<?php 

function get_conn() {
    $conn = new mysqli("localhost","root","@A&i#159324786","waltrix");

    // Check connection
    if ($conn -> connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}