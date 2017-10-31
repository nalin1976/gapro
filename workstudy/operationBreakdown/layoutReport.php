<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Layout Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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

</style>
</head>
<body>
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
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
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  


  <tr>
    <td colspan="5"  valign="top">
<table align="center" width="900" cellspacing="1" >
<tr><td valign="top">
<table width="100%">
<tr><td width="50%" align="left">Style No :</td><td><?php echo $_GET['styleId'] ?></td></tr>
<tr><td align="left">Description :</td><td><?php echo $_GET['styleId'] ?></td></tr>
</table>
</td></tr>
	<tr>
		<td width="428"><table width="100%" cellpadding="0"  cellspacing="1" class="layoutGrid">
          <tbody>
            <tr>
              <td valign="top">
<table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >			  <tr>
			  <th>M/C</th>
			  <th>Type</th>
			  <th>Req No's</th>
			  </tr>
			  </table>
			  </td>
            </tr>
          </tbody>
        </table></td>
		<td width="27"></td>
		<td width="427"><table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >
			  <tr>
			  <td width="20%">Date of issue</td>
			  <td>&nbsp;</td>
			  </tr>
			  <tr>
			  <td>SMV of GMT</td>
			  <td>&nbsp;</td>
			  </tr>
			  <tr>
			  <td>Line/Team</td>
			  <td>&nbsp;</td>
			  </tr>
			  <tr>
			  <td>Total Maning in line(with Ab%)</td>
			  <td><table>
			  <tr><td>
			  <table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >
			  <tr><td >M/O's</th><td >Help's</th><td >Total</th></tr>
			  <tr><td></td><td></td><td></td></tr>
			  </table></td>
			  </tr>
			  <tr><td>
			  <table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >
			  <tr><td colspan="3" >Final Press Folders</th></tr>
			  <tr><td></td><td></td><td></td></tr>
			  </table>
			  </tr>
			  </table></td>
			  </tr>
			  </table>
			  </td>
            </tr>
          </tbody>
        </table></td>
	</tr>
<tr>
		<td width="428">&nbsp;</td>
		<td width="27"></td>
		<td width="427">
			  </td>
            </tr>
          </tbody>
        </table></td>
	</tr></table>
<?php
$styleNo = $_GET['styleId'];

$sqlCountQuery = "SELECT count(*) AS count
				  FROM `machinesoperatorsassignment`
				  WHERE `styleNo` = '$styleNo' AND `L_R`='left' ";
$recordCount 	= $db->RunQuery($sqlCountQuery);
$reCount 		= mysql_fetch_array($recordCount);
$resCount 		= $reCount['count'];
		 		
   $sqlQuery = "SELECT
			MP.id AS id,
			MP.styleNo AS styleNo,
			MP.L_R as L_R,
			MP.operationId AS operationId,
			MP.location AS location,
			MP.machine AS intMachineTypeId,
			MP.smv AS smv,
			MP.r AS r,
			MP.tgt AS tgt,
			MP.mr AS mr,
			MP.eff AS eff,
			MP.totTarget AS totTarget,
			MP.nos AS nos,
			MP.lineNo AS lineNo,
			OP.strOperation AS strOperation, 
			ws_machinetypes.strMachineName 
			FROM
			ws_machinesoperatorsassignment AS MP
			INNER JOIN ws_operations AS OP ON MP.operationId = OP.intOpID 
			Inner Join ws_machinetypes ON MP.machine = ws_machinetypes.intMachineTypeId 
			WHERE MP.styleNo = '$styleNo'
			ORDER BY MP.id DESC";
				
$recordSet = $db->RunQuery($sqlQuery); 
?>
<br />

<table align="center" width="900" cellspacing="1">
	<tr>
	
<td width="420">
			<table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >
