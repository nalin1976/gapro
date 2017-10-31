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
	$SQL="SELECT CONCAT(subIn.intAODYear,'/',subIn.intAODNo) AS AOD, orders.strOrderNo, 
			orders.strStyle, orders.strDescription, 
			subIn.strColor, orders.intQty, subIn.dblQty, was_stocktransactions.strType ,subIn.strGatePassNo
			FROM was_subcontractin AS subIn 
			INNER JOIN orders ON orders.intStyleId = subIn.intStyleId 
			INNER JOIN was_stocktransactions ON subIn.intStyleId = was_stocktransactions.intStyleId 
			AND subIn.intAODNo = was_stocktransactions.intDocumentNo AND subIn.intAODYear = was_stocktransactions.intDocumentYear 
			WHERE orders.intStatus = '11'  " ;
		if($chk==1){
			if($po!='')
				$SQL.= " AND orders.intStyleId='$po' ";
			if($style!='')
				$SQL.= " AND orders.strStyle='$style' ";
			if($dfrom != '')
				$SQL.= " AND  date(subIn.dtmDate) >= '$dfrom' ";
			if($dto != '')
				$SQL.= " AND  date(subIn.dtmDate) <= '$dto' ";
			if($fFactory!='')
				$SQL.= " AND  subIn.intSubContractNo = '$fFactory' ";
		}
		$SQL.= "  AND was_stocktransactions.strType='SubIn' AND
		was_stocktransactions.intCompanyId = '$factory' order by AOD;";
		//echo $SQL;
		return $db->RunQuery($SQL);
		
	}
		
	public function getPoNumbers($factory){
		$this->factory = $factory;
		global $db;
		$SQL="SELECT
				orders.strOrderNo,
				orders.intStyleId,
				orders.strStyle
				FROM
				was_subcontractin
				INNER JOIN orders ON was_subcontractin.intStyleId = orders.intStyleId
				ORDER BY
				orders.strOrderNo ASC;";			
		return $db->RunQuery($SQL);
		
	}
	public function getFromFactories(){
		global $db;
		$SQL="SELECT
			was_outside_companies.intCompanyID,
			was_outside_companies.strName
			FROM
			was_subcontractin
			INNER JOIN was_outside_companies ON was_subcontractin.intSubContractNo = was_outside_companies.intCompanyID
			ORDER BY
			was_outside_companies.strName ASC;";		

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