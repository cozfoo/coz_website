<?php
error_reporting(E_ALL);
//print_r($_COOKIE);
if(!empty($_COOKIE['RotatePic']))
	{
	$last_pic = $_COOKIE['RotatePic'];
	if ($last_pic < 3) {
		$last_pic++;
		setcookie('RotatePic', $last_pic, 0,  "/");
		}
	else
	{
	$last_pic = 1;
	setcookie('RotatePic', $last_pic, 0,  "/");
	}
}
else
{
    $last_pic = 1;
    setcookie('RotatePic', $last_pic, 0,  "/");
}
print_r($_COOKIE);
$last_pic = "homeart/home-pic-".$last_pic.".jpg";
echo $last_pic;
print_r($_COOKIE);
exit;

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mitchell Albala Landscape Painting and Learning Center: Articles, Plein Air, Publications Instruction</title>
<link href="albala.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	
	getElementById('rotate').scr= <?php echo $last_pic ?>;
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<meta name="Keywords" content="Mitchell Albala, landscape painting, Gage Academy of Art, Lisa Harris Gallery, plein air painting, American Artist Magazine, Watson-Guptill Publications, Seattle Art Museum, Impressionism, art instruction" />
<meta name="Description" content="Landscape paintings and learning center of landscape painter Mitchell Albala: instructor of Landscape Painting and author , featuring a behind the scenes look at the creative process." />
</head>

<body onload="MM_preloadImages('homeart/preview-waterfall.jpg','homeart/preview-alaska.jpg','homeart/preview-fog.jpg','homeart/preview-cloud.jpg','homeart/preview-small.jpg')">
<div id="container">
<div id="header"><img src="homeart/home-header.gif" width="729" height="73" /></div>

<div id="border-wrapper">
  <table width="961" border="0" cellpadding="0" cellspacing="24">
    <tr>
      <td width="136" height="510" valign="top"><p class="bodytext-white"><img src="typical/spacer.gif" width="136" height="48" /><br />
          <strong>PORTFOLIO</strong></p>
        <p class="bodytext-white">&#155;&#155; <a href="portfolio/waterfalls/waterfalls.html" onmouseover="MM_swapImage('preview','','homeart/preview-waterfall.jpg',1)" onmouseout="MM_swapImgRestore()">Waterfall Series</a></p>
        <p class="bodytext-white">&#155;&#155; <a href="portfolio/alaska/alaska.html" onmouseover="MM_swapImage('preview','','homeart/preview-alaska.jpg',1)" onmouseout="MM_swapImgRestore()">Alaska Series</a></p>
        <p class="bodytext-white">&#155;&#155; <a href="portfolio/fog/fog.html" onmouseover="MM_swapImage('preview','','homeart/preview-fog.jpg',1)" onmouseout="MM_swapImgRestore()">Fog Series</a></p>
        <p class="bodytext-white">&#155;&#155; <a href="portfolio/cloud-nocturne/cloud-nocturne.html" onmouseover="MM_swapImage('preview','','homeart/preview-cloud.jpg',1)" onmouseout="MM_swapImgRestore()">Cloud Series</a></p>
        <p class="bodytext-white">&#155;&#155; <a href="portfolio/small/small.html" onmouseover="MM_swapImage('preview','','homeart/preview-small.jpg',1)" onmouseout="MM_swapImgRestore()">Small Works</a></p>
        <p class="bodytext-white">&nbsp;</p>
        <p class="bodytext-white"><img src="typical/spacer.gif" name="preview" width="136" height="140" id="preview" /></p></td>
       
<!-- rotate pics on load -->	   
	    
      <td width="360" valign="top"><img ID="rotate" src=<?php echo $last_pic ?> width="360" height="445" />
	  
	       
        <p class="bodytext-white-small">&nbsp;</p>
        <p class="bodytext-white-small">&#169;2000&#150;2009 by Mitchell Albala. All rights reserved. Written content and  images of paintings may not be borrowed, reproduced or reprinted without the explicit, written permission of Mitchell Albala. <a href="mailto:mitch@mitchalbala.com">mitch@mitchalbala.com</a></p></td>
      <td width="369" valign="top"><p class="bodytext-white"><img src="/typical/spacer.gif" width="360" height="48" /><br />
          <a href="learning/index.html" class="bodytext-white"><strong>EXPLORE the LEARNING CENTER</strong></a> - Articles, real-world lessons, painting analyses,  and resources for the painter.</p>
        <p class="bodytext-white"><a href="gage/index.html" ><strong>CLASSES at GAGE ACADEMY of ART </strong></a></p>
        <p class="bodytext-white"><a href="bio-contact/bio.html"><strong>ARTIST PROFILE</strong></a></p>
        <p class="bodytext-white"><a href="#"><strong>CONTACT</strong></a> Mitchell Albala</p>
        <div id="homebookbox"> 
          <p class="bodytext-white"><strong> NEW BOOK by Mitchell Albala</strong><br />
            <a href="book/index.html"><em>Landscape Painting: Essential Concepts and Techniques for Plein Air and Studio Practice </em></a><br/>
            Available Nov. 17. (Watson-Guptill, 2009)
          
          <p class="bodytext-white"><strong><a href="book/index.html"><img src="homeart/bookcover.jpg" border="0" class="image_float_rt" /></a></strong><a href="book/different.html">How is &quot;Landscape Painting&quot; different?</a></p>
          <p class="bodytext-white"><a href="book/index.html">Look Inside</a><strong> - </strong>Overview, Introduction, Contents, Excerpt, Featured Artists</p>
          <p class="bodytext-white"><a href="book/events.html">Book Release Event and Exhibition</a> - Gage <br/>
    Academy, Nov. 20, 2009</p>
  <p class="bodytext-white"><a href="book/events.html">Schedule</a> - Book signings and demonstrations</p>
  <!--closing tag for #homebookbox -->
      </div> </td></tr>
  </table>
</div>
<!--closing tag for #container-->
</div>
</body>
</html>
