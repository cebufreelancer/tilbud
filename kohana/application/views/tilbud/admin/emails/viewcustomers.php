<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<?php echo __(LBL_CUSTOMERS)?>
      </div>

      <div>
        <script type="text/javascript">
          jQuery(document).ready(function() {
        
            $("#send_email_form").bind("submit", function() {
              
            	if ($("#test_email").val().length < 1 || $("#test_email").val().length < 1) {
            	    $("#send_error").show();
            	    $.fancybox.resize();
            	    return false;
            	}

            	$.fancybox.showActivity();

            	$.ajax({
            		type		: "POST",
            		cache	: false,
            		url		: "/admin/emails/sendtest",
            		data		: $(this).serializeArray(),
            		success: function(data) {
            			$.fancybox(data);
            		}
            	});

            	return false;
            });
            
            $("#sendall_email_form").bind("submit", function() {
              alert('pass');
              

            	$.fancybox.showActivity();

            	$.ajax({
            		type		: "POST",
            		cache	: false,
            		url		: "/admin/emails/notify_buyers",
            		data		: $(this).serializeArray(),
            		success: function(data) {
            			$.fancybox(data);
            		}
            	});

            	return false;
            });

            
          });
        </script>        

        <form action="" name="send_email_form" id="send_email_form" method="post">
          <p id="send_error" style="display: none">Please enter email</p>
        Send test email to: <input type="input" name="test_email" id="test_email">
        <input type="hidden" name="deal_id" value="<?php echo $deal['ID'];?>">
        <input type="submit" name="SendTestEmail" value="Send Test Email">
        </form>
        
      </div>
      
      <br/>
      
      <form action="" name="sendall_email_form" id="sendall_email_form" method="post">
      <table cellpadding="5" cellspacing="5"  border="1">
        <?php
        for($i=0; $i < sizeof($orders); $i++) {
        ?>
        <tr >
          <td>
            <input type="checkbox" name="semail[]" value="<?php echo $orders[$i]['users']['email'];?>">
            </td>
          <td width=200><?php echo $orders[$i]['users']['email']?></td>
          <td width=200><?php echo $orders[$i]['users']['firstname'] . " " . $orders[$i]['users']['lastname']?></td>
          <td width=100><?php echo strftime("%Y-%m-%d", strtotime($orders[$i]['date_created'])) ?></td>
          <td width=100><?php echo $orders[$i]['refno']?></td>
        </tr>
        <?php } ?>
      </table>
      
      <input type="hidden" name="deal_id" value="<?php echo $deal['ID'];?>">
      <input type="submit" name="Send Email" value="Send Email">
      </form>
          
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>