<?php
 $carts = new ShoppingCart();
 $carts_count=0;
 if($_SESSION['account_id']){
      $carts_obj = $carts -> sumCart($_SESSION['account_id']);
      $carts_count = $carts_obj[0]["products"];
  }
 $newProducts=$carts->sumNewProduct();
 $newProducts_count=$newProducts[0]["products"];
  
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand mx-2 order-8 order-md-1" href="index.php">
    <img class ="logo" src="/images/graphics/logo.png">
  </a>
  <button class="navbar-toggler mx-2 order-1" type="button" data-toggle="collapse" data-target="#nav-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
   <div class="collapse navbar-collapse order-10 order-md-4">
  </div>
  <form class="form-inline my-2 my-lg-0 flex-fill flex-sm-fill d-sm-flex flex-row flex-sm-nowrap order-3 order-md-3" method="get" action="search.php">
    <input class="form-control mr-sm-2 flex-fill flex-sm-fill" type="search" name="keywords" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0 mr-sm-2 d-none d-md-inline-block" type="submit">Search</button>
  </form>
  <div class="collapse navbar-collapse order-10 order-md-4">
  </div>
  <div class="cart-group d-flex order-8 order-md-9">
    <a class="nav-icon cart mx-1" href="index.php?page=cart">
      <img class="icon" src="images/graphics/shopping-bag.png">
      <span class="badge badge-primary cart-count"><?php echo $carts_count?></span>
    </a>
    <a class="nav-icon wish mx-1" href="index.php?page=newProduct">
      <img class="icon" src="images/graphics/wish-bag.png">
      <span class="badge badge-primary wish-count"><?php echo $newProducts_count?></span>
    </a>
  </div>
  <?php
    if( $_SESSION["username"] ){
      $user = $_SESSION["username"];
      echo "<div  class=\"order-9 order-md-10 mx-2 d-flex align-items-center\">
      <img src=\"/images/graphics/user.png\" class=\"icon\">
      <span class=\"navbar-text greeting d-md-inline-block d-none\">$user</span>
      </div>";
    }else{
      echo "<div  class=\"order-9 order-md-10 mx-2 d-flex align-items-center\">
      <img src=\"/images/graphics/login.png\" class=\"icon\">
      <a class=\"navbar-text greeting d-md-inline-block d-none\" href=\"login.php\">login</a>
      </div>";
	}
    ?>
    
</nav>