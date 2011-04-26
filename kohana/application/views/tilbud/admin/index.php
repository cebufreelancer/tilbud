<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Products</h2>
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
      
      <div id="myforms">
        <div id="action-button">
          <?php echo HTML::anchor('admin/products/add', 'Add a Product', array('class' => 'addbutton')); ?>
        </div>
        
        <?php echo $paging->render(); ?>
        
        <table class="table">
        <thead>
        <tr>
          <td>Action</td>
          <td width="200">Product</td>
          <td>Description</td>
          <td># of Deals</td>
          <td>Vendor</td>
          <td>Date Created</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($products as $product) {
					$edit_url = HTML::anchor('admin/products/edit/' . $product['ID'], 'Edit');
					$delete_url = HTML::anchor('admin/products/delete/' . $product['ID'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $product['title'] . '</b></td>';
          echo '<td>' . substr($product['description'], 0, 50) . '</td>';
					echo '<td align="center">' . ORM::factory('product', $product['ID'])->deals->count_all() . '</td>';
					echo '<td>' . ORM::factory('vendor', $product['vendor_id'])->name . '</td>';
          echo '<td>' . Date::fuzzy_span(strtotime($product['date_created'])) . '</td>';
          echo '</tr>';
        }		
        ?>
        </tbody>
        </table>
        
        <?php echo $paging->render(); ?>
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>