<?php
 session_start();
$backwardseperator 	= "../";
include('../Connector.php');
$report_companyId=$_SESSION['UserID'];
$docNo = $_GET['req'];
$days=$_GET['days'];

$tbl="";
	($status==1)?$tbl="stocktransactions_temp":$tbl="stocktransactions";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Common Stock Non-Moving Items Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>
<script src="itemDispos.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->
table
{
	border-spacing:0px;

	
}
</style>
</head>
<body>
<table width="800" border="0" align="center" >
  <tr>
    <td>
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
      <tr>
        <td width="24%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="9%" class="normalfnt">&nbsp;</td>
        <td width="66%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;"  ><?php
		$SQL_alldetails="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
		


$result_alldetails = $db->RunQuery($SQL_alldetails);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo=$row["intGrnNo"];
		$intGRNYear=$row["intGRNYear"];
		$intGRNYearnew= substr($intGRNYear, -2);
		$strInvoiceNo=$row["strInvoiceNo"];
		$strSupAdviceNo=$row["strSupAdviceNo"];
		$dtmAdviceDate=$row["dtmAdviceDate"];
		$dtmAdviceDateNew= substr($dtmAdviceDate,-19,10);
		$dtmAdviceDateNewDate= substr($dtmAdviceDateNew,-2);
		$dtmAdviceDateNewYear=substr($dtmAdviceDateNew,-10,4);
		$dtmAdviceDateNewmonth1=substr($dtmAdviceDateNew,-5);
		$dtmAdviceDateNewMonth=substr($dtmAdviceDateNewmonth1,-5,2);
		$strBatchNO=$row["strBatchNO"];
		$dtmConfirmedDate=$row["dtmConfirmedDate"];
		$dtmConfirmedDateNew= substr($dtmConfirmedDate,-19,10);
		$dtmConfirmedDateNewDate= substr($dtmConfirmedDateNew,-2);
		$dtmConfirmedDateNewYear=substr($dtmConfirmedDateNew,-10,4);
		$dtmConfirmedDateNewmonth1=substr($dtmConfirmedDateNew,-5);
		$dtmConfirmedDateNewMonth=substr($dtmConfirmedDateNewmonth1,-5,2);
		$strName=$row["strName"];
		$comAddress1=$row["strAddress1"];
		$comAddress2=$row["strAddress2"];
		$comStreet=$row["strStreet"];
		$comCity=$row["strCity"];
		$comCountry=$row["strCountry"];
		$comZipCode=$row["strZipCode"];
		$strPhone=$row["strPhone"];
		$comEMail=$row["strEMail"];
		$comFax=$row["strFax"];
		$comWeb=$row["strWeb"];
		$strTitle=$row["strTitle"];
		$strAddress1=$row["strAddress1"];
		$strAddress2=$row["strAddress2"];
		$strStreet=$row["strStreet"];
		$strCity=$row["strCity"];
		$strCountry=$row["strCountry"];
		$ConfirmedPerson=$row["ConfirmedPerson"];
		$ShippingMode=$row["ShippingMode"];
		$ShippingTerm=$row["ShippingTerm"];
		$PmntMode=$row["PmntMode"];
		$PmntTerm=$row["PmntTerm"];
		$dtmDeliveryDate=$row["dtmDeliveryDate"];
		$dtmDeliveryDateNew= substr($dtmDeliveryDate,-19,10);
		$dtmDeliveryDateNewDate= substr($dtmDeliveryDateNew,-2);
		$dtmDeliveryDateNewYear=substr($dtmDeliveryDateNew,-10,4);
		$dtmDeliveryDateNewmonth1=substr($dtmDeliveryDateNew,-5);
		$dtmDeliveryDateNewmonth=substr($dtmDeliveryDateNewmonth1,-5,2);
		$intPONo=$row["intPONo"];
		$intYear=$row["intYear"];
		$intYearnew= substr($intYear,-2);
		$strPINO=$row["strPINO"];
		$preparedperson=$row["preparedperson"];
		$grnStatus = $row["grnStatus"];
		$dtmRecievedDate = $row["dtmRecievedDate"];
		$merchandiser=$row["merchandiser"];
		}
		?>
<?php echo $strName; ?>
<p class="normalfnt">
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  </td>
      </tr>
    </table>
<table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="100%" height="38" class="head2BLCK" >Common Stock Non-Moving Items</td>
        <!--<td width="18%" class="head2BLCK">&nbsp;</td>-->
      </tr>
    </table>
<br />
<table width="1000" border="1" align='center' CELLPADDING=1 CELLSPACING=1 rules="rows" >
      <tr>
		      <td width="3%"  class="" align="center"></td>
              <td width="10%" class="normalfnth2B" align="center"> No</td>
			  <td width="18%" class="normalfnth2B" align="center">Item Description </td>
              <td width="12%" class="normalfnth2B" align="center">Main store</td>
              <td width="10%" class="normalfnth2B" align="center">Color</td>
			  <td width="10%" class="normalfnth2B" align="center">Size</td>
			  <td width="10%" class="normalfnth2B" align="center">Unit</td>
			  <td width="10%" class="normalfnth2B" align="center">Qty</td>
			  <td width="5%"  class="normalfnth2B" align="center">Days</td>
			  <td width="12%" class="normalfnth2B" align="center">Date</td>
             </tr>
      
     <?php $sql="
			select * from(SELECT
			DATEDIFF(now(),stocktransactions.dtmDate) AS NDays,
			concat(stocktransactions.intDocumentYear,'/',stocktransactions.intDocumentNo) as N,
			matitemlist.strItemDescription,
			mainstores.strName,
			stocktransactions.strColor,
			stocktransactions.strSize,
			stocktransactions.strUnit,
			stocktransactions.dblQty,
			stocktransactions.dtmDate
			FROM
			stocktransactions
			Inner Join matitemlist ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
			Inner Join mainstores ON mainstores.strMainID = stocktransactions.strMainStoresID
			WHERE
			stocktransactions.strType =  'LeftOver' ) as tbl";
			if($days!=""){
				$sql.=" where tbl.NDays >= '$days'";
			}
			//echo $sql;
			$res=$db->RunQuery($sql);
			while(@$row=mysql_fetch_array($res)){
			?>
      		<tr>
		      <td width="3%" height="" bgcolor="" class=""> </td>
              <td width="10%" height="" bgcolor="" class="normalfnt"> <?php echo $row['N'];?></td>
			  <td width="18%" bgcolor="" class="normalfnt"><?php echo $row['strItemDescription'];?> </td>
              <td width="12%" bgcolor="" class="normalfnt"><?php echo $row['strName'];?></td>
              <td width="10%" bgcolor="" class="normalfnt"><?php echo $row['strColor'];?></td>
			  <td width="10%" bgcolor="" class="normalfnt"><?php echo $row['strSize'];?></td>
			  <td width="10%" bgcolor="" class="normalfntCenterTABNoBorder"><?php echo $row['strUnit'];?></td>
			  <td width="10%" bgcolor="" class="normalfntRite"><?php echo  round($row['dblQty'],4);?></td>
			  <td width="5%"  bgcolor="" class="normalfntRite"><?php echo $row['NDays'];?></td>
			  <td width="12%" bgcolor="" class="normalfntCenterTABNoBorder"> <?php echo substr($row['dtmDate'],0,10);?> </td>
			  
             </tr>
			 <?php }?>
	  
</table>

</td>
</tr>
</table>

</body>
</html>
