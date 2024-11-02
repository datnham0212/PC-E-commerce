# app/controllers/product_catalogCtrl.py
from app.models import Product, Review, Client, Brand, Wish
from app.extensions import db
from flask_login import current_user

def get_filtered_products(min_price, max_price, sort_by, selected_brands):
    # Build the query
    query = Product.query

    # Filter by price range
    query = query.filter(Product.price >= min_price, Product.price <= max_price)

    # Filter by selected brands
    if selected_brands:
        query = query.filter(Product.brand.in_(selected_brands))

    # Sort the results
    if sort_by == 'lowToHigh':
        query = query.order_by(Product.price.asc())
    elif sort_by == 'highToLow':
        query = query.order_by(Product.price.desc())
    elif sort_by == 'nameAZ':
        query = query.order_by(Product.name_prod.asc())
    elif sort_by == 'nameZA':
        query = query.order_by(Product.name_prod.desc())

    # Execute the query
    return query.all()

def get_all_brands():
    return Brand.query.all()

def get_product_details(product_id):
    product = Product.query.get(product_id)
    if product is None:
        return None, None

    reviews = Review.query.filter_by(idProduct=product_id).all()
    review_details = []
    for review in reviews:
        client = Client.query.get(review.idClient)
        review_details.append({
            'client_name': f"{client.firstName} {client.lastName}",
            'comment': review.comment,
            'rating': review.rating
        })
    return product, review_details

def get_favorite_products():
    return db.session.query(Product).join(Wish, Product.idProduct == Wish.idProduct).filter(Wish.idClient == current_user.idClient).all()

def add_product_to_favorites(product_id):
    existing_wish = Wish.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    if not existing_wish:
        new_wish = Wish(idClient=current_user.idClient, idProduct=product_id)
        db.session.add(new_wish)
        db.session.commit()
        return 'Sản phẩm đã được thêm vào danh sách ưa thích.', 'success'
    else:
        return 'Sản phẩm đã có trong danh sách ưa thích.', 'info'

def remove_product_from_favorites(product_id):
    wish = Wish.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    if wish:
        db.session.delete(wish)
        db.session.commit()
        return 'Sản phẩm đã được xoá khỏi danh sách ưa thích.', 'success'
    return None

def clear_all_favorites():
    Wish.query.filter_by(idClient=current_user.idClient).delete()
    db.session.commit()
    return 'Tất cả sản phẩm ưa thích đã được xoá.', 'success'

def add_review(product_id, comment, rating):
    existing_review = Review.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    if existing_review:
        return 'Bạn đã đánh giá sản phẩm này rồi.', 'info'
    new_review = Review(idClient=current_user.idClient, idProduct=product_id, comment=comment or '', rating=rating)
    db.session.add(new_review)
    db.session.commit()
    return 'Đánh giá của bạn đã được thêm.', 'success'

def update_review(product_id, comment, rating):
    review = Review.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    if review:
        review.comment = comment or ''
        review.rating = rating
        db.session.commit()
        return 'Đánh giá của bạn đã được cập nhật.', 'success'
    return 'Không tìm thấy đánh giá của bạn.', 'error'

def delete_review(product_id):
    review = Review.query.filter_by(idClient=current_user.idClient, idProduct=product_id).first()
    if review:
        db.session.delete(review)
        db.session.commit()
        return 'Đánh giá của bạn đã được xoá.', 'success'
    return 'Không tìm thấy đánh giá của bạn.', 'error'