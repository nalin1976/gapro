<?php
session_start();

class washReceiveSummary{
	private $po = '';
	private $color='';
	private $factory = '';
	private $fFac='';	
	private $GP='';
	private $style='';
	private $dfrom ='';
	private $dto='';
	private $fFactory='';
	
	public function getMainDetails($factory,$chk,$po,$style,$dfrom,$dto,$fFactory){
		$this->factory =$factory;
		$this->fFactory =$fFactory;
		$this->po =$po;
		$this->style =$style;
		$this->dfrom =$dfrom;
		$this->dto =$dto;
		
		global $db;
	$SQL="SELECT
		concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo) AS GPNO,		
		orders.strOrderNo,
		orders.strStyle,
		orders.strDescription,
		orders.intQty,
		productionfinishedgoodsreceiveheader.dblTotQty,
		orders.intStatus,
		productionfinishedgoodsreceivedetails.strColor,
		Sum(productionfinishedgoodsreceivedetails.lngRecQty) AS CQty,
		orders.intStyleId
		FROM
		productionfinishedgoodsreceiveheader
		INNER JOIN orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
		INNER JOIN productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
		WHERE orders.intStatus = '11' " ;
		if($chk==1){
			if($po!='')
				$SQL.= " AND orders.intStyleId='$po' ";
			if($style!='')
				$SQL.= " AND orders.strStyle='$style' ";
			if($dfrom != '')
				$SQL.= " AND  date(productionfinishedgoodsreceiveheader.dtmTransInDate) >= '$dfrom' ";
			if($dto != '')
				$SQL.= " AND  date(productionfinishedgoodsreceiveheader.dtmTransInDate) <= '$dto' ";
			if($fFactory!='')
				$SQL.= " AND  productionfinishedgoodsreceiveheader.strFComCode = '$fFactory' ";
		}
		$SQL.= " AND productionfinishedgoodsreceiveheader.strTComCode = '$factory' 		
		GROUP BY
		orders.strOrderNo,
		orders.strStyle,
		productionfinishedgoodsreceivedetails.strColor;";
		//echo $SQL;
		return $db->RunQuery($SQL);
		
	}
	
	public function getGPQtyAndToBRcvd($factory,$GP,$po){
		$this->factory = $factory;
		$this->GP	   = $GP;
		$this->po	   = $po;
		global $db;
		$SQL="SELECT
				productionfggpheader.intStyleId,
				sum(productionfggpheader.dblTotQty) AS dblTotQty
				FROM
				productionfggpheader
				WHERE
				productionfggpheader.strToFactory = '$factory' AND
				-- concat(productionfggpheader.intGPYear,'/',productionfggpheader.intGPnumber) = '$GP' AND
				productionfggpheader.intStyleId='$po';";
				
		$res=$db->RunQuery($SQL);
		$row=mysql_fetch_assoc($res);
		return $row['dblTotQty'];
	}
	
	public function getPoNumbers($factory){
		$this->factory = $factory;
		global $db;
		$SQL="SELECT DISTINCT
				o.intStyleId,
				o.strOrderNo,
				o.strStyle
				FROM
				orders AS o
				INNER JOIN productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.intStyleNo = o.intStyleId
				WHERE
				productionfinishedgoodsreceiveheader.strTComCode = '$factory'
				order by o.strOrderNo ASC;";			
		return $db->RunQuery($SQL);
		
	}
	public function getFromFactories($factory,$fFactory){
		$this->factory = $factory;
		$this->fFactory = $fFactory;
		global $db;
		$SQL="SELECT DISTINCT
				ph.strFromFactory,
				companies.intCompanyID,
				companies.strName
				FROM
				productionfggpheader AS ph
				INNER JOIN companies ON ph.strFromFactory = companies.intCompanyID
				WHERE
				ph.strToFactory = '$factory' 
				order by companies.strName;";		

		return $db->RunQuery($SQL);
		
	}
	
	public function getPo($style){
		global $db;
		$this->style =$style;
		$SQL="select o.intStyleId from orders o where o.strStyle='$style';";
		return $db->RunQuery($SQL);
	}
	
	public function getStyle($po){
		global $db;
		$this->po =$po;
		$SQL="select o.strStyle from orders o where o.intStyleId='$po';";	
		return $db->RunQuery($SQL);
	}
}
?>