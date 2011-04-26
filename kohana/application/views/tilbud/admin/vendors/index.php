<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Vendors</h2>
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
          <?php echo HTML::anchor('admin/vendors/add', 'Add a Vendor', array('class' => 'addbutton')); ?>
        </div>

        <?php echo $paging->render(); ?>

        <table class="table">
        <thead>
        <tr>
          <td>Action</td>
          <td width="200">Name</td>
          <td>Description</td>
          <td>Address</td>
          <td>Email</td>
          <td>Date Created</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($vendors as $vendor) {
					$edit_url = HTML::anchor('admin/vendors/edit/' . $vendor['ID'], 'Edit');
					$delete_url = HTML::anchor('admin/vendors/delete/' . $vendor['ID'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $vendor['name'] . '</b></td>';
          echo '<td>' . substr($vendor['description'], 0, 50) . '</td>';
          echo '<td>' . Date::fuzzy_span(strtotime($vendor['date_created'])) . '</td>';
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
  <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
</body>
</html>