<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
  Kære <?= $user->firstname; ?>, 
  <br/>
  <br/>
  <br/>
  <b>"<?= $deal->description; ?>"</b> er nu aktiveret.
  <br/><br/>
  I den vedhæftet pdf fil finder du dit værdibevis med dit referencenummer.<br/><br/>
  
  Har du angivet dit mobilnummer har du også modtaget referencenummeret på SMS.<br/><br/>
  
  Medbring dit referencenummer i butikken når du ønsker at gøre brug af dit køb.<br/><br/>
  
  Husk at være opmærksom på værdibevisets udløbsdato. Den står på det vedhæftede værdibevis.<br/><br/>
  <br/>
  
  Referencenummeret kan indløses fra i dag af.<br/><br/>
  
  God fornøjelse!<br/><br/>
  
  <table width="100%" style="font-size: 12px; margin-top: 25px;">
  <tr>
  <td width="50%" style="vertical-align:top;">
  <b>Køber</b><br/>
  <?= $user->firstname . ' ' . $user->lastname; ?><br />
  <?= $user->email; ?><br /><br/>
  
  <b><?php echo __(LBL_SELLER); ?></b><br/>
  TilbudiByen.dk<br/>
  Nørregade 7B<br/>
  1165 København K<br/>
  CVR nummer: 33583400<br/>
  </td>
  
  <td width="50%" style="font-size: 12px; vertical-align: top;">
  <b>FAKTURA</b><br/>
  Bestillingsnummer: <?= $order->ID; ?><br/>
  Fakturanummer: <?= $order->ID; ?><br/>
  Dato: <?= date("F j, Y"); ?><br/><br/>
  
  Betaling: <b><?= strtoupper($order->payment_type); ?></b><br/>
  Betalingstatus: <b><?= strtoupper($order->status); ?></b><br/>   
  </td>
  
  </tr>
  </table>
  
  <?php $cc_int = 1.10; ?>
  
  <table style="font-size: 12px; border-collapse: collapse; margin: 25px 0px;">
  <thead style="font-weight: bold;">
    <tr style="border-bottom: 2px solid #000;">
      <td width="60%" style="padding: 15px 3px;">Beskrivelse</td>
      <td width="10%" style="border-bottom: 2px solid #000;">Antal</td>
      <td width="15%" style="border-bottom: 2px solid #000;">Pris</td>
      <td width="15%" style="border-bottom: 2px solid #000;">Total</td>
    </tr>
  </thead>
  <tbody>
    <tr style="border-bottom: 1px solid #000;">
    	<td style="padding: 10px 5px;"><?= $deal->description; ?></td>
      <td><?= $order->quantity; ?></td>
      <td><?= $deal->regular_price; ?> DKK</td>
      <td><?= $order->total_count; ?> DKK</td>
    </tr>
    <tr style="border-bottom: 1px solid #000;">
    	<td style="padding: 10px 5px;">Betalingskortgebyr<br/>
      <?= strtoupper($order->payment_type); ?>, XXXX XXXX XXXX <?= substr($billing['cardnumber'], -4); ?>
      </td>
      <td>1</td>
      <td><?= $cc_int; ?> DKK</td>
      <td><?= $cc_int; ?> DKK</td>
    </tr>
    <tr style="border-bottom: 1px solid #000; font-weight: bold;">
    	<td colspan="3" style="padding: 10px 5px;">Total</td>
      <td><?= ($cc_int + $order->total_count); ?> DKK</td>
    </tr>
    <tr style="border-bottom: 1px solid #000;">
    	<td colspan="3" style="padding: 10px 5px;">Heraf moms (25,00%)</td>
      <td>10.00 DKK</td>
    </tr>
  </tbody>
  </table>
  <br/>
  Husk at oplyse dit bestillingsnummer hvis du skulle få brug for at henvende dig til Tilbudibyen kundeservice i forbindelse med dit køb.<br/><br/>
  
  Med venlig hilsen<br/>
  The Tilbudibyen Team
  <br/>
  <a href=\"http://www.tilbudibyen.com\">http://www.tilbudibyen.com</a><br/><br/><br/>
  
  <?php echo HTML::image(URL::base(TRUE) . 'images/logo.png', array('style' => 'background: #000;')); ?><br/><br/>
  
  Tilbud DK ApS, Vesterbrogade 20, 3. sal, 1620 København K<br/>
CVR nummer: 32780709<br/><br/>


</div>
