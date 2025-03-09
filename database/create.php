<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ArtistName = $_POST['ArtistName'];
    $SongName = $_POST['SongName'];
    $Genre = $_POST['Genre'];
    $ReleaseDate = $_POST['ReleaseDate'];
    $Streams = $_POST['Streams'];
    $Duration = $_POST['Duration'];

    $sql = "INSERT INTO songs (artistname, songname, genre, releasedate, streams, duration) 
            VALUES('$ArtistName', '$SongName', '$Genre', '$ReleaseDate', '$Streams', '$Duration')";  

    if (mysqli_query($conn, $sql)) 
    {
       $status = "Success";
    } else {
        $status = "Success";
    }

    mysqli_close($conn);
    header("Location: ../index.php?status=$status");
    exit();
}       
?>