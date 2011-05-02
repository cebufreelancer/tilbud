<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
			$status = array('draft' => 'Draft',
											'cancelled' => 'Cancelled',
											'active' => 'Active',
											'expired' => 'Expired');
			?>
      
			<?php echo Form::open(Request::current(), array('enctype' => 'multipart/form-data',
																											'id'			=> 'myforms',
																						 					'style' => 'display: table;')); ?>
      <div id="deals-content-form">
        <ul>
          <li><?php echo Form::label('deal_city', __('City')); ?>
              <?php echo Form::select('deal_city', $cities); ?>
          </li>
          <li><?php echo Form::label('deal_product', __('Product')); ?>
              <?php echo Form::select('deal_product', $products); ?>
          </li>
  
          <li><?php echo Form::label('deal_title', __('Title')); ?>
              <?php echo Form::input('deal_title', $deal_title, array('autofocus' => 1,
																																			'style' => 'width: 570px;')); ?>
          </li>
          <li><?php echo Form::label('deal_desc', __('Title Description')); ?>
              <?php echo Form::textarea('deal_desc', $deal_desc, array('rows' => 5,
																																			 'style' => 'width: 570px;')); ?>
          </li>
          <li><?php echo Form::label('deal_content_title', __('Content Title')); ?>
              <?php echo Form::input('deal_content_title', $deal_content_title, array('autofocus' => 1,
																																			'style' => 'width: 570px;')); ?>
          </li>
          <li><?php echo Form::label('deal_desc_long', __('Content Description')); ?>
              <?php echo Form::textarea('deal_desc_long', $deal_desc_long); ?>
          </li>
          <li><?php echo Form::label('deal_whatyouget', __('What you get')); ?>
              <?php echo Form::textarea('deal_whatyouget', $deal_whatyouget, array('rows' => 5)); ?>
          </li>
          <li><?php echo Form::label('deal_information', __('Information')); ?>
              <?php echo Form::textarea('deal_information', $deal_information, array('rows' => 5)); ?>
          </li>
          <li><?php echo Form::label('deal_image', __('Upload image')); ?>
              <?php echo Form::file('deal_image'); ?>
          </li>
        </ul>
			</div>
      
      <div id="deals-detail-form">
      	<div id="deals-detail-form-inner">
        <script>
				$(function() {
					$( "#deal_start_date" ).datepicker({ showAnim: 'drop', dateFormat: 'yy/mm/dd' });
					$( "#deal_end_date" ).datepicker({ showAnim: 'drop', dateFormat: 'yy/mm/dd' });
				});
				</script>
        <ul>
        	<li><?php echo Form::label('deal_start_date', __('Deal Start Date')); ?>
              <?php echo Form::input('deal_start_date', $start_date, array('id' => 'deal_start_date',
																																					'style' => 'width: 150px;')); ?>
          </li>
          <li><?php echo Form::label('deal_end_date', __('Deal End Date')); ?>
              <?php echo Form::input('deal_end_date', $end_date, array('id' => 'deal_end_date',
																																					'style' => 'width: 150px;')); ?>
          </li>
          <li>
            <div class="half left">
              <?php echo Form::label('deal_regular_price', __('Regular Price')); ?>
              <?php echo Form::input('deal_regular_price', $deal_regular_price, array('style' => 'width: 100px;',
                                                                                      'placeholder' => '0.00')); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_discount', __('Discount')); ?>
              <?php echo Form::input('deal_discount', $deal_discount, array('style' => 'width: 100px;',
                                                                            'placeholder' => '0')); ?>
              <span style="font-size: 20px;"> % </span>
            </div>
            <div class="clear"></div>
          </li>
          <li>
            <div class="half left">
              <?php echo Form::label('deal_min_buy', __('Minimum buy')); ?>
              <?php echo Form::input('deal_min_buy', $deal_min_buy, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="half left">
              <?php echo Form::label('deal_min_buy', __('Maximum buy')); ?>
              <?php echo Form::input('deal_max_buy', $deal_max_buy, array('style' => 'width: 100px;',
                                                                          'placeholder' => '1')); ?>
            </div>
            <div class="clear"></div>
          </li>
          <li><?php echo Form::label('deal_vouchers', __('Number of Vouchers')); ?>
              <?php echo Form::input('deal_vouchers', $deal_vouchers, array('style' => 'width: 100px;',
                                                                            'placeholder' => '1')); ?>
          </li> 
          <li><?php echo Form::label('deal_status', __('Status')); ?>
              <?php echo Form::select('deal_status', $status); ?>
          </li>
          <li><?php echo Form::label('deal_isfeatured', __('Featured')); ?>
              <?php echo Form::radio('deal_isfeatured', '1', true); ?>
              Yes
              <?php echo Form::radio('deal_isfeatured', '0', false); ?>
              No        		
          </li>
          <li>
            <?php echo Form::submit(NULL, 'Save'); ?>
            <?php echo Form::submit(NULL, 'Cancel'); ?>
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