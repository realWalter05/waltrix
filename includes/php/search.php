<?php
require_once './tmdb_api.php';

if (isset($_GET["query"])) {
	$results = search_by_title($_GET["query"])["results"];
    $html_code = "";
    foreach ($results as $result) {
        $title = get_data_about_title($result);
        if (!$title["img"])
            continue;        
        $html_code = $html_code."<a class='title-a' href='/index.php?p=video&id=" . $title['id'] . (($title["type"] == "tv") ? "&s=1&e=1" : "") . "'>";
        $html_code = $html_code."<div class='title'>";
        $html_code = $html_code."<div>";
        $html_code = $html_code.'<div class="title-text text-center">';
        $html_code = $html_code.'<p class="mt-4 px-4">'.$title["name"].'<br/><span style="font-size: 0.7em; opacity: 0.9;">'.$title["release"].'</span></p>';
        $html_code = $html_code.'<p class="genres">';
        foreach ($title["genres"] as $genre) {
            if (is_array($genre)) {
                foreach ($genre as $g) {
                    $html_code = $html_code.get_genre_from_id($g)." ";
                }
            } else {
                $html_code = $html_code.get_genre_from_id($genre)." ";
            }
        }
        $html_code = $html_code.'</p>';
        $html_code = $html_code."</div>";
        $html_code = $html_code.'<img src="https://image.tmdb.org/t/p/w400/'.$title["img"].'"/>';
        $html_code = $html_code."</div>";
        $html_code = $html_code."</div>";
        $html_code = $html_code."</a>";
    }
    echo(json_encode($html_code));
}		
?>