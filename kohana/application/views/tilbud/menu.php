<?php defined('SYSPATH') or die('No direct script access.'); ?>
<nav id="header-nav">
  <ul>
    <?php
    $is_admin = Auth::instance()->logged_in('admin');
		$is_logged = Auth::instance()->logged_in();
    $log_txt  = $is_logged ? 'logout' : 'login';
		$user = $is_logged ? __(LBL_My_Account) : '';
  
    if($is_admin) { ?>
      <li><?php echo HTML::anchor('/', __(LBL_VIEW_SITE)); ?></li>
      <li><?php echo HTML::anchor('admin/users', __(LBL_USERS)); ?></li>
      <li><?php echo HTML::anchor('admin/cities', __(LBL_CITIES)); ?></li>
      <li><?php echo HTML::anchor('admin/groups', __(LBL_GROUPS)); ?></li>
      <li><?php echo HTML::anchor('admin/deals', __(LBL_DEALS)); ?></li>      
      <li><?php echo HTML::anchor('admin/orders', __(LBL_ORDERS)); ?></li>
      <li><?php echo HTML::anchor('admin/pages', __(LBL_PAGES)); ?></li>
      <li id="mymenu"><?php echo strtoupper("more") . HTML::image('images/down.png', array('style' => 'margin-left: 10px;')); ?></li>

    <?php } else { ?>
      <li><?php echo HTML::anchor(url::base(true), LBL_FEATURED_DEAL); ?></li>
      <li><?php echo HTML::anchor('alldeals', LBL_ALLDEALS); ?></li>

      <?php if (!$is_logged){?>
      	<li><?php echo HTML::anchor('#signup-form', LBL_SIGNUP, array('id' => 'signup', 'class' => 'signup')); ?></li>
      <?php } ?>

      
      <li><a class="ipages" id="iabout" href="<?= url::base(true)?>ipages?p=about"><?= LBL_ABOUTUS?></a></li>
      <li><a class="ipages" id="icontact" href="<?= url::base(true)?>ipages?p=contact"><?= LBL_CONTACTUS ?></a></li>      
      <li><a class="ipages" id="ifaq" href="<?= url::base(true)?>ipages?p=faq"><?= LBL_FAQ?></a></li>
      <?php if (!$is_logged){?>
      	<li><?php echo HTML::anchor('#loginform', LBL_LOGIN, array('id' => 'tip5')); ?></li>
      <?php } ?>


      <?php if($is_logged) { ?>
      	<li style="border: none;">&nbsp;</li>
      	<li id="mymenu"><?php echo strtoupper($user) . HTML::image('images/down.png', array('style' => 'margin-left: 10px;')); ?></li>
      <?php } ?>
      
    <?php } ?>
  </ul>
</nav>
<?php if($is_logged) { ?>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#mymenu").click(function(){
    		$("#subnav").slideToggle("fast");
			});
  	});
	</script>
  
  <nav id="subnav">
    <ul>
      <?php if(!$is_admin) { ?>
      	<li><?php echo __(LBL_MY_STUFF); ?></li>
        <li><?php echo HTML::anchor('user/myaccount', __(LBL_My_Account)); ?></li>
        <li><?php echo HTML::anchor('user/orders', __(LBL_My_Orders)); ?></li>
      <?php } else { ?>
      	<li><?php echo __(LBL_SETTINGS); ?></li>
        <li><?php echo HTML::anchor('admin/labels', ucwords(strtolower(LBL_LABELS))); ?></li>
      <?php } ?>
      <li>
        <?php if (isset($_SESSION['oauth_uid']) && $_SESSION['oauth_uid'] != "") {?>
          <?php echo HTML::anchor('user/fblogout', ucwords(strtolower(LBL_LOGOUT))); ?>
        <?php }else{ ?>
          <?php echo HTML::anchor('user/logout', ucwords(strtolower(LBL_LOGOUT))); ?>
        <?php } ?>
      </li>
    </ul>
  </nav>
<?php } ?>