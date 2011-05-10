<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Cities</h2>
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
          <?php echo HTML::anchor('admin/cities/add', 'Add a City', array('class' => 'addbutton')); ?>
        </div>
        
        <?php echo ($no_pager == TRUE) ? '' : $paging->render(); ?>
        
        <table class="table">
        <thead>
        <tr>
          <td>Action</td>
          <td>Order</td>
          <td width="200">City</td>
          <td>Subscribers</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($cities as $city) {
					$edit_url = HTML::anchor('admin/cities/edit/' . $city['ID'], 'Edit');
					$delete_url = HTML::anchor('admin/cities/delete/' . $city['ID'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
					echo '<td>' . $city['order'] . '</td>';
					echo '<td><b>' . $city['name'] . '</b></td>';
					echo '<td>' . ORM::factory('city')->get_subscribers($city['ID']) . '</td>';
          echo '</tr>';
        }		
        ?>
        </tbody>
        </table>
        
        <?php echo ($no_pager == TRUE) ? '' : $paging->render(); ?>
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>