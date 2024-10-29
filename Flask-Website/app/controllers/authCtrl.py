from flask import flash
from werkzeug.security import generate_password_hash, check_password_hash
from app.models import User  # Import the User model
from app import db
from app.models import Client  # Import the Client model
from datetime import datetime
from flask_login import login_user as flask_login_user

def login_user_action(email, password):
    user = Client.query.filter_by(email=email).first()  # Kiểm tra trong bảng Client
    if user:
        print(f"User found: {user.email}")  # Ghi log email người dùng
        print(f"Stored password hash: {user.password}")  # Ghi log mật khẩu đã lưu
        if check_password_hash(generate_password_hash(user.password), password):  # Kiểm tra mật khẩu
            print("Ok")
            return user
    print("Invalid email or password")  # Ghi log thông báo lỗi
    return None

def signup_user(first_name, last_name, email, password, phone_number=None):
    existing_client = Client.query.filter_by(email=email).first()
    if existing_client:
        flash("Email already registered", "warning")
        return False

    new_client = Client(
        firstName=first_name,
        lastName=last_name,
        email=email,
        password=generate_password_hash(password, method='sha256'),
        phone=phone_number,
        creationDate=datetime.now()
    )
    db.session.add(new_client)
    db.session.commit()
    flash("Registration successful! Please log in.", "success")
    return True

def login_user(user):
    flask_login_user(user)  # Sử dụng hàm login_user từ Flask-Login
