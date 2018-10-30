<?php
//import_request_variables("gp", "rv_");
//require_once("db_globals.php");
function show_cbs($GuestID) {
    global $call_script;
    $cb = "";
    $guest_cats_set = array();
    if ($call_script == "get_rec") {
        $sql = "SELECT * FROM guest_category ".
               "WHERE (guest_category.GuestID = $GuestID)";
        $result = mysql_query($sql) or die("<br><b>Select Failed!</b><br>$in_str<br>".mysql_errno($link)." : ".mysql_error($link));
        while ($rec = mysql_fetch_array($result)) {
            $guest_cats_set[$rec['CategoryID']] = 1;
        }
    }

    $sql = "SELECT * FROM guest_sponsor_categories";
    $result = mysql_query($sql) or die("<br><b>Select Failed!</b><br>$in_str<br>".mysql_errno($link)." : ".mysql_error($link));
    while ($rec = mysql_fetch_array($result)) {
        $chkd = isset($guest_cats_set[$rec['ID']]) ? "CHECKED" : "";
        $cb .= "<input type='checkbox' name='ignore_guest_cat".$rec['ID']."' value='".$rec['ID']."' $chkd>".$rec['cat_name']."<br>";
    }

    echo $cb;
}
?>
