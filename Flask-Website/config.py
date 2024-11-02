# config.py
import os

class Config:
    SECRET_KEY = os.getenv('SECRET_KEY', 'your_secret_key')
    SQLALCHEMY_DATABASE_URI = 'mysql+pymysql://root:@localhost/ecommerce3'
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    DEBUG = True

