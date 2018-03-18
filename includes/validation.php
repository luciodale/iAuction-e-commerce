<?php

// Auction Login *************************************************
function validate_login($info) {

  $errors = [];

  // DEBUGGING checking whether variables are received
  // echo $info['username'];
  // echo $info['password'];

  if (is_blank($info['username']) && is_blank($info['password'])) 
  {
    $errors[] = "Please, write your <strong>credentials</strong>";
  }
  elseif(is_blank($info['username'])) 
  {
    $errors[] = "Username cannot be <strong>blank</strong>";
  } 
  elseif (is_blank($info['password']))
  {
    $errors[] = "Password cannot be <strong>blank</strong>";
  } 

  return $errors;
}

// Auction Registration *************************************************
function validate_registration($info, $pdo){

  $errors = [];

  // looking for blank fields
  foreach ($info as $key => $value) {

    if(is_blank($value)) {
      $errors[] = "Please, make sure all the fields are completed";
      return $errors;
    }

    // checking for special characters (allowed for password and email)
    if($key != 'password' && $key != 'email'){
      if (preg_match('/[^A-Za-z0-9]+/', $value))
      {
        $errors[] = "The " . $key . " contains illegal characters";
        return $errors;
      }
    }
  }

  // username validation
  if(!has_length($info['username'], ['min' => 6, 'max' => 40])) 
  {
    $errors[] = "Username must be between 6 and 40 characters";
  }

  // checking whether username already exists in database
  if(!is_blank($info['username']))
  {
    $stmt = $pdo->prepare("SELECT Username FROM users WHERE Username = ?");
    $stmt->execute(array($_POST["username"]));
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($user != NULL)
      $errors[] = "An account under this name already exists";
  } 

  // email validation
  if (!filter_var($info['email'], FILTER_VALIDATE_EMAIL)) 
  {
    $errors[] = "Email is not valid";
  }

  // first name validation
  if(!has_length($info['firstname'], ['min' => 3, 'max' => 40])) 
  {
    $errors[] = "First name must be between 3 and 40 characters";
  } 

  // last name validation
  if(!has_length($info['lastname'], ['min' => 3, 'max' => 40])) 
  {
    $errors[] = "Last name must be between 3 and 40 characters";
  } 

  // password validation
  if(!has_length($info['password'], ['min' => 6, 'max' => 255])) 
  {
    $errors[] = "Password must be between 6 and 255 characters";
  }

  if(!validate_passw($info['password']))
  {
    $errors[] = "The password contains illegal characters";
  }

  // password matching
  if($info['confirmation'] !== $info['password']) 
  {
    $errors[] = "The two passwords must match";
  }

  return $errors;
}

function validate_passw($input) {
  $prohibited = ["<", ">", "\"", "'", " " , "#", "$", "%", "^", "+", "\\", ":", ";", "?", "/", "|", "~", "`", "="];

  foreach ($prohibited as $value) {

    if(strripos($input, $value) !== false){
      return false;
    }
  }
  return true;
}

function validate_input($input) {

  $prohibited = ["<", ">", "\"", "'", "@" , "#", "$", "%", "^", "*", "(", ")", "+", "]", "[", "{", "}", "\\", ":", ";", ".", "?", "/", "|", "~", "`", "="];

  foreach ($prohibited as $value) {

    if(strripos($input, $value) !== false){
      return false;
    }
  }
  return true;
}

// Auction Creation *************************************************
function validate_auction($info){

  $errors = [];

    // looking for blank fields + illegal characters
  foreach ($info as $key => $value) 
  {
    if(is_blank($value)) 
    {
     $errors[] = "Please, make sure all the fields are completed";
     return $errors;
   }

   if(!validate_input($value)) 
   {
    $errors[] = "The " . $key . " contains illegal characters";
    return $errors;
  }
  }

  if(!has_length($info['item_name'], ['min' => 10, 'max' => 40])) 
  {
    $errors[] = "Item name must be between 10 and 40 characters";
  }

                // item description validation
  if(!has_length($info['item_description'], ['min' => 10, 'max' => 200])) 
  {
   $errors[] = "Item description must be between 10 and 200 characters";
  } 

                  // item price validation
  if(!is_numeric($info['item_start_price']) || !is_numeric($info['item_reserve_price']))
  {
   $errors[] = "Start and reserve prices must be numbers";
  }

                  // category and condition validation
  if ($info["ItemCategory"] == "notSelected" || $info["ItemCondition"] == "notSelected" || 
    $info["end_time"] == "notSelected")
  {
    $errors[] = "Category, Condition, and Time must be selected";
  }

  return $errors;
}

function validate_images($images) {

  $errors = [];

  $box = rearrange($images);

  for($i = 0; $i < sizeof($box); $i++) {

    // $_FILES Corruption Attack
    if (!isset($box[$i]['error'])) {

      $errors[] = "Please, upload valid images";
      return $errors;
    }

    // Uploading error
    if($box[$i]['error'] !== UPLOAD_ERR_OK){

      $errors[] = "An error occured while uploading image: " . $box[$i]['name'];
      return $errors;
    }

    // max number of images is 3
    if(sizeof($box) > 3){

      $errors[] = "Please, upload at most three pictures";
      return $errors;
    }

    // Image size within 1 MB
    if ($box[$i]['size'] > 1048576) {

      $errors[] = "The following image is bigger than 1 MB: " . $box[$i]['name'];
      return $errors;
    }

    // Invalid file format
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search($finfo->file($box[$i]['tmp_name']), array(
      'jpg' => 'image/jpeg',
      'png' => 'image/png',
    ),
      true)) {

     $errors[] = "The accepted formats are .jpg and .png";
     return $errors;
   }

 } // closing loop
 return $errors;
}

function validate_date($form) {

  $expirationDate = new DateTime(date("Y-m-d H:i:s"));

  switch($form)
  {
    case 'one': $expirationDate->modify('+1 day');
    break;
    case 'five': $expirationDate->modify('+5 days');
    break;
    case 'ten': $expirationDate->modify('+10 days');
    break;
    case 'fifteen': $expirationDate->modify('+15 days');
    break;
    case 'month': $expirationDate->modify('+1 month');
  }

  return $expirationDate->format('Y-m-d H:i:s');
}

function prepare_namesImages($images) {

  $namesImages [][] = 0;

  $box = rearrange($images);

  for($i = 0; $i < sizeof($box); $i++) {

    $rowName = $box[$i]['name'];
    $ext = strtolower(substr($rowName, strripos($rowName, '.') + 1));
    $name = round(microtime(true)).mt_rand().'.'.$ext;

    $rowImage = file_get_contents($box[$i]['tmp_name']);
    $image = base64_encode($rowImage);

    $namesImages[$i][0] = $name;
    $namesImages[$i][1] = $image;

  }
  return $namesImages;
}

function rearrange($arr){
  foreach( $arr as $key => $all ){
    foreach( $all as $i => $val ){
      $new[$i][$key] = $val;    
    }    
  }
  return $new;
}

// *****************************************


?>