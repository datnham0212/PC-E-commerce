import sys
import os
import io
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../..')))
import unittest
from flask_testing import TestCase
from app import create_app
from app.extensions import db
from app.models import Admin, Category, Product

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
        self.assertEqual(response.status_code, 200)

    def edit_product(self, product_id, form_data):
        """Reusable helper for editing a product"""
        return self.client.post(f'/admin/edit_product/{product_id}', data=form_data, content_type='multipart/form-data')

    def test_product_validations(self):
        """Test editing a product with various invalid inputs"""
        test_cases = [
            # Valid data
            {"name": "Updated Laptop", "quantity": 30, "price": 1200.0, "category": "1", "expected_status": 302},
            # Invalid cases
            {"name": "", "quantity": 30, "price": 1200.0, "category": "1", "expected_status": 400},  # Empty name
            {"name": "Product with zero quantity", "quantity": 0, "price": 1200.0, "category": "1", "expected_status": 400},  # Zero quantity
            {"name": "Product with negative price", "quantity": 30, "price": -1200.0, "category": "1", "expected_status": 400},  # Negative price
            {"name": "Product with invalid category", "quantity": 30, "price": 1200.0, "category": "999", "expected_status": 400},  # Invalid category
            {"name": "Product with negative quantity", "quantity": -30, "price": 1200.0, "category": "1", "expected_status": 400},  # Negative quantity
            {"name": "Product with zero price", "quantity": 30, "price": 0.0, "category": "1", "expected_status": 400},  # Price = 0
            # Non-existent product ID
            {"name": "Non-existent Product", "quantity": 30, "price": 1200.0, "category": "1", "expected_status": 404},  # Non-existent product ID
        ]

        with self.client:
            with self.app.app_context():
                self.admin_user = db.session.query(Admin).filter_by(idAdmin=2).first()
                db.session.refresh(self.admin_user)  # Refresh the instance

                # Refresh the product instance to ensure it is managed by the session
                self.product = db.session.query(Product).filter_by(idProduct=1).first()
                db.session.refresh(self.product)

            # Simulate admin login
            response = self.client.post('/auth/', data={
                'email': self.admin_user.email,
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
                    product_id = self.product.idProduct if case["name"] != "Non-existent Product" else 999
                    response = self.edit_product(product_id, form_data)
                    print(f"Testing: {case} -> Status: {response.status_code}")
                    self.assertEqual(response.status_code, case["expected_status"])

if __name__ == "__main__":
    unittest.main(verbosity=2)