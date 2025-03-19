<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $ID = $_POST['edit_id'];
  $ArtistName = mysqli_real_escape_string($conn, $_POST['artistname']);
  $SongName = mysqli_real_escape_string($conn, $_POST['songname']);
  $Genre = mysqli_real_escape_string($conn, $_POST['genre']);
  $ReleaseDate = mysqli_real_escape_string($conn, $_POST['releasedate']);
  $Streams = mysqli_real_escape_string($conn, $_POST['streams']);
  $Duration = mysqli_real_escape_string($conn, $_POST['duration']);

  $query="UPDATE songs SET artistname = '$ArtistName', 
                                 songname = '$SongName', 
                                 genre = '$Genre', 
                                 releasedate = '$ReleaseDate',
                                 streams = '$Streams',
                                 duration = '$Duration' WHERE id = $ID";

  if (mysqli_query($conn, $query)) {
    header("Location: ../index.php?status=updated");
    exit();
  } else {
    echo "Error updating record: " .mysqli_error($conn);
  }
  
  mysqli_close($conn);
}
?>