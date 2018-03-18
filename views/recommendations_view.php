<?php 
$popItems = getPopViewsItems();
    // print_r($popItems);
?>

<div style= "text-align: center" class="container container-top-margin">
    <h3><?php echo $heading1 ?></h3>
    <h5><?php echo $heading2 ?></h5>
    <?php if(isset($_SESSION['role'])) {?>
    <?php if($_SESSION['role'] == 1) {?>
    <br>
    <form method="post" class="form-inline">
        <div class="form-group">
            <label><h4>Recommend based on: </h4></label>
            <select style="width:150px;" class="form-control" name="optionSelected">
                <option <?php if($optionSelected == "bids") {echo 'selected="selected"';} ?> value="bids">Your bids</option>
                <option <?php if($optionSelected == "views") {echo 'selected="selected"';} ?> value="views">Your views</option>
                <option <?php if($optionSelected == "popular") {echo 'selected="selected"';} ?>value="popular">Popular items</option>
            </select> 
            <button style="width:100px;" type="submit" class="btn btn-primary">GO</button>
        </div>
   </form>
  <br>
  <?php } ?>
  <?php } ?>
</div>

<div onload="setInterval(function(){ countdown(arrayDecoded); }, 500);" class="row container-items">

  <?php 
  // print_r($GridInfo);


  $arrayPHP = [];
  for ($a = 0; $a < count($GridInfo); $a++){ 
    // finding highest bid according to item in question
    $bidPrice = displayHighestBid_db($GridInfo[$a]['ItemID']);

    //*** Auction Time Validation ***//
    $time_var = $GridInfo[$a]['EndTime'];

    // override default is 0, set to 1 to show all auctions
    $check = timeCheck($time_var);

    if($check == TRUE){
      continue;
    }

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
            <h4>
              <?php echo $GridInfo[$a]['ItemName'] ?> 
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
            </h3>
          </div>

          <?php if(!isset($_SESSION['role'])) {?>
          <div class="card-buttons">
            <a class="button-left" href="<?php echo 'watchlist.php?' . http_build_query($GridInfo[$a]); ?>"> 
              <p>Save Item</p>
            </a>
            <?php 
          // array_push($_SESSION['item'], $GridInfo[$a]);
            $_SESSION["item"][$a] = $GridInfo[$a]; 

            ?>
            <a class="button-right" href="<?php echo 'place_bid.php?id=' . h(u($_SESSION["item"][$a]['ItemID'])) ?>">
              <p>Bid Now</p>
            </a>
          </div>
          <?php } else { ?>

          <?php if($_SESSION["role"] != 3) {?>
          <div class="card-buttons">
            <a class="button-left" href="<?php echo 'watchlist.php?' . http_build_query($GridInfo[$a]); ?>"> 
              <p>Save Item</p>
            </a>
            <?php 
          // array_push($_SESSION['item'], $GridInfo[$a]);
            $_SESSION["item"][$a] = $GridInfo[$a]; 

            ?>
            <a class="button-right" href="<?php echo 'place_bid.php?id=' . h(u($_SESSION["item"][$a]['ItemID'])) ?>">
              <p>Bid Now</p>
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
            <a class="button-right" href="<?php echo 'place_bid.php?id=' . h(u($_SESSION["item"][$a]['ItemID'])) ?>">
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
   <script type="text/javascript" src="js/clock.js"></script>
  <script type="text/javascript"> 
    var arrayDecoded = <?php echo json_encode($arrayPHP); ?>;
    countdown(arrayDecoded);
    setInterval(countdown(), 1000);
  </script>  -->

  <script type="text/javascript">


    function countdown(){
      // console.log("lolz");

      var arrayDecoded = <?php echo json_encode($arrayPHP);?>
    // console.log(arrayDecoded[0]);

    var secsum = [];
    var minsum = [];
    var hoursum = [];
    var daysum = [];

    var now = new Date();
    var currentTime = now.getTime();

    for(var i = 0; i < arrayDecoded.length; i++){
      var time = arrayDecoded[i].replace(/ /g, "T");
      // console.log(arrayDecoded[i]);
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

<style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>