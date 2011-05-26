<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo __(LBL_CITIES); ?></h2>
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
          <?php echo HTML::anchor('admin/cities/add', __(LBL_CITY_ADD), array('class' => 'addbutton')); ?>
        </div>
        
        <?php echo ($no_pager == TRUE) ? '' : $paging->render(); ?>
        
        <table class="table">
        <thead>
        <tr>
          <td><?php echo __(LBL_ACTION); ?></td>
          <td width="90"><?php echo __(LBL_ORDER); ?></td>
          <td width="400"><?php echo __(LBL_CITY); ?></td>
          <td width="90"><?php echo __(LBL_SUBSCRIBERS); ?></td>
          <td width="90"><?php echo __(LBL_DEALS_SOLD); ?></td>
          <td width="90"><?php echo __(LBL_AMOUNT_SOLD); ?></td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($cities as $city) {
					$edit_url = HTML::anchor('admin/cities/edit/' . $city['ID'], __(LBL_EDIT));
					$delete_url = HTML::anchor('admin/cities/delete/' . $city['ID'], __(LBL_DELETE), array('class' => 'delete'));
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
					echo '<td>' . $city['order'] . '</td>';
					echo '<td><b>' . $city['name'] . '</b></td>';
					echo '<td>' . ORM::factory('city')->get_subscribers($city['ID']) . '</td>';
					echo '<td>' . ORM::factory('order')->count_orders_by_city((int)$city['ID']) . '</td>';
					echo '<td>' . ORM::factory('order')->orders_sales_by_city((int)$city['ID']) . ' <span class="currency">DKK</span> </td>';
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