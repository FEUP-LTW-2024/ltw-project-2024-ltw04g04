

document.getElementById("accountAdressButton").addEventListener("click", function() {
    if ( ) {
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

