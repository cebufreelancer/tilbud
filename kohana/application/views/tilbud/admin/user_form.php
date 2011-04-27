<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
			$form = new Appform();

			if(isset($errors)) {
				 $form->errors = $errors;
			}
			?>
      
			<?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
      <ul>
      	<li><?php echo $form->label('username', __('Username')); ?>
						<?php echo $form->input('username', $username, array('info' => __('Length between 4-32 characters. Letters, numbers, dot and underscore are allowed characters.'))); ?>
        </li>
        <li><?php echo $form->label('email', __('Email Address')); ?>
        		<?php echo $form->input('email', $email); ?>
        </li>
        <li><?php echo $form->label('password', __('Password')); ?>
        		<?php echo $form->password('password', null, array('info' => __('Password should be between 6-42 characters.'))); ?>
        </li>
        <li><?php echo $form->label('password_confirm', __('Re-type Password')); ?>
        		<?php echo $form->password('password_confirm'); ?>
        </li>
        <li><?php echo $form->label('user_type', __('User Type')); ?>
        		<?php echo $form->select('user_type', $user_types, $user_type); ?>
        </li>
        <li>
        	<?php echo $form->submit(NULL, __('Save')); ?>
          <?php echo $form->submit(NULL, 'Cancel'); ?>
        </li>
      </ul>
      <?php echo $form->close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>