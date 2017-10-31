<style type="text/css">
.tduserAdminLeftTopBottom
{
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminTopBottom
{
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
	border-bottom-style:solid; 
	border-bottom-width:1px;
	border-bottom-color:#000000;
}
.tduserAdminLeftTop1
{
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminTop1
{
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminFull1
{
	border-bottom-style:solid; 
	border-bottom-width:1px;
	border-bottom-color:#000000;
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	border-right-style:solid; 
	border-right-width:1px; 
	border-right-color:#000000;
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminLeftTopRight1
{
	border-top-style:solid; 
	border-top-width:1px;
	border-top-color:#000000;
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	border-right-style:solid; 
	border-right-width:1px; 
	border-right-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminLeft
{
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;
	
}
.tdFormat
{
	font-family:Calibri;
	font-size:13px;
	font-style:normal; 
	color:#000000;	
}
.tduserAdminLeftBottom{ 
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	border-bottom-width:1px;
	border-bottom-style:solid;
	border-bottom-color:#000000;
	font-family:Verdana;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminBottomRight{ 
	border-bottom-width:1px;
	border-bottom-style:solid;
	border-bottom-color:#000000;
	border-right-style:solid; 
	border-right-width:1px; 
	border-right-color:#000000;
	font-family:Verdana;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
.tduserAdminLeftBottomRight{ 
	border-bottom-width:1px;
	border-bottom-style:solid;
	border-bottom-color:#000000;
	border-right-style:solid; 
	border-right-width:1px; 
	border-right-color:#000000;
	border-left-style:solid; 
	border-left-width:1px; 
	border-left-color:#000000;
	font-family:Verdana;
	font-size:13px;
	font-style:normal; 
	color:#000000;
}
</style>

 <table width="504" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td height="23" colspan="4" align="center"  class="tdFormat" bgcolor="#0066FF"><strong>FOB Sales</strong><strong></strong> </td> 
  </tr>
 <tr>
  <td width="203" height="23" align="center" bgcolor="#00CCFF" class="tdFormat"><strong>Buyer</strong> </td> 
  <td width="104" class="tdFormat" align="center" bgcolor="#00CCFF"><strong>Forecast</strong></td>  
  <td width="104" class="tdFormat" align="center" bgcolor="#00CCFF"><strong>Actual</strong> </td> 
  <td width="93" class="tdFormat" align="center" bgcolor="#00CCFF"><strong>Variance</strong> </td> 
  </tr>   
   <tr> 
  <td width="203" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="104" class="tdFormat"><strong>&nbsp;</strong> </td>  
  <td width="104" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="93" class="tdFormat"><strong>&nbsp;</strong> </td> 
  </tr>   
 </table>
    <?php
$uri =$_SERVER["HTTP_REFERER"] ;
$splitdata = explode('=',$uri);
$Dto=$splitdata[0];
$dt_report=$splitdata[1];



$int_report_month = date("n",strtotime($dt_report));
$int_report_year = date("Y", strtotime($dt_report));	
$int_day_of_week = date("w", strtotime($dt_report));


	
if($int_report_month<'10')
{
$startdate="$int_report_year-0$int_report_month-01";
$enddate="$int_report_year-0$int_report_month-31";
}
else
{
$startdate="$int_report_year-$int_report_month-01";
$enddate="$int_report_year-$int_report_month-31";
}

//                     include'db.php';		
//		            $sqlmin="SELECT
//					Min(d2d_efficincy.createdate)as mindate
//					FROM
//					d2d_efficincy
//					WHERE
//					d2d_efficincy.createdate >='$startdate'";			
//				    $resultmin = mysql_query($sqlmin);					
//					while($rowmin= mysql_fetch_array($resultmin))
//                        {	
//						$signupdate=$rowmin['mindate'];
//						
//						}
						


function find_the_first_monday($dt_report)
{
    $time = strtotime($dt_report);
    $year = date('Y', $time);
    $month = date('m', $time);

    for($day = 1; $day <= 31; $day++)
    {
        $time = mktime(0, 0, 0, $month, $day, $year);
        if (date('N', $time) == 1)
        {
            return date('Y-m-d', $time);
        }
    }
}

$signupdate=find_the_first_monday($dt_report);
				
$signupweek=date("W",strtotime($signupdate));
$year=date("Y",strtotime($signupdate));
$dtdate =$enddate;
$currentweek=date("W",strtotime($dtdate));

for($i=$signupweek;$i<=$currentweek;$i++) {
    $result=getWeek($i,$year);
    echo "Week Start:".$result['start']." Week End :".$result['end'];	
	
	
	?>
    <tr>
     <td width="106" class="tdFormat">&nbsp;</td>
  <td width="106" class="tdFormat"><strong>&nbsp;</strong> </td>  
  <td width="77" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="79" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="81" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="79" class="tdFormat"><strong>&nbsp;</strong> </td>  
  <td width="80" class="tdFormat"><strong>&nbsp;</strong> </td> 
  <td width="94" class="tdFormat"><strong>&nbsp;</strong> </td> 
  </tr>    <?php
	
	$dfrom=$result['start'];
	$dto=$result['end'];
	?>
	
	<table width="503" border="0" cellpadding="0" cellspacing="0">

   <?php
      $con = mysql_connect("172.23.1.14:3306","root","He20La14") or die("not conenct");
	  $db = mysql_select_db("gapro",$con);

										 
											$sqlgmt="SELECT
											distinct(buyers.intBuyerID),
											buyers.strName
											FROM
											bpodelschedule
											INNER JOIN orders ON orders.intStyleId = bpodelschedule.intStyleId
											INNER JOIN buyers ON buyers.intBuyerID = orders.intBuyerID
 ORDER BY
											buyers.strName ASC";
											$resultg = mysql_query($sqlgmt);
                                               $iRowCnt = 0;
											   
                                                while($rowg= mysql_fetch_array($resultg))
                                                {	
												$strMainBuyerCode=$rowg['strName'];
												$intBuyerID=$rowg['intBuyerID'];
												
                                            ?>
    <tr>
    <td class="tduserAdminLeftTop1">&nbsp;<?php echo ($strMainBuyerCode);?></td>
    <td class="tduserAdminLeftTopBottom" align="right">&nbsp;<?php
						     $con = mysql_connect("172.23.1.14:3306","root","He20La14") or die("not conenct");
	  						 $db = mysql_select_db("gapro",$con);
	  
							$sqlb="SELECT
							sum((deliveryschedule.dblQty*orders.reaFOB)) as fobcost
							FROM
							deliveryschedule
							INNER JOIN orders ON orders.intStyleId = deliveryschedule.intStyleId
							INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
							WHERE
							deliveryschedule.dtmHandOverDate >= '$dfrom' AND
							deliveryschedule.dtmHandOverDate <= '$dto' AND
							orders.intBuyerID = '$intBuyerID' AND
							deliveryschedule.strShippingMode <> '7'";
							$resultb = mysql_query($sqlb);
						
	 						while($rowb= mysql_fetch_array($resultb))
                                    {	
									$forcast=$rowb['fobcost'];								    
									}
	                      
						    echo  number_format($forcast,2);
												
	?>&nbsp;</td>
    <td class="tduserAdminLeftTopBottom" align="right">&nbsp; <?php
    
         $total_amount='0';
	     $con = mysql_connect("172.23.1.15:3306","root","He20La14") or die("not conenct");
	     $db = mysql_select_db("myexpo",$con);
	 
	 
	   $invoiceNumberSql = "SELECT
						buyers_main.strMainBuyerCode,
						cdn_header.strInvoiceNo
						FROM
						cdn_header
						Inner Join buyers ON cdn_header.intConsignee = buyers.intBuyerID
						Inner Join buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
						Inner Join pre_invoice_header ON cdn_header.strInvoiceNo = pre_invoice_header.strInvoiceNo
						WHERE
						DATE(cdn_header.dtmDate) BETWEEN '$dfrom' AND '$dto'
						AND buyers_main.gaprobuyer = '$strMainBuyerCode'
						GROUP BY
						cdn_header.strInvoiceNo
						ORDER BY
						cdn_header.strInvoiceNo ASC";
	
	$exec_sql = mysql_query($invoiceNumberSql,$con);
	
	while($invoice = mysql_fetch_array($exec_sql)){
		$inv_total_cm = 0;
		$inv_total_smv = 0;
			
		$invoice_no = $invoice['strInvoiceNo'];
		
		$tot_sql = "SELECT
					Sum(cdn_detail.dblQuantity) AS QTY,
					Sum(cdn_detail.dblAmount) AS AMOUNT,
					cdn_detail.strUnitID AS QTY_UNIT
					FROM
					cdn_detail
					WHERE
					cdn_detail.strInvoiceNo = '$invoice_no'";
					
		$exec_tot = mysql_query($tot_sql,$con);
    	$tot = @mysql_fetch_array($exec_tot);		
		$total_amount = $total_amount + (float)$tot['AMOUNT'];		
    }
	echo number_format($total_amount,2);
	
    ?>&nbsp;</td>
  <td class="tduserAdminLeftTopRight1" align="right">&nbsp;<?php echo number_format(($forcast-$total_amount),2);?>&nbsp;</td>
    <?php $iRowCnt ++;	}?>
  </tr>
  <tr>
    <td width="183" class="tduserAdminFull1">&nbsp;<strong>Total</strong></td>
    <td width="103"  class="tduserAdminFull1" align="right"><strong>
      <?php
						     $con = mysql_connect("172.23.1.14:3306","root","He20La14") or die("not conenct");
	  						 $db = mysql_select_db("gapro",$con);
	  
							 $sqlb="SELECT
							sum((deliveryschedule.dblQty*orders.reaFOB)) as fobcost
							FROM
							deliveryschedule
							INNER JOIN orders ON orders.intStyleId = deliveryschedule.intStyleId
							INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
							WHERE
							deliveryschedule.dtmHandOverDate >= '$dfrom' AND
							deliveryschedule.dtmHandOverDate <= '$dto' AND
							deliveryschedule.strShippingMode <> '7' AND
orders.intStatus <> '14'";
							$resultb = mysql_query($sqlb);
						
	 						while($rowb= mysql_fetch_array($resultb))
                                    {	
									$forcast=$rowb['fobcost'];								    
									}
	                      
						    echo  number_format($forcast,2);
												
	?>
    </strong>&nbsp;</td>
    <td width="106" class="tduserAdminFull1" align="right"><strong>
      <?php
    
         $total_amount='0';
	     $con = mysql_connect("172.23.1.15:3306","root","He20La14") or die("not conenct");
	     $db = mysql_select_db("myexpo",$con);
	 
	 
	   $invoiceNumberSql = "SELECT
						buyers_main.strMainBuyerCode,
						cdn_header.strInvoiceNo
						FROM
						cdn_header
						Inner Join buyers ON cdn_header.intConsignee = buyers.intBuyerID
						Inner Join buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
						Inner Join pre_invoice_header ON cdn_header.strInvoiceNo = pre_invoice_header.strInvoiceNo
						WHERE
						DATE(cdn_header.dtmDate) BETWEEN '$dfrom' AND '$dto'
						GROUP BY
						cdn_header.strInvoiceNo
						ORDER BY
						cdn_header.strInvoiceNo ASC";
	
	$exec_sql = mysql_query($invoiceNumberSql,$con);
	
	while($invoice = mysql_fetch_array($exec_sql)){
		$inv_total_cm = 0;
		$inv_total_smv = 0;
			
		$invoice_no = $invoice['strInvoiceNo'];
		
		$tot_sql = "SELECT
					Sum(cdn_detail.dblQuantity) AS QTY,
					Sum(cdn_detail.dblAmount) AS AMOUNT,
					cdn_detail.strUnitID AS QTY_UNIT
					FROM
					cdn_detail
					WHERE
					cdn_detail.strInvoiceNo = '$invoice_no'";
					
		$exec_tot = mysql_query($tot_sql,$con);
    	$tot = @mysql_fetch_array($exec_tot);		
		$total_amount = $total_amount + (float)$tot['AMOUNT'];		
    }
	echo number_format($total_amount,2);
	
    ?>
   </strong>&nbsp;</td>
    <td width="111"  class="tduserAdminFull1" align="right"><strong><?php echo number_format(($forcast-$total_amount),2);?>&nbsp;</strong></td>
    </tr>
      <tr>
    <td width="183">&nbsp;</td>
    <td width="103">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td width="111" >&nbsp;</td>
    </tr>
    </table>


<?php
      }
	?>

 
 <?php 

function getWeek($week, $year) {
  $dto = new DateTime();
  $result['start'] = $dto->setISODate($year, $week, 1)->format('Y-m-d');
  $result['end'] = $dto->setISODate($year, $week, 6)->format('Y-m-d');
 // $Sizevalues[] = array("sizeid" => $size);
  return $result;
}
	?>