<?php

session_start();
include "Connector.php";
//include "Header.php";
$xml = simplexml_load_file("${backwardseperator}config.xml");
$headerPub_AllowOrderStatus = $xml->SystemSettings->AllowOrderStatus;
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$companyId  	= $_SESSION["FactoryID"];
//$db =new DBManager();
//$userID="1";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"SRNo") == 0)
{
	 $ResponseXML = "";
	  $ResponseXML .= "<ScList>\n";
	 $StyleID=$_GET["StyleID"];
	global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 
	 
	 $SQL="SELECT DISTINCT S.intSRNO,MR.intStyleId FROM materialratio MR INNER JOIN orders O ON MR.intStyleId = O.intStyleId inner join specification S on S.intStyleId=O.intStyleId where O.intStatus = '$arrstatus[0]' or O.intStatus = '$arrstatus[1]' or O.intStatus = '$arrstatus[2]' ";
	 
	 if($StyleID != 'Select One')
	 	$SQL .= "and  O.strStyle = '$StyleID' ";
		
	$SQL .= "order by S.intSRNO desc ";
	// $SQL = "SELECT intSRNO FROM specification s where  intOrdComplete='0';";
	
	 $result = $db->RunQuery($SQL);
	 $str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	
	 while($row = mysql_fetch_array($result))
  	 {
		$str .= "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
                       
	 }
	 
	 $ResponseXML .= "<SCno><![CDATA[" . $str . "]]></SCno>\n";
	 $ResponseXML .= "</ScList>";
	 echo $ResponseXML;
	
}

function getSRNumber($styleID)
{
global $db;
$sql="SELECT intSRNO FROM specification s where intStyleId='".$styleID."' AND intOrdComplete='0';";
$result = $db->RunQuery($sql);
  while($row = mysql_fetch_array($result))
  	 {
	 	$SCNO = $row["intSRNO"];
	 }
	 
	 return $SCNO;
}

