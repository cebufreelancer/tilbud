<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
<!-- content starts here -->
<section id="ad-body">
	<div class="centered">
  	
    <div id="htitle">
    	<h2><?php echo __(LBL_DEALS); ?></h2>
    </div>

    <table cellspacing=5 cellpadding=5 border=0 class="table">
      <thead>
        <tr>
          <td width=80>Order id</td>
          <td width=150>Customer Name</td>
          <td width=140>Ref No</td>
          <td width=100>Amount</td>
          <td width=100>Ref is used?</td>
        </tr>
      </thead>
      <?php
      foreach($orders as $order){
        $user = DB::select()->from('users')->where('id', '=', $order['user_id'])->execute()->as_array();
        if (sizeof($user) > 0) {
      ?>
      <tbody>
        <tr>
          <td><?php echo $order['ID']?></td>
          <td><?php echo $user[0]['firstname'] . " " .  $user[0]['lastname'];?></td>
          <td> <?php echo $order['refno'];?></td>
          <td> <?php echo $order['total_count'];?></td>
          <td> <?php echo ($order['is_claimed'] == "1") ? "Used" : "Not used" ?></td>
        </tr>
      </tbody>
      <?php } } ?>
    </table>

    </div>
  </div>
</section>
  
  <!-- footer starts here -->
  <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
</body>
</html>
