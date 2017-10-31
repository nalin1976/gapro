<?php 
require_once('../../Connector.php');
$request=$_GET['req'];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	

if($request=="selectDet")
{
	$styId 	=	$_GET['styId'];	
	$color 	=	$_GET['color'];
	$cat	=	$_GET['cat'];
	$ResponseXML .="<xmlDet>";	//was_machineloadingheader.dblQty,	(select intTotQty from was_machineloadingdetails where intStyleId='$styId' and strColor='$color') as TQty
		if($cat==0){
		$sql = "SELECT
				was_machineloadingheader.strColor,
			(select intTotQty from was_machineloadingdetails where intStyleId='$styId' and strColor='$color') as dblQty,
				orders.strStyle,
				orders.strOrderNo,
				orders.intQty,
				buyerdivisions.strDivision,
				was_stocktransactions.intCompanyId,
				companies.strName,
				companies.intCompanyID ,		
                (select dblIssueQty from was_machineloadingdetails where intStyleId='$styId' and strColor='$color') as IQty
			
				FROM
				was_machineloadingheader
				Inner Join orders ON was_machineloadingheader.intStyleId = orders.intStyleId
				left Join buyerdivisions ON buyerdivisions.intBuyerID = orders.intBuyerID
				Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId
				Inner Join companies ON companies.intCompanyID = was_stocktransactions.intCompanyId
				Inner Join was_actualcostheader ON was_machineloadingheader.intCostId = was_actualcostheader.intSerialNo
				WHERE was_machineloadingheader.intStatus =1 AND was_machineloadingheader.intStyleId='$styId' AND  was_machineloadingheader.strColor='$color' GROUP BY was_machineloadingheader.intStyleId;";
				//echo $sql ;// AND buyerdivisions.intDivisionId = was_actualcostheader.intDivisionId
			}
		else{
		$sql = "SELECT
				was_machineloadingheader.strColor,
				was_machineloadingheader.dblQty,
				orders.strStyle,
				orders.strOrderNo,
				orders.intQty,
				buyerdivisions.strDivision,
				was_stocktransactions.intCompanyId,
				companies.strName
				FROM
				was_machineloadingheader
				Inner Join orders ON was_machineloadingheader.intStyleId = orders.intStyleId
				left Join buyerdivisions ON buyerdivisions.intBuyerID = orders.intBuyerID
				Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId
				Inner Join companies ON companies.intCompanyID = was_stocktransactions.intCompanyId
				Inner Join was_actualcostheader ON was_machineloadingheader.intCostId = was_actualcostheader.intSerialNo 
				WHERE was_machineloadingheader.intStatus =1 AND was_machineloadingheader.intStyleId='$styId' AND  was_machineloadingheader.strColor='$color'  GROUP BY was_machineloadingheader.intStyleId;";//echo $sql;
			}

	$result = $db->RunQuery($sql);
	
	if(mysql_num_rows($result)==0)
	{
		$ResponseXML .= "<strTag>0</strTag>\n";
	}
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<strTag>1</strTag>\n";
		$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
		$ResponseXML .= "<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>\n";
		$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
		$ResponseXML .= "<CompanyID><![CDATA[" . trim($row["intCompanyID"])  . "]]></CompanyID>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
		$ResponseXML .= "<POQTY><![CDATA[" . trim($row["intQty"])  . "]]></POQTY>\n";
		$ResponseXML .= "<QTY><![CDATA[" . trim($row["dblQty"])  . "]]></QTY>\n";
		$ResponseXML .= "<RCVDQty><![CDATA[".getRCVDQty($styId,$color,'FTransIn',1)."]]></RCVDQty>";
		$ResponseXML .= "<IssueQty><![CDATA[".  trim($row["IQty"])."]]></IssueQty>";
		//$ResponseXML .= "<TotQty><![CDATA[".  trim($row["TQty"])."]]></TotQty>";
		
	}

	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
