<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta CONTENT="text/html; charset=ISO-8859-1"/>
  <title>TILBUD</title>
	
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/base/jquery-ui.css" type="text/css" media="all" /> 

	<link rel="stylesheet" media="all" href="css/main.css"/>

	<meta name="viewport" content="width=device-width; initial-scale=1"/>
	<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
    
  <!--[if lt IE 9]>
  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
</head>
<body>

	<!-- header starts here -->
	<header id="main-header">
  	<div class="centered">
      <div id="header-container">
      	<div class="hlogo"><img src="images/logo.png" /></div>
        <div class="hcaption">De bedste tilbud på restauranter, rejser, wellness og meget andet.</div>
        <div class="hsocial">
        	<span>Del med dine venner</span><br />
            <?php 
							echo HTML::anchor('', HTML::image('images/socials/in.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/facebook.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/twitter.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/technorati.jpg')); 
						?>
        </div>
        
      </div>
      <nav id="header-nav">
        <ul>
          <li><?php echo HTML::anchor('', 'DAGENS TILBUD'); ?></li>
          <li><?php echo HTML::anchor('', 'TIDLIGERE TILBUD'); ?></li>
          <li><?php echo HTML::anchor('', 'TILMED DIG'); ?></li>
          <li><?php echo HTML::anchor('', 'OM OS'); ?></li>
          <li><?php echo HTML::anchor('', 'KONTAKT OS'); ?></li>
          <li><?php echo HTML::anchor('login', 'LOGIN'); ?></li>
          <li><?php echo HTML::anchor('', 'FAQ'); ?></li>
        </ul>
      </nav>
    </div>
  </header>
  
  