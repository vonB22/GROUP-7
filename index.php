<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database\database.php');
  include('database\search.php');

  $ArtistName = "";
  $SongName = "";
  $Genre = "";
  $ReleaseDate = "";
  $Streams = "";
  $Duration = "";

// PAGINATION
 $limit = 5;
 $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
 $start = ($page - 1) * $limit; // TO CALCULATE STARTING POINT

 // TO GET SEARCH VALUE
 $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : ""; 

 if (!empty($search)) {
     // SEARCH QUERY WITH PAGINATION
     $query = "SELECT * FROM songs 
               WHERE ArtistName LIKE '%$search%' 
               OR SongName LIKE '%$search%' 
               OR Genre LIKE '%$search%' 
               LIMIT $start, $limit";
     
     // COUNT TOTAL SEARCH RESULTS
     $count_query = "SELECT COUNT(*) as total FROM songs 
                     WHERE ArtistName LIKE '%$search%' 
                     OR SongName LIKE '%$search%' 
                     OR Genre LIKE '%$search%'";
 } else {
     // DEFAULT QUERY IF NO SEARCH
     $query = "SELECT * FROM songs LIMIT $start, $limit";
     $count_query = "SELECT COUNT(*) as total FROM songs";
 }

 // EXECUTE QUERIES
 $query_run = mysqli_query($conn, $query);
 $result = mysqli_query($conn, $count_query);
 $row = mysqli_fetch_assoc($result);
 $total_records = $row['total'];
 $total_pages = ceil($total_records / $limit);

