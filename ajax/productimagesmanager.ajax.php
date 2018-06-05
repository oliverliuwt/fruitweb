<?php
include('../autoloader.php');
if( $_SERVER["REQUEST_METHOD"] == "POST"){
  $response = array();
  $errors = array();
  
  $image_manager = new ProductImages();
  
  $action = $_POST["action"];
  if( $action == 'delete' ){
    $response=$image_manager ->delete($_POST["image"], $_POST["product"]);
  }else if($action == 'add'){
    $response=$image_manager ->create($_POST["image"], $_POST["product"]);
    //save img
    if($response){
        $base64_image_content = explode(',', $_POST['imgBase64']);
        $new_file = "../images/products/";
        if(!file_exists($new_file))
        {
          //检查是否有该文件夹，如果没有就创建，并给予最高权限
          mkdir($new_file, 0700);
        }
        $new_file=$new_file.$_POST["image"];
        if (file_put_contents($new_file, base64_decode($base64_image_content[1]))){
          $response=true;
        }
    }
  }
  
  echo json_encode($response);
}

?>