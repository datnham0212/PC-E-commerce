# app/routes/main.py
from flask import Blueprint, render_template

main = Blueprint('main', __name__)

@main.route('/')
def home():
    return render_template('home.html')

@main.route('/favorites')
def help_page():
    return render_template('favorites.html')

@main.route('/contact-help')
def contact_page():
    return render_template('contact-help.html')
