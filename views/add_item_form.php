<link href="/css/add_auction.css" rel="stylesheet"/>

<script type="text/javascript">

        var form_being_submitted = false; // global variable

        function checkForm(form)
        {
          if(form.item_name.value == "") {
            alert("Please enter your first and last names");
            form.firstname.focus();
            return false;
          }
          if(form.item_description.value == "") {
            alert("Please enter your first and last names");
            form.lastname.focus();
            return false;
          }
          return true;
        }

        function resetForm(form)
        {
          form.myButton.disabled = false;
          form.myButton.value = "Submit";
          form_being_submitted = false;
        }

      </script>

      <div style="margin-top: 100px;">

        <div class="container-title">
          <h1>Create Auction</h1>

        </div>
        <!-- edit form column -->
        <div class="form-container">
          <?php if (is_post_request()) { ?> <p style="color:rgb(212, 50, 80); text-align:center" ><?php echo display_errors($errors); ?></p>
            <?php } ?>
          </br>

          
          <form class="form-horizontal" action="add_item.php" role="form" method="POST" enctype="multipart/form-data" onsubmit="
          if(form_being_submitted) {
            submit_btn.disabled = true;
            return false;
          }
          if(checkForm(this)) {
            submit_btn.value = 'Adding item...';
            form_being_submitted = true;
            return true;
          }
          return false;

          ">

          <div class="form-group">
            <label class="col-md-3 control-label">Item image(s)</label>
            <div class="tool_tip tool-tip-first">
              <img src="img/Blue_question_mark_icon.png" height="13px"/>
              <span class="tool_tip_text">Upload 1 to 3 images of your item. NOTE: The first image you upload will be displayed on the item card.
              </span>
            </div>
            <div class="col-md-2 button-upload">
              <input required type="file" name="files[]" id="image" multiple="multiple">
            </div>
          </div>
        </br>


        <div class="form-group">
          <label class="col-md-3 control-label">Item name</label>
          <div class="tool_tip">
            <img src="img/Blue_question_mark_icon.png" height="13px"/>
            <span class="tool_tip_text">10-40 characters
            </span>
          </div>
          <div class="col-md-6">
            <input autocomplete="off" required class="form-control" name="item_name" type="text" value="<?php echo $form['item_name'] ?? '' ?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Item Description</label>
          <div class="tool_tip">
            <img src="img/Blue_question_mark_icon.png" height="13px"/>
            <span class="tool_tip_text">10-500 characters
            </span>
          </div>
          <div class="col-md-6">
            <input autocomplete="off" required rows="3" required class="form-control" name="item_description" type="text" value="<?php echo $form['item_description'] ?? '' ?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Item Start Price</label>
          <div class="tool_tip">
            <img src="img/Blue_question_mark_icon.png" height="13px"/>
            <span class="tool_tip_text">This is the price the item will start bidding at
            </span>
          </div>

          <div class="col-md-6">
            <input autocomplete="off" required class="form-control" name="item_start_price" type="number" value="<?php echo $form['item_start_price'] ?? '' ?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Item Reserve Price</label>
          <div class="tool_tip">
            <img src="img/Blue_question_mark_icon.png" height="13px"/>
            <span class="tool_tip_text">This is the price the auction has to reach in order to be valid
            </span>
          </div>
          <div class="col-md-6">
            <input autocomplete="off" required class="form-control" name="item_reserve_price" type="number" value="<?php echo $form['item_reserve_price'] ?? '' ?>">
          </div>
        </div>



        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <select required name="ItemCategory" class="selectdrop">
              <option value="">Category</option>
              <optgroup></optgroup>
              <option value="1">Luxury</option>
              <option value="2">Sports</option>
              <option value="3">Electronics</option>
              <option value="4">Entertainment</option>
              <option value="5">Apparel</option>
              <option value="6">Collectibles</option>
            </select> 

            <select required name="ItemCondition" class="selectdrop">
              <option value="">Condition</option>
              <optgroup></optgroup>
              <option value="5">New</option>
              <option value="4">Excellent</option>
              <option value="3">Good</option>
              <option value="2">Average</option>
              <option value="1">Bad</option>
            </select> 

            <select required name="ETime" class="selectdrop">
              <option value="">Duration</option>
              <optgroup></optgroup>
              <option value="one">1 day</option>
              <option value="five">5 days</option>
              <option value="ten">10 days</option>
              <option value="fifteen">15 days</option>
              <option value="month">1 month</option>
            </select> 
          </div>
        </div> 
        <br>
        <div class="form-group submit-button">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input name="submit_btn" type="submit" href="add_item.php" class="btn btn-primary" value="Add Item">
            <input type="button"  value="Return" class="btn btn-default" onClick="document.location.href='index.php'" />
          </div>
        </div>
      </form>
    </div>
  </div>
  <hr>

  <style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>
