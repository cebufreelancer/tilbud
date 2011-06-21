<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="da" lang="da" xmlns:og="http://ogp.me/ns#"   xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
  <meta CONTENT="text/html; charset=utf-8"/>
  <title>TilbudiByen</title>
	
  <link rel="stylesheet" href="<?php echo url::base()?>js/jquery-ui.css" type="text/css" media="all" />
  <link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/main.css"/>
  <link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/s3Slider.css"/>
	
  <?php if (isset($deal)) {?>
  <meta property="og:type" content="restaurant"/> 
  <meta property="og:url" content="<?= url::base(true);?>deals/view/<?= $deal['ID'];?>"/>
  <meta property="og:site_name" content="www.tilbudibyen.com"/> 
	<meta property="og:title" content="<?php echo html_entity_decode($deal['contents_title']) ?>" />
	<meta property="og:description" content="<?php echo html_entity_decode($deal['description']);?>" />
	
  	<?php if ($deal['facebook_image'] != "") {?>
  	  <meta property="og:image" content="<?php echo url::base(true) . "uploads/" . $deal['ID'] . "/" . rawurlencode($deal['facebook_image']); ?>" />
  	  <link rel="image_src"  type="image/jpeg"  href="<?php echo url::base(true) . "uploads/" . $deal['ID'] . "/" . rawurlencode($deal['facebook_image']); ?>" />
  	<?php }else {?>
  	  <meta property="og:image" content="<?php echo url::base(true) . "images/logo.png";?>"/>
  	  <link rel="image_src" href="<?php echo url::base(true) . "images/logo.png"; ?>"/>
  	<?php } ?>
  <?php }else {?>
    <meta property="og:type" content="article"/> 
    <meta property="og:url" content="<?= url::base(true);?>"/>
    <meta property="og:site_name" content="www.tilbudibyen.com"/> 
  	<meta property="og:title" content="TilbudIbyen" />
  	<meta property="og:description" content="50% Discounts daily" />
	  <meta property="og:image" content="<?php echo url::base(true) . "images/logo.png";?>"/>
	  <link rel="image_src" href="<?php echo url::base(true) . "images/logo.png"; ?>"/>
  <?php } ?>

	<meta name="viewport" content="width=device-width; initial-scale=1"/>
	<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->
	<script type="text/javascript" src="<?php echo url::base()?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo url::base()?>js/jquery-ui.min.js"></script>

  <script type="text/javascript" src="<?php echo url::base()?>js/fancybox/jquery.easing-1.3.pack.js"></script> 
  <script type="text/javascript" src="<?php echo url::base()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  	  
  <script type="text/javascript" src="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.js"></script> 
	<link rel="stylesheet" type="text/css" href="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript" src="<?php echo url::base()?>js/jquery.countdown.pack.js"></script>

	<!-- for live -->
  <?php
  $live = '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xTh1Xu1DCtyDZLHCop3sXObMWlGYBRqFcGWz0zY_HTPH9tdC_yHU2a-Ag" type="text/javascript"></script>';
  $local = '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xTb-vLQlFZmc2N8bgWI8YDPp5FEVBR0fbtPlG0ajsdbFHG0Bo4Nt1JTHA" type="text/javascript"></script>';
  ?>

  <?php if (isset($address)) { ?>
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xQYncROD2BDKvWqEuo4PwsE_DGQgRS20trX2PsZLb7gtB92IP55joerMA" type="text/javascript"></script>  
  <?php } ?>
      
  <!--[if lt IE 9]>
  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
