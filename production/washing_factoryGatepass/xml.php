<?php
session_start();
include "../../Connector.php";
include "../production.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
$intCompanyId =	$_SESSION["FactoryID"];
$userId		= $_SESSION['UserID'];
//------------Load Po No And Style No------------------------------------------------------------
if (strcmp($RequestType,"loadPoNoAndStyle") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	
	$sql = "SELECT 
	productionwashreadyheader.intStyleId, 
	orders.strStyle,
	orders.strOrderNo 
	FROM
	  productionwashreadyheader  LEFT JOIN orders ON productionwashreadyheader.intStyleId = orders.intStyleId
	  WHERE productionwashreadyheader.intFactory = '".$factoryID."' 
	  group by productionwashreadyheader.intStyleId 
	  order by productionwashreadyheader.intStyleId ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	
	 $ResponseXML2 .= "<orderNo>";
	 $ResponseXML2 .= "<![CDATA[";
	 $ResponseXML2 .="<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML2 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
			
		$k++;
	 }
	$ResponseXML1 .= "]]>"."</style>";
	$ResponseXML2 .= "]]>"."</orderNo>";
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1.$ResponseXML2. "</Styles>";
	 echo $ResponseXML;	
}
//--------Load Header to serial no ----------------------------------------------
if (strcmp($RequestType,"LoadHeaderToSerial") == 0)
{
	$ResponseXML= "<Styles>";
	$serial = $_GET["serialNo"];
	$year = $_GET["year"];
	
	/* $sql = "SELECT 
	  productionfggpheader.dtmGPDate AS Date,
	  productionfggpheader.strFromFactory,
	  productionfggpheader.strToFactory,
	  productionfggpheader.intStyleId,
	  productionfggpheader.strVehicleNo,
	  productionfggpheader.intConfirmedBy,
	  orders.strOrderNo,
	  orders.strStyle,
	  productionfggpdetails.intCutBundleSerial,
	  productionfggpdetails.dblBundleNo,	  
	  productionbundleheader.strCutNo AS strCutNoDetails,
	  productionfggpheader.intStatus
	  FROM
		 productionfggpdetails
		 JOIN productionbundleheader ON
		  productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial 
		  
		 JOIN productionbundledetails ON
		  productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo 
		 AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial 
		 
		 JOIN productionfggpheader ON
		  productionfggpdetails.intGPnumber = productionfggpheader.intGPnumber
		  
	   LEFT JOIN orders ON 
	   productionfggpheader.intStyleId = orders.intStyleId
		  
		-- LEFT JOIN productionfinishedgoodsreceivedetails ON productionbundledetails.dblBundleNo != productionfinishedgoodsreceivedetails.dblBundleNo 
		-- AND productionbundledetails.intCutBundleSerial != productionfinishedgoodsreceivedetails.intCutBundleSerial 
		WHERE
		 productionfggpheader.intGPnumber = '".$serial."' 
		 AND productionfggpheader.intGPYear = '".$year."'";*/
//removed-(15/09/2010)- (AND productionbundleheader.strStatus!=2)

//echo $sql;
		$sql="SELECT
				p.strFromFactory,
				p.strToFactory,
				p.intStatus,
				p.dtmGPDate,
				p.intStyleId,
				o.intStyleId,
				o.strStyle,
				o.strOrderNo,
				p.strVehicleNo,
				p.strRemarks
				FROM
				productionfggpheader AS p
				INNER JOIN orders AS o ON p.intStyleId = o.intStyleId
				WHERE
				p.intGPYear='".$year."' AND
				p.intGPnumber='".$serial."'";

	    global $db;
	    $result = $db->RunQuery($sql);
		
	$k=0;
		$ResponseXML1 .= "<fromFactory>";
		$ResponseXML1 .= "<![CDATA[";
		
		$ResponseXML2 .= "<toFactory>";
		$ResponseXML2 .= "<![CDATA[";
		
		$ResponseXML3 .= "<style>";
		$ResponseXML3 .= "<![CDATA[";
		
		$ResponseXML4 .= "<PoNo>";
		$ResponseXML4 .= "<![CDATA[";
		
		$ResponseXML5 .= "<cutNo>";
		$ResponseXML5 .= "<![CDATA[";
		
		$ResponseXML6 .= "<date>";
		$ResponseXML6 .= "<![CDATA[";
		
		$ResponseXML7 .= "<vehicle>";
		$ResponseXML7 .= "<![CDATA[";
								   
		$ResponseXML8 .= "<confirm>";
		$ResponseXML8 .= "<![CDATA[";
		$ResponseXML92='';
		$ResponseXML102 ='';
		$ResponseXML112 ='';

	$tempBundle="";	
	$noOfBundle=0;
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML12 = $ResponseXML1.$row["strFromFactory"] ;
		$ResponseXML22 = $ResponseXML2.$row["strToFactory"] ;
		$ResponseXML32 =$ResponseXML3. "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
		$ResponseXML42 =$ResponseXML4. "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
		$ResponseXML52 = $ResponseXML5. $row["intCutBundleSerial"];
		
		$tmpDateDescT=$row["dtmGPDate"];
		$ArrayDateDesc = explode('-',$tmpDateDescT);
		$DateDesc = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		$ResponseXML62 =  $ResponseXML6.$DateDesc ;
		
		$ResponseXML72 = $ResponseXML7.$row["strVehicleNo"] ;
		$ResponseXML82 = $ResponseXML8.$row["intStatus"] ;
		$ResponseXML92 = "<cancel><![CDATA[".getCancelStatus($year,$serial)."]]></cancel>\n";
		$ResponseXML102 = "<status><![CDATA[".$row['intStatus']."]]></status>\n";
		$ResponseXML112 = "<remarks><![CDATA[".$row['strRemarks']."]]></remarks>\n";
		$k++;
	 }
	 

	$ResponseXML12 .= "]]>"."</fromFactory>";
	$ResponseXML22 .= "]]>"."</toFactory>";
	$ResponseXML32 .= "]]>"."</style>";
	$ResponseXML42 .= "]]>"."</PoNo>";
	$ResponseXML52 .= "]]>"."</cutNo>";
	$ResponseXML62 .= "]]>"."</date>";
	$ResponseXML72 .= "]]>"."</vehicle>";
	$ResponseXML82 .= "]]>"."</confirm>";
	

	$ResponseXML .=  $ResponseXML12.$ResponseXML22.$ResponseXML32.$ResponseXML42.$ResponseXML52.$ResponseXML62.$ResponseXML72.$ResponseXML82.$ResponseXML92.$ResponseXML102.$ResponseXML112."</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grids ----------------------------------------------
