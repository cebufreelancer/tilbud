<style type="text/css">
<!--
  body { font-family: "Arial", "Helvetica", sans-serif; }
  a { color: #40a2d5; }
  #main { border: 15px solid #40a2d5; background: #FFFFFF; width: 670px; padding: 15px; margin: auto; }
  #main-title { background: #000000; padding: 15px 10px;
                url(<?php echo url::base(TRUE)?>images/bg-header.png) bottom left repeat-x; }
  #deal-title { background: #40a2d5; color: #FFF; }
  #deal-title h1 { font-size: 22px; padding: 10px; }
  #deal-control { width: 200px; float: left; }
  #deal-content { width: 430px; float: left; padding-left: 25px; font: 18px/22px Arial, Helvetica, sans-serif; }
  #deal-content h2 { color: #666666; font-size: 22px; }
  #deal-content img { margin-bottom: 20px; }

  .price { font-size: 60px; font-weight: bold; text-align: center; color: #40a2d5; }
  .medium { font-size: 45px; }
  .button { background: url(<?php echo url::base(TRUE)?>images/bg-button.png) top left repeat-x; 
            color: #FFFFFF; font-weight: bold; font-size: 28px; 
            padding: 10px 15px; text-align: center; margin-bottom: 20px;
            border-radius: 10px; display: block; text-decoration: none; 
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-box-shadow: 0px 0px 20px #333 inset;
            -webkit-box-shadow: 0px 0px 20px #333 inset;
            box-shadow: 0px 0px 20px #333 inset;
          }
  .big { font-size: 18px; font-weight: bold; padding: 5px 20px 5px 0px; }
  .align-right { float: right; }
  .align-center { text-align: center; font-size: 11px; }
  .subhead { color: #40a2d5; }
  .contents { font-size: 14px; }
  .slogan { float: right; font-style: italic; color: #e9e9e9; font-size: 17px; padding-top: 15px; }
  .black { color: #000; }
  .clear { clear: both; }
  ::selection { background: #F85510; /* Safari */ }
  ::-moz-selection { background: #F85510; /* Firefox */ }
-->
</style>
<div style="color: #000000;">
<div style="border: 15px solid #40a2d5; background: #FFFFFF; width: 635px; padding: 15px; margin: auto;">
	<div style="background: #000000; padding: 15px 10px; url(<?php echo url::base(TRUE)?>images/bg-header.png) bottom left repeat-x;">
		<img src="<?php echo url::base(TRUE)?>images/logo.png" /><span style="float: right; font-style: italic; color: #e9e9e9; font-size: 17px; padding-top: 15px;">De bedste tilbud og oplevelser i din by!</span>
	</div>
	
	<div style="background: #40a2d5; color: #FFF;">
		<h1 style="font-size: 22px; padding: 10px; text-align: center;"><?php echo __(LBL_SHARE_TO_FRIEND); ?></h1>
	</div>
	
  <?php echo HTML::Image(Url::base(TRUE).'images/arrow.jpg', array('align' => 'right')); ?>
  
	<p>Mange tak for din tilmelding til TilbudiByen.dk
For at undgå misbrug vil vi bede dig til at bekræfte din tilmelding ved at klikke på nedenstående link:</p>
  
  <?php echo HTML::anchor(Url::base(TRUE), 'Klik her for at bekræfte din tilmelding', array('style' => 'font-size: 20px; font-weight: bold; color: #f22b2e;')); ?>
  
  <p>Hvis du ikke ønsker at tilmelde dig nyhedsbrevet fra Tilbudibyen.dk så kan du blot se bort fra denne mail.</p>
  
  <p>Du vil kun blive tilmeldt hvis du bekræfter din tilmelding ved at klikke på linket herover. </p>
  
  <?php echo HTML::Image(Url::base(TRUE).'images/email-confirm.jpg', array('align' => 'center')); ?>
  
</div>

<p style="text-align: center; font-size: 11px;">Du modtager denne e-mail fordi du er tilmeldt nyhedsbrevet hos TilbudiByen.dk.Hvis du ikke ønsker at modtage Dagens Tilbud i Byen på e-mail længere kan du altid afmelde dig ved at klike her.</p>

<p style="text-align: center; font-size: 11px;">Nyhedsbrevet udsendes af Tilbudibyen.dk ApS - Nørregade 7B - 1165 København K</p>
</div>