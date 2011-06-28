<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php require_once APPPATH .'views/tilbud/admin/header.php'; ?>
<!-- content starts here -->
<section id="ad-body">
	<div class="centered">

    <div id="htitle">
    	<h2><?php echo __(LBL_RESTAURANT_SET_USERPASSWORD); ?></h2>
    </div>


    <form method="post" action="">
      <table>
        <tr>
          <td width=130>Username : </td>
          <td><?php echo $bus['username'];?></td>
        </tr>
        <tr>
          <td>Password : </td>
          <td><?php echo $bus['password'];?></td>
        </tr>
      </table>
    </form>



    </div>
  </section>

    <!-- footer starts here -->
    <?php require_once APPPATH .'views/tilbud/admin/footer.php'; ?>  
  </body>
  </html>
