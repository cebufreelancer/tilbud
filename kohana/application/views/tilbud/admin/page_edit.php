<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; ?>
      
			<?php echo Form::open(Request::current(), array('id'			=> 'myforms')); ?>
      <ul>
      	<li><?php echo Form::label('product_name', __('Page Code')); ?>
						<?= $thepage->page_code;?>
        </li>
        <li><?php echo Form::label('product_desc', __('Content')); ?>
        		<?php echo Form::textarea('page_content', $thepage->content, array('style' => 'width: 70%;')); ?>
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
  <?php require_once 'footer.php'; ?>
  
</body>
</html>