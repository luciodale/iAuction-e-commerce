<?php

require_once("../includes/config.php");

if (is_get_request())
{
    $myPurchases = displayPurchases_db();
    
    // print_r($bidsList);
    render("buyingsummary_view.php", ["title" => "My Purchases", 'myPurchases' => $myPurchases]);
}

else {
    $newRating = h($_POST['star']);
    $ratedOrder = h($_POST['orderID']);
    
    // query to save rating
    saveRating_db($ratedOrder, $newRating);
    // load purchases again
    $myPurchases = displayPurchases_db();
    render("buyingsummary_view.php", ["title" => "My Purchases", 'myPurchases' => $myPurchases]);
}

?>
