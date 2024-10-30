# app/models.py
from .extensions import db
from flask_login import UserMixin
from datetime import datetime

# Admin Model
class Admin(db.Model, UserMixin):
    __tablename__ = 'admins'  # Thay đổi tên bảng
    idAdmin = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    email = db.Column(db.String(100), unique=True, nullable=False)
    password = db.Column(db.String(50), nullable=False)
    lastName = db.Column(db.String(50))
    firstName = db.Column(db.String(50))
    phoneNumber = db.Column(db.String(10), nullable=True)
    photo = db.Column(db.String(50), nullable=True)

# Address Model
class Address(db.Model):
    __tablename__ = 'address'
    idAddress = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    city = db.Column(db.String(50), nullable=False)
    country = db.Column(db.String(50), nullable=False)
    zipCode = db.Column(db.String(20), nullable=False)  # Thay đổi tên cột
    details = db.Column(db.String(100), nullable=False)
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), nullable=False)  # Thay đổi tên bảng và cột

# Category Model
class Category(db.Model):
    __tablename__ = 'category'
    idCategory = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    description_cat = db.Column(db.String(1000), nullable=False)  # Thay đổi tên cột
    idParent_cat = db.Column(db.Integer)  # Thay đổi tên cột

# Product Model
class Product(db.Model):
    __tablename__ = 'product'  
    idProduct = db.Column(db.Integer, primary_key=True)
    name_prod = db.Column(db.String(50), nullable=False)
    description_prod = db.Column(db.String(500), nullable=False)
    price = db.Column(db.Float, nullable=False)
    img_prod = db.Column(db.String(100), nullable=False)
    promo = db.Column(db.Float, default=0)
    stock = db.Column(db.Integer, nullable=False)
    idCategory = db.Column(db.Integer, db.ForeignKey('category.idCategory'), nullable=False)  # Thay đổi để liên kết với bảng category
    sold = db.Column(db.Integer, default=0)
    shipped = db.Column(db.Boolean, default=True)
    brand = db.Column(db.Integer, nullable=False)

# Review Model
class Review(db.Model):
    __tablename__ = 'review'
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), primary_key=True)  # Thay đổi tên bảng và cột
    idProduct = db.Column(db.Integer, db.ForeignKey('product.idProduct'), primary_key=True)  # Thay đổi tên bảng và cột
    comment = db.Column(db.String(500), nullable=False)
    rating = db.Column(db.Enum('0', '1', '2', '3', '4', '5'), nullable=False)

# Client Model
class Client(UserMixin, db.Model):
    __tablename__ = 'client'
    idClient = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    lastName = db.Column(db.String(50), nullable=False)
    firstName = db.Column(db.String(50), nullable=False)
    email = db.Column(db.String(100), unique=True, nullable=False)
    password = db.Column(db.String(20), nullable=False)
    phone = db.Column(db.String(12), nullable=True)  # Cho phép NULL
    user_img = db.Column(db.String(100), nullable=True)  # Cho phép NULL
    creationDate = db.Column(db.Date, nullable=False)

    # Flask-Login requires these properties
    def get_id(self):
        return self.idClient  # Return the correct column for the user ID
    
    @property
    def is_active(self):
        return True  # Active users return True

    @property
    def is_authenticated(self):
        return True  # Users who have logged in return True

    @property
    def is_anonymous(self):
        return False  # Users are not anonymous after login

# Order Model
class Order(db.Model):
    __tablename__ = 'order'
    idOrder = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), nullable=False)  # Thay đổi tên bảng và cột
    date_order = db.Column(db.DateTime, nullable=False)  # Thay đổi tên cột
    total_order = db.Column(db.Float, nullable=False)  # Thay đổi tên cột
    id_deliveryType = db.Column(db.Integer, db.ForeignKey('delivery_types.id_type'), nullable=False)  # Thay đổi tên bảng và cột

# Cart Model
class Cart(db.Model):
    __tablename__ = 'cart_products'
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), primary_key=True)  # Thay đổi tên bảng và cột
    idProduct = db.Column(db.Integer, db.ForeignKey('product.idProduct'), primary_key=True)  # Thay đổi tên bảng và cột
    quantity = db.Column(db.Integer, nullable=False)

# Delivery Model
class Delivery(db.Model):
    __tablename__ = 'delivery'
    idDelivery = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    idOrder = db.Column(db.Integer, db.ForeignKey('order.idOrder'), nullable=False)  # Thay đổi tên bảng và cột
    status_del = db.Column(db.Integer, nullable=False)  # Thay đổi tên cột
    date_del = db.Column(db.DateTime, nullable=False)  # Thay đổi tên cột
    idAddress = db.Column(db.Integer, db.ForeignKey('address.idAddress'), nullable=False)  # Thay đổi tên bảng và cột

# DeliveryType Model
class DeliveryType(db.Model):
    __tablename__ = 'delivery_types'
    id_type = db.Column(db.Integer, primary_key=True)  # Thay đổi tên cột
    name_type = db.Column(db.String(50), nullable=False)  # Thay đổi tên cột
    delivery_price = db.Column(db.Integer, nullable=False)  # Thay đổi tên cột

# Coupon Model
class Coupon(db.Model):
    __tablename__ = 'coupon'
    codeCoupon = db.Column(db.String(10), primary_key=True)  # Thay đổi tên cột
    value = db.Column(db.Integer, nullable=False)
    expiration_date = db.Column(db.Date, nullable=False)  # Thay đổi tên cột

# Wish Model
class Wish(db.Model):
    __tablename__ = 'wish'
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), primary_key=True)  # Thay đổi tên bảng và cột
    idProduct = db.Column(db.Integer, db.ForeignKey('product.idProduct'), primary_key=True)  # Thay đổi tên bảng và cột

# Brand Model
class Brand(db.Model):
    __tablename__ = 'brand'
    brand = db.Column(db.Integer, primary_key=True)
    brand_name = db.Column(db.String(200), nullable=False)

# Catalog Model
class Catalog(db.Model):
    __tablename__ = 'catalog'
    idCatalog = db.Column(db.Integer, primary_key=True)
    name_cat = db.Column(db.String(100), nullable=False)

# CatalogProducts Model
class CatalogProducts(db.Model):
    __tablename__ = 'catalog_products'
    idCatalog = db.Column(db.Integer, db.ForeignKey('catalog.idCatalog'), primary_key=True)
    idProduct = db.Column(db.Integer, db.ForeignKey('product.idProduct'), primary_key=True)

# LoyalClient Model
class LoyalClient(db.Model):
    __tablename__ = 'loyal_client'
    idClient = db.Column(db.Integer, db.ForeignKey('client.idClient'), primary_key=True)

# OrderProducts Model
class OrderProducts(db.Model):
    __tablename__ = 'order_products'
    idOrder = db.Column(db.Integer, db.ForeignKey('order.idOrder'), primary_key=True)
    idProduct = db.Column(db.Integer, db.ForeignKey('product.idProduct'), primary_key=True)
    quantity = db.Column(db.Integer, nullable=False)
