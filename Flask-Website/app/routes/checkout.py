from flask import Blueprint, render_template, redirect, url_for, request
from app.controllers.checkoutCtrl import validate_checkout, process_order

checkout = Blueprint('checkout', __name__)

@checkout.route('/')
def checkout_page():
    valid, data = validate_checkout()
    if not valid:
        return redirect(url_for('cart.cart_page'))
    return render_template('checkout.html', cart_items=data['cart_items'], total=data['total'])

@checkout.route('/process_checkout', methods=['POST'])
def process_checkout():
    order_details = process_order(request.form)
    if order_details:
        return render_template('receipt.html', order=order_details)
    return redirect(url_for('cart.cart_page'))
