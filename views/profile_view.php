<div style="margin-top: 100px;">

  <div class="container">
    <h1>Edit Profile</h1>
    <div class="row">
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">   

        <h3>Personal info</h3>
        <?php if (isset($error_message)) { ?>
        <div id="firstnamealert" class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          <?php echo $error_message[0]?? '';?>
        </div> 
        <?php } ?>


        
        <form action="profile.php" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="firstname" value="<?php echo $form['FirstName'] ?? $firstname;?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="lastname" value="<?php echo $form['LastName'] ?? $lastname;?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="email" value="<?php echo $form['Email'] ?? $email;?>">
            </div>
          </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label>
          <div class="col-md-8">
            <input disabled class="form-control" name="username" type="text" value="<?php echo $user['Username'] ?? $username;?>" >
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Password:</label>
          <div class="col-md-8">
            <input autocomplete="off" class="form-control" type="password" name="password" placeholder="Type new password here if you want to change your password" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Confirm password:</label>
          <div class="col-md-8">
            <input autocomplete="off" class="form-control" type="password" name="confirmation" placeholder="Confirm your new password" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input type="submit" class="btn btn-primary" value="Save Changes">
            <input type="button" onclick="location.href='index.php';" class="btn btn-default" value="Cancel">

          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<hr>

</div>

<style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>











