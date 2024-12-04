import unittest
from flask import session
from app import create_app, db
from app.models import Admin, Client
from app.controllers.authCtrl import signup_user, user_login, user_logout
from datetime import datetime

class TestAuth(unittest.TestCase):
    def setUp(self):
        self.app = create_app('testing')
        self.app_context = self.app.app_context()
        self.app_context.push()
        db.create_all()
        self.client = self.app.test_client()
        
        # Create test users
        self.test_admin = Admin(email='admin@test.com', password='adminpass')
        self.test_client = Client(
            firstName='Test',
            lastName='User',
            email='test@test.com',
            password='testpass',
            creationDate=datetime.now()
        )
        db.session.add(self.test_admin)
        db.session.add(self.test_client)
        db.session.commit()

    def tearDown(self):
        db.session.remove()
        db.drop_all()
        self.app_context.pop()

    def test_signup_user_success(self):
        result = signup_user(
            'New', 'User', 'new@test.com', 'newpass', '1234567890'
        )
        self.assertTrue(result)
        user = Client.query.filter_by(email='new@test.com').first()
        self.assertIsNotNone(user)

    def test_signup_user_duplicate_email(self):
        result = signup_user(
            'Test', 'User', 'test@test.com', 'testpass', '1234567890'
        )
        self.assertFalse(result)

    def test_user_login_admin_success(self):
        result = user_login(self.test_admin, 'adminpass')
        self.assertTrue(result)

    def test_user_login_client_success(self):
        result = user_login(self.test_client, 'testpass')
        self.assertTrue(result)

    def test_user_login_invalid_password(self):
        result = user_login(self.test_client, 'wrongpass')
        self.assertFalse(result)

    def test_user_logout(self):
        with self.client:
            user_login(self.test_client, 'testpass')
            user_logout()
            self.assertNotIn('user_id', session)

if __name__ == '__main__':
    unittest.main()
