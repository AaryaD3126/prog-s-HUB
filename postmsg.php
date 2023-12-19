<?php
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
include 'db_connect.php';

$room = $_POST['room'];
$msg= mysqli_real_escape_string($connection, $_POST['text']);
$msg = str_replace("<", "&lt;", $msg);
$msg = str_replace(">", "&gt;", $msg);
$ip = $_POST['IP'];

$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '1234567891011121';
  
$encryption_key = "chat@message|3126";

$encrypt_msg = openssl_encrypt($msg, $ciphering,
            $encryption_key, $options, $encryption_iv);
$encrypt_ip = openssl_encrypt($ip, $ciphering,
            $encryption_key, $options, $encryption_iv);

$sql = "INSERT INTO `messages` ( `message`, `room`, `ip`, `stime`) VALUES ( '$encrypt_msg', '$room', '$encrypt_ip', current_timestamp());";
mysqli_query($connection,$sql);
mysqli_close($connection);

?>