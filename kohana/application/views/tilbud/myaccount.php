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
    <?php echo HTML::anchor('user/billing', LBL_Billing_Info, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/orders', LBL_My_Orders, array('class' => 'addbutton')); ?>
  </div>
    
  <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
	$form = new Appform();

	if(isset($errors)) {
		 $form->errors = $errors;
	}
	$username = isset($posts['username']) ? $posts['username'] : $user->username;
	$email = isset($posts['email']) ? $posts['email'] : $user->email;
	$mobile = isset($posts['mobile']) ? $posts['mobile'] : $user->mobile;
	$firstname = isset($posts['firstname']) ? $posts['firstname'] : $user->firstname;
	$lastname = isset($posts['lastname']) ? $posts['lastname'] : $user->lastname;
	
	?>
	
	<?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
	<ul>
  	<li><?php echo $form->label('firstname', __(LBL_EMAIL_ADDRESS . '<span class="username">' . $email . '</span>')); ?></li>
    <li>&nbsp;</li>
  	<li><?php echo $form->label('firstname', LBL_FIRSTNAME); ?>
				<?php echo $form->input('firstname', ucwords($firstname)); ?>
		</li>
    <li><?php echo $form->label('lastname', LBL_LASTNAME); ?>
				<?php echo $form->input('lastname', ucwords($lastname)); ?>
		</li>
		<?php /*
    <li><?php echo $form->label('email', LBL_EMAIL_ADDRESS); ?>
				<?php echo $form->input('email', $email); ?>
        <span style="font-size: 10px; padding-left: 380px;"><?php echo HTML::anchor('#', 'Manage email subscription', array('class' => 'homelink')); ?></span>
		</li>
		*/ ?>
    <li><?php echo $form->label('mobile', LBL_MOBILE); ?>
				<?php echo $form->input('mobile', ucwords($mobile)); ?>
		</li>
    <li><h2>Change Your Password</h2></li>
		<li><?php echo $form->label('password', LBL_PASSWORD); ?>
				<?php echo $form->password('password', null); ?>
		</li>
		<li><?php echo $form->label('password_confirm', LBL_RETYPE_PASSWORD); ?>
				<?php echo $form->password('password_confirm'); ?>
		</li>
		<li>
			<?php echo $form->submit(NULL, LBL_SAVE); ?>
		</li>
	</ul>
	<?php echo $form->close(); ?>
  
</div>
