<?php
class glcode 
{

	private $GLAllowId = '';
	
	public function getGLCode($GLAllowId)
	{
		$this->GLAllowId = $GLAllowId;
		global $db;
		$sql = "select concat(GAC.strAccID,'-',C.strCode) as GLCode
				from glallowcation GLA
				inner join glaccounts GAC on GLA.GLAccNo=GAC.intGLAccID
				inner join costcenters C on C.intCostCenterId=GLA.FactoryCode
				where GLA.GLAccAllowNo='$GLAllowId'";
		$res=$db->RunQuery($sql);		
		$row=mysql_fetch_array($res);
		return $row['GLCode'];
	}
	public function getGLDescription($GLAllowId)
	{
		$this->GLAllowId = $GLAllowId;
		global $db;
		$sql = "select GAC.strDescription
				from glallowcation GLA
				inner join glaccounts GAC on GLA.GLAccNo=GAC.intGLAccID
				inner join costcenters C on C.intCostCenterId=GLA.FactoryCode
				where GLA.GLAccAllowNo='$GLAllowId'";
		$res=$db->RunQuery($sql);		
		$row=mysql_fetch_array($res);
		return $row['strDescription'];
	}
}
?>