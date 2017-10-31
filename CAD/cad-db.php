<?PHP
include '../Connector.php';
$id = $_GET["id"];

if($id=='saveHeader')
{
		$Styleid 				= $_GET["Styleid"];
		$Fabric					= $_GET["Fabric"];
		$BuyerPoNo				= str_replace("***","#",$_GET["BuyerPoNo"]);
		$Color					= $_GET["Color"];
		$Width					= $_GET["Width"];
		$Mearchandiser			= $_GET["Mearchandiser"];
		$TotalQty				= $_GET["TotalQty"];
		$Width					= $_GET["Width"];
		$BudgetedConsumption	= $_GET["BudgetedConsumption"];
		$BudgetedPcs			= $_GET["BudgetedPcs"];
		$FabricRecieved			= $_GET["FabricRecieved"];
		$PipingConsumption		= $_GET["PipingConsumption"];
		$ProductionPcs			= $_GET["ProductionPcs"];
		$CuttableQty			= $_GET["CuttableQty"];
		$Percentage				= $_GET["Percentage"];
		$date					= date('Y-m-d');
		
		/////////////////////////////////// find sub category no ////////////////////////////////
		$SQL1 = "SELECT  intSubCatID FROM matitemlist WHERE matitemlist.intItemSerial =  '$Fabric'";
		$result = $db->RunQuery($SQL1);
		while($row = mysql_fetch_array($result))
		{
				$intMatCategoryId = $row["intSubCatID"];
				break;
		}
		///////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////// check and delete allready exist data //////////////////////////
	$SQL1 = "DELETE FROM cadconsumptionheader where intStyleId='$Styleid' AND intMatCategoryId='$intMatCategoryId' AND intMatdetailId='$Fabric' AND strColor='$Color'";
	$result = $db->RunQuery($SQL1);
	//echo $SQL1;
		///////////////////////////////////////////////////////////////////////////////////
		
		$SQL  = "insert into cadconsumptionheader 
				(intStyleId, 
				intMatCategoryId, 
				intMatdetailId, 
				strColor, 
				strBuyerPoNo,
				dblwidth, 
				dblBudgetedPipingConsumption,
				dblBudgetedConPcs,
				dblFabricRecievedExpected,
				dblPipingConsumptionYrd,
				dblProductionConPcsPercentage,
				dblProductionConPcsYrd,
				dblCuttableQtyYrd,
				dtmDate,
				strUserId, 
				intStatus, 
				dblPercentage
				)
				values
				('$Styleid', 
				'$intMatCategoryId', 
				'$Fabric', 
				'$Color', 
				'$BuyerPoNo',
				'$Width', 
				'$BudgetedConsumption', 
				'$BudgetedPcs',
				'$FabricRecieved',
				'$Percentage',
				'$BudgetedConsumption',
				'$ProductionPcs',
				'$CuttableQty',
				'$date',
				'$Mearchandiser', 
				'0',
				'$Percentage'
				);";
				
		$result = $db->RunQuery($SQL);
		echo $result;
		
}

if($id =='saveMarkerDetails')
{
				$count			= $_GET["count"];
				$Styleid 		= $_GET["Styleid"];
				$Fabric			= $_GET["Fabric"];
				$BuyerPoNo		= str_replace("***","#",$_GET["BuyerPoNo"]);
				$Color		= $_GET["Color"];
				$markerName		= $_GET["markerName"];
				$txtWidth		= $_GET["txtWidth"];
				$copy			= $_GET["copy"];
				$layer			= $_GET["layer"];
				$markerLengthYrd= $_GET["markerLengthYrd"];
				$markerLengthInc= $_GET["markerLengthInc"];
				$eff			= $_GET["eff"];
				$TotalYards		= $_GET["TotalYards"];

		/////////////////////////////////// find sub category no //////////////////////////////////////////
			$SQL1 = "SELECT  intSubCatID FROM matitemlist WHERE matitemlist.intItemSerial =  '$Fabric'";
			$result = $db->RunQuery($SQL1);
			while($row = mysql_fetch_array($result))
			{
					$intMatCategoryId = $row["intSubCatID"];
					break;
			}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		if($count==1)
		{
		/////////////////////////////////// check and delete allready exist data ///////////////////////////
		$SQL1 = "DELETE FROM cadconsumptionmarkerdetails where intStyleId='$Styleid' AND intMatCategoryId='$intMatCategoryId' AND intMatdetailId='$Fabric' AND strColor='$Color' ";
		$result = $db->RunQuery($SQL1);
		//echo $SQL1;
		////////////////////////////////////////////////////////////////////////////////////////////////////
		}
	$SQL = "insert into cadconsumptionmarkerdetails 
			(intStyleId, 
			intMatCategoryId, 
			intMatdetailId, 
			strColor, 
			strMarkerName, 
			dblCopy, 
			dblLayers, 
			dblMarKerLengthYrd, 
			dblMarKerLengthInch, 
			dblEFF, 
			intMarkerId, 
			dblWidth,
			dblTotalYrd
			)
			values
			('$Styleid', 
			'$intMatCategoryId', 
			'$Fabric', 
			'$Color', 
			'$markerName', 
			'$copy', 
			'$layer', 
			'$markerLengthYrd', 
			'$markerLengthInc', 
			'$eff', 
			'0', 
			'$txtWidth',
			'$TotalYards'
			);";
		$result = $db->RunQuery($SQL);
		echo $result;
}

if($id =='saveSizeDetails')
{
	$count				= $_GET["count"];
	$strStyleId			= $_GET["strStyleId"];
	$intMatdetailId		= $_GET["intMatdetailId"];
	$strColor			= $_GET["strColor"];
	$strMarkerName		= $_GET["strMarkerName"];
	$strSize			= $_GET["strSize"];
	$dblQty				= $_GET["dblQty"];
	$dblLayers			= $_GET["dblLayers"];
	$dblWidth			= $_GET["dblWidth"];
	$dblTotalQty		= $dblQty *$dblLayers;

		/////////////////////////////////// Find Sub Category No ///////////////////////////////////////////
		$SQL1 = "SELECT  intSubCatID FROM matitemlist WHERE matitemlist.intItemSerial =  '$intMatdetailId'";
		$result = $db->RunQuery($SQL1);
		while($row = mysql_fetch_array($result))
		{
			$intMatCategoryId = $row["intSubCatID"];
			break;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		if($count==1)
		{
		/////////////////////////////////// check and delete allready exist data ///////////////////////////
		$SQL1 = "DELETE FROM cadconsumptionsizedetails where intStyleId='$strStyleId' AND intMatCategoryId='$intMatCategoryId' AND intMatdetailId='$intMatdetailId' AND strColor='$strColor' ";
		$result = $db->RunQuery($SQL1);
		//echo $SQL1;
		////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		$SQL = "insert into cadconsumptionsizedetails 
				(intStyleId, 
				intMatCategoryId, 
				intMatdetailId, 
				strColor, 
				strMarkerName, 
				strSize, 
				dblQty, 
				dblTotalQty,
				dblPending,
				dblWidth
				)
				values
				('$strStyleId', 
				'$intMatCategoryId', 
				'$intMatdetailId', 
				'$strColor', 
				'$strMarkerName', 
				'$strSize', 
				'$dblQty', 
				$dblTotalQty, 
				$dblTotalQty, 
				'$dblWidth'
				);";
		$result = $db->RunQuery($SQL);
		echo $result;
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
