<?php
 session_start();
include "../../../Connector.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Stock Balance - Item Wise Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<?PHP
			$mainId		= $_GET["mainId"];
			$subId		= $_GET["subId"];
			$matItem	= $_GET["maiItem"];
			$color		= $_GET["color"];
			$size		= $_GET["size"];
			$style		= $_GET["style"];
			$mainStores	= $_GET["mainStores"];
			$with0		= $_GET["with0"];
			$x			= $_GET["x"];
			$txtmatItem	= $_GET["txtmatItem"];
			$StyleNo = $_GET["StyleNo"];
			$OrderType = $_GET["OrderType"];
			$withLeftVal = $_GET["withLeftVal"];
			?>
<table width="800" border="0" align="center" >
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="75%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;" ><?php
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
		?></td>
<p class="head2BLCK"><?php echo $strName; ?></p>
<p class="normalfntMid">
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
	  <?PHP
			$SQL = 	"SELECT  mainstores.strName FROM mainstores where strMainID=$mainStores";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
				$sStores =  $row["strName"];
				
			if($sStores=='')
				$sStores = 'All';	
				
			switch($x)
			{
				case 'all':
				{
					$reportType = 'All';
					break;
				}
				case 'running':
				{
					$reportType = 'Running';
					break;
				}
				case 'leftOvers':
				{
					$reportType = 'Leftover';
					break;
				}
			}	
		?>
        <td width="91%" height="38" class="head1">STOCK BALANCE REPORT ( <span><?php echo $sStores; ?></span> ) - <?php echo $reportType; ?></td>
        </tr>
    </table></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <tr bgcolor="#CCCCCC" class="normalfntMid">
          <th width="13%" >Item Code No</th>
          
         
          <th width="21%" height="22" >Description</th>
          <th width="7%" >Color</th>
          <th width="8%" >Size</th>
           <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
          <th width="8%" >Stock Balance </th>
          <th width="12%" >Stock Balance Value </th>
         
           
          <?php
		  
		//  $costCenterId = '1,2';
		  
		 
		   
		  $sqlCC = "SELECT
CC.strMainID,
CC.strName
FROM
mainstores AS CC ";
		  if($mainStores !='')
		  $sqlCC .= " WHERE CC.strMainID IN ($mainStores)";
		  //echo $sqlCC;
		  		$resultCC = $db->RunQuery($sqlCC);
				$numRows = mysql_num_rows($resultCC );
			while($rowCC = mysql_fetch_array($resultCC)){
			
			echo "  <th width='8%' >".$rowCC['strName']." QTY</th>";	
			}
		  
		  ?>
        
         
         
         
          <?php 
		  }
		  	
		  ?>
          
          
        </tr>
		<?php
		$check	= false;
		
		if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
		
		$sql = "SELECT
		o.strOrderNo,
		o.strStyle,
		(
			SELECT
				intSRNO
			FROM
				specification
			WHERE
				specification.intStyleId = st.intStyleId
		) AS ScNo,
		mil.strItemDescription,
		st.intMatDetailId,
		st.strColor,
		st.strSize,
		st.intStyleId,
		Sum(st.stockQty) AS stockQty,
		(
			SELECT
				sum(temp.tempQty)
			FROM
				tempstock_view temp
			INNER JOIN matitemlist mil ON mil.intItemSerial = temp.intMatDetailId
			INNER JOIN orders o ON o.intStyleId = temp.intStyleId
			WHERE
				st.intMatDetailId = temp.intMatDetailId
			AND st.strColor = temp.strColor
			AND st.strSize = temp.strSize
			AND st.intStyleId = temp.intStyleId
			AND mil.intMainCatID = '$mainId'
			AND mil.intSubCatID = '$subId'
			AND o.intOrderType = '1'
		) AS tempQty,
		(
			SELECT
				sum(sl.leftoverStock)
			FROM
				leftstock_view sl
			INNER JOIN matitemlist mil ON mil.intItemSerial = sl.intMatDetailId
			INNER JOIN orders o ON o.intStyleId = sl.intStyleId
			WHERE
				st.intMatDetailId = sl.intMatDetailId
			AND st.strColor = sl.strColor
			AND st.strSize = sl.strSize
			AND st.intStyleId = sl.intStyleId
			AND mil.intMainCatID = '$mainId'
			AND mil.intSubCatID = '$subId'
			AND o.intOrderType = '$OrderType'
		) AS leftoverQty,
		materialratio.materialRatioID
	FROM
		stock_view AS st
	INNER JOIN matitemlist AS mil ON mil.intItemSerial = st.intMatDetailId
	INNER JOIN orders AS o ON o.intStyleId = st.intStyleId
	INNER JOIN materialratio ON o.intStyleId = materialratio.intStyleId
	AND mil.intItemSerial = materialratio.strMatDetailID
	AND st.strColor = materialratio.strColor
	AND st.strSize = materialratio.strSize
	WHERE
		st.strMainStoresID > 0
	AND mil.intMainCatID = '$mainId'
	AND mil.intSubCatID = '$subId'
	AND o.intOrderType = '$OrderType'
	GROUP BY
		strOrderNo,
		strItemDescription ";
