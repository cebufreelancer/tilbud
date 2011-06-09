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
				
				// Section Search
				$filters = array('email' => __(LBL_EMAIL),
												 'name' => __(LBL_FULLNAME),
												 'order' => __(LBL_ORDER));
				
				echo Form::open(Url::base(TRUE) . 'admin/users', array('style' => 'margin-top: 10px;'));
					echo Form::label('show_city', __(LBL_USER_SEARCH));
					echo '<div id="">';
					echo Form::input('search_string', '', array('class' => 'field', 'style' => 'width: 230px;'));
					echo Form::select('search_filter', $filters);
					echo Form::submit(NULL, __(LBL_SEARCH));
					echo '</div>';
				echo Form::close(); 

				// Section for Cities Filter
				if(!empty($cities)) {
					$cities[0] = "";				
					ksort($cities);

					echo Form::open(Url::base(TRUE) . 'admin/users', array('style' => 'margin-top: 10px;'));
						echo Form::label('show_city', __(LBL_SHOW_CITY));
						echo Form::select('show_city', $cities, $group, array('onChange' => 'javascript:submit(); return true;'));
					echo Form::close(); 
				}

				// Display Admin Types
				$admin_label = '<b>' . __(LBL_USER_ADMIN) . '</b> ( ' . $admin_count . ' )';
				$member_label = '<b> ' . __(LBL_USER_MEMBER) . '</b> ( ' . $member_count . ' )';
				$all_label = '<b>' . __(LBL_USER_ALL) . '</b> ( ' . ($admin_count + $member_count) . ' )';
				echo Html::anchor('/admin/users/', $all_label, array('class' => 'user-url')) . ' | ';
				echo Html::anchor('/admin/users/?show=admin', $admin_label, array('class' => 'user-url')) . ' | ';
				echo Html::anchor('/admin/users/?show=member', $member_label, array('class' => 'user-url'));
				       
				// Display query string result for searches
				if(isset($query_result)) { echo "<p><i>$query_result</p></i>"; } 

				if(!empty($users)) {
					echo ($show_pager) ? $paging->render() : ''; ?>
        
          <table class="table">
          <thead>
          <tr>
            <td><?php echo __(LBL_ACTION); ?></td>
            <td><?php echo __(LBL_EMAIL); ?></td>
            <td><?php echo __(LBL_CITY); ?></td>
            <td><?php echo __(LBL_USER_TYPE); ?></td>
            <td><?php echo __(LBL_JOINED); ?></td>
            <td><?php echo __(LBL_LAST_LOGIN); ?></td>
          </tr>
          </thead>
          <tbody>
          <?php
          foreach($users as $user) {
            $cur_user = ORM::factory('user', $user['id']);
            $edit_url = HTML::anchor('admin/users/edit/' . $user['id'], __(LBL_EDIT));
            $delete_url = HTML::anchor('admin/users/delete/' . $user['id'], __(LBL_DELETE), array('class' => 'delete'));
            $last_login = $user['last_login'] == NULL ? __(LBL_NEVER) : date("F j, Y",$user['last_login']);
            $is_admin = $cur_user->is_admin($cur_user) ? __(LBL_USER_ADMIN) : __(LBL_USER_MEMBER);
            $city = $cur_user->get_city($cur_user->email);
						
						if(isset($_GET['show'])) {
							if($cur_user->is_admin($cur_user) && $_GET['show'] == 'admin') {
								echo '<tr>';
								echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
								echo '<td><b>' . $user['email'] . '</b><br /><span style="font-size: 11px;">' . $user['firstname'] . ' ' . $user['lastname'] . 
										 '<br />' . $user['address'] . '</span></td>';
								echo '<td>' . $city . '</td>';
								echo '<td>' . $is_admin . '</td>';
								echo '<td>' . date("F j, Y",strtotime($user['created'])) . '</td>';
								echo '<td>' . $last_login . '</td>';
			
								echo '</tr>';
							} else if (!$cur_user->is_admin($cur_user) && $_GET['show'] == 'member') {
								echo '<tr>';
								echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
								echo '<td><b>' . $user['email'] . '</b><br /><span style="font-size: 11px;">' . $user['firstname'] . ' ' . $user['lastname'] . 
										 '<br />' . $user['address'] . '</span></td>';
								echo '<td>' . $city . '</td>';
								echo '<td>' . $is_admin . '</td>';
								echo '<td>' . date("F j, Y",strtotime($user['created'])) . '</td>';
								echo '<td>' . $last_login . '</td>';
			
								echo '</tr>';
							}
						} else {
							echo '<tr>';
								echo '<td>' . $edit_url . ' ' . $delete_url . '</td>';
								echo '<td><b>' . $user['email'] . '</b><br /><span style="font-size: 11px;">' . $user['firstname'] . ' ' . $user['lastname'] . 
										 '<br />' . $user['address'] . '</span></td>';
								echo '<td>' . $city . '</td>';
								echo '<td>' . $is_admin . '</td>';
								echo '<td>' . date("F j, Y",strtotime($user['created'])) . '</td>';
								echo '<td>' . $last_login . '</td>';
			
								echo '</tr>';
						}
          }		
          ?>
          </tbody>
          </table>
          <?php echo ($show_pager) ? $paging->render() : ''; ?>
          <br/>
          <div> Total number of users: <?php echo $paging->total_items; ?></div>
          
        <?php } else { ?>
          <p><?php echo __(LBL_USER_EMPTY); ?></p>
        <?php } ?>
        
      </div>
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>