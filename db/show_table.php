<?php
error_reporting(E_ERROR);
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");

$ID_field_name = isset($ID_field_name) ? $ID_field_name : "ID";
$ID = $_GLOBALS['rv_ID'];//$rv_ID;
$call_script = "show_table";
$config_file = "cfg_" . $rv_cfg . ".php";
require_once($config_file);
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}

$inName_str = "";
$inVal_str = "";
$Set_str = "";

if (!(($rv_cat == "") && ($categories))) {
    $mysql_link=db_connect();
    $sel_str = $show_table_sql;
    $res = mysql_query($sel_str) or die("<b>Select Failed!</b><br>$sel_str<br>errnum:".
       mysql_errno($mysql_link) . ": " . mysql_error($mysql_link));
    $total_rows = mysql_num_rows($res);
}

if (isset($recs_per_page)) { //in cfg file
    /*if (!isset($_SESSION['start_rec'][$rv_cfg])) {
        $start_rec = 0;
    }
    else {
        $start_rec = $_SESSION['start_rec'][$rv_cfg] + $recs_per_page;
    }
    if ($start_rec > $total_rows) {
        $start_rec = 0;
    }
    $_SESSION['start_rec'][$rv_cfg] = 0;
    */
    //create page links
    if (isset($rv_start_rec) && $rv_start_rec != "") {
        $start_rec = $rv_start_rec;
    }
    /*else if (isset($_SESSION['start_rec'][$rv_cfg]) && $_SESSION['start_rec'][$rv_cfg] != "") {
        $start_rec = $_SESSION['start_rec'];
        //echo "set $rv_cfg start to $start_rec";
    }*/
    else {
        $start_rec = 0;
    }
    $prev_start_rec = $start_rec - $recs_per_page;
    if ($prev_start_rec < 0) {
        $prev_start_rec_link = "";
    }
    else {
        $prev_start_rec_link =
        "&lt;&lt;&nbsp;<a href=\"show_table.php?cfg=$rv_cfg&per_sist=$rv_per_sist&start_rec=$prev_start_rec&order_by=$rv_order_by\" CLASS=$db_table_link_class>Previous</a>&nbsp;";
    }
    $next_start_rec = $start_rec + $recs_per_page;
    if ($next_start_rec > $total_rows) {
        $next_start_rec_link = "<br><br>";
    }
    else {
        $next_start_rec_link =
             "-&nbsp;&nbsp;<a href=\"show_table.php?cfg=$rv_cfg&per_sist=$rv_per_sist&start_rec=$next_start_rec&order_by=$rv_order_by\" CLASS=$db_table_link_class>Next</a>&nbsp;&gt;&gt;&nbsp;<br><br>";
    }
    $page_num = 1;
    $page_start_rec = 0;
    $lnks_ct = 0;
    while ($page_start_rec < $total_rows) {
        $disp_page_num = sprintf("% 4d",$page_num);
        if ($page_start_rec == $start_rec) {
            $page_links .= $prev_start_rec_link == "" ? "" : "-&nbsp;";
            $page_links .= "<b>$disp_page_num</b> ";
        }
       else {
            $page_links .= 
            "-&nbsp;<a href=\"show_table.php?cfg=$rv_cfg&per_sist=$rv_per_sist&start_rec=$page_start_rec&order_by=$rv_order_by\" CLASS=$db_table_link_class>$disp_page_num</a> \n";
        }
        if (++$lnks_ct == 15) {
            //$page_links .= "<br>";
            $lnks_ct = 0;
        }
        $page_num++;
        $page_start_rec += $recs_per_page;
    }
    $sel_str = $show_table_sql . " LIMIT $start_rec,$recs_per_page";
    $res = mysql_query($sel_str) or die("<b>Select Failed!</b><br>$sel_str<br>errnum:". mysql_errno($mysql_link) .
     ": " . mysql_error($mysql_link));
}
$_SESSION['start_rec'][$rv_cfg] = $start_rec;
//echo $rv_cfg.$start_rec;
//$sel_str .= " LIMIT $start_rec,$recs_per_page";
#print $db_name.$sel_str;

