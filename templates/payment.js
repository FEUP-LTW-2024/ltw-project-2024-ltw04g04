var accountAdressSelected = false;
var accountAdressComplete;

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleAdressButton');

    toggleButton.addEventListener('click', function() {
        this.classList.toggle('selected');
        if (this.classList.contains('selected')) {
            accountAdressSelected = true;
        } else {
            accountAdressSelected = false;
        }
    });
});

function validatePaymentForm() {
    if (accountAdressSelected) {
        if (!accountAdressComplete) { 
            // 'Your account information isn't complete'
            return false;
        }
        document.getElementById("adress").value = "";  
        document.getElementById("city").value = "";  
        document.getElementById("country").value = "";  
        document.getElementById("postal-code").value = "";  
    } else {
        var adress = document.getElementById("adress").value;
        var city = document.getElementById("city").value;
        var country = document.getElementById("country").value;
        var postalCode = document.getElementById("postal-code").value;

        // 'Please fill out all the delivery form'
        if (adress === "" || city === "" || country === "" || postalCode === "") {
            return false;
        }
    }

    var cardNumber = document.getElementById('card-number').value;
    var expiryDate = document.getElementById('expiry-date').value;
    var cvv = document.getElementById('cvv').value;

    if (cardNumber.length !== 16) {
        // 'Please enter a valid card number'
        return false; 
    }

    if (expiryDate.length !== 5 || !expiryDate.match(/^\d{2}\/\d{2}$/)) {
        // 'Please enter a valid expiration date in the format MM/YY'
        return false; 
    }

    if (cvv.length !== 3) {
        //'Please enter a valid CVV'
        return false; 
    }

    return true;
}

