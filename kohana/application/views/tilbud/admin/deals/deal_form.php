<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; ?>
      
			<?php echo Form::open(Request::current(), array('enctype' => 'multipart/form-data',
																											'id'			=> 'myforms')); ?>
      <ul>
        <li><?php echo Form::label('deal_city', __('City')); ?>
        		<?php echo Form::select('deal_city', $cities); ?>
        </li>
        <li><?php echo Form::label('deal_product', __('Product')); ?>
        		<?php echo Form::select('deal_product', $products); ?>
        </li>

      	<li><?php echo Form::label('deal_title', __('Title')); ?>
						<?php echo Form::input('deal_title', $deal_title); ?>
        </li>
        <li><?php echo Form::label('deal_desc', __('Description')); ?>
        		<?php echo Form::textarea('deal_desc', $deal_desc); ?>
        </li>
        <li><?php echo Form::label('deal_regular_price', __('Regular Price')); ?>
        		<?php echo Form::input('deal_regular_price', $deal_regular_price); ?>
        </li>
        <li><?php echo Form::label('deal_discount', __('Discount')); ?>
        		<?php echo Form::input('deal_discount', $deal_discount); ?>
        		e.g.: 30
        </li>
        <li><?php echo Form::label('deal_min_buy', __('Minimum buy')); ?>
        		<?php echo Form::input('deal_min_buy', $deal_min_buy); ?>
        </li>
        <li><?php echo Form::label('deal_min_buy', __('Maximum buy')); ?>
        		<?php echo Form::input('deal_max_buy', $deal_max_buy); ?>
        </li>

        <li><?php echo Form::label('deal_vouchers', __('Number of Vouchers')); ?>
        		<?php echo Form::input('deal_vouchers', $deal_vouchers); ?>
        </li>
        <li><?php echo Form::label('deal_image', __('Upload image')); ?>
        		<?php echo Form::file('deal_image'); ?>
        </li>

        <li><?php echo Form::label('deal_status', __('Status')); ?>
        		<?php echo Form::input('deal_status', 'draft'); ?>
        		        		draft, active, cancelled
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
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>