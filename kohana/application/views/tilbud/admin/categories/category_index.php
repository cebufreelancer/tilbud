<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo ucwords(strtolower(__(LBL_GROUPS))); ?></h2>
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
          <?php echo HTML::anchor('admin/groups/add', __(LBL_GROUP_ADD), array('class' => 'addbutton')); ?>
        </div>
        
        <?php echo ($no_pager == TRUE) ? '' : $paging->render(); ?>
        
        <table class="table">
        <thead>
        <tr>
          <td><?php echo __(LBL_ACTION); ?></td>
          <td width="300"><?php echo __(LBL_GROUPS); ?></td>
          <td width="90"><?php echo __(LBL_DEALS_SOLD); ?></td>
          <td width="90"><?php echo __(LBL_AMOUNT_SOLD); ?></td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($categories as $cat) {
					$edit_url = HTML::anchor('admin/groups/edit/' . $cat['ID'], __(LBL_EDIT));
					$delete_url = HTML::anchor('admin/groups/delete/' . $cat['ID'], __(LBL_DELETE), array('class' => 'delete'));
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $cat['name'] . '</b></td>';
					echo '<td>' . ORM::factory('order')->count_orders_by_category($cat['ID']) . '</td>';
					echo '<td>' . ORM::factory('order')->orders_sales_by_category($cat['ID']) . ' <span class="currency">DKK</span></td>';
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
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>