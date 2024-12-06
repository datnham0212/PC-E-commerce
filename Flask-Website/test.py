import unittest
from flask import session
from app import create_app
from app.extensions import db
from app.models import Client

# test_test.py

class CartTestCase(unittest.TestCase):
    def setUp(self):
        self.app = create_app()
        self.app.config['TESTING'] = True
        self.app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
        self.client = self.app.test_client()
        with self.app.app_context():
            db.create_all()
            self.client_user = Client(idClient=1, email='test@example.com')
            db.session.add(self.client_user)
            db.session.commit()

    def tearDown(self):
        with self.app.app_context():
            db.session.remove()
            db.drop_all()

    def test_add_product_to_cart(self):
        with self.client.session_transaction() as sess:
            sess['user_id'] = self.client_user.idClient

        response = self.client.post('/cart/add_to_cart', data={
            'product_id': '1',
            'product_name': 'Test Product',
            'product_price': '10.0',
            'quantity': '1',
            'product_image': 'test_image.jpg'
        })

        self.assertEqual(response.status_code, 302)
        with self.client.session_transaction() as sess:
            cart_key = f'cart_{self.client_user.idClient}'
            self.assertIn(cart_key, sess)
            self.assertIn('1', sess[cart_key])
            self.assertEqual(sess[cart_key]['1']['name'], 'Test Product')
            self.assertEqual(sess[cart_key]['1']['price'], 10.0)
            self.assertEqual(sess[cart_key]['1']['quantity'], 1)
            self.assertEqual(sess[cart_key]['1']['image'], 'test_image.jpg')

if __name__ == '__main__':
    unittest.main()