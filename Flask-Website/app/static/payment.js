// Quản lý trạng thái
const state = {
    currentStep: 1,
    totalSteps: 2,
    deliveryPrice: 0,
    subtotal: parseFloat(document.getElementById('subtotal').textContent.replace(' VND', '').trim())
};

// Xác thực biểu mẫu
const validateShippingForm = () => {
    const requiredFields = [
        'first_name', 'last_name', 'email',
        'phone', 'address', 'country', 'city', 'zipCode'
    ];

    let isValid = true;

    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');
        }
    });

    console.log('Biểu mẫu giao hàng hợp lệ:', isValid);
    return isValid;
};

const validatePaymentForm = () => {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    let isValid = true;

    if (paymentMethod === 'card') {
        const cardFields = ['card_number', 'expiry', 'cvv'];
        cardFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('error');
                isValid = false;
            } else {
                input.classList.remove('error');
            }
        });
    }

    console.log('Biểu mẫu thanh toán hợp lệ:', isValid);
    return isValid;
};

// Chức năng điều hướng
const updateSteps = () => {
    document.querySelectorAll('.step').forEach((step, index) => {
        step.classList.toggle('active', index + 1 <= state.currentStep);
    });

    document.querySelectorAll('.form-section').forEach((section, index) => {
        section.classList.toggle('active', index + 1 === state.currentStep);
    });

    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');

    prevBtn.style.display = state.currentStep === 1 ? 'none' : 'block';
    nextBtn.style.display = state.currentStep === state.totalSteps ? 'none' : 'block';
    submitBtn.style.display = state.currentStep === state.totalSteps ? 'block' : 'none';
};

const nextStep = () => {
    const warningMessage = document.getElementById('warning-message');
    if (state.currentStep === 1 && !validateShippingForm()) {
        warningMessage.style.display = 'block';
        return;
    } else {
        warningMessage.style.display = 'none';
    }

    if (state.currentStep < state.totalSteps) {
        state.currentStep++;
        updateSteps();
    }
};

const prevStep = () => {
    if (state.currentStep > 1) {
        state.currentStep--;
        updateSteps();
    }
};

// Logic mã khuyến mãi
const applyCoupon = (e) => {
    e.preventDefault();
    const couponCode = document.getElementById('coupon-code').value.trim();
    if (couponCode) {
        fetch('/api/validate-coupon', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ code: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                state.subtotal *= (1 - data.discount);
                updateTotalPrice();
            }
        });
    }
};

// Cập nhật tổng giá sau khi áp dụng mã khuyến mãi hoặc thay đổi phí giao hàng
const updateTotalPrice = () => {
    const total = state.subtotal + state.deliveryPrice;
    document.querySelector('.total-amount').textContent = total.toFixed(2) + ' VND';
    document.querySelector('#shipping-cost').textContent = state.deliveryPrice === 0 ? 'Miễn phí' : state.deliveryPrice + ' VND';
};

// Trình nghe sự kiện
document.querySelectorAll('input[name="delivery_option"]').forEach(input => {
    input.addEventListener('change', (e) => {
        // Đặt giá giao hàng là 15000 VND cho giao hàng nhanh, 0 cho giao hàng tiêu chuẩn
        state.deliveryPrice = e.target.value === 'express' ? 15000 : 0;
        updateTotalPrice();
    });
});

updateSteps();

document.addEventListener('DOMContentLoaded', () => {
    const cardDetails = document.getElementById('card-details');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');

    paymentMethods.forEach(method => {
        method.addEventListener('change', (e) => {
            if (e.target.value === 'cash') {
                cardDetails.style.display = 'none';
            } else {
                cardDetails.style.display = 'block';
            }
        });
    });

    // Kiểm tra ban đầu để đặt trạng thái hiển thị chính xác
    if (document.querySelector('input[name="payment_method"]:checked').value === 'cash') {
        cardDetails.style.display = 'none';
    }
});