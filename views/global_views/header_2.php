<?php
require_once("../includes/functions_db.php"); 
?>
<!DOCTYPE html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">

  <!-- http://getbootstrap.com/ -->
  
  <link href="/css/bootstrap.min.css" rel="stylesheet"/>

  <link href="/css/home.css" rel="stylesheet"/>
  <link href="/css/global.css" rel="stylesheet"/>
  <link href="/css/place_bid.css" rel="stylesheet"/>

  <link href="https://fonts.googleapis.com/css?family=Fugaz+One" rel="stylesheet">


  <?php if (isset($title)): ?>
    <title>SA:  <?= h($title) ?></title>
  <?php else: ?>
    <title>Scratch Auction</title>
  <?php endif ?>

</head>

<body>
  <header>
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">

          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed " data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo '/'; ?>"> <img src="<?php echo IMG_PATH . '/logo.png'; ?>" width="75"></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">  
              <div class="col-sm-4 col-md-4">
                <form class="navbar-form" role="search" method="get">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" maxlength="50" name="q"/>
                    <div class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      <?php 

                      if (isset($_GET["q"]) && $_GET["q"] != "") {
                        unset($GridInfo);
                        unset($GridImages);

                        $objects3 = Searchbar($_GET["q"]);

                        $GridInfo = $objects3[0];
                        $GridImages = $objects3[1];
                      }
                      ?>
                    </div>
                  </div>
                </form>
              </div>


              
              <ul class="nav navbar-nav top-filters">


                <li> 
                  <div class="row">
                    <div class="col-lg-2">
                      <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Filters<span class="caret"></span></a>

                          <ul class="dropdown-menu dropdown-menu-right" style="height:410px;">
                            <li><a href="#">My Current Bids</a></li>
                            <li><a href="#">My Winning Bids</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Advanced Filters</li>
                            <li><a href="#">

                              <form class="form-horizontal" method="get" role="form">

                                <label for="filter">Options</label>

                                <select name="ItemT" class="form-control" style="display:block; margin-bottom: 10px;">
                                  <option value="0" selected>Item Type</option>
                                  <optgroup></optgroup>
                                  <option value="6">Luxury</option>
                                  <option value="5">Sports</option>
                                  <option value="4">Electronics</option>
                                  <option value="3">Entertainment</option>
                                  <option value="2">Apparel</option>
                                  <option value="1">Collectibles</option>
                                </select>

                                <select name="ItemCon" class="form-control" style="display:block;">
                                  <option value="0" selected>Item Condition</option>
                                  <optgroup></optgroup>
                                  <option value="New">New</option>
                                  <option value="Excellent">Excellent</option>
                                  <option value="Good">Good</option>
                                  <option value="Average">Average</option>
                                  <option value="Bad">Bad</option>
                                </select>

                                <label style="margin-top: 10px; display:block;" for="contain">Starting Price</label>
                                <input class="form-control" type="number" name="SPrice"/>

                                <label style="margin-top: 10px; display:block;" for="contain">Keyword</label>
                                <input class="form-control" type="text" name="keyword"/>

                                <button type="submit" class="btn btn-success btn-block" style="margin-top: 15px; display:block; height:35px;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>

                              </form>
                              <?php 
                              

                              if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
                                if (isset($_GET["SPrice"]) && $_GET["SPrice"] != "") {
                                  if (isset($_GET["ItemCon"])) {
                                    if (isset($_GET["ItemT"])) {
                                      unset($GridInfo);
                                      unset($GridImages);
                                      $objects2 = displayAuctionAdvanced($_GET["ItemT"], $_GET["ItemCon"], $_GET["SPrice"], $_GET["keyword"]);

                                      $GridInfo = $objects2[0];
                                      $GridImages = $objects2[1];
                                    }}}} ?>
                                  </a>
                                </li>
                              </ul>
                              

                            </li>
                          </ul>
                        </div>
                      </div>
                    </li>
                  </ul>



                  <?php if (empty($_SESSION["id"])): ?>
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="login.php"><span class="glyphicon glyphicon-log-in">
                      </span> Sign In</a></li>
                      <li><a href="register.php"><span class="glyphicon glyphicon-user">
                      </span> Sign Up</a></li>
                    </ul>
                    
                  <?  else: ?>
                    <ul class="nav navbar-nav navbar-right">

                      <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          <span class="glyphicon glyphicon-user"></span>
                          <?= $_SESSION["username"] . " " ?>
                          <span class="caret"> </span> 
                        </a>
                        <div class="dropdown-menu dropdown-profile" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="profile.php">Edit Profile</a><br>

                          <?php if($_SESSION["role"] == 'buyer'){ ?>
                          <a class="dropdown-item" href="mybids.php">My Bids</a><br>
                          <a class="dropdown-item" href="#">Watch List</a>
                          <?php } else if($_SESSION["role"] == 'seller') { ?>
                          <a class="dropdown-item" href="#">My Auctions</a><br>
                          <a class="dropdown-item" href="add_item.php">Create Auction</a>
                          <?php } ?>

                        </div>
                      </li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in">
                      </span> Log-Out</a></li>
                    </ul>
                  <?php endif; ?>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </header>