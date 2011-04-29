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
							echo HTML::anchor('', HTML::image('images/socials/email.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/facebook.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/twitter.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/myspace.jpg')); 
						?>
        </div>
        
      </div>
      
      <?php include_once 'menu.php'; ?>
      
    </div>
  </header>


  	<script type="text/javascript">

  	jQuery(document).ready(function() {

  		$("#tip5-new").fancybox({
  			'scrolling'		: false,
  			'titleShow'		: false,
  			'autoScale'	: false,
  			'frameWidth'		: 900,
  			'frameHeight'		: 460,
  			'overlayOpacity' : 0.7,
  			'centerOnScroll' : true,
  			'transitionIn' : 'elastic',
  			'showCloseButton' : false,
  			'hideOnOverlayClick' : false,
  			'hideOnContentClick' : false,
  			'onClosed'		: function() {
  					$("#login_error").hide();
  			}
  		});

  		$("#tip5").fancybox({
  			'scrolling'		: 'true',
  			'titleShow'		: false,
  			'hideOnOverlayClick' : false,
  			'hideOnContentClick' : false,
  			'showCloseButton' : true,
  			'onClosed'		: function() {
  					$("#login_error").hide();
  			}
  		});
  		
  		$("#ifaq").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		$("#ifaq2").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  		$("#icontact").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  		$("#icontact2").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      $("#iabout").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

      $("#iabout2").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      
      $("#ihow").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      $("#iterms").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		
  		$("#isuggest").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		$("#iwhy").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      $("#igetyourbusiness").fancybox({
      		'width'				: '80%',
      		'height'			: '95%',
              'autoScale'     	: false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		
  		
  		
  		

  		
  	});
	
  	</script>

  	<div style="display:none">
    	<div id="loginform"><?php require_once 'login.php'; ?></div>
    </div>