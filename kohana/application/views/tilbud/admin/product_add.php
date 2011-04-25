<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <?php
			$username = '';
			$about = '';
			?>
      <div id="htitle">
      	<h2>Add a Product</h2>
      </div>
      
      <?php
     // output messages
     if(Message::count() > 0) {
       echo '<div class="block">';
       echo '<div class="content" style="padding: 10px 15px;">';
       echo Message::output();
       echo '</div></div>';
     }
		 ?>
      
			<?php echo Form::open('admin/products/add', array('enctype' => 'multipart/form-data',
																				'id'			=> 'myforms')); ?>
      <ul>
      	<li><?php echo Form::label('product_name', __('Product Name')); ?>
						<?php echo Form::input('product_name', $username); ?>
        </li>
        <li><?php echo Form::label('product_desc', __('Description')); ?>
        		<?php echo Form::textarea('product_desc', $about); ?>
        </li>
        <li><?php echo Form::label('product_vendor', __('Vendor')); ?>
        		<?php echo Form::select('product_vendor', $vendors, NULL); ?>
        </li>
        <li><?php echo Form::label('product_price', __('Price')); ?>
        		<?php echo Form::input('product_price', $username); ?>
        </li>
        <li><?php echo Form::label('product_image', __('Upload Image')); ?>
        		<?php echo Form::file('product_image'); ?>
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
  <?php require_once 'footer.php'; ?>
  
</body>
</html>