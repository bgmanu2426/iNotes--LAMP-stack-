<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Contact Us</title>
</head>

<body style="background-color: wheat;">
<?php
include 'partials/_navbar.php';
?>
    <h2 class="text-center my-4"> Fill the form to reach us</h2>
    <div class="container col-md-6">
        <form action="contactUs.php" method="post">
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address <strong style="color: red;">*</strong></label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput2">Full name</label>
                <input type="email" class="form-control" id="exampleFormControlInput2">
            </div>
            <label for="exampleFormControlInput3">Select issue <strong style="color: red;">*</strong></label>
            <select class="form-control" required>
                <option>-- Select --</option>
                <option>Registration issue</option>
                <option>Issue in Login</option>
                <option>Bugs in the iNotes</option>
                <option>Others</option>
            </select>
            <div class="form-group">
                <label for="exampleFormControlFile1">Upload the file</label>
                <input type="file" class="form-control-file bg-light py-2 px-2" id="exampleFormControlFile1">
            </div>
            <div class="form-group my-3">
                <label for="exampleFormControlTextarea1">Example textarea <strong style="color: red;">*</strong></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" required placeholder="Tell us about your issue...."></textarea>
            </div>
            <button type="reset" class="btn btn-danger">Reset</button>
            <button type="submit" class="btn btn-success mx-3">Submit</button>
        </form>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>