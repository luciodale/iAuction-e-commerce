<?php

require_once("../includes/config.php");
	// require("../includes/connectSQL.php");

	    // if user reached page via GET (as by clicking a link or via redirect)
if (is_get_request())
{
	        // else render form
 render("add_item_form.php", ["title" => "Add Item"]);
}

else
{
  $form = [];
  $form['item_name'] = h($_POST['item_name']);
  $form['item_start_price'] = h($_POST['item_start_price']);
  $form['item_reserve_price'] = h($_POST['item_reserve_price']);
  $form['item_description'] = h($_POST['item_description']);
  $form['ItemCategory'] = h($_POST['ItemCategory']);
  $form['ItemCondition'] = h($_POST['ItemCondition']);
  $form['end_time'] = h($_POST['ETime']);

  $images  = $_FILES['files'];


  $result = createAuction_db($form, $images);

  if($result === true) 
  {
    // $objects = displayAuction_db();
    // render("home.php", ["GridInfo" => $objects[0], "GridImages" => $objects[1]]);
    redirect("index.php");
  }
  else
  {
    $errors = $result;
    render("add_item_form.php", ["errors" => $errors, "form" => $form]);
  }
}

?>