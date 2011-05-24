<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
			$status = array('draft' => __(LBL_DRAFT),
											'cancelled' => __(LBL_CANCELLED),
											'active' => __(LBL_ACTIVE),
											'expired' => __(LBL_EXPIRED));
			?>
      
			<?php echo Form::open(Request::current(), array('enctype' => 'multipart/form-data',
																											'id'			=> 'myforms',
																						 					'style' => 'display: table;')); ?>
      <div id="deals-content-form">
        <ul>
          <li><?php echo Form::label('deal_city', __(LBL_CITY)); ?>
              <?php echo Form::select('deal_city', $cities, $deal_city); ?>
          </li>
          <li><?php echo Form::label('deal_group', __(LBL_GROUP)); ?>
              <?php echo Form::select('deal_group', $categories, $group); ?>
          </li>
  
          <li><?php echo Form::label('deal_title', __(LBL_TITLE)); ?>
              <?php echo Form::textarea('deal_title', $deal_title, array('autofocus' => 1,
																																				 'class' => 'mceNoEditor',
																																				 'rows' => 3,
																																				 'style' => 'font-weight: bold; 
																																				 						 font-size: 20px; 
																																										 padding-top: 10px;
																																										 color: #666;')); ?>
          </li>
          <li>
							<?php echo Form::label('deal_desc', __(LBL_TITLE_DESC)); ?>
              <?php echo Form::textarea('deal_desc', $deal_desc, array('rows' => 5)); ?>
          </li>
          <li><?php echo Form::label('deal_content_title', __(LBL_CONTENT_TITLE)); ?>
              <?php echo Form::textarea('deal_content_title', $deal_content_title, array('class' => 'mceNoEditor',
																																												 'rows' => 3,
																																												 'style' => 'font-weight: bold; 
																																				 						 								 font-size: 20px; 
																																										 								 padding-top: 10px;
																																										 								 color: #666;')); ?>
          </li>
          <li><?php echo Form::label('deal_desc_long', __(LBL_CONTENT_DESC)); ?>
              <?php echo Form::textarea('deal_desc_long', $deal_desc_long, array('class' => 'mceEditor')); ?>
          </li>
          <li><?php echo Form::label('deal_whatyouget', __(LBL_WHAT_YOU_GET)); ?>
              <?php echo Form::textarea('deal_whatyouget', $deal_whatyouget, array('class' => 'mceEditor', 'rows' => 5)); ?>
          </li>
          <li><?php echo Form::label('deal_information', __(LBL_INFORMATION)); ?>
              <?php echo Form::textarea('deal_information', $deal_information, array('class' => 'mceEditor', 'rows' => 5)); ?>
          </li>
          <li><?php echo Form::label('deal_video_url', __(LBL_YOUTUBE_VIDEO_URL)); ?>
              <?php echo Form::input('deal_video_url', $deal_video_url, array()); ?>
              <div style="font-size: 11px; line-height: 15px">
              Append &autoplay=1 to autoplay the video <br/>
              e.g. : http://www.youtube.com/watch?v=g9f-6jygRJk<strong>&autoplay=1</strong>
              </div>
          </li>
          <li><?php echo Form::label('deal_address', __(LBL_ADDRESS2)); ?>
              <?php echo Form::input('deal_address', $address, array()); ?>
          </li>
          <li><?php echo Form::label('deal_image', __(LBL_UPLOAD_IMAGE)); ?>
              
              <?php echo Form::file('deal_image', array("style" => "width: 200px")); ?>
              <?php if ($deal_image != ""){?>
                <a href="/uploads/<?= $deal_id;?>/<?= $deal_image;?>" target="_blank" class="homelink">View  </a>|
                <a href="/admin/deals/deleteimage/<?= $deal_id;?>?i=1" class="homelink" onclick="return confirm('Are you sure?')">Remove  </a>
              <?php } ?>

              <?php echo Form::file('deal_image2', array("style" => "width: 200px")); ?>
              <?php if ($deal_image2 != ""){?>
                <a href="/uploads/<?= $deal_id;?>/<?= $deal_image2;?>" target="_blank" class="homelink">View  </a>|
                <a href="/admin/deals/deleteimage/<?= $deal_id;?>?i=2" class="homelink" onclick="return confirm('Are you sure?')">Remove  </a>
              <?php }?>

              <?php echo Form::file('deal_image3', array("style" => "width: 200px"));?>
              <?php if ($deal_image3 != ""){?>
                <a href="/uploads/<?= $deal_id;?>/<?= $deal_image3;?>" target="_blank" class="homelink">View  </a>|
                <a href="/admin/deals/deleteimage/<?= $deal_id;?>?i=3" class="homelink" onclick="return confirm('Are you sure?')">Remove  </a>
              <?php } ?>

              <?php echo Form::file('deal_image4', array("style" => "width: 200px")); ?>
              <?php if ($deal_image4 != ""){?>
                <a href="/uploads/<?= $deal_id;?>/<?= $deal_image4;?>" target="_blank" class="homelink">View  </a>|
                <a href="/admin/deals/deleteimage/<?= $deal_id;?>?i=4" class="homelink" onclick="return confirm('Are you sure?')">Remove </a>
              <?php }?>

              <?php echo Form::file('deal_image5', array("style" => "width: 200px")); ?>
              <?php if ($deal_image5 != ""){?>
                <a href="/uploads/<?= $deal_id;?>/<?= $deal_image5;?>" target="_blank" class="homelink">View  </a>|
                <a href="/admin/deals/deleteimage/<?= $deal_id;?>?i=5" class="homelink" onclick="return confirm('Are you sure?')">Remove  </a>
              <?php }?>
          </li>
          <li><?php echo Form::label('deal_facebook_image', __(LBL_UPLOAD_FACEBOOK_IMAGE)); ?>
              <?php echo Form::file('deal_facebook_image'); ?>
          </li>
          <?php if(isset($deal_id)) { ?>
          <li>
              <img src="/uploads/<?= $deal_id; ?>/<?= $deal_facebook_image?>" width="200" height="70">
          </li>
          <?php } ?>
          <li></li>
        </ul>
			</div>
      
      <div id="deals-detail-form">
      	<div id="deals-detail-form-inner">
        <script>
				$(function() {
					$( "#deal_start_date" ).datepicker({ 
								showAnim: 'drop', 
								dateFormat: 'yy/mm/dd',
								showOn: "both",
								buttonImage: "<?php echo Url::base(TRUE); ?>images/calendar.png",
								buttonImageOnly: true});
					$( "#deal_end_date" ).datepicker({ 
								showAnim: 'drop', 
								dateFormat: 'yy/mm/dd',
								showOn: "both",
								buttonImage: "<?php echo Url::base(TRUE); ?>images/calendar.png",
								buttonImageOnly: true});
					$( "#deal_expiry_date" ).datepicker({ 
								showAnim: 'drop', 
								dateFormat: 'yy/mm/dd',
								showOn: "both",
								buttonImage: "<?php echo Url::base(TRUE); ?>images/calendar.png",
								buttonImageOnly: true});
				});
				</script>
        <ul>
        	<li><?php echo Form::label('deal_start_date', __(LBL_DEAL_START_DATE)); ?>
              <?php echo Form::input('deal_start_date', $start_date, array('id' => 'deal_start_date',
																																					'style' => 'width: 150px;')); ?>
          </li>
          <li class="separator">
							<?php echo Form::label('deal_end_date', __(LBL_DEAL_END_DATE)); ?>
              <?php echo Form::input('deal_end_date', $end_date, array('id' => 'deal_end_date',
																																			 'style' => 'width: 150px;')); ?>
          </li>
          <li>
            <div class="half left">
              <?php echo Form::label('deal_regular_price', __(LBL_REGULAR_PRICE)); ?>
              <?php echo Form::input('deal_regular_price', $deal_regular_price, array('style' => 'width: 100px;',
                                                                                      'placeholder' => '0.00')); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_discount', __(LBL_DISCOUNT)); ?>
              <?php echo Form::input('deal_discount', $deal_discount, array('style' => 'width: 100px;',
                                                                            'placeholder' => '50')); ?>
              <span style="font-size: 20px;"> % </span>
            </div>
            <div class="clear"></div>
          </li>
          <li class="separator">
            <div class="half left">
              <?php echo Form::label('deal_min_buy', __(LBL_MINIMUM_BUY)); ?>
              <?php echo Form::input('deal_min_buy', $deal_min_buy, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_min_buy', __(LBL_MAXIMUM_BUY)); ?>
              <?php echo Form::input('deal_max_buy', $deal_max_buy, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="clear"></div>
          </li>
          <li class="separator">
            <div class="half left">
              <?php echo Form::label('deal_min_sold', __(LBL_MINIMUM_SOLD)); ?>
              <?php echo Form::input('deal_min_sold', $deal_min_sold, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_max_sold', __(LBL_MAXIMUM_SOLD)); ?>
              <?php echo Form::input('deal_max_sold', $deal_max_sold, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="clear"></div>
          </li>
          <li><?php echo Form::label('deal_refno', __(LBL_REFERENCE_NO_PREFIX)); ?>
              <?php echo Form::input('deal_refno', $deal_refno, array('style' => 'width: 100px; text-align: center;',
																																			'maxlength' => 4)) . ' ' . __(LBL_REFERENCE_NO_PREFIX_DESC); ?>
          </li>
          <li class="separator">
							<?php echo Form::label('deal_expiry_date', __(LBL_DEAL_EXPIRY_DATE)); ?>
              <?php echo Form::input('deal_expiry_date', $expiry_date, array('id' => 'deal_expiry_date',
																																						'style' => 'width: 150px;')); ?>
          </li>
          <li>
							<?php echo Form::label('deal_regno', __(LBL_DEALS_REGNO)); ?>
              <?php echo Form::input('deal_regno', $regno, array('style' => 'width: 95%')); ?>
          </li>
          <li class="separator">
							<?php echo Form::label('deal_itemno', __(LBL_DEALS_KONTO)); ?>
              <?php echo Form::input('deal_itemno', $itemno, array('style' => 'width: 95%')); ?>
          </li>
          <?php /*
          <li><?php echo Form::label('deal_vouchers', __(LBL_NUMBER_OF_VOUCHERS)); ?>
              <?php echo Form::input('deal_vouchers', $deal_vouchers, array('style' => 'width: 100px;',
                                                                            'placeholder' => '100')); ?>
          </li> 
					*/ ?>
          <li><?php echo Form::label('deal_status', __(LBL_STATUS)); ?>
              <?php echo Form::select('deal_status', $status, $deal_status); ?>
          </li>
          <?php /*
          <li><?php echo Form::label('deal_status', __(LBL_CATEGORY)); ?>
          		<?php
							$deal_categories = isset($deal_categories) ? $deal_categories : array();
							foreach($categories as $k => $cat) {
								$is_checked = in_array($k, $deal_categories) ? TRUE : NULL;
								echo '<div class="deals-category-container">';
								echo Form::label("category_$k", $cat);
								echo Form::checkbox("category[]", $k, $is_checked ,array('id' => "category_$k"));
								echo '<div class="clear"></div>';
								echo '</div>';
 							}
							?>              
          </li>
					*/ ?>
          <?php
					/*
					Not needed anymore
          <li><?php echo Form::label('deal_isfeatured', __('Featured')); ?>
              <?php echo Form::radio('deal_isfeatured', '1', true); ?>
              Yes
              <?php echo Form::radio('deal_isfeatured', '0', false); ?>
              No        		
          </li>
					*/ ?>
          <li>
            <?php echo Form::submit(NULL, __(LBL_SAVE)); ?>
            <?php echo HTML::anchor('admin/deals', LBL_CANCEL, array('class' => 'cancel',
																																		 'style' => 'font-size: 11px;')) ?>
          </li>	
        </ul>
        </div>
      </div>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>
