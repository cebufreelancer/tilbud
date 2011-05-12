<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="signup-container">
	<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#close-button").click(function() {
      $.fancybox.close();
		});
	});
  </script>
  
  <div id="email-sent">
    <h2>Vi har sendt dig en e-mail</h2>
  
    <?php echo HTML::image(Url::base(TRUE) . 'images/bekraeft_din_tilmelding.jpg', array('width' => 600)); ?>
    <br />
  
    <span  id="close-button" style="cursor: pointer; background: #369BCF; font-size: 15px; font-weight: bold; color: white;  padding: 5px 10px; border: 1px solid #CCC;  margin: 0px 0px 2px 5px;"><?php echo htmlentities('Luk');?></span>
  </div>

</div>