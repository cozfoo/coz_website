<?php
error_reporting(E_ALL);
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");
$ID_field_name = isset($ID_field_name) ? $ID_field_name : "ID";
$ID = $rv_ID;
$call_script = "edit_rec";
$config_file = "cfg_" . $rv_cfg . ".php";
require $config_file;
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}

$ID = $rv_ID;
$link = db_connect($db_name);

$inName_str = "";
$inVal_str = "";
$Set_str = "";
//--------------------------------------------------
print <<< bodytext1
<html><head><title>$title</title></head>
$db_stylesheet_spec
<BODY bgcolor="$body_bgcolor" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
$db_admin_banner
<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH="100%">
<TR><TD ALIGN=center CLASS=$db_table_disp_class>
bodytext1;
//
foreach ($_POST as $nam => $val) {
  //echo "$nam => $val<br>";
  /*unless (($nam =~ /^ext_file_/)||($nam =~ /^img_upload_/)||($nam eq "full_image")||($nam eq "upload_filename")||($nam eq "cfg")||($nam eq "m")||($nam eq "cart_admin")||($nam eq "most_recent_edit")||($nam =~ /^ignore/)) { */
  if (HTML_obj($nam) == "checkbox") { /* the html obj name must have '[]' appended */
    $cb_val = "|".implode("|", $val)."|";
    $Set_str .= "$nam='$cb_val',";
    $cbset[$nam] = true;
  }
  else if ( !preg_match("/^ext_file_/",$nam) &&
       !preg_match("/^img_upload_/",$nam) &&
       !preg_match("/^ignore/",$nam) &&
       !preg_match("/^ext_file_hidden_/",$nam) &&
       ($nam != $ID_field_name) &&
       ($nam != "upload_filename") &&
       ($nam != "per_sist") &&
       ($nam != "cfg") &&
       ($nam != "m") &&
       ($nam != "cart_admin") &&
       ($nam != "most_recent_edit") ) {
	$inName_str .= "$nam,";
    if (!get_magic_quotes_gpc()) {
        $val = addslashes($_POST[$nam]);
    } else {
        $val = $_POST[$nam];
    }
	$inVal_str .= "'$val',";
	$Set_str .= "$nam='$val',";
    //echo "$nam='$val',<br>";
  }
  if ($nam == "most_recent_edit") {
    $Set_str .= "most_recent_edit=NOW(),";
  }
  elseif (preg_match("/^img_upload_/",$nam)) {
    $mysql_nam = $nam;
	$mysql_nam = preg_replace("/^img_upload_(.*)$/","$1",$mysql_nam);
    $img_path = added_str($mysql_nam);
    if (preg_match("/^img_upload_remove_/",$nam)) {
	  preg_replace("/^img_upload_remove_(.*)$/","$1",$nam);
      $Set_str .= "$nam='',";
	}
  }
  elseif (preg_match("/^ignore_checkbox_(.+)/",$nam,$cbmatch)) {
    $mysql_nam = $cbmatch[1];
    $cbs[$cbmatch[1]] = $val;
  }
  else if (preg_match("/^ext_file_/",$nam))  {
    $mysql_nam = $nam;
    if (preg_match("/^ext_file_remove_/",$nam))  {
	  $mysql_nam = preg_replace("/^ext_file_remove_(.*)$/","$1",$mysql_nam);
      $ext_file_path = $full_path_to_htdocs . added_str($mysql_nam) . "/" . $val;
      unlink($ext_file_path);
      $Set_str .= "$mysql_nam='',";
	}
    else {
	  $mysql_nam = preg_replace("/^ext_file_hidden_(.*)$/","$1",$mysql_nam);
      $FILES_name = "ext_file_upload_" . $mysql_nam;
      $ext_file_path = $full_path_to_htdocs . added_str($mysql_nam) . "/" .
        basename( $_FILES[$FILES_name]['name']);
      if (basename( $_FILES[$FILES_name]['name']) != "") {
        if(move_uploaded_file($_FILES[$FILES_name]['tmp_name'], $ext_file_path)) {
          print
            "The file <b>". basename( $_FILES[$FILES_name]['name']) .
             "</b> has been uploaded<br>";
          chmod("$ext_file_path",0777);
          $inVal_str .= "'" . basename( $_FILES[$FILES_name]['name']) . "',";
          $inName_str .= "$mysql_nam,";
          $Set_str .= "$mysql_nam=" . "'" . basename( $_FILES[$FILES_name]['name']) . "',";
          list($com,$w,$h) = explode(":",added_str2($mysql_nam));
           if (strpos($com,"resize") !== FALSE) {
            //echo "resize_jpeg($ext_file_path,$w,$h)";
            resize_jpeg($com,$ext_file_path,$w,$h);
          }
        }
        else{
          print "There was an error uploading " .$uploadErrors[$_FILES[$FILES_name]["error"]].
          basename( $_FILES['full']['name']).", please try again! ($ext_file_path)<br>";
        }
      }
    }
  }
}
// any 'missing' checkboxes?
if (isset($cbs)) {
    foreach ($cbs AS $thisCBnam => $thisCBval) {
        if (isset($cbset[$thisCBnam])) { continue; }
        // else set the field to blank
        $Set_str .= "$thisCBnam='',";
    }
}
/*(my $upload_filename,my $file_uploaded)= split(/\|/,grab_file());
if ($file_uploaded ne "") {
  $file_uploaded =~ s/'/\\'/g;
  $Set_str .= "text='$file_uploaded',";
  $Set_str .= "upload_date=NOW(),";
  $Set_str .= "upload_filename='$upload_filename',";
}*/
$inName_str = preg_replace('/,$/','',$inName_str);
$inVal_str = preg_replace('/,$/','',$inVal_str);
$Set_str = preg_replace('/,$/','',$Set_str);
$ID_val = $_POST[$ID_field_name];
#$Set_str =~ s/''/null/g;
$in_str = "UPDATE $tbl_name SET $Set_str WHERE $ID_field_name=$ID_val";
//print "<br>**$in**in_str=$in_str<br>";
//printf("MySQL server version: %s\n<br>", mysql_get_server_info());
//echo 'Current PHP version: ' . phpversion();
$props = mysql_query($in_str) or die("<br><b>Select Failed!</b><br>$in_str<br>".mysql_errno($link)." : ".mysql_error($link));

$cart_admin = $rv_cart_admin;
if ($cart_admin) {
  $all_rec_script = "show_cart.pl";
}
else {
  $all_rec_script = "show_table.php";
}

if ($edit_rec_return_to_table_link) { #defined in cfg file?
  $edit_rec_return_link = $edit_rec_return_to_table_link;
}
else {
  $cfg_param=$rv_cfg;
  $edit_rec_return_link = "<A HREF=$all_rec_script?cfg=$cfg_param CLASS=$db_table_link_class>[Return to All records table]</A>";
}
//##########
if (function_exists(post_edit)) {
    post_edit($ID_val);
}
//##########
print <<< _END_
<table width="65%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="$rec_outer_tbl_bgcolor">
  <tr>
    <td height="67">&nbsp;</td>
    <td>
	<div class="alertbox" align="center">
	     <span class="sansblk14"><strong>$rec_name_singular edit has been saved.</strong></span>
	</div>
	<p align="center">$edit_rec_return_link
    <td>&nbsp;</td>
  </tr>
</table>

<BR><BR>
$script_links
$bottom_links
_END_;
########
#print "<br>$inName_str<br>$inVal_str<br>";
//print"</TD></TR></TABLE>";
echo <<< _END_
</TD></TR></TABLE>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</table>
<BR><BR></BODY></HTML>
_END_;

?>
