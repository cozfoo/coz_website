<?php
import_request_variables("gp", "rv_");
$username = "bluedaughter";
$pw = "m3oZQ2o4n";
$upload_url = "ftp://ftp.bluemoondaughter.com/uploads";
$account = "uploads";

$db_data = $rv_tbl . "|" . $rv_fld . "|" . $rv_IDfld . "|" . $rv_ID;
$post_url = "";//"http://ww2.cozmotion.com/db/jclient/post.php";
$forward_url = "";//"http://ww2.cozmotion.com/db/jclient/post.php";
?>
<!--
var _info = navigator.userAgent;
var _ns = false;
var _ns6 = false;
var _ie = (_info.indexOf("MSIE") > 0 && _info.indexOf("Win") > 0 && _info.indexOf("Windows 3.1") < 0);
if (_info.indexOf("Opera") > 0) _ie = false;
var _ns = (navigator.appName.indexOf("Netscape") >= 0 && ((_info.indexOf("Win") > 0 && _info.indexOf("Win16") < 0) || (_info.indexOf("Sun") > 0) || (_info.indexOf("Linux") > 0) || (_info.indexOf("AIX") > 0) || (_info.indexOf("OS/2") > 0) || (_info.indexOf("IRIX") > 0)));
var _ns6 = ((_ns == true) && (_info.indexOf("Mozilla/5") >= 0));
if (_ie == true) {
  document.writeln('<OBJECT classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" WIDTH="250" HEIGHT="250" NAME="clientupload" codebase="http://java.sun.com/update/1.4.2/jinstall-1_4-windows-i586.cab#Version=1,4,0,0">');
}
else if (_ns == true && _ns6 == false) { 
  // BEGIN: Update parameters below for NETSCAPE 3.x and 4.x support.
  document.write('<EMBED ');
  document.write('type="application/x-java-applet;version=1.4" ');
  document.write('CODE="javazoom.upload.client.MApplet.class" ');
  document.write('JAVA_CODEBASE="./" ');
  document.write('ARCHIVE="lib/jclientupload.jar,lib/ftpimpl.jar,lib/cnet.jar,lib/clogging.jar" ');
  document.write('NAME="clientupload" ');
  document.write('WIDTH="250" ');
  document.write('HEIGHT="250" ');
  document.write('url="<?php echo $upload_url; ?>" ');
  document.write('param1="username" ');
  document.write('value1="<?php echo $username; ?>" ');
  document.write('param2="password" ');
  document.write('value2="<?php echo $pw; ?>" ');
  document.write('param3="pasv" ');
  document.write('value3="true" ');
  document.write('param4="account" ');
  document.write('value4="<?php echo $account; ?>" ');
  document.write('param5="db_data" ');
  document.write('value5="<?php echo $db_data; ?>" ');
  document.write('post="<?php echo $post_url; ?>" ');
  document.write('postparameters="extra" ');
  document.write('forward="<?php echo $forward_url; ?>" ');
  document.write('forwardparameters="true" ');
  document.write('mode="ftp" ');
  document.write('scriptable=true ');
  document.writeln('pluginspage="http://java.sun.com/products/plugin/index.html#download"><NOEMBED>');
  // END
}
else {
  document.write('<APPLET CODE="javazoom.upload.client.MApplet.class" JAVA_CODEBASE="./" ARCHIVE="lib/jclientupload.jar,lib/ftpimpl.jar,lib/cnet.jar,lib/clogging.jar" WIDTH="250" HEIGHT="250" NAME="clientupload">');
}
// BEGIN: Update parameters below for INTERNET EXPLORER, FIREFOX, SAFARI, OPERA, MOZILLA, NETSCAPE 6+ support.
document.writeln('<PARAM NAME=CODE VALUE="javazoom.upload.client.MApplet.class">');
document.writeln('<PARAM NAME=CODEBASE VALUE="./">');
document.writeln('<PARAM NAME=ARCHIVE VALUE="lib/jclientupload.jar,lib/ftpimpl.jar,lib/cnet.jar,lib/clogging.jar">');
document.writeln('<PARAM NAME=NAME VALUE="clientupload">');
document.writeln('<PARAM NAME="type" VALUE="application/x-java-applet;version=1.4">');
document.writeln('<PARAM NAME="scriptable" VALUE="true">');
document.writeln('<PARAM NAME="url" VALUE="<?php echo $upload_url; ?>">');
document.writeln('<PARAM NAME="param1" VALUE="username">');
document.writeln('<PARAM NAME="value1" VALUE="<?php echo $username; ?>">');
document.writeln('<PARAM NAME="param2" VALUE="password">');
document.writeln('<PARAM NAME="value2" VALUE="<?php echo $pw; ?>">');
document.writeln('<PARAM NAME="param3" VALUE="pasv">');
document.writeln('<PARAM NAME="value3" VALUE="true">');
document.writeln('<PARAM NAME="param4" VALUE="account">');
document.writeln('<PARAM NAME="value4" VALUE="<?php echo $account; ?>">');
document.writeln('<PARAM NAME="param5" VALUE="db_data">');
document.writeln('<PARAM NAME="value5" VALUE="<?php echo $db_data; ?>">');
document.writeln('<PARAM NAME="post" VALUE="<?php echo $post_url; ?>">');
document.writeln('<PARAM NAME="postparameters" VALUE="extra">');
document.writeln('<PARAM NAME="forward" VALUE="<?php echo $forward_url; ?>">');
document.writeln('<PARAM NAME="forwardparameters" VALUE="true">');
document.writeln('<PARAM NAME="mode" VALUE="ftp">');
// END
if (_ie == true) {
  document.write('</OBJECT>');
}
else if (_ns == true && _ns6 == false) {
  document.write('</NOEMBED></EMBED>');
}
else {
  document.write('</APPLET>');
}
//-->
