import sys
import os
import io
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../..')))
import unittest
from datetime import datetime
from flask_testing import TestCase
from flask_login import current_user
from app import create_app
from app.extensions import db
from app.models import Admin, Category, Product, Catalog

class AdminCrudTestCase(TestCase):
    def create_app(self):
        """Set up the Flask test client"""
        self.app = create_app()
        self.app.config['TESTING'] = True
        self.app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
        return self.app

    def setUp(self):
        """Set up the Flask test client"""
        print("Setting up the test environment")
        self.client = self.app.test_client()  # Initialize the test client
        with self.app.app_context():
            db.create_all()
            self.admin_user = Admin(
                idAdmin=2,
                firstName='bee',
                lastName='bee',
                email='admin2@gmail.com',
                password='admin2'
            )
            db.session.add(self.admin_user)
            db.session.commit()
            db.session.refresh(self.admin_user)  # Ensure the instance is managed by the session
            print("Admin user created and committed to the database")

            self.category = Category(
                idCategory=1,
                description_cat='Graphics Cards',
                idCatalog=1
            )
            db.session.add(self.category)
            db.session.commit()
            print("Category created and committed to the database")

            self.product = Product(
                idProduct=1,
                name_prod='NVIDIA RTX 2080',
                description_prod='High performance graphics card.',
                price=1890000.0,
                stock=10,
                img_prod='palit rtx.jpg',
                idCategory=1,
                brand=6
            )
            db.session.add(self.product)
            db.session.commit()
            print("Product created and committed to the database")

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_add_category(self):
        """Test adding a category"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Add category
            form_data = {
                'category_name': 'Laptops',
                'catalog_id': '1'
            }
            response = self.client.post('/admin/add_category', data=form_data)
            print(f"Add category response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after adding category

            # Check if category is added
            with self.app.app_context():
                category = Category.query.filter_by(description_cat='Laptops').first()
                print(f"Category added: {category}")
                self.assertIsNotNone(category)
                self.assertEqual(category.description_cat, 'Laptops')

    def test_add_product(self):
        """Test adding a product"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Add product
            form_data = {
                'name_prod': 'Laptop',
                'description_prod': 'High performance laptop',
                'price': '1000.0',
                'promo': '10',
                'stock': '50',
                'idCategory': '1',
                'brand': 'BrandX',
                'img_prod': (io.BytesIO(b"fake image data"), 'laptop.jpg')
            }
            response = self.client.post('/admin/add_product', data=form_data, content_type='multipart/form-data')
            print(f"Add product response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after adding product

            # Check if product is added
            with self.app.app_context():
                product = Product.query.filter_by(name_prod='Laptop').first()
                print(f"Product added: {product}")
                self.assertIsNotNone(product)
                self.assertEqual(product.name_prod, 'Laptop')

    def test_delete_product(self):
        """Test deleting a product"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

                # Refresh the product instance to ensure it is managed by the session
                self.product = db.session.query(Product).filter_by(idProduct=1).first()
                db.session.refresh(self.product)

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Delete product
            response = self.client.post(f'/admin/delete_product/{self.product.idProduct}')
            print(f"Delete product response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after deleting product

            # Check if product is deleted
            with self.app.app_context():
                deleted_product = Product.query.filter_by(idProduct=self.product.idProduct).first()
                print(f"Product deleted: {deleted_product}")
                self.assertIsNone(deleted_product)

    def test_delete_category(self):
        """Test deleting a category"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

                # Refresh the category instance to ensure it is managed by the session
                self.category = db.session.query(Category).filter_by(idCategory=1).first()
                db.session.refresh(self.category)

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Delete category
            response = self.client.post(f'/admin/delete_category/{self.category.idCategory}')
            print(f"Delete category response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after deleting category

            # Check if category is deleted
            with self.app.app_context():
                deleted_category = Category.query.filter_by(idCategory=self.category.idCategory).first()
                print(f"Category deleted: {deleted_category}")
                self.assertIsNone(deleted_category)

    def test_edit_product(self):
        """Test editing a product"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

                # Refresh the product instance to ensure it is managed by the session
                self.product = db.session.query(Product).filter_by(idProduct=1).first()
                db.session.refresh(self.product)

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Edit product
            form_data = {
                'name_prod': 'Updated Laptop',
                'description_prod': 'Updated high performance laptop',
                'price': '1200.0',
                'promo': '15',
                'stock': '30',
                'idCategory': '1',
                'brand': 'UpdatedBrand',
                'img_prod': (io.BytesIO(b"updated fake image data"), 'updated_laptop.jpg')
            }
            response = self.client.post(f'/admin/edit_product/{self.product.idProduct}', data=form_data, content_type='multipart/form-data')
            print(f"Edit product response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after editing product

            # Check if product is edited
            with self.app.app_context():
                edited_product = Product.query.filter_by(idProduct=self.product.idProduct).first()
                print(f"Product edited: {edited_product}")
                self.assertIsNotNone(edited_product)
                self.assertEqual(edited_product.name_prod, 'Updated Laptop')
                self.assertEqual(edited_product.description_prod, 'Updated high performance laptop')
                self.assertEqual(edited_product.price, 1200.0)
                self.assertEqual(edited_product.promo, 15)
                self.assertEqual(edited_product.stock, 30)
                self.assertEqual(edited_product.brand, 'UpdatedBrand')

    def test_edit_category(self):
        """Test editing a category"""
        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

                # Refresh the category instance to ensure it is managed by the session
                self.category = db.session.query(Category).filter_by(idCategory=1).first()
                db.session.refresh(self.category)

            # Simulate login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',
                'action': 'login'
            })
            print(f"Login response status code: {response.status_code}")

            # Edit category
            form_data = {
                'category_name': 'Updated Graphics Cards',
                'catalog_id': '1'
            }
            response = self.client.post(f'/admin/edit_category/{self.category.idCategory}', data=form_data)
            print(f"Edit category response status code: {response.status_code}")
            self.assertEqual(response.status_code, 302)  # Redirect after editing category

            # Check if category is edited
            with self.app.app_context():
                edited_category = Category.query.filter_by(idCategory=self.category.idCategory).first()
                print(f"Category edited: {edited_category}")
                self.assertIsNotNone(edited_category)
                self.assertEqual(edited_category.description_cat, 'Updated Graphics Cards')

if __name__ == "__main__":
    unittest.main(verbosity=2)