<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = '../../';
	$factoryId = $_SESSION["FactoryID"];
	$report_companyId = $factoryId;
	
	$orderNo 	= $_GET["orderNo"];
	$division 	= $_GET["division"];
	$Factory 	= $_GET["Factory"];
	$styleNo	= $_GET["styleNo"];
	$CheckDate	= $_GET["CheckDate"];
	$DateFrom	= $_GET["DateFrom"];
	$DateTo		= $_GET["DateTo"];
	
	$poQtyArray = 0;
	$allocateQtyArry = 0;
	$cutQtyArry = 0;
	$varianceArray = 0;
	$line = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Washing Plan</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" class="head2">Cut Quantity Report</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblItems">
      <tr bgcolor="#CCCCCC">
        <th width="6%" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center">&nbsp;<b>Bulk Start&nbsp;<br />&nbsp;Date</b>&nbsp;</th>
        <th width="10%" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>FTY</b></th>
        <th width="11%" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>PO No</b></th>
        <th width="10%" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>DIV</b></th>
        <td width="21%" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>COLOUR</b></th>
        <th width="13%" class="border-All-fntsize10" nowrap="nowrap" style="text-align:center"><b>REQUREMENT</b></th>
      </tr>
      <?php
	   $sqlorderwise = "select distinct C.strComCode,O.strOrderNo,BD.strDivision,SR.strColor,PBH.intStyleId as styleId
						from productionbundleheader PBH
						inner join companies C on C.intCompanyID=PBH.strToFactory
						inner join orders O on O.intStyleId=PBH.intStyleId
						inner join buyerdivisions BD on BD.intDivisionId=O.intDivisionId
						inner join styleratio SR on SR.intStyleId=PBH.intStyleId
						where PBH.cut_type=1 ";
	   	if($orderNo!="")
	  	 $sqlorderwise.="and PBH.intStyleId='$orderNo' ";
		
		if($styleNo!="")
	  	 $sqlorderwise.="and O.strStyle='$styleNo' ";
		 
		if($division!="")
		$sqlorderwise.="and BD.intDivisionId='$division' ";
		
		if($Factory!="")
		$sqlorderwise.="and C.intCompanyID='$Factory' ";
		
		if($CheckDate=="1")
		{
			if($DateFrom!="")
			{
				$sqlorderwise.=" AND date(PBH.dtmCutDate)>='$DateFrom' ";
			}
			if($DateTo!="")
			{
				$sqlorderwise.=" AND date(PBH.dtmCutDate)<='$DateTo' ";
			}
		}
		$sqlorderwise.="group by BD.strDivision ";
					
	   $resultorderwise = $db->RunQuery($sqlorderwise);
	   $a = 0;
	   while($roworderwise = mysql_fetch_array($resultorderwise))
	   {
		   $a++;
		?>
            <tr >
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strComCode"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strOrderNo"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strDivision"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strColor"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>SIZE RATIO</b></td>
              <?php
			   $sqlRatio ="select distinct SR.strSize
						from productionbundleheader PBH
						inner join styleratio SR on SR.intStyleId=PBH.intStyleId
						where PBH.intStyleId='".$roworderwise["styleId"]."'
						and PBH.cut_type=1";
				
	  	 $resultRatio=$db->RunQuery($sqlRatio);
		  $sizeCount = mysql_num_rows($resultRatio);
		   while($rowRatio = mysql_fetch_array($resultRatio))
			{	
				if($line == 0)
				{ 
		?>		
              <th bgcolor="#CCCCCC" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>&nbsp;<?php echo $rowRatio["strSize"]; ?>&nbsp;</b></th>
        <?php
				}
				else
				{
					?>
					 <th bgcolor="#CCCCCC" class="border-top-bottom-left-fntsize10" nowrap="nowrap" style="text-align:center"><b>&nbsp;<?php echo $rowRatio["strSize"]; ?>&nbsp;</b></th>
                   <?php
					
				}
		}
		if($line == 0)
		{
		?>
		<th bgcolor="#CCCCCC" class="border-All-fntsize10" nowrap="nowrap" style="text-align:center"><b>Total</b></th>
        <?php
		}
		else
		{
		?>
        <th bgcolor="#CCCCCC" class="border-All-fntsize10" nowrap="nowrap" style="text-align:center"><b>Total</b></th>
        <?php
		}
		?>
         </tr>
         <?php
		$sqlSizes = "select distinct SR.strSize
						from productionbundleheader PBH
						inner join styleratio SR on SR.intStyleId=PBH.intStyleId
						where PBH.intStyleId='".$roworderwise["styleId"]."'
						and PBH.cut_type=1 ";
			
		$resultSizes=$db->RunQuery($sqlSizes);
	   while($rowSizes = mysql_fetch_array($resultSizes))
	   {
		   
		   $sqlDetail = "select sum(dblQty) as POQty,sum(dblExQty) as AllocateQty,
						(select sum(dblPcs) as cutQty from productionbundledetails PBD 
						inner join productionbundleheader PBH on PBH.intCutBundleSerial=PBD.intCutBundleSerial 
						where SUBSTRING_INDEX(PBD.strSize,'-', 1)='".$rowSizes["strSize"]."' 
						and PBH.intStyleId='".$roworderwise["styleId"]."' and PBH.cut_type=1) as cutQty
						from styleratio SR
						inner join orders O on O.intStyleId=SR.intStyleId
						where strSize='".$rowSizes["strSize"]."' 
						and SR.intStyleId='".$roworderwise["styleId"]."'						
						group by strSize";
			$resultDetail = $db->RunQuery($sqlDetail);
			while($rowDetail = mysql_fetch_array($resultDetail))
			{
				$poQtyArray 		.= ','.$rowDetail["POQty"];
				$allocateQtyArry 	.= ','.$rowDetail["AllocateQty"];
				$cutQtyArry 		.= ','.$rowDetail["cutQty"];
				$varianceArray 		.= ','.($rowDetail["cutQty"]-$rowDetail["AllocateQty"]);
	
			}
	   }
		?>
			<tr>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>PO QTY</b>&nbsp;</td>  
		<?php
			for($i=1;$i<=$sizeCount;$i++)
			{
				
				$poQtyArrayNew = explode(',',$poQtyArray);
				$totPoQty += $poQtyArrayNew[$i]; 
				
			?>
				<td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($poQtyArrayNew[$i],0); ?></td>
            <?php
			}
			?>
            <td class="border-Left-bottom-right-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($totPoQty,0); ?></td>
			</tr>
            <tr>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>ALLOCATED QTY </b>&nbsp;</td> 
        <?php   
			for($j=1;$j<=$sizeCount;$j++)
			{
				$AllocQtyArrayNew = explode(',',$allocateQtyArry);
				$totAllocQty += $AllocQtyArrayNew[$j]; 
			?>
				<td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($AllocQtyArrayNew[$j],0); ?></td>
			 <?php
			}
			?>
            <td class="border-Left-bottom-right-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($totAllocQty,0); ?></td>
       </tr>
        <tr>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>CUT QTY </b>&nbsp;</td>
       <?php   
		for($k=1;$k<=$sizeCount;$k++)
			{
				$cutQtyArrayNew = explode(',',$cutQtyArry);
				$totcutQty += $cutQtyArrayNew[$k]; 
			?>
				<td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($cutQtyArrayNew[$k],0); ?></td>
			 <?php
			}
			?>
            <td class="border-Left-bottom-right-fntsize10" nowrap="nowrap" style="text-align:right"><?php echo number_format($totcutQty,0); ?></td>
	   
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
        <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b><span class="compulsoryRed">VAR </span></b>&nbsp;</td>
        <?php
       for($l=1;$l<=$sizeCount;$l++)
			{
				$varQtyArrayNew = explode(',',$varianceArray);
				$totvarQty += $varQtyArrayNew[$l]; 
			?>
				<td class="border-bottom-left-fntsize10 compulsoryRed" nowrap="nowrap" style="text-align:right"><?php echo number_format($varQtyArrayNew[$l],0); ?></td>
			 <?php
			}
			?>
            <td class="border-Left-bottom-right-fntsize10 compulsoryRed" nowrap="nowrap" style="text-align:right"><?php echo number_format($totvarQty,0); ?></td>
            </tr>
             <tr>
             <?php
			 if(mysql_num_rows($resultorderwise)!=$a)
			 {
			?>
        <td colspan="6" nowrap="nowrap" class="border-bottom-fntsize10" style="text-align:left">&nbsp;&nbsp;</td>
        	<?php
			 }
			 ?>
        </tr> 
		<?php
				$poQtyArray = 0;
				$allocateQtyArry = 0;
				$cutQtyArry = 0;
				$varianceArray = 0;
				$line = 1;
				$totPoQty = 0;
				$totAllocQty = 0;
				$totcutQty = 0;
				$totvarQty = 0;
	   }
		?> 
       
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  </table></td>
  </tr>
</table>
</body>
</html>
