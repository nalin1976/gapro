<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];

if($id=="load_PR_str")
{
	$sql = "select PH.strPRNo 
			from purchaserequisition_header PH 
			inner join purchaserequisition_details PD on PD.intPRNo=PH.intPRNo and PD.intPRYear=PH.intPRYear
			where intStatus=3 and PD.dblBalanceQty>0 ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strPRNo']."|";
				 
			}
			echo $pr_arr;
	
}
if($id=="load_PendinPO_str")
{

$intYear = $_GET["intYear"];
$intYear = ($intYear == '' ?date('Y'):$intYear);
	$sql = "select intGenPONo from generalpurchaseorderheader where intYear=$intYear and intStatus=0 order by intGenPONo desc ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['intGenPONo']."|";
				 
			}
			echo $pr_arr;
	
}
if($id=="loadMainCategory")
{	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatmaincategory>";
		$SQL="SELECT intID,strDescription FROM genmatmaincategory where status='1' ORDER BY strDescription";
				
		$result = $db->RunQuery($SQL);
		$str = '';
		$str .= "<option value=\"". "" ."\">" . "" ."</option>";
		while($row = mysql_fetch_array($result))
		{
			  $str .= "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>";
		}
		$ResponseXML .= "<mainCat><![CDATA[" . $str  . "]]></mainCat>\n";
		$ResponseXML .= "</genmatmaincategory>";
		echo $ResponseXML;
}

if($id=="loadSubCategory")
{	

		$intMainCatId = $_GET["mainCatId"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
				
		$result = $db->RunQuery($SQL);
		$str = '';
		$str .= "<option value=\"". "" ."\">" . "" ."</option>";
		
			while($row = mysql_fetch_array($result))
			{
				 $str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
			}
			$ResponseXML .= "<SubCat><![CDATA[" . $str  . "]]></SubCat>\n";
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}
if($id=="loadCostCenter")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$txtPRNo = $_GET['txtPRNo'];
	$ResponseXML 	.= "<loadCostCenter>";
	$sql = "select intCostCenterId from purchaserequisition_header where strPRNo='$txtPRNo'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$ResponseXML .= "<costCenterId><![CDATA[" . $row['intCostCenterId']  . "]]></costCenterId>\n";
	$ResponseXML .= "</loadCostCenter>";
	echo $ResponseXML;
	
}
if($id=="loadMaterial")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML 	.= "<genmatsubcategory>";

$mainCatId 		= trim($_GET["mainCatId"]);
$subCatId 		= trim($_GET["subCatId"]);
$txtDetailsLike = trim($_GET["txtDetailsLike"]);
$txtPRNo 		= trim($_GET["txtPRNo"]);
$costCenter 	= trim($_GET["costCenter"]);

	$SQL="select gm.intItemSerial,gm.strItemDescription, gm.strUnit, gm.intMainCatID,gm.dblLastPrice
		 from genmatitemlist gm
		 where gm.intStatus=1";
	
	if($mainCatId != "")
		$SQL.="  AND gm.intMainCatID =$mainCatId ";
		
	if($subCatId!="")
		$SQL.="  AND gm.intSubCatID =$subCatId ";
	
	if($txtDetailsLike!="")
		$SQL.="  AND gm.strItemDescription like '%$txtDetailsLike%' ";
	
	if($txtPRNo != "")
		$SQL .= " and gm.intItemSerial in (select prd.intMatDetailId from purchaserequisition_details prd 
