<?php
class UploadFile {
  public function __construct(){
    //initialise database
    //parent::__construct();
    //check if files are being uploaded
    if( count($_FILES) > 0 ){
      print_r($_FILES);
    }
    else{
      
      print_r($_FILES["upload"]["error"]);
    }
  }
}
?>