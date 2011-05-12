<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="signup-container">
	<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#next-button").click(function() {
			$("#email-sent").hide();
			$("#share-us").show();
		});

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

	<div id="email-sent">
    <h2>Vi har sendt dig en e-mail</h2>
    
    <?php echo HTML::image(Url::base(TRUE) . 'images/bekraeft_din_tilmelding.jpg', array('width' => 600)); ?>
    <br />
    
    <span  id="next-button" style="cursor: pointer; background: #369BCF; font-size: 15px; font-weight: bold; color: white;  padding: 5px 10px; border: 1px solid #CCC;  margin: 0px 0px 2px 5px;">NEXT</span>
  </div>
	<div id="share-us" style="display: none;">    
    <h2>Tak for din tilmelding!<br /><br />
        Giv dine venner eller familie samme mulighed</h2>
    
    <?php echo Form::open(Url::base(TRUE) . 'referral', array('method' => 'post', 'id' => 'thereferralform')); ?>
    
    <ul id="signup-form-container">
      <li><?php echo Form::input('email', NULL, array('id' => 'signup-email', 
                                                       'placeholder' => 'Indtast din vens e-mail adresse')) . 
                     Form::submit(NULL, __(LBL_SEND), array('id' => 'signup-button')); ?></li>
    </ul>
    <?php echo Form::close(); ?>
    
    <?php echo HTML::image(Url::base(TRUE) . 'images/tak_for_din_tilmelding.jpg'); ?>
  </div>
</div>