//--------------------------------------------------
print <<< bodytext1
<HTML><HEAD><TITLE>$title</TITLE>
<SCRIPT LANGUAGE="JavaScript">
var del_action;
function deleteChk() {
    if (del_action == "delete"){
      for (i=0; i<del_form.elements.length; i++){
        if (del_form.elements[i].name == "del_chk[]") {
          if (del_form.elements[i].checked) {
            if (confirm("Delete these records?"))  {
    	      return true;
    	    }
    	    else return false;
          }
        }
      }
    }
  $show_table_checkform_additions
  alert("nothing checked");
  return false;
}
function selAll() {
    for (i=0; i<del_form.elements.length; i++){
        if (del_form.elements[i].name == "del_chk[]") {
            del_form.elements[i].checked = true;
        }
    }
}
bodytext1;
print("</SCRIPT>");
print <<< bodytext2
$db_stylesheet_spec
</HEAD>
<BODY bgcolor="$body_bgcolor" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
$db_admin_banner
$show_table_top_text
bodytext2;
/*########################################  INDEX?
//# if there is no $in{sec} and there is a cats array, this must be a request for a
//# section index*/
if (($rv_cat == "") && ($categories)) {
  print <<< bodytextIDX
<TABLE ALIGN="center" BORDER="0" CELLPADDING=0 CELLSPACING=0>
<TR><TD CLASS=$db_table_disp_class><B>
<br>
bodytextIDX;
  foreach ($categories as $cat_code => $cat_str) {
    /*if ($disp_cat{$cat_str} ne "") { $disp_cat_item = $disp_cat{$cat_str}; }
	else {
      $disp_cat_item = $_;
      $disp_cat_item =~ s/_/ /g;
	}
	if ($disp_cat_item eq "") { $disp_cat_item = "[blank]";}
    $_ =~ s/ /%20/g;*/
    $persist_str = get_persist_string("cat-$cat_code");
    print "<A HREF=\"show_table.php?cfg=$rv_cfg&per_sist=$persist_str&cat=$cat_code\" CLASS=$db_table_link_class>$cat_str</A><BR>";
  }
  print $show_all_link; #in cfg file, as are those next line
  print  <<< _END_
</B><BR></TD></TR><tr><td align="center">$bottom_links</td></tr></TABLE></BODY>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
</tr>
</TABLE></BODY></HTML>
_END_;
  exit;
}
/*########################################### LIST VIEW
# if cfg file has variable set, show switches in list view
if ($show_table_online_switches_field) {
  $online_switches_button = <<"_ONLINE_";
<TABLE CELLPADDING=2 BORDER="0">
<TR><TD VALIGN=top COLSPAN="2">
<FONT CLASS=$show_table_text_class>
Check the box to take offline OR uncheck the box to place online</FONT>
<BR><INPUT TYPE="button" NAME="online_button" VALUE="SET ONLINE STATUS" ONCLICK="javascript:document.del_form.action='set_online_status.pl';document.del_form.submit()">
</TD></TR>
</TABLE>
_ONLINE_
}*/
if (!$show_table_disable_add_new) {
  $add_newOBS = <<< _END_
<FORM action=new_item_form.php method=get>
<TABLE CELLPADDING=2 BORDER="0"><TR><TD VALIGN=top>
<INPUT TYPE=submit value="&nbsp; &nbsp; New &nbsp;&nbsp;"></INPUT></TD><TD><FONT CLASS=$show_table_text_class><B>TO ADD NEW ITEM<BR> TO DATABASE</B></FONT>
</TD></TR>
</TABLE><INPUT TYPE=hidden NAME=cat VALUE="$rv_cat"><INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>$add_new_preselect_hiddens</FORM>
_END_;
  $add_new = <<< _END_
<form action=new_item_form.php method=get>
<p align="center">
<INPUT TYPE=submit value="&nbsp; &nbsp; New &nbsp;&nbsp;">
</INPUT>To add a new $rec_name to $rec_name database.
</p>
<INPUT TYPE=hidden NAME=cat VALUE="$rv_cat"><INPUT TYPE=hidden NAME=per_sist VALUE="$rv_per_sist"><INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>$add_new_preselect_hiddens
</form>
_END_;
}
if (!$show_table_disable_delete) {
  $del_tblOBS = <<< _END_
<TABLE CELLPADDING=2 BORDER="0"><TR><TD VALIGN=top>
<INPUT type=submit value="&nbsp; Delete &nbsp;"></INPUT></TD><TD><FONT CLASS=$show_table_text_class><B>WILL DELETE ALL ITEMS<BR> CHECKED BELOW</B></FONT>
</TD></TR>
</TABLE>
_END_;
  $del_tbl = <<< _END_
<p align="center"><input type=submit value="&nbsp; Delete &nbsp;" onclick="del_action='delete'">
  </input> Will delete all $rec_name checked above.</p>
	  <INPUT TYPE=hidden NAME=cat VALUE="$rv_cat"><INPUT TYPE=hidden NAME=per_sist VALUE="$rv_per_sist"><INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>
_END_;
} 
/*
#$dn = display_name($db_name);
#$tn = display_name($tbl_name);
$click_fld = col_disp_name($sth->{'NAME'}->[0]);
$click_fld =~ s/://g;  */
/*print <<< bodytext2

<TABLE BORDER="0" CELLPADDING=0 CELLSPACING=0 WIDTH=500>
<TR><TD valign=top>
<FONT COLOR="#FF0000" FACE="Arial,Verdana" SIZE="-1"><B>Click on Link Below $click_fld to View/Edit a $rec_name</B></font>
</TD>
<TD valign=top>
$add_new
<FORM NAME="del_form" action=delete_rec.php method=post ONSUBMIT="return(deleteChk());">
<INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>
$del_tbl
$online_switches_button
</TD></TR></TABLE>
bodytext2;*/


