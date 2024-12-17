import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../../')))
from datetime import datetime
import unittest
from unittest.mock import patch, MagicMock
from flask import Flask, session
from app.controllers.checkoutCtrl import validate_checkout, process_order, apply_coupon, process_payment
from app.models import Order, OrderProducts, Delivery, Address, Coupon, Product

app = Flask(__name__)
app.config['SECRET_KEY'] = 'test_secret_key'

class TestCheckoutCtrl(unittest.TestCase):

    @patch('app.controllers.checkoutCtrl.get_cart_items')
    def test_validate_checkout_empty_cart(self, mock_get_cart_items):
        mock_get_cart_items.return_value = {}
        result, data = validate_checkout()
        self.assertFalse(result)
        self.assertIsNone(data)

    @patch('app.controllers.checkoutCtrl.get_cart_items')
    def test_validate_checkout_with_items(self, mock_get_cart_items):
        mock_get_cart_items.return_value = {
            1: {'price': 10.0, 'quantity': 2},
            2: {'price': 20.0, 'quantity': 1}
        }
        result, data = validate_checkout()
        self.assertTrue(result)
        self.assertEqual(data['total'], 40.0)

    @patch('app.controllers.checkoutCtrl.get_cart_items')
    @patch('app.controllers.checkoutCtrl.db.session')
    @patch('app.controllers.checkoutCtrl.Product')
    @patch('app.controllers.checkoutCtrl.Order')
    @patch('app.controllers.checkoutCtrl.OrderProducts')
    @patch('app.controllers.checkoutCtrl.Address')
    @patch('app.controllers.checkoutCtrl.Delivery')
    @patch('app.controllers.checkoutCtrl.current_user')
    def test_process_order(self, mock_current_user, mock_delivery, mock_address, mock_order_products, mock_order, mock_product, mock_db_session, mock_get_cart_items):
        with app.test_request_context():
            mock_current_user.idClient = 1
            mock_get_cart_items.return_value = {
                1: {'price': 10.0, 'quantity': 2},
                2: {'price': 20.0, 'quantity': 1}
            }
            form_data = {
                'delivery_option': 'standard',
                'city': 'Test City',
                'country': 'Test Country',
                'zipCode': '12345',
                'address': 'Test Address'
            }

            mock_address.return_value.city = 'Test City'

            result = process_order(form_data)

            self.assertIsNotNone(result)
            self.assertEqual(result['total'], 40.0)
            self.assertEqual(result['address']['city'], 'Test City')
            mock_db_session.commit.assert_called_once()

    @patch('app.controllers.checkoutCtrl.Coupon')
    def test_apply_coupon_invalid(self, mock_coupon):
        mock_coupon.query.get.return_value = None
        result, message = apply_coupon('INVALID')
        self.assertFalse(result)
        self.assertEqual(message, "Invalid coupon code")

    @patch('app.controllers.checkoutCtrl.Coupon')
    def test_apply_coupon_expired(self, mock_coupon):
        mock_coupon.query.get.return_value = MagicMock(expiration_date=datetime(2020, 1, 1))
        result, message = apply_coupon('EXPIRED')
        self.assertFalse(result)
        self.assertEqual(message, "Coupon has expired")

    @patch('app.controllers.checkoutCtrl.Coupon')
    def test_apply_coupon_valid(self, mock_coupon):
        mock_coupon.query.get.return_value = MagicMock(expiration_date=datetime(2025, 1, 1), value=10)
        result, value = apply_coupon('VALID')
        self.assertTrue(result)
        self.assertEqual(value, 10)

    def test_process_payment_cash(self):
        result = process_payment('cash', {})
        self.assertTrue(result)

    def test_process_payment_card(self):
        result = process_payment('card', {'card_number': '1234-5678-9876-5432'})
        self.assertTrue(result)

    def test_process_payment_invalid_method(self):
        result = process_payment('bitcoin', {})
        self.assertFalse(result)

if __name__ == '__main__':
    unittest.main(verbosity=2)