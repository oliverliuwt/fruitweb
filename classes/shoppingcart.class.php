<?php
class ShoppingCart extends Database{
	
  public function __construct(){
    //initialise parent class
    parent::__construct();
	
  }
  public function sumCart($account_id){
    $query = 'SELECT COUNT(1) AS products FROM cart WHERE account_id = '.account_id;
    $result = $this -> connection -> query( $query );
    if( $result -> num_rows > 0 ){
      $carts = array();
      while( $row = $result -> fetch_assoc() ){
        array_push( $carts, $row);
      }
      return $carts;
    }
  }
  
  public function sumNewProduct(){
	$query = 'SELECT COUNT( 1 ) AS products FROM products
		WHERE DATEDIFF( CURDATE( ) , created ) <=1 and active=1';
    $result = $this -> connection -> query( $query );
    if( $result -> num_rows > 0 ){
      $products = array();
      while( $row = $result -> fetch_assoc() ){
        array_push( $products, $row);
      }
      return $products;
    }
  }
  
  public function addProduct($account_id,$product_id){
    $query = 'SELECT * FROM cart
		          WHERE product_id='.$product_id.' and account_id='.$account_id;
    $result = $this -> connection -> query( $query );
    if( $result -> num_rows > 0 ){
      return true;
    }else{
      $query = 'INSERT INTO cart(account_id,product_id,createtime) values(?,?,NOW( ))';
      $statement = $this -> connection -> prepare( $query );
      $statement -> bind_param( "ii",$account_id,$product_id);
      if( $statement -> execute() ){
        return true;
      }
      else{
        return false;
      }
    }
    
  }
  
  public function buyProduct($account_id,$product_id,$quantity,$price){
      $query = 'INSERT INTO product_order(account_id, product_id,quantity,price,created) values(?,?,?,?,NOW( ))';
      $statement = $this -> connection -> prepare( $query );
      $statement -> bind_param( "iiid",$account_id,$product_id,$quantity,$price);
      if( $statement -> execute() ){
        return true;
      }
      else{
        return false;
      }
  }
}
?>