if (strcmp($RequestType,"loadGrids") == 0)
{

$ResponseXML= "<Grid>";
$ResponseXML=loadGrid1($ResponseXML);
$ResponseXML=loadGridShades($ResponseXML);//lasantha-to display shades
$ResponseXML=loadGrid2($ResponseXML);
$ResponseXML .= "</Grid>";
 echo $ResponseXML;	
}
//-----load first grid-------------------------------------------------------
function loadGrid1($ResponseXML)
{

	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];

	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];

/*if(($searchYear!="") AND ($searchSerialNo!="")){
	  $sql ="SELECT DISTINCT 
	 productionbundleheader.strCutNo,
	 productionfggpheader.dtmGPDate AS date
	 FROM
	 productionfggpdetails
	 
	 JOIN productionfggpheader ON
	  productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber
	 
   JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial= productionfggpdetails.intCutBundleSerial
   
     WHERE
     productionfggpheader.intGPYear = '".$searchYear."' 
	 AND productionfggpheader.intGPnumber = '".$searchSerialNo."'"; 
	 }
	 else{
	  $sql ="SELECT DISTINCT 
	 productionbundleheader.strCutNo,
	 productionwashreadyheader.dtmDate AS date
	 FROM
	 productionwashreadyheader
   JOIN productionwashreadydetail ON productionwashreadyheader.intWashreadySerial= productionwashreadydetail.intWashreadySerial
   LEFT JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial= productionwashreadydetail.intCutBundleSerial
     WHERE
     productionwashreadyheader.intFactory = '".$factoryID."' 
	 AND productionwashreadyheader.intStyleId = '".$styleID."'"; 
	 }
	 
	 $sql="SELECT distinct
			productionbundleheader.strCutNo,
			productionwashreadyheader.dtmDate as date
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
			Inner Join productionfggpheader ON productionfinishedgoodsreceiveheader.intGPYear = productionfggpheader.intGPYear AND productionfggpheader.intGPnumber = productionfinishedgoodsreceiveheader.dblGatePassNo
			Inner Join productionfggpdetails ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber AND productionfggpheader.intGPYear = productionfggpdetails.intGPYear
			Inner Join productionwashreadydetail ON productionfggpdetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial AND productionfggpdetails.dblBundleNo = productionwashreadydetail.dblBundleNo
			Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial
			Inner Join productionwashreadyheader ON productionwashreadydetail.intWashreadySerial = productionwashreadyheader.intWashreadySerial AND productionwashreadydetail.intWashReadyYear = productionwashreadyheader.intWashReadyYear
			WHERE
			
productionfinishedgoodsreceiveheader.strTComCode =  '$factoryID'  AND
			productionfinishedgoodsreceiveheader.intStyleNo =  '$styleID';";*/
			
	$sql="SELECT DISTINCT
			productionfinishedgoodsreceivedetails.strCutNo,
			productionbundleheader.dtmCutDate
			FROM
			productionfinishedgoodsreceiveheader
			INNER JOIN productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
			INNER JOIN productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionfinishedgoodsreceivedetails.dblBundleNo = productionbundledetails.dblBundleNo
			INNER JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial = productionbundledetails.intCutBundleSerial
			WHERE
			productionfinishedgoodsreceiveheader.strTComCode = '$factoryID' AND
			productionfinishedgoodsreceiveheader.intStyleNo =  '$styleID'
			group by productionfinishedgoodsreceivedetails.strCutNo,productionbundleheader.dtmCutDate;";
