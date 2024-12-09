import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
import unittest
from datetime import datetime
from flask_testing import TestCase
from flask_login import current_user
from app import create_app
from app.extensions import db
from app.models import Client, Product
from app.controllers.cartCtrl import add_product_to_cart
from app.controllers.checkoutCtrl import validate_checkout, process_order

class CheckoutTestCase(TestCase):
    def create_app(self):
        """Set up the Flask test client"""
        self.app = create_app()
        self.app.config['TESTING'] = True
        self.app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
        return self.app

    def setUp(self):
        """Set up the Flask test client"""
        with self.app.app_context():
            db.create_all()
            self.client_user = Client(
                idClient=12,
                lastName='a',
                firstName='a',
                email='a@a',
                password='a',
                phone='1',
                user_img='NULL',
                creationDate=datetime(2024, 10, 31),
                is_admin=False
            )
            db.session.add(self.client_user)
            db.session.commit()

            self.product = Product(
                idProduct=1,
                name_prod='NVIDIA RTX 2080',
                description_prod='Card đồ họa hiệu suất cao.',
                price=1890000.0,
                stock=10,
                img_prod='palit rtx.jpg',
                idCategory=1,  # Provide a valid idCategory value
                brand=6  # Provide a valid brand value
            )
            db.session.add(self.product)
            db.session.commit()

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_checkout_page(self):
        """Test accessing the checkout page"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data)

        # Access checkout page
        response = self.client.get('/checkout/')
        self.assertEqual(response.status_code, 200)
        self.assert_template_used('checkout.html')

    def test_process_checkout(self):
        """Test processing a checkout"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data)

        # Process checkout
        checkout_data = {
            'delivery_option': 'standard',
            'city': 'Test City',
            'country': 'Test Country',
            'zipCode': '12345',
            'address': '123 Test St'
        }
        response = self.client.post('/checkout/process_checkout', data=checkout_data)
        self.assertEqual(response.status_code, 200)
        self.assert_template_used('receipt.html')

if __name__ == "__main__":
    unittest.main()