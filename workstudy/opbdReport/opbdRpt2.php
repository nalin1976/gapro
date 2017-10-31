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
<title>Operation Breakdown Report</title>
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
    <td colspan="5" style="text-align:center">


<table width="100%" border='0'>
<tr><td colspan="2">

	   <?php

 $opbdrpt_intStyleID = $_GET['opbdrpt_intStyleID']; 
 
$sql = "SELECT 
dblworkinghours,intOperators,strTeams from ws_operationbreakdownheader WHERE strStyleID = '".$opbdrpt_intStyleID."'";
$result = $db->RunQuery($sql);
$row = mysql_fetch_array($result);
$hoursPerDay=$row["dblworkinghours"];
$noOfOperators=$row["intOperators"];
$teams=$row["strTeams"];
				 
$smvRatio=1667;
 
 
 
 
  /*
 $sql  ="select operationbreakdownheader.dblTotalSMV,operationbreakdownheader.dblOutPutPerHr,operationbreakdownheader.dblMachSMV,
  	                operationbreakdownheader.dblHelpSMV,operationbreakdownheader.workinghours,
  	                operationbreakdownheader.dblMachineOutPutPerHr,operationbreakdownheader.strComments,
  	                operationbreakdowndetails.intPlaceId,operationbreakdowndetails.intPartID,tbloperationparts.strPartName,
  	                operationbreakdowndetails.strComponent,operationbreakdowndetails.strCompType,operationbreakdowndetails.orderby,
  	                operationbreakdowndetails.intOptId,operationbreakdowndetails.strTarget,operationbreakdowndetails.strLength,operationbreakdowndetails.stringmach,operationbreakdowndetails.totsmv,
  	                operationbreakdowndetails.stringsmv,tbloperationplaces.strComponent,operationheader.strOperationID,operationheader.strOperation, 
  	                pitchtime.intMO,pitchtime.intHelper,pitchtime.intTotWorkers,pitchtime.dblMSMV,pitchtime.dblHSMV,pitchtime.dblNonTotSMV,
  	                pitchtime.dblTotSMV,pitchtime.dblPT,pitchtime.dblMPT,pitchtime.intReqMO,pitchtime.intReqHelper from             
  	              
  	                (((((operationbreakdownheader left join operationbreakdowndetails on operationbreakdownheader.strStyleID=operationbreakdowndetails.strStyleID)
                                                   left join tbloperationplaces on operationbreakdowndetails.intPlaceId = tbloperationplaces.intPlaceId)  
                                                   left join operationheader on operationbreakdowndetails.intOptID = operationheader.strOperationID)
                                                   left join tbloperationparts on operationbreakdowndetails.intPartID = tbloperationparts.intPartID)	
                                                   left join pitchtime on operationbreakdownheader.strStyleID =  pitchtime.strStyleID)                      
  	                where operationbreakdownheader.strStyleID='$strStyleID' ORDER BY strComponent asc,orderby asc";  */
					
					
    $sql = "SELECT ws_operationbreakdowndetails.dblSMV,ws_operations.dblTMU,ws_operations.strOperation,ws_operationbreakdowndetails.intOperationID,ws_operationbreakdowndetails.intMachineTypeId,ws_machinetypes.strMachineName,
componentcategory.strCategory,components.strComponent,ws_operationbreakdowndetails.intMachineType,ws_operationbreakdownheader.dtmDate  
FROM ws_operationbreakdowndetails 
inner JOIN ws_operationbreakdownheader ON ws_operationbreakdowndetails.strStyleID = ws_operationbreakdownheader.strStyleID
LEFT JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
                               LEFT JOIN components ON ws_operations.intComponent = components.intComponentId
							   LEFT JOIN componentcategory ON intCategoryNo = components.intCategory 
							   LEFT JOIN ws_machinetypes ON ws_operationbreakdowndetails.intMachineTypeId = ws_machinetypes.intMachineTypeId 
