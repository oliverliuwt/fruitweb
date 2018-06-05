<?php

$current_dir = "admin";
$admin_nav = array("Manage Products" => "index.php","Manage Categories" => "categories_manage.php","Sales Records" => "sales_record.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand ">
    <img class ="logo" src="/images/graphics/logo.png">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admin-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="admin-collapse">
    <ul class="navbar-nav mr-auto">
      <?php
      if( count($admin_nav) > 0 ){
        
        foreach( $admin_nav as $name => $link ){
          //if the link matches the current page, set active as 'active'
          if( $link == basename($_SERVER["PHP_SELF"])){
            $active = "active";
          }
          else{
            unset($active);
          }
          
          echo "<li class=\"nav-item $active\">
                  <a class=\"nav-link\" href=\"/$current_dir/$link\">$name</a>
                </li>";
        }
      }
      ?>
      
    </ul>
  </div>
</nav>