import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../..')))
import unittest
from datetime import datetime
from flask_testing import TestCase
from flask_login import current_user
from app import create_app
from app.extensions import db
from app.models import Client, Admin
from app.controllers.authCtrl import signup_user, user_login, user_logout

class AuthTestCase(TestCase):
    def create_app(self):
        """Set up the Flask test client"""
        print("Creating Flask test client")
        self.app = create_app()
        self.app.config['TESTING'] = True
        self.app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
        return self.app

    def setUp(self):
        """Set up the Flask test client"""
        print("Setting up the test environment")
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
            print("Test user created and committed to the database")

    def tearDown(self):
        """Clean up after each test"""
        print("Tearing down the test environment")
        with self.app.app_context():
            db.session.remove()
            db.drop_all()
            print("Database tables dropped")

    def test_signup_user(self):
        """Test user signup"""
        print("Testing user signup")
        with self.app.app_context():
            result = signup_user('John', 'Doe', 'john@example.com', 'password123', '1234567890')
            print(f"Signup result: {result}")
            self.assertTrue(result)
            user = Client.query.filter_by(email='john@example.com').first()
            print(f"Queried user: {user}")
            self.assertIsNotNone(user)
            self.assertEqual(user.firstName, 'John')
            self.assertEqual(user.lastName, 'Doe')

    def test_user_login(self):
        """Test user login"""
        print("Testing user login")
        with self.app.app_context():
            user = Client.query.filter_by(email='a@a').first()
            print(f"Queried user for login: {user}")
            result = user_login(user, 'a')
            print(f"Login result: {result}")
            self.assertTrue(result)

    def test_user_logout(self):
        """Test user logout"""
        print("Testing user logout")
        with self.app.app_context():
            user = Client.query.filter_by(email='a@a').first()
            print(f"Queried user for logout: {user}")
            user_login(user, 'a')
            user_logout()
            print(f"User authenticated: {current_user.is_authenticated}")
            self.assertFalse(current_user.is_authenticated)

if __name__ == "__main__":
    unittest.main(verbosity=2)