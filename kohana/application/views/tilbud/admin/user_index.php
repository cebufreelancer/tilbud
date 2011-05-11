<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	   	
      <div id="htitle">
      	<h2><?php echo __(LBL_USERS); ?></h2>
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
          <?php echo HTML::anchor('admin/users/add', __(LBL_USER_ADD), array('class' => 'addbutton')); ?>
        </div>
        
        <?php				
				if(!empty($categories)) {
					$categories = array_merge(array("0" => "All"), $categories);
	
					echo Form::open(Url::base(TRUE) . 'admin/users', array('style' => 'margin-top: 10px;'));
						echo Form::label('show_group', __(LBL_SHOW_GROUP));
						echo Form::select('show_group', $categories, $group, array('onChange' => 'javascript:submit(); return true;'));
					echo Form::close(); 
				} ?>
        
        <?php echo ($show_pager) ? $paging->render() : ''; ?>
        
        <table class="table">
        <thead>
        <tr>
          <td><?php echo __(LBL_ACTION); ?></td>
          <td><?php echo __(LBL_EMAIL); ?></td>
          <td><?php echo __(LBL_GROUP); ?></td>
          <td><?php echo __(LBL_USER_TYPE); ?></td>
          <td><?php echo __(LBL_JOINED); ?></td>
          <td><?php echo __(LBL_LAST_LOGIN); ?></td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($users as $user) {
					$cur_user = ORM::factory('user', $user['id']);
					$edit_url = HTML::anchor('admin/users/edit/' . $user['id'], 'Edit');
					$delete_url = HTML::anchor('admin/users/delete/' . $user['id'], 'Delete');
					$last_login = $user['last_login'] == NULL ? 'Never' : date("F j, Y",$user['last_login']);
					$is_admin = $cur_user->is_admin($cur_user) ? 'Admin' : 'Member';
					$group = ORM::factory('category', $user['group_id'])->name;
          echo '<tr>';
          echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
          echo '<td><b>' . $user['email'] . '</b><br /><span style="font-size: 11px;">' . $user['firstname'] . '</span></td>';
					echo '<td>' . $group . '</td>';
					echo '<td>' . $is_admin . '</td>';
          echo '<td>' . date("F j, Y",strtotime($user['created'])) . '</td>';
          echo '<td>' . $last_login . '</td>';

          echo '</tr>';
        }		
        ?>
        </tbody>
        </table>
        <?php echo ($show_pager) ? $paging->render() : ''; ?>
        <br/>
        <div> Total number of users: <?php echo $paging->total_items; ?></div>
                
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>