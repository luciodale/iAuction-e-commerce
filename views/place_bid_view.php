 <?php include_once("place_bid.php"); ?>


 <!--Div Container -->
 <div class="container container-top-margin">
   <div class="col-sm-4 col-md-4">
    <h3>PICTURES</h3>

    <div id="dynamic_slide_show" class="carousel carouselPersonal slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php echo $slideIndicators; ?>
      </ol>

      <div class="carousel-inner">
       <?php echo $imageSlides; ?>
     </div>
     <a class="left carousel-control" href="#dynamic_slide_show" data-slide="prev">
       <span class="glyphicon glyphicon-chevron-left"></span>
       <span class="sr-only">Previous</span>
     </a>

     <a class="right carousel-control" href="#dynamic_slide_show" data-slide="next">
       <span class="glyphicon glyphicon-chevron-right"></span>
       <span class="sr-only">Next</span>
     </a>
   </div>
 </div>


 <!-- edit form column -->
 <div class="col-sm-8 col-md-8">
  <h3><?php echo $currentItem['ItemName']; ?></h3>
  <p>User Rating: ***** </p>
  <hr class="line" />

  <!--Div Column-->
  <div class="col-sm-4 col-md-4">
    <!--Table-->
    <table class="table table-sm">

      <!--Table body-->
      <tbody>
        <tr>
          <th scope="row" style="border-top: none;">Views</th>
          <td style="border-top: none;">34</td>
        </tr>
        <tr>
          <th scope="row">Starting Price</th>
          <td><?php echo '£ ' . $currentItem['StartPrice'] ?></td>
        </tr>
        <tr>
          <th scope="row">Condition</th>
          <td><?php echo $currentItem['Status'] ?></td>
        </tr>
        <tr>
          <th scope="row">Category</th>
          <td><?php echo $currentItem['CategoryName'] ?></td>
        </tr>
      </tbody>
      <!--Table body-->
    </table>
    <!--Table-->
  </div>

  <!--Bid Box-->

  <div class="col-sm-4 col-md-4">
    <div class="bid-box">

      <form class="form-horizontal" method="post">
        <div class="form-group">
          <label for="formGroupExampleInput">$ 45 BID PRICE, IF 0 BIDS THEN STARTING PRICE <br># of bids <br> reserve not met</label>
          <input type="text" class="form-control" name="bid_price" id="formGroupExampleInput" placeholder="Example input">

          <button type="submit" class="btn btn-primary btn-block bid-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> SUBMIT BID</button>
          <hr class="line" />

          <label for="formGroupExampleInput">$90 buy it now!</label>
          <button type="button" onclick="on()" class="btn btn-primary btn-block bid-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> BUY NOW</button>

          <label for="formGroupExampleInput"></label>
          <button type="button" onclick="on()" class="btn btn-primary btn-block bid-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> VIEW BID HISTORY</button>
        </div>
        </form>

      </div>
    </div>
    <!--Bid Box-->

  </div>
  <!--Div Column-->

</div>
<!--Div Container -->


<!--Div POPUP -->
<div id="overlay" onclick="off()">

</div>
<!--Div POPUP -->


<script>
  function on() {
    document.getElementById("overlay").style.display = "block";
  }

  function off() {
    document.getElementById("overlay").style.display = "none";
  }
</script>



