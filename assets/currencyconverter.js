jQuery(document).ready(function ($) {
  $("#onclick-exchange").on("click", function (e) {
    e.preventDefault();

    var usdAmount = $('input[name="usd_amount"]').val(); // Get the USD amount from the input field

    // Check if the conversion has already been done
    if ($(this).data("converted")) {
      return;
    }
    var apiKey = "cur_live_w0ZN0pU4HqBYB2igmVBewxY1adPfTlVsbXgCQLM6"; // Your API key
    var apiUrl = `https://api.currencyapi.com/v3/latest?apikey=cur_live_UdOuQQk8O1sOO6ndGXq5TmHdDnCEO3ZhKcfURalU`; // Correct API URL

    $.ajax({
      url: apiUrl,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.data && response.data.AED) {
          var conversionRate = response.data.AED.value;
          //   console.log(conversionRate);
          var convertAED = usdAmount * conversionRate;
          //   console.log(convertAED);
          const changeText = document.querySelector("#investor_currency").value;
          //   console.log(changeText);
          $("#investor_currency").val(convertAED.toFixed(2)); // Set the value to the converted amount, formatted to 2 decimal places

          // Set the flag to indicate conversion has been done
          $("#onclick-exchange").data("converted", true);
        }
      },
      error: function (xhr, status, error) {
        alert("An error occurred during the conversion.");
      },
    });
  });
});
