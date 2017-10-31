<?php
session_start();
include "../Connector.php";
header('Content-Type: text/xml');

$RequestType = $_GET['RequestType'];

if($RequestType == "save")
{
	$styleid       		= $_GET['styleid'];
	$customer       	= $_GET['customer'];
	$stylenumber       	= $_GET['stylenumber'];
	$ordernumber        = $_GET['ordernumber'];
	$fabsupplier        = $_GET['fabsupplier'];
	$description        = $_GET['description'];
	$designer           = $_GET['designer'];
	$date       		= $_GET['date'];
	$size           	= $_GET['size'];
	$quality            = $_GET['quality'];
	$sampletype			= $_GET['sampletype'];
	$price       		= $_GET['price'];
	$composition        = $_GET['composition'];
	$lining            	= $_GET['lining'];
	$button             = $_GET['button']; 
	$zip 				= $_GET['zip'];
	$additionaldetails 	= $_GET['additionaldetails'];	
	$userid				= $_SESSION["UserID"];
	
	$arr = strrev($stylenumber);
	if($arr[0]=="-")
		$stylenumber = substr($stylenumber, 0, -1);
		
	$checkStyle  = "SELECT intStyleId FROM orders WHERE intStyleId=$styleid";
	$resultStyle = $db->RunQuery($checkStyle);
	
	$sqlCheck    = "Select strStyle FROM orders WHERE (strStyle='$stylenumber' OR strOrderNo='$ordernumber') AND intStatus=2";
	$resultCheck = $db->RunQuery($sqlCheck);
	
	if( $styleid == "" && !mysql_num_rows($resultCheck)>0)
	{
	
		$SQL1    = "INSERT INTO orders 
 					(intBuyerID,strStyle,strOrderNo,strSupplierID,strDescription,strDesigner
					,dtmDate,strSize,strQuality,strSampleId,dblPrice,strComposition,strLining,strButton
					,strZip,strAddDetails,intStatus,intUserID)
					VALUES ('$customer','$stylenumber','$ordernumber','$fabsupplier','$description','$designer'
					,'$date','$size','$quality','$sampletype','$price','$composition','$lining','$button'
					,'$zip','$additionaldetails',2,$userid)";
			 
		$result1 = $db->RunQuery($SQL1);
		
			
		$SQL12  = "INSERT INTO sampleschedule
				   (intStyleId,intStatus) VALUES ('$styleid',1)";
		$result12 = $db->RunQuery($SQL12);
		if($result1 && $result12)
			echo 1;		
	}
	else if($styleid != "")
	{
		
		$sqlCheck1    = "Select strStyle FROM orders WHERE strStyle='$stylenumber' 
						 AND strOrderNo='$ordernumber' AND intStatus=2 AND intStyleId!=$styleid";
		$resultCheck1 = $db->RunQuery($sqlCheck1);
		
		if(!mysql_num_rows($resultCheck1)>0)
		{
			$SQL2 = "UPDATE orders
				 	SET intBuyerID = '$customer',strStyle = '$stylenumber',strOrderNo = '$ordernumber'
				 	,strSupplierID = '$fabsupplier',strDescription = '$description',strDesigner = '$designer'
				 	,dtmDate = '$date',strSize = '$size',strQuality = '$quality',dblPrice = '$price'
				 	,strComposition = '$composition',strLining = '$lining',strButton = '$button'
				 	,strZip = '$zip',strAddDetails = '$additionaldetails',strSampleId = '$sampletype'
				 	WHERE intStyleId = '$styleid'";
		
			$result2 = $db->RunQuery($SQL2);
			if($result2)
				echo 1;
			
		}
		else
			echo 2;
			/*$SQL22 = "UPDATE sampleschedule
					  SET intBuyerNo = '$customer',strSize = '$size',intSampleTypeId = '$sampletype'
					  ,intFabricSupp = '$fabsupplier',strDescription = '$description'
					  ,dtmDate = '$date' WHERE intStyleId=$styleid";
					  
			$result22 = $db->RunQuery($SQL22);*/
			
	}
	else
	{
		echo 2;
	}
}

else if($RequestType=='deleteImage')
{
	$styleid = $_GET['styleid'];
	$imagename  = $_GET['imagename'];
	
	if(file_exists("../styleDocument/".$styleid."/Sketch/".$imagename))
	{
		unlink("../styleDocument/".$styleid."/Sketch/".$imagename);
	}
}

else if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
{
	    
	    $imageData = $GLOBALS['HTTP_RAW_POST_DATA'];
	    $filteredData = substr($imageData, strpos($imageData, ",")+1);
	    $unencodedData=base64_decode($filteredData);
	 
        $stylenumber = $_GET['stylenumber'];
		$filename    = $_GET['filename'];
	    
	    $fp = fopen('../styleDocument/'.$stylenumber.'/Sketch/'.$filename,'w');
	    fwrite( $fp, $unencodedData);
	    fclose( $fp );
}

else if($RequestType=="getStyleCustomer")
{
$ResponseXML="";
$ResponseXML.="<MainStyleNo>";
$buyerID=$_GET["buyerID"];
global $db;
if($buyerID!="")
{
$sql="SELECT distinct  strStyle FROM orders where intBuyerID='$buyerID' and intStatus='2' order by strStyle";
}
else
{
	$sql="SELECT distinct strStyle FROM orders where intStatus='2' order by strStyle";
}
 
 $result=$db->RunQuery($sql);
 $str .= "<option value=\"".""."\">Select One</option>";
while($row = mysql_fetch_array($result))
{
	$str .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>";
}

$ResponseXML .= "<StyleNo><![CDATA[" . $str . "]]></StyleNo>\n";
$ResponseXML.="</MainStyleNo>";
echo $ResponseXML;
}


else if($RequestType=="getBuyerOrderNo")
{
$ResponseXML="";
$ResponseXML.="<MainStyleNo>";
$buyerID=$_GET["buyerID"];
global $db;
if($buyerID!="")
{
$sql="SELECT intStyleId,strOrderNo FROM orders where intBuyerID='$buyerID' and intStatus='2' order by strOrderNo";
}
else
{
	$sql="SELECT intStyleId, strOrderNo FROM orders where intStatus='2' order by strOrderNo";
}
 
 $result=$db->RunQuery($sql);
 $str .= "<option value=\"".""."\">Select One</option>";
while($row = mysql_fetch_array($result))
{
//$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"]. "]]></StyleNo>\n";
	$str .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
}

$ResponseXML .= "<OrderNo><![CDATA[" . $str . "]]></OrderNo>\n";
$ResponseXML.="</MainStyleNo>";
echo $ResponseXML;
}

else if($RequestType=="getStyleWiseOrderNoOrderinquiry")
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = "select intStyleId,strOrderNo from orders where intUserID=" . $_SESSION["UserID"] . " and intStatus= 2 ";
		
	if($stytleName != '')
		$SQL .= "and strStyle='$stytleName' ";
		
		$SQL .= "order by strOrderNo ";
	$result = $db->RunQuery($SQL);
	
	$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
?>