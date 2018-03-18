<!-- Carousel ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
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
          <p>iAuction is the official e-commerce to buy and sell second hand Apple devices</p>
          <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <picture>
        <source srcset="img/carousel/carousel2_1920x400.jpg" media="(min-width: 1366px)"/>
        <source srcset="img/carousel/carousel2_1366x400.jpg" media="(min-width: 768px)"/>
        <source srcset="img/carousel/carousel2_800x400.jpg" media="(min-width: 576px)"/>
        <img class ="second-slide" srcset="img/carousel/carousel2_600x400.jpg" alt="responsive image" class="d-block img-fluid">
      </picture>
      <div class="container">
        <div class="carousel-caption">
          <h1>Another example headline.</h1>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <picture>
        <source srcset="img/carousel/carousel3_1920x400.jpg" media="(min-width: 1366px)"/>
        <source srcset="img/carousel/carousel3_1366x400.jpg" media="(min-width: 768px)"/>
        <source srcset="img/carousel/carousel3_800x400.jpg" media="(min-width: 576px)"/>
        <img class ="third-slide" srcset="images/carousel3_600x400.jpg" alt="responsive image" class="d-block img-fluid">
      </picture>
      <div class="container">
        <div class="carousel-caption">
          <h1>One more for good measure.</h1>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
        </div>
      </div>
    </div>
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


<!--Grid column-->

<div class="row container-items">

  <?php 

  $arrayPHP = [];
  for ($a = 0; $a < count($GridInfo); $a++){ 
    $arrayPHP[$a] = $GridInfo[$a]['EndTime'];

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
          <p><h4><?php echo $GridInfo[$a]['ItemName'] ?></h4></p>
          <hr class="line">
          <div class="ratings">
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
          </div>

          <div class="description-scroll">
            <p><?php echo $GridInfo[$a]['Description'] ?></p>
          </div>
        </div> 

        <div class="card-buttons">
          <a class="button-left"> 
            <p>Save Item</p>
          </a>
          <a class="button-right" href="<?php echo 'place_bid.php?' . http_build_query($GridInfo[$a]); ?>">
            <p>Bid Now</p>
          </a>
        </div>

      </div>
    </div>
    <?php } ?>
  </div>


  <script type="text/javascript">

    var arrayDecoded = <?php echo json_encode($arrayPHP); ?>;

    function countdown(){

      var secsum = [];
      var minsum = [];
      var hoursum = [];
      var daysum = [];

      var now = new Date();
      var currentTime = now.getTime();

      for(var i = 0; i < arrayDecoded.length; i++){

        var eventDate = new Date(arrayDecoded[i]);
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




