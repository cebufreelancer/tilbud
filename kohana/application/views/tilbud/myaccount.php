<div id="htitle">
  <h2>My Account</h2>
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
  
  <div id="action-button">
    <?php echo HTML::anchor('#', 'My Orders', array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('#', 'My Deals', array('class' => 'addbutton')); ?>
  </div>
   
  <p class="intro">This is your user information, <?php echo $user->username ?>.</p>
  
  <h2>Username &amp; Email Address</h2>
  <p><?php echo $user->username ?> &mdash; <?php echo $user->email ?></p>
  
  <h2>Login Activity</h2>
  <p>Last login was <?php echo date('F jS, Y', $user->last_login) ?>, at <?php echo date('h:i:s a', $user->last_login) ?>.<br/>Total logins: <?php echo $user->logins ?></p>
  
</div>
