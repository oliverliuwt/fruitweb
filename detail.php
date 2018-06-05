<?php
include("autoloader.php");
$root = $_SERVER["DOCUMENT_ROOT"];
$self = basename($_SERVER["PHP_SELF"]);
session_start();

if( isset($_GET["product_id"]) ){
  
  $product_id = $_GET["product_id"];
  
  $product_detail = new ProductDetail( );
  $product = $product_detail -> getProduct($product_id);
  
  $product_name = $product[0]["name"];
  $product_price = $product[0]["price"];
  $product_description = $product[0]["description"];
  $product_data = $product[0]["modified"];
}
else{
  echo "You will be redirected to the home page after 5 seconds";
  header( "location:index.php" );
}
$page_title = $product_name;

$carts = new ShoppingCart();
//cart
if($_SESSION['account_id']){
  if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "cart"){
  $update = $carts ->addProduct($_SESSION['account_id'],$product_id);
  $location="/index.php";
  header( "location: $location");
}
}else{
  $location="/login.php";
  header( "location: $location");
}
//buy
if($_SESSION['account_id']){
  if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "buy"){
  $update = $carts ->buyProduct($_SESSION['account_id'],$product_id,$_GET["quantity"],$product_price);
  $location="/index.php";
  header( "location: $location");
}
}else{
  $location="/login.php";
  header( "location: $location");
}
?>
<!doctype html>
<html>
  <?php include ('includes/head.php'); ?>
  <body>
    <?php include('includes/navbar.php'); ?>
    <div class="container-fluid content">
      <div class="row mt-4">
	  <div class="col-md-2"></div>
      <div class="col-md-8">
	    <div class="col-sm-12">
          <?php
          $count = count( $product );

          if( $count > 0 ){
            if( $count == 1 ){
              $image = $product[0]["image"];
              echo "<img class=\"img-fluid\" src=\"/images/products/$image\">";
            }
            else{
              //output carousel if there are multiple images
              echo" <div id=\"product-detail-carousel\" class=\"carousel slide d-flex flex-column\" data-ride=\"carousel\">
                <ol class=\"carousel-indicators image-indicators position-static order-3\">";
                  $indicator_counter = 0;
                  foreach( $product as $indicator){
                    $indicator_image = $indicator["image"];
                    if($indicator_counter == 0){
                      $class="active";
                    }
                    else{
                      unset( $class );
                    }
                    echo "<li data-target=\"#product-detail-carousel\" data-slide-to=\"$indicator_counter\" class=\"$class\">
                      <img src=\"/images/products/$indicator_image\" class=\"img-fluid\">
                    </li>";
                    $indicator_counter++;
                  }
                echo "</ol>";
                echo "<div class=\"carousel-inner order-2 mb-2\">";
                  $image_counter = 0;
                  foreach( $product as $item){
                    $image = $item["image"];
                    $name = $item["name"];
                    if($image_counter == 0){
                      $class="active";
                    }
                    else{
                      unset( $class );
                    }
                    echo "<div class=\"carousel-item $class\">
                      <img class=\"d-block w-100\" src=\"/images/products/$image\" alt=\"$name\">
                    </div>";
                    $image_counter++;
                  }
                echo "</div>";
              echo "</div>";
            }
          }
          ?>
        </div>
        <div class="col-sm-12">
          <h2 class="product-name">
            <?php echo $product_name; ?>
          </h2>
          <p class="price">
            <?php echo $product_price; ?>
          </p>
          <p>Update Time : <?php echo $product_data; ?></p>
          <form class="my-2 form-inline" method="get" action="<?php echo $self?>">
		   <input name="product_id" value="<?php echo $product_id; ?>" style="display:none">
            <div class="form-row">
              <div class="col-8 col-md-3 input-group">
                <div class="input-group product-quantity my-2 my-md-0">
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-primary" data-function="subtract" type="button">&minus;</button>
                  </div>
                  <input type="number" name="quantity" value="1" min="1" class="form-control border-primary ">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" data-function="add" type="button">&plus;</button>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-7">
                <button class="btn btn-outline-primary" type="submit" value="cart" name="submit">Add to cart</button>
                <button class="btn btn-outline-primary" type="submit" value="buy" name="submit">Direct purchase</button>
              </div>
            </div>
          </form>
          <p class="description">
            <?php echo $product_description; ?>
          </p>
        </div>
	  </div>
      </div>
    </div>
    <script src="js/product-detail.js"></script>
  </body>
</html>