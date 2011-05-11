<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php if(Auth::instance()->logged_in() && !Auth::instance()->logged_in('admin')) { ?>
  <div id="action-button">
    <?php echo HTML::anchor('user/myaccount', 'My Account', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/billing', 'Billing Info', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('#', 'My Orders', array('class' => 'addbutton')); ?>
  </div>
<?php } ?>