//echo $sql;

     global $db;
	  $result = $db->RunQuery($sql);
	  

	 while($row = mysql_fetch_array($result))
	 {

	$ResponseXML .= "<CutNo><![CDATA[" . $row["strCutNo"]  . "]]></CutNo>\n";
	$ResponseXML .= "<Date><![CDATA[" . $row["dtmCutDate"]  . "]]></Date>\n";
	 }
	return $ResponseXML;	
}

//-----------To display shades------------------------------------------------

function loadGridShades($ResponseXML){
	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];
	
	$sql="SELECT DISTINCT
			productionfinishedgoodsreceivedetails.strShade
			FROM
			productionfinishedgoodsreceiveheader
			INNER JOIN 
			productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo 
			AND 
			productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
			WHERE
			productionfinishedgoodsreceiveheader.strTComCode = '$factoryID' AND
			productionfinishedgoodsreceiveheader.intStyleNo =  '$styleID'
			GROUP BY
			productionfinishedgoodsreceivedetails.strShade;";
			
	global $db;
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<gShade><![CDATA[" . $row["strShade"]  . "]]></gShade>\n";
	 }
	return $ResponseXML;	
	
}
//--------end-----------------------------------------------------------------
//-----load second grid-------------------------------------------------------
function loadGrid2($ResponseXML)
{

	//if searching-------------------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];
	$gp=$_GET['gp'];
	$length=0;
	$factoryID = $_GET["factoryID"];
	$styleID = $_GET["styleID"];
	$ArrayCutNos = $_GET["ArrayCutNos"];
	$CutNos = explode(',', $ArrayCutNos) ;
	//$CutNos	= implode(',',$CutNos);
	$ArrayDates = $_GET["ArrayDates"];
	$explodeDates = explode(',',$ArrayDates) ;
	$arrShades    = $_GET['arrshades'];
	$shades		  =  explode('~',$arrShades) ;
	$c=array();
	$length=count($CutNos);
	for($i=0;$i<$length;$i++){
		$c[]="'".trim($CutNos[$i],' ')."'";
	}
	
	$s=array();
	$len=count($shades);
	for($i=0;$i<$len;$i++){
		$s[]="'".trim($shades[$i],' ')."'";
	}
	 /*$sql = "SELECT
	 productionbundledetails.strSize,
	 productionbundledetails.dblBundleNo,
	 productionbundledetails.strNoRange,
	 productionbundledetails.strShade,";
	 
if(($searchYear!="") AND ($searchSerialNo!="")){
	$sql =$sql."productionfggpheader.dtmGPDate,
	productionfggpdetails.intCutBundleSerial,
	productionbundleheader.strCutNo AS strCutNoDetails,
	productionfggpdetails.intGPYear,
	productionfggpdetails.dblQty,
	productionfggpdetails.strRemarks,
	productionwashreadydetail.dblBalQty
	FROM
	productionfggpdetails
	Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionbundledetails ON productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionfggpheader ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber
	Left Join productionfinishedgoodsreceivedetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
	Inner Join productionwashreadydetail ON productionwashreadydetail.intCutBundleSerial = productionfggpdetails.intCutBundleSerial AND productionwashreadydetail.dblBundleNo = productionfggpdetails.dblBundleNo
	WHERE
	productionfggpheader.intGPnumber = '".$searchSerialNo."' 
	AND productionfggpheader.intGPYear = '".$searchYear."'	
	 AND productionwashreadydetail.dblBalQty != '0'"; 

	// $sql=$sql."AND productionfggpheader.dtmGPDate = '".$searchYear."'";
		 
}
else{
	$sql=$sql."productionwashreadydetail.dblBalQty,
	productionwashreadydetail.dblQty,
	 productionwashreadydetail.intCutBundleSerial,
	  productionbundleheader.strCutNo AS strCutNoDetails,
	 productionwashreadydetail.intWashReadyYear
	 FROM
	 productionwashreadyheader
	 JOIN productionwashreadydetail
	 ON productionwashreadyheader.intWashreadySerial=productionwashreadydetail.intWashreadySerial
	   JOIN productionbundleheader ON productionbundleheader.intCutBundleSerial= productionwashreadydetail.intCutBundleSerial
	 JOIN productionbundledetails ON
	 productionbundledetails.dblBundleNo = productionwashreadydetail.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionwashreadydetail.intCutBundleSerial 
	 JOIN productionlineoutdetail ON
	 productionbundledetails.dblBundleNo = productionlineoutdetail.dblBundleNo 
	 AND productionbundledetails.intCutBundleSerial = productionlineoutdetail.intCutBundleSerial 
     WHERE ";
	 if($length<=1){
     $sql=$sql."productionwashreadyheader.intFactory = '".$factoryID."' 
	 AND productionwashreadyheader.intStyleId = '".$styleID."' 
	 AND productionwashreadydetail.dblBalQty != '0'"; 
	 }
	 else if($length>1){
		  for($i = 0 ;$i < $length-1 ; $i ++ ){
		  
			  if($i==0){
				$sql=$sql."productionwashreadyheader.intFactory = '".$factoryID."' 
						AND productionwashreadyheader.intStyleId = '".$styleID."' 
						AND productionwashreadydetail.dblBalQty != '0'"; 
				$sql .=" AND productionbundleheader.strCutNo = '".trim($CutNos[$i],' ')."'"; 
				$sql .=" AND productionwashreadyheader.dtmDate = '".trim($explodeDates[$i],' ')."'";
			  }
			  else{
				$sql=$sql." OR productionwashreadyheader.intFactory = '".$factoryID."' 
						AND productionwashreadyheader.intStyleId = '".$styleID."' 
						AND productionwashreadydetail.dblBalQty != '0'"; 
				$sql .=" AND productionbundleheader.strCutNo = '".trim($CutNos[$i],' ')."'"; 
				$sql .=" AND productionwashreadyheader.dtmDate = '".trim($explodeDates[$i],' ')."'";
			  }
		  }
	  }
  }
		  $sql .=" GROUP BY  productionbundledetails.dblBundleNo"; 
	  
 */
 	 
if(($searchYear!="") AND ($searchSerialNo!="")){
  /*$sql = "SELECT
	 productionbundledetails.strSize,
	 productionbundledetails.dblBundleNo,
	 productionbundledetails.strNoRange,
	 productionbundledetails.strShade,
	 productionfggpheader.dtmGPDate,
	productionfggpdetails.intCutBundleSerial,
	productionbundleheader.strCutNo AS strCutNoDetails,
	productionfggpdetails.intGPYear,
	sum(productionfggpdetails.dblQty) as dblQty,
	productionfggpdetails.strRemarks ,	-- productionwashreadydetail.dblQty
    sum(productionfinishedgoodsreceivedetails.dblBalQty) as dblBalQty
	FROM
	productionfggpdetails
	Inner Join productionbundleheader ON productionbundleheader.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionbundledetails ON productionbundledetails.dblBundleNo = productionfggpdetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfggpdetails.intCutBundleSerial
	Inner Join productionfggpheader ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber
	Left Join productionfinishedgoodsreceivedetails ON productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo AND productionbundledetails.intCutBundleSerial = productionfinishedgoodsreceivedetails.intCutBundleSerial
	Inner Join productionwashreadydetail ON productionwashreadydetail.intCutBundleSerial = productionfggpdetails.intCutBundleSerial AND productionwashreadydetail.dblBundleNo = productionfggpdetails.dblBundleNo
	WHERE
	productionfggpheader.intGPnumber = '".$searchSerialNo."' 
	AND productionfggpheader.intGPYear = '".$searchYear."' "; */
	$sql="SELECT
			p.intGPnumber,
			p.intGPYear,
			p.strCutNo as strCutNoDetails,
			p.strSize,
			p.dblBundleNo,
			p.strRange as strNoRange,
			p.strShade,
			p.dblQty as dblBalQty,
			p.intCutBundleSerial,
			p.dblBalQty,
			p.intStatus,
			p.strRemarks
			FROM productionfggpdetails p
			WHERE
			p.intGPYear = '".$searchYear."'
			AND
			p.intGPnumber = '".$searchSerialNo."' ";
			

}
	 else{
 
 	$sql="SELECT
			productionfinishedgoodsreceiveheader.strTComCode,
			productionfinishedgoodsreceivedetails.strCutNo as strCutNoDetails,
			productionfinishedgoodsreceivedetails.strSize,
			productionfinishedgoodsreceivedetails.dblBundleNo,
			productionfinishedgoodsreceivedetails.strShade,
			sum(productionfinishedgoodsreceivedetails.dblBalQty) as dblBalQty,
			productionfinishedgoodsreceivedetails.intCutBundleSerial,
			productionbundledetails.strNoRange,
			productionfinishedgoodsreceiveheader.dblTransInNo,
			productionfinishedgoodsreceiveheader.intGPTYear,
			sum(productionfinishedgoodsreceivedetails.lngRecQty) as lngRecQty
			FROM
			productionfinishedgoodsreceiveheader
			Inner Join productionfinishedgoodsreceivedetails ON productionfinishedgoodsreceiveheader.dblTransInNo = productionfinishedgoodsreceivedetails.dblTransInNo AND productionfinishedgoodsreceiveheader.intGPTYear = productionfinishedgoodsreceivedetails.intGPTYear
			Inner Join productionbundledetails ON productionfinishedgoodsreceivedetails.intCutBundleSerial = productionbundledetails.intCutBundleSerial AND productionbundledetails.dblBundleNo = productionfinishedgoodsreceivedetails.dblBundleNo
			WHERE ";
			/*if(($searchYear!="") AND ($searchSerialNo!="")){
				$sql.="productionfinishedgoodsreceiveheader.dblTransInNo = '".$searchSerialNo."' 
	AND productionfinishedgoodsreceiveheader.intGPTYear = '".$searchYear."'	
	-- AND productionfinishedgoodsreceiveheader.dblBalQty != '0' ";
			}
			else{*/
				$sql.= "productionfinishedgoodsreceiveheader.strTComCode =  '$factoryID' AND
						productionfinishedgoodsreceiveheader.intStyleNo =  '$styleID' AND
						productionfinishedgoodsreceivedetails.dblBalQty > 0
						 ";
				if($gp!=''){
				$sql.= " AND concat(productionfinishedgoodsreceiveheader.intGPYear,'/',productionfinishedgoodsreceiveheader.dblGatePassNo ) ='$gp' ";	
				}
						 
				if($length > 1){	
				$c=implode(",", $c);
					$sql.=" AND productionfinishedgoodsreceivedetails.strCutNo IN (".substr($c,0,strlen($c)-3).") ";
				}
				
				if($len > 1){	
				$s=implode(",", $s);
					$sql.=" AND TRIM(productionfinishedgoodsreceivedetails.strShade) IN (".substr($s,0,strlen($s)-3).") ";
				}
			}
			if(($searchYear!="") AND ($searchSerialNo!="")){
				$sql .=" GROUP BY p.dblBundleNo order by  p.dblBundleNo ASC;";
			}else{
				$sql .=" GROUP BY  productionbundledetails.dblBundleNo order by  productionbundledetails.dblBundleNo ASC;"; 
			}
			//echo $sql;

     global $db;
	  $result = $db->RunQuery($sql);
	 // echo $sql;
	  $remarks = '';
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<CutNo1><![CDATA[" . $row["strCutNoDetails"]  . "]]></CutNo1>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<Bundle><![CDATA[" . $row["dblBundleNo"]  . "]]></Bundle>\n";
		$ResponseXML .= "<Range><![CDATA[" . $row["strNoRange"]  . "]]></Range>\n";
		$ResponseXML .= "<Shade><![CDATA[" . $row["strShade"]  . "]]></Shade>\n";
		$ResponseXML .= "<TransInNo><![CDATA[" . $row["dblTransInNo"]  . "]]></TransInNo>\n";
		$ResponseXML .= "<GPTYear><![CDATA[" . $row["intGPTYear"]  . "]]></GPTYear>\n";
		
	if(($searchYear!="") AND ($searchSerialNo!="")){
		$date=$row["dtmGPDate"];
		$ArrayDateDesc = explode('-',$date);
		$date = $ArrayDateDesc[2]."/".$ArrayDateDesc[1]."/".$ArrayDateDesc[0];
		if($row["dblBalQty"]==0){
			$bal=0;
		} 
		else $bal=$row["dblBalQty"];
		
		$ResponseXML .= "<WashQty><![CDATA[" . ($bal+$row["dblQty"]) . "]]></WashQty>\n";
		$ResponseXML .= "<GPQty><![CDATA[" . ($row["dblQty"])  . "]]></GPQty>\n";
		$remarks = $row["strRemarks"];
		
		}
		else{
		$date="";
		$ResponseXML .= "<WashQty><![CDATA[" . $row["dblBalQty"]  . "]]></WashQty>\n";
		$ResponseXML .= "<GPQty><![CDATA[" . $row["dblBalQty"]  . "]]></GPQty>\n";

		}
		$ResponseXML .= "<CutBundserial><![CDATA[" . $row["intCutBundleSerial"]  . "]]></CutBundserial>\n";
		$ResponseXML .= "<remarks><![CDATA[" . $remarks  . "]]></remarks>\n";
	 }
	return $ResponseXML;	
 
}
//----------------save finished goods gate pass header-------------------------------------------------------
if (strcmp($RequestType,"SaveFinishGoodGPHeader") == 0)
{
	
	$GPDateTemp = $_GET["GPDate"];
	$GPDateArray		= explode('/',$GPDateTemp);
	$GPDate = $GPDateArray[2]."-".$GPDateArray[1]."-".$GPDateArray[0];
	
	$GPYear = $_GET["GPYear"];
	$fromFactory = $_GET["fromFactory"];
	$toFactory = $_GET["toFactory"];
	$styleID = $_GET["styleID"];
	$totBalQty = $_GET["totBalQty"];
	$Status = $_GET["Status"];
	$totQty = $_GET["totQty"];
	$vehicleNo = $_GET["vehicleNo"];
	$Remarks  = $_GET['Remarks'];
	//--if searching-------
	$searchYear = $_GET["searchYear"];
	$searchSerialNo = $_GET["searchSerialNo"];
	//--------------------
	
	 if (($searchYear!="") AND ($searchSerialNo!=""))
	 {
	    $GatePassNo=$searchSerialNo;	
	    $GPYear=$searchYear;
		
	 	$result=UpdateProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$vehicleNo,$Remarks);
	 }
	 else
	 {
	   $GatePassNo=SelectMaxGatePassNo();	
	   $searchYear = date("Y");	
	  $result=SaveProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$totQty,$totBalQty,$Status,$vehicleNo,$Remarks);
	   
	 }	 
	
	   
	 $ResponseXML .= "<Result>";
	 if($result!=""){
	 $ResponseXML .= "<Save><![CDATA[True]]></Save>\n";
	 }
	 else{
	 $ResponseXML .= "<Save><![CDATA[False]]></Save>\n";
	 }
	 $ResponseXML .= "<GatePassNo><![CDATA[" . $GatePassNo  . "]]></GatePassNo>\n";
	  $ResponseXML .= "<GPyear><![CDATA[" . $searchYear  . "]]></GPyear>\n";
	  
	 $ResponseXML .= "</Result>";	 
	 
	echo $ResponseXML;
}
//-------update header file-----------------------------------------------------------------------
function UpdateProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$vehicleNo,$Remarks)
{
	global $db;
	$sql= "UPDATE productionfggpheader SET dtmGPDate='$GPDate', strVehicleNo='$vehicleNo',strRemarks='$Remarks' WHERE strFromFactory='$fromFactory' AND strToFactory='$toFactory' AND intStyleId='$styleID' AND intGPYear='$GPYear' AND intGPnumber='$GatePassNo';";
	return $db->RunQuery($sql);
}

