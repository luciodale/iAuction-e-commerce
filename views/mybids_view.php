<div class="container container-top-margin">
    <h4 style="text-align: center; font-size: 35px" >Current bids</h4>
    <?php if (count($currentBids) != 0) { ?>
    </br>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">BidTime</th>
          <th scope="col">BidPrice</th>
          <th scope="col">StartPrice</th>
          <th scope="col">EndTime</th>
          <th scope="col">ItemName</th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($currentBids); $i++){ ?>
        <tr>
          <th scope="row"><?php echo count($currentBids) - $i;?></th>
          <td><?php echo $currentBids[$i]['BidTime'];?></td>
          <td><?php echo $currentBids[$i]['BidPrice'];?></td>
          <td><?php echo $currentBids[$i]['StartPrice'];?></td>
          <td><?php echo $currentBids[$i]['EndTime'];?></td>
          <td><?php echo $currentBids[$i]['ItemName'];?></td>
          <td><a href="<?php echo 'place_bid.php?id=' . h(u($currentBids[$i]['ItemID']))?>" class="btn btn-info">View</a></td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
    <?php } else { ?>
        <p>No current bids to show</p>
    <?php } ?> 

    </br>
    <h4 style="text-align: center; font-size: 35px">Past bids</h4>
    <?php if (count($pastBids) != 0) { ?>
    </br>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">BidTime</th>
          <th scope="col">BidPrice</th>
          <th scope="col">StartPrice</th>
          <th scope="col">EndTime</th>
          <th scope="col">ItemName</th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($pastBids); $i++){ ?>
        <tr>
          <th scope="row"><?php echo count($pastBids) - $i;?></th>
          <td><?php echo $pastBids[$i]['BidTime'];?></td>
          <td><?php echo $pastBids[$i]['BidPrice'];?></td>
          <td><?php echo $pastBids[$i]['StartPrice'];?></td>
          <td><?php echo $pastBids[$i]['EndTime'];?></td>
          <td><?php echo $pastBids[$i]['ItemName'];?></td>
          <td><a href="<?php echo 'place_bid.php?id=' . h(u($pastBids[$i]['ItemID']))?>" class="btn btn-info">View</a></td>
        </tr>
        <?php } ?>

      </tbody>
    </table>
    <?php } else { ?>
        <p>no past bids to show</p>
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