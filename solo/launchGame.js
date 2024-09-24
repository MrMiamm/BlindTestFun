let launchGame = document.getElementById('submitBtn');
launchGame.addEventListener('click', function(event) {
    event.preventDefault();

    let table = document.getElementById('table-style-artist');
    let form = document.getElementById('form-partie');
    if (table.children.length === 0) {
        alert('Veuillez ajouter au moins un style ou un artiste');
    } else{

        let styleInput = document.getElementById('styles');
        let artistInput = document.getElementById('artistes');

        //Récupération des styles et artistes
        let styles = [];
        let artists = [];
        for (let i = 0; i < table.rows.length; i++) {
            console.log('Row ' + i + ': ' + table.rows[i].cells[0].innerText);
            if (table.rows[i].cells[0].innerText === 'Style') {
                styles.push(table.rows[i].cells[1].innerText);
            } else {
                artists.push(table.rows[i].cells[1].innerText);
            }
        }

        //Récupération du nombre de questions
        let nbSongs = document.getElementById('nb-songs').value;

        //Récupération du temps
        let time = document.getElementById('time').value;

        //Convertion de styles et artistes en string
        styles = styles.join(',');
        artists = artists.join(',');

        //Aller sur la page de jeu avec les paramètres
        let urlGame = '/solo/game.php?';
        urlGame += 'nb-songs=' + nbSongs;
        urlGame += '&time=' + time;
        if (styles != '') urlGame += '&styles=' + styles;
        if (artists != '') urlGame += '&artistes=' + artists;

        window.location.href = urlGame;
    } 
});