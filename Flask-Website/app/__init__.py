# app/__init__.py
from flask import Flask
from config import Config
from .extensions import db, bcrypt, login_manager  # Nhập từ extensions.py
from .models import Client, Admin  # Import Client & Admin model
from flask_login import LoginManager
    
login_manager = LoginManager()
login_manager.login_view = 'auth.auth_route'  # Đảm bảo rằng đây là route đăng nhập

@login_manager.user_loader
def load_user(user_id):
    # Try loading admin first
    admin = Admin.query.get(int(user_id))
    if admin:
        return admin
    # If not admin, try client
    return Client.query.get(int(user_id))


def create_app():
    app = Flask(__name__)
    app.config.from_object(Config)

    # Initialize extensions
    db.init_app(app)  # Đảm bảo rằng db được khởi tạo với app
    bcrypt.init_app(app)
    login_manager.init_app(app)
    login_manager.login_view = 'auth.login'  # Đảm bảo rằng đây là route đăng nhập

    # Register blueprints
    from .routes.auth import auth as auth_blueprint
    app.register_blueprint(auth_blueprint, url_prefix='/auth')

    from .routes.main import main as main_blueprint
    app.register_blueprint(main_blueprint)

    from .routes.product_catalog import product_catalog
    app.register_blueprint(product_catalog, url_prefix='/product_catalog')

    from .routes.cart import cart as cart_blueprint
    app.register_blueprint(cart_blueprint, url_prefix='/cart')

    from .routes.checkout import checkout
    app.register_blueprint(checkout, url_prefix='/checkout')

    from .routes.admin_route import admin_bp
    app.register_blueprint(admin_bp, url_prefix='/admin')

    return app
