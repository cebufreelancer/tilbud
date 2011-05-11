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
    <li><?php echo $form->label('firstname', __(LBL_FIRSTNAME)); ?>
        <?php echo Form::input('firstname', $firstname, array('style' => 'width: 215px;',
                                                        'required' => true)); ?> <?php echo __(LBL_LASTNAME); ?> 
        <?php echo Form::input('lastname', $lastname, array('style' => 'width: 210px;',
                                                       'required' => true)); ?>
        <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
    </li>
    <li><?php echo $form->label('email', __(LBL_EMAIL_ADDRESS)); ?>
        <?php echo $form->input('email', $email,array('placeholder' => 'youremail@website.com',
																										  'required' => true,
																										  'type' => 'email',
																										  'style' => 'width: 500px;')); ?>
    </li>
    <li>
				<?php $pass_param = (isset($is_edit)) ? array('style' => 'width: 215px;') 
														: array('style' => 'width: 215px', 'required' => true); ?>
				<?php echo $form->label('password', __(LBL_PASSWORD)); ?>
        <?php echo Form::password('password', NULL, $pass_param); ?> (confirm) 
        <?php echo Form::password('password_confirm', NULL, $pass_param); ?>
        <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
    </li>
    <li><?php echo $form->label('mobile', __(LBL_MOBILE)); ?>
        <?php echo Form::input('mobile', $mobile, array('style' => 'width: 215px;',
                                                     'required' => true,
                                                     'type' => 'tel')); ?>
    </li>
    <li><?php echo $form->label('user_type', __(LBL_USER_TYPE)); ?>
        <?php echo $form->select('user_type', $user_types, $user_type); ?>
    </li>
    <li>
      <?php echo $form->submit(NULL, __(LBL_SAVE)); ?>
      <?php echo HTML::anchor($_SERVER['HTTP_REFERER'], LBL_CANCEL, array('class' => 'cancel')); ?>
    </li>
  </ul>
  <?php echo $form->close(); ?>
  
</div>
</section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>