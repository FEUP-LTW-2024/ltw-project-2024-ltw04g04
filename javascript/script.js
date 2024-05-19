
/* Error messsage for register */

document.addEventListener("DOMContentLoaded", function() {
    var errorPopup = document.getElementById("error-popup");

    if (errorPopup) {
        if (errorPopup.innerText.trim() !== "") {
            var errorButton = document.createElement("button");
            errorButton.classList.add("error-button");
            errorButton.innerText = errorPopup.innerText;
            document.body.appendChild(errorButton);

            setTimeout(function() {
                errorButton.remove();
            }, 5000);
        }
    }
});


function showBox() {
    var filterBox = document.getElementById('filter-box');
    var arrow = document.querySelector('.arrow');

    if (filterBox.style.display === 'none' || filterBox.style.display === '') {
        filterBox.style.display = 'block';
        arrow.innerHTML = '&#9662;';
    }
}


function hideBox() {
    var filterBox = document.getElementById('filter-box');

    if (!filterBox.contains(event.relatedTarget)) {
        filterBox.style.display = 'none';
        var arrow = document.querySelector('.arrow');
        arrow.innerHTML = '&#9652;'; 
    }
}


function toggleBox() {
    var filterBox = document.getElementById('filter-box');
    var arrow = document.querySelector('.arrow');

    if (filterBox.style.display === 'none' || filterBox.style.display === '') {
        filterBox.style.display = 'block';
        arrow.innerHTML = '&#9662;'; 
    } else {
        filterBox.style.display = 'none';
        arrow.innerHTML = '&#9652;';
    }
}


document.getElementById('filter').addEventListener('mouseover', showBox);
document.getElementById('filter').addEventListener('mouseout', hideBox);
document.getElementById('filter').addEventListener('click', toggleBox);



document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById('searchInput');
    var suggestionsDiv = document.getElementById('suggestions');

    searchInput.addEventListener('input', function() {
        var query = searchInput.value.trim();

        if (query === '') {
            suggestionsDiv.innerHTML = ''; 
            return;
        }

        fetch('../actions/action_search_suggestions.php?query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            suggestionsDiv.innerHTML = ''; 
            data.forEach(function(suggestion) {
                var suggestionElement = document.createElement('div');
                suggestionElement.textContent = suggestion;
                suggestionElement.classList.add('suggestion');
                suggestionElement.addEventListener('click', function() {
                    searchInput.value = suggestion;
                    suggestionsDiv.innerHTML = ''; 
                });
                suggestionsDiv.appendChild(suggestionElement);
            });
        })
        .catch(error => console.error('Error fetching suggestions:', error));
    });
});










