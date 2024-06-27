jQuery(document).ready(function ($) {
  $("#investor_type, #cpm_investor_type").select2({
    placeholder: "Select Investor Type",
    allowClear: true,
  });

  // Initialize jQuery UI Datepicker with year view only
  $("#cpm_investor_founded, #investor_founded")
    .datepicker({
      changeYear: true,
      showButtonPanel: true,
      dateFormat: "yy",
      onClose: function (dateText, inst) {
        $(this).datepicker("setDate", new Date(inst.selectedYear, 1));
      },
    })
    .focus(function () {
      $(".ui-datepicker-month").hide();
      $(".ui-datepicker-calendar").hide();
    });
});

//for drop down list of countries
jQuery(document).ready(function ($) {
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
    "Korea, North",
    "Korea, South",
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

  function populateCountrySelect(selector) {
    var $select = $(selector);
    countries.forEach(function (country) {
      var option = new Option(country, country);
      $select.append(option);
    });
  }

  // Apply select2 to the necessary fields with appropriate placeholders
  $("#investor_type").select2({
    placeholder: "Select Investor Type",
    allowClear: true,
  });

  $("#cpm_investor_type").select2({
    placeholder: "Select Investor Type",
    allowClear: true,
  });

  $("#investor_country").select2({
    placeholder: "Select a country",
    allowClear: true,
  });

  $("#cpm_investor_country").select2({
    placeholder: "Select a country",
    allowClear: true,
  });

  $("#investment_type").select2({
    tags: true,
    tokenSeparators: [",", " "],
    placeholder: "Select Investment Type",
  });
  $("#cpm_investment_type").select2({
    tags: true,
    tokenSeparators: [",", " "],
    placeholder: "Select Investment Type",
  });
  //   $("#investment_type").select2({
  //     tags: true,
  //     placeholder: "Select Investment Type",
  //   });

  //   $("#cpm_investment_type").select2({
  //     tags: true,
  //     placeholder: "Select Investment Type",
  //   });

  // Populate country select field in the frontend form
  populateCountrySelect("#investor_country");

  // Populate country select field in the backend form
  populateCountrySelect("#cpm_investor_country");

  // Set the selected value in the backend form
  if (typeof cpm_investor_country !== "undefined") {
    $("#cpm_investor_country").val(cpm_investor_country).trigger("change");
  }
});
