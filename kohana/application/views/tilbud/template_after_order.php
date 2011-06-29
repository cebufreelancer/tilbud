<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
  
<?php echo "Kære " . $user->firstname; ?>
<br /><br />
<?php echo "Tak for din bestilling"; ?>
<br />
<?php echo "Vi har registreret din bestilling af Dagens Tilbud \"<b>" .  html_entity_decode(strip_tags($this_deal->description)) . "</b>\", og du har fået ordernummer " . $order->ID . "<br />
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
<b><?php echo "Hvornår får jeg mit værdibevis?"?></b>
<ul>
<li><?php echo "Så snart tilbudet udløber, vil du modtage dit værdibevis og referencenummer  på e-mail og SMS – men kun hvis minimum " . $this_deal->min_buy . " har købt Dagens Tilbud.";?> </li>
<li><?php echo "Følg med på";?> <a href="<?php echo url::base(true);?>">Tilbud i Byen</a>, <?php echo "og se hvor mange der har købt, og hvornår tilbudet slutter.";?> </li>
<li><?php echo "Medbring så dit værdibevis eller oplys dit referencenummer i butikken, når du vil gøre brug af dit køb.";?> </li>
</ul>

<b>OBS:</b> <?php echo "Værdibeviset kan bruges dagen efter Dagens Tilbud er udløbet på TilbudiByen.dk";?> 
<br />
<?php echo "Husk at være opmærksom på værdibevisets udløbsdato. Den står under";?> "<?php echo html_entity_decode($this_deal->title); ?>" <?php echo "på TilbudiByen.dk og på det værdibevis du modtager.";?>
<br /><br />
<b><?php echo "Hvad hvis der ikke er nok der har købt Dagens Tilbud?";?></b> <br />
<?php echo "Skulle det ske, at der ikke er nok der har købt Dagens Tilbud, så vil alle køb blive annulleret og der bliver IKKE trukket penge på dit betalingskort.";?>
<br /><br />
<?php echo "Husk at oplyse dit Ordernummer hvis du skulle få brug for at henvende dig til TilbudiByens kundeservice i forbindelse med din bestilling. " ?>
<br />
Med venlig hilsen<br />
TilbudiByen.dk
<br /><br />
<?php echo Html::image(Url::base(TRUE) . 'images/logo.jpg'); ?>
<br /><br />
<?php echo "TilbudIbyen.dk ApS, Nørregade 7B, 1165 København K ";?><br />
CVR nummer: 33583400
<br /><br />
<?php echo "Du kan ikke svare direkte på denne e-mail. Du bedes benytte kontakt-siden på TilbudiByen.dk";?>
</div>
