<?php 
//include "../../../../Connector.php";

class ReportSummary
{
		
	function summary_string($obj1,$obj2)
	{
			global $db;
			$str_summary_dtl	="select $obj2,replace($obj2,' ','') as grpby from commercial_invoice_detail where strInvoiceNo='$obj1' group by grpby order by strBuyerPONo";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$first=0;
			while($row_summary_dtl	=mysql_fetch_array($result_summary_dtl))
			{
				if($first==0){
				$str.=$row_summary_dtl[$obj2];
				$first=1;
				}
				else 
				$str.="/ ".$row_summary_dtl[$obj2];
			}
			return $str;
	}	
	
	function summary_sum($obj1,$obj2)
	{
			global $db;
			$str_summary_dtl	="select sum($obj2) as totamt from commercial_invoice_detail where strInvoiceNo='$obj1' group by strInvoiceNo ";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$row_summary_dtl	=mysql_fetch_array($result_summary_dtl);
			$totamt=$row_summary_dtl['totamt'];
			return $totamt;
	}
	
	function roundup($sumQty,$div)
	{
			$dznsPre = ($sumQty%$div);
			$sumTot  = ($sumQty/$div);
			if($dznsPre!=0)
			return ((($sumQty-$dznsPre)/$div)+1)." DZNS";
			else
			return $sumTot." DZNS";	
	}

	function summary_string_concat($id,$col1,$col2,$grpby)
	{
			global $db;
			$str_summary_dtl	="select $col1,$col2,replace($grpby,' ','') as grpby from commercial_invoice_detail where strInvoiceNo='$id' group by grpby order by strBuyerPONo";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$first=0;
			while($row_summary_dtl	=mysql_fetch_array($result_summary_dtl))
			{
				if($first==0){
				$str.=$row_summary_dtl[$col1]." ".$row_summary_dtl[$col2];
				$first=1;
				}
				else 
				$str.="/ ".$row_summary_dtl[$col1]." ".$row_summary_dtl[$col2];
				
				
			}
			return $str;
	}	
		
		function summary_string_lbl($obj1,$obj2)
	{
			global $db;
			$str_summary_dtl	="select $obj2,replace($obj2,' ','') as grpby from commercial_invoice_detail where strInvoiceNo='$obj1' group by grpby order by strBuyerPONo";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$first=0;
			while($row_summary_dtl	=mysql_fetch_array($result_summary_dtl))
			{
				if($first==0){
				$str.=$row_summary_dtl[$obj2];
				$first=1;
				}
				else 
				$str.="<BR/>".$row_summary_dtl[$obj2];
			}
			return $str;
	}

}


$r_summary	= new ReportSummary();
//$str		=$r_summary->summary_string('strHSCode');
//echo $str;
?>