<?php
//import_request_variables("gp", "rv_");
//foreach ($_POST as $key => $value) {  echo("$key => $value<br>");}
error_reporting(E_ALL);
require_once("tarzan/tarzan.class.php");
require_once("_globals.php");
db_connect();

//$sqs = new AmazonSQS();
//$s3 = new AmazonS3();
$aaws = new AmazonAAWS();
//print_r($aaws);
//list_objects
//$list = $s3->get_bucket_list();

$opt['MerchantId'] = "All";
$opt['ResponseGroup'] = "Medium,Offers";
//$opt['MerchantId'] = 'wwwchildren00-20';
//$item1 = $aaws->item_lookup("B000PC507Q",$opt);

/*
$item1 = $aaws->item_lookup("B0001QAVSM",$opt);
//err?
if (isset($item1->body->Items->Request->Errors->Error->Message)) {
    echo "<b>".$item1->body->Items->Request->Errors->Error->Message."</b><br>";
}
print_r($item1);
exit;
*/
$item_data = "";
$sql = "Select * FROM products ORDER BY disp_ord";
$result = mysql_query($sql) or die("<b>Select Failed!</b><br>$sql<br>".mysql_error());
while ($rec = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $thisID = $rec['ID'];
    $item1 = $aaws->item_lookup($rec['prod_ID'],$opt);
    echo "<br><b>attempt: ".$rec['prod_ID']."</b><br>status: ".$item1->status."<br>";

    //err?
    if (isset($item1->body->Items->Request->Errors->Error->Message)) {
        echo "<b>ERROR: ".$item1->body->Items->Request->Errors->Error->Message."</b><hr>";
        $bad_ids .= $rec['prod_ID']."<br>";
        $bad_id_sql[] = "(ID=".$rec['ID'].")";
        continue;
    }
    
    $cat = $rec['cat'];
    $pic_src =  $item1->body->Items->Item->MediumImage->URL;
    $pic_height =  $item1->body->Items->Item->MediumImage->Height;
    $pic_width =  $item1->body->Items->Item->MediumImage->Width;
    
    $item_pic = "<img src='".$pic_src."' alt='' width='".$pic_width."' height='".$pic_height."' border='0'>";
    echo $item_pic;
    $thumb_src =  $item1->body->Items->Item->SmallImage->URL;
    $thumb_height =  $item1->body->Items->Item->SmallImage->Height;
    $thumb_width =  $item1->body->Items->Item->SmallImage->Width;
    $item_thumb = "<img src='".$thumb_src."' alt='' width='".$thumb_width."' height='".$thumb_height."' border='0'>";
    echo $item_thumb;
    
    $aTitle = $item1->body->Items->Item->ItemAttributes->Title;
    echo $aTitle . "<br>";
    
    $aLowestNewPrice = $item1->body->Items->Item->OfferSummary->LowestNewPrice->Amount;
    echo "aLowestNewPrice" . $aLowestNewPrice . "<br>";
    $aLowestNewPriceFormatted = $item1->body->Items->Item->OfferSummary->LowestNewPrice->FormattedPrice;
    echo $aLowestNewPriceFormatted . "<br>";
    $aTotalNew = $item1->body->Items->Item->OfferSummary->TotalNew;
    echo "tot new ".$aTotalNew . "<br>";
    $aTotalUsed = $item1->body->Items->Item->OfferSummary->TotalUsed;
    echo "tot used ".$aTotalUsed . "<br>";

    $aTotalOffers = $item1->body->Items->Item->Offers->TotalOffers;
    echo "TotalOffers ".$aTotalOffers . "<br>";

    $aOfferListingId = $item1->body->Items->Item->Offers->Offer[0]->OfferListing->OfferListingId;
    echo "OfferListingId ".$aOfferListingId . "<br>";
    //if (isset($item1->body->Items->Item->Offers->Offer[0])) { echo "<b>ARRAY:</b><br>"; }
    $aAvailability = $item1->body->Items->Item->Offers->Offer[0]->OfferListing->Availability;
    echo "Availability ".$aAvailability . "<br>";

    $aOfferPrice = $item1->body->Items->Item->Offers->Offer[0]->OfferListing->Price->Amount;
    echo "aOfferPrice ".$aOfferPrice . "<br>";
    $aOfferPriceFormatted = $item1->body->Items->Item->Offers->Offer[0]->OfferListing->Price->FormattedPrice;
    echo "aOfferPriceFormatted ".$aOfferPriceFormatted . "<br>";
    
    if ($aOfferPrice*0 != $aLowestNewPrice*0) { echo "<b>PRICE MISMATCH!!!!: $aOfferPrice != $aLowestNewPrice</b><br>"; }

    $aManufacturer = $item1->body->Items->Item->ItemAttributes->Manufacturer;
    echo "aManufacturer ".$aManufacturer . "<br>";

     //features?
    $features = "";
    if (isset($item1->body->Items->Item->ItemAttributes->Feature)) {
        //print_r($item1);
        //print_r($item1->body->Items->Item->ItemAttributes->Feature);
        echo "<b>FEATURES: </b><br>";
        foreach ($item1->body->Items->Item->ItemAttributes->Feature AS $feature) {
            echo $feature."<br>";
            $features .= $feature."<br>";
        }
    }
    else  {
        echo "<b>NO FEATURES: </b><br>";
    }
    
    //description?
    //[Source] => Product Description
    $description = "";
    if (isset($item1->body->Items->Item->EditorialReviews->EditorialReview->Content)) {
        if (($item1->body->Items->Item->EditorialReviews->EditorialReview->Source == "Product Description") ||
           ($item1->body->Items->Item->EditorialReviews->EditorialReview->Source == "Album Description")) {
            echo "<b>description: </b><br>".$item1->body->Items->Item->EditorialReviews->EditorialReview->Content."";
            $description = $item1->body->Items->Item->EditorialReviews->EditorialReview->Content;
        }
        else {
            echo "<b>NO description: </b><br>";
            print_r($item1);
        }
    }
    else {
        echo "<b>NO Content: </b><br>";
        print_r($item1);
    }
    
    $esc_description = str_replace("\"","\\\"",$description);
    $esc_features = str_replace("\"","\\\"",$features);
    $esc_aTitle = str_replace("\"","\\\"",$aTitle);
    $item_data .= <<< _END_
\$item['pic_src'] = "$pic_src";
\$item['pic_height'] = "$pic_height";
\$item['pic_width'] = "$pic_width";
\$item['thumb_src'] = "$thumb_src";
\$item['thumb_height'] = "$thumb_height";
\$item['thumb_width'] = "$thumb_width";
\$item['features'] = "$esc_features";
\$item['description'] = "$esc_description";
\$item['aTitle'] = "$esc_aTitle";
\$item['aLowestNewPrice'] = "$aLowestNewPrice";
\$item['aLowestNewPriceFormatted'] = "$aLowestNewPriceFormatted";
\$item['aTotalNew'] = "$aTotalNew";
\$item['aTotalUsed'] = "$aTotalUsed";
\$item['aTotalOffers'] = "$aTotalOffers";
\$item['aOfferListingId'] = "$aOfferListingId";
\$item['aAvailability'] = "$aAvailability";
\$item['aOfferPrice'] = "$aOfferPrice";
\$item['aOfferPriceFormatted'] = "$aOfferPriceFormatted";
\$item['aManufacturer'] = "$aManufacturer";
\$items_data[$cat][] = \$item;

_END_;

    //$online = ($aTotalOffers*1 > 0) ? 1 : 0;

    $sql_update = <<< _END_
    UPDATE products SET 
    online = |1|,
    pic_src = |$pic_src|,
    pic_height = |$pic_height|,
    pic_width = |$pic_width|,
    thumb_src = |$thumb_src|,
    thumb_height = |$thumb_height|,
    thumb_width = |$thumb_width|,
    features = |$features|,
    description = |$description|,
    aTitle = |$esc_aTitle|,
    aLowestNewPrice = |$aLowestNewPrice|,
    aLowestNewPriceFormatted = |$aLowestNewPriceFormatted|,
    aTotalNew = |$aTotalNew|,
    aTotalUsed = |$aTotalUsed|,
    aTotalOffers = |$aTotalOffers|,
    aOfferListingId = |$aOfferListingId|,
    aAvailability = |$aAvailability|,
    aOfferPrice = |$aOfferPrice|,
    aOfferPriceFormatted = |$aOfferPriceFormatted|,
    aManufacturer = |$aManufacturer|,
    update_time = NOW()
    WHERE ID=$thisID
_END_;
    $sql_update = str_replace("'","\\'",$sql_update);
    $sql_update = str_replace("|","'",$sql_update);
    $update_result = mysql_query($sql_update) or die("<b>Select Failed!</b><br>$sql_update<br>".mysql_error());

    echo "$sql_update<hr>";
    //$aDesc = $item1->body->Items->Item->EditorialReviews->EditorialReview->Content;
    //echo $aDesc . "<br><br>";

    print_r($item1);
    //if ($ct++ > 3) { echo "<br>".$item_data. "<br>" ; break; }
}

echo $bad_ids;
$sql_update = "UPDATE products SET online = 0 WHERE " . implode(" OR ",$bad_id_sql);
$update_result = mysql_query($sql_update) or die("<b>Select Failed!</b><br>$sql_update<br>".mysql_error());
//print_r($item1 );
$fd = fopen("listings_data.php", "w");
if ($fd === false) { echo "open failed"; }
fwrite($fd, '<?php'."\n".$item_data.'?>');
fclose($fd);
?>

<html>
<body>

</body>
</html>