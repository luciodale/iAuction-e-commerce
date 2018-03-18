<div style="text-align: center;" class="container container-top-margin">
    <h3>Item Delete</h3>
    
    <?php if($boolDeleted == true) { ?>
    
    <p>The item was deleted successfully</p>
    
    <?php } else { ?>
    
    <p style="color:red">The item could not be deleted as the Auction has ended.</p>
    
    <a style="margin: 5px auto; width:200px;" href="<?php echo 'place_bid.php?id=' . h(u($currentItem['ItemID']))?>" class="btn btn-primary">Go Back To Item</a>
    
    <?php } ?>
    <br>
    <a style="margin: 5px auto; width:200px;" href="index.php" class="btn btn-primary">Go To Homepage</a>
    
    
    
    
    
</div>

<style type="text/css">
   footer {
   position: fixed;
   bottom:0;
   margin-bottom: 0;
   padding: 1rem;
 }
</style>