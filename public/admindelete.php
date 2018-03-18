<?php

require_once("../includes/config.php");

$currentItem['ItemID'] = h($_GET['ItemID']);
$currentItem['EndTime'] = h($_GET['EndTime']);

if($currentItem['EndTime']>date("Y-m-d H:i:s")) {
    adminDelete_db($currentItem['ItemID']);
    $boolDeleted = true;

}

else {
    $boolDeleted = false;
}

render("admindelete_view.php", ["title" => "Item Delete", "currentItem" => $currentItem, "boolDeleted" => $boolDeleted]);

?>
