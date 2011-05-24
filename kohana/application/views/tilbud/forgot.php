<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
  <!-- content starts here -->
  <section id="main-body">
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
            		url		: "/home/forgot",
            		data		: $(this).serializeArray(),
            		success: function(data) {
            			$.fancybox(data);
            		}
            	});

            	return false;
            });
            
          });
        </script>

   <br/>
   <h3><?php echo __(LBL_CHANGE_YOUR_TILBUD_PASSWORD)?></h3>
   <p> <?php echo __(LBL_TILBUD_SEND_RESET_INSTRUCTIONS)?></p>
   <br/>   
   <form id="forget_password" action="" method="post">
      <?php echo __(LBL_PLEASE_ENTER_EMAIL_ADDRESS); ?> <br/>
    <div id="email_send_error" style="color: red; display: none"><?php echo __(LBL_PLEASE_ENTER_YOUR_EMAIL_ADDRESS); ?> </div>
    <input type="text" name="email" id="email" value="" style="width:240px">
    <input type="submit" name="submit" value="<?php echo __(LBL_SEND_INSTRUCTIONS);?>">
    </form>

    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>