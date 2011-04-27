<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta CONTENT="text/html; charset=ISO-8859-1"/>
  <title>TILBUD</title>
	
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/base/jquery-ui.css" type="text/css" media="all" /> 

  <?php echo Html::style('css/main.css') . "\n"; ?>

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
      	<a href="<?= url::base(true)?>"><div class="hlogo"><?php echo HTML::image('images/logo.png', array('alt' => 'Tilbug i Byen')); ?></div></a>
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
          <li><?php echo HTML::anchor('admin/users', 'USERS'); ?></li>
          <li><?php echo HTML::anchor('admin/cities', 'CITIES'); ?></li>
          <li><?php echo HTML::anchor('admin/vendors', 'VENDORS'); ?></li>
          <li><?php echo HTML::anchor('admin/products', 'PRODUCTS'); ?></li>
          <li><?php echo HTML::anchor('admin/deals', 'DEALS'); ?></li>
          <li><?php echo HTML::anchor('admin/orders', 'ORDERS'); ?></li>
          <li><?php echo HTML::anchor('user/logout', 'LOGOUT'); ?></li>
        </ul>
      </nav>
    </div>
  </header>