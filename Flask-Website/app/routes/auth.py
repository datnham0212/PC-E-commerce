# app/routes/auth.py
from flask import Blueprint, render_template, request, redirect, url_for, flash, session
from flask_login import current_user, login_required
from app.models import Admin, Client
from app.controllers.authCtrl import signup_user, user_login, user_logout  # Import functions from authCtrl

auth = Blueprint('auth', __name__)

@auth.route('/', methods=['GET', 'POST'])
def auth_route():
    next_url = request.args.get('next')
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

    # If the next parameter is present, redirect to the home page
    if next_url:
        return redirect(url_for('main.home'))

    # Render the combined form template
    return render_template('login.html')


@auth.route('/logout')
@login_required
def logout():
    user_logout()
    return redirect(url_for('auth.auth_route'))