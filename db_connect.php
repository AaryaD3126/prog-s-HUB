<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php

//setting the connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "chatroom";

//creating a database connection
$connection = mysqli_connect($servername,$username,$password,$database);

//checking the connection error
if(!$connection){
    die("server Connection failed, error:".mysqli_connect_error());

}
else{
    // echo "successfully connected";
}
// echo "\nLet's chat now!";

?>