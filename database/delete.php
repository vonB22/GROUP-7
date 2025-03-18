<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $ID = $_POST['delete_id'];

    $query = "DELETE FROM songs WHERE id = $ID";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?status=deleted");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>