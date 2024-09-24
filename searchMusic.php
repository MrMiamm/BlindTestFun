<?php
/**********************************************************************/
/**********************************************************************/
//Variables
$CACERT = $_SERVER['DOCUMENT_ROOT'].'/cacert.pem';

/**********************************************************************/
/**********************************************************************/
//Fonctions
function getCurl($url){
    //Obtenir la reponse d'une requête curl
    global $CACERT;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CAINFO, $CACERT);
    $result = curl_exec($ch);   
    curl_close($ch);
    $result = json_decode($result, true);
    return $result;
}

function searchMusicStyle($style, $nbSongs){
    //Recherche de musique par style
    $res = array(null, null, null, null);
    $urls = array();
    $songsName = array();
    $imgAlbums = array();
    $artists = array();
    $tentatives = 0;
    if ($style === 'random') {
        for ($i=0; $i < $nbSongs; $i++) { 
            do {
                $numTrack = rand(1, 1000000);
                $url = 'https://api.deezer.com/track/' . $numTrack;
                $result = getCurl($url);
                
            } while (!((isset($result['preview'])) && ($result['preview'] != '') && ($result['explicit_lyrics'] == false) && (isset($result['title']))));
            $urls[] = $result['preview'];
            $songsName[] = preg_replace('/\([^)]+\)/', '', $result['title']);     
            $imgAlbums[] = $result['album']['cover_big'];
            $artists[] = $result['artist']['name'];
        } 
        $res = array($urls, $songsName, $imgAlbums, $artists);
    } else{
        $url = 'https://api.deezer.com/search/playlist?q='.$style;
        $result = getCurl($url);
        
        if ((isset($result['data'])) && (count($result['data']) != 0)) {
            $tracklist = $result['data'][0]['tracklist'];
            $result = getCurl($tracklist);  
            $tracks = $result['data'];
            for ($i=0; $i < $nbSongs; $i++) { 
                $tentatives = 0;
                do {
                    if ($tentatives > 100) {
                        break;
                    }
                    $numTrack = rand(0, count($tracks)-1);
                    $tentatives++;
                } while (($tracks[$numTrack]['preview'] == '') || (array_search($tracks[$numTrack]['preview'], $urls) !== false));
                if ($tentatives > 100) {
                    break;
                }
                $urls[] = $tracks[$numTrack]['preview'];
                $songsName[] = preg_replace('/\([^)]+\)/', '', $tracks[$numTrack]['title']);     
                $imgAlbums[] = $tracks[$numTrack]['album']['cover_big'];
                $artists[] = $tracks[$numTrack]['artist']['name'];
            }
            if ($tentatives <= 100) $res = array($urls, $songsName, $imgAlbums, $artists);
        }
    }
    return $res;
}

function searchMusicArtist($artist, $nbSongs){
    //Recherche de musique par artiste
    $res = array(null, null, null, null);
    $urls = array();
    $songsName = array();
    $imgAlbums = array();
    $artists = array();
    $url = 'https://api.deezer.com/search/artist?q='.$artist;
    $result = getCurl($url);
    
    $tentatives = 0;
    if ((isset($result['data'])) && (count($result['data']) != 0)) {
        $tracklist = $result['data'][0]['tracklist'];
        $result = getCurl($tracklist);
        $tracks = $result['data'];

        for ($i=0; $i < $nbSongs; $i++) { 
            do {
                if ($tentatives > 100) {
                    break;
                }
                $numTrack = rand(0, count($tracks)-1);
                $tentatives++;
            } while (($tracks[$numTrack]['preview'] == '') || (array_search($tracks[$numTrack]['preview'], $urls) !== false));
            if ($tentatives > 100) {
                break;
            }
            $urls[] = $tracks[$numTrack]['preview'];
            $songsName[] = preg_replace('/\([^)]+\)/', '', $tracks[$numTrack]['title']);     
            $imgAlbums[] = $tracks[$numTrack]['album']['cover_big'];
            $artists[] = $tracks[$numTrack]['artist']['name'];
        }
        if ($tentatives <= 100) $res = array($urls, $songsName, $imgAlbums, $artists);
    }
    
    return $res;
}