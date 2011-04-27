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
      	<li>Enter your username and password below to login.</li>
      	<li><?php echo Form::label('username', __('Username')); ?>
						<?php echo Form::input('username', ''); ?>
        </li>
        <li><?php echo Form::label('password', __('Password')); ?>
						<?php echo Form::password('password'); ?>
        </li>
        <li>Forgot your password?</li>
        <li>
        	<?php echo Form::submit(NULL, 'Login'); ?>
        </li>
      </ul>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
         
    	<?php
			/*
$form = new Appform();
if(isset($errors)) {
   $form->errors = $errors;
}
if(isset($username)) {
   $form->values['username'] = $username;
}
// set custom classes to get labels moved to bottom:
$form->error_class = 'error block';
$form->info_class = 'info block';

?>
<div id="box">
   <div class="block">
      <h1><?php echo __('Login'); ?></h1>
      <div class="content">
<?php
echo $form->open('user/login');
echo '<table><tr><td style="vertical-align: top;">';
echo '<ul style="list-style-type: none">';
echo '<li style="list-style-type: none">'.$form->label('username', __('Email or Username')).'</li>';
echo $form->input('username', null, array('class' => 'text twothirds'));
echo '<li>'.$form->label('password', __('Password')).'</li>';
echo $form->password('password', null, array('class' => 'text twothirds'));
echo '</ul>';
echo $form->submit(NULL, __('Login'));
echo '<small> '.Html::anchor('user/forgot', __('Forgot your password?')).'<br></small>';
echo $form->close();
echo '</td><td width="5" style="border-right: 1px solid #DDD;">&nbsp;</td><td><td style="padding-left: 2px; vertical-align: top;">';

echo '<ul style="list-style-type: none">';
echo '<li style="height: 61px; list-style-type: none">'.__('Don\'t have an account?').' '.Html::anchor('user/register', __('Register a new account')).'.</li>';
$options = array_filter(Kohana::config('useradmin.providers'));
if(!empty($options)) {
   echo '<li>';
   if(isset($options['facebook']) && $options['facebook']) {
      echo '<a class="login_provider" style="background: #FFF url(/img/facebook.png) no-repeat center center" href="'.URL::site('/user/provider/facebook').'"></a>';
   }
   if(isset($options['twitter']) && $options['twitter']) {
      echo '<a class="login_provider" style="background: #FFF url(/img/twitter.png) no-repeat center center" href="'.URL::site('/user/provider/twitter').'"></a>';
   }
   if(isset($options['google']) && $options['google']) {
      echo '<a class="login_provider" style="background: #FFF url(/img/google.gif) no-repeat center center" href="'.URL::site('/user/provider/google').'"></a>';
   }
   if(isset($options['yahoo']) && $options['yahoo']) {
      echo '<a class="login_provider" style="background: #FFF url(/img/yahoo.gif) no-repeat center center" href="'.URL::site('/user/provider/yahoo').'"></a>';
   }
   echo '<br style="clear: both;">
   </li>';
}
echo '</ul>';
echo '</td></tr></table>';
*/
?>
  <!--     </div>
   </div>
</div>  -->   	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>