if (strcmp($RequestType,"BuyerPO") == 0)
{
	 $ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<BuyerPO>\n";
	 
	 
	 $result=getBuyerPO($StyleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 //$ResponseXML .= "<PO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PO>\n";
		 $buyerPoName = '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerPoName($row["strBuyerPONO"],$StyleID);
			
		 $ResponseXML .= "<PO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PO>\n";
		 $ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
                       
	 }
	 $ResponseXML .= "</BuyerPO>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"getStyleID") == 0)
{
	 $ResponseXML = "";
	
	 $ResponseXML .= "<StyleID>\n";
	 
	 global $db;
	 global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 
	 $sql = "SELECT DISTINCT orders.strStyle
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId AND 
(orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]') order by orders.strStyle";

	/*$sql = "SELECT DISTINCT orders.strStyle,materialratio.intStyleId,s.intSRNO 
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId 
inner join specification s on s.intStyleId = orders.intStyleId and s.intStyleId = materialratio.intStyleId
where (orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]')";*/
	 $result=$db->RunQuery($sql);
	 $str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	 while($row = mysql_fetch_array($result))
  	 {
		 /*$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		 $ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";
*/      
		$str .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;                
	 }
	 
	 $ResponseXML .= "<StyleName><![CDATA[" . $str  . "]]></StyleName>\n";
	 $ResponseXML .= "</StyleID>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"getStyleNOS") == 0)
{
	 $ResponseXML = "";
	 $styleSC=$_GET["styleSC"];
	 $ResponseXML .= "<StyleSC>\n";
	 
	 global $db;
	 global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 
	 $sql = "SELECT DISTINCT orders.strStyle
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId AND 
(orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]') ";
if($styleSC != 'Select One')
		$sql .= " and orders.intStyleId = '$styleSC' ";
	
	$sql .= "order by orders.strStyle";	
//echo $sql;
	/*$sql = "SELECT DISTINCT orders.strStyle,materialratio.intStyleId,s.intSRNO 
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId 
inner join specification s on s.intStyleId = orders.intStyleId and s.intStyleId = materialratio.intStyleId
where (orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]')";*/
	 $result=$db->RunQuery($sql);
	 //$str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	 while($row = mysql_fetch_array($result))
  	 {
		 /*$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		 $ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";
*/      
		$str .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;                
	 }
	 
	 $ResponseXML .= "<StyleNSC><![CDATA[" . $str  . "]]></StyleNSC>\n";
	 $ResponseXML .= "</StyleSC>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"loadOrderNoDet") == 0)
{
	 $ResponseXML="";
	$ResponseXML.="<MrnOrderMain>";
	 global $db;
	 global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 
	 $sql = "SELECT DISTINCT orders.strOrderNo,materialratio.intStyleId 
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId AND 
(orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]') order by strOrderNo";
	
	$str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	
		$str .="<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>"; 
	}	
	$ResponseXML .= "<OrderNo><![CDATA[" . $str  . "]]></OrderNo>\n";
	$ResponseXML.="</MrnOrderMain>";
	echo $ResponseXML;
	
}
else if (strcmp($RequestType,"loadOrderNoStylewise") == 0)
{
	 $ResponseXML="";
	$ResponseXML.="<MrnOrderMain>";
	$StyleID = $_GET["StyleID"];
	 
	 global $db;
	 global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 
	 $sql = "SELECT DISTINCT orders.strOrderNo,materialratio.intStyleId 
FROM materialratio INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId AND 
(orders.intStatus = '$arrstatus[0]' or orders.intStatus = '$arrstatus[1]' or orders.intStatus = '$arrstatus[2]')";

	if($StyleID != 'Select One')
		$sql .= " and orders.strStyle = '$StyleID' ";
	
	$sql .= "order by orders.strOrderNo";	
	$str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	
	$str .="<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>"; 
	}
	
	 $ResponseXML .= "<OrderNolist><![CDATA[" . $str  . "]]></OrderNolist>\n";
	$ResponseXML.="</MrnOrderMain>";
	echo $ResponseXML;
	
}
else if (strcmp($RequestType,"getQty") == 0)
{
	 $ResponseXML = "";
	$styleID=$_GET["StyleID"];
	$buyerPO=$_GET["buyerPO"];
	$scNo=$_GET["scNo"];
	 $ResponseXML .= "<qtyM>\n";
	

	 global $db;
	 $sql="SELECT DISTINCT s.dblQuantity FROM specification s INNER JOIN materialratio m ON m.intStyleId=s.intStyleId where s.intStyleId='$styleID' AND m.strBuyerPONO='$buyerPO';";

	 $result=$db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<qty><![CDATA[" . $row["dblQuantity"]  . "]]></qty>\n";
                       
	 }
	 $ResponseXML .= "</qtyM>";
	 echo $ResponseXML;
	
}
else if(strcmp($RequestType,"MainCat") == 0)
{
$ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<MainCat>\n";
	 
	 $result=getMainCat($StyleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Catname><![CDATA[" . $row["strDescription"]  . "]]></Catname>\n";
		 $ResponseXML .= "<CatID><![CDATA[" . $row["intID"]  . "]]></CatID>\n";
                       
	 }
	 $ResponseXML .= "</MainCat>";
	 echo $ResponseXML;
}
else if (strcmp($RequestType,"SubCat") == 0)
{
	 $ResponseXML = "";
	$styleID=$_GET["StyleID"];
	$mainCatID=$_GET["mainCatID"];
	
	 $ResponseXML .= "<SubCat>\n";
	
	 global $db;
	 $sql="SELECT DISTINCT a.StrCatName,a.intSubCatNo FROM specificationdetails s INNER JOIN matitemlist m ON s.strMatDetailID=m.intItemSerial INNER JOIN matsubcategory a ON a.intSubCatNo=m.intSubCatID where s.intStyleId='$styleID' AND m.intMainCatID='$mainCatID' order by a.StrCatName;";
	//echo $sql; 
	 $result=$db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<SubCatName><![CDATA[" . $row["StrCatName"]  . "]]></SubCatName>\n";
		 $ResponseXML .= "<SubCatID><![CDATA[" . $row["intSubCatNo"]  . "]]></SubCatID>\n";
                       
	 }
	 $ResponseXML .= "</SubCat>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"getMatInfo") == 0)
{
	global $db;
	$ResponseXML = "";
	$styleID=$_GET["styleID"];
	$mainCatID=$_GET["mainCatID"];
	$subCatID=$_GET["subCatID"];
	$buyerPo=$_GET["buyerPO"];
	$scno=$_GET["scNo"];
	$storeID = $_GET["store"];
	$ResponseXML .= "<MatInfo>\n";
	
	//get material ratio details
	$sql = " SELECT intMainCatID,matitemlist.strItemDescription,materialratio.strColor,
	        materialratio.strSize,materialratio.strMatDetailID,materialratio.dblQty as MatratioQty,
			specificationdetails.sngConPc,specificationdetails.sngWastage, specificationdetails.strUnit, materialratio.strBuyerPONO
			FROM materialratio INNER JOIN matitemlist ON matitemlist.intItemSerial=materialratio.strMatDetailID 
			INNER JOIN specification  ON 
			specification.intStyleId=materialratio.intStyleId INNER JOIN specificationdetails ON 
			specification.intStyleId=specificationdetails.intStyleId  
			AND materialratio.strMatDetailID = specificationdetails.strMatDetailID 
		   WHERE materialratio.intStyleId='$styleID' "; 
		   
		   # =========================================================
		   # Comment On  - 2015/12/22
		   # Commment By - Nalin Jayakody
		   # Remove material ratio status from MRN
		     // and materialratio.intStatus = 1
		   # ========================================================
		   
		   #=========================================================
		   # Comment On  - 2015/10/30
		   # Commment By - Nalin Jayakody
		   # Comment For - Remove buyer po filtering from where clause and add intStatus to the where clause
		   #               Retrievew buyer po number from the list
		   #=========================================================
		   	//AND materialratio.strBuyerPONO='$buyerPo'  
		   #=========================================================
			
	if ($mainCatID!=0)
	 {
	 	$sql .= " AND matitemlist.intMainCatID='$mainCatID'";
	 }
	 if ($subCatID!=0)
	 {
	 	$sql .=  " AND matitemlist.intSubCatID='$subCatID' ";
	 }
	// $sql .= " group by intMainCatID,matitemlist.strItemDescription,materialratio.strColor,materialratio.strSize,  	materialratio.strMatDetailID ";
	// echo $sql;
	 $result=$db->RunQuery($sql);
	
	 while($row = mysql_fetch_array($result))
  	 {
		$MatID 			= $row["strMatDetailID"];
		$conPC 			= $row["sngConPc"];
		$wastage 		= $row["sngWastage"];
		$description	= $row["strItemDescription"];
	 	$MatratioQty 	= $row["MatratioQty"];
		
		$year			= date("Y");

		$color			= $row["strColor"];
		$size			= $row["strSize"];
		#=======================================
		# Add On - 2015/10/30
		# Add By - Nalin Jayakody
		# Adding - Add buyer po number to the variable
		#=======================================
		$buyerPONo		= $row["strBuyerPONO"];
		#=======================================
	
		$qty			= $MatratioQty;
		
		#=====================================================================
		/* Check if stock balance exist in given style, item, color & size
		 If only stock balance exist then display the row items
		*/
		#=====================================================================
		$_dblStockBal = 0;
		$strSql = " select round(sum(dblQty),2) as stockQty from stocktransactions
					where intStyleId='$styleID' and strBuyerPoNo='$buyerPONo' and strColor='$color'
					and strSize='$size' and intMatDetailId='$MatID' and strMainStoresID='$storeID'
					having sum(dblQty)>=0";
		//echo $strSql;
		$resStockBal = $db->RunQuery($strSql);
		//$resCount = mysql_num_rows($resStockBal);
		
		while($rowStockBal = mysql_fetch_array($resStockBal)){
			$_dblStockBal = $rowStockBal["stockQty"];
		}
		
		if($_dblStockBal>0){
		
		#=====================================================================
		//check Stock availability of the item
				
			$sqlStock = " select intGrnNo,intGrnYear,round(sum(dblQty),2) as stockQty,strGRNType from stocktransactions
						where intStyleId='$styleID' and strBuyerPoNo='$buyerPONo' and strColor='$color'
						and strSize='$size' and intMatDetailId='$MatID' and strMainStoresID='$storeID'
						group by intGrnNo,intGrnYear,strGRNType
						having sum(dblQty)>=0";
						
			$resultStock=$db->RunQuery($sqlStock);
			$recCount = mysql_num_rows($resultStock);
			
			$trimInspected =1;
			
			if($recCount >0)
			{
				 while($rowSt = mysql_fetch_array($resultStock))
				 {	
					$intGrnNo = $rowSt["intGrnNo"];
					$intGrnYear = $rowSt["intGrnYear"];
					$stockQty = $rowSt["stockQty"];
					$GrnType = $rowSt["strGRNType"];
					$invoiceNo = getInvoiceNo($intGrnNo,$intGrnYear,$GrnType);
					//get GRN excess Qty 
					$grnExQty = getGRNExQty($intGrnNo,$intGrnYear,$styleID,$buyerPo,$color,$size,$MatID);
					$qty += $grnExQty;
					
					//get issue qty
					$issueQty=getIssueQty($styleID,$year,$buyerPONo,$MatID,$color,$size,"Qty",$storeID,$intGrnNo,$intGrnYear,$GrnType) * -1;	
					$mrnReq=getMRNQuantity($styleID,$buyerPONo,$MatID,$color,$size,$storeID,$intGrnNo,$intGrnYear,$GrnType);
					
					$approvedQtyArr=getNotApprovedQty($styleID,$buyerPONo,$MatID,$color,$size,$intGrnNo,$intGrnYear);
					$approvedQty=$approvedQtyArr[0];
					$rejectQty=$approvedQtyArr[1];
					//check mrn raised to avoid geting trading apparel transaction records(STNF/GRN)
					if($stockQty != 0 || $mrnReq !=0)
					{
						switch($GrnType)
						{
							case 'S':
							{
								$strGRNType = 'Style';
								break;
							}
							case 'B':
							{
								$strGRNType = 'Bulk';
								break;
							}							
						}
					}
						$ResponseXML .= "<Item><![CDATA[" .$description. "]]></Item>\n";
						$ResponseXML .= "<color><![CDATA[" . $color  . "]]></color>\n";
						$ResponseXML .= "<size><![CDATA[" . $size  . "]]></size>\n";
						$ResponseXML .= "<qty><![CDATA[" .round($qty,2). "]]></qty>\n";
						$ResponseXML .= "<MatDetailID><![CDATA[" . $MatID . "]]></MatDetailID>\n";
						$ResponseXML .= "<MRNRaised><![CDATA[" .round($mrnReq,2). "]]></MRNRaised>\n";
						$ResponseXML .= "<Issued><![CDATA[" .round($issueQty,2). "]]></Issued>\n";
						//$ResponseXML .= "<issueBalance><![CDATA[" .round($issueBalance,2). "]]></issueBalance>\n";
						$ResponseXML .= "<stockBalance><![CDATA[" .round($stockQty,2). "]]></stockBalance>\n";
						$ResponseXML .= "<ConPC><![CDATA[" .$conPC. "]]></ConPC>\n";
						$ResponseXML .= "<Wastage><![CDATA[" .round($wastage,2). "]]></Wastage>\n";
						$ResponseXML .= "<Approved><![CDATA[" .round($approvedQty,2). "]]></Approved>\n";
						$ResponseXML .= "<NotApproved><![CDATA[" .round($rejectQty,2). "]]></NotApproved>\n";
						$ResponseXML .= "<TrimInspected><![CDATA[" .$trimInspected. "]]></TrimInspected>\n";
						$ResponseXML .= "<GRNno><![CDATA[" .$intGrnNo. "]]></GRNno>\n";
						$ResponseXML .= "<grnYear><![CDATA[" .$intGrnYear. "]]></grnYear>\n";	
						$ResponseXML .= "<strGRNType><![CDATA[" .$strGRNType. "]]></strGRNType>\n";
						$ResponseXML .= "<strGRNTypeId><![CDATA[" .$GrnType. "]]></strGRNTypeId>\n";
						$ResponseXML .= "<invoiceNo><![CDATA[" .$invoiceNo. "]]></invoiceNo>\n";
						$ResponseXML .= "<intMainCatID><![CDATA[" .$row["intMainCatID"]. "]]></intMainCatID>\n";
						$ResponseXML .= "<strUOM><![CDATA[" .$row["strUnit"]. "]]></strUOM>\n";
						$ResponseXML .= "<strBuyerPO><![CDATA[" .$row["strBuyerPONO"]. "]]></strBuyerPO>\n";
						
				 }
			}
			else
			{
				$mrnReq=0;
				$issueQty =0;
				$stockQty=-100;
				$approvedQty=0;
				$rejectQty=0;
				$intGrnNo='';
				$intGrnYear = '';
				$strGRNType='';
				$GrnType = '';
				$invoiceNo = '';
				$ResponseXML .= "<Item><![CDATA[" .$description. "]]></Item>\n";
					$ResponseXML .= "<color><![CDATA[" . $color  . "]]></color>\n";
					$ResponseXML .= "<size><![CDATA[" . $size  . "]]></size>\n";
					$ResponseXML .= "<qty><![CDATA[" .round($qty,2). "]]></qty>\n";
					$ResponseXML .= "<MatDetailID><![CDATA[" . $MatID . "]]></MatDetailID>\n";
					$ResponseXML .= "<MRNRaised><![CDATA[" .round($mrnReq,2). "]]></MRNRaised>\n";
					$ResponseXML .= "<Issued><![CDATA[" .round($issueQty,2). "]]></Issued>\n";
					//$ResponseXML .= "<issueBalance><![CDATA[" .round($issueBalance,2). "]]></issueBalance>\n";
					$ResponseXML .= "<stockBalance><![CDATA[" .round($stockQty,2). "]]></stockBalance>\n";
					$ResponseXML .= "<ConPC><![CDATA[" .$conPC. "]]></ConPC>\n";
					$ResponseXML .= "<Wastage><![CDATA[" .round($wastage,2). "]]></Wastage>\n";
					$ResponseXML .= "<Approved><![CDATA[" .round($approvedQty,2). "]]></Approved>\n";
					$ResponseXML .= "<NotApproved><![CDATA[" .round($rejectQty,2). "]]></NotApproved>\n";
					$ResponseXML .= "<TrimInspected><![CDATA[" .$trimInspected. "]]></TrimInspected>\n";
					$ResponseXML .= "<GRNno><![CDATA[" .$intGrnNo. "]]></GRNno>\n";
					$ResponseXML .= "<grnYear><![CDATA[" .$intGrnYear. "]]></grnYear>\n";	
					$ResponseXML .= "<strGRNType><![CDATA[" .$strGRNType. "]]></strGRNType>\n";
					$ResponseXML .= "<strGRNTypeId><![CDATA[" .$GrnType. "]]></strGRNTypeId>\n";
					$ResponseXML .= "<invoiceNo><![CDATA[" .$invoiceNo. "]]></invoiceNo>\n";
					$ResponseXML .= "<intMainCatID><![CDATA[" .$row["intMainCatID"]. "]]></intMainCatID>\n";
					$ResponseXML .= "<strUOM><![CDATA[" .$row["strUnit"]. "]]></strUOM>\n";
					$ResponseXML .= "<strBuyerPO><![CDATA[" .$row["strBuyerPONO"]. "]]></strBuyerPO>\n";
			}
		}
		
		//start 2010-11-02 get grnQty with excess
		/*$sql = "SELECT dblQty FROM materialratio WHERE intStyleId = '$styleID' AND strMatDetailID = '$MatID' AND  strColor = '$color' AND strSize = '$size' AND strBuyerPONO = '$buyerPo'";
		$resultitems=$db->RunQuery($sql);
		while($rowitems = mysql_fetch_array($resultitems))
		{
			$qty = $rowitems["dblQty"];
				$sql_1="SELECT  COALESCE(SUM(dblExcessQty),0)AS excessQty  FROM grndetails WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' AND intMatDetailID='$MatID' AND strColor='$color' AND strSize='$size'";
				$result_1=$db->RunQuery($sql_1);
				$row_1=mysql_fetch_array($result_1);
				$excessQty	= $row_1["excessQty"];
			$qty += $excessQty;
			break;
		}*/
	
		
	
	//$stockQty=getStockqty($styleID,$buyerPo,$MatID,$color,$size,$storeID,$grnNo,$grnYear);
	
	
	//$issueQty=getIssueQty($styleID,$year,$buyerPo,$MatID,$color,$size,"Qty",$storeID,$grnNo,$grnYear) * -1;
//	$mrnReq=getMRNQuantity($styleID,$buyerPo,$MatID,$color,$size,$storeID,$grnNo,$grnYear);
//	

	
	
	/*$trimInspected = 1;
	$sqlitm = "SELECT intSubCatID FROM matitemlist INNER JOIN matsubcategory ON  matitemlist.intSubCatID = matsubcategory.intSubCatNo   WHERE matitemlist.intItemSerial = '$MatID'  AND matsubcategory.intInspection = '1'";
	$resultitm=$db->RunQuery($sqlitm);
	
	 while($rowitm = mysql_fetch_array($resultitm))
  	 {
  	 	$trimInspected=getTrimInspected($styleID,$year,$buyerPo,$MatID,$color,$size,$grnNo,$grnYear);
  	 	break;
	 }*/
	
	//$trimInspected=getTrimInspected($styleID,$year,$buyerPo,$MatID,$color,$size);
	
	//$mrnReqArr=getMrnQty($styleID,$year,$buyerPo,$MatID,$color,$size);
	//$approvedQtyArr=getNotApprovedQty($styleID,$buyerPo,$MatID,$color,$size,$grnNo,$grnYear);
//	$approvedQty=$approvedQtyArr[0];
//	$Inspected=$approvedQtyArr[1];
//	$notApprovedqty=$Inspected-$approvedQty;
	/*if($MatID == '37338')
	{
		echo $trimInspected.' '.$MatID;
	}*/
	
	/*$ResponseXML .= "<Item><![CDATA[" .$description. "]]></Item>\n";
	$ResponseXML .= "<color><![CDATA[" . $color  . "]]></color>\n";
	$ResponseXML .= "<size><![CDATA[" . $size  . "]]></size>\n";
	$ResponseXML .= "<qty><![CDATA[" .round($qty,2). "]]></qty>\n";
	$ResponseXML .= "<MatDetailID><![CDATA[" . $MatID . "]]></MatDetailID>\n";
	$ResponseXML .= "<MRNRaised><![CDATA[" .round($mrnReq,2). "]]></MRNRaised>\n";
	$ResponseXML .= "<Issued><![CDATA[" .round($issueQty,2). "]]></Issued>\n";
	$ResponseXML .= "<issueBalance><![CDATA[" .round($issueBalance,2). "]]></issueBalance>\n";
	$ResponseXML .= "<stockBalance><![CDATA[" .round($stockQty,2). "]]></stockBalance>\n";
	$ResponseXML .= "<ConPC><![CDATA[" .$conPC. "]]></ConPC>\n";
	$ResponseXML .= "<Wastage><![CDATA[" .round($wastage,2). "]]></Wastage>\n";
	$ResponseXML .= "<Approved><![CDATA[" .round($approvedQty,2). "]]></Approved>\n";
	$ResponseXML .= "<NotApproved><![CDATA[" .round($notApprovedqty,2). "]]></NotApproved>\n";
	$ResponseXML .= "<TrimInspected><![CDATA[" .$trimInspected. "]]></TrimInspected>\n";
	$ResponseXML .= "<GRNno><![CDATA[" .$grnNo. "]]></GRNno>\n";
	$ResponseXML .= "<grnYear><![CDATA[" .$grnYear. "]]></grnYear>\n";	 */               
	}
	
	$ResponseXML .= "</MatInfo>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"getStockTrance") == 0)
{
global $db;
$styleID=$_GET["styleNo"];
$buyerPO=$_GET["buyerPo"];
$store = $_GET["store"]; 
$matDetailID=$_GET["MatID"];
$color=$_GET["color"];
$size=$_GET["size"];
$total=0;
$ResponseXML = "";
$ResponseXML .="<stockTrance>";
$sql="SELECT strType,dtmDate,dblQty FROM stocktransactions s WHERE intStyleId='$styleID' AND strBuyerPoNo='$buyerPO' AND intMatDetailId='$matDetailID' AND strColor='$color' AND strSize='$size' and strMainStoresID = '$store';";

$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
 $ResponseXML .= "<type><![CDATA[" .$row["strType"]. "]]></type>\n";
		 $ResponseXML .= "<date><![CDATA[" .$row["dtmDate"]. "]]></date>\n";
		 $ResponseXML .= "<qty><![CDATA[" . $row["dblQty"]. "]]></qty>\n";
$qty= $row["dblQty"];
$total+=$qty;
}
$ResponseXML .= "<Total><![CDATA[" . $total. "]]></Total>\n";
$ResponseXML .="</stockTrance>";
echo $ResponseXML;
}

