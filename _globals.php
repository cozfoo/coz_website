<?php  
//###################################### */
$full_path_to_htdocs=dirname(realpath("_globals.php"))."/";
if (file_exists("/home/inet/debian_coz_superglobals.php")) {
    $non_secure_url = "http://ww2..com/exhibitors";
    $secure_url = "http://ww2..com/exhibitors";
}
else {
    $non_secure_url = "http://www..com/exhibitors";
    $secure_url = "https://www..com/exhibitors";
}
//###################################### */
$full_path_to_htdocs=dirname(realpath("_globals.php"))."/";
if (!function_exists('import_request_variables')) {
    function import_request_variables($gp,$prefix) {
        //$prefix = str_replace("_","",$prefix);
        $prefix = rtrim($prefix, "_");
        //extract($_REQUEST,EXTR_PREFIX_ALL,$prefix);
        //print_r(get_defined_vars());
        //echo "<br>q in sub:$rv_q<br>";
        foreach ($_REQUEST AS $k => $v) {
            //echo "var name:".$prefix."_".$k."<br>";
            global ${$prefix."_".$k};
            ${$prefix."_".$k} = $v;
            //echo "ar:".${$prefix."_".$k}."<br>";
        }
    }
}//###################################### */
function db_connect() {
  if (file_exists("/home/inet/debian_coz_superglobals.php")) {
    global $user,$pw;
    require_once("/home/inet/debian_coz_superglobals.php");
    $db = "coz";$host = "localhost";
  }
  else if (0) { //v4
    $user = "BMDadmin";$pw = "Zb1m2d3";
    $db = "BMDadmin";$host = "p41mysql19.secureserver.net";
  }
  else { //v5
    $user = "bmd_site";$pw = "Z48b1m2z0d3";
    $db = "bmd_site";$host = "p50mysql251.secureserver.net";
  }
  $link=mysql_connect($host,$user,$pw)
               or die("Unable to connect to MySQL server ".$db);
  mysql_select_db($db) or die("Unable to select database $db");
  return $link;
}
//###################################################################
//###################################################################
/**
 * Convert SimpleXMLElement object to array
 * Copyright Daniel FAIVRE 2005 - www.geomaticien.com
 * Copyleft GPL license
 */
