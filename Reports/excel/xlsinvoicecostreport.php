<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = '../../';
	$report_companyId = $_SESSION["FactoryID"];
	$styleId		= $_GET["orderNo"];
	$reportCat		= $_GET["ReportCat"];
	
	$deci			= 4;
	$deciT			= ($reportCat=='1'?2:4);
	$cVisibility	= ($reportCat=='1'?1:2);
	
	$titleid			= $_GET["titleid"];
	
	function xlsBOF() 
	{
    	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
   	    return;
	}
	function xlsEOF()
    {
   	    echo pack("ss", 0x0A, 0x00);
        return;
    }
	function xlsWriteNumber($Row, $Col, $Value)
    {
   	    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        echo pack("d", $Value);
        return;
    }
	function xlsWriteLabel($Row, $Col, $Value) 
	{
   	    $L = strlen($Value);
        echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
        echo $Value;
        return;
	}
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");    
	header ("Pragma: no-cache");    
	header ('Content-type: application/x-msexcel');
	header ("Content-Disposition: attachment; filename=Exportreport.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	
	xlsWriteLabel(1,0,"INVOICE COSTING REPORT");
	$sql_header="select C.strName,O.strStyle as pono,
	O.strOrderNo as style,strFabric,IH.dblNewCM,IH.dblFOB,
	IH.dblQty,IH.dblReduceCM,IH.strDescription
	from invoicecostingheader IH 
	inner join  orders O on IH.intStyleId=O.intStyleId
	inner join companies C on C.intCompanyID=O.intCompanyID
	where IH.intStyleId='$styleId'";
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
	$i=2;
		
		xlsWriteLabel($i,1,"Factory");
		xlsWriteLabel($i,2, $factoryName);
		
		xlsWriteLabel(++$i,1,"PO No "); 
		xlsWriteLabel($i,2,$style);
	
		xlsWriteLabel(++$i,1,"Style "); 
		xlsWriteLabel($i,2,$pono);
		
		xlsWriteLabel(++$i,1,"Fabric"); 
		xlsWriteLabel($i,2,$mainFabric);
		
		xlsWriteLabel(++$i,1,"CM"); 
		xlsWriteLabel($i,2,$cm);
		
		xlsWriteLabel(++$i,1,"Estimated FOB"); 
		xlsWriteLabel($i,2,$fob);
		
		xlsWriteLabel(++$i,1,"Order Qty"); 
		xlsWriteLabel($i,2,$qty);
		
		$i+=2;
		xlsWriteLabel($i,0,"No");
		xlsWriteLabel($i,1,"Item Description");
		xlsWriteLabel($i,4,"Consumption Per Doz");
		xlsWriteLabel($i,5,"Unit Price Per Pcs");
		xlsWriteLabel($i,6,"Wastage %");
		xlsWriteLabel($i,7,"Finance %");
		xlsWriteLabel($i,8,"Price Per Doz");
	
	$sql_1="select distinct IC.intCategoryId,IC.intCategoryName from invoicecostingcategory IC
inner join invoicecostingdetails ID on ID.strType=IC.intCategoryId
where IC.intStatus=1 and ID.intStyleId ='$styleId' and IC.intCategoryId in(1,2,3,4) order by IC.intOrderId";
$result_1=$db->RunQuery($sql_1);
while($row_1=mysql_fetch_array($result_1))
{
	$categoryId	= $row_1["intCategoryId"];
	$mainCategoryName = $row_1["intCategoryName"];
	$i+=2;
	xlsWriteLabel($i,1,$mainCategoryName);
	


	
	$sql_2="select distinct IP.intType
			from invoicecostingdetails ID
			inner join itempurchasetype IP on IP.intOriginNo=ID.intOrigin
			where ID.intStyleId='$styleId'
			and strType=$categoryId";		
	$result_2=$db->RunQuery($sql_2);
	
	while($row_2=mysql_fetch_array($result_2))
	{
		//$originType = $row_2["intOrigin"];
		if($categoryId!=1)
		{
			$categoryName = ($row_2["intType"]== 0 ? "Imported":"Local");
			xlsWriteLabel(++$i,1,$categoryName);
			
		}
		else
		{
			$categoryName ="";		
		}
	
		$totPricePerDoz = 0;
		$totConPc = 0;
		$totWastage = 0;
		$totFinancePercent = 0;
		
		$rw2_type=$row_2["intType"];
		$sql_3="select MIL.strItemDescription,reaConPc,ID.dblUnitPrice,ID.reaWastage,dblFinance
		from invoicecostingdetails ID 
		inner join matitemlist MIL on MIL.intItemSerial=ID.strItemCode
		inner join itempurchasetype IP on IP.intOriginNo=ID.intOrigin
		where ID.intStyleId='$styleId'
		and ID.strType='$categoryId'
		and IP.intType='$rw2_type'
		order by MIL.strItemDescription";
		//echo $sql_3;
		$result_3=$db->RunQuery($sql_3);
		while($row_3=mysql_fetch_array($result_3))
			{
				$itemDescription 	= $row_3["strItemDescription"];
				$conPc 				= round($row_3["reaConPc"],$deci);
				$unitPrice 			= round($row_3["dblUnitPrice"],$deci);
				$wastage			= round($row_3["reaWastage"],$deci);
				$dblFinance 		= round($row_3["dblFinance"],$deci);
				//$pricePerDoz		= round(($conPc * $unitPrice),$deciT);
				$pricePerDoz		= Calculate($conPc,$unitPrice,$deciT,$reportCat);
				$visible = "style=\"visibility:hidden\"";
				if($categoryId==1 || $categoryId==2)				
				{
					$visible = "style='visibility:visible'";
				}
				else
				{
					$visible = $cVisibility;
				}
				
				xlsWriteLabel(++$i,0,++$loop);
				xlsWriteLabel($i,1,$itemDescription);
				xlsWriteLabel($i,4,number_format($conPc,$deci));
				xlsWriteLabel($i,5,number_format($unitPrice,$deci));
				xlsWriteLabel($i,6,round($wastage,$deci));
				xlsWriteLabel($i,7,round($dblFinance,$deci));
				xlsWriteLabel($i,8,number_format($pricePerDoz,$deciT));
				
				$totPricePerDoz 	+= $pricePerDoz;
				$totConPc 			+= round($conPc,$deci);
				$totWastage 		+= round(($pricePerDoz * $wastage)/100,$deci);
				$totFinancePercent 	+= round(($pricePerDoz * $dblFinance)/100,$deci);
				$grandTotal 		+= round($totPricePerDoz+$totWastage+$totFinancePercent,$deci);
			}
		if($categoryId==1 || $categoryId==2)
		{		
			$mainCategoryName1 	= "Fabric";
			for($J=0;$J<=4;$J++) 
			{
				switch ($J)
				{
					case 0:
						$A = "Total $mainCategoryName1 Value";
						$B = $totPricePerDoz;
						$totPricePerDoz = 0;
						break;
					case 1:
						$A	= "$mainCategoryName1 Consumption";
						$B = $totConPc;
						$totConPc = 0;
						break;
					case 2:
						$A = "$mainCategoryName1 Wastage";
						$B = $totWastage;
						$totWastage = 0;
						break;
					case 3:
						$A = "$mainCategoryName1 Finance";
						$B = $totFinancePercent;
						$totFinancePercent = 0;
						break;
					case 4:
						$A = "Total $mainCategoryName1 Cost";
						$B = $grandTotal;
						$grandTotal = 0;
						$totalPoFob += $B;
						break;
				}
				
				xlsWriteLabel(++$i,1,$A);
				xlsWriteLabel($i,8,number_format($B,$deciT));
				
			}
		}
		else
		{
				for($j=0;$j<=3;$j++) 
				{
					switch ($j) 
					{
						case 0:
							$A = "Total $categoryName $mainCategoryName Value";
							$B = $totPricePerDoz;
							//$totPricePerDoz = 0;
							break;
						//case 1:
							//$A	= "$categoryName $mainCategoryName Consumption";
							//$B = $totConPc;
							//$totConPc = 0;
							break;
						case 1:
							$A = "$categoryName $mainCategoryName Wastage";
							$B = $totWastage;
							//$totWastage = 0;
							break;
						case 2:
							$A = "$categoryName $mainCategoryName Finance";
							$B = $totFinancePercent;
							//$totFinancePercent = 0;
							break;
						case 3:
							$A = "$categoryName $mainCategoryName Total";
							$B = round($totPricePerDoz+$totWastage+$totFinancePercent,$deciT);
							$grandTotal = 0;
							$totalPoFob += $B;
							break;
					}
			
				xlsWriteLabel(++$i,1,$A);
				xlsWriteLabel($i,8,number_format($B,$deciT));		
				$B = 0;				
			}
			
			
		}
	}
}

$booOtherAvailable = false;
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
		$itemDescription 	= $fields3["strItemDescription"];
		$o_conPc 			= round($fields3["reaConPc"],$deci);
		$o_unitPrice 		= round($fields3["dblUnitPrice"],$deci);
		$o_wastage			= round($fields3["reaWastage"],$deci);
		$o_dblFinance 		= round($fields3["dblFinance"],$deci);
		//$o_pricePerDoz	= round(($o_conPc * $o_unitPrice),$deci);
		$o_pricePerDoz		= Calculate($o_conPc,$o_unitPrice,$deciT,$reportCat);
		$booOtherAvailable 	= true;
	
		$o_totPricePerDoz 	+= $o_pricePerDoz;
		$o_totWastage 		+= ($o_pricePerDoz * $o_wastage)/100;
		$o_totFinance 		+= ($o_pricePerDoz * $o_dblFinance)/100;
		
    if($flg_newdocyn1 == "y")
    {
		if($flg_firstyn1  == "n")
	 	{	  
			
			xlsWriteLabel(++$i,8,number_format($te_totsubPriceperDoz3,$deciT));		
			
	  		$te_totsubPriceperDoz3 = 0;
     	}	    
    } 
	 $te_totsubPriceperDoz3 += $pricePerDoz3;
		
		xlsWriteLabel(++$i,0,++$loop);	
		xlsWriteLabel($i,1,$itemDescription);	
		xlsWriteLabel($i,4,number_format($o_conPc,$deci));	
		xlsWriteLabel($i,5,number_format($o_unitPrice,$deci));	
		xlsWriteLabel($i,6,$o_wastage);	
		xlsWriteLabel($i,7,$o_dblFinance);
		xlsWriteLabel($i,8,number_format($o_pricePerDoz,$deciT));
		$flg_firstyn1  = "n";
   		$jj++;
	}
	if($booOtherAvailable)
	{
		
			
		xlsWriteLabel(++$i,1,"Total");	
		xlsWriteLabel($i,8,number_format($o_totPricePerDoz,$deciT));
		
		
		
		
		xlsWriteLabel(++$i,1,"Wastage");			
		xlsWriteLabel($i,8,number_format($o_totWastage,$deciT));
		
		
		
		xlsWriteLabel(++$i,1,"Finance");			
		xlsWriteLabel($i,8,number_format($o_totFinance,$deciT));
		
			 

 }
	 $totalPoFob += $o_totPricePerDoz;
	 
	 	++$i;
		xlsWriteLabel(++$i,1,"PO FOB");	
		xlsWriteLabel($i,8,number_format($totalPoFob,$deciT));	
		
		
		
		
		xlsWriteLabel(++$i,1,"CM");			
		xlsWriteLabel($i,8,number_format($reduceCM,$deciT));	
		$totalCost	= round(round($totalPoFob,$deci) + round($reduceCM,$deci),$deci);
		
		xlsWriteLabel(++$i,1,"Total Cost");			
		xlsWriteLabel($i,8,number_format($totalCost,$deciT)); 
		
		$totalCostPerPiece = round($totalCost/12,$deci);
		xlsWriteLabel(++$i,1,"Total Cost per piece");			
		xlsWriteLabel($i,8,number_format($totalCostPerPiece,$deciT));
		
		xlsWriteLabel(++$i,1,"Remarks ");			
		xlsWriteLabel($i,2,$remarks);		
		

	xlsEOF();
	
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