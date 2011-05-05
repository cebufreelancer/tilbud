<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
// TODO: need to transfer this to controller level and made available every pageload;
$cities = Kohana::config('global.cities');
?>
<div id="htitle">
	<h2><?= LBL_SIGNUP?></h2>
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
	<li><?php echo Form::label('city', LBL_CITY); ?>
			<?php echo Form::select('city', $cities); ?>
	</li>
	<li><?php echo Form::label('semail', LBL_EMAIL); ?>
			<input id="semail" name="semail" value="">
	</li>
	<li>
		<?php echo Form::submit(NULL, LBL_SAVE); ?>
	</li>
</ul>
<?php echo Form::close(); ?>
