from flask import Blueprint, render_template, session, request, redirect, url_for, flash

cart = Blueprint('cart', __name__)

def get_cart_items():
    return session.get('cart', {})

def add_product_to_cart(product_id, product_name, product_price, quantity):
    cart_items = get_cart_items()
    
    if product_id in cart_items:
        cart_items[product_id]['quantity'] += quantity  # Tăng số lượng nếu sản phẩm đã có
    else:
        cart_items[product_id] = {
            'name': product_name,
            'price': product_price,
            'quantity': quantity  # Sử dụng số lượng từ form
        }
    
    session['cart'] = cart_items  # Cập nhật session
    flash(f'Đã thêm {product_name} vào giỏ hàng thành công!')  # Thêm thông báo flash

def remove_product_from_cart(product_id):
    cart_items = get_cart_items()
    
    if product_id in cart_items:
        del cart_items[product_id]  # Xóa sản phẩm khỏi giỏ hàng
    
    session['cart'] = cart_items  # Cập nhật session

@cart.route('/')
def cart_page():
    cart_items = get_cart_items()
    return render_template('cart.html', cart_items=cart_items)

@cart.route('/add_to_cart', methods=['POST'])
def add_to_cart():
    product_id = request.form.get('product_id')
    product_name = request.form.get('product_name')
    product_price = float(request.form.get('product_price'))
    quantity = int(request.form.get('quantity'))  # Lấy số lượng từ form
    
    add_product_to_cart(product_id, product_name, product_price, quantity)  # Gọi hàm thêm sản phẩm vào giỏ hàng
    return redirect(url_for('product_catalog.product_catalog_route'))  # Chuyển hướng đến trang danh mục sản phẩm

@cart.route('/remove_from_cart/<product_id>', methods=['POST'])
def remove_from_cart(product_id):
    remove_product_from_cart(product_id)  # Gọi hàm xóa sản phẩm khỏi giỏ hàng
    return redirect(url_for('cart.cart_page'))  # Chuyển hướng đến trang giỏ hàng
