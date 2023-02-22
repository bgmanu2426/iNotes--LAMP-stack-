<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit();
}

// Flages to show confirmation message on CRUD operations perfomed 
$insert = false;
$update = false;
$delete = false;

// Connection to the database
include 'partials/_dbconnect.php';

//Variable to fetch users table to store user data
$tb_name = $_SESSION['email'];

// php to perfom the CRUD operations in the iNotes app 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // operations perfomed using the POST method 
  if (isset($_POST['slnoEdit'])) {
    // Update the record in database
    $slno = $_POST['slnoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];
    $sql = "UPDATE `$tb_name` SET `title` = '$title', `description` = '$description' WHERE `$tb_name`.`slno` = $slno";
    $result = mysqli_query($connection, $sql);
    if ($result) {
      $update = true;
    }
  } else {
    // Insert the new note in the databse 
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO `$tb_name` (`title`, `description`, `timestamp`) VALUES ('$title', '$description', current_timestamp())";
    $result = mysqli_query($connection, $sql);
    if ($result) {
      $insert = true;
    }
  }
} elseif (isset($_GET['delete'])) {
  // operations perfomed using the GET method to delete the note in databse
  $slno = $_GET['delete'];
  $sql = "DELETE FROM `$tb_name` WHERE `slno` = $slno";
  $result = mysqli_query($connection, $sql);
  if ($result) {
    $delete = true;
  }
}
?>

<!-- HTML body start  -->
</body>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iNotes - Notes taking made easy</title>
  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
</head>

<body>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST">
            <input type="hidden" name="slnoEdit" id="slnoEdit">
            <div class="mb-3 my-3">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit">
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Description</label>
              <textarea type="text" class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="index.php" method="GET">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModallLabel">Delete Note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this note permanently?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
            <button type="button" id="delBtn" class=" confirmDelete btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Navigation bar -->
  <?php require "partials/_navbar.php"; ?>

  <?php
  // php script to show the CRUD oprations message in alerts 
  if ($insert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your note has been added successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  } elseif ($update) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Updated!</strong> Your note has been updated successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  } elseif ($delete) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Deleted!</strong> Your note has been deleted successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  ?>

  <!-- HTML form to write the note -->
  <div class="container my-4">
    <center>
      <h6>Welcome to iNotes <?php echo $_SESSION['name']; ?> now you can start adding notes</h6>
    </center>
    <h3>Add a Note</h3>
    <form action="index.php" method="POST">
      <div class="mb-3 my-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea type="text" class="form-control" id="description" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>

  <!-- jQuery table to display the notes in the iNotes app -->
  <div class="container my-5 table-responsive">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sl.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `$tb_name`";
        $result = mysqli_query($connection, $sql);
        $num = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr>
          <th scope="row">' . $num . '</th>
          <td>' . $row['title'] . '</td>
          <td>' . $row['description'] . '</td>
          <td>  <div class="d-flex flex-row mb-3">
          <div class="p-1"><button class="edit btn btn-sm btn-primary" id=' . $row['slno'] . '>&nbsp&nbsp&nbspEdit&nbsp&nbsp</button></div>
          <div class="p-1"><button class="delete btn btn-sm btn-danger" id=d' . $row['slno'] . '>Delete</button></div>
        </div></td>
        </tr>';
          $num = $num + 1;
        }
        ?>
      </tbody>
    </table>
  </div>
  <hr>

  <!-- Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

  <script>
    // Script for the jQuerys plug-in DataTables
    $(document).ready(function() {
      $(' #myTable').DataTable();
    });
  </script>

  <script>
    // Javascript to make edit and delete operations
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        // console.log("edit");
        tr = e.target.parentNode.parentNode.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        // console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        slnoEdit.value = e.target.id;
        // console.log(e.target.id);
        $('#editModal').modal('toggle')
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e1) => {
        // console.log("edit");
        $('#deleteModal').modal('toggle');
        slno = e1.target.id.substr(1, );
        document.getElementById('delBtn').onclick = function() {
          window.location = `/index.php?delete=${slno}`;
        }
      })
    })

    // // To add active class to the navbar
    // const addClassActive = document.getElementById('pills-home-tab');
    // addClassActive.classList.add('active');

    // To fix the re-submission error on reloading the webpage
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>

<!-- TODO:
1. To make a POST request form to delete the note in iNotes app for the security and privacy concerns
2. And fix some of other small bugs -->