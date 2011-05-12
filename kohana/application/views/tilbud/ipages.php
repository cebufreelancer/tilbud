<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'ipages-header.php'; ?>

  <!-- content starts here -->
  <section id="main-body">
  	<div class="centered">
  	  
  	  <?php if ($page->page_code == "contact") { ?>
        <iframe src="http://snupti.com//tilbudibyen/contact/contact.php" width="100%" height="350" frameborder="0">
         <p>Your browser does not support iframes.</p>
        </iframe>
          	  
  	  <?php } ?>
      <p> <?= $page->content ?> </p>	      
    </div>
  </section>
  
  <!-- footer starts here -->

  
</body>
</html>