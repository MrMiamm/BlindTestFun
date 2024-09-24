let switchCheck = document.getElementById("switch");
let styles = document.getElementById("styles");
let artistes = document.getElementById("artistes");
let switchActive = false;

function switchToggle() {
    if (switchCheck.checked) {
        switchActive = true;
        artistes.style.display = "block";
        artistes.children[1].focus();
        styles.style.display = "none";

    } else {
        switchActive = false;
        styles.style.display = "block";
        styles.children[1].focus();
        artistes.style.display = "none";
    }
}

switchToggle();
switchCheck.addEventListener("click", switchToggle);

//Submit form
let form = document.querySelector("form");
let submitBtn = document.getElementById("submitBtn");
submitBtn.addEventListener("click", function (e) {
    e.preventDefault();

    if (switchActive){
        styles.parentElement.removeChild(styles);
    } else {
        artistes.parentElement.removeChild(artistes);
    }
    form.submit();
});