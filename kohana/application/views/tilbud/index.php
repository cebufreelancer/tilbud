<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
      
      <!-- DEALS SECTION -->
      <ul id="deals-container">
      	<li>
          <div class="deal-title">
            <h1><a href="">Dagens Tilbud</a></h1>
            <p><?php echo html_entity_decode($deal->description); ?></p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(TRUE); ?>uploads/<?php echo "$deal->ID/$deal->image"; ?>)" >
              <div class="buy-container">
              	<?php $price = ($deal->regular_price * (100 - $deal->discount)) / 100; ?>
              	<p class="huge buy-label" style="width: 600px;"><?php echo $price . ',-' . HTML::anchor('deals/buy?did=' . $deal->ID, HTML::image('images/buy.png', array('title' => 'Buy Now!', 'style' => 'margin-bottom: -10px;'))); ?></p>
              </div>
            <div class="buy-container">
            	<p class="discounts" style="text-align: left">Værdi <?php echo $deal->regular_price; ?>,- &nbsp; &nbsp; &nbsp;Rabat <?php echo $deal->discount; ?>%</p>
            </div>
            <div>
              <div class="buy-container" style="">
              	<script type="text/javascript">
								jQuery(document).ready(function() {
									var newYear = new Date(); 
									newYear = new Date("<?php echo $deal->end_date; ?>");
									$('#noDays').countdown({until: newYear, format: 'HMS', compact: true, description: '', timeSeparator: ' : '});
								});
								</script>
              	<p class="period-label">Tilbuddet stopper om</p>
                <p id="noDays" class="period">Promo Ended</p>
              </div>
              <div class="clock-img-cont"><?php echo HTML::image('images/clock.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            
            <div>
              <div class="offer-container" style="">
              	<p class="period-label">Tilbuddet bliver aktiv ved <?php echo $deal->vouchers; ?> køb</p>
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
        

        <!-- footer starts here -->
			  <?php require_once 'sidebar.php'; ?>

      </div>    	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>