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
            alert("Your account information isn't complete");
            return false;
        }
        document.getElementById("adress").value = "";  
        document.getElementById("city").value = "";  
        document.getElementById("country").value = "";  
        document.getElementById("postal-code").value = "";  
    } else {
        var address = document.getElementById("adress").value;
        var city = document.getElementById("city").value;
        var country = document.getElementById("country").value;
        var postalCode = document.getElementById("postal-code").value;

        if (address === "" || city === "" || country === "" || postalCode === "") {
            alert('Please fill out all the delivery form');
            return false;
        }
    }

    var cardNumber = document.getElementById('card-number').value;
    var expiryDate = document.getElementById('expiration-date').value;
    var cvv = document.getElementById('cvv').value;

    if (cardNumber.length !== 16) {
        alert('Please enter a valid card number');
        return false; 
    }

    if (expiryDate.length !== 5 || !expiryDate.match(/^\d{2}\/\d{2}$/)) {
        alert('Please enter a valid expiration date in the format MM/YY');
        return false; 
    }

    if (cvv.length !== 3) {
        alert('Please enter a valid CVV');
        return false; 
    }


    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../actions/action_process_payment.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = 'account.php';
        }
    };
    var formData = new FormData(document.querySelector('form'));
    xhr.send(formData);

    return false;
}


