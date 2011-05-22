<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo __(LBL_DEALS); ?></h2>
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
          <?php echo HTML::anchor('admin/deals/add', __(LBL_DEALS_ADD), array('class' => 'addbutton')); ?>
        </div>

				<?php
				$filters = array('deals' => __(LBL_DEALS),
												 'startdate' => __(LBL_DEAL_START_DATE),
												 'enddate' => __(LBL_DEAL_END_DATE),
												 'date' => __(LBL_DEAL_START_DATE) .'-'. __(LBL_DEAL_END_DATE));
				
				echo Form::open(Url::base(TRUE) . 'admin/deals', array('method' => 'get'));
					echo Form::label('show_order', __(LBL_ORDER_SEARCH));
					echo Form::input('s', '', array('id' => 'search_string', 'class' => 'field', 'style' => 'width: 230px;'));
					echo Form::input('df', '', array('id' => 'datefrom', 'class' => 'field', 'style' => 'width: 130px; display: none;'));
					echo Form::input('dt', '', array('id' => 'dateto', 'class' => 'field', 'style' => 'width: 130px; display: none;'));
					echo Form::select('f', $filters, NULL, array('id' => 'search_filter'));
					echo Form::submit(NULL, __(LBL_SEARCH));
				echo Form::close(); 
				?>
        <script type="text/javascript">
					$(function() {
						var dates = $( "#datefrom, #dateto" ).datepicker({
							defaultDate: "+1w",
							changeMonth: true,
							dateFormat: "yy-mm-dd",
							numberOfMonths: 3,
							onSelect: function( selectedDate ) {
								var option = this.id == "datefrom" ? "minDate" : "maxDate",
									instance = $( this ).data( "datepicker" ),
									date = $.datepicker.parseDate(
										instance.settings.dateFormat ||
										$.datepicker._defaults.dateFormat,
										selectedDate, instance.settings );
								dates.not( this ).datepicker( "option", option, date );
							}
						});
					});
					$("#search_filter").change(function() {
						if($(this).val() == 'date' || $(this).val() == 'startdate' || $(this).val() == 'enddate') {
							$("#datefrom").fadeIn('slow');
							$("#dateto").fadeIn('slow');
							$("#search_string").hide('fast');
						} else {
							$("#datefrom").hide();
							$("#dateto").hide();
							$("#search_string").show();
						}
					});
				</script>

				<?php				
				if(!empty($cities)) {
					$cities[0] = "";
					$categories[0] = "";
					
					ksort($cities);
					ksort($categories);
	
					echo Form::open(Url::base(TRUE) . 'admin/deals', array('style' => 'margin-bottom: 25px;',
																																	'method' => 'GET'));
						echo Form::label('show_city', __(LBL_SHOW_CITY));
						echo Form::select('cid', $cities, 0);
						echo Form::select('gid', $categories, 0);
						echo Form::submit(NULL, __(LBL_GO));
					echo Form::close(); 
				} ?>

				<?php 
				// Display query string result for searches
				if(isset($query_result)) { echo "<p><i>$query_result</p></i>"; } 
				?>

        <?php 
				if(!empty($deals)) {
					echo ($show_pager) ? $paging->render() : ''; ?>
	
					<table class="table" >
					<thead>
					<tr>
						<td><?php echo __(LBL_TITLE); ?></td>
            <td><?php echo __(LBL_GROUP); ?></td>
						<td><?php echo __(LBL_DEAL_START_DATE); ?></td>
            <td><?php echo __(LBL_DEAL_END_DATE); ?></td>
						<td><?php echo __(LBL_DEALS_SOLD); ?></td>
						<td><?php echo __(LBL_STATUS); ?></td>
						<td><?php echo __(LBL_DATE_CREATED); ?></td>
					</tr>
					</thead>
					<tbody class="order-table">
					<?php
					foreach($deals as $deal) {
					  $serving_css= "";

					  if (strftime( "%Y-%m-%d" , strtotime($deal['start_date'])) == date('Y-m-d')) {
					    $serving_css = 'style="background-color: #FFFFCC"';
					  }else {
					    $serving_css = "";
					  }
					  
						$edit_url = HTML::anchor('admin/deals/edit/' . $deal['ID'], __(LBL_EDIT));
						$delete_url = HTML::anchor('admin/deals/delete/' . $deal['ID'], __(LBL_DELETE), array('class' => 'delete'));
						$email_url = HTML::anchor('admin/deals?action=email&city=' . $deal['city_id'] . '&did=' . $deal['ID'], 'Send Email');
						$group = ORM::factory('category', $deal['group_id'])->name;
						echo '<tr ' . $serving_css . '>';
						echo '<td style="width:400px;"><b>' . $deal['description'] . '</b>' .
						     '<div>' . $edit_url . ' | ' . $delete_url . ' | ' . $email_url . '</div>' .
						     '</td>';
						echo '<td>' . $group . '</td>';
						echo '<td>' . date("F d, Y", strtotime($deal['start_date'])) . '</td>';
						echo '<td>' . date("F d, Y", strtotime($deal['end_date'])) . '</td>';
						echo '<td align="center">' . $deal['total_sold'] . '</td>';
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
