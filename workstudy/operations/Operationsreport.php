<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
$report_companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"content="text/html; charset=utf-8"/>
<title>Operations Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
/*<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->*/

</style>
</head>
<body>
<table width="750" border="0" align="center" cellpadding="0">
	  <tr>
			<td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
			<td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
	  <tr>
	  		<td width="24%"><img src="../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        	<td width="9%" class="normalfnt">&nbsp;</td>
			<td width="66%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;" >
			<?php 
			$SQL_alldetails="SELECT * FROM companies
								INNER JOIN useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
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
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>	</td>
	  </tr>
</table></td>
	 </tr>
</table></td>
	  </tr>
	  <tr>
		  <td colspan="7" class="normalfnt2bldBLACKmid">&nbsp;</td>
	  </tr>
	  <tr>
		 <td colspan="7" style="text-align:center">
<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
<thead style="height:25px">
	  <tr>
		  <td colspan="8" class="normalfnt2bldBLACKmid">Operations  Report</td>
      </tr>
      <tr>
	      <td class='normalfntBtab' align="center" style="width:15px;"><font style='font-size:9px;'><b>ID</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Operation  Code</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Component</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Operation</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Operation Mode</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Machine</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>SMV</b></font></td>
		  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Active</b></font></td>
	  </tr>
	  </thead>
		  <?php     
				$SQL="SELECT 
				ws_operations.intOpID,
				ws_operations.strOpCode,
				ws_operations.strOperation,
				ws_operations.intStatus,
				ws_operations.intMachineType,
				ws_operations.dblSMV,
				ws_machinetypes.strMachineName,
				components.strComponent
                   FROM ws_operations
                   INNER JOIN components  
				       ON ws_operations.intComponent= components.intComponentId
                   INNER JOIN ws_machinetypes ws_machinetypes 
				       ON ws_operations.intMachineTypeId = ws_machinetypes.intMachineTypeId
                   WHERE ws_operations.intStatus <>'10' ORDER BY ws_operations.intOpID ASC";				
		  $result=$db->RunQuery($SQL);   
	      $i=1;		
		  while($row = mysql_fetch_array($result))
			{		
				$OperationCode=$row["strOpCode"];
				$Component=$row["strComponent"];
				$Operation=$row["strOperation"];
				$Machine=$row["strMachineName"];
				$OperationMode=$row["intMachineTypeId"];
				$SMV=$row["dblSMV"];
				$intStatus=$row["intStatus"];						
				if($intStatus == 1)
				    {
					$intStatus='Yes';
					} 
					else 
					{
					$intStatus='No';
					}	
				
				if($OperationMode==1) 
					$OperationMode='Manual';
					else
					$OperationMode='Machine';
					
			  echo"<tr>";
			  echo"<td class='reportStylemachine'>$i</td>";
			  echo"<td class='normalfnt'>$OperationCode</td>";
			  echo"<td class='normalfnt'>$Component</td>";
			  echo"<td class='normalfnt'>$Operation</td>";
			  echo"<td class='normalfnt'>$OperationMode</td>";
			  echo"<td class='normalfnt'>$Machine</td>";
			  echo"<td class='normalfnt'>$SMV</td>";
			  echo"<td class='reportStylemachine'>$intStatus</td>"; 
			  echo"</tr>";	
			  $i++;	
		  } 
		   ?>						
   </table></td>
  </tr>
 </table>
</body>
</html>