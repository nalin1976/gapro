<?php
//include('../Connector.php');

class wasCommonScripts
{

private $po = '';
private $color='';
private $factory = '';
private $fFac='';

public function getOrderQty($po){
	$this->po = $po;
	global $db;
	$sql = " select intQty from orders where intStyleId='$po';";
	$res=$db->RunQuery($sql);		
	$row=mysql_fetch_array($res);
	return $row['intQty'];
}

public function gpQtyForMrn($po,$color,$factory){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac	=	$fFac;
		
		global $db;//s.strMainStoresID =  '1' AND AND   
		$sql="SELECT
				Sum(pbh.dblTotalQty) AS Qty
				from productionbundleheader pbh
				WHERE
				pbh.intStyleId = '$po' AND
				pbh.strColor ='$color'
				group by pbh.strColor,pbh.intStyleId";
		//echo $sql;//strType='FTransIn' AND 
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_array($res);
		return $row['Qty'];
}

public function GetAvailableQty($po,$color,$factory,$fFac)
{
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac	=	$fFac;
global $db;
$qty = 0;
	$sql="select COALESCE(sum(dblQty),0) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color' and intCompanyId='$factory' and intFromFactory='$fFac' AND strMainStoresID=1 group by intStyleId,strColor;";
	//echo $sql;
	$result=$db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$qty = $row['RCVDQty'];
	}
return $qty;
}

public function GetAvailableQtyForGP($po,$color,$factory,$fFac)
{
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac	=	$fFac;
global $db;
$qty = 0;//AND strMainStoresID=1 
	$sql="select COALESCE(sum(dblQty),0) as RCVDQty from was_stocktransactions where intStyleId='$po' and strColor='$color' and intCompanyId='$factory' and intFromFactory='$fFac' group by intStyleId,strColor;";
	//echo $sql;
	$result=$db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$qty = $row['RCVDQty'];
	}
return $qty;
}

public function gpQtyForIssued($po,$color,$factory,$fFac){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac	=	$fFac;
		
		global $db;//s.strMainStoresID =  '1' AND AND   
		$sql="SELECT Sum(s.dblQty) AS Qty from was_stocktransactions s WHERE s.intStyleId =  '$po' AND s.strColor =  '$color' AND s.intCompanyId =  '$factory' AND strType='FTransIn' AND intFromFactory='$fFac'  GROUP BY s.strColor,s.intCompanyId,s.intStyleId;";
		//echo $sql;//
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_array($res);
		return $row['Qty'];
}
 	//to get totally gatepass Qty
public function gpQty($po,$color,$factory,$fFac){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac	=	$fFac;
		
		global $db;//s.strMainStoresID =  '1' AND AND   
		$sql="SELECT Sum(s.dblQty) AS Qty from was_stocktransactions s WHERE s.intStyleId =  '$po' AND s.strColor =  '$color' AND s.intCompanyId =  '$factory' AND intFromFactory='$fFac'  GROUP BY s.strColor,s.intCompanyId,s.intStyleId;";
		//echo $sql;//strType='FTransIn' AND 
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_array($res);
		return $row['Qty'];
}
	//to get  Balance Qty 
public function getSubContractorBalance($po,$color,$fFac){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		global $db;
		$sqlSO="SELECT Sum(so.dblQty) AS Qty FROM was_subcontractout AS so WHERE so.intStyleId =  '$po' AND so.strColor =  '$color' and so.intSFac='$fFac' GROUP BY so.strColor,so.intStyleId;";
		//echo $sqlSO;
		$sqlSI="SELECT Sum(si.dblQty) AS Qty FROM was_subcontractin AS si WHERE si.intStyleId =  '$po' AND si.strColor =  '$color' and si.intSFac='$fFac' GROUP BY si.intStyleId,si.strColor ;";
		//echo $sqlSI;
		$resSO=$db->RunQuery($sqlSO);
		$resSI=$db->RunQuery($sqlSI);
		$rowSO = mysql_fetch_array($resSO);
		$rowSI = mysql_fetch_array($resSI);
		$bal=$rowSO['Qty']-$rowSI['Qty'];
		return $bal; 
	}
	
public function getIssuedToOtherBalance($po,$color,$factory,$fFac){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		$this->fFac = $fFac;
		global $db;
		$sqlIO="SELECT Sum(IO.dblQty) AS Qty FROM was_issuedtootherfactory AS IO WHERE IO.strColor =  '$color' AND IO.intStyleId =  '$po' AND IO.intCompanyId =  '$factory'   AND IO.intSFactory='$fFac' GROUP BY IO.intStyleId,IO.strColor,IO.intCompanyId;";
		//echo $sqlIO;
		$sqlRO="SELECT Sum(RO.dblQty) AS Qty FROM was_rcvdfromfactory AS RO WHERE RO.intStyleId =  '$po' AND RO.strColor =  '$color' AND RO.intCompanyId =  '$factory' RO.intSewingFactory='$fFac' GROUP BY RO.intStyleId,RO.strColor;";
		
		$resIO=$db->RunQuery($sqlIO);
		$resRO=$db->RunQuery($sqlRO);
		$rowIO = mysql_fetch_array($resIO);
		$rowRO = mysql_fetch_array($resRO);
		return ($rowIO['Qty']-$rowRO['Qty']); 	
	}
	
public function getReturnToFactoryQty($po,$color){
	 	$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		global $db;
		$sqlRF="SELECT Sum(rfd.dblQty) AS Qty FROM was_returntofactoryheader AS rfh Inner Join was_returntofactorydetails AS rfd ON rfh.dblSerial = rfd.dblSerial AND rfh.intYear = rfd.intYear WHERE rfh.intStyleId =  '$po' AND rfh.strColor =  '$color' GROUP BY rfh.intStyleId,rfh.strColor;";
		$resRF=$db->RunQuery($sqlRF);
		$rowRF = mysql_fetch_array($resRF);
		return $rowRF['Qty']; 
	}
	
public function getMrnIssueQty($po,$color){
	 	$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		global $db;
		$sqlI="SELECT Sum(i.dblQty) AS Qty FROM was_issue AS i WHERE i.intStyleId =  '$po' AND i.strColor =  '$color' GROUP BY i.intStyleId,i.strColor;";
		$resI=$db->RunQuery($sqlI);
		$rowI=mysql_fetch_array($resI);
		return $rowI['Qty']; 
	}
	
public function getIssuedToWashQty($po,$color,$factory,$fFac){
		$this->po = $po;
		$this->color = $color;
		$this->factory = $factory;
		global $db;
		$sqlIW="SELECT Sum(iw.dblQty) AS Qty FROM was_issuedtowashheader AS iw WHERE iw.strColor =  '$color' AND iw.intStyleNo =  '$po' AND strFComCode='$fFac' AND intCompanyID='$factory' GROUP BY iw.intStyleNo,iw.strColor";
		$resIW=$db->RunQuery($sqlIW);
		$rowIW=mysql_fetch_array($resIW);
		return $rowIW['Qty']; 
	}
}
?>