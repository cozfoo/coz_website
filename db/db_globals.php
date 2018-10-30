<?php  
error_reporting(E_ERROR);
import_request_variables("gp", "rv_");
$pv = isset($rv_per_sist)? parse_persist_vars($rv_per_sist) : "";
$persist_cat = isset($pv['cat'])? $pv['cat'] : "";
$persist_param = isset($rv_per_sist)? $rv_per_sist : "";
$this_cat = isset($rv_cat)? $rv_cat : $persist_cat ;

require_once "site_globals.php";

$tadays = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
$tamonths = array("01","02","03","04","05","06","07","08","09","10","11","12");
$tayears = array("2000","2001","2002","2003","2004","2005","2006","2007","2008","2009","2010","2011",
"2012","2013","2014","2015","2016","2017","2018","2019","2020");
$tahours = array("01","02","03","04","05","06","07","08","09","10","11","12");
$taminutes = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
$uploadErrors = array(
    UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
);
//###################################### */
function check_admin_cookie() {
  if (isset($_COOKIE["admin"])) {
    return 1;
  }
  else {
    return 0;
  }
}
//###################################### */
function parse_persist_vars($per_sist) {
  $pvar = explode(",",$per_sist);
  foreach ($pvar AS $pv) {
    list($k,$v)=explode("-",$pv);
    $ret[$k]=$v;
  }
  return $ret;
}
//###################################### */
// will add or overwrite the input key/val
function get_persist_string($add_change) {
  global $rv_per_sist;
  //echo "$add_change<br>";
  list($new_k,$new_v)=explode("-",$add_change);
  //echo "list $new_k,$new_v<br>";
  if ($rv_per_sist != "") {
    $per_hash = parse_persist_vars($rv_per_sist);
    //echo "var_dump:",var_dump($rv_per_sist);echo"<br>";
  }
  $per_hash[$new_k] = $new_v;
  foreach ($per_hash AS $k => $v) {
    //echo "kv: $k-$v<br>";
    $kv_arr[] = "$k-$v";
  }
  return implode(",",$kv_arr);
}
//############################################################## */
function db_connect() {
  if (file_exists("/home/inet/debian_coz_superglobals.php")) {
    global $user,$pw;
    require_once("/home/inet/debian_coz_superglobals.php");
    $db = "coz";$host = "localhost";
  }
  else { //v5
    $user = "bmd_site";$pw = "Z48b1m2z0d3";
    $db = "bmd_site";$host = "p50mysql251.secureserver.net";
  }
  $link=mysql_connect($host,$user,$pw)
               or die("Unable to connect to MySQL server ".$db);
  mysql_select_db($db) or die("Unable to select database $db<br>".mysql_error($link) );
  return $link;
}
//###################################################################
function col_disp_name($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str) = explode("|",$col_defs[$col_name]);
  if ($col_nameX  != "") {
    return $col_nameX;
	}
  else {
    return $col_name;
	}
}
function col_disp_width($col_name)  {
  global $col_defs;
  $def_array = explode("|",$col_defs[$col_name]);
  return $def_array[2];
}
function align($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str,$added_str,$align_str) =
     explode("|",$col_defs[$col_name]);
  return $align_str;
}
function added_str($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str,$added_str) =
     explode("|",$col_defs[$col_name]);
  return $added_str;
}
function added_str2($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str,$added_str,$added_str2) =
     explode("|",$col_defs[$col_name]);
  return $added_str2;
}
function HTML_obj($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str) = explode("|",$col_defs[$col_name]);
  return $HTMLobjX;
}
function exp_string($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str) = explode("|",$col_defs[$col_name]);
  if ($exp_str == "no") {
    $exp_str = ""; }
  else {
    $exp_str = "$exp_str";  }
  return trim($exp_str);
}
/*function dropdown($col_name)  {
  global $col_defs;
  list($col_nameX,$HTMLobjX,$max_sizeX,$exp_str) = split("\|",$col_defs[$col_name]);
  return $exp_str;
}
function display_name  {
  $tbl_nameX = $disp_name{$_[0]};
  if ($tbl_nameX  ne "") {
    return $tbl_nameX;
	}
  else {
    return $_[0];
	}
}*/
//#####################################################################
//# display whole record:
function display_record() {
  global $disp_row_ary,$disp_ary,$db_table_disp_class,$call_script,$full_path_to_htdocs,$tadays,$tamonths,$tayears,
         $tahours,$taminutes,$tbl_name,$rv_ID,
         $preselect_dropdown_for_new_item_form,$categories,$rec_tbl_title_cell_bgcolor,$rec_tbl_data_cell_bgcolor;
//# be sure you've started table and form before calling...

//#print"<input type='hidden' name='tbl_name' value='$tbl_name'> \n";
$num_of_fields = mysql_num_fields($disp_ary);
for ($i=0;$i<$num_of_fields;$i++)    {
        $field_name = mysql_field_name($disp_ary, $i);
	    $tt=col_disp_name($field_name);
		$ht=HTML_obj($field_name);
		$xstr=exp_string($field_name);
	    $ww=col_disp_width($field_name);
	    $addstr=added_str($field_name);
	    $align=align($field_name);
        $ww_max = strpos($ww, ":");
		if ($ww_max !== false) {list($ww,$max_width) = explode(":",$ww);}
		else {$max_width = $ww;}
        
        $field_length = mysql_field_len($disp_ary, $i);
        
        if ($call_script != "new_item_form") {
        	$disp_value = $disp_row_ary[$i];
        }
		if (($field_length > 0)&&($field_length < $ww))  {
		  $max_width = $field_length;
		  $ww = $max_width;
		}
        if ($ht == "title_row") {
	      print "<tr><td colspan=3 align=$align valign=middle CLASS=$xstr bgcolor=$addstr  NOWRAP><b>$disp_value</b>\n";
        }
        else if ($tt != "ID") {
	      print "<tr><td align=right valign=middle CLASS=$db_table_disp_class bgcolor=$rec_tbl_title_cell_bgcolor  NOWRAP><b>$tt</b>&nbsp;</td><td CLASS=$db_table_disp_class bgcolor=$rec_tbl_data_cell_bgcolor NOWRAP>\n";
        }
    // function
	if ($ht == "function")	  {
		/* calls a function - nomally it's in the cfg file.  For editing, any form objects probably need to be named "ignore..."
           show_table will need something like "ID AS whatever" and the cfg will set "whatever" as a "code_require" field
           post edit can then do editing. */
          $addstr($disp_value); // addstr has the function to call 
	}
    // text
	if ($ht == "text")	  {
		if (1) {
		//$disp_value =~ s/"/&quot;/g;
        $disp_value = preg_replace("/\"/","&quot;",$disp_value);
	    print("<input type='text' name='$field_name' value=\"$disp_value\" size='$ww' maxlength='$max_width' ></input>$xstr \n");
		}
	}
    // show_only
	else if ($ht == "show_only")	  {
        $disp_value_2 = preg_replace("/\n/","<br>",$disp_value);
		print("<b>$disp_value_2</b>&nbsp;$xstr");
	}
    /* show_only_text
	else if ($ht == "show_only_text")	  {
		  print("<b>$disp_value</b>&nbsp;$xstr");
	}*/
    // show_hidden
	else if ($ht == "show_hidden")	  {
		  print("<input name='$field_name' type=hidden value=\"$disp_value\">&nbsp;$xstr");
	}
	else if ($ht == "show_only_after_add")	  {
      if ($call_script=="new_item_form") {
      	    print("<input type='text' name='$field_name' value=\"$disp_value\" size='$ww' maxlength='$max_width'></input>$xstr \n");
      }
      else {
		  print("<b>$disp_value</b>&nbsp;$xstr");
      }
	}
	else if ($ht == "textareaOBS")	  {
		$tatext = $disp_value;
		list($cols,$rows) = explode("x",$ww);
        $disabled = $addstr == "disabled" ? "disabled" : "";
	    print("<textarea cols=$cols rows=$rows wrapz=physical name='$field_name' $disabled>$tatext</textarea>$xstr<br> \n");
	}
	else if ($ht == "textarea")	  {
		$tatext = $disp_value;
		list($cols,$rows) = explode("x",$ww);
        $disabled = $addstr == "disabled" ? "disabled" : "";
	    print("<textarea cols=$cols rows=$rows wrapz=physical name='$field_name' $disabled>$tatext</textarea>$xstr<br> \n");
        print_toolbar_div($field_name);
 	}
	else if (preg_match("/^ext_file_upload/",$ht))  {
		$cur_file_txt = "";
		if ($disp_value != "") {
		    $cur_file_txt = "current filename is: <B>$disp_value</B><BR>";
            $file_path =
                $full_path_to_htdocs . $addstr . "/" . $disp_value;
            if (file_exists($file_path)) {
                $is_file = "<font color=#008000>File found on server</font><BR>";
			    $file_remove_tag = 
                "<INPUT TYPE=checkbox NAME=\"ext_file_remove_$field_name\" VALUE=\"$disp_value\"> Delete this file<BR>\n";
            }
            else {
                $is_file = "<font color=#FF0000>File NOT found on server ($file_path)</font><BR>";
            }
		}
		else {
		    $cur_pic = "";
		    $is_file = "";
		    $file_remove_tag = "";
		}
        // FTP?
        $ftp_html = "";
        if ($ht == "ext_file_upload_ftp")	  {
            if ($call_script == "new_item_form") {
                $ftp_html = "<br>For smaller files, use the Browse button above<br>";
                $ftp_html .= "For larger files files, submit the form without uploading and then 'edit' this record to FTP the ".
                             "larger file<br>";
            }
            else {
                $IDfldname = isset($ID_field_name) ? $ID_field_name : "ID";
                $ftp_html = "<br>For smaller files, use the Browse button above<br>";
                $ftp_html .= "For larger files files, click the FTP button below<br>";
                $ftp_html .= "<input type='button' name='ftp_button' value='FTP' onClick=\"myRef =".
                    "window.open('jclient/applet_ftp.php?dir=$addstr&tbl=$tbl_name&fld=$field_name&IDfld=$IDfldname&ID=$rv_ID',".
                    "'mywin','left=20,top=20,width=500,height=500,toolbar=0,resizable=0');\">";
            }
        }
        //
		echo "$cur_file_txt$is_file$file_remove_tag<input type=hidden name=\"ext_file_hidden_$field_name\"".
           " value=\"$disp_value\"><INPUT TYPE=file NAME=ext_file_upload_$field_name SIZE=$ww MAXLENGTH=$max_width".
           " accept=\"$xstr\"></INPUT>&nbsp;$xstr\n";
       echo $ftp_html;
	}
	else if ($ht == "cat_static")  {
        $t_cat = $preselect_dropdown_for_new_item_form[$field_name] ?
              $preselect_dropdown_for_new_item_form[$field_name] : $disp_value;
        $disp_t_cat = $categories[$t_cat];
        echo "<input name=\"$field_name\" type=hidden value=\"$t_cat\">$disp_t_cat &nbsp;";
	  }
	else if ($ht == "dropdown")  {
        $dd_items = explode(" ", $addstr);
        //echo "************** " . var_dump($dd_items) . "*******************";
		if (1) {
	      print "<SELECT NAME=\"$field_name\">";
		  foreach  ($dd_items as $option_item) {
            list($option_item,$disp_option_item) = explode("^",$option_item);
            if ($option_item == "") { continue; }
            if ($disp_option_item == "") { $disp_option_item = $option_item; }
		    $disp_option_item = preg_replace("/_/"," ",$disp_option_item);
		    if (($disp_value == $option_item)  ||
			    ($preselect_dropdown_for_new_item_form{$field_name} == $option_item)) {
			  $sel = "SELECTED";
			}
		    else {$sel = "";}
		    print("<OPTION VALUE=\"$option_item\" $sel>$disp_option_item</OPTION>\n");
		  }
		  print "</SELECT>$xstr";
		}
		else { print "(No Categories for this Table)"; }
	  }
	elseif (($ht == "radio")||($ht == "radio_vert"))  {
	    #print "$sth->{'NAME'}->[$i]<br>\n";
        $radio_items = explode(" ", $addstr);
        //@this_rec_cats = split(/ /,dropdown($sth->{'NAME'}->[$i]));
		#$foofoo = dropdown($sth->{'NAME'}->[$i]);
		if (1) {
		  list($sel1,$sel2) = explode("|",$disp_value);
		  #if there's no valid selection in db, select first item
		  $use_default=1;
          foreach ($radio_items as $radio_item) {
            list($param,$disp_param) = explode("^",$radio_item);
		    if ($sel1 == $param) {$use_default=0;}
		  }
		  $ct=0;
          foreach ($radio_items as $radio_item) {
            list($param,$disp_param) = explode("^",$radio_item);
		    $disp_param = preg_replace("/_/"," ",$disp_param);
		    #$disp_cat_item = "coocoo";
		    if ($sel1 == $param) {$sel = "CHECKED";}
		    else {$sel = "";}
			if ($ct==0 && $use_default) {$sel = "CHECKED";}
		    echo "<INPUT TYPE=radio NAME=\"$field_name\"
			 VALUE=\"$param\" $sel> $disp_param";
            echo ($ht == "radio_vert") ? "<br>" : "";
			$ct++;
		  }
		}
		else { echo "(No Categories for this Table)"; }
	  }
	elseif ($ht == "checkbox")  {
        $cb_items = explode(" ", $addstr);
		if (1) {
          foreach ($cb_items as $cb_item) {
            list($param,$disp_param) = explode("^",$cb_item);
		    $disp_param = preg_replace("/_/"," ",$disp_param);
            $cb_pos = strpos($disp_value,"|".$param."|");
		    if ($cb_pos !== false) {$sel = "CHECKED";}
		    else {$sel = "";}
		    echo "<INPUT TYPE=\"checkbox\" NAME=\"$field_name"."[]\"
			 VALUE=\"$param\" $sel> $disp_param<br>";
		  }
          echo "<input type='hidden' name='ignore_checkbox_".$field_name."' value='".$disp_value."'>";
		}
		else { echo "(No Categories for this Table)"; }
	  }

 	elseif ($ht == "datetime")  {
        $script_end_tag = "</SCRIPT>";
        ###################################### get today's date
        $date_sql = "SELECT NOW() AS now";
        $date_result = mysql_query($date_sql) or die("<br><b>Select Failed!</b><br>$date_sql<br>".mysql_errno().
            " : ".mysql_error());
        $date_rec = mysql_fetch_array($date_result);
        list ($this_date_now,$this_time_now) = explode(" ",$date_rec['now']);
        list ($this_year_now,$this_month_now,$this_day_now) = explode("-",$this_date_now);
        list ($this_hour_now,$this_minute_now,$this_second_now) = explode(":",$this_time_now);
        ######################################  end get today's date
        $date_js_function_name = $field_name . "_change()";
		echo <<< _END_SCRIPT_
<SCRIPT LANGUAGE="JavaScript">
function $date_js_function_name {
    var day=document.forms[0].ignore_day_$field_name.options[document.forms[0].ignore_day_$field_name.selectedIndex].value;
    var month=document.forms[0].ignore_month_$field_name.options[document.forms[0].ignore_month_$field_name.selectedIndex].value;
    var year=document.forms[0].ignore_year_$field_name.options[document.forms[0].ignore_year_$field_name.selectedIndex].value;
    var hour=document.forms[0].ignore_hour_$field_name.options[document.forms[0].ignore_hour_$field_name.selectedIndex].value;
    var minute=document.forms[0].ignore_minute_$field_name.options[document.forms[0].ignore_minute_$field_name.selectedIndex].value;
    var ampm=document.forms[0].ignore_ampm_$field_name.options[document.forms[0].ignore_ampm_$field_name.selectedIndex].value;
    //var second=document.forms[0].ignore_second_$field_name.options[document.forms[0].ignore_second_$field_name.selectedIndex].value;
    if (ampm=='PM') {
        if (hour != '12') {
            hour = (hour * 1) + 12;
        }
    }
    else if ((ampm=='AM')&&(hour==12)) {
        hour = '00';
    }
    if (hour=='24') {
        alert (hour);
    }
    var date = year+"-"+month+"-"+day+" "+hour+":"+minute+":00";
    document.forms[0].$field_name.value = date;
}
        $script_end_tag
_END_SCRIPT_;
	      if ($call_script == "new_item_form") {
		    $tayear=$this_year_now;$tamonth=$this_month_now;$taday=$this_day_now;
            $tahour=$this_hour_now;$taminute=0;
          }
          else {
            list ($tadate,$tatime) = explode(" ",$disp_value);
		    list ($tayear,$tamonth,$taday) = explode("-",$tadate);
            list ($tahour,$taminute,$tasecond) = explode(":",$tatime);
          }
            //24hour?
            $real_tahour = $tahour;
            if ($tahour < 12) {$ampm = "AM"; }
            else {$ampm = "PM"; }
            if ($tahour == "00") {$tahour = 12; }
            else if ($tahour > 12) { $tahour -= 12; }
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_month_$field_name'>";
          $year_name = $field_name . "_YEAR";
          $month_name = $field_name . "_MONTH";
          $day_name = $field_name . "_DAY";
          $hour_name = $field_name . "_HOUR";
          $minute_name = $field_name . "_MINUTE";
          $second_name = $field_name . "_SECOND";
		  foreach ($tamonths AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($tamonth == $cat_item)  ||
			  ($preselect_dropdown_for_new_item_form[$month_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $tamonth = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_day_$field_name'>";
		  foreach ($tadays AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($taday == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$day_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $taday = $cat_item;
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_year_$field_name'>";
		  foreach ($tayears AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($tayear == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$year_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $tayear = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo "&nbsp;&nbsp;<SELECT ONCHANGE=$date_js_function_name NAME='ignore_hour_$field_name'>";
		  foreach ($tahours AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($tahour == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$hour_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $tahour = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo ":<SELECT ONCHANGE=$date_js_function_name NAME='ignore_minute_$field_name'>";
		  foreach ($taminutes AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($taminute == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$minute_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $taminute = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";

		  echo "<INPUT TYPE=hidden NAME='ignore_second_$field_name' VALUE='00'>";

	      echo "&nbsp;<SELECT ONCHANGE=$date_js_function_name NAME='ignore_ampm_$field_name'>";
		  $am_sel = $ampm == "AM" ? "SELECTED" : "";
		  $pm_sel = $ampm == "PM" ? "SELECTED" : "";
		  echo "<OPTION VALUE=\"AM\" $am_sel>AM</OPTION>\n";
		  echo "<OPTION VALUE=\"PM\" $pm_sel>PM</OPTION>\n";
		  echo "</SELECT>";
          //
		  echo  "$xstr<INPUT TYPE=hidden NAME='$field_name' VALUE='".
              $tayear."-".$tamonth."-".$taday." ".$real_tahour.":".$taminute.":00'>";
	  }
 	elseif ($ht == "date")  {
        $script_end_tag = "</SCRIPT>";
	    #print "$sth->{'NAME'}->[$i]<br>\n";
		#day
		#$tatext = $disp_ary[$i];
		  #$tatext =~ s/<P>|<p>/\n/g;
        ###################################### get today's date
        $date_sql = "SELECT CURDATE() AS now";
        $date_result = mysql_query($date_sql) or die("<br><b>Select Failed!</b><br>$date_sql<br>".mysql_errno().
            " : ".mysql_error());
        $date_rec = mysql_fetch_array($date_result);
        list ($this_year_dbdate,$this_month_dbdate,$this_day_dbdate) = explode("-",$date_rec['now']);
        ######################################  end get today's date
        $date_js_function_name = $field_name . "_change()";
		echo <<< _END_SCRIPT_
        <SCRIPT LANGUAGE="JavaScript">
        function $date_js_function_name {
         var day=document.forms[0].ignore_day_$field_name.options[document.forms[0].ignore_day_$field_name.selectedIndex].value;
        var month=document.forms[0].ignore_month_$field_name.options[document.forms[0].ignore_month_$field_name.selectedIndex].value;
        var year=document.forms[0].ignore_year_$field_name.options[document.forms[0].ignore_year_$field_name.selectedIndex].value;
         var date = year+"-"+month+"-"+day;
         document.forms[0].$field_name.value = date;
        }
        $script_end_tag
_END_SCRIPT_;
	      if ($call_script == "new_item_form") {
		    $tayear=$this_year_dbdate;$tamonth=$this_month_dbdate;$taday=$this_day_dbdate;
          }
          else {
		    list ($tayear,$tamonth,$taday) = explode("-",$disp_value);
          }
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_month_$field_name'>";
          $year_name = $field_name . "_YEAR";
          $month_name = $field_name . "_MONTH";
          $day_name = $field_name . "_DAY";
		  foreach ($tamonths AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($tamonth == $cat_item)  ||
			  ($preselect_dropdown_for_new_item_form[$month_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $tamonth = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_day_$field_name'>";
		  foreach ($tadays AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($taday == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$day_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $taday = $cat_item;
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>";
	      echo "<SELECT ONCHANGE=$date_js_function_name NAME='ignore_year_$field_name'>";
		  foreach ($tayears AS $cat_item) {
		    $disp_cat_item = $cat_item;
		    if (($tayear == $cat_item)  ||
			    ($preselect_dropdown_for_new_item_form[$year_name] == $cat_item)) {
			  $sel = "SELECTED";
			  $tayear = $cat_item; #for preselect
			}
		    else {$sel = "";}
		    echo "<OPTION VALUE=\"$cat_item\" $sel>$disp_cat_item</OPTION>\n";
		  }
		  echo "</SELECT>$xstr";
		  print "<INPUT TYPE=hidden NAME='$field_name' VALUE='".$tayear."-".$tamonth."-".$taday."'>";
	  }
     /*	elsif ($ht eq 'textlink')
	  {
	    if ($field_name eq "dbcat_num")  {
		  $disp_dbcat_num = $disp_ary[$i];
		  if ($disp_ary[$i] =~ /~/) {
		    $chkd = "checked";
    		$disp_dbcat_num =~ s/~//;
          }
		  else {$chkd = "";}
	      print "<input type='text' name='$field_name' value=\"$disp_dbcat_num\" size='$ww' maxlength='$max_width'></input>$xstr \n";
		  print "<input type=checkbox name=offline value=hello $chkd>&nbsp;Offline (don\'t display to users)</input>";
		}
		else {
	    print "<input type='text' name='$field_name' value=\"$disp_ary[$i]\" size='$ww' maxlength='$max_width'></input>$xstr \n";
		}
		if ($disp_ary[$i]) {
		  if ($disp_ary[$i] =~ /\@/) { $protocol = "mailto:"; }
		  elsif ($disp_ary[$i] =~ /http:\/\//) { $protocol = ""; }
		  else { $protocol = "http://"; }
		  print "<BR><A HREF=\"$protocol$disp_ary[$i]\" TARGET=_blank>$disp_ary[$i]</A>";
		}
	  }

###########################*/
print "</td></tr>\n";
	}
}
 ?>
