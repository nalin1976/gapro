<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$RequestType = $_GET["RequestType"];
if (strcmp($RequestType,"MarkPostBatch") == 0)
{
	$BatchId = $_GET["BatchId"];	
	$ResponseXML = "<RequestDetails>";	
	MarkPostBatch($BatchId);
	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

else if (strcmp($RequestType,"MarkUnPostBatch") == 0)
{
	$BatchId = $_GET["BatchId"];	
	$ResponseXML = "<RequestDetails>";	
	MarkUnPostBatch($BatchId);
	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

else if (strcmp($RequestType,"SaveBatch") == 0)
{		
$intBatch		= $_GET["intBatch"];
$intBatchType	= $_GET["intBatchType"];
$strDescription	= $_GET["strDescription"];
$strCurrency	= $_GET["strCurrency"];
$strBankCode	= $_GET["strBankCode"];
$dtmDate		= $_GET["dtmDate"];
$accountNo		= $_GET["AccountNo"];
$ResponseXML 	= "<RequestDetails>";

	if(empty($intBatch))
	{
		$reschk=chkDuplicate($strDescription);	
		if($reschk > 0)
		{
			$ResponseXML .= "<Result><![CDATA[".-4 ."]]></Result>\n";
			$ResponseXML .= "<BatchNo><![CDATA[".$strDescription."]]></BatchNo>\n";
		}
		else
		{
			$res=getBatchNoTask(1);
			while($row=mysql_fetch_array($res)){
			 $intBatch=$row['dblBatchNo']+1;
		}
			$ResponseXML .= "<Result><![CDATA[".SaveBatch($intBatch,$intBatchType,$strDescription,$strCurrency,$strBankCode,$dtmDate,$accountNo)."]]></Result>\n";
			$ResponseXML .= "<BatchNo><![CDATA[".$intBatch."]]></BatchNo>\n";
		}
	}
	else
	{
		$reschk=chkDuplicatedes($strDescription,$intBatch);	
		if($reschk > 0)
		{
			$ResponseXML .= "<Result><![CDATA[".-5 ."]]></Result>\n";
			$ResponseXML .= "<BatchNo><![CDATA[".$intBatch."]]></BatchNo>\n";			
		}
		else 
		{
			$ResponseXML .= "<Result><![CDATA[".SaveBatch($intBatch,$intBatchType,$strDescription,$strCurrency,$strBankCode,$dtmDate,$accountNo)."]]></Result>\n";
			$ResponseXML .= "<BatchNo><![CDATA[".$intBatch."]]></BatchNo>\n";
		}
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getAllBatches") == 0)
{		
	$ResponseXML = "<RequestDetails>";	
	$result=getAllBatches();
	while($row = mysql_fetch_array($result))
	{
		$type=$row["intBatchType"];				
		$ResponseXML .= "<batchNo><![CDATA[" . $row["intBatch"]  . "]]></batchNo>\n";
		$ResponseXML .= "<desc><![CDATA[" . $row["strDescription"]  . "]]></desc>\n";
		$ResponseXML .= "<type><![CDATA[" . $type  . "]]></type>\n";
		$ResponseXML .= "<date><![CDATA[" . $row["dtmDate"]  . "]]></date>\n";
		$ResponseXML .= "<currency><![CDATA[" . $row["strCurrency"]  . "]]></currency>\n";
		$ResponseXML .= "<currencyName><![CDATA[" . $row["currencyName"]  . "]]></currencyName>\n";
		$ResponseXML .= "<bank><![CDATA[" . $row["strName"]  . "]]></bank>\n";
		$ResponseXML .= "<bankCode><![CDATA[" . $row["strBankCode"]  . "]]></bankCode>\n";
		$ResponseXML .= "<posted><![CDATA[" . $row["posted"]  . "]]></posted>\n";
	}

	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

else if (strcmp($RequestType,"BatchNoTask") == 0)
{	
	 $task=$_GET["task"];	 
	 $ResponseXML = "";
	 $ResponseXML .= "<BatchNoTask>\n";
			 
	 $result=getBatchNoTask($task);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<batchNo><![CDATA[" . $row["dblBatchNo"]  . "]]></batchNo>\n";
	 }
	 $ResponseXML .= "</BatchNoTask>";
	 echo $ResponseXML;
}
elseif($RequestType=="loadCurrency")
{
			$SQL="SELECT currencytypes.strCurrency,currencytypes.strTitle FROM currencytypes WHERE currencytypes.intStatus=1 order by currencytypes.strTitle;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
}
elseif($RequestType=="LoadBankMode")
{
	$SQL = "SELECT intBranchId,strName FROM branch WHERE intStatus='1' order by intBranchId asc";
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$x = $row["strName"];
		echo "<option value=\"". $row["intBranchId"] ."\">" . cdata($x) ."</option>" ;
	}
}
elseif($RequestType=="LoadAccountDetails")
{
$branchId	= $_GET["BranchId"];
	$SQL = "select intCurrencyId,strAccountNo from branch_accounts where intBranchId=$branchId and intStatus=1 order by strAccountNo";
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "null" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCurrencyId"] ."\">" . cdata($row["strAccountNo"]) ."</option>" ;
	}
}
else if($RequestType=="LoadBatch")
{
$batchId = $_GET["BatchId"];
$ResponseXML = "<XMLLoadBatch>\n";
$result = LoadBatchSql($batchId);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<BatchId><![CDATA[" . $batchId  . "]]></BatchId>\n";
		$ResponseXML .= "<BatchType><![CDATA[" . $row["intBatchType"]  . "]]></BatchType>\n";
		$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<BankId><![CDATA[" . $row["strBankCode"]  . "]]></BankId>\n";
		$dateArray 	  = explode('-',$row["dtmDate"]);
		$formatedDate = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
		$ResponseXML .= "<Date><![CDATA[" . $formatedDate  . "]]></Date>\n";
		$ResponseXML .= "<IsUsed><![CDATA[" . $row["intUsed"]  . "]]></IsUsed>\n";
		$ResponseXML .= "<postedStatus><![CDATA[" . $row["posted"]  . "]]></postedStatus>\n";
		
	}
$ResponseXML .= "</XMLLoadBatch>\n";
echo $ResponseXML;
}
else if($RequestType=="DeleteBatch")
{
$ResponseXML = "<XMLDeleteBatch>\n";
$batchId	= $_GET["BatchId"];
$sql="delete from batch where intBatch=$batchId";
$result = $db->RunQuery2($sql);
if(gettype($result)=='string')
	$ResponseXML .= "<Result><![CDATA[" . $result  . "]]></Result>\n";
else
	$ResponseXML .= "<Result><![CDATA[" . "Deleted successfully."  . "]]></Result>\n";
	
$ResponseXML .= "</XMLDeleteBatch>\n";
echo $ResponseXML;	
}
if($RequestType=="writetxt")
{
	$bool = "false";
	$batchDes = 0;
	$batchNo = $_GET["batchNo"];
	$SQL_BATCH ="select strDescription from batch where intBatch='$batchNo';";
	$result_batch =$db->RunQuery($SQL_BATCH);
	while($row_batch=mysql_fetch_array($result_batch))
	{
		$batchDes = $row_batch["strDescription"];
		$batchDes  = str_replace(" ", "", $batchDes);
	}
	$date = date("Y-m-d");
 	$myFile = "Invoices_"."$batchNo"."_"."$date".".txt";
	$fh = fopen("Batch/".$myFile, 'w') or die("cannot open file");
	//$path='\\\\192.168.137.1\\share\\Invoices_aaa_2011-08-05.txt';
	//$fh = fopen($path, 'w') or die("can't open file $path");

	$stringData ='"RECTYPE","CNTBTCH","CNTITEM","IDVEND","IDINVC","TEXTTRX","IDTRX","PONBR","INVCDESC","DATEINVC","AMTGROSTOT","CODECURN","RATETYPE","EXCHRATEHC"';
	
	fwrite($fh, $stringData."\r\n");
	$stringData = '"RECTYPE","CNTBTCH","CNTITEM","CNTLINE","IDGLACCT","AMTDIST","AMTGLDIST"';
	fwrite($fh, $stringData."\r\n");
	$stringData = '"RECTYPE","CNTBTCH","CNTITEM","CNTPAYM","DATEDUE","AMTDUE"';
	fwrite($fh, $stringData."\r\n");
	
	$sql = "select IH.strBatchNo,IH.intEntryNo,S.strAccPaccID,IH.strInvoiceNo,IH.strSupplierId,
			IH.strDescription,DATE_FORMAT(IH.dtmDate,'%Y%m%d') as invoiceDate,round(IH.dblInvoiceAmount,4) as dblInvoiceAmount,CT.strCurrency,IH.dblCurrencyRate,IH.strType
			from invoiceheader IH
			inner join suppliers S on IH.strSupplierId=S.strSupplierID
			inner join currencytypes CT on CT.intCurID = IH.strCurrency
			where IH.strBatchNo ='$batchNo' order by intEntryNo";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$invoiceNo = $row["strInvoiceNo"];
		$type = $row["strType"];
		$suppierId = $row["strSupplierId"];
	
		$stringData ='"1","'.$row["strBatchNo"].'","'.$row["intEntryNo"].'","'.$row["strAccPaccID"].'","'.$row["strInvoiceNo"].'","1","12","'.getPONo($batchNo,$invoiceNo,$type,$suppierId).'","'.$row["strDescription"].'","'.$row["invoiceDate"].'","'.$row["dblInvoiceAmount"].'","'.$row["strCurrency"].'","AV","'.$row["dblCurrencyRate"].'"';
		fwrite($fh, $stringData."\r\n");
		
		$sqlgl="select IGB.dblAmount,IGB.strInvoiceNo,concat(GLA.strAccID,'',CC.strCode) as GLAccNo
				from invoiceglbreakdown IGB
				left join glallowcation GA on GA.GLAccAllowNo=IGB.strAccID
				inner join glaccounts GLA on GLA.intGLAccID = GA.GLAccNo
				inner join costcenters CC on CC.intCostCenterId = GA.FactoryCode
				where IGB.strInvoiceNo='$invoiceNo' 
				and IGB.strType='$type' 
				and IGB.strSupplierId='$suppierId';";		
		$resultgl = $db->RunQuery($sqlgl);
		while($rowgl=mysql_fetch_array($resultgl))
			{
				$i = 1;
				$stringData ='"2","'.$row["strBatchNo"].'","'.$row["intEntryNo"].'","'.$i.'","'.$rowgl["GLAccNo"].'","'.$rowgl["dblAmount"].'","'.$rowgl["dblAmount"].'"';
				fwrite($fh, $stringData."\r\n");
				$i++;
			}
			
			$SQL = "select IH.intCreditPeriod,IH.dblTotalAmount,DATE_FORMAT(DATE_ADD(date(dtmDate),INTERVAL IH.intCreditPeriod DAY),'%Y%m%d') as invoiceDate
			from invoiceheader IH
			where IH.strInvoiceNo='$invoiceNo' and IH.strType='$type' and IH.strSupplierId='$suppierId'";
			$RESULT = $db->RunQuery($SQL);
			while($ROW=mysql_fetch_array($RESULT))
			{
				$stringData ='"3","'.$row["strBatchNo"].'","'.$row["intEntryNo"].'","1","'.$ROW["invoiceDate"].'","'.$ROW["dblTotalAmount"].'"';
				fwrite($fh, $stringData."\r\n");
				$bool = "true";
			}
	}
	fclose($fh);
	if($bool=="true")
	{
		MarkPostBatch($batchNo,$myFile);
	}
	$ResponseXML = "<XMLBatchNo>\n";
	$ResponseXML .= "<boolcheck><![CDATA[" .$bool. "]]></boolcheck>\n";
	$ResponseXML .= "<txtFileName><![CDATA[" .$myFile. "]]></txtFileName>\n";
	$ResponseXML .= "</XMLBatchNo>\n";
	echo $ResponseXML;
}
if($RequestType=="openTXTFile")
{
	$batchId = $_GET["batchId"];
	$sql_getFileName = "select strBatchFileName from batch where intBatch='$batchId'";
	$result = $db->RunQuery($sql_getFileName);
	while($row=mysql_fetch_array($result))
	{
		$fileName = $row["strBatchFileName"];
		$path = "Batch/$fileName";
		$file = basename($path);
		$size = filesize($path);
		
		header ("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Length: $size");
	
	readfile($path);
	}
}
function getAllBatches()
{
	global $db;
	$sql = "SELECT BA.*,BR.strName,CT.strCurrency as currencyName FROM batch BA left JOIN branch BR ON BA.strBankCode=BR.intBranchId left join currencytypes CT on CT.intCurID=BA.strCurrency where BA.intCompID=".$_SESSION["FactoryID"]." ORDER BY  BA.intBatch DESC";
	$result=$db->executeQuery($sql);
	return $result;	
}

