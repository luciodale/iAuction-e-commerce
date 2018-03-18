<?php

    // configuration
require("../includes/config.php"); 
    // require("../includes/connectSQL.php");

if (is_get_request())
{
    if (!empty($_GET['id'])) {
        $delItemID = $_GET['id'];
        deleteAuction_db($delItemID);
        redirect("myauctions.php");
    }
    
    else {
        // else render form
        $auctionsList = displayAuctions_db();
        $currentAuctions = null;
        $pastAuctions = null;
        for($i = 0; $i < count($auctionsList); $i++) {
            $endTime = $auctionsList[$i]['EndTime'];
            $today = date("Y-m-d H:i:s");
            if ($today <= $endTime) {
                $currentAuctions[count($currentAuctions)] = $auctionsList[$i];
            }
            else {
                $pastAuctions[count($pastAuctions)] = $auctionsList[$i];
            }
        }
        render("myauctions_view.php", ["title" => "My Auctions", 'currentAuctions' => $currentAuctions, 'pastAuctions' => $pastAuctions]);
    }
    
}
else {
    
    $newRating = h($_POST['star']);
    $ratedOrder = h($_POST['orderID']);
    
    // query to save rating
    saveRating_db($ratedOrder, $newRating);
    
    $auctionsList = displayAuctions_db();
        $currentAuctions = null;
        $pastAuctions = null;
        for($i = 0; $i < count($auctionsList); $i++) {
            $endTime = $auctionsList[$i]['EndTime'];
            $today = date("Y-m-d H:i:s");
            if ($today <= $endTime) {
                $currentAuctions[count($currentAuctions)] = $auctionsList[$i];
            }
            else {
                $pastAuctions[count($pastAuctions)] = $auctionsList[$i];
            }
        }
        render("myauctions_view.php", ["title" => "My Auctions", 'currentAuctions' => $currentAuctions, 'pastAuctions' => $pastAuctions]);
    
}







?>