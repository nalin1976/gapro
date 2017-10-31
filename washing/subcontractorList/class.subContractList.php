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
		CONCAT(was_subcontractout.intAODYear,'/',was_subcontractout.intAODNo) AS AOD,
		orders.strOrderNo,
		orders.strStyle,
		orders.strDescription,
		was_subcontractout.strColor,
		orders.intQty,
		was_subcontractout.dblQty,
		was_stocktransactions.strType
		FROM
		was_subcontractout
		INNER JOIN orders ON orders.intStyleId = was_subcontractout.intStyleId
		INNER JOIN was_stocktransactions ON was_subcontractout.intStyleId = was_stocktransactions.intStyleId AND was_subcontractout.intAODNo = was_stocktransactions.intDocumentNo AND was_subcontractout.intAODYear = was_stocktransactions.intDocumentYear
		WHERE orders.intStatus = '11' " ;
		if($chk==1){
			if($po!='')
				$SQL.= " AND orders.intStyleId='$po' ";
			if($style!='')
				$SQL.= " AND orders.strStyle='$style' ";
			if($dfrom != '')
				$SQL.= " AND  date(was_subcontractout.dtmDate) >= '$dfrom' ";
			if($dto != '')
				$SQL.= " AND  date(was_subcontractout.dtmDate) <= '$dto' ";
			if($fFactory!='')
				$SQL.= " AND  was_subcontractout.intSubContractNo = '$fFactory' ";
		}
		$SQL.= " AND was_stocktransactions.strType='SubOut' AND
		was_stocktransactions.intCompanyId = '$factory' order by AOD;";
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
				was_subcontractout
				INNER JOIN orders ON was_subcontractout.intStyleId = orders.intStyleId
				ORDER BY
				orders.strOrderNo ASC;";			
		return $db->RunQuery($SQL);
		
	}
	public function getFromFactories(){
		global $db;
		$SQL="SELECT distinct
			was_outside_companies.intCompanyID,
			was_outside_companies.strName
			FROM
			was_subcontractout
			INNER JOIN was_outside_companies ON was_subcontractout.intSubContractNo = was_outside_companies.intCompanyID
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