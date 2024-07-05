jQuery(document).ready(function ($) {
  let isConvertedToAED = false; // State to track conversion

  $("#onclick-exchange").on("click", function (e) {
    e.preventDefault();

    const $currencyElement = $("#investor_currency");
    let usdAmount = parseFloat($currencyElement.data("usd-amount"));

    if (isConvertedToAED) {
      // Convert back to USD
      $currencyElement.html(`<strong>$</strong>${usdAmount.toFixed(2)}`); // Set the text to the original USD amount with dollar sign
      isConvertedToAED = false; // Set the flag to indicate conversion to USD
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
<<<<<<< Updated upstream
            $("#investor_currency").text(convertAED.toFixed(2)); // Set the text to the converted amount, formatted to 2 decimal places
            $('#investor-currency').removeClass('fa-dollar-sign').addClass('fa-check');
=======
            $currencyElement.html(
              ` <strong>AED </strong>${convertAED.toFixed(2)}`
            );
>>>>>>> Stashed changes
            isConvertedToAED = true; // Set the flag to indicate conversion to AED
          }
        },
        error: function (xhr, status, error) {
          alert("An error occurred during the conversion.");
        },
      });
    }
  });
});
