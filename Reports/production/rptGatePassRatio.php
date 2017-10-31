<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = '../../';
	$factoryId = $_SESSION["FactoryID"];
	$report_companyId = $factoryId;
	
	$orderNo 	 = $_GET["orderNo"] ;
	$tofactory 	 = $_GET["tofactory"];
	$fromfactory = $_GET["fromfactory"];
	$styleNo	 = $_GET["styleNo"];
	$CheckDate	 = $_GET["CheckDate"];
	$DateFrom	 = $_GET["DateFrom"];
	$DateTo		 = $_GET["DateTo"];

	$GPQtyArray = 0;
	$line = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro | Size Wise Production Gate Pass Report</title>
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
        <td height="36" class="head2">Size Wise Production Gate Pass Report</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0" id="tblItems">
      <tr bgcolor="#CCCCCC">
        <th width="6%" height="25" class="border-top-bottom-left" nowrap="nowrap" style="text-align:center"><b>STYLE NO</b></th>
        <th width="10%" class="border-top-bottom-left" nowrap="nowrap" style="text-align:center"><b>OREDER NO</b></th>
        <th width="11%" class="border-top-bottom-left" nowrap="nowrap" style="text-align:center"><b>COLOR</b></th>
        <th width="10%" class="border-top-bottom-left" nowrap="nowrap" style="text-align:center"><b>AOD DATE</b></th>
        <td width="21%" class="border-top-bottom-left" nowrap="nowrap" style="text-align:center"><b>AOD NO</b><th width="13%" class="border-All" nowrap="nowrap" style="text-align:center"><b>REQUREMENT</b></th>
      </tr>
      <?php
	   $sqlorderwise = "select distinct PGH.intStyleId,O.strStyle,O.strOrderNo,S.strColor,
	   date(PGH.dtmDate) as dtmDate,PGH.intFromFactory,PGH.intTofactory
						from productiongpheader PGH
						inner join orders O on O.intStyleId=PGH.intStyleId
						inner join styleratio S on S.intStyleId=O.intStyleId
						where PGH.intStatus=0 ";
						
	   	if($orderNo!="")
	  	 $sqlorderwise.="and O.intStyleId='$orderNo' ";
		
		if($styleNo!="")
	  	 $sqlorderwise.="and O.strStyle='$styleNo' ";
		
		if($fromfactory!="")
		$sqlorderwise.="and PGH.intFromFactory='$fromfactory' ";
		
		if($tofactory!="")
		$sqlorderwise.="and PGH.intTofactory='$tofactory' ";
		
		if($CheckDate=="1")
		{
			if($DateFrom!="")
			{
				$sqlorderwise.=" AND date(PGH.dtmDate)>='$DateFrom' ";
			}
			if($DateTo!="")
			{
				$sqlorderwise.=" AND date(PGH.dtmDate)<='$DateTo' ";
			}
		}
		$sqlorderwise.="group by O.strOrderNo order by O.strOrderNo ";
		//echo $sqlorderwise;			
	   $resultorderwise = $db->RunQuery($sqlorderwise);
	   $a = 0;
	   while($roworderwise = mysql_fetch_array($resultorderwise))
	   {
		   $a++;
		?>
            <tr >
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strStyle"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strOrderNo"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $roworderwise["strColor"]; ?>&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td bgcolor="#CCCCCC" class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>SIZE RATIO</b></td>
              <?php
			   $sqlRatio ="select distinct SR.strSize
						from productiongpheader PGPH
						inner join styleratio SR on SR.intStyleId=PGPH.intStyleId
						where PGPH.intStyleId='".$roworderwise["intStyleId"]."'
						and PGPH.intStatus=0 ";
				
	  	 $resultRatio=$db->RunQuery($sqlRatio);
		// echo $sqlRatio;
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
		<th bgcolor="#CCCCCC" class="border-All-fntsize10" nowrap="nowrap" style="text-align:center"><b>TOTAL</b></th>
        <?php
		}
		else
		{
		?>
        <th bgcolor="#CCCCCC" class="border-All-fntsize10" nowrap="nowrap" style="text-align:center"><b>TOTAL</b></th>
        <?php
		}
		?>
         </tr>
         <?php
		$sqlGp = "select concat(PGH.intYear,'/',PGH.intGPnumber) as AODNo,PGH.intYear,PGH.intGPnumber,date(PGH.dtmDate) as dtmDate
					from productiongpheader PGH
					inner join orders O on O.intStyleId=PGH.intStyleId
					where O.strOrderNo='".$roworderwise['strOrderNo']."' and PGH.intStatus=0 ";
		if($styleNo!="")
				$sqlGp.="and O.strStyle='$styleNo' ";
		
			if($fromfactory!="")
				$sqlRatio.="and PGH.intFromFactory='$fromfactory' ";
			
			if($tofactory!="")
				$sqlGp.="and PGH.intTofactory='$tofactory' ";
		
			if($CheckDate=="1")
			{
				if($DateFrom!="")
				{
					$sqlGp.=" AND date(PGH.dtmDate)>='$DateFrom' ";
				}
				if($DateTo!="")
				{
					$sqlGp.=" AND date(PGH.dtmDate)<='$DateTo' ";
				}
			}
		$sqlGp.="order by PGH.dtmDate ";
	//	echo $sqlGp;
		$resultGp=$db->RunQuery($sqlGp);
		$GPCount = mysql_num_rows($resultGp);
		$numGP = 1;
	   while($rowGp = mysql_fetch_array($resultGp))
	   {
		 
		$sqlSizes = "select distinct SR.strSize
						from productiongpheader PGPH
						inner join styleratio SR on SR.intStyleId=PGPH.intStyleId
						where PGPH.intStyleId='".$roworderwise["intStyleId"]."'
						and PGPH.intStatus=0";
			
		$resultSizes=$db->RunQuery($sqlSizes);
	   while($rowSizes = mysql_fetch_array($resultSizes))
	   {
		   
	   $sqlDetail = "select (select sum(dblQty) as cutQty from productiongpdetail PGPD
				inner join productiongpheader PGPH on PGPH.intGPnumber=PGPD.intGPnumber and PGPH.intYear=PGPD.intYear
				inner join productionbundledetails PBD on PBD.intCutBundleSerial=PGPD.intCutBundleSerial 
				where SUBSTRING_INDEX(PBD.strSize,'-', 1)='".$rowSizes["strSize"]."' 
				and PGPH.intGPnumber='".$rowGp["intGPnumber"]."' and PGPH.intYear='".$rowGp["intYear"]."' and PGPH.intStatus=0) as GPQty
				from styleratio SR
				inner join orders O on O.intStyleId=SR.intStyleId
				where strSize='".$rowSizes["strSize"]."' 
				and SR.intStyleId='".$roworderwise["intStyleId"]."'						
				group by strSize";
			$resultDetail = $db->RunQuery($sqlDetail);
			while($rowDetail = mysql_fetch_array($resultDetail))
			{
				$GPQtyArray 		.= ','.$rowDetail["GPQty"];
			}
	   }
		?>
			<tr>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $rowGp["dtmDate"]; ?>&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<?php echo $rowGp["AODNo"]; ?>&nbsp;</td>
            <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<strong>GATE PASS QTY</strong></td>  
		<?php
			for($i=1;$i<=$sizeCount;$i++)
			{
				
				$GPQtyArrayNew = explode(',',$GPQtyArray);
				$totGPQty += $GPQtyArrayNew[$i]; 
				
			?>
				<td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:right">
				<?php echo ($GPQtyArrayNew[$i]=='' ? "":number_format($GPQtyArrayNew[$i],0));
				$tot_size_qty[$i]+=$GPQtyArrayNew[$i] ?></td>
            <?php
			}
			?>
            <td class="border-Left-bottom-right-fntsize10" nowrap="nowrap" style="text-align:right"><b><?php echo number_format($totGPQty,0); ?></b></td>
			</tr>
            <?php
         if($numGP==$GPCount)   
		 {
		 ?>
        <tr>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;&nbsp;</td>
          <td class="border-bottom-left-fntsize10" nowrap="nowrap" style="text-align:left">&nbsp;<b>TOTAL</b></td>
          <?php
       for($l=1;$l<=$sizeCount;$l++)
			{
				$totQty += $tot_size_qty[$l]; 
			?>
          <td class="border-bottom-left-fntsize10 " nowrap="nowrap" style="text-align:right"><b>
		  <?php echo ($tot_size_qty[$l]==""?"":number_format($tot_size_qty[$l],0)); ?></b></td>
          <?php
			}
			?>
          <td class="border-Left-bottom-right-fntsize10 " nowrap="nowrap" style="text-align:right"><b><?php echo number_format($totQty,0); ?></b></td>
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
		 }
				$numGP++;
				$GPQtyArray = 0;
				$totGPQty = 0;
	   }
				
				$line = 1;
				//$totGPQty = 0;
				$totQty = 0;
				unset($tot_size_qty);
				
		
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
