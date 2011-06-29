<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<?php echo mb_convert_encoding("Kære ","ISO-8859-1", "UTF-8") . $user->firstname; ?>
<br /><br />
<?php echo "Tak for din bestilling"; ?>
<br />
<?php echo mb_convert_encoding("Vi har registreret din bestilling af Dagens Tilbud", "ISO-8859-1", "UTF-8") . " \"<b>" .  html_entity_decode(strip_tags($this_deal->description)) . "</b>\", 
" . mb_convert_encoding("og du har fået ordernummer ", "ISO-8859-1", "UTF-8") . $order->ID . "<br />
OBS: Dette er dit ordernummer og ikke dit refferancenummer. ";?>
<br /><br />
<?php echo LBL_LOGIN_INFORMATION?>: <br/>
<?php echo LBL_USERNAME;?>: <?= $user->email;?><br/>
<?php echo LBL_PASSWORD;?>: <?= $password;?><br/>
<?php echo LBL_LOGIN_PAGE;?>: <a href="http://tilbudibyen.com/user/login">http://tilbudibyen.com/user/login</a> 
<br/><br/>
<?php echo LBL_IFHAVE_ACCOUNT_TEXT?><br/>
<a href="http://www.tilbudibyen.com/home/forgot">http://www.tilbudibyen.com/home/forgot</a>
<br />
<b><?php echo mb_convert_encoding("Hvornår får jeg mit værdibevis?", "ISO-8859-1", "UTF-8")?></b>
<ul>
<li><?php echo mb_convert_encoding("Så snart tilbudet udløber, vil du modtage dit værdibevis og referencenummer  på e-mail og SMS – men kun hvis minimum ", "ISO-8859-1", "UTF-8") . $this_deal->min_buy . mb_convert_encoding(" har købt Dagens Tilbud.", "ISO-8859-1", "UTF-8");?> </li>
<li><?php echo mb_convert_encoding("Følg med på", "ISO-8859-1", "UTF-8");?> <a href="<?php echo url::base(true);?>">Tilbud i Byen</a>, <?php echo mb_convert_encoding("og se hvor mange der har købt, og hvornår tilbudet slutter.", "ISO-8859-1", "UTF-8");?> </li>
<li><?php echo mb_convert_encoding("Medbring så dit værdibevis eller oplys dit referencenummer i butikken, når du vil gøre brug af dit køb.", "ISO-8859-1", "UTF-8");?> </li>
</ul>

<b>OBS:</b> <?php echo mb_convert_encoding("Værdibeviset kan bruges dagen efter Dagens Tilbud er udløbet på TilbudiByen.dk", "ISO-8859-1", "UTF-8");?> 
<br />
<?php echo mb_convert_encoding("Husk at være opmærksom på værdibevisets udløbsdato. Den står under", "ISO-8859-1", "UTF-8");?> "<?php echo html_entity_decode($this_deal->title); ?>" <?php echo mb_convert_encoding("på TilbudiByen.dk og på det værdibevis du modtager.", "ISO-8859-1", "UTF-8");?>
<br /><br />
<b><?php echo mb_convert_encoding("Hvad hvis der ikke er nok der har købt Dagens Tilbud?", "ISO-8859-1", "UTF-8");?></b> <br />
<?php echo mb_convert_encoding("Skulle det ske, at der ikke er nok der har købt Dagens Tilbud, så vil alle køb blive annulleret og der bliver IKKE trukket penge på dit betalingskort.", "ISO-8859-1", "UTF-8");?>
<br /><br />
<?php echo mb_convert_encoding("Husk at oplyse dit Ordernummer hvis du skulle få brug for at henvende dig til TilbudiByens kundeservice i forbindelse med din bestilling. ", "ISO-8859-1", "UTF-8") ?>
<br />
Med venlig hilsen<br />
TilbudiByen.dk
<br /><br />
<?php echo Html::image(Url::base(TRUE) . 'images/logo.jpg'); ?>
<br /><br />
<?php echo mb_convert_encoding("TilbudIbyen.dk ApS, Nørregade 7B, 1165 København K ", "ISO-8859-1", "UTF-8");?><br />
CVR nummer: 33583400
<br /><br />
<?php echo mb_convert_encoding("Du kan ikke svare direkte på denne e-mail. Du bedes benytte kontakt-siden på TilbudiByen.dk", "ISO-8859-1", "UTF-8");?>
</div>
