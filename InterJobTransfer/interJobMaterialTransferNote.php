<?php 
session_start();

include "../Connector.php";
	$backwardseperator 	= "../";			
				$intJobNo		= $_GET["InterJobNo"];
				$intJobYear	= $_GET["InterJobYear"];
				
	$SQL = "SELECT
				IT.intTransferId,
				IT.intTransferYear,
				IT.intStyleIdFrom,
				IT.intStyleIdTo,
				IT.intStatus,
				IT.strRemarks,
				IT.intUserId,
				IT.dtmTransferDate,
				IT.intApprovedBy,
				IT.dtmApprovedDate,
				IT.intAuthorisedby,
				IT.dtmAuthorisedDate,
				IT.intConfirmedBy,
				IT.dtmConfirmedDate,
				IT.intCancelledBy,
				IT.dtmCancelledDate,
				IT.intFactoryCode,
				IT.intMainStoreID,
				CO.strName,
				CO.strAddress1,
				CO.strAddress2,
				CO.strStreet,
				CO.strCity,
				CO.strZipCode,
				CO.strPhone,
				CO.strEMail,
				CO.strFax,
				CO.strWeb,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intUserId ) as UserId,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intApprovedBy ) as ApprovedBy,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intAuthorisedby ) as Authorisedby,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intConfirmedBy ) as ConfirmedBy,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intCancelledBy) as CancelledBy
				FROM
				itemtransfer AS IT
				Inner Join companies AS CO ON CO.intCompanyID = IT.intFactoryCode
				WHERE
				IT.intTransferId =  '$intJobNo' AND
				IT.intTransferYear =  '$intJobYear'";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{  
					$report_companyId = $row["intFactoryCode"];
					
					$styleFrom		= $row["intStyleIdFrom"];
					$styleTo		= $row["intStyleIdTo"];
					$Status			= $row["intStatus"];
					
					$UserId			= $row["UserId"];
					$TransferDate	= $row["dtmTransferDate"];
					
					$ApprovedBy		= $row["ApprovedBy"];
					$ApprovedDate	= $row["dtmApprovedDate"];
					
					$Authorisedby	= $row["Authorisedby"];
					$AuthorisedDate	= $row["dtmAuthorisedDate"];
									
					$ConfirmedBy	= $row["ConfirmedBy"];
					$ConfirmedDate	= $row["dtmConfirmedDate"];

					$CancelledBy	= $row["CancelledBy"];
					$CancelledDate	= $row["dtmCancelledDate"];
					
					$mainStoresId 	= $row["intMainStoreID"];
					
				}
				?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inter Job Transfer :: Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

</script>
</head>


<body>

<table width="1100" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              
              <tr>
                <td width="100%" colspan="4"><?php include "../reportHeader.php";?></td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="head2BLCK">INTER-JOB MATERIAL TRANSFER NOTE </p>
      <p align="center" class="headRed"><?PHP		
			if($Status==10)
				echo "THIS IS NOT A VALID REPORT";			
	?>
	  </p>
      <table width="100%" border="0" cellpadding="0">
        
        <tr>
          <td width="50%" height="53"><table width="100%" border="0">
            <tr>
              <td width="11%" class="normalfnBLD1">Serial No</td>
			  <td width="3%"><span class="normalfnBLD1">:</span></td>
              <td width="10%"><span class="normalfnBLD1"><?php echo $intJobYear."/".$intJobNo; ?></span></td>
              <td width="8%">&nbsp;</td>
			   <td width="27%">&nbsp;</td>
              <td width="12%"><span class="normalfnBLD1"> Date &amp; Time </span></td>
			  
              <td width="2%"><span class="normalfnBLD1">:</span></td>		  
              <td width="16%" class="normalfnBLD1"><?php echo $TransferDate ;?></td>
              <td width="2%" class="normalfnBLD1">&nbsp;</td>
              <td width="2%" class="normalfnBLD1">&nbsp;</td>
              <td width="7%" class="normalfnBLD1">&nbsp;</td>
            </tr>
			
			<tr>
              <td width="11%" class="normalfnBLD1">From Style</td>
			  <td width="3%"><span class="normalfnBLD1">:</span></td>
              <td width="10%"><span class="normalfnBLD1"><?php echo Style($styleFrom) ?></span></td>
              <td width="8%">&nbsp;</td>
			   <td width="27%">&nbsp;</td>
              <td width="12%"><span class="normalfnBLD1"> To Style</span></td>
			  
              <td width="2%"><span class="normalfnBLD1">:</span></td>		  
              <td width="16%" class="normalfnBLD1"><?php echo Style($styleTo) ;?></td>
              <td width="2%" class="normalfnBLD1">&nbsp;</td>
              <td width="2%" class="normalfnBLD1">&nbsp;</td>
              <td width="7%" class="normalfnBLD1">&nbsp;</td>
            </tr>
          </table>
            <table width="100%" border="0">
