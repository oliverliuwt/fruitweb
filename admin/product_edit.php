<?php
include('../autoloader.php');
$root = $_SERVER["DOCUMENT_ROOT"];
$self = basename($_SERVER["PHP_SELF"]);


$product_id = $_GET["product_id"];
if( isset($product_id) == false 
|| filter_var($product_id,FILTER_VALIDATE_INT == false) )
{
 // exit();
  $location="/admin/";
  header( "location: $location");
}

$product_edit = new ProductEdit( $product_id );
//get the products
$products = $product_edit -> getProductDetails();

$categories = new Categories();
$products_categories = $categories -> getCategories();

$images_obj = new ProductImages();
$images = $images_obj -> getImages( $product_id );

$product_id = $products[0]["id"];
$product_name = $products[0]["name"];
$price = $products[0]["price"];
$product_active = $products[0]["active"];
$description = $products[0]["description"];

$page_title = "Editing ".$product_name;

//delete
$product_update = new ProductsUpdate();
if( $_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "delete" ){
  $update = $product_update -> deleteProduct($product_id);
  $location="/admin/";
  header( "location: $location");
}
//edit
if( $_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "edit" ){
  $name=$_GET["product_name"];
  $description=$_GET["product-description"];
  $price=$_GET["product_price"];
  $onspecial=0;
  $active=$_GET["product_active"] ? 1 : 0;
  $categories=json_encode($_GET["categories"]);
  $update = $product_update -> editProduct($product_id,$name,$description,$price,$onspecial,$active,$categories);
  $location="/admin/";
  header( "location: $location");
}
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
          <h4 class="my-4">Edit Product</h4>
          <form id="product-update-1"  method="GET" action="<?php echo $self?>">
            <div class="row">
              <div class="col-md-1">
                <div class="form-group">
                  <label for="">Id</label>
                  <input type="text" class="form-control" id="product-id" name="product_id" value="<?php echo $product_id;?>" readonly>  
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="product-name">Name</label>
                  <input type="text" class="form-control" id="product-name" name="product_name" value="<?php echo $product_name;?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="product-price">Price</label>
                  <input type="text" class="form-control" id="product-price" name="product_price" value="<?php echo $price;?>"> 
                </div>
              </div>
              <div class="col">
                <!--see class toggle in styles.css-->
                <label class="toggle" for="product-active">
                  <input type="checkbox" name="product_active" id="product-active" value="<?php echo $product_active;?>" <?php echo ($product_active==1 ? "checked" : ""); ?> >
                  <div class="toggle-button"></div>
                  <span class="toggle-label"></span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="product-description">Description</label>
                  <textarea name="product-description" class="form-control" rows="4" cols="10" id="product-description"><?php echo $description; ?></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="d-block mb-4">Product is in these categories</label>
                  <?php
                  if( count($products_categories) > 0 && $products_categories ){
                    foreach( $products_categories as $category){
                      $cat_id = $category["category_id"];
                      $cat_name = $category["category_name"];
                      $cat_active = $category["active"];
                      
                      //check if the current product is in this category
                      if( count($products) > 0 && $products){
                        foreach( $products as $product ){
                          $prd_cat_id = $product["category_id"];
                          if( $prd_cat_id == $cat_id ){
                            //if it is, create a string to check the checkbox
                            $checked = "checked";
                            break;
                          }
                          else{
                            //otherwise set string to empty
                            unset( $checked );
                          }
                        }
                      }
                      echo "
                      <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"categories[]\" value=\"$cat_id\" id=\"category-$cat_id\" $checked>
                        <label class=\"form-check-label\" for=\"category-$cat_id\">
                          $cat_name " . 
                          //if category is inactive, print out badge
                          ( $cat_active == 1 ? "" : "<span class=\"badge badge-warning\">inactive</span>") .
                        "</label>
                      </div>";
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <h5>Existing images</h5>
              </div>
              <div class="col-md-10">
                <div class="w-100 d-flex flex-wrap bg-light product-edit-images" id="product-images">
                  <?php
                  if( $images ){
                    foreach( $images as $image ){
                      $img_id = $image["image_id"];
                      $img = $image["image_file_name"];
                      echo 
                      "<div class=\"card w-25 p-2\">
                        <div class=\"border border-dark\">
                          <img class=\"img-fluid card-img-top\" src=\"/images/products/$img\">
                        </div>
                        <div class=\"my-2 text-right\">
                          <button type=\"button\" class=\"btn btn-outline-dark btn-sm\" data-id=\"$img_id\" data-product-id=\"$product_id\">
                            Detach image
                          </button>
                        </div>
                      </div>";
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <button type="button" class="btn btn-primary my-2" id="add-uploader">Upload new image</button>
              </div>
              <div class="col-md-10">
                <div id="image-upload" style="min-height:90px;" class="d-flex flex-wrap bg-light rounded my-2 p-2"></div>
                
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex flex-row justify-content-between">
                  <button class="btn btn-outline-primary my-4" type="submit" value="edit" name="submit">
                    Save
                  </button>
                  <button class="btn btn-outline-danger my-4" type="submit" value="delete" name="submit">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </form>
          <hr>
        </div>
      </div>
    </div>
    <!--load the trumbowyg text editor-->
    <script src='/node_modules/trumbowyg/dist/trumbowyg.min.js'></script>
    <script>
    //add stylesheet for trumbowyg after document load
      $( document ).ready( () => {
        //create a link tag and append it to head
        let link = document.createElement('link');
        $(link).attr('rel','stylesheet');
        $(link).attr('href','/node_modules/trumbowyg/dist/ui/trumbowyg.css');
        $('head').append(link);
        //initialise trumbowyg text editor
        let options = { btns:[
          ['viewHTML'],
          ['undo', 'redo'],
          ['formatting'],
          ['strong', 'em', 'del'],
          ['superscript', 'subscript'],
          ['link'],
          ['unorderedList', 'orderedList'],
          ['horizontalRule'],
          ['removeformat'],
          ['fullscreen']
          ]};
        $('#product-description').trumbowyg( options );
        
        //cloning image uploader from template
        $('#add-uploader').click( (event) => {
          template = $('#uploader-template').html().trim();
          let clone = $(template);
          //fill the template with data
          let id= new Date().getTime();
          $(clone).find('label').attr('for', id);
          $(clone).find('input[name="images[]"]').attr('id', id );
          //add to container
          $('#product-images').append( clone );
        });
        
        //listener for each image uploader
        $('#image-upload').click( (event) => {
          let target = event.target;
          //remove an uploader if the X button is clicked
          if( $(target).attr('type') == 'button' ){
            let id = $(target).parents('label').attr('for');
            let elm = 'label[for="' + id + '"]';
            $(elm).remove();
          }
        });
         $('.product-edit-images').on('change', (event) => {
          let input = event.target;
          //get a reference to the file selected( it's an array )
          let file = input.files[0];
          //calculate size in kilobytes
          let size = Math.ceil(file.size/1024);
          //show first few characters of the file name (limited space)
          let name = file.name.substr(0,6) + '...';
          //file reader object to read file and load a preview on the page
          var reader = new FileReader();
          reader.onload=function(){
            //the result of the file reader loading the image
            let img = reader.result;
            //we now have an image and we will apply as a background
            //get id of the input that triggers the event
            let id = $(input).attr('id');
            //get the label with a 'for' attribute with same value
            let element = $('[for="'+ id +'"]');
            let style = 'background-image: url('+img+');';
            $(element).attr('style',style);
            //add 'has-image' class
            $(element).addClass('has-image');
            //display information about the file
            let fileinfo = name + '\n' + size + 'KB';
            $(element).find('.uploader-label').text(fileinfo);
            let product_id = $(input).attr('data-product-id');
            //upload
             $.ajax({
                url: '/ajax/productimagesmanager.ajax.php',
                data: {image:file.name, product: product_id, action: 'add',imgBase64:img},
                dataType: 'json',
                method: 'post'
              })
              .done( ( response ) => {
                  console.log(111);
              });
          };
            //activate the reader
          reader.readAsDataURL(file);
          });
          //product-images
          $('.product-edit-images').click( (event) => {
            let elm = event.target;
            if( $(elm).attr('type') == 'button' ){
              // add spinner to button
             let src = '/images/graphics/spinner1.gif';
              let img = `<img src="${src}" style="max-width:50px;">`;
              $(elm).attr('disabled','');
              $(elm).append(img);
              
              //get the id of the image from button
              let image_id = $(elm).attr('data-id');
              let product_id = $(elm).attr('data-product-id');
              
              //create data obj
              let data_obj = {image: image_id, product: product_id, action: 'delete' };
              
              //make request
              $.ajax({
                url: '/ajax/productimagesmanager.ajax.php',
                data: data_obj,
                dataType: 'json',
                method: 'post',
                action:'delete'
              })
              .done( ( response ) => {
                  elm.parentNode.parentNode.remove();
              });
            }
		  });
      }
      );
      
    </script>
  </body>
  <template id="uploader-template">
    <div class="card w-25 p-2 image-uploader">
      <div class="border border-dark">
        <label for="">
          <img class="img-fluid card-img-top" src="">
        </label>
        <input type="file" id="" name="images[]" data-product-id="<?php echo $product_id?>">
      </div>
      <div class="my-2 text-right">
        <button type="button" class="btn btn-outline-dark btn-sm" data-id="" data-product-id="<?php echo $product_id?>">
          Remove image
        </button>
      </div>
    </div>
  </template>
</html>