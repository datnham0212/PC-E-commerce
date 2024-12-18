from app import db
from app.models import Admin, Cart, Client, Product, Category, Order, OrderProducts, Delivery, LoyalClient, Address, Review, Wish, Catalog
from sqlalchemy import func
from datetime import datetime
from flask_login import current_user

def fetch_recent_orders():
    recent_orders = db.session.query(Order, Delivery, Address).outerjoin(Delivery, Order.idOrder == Delivery.idOrder).outerjoin(Address, Delivery.idAddress == Address.idAddress).order_by(Order.date_order.desc()).limit(10).all()
    orders_with_details = []
    for order, delivery, address in recent_orders:
        client = Client.query.get(order.idClient)
        order_products = OrderProducts.query.filter_by(idOrder=order.idOrder).all()
        products = [{'name': Product.query.get(order_product.idProduct).name_prod, 'quantity': order_product.quantity} for order_product in order_products]
        orders_with_details.append({
            'order_id': order.idOrder,
            'customer_name': f"{client.firstName} {client.lastName}",
            'products': products,
            'amount': order.total_order,
            'order_date': order.date_order,
            'delivery_status': 'Completed' if delivery.status_del == 1 else 'Pending',
            'delivery_date': delivery.date_del if delivery.date_del else 'N/A',
            'delivery_id': delivery.idDelivery if delivery else 'N/A',
            'delivery_address': f"{address.details}, {address.city}, {address.country}, {address.zipCode}" if address else 'N/A',
            'delivery_type': order.id_deliveryType
        })
    return orders_with_details

def fetch_statistics():
    total_sales = db.session.query(func.sum(Order.total_order)).scalar() or 0
    total_orders = Order.query.count()
    total_customers = Client.query.count()
    total_stocks = db.session.query(func.sum(Product.stock)).scalar() or 0
    return total_sales, total_orders, total_customers, total_stocks

def delete_client(client_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    client = Client.query.get(client_id)
    if client:
        try:
            orders = Order.query.filter_by(idClient=client_id).all()
            for order in orders:
                OrderProducts.query.filter_by(idOrder=order.idOrder).delete()
                Delivery.query.filter_by(idOrder=order.idOrder).delete()
                db.session.delete(order)
            deliveries = Delivery.query.filter(Delivery.idAddress.in_(db.session.query(Address.idAddress).filter_by(idClient=client_id))).all()
            for delivery in deliveries:
                db.session.delete(delivery)
            addresses = Address.query.filter_by(idClient=client_id).all()
            for address in addresses:
                Delivery.query.filter_by(idAddress=address.idAddress).delete()
                db.session.delete(address)
            LoyalClient.query.filter_by(idClient=client_id).delete()
            Cart.query.filter_by(idClient=client_id).delete()
            Wish.query.filter_by(idClient=client_id).delete()
            Review.query.filter_by(idClient=client_id).delete()
            db.session.delete(client)
            db.session.commit()
            return True, 'Customer has been deleted successfully.'
        except Exception as e:
            db.session.rollback()
            return False, f'Error deleting client: {e}'
    return False, 'Customer not found.'

def toggle_loyal_client_status(client_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    client = Client.query.get(client_id)
    if client:
        loyal_client = LoyalClient.query.filter_by(idClient=client_id).first()
        if loyal_client:
            db.session.delete(loyal_client)
            db.session.commit()
            return True, 'Client has been removed from loyal clients.'
        else:
            new_loyal_client = LoyalClient(idClient=client_id)
            db.session.add(new_loyal_client)
            db.session.commit()
            return True, 'Client has been verified as a loyal client.'
    return False, 'Client not found.'

def add_admin(first_name, last_name, email, password):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    existing_admin = Admin.query.filter_by(email=email).first()
    if existing_admin:
        return False, 'Email already registered.'
    new_admin = Admin(firstName=first_name, lastName=last_name, email=email, password=password)
    db.session.add(new_admin)
    db.session.commit()
    return True, 'Admin registered successfully.'

def fetch_all_admins():
    return Admin.query.all()

def fetch_all_clients():
    return Client.query.all()

def fetch_all_loyal_clients():
    return [loyal_client.idClient for loyal_client in LoyalClient.query.all()]

def fetch_all_categories():
    return Category.query.all()

def fetch_all_catalogs():
    return Catalog.query.all()

def add_category(category_name, catalog_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    existing_category = Category.query.filter_by(description_cat=category_name, idCatalog=catalog_id).first()
    if existing_category:
        return False, 'Category already exists.'
    new_category = Category(description_cat=category_name, idCatalog=catalog_id)
    db.session.add(new_category)
    db.session.commit()
    return True, 'Category added successfully.'

def update_category(category_id, category_name, catalog_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    category = Category.query.get(category_id)
    if category:
        category.description_cat = category_name
        category.idCatalog = catalog_id
        db.session.commit()
        return True, 'Category updated successfully.'
    return False, 'Category not found.'

def delete_category(category_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    category = Category.query.get(category_id)
    if category:
        db.session.delete(category)
        db.session.commit()
        return True, 'Category has been deleted successfully.'
    return False, 'Category not found.'

def fetch_all_products():
    return Product.query.all()

def add_product(name_prod, description_prod, price, promo, stock, idCategory, brand, img_prod):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    if not name_prod or not description_prod or not idCategory or not brand:
        return False, 'Missing product information.'
    if not img_prod:
        return False, 'Missing product image.'
    
    # Check if the category exists
    category = Category.query.get(idCategory)
    if not category:
        return False, 'Category not found.'

    try:
        price = float(price)
        stock = int(stock)
    except ValueError:
        return False, 'Price and stock must be numeric values.'

    if price < 1 or stock < 1:
        return False, 'Price and stock must be at least 1.'
    
    existing_product = Product.query.filter_by(name_prod=name_prod, idCategory=idCategory, brand=brand).first()
    if existing_product:
        return False, 'Product already exists.'
    
    new_product = Product(name_prod=name_prod, description_prod=description_prod, price=price, promo=promo, stock=stock, idCategory=idCategory, brand=brand, img_prod=img_prod)
    db.session.add(new_product)
    db.session.commit()
    return True, 'Product added successfully.'

def update_product(product_id, name, description, price, promo, stock, category_id, brand, image):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'

    product = Product.query.get(product_id)
    if not product:
        return False, 'Product not found.'

    if not name or not description or not category_id or not brand:
        return False, 'Missing product information.'
    
    # Check if the category exists
    category = Category.query.get(category_id)
    if not category:
        return False, 'Category not found.'

    try:
        price = float(price)
        stock = int(stock)
    except ValueError:
        return False, 'Price and stock must be numeric values.'

    if price < 1 or stock < 1:
        return False, 'Price and stock must be at least 1.'

    product.name_prod = name
    product.description_prod = description
    product.price = price
    product.promo = promo
    product.stock = stock
    product.idCategory = category_id
    product.brand = brand

    if image:
        product.img_prod = image

    db.session.commit()
    return True, 'Product updated successfully.'

def delete_product(product_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    product = Product.query.get(product_id)
    if product:
        db.session.delete(product)
        db.session.commit()
        return True, 'Product has been deleted successfully.'
    return False, 'Product not found.'

def update_delivery_status(order_id):
    if not current_user.is_authenticated or not isinstance(current_user, Admin):
        return False, 'User is not an admin.'
    delivery = Delivery.query.filter_by(idOrder=order_id).first()
    if delivery:
        delivery.status_del = 1
        delivery.date_del = datetime.now()
        db.session.commit()
        return True
    return False