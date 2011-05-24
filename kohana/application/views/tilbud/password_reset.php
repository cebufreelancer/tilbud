<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">

       <script type="text/javascript">
          jQuery(document).ready(function() {
        
            $("#change_password").bind("submit", function() {
              
            	if ($("#password").val().length < 1 || $("#confirm_password").val().length < 1) {
            	    $("#change_error").show().fadeOut(2200);
            	    return false;
            	}else{
              	if ($("#password").val() != $("#confirm_password").val()) {
              	    $("#dontmatch_error").show().fadeOut(2200);
              	    return false;
              	}
              }

            	$.fancybox.showActivity();

            	$.ajax({
            		type		: "POST",
            		cache	: false,
            		url		: "/home/changepassword",
            		data		: $(this).serializeArray(),
            		success: function(data) {
            		  $.fancybox.hideActivity();
            			if (data == "success") {
            			  $("#change_password").replaceWith("Password successfully changed.");
            			}
            		}
            	});

            	return false;
            });
            
          });
        </script>

   <br/>
   <h3><?php echo __(LBL_CHANGE_YOUR_TILBUD_PASSWORD);?></h3>
   <p> <?php echo __(LBL_CHOOSE_PASSWORD);?></p>
   <br/>
   <form id="change_password" action="" method="post">
     <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
    <div id="change_error" style="color: red; display: none"> <?php echo __(LBL_PASSWORD_EMPTY);?></div>
    <div id="dontmatch_error" style="color: red; display: none"> <?php echo __(LBL_PASSWORD_DONT_MATCH);?></div>

    <?php echo __(LBL_NEW_PASSWORD);?>   <br/>
    <input type="password" name="password" id="password" value="" style="width:240px">
    <br/>
    <?php echo __(LBL_VERIFY_NEW_PASSWORD);?>   <br/>    
    <input type="password" name="confirm_password" id="confirm_password" value="" style="width:240px">
    <br/>
    <input type="submit" name="submit" value="<?php echo __(LBL_CHANGE);?>">
    </form>



    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>