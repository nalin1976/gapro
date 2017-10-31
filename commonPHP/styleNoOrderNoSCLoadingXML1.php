<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";

//simplexml_load_file('../config.xml');
		
/*$xml = simplexml_load_file('../config.xml');
$headerPub_AllowOrderStatus = $xml->AllowOrderStatus;*/

$companyId=$_SESSION["FactoryID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


$RequestType = $_GET["RequestType"];

//-------------------------------------------------------------Style Item Gatepass--------------------------------------------------------------------

if($RequestType == "styleItemGatePassGetStylewiseOrderNo")
{
    $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = "SELECT DISTINCT orders.strStyle,orders.strOrderNo,orders.intStyleId
				FROM orders
				Inner Join subcontract_styledetails ON orders.intStyleId = subcontract_styledetails.intStyleId ";
		
	if($stytleName != 'Select One' && $stytleName != ''){
		$SQL .= " and orders.strStyle='$stytleName' ";
	}	
		
		$SQL .= " GROUP BY orders.intStyleId order by orders.strOrderNo";		
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "styleItemGatePassgetStyleWiseSCNum")
{
	//echo ("qqq");
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 //$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = "SELECT DISTINCT specification.intSRNO,orders.strStyle,specification.intStyleId
 FROM orders
				Inner Join specification ON orders.intStyleId = specification.intStyleId";
				//echo $SQL ;	
		
	if($stytleName != 'Select One' && $stytleName != ''){
		$SQL .= " and orders.strStyle='$stytleName' ";
	}
		
		$SQL .= " GROUP BY specification.intStyleId
			      order by specification.intSRNO desc";	
		
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "styleItemGatePassGetStyleNo")
{
 $ResponseXML="";
 $styleID = $_GET["styleID"];
 
 $SQL = "select strStyle from orders where intStyleId = '$styleID'";
 $result = $db->RunQuery($SQL);
 while($row=mysql_fetch_array($result))
 {
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
 }
 $ResponseXML.="<StyleNameList>";
 $ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
 $ResponseXML.="</StyleNameList>";
 echo $ResponseXML;
}

//---------------------------------------GRN------------------------------------------------------------------------------------------------------

else if($RequestType == "GRNGetStylewiseOrderNo")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	    $SQL = " select distinct po.intStyleId,o.strOrderNo
			from purchaseorderdetails po inner join orders o on
			po.intStyleId = o.intStyleId
			where intPoNo='$poNoArray[1]' and intYear='$poNoArray[0]' and o.strStyle='$stytleName'";		
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "GRNgetStyleWiseSCNum")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = " SELECT DISTINCT
			specification.intSRNO,
			o.intStyleId
			FROM
			purchaseorderdetails AS po
			Inner Join orders AS o ON po.intStyleId = o.intStyleId
			Inner Join specification ON o.intStyleId = specification.intStyleId
			where intPoNo='$poNoArray[1]' and intYear='$poNoArray[0]' ";
		
	if($stytleName != 'Select One' && $stytleName != ''){
		$SQL .= " and o.strStyle='$stytleName' ";
	}
		
	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "GRNGetStyleNo")
{
 $ResponseXML="";
 $styleID = $_GET["styleID"];
 $poNoArray = explode('/',$_GET["poNo"]);
 
  $SQL = "select distinct o.strStyle
			from purchaseorderdetails po inner join orders o on
			po.intStyleId = o.intStyleId
			where intPoNo='$poNoArray[1]' and intYear='$poNoArray[0]' and o.intStyleId='$styleID'";
 $result = $db->RunQuery($SQL);
 while($row=mysql_fetch_array($result))
 {
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
 }
 $ResponseXML.="<StyleNameList>";
 $ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
 $ResponseXML.="</StyleNameList>";
 echo $ResponseXML;
}

//----------------------------------------------------------------MRN-----------------------------------------------------------------------------

