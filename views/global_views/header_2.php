<?php
require_once("../includes/functions_db.php"); 

?>
<!DOCTYPE html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/img/apple_icon.png">

  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">

  <!-- http://getbootstrap.com/ -->
  
  <link href="/css/bootstrap.min.css" rel="stylesheet"/>

  <link href="/css/home.css" rel="stylesheet"/>

  <link href="/css/tooltip.css" rel="stylesheet"/>

  <link href="/css/global.css" rel="stylesheet"/>
      
  <link href="/css/place_bid_view.css" rel="stylesheet"/>

    <link href="/css/watchlist.css" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">





  <?php if (isset($title)): ?>
    <title>iAuction:  <?= $title ?></title>
  <?php else: ?>
    <title>iAuction</title>
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
              <a class="navbar-brand" href="/"> <img src="<?php echo IMG_PATH . '/logo.png'; ?>" width="75"></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">  
              <div class="col-sm-4 col-md-4">
                <form class="navbar-form" role="search" action="index.php" method="post">
                  <div class="input-group">
                    <!-- SEARCH BAR -->
                    <input type="text" class="form-control" placeholder="Search" maxlength="50" name="q"/>
                    <div class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>


              
              <ul class="nav navbar-nav top-filters">


                <li> 
                  <div class="row">
                    <div class="col-sm-1 advancedSearchWrapper">
                      <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Filters<span class="caret"></span></a>

                          <ul class="dropdown-menu dropdown-menu-right" style="height:340px;">
                            <li class="dropdown-header">Set your search criteria</li>
                            <li><a href="#">


                              <form id="adsearch" class="form-horizontal" action="index.php" method="post" role="form">

                                <label for="filter">Options</label>

                                <select name="ItemT" id="type" class="form-control" style="display:block; margin-bottom: 10px;">
                                  <option value="" selected>Category</option>
                                  <optgroup></optgroup>
                                  <option value="1">Luxury</option>
                                  <option value="2">Sports</option>
                                  <option value="3">Electronics</option>
                                  <option value="4">Entertainment</option>
                                  <option value="5">Apparel</option>
                                  <option value="6">Collectibles</option>
                                </select>

                                <select name="ItemCon" id="condition" class="form-control" style="display:block;">
                                  <option value="" selected>Item Condition</option>
                                  <optgroup></optgroup>
                                  <option value="5">New</option>
                                  <option value="4">Excellent</option>
                                  <option value="3">Good</option>
                                  <option value="2">Average</option>
                                  <option value="1">Bad</option>
                                </select>

                                <label style="margin-top: 10px; display:block;" for="contain">Starting Price</label>
                                <input class="form-control" type="number" id="price" name="SPrice"/>

                                <label style="margin-top: 10px; display:block;" for="contain">Keyword</label>
                                <input class="form-control" type="text" id="key" name="keyword"/>

                                <button type="submit" id="disbutton" class="btn btn-success btn-block" style="margin-top: 15px; display:block; height:35px;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>

                              </form>

                              
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
                      <li><a href="register.php"><span class="glyphicon glyphicon-user">
                      </span> Sign Up</a></li>
                      <li><a href="login.php"><span class="glyphicon glyphicon-log-in">
                      </span> Login</a></li>
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

                          <?php if($_SESSION["role"] == 1){ ?>
                          <a class="dropdown-item" href="mybids.php">My Bids</a><br>
                          <a class="dropdown-item" href="watchlist.php">Watch List</a><br>
                          <a class="dropdown-item" href="buyingsummary.php">My Purchases</a><br>
                          <a class="dropdown-item" href="recommendations.php">Recommendations</a>
                          <?php } else if($_SESSION["role"] == 2) { ?>
                          <a class="dropdown-item" href="myauctions.php">My Auctions</a><br>
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
    
<body>