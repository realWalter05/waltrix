<?php 

function make_api_call($call) {
    $api_key = "ebc5d78d9d01fe8b66d19259d561052a";
    $url = $call."?api_key=".$api_key;

    $json = file_get_contents($url);
    $decoded = json_decode($json);
    $arr = json_decode(json_encode($decoded), true);
    return $arr;
}

function search_by_title($query) {
    $api_key = "ebc5d78d9d01fe8b66d19259d561052a";

    # Encode title to url format
    $title_url = urlencode($query);
    
    $url = "https://api.themoviedb.org/3/search/multi?api_key=$api_key&query=$title_url";
    $json = file_get_contents($url);
    $decoded = json_decode($json);
    $results = json_decode(json_encode($decoded), true);
    return($results);
}

function get_genre_from_id($id) {
    $genres = [
        "Action" => 28,
        "Adventure" => 12,
        "Animation" => 16,
        "Comedy" => 35,
        "Crime" => 80,
        "Documentary" => 99,
        "Drama" => 18,
        "Family" => 10751,
        "Fantasy" => 14,
        "History" => 36,
        "Horror" => 27,
        "Music" => 10402,
        "Mystery" => 9648,
        "Romance" => 10749,
        "Science Fiction" => 878,
        "TV Movie" => 10770,
        "Thriller" => 53,
        "War" => 10752,
        "Western" => 37,
        "Action & Adventure" => 10759,
        "Animation" => 16,
        "Comedy" => 35,
        "Crime" => 80,
        "Documentary" => 99,
        "Drama" => 18,
        "Family" => 10751,
        "Kids" => 10762,
        "Mystery" => 9648,
        "News" => 10763,
        "Reality" => 10764,
        "Sci-Fi & Fantasy" => 10765,
        "Soap" => 10766,
        "Talk" => 10767,
        "War & Politics" => 10768,
        "Western" => 37,
    ];
    $genres = array_flip($genres);
    return $genres[$id] ?? null;
}


function get_title_data($id, $type) {
    $data = make_api_call("https://api.themoviedb.org/3/$type/$id");
    return $data;
}


function get_top_movies() {
    $answer = make_api_call("https://api.themoviedb.org/3/movie/top_rated");
    $trending = [];
    foreach ($answer["results"] as $title) {
        $title_info = get_data_about_title($title);
        array_push($trending, $title_info);
    }
    return $trending;    
}


function get_series_data($id, $season, $episode) {
    $data = make_api_call("https://api.themoviedb.org/3/tv/$id/season/$season");
    return $data["episodes"];
}

function get_data_about_title($title) {
    $id =  isset($title["id"]) ? $title["id"] : "";
    $img = isset($title["backdrop_path"]) ? $title["backdrop_path"] : "";
    $media = isset($title["media_type"]) ? $title["media_type"] : "";
    if(!$media && array_key_exists("seasons", $title)) {
        $media = "tv";
    }

    if (array_key_exists("genre_ids", $title)) {
        $genres = $title["genre_ids"]; 
    } else {
        $genres = $title["genres"]; 
    }
    

    if ($media == "tv" || array_key_exists("seasons", $title)) {
        if (is_array($title["name"])) {
            $name = $title["original_name"]; 
        } else {
            $name = $title["name"]; 
        }       
        $release_full = $title["first_air_date"];
    } else {
        $name = $title["title"];
        $release_full = $title["release_date"];

    }
    $release = explode("-", $release_full)[0];            

    $title_info = [
        "name" => $name,
        "id" => $id,
        "type" => $media,
        "img" => $img,
        "genres" => $genres,
        "release" => $release,
    ];
    return $title_info;
}

function get_similar_movies($id) {
    $answer = make_api_call("https://api.themoviedb.org/3/movie/$id/recommendations");
    $trending = [];
    foreach ($answer["results"] as $title) {
        $title_info = get_data_about_title($title);
        array_push($trending, $title_info);
    }
    return $trending;    
}

function get_trending_titles($type) {
    $answer = make_api_call("https://api.themoviedb.org/3/trending/$type/week");
    $trending = [];
    foreach ($answer["results"] as $title) {
        $title_info = get_data_about_title($title);
        array_push($trending, $title_info);
    }
    return $trending;
}

function show_title($title) {
    echo("<a class='title-a' href='/?p=video&id=" . $title['id'] . (($title["type"] == "tv") ? "&s=1&e=1" : "") . "'>");
    echo("<div class='title'>");
    echo("<div>");
    echo('<div class="title-text text-center">');
    echo('<p class="mt-4 px-4">'.$title["name"].'<br/><span style="font-size: 0.7em; opacity: 0.9;">'.$title["release"].'</span></p>');
    echo('<p class="genres">');
    foreach ($title["genres"] as $genre) {
        if (is_array($genre)) {
            foreach ($genre as $g) {
                echo(get_genre_from_id($g)." ");
            }
        } else {
            echo(get_genre_from_id($genre)." ");
        }
    }
    echo('</p>');
    echo("</div>");
    echo('<img src="https://image.tmdb.org/t/p/w400/'.$title["img"].'"/>');
    echo "</div>";
    echo "</div>";
    echo "</a>";
}

function show_series_title($title, $season, $episode) {
    echo("<a class='title-a' href='/?p=video&id=" . $title['id'] . (($title["type"] == "tv") ? "&s=$season&e=$episode" : "") . "'>");
    echo("<div class='title'>");
    echo("<div>");
    echo('<div class="title-text text-center">');
    echo('<p class="mt-4 px-4">'.$title["name"].'<br/><span style="font-size: 0.7em; opacity: 0.9;">S'.$season."E".$episode.'</span></p>');
    echo('<p class="genres">');
    foreach ($title["genres"] as $genre) {
        if (is_array($genre)) {
            foreach ($genre as $g) {
                echo(get_genre_from_id($g)." ");
            }
        } else {
            echo(get_genre_from_id($genre)." ");
        }
    }
    echo('</p>');
    echo("</div>");
    echo('<img src="https://image.tmdb.org/t/p/w400/'.$title["img"].'"/>');
    echo "</div>";
    echo "</div>";
    echo "</a>";
}