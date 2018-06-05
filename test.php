<?php
include('autoloader.php');

$test = new Account();
$account = $test -> authenticate('jenny66','password');

print_r($test -> errors);
?>
<!doctype html>
<html>
  <?php include ('includes/head.php'); ?>
  
  <body>
    <div class="container-fluid">
      <div class="row">
        
      </div>
    </div>
  
  
  </body>
</html>
