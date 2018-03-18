
<form action="register.php" method="post">


 <fieldset class="login-container container-register"> 

    <!-- FORM TITLE -->
    <h3 class="signin-text">Register</h3>


    <div class="right-side-form">

        <!-- RADIO BUTTONS -->
        <div class="form-group form-group_register">
            <p class="radio-buttons">Buyer</p>
            <input autocomplete="off" autofocus class="form-control" name="role" value="1" placeholder="Type" type="radio" tabindex=5 checked>

            <br>

            <p class="radio-buttons">Seller</p>
            <input autocomplete="off" autofocus class="form-control" name="role" value="2" placeholder="Type" tabindex=6 type="radio">
        </div>

        <br>

        <!-- PASSWORD FIELDS -->
        <div style="margin-top:-12px;">
          <div class="form-group form-group_register">
            <input class="form-control" name="password" placeholder="password" value="<?php echo $form['password'] ?? '' ?>" tabindex=7 type="password"/>
        </div>
        <div class="form-group form-group_register">
            <input class="form-control" name="confirmation" placeholder="re-enter Password" value="<?php echo $form['confirmation'] ?? '' ?>" tabindex=8 type="password"/>
        </div>

    </div>
</div>


<div class="left-side-form">

    <!-- USERNAME -->
    <div class="form-group form-group_register">
        <input autocomplete="off" autofocus class="form-control" name="username" placeholder="username" type="text" tabindex=1 value="<?php echo $form['username'] ?? '' ?>" autofocus/>
    </div>

    <!-- EMAIL -->
    <div class="form-group form-group_register">
        <input autocomplete="off" autofocus class="form-control" name="email" placeholder="email" value="<?php echo $form['email'] ?? '' ?>" type="text" tabindex=2 />
    </div>

    <!-- FIRST NAME -->
    <div class="form-group form-group_register">
        <input autocomplete="off" autofocus class="form-control" name="firstname" placeholder="first name" value="<?php echo $form['firstname'] ?? '' ?>" type="text" tabindex=3/>
    </div>

    <!-- LASTNAME -->
    <div class="form-group form-group_register">
        <input autocomplete="off" autofocus class="form-control" name="lastname" placeholder="last name" value ="<?php echo $form['lastname'] ?? '' ?>" tabindex=4 type="text"/>
    </div>

    <!-- REGISTER BUTTON -->
    <div class="form-group form-group_register">
        <button class="btn btn-default" type="submit" style="width:150px;">
            <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
            Register
        </button>

        <!-- WARNING MESSAGES -->
        <div class="register" style="margin-top: 10px;">
            or <a href="login.php">sign in</a> if you have an account <br>
            <?php if (is_post_request()) { ?> <p style="color:rgb(212, 50, 80);"><?php echo display_errors($errors); ?></p>
             <?php } ?>
         </div>
     </div>
 </div>
</fieldset>
</form>
