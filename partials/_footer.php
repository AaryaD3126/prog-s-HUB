<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>
<?php
echo '
<div style="bottom:0;left:0;right:0;width:100%;position:fixed;z-index:2;" class="bg-dark text-center text-lg-start">
  <!-- Copyright -->
  <div class="text-center p-2" style="color:white;background-color: rgba(0, 0, 0, 0.2); padding: 20px; text-align: center;">
    © Copyright:
  <a href="./index.php" style="color:white; font-size:17px;">  Prog\'s HUB</a>
  </div>
  <!-- Copyright -->
</div>
'
?>