else if(strcmp($RequestType,"SaveMrnHeader") == 0)
{
	
	$departmentCode=$_GET["dipCode"];
	$datex=$_GET["datex"];
	$store=$_GET["store"];
	
	$requestBy=$_SESSION["UserID"];
	$userID=$_SESSION["UserID"];
	
	$status="1";
	
	//$companyID=getCompanyID($userID);
	
	$ResponseXML = "";
	$ResponseXML .="<saveMRN>";
	
//	$keyVal="MRNID".$companyID;
//	$sql="SELECT strValue FROM settings s where strKey='$companyID';";
//	$resultRate=$db->RunQuery($sql);
//	
//	while($row = mysql_fetch_array($resultRate))
//	{
//	$rangeArr=explode("-",$row["strValue"]);
//	
//	}
	
//	$sql="SELECT strValue FROM settings s where strKey='$keyVal';";
//	$result=$db->RunQuery($sql);
//	while($row = mysql_fetch_array($result))
//	{
//	$maxID=$row["strValue"];
//	}
//
//	$intMax=0;
//	$intMax=(int)$maxID;
//	
//	if($intMax<(int)$rangeArr[1] && $intMax>(int)$rangeArr[0])
//	{
//	$intMRNNo=$intMax+1;
//	$sql="UPDATE settings SET strValue='$intMRNNo' WHERE strKey='$keyVal';";
//	$db->executeQuery($sql);
//	}
//	else
//	{
//	$intMRNNo= -1000;
//	}
	$arrDate = explode('/',$datex);
	$dtmDate = $arrDate[0].'-'.$arrDate[1].'-'.$arrDate[2];
	$mrnNo = $_GET["mrnNo"];
	$response = "";
	if($mrnNo != "")
	{
		$arrMRNno = explode('/',$mrnNo);
		$intMRNNo = $arrMRNno[0];
		$mrnYear  = $arrMRNno[1];
		
		$response = updateMRNHeader($intMRNNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$store,$dtmDate);
		
	}
	else
	{
		$intMRNNo=generateMRNNo();
		$mrnYear=date("Y");
		//echo $intMRNNo;
		$response = saveMrnHeader($intMRNNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$store,$dtmDate);
		
	}
	
	if($response == '1')
		{
			$MRNDet = $intMRNNo.'/'.$mrnYear;
			$ResponseXML .= "<Result><![CDATA[$MRNDet]]></Result>\n";
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[-100]]></Result>\n";
		}
	
	
	$ResponseXML .="</saveMRN>";
   echo $ResponseXML;
	//echo saveMrnHeader($intMRNNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$store,$datex);
}

