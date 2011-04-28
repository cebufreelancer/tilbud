<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta CONTENT="text/html; charset=ISO-8859-1"/>
  <title>TILBUD</title>
	
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/base/jquery-ui.css" type="text/css" media="all" /> 
	<link rel="stylesheet" media="all" href="<?php echo url::base()?>css/main.css"/>

	<meta name="viewport" content="width=device-width; initial-scale=1"/>
	<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.js"></script> 
	<link rel="stylesheet" type="text/css" href="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript" src="<?php echo url::base()?>js/jquery.countdown.pack.js"></script>
  
  <!--[if lt IE 9]>
  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
</head>
<body>

	<!-- header starts here -->
	<header id="main-header">
  	<div class="centered">
      <div id="header-container">
      	<a href="<?= url::base();?>"><div class="hlogo"><?php echo HTML::image('images/logo.png', array('alt' => 'Tilbug i Byen')); ?></div></a>
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
      
      <?php include_once 'menu.php'; ?>
      
      <?php if (Auth::instance()->logged_in() == 1){?>
      <div style="position: relative; text-align: right; float: right; top: 10px; top: -130px">
        <?php echo HTML::anchor('account', 'My Account'); ?> |
        <?php echo HTML::anchor('account', 'My Deals'); ?>
      </div>
      <? } ?>
    </div>
  </header>
