<?php
import_request_variables("gp", "rv_");
require_once("db_globals.php");

$banner_bgcolor = "#8D1920";
$body_bgcolor = "#000000";
$site_name = "Blue Moon Daughter";
if (($rv_m == "logout")) {
  setcookie("admin", "", time() - 3600,"/");
  head();
  password_page();
  }
else if (isset($_COOKIE["admin"])) {
  head();
  links_page();
  }
else if (($rv_admin_pswd == "1mar2ket3")||($rv_admin_pswd == "coz")) {
  setcookie("admin", "yes",0,"/");
  head();
  links_page();
  }
else {
  $onload = "onload='document.forms[0].admin_pswd.focus()'";
  head();
  password_page();
  }

//*******************************************************************************//

function password_page() {
  global $body_bgcolor,$site_name;
  print <<<_END_
<table widthz="712" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEDFCD">
  <tr>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="ulcorner"><div align="center" class="header">$site_name</div></td>
    <td bgcolor="$body_bgcolor" align="center" background="AdminCtr.gif"><img src="AdminLogo.jpg" width="264" height="84" /></td>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="urcorner"><div align="center" class="header">Database Administration</div></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center" class="topnav"><strong><a href="admin.php">Admin
            Home</a> | <a href="/" target="_blank">Website Homepage</a> | <a href="admin.php?m=logout">Logout</a></strong></p>
	<div><img src="brownpixel.gif" width="100%" height="1" /></div>	

    <p align="center" class="secheader">Admin Home</p>

  <tr>
    <td>&nbsp;</td>
    <td><p align="center" class="bodytext"><strong>You are not
	      logged in.<br>
        Please log in to use the Database Admin.</strong></p>
	<p>&nbsp;</p>
	<div align="center" class="bodytext">
<form action="admin.php" method="post" class="sansblk14">
  <b>Enter Password:</b> 
  <input type="password" name="admin_pswd">
<br>
<br>
<input type="submit" value="Login To Database Admin">
</form>
</div>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>

</table>
_END_;
}

function links_page() {
  global $body_bgcolor,$site_name;
  $full_path_to_root=dirname(realpath("admin.php"));
  print <<<_END_
<table width="712" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEDFCD">
  <tr>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="ulcorner"><div align="center" class="header">$site_name</div></td>
    <td bgcolor="$body_bgcolor"><img src="AdminLogo.jpg" width="264" height="84" /></td>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="urcorner"><div align="center" class="header">Database Administration</div></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center" class="topnav"><strong><a href="admin.php">Admin
            Home</a> | <a href="/" target="_blank">Website Homepage</a> | <a href="admin.php?m=logout">Logout</a></strong></p>
	<div><img src="brownpixel.gif" width="712" height="1" /></div>		
    <p align="center" class="secheader">Admin Home</p>
    <table width="400" align="center" cellpadding="8" cellspacing="3" bgcolor="#FFFFFF" class="maintable">
      <tr>
        <td align="center" bgcolor="#BF966B"><strong>Email</strong></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
		  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="bodytext">
 		    <tr>
		      <td align="left"><a href="show_table.php?cfg=email_list">Add/Edit/Delete Email List Records</a></td>
		      </tr>
 		    <tr>
		      <td align="left"><a href="email_to_list.php?p=1">Email to List</a></td>
		      </tr>
		    </table>
		  </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><img src="AdminBottom.gif" width="712" height="23" /></td>
  </tr>
</table>
_END_;

}

function head() {
  global $onload,$banner_bgcolor,$body_bgcolor;
  print <<<_END_
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <title>$site_name Database Admin</title>
  <link href="/db/admin-styles.css" rel="stylesheet" type="text/css" />

<script language = "Javascript">
<!--
function pop_upload(loc) {
  upload_window = window.open (loc,
  "upload_window","location=0,status=0,scrollbars=1,width=580,height=500");
  upload_window.focus();
}
// -->
</script>
</head>
<body $onload>
_END_;
}
?> 

</body>
</html>
