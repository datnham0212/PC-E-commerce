# app/routes/main.py
from flask import Blueprint, render_template

main = Blueprint('main', __name__)

@main.route('/')
def home():
    return render_template('home.html')

@main.route('/help')
def help_page():
    return render_template('help.html')

@main.route('/contact')
def contact_page():
    return render_template('contact.html')
