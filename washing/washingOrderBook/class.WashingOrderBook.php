<?php
class washingOrderBook{

private $poNo='';
private $costId='';
private $PT='';
	function getOritOrderNo($poNo){
		global $db;
		$this->poNo=$poNo;
		
	$sql="SELECT
		concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo) AS oritOrderNo,
		O.strOrderNo
		FROM
		orders AS O
		WHERE
		O.intStyleId='$poNo'
		order by O.strOrderNo;";
		
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_array($res);
		return $row['oritOrderNo'];
	
	}

	function getCostDetails(){
		global $db;
	  $sql="SELECT
			was_actualcostheader.intSerialNo,
			was_actualcostheader.intStyleId,
			concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo) AS COSTID,
			orders.strOrderNo,
			orders.strStyle,
			was_actualcostheader.strColor,
			matitemlist.strItemDescription,
			was_machinetype.dblOHCostMin,
			was_machinetype.dblUnitPrice,
			was_actualcostheader.dblHTime,
			was_actualcostheader.dblQty,
			orders.intQty,
			buyers.strName,
			was_actualcostheader.intCat
			FROM
			was_actualcostheader
			INNER JOIN orders ON orders.intStyleId = was_actualcostheader.intStyleId
			LEFT JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId
			INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
			INNER JOIN was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType
			INNER JOIN buyers ON buyers.intBuyerID = orders.intBuyerID
			WHERE
			orderdetails.intMainFabricStatus = 1 AND was_actualcostheader.intStatus = 1
			ORDER BY was_actualcostheader.intStyleId ASC;";
			//echo $sql;
			$res=$db->RunQuery($sql);
			return $res;
	
	}
	
	function getRunTime($costId){
		global $db;
		$this->costId=$costId;
		
	  $sql_RTime="SELECT SUM(dblTime) R_TIME FROM was_actualcostdetails 
	  			  WHERE concat(was_actualcostdetails.intYear,'/',was_actualcostdetails.intSerialNo)='$costId';";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  return $rowRT['R_TIME'];
	}
	function getLiqour($costId){
		global $db;
		$this->costId=$costId;
		
	  $sql_RTime="SELECT Sum(was_actualcostdetails.dblLiqour) AS LQTY FROM was_actualcostdetails 
	  			  WHERE concat(was_actualcostdetails.intYear,'/',was_actualcostdetails.intSerialNo)='$costId';";
	  $resRT=$db->RunQuery($sql_RTime);
	  $rowRT=mysql_fetch_array($resRT);
	  return $rowRT['LQTY'];
	}
	
	/*function getChemicalCost($costId){
		global $db;
		$this->costId=$costId;
		$SQL="SELECT
			sum(was_actcostchemicals.dblUnitPrice*was_actcostchemicals.dblQty) AS ChemCOST
			FROM
			was_actcostchemicals
			WHERE
			concat(was_actcostchemicals.intYear,'/',was_actcostchemicals.intSerialNo)='$costId';";	
		  $rescc=$db->RunQuery($SQL);
		  $rowcc=mysql_fetch_array($rescc);
		  return $rowcc['ChemCOST'];
	}*/
	function getChemicalCost($costId,$PT){
		global $db;
		$this->costId=$costId;
		$this->PT=$PT;
		$SQL="SELECT
				SUM(wc.dblQty*wc.dblUnitPrice) AS CCost
				FROM
				was_actcostchemicals AS wc
				INNER JOIN was_washformula AS wf ON wc.intProcessId = wf.intSerialNo
				WHERE
				concat(wc.intyear,'/',wc.intSerialNo) = '$costId' AND
				wf.intProcType = '$PT';";	
				//echo $SQL;
		  $rescc=$db->RunQuery($SQL);
		  $rowcc=mysql_fetch_array($rescc);
		  return $rowcc['CCost'];
	}
	
}
?>