function changeQuantity(amount) {
    const input = document.querySelector('.quantity-input');
    let currentValue = parseInt(input.value);
    const maxStock = parseInt(input.getAttribute('max'));

    // Ensure currentValue is a valid number
    if (isNaN(currentValue)) currentValue = 1;

    currentValue += amount;
    if (currentValue < 1) currentValue = 1; // Ensure quantity doesn't go below 1
    if (currentValue > maxStock) currentValue = maxStock; // Ensure quantity doesn't exceed stock

    input.value = currentValue;
    updateHiddenInput(currentValue);
}

function updateHiddenInput() {
    const input = document.querySelector('.quantity-input');
    const hiddenInput = document.querySelector('.quantity-hidden-form');
    hiddenInput.value = input.value; // Update the form hidden input with the current quantity
}

function checkQuantity() {
    const hiddenInput = document.querySelector('.quantity-hidden-form');
    console.log("Số lượng gửi đi:", hiddenInput.value); // Output the value of the hidden field
}

function showEditForm(comment, rating) {
    const editForm = document.getElementById('edit-review-form');
    const editComment = document.getElementById('edit-comment');
    const editRating = document.getElementById('edit-rating');
    editComment.value = comment;
    editRating.value = rating;
    editForm.style.display = 'block';
}