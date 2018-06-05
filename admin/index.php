<?php
include('../autoloader.php');
$root = $_SERVER["DOCUMENT_ROOT"];
$self = basename($_SERVER["PHP_SELF"]);

//check if user is admin, if not redirect elsewhere or exit

//create ProductUpdate instance
$product_update = new ProductsUpdate();

//handle GET requests
if( $_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "edit" ){
  $product_id = $_GET["product_id"];
  $location = "product_edit.php?product_id=$product_id";
  header( "location: $location");
}
if( $_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "save" ){
  $product_id = $_GET["product_id"];
  //if product_active is not sent, set value to 0 = inactive
  $active = ($_GET["product_active"] ? 1 : 0);
  echo $active;
  $update = $product_update -> updateStatus( $product_id, $active );
}



//get the products
$products = $product_update -> getProducts();

// add the products
if( $_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "add" ){
  $name=$_GET["product_name"];
  $description=$_GET["product_description"];
  $price=$_GET["product_price"];
  $onspecial=0;
  $active=$_GET["product_active"] ? 1 : 0;
  $update = $product_update -> addProduct($name,$description,$price,$onspecial,$active);
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
          <ul class="nav nav-tabs" id="products-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="edit-categories" data-toggle="tab" href="#edit-products" role="tab" aria-controls="home" aria-selected="true">
                Edit products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#add-product" role="tab" aria-controls="profile" aria-selected="false">Add a product</a>
            </li>
          </ul>
          <div class="tab-content" id="products-tabContent">
            <div class="tab-pane fade show active" id="edit-products" role="tabpanel" aria-labelledby="edit-tab">
              <h4 class="my-4">Products</h4>
              <?php
              //if there are products
              if( $products && count($products) > 0 ){
                foreach( $products as $product ){
                  $product_id = $product["id"];
                  $product_name = $product["name"];
                  $product_price = $product["price"];
                  $product_active = ($product["active"] ? "checked" : "");
                  //set row background color
                  $row_bg = ( $product["active"] ? "" : "bg-warning");
                  $product_image = $product["image"];
                  //output rows
                  echo "
                  <form id=\"product-edit-$product_id\" method=\"get\" action=\"$self\">
                    <div class=\"row my-2\">
                      <div class=\"col-2\">
                        <img class=\"img-fluid\" src=\"/images/products/$product_image\">
                      </div>
                      <div class=\"col-4\">
                        <h4>$product_name</h4>
                        <p class=\"price\">$product_price</p>
                      </div>
                      <div class=\"col-3 rounded\">
                        <label class=\"toggle $row_bg\" for=\"product-active-$product_id\">
                          <input type=\"checkbox\" name=\"product_active\" id=\"product-active-$product_id\" value=\"1\" $product_active >
                          <div class=\"toggle-button\"></div>
                          <span class=\"toggle-label\"></span>
                        </label>
                      </div>
                      <div class=\"col-3\">
                        <input type=\"hidden\" value=\"$product_id\" name=\"product_id\">
                        <label class=\"d-block\">Actions</label>
                        <div class=\"btn-group\">
                          <button type=\"submit\" value=\"save\" name=\"submit\" class=\"btn btn-outline-primary\">Update Status</button>
                          <button type=\"submit\" value=\"edit\" name=\"submit\" class=\"btn btn-outline-primary\">Edit Details</button>
                        </div>
                      </div>
                    </div>
                    <hr>
                  </form>
                  ";
                }
              }
              ?>
            </div>
            <div class="tab-pane fade show" id="add-product" role="tabpanel" aria-labelledby="edit-tab">
               <div class="row">
        <div class="col-sm-12">
          <h4 class="my-4">Add Fruit</h4>
          <form id="product-update-1" method="GET" action="<?php echo $self?>">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="product-name">Name</label>
                  <input type="text" class="form-control" id="product-name" name="product_name" value="">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="product-price">Price</label>
                  <input type="text" class="form-control" id="product-price" name="product_price" value=""> 
                </div>
              </div>
              <div class="col">
                <!--see class toggle in styles.css-->
                <label class="toggle" for="product-active">
                  <input type="checkbox" name="product_active" id="product-active" value="" >
                  <div class="toggle-button"></div>
                  <span class="toggle-label"></span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="product-description">Description</label>
                  <textarea name="product_description" class="form-control" rows="4" cols="10" id="product-description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <h5>Existing images</h5>
              </div>
              <div class="col-md-10">
                <div class="w-100 d-flex flex-wrap bg-light product-edit-images" id="product-images">
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
                  <button class="btn btn-outline-primary my-4" type="submit" value="add" name="submit">
                    Save
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
        $('#image-upload').on('change', (event) => {
          let input = event.target;
          //get a reference to the file selected( it's an array )
          let file = input.files[0];
          //calculate size in kilobytes
          let size = Math.ceil(file.size/1024);
          //show first few characters of the file name (limited space)
          let name = file.name.substr(0,6) + '...';
          //file reader object to read file and load a preview on the page
          let reader = new FileReader();
          reader.addEventListener('load', (event) => {
            //the result of the file reader loading the image
            let img = event.target.result;
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
          });
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
                method: 'GET',
                action:'delete'
              })
              .done( ( response ) => {
                console.log(response);
              });
            }
          });
      }
      );
      
    </script>
            </div>
          </div>
      </div>
    </div>
  </body>
   <template id="uploader-template">
    <div class="card w-25 p-2 image-uploader">
      <div class="border border-dark">
        <label for="">
          <img class="img-fluid card-img-top" src="">
        </label>
        <input type="file" id="" name="images[]">
      </div>
      <div class="my-2 text-right">
        <button type="button" class="btn btn-outline-dark btn-sm" data-id="" data-product-id="">
          Remove image
        </button>
      </div>
    </div>
  </template>
</html>