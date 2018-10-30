<?php
import_request_variables("gp", "rv_");

if (isset($rv_m) && ($rv_m == "get_login")) {
    $asdf = <<< _END_

_END_;
    $asdf = str_replace("\n","",$asdf);
    $asdf = str_replace("\r","",$asdf);
    echo $asdf;
    exit;
}


foreach ($_GET AS $key => $value) {  echo "$key => $value<br>\n";}
$IDval = $rv_tbl."|".$rv_fld."|".$rv_ID;
?>
<html>
<style type="text/css">
<!--
.temp {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style1 {color: #666666}
-->
</style>
<body>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="temp">
  <tr>
    <td align="center"><strong><br>FTP upload<br>
    </strong></td>
  </tr>
  <tr>
    <td align="center"><p><br>
        <!-- jClientUpload Applet : Begin copy/paste -->
        <APPLET  CODE = "javazoom.upload.client.MApplet.class" CODEBASE = "./" 
        ARCHIVE = "jclient/lib/jclientupload.jar,jclient/lib/ftpimpl.jar,jclient/lib/cnet.jar,jclient/lib/clogging.jar" 
        WIDTH = "250" HEIGHT = "250" NAME = "clientupload">
          <PARAM NAME="scriptable" VALUE="true">
          <PARAM NAME = "url" VALUE="ftp://ftp.bluemoondaughter.com/<?php echo $rv_dir;?>">
          <PARAM NAME = "param1" VALUE="username">
          <PARAM NAME = "value1" VALUE="bluedaughter">
          <PARAM NAME = "param2" VALUE="password">
<SCRIPT language="JavaScript">
var xmlhttp=false;
try {
  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (e) {
  try {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (E) {
   xmlhttp = false;
  }
 }
//    alert('ggg');
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
}
xmlhttp.open("GET", "applet_ftp_simple_login.php?m=get_login1");
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4) {
    var login = xmlhttp.responseText;
    //loginArray = login.split("|");
    alert(login);
    //document.write(login);
    //alert(loginArray[1]);
    //document.write(loginArray[1]);
  }
  xmlhttp.send(null)
}
//END XML
//-->
</SCRIPT>
          <PARAM NAME = "param3" VALUE="pasv">
          <PARAM NAME = "value3" VALUE="true">
          <PARAM NAME = "param4" VALUE="account">
          <PARAM NAME = "value4" VALUE="php_uploads">
          <PARAM NAME = "param5" VALUE="coz">
          <PARAM NAME = "value5" VALUE="<?php echo $IDval;?>">
          <PARAM NAME = "mode" VALUE="ftp">
          <PARAM NAME = "post" VALUE="http://ww2.cozmotion.com/db/jclient/post.php">
          <PARAM NAME = "postparameters" VALUE="extra">
          <PARAM NAME = "forward" VALUE="http://ww2.cozmotion.com/db/jclient/post.php">
          <PARAM NAME = "forwardparameters" VALUE="extra">
          <PARAM NAME = "mode" VALUE="ftp">
        </APPLET>
        <!-- jClientUpload Applet : End copy/paste -->
        <br>
        <br>
        <span class="style1">help text<br>
        </span> </p>
    </td>
  </tr>
  <tr>
    <td align="center"><p><b><br>
    </b>
</p>
      <p><b>jClientUpload 1.8 Applet</b><br>
Homepage : <a href="http://www.javazoom.net/applets/jclientupload/jclientupload.html" target="_blank">http://www.javazoom.net</a> <br>
<br>
</p>
      <p>This uploader requires <a href="http://www.java.com" target="_blank">Java</a>&#8482; technology. </p></td>
  </tr>
</table>
</body>
</html>
