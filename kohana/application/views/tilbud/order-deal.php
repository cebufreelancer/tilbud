<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>

	<!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">

			<div id="htitle">
				<h2>Your Purchase</h2>
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
					<?php echo HTML::anchor('user/myaccount', 'My Account', array('class' => 'addbutton')); ?>
					<?php echo HTML::anchor('user/billing', 'Billing Info', array('class' => 'addbutton')); ?>
					<?php echo HTML::anchor('#', 'My Orders', array('class' => 'addbutton')); ?>
					<?php echo HTML::anchor('#', 'My Deals', array('class' => 'addbutton')); ?>
				</div>
					
				<?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
				$form = new Appform();

				if(isset($errors)) {
					 $form->errors = $errors;
				}
				
				$qmin = isset($deal->min_buy) ? $deal->min_buy : 1;
				$qmax = isset($deal->max_buy) ? $deal->max_buy : 1;
				for($i=$qmin; $i<=$qmax; $i++) { $quantity[$i] = $i; }
				if(isset($deal->regular_price)) {
					$deal_price = ($deal->regular_price * (100 - $deal->discount)) / 100;
					$price = number_format($deal_price, 2, '.', '');
				} else {
					$price = 0;
				}
				$total = number_format(($qmin * $price), 2, '.', '');
				$tamount = number_format($total, 2, '.', '');
				
				?>
				<?php echo Form::open('user/login', array('id' => 'myforms')); ?>
				<table id="order-deal">
								<thead>
					<tr>
						<td>Your Deal</td>
						<td colspan="2">Quantity</td>
						<td colspan="2">Price</td>
						<td>Total</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'Two Tickets to Lehigh Valley Steelhawks in Bethlehem. Six Options Available.'; ?></td>
						<td><?php echo Form::select('quantity', isset($quantity) ? $quantity : array(1=>1)); ?> </td>
            <td style="width:5px; font-size: 13px;">x</td>
						<td>$ <span id="price"><?php echo $price; ?></span>
									<?php echo Form::hidden('price', isset($price) ? $price : 1); ?></td>
            <td style="width:5px;">=</td>
						<td>$ <span id="tprice"><?php echo isset($total) ? $total : 1; ?></span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">My Price : </td>
						<td width="140">$ <span id="totalamount"><?php echo isset($tamount) ? $tamount : 1; ?></span></td>
					</tr>
				</tfoot>
				</table>
        <script>
				$(document).ready(function(){
					$("[name='quantity']").change(function(){
						var quantity = $(this).val();
						var price = $("#price").html();
						total = (quantity * price);
						$("#totalamount").html(total.toFixed(2));
						$("#tprice").html(total.toFixed(2));
					});
				});
				</script>
				
        <?php
				$fullname = '';
				$email = '';
				?>
        
				<h2>Select Payment Method<br />&nbsp;</h2>
				
        <?php if(Auth::instance()->logged_in() == false) { ?>
          <h3 style="margin-bottom: 10px;"><span class="special-headers">Personal Information</span></h3>
          <ul>
            <li><?php echo $form->label('fullname', __('Full Name')); ?>
                <?php echo $form->input('fullname', ucwords($fullname)); ?>
            </li>
            <li><?php echo $form->label('email', __('Email')); ?>
                <?php echo $form->input('email', $email); ?>
            </li>
            <li><?php echo $form->label('password', __('Password')); ?>
                <?php echo Form::password('password', NULL, array('style' => 'width: 215px;')); ?> (confirm) <?php echo Form::password('confirm_password', NULL, array('style' => 'width: 215px;')); ?>
            </li>
            <li>&nbsp;</li>
          </ul>
        <?php } ?>
				<?php
				$cardname = '';
				$cardnumber = '';
				$cardcode = '';
				$year = (int)date("Y");
				$years = range($year, $year+10);
				$expiry_year = 2002;
				$mo = range(1,12);
				$expiry_month = 5;
				$address = '';
				$city = '';
				$state = '';
				$zipcode = '';
				?>
				
				<h3 style="margin-bottom: 10px;"><span class="special-headers">Billing Information</span></h3>
				<ul>
          <li><?php echo $form->label('cardname', __('Cardholder Name')); ?>
              <?php echo $form->input('cardname', ucwords($cardname)); ?>
          </li>
          <li><?php echo $form->label('cardnumber', __('Card Number')); ?>
              <?php echo Form::input('cardnumber', ucwords($cardnumber), array('style' => 'width: 348px; letter-spacing: 5px;')) .  
                    ' Security Code ' . 
                    Form::input('cardcode', $cardcode, array('style' => 'width: 50px',
                                                             'maxlength' => 3,
                                                             'size' => 3)); ?>
          </li>
          <li><?php echo $form->label('expiry_year', __('Expiration Date')); ?>
              <?php echo Form::select('expiry_month', $mo, $expiry_month) . ' ' . Form::select('expiry_year', $years, $expiry_year); ?>
          </li>
          <li><?php echo $form->label('address', __('Billing Address')); ?>
              <?php echo $form->input('address', ucwords($address)); ?>
          </li>
          <li><?php echo $form->label('city', __('City')); ?>
              <?php echo $form->input('city', ucwords($city)); ?>
          </li>
          <li><?php echo $form->label('state', __('State/Province')); ?>
              <?php echo Form::input('state', ucwords($state), array('style' => 'width: 375px;')) .
                    ' Zipcode ' .
                    Form::input('zipcode', ucwords($zipcode), array('size' => 5, 'maxlength' => 5, 'style' => 'width: 60px;')); ?>
          </li>
          <li>
            <?php echo $form->submit(NULL, __('Complete Order')); ?>
          </li>
        </ul>
        <?php echo $form->close(); ?>
				
			</div>

		</div>
  </section>
			
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>