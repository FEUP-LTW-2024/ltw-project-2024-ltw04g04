var accountAddressSelected = false;
var accountAddressComplete; 

document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleAdressButton');

    toggleButton.addEventListener('click', function() {
        this.classList.toggle('selected');
        accountAdressSelected = this.classList.contains('selected');
    });

});



function validatePaymentForm() {
    const address = document.getElementById('adress').value.trim();
    const city = document.getElementById('city').value.trim();
    const country = document.getElementById('country').value.trim();
    const postalCode = document.getElementById('postal-code').value.trim();
    const cardNumber = document.getElementById('card-number').value.trim();
    const expirationDate = document.getElementById('expiration-date').value.trim();
    const cvv = document.getElementById('cvv').value.trim();

    if (cardNumber.length !== 16 || isNaN(cardNumber)) {
        alert('Please enter a valid card number.');
        return false;
    }

    if (expirationDate.length !== 5 || !expirationDate.match(/^\d{2}\/\d{2}$/)) {
        alert('Please enter a valid expiration date in the format MM/YY.');
        return false;
    }

    if (cvv.length !== 3 || isNaN(cvv)) {
        alert('Please enter a valid CVV.');
        return false;
    }

    return true;
}



