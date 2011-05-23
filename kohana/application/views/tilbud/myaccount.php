<div id="htitle">
  <h2><?= LBL_My_Account ?></h2>
</div>

<div id="myforms">
	<?php
  // output messages
  if(Message::count() > 0) {
    echo '<div class="block">';
    echo '<div class="content" style="padding: 10px 15px;">';
    echo Message::output();
    echo '</div></div>';
  }
  ?>
  
  <div id="action-button">
  	<?php echo HTML::anchor('user/myaccount', LBL_My_Account, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/orders', LBL_My_Orders, array('class' => 'addbutton')); ?>
  </div>
    
  <?php
	$form = new Appform();

	if(isset($errors)) {
		 $form->errors = $errors;
	}
	$username = isset($posts['username']) ? $posts['username'] : $user->username;
	$email = isset($posts['email']) ? $posts['email'] : $user->email;
	$mobile = isset($posts['mobile']) ? $posts['mobile'] : $user->mobile;
	$firstname = isset($posts['firstname']) ? $posts['firstname'] : $user->firstname;
	$lastname = isset($posts['lastname']) ? $posts['lastname'] : $user->lastname;
	$address = isset($posts['address']) ? $posts['address'] : $user->address;
	
	?>
	
	<?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
	<ul>
  	<li><?php echo $form->label('firstname', __(LBL_EMAIL_ADDRESS . '<span class="username">' . $email . '</span>')); ?></li>
    <li>&nbsp;</li>
  	<li><?php echo $form->label('firstname', __(LBL_FIRSTNAME)); ?>
        <?php echo Form::input('firstname', ucwords($firstname), array('style' => 'width: 215px;',
                                                        'required' => true)); ?> <?php echo __(LBL_LASTNAME); ?> 
        <?php echo Form::input('lastname', ucwords($lastname), array('style' => 'width: 210px;',
                                                       'required' => true)); ?>
    </li>
    <li><?php echo $form->label('address', __(LBL_ADDRESS2)); ?>
        <?php echo $form->input('address', $address,array('style' => 'width: 500px;')); ?>
    </li>
		<?php /*
    <li><?php echo $form->label('email', LBL_EMAIL_ADDRESS); ?>
				<?php echo $form->input('email', $email); ?>
        <span style="font-size: 10px; padding-left: 380px;"><?php echo HTML::anchor('#', 'Manage email subscription', array('class' => 'homelink')); ?></span>
		</li>
		*/ ?>
    <li><?php echo $form->label('mobile', __(LBL_MOBILE)); ?>
        <?php echo Form::input('mobile', $mobile, array('style' => 'width: 215px;',
                                                     'required' => true,
                                                     'type' => 'tel')); ?>
    </li>
    <li><h2><?php echo __(LBL_CHANGE_YOU_PASS_USER); ?></h2></li>
		<li>
				<?php $pass_param = array('style' => 'width: 215px;'); ?>
				<?php echo $form->label('password', __(LBL_PASSWORD)); ?>
        <?php echo Form::password('password', NULL, $pass_param); ?> (<?php echo __(LBL_CONFIRM); ?>)
        <?php echo Form::password('password_confirm', NULL, $pass_param); ?>
        <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
    </li>
		<li>
			<?php echo $form->submit(NULL, LBL_SAVE); ?>
		</li>
	</ul>
	<?php echo $form->close(); ?>
  
</div>
