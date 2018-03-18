<?php 
$popItems = getPopViewsItems();
    // print_r($popItems);
?>

<!-- Carousel ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <?php if (isset($_SESSION['id']) and $_SESSION['role'] == '1') { ?>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <?php } ?>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <picture>
        <source srcset="img/carousel/carousel1_1920x400.jpg" media="(min-width: 1366px)"/>
        <source srcset="img/carousel/carousel1_1366x400.jpg" media="(min-width: 768px)"/>
        <source srcset="img/carousel/carousel1_800x400.jpg" media="(min-width: 576px)"/>
        <img class ="first-slide" srcset="img/carousel/carousel1_600x400.jpg" alt="responsive image" class="d-block img-fluid">
      </picture>
      <div class="container">
        <div class="carousel-caption">
          <h1>Buy and Sell your Apple Products</h1>
          <p>iAuction is the official site to buy and sell second hand Apple devices</p>
          
          <?php if (!isset($_SESSION['id'])) { ?>
          <p><a class="btn btn-lg btn-primary" href="register.php" role="button">Sign up today</a></p></br></br>
          <?php } else { ?>
          <p></br></br></p>
          <?php } ?>
        </div>
      </div>
    </div>


    <!-- TESTING CAROUSEL ITEMS -->
    <div class="item">
      <picture>
        <source srcset="img/carousel/carousel2_1920x400.jpg" media="(min-width: 1366px)"/>
        <source srcset="img/carousel/carousel2_1366x400.jpg" media="(min-width: 768px)"/>
        <source srcset="img/carousel/carousel2_800x400.jpg" media="(min-width: 576px)"/>
        <img class ="second-slide" srcset="img/carousel/carousel2_600x400.jpg" alt="responsive image" class="d-block img-fluid">
      </picture>
      <div class="container">
        <div class="carousel-caption">
          <h1>View popular auctions right now</h1>
          <p></p>
          <p><a class="btn btn-lg btn-primary" href="<?php echo 'recommendations.php?type=pop'?>" role="button">Browse Items</a></p>
          <p></br></br></p>
        </div>
      </div>
    </div>

    <?php if (isset($_SESSION['id']) and $_SESSION['role'] == '1') { ?>
    <div class="item">
      <picture>
        <source srcset="img/carousel/carousel3_1920x400.jpg" media="(min-width: 1366px)"/>
        <source srcset="img/carousel/carousel3_1366x400.jpg" media="(min-width: 768px)"/>
        <source srcset="img/carousel/carousel3_800x400.jpg" media="(min-width: 576px)"/>
        <img class ="third-slide" srcset="img/carousel/carousel3_600x400.jpg" alt="responsive image" class="d-block img-fluid">
      </picture>
      <div class="container">
        <div class="carousel-caption">
          <h1>Check out your recommended auctions</h1>
          <p>Click below to view your personalized offerings!</p>
          <p><a class="btn btn-lg btn-primary" href="recommendations.php" role="button">Browse Items</a></p>
        </br></br></br>
      </div>
    </div>
  </div>
  <?php } ?>


</div>
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
  <span class="sr-only">Next</span>
</a>
</div>
<!-- /.carousel -->


<script type="text/javascript">
  function myFunction(x){
    x.classList.toggle("change");
    if($(".visible-on-toggle").css("opacity") == "1"){
      $('.visible-on-toggle').fadeTo(200, 0);
    } else {
      $(".visible-on-toggle").animate({opacity: 1});
    }
  }
</script>

<div class="container-new-thing">
  <div class="d-inline-block col-sm-2 col-md-2 visible-on-toggle">
    <h5><a href="index.php?sort=PriceLowHigh">Price: low to high</a></h5>
  </div>
  <div class="d-inline-block col-sm-2 col-md-2 visible-on-toggle">
    <h5><a href="index.php?sort=PriceHighLow">Price: high to low</a></h5>
  </div>
  <div class="notch-container d-inline-block col-sm-2 col-md-4 image">
    <img src="img/notch.png">
    <div class="over-child" style="cursor:pointer;" onclick="myFunction(this)" >
      <div class="bars">
        <div class="bar1"></div>
        <p class="bar2">sort</p>
        <div class="bar3"></div>
      </div>
    </div>
  </div>
  <div class="d-inline-block col-sm-2 col-md-2 visible-on-toggle">
    <h5><a href="index.php?sort=TimeLowHigh">Time: newest to oldest</a></h5>
  </div>
  <div class="d-inline-block col-sm-2 col-md-2 visible-on-toggle">
    <h5><a href="index.php?sort=TimeHighLow">Time: oldest to newest</a></h5>
  </div>
