<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php $cities = Kohana::config('global.cities'); ?>
<html>
<head>
	<link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/main.css"/>
</head>
<body>
  <div id="signup-container">
    <h2>Velkommen til TilbudiByen.dk</h2>
    <p>Tilmeld dig gratis vores nyhedsbrev og f� halv pris i din by.</p>
    
    <?php echo Form::open(Request::current(), array('method' => 'post')); ?>
    <ul id="signup-form-container">
      <li><?php echo Form::select('city', $cities) . ' ' . __(LBL_CITY); ?></li>
      <li><?php echo Form::input('semail', NULL, array('id' => 'signup-email', 
                                                       'type' => 'email')) . 
                     Form::submit(NULL, __("Send"), array('id' => 'signup-button')); ?></li>
    </ul>
    <?php echo Form::close(); ?>
    
    <?php echo HTML::image(Url::base(TRUE) . 'images/tilmelding.jpg'); ?>
    
    <p>N�r du tilmelder dig vores nyhedsbrev giver du samtidig dit samtykke til, at TilbudiByen.dk ApS hver dag m� sende 
  dig en e-mail med tilbud, som er udvalgt fra de bedste restauranter, wellness-steder, oplevelser etc. i din by.</p>
    <p>Du kan altid p� TilbudiByen.dk eller via et link i e-mailen nemt og hurtigt framelde dig igen.</p>
    <p>TilbudiByen.dk ApS - N�regade 7B - 1161 K�benhavn K - CVR nummer: 33583400</p>
    
  </div>
</body>
</html>