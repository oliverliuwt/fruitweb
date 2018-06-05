<?php
include('../autoloader.php');
$root = $_SERVER["DOCUMENT_ROOT"];
$self = basename($_SERVER["PHP_SELF"]);
//create instance of category class
$category = new Categories();


if( $_SERVER["REQUEST_METHOD"] == "POST" ){
  
  //array for errors
  $errors = array();
  
  //array for success
  $success = array();
  
  //adding a new category
  if( $_POST["submit"] == "add" ){
    //check category name
    $category_name = $_POST["category_name"];
    //check category parent
    $category_parent = $_POST["category_parent"];
    //check category active
    $category_active = $_POST["category_active"];
    //process the request
    $new_category = $category -> create($category_name,$category_parent,$category_active);
    if( $new_category == false ){
      $errors["add"] = "Error adding category";
    }
    else{
      $success["add"] = "Category $category_name has been added";
    }
  }
  if( $_POST["submit"] == "update" ){
    $category_id = $_POST["category_id"];
    $category_name = $_POST["category_name"];
    $category_parent = $_POST["category_parent"];
    $category_active = $_POST["category_active"];
    $update_category = $category -> update($category_id,$category_name,$category_parent,$category_active);
    if( $update_category == false ){
      $error["update"] = "Error updating category";
    }
    else{
      $success["update"] = "Category $category_name has been updated";
    }
  }
  if( $_POST["submit"] == "delete" ){
    $category_id = $_POST["category_id"];
    
    $delete_category = $category -> remove($category_id);
    if( $delete_category == false ){
      $error["delete"] = "Error removing category";
    }
    else{
      $success["delete"] = "Category $category_name has been deleted";
    }
  }
}

//get existing categories
$categories = $category -> getCategories();

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
        <div class="col">
          <?php
          //output any errors
          if( count($errors) > 0 ){
            $err_msg = implode(" ",$errors);
            echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
                    <strong>There has been an error</strong> $err_msg
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                      <span aria-hidden=\"true\">&times;</span>
                    </button>
                  </div>";
          }
          //output any success
          if( count($success) > 0){
            $sc_msg = implode(" ",$success);
            echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <strong>Successful</strong> $sc_msg
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                      <span aria-hidden=\"true\">&times;</span>
                    </button>
                  </div>";
          }
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <ul class="nav nav-tabs" id="categories-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="edit-categories" data-toggle="tab" href="#edit" role="tab" aria-controls="home" aria-selected="true">
                Edit categories
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#add" role="tab" aria-controls="profile" aria-selected="false">Add a category</a>
            </li>
          </ul>
          <div class="tab-content" id="categories-tabContent">
            <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
              <div class="row">
                <div class="col">
                  <h4>Edit categories</h4>
                </div>
              </div>
              <?php
              if( count( $categories ) > 0 ){
                foreach( $categories as $cat ){
                  $cat_id = $cat["category_id"];
                  $cat_name = $cat["category_name"];
                  $cat_parent = $cat["parent_id"];
                  $cat_active = $cat["active"];
                  
                  if( $cat_active ){
                    $check_value = "checked";
                  }
                  else{
                    unset($check_value);
                  }
                  //output form for the category
                  echo "
                    <form id=\"edit-category-$cat_id\" method=\"post\" action=\"$self\">
                    <div class=\"row\">
                      <div class=\"col-md-3 col-sm-12\">
                        <label class=\"\" for=\"category-name-$cat_id\">Name</label>
                        <input id=\"category-name-$cat_id\" name=\"category_name\" type=\"text\" class=\"form-control d-md-inline mr-4\" value=\"$cat_name\">
                      </div>
                      <div class=\"col-md-3 col-sm-12\">
                        <label class=\"mr-2\" for=\"category-parent-$cat_id\">Parent</label>
                        <select id=\"category-parent-$cat_id\" name=\"category_parent\" class=\"form-control mr-4\" style=\"min-width:220px;\">
                          <option value=\"0\">None</option>";
                         //output existing categories
                         foreach( $categories as $cat_option ){
                           $cat_option_id = $cat_option["category_id"];
                           $cat_option_name = $cat_option["category_name"];
                           if($cat_option_id == $cat_id){
                             continue;
                           }
                           else{
                             if( $cat_option_id == $cat_parent ){
                                 $cat_selected = "selected";
                             }
                             else{
                               unset( $cat_selected );
                             }
                             echo "<option value=\"$cat_option_id\" $cat_selected>$cat_option_name</option>";
                           }
                         
                         }
                  echo "</select>
                      </div>
                      <div class=\"col-md-3\">
                        <label class=\"toggle\" for=\"category-active-$cat_id\">
                          <input type=\"checkbox\" name=\"category_active\" id=\"category-active-$cat_id\" value=\"1\" $check_value>
                          <div class=\"toggle-button\"></div>
                          <span class=\"toggle-label\"></span>
                        </label>
                      </div>
                      <div class=\"col-md-3\">
                        <input type=\"hidden\" name=\"category_id\" value=\"$cat_id\">
                        <label class=\"d-block\" for=\"buttons-$cat_id\">Action</label>
                        <div class=\"btn-group\" id=\"buttons-$cat_id\">
                          <button class=\"btn btn-primary\" name=\"submit\" value=\"update\">
                            Save
                          </button>
                          <button class=\"btn btn-warning\" name=\"submit\" value=\"delete\">
                            &times;
                          </button>
                        </div>
                      </div>
                    </div>
                    </form>
                    <hr>
                  ";
                }
                unset( $cat );
              }
              ?>
            </div>
            <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="profile-tab">
              <div class="row">
                <div class="col-md-6">
                  <h4>Add a new category</h4>
                  <form id="add-category" method="post" action="">
                    <div class="form-group">
                      <label for="category-name">Category Name</label>
                      <input id="category-name" name="category_name" class="form-control" type="text" placeholder="category name" required>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="category-parent">Parent Category</label>
                          <select id="category-parent" class="form-control" name="category_parent" style="max-width:300px;">
                            <option value="0">None</option>
                            <?php
                            if( count($categories) > 0 ){
                              foreach( $categories as $cat ){
                                $cat_id = $cat["category_id"];
                                $cat_name = $cat["category_name"];
                                echo "<option value=\"$cat_id\">$cat_name</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-check">
                          <label class="toggle" for="category-active">
                            <input type="checkbox" name="category_active" id="category-active" value="1" checked >
                            <div class="toggle-button"></div>
                            <span class="toggle-label"></span>
                          </label>
                        </div>
                        <br>
                        <button type="submit" name="submit" value="add" class="btn btn-outline-dark">
                          Add new category
                        </button>
                      </div>
                    </div>
                        
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          
          
          
        </div>
      </div>
    </div>
  </body>
</html>