<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Labels</h2>
      </div>
      
      <div id="myforms">
      	<?php
				// output messages
				if(Message::count() > 0) {
				 	echo '<div class="block">';
				 	echo '<div class="content" style="padding: 10px 15px;">';
				 	echo Message::output();
					echo '</div></div>';
				}
				?>
				
				<p style="font-size: 11px">
        To create a label <br/>
        &nbsp;&nbsp;define("LBL_Your_Label_Here", "Your value here") ;
        <br/>
        To make the line a comment <br/>
        &nbsp;&nbsp;// this is a comment

        </p>
        

  			<?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
        <textarea name="labels" id="labels" class="mceNoEditor" style="height: 600px; width: 700px"><?= $labels ?></textarea>
        <li>
        	<?php echo Form::submit(NULL, 'Save'); ?>
          <?php echo Form::submit(NULL, 'Cancel'); ?>
        </li>
        
        <?php echo Form::close(); ?>
        
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>