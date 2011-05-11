<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2>Users</h2>
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
          <?php echo HTML::anchor('admin/users/add', 'Add a User', array('class' => 'addbutton')); ?>

<!-->          
          <div id="search-form">
            <div>SEARCH: </div>
            <div>
              <form method="post" action="">
              <div> <?= LBL_CITY ?> : <?php echo Form::select('deal_city', $cities); ?> </div>
              <div> <?= LBL_GROUP ?> : <?php echo Form::select('deal_categories', $categories); ?> </div>
              <div> who have paid : <input type="checkbox" value="1" name="whobuy"> </div>
              <div> who sign up for newsletter : <input type="checkbox" value="1" name="whosignup"> </div>
              <div> <input type="submit" name="submit" value="Search"> </div>
              </form>
            </div>
          </div>
-->          
          
        </div>

        <?php echo ($show_pager) ? $paging->render() : ''; ?>

        <table class="table">
        <thead>
        <tr>
          <td>Action</td>
          <td>Username</td>
          <td>Joined</td>
          <td>Status</td>          
          <td>Last Login</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($users as $user) {
					$edit_url = HTML::anchor('admin/users/edit/' . $user['id'], 'Edit');
					$delete_url = HTML::anchor('admin/users/delete/' . $user['id'], 'Delete');
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $user['username'] . '</b></td>';
					echo '<td>' . $user['status'] . '</td>';
          echo '<td>' . date("F j, Y",strtotime($user['created'])) . '</td>';
          echo '<td>' . date("F j, Y",$user['last_login']) . '</td>';
          echo '</tr>';
        }		
        ?>
        </tbody>
        </table>
        <div> <?php echo sizeof($users); ?></div>
        <?php echo ($show_pager) ? $paging->render() : ''; ?>
        
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
</body>
</html>