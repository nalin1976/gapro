<?php
include('../../Connector.php');	
	$type=trim($_GET["type"]);
	
		 
if($type=="save")
{
    $operationId=trim($_GET["operationId"]); 
	$operationCode=trim($_GET["operationCode"]);
	$intComponent=trim($_GET["cboComponent"]);
	$strOperation=trim($_GET["txtOperation"]);
	$intMachineType=trim($_GET["cboOperationMode"]);
	$intMachineTypeId=trim($_GET["cboMachineType"]);
	$dblSMV=trim($_GET["txtSMV"]);	
	$dblTMU=trim($_GET["txtTMU"]);			
	$intStatus=trim($_GET["intStatus"]);

	if($operationId =='')
	{
	$nextno = getNextNo();		 
	 $sql_insert="INSERT INTO ws_operations(strOpCode,strOperation,intMachineType,intComponent,intMachineTypeId,dblSMV,dblTMU,intStatus)
					VALUES
					('$operationCode',	 
					'$strOperation',	
					'$intMachineType',
					'$intComponent',
					'$intMachineTypeId',
					'$dblSMV',
					'$dblTMU',
					'$intStatus');"; 
	$db->ExecuteQuery($sql_insert);
 
   echo "Saved successfully.";  
   }  

   else
   {		
   $SQL_Update="UPDATE ws_operations SET  
   									   strOpCode='$operationCode',
                                       strOperation='$strOperation',
									   intMachineType='$intMachineType',
									   intComponent='$intComponent',
									   intMachineTypeId='$intMachineTypeId',
									   dblSMV='$dblSMV',
									   dblTMU='$dblTMU',
								 	   intStatus='$intStatus'
						               WHERE intOpID='$operationId'";
	$db->ExecuteQuery($SQL_Update);
	
	echo "Updated successfully.";	
	}	
}


else if($type=="delete")
{	
 	
    $operationId=trim($_GET["operationId"]);  
	$SQL="DELETE FROM ws_operations WHERE intOpID='$operationId'";
	$db->ExecuteQuery($SQL);
	
	echo "Deleted successfully.";
 }
 
function getNextNo()
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 
	
		$strSQL="SELECT  intOBSSerial FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		while($obsrec = mysql_fetch_array($result))
		{
			$no = $obsrec['intOBSSerial'];
		}
		$strSQL="UPDATE syscontrol SET intOBSSerial= intOBSSerial+1 WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
	
		return $no;
}
?>