if($request=="loadDet")
{
	$issueId=	split('/',$_GET['issueId']);	
	$cat	=	$_GET['cat'];
	$ResponseXML .="<xmlDet>";
	if($cat==0){
	$sql_loadDet="SELECT
								was_issuedheader.intIssueId,was_issuedheader.intYear,
								was_machineloadingheader.strColor,
								was_issuedheader.intMode,
								orders.strStyle,
								orders.intStyleId,
								orders.strOrderNo,
								orders.intQty,
								buyerdivisions.strDivision,
								was_stocktransactions.intCompanyId,
								companies.strName,
								was_issuedheader.dblQty,
								was_issuedheader.dblRQty,
								was_issuedheader.dblWQty,
								was_issuedheader.dblIQty,
								was_issuedheader.dtmDate
								FROM
								was_issuedheader
								Inner Join was_machineloadingheader ON was_issuedheader.intStyleId = was_machineloadingheader.intStyleId
								Inner Join orders ON was_issuedheader.intStyleId = orders.intStyleId
								Inner Join buyerdivisions ON buyerdivisions.intBuyerID = orders.intBuyerID
								Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = orders.intStyleId
								Inner Join companies ON companies.intCompanyID = was_stocktransactions.intCompanyId
								Inner Join was_actualcostheader ON was_machineloadingheader.intCostId = was_actualcostheader.intSerialNo 
								
								WHERE
								was_issuedheader.intIssueId =  '".$issueId[1]."' and 
								was_issuedheader.intYear =  '".$issueId[0]."'
								GROUP BY was_issuedheader.intIssueId,was_issuedheader.intYear
								ORDER BY was_issuedheader.dtmDate DESC;";
			}
			else{
			 $sql_loadDet="SELECT
				was_issuedheader.intIssueId,was_issuedheader.intYear,
				was_machineloadingheader.strColor,
				was_issuedheader.intMode,
				was_issuedheader.dblQty,
				was_issuedheader.dblRQty,
				was_issuedheader.dblIQty,
				was_issuedheader.dblWQty,
				was_outsidepo.strStyleDes as strStyle,
				was_outsidepo.intId as intStyleId,
				was_outsidepo.intPONo,
				was_outsidepo.dblOrderQty,
				was_outside_companies.strName,
				buyerdivisions.intDivisionId as strDivision
				FROM
				was_issuedheader
				Inner Join was_machineloadingheader ON was_machineloadingheader.intStyleId = was_issuedheader.intStyleId
				Inner Join was_outsidepo ON was_outsidepo.intId = was_issuedheader.intStyleId
				Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidepo.intFactory
				Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId AND was_outsidepo.intDivision = was_outsidewash_fabdetails.intDivision
				Inner Join buyerdivisions ON was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND buyerdivisions.intDivisionId = was_outsidewash_fabdetails.intDivision
				WHERE
				was_issuedheader.intIssueId =  '$issueId'
				GROUP BY was_issuedheader.intIssueId
				ORDER BY was_issuedheader.dtmDate DESC;";
			 }
			$res=$db->RunQuery($sql_loadDet);
			while($row=mysql_fetch_array($res))
			{
				$ResponseXML .= "<issueId><![CDATA[" . trim($row["intYear"]."/".$row["intIssueId"])  . "]]></issueId>\n";
				$ResponseXML .= "<intStyleId><![CDATA[" . trim($row["intStyleId"])  . "]]></intStyleId>\n";
				$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				$ResponseXML .= "<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>\n";
				$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
				$ResponseXML .= "<dtmDate><![CDATA[" . trim(substr($row["dtmDate"],0,10))  . "]]></dtmDate>\n";
				$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				$ResponseXML .= "<dblRQty><![CDATA[" . trim($row["dblRQty"])  . "]]></dblRQty>\n";
				$ResponseXML .= "<dblWQty><![CDATA[" . trim($row["dblWQty"])  . "]]></dblWQty>\n";
				$ResponseXML .= "<dblIQty><![CDATA[" . trim($row["dblIQty"])  . "]]></dblIQty>\n";
				$ResponseXML .= "<intMode><![CDATA[" . trim($row["intMode"])  . "]]></intMode>\n";
				$ResponseXML .= "<TQty><![CDATA[" . getIssuedQty($row["intStyleId"],$row["strColor"])  . "]]></TQty>\n";
			}
			
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
if($request=="selectColors")
{
	$issueId=$_GET['styId'];	
	$ResponseXML .="<xmlDet>";
	$sql_loadColors="SELECT strColor FROM was_machineloadingdetails WHERE intStyleId='$issueId';";
	$res=$db->RunQuery($sql_loadColors);
	while($row=mysql_fetch_array($res))
	{
		$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"]) . "]]></strColor>\n";
	}
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}

