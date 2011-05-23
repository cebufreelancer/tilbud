<div style="width: 700px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
  
Kære <?= $user->firstname; ?>
<br /><br />
Tak for din bestilling
<br />
Vi har registreret din bestilling af Dagens Tilbud "<?php echo $this_deal->description; ?>", og du har fået ordernummer <?= $order->ID; ?> <br />
OBS: Dette er dit ordernummer og ikke dit refferancenummer. 
<br />
<br />
Hvornår får jeg mit værdibevis?
<br />
Så snart tilbudet udløber, vil du modtage dit værdibevis og referencenummer  på e-mail og SMS – men kun hvis minimum <?php echo $this_deal->min_buy?> har købt Dagens Tilbud. 
<br />
Følg med på <a href="<?php echo url::base(true);?>">Tilbud i Byen</a>, og se hvor mange der har købt, og hvornår tilbudet slutter. 
<br />
Medbring så dit værdibevis eller oplys dit referencenummer i butikken, når du vil gøre brug af dit køb. 
<br />
OBS: Værdibeviset kan bruges dagen efter Dagens Tilbud er udløbet på TilbudiByen.dk 
<br />
Husk at være opmærksom på værdibevisets udløbsdato. Den står under "<?php echo $this_deal->title; ?>" på TilbudiByen.dk og på det værdibevis du modtager.
<br /><br />
Hvad hvis der ikke er nok der har købt Dagens Tilbud? <br />
Skulle det ske, at der ikke er nok der har købt Dagens Tilbud, så vil alle køb blive annulleret og der bliver IKKE trukket penge på dit betalingskort.
<br /><br />
Husk at oplyse dit Ordernummer hvis du skulle få brug for at henvende dig til TilbudiByens kundeservice i forbindelse med din bestilling. 
<br />
Med venlig hilsen<br />
TilbudiByen.dk
<br /><br />
<TILBUDIBYEN LOGO>
<br /><br />
TilbudIbyen.dk ApS, Nørregade 7B, 1165 København K <br />
CVR nummer: 33583400
<br /><br />
Du kan ikke svare direkte på denne e-mail. Du bedes benytte kontakt-siden på TilbudiByen.dk
</div>