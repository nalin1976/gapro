<?php
session_start();
//$pub_intCompany = $_SESSION["FactoryID"];
include "../Connector.php";

$id=$_GET["id"];


if($id=="savePackingListHeader")
{
		$intPackingListNo		= 	$_GET["intPackingListNo"];
		$strStyleId				= 	$_GET["strStyleId"];
		$intNoOfCartons			= 	(int)$_GET["intNoOfCartons"];
		$dblCtnMeasurements		= 	(float)$_GET["dblCtnMeasurements"];
		$strBuyerPoNo			= 	$_GET["strBuyerPoNo"];
		$strPrePack				= 	$_GET["strPrePack"];
		$dblQuantity			= 	(float)$_GET["dblQuantity"];
		$dblGrossMass			= 	(float)$_GET["dblGrossMass"];
		$dblNetMass				= 	(float)$_GET["dblNetMass"];
		$dblCbm					= 	(float)$_GET["dblCbm"];
		$strProCode				= 	$_GET["strProCode"];
		$strComCode				= 	$_GET["strComCode"];
		$strFabric				= 	$_GET["strFabric"];
		$strLineNo				= 	$_GET["strLineNo"];
		$intHanger				= 	(int)$_GET["intHanger"];
		$intPriceTicket			= 	(int)$_GET["intPriceTicket"];
		$intPriceSticker		= 	(int)$_GET["intPriceSticker"];
		$intLegSticker			= 	(int)$_GET["intLegSticker"];
		$intPoFlasher			= 	(int)$_GET["intPoFlasher"];
		$intBelt				= 	(int)$_GET["intBelt"];
		$intHangerTag			= 	(int)$_GET["intHangerTag"];
		$intJockerTag			= 	(int)$_GET["intJockerTag"];
		$strPackingType			= 	$_GET["strPackingType"];
		$intCompany				= 	(int)$_GET["intCompany"];
		
		$db->OpenConnection();
		$db->open('BEGIN');
		if($intPackingListNo=='')
		{
			$intPackingListNo = getNextPackingListNo();
		}	  	  
	$db->open("delete from packinglistheader where intPackingListNo=$intPackingListNo");
	$db->open("delete from packinglistcartons_size where intPackingListNo=$intPackingListNo");
	$db->open("delete from packinglistcartons where intPackingListNo=$intPackingListNo");
	
	$sql = "
insert into packinglistheader 
	(intPackingListNo, 
	intStyleId, 
	intNoOfCartons, 
	dblCtnMeasurements, 
	strBuyerPoNo, 
	strPrePack, 
	dblQuantity, 
	dblGrossMass, 
	dblNetMass, 
	dblCbm, 
	strProCode, 
	strComCode, 
	strFabric, 
	strLineNo, 
	intHanger, 
	intPriceTicket, 
	intPriceSticker, 
	intLegSticker, 
	intPoFlasher, 
	intBelt, 
	intHangerTag, 
	intJockerTag, 
	strPackingType, 
	strUnitType, 
	intCompany, 
	dtDate
	)
	values
	('$intPackingListNo', 
	'$strStyleId', 
	'$intNoOfCartons', 
	'$dblCtnMeasurements', 
	'$strBuyerPoNo', 
	'$strPrePack', 
	'$dblQuantity', 
	'$dblGrossMass', 
	'$dblNetMass', 
	'$dblCbm', 
	'$strProCode', 
	'$strComCode', 
	'$strFabric', 
	'$strLineNo', 
	'$intHanger', 
	'$intPriceTicket', 
	'$intPriceSticker', 
	'$intLegSticker', 
	'$intPoFlasher', 
	'$intBelt', 
	'$intHangerTag', 
	'$intJockerTag', 
	'$strPackingType', 
	'$strUnitType', 
	'$intCompany', 
	NOW()
	)
	";
	//echo $sql;
	$result = $db->open($sql);
	if($result)
	{
		echo $intPackingListNo;
		$db->commit();
	}
	else
	{
		echo 'error';
		$db->rollback();
	}
}

