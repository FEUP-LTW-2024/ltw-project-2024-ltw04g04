
/* Error messsage for register*/


document.addEventListener("DOMContentLoaded", function() {
    var errorPopup = document.getElementById("error-popup");

    if (errorPopup) { // Check if element exists
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


// Função para mostrar a caixa de filtro e inverter a seta quando o mouse passa por cima
function showBox() {
    var filterBox = document.getElementById('filter-box');
    var arrow = document.querySelector('.arrow');

    if (filterBox.style.display === 'none' || filterBox.style.display === '') {
        filterBox.style.display = 'block';
        arrow.innerHTML = '&#9662;'; // Inverte a seta para cima
    }
}

// Função para ocultar a caixa de filtro quando o mouse sai de cima da seta
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

var filterElement = document.getElementById('filter');
if (filterElement) {
    filterElement.addEventListener('mouseover', showBox);
    filterElement.addEventListener('mouseout', hideBox);
    filterElement.addEventListener('click', toggleBox);
}



function toggleMenu() {
    var menu = document.getElementById("menu");
    if (menu.style.maxHeight === "0px" || menu.style.maxHeight === "") {
        menu.style.display = "flex";
        menu.style.maxHeight = menu.scrollHeight + "px";
    } else {
        menu.style.maxHeight = "0px";
        setTimeout(() => {
            menu.style.display = "none";
        }, 300); // Wait for the transition to end before setting display to none
    }
}


/*function toggleMenu() {
    var menu = document.getElementById("menu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}*/



/*document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("hamburger-menu").addEventListener("click", function() {
        var menu = document.getElementById("menu");
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    });
});*/