else if(strcmp($RequestType,"SaveMrnDetail") == 0)
{

	$mrnNo=$_GET["mrnNo"];
	$year=date("Y");
	$styleID=$_GET["styleID"];
	$buyerPO=$_GET["BuyerPO"];
	$matDetailID=$_GET["matDetaiID"];
	$color=$_GET["color"];
	$size=$_GET["size"];
	$qty=$_GET["qty"];
	$balQty=$_GET["BalQty"];
	$notes=$_GET["notes"];
	$grnNo = $_GET["grnNo"];
	$grnYear = $_GET["grnYear"];
	$grnTypeId = $_GET["grnTypeId"];
	//echo $color;
	$ResponseXML="";
	
	$arrMRNno = explode('/',$mrnNo);
	$intMRNno = $arrMRNno[0];
	$intYear  = $arrMRNno[1];
	
	//deleteMRNdetails($intMRNno,$intYear);
	$ResponseXML.="<SaveMRNDetails>";
	if(saveMrnDetails($intMRNno,$intYear,$styleID,$buyerPO,$matDetailID,$color,$size,$qty,$balQty,$notes,$grnNo,$grnYear,$grnTypeId))
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	}
	$ResponseXML.="</SaveMRNDetails>";
	echo $ResponseXML;

}
else if(strcmp($RequestType,"CheckPossibility") == 0)
{


	/*$styleID=$_GET["styleID"];
	$buyerPO=$_GET["BuyerPO"];
	$matDetailID=$_GET["matDetaiID"];
	$color=$_GET["color"];
	$size=$_GET["size"];
	$qty=$_GET["qty"];
	$balQty=$_GET["BalQty"];
	$notes=$_GET["notes"];
	$storeID=$_GET["store"];
	
	$ResponseXML="";
	$ResponseXML.="<MRNValidate>";
	//echo $storeID;
	$stockQty=getStockqty($styleID,$buyerPO,$matDetailID,$color,$size,$storeID);
	$issueQty=getIssueQty($styleID,$year,$buyerPO,$matDetailID,$color,$size,"Qty",$storeID) * -1;
	$mrnQty=getMRNQuantity($styleID,$buyerPO,$matDetailID,$color,$size,$storeID);
	//echo $stockQty.' '.$issueQty.' '.$mrnQty;
	$balQty=($stockQty + $issueQty)-$mrnQty;
	
	if($qty > $balQty)
	{
		$ResponseXML .= "<Result><![CDATA[There is a problem with the MRN balance in following item.\nStyle : $styleID \nBuyer PO : $buyerPO\nItem Code:$matDetailID \nColor : $color\nSize : $size\nEntered Qty : $qty\nAvailable Qty : $balQty  ]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	$ResponseXML.="</MRNValidate>";
	echo $ResponseXML;*/
	$styleID=$_GET["styleID"];
	$buyerPO=$_GET["BuyerPO"];
	$matDetailID=$_GET["matDetaiID"];
	$color=$_GET["color"];
	$size=$_GET["size"];
	$qty=$_GET["qty"];
	$balQty=$_GET["BalQty"];
	$notes=$_GET["notes"];
	$storeID=$_GET["store"];
	$grnNo = $_GET["grnNo"];
	$grnYear = $_GET["grnYear"];
	$grnTypeId = $_GET["grnTypeId"];
	$ResponseXML="";
	$ResponseXML.="<MRNValidate>";
	//echo $storeID;
	$stockQty=getStockqty($styleID,$buyerPO,$matDetailID,$color,$size,$storeID,$grnNo,$grnYear,$grnTypeId);
	$issueQty=getIssueQty($styleID,$year,$buyerPO,$matDetailID,$color,$size,"Qty",$storeID,$grnNo,$grnYear,$grnTypeId) * -1;
	$mrnQty=getMRNQuantity($styleID,$buyerPO,$matDetailID,$color,$size,$storeID,$grnNo,$grnYear,$grnTypeId);
	//echo $stockQty.' '.$issueQty.' '.$mrnQty;
	$balQty=($stockQty + $issueQty)-$mrnQty;
	
	if($qty > $balQty)
	{
		$ResponseXML .= "<Result><![CDATA[There is a problem with the MRN balance in following item.\nStyle : $styleID \nBuyer PO : $buyerPO\nItem Code:$matDetailID \nColor : $color\nSize : $size\nEntered Qty : $qty\nAvailable Qty : $balQty  ]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	$ResponseXML.="</MRNValidate>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getAck") == 0)
{
	$mrnNo=$_GET["mrnNo"];
	$count=$_GET["count"];
	$ResponseXML="";
	$ResponseXML.="<Acknowledgement>";
	global $db;
	$sql="SELECT COUNT(intMatRequisitionNo)AS ackCount FROM matrequisition where intMatRequisitionNo='$mrnNo';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$mrnCount=$row["ackCount"];
	}
	if($mrnCount>0)
	{
	$ResponseXML .= "<mrnHeader><![CDATA[TRUE]]></mrnHeader>\n";
	}
	else
	{
		$ResponseXML .= "<mrnHeader><![CDATA[FALSE]]></mrnHeader>\n";
	}
	
	$sql="SELECT COUNT(intMatRequisitionNo) AS MrnDetailCount FROM matrequisitiondetails m where intmatRequisitionNo='$mrnNo';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$mrnDetailCount=$row["MrnDetailCount"];
	}
	if($mrnDetailCount==$count)
	{
		$ResponseXML .= "<mrnDetail><![CDATA[TRUE]]></mrnDetail>\n";
	}
	else
	{
		$ResponseXML .= "<mrnDetail><![CDATA[FALSE]]></mrnDetail>\n";
	}
	$ResponseXML.="</Acknowledgement>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getMrnAccYear") == 0)
{
	$year=$_GET["year"];
	$ResponseXML="";
	$ResponseXML.="<MrnNOMain>";
	global $db;
	$sql="SELECT intmatRequisitionNo FROM matrequisition m where intMRNYear='$year';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	$mrnNo=$row["intmatRequisitionNo"];
	$ResponseXML .= "<MrnNo><![CDATA[".$mrnNo."]]></MrnNo>\n";
	}
	$ResponseXML.="</MrnNOMain>";
	echo $ResponseXML;
}
//-------
else if(strcmp($RequestType,"GetSCNO") == 0)
{
	$year=$_GET["year"];
	$ResponseXML="";
	$ResponseXML.="<MrnNOMain>";
	$ResponseXML .= "<SRNO><![CDATA[Select One]]></SRNO>\n";
	$ResponseXML .= "<StyleId><![CDATA[".""."]]></StyleId>\n";
	global $db;
	global $headerPub_AllowOrderStatus;
	 $arrstatus = explode(',',$headerPub_AllowOrderStatus);
	 //$sql="SELECT DISTINCT s.intSRNO FROM specification s INNER JOIN materialratio m ON s.intStyleId=m.intStyleId where s.intOrdComplete='0';";
	 
	 $sql="SELECT DISTINCT S.intSRNO,MR.intStyleId FROM materialratio MR INNER JOIN orders O ON MR.intStyleId = O.intStyleId inner join specification S on S.intStyleId=O.intStyleId where O.intStatus = '$arrstatus[0]' or O.intStatus = '$arrstatus[1]' or O.intStatus = '$arrstatus[2]' order by  S.intSRNO desc";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	
		$ResponseXML .= "<SRNO><![CDATA[". $row["intSRNO"] ."]]></SRNO>\n";
		$ResponseXML .= "<StyleId><![CDATA[". $row["intStyleId"] ."]]></StyleId>\n";
	}
	$ResponseXML.="</MrnNOMain>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"GetStyleID") == 0)
{
	$SCNO=$_GET["SCNO"];
	$ResponseXML="";
	$ResponseXML.="<MrnNOMain>";
	global $db;
	 $sql="select s.intStyleId,o.strStyle 
			from specification s inner join orders o on s.intStyleId = o.intStyleId 
			where intSRNO='$SCNO';";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	$StyleID=$row["intStyleId"];
	$ResponseXML .= "<StyleID><![CDATA[".$StyleID."]]></StyleID>\n";
	$ResponseXML .= "<StyleName><![CDATA[".$row["strStyle"]."]]></StyleName>\n";
	}
	$ResponseXML.="</MrnNOMain>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"loadOrderNoStyleRatioColor") == 0)
{
	$styleID = $_GET["styleID"];
	$sql = " select distinct strColor from styleratio where intStyleId=$styleID ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$ResponseXML.="<styleColor>";
	$ResponseXML .= "<ratioColor><![CDATA[".$row["strColor"]."]]></ratioColor>\n";
	$ResponseXML.="</styleColor>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"URLLoadPatternNo") == 0)
{
$styleID 		= $_GET["styleID"];
//$ResponseXML 	= "<XMLLoadPatternNo>";

	$sql = "select distinct strPatternNo from upload_shrinkagedataretrieve where strPONo=(select distinct strBuyerOrderNo from orders where intStyleId='$styleID')";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["strPatternNo"]."\">".$row["strPatternNo"]."</option>";
	}
//$ResponseXML	.= "</XMLLoadPatternNo>";
//echo $ResponseXML;
}
//-----
//============================ Ananda 2009/06/17
else if (strcmp($RequestType,"MRNNoTask") == 0)
{	
	 $task=$_GET["task"];
	 
	 $ResponseXML = "";
	 $ResponseXML .= "<NewMRNNo>\n";
			
	 $result=getNextMRNNo($task);
	 
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<MRNNo><![CDATA[" . $row["dblSMRNNo"]  . "]]></MRNNo>\n";
	 }
	 $ResponseXML .= "</NewMRNNo>";
	 echo $ResponseXML;
}
	
