<style>
    
    .rate {
        border: none !important;
        background-color:white !important;
        padding-left: 0px !important;
        font-size: 17px !important;
        color: #006dcc !important;
    }
    .rate:hover {
        color: darkblue!important;
    }

</style>

<div class="container container-top-margin">
    <h4>My Purchases</h4>
    <?php if (count($myPurchases) != 0) { ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Order Date</th>
          <th scope="col">Price Paid</th>
          <th scope="col">Item Name</th>
          <th scope="col">Your Rating</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($myPurchases); $i++){ ?>
        <tr>
          <th scope="row"><?php echo count($myPurchases) - $i;?></th>
          <td><?php echo $myPurchases[$i]['SoldDate'];?></td>
          <td><?php echo $myPurchases[$i]['OrderPrice'];?></td>
          <td><?php echo $myPurchases[$i]['ItemName'];?></td>
          <td>
            <div class="ratings">  
            <?php  if(isset($myPurchases[$i]['Rating'])) {
                $k = 5;
                for ($j = 0; $j < $myPurchases[$i]['Rating']; $j++){
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star"></span>';
                    $k--;
                }
                for ($p = 0; $p<$k; $p++) {
                    echo '<span style="font-size:17px;" class="glyphicon glyphicon-star-empty"></span>';
                }
                echo '</div>';
            } else { ?>
                please rate:
                <form method="post">
                    <input type="hidden" name="orderID" value="<?php echo $myPurchases[$i]['OrderID']; ?>">
                    <button value="1" name = "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="2" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="3" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="4" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
                    <button value="5" name= "star" type="submit" class="glyphicon glyphicon-star-empty rate"></button>
              </form>
            <?php } ?>
            
          </td>
          <td><a href="<?php echo 'place_bid.php?id=' . h(u($myPurchases[$i]['ItemID']))?>" class="btn btn-info">View</a></td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
    <?php } else { ?>
        <p>no purchases to show</p>
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