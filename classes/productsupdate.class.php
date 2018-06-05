<?php
class ProductsUpdate extends Products{
  public function __construct(){
    //initialise parent class
    parent::__construct();
  }
  public function getProducts(){
    //list products
    $query = 'SELECT 
    products.id AS id,
    products.name AS name,
    products.price AS price,
    products.description AS description,
    products.active AS active,
    images.image_file_name AS image
    FROM products 
    LEFT OUTER JOIN products_images 
    ON products.id = products_images.product_id 
    LEFT OUTER JOIN images
    ON products_images.image_id = images.image_id 
    GROUP BY products.id';
    
    $result = $this -> connection -> query( $query );
    if( $result -> num_rows > 0 ){
      $products_array = array();
      while( $row = $result -> fetch_assoc() ){
        array_push( $products_array, $row);
      }
      return $products_array;
    }
  }
  public function updateStatus( $product_id, $status ){
    //update a product's active status
    $query = 'UPDATE products 
              SET active=?, modified=NOW()
              WHERE id=?';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "ii", $status, $product_id );
    if( $statement -> execute() ){
      return true;
    }
    else{
      return false;
    }
  }
  
  public function addProduct($name,$description,$price,$onspecial,$active){
    $query = 'INSERT products(name,description,price,onspecial,active,created) 
	          VALUES(?,?,?,?,?,NOW())';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "ssdii", $name,$description,$price,$onspecial,$active);
    if( $statement -> execute() ){
      return true;
    }
    else{
      return false;
    }
  }
  
  public function deleteProduct($product_id){

    $query = 'delete FROM products_images 
              WHERE product_id=?';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $product_id );
	  $statement -> execute();
	
	  $query = 'delete FROM products_categories
              WHERE product_id=?';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $product_id );
 	  $statement -> execute();
	
	  $query = 'delete FROM products 
              WHERE id=?';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $product_id );
	  $statement -> execute();
	  
	  return true;
  }
  
  public function editProduct($product_id,$name,$description,$price,$onspecial,$active,$categories){
    $query = 'UPDATE products 
	            set name=?,description=?,price=?,onspecial=?, active=?, modified=NOW()
              WHERE id=?';
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "ssdiii",$name,$description,$price,$onspecial,$active,$product_id );
    $statement -> execute();
	
	$query = 'delete from products_categories 
              WHERE product_id=?';
	$statement = $this -> connection -> prepare( $query );
	$statement -> bind_param( "i",$product_id );
	$statement -> execute();
	
	$categories=json_decode($categories);
    foreach($categories as $k){
		$query = 'INSERT INTO products_categories(product_id,category_id) values(?,?)';
		$statement = $this -> connection -> prepare( $query );
		$statement -> bind_param( "ii",$product_id,$k);
		$statement -> execute();
    }
	return true;
  }
  
  public function getOrder(){
    $query = 'SELECT product_order.id AS id, products.name AS name, product_order.price AS price, products.active AS active, images.image_file_name AS image, product_order.quantity AS quantity, product_order.created AS created
    FROM product_order
    LEFT OUTER JOIN products_images ON product_order.product_id = products_images.product_id
    LEFT OUTER JOIN images ON products_images.image_id = images.image_id
    LEFT OUTER JOIN products ON products.id = product_order.product_id
    ORDER BY product_order.created';
    
    $result = $this -> connection -> query( $query );
    if( $result -> num_rows > 0 ){
      $order_array = array();
      while( $row = $result -> fetch_assoc() ){
        array_push( $order_array, $row);
      }
      return $order_array;
    }
  }
}
?>