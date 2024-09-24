document.addEventListener("DOMContentLoaded", function() {
/***************************************************/
//Fonctions

function playMusic() {
    document.getElementById('player').volume = 1.0;
    document.getElementById('player').loop = true;
    document.getElementById('player').muted = false;
    document.getElementById('player').playbackRate = 1.0;
    document.getElementById('player').currentTime = 0;
    document.getElementById('player').play();
}

function setupMusic(song, url) {
    let audio = document.getElementById("player");
    audio.src = url;
}

function ressemblance(a, b) {
    let nb = 0;
    //Retirer les espaces
    a = a.replace(/\s/g, '');
    b = b.replace(/\s/g, '');
    //Retirer les caractères spéciaux
    a = a.replace(/[^\w\s]/gi, '');
    b = b.replace(/[^\w\s]/gi, '');
    //Mettre en minuscule
    a = a.toLowerCase();
    b = b.toLowerCase();

    for (let i = 0; i < b.length; i++) {
        if (a[i] == b[i]) {
            nb++;
        }
    }
    let res = false;
    if (nb / b.length > 0.9) {
        res = true;
    }
    return res;
}

function startTimer(time) {
    let countdown = time;
    timer.innerHTML = "Temps restant: " + countdown;
    intervalId = setInterval(function () {
        countdown--;
        timer.innerHTML = "Temps restant: " + countdown;
        if (countdown <= 0) {
            clearInterval(intervalId);
            reponses.push(false);
            showResponse(cpt);
        }
    }, 1000);
}

function nextMusic() {
    clearInterval(intervalId);
    cpt++;
    
    if (cpt < urls.length) {
        let nbSongs = document.getElementById("nb-songs");
        nbSongs.innerHTML = "Musique: " + (cpt + 1) + "/" + songs.length;  
        setupMusic(songs[cpt], urls[cpt]);
        playMusic();
        startTimer(time);
    } else {
        endGame();
    }
}

function endGame () {
    let endDiv = document.getElementById("end-div");
    let gameDiv = document.getElementById("game-div");
    gameDiv.style.display = "none";
    endDiv.innerHTML = "<h1>Vous avez deviné " + nbPoints + " chansons sur " + songs.length + "</h1>" + endDiv.innerHTML;

    let table = document.getElementById("table-body");
    let tableDiv = document.getElementById("table-div");
    tableDiv.style.display = "block";
    for (let i = 0; i < urls.length; i++) {
        let tr = document.createElement("tr");
        let td1 = document.createElement("td");
        td1.innerText = songs[i];
        let td2 = document.createElement("td");
        td2.innerText = artists[i];
        let td3 = document.createElement("td");
        td3.innerText = reponses[i] ? "Vrai" : "Faux";
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        table.appendChild(tr);
    }
}

function showResponse(i) {
    let gameDiv = document.getElementById("game-div");
    gameDiv.style.display = "none";
    let responseDiv = document.getElementById("response-div");
    responseDiv.style.display = "block";
    let continueBtn = document.getElementById("continue");
    setTimeout(function () {
        continueBtn.focus();
    }, 1000);

    let nameText = document.getElementById("song-name");
    nameText.innerText = songs[i];
    let album = document.getElementById("album");
    album.src = imgAlbums[i];
    let artist = document.getElementById("artist");
    artist.innerText = artists[i];
}

/***************************************************/
//Variables

let playBtn = document.getElementById("playBtn");
let submitBtn = document.getElementById("submitBtn");
let continueBtn = document.getElementById("continue");
var answer = document.getElementById("answer");
let url = window.location.href;
let time = url.split("time=")[1].split("&")[0];
console.log(time);
let timer = document.getElementById("timer");
let intervalId;
var nbPoints = 0;
var cpt = 0;
var reponses = [];

/***************************************************/
//Code

submitBtn.addEventListener("click", function (e) {
    e.preventDefault();
    if (ressemblance(answer.value, songs[cpt])) {
        nbPoints++;
        reponses.push(true);
        showResponse(cpt);
    }
    answer.value = "";
});

continueBtn.addEventListener("click", function () {
    let gameDiv = document.getElementById("game-div");
    let responseDiv = document.getElementById("response-div");
    gameDiv.style.display = "block";
    responseDiv.style.display = "none";
    answer.value = "";
    answer.focus();
    
    nextMusic();
});

answer.focus();
setupMusic(songs[cpt], urls[cpt]);
playMusic();
startTimer(time);
});