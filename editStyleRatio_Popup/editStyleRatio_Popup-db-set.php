<?php
include('../Connector.php');	
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
?>