<?php


function create_slides_indicators($iterator) {

  $output = ''; 

  for($count = 0; $count < $iterator; $count++) 
  {
    if($count == 0)
    {
     $output .= '
     <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
     ';
   }
   else
   {
     $output .= '
     <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>
     ';
   }
 }
 return $output;
}

function create_slides($currentImages){

  $output = ''; 
  $iteration = count($currentImages);


  for($count = 0; $count < $iteration; $count++) 
  {
    if($count == 0)
    {
     $output .= '<div class="item active">';
   }
   else
   {
     $output .= '<div class="item">';
   }
   $output .= '
   <img src="data:image;base64,'. $currentImages[$count]['Image']. '" />
   </div>
   ';
 }
 return $output;
}


?>