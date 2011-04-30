<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?

// TODO: need to transfer this to controller level and made available every pageload;
$dbconfig = Kohana::config('database.default');
$conn = mysql_connect('localhost', $dbconfig['connection']['username'], $dbconfig['connection']['password']  );
mysql_select_db($dbconfig['connection']['database']);
$sql = "select * from cities order by name ASC";
$result = mysql_query($sql, $conn);
$cities = array();
while($row = mysql_fetch_assoc($result)) {
  $cities[$row['ID']] =  $row['name'];
}

?>
      <div id="htitle">
      	<h2>Sign up</h2>
      </div>
      
    	<?php
			// output messages
			if(Message::count() > 0) {
			 	echo '<div class="block">';
			 	echo '<div class="content" style="padding: 10px 15px;">';
			 	echo Message::output();
				echo '</div></div>';
			}
			?>
      
		<?php echo Form::open('home/signup', array('id'	=> 'signupform', 'method' => 'post')); ?>
      <ul>
        <li><?php echo Form::label('city', __('City')); ?>
        		<?php echo Form::select('city', $cities); ?>
        </li>
      	<li><?php echo Form::label('semail', __('Email')); ?>
						<input id="semail" name="semail" value="">
        </li>
        <li>
        	<?php echo Form::submit(NULL, 'Save'); ?>
          <?php echo Form::submit(NULL, 'Cancel'); ?>
        </li>
      </ul>
    <?php echo Form::close(); ?>
