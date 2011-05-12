<div id="htitle">
  <h2><?= LBL_MY_ACCOUNT ?></h2>
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
	
	$cardname 	= isset($posts['cardname']) ? $posts['cardname'] : $billing->cardname;
	$cardnumber = isset($posts['cardnumber']) ? $posts['cardnumber'] : $billing->cardnumber;
	$cardcode 	= isset($posts['cardcode']) ? $posts['cardcode'] : $billing->cardcode;
	$expiry_year 	= isset($posts['expiry_year']) ? $posts['expiry_year'] : $billing->expiry_year;
	$expiry_month = isset($posts['expiry_month']) ? $posts['expiry_month'] : $billing->expiry_month;
	$address 		= isset($posts['address']) ? $posts['address'] : $billing->address;
	$city 			= isset($posts['city']) ? $posts['city'] : $billing->city;
	$state 			= isset($posts['state']) ? $posts['state'] : $billing->state;
	$zipcode 		= isset($posts['zipcode']) ? $posts['zipcode'] : $billing->zipcode;
	$cardtype	  = isset($posts['cardtype']) ? $posts['cardtype'] : $billing->cardtype;
	
	$year = (int)date("Y");
	for($i=$year; $i<$year+10; $i++) { $years[$i] = $i; }
	for($i=1; $i<=12; $i++) { $mo[$i] = $i; }
	?>
	
	<?php echo $form->open(Request::current(), array('id' => 'myforms')); ?>
	<ul>
  	<li><?php echo Form::label('cardtype', __(LBL_CARDTYPE)); ?>
				<?php echo Form::select('cardtype', $cardtypes, $cardtype); ?>
    </li>
    <li><?php echo Form::label('cardname', __(LBL_CARDHOLDER)); ?>
        <?php echo isset($errors['cardname']) ? '<span class="serror">' . $errors['cardname'] . '</span>' : ''; ?>
        <?php echo Form::input('cardname', ucwords($cardname), array('required' => true)); ?>
    </li>
    <li><?php echo Form::label('cardnumber', __(LBL_CARDNUMBER)); ?>
        <?php echo isset($errors['cardnumber']) ? '<span class="serror">' . $errors['cardnumber'] . '</span>' : ''; ?>
        <?php echo isset($errors['cardcode']) ? '<span class="serror">' . $errors['cardcode'] . '</span>' : ''; ?>
        <?php echo Form::input('cardnumber', ucwords($cardnumber), array('style' => 'width: 310px; letter-spacing: 5px;',
                                                                         'required' => true)) .  
              ' ' . __(LBL_SECURITY_CODE) . ' ' .

              Form::input('cardcode', $cardcode, array('style' => 'width: 50px',
                                                       'maxlength' => 3,
                                                       'size' => 3,
                                                       'required' => true,
                                                       'pattern' => '[0-9]*')); ?>
    </li>
    <li><?php echo Form::label('expiry_year', __(LBL_EXPIRATION_DATE)); ?>
				<?php echo Form::select('expiry_month', $mo, $expiry_month) . ' ' . Form::select('expiry_year', $years, $expiry_year); ?>
    </li>
    <li><?php echo Form::label('address', __(LBL_BILLING_ADDRESS)); ?>
        <?php echo Form::input('address', ucwords($address), array('required' => true)); ?>
    </li>
    <?php /*
    <li><?php echo $form->label('city', __('City')); ?>
				<?php echo $form->input('city', ucwords($city)); ?>
		</li>
		*/ ?>
    <li>
				<?php echo Form::label('city', __(LBL_CITY)); ?>
        <?php echo isset($errors['city']) ? '<span class="serror">' . $errors['city'] . '</span>' : ''; ?>
        <?php echo isset($errors['zipcode']) ? '<span class="serror">' . $errors['zipcode'] . '</span>' : ''; ?>         
        <?php echo Form::input('city', ucwords($city), array('style' => 'width: 348px;', 'required' => true)) ; ?>
        <?php echo __(LBL_ZIPCODE); ?>
        <?php echo Form::input('zipcode', ucwords($zipcode), array('size' => 5, 
                                                              'maxlength' => 5, 
                                                              'style' => 'width: 60px;',
                                                              'required' => true,
                                                              'pattern' => '[0-9]*')); ?>
    </li>
		<li>
			<?php echo $form->submit(NULL, __(LBL_SAVE), array('class' => 'addbutton')); ?>
		</li>
	</ul>
	<?php echo $form->close(); ?>
  
</div>
