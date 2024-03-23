<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "forum_website";

$connection = mysqli_connect($server, $username, $password, $database);
if ($connection) {
    // echo "succesfully connected";
} else {
    die("Connection Error:" . mysqli_connect_error());
}

?>