//echo $sql;
$preStyleId = '';
			$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$currStyleId = $row["intStyleId"];
                        
                        
                 
			//$stockQty = round($row["stockQty"],2);
                      //  print_r($stock);
                        
                        $stock = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
			$stockQty = $stock['qty']; 
                        
                        $temp = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
                        
                        $tempQty = $temp['qty']; 
                        
                        $leftover = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId); 
			$leftoverQty = $leftover['qty']; 
						
			$stockValue =0;
			$tempValue =0;
			$leftoverValue =0;
						
			if($stockQty>0)
                            
                            $stockValue = $stock['value']; 
				//$stockValue = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
			if($tempQty>0)	
                           $tempValue =   $temp['value'];
				//$tempValue = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
			if($leftoverQty>0)
                            
                            $leftoverValue = $leftover['value'];
				//$leftoverValue = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
					
			$totStockQty += $stockQty;
			$totTempQty += $tempQty;
			$totLeftQty += $leftoverQty;
			
			$totStockValue += $stockValue;
			$totTempValue += $tempValue;
			$totLeftValue += $leftoverValue;
			
			switch($x)
			{
				case 'all':
				{
					$totQty = $stockQty + $tempQty + $leftoverQty;
					$totValue = $stockValue + $tempValue;
					if($withLeftVal=='true') 
						$totValue += $leftoverValue;
					break;
				}
				case 'running':
				{
					$totQty = $stockQty + $tempQty;
					$totValue = $stockValue + $tempValue; 
					break;
				}
				case 'leftOvers':
				{
					$totQty = $leftoverQty;
					$totValue = $leftoverValue;	
					break;
				}
				
			}	
			
			
			
			$grandTotQty += $totQty;
			$grandTotValue += $totValue;
			
			if($totQty ==0 && $with0=='false')
				continue;
				
			//$strUrl  = "stockItemValueReport.php?StyleID=".$currStyleId.'&x='.$x.'&MatDetailID='.$row["intMatDetailId"].'&color='.urlencode($row["strColor"]).'&size='.urlencode($row["strSize"]).'&mainStores='.$mainStores.'&withLeftVal='.$withLeftVal;
			$strUrl = "qtyDetail.php?tbl=stocktransactions&matId=". $row['intMatDetailId'] ."&fromVal=120&toVal=120&mainStores=" . $mainStores . "&color=" .$color . "&size= ".$size;
			//echo $x;
			
			if($preStyleId != $currStyleId && $preStyleId!='')
			{
			?>
            <tr bgcolor="#FFFFFF">
          <td height="20" colspan="4" nowrap="nowrap" class="normalfnt"><span class="normalfntSMB">&nbsp;</span></td>
	
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockQty == 0?'&nbsp;':number_format($totStyleStockQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockValue == 0?'&nbsp;':number_format($totStyleStockValue,4));		 ?></strong></td>
          
           
          
     <td class='normalfnt' colspan="<?php echo $numRows; ?>">&nbsp;</td>	
          
          
          
          
          
         
         <?php
		  if($x == 'all')
		  {
		  ?>
          
          <?php if($withLeftVal=='true') {?>
         
          
		  <?php
		  	}
		  }
		  ?>
        
        
        </tr><?php
		$totStyleStockQty =0;
			$totStyleTempQty =0;
			$totStyleLeftQty =0;
			
			$totStyleStockValue =0;
			$totStyleTempValue =0;
			$totStyleLeftValue =0;
			
			$styleTotQty=0;
			$stylTotValue =0;
		
		 }?>
          
			<tr bgcolor="#FFFFFF">
			  <td class="normalfnt" nowrap="nowrap"><?php echo $row["materialRatioID"];?></td>
			
		
			<td height="20" class="normalfnt" nowrap="nowrap"><a href="<?php echo $strUrl; ?>" target="_blank"><?php echo $row["strItemDescription"]; ?></a></td>
			<td class="normalfnt"><?php echo $row["strColor"]; ?></td>
			<td class="normalfnt"><?php  echo $row["strSize"]; ?></td>
			<td class="normalfntRite"><?php  echo ($stockQty == 0?'&nbsp;':number_format($stockQty,2)); ?></td>
			<td class="normalfntRite">
			<?php echo ($stockValue == 0?'&nbsp;':number_format($stockValue,4));  ?>
			</td>
                        
                            <?php

		  $sqlCC = "SELECT
