<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div>
      	<strong><a href="">Add New Product</a></strong>
      </div>
      
      <?php echo $paging->render(); ?>
      
      <table class="table">
      <?php
			foreach($products as $product) {
				echo '<tr>';
				echo '<td><a href="">Edit</a> <a href="">Delete</a></td>';
				echo '<td>' . $product['ID'] . '</td>';
				echo '<td>' . $product['title'] . '</td>';
				echo '<td>' . $product['description'] . '</td>';
				echo '<td>' . $product['date_created'] . '</td>';
				echo '</tr>';
			}		
			?>
			</table>
      
    	<?php echo $paging->render(); ?>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>