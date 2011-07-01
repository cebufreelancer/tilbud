<div style="width: 700px; border: 10px solid #111; padding: 10px 15px;font-family: Arial, Helvetica, sans-serif;">

	<div style="background: #000; padding: 5px;"><?php echo HTML::image(URL::base(TRUE) . 'images/logo.jpg'); ?></div>
  
  <hr />
  <table style="margin-top: 10px; margin-bottom: 10px;">
    <tr><td width="670"><span style="font-size: 26px; font-weight: bold;"><?= $deal->title; ?></span></td></tr>
    <tr><td width="670" style="font-size: 24px; text-align: justify"><?= $deal->description; ?> (Værdi: <?= $deal->regular_price ?> kr.)</td></tr>
  </table>
  
  <hr />
  <table style="margin-top: 10px; margin-bottom: 10px;">
  <tr style="font-weight: bold;">
    <td>Indehaver</td>
    <td>Købsdato</td>
    <td>Udløbsdato</td>
  </tr>
  <tr>
    <td width="420"><?= $user->firstname . ' ' . $user->lastname; ?></td>
    <td width="125"><?= date("d-m-Y", strtotime($order->date_created)); ?></td>
    <td width="125"><?= date("j. F Y", strtotime($deal->expiry_date)); ?></td>
  </tr>
  </table>
  <hr />
  
  <p><b>Referencenummer:</b> <span style="padding-left: 25px; font-size: 18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $pdf_refno; ?></span></p>
  <hr/>
  
  <table>
    <tr>
      <td width="330">
        <?php echo html_entity_decode($deal->whatyouget); ?>
      </td>
      <td width="300">
        <?php echo html_entity_decode($deal->information);?>
      </td>
    </tr>
  </table>
  
</div>

<div style="font-family: Arial, Helvetica, sans-serif;">

    <p style="font-size: 20px;">
  <b>Tilbudibyen kundeservice</b><br/>
  Telefon: +45 60 92 62 61<br/>
  Mail: kundeservice@tilbudibyen.dk<br/><br/>
  <b>Vi ses på www.tilbudibyen.dk</b>
  </p>

	<hr />
</div>