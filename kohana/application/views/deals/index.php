<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php require_once APPPATH . 'views/tilbud/header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
    	
      <!-- DEALS SECTION -->
      <ul id="deals-container">
      	<li>
          <div class="deal-title">
            <h1><a href="">Dagens Tilbud</a></h1>
            <p>Halv pris på en stor sushi-menu til 2 personer hos Sushi.com på Sankt Annæ Plads. Del det med en du holder af - for der er mere end nok til 2.</p>
          </div>
          <div class="deal-banner" style="background-image: url(<?php echo URL::base(); ?>images/sample-image.jpg)" >
          	<div>
              <div class="buy-container"><p class="huge buy-label">250,-</p></div>
              <div class="buy-img-cont"><?php echo HTML::image('images/buy.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            <div class="buy-container">
            	<p class="discounts">Værdi 500,-   Rabat 50%</p>
            </div>
            <div>
              <div class="buy-container" style="">
              	<p class="period-label">Tilbuddet stopper om</p>
                <p class="period">10 : 10 : 10</p>
              </div>
              <div class="clock-img-cont"><?php echo HTML::image('images/clock.png', array('alt' => '')); ?></div>
              <div class="clear"></div>
            </div>
            
            <div>
              <div class="offer-container" style="">
              	<p class="period-label">Tilbuddet bliver aktiv ved 100 køb</p>
                <p class="period">1.235 har købt</p>
              </div>
              <div class="social-container">
              	<?php echo HTML::image('images/facebook.jpg', array('alt' => 'Share on facebook!')); ?>
              </div>
              <div class="save-label">SPAR 50%</div>
              <div class="clear"></div>
            </div>
            
          </div>
        </li>
      </ul>
    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title">Nyd en skræddersyet sushi couple menu</a></h1>
          
          <p>I en kælder på Sankt Annæ Plads ligger en skjult sushi-perle. Så snart du træder ind hos Sushi.com, kan den hyggelige atmosfære mærkes, og betjeningen er sød og åben.</p>

<p>Hos Sushi.com kan du få en anderledes sushi-oplevelse midt i byen. Det er de perfekte rammer om en hyggelig aften med én, du holder af. Restauranten laver sushi efter alle kunstens regler og originale japanske opskrifter.</p>

<p>Indehaveren Yadi har over fem års erfaring som sushi-kok, og han er derfor rustet til at servicere sushi-glade københavnere på allerbedste vis.</p>

<p>Der bliver naturligvis kræset for detaljerne med friske og sunde råvarer. Med dagens tilbud får du sushi til to personer bestående af:</p>

<p>38 stk. sushi: <br />
- Nigiri:  2 stk. laks, 2 stk. tun, 2 stk. laks med peber, 2 stk. reje <br />
- Hoso maki: 4 stk. agurk, 4 stk. spicy reje <br />
- Insideout maki: 4 stk. hawaian, 4 stk. green laks <br />
- Futo maki: 6 stk. california <br />
- Rispapir maki: 4 stk. crispy rejer, 4 stk. laks <br />
</p>

<p>Ved hvert bord i restauranten finder du en knap, og når du trykker på den, kommer der straks en tjener - for hos Sushi.com er betjeningen vigtig. Du behøver derfor aldrig at sidde og vifte forgæves efter øjenkontakt. Du kan spise sushi-menuen i den hyggelige restaurant eller tage den med hjem.</p>

					<div id="deals-info">
            <ul>
              <li class="dhead-one">Det får du</li>
              <li>Max. 1 værdibevis pr. person.</li>
              <li>Max. 1500 værdibeviser til salg.</li>
              <li>Bestilling af maden skal ske senest 2 timer før afhentning på tlf.: 3333 8088.</li>
              <li>Kan tidligst afhentes fra kl 14. Ændringer i menu kan ikke foretages.</li>
              <li>Værdibeviset kan indløses fra 18. februar 2011 til 30. april 2011</li>
            </ul>
            <ul>
            	<li class="dhead-two ">Praktiske oplysninger</li>
              <li>Åbningstider & hjemmeside:</li>
							<li>Mandag-torsdag: 11-21</li>
							<li>Fredag-lørdag: 11-22</li>
              <li>Søndag: 12-21</li>
							<li>www.sushicom.dkapril 2011</li>
            </ul>
        	</div>
          
        </div>
        
        <div class="sidebar">
        	<center><?php echo HTML::image('images/sample-facebook.jpg', array('alt' => 'Tilbug i Byen')); ?></center>
        </div>
      </div>    	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH . 'views/tilbud/footer.php'; ?>
  
</body>
</html>