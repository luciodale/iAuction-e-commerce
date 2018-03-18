<?php



function login_db($info) {

  // getting the global variable from config
  global $pdo;

  // !important.. doing validation before executing the query. The best way to place it is inside any query function to make sure we never skip the validation
  $errors = validate_login($info);

  // DEBUGGING checking whether the string is received
  // echo $errors[0];

  // if there is any error, we stop here and we return the array containig the errors
  if(!empty($errors)) {
    return $errors[0];
  }

  // query execution (pdo -> prepare makes sure that all special characters are escaped)
  $stmt = $pdo->prepare("SELECT * FROM users WHERE BINARY Username = ?");
  $stmt->execute(array($info['username']));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // one row detected
  if (count($rows) == 1) 
  {       
    $row = $rows[0];
    if (password_verify($info['password'], $row["Password"]))
    {
        // remember that user's now logged in by storing user's ID in session
      $_SESSION["id"] = $row["UserID"];
      $_SESSION["username"] = $info['username']; 
      $_SESSION["role"] = $row["Role"];  

      return true;
    }

    else {
      // disconnecting from database;
      db_disconnect($stmt, $pdo);

    }
  }
}

function register_db($form){

  global $pdo;

  $errors = validate_registration($form, $pdo);

  if(!empty($errors)) {
    return $errors;
  }

    // if Role is different from buyer, sellers, or admin, the user will not be registered
  $stmt = $pdo->prepare("INSERT IGNORE INTO users (FirstName, LastName, Email, Username, Password, Role) VALUES(:field1, :field2, :field3, :field4, :field5, :field6)");
  $stmt->execute(array(':field1' => $form["firstname"], ':field2' => $form["lastname"], ':field3' => $form["email"], ':field4' => $form["username"], ':field5' => password_hash($form["password"], PASSWORD_DEFAULT), ':field6' => $form["role"] ));

  // $affected_rows = $stmt->rowCount();
  // query database for user
  $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = ?");
  $stmt->execute(array($form["username"]));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // start user session
  $_SESSION["id"] = $rows[0]["UserID"];
  $_SESSION["username"] = $form["username"];
  $_SESSION["role"] = $rows[0]["Role"];

  // if($_SESSION["role"] == 'buyer')
  // {
  // // creation of customized table for user preferences
  //   $var = 'zusers_' . $form["username"];
  //   // sql to create table
  //   $sql = "CREATE TABLE $var (
  //   VisitID INT(11) AUTO_INCREMENT PRIMARY KEY, 
  //   ItemID int(11) NOT NULL,
  //   CategoryName varchar(40) NOT NULL,
  //   VisitDate datetime NOT NULL,
  //   FOREIGN KEY (CategoryName) REFERENCES categories(CategoryName),
  //   FOREIGN KEY (ItemID) REFERENCES items(ItemID))
  //   ";

  //   // use exec() because no results are returned
  //   $pdo->exec($sql);
  // }

  // disconnecting from database;
  db_disconnect($stmt, $pdo);

  return true;
} 

function createAuction_db($form, $images) {

  global $pdo;

  $errorsForm = validate_auction($form);
  $errorsImages = validate_images($images);
  $endTime = validate_date($form['end_time']);

  if(!empty($errorsForm)) {
    return $errorsForm;
  } else if (!empty($errorsImages)){
    return $errorsImages;
  }

  $namesImages = prepare_namesImages($images);


  $stmt = $pdo->prepare("INSERT IGNORE INTO items (ItemName, Description, Status, CategoryName, Seller) VALUES(?, ?, ?, ?, ?)");
  $stmt->execute(array($form['item_name'], $form['item_description'], $form['ItemCondition'], $form['ItemCategory'], $_SESSION["id"]));

  $autoid = $pdo->lastInsertId();

  $stmt = $pdo->prepare("INSERT IGNORE INTO auctions (ItemID, StartPrice, ReservePrice, EndTime, CurrentPrice) VALUES(?,?,?,?,?)");
  $stmt->execute(array($autoid, $form["item_start_price"], $form["item_reserve_price"], $endTime, NULL));


  $count = 0;
  foreach ($namesImages as $key) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO photos (Name, Image, ItemID, SubgroupID) VALUES(?,?,?,?)");
    $stmt->execute(array($key[0], $key[1], $autoid, $count));
    $count++;
  }

  db_disconnect($stmt, $pdo);

  return true;
}

function bidRegister_db($form){

  global $pdo;

  // some validation here;

  $BidDate = new DateTime(date("Y-m-d H:i:s"));
  $BidDate = $BidDate->format('Y-m-d H:i:s');

  $stmt = $pdo->prepare("INSERT IGNORE INTO bids (AuctionID, BidderID, BidTime, BidPrice) VALUES(?, ?, ?, ?)");
  $stmt->execute(array($form['AuctionID'], $_SESSION['id'], $BidDate, $form['bid_price']));

  db_disconnect($stmt, $pdo);

  return true;

}

function displayBid_db(){

  global $pdo;

  // retrieving only bid details of current user
  $sql = "SELECT BidTime, BidPrice, StartPrice, EndTime, ItemName, Description";
  $sql .= " FROM bids AS b
            JOIN auctions AS a 
            JOIN items AS i
            on b.BidderID = ?
            and a.AuctionID = b.AuctionID
            and a.ItemID = i.ItemID";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION['id']));
    $bids = $stmt->fetchAll();

    db_disconnect($stmt, $pdo);

  return $bids;

}

// Method that calls all auctions from database ************
function displayAuction_db() {

  global $pdo;

  $container = [];

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID");
  $stmt->execute();
  $info = $stmt->fetchAll();

  $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0");
  $stmt->execute();
  $photos = $stmt->fetchAll();


  // db_disconnect($stmt, $pdo);

  $container[0] = $info;
  $container[1] = $photos;

  return $container;
}

function displayAuctionAdvanced($type, $condition, $price, $word) {

  global $pdo;

  $container = [];

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND CategoryName = '".$type."' AND items.Status = '".$condition."' AND ItemName LIKE '%".$word."%'AND auctions.StartPrice <= '".$price."' ");
  $stmt->execute();
  $info2 = $stmt->fetchAll();

  $photos2 = array();

  for ($x=0; $x < count($info2); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info2[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos2)) {
      $photos2 = $stmt->fetchAll();
    } else {
      $photosint = $photos2;
      $photos2 = array_merge($photosint, $stmt->fetchAll());
    }
  }


  $container[0] = $info2;
  $container[1] = $photos2;


  //render("home.php", ["GridInfo" => $container[0], "GridImages" => $container[1]]);
  return $container;
}

function Searchbar($searchword) {

  global $pdo;

  $container = [];

  echo '<script>console.log("'.$searchword.'");</script>';

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND ItemName LIKE '%".$searchword."%' ");

  $stmt->execute();
  $info3 = $stmt->fetchAll();

  $photos3 = array();

  for ($x=0; $x < count($info3); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info3[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos3)) {
      $photos3 = $stmt->fetchAll();
    } else {
      $photosint2 = $photos3;
      $photos3 = array_merge($photosint2, $stmt->fetchAll());
    }
  }

  $container[0] = $info3;
  $container[1] = $photos3;

  return $container;
}

function retrieveCarouselImage_db ($currentItemID) {

  global $pdo;

  $stmt = $pdo->prepare("SELECT Image FROM photos WHERE photos.ItemID = '$currentItemID'");
  $stmt->execute();
  return $stmt->fetchAll();
}



?>