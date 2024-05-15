var accountAddressSelected = false;
var accountAddressComplete; 

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleAdressButton');

    toggleButton.addEventListener('click', function() {
        this.classList.toggle('selected');
        accountAddressSelected = this.classList.contains('selected');
    });
});

function validateAndSubmitForm(event) {
    event.preventDefault();

    if (accountAddressSelected && !accountAddressComplete) {
        alert("Your account information isn't complete");
        return false;
    }

    if (!accountAddressSelected) {
        var address = document.getElementById("address").value;
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

    openPrintWindow();
}

function openPrintWindow() {
    const form = document.getElementById('paymentForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    const printWindow = window.open('../actions/action_process_payment.php?' + params, '_blank');
    printWindow.focus();
}


