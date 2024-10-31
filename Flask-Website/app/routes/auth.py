# app/routes/auth.py
from flask import Blueprint, render_template, request, redirect, url_for, flash
from flask_login import logout_user, current_user
from app.models import Admin, Client
from app.controllers.authCtrl import signup_user, user_login  # Import functions from authCtrl

auth = Blueprint('auth', __name__)

@auth.route('/', methods=['GET', 'POST'])
def auth_route():
    if request.method == 'POST':
        action = request.form.get('action')  # "login" or "signup"

        # Login Logic
        if action == 'login':
            email = request.form.get('email').strip()
            password = request.form.get('password').strip()
        
            # Try admin login first
            admin = Admin.query.filter_by(email=email).first()
            if admin and user_login(admin, password):
                return redirect(url_for('admin.dashboard'))
        
            # If not admin, try client login
            client = Client.query.filter_by(email=email).first()
            if client and user_login(client, password):
                return redirect(url_for('main.home'))
            
            flash('Invalid credentials', 'danger')
            return redirect(url_for('auth.auth_route'))

        # Registration Logic
        elif action == 'signup':
            first_name = request.form.get('first_name')
            last_name = request.form.get('last_name')
            email = request.form.get('email')
            password = request.form.get('password')
            phone_number = request.form.get('phone_number')

            if signup_user(first_name, last_name, email, password, phone_number):
                return redirect(url_for('auth.auth_route'))

    # Render the combined form template
    return render_template('login.html')


@auth.route('/logout')
def logout():
    if current_user.is_authenticated:
        flash("You have been logged out.", "info")
        logout_user()
    return redirect(url_for('auth.auth_route'))