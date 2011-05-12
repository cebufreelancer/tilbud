<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="signup-container">
	<script type="text/javascript">
	jQuery(document).ready(function() {

  	$("#thereferralform").bind("submit", function() {
	    $.fancybox.showActivity();

  		$.ajax({
  			type	: "POST",
  			cache	: false,
  			url		: "/home/referral",
  			data	: $(this).serializeArray(),
  			success: function(data) {
  				$.fancybox(data);
  			}
  		});

      $.fancybox.hideActivity();
  		return false;
  	});
		
		
	});
	</script>

	<div id="share-us" ">    
    <h2>Tak for din tilmelding!<br /><br />
        Giv dine venner eller familie samme mulighed</h2>
    
    <?php echo Form::open(Url::base(TRUE) . 'referral', array('method' => 'post', 'id' => 'thereferralform')); ?>
    
    <ul id="signup-form-container">
      <li><?php echo Form::input('email', NULL, array('id' => 'signup-email', 
                                                       'placeholder' => 'Indtast din vens e-mail adresse')) . 
                     Form::submit(NULL, __(LBL_SEND), array('id' => 'signup-button')); ?>
          <span style="color: gray"><?php echo __(LBL_COMMA_DELIMITED);?></span>
    </li>
    </ul>
    <?php echo Form::close(); ?>
    
    <?php echo HTML::image(Url::base(TRUE) . 'images/tak_for_din_tilmelding.jpg'); ?>
  </div>
</div>