</div>

<br>
<br>
<br>
<br>

<!--Grid column-->
<br>
<div onload="setInterval(function(){ countdown(arrayDecoded); }, 500);" class="row container-items">

  <?php 
  // print_r($GridInfo);
  // echo count($GridInfo);
  // print_r($_SESSION);


  $arrayPHP = [];
  for ($a = 0; $a < count($GridInfo); $a++){ 
    // finding highest bid according to item in question
    $bidPrice = displayHighestBid_db($GridInfo[$a]['ItemID']);

    //*** Auction Time Validation ***//
    $time_var = $GridInfo[$a]['EndTime'];

    // // override default is 0, set to 1 to show all auctions
    // $check = timeCheck($time_var);

    // if($check == TRUE){
    //   continue;
    // }

    array_push($arrayPHP, $GridInfo[$a]['EndTime']);

    ?>
    <div class="col-sm-4 col-md-4">
      <div class="thumbnail text-center">
        <div class="item-img">
          <?php 
          for ($i = 0; $i < count($GridImages); $i++) {
            if($GridImages[$i]['ItemID'] == $GridInfo[$a]['ItemID']){ ?>

            <?php echo '<img height="" width="" src="data:image;base64,'. $GridImages[$i]['Image']. '">' ?>
            <?php }} ?>
            <div class="time-tag">
             <table class="counter">
              <td class="days"></td>
              <td class="hours"></td>
              <td class="minutes"></td>
              <td class="seconds"></td>
            </table>
          </div>
        </div>
        <div class="caption">

          <p>
            <h4><?php echo $GridInfo[$a]['ItemName'] ?> 
              <!-- finding whether the item in questions has enough views for the fire image to be displayed -->
              <?php for($b = 0; $b < sizeof($popItems); $b++){
                if($popItems[$b]['ItemID'] == $GridInfo[$a]['ItemID'] && $popItems[$b]['popularity'] > 10){ ?>

                <img src="img/flame.png" width="20">

                <?php break; } } ?>
              </h4>
            </p>
          </div>

          <hr class="line">
          <div class="description-money">
            <?php  if(isset($bidPrice['BidPrice'])){   ?>
            <img src="img/tag.png" width="80%">
            <h3 class="money-value"> <?php echo $bidPrice['BidPrice']; 
          } else { ?> 
          <img src="img/tag2.png" width="80%">
          <h3 class="money-value" style="margin-top: 4%;"> <?php echo $GridInfo[$a]['StartPrice']; 
        } ?>
      </h3></h3>
    </div>

    <?php if(!isset($_SESSION["role"])) {?>
    <div class="card-buttons">
      <a class="button-left" href="<?php echo 'watchlist.php?' . http_build_query($GridInfo[$a]); ?>"> 
        <p>Save Item</p>
      </a>
      <?php 
          // array_push($_SESSION['item'], $GridInfo[$a]);
      $_SESSION["item"][$a] = $GridInfo[$a]; 

      ?>
      <a class="button-right" href="<?php echo 'place_bid.php?id=' . h($_SESSION["item"][$a]['ItemID']) ?>">

        <p>Bid Now</p>

      </a>
    </div>
    <?php } else { ?>

    <?php if($_SESSION["role"] != 3) {?>
    <div class="card-buttons">

      <?php if($_SESSION["role"] == 1) { ?>
      <a class="button-left" href="<?php echo 'watchlist.php?' . http_build_query($GridInfo[$a]); ?>"> 
        <p>Save Item</p>
      </a>
      <?php } else { ?>
      <a class="button-left" style="cursor:default">
        <p>Save Item</p>
      </a>
      <?php } ?>



      <?php 
          // array_push($_SESSION['item'], $GridInfo[$a]);
      $_SESSION["item"][$a] = $GridInfo[$a]; 

      ?>
      <a class="button-right" href="<?php echo 'place_bid.php?id=' . h($_SESSION["item"][$a]['ItemID']) ?>">
        
        <?php if($_SESSION["role"] == 2) { ?>
        <p>View Item</p>
        <?php } else { ?>
        <p>Bid Now</p>
        <?php } ?>

      </a>
    </div>
    <?php } else {?>
    <div class="card-buttons">
      <a class="button-left" style=" color:red" href="<?php echo 'admindelete.php?' . http_build_query($GridInfo[$a]); ?>"> 
        <p>Admin Delete</p>
      </a>
      <?php 
          // array_push($_SESSION['item'], $GridInfo[$a]);
      $_SESSION["item"][$a] = $GridInfo[$a]; 

      ?>
      <a class="button-right" href="<?php echo 'place_bid.php?id=' . h($_SESSION["item"][$a]['ItemID']) ?>">
        <p>More Info</p>
      </a>
    </div>
    <?php } ?>
    <?php } ?>

  </div>
</div>

<?php } ?>
</div>
<!-- 
  <a class="button-right" href="popup.php">
    <p>POPUP TEST</p>
  </a> -->

