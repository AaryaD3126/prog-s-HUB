<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( "Location: index.php");
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<head>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalTour">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-body p-5">
       <form action="upload.php" method="post" enctype="multipart/form-data">
  <fieldset>
    <legend>Select image to upload:</legend>
    <div class="mb-3">
      <input type="file" name="fileToUpload" id="fileToUpload">
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
  </fieldset>
</form>
      </div>
    </div>
  </div>
</div>



<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        include 'partials/_dbconnect.php';
        $username = $_SESSION['username'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $message = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $message = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                $sql = "INSERT INTO `profile_img` (`image_url`, `img_username`) VALUES ('$target_file', '$username');";
                $result = mysqli_query($connection, $sql);
              
            $sql2 = "SELECT * FROM `profile_img` WHERE img_username = '$username'";
            $res = mysqli_query($connection, $sql2);
            $row = mysqli_fetch_assoc($res);
            $_SESSION['profile'] = $row['image_url'];
                
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
        
    }
    echo '<script language="javascript">';
        echo 'alert("' . $message . '");';
        echo 'window.location="index.php";';
        echo '</script>';
}

?>