<?php

    // configuration
require("../includes/config.php"); 
    // require("../includes/connectSQL.php");
    
if (is_get_request())
{
        // else render form
    $bidsList = displayBid_db();
    $currentBids = null;
    $pastBids = null;
    for($i = 0; $i < count($bidsList); $i++) {
        $endTime = $bidsList[$i]['EndTime'];
        $today = date("Y-m-d H:i:s");
        if ($today <= $endTime) {
            $currentBids[count($currentBids)] = $bidsList[$i];
        }
        else {
            $pastBids[count($pastBids)] = $bidsList[$i];
        }
    }
    
    
    
    // print_r($bidsList);
    render("mybids_view.php", ["title" => "My Bids", 'currentBids' => $currentBids, 'pastBids' => $pastBids]);
}







?>