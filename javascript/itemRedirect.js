function redirectToItemPage(itemId, csrf) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "../actions/action_process_item.php");

    var verif = document.createElement("input");
    verif.setAttribute("type", "hidden");
    verif.setAttribute("name", "csrf");
    verif.setAttribute("value", csrf);

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "item-id");
    input.setAttribute("value", itemId);

    form.appendChild(verif);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}