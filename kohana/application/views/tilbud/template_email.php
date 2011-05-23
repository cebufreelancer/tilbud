<style type="text/css">
<!--
  body { font-family: "Arial", "Helvetica", sans-serif; }
  a { color: #40a2d5; }
  #main { border: 15px solid #40a2d5; background: #FFFFFF; width: 670px; padding: 15px; margin: auto; }
  #main-title { background: #000000; padding: 15px 10px;
                url(<?php echo url::base(TRUE)?>images/bg-header.png) bottom left repeat-x; }
  #deal-title { background: #40a2d5; color: #FFF; }
  #deal-title h1 { font-size: 22px; padding: 10px; }
  #deal-control { width: 200px; float: left; }
  #deal-content { width: 430px; float: left; padding-left: 25px; font: 18px/22px Arial, Helvetica, sans-serif; }
  #deal-content h2 { color: #666666; font-size: 22px; }
  #deal-content img { margin-bottom: 20px; }

  .price { font-size: 60px; font-weight: bold; text-align: center; color: #40a2d5; }
  .medium { font-size: 45px; }
  .button { background: url(<?php echo url::base(TRUE)?>images/bg-button.png) top left repeat-x; 
            color: #FFFFFF; font-weight: bold; font-size: 28px; 
            padding: 10px 15px; text-align: center; margin-bottom: 20px;
            border-radius: 10px; display: block; text-decoration: none; 
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-box-shadow: 0px 0px 20px #333 inset;
            -webkit-box-shadow: 0px 0px 20px #333 inset;
            box-shadow: 0px 0px 20px #333 inset;
          }
  .big { font-size: 18px; font-weight: bold; padding: 5px 20px 5px 0px; }
  .align-right { float: right; }
  .align-center { text-align: center; font-size: 11px; }
  .subhead { color: #40a2d5; }
  .contents { font-size: 14px; }
  .slogan { float: right; font-style: italic; color: #e9e9e9; font-size: 17px; padding-top: 15px; }
  .black { color: #000; }
  .clear { clear: both; }
  ::selection { background: #F85510; /* Safari */ }
  ::-moz-selection { background: #F85510; /* Firefox */ }
-->
</style>
<div class="black">
<p class="align-center">Jeg ønsker at se denne e-mail i min browser - <?php echo HTML::anchor(Url::base(TRUE) . 'deals/email_format/'.$deals->ID, 'klik her'); ?>.</p>	
<div id="main">
	<div id="main-title">
		<img src="<?php echo url::base(TRUE)?>images/logo.png" /><span class="slogan">De bedste tilbud og oplevelser i din by!</span>
	</div>
	
	<div id="deal-title">
		<h1><span class="black"><?php echo $deals->title; ?></span>  <?php echo html_entity_decode($deals->description); ?></h1>
	</div>
	
	<div id="deal-control">
		<?php $price = ($deals->regular_price * (100 - $deals->discount)) / 100; 
					$class = strlen($price) > 5 ? ' font-size: 45px;' : ''; 
					$savings = $deals->regular_price - $price; ?>
    
		<div class="price" style=" <?php echo $class; ?>"><span class="black"><?php echo $price; ?></span>,-</div>
		
		<div><a href="<?php echo Url::base(TRUE) . 'deals/view/' . $deals->ID; ?>"><?php echo HTML::Image(Url::base(TRUE) . 'images/ordernow.png', array('alt' => 'Order Now',
																																																																										 'style' => 'margin-bottom: 20px;')); ?></a></div> 
    		
		<div class="big">Værdi:	<span class="align-right"><?php echo $deals->regular_price; ?>,-</span></div>
		<div class="big">Rabat:	<span class="align-right"><?php echo $deals->discount; ?> %</span></div>
		<div class="big">Du sparer:	<span class="align-right"><?php echo $savings; ?>,-</span></div>
		<div class="clear"></div>
	
		<h3 class="subhead">Information</h3>
		<div class="contents"><?php echo $deals->information; ?></div>

		<h3 class="subhead">Hvor ligger det</h3>
		<div class="contents"><?php echo $deals->addresses; ?></div>
		
	</div>
	
	<div id="deal-content">
		<h2>Se dagens tilbud på video - klik her.</h2>
		<img src="<?php echo url::base(TRUE)?>images/sample-image.jpg" width="445" height="300" style="margin-bottom: 20px;"/>
		<?php echo html_entity_decode($deals->contents); ?>
	</div>
	<div class="clear"></div>
  
  <div style="text-align: right; margin-top: 25px;"><?php echo HTML::Image(Url::base(TRUE).'images/facebook-like.png'); ?></div>
</div>

<p class="align-center">Du modtager denne e-mail fordi du er tilmeldt nyhedsbrevet hos TilbudiByen.dk.Hvis du ikke ønsker at modtage Dagens Tilbud i Byen på e-mail længere kan du altid afmelde dig ved at klike her.</p>

<p class="align-center">Nyhedsbrevet udsendes af Tilbudibyen.dk ApS - Nørregade 7B - 1165 København K</p>
</div>