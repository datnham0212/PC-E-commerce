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
        """Set up the test environment"""
        self.client = self.app.test_client()
        with self.app.app_context():
            db.create_all()
            # Create admin user
            admin_user = Admin(
                idAdmin=2,
                firstName='bee',
                lastName='bee',
                email='admin2@gmail.com',
                password='admin2'
            )
            db.session.add(admin_user)
            db.session.commit()
            self.admin_user = db.session.query(Admin).filter_by(email='admin2@gmail.com').first()  # Refetch to attach

            # Create valid category
            self.category = Category(
                idCategory=1,
                description_cat='Electronics',
                idCatalog=1
            )
            db.session.add(self.category)
            db.session.commit()

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def add_product(self, form_data):
        """Reusable helper for adding a product"""
        return self.client.post('/admin/add_product', data=form_data, content_type='multipart/form-data')

    def test_product_validations(self):
        """Test adding a product with various invalid inputs"""
        test_cases = [
            # Valid data
            {"name": "Laptop", "quantity": 5, "price": 1000.0, "category": "1", "expected_status": 302},
            # Invalid cases
            {"name": "", "quantity": 5, "price": 1000.0, "category": "1", "expected_status": 400},  # Empty name
            {"name": "T-Shirt", "quantity": 0, "price": 50.0, "category": "1", "expected_status": 400},  # Zero quantity
            {"name": "Bread", "quantity": 10, "price": -5.0, "category": "1", "expected_status": 400},  # Negative price
            {"name": "Phone", "quantity": 3, "price": 800.0, "category": "999", "expected_status": 400},  # Invalid category
            {"name": "Monitor", "quantity": -2, "price": 300.0, "category": "1", "expected_status": 400},  # Negative quantity
            {"name": "Headphones", "quantity": 7, "price": 0.0, "category": "1", "expected_status": 400},  # Price = 0
            {"name": "Shoes", "quantity": 4, "price": 120.5, "category": "1", "expected_status": 302},  # Valid data
        ]

        # Simulate admin login
        with self.app.app_context():
            admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
            assert admin_user is not None, "Admin user must exist for login"
            email = admin_user.email  # Access email while attached to the session

        response = self.client.post('/auth/', data={
            'email': email,
            'password': 'admin2',
            'action': 'login'
        })


        for case in test_cases:
            with self.subTest(case=case):
                form_data = {
                    'name_prod': case["name"],
                    'description_prod': 'Test product',
                    'price': str(case["price"]),
                    'promo': '0',
                    'stock': str(case["quantity"]),
                    'idCategory': case["category"],
                    'brand': 'TestBrand',
                    'img_prod': (io.BytesIO(b"fake image data"), 'test.jpg')
                }
                response = self.add_product(form_data)
                print(f"Testing: {case} -> Status: {response.status_code}")
                self.assertEqual(response.status_code, case["expected_status"])

if __name__ == "__main__":
    unittest.main(verbosity=2)
