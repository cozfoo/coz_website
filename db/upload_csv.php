<?php
error_reporting(E_ALL);

require_once("../_globals.php");
import_request_variables("gp", "rv_");
db_connect();
$msg = process_csv($rv_table,$rv_cat,$rv_html_obj_name,"../uploads/csv/");

function process_csv($table,$cat,$html_obj_name,$target_path) {
    $err_msg = "";
    $filename = basename( $_FILES[$html_obj_name]['name']);
    $target_path = $target_path . $filename; 
    //echo $target_path;
    if(move_uploaded_file($_FILES[$html_obj_name]['tmp_name'], $target_path)) {
        //echo "The file <b>". basename( $_FILES[$html_obj_name]['name']). "</b> has been uploaded <br />...It is finished inserting into database when you see the number of records below<br>...This could take a couple of minutes, depending on file size and number of updates<br>";
    }
    else {
        $err_msg .= "There was an error uploading the exhibitors_csv file, please try again!";
    } 
    // get rid of old:
    $query = "DELETE FROM spreadsheets WHERE cat='$cat'";
    //echo "<b>$query</b><br>";
    $result = mysql_query($query) or die("<b>Select Failed!</b><br>$query<br>".mysql_error());

    $row_ct = 1;$update_ct = 0;$insert_ct = 0;$insert_or_update_ct=0;
    $handle = fopen($target_path, "r");
    $found_title_rec = 0;$data_err = 0;$disp_ord = 0;
    while (($data = fgetcsv($handle, 2000)) !== FALSE) {
        //var_dump($data);
        /*if (($found_title_rec == 0)&&($data_err == 0)) {
            if ($data[0] == "CompanyName") { $found_title_rec = 1; }
            if ($data[0] != "CompanyName") { $data_err = 100; }
            if ($data[1] != "FirstName") { $data_err = 1; }
            if ($data[2] != "LastName") { $data_err = 2; }
            if ($data[3] != "Address") { $data_err = 3; }
            if ($data[4] != "Address2") { $data_err = 4; }
            if ($data[5] != "City") { $data_err = 5; }
            if ($data[6] != "State") { $data_err = 6; }
            if ($data[7] != "Zip") { $data_err = 7; }
            if ($data[8] != "Fax") { $data_err = 8; }
            if ($data[9] != "Phone") { $data_err = 9; }
            if ($data[10] != "EmailAddress") { $data_err = 10; }
            if ($data[11] != "Password") { $data_err = 11; }
            if ($data[12] != "3rdPartyCompany") { $data_err = 12; }
            if ($data[13] != "3rdPartyContactName") { $data_err = 13; }
            if ($data[14] != "3rdPartyAddress") { $data_err = 14; }
            if ($data[15] != "3rdPartyAddress2") { $data_err = 15; }
            if ($data[16] != "3rdPartyCity") { $data_err = 16; }
            if ($data[17] != "3rdPartyState") { $data_err = 17; }
            if ($data[18] != "3rdPartyZip") { $data_err = 18; }
            if ($data[19] != "3rdPartyFax") { $data_err = 19; }
            if ($data[20] != "3rdPartyPhone") { $data_err = 20; }
            if ($data[21] != "3rdPartyEmail") { $data_err = 21; }
            if ($data[22] != "3rdPartyCellPhone") { $data_err = 22; }
            if ($data[23] != "CellPhone") { $data_err = 23; }
            if ($data[24] != "BoothNumbers") { $data_err = 24; }
            continue;
        }
        if (($found_title_rec == 0)||($data_err != 0)) {
            if ($found_title_rec == 0) {
                $err_msg .= "Data File Error $data_err - First record does not look like column header record - nothing uploaded<br>";
            }
            if ($data_err != 0) {
                $err_msg .= "Data File Error $data_err - Columns out of order or not named correctly - nothing uploaded<br>";
            }
            if ($err_msg != "") {
                return $err_msg;
            }
        }
        if (($data[10] == "")||($data[10] == "")) {
            $row_ct_1rel = $row_ct+1;
            $err_msg .= "Blank Email Address or Password for row $row_ct_1rel - row ignored<br>";
            continue;
        }*/
        
        $num = count($data);
        //echo "<br /><b>$row_ct:</b> <br />\n";
        $disp_ord = $row_ct * 10;
        $row_ct++;
        //for ($c=0; $c < $num; $c++) { echo $data[$c] . "<b>|</b>"; }
        switch (strtolower($data[0])) {
            case "headers":
                $row_type = "headers";
                $col1 = "";
                $col2 = $data[1];
                $col3 = $data[2];
                $col4 = $data[3];
                break;
            case "title":
                $row_type = "title";
                $col1 = "";
                $col2 = $data[1];
                $col3 = "";
                $col4 = "";
                break;
            default:
                $row_type = "data";
                $col1 = $data[0];
                $col2 = $data[1];
                $col3 = $data[2];
                $col4 = $data[3];
                break;
        }
        //mysql_free_result($result);
        $result = "";
        $query =
        "INSERT INTO spreadsheets
        (cat,row_type,col1,col2,col3,col4,disp_ord)
        VALUES
        (|$cat|,|$row_type|,|$col1|,|$col2|,|$col3|,|$col4|,$disp_ord)";
        //     STR_TO_DATE(|$data[14]|, |%m/%d/%Y|),
        $query = str_replace("\n", "", $query);
        $query = mysql_real_escape_string($query);
        //echo "<br>" . $query . "<br>";
        $query = str_replace("|", "'", $query);
        //echo "<br>" . $query . "<br>";
        //echo "record inserted<br>" . $query . "<br>";
        $success = mysql_query($query) or die("<b>Insert Failed!</b><br>$query<br>".mysql_error());
        $insert_ct++;
        $insert_or_update_ct++;
        //if ($insert_or_update_ct % 100 == 0) { echo "<br>"; }
    }
    fclose($handle);
    //$ret_msg = "$row_ct Records Uploaded - $insert_ct new records inserted, $update_ct existing records updated<br>";
    $ret_msg = "$insert_ct records inserted<br>";
    return $err_msg == "" ? "csv file upload OK<br>".$ret_msg : $err_msg.$ret_msg;
}

?>
<html>
<head>
	<title>Upload CSV</title>
    <link href="../boehl.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<br><br><br><br><br><br><br><br><br><div align="center"><?php echo $msg;?><br><br>
<a href="admin.php">[click here]</a> to return to admin index<br><br>
<a href="/">[click here]</a> to go to site home page<br><br>
</div>


</body>
</html>
