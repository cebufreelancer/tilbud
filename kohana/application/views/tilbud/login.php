<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
    
  <div id="htitle">
    <h2><?= LBL_LOGIN ?></h2>
  </div>
       
  <?php //echo '<pre>'; print_r($errors); echo '</pre>'; ?>
  
  <?php echo Form::open('user/login', array('id' => 'myforms')); ?>
  <ul>
    <li><?= LBL_ENTER_USERNAME_PASSWORD ?></li>
    <?php
    if(!empty($errors)) {
      echo '<li class="error">';
      foreach($errors as $err) {
        echo $err . '<br />';
      }
      echo '</li>';
    }
    ?>
    <li><?php echo Form::label('username', LBL_USERNAME); ?>
        <?php echo Form::input('username', isset($username) ? $username : '' ); ?>
    </li>
    <li><?php echo Form::label('password', LBL_PASSWORD); ?>
        <?php echo Form::password('password'); ?>
    </li>
    <li><?php echo HTML::anchor('#', LBL_FORGOT_PASSWORD, array('class' => 'homelink')); ?></li>
    <li>
      <?php echo Form::submit(NULL, LBL_LOGIN); ?>
      <!--  or <?php echo HTML::anchor('#', LBL_CREATE_ACCOUNT, array('class' => 'homelink')); ?> -->
    </li>
  </ul>
  <?php echo Form::close(); ?>