else if (strcmp($RequestType,"deleteMRNDetData") == 0)
{
	$ResponseXML = "";
	$ResponseXML .= "<MRNDetail>\n";
	
	$response = $_GET["response"];
	$arrRes = explode('/',$response);
	$mrnNo = $arrRes[0];
	$intyear = $arrRes[1];
	//check record availability
	$RecAV = checkMRNdetailAV($mrnNo,$intyear);
	$res = 0;
	if($RecAV == '1')
	{
		$res = deleteMRNdetails($mrnNo,$intyear);
	}
	else
	{
		$res = 1;
	}
	 $ResponseXML .= "<delResponse><![CDATA[" . $res  . "]]></delResponse>\n";
	  $ResponseXML .= "</MRNDetail>";
	 echo $ResponseXML;
	 
	 	
}

else if (strcmp($RequestType,"getStyleName") == 0)
{
	$ResponseXML = "";
	$ResponseXML .= "<StyleDetails>\n";
	$styleID = $_GET["styleNo"];
	
	$styleName = getStyleNameDetails($styleID);
	
	 $ResponseXML .= "<styleName><![CDATA[" . $styleName  . "]]></styleName>\n";
	 $ResponseXML .= "</StyleDetails>";
	 echo $ResponseXML;
	 
	 	
}
function getStyleNameDetails($styleID)
{
global $db; 
	
	$sql = "select strStyle from orders where intStyleId='$styleID' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}

function getNextMRNNo($task)
{	
	$compCode=$_SESSION["FactoryID"];
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT  dblSMRNNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";

		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQL="update syscontrol set  dblSMRNNo= dblSMRNNo+1 WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		$strSQL="SELECT dblSMRNNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		$result=$db->RunQuery($strSQL);
		return $result;
	}
}
//==============================================

