#app/admin/routes/admin_route.py
from flask import Blueprint, render_template, redirect, url_for
from sqlalchemy import func
from app import db
from flask_login import login_required, current_user, logout_user
from app.models import Admin, Client, Product, Category, Order, OrderProducts, DeliveryType

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
    return render_template('admin_customers.html', clients=clients)

@admin_bp.route('/categories')
@login_required
def categories():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    categories = Category.query.all()  # Fetch all categories from the database
    return render_template('admin_categories.html', categories=categories)

@admin_bp.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('main.home'))
