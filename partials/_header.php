
<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<nav style="z-index:1;" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Prog's HUB</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      
       
        
          <li class="nav-item"><a class="nav-link active" href="chatroom.php">community chat</a></li>
      


      
          
        
        <li class="nav-item">
          <a class="nav-link active" href="contact.php">Contact</a>
        </li>
      </ul>
      
    
      <form action="./search.php" method="get" class="d-flex" role="search">
        <input class="form-control" name="search" type="search" placeholder="Search a thread" aria-label="Search a thread">
        <button class="btn mx-2" type="submit" style="width:50px;height:50px;border-radius:50%;background-color: black;">&#x1F50E; </button>
      </form>
      <?php 
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        if (isset($_SESSION['profile'])) {
          $profile = $_SESSION['profile'];
          echo '<img class="mx-1" src="' . $profile . '" alt="..." style="width:50px;height:50px;border-radius:50%;">';
        }else{
          echo '
<form action="upload.php" method="post" enctype="multipart/form-data">

      <button type="submit" class="btn" style="background-color:black;color:white;font-size:20px;margin-left:4px;width:50px;height:50px;border-radius:50%;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  +
</button>
    </form>


';
        }
        
          echo '<p style="font-size:16px;color:white;" class="mx-2  my-1"><span style="font-size:18px;color:white;font-weight:bolder;">'.$_SESSION["username"].'</span></p>';
        echo '<form action="./partials/logout.php" method="post"><button class="btn btn-outline-danger my-1" data-bs-toggle="modal" data-bs-target="#signupmodal">log out</button></form>';
      }
      else{
      echo '<button class="btn btn-outline-success mx-2  my-1" data-bs-toggle="modal" data-bs-target="#loginmodal">log in</button>
      <button class="btn btn-outline-success my-1" data-bs-toggle="modal" data-bs-target="#signupmodal">sign up</button>';
      }
      ?>
    </div>
  </div>
</nav>
<?php
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>account created!</strong> Your account is successfully created. You can login now!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

?>