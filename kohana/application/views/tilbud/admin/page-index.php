<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo __(LBL_PAGES); ?></h2>
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
          <?php echo HTML::anchor('admin/pages/add', __(LBL_PAGE_ADD), array('class' => 'addbutton')); ?>
        </div>
        
        <?php echo $paging->render(); ?>
        
        <table class="table">
        <thead>
        <tr>
          <td><?php echo __(LBL_ACTION); ?></td>
          <td width="200"><?php echo __(LBL_PAGE_CODE); ?></td>
          <td><?php echo __(LBL_DESCRIPTION); ?></td>
          <td><?php echo __(LBL_URL); ?></td>          
          <td><?php echo __(LBL_LAST_UPDATE); ?></td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($pages as $page) {
					$edit_url = HTML::anchor('admin/pages/edit/' . $page['id'], __(LBL_EDIT));
					$delete_url = HTML::anchor('admin/pages/delete/' . $page['id'], __(LBL_DELETE), array('class' => 'delete'));
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $page['page_code'] . '</b></td>';
          echo '<td>' . substr($page['content'], 0, 50) . '</td>';
          echo '<td>/ipages?p=' . $page['page_code'] . '</td>';
          echo '<td>' . strftime("%Y-%m-%d", strtotime($page['updated_at'])) . '</td>';
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