function simplexml2array($xml) {
   if (get_class($xml) == 'SimpleXMLElement') {
       $attributes = $xml->attributes();
       foreach($attributes as $k=>$v) {
           if ($v) $a[$k] = (string) $v;
       }
       $x = $xml;
       $xml = get_object_vars($xml);
   }
   if (is_array($xml)) {
       if (count($xml) == 0) return (string) $x; // for CDATA
       foreach($xml as $key=>$value) {
           $r[$key] = simplexml2array($value);
       }
       if (isset($a)) $r['@'] = $a;    // Attributes
       return $r;
   }
   return (string) $xml;
}
//###################################### */
function get_qty_select($qty="") {
    $ops = "";
	$qty_vals = array("1000","1500","2000","2500","3000","3500","4000","4500","5000","5500","6000","6500","7000","7500",
                      "8000","8500","9000","9500","10000","10500","11000","11500","12000","13000","15000","18000","20000");
    foreach ($qty_vals AS $qty_item) {
        $sel = ($qty == $qty_item) ? "selected": "";
        $ops .= "<option value=\"".$qty_item."\" $sel>".$qty_item."</option>\n";
    }
    return $ops;
}
//###################################### */
//###################################### */
function get_admin_login($username) {
    db_connect();
    if ($username == "") {
        $ret['AccessLevel'] =  "";
        $ret['Name'] = "";
    }
    else {
        $sql = "SELECT * FROM Users WHERE EmailAddress='".$username."'";
        //echo $sql;
        $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
        if (mysql_num_rows($result) < 1) {
            $ret['AccessLevel'] =  "";
            $ret['Name'] = "";
        }
        else {
            $rec = mysql_fetch_array($result);
            $ret['AccessLevel'] =  $rec['AccessLevel'];
            $ret['Name'] = $rec['FirstName']." ".$rec['LastName'];
        }
    }
    return $ret;
}
//###################################### */
function check_login($data_source,$username,$password) {
    db_connect();
    if ($data_source == "db") {
        $sql = "SELECT ExhibitorID FROM Exhibitors WHERE Password='".$password."' AND EmailAddress='".$username."'";
        //echo $sql;
        $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
        if (mysql_num_rows($result) < 1) {
            return "Error||That username/password is not in our database.";
        }
        else {
            $rec = mysql_fetch_array($result);
            return "OK|" . $rec['ExhibitorID'] . "|";
        }
    }
}
//###################################### */
function show_error_page($errmsg) {
    include("_header.php");
    echo wrap_err($errmsg);
    include("_footer.php");
}
//###################################### */
// must be called BEFORE any output to browser
function redirect($redir_page) {
    header("Location: $redir_page");
    exit;
}
//###################################### */
// must be called BEFORE any output to browser
function redirect_if_not_logged_in($calling_script,$redir_page) {
    global $disp_msg;
    //is there a login cookie?
    if (isset($_COOKIE['ExhibitorID'])) {
        return $_COOKIE['ExhibitorID'];
    }
    //is there an auto-login persistent cookie?
    else if (isset($_COOKIE['auto_login'])) {
        //echo decrypt($_COOKIE['auto_login']);
        list ($uname,$pw) = explode("\0",decrypt($_COOKIE['auto_login']));
        //echo "($uname,$pw)";
        list ($status,$ID,$msg) = explode("|",check_login("db",$uname,$pw));
        if ($status == "OK") {
            setcookie('ExhibitorID',$ID , 0, '/'); // session cookie for the scripts
            setcookie('auto_login',encrypt($uname."\0".$pw) , time()+60*60*24*180, '/'); // refresh the persistent cookie
            return $ID;
        }
        else {
            $disp_msg = wrap_err("Login error: ". $msg);
            //echo $msg.$redir_page;
            require $redir_page;
            exit;
        }
    }
    //If you get here, you are not logged in...
    header("Location: $redir_page");
    exit;
}
//###################################### */
function wrap_err($errmsg) {
    return "<span class='err-msg'>".$errmsg."</span>";
}
//###################################################################
function send_email($to,$to_name="",$from,$from_name="",$subject,$mailbody,$content_type = "text/plain") {
    if (file_exists("/home/inet/debian_coz_superglobals.php")) {
        require_once("/home/inet/smtp_mail.php");
        authSendEmail($to,$to_name,$from,$from_name,$subject,$mailbody,$content_type);
    }
    else if (1) {
        if (!empty($to_name)) {
            $to_address = $to_name."<".$to.">";
        }
        else {
            $to_address = $to;
        }
        if (!empty($from_name)) {
            $from_address = $from_name."<".$from.">";
        }
        else {
            $from_address = $from;
        }
        $headers  = 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: '.$content_type.'; charset=iso-8859-1' . "\n";
        $headers .= "From: " . $from_address . "\n";
        mail($to_address, $subject, $mailbody, $headers);
    }
    else {
        include_once("Mail.php");
        $params["host"] = "smtp..com";
        $params["port"] = "25";
        $params["auth"] = true;
        $params["username"] = "@.com";
        $params["password"] = "";
        $params["host"] = "smtp..com";
        $params["port"] = "25";
        $params["auth"] = true;
        $params["username"] = "@.com";
        $params["password"] = "";
        $headers["From"]    = $from;
        $headers["To"]      = $to;
        $headers["Subject"] = $subject;
        $mail_object =& Mail::factory("smtp", $params);
        $mail = $mail_object->send($to, $headers, $mailbody);
    }
}
//###################################### */
function get_page_content($cat) {
    db_connect();
    $sql = "SELECT * FROM Pages WHERE cat='$cat'";
    //echo $sql;
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
    $rec = mysql_fetch_array($result);
    $content = str_replace ( "\n", "<br />", $rec['content'] );
    $content = str_replace ( "\r", "", $content );
    $pic_src = $rec['photo'];
    $title = $rec['title'];
    $subtitle = $rec['subtitle'];
    $ret['html'] = <<< _END_
	<div class="header">$title</div>
	<p><img class="reg-img" src="/uploads/page_content/$pic_src" alt="" widthz="233" heightz="350" border="0" />$content
_END_;
    $ret['content'] = $content;
    $ret['pic_src'] = $pic_src;
    $ret['title'] = $title;
    $ret['subtitle'] = $subtitle;
    return $ret;
}
//###################################### */
function get_adm_page_content($handle) {
    db_connect();
    $sql = "SELECT * FROM Pages2 WHERE handle='$handle'";
    //echo $sql;
    $result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>");
    $rec = mysql_fetch_array($result);
    $content = str_replace ( "\n", "<br />", $rec['content'] );
    $content = str_replace ( "\r", "", $content );
    $pic_src = $rec['photo'];
    $title = $rec['title'];
    $ret['html'] = <<< _END_
	<div class="header">$title</div>
	<p><img class="reg-img" src="/uploads/page_content2/$pic_src" alt="" widthz="233" heightz="350" border="0" />$content
_END_;
    $ret['content'] = $content;
    $ret['pic_src'] = $pic_src;
    $ret['title'] = $title;
    return $ret;
}
//###################################### */
function IsInt($x) {
    return (is_numeric($x) ? intval($x) == $x : false);
}
//###################################### */
function error_exit($msg) {
//    echo "<br><br>".$msg."<br><br>";
global $left_links;
$left_links = 1;
    include("_header.php");
    echo <<< _END_
   <td class="shop-content">
   <p>An error has occurred: $msg</p>
   </td>
_END_;

    include("_footer.php");
    exit;
}
//###################################### */
function encrypt($string, $key="lizzwright") {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
    }
    return base64_encode($result);
}
function decrypt($string, $key="lizzwright") {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
    }
    return $result;
}
//###################################### */
function check_cookie($cook_name) {
    if (isset($_COOKIE[$cook_name])) {
        return $_COOKIE[$cook_name];
    }
    else {
        return FALSE;
    }
}
//###################################### */
//###################################################################
//###################################### */
function sanitize($str) {
    $bad_str = array("select", "drop", ";", "#", "insert", "delete","\"","'","(",")",";","|");//"-",
    return str_replace($bad_str, "", $str);
}
//###################################### */
function possible_injection_attack_sql($input_array) {
    //var_dump($input_array);
    $bad_words = array("select", "drop", ";", "#", "insert", "delete","\"","'","(",")",";","-","|");
    foreach ($bad_words AS $word) {
        if (in_array($word, $input_array)) {
            return TRUE;
        }
    }
    return FALSE;
}
//###################################### */
function possible_form_attack($input_array) {
    $bad_words = array("/","+","%","select", "drop", ";", "#", "insert", "delete","\"","'","(",")",";","-","|");
    foreach ($bad_words AS $word) {
    //echo $word;
        foreach ($input_array as $input_item) {
            //echo "$word==$input_item<br>";
            if (strpos($input_item,$word) !== false) {
                return TRUE;
            }
        }
    }
    return FALSE;
}
//###################################### */
function validEmail($email) {
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)   {
      $isValid = false;
   }
   else   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',str_replace("\\\\","",$local)))   {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))     {
            $isValid = false;
         }
      }
      /*if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }*/
   }
   return $isValid;
}

