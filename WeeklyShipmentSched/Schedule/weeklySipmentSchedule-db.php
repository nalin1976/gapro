<?php
session_start();
include "../../Connector.php";

$id=$_GET["id"];
//echo $id;

if($id=="checkExist"){
 $scheddate	= $_GET["scheddate"];
 

	$SQL1 = "SELECT * FROM weeklyshipmentschedule  WHERE intScheduleNo='$scheddate'";
	//echo $SQL1;
    $result1 = $db->RunQuery($SQL1);
	if(mysql_num_rows($result1)){
	echo "1";
	}else{
	echo "0";
	}
}

if($id=="deleteBeforeSaveWeekly"){

$intScheduleNo = $_GET["intScheduleNo"];
$styleID       = $_GET["styleID"];
$delDate       = $_GET["delDate"];
$etdDate       = $_GET["etdDate"];
$del ="DELETE FROM weeklyheader WHERE schedNoWithMonth='$intScheduleNo'";
$db->RunQuery($del);

$del_before_save ="DELETE FROM weeklyshipmentschedule 
                   WHERE intScheduleNo='$intScheduleNo' AND intStyleId='$styleID' AND deliveryDate='$delDate' AND etdDate='$etdDate'";
//echo $del_before_save;
$db->RunQuery($del_before_save);

$intSave = $db->RunQuery($del_before_save);
if ($intSave==1)
	echo "1";
else
	echo "Saving-Error";//"Saving-Error";
	
	$save_header = "INSERT INTO weeklyheader (schedNoWithMonth,intConfirm)VALUES('$intScheduleNo','0')";
	$db->RunQuery($save_header);
}


if($id=="confirmWeekly"){
  $status = '11';
  $intScheduleNo  = $_GET["intScheduleNo"];
	$update_confirm = "UPDATE weeklyheader SET intConfirm='$status' 
	                   WHERE schedNoWithMonth='$intScheduleNo'";
	$db->RunQuery($update_confirm);
	//echo $update_confirm;
}


if($id=="save"){

         $intScheduleNo  = $_GET["intScheduleNo"];
         $week   	     = $_GET["week"];
		 $etdDate	     = $_GET["etdDate"];
		 $deldate	     = $_GET["deldate"];			
		 $styleno		 = $_GET["styleno"];
		 $orderqty		 = $_GET["orderqty"];
		 $deliveryqty	 = $_GET["deliveryqty"];
		 $exportQty		 = $_GET["exportQty"];
		 $monQtySea		 = $_GET["monQtySea"];
		 $monQtyAir		 = $_GET["monQtyAir"];
		 $balQty	     = $_GET["balQty"];
		 $shipnowqtySea     = $_GET["shipnowqtySea"];
		 if($shipnowqtySea==""){
		  $shipnowqtySea=0;
		 }
		 
		 $shipnowqtyAir     = $_GET["shipnowqtyAir"];
		 if($shipnowqtyAir==""){
		  $shipnowqtyAir=0;
		 }
	     if(($monQtySea + $monQtyAir)==($shipnowqtySea + $shipnowqtyAir)){
		  $status = '1';
		 }else{
		  $status = '0';
		 }
		 $remark		 = $_GET["remark"];
		 $washCode		 = $_GET["washCode"];
		 $length		 = $_GET["length"];
		 $width			 = $_GET["width"];
		 $hiegth		 = $_GET["hiegth"];
		 $pPerPack		 = $_GET["pPerPack"];
		 $dimention		 = $_GET["dimention"];
		 $mode			 = $_GET["mode"];
		 $vessel		 = $_GET["vessel"];
		 $vesselDate	 = $_GET["vesselDate"];
		 $destination	 = $_GET["destination"];
		 
		 $qtyCtn     = $_GET["qtyCtn"];
		 if($qtyCtn==""){
		  $qtyCtn=0;
		 }

		 
		    $user= $_SESSION["UserID"];
			$SQL="SELECT * FROM useraccounts WHERE intUserID='$user'";
			$result =$db->RunQuery($SQL);
			$rowU=mysql_fetch_array($result);
			$userName= $rowU["Name"];      
		    $schedNo =  dtoy($scheddate,$userName); 
		 

//echo $del_before_save;
	$SQL="insert into weeklyshipmentschedule 
		(intScheduleNo,
		strWeek,
		etdDate,
		deliveryDate, 
		intStyleId, 
		dblOrderQty, 
		dblDeliveryQty, 
		dblExportQty,
		dblMonQtySea,
		dblMonQtyAir,
		dblBalanceQty,
		dblShipNowQuantitySea,
		dblShipNowQuantityAir,
		dblQtyCtn,
		intDestID,
		strRemarks,
		strWashCode,
		dblLength,
		dblWidth,
		dblHeight,
		dblPcsPerPack,
		dblDimension,
		intMode,
		strvessel,
		dtmVesddt,
		intStatus
		)
		values
		(
		'$intScheduleNo',
		'$week', 
		'$etdDate',
		'$deldate', 
		'$styleno', 
		'$orderqty', 
		'$deliveryqty', 
		'$exportQty',
		'$monQtySea',
		'$monQtyAir', 
		'$balQty', 
		'$shipnowqtySea',
		'$shipnowqtyAir', 
		'$qtyCtn',
		'$destination',
		'$remark',
		'$washCode', 
		'$length',
		'$width',
		'$hiegth',
		'$pPerPack',	  		
        '$dimention',		  		
        '$mode',			      		
        '$vessel',		     		
        '$vesselDate',
		'$status'	  		 					
		)";
        //echo $SQL;
		$intSave = $db->RunQuery($SQL);
		if ($intSave==1)
			echo "Saved Successfully";
		else
			echo "Saving-Error";//"Saving-Error";
}

