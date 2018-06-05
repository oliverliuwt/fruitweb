<?php
include('autoloader.php');

?>
<!doctype html>
<html>
  <?php include ('includes/head.php'); ?>
  <style>
    #categories:empty::after{
      content:"no categories";
      position: relative;
    }
    #products{
      min-height:500px;
      position: relative;
    }
    .spinner{
      position: absolute;
      max-width: 60px;
      top:50%;
      left:50%;
    }
  </style>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2">
          <nav id="categories" class="nav nav-pills flex-column justify-content-start align-items-start"></nav>
        </div>
        <div class="col-md-10">
          <div id="products" class="row d-flex flex-wrap"></div>
        </div>
      </div>
    </div>
  
  <script>
    $(document).ready(
      () => {
        //GET CATEGORIES
        //get currently selected category
        let url_params = new URLSearchParams(window.location.search);
        let current_category = url_params.get('category');
        if( !current_category ){
          current_category = 0;
        }
        //get current url
        let current_url = window.location.pathname;
        //get current page number
        let current_page = url_params.get('page');
        if( !current_page ){
          current_page = 1;
        }
        
        //add spinner to categories container
        $('#categories').html('<img class="spinner" src="/images/graphics/spinner1.gif">');
        //make ajax request to ajax/categories.ajax.php
        $.ajax({
          url: '/ajax/categories.ajax.php',
          dataType: 'json',
          method: 'get'
        }).done( (response) => {
          if( response.length > 0 ){
            //empty the target element
            $('#categories').empty();
            response.forEach( (item) => { 
              //get reference to template content
              template = $('#categories-template').html().trim();
              //create clone of template
              let clone = $(template);
              //fill clone with data
              let name = item.category_name;
              let id = item.category_id;
              $(clone).attr('href', current_url + '?' + 'category=' + id);
              if( id == current_category ){
                $(clone).addClass('active');
              }
              $(clone).text(name);
              $('#categories').append( clone );
            });
          }
        });
        
        //GET PRODUCTS
        let product_data = { category: current_category, page: current_page };
        //add spinner to categories container
        $('#products').html('<img class="spinner" src="/images/graphics/spinner1.gif">');
        $.ajax({
          url: '/ajax/products.ajax.php',
          data: product_data,
          dataType: 'json',
          method: 'get'
        })
        .done( (response) => {
          if( response.length > 0 ){
            //empty the target element
            $('#products').empty();
            response.forEach( (item) => { 
              //get reference to template content
              template = $('#product-template').html().trim();
              //create clone of template
              let clone = $(template);
              //fill clone with data
              
              let id = item.id;
              let name = item.name;
              let price = item.price;
              let description = item.description;
              let image = item.image;
              
              //fill the template with data
              let detail_url = 'detail.php' + '?' + 'product_id=' + id;
              $(clone).find('a').attr('href', detail_url);
              $(clone).find('.product-name').text(name);
              let image_url = '/images/products/' + image;
              $(clone).find('.product-thumbnail').attr('src', image_url );
              $(clone).find('.product-price').text(price);
              $(clone).find('.product-description').html(description);
              
              //append the template to the product container
              $('#products').append( clone );
            });
          }
        });
      }
    );
  </script>
  </body>
</html>
<template id="categories-template">
  <a class="nav-link w-100" href=""></a>
</template>
<template id="product-template">
  <div class="col-sm-3 product-column">
    <a href="">
      <h4 class="product-name"></h4>
      <img class="img-fluid product-thumbnail" src="">
      <h5 class="price product-price"></h5>
      <p class="product-description"></p>
    </a>
  </div>
</template>