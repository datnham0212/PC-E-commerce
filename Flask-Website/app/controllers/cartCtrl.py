from flask import Blueprint, render_template, session, request, redirect, url_for, flash
from flask_login import current_user

cart = Blueprint('cart', __name__)

def get_cart_items():
    if not current_user.is_authenticated:
        return {}
    cart_key = f'cart_{current_user.idClient}'
    return session.get(cart_key, {})

def add_product_to_cart(product_id, product_name, product_price, quantity):
    if not current_user.is_authenticated:
        flash('Please login to add items to cart')
        return
    
    cart_key = f'cart_{current_user.idClient}'
    cart_items = session.get(cart_key, {})
    
    if product_id in cart_items:
        cart_items[product_id]['quantity'] += quantity
    else:
        cart_items[product_id] = {
            'name': product_name,
            'price': product_price,
            'quantity': quantity
        }
    
    session[cart_key] = cart_items
    flash(f'Added {product_name} to cart successfully!')

def remove_product_from_cart(product_id):
    if not current_user.is_authenticated:
        return
        
    cart_key = f'cart_{current_user.idClient}'
    cart_items = session.get(cart_key, {})
    
    if product_id in cart_items:
        del cart_items[product_id]
    
    session[cart_key] = cart_items


