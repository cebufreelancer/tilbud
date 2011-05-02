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
	
	$cardname 	= isset($posts['cardname']) ? $posts['cardname'] : $billing->cardname;
	$cardnumber = isset($posts['cardnumber']) ? $posts['cardnumber'] : $billing->cardnumber;
	$cardcode 	= isset($posts['cardcode']) ? $posts['cardcode'] : $billing->cardcode;
	$expiry_year 	= isset($posts['expiry_year']) ? $posts['expiry_year'] : $billing->expiry_year;
	$expiry_month = isset($posts['expiry_month']) ? $posts['expiry_month'] : $billing->expiry_month;
	$address 		= isset($posts['address']) ? $posts['address'] : $billing->address;
	$city 			= isset($posts['city']) ? $posts['city'] : $billing->city;
	$state 			= isset($posts['state']) ? $posts['state'] : $billing->state;
	$zipcode 		= isset($posts['zipcode']) ? $posts['zipcode'] : $billing->zipcode;
	
	$year = (int)date("Y");
	for($i=$year; $i<$year+10; $i++) { $years[$i] = $i; }
	for($i=1; $i<=12; $i++) { $mo[$i] = $i; }
	?>
	
	<?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
	<ul>
  	<li><?php echo $form->label('cardname', __('Cardholder Name')); ?>
				<?php echo $form->input('cardname', ucwords($cardname)); ?>
		</li>
    <li><?php echo $form->label('cardnumber', __('Card Number')); ?>
				<?php echo Form::input('cardnumber', ucwords($cardnumber), array('style' => 'width: 348px; letter-spacing: 5px;')) .  
							' Security Code ' . 
							Form::input('cardcode', $cardcode, array('style' => 'width: 50px',
																											 'maxlength' => 3,
																											 'size' => 3)); ?>
		</li>
    <li><?php echo $form->label('expiry_year', __('Expiration Date')); ?>
				<?php echo Form::select('expiry_month', $mo, $expiry_month) . ' ' . Form::select('expiry_year', $years, $expiry_year); ?>
		</li>
    <li><?php echo $form->label('address', __('Billing Address')); ?>
				<?php echo $form->input('address', ucwords($address)); ?>
		</li>
    <li><?php echo $form->label('city', __('City')); ?>
				<?php echo $form->input('city', ucwords($city)); ?>
		</li>
    <li><?php echo $form->label('state', __('State/Province')); ?>
				<?php echo Form::input('state', ucwords($state), array('style' => 'width: 375px;')) .
							' Zipcode ' .
							Form::input('zipcode', ucwords($zipcode), array('size' => 5, 'maxlength' => 5, 'style' => 'width: 60px;')); ?>
		</li>
		<li>
			<?php echo $form->submit(NULL, __('Save')); ?>
		</li>
	</ul>
	<?php echo $form->close(); ?>
  
</div>
