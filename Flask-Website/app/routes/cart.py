from flask import Blueprint, render_template, session, request, redirect, url_for, flash
from app.controllers.cartCtrl import add_product_to_cart, remove_product_from_cart, get_cart_items, clear_cart

cart = Blueprint('cart', __name__)

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

@cart.route('/delete_cart', methods=['POST'])
def delete_cart():
    clear_cart()  # Gọi hàm xóa toàn bộ giỏ hàng
    flash('Giỏ hàng đã được xóa thành công!')  # Hiển thị thông báo thành công
    return redirect(url_for('cart.cart_page'))  # Chuyển hướng đến trang giỏ hàng