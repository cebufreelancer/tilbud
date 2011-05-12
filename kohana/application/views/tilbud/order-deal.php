<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div style="display:none">
	<div id="loginform2"><?php include 'login.php'; ?></div>
</div>        

<?php require_once 'header.php'; ?>

	<!-- content starts here -->
  <section id="ad-body">
  	<div class="centered">

			<div id="htitle">

				<h2><?php echo LBL_YOUR_PURCHASE?></h2>
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
				
				<?php require_once 'menu-user.php'; ?>
					
				<?php //echo '<pre>'; print_r($_SERVER); echo '</pre>'; 
				$form = new Appform();

				if(isset($errors)) {
					 $form->errors = $errors;
				}
				
				$deal_title = $deal->title;
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
				<?php echo Form::open(Request::current(), array('id' => 'myforms')); ?>
				<table id="order-deal" style="width:800px">
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
						<td><?php echo $deal_title; ?>
            	<div style="font-size: 11px; font-weight: normal; color: #999999;"><?php echo $deal->contents_title; ?>
            </td>

						<td><?php echo Form::select('quantity', isset($quantity) ? $quantity : array(1=>1), 0, array('autofocus' => true)); ?> </td>
            <td style="width:5px; font-size: 13px;">x</td>
						<td> <span id="price"><?php echo $price; ?></span> <span class="currency">DKK</span>
									<?php echo Form::hidden('price', isset($price) ? $price : 1); ?></td>
            <td style="width:5px;">=</td>
						<td> <span id="tprice"><?php echo isset($total) ? $total : 1; ?></span> <span class="currency">DKK</span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>

						<td colspan="5"><?php echo __(LBL_MY_PRICE); ?> : </td>
						<td width="140"><span id="totalamount"><?php echo isset($tamount) ? $tamount : 1; ?></span> DKK</td>

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

        
        <div style="float: right; position: relative; height: 250px; width: 300px; background-color: #EDEDED; left: -50px">
          <div style="text-align: center; margin: auto 0; padding: 15px">
            <p><?php echo LBL_ALREADY_HAVE_ACCOUNT ?></p>
            <br/>
            <p><?php echo LBL_ALREADY_PURCHASED ?></p>
            <br/>
            <p> 
              <div  style="background-color: gray; width: 100px; margin-right: auto; margin-left: auto">
      	        <?php echo HTML::anchor('#loginform2', LBL_LOGIN, array('id' => 'login2')); ?>
              </div>
            </p>
          </div>
        </div>
        
				<h2><?php echo __(LBL_PAYMENT_METHOD); ?><br />&nbsp;</h2>
				
        <?php if(Auth::instance()->logged_in() == false) { 
								$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
								$email = isset($_POST['email']) ? $_POST['email'] : '';
				?>
          <h3 style="margin-bottom: 10px;"><span class="special-headers"><?php echo LBL_PERSONAL_INFORMATION?></span></h3>
          <h3> <?php echo LBL_CREATE_ACCOUNT ?> </H3>
          <ul>
            <li><?php echo $form->label('fullname', __(LBL_FULLNAME)); ?>
                <?php echo $form->input('fullname', ucwords($fullname), array('placeholder' => LBL_YOUR_NAME_HERE,
																																							'required' => true)); ?>
                <?php echo isset($errors['fullname']) ? $errors['fullname'] : ''; ?>
            </li>
            <li><?php echo $form->label('email', __(LBL_EMAIL)); ?>
                <?php echo $form->input('email', $email, array('placeholder' => 'youremail@website.com',
																															 'required' => true,
																															 'type' => 'email',
																															 'style' => 'width: 500px;')); ?>
                <?php echo isset($errors['fullname']) ? $errors['fullname'] : ''; ?>
            </li>
            <li><?php echo $form->label('password', __(LBL_PASSWORD)); ?>
                <?php echo Form::password('password', NULL, array('style' => 'width: 215px;',
																																	'required' => true)); ?> (confirm) 
								<?php echo Form::password('password_confirm', NULL, array('style' => 'width: 215px;',
																																					'required' => true)); ?>
                <?php echo isset($errors['password_confirm']) ? '<br />' . $errors['password_confirm'] : ''; ?>
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
				$expiry_year = $year;
				$mo = range(1,12);
				$expiry_month = 1;
				$address = isset($_POST['address']) ? $_POST['address'] : '';
				$city = isset($_POST['city']) ? $_POST['city'] : '';;
				$state = isset($_POST['state']) ? $_POST['state'] : '';
				$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
				?>
				

				<h3 style="margin-bottom: 10px;"><span class="special-headers"><?php echo __(LBL_Billing_Info); ?></span></h3>
				<ul>
          <li><?php echo $form->label('cardname', __(LBL_CARDHOLDER)); ?>
              <?php echo $form->input('cardname', ucwords($cardname), array('required' => true)); ?>
          </li>
          <li><?php echo $form->label('cardnumber', __(LBL_CARDNUMBER)); ?>
              <?php echo Form::input('cardnumber', ucwords($cardnumber), array('style' => 'width: 348px; letter-spacing: 5px;',
																																							 'required' => true)) .  
                    ' ' . __(LBL_SECURITY_CODE) . ' ' .

                    Form::input('cardcode', $cardcode, array('style' => 'width: 50px',
                                                             'maxlength' => 3,
                                                             'size' => 3,
																														 'required' => true,
																														 'pattern' => '[0-9]*')); ?>
          </li>
          <li><?php echo $form->label('expiry_year', __(LBL_EXPIRATION_DATE)); ?>
              <?php echo Form::select('expiry_month', $mo, $expiry_month) . ' ' . Form::select('expiry_year', $years, $expiry_year); ?>
          </li>
          <li><?php echo $form->label('address', __(LBL_BILLING_ADDRESS)); ?>
              <?php echo $form->input('address', ucwords($address), array('required' => true)); ?>
          </li>
          <li><?php echo $form->label('city', __(LBL_CITY)); ?>
              <?php echo $form->input('city', ucwords($city), array('required' => true)); ?>
          </li>
          <li>
              <!-- hide for now
              <?php echo $form->label('state', __(LBL_STATE_PROVINCE)); ?>              
              <?php echo Form::input('state', ucwords($state), array('style' => 'width: 375px;')) ; ?>
              -->
              
              <?php echo $form->label('state', __(LBL_ZIPCODE)); ?>
              <?php echo Form::input('zipcode', ucwords($zipcode), array('size' => 5, 
																																		'maxlength' => 5, 
																																		'style' => 'width: 60px;',
																																		'required' => true,
																																		'pattern' => '[0-9]*')); ?>
          </li>
          <li>

            <a id="iterms2" class="homelink" href="<?php echo url::base(true) . "ipages?p=terms"; ?>"> <?php echo LBL_READ_TERMS_CONDITIONS ?></a>
          </li>
          <li>
            <?php echo $form->submit(NULL, __(LBL_COMPLETE_ORDER),array('class' => 'addbutton')); ?>
          </li>
        </ul>
        <?php 
				echo $form->hidden('did', $deal->ID);
				echo $form->close(); 
				?>
				
			</div>

		</div>
  </section>
			
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>