<?php
//handle ajax request to add item to the shopping cart
if( $_SERVER["REQUEST_METHOD"] == "POST"){
  //include the autoloader
  include( '../autoloader.php' );
  
  //add an array to store responses
  $response = array();
  //add an array to store errors
  $errors = array();
  
  //create instance of shopping cart class
  $cart = new ShoppingCart();
  //get action
  $action = $_POST["action"];
  //if the request was to add an item to the cart
  if( $action == "add" ){
    //add item to cart
    $id = $_POST["product_id"];
    $qty = $_POST["quantity"];
    if( $cart -> addItem($id,$qty) ){
      //success
      $response["success"] = true;
    }
    else{
      //failed
      $response["success"] = false;
      //get the client redirecting to login.php
      $response["redirect"] = "login.php";
    }
  }
  
}
?>