else if($RequestType == "MRNGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = " select distinct intSRNO,MD.intStyleId,orders.strOrderNo from matrequisitiondetails MD
				inner join specification SP on MD.intStyleId=SP.intStyleId 
				inner JOIN orders ON SP.intStyleId = orders.intStyleId ";
		
	if($stytleName != 'Select One' && $stytleName != ''){
		$SQL .= " where orders.strStyle='$stytleName' ";
	}	
	
	$SQL  .= " Order By strOrderNo ASC";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "MRNgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = " select distinct intSRNO,MD.intStyleId
				FROM
				matrequisitiondetails AS `MD`
				Inner Join specification AS SP ON `MD`.intStyleId = SP.intStyleId
				Inner Join orders ON SP.intStyleId = orders.intStyleId";
				
	if($stytleName != 'Select One' && $stytleName != ''){
	  $SQL .= " where orders.strStyle='$stytleName' ";
	}	

	  $SQL  .= "Order By intSRNO ASC";	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "MRNGetStyleNo")
{
 $ResponseXML="";
 $styleID = $_GET["styleID"];
 
  $SQL = "select distinct orders.strStyle from matrequisitiondetails MD
inner join specification SP on MD.intStyleId=SP.intStyleId 
inner JOIN orders ON SP.intStyleId = orders.intStyleId where orders.intStyleId = '$styleID' Order By orders.strOrderNo ASC ";
 $result = $db->RunQuery($SQL);
 while($row=mysql_fetch_array($result))
 {
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
 }
 $ResponseXML.="<StyleNameList>";
 $ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
 $ResponseXML.="</StyleNameList>";
 echo $ResponseXML;
}

//-------------------------------------------Return to stores--------------------------------------------------------------------

else if($RequestType == "ReturnToStoresGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = " SELECT DISTINCT ".
				"ID.intStyleId, ".
				"orders.strOrderNo  ".
				"FROM ".
				"issuesdetails AS ID ".
				"Inner Join orders ON ID.intStyleId = orders.intStyleId  ".
				"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
				"WHERE ".
				"ID.dblBalanceQty > 0 AND ".
				"issues.intCompanyID ='$companyId'  ";
		
	if($stytleName != 'Select One' && $stytleName != ''){
		$SQL .= " and orders.strStyle='$stytleName' ";
	}	
	
	$SQL  .= " order by orders.strStyle";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "ReturnToStoresgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = " SELECT DISTINCT ID.intStyleId, specification.intSRNO
				FROM
				issuesdetails AS ID
				Inner Join specification ON ID.intStyleId = specification.intStyleId
				Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear
				Inner Join orders ON specification.intStyleId = orders.intStyleId
				WHERE ID.dblBalanceQty > 0 AND issues.intCompanyID ='$companyId'	";
				
   if($stytleName != 'Select One' && $stytleName != ''){
	  $SQL .= " and orders.strStyle='$stytleName' ";
	}	

	  $SQL  .= " Order by specification.intSRNO DESC";	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "ReturnToStoresGetStyleNo")
{
 $ResponseXML="";
 $styleID = $_GET["styleID"];
 
   $SQL = "SELECT DISTINCT ".
				"orders.strStyle  ".
				"FROM ".
				"issuesdetails AS ID ".
				"Inner Join orders ON ID.intStyleId = orders.intStyleId  ".
				"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
				"WHERE ".
				"ID.dblBalanceQty > 0 AND ".
				"issues.intCompanyID ='$companyId' AND orders.intStyleId = '$styleID' order by orders.strStyle ";
 $result = $db->RunQuery($SQL);
 while($row=mysql_fetch_array($result))
 {
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
 }
 $ResponseXML.="<StyleNameList>";
 $ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
 $ResponseXML.="</StyleNameList>";
 echo $ResponseXML;
}

//----------------------------------------------------Return to Supp-----------------------------------------------------------------

