<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
    	
      <!-- DEALS SECTION -->    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title">TIDLIGERE TILBUD</a></h1>


          <?php foreach($deals as $deal){ ?>
            <div class="deals-widget">
            	<?php
							$title = strlen($deal['title']) > 65 ? substr($deal['title'],0,65) . ' ...' : $deal['title'];
							$title_url = HTML::anchor('deals/view/' . $deal['ID'], $title, array('title' => $deal['title'],
																																									 'class' => 'widget-title'));
							$regular_price    = $deal['regular_price'];
							$discount					= $deal['discount'];
							$discounted_price = ( $regular_price * (100 - $discount)) / 100;
							?>
            	<h2><?php echo  $title_url; ?></h2>
              <div style="margin-top: 10px;">
                <div class="image" style="float: right">
                  <img src="<?= url::base(true);?>uploads/<?= $deal['ID'];?>/<?= $deal['image'];?>" width="165" height="105">
                </div>
                <div style="float :left">
                  <div class="sold">458 Sold</div>
                  <div class="widget-label">Price <span><?= $discounted_price; ?></span></div>
                  <div class="widget-label">Value <span><?= $deal['regular_price']?></span></div>
                  <div class="widget-label">Savings <span><?= $deal['discount']?> %</span></div>
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