?>


  <!-- Main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1 class="text-dark fw-bold">
        <img src="assets/img/spotify-logo-dark.png" alt="" class="img-fluid" style="width: 40px; height: 40px;">
          Spotify Data Management System
      </h1>
      <nav>
        <ol class="breadcrumb fw-normal p-1">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">General</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!---------------------------------- Table Section ------------------------------------------->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title fw-bold text-dark">Songs Table</h5>
                </div>
                <div>
                  <a href="#"> <!-- Add button trigger (data-bs-toggle="modal" data-bs-target="#staticBackdrop") -->
                    <button class="btn btn-dark btn-sm mt-3 mx-3" title="Add" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <a href="#" class="icons"><i class="fa-regular fa-square-plus text-white fs-6 pe-1"></i></a>Add Songs</button>
                  </a>
                </div>
              </div>


              <?php
                // USE SEARCH QUERY FROM search.php
                if (!empty($search)) {
                    $query_run = mysqli_query($conn, $query);
                } else {
                    $query = "SELECT * FROM songs LIMIT $start, $limit";
                    $query_run = mysqli_query($conn, $query);
                }
              ?>


              <!-- Table -->
              <table class="table">
                <thead>
                  <tr class="table-dark">
                    <th scope="col">ID</th>
                    <th scope="col">Artist Name</th>
                    <th scope="col">Song Name</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Release Date</th>
                    <th scope="col">Streams</th>
                    <th scope="col">Duration</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    if($query_run) {
                    foreach($query_run as $row) {
                  ?> 

                  <tr>
                    <td> <strong> <?php echo $row['ID']; ?> </strong> </td>
                    <td> <?php echo $row['ArtistName']; ?> </td>
                    <td> <?php echo $row['SongName']; ?> </td>
                    <td> <?php echo $row['Genre']; ?> </td>
                    <td> <?php echo $row['ReleaseDate']; ?> </td>
                    <td> <?php echo $row['Streams']; ?> </td>
                    <td> <?php echo $row['Duration']; ?> </td>
                    <td class="d-flex justify-content-center">

                      <!-- Edit Button -->
                      <button class="btn btn-sm mx-1 bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#editInfo">
                        <i class="fa-solid fa-pen-to-square text-dark fs-6" title="Edit"></i>
                      </button>
                      
                      <!-- View Button -->
                      <button class="btn btn-sm mx-1 bg-transparent border-0" title="View details" data-bs-toggle="modal" data-bs-target="#viewInfo">
                        <i class="fa-solid fa-eye text-dark fs-6" title="View"></i>
                      </button>

                      <!-- Delete Button -->
                      <button class="btn btn-danger btn-sm mx-1 bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#DeleteInfo">
                        <i class="fa-solid fa-trash text-danger fs-6" title="Delete"></i>
                      </button>

                    </td>
                  </tr>              
                </tbody>

                  <?php    
                      }
                    } else {
                      echo "<tr><td colspan='8' class='text-center'>No Resuts Found</td></tr>";
                    }
                   ?>

              </table>
            </div>

            <!-- Pagination -->
            <div class="mx-4">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?> ">
                    <a class="page-link text-dark" href="?page=<?php echo max(1, $page - 1); ?>&search=<?php echo urlencode($search); ?> ">
                      <i class="fa-solid fa-arrow-left text-dark fs-6 pe-1"></i> Previous
                    </a>
                  </li>

                  <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php if ($page == $i) echo 'active'; ?> ">
                      <a class="page-link <?php echo ($page == $i) ? 'bg-dark text-white border-dark' : 'text-dark'; ?> " 
                        href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search);  ?>">
                        <?php echo $i; ?>
                      </a>
                    </li>
                  <?php } ?>  

                  <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?> ">
                    <a class="page-link text-dark" href="?page=<?php echo min($total_pages, $page + 1); ?>&search=<?php echo urlencode($search); ?>"> 
                      Next <i class="fa-solid fa-arrow-right text-dark fs-6 pe-1"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div><!-- End Pagination -->
          </div>
        </div>
      </div>
    </section>
    <!-- End Table Section -->


    <!---------------------------------- Edit Modal ---------------------------------------------->
    <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
      <div class="modal-dialog pt-5">
        <div class="modal-content" style="background-color: #166d3b;
                                          background: linear-gradient( 314deg, #166d3b 0%, #000000 74%);">

          <div class="modal-header  border-0">
            <img src="assets/img/spotify-logo01.png" alt="" class="img-fluid" style="width: 150px; height: 40px;">
            <h5 class="modal-title fw-bold ps-3" id="staticBackdropLabel" style="color: white;">Edit Song Details</h5>
            <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
          </div>


          <div class="modal-body" style="color: white;">
            <form action="database/update.php" method="POST" class="row g-3">
              <input type="hidden" id="edit_id" name="edit_id">

              <div class="col-md-6">
                <label for="artistname" class="col-form-label">Artist Name:</label>
                <input type="text" class="form-control form-control-sm" id="artistname" name="artistname" style="font-weight: 600;">
              </div>

              <div class="col-md-6">
                <label for="songname" class="col-form-label">Song Name:</label>
                <input type="text" class="form-control form-control-sm" id="songname" name="songname" style="font-weight: 600;">
              </div>

              <div class="col-md-6">
                <label for="genre" class="form-label">Genre:</label>
                <input type="text" class="form-control form-control-sm" id="genre" name="genre" style="font-weight: 600;">
              </div>

              <div class="col-md-6">
                <label for="releasedate" class="form-label">Release Date:</label>
                <input type="text" class="form-control form-control-sm" id="releasedate" name="releasedate" style="font-weight: 600;">
              </div>

              <div class="col-md-6">
                <label for="streams" class="form-label">Streams:</label>
                <input type="text" class="form-control form-control-sm" id="streams" name="streams" style="font-weight: 600;">
              </div>

              <div class="col-md-6">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control form-control-sm" id="duration" name="duration" style="font-weight: 600;">
              </div>

              <div class="modal-footer bg-transparent border-0">
                <button type="button" class="btn border-danger" style="background-color: rgb(184, 0, 0); color: rgb(255, 255, 255);" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn border-success" name="update" style="background-color: rgb(11, 153, 42); color: rgb(255, 255, 255);">Save Changes</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div><!---- End Edit Modal ---->


    <!---------------------------------- View Modal ---------------------------------------------->
    <div class="modal fade" id="viewInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewInfoLabel" aria-hidden="true">
      <div class="modal-dialog pt-5">
        <div class="modal-content pb-2" style="background-color: #166d3b;
                                               background: linear-gradient( 314deg, #166d3b 0%, #000000 74%);">

          <div class="modal-header border-0">
            <img src="assets/img/spotify-logo01.png" alt="" class="img-fluid" style="width: 150px; height: 40px;">
            <h5 class="modal-title fw-bold ps-4" id="staticBackdropLabel" style="color: white;">View Mode</h5>
            <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <?php
          if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong>$errorMessage</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
            </div>
            ";
          }

          ?>

          <div class="modal-body" style="color: white;">
            <form action="" class="row g-3">

              <div class="col-md-6">
                <label for="artistname" class="col-form-label">Artist Name:</label>
                <input type="text" class="form-control form-control-sm" id="view_artistname" style="font-weight: 600; background-color:rgba(248, 249, 250, 0.79);"  name="artistname" disabled>
              </div>

              <div class="col-md-6">
                <label for="songname" class="col-form-label">Song Name:</label>
                <input type="text" class="form-control form-control-sm" id="view_songname" style="font-weight: 600; background-color:rgba(248, 249, 250, 0.79);" name="songname" disabled>
              </div>

              <div class="col-md-6">
                <label for="genre" class="form-label">Genre:</label>
                <input type="text" class="form-control form-control-sm" id="view_genre" style="font-weight: 600; background-color: rgba(248, 249, 250, 0.79);" name="genre" disabled>
              </div>

              <div class="col-md-6">
                <label for="releasedate" class="form-label">Release Date:</label>
                <input type="text" class="form-control form-control-sm" id="view_releasedate" style="font-weight: 600; background-color: rgba(248, 249, 250, 0.79);" name="releasedate" disabled>
              </div>

              <div class="col-md-6">
                <label for="streams" class="form-label">Streams:</label>
                <input type="text" class="form-control form-control-sm" id="view_streams" style="font-weight: 600; background-color: rgba(248, 249, 250, 0.79);" name="streams" disabled>
              </div>

              <div class="col-md-6">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control form-control-sm" id="view_duration" style="font-weight: 600; background-color: rgba(248, 249, 250, 0.79);" name="duration" disabled>
              </div>

              <!-- close button -->
              <div class="modal-footer bg-transparent border-0" style="padding-bottom: 1px; margin-bottom: 0;">
                  <button type="button" class="btn border-danger" role="button" style="background-color: rgb(184, 0, 0); color: rgb(255, 255, 255);" data-bs-dismiss="modal">Close</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div><!---- End View Modal ---->


     <!--------------------------------- Delete Modal -------------------------------------------->
     <div class="modal fade" id="DeleteInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DeleteInfoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #166d3b;
                                          background: linear-gradient( 314deg, #166d3b 0%, #000000 74%);">

          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold fs-1 text-danger" style="padding-left: 210px; color: white;" id="staticBackdropLabel">
              <i class="fa-solid fa-circle-exclamation" style="color: rgb(255, 0, 0);"></i>
            </h5>
            <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form action="database/delete.php" method="POST" class="row g-3">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <h4 class="fs-5 text-center" style="color: white;"> Do you really want to delete this Song?</h4>
            </div>
          
            <!-- buttons -->
            <div class="modal-footer bg-transparent border-0">
              <button type="button" class="btn border-danger" href="" role="button" style="background-color: rgb(184, 0, 0); color: rgb(255, 255, 255);" data-bs-dismiss="modal">No</button>
              <button type="submit" class="btn border-success" name="btn" href="" role="button" style="background-color: rgb(11, 153, 42); color: rgb(255, 255, 255);">Yes</button>
            </div>
          </form>

        </div>
      </div>
    </div><!--- End Delete Modal --->

    <!----------------------------------- Add Modal ---------------------------------------------->
    <form action="database/create.php" method="POST">
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog pt-5">
          <div class="modal-content" style="background-color: #166d3b;
                                            background: linear-gradient( 314deg, #166d3b 0%, #000000 74%);">

            <div class="modal-header border-0">
              <img src="assets/img/spotify-logo01.png" alt="" class="img-fluid" style="width: 150px; height: 40px;">
                <h5 class="modal-title fw-bold ps-5" id="staticBackdropLabel" style="color: white;">Add Songs</h5>
              <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="color: white;">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="artistname" class="col-form-label">Artist Name:</label>
                  <input type="text" class="form-control form-control-sm" id="artistname" name="ArtistName" style="font-weight: 600;" value="<?php echo $ArtistName; ?>">
                </div>

                <div class="col-md-6">
                  <label for="songname" class="col-form-label">Song Name:</label>
                  <input type="text" class="form-control form-control-sm" id="songname" name="SongName" style="font-weight: 600;" value="<?php echo $SongName; ?>">
                </div>

                <div class="col-md-6">
                  <label for="genre" class="form-label">Genre:</label>
                  <input type="text" class="form-control form-control-sm" id="genre" name="Genre" style="font-weight: 600;" value="<?php echo $Genre; ?>">
                </div>

                <div class="col-md-6">
                  <label for="releasedate" class="form-label">Release Date:</label>
                  <input type="text" class="form-control form-control-sm" id="releasedate" name="ReleaseDate" style="font-weight: 600;" value="<?php echo $ReleaseDate; ?>">
                </div>

                <div class="col-md-6">
                  <label for="streams" class="form-label">Streams:</label>
                  <input type="text" class="form-control form-control-sm" id="streams" name="Streams" style="font-weight: 600;" value="<?php echo $Streams; ?>">
                </div>

                <div class="col-md-6">
                  <label for="duration" class="form-label">Duration:</label> 
                  <input type="text" class="form-control form-control-sm" id="duration" name="Duration" style="font-weight: 600;" value="<?php echo $Duration; ?>">
                </div>

                <!-- buttons -->
                <div class="modal-footer bg-transparent border-0">
                  <button type="button" class="btn border-danger" role="button" style="background-color: rgb(184, 0, 0); color: rgb(255, 255, 255);" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn border-success" name="insertdata" role="button" style="background-color: rgb(11, 153, 42); color: rgb(255, 255, 255);">Add</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form><!---- End Add Modal ---->

    

  </main><!-- End #main -->

<?php
include('partials\footer.php');
?>