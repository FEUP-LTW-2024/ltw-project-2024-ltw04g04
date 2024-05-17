document.getElementById('printButton').addEventListener('click', function() {
    window.print();
});

document.getElementById('goBackButton').addEventListener('click', function() {
    window.location.href = "../pages/account.php";
});