<?php
require_once './database.php';

if (isset($_GET["user_id"]) && isset($_GET["tmdb_id"])) {
    # User is logged and has approprite data
    $user_id = $_GET["user_id"];
    $tmdb_id = $_GET["tmdb_id"];
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
            $query = "SELECT * FROM `watching_movies` WHERE tmdb_id=? AND user_id=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $tmdb_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo($row["watched"]);
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
            $query = "SELECT * FROM `watching_series` WHERE tmdb_id=? AND user_id=? AND season=? AND episode=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiii", $tmdb_id, $user_id, $season, $episode);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo($row["watched"]);
        }       
    }  
}