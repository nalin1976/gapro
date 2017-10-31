<?PHP
include '../Connector.php';
$id = $_GET["id"];

if($id=='saveHeader')
{

		$strStyleId				= $_GET["strStyleId"];
		$intMatDetailId			= $_GET["intMatDetailId"];
		$strBuyerPoNo			= $_GET["strBuyerPoNo"];
		$strColor				= $_GET["strColor"];
		$strMarker				= $_GET["strMarker"];
		$dblCutNo				= $_GET["dblCutNo"];
		$dblWidth				= $_GET["dblWidth"];
		$dtDate					= $_GET["dtDate"];
		$dblOrderQty			= $_GET["dblOrderQty"];
		$strFactRefNo			= $_GET["strFactRefNo"];
		$dblPercentage			= $_GET["dblPercentage"];
		$intUserId				= $_GET["intUserId"];
		$dblMarkerLengthYrd		= $_GET["dblMarkerLengthYrd"];
		$dblMarkerLengthInch	= $_GET["dblMarkerLengthInch"];
		$Eff					= $_GET["Eff"];
		$dblTotalYrd			= $_GET["dblTotalYrd"];
		$dblLayerNo				= $_GET["dblLayerNo"];
		$dbladitictLayer 		= $_GET["dbladitictLayer"];
		$intStatus				= $_GET["intStatus"];

		
		/////////////////////////////////// check and delete allready exist data //////////////////////////
		$SQL1 = "DELETE FROM cutticketsheader where intStyleId='$strStyleId' AND
		 intMatDetailId		=	'$intMatDetailId' 	AND 
		 strBuyerPoNo		=	'$strBuyerPoNo' 	AND 
		 strColor			= 	'$strColor'			AND
		 strMarker			=	'$strMarker'		AND
		 dblCutNo			=	'$dblCutNo'			
		 ";
		$result = $db->RunQuery($SQL1);
		//echo $SQL1;
		///////////////////////////////////////////////////////////////////////////////////
		
		$SQL  = "insert into cutticketsheader 
					(intStyleId, 
					intMatDetailId, 
					strBuyerPoNo, 
					strColor, 
					strMarker, 
					dblCutNo, 
					dblWidth, 
					dtDate, 
					dblOrderQty, 
					strFactRefNo, 
					dblPercentage, 
					intUserId, 
					dblMarkerLengthYrd, 
					dblMarkerLengthInch, 
					Eff, 
					dblTotalYrd, 
					dblLayerNo, 
					dbladitictLayer, 
					intStatus
					)
					values
					('$strStyleId', 
					'$intMatDetailId', 
					'$strBuyerPoNo', 
					'$strColor', 
					'$strMarker', 
					'$dblCutNo', 
					'$dblWidth', 
					'$dtDate', 
					'$dblOrderQty', 
					'$strFactRefNo', 
					'$dblPercentage', 
					'$intUserId', 
					'$dblMarkerLengthYrd', 
					'$dblMarkerLengthInch', 
					'$Eff', 
					'$dblTotalYrd', 
					'$dblLayerNo', 
					'$dbladitictLayer', 
					'0'
					);";
				
		$result = $db->RunQuery($SQL);
		if($result>0)
			echo $result;
		else
			echo $SQL;
			
		
}


if($id =='saveSizeDetails')
{
	$count					= $_GET["count"];
	$strStyleId				= $_GET["strStyleId"];
	$intMatDetailId			= $_GET["intMatDetailId"];
	$strBuyerPoNo			= $_GET["strBuyerPoNo"];
	$strColor				= $_GET["strColor"];
	$strMarker				= $_GET["strMarker"];
	$dblCutNo 				= $_GET["dblCutNo"];
	$strSize 				= $_GET["strSize"];
	$dblCuttableQty 		= $_GET["dblCuttableQty"];
	$dblCutQty 				= $_GET["dblCutQty"];
	$dblWith_Percentage 	= $_GET["dblWith_Percentage"];
	$dblWidth				= $_GET["dblWidth"];
		

if($count==1)
{
		/////////////////////////////////// Find and recorect data ///////////////////////////
		$SQL = "SELECT dblCutQty, strSize FROM `cutticketsdetails` 
				WHERE
					intStyleId 		=  '$strStyleId' AND
					intMatDetailId 	=  '$intMatDetailId' AND
					strBuyerPoNo 	=  '$strBuyerPoNo' AND
					strColor 		=  '$strColor' AND
					strMarker 		=  '$strMarker'	AND
					dblCutNo		=	'$dblCutNo'
					
				";
		$result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{
					$A_strSize 		= $row["strSize"];
					$A_dblCutQty	= $row["dblCutQty"];
					$SQL1 = "UPDATE cadconsumptionsizedetails SET dblPending=dblPending+$A_dblCutQty WHERE
							intStyleId 		=  '$strStyleId' AND
							intMatDetailId 	=  '$intMatDetailId' AND
							strColor 		=  '$strColor' AND
							strMarkerName	=  '$strMarker'	AND
							strSize 		=  '$A_strSize'
									
							";
					$result1 = $db->RunQuery($SQL1);
					echo $SQL1;

		}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		
		/////////////////////////////////// check and delete allready exist data ///////////////////////////
		$SQL1 = "DELETE FROM cutticketsdetails where intStyleId='$strStyleId' AND 
				intMatDetailId='$intMatDetailId' 	AND 
				strBuyerPoNo='$strBuyerPoNo' 			AND 
				strColor='$strColor' 					AND
				strMarker='$strMarker' 					AND
				dblCutNo='$dblCutNo' 				
				";
		$result = $db->RunQuery($SQL1);
		////////////////////////////////////////////////////////////////////////////////////////////////////
}
		$SQL = "insert into cutticketsdetails 
				(intStyleId, 
				intMatDetailId, 
				strBuyerPoNo, 
				strColor, 
				strMarker, 
				dblCutNo, 
				strSize, 
				dblCuttableQty, 
				dblCutQty, 
				dblWith_Percentage, 
				dblWidth
				)
				values
				('$strStyleId', 
				'$intMatDetailId', 
				'$strBuyerPoNo', 
				'$strColor', 
				'$strMarker', 
				'$dblCutNo', 
				'$strSize', 
				'$dblCuttableQty', 
				'$dblCutQty', 
				'$dblWith_Percentage', 
				'$dblWidth'
				);

				";
		$result = $db->RunQuery($SQL);
		if($result>0)
			echo $result;
		else
			echo $SQL;
			
			
		$SQL1 = "UPDATE cadconsumptionsizedetails SET dblPending=dblPending-$dblCutQty WHERE
							intStyleId 		=  '$strStyleId' AND
							intMatDetailId 	=  '$intMatDetailId' AND
							strColor 		=  '$strColor' AND
							strMarkerName	=  '$strMarker'	AND
							strSize 		=  '$strSize'
								
						";
		$result1 = $db->RunQuery($SQL1);
		echo $SQL1;
			
}

if($id =='confirm')
{

	$strStyleId			= $_GET["strStyleId"];
	$intMatdetailId		= $_GET["intMatdetailId"];
	$strColor			= $_GET["strColor"];
	$BuyerPoNo			= str_replace("***","#",$_GET["BuyerPoNo"]);

		$SQL = "update cadconsumptionheader set intStatus=1 WHERE
				intStyleId =  '$strStyleId' AND
				intMatdetailId =  '$intMatdetailId' AND
				strColor =  '$strColor' AND
				strBuyerPoNo =  '$BuyerPoNo'";
				
		$result = $db->RunQuery($SQL);
		echo $result;

}
?>
