<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta CONTENT="text/html; charset=ISO-8859-1"/>
  <title>TilbudiByen</title>
	
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/base/jquery-ui.css" type="text/css" media="all" /> 
	<link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/main.css"/>

	<meta name="viewport" content="width=device-width; initial-scale=1"/>
	<!-- Add "maximum-scale=1" to fix the weird iOS auto-zoom bug on orientation changes. -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.js"></script> 
	<link rel="stylesheet" type="text/css" href="<?php echo url::base()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript" src="<?php echo url::base()?>js/jquery.countdown.pack.js"></script>

  <!-- for live -->
  <?php
  $live = '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xTh1Xu1DCtyDZLHCop3sXObMWlGYBRqFcGWz0zY_HTPH9tdC_yHU2a-Ag" type="text/javascript"></script>';
  $local = '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xTb-vLQlFZmc2N8bgWI8YDPp5FEVBR0fbtPlG0ajsdbFHG0Bo4Nt1JTHA" type="text/javascript"></script>';
  ?>
  
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAbQlC_gF4H7R0hbKr8QVz5xQYncROD2BDKvWqEuo4PwsE_DGQgRS20trX2PsZLb7gtB92IP55joerMA" type="text/javascript"></script>  

  <script>
  	jQuery(document).ready(function() {
      $("#signupform-footer").bind("submit", function() {
      	$.fancybox.showActivity();

      	$.ajax({
      		type		: "POST",
      		cache	: false,
      		url		: "home/signup",
      		data		: $(this).serializeArray(),
      		success: function(data) {
      			$.fancybox(data);
      		}
      	});

      	return false;
      });

    });
  </script>
    
  
  <!--[if lt IE 9]>
  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
</head>
<body onLoad="initialize()" onunload="GUnload()">
	
		<?php if(isset($is_referral)) { ?>
    <a href="<?php echo Url::base() . 'home/referral'; ?>" id="referral-form" ></a>
    <script type="text/javascript">
			$(document).ready(function() {
				$("#referral-form").fancybox({
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
      	}).trigger('click');				
    	});
		</script>
    <?php } ?>

		<?php if(isset($msg)) { ?>
		<div id="notification">
			<p>Thank you for your subscription! Please check your email for verification. 
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
      $map_address = "";
      if (isset($address)) {
        $address = strtolower(html_entity_decode($address));
        $map_address = str_replace("\n", " ", $address);
    ?>
      <script type="text/javascript">
          var map = null;
          var geocoder = null;

          function initialize() {
            if (GBrowserIsCompatible()) {
              map = new GMap2(document.getElementById("map_canvas"));
              map.addControl(new GLargeMapControl());
              map.setCenter(new GLatLng(10.3455617, 123.8969328), 15);
              geocoder = new GClientGeocoder();
              showAddress("<?= $map_address . " denmark " ?>");
            }
          }

          function showAddress(address) {
            geocoder.getLatLng(
              address,
              function(point) {
                if (!point) {
                  //alert(address + " not found");
                } else {
                  map.setCenter(point, 15);
                  var marker = new GMarker(point);
                  map.addOverlay(marker);
                  //marker.openInfoWindowHtml(address);
                }
              }
            );
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
            <a class="addthis_button_preferred_4"><img src="<?= url::base(true)?>images/socials/in.jpg" alt="" /></a>    	
            <?php 
            
							echo HTML::anchor('http://www.addthis.com/bookmark.php?v=250&winname=addthis&pub=ra-4d6e3a782d6e35f6&source=tbx-250&lng=da&s=facebook&url=http%3A%2F%2Ftilbudibyen.dk%2F&title=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&ate=AT-ra-4d6e3a782d6e35f6/-/fs-0/4d6e50716ec654ce/1/4cc81af600857552&ips=1&uid=4cc81af600857552&sms_ss=1&at_xt=1&CXNID=2000001.5215456080540439074NXC&tt=0', HTML::image('images/socials/facebook.jpg')); 
							echo HTML::anchor('http://twitter.com/share?url=http%3A%2F%2Ftilbudibyen.dk%2F%3Fsms_ss%3Dtwitter%26at_xt%3D4d6e55361b58d8b5%2C0&via=AddThis&text=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&', HTML::image('images/socials/twitter.jpg')); 
							echo HTML::anchor('', HTML::image('images/socials/myspace.jpg')); 
						?>
        </div>
        
      </div>
      
      <?php include_once 'menu.php'; ?>
      
    </div>
  </header>


  	<script type="text/javascript">

  	jQuery(document).ready(function() {

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

  		$("#tip5-old").fancybox({
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
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
          'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		$("#ifaq2").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  		$("#icontact").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  		$("#icontact2").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      $("#iabout").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

      $("#iabout2").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      
      $("#ihow").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      
      $("#iterms").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		
  		$("#isuggest").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
  		$("#iwhy").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });
      $("#igetyourbusiness").fancybox({
      		'width'				: 712,
      		'height'			: 458,
          'autoDimensions' : false,
              'transitionIn'		: 'none',
      		'transitionOut'		: 'none',
      		'type'				: 'iframe'
      });

  		$("#signup").fancybox({
  			'scrolling'		: false,
  			'titleShow'		: false,
				'autoDimensions' : true,
				'width'		: 710,
  			'height'		: 455,
  			'overlayOpacity' : 0.7,
  			'centerOnScroll' : true,
  			'transitionIn' : 'fade',
  			'showCloseButton' : false,
				'enableEscapeButton' : true,
  			'hideOnOverlayClick' : false,
  			'hideOnContentClick' : false,
				'type' : 'iframe',
				'href'	: '<?php echo Url::base(TRUE); ?>signup',
  			'onClosed'		: function() {
  					$("#login_error").hide();
  			}
  		});

  		$("#signup-footer").fancybox({
  			'scrolling'		: false,
  			'titleShow'		: false,
  			'autoScale'	: true,
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
  		
  	});
	
  	</script>

  	<div style="display:none">
    	<div id="loginform"><?php require_once 'login.php'; ?></div>
    </div>

  	<div style="display:none">
    	<div id="signup-form"><?php require_once 'signupform.php'; ?></div>
    </div>

  	<div style="display:none">
    	<div id="signup-form-footer"><?php require_once 'signupform-footer.php'; ?></div>
    </div>