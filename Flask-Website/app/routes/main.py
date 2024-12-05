# app/routes/main.py
from flask import Blueprint, render_template
from app.decorators.auth_decorators import client_required

main = Blueprint('main', __name__)

@main.route('/')
@client_required
def home():
    return render_template('home.html')

@main.route('/guidelines')
@client_required
def guidelines_page():
    return render_template('guidelines.html')

@main.route('/about')
@client_required
def about_page():
    return render_template('about.html')

@main.route('/policies')
@client_required
def policies_page():
    return render_template('policies.html')

@main.route('/favorites')
@client_required
def favorite_page():
    return render_template('favorites.html')

@main.route('/contact-help')
@client_required
def contact_page():
    return render_template('contact-help.html')
