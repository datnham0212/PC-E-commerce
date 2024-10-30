from flask import Blueprint, render_template, session, redirect, url_for, flash, request
from app.controllers.cartCtrl import get_cart_items

checkout = Blueprint('checkout', __name__)

@checkout.route('/')
def checkout_page():
    cart_items = get_cart_items()
    if not cart_items:
        return redirect(url_for('cart.cart_page'))
    
    total = sum(item['price'] * item['quantity'] for item in cart_items.values())
    return render_template('checkout.html', cart_items=cart_items, total=total)

@checkout.route('/process_checkout', methods=['POST'])
def process_checkout():
    cart_items = get_cart_items()
    if not cart_items:
        return redirect(url_for('cart.cart_page'))
        
    # Get form data
    full_name = request.form.get('full_name')
    email = request.form.get('email')
    address = request.form.get('address')
    phone = request.form.get('phone')
    
    # Process order here
    # Add to database
    # Clear cart
    session.pop('cart', None)
    
    flash('Order placed successfully!', 'success')
    return redirect(url_for('main.home'))
