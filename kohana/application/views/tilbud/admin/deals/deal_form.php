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
          <li id="address-container">
							<?php echo Form::label('deal_address', __(LBL_ADDRESS2));
              
							$remove = ' <span id="remove-image" class="cancel" onclick="javascript: removeMe(this);"> Remove </span>';
							$html = '<div>' . Form::input('deal_address[]', '', array('style' => 'width: 500px;')) . $remove . '</div>';
							?>
              <script type="text/javascript">
							$(function() {
								var fileHtml = '<?php echo $html; ?>';
							 	$("#addAddress").click(function(ez){
									ez.preventDefault();
									var dealsImage = document.getElementsByName("deal_address[]").length;
									if(dealsImage<5) {
										$("#address-container").append(fileHtml);
									} else {
										return false;
									}
							 	});
								
								
								
							});
							
							function removeMe(elem) {
								$(elem).parent().fadeOut("fast", function(ez) {
									$(elem).parent().remove();
								});
							}
							
							</script>
              <?php
							if(!empty($address)) {
								foreach($address as $add) {
             			echo '<div>' . Form::input('deal_address[]', html_entity_decode($add), array('style' => 'width: 500px;')) . $remove . '</div>';
								}
							} else {
								echo '<div>' . Form::input('deal_address[]', '', array('style' => 'width: 500px;')) . $remove . '</div>';
							}
							?>
          </li>
          <li><a id="addAddress" href="" class="blue"><b>Add More Address</b></a><br /></li>
          <li id="image-container">
						<?php echo Form::label('deal_image', __(LBL_UPLOAD_IMAGE)); ?>
            <span style="font-size: 10px">Size: 952px x 312px</span><br />
            <?php
            $remove = ' <a href="" id="remove-image" class="cancel" onclick="javascript: removeThis(this);"> Remove </a>';
            $html   = '<div>' . Form::file('deal_image[]', array("style" => "width: 500px")) . $remove . '</div>';
            $img_count = isset($images_count) ? $images_count : 0;
            ?>
            <script type="text/javascript">
            $(function() {
              var fileHtml = '<?php echo $html; ?>';
              $("#addImage").click(function(ez){
                ez.preventDefault();
                var dealsImage = document.getElementsByName("deal_image[]").length;
                var existingImage = document.getElementsByName("imgs[]").length;
                if((dealsImage+existingImage)<5) {
                  $("#image-container").append(fileHtml);
                } else {
                  return false;
                }
              });
            });
            
            function removeThis(id) {
							$("#rimg_" + id).parent().fadeOut("fast", function(ez) {
              	$("#rimg_" + id).parent().remove();
              });
							$("#rimg_" + id).click(function (z){ z.preventDefault(); });
            }
            </script>
          </li>
          <li><a id="addImage" href="" class="blue"><b>Add Image</b></a><br /></li>
          <?php if($img_count > 0) { ?>
          <li>
         		<?php
						echo Form::hidden('rimgs', '', array('id' => 'rimgs'));
						foreach($images as $img) {
							$tmp = explode(".", $img->path);
							$thumb = $tmp[0] . "_thumb.{$tmp[1]}";
							echo '<div>';
								echo Html::image($thumb);
								echo Form::hidden('imgs[]', $img->ID);
								echo Html::anchor("#rimgs", ' Remove', array('class' 	=> "cancel",
																														 'id'    	=> "rimg_{$img->ID}",
																														 'onclick' => "return removeThis({$img->ID});"));
							echo '</div>';
						} ?>
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
              <?php echo Form::input('deal_regno', $regno, array('style' => 'width: 100px; text-align: center;',
																																 'maxlength' => 4,
																																 'pattern' => "[0-9]{0,4}")); ?>
							<div style="font-size: 11px; line-height: 15px">
              e.g. : <strong>8273</strong>
              </div>
          </li>
          <li class="separator">
							<?php echo Form::label('deal_itemno', __(LBL_DEALS_KONTO)); ?>
              <?php echo Form::input('deal_itemno', $itemno, array('style' => 'width: 95%; text-align: center;',
																																	 'maxlength' => 10,
																																	 'pattern' => "[0-9]{0,10}")); ?>
							<div style="font-size: 11px; line-height: 15px">
              e.g. : <strong>123456789012</strong>
              </div>
          </li>
          <li>
          	<div class="half left">
              <?php echo Form::label('deal_status', __(LBL_STATUS)); ?>
              <?php echo Form::select('deal_status', $status, $deal_status); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_send', __(LBL_SEND_EMAIL)); ?>
              <?php echo Form::checkbox('deal_send', true); ?>
            </div>
            <div class="clear"></div>
          </li>
          <li>
            <?php echo Form::submit('submit', __(LBL_SAVE), array('id' => 'submit')); ?>
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
