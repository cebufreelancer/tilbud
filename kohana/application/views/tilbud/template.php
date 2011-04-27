<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php require_once APPPATH .'views/tilbud/header.php'; ?>

	<!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    
    <?php echo $content; ?>

	 </div>
  </section>
   
<?php 
// echo '<div id="kohana-profiler">'.View::factory('profiler/stats').'</div>';
?>

	<?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>

</body>
</html>
