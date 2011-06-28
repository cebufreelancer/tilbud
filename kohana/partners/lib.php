<?php
require_once('conn.php');

//NOTE:
// this file is being linked to the foler application/languages so that we can reused the list of translations.
require_once('languages/dk.php');

if (isset($_POST['action']) && $_POST['action'] == "LOGIN")
{
  $user = trim($_POST['username']);
  $pass = trim($_POST['password']);
  $sql = sprintf("select * from businesses WHERE username = '%s' AND password = '%s' limit 0,1", $user, $pass);
  $result = mysql_query($sql, $conn) or die(mysql_error());

  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    $_SESSION['b_user'] = $user;
    $_SESSION['b_deal_id'] = $row['deal_id'];
    echo "<script>\n
//    location.replace('index.php')\n
    </script>";
  }else {
    $error  = LBL_INVALID_USERNAME_PASSWORD;
  }
}

if (isset($_POST['action']) && $_POST['action'] == "UPDATE")
{
  $ref_code = trim($_POST['ref_code']);
  $sql = sprintf("SELECT * FROM orders where refno='%s' AND deal_id=%d limit 0,1", $ref_code, $_SESSION['b_deal_id']);
  $result = mysql_query($sql, $conn) or die(mysql_error());

  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    if ($row['is_claimed'] == "1") {
      // already used.
      $error = LBL_REF_CODE_ALREADY_USED;
    }else{
      $date = date("Y-m-d H:i:s");
      $sql = sprintf("UPDATE orders set is_claimed=1, claimed_at='%s' WHERE id=%d", $date, $row['ID']);
      mysql_query($sql, $conn) or die(mysql_error());
      echo "<script>\n
      location.replace('index.php?s=1')\n
      </script>";
    }
  }else{
    $error = LBL_REF_CODE_DONT_EXIST;
  }

}

if ($_REQUEST['a'] == "logout")
{
  session_destroy();
  echo "<script>\n
  location.replace('index.php')\n
  </script>";
  
}
?>