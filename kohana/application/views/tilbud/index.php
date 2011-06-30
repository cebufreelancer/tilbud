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



							<?php $xml = Url::base() . 'uploads/' . $deal['ID'] . '/' . $deal['ID'] . '.xml'; ?>

              <div id="banner" style="margin-bottom: -317px;">
              	<script type="text/javascript" src="<?php echo Url::base();?>js/imagerotator/swfobject.js"></script>
								<script type="text/javascript">
                  var s1 = new SWFObject("<?php echo Url::base(); ?>js/imagerotator/imagerotator.swf","rotator","950","310","7");
                  s1.addParam("allowfullscreen","false");
									s1.addParam("wmode","transparent");
                  s1.addVariable("shownavigation", "false");
                  s1.addVariable("transition", "bubbles");
                  s1.addVariable("file","<?php echo $xml; ?>");
                  s1.addVariable("width","950");
                  s1.addVariable("height","310");
                  s1.write("banner");
                </script>
              </div>
              
              <div class="buy-container" style="z-index: 99; position: relative;">
              	  <?php 

              	  $price = (float)($deal['regular_price'] * (100 - $deal['discount'])) / 100 ;
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
                  $burl = $is_logged ? 'kob' : 'buy';
									$burl_class = $is_logged ? 'ipages' : '';
              	  ?>
              	  <div class="buy-label">
              	    <p class="huge buy-label" style="width: 200px; min-width: 200px; float: left;">
              	    <?php echo number_format($deal['price_for_email'],0,'.',',' ); ?>,-
              	    </p>

                      <?php if(strtotime($deal['end_date']) > strtotime(date("Y-m-d H:i:s")) ) {?>
                        <?php echo HTML::anchor('#buy-dialog', HTML::image('images/buy.png', array('title' => LBL_Buy_now, 'style' => 'margin-bottom: -10px;')), array('id' => "buy-button")); ?>
                      <?php } ?>

								
      								<?php 
      								if(isset($deal['youtube_url']) && $deal['youtube_url'] != "") {
      									echo HTML::anchor($deal['youtube_url'], 
      																		HTML::image('images/play.png', array('class' => 'playbutton')), 
      																		array('id' => 'youtubevideo'));
												
												echo '<div style="width: 180px; float: right; margin-right: -280px; margin-top: 20px;">' . HTML::image('images/video-text.png') . '</div>';
      								}
      								?>
                  	<div class="clear"></div>
								  </div>
								  <?php require_once('buy-dialog.php'); ?>

		                 <script type="text/javascript">
                      	$("#youtubevideo").click(function() {
                      	$.fancybox({
                      			'padding'		: 0,
                      			'autoScale'		: false,
                      			'transitionIn'	: 'none',
                      			'transitionOut'	: 'none',
                      			'title'			: this.title,
                      			'width'		: 700,
                      			'height'		: 495,
                      			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                      			'type'			: 'swf',
                      			'swf'				: {
                      					'wmode'		: 'transparent',
                      					'allowfullscreen'	: 'true'
                      			}
                      		});
 
                      	return false;
                      });</script>
              </div>
							
              <div class="buy-container" style="z-index: 100; position: relative" >
              	<p class="discounts" style="text-align: left">Værdi <?php echo number_format($deal['regular_price'], 2, '.', ''); ?>,- <span style="float:right;">Rabat <?php echo number_format($deal['discount'],0, '.', ''); ?>%</span></p>
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
            
              <div style="z-index: 101; position: relative; margin-top: 0px">
                <div class="offer-container" style="z-index: 87; height: 82px">
                	<p class="period-label"><?= LBL_OFFER_ACTIVE_WHEN ?> <?php echo $deal['min_sold']; ?> <?= LBL_BUY ?></p>
                  <p class="period"><?php echo $total_qty; ?> <?= LBL_BOUGHT ?></p>
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
              <?php for($i=0; $i<sizeof($address); $i++) {
		if (sizeof($address[$i]) == 3) {
?>
              <li>
                <div style="padding-bottom: 1px">
                  <p style="line-height: 19px">
                  <span style="font-weight: bold; text-decoration: underline; cursor:pointer" onclick="myaddress('<?php echo $i;?>')">
<?php echo html_entity_decode($address[$i]['company_name'])?></span><br/>
                  <span><?php echo html_entity_decode($address[$i]['address'])?></span><br/>
                  <span><?php echo $address[$i]['telephone']?></span>
                  </p>
                </div>
              </li>
              <?php }} ?>
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
