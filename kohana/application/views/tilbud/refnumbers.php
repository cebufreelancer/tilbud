<div id="htitle">
  <h2><?= LBL_My_Account ?></h2>
</div>

<div id="myforms">
	<?php
  // output messages
  if(Message::count() > 0) {
    echo '<div class="block">';
    echo '<div class="content" style="padding: 10px 15px;">';
    echo Message::output();
    echo '</div></div>';
  }
  ?>
  
  <div id="action-button">
  	<?php echo HTML::anchor('user/myaccount', LBL_My_Account, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/orders', LBL_My_Orders, array('class' => 'addbutton')); ?>
    <?php echo HTML::anchor('user/refnumbers', LBL_My_RefNo, array('class' => 'addbutton')); ?>
  </div>
  
  <div id="action-button">
    
    <ul style="list-style-type: none">
      <?php   foreach($refnumbers as $refno){ ?>
        <form style="float; left" target="_blank" method="post" action="/user/pdfviewer"><input type="hidden" name="refno" value="<?php echo $refno['refno'];?>">
          <li style="margin: 0px 0px; height: 15px; padding: 8px 0px">
          <?php echo $refno['refno'];?> 
          <input style="height: 20px; cursor: pointer; font-size: 12px; width: 70px; margin-left: 10px" type="submit" name="action" value="<?php echo __(LBL_DOWNLOAD_PDF);?>">
        </li>
        </form>      
      <?php } ?>
    </li>
  </div>
    
	
  
</div>
