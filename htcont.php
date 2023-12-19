<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
$room = $_POST['room'];
include 'db_connect.php';
$sql = "SELECT message, stime,IP FROM messages WHERE room = '$room'";
$res="";
$html_content = '';
$result = mysqli_query($connection,$sql);
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '1234567891011121';
  
$encryption_key = "chat@message|3126";

$decrypt_msg = openssl_decrypt($row['message'], $ciphering,
            $encryption_key, $options, $encryption_iv);
$decrypt_ip = openssl_decrypt($row['IP'], $ciphering,
            $encryption_key, $options, $encryption_iv);

        $res = $res.'<div class="container" style="color: #007bff;">';
        $res = $res . $decrypt_ip;
        $res = $res . " says <p style='color:#17a2b8;'>".$decrypt_msg;
        $res = $res.'</p><span class="time-right">'.$row['stime'].'</span></div>';
    }
}
echo $res;
?>