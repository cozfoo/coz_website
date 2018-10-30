<?php
error_reporting(E_ALL);

import_request_variables("gp", "rv_");
require_once("../_globals.php");

/*foreach ($_POST as $key => $value) {
  echo("\"$key\",\"\",\n");
}*/
//exit;

$params['table'] = "volunteers";
$params['content_type'] = "text/plain";
$params['filename'] = "volunteers.tab";
$params['separator'] = "\t";
$params['where_clause'] = "";
$params['order_by'] = "ORDER BY lastname";
$params['fields'] = "firstname,lastname,email,phone,address,city,state,zip,shirtsize,olcc,worked_before,comments,shift1,shift2,shift3,shift4,shift5,shift6,shift7,shift8,shift9,shift10,shift11,date_entered";
$params['titles'] = "firstname,lastname,email,phone,address,city,state,zip,shirtsize,olcc,worked_before,comments,Th 10:30-3:00,Th 2:30-6:30,Th 6-10,Fri 10:30-3:00,Fri 2:30-6:30,Fri 6-10,Sat 10:30-3:00,Sat 2:30-6:30,Sat 6-10,Sun 10:30-3:00,Sun 2:30-6:30,date_entered";

dl_tbl($params);

function dl_tbl($params) {
    db_connect();
    $sql = "SELECT * FROM " . $params['table']. " " .
    $params['where_clause'] . " " . $params['order_by'] . " ";
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
    header('Content-type: ' . $params['content_type']);
    header("Content-Disposition: attachment; filename=\"" . $params['filename'] . "\"");
    echo implode($params['separator'],explode(",",$params['titles'])) . "\n";
    while($rec = mysql_fetch_array($result)) {
        foreach (explode(",",$params['fields']) AS $fldname) {
            $this_val = $rec[$fldname];
            $this_val = str_replace($params['separator'],"",$this_val);
            $this_val = str_replace("\n","",$this_val);
            $this_val = str_replace("\r","",$this_val);
            echo $this_val . $params['separator'];
        }
        echo "\n";
    }
}
	// Redirect location
	//header('location: thankyou.html');
?>
