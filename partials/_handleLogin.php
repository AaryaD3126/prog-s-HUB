<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
$showError = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '_dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "Select * from users where username = '$username'";
    $result = mysqli_query($connection, $sql);
    $numRows = mysqli_num_rows($result);
    if($username == "" || $password==""){
        echo '<script>alert("fields are blank");</script>';
        echo '<script>window.location = "../index.php";</script>';
        
    }
   
    
    else if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_start();
         
            $sql2 = "SELECT * FROM `profile_img` WHERE img_username = '$username'";
          $res = mysqli_query($connection, $sql2);
          $row = mysqli_fetch_assoc($res);
          $_SESSION['profile'] = $row['image_url'];
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            echo '<script>alert("loggedin with username: '.$username.'");</script>';
            echo '<script>window.location = "../index.php";</script>';
           
        }
        else if(password_verify($password, $row['password']) != $password){
            echo '<script>alert("password incorrect");</script>';
            echo '<script>window.location = "../index.php";</script>';
        }

    }
    else{
        echo '<script>alert("unable to login");</script>';
        echo '<script>window.location = "../index.php";</script>';
        }
        
}
echo '<script>window.location = "../index.php";</script>';



?>

