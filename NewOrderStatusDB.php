<?php
	session_start();
	include "Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
	$DBOprType 		= $_GET["DBOprType"]; 
	$StyleID 		= $_GET["StyleID"];

	 $sqlCatQtyList="";
	
	if (strcmp($DBOprType,"getStyleDeialsCount") == 0)
	{	
		 $companyID	=$_GET["companyID"];
		 $cusID		=$_GET["cusID"];
		 $styleLike	=$_GET["styleLike"];
		 
		 global $db; 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Data>\n";
		 
		 if($companyID!="")
		 {
			$strSQL="SELECT orders.intStyleId, orders.strDescription, styleratio.strBuyerPONO, orders.reaFOB, orders.reaNewSMV,0 AS estyy,0 AS actyy,orders.reaNewCM,DATE_FORMAT(orders.dtmDate,'%Y/%m/%d') AS dtmDate,styleratio.strColor,SUM(styleratio.dblQty) AS dblQty,0 AS GMTETD,0 AS RevETD FROM (((styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId)   INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId) INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId) INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID WHERE orders.intCompanyID ='$companyID' and orders.intStatus=11 ";
		 
		 
		 if($cusID!="")
		 {
			$strSQL=$strSQL . " and orders.intBuyerID='$cusID'";
		 }
		
		 if($styleLike!="")
		 {
			$strSQL=$strSQL . " and orders.intStyleId like '$styleLike%'";
		 }	
		 
		 $strSQL=$strSQL . " GROUP BY buyers.strName,orders.intStyleId, orders.strDescription,styleratio.strBuyerPONO, orders.reaFOB,orders.reaNewSMV, orders.reaNewCM,orders.dtmDate,styleratio.strColor";
		 
		 
		 $result=$db->RunQuery($strSQL);
		 
		 }
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<strStyleID><![CDATA[" . $row["intStyleId"]  . "]]></strStyleID>\n";
			$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
		 }
		 $ResponseXML .= "</Data>";
		 echo $ResponseXML;
	}
		 
	else if (strcmp($DBOprType,"getStyleDeials") == 0)
	{	
		 $companyID		=$_GET["companyID"];
		 $cusID			=$_GET["cusID"];
		 $styleLike		=$_GET["styleLike"];
		 $possition	   	=$_GET["possition"];
		 $noOfRowsFrom 	=$_GET["noOfRowsFrom"];
		 $noOfRowsTo 	=$_GET["noOfRowsTo"];
		 global $db; 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<Data>\n";
		
		 $result="";		 
		 
		 if($companyID!="")
		 {
			$strSQL="SELECT buyers.strName,orders.intStyleId, orders.strDescription, styleratio.strBuyerPONO, orders.reaFOB, orders.reaSMV as reaNewSMV,0 AS estyy,0 AS actyy,round(orders.reaSMVRate*orders.reaSMV,4) as reaNewCM,date_format(orders.dtmDate,'%Y/%m/%d') AS dtmDate,styleratio.strColor,SUM(styleratio.dblQty) AS dblQty,0 AS GMTETD,0 AS RevETD FROM (((styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId)   INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId) INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId) INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID WHERE orders.intCompanyID ='$companyID' and orders.intStatus=11 ";
		 
		 //echo $strSQL;
		 
		 if($cusID!="")
		 {
			$strSQL=$strSQL . " and orders.intBuyerID='$cusID'";
		 }
		
		 if($styleLike!="")
		 {
			$strSQL=$strSQL . " and orders.intStyleId like '$styleLike%'";
		 }	
		 
		 $strSQL=$strSQL . " GROUP BY buyers.strName,orders.intStyleId, orders.strDescription,styleratio.strBuyerPONO, orders.reaFOB,orders.reaNewSMV, orders.reaNewCM,orders.dtmDate,styleratio.strColor order by orders.dtmDate desc Limit $noOfRowsFrom,$noOfRowsTo";
		 
		
		//
		//echo $strSQL;
		 
		 $result=$db->RunQuery($strSQL);
		 
		 }
		 
		
		$userID=$_SESSION["UserID"];
		$sqlTemp="delete from temporderstatusstyles where userID='$userID'";
		$db->RunQuery($sqlTemp);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
			$ResponseXML .= "<strStyleID><![CDATA[" . $row["intStyleId"]  . "]]></strStyleID>\n";
			$ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
			$ResponseXML .= "<strBuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></strBuyerPONO>\n";
			$ResponseXML .= "<reaFOB><![CDATA[" . $row["reaFOB"]  . "]]></reaFOB>\n";
			$ResponseXML .= "<reaNewSMV><![CDATA[" . $row["reaNewSMV"]  . "]]></reaNewSMV>\n";
			$ResponseXML .= "<estyy><![CDATA[" . $row["estyy"]  . "]]></estyy>\n";
			$ResponseXML .= "<actyy><![CDATA[" . $row["actyy"]  . "]]></actyy>\n";
			$ResponseXML .= "<reaNewCM><![CDATA[" . $row["reaNewCM"]  . "]]></reaNewCM>\n";
			$ResponseXML .= "<dtmDate><![CDATA[" . $row["dtmDate"]  . "]]></dtmDate>\n";
			$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
			$ResponseXML .= "<GMTETD><![CDATA[" . $row["GMTETD"]  . "]]></GMTETD>\n";
			$ResponseXML .= "<RevETD><![CDATA[" . $row["RevETD"]  . "]]></RevETD>\n";
			
			$styleID=$row["intStyleId"];
			$colour	=$row["strColor"];
			$userID=$_SESSION["UserID"];
			
			$sqlCatQty="insert into temporderstatusstyles(intStyleId,strColour,userID) values('$styleID','$colour','$userID')";
			$db->RunQuery($sqlCatQty);
			
			//getItemCategories($styleID,$colour);
						
			//echo $sqlTempStyle;
			
			//$db->RunQuery($sqlTempStyle);
			
		 }
		 $ResponseXML .= "</Data>";
		 echo $ResponseXML;
	}
	else if(strcmp($DBOprType,"getAllCategories")==0)
	{
		global $db; 
		$ResponseXML = "";
		$ResponseXML .= "<Categories>\n";
	
		$strSQL="select intSubCatNo,StrCatName from matsubcategory where intStatus=1 and intCatno=2 or intCatno=3 and StrCatName<>'' order by intCatno,StrCatName";
		$result= $db->RunQuery($strSQL);
		
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<StrCatID><![CDATA[" . $row["intSubCatNo"]  . "]]></StrCatID>\n";
			$ResponseXML .= "<StrCatName><![CDATA[" . $row["StrCatName"]  . "]]></StrCatName>\n";
		}
		$ResponseXML .= "</Categories>";
		echo $ResponseXML;
	
	
	}
	
	else if (strcmp($DBOprType,"getCategories") == 0)
	{	
		$strStyle	=$_GET["strStyle"];
		$strColour	=$_GET["strColour"];
		$strCatID	=$_GET["strCatID"];
		$userID		=$_SESSION["UserID"];
		
		$ResponseXML = "";
		$ResponseXML .= "<Categories>\n";
		
		
		$result= getItemCategories($strStyle,$strColour,$strCatID);
		if($result==0)
		{
			$ResponseXML .= "<strCatID><![CDATA[" . $strCatID  . "]]></strCatID>\n";
			$ResponseXML .= "<dblQty><![CDATA[0]]></dblQty>\n";
		}
		else if($result!=0)
		{
			while($row = mysql_fetch_array($result))
			{
				$ResponseXML .= "<strCatID><![CDATA[" . $strCatID  . "]]></strCatID>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
			}
		}
		
		$ResponseXML .= "</Categories>";
		echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"ESTYY") == 0)
	{	
		 $INVNo=$_GET["INVNo"];
		
		 $ResponseXML = "";
		 $ResponseXML .= "<order>\n";
				 
		/*$SQL="SELECT reaConPc FROM orderdetails INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId 
	INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
	INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
	WHERE orders.intCompanyID ='".$RequestType."';";*/
		$SQL="SELECT matitemlist.strItemDescription,orderdetails.reaConPc FROM orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial WHERE orderdetails.intStyleId = '$StyleID' AND matitemlist.intMainCatID = '1';";
		
		
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<Estyy><![CDATA[" . $row["reaConPc"]  . "]]></Estyy>\n";
			 $ResponseXML .= "<Material><![CDATA[" . $row["strItemDescription"]  . "]]></Material>\n";
		
		}
		 $ResponseXML .= "</order>";
		 echo $ResponseXML;
		 
	}
	else if (strcmp($DBOprType,"SIZERATIOS") == 0)//OK
	{	
		$Color=$_GET["Color"];
	
		$ResponseXML = "";
		$ResponseXML .= "<size>\n";
			
		$SQL="SELECT styleratio.strSize,styleratio.dblQty FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId WHERE orders.intStyleId like '$StyleID' and strColor='$Color';";
		
		//echo $SQL;
		
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
			 $ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		
		} $ResponseXML .= "</size>";
	 echo $ResponseXML;
	 
	}
	function getItemCategories($styleID,$strColor,$strCatID)
	{
		global $db;
		
		$strSQL="SELECT intMatDetailID from orderdetails inner join matitemlist on orderdetails.intMatDetailID=matitemlist.intItemSerial where orderdetails.intStyleId='$styleID' and matitemlist.intSubCatID='$strCatID'";
		
		$catResult=$db->RunQuery($strSQL);
		while($cat = mysql_fetch_array($catResult))
		{
			$matDetID	=$cat["intMatDetailID"];
			if($matDetID=='')
			{
				//return 0;
			}
		}
		
		
		//$sqlCats="SELECT DISTINCT orders.intStyleId,matsubcategory.intSubCatNo,materialratio.strColor, sum(purchaseorderdetails.dblQty+purchaseorderdetails.dblAdditionalQty) AS dblQty,matsubcategory.StrCatName FROM  matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID INNER JOIN materialratio ON orders.intStyleId = materialratio.intStyleId AND orderdetails.intMatDetailID = materialratio.strMatDetailID LEFT JOIN purchaseorderdetails ON materialratio.intStyleId = purchaseorderdetails.intStyleId AND materialratio.strMatDetailID = purchaseorderdetails.intMatDetailID AND materialratio.strColor = purchaseorderdetails.strColor AND materialratio.strSize = purchaseorderdetails.strSize AND materialratio.strBuyerPONO = purchaseorderdetails.strBuyerPONO WHERE orders.intStyleId='$styleID' and matsubcategory.intSubCatNo='$strCatID' group by orders.intStyleId,matsubcategory.intSubCatNo,materialratio.strColor,matsubcategory.StrCatName";
		
		$sqlCats="SELECT DISTINCT sum(purchaseorderdetails.dblQty+purchaseorderdetails.dblAdditionalQty) AS dblQty FROM  matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID INNER JOIN materialratio ON orders.intStyleId = materialratio.intStyleId AND orderdetails.intMatDetailID = materialratio.strMatDetailID LEFT JOIN purchaseorderdetails ON materialratio.intStyleId = purchaseorderdetails.intStyleId AND materialratio.strMatDetailID = purchaseorderdetails.intMatDetailID AND materialratio.strColor = purchaseorderdetails.strColor AND materialratio.strSize = purchaseorderdetails.strSize AND materialratio.strBuyerPONO = purchaseorderdetails.strBuyerPONO WHERE orders.intStyleId='$styleID' and matsubcategory.intSubCatNo='$strCatID'";
		//$sqlCats="select sum(dblQty)AS dblQty from  purchaseorderdetails where intStyleId='$styleID' and intMatDetailID=88";
		$rstCatResult=$db->RunQuery($sqlCats);
		return $rstCatResult;
		
		
		

	}

?>