else if($RequestType == "ReturnToSupGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = " (SELECT DISTINCT O.intStyleId,O.strOrderNo 
			FROM stocktransactions AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId' and O.strStyle = '2011'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)
			union 
			(SELECT DISTINCT O.intStyleId,O.strOrderNo 
			FROM stocktransactions_temp AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId' and O.strStyle = '$stytleName'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0) order by strOrderNo";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}

else if($RequestType == "ReturnToSupgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = "  (SELECT DISTINCT SP.intSRNO,SP.intStyleId
			FROM stocktransactions AS ST INNER JOIN 
			specification AS SP ON ST.intStyleId=SP.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
                        inner join orders on orders.intStyleId = ST.intStyleId
			WHERE MS.intCompanyId ='1' and orders.strStyle = '$stytleName'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)
			union 
			(SELECT DISTINCT SP.intSRNO,SP.intStyleId 
			FROM stocktransactions_temp AS ST INNER JOIN 
			specification AS SP ON ST.intStyleId=SP.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
                        inner join orders on orders.intStyleId = ST.intStyleId
			WHERE MS.intCompanyId ='1' and orders.strStyle = '$stytleName'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)
			order by intSRNO DESC";	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;	
}

else if($RequestType == "ReturnToSupGetStyleNo")
{
 $ResponseXML="";
 $styleID = $_GET["styleID"];
 
   $SQL = " (SELECT DISTINCT O.strStyle
			FROM stocktransactions AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId' 
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0)
			union 
			(SELECT DISTINCT O.strStyle
			FROM stocktransactions_temp AS ST 			
			inner join orders O on O.intStyleId=ST.intStyleId 
			Inner Join mainstores AS MS ON MS.strMainID = ST.strMainStoresID 
			WHERE MS.intCompanyId ='$companyId'
			group by  ST.intStyleId,MS.intCompanyId
			having  sum(ST.dblQty) > 0) order by strStyle ";
 $result = $db->RunQuery($SQL);
 while($row=mysql_fetch_array($result))
 {
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
 }
 $ResponseXML.="<StyleNameList>";
 $ResponseXML.="<StyleName><![CDATA[" .$str. "]]></StyleName>\n";
 $ResponseXML.="</StyleNameList>";
 echo $ResponseXML;
}

//--------------------------------------------------Inter Job Transfer-------------------------------------------------------

else if($RequestType == "InterJobFROMGetStylewiseOrderNoFROM")
{
    $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = " SELECT distinct  O.intStyleId,O.strOrderNo
									FROM  orders O INNER JOIN  stocktransactions S ON O.intStyleId = S.intStyleId
									where(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2]) and O.strStyle='$stytleName'
									GROUP BY O.intStyleId,O.strStyle 
									HAVING SUM(S.dblQty)>0
									order by O.strOrderNo";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}

else if($RequestType == "InterJobFROMgetStyleWiseSCNumFROM")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	 $SQL = "  SELECT distinct  S.intSRNO,S.intStyleId
							FROM specification S INNER JOIN orders O ON S.intStyleId = O.intStyleId
							INNER JOIN stocktransactions ST ON ST.intStyleId = O.intStyleId
							WHERE (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2]) and O.strStyle = '$stytleName'
							GROUP BY S.intSRNO,S.intStyleId
							HAVING SUM(ST.dblQty)>0
							ORDER BY  intSRNO DESC ";	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;	
}

else if($RequestType == "InterJobTOGetStylewiseOrderNoTO")
{
    $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = " SELECT distinct  O.intStyleId,O.strOrderNo
								FROM  orders O 
								where (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2]) and O.strStyle = '$stytleName'
								order by O.strOrderNo";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}

else if($RequestType == "InterJobTOgetStyleWiseSCNumTO")
{
	$ResponseXML="";
	 $stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	 $SQL = " SELECT distinct  S.intSRNO,S.intStyleId
							FROM specification S INNER JOIN orders O ON S.intStyleId = O.intStyleId
							WHERE(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2]) and O.strStyle = '$stytleName'
							ORDER BY  intSRNO DESC ";	
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;	
}

//-------------------------------------------------Order Completion-------------------------------------------------------------


