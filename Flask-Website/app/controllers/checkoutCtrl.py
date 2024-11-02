from flask import session, flash
from flask_login import current_user
from datetime import datetime
from app.models import Order, OrderProducts, Delivery, Address, Coupon
from app.extensions import db
from app.controllers.cartCtrl import get_cart_items

def validate_checkout():
    cart_items = get_cart_items()
    if not cart_items:
        return False, None
    total = sum(item['price'] * item['quantity'] for item in cart_items.values())
    return True, {'cart_items': cart_items, 'total': total}

def process_order(form_data):
    cart_items = get_cart_items()
    if not cart_items:
        return False
    
    # Calculate total
    total = sum(item['price'] * item['quantity'] for item in cart_items.values())
    
    # Determine delivery type
    delivery_option = form_data.get('delivery_option')
    if delivery_option == 'express':
        delivery_type_id = 2  # Assuming 2 is the ID for express delivery
    else:
        delivery_type_id = 1  # Default to standard delivery
    
    # Create new order
    new_order = Order(
        idClient=current_user.idClient,
        date_order=datetime.now(),
        total_order=total,
        id_deliveryType=delivery_type_id
    )
    db.session.add(new_order)
    db.session.flush()  # Get the order ID
    
    # Create order products
    for product_id, item in cart_items.items():
        order_product = OrderProducts(
            idOrder=new_order.idOrder,
            idProduct=product_id,
            quantity=item['quantity']
        )
        db.session.add(order_product)
    
    # Create delivery address
    address = Address(
        city=form_data.get('city'),
        country=form_data.get('country', 'Default Country'),
        zipCode=form_data.get('zipCode'),
        details=form_data.get('address'),
        idClient=current_user.idClient
    )
    db.session.add(address)
    db.session.flush()
    
    # Create delivery record
    delivery = Delivery(
        idOrder=new_order.idOrder,
        status_del=0,  # Initial status
        date_del=datetime.now(),
        idAddress=address.idAddress
    )
    db.session.add(delivery)
    
    try:
        db.session.commit()
        session.pop(f'cart_{current_user.idClient}', None)  # Clear cart
        flash('Order placed successfully!', 'success')
        return True
    except Exception as e:
        db.session.rollback()
        flash('Error processing order', 'error')
        return False

def apply_coupon(coupon_code):
    coupon = Coupon.query.get(coupon_code)
    if not coupon:
        return False, "Invalid coupon code"
    
    if coupon.expiration_date < datetime.now().date():
        return False, "Coupon has expired"
        
    return True, coupon.value

def process_payment(payment_method, payment_data):
    if payment_method == 'cash':
        return True
        
    if payment_method == 'card':
        # Integrate with payment gateway here
        # Validate card details
        # Process payment
        return True
    
    return False
