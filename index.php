<html>
<head>
	<title>Blue Moon Daughter</title>
</head>

<body>

<?php
//###################################################################
error_reporting(E_ALL);
include_once "_globals.php";
import_request_variables("gp", "rv_");
//


// AREAS - THIS ONLY WORKS BECAUSE ALL NEW AREAS ARE THE ENTIRE STATE!!!!!
/*$sql3 ="SELECT states.StateId,new_areas.area FROM new_areas,states
        WHERE states.StateName=new_areas.state GROUP BY new_areas.area ORDER BY new_areas.ID";
$result2 = mysql_query($sql3) or die("<b>SELECT Failed!</b><br>$sql3<br>".
     mysql_errno() . ": " . mysql_error()."<br>");
echo $sql3."<br>";
$sort_order = 0;
while ($new_areas_rec = mysql_fetch_array($result2)) {
    $StateId = $new_areas_rec['StateId'];
    $area = $new_areas_rec['area'];
    $price = $new_areas_rec['price'];
    echo $StateId." ".$area."<br>";
    $area_sql = "INSERT INTO areas (AreaName,StateId,SortOrder) VALUES ('$area',$StateId,0)";
    mysql_query($area_sql) or die("<b>INSERT Failed!</b><br>$sql4<br>".
      mysql_errno() . ": " . mysql_error()."<br>");
    echo $area_sql."<br><b>";
    $sort_order++;
}

*/
if (!isset($rv_p)) { $rv_p = ""; }
switch ($rv_p) {
    case "home":
        home();
        break;
    case "schedule":
        schedule();
        break;
    case "bio":
        bio();
        break;
    case "listen":
        listen();
        break;
    case "buy_cd":
        buy_cd();
        break;
    case "contact":
        contact();
        break;
    case "pics":
        pics();
        break;
    default:
        home();
        break;
}

/*$title = $in{p};
$title =~ s/\_/ /g;
$title = ucfirst($title);
*/

# START PAGE
$title = "";
echo <<< _END_START_
<html>
<head>
<title>Blue Moon Daughter $title</title>
<LINK REL="SHORTCUT ICON" HREF="/favicon.ico">
<LINK REL=STYLESHEET TYPE="text/css" HREF="/bluemoondaughter.css">
</head>
<body bgcolor=black>
_END_START_;

