<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
session_start();
$rname = $_SESSION["username"];
//storing room name in variable
$room = $_POST['room'];

//validating room name
if(strlen($room) > 60 or strlen($room) <2){
    $message = "Please enter a room name between 2-60 chars";
    echo '<script language="javascript">';
    echo 'alert("'.$message.'");';  //not showing an alert box.
    echo 'window.location="./chatroom.php";';
    echo '</script>';
    
}
else if(!ctype_alnum($room)){
    $message = "Please enter a alphanumeric room name!";
    echo '<script language="javascript">';
    echo 'alert("'.$message.'");';  //not showing an alert box.
    echo 'window.location="./chatroom.php";';
    echo '</script>';
    
}
else{
    //if room name is accepted then setting the connection through connection php file
    include "db_connect.php";
}

//check if the room name is already in the chat
$sql = "SELECT * FROM `rooms` WHERE roomname = '$room'";
$result = mysqli_query($connection, $sql);
if($result){
    if(mysqli_num_rows($result) > 0){
        $message = "Please enter different room name, as it is already taken!";
        echo '<script language="javascript">';
        echo 'alert("'.$message.'");';  
        echo 'window.location="./chatroom.php";';
        echo '</script>';

    }
    else{
        $sql = "INSERT INTO `rooms` (`roomname`,`room_by`, `time`) VALUES ('$room','$rname' ,current_timestamp());";
        if(mysqli_query($connection,$sql)){
            $message = "Room was successfully created, you can start chatting now!";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';  
            echo 'window.location="./rooms.php?roomname='.$room.'";';
            echo '</script>';
        }
    }
}
else{
    echo "echo: ".mysqli_error($connection);
}
?>