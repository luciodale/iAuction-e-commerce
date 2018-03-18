<?php

require_once("../includes/config.php");
error_reporting(0);

if (is_get_request())
{

$currentItem['ItemID'] = $_GET['ItemID'];
addtoWatch($currentItem['ItemID']);

$watchList = Display_watch();
render("watchlist_form.php", ["title" => "My WatchList", 'watchList' => $watchList]);

}

if (is_post_request())
{
	Watch_delete($_POST['DelItemize']);
	unset($watchList);
	$watchList = Display_watch();
	render("watchlist_form.php", ["title" => "My WatchList", 'watchList' => $watchList]);
}
?>