//------------------------------------------------------------update---------------------------------------------------

if($id=="deleteBeforeUpdate"){
$scheddate	= $_GET["scheddate"];
$sql = "DELETE  FROM weeklyshipmentschedule WHERE intScheduleNo='$scheddate'";
		$intSave = $db->RunQuery($sql);
		if ($intSave==1)
			echo "1";
		else
			echo "deleting-Error";//"Saving-Error";
}

if($id=="update"){

         $week	         = $_GET["week"];
	     $intScheduleNo	 = $_GET["intScheduleNo"];
		 $deldate	     = $_GET["deldate"];			
		 $styleno		 = $_GET["styleno"];
		 $orderqty		 = $_GET["orderqty"];
		 $deliveryqty	 = $_GET["deliveryqty"];
		 $actualqty		 = $_GET["actualqty"];
		 $exportQty		 = $_GET["exportQty"];
		 $monQtySea		 = $_GET["monQtySea"];
		 $monQtyAir		 = $_GET["monQtyAir"];
		 $balQty	     = $_GET["balQty"];
		 $shipnowqtySea     = $_GET["shipnowqtySea"];
		 if($shipnowqtySea==""){
		  $shipnowqtySea=0;
		 }
		 $shipnowqtyAir     = $_GET["shipnowqtyAir"];
		 if($shipnowqtyAir==""){
		  $shipnowqtyAir=0;
		 }
		 $ctn		     = $_GET["ctn"];
		 $color	         = $_GET["color"];
		 $remark		 = $_GET["remark"];
		 $perPackCode	 = $_GET["perPackCode"];
		 $washCode		 = $_GET["washCode"];
		 $isdNo			 = $_GET["isdNo"];
		 $doNo			 = $_GET["doNo"];
		 $dcNo			 = $_GET["dcNo"];
		 $length		 = $_GET["length"];
		 $width			 = $_GET["width"];
		 $hiegth		 = $_GET["hiegth"];
		 $pPerPack		 = $_GET["pPerPack"];
		 $CBM			 = $_GET["CBM"];
		 $labelComp		 = $_GET["labelComp"];
		 $warehouse		 = $_GET["warehouse"];
		 $dimention		 = $_GET["dimention"];
		 $mode			 = $_GET["mode"];
		 $vessel		 = $_GET["vessel"];
		 $vesselDate	 = $_GET["vesselDate"];
		 $scheduleDate	 = $_GET["scheduleDate"];
		 $material		 = $_GET["material"];
		 $exeRate		 = $_GET["exeRate"];
		 $ctnGroupNo	 = $_GET["ctnGroupNo"];
		 
		    $user= $_SESSION["UserID"];
			$SQL="SELECT * FROM useraccounts WHERE intUserID='$user'";
			$result =$db->RunQuery($SQL);
			$rowU=mysql_fetch_array($result);
			$userName= $rowU["Name"];      
		    $schedNo =  dtoy($scheddate,$userName); 
		 

	$SQL="insert into weeklyshipmentschedule 
		(intScheduleNo, 
		strWeek,
		deliveryDate, 
		intStyleId, 
		dblOrderQty, 
		dblDeliveryQty, 
		dblActualQty, 
		dblExportQty,
		dblMonQtySea,
		dblMonQtyAir,
		dblBalanceQty,
		dblShipNowQuantitySea,
		dblShipNowQuantityAir,
		strCtn,
		strColour,
		strRemarks,
		strPerPackCode,
		strWashCode,
		ISDNo,
		strDONo,
		strDCNo,
		dblLength,
		dblWidth,
		dblHeight,
		dblPcsPerPack,
		dblCBM,
		strLabelCompo,
		strWarehouse,
		dblDimension,
		intMode,
		strvessel,
		dtmVesddt,
		strSchedDate,
	    strItemID,
		dblExeRate,
		strCtnGroupNo	
		)
		values
		('$intScheduleNo', 
		'$week',
		'$deldate', 
		'$styleno', 
		'$orderqty', 
		'$deliveryqty', 
		'$actualqty', 
		'$exportQty',
		'$monQtySea',
		'$monQtyAir', 
		'$balQty', 
		'$shipnowqtySea',
		'$shipnowqtyAir', 
		'$ctn', 
		'$color',
		'$remark',
		'$perPackCode', 
		'$washCode', 
		'$isdNo',
		'$doNo',
		'$dcNo', 
		'$length',
		'$width',
		'$hiegth',
		'$pPerPack',
        '$CBM',			       
        '$labelComp',		  
        '$warehouse',		  		
        '$dimention',		  		
        '$mode',			      		
        '$vessel',		     		
        '$vesselDate',	  		
        '$scheduleDate',			
        '$material',		   		
        '$exeRate',		    		
        '$ctnGroupNo'	  					
		)";
        //echo $SQL;
		$intSave = $db->RunQuery($SQL);
		if ($intSave==1)
			echo "1";
		else
			echo "Saving-Error";//"Saving-Error";
}

