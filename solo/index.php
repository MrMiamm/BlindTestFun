<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles.css">
    <title>Blind Test Solo</title>
</head>
<body>
    <div id="bg-gradient"></div>
    <button href="" class="btn" id="go-back">Retour</button>
    <section>
        <h1>Blind Test Solo</h1>
        <article class="translucent" id="modes">
            <h2>Ajouter Style/Artiste</h2>
            <form>
                <div id="toggle-div">
                    <div id="styles">
                        <label for="style">Mode: Type de musique</label>
                        <input name="style" id="style" placeholder="Ex: random, electro...">
                    </div>
                    <div id="artistes">
                        <label for="artiste">Mode: Artiste</label>
                        <input name="artiste" id="artiste" placeholder="Ex: avicii, mozart...">
                    </div>
                    <div>
                        <input type="checkbox" id="switch"/>
                        <label for="switch"></label>
                    </div>
                </div>
                <input class="btn" id="submitStyleBtn" type="submit" value="Ajouter">
            </form>
        </article>
        <article class="translucent">
            <h2>Partie</h2>
            <div id="form-partie" class="form">
                <div>
                    <label for="nb-songs">Nombre de chansons</label>
                    <input required type="number" name="nb-songs" id="nb-songs" value="10" min="1" max="100">
                </div>
                <div>
                    <label for="time">Temps de réponse</label>
                    <input required type="number" name="time" id="time" value="10" min="5" max="30">
                </div>
                <input class="btn" id="submitBtn" type="submit" value="Jouer">
            </div>            
        </article>
        <table class="translucent" id="table-style-artist">

        </table>
    </section>
    <script src="/js/go-back.js"></script>
    <script src="switch.js"></script>
    <script src="addStyleArtist.js"></script>
    <script src="launchGame.js"></script>
</body>
</html>