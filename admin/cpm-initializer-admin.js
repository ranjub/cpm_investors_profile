jQuery(document).ready(function ($) {
  $("#cpm_investor_type").select2({
    placeholder: "Select Investor Type",
    allowClear: true,
  });

  // Initialize jQuery UI Datepicker with year view only
  $("#cpm_investor_founded")
    .datepicker({
      changeYear: true,
      showButtonPanel: true,
      dateFormat: "yy",
      beforeShow: function (input, inst) {
        var $input = $(input);
        var offset = $input.offset();
        setTimeout(function () {
          inst.dpDiv.css({
            top: offset.top + $input.outerHeight(),
            left: offset.left,
          });
        }, 10);
      },
    })
    .focus(function () {
      $(".ui-datepicker-month").hide();
      $(".ui-datepicker-calendar").hide();
    });

  // List of countries
  var countries = [
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Congo, Democratic Republic of the",
    "Congo, Republic of the",
    "Costa Rica",
    "Cote d'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "South Korea",
    "North Korea",
    "Kosovo",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "North Macedonia",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Palestine",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe",
  ];

  // Function to populate the country select
  function populateCountrySelect(selector) {
    var $select = $(selector);
    countries.forEach(function (country) {
      var option = new Option(country, country);
      $select.append(option);
    });
  }

  // Initialize Select2 for country select
  $("#cpm_investor_country").select2({
    placeholder: "Select a country",
    allowClear: true,
  });

  // Populate country select
  populateCountrySelect("#cpm_investor_country");

  // Set the selected country value
  if (typeof cpm_investor_country !== "undefined" && cpm_investor_country) {
    $("#cpm_investor_country").val(cpm_investor_country).trigger("change");
  }

  $("#cpm_investment_type").select2({
    tags: true,
    tokenSeparators: [","],
  });

  //js validation for capital(amount)
  $("#post").on("submit", function (event) {
    var capitalUSD = $("#cpm_capital_usd").val();
    var isValid =
      !isNaN(capitalUSD) &&
      capitalUSD.trim() !== "" &&
      parseFloat(capitalUSD) >= 0;

    if (!isValid) {
      event.preventDefault(); // Prevent form submission
      $("#capital_usd_error").show(); // Show error message
    } else {
      $("#capital_usd_error").hide(); // Hide error message
    }
  });
});
