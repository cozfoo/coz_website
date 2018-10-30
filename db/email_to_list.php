<?php
define("FROM", "info@bluemoondaughter.com");
define("FROM_NAME", "Blue Moon Daughter");
define("TEST_ADDRESS", "cozmotion@comcast.net");

include_once("../_globals.php");
import_request_variables("gp", "rv_");
error_reporting(E_ALL);
if (isset($rv_logout)) {
    setcookie('CustomerID',"" , time() - 1000, '/');
    require "login.php";
    exit;
}
db_connect();

if ((isset($rv_m)) && ($rv_m == "send_email")) {
    echo "<a href='admin.php'>[return to admin index]</a><br><br>";
    send_email_to_list(stripslashes($rv_body),stripslashes($rv_subject),stripslashes($rv_test_address));
    echo "<br><br><a href='admin.php'>[return to admin index]</a>";
    exit;
}
//else fall thru and print input form
$test_address = TEST_ADDRESS;
echo <<< _END_
<HTML><head>
<title>Email to Volunteers</title>

</head>
<body BGCOLOR="#000000">
<br><br><br><center>
<table ALIGN="center" width=600 bgcolor=#CFD0BF BORDER=0>
<tr bgcolor="#AFD0BF"><th>Send email to List</th></tr>
<tr><td ALIGN="center" VALIGN=TOP>
<FORM ACTION="email_to_list.php" METHOD="post">
<INPUT TYPE="hidden" NAME="m" VALUE="send_email">
Subject: <INPUT TYPE="text" SIZE="70" NAME="subject"><BR>
<div align="left">Message:</div>
<TEXTAREA COLS=80 ROWS=20 NAME="body"></TEXTAREA><BR>

<INPUT TYPE="checkbox" NAME="test" VALUE="test_only" CHECKED><INPUT TYPE="text" NAME="test_address" SIZE="35" VALUE=$test_address> (test only)
<br><br>
<INPUT TYPE="submit" value="Send Email(s)"><br>
DO NOT CLICK TWICE!!
</FORM>
</td></tr></table></body></html>
_END_;
##################################################################################################################################
function send_email_to_list($body,$subject,$test_address) {
    global $rv_test,$rv_test_address;
    $template = file_get_contents("../email_template.htm");
    $mailbody = str_replace("USER_INPUT_BODY",nl2br($body),$template);
    
    // is this a test?
    if (isset($rv_test)&&($rv_test == "test_only")) {
        $sql = "SELECT '".$rv_test_address."' AS email,'Test Email' AS lastname, '' AS firstname";
    }
    else {
        $sql = "SELECT address AS email,firstname,lastname FROM email WHERE offline = 'mail_OK' AND (mc=1 OR bmd=1)";
    }
    //echo $sql;exit;
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>".mysql_error());
    while ($rec = mysql_fetch_array($result)) {
        send_email($rec['email'],$rec['firstname']." ".$rec['lastname'],FROM,FROM_NAME,$subject,$mailbody,"text/html");
        echo $rec['email'] . "<BR>";
    }
}
?>
