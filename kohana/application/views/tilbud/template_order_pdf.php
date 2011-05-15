<div style="width: 700px; border: 10px solid #111; padding: 10px 15px;font-family: Arial, Helvetica, sans-serif;">

	<div style="background: #000; padding: 5px;"><?php echo HTML::image(URL::base(TRUE) . 'images/logo.png'); ?></div>
  
  <div style="margin: 10px 0px; border-top: 2px solid #111; padding: 10px 0px; border-bottom: 2px solid #111;">
  <span style="font-size: 22px; font-weight: bold;"><?= $deal->title; ?></span><br/>
  <?= $deal->description; ?> (V�rdi: <?= $deal->regular_price ?> kr.)
  </div>
  
  <table width="100%" style="border-bottom: 2px solid #111;">
  <tr style="font-weight: bold;">
  	<td width="60%">Indehaver</td>
    <td width="20%">K�bsdato</td>
    <td width="20%">Udl�bsdato</td>
  </tr>
  <tr>
  	<td><?= $user->firstname . ' ' . $user->lastname; ?></td>
    <td><?= date("d-m-Y", strtotime($order->date_created)); ?></td>
    <td><?= date("j. F Y", strtotime($deal->expiry_date)); ?></td>
  </tr>
  </table>
  
  <p><b>Referencenummer:</b> <span style="padding-left: 25px;"><?= $deal->reference_no; ?></span></p>
  
  <p style="font-size: 14px;"><b>Det med sm�t</b><br/>
Kan indl�ses man-l�r 11-15.<br/>
Jailhouse Cph, Studiestr�de 12, kld, 1455 K�benhavn K. Tlf. 33152255</p>
	
</div>

<div style="font-family: Arial, Helvetica, sans-serif;">

  <p style="font-size: 20px;">
    <b>S�dan bruger du dit v�rdibevis</b>
    <ul>
      <li>Print v�rdibeviset ud</li>
      <li>H�ng det op p� k�leskabet eller l�g det i din pung</li>
      <li>Nyd oplevelsen med dine venner eller familie</li>
    </ul>
    </p>
  
    <p style="font-size: 20px;"><b>Tilbudibyen kundeservice</b><br/>
  Telefon: +45 51 90 14 53<br/>
  Mail: kundeservice@tilbudibyen.com<br/><br/>
  <b>Vi ses p� www.tilbudibyen.com</b></p>

</div>