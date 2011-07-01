<div style="width: 700px; border: 10px solid #111; padding: 10px 15px;font-family: Arial, Helvetica, sans-serif;">

	<div style="background: #000; padding: 5px;"><?php echo HTML::image(URL::base(TRUE) . 'images/logo.jpg'); ?></div>
  
  <hr />
  <table style="margin-top: 10px; margin-bottom: 10px;">
    <tr><td width="670"><span style="font-size: 26px; font-weight: bold;"><?= $deal->title; ?></span></td></tr>
    <tr><td style="font-size: 24px;"><?= $deal->description; ?> (V�rdi: <?= $deal->regular_price ?> kr.)</td></tr>
  </table>
  
  <hr />
  <table style="margin-top: 10px; margin-bottom: 10px;">
  <tr style="font-weight: bold;">
    <td>Indehaver</td>
    <td>K�bsdato</td>
    <td>Udl�bsdato</td>
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
      <td width="50%">
        <?php $deal->whatyouget; ?>
      </td>
      <td width="50%">
        <?php $deal->information;?>
      </td>
    </tr>
  </table>
  
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

	<hr />
  
  <div style="margin: 15px 0px; padding: 25px; text-align: center; background: #333333; color: #FFFFFF;">
  	<h2>ANNONCE</h2>
    <p>F� din annoncen vist her - ring p� +45 51 90 14 53</p>
  </div>

</div>