<?php
$sqlfrom="SELECT
		B.strName AS fromBuyerName,
		specification.intSRNO AS fromSRNO
		FROM
		orders AS O
		Inner Join buyers AS B ON O.intBuyerID = B.intBuyerID
		Inner Join specification ON O.intStyleId = specification.intStyleId
		WHERE
		O.intStyleId =  '$styleFrom'";

$resultfrom = $db->RunQuery($sqlfrom);
while($rowfrom = mysql_fetch_array($resultfrom )){
	$fromBuyerName		=$rowfrom["fromBuyerName"];
	$fromSRNO		=$rowfrom["fromSRNO"];
}
?>

<?PHP
$sqlto="SELECT
		B.strName AS toBuyerName,
		specification.intSRNO AS toSRNO
		FROM
		orders AS O
		Inner Join buyers AS B ON O.intBuyerID = B.intBuyerID
		Inner Join specification ON O.intStyleId = specification.intStyleId
		WHERE
		O.intStyleId =  '$styleTo'";

$resultto = $db->RunQuery($sqlto);
while($rowto = mysql_fetch_array($resultto )){
	$toBuyerName		=$rowto["toBuyerName"];
	$toSRNO		=$rowto["toSRNO"];
}
?>
              <tr>
                <td width="11%" class="normalfnBLD1">From Order No </td>
                <td width="3%"><span class="normalfnBLD1">:</span></td>
                <td width="12%"><span class="normalfnt"><?php echo StyleName($styleFrom);?></span></td>
                <td width="2%"></td>
                <td width="31%"></td>
               
                <td width="12%" class="normalfnBLD1">To Order No </td>
                <td width="2%"><span class="normalfnBLD1">:</span></td>
                <td width="13%"><span class="normalfnt"><?php echo StyleName($styleTo);?></span></td>
                <td width="3%"><span class="normalfnBLD1"> </span></td>
				<td width="3%">&nbsp;</td>
                <td width="8%"><span class="normalfnt"></span></td>
              </tr>
			  
			   <tr>

                <td width="11%"><span class="normalfnBLD1">From SC :</span></td>
				<td width="3%"><span class="normalfnBLD1">:</span></td>
                <td width="12%"><span class="normalfnt"><?php echo $fromSRNO ;?></span></td>
				<td width="2%" class="normalfnBLD1"> </td>              
                <td width="31%"><span class="normalfnt"></span></td>
               
                <td width="12%"><span class="normalfnBLD1">To SC </span></td>
				<td width="2%"><span class="normalfnBLD1">:</span></td>
                <td width="13%"><span class="normalfnt"><?php echo $toSRNO;?></span></td>
				<td width="3%" class="normalfnBLD1"> </td>
                <td width="3%">&nbsp;</td>
                <td width="8%"><span class="normalfnt"></span></td>
              </tr>
			  
			   <tr>
                <td width="11%" class="normalfnBLD1">Buyer</td>
                <td width="3%"><span class="normalfnBLD1">:</span></td>
                <td colspan="3"><span class="normalfnt"><?php echo $fromBuyerName ;?></span></td>
                <td width="12%" class="normalfnBLD1">Buyer</td>
                <td width="2%"><span class="normalfnBLD1">:</span></td>
                <td colspan="4"><span class="normalfnt"><?php echo $toBuyerName;?></span></td>
              </tr>
            </table></td>
        </tr>
    </table>      
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td width="11%" class="normalfnBLD1">&nbsp;Report Status</td>		  
          <td width="3%" class="normalfnBLD1">:</td>
          <td width="8%" bgcolor="#CCCCCC" class="normalfnBLD1TAB">
		    <div align="center">
		      <?PHP
		  if($Status==0)echo "SAVED";
		  elseif($Status==1)echo "APPROVED";
		  elseif($Status==2)echo "AUTHORISED";
		  elseif($Status==3)echo "CONFIRMED";
		  elseif($Status==10)echo "CANCELED";
		  ?>
          </div></td>
          <td width="78%" class="normalfnBLD1" >&nbsp;</td>
        </tr>
        <tr>
          <td width="11%" class="normalfnBLD1">&nbsp;Stores Location</td>		  
          <td width="3%" class="normalfnBLD1">:</td>
          <td width="8%" class="normalfnBLD1TAB"><?php echo  getMainStoresLocation($mainStoresId); ?></td>
          <td width="78%" class="normalfnBLD1" >&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

            <tr>
              <td width="8%" height="31"  bgcolor="#CCCCCC" class="bcgl1txt1B">Item Code </td>
              <td width="35%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Description </td>
              <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Buyer Po No</td>
              <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Color</td>
              <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Size</td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Transfer Qty </td>
              <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B" >UOM</td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price </td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Value</td>
              </tr>
