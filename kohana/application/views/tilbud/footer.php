<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<footer>
		
  <section class="centered">
  
    <ul class="fwidget">
    	<li><a href="#"><?= LBL_COMPANY?> </a></li>
      <li><a id="iabout2" href="<?= url::base(true)?>ipages?p=about"><?= LBL_ABOUT_TILBUD?></a></li>
      <li><a id="icontact2" href="<?= url::base(true)?>ipages?p=contact"><?= LBL_CONTACTUS?></a></li>
      <li><a id="iterms" href="<?= url::base(true)?>ipages?p=terms"><?= LBL_TERMS_AND_CONDITIONS ?></a></li>
    </ul>
    
    <ul class="fwidget">
    	<li><a href="#"><?= LBL_LEARN_MORE?></a></li>
      <li><a id="ihow" href="<?= url::base(true)?>/ipages?p=how"><?= LBL_HOW_TILBUD?></a></li>
      <li><a id="ifaq2" href="<?= url::base(true)?>/ipages?p=faq"><?= LBL_FAQ?></a></li>
      <li><a id="isuggest" href="<?= url::base(true)?>/ipages?p=suggest"><?= LBL_SUGGEST_TILBUD?></a></li>

    </ul>
    
    <ul class="fwidget">
    	<li><a href="#"><?= LBL_ADVERTISERS?></a></li>
      <li><a id="iwhy" href="<?= url::base(true)?>/ipages?p=why"><?= LBL_WHY_TILBUD?></a></li>
      <li><a id="igetyourbusiness" href="<?= url::base(true)?>/ipages?p=getyourbusiness"><?= LBL_GET_YOUR_BUSINESS?></a></li>
    </ul>
    
    <ul class="fwidget">
    	<li><a href="#"><?= LBL_FOLLOW_US?></a></li>
      <li><a href="http://www.addthis.com/bookmark.php?v=250&winname=addthis&pub=ra-4d6e3a782d6e35f6&source=tbx-250&lng=da&s=facebook&url=http%3A%2F%2Ftilbudibyen.dk%2F&title=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&ate=AT-ra-4d6e3a782d6e35f6/-/fs-0/4d6e50716ec654ce/1/4cc81af600857552&ips=1&uid=4cc81af600857552&sms_ss=1&at_xt=1&CXNID=2000001.5215456080540439074NXC&tt=0">Facebook</a></li>
      <li><a href="http://twitter.com/share?url=http%3A%2F%2Ftilbudibyen.dk%2F%3Fsms_ss%3Dtwitter%26at_xt%3D4d6e55361b58d8b5%2C0&via=AddThis&text=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&">Twitter</a></li>
      <?php if (!$is_logged){?>
      	<li><?php echo HTML::anchor('#signup-form-footer', LBL_JOIN_TILBUD, array('id' => 'signup-footer')); ?></li>
      <?php } ?>
    </ul>
    
  </section>
</footer>