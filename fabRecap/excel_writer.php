<?php
require_once('../Connector.php');
$request=$_GET['req'];
if($request=="writeExcel")
{
 $arrFieldNames=array('Style Name','PO date','PO#','Div','Style #','Color Code','Dim','Orig PO Qty','Rvsd PO Qty','Mill','Fabric Ref#','Fabrication','Price','Width','Shrinkage','Fiber Content','MM YY','ORIT MM','Est Reqd Ydge','PI#','PI Qty','Inv#','Inv Qty','Rcvd to Cut','Fab Act ETA','EPLAN #','Fabric req. date','Fab Tgt ETA','YY Po qty','PO ETD','IN LINE','FTY','ALLOCATED YDS FOR CUTTING DEPT','Shrinkage','Used Ydge','Bal Ydge','','Comments','WEERAKOON\'S ACT YY (with out 3%)','Act Shrinkage','Act Width','ACT YY PER CUT QTY','ALLOCATED CUT QTY DZN','FINAL CUT QTY DZN','FTY RCVD','Act Used Ydge','rvsd cut qty %','Comments','proft/loss on fab value','PO SIGN DATE','sh.re tgt date','rcvd date','difference','CUTTING YY','CUTTIN USED YDGE','VARIANCE','EPLAN QTY','VARIANCE','ACT.EFF');

$arrTblRows=array("strDescription","dtmDate","strStyle","strDivision","strOrderNo","strColorCode","dblDimension","intQty","intQty","strSupplierID",				"strFabricRefNo","strFabrication");

	include("excelwriter.inc.php");
	$fileName=date("Y-M-D").".xls";
	$excel=new ExcelWriter($fileName);//put ur file name here
	
	if($excel==false)	
		echo $excel->error;
	$excel->writeLine($arrFieldNames);
	$sql_q="SELECT 			
					o.strDescription,
					o.dtmDate,
					o.strStyle,
					bd.strDivision,
					o.strOrderNo,
					o.strColorCode,
					o.dblDimension,
					o.intQty,
					o.intQty,
					o.strSupplierID,
					o.strFabricRefNo,
					o.strFabrication
					FROM orders o
					INNER JOIN buyerDivisions bd ON bd.intDivisionId=o.intDivisionId;";
					$res=$db->RunQuery($sql_q);
					$count=0;
					while($row=mysql_fetch_array($res))
					{
						$excel->writeRow();
						for($i=0;$i<count($arrTblRows);$i++){
							$col=$arrTblRows[$i];
							$excel->writeCol($row[$col],$count);
						}
						$count++;
					}
					/*$excel->writeAnywhere(20,12);
					$excel->writeCol("sada",1);*/
	$excel->close();
	echo "Data is write into $fileName Successfully.";
	}
?>