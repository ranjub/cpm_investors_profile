// jQuery(document).ready(function($) {
//     $('#search-input').on('keyup', function() {
//         var search = $(this).val();
//         if(search.length > 2) { // Trigger search after at least 3 characters
//             $.ajax({
//                 url: ajax_object.ajax_url,
//                 type: "POST",
//                 data: {action: "fetch_suggestions", query: search},
//                 success: function(response) {
//                     var suggestions = JSON.parse(response);
//                     updateSuggestions(suggestions);
//                 }
//             });
//         } else {
//             $('#suggestions-list').empty(); // Clear suggestions if no search term
//         }
//     });

//     function updateSuggestions(suggestions) {
//         var list = '<ul>';
//         $.each(suggestions, function(index, item) {
//             list += '<li>' + item + '</li>';
//         });
//         list += '</ul>';
//         $('#suggestions-list').html(list);
//     }
// });

// j

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.querySelector('#searchFilter input[type="text"]');
    var dropdown = '<?php echo $dropdown; ?>'; // Ensure this is properly escaped

    searchInput.addEventListener('focus', function() {
        var container = document.createElement('div');
        container.innerHTML = dropdown;
        this.parentNode.insertBefore(container, this.nextSibling);
    });
});
