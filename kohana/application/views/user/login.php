<?php
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
  <div id="htitle">
    <h2><?php echo LBL_LOGIN; ?></h2>
  </div>
<?php
echo $form->open('user/login', array('id' => 'myforms'));
echo '<table><tr><td style="vertical-align: top;">';
echo '<ul>';
echo '<li>'.$form->label('username', LBL_EMAIL_OR_USERNAME).'</li>';
echo $form->input('username', null, array('class' => 'text twothirds'));
echo '<li>'.$form->label('password', LBL_PASSWORD).'</li>';
echo $form->password('password', null, array('class' => 'text twothirds'));
echo '</ul>';
echo $form->submit(NULL, LBL_LOGIN);
echo '<small> '.Html::anchor('user/forgot', LBL_FORGOT_PASSWORD).'<br></small>';
echo $form->close();
echo '</td><td width="5" style="border-right: 1px solid #DDD;">&nbsp;</td><td><td style="padding-left: 2px; vertical-align: top;">';

echo '<ul>';
echo '<li style="height: 61px">'.__('Don\'t have an account?').' '.Html::anchor('user/register', __('Register a new account')).'.</li>';
$options = array_filter(Kohana::config('useradmin.providers'));
if(!empty($options)) {
   echo '<li style="padding-bottom: 8px;"><label>'.__('To register / log in using another account, please click your provider').':</label></li>';
   echo '<li>';
   if(isset($options['facebook']) && $options['facebook']) {
      echo '<a class="login_provider" style="background: #FFF url(' . URL::base(TRUE) . 'images/img/facebook.png) no-repeat center center" href="'.URL::site('/user/provider/facebook').'"></a>';
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
?>
      </div>
   </div>
</div>