//-------retrieve existing  intLineOutputSerial & update it by adding 1---------------------------------------
function SelectMaxGatePassNo(){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sql1="SELECT MAX(intFinishGoodGPNo) FROM syscontrol where intCompanyID='$intCompanyId'";
	$result= $db->RunQuery($sql1);

	$row = mysql_fetch_array($result);
	$old= $row["MAX(intFinishGoodGPNo)"];
	$newSerial=$old+1;
	
	updateSysControl($old,$newSerial);
	return $old; 
}
//--------update syscontrol for intWashreadySerial(by Adding 1)----------------------
function updateSysControl($old,$newSerial){
global $db;
$intCompanyId =	$_SESSION["FactoryID"];
	$sqls= "UPDATE syscontrol SET intFinishGoodGPNo='$newSerial' WHERE intFinishGoodGPNo='$old' and intCompanyID='$intCompanyId'";
	 $db->executeQuery($sqls);
}
//-------save new record for header----------------------------------------------------------------------------------------
function SaveProductionfggpheader($GatePassNo,$fromFactory,$toFactory,$styleID,$GPYear,$GPDate,$totQty,$totBalQty,$Status,$vehicleNo,$Remarks)
{

	global $db;
	   $sql= "INSERT INTO productionfggpheader(intGPnumber ,strFromFactory ,strToFactory ,intStyleId, intGPYear ,dtmGPDate ,dblTotQty, dblBalQty, intStatus,strVehicleNo,strRemarks,intUser) VALUES($GatePassNo, $fromFactory, $toFactory, $styleID, $GPYear, '$GPDate', $totQty, $totBalQty, 1,'$vehicleNo','$Remarks','".$_SESSION['UserID']."')";
	return $db->RunQuery($sql);
}
//----------------Save finished goods gate pass Details---------------------------------
if (strcmp($RequestType,"SaveFinishGoodGPDetails") == 0)
{
	$GatePassNo = $_REQUEST["GatePassNo"];
	$year = $_REQUEST["year"];
	$factory = $_REQUEST["factory"];
	
	$CutBundleSerial = $_REQUEST["CutBundleSerial"];
	$BundleNo = $_REQUEST["BundleNo"];
	$Qty = $_REQUEST["Qty"];
	$serial=$_GET['serial'];
	$po	=	$_GET['po'];
	$BalQty = $_REQUEST["BalQty"];
	$ArrayCutNo = $_REQUEST["CutNo"];
	$ArraySize = $_REQUEST["Size"];
	$ArrayRange = $_REQUEST["Range"];
	$ArrayShade = $_REQUEST["Shade"];
	$ArrRemarks = $_REQUEST["Remarks"];
	$exe=$_REQUEST['r'];
	$totQty=0;
	$totBalQty=0;
	$x=0;
	//echo $CutNo.",".$Size.",".$Range.",".$Shade.",".$Remarks;
	 //if $ExistQty !=0 means already saved record and then shd update.
	 $AllreadyExist = false;
	 $ExistQty = CheckExistDetails($GatePassNo,$year,trim($CutBundleSerial,' '),trim($BundleNo,' '));
	 
	 if ($ExistQty != "")
	 {
		$resultDetail=UpdateProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$Qty,trim($ArrayCutNo,' '),trim($ArraySize,' '),trim($ArrayRange,' '),trim($ArrayShade,' '),$ExistQty,$Remarks);
	 }
	 else{
	   $ExistQty=0;
	   $resultDetail=SaveProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$Qty,trim($ArrayCutNo,' '),trim($ArraySize,' '),trim($ArrayRange,' '),trim($ArrayShade,' '),$Remarks);
	 }
	 
		$totQty += $Qty;
		$totBalQty += $BalQty;
		
		//new
		updateProductionFinshhgoddReceiveHeaderBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year,$serial,$po);

		$wipQty=$Qty-$ExistQty;
		update_production_wip($factory,$CutBundleSerial,"intFGgatePass",$wipQty);		 
	 
		//Update Productionfggpheader for totQty & totBalQty------
		updateProductionfggpheaderQty($GatePassNo,$year,$totQty,$totBalQty);	
	//----------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------
	
		$ResponseXML = "<data>";
		$ResponseXML .= "<result><![CDATA[" . $resultDetail  . "]]></result>\n";
		$ResponseXML .= "</data>";
		
			echo $ResponseXML;	
}

