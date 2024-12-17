import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..', '..')))
import unittest
from datetime import datetime
from flask_testing import TestCase
from flask_login import current_user
from app import create_app
from app.extensions import db
from app.models import Client, Product, Cart
from app.controllers.cartCtrl import add_product_to_cart, remove_product_from_cart, clear_cart, update_product_quantity_in_cart


class CartTestCase(TestCase):
    def create_app(self):
        """Set up the Flask test client"""
        self.app = create_app()
        self.app.config['TESTING'] = True
        self.app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
        return self.app

    def setUp(self):
        """Set up the Flask test client"""
        self.client = self.app.test_client()  # Initialize the test client
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

            self.product1 = Product(
                idProduct=1,
                name_prod='NVIDIA RTX 2080',
                description_prod='Card đồ họa hiệu suất cao.',
                price=1890000.0,
                stock=10,
                img_prod='palit rtx.jpg',
                idCategory=1,  # Provide a valid idCategory value
                brand=6  # Provide a valid brand value
            )
            db.session.add(self.product1)

            self.product2 = Product(
                idProduct=2,
                name_prod='AMD Ryzen 9 5900X',
                description_prod='High-performance CPU.',
                price=499000.0,
                stock=5,
                img_prod='ryzen_9.jpg',
                idCategory=2,  # Provide a valid idCategory value
                brand=7  # Provide a valid brand value
            )
            db.session.add(self.product2)
            db.session.commit()

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_add_to_cart(self):
        """Test adding a product to the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })
        print(f"Login response status code: {response.status_code}")

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        response = self.client.post('/cart/add_to_cart', data=form_data)
        print(f"Add to cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after adding to cart

        # Debug: Check cart contents
        cart_items = Cart.query.filter_by(idClient=self.client_user.idClient).all()
        print(f"Cart items after adding product: {cart_items}")

        # Check if item is in cart
        cart_item = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f"Cart item: {cart_item}")
        self.assertIsNotNone(cart_item)
        self.assertEqual(cart_item.quantity, 1)

    def test_remove_from_cart(self):
        """Test removing a product from the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })
        print(f"Login response status code: {response.status_code}")

        # Add item to cart via the client POST request
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        response = self.client.post('/cart/add_to_cart', data=form_data)
        print(f"Add to cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after adding to cart

        # Debug: Check if item was added to cart
        cart_item_added = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f"Cart item added: {cart_item_added}")

        # Remove item from cart
        response = self.client.post('/cart/remove_from_cart/1')
        print(f"Remove from cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after removing from cart

        # Check if item is removed from cart
        cart_item = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f"Cart item after removal: {cart_item}")
        self.assertIsNone(cart_item)

    def test_add_multiple_items_to_cart(self):
        """Test adding multiple products to the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })
        print(f"Login response status code: {response.status_code}")

        # Add first item to cart
        form_data_1 = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        response_1 = self.client.post('/cart/add_to_cart', data=form_data_1)
        print(f"Add to cart response status code (product 1): {response_1.status_code}")
        self.assertEqual(response_1.status_code, 302)  # Redirect after adding to cart

        # Add second item to cart
        form_data_2 = {
            'product_id': '2',
            'product_name': 'AMD Ryzen 9 5900X',
            'product_price': '499000.0',
            'product_image': 'ryzen_9.jpg',
            'quantity': '1'
        }
        response_2 = self.client.post('/cart/add_to_cart', data=form_data_2)
        print(f"Add to cart response status code (product 2): {response_2.status_code}")
        self.assertEqual(response_2.status_code, 302)  # Redirect after adding to cart

        # Debug: Check cart contents
        cart_items = Cart.query.filter_by(idClient=self.client_user.idClient).all()
        print(f"Cart items after adding multiple products: {cart_items}")

        # Check if both items are in cart
        cart_item_1 = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        cart_item_2 = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=2).first()
        print(f"Cart item 1: {cart_item_1}")
        print(f"Cart item 2: {cart_item_2}")
        self.assertIsNotNone(cart_item_1)
        self.assertEqual(cart_item_1.quantity, 1)
        self.assertIsNotNone(cart_item_2)
        self.assertEqual(cart_item_2.quantity, 1)

    def test_update_quantity_in_cart(self):
        """Test updating the quantity of a product in the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })
        print(f"Login response status code: {response.status_code}")

        # Add item to cart via the client POST request
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        response = self.client.post('/cart/add_to_cart', data=form_data)
        print(f"Add to cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after adding to cart

        # Check if item is in cart before update
        cart_item_before = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f'Cart item before update: {cart_item_before}')
        self.assertIsNotNone(cart_item_before)
        self.assertEqual(cart_item_before.quantity, 1)

        # Update quantity in cart
        update_data = {
            'product_id': 1,
            'quantity': 5
        }
        response = self.client.post('/cart/update_quantity', json=update_data)
        print(f"Update quantity response status code: {response.status_code}")
        self.assertEqual(response.status_code, 204)  # No Content after updating quantity

        # Check if quantity is updated
        cart_item_after = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f'Cart item after update: {cart_item_after}')
        self.assertIsNotNone(cart_item_after)
        self.assertEqual(cart_item_after.quantity, 5)

    def test_clear_cart(self):
        """Test clearing the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        response = self.client.post('/auth/', data={
            'email': self.client_user.email,
            'password': 'a',
            'action': 'login'
        })
        print(f"Login response status code: {response.status_code}")

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        response = self.client.post('/cart/add_to_cart', data=form_data)
        print(f"Add to cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after adding to cart

        # Debug: Check if item was added to cart
        cart_item_added = Cart.query.filter_by(idClient=self.client_user.idClient, idProduct=1).first()
        print(f"Cart item added: {cart_item_added}")
        self.assertIsNotNone(cart_item_added)

        # Clear cart
        response = self.client.post('/cart/delete_cart')
        print(f"Clear cart response status code: {response.status_code}")
        self.assertEqual(response.status_code, 302)  # Redirect after clearing cart

        # Check if cart is empty
        cart_items = Cart.query.filter_by(idClient=self.client_user.idClient).all()
        print(f"Cart items after clearing cart: {cart_items}")
        self.assertEqual(len(cart_items), 0)


if __name__ == "__main__":
    unittest.main(verbosity=2)