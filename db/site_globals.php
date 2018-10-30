<?php
$global_OK_pswds = array("coz","p1b123df2o");
$full_path_to_htdocs=dirname(realpath("../db/"))."/";
//###################################################################
$site_name = "Blue Moon Daughter";
$title = "$site_name Database Administration";
$db_stylesheet_spec = "<LINK REL=STYLESHEET TYPE=text/css HREF=admin-styles.css>";

$db_table_disp_class = "bodytext11";
$db_table_class = "maintable";
$db_table_link_class = "topnav";
$show_table_text_class = "bodytext11";
$db_banner_bgcolor = "#8D1920";
$rec_tbl_bgcolor = "#FFFFFF";
$rec_table_header_class = "secheader";
$rec_outer_tbl_bgcolor = "#EEDFCD";
$rec_tbl_title_cell_bgcolor = "#BF966B";
$rec_tbl_data_cell_bgcolor = "#EEDFCD";
$rec_alt_row_bgcolor = "#EEDFCD";
$body_bgcolor = "#000000";
$show_table_head_bgcolor = "#BF966B";
$show_table_bgcolor = "#FFFFFF";
$show_table_outer_table_bgcolor = "#EEDFCD";

$ID_idx = substr_count($show_table_sql,","); # ID field index in $show_table_sql list
//###################################################################
$db_admin_banner = <<< _END_BANNER_
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEDFCD">
  <tr>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="ulcorner"><div align="center" class="header">$site_name</div></td>
    <td bgcolor="$body_bgcolor" align="center" background="AdminCtr.gif"><img src="AdminLogo.jpg" width="264" height="84" /></td>
    <td bgcolor="$body_bgcolor" width="224" valign="middle" class="urcorner"><div align="center" class="header">Database Administration</div></td>
  </tr>
  <tr>
    <td colspan="3"><p align="center" class="topnav"><strong><a href="admin.php">Admin
            Home</a> | <a href="/" target="_blank">Website Homepage</a> | <a href="admin.php?m=logout">Logout</a></strong></p>
	<div><img src="brownpixel.gif" width="100%" height="1" /></div>	
_END_BANNER_;
//###################################################################
function get_admin_page_dropdown($constants) {
///originally for pbo.org
$link = db_connect();
  if (1) {
    $query_st = "SELECT DISTINCT page FROM pages WHERE page NOT REGEXP '^(".$constants.")$' ORDER BY PAGE";
    $res = mysql_query($query_st)
      or die("<br><b>Page Select Failed!</b><br>$query_str<br>".
      mysql_errno($link)." : ".mysql_error($link));
    while ($rec = mysql_fetch_array($res)) {
      $dd .= $rec['page'] . " ";
    }
    $dd = preg_replace("/ $/","",$dd);
  }
  return $dd;
}
//###################################################################
function print_toolbar_div($field_name) {
    global $toolbar_js_loaded;
    if (!isset($toolbar_js_loaded)) {
        $toolbar_js_loaded = 1;
        print("<SCRIPT type=\"text/javascript\" src=\"toolbar.js\"></SCRIPT>");
    }
    echo <<< _END_
<div id="toolbar">
<b>Tools for HTML entry:</b>
<img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="insert('&bull;',document.forms[0].$field_name);" 
 src="bullet.gif" 
 width="16" height="16" 
 align="middle" 
 alt="click to insert bullet">
<img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="format_sel('b',document.forms[0].$field_name);" 
 src="bold.gif" 
 width="16" height="16" 
 align="middle" 
 alt="click to make your selection bold">
<img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="format_sel('i',document.forms[0].$field_name);" 
 src="italic.gif" 
 width="16" height="16" 
 align="middle" 
 alt="click to make your selection italic">
<img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="insert_link(document.forms[0].$field_name);" 
 src="link.gif" 
 width="32" height="16" 
 align="middle" 
 alt="click to add a link">
 <img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="create_list('###LIST,START','###LIST,END',document.forms[0].$field_name);" 
 src="list.gif" 
 width="32" height="16" 
 align="middle" 
 alt="click to create 'list'">
 <img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="create_list('###TABLE,START','###TABLE,END',document.forms[0].$field_name);" 
 src="table.gif" 
 width="32" height="16" 
 align="middle" 
 alt="click to create 'table'">
 <img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="create_list('###HTML,START','###HTML,END',document.forms[0].$field_name);" 
 src="html.gif" 
 width="32" height="16" 
 align="middle" 
 alt="click to create HTML section">
 <img class="button" 
 onmouseover="mouseover(this);" 
 onmouseout="mouseout(this);" 
 onmousedown="mousedown(this);" 
 onmouseup="mouseup(this);" 
 onclick="window.open('toolbar_help.htm');" 
 src="help.gif" 
 width="32" height="16" 
 align="middle" 
 alt="open help page">
 </div><br>
_END_;
}
?>