function generateMRNNo()
{	
	$compCode=$_SESSION["FactoryID"];
	global $db; 

	$strSQL="update syscontrol set  dblSMRNNo= dblSMRNNo+1 WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$strSQL="SELECT dblSMRNNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
	$result=$db->RunQuery($strSQL);
	$MRNNo = 0;
	while($row = mysql_fetch_array($result))
	 {
		$MRNNo  =  $row["dblSMRNNo"] ;
		break;
	 }
	return $MRNNo;
	//echo $MRNNo;

}

function getmrnQty($styleID,$year,$buyerPO,$matDetailID,$strColor,$strSize)
{
global $db;

$balMrnArr[0]=0;
$balMrnArr[1]=0;
$sql="SELECT m.dblBalQty AS MrnQty,i.dblQty AS issueQty FROM matrequisitiondetails m INNER JOIN issuesdetails i ON i.intMatRequisitionNo=m.intMatRequisitionNo where m.intStyleId='$styleID' AND m.strBuyerPONO='$buyerPO' AND m.strColor='$strColor' AND m.strSize='$strSize' AND m.strMatDetailID='$matDetailID' AND m.intYear='$year';";

//print($sql);

$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$mrn=$row["MrnQty"];
	$issue=$row["issueQty"];
$balMrnArr[0]=$mrn;
$balMrnArr[1]=$issue;

}
return $balMrnArr;
}
function getConPC($itemID,$styleID)
{
global $db;
$sql="SELECT sngConPc,sngWastage FROM specificationdetails s where intStyleId='$styleID' AND strMatDetailID='$itemID';";
 return $db->RunQuery($sql);
	
}

function getBuyerPO($styleID)
{
global $db;
$sql="SELECT DISTINCT strBuyerPONO FROM materialratio where intStyleId='".$styleID."';";
return $db->RunQuery($sql);
}

function getStockqty($styleNo,$buyerPO,$matDetaiID,$color,$size,$storeID,$grnNo,$grnYear,$grnTypeId)
{
global $db;
$stockQty=0;
$sql="SELECT SUM(dblQty)AS stockQty FROM stocktransactions s WHERE intStyleId='$styleNo' AND strBuyerPoNo='$buyerPO' AND intMatDetailId='$matDetaiID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType ='$grnTypeId' ";


//echo $sql;
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$stockQty=$row["stockQty"];

	if($stockQty=="" || $stockQty==NULL)
	{
		//$stockQty=-100;
		$stockQty = 0;
	}

}

return $stockQty;


}

function getStockqty1($styleNo,$buyerPO,$matDetaiID,$color,$size,$storeID)
{
global $db;
$stockQty=0;
$sql="SELECT SUM(dblQty)AS stockQty FROM stocktransactions s WHERE intStyleId='$styleNo' AND strBuyerPoNo='$buyerPO' AND intMatDetailId='$matDetaiID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' ;";


echo $sql;
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$stockQty=$row["stockQty"];

	if($stockQty=="" || $stockQty==NULL)
	{
	$stockQty=-100;
	}

}

return $stockQty;


}

function getNotApprovedQty($styleID,$buyerPO,$matDetailID,$color,$size,$grnNo,$grnYear)
{
global $db;
$AprroveArr[0]=0;
$AprroveArr[1]=0;

	/*$sql="SELECT intInspApproved,intInspected FROM grndetails
	WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND intMatDetailID='$matDetailID' AND strColor='$color' AND strSize='$size' and intGrnNo = '$grnNo' and intGRNYear = '$grnYear' ";*/
	
	$sql="SELECT intApprovedQty,intRejectQty FROM grndetails
	WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND intMatDetailID='$matDetailID' AND strColor='$color' AND strSize='$size' and intGrnNo = '$grnNo' and intGRNYear = '$grnYear' ";
	
	$result=$db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$approve=$row["intApprovedQty"];
		$rejectQty = $row["intRejectQty"];
		//$inspected=$row["intRejectQty"];
		$AprroveArr[0]=$approve;
		$AprroveArr[1]=$rejectQty;
		//$AprroveArr[1]=$inspected;
	
	}
