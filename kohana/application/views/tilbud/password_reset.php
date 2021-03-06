<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
  <!-- content starts here -->
  <section id="ad-body">
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
							url		: "<?php echo Url::base(TRUE); ?>/home/changepassword",
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
        
			<div id="htitle">
        <h2><?php echo __(LBL_CHANGE_YOUR_TILBUD_PASSWORD)?></h2>
      </div>

			<div id="myforms">
				<p> <?php echo __(LBL_CHOOSE_PASSWORD);?></p>

				<form id="change_password" action="" method="post">
        	<div id="change_error" style="color: red; display: none"> <?php echo __(LBL_PASSWORD_EMPTY);?></div>
          <div id="dontmatch_error" style="color: red; display: none"> <?php echo __(LBL_PASSWORD_DONT_MATCH);?></div>
					<ul>
						<li><?php echo Form::hidden('email', $_GET['email']); ?>
								<?php echo Form::label('password', __(LBL_NEW_PASSWORD)); ?>
            		<?php echo Form::password('password', '', array('style' => 'width: 240px;', 'required' => true, 'id' => 'password')); ?>
            </li>
            <li>
            		<?php echo Form::label('confirm_password', __(LBL_VERIFY_NEW_PASSWORD)); ?>
            		<?php echo Form::password('confirm_password', '', array('style' => 'width: 240px;', 'required' => true, 'id' => 'confirm_password')); ?>
            </li>
						<li>
            	<?php echo Form::submit('submit', __(LBL_CHANGE)); ?>
            </li>
      		</ul>
      	</form>
			</div>

    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>