WHERE ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' ORDER BY components.strComponent";					
  	     
  //echo"$sql<br>"; 
  $result = $db->RunQuery($sql);
  
  if(mysql_num_rows($result))
  {
   $flg_newpgyn  = ""; 
   $flg_firstyn  = "";
   $flg_newdocyn = "";
   $te_docmain   = ""; 
   
   $flg_newpgyn2  = ""; 
   $flg_firstyn2  = "";
   $flg_newconyn2 = "";
  	
   $te_totsubsmv = 0;
   $te_totsubsmvHelp = 0;
   $te_totsubtmvHelp = 0;
   $j = 0;

   while($fields = mysql_fetch_array($result, MYSQL_BOTH)) 
   { 
    $te_strComponent   = $fields['strComponent'];	
    $totsmv            = $fields['dblSMV'];
	$strOperation      = $fields['strOperation'];  
    $intOperationID    = $fields['intOperationID'];
    $intMachineTypeId        = $fields['intMachineTypeId']; 
	$machine        = $fields['strMachineName']; 
    $strCategory       = $fields['strCategory'];
	$intMachineType        = $fields['intMachineType']; 
	$date1        = $fields['dtmDate'];
	$date=substr($date1,0,4)."-".substr($date1,5,2)."-".substr($date1,8,2);
	$te_totsubsmv += $totsmv;
    $tottmu            = round($totsmv*$smvRatio);
    $tottgt            = round(60/$fields['dblSMV']);
	$te_totsubtmu += $tottmu; 
	  
    $te_totamtTMU   += $tottmu;
    $te_totamt   += $totsmv;
    
   if($j == 0 )
   {	    
    echo "<br><table width='100%' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td align='center' class='head2BLCK'>OPERATION BREAKDOWN SHEET</td>";
    echo "</tr>";
    echo "</table>";?>
	
	
	
	
	
	
	
	<br><table width='100%'  border='0' align='center'>
	<tr align='center' >
	<td width="45%">
	<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table1">
	<tr>
	<td class='bcgl1txt1NB'>Style No</td>
	<td class="normalfnt"><font  style='font-size: 12px;'><?php echo $opbdrpt_intStyleID ?></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Item</td>
	<td class="normalfnt"><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Team</td>
	<td class="normalfnt"><font  style='font-size: 12px;'><?php echo $teams ?></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Date</td>
	<td><font  style='font-size: 12px;'></font></td>
	</tr>
	</table>
	
	</td>
	<td class='bcgl1txt1NB' width="10%"></td>
	<td width="45%">
	<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table2">
	<tr>
	<td class='bcgl1txt1NB' colspan="2"># Operators</td>
	<td align="right"><font  style='font-size: 12px;'><?php echo $noOfOperators ?></font></td>
	<td  class='bcgl1txt1NB' rowspan="2">TARGET PER DAY</td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>S.M.V</td>
	<td align="right" class="normalfntRite"></td>
	<td align="right" bgcolor='#E2E2E2' ><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB' rowspan="2">Target</td>
	<td align="right" class="normalfntRite">100%</td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td align="right" class="normalfntRite">75%</td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	</tr>
	</table>
	</td></tr>
	
	<tr height="15"><td colspan="3"></td></tr>
	
	
	<?php
   
    echo "<br><table id='table3' width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center' bgcolor='#E2E2E2'>";
    echo "<td class='normalfntBtab' align='center' width='6%'>NO</td>";
    echo "<td class='normalfntBtab' align='center' width='40%'>OPERATION</td>";
	echo "<td class='normalfntBtab' align='center' width='15%'>M\C TYPE</td>";
    echo "<td class='normalfntBtab' align='center' width='9%'>T.M.U</td>";
    echo "<td class='normalfntBtab' align='center' width='9%'>S.M.V</td>";
    echo "<td class='normalfntBtab' align='center' width='10%'>TGt</td>";
    echo "<td class='normalfntBtab' align='center' width='11%'>No.M\C Req</td>";
    echo "</tr>";   
   }
           
   #---------------------------
    if($te_docmain != $te_strComponent)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $te_strComponent; 
        
    #---------------------------
    if( $te_docmain != $te_strComponent)
    {
     $flg_newconyn2 = "y";
    }
    else
    {
     $flg_newconyn2 = "n"; 
    }
         
    #---------------------------[ subtotal ]------------------------------
    if($flg_newdocyn== "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
  /*   echo "<tr>";
	  echo "<td align='right' colspan=3 ><font  style='font-size: 15px;'>SUB TOTAL :</font></td>";    
	  echo "<td align='right' ><font  style='font-size: 15px;'>".number_format($te_totsubsmv,2)."</font></td>";     
	  echo "<td align='right'><font  style='font-size: 15px;'>".number_format($te_totsubsmvHelp,2)."</font></td>";   
	  echo "<td align='right'width=''></td>"; 
      echo "</tr>";*/
	   $ArraySubtotTMU=$ArraySubtotTMU.$te_totsubtmvHelp.",";
	   $ArraySubtotSMV=$ArraySubtotSMV.$te_totsubsmvHelp.",";
      $te_totsubtmu = 0;
      $te_totsubsmv = 0;
	  $te_totsubsmvHelp = 0;
	  $te_totsubtmvHelp = 0;
     }	    
    }     
	
    if($intMachineType == "1"){ 
    $te_totsubsmv += $totsmv;
	}
	
	if($intMachineType == "0"){ 
    $te_totsubsmvHelp += $totsmv;
    $te_totsubtmvHelp += $tottmu;
	}

    if($flg_newdocyn== "y" || $flg_newpgyn == "y")
    {
     echo "<tr>";
   echo "<td  align='center' ></td>";
     echo "<td class='normalfnt' align='left'><b><font  style='font-size: 10px;'>$te_strComponent</font></b></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='center' ></td>";
     echo "</tr>"; 
	 
	  $ArrayCatogery=$ArrayCatogery.$te_strComponent.",";
    }  
     echo "<tr>";
     echo "<td align='center' class='normalfntMid'>".($j+1)."."."</td>";   
     echo "<td align='left' class='normalfnt'>$strOperation</td>";
     echo "<td align='center' class='normalfnt'>$machine</td>";
	 if($intMachineType == "1"){
	 echo "<td align='right'width='' class='normalfntRite'>$tottmu</td>"; 
     echo "<td align='right' width='' class='normalfntRite'>$totsmv</td>"; 
	 }
         
    if($intMachineType == "0"){
	 echo "<td align='right'width='' class='normalfntRite'>$tottmu</td>"; 
     echo "<td align='right' width='' class='normalfntRite'>$totsmv</td>"; 
	 }  
	 echo "<td align='right'width='' class='normalfntRite'>$tottgt</td>";  
	 echo "<td align='right'width='' class='normalfntRite'>0.00</td>";       
     echo "</tr>";  

     $flg_firstyn  = "n";
     $flg_firstyn2 = "n";          
     $j++;    
   }//end while 
	   $ArraySubtotTMU=$ArraySubtotTMU.$te_totsubtmvHelp.",";
	   $ArraySubtotSMV=$ArraySubtotSMV.$te_totsubsmvHelp.",";
  
   echo "<tr  bgcolor='#E2E2E2'>";

   echo "<td  align='center' ></td>";
   echo"<td align='center' ><font  style='font-size: 12px;'><b>  TOTAL SMV </b></font></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b>  ".number_format($te_totamtTMU,2)."</b></font></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b>  ".number_format($te_totamt,2)."</b></font></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b> </b></font></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b> </b></font></td>";
   echo"</tr>";

  }
  else
  {
   echo "<br><table width='100%' border='0'>";
   echo "<tr class='lbl'>";
   echo"<td align='center'><font  size='3'>No Records</font></td>";
   echo"</tr>";  
   echo "</table>";
  }
  /*
   echo "<br><table width='50%' border='0'>";
   echo "<tr class='lbl'>";
   echo"<td align='left' width='50%'> <font  size='3'><b>TOTAL S.M.V</font></td>";
   echo"<td align='left'> <font  size='3'><b>  ".number_format($te_totamt,2)."</b></font></td>";
   echo"</tr>";  
   echo "</table>";*/
   //	 $ArraySubtotSMV, $ArrayCatogery,$ArraySubtotTMU

