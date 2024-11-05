from flask import flash, session
from flask_login import login_user, logout_user, current_user
from app.models import Admin, Client  # Import the Admin and Client models
from app import db
from datetime import datetime

def signup_user(first_name, last_name, email, password, phone_number=None):
    existing_client = Client.query.filter_by(email=email).first()
    if existing_client:
        flash("Email already registered", "warning")
        return False

    new_client = Client(
        firstName=first_name,
        lastName=last_name,
        email=email,
        password=password,  # Store plain text password for simplicity
        phone=phone_number,
        creationDate=datetime.now()
    )
    
    db.session.add(new_client)
    db.session.commit()
    flash("Registration successful! Please log in.", "success")
    return True

def user_login(user, password):
    if user.password == password:  # Compare plain text passwords
        session.clear()  # Clear session cookies
        login_user(user)
        if not isinstance(user, Admin):
            flash("Login successful!", "success")
        return True
    else:
        flash("Invalid credentials", "danger")
        return False

def user_logout():
    if current_user.is_authenticated:
        logout_user()
        session.clear()
        flash("You have been logged out.", "info")