inner join purchaserequisition_header prh on prd.intPRNo= prh.intPRNo and prd.intPRYear = prh.intPRYear 
where prh.strPRNo='$txtPRNo') ";

		$SQL.="  ORDER BY gm.strItemDescription";
			
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			$sqlGL="select BAMC.intGlId,GA.strAccID,GA.strDescription,C.strCode,GF.GLAccAllowNo
					from budget_glallocationtomaincategory BAMC
					inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId
					inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
					inner join costcenters C on C.intCostCenterId=GF.FactoryCode
					where intMatCatId='".$row['intMainCatID']."'  and GF.FactoryCode=$costCenter";
					
			$resultGL = $db->RunQuery($sqlGL);
			if($txtPRNo!="")
			{
				$text = "<select name=\"cboGLId\" id=\"cboGLId\" style=\"width:90px;\" onChange=\"loadGLDescription(this,this.parentNode.parentNode.rowIndex);\" disabled=\"disabled\">";
			}
			else
			{
				$text = "<select name=\"cboGLId\" id=\"cboGLId\" style=\"width:90px;\" onChange=\"loadGLDescription(this,this.parentNode.parentNode.rowIndex);\" >";
			}
			
			$rowCount = mysql_num_rows($resultGL);
			if($rowCount!=1)
				$text.= "<option value=\"\">Select One</option>";
	
			while($rowGL = mysql_fetch_array($resultGL))
			{
				if($rowCount==1)
				{
					$GLDes = $rowGL['strDescription'];
					$GLAllowId  = $rowGL['GLAccAllowNo'];
				}
				else
				{
					$GLDes = "";
					$GLAllowId = "";
				}
				$GLId = $rowGL['strAccID'].'-'.$rowGL['strCode'];
				$text.= "<option value=".$rowGL['GLAccAllowNo'].">".$GLId."</option>";	
			}
			$text.="</select>";
			 $ResponseXML .= "<cboGLId><![CDATA[" . $text  . "]]></cboGLId>\n";
			  $ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
			 $ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
			 $ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
			 $ResponseXML .= "<GLDescription><![CDATA[" . $GLDes . "]]></GLDescription>\n";  
			 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
			 if($txtPRNo!=""){
			 	$value = GetPRQty($txtPRNo,$row["intItemSerial"]);
			 	$ResponseXML .= "<PRQty><![CDATA[".$value[0]."]]></PRQty>\n";
				$ResponseXML .= "<CostCenterId><![CDATA[".$value[1]."]]></CostCenterId>\n";
				$ResponseXML .= "<UnitPrice><![CDATA[".$value[2]."]]></UnitPrice>\n";
				$ResponseXML .= "<PRGLid><![CDATA[".$value[3]."]]></PRGLid>\n";
				$ResponseXML .= "<PRGLDes><![CDATA[".$value[4]."]]></PRGLDes>\n";
			}else{
				$ResponseXML .= "<PRQty><![CDATA[]]></PRQty>\n";
				$ResponseXML .= "<CostCenterId><![CDATA[Null]]></CostCenterId>\n";
				$ResponseXML .= "<UnitPrice><![CDATA[".$row["dblLastPrice"]."]]></UnitPrice>\n";
				$ResponseXML .= "<PRGLid><![CDATA[]]></PRGLid>\n";
				$ResponseXML .= "<PRGLDes><![CDATA[]]></PRGLDes>\n";
			}
		}
		
		$ResponseXML .= "</genmatsubcategory>";
		echo $ResponseXML;
}
if($id=="loadGLDescription")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<getGLDescription>";
	$GLId = $_GET["GLId"];
	
	$sql = "select GAC.strDescription,concat(GAC.strAccID,'-',C.strCode) as GLCode
			from glallowcation GLA
			inner join glaccounts GAC on GLA.GLAccNo=GAC.intGLAccID
			inner join costcenters C on C.intCostCenterId=GLA.FactoryCode
			where GLA.GLAccAllowNo='$GLId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$ResponseXML .="<strGLDescription><![CDATA[" . $row["strDescription"]  . "]]></strGLDescription>\n";
	$ResponseXML .="<strGLCode><![CDATA[" . $row["GLCode"]  . "]]></strGLCode>\n";
	$ResponseXML .= "</getGLDescription>";
	echo $ResponseXML;
	
}

