<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
	
  		<script type="text/javascript">
			jQuery(document).ready(function() {
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
			});
			</script>

			<div style="display:none">
      	<div id="loginform"><?php require_once 'login.php'; ?></div>
      </div>
      
      <!-- DEALS SECTION -->
      <ul id="deals-container">
      	<li>
          <div class="deal-title">
            <h1><a href="">Dagens Tilbud</a></h1>
            <p><?php echo $deal->description; ?></p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(TRUE); ?>uploads/<?php echo "$deal->ID/$deal->image"; ?>)" >
          	<div>
              <div class="buy-container"><p class="huge buy-label">250,-</p></div>
              <div class="buy-img-cont"><?php echo HTML::image('images/buy.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            <div class="buy-container">
            	<p class="discounts">Værdi <?php echo $deal->regular_price; ?>,-   Rabat <?php echo $deal->discount; ?>%</p>
            </div>
            <div>
              <div class="buy-container" style="">
              	<p class="period-label">Tilbuddet stopper om</p>
                <p class="period">10 : 10 : 10</p>
              </div>
              <div class="clock-img-cont"><?php echo HTML::image('images/clock.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            
            <div>
              <div class="offer-container" style="">
              	<p class="period-label">Tilbuddet bliver aktiv ved 100 køb</p>
                <p class="period"><?php echo sizeof($orders); ?> har købt</p>
              </div>
              <div class="social-container">
              	<?php echo HTML::image('images/facebook.jpg', array('alt' => 'Share on facebook!')); ?>
              </div>
              <div class="save-label">SPAR <?php echo $deal->discount; ?>%</div>
              <div class="clear"></div>
            </div>
            
          </div>
        </li>
      </ul>
    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title"><?php echo $deal->contents_title; ?></a></h1>
          
          <p><?php echo str_replace("\n", "<br/>", $deal->contents); ?></p>

					<div id="deals-info">
            <ul>
              <li class="dhead-one">Det får du</li>
              <li><p><?php echo $deal->whatyouget; ?>   </p>
              </li>
            </ul>
            <ul>
            	<li class="dhead-two ">Praktiske oplysninger</li>
              <li><p> <?php echo $deal->information; ?></p></li>
            </ul>
        	</div>  
        </div>
        
        <div class="sidebar">
        	<center><?php echo HTML::image('images/sample-facebook.jpg', array('alt' => 'Tilbug i Byen')); ?></center>
        </div>
      </div>    	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>