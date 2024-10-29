# app/routes/product_catalog.py
from flask import Blueprint, render_template, request, abort
from app.models import Product  # Import Product model

product_catalog = Blueprint('product_catalog', __name__)

@product_catalog.route('/')
def product_catalog_route():
    products = Product.query.all()  # Lấy tất cả sản phẩm từ cơ sở dữ liệu
    return render_template('product_catalog.html', products=products)

@product_catalog.route('/api/products')
def get_products():
    products = Product.query.all()  # Lấy tất cả sản phẩm từ cơ sở dữ liệu
    return {
        'products': [
            {'name': product.name_prod, 'link': f'product/{product.idProduct}'}
            for product in products
        ]
    }

@product_catalog.route('/product/<int:product_id>')
def product_detail(product_id):
    product = Product.query.get(product_id)  # Lấy sản phẩm theo ID
    if product is None:
        abort(404)  # Nếu không tìm thấy sản phẩm, trả về lỗi 404
    return render_template('product_detail.html', product=product)  # Trả về template chi tiết sản phẩm


