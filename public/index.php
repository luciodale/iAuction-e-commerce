<?php

    require_once("../includes/config.php"); 
    //require("../includes/connectSQL.php");

    // $mainpagestmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID");
    // $mainpagestmt->execute();

    // $result = $mainpagestmt->fetchAll();

    // render("home.php", ["GridInfo" => $result]);

    $objects = displayAuction_db();
    render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1]]);

?>


