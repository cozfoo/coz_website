<script>
window.location = 'http://www.bluemoondaughter.com/db/jclient/applet_ftp.php?dir=php_uploads';
</script>
<?php
exit;
//foreach ($_POST AS $key => $value) {  $postvals .= "$key => $value\n";}
//$rv_tbl . "|" . $rv_fld . "|" . $rv_IDfld . "|" . $rv_ID
if (isset($_POST['db_data'])) {
    include "../../_globals.php";
    db_connect();
    list ($tbl,$fld,$IDfld,$ID) = explode("|",$_POST['db_data']);
    $fn_sep = strpos($_POST['filename1'],"\\") !== false ? "\\" : "/" ;
    $fn = explode($fn_sep,$_POST['filename1']);
    $fn1 = $fn[count($fn)-1];
    $sql = "UPDATE ".$tbl." SET ".$fld."='".mysql_real_escape_string($fn1)."' WHERE ".$IDfld."=".$ID;
    echo $fn_sep."...".$sql;
    $result1 = mysql_query($sql) or die("<b>SELECT Failed!</b><br>$sql<br>".
         mysql_errno() . ": " . mysql_error()."<br>");

    //$mailbody = $sql;
    //send_email('coz@3hats.com',"coz",'coz@3hats.com',"coz",'test',$mailbody)

    exit;
}
else {
    import_request_variables("gp", "rv_");
    $postvals="";
    foreach ($_GET AS $key => $value) {  $postvals .= "$key => $value<br>\n";}
    //echo $postvals;
}
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
    File uploaded: <?php echo $rv_filename1; ?><br><br>
    <a href="javascript:window.opener.location.reload();window.close();">CLICK HERE TO FINISH</a>
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
