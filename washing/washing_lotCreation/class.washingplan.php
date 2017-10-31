<?php
//include('../washingCommonScript.php')extends wasCommonScripts 

class washingplan 
{

private $po = '';
private $color='';
private $factory = '';
private $fFac='';
private $style='';
private $costID='';

	public function getOrderQty($po){
		$this->po = $po;
		global $db;
		$sql = " select intQty from orders where intStyleId='$po';";
		$res=$db->RunQuery($sql);		
		$row=mysql_fetch_array($res);
		return $row['intQty'];
	}
	public function getOrderNumbers($factory){
	  $this->factory = $factory;
	  global $db;
	  $sql="select distinct o.intStyleId,o.strOrderNo,o.strStyle
			FROM
			was_stocktransactions AS ws
			INNER JOIN orders AS o ON o.intStyleId = ws.intStyleId
			INNER JOIN was_actualcostheader ON ws.intStyleId = was_actualcostheader.intStyleId 
			where ws.intCompanyId='$factory' and o.intStatus='11';";
		//echo $sql;
	   return $db->RunQuery($sql);
	 }
	
	public function getStyles($factory){
	  $this->factory = $factory;
	  global $db;
	  $sql="select distinct o.intStyleId,o.strOrderNo,o.strStyle
			from was_stocktransactions ws 
			inner join orders o on o.intStyleId=ws.intStyleId 
			where ws.intCompanyId='$factory' and o.intStatus='11';";
		
	   return $db->RunQuery($sql);
	 }
	 
	public function getPo($style){
		global $db;
		$this->style =$style;
		$SQL="select o.intStyleId,o.intQty from orders o where o.strStyle='$style';";
		return $db->RunQuery($SQL);
	}
	
	public function getStyle($po){
		global $db;
		$this->po =$po;
		$SQL="select o.strStyle,o.intQty from orders o where o.intStyleId='$po';";	
		return $db->RunQuery($SQL);
	}
	
	public function getColor($po){
		global $db;
		$this->po =$po;
		$SQL="select distinct pbh.strColor from productionbundleheader pbh where pbh.intStyleId='$po';";	
		return $db->RunQuery($SQL);
	}
	
	public function getRCVDQty($po,$color,$factory){
		global $db;
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		
		$SQL="select sum(wst.dblQty) as RCVDQty from was_stocktransactions wst where wst.intStyleId='$po' AND wst.strColor='$color' AND wst.intCompanyId='$factory' AND wst.strType='FTransIn';";	
		return $db->RunQuery($SQL);
			
	}
	
	public function getMachineTypes(){
		global $db;
		$SQL="select wm.intMachineId,wm.strMachineType from was_machinetype wm where wm.intStatus='1' order by wm.strMachineType ASC;";	
		return $db->RunQuery($SQL);
	}
	public function getMachines($costID){
		global $db;
		$SQL="SELECT
				was_machine.strMachineName,
				was_machine.intMachineType,was_machine.intMachineId
				FROM
				was_machine
				Inner Join was_actualcostheader ON was_actualcostheader.intMachineType = was_machine.intMachineType
				WHERE
				concat( was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo)='$costID';";	
		return $db->RunQuery($SQL);
	}
	
	public function getMachineCapacity($mId){
		global $db;
		$SQL="SELECT m.intCapacity FROM was_machine AS m WHERE m.intMachineId = '$mId' ;";	
		return $db->RunQuery($SQL);
	}
	public function getCostings($po){
		global $db;
		$this->po = $po;
		  $SQL="SELECT
				concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo) AS COSTID,			
				was_machine.strMachineName,
				was_machine.intCapacity,
				was_actualcostheader.dblHTime
				FROM
				was_actualcostheader
				INNER JOIN was_machine ON was_actualcostheader.intMachineType = was_machine.intMachineType
				WHERE
				was_actualcostheader.intStyleId = '$po';";	
		return $db->RunQuery($SQL);
	}
	public function getTotTime($costID){
		global $db;
		$this->costID = $costID;
		  $SQL="SELECT 
				round(((was_actualcostheader.dblHTime+Sum(was_actualcostdetails.dblTime))/was_actualcostheader.dblQty),3) as HT
				FROM
				was_actualcostheader
				INNER JOIN was_actualcostdetails ON was_actualcostdetails.intSerialNo = was_actualcostheader.intSerialNo AND was_actualcostheader.intYear = was_actualcostdetails.intYear
				WHERE
				concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo) = '$costID' 
				GROUP BY
				was_actualcostheader.dblHTime;";	
		$row=mysql_fetch_assoc($db->RunQuery($SQL));
		return $row['HT'];
	}
	
	public function getCostIDs($po){
		global $db;
		$this->po = $po;
		  $SQL="SELECT
				concat(was_actualcostheader.intSerialNo,'/',was_actualcostheader.intYear,'/',WM.strMachineCode) AS COSTID,
				concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo) AS costIdValue	
				FROM
				was_actualcostheader
				inner join was_machinetype WM ON WM.intMachineId=was_actualcostheader.intMachineType
				WHERE
				was_actualcostheader.intStyleId = '$po';";	
		return $db->RunQuery($SQL);
	}
	public function getQty($costID)
	{
		global $db;
		$this->costID = $costID;
		  $SQL="SELECT was_actualcostheader.dblQty				
				FROM was_actualcostheader
				where concat( was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo)='$costID'";	
		$row=mysql_fetch_assoc($db->RunQuery($SQL));
		return $row['dblQty'];
	}
	public function getWMachineCapacity($costID){
		global $db;
		$this->costID = $costID;
		  $SQL="SELECT DISTINCT
				was_machine.intCapacity
				FROM
				was_actualcostheader
				INNER JOIN was_machinetype ON was_actualcostheader.intMachineType = was_machinetype.intMachineId
				INNER JOIN was_machine ON was_machinetype.intMachineId = was_machine.intMachineId
				WHERE
				concat(was_actualcostheader.intYear,'/',was_actualcostheader.intSerialNo)='$costID';";	
		return $db->RunQuery($SQL);
	}
}
?>