function getBatchNoTask($task)
{
	global $db; 
	if($task==1)
	{
		$strSQL="SELECT dblBatchNo FROM syscontrol WHERE intCompanyID =".$_SESSION["FactoryID"]."";		
		//echo $strSQL;
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($task==2)
	{
		$strSQLU="update syscontrol set dblBatchNo=dblBatchNo+1 WHERE intCompanyID =".$_SESSION["FactoryID"]."";
		$resultU=$db->RunQuery($strSQLU);
		$strSQLS="SELECT dblBatchNo FROM syscontrol WHERE intCompanyID =".$_SESSION["FactoryID"]."";
		$resultS=$db->RunQuery($strSQLS);
		return $resultS;		
	}	
}

function MarkPostBatch($BId,$myFile)
{
	global $db;
	$sql = "UPDATE batch SET posted=1 , strBatchFileName = '$myFile' WHERE intBatch='$BId' ";
	//echo $sql;
	$res=$db->executeQuery($sql);
	//echo $res;
	if($res==1){
		return true;	
	}
}

function MarkUnPostBatch($BId)
{
	global $db;
	$sql = "UPDATE batch SET posted=0 WHERE intBatch='$BId'";
	$res=$db->executeQuery($sql);
	//echo $res;
	if($res==1){
		return true;	
	}	
}

function SaveBatch($intBatch,$intBatchType,$strDescription,$strCurrency,$strBankCode,$dtmDate,$accountNo)
{
	global $db;	
	$sql = "SELECT intBatch FROM batch WHERE intBatch='$intBatch'";	
	$result = $db->RunQuery($sql);
	$rows = mysql_num_rows($result);	

	if ($rows >0)
	{		
		$sql ="UPDATE batch SET	intBatchType = $intBatchType,strDescription='$strDescription',strCurrency = $strCurrency , strBankCode = $strBankCode, dtmDate = '$dtmDate',strAccountNo='$accountNo' WHERE intBatch = $intBatch ;";
		$affrows = $db->RunQuery($sql);
		if ( $affrows != 0 ) return -2;		
	}
	else
	{	
		$sql = "INSERT INTO batch (intBatch,intBatchType, strDescription, strCurrency, strBankCode, dtmDate,intCompID,strAccountNo)	VALUES ($intBatch,$intBatchType, '$strDescription',$strCurrency,$strBankCode,'$dtmDate',".$_SESSION["FactoryID"].",'$accountNo');";
		$newID = $db->RunQuery($sql);
		if($newID==1){
			return $newID;	
		}
		else
		{
			return -3;
		}
	}
}
// to check the duplicated descriptions
function chkDuplicate($strDescription){
	global $db;
	$sqlChkD="select intBatch from batch where strDescription='$strDescription';";
	$res=$db->RunQuery($sqlChkD);
	return mysql_num_rows($res);
}
function chkDuplicatedes($strDescription,$intBatch){
	global $db;
	$sqlChkD="select intBatch from batch where strDescription='$strDescription' and intBatch <> '$intBatch';";
	$res=$db->RunQuery($sqlChkD);
	return mysql_num_rows($res);
}
function LoadBatchSql($batchId)
{	
global $db;
	$sql="select B.intBatchType,B.strDescription,B.strCurrency,B.strBankCode,B.dtmDate,B.strAccountNo,B.intUsed,B.posted from batch B where B.intBatch=$batchId";
	return $db->RunQuery($sql);
}
function getPONo($batchNo,$invoiceNo,$type,$suppierId)
{
	global $db;
	$sql_po = "select concat(substr(ID.intPOYear,3,4),'/',ID.intPONO) as PONo 
				from invoicedetails  ID
				where ID.strInvoiceNo='$invoiceNo' 
				and ID.strType='$type' 
				and ID.strSupplierId='$suppierId'";
	$result_po=$db->RunQuery($sql_po);
	$boolcheck = false;
	while($row=mysql_fetch_array($result_po))
	{
		if($boolcheck)
		{
			$strPONo = $strPONo.'\\'.$row["PONo"];
		}
		else
		{
			$strPONo = $row["PONo"];
		}
		$boolcheck = true;
	}
	return $strPONo;
}
?>