//BEGIN - 04-11-2011
if($RequestType=="URLValidateStock")
{
$ResponseXML 	= "<XMLValidateStock>";
$StyleId		= $_GET["StyleId"];
$totGpQty		= round($_GET["TotGpQty"],2);
$stockQty		= round(GetStockQty($StyleId,$intCompanyId),2);
$variance 		= round($stockQty-$totGpQty,2);
if($stockQty<$totGpQty)
{
	$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	$ResponseXML .= "<Message><![CDATA[GatePass Qty exceed Stock Qty\nStock Qty = $stockQty\nGatePass Qty = $totGpQty\nVariance = $variance]]></Message>\n";
}
else
{
	$ResponseXML .= "<Result><![CDATA[Ture]]></Result>\n";
}
$ResponseXML   .= "</XMLValidateStock>";
echo $ResponseXML;
}
//END - 04-11-2011

//-----check whether record existing in details file-------------------------------------------------------
function CheckExistDetails($GatePassNo,$year,$CutBundleSerial,$BundleNo)
{
	global $db;
	 $sql= "select * from productionfggpdetails where intGPnumber = ". $GatePassNo ." AND intCutBundleSerial = '". $CutBundleSerial ."' AND dblBundleNo = '". $BundleNo ."'";
	$result2= $db->RunQuery($sql);
	$row = mysql_fetch_array($result2);
	$exitQty = $row["dblQty"];
	return $exitQty;
}
//------Update records in details file------------------------------------------------------------------
function UpdateProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$BalQty,$CutNo,$Size,$Range,$Shade,$ExistQty,$remarks)
{
	global $db;
	
    $sql= "UPDATE productionfggpdetails SET dblQty=$Qty, strRemarks='$remarks' WHERE intGPnumber = ". $GatePassNo ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . "";
     $db->RunQuery($sql);
	 
   $sql2= "UPDATE productionfggpdetails SET dblBalQty=(dblBalQty+'$Qty'-'$ExistQty')  WHERE intGPnumber = ". $GatePassNo ." AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . "";
     return $db->RunQuery($sql2);
}
//-----Save Record in details file------------------------------------------------------------------
function SaveProductionfggpdetails($GatePassNo,$year,$CutBundleSerial,$BundleNo,$Qty,$BalQty,$CutNo,$Size,$Range,$Shade,$remarks)
{
	global $db;
	 $sql2= "select MAX(dblBalQty) from productionfggpdetails where intGPnumber= ". $GatePassNo ." AND intGPYear='$year' AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . " ";
	 
	// die($sql2);
	// echo $sql2;
	/*SELECT
Max(productionfggpdetails.dblBalQty)
FROM
productionfggpdetails
INNER JOIN productionfggpheader ON productionfggpheader.intGPnumber = productionfggpdetails.intGPnumber AND productionfggpdetails.intGPYear = productionfggpheader.intGPYear
WHERE
productionfggpdetails.intGPnumber = 500002 AND
productionfggpdetails.intGPYear = '2011' AND
productionfggpdetails.intCutBundleSerial = 405209 AND
productionfggpdetails.dblBundleNo = 12 AND
productionfggpheader.strFromFactory = 5*/


	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
	 $MaxbalQty = $row["MAX(dblBalQty)"]+$BalQty;
	
	
	 $sql= "INSERT INTO productionfggpdetails(intGPnumber,intGPYear,intCutBundleSerial,dblBundleNo,dblQty,dblBalQty,strCutNo,strSize,strRange,strShade,strRemarks,intStatus) VALUES($GatePassNo, $year, $CutBundleSerial,$BundleNo, $Qty, $BalQty, '$CutNo', '$Size', '$Range', '$Shade','$remarks','2')";
     $res1= $db->RunQuery($sql);
	 	 
	 
      $sql3= "UPDATE productionfggpdetails SET  dblBalQty= ". $MaxbalQty ." where intGPnumber= ". $GatePassNo ."  AND intGPYear='$year' AND intCutBundleSerial = ". $CutBundleSerial ." AND dblBundleNo= ". $BundleNo . " ";
	 // echo $sql3;
	return $db->RunQuery($sql3);
	 
}
//------------------------------------------------------------------------------------------
/*function updateWashReadydetailForBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year){
global $db;
	
	 $sql2= "select * from productionwashreadydetail where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	$result2 = $db->RunQuery($sql2);
	$row = mysql_fetch_array($result2);
		$balQty = $ExistQty+$row["dblBalQty"]-$Qty;
	
	  $sql= "UPDATE productionwashreadydetail SET dblBalQty='$balQty' where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	 	$db->executeQuery($sql);
}*/

