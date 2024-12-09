import sys
import os
import io
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
import unittest
from datetime import datetime, date
from flask_testing import TestCase
from flask_login import current_user
from app import create_app
from app.extensions import db
from app.models import Admin, Client, Product, Category

class AdminRouteTestCase(TestCase):
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
            self.admin_user = Admin(
                idAdmin=2,
                firstName='bee',
                lastName='bee',
                email='admin2@gmail.com',
                password='admin2'
            )
            db.session.add(self.admin_user)
            db.session.commit()

            self.category = Category(
                idCategory=1,
                description_cat='Graphics Cards',
                idCatalog=1
            )
            db.session.add(self.category)
            db.session.commit()

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

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_add_category(self):
        """Test adding a category"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })
            
            response = self.client.post('/admin/add_category', data={
                'category_name': 'Processors',
                'catalog_id': 1
            })
            
            self.assertEqual(response.status_code, 302)
            category = Category.query.filter_by(description_cat='Processors').first()
            self.assertIsNotNone(category)

    def test_delete_category(self):
        """Test deleting a category"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })
            
            # Add a category to delete
            self.client.post('/admin/add_category', data={
                'category_name': 'Processors',
                'catalog_id': 1
            })
            
            category = Category.query.filter_by(description_cat='Processors').first()
            self.assertIsNotNone(category)

            # Delete the category
            response = self.client.post(f'/admin/delete_category/{category.idCategory}')
            
            self.assertEqual(response.status_code, 302)
            category = Category.query.filter_by(description_cat='Processors').first()
            self.assertIsNone(category)

    def test_update_category(self):
        """Test updating a category"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })
            
            # Add a category to update
            self.client.post('/admin/add_category', data={
                'category_name': 'Processors',
                'catalog_id': 1
            })
            
            category = Category.query.filter_by(description_cat='Processors').first()
            self.assertIsNotNone(category)

            # Update the category
            response = self.client.post(f'/admin/edit_category/{category.idCategory}', data={
                'category_name': 'Updated Processors',
                'catalog_id': 1
            })
            
            self.assertEqual(response.status_code, 302)
            updated_category = Category.query.filter_by(idCategory=category.idCategory).first()
            self.assertIsNotNone(updated_category)
            self.assertEqual(updated_category.description_cat, 'Updated Processors')

    def test_add_product(self):
        """Test adding a product"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })

            # Include the file in the data parameter
            data = {
                'name_prod': 'Intel i9',
                'description_prod': 'High performance processor.',
                'price': 500000.0,
                'stock': 15,
                'idCategory': 1,
                'brand': 1,
                'img_prod': (io.BytesIO(b"fake image data"), 'intel_i9.jpg')
            }

            response = self.client.post('/admin/add_product', data=data, content_type='multipart/form-data')

            self.assertEqual(response.status_code, 302)
            product = Product.query.filter_by(name_prod='Intel i9').first()
            self.assertIsNotNone(product)

    def test_delete_product(self):
        """Test deleting a product"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })

            # Add a product to delete
            self.client.post('/admin/add_product', data={
                'name_prod': 'Intel i9',
                'description_prod': 'High performance processor.',
                'price': 500000.0,
                'stock': 15,
                'idCategory': 1,
                'brand': 1,
                'img_prod': (io.BytesIO(b"fake image data"), 'intel_i9.jpg')
            }, content_type='multipart/form-data')

            product = Product.query.filter_by(name_prod='Intel i9').first()
            self.assertIsNotNone(product)

            # Delete the product
            response = self.client.post(f'/admin/delete_product/{product.idProduct}')
            
            self.assertEqual(response.status_code, 302)
            product = Product.query.filter_by(name_prod='Intel i9').first()
            self.assertIsNone(product)

    def test_update_product(self):
        """Test updating a product"""
        with self.app.app_context():
            # Ensure the admin_user is attached to the session
            self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            # db.session.refresh(self.admin_user)  # Reload the admin_user to avoid detached instance

            self.client.post('/auth/', data={
                'email': self.admin_user.email,
                'password': 'admin2',  # Ensure this is the correct password
                'action': 'login'
            })

            # Add a product to update
            self.client.post('/admin/add_product', data={
                'name_prod': 'Intel i9',
                'description_prod': 'High performance processor.',
                'price': 500000.0,
                'stock': 15,
                'idCategory': 1,
                'brand': 1,
                'img_prod': (io.BytesIO(b"fake image data"), 'intel_i9.jpg')
            }, content_type='multipart/form-data')

            product = Product.query.filter_by(name_prod='Intel i9').first()
            self.assertIsNotNone(product)

            # Update the product
            response = self.client.post(f'/admin/edit_product/{product.idProduct}', data={
                'name_prod': 'Intel i9 Updated',
                'description_prod': 'Updated high performance processor.',
                'price': 600000.0,
                'stock': 20,
                'idCategory': 1,
                'brand': 1,
                'img_prod': (io.BytesIO(b"updated fake image data"), 'intel_i9_updated.jpg')
            }, content_type='multipart/form-data')
            
            self.assertEqual(response.status_code, 302)
            updated_product = Product.query.filter_by(idProduct=product.idProduct).first()
            self.assertIsNotNone(updated_product)
            self.assertEqual(updated_product.name_prod, 'Intel i9 Updated')
            self.assertEqual(updated_product.description_prod, 'Updated high performance processor.')
            self.assertEqual(updated_product.price, 600000.0)
            self.assertEqual(updated_product.stock, 20)

if __name__ == "__main__":
    unittest.main()