<?php
require_once './database.php';

if (isset($_GET["user_id"]) && isset($_GET["tmdb_id"]) && isset($_GET["watched"])) {
    # User is logged and has approprite data
    $user_id = $_GET["user_id"];
    $tmdb_id = $_GET["tmdb_id"];
    $watched = $_GET["watched"];
    $conn = get_conn();

    if (!isset($_GET["s"]) && !isset($_GET["e"])) {
        # It is movie
        $query = "SELECT EXISTS(SELECT * FROM `watching_movies` WHERE tmdb_id=? AND user_id=?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $tmdb_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (end($row) == 1) {
            # Row is already there
            $query = "UPDATE `watching_movies` SET watched=? WHERE tmdb_id=? AND user_id=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $watched, $tmdb_id, $user_id);
            $stmt->execute();
        } else {
            # Row is not there
            $query = "INSERT INTO `watching_movies` (tmdb_id, user_id, watched) VALUES(?, ?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $tmdb_id, $user_id, $watched);
            $stmt->execute();    
        }
    } else {
        # It is series
        $season = $_GET["s"];
        $episode = $_GET["e"];

        # Check if it exists
        $query = "SELECT EXISTS(SELECT * FROM `watching_series` WHERE tmdb_id=? AND user_id=? AND season=? AND episode=?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiii", $tmdb_id, $user_id, $season, $episode);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (end($row) == 1) {
            # Row is already there
            $query = "UPDATE `watching_series` SET watched=? WHERE tmdb_id=? AND user_id=? AND season=? AND episode=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiii", $watched, $tmdb_id, $user_id, $season, $episode);
            $stmt->execute();
        } else {
            # Row is not there
            $query = "INSERT INTO `watching_series` (tmdb_id, user_id, season, episode, watched) VALUES(?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiii", $tmdb_id, $user_id, $season, $episode, $watched);
            $stmt->execute();    
        }        
    }  
}
