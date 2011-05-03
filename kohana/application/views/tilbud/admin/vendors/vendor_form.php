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
      	<li><?php echo Form::label('vendor_name', __('Vendor Name')); ?>
						<?php echo Form::input('vendor_name', $vendor_name, array('autofocus' => 1,
																																			'required' => true)); ?>
        </li>
        <li><?php echo Form::label('vendor_desc', __('Description')); ?>
        		<?php echo Form::textarea('vendor_desc', $vendor_desc); ?>
        </li>
        <li><?php echo Form::label('vendor_address', __('Address')); ?>
        		<?php echo Form::input('vendor_address', $vendor_address); ?>
        </li>
        <li><?php echo Form::label('vendor_phone', __('Phone')); ?>
        		<?php echo Form::input('vendor_phone', $vendor_phone, array('type' => 'tel',
																																				'placeholder' => '+639228888888')); ?>
        </li>
        <li><?php echo Form::label('vendor_website', __('Website')); ?>
        		<?php echo Form::input('vendor_website', $vendor_website, array('type' => 'url',
																																						'placeholder' => 'www.yourwebsite.com')); ?>
        </li>
        <li><?php echo Form::label('vendor_email', __('Email Address')); ?>
        		<?php echo Form::input('vendor_email', $vendor_email, array('type' => 'email',
																																				'placeholder' => 'youremail@yourwebsite.com')); ?>
        </li>
        <li><?php echo Form::label('vendor_office_hours', __('Office Hours')); ?>
        		<?php echo Form::textarea('vendor_office_hours', $vendor_office_hours); ?>
        </li>
        <li><?php echo Form::label('vendor_notes', __('Admin Notes')); ?>
        		<?php echo Form::textarea('vendor_notes', $vendor_notes); ?>
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