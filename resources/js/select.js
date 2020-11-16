/*
 * Styling Select and option tags
 */

const select = document.getElementById("role");

select.onchange = function() {
    this.style.color = "#065661";
    this.classList.remove("thin");
    this.style.fontWeight = "bold";
};
