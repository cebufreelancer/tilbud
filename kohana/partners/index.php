<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Tilbudibyen - Partner Administration</title> 
<style type="text/css"> 
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style> 
</head> 
 
<body> 
<?php
require_once('lib.php');
?> 

  <table border="0" cellspacingacing="0" cellpadding="0" align="center"> 
  <tr> 
    <td  width="800" height="90" background="images/header.png">&nbsp;
      <?php if (isset($_SESSION['b_user']) && $_SESSION['b_user'] != "") {  ?>
        <br/>
        <div style="position: absolute; padding-top: 50px;">
          <a href="index.php?a=logout"><?php echo LBL_LOGOUT;?></a>
        </div>
      <?php } ?>
    </td>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
      <tr> 
        <td height="40" align="center" valign="top">
        </td> 
      </tr> 
      <tr> 
        <td align="center">

<?php
if (!isset($_SESSION['b_user']) || $_SESSION['b_user'] == "") { 
?>

          <form id="form1" name="form1" method="post" action="index.php">
            <table>
              <?php if(isset($error) && $error != "") {?>
              <tr>
                <td colspan=2 ><span style="color: red;font-size: 11px"><?php echo $error;?></span></td>
              </tr>
              <?php } ?>
              <tr>
                <td><label for="textfield"><?php echo LBL_USERNAME;?></label> </td>
                <td><input type="text" name="username" id="username" style="width:190px; height:24px"/> </td>
              </tr>
              <tr>
                <td><label for="textfield"><?php echo LBL_PASSWORD;?></label></td>
                <td><input type="password" name="password" id="password" style="width:190px; height:24px"/> </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <input type="hidden" name="action" value="LOGIN">
                  <input type="submit" name="submit" id="button" value="<?php echo LBL_LOGIN;?>" style="width:100px; height:40px; font-size: 12px " /> </td>
              </tr>
              </table>
        </form>

<?php }else{ ?>

    <form id="form1" name="form1" method="post" action="index.php">
      <table>
        <?php if(isset($error) && $error != "") {?>
        <tr>
          <td colspan=2 ><span style="color: red;font-size: 11px"><?php echo $error;?><br/><?php echo LBL_PLEASE_CALL_US;?></span></td>
        </tr>
        <?php } ?>
        
        <?php if(isset($_REQUEST['s']) && $_REQUEST['s'] == "1") {?>
        <tr>
          <td colspan=2 ><span style="color: green;font-size: 11px"><?php echo LBL_REF_CODE_MARKED?></span></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan=2 height=50><img src="images/text.jpg"></td>
        </tr>
        
        <tr>
          <td colspan="2">
            <input type="text" name="ref_code" id="ref_code" style="width:290px; height:24px; font-size: 20px; padding: 6px"/> 
            <input type="submit" name="submit" id="button" value="<?php echo LBL_SEND;?>" style="padding: 6px 8px" />
            <input type="hidden" name="action" value="UPDATE">
            </td>
        </tr>
        </table>
  </form>

  
<?php }?>

        </td> 
      </tr> 
      <tr> 
        <td align="center"></td> 
      </tr> 
    </table></td> 
  </table> 
</body> 
</html>