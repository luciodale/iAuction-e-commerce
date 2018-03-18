<div style="margin-top: 100px;">

  <div class="container">
    <h1>Add Item</h1>
    <div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="//placehold.it/100" class="avatar img-thumbnail" alt="avatar">
          <h6>Upload item photo</h6>
          

          <form action="upload.php" enctype="multipart/form-data" method="post"> 
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
            <input type="file" name="test" multiple="multiple">
            <br>
            <input type="submit" name="submit" value="submit">
          </form>
        </div>
      </div>




      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <?php if (is_post_request()) { ?> <p style="color:rgb(212, 50, 80);"><?php echo display_errors($errors); ?></p>
          <?php } ?>
          <h3>Item Information</h3>

          <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <input type="file" name="files[]" id="image" multiple="multiple">
            <div class="form-group">
              <label class="col-lg-3 control-label">Item name:</label>
              <div class="col-lg-8">
                <input class="form-control" name="item_name" type="text" value="<?php echo $form['item_name'] ?? '' ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Item Start Price (GBP) :</label>
              <div class="col-lg-8">
                <input class="form-control" name="item_start_price" type="number" value="<?php echo $form['item_start_price'] ?? '' ?>">
              </div>
            </div>
             <div class="form-group">
              <label class="col-lg-3 control-label">Item Reserve Price (GBP) :</label>
              <div class="col-lg-8">
                <input class="form-control" name="item_reserve_price" type="number" value="<?php echo $form['item_reserve_price'] ?? '' ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Item Description:</label>
              <div class="col-lg-8">
                <input class="form-control" name="item_description" type="text" value="<?php echo $form['item_description'] ?? '' ?>">
              </div>
            </div>
            <div class="form-group">
              <select name="ItemCategory" class="selectdrop">
                <option value="notSelected">Category</option>
                <optgroup></optgroup>
                <option value="Luxury">Luxury</option>
                <option value="Sports">Sports</option>
                <option value="Electronics">Electronics</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Apparel">Apparel</option>
                <option value="Collectibles">Collectibles</option>
              </select> 
            
              <select name="ItemCondition" class="selectdrop">
                <option value="notSelected">Condition</option>
                <optgroup></optgroup>
                <option value="New">New</option>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                <option value="Bad">Bad</option>
              </select> 
           
              <select name="ETime" class="selectdrop">
                <option value="notSelected">Duration</option>
                <optgroup></optgroup>
                <option value="one">1 day</option>
                <option value="five">5 days</option>
                <option value="ten">10 days</option>
                <option value="fifteen">15 days</option>
                <option value="month">1 month</option>
              </select> 
            </div> <br><br>
              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                  <input type="submit" href="add_item.php" class="btn btn-primary" value="Add Item">
                  <input type="button"  value="Return" class="btn btn-default" onClick="document.location.href='index.php'" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <hr>


    </div>