<br>

  <div id="pagination" style="clear: both;">
    <?php
    if($pagination->total_pages() > 1) {

      if($pagination->has_previous_page()) { 
        echo "<a href=\"index.php?page=";
        echo $pagination->previous_page();
        echo "\">&laquo; Previous</a> "; 
      }

      for($i=1; $i <= $pagination->total_pages(); $i++) {
        if($i == $page) {
          echo " <span class=\"selected\">{$i}</span> ";
        } else {
          echo " <a href=\"index.php?page={$i}\">{$i}</a> "; 
        }
      }

      if($pagination->has_next_page()) { 
        echo " <a href=\"index.php?page=";
        echo $pagination->next_page();
        echo "\">Next &raquo;</a> "; 
      }

    }

    ?>
  </div>




  <script type="text/javascript">


    function countdown(){
      // console.log("lolz");

      var arrayDecoded = <?php echo json_encode($arrayPHP);?>
    // console.log(arrayDecoded);

    var secsum = [];
    var minsum = [];
    var hoursum = [];
    var daysum = [];

    var now = new Date();
    var currentTime = now.getTime();

    for(var i = 0; i < arrayDecoded.length; i++){
      var time = arrayDecoded[i].replace(/ /g, "T");
      console.log(arrayDecoded[i]);
      var eventDate = new Date(time);
      // console.log("date from JSON: " + eventDate);

      var eventDate = eventDate.getTime();  
      // console.log("date after JSON: " + eventDate);

      var remTime = eventDate - currentTime;
      // console.log("time remaining: " + eventDate + ' - ' + currentTime + ' = ' + remTime);

      var s = Math.floor(remTime / 1000);
      var m = Math.floor(s / 60);
      var h = Math.floor(m / 60);
      var d = Math.floor(h / 24);

      if(d <= 0 && h <= 0 && m <= 0 && s <= 0)
      {
        secsum.push(0);
        minsum.push(0);
        hoursum.push(0);
        daysum.push(0);
        continue;
      }

      h %= 24;
      m %= 60;
      s %= 60;

      h = (h < 10) ? "0" + h : h;
      m = (m < 10) ? "0" + m : m;
      s = (s < 10) ? "0" + s : s;

      // console.log("d: " + d);
      // console.log("h: " + h);
      // console.log("m: " + m);
      // console.log("s: " + s);

      secsum.push(s);
      // console.log("secsum: " + secsum[i]);
      minsum.push(m);
      // console.log("minsum: " + minsum[i]);
      hoursum.push(h);
      // console.log("hoursum: " + hoursum[i]);
      daysum.push(d);
      // console.log("daysum: " + daysum[i]);

    }

    var days = document.getElementsByClassName('days');
    var hours = document.getElementsByClassName('hours');
    var minutes = document.getElementsByClassName('minutes');
    var seconds = document.getElementsByClassName('seconds');
    var timer = document.getElementsByClassName('time-tag');
    var box = document.getElementsByClassName('thumbnail');


    for(var i = 0; i < days.length; i++)
    {
      // console.log("day: " + daysum[i] + " hour: " + hoursum[i] + " minute: " + minsum[i] + " seconds: " + secsum[i]);

      if(daysum[i] == 0 
        // && hoursum[i] == 0 && minutes[i] <= 59
        ) {

        timer[i].style.backgroundColor = "rgba(240,128,128,1)";
      box[i].style.boxShadow = "0px 0px 20px 10px rgba(240,128,128,1)";
    }

      // console.log("In loop count: " + i);
      days[i].textContent = daysum[i] + "d" + '\xa0\xa0\xa0';
      hours[i].textContent =  hoursum[i] + "h" + '\xa0\xa0\xa0';
      minutes[i].textContent = minsum[i] + "m" + '\xa0\xa0\xa0';
      seconds[i].textContent = secsum[i] + "s";
    }



//calling function countdown after 1 second
setTimeout(countdown, 1000);
}

// running the function when all content is loaded on page
document.addEventListener('DOMContentLoaded', function() {
  countdown();
}, false);




</script>




