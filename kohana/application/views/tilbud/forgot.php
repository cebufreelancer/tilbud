<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">

       <script type="text/javascript">
          jQuery(document).ready(function() {
            $("#forget_password").bind("submit", function() {
            	if ($("#email").val().length < 1 || $("#email").val().length < 1) {
            	    $("#email_send_error").show().fadeOut(2000);
            	    return false;
            	}
            	$.fancybox.showActivity();
            	$.ajax({
            		type		: "POST",
            		cache	: false,
            		url		: "<?php echo Url::base(TRUE); ?>home/forgot",
            		data		: $(this).serializeArray(),
            		success: function(data) {
            			$.fancybox(data);
            		}
            	});
            	return false;
            });    
          });
        </script>
      <div id="htitle">
        <h2><?php echo __(LBL_CHANGE_YOUR_TILBUD_PASSWORD)?></h2>
      </div>

			<div id="myforms">
      <p> <?php echo __(LBL_TILBUD_SEND_RESET_INSTRUCTIONS)?></p>

      <form id="forget_password" action="" method="post">
      <ul>
        <li><?php echo Form::label('email', __(LBL_PLEASE_ENTER_EMAIL_ADDRESS)); ?>
            <?php echo isset($errors['cardnumber']) ? '<span class="serror">' . $errors['cardnumber'] . '</span>' : ''; ?>
            <div id="email_send_error" style="color: red; display: none"><?php echo __(LBL_PLEASE_ENTER_YOUR_EMAIL_ADDRESS); ?></div>
            <?php echo Form::input('email', '', array('required' => true, 'style' => 'width: 240px;', 'id' => 'email')); ?>
            <?php echo Form::submit('submit', __(LBL_SEND_INSTRUCTIONS)); ?>
        </li>
      </ul>
      <?php echo Form::close(); ?>
      </div>
   	</div>
 	</section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>
