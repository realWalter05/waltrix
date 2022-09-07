<?php
require_once './database.php';

if (isset($_GET["user_id"]) && isset($_GET["tmdb_id"])) {
    # User is logged and has approprite data
    $user_id = $_GET["user_id"];
    $tmdb_id = $_GET["tmdb_id"];
    $conn = get_conn();

    if (!isset($_GET["s"]) && !isset($_GET["e"])) {
        # It is movie

        # Delete it from watching
        $query = "DELETE FROM `watching_movies` WHERE tmdb_id=? AND user_id=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $tmdb_id, $user_id);
        $stmt->execute();        

        # Check if it exists
        $query = "SELECT EXISTS(SELECT * FROM `watched_movies` WHERE tmdb_id=? AND user_id=?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $tmdb_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!end($row)) {
            // Film row is not in database
            $query = "INSERT INTO `watched_movies` (tmdb_id, user_id) VALUES(?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $tmdb_id, $user_id);
            $stmt->execute();            
        } 
    } else {
        # It is series
        # Delete it from watching
        $query = "DELETE FROM `watching_series` WHERE tmdb_id=? AND user_id=? AND season=? AND episode=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiii", $tmdb_id, $user_id, $_GET["s"], $_GET["e"]);
        $stmt->execute(); 
        
        # Check if it exists
        $query = "SELECT EXISTS(SELECT * FROM `watched_series` WHERE tmdb_id=? AND user_id=? AND season=? AND episode=?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiii", $tmdb_id, $user_id, $_GET["s"], $_GET["e"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!end($row)) {
            // Film row is not in database
            $query = "INSERT INTO `watched_series` (tmdb_id, user_id, season, episode) VALUES(?, ?, ?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiii", $tmdb_id, $user_id, $_GET["s"], $_GET["e"]);
            $stmt->execute();            
        }         
    }

    if(isset($_GET["return"])) {
        if (isset($_GET["s"]) && isset($_GET["e"])) {
            header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=video&id=$tmdb_id&s=".$_GET["s"]."&e=".$_GET["e"]);
            exit;            
        }
        header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=video&id=$tmdb_id");
        exit;    
    }
}
