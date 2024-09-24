<?php 
    session_start(); 
    set_time_limit(0);
    if (!isset($_GET['nb-songs']) || !isset($_GET['time']) || (!isset($_GET['styles']) && !isset($_GET['artistes']))) {
        header('Location: /solo/');
    } else {
        $nbSongs = intval($_GET['nb-songs']);
        $nbSongsActuel = 0;
        $time = $_GET['time'];
        $urls = array();
        $songsName = array();
        $imgAlbums = array();
        $artistsNames = array();
        $artists = array();
        $styles = array();

        include($_SERVER['DOCUMENT_ROOT'].'/searchMusic.php');

        if (isset($_GET['styles']) && $_GET['styles'] != '') {
            $styles = str_replace(' ', '-', $_GET['styles']);
            $styles = explode(',', $styles);
            foreach ($styles as $key => $value) {
                $styles[$key] = strtolower($value);
            }
        } 
        if (isset($_GET['artistes']) && $_GET['artistes'] != '') {
            $artists = str_replace(' ', '-', $_GET['artistes']);
            $artists = explode(',', $artists);
            foreach ($artists as $key => $value) {
                $artists[$key] = strtolower($value);
            }
        }

        foreach ($styles as $style) {
            $nbSongsActuel += random_int(1, intval(($nbSongs - $nbSongsActuel) / (count($styles) + count($artists))));
            [$urls[], $songsName[], $imgAlbums[], $artistsNames[]] = searchMusicStyle($style, $nbSongsActuel);
        }

        foreach ($artists as $artist) {
            $nbSongsActuel += random_int(1, intval(($nbSongs - $nbSongsActuel) / (count($styles) + count($artists))));
            [$urls[], $songsName[], $imgAlbums[], $artistsNames[]] = searchMusicArtist($artist, $nbSongsActuel);
        }

        $urls = array_merge(...$urls);
        $songsName = array_merge(...$songsName);
        $imgAlbums = array_merge(...$imgAlbums);
        $artistsNames = array_merge(...$artistsNames);

        if ($urls == null) {
            header('Location: /solo/');
        }
    } 
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
    <button class="btn" id="go-back">Quitter</button>

    <div id="game-div" class="translucent">
        <h2 id="timer">Temps restant: </h2>
        <form action="">
            <input type="text" id="answer">
            <button class="btn" id="submitBtn">Valider</button>
        </form>
    </div>
    <div id="infos-div" class="translucent">
        <?php if (isset($styles)): $stylesStr = implode(',',$styles) ?>
            <h2 id="style">Style: <?php echo ucfirst($stylesStr); ?></h2>
        <?php else: $artistsStr = implode(',',$artists) ?>
            <h2 id="style">Artiste: <?php echo ucfirst($artistsStr); ?></h2>
        <?php endif; ?>
        <h2 id="nb-songs">Musique: 1/<?php echo $nbSongs; ?></h2>
    </div>
    <div id="response-div" class="translucent">
        <img src="" alt="" id="album">
        <h1 id="song-name"></h1>
        <h2 id="artist"></h2>
        <button id="continue" class="btn">Continuer</button>
    </div>
    <div id="end-div">
        <div id="table-div" class="translucent">
            <table>
                <thead>
                    <tr>
                        <th>Chanson</th>
                        <th>Artiste</th>
                        <th>Reponse</th>
                    </tr>
                </thead>
                <tbody id="table-body"></tbody>
            </table>
        </div>
    </div>
    <audio id="player" src=""></audio>

    <script src="/js/go-back.js"></script>
    <?php if (isset($urls)): ?>
        <script>
            var urls = <?php echo json_encode($urls); ?>;
            var songs = <?php echo json_encode($songsName); ?>;
            var imgAlbums = <?php echo json_encode($imgAlbums); ?>;
            var artists = <?php echo json_encode($artistsNames); ?>;
        </script>
        <script src="game.js"></script>
    <?php endif; ?>
</body>
</html>