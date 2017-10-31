<?php
include "../Connector.php";
$RequestType = $_GET["RequestType"];
$status = '13,14';

if($RequestType=="ChangeOrder")
{
	$sourceStyleId 		= $_GET["sourceStyleId"];
	$changeToStyleName 	= $_GET["changeToStyleName"];
	$preOrderNo 		= $_GET["styleName"];
	$changeToStyleNo	= $_GET["changeToStyleNo"];
	$colorCode			= $_GET["colorCode"];
	$buyerPoNo			= $_GET["buyerPoNo"];
	$manufacFactory 	= $_GET["manufacFactory"];
	//echo $changeToStyleNo.' '.$colorCode;
	
	//return;	
	$sql_check="select strOrderNo from orders where strOrderNo='$changeToStyleName' and intStyleId <>'$sourceStyleId'";	
	$result_check=$db->RunQuery($sql_check);	
	$count=mysql_num_rows($result_check);
	
	if($count<=0){
		$sql="update orders set strOrderNo='$changeToStyleName',strStyle='$changeToStyleNo', strOrderColorCode='$colorCode',
		strBuyerOrderNo='$buyerPoNo', intManufactureCompanyID='$manufacFactory' where intStyleId='$sourceStyleId'";
		
		
		$result=$db->RunQuery($sql);
		
		include "../EmailSender.php";
		$eml =  new EmailSender();
		$today = date("F j, Y, g:i a");      
		$userName     = getUserName();
		$styleName = GetStyle($sourceStyleId);		
		
		/*$body 		= "Style Name    : $styleName <br>
					   Order No      : $preOrderNo has Change to : $changeToStyleName ";	*/	
		$body = " <table width='600' border='0' cellspacing='0' cellpadding='0>
  <tr>
    <td width='20%' align='left'><b>Style Name :</b></td>
    <td width='80%'  align='left'><b>$styleName</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Order No :</b></td>
    <td><b>$preOrderNo &nbsp;&nbsp;  has Change to &nbsp; $changeToStyleName </b></td>
  </tr>
</table>";			   
		
		$fieldName = 'intChangeOrderNo';
		$sender = '';
		$reciever = '';
		
		$subject = "Change Order No";				
		$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
		
		//save changed order details in orderNolog table
		insertOrderNoLogDetails($sourceStyleId,$preOrderNo,$changeToStyleName,$colorCode);
		echo "Style updated.";
	}
	else{
		echo "Sorry!\nOrder No : '$changeToStyleName' already exist.\nPlease try with a different name.";
	}	
}
else if($RequestType=="GetOrderNo")
{
	
	$styleNo	= $_GET["styleNo"];
	$sql="select distinct intStyleId,strOrderNo from orders where intStatus not in ($status)";
	if($styleNo!="")
		$sql .="and strStyle='$styleNo'";
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	echo $A;
}
else if($RequestType=="GetScNo")
{
	
	$styleNo	= $_GET["styleNo"];
	$sql="select O.intStyleId,S.intSRNO from orders O inner join specification S on S.intStyleId=O.intStyleId where intStatus not in ($status) ";
	
	if($styleNo!="")
		$sql .="and O.strStyle='$styleNo' ";
	
	$sql .="order By S.intSRNO desc";
	
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	echo $A;
}
else if($RequestType=="ReLoadStyleNo")
{
		
	$sql="select distinct strStyle from orders where intStatus not in ($status) order By strStyle";
	
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
	}
	echo $A;
}
else if($RequestType=="ReLoadOrderNo")
{

	$sql="select intStyleId,strOrderNo from orders where intStatus not in ($status) order By strOrderNo";
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	echo $A;
}
else if($RequestType=="ReLoadScNo")
{
	$sql="select O.intStyleId,S.intSRNO from orders O inner join specification S on S.intStyleId=O.intStyleId where intStatus not in ($status) order By S.intSRNO desc ";
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	echo $A;
}

function getUserName()
{
	global $db;
	$userID = $_SESSION["UserID"];
	
	$sql = "select Name from useraccounts where intUserID='$userID'"; 
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  $Uname = $row["Name"];
	  
	  return $Uname;
}

function GetStyle($styleId)
{
	global $db;
	$sql="select strStyle from orders where intStyleId='$styleId'";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleName = $row["strStyle"];		
	}
	return $styleName;	
}

function insertOrderNoLogDetails($sourceStyleId,$preOrderNo,$changeToStyleName,$colorCode)
{
	global $db;
	$userID = $_SESSION["UserID"];
	$orderStatus = getOrderStatus($sourceStyleId);
	
	$SQL = " insert into ordernolog 
			(intStyleId, 
			oldOrderNo, 
			newOrderNo, 
			intUserID, 
			dtmDate, 
			intStatus,
			strOrderColorCode
			)
			values
			('$sourceStyleId', 
			'$preOrderNo', 
			'$changeToStyleName', 
			'$userID', 
			NOW(), 
			'$orderStatus',
			'$colorCode'			
			)	";
			
	$result=$db->RunQuery($SQL);		
			
}

function getOrderStatus($styleID)
{
	global $db;
	$sql="select intStatus from orders where intStyleId='$styleID'";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleName = $row["intStatus"];		
	}
	return $styleName;
}
?>