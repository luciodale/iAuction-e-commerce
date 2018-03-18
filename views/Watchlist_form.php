
<div class="container container-top-margin">
  <h1 align="center" class="titleWatch">Your Watchlist</h1>
  <p><br/></p>
  <table class="table table-hover" id="thistable" style="table-layout:fixed;">
    <thead>
      <tr>
        <th scope="col" class="text-center col-md-1" style="">#</th>
        <th scope="col" class="text-center col-md-1">Highest Bid</th>
        <th scope="col" class="text-center col-md-1" >Initial Price</th>
        <th scope="col" class="text-center col-md-2" >End Time</th>
        <th scope="col" class="text-center col-md-5">Item Name</th>
        <th scope="col" class="text-center col-md-2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php for($i = 0; $i < count($watchList); $i++){ ?>
      <tr id="testrow">
        <td scope="row" class="text-center col-md-1"><?php echo $i + 1;?></td>
        <td align="center" class="text-center col-md-1"><?php if ($watchList[$i]['BidPrice'] != 0) {echo $watchList[$i]['BidPrice'];} else {echo "No Bids";} ?></td>
        <td class="textOptions col-md-1"><?php echo $watchList[$i]['StartPrice'];?></td>
        <td class="textOptions col-md-2"><?php echo $watchList[$i]['EndTime'];?></td>
        <td class="textOptions col-md-5"><?php echo $watchList[$i]['ItemName'];?></td>

        <td class="textOptions inline col-md-2" style="">

        <button type="button" id="removebtn" class="btn btn-danger" onclick="DelWatch(this)" style="margin-top: 5px; margin-bottom: 5px;">Remove</button>

        <a style="color: white;" href="<?php echo 'place_bid.php?id=' . h($watchList[$i]['ItemID'])?>">
          <button class="btn btn-info" style="margin-top: 5px; margin-bottom: 5px;">&nbsp;&nbsp;View</button>
        </a>

      </td>
    </tr>

    <script type="text/javascript">
      window.DelWatch = function(rowind) {
        var indplus = rowind.parentNode.parentNode.rowIndex;
          // console.log(indplus);

          // console.log(watchnow[indplus-1]);
          // console.log(watchnow[indplus-1]['ItemID']);
          form = document.createElement('form');
          form.setAttribute('method', 'POST');
          form.setAttribute('action', 'watchlist.php');
          myvar = document.createElement('input');
          myvar.setAttribute('name', "DelItemize");
          myvar.setAttribute('type', 'hidden');
          myvar.setAttribute('value', watchnow[indplus-1]['ItemID']);
          form.appendChild(myvar);
          document.body.appendChild(form);
          form.submit(); 
        };
        var watchnow = <?php echo json_encode($watchList);?>
      </script>

      <?php } ?>

    </tbody>
  </table>

</div>

<style type="text/css">
footer {
 position: fixed;
 bottom:0;
 margin-bottom: 0;
 padding: 1rem;
}
</style>