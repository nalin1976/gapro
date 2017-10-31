<?php
//--------------------------------------------------------------
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 	
$strButton		=	trim($_GET["q"],' ');
$strDescription	=	trim($_GET["strDescription"],' ');
$strRemarks		=	trim($_GET["strRemarks"],' ');
$intAdvanceStat = 	trim($_GET['intAdvanceStat'],' ');
$intStatus		= 	trim($_GET['intStatus'],' ');
//New & Save------------------------------------------------------------
if($strButton=="Save")
{


$SQL_Check="SELECT strDescription FROM popaymentterms WHERE strDescription='$strDescription'";
$result_check = $db->RunQuery($SQL_Check);	


if(mysql_num_rows($result_check)){
$SQL_Update ="UPDATE popaymentterms SET	strDescription='$strDescription',strRemarks = '$strRemarks',intAdvance='$intAdvanceStat',intStatus='$intStatus' WHERE strDescription='$strDescription';";
$db->ExecuteQuery($SQL_Update);
echo "Updated successfully.";			
}
else{
$SQL = "INSERT INTO popaymentterms (strDescription, strRemarks,intStatus,intAdvance)	VALUES ('$strDescription','$strRemarks','$intStatus','$intAdvanceStat')";
//echo $SQL ;
$db->ExecuteQuery($SQL);
echo "Saved successfully.";
}

} 

//Delete--------------------------------------------------------------------------------------

if($strButton=="Delete" & $strCurrency != null)
{	

echo $SQL="update currencytypes set intStatus=10  where strCurrency='".$strCurrency."';";
$db->ExecuteQuery($SQL);

echo "Deleted successfully.";
}

if($strButton=="clearReq")
{
	$sql="SELECT currencytypes.strCurrency,currencytypes.intCurID,currencytypes.dblRate FROM currencytypes WHERE (((currencytypes.intStatus)<>10)) order by strCurrency asc;;";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
		{
		echo "<option value='".$row['intCurID']."'>".$row['strCurrency']."</option>";
		}
}

if($strButton=="reload")
{
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
	$str="select strPayTermId,strDescription,ifnull(strRemarks,'1') as strRemarks,intAdvance,intStatus from popaymentterms order by strDescription ASC  -- where intStatus=1";
	
	$XMLString= "<Data>";
	$XMLString .= "<payterm>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<PayTermId><![CDATA[" . $row["strPayTermId"]  . "]]></PayTermId>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<Advance><![CDATA[" . $row["intAdvance"]  . "]]></Advance>\n";
		$XMLString .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		
		
		
	}
	$XMLString .= "</payterm>";
	$XMLString .= "</Data>";
	echo $XMLString;
	

}

if($strButton=="delete")
{
$paytrmid=$_GET["paytrmid"];
	$str ="delete from popaymentterms	where strPayTermId = '$paytrmid' ;";
	$result = $db->RunQuery2($str);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}	
	 echo "Deleted successfully.";
}
?>