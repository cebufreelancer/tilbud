<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo __(LBL_EMAIL_TEMPLATES); ?></h2>
      </div>
      
      <?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
      
      <?php
			// output messages
			if(Message::count() > 0) {
				echo '<div class="block">';
				echo '<div class="content" style="padding: 10px 15px;">';
				echo Message::output();
				echo '</div></div>';
			}
			?>
			<script type="text/javascript">
				tinyMCE.init({
					mode : "specific_textareas",
					theme : "advanced",
					editor_selector : "emailEditor",
					width: "100%",
					height: "600",
					
					plugins : "table,fullscreen,inlinepopups",
					
					// Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,tablecontrols,|,code,fullscreen",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "bottom",

				});
			</script>		
      
      <ul>
      	<li><?php echo Form::label('to', __(LBL_EMAIL_TO)); ?>
						<?php echo Form::input('to', '', array('style' => 'width: 99%')); ?>
        </li>
      	<li><?php echo Form::label('subject', __(LBL_EMAIL_SUBJECT)); ?>
						<?php echo Form::input('subject', $subject, array('style' => 'width: 99%')); ?>
        </li>
        <li><?php echo Form::label('body', __(LBL_EMAIL_BODY)); ?>
						<?php echo Form::textarea('body', $body, array('class' => 'emailEditor')); ?>
        </li>
        <li>
            <?php echo Form::submit(NULL, __(LBL_SAVE)); ?>
            <?php echo HTML::anchor($_SERVER['HTTP_REFERER'], LBL_CANCEL, array('class' => 'cancel',
																																		 'style' => 'font-size: 11px;')) ?>
        </li>	
      </ul>
      <?php echo Form::close(); ?>

    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>