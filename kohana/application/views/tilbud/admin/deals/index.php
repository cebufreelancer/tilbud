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

        <?php 
				
				if(!empty($deals)) {
					echo ($show_pager) ? $paging->render() : ''; ?>
	
					<table class="table" border=1>
					<thead>
					<tr>
						<td>Title</td>
            <td>Group</td>
						<td>Start date</td>
						<td>Sold</td>
						<td>Status</td>
						<td>Date Created</td>
					</tr>
					</thead>
					<tbody class="order-table">
					<?php
					foreach($deals as $deal) {
						$edit_url = HTML::anchor('admin/deals/edit/' . $deal['ID'], 'Edit');
						$delete_url = HTML::anchor('admin/deals/delete/' . $deal['ID'], 'Delete', array('class' => 'delete'));
						$email_url = HTML::anchor('admin/deals?city=' . $deal['city_id'] . '&did=' . $deal['ID'], 'Send Email');
						$group = ORM::factory('category', $deal['group_id'])->name;
						echo '<tr>';
						echo '<td style="width:480px;"><b>' . $deal['title'] . '<br/>' . $deal['description'] . '</b>' .
						     '<div>' . $edit_url . ' | ' . $delete_url . ' | ' . $email_url . '</div>' .
						     '</td>';
						echo '<td>' . $group . '</td>';
						echo '<td>' . date("F d, Y", strtotime($deal['start_date'])) . '</td>';
						echo '<td>' . $deal['total_sold'] . '</td>';
						//echo '<td>' . $deal['end_date'] . '</td>';
						echo '<td>' . ucwords($deal['status']) . '</td>';
						echo '<td>' . date("F d, Y", strtotime($deal['date_create'])) . '</td>';
						echo '</tr>';
					}		
					?>
					</tbody>
					</table>
        
        <?php 
					echo ($show_pager) ? $paging->render() : '';
				} else { ?>
        
        	<p>There are currently no deals as of the moment</p>
        
        <?php } ?>
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
</body>
</html>
