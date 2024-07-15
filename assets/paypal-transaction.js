document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cpm_radio_buttons_form').addEventListener('submit-btn', function(event) {
        event.preventDefault();
        const selectedAmount = document.getElementById('option1').value;
        
        // Simulate transaction confirmation
        const transactionResult = document.getElementById('transaction-result');
        transactionResult.innerHTML = `Payment of $${selectedAmount} was successful!`;

        // You can perform additional actions here, such as logging the transaction
    });
});