<?php
require_once './database.php';

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