if($RequestType == "StoresConfirmGetStylewiseOrderNo")
{
    $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	    $SQL = " select distinct o.intStyleId, o.strOrderNo from orders o inner join stocktransactions st on
o.intStyleId = st.intStyleId  inner join mainstores ms on ms.strMainID= st.strMainStoresID
where o.intStatus=13 and ms.intCompanyId='$companyId' and o.strStyle='$stytleName'";

				
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "StoresConfirmgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	  $SQL = " SELECT DISTINCT
				o.intStyleId,
				o.strOrderNo,
				specification.intSRNO
				FROM
				orders AS o
				Inner Join stocktransactions AS st ON o.intStyleId = st.intStyleId
				Inner Join mainstores AS ms ON ms.strMainID = st.strMainStoresID
				Inner Join specification ON o.intStyleId = specification.intStyleId
				where o.intStatus=13 and ms.intCompanyId='$companyId' and o.strStyle='$stytleName' ";
			
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

//------------------------------------------------------------------Gate pass Transfer IN------------------------------------------------

if($RequestType == "GatePassTransferINGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	     $SQL = " select distinct gpd.intStyleId,o.strOrderNo as orderNo
				from gatepassdetails gpd inner join orders o on
				o.intStyleId = gpd.intStyleId 
				inner join gatepass  gp on gp.intGatePassNo=gpd.intGatePassNo and
				gp.intGPYear = gpd.intGPYear
				where gp.intCompany='$companyId' and gp.intStatus=1 and gpd.dblBalQty>0 ";
				if($stytleName != ''){
				$SQL .= " and o.strStyle='$stytleName'";
				}
				$SQL .=  " union 
				select distinct gpd.intStyleId,o.strOrderNo as orderNo
				from gatepassdetails gpd inner join orders o on
				o.intStyleId = gpd.intStyleId 
				inner join gatepass  gp on gp.intGatePassNo=gpd.intGatePassNo and
				gp.intGPYear = gpd.intGPYear
				inner join mainstores  ms on ms.strMainID = gp.strTo
				where ms.intCompanyId='$companyId' and  gp.intStatus=1 and gpd.dblBalQty>0 ";
				
				if($stytleName != ''){
				$SQL .= " and o.strStyle='$stytleName'";
				}
				$SQL .= " order by orderNo";

				
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["orderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "GatePassTransferINgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	  $SQL = " select distinct gpd.intStyleId,specification.intSRNO
				from gatepassdetails gpd inner join orders o on
				o.intStyleId = gpd.intStyleId 
				inner join gatepass  gp on gp.intGatePassNo=gpd.intGatePassNo and
				gp.intGPYear = gpd.intGPYear
				inner join specification on o.intStyleId = specification.intStyleId
				where gp.intCompany='$companyId' and gp.intStatus=1 and gpd.dblBalQty>0 ";
			if($stytleName != ''){
				$SQL .= " and o.strStyle='$stytleName'";
			}
				$SQL .= " union 
				select distinct gpd.intStyleId,specification.intSRNO
				from gatepassdetails gpd inner join orders o on
				o.intStyleId = gpd.intStyleId 
				inner join gatepass  gp on gp.intGatePassNo=gpd.intGatePassNo and
				gp.intGPYear = gpd.intGPYear
				inner join mainstores  ms on ms.strMainID = gp.strTo
				inner join specification on o.intStyleId = specification.intStyleId
				where ms.intCompanyId='$companyId' and  gp.intStatus=1 and gpd.dblBalQty>0 ";
				
			if($stytleName != ''){
				$SQL .= " and o.strStyle='$stytleName'";
			}
			
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "poReportGetStylewiseOrderNo"){
 	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	   $SQL = "select specification.intStyleId, orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND              orders.intStatus = 11 and orders.strStyle = '$stytleName' order by orders.strOrderNo";
	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}

//--------------------------------------------------------- Trim Inspection-------------------------------------------------------------------
else if($RequestType == "TrimGetStylewiseOrderNo")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	    $SQL = " SELECT DISTINCT GD.intStyleId,O.strOrderNo FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 ";		
				
		if($stytleName != ''){
		$SQL .= " and O.strStyle='$stytleName'";
		}
				
		$SQL .= " order by strOrderNo ASC";
				
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}


else if($RequestType == "TrimGetStylewiseSCNo")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = " SELECT DISTINCT
			GD.intStyleId,
			O.strStyle,
			specification.intSRNO
			FROM
			grndetails AS GD
			Inner Join grnheader AS GH ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			Inner Join orders AS O ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID
			Inner Join matsubcategory AS MSC ON MSC.intSubCatNo = MIL.intSubCatID
			Inner Join specification ON O.intStyleId = specification.intStyleId
			WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1 ";
			
		if($stytleName != ''){
		$SQL .= " and O.strStyle='$stytleName'";
		}
				
		$SQL .= " order by intSRNO DESC";
		
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

//--------------------------------------------------------------Work Study-----------------------------------------------------------------------
else if($RequestType == "OPBDGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	$SQL = " select distinct intStyleId,strOrderNo from orders where intStatus='11' ";		
    if($stytleName != ''){
	 $SQL .= " and strStyle = '$stytleName'";
	}
    $SQL .= " order by strOrderNo";
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "OPBDgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	  $SQL = " SELECT
				specification.intSRNO,
				specification.intStyleId
				FROM
				orders
				Inner Join specification ON orders.intStyleId = specification.intStyleId where intStatus='11' "; 
		
	  if($stytleName){			
	  $SQL .= " and strStyle = '$stytleName'";
	  }
				
	  $SQL .= " order by intSRNO ASC";
			
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}


else if($RequestType == "OPBDReportGetStylewiseOrderNo")
{
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	$SQL = " SELECT
				orders.strOrderNo,
				orders.intStyleId
				FROM
				ws_operationbreakdownheader
				Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId ";		
    if($stytleName != ''){
	 $SQL .= " and orders.strStyle = '$stytleName'";
	}
     $SQL .= " order by orders.strOrderNo";
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "OPBDReportgetStyleWiseSCNum")
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	  $SQL = " SELECT
				orders.intStyleId,
				specification.intSRNO
				FROM
				ws_operationbreakdownheader
				Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId
				Inner Join specification ON orders.intStyleId = specification.intStyleId "; 
		
	  if($stytleName){			
	  $SQL .= " and orders.strStyle = '$stytleName'";
	  }
				
	  $SQL .= " order by specification.intSRNO ASC";
			
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}

