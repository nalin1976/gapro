<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 


$RequestType=$_GET["RequestType"];
$CompanyId=$_SESSION["FactoryID"];

$UserID=$_SESSION["UserID"];

if($RequestType=="LoadPoNo")
{
	$year =$_GET["year"];
	
	$ResponseXML .="<LoadPoNo>\n";
	
	//$SQL ="select distinct intPONo from purchaseorderheader where intStatus=10 AND intYear=$year;";



 	$SQL = "SELECT DISTINCT
purchaseorderheader.intPONo
FROM
purchaseorderdetails
INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
INNER JOIN purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo
WHERE
matmaincategory.intID = '1' AND purchaseorderheader.intStatus='10' AND purchaseorderheader.intYear='$year'
";

	$result=$db->RunQuery($SQL);
	$ResponseXML .="<option value=''></option>" ;
		while ($row=mysql_fetch_array($result))
		{
			//$ResponseXML .="<PoNo><![CDATA[".$row["intPONo"]."]]></PoNo>\n";
		$ResponseXML .="<option value=\"". $row["intPONo"] ."\">" . $row["intPONo"] ."</option>" ;
		}
	$ResponseXML .="</LoadPoNo>";
	echo $ResponseXML;
}
else if(strcmp($RequestType, "GetAutocompleteItem") == 0)
{
	$ResponseXML = "";
	$text = $_GET["text"];
	$year =$_GET["year"];
	
	$sql = "SELECT intPONo FROM purchaseorderheader WHERE intStatus=10 AND  intYear='$year' AND intPONo LIKE '%$text%'";
	$result = $db->RunQuery($sql);
	while ($row = mysql_fetch_array($result))
	{
		$ponos_array .= $row["intPONo"] . "|";
	}
	
	echo $ponos_array;
		
}
else if(strcmp($RequestType, "DisplaySelectedItem") == 0)
{
	$ResponseXML = "";
	$selectedItem = $_GET["selectedItem"];
	$ResponseXML .= "<PoNo>\n";
	
	$sql = "SELECT intPONo FROM purchaseorderheader WHERE intPONo = '$selectedItem' ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ponos_array .= $row["intPONo"];
	}
	
	$ResponseXML .= "<ponos><![CDATA[" .$ponos_array. "]]></ponos>\n";
	$ResponseXML .= "</PoNo>\n";
	echo $ResponseXML;
}

