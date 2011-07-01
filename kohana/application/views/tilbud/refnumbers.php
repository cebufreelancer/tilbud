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
    <?php
    //foreach($refnumbers as $refno){
      
    //}
    ?>
    <ul>
      <li> code here <form target="_blank" method="post" action="/user/pdfviewer"><input type="hidden" name="refno" value="1234"><input type="submit" name="action" value="View PDF"></form></li>
    </li>
  </div>
    
	
  
</div>