if($id=="saveWeekAndRemarks"){
$intScheduleNo	= $_GET["intScheduleNo"];
$etdDate = $_GET["etdDate"];
$delDate = $_GET["delDate"];
$styleID = $_GET["styleID"];
$week	 = $_GET["week"];
$remarks = $_GET["remarks"];

$sql1 = "SELECT * FROM weeklyshipmentschedule 
         WHERE intScheduleNo='$intScheduleNo' AND etdDate='$etdDate' AND deliveryDate='$delDate' AND intStyleId='$styleID'";
$intSave1 = $db->RunQuery($sql1);
	if(mysql_num_rows($intSave1)){
 $sql2 = "UPDATE weeklyshipmentschedule SET strWeek='$week' , strRemarks='$remarks'
          WHERE intScheduleNo='$intScheduleNo' AND etdDate='$etdDate' AND deliveryDate='$delDate' AND intStyleId='$styleID'";
		$intSave2 = $db->RunQuery($sql2);
		//echo $sql2;
		if ($intSave2==1)
			echo "1";
		else
			echo "saving-Error";//"Saving-Error";
}else{
echo "2";
}
}


 
 
function dtoy($ddt,$userName)
{
if ($ddt) {
$vl=explode('/',$ddt);
$day = $vl[0];
$month = $vl[1];
$year = $vl[2];

return "$year/$month/$day/$userName";
}
else
{return ""; }
}
?>