?>
    </table>
	</td>
  </tr>
	<tr height="15"><td colspan="3"></td></tr>
  <tr>
  <td width="50%">
<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table4"> 
<tr>
<td colspan="2" width="55%" class='normalfntBtab' align='center'>Component</td>
<td width="9%" class='normalfntBtab' align='center' >TMU</td>
<td width="9%" class='normalfntBtab' align='center' >SMV</td>
</tr>


 <?php
//echo $ArraySubtotSMV;

 $explodeCategory = explode(',', $ArrayCatogery) ; 
 $explodeCatSMVTotal = explode(',', $ArraySubtotSMV) ; 
 $explodeCatTMUTotal = explode(',', $ArraySubtotTMU) ; 
 
 
 $catogeries = count($explodeCategory)-1;
		for ($i = 0;$i < $catogeries;$i++)
		{
     echo "<tr>";
     echo "<td class='normalfnt' align='left' colspan='2'><b><font  style='font-size: 10px;'>$explodeCategory[$i]</font></b></td>";
     echo "<td class='normalfntRite'  align='right' ><b><font  style='font-size: 10px;'>$explodeCatTMUTotal[$i]</font></b></td>";
     echo "<td class='normalfntRite' align='right'><b><font  style='font-size: 10px;'>$explodeCatSMVTotal[$i]</font></b></td>";
     echo "</tr>"; 
	 }
  ?>
  </table>
  </td>
  <td></td>
  </tr>
  
  </table>
  
  <script type="text/javascript">
	var tbl1 = document.getElementById("table1");	
		tbl1.rows[1].cells[1].childNodes[0].innerHTML='<?php echo $strCategory; ?>';
		tbl1.rows[3].cells[1].childNodes[0].innerHTML='<?php echo $date; ?>';
		
	var tbl2 = document.getElementById("table2");	
		tbl2.rows[1].cells[2].childNodes[0].innerHTML=<?php echo round($te_totamt,2); ?>;
		tbl2.rows[2].cells[2].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators/$te_totamt); ?>;
		tbl2.rows[3].cells[1].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*0.75/$te_totamt); ?>;
		tbl2.rows[2].cells[3].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*1*$hoursPerDay/$te_totamt); ?>;
		tbl2.rows[3].cells[2].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*0.75*$hoursPerDay/$te_totamt); ?>;
		
		
		
	
	var totNoMacReq=0;	
	var totSMV ='<?php echo $te_totamt; ?>';
	var operators ='<?php echo $noOfOperators; ?>';

	var tbl3 = document.getElementById("table3");	
	for ( var loop = 1 ;loop < tbl3.rows.length-1 ; loop ++ )
	{
	if(tbl3.rows[loop].cells[4].innerHTML!=''){
			var smv=parseFloat(tbl3.rows[loop].cells[4].innerHTML);
			//alert(tbl3.rows.length);
			//alert(tbl3.rows[8].cells[4].innerHTML);
			
			var noMacReq1=smv*operators/totSMV;
			noMacReq=Math.round(noMacReq1*100)/100;
			//alert(noMacReq);
		
			tbl3.rows[loop].cells[6].innerHTML=noMacReq;
			totNoMacReq=totNoMacReq+noMacReq;
			//alert(noMacReq);

			}
	}
tbl3.rows[tbl3.rows.length-1].cells[6].innerHTML=Math.round(totNoMacReq);
tbl3.rows[tbl3.rows.length-1].cells[6].childNodes[2].Font.Bold = True

		
</script>	

</body>
</html>
