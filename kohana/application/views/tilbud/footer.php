<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<footer>
		
  <section class="centered">
  
    <ul class="fwidget">
    	<li><span style="font-weight: bold"><?= LBL_COMPANY?> </span></li>
      <li><a class="ipages" id="iabout2" href="<?= url::base(true)?>ipages?p=about"><?= LBL_ABOUT_TILBUD?></a></li>
      <li><a class="ipages" id="icontact2" href="<?= url::base(true)?>ipages?p=contact"><?= LBL_Contactus ?></a></li>
      <li><a class="ipages" id="iterms" href="<?= url::base(true)?>ipages?p=terms"><?= LBL_TERMS_AND_CONDITIONS ?></a></li>
    </ul>
    
    <ul class="fwidget">
    	<li><span style="font-weight: bold"><?= LBL_LEARN_MORE?></span></li>
      <li><a class="ipages" id="ihow" href="<?= url::base(true)?>/ipages?p=how"><?= LBL_HOW_TILBUD?></a></li>
      <li><a class="ipages" id="ifaq2" href="<?= url::base(true)?>/ipages?p=faq"><?= LBL_FAQ?></a></li>
      <li><a class="ipages" id="isuggest" href="<?= url::base(true)?>/ipages?p=suggest"><?= LBL_SUGGEST_TILBUD?></a></li>

    </ul>
    
    <ul class="fwidget">
    	<li><span style="font-weight: bold"><?= LBL_ADVERTISERS?></span></li>
      <li><a class="ipages" id="iwhy" href="<?= url::base(true)?>/ipages?p=why"><?= LBL_WHY_TILBUD?></a></li>
      <li><a class="ipages" id="igetyourbusiness" href="<?= url::base(true)?>/ipages?p=getyourbusiness"><?= LBL_GET_YOUR_BUSINESS?></a></li>
    </ul>
    
    <ul class="fwidget">
    	<li><span style="font-weight: bold"><?= LBL_FOLLOW_US?></span></li>
      <li><a target='_blank' href="/home/fb">Facebook</a></li>
      <li><a target='_blank' href="http://twitter.com/share?url=http%3A%2F%2Ftilbudibyen.dk%2F%3Fsms_ss%3Dtwitter%26at_xt%3D4d6e55361b58d8b5%2C0&via=AddThis&text=Tilbud%20i%20Byen%20-%20Spar%2050%25%20p%C3%A5%20alt%20i%20byen!&">Twitter</a></li>
      <?php if (!$is_logged){?>
      	<li><?php echo HTML::anchor('#signup-form', LBL_JOIN_TILBUD, array('id' => 'signup-footer',
																																									'class' => 'signup')); ?></li>
      <?php } ?>
    </ul>
    
  </section>
</footer>