# app/controllers/cartCtrl.py
from flask import Blueprint, session, flash
from flask_login import current_user
import mysql.connector
from app.extensions import db
from app.models import Product, Cart

cart = Blueprint('cart', __name__)

def get_cart_items():
    if not current_user.is_authenticated:
        return {}
    
    cart_items = {}
    cart_records = Cart.query.filter_by(idClient=current_user.idClient).all()
    
    for record in cart_records:
        product = Product.query.get(record.idProduct)
        cart_items[record.idProduct] = {
            'name': product.name_prod,
            'price': product.price,
            'quantity': record.quantity,
            'image': product.img_prod,
            'stock': product.stock
        }
    
    return cart_items

def add_product_to_cart(product_id, product_name, product_price, quantity, product_image):
    if not current_user.is_authenticated:
        flash('Please login to add items to cart')
        return
    
    product_id = int(product_id)  # Ensure product_id is an integer
    cart_item = Cart.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    
    if cart_item:
        new_quantity = cart_item.quantity + quantity
        product = Product.query.get(product_id)
        if new_quantity > product.stock:
            flash('Cannot add more than available stock')
            return
        cart_item.quantity = new_quantity
    else:
        cart_item = Cart(
            idClient=current_user.idClient,
            idProduct=product_id,
            quantity=quantity
        )
        db.session.add(cart_item)
    
    db.session.commit()
    flash(f'Added {product_name} to cart successfully!')
    print(f'Cart item added: {cart_item}')  # Debugging statement

def remove_product_from_cart(product_id):
    if not current_user.is_authenticated:
        return
    
    cart_item = Cart.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    
    if cart_item:
        db.session.delete(cart_item)
        db.session.commit()

def clear_cart():
    if not current_user.is_authenticated:
        return
    
    Cart.query.filter_by(idClient=current_user.idClient).delete()
    db.session.commit()
    flash('Giỏ hàng đã được xóa thành công!')

def update_product_quantity_in_cart(product_id, quantity):
    if not current_user.is_authenticated:
        return
    
    cart_item = Cart.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    product = Product.query.get(product_id)
    
    if not product:
        flash('Product not found')
        return
    
    if cart_item:
        if quantity > product.stock:
            flash('Cannot add more than available stock')
            return
        cart_item.quantity = quantity
        db.session.commit()
