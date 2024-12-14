import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
import unittest
from datetime import date
from flask import session
from flask_testing import TestCase
from app import create_app
from app.extensions import db
from app.models import Client, Product, Cart, Category
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
            self.category = Category(
                idCategory=1,
                description_cat='Graphics Cards',
                idCatalog=1
            )
            self.product = Product(
                idProduct=1,
                name_prod='NVIDIA RTX 2080',
                description_prod='High-end graphics card',
                price=1890000.0,
                img_prod='palit rtx.jpg',
                stock=10,
                idCategory=1,
                brand=1
            )
            db.session.add(self.client_user)
            db.session.add(self.category)
            db.session.add(self.product)
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

        # Simulate login by setting the current_user
        with self.client.session_transaction() as sess:
            sess['_user_id'] = self.client_user.idClient

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

        # Debug: Check if the product was added to the cart
        with self.app.app_context():
            cart_items = get_cart_items()
            print("Cart items after adding product:", cart_items)  # Debug statement
            self.assertIn('1', cart_items)
            self.assertEqual(cart_items['1']['name'], 'NVIDIA RTX 2080')
            self.assertEqual(cart_items['1']['price'], 1890000.0)
            self.assertEqual(cart_items['1']['quantity'], 1)
            self.assertEqual(cart_items['1']['image'], 'palit rtx.jpg')

    def test_add_multiple_items_to_cart(self):
        """Test adding multiple items to the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()
            product2 = Product(
                idProduct=2,
                name_prod='Gaming PC - AMD Ryzen 9',
                description_prod='High-performance gaming PC',
                price=900000.0,
                img_prod='amd2.png',
                stock=5,
                idCategory=1,
                brand=1
            )
            db.session.add(product2)
            db.session.commit()

        # Simulate login
        with self.client.session_transaction() as sess:
            sess['_user_id'] = self.client_user.idClient

        # Add first item
        form_data_1 = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data_1)

        # Add second item
        form_data_2 = {
            'product_id': '2',
            'product_name': 'Gaming PC - AMD Ryzen 9',
            'product_price': '900000.0',
            'product_image': 'amd2.png',
            'quantity': '2'
        }
        self.client.post('/cart/add_to_cart', data=form_data_2)

        # Check if cart contains both items
        with self.app.app_context():
            cart_items = get_cart_items()
            self.assertIn('1', cart_items)
            self.assertIn('2', cart_items)
            self.assertEqual(cart_items['1']['name'], 'NVIDIA RTX 2080')
            self.assertEqual(cart_items['2']['name'], 'Gaming PC - AMD Ryzen 9')

    def test_remove_item_from_cart(self):
        """Test removing an item from the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        with self.client.session_transaction() as sess:
            sess['_user_id'] = self.client_user.idClient

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data)

        # Remove item from cart
        self.client.post('/cart/remove_from_cart/1')

        # Check if cart is empty
        with self.app.app_context():
            cart_items = get_cart_items()
            self.assertNotIn('1', cart_items)

    def test_clear_cart(self):
        """Test clearing the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        with self.client.session_transaction() as sess:
            sess['_user_id'] = self.client_user.idClient

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data)

        # Clear cart
        self.client.post('/cart/delete_cart')

        # Check if cart is empty
        with self.app.app_context():
            cart_items = get_cart_items()
            self.assertEqual(cart_items, {})

    def test_update_item_quantity_in_cart(self):
        """Test updating the quantity of an item in the cart"""
        with self.app.app_context():
            self.client_user = db.session.query(Client).filter_by(idClient=12).first()

        # Simulate login
        with self.client.session_transaction() as sess:
            sess['_user_id'] = self.client_user.idClient

        # Add item to cart
        form_data = {
            'product_id': '1',
            'product_name': 'NVIDIA RTX 2080',
            'product_price': '1890000.0',
            'product_image': 'palit rtx.jpg',
            'quantity': '1'
        }
        self.client.post('/cart/add_to_cart', data=form_data)

        # Update item quantity
        update_data = {
            'product_id': '1',
            'quantity': '3'
        }
        self.client.post('/cart/update_quantity', json=update_data)

        # Check if item quantity is updated
        with self.app.app_context():
            cart_items = get_cart_items()
            self.assertEqual(cart_items['1']['quantity'], 3)

if __name__ == "__main__":
    unittest.main()