print <<< bodytext2
<FORM NAME="del_form" action=delete_rec.php method=post ONSUBMIT="return(deleteChk());">
<INPUT TYPE=hidden NAME=cfg VALUE=$rv_cfg>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor=$show_table_outer_table_bgcolor>
  <tr>
    <td>&nbsp;</td>
    <td>
	$common_sub_header
bodytext2;

if (isset($show_table_instructions) && ($show_table_instructions != "")) {
    echo "<p align='left' class='sans_tan20'>".$show_table_instructions."</p>";
}

print "<TABLE cellpadding=3 cellspacing=3 border=0 width=100% class=$db_table_class bgcolor=$show_table_bgcolor><TR>";
# print column titles
for ($i=0;$i<mysql_num_fields($res);$i++) {
  $tt=col_disp_name(mysql_field_name($res, $i));
  $tt = preg_replace('/:/', '', $tt);
  $ht=HTML_obj(mysql_field_name($res, $i));
  if (!(mysql_field_name($res, $i)==$ID_field_name)) {
    $field_name = mysql_field_name($res, $i);
    if ($field_name == $show_table_aux_link_field) {
      print "<td nowrap CLASS=$db_table_disp_class BGCOLOR=$show_table_head_bgcolor align=center>$tt </td>\n";
    }
    else {
      print "<td nowrap CLASS=$db_table_disp_class BGCOLOR=$show_table_head_bgcolor align=center><A HREF=\"show_table.php?cfg=$rv_cfg&cat=$rv_cat&per_sist=$rv_per_sist&start_rec=$rv_start_rec&order_by=$field_name$sec_cat\" CLASS=$db_table_link_class><B>$tt</B></A></td>\n";
    }
  }
  /* else if (($ht == "show_only_other_tbl")||
    ($ht == "show_pic_indirect_address")) {
    print "<td nowrap CLASS=$db_table_disp_class BGCOLOR=$show_table_head_bgcolor><A HREF=\"javascript:alert('Sort not available for this field in this table view')\" CLASS=$db_table_link_class><B>$tt</B></A></td>\n" unless ($sth->{'NAME'}->[$i] eq 'ID');
  }  */
  
}
if (isset($use_edit_buttons)) {
  print  "<td nowrap align=center CLASS=$db_table_disp_class BGCOLOR=$show_table_head_bgcolor><b>Edit</b></TD>\n";
}
if (!$show_table_disable_delete) {
print "<td nowrap align=center CLASS=$db_table_disp_class BGCOLOR=$show_table_head_bgcolor><b>$show_table_checkform_header</b><br><a href='javascript:selAll()'>all</a></TD></TR>\n";
}
echo "</TR>";
//* print data */
$ct = 0;
$rec_row_bgcolor = "";
while ($disp_ary = mysql_fetch_array($res, MYSQL_NUM)) {
  $ct++;
  $rec_row_bgcolor = $rec_alt_row_bgcolor == $rec_row_bgcolor? "" : $rec_alt_row_bgcolor;
  print "<TR bgcolor=$rec_row_bgcolor>";
  for ($i=0;$i<mysql_num_fields($res);$i++) {
	{
	if ($disp_ary[$i] == "")  {
      $disp_ary[$i] = "&nbsp;";
    }
	$ht=HTML_obj(mysql_field_name($res, $i));
    $align=align(mysql_field_name($res, $i));
	   /*if ($ht eq "show_only_other_tbl")  {
          my $def = added_str(mysql_field_name($res, $i));
	     (my $sec_tbl, my $sec_tbl_field, my $sec_tbl_key_field) = split(/\^/,$def);
		  my $esc_param = $disp_ary[$i];
		  $esc_param =~ s/'/\\'/g;
		  my $sel_str = "SELECT $sec_tbl_field,ID FROM $sec_tbl WHERE
		    $sec_tbl_key_field = '$esc_param'";
		  my $sth = $dbh->prepare($sel_str);
          $sth->execute or bail_out("Can't execute sql: $sel_str");
		  my $rh = $sth->fetchrow_hashref();
          my $disp_item =
		    $rh->{$sec_tbl_field} eq ""? "&nbsp;" : $rh->{$sec_tbl_field};
		  #print $sel_str;
          print "<TD nowrap CLASS=$db_table_disp_class><a href=get_rec.pl?ID=$rh->{ID}&per_sist=$rv_per_sist&cfg=$sec_tbl CLASS=$db_table_link_class TARGET=_blank>$disp_item</a></TD>\n";
	    }
		elsif ($ht eq "show_pic_indirect_address") {
          my $sub_ptr_index = added_str($sth->{'NAME'}->[$i]);
		  my $sub_ptr = $func_ptrs[$sub_ptr_index];
		  #print $sub_ptr;
		  my $pic_address = &$sub_ptr($disp_ary[$i]);
		  #print $pic_address;
          print "<TD><IMG SRC=$pic_address BORDER=0 ALT=''></TD>\n";
		} */
	    if (mysql_field_name($res, $i) == $show_table_link_field)  {
		  if ($disp_ary[$i] == "&nbsp;") { $disp_ary[$i] = "[BLANK]"; }
		  //if ($in{m}) {$mode_param = "&m=$in{m}";}
          print "<TD nowrap CLASS=$db_table_disp_class align=$align><a href=get_rec.php?ID=$disp_ary[$ID_idx]&cfg=$rv_cfg&per_sist=$rv_per_sist$mode_param CLASS=$db_table_link_class>$disp_ary[$i]</a></TD>\n";
	    }
	    else if (mysql_field_name($res, $i) == $show_table_aux_link_field)  {
          $show_table_aux_link_href = &create_show_table_aux_link($disp_ary[$i]);
		  print "<TD nowrap CLASS=$db_table_disp_class align=$align>$show_table_aux_link_href</TD>\n";
	    }
	    /*elsif ($sth->{'NAME'}->[$i] eq $show_table_aux2_link_field)  {
		  if ($disp_ary[$i] eq "&nbsp;") { $disp_ary[$i] = "[BLANK]"; }
          $show_table_aux2_link_href = &create_show_table_aux2_link_href($disp_ary[$ID_idx]);
		  print "<TD nowrap CLASS=$db_table_disp_class><a href=$show_table_aux2_link_href  CLASS=$db_table_link_class>$disp_ary[$i]</a></TD>\n";
	    } */
		else if (mysql_field_name($res, $i) == $ID_field_name) {
          if (isset($use_edit_buttons)) {
              print "<TD  align=center CLASS=$db_table_disp_class><input name=\"editorder\" type=\"button\" id=\"editorder\" onclick=\"parent.location='get_rec.php?ID=$disp_ary[$i]&cfg=$rv_cfg&per_sist=$rv_per_sist'\" value=\"Edit\" /></input></TD>\n";
          }
		  if (!$show_table_disable_delete) {
            print "<TD  align=center CLASS=$db_table_disp_class><input type=checkbox name=del_chk[] value=$disp_ary[$i]></input></TD>\n";
          }
	    }
		/*elsif ($sth->{'NAME'}->[$i] eq "email") {
          print "<TD CLASS=$db_table_disp_class><A HREF=\"mailto:$disp_ary[$i]\" CLASS=$db_table_link_class>$disp_ary[$i]</A></TD>\n";
	    }
        elsif (($show_table_online_switches_field) &&
		  ($sth->{'NAME'}->[$i] eq $show_table_online_switches_field)) {
		    if ($disp_ary[$i] == 1) { 
			  $online_chkd = "CHECKED";
			  $offline_chkd = "";
			}
		    else {
			  $online_chkd = "";
			  $offline_chkd = "CHECKED";
			}
            print "<TD CLASS=$db_table_disp_class ALIGN=center>\n<INPUT TYPE=checkbox NAME=checkbox_online_$disp_ary[$ID_idx] $offline_chkd ONCLICK=\"document.del_form.online_$disp_ary[$ID_idx].value=document.del_form.checkbox_online_$disp_ary[$ID_idx].checked?0:1;\"> Off Line\n<INPUT TYPE=hidden NAME=online_$disp_ary[$ID_idx] VALUE=$disp_ary[$i]></TD>\n";
          }*/
		else if ($ht == "cat_static") {
          $da_ = $disp_ary[$i];
          print "<TD CLASS=$db_table_disp_class align=$align>$categories[$da_]</TD>";
	    }
		else if ($ht == "dropdown") {
          global ${mysql_field_name($res, $i) ."_disp"}; 
          $disp_fld_name = ${mysql_field_name($res, $i) ."_disp"}; //must be defined in cfg file
          $da_ = $disp_ary[$i];
          //var_dump($disp_fld_name);
          print "<TD CLASS=$db_table_disp_class align=$align>$disp_fld_name[$da_]</TD>";
	    }
		else {
          $elips = strlen($disp_ary[$i]) > 30 ? "...": "";
          print "<TD CLASS=$db_table_disp_class align=$align>".substr($disp_ary[$i], 0, 30).$elips . "</TD>";
	    }
	}
  }
  print "</TR>";
}
//print "</FORM>";
$total_html = "";
if (!empty($show_table_disp_total_records)) {
  $total_html =  "<DIV ALIGN=center CLASS=$db_table_disp_class><b>$ct $show_table_disp_total_records</b></DIV>";
}
//<A HREF="show_table.pl?cfg=$in{cfg}&cat=$in{cat}&order_by=$in{order_by}&start=$next_start_rec&per_sist=$rv_per_sist">next</A>$total_rows records
/*print <<< _END_
</TABLE><BR><BR>$bottom_links<BR><BR>
</TD></TR></TABLE></CENTER></BODY></HTML>
_END_;*/

print <<< _END_
	</TABLE>
    $total_html
    $del_tbl
    $show_table_checkform_buttons
    </form>
    $add_new
    $online_switches_button

	</td><td>&nbsp;</td>
  </tr>
  <tr><td></td>
    <td align="center" class=$db_table_disp_class>$prev_start_rec_link$page_links$next_start_rec_link</td><td></td>
  </tr>
</table>
  </td>
  </tr>
  <tr><td colspan="3" align="center">$bottom_links</td></tr>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</table>
</body></html>
_END_;
