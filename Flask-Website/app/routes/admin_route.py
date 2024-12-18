from flask import Blueprint, render_template, redirect, url_for, flash, request, session
from flask_login import login_required, current_user, logout_user
from werkzeug.utils import secure_filename  # Add this import
from app.controllers.admin_controller import (
    fetch_recent_orders, fetch_statistics, delete_client, toggle_loyal_client_status,
    add_admin, fetch_all_admins, fetch_all_clients, fetch_all_loyal_clients,
    fetch_all_categories, fetch_all_catalogs, add_category, update_category,
    delete_category, fetch_all_products, add_product, update_product, delete_product,
    update_delivery_status
)
from app.models import Admin, Client, LoyalClient, Order, Product, Category, Catalog
import os

admin_bp = Blueprint('admin', __name__)

@admin_bp.route('/dashboard')
@login_required
def dashboard():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    recent_orders = fetch_recent_orders()
    total_sales, total_orders, total_customers, total_stocks = fetch_statistics()
    return render_template('admin_dashboard.html', 
                           recent_orders=recent_orders,
                           total_sales=total_sales,
                           total_orders=total_orders,
                           total_customers=total_customers,
                           total_stocks=total_stocks)

@admin_bp.route('/customers')
@login_required
def customers():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    clients = fetch_all_clients()
    loyal_clients = fetch_all_loyal_clients()
    return render_template('admin_customers.html', clients=clients, loyal_clients=loyal_clients)

@admin_bp.route('/delete_customer/<int:client_id>', methods=['POST'])
@login_required
def delete_customer_route(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    success, message = delete_client(client_id)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.customers'))

@admin_bp.route('/verify_loyal_client/<int:client_id>', methods=['POST'])
@login_required
def verify_loyal_client_route(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    success, message = toggle_loyal_client_status(client_id)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.customers'))

@admin_bp.route('/add_admin', methods=['GET', 'POST'])
@login_required
def registration():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    if request.method == 'POST':
        first_name = request.form.get('firstName')
        last_name = request.form.get('lastName')
        email = request.form.get('email')
        password = request.form.get('password')
        success, message = add_admin(first_name, last_name, email, password)
        flash(message, 'success' if success else 'error')
        return redirect(url_for('admin.registration'))
    admins = fetch_all_admins()
    return render_template('admin_registration.html', admins=admins)

@admin_bp.route('/categories')
@login_required
def categories_route():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    categories = fetch_all_categories()
    catalogs = fetch_all_catalogs()
    return render_template('admin_categories.html', categories=categories, catalogs=catalogs)

@admin_bp.route('/add_category', methods=['POST'])
@login_required
def add_category_route():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    category_name = request.form.get('category_name')
    catalog_id = request.form.get('catalog_id')
    success, message = add_category(category_name, catalog_id)
    if success:
        flash(message, 'success')
    else:
        flash(message, 'danger')
    return redirect(url_for('admin.categories_route'))

@admin_bp.route('/edit_category/<int:category_id>', methods=['POST'])
@login_required
def edit_category_route(category_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    category_name = request.form.get('category_name')
    catalog_id = request.form.get('catalog_id')
    success, message = update_category(category_id, category_name, catalog_id)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.categories_route'))

@admin_bp.route('/delete_category/<int:category_id>', methods=['POST'])
@login_required
def delete_category_route(category_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    success, message = delete_category(category_id)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.categories_route'))

@admin_bp.route('/products')
@login_required
def products_route():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    products = fetch_all_products()
    categories = fetch_all_categories()
    return render_template('admin_products.html', products=products, categories=categories)

@admin_bp.route('/add_product', methods=['POST'])
@login_required
def add_product_route():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    file = request.files['img_prod']
    filename = secure_filename(file.filename) if file and file.filename else 'téléchargement.png'
    if file and file.filename:
        file.save(os.path.join('app', 'static', 'img', filename))
    name_prod = request.form.get('name_prod')
    description_prod = request.form.get('description_prod')
    price = request.form.get('price')
    promo = request.form.get('promo')
    stock = request.form.get('stock')
    idCategory = request.form.get('idCategory')
    brand = request.form.get('brand')
    success, message = add_product(name_prod, description_prod, price, promo, stock, idCategory, brand, filename)
    flash(message, 'success' if success else 'error')
    if success:
        return redirect(url_for('admin.products_route')), 302
    else:
        return redirect(url_for('admin.products_route')), 400

@admin_bp.route('/edit_product/<int:product_id>', methods=['POST'])
@login_required
def edit_product_route(product_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))

    product = Product.query.get(product_id)
    if not product:
        flash('Product not found', 'error')
        return redirect(url_for('admin.products_route')), 404

    file = request.files['img_prod']
    filename = secure_filename(file.filename) if file and file.filename else None
    if file and file.filename:
        file.save(os.path.join('app', 'static', 'img', filename))

    name_prod = request.form.get('name_prod')
    description_prod = request.form.get('description_prod')
    price = request.form.get('price')
    promo = request.form.get('promo')
    stock = request.form.get('stock')
    idCategory = request.form.get('idCategory')
    brand = request.form.get('brand')

    # Validate inputs
    if not name_prod or float(price) <= 0 or int(stock) < 0 or not idCategory.isdigit():
        flash('Invalid input data', 'error')
        return redirect(url_for('admin.products_route')), 400

    success, message = update_product(product_id, name_prod, description_prod, price, promo, stock, idCategory, brand, filename)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.products_route')), 302 if success else 400

@admin_bp.route('/delete_product/<int:product_id>', methods=['POST'])
@login_required
def delete_product_route(product_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    product = Product.query.get(product_id)
    if not product:
        flash('Product not found', 'error')
        return redirect(url_for('admin.products_route')), 404

    success, message = delete_product(product_id)
    flash(message, 'success' if success else 'error')
    return redirect(url_for('admin.products_route')), 302 if success else 400

@admin_bp.route('/update_delivery_status/<int:order_id>', methods=['POST'])
@login_required
def update_delivery_status_route(order_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    success = update_delivery_status(order_id)
    return ('', 204) if success else ('Delivery not found', 404)

@admin_bp.route('/logout')
@login_required
def logout_route():
    logout_user()
    session.clear()
    return redirect(url_for('main.home'))