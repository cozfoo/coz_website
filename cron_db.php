<?php
error_reporting(E_ALL);
require_once("_globals.php");
db_connect();
$sql = "Select * FROM email ORDER BY ID LIMIT 1";
$result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>".mysql_error());
$rec = mysql_fetch_array($result, MYSQL_ASSOC);
$fn = $rec['address'];
$mailbody = "from cron:\n".$fn;
send_email('cozmotion@comcast.net',"",'info@bluemoondaughter.com',"",'cron',$mailbody,"text/plain");
echo $mailbody;
/*
 mysql_connect("localhost","root","3hats")
               or die("Unable to connect to SQL server");
mysql_select_db("coz") or die("Unable to select database");
$query = "SELECT * FROM venues";
$venues = mysql_query($query) or die("Select Failed!");
while ($venue = mysql_fetch_array($venues)) {
  echo $venue['name'];echo'<BR>';
}
 echo '<p>Hello World</p>'; */
  ?>