//update productionfinshhgoddreceivedetails balQty

function updateProductionFinshhgoddReceiveHeaderBalQty($CutBundleSerial,$BundleNo,$ExistQty,$Qty,$year,$serial,$po){
global $db;
	$gp=split('/',$serial);
	$sql1= "select * from productionfinishedgoodsreceivedetails where intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."' and dblTransInNo='".$gp[1]."' and intGPTYear='".$gp[0]."'";
	$sql2="update  productionfinishedgoodsreceiveheader set dblBalQty=dblBalQty-$Qty  where intStyleNo='$po' and dblTransInNo='".$gp[1]."' and intGPTYear='".$gp[0]."';";
	// echo $sql2; ,intStatus='2'
	$db->RunQuery($sql2);
	$result1 = $db->RunQuery($sql1);
	$row = mysql_fetch_array($result1);
		$balQty = $ExistQty+$row["dblBalQty"]-$Qty;
	
	$sql= "update productionfinishedgoodsreceivedetails set dblBalQty='$balQty' where dblTransInNo='".$gp[1]."' and intGPTYear='".$gp[0]."' and intCutBundleSerial= '". $CutBundleSerial ."' AND dblBundleNo= '". $BundleNo ."'";
	 	$db->executeQuery($sql);
}

//--------Update productionlineoutputheader for total line output Quantities------------------------
function updateProductionfggpheaderQty($GatePassNo,$year,$totQty,$totBalQty){
global $db;
	
	 $sql2= "select * from productionfggpdetails where intGPnumber = '". $GatePassNo . "' AND intGPYear= '". $year ."'";
	$result2 = $db->RunQuery($sql2);
	$k=0;
	 while($row = mysql_fetch_array($result2))
  	 {	  
		 if($k==0){
			$totQty=0;
			$totBalQty=0;
		 }
		$totQty += $row["dblQty"];
		$totBalQty += $row["dblBalQty"];
		$k++;
	 }
	
	$sql= "UPDATE productionfggpheader SET dblTotQty='$totQty',dblBalQty='$totBalQty' where intGPnumber = '". $GatePassNo . "' AND intGPYear= '". $year ."'";
	 	$db->executeQuery($sql);
}
//----------------------------------------------------------------------------------------------------------
function getBundleAndBundleSerials($styleId,$wrFac,$field){
	global $db;
	$sql="select distinct wrd.`$field`  from productionwashreadyheader wrh 
	inner join productionwashreadydetail wrd on wrd.intWashreadySerial=wrh.intWashreadySerial and wrd.intWashReadyYear=wrh.intWashReadyYear
	where wrh.intStyleId='$styleId' and wrh.intFactory='$wrFac';";
			$res=$db->RunQuery($sql);
			$No=array();
			while($row=mysql_fetch_array($res)){
				$No[]	= $row[$field];
				
			}
			//print_r($No);
			return $No;
}
function getCancelStatus($gpYear,$gpNo){
	global $db;
	$sql="SELECT p.dblGatePassNo,p.intGPYear FROM productionfinishedgoodsreceiveheader AS p WHERE p.intGPYear='$gpYear' AND p.dblGatePassNo='$gpNo';";
	$res=$db->RunQuery($sql);
	$nR=mysql_num_rows($res);
	return $nR;
	
}

function GetStockQty($StyleId,$companyId)
{
global $db;
$qty = 0;
	$sql="select COALESCE(sum(dblQty),0) as RCVDQty from was_stocktransactions where intStyleId='$StyleId' and intCompanyId='$companyId' group by intStyleId,strColor,intCompanyId;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty	= $row["RCVDQty"];
	}
return $qty;
}
?>