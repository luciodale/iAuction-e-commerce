<div style="margin-top: 100px;">

  <div class="container">
    <h1>Edit Profile</h1>
    <div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
          <h6>Upload a different photo...</h6>
          
          <input type="file" class="form-control">
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">   

        <h3>Personal info</h3>
        <?php if (isset($error_message)) { ?>
        <div id="firstnamealert" class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          <?php echo htmlspecialchars($error_message);?>
        </div> 
        <?php } ?>


        
        <form action="profile.php" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="firstname" value="<?php echo htmlspecialchars($firstname);?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="lastname" value="<?php echo htmlspecialchars($lastname);?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="email" value="<?php echo htmlspecialchars($email);?>">
            </div>
          </div>
<!--
          <div class="form-group">
            <label class="col-lg-3 control-label">Time Zone:</label>
            <div class="col-lg-8">
              <div class="ui-select">
                <select id="user_time_zone" name="timezone" class="form-control">
                  <option value="Hawaii">(GMT-10:00) Hawaii</option>
                  <option value="Alaska">(GMT-09:00) Alaska</option>
                  <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                  <option value="Arizona">(GMT-07:00) Arizona</option>
                  <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                  <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                  <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                  <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                </select>
              </div>
            </div>
          </div>
        -->
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label>
          <div class="col-md-8">
            <input class="form-control" name="username" type="text" value="<?php echo htmlspecialchars($username);?>" >
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Password:</label>
          <div class="col-md-8">
            <input class="form-control" type="password" name="password" placeholder="Type new password here if you want to change your password" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Confirm password:</label>
          <div class="col-md-8">
            <input class="form-control" type="password" name="confirmation" placeholder="Confirm your new password" value="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input type="submit" class="btn btn-primary" value="Save Changes">
            <span></span>
            <input type="reset" class="btn btn-default" value="Cancel">

          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<hr>


</div>



<!-- 
<table>
  <tr>
    <td>IN TR</td>
  </tr>

  <tr>
    <td id="days">23</td>
    <td id="hours">43</td>
    <td id="minutes">12</td>
    <td id="seconds">43</td>
  </tr>

  <tr>
    <td>D</td>
    <td>H</td>
    <td>M</td>
    <td>S</td>
  </tr>
</table>

<script type="text/javascript">

  function countdown(){

    var now = new Date();
    var eventDate = new Date(2018, 1, 25);

    var currentTime = now.getTime();
    var eventDate = eventDate.getTime();
    var remTime = eventDate - currentTime;

    var s = Math.floor(remTime / 1000);
    var m = Math.floor(s / 60);
    var h = Math.floor(m / 60);
    var d = Math.floor(h / 24);

    h %= 24;
    m %= 60;
    s %= 60;

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    document.getElementById('days').textContent = d + ":";
    document.getElementById('hours').textContent = h + ":";
    document.getElementById('minutes').textContent = m + ":";
    document.getElementById('seconds').textContent = s;

//calling function countdown after 1 second
setTimeout(countdown, 1000);
}

  countdown();



</script>
 -->















