<?php
session_start();
	include "../Connector.php";	
	
	
	$CompanyId=$_SESSION["FactoryID"];
	$UserID=$_SESSION["UserID"];	
	
	$str_header		="select 	frh.intFRollSerialNO, 
								frh.intFRollSerialYear, 
								frh.strSupplierID, 
								frh.intStyleId, 
								frh.strMatDetailID, 
								frh.strColor, 
								frh.strWashType, 
								frh.strInvoiceNo, 
								frh.intStatus, 
								frh.intStoresID, 
								frh.intUserID, 
								date(frh.dtmDate) as dtmDate, 
								frh.strRemarks,
								ordz.strStyle,
								s.strTitle, 
								frh.intCompanyID,
								mlst.strItemDescription,
								sum(dblLength)as totyards,
								count(frd.intFRollSerialNO)as rolls 
								from 
								fabricrollheader frh left join orders ordz on ordz.intStyleId=frh.intStyleId
								left join suppliers s on s.strSupplierID=frh.strSupplierID 
								left join matitemlist mlst on mlst.intItemSerial=frh.strMatDetailID
								left join fabricrolldetails frd on frd.intFRollSerialNO=frh.intFRollSerialNO
								and  frd.intFRollSerialYear=frh.intFRollSerialYear
								
								where 
								frh.intFRollSerialNO ='114' and
								frh.intFRollSerialYear='2010' 
								group by frh.intFRollSerialNO,frh.intFRollSerialYear ";
	$result_header	=$db->RunQuery($str_header);
	
	while($row_header=mysql_fetch_array($result_header))
	{
		$invoice=$row_header["strInvoiceNo"];
		$Style=$row_header["strStyle"];
		$supplier=$row_header["strTitle"];
		$InvoiceNo=$row_header["strInvoiceNo"];
		$date=$row_header["dtmDate"];	
		$ItemDescription=$row_header["strItemDescription"];
		$date_array=explode("-",$date);
		$date=$date_array[2]."/".$date_array[1]."/".$date_array[0];
		$color=$row_header["strColor"];
		$washtype=$row_header["strWashType"];
		$tot_yards=$row_header["totyards"];
		$tot_rolls=$row_header["rolls"];
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shrinkage Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="900" border="0" cellpadding="0"  cellspacing="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">QAP 12-D</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt_size20" style="text-align:center">ORIT APPAREL (PVT) Ltd, SEETHAWAKA</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="25%">&nbsp;</td>
        <td width="50%" class="normalfnt2bldBLACKmid" >SHRIKAGE TESTING REPORT </td>
        <td width="25%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnBLD1">
      <tr on>
        <td height="20">&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="20">PO#</td>
        <td class="border-bottom-fntsize12">:<?php echo "";?></td>
        <td>&nbsp;</td>
        <td>INVOICE # </td>
        <td class="border-bottom-fntsize12">:<?php echo $InvoiceNo;?></td>
      </tr>
      <tr>
        <td height="20">COLOR &amp; DIM </td>
        <td class="border-bottom-fntsize12">:<?php echo $color;?></td>
        <td>&nbsp;</td>
        <td>NO. OF ROLLS </td>
        <td class="border-bottom-fntsize12">:<?php echo $tot_rolls;?></td>
      </tr>
      <tr>
        <td height="20">STYLE</td>
        <td class="border-bottom-fntsize12">:<?php echo $Style;?></td>
        <td>&nbsp;</td>
        <td>TOTAL YARDS </td>
        <td class="border-bottom-fntsize12">:<?php echo $tot_yards;?></td>
      </tr>
      <tr>
        <td height="20">FABRIC SUPPLIER </td>
        <td class="border-bottom-fntsize12">:<?php echo $supplier;?></td>
        <td>&nbsp;</td>
        <td>DATE</td>
        <td class="border-bottom-fntsize12">:<?php echo $date;?></td>
      </tr>
      <tr>
        <td height="20">TYPE OF WASH </td>
        <td colspan="3" class="border-bottom-fntsize12">:<?php echo $washtype;?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">FABRIC DESC &amp; ID </td>
        <td colspan="3" class="border-bottom-fntsize12">:<?php echo $ItemDescription;?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="4">DIMENSION USED FOR SHRINKAGE :- </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="15%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
     	  <tr>
        <td width="70%" valign="top" class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
          <tr class="normalfntMid">
		  <thead>
            <td rowspan="2" class="border-top-fntsize12" style="text-align:center;font-weight:600">#</td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Roll</td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Yards</td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Fabric Width </td>
            <td colspan="2" align="center" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Shrikage % </td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Shade</td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Pttn # </td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Skewness</td>
            <td rowspan="2" class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Elongation</td>
          </tr>
          <tr>
            <td class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Length</td>
            <td class="border-top-left-fntsize12" style="text-align:center;font-weight:600">Width</td>
          </tr>
          <tr>
            <td class="border-top-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12" >&nbsp;</td>
          </tr></thead>
          <?PHP 
		  		$str_detail		="select 	
								intFRollSerialNO, 
								intFRollSerialYear, 
								intRollNo, 
								dblLength, 
								dblWidth, 
								dblShrinkageLength, 
								dblShrinkageWidth, 
								strShade, 
								dblQty, 
								dblBalQty, 
								intInspected, 
								intApproved, 
								intRejected, 
								dblPtrn, 
								dblSkewness, 
								dblElongation, 
								intStatus
								
								from 
								fabricrolldetails 
								where 
								intFRollSerialNO=114
								and intFRollSerialYear=2010 
								order by dblPtrn";
								$no=0;
				$result_details	=$db->RunQuery($str_detail);
				while($row_detail=mysql_fetch_array($result_details))		
		  {$no++;
		  ?>
          <tr>
            <td class="border-top-fntsize12" style="text-align:right"><?php echo $no;?></td>
            <td class="border-top-left-fntsize12"  style="text-align:center"><?php echo $row_detail["intRollNo"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblLength"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblWidth"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblShrinkageLength"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblShrinkageWidth"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:center"><?php echo $row_detail["strShade"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblPtrn"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblSkewness"];?></td>
            <td class="border-top-left-fntsize12"  style="text-align:right"><?php echo $row_detail["dblElongation"];?></td>
          </tr>
          <?PHP } for($loop=$no;$loop<45;$loop++){?>
          <tr>
            <td class="border-top-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12">&nbsp;</td>
            <td class="border-top-left-fntsize12" >&nbsp;</td>
          </tr><?php }?>
		  <tfoot> 
          <tr>		 
            <td width="5%"  class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="7%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
            <td width="11%" class="border-top-fntsize12">&nbsp;</td>
         </tr></tfoot>
        </table></td>
        <td width="30%" class="border-Left-Top-right-fntsize12" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
          <tr>
            <td style="text-align:left;font-weight:600" class="border-bottom-fntsize12"><div align="center">SUMMARY</div></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">P.O. SHRINKAGE : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">INVOICE SHRINKAGE : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">ACTUAL SHRINKAGE : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12"><table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td width="30%" style="text-align:left;font-weight:400">LENGTH :</td>
                <?php 
					$sqlAcshrink = "select min(dblShrinkageLength) as minlength,max(dblShrinkageLength) as maxlength,
									min(dblShrinkageWidth) as minwidth, max(dblShrinkageWidth) as maxwidth
									from fabricrolldetails
									where intFRollSerialNO=114 and intFRollSerialYear=2010 and dblShrinkageLength>0";
							
							$resultAcshrink = $db->RunQuery($sqlAcshrink);	
							$rowShrink = mysql_fetch_array($resultAcshrink);
							
				?>
                <td width="50%" style="text-align:left;font-weight:400"><?php echo $rowShrink["minlength"].'%'.' - '.$rowShrink["maxlength"].'%'?></td>
              </tr>
              <tr>
                <td>WIDTH :</td>
                <td><?php echo $rowShrink["minwidth"].'%'.' - '.$rowShrink["maxwidth"].'%'?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600"> SHRINKAGE (AATCC135) : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">P.O. WIDTH : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">INVOICE WIDTH : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">ACTUAL FABRIC WIDTH : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">
			<?php 
				$str_actual_width="select max(dblWidth)as maxwidth,min(dblWidth) as minwidth from fabricrolldetails where intFRollSerialNO=114 and intFRollSerialYear=2010 ";
				$result_actual_width=$db->RunQuery($str_actual_width);
				$row_actual_width=mysql_fetch_array($result_actual_width);
				echo $row_actual_width["minwidth"].'" '.$row_actual_width["maxwidth"].'" ';
			?></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">CUTABLE WIDTH : </td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12"><?php echo $row_actual_width["minwidth"].'" '.$row_actual_width["maxwidth"].'" ';?></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="normalfntSMB">
                <tr>
                  <td class="border-bottom-fntsize12"><span class="normalfntSMB">PATTERNNO</span></td>
                  <td colspan="2" class="border-bottom-left-fntsize12"><span class="normalfntSMB">SHRINKAGE</span></td>
                </tr>
                <tr>
                  <td class="border-bottom-fntsize12">&nbsp;</td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntSMB">LENGTH</span></td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntSMB">WIDTH</span></td>
                </tr>
				<?php 
				$str_compose_pttrn		="select dblPtrn, 
				avg(dblShrinkageLength) as shrinklength,
				avg(dblShrinkageWidth) as shrinkwidth 
				from fabricrolldetails where 
				intFRollSerialNO=114
				and intFRollSerialYear=2010 
				group by dblPtrn
				order by dblPtrn";
				$result_compose_pttrn=$db->RunQuery($str_compose_pttrn);
				while($row_compose_pttrn=mysql_fetch_array($result_compose_pttrn)){
				$shrinklength	 =strlen(round($row_compose_pttrn["shrinklength"]));
				$shrinklength	 =substr($row_compose_pttrn["dblPtrn"],0, $shrinklength);
				$shrinkwidth 	 =strlen(round($row_compose_pttrn["shrinkwidth"]));
				$shrinkwidth	 =substr($row_compose_pttrn["dblPtrn"],($shrinklength*-1));
				?>
				
                <tr>
                  <td class="border-bottom-fntsize12" style="text-align:center"><span class="normalfntRiteSML"><?php echo $row_compose_pttrn["dblPtrn"];?></span></td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntRiteSML"><?php echo $shrinklength;?></span></td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntRiteSML"><?php echo $shrinkwidth;?></span></td>
                </tr><?php }?>
                <tr>
                  <td width="40%">&nbsp;</td>
                  <td width="30">&nbsp;</td>
                  <td width="30%">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600"><span class="normalfntSMB">REMARKS</span></td>
          </tr>
          <tr>
            <td class="border-bottom-fntsize12">&nbsp;</td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="normalfntSMB">
                <tr>
                  <td class="border-bottom-fntsize12"><span class="normalfntSMB">PATTERN</span></td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntSMB">ROLLS</span></td>
                  <td class="border-bottom-left-fntsize12"><span class="normalfntSMB">YARDS</span></td>
                </tr>
				<?php 
						$str_pttrn_tot		="select dblPtrn, sum(dblLength) as yards,count(intRollNo) as rolls
						from fabricrolldetails where 
						intFRollSerialNO=114
						and intFRollSerialYear=2010 
						group by dblPtrn
						order by dblPtrn";
				$result_pttrn_tot=$db->RunQuery($str_pttrn_tot);
				while($row_pttrn_tot=mysql_fetch_array($result_pttrn_tot)){
				?>
                <tr>
                  <td style="text-align:center" class="border-bottom-fntsize12"><span class="normalfntRiteSML"><?php echo $row_pttrn_tot["dblPtrn"];?></span></td>
                  <td class="border-bottom-left-fntsize12" style="text-align:right"><span class="normalfntRiteSML"><?php echo $row_pttrn_tot["rolls"];?></span></td>
                  <td class="border-bottom-left-fntsize12" style="text-align:right"><span class="normalfntRiteSML"><?php echo $row_pttrn_tot["yards"];?></span></td>
                </tr><?php  } ?>
                <tr>
                  <td width="40%">&nbsp;</td>
                  <td width="30">&nbsp;</td>
                  <td width="30%">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">NARROW WIDTH :</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">OK TO CUT YARDAGE :</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:left;font-weight:600">HOLD YARDAGE :</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr ><td colspan="2" class="border-top-fntsize12">&nbsp;</td></tr>
    </table></td>
  </tr>
</table>


</body>
</html>
