# app/routes/auth.py
from flask import Blueprint, render_template, request, redirect, url_for, flash
from flask_login import logout_user, current_user
from app.controllers.authCtrl import login_user_action, signup_user, login_user  # Import functions from authCtrl

auth = Blueprint('auth', __name__)

@auth.route('/', methods=['GET', 'POST'])
def auth_route():
    
    if request.method == 'POST':
        action = request.form.get('action')  # "login" or "signup"

        # Login Logic
        if action == 'login':
            email = request.form.get('email').strip()  # Loại bỏ khoảng trắng
            password = request.form.get('password').strip()  # Loại bỏ khoảng trắng
            print(password)
            user = login_user_action(email, password)  # Gọi hàm đăng nhập

            if user:
                login_user(user)  # Đăng nhập người dùng
                flash(f"Login successful! Welcome, {user.firstName}!", "success")  # Hiển thị tên người dùng
                return redirect(url_for('main.home'))  # Chuyển hướng đến trang chính
            else:
                flash("Invalid email or password", "danger")  # Thông báo lỗi

        # Registration Logic
        elif action == 'signup':
            first_name = request.form.get('first_name')
            last_name = request.form.get('last_name')
            email = request.form.get('email')
            password = request.form.get('password')
            phone_number = request.form.get('phone_number')  # Lấy số điện thoại từ form

            if signup_user(first_name, last_name, email, password, phone_number):  # Gọi hàm signup
                return redirect(url_for('auth.auth_route'))  # Redirect to login tab

    # Render the combined form template
    return render_template('login.html')

@auth.route('/logout')
def logout():
    if current_user.is_authenticated:
        flash("You have been logged out.", "info")
        logout_user()
    return redirect(url_for('auth.auth_route'))
