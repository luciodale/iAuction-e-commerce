<?php

require_once("../includes/config.php"); 

error_reporting(0);

$contained = false;
$contained2 = false;
$GridInfo;
$GridImages;

// the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// records per page
$per_page = 9;

$objects2 = null;
$objects = null;

$fromDropDown[0] = h($_GET['sortBy']);
    // $fromDropDown[1] = $_GET['ASC'];
$sort[0] = "AuctionID"; 
$sort[1] = "DESC";

$sorter;

if(validate_input($_GET['sort'])){
$sorter = $_GET['sort'];
}

if(isset($sorter)){

    switch($sorter) {
        case 'PriceLowHigh': 
        $sort[0] = "StartPrice"; $sort[1] = "ASC";
        break;
        case 'PriceHighLow': 
        $sort[0] = "StartPrice"; $sort[1] = "DESC";
        break;
        case 'TimeLowHigh': 
        $sort[0] = "EndTime"; $sort[1] = "DESC";
        break;
        case 'TimeHighLow':
        $sort[0] = "EndTime"; $sort[1] = "ASC";
    } 

}

if (isset($_POST['q'])) {
    if ($_POST["q"] != "" && validate_input($_POST["q"])) {
        $objects = searchQ($_POST["q"]);
        $GridInfo = $objects[0];
        $GridImages = $objects[1];
        
        //drop down doesnt work here
        $pagination = new Pagination($page, $per_page, $total_count);
        render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1], "pagination" => $pagination]);
    } 
    else {
        $total_count = countAll_db();

        $pagination = new Pagination($page, $per_page, $total_count);
// total record count 
        $objects = displayAuction_db($per_page, $pagination, $sort);

        render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1], "pagination" => $pagination]);
        
    }

}

else if ((isset($_POST['ItemCon']) or isset($_POST['ItemT']) or isset($_POST['SPrice']) or isset($_POST['keyword']))&&(!empty($_POST['ItemCon']) or !empty($_POST['ItemT']) or !empty($_POST['SPrice']) or !empty($_POST['keyword']))) {

    $Search;
    
    if(validate_input($_POST['ItemT']) && validate_input($_POST['SPrice']) && validate_input($_POST['keyword']) && validate_input($_POST['ItemCon'])){
        $Search['ItemT'] =   h($_POST['ItemT']);
        $Search['SPrice'] = h($_POST['SPrice']);
        $Search['keyword'] = h($_POST['keyword']);
        $Search['ItemCon'] = h($_POST['ItemCon']);
    }
    $objects = searchAuction($Search);
    $GridInfo = $objects[0];
    $GridImages = $objects[1];
    //drop down doesnt work here
    $pagination = new Pagination($page, $per_page, $total_count);
    
    render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1], "pagination" => $pagination]);
}

else {  
    $total_count = countAll_db();

    $pagination = new Pagination($page, $per_page, $total_count);
// total record count 
    $objects = displayAuction_db($per_page, $pagination, $sort);
    render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1], "pagination" => $pagination]);

}



?>


