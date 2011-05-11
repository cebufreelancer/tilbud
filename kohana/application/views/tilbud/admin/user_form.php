<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	    	
  <div id="htitle">
    <h2><?php echo $label; ?></h2>
  </div>
       
  <?php
  $form = new Appform();

  if(isset($errors)) {
     $form->errors = $errors;
  }
  ?>
  
  <?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
  <ul>
  	<li><?php echo $form->label('group', __(LBL_GROUPS)); ?>
        <?php echo $form->select('group', $groups, $group); ?>
    </li>
    <li><?php echo $form->label('firstname', __('Firstname')); ?>
        <?php echo Form::input('firstname', NULL, array('style' => 'width: 215px;',
                                                          'required' => true)); ?> Lastname 
        <?php echo Form::input('lastname', NULL, array('style' => 'width: 210px;',
                                                                  'required' => true)); ?>
        <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
    </li>
    <li><?php echo $form->label('email', __('Email Address')); ?>
        <?php echo $form->input('email', $email,array('placeholder' => 'youremail@website.com',
                                                           'required' => true,
                                                           'type' => 'email',
                                                           'style' => 'width: 500px;')); ?>
    </li>
    <li><?php echo $form->label('password', __('Password')); ?>
        <?php echo Form::password('password', NULL, array('style' => 'width: 215px;',
                                                          'required' => true)); ?> (confirm) 
        <?php echo Form::password('password_confirm', NULL, array('style' => 'width: 215px;',
                                                                  'required' => true)); ?>
        <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
    </li>
    <li><?php echo $form->label('mobile', __('Mobile')); ?>
        <?php echo Form::input('mobile', NULL, array('style' => 'width: 215px;',
                                                        'required' => true,
                                                        'type' => 'tel')); ?>
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