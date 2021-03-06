<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH . 'views/tilbud/admin/header.php'; ?>
	
  <!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">
    	
      <div id="htitle">
      	<h2><?php echo $label; ?></h2>
      </div>
           
      <?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
			$status = array('new' => LBL_ORDER_NEW,
											'delivered' => LBL_ORDER_DELIVERED,
											'cancelled' => LBL_ORDER_CANCELLED,
											'notreached' => LBL_ORDER_NOTREACHED);
			?>
      
			<?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
      <ul id="order-view">
      	<li><?php echo Form::label('order_status', __(LBL_ORDER_DATE), array('class' => 'label')); ?>
        		<span class="lavalue"><?php echo date("M j, Y", strtotime($order_date_created)); ?></span>
            <div class="clear"></div>
      	<li><?php 
						echo Form::label('order_status', __(LBL_USER), array('class' => 'label')); ?>
        		<span class="lavalue"><?php echo Html::anchor('admin/users/edit/' . $order_user_id, $order_user, array('class' => 'blue')); ?></span>
            <div class="clear"></div>
        <li><?php echo Form::label('order_status', __(LBL_PRODUCT_DEAL), array('class' => 'label')); ?>
        		<span class="lavalue"><?php echo $order_deal_title; ?></span>
            <div class="clear"></div>
        <li><?php echo Form::label('order_status', __(LBL_QUANTITY), array('class' => 'label')); ?>
        		<span class="lavalue"><?php echo $order_quantity; ?></span>
            <div class="clear"></div>
        <li><?php echo Form::label('order_status', __(LBL_AMOUNT_PAID), array('class' => 'label')); ?>
        		<span class="lavalue"><?php echo $order_amount_paid; ?></span>
            <div class="clear"></div>
        <li><?php echo Form::label('order_status', __(LBL_STATUS), array('class' => 'label')); ?>
        		<?php echo Form::select('order_status', $status, $order_status); ?>
        </li>
        <li>
        	<?php echo Form::submit(NULL, __(LBL_SAVE), array('class' => 'addbutton')); ?>
          <?php echo HTML::anchor('admin/orders', LBL_CANCEL, array('class' => 'cancel',
																																	 'style' => 'font-size: 11px;')) ?>
        </li>
      </ul>
      <?php echo Form::close(); ?>
      
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/admin/footer.php'; ?>
  
</body>
</html>