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

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        
        // else render form
        render("profile.php", ["title" => "profileGET", "firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email, "password" => $password]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if (empty($_POST["username"]) || empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"]))
        {
            $error_message = "Could not save changes. Your firstname, lastname, username and email are required.";
            render("profile.php", ["title" => "profileGET", "firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email, "error_message" => $error_message]);
        }
        
        else if ((!(empty($_POST["password"])) || !(empty($_POST["confirmation"]))) && ($_POST["password"] != $_POST["confirmation"]))
        {
            $error_message = "Could not save changes. Your passwords did not match";
            render("profile.php", ["title" => "profileGET", "firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email, "error_message" => $error_message]);
        }
        
        else {
            // save changes in Database
            
            // update information 
            $updateinfo = $pdo->prepare("UPDATE users SET FirstName = ?, LastName = ?, Username = ?, Email = ? WHERE UserId = ?");
            $updateinfo->execute(array($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["email"], $_SESSION["id"] ));
            
            $error_message = "Success. Your changes were saved.";
            
            // update password if not empty
            if (!(empty($_POST["password"])) && !(empty($_POST["confirmation"])) && ($_POST["password"] == $_POST["confirmation"])) {
                
                if (password_verify($_POST["password"], $password)) {
                    $error_message = "Your password was not changed. You entered your old password.";
                }
                
                else {
                    $updatepassword = $pdo->prepare("UPDATE users SET Password = ? WHERE UserId = ?");
                    $updatepassword->execute(array(password_hash($_POST["password"], PASSWORD_DEFAULT), $_SESSION["id"]));

                    $error_message = "Success. Your changes were saved and password was changed.";
                    
                }
            }
            
            render("profile.php", ["title" => "profileGET", "firstname" => $_POST["firstname"], "lastname" => $_POST["lastname"], "username" => $_POST["username"], "email" => $_POST["email"], "error_message" => $error_message]);
        }

        


        
        
    }




?>




