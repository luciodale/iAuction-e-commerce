  
<div class="container container-top-margin">
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">BidTime</th>
      <th scope="col">BidPrice</th>
      <th scope="col">StartPrice</th>
      <th scope="col">EndTime</th>
      <th scope="col">ItemName</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i = 0; $i < count($bidsList); $i++){ ?>
    <tr>
      <th scope="row"><?php echo $i + 1;?></th>
      <td><?php echo $bidsList[$i]['BidTime'];?></td>
      <td><?php echo $bidsList[$i]['BidPrice'];?></td>
      <td><?php echo $bidsList[$i]['StartPrice'];?></td>
      <td><?php echo $bidsList[$i]['EndTime'];?></td>
      <td><?php echo $bidsList[$i]['ItemName'];?></td>
      <td><?php echo $bidsList[$i]['Description'];?></td>
    </tr>
          <?php } ?>

  </tbody>
</table>

</div>