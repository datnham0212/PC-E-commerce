function switchTab(tabName) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    document.querySelector(`.${tabName}-tab`).classList.add('active');
    document.getElementById(`${tabName}-form`).classList.add('active');
}

function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-tab').forEach(tab => tab.classList.remove('active'));
    document.querySelector(`[onclick="selectPaymentMethod('${method}')"]`).classList.add('active');
    
    const cardForm = document.getElementById('card-payment-form');
    cardForm.style.display = method === 'card' ? 'block' : 'none';
}

async function applyCoupon() {
    const couponCode = document.getElementById('coupon-code').value;
    const response = await fetch('/apply-coupon', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({coupon: couponCode})
    });
    const result = await response.json();
    // Update total price based on response
}