if($id=="loadMaterialToMainGrid")
{

//load item details to main grid 
	$txtPRNo = trim($_GET["txtPRNo"]);
	$matDetialID = $_GET["matDetialID"];
	
	header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<genmatItem>";

	if($txtPRNo !='')
	{
		$SQL = "select gm.intItemSerial,p.strUnit,gm.strItemDescription,p.dblUnitPrice,p.dblQty,gmat.strDescription,
				ph.intPRNo,ph.intPRYear,ph.strPRNo,p.dblDiscount,ph.intSupplierId,ph.intCurrencyId
				from genmatitemlist gm inner join purchaserequisition_details p on
				p.intMatDetailId = gm.intItemSerial
				inner join purchaserequisition_header ph on 
				ph.intPRNo = p.intPRNo and p.intPRYear = ph.intPRYear
				inner join genmatmaincategory gmat on gmat.intID = gm.intMainCatID
				where ph.strPRNo='$txtPRNo' and p.intMatDetailId=$matDetialID";
	}
	else
	{
		$SQL = "select gm.intItemSerial,gm.strItemDescription, gm.strUnit,0,dblLastPrice as dblUnitPrice,gmat.strDescription,
				0,0,0,0 as intCurrencyId	
				from genmatitemlist gm inner join genmatmaincategory gmat on
				gm.intMainCatID = gmat.intID
				where gm.intItemSerial='$matDetialID' ";
	}
	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
				 $ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";  
				 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n"; 
				 $ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";  
				 $ResponseXML .= "<Unitprice><![CDATA[" . $row["dblUnitPrice"]  . "]]></Unitprice>\n";
				 
				 $itemVal =  round($row["dblQty"]*$row["dblUnitPrice"],4);
				 
				 $ResponseXML .= "<value><![CDATA[" . $itemVal  . "]]></value>\n";      
				 $ResponseXML .= "<mainCategory><![CDATA[" . $row["strDescription"]  . "]]></mainCategory>\n"; 
				 
				 $ResponseXML .= "<intPRNo><![CDATA[" . $row["intPRNo"]  . "]]></intPRNo>\n";      
				 $ResponseXML .= "<intPRYear><![CDATA[" . $row["intPRYear"]  . "]]></intPRYear>\n";
				 $ResponseXML .= "<strPRNo><![CDATA[" . $row["strPRNo"]  . "]]></strPRNo>\n";  
				 $ResponseXML .= "<DiscountPer><![CDATA[" . $row["dblDiscount"]  . "]]></DiscountPer>\n"; 
				 $ResponseXML .= "<SuppId><![CDATA[" . $row["intSupplierId"]  . "]]></SuppId>\n"; 
				 $ResponseXML .= "<CurrId><![CDATA[" . $row["intCurrencyId"]  . "]]></CurrId>\n"; 
				 
				/* $result_c = getCostCenterDetails();
				 $str = '';
				 $str .= "<select name='cboCostCenter' id='cboCostCenter' style='width:70px;' onChange='setCostCenterVal(this);'>";
				 $str .=  "<option value="."null".">".""."</option>";
				 while($rw = mysql_fetch_array($result_c))
				 {
					 $str .= "<option value=\"". $rw["intCostCenterId"] ."\">" . $rw["strDescription"] ."</option>";
				 }
				 $str .= "</select> ";
				 $ResponseXML .= "<costCenter><![CDATA[" . $str  . "]]></costCenter>\n";
				  $ResponseXML .= "<costCenterID><![CDATA[null]]></costCenterID>\n"; */
			}
			
			$ResponseXML .= "</genmatItem>";
			echo $ResponseXML;
}

if($id=="loadColor")
{	
		$SQL="SELECT distinct strColor FROM colors ORDER BY strColor";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $text .= "<option>" . $row["strColor"]  ."</option>\n";
		}
		echo $text;
}

if($id=="loadSize")
{	
		$SQL="SELECT distinct strSize FROM sizes ORDER BY strSize";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $text .= "<option>" . $row["strSize"]  . "</option>\n";
			}
			echo $text;
}

if($id=="GetSupplierRelatedDetails")
{	
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<GetSupplierRelatedDetails>\n";
$supId		 = $_GET["supId"];

	$SQL="SELECT strCurrency,strPayModeId,strPayTermId FROM suppliers  where intStatus='1' AND strSupplierID=$supId";
	$result = $db->RunQuery($SQL);
	$text= "";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<CurrencyId><![CDATA[" . $row["strCurrency"]  . "]]></CurrencyId>\n";
		$ResponseXML .= "<PaymentMode><![CDATA[" . $row["strPayModeId"]  . "]]></PaymentMode>\n";
		$ResponseXML .= "<PaymentTerm><![CDATA[" . $row["strPayTermId"]  . "]]></PaymentTerm>\n";
	}
