jQuery(document).ready(function ($) {
  let isConvertedToAED = false;

  $("#onclick-exchange").on("click", function (e) {
    e.preventDefault();

    let usdAmount = parseFloat($("#investor_currency").data("usd-amount")); // Get the original USD amount from data attribute
    if (!usdAmount) {
      usdAmount = parseFloat($("#investor_currency").text().trim());
      $("#investor_currency").data("usd-amount", usdAmount); // Store the original USD amount
    }

    if (isConvertedToAED) {
      // Convert back to USD
      $("#investor_currency").text(usdAmount.toFixed(2)); // Set the text to the original USD amount
    } else {
      // Convert to AED
      const apiKey = "cur_live_w0ZN0pU4HqBYB2igmVBewxY1adPfTlVsbXgCQLM6"; // Your API key
      const apiUrl = `https://api.currencyapi.com/v3/latest?apikey=${apiKey}`; // Correct API URL

      $.ajax({
        url: apiUrl,
        method: "GET",
        dataType: "json",
        success: function (response) {
          if (response.data && response.data.AED) {
            const conversionRate = response.data.AED.value;
            const convertAED = usdAmount * conversionRate;
            $("#investor_currency").text(convertAED.toFixed(2)); // Set the text to the converted amount, formatted to 2 decimal places
            $('#investor-currency').removeClass('fa-dollar-sign').addClass('fa-check');
            isConvertedToAED = true; // Set the flag to indicate conversion to AED
          }
        },
        error: function (xhr, status, error) {
          alert("An error occurred during the conversion.");
        },
      });
    }

    isConvertedToAED = !isConvertedToAED; // Toggle the state
  });
});
