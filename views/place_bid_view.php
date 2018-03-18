 <?php include_once("place_bid.php"); ?>

  <link href="/css/place_bid.css" rel="stylesheet"/>


 <!--Div Container -->
 <div class="container container-top-margin">
   <div class="col-sm-4 col-md-4">
    <br>
    <br>
    <br>

    <div style="margin-bottom: 0;" id="dynamic_slide_show" class="carousel carouselPersonal slide" data-ride="carousel">
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

   <?php if( $_SESSION["role"] == 1) { ?> 
   <div style="text-align: center">
       <a style="width: 60%; margin: 10px auto" class="btn btn-info btn-block bid-button" href="<?php echo 'watchlist.php?' . http_build_query($currentItem); ?>">Add to watchlist</a>
   </div>
   <?php } else if ($_SESSION["role"] == 3) { ?>
   <div style="text-align: center">
       <p style="padding-top:15px;color:red">Admin delete will delete the item and all associated database entries. This is only possible before an Auction has ended.</p>
       <a href="<?php echo 'admindelete.php?' . http_build_query($currentItem); ?>" style="width: 60%; margin: 10px auto" class="btn btn-danger btn-block bid-button" <?php if($currentItem['EndTime']<date("Y-m-d H:i:s")) { echo "disabled"; }?>>Admin Delete</a>
   </div>
   <?php }?>
 </div>

 <!-- edit form column -->
 <div class="col-sm-8 col-md-8">
  <h3><?php echo $currentItem['ItemName']; ?></h3>
  <p>by <a href="#"><?php echo $bidsList['seller'][0]['Username']; ?></a></p>
  <p>Seller Rating: 
      
      <?php  if (isset($currentItem['SellerRating'])) {
                $k = 5;
                for ($j = 0; $j < round($currentItem['SellerRating']); $j++){
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star"></span>';
                    $k--;
                }
                for ($p = 0; $p<$k; $p++) {
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star-empty"></span>';
                }
                echo " (".round($currentItem['SellerRating'],1).")";
            } else { echo 'no ratings yet'; } ?>
  </p>
  <hr class="line" />

  <h4>Description</h4>
   <p style="word-wrap: break-word;"> <?php echo $currentItem["Description"]; ?> </p>

  <!--Div Column-->
  <div class="col-sm-5 col-md-5">
    <!--Table-->
    <table class="table table-sm">

      <!--Table body-->
      <tbody>
        <tr>
          <th scope="row">Starting Price</th>
          <td><?php echo '£ ' . $currentItem['StartPrice'] ?></td>
        </tr>
        <tr>
          <th scope="row">Highest Bid</th>
          <td><?php
                  if (isset($bidsList['bids'][0])) {
                    echo '£ ' . $bidsList['bids'][0]['BidPrice'];
                  } else { echo 'No bids'; }
              ?></td>
        </tr>
        <tr>
          <th scope="row">Condition</th>
          <td><?php echo $currentItem['StatusName'] ?></td>
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

  <!-- check if you are the current highest bidder -->
  <?php $boolBid = boolBidCheck($bidsList); ?>  

  <div class="col-sm-3 col-md-3">
    <div style="height:auto" class="bid-box">
      <?php if($currentItem['EndTime']>date("Y-m-d H:i:s")) {?>
      <form class="form-horizontal" method="post">
          <?php if($boolBid == true) { ?>
            <h4> You are the highest bidder! </h4>
          <?php } else {?>
          <label for="formGroupExampleInput">Enter your bid<br></label>
            <div class="tool_tip">
              <img src="img/Blue_question_mark_icon.png" height="13px"/>
              <span class="tool_tip_text">Enter a bid price above the highest bid
              </span>
            </div>
        <div class="form-group">
          <input style="width: 60%" type="text" class="form-control" name="bid_price" id="formGroupExampleInput" placeholder="enter a value">

          <?php } ?>

          <?php if (isset($errors)) { ?>
          <div id="firstnamealert" class="alert alert-info alert-dismissable">
            <a class="panel-close close" data-dismiss="alert">×</a> 
            <i class="fa fa-coffee"></i>
          <?php echo $errors[0];?>
          </div> 
          <?php } ?>
          
          <button style="width: 60%" type="submit" class="btn btn-primary btn-block bid-button" <?php if(2 == $_SESSION["role"] or 3 == $_SESSION["role"] or  $boolBid == true) { echo "disabled"; } ?>><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Submit Bid</button>
<!--           <hr class="line" /> -->
            
<!--           <label for="formGroupExampleInput"></label> -->
            
        <?php } else { ?>
        <h4>This auction has ended</h4>
        <?php } ?>

        <?php if (!empty($bidsList['bids'])) { ?>
          <button style="width: 60%" type="button" onclick="on()" class="btn btn-primary btn-block bid-button"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Bid History</button>
        <?php } else  { ?>
          <button style="width: 60%" type="button" onclick="on()" class="btn btn-primary btn-block bid-button" disabled><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Bid History</button>
        <?php } ?>
        </div>
        </form>

      </div>
    </div>
    <!--Bid Box-->
  </div>
  <!--Div Column-->
  
  <div>
      <div class="col-sm-4 col-md-4"></div>
      
      <?php if($currentItem['Seller'] == $_SESSION["id"] or 3 == $_SESSION["role"]) { ?>
      <div class="col-sm-8 col-md-8">

          <h4>Seller summary:</h4>
          
          <div class="col-sm-5 col-md-5">
            <table class="table table-sm">
              <tbody>
                <tr>
                  <th scope="row" style="border-top: none;">Views</th>
                  <td style="border-top: none;"><?php echo $currentItem['Views'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Reserve Price</th>
                  <td><?php echo '£ ' . $currentItem['ReservePrice'] ?></td>
                </tr>
                <tr>
                  <th scope="row">Number of Bids</th>
                  <td><?php echo sizeof($bidsList['bids']); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
    
     
     </div>
     <?php } ?>
</div>
     
  <!--Div POPUP -->
  <div class="overlay" style="display:none">
      <div class="relative">
          <div>
            <a class="bidpop_close_btn" href="#" onclick="off()">&#10006;</a>
          </div>
          <div class="inner">
              <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Bid Time</th>
                  <th scope="col">Bidder ID</th>
                  <th scope="col">Bidder Rating</th>
                  <th scope="col">Bid Price</th>
                </tr>
              </thead>
              <tbody> 
                <?php for($i = 0; $i < sizeof($bidsList['bids']); $i++){ ?>
                <tr>
                  <th scope="row"><?php echo sizeof($bidsList['bids'])-$i;?></th>
                  <td><?php echo $bidsList['bids'][$i]['BidTime'];?></td>
                  <td><?php echo $bidsList['users'][$i]['Username'];?></td>
                  <td><?php $r = getBuyerAverageRating($bidsList['bids'][$i]['BidderID']); 

                  if (isset($r[0]["AverageRating"])) {
                    $k = 5;
                    for ($j = 0; $j < round($r[0]["AverageRating"]); $j++){
                        echo '<span style="font-size:17px;" class="glyphicon glyphicon-star"></span>';
                        $k--;
                    }
                    for ($p = 0; $p<$k; $p++) {
                        echo '<span style="font-size:17px;" class="glyphicon glyphicon-star-empty"></span>';
                    }
                    echo " (".round($r[0]["AverageRating"],1).")";
                } else { echo 'no ratings yet'; } ?> </td>
                  <td><?php echo $bidsList['bids'][$i]['BidPrice'];?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
      </div>
  </div>


</div>


<style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>


<script>
  function on() {
    $('.overlay').fadeIn(200);
  }

  function off() {
    $('.overlay').fadeOut(200);
  }
  window.onload = off;
</script>
