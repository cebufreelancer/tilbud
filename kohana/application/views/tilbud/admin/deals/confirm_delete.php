<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once '../header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; ?>
      
			<?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
      <ul>
      	<li><p class="medium">Are you sure you want to delete this record?</li>
        <?php
				foreach($records as $key => $val) {
					echo '<li>' . Form::label($key, __(ucfirst($key))) . '</li>';
					if($key == 'description') {
						$val = Form::textarea('vendor_desc', $val, array('readonly' => true, 'class' => 'display'));
					}
					echo '<li class="record-value">' . __($val) . '</li>';
				}
				?>
        <li>
        	<?php echo Form::submit('submit', 'Ok', array('class' => 'addbutton')); ?>
        <?php echo HTML::anchor($_SERVER['HTTP_REFERER'], LBL_CANCEL, array('class' => 'cancel')); ?>
        </li>
      </ul>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>