<?php 
	$sql_details="SELECT IT.intStyleIdFrom,
		ITD.strBuyerPoNo,
		ITD.strColor,
		ITD.strSize,
		ITD.strUnit,
		ITD.dblQty,
		ITD.dblUnitPrice,
		MIL.strItemDescription,
		MR.materialRatioID
		FROM
		itemtransferdetails AS ITD
		Inner Join matitemlist AS MIL ON ITD.intMatDetailId = MIL.intItemSerial
		Inner Join itemtransfer IT ON IT.intTransferId=ITD.intTransferId and IT.intTransferYear=ITD.intTransferYear
		LEFT Join materialratio MR ON MR.intStyleId=IT.intStyleIdFrom and MR.strBuyerPONO=ITD.strBuyerPoNo and 
		MR.strMatDetailID=ITD.intMatDetailId and MR.strColor=ITD.strColor and MR.strSize=ITD.strSize
		WHERE
		ITD.intTransferId =  '$intJobNo' AND
		ITD.intTransferYear =  '$intJobYear'";
		
	$result_details = $db->RunQuery($sql_details);
	while($row_details = mysql_fetch_array($result_details )){
?>           
            <tr>
              <td class="normalfntTAB"><?php echo $row_details["materialRatioID"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strItemDescription"]?></td>
              <td class="normalfntTAB"><?php echo getBuyerPOName($row_details["intStyleIdFrom"],$row_details["strBuyerPoNo"]);?></td>
              <td class="normalfntTAB"><?php echo $row_details["strColor"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strSize"]?></td>
              <td class="normalfntRiteTAB"><?php echo $row_details["dblQty"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strUnit"]?></td>
              <td class="normalfntRiteTAB"><?php echo number_format($row_details["dblUnitPrice"],4)?></td>
              <td class="normalfntRiteTAB"><?php echo number_format(($row_details["dblUnitPrice"]*$row_details["dblQty"]),2)?></td>
              </tr>
<?php
}
?>
          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="86%" class="bigfntnm1mid">&nbsp;</td>
        <td width="7%" class="bigfntnm1mid">&nbsp;</td>
        <td width="7%" class="bigfntnm1rite">&nbsp;</td>
      </tr>
      <tr>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1rite">&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="0">
        <tr>          
			<td width="20%" class="bcgl1txt1"><?php echo $UserId ;?></td>       
		 	<td width="20%" class="bcgl1txt1"><?php echo $ApprovedBy ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $Authorisedby ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $ConfirmedBy ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $CancelledBy ;?></td>    
        </tr>
        <tr>
          <td width="20%" class="normalfntMid"><?php echo $TransferDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $ApprovedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $AuthorisedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $ConfirmedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $CancelledDate ;?></td>
        </tr>
        <tr>
          <td width="20%" class="normalfntMid">Prepaired By/Date</td>
          <td width="20%" class="normalfntMid">Approved By/Date</td>
          <td width="20%" class="normalfntMid">Authorized By/Date</td>
          <td width="20%" class="normalfntMid">Confirmed By/Date</td>
          <td width="20%" class="normalfntMid">Cancelled By/Date</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 
function StyleName($styleID)
{
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];
}

function Style($styleID)
{
	global $db;
	$SQL = " SELECT strStyle FROM orders WHERE intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strStyle"];
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function getMainStoresLocation($prmStoresLocation){
	
	global $db;
	$SQL = " SELECT strName FROM mainstores WHERE strMainID = '$prmStoresLocation'";
	$res = $db->RunQuery($SQL);
	$rowStores = mysql_fetch_array($res);
	return $rowStores["strName"];
	
}

if($Status==10)
{
	echo " <style type=\"text/css\"> body {background-image: url(../images/not-valid.png);} </style>";
}
?>
</body>
</html>
