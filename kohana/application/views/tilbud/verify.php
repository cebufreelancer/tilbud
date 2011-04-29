<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Account verification</h2>
      </div>
      
    	<?php
			// output messages
			if(Message::count() > 0) {
			 	echo '<div class="block">';
			 	echo '<div class="content" style="padding: 10px 15px;">';
			 	echo Message::output();
				echo '</div></div>';
			}
			?>      
      
      <div>
        <h4> Please update your password</h4>

          <?php if ($success){?>
            
        		<form action="password_update" method="post" id="myforms">
              <?php echo Form::hidden('email', $email)?>
              <ul>
                <li><?php echo Form::label('password', __('Password')); ?>
                		<?php echo Form::password('password', ''); ?>
                </li>
              	<li><?php echo Form::label('confirm_password', __('Confirm Password')); ?>
        						<?php echo Form::password('confirm_password', ''); ?>
                </li>
                <li>
                	<?php echo Form::submit(NULL, 'Update'); ?>
                  <?php echo Form::submit(NULL, 'Cancel'); ?>
                </li>
              </ul>
            </form>



            
          <? } ?>

      </div>

    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>