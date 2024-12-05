from functools import wraps
from flask import redirect, url_for
from flask_login import current_user
from app.models import Admin

def client_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if isinstance(current_user, Admin):
            return redirect(url_for('admin.dashboard'))
        return f(*args, **kwargs)
    return decorated_function
