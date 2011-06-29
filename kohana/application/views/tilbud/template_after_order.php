<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
  
Kære <?= $user->firstname; ?>
<br /><br />
Tak for din bestilling
<br />
Vi har registreret din bestilling af Dagens Tilbud "<b><?php echo html_entity_decode(strip_tags($this_deal->description)); ?></b>", og du har fået ordernummer <?= $order->ID; ?> <br />
OBS: Dette er dit ordernummer og ikke dit refferancenummer. 
<br />
LOGIN INFORMATION: <br/>
username: <?= $user->email;?><br/>
password: <?= $password;?><br/>
Login page: <a href="http://tilbudibyen.com/user/login">http://tilbudibyen.com/user/login</a> 
<br/><br/>
If you have already an account and forgot the password, please copy and paste the link below to your browser:<br/>
<a href="http://www.tilbudibyen.com/home/forgot">http://www.tilbudibyen.com/home/forgot</a>
<br />
<b>Hvornår får jeg mit værdibevis?</b>
<ul>
<li>Så snart tilbudet udløber, vil du modtage dit værdibevis og referencenummer  på e-mail og SMS – men kun hvis minimum <?php echo $this_deal->min_buy?> har købt Dagens Tilbud. </li>
<li>Følg med på <a href="<?php echo url::base(true);?>">Tilbud i Byen</a>, og se hvor mange der har købt, og hvornår tilbudet slutter. </li>
<li>Medbring så dit værdibevis eller oplys dit referencenummer i butikken, når du vil gøre brug af dit køb. </li>
</ul>

<b>OBS:</b> Værdibeviset kan bruges dagen efter Dagens Tilbud er udløbet på TilbudiByen.dk 
<br />
Husk at være opmærksom på værdibevisets udløbsdato. Den står under "<?php echo html_entity_decode($this_deal->title); ?>" på TilbudiByen.dk og på det værdibevis du modtager.
<br /><br />
<b>Hvad hvis der ikke er nok der har købt Dagens Tilbud?</b> <br />
Skulle det ske, at der ikke er nok der har købt Dagens Tilbud, så vil alle køb blive annulleret og der bliver IKKE trukket penge på dit betalingskort.
<br /><br />
Husk at oplyse dit Ordernummer hvis du skulle få brug for at henvende dig til TilbudiByens kundeservice i forbindelse med din bestilling. 
<br />
Med venlig hilsen<br />
TilbudiByen.dk
<br /><br />
<?php echo Html::image(Url::base(TRUE) . 'images/logo.jpg'); ?>
<br /><br />
TilbudIbyen.dk ApS, Nørregade 7B, 1165 København K <br />
CVR nummer: 33583400
<br /><br />
Du kan ikke svare direkte på denne e-mail. Du bedes benytte kontakt-siden på TilbudiByen.dk
</div>