$ResponseXML .= "</GetSupplierRelatedDetails>";	
echo $ResponseXML;
}

if($id=="loadBulkPo")
{
		$fromDate		= $_GET["fromDate"];
		$toDate			= $_GET["toDate"];
		$intStatus		= $_GET["intStatus"];
		$intPoNo		= $_GET["poNo"];
		$intSupplierID	= $_GET["intSupplierID"];
		$intCompanyId	=	$_SESSION["FactoryID"];
		 
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$limitText = " limit 0,50 ";
		
		$ResponseXML .= "<BulkPo>";
		$SQL=  "	SELECT
					GH.intGenPONo,
					GH.intYear,
					GH.intUserID,
					(select Name from useraccounts UA where GH.intUserID=UA.intUserID)as userName,
					suppliers.strTitle,
					date(dtmDate)as genDate
					FROM
					generalpurchaseorderheader GH
					Inner Join suppliers ON suppliers.strSupplierID = GH.intSupplierID
					WHERE
					GH.intStatus =  '$intStatus'  ";				

				if($fromDate!="")
				{
					$SQL.=" AND GH.dtmDate>='$fromDate' ";
					$limitText = "";
				}
				if($toDate!="")
				{
					$SQL.=" AND GH.dtmDate<='$toDate'";
					$limitText = "";
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND GH.intGenPONo LIKE '%$intPoNo%' ";
					$limitText = "";
				}
				if($intSupplierID!="")
				{
					$SQL.=" AND GH.intSupplierID = '$intSupplierID' ";
					$limitText = "";
				}
				
				$SQL.=" order by GH.intGenPONo desc, dtmDate desc $limitText ";
		
		
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$permision = 0;
				if($row["intUserID"]==$_SESSION["UserID"])
					$permision=1;
					
				 $ResponseXML .= "<intGenPONo><![CDATA[" . $row["intGenPONo"]  . "]]></intGenPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . $row["intYear"]  . "]]></intYear>\n"; 
				 $ResponseXML .= "<strTitle><![CDATA[" . $row["strTitle"]  . "]]></strTitle>\n";
				 $ResponseXML .= "<permision><![CDATA[" . $permision  . "]]></permision>\n";
				 $ResponseXML .= "<userName><![CDATA[" . $row["userName"]  . "]]></userName>\n";
				 $ResponseXML .= "<date><![CDATA[" .  $row["genDate"]  . "]]></date>\n";
				 
			}
			$ResponseXML .= "</BulkPo>";
			echo $ResponseXML;
}

