<?php

    // configuration
require("../includes/config.php"); 
    // require("../includes/connectSQL.php");

if (is_get_request())
{
        // else render form
    $bidsList = displayBid_db();
    // print_r($bidsList);
    render("mybids_view.php", ["title" => "My Bids", 'bidsList' => $bidsList]);
}







?>