<?php
session_start();

class wip{
	
private $po		='';
private $factory='';
private $color	='';
private $company='';
private $dt		='';

	public function getMainDetals($company,$dt){
		global $db;
		$company=$this->company=$company;
		$dt=$this->dt=$dt;
		
		$sql="SELECT
			o.strOrderNo,
			o.intStyleId,
			o.strStyle,
			was_stocktransactions.strColor,
			o.intQty,
			c.strName,
			c.intCompanyID,
			was_stocktransactions.intFromFactory,
			buyerdivisions.strDivision
			FROM
			was_stocktransactions
			INNER JOIN orders AS o ON was_stocktransactions.intStyleId = o.intStyleId
			INNER JOIN companies AS c ON c.intCompanyID = was_stocktransactions.intFromFactory
			INNER JOIN orderdetails AS od ON o.intStyleId = od.intStyleId
			LEFT JOIN buyerdivisions ON o.intDivisionId = buyerdivisions.intDivisionId
		WHERE
		was_stocktransactions.intCompanyId = '$company' 
		AND was_stocktransactions.dtmDate <='$dt'
		GROUP BY
		was_stocktransactions.strColor,
		was_stocktransactions.intStyleId
		ORDER BY
		was_stocktransactions.intFromFactory ASC;";
		//echo $sql;
		return $db->RunQuery($sql);
	}

	public function getCutQty($po){
		global $db;
		$this->po=$po;
		$sql="select sum(pbh.dblTotalQty) AS CQty from productionbundleheader pbh
							where pbh.intStyleId='$po' 
							group by pbh.strColor,pbh.intStyleId";
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_assoc($res);
		return $row['CQty'];
	}
	public function getMill($po){
		global $db;
		$this->po=$po;
		$sql="SELECT
				suppliers.strTitle
				FROM
				orders
				INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId
				INNER JOIN suppliers ON orderdetails.intMillId = suppliers.strSupplierID
				WHERE
				orderdetails.intMainFabricStatus = 1 AND
				orders.intStyleId='$po';";
		$res=$db->RunQuery($sql);
		$row=mysql_fetch_assoc($res);
		return $row['strTitle'];
	}
	
	public function getTotRcvd($po,$fac,$dt){
		global $db;
		$this->po=$po;
		$sql="SELECT
			Sum(was_stocktransactions.dblQty) as QTY
			FROM
			was_stocktransactions
			WHERE
			was_stocktransactions.intCompanyId = '$fac' AND
			was_stocktransactions.intStyleId = '$po' AND
			was_stocktransactions.dtmDate <= '$dt'
			GROUP BY
			was_stocktransactions.intStyleId,
			was_stocktransactions.strColor;";
					$res=$db->RunQuery($sql);
		$row=mysql_fetch_assoc($res);
		return $row['QTY'];
	}
	
	



}
?>