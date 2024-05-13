var accountAdress = false;

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleAdressButton');

    toggleButton.addEventListener('click', function() {
        this.classList.toggle('selected');
        if (this.classList.contains('selected')) {
            accountAdress = true;
        } else {
            accountAdress = false;
        }
    });
});

document.getElementById("accountAdressButton").addEventListener("click", function() {
    if ( true ) {
        window.location.href = "...";
    } else {
        console.log("Condição não cumprida.");
    }
});


document.getElementById("otherAdressButton").addEventListener("click", function() {
    var adress = document.getElementById("adress").value;
    var city = document.getElementById("city").value;
    var country = document.getElementById("country").value;
    var postalCode = document.getElementById("postal-code").value;

    if (adress === "" || city === "" || country === "" || postalCode === "") {
        window.location.href = "...";
    } else {
        console.log("Condição não cumprida.");
    }
});

