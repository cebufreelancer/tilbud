<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; ?>
      
			<?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
      <ul>
      	<li><?php echo Form::label('city', __(LBL_CITY_NAME)); ?>
						<?php echo Form::input('city', $city); ?>
        </li>
        <li><?php echo Form::label('order', __(LBL_ORDER)); ?>
						<?php echo Form::input('order', $order); ?>
        </li>
        <li>
            <?php echo Form::submit(NULL, __(LBL_SAVE)); ?>
            <?php echo HTML::anchor('admin/cities', LBL_CANCEL, array('class' => 'cancel',
																																		 'style' => 'font-size: 11px;')) ?>
        </li>	
      </ul>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>