#app/admin/routes/admin_route.py
from flask import Blueprint, render_template, redirect, url_for, flash, request
from sqlalchemy import func
from app import db
from flask_login import login_required, current_user, logout_user
from app.models import Admin, Client, Product, Category, Order, OrderProducts, DeliveryType, LoyalClient

admin_bp = Blueprint('admin', __name__)

@admin_bp.route('/dashboard')
@login_required
def dashboard():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    # Fetch the 10 most recent orders
    recent_orders = Order.query.order_by(Order.date_order.desc()).limit(10).all()
    
    # Fetch related client and product data
    orders_with_details = []
    for order in recent_orders:
        client = Client.query.get(order.idClient)
        order_products = OrderProducts.query.filter_by(idOrder=order.idOrder).all()
        
        for order_product in order_products:
            product = Product.query.get(order_product.idProduct)
            orders_with_details.append({
                'id': order.idOrder,
                'customer_name': f"{client.firstName} {client.lastName}",
                'product_name': product.name_prod,
                'amount': order.total_order,
                'status': 'Pending'  # Adjust this line as per your actual order status logic
            })
    
    # Fetch statistics
    total_sales = db.session.query(func.sum(Order.total_order)).scalar() or 0
    total_orders = Order.query.count()
    total_customers = Client.query.count()
    total_stocks = db.session.query(func.sum(Product.stock)).scalar() or 0  # Sum of all product quantities

    return render_template('admin_dashboard.html', 
                           recent_orders=orders_with_details,
                           total_sales=total_sales,
                           total_orders=total_orders,
                           total_customers=total_customers,
                           total_stocks=total_stocks)

@admin_bp.route('/products')
@login_required
def products():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    products = Product.query.all()  # Fetch all products from the database
    return render_template('admin_products.html', products=products)

@admin_bp.route('/customers')
@login_required
def customers():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    clients = Client.query.all()  # Fetch all clients from the database
    loyal_clients = [loyal_client.idClient for loyal_client in LoyalClient.query.all()]  # Fetch all loyal clients
    return render_template('admin_customers.html', clients=clients, loyal_clients=loyal_clients)

@admin_bp.route('/delete_customer/<int:client_id>', methods=['POST'])
@login_required
def delete_customer(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    client = Client.query.get(client_id)
    if client:
        db.session.delete(client)
        db.session.commit()
        flash('Customer has been deleted successfully.', 'success')
    else:
        flash('Customer not found.', 'error')
    return redirect(url_for('admin.customers'))

@admin_bp.route('/verify_loyal_client/<int:client_id>', methods=['POST'])
@login_required
def verify_loyal_client(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    client = Client.query.get(client_id)
    if client:
        loyal_client = LoyalClient.query.filter_by(idClient=client_id).first()
        if loyal_client:
            db.session.delete(loyal_client)
            flash('Client has been removed from loyal clients.', 'success')
        else:
            new_loyal_client = LoyalClient(idClient=client_id)
            db.session.add(new_loyal_client)
            flash('Client has been verified as a loyal client.', 'success')
        db.session.commit()
    else:
        flash('Client not found.', 'error')
    return redirect(url_for('admin.customers'))

@admin_bp.route('/categories')
@login_required
def categories():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    categories = Category.query.all()  # Fetch all categories from the database
    return render_template('admin_categories.html', categories=categories)

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
        
        # Check if the email already exists
        existing_admin = Admin.query.filter_by(email=email).first()
        if existing_admin:
            flash('Email already registered.', 'error')
            return redirect(url_for('admin.registration'))
        
        # Create a new admin with plain text password (not recommended)
        new_admin = Admin(
            firstName=first_name,
            lastName=last_name,
            email=email,
            password=password
        )
        db.session.add(new_admin)
        db.session.commit()
        flash('Admin registered successfully.', 'success')
        return redirect(url_for('admin.registration'))
    
    admins = Admin.query.all()  # Fetch all admins from the database
    return render_template('admin_registration.html', admins=admins)

@admin_bp.route('/delete_category/<int:category_id>', methods=['POST'])
@login_required
def delete_category(category_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    category = Category.query.get(category_id)
    if category:
        db.session.delete(category)
        db.session.commit()
        flash('Category has been deleted successfully.', 'success')
    else:
        flash('Category not found.', 'error')
    return redirect(url_for('admin.categories'))

@admin_bp.route('/delete_product/<int:product_id>', methods=['POST'])
@login_required
def delete_product(product_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    product = Product.query.get(product_id)
    if product:
        db.session.delete(product)
        db.session.commit()
        flash('Product has been deleted successfully.', 'success')
    else:
        flash('Product not found.', 'error')
    return redirect(url_for('admin.products'))

@admin_bp.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('main.home'))
