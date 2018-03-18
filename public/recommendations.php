<?php

require_once("../includes/config.php");

$objects = displayAuction2_db();
$GridInfo = $objects[0];
$GridImages = $objects[1];
$recommendedGridInfo = null;
$recommendedGridImages = null;
$heading1 = null; 
$heading2 = null;
$optionSelected = null;
$recommendedItems = null;

if (is_get_request()) {
    
    if (count($GridInfo) == 0) {
    $heading1 = "No items to show";
    $heading2 = "There are no currently active auctions so unfortunately we cannot give any recommendations";
    $optionSelected = "bids";
    }
    
    else {
        
        if (isset($_GET['type'])) {
            if(h($_GET['type']) == 'pop') {
                $recommendedItems = getPopularRecommendations($GridInfo, $GridImages);
                $recommendedGridInfo = $recommendedItems[0];
                $recommendedGridImages = $recommendedItems[1];
                $heading1 = "Popular items";
                $heading2 = "These are the most popular items on sale";
                $optionSelected = "popular";   
            }
        }
            
        else {
            
            $recommendedItems = getBidRecommendations($GridInfo, $GridImages);
            $recommendedGridInfo = $recommendedItems[0];
            $recommendedGridImages = $recommendedItems[1];

            if (count($recommendedGridInfo) > 0) {
                $heading1 = "Recommendations for you based on your bids";
                $heading2 = "These are the items, that people who have bid on the same things as you have also bid on.";
                $optionSelected = "bids";
            }
            else {

                $recommendedItems = getViewsRecommendations($GridInfo, $GridImages);
                $recommendedGridInfo = $recommendedItems[0];
                $recommendedGridImages = $recommendedItems[1];

                if (count($recommendedGridInfo) > 0) {
                    $heading1 = "View Recommendations";
                    $heading2 = "These are recommendations based on popular items in your recently most viewed categories (excluding your recent views)";
                    $optionSelected = "views";
                }

                else {

                    $recommendedItems = getPopularRecommendations($GridInfo, $GridImages);
                    $recommendedGridInfo = $recommendedItems[0];
                    $recommendedGridImages = $recommendedItems[1];
                    $heading1 = "Popular items";
                    $heading2 = "These are the most popular items on sale";
                    $optionSelected = "popular";

                }
            }

        }
    
    }
    
}

else {
    $optionSelected = h($_POST['optionSelected']);
    
    if(count($GridInfo) == 0) {
    $heading1 = "No items to show";
    $heading2 = "There are no currently active auctions so unfortunately we cannot give any recommendations";
    }
    else if ($optionSelected == 'bids') {
        $recommendedItems = getBidRecommendations($GridInfo, $GridImages);
        $recommendedGridInfo = $recommendedItems[0];
        $recommendedGridImages = $recommendedItems[1];
        $heading1 = "Recommendations for you based on your bids";
        if (count($recommendedGridInfo)>0) {
            $heading2 = "These are the items, that people who have bid on the same things as you have also bid on.";
        }
        else {
            $heading2 = "We could not make recommendations based on your bids. This could be because you haven't bid on anything yet, or there aren't enough items on sale";
        }       
    }
        
    else if ($optionSelected == 'popular') {
        $recommendedItems = getPopularRecommendations($GridInfo, $GridImages);
        $recommendedGridInfo = $recommendedItems[0];
        $recommendedGridImages = $recommendedItems[1];
        $heading1 = "Popular items";
        $heading2 = "These are the most popular items on sale";
    }
    
    else if ($optionSelected == 'views') {
        $recommendedItems = getViewsRecommendations($GridInfo, $GridImages);
        $recommendedGridInfo = $recommendedItems[0];
        $recommendedGridImages = $recommendedItems[1];
        $heading1 = "View Recommendations";
        if (count($recommendedGridInfo)>0) {
            $heading2 = "These are recommendations based on popular items in your recently most viewed categories (excluding your recent views)";
        }
        else {
            $heading2 = "We could not make recommendations based on popular items in your recently most viewed categories (excluding your recent views), this could be because there aren't enough items on sale. Try looking at popular items instead";
        }
    }
}
            
function getPopularRecommendations($GridInfo, $GridImages) {
    $recommendedGridInfo = null;
    $recommendedGridImages = null;
    $popularViewItemsArray = null;
    
    $popViewItems = getPopularViewActiveItems();
    
    for($i = 0; $i < count($popViewItems); $i++) {
    $popularViewItemsArray[$i] = $popViewItems[$i]['ItemID'];
    }
    
    if(count($popularViewItemsArray)>0) {
        $popularViewItemsArray = array_slice($popularViewItemsArray, 0, 12);
        for($i = 0; $i < count($GridInfo); $i++) {
            if ( in_array($GridInfo[$i]['ItemID'], $popularViewItemsArray) ) {
                $recommendedGridInfo[count($recommendedGridInfo)] = $GridInfo[$i];
                $recommendedGridImages[count($recommendedGridImages)] = $GridImages[$i];  
            }
        }
    }
    
    return array($recommendedGridInfo, $recommendedGridImages);
}

function getViewsRecommendations($GridInfo, $GridImages) {
    $recommendedGridInfo = null;
    $recommendedGridImages = null;
    $recommendedItemsArray = null;
    
    $recommendedItems = getViewsRecommendations_db();
    
    for($i = 0; $i < count($recommendedItems); $i++) {
        $recommendedItemsArray[$i] = $recommendedItems[$i]['ItemID'];
    }
    
    if(count($recommendedItemsArray)>0) {
        for($i = 0; $i < count($GridInfo); $i++) {
            if ( in_array($GridInfo[$i]['ItemID'], $recommendedItemsArray) ) {
                $recommendedGridInfo[count($recommendedGridInfo)] = $GridInfo[$i];
                $recommendedGridImages[count($recommendedGridImages)] = $GridImages[$i];  
            }
        }
    }
    
    return array($recommendedGridInfo, $recommendedGridImages);
}

function getBidRecommendations($GridInfo, $GridImages) {
    $recommendedGridInfo = null;
    $recommendedGridImages = null;
    $recommendedItemsArray = null;
    
    $recommendedItems = getRecommendationsBasedOnBids();
    
    for($i = 0; $i < count($recommendedItems); $i++) {
        $recommendedItemsArray[$i] = $recommendedItems[$i]['ItemID'];
    }
    
    if(count($recommendedItemsArray)>0) {
        for($i = 0; $i < count($GridInfo); $i++) {
            if ( in_array($GridInfo[$i]['ItemID'], $recommendedItemsArray) ) {
                $recommendedGridInfo[count($recommendedGridInfo)] = $GridInfo[$i];
                $recommendedGridImages[count($recommendedGridImages)] = $GridImages[$i];  
            }
        }
    }
    
    return array($recommendedGridInfo, $recommendedGridImages);
        
}





render("recommendations_view.php", ["GridInfo" => $recommendedGridInfo, "GridImages" => $recommendedGridImages, "heading1" => $heading1, "heading2" => $heading2, "optionSelected" => $optionSelected, "recommendedItems" => $recommendedItems]);

?>