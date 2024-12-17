import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../../')))

import unittest
from unittest.mock import patch, MagicMock
from flask import session, Flask
from app.controllers.cartCtrl import get_cart_items, add_product_to_cart, remove_product_from_cart, clear_cart, update_product_quantity_in_cart
from app.models import Product, Cart

app = Flask(__name__)
app.config['SECRET_KEY'] = 'test_secret_key'

class TestCartCtrl(unittest.TestCase):

    @patch('app.controllers.cartCtrl.current_user')
    @patch('app.controllers.cartCtrl.Cart')
    @patch('app.controllers.cartCtrl.Product')
    def test_get_cart_items(self, mock_product, mock_cart, mock_current_user):
        mock_current_user.is_authenticated = True
        mock_current_user.idClient = 1
        mock_cart.query.filter_by.return_value.all.return_value = [
            MagicMock(idProduct=1, quantity=2),
            MagicMock(idProduct=2, quantity=1)
        ]
        mock_product.query.get.side_effect = lambda id: MagicMock(
            name_prod=f'Product{id}', price=10.0, img_prod=f'img{id}', stock=5
        )

        cart_items = get_cart_items()

        self.assertEqual(len(cart_items), 2)
        self.assertEqual(cart_items[1]['name'], 'Product1')
        self.assertEqual(cart_items[2]['name'], 'Product2')

    @patch('app.controllers.cartCtrl.current_user')
    @patch('app.controllers.cartCtrl.db.session')
    @patch('app.controllers.cartCtrl.Cart')
    @patch('app.controllers.cartCtrl.Product')
    def test_add_product_to_cart(self, mock_product, mock_cart, mock_db_session, mock_current_user):
        with app.test_request_context():
            mock_current_user.is_authenticated = True
            mock_current_user.idClient = 1
            mock_product.query.get.return_value = MagicMock(stock=10)
            mock_cart.query.filter_by.return_value.first.return_value = None

            add_product_to_cart(1, 'Product1', 10.0, 2, 'img1')

            mock_db_session.add.assert_called_once()
            mock_db_session.commit.assert_called_once()

    @patch('app.controllers.cartCtrl.current_user')
    @patch('app.controllers.cartCtrl.db.session')
    @patch('app.controllers.cartCtrl.Cart')
    def test_remove_product_from_cart(self, mock_cart, mock_db_session, mock_current_user):
        mock_current_user.is_authenticated = True
        mock_current_user.idClient = 1
        mock_cart.query.filter_by.return_value.first.return_value = MagicMock()

        remove_product_from_cart(1)

        mock_db_session.delete.assert_called_once()
        mock_db_session.commit.assert_called_once()

    @patch('app.controllers.cartCtrl.current_user')
    @patch('app.controllers.cartCtrl.db.session')
    @patch('app.controllers.cartCtrl.Cart')
    def test_clear_cart(self, mock_cart, mock_db_session, mock_current_user):
        with app.test_request_context():
            mock_current_user.is_authenticated = True
            mock_current_user.idClient = 1

            clear_cart()

            mock_cart.query.filter_by.return_value.delete.assert_called_once()
            mock_db_session.commit.assert_called_once()

    @patch('app.controllers.cartCtrl.current_user')
    @patch('app.controllers.cartCtrl.db.session')
    @patch('app.controllers.cartCtrl.Cart')
    @patch('app.controllers.cartCtrl.Product')
    def test_update_product_quantity_in_cart(self, mock_product, mock_cart, mock_db_session, mock_current_user):
        mock_current_user.is_authenticated = True
        mock_current_user.idClient = 1
        mock_product.query.get.return_value = MagicMock(stock=10)
        mock_cart.query.filter_by.return_value.first.return_value = MagicMock()

        update_product_quantity_in_cart(1, 5)

        mock_db_session.commit.assert_called_once()

if __name__ == '__main__':
    unittest.main(verbosity=2)