<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Orders</h2>
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
          <?php //echo HTML::anchor('admin/vendors/add', 'Add a Vendor', array('class' => 'addbutton')); ?>
        </div>

       <?php 
				
				if(!empty($orders)) {
					echo ($show_pager) ? $paging->render() : ''; ?>

          <table class="table">
          <thead>
          <tr>
            <td>Action</td>
            <td>User</td>
            <td width="300">Deal</td>
            <td>Quantity</td>
            <td>Paid</td>
            <td>Status</td>
            <td>Date Created</td>
          </tr>
          </thead>
          <tbody>
          <?php
					// TODO: Create a view datatable where user 
					//	details and deal details are already queried
					$total = 0;
          foreach($orders as $order) {
            $edit_url = HTML::anchor('admin/vendors/edit/' . $order['ID'], 'Edit');
            $delete_url = HTML::anchor('admin/vendors/delete/' . $order['ID'], 'Delete');
						$total += $order['total_count'];
            echo '<tr>';
            echo '<td>' . /*$edit_url . ' ' . $delete_url .*/ '</td>';
            echo '<td><b>' . ORM::factory('user', $order['user_id'])->firstname . ' ' . ORM::factory('user', $order['user_id'])->lastname . '</b></td>';
            echo '<td>' . ORM::factory('deal', $order['deal_id'])->title . '</td>';
            echo '<td align="center">' . $order['quantity'] . '</td>';
            echo '<td align="right">' . $order['total_count'] . '</td>';
            echo '<td>' . $order['status'] . '</td>';
            echo '<td>' . date("M j, Y H:i:s", strtotime($order['date_created'])) . '</td>';
            echo '</tr>';
          }		
          ?>
          </tbody>
          <tfoot>
          <tr>
          	<td colspan="5" align="right"><span style="font-size: 18px; font-weight: bold;">TOTAL</span></td>
            <td colspan="2" align="center"><span style="font-size: 22px; font-weight: bold;">$ <?php echo $total; ?></span></td>
          </tr>
          </tfoot>
          </table>
        
        <?php 
					echo ($show_pager) ? $paging->render() : ''; 
				} else { ?>
        	<p>There are currently no orders as of the moment</p>
        <?php } ?>
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
</body>
</html>