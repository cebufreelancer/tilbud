<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
    	
      <!-- DEALS SECTION -->    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title"><?= LBL_ALLDEALS ?></a></h1>


          <?php foreach($deals as $deal){ ?>
            <div class="deals-widget">
            	<?php
							$deal_contents = html_entity_decode(strip_tags($deal->description));
							$title = strlen($deal_contents) > 65 ? substr($deal_contents,0,65) . ' ...' : $deal_contents;
							$title_url = HTML::anchor('deals/view/' . $deal->ID, $title, array('title' => $deal->title . '-' . $deal_contents,
																																									 'class' => 'widget-title'));
							$regular_price    = $deal->regular_price;
							$discount					= $deal->discount;
							$discounted_price = ( $regular_price * (100 - $discount)) / 100;
							?>
            	<h2 style="white-space:nowrap; overflow: hidden; width: 95%;"><?php echo  $title_url; ?></h2>
              <div style="margin-top: 10px;">
                <div class="image" style="float: right; background: url(images/default_thumb.jpg) top left no-repeat;">
                	<?php
                  $img = $deal->get_random_image($deal->ID, 'thumb');
									echo Html::image($img, array('title' => $deal_contents)); ?>
                  
                </div>
                <div style="float :left">
                  <div class="sold"><?php echo count($orders->get_orders($deal->ID)); ?> <?= LBL_SOLD?></div>
                  <div class="widget-label"><?= LBL_PRICE?> <span><?= $discounted_price; ?></span></div>
                  <div class="widget-label"><?= LBL_VALUE?> <span><?= $deal->regular_price; ?></span></div>
                  <div class="widget-label"><?= LBL_SAVINGS ?><span><?= $deal->discount; ?> %</span></div>
                  <div class="price"></div>                
                </div>
              </div>
            </div>
          <?php } ?>
                    
        </div>
        
        <div class="sidebar">
          <p></p>
        	<center>
        	  <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/#!/pages/TilbudiByendk/141668405900565" width="214" show_faces="true" stream="false" header="true"></fb:like-box>
        	  </center>
        </div>
      </div>    	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>