elseif($RequestType=="LoadSupplier")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	
	$ResponseXML .="<LoadSupplier>\n";
	
	$SQL ="select (select strTitle from suppliers S where S.strSupplierID=POH.strSupplierID) as Supplier, POH.strSupplierID 
		from purchaseorderheader POH where intPONo='$PoNo' AND intYear=$year;";

	$result=$db->RunQuery($SQL);
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Supplier><![CDATA[".$row["Supplier"]."]]></Supplier>\n";
			$ResponseXML .="<SupplierID><![CDATA[".$row["strSupplierID"]."]]></SupplierID>\n";
		}
	$ResponseXML .="</LoadSupplier>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadStyle1")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	
	$ResponseXML .="<LoadStyleRequest>\n";
	
	$SQL = "SELECT DISTINCT
						POD.intStyleId,
						SP.intSRNO,
						orders.strStyle,
						POD.strBuyerPONO,
						matitemlist.strItemDescription,
						POD.intMatDetailID,
						POD.strColor
			FROM
						purchaseorderdetails AS POD
			INNER JOIN specification AS SP ON SP.intStyleId = POD.intStyleId
			INNER JOIN orders ON POD.intStyleId = orders.intStyleId
			INNER JOIN matitemlist ON POD.intMatDetailID = matitemlist.intItemSerial
			WHERE  POD.intPoNo='$PoNo' AND POD.intYear='$year'";
		  			  
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<StyleId><![CDATA[".$row["intStyleId"]."]]></StyleId>\n";
			$ResponseXML .="<Style><![CDATA[".$row["strStyle"]."]]></Style>\n";
			$ResponseXML .="<SRNO><![CDATA[".$row["intSRNO"]."]]></SRNO>\n";
			$ResponseXML .="<BuyerPoNo><![CDATA[".$row["strBuyerPONO"]."]]></BuyerPoNo>\n";
			$ResponseXML .="<MatDetailID><![CDATA[".$row["intMatDetailID"]."]]></MatDetailID>\n";			
			$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
			$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";	
		}
	$ResponseXML .="</LoadStyleRequest>";
	echo $ResponseXML;
}
else if($RequestType == "LoadScToPo")
{
	$year = $_GET["year"];
	$poNo = $_GET["poNo"];
	
	$ResponseXML .="<LoadScToPoRequest>\n";
	
  $sql = "SELECT DISTINCT
specification.intSRNO
FROM
purchaseorderdetails
INNER JOIN specification ON purchaseorderdetails.intStyleId = specification.intStyleId
WHERE purchaseorderdetails.intPoNo = '$poNo' AND purchaseorderdetails.intYear = '$year'";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intSRNO"].">".$row["intSRNO"]."</option>";
	}
	
	$ResponseXML .= "</LoadScToPoRequest>";	
	echo $ResponseXML;
}
else if($RequestType == "LoadStyleToSc")
{
	$poNo = $_GET["poNo"];
	$year = $_GET["year"];
	$scNo = $_GET["scNo"];
	
	$ResponseXML .= "<LoadStyleToScRequest>";
	
	 $sql = "SELECT DISTINCT
					POD.intStyleId,
					SP.intSRNO,
					orders.strStyle
		FROM
					purchaseorderdetails AS POD
		INNER JOIN specification AS SP ON SP.intStyleId = POD.intStyleId
		INNER JOIN orders ON orders.intStyleId = SP.intStyleId
		where  POD.intPoNo='$poNo' AND POD.intYear='$year' AND SP.intSRNO='$scNo'";
		
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=" . $row["intStyleId"] .">" . $row["strStyle"] . "</option>";
	}
	
	$ResponseXML .="</LoadStyleToScRequest>";
	echo $ResponseXML;
		
}
else if($RequestType == 'LoadBuyerPoToSc')
{
	$poNo = $_GET["poNo"];
	$year = $_GET["year"];
	$scNo = $_GET["scNo"];
	
	$ResponseXML .= "<LoadBuyerPoToScRequest>";
	
 	$sql = "SELECT
			purchaseorderdetails.strBuyerPONO,
			specification.intSRNO
			FROM
			purchaseorderdetails
			INNER JOIN specification ON specification.intStyleId = purchaseorderdetails.intStyleId
			where  purchaseorderdetails.intPoNo='$poNo' AND purchaseorderdetails.intYear='$year' AND specification.intSRNO='$scNo'";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))	
	{
		$ResponseXML .= "<option value=" . $row["strBuyerPONO"] .">" .$row["strBuyerPONO"] . "</option>";	
	}	
	
	$ResponseXML .= "</LoadBuyerPoToScRequest>";
	echo $ResponseXML;
			
}
else if($RequestType == 'LoadDescriptionToSc')
{
	$year 		= $_GET["year"];
	$poNo 		= $_GET['poNo'];
	$scNo 		= $_GET['scNo'];
	$buyerPo 	= $_GET['buyerPo'];
	
	$ResponseXML .= "<LoadDescriptionToScRequest>";
	
	 $sql = "SELECT
			specification.intSRNO,
			matitemlist.intItemSerial,
			matitemlist.strItemDescription
			FROM
			purchaseorderdetails
			INNER JOIN matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
			INNER JOIN specification ON purchaseorderdetails.intStyleId = specification.intStyleId
			where purchaseorderdetails.intPoNo='$poNo' AND 
		 	purchaseorderdetails.intYear='$year' AND 
		 	specification.intSRNO='$scNo' ";
			
		$result = $db->RunQuery($sql);	
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=" .$row["intItemSerial"].">" . $row["strItemDescription"] . "</option>";
		}
		
		$ResponseXML .= "</LoadDescriptionToScRequest>";
		echo $ResponseXML;
}
else if($RequestType == 'LoadColorToSc')
{
	$poNo = $_GET["poNo"];
	$year = $_GET["year"];
	$scNo = $_GET["scNo"];
	$itemDes = $_GET["itemDes"];
	
	$ResponseXML .="<LoadColorToScRequest>";
	
	 $sql= "SELECT
specification.intSRNO,
matitemlist.strItemDescription,
matitemlist.intItemSerial,
purchaseorderdetails.strColor
FROM
purchaseorderdetails
INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN specification ON specification.intStyleId = purchaseorderdetails.intStyleId
where  purchaseorderdetails.intPoNo='$poNo' AND 
			purchaseorderdetails.intYear='$year' AND 
			specification.intSRNO='$scNo' AND   
			matitemlist.intItemSerial='$itemDes'";
			
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=" .$row["strColor"].">" .$row["strColor"] . "</option>";
	}
	
	$ResponseXML .= "</LoadColorToScRequest>";
	echo $ResponseXML;
			
}

