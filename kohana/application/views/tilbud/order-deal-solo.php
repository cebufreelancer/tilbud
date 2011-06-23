<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<html>
<head>
	<script type="text/javascript" src="<?php echo url::base()?>js/jquery.min.js"></script>
  <link rel="stylesheet" media="all" href="<?php echo url::base(TRUE)?>css/main.css"/>
</head>
<body>
<!--
<div style="display:none">
	<div id="loginform2"><?php include 'login.php'; ?></div>
</div>

	<!-- content starts here -->
  <section id="ad-body"  style="padding: 0px; margin: 0px;">
  	<div class="centered" style="width: 650px; padding: 0px;">

			<div id="htitle" style="width: 650px;">
      	<ul id="order-menu">
        	<li id="step1" class="selected">1. Personlige oplysniger</li>
          <li id="step2">2. Betaling</li>
          <li id="step3">3. Kviterring</li>
        </ul>
      	<!-- <h2><?php echo LBL_YOUR_PURCHASE?></h2> -->
			</div>

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
				
				<?php echo Form::open(Request::current(), array('style' => 'width: 650px;')); ?>
        <div id="stepOne" class="order-container">
          <table id="order-deal" style="width:650px;">
            <tr>
              <td width="200"><?php echo __(LBL_QUANTITY) . ' ' . Form::select('quantity', isset($quantity) ? $quantity : array(1=>1), 0, array('autofocus' => true)); ?> </td>
              <td style="width:5px; font-size: 13px;">x</td>
              <td width="100"> <span id="price"><?php echo $price; ?></span> <span class="currency">DKK</span>
                    <?php echo Form::hidden('price', isset($price) ? $price : 1); ?></td>
              <td style="width:5px;">=</td>
              <td width="100" style="background: #EFF7B9;"> <span id="totalamount"><?php echo isset($total) ? $total : 1; ?></span> <span class="currency">DKK</span></td>
            </tr>
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
					$fname = isset($_POST['firstname']) ? $_POST['firstname'] : $user->firstname;
					$lname = isset($_POST['lastname']) ? $_POST['lastname'] : $user->lastname;
					$address = isset($_POST['address']) ? $_POST['address'] : $user->address;
					$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : $user->mobile;
					$city = isset($_POST['city']) ? $_POST['city'] : $user->get_city($user->email);
					$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
					
					?>
          
          <table id="order-table" class="left">
          	<tr>
            	<td><?php echo Form::label('firstname', __(LBL_FIRSTNAME)); ?><br />
								<?php echo Form::input('firstname', $fname, array('style' => 'width: 200px;', 'required' => true)); ?></td>
              <td><?php echo Form::label('lastname', __(LBL_LASTNAME)); ?><br />
								<?php echo Form::input('lastname', $lname, array('style' => 'width: 200px;', 'required' => true)); ?></td>
            </tr>
            <tr>
            	<td colspan="2">
              	<?php echo Form::label('address', __(LBL_ADDRESS)); ?><br />
								<?php echo Form::input('address', $address, array('style' => 'width: 100%;', 'required' => true)); ?></td>
            </tr>
            <tr>
              <td><?php echo Form::label('city', __(LBL_CITY)); ?><br />
									<?php echo Form::input('city', $city, array('style' => 'width: 200px;', 'required' => true)); ?></td>
              <td><?php echo Form::label('zipcode', __(LBL_ZIPCODE)); ?><br />
									<?php echo Form::input('zipcode', $zipcode, array('style' => 'width: 50px;', 'required' => true, 'maxlength' => 6)); ?></td>
            </tr>
            <tr>
            	<td colspan="2" style="padding:15px 0px;"><?php echo $user->email; ?></td>
            </tr>
            <tr>
            	<td colspan="2">
								<?php echo Form::label('mobile', __(LBL_MOBILE)); ?><br />
								<?php echo Form::input('mobile', $mobile, array('style' => 'width: 200px;', 'required' => true)); ?></td>
            </tr>
            <tr>
            	<td colspan="2" align="right" style="padding-top: 20px;">
								<?php echo Form::button('undo', __(LBL_UNDO), array('class' => 'addbutton', 'id' => 'undoButton')); ?>
              	<?php echo Form::button('paynow', __(LBL_PAY_NOW), array('class' => 'addbutton', 'id' => 'payButton')); ?>
              </td>
            </tr>
          </table>         
          <div class="right" style="width: 200px; padding: 5px;">
          	<h4>Du er ved at købe</h4>
            <p>The text goes here and here and here and here and booom!.</p>
            
            <h4>Betingelser</h4>
            <p>The text goes here and here and here and here and booom!.</p>
          </div>
          
          <div class="clear"></div>
				</div>
				
				<?php
				$year = (int)date("Y");
				$years = range($year, $year+10);
				$expiry_year = $year;
				$mo = range(01,12);
				$expiry_month = (int)date("n") - 1;
				$state = isset($_POST['state']) ? $_POST['state'] : '';
				?>
        <div id="stepTwo" class="order-container" style="display:none;">
        	<!-- <h3 style="margin-bottom: 10px;"><span class="special-headers"><?php echo __(LBL_Billing_Info); ?></span></h3> -->
        	<table id="order-table" class="left">
          	<tr>
            	<td width="120"></td>
              <td><?php echo HTML::image(Url::base(TRUE) . 'images/payment-logos.png', array('height' => 30)); ?></td>
            </tr>
            <tr>
            	<td><?php echo Form::label('cardtype', __(LBL_CARDTYPE)); ?></td>
              <td><?php echo Form::select('cardtype', $cardtypes); ?></td>
            </tr>
            <tr>
            	<td><?php echo Form::label('cardnumber', __(LBL_CARDNUMBER)); ?></td>
              <td><?php echo Form::input('cardnumber', ucwords($cardnumber), array('style' => 'width: 275px; letter-spacing: 5px;',
                                                                                 'required' => true,
                                                                                 'maxlength' => 16,
                                                                                 'pattern' => '[0-9]*')); ?></td>
            </tr>
            <tr>
            	<td><?php echo Form::label('', __(LBL_SECURITY_CODE));?></td>
              <td><?php echo Form::input('cardcode', $cardcode, array('style' => 'width: 50px',
                                                               'maxlength' => 3,
                                                               'size' => 3,
                                                               'required' => true,
                                                               'pattern' => '[0-9]*')); ?></td>
            </tr>
            <tr>
            	<td><?php echo Form::label('expiry_year', __(LBL_EXPIRATION_DATE)); ?></td>
              <td><?php echo Form::select('expiry_month', $mo, $expiry_month) . ' ' . Form::select('expiry_year', $years, $expiry_year); ?></td>
            </tr>
            <tr>
            	<td colspan="2" style="text-align: center;">
								<?php echo Form::submit('submit', __(LBL_COMPLETE_ORDER), array('class' => 'addbutton')); ?>
            		<?php echo Form::button('cancel', __(LBL_CANCEL), array('id' => 'cancelButton')); ?>
              </td>
            </tr>
          </table>
          
          <div class="right" style="width: 200px; padding: 5px;">
          	<h4>Du er ved at købe</h4>
            <p>The text goes here and here and here and here and booom!.</p>
            
            <h4>Betingelser</h4>
            <p>The text goes here and here and here and here and booom!.</p>
          </div>
          
          <div class="clear"></div>
          
        </div>
        <script type="text/javascript">
				$("#undoButton").click(function(az){
					az.preventDefault();
					var fname = "<?= $user->firstname; ?>";
					var lname = "<?= $user->lastname; ?>";
					var address = "<?= $user->address; ?>";
					var mobile = "<?= $user->mobile; ?>";
					$("input[name=firstname]").val(fname);
					$("input[name=lastname]").val(lname);
					$("input[name=address]").val(address);
					$("input[name=mobile]").val(mobile);
				});
				$("#payButton").click(function(az) {
					if(isStepOneCompleted() == true) {
						az.preventDefault();
						$("#step2").addClass("selected");
						$("#step1").removeClass("selected");
						$("input[name=step]").val(2);
						$("#stepOne").hide();
						$("#stepTwo").fadeIn("slow");
					}
				});
				$("#cancelButton").click(function(az){
					parent.$.fancybox.close();
				});
				function isStepOneCompleted() {
					var r;
					// simple validation
					if($("input[name=firstname]").val() == "") { 
						return false; 
					} else if($("input[name=lastname]").val() == "") { 
						return false; 
					} else if($("input[name=address]").val() == "") { 
						return false; 
					} else if($("input[name=mobile]").val() == "") { 
						return false; 
					} else if($("input[name=city]").val() == "") {
						return false;
					} else if($("input[name=zipcode]").val() == "") { 
						return false;
					}
					
					return true;
				}
				</script>
          <?php
					echo $form->hidden('step', 1);
          echo $form->hidden('did', $deal->ID);
          echo $form->close(); 
          ?>

		</div>
  </section>
  
</body>
</html>