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
<title>Factor Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<table width="750" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" >
      <tr>
        <td width="24%"><img src="../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="9%" class="normalfnt">&nbsp;</td>
        <td width="66%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;"  >
		<?php
		$SQL_alldetails="SELECT * FROM 
						companies
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
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  </td>
      </tr>
    </table>
				
				</td>
              </tr>
          </table></td>
		 </tr>
    </table></td>
  </tr>
  <tr>
  <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" style="text-align:center">
<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
<thead style="height:25px">
  <tr>
      <td colspan="5" class="normalfnt2bldBLACKmid">Factor Report</td>
      </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>ID</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Machine Name</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Stitch Type</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Seam Type</b></font></td>
      <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Factor</b></font></td>
	  </tr>
	  </thead>
	  <?php        
			$SQL="SELECT ws_machinetypes.strMachineName, ws_stitchtype.strStitchType, ws_seamtype.strName, ws_machinefactors.dblFactor FROM ws_machinefactors
			INNER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId =  ws_machinefactors.intMachineTypeId
			INNER JOIN ws_stitchtype ON ws_stitchtype.intID = ws_machinefactors.intStitchTypeId
			INNER JOIN ws_seamtype ON ws_seamtype.intId = ws_machinefactors.intStitchTypeId
			WHERE
				ws_machinetypes.intStatus = 1
				ORDER BY
				ws_machinetypes.strMachineName ASC";			
        $result=$db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
	{		
		$strMachineName	=	$row["strMachineName"];
		$strStitchType	=	$row["strStitchType"];
		$strName		=	$row["strName"];
		$dblFactor		=	$row["dblFactor"];
	
	  echo "<tr>";
	  echo"<td class='reportStylemachine' style=''>$i</td>";
	  echo"<td class='normalfnt'>$strMachineName</td>";
	  echo"<td class='normalfnt'>$strStitchType</td>";
	  echo"<td class='normalfnt'>$strName</td>";
	  echo"<td class='normalfnt' style='text-align:right'>$dblFactor</td>"; 
	  echo"</tr>";	
      $i++;	
  } 
   ?>						
   </table></td>
  </tr>
 </table>
</body>
</html>