if($id=="loadBulkPoHeader")
{
	$intGenPONo	=$_GET["intGenPONo"];
	$intYear		=$_GET["intYear"];
	$intStatus		=$_GET["intStatus"];
	$CopyToStat		=$_GET["CopyToStat"];
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoHeader>";
		
		$SQL		  ="SELECT
						generalpurchaseorderheader.intGenPONo,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.intSupplierID,
						generalpurchaseorderheader.dtmDate,
						generalpurchaseorderheader.dtmDeliveryDate,
						generalpurchaseorderheader.strCurrency,
						generalpurchaseorderheader.intStatus,
						generalpurchaseorderheader.intCompId,
						generalpurchaseorderheader.intDeliverTo,
						generalpurchaseorderheader.strPayTerm,
						generalpurchaseorderheader.intPayMode,
						generalpurchaseorderheader.intShipmentModeId,
						generalpurchaseorderheader.strInstructions,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.intInvoiceComp
						FROM
						generalpurchaseorderheader
						WHERE
						intYear = 	$intYear AND
						intGenPONo =   '$intGenPONo' AND intStatus	= '$intStatus'";
						
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intGenPONo><![CDATA[" . trim($row["intGenPONo"])  . "]]></intGenPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";
				 
				 $ResponseXML .= "<CopyToStat><![CDATA[" . trim($CopyToStat)  . "]]></CopyToStat>\n";
				 
				 $ResponseXML .= "<intSupplierID><![CDATA[" . trim($row["intSupplierID"])  . "]]></intSupplierID>\n";
				 $ResponseXML .= "<dtmDate><![CDATA[" . trim($row["dtmDate"])  . "]]></dtmDate>\n";
				 $ResponseXML .= "<dtmDeliveryDate><![CDATA[" . trim($row["dtmDeliveryDate"])  . "]]></dtmDeliveryDate>\n";
				 $ResponseXML .= "<strCurrency><![CDATA[" . trim($row["strCurrency"])  . "]]></strCurrency>\n";
				 $ResponseXML .= "<intStatus><![CDATA[" . trim($_GET["intStatus"])  . "]]></intStatus>\n";
				 $ResponseXML .= "<intCompId><![CDATA[" . trim($row["intCompId"])  . "]]></intCompId>\n";
				 $ResponseXML .= "<intDeliverTo><![CDATA[" . trim($row["intDeliverTo"])  . "]]></intDeliverTo>\n";
				 $ResponseXML .= "<strPayTerm><![CDATA[" . trim($row["strPayTerm"])  . "]]></strPayTerm>\n";
				 $ResponseXML .= "<intPayMode><![CDATA[" . trim($row["intPayMode"])  . "]]></intPayMode>\n";
				 $ResponseXML .= "<intShipmentModeId><![CDATA[" . trim($row["intShipmentModeId"])  . "]]></intShipmentModeId>\n";
				 $ResponseXML .= "<strInstructions><![CDATA[" . trim($row["strInstructions"])  . "]]></strInstructions>\n";
				 $ResponseXML .= "<strPINO><![CDATA[" . trim($row["strPINO"])  . "]]></strPINO>\n";
				 $ResponseXML .= "<intInvoiceComp><![CDATA[" . trim($row["intInvoiceComp"])  . "]]></intInvoiceComp>\n";
				 break;
			}
			$ResponseXML .= "</BulPoHeader>";
			echo $ResponseXML;

}


