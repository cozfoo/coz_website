<?php
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");
$call_script="get_rec";
$config_file = "cfg_" . $rv_cfg . ".php";
require $config_file;
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}
$ID = $rv_ID;

print <<< bodytext1
<html><head><title>$title</title>
$db_stylesheet_spec
$CheckFormJavaScript
</head>
<BODY>
$db_admin_banner
<table width="65%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="$rec_outer_tbl_bgcolor">
<!--   <tr>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_ul.gif" width="28" height="28"></td>
    <td>&nbsp;</td>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_ur.gif" width="28" height="28"></td>
  </tr> -->
  <tr>
    <td>&nbsp;</td>
    <td><br>
	$common_sub_header
      <p align="center" class="$rec_table_header_class">Edit an existing $rec_name_singular</p>
      <span class="$show_table_text_class">$get_rec_instructions</span>
bodytext1;

db_connect($db_name);
if ($all_fields_sql != "") {
  $sel_str = "SELECT $all_fields_sql FROM $tbl_name WHERE ID = $ID";
}
else { $sel_str = compose_all_fields_sql(); }
//echo $sel_str;
$disp_ary = mysql_query($sel_str) or die("<b>Select Failed!</b><br>$sel_str<br>");
$disp_row_ary = mysql_fetch_array($disp_ary);

//$dn = display_name($db_name);
//$tn = display_name($tbl_name);
//print("<TR><TD ALIGN=left CLASS=$db_table_disp_class>This is the page for <B>Editing an Existing $rec_name_singular</B>...</TD></TR>\n");
//print("<TR><TD ALIGN=left CLASS=$db_table_disp_class>Table: <B>$tbl_name</B><BR><BR>$db_entry_instructions</TD></TR></TABLE>\n");

if ($CheckFormJavaScript) {
  $CheckFormJavaScriptONSUBMIT = "ONSUBMIT='return CheckForm(this);'";
}
else {
  $CheckFormJavaScriptONSUBMIT = "";
}

print("<TABLE CELLPADDING=3 CELLSPACING=3 BORDER=0 WIDTH=100% BGCOLOR=$rec_tbl_bgcolor>\n");
print("<FORM action='edit_rec.php' method=post ENCTYPE=\"multipart/form-data\" $CheckFormJavaScriptONSUBMIT>\n");
if ($rv_cart_admin) {
  print ("<INPUT TYPE=hidden NAME=cart_admin VALUE=1>");
}
//# then call it immediately...
display_record();
//# then must finish up form:
//print("</TD></TR></TABLE>");

if (0==1) { //#defined in cfg file?
  $get_rec_cancel_link = "<A HREF=\"show_table.php?cfg=$rv_cfg\" CLASS=$db_table_link_class>CANCEL EDIT</A> and return to Admin Index for this section";
}
print("</TD></TR></table>	<p align=\"center\">$get_rec_cancel_link <p align=\"center\"><INPUT type=submit value='Save'> </INPUT> edits to this $rec_name_singular.</p>");
if ($rv_m) { print("<INPUT TYPE=hidden NAME=m VALUE=$rv_m>"); }
print("<INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>");
print("<INPUT TYPE=hidden NAME=per_sist VALUE=$rv_per_sist>");

print <<<_END_
	</form>
	<td>&nbsp;</td>
  </tr>
<!--   <tr>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_ll.gif" width="28" height="28"></td>
    <td>&nbsp;</td>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_lr.gif" width="28" height="28"> -->
_END_;
//##########
if (function_exists(post_get_rec)) {
    $script_links = post_get_rec($ID);
}
//##########
echo <<< _END_
<!-- </TD></TR> --></TABLE>
<div align="center">$script_links$bottom_links</div>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</table>
<BR><BR></BODY></HTML>
_END_;
?>