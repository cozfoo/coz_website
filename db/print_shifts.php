<?php
error_reporting(E_ALL);

import_request_variables("gp", "rv_");
require_once("../_globals.php");

/*foreach ($_POST as $key => $value) {
  echo("\"$key\",\"\",\n");
}*/
//exit;

if (!isset($rv_shift)) {
    $shift_number = " Index";
    $page = <<< _END_
<table align="center">
<tr><td align="right">Shift 1 </td><td><a href="print_shifts.php?shift=1">[print]</a></td></tr>
<tr><td align="right">Shift 2 </td><td><a href="print_shifts.php?shift=2">[print]</a></td></tr>
<tr><td align="right">Shift 3 </td><td><a href="print_shifts.php?shift=3">[print]</a></td></tr>
<tr><td align="right">Shift 4 </td><td><a href="print_shifts.php?shift=4">[print]</a></td></tr>
<tr><td align="right">Shift 5 </td><td><a href="print_shifts.php?shift=5">[print]</a></td></tr>
<tr><td align="right">Shift 6 </td><td><a href="print_shifts.php?shift=6">[print]</a></td></tr>
<tr><td align="right">Shift 7 </td><td><a href="print_shifts.php?shift=7">[print]</a></td></tr>
<tr><td align="right">Shift 8 </td><td><a href="print_shifts.php?shift=8">[print]</a></td></tr>
<tr><td align="right">Shift 9 </td><td><a href="print_shifts.php?shift=9">[print]</a></td></tr>
<tr><td align="right">Shift 10</td><td><a href="print_shifts.php?shift=10">[print]</a></td></tr>
<tr><td align="right">Shift 11</td><td><a href="print_shifts.php?shift=11">[print]</a></td></tr>
</table>

_END_;
}

else {
    db_connect();
    $shift_number = $rv_shift;
    $shift_name = "shift".$rv_shift;
    $sql = "SELECT $shift_name FROM shifts WHERE ID=1";
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
    $rec = mysql_fetch_array($result);
    $shift_text = $rec[$shift_name];
    
    $table = "<table border='0' cellpadding='0'>";
    $table .= "<tr><td colspan='10' align=CENTER><b>SHIFT $rv_shift &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $shift_text</b><br><br></td></tr>";
    $table .= "<tr>";
    $table .= "<th>&nbsp;</th>";
    $table .= "<th>&nbspLAST&nbsp;NAME&nbsp</th>";
    $table .= "<th>&nbspFIRST&nbsp;NAME&nbsp</th>";
    $table .= "<th>&nbspSHIRT&nbsp;SIZE&nbsp</th>";
    $table .= "<th>&nbspOLCC&nbsp</th>";
    $table .= "<th>&nbspPHONE&nbsp</th>";
    $table .= "<th>&nbspMug/script&nbsp</th>";
    $table .= "</tr>";
    $sql = "SELECT * FROM volunteers WHERE $shift_name = 'X' ORDER BY date_entered";
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
    $line_number = 1;
    while($rec = mysql_fetch_array($result)) {
        $table .= "<tr><td height=3 colspan='10' valign=baseline><br><hr width='100%'></td></tr>";
        $table .= "<tr>";
        $table .= "<td><b>". $line_number++ ."</b>&nbsp;&nbsp;</td>";
        $table .= "<td>". ucwords(strtolower($rec['lastname'])) ."</td>";
        $table .= "<td>". ucwords(strtolower($rec['firstname'])) ."</td>";
        $table .= "<td>". $rec['shirtsize'] ."</td>";
        $table .= "<td>". $rec['olcc'] ."</td>";
        $table .= "<td>". $rec['phone'] ."</td>";
        $table .= "<td align=center>[&nbsp;&nbsp;]</td>";
        $table .= "</tr>\n";
    }
    $table .= "</table>";
    $page = <<< _END_
$table
<br><br><br><a href="print_shifts.php">[index]</a>
_END_;
//LAST       FIRST         SHIRT SIZE  OLCC   PHONE#             MUG
}

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
<html>
<head>
	<title>Shift <?php echo $shift_number; ?></title>
</head>

<body bgcolor="#ffffff">

<?php echo $page; ?>

</body>
</html>
