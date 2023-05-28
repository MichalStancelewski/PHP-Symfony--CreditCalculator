function toggle(divID, button) {
    var element = document.getElementById(divID);
    if (element.style.display === "none") {
        element.style.display = "block";
        button.innerHTML = "Less details &#45;"
    } else {
        element.style.display = "none";
        button.innerHTML = "More details &#43;"
    }
}