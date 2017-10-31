<?php
	session_start();
	include "../../Connector.php";
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	//$db =new DBManager();
	$DBOprType = $_GET["DBOprType"]; 
	
	if (strcmp($DBOprType,"SaveNewGLAcc") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
		 $glAccNo = $_GET["AccNo"];
		 $glAccName = $_GET["AccName"];
		 $glAccType = $_GET["AccType"];
		 $intStatus = $_GET["intStatus"];
		 $AccID 	= $_GET["AccID"];
		 $accCat	= $_GET['cat'];
		 $GLcategory = $_GET["GLcategory"];
		// $glAccFactoryCode = $_GET["FactoryCode"];
		 
		 if(saveNewGLAcc($glAccNo,$glAccName,$glAccType,$intStatus,$AccID,$accCat,$GLcategory))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"SaveSupGLAllowcation") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
		 
		 $supID = $_GET["supID"];
		 $alloID = $_GET["alloID"];
		// $isFirst = $_GET["isFirst"];
		 
		 if(SaveSupGLAllowcation($supID,$alloID))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"GetAllowcatedSupGLAccs") == 0)
	{
		$supID = $_GET["supID"]; 
		$ResponseXML = "";
		$ResponseXML .= "<SupGLAccs>\n";
		$result=getAllowcatedSupGLAccs($supID);
		
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"].$row['strCode']. "]]></accNo>\n";
			$ResponseXML .= "<accName><![CDATA[" . $row["strDescription"]. "]]></accName>\n";
			$ResponseXML .= "<accID><![CDATA[" . $row["GLAccAllowNo"]. "]]></accID>\n";
		}
		$ResponseXML .= "</SupGLAccs>";
		echo $ResponseXML;		
	
	}
	
	
	
	else if (strcmp($DBOprType,"GetGLAccs") == 0)
	{
		$accNo = $_GET["glaccNo"]; 
		$accDescr = $_GET["glaccDcs"]; 
		//$accFactory = $_GET["glaccFactory"]; 
		
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccsData>\n";
		 #------------------------lasantha 22-09-2010_factory account id-------------------------
		 /*$facIdRes=getFactoryId($accFactory);
		 //echo $facIdRes;
		 $rowFacID=mysql_fetch_array($facIdRes);
		 $ResponseXML .= "<facAccNo><![CDATA[" . $rowFacID["strAccountNo"]  . "]]></facAccNo>\n";*/
		 #---------------------------------------------------------------------------------------
		 $result=getAvailableGLAccs($accNo,$accDescr);
		 //echo "$accNo,$accDescr,$accFactory";
		 while($row = @mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
			$ResponseXML .= "<accName><![CDATA[" . $row["strDescription"]  . "]]></accName>\n";
			$ResponseXML .= "<accType><![CDATA[" . $row["strAccType"]  . "]]></accType>\n";
			$ResponseXML .= "<accFacCode><![CDATA[" . $row["strFacCode"]  . "]]></accFacCode>\n";           
			$ResponseXML .= "<accGLID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></accGLID>\n";           
		 }
		 $ResponseXML .= "</GLAccsData>";
		 echo $ResponseXML;	
	}
	else if(strcmp($DBOprType,"deleteGLAccount") == 0)
	{
		global $db;
		
		$accNo = $_GET["accNo"];
		
		$strSQL="delete from glaccounts  where strAccID='$accNo'" ;  
		
		$db->ExecuteQuery($strSQL);
		return true;
		
	}
	else if(strcmp($DBOprType,"saveGLAllowcation") == 0)
	{
		$ResponseXML = "";
		$ResponseXML .= "<GLAllowcation>\n";
		//$accID = $_GET["accID"];
		$accGLID = $_GET["accGLID"];
		$accFactory = $_GET["accFactory"];
		
		if(saveNewGLAlloacation($accGLID,$accFactory))
		{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		$ResponseXML .= "</GLAllowcation>";
		echo $ResponseXML;
	}
	#------------------lasantha 22-09-2010----------------------
else if (strcmp($DBOprType,"deleteGLAccDets") == 0)
{
	$ResponseXML = "<DelGLAcc>\n";
	$supNO	= $_GET['supplier'];
	$GlNo	= $_GET['glNo'];
	
	$strSQL="DELETE FROM glallocationforsupplier WHERE strSupplierId='$supNO' AND strAccID='$GlNo';";
	$result = $db->RunQuery2($strSQL);
	if(gettype($result)=='string')
		$ResponseXML .= "<Result><![CDATA[".$result."]]></Result>\n"; 
	else
		$ResponseXML .= "<Result><![CDATA[Deleted successfully.]]></Result>\n"; 
	
	$ResponseXML .= "</DelGLAcc>";
	echo $ResponseXML;
}
	#-----------------------------------------------------------
	else if (strcmp($DBOprType,"loadEditDet") == 0){
		$accId=$_GET['accId'];
		$facCode=$_GET['facCode'];
		$sql="select strDescription,strAccType from glaccounts where strAccID='$accId' AND strFacCode='$facCode';";
		//echo $sql;
		$res=$db->RunQuery($sql);
		$ResponseXML = "";
		$ResponseXML .= "<GLAccDet>\n";
		while ($row=mysql_fetch_array($res)){
			$ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
			$ResponseXML .= "<strAccType><![CDATA[" . $row["strAccType"]  . "]]></strAccType>\n";
		}
		$ResponseXML .= "</GLAccDet>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"viewGLData") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
		 $accID = $_GET["accID"];
		 
		 $sql = "select * from glaccounts where intGLAccID='$accID' ";
		 $res = $db->RunQuery($sql);
		//echo $sql;
		 while($row = mysql_fetch_array($res))
		 {
		 	$ResponseXML .= "<GLAccID><![CDATA[" . $row["strAccID"]  . "]]></GLAccID>\n";
			$ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
			$ResponseXML .= "<strAccType><![CDATA[" . $row["strAccType"]  . "]]></strAccType>\n";
			$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
			$ResponseXML .= "<intGlType><![CDATA[" . $row["intGLType"]  . "]]></intGlType>\n";
			$ResponseXML .= "<intGlCategory><![CDATA[" . $row["intGLCategory"]  . "]]></intGlCategory>\n";
		 }
		 
		 $ResponseXML .= "</GLAccs>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"deleteGLdata") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
		 $GlAccId = $_GET["GlAccId"];
		 
		 $sql = "delete from glaccounts where intGLAccID = '$GlAccId' ";
		 $result = $db->RunQuery2($sql);
		 if(gettype($result)=='string')
		 {
			$ResponseXML .= "<Result><![CDATA[" . $result  . "]]></Result>\n";
			
		 }
		 else
		 {
		 	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
		 }
		
		
		 
		 $ResponseXML .= "</GLAccs>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"loadGLAlloData") == 0)
	{
		
		$comID = $_GET["comID"]; 
		
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccsData>\n";
		 $comAccNo = getFactoryId($comID);
		 $result=getFacwiseGLData($comID);
		 //echo "$accNo,$accDescr,$accFactory";
		 while($row = @mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
			$ResponseXML .= "<accName><![CDATA[" . $row["strDescription"]  . "]]></accName>\n";
			$ResponseXML .= "<accType><![CDATA[" . $row["strAccType"]  . "]]></accType>\n";      
			$ResponseXML .= "<accGLID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></accGLID>\n"; 
			$ResponseXML .= "<GLAccID><![CDATA[" . $row["intGLAccID"]  . "]]></GLAccID>\n";           
		 }
		 $ResponseXML .= "<facAccNo><![CDATA[" . $comAccNo  . "]]></facAccNo>\n";    
		 $ResponseXML .= "</GLAccsData>";
		 echo $ResponseXML;	
	}
	else if (strcmp($DBOprType,"deleteSupGLAlloData") == 0)
	{
		
		$supID = $_GET["supID"]; 
		
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccsData>\n";
		 
		 $sql = "delete from glallocationforsupplier WHERE strSupplierId='$supID'";
		 $res = $db->RunQuery($sql);
		
		 $ResponseXML .= "<Response><![CDATA[" . $res  . "]]></Response>\n";    
		 $ResponseXML .= "</GLAccsData>";
		 echo $ResponseXML;	
	}
	
function getAllowcatedSupGLAccs($supID)
{
	global $db;
	
	$strSQL="SELECT gl.strAccID,gl.strDescription ,c.strCode,gla.GLAccAllowNo
		FROM glaccounts gl INNER JOIN glallowcation gla on
		gl.intGLAccID = gla.GLAccNo 
		INNER JOIN glallocationforsupplier glSup ON
		glSup.strAccID = gla.GLAccAllowNo
		INNER JOIN costcenters c ON c.intCostCenterId = gla.FactoryCode
		where glSup.strSupplierId='$supID' " ;  
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}		

function saveNewGLAlloacation($accGLID,$accFactory)
{
	global $db;
	$strSQL="INSERT INTO glallowcation(GLAccNo,FactoryCode) VALUES('$accGLID','$accFactory')" ;  
	$db->ExecuteQuery($strSQL);
	return true;
}

function SaveSupGLAllowcation($supID,$glAccNo)
{
	global $db;
	
	/*if($isFirst==1)
	{
		$sql = "delete from glallocationforsupplier WHERE strSupplierId='$supID'";
		//echo $sql;	
		$db->RunQuery($sql);
	}	*/	
	//$glAccNo=split("-",$glAccNo);
	$strSQL="INSERT INTO glallocationforsupplier(strSupplierId,strAccID) VALUES('$supID','".$glAccNo."')" ;  
	//echo $strSQ;
	$db->ExecuteQuery($strSQL);
	return true;

}
	

function getAvailableGLAccs($no,$dcs)   
{
	global $db;
	
	if($no!="0" && $dcs=="0")
	{
		$strSQL="select * from glaccounts where strAccID =  '$no'  order by strAccID";	
	}
	else if($dcs!="0" && $no=="0")
	{
		$strSQL="select * from glaccounts where strDescription = '$dcs' order by strAccID";	
		
	}
	else if($no=="0" && $dcs=="0")
	{
		$strSQL="select * from glaccounts  order by strAccID";	
	}
	else if($no=="all" && $dcs=="all" && $factory!="")
	{
		/*$strSQL="SELECT glaccounts.strAccID, glaccounts.strDescription, glaccounts.strAccType, glaccounts.strFacCode, glallowcation.GLAccAllowNo FROM glaccounts INNER JOIN glallowcation ON (glaccounts.strAccID = glallowcation.GLAccNo) WHERE glallowcation.FactoryCode = '$factory' UNION SELECT glaccounts.strAccID, glaccounts.strDescription, glaccounts.strAccType, 'a' AS strFacCode, 'xno' AS GLAccAllowNo FROM glaccounts WHERE glaccounts.strAccID NOT IN (SELECT glallowcation.GLAccNo FROM glallowcation WHERE glallowcation.FactoryCode = '$factory') -- order by glaccounts.strAccID" ;*/
	$strSQL="SELECT glaccounts.strAccID, glaccounts.strDescription, glaccounts.strAccType, glaccounts.strFacCode, glallowcation.GLAccAllowNo 
FROM glaccounts INNER JOIN glallowcation ON (glaccounts.strAccID = glallowcation.GLAccNo) WHERE glaccounts.strFacCode = '$factory' and glallowcation.FactoryCode= '$factory'
UNION 
SELECT glaccounts.strAccID, glaccounts.strDescription, glaccounts.strAccType, 'a' AS strFacCode, 'xno' AS GLAccAllowNo FROM glaccounts 
WHERE glaccounts.strFacCode='$factory' and glaccounts.strAccID 
NOT IN (SELECT glallowcation.GLAccNo FROM glallowcation WHERE glallowcation.FactoryCode = '$factory');";
	}

	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}

	
function saveNewGLAcc($glAccNo,$glAccName,$glAccType,$intStatus,$accID,$accCat,$GLcategory)
{
	global $db;
	$sqlchk="select strAccID from glaccounts where strAccID='$glAccNo' ";
	//echo $accID;
	$res=$db->RunQuery($sqlchk);
	$nr=mysql_num_rows($res);
	if($accID !=0)
	{
		$sql = " update glaccounts 
					set
					strAccID = '$glAccNo' , 
					strDescription = '$glAccName' , 
					strAccType = '$glAccType' , 
					intStatus = '$intStatus',
					intGLType='$accCat',
					intGLCategory = $GLcategory
					where
					intGLAccID = '$accID' ";
			
			$result = $db->RunQuery($sql);	
			if($result == 1)
				return true;
	}
	else
	{
		$strSQL="insert into glaccounts(strAccID,strDescription,strAccType,intStatus,intGLType,intGLCategory) 	values('$glAccNo','$glAccName','$glAccType',$intStatus,'$accCat',$GLcategory)";
		$resI=$db->ExecuteQuery($strSQL);
		if($resI==1)
			return true;
	}
	
	
}
//==================lasantha-22-09-2010================
function getFactoryId($facID){
	global $db;
	$strSQL="SELECT strCode FROM costcenters WHERE intCostCenterId='$facID'";
	$resFacAccId=$db->RunQuery($strSQL);
	$row = mysql_fetch_array($resFacAccId);
	return $row["strCode"];
}

function deleteSupplierAccGlNo($supNO,$GlNo)
{
	global $db;
	$strSQL="DELETE FROM glallocationforsupplier WHERE strSupplierId='$supNO' AND strAccID='$GlNo';";
	 $result = $db->RunQuery2($strSQL);
	 if(gettype($result)=='string')
	 {
		$result =  $result;
	 }
	 else
 		$result = "Deleted successfully.";
return $result;
}
//==================End=====================

function getFacwiseGLData($comID)
{
global $db;
	$SQl = "select gl.strAccID,gl.strDescription,gl.strAccType,'Allono' as GLAccAllowNo,gl.intGLAccID
			from glaccounts gl
			where intStatus=1 and gl.intGLAccID not in (SELECT glallowcation.GLAccNo FROM glallowcation 
			WHERE glallowcation.FactoryCode = '$comID') 
			union 
			select gl.strAccID,gl.strDescription,gl.strAccType, glAllo.GLAccAllowNo as GLAccAllowNo,gl.intGLAccID
			from glaccounts gl inner join glallowcation glAllo on
			gl.intGLAccID=glAllo.GLAccNo
			where FactoryCode='$comID'";
			
		return $db->RunQuery($SQl);
}
?>