elseif($RequestType=="LoadStyle")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	
	$ResponseXML .="<LoadStyleRequest>\n";
	
	 $SQL ="SELECT DISTINCT
					POD.intStyleId,
					SP.intSRNO,
					orders.strStyle
		FROM
					purchaseorderdetails AS POD
		INNER JOIN specification AS SP ON SP.intStyleId = POD.intStyleId
		INNER JOIN orders ON orders.intStyleId = SP.intStyleId
		where  POD.intPoNo='$PoNo' AND POD.intYear='$year';";
		  	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strStyle"]."</option>";
		}
	$ResponseXML .="</LoadStyleRequest>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadSc")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$style = $_GET["style"];
	
	$ResponseXML .="<LoadScRequest>\n";
	
	echo $SQL ="SELECT DISTINCT
					POD.intStyleId,
					SP.intSRNO,
					orders.strStyle
		FROM
					purchaseorderdetails AS POD
		INNER JOIN specification AS SP ON SP.intStyleId = POD.intStyleId
		INNER JOIN orders ON orders.intStyleId = SP.intStyleId
		where  POD.intPoNo='$PoNo' AND POD.intYear='$year' AND orders.strStyle='$style';";
		  	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=".$row["intSRNO"].">".$row["intSRNO"]."</option>";
		}
	$ResponseXML .="</LoadScRequest>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadBuyerPoNo")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$style =$_GET["style"];
	
	$ResponseXML .="<LoadBuyerPoNo>\n";
	
	 $SQL ="SELECT DISTINCT
					POD.strBuyerPONO,
					POD.intStyleId,
					orders.strStyle
			FROM
					purchaseorderdetails AS POD
			INNER JOIN orders ON POD.intStyleId = orders.intStyleId
			where  POD.intPoNo='$PoNo' AND POD.intYear=$year AND orders.strStyle='$style';";
			
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			  $ResponseXML .= "<option value=".$row["strBuyerPONO"].">".$row["strBuyerPONO"]."</option>";			
		}
	$ResponseXML .="</LoadBuyerPoNo>";
	echo $ResponseXML;
}
else if($RequestType == "LoadDescription")
{
	$PoNo = $_GET["PoNo"];
	$year = $_GET["year"];
	$BuyerPoNo = $_GET["BuyerPoNo"];
	$style = $_GET["style"];
	
	$ResponseXML .="<LoadDescription>\n";
	
	 $SQL ="SELECT DISTINCT
POD.intMatDetailID,
POD.strBuyerPONO,
POD.intStyleId,
MIL.strItemDescription,
orders.strStyle
FROM
purchaseorderdetails AS POD
INNER JOIN matitemlist AS MIL ON POD.intMatDetailID = MIL.intItemSerial
INNER JOIN orders ON orders.intStyleId = POD.intStyleId
where POD.intPoNo='$PoNo' AND 
		 POD.intYear='$year' AND 
		 POD.strBuyerPONO='$BuyerPoNo' AND
		 orders.strStyle='$style' ";

		 
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
					
		$ResponseXML .= "<option value=".$row["intMatDetailID"].">".$row["strItemDescription"]."</option>";	
	}
	
	$ResponseXML .= "</LoadDescription>";
	echo $ResponseXML;	 
	
}
elseif($RequestType=="LoadColor")
{
	$year =$_GET["year"];
	$PoNo =$_GET["PoNo"];
	$style =$_GET["style"];
	$BuyerPoNo =$_GET["BuyerPoNo"];
	$ItemDes =$_GET["ItemDes"];
	
	$ResponseXML .="<LoadColor>\n";
	
	 $SQL ="SELECT DISTINCT
POD.strColor,
matitemlist.strItemDescription,
orders.strStyle
FROM
purchaseorderdetails AS POD
INNER JOIN matitemlist ON matitemlist.intItemSerial = POD.intMatDetailID
INNER JOIN orders ON orders.intStyleId = POD.intStyleId
where  POD.intPoNo='$PoNo' AND 
			POD.intYear='$year' AND 
			orders.strStyle='$style' AND 
			POD.strBuyerPONO='$BuyerPoNo' AND  
			matitemlist.intItemSerial='$ItemDes'";


	
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=".$row["strColor"].">".$row["strColor"]."</option>";		
		}
	$ResponseXML .="</LoadColor>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblFabricRollSerialNo from syscontrol where intCompanyID='$CompanyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{	
					$rollYear = date('Y');			
					$No=$row["dblFabricRollSerialNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblFabricRollSerialNo='$NextNo' WHERE intCompanyID='$CompanyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[" . $rollYear. "]]></Year>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}

else if ($RequestType=="getUnits"){
	$style=$_GET['style'];	//-- purchaseorderdetails.strStyleID =  '$style' AND
	$po=$_GET['po'];
	$ResponseXML .="<LoadUnits>\n";
	$Sql="SELECT DISTINCT
	purchaseorderdetails.strUnit
	FROM
	purchaseorderdetails
	WHERE purchaseorderdetails.intPoNo =  '$po' ";
	$result =$db->RunQuery($Sql);	
	
	while($row = mysql_fetch_array($result))
	{				
		$ResponseXML .= "<UNIT><![CDATA[".$row['strUnit']."]]></UNIT>\n";
	}
	$ResponseXML .="</LoadUnits>";
	echo $ResponseXML;
}
elseif($RequestType=="SaveHeader")
{
	$rollSerialNo 		= $_GET["rollSerialNo"];
	$rollSerialYear	 	= $_GET["rollSerialYear"];
	$PoNo 				= $_GET["PoNo"];	
	$year			 	= $_GET["year"];
	$SupplierID 		= $_GET["SupplierID"];
	$styleId 			= $_GET["styleId"];
	$MatDetailID 		= $_GET["MatDetailID"];
	$Color 				= $_GET["Color"];	
	$BuyerPoNo 			= $_GET["BuyerPoNo"];
	//$BuyerPoNo 		= str_replace("Main Ratio","#Main Ratio#",$BuyerPoNo);
	$SupBatchNo 		= $_GET["SupBatchNo"];		
	$CompBatchNo 		= $_GET["CompBatchNo"];
	$Remarks			= $_GET["Remarks"];
	$mainStoreID		= $_GET["mainStoreID"];
	
	 $sql_header= "insert into fabricrollheader 
		  (intFRollSerialNO,intFRollSerialYear,intPONo,intPoYear,strSupplierID,intStyleId,strMatDetailID, 
		  strColor,strBuyerPoNo,intStatus,strSupplierBatchNo,strCompanyBatchNo,intStoresID, intUserID,dtmDate,strRemarks,intCompanyID) 
		  values 
		  ('$rollSerialNo','$rollSerialYear','$PoNo','$year','$SupplierID','$styleId','$MatDetailID','$Color','$BuyerPoNo','1','$SupBatchNo',
		   '$CompBatchNo','$mainStoreID','$UserID',now(),'$Remarks','$CompanyId');";  
		    		 
//echo $sql_header;
	$result=$db->executeQuery($sql_header);
	$ResponseXML ="<INHead>\n";
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
	$ResponseXML .= "</INHead>\n";
	echo $ResponseXML;
}
elseif($RequestType=="SaveDetails")
{
	$rollSerialNo 		= $_GET["rollSerialNo"];
	$rollSerialYear	 	= $_GET["rollSerialYear"];
	$RollNo 			= $_GET["RollNo"];	
	$SuppWidth			= $_GET["SuppWidth"];
	$CompWidth 			= $_GET["CompWidth"];
	$WidthUOM 			= $_GET["WidthUOM"];
	$SuppLength 		= $_GET["SuppLength"];
	$CompLength 		= $_GET["CompLength"];	
	$LengthUOM 			= $_GET["LengthUOM"];
	$SuppWeight 		= $_GET["SuppWeight"];		
	$CompWeight 		= $_GET["CompWeight"];
	$WeighUOM			= $_GET["WeighUOM"];
	$SpecialComm		= $_GET["SpecialComm"];
	$rc					= $_GET['rc'];
	
	echo $SQL= "insert into fabricrolldetails 
						(intFRollSerialNO,intFRollSerialYear,intRollNo,dblSuppWidth,dblCompWidth,strWidthUOM, 
						dblSuppLength,dblCompLength,strLengthUOM,dblSuppWeight,dblCompWeight,strWeightUOM,dblQty,strSpecialComments,intStatus) 
						values 
						('$rollSerialNo','$rollSerialYear','$RollNo','$SuppWidth','$CompWidth','$WidthUOM','$SuppLength','$CompLength',  
		 				'$LengthUOM','$SuppWeight','$CompWeight','$WeighUOM','$SuppLength','$SpecialComm','1');";	
	 
	$result=$db->executeQuery($SQL);
	if($result==1){
		$ResponseXML ="<INDet>\n";
		$ResponseXML .="<Result><![CDATA[". $rc ."]]></Result>\n";
		$ResponseXML .= "</INDet>\n";
		echo $ResponseXML;
	}
}
else if ($RequestType=="SaveValidate")
{
	$rollSerialNo=$_GET["rollSerialNo"];
	$rollSerialYear =$_GET["rollSerialYear"];
	$validateCount =$_GET["validateCount"];	
		
	$ResponseXML .="<SaveValidate>\n";
	
	$SQLHeder="SELECT COUNT(intFRollSerialNO) AS headerRecCount FROM fabricrollheader where intFRollSerialNO='$rollSerialNo' AND intFRollSerialYear='$rollSerialYear'";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader)){		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0){
					$ResponseXML .= "<recCountHeader><![CDATA[TRUE]]></recCountHeader>\n";
				}
				else{	
					$ResponseXML .= "<recCountHeader><![CDATA[FALSE]]></recCountHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intFRollSerialNO) AS DetailsRecCount FROM fabricrolldetails where intFRollSerialNO='$rollSerialNo' AND intFRollSerialYear=$rollSerialYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail)){
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount){
						$ResponseXML .= "<recCountDetails><![CDATA[TRUE]]></recCountDetails>\n";
					}
					else{
						$ResponseXML .= "<recCountDetails><![CDATA[FALSE]]></recCountDetails>\n";
					}
			}	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpReturnNo")
{

	$state=$_GET["state"];
	$year=$_GET["year"];

	$LoadPopUpReturnNoXML="<LoadPopUpReturnNo>";
	global $db;
	$SQL="SELECT DISTINCT FRH.intFRollSerialNO  ".
		 "FROM fabricrollheader AS FRH  ".		 
		 "WHERE FRH.intStatus='1' AND  FRH.intFRollSerialYear='$year';";
	
	$result=$db->RunQuery($SQL);
	
		$LoadPopUpReturnNoXML .="<option value=\"".""."\">"."Select one"."</option>";
	while($row = mysql_fetch_array($result))
	{	
		$LoadPopUpReturnNoXML .="<option value=>" . $row["intFRollSerialNO"] ."</option>\n";
	}
	$LoadPopUpReturnNoXML.="</LoadPopUpReturnNo>";
	echo $LoadPopUpReturnNoXML;
}
else if($RequestType=="LoadHeaderDetailsToMain")
{
	$No			= $_GET["No"];
	$rollNo 	= explode('/',$No);
	$batchNo	= $_GET['batchNo'];
	
$ResponseXML ="";
$ResponseXML .="<LoadHeaderDetailsToMain>\n";
$sql="";
 $sql="select 
intFRollSerialNo,
intFRollSerialYear,
intPoNo,
intPoYear,
intSRNO,
FH.intStyleId,
FH.intStatus,
strSupplierBatchNo,
strCompanyBatchNo,
strColor,
strSupplierID,
(select strTitle from suppliers S where S.strSupplierID=FH.strSupplierID)AS supplierName,
(SELECT strStyle FROM orders O WHERE O.intStyleId = FH.intStyleId) AS strStyle, 
strBuyerPoNo,
strMatDetailID,
MIL.strItemDescription,
strRemarks
from fabricrollheader FH 
inner join specification SP on SP.intStyleId=FH.intStyleId
Inner JOIN matitemlist MIL on MIL.intItemSerial=FH.strMatDetailID ";
if(!empty($No)){
	$sql.="where intFRollSerialNO='$rollNo[1]' and intFRollSerialYear='$rollNo[0]'";
}
if(!empty($batchNo)){
	$sql.=" and strSupplierBatchNo='$batchNo';";
}
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .="<FRollSerialNo><![CDATA[".$row["intFRollSerialYear"].'/'.$row["intFRollSerialNo"]."]]></FRollSerialNo>\n";
	$ResponseXML .="<PoNo><![CDATA[".$row["intPoNo"]."]]></PoNo>\n";
	$ResponseXML .="<PoYear><![CDATA[".$row["intPoYear"]."]]></PoYear>\n";
	$ResponseXML .="<SRNO><![CDATA[".$row["intSRNO"]."]]></SRNO>\n";
	$ResponseXML .="<StyleID><![CDATA[".$row["strStyle"]."]]></StyleID>\n";
	$ResponseXML .="<BuyerPoNo><![CDATA[".$row["strBuyerPoNo"]."]]></BuyerPoNo>\n";
	$ResponseXML .="<SupplierBatchNo><![CDATA[".$row["strSupplierBatchNo"]."]]></SupplierBatchNo>\n";
	$ResponseXML .="<CompanyBatchNo><![CDATA[".$row["strCompanyBatchNo"]."]]></CompanyBatchNo>\n";
	$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
	$ResponseXML .="<SupplierID><![CDATA[".$row["strSupplierID"]."]]></SupplierID>\n";
	$ResponseXML .="<SupplierName><![CDATA[".$row["supplierName"]."]]></SupplierName>\n";
	$ResponseXML .="<MatDetailID><![CDATA[".$row["strMatDetailID"]."]]></MatDetailID>\n";
	$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
	$ResponseXML .="<Remarks><![CDATA[".$row["strRemarks"]."]]></Remarks>\n";	
	$ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";
}
$ResponseXML .="</LoadHeaderDetailsToMain>";
echo $ResponseXML;
}
else if($RequestType=="LoadDetailsToMainRequest")
{
	$No	= $_GET["No"];
		$rollNo = explode('/',$No);
$ResponseXML ="";
$ResponseXML .="<LoadDetailsToMainRequest>\n";
$sql="";
$sql="select * from fabricrolldetails 
where intFRollSerialNO='$rollNo[1]'
AND intFRollSerialYear='$rollNo[0]'
ORDER BY intRollNo;";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .="<RollNo><![CDATA[".$row["intRollNo"]."]]></RollNo>\n";
	$ResponseXML .="<SuppWidth><![CDATA[".$row["dblSuppWidth"]."]]></SuppWidth>\n";
	$ResponseXML .="<CompWidth><![CDATA[".$row["dblCompWidth"]."]]></CompWidth>\n";
	$ResponseXML .="<WidthUOM><![CDATA[".$row["strWidthUOM"]."]]></WidthUOM>\n";
	$ResponseXML .="<SuppLength><![CDATA[".$row["dblSuppLength"]."]]></SuppLength>\n";
	$ResponseXML .="<CompLength><![CDATA[".$row["dblCompLength"]."]]></CompLength>\n";
	$ResponseXML .="<LengthUOM><![CDATA[".$row["strLengthUOM"]."]]></LengthUOM>\n";
	$ResponseXML .="<SuppWeight><![CDATA[".$row["dblSuppWeight"]."]]></SuppWeight>\n";
	$ResponseXML .="<CompWeight><![CDATA[".$row["dblCompWeight"]."]]></CompWeight>\n";
	$ResponseXML .="<WeightUOM><![CDATA[".$row["strWeightUOM"]."]]></WeightUOM>\n";
	$ResponseXML .="<SpecialComments><![CDATA[".$row["strSpecialComments"]."]]></SpecialComments>\n";
	$ResponseXML .="<Approved><![CDATA[".$row["intApproved"]."]]></Approved>\n";

}
$ResponseXML .="</LoadDetailsToMainRequest>";
echo $ResponseXML;
}
elseif($RequestType=="LoadPopUpRollNo")
{
	$batchNo =$_GET["batchNo"];
	$SupplierID =$_GET["SupplierID"];
	
	$ResponseXML .="<LoadPoNo>\n";
	
	$SQL = "SELECT concat(intFRollSerialYear,'/',intFRollSerialNO)AS SerialNo  from fabricrollheader where intFRollSerialNO<>0";
	if($batchNo!="")
		$SQL .= " AND strSupplierBatchNo='$batchNo'";
	if($SupplierID!="")
		$SQL .= " AND strSupplierID='$SupplierID'";
		
		$SQL .= " AND intCompanyID='$CompanyId' Order By intFRollSerialYear,intFRollSerialNO DESC";
	//echo $SQL;
	$result=$db->RunQuery($SQL);	
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<PO><![CDATA[".$row["SerialNo"]."]]></PO>" ;
		}
	$ResponseXML .="</LoadPoNo>";
	echo $ResponseXML;
}

