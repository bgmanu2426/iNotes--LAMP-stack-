<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;
}

echo '<ul class="nav bg-dark bg-gradient">
<li class="nav-item my-2 mx-2">
  <a class="nav-link text-light" aria-current="page" href="index.php"><strong>Home</strong></a>
</li>
';

if (!$loggedin) {
  echo '
<li class="nav-item my-2 mx-2">
  <a class="nav-link text-light" aria-current="page" href="index.php"><strong>Login</strong></a>
</li>
';
}

if ($loggedin) {
  echo '
<li class="nav-item dropdown my-2">
  <a class="nav-link dropdown-toggle text-light" id="more-options" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>More options</strong></a>
  <div class="dropdown-menu">
  <a class="dropdown-item" href="profile.php">Profile</a>
  <a class="dropdown-item" href="partials/_logout.php">Logout</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="partials/_clearNotes.php"> Clear all Notes</a>
  <button type="button" id="delall" onclick="deleteaccount()" class="btn">Delete account</button>
</li>';
}

echo '
<li class="nav-item my-2 mx-2">
  <a class="nav-link text-light" aria-current="page" href="contactUs.php"><strong>Contact Us</strong></a>
</li>
</ul>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <!-- Delete  all Modal -->
  <div class="modal fade" id="deleteallModal" tabindex="-1" aria-labelledby="deleteallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="/partials/_delAccount.php" method="post">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteallModallLabel">Delete your account</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete your account permanently?
              You may loose all of your data by deleting the account.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
            <button type="button" id="delallBtn" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function deleteaccount() {
      document.getElementById('delall');
      $('#deleteallModal').modal('toggle');
      document.getElementById('delallBtn').onclick = function() {
        window.location = `partials/_delAccount.php`;
      }
    }
  </script>
</body>


</html>