return $AprroveArr;


}


function saveMrnHeader($mrnNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$store,$datex)
{
	global $db;
	global $companyId;
	$sql="INSERT INTO matrequisition (intMatRequisitionNo, intMRNYear,dtmDate, strDepartmentCode,intRequestedBy , intStatus,intUserId,  strMainStoresID,intCompanyID)VALUES('$mrnNo','$mrnYear','$datex','$departmentCode','$requestBy','$status','$userID','$store','$companyId');";
	//echo $sql;
	//print($sql);
	/*$db->executeQuery($sql);
	return true;*/
	return $db->RunQuery($sql);
}

function updateMRNHeader($mrnNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$store,$datex)
{
	global $db;
	
	
	$SQL = "update matrequisition 
	set
	dtmDate = '$datex' , 
	strDepartmentCode = '$departmentCode' , 
	intRequestedBy = '$requestBy' , 
	intStatus = '$status' ,
	intUserId = '$userID', 
	strMainStoresID = '$store'
	where
	intMatRequisitionNo = '$mrnNo' and intMRNYear = '$mrnYear' ";
	
	/*$db->executeQuery($SQL);
	return true;*/
	return $db->RunQuery($SQL);
}

function saveMrnDetails($mrnNo,$year,$styleID,$buyerPO,$matDetailID,$color,$size,$qty,$balQty,$notes,$grnNo,$grnYear,$grnTypeId)
{

	global $db;
	$sql="INSERT INTO matrequisitiondetails (intMatRequisitionNo,intYear,intStyleId, strBuyerPONO,strMatDetailID,strColor, strSize, dblQty, dblBalQty,strNotes,intGrnNo,intGrnYear,strGRNType) VALUES ('$mrnNo','$year','$styleID','$buyerPO','$matDetailID', '$color','$size','$qty','$qty', '$notes','$grnNo','$grnYear','$grnTypeId')";
	
	$db->executeQuery($sql);
	return true;
}

function getCompanyID($userID)
{
	global $db;
	$sql="SELECT intCompanyID FROM useraccounts where intUserID='$userID';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["intCompanyID"];
	}
}


function getMRNQuantity($styleID,$buyerPo,$MatID,$color,$size,$stores,$grnNo,$grnYear,$grnType)
{
	global $db;
	/*$sql="SELECT sum(dblQty) as dblQty FROM matrequisitiondetails inner join matrequisition on matrequisitiondetails.intMatRequisitionNo = matrequisition.intMatRequisitionNo AND matrequisitiondetails.intYear = matrequisition.intMRNYear WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' 
AND strColor='$color' AND strSize='$size' AND strMatDetailID='$MatID' AND matrequisition.strMainStoresID='$stores'; ";
*/
	$sql="SELECT round(sum(dblQty),2) as dblQty FROM matrequisitiondetails inner join matrequisition on matrequisitiondetails.intMatRequisitionNo = matrequisition.intMatRequisitionNo AND matrequisitiondetails.intYear = matrequisition.intMRNYear WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' 
AND strColor='$color' AND strSize='$size' AND strMatDetailID='$MatID' AND matrequisition.strMainStoresID='$stores' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and  strGRNType ='$grnType' ; ";
	//echo $sql;
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$Qty= $row["dblQty"];
		if($Qty=="" || $Qty==NULL)
		{
			$Qty=0;
		}
	}
return $Qty;
}

function getIssueQty($styleID,$year,$buyerPo,$MatID,$color,$size,$type,$storeID,$grnNo,$grnYear,$GrnType)
{
	global $db;
	$Qty =0;
	$sql= "";
	if($type=="Qty")
	{
		/*$sql="SELECT SUM(dblQty)AS dblQty FROM stocktransactions s WHERE intStyleId='$styleID' AND strBuyerPoNo='$buyerPo' AND intMatDetailId='$MatID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' AND strType = 'ISSUE' ;";*/
		
		$sql=" SELECT  round(SUM(dblQty),2)AS dblQty FROM stocktransactions s WHERE intStyleId='$styleID' AND strBuyerPoNo='$buyerPo' AND intMatDetailId='$MatID' AND strColor='$color' AND strSize='$size' AND strMainStoresID = '$storeID' AND strType = 'ISSUE' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType ='$GrnType'";
		
	}
	else if($type=="BalQty")
	{
		/*$sql="SELECT sum(dblBalanceQty) as dblQty FROM issuesdetails WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' AND  strColor='$color' AND strSize='$size' AND intMatDetailID='$MatID'";*/
		$sql="SELECT round(sum(dblBalanceQty),2) as dblQty FROM issuesdetails WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' AND  strColor='$color' AND strSize='$size' AND intMatDetailID='$MatID' and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and strGRNType ='$GrnType' ";
	}
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$Qty= $row["dblQty"];
		
		if($Qty=="" || $Qty==NULL)
		{
			$Qty=0;
		}
		
	}
return $Qty;

}

function getTrimInspected($styleID,$year,$buyerPo,$MatID,$color,$size,$grnNo,$grnYear)
{
	global $db;
	//$sql="SELECT intInspected FROM grndetails WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPo' AND intMatDetailID='$MatID' And strColor='$color' AND strSize='$size'";

//$sql="SELECT   grndetails.intInspected,  matsubcategory.intInspection FROM grndetails INNER JOIN matitemlist ON (grndetails.intMatDetailID=matitemlist.intItemSerial) INNER JOIN matsubcategory ON (matitemlist.intSubCatID=matsubcategory.intSubCatNo)  AND (matitemlist.intMainCatID=matsubcategory.intCatNo) AND (grndetails.intInspected=matsubcategory.intInspection) WHERE (grndetails.intStyleId ='$styleID') AND (grndetails.strBuyerPONO = '$buyerPo') AND (grndetails.intMatDetailID = '$MatID') AND (grndetails.strColor = '$color') AND (grndetails.strSize ='$size')";

$sql="SELECT   grndetails.intInspected FROM grndetails WHERE (grndetails.intStyleId ='$styleID') AND (grndetails.strBuyerPONO = '$buyerPo') AND (grndetails.intMatDetailID = '$MatID') AND (grndetails.strColor = '$color') AND (grndetails.strSize ='$size' and intGrnNo='$grnNo' and intGRNYear = '$grnYear')";


 
	//print($sql);
//$intInspected=1;

	$result=$db->RunQuery($sql);
	
	/*
	if (mysql_fetch_row($result)==0)
	{
		$intInspected=1;
	}
	*/
	while($row = mysql_fetch_array($result))
	{
		$intInspected= $row["intInspected"];
		
		/*
		if($intInspected=="" || $intInspected==NULL)
		{
			return 0;
		}
		*/
		//return 1;
		//else
		//{
		//	$intInspected=1;
		//}
		
	}
	//echo $intInspected;
	//echo mysql_fetch_array($result);
//return 0;
return $intInspected;



}

