import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
import unittest
from datetime import date
from flask import session
from flask_testing import TestCase
from app import create_app
from app.extensions import db
from app.models import Client
from app.controllers.cartCtrl import add_product_to_cart, get_cart_items, clear_cart


class CartTestCase(TestCase):
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
                creationDate=date(2024, 10, 31),
                is_admin=False
            )
            db.session.add(self.client_user)
            db.session.commit()

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_add_to_cart_success(self):
        """Test adding a single item to the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login by posting login request to the correct route
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',  # Ensure the password is correct
            'action': 'login'  # Include action to specify login
        })

        # Ensure login was successful (expecting a redirection to home page)
        self.assertEqual(response.status_code, 302)
        self.assertRedirects(response, '/')

        # Prepare test data
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }

        # Send POST request to add product to cart
        response = self.client.post('/cart/add_to_cart', data=form_data)
        self.assertEqual(response.status_code, 302)  # 302 is the status code for redirection

        # Check if cart contains the added product
        with self.client.session_transaction() as sess:
            cart_key = f'cart_{self.client_user.idClient}'
            self.assertIn(cart_key, sess)
            self.assertIn('1', sess[cart_key])
            self.assertEqual(sess[cart_key]['1']['name'], 'NVIDIA RTX 2080')
            self.assertEqual(sess[cart_key]['1']['price'], 1890000.0)
            self.assertEqual(sess[cart_key]['1']['quantity'], 1)
            self.assertEqual(sess[cart_key]['1']['image'], 'palit rtx.jpg')

if __name__ == "__main__":
    unittest.main()
