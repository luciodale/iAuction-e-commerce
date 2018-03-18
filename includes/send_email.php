<?php 



require_once("../includes/config.php");


function sendDataForEmails($currentItem, $data, $call) {
global $pdo;
$stmt = $pdo->prepare("SELECT* FROM auctions AS a JOIN items AS i ON a.itemID = i.ItemID AND a.Status = 'Active' JOIN categories ON i.CategoryName = CategoryID JOIN status ON i.Status = StatusID");
  $stmt->execute();
  $active = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // API key to send emails by using the SendGrip php library
  $FROM_EMAIL = 'updates@iAuction.com';
  $apiKeyEmail = getApiKey();// using SendGrid's PHP Library
  // https://github.com/sendgrid/sendgrid-php
  $InfoForEmail = updateOnNewBid($data);

  if($call == 1) 
  {
    sendGeneralToBidders($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL);
  }
}


?>