</head>
<body <?php if (isset($address)) { echo  'onLoad="initialize()" onunload="GUnload()"'; }?>>

  <a href="#signup-form" id="newvisitor" ></a>

		<?php if(isset($is_referral)) { ?>
    <div style="display:none"><div id="account_verified"><?php include 'referral.php'; ?></div></div>
    <a href="<?php echo Url::base(TRUE) . 'referral'; ?>" id="referral-form" ></a>
    <script type="text/javascript">
			$(document).ready(function() {
				$("#referral-form").fancybox({
      		'scrolling'		: false,
					'titleShow'		: false,
					'autoScale'	: false,
					'width'		: 760,
					'height'		: 420,
					'overlayOpacity' : 0.7,
					'centerOnScroll' : true,
					'transitionIn' : 'elastic',
					'showCloseButton' : false,
					'hideOnOverlayClick' : false,
					'hideOnContentClick' : false,
					'type' : 'iframe',
      	}).trigger('click');				
    	});
		</script>
    <?php } ?>

		<?php if(isset($msg)) { ?>
      <div id="notification">
        <p><?php echo $msg; ?> 
        <?php echo HTML::image(Url::base(TRUE) . 'images/close.png', array('align' => 'right', 'width' => 10, 'id' => 'closeme')); ?>
        </p>
      </div>
      <script type="text/javascript">
      $("#notification").slideDown('fast');
      $("#closeme").click(function(){
        $("#notification").slideToggle('fast');
      });
      </script>
		<?php }	?>

    <?php
      $map_address = array();
      if (isset($address)) {
    ?>
		<script type="text/javascript">
        var map = null;
        var geocoder = null;

				<?php
				$address_list = '';
				for($i=0; $i<sizeof($address); $i++){
				  $address_list .=  '"' . html_entity_decode($address[$i]['address']) . '"';
				  if($i < sizeof($address)-1) {
				    $address_list .= ",";
				  }
				}
				?>
				
				var addressMaps = new Array(<?php echo $address_list;?>);
				//"mabolo cebu city philippines 6000", "mandaue city 6014 philippines");
        var bounds = new GLatLngBounds();
        var gmarkers = [];
        
        function initialize() {
          if (GBrowserIsCompatible()) {
            map = new GMap2(document.getElementById("map_canvas"));
            map.addControl(new GLargeMapControl());
            //map.setCenter(new GLatLng(10.3455617, 123.8969328), 15);
            map.setCenter(new GLatLng(0,0),0);
            geocoder = new GClientGeocoder();
            var bounds = new GLatLngBounds();
						$(addressMaps).each(function(index, value) {
              showAddress(value);
						});
						map.setZoom(map.getBoundsZoomLevel(bounds));
						map.setCenter(bounds.getCenter());
          }
        }

        function showAddress(address) {
          geocoder.getLatLng(
            address,  
            function(point) {
              if (!point) {
                //alert(address + " not found");
              } else {
                map.setCenter(point, 11);
                var marker = new GMarker(point);
                gmarkers.push(marker);
                map.addOverlay(marker);
                GEvent.addListener(marker, "click", function() {
                        marker.openInfoWindowHtml(address);
                });
                marker.openInfoWindowHtml(address);
              }
            }
          );
        }
        
        function myaddress(i) {
          GEvent.trigger(gmarkers[i], "click");
        }
    </script>
  <?php } ?>

	<!-- header starts here -->
	<header id="main-header">
  	<div class="centered">
      <div id="header-container">
      	<a href="<?= url::base();?>"><div class="hlogo"><?php echo HTML::image('images/logo.png', array('alt' => 'Tilbug i Byen')); ?></div></a>
        <div class="hcaption"><?= LBL_TAG_LINE ?></div>
        <div class="hsocial">
        	<span><?= LBL_SHARE_LINKS ?></span><br />

          <div class="addthis_toolbox addthis_default_style ">
            <div class="addthis_toolbox addthis_default_style ">              
            </div>
          </div>

          <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
          <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d6e3a782d6e35f6"></script>
            <a target="_blank" class="addthis_button_preferred_4"><img src="<?= url::base(true)?>images/socials/in.jpg" alt="" /></a>    	
            <a target="_blank" href="<?= url::base(true);?>home/fb"/><img src="<?= url::base(true)?>images/socials/facebook.jpg"></a>
            <a target="_blank" href="http://twitter.com/share?url=http%3A%2F%2Ftilbudibyen.dk%2F%3Fsms_ss%3Dtwitter%26at_xt%3D4d6e55361b58d8b5%2C0&via=AddThis&text=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&"/><img src="<?= url::base(true);?>images/socials/twitter.jpg"></a>
        </div>
        
      </div>
      
      <?php include_once 'menu.php'; ?>
      
    </div>
  </header>


  	<script type="text/javascript">

  	jQuery(document).ready(function() {

  		$("#login2").fancybox({
  			'scrolling'		: false,
  			'titleShow'		: false,
  			'autoScale'	: false,
  			'frameWidth'		: 900,
  			'frameHeight'		: 460,
  			'overlayOpacity' : 0.7,
  			'centerOnScroll' : true,
  			'transitionIn' : 'elastic',
  			'showCloseButton' : true,
  			'hideOnOverlayClick' : false,
  			'hideOnContentClick' : false,
  			'onClosed'		: function() {
  					$("#login_error").hide();
  			}
  		});
			
  		$("#tip5").fancybox({
  			'scrolling'		: false,
  			'titleShow'		: false,
  			'autoScale'	: false,
  			'frameWidth'		: 900,
  			'frameHeight'		: 460,
  			'overlayOpacity' : 0.7,
  			'centerOnScroll' : true,
  			'transitionIn' : 'elastic',
  			'showCloseButton' : true,
  			'hideOnOverlayClick' : false,
  			'hideOnContentClick' : false,
  			'onClosed'		: function() {
  					$("#login_error").hide();
  			}
  		});
			$("a.ipages").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
          'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  	});
  	</script>

		<?php if(!$is_logged) { ?>
    
			<script type="text/javascript">
      jQuery(document).ready(function() {
        $("a.signup").fancybox({
        'scrolling' : 'no',
        'titleShow'	: false,
        'onClosed'	: function() { 
          $("#login_error").hide(); }	
        });
      });
      </script>
      <div style="display:none">
        <div id="loginform"><?php include 'login.php'; ?></div>
      </div>
  
      <div style="display:none">
        <div id="signup-form"><?php include 'signupform.php'; ?></div>
      </div>
    
			<?php 
			// Check if visitor has already visited the website
			// Cookie expiration is set to 2 weeks or 
			if (is_null(Cookie::get('tib'))) { ?>
        <script type="text/javascript">
        $(document).ready(function() {
          $("#renamed_newvisitor").fancybox({
            'scrolling'		: false,
            'titleShow'		: false,
            'autoScale'	: false,
            'frameWidth'		: 900,
            'frameHeight'		: 460,
            'overlayOpacity' : 0.7,
            'centerOnScroll' : true,
            'transitionIn' : 'elastic',
            'showCloseButton' : true,
            'enableEscapeButton' : false,
            'hideOnOverlayClick' : false
          }).trigger('click');
        });
        </script>
      <?php } ?>
      
		<?php } ?>