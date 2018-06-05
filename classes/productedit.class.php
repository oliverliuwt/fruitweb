<?php
class ProductEdit extends Products{
  private $product_id;
  private $results = array();
  public function __construct($product_id){
    parent::__construct();
    try{
      if( isset($product_id) && filter_var( $product_id, FILTER_VALIDATE_INT ) ){
        $this -> product_id = $product_id;
      }
      else{
        $class_name = get_class( $this );
        throw new Exception("missing product id in $class_name class constructor");
      }
    }
    catch(Exception $exc){
      error_log( $exc -> getMessage() );
    }
  }
  public function getProductDetails(){
    //LEFT JOIN is used in case a product is not in categories yet
    $query = 'SELECT 
      products.id,
      products.name,
      products.description,
      products.price,
      products.active,
      products.modified,
      categories.category_id,
      categories.category_name 
      FROM products
      LEFT JOIN products_categories
      ON products_categories.product_id = products.id
      LEFT JOIN categories
      ON categories.category_id = products_categories.category_id
      WHERE products.id = ?';
    //prepare query
    $statement = $this -> connection -> prepare( $query );
    $statement -> bind_param( "i" , $this -> product_id );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0 ){
      while( $row = $result -> fetch_assoc() ){
        array_push( $this -> results, $row );
      }
      return $this -> results;
    }
    else{
      return false;
    }
  }
}
?>