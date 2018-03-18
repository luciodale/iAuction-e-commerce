<?php

    // configuration
require("../includes/config.php");
    // require("../includes/connectSQL.php");

    // if user reached page via GET (as by clicking a link or via redirect)
if (is_get_request()) 
{
        // render form
    render("register_form.php", ["title" => "Registration"]);
}

    // else if user reached page via POST (as by submitting a form via POST)
else if (is_post_request()) 
{
    // escaping all possible injections via htmlspecialchars function
    $form = [];
    $form['username'] = h($_POST['username']);
    $form['email'] = h($_POST['email']);
    $form['firstname'] = h($_POST['firstname']);
    $form['lastname'] = h($_POST['lastname']);
    $form['password'] = h($_POST['password']);
    $form['confirmation'] = h($_POST['confirmation']);
    $form['role'] = h($_POST['role']);

// connection database
    $result = register_db($form);

    if($result === true) 
    {
        redirect("/");
    } 
    else 
    {
        $errors = $result;
        render("register_form.php", ["errors" => $errors, "form" => $form]);
    }
}
