<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>

	<!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">

			<div id="htitle">
				<h2>Thank You!</h2>
			</div>

			<div id="myforms">
        
				<h2>Your text goes here. You can input what ever you want to input!</h2>
        
        <p>This is an example paragraph that will be visible in this area. Just put in here whatever you wish to put in here.</p>
				
        <h3 style="font-size: 11px; margin-bottom: 10px;"><span class="special-headers">YOUR PURCHASE RECEIPT</span></h3>

				<p><b>Customer Name: </b><?php echo $name; ?><br />
        	<b>Email: </b><?php echo $email; ?>
        </p>
        <table id="order-deal" style="width: 100%;">
								<thead>
					<tr>
						<td>Item</td>
						<td colspan="2">Quantity</td>
						<td colspan="2">Price</td>
						<td>Total</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $title; ?></td>
						<td><?php echo $quantity; ?> </td>
            <td style="width:5px; font-size: 13px; color: #999;">x</td>
						<td>$ <span id="price"><?php echo $price; ?></span></td>
            <td style="width:5px; caption-side: #999;">=</td>
						<td>$ <span id="tprice"><?php echo ($quantity * $price); ?></span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">Total : </td>
						<td width="140">$ <span id="totalamount"><?php echo ($quantity * $price); ?></span></td>
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