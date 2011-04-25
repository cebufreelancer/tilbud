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
            <p>Halv pris på en stor sushi-menu til 2 personer hos Sushi.com på Sankt Annæ Plads. Del det med en du holder af - for der er mere end nok til 2.</p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(); ?>images/sample-image.jpg)" >
          	<div>
              <div class="buy-container"><p class="huge buy-label">250,-</p></div>
              <div class="buy-img-cont"><?php echo HTML::image('images/buy.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            <div class="buy-container">
            	<p class="discounts">Værdi 500,-   Rabat 50%</p>
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
                <p class="period">1.235 har købt</p>
              </div>
              <div class="social-container">
              	<?php echo HTML::image('images/facebook.jpg', array('alt' => 'Share on facebook!')); ?>
              </div>
              <div class="save-label">SPAR 50%</div>
              <div class="clear"></div>
            </div>
            
          </div>
        </li>
      </ul>
    		
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>