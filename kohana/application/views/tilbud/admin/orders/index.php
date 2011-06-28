<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo __(LBL_ORDERS); ?></h2>
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

        <?php
				$filters = array('email' => __(LBL_EMAIL),
												 'name' => __(LBL_FULLNAME),
												 'order' => __(LBL_ORDER),
												 'refno' => __(LBL_REFERENCE_NO),
												 'date' => __(LBL_DATE));
				
				echo Form::open(Url::base(TRUE) . 'admin/orders', array('method' => 'get'));
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
						if($(this).val() == 'date') {
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
					$cities[0] = __(LBL_CITY);
					$categories[0] = __(LBL_GROUP);
					
					ksort($cities);
					ksort($categories);
	
					echo Form::open(Url::base(TRUE) . 'admin/orders', array('style' => 'margin-bottom: 25px;',
																																	'method' => 'GET'));
						echo Form::label('show_city', __(LBL_SHOW_CITY));
						echo Form::select('cid', $cities, 0);
						echo Form::select('gid', $categories, 0);
						echo Form::select('status', $status, 0);
						echo Form::submit(NULL, __(LBL_GO));
					echo Form::close(); 
				} ?>
        
				<?php 
				// Display query string result for searches
				if(isset($query_result)) { echo "<p><i>$query_result</p></i>"; } 
				?>
        
       	<?php 
				if(!empty($orders)) {
					echo ($show_pager) ? $paging->render() : '';
					
					echo Form::open(Url::base(TRUE) . 'admin/orders/process', array('id' => 'actionForm')); ?>					
          <table class="table">
          <thead>
          <tr id="actionPanel" style="display:none;">
          	<td colspan="7" style="text-align:left; padding: 5px 10px;">
            	<?php 
							
							echo Form::select('status', $status, 0, array('class' => 'actionButton')) . Form::submit('action', 'Set', array('class' => 'actionButton'));
							echo " " . Form::submit('action', __(LBL_SEND_EMAIL), array('class' => 'actionButton'));
							echo " " . Form::submit('action', __(LBL_DELETE), array('class' => 'actionButton'));
							echo " " . Form::submit('action', __(LBL_MARKED_AS_REFNO_PAID), array('class' => 'actionButton'));
							?> 
            </td>
          </tr>
          <tr>
          	<td style="width:5px;"><?php echo Form::checkbox('obox_all', '', '',array('id' => 'obox_all')); ?></td>
            <td width="450"><?php echo LBL_ORDERED_DEAL; ?></td>
            <td width="100">REF</td>
            <td><?php echo LBL_QUANTITY; ?></td>
            <td width="120"><?php echo LBL_PAID; ?></td>
            <td><?php echo LBL_STATUS; ?></td>
            <td><?php echo LBL_REF_STATUS; ?></td>
            <td width="120"><?php echo LBL_ORDER_DATE; ?></td>
          </tr>
          </thead>
          <tbody>
          <?php
					// TODO: Create a view datatable where user 
					//	details and deal details are already queried
					$total = 0;
          foreach($orders as $order) {
            $edit_url = HTML::anchor('admin/orders/edit/' . $order['ID'], __(LBL_EDIT));
            $delete_url = HTML::anchor('admin/orders/delete/' . $order['ID'], __(LBL_DELETE), array('class' => 'delete'));
						$total += $order['total_count'];
						
						if ($order['is_claimed'] == "1") {
						  $ref_status = __(LBL_USED);
						}else if ($order['is_claimed'] == "2") {
						  $ref_status = __(LBL_PAID);
						}else{
						  $ref_status = __(LBL_NOT_USED);
						}

						if ($order['is_claimed'] == "1") {
						  $ref_class = "style=\"color: green; font-weight: bold\"";
						}else if ($order['is_claimed'] == "2") {
						  $ref_class = "style=\"color: orange; font-weight: bold\"";
						}else{
						  $ref_class = "style=\"color: gray; font-weight: normal\"";
						}
						


						switch($order['status']) {
						case 'delivered': $status = __(LBL_ORDER_DELIVERED); $class = 'bblue'; break;
						case 'notreached': $status = __(LBL_ORDER_NOTREACHED); $class = 'bwarm'; break;
						case 'cancelled': $status = __(LBL_CANCELLED); $class = 'bred'; break;
						case 'new': $status = __(LBL_ORDER_NEW); $class = 'blime'; break;
						}
						
            echo '<tr>';
						echo '<td style="width: 5px;">' . Form::checkbox('obox[]', $order['ID'], $order['ID'], array('id' => $order['ID'])) . '</td>';
            echo '<td>' . ORM::factory('deal', $order['deal_id'])->description . 
									 '<div><b>' . ORM::factory('user', $order['user_id'])->firstname . ' ' . ORM::factory('user', $order['user_id'])->lastname . '</b></div>' .
									 '<div>' . $edit_url . ' | ' . $delete_url . '</div>' .
								 '</td>';
						echo '<td>' . $order['refno'] . '</td>';
            echo '<td align="center">' . $order['quantity'] . '</td>';
            echo '<td align="right">' . $order['total_count'] . ' <span class="currency">DKK</span></td>';
            echo '<td class="' . $class . '">' . ucwords($status) . '</td>';
            echo '<td ' . $ref_class . '>' . ucwords($ref_status) . '</td>';
            echo '<td>' . date("M j, Y", strtotime($order['date_created'])) . '</td>';
            echo '</tr>';
          }		
          ?>
          </tbody>
          <tfoot>
          <tr>
          	<td colspan="5" align="right"><span style="font-size: 18px; font-weight: bold;"><?php echo LBL_TOTAL; ?></span></td>
            <td colspan="2" align="center"><span style="font-size: 22px; font-weight: bold;"><?php echo $total; ?> DKK</span></td>
          </tr>
          </tfoot>
          </table>
        	<?php echo Form::close(); ?>
        	<script type="text/javascript">
					$("#obox_all").click(function() { 
						$('[name="obox[]"]').attr("checked",$("#obox_all").attr("checked")); 
						showControl();
						if($('[name="obox[]"]').attr("checked")) {
							$('[name="obox[]"]').parent().parent().effect("highlight", {}, 3000);
						}
					});
					
					$('[name="obox[]"]').change(function() { 
						showControl();
						if($(this).attr("checked")) {
							$(this).parent().parent().effect("highlight", {}, 3000);
						}
					});
					
					function showControl() {
						var obox = $(this + ":checked").length;
						if(obox > 0) {
							$("#actionPanel").fadeIn("fast");
						} else {
							$("#actionPanel").fadeOut("slow");
						}
					}
					</script>
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