<?php 
$tbl_name = "email_list";
$cfg_fn = "email_list";

$rec_name_singular = "Email List Member";
$rec_name_plural = "Email List Members";
$rec_name = $rec_name_singular . " Record";

$show_table_disp_total_records = "Members"; #any non-zero string causes display

$pv = parse_persist_vars($rv_per_sist);
$persist_cat = $pv['cat'];

$delete_return_link = "<A HREF='show_table.php?cfg=$cfg_fn&cat=$rv_cat' CLASS=admin>[Return to All records table]</A>";
$add_new_return_link = 
$edit_rec_return_to_table_link = "<A HREF='show_table.php?cfg=$cfg_fn&cat=$persist_cat' CLASS=admin>[Return to All records table]</A>";
$get_rec_cancel_link = "<A HREF=\"show_table.php?cfg=$cfg_fn&cat=$persist_cat\" CLASS=$db_table_link_class>CANCEL EDIT</A> and return to Admin Index for this section";
$bottom_links = "<DIV CLASS=$db_table_disp_class><A HREF=admin.php CLASS=$db_table_link_class>[ADMIN INDEX]</A><br><br><A HREF=/ CLASS=$db_table_link_class>[HOME]</A></DIV>";

$show_table_top_text = <<< _END_BANNER_
    <p align="center" class="secheader">$rec_name_plural</p>
    <p align="center">Click header titles to sort by that column.</p>
_END_BANNER_;


session_start();
if (isset($rv_order_by) && $rv_order_by != "") { $order_by_fld = $rv_order_by; }
else if (isset($_SESSION['order_by'][$rv_cfg]) && $_SESSION['order_by'][$rv_cfg] != "") {
    $order_by_fld = $_SESSION['order_by'][$rv_cfg];
}
else  { $order_by_fld = "cart_name"; }
$_SESSION['order_by'][$rv_cfg] = $order_by_fld;

$order_by_fld = $rv_order_by == "" ? "lastname" : $rv_order_by;
if ($order_by_fld = "date_entered") { $order_by_fld  .= " DESC"; }
$show_table_sql = "SELECT email,lastname,firstname,status,date_entered,ID FROM $tbl_name ORDER BY $order_by_fld";

$show_table_link_field = "";
$all_fields_sql = "email,firstname,lastname,status,date_entered,ID";
$show_table_cat_name = "Contact type: ";
$ID_field_name = "ID";

$col_defs = array (
"ID" => "ID|show_hidden|5|no",
"email" => "Email|text|50:100|no",
"firstname" => "First Name|text|30:50|no",
"lastname" => "Last Name|text|30:50|no",
"status" => "Status|radio|20:50|no|Email_OK^Email_OK NO_EMAIL^NO_EMAIL",
"date_entered" => "Date Entered|date|30:50|no",
"answer" => "Answer|textarea|70x10|<br>If there are no html tags, Carriage returns will be replaced by break tags",
"pic" => "Optional small graphic:|ext_file_upload|80:150|<br>does not apply to FAQ |php_uploads/pages/pics",
"banner" => "Left, large graphic:|ext_file_upload|80:150|<br><b>REQUIRED - 391x766 pixels</b>|php_uploads/pages/banners",
"disp_ord" => "Display Order:|text|5:10| integers only - leave gaps for future insertions!"
);
//##################################
$this_tbl_pswds = array();
function admin_pswd_OK() {
  return 1;
  //return &check_admin_cookie($this_tbl_pswds);
}
////////////////////////////////////////////////////////////
$show_table_checkform_header = "Select";
$show_table_checkform_additions = <<< _END_
    else if (del_action == "compile_page"){
      del_form.action="compile_page.php";
      for (i=0; i<del_form.elements.length; i++){
        if (del_form.elements[i].name == "del_chk[]") {
          if (del_form.elements[i].checked) {
            if (confirm("Compile selected pages?"))  {
    	      return true;
    	    }
    	    else return false;
          }
        }
      }
    }
_END_;
$show_table_checkform_buttons  = "";
/*<<< _END_
  <p align="center"><input type=submit value="Compile checked pages" onclick="del_action='compile_page'"></input></p>
_END_;*/
################################## */
$show_table_disable_add_new = 0;
$show_table_disable_delete = 0;
$show_table_instructions = "";
$get_rec_instructions = "";//"NOTE:<br>Pages named Donate, Teachers, Programs, Students, Fun, Success, About<br>are REQUIRED FOR SITE OPERATION<br><br>Other pages can be created, and then linked to with href=kwtpage.php?p=[Page]<br>...the page name must have only letters and numbers, and no spaces";
$db_entry_instructions = "";
$use_edit_buttons = 1;
?>