<?php
//import_request_variables("gp", "rv_");
  $dh = opendir(".");
  while (($filename = readdir($dh)) !== false) {
      if (($filename != ".")&&($filename != "..")&&($filename != "index.php")) {
          //echo date("n/j/Y", filemtime($filename))." &nbsp; <a href='$filename'>$filename</a><br>";
          $files[$filename] =
              date("n/j/Y", filemtime($filename))." &nbsp; <a href='$filename'>$filename</a><br>";
      }
  }
  ksort($files);
  foreach ($files AS $k => $v) {
      echo $v;
  }

/*****************************************************************************************/
function show_dirz($dir) {
  $dh = opendir($dir);
  while (($filedir = readdir($dh)) !== false) {
    //if(is_dir($filedir."/")) {
      echo $filedir . "<br>";
      //show_dirz($filedir);
    //}
  }
}
function parse_dir($dir) {
   if ($dh = @opendir($dir)) {
       while(($file = readdir($dh)) !== false) {
           if( !preg_match('/^\./s', $file) )  {
               if(is_dir($dir.$file)) {
                   $newdir = $dir.$file.'/'; // <- tailing slash
                   chdir($newdir);
                   echo "IS DIR: $newdir<br>";
                   echo parse_dir($newdir);
               } else {
                   //echo $dir.$file."\n";
               }
           }
       }
       chdir('..');
   }
}
?>