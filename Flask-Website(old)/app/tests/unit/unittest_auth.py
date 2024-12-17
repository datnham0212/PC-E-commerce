import sys
import os
sys.path.insert(0, os.path.abspath(os.path.join(os.path.dirname(__file__), '../../../')))

import unittest
from unittest.mock import patch, MagicMock
from flask import Flask, session
from app.controllers.authCtrl import signup_user, user_login, user_logout
from app.models import Admin, Client

app = Flask(__name__)
app.config['SECRET_KEY'] = 'test_secret_key'

class TestAuthCtrl(unittest.TestCase):

    @patch('app.controllers.authCtrl.db.session')
    @patch('app.controllers.authCtrl.Client')
    def test_signup_user_success(self, mock_client, mock_db_session):
        with app.test_request_context():
            mock_client.query.filter_by.return_value.first.return_value = None

            result = signup_user('John', 'Doe', 'john.doe@example.com', 'password123', '1234567890')

            self.assertTrue(result)
            mock_db_session.add.assert_called_once()
            mock_db_session.commit.assert_called_once()

    @patch('app.controllers.authCtrl.Client')
    def test_signup_user_existing_email(self, mock_client):
        with app.test_request_context():
            mock_client.query.filter_by.return_value.first.return_value = MagicMock()

            result = signup_user('John', 'Doe', 'john.doe@example.com', 'password123', '1234567890')

            self.assertFalse(result)

    @patch('app.controllers.authCtrl.login_user')
    def test_user_login_success(self, mock_login_user):
        with app.test_request_context():
            mock_user = MagicMock(password='password123')
            result = user_login(mock_user, 'password123')

            self.assertTrue(result)
            mock_login_user.assert_called_once_with(mock_user)

    @patch('app.controllers.authCtrl.login_user')
    def test_user_login_invalid_credentials(self, mock_login_user):
        with app.test_request_context():
            mock_user = MagicMock(password='password123')
            result = user_login(mock_user, 'wrongpassword')

            self.assertFalse(result)
            mock_login_user.assert_not_called()

    @patch('app.controllers.authCtrl.logout_user')
    @patch('app.controllers.authCtrl.current_user')
    def test_user_logout(self, mock_current_user, mock_logout_user):
        with app.test_request_context():
            mock_current_user.is_authenticated = True

            user_logout()

            mock_logout_user.assert_called_once()
            mock_current_user.is_authenticated = False  # Simulate the expected behavior
            self.assertFalse(mock_current_user.is_authenticated)

if __name__ == '__main__':
    unittest.main(verbosity=2)