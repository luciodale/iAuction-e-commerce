<?php

    // configuration
    require("../includes/config.php");
    // require("../includes/connectSQL.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("pass_form.php", ["title" => "Change Password"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate dat hoeeee
        if (empty($_POST["old_password"]))
        {
            apologize("You must provide your old password.");
        }
        else if (empty($_POST["new_password"]))
        {
            apologize("You must provide a new password.");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must re-enter your new password.");
        }
        
        //see if last two match
        if (($_POST["new_password"] != $_POST["confirmation"]))
        {
            apologize("The new passwords you provided do not match!");
        }
        
        //extract password and check if old password matches the current one
        //$rows = CS50::query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"]);
        $stmt = $pdo->prepare("SELECT hash FROM users WHERE id = ?");
        $stmt->execute(array($_SESSION["id"]));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (password_verify($_POST["old_password"], $row["hash"]))
            {
                if (($_POST["new_password"] == $_POST["confirmation"]))
                {
                    //update password
                    $stmt = $pdo->prepare("UPDATE users SET hash = ? WHERE id = ?");
                    $stmt->execute(array(password_hash($_POST["new_password"], PASSWORD_DEFAULT), $_SESSION["id"]));
                    $affected_rows = $stmt->rowCount();
                    
                    //redirect to portfolio
                    redirect("/");
                }
                else
                {
                    apologize("Wrong password/the passwords you entered don't match!");
                }
            }
            else
            {
                apologize("Wrong password/the passwords you entered don't match!");
            }
    }
        
?>