<?php
    // configuration
require_once("../includes/config.php"); 
    // require_once("../includes/connectSQL.php");

    // if user reached page via GET (as by clicking a link or via redirect)
if (is_get_request())
{
        // else render form
  render("login_form.php", ["title" => "Log In"]);
}

    // else if user reached page via POST (as by submitting a form via POST)
if (is_post_request())
{
  $credentials = [];
  $credentials['username'] = h($_POST['username']);
  $credentials['password'] = h($_POST['password']);

  $result = login_db($credentials);

  if($result === true) 
  {
    redirect("/");
  } 
  else 
  {
    $errors = $result;

        // if username or password are wrong
    if(is_blank($errors))
    {

      render("login_form.php", ["errors" => "Please, use valid <strong>username</strong> and <strong>password</strong>"]);
        // remember that user's now logged in by storing user's ID in session
        // store id, username and role type
      $_SESSION["id"] = $row["UserID"];
      $_SESSION["username"] = $info['username']; 
      $_SESSION["role"] = $row["roleName"];  

      return true;
    }
    else
    {
      render("login_form.php", ["errors" => $errors, "username" => $credentials['username']]);
    }
  }
}

?>
