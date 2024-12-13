# app/routes/product_catalog.py
from flask import Blueprint, render_template, request, abort, redirect, url_for, flash
from app.controllers.product_catalogCtrl import (
    get_filtered_products, get_all_brands, get_product_details,
    get_favorite_products, add_product_to_favorites,
    remove_product_from_favorites, clear_all_favorites,
    add_review, update_review, delete_review
)
from flask_login import login_required, current_user
from app.models import Product, Catalog, Category # Import the Product, Catalog, Category models
from app.decorators.auth_decorators import client_required
product_catalog = Blueprint('product_catalog', __name__)

@product_catalog.route('/')
@client_required
def product_catalog_route():
    # Get filter parameters from the request
    min_price = request.args.get('minPrice', 0, type=float)
    max_price = request.args.get('maxPrice', 99999999, type=float)
    sort_by = request.args.get('sort', 'nameAZ')
    selected_brands = request.args.getlist('brand')
    category_name = request.args.get('category', 'all')

    # Get filtered products based on category
    if category_name == 'all':
        products = get_filtered_products(min_price, max_price, sort_by, selected_brands)
    else:
        category = Catalog.query.filter_by(name_cat=category_name).first()
        if category:
            products = Product.query.join(Category).filter(
                Category.idCatalog == category.idCatalog,
                Product.price >= min_price,
                Product.price <= max_price,
                Product.brand.in_(selected_brands) if selected_brands else True
            ).order_by(
                Product.name_prod.asc() if sort_by == 'nameAZ' else Product.name_prod.desc()
            ).all()
        else:
            products = []

    # Get the minimum and maximum prices from the products
    if products:
        min_price_value = min(product.price for product in products)
        max_price_value = max(product.price for product in products)
    else:
        min_price_value = 0
        max_price_value = 99999999

    brands = get_all_brands()
    categories = Catalog.query.all()
    return render_template('product_catalog.html', products=products, brands=brands, categories=categories, min_price_value=min_price_value, max_price_value=max_price_value)

@product_catalog.route('/api/products')
@client_required
def get_products():
    products = Product.query.all()  # Lấy tất cả sản phẩm từ cơ sở dữ liệu
    return {
        'products': [
            {'name': product.name_prod, 'link': f'/product_catalog/{product.idProduct}'}
            for product in products
        ]
    }

@product_catalog.route('/<int:product_id>')
@client_required
def product_detail(product_id):
    product, review_details = get_product_details(product_id)
    if product is None:
        abort(404)  # Nếu không tìm thấy sản phẩm, trả về lỗi 404
    return render_template('product_detail.html', product=product, reviews=review_details)  # Trả về template chi tiết sản phẩm & đánh giá

@product_catalog.route('/favorites')
@login_required
@client_required
def favorites():
    favorite_products = get_favorite_products()
    return render_template('favorites.html', products=favorite_products)

@product_catalog.route('/add_to_favorites', methods=['POST'])
@login_required
@client_required
def add_to_favorites():
    product_id = request.form.get('product_id')
    if product_id:
        message, category = add_product_to_favorites(product_id)
        flash(message, category)
    return redirect(url_for('product_catalog.product_detail', product_id=product_id))

@product_catalog.route('/remove_from_favorites/<int:product_id>', methods=['POST'])
@login_required
@client_required
def remove_from_favorites(product_id):
    message = remove_product_from_favorites(product_id)
    if message:
        flash(message[0], message[1])
    return redirect(url_for('product_catalog.favorites'))

@product_catalog.route('/clear_favorites', methods=['POST'])
@login_required
@client_required
def clear_favorites():
    message, category = clear_all_favorites()
    flash(message, category)
    return redirect(url_for('product_catalog.favorites'))

@product_catalog.route('/add_review', methods=['POST'])
@login_required
@client_required
def add_review_route():
    product_id = request.form.get('product_id')
    comment = request.form.get('comment')
    rating = request.form.get('rating')
    if product_id and rating:
        message, category = add_review(product_id, comment, rating)
        flash(message, category)
    return redirect(url_for('product_catalog.product_detail', product_id=product_id))

@product_catalog.route('/update_review', methods=['POST'])
@login_required
@client_required
def update_review_route():
    product_id = request.form.get('product_id')
    comment = request.form.get('comment')
    rating = request.form.get('rating')
    if product_id and rating:
        message, category = update_review(product_id, comment, rating)
        flash(message, category)
    return redirect(url_for('product_catalog.product_detail', product_id=product_id))

@product_catalog.route('/delete_review/<int:product_id>', methods=['POST'])
@login_required
@client_required
def delete_review_route(product_id):
    message, category = delete_review(product_id)
    flash(message, category)
    return redirect(url_for('product_catalog.product_detail', product_id=product_id))