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
      	<li><?php echo Form::label('page_code', __(LBL_PAGE_CODE)); ?>
        	  <?php echo Form::input('page_code', $thepage->page_code, array()); ?>
        </li>
        <li><?php echo Form::label('page_content', __(LBL_PAGE_CONTENT)); ?>
        		<?php echo Form::textarea('page_content', $thepage->content, array('style' => 'width: 70%;', 'class' => 'mceEditor' )); ?>
        </li>
        <li>
        	<?php echo Form::submit(NULL, __(LBL_SAVE)); ?>
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
