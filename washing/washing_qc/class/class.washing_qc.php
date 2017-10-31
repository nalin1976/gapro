<?
class classWashingQC{
	private $po;
	private $empNo;
	private $epfNo;
	private $shift;
	private $factory;
	
	public function getPoNo($factory){
		global $db;
		$factory=$this->factory;
		$sql="SELECT orders.intStyleId,orders.strOrderNo FROM was_stocktransactions INNER JOIN orders ON orders.intStyleId = was_stocktransactions.intStyleId
WHERE was_stocktransactions.intCompanyId='$factory' order by order.strOrderNo;";
	
		$res=$db->RunQuery($sql);
		return $res;
	}
	
	public function getLineRecoder($factory){
		global $db;
		$factory=$this->factory;
		$sqlL="SELECT was_operators.intOperatorId,was_operators.strName from was_operators WHERE was_operators.intStatus = '1' 
			   AND was_operators.intSection = '1';";
		  $resL=$db->RunQuery($sqlL);
		  return $resL;
		}	
	
}
?>