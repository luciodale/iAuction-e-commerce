

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/img/apple_icon.png">

  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">

  <!-- http://getbootstrap.com/ -->
  <link href="/css/bootstrap.min.css" rel="stylesheet"/>

  <link href="/css/global.css" rel="stylesheet"/>

  <link href="/css/home.css" rel="stylesheet"/>

  <link href="/css/tooltip.css" rel="stylesheet"/>

  <link href="/css/signin_register.css" rel="stylesheet"/>

  <link href="https://fonts.googleapis.com/css?family=Fugaz+One" rel="stylesheet">


  <?php if (isset($title)): ?>
    <title><?= $title ?></title>
  <?php else: ?>
    <title>iAuction</title>
  <?php endif ?>



</head>

<body>
  
  <header>
    <div class="navbar-wrapper">
      <div class="container">

       <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="<?php echo '/index.php'; ?>"> <img src="<?php echo 'img/logo.png'; ?>" width="75"></a>
          </div>

          <div id="navbar" class="navbar-collapse collapse">  
            <ul class="nav navbar-nav navbar-right">
             <li><a href="index.php"><span class="glyphicon glyphicon-log-in">
             </span> Back to Home Page</a></li>
           </ul>
         </div>
       </div>
     </nav>
   </div>
 </div>
</header>