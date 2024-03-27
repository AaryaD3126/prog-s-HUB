<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome - Prog's HUB - a digital community for coders</title>
  <link rel="icon" href="img/LOGO for Prog's HUB (2).png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/901d7d049c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/index.css">
  <style>
  <?php include "assets/css/_header.css"; ?>
  </style>

</head>

<body>
  <button type="button" class="btn btn-floating btn-lg" id="btn-back-to-top">
    <i class="fas fa-arrow-up"></i>
  </button>
  <?php include "partials/_header.php"; ?>
  <?php include "partials/_dbconnect.php"; ?>
  <?php include "partials/_loginmodal.php"; ?>
  <?php include "partials/_signupmodal.php"; ?>

  <h2 class="text-center mt-5 mb-4">Discussion/Forums - Browse Categories</h2>

  <div class="container box">
    <div class="row">
      <?php
      $sql = "SELECT * FROM `categories`";
      $result = mysqli_query($connection, $sql);
      $cardIndex = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $cn = $row['category_name'];
        $cd = $row['category_description'];
        $id = $row['category_id'];
        echo '
               <div class="col-md-4 my-3 fade-in card-container" style="animation-delay: ' . ($cardIndex * 0.2) . 's;">
                   <div class="card">
                       <div class="card-body">
                           <h5 class="card-title">' . $cn . '</h5>
                           <p class="card-text">' . substr($cd, 0, 90) . '...</p>
                           <a href="thread_list.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                       </div>
                   </div>
               </div>';
        $cardIndex++;
      }
      ?>
    </div>
  </div>
<br>
<br>
<br>
<br>
  <footer class="mt-5 py-4 bg-dark text-white text-center">
    &copy; 2024 Prog's HUB. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script>
    document.getElementById('btn-back-to-top').addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  </script>

</body>

</html>
