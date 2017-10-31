<?php
	session_start();
	include("../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fabric Inspection Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>


<body>
<?php
					$strInvoiceNo 	= $_GET["strInvoiceNo"];
					$intSupplierId	= $_GET["intSupplierId"];
					$intItemSerial	= $_GET["intItemSerial"];
					$strColor		= $_GET["strColor"];					
					$strSql="
SELECT * FROM fabricinspection INNER JOIN suppliers ON (fabricinspection.intSupplierId = suppliers.strSupplierID) WHERE strInvoice='$strInvoiceNo' AND intSupplierId=$intSupplierId AND intItemSerial=$intItemSerial AND strColor='$strColor' ;";
					$result = $db->RunQuery($strSql);
					while ($row = mysql_fetch_array($result))						
					{						
				?>


<table width="1100" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="6%"><img src="../images/GaPro_logo.png" alt="" width="167" height="47" class="normalfnt" /></td>

              <td width="0%" class="normalfnt">&nbsp;</td>
				 <td width="82%" class="tophead"><p class="normalfnt"></p>     			</td>
                 <td width="12%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="head2BLCK">FABRIC INSPECTION  DETAIL REPORT </p>
      <table width="100%" border="0" cellpadding="0">
        
        <tr>
          <td width="50%" height="53"><table width="100%" border="0">
            <tr>
              <td width="6%" class="normalfnBLD1">INVOICE NO</td>
              <td width="0%" class="normalfnBLD1">:</td>
              <td width="34%" class="normalfnBLD1"><?php echo $strInvoiceNo; ?></td>
              <td width="60%">&nbsp;</td>
              </tr>
            <tr>
              <td><span class="normalfnBLD1">SUPPLIER</span></td>
              <td><span class="normalfnBLD1">:</span></td>
              <td class="normalfnBLD1"><?php echo $row["strTitle"]; ?></td>
              <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
    </table>      
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="110%" border="0" cellpadding="0" cellspacing="0" class="tablez">
		  <!--<tr>
              <td colspan="15" class="normalfntTAB">&nbsp;</td>
              <td colspan="4" bgcolor="#CCCCCC" class="bcgl1txt1B">FOR LECTRA MARKER MAKING</td>
              <td colspan="3" class="normalfntTAB">&nbsp;</td>
              </tr>-->

            <tr>
              <td width="4%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">RECEIVED DATE </td>
              <td width="5%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">INVOICE NO</td>
              <td width="7%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SUPPLIER</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >STYLE NO</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >PO & PI</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >BUYER</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >COLOUR</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >RCVD QTY [YDS]</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >APP.SWAT INFORMED DATE</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >APP.SWAT RECEIVED DATE</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SINK AGE LENGTH</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SINK AGE WIDTH</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >ORDER WIDTH</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >CUTTABLE WIDTH</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >LESS WIDTH SAMPLE SENT DATE</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GATE PASS NO</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >APPROVED BY</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >INSPEC.QTY[YDS]</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >INSP.%</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >DEFECT %</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >DEFECT SEND DATE</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GATE PASS NO</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >DEFECT APPROVAL</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >DEFECTIVE PANEL REPLACE</td>
              <td width="3%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">INROLL SHORTAGES</td>
              <td width="3%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >TTL. YDS WE NEED TO REPLACE</td>
              <td width="5%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">CLAIM REPORT UP-DATE</td>
              <td width="5%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">MAILED DATE</td>
              <td width="6%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SHADE BANDSEND DATE</td>
              <td width="5%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GATE PASS NO</td>
			  <td width="6%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">SHADE BAND APPROVAL</td>
              <td width="5%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >CLR. MATCHING LABDIP</td>
              <td width="5%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">SENT DATE</td>
              <td width="5%" height="31" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GATE PASS NO</td>
              <td width="5%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">COLOR APPROVAL</td>
              <td width="4%" height="31" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SKEWING BOWING%</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B">SENT DATE</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B">GATE PASS NO</td>
              <td width="4%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">BOWING/ SKEW APPROVAL</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >CLR.SHADING</td>
              <td width="4%" rowspan="2"  bgcolor="#CCCCCC" class="bcgl1txt1B">SEND DATE</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GATE PASS NO</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >SHADING APPROVAL</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >FABRIC WAY</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >GRADE</td>
              <td width="4%" rowspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B" >STATUS</td>
              <td colspan="7" bgcolor="#CCCCCC" class="bcgl1txt1B" >REPLACEMENT RECE / DETAILS </td>
              </tr>
            <tr>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >INVOICE NO</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >SUPPLIER</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >STYLE NO</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >PO & PI</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >BUYER</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >COLOUR</td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >RCVDQTY [YDS]</td>
            </tr>
			  
				
            <tr>
              <td class="normalfntTAB"><?php echo $row["receivedDate"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["strInvoice"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["intSupplierId"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["strStyle"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["Po_Pi2"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["Buyer2"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["strColor"]; ?></td>
              <td class="normalfntTAB"><?php echo $row["receivedQty"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["swatImformedDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["swatReceivedDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["srinkageLength"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["srinkageWidth"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["orderWidth"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["cuttableWidth"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["lessWidthSampleSendDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo1"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo1"]; ?></td>
              <td class="normalfntMidTAB"><?php echo  $row["inspectedQty"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["inspected"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["defected"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["defectSentDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["defectApproved"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["defectivePanelReplace"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["inrollShortage"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["totalYardsWeNeeded"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["claimReportUpDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["mailedDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadeBandSendDate"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo3"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadeBandApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["matchingLabdip"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["sendDate1"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo4"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["colorApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["skewingBowing"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["sendDate2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["gatepassNo5"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["shadingApproval"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["fabricWay"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["grade"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["status"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["invoiceNo2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["supplierId2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["styleNo2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["Buyer2"]; ?></td>
              <td class="normalfntTAB"><?php echo  $row["strColor2"]; ?></td>
			<td class="normalfntTAB"><?php echo  $row["receivedQty2"]; ?></td>


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
    </table></td>
  </tr>
</table>
</body>
</html>