if($id=="loadBulkPoDetails")
{
		$intGenPONo		=$_GET["intGenPONo"];
		$intYear		=$_GET["intYear"];
		$intStatus		=$_GET["intStatus"];
		
		if($intStatus==13){
		$intStatus=1;
		}
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoDetails>";
		
		/*$SQL		  =" SELECT
						generalpurchaseorderdetails.strDescription AS itemDescription,
						genmatmaincategory.strDescription AS strMainCategory,
						generalpurchaseorderdetails.strUnit,
						generalpurchaseorderdetails.dblUnitPrice,
						generalpurchaseorderdetails.dblQty,
						generalpurchaseorderdetails.intMatDetailID,
						generalpurchaseorderheader.intStatus
						FROM
						generalpurchaseorderdetails
						Inner Join genmatmaincategory ON genmatmaincategory.intID = generalpurchaseorderdetails.strMatID
						Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo 
						AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
						WHERE
						generalpurchaseorderheader.intStatus 		=  $intStatus AND
						generalpurchaseorderdetails.intYear 		= 	$intYear AND
						generalpurchaseorderdetails.intGenPONo 	=   '$intGenPONo'";*/
		$SQL		  =" SELECT
						
						genmatmaincategory.strDescription AS strMainCategory,
						genmatitemlist.strItemDescription as itemDescription,
						generalpurchaseorderdetails.strRemarks,
						generalpurchaseorderdetails.strUnit,
						generalpurchaseorderdetails.dblUnitPrice,
						generalpurchaseorderdetails.dblExchangeRate,
						generalpurchaseorderdetails.dblQty,
						generalpurchaseorderdetails.intMatDetailID,
						generalpurchaseorderheader.intStatus,
						genmatmaincategory.strDescription AS strMainCategory,
						generalpurchaseorderdetails.dblDiscountPct,
						generalpurchaseorderdetails.intFixed,
						generalpurchaseorderdetails.intPRNo, 
						generalpurchaseorderdetails.intPRYear,
						generalpurchaseorderdetails.intCostCenterId,
						(select c.strDescription from costcenters c where c.intCostCenterId = generalpurchaseorderdetails.intCostCenterId ) as costCenter,
						generalpurchaseorderdetails.intGLAllowId,
						concat(glaccounts.strAccID,'-',costcenters.strCode) as GLCode
						FROM
						generalpurchaseorderdetails
						Inner Join generalpurchaseorderheader 
						ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPONo 
						AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
						Inner Join genmatitemlist ON generalpurchaseorderdetails.intMatDetailID = genmatitemlist.intItemSerial
						Inner Join genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID
						inner join glallowcation on glallowcation.GLAccAllowNo=generalpurchaseorderdetails.intGLAllowId
						inner join glaccounts on glaccounts.intGLAccID=glallowcation.GLAccNo
						inner join costcenters on costcenters.intCostCenterId=glallowcation.FactoryCode
						WHERE
						generalpurchaseorderheader.intStatus 		= $intStatus AND
						generalpurchaseorderdetails.intYear 		= $intYear AND
						generalpurchaseorderdetails.intGenPONo 	=  '$intGenPONo' ";
		$result = $db->RunQuery($SQL);
		//echo $SQL;
		
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strMainCategory><![CDATA[" . trim($row["strMainCategory"])  . "]]></strMainCategory>\n";
				 $ResponseXML .= "<itemDescription><![CDATA[" . trim($row["itemDescription"])  . "]]></itemDescription>\n";
				 $ResponseXML .= "<strRemark><![CDATA[" . trim($row["strRemarks"])  . "]]></strRemark>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . trim($row["dblUnitPrice"])  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblExchRate><![CDATA[" . trim($row["dblExchangeRate"])  . "]]></dblExchRate>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				 $value = $row["dblQty"]*$row["dblUnitPrice"];
				 $ResponseXML .= "<dblValue><![CDATA[" . round($value,4)  . "]]></dblValue>\n";
				 $ResponseXML .= "<intMatDetailID><![CDATA[" . trim($row["intMatDetailID"])  . "]]></intMatDetailID>\n";
				 $ResponseXML .= "<dblDiscountPct><![CDATA[" . trim($row["dblDiscountPct"])  . "]]></dblDiscountPct>\n";
				 $ResponseXML .= "<intFixed><![CDATA[" . trim($row["intFixed"])  . "]]></intFixed>\n";
				 
				 $strPRNo = '';
				 if(!is_null(trim($row["intPRNo"])) && !is_null(trim($row["intPRYear"])))
				 	$strPRNo = getPRNo($row["intPRNo"],$row["intPRYear"]);
					
				 $ResponseXML .= "<intPRNo><![CDATA[" . $row["intPRNo"]  . "]]></intPRNo>\n";      
				 $ResponseXML .= "<intPRYear><![CDATA[" . $row["intPRYear"]  . "]]></intPRYear>\n";
				 $ResponseXML .= "<strPRNo><![CDATA[" . $strPRNo  . "]]></strPRNo>\n";  	
				 
				 /* $result_c = getCostCenterDetails();
				 $str = '';
				 $str .= "<select name='cboCostCenter' id='cboCostCenter' style='width:70px;' onChange='setCostCenterVal(this);'>";
				 $str .=  "<option value="."null".">".""."</option>";
				 while($rw = mysql_fetch_array($result_c))
				 {
				 	if($row["intCostCenterId"] == $rw["intCostCenterId"])
						$str .= "<option selected=\"selected\" value=\"". $rw["intCostCenterId"] ."\">" . $rw["strDescription"] ."</option>";
					else	
					   $str .= "<option value=\"". $rw["intCostCenterId"] ."\">" . $rw["strDescription"] ."</option>";
				 }
				 $str .= "</select> ";*/
				 $ResponseXML .= "<costCenter><![CDATA[" . $row["costCenter"]  . "]]></costCenter>\n";
				 $ResponseXML .= "<costCenterID><![CDATA[".$row["intCostCenterId"]."]]></costCenterID>\n"; 
				 $ResponseXML .= "<GLCode><![CDATA[".$row["GLCode"]."]]></GLCode>\n"; 
				 $ResponseXML .= "<GLId><![CDATA[".$row["intGLAllowId"]."]]></GLId>\n"; 
			}
			$ResponseXML .= "</BulPoDetails>";
			echo $ResponseXML;

}

