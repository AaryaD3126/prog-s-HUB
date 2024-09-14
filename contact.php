<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  include 'partials/_dbconnect.php';
  $name = mysqli_real_escape_string($connection, $_POST['name']);
  $emailAddress = mysqli_real_escape_string($connection, $_POST['emailAddress']);
  $msg = mysqli_real_escape_string($connection, $_POST['message']);
  $sql = "INSERT INTO `contact` (`name`, `email`, `msg`) VALUES ('$name', '$emailAddress', '$msg')";
  $result = mysqli_query($connection, $sql);
  if ($result) {
   
    echo '<script>alert("message sent!");</script>';

  } else {
    echo '<script>alert("message was not sent!")</script>';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact - Prog's HUB - a digital community for coders</title>
  <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
  <script src="https://kit.fontawesome.com/901d7d049c.js" crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
  <style>
    body{
                font-family: 'Chivo Mono', monospace;
                background: linear-gradient(to bottom right, #2c2c2c, #343a40, #343a40, #2c2c2c);


            }
            <?php include "assets/css/_header.css"; ?>
  </style>
</head>

<body>
  <?php include "partials/_dbconnect.php" ?>
  <?php include "partials/_header.php" ?>
<h1 style="color:white;margin-top:25px;"><center><b>Contact us</b></center></h1>
<div style="padding:25px;border-radius:20px;" class="container my-4 bg-light">

  <form action="contact.php" method="post" id="contactForm">

    <div class="mb-3">
      <label class="form-label" for="name">Name</label>
      <input class="form-control" name="name" id="name" type="text" placeholder="Name" />
    </div>

    <div class="mb-3">
      <label class="form-label" for="emailAddress">Email Address</label>
      <input class="form-control" name="emailAddress" id="emailAddress" type="email" placeholder="Email Address" />
    </div>

    <div class="mb-3">
      <label class="form-label" for="message">Message</label>
      <textarea class="form-control" name="message" id="message" type="text" placeholder="Message" style="height: 10rem;"></textarea>
    </div>

    <div class="d-grid">
      <button style="width:100px;" class="btn btn-primary btn-lg" type="submit">Submit</button>
    </div>

  </form>

</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>