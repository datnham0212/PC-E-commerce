import sys
import os
import io
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../..')))
import unittest
from flask_testing import TestCase
from app import create_app
from app.extensions import db
from app.models import Admin, Product, Category

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

            # Create product
            self.product = Product(
                idProduct=1,
                name_prod='NVIDIA RTX 2080',
                description_prod='High performance graphics card.',
                price=1890000.0,
                stock=10,
                img_prod='palit rtx.jpg',
                idCategory=1,
                brand='BrandX'
            )
            db.session.add(self.product)
            db.session.commit()

    def tearDown(self):
        """Clean up after each test"""
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def login_admin(self):
        """Helper method to log in as admin"""
        response = self.client.post('/auth/', data={
            'email': self.admin_user.email,
            'password': 'admin2',
            'action': 'login'
        })

    def delete_product(self, product_id):
        """Reusable helper for deleting a product"""
        return self.client.post(f'/admin/delete_product/{product_id}')

    def test_delete_product(self):
        """Test deleting a product with various scenarios"""
        test_cases = [
            # Valid product
            {"product_id": 1, "expected_status": 302},
            # Non-existent product
            {"product_id": 999, "expected_status": 404},
            # Empty ID
            {"product_id": "", "expected_status": 404},
        ]

        with self.app.app_context():
            self.admin_user = db.session.query(Admin).filter_by(email='admin2@gmail.com').first()
            db.session.refresh(self.admin_user)  # Refresh the instance

        self.login_admin()

        for case in test_cases:
            with self.subTest(case=case):
                response = self.delete_product(case["product_id"])
                print(f"Testing: {case} -> Status: {response.status_code}")
                self.assertEqual(response.status_code, case["expected_status"])

                if case["expected_status"] == 302:
                    with self.app.app_context():
                        deleted_product = Product.query.filter_by(idProduct=case["product_id"]).first()
                        self.assertIsNone(deleted_product)

if __name__ == "__main__":
    unittest.main(verbosity=2)