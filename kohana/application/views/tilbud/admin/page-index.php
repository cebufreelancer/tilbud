<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Pages</h2>
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
          <?php echo HTML::anchor('admin/pages/add', 'Add a Product', array('class' => 'addbutton')); ?>
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
        foreach($pages as $page) {
					$edit_url = HTML::anchor('admin/pages/edit/' . $page['id'], 'Edit');
					$delete_url = HTML::anchor('admin/pages/delete/' . $page['id'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $page['page_code'] . '</b></td>';
          echo '<td>' . substr($page['content'], 0, 50) . '</td>';
          echo '<td>' . Date::fuzzy_span(strtotime($page['updated_at'])) . '</td>';
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