else if($RequestType=="LoadPopUpBatchNo"){
	$batchNo =$_GET["batchNo"];
	$SupplierID =$_GET["SupplierID"];
	
	
	$ResponseXML .="<BatchNo>\n";
	
  	$SQL = "select distinct strSupplierBatchNo from fabricrollheader where intStatus='1' AND intCompanyID='$CompanyId'";
	if($SupplierID!="")
		$SQL .= " AND strSupplierID='$SupplierID'";
		
		$SQL .= " Order By   intFRollSerialYear,intFRollSerialNO DESC;";
	//echo $SQL;
	$result=$db->RunQuery($SQL);	
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<Batch><![CDATA[".$row["strSupplierBatchNo"]."]]></Batch>" ;
		}
	$ResponseXML .="</BatchNo>";
	echo $ResponseXML;
}
else if($RequestType == "LoadSuppBatchNo")
{
	$Mode = $_GET["Mode"];
	$SupplierId = $_GET["SupplierId"];
	$companyId = $_GET['companyId'];
	
	$ResponseXML .= "<BatchNo>\n";
	
	$sql = "select distinct strSupplierBatchNo from fabricrollheader where intStatus='$Mode' AND intCompanyID='$companyId' AND strSupplierID='$SupplierId'";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=" .$row["strSupplierBatchNo"]. ">" .$row["strSupplierBatchNo"]. "</option>";
	}
	
	$ResponseXML .= "</BatchNo>\n";
	echo $ResponseXML;
}
else if($RequestType== "LoadSupplierToMode")
{
	
	$Mode = $_GET["Mode"];
	$companyId = $_GET['companyId'];
	
	$ResponseXML .= "<Supplier>\n";
	
 	$sql = "SELECT 
suppliers.strTitle,
fabricrollheader.strSupplierID
FROM
suppliers
INNER JOIN fabricrollheader ON fabricrollheader.strSupplierID = suppliers.strSupplierID
WHERE
fabricrollheader.intStatus = '$Mode' AND intCompanyID='$companyId'";	

	$result = $db->RunQuery($sql);
	//while($row = mysql_fetch_array($result))
//	{
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		}
	//}
	
	$ResponseXML .= "</Supplier>";
	echo $ResponseXML;

}
else if($RequestType == "LoadRollNoToMode")
{
	$Mode = $_GET['Mode'];
	$SupplierId = $_GET['SupplierId'];
	$SuppBatchNo = $_GET['SuppBatchNo'];
	$companyId = $_GET['companyId'];
	
	$ResponseXML .= "<RollNo>\n";
	
	echo $sql = "SELECT concat(intFRollSerialYear,'/',intFRollSerialNO)AS SerialNo  from fabricrollheader where intFRollSerialNO<>0 
AND strSupplierBatchNo='$SuppBatchNo' AND strSupplierID='$SupplierId'
AND intCompanyID='$companyId' AND intStatus='$Mode' Order By intFRollSerialYear,intFRollSerialNO DESC";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["SerialNo"].">".$row["SerialNo"]."</option>";
	}
	
	$ResponseXML .= "</RollNo>";
	echo $ResponseXML;
}

