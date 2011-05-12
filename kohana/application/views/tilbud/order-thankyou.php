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

				<div style="margin: 50px 0px; padding: 15px; border: 3px double #CCC; width: 90%; margin: auto;">
          <table width="100%" style="font-size: 12px;">
          <tr>
            <td width="50%">
            <b><?php echo __(LBL_BUYER); ?></b><br/>
            <?php echo $name; ?><br />
            <?php echo $email; ?><br /><br/>
            
            <b><?php echo __(LBL_SELLER); ?></b><br/>
            TilbudiByen.dk<br/>
            Nørregade 7B<br/>
            1165 København K<br/>
            CVR nummer: 33583400<br/>
            </td>
            <td width="50%">
            <b><?php echo __(LBL_INVOICE); ?></b><br/>
            <?php echo __(LBL_ORDER_NUMBER) . ' : ' . $orders->ID; ?><br/>
            <?php echo __(LBL_INVOICE_NUMBER) . ' : ' . $orders->ID; ?><br/>
            <?php echo __(LBL_DATE) . ' : ' . date("F j, Y"); ?><br/><br/>
            
            <?php echo __(LBL_PAYMENT) . ' : <b>' . strtoupper($orders->payment_type); ?></b><br/>
            <?php echo __(LBL_PAYMENT_STATUS) . ' : <b>' . strtoupper($orders->status); ?></b><br/>          
            </td>
          </tr>
          </table>
          
          <table id="order-deal" style="width: 90%;">
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
          
          <p>Husk at oplyse dit Ordernummer hvis du skulle få brug for at henvende dig til TilbudiByens kundeservice i forbindelse med din bestilling.</p>
          
          <p>Med venlig hilsen<br />
             TilbudiByen.dk<br />
             <?php echo HTML::image('images/logo.png', array('alt' => 'Tilbug i Byen', 'style' => 'background: #000; width: 200px;')); ?>
             
             <br /><br />
  TilbudIbyen.dk ApS, Nørregade 7B, 1165 København K <br />
  CVR nummer: 33583400
  <br /><br />
  Du kan ikke svare direkte på denne e-mail. Du bedes benytte kontakt-siden på TilbudiByen.dk
          </p>
        </div>
			</div>

		</div>
  </section>
			
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>