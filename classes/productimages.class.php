<?php
class ProductImages extends Products{
  public $images = array();
  public function __construct(){
    parent::__construct();
  }
  public function getImages( $product_id ){
    if( filter_var($product_id, FILTER_VALIDATE_INT) == false ){
      return false;
    }
    $query = "SELECT 
              images.image_id,
              images.image_file_name,
              images.active
              FROM products_images
              INNER JOIN images
              ON products_images.image_id = images.image_id
              WHERE products_images.product_id = ?";

    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i", $product_id );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0 ){
      while( $row = $result -> fetch_assoc() ){
        array_push( $this -> images, $row );
      }
      return $this -> images;
    }
    else{
      return false;
    }
  }
  
  public function create( $image_file_name, $product_id,$caption = '' ){
    $query = "INSERT INTO images 
              (image_file_name,date_added,caption,active)
              VALUES
              ( ?, NOW(), ?, 1 )";
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "ss", $image_file_name, $caption );
    if( $statement -> execute() ){
      $id = $this -> connection -> insert_id;
      $query = "INSERT INTO products_images 
              (product_id,image_id,active)
              VALUES
              ( ?, ?, 1 )";
      $statement = $this -> connection -> prepare( $query );
      $statement -> bind_param( "ii",$product_id,$id );
      $statement -> execute();
      return true;
    }
    else{
      return $statement -> execute();
    }
  }
  
  public function delete( $image_id , $product_id ){

    //delete image from products_images table
    $prd_images = "DELETE FROM products_images WHERE image_id = ? AND product_id = ?";
    $statement = $this -> connection -> prepare($prd_images);
    $statement -> bind_param( "ii", $image_id,$product_id);
    $statement -> execute();
    
    //delete image from images table
    $img_query = "DELETE FROM images WHERE image_id = ?";
    $statement = $this -> connection -> prepare( $img_query );
    $statement -> bind_param( "i", $image_id);
    $statement -> execute(); 
    
    return true;
    
  }
}
?>