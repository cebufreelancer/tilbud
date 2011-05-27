<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php $cities = Kohana::config('global.cities'); ?>
	<script type="text/javascript">
    jQuery(document).ready(function() {

    	$("#thesignupform").bind("submit", function() {
  	    $.fancybox.showActivity();

    		$.ajax({
    			type	: "POST",
    			cache	: false,
    			url		: "home/signup",
    			data	: $(this).serializeArray(),
    			success: function(data) {
    				$.fancybox(data);
    			}
    		});

        $.fancybox.hideActivity();
    		return false;
    	});
		});      
  </script>
  <div id="signup-container">
    <h2>Velkommen til TilbudiByen.dk</h2>
    <p>Tilmeld dig gratis vores nyhedsbrev og få halv pris i din by.</p>
    
    <?php echo Form::open('', array('method' => 'post', 'id' => 'thesignupform')); ?>
    <ul id="signup-form-container">
    	<?php 
				if (is_null(Cookie::get('tib'))) {
					echo Form::hidden('subscriber', true);
				}
			?>
      <li><?php echo Form::select('city', $cities) . ' ' . __(LBL_CITY); ?></li>
      <li>
				<?php echo isset($errors['email']) ? '<span class="serror">' . $errors['email'] . '</span>' : ''; ?>
				<?php echo Form::input('semail', NULL, array('id' => 'signup-email', 'type' => 'email', 'style' => "width: 250px")) . 
        Form::submit(NULL, __(LBL_SEND), array('id' => 'signup-button')); ?>
      </li>
    </ul>
    <?php echo Form::close(); ?>
    
    <?php echo HTML::image(Url::base(TRUE) . 'images/tilmelding.jpg'); ?>
    
    <p>Når du tilmelder dig vores nyhedsbrev giver du samtidig dit samtykke til, at TilbudiByen.dk ApS hver dag må sende dig en e-mail med tilbud, som er udvalgt fra de bedste restauranter, wellness-steder, oplevelser etc. i din by.</p>
    <p>Du kan altid på TilbudiByen.dk eller via et link i e-mailen nemt og hurtigt framelde dig igen.</p>
    <p>TilbudiByen.dk ApS - Nøregade 7B - 1161 København K - CVR nummer: 33583400</p>
    
  </div>

