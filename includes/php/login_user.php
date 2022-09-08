<?php
require_once './database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET["login"])) {
    $email = isset($_GET["log-email"]) ? $_GET["log-email"] : "";
    $password = isset($_GET["log-password"]) ? $_GET["log-password"] : "";
    if (empty($email) || empty($password)) {
        # Some value not filled
        header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=register&login-msg=empty_values&log-email=$email");
        exit;        
    } else {
            $conn = get_conn();

            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (password_verify($password, $row["password"])) {
                # Start session
                session_start();

                $_SESSION["user"] = $row;
                if(isset($_GET["remember-me"])) {
                    # Store login token to cookie
                    $random_hash = password_hash($row["user_id"] + microtime(), PASSWORD_DEFAULT);
                    setcookie("cookie_token", $random_hash);

                    # Insert its hash into the database
                    $hash = password_hash($random_hash, PASSWORD_DEFAULT);
                    $query = "UPDATE `users` SET cookie_token=? WHERE user_id=?;";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $hash, $row["user_id"]);
                    $stmt->execute();
                }

                # Password correct 
                $stmt->close();
                $conn->close();
                header("Location: http://".$_SERVER['HTTP_HOST'].$formaction);
                exit;   
            } else {
                $stmt->close();
                $conn->close();
                header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=register&login-msg=wrong_pwd&log-email=$email");
                exit;
            }
        
        stmt->close();
        $conn->close();
        header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=register&login-msg=system_err&log-email=$email");
        exit;         
    }

} else {
    # Unauthorized access
    header("Location: http://".$_SERVER['HTTP_HOST'].$formaction."/index.php?p=register&login-msg=system_err&log-email=$email");
    exit;
}