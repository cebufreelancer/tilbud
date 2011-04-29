<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
	
  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
    	
      <!-- DEALS SECTION -->    	
    	<div id="body-content">
      	<div class="posts">
        	<h1><a href="" class="posts-title">All Deals</a></h1>


          <?php foreach($deals as $deal){ ?>
            <div>
              <div class="image" style="float: left">
                <img src="<?= url::base(true);?>uploads/<?= $deal['ID'];?>/<?= $deal['image'];?>" width="261" height="156">
              </div>
              <div style="float :left">
                <div class="price"><?= $deal['regular_price']?> </div>                
                <a href="<?= url::base(true); ?>deals/view/<?= $deal['ID'];?>" class="deals"><h3><?= $deal['title']?></h3></a>
                <p><?= $deal['description']; ?></p>
              </div>
            </div>
          <?php } ?>

          
          
        </div>
        
        <div class="sidebar">
          <p></p>
        	<center>
        	  <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/#!/pages/TilbudiByendk/141668405900565" width="214" show_faces="true" stream="false" header="true"></fb:like-box>
        	  </center>
        </div>
      </div>    	
    </div>
  </section>
  
  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>