<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once 'header.php'; ?>
<!-- content starts here -->
<section id="ad-body">
	<div class="centered">
      <br/><br/>
      
      <?php if (isset($status) && $status =='success') {?>
        <h3><?php echo __(LBL_UNSUBSCRIBE_CHECK_EMAIL)?></h3>
      <?php } else {?>
      
            <?php
            for($i=0; $i<sizeof($error); $i++) {
             echo $error[$i]; 
            }
            ?>
            <h3>Please enter your email to unsubscribe</h3>
      <br/>
            <form method="post" action="">
              Email address: <input type="text" name="email" value="">
              <input type="submit" name="unsubscribeme" value="Unsubscribe me">
            </form>
      <?php } ?>

 	</div>
</section>

  <!-- footer starts here -->
  <?php require_once 'footer.php'; ?>
  
</body>
</html>