//###################################################################
function get_state_dropdown($state) {
    $dd = "";
    $state_list = array('AL'=>"Alabama",
                'AK'=>"Alaska",  
                'AZ'=>"Arizona",  
                'AR'=>"Arkansas",  
                'CA'=>"California",  
                'CO'=>"Colorado",  
                'CT'=>"Connecticut",  
                'DE'=>"Delaware",  
                'DC'=>"District Of Columbia",  
                'FL'=>"Florida",  
                'GA'=>"Georgia",  
                'HI'=>"Hawaii",  
                'ID'=>"Idaho",  
                'IL'=>"Illinois",  
                'IN'=>"Indiana",  
                'IA'=>"Iowa",  
                'KS'=>"Kansas",  
                'KY'=>"Kentucky",  
                'LA'=>"Louisiana",  
                'ME'=>"Maine",  
                'MD'=>"Maryland",  
                'MA'=>"Massachusetts",  
                'MI'=>"Michigan",  
                'MN'=>"Minnesota",  
                'MS'=>"Mississippi",  
                'MO'=>"Missouri",  
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",  
                'OK'=>"Oklahoma",  
                'OR'=>"Oregon",  
                'PA'=>"Pennsylvania",  
                'RI'=>"Rhode Island",  
                'SC'=>"South Carolina",  
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",  
                'TX'=>"Texas",  
                'UT'=>"Utah",  
                'VT'=>"Vermont",  
                'VA'=>"Virginia",  
                'WA'=>"Washington",  
                'WV'=>"West Virginia",  
                'WI'=>"Wisconsin",  
                'WY'=>"Wyoming");
    foreach ($state_list AS $st_code => $st_name) {
        $sel = $state == $st_code ? "selected" : "";
        $dd .= "<option value=\"$st_code\" $sel>$st_name</option>\n";
    }
    return $dd;
}
//###################################### */
function error_exit_global($msg) {
//    echo "<br><br>".$msg."<br><br>";
    //db_connect();
   // include("../_header.php");
    echo <<< _END_
              <table border="0" cellpadding="6" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber6">
                <tr>
                  <td width="100%" class="size1main">
                  <br>
                            <span class="size2mainb">$msg</span><br><br>
											</td>
										</tr>
									</table>
                   </td>
                </tr>
              </table>
_END_;
   // include("../_footer.php");
    exit;
}

?>