<?php
require_once("db_globals.php");
if (!check_admin_cookie()) {
  echo "No Admin cookie";
  exit;
}
//import_request_variables("gp", "rv_");
$ID = $rv_ID;
$call_script = "add_new_item";
$config_file = "cfg_" . $rv_cfg . ".php";
require $config_file;
if (!admin_pswd_OK()) {
  print "Not logged in with admin password";
  exit;
}
db_connect();
$inName_str = "";
$inVal_str = "";
$Set_str = "";
/* -------------------------------------- */
print <<< bodytext1
<html><head><title>$title</title></head>
$db_stylesheet_spec
<BODY bgcolor="$body_bgcolor" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
$db_admin_banner
<CENTER>
<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH="100%">
<TR><td>&nbsp;</td><TD ALIGN=center CLASS=$db_table_disp_class>
bodytext1;

foreach ($_POST as $nam => $val) {
  //print "$nam => $val<br>";
  /*unless (($nam =~ /^ext_file_/)||($nam =~ /^img_upload_/)||($nam eq "full_image")||($nam eq "upload_filename")||($nam eq "cfg")||($nam eq "m")||($nam eq "cart_admin")||($nam eq "most_recent_edit")||($nam =~ /^ignore/)) { */

  if (HTML_obj($nam) == "checkbox") { /* the html obj name must have '[]' appended */
    $cb_val = "|".implode("|", $val)."|";
	$inName_str .= "$nam,";
	$inVal_str .= "'$cb_val',";
  }
  else if ( !preg_match("/^ext_file_/",$nam) &&
       !preg_match("/^img_upload_/",$nam) &&
       !preg_match("/^ignore/",$nam) &&
       !preg_match("/^ID$/",$nam) &&
       !preg_match("/^ext_file_hidden_/",$nam) &&
       ($nam != "per_sist") &&
       ($nam != "upload_filename") &&
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
  }
  if ($nam == "most_recent_edit") {
    $Set_str .= "most_recent_edit=NOW(),";
  }
  /*elseif (preg_match("/^img_upload_/",$nam)) {
    $mysql_nam = $nam;
	$mysql_nam = preg_replace("/^img_upload_(.*)$/","$1",$mysql_nam);
    $img_path = added_str($mysql_nam);
    if (preg_match("/^img_upload_remove_/",$nam)) {
	  preg_replace("/^img_upload_remove_(.*)$/","$1",$nam);
      $Set_str .= "$nam='',";
	}
  }*/
  else if (preg_match("/^ext_file_hidden_/",$nam))  {
    $mysql_nam = $nam;
	$mysql_nam = preg_replace("/^ext_file_hidden_(.*)$/","$1",$mysql_nam);
    $FILES_name = "ext_file_upload_" . $mysql_nam;
    $ext_file_path = $full_path_to_htdocs . added_str($mysql_nam) . "/" .
      basename( $_FILES[$FILES_name]['name']);
    //print "$mysql_nam ** $FILES_name ** $ext_file_path ** ";
    if (basename( $_FILES[$FILES_name]['name']) != "") {
      if(move_uploaded_file($_FILES[$FILES_name]['tmp_name'], $ext_file_path)) {
        print
          "The file <b>". basename( $_FILES[$FILES_name]['name']) .
           "</b> has been uploaded<br>";
        chmod("$ext_file_path",0777);
        $inVal_str .= "'" . basename( $_FILES[$FILES_name]['name']) . "',";
        $inName_str .= "$mysql_nam,";
        list($com,$w,$h) = explode(":",added_str2($mysql_nam));
        if (strpos($com,"resize") !== FALSE) {
            //echo "resize_jpeg($ext_file_path,$w,$h)";
            resize_jpeg($com,$ext_file_path,$w,$h);
        }
      }
      else{
        print "There was an error uploading: " .$uploadErrors[$_FILES[$FILES_name]["error"]] .
        basename( $_FILES['full']['name']).", please try again!<br>";
      }
    }
  }
}
$inName_str = preg_replace('/,$/','',$inName_str);
$inVal_str = preg_replace('/,$/','',$inVal_str);
$Set_str = preg_replace('/,$/','',$Set_str);

$in_str = "INSERT INTO $tbl_name ($inName_str) VALUES ($inVal_str)";
$props = mysql_query($in_str) or die("<b>Select Failed!</b><br>$in_str<br>");
//##########
$insertId = mysql_insert_id();
if (function_exists(post_add)) {
    global $insertId;
    $script_links = post_add($insertId);
}
else {
    $script_links = "";
}
//##########

$dn = $db_name;
$tn = $tbl_name;
$cfg_param=$rv_cfg;
 //...might be defined in cfg file
if (!$add_new_return_link) {
$add_new_return_link = <<< _END_
<A HREF="show_table.php?cfg=$cfg_param&per_sist=$rv_per_sist" CLASS="$db_table_link_class"><B>[Return to All records table]</B></A>
_END_;
}

print <<< _END_
	<div class="alertbox" align="center">
	     <span class="sansblk14"><strong>The new $rec_name has been added to the
	     $rec_name Database.</strong></span>
	</div>
	<p align="center">$add_new_return_link<BR><BR>$bottom_links<BR><BR>$script_links
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="AdminBL.gif" width="25" height="23" /></td><td></td><td align="right"><img src="AdminBR.gif" width="25" height="23" /></td>
  </tr>
</table>
_END_;

//print "<br>$inName_str<br>$inVal_str<br>";
print "</BODY></HTML>";

?>
