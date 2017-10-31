<?php
session_start();
include "../../Connector.php";
$backwardseperator = '../../';
$report_companyId = $_SESSION["FactoryID"];
$styleId		= $_GET["orderNo"];
$reportCat		= $_GET["ReportCat"];

$deci			= 4;
$deciT			= ($reportCat=='1'?2:4);
$cVisibility	= ($reportCat=='1'?"style='visibility:hidden'":"style='visibility:visible'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Invoice Costing Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>

<blockquote>
  <form id="invoiceCostingReport" name="invoiceCostingReport" action="" >
    <table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><?php include "../../reportHeader.php"?></td>
      </tr>
<?PHP
$sql_header="select C.strName,O.strStyle as pono,O.strOrderNo as style,strFabric,IH.dblNewCM,IH.dblFOB,IH.dblQty,IH.dblReduceCM,IH.strDescription
from invoicecostingheader IH 
inner join  orders O on IH.intStyleId=O.intStyleId
inner join companies C on C.intCompanyID=O.intCompanyID
where IH.intStyleId='$styleId'";
//echo $sql_header;
$result_header=$db->RunQuery($sql_header);
while($row_header=mysql_fetch_array($result_header))
{
	$factoryName 	= $row_header["strName"];
	$pono 			= $row_header["pono"];
	$style 			= $row_header["style"];
	$mainFabric 	= $row_header["strFabric"];
	$cm 			= $row_header["dblNewCM"];
	$fob 			= $row_header["dblFOB"];
	$qty 			= $row_header["dblQty"];
	$reduceCM		= $row_header["dblNewCM"]*12;
	$remarks		= $row_header["strDescription"];		
}
?>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" rules="groups">
            <tr>
              <td width="15">&nbsp;</td>
              <td width="127" class="bcgl1txt1NB">Factory</td>
              <td width="8"><b>:</b></td>
              <td width="790" class="normalfnt">&nbsp;<?php echo $factoryName;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">PO No</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $style;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Style</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $pono;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Fabric</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $mainFabric;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">CM</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $cm;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Final FOB</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $fob;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="bcgl1txt1NB">Order Qty</td>
              <td><b>:</b></td>
              <td class="normalfnt">&nbsp;<?php echo $qty;?></td>
            </tr>
          </table></td>
      </tr>
	  <tr>
	  	<td height="1">&nbsp;</td>
	  </tr>
	  <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="2" rules="all">
		<thead>
		  <tr>
			<td width="2%" bgcolor="#CCCCCC" class="bcgl1txt1B">No</td>
			<td width="58%" bgcolor="#CCCCCC" class="bcgl1txt1B">Item Description</td>
			<td width="9%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Consumption<br />Per Doz</td>
			<td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price<br />Per Pcs</td>
			<td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B">Wastage<br/>%</td>
			<td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B">Finance<br/>%</td>
		    <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B">Price<br/>
		      Per Doz</td>
		  </tr>
		  </thead>

<?php
$sql = "SELECT matitemlist.strItemDescription,invoicecostingdetails.reaConPc,invoicecostingdetails.dblUnitPrice,invoicecostingdetails.reaWastage,invoicecostingdetails.dblFinance,itempurchasetype.strOriginType,invoicecostingcategory.intCategoryId,invoicecostingcategory.intCategoryName
    FROM invoicecostingdetails 
    INNER JOIN invoicecostingcategory ON invoicecostingdetails.strType=invoicecostingcategory.intCategoryId
	INNER JOIN matitemlist ON invoicecostingdetails.strItemCode= matitemlist.intItemSerial
	INNER JOIN itempurchasetype ON invoicecostingdetails.intOrigin = itempurchasetype.intOriginNo	
	WHERE invoicecostingdetails.intStyleId='$styleId' AND invoicecostingdetails.strType='1'
	 ORDER BY invoicecostingcategory.intCategoryName";    
  //echo"$sql<br>"; 
  $result = $db->RunQuery($sql);
  
  if(mysql_num_rows($result))
  {
   $j = 1;
   while($fields = mysql_fetch_array($result, MYSQL_BOTH)) 
   { 
    $intCategoryId  	= $fields['intCategoryId'];
    $intCategoryName    = $fields['intCategoryName'];
	$itemDescription 	= $fields["strItemDescription"];
	$conPc 				= $fields["reaConPc"];
	$unitPrice 			= $fields["dblUnitPrice"];
	$wastage			= $fields["reaWastage"];
	$dblFinance 		= $fields["dblFinance"];
	//$pricePerDoz		= ($conPc * $unitPrice);
	
	$pricePerDoz		= Calculate($conPc,$unitPrice,$deciT,$reportCat);
	
	$totPricePerDoz += round($pricePerDoz,$deci);
	$totConPc += round($conPc,$deci);
	$totWastage += round((round($pricePerDoz,$deci)*round($wastage,$deci))/100,$deci);
	$totFinancePercent += round((round($pricePerDoz,$deci)*round($dblFinance,$deci))/100,$deci);
	$grandTotal		+= $totPricePerDoz+$totWastage+$totFinancePercent;
	$totalPoFob	+= $grandTotal;
    echo "<tr >";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnth2'><b>$intCategoryName</td>";
	echo "<td></td>";
	echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "</tr>"; 
	
    echo "<tr align='center'>";
    echo "<td class='normalfntMid'>$j</td>";
	echo "<td class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;$itemDescription&nbsp;</td>";
    echo "<td class='normalfntRite'>".number_format($conPc,4)."&nbsp;</td>";
    echo "<td class='normalfntRite'>".number_format($unitPrice,4)."&nbsp;</td>";
	echo "<td class='normalfntRite'>$wastage &nbsp;</td>";
	echo "<td class='normalfntRite'>$dblFinance &nbsp;</td>";
	echo "<td class='normalfntRite'>".number_format($pricePerDoz,$deciT)."&nbsp;</td>";
    echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Fabric Value</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totPricePerDoz,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Fabric Consumption</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totConPc,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
    echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Fabric Wastage</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totWastage,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Fabric Finance</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totFinancePercent,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Fabric Cost</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($grandTotal,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	$j++;  
	}//end fabric while
	
	$sql2 = "SELECT matitemlist.strItemDescription,invoicecostingdetails.reaConPc,invoicecostingdetails.dblUnitPrice,invoicecostingdetails.reaWastage,invoicecostingdetails.dblFinance,itempurchasetype.strOriginType,invoicecostingcategory.intCategoryId,invoicecostingcategory.intCategoryName,itempurchasetype.intType
    FROM invoicecostingdetails 
    INNER JOIN invoicecostingcategory ON invoicecostingdetails.strType=invoicecostingcategory.intCategoryId
	INNER JOIN matitemlist ON invoicecostingdetails.strItemCode= matitemlist.intItemSerial
	INNER JOIN itempurchasetype ON invoicecostingdetails.intOrigin = itempurchasetype.intOriginNo	
	 WHERE invoicecostingdetails.intStyleId='$styleId' AND invoicecostingdetails.strType IN(2,3) 
	 ORDER BY itempurchasetype.strOriginType,invoicecostingcategory.intCategoryId,matitemlist.strItemDescription ";    
  //echo"$sql2<br>"; 
  $result2 = $db->RunQuery($sql2);

   $flg_newdocyn = "";
   $flg_firstyn  = "";
   $te_docmain   = ""; 
   $te_totsubPriceperDoz = 0;
     echo "<tr>";
 	 echo "<td></td>";
     echo "<td class='normalfnth2'><b>Trims</td>";
	 echo "<td></td>";
     echo "<td></td>";
	 echo "<td></td>";
	 echo "<td></td>";
     echo "</tr>"; 
   $TotPricePerDozTrims=0;	 
   $jj=0;
   while($fields2 = mysql_fetch_array($result2, MYSQL_BOTH)) 
   { 
		$strOriginType     	= $fields2['strOriginType'];		
		$intCategoryId2     = $fields2['intCategoryId'];
		$intCategoryName2   = $fields2['intCategoryName'];
		$itemDescription2 	= $fields2["strItemDescription"];
		$conPc2 			= $fields2["reaConPc"];
		$unitPrice2 		= $fields2["dblUnitPrice"];
		$wastage2			= $fields2["reaWastage"];
		$dblFinance2 		= $fields2["dblFinance"];
		//$pricePerDoz2		= ($conPc2 * $unitPrice2);
		$pricePerDoz2		= Calculate($conPc2,$unitPrice2,$deciT,$reportCat);
    $TotPricePerDozTrims2+=$pricePerDoz2;
	
	$strOriginType = ($fields2["intType"]== 0 ? "Imported":"Local");
	
	$totPricePerDoz2 += round($pricePerDoz2,$deci);
	$totImportedTrimWastage +=  ($pricePerDoz2*$wastage2)/100;
	$totImportedTrimFinance +=  ($pricePerDoz2*$dblFinance2)/100;
	$totImportedTrimTotal = round(($totPricePerDoz2+$totImportedTrimWastage+$totImportedTrimFinance),$deci);
	
	
    if($te_docmain != $strOriginType)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $strOriginType;
	

    if($flg_newdocyn == "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
      echo "<tr>";
	  echo "<td></td>";
	  echo "<td></td>";
	  echo "<td></td>";   
	  echo "<td></td>";
	  echo "<td></td>"; 
	  echo "<td></td>"; 
	  echo "<td class='normalfntRite'>".number_format($te_totsubPriceperDoz2,4)."&nbsp;</td>";     
      echo "</tr>";
	  $te_totsubPriceperDoz2 = 0;
     }	    
    } 
	 $te_totsubPriceperDoz2 += $pricePerDoz2;
	 
	 
    if($flg_newdocyn== "y")
    {
     echo "<tr>";
	 echo "<td></td>";
     echo "<td class='normalfntLeftRedSmall'>&nbsp;&nbsp;$strOriginType</td>";
	 echo "<td></td>";
     echo "<td></td>";
	 echo "<td></td>";
	 echo "<td></td>";
     echo "</tr>"; 
    }   
	
	echo "<tr align='center'>";
	echo "<td class='normalfntMid'>".($jj+$j)."</td>";
	echo "<td class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;$itemDescription2 &nbsp;</td>";
    echo "<td class='normalfntRite' $cVisibility>".number_format($conPc2,$deci)."&nbsp;</td>";
    echo "<td class='normalfntRite' $cVisibility>".number_format($unitPrice2,$deci)."&nbsp;</td>";
	echo "<td class='normalfntRite'>$wastage2 &nbsp;</td>";
	echo "<td class='normalfntRite'>$dblFinance2 &nbsp;</td>";
	echo "<td class='normalfntRite'>".number_format($pricePerDoz2,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
   $flg_firstyn  = "n";
   $jj++;
   }
   	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Imported Trim Value</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totPricePerDoz2,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Wastage</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totImportedTrimWastage,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
    echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Finance</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totImportedTrimFinance,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	
	echo "<tr align='center'>";
	echo "<td><font  style='font-size: 15px;'></font></td>";
	echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Total</td>";
    echo "<td></td>";
    echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td class='normalfntRite'><b>".number_format($totImportedTrimTotal,$deciT)."&nbsp;</td>";
	echo "</tr>"; 
	  $totalPoFob	+= $totImportedTrimTotal;
$booServiceAvailable = false;
$booServicesFirst	= false;
$sql3 = "SELECT matitemlist.strItemDescription,invoicecostingdetails.reaConPc,invoicecostingdetails.dblUnitPrice,invoicecostingdetails.reaWastage,invoicecostingdetails.dblFinance,itempurchasetype.strOriginType,invoicecostingcategory.intCategoryId,invoicecostingcategory.intCategoryName,itempurchasetype.intType
FROM invoicecostingdetails 
INNER JOIN invoicecostingcategory ON invoicecostingdetails.strType=invoicecostingcategory.intCategoryId
INNER JOIN matitemlist ON invoicecostingdetails.strItemCode= matitemlist.intItemSerial
INNER JOIN itempurchasetype ON invoicecostingdetails.intOrigin = itempurchasetype.intOriginNo	
WHERE invoicecostingdetails.intStyleId='$styleId' AND invoicecostingdetails.strType IN(4) 
ORDER BY itempurchasetype.strOriginType,matitemlist.strItemDescription";    
$result3 = $db->RunQuery($sql3);

   $flg_newdocyn1 = "";
   $flg_firstyn1  = "";
   $te_docmain1   = ""; 
   $te_totsubPriceperDoz3 = 0;
 
   $TotPricePerDozServices=0;	 
   $jjj=0;
   	while($fields3 = mysql_fetch_array($result3, MYSQL_BOTH)) 
   	{ 
		
		$strOriginType3     = $fields3['strOriginType'];	
		$intCategoryId3     = $fields3['intCategoryId'];
		$intCategoryName3   = $fields3['intCategoryName'];
		$itemDescription3 	= $fields3["strItemDescription"];
		$conPc3 			= $fields3["reaConPc"];
		$unitPrice3 		= $fields3["dblUnitPrice"];
		$wastage3			= $fields3["reaWastage"];
		$dblFinance3 		= $fields3["dblFinance"];
		//$pricePerDoz3		= ($conPc3 * $unitPrice3);
		$pricePerDoz3		= Calculate($conPc3,$unitPrice3,$deciT,$reportCat);
		$TotPricePerDozServices+=$pricePerDoz3;
		$booServiceAvailable = true;
		$strOriginType3 = ($fields3["intType"]== 0 ? "Imported":"Local");
	
		$totPricePerDoz3 				+= round($pricePerDoz3,$deci);
		$totImportedServicesWastage3 	+=  ($pricePerDoz3*$wastage3)/100;
		$totImportedServicesFinance3 	+=  ($pricePerDoz3*$dblFinance3)/100;
		$totImportedServicesTotal3 		= round(($totPricePerDoz3+$totImportedServicesWastage3+$totImportedServicesFinance3),$deci);
		//$totalPoFob	+= $totImportedServicesTotal3;
		if(!$booServicesFirst){
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt2'><b>Services</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>"; 
		}
	 $booServicesFirst	= true;
    if($te_docmain1 != $strOriginType3)
     $flg_newdocyn1 = "y";
    else
     $flg_newdocyn1 = "n";  

    $te_docmain1 = $strOriginType3;
	
    if($flg_newdocyn1 == "y")
    {
		if($flg_firstyn1  == "n")
	 	{	  
			echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";   
			echo "<td></td>";
			echo "<td></td>"; 
			echo "<td></td>"; 
			echo "<td class='normalfntRite'>".number_format($te_totsubPriceperDoz3,4)."&nbsp;</td>";     
			echo "</tr>";
	  		$te_totsubPriceperDoz3 = 0;
     	}	    
    } 
	 $te_totsubPriceperDoz3 += $pricePerDoz3;

	if($flg_newdocyn1== "y")
	{
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfntLeftRedSmall'>&nbsp;&nbsp;$strOriginType3</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>"; 
	}   
	
		echo "<tr align='center'>";
		echo "<td class='normalfntMid'>".($jjj+$jj+$j)."</td>";
		echo "<td class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;$itemDescription3 &nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($conPc3,$deci)."&nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($unitPrice3,$deci)."&nbsp;</td>";
		echo "<td class='normalfntRite'>$wastage3 &nbsp;</td>";
		echo "<td class='normalfntRite'>$dblFinance3 &nbsp;</td>";
		echo "<td class='normalfntRite'>".number_format($pricePerDoz3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
   		$flg_firstyn1  = "n";
   		$jj++;
	}
	if($booServiceAvailable)
	{
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Imported Trim Value</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totPricePerDoz3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Wastage</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totImportedServicesWastage3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Finance</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totImportedServicesFinance3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Imported Trim Total</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totImportedServicesTotal3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
	 }
	 $totalPoFob	+= $totImportedServicesTotal3;
//Start - 31-10-2010 - Load Other cost
$booOtherAvailable = false;
$totPricePerDoz3 				= 0;
$totImportedServicesWastage3 	= 0;
$totImportedServicesFinance3 	= 0;
$totImportedServicesTotal3 		= 0;

$sql3="(SELECT MIL.strItemDescription,ID.reaConPc,ID.dblUnitPrice,ID.reaWastage,ID.dblFinance
FROM invoicecostingdetails ID
INNER JOIN matitemlist MIL ON ID.strItemCode= MIL.intItemSerial
WHERE ID.intStyleId='$styleId' AND ID.strType IN(5))
union
(select WDP.strDescription,'1',dblUnitPrice,'0','0' 
from invoicecostingproceses IP 
inner join was_dryprocess WDP on WDP.intSerialNo=IP.intProcessId 
inner join invoicecostingheader IH on IH.intStyleId=IP.intStyleId where IH.intStyleId='$styleId')
order by strItemDescription";
$result3 = $db->RunQuery($sql3);

   $flg_newdocyn1 = "";
   $flg_firstyn1  = "";
   $te_docmain1   = ""; 
   $te_totsubPriceperDoz3 = 0;
 
   $TotPricePerDozServices=0;	 
   $jjj=0;
   	while($fields3 = mysql_fetch_array($result3, MYSQL_BOTH)) 
   	{ 
		$strOriginType3     = $fields3['strOriginType'];	
		$intCategoryId3     = $fields3['intCategoryId'];
		$intCategoryName3   = $fields3['intCategoryName'];
		$itemDescription3 	= $fields3["strItemDescription"];
		$conPc3 			= $fields3["reaConPc"];
		$unitPrice3 		= $fields3["dblUnitPrice"];
		$wastage3			= $fields3["reaWastage"];
		$dblFinance3 		= $fields3["dblFinance"];
		//$pricePerDoz3		= ($conPc3 * $unitPrice3);
		$pricePerDoz3		= Calculate($conPc3,$unitPrice3,$deciT,$reportCat);
		$TotPricePerDozServices+=$pricePerDoz3;
		$booOtherAvailable = true;
		$strOriginType3 = ($fields3["intType"]== 0 ? "Imported":"Local");
	
		$totPricePerDoz3 				+= round($pricePerDoz3,$deci);
		$totImportedServicesWastage3 	+=  ($pricePerDoz3*$wastage3)/100;
		$totImportedServicesFinance3 	+=  ($pricePerDoz3*$dblFinance3)/100;
		$totImportedServicesTotal3 		= round(($totPricePerDoz3+$totImportedServicesWastage3+$totImportedServicesFinance3),$deci);
		
    if($te_docmain1 != $strOriginType3)
     $flg_newdocyn1 = "y";
    else
     $flg_newdocyn1 = "n";  

    $te_docmain1 = $strOriginType3;
	
    if($flg_newdocyn1 == "y")
    {
		if($flg_firstyn1  == "n")
	 	{	  
			echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";   
			echo "<td></td>";
			echo "<td></td>"; 
			echo "<td></td>"; 
			echo "<td class='normalfntRite'>".number_format($te_totsubPriceperDoz3,4)."&nbsp;</td>";     
			echo "</tr>";
	  		$te_totsubPriceperDoz3 = 0;
     	}	    
    } 
	 $te_totsubPriceperDoz3 += $pricePerDoz3;
		echo "<tr align='center'>";
		echo "<td class='normalfntMid'>".($jjj+$jj+$j)."</td>";
		echo "<td class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;$itemDescription3 &nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($conPc3,4)."&nbsp;</td>";
		echo "<td class='normalfntRite' $cVisibility>".number_format($unitPrice3,4)."&nbsp;</td>";
		echo "<td class='normalfntRite'>$wastage3 &nbsp;</td>";
		echo "<td class='normalfntRite'>$dblFinance3 &nbsp;</td>";
		echo "<td class='normalfntRite'>".number_format($pricePerDoz3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
   		$flg_firstyn1  = "n";
   		$jj++;
	}
	if($booOtherAvailable)
	{
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totPricePerDoz3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Wastage</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totImportedServicesWastage3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr align='center'>";
		echo "<td><font  style='font-size: 15px;'></font></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Finance</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totImportedServicesFinance3,$deciT)."&nbsp;</td>";
		echo "</tr>"; 		
	 }
	 $totalPoFob	+= $totPricePerDoz3;
	//End - 31-10-2010 - Load other cost
}  
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'>&nbsp;</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>"; 
		
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;PO FOB</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalPoFob,$deciT)."</b>&nbsp;</td>";
		echo "</tr>"; 
		
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;CM</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($reduceCM,$deciT)."</b>&nbsp;</td>";
		echo "</tr>"; 
		$totalCost	= round(round($totalPoFob,$deci) + round($reduceCM,$deci),$deci);
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Cost</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalCost,$deciT)."</b>&nbsp;</td>";
		echo "</tr>";
		$totalCostPerPiece = round($totalCost/12,$deci);
		echo "<tr>";
		echo "<td></td>";
		echo "<td class='normalfnt'><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Cost per piece</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td class='normalfntRite'><b>".number_format($totalCostPerPiece,$deciT)."</b>&nbsp;</td>";
		echo "</tr>";
		?>

		  <tr>
			<td>&nbsp;</td>
			<td colspan="6" class='normalfnt'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Remarks :- </b><?php echo $remarks;?></td>
			</tr>
		</table>
		</td>
      </tr>
    </table>
  </form>
</blockquote>
</body>
</html>
<?php
function Calculate($conPc,$unitPrice,$deciT,$reportCat)
{
	if($reportCat=='1')
	{
		$value = $conPc * $unitPrice;
		return round_up($value,$deciT);
		//echo
	}
	else
	{
		return round(($conPc * $unitPrice),$deciT);
	}
}

function round_up($value,$precision)
{
	$pow = pow( 10, $precision );
    return (ceil($pow*$value)+ceil($pow*$value-ceil($pow*$value)))/$pow;
} 
?>