/*
function getMrnQty($styleNO,$year,$buyerPO,$matDetailID,$color,$size)
{
global $db;
$sql="SELECT dblQty FROM matrequisitiondetails m WHERE intStyleId='$styleNO' AND intYear='$year' AND strBuyerPONO='$buyerPO' AND strMatDetailID='$matDetailID' AND strColor='$color' AND strSize='$size';";
while($row = mysql_fetch_array($db->RunQuery($sql)))
{

return row["dblQty"];
}
return 0;

}
*/

if (strcmp($RequestType,"getCutQtyDetails") == 0)
{
	 $ResponseXML = "";
	 $StyleID=$_GET["styleID"];
	 
	 $result = cutQtyDetails($StyleID);
	 $ResponseXML .= "<CutDetails>\n";
	 
	 while($row=mysql_fetch_array($result))
	 {
	 	$ResponseXML .= "<CutNo><![CDATA[" . $row["strCutNo"]  . "]]></CutNo>\n";
		$ResponseXML .= "<CutQty><![CDATA[" . $row["dblTotalQty"]  . "]]></CutQty>\n";
		
		   
	 }
	 
	  $ResponseXML .= "</CutDetails>";
	  echo $ResponseXML;
	  
	
}

function cutQtyDetails($StyleID)
{
	global $db;
	$SQL = "SELECT strCutNo, dblTotalQty FROM productionbundleheader WHERE intStyleId ='$StyleID'";
	return $db->RunQuery($SQL);
}
	
/*function GetBuyerPoName($buyerPoNo)
{
global $db;
	$sql="select distinct strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoNo'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];	
}*/
function GetBuyerPoName($buyerPoNo,$StyleId)
{
global $db;
	$sql="select distinct strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoNo' and intStyleId='$StyleId'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];	
}

if (strcmp($RequestType,"confirmMrn") == 0)
{
	global $db;
	 $ResponseXML = "";
	 
	  $ResponseXML .= "<conMRN>\n";
	 $intMrnNo=$_GET["intMrnNo"];
	 $intYear=$_GET["intYear"];
	 $storeID=$_GET["storeID"];
	 $deptId=$_GET["deptId"];
	 $userID  = $_SESSION["UserID"];
	 $confirmDate = date("Y-m-d");
	$result = '';
	$stockAv = getMRNDetails($intMrnNo,$intYear); 
	$numrows = mysql_num_rows($stockAv);
	if($numrows <1)
		$result = 'MRN details not available';
		
	while($row = mysql_fetch_array($stockAv))
	{
		$orderNo = $row["strOrderNo"];
		$mrnQty = $row["dblQty"];
		$grnQty = getGRNQty($row["strMainStoresID"],$row["intStyleId"],$row["strBuyerPONO"],$row["strColor"],$row["strSize"],$row["strMatDetailID"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"]);
		
		if($mrnQty>$grnQty)
			$result = "MRN item ".$row["strItemDescription"]." \n "." Color ".$row["strColor"]."\n"." Size ".$row["strSize"]." not in stock order no - ".$orderNo;
	}
	
	
	//echo $result;
	if($result == '')
	{
		 $SQL = "update matrequisition 
	set	
	intStatus = '10',
	intConfirmedBy = '$userID', 	
	dtmConfirmDate = '$confirmDate'
	where
	intMatRequisitionNo = '$intMrnNo' and intMRNYear = '$intYear' ";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
	}
	
	
	$ResponseXML .= "<MRNresponse><![CDATA[" . $result  . "]]></MRNresponse>\n";
	$ResponseXML .= "</conMRN>";
	  echo $ResponseXML;
}

function deleteMRNdetails($mrnNo,$mrnYear)
{
	global $db;
	$sql=" delete from matrequisitiondetails 
		   where 	intMatRequisitionNo = '$mrnNo' and intYear = '$mrnYear' ";
	
	return $db->RunQuery($sql);
}

function checkMRNdetailAV($mrnNo,$mrnYear)
{
	global $db;
	$sql=" select* from matrequisitiondetails 
		   where 	intMatRequisitionNo = '$mrnNo' and intYear = '$mrnYear' ";
	
	return $db->CheckRecordAvailability($sql);
}
function getGRNExQty($intGrnNo,$intGrnYear,$styleID,$buyerPo,$color,$size,$MatID)
{
	global $db;
	
	$sql = " select dblExcessQty from grndetails
			where intGrnNo='$intGrnNo' and intGRNYear='$intGrnYear' and intStyleId = '$styleID' 
			and strBuyerPONO = '$buyerPo' and intMatDetailID = '$MatID' and 
			strColor = '$color' and strSize = '$size' ";
			
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblExcessQty"];		
}

function getMRNDetails($intMrnNo,$intYear)
{
	global $db;
	$SQL = "select mh.strMainStoresID,md.intStyleId,md.strBuyerPONO,md.strColor,md.strSize,md.strMatDetailID,
md.dblQty,md.intGrnNo,md.intGrnYear,md.strGRNType,mil.strItemDescription,o.strOrderNo
from matrequisition mh inner join matrequisitiondetails md on 
mh.intMatRequisitionNo= md.intMatRequisitionNo and mh.intMRNYear = md.intYear
inner join matitemlist mil on mil.intItemSerial = md.strMatDetailID
inner join orders o on o.intStyleId = md.intStyleId
where mh.intMatRequisitionNo='$intMrnNo' and mh.intMRNYear='$intYear'  and mh.intStatus=1";

	return $db->RunQuery($SQL);
	
}

function getGRNQty($storeId,$styleId,$buyerPO,$color,$size,$matDetailId,$grnno,$grnYear,$grnType)
{
	global $db;
	$sql = "select round(sum(dblQty),4) as grnQty from stocktransactions
	 where strMainStoresID='$storeId' and intMatDetailId='$matDetailId'
and intStyleId='$styleId' and strBuyerPoNo='$buyerPO' and strColor='$color' and strSize='$size' and intGrnNo='$grnno'
and intGrnYear='$grnYear' and strGRNType='$grnType'";

	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return round($row["grnQty"],2);
	
}
function getInvoiceNo($intGrnNo,$intGrnYear,$GrnType)
{
	global $db;
	switch($GrnType)
	{
		case 'S':
		{
			$sql = "select strInvoiceNo from grnheader where intGrnNo='$intGrnNo'  and intGRNYear = '$intGrnYear'";
			break;
		}
		case 'B':
		{
			$sql = "select strInvoiceNo from bulkgrnheader where intBulkGrnNo='$intGrnNo' and intYear = '$intGrnYear'";
			break;
		}
	}
	
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strInvoiceNo"];
}

function getMainCat($styleID)
{
global $db;
$sql="SELECT DISTINCT g.intID,g.strDescription FROM materialratio m INNER JOIN matitemlist l ON m.strMatDetailID=l.intItemSerial INNER JOIN matmaincategory g ON l.intMainCatID=g.intID where m.intStyleId='".$styleID."' ORDER BY g.intID;";
return $db->RunQuery($sql);
}
?>