if($id=="GetPO")
{
	$intCompanyId	=	$_SESSION["FactoryID"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	global $db;
	$sql="SELECT DISTINCT p.intGenPONo,p.intYear FROM generalpurchaseorderheader p INNER JOIN generalpurchaseorderdetails d  ON p.intGenPONo=d.intGenPONo where intStatus='10' OR intStatus='11'
	and intCompId = '$intCompanyId' ORDER BY intGenPONo DESC";
	$result=$db->RunQuery($sql);
	$ResponseXML = "";	
	$ResponseXML .= "<PONos>\n";
		while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<PO><![CDATA[" . $row["intGenPONo"]. "]]></PO>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]. "]]></Year>\n";
		}
	$ResponseXML .= "</PONos>";
	echo $ResponseXML;
}

if($id=="LoadCopyPopupPoNo")
{
	$no	=	$_GET["no"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	global $db;
	$sql="select distinct intYear,intGenPONo from generalpurchaseorderheader where intStatus=1 and intYear='$no'";
	$result=$db->RunQuery($sql);
	$ResponseXML = "<PONos>\n";
	while($row = mysql_fetch_array($result))
	{
		$value = $row["intYear"]."/".$row["intGenPONo"];
		$ResponseXML .= "<option value=".$value.">".$row["intGenPONo"]."</option>";		
	}
	$ResponseXML .= "</PONos>";
	echo $ResponseXML;
}
if($id=="checkPRAvailable")
{
	$boolCheck = false;
	$GPONo	=	$_GET["GPONo"];
	$GPYear	=	$_GET["GPYear"];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<checkPRAvailable>\n";
	$sql = "select intPRNo
			from generalpurchaseorderheader GPH
			inner join generalpurchaseorderdetails GPD on GPH.intGenPONo=GPD.intGenPoNo and GPH.intYear=GPD.intYear
			where GPH.intGenPONo='$GPONo' and GPH.intYear='$GPYear';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if($row["intPRNo"]!=0)
		{
			$boolCheck = true;
			break;
		}
	}
	if($boolCheck)
		$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
	else
		$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
	
	$ResponseXML .= "</checkPRAvailable>";
	echo $ResponseXML;	
}
function getPRNo($intPRno,$intPRyear)
{
	global $db;
	
	$sql = "select strPRNo from purchaserequisition_header where intPRNo=$intPRno and intPRYear=$intPRyear ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strPRNo"];
}

function GetPRQty($txtPRNo,$matDetailId)
{
global $db;
$array	= array();
$sql="select PRD.dblBalanceQty,intCostCenterId,PRD.dblUnitPrice,glaccounts.strDescription,PRD.intGLAllowId 
		from purchaserequisition_details PRD 
		inner join purchaserequisition_header PRH on PRH.intPRNo=PRD.intPRNo and PRH.intPRYear=PRD.intPRYear  
		inner join glallowcation on glallowcation.GLAccAllowNo=PRD.intGLAllowId 
		inner join glaccounts on glaccounts.intGLAccID=glallowcation.GLAccNo
		where PRD.intMatDetailId='$matDetailId' and PRH.strPRNo='$txtPRNo';";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
	
	$array[0] = $row["dblBalanceQty"];
	$array[1] = $row["intCostCenterId"];
	$array[2] = $row["dblUnitPrice"];
	$array[3] = $row["intGLAllowId"];
	$array[4] = $row["strDescription"];
	
	return $array;
}
function getCostCenterDetails()
{
	global $db;
	$sql = " select intCostCenterId,strDescription from costcenters where intStatus=1 order by strDescription ";
	return $db->RunQuery($sql);
}
?>
