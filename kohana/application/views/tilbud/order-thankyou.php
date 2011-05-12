<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>

	<!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">

			<div id="htitle">
				<h2><?php echo __(LBL_THANK_YOU); ?></h2>
			</div>

			<div id="myforms">
        
				<h2><?php echo __(LBL_ORDER_FINISH_HEADER); ?></h2>
        
        <p><?php echo __(LBL_ORDER_FINISH_DESCRIPTION); ?></p>
				
        <h3 style="font-size: 11px; margin-bottom: 10px;"><span class="special-headers"><?php echo __(LBL_PURCHASE_RECEIPT); ?></span></h3>

				<p><b><?php echo __(LBL_CUSTOMER_NAME); ?>: </b><?php echo $name; ?><br />
        	<b><?php echo __(LBL_EMAIL); ?>: </b><?php echo $email; ?>
        </p>
        <table id="order-deal" style="width: 100%;">
								<thead>
					<tr>
						<td><?php echo __(LBL_YOUR_DEAL); ?></td>
						<td colspan="2"><?php echo __(LBL_QUANTITY); ?></td>
						<td colspan="2"><?php echo __(LBL_PRICE); ?></td>
						<td><?php echo __(LBL_TOTAL); ?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $title; ?>
            		<div style="font-size: 11px; font-weight: normal; color: #999999;"><?php echo $contents_title; ?></div>
            </td>
						<td><?php echo $quantity; ?> </td>
            <td style="width:5px; font-size: 13px; color: #999;">x</td>
						<td>$ <span id="price"><?php echo $price; ?></span></td>
            <td style="width:5px; caption-side: #999;">=</td>
						<td>$ <span id="tprice"><?php echo ($quantity * $price); ?></span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5"><?php echo __(LBL_TOTAL); ?> : </td>
						<td width="140"><span id="totalamount"><?php echo ($quantity * $price); ?></span> <span class="currency">DKK</span></td>
					</tr>
				</tfoot>
				</table>
				
			</div>

		</div>
  </section>
			
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>