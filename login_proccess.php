<?php
session_start();
include 'database/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // CHECK IF ANY FIELD IS EMPTY
    if (empty($username) || empty($password)) {
        $_SESSION["error"] = "Username and password are required.";
        header("Location: login.php");
        exit();
    }

    // RETRIEVE USER FROM DATABASE
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
}
?>