if($id	==	'savepackingListDetails')
{
	
	$intPackingListNo	=	$_GET["intPackingListNo"];
	$intColorIndex	=	$_GET["intColorIndex"];
	$strBuyerPoNo	=	$_GET["strBuyerPoNo"];
	$strSh			=	$_GET["strSh"];
	$strLength		=	$_GET["strLength"];	
	$strSticker		=	$_GET["strSticker"];
	$strContainer	=	$_GET["strContainer"];
	$intFromCtn		=	$_GET["intFromCtn"];
	$intToCtn		=	$_GET["intToCtn"];
	$strColor		=	$_GET["strColor"];
	$dblPscCtn		=	$_GET["dblPscCtn"];
	$dblTotal		=	$_GET["dblTotal"];
	$dblGrossWgt	=	$_GET["dblGrossWgt"];
	$dblNetWgt		=	$_GET["dblNetWgt"];
	$dblNetNetWgt	=	$_GET["dblNetNetWgt"];
	$intCompany		=	$_GET["intCompany"];
	
	
	
	$sql = "insert into packinglistcartons 
	(intPackingListNo, 
	intColorIndex, 
	strBuyerPoNo, 
	strSh, 
	strLength, 
	strSticker, 
	strContainer, 
	intFromCtn, 
	intToCtn, 
	strColor, 
	dblPscCtn, 
	dblTotal, 
	dblGrossWgt, 
	dblNetWgt, 
	dblNetNetWgt, 
	intCompany
	)
	values
	('$intPackingListNo', 
	'$intColorIndex', 
	'$strBuyerPoNo', 
	'$strSh', 
	'$strLength', 
	'$strSticker', 
	'$strContainer', 
	'$intFromCtn', 
	'$intToCtn', 
	'$strColor', 
	'$dblPscCtn', 
	'$dblTotal', 
	'$dblGrossWgt', 
	'$dblNetWgt', 
	'$dblNetNetWgt', 
	'$intCompany'
	)
	";
	$result = $db->open($sql);
	if($result)
		echo 'true';
	else
		echo $sql;
}

if($id=='saveSizeDetails')
{
	$sSize 				= 	$_GET["sSize"];
	$sValue 			= 	$_GET["sValue"];
	$intPackingListNo	=	$_GET["intPackingListNo"];
	$intColorIndex		=	$_GET["intColorIndex"];
	$intCompany			=	$_GET["intCompany"];
	
	$arrSize = explode(',',$sSize);
	$arrValue = explode(',',$sValue);
	
	
	for($i=0;$i<count($arrSize);$i++)
	{
		
		$strSize = $arrSize[$i];
		$dblQty = $arrValue[$i];
		if($strSize!='')
		{
		$sql = "insert into packinglistcartons_size 
				(intPackingListNo, 
				intColorIndex, 
				strSize, 
				dblQty, 
				intCompany
				)
				values
				('$intPackingListNo', 
				'$intColorIndex', 
				'$strSize', 
				'$dblQty', 
				'$intCompany'
				)
				";
		$result = $db->open($sql);
		}
	}
		if($result)
			echo 'Cartons sizes saved ';
		else
			echo 'Not Saved';
	
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getNextPackingListNo()
{
	global $db;
	$sql = "update syscontrol set dblPackingListNo=dblPackingListNo+1 where intCompanyID= '".$_SESSION["FactoryID"]."'";
	$result = $db->open($sql);
	$sql = "select dblPackingListNo from syscontrol where intCompanyID= '".$_SESSION["FactoryID"]."'";
	$result = $db->open($sql);
	while ($row=mysql_fetch_array($result))
		$no = (int)$row["dblPackingListNo"];
		
	return $no;
}

if($id=="rollback")
{
	$result = $db->open('ROLLBACK');
	//$db->CloseConnection();
}

if($id=="commit")
{
	$result = $db->open('COMMIT');
	//$db->CloseConnection();
}


?>