elseif($RequestType=="DeleteRow")
{
$rollSerialNo	= $_GET["rollSerialNo"];
$rollSerialNoArray	= explode('/',$rollSerialNo);
$rollNo		= $_GET["rollNo"];
$sql ="delete from fabricrolldetails where intFRollSerialNO='$rollSerialNoArray[1]' and intFRollSerialYear='$rollSerialNoArray[0]' and intRollNo='$rollNo'";
$result=$db->RunQuery($sql);
}
elseif($RequestType=="Cancel")
{
	$rollSerialNo	= $_GET["rollSerialNo"];
	$rollSerialNoArray	= explode('/',$rollSerialNo);
	
	$sql1 ="update fabricrollheader set intStatus=10 
			where intFRollSerialNO='$rollSerialNoArray[1]'
			and intFRollSerialYear='$rollSerialNoArray[0]'";
			
	$result1 = $db->RunQuery($sql1);
	
	$sql2 = "UPDATE fabricrolldetails SET intStatus = 10 WHERE intFRollSerialNO='$rollSerialNoArray[1]' AND 	 	 	 	 	 			    			   																						intFRollSerialYear='$rollSerialNoArray[0]'";
	
	$result2 = $db->RunQuery($sql2);
	
	$result = ($result1 + $result2 )/2; 
			
	$ResponseXML ="<Cancel>\n";
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
	$ResponseXML .= "</Cancel>\n";
	echo $ResponseXML;
	
}
else if($RequestType=="revise"){
$rollSerialNo	= $_GET["rollSerialNo"];
$rollSerialNoArray	= explode('/',$rollSerialNo);
$sql="update fabricrollheader set intStatus='0' where intFRollSerialNO='$rollSerialNoArray[1]' and intFRollSerialYear='$rollSerialNoArray[0]'";
//echo $sql;
$ResponseXML ="<Revise>\n";
	$result=$db->RunQuery($sql);
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
$ResponseXML .= "</Revise>\n";
echo $ResponseXML;
}

else if($RequestType=="updateHeader"){
$rollSerialNo	= $_GET["rollSerialNo"];
$serialYear		= $_GET["serialYear"];
$sql="update fabricrollheader set intStatus='1' where intFRollSerialNO='$rollSerialNo' and intFRollSerialYear='$serialYear'";
//echo $sql;
$result=$db->RunQuery($sql);
	if($result==1){
	$ResponseXML ="<UPhead>\n";
	$result=$db->RunQuery($sql);
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
	$ResponseXML .= "</UPhead>\n";
	echo $ResponseXML;
	}
}

else if($RequestType="updateDet"){
	$rollSerialNo = $_GET["rollSerialNo"];
	$rollSerialNoArray	= explode('/',$rollSerialNo);
	$RollNo 		= $_GET["RollNo"];	
	$SuppWidth		= $_GET["SuppWidth"];
	$CompWidth 		= $_GET["CompWidth"];
	$WidthUOM 		= $_GET["WidthUOM"];
	$SuppLength 	= $_GET["SuppLength"];
	$CompLength 	= $_GET["CompLength"];	
	$LengthUOM 		= $_GET["LengthUOM"];
	$SuppWeight 	= $_GET["SuppWeight"];		
	$CompWeight 	= $_GET["CompWeight"];
	$WeighUOM		= $_GET["WeighUOM"];
	$SpecialComm	= $_GET["SpecialComm"];
	$r				=$_GET['r'];


updateDet($rollSerialNoArray[1],$rollSerialNoArray[0],$RollNo,$SuppWidth,$CompWidth,$WidthUOM,$SuppLength,$CompLength,$LengthUOM,$SuppWeight,$CompWeight,$WeighUOM,$SuppLength,$SpecialComm,$r);

}
function updateDet($rollSerialNo,$rollSerialYear,$RollNo,$SuppWidth,$CompWidth,$WidthUOM,$SuppLength,$CompLength ,$LengthUOM,$SuppWeight,$CompWeight,$WeighUOM,$SuppLength,$SpecialComm,$r){
global $db;

$sqlUpdate="UPDATE fabricrolldetails SET 
dblSuppWidth='$SuppWidth' , 
dblCompWidth='$CompWidth' ,
strWidthUOM='$WidthUOM' ,
dblSuppLength='$SuppLength', 
dblCompLength='$CompLength',
strLengthUOM='$LengthUOM',
dblSuppWeight='$SuppWeight',
dblCompWeight='$CompWeight',
strWeightUOM='$WeighUOM',
dblQty='$SuppLength',
strSpecialComments='$SpecialComm' 
WHERE intFRollSerialNO='$rollSerialNo' AND intFRollSerialYear='$rollSerialYear' AND intRollNo='$RollNo';";

//echo $sqlUpdate;
$result=$db->RunQuery($sqlUpdate);
if($result==1)
{
	$ResponseXML ="<UPDet>\n";
	$ResponseXML .="<Result><![CDATA[". $result ."]]></Result>\n";
	$ResponseXML .= "</UPDet>\n";
	echo $ResponseXML;
}

}
?>
