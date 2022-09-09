<?php
require_once './database.php';

if (isset($_GET["registration"])) {
    $name = isset($_GET["reg-username"]) ? $_GET["reg-username"] : "";
    $email = isset($_GET["reg-email"]) ? $_GET["reg-email"] : "";
    $password = isset($_GET["reg-password"]) ? $_GET["reg-password"] : "";
    if (empty($name) || empty($email) || empty($password)) {
        # Some value not filled
        header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/?p=register&register-msg=empty_values&reg-username=$name&reg-email=$email");
        exit;        
    } else {
        # Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($hash) {
            # Prepere statement
            $conn = get_conn();

            $query = "INSERT INTO `users` (username, email, password) VALUES(?, ?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $name, $email, $hash);

            if ($stmt->execute()) {
                # Start session
                session_start();

                # Request user data
                $user_id = $conn->insert_id;
                $query = "SELECT * FROM `users` WHERE user_id=$user_id;";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    
                    $row = $result->fetch_assoc();
                    $_SESSION["user"] = $row;
                    
                    # It worked 
                    $stmt->close();
                    $conn->close();
                    header("Location: http://".$_SERVER['HTTP_HOST'].$formaction);
                    exit;   
                }               
            }
        }
        
        stmt->close();
        $conn->close();
        header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/?p=register&register-msg=system_err&reg-username=$name&reg-email=$email");
        exit;         
    }

} else {
    # Unauthorized access
    header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/?p=register&register-msg=system_err&reg-username=$name&reg-email=$email");
    exit;
}