CC.strMainID,
CC.strName
FROM
mainstores AS CC ";
		  if($mainStores !='')
		  $sqlCC .= " WHERE CC.strMainID IN ($mainStores)";
		  //echo $sqlCC;
		  		$resultCC = $db->RunQuery($sqlCC);
			while($rowCC = mysql_fetch_array($resultCC)){
                            
                         $stock = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$rowCC['strMainID'],$subId);
			$stockQty = $stock['qty']; 
                        
                        $temp = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$rowCC['strMainID'],$subId);
                        
                        $tempQty = $temp['qty']; 
                        
                        $leftover = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$rowCC['strMainID'],$subId); 
			$leftoverQty = $leftover['qty'];          
                            
                        $totMainQty =  $stockQty+  $tempQty + $leftoverQty; 
			           $totMainQty = number_format($totMainQty,2);
			//echo "  <th width='8%' >".$rowCC['strName']."</th>";
                        echo "<td class='normalfnt'>".$totMainQty."</td>";
			}
		  
		  ?>                       
                        
            		
                    	
            
			<?php 
			if($x == 'all' || $x == "leftOvers")
			{
			
			?>
			
            <?php if($withLeftVal=='true') {?>
			
          <?php 
		  		}
		  }
		  ?>
       
         
        </tr>
		
            <?php
			
			
			
			?>
             
			<?php
			//}//
			$preStyleId=$currStyleId;
			
			/*  order no wise totals*/
			$totStyleStockQty += $stockQty;
			$totStyleTempQty += $tempQty;
			$totStyleLeftQty += $leftoverQty;
			
			$totStyleStockValue += $stockValue;
			$totStyleTempValue += $tempValue;
			$totStyleLeftValue += $leftoverValue;
			
			switch($x)
			{
				case 'all':
				{
					$styleTotQty += $stockQty + $tempQty + $leftoverQty;  
					$stylTotValue += $stockValue + $tempValue;
					if($withLeftVal=='true') 
						$stylTotValue += $leftoverValue;		
					break;
				}
				case 'running':
				{
					$styleTotQty += $stockQty + $tempQty;  
					$stylTotValue += $stockValue + $tempValue;	
					break;
				}
				case 'leftOvers':
				{
					$styleTotQty += $leftoverQty;  
					$stylTotValue += $leftoverValue;	
					break;
				}
				
			}	
			/*  order no wise totals*/
			
		}
		?>
		  <tr bgcolor="#FFFFFF">
          <td height="20" colspan="2" nowrap="nowrap" class="normalfnt">&nbsp;</td>
		  <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockQty == 0?'&nbsp;':number_format($totStyleStockQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockValue == 0?'&nbsp;':number_format($totStyleStockValue,4));		 ?></strong></td>
          
         <td class='normalfnt' colspan="<?php echo $numRows; ?>"></td>
           
          
          
          
       
         <?php
		  if($x == 'all')
		  {
		  ?>
         
          <?php if($withLeftVal=='true') {?>
         
		  <?php
		  		}
		  }
		  ?>
          
        
        </tr>   
           
        <tr bgcolor="#EBEBEB">
         <td height="20" class="normalfnt" colspan="4" ><b>&nbsp;&nbsp;&nbsp;&nbsp;Grand Total</b></td>
          <td class="normalfntRite">&nbsp;<b><?php echo ($totStockQty == 0?'&nbsp;':number_format($totStockQty,2)); ?></b>&nbsp;</td>
          
           <td class="normalfntRite">&nbsp;<b><?php echo ($totStockValue == 0?'&nbsp;':number_format($totStockValue,4));  ?></b>&nbsp;</td>
           
           
    
           
     <td class='normalfnt' colspan="<?php echo $numRows; ?>"></td>	      
          
        
           <?php 
		  	if($x == 'all')
			{
		  ?>
          
          <?php if($withLeftVal=='true') {?>
         
          <?php 
		    }
		  }
		  ?>
         
          
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($tbl,$matDetailID,$color,$size,$style,$mainStores,$subcategoryId)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where st.intMatDetailId ='$matDetailID'";
	if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty>0 ";
//echo $sql;
	}
	else
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize 
from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
 where st.intMatDetailId ='$matDetailID' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
		if($color != "")
		$sql .= " and st.strColor = '$color'";
		if($size != "")
		$sql .= " and st.strSize = '$size'";
 		$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";
	}	
	
	$result = $db->RunQuery($sql);
        $r = array();
	while($row = mysql_fetch_array($result))
	{
		$grnQty += $row["qty"];
		$grnValue += getGRNValue($row["qty"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$row["intStyleId"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
	}
        $r['qty'] = $grnQty;
         $r['value'] = $grnValue;
        
	return $r;
}

function getGRNValue($grnQty,$grnNo,$grnYear,$grnType,$styleID,$matdetailID,$color,$size)
{
	global $db;
	if($grnType == 'S')
	{
		$sql = " select distinct gd.dblInvoicePrice as grnprice,gh.dblExRate as exRate
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intGrnNo='$grnNo' and gh.intGRNYear='$grnYear' and gd.intMatDetailID='$matdetailID' 
  and gd.strColor ='$color' and  gd.strSize = '$size' ";
	}
	else if($grnType == 'B')
	{
		$sql = " select gd.dblRate as grnprice,gh.dblRate as exRate
from bulkgrnheader gh inner join bulkgrndetails gd on
gh.intBulkGrnNo = gd.intBulkGrnNo and gh.intYear = gd.intYear
where gh.intBulkGrnNo='$grnNo'  and gh.intYear='$grnYear' and intMatDetailID='$matdetailID' and gd.strColor='$color' and gd.strSize = '$size'";
	}
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	//echo $sql;
	$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	return $grnValue;
}
 ?>
</body>
</html>