<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
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
      	<li><?php echo Form::label('product_vendor', __('Vendor')); ?>
        		<?php echo Form::select('product_vendor', $vendors, $prod_vid); ?>
        </li>
      	<li><?php echo Form::label('product_name', __('Product Name')); ?>
						<?php echo Form::input('product_name', $prod_title); ?>
        </li>
        <li><?php echo Form::label('product_desc', __('Description')); ?>
        		<?php echo Form::textarea('product_desc', $prod_desc); ?>
        </li>
        <li><?php echo Form::label('product_price', __('Price')); ?>
        		<?php echo Form::input('product_price', $prod_price, array('style' => 'width: 100px;')); ?>
        </li>
        <!--
        <li><?php echo Form::label('product_image', __('Upload Image')); ?>
        		<?php echo Form::file('product_image'); ?>
        </li>
        -->
        <li>
        	<?php echo Form::submit(NULL, 'Save'); ?>
          <?php echo Form::submit(NULL, 'Cancel'); ?>
        </li>
      </ul>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>