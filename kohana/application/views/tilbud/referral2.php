<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="signup-container">
	<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#close-button").click(function() {
      $.fancybox.close();
      location.replace("/user/myaccount");
		});
	});
  </script>
  
  <div id="email-sent">
    <h2><?php echo __(LBL_THANKYOU_FOR_INVITING); ?></h2>
  
    <br />
  
    <span  id="close-button" style="cursor: pointer; background: #369BCF; font-size: 15px; font-weight: bold; color: white;  padding: 5px 10px; border: 1px solid #CCC;  margin: 0px 0px 2px 5px;"><?php echo htmlentities('Luk');?></span>
  </div>

</div>