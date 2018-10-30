<?php
error_reporting(E_ALL);
import_request_variables("gp", "rv_");
include_once("../_globals.php");
db_connect();


$msg = "<p>Please fill in the form completely and submit<br>Thanks!</p>";


$sql = "SELECT * FROM volunteers WHERE ID=$rv_ID";
//echo $sql;
$result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
$rec = mysql_fetch_array($result);

$shift1checked = $rec['shift1'] == "X" ?  "YES" : "no";
$shift2checked = $rec['shift2'] == "X" ?  "YES" : "no";
$shift3checked = $rec['shift3'] == "X" ?  "YES" : "no";
$shift4checked = $rec['shift4'] == "X" ?  "YES" : "no";
$shift5checked = $rec['shift5'] == "X" ?  "YES" : "no";
$shift6checked = $rec['shift6'] == "X" ?  "YES" : "no";
$shift7checked = $rec['shift7'] == "X" ?  "YES" : "no";
$shift8checked = $rec['shift8'] == "X" ?  "YES" : "no";
$shift9checked = $rec['shift9'] == "X" ?  "YES" : "no";
$shift10checked = $rec['shift10'] == "X" ?  "YES" : "no";
$shift11checked = $rec['shift11'] == "X" ?  "YES" : "no";
//email,shirtsize,olcc,worked_before
$olcc_disp = $rec['olcc'] == "X" ? "yes" : "no";
$worked_before_disp = $rec['worked_before'] == "X" ? "yes" : "no";
$firstname = $rec['firstname'];
$lastname = $rec['lastname'];
$address = $rec['address'];
$city = $rec['city'];
$state = $rec['state'];
$zip = $rec['zip'];
$phone = $rec['phone'];
$email = $rec['email'];
$comments = $rec['comments'];
$shirtsize = $rec['shirtsize'];

$email_body = <<< _END_
Thanks for volunteering!

You have been confirmed for the shift(s) listed below.  You need to plan to arrive a little early so you can find parking and get into the fest.

Please bring this with you to show security that you are a volunteer.  Once inside the event make your way to the main bar and look for the "Volunteer check in" sign.  If you have a OLCC servers permit please bring it with you. There will be a general area for you to put your coats in and we will have festival shirts for you. At the end of your shift you will receive your mug and beers and be turned loose to enjoy the fest.

Thanks and see you there!

Preston

..........................................................................
You are scheduled for:
(the shift(s) you are scheduled for will have "YES" below)

Thursday, November 29:
shift1 10:30 AM - 3 PM => $shift1checked
shift2 2:30 PM - 6:30 PM => $shift2checked
shift3 6 PM - 10 P M=> $shift3checked

Friday, November 30:
shift4 10:30 AM - 3 PM => $shift4checked
shift5 2:30 PM - 6:30 PM => $shift5checked
shift6 6 PM - 10 PM => $shift6checked

Saturday, December 1:
shift7 10:30 AM - 3 PM => $shift7checked
shift8 2:30 PM - 6:30 PM => $shift8checked
shift9 6 PM - 10 PM => $shift9checked

Sunday, December 2:
shift10 10:30 AM - 3 PM => $shift10checked
shift11 2:30 PM - 7:00 PM => $shift11checked
..........................................................................
The information you submitted was:

First Name => $firstname
Last Name => $lastname
Email => $email
Address => $address
City => $city
State => $state
Zip => $zip
Phone => $phone
shirtsize => $shirtsize
olcc => $olcc_disp
worked at fest before? => $worked_before_disp
Your Comments:
$comments

_END_;
$headers = "From: Holiday Ale Website <hafvolunteers@comcast.net>\r\n";
mail($email, "Your Volunteer Form Info", $email_body, $headers);
$headers = "From: $firstname $lastname <$email>\r\n";
//mail('coz@med2020.com', "Volunteer Form Submitted", $email_body, $headers);
//mail('hafvolunteers@comcast.net', "Volunteer Form Submitted", $email_body, $headers);
$msg = "<p><hr>Your information has successfully been submitted.<br><font size='-1'>The form may now be used to submit another person's request.</font><hr></p>";
$disp_email_body = str_replace("\n","<br>",$email_body);
?>
<html>
<head>
	<title>Untitled</title>
</head>

<body>
<div align="center"><a href="admin.php">[back to admin]</a></div>
<?php echo $disp_email_body; ?>
<div align="center"><a href="admin.php">[back to admin]</a></div>
<br><br>

</body>
</html>
