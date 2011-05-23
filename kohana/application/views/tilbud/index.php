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
            <h1><a href=""><?php echo $deal['title'] ?></a></h1>
            <p><?php echo substr(html_entity_decode(strip_tags($deal['description'])), 0, 200); ?></p>
          </div>

          <div class="deal-banner" style="position: static" >

              <div id="slider">
                <?php if (sizeof($images) == 1) {?>
                  <img src="<?php echo URL::base(TRUE); ?>uploads/<?php echo $deal->ID . "/". rawurlencode("$images[0]"); ?>">
                <?php }else{?>
                  <ul id="sliderContent"> 
                    <?php foreach($images as $img) {?>
                      <li class="sliderImage"> 
                          <img src="<?php echo URL::base(TRUE); ?>uploads/<?php echo $deal['ID'] . "/". rawurlencode("$img"); ?>">
                          <span class="top"></span> 
                      </li>
                    <?php } ?>
                      <div class="clear sliderImage"></div> 
                  </ul>                   
                <?php }?>
              </div>
              
              <div class="buy-container" style="z-index: 99; position: relative">
              	  <?php 

              	  $price = (float) ($deal['regular_price'] * (100 - $deal['discount'])) / 100 ;
              	  $pricex = explode(".", $price);

                  if (sizeof($pricex) > 1) {
                    if ($pricex[1] >= 50) {
                	    $newprice = $pricex[0] + 1;
                	  }else if ($pricex[1] > 0 && $pricex[1] < 50) {
                	    $newprice = $pricex[0] + 0.50;
                	  }
                  }else{
                    $newprice = $price;
                  }
                  
              	  
              	  ?>
              	  <p class="huge buy-label" style="width: 935px;"><?php echo $newprice . ',-' . HTML::anchor('deals/buy/' . $deal['ID'], HTML::image('images/buy.png', array('title' => LBL_Buy_now, 'style' => 'margin-bottom: -10px;'))); ?>
								
      								<?php 
      								if(isset($deal->youtube_url) && $deal->youtube_url != "") {
      									echo HTML::anchor($deal->youtube_url, 
      																		HTML::image('images/play.png', array('class' => 'playbutton')), 
      																		array('id' => 'youtubevideo',
      																					'title' => 'Promo Video'));
      								}
      								?>
								  </p>
      								<script type="text/javascript">
                      	$("#youtubevideo").click(function() {
                      	$.fancybox({
                      			'padding'		: 0,
                      			'autoScale'		: false,
                      			'transitionIn'	: 'none',
                      			'transitionOut'	: 'none',
                      			'title'			: this.title,
                      			'width'		: 680,
                      			'height'		: 495,
                      			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                      			'type'			: 'swf',
                      			'swf'			: {
                      			   	 'wmode'		: 'transparent',
                      				'allowfullscreen'	: 'true'
                      			}
                      		});
 
                      	return false;
                      });</script>
              </div>
							
              <div class="buy-container" style="z-index: 100; position: relative" >
              	<p class="discounts" style="text-align: left">Værdi <?php echo number_format($deal['regular_price'], 2, '.', ''); ?>,- <span style="float:right;">Rabat <?php echo number_format($deal['discount'], 0, '.', ''); ?>%</span></p>
              </div>
            
              <div style="z-index: 151; position: relative">
                <div class="buy-container" style="">
                  <?php
                  $tmp_end_date = strtotime($deal['end_date']);
                  $end_date = date("D M d Y", $tmp_end_date);
                  ?>
                	<script type="text/javascript">
  								jQuery(document).ready(function() {
  									var end = "<?php echo $end_date; ?>";
  									var enddate= new Date(end);
  									enddate_final = new Date(enddate.toDateString() + " 23:59:59");
  									$('#noDays').countdown({until: enddate_final, format: 'HMS', compact: true, description: '', timeSeparator: ' : '});
  								});
  								</script>
                	<p class="period-label"><?= LBL_OFFER_ENDS ?></p>
                  <p id="noDays" class="period"><?= LBL_PROMO_ENDED ?></p>
                </div>
                <div class="clock-img-cont"><?php echo HTML::image('images/clock.png', array('alt' => '')); ?></div>
                <div class="clear"></div>
              </div>
            
              <div style="z-index: 101; position: relative">
                <div class="offer-container" style="z-index: 87">
                	<p class="period-label"><?= LBL_OFFER_ACTIVE_WHEN ?> <?php echo $deal['min_sold']; ?> <?= LBL_BUY ?></p>
                  <p class="period"><?php echo $total_qty; ?> <?= LBL_BOUGHT ?></p>
                </div>

                <div class="social-container" style="z-index: 86">
                  <a target="_blank" href="http://www.addthis.com/bookmark.php?v=250&amp;winname=addthis&amp;pub=ra-4d6e3a782d6e35f6&amp;source=tbx-250&amp;lng=da&amp;s=facebook&amp;url=<?php echo url::base(true) . "deals/view/" . $deal['ID']?>">
                	  <?php echo HTML::image('images/facebook.jpg', array('alt' => LBL_SHARE_ON_FACEBOOK)); ?>
                	</a>
                </div>
              
                <div class="save-label"><?= LBL_SPAR ?> <?php echo number_format($deal['discount'], 0, '.', ''); ?>%</div>
                <div class="clear"></div>
              </div>
            
          </div>
          
        </li>
      </ul>
    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title"><?php echo html_entity_decode($deal['contents_title']); ?></a></h1>
          
          <p><?php echo str_replace("\n", "<br/>", html_entity_decode($deal['contents'])); ?></p>

					<div id="deals-info">
            <ul>
              <li class="dhead-one"><?= LBL_WHAT_YOU_GET?></li>
              <li><p><?php echo html_entity_decode($deal['whatyouget']); ?>   </p>
              </li>
            </ul>
            <ul>
            	<li class="dhead-two "><?= LBL_INFORMATION ?></li>
              <li><p> <?php echo html_entity_decode($deal['information']); ?></p></li>
            </ul>
        	</div>
        	
        	<div id="deals-info">
            <ul>
              <li class="dhead-one"> <?= LBL_ADDRESS?> </li>
              <li><p> 
              <?php
              $decoded_address = html_entity_decode($deal['addresses']);
              $clean_address = str_replace("\n", "<br/>", $decoded_address);
              echo $clean_address;
              ?></p> </li>
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