<?php

    // configuration
require("../includes/config.php");

$userinfo = $pdo->prepare("SELECT * FROM users WHERE UserID = ?");
$userinfo->execute(array($_SESSION["id"]));
$res = $userinfo->fetchAll();

    // get data from database
$firstname = $res[0]["FirstName"];
$lastname = $res[0]["LastName"];
$username = $res[0]["Username"];
$email = $res[0]["Email"];
$password = $res[0]["Password"];


if (is_get_request())
{

        // else render form
    render("profile_view.php", ["title" => "Edit Profile", "firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email]);
}

    // else if user reached page via POST (as by submitting a form via POST)
else if (is_post_request())
{

    $input['FirstName'] = h($_POST['firstname']);
    $input['LastName'] = h($_POST['lastname']);
    $input['Email'] = h($_POST['email']);
    $input['Password'] = h($_POST['password']);
    $conf['Confirmation'] = h($_POST['confirmation']);
    $user['Username'] = $username;

    $result = editProfile_db($input, $conf);

    if($result === true) 
    {
        $errors[0] = "Your changes have been updated!";
        render("profile_view.php", ["error_message" => $errors, "form" => $input, "user" => $user]);
    } 
    else 
    {   
        $errors = $result;
        render("profile_view.php", ["title" => "Edit Profile", "firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email, "error_message" => $errors]);
    }
}


?>




