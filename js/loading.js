let loadingDiv = document.createElement("div");
loadingDiv.id = "loading";
let loadingText = document.createElement("h1");
loadingText.innerHTML = "Loading...";
loadingDiv.appendChild(loadingText);
document.body.appendChild(loadingDiv);

document.addEventListener("DOMContentLoaded", function() {
    document.body.removeChild(document.getElementById("loading"));
});