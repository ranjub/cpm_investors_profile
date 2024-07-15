document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submit-button').addEventListener('click', function () {
        const selectedPrice = document.querySelector('input[name="radio_option"]:checked');
        
        if (!selectedPrice) {
            alert('Please select a price.');
            return;
        }

        // Send selected price to server to simulate PayPal transaction
        fetch('/wp-admin/admin-ajax.php?action=create_paypal_transaction_from_radio', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'radio_option=' + encodeURIComponent(selectedPrice.value)
        }).then(response => response.json()).then(result => {
            const transactionResult = document.getElementById('transaction-result');
            if (result.success) {
                // Display transaction details
                transactionResult.innerHTML = `Payment successful! Price: ${result.price} USD, Transaction ID: ${result.transactionId}`;
            } else {
                transactionResult.innerHTML = 'Payment failed';
            }
        });
    });
});