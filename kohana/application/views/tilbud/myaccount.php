<div id="htitle">
  <h2>My Account</h2>
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
  	<?php echo HTML::anchor('user/myaccount', 'My Account', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/billing', 'Billing Info', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('#', 'My Orders', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('#', 'My Deals', array('class' => 'addbutton')); ?>
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
  	<li><?php echo $form->label('firstname', __('Username: <span class="username">' . $username . '</span>')); ?></li>
    <li>&nbsp;</li>
  	<li><?php echo $form->label('firstname', __('Firstname')); ?>
				<?php echo $form->input('firstname', ucwords($firstname)); ?>
		</li>
    <li><?php echo $form->label('lastname', __('Lastname')); ?>
				<?php echo $form->input('lastname', ucwords($lastname)); ?>
		</li>
		<li><?php echo $form->label('email', __('Email Address')); ?>
				<?php echo $form->input('email', $email); ?>
        <span style="font-size: 10px; padding-left: 380px;"><?php echo HTML::anchor('#', 'Manage email subscription', array('class' => 'homelink')); ?></span>
		</li>
    <li><?php echo $form->label('mobile', __('Mobile')); ?>
				<?php echo $form->input('mobile', ucwords($mobile)); ?>
		</li>
    <li><h2>Change Your Password</h2></li>
		<li><?php echo $form->label('password', __('Password')); ?>
				<?php echo $form->password('password', null); ?>
		</li>
		<li><?php echo $form->label('password_confirm', __('Re-type Password')); ?>
				<?php echo $form->password('password_confirm'); ?>
		</li>
		<li>
			<?php echo $form->submit(NULL, __('Save')); ?>
		</li>
	</ul>
	<?php echo $form->close(); ?>
  
</div>
