<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if(Auth::instance()->logged_in() && !Auth::instance()->logged_in('admin')) { ?>
	<div id="action-button">
		<?php echo HTML::anchor('user/myaccount', LBL_My_Account, array('class' => 'addbutton')); ?>
		<?php echo HTML::anchor('user/billing', LBL_Billing_Info, array('class' => 'addbutton')); ?>
	</div>
<?php } ?>