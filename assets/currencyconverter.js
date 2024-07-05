jQuery(document).ready(function($) {
    $('#onclick-exchange').on('click', function(e) {
        e.preventDefault();

        var usdAmount = $('input[name="usd_amount"]').val();  // Get the USD amount from the input field
        var apiKey = 'cur_live_w0ZN0pU4HqBYB2igmVBewxY1adPfTlVsbXgCQLM6';  // Your API key
        var apiUrl = `https://api.currencyapi.com/v3/latest?apikey=${apiKey}&base_currency=USD&currencies=AED`;  // Correct API URL

        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.data && response.data.AED) {  // Check if response contains AED conversion rate
                    var conversionRate = response.data.AED;  // Extract the conversion rate from the API response

                    // Calculate the converted amount
                    var aedAmount = usdAmount * conversionRate;

                    // Display the result in an alert box for demonstration purposes
                    $('#investor_attr').text(aedAmount.toFixed(2) + ' AED');  // Update the UI with the converted amount
                } else {
                    alert('Conversion rate for AED not found in the API response.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred during the conversion.');
            }
        });
    });
});
