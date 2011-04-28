<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
    
  <div id="htitle">
    <h2>Login</h2>
  </div>
       
  <?php //echo '<pre>'; print_r($errors); echo '</pre>'; ?>
  
  <?php echo Form::open('user/login', array('id' => 'myforms')); ?>
  <ul>
    <li>Enter your username and password below to login.</li>
    <?php
    if(!empty($errors)) {
      echo '<li class="error">';
      foreach($errors as $err) {
        echo $err . '<br />';
      }
      echo '</li>';
    }
    ?>
    <li><?php echo Form::label('username', __('Username')); ?>
        <?php echo Form::input('username', isset($username) ? $username : '' ); ?>
    </li>
    <li><?php echo Form::label('password', __('Password')); ?>
        <?php echo Form::password('password'); ?>
    </li>
    <li><?php echo HTML::anchor('#', 'Forgot your password?', array('class' => 'homelink')); ?></li>
    <li>
      <?php echo Form::submit(NULL, 'Login'); ?> or <?php echo HTML::anchor('#', 'Create Account', array('class' => 'homelink')); ?>
    </li>
  </ul>
  <?php echo Form::close(); ?>