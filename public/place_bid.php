<?php

require_once("../includes/config.php");

if(isset($_GET['id'])) {
    $id = h($_GET['id']);
    $info = getItemInfo_db($id);
  
    if (count($info) == 0) {
        render("error_view.php");
    }

    $currentWatchlist = Display_watch();
    $currentItem = $info[0];
    $averageRating = getSellerAverageRating($currentItem['Seller']);
    $currentItem['SellerRating'] = $averageRating[0]['AverageRating']; 
    $views = getViews_db($id)[0]['Visits'];
    $currentItem['Views'] = $views;

    $currentItemID = $currentItem['ItemID'];

    // passing itemID in query to retrieve all pictures belonging to an item
    $currentImages = retrieveCarouselImage_db($currentItemID);

    $iterator = count($currentImages);

    //html function generators
    $slideIndicators = create_slides_indicators($iterator);
    $imageSlides = create_slides($currentImages);

    // item bidders information
    $bidsList = displayBid_item_db($currentItemID);

    if(is_get_request()){
        

        // store new view in database
        storeView_db($currentItemID);
        if($currentItem['Seller'] != $_SESSION["id"] and $_SESSION["role"] != 3) {
            $currentItem['Views'] = $currentItem['Views'] + 1;
        }
        
        render("place_bid_view.php", 
        ["title" => $currentItem['ItemName'], "imageSlides" => $imageSlides, "slideIndicators" => $slideIndicators, "currentItem" => $currentItem, "bidsList" => $bidsList]);
    } else {
        // POST REQUEST

      $currentItem['bid_price'] = h($_POST['bid_price']);

      // connection database
      $result = bidRegister_db($currentItem, $bidsList);
        
      if($result === true) {
        //sending updates via EMAIL
        sendDataForEmails($currentItem, $bidsList, 1);
        $test = "place_bid.php?id=" . $currentItem['ItemID'];
        redirect($test);
        // redirect back to item
        // redirect("place_bid.php?id=" . h(u($_SESSION["item"][$a]['ItemID'])));

        // redirect("mybids.php");
      } 
      else {
        $errors = $result;
        render(
          "place_bid_view.php", 
          ["imageSlides" => $imageSlides, "slideIndicators" => $slideIndicators, "currentItem" => $currentItem, "bidsList" => $bidsList, "errors" => $errors]);
      }
    }

} else {
  // redirect()
  render("error_view.php");
}

?>
