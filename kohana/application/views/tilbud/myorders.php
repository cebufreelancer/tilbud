<div id="htitle">
  <h2><?= $header ?></h2>
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
  	<?php echo HTML::anchor('user/myaccount', LBL_My_Account, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/billing', LBL_Billing_Info, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/orders', LBL_My_Orders, array('class' => 'addbutton')); ?>
  </div>

	<?php 
  
  if(!empty($orders)) {
    echo ($show_pager) ? $paging->render() : ''; ?>
  
    <table class="table">
    <thead>
    <tr>
      <td width="550"><?php echo LBL_ORDERED_DEAL; ?></td>
      <td><?php echo LBL_QUANTITY; ?></td>
      <td><?php echo LBL_PAID; ?></td>
      <td><?php echo LBL_STATUS; ?></td>
      <td width="120"><?php echo LBL_DATE_CREATED; ?></td>
    </tr>
    </thead>
    <tbody class="order-table">
    <?php
    // TODO: Create a view datatable where user 
    //	details and deal details are already queried
    $total = 0;
    foreach($orders as $order) {
      $view_url = HTML::anchor('admin/orders/edit/' . $order['ID'], 'View');
      $total += $order['total_count'];
      echo '<tr>';
      echo '<td><b>' . ORM::factory('deal', $order['deal_id'])->title . '</b>' . 
             '<div>' . ORM::factory('user', $order['user_id'])->firstname . ' ' . ORM::factory('user', $order['user_id'])->lastname . '</div>' .
             '<div>' . $view_url . '</div>' .
           '</td>';
      echo '<td align="center">' . $order['quantity'] . '</td>';
      echo '<td align="right">' . $order['total_count'] . '</td>';
      echo '<td>' . ucwords($order['status']) . '</td>';
      echo '<td>' . date("M j, Y", strtotime($order['date_created'])) . '</td>';
      echo '</tr>';
    }		
    ?>
    </tbody>
    <tfoot>
    </tfoot>
    </table>
  
  	<p style="font-size: 18px; font-weight: bold; color: #090;"><?php echo LBL_TOTAL . ' : ' . $total; ?>
  <?php 
    echo ($show_pager) ? $paging->render() : ''; 
  } else { ?>
    <p>You have not made any purchases as of the moment.</p>
  <?php } ?>

</div>  