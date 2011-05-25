<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>   
<div class="sidebar">
  <center>
  <div class="social-container" style="z-index: 86">
    <a target="_blank" href="http://www.addthis.com/bookmark.php?v=250&amp;winname=addthis&amp;pub=ra-4d6e3a782d6e35f6&amp;source=tbx-250&amp;lng=da&amp;s=facebook&amp;url=<?php echo url::base(true) . "deals/view/" . $deal['ID']?>">
      <?php echo HTML::image('images/facebook.jpg', array('alt' => LBL_SHARE_ON_FACEBOOK)); ?>
    </a>
  </div>
  
  <script src="http://connect.facebook.net/da_DK/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/TilbudiByendk/141668405900565" width="214" show_faces="true" stream="false" header="true"></fb:like-box>
  </center>
</div>