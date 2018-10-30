<?php
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");
$call_script="new_item_form";
$config_file = "cfg_" . $rv_cfg . ".php";
require $config_file;
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}
db_connect($db_name);
$disp_ary = mysql_query("SELECT $all_fields_sql FROM $tbl_name") or die("<b>Select Failed!</b><br>sql: SELECT $all_fields_sql FROM $tbl_name<br>$config_file");
$disp_row_ary = mysql_fetch_array($disp_ary);

print <<< bodytext1
<HTML><HEAD><TITLE>$title</TITLE>
$db_stylesheet_spec
$chkform_inc
$comp_opts_inc
</HEAD>
<BODY>
$db_admin_banner
<table widthz="65%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="$rec_outer_tbl_bgcolor">

bodytext1;

/*$dn = display_name($db_name);
$tn = display_name($tbl_name);*/
$dn = $db_name;
$tn = $tbl_name;

# START FORM DISPLAY PARTLY USING SUBROUTINE....
# must do these before calling display_record:
# @disp_ary = $sth->fetchrow_array(); (this is for NEW record, so there's no data to display...

//print "<TR><TD ALIGN=left CLASS=$db_table_disp_class>This is the page for entering a <B>New Item</B>...</TD></TR>";
//print "<TR><TD ALIGN=left CLASS=$db_table_disp_class>Database: <B>$dn</B> &nbsp;&nbsp;Table: <B>$tn</B><BR>$db_entry_instructions</TD></TR></TABLE>";

print <<<_END_


  <tr>
    <td>&nbsp;</td>
    <td><br>
	$common_sub_header
      <p align="center" class="$rec_table_header_class">Add a new $rec_name</p>
      <span class="$show_table_text_class">$new_item_instructions</span>
	  <form action="add_new_item.php" method=post enctype="multipart/form-data">
      <INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>
      <INPUT TYPE=hidden NAME=per_sist VALUE=$rv_per_sist>
     <table align="center" width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="$rec_tbl_bgcolor">
_END_;


//print"<FORM action='add_new_item.php' method=post ENCTYPE=\"multipart/form-data\">";
//print "<TABLE CELLPADDING=4 CELLSPACING=0 BORDER=1 WIDTH=600 BGCOLOR=$rec_tbl_bgcolor>";
# then call it immediately...
#$preselect_dropdown_for_new_item_form = $in{cat};
display_record();

# then must finish up form:
//print "</TD></TR></TABLE>";

if ($new_item_cancel_link) { #defined in cfg file?
  $cancel_link = $new_item_cancel_link;
}
else {
  $cancel_link = "<A HREF=\"show_table.php?cfg=$rv_cfg&per_sist=$rv_per_sist\" CLASS=$db_table_link_class>CANCEL EDIT</A> and return to main page";
}
/*
print <<<_END_
    </table>
	<p align="center">$cancel_link</p>
	<p align="center"><INPUT type=submit value='Add'>
	</INPUT> this $rec_name to $rec_name database.	</p>
	  </form>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_ll.gif" width="28" height="28"></td>
    <td>&nbsp;</td>
    <td width="28" height="28" BGCOLOR="$body_bgcolor"><img src="corner_lr.gif" width="28" height="28"></td>
  </tr>
</table>

_END_;
print"</TD></TR></TABLE>$bottom_links<BR><BR><BR></BODY></HTML>";
*/
print <<<_END_


_END_;
//##########
if (function_exists(post_get_rec)) {
    $script_links = post_get_rec($ID);
}
//##########
echo <<< _END_
</TD></TR></TABLE><br>
<div align="center"><INPUT type=submit value='Add'></div>
	</form>
</td>
  </tr>
</table><br>
<div align="center">$script_links$bottom_links</div>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</table>

<BR><BR></BODY></HTML>
_END_;
?>
