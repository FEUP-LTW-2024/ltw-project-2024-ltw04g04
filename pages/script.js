
/* Error messsage for register*/

document.addEventListener("DOMContentLoaded", function() {
    var errorPopup = document.getElementById("error-popup");

    if (errorPopup.innerText.trim() !== "") {
        var errorButton = document.createElement("button");
        errorButton.classList.add("error-button");
        errorButton.innerText = errorPopup.innerText;
        document.body.appendChild(errorButton);

        setTimeout(function() {
            errorButton.remove();
        }, 5000);
    }
});





