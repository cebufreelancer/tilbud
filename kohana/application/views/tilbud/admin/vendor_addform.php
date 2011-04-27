<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
      
			<?php echo Form::open(Request::current(), array('enctype' => 'multipart/form-data',
																											'id'			=> 'myforms')); ?>
      <ul>
      	<li><?php echo Form::label('vendor_name', __('Vendor Name')); ?>
						<?php echo Form::input('vendor_name', ''); ?>
        </li>
        <li><?php echo Form::label('vendor_desc', __('Description')); ?>
        		<?php echo Form::textarea('vendor_desc', '') ?>
        </li>
        <li><?php echo Form::label('vendor_address', __('Address')); ?>
        		<?php echo Form::input('vendor_address', '');?>
        </li>
        <li><?php echo Form::label('vendor_phone', __('Phone')); ?>
        		<?php echo Form::input('vendor_phone', ''); ?>
        </li>
        <li><?php echo Form::label('vendor_url', __('URL')); ?>
        		<?php echo Form::input('vendor_url'); ?>
        </li>
        <li><?php echo Form::label('vendor_email', __('Email')); ?>
        		<?php echo Form::input('vendor_email'); ?>
        </li>
        <li><?php echo Form::label('vendor_office_hours', __('Office hours')); ?>
        		<?php echo Form::input('vendor_office_hours'); ?>
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