if($request=="loadSearchDet")
{
	$issueId=$_GET['issueId'];	
	$dtmFrom=$_GET['dtmFrom'];
	$dtmT0=$_GET['dtmT0'];
	$ResponseXML .="<xmlDet>";
	$sql_loadSearchDet="SELECT 		
						wi.intIssueId,wi.intMode,wi.intStyleId,O.strStyle,ws.strColor,
						BD.strDivision,
						companies.strName,wi.dtmDate,wi.dblQty,wi.dblRQty,wi.dblWQty,wi.dblIQty,O.strOrderNo
						FROM was_issuedheader wi
						INNER JOIN was_machineloadingheader ws on ws.intStyleId=wi.intStyleId
						INNER JOIN was_actualcostheader AS wa ON wa.intSerialNo=ws.intCostId
						INNER JOIN Orders AS O on O.intDivisionId=wa.intDivisionId
						INNER JOIN buyerdivisions AS BD on BD.intDivisionId=O.intDivisionId
						Inner Join productionfinishedgoodsreceiveheader ON productionfinishedgoodsreceiveheader.intStyleNo = O.intStyleId
						Inner Join companies ON productionfinishedgoodsreceiveheader.strTComCode = companies.intCompanyID 
						WHERE ws.intStatus =1 ";
			//echo $sql_loadSearchDet;
			if(!empty($issueId))
			{
				$sql_loadSearchDet.=" AND wi.intIssueId like '%$issueId%'";
			}
			if((!empty($dtmFrom)) && (!empty($dtmT0)))
			{
				$sql_loadSearchDet.=" AND wi.dtmDate BETWEEN '$dtmFrom' AND '$dtmT0'";
			}		
			$sql_loadSearchDet.="GROUP BY wi.intIssueId;";
			
			$res=$db->RunQuery($sql_loadSearchDet);
			if(!mysql_num_rows($res)>0){
			$sql_loadSearchDet="SELECT
								was_issuedheader.intIssueId,
								was_issuedheader.intMode,
								was_issuedheader.intStyleId,
								was_issuedheader.dtmDate,
								was_issuedheader.dblQty,
								was_issuedheader.dblRQty,
								was_issuedheader.dblWQty,
								was_issuedheader.dblIQty,
								was_outsidepo.strStyleDes as strStyle,
								was_outsidepo.intPONo as  strOderNo,
								was_machineloadingheader.strColor,
								buyerdivisions.strDivision,
								was_outside_companies.strName
								FROM
								was_issuedheader
								Inner Join was_outsidepo ON was_outsidepo.intId = was_issuedheader.intStyleId
								Inner Join was_machineloadingheader ON was_issuedheader.intStyleId = was_machineloadingheader.intStyleId
								Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId AND was_outsidepo.intDivision = was_outsidewash_fabdetails.intDivision
								Inner Join buyerdivisions ON was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
								Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory";
				if(!empty($issueId))
				{
					$sql_loadSearchDet.=" AND was_issuedheader.intIssueId like '%$issueId%'";
				}
				if((!empty($dtmFrom)) && (!empty($dtmT0)))
				{
					$sql_loadSearchDet.=" AND was_issuedheader.dtmDate BETWEEN '$dtmFrom' AND '$dtmT0'";
				}		
				$sql_loadSearchDet.="GROUP BY was_issuedheader.intIssueId;";
									
			}//echo $sql_loadSearchDet;
			$res=$db->RunQuery($sql_loadSearchDet);
			while($row=mysql_fetch_array($res))
			{
				$mode="";
				if(trim($row["intMode"])=='0')
				{
					$mode='In';
				}
				else{$mode='Out';}
				$ResponseXML .= "<issueId><![CDATA[" . trim($row["intIssueId"])  . "]]></issueId>\n";
				$ResponseXML .= "<intStyleId><![CDATA[" . trim($row["strOrderNo"])  . "]]></intStyleId>\n";
				$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				$ResponseXML .= "<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>\n";
				$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
				$ResponseXML .= "<dtmDate><![CDATA[" . trim(substr($row["dtmDate"],0,10))  . "]]></dtmDate>\n";
				$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				$ResponseXML .= "<dblRQty><![CDATA[" . trim($row["dblRQty"])  . "]]></dblRQty>\n";
				$ResponseXML .= "<dblWQty><![CDATA[" . trim($row["dblWQty"])  . "]]></dblWQty>\n";
				$ResponseXML .= "<dblIQty><![CDATA[" . trim($row["dblIQty"])  . "]]></dblIQty>\n";
				$ResponseXML .= "<intMode>$mode</intMode>\n";
			}
			
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
if($request=="loadNewRow")
{
	$issueId=split('/',$_GET['issueId']);	
	
	$ResponseXML .="<xmlDet>";
	$sql_loadSearchDet="SELECT 		
						wi.intIssueId,wi.intYear,wi.intMode,wi.intStyleId,O.strStyle,ws.strColor,
						BD.strDivision,
						companies.strName,wi.dtmDate,wi.dblQty,wi.dblRQty,wi.dblWQty,wi.dblIQty,O.strOrderNo
						FROM was_issuedheader wi
						INNER JOIN was_machineloadingheader ws on ws.intStyleId=wi.intStyleId
						INNER JOIN was_actualcostheader AS wa ON wa.intSerialNo=ws.intCostId
						INNER JOIN orders AS O on O.intDivisionId=wa.intDivisionId
						left JOIN buyerdivisions AS BD on BD.intDivisionId=O.intDivisionId
					       Inner Join was_stocktransactions ON was_stocktransactions.intStyleId = O.intStyleId
						Inner Join companies ON was_stocktransactions.intCompanyId = companies.intCompanyID 
						WHERE ws.intStatus =1  AND wi.intIssueId = '".$issueId[1]."' and wi.intYear = '".$issueId[0]."' ";

				//$sql_loadSearchDet.=" AND wi.intIssueId like '%$issueId%'";
			
				$sql_loadSearchDet.="GROUP BY wi.intIssueId;";
				
				//echo $sql_loadSearchDet;
			$res=$db->RunQuery($sql_loadSearchDet);
			while($row=mysql_fetch_array($res))
			{
				$mode="";
				if(trim($row["intMode"])=='0')
				{
					$mode='In';
				}
				else{$mode='Out';}
				$ResponseXML .= "<issueId><![CDATA[" . trim($row["intYear"]."/".$row["intIssueId"])  . "]]></issueId>\n";
				$ResponseXML .= "<intStyleId><![CDATA[" . trim($row["strOrderNo"])  . "]]></intStyleId>\n";
				$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				$ResponseXML .= "<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>\n";
				$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
				$ResponseXML .= "<dtmDate><![CDATA[" . trim(substr($row["dtmDate"],0,10))  . "]]></dtmDate>\n";
				$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				$ResponseXML .= "<dblRQty><![CDATA[" . trim($row["dblRQty"])  . "]]></dblRQty>\n";
				$ResponseXML .= "<dblWQty><![CDATA[" . trim($row["dblWQty"])  . "]]></dblWQty>\n";
				$ResponseXML .= "<dblIQty><![CDATA[" . trim($row["dblIQty"])  . "]]></dblIQty>\n";
				$ResponseXML .= "<intMode>$mode</intMode>\n";
			}
			
			$sql="SELECT was_issuedheader.intIssueId,was_issuedheader.intMode,was_issuedheader.intStyleId,was_issuedheader.dtmDate,was_issuedheader.dblQty,		was_issuedheader.dblRQty,was_issuedheader.dblWQty,was_issuedheader.dblIQty,was_outsidepo.strStyleDes as strStyle,was_outsidepo.intPONo as  strOderNo,was_machineloadingheader.strColor,buyerdivisions.strDivision,was_outside_companies.strName
			FROM
			was_issuedheader
			Inner Join was_outsidepo ON was_outsidepo.intId = was_issuedheader.intStyleId
			Inner Join was_machineloadingheader ON was_issuedheader.intStyleId = was_machineloadingheader.intStyleId
			Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId AND was_outsidepo.intDivision = was_outsidewash_fabdetails.intDivision
			Inner Join buyerdivisions ON was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
			Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory";
			$sql.=" AND wi.intIssueId like '%$issueId%'";			
			$sql.="GROUP BY wi.intIssueId;";
			$res=$db->RunQuery($sql);
			while($row=mysql_fetch_array($res))
			{
				$mode="";
				if(trim($row["intMode"])=='0')
				{
					$mode='In';
				}
				else{$mode='Out';}
				$ResponseXML .= "<issueId><![CDATA[" . trim($row["intIssueId"])  . "]]></issueId>\n";
				$ResponseXML .= "<intStyleId><![CDATA[" . trim($row["strOrderNo"])  . "]]></intStyleId>\n";
				$ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				$ResponseXML .= "<strDivision><![CDATA[" . trim($row["strDivision"])  . "]]></strDivision>\n";
				$ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
				$ResponseXML .= "<dtmDate><![CDATA[" . trim(substr($row["dtmDate"],0,10))  . "]]></dtmDate>\n";
				$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
				$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				$ResponseXML .= "<dblRQty><![CDATA[" . trim($row["dblRQty"])  . "]]></dblRQty>\n";
				$ResponseXML .= "<dblWQty><![CDATA[" . trim($row["dblWQty"])  . "]]></dblWQty>\n";
				$ResponseXML .= "<dblIQty><![CDATA[" . trim($row["dblIQty"])  . "]]></dblIQty>\n";
				$ResponseXML .= "<intMode>$mode</intMode>\n";
			}
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
if($request=="getBalance"){
	$po    = $_GET['poNo'];
	$color = $_GET['color'];
	
	$select_balance="SELECT intTotQty,dblIssueQty FROM was_machineloadingdetails WHERE intStyleId='$po' AND strColor='$color';";
	//echo $select_balance;
	$res=$db->RunQuery($select_balance);
	$row=mysql_fetch_array($res);
	$ResponseXML .="<xmlDet>";
	$ResponseXML .="<ToTQty><![CDATA[" . trim($row["intTotQty"])  . "]]></ToTQty>\n";
	$ResponseXML .="<IssueQty><![CDATA[" . trim($row["dblIssueQty"])  . "]]></IssueQty>\n";
	$ResponseXML .="</xmlDet>";
	echo $ResponseXML;
}
function getRCVDQty($po,$color,$type,$store){
	global $db;
	$sql="SELECT
			Sum(was_stocktransactions.dblQty) AS Qty
			FROM
			was_stocktransactions
			WHERE
			was_stocktransactions.intStyleId =  '$po' AND
			was_stocktransactions.strColor =  '$color' AND
			was_stocktransactions.strMainStoresID='$store' AND
			was_stocktransactions.strType =  '$type'
			GROUP BY
			was_stocktransactions.intStyleId,
			was_stocktransactions.strColor,
			was_stocktransactions.strType;";
			
	$res=$db->RunQuery($sql);
	$row= mysql_fetch_array($res);
	return $row['Qty'];
}
function getIssuedQty($po,$color){
 global $db;
 $sql="select sum(dblIQty) as dblIQty from was_issuedheader where intStyleId='$po' and strColor='$color' group by intStyleId,strColor;";
 $res=$db->RunQuery($sql);
 $row= mysql_fetch_array($res);
 return $row['dblIQty'];
}
?>
