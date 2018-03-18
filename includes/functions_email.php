<?php 

// require_once("../includes/config.php");
require_once("../library/vendor/autoload.php");

// ***********************************************
// EMAIL FOR ALL THE BIDDERS BUT THE ONE WHO JUST GOT OUTBID (different email for that guy)
function sendGeneralToBidders ($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL) {
  
  sendToUserBidding ($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL);
  sendToSeller ($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL);

  if(!isset($InfoForEmail['bidders'][0]['Email'])) return;

  sendToOutbidUser ($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL);

  for ($i = 1; $i < sizeof($InfoForEmail['bidders']); $i++) { 

    echo '<br/> highest bid: ' . $InfoForEmail['bidders'][0]['Username'];
    echo '<br/> highest bid: ' . $InfoForEmail['bidders'][$i]['Username'];

    if(strcmp($InfoForEmail['bidders'][0]['Username'], $InfoForEmail['bidders'][$i]['Username']) === 0) continue;

    $now = date('Y-m-d H:i:s');   
    $subject = "Hi " . $InfoForEmail['bidders'][$i]['Username'] . ", check the updates!";
    $from = new SendGrid\Email(null, $FROM_EMAIL);
    $to = new SendGrid\Email(null, $InfoForEmail['bidders'][$i]['Email']);
    $htmlContent = '<!DOCTYPE html>
    <html>
    <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
    /* FONTS */
    @media screen {
      @font-face {
        font-family: "Lato";
        font-style: normal;
        font-weight: 400;
        src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
      }

      @font-face {
        font-family: "Lato";
        font-style: normal;
        font-weight: 700;
        src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
      }

      @font-face {
        font-family: "Lato";
        font-style: italic;
        font-weight: 400;
        src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
      }

      @font-face {
        font-family: "Lato";
        font-style: italic;
        font-weight: 700;
        src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
      }
    }

    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; }

    /* RESET STYLES */
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* MOBILE STYLES */
    @media screen and (max-width:600px){
      h1 {
        font-size: 32px !important;
        line-height: 32px !important;
      }
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
    </head>
    <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
    <td bgcolor="#66BB7F" align="center">
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
    <td align="center" valign="top" width="600">
    <![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
    <tr>
    <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
    <a href="https://compgc06-group25.azurewebsites.net" target="_blank">
    <img alt="Logo" src="http://cdn.redmondpie.com/wp-content/uploads/2011/11/Apple-Logo.png" width="60" height="60" style="display: block; width: 40px; max-width: 40px; min-width: 40px; font-family: "Lato", Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
    </a>
    </td>
    </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </td>
    </tr>
    <!-- HERO -->
    <tr>
    <td bgcolor="#66BB7F" align="center" style="padding: 0px 10px 0px 10px;">
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
    <td align="center" valign="top" width="600">
    <![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
    <tr>
    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">


    <h1 style="font-size: 30px; font-weight: 400; margin: 0;">
    <strong>' .$InfoForEmail['bidders'][0]['Username'] . '</strong> bid on an auction you bid in the past! </h1>


    </td>
    </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </td>
    </tr>
    <!-- COPY BLOCK -->
    <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
    <td align="center" valign="top" width="600">
    <![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
    <!-- COPY -->
    <tr>
    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 400; line-height: 25px;" >


    <p style="margin: 0; text-align: center;">
    Bid value: ' . $currentItem['bid_price'] . ' £ <br>
    Bid time: ' . $now . '
    </p>


    </td>
    </tr>
    <!-- COPY -->
    <tr>
    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
    <p style="margin: 0; text-align: center;"><b>Auction Information</b></p>

    <p style="text-align: center;"> 
    Name: ' . $currentItem['ItemName'] . ' <br> 
    Condition: ' . $currentItem['StatusName'] . '  <br>
    Category: ' . $currentItem['CategoryName'] . '  <br> 
    Start price: ' . $currentItem['StartPrice'] . '  <br> 

    </td>
    </tr>
    <!-- BULLETPROOF BUTTON -->
    <tr>
    <td bgcolor="#ffffff" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
    <table border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td align="center" style="border-radius: 3px;" bgcolor="#66BB7F"><a href="https://compgc06-group25.azurewebsites.net/myauctions.php" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #66BB7F; display: inline-block;">Bid again for the lead!</a></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </td>
    </tr>

    <!-- SUPPORT CALLOUT -->
    <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
    <td align="center" valign="top" width="600">
    <![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
    <!-- HEADLINE -->
    <tr>
    <td bgcolor="#C0EDE0" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
    <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
    <p style="margin: 0;">Call us at +06 3674258532</p>
    </td>
    </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </td>
    </tr>
    <!-- FOOTER -->
    <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
    <tr>
    <td align="center" valign="top" width="600">
    <![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
    <!-- NAVIGATION -->
    <br>
    <!-- PERMISSION REMINDER -->
   

    <!-- ADDRESS -->
    <tr>
    <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
    <p style="margin: 0;">iAuction - 22 Main Street - London, UK - 33219</p>
    </td>
    </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </td>
    </tr>
    </table>

    </body>
    </html>';
    $content = new SendGrid\Content("text/html",$htmlContent);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // echo $subject;
    echo '<br/> ALL BIDDERS: <br/>';
    print_r($content);
    // echo '<br/>';
    $sg = new \SendGrid($apiKeyEmail);
    $response = $sg->client->mail()->send()->post($mail);
    // print_r($response);
    if ($response->statusCode() == 202) {
    // Successfully sent
      echo '<br/>done';
    } else {
  //     echo '<br/>false';
  //   }
    }
  }
}
// EMAIL FOR GUY WHO GOT OUTBID
function sendToOutbidUser ($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL) {

  $now = date('Y-m-d H:i:s');
  $subject = "Hi " . $InfoForEmail['bidders'][0]['Username'] . ", hurry up!!";
  $from = new SendGrid\Email(null, $FROM_EMAIL);
  $to = new SendGrid\Email(null, $InfoForEmail['bidders'][0]['Email']);
  $htmlContent = '<!DOCTYPE html>
  <html>
  <head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
  /* FONTS */
  @media screen {
    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 400;
      src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 700;
      src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 400;
      src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 700;
      src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
    }
  }

  /* CLIENT-SPECIFIC STYLES */
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; }

  /* RESET STYLES */
  img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  table { border-collapse: collapse !important; }
  body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

  /* iOS BLUE LINKS */
  a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
  }

  /* MOBILE STYLES */
  @media screen and (max-width:600px){
    h1 {
      font-size: 32px !important;
      line-height: 32px !important;
    }
  }

  /* ANDROID CENTER FIX */
  div[style*="margin: 16px 0;"] { margin: 0 !important; }
  </style>
  </head>
  <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <!-- LOGO -->
  <tr>
  <td bgcolor="#66BB7F" align="center">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
  <a href="https://compgc06-group25.azurewebsites.net" target="_blank">
  <img alt="Logo" src="http://cdn.redmondpie.com/wp-content/uploads/2011/11/Apple-Logo.png" width="60" height="60" style="display: block; width: 40px; max-width: 40px; min-width: 40px; font-family: "Lato", Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
  </a>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- HERO -->
  <tr>
  <td bgcolor="#66BB7F" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">


  <h1 style="font-size: 30px; font-weight: 400; margin: 0;">
  <strong>' . $_SESSION['username'] . '</strong> just outbid you! </h1>


  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- COPY BLOCK -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 400; line-height: 25px;" >


  <p style="margin: 0; text-align: center;">
  Bid value: ' . $currentItem['bid_price'] . ' £ <br>
  Bid time: ' . $now . ' 
  </p>


  </td>
  </tr>
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <p style="margin: 0; text-align: center;"><b>Auction Information</b></p>

  <p style="text-align: center;"> 
  Name: ' . $currentItem['ItemName'] . ' <br> 
  Condition: ' . $currentItem['StatusName'] . '  <br>
  Category: ' . $currentItem['CategoryName'] . '  <br> 
  Start price: ' . $currentItem['StartPrice'] . '  <br> 

  </td>
  </tr>
  <!-- BULLETPROOF BUTTON -->
  <tr>
  <td bgcolor="#ffffff" align="left">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="center" style="border-radius: 3px;" bgcolor="#66BB7F"><a href="https://compgc06-group25.azurewebsites.net/myauctions.php" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #66BB7F; display: inline-block;">Outbid them back!</a></td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>

  <!-- SUPPORT CALLOUT -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- HEADLINE -->
  <tr>
  <td bgcolor="#C0EDE0" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
  <p style="margin: 0;">Call us at +06 3674258532</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- FOOTER -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- NAVIGATION -->
  <br>
  <!-- PERMISSION REMINDER -->
 


  <!-- ADDRESS -->
  <tr>
  <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
  <p style="margin: 0;">iAuction - 22 Main Street - London, UK - 33219</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  </table>

  </body>
  </html>';
  $content = new SendGrid\Content("text/html",$htmlContent);
  $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // echo $subject;
  echo '<br/> OUTBID BUYER: <br/>';
  print_r($content);
    // echo '<br/>';
  $sg = new \SendGrid($apiKeyEmail);
  $response = $sg->client->mail()->send()->post($mail);
    // print_r($response);
  if ($response->statusCode() == 202) {
    // Successfully sent
    echo '<br/>done';
  } else {
    echo '<br/>false';
  }
}
// EMAIL FOR AUCTION HOLDER (SELLER)
function sendToSeller($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL) {

  $info[0] = $currentItem;
  $info[1] = $InfoForEmail;
  $now = date('Y-m-d H:i:s');
  $subject = "Hi " . $InfoForEmail['seller'][0]['Username'] . ", new bid on auction!!";
  $from = new SendGrid\Email(null, $FROM_EMAIL);
  // $to = new SendGrid\Email(null, $InfoForEmail['seller'][0]['Email']);
  $to = new SendGrid\Email(null, $InfoForEmail['seller'][0]['Email']);
  $htmlContent = '
  <!DOCTYPE html>
  <html>
  <head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
  /* FONTS */
  @media screen {
    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 400;
      src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 700;
      src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 400;
      src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 700;
      src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
    }
  }

  /* CLIENT-SPECIFIC STYLES */
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; }

  /* RESET STYLES */
  img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  table { border-collapse: collapse !important; }
  body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

  /* iOS BLUE LINKS */
  a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
  }

  /* MOBILE STYLES */
  @media screen and (max-width:600px){
    h1 {
      font-size: 32px !important;
      line-height: 32px !important;
    }
  }

  /* ANDROID CENTER FIX */
  div[style*="margin: 16px 0;"] { margin: 0 !important; }
  </style>
  </head>
  <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <!-- LOGO -->
  <tr>
  <td bgcolor="#66BB7F" align="center">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
  <a href="https://compgc06-group25.azurewebsites.net" target="_blank">
  <img alt="Logo" src="http://cdn.redmondpie.com/wp-content/uploads/2011/11/Apple-Logo.png" width="60" height="60" style="display: block; width: 40px; max-width: 40px; min-width: 40px; font-family: "Lato", Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
  </a>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- HERO -->
  <tr>
  <td bgcolor="#66BB7F" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">


  <h1 style="font-size: 30px; font-weight: 400; margin: 0;">

  You received a new bid from ' .$_SESSION['username'] . ' !!</h1>

  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- COPY BLOCK -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 400; line-height: 25px;" >


  <p style="margin: 0; text-align: center;">
  Bid value: ' . $currentItem['bid_price'] . ' £ <br>
  Bid time: ' . $now . '


  </td>
  </tr>
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <p style="margin: 0; text-align: center;"><b>Your Auction </b></p>

  <p style="text-align: center;"> Name: ' . $currentItem['ItemName'] . ' <br> 
  Condition: ' . $currentItem['StatusName'] . '   <br>
  Start price: ' . $currentItem['StartPrice'] . '  <br> 
  Reserve price: ' . $currentItem['ReservePrice'] . '  <br> 
  Views: ' . $currentItem['Views'] .'</p>


  </td>
  </tr>
  <!-- BULLETPROOF BUTTON -->
  <tr>
  <td bgcolor="#ffffff" align="left">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="center" style="border-radius: 3px;" bgcolor="#66BB7F"><a href="https://compgc06-group25.azurewebsites.net/myauctions.php" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #66BB7F; display: inline-block;">
  Check it out now!</a></td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>

  <!-- SUPPORT CALLOUT -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- HEADLINE -->
  <tr>
  <td bgcolor="#C0EDE0" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
  <p style="margin: 0;">Call us at +06 3674258532</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- FOOTER -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- NAVIGATION -->
  <br>
  <!-- PERMISSION REMINDER -->
 

  <!-- ADDRESS -->
  <tr>
  <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
  <p style="margin: 0;">iAuction - 22 Main Street - London, UK - 33219</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  </table>

  </body>
  </html>';
  $content = new SendGrid\Content("text/html",$htmlContent);
  $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // echo $subject;
  echo '<br/> USER SELLER: <br/>';
  print_r($content);
    // echo '<br/>';
  $sg = new \SendGrid($apiKeyEmail);
  $response = $sg->client->mail()->send()->post($mail);
    // print_r($response);
  if ($response->statusCode() == 202) {
    // Successfully sent
    echo '<br/>done';
  } else {
    echo '<br/>false';
  }
}
// EMAIL FOR BUYER WHO JUST MADE THE BID
function sendToUserBidding($currentItem, $InfoForEmail, $apiKeyEmail, $FROM_EMAIL) {

  $now = date('Y-m-d H:i:s');
  $subject = "Hi " . $_SESSION['username'] . ", new bid on auction!!";
  $from = new SendGrid\Email(null, $FROM_EMAIL);
  $to = new SendGrid\Email(null, $_SESSION['email']);
  $htmlContent = '<!DOCTYPE html>
  <html>
  <head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
  /* FONTS */
  @media screen {
    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 400;
      src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: normal;
      font-weight: 700;
      src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 400;
      src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
    }

    @font-face {
      font-family: "Lato";
      font-style: italic;
      font-weight: 700;
      src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
    }
  }

  /* CLIENT-SPECIFIC STYLES */
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; }

  /* RESET STYLES */
  img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  table { border-collapse: collapse !important; }
  body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

  /* iOS BLUE LINKS */
  a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
  }

  /* MOBILE STYLES */
  @media screen and (max-width:600px){
    h1 {
      font-size: 32px !important;
      line-height: 32px !important;
    }
  }

  /* ANDROID CENTER FIX */
  div[style*="margin: 16px 0;"] { margin: 0 !important; }
  </style>
  </head>
  <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <!-- LOGO -->
  <tr>
  <td bgcolor="#66BB7F" align="center">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
  <a href="https://compgc06-group25.azurewebsites.net" target="_blank">
  <img alt="Logo" src="http://cdn.redmondpie.com/wp-content/uploads/2011/11/Apple-Logo.png" width="60" height="60" style="display: block; width: 40px; max-width: 40px; min-width: 40px; font-family: "Lato", Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
  </a>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- HERO -->
  <tr>
  <td bgcolor="#66BB7F" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <tr>
  <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">


  <h1 style="font-size: 30px; font-weight: 400; margin: 0;">


  Bid Summary </h1>


  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- COPY BLOCK -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 400; line-height: 25px;" >


  <p style="margin: 0; text-align: center;">
  Bid value: ' . $currentItem['bid_price'] . ' £ <br>
  Bid time: ' . $now . '
  </p>


  </td>
  </tr>
  <!-- COPY -->
  <tr>
  <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <p style="margin: 0; text-align: center;"><b>On Auction</b></p>

  <p style="text-align: center;"> 
  Name: ' . $currentItem['ItemName'] . ' <br> 
  Condition: ' . $currentItem['StatusName'] . '  <br>
  Category: ' . $currentItem['CategoryName'] . '  <br> 
  Start price: ' . $currentItem['StartPrice'] . '  <br> 

  </td>
  </tr>
  <!-- BULLETPROOF BUTTON -->
  <tr>
  <td bgcolor="#ffffff" align="left">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="center" style="border-radius: 3px;" bgcolor="#66BB7F"><a href="https://compgc06-group25.azurewebsites.net/myauctions.php" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #66BB7F; display: inline-block;">See your bid list!</a></td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>

  <!-- SUPPORT CALLOUT -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- HEADLINE -->
  <tr>
  <td bgcolor="#C0EDE0" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
  <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
  <p style="margin: 0;">Call us at +06 3674258532</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  <!-- FOOTER -->
  <tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
  <!--[if (gte mso 9)|(IE)]>
  <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
  <tr>
  <td align="center" valign="top" width="600">
  <![endif]-->
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
  <!-- NAVIGATION -->
  <br>
  <!-- PERMISSION REMINDER -->
 

  <!-- ADDRESS -->
  <tr>
  <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
  <p style="margin: 0;">iAuction - 22 Main Street - London, UK - 33219</p>
  </td>
  </tr>
  </table>
  <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  </table>

  </body>
  </html>';
  $content = new SendGrid\Content("text/html",$htmlContent);
  $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // echo $subject;
  echo '<br/> USER BIDDING: <br/>';
  print_r($content);
    // echo '<br/>';
  $sg = new \SendGrid($apiKeyEmail);
  $response = $sg->client->mail()->send()->post($mail);
    // print_r($response);
  if ($response->statusCode() == 202) {
    // Successfully sent
    echo '<br/>done';
  } else {
    echo '<br/>false';
  }
}
// ***********************************************


// ***********************************************
// Email: Retrieve Auction Bidders for specific Auction ************
// getting recipient information 
function updateOnNewBid($data) {

  $InfoForEmail = [];

  if(!isset($data['users'][0])){
    $seller = $data['seller'];
    $InfoForEmail['seller'] = $data['seller'];
    return $InfoForEmail;
  }

  $bidders = $data['users'];
  $noDuplicates[0] = $bidders[0];

  $count = 1;

  for ($i = 1; $i < sizeof($bidders); $i++) {
    if(!isInArray($bidders[$i]["Username"], $noDuplicates)){
      $noDuplicates[$count] = $bidders[$i];
      $count++;
    }
  }

  $seller = $data['seller'];

  $InfoForEmail['bidders'] = $noDuplicates;
  $InfoForEmail['seller'] = $data['seller'];
  $InfoForEmail['latestBid'] = $data['bids'][0];

  return $InfoForEmail;
}

function isInArray($key, $array) {
  for($i = 0; $i < sizeof($array); $i++){
    if($key == $array[$i]["Username"]){
      return true;
    }
  }
}
// ***********************************************


?>