//---------------------------------------------------------Trim Listing---------------------------------------------------------------------

else if($RequestType == "TrimListGetStylewiseOrderNo")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
    $stytleName = $_GET["stytleName"];
	
	    $SQL = " SELECT DISTINCT GD.intStyleId,O.strOrderNo FROM grndetails GD
				INNER JOIN grnheader GH ON GH.intGrnNO = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
				inner join orders O on O.intStyleId=GD.intStyleId
				inner join matitemlist MIL on MIL.intItemSerial=GD.intMatDetailID
				inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID 
				WHERE GH.intStatus = 1 AND GH.intCompanyID='$companyId' and GD.intTrimIStatus<>'2' and MSC.intInspection=1";		
				
		if($stytleName != ''){
		$SQL .= " and O.strStyle='$stytleName'";
		}
				
		$SQL .= " order by strOrderNo ASC";
				
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if($RequestType == "TrimListGetStylewiseSCNo")
{
    $poNoArray = explode('/',$_GET["poNo"]);
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	 $arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	  $SQL = " SELECT DISTINCT
			GD.intStyleId,
			O.strOrderNo,
			specification.intSRNO
			FROM
			grndetails AS GD
			Inner Join grnheader AS GH ON GH.intGrnNo = GD.intGrnNo AND GH.intGRNYear = GD.intGRNYear
			Inner Join orders AS O ON O.intStyleId = GD.intStyleId
			Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID
			Inner Join matsubcategory AS MSC ON MSC.intSubCatNo = MIL.intSubCatID
			Inner Join specification ON O.intStyleId = specification.intStyleId ";
			
		if($stytleName != ''){
		$SQL .= " and O.strStyle='$stytleName'";
		}
				
		$SQL .= " order by specification.intSRNO DESC";
		
		//echo $SQL ;	
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<SCNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</SCNoList>";
	echo $ResponseXML;
	
}
?>