
from flask import session, flash
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
        
    # Process order here
    # Add to database using form_data (full_name, email, address, phone)
    
    # Clear cart after successful order
    session.pop('cart', None)
    flash('Order placed successfully!', 'success')
    return True
