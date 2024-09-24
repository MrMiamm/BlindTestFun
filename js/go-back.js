let backBtn = document.getElementById("go-back");



backBtn.addEventListener("click", (e) => {
    e.preventDefault();
    window.history.back();
});

