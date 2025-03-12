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

    // CHECK IF USER EXISTS
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $db_password);
        $stmt->fetch();

        // VERIFY PASSWORD
        if (password_verify($password, $db_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $db_username;
            $_SESSION["success"] = "Login successful!";
            header("Location: index.php"); // IF ALL CORRECT REDIRECT TO MAIN(index.php)
            exit();
        } else {
            $_SESSION["error"] = "Invalid username or password.";
        }
    } else {
        $_SESSION["error"] = "User not found.";
    }

    $stmt->close();
    $conn->close();
    header("Location: login.php"); // REDIRECT BACK TO LOGIN(login.php)
    exit();
}
?>