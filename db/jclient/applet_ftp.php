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
//?dir=$addstr&tbl=$tbl_name&fld=$field_name&ID=$rv_ID

//foreach ($_GET AS $key => $value) {  echo "$key => $value<br>\n";}
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
    <td align="center"><strong><br>
    jClientUpload<br>
    </strong></td>
  </tr>
  <tr>
    <td align="center"><p><br>
<!-- jClientUpload Applet : Begin copy/paste -->
<script src="applet_ftp_js.php?<?php echo $_SERVER['QUERY_STRING']; ?>"></script>
<!-- jClientUpload Applet : End copy/paste -->
        <br>
        <br>
      </p>
    </td>
  </tr>
  <tr>
    <td align="center"><p><b><br>
    </b>
</p>
      <p><b>jClientUpload 1.9.3 Applet</b><br>
Homepage : <a href="http://www.javazoom.net/applets/jclientupload/jclientupload.html" target="_blank">http://www.javazoom.net</a> <br>
<br>
</p>
      <p>This product requires <a href="http://www.java.com" target="_blank">Java</a>&#8482; technology. </p></td>
  </tr>
</table>
</body>
</html>
