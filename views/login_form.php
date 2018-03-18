
<form action="login.php" method="post">
    <fieldset class="login-container">
        <h3 class="signin-text">Sign In</h3>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="username" placeholder="Username" type="text" value="<?php echo $username ?? ''; ?>" />
        </div>
        <div class="form-group">
            <input class="form-control" name="password" placeholder="Password" type="password" />
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span> Sign In
            </button>
        </div>
        <div class="register">
            or  <a href="register.php">register</a> for an account <br>
             <?php if (is_post_request()) { ?> <p style="color:rgb(212, 50, 80);"><?php echo $errors; ?></p>
                 <?php } ?>
        </div>
    </fieldset>    
</form>
