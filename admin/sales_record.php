<?php
include('../autoloader.php');
$root = $_SERVER["DOCUMENT_ROOT"];
$self = basename($_SERVER["PHP_SELF"]);

//create ProductUpdate instance
$product_update = new ProductsUpdate();
//get the products
$products = $product_update ->getOrder();

?>
<!doctype html>
<html>
  <?php 
  include ("$root/includes/head.php"); 
  ?>
  <body>
    <div class="container content">
      <?php
      include("includes/admin_nav.php");
      ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="tab-content">
            <div class="tab-pane fade show active" id="edit-products" role="tabpanel" aria-labelledby="edit-tab">
              <h4 class="my-4"></h4>
              <?php
              //if there are products
              if( $products && count($products) > 0 ){
                foreach( $products as $product ){
                  $order_id = $product["id"];
                  $product_name = $product["name"];
                  $order_price = $product["price"];
				  $order_quantity = $product["quantity"];
				  $order_created = $product["created"];
                  $product_active = ($product["active"] ? "checked" : "");
                  //set row background color
                  $row_bg = ( $product["active"] ? "" : "bg-warning");
                  $product_image = $product["image"];
                  //output rows
                  echo "
                    <div class=\"row my-2\">
                      <div class=\"col-2\">
                        <img class=\"img-fluid\" src=\"/images/products/$product_image\">
                      </div>
                      <div class=\"col-4\">
                        <h4>$product_name</h4>
            						<p class=\"price\">$order_price *   $order_quantity</p>
            						<p>$order_created</p>
                      </div>
                    </div>
                    <hr>
                  ";
                }
              }
              ?>
            </div>
      </div>
    </div>
  </body>
 
</html>