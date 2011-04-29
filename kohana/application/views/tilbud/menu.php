<?php defined('SYSPATH') or die('No direct script access.'); ?>
<nav id="header-nav">
  <ul>
    <?php
    $is_admin = Auth::instance()->logged_in('admin');
		$is_logged = Auth::instance()->logged_in();
    $log_txt  = $is_logged ? 'logout' : 'login';
		$user = $is_logged ? Auth::instance()->get_user()->username : '';
  
    if($is_admin) { ?>
      <li><?php echo HTML::anchor('admin/users', 'USERS'); ?></li>
      <li><?php echo HTML::anchor('admin/cities', 'CITIES'); ?></li>
      <li><?php echo HTML::anchor('admin/vendors', 'VENDORS'); ?></li>
      <li><?php echo HTML::anchor('admin/products', 'PRODUCTS'); ?></li>
      <li><?php echo HTML::anchor('admin/deals', 'DEALS'); ?></li>      
      <li><?php echo HTML::anchor('admin/pages', 'PAGES'); ?></li>
      <li><?php echo HTML::anchor('', 'ORDERS'); ?></li>
      <li><?php echo HTML::anchor('user/logout', 'LOGOUT'); ?></li>

    <?php } else { ?>
      <li><?php echo HTML::anchor(url::base(true), 'DAGENS TILBUD'); ?></li>
      <li><?php echo HTML::anchor('alldeals', 'TIDLIGERE TILBUD'); ?></li>
      <li><?php echo HTML::anchor('signup', 'TILMED DIG'); ?></li>
      <li><a id="iabout" href="<?= url::base(true)?>ipages?p=about">OM OS</a></li>
      <li><a id="icontact" href="<?= url::base(true)?>ipages?p=contact">KONTAKT OS</a></li>      
      <li><a id="ifaq" href="<?= url::base(true)?>ipages?p=faq">FAQ</a></li>
      <li><?php echo HTML::anchor('#loginform', 'LOGIN', array('id' => 'tip5')); ?></li>


      <?php if($is_logged) { ?>
      	<li style="border-right: none;">&nbsp;</li>
        <li style="border: none;">&nbsp;</li>
        <li style="border: none;">&nbsp;</li>
      	<li id="mymenu"><?php echo strtoupper($user) . HTML::image('images/down.png', array('style' => 'margin-left: 10px;')); ?></li>
      <?php } ?>
      
    <?php } ?>
  </ul>
</nav>
<?php if($is_logged && !$is_admin) { ?>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#mymenu").click(function(){
    		$("#subnav").slideToggle("fast");
			});
  	});
	</script>
  
  <nav id="subnav">
    <ul>
      <li>My Stuff</li>
      <li><?php echo HTML::anchor('user/myaccount', 'My Account'); ?></li>
      <li><?php echo HTML::anchor('#', 'My Deals'); ?></li>
      <li><?php echo HTML::anchor('user/logout', 'Logout'); ?></li>
    </ul>
  </nav>
<?php } ?>