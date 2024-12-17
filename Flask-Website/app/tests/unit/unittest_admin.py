import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../../')))

import unittest
from unittest.mock import patch, MagicMock
from flask import Flask
from app.controllers.admin_controller import fetch_all_products, add_product, update_product, delete_product
from app.models import Product, Admin

app = Flask(__name__)
app.config['SECRET_KEY'] = 'test_secret_key'

class TestAdminController(unittest.TestCase):

    @patch('app.controllers.admin_controller.Product')
    def test_fetch_all_products(self, mock_product):
        # Simulating the return of two products from the database
        mock_product.query.all.return_value = [MagicMock(idProduct=1, name_prod='Product1'), MagicMock(idProduct=2, name_prod='Product2')]

        result = fetch_all_products()
        self.assertEqual(len(result), 2)
        self.assertEqual(result[0].name_prod, 'Product1')
        self.assertEqual(result[1].name_prod, 'Product2')

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_add_product_not_admin(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as not authenticated or not an admin
        mock_current_user.is_authenticated = False

        # Call the add_product function
        result, message = add_product('Product1', 'Description1', 10.0, 0, 100, 1, 'Brand1', 'img1.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'User is not an admin.')
        
        # Verify that session add and commit methods were not called
        mock_db_session.add.assert_not_called()
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_add_product_already_exists(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock that the product already exists
        mock_product.query.filter_by.return_value.first.return_value = MagicMock()

        # Call the add_product function
        result, message = add_product('Product1', 'Description1', 10.0, 0, 100, 1, 'Brand1', 'img1.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Product already exists.')
        
        # Verify that session add and commit methods were not called
        mock_db_session.add.assert_not_called()
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_add_product_missing_image(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock that the product doesn't already exist
        mock_product.query.filter_by.return_value.first.return_value = None

        # Call the add_product function without image
        result, message = add_product('Product1', 'Description1', 10.0, 0, 100, 1, 'Brand1', None)
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Missing product image.')
        
        # Verify that session add and commit methods were not called
        mock_db_session.add.assert_not_called()
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_add_product_missing_information(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock that the product doesn't already exist
        mock_product.query.filter_by.return_value.first.return_value = None

        # Call the add_product function with missing information
        result, message = add_product(None, 'Description1', 10.0, 0, 100, 1, 'Brand1', 'img1.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Missing product information.')
        
        # Verify that session add and commit methods were not called
        mock_db_session.add.assert_not_called()
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_add_product_success(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock that the product doesn't already exist
        mock_product.query.filter_by.return_value.first.return_value = None

        # Call the add_product function
        result, message = add_product('Product1', 'Description1', 10.0, 0, 100, 1, 'Brand1', 'img1.jpg')
        
        # Assertions to verify the correct behavior
        self.assertTrue(result)
        self.assertEqual(message, 'Product added successfully.')
        
        # Verify that session add and commit methods were called
        mock_db_session.add.assert_called_once()
        mock_db_session.commit.assert_called_once()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_update_product_not_admin(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as not authenticated or not an admin
        mock_current_user.is_authenticated = False

        # Call the update_product function
        result, message = update_product(1, 'UpdatedProduct', 'UpdatedDescription', 20.0, 1, 200, 1, 'UpdatedBrand', 'updated_img.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'User is not an admin.')
        
        # Verify that session commit method was not called
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_update_product_not_found(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock not finding a product by ID
        mock_product.query.get.return_value = None

        # Call the update_product function
        result, message = update_product(1, 'UpdatedProduct', 'UpdatedDescription', 20.0, 1, 200, 1, 'UpdatedBrand', 'updated_img.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Product not found.')
        
        # Verify that session commit method was not called
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_update_product_missing_image(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock getting an existing product by ID
        mock_product.query.get.return_value = MagicMock(idProduct=1, name_prod='Product1')

        # Call the update_product function without image
        result, message = update_product(1, 'UpdatedProduct', 'UpdatedDescription', 20.0, 1, 200, 1, 'UpdatedBrand', None)
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Missing product image.')
        
        # Verify that session commit method was not called
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_update_product_missing_information(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock getting an existing product by ID
        mock_product.query.get.return_value = MagicMock(idProduct=1, name_prod='Product1')

        # Call the update_product function with missing information
        result, message = update_product(1, None, 'UpdatedDescription', 20.0, 1, 200, 1, 'UpdatedBrand', 'updated_img.jpg')
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Missing product information.')
        
        # Verify that session commit method was not called
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_update_product_success(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock getting an existing product by ID
        mock_product.query.get.return_value = MagicMock(idProduct=1, name_prod='Product1')

        # Call the update_product function
        result, message = update_product(1, 'UpdatedProduct', 'UpdatedDescription', 20.0, 1, 200, 1, 'UpdatedBrand', 'updated_img.jpg')
        
        # Assertions to verify the correct behavior
        self.assertTrue(result)
        self.assertEqual(message, 'Product updated successfully.')
        
        # Verify that session commit method was called
        mock_db_session.commit.assert_called_once()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_delete_product_not_admin(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as not authenticated or not an admin
        mock_current_user.is_authenticated = False

        # Call the delete_product function
        result, message = delete_product(1)
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'User is not an admin.')
        
        # Verify that session delete and commit methods were not called
        mock_db_session.delete.assert_not_called()
        mock_db_session.commit.assert_not_called()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_delete_product_success(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock getting an existing product by ID
        mock_product.query.get.return_value = MagicMock(idProduct=1, name_prod='Product1')

        # Call the delete_product function
        result, message = delete_product(1)
        
        # Assertions to verify the correct behavior
        self.assertTrue(result)
        self.assertEqual(message, 'Product has been deleted successfully.')
        
        # Verify that session delete and commit methods were called
        mock_db_session.delete.assert_called_once()
        mock_db_session.commit.assert_called_once()

    @patch('app.controllers.admin_controller.db.session')
    @patch('app.controllers.admin_controller.Product')
    @patch('app.controllers.admin_controller.current_user')
    def test_delete_product_not_found(self, mock_current_user, mock_product, mock_db_session):
        # Mock current_user as an authenticated admin
        mock_current_user.is_authenticated = True
        mock_current_user.__class__ = Admin  # Ensure current_user is an instance of Admin
        
        # Mock not finding a product by ID
        mock_product.query.get.return_value = None

        # Call the delete_product function
        result, message = delete_product(1)
        
        # Assertions to verify the correct behavior
        self.assertFalse(result)
        self.assertEqual(message, 'Product not found.')
        
        # Verify that session delete and commit methods were not called
        mock_db_session.delete.assert_not_called()
        mock_db_session.commit.assert_not_called()

if __name__ == '__main__':
    unittest.main(verbosity=2)