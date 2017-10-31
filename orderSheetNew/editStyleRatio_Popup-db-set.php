<?php
include "../Connector.php";

	 $type=trim($_GET["RequestType"]);
	
//----------------------------------------------------	 
if($type=="saveEditedStyleRatio")
{
	$strStyleID=trim($_GET["strStyleID"]);
	$buyerPO=trim($_GET["buyerPO"]);
	$user = $_GET["User"];
	
	 $ArrayColor = $_GET["ArrayColor"];
	$ArraySize = $_GET["ArraySize"];
	$ArrayQty = $_GET["ArrayQty"];
	
	$explodeColor = explode(',', $ArrayColor);
	$explodeSize = explode(',', $ArraySize) ;
	$explodeQty = explode(',', $ArrayQty);
	
	$sql1="SELECT MAX(intOrderNo) FROM editedStyleRatio";
	$result= $db->RunQuery($sql1);
	$row = mysql_fetch_array($result);
	$orderNo= $row["MAX(intOrderNo)"]+1;
	
	$records = count($explodeColor)-1;
	$error=0;

		for ($i = 0;$i < $records;$i++)
		{
    	 $query="INSERT INTO editedStyleRatio (intOrderNo,intStyleId,strBuyerPONO,strColor,strSize,dblExQty,strUserId,dtmDate)
				VALUES
				('$orderNo','$strStyleID','$buyerPO','$explodeColor[$i]','$explodeSize[$i]','$explodeQty[$i]','$user',now())";	
		$result = $db->RunQuery($query);
			if(!$result){
				echo $message1.=$query."\n";
				$error=1;
			}
		}
		
	if($records>0){
		if($error==0)
			 $message="Saved Sucessfully";
		 else
			 $message=$message1;
	}
	else{
			 $message="No records to save";;	
	}
		
			echo $message;
}

if($type=="save")
{
	 $intStyleId = $_GET["intStyleId"];
	 $ratioOrderNos = $_GET["ratioOrderNos"];
	 $itemSerial = $_GET["itemSerial"];
	 $conPc = $_GET["conPc"];
	 $reqQty = $_GET["reqQty"];
	 $color = $_GET["color"];
	 $size  = $_GET["size"];
	 $BuyerPONO  = $_GET["BuyerPONO"];
	 $wastage  = $_GET["wastage"];
	 $description  = $_GET["description"];
	 
	
   echo $sql = "INSERT INTO editordersheet
				     (intDocNo,intStyleId,intMatDetailId,strDes,strColor,strSize,strBuyerPoNo,strWastage,dblConPc,dblReqQty,intStatus)
				      VALUES('$ratioOrderNos','$intStyleId','$itemSerial','$description','$color','$size','$BuyerPONO','$wastage','$conPc','$reqQty',1);";
   $result = $db->RunQuery($sql);
	
	if(!$resultInsert)
	{
		echo $sqlUpdate = "UPDATE editordersheet
					  SET dblConPc='$conPc', dblReqQty='$reqQty',strWastage='$wastage',strDes='$description'
					  WHERE intDocNo='$ratioOrderNos' AND intStyleId='$intStyleId' AND intMatDetailId='$itemSerial' AND strColor='$color' AND strSize='$size'
					  AND strBuyerPoNo='$BuyerPONO' ";
					  
		$resultUpdate = $db->RunQuery($sqlUpdate);
		
		
	}
}

if($type=="delete")
{
	 $intStyleId = $_GET["intStyleId"];
	 $ratioOrderNos = $_GET["ratioOrderNos"];
	 $itemSerial = $_GET["itemSerial"];
	 $conPc = $_GET["conPc"];
	 $reqQty = $_GET["reqQty"];
	 $color = $_GET["color"];
	 $size  = $_GET["size"];
	 $BuyerPONO  = $_GET["BuyerPONO"];
	 $wastage  = $_GET["wastage"];
 
   echo $sql = "INSERT INTO editordersheet
				     (intDocNo,intStyleId,intMatDetailId,strColor,strSize,strBuyerPoNo,strWastage,dblConPc,dblReqQty,intStatus)
				      VALUES('$ratioOrderNos','$intStyleId','$itemSerial','$color','$size','$BuyerPONO','$wastage','$conPc','$reqQty',0);";
    $result = $db->RunQuery($sql);
	
	if(!$resultInsert)
	{
		echo $sqlUpdate = "UPDATE editordersheet
					  SET intStatus='0'
					  WHERE intDocNo='$ratioOrderNos' AND intStyleId='$intStyleId' AND intMatDetailId='$itemSerial' AND strColor='$color' AND strSize='$size'
					  AND strBuyerPoNo='$BuyerPONO' ";
					  
		$resultUpdate = $db->RunQuery($sqlUpdate);
		
		
	}
}

//----------------------------------------------------------------------------------------------------------------------------------------------------

if($type=="cancelOrderSheet")
{
 $tdRatioOrderNos = $_GET["tdRatioOrderNos"];
 
  $sql1 = "update editedStyleRatio set intStatus = '0' where intOrderNo = '$tdRatioOrderNos'";
 $resultCancel = $db->RunQuery($sql1);
 if($resultCancel == 1){
  echo 1;
 }else{
  echo 0;
 }
}
?>