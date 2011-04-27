<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Deals</h2>
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
          <?php echo HTML::anchor('admin/deals/add', 'Add a Deal', array('class' => 'addbutton')); ?>
        </div>

        <?php echo $paging->render(); ?>

        <table class="table">
        <thead>
        <tr>
          <td>Action</td>
          <td>Title</td>
          <td>Image</td>
          <td>Start date</td>
          <td>End date</td>
          <td>Status</td>
          <td>Date Created</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($deals as $deal) {
					$edit_url = HTML::anchor('admin/deals/edit/' . $deal['ID'], 'Edit');
					$delete_url = HTML::anchor('admin/deals/delete/' . $deal['ID'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $deal['title'] . '</b></td>';
					echo '<td>' . $deal['image'] . '</td>';
					echo '<td>' . $deal['start_date'] . '</td>';
					echo '<td>' . $deal['end_date'] . '</td>';
					echo '<td>' . $deal['status'] . '</td>';
          echo '<td>' . Date::fuzzy_span(strtotime($deal['date_create'])) . '</td>';
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