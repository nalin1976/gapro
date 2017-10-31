<?php
session_start();
require_once('../../Connector.php');

$Request	= $_GET["Request"];
$companyId	= $_SESSION["FactoryID"];
$userid		= $_SESSION["UserID"];

if($Request=="loadSubCategory")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$cboMainId = $_GET["cboMainId"];
	$ResponseXML .= "<genmatsubcategory>";
	
	$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$cboMainId   ORDER BY StrCatName";
	$result = $db->RunQuery($SQL);
	
	$str = '';
	$str .= "<option value=\"". "" ."\">" . "" ."</option>";
		
		
			while($row = mysql_fetch_array($result))
			{
				 $str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
				 
				 
			}
			$ResponseXML .= "<intSubCatNo><![CDATA[" . $str . "]]></intSubCatNo>\n";
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}
if($Request=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLURLLoadPopItems>";

$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
$PRNo 		= $_GET["PRNo"];
$arrayPRNo	= explode('/',$PRNo);
	
	$sql="select intItemSerial,strItemDescription,strUnit from genmatitemlist where intStatus=1 ";
if($PRNo!="")	
	$sql .= "and intItemSerial in(select GD.intMatDetailID from generalpurchaseorderdetails GD  where intGenPoNo='$arrayPRNo[1]' and intYear='$arrayPRNo[0]') ";
if($mainCat!="")	
	$sql .= "and intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and strItemDescription like '%$itemDesc%' ";
	
	$sql .= "order by strItemDescription ";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
		
if($Request=="loadDetailsMainTbl")		
{
		$txtPRNo 	= $_GET["txtPRNo"];
		$matId 		= $_GET["matId"];
		$arraytxtPRNo	= explode('/',$txtPRNo);
		
		header('Content-Type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML = "<XMLURLLoadToItem>";
		
		if($txtPRNo!="")
		{
				$load_sql ="select gm.intItemSerial,p.strUnit,gm.strItemDescription,p.dblQty
				from genmatitemlist gm inner join generalpurchaseorderdetails p on
				p.intMatDetailId = gm.intItemSerial
				inner join generalpurchaseorderheader ph on 
				ph.intGenPONo = p.intGenPONo and p.intYear = ph.intYear
				where ph.intGenPONo='$arraytxtPRNo[1]' and ph.intYear='$arraytxtPRNo[0]' and gm.intItemSerial=$matId ;";
				
		}
		else
		{
				$load_sql ="select gm.intItemSerial,gm.strItemDescription, gm.strUnit,0 as dblQty
				from genmatitemlist gm inner join genmatmaincategory gmat on
				gm.intMainCatID = gmat.intID
				where gm.intItemSerial=$matId ;";
		}
		
		$result = $db->RunQuery($load_sql);	
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
			$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
			$ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
			

		}
		$ResponseXML .= "</XMLURLLoadToItem>";
		echo $ResponseXML;
	

}

if($Request=="LoadGPONo")
{
	$sql="select concat(intYear,'/',intGenPONo)as gpono from generalpurchaseorderheader order by intYear,intGenPONo;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array .= $row['gpono']."|";
	}
	echo $array;
}
if($Request=="getGPNo")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$str_id			    = "select dblGenNormalGatePass from  syscontrol where intCompanyID = $companyId ";
	$result_id			= $db->RunQuery($str_id);
	$data_id			= mysql_fetch_array($result_id);
	$str_id_update		= "update syscontrol set dblGenNormalGatePass=dblGenNormalGatePass+1 where intCompanyID = $companyId ";
	$result_id_update	= $db->RunQuery($str_id_update);
	$id					= $data_id["dblGenNormalGatePass"];
	
	$xml_string.='<data>';
	
	if($result_id_update) 
		{
			$xml_string .=  "<ID><![CDATA[". $id  ."]]></ID>\n";
			$xml_string .=  "<year><![CDATA[". date('Y')  ."]]></year>\n";
		}
	
	$xml_string.='</data>';
	echo $xml_string;
}
if($Request=="save_header")
{
	$pub_No		= $_GET["pub_No"];
	$pub_Year	= $_GET["pub_Year"];
	$date		= $_GET["date"];
	$GPto		= $_GET["GPto"];
	$attention	= $_GET["attention"];
	$through	= $_GET["through"];
	$instby		= $_GET["instby"];
	$remark		= $_GET["remark"];
	$style		= $_GET["style"];
	$spintruct	= $_GET["spintruct"];
	
	
	
	if(!checkValueExist($pub_No,$pub_Year))
	{
			
		$sql="INSERT INTO general_nomgatepass_header (intGatepassId,intYear,strToStores,strAttention,strThrough,strInstructedBy,dtmDate,intStatus,intCompanyId,intUserId,strInstructions,strRemarks,strStyleID) VALUES($pub_No,$pub_Year,'$GPto','$attention','$through','$instby',now(),0,'$companyId','$userid','$spintruct','$remark','$style');";	
			
			$result_sql			= $db->RunQuery($sql) ;
			if($result_sql)
				echo "Saved successfully.";
	}
	else
	{
		
		$sql_update="UPDATE general_nomgatepass_header SET strToStores='$GPto',strAttention='$attention',strThrough='$through',strInstructedBy='$instby',dtmDate=now(),intStatus=0,intCompanyId='$companyId',intUserId='$userid',strInstructions='$spintruct',strRemarks='$remark',strStyleID='$style' WHERE intGatepassId='$pub_No' AND intYear='$pub_Year';";
		
		
		$result_update			= $db->RunQuery($sql_update) ;
		if($result_update)
				echo "Update successfully";
		
	}

}
if($Request=="save_detail")
{
	$strPONo		= $_GET["strPONo"];
	$dblQty			= $_GET["dblQty"];
	$dblunit		= $_GET["dblunit"];
	$pub_No			= $_GET["pub_No"];
	$Itemserial		= $_GET["Itemserial"];
	$pub_Year		= $_GET["pub_Year"];
	$retunable		= $_GET["retunable"];
	
	
	$sql_delete="DELETE FROM general_nomgatepass_detail WHERE intGatepassId='$pub_No' AND intYear='$pub_Year' AND strPRNo='$strPONo' AND intMatDetailId='$Itemserial';";
	$result_delete=$db->RunQuery($sql_delete);
	
	$sql="INSERT INTO general_nomgatepass_detail (intGatepassId,intYear,strPRNo,intMatDetailId,dblQty,strUnit,intReturnable) VALUES ('$pub_No','$pub_Year','$strPONo','$Itemserial','$dblQty','$dblunit','$retunable');";
	$result=$db->RunQuery($sql);
	if($result)
	{
		echo "Saved";
	}
		
	
}
if($Request=="LoadHeaderDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$no			= $_GET["no"];
	$year		= $_GET["year"];
	
	$ResponseXML = "";
	$ResponseXML .= "<LoadHeaderDetails>\n";
	
	$sql="SELECT concat(GH.intYear,'/',GH.intGatepassId)AS gatePassNo,GH.strRemarks,GH.strAttention,GH.strThrough,GH.strToStores,GH.strInstructedBy,GH.strStyleID,GH.strInstructions,substr(GH.dtmDate,1,10) as dtmDate
	FROM general_nomgatepass_header GH 
	WHERE GH.intGatepassId ='$no'
	AND GH.intYear ='$year';";
	
		$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{		
			$ResponseXML .= "<GatePassNo><![CDATA[" . $row["gatePassNo"]. "]]></GatePassNo>\n";
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]. "]]></Remarks>\n";
			$ResponseXML .= "<Attention><![CDATA[" . $row["strAttention"]. "]]></Attention>\n";
			$ResponseXML .= "<Through><![CDATA[" . $row["strThrough"]. "]]></Through>\n";
			$ResponseXML .= "<ToStores><![CDATA[" . $row["strToStores"]. "]]></ToStores>\n";
			$ResponseXML .= "<InstructedBy><![CDATA[" . $row["strInstructedBy"]. "]]></InstructedBy>\n";
			$ResponseXML .= "<StyleID><![CDATA[" . $row["strStyleID"]. "]]></StyleID>\n";
			$ResponseXML .= "<Instructions><![CDATA[" . $row["strInstructions"]. "]]></Instructions>\n";
			$ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"]. "]]></Date>\n";
		}
	
	$ResponseXML .= "</LoadHeaderDetails>";
	echo $ResponseXML;
}
if($Request=="LoadGatePassDetails")
{

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$no			= $_GET["no"];
	$year		= $_GET["year"];
	
	$ResponseXML = "";
	$ResponseXML .= "<LoadGatePassDetails>";
	
	$sql="SELECT GD.intMatDetailID,GD.strPRNo,GD.dblQty,GD.strUnit,GD.intReturnable,GI.strItemDescription
	FROM general_nomgatepass_detail GD inner join genmatitemlist GI on GD.intMatDetailID=GI.intItemSerial
	WHERE GD.intGatepassId ='$no'
	AND GD.intYear ='$year'";
	
		$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{	
			$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"]. "]]></MatDetailID>\n";	
			$ResponseXML .= "<Description><![CDATA[" . $row["strItemDescription"]. "]]></Description>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]. "]]></Qty>\n";
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]. "]]></Unit>\n";
			$ResponseXML .= "<Returnable><![CDATA[" . $row["intReturnable"]. "]]></Returnable>\n";
			$ResponseXML .= "<PRNo><![CDATA[" . $row["strPRNo"]. "]]></PRNo>\n";
		}
	
	$ResponseXML .= "</LoadGatePassDetails>";
	echo $ResponseXML;
}
function checkValueExist($pub_No,$pub_Year)
{
	global $db;
	$sql="select * from general_nomgatepass_header where intGatepassId='$pub_No' AND intYear='$pub_Year';";
	
	$result=$db->RunQuery($sql);
		if(mysql_num_rows($result) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
}

?>