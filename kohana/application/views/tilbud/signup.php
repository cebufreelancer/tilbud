<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Sign up</h2>
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
      

		<?php echo Form::open(Request::current(), array(
																										'id'			=> 'myforms')); ?>

      <ul>

        <li><?php echo Form::label('city', __('City')); ?>
        		<?php echo Form::select('city', $cities); ?>
        </li>
      	<li><?php echo Form::label('email', __('Email')); ?>
						<?php echo Form::input('email', ''); ?>
        </li>
        <li>
        	<?php echo Form::submit(NULL, 'Save'); ?>
          <?php echo Form::submit(NULL, 'Cancel'); ?>
        </li>

      </ul>

      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>