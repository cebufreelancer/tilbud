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
            <p><?= $deal->description ?></p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(); ?>uploads/<?= $deal->ID?>/<?= $deal->image?>)" >
          	<div>
              <div class="buy-container"><p class="huge buy-label"><?= ($deal->regular_price - ($deal->regular_price * ($deal->discount / 100) ))?>,-</p></div>
              <div class="buy-img-cont"><?php echo HTML::image('images/buy.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            <div class="buy-container">
            	<p class="discounts">V�rdi <?= $deal->regular_price?>,-   Rabat <?= $deal->discount ?>%</p>
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
              	<p class="period-label">Tilbuddet bliver aktiv ved <?= $deal->min_buy?> k�b</p>
                <p class="period"><?= sizeof($orders)?> har k�bt</p>
              </div>
              <div class="social-container">
              	<?php echo HTML::image('images/facebook.jpg', array('alt' => 'Share on facebook!')); ?>
              </div>
              <div class="save-label">SPAR <?= $deal->discount?>%</div>
              <div class="clear"></div>
            </div>
            
          </div>
        </li>
      </ul>
    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title"><?= $deal->contents_title ?></a></h1>
          
          <p><?= str_replace("\n", "<br/>", $deal->contents) ?></p>

					<div id="deals-info">
            <ul>
              <li class="dhead-one">Det f�r du</li>
              <li><p><?= $deal->whatyouget?>   </p>
              </li>
            </ul>
            <ul>
            	<li class="dhead-two ">Praktiske oplysninger</li>
              <li><p> <?= $deal->information?></p></li>
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