<style>
    
    .rate {
        border: none !important;
        background-color:white !important;
        padding-left: 0px !important;
        padding-right: 2px !important;
        font-size: 17px !important;
        color: #006dcc !important;
    }
    .rate:hover {
        color: darkblue!important;
    }

</style>

<div class="container container-top-margin">
    <h4>Current auctions</h4>
    <?php if (count($currentAuctions) != 0) { ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">End Time</th>
          <th scope="col">Item</th>
          <th scope="col">Condition</th>
          <th scope="col">Category</th>
          <th scope="col">Starting Price</th>
          <th scope="col">Reserve Price</th>
          <th scope="col">Highest Bid</th>
          <th scope="col">Most recent Bid</th>
          <th scope="col">Number of Bids</th>
          <th style = "width:auto" scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($currentAuctions); $i++){ ?>
        <tr>
          <td><?php echo $currentAuctions[$i]['EndTime'];?></td>
          <td><?php echo $currentAuctions[$i]['ItemName'];?></td>
          <td><?php echo $currentAuctions[$i]['Status'];?></td>
          <td><?php echo $currentAuctions[$i]['CategoryName'];?></td>
          <td><?php echo $currentAuctions[$i]['StartPrice'];?></td>
          <td><?php echo $currentAuctions[$i]['ReservePrice'];?></td>
          <td><?php echo $currentAuctions[$i]['HighestBid'] ?? '/';?></td>
          <td><?php echo $currentAuctions[$i]['RecentBid'] ?? '/';?></td>
          <td><?php echo $currentAuctions[$i]['NumberBids'];?></td>
          <td><a href="<?php echo 'place_bid.php?id=' . h(u($currentAuctions[$i]['ItemID']))?>" class="btn btn-info">View</a></td>
          <td>
              <?php if($currentAuctions[$i]['NumberBids'] != 0) {?>
              <button class="btn">Delete</button>
              <?php } else if($currentAuctions[$i]['NumberBids'] == 0) {?>
              <a href="<?php echo 'myauctions.php?id=' . h(u($currentAuctions[$i]['ItemID']))?>"><button class="btn btn-danger">Delete</button></a>
              <?php } ?>
          </td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
    <?php } else { ?>
        <p>no current auctions to show</p>
    <?php } ?>  
    
    <h4>Past auctions</h4>
    <?php if (count($pastAuctions) != 0) { ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">End Time</th>
          <th scope="col">Item</th>
          <th scope="col">Starting Price</th>
          <th scope="col">Reserve Price</th>
          <th scope="col">Number of Bids</th>
          <th scope="col">Highest Bid</th>
          <th scope="col">Accepted Bid</th>
          <th scope="col">Your Buyer Rating</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($pastAuctions); $i++){ ?>
        <tr>
          <td><?php echo $pastAuctions[$i]['EndTime'];?></td>
          <td><?php echo $pastAuctions[$i]['ItemName'];?></td>
          <td><?php echo $pastAuctions[$i]['StartPrice'];?></td>
          <td><?php echo $pastAuctions[$i]['ReservePrice'];?></td>  
          <td><?php echo $pastAuctions[$i]['NumberBids'];?></td>
          <td><?php echo $pastAuctions[$i]['HighestBid'] ?? '/';?></td>
          <td><?php echo $pastAuctions[$i]['OrderPrice'] ?? '/';?></td>
          <td>
            <?php  if (!isset($pastAuctions[$i]['OrderDate'])) {
                echo 'not applicable';
            }else if(isset($pastAuctions[$i]['Rating'])) {
                $k = 5;
                for ($j = 0; $j < $pastAuctions[$i]['Rating']; $j++){
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star"></span>';
                    $k--;
                }
                for ($p = 0; $p<$k; $p++) {
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star-empty"></span>';
                }
            } else { ?>
                please rate:
                <form method="post">
                    <input type="hidden" name="orderID" value="<?php echo $pastAuctions[$i]['OrderID']; ?>">
                    <button value="1" name = "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="2" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="3" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="4" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="5" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
              </form>
            <?php } ?>
            
          </td>
          <td><a href="<?php echo 'place_bid.php?id=' . h(u($pastAuctions[$i]['ItemID']))?>" class="btn btn-info">View</a></td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
    <?php } else { ?>
        <p>no past auctions to show</p>
    <?php } ?>  
</div>

<style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>