<?php
$tmpID = 0; 	
$recordSet = $db->RunQuery($sqlQuery); 
while( $record = mysql_fetch_array($recordSet)){   
if($record['id']%2==0){ 

if($tmpID!=$record['id']){?>
	<thead>
		<tr>     
			<td class='bcgl1txt1NB'>Eff</td>
			<td class='bcgl1txt1NB'>EPF No</td>
			<td class='bcgl1txt1NB' align="right"><?php echo $record['id']; ?></td>
			<td class='bcgl1txt1NB'><?php echo $record['strMachineName']; ?></td>
			<td class='bcgl1txt1NB'>SMV</td>
			<td class='bcgl1txt1NB'>Tgt%</td>
			<td class='bcgl1txt1NB'>Bal%</td>
		</tr>
	</thead>
<?php
}

$tmpID=$record['id'];
?>	
<tbody>
<tr>
<td></td>
<td colspan="3"><?php echo $record['strOperation']; ?></td>
<td><?php echo $record['smv']; ?></td>
<td><?php echo $record['tgt']; ?></td>
<td></td>
</tr>						
 <?php $lineNumber++; if($lineNumber%3 ==0){ ?>
</tbody>		 
<?php }  } }?>
</table>
</td>
		
<td></td>
<?php
$styleNo = $_GET['styleId'];

$sqlCountQuery1 = "	SELECT count(*) AS count
					 FROM `ws_machinesoperatorsassignment`
					 WHERE `styleNo` = '$styleNo' AND `L_R`='right' ";
$recordCount1 	= $db->RunQuery($sqlCountQuery1);
$reCount1 		= mysql_fetch_array($recordCount1);
$resCount1		= $reCount1['count'];		
 $sqlQuery1 		= "SELECT
					MP.id AS id,
					MP.styleNo AS styleNo,
					MP.L_R as L_R,
					MP.operationId AS operationId,
					MP.location AS location,
					MP.machine AS intMachineTypeId,
					MP.smv AS smv,
					MP.r AS r,
					MP.tgt AS tgt,
					MP.mr AS mr,
					MP.eff AS eff,
					MP.totTarget AS totTarget,
					MP.nos AS nos,
					MP.lineNo AS lineNo,
					OP.strOperation AS strOperation
					FROM
					ws_machinesoperatorsassignment AS MP
					INNER JOIN ws_operations AS OP ON MP.operationId = OP.intOpID
					WHERE MP.styleNo = '$styleNo' AND MP.L_R ='right'
					ORDER BY MP.location ASC";
				
$recordSet1 	= $db->RunQuery($sqlQuery1); 
?>
<td width="420">
			<table width='100%' border='1' align='center' CELLPADDING='3' CELLSPACING='1'  RULES='COLS,ROWS' FRAME='BOX' >
<?php
$tmpID = 0; 	
$recordSet = $db->RunQuery($sqlQuery); 
while( $record = mysql_fetch_array($recordSet)){   
if($record['id']%2!=0){ 

if($tmpID!=$record['id']){?>
	<thead>
		<tr>     
			<td class='bcgl1txt1NB'>Eff</td>
			<td class='bcgl1txt1NB'>EPF No</td>
			<td class='bcgl1txt1NB' align="right"><?php echo $record['id']; ?></td>
			<td class='bcgl1txt1NB'><?php echo $record['strMachineName']; ?></td>
			<td class='bcgl1txt1NB'>SMV</td>
			<td class='bcgl1txt1NB'>Tgt%</td>
			<td class='bcgl1txt1NB'>Bal%</td>
		</tr>
	</thead>
<?php

}

$tmpID=$record['id'];
?>	
<tbody>
<?php  ?>
<tr>
<td></td>
<td colspan="3"><?php echo $record['strOperation']; ?></td>
<td><?php echo $record['smv']; ?></td>
<td><?php echo $record['tgt']; ?></td>
<td></td>
</tr>						
 <?php $lineNumber++; if($lineNumber%3 ==0){ ?>
</tbody>		 
<?php }  } }?>
</table>
					
		</td>
	</tr>
</table>



<br />
<br />
<table align="center" width="900" cellspacing="1">
	<tr>
		<td class="normalfntC">Prepaired By,</td>
		<td class="normalfntC">Approved By,</td>
		<td></td>
		<td class="normalfntC">Checked By,</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>    
	<tr>
		<td style="text-align:center;">___________________</td>
		<td style="text-align:center;">___________________</td>
		<td style="text-align:center;">___________________</td>
		<td style="text-align:center;">___________________</td>
		<td style="text-align:center;">___________________</td>
	</tr>  
	<tr>
		<td class="normalfntCB">I.E. Officer</td>
		<td class="normalfntCB">I.E. Executive</td>
		<td class="normalfntCB">A.P.M.</td>
		<td class="normalfntCB">P.M.</td>
		<td class="normalfntCB">F.M.</td>
	</tr>
</table>

  </tr>
  </table>
</body>
</html>