############# SCHEDULE
function schedule() {
    global $rv_p;

  /*db_connect("coz");
  do_sql("select *,DATE_FORMAT(date,'%W, %M %e, %Y') as format_date from schedule WHERE offline <> 'offline' order by date desc");
  while (0) {
    $sched .= <<< _END_SCHED_
<TR><TD WIDTH="640" CLASS="ss11-dkgrn-bold" ALIGN="center">$rh->{format_date}</TD></TR>
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="center">$rh->{venue}</TD></TR>
_END_SCHED_
    if ($rh->{ad_line}) {
      $sched .= << "_END_SCHED_";
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="center">$rh->{ad_line}</TD></TR>
_END_SCHED_
}
    $sched .= << "_END_SCHED_";
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="center">$rh->{time}</TD></TR>
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="center">&nbsp;</TD></TR>
_END_SCHED_;
  }
  do_sql("SELECT DISTINCT venues.* FROM venues LEFT JOIN schedule ON venues.name=schedule.venue WHERE schedule.offline <> 'offline'");
  $venues = "<TR><TD WIDTH=640 CLASS=ss10-bold ALIGN=left>VENUES:</TD></TR>";

  while ($rh=$sth->fetchrow_hashref()) {
    if ($rh->{website}) {$website = "<TD WIDTH=640 CLASS=ss10-bold ALIGN=left><A HREF=\"http://$rh->{website}\" TARGET=_blank>$rh->{website}</A></TD></TR>";}
    else {$website = "";}
    if ($rh->{address2}) {$disp_ad2 = "<BR>$rh->{address2}";}
	else {$disp_ad2 = "";}
    $venues .= << "_END_VENUE_";
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="center">&nbsp;</TD></TR>
<TR><TD WIDTH="640" CLASS="ss11-dkgrn-bold" ALIGN="left">$rh->{name}</TD></TR>
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="left">$rh->{address1}$disp_ad2</TD></TR>
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="left">$rh->{phone}</TD></TR>
$website
<TR><TD WIDTH="640" CLASS="ss10-bold" ALIGN="left">$rh->{descrip}</TD></TR>
_END_VENUE_
}*/
print_hdr();
echo <<<_END_SCHED_
<table BORDER=0 CELLPADDING="0" CELLSPACING="0" ALIGN="center" WIDTH="688">
<tr>
	<td valign="top"><br><br><img src="images/logo_sm.png" alt="" width="283" heighxt="188" border="0">  </td>
	<td>



<TABLE BORDER=0 CELLPADDING="0" CELLSPACING="0" ALIGN="center" WIDTH="320">

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Sunday, August 21, 2016</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">6:00 - 7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Featuring Clipper Anderson on bass</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.columbiacitytheater.com/calendar">Bourbon Bar</a> <br>
4916 Rainier Ave. S.<br>
Seattle, 98118<br>
(206)722-3009
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br>Past:<br><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Friday, July 15, 2016</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">6:30 - 8:30</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.columbiacitytheater.com/calendar">Bourbon Bar</a> <br>
4916 Rainier Ave. S.<br>
Seattle, 98118<br>
(206)722-3009
</TD></TR>


<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Friday, June 10, 2016</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">6:30 - 8:30</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.columbiacitytheater.com/calendar">Bourbon Bar</a> <br>
4916 Rainier Ave. S.<br>
Seattle, 98118<br>
(206)722-3009
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, April 23, 2016</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Featuring Laura Welland on bass</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.grumpydsballard.com">Grumpy D&rsquo;s</a> <br>
7:00 - 9:00<br>
7001 15th Ave NW Seattle<br>(206) 783-4039
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, Dec. 26, 2015</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00 - 9:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.grumpydsballard.com">Grumpy D&rsquo;s</a>
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, Oct. 24, 2015</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00 - 9:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.grumpydsballard.com">Grumpy D&rsquo;s</a>
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Sunday, Aug. 16, 2015</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">3:00 - 5:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.stonewaycafe.com">Stoneway Cafe</a>
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>



<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Friday, June 24, 2011</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">4:00 - 5:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.tasteoftacoma.com/">Taste of Tacoma</a><br>
at Point Defiance Park
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><br></TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Friday, June 25, 2010</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.tasteoftacoma.com/">Taste of Tacoma</a><br>
at Point Defiance Park
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, June 5, 2010</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.ballardjamhouse.com/">Egan&acute;s Ballard Jam House</a><br>
1707 NW Market Street
<br>
Seattle, WA 98107
<br>
206-789-1621
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, April 10, 2010</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.bbaybrewery.com/">Boundary Bay Brewery</a><br>
1107 Railroad Avenue
<br>
Bellingham, WA 98225
<br>
(360) 647-5593
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">Saturday, December 5, 2009</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.ballardjamhouse.com/">Egan&acute;s Ballard Jam House</a><br>
1707 NW Market Street
<br>
Seattle, WA 98107
<br>
206-789-1621
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>

<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">September 25, 2009</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.localcolorseattle.com/">Local Color</a><br>
1606 Pike Place (in the Market)
<br>
Seattle, WA 98101
<br>
206.728.1717
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">8 - 10</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">May 30, 2009</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.ballardjamhouse.com/">Egan&acute;s Ballard Jam House</a><br>
1707 NW Market Street
<br>
Seattle, WA 98107
<br>
206-789-1621
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>


<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">January 30, 2009</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"><a target="_blank" href="http://www.ballardjamhouse.com/">Egan&acute;s Ballard Jam House</a><br>
1707 NW Market Street
<br>
Seattle, WA 98107
<br>
206-789-1621
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center"></TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">7:00</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-blue2moon-bold" ALIGN="center">&nbsp;</TD></TR>



</TABLE>


    
    
    </td>
</tr>
</table>





_END_SCHED_;
}
#############BIO
function bio() {
print_hdr();
    global $rv_p;
require "bio.php";

}
#############LISTEN
function listen() {
print_hdr();
    global $rv_p;
echo <<< _END_LISTEN_
<TABLE BORDER=0 CELLPADDING="10" CELLSPACING="0" ALIGN="center" WIDTH="640">

<TR><TD WIDTHz="320" CLASS="ss10-bold" align="center"><img src="images/logo_sm.png" alt="" width="283" heighxt="188" border="0"></TD></TR>

<TR><TD WIDTHz="320" CLASS="ss10-bold" align="center"><img src="images/CrystalEgans.png" width="375" height="250" style="border: 0" alt=""></TD></TR>

<!--  <IFRAME frameborder="0" widthz="320" height="170" src="/player.htm"></IFRAME></TD></TR>  -->
<TR><TD CLASS="ss10-bold" ALIGN="center">
<table style="width: 100%;backgroundZZ:#eee" CLASS="ss8-bold">
    <!--   <tr><td colspan='2' align='left' style='font-sizeXX:24px'><font size="+3" face="Comic Sans MS">Music Samples</font></td></tr> -->
    <tr>
        <td align='right'>Stop</td>
        <td><audio src="crystal/Stop - Crystal.mp3" controls="controls" type="audio/mpeg" stylez="background-color:#eee;border-radius: 7px;"></td>
    </tr>
    <tr>
        <td align='right'>Black Crow</td>
        <td><audio src="crystal/Black Crow Crystal 2.mp3" controls="controls" type="audio/mpeg" stylez="background-color:#eee;border-radius: 7px;"></td>
    </tr>
    <tr>
        <td align='right'>A Taste of Honey</td>
        <td><audio src="crystal/A Taste of Honey - Crystal.mp3" controls="controls" type="audio/mpeg" stylez="background-color:#eee;border-radius: 7px;"></td>
    </tr>
</table>
</TD></TR>
<TR><TD COLSPAN="2"><hr size="1" width=640></TD></TR>
</TABLE>

_END_LISTEN_;
}

#############BUY CD
function buy_cd() {
    global $rv_p;
print_hdr();
echo <<< _END_CD_
<TABLE BORDER=0 CELLPADDING="10" CELLSPACING="0" ALIGN="center" WIDTH="640">
<TR><TD CLASS="ss10-bold" ALIGN="left" WIDTH="320">
Soon</TD></TR>
<TR><TD COLSPAN="2"><hr size="1" width=640></TD></TR>


_END_CD_;

}
#############CONTACT
function contact() {
    global $rv_p,$rv_m,$rv_email,$rv_firstname,$rv_lastname;
    $msg = "";
    if (isset($rv_m)) {
        if ($rv_m == 'join_email_list') {
            //echo $rv_email;exit;
            $msg = add_to_email_list($rv_email,$rv_firstname,$rv_lastname);
        }
        else if ($rv_m == 'remove_from_email_list') {
            //echo $rv_email;exit;
            $msg = remove_from_email_list($rv_email);
        }
    }
    $msg = empty($msg) ? "" : "<font color='#FFFFFF'><b>".$msg."</b></font><br><br>";
    $scr_pt_start = '<script>';
    $scr_pt_end = '</script>';
    print_hdr();
    echo <<< _END_CD_
<TABLE BORDER=0 CELLPADDING="10" CELLSPACING="0" ALIGN="center" WIDTH="640">
<TR><TD CLASS="ss10-bold" ALIGN="left" WIDTH="320">
You can send email to:
$scr_pt_start
function escramble(){var a,b,c,z,s,e;a='<a href="mai';a+='lto:';b='info';b+='@';c='">';z='.com';s='';e='</a>';b+='bluemoondaughter';document.write(a+b+z+s+c+b+z+e);}escramble()
$scr_pt_end
</TD></TR>
<TR><TD WIDTH="320" CLASS="ss10-bold">

<!-- start -->
<TABLE BORDER=0 CELLPADDING="3" CELLSPACING="0" ALIGN="center" WIDTH="420">
<FORM ACTION="?" METHOD="post">
<INPUT TYPE="hidden" NAME="m" VALUE="join_email_list">
<INPUT TYPE="hidden" NAME="p" VALUE="contact">
<TR><TD WIDTH="640" CLASS="ss11-dkgrn-bold" ALIGN="left">$msg
To join our email list... (do join!)</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left">enter email address:</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left"><INPUT TYPE="text" NAME="email" SIZE="30" MAXLENGTH="50"></TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left">enter first and last name, if you&acute;d like:</TD></TR>

<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left"><INPUT TYPE="text" NAME="firstname" SIZE="10" MAXLENGTH="15"><INPUT TYPE="text" NAME="lastname" SIZE="15" MAXLENGTH="20"></TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left">then click button...</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left"><INPUT TYPE="submit" VALUE="Join Email List"></TD></TR>
</FORM></TABLE>
<!-- end -->
<br><br>
<!-- start -->
<TABLE BORDER=0 CELLPADDING="3" CELLSPACING="0" ALIGN="center" WIDTH="420">
<FORM ACTION="?" METHOD="post">
<INPUT TYPE="hidden" NAME="m" VALUE="remove_from_email_list">
<INPUT TYPE="hidden" NAME="p" VALUE="contact">
<TR><TD WIDTH="640" CLASS="ss11-dkgrn-bold" ALIGN="left">To be removed from our email list...</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left">enter email address:</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left"><INPUT TYPE="text" NAME="email" SIZE="30" MAXLENGTH="50" value="$rv_email"></TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left">then click button...</TD></TR>
<TR><TD WIDTH="640" CLASS="ss8-bold" ALIGN="left"><INPUT TYPE="submit" VALUE="Remove From Email List"></TD></TR>
</FORM></TABLE>
<!-- end -->

</TD>
<td valign="middle">

<img src="images/logo_on_black_100.gif" alt="" width="170" height="113" border="0">
<br><br><br><br><br>
<TABLE BORDER=1 CELLPADDING="3" CELLSPACING="0" ALIGN="center" WIDTHz="420">
<TR><TD WIDTH="640" CLASS="ss11-dkgrn-bold" ALIGN="left">
<font size="+1">BOOKING:</font><br>
<span CLASS="ss10-bold">
<a href="&#109;&#97;&#105;&#108;&#116;&#111;:&#105;&#110;&#102;&#111;&#64;&#98;&#108;&#117;&#101;&#109;&#111;&#111;&#110;&#100;&#97;&#117;&#103;&#104;&#116;&#101;&#114;&#46;&#99;&#111;&#109;">&#105;&#110;&#102;&#111;&#64;&#98;&#108;&#117;&#101;&#109;&#111;&#111;&#110;&#100;&#97;&#117;&#103;&#104;&#116;&#101;&#114;&#46;&#99;&#111;&#109;</a></span>
</TD></TR>
</TABLE>

</td>
</TR>
<TR><TD COLSPAN="2"><hr size="1" width=640></TD></TR>

_END_CD_;

}
//  REMOVE
function remove_from_email_list($email) {
    db_connect();
    $san_email = stripslashes(sanitize($email));
    // Already in?
    //echo "test:".validEmail($san_email);exit;
    $sql = "UPDATE email_list SET status='NO_EMAIL' WHERE email = '".$san_email."'";
    //echo $sql;
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>".mysql_error());
    return "\"$san_email\" has been remove from the list.";
}
#############PICS
function add_to_email_list($email,$firstname,$lastname) {
    db_connect();
    $san_email = stripslashes(sanitize($email));
    $san_firstname = stripslashes(sanitize($firstname));
    $san_lastname = stripslashes(sanitize($lastname));
    // Already in?
    //echo "test:".validEmail($san_email);exit;
    $sql = "SELECT * FROM email_list WHERE email = '".$san_email."'";
    //echo $sql;
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>".mysql_error());
    if (mysql_num_rows($result) > 0) {
        $msg = "\"$san_email\" is already on our list.";
    }
    else if (validEmail($san_email)) {
        $sql = "INSERT INTO email_list (email,firstname,lastname,status,date_entered) VALUES (" .
               "'".mysql_real_escape_string($san_email)."'," .
               "'".mysql_real_escape_string($san_firstname)."'," .
               "'".mysql_real_escape_string($san_lastname)."'," .
               "'Email_OK',NOW() )";
        $result = mysql_query($sql) or die("<b>Insert Failed!</b><br>$sql<br>".mysql_error());
        $msg = "Thank You!  You are now on our list.";
    }
    else {
        $msg = "Sorry, \"$san_email\" is not a valid email address.";
    }
    return $msg;
}
#############PICS
function pics() {
    global $rv_p;
print_hdr();
require "pics.php";

}
/*
    <img src="photos/Elizabeth_red_singing.jpg" alt="" width="289" height="440" border="0"><br>
    <img src="photos/rod_cdreleaseparty.jpg" alt="" width="400" height="267" border="0"><br>
    <img src="photos/_mrb0108 600.jpg" alt="" border="0"><br>

*/
#############
function home() {
    global $rv_p;
print_hdr();
echo <<< _END_HOME_
<!-- <div style="position:absolute;top:70;left:550"><img src="photos/bluemoondaughter_monotype2.gif" alt="" border="0"></div> -->

<TABLE BORDER=0 CELLPADDING="0" CELLSPACING="0" ALIGN="center" WIDTH="650">
<TR>
	<TD ALIGN="center"><br><br><br><br>
 <!--    <img src="photos/collage3.jpg" alt="" width="600" height="800" border="0"> -->
<!--     <img src="photos/BJH Band 088 - 600.jpg" alt="" width="600" height="391" border="0"> -->
<img src="images/logo_on_black.gif" alt="" width="565" height="376" border="0">
    </TD>
</TR>
</TABLE>

<BR><BR><BR>
_END_HOME_;
}


function  print_hdr() {
    global $rv_p;
$schedule = "<A href=index.php?p=schedule>CALENDAR</A>";
if ($rv_p == "schedule") {$schedule = "<FONT CLASS=ss10-bluemoon-bold>CALENDAR</FONT>";}
$bio = "<A href=index.php?p=bio>ABOUT</A>";
if ($rv_p == "bio") {$bio = "<FONT CLASS=ss10-bluemoon-bold>ABOUT</FONT>";}
$pics = "<A href=index.php?p=pics>PHOTOS</A>";
if ($rv_p == "pics") {$pics = "<FONT CLASS=ss10-bluemoon-bold>PHOTOS</FONT>";}
$listen = "<A href=index.php?p=listen>LISTEN</A>";
if ($rv_p == "listen") {$listen = "<FONT CLASS=ss10-bluemoon-bold>LISTEN</FONT>";}
$buy_cd = "<A href=index.php?p=buy_cd>BUY CD</A>";
if ($rv_p == "buy_cd") {$buy_cd = "<FONT CLASS=ss10-bluemoon-bold>BUY CD</FONT>";}
$contact = "<A href=index.php?p=contact>CONTACT</A>";
if ($rv_p == "contact") {$contact = "<FONT CLASS=ss10-bluemoon-bold>CONTACT</FONT>";}
$home = "<a href=index.php?p=home>HOME</a>";
if ($rv_p == "home") {$home = "<FONT CLASS=ss10-bluemoon-bold>HOME</FONT>";}

echo <<< _END_NAV_TBL_
<TABLE WIDTH="720" ALIGN="center" BORDER="0"><TR>
    <TD CLASS="ss10-bold" WIDTH="120" ALIGN="left">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;$home</TD>
    <TD CLASS="ss10-bold" WIDTH="120" ALIGN="center">$schedule</TD>
    <TD CLASS="ss10-bold" WIDTH="120" ALIGN="center">$bio</TD>
    <!-- <TD CLASS="ss10-bold" WIDTH="120" ALIGN="center">$pics</TD> -->
    <TD CLASS="ss10-bold" WIDTH="120" ALIGN="center">$listen</TD>
    <TD CLASS="ss10-bold" WIDTH="120" ALIGN="right">$contact&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</TD>
	</TR>
<TR><TD CLASS="ss10-bold" COLSPAN="6" ALIGN="center"><hr size="1" width=640></TD></TR>
</TABLE>
_END_NAV_TBL_;
}

?>
</body>
</html>
