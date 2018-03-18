<?php

require_once("../includes/config.php");
  // require("../includes/connectSQL.php");

$currentItem = $_GET;



if (is_post_request())
{

  $currentItem['bid_price'] = h($_POST['bid_price']);

  // connection database
  $result = bidRegister_db($currentItem);

  if($result === true) 
  {
    redirect("mybids.php");
  } 
  else 
  {
    // $errors = $result;
    render("place_bid_view.php");
  }



} else {

// itemID
  $currentItemID = $currentItem['ItemID'];

// passing itemID in query to retrieve all pictures belonging to an item
  $currentImages = retrieveCarouselImage_db($currentItemID);
  $iterator = count($currentImages);

//html function generators
  $slideIndicators = create_slides_indicators($iterator);
  $imageSlides = create_slides($currentImages);

  render(
    "place_bid_view.php", 
    ["imageSlides" => $imageSlides, "slideIndicators" => $slideIndicators, "currentItem" => $currentItem]
  );
}


?>


