<?php
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");
$call_script = "delete_rec";
$config_file = "cfg_" . $rv_cfg . ".php";
require $config_file;
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}
db_connect();
//--------------------------------------------------
print <<< bodytext1
<html><head><title>$title</title></head>
$db_stylesheet_spec
<BODY bgcolor="$body_bgcolor" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
$db_admin_banner

<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH="100%">
<TR><TD ALIGN=center CLASS=$db_table_disp_class>
bodytext1;
//--------------------------------------------------
foreach ($rv_del_chk as $ID2del) {
    //##########
    $OK2Delete = TRUE;
    $msg = "";
    if (function_exists(pre_delete)) {
        $OK2Delete = pre_delete($tbl_name,$ID2del);
    }
    //##########
    if ($OK2Delete !== FALSE) {
        $in_str = "DELETE FROM $tbl_name WHERE $ID_field_name='$ID2del'";
        $result = mysql_query($in_str) or die("<b>Delete Failed!</b><br>$in_str<br>");
        $msg = "Selected $rec_name(s) have been deleted from<br>the $rec_name Database.";
    }
    //##########
    if (function_exists(post_delete)) {
        post_delete($tbl_name,$ID2del);
    }
    //post_delete($tbl_name,$ID2del);
    //##########
    // print "Item <b>$ID2del</b> has been deleted from <b>$tbl_name</b><BR>\n";
}
//--------------------------------------------------
print <<< _END_
<table width="65%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="67">&nbsp;</td>
    <td>
	<div class="alertbox" align="center"><br><br>
	     <span class="bodytext11"><strong>$msg</strong></span>
	</div>
	<p align="center">$delete_return_link</p>
    <td>&nbsp;</td>
  </tr>
</table>
	<p align="center">$bottom_links</p>
</TD></TR>
</TABLE>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</TD></TR>
</TABLE>

<BR>
</BODY></HTML>
_END_;
//--------------------------------------------------
?>

