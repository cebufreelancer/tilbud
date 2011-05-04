<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
      
      <?php if(isset($deal)) { ?>
      
      <!-- DEALS SECTION -->
      <ul id="deals-container">
      	<li>
          <div class="deal-title">
            <h1><a href=""><?= LBL_Featured_Deal ?></a></h1>
            <p><?php echo substr(html_entity_decode($deal->description), 0, 200); ?></p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(TRUE); ?>uploads/<?php echo "$deal->ID/$deal->image"; ?>)" >
              <div class="buy-container">
              	<?php $price = ($deal->regular_price * (100 - $deal->discount)) / 100; ?>
              	<p class="huge buy-label" style="width: 600px;"><?php echo $price . ',-' . HTML::anchor('deals/buy/' . $deal->ID, HTML::image('images/buy.png', array('title' => LBL_Buy_now, 'style' => 'margin-bottom: -10px;'))); ?></p>
              </div>
            <div class="buy-container">
            	<p class="discounts" style="text-align: left">V�rdi <?php echo number_format($deal->regular_price, 0, '.', ''); ?>,- <span style="float:right;">Rabat <?php echo number_format($deal->discount, 0, '.', ''); ?>%</span></p>
            </div>
            <div>
              <div class="buy-container" style="">
              	<script type="text/javascript">
								jQuery(document).ready(function() {
									var newYear = new Date(); 
									newYear = new Date(newYear.toDateString() + " 23:59:59");
									$('#noDays').countdown({until: newYear, format: 'HMS', compact: true, description: '', timeSeparator: ' : '});
								});
								</script>
              	<p class="period-label"><?= LBL_OFFER_ENDS ?></p>
                <p id="noDays" class="period"><?= LBL_PROMO_ENDED ?></p>
              </div>
              <div class="clock-img-cont"><?php echo HTML::image('images/clock.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            
            <div>
              <div class="offer-container" style="">
              	<p class="period-label"><?= LBL_OFFER_ACTIVE_WHEN ?> <?php echo $deal->vouchers; ?> <?= LBL_BUY ?></p>
                <p class="period"><?php echo sizeof($orders); ?> <?= LBL_BOUGHT ?></p>
              </div>
              <div class="social-container">
              	
              	<?php echo HTML::image('images/facebook.jpg', array('alt' => LBL_SHARE_ON_FACEBOOK)); ?>
              </div>
              <div class="save-label"><?= LBL_SPAR ?> <?php echo number_format($deal->discount, 0, '.', ''); ?>%</div>
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
              <li class="dhead-one"><?= LBL_WHAT_YOU_GET?></li>
              <li><p><?php echo $deal->whatyouget; ?>   </p>
              </li>
            </ul>
            <ul>
            	<li class="dhead-two "><?= LBL_INFORMATION ?></li>
              <li><p> <?php echo $deal->information; ?></p></li>
            </ul>
        	</div>
        	
        	<div id="deals-info">
            <ul>
              <li class="dhead-one"> <?= LBL_ADDRESS?> </li>
              <li><p> <?= str_replace("\n", "<br/>", $vendor->address)?></p> </li>
            </ul>            
            <ul>
              <li class="dhead-two"> <?= LBL_MAP ?> </li>
              <li><center><div id="map_canvas" style="width: 390px; height: 300px;"></div></center>  </li>
            </ul>
        	
        	</div>
        </div>
        

        <!-- footer starts here -->
			  <?php require_once 'sidebar.php'; ?>

      </div>	

      <?php } else { ?>
      	<p style="text-align: center; padding: 80px 40px;"> <?= LBL_NO_DEALS_CREATED ?> </p>
      <?php } ?>      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>