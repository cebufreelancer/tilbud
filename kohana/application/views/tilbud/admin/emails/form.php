<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
      
      <?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
	    <script type="text/javascript">
				tinyMCE.init({
					mode : "specific_textareas",
					theme : "advanced",
					editor_selector : "emailEditor",
					width: "100%",
					height: "300",
					
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
      	<li><?php echo Form::label('template_name', __(LBL_EMAIL_TEMPLATE_NAME)); ?>
						<?php echo Form::input('template_name', $template_name, array('style' => 'width: 50%')); ?>
        </li>
        <li><?php echo Form::label('tags', __(LBL_EMAIL_TAGS)); ?>
        		<div style="font-size: 11px;">
            <b>$CUSTOMERNAME</b> - Name of the customer <br />
            <b>$CUSTOMEREMAIL</b> - Email of the customer <br />
            <b>$DEAL</b> - Name of the deal <br />
            <b>$REFERENCENO</b> - Reference Number
            <b>$PAYMENTTYPE</b> - Reference Number
            <b>$CARDNUMBER</b> - Reference Number
            <b>$CARDINTEREST</b> - Reference Number
            <b>$TOTALAMOUNT</b> - Reference Number
            <b>$ORDERSTATUS</b> - Reference Number
            <b>$ORDERNUMBER</b> - Reference Number
            <b>$QUANTITY</b> - Reference Number
            <b>$REGULARPRICE</b> - Reference Number
            <b>$TOTALAMOUNT</b> - Reference Number
            <b>$DATETODAY</b> - Reference Number
            
            <b>$EMAILFORMATURL</b> - Reference Number
            </div>
        </li>
      	<li><?php echo Form::label('subject', __(LBL_EMAIL_SUBJECT)); ?>
						<?php echo Form::input('subject', $subject, array('style' => 'width: 99%')); ?>
        </li>
        <li><?php echo Form::label('body', __(LBL_EMAIL_BODY)); ?>
						<?php echo Form::textarea('body', $body, array('class' => 'emailEditor')); ?>
        </li>
        <li>
            <?php echo Form::submit(NULL, __(LBL_SAVE), array('class' => 'addbutton')); ?>
            <?php echo HTML::anchor('admin/emails', LBL_CANCEL, array('class' => 'cancel',
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