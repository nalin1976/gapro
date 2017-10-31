<?php
 session_start();
 error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';
include "../../Connector.php";
//		get template

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | LC Document Uploader</title>
<style type="text/css">
<!--
.nobcg {	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function Continue()
{
	window.close();
}
</script>
</head>

<body>
<table width="429" border="0" cellpadding="1" cellspacing="0" class="bcgl1" align="center">
  <tr>
    <td height="31" colspan="4" class="mainHeading">Uploading Process</td>
  </tr>
  <tr>
    <td width="15" height="19">&nbsp;</td>
    <td colspan="3" class="normalfnt2bld">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="normalfnt"><?php

/*if ($_FILES["file"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/cws", 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"], 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"]."/fabInvoice", 0700);
  $filename = basename($_FILES['file']['name']);
  echo $filename.'</br>';
  	
  move_uploaded_file($_FILES["file"]["tmp_name"],"../../upload files/cws/".$_SESSION["styleId"].'/fabInvoice/'. $filename);
  }

if ($_FILES["filePoc"]["error"] > 0)
  {
 // echo "Error: " . $_FILES["fileQuat"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/cws", 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"], 0700);
  mkdir("../../upload files/cws/".$_SESSION["styleId"]."/pocInvoice", 0700);
  $filenameQ = basename($_FILES['filePoc']['name']);
  echo $filenameQ.'</br>';
  	
  move_uploaded_file($_FILES["filePoc"]["tmp_name"],"../../upload files/cws/".$_SESSION["styleId"].'/pocInvoice/'. $filenameQ);
  }*/
  
  if ($_FILES["fileBPO"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["fileBOQ"]["error"] . "<br />";
  }

else
  {
  mkdir("../../upload files", 0700);
  mkdir("../../upload files/lc", 0700);
  $filenameB = basename($_FILES['fileBPO']['name']);
  echo $filenameB.' uploaded successfully'.'</br>';
  	
  move_uploaded_file($_FILES["fileBPO"]["tmp_name"],"../../upload files/lc/". $filenameB);
  $file = "../../upload files/lc/".$filenameB;
 
	if (!file_exists($file)) {
	exit("Can't find $filenameB");
	}
//$objPHPExcel = PHPExcel_IOFactory::load($file);
	$Reader = PHPExcel_IOFactory::createReaderForFile($file);
	$Reader->setReadDataOnly(true); 
	$objXLS = $Reader->load($file);
	$supplier = $objXLS->getSheet(0)->getCell('B2')->getValue();
	$wrkIterator = $objXLS->getWorksheetIterator();

	foreach ($objXLS->getWorksheetIterator() as $sheet) {
		// for all cells
			$i=5;
		foreach ($sheet->getCellCollection(false) as $cell) {
			$xfIndex = $cell->getXfIndex();
			$cellId = 'A'.$i;
			$facName = $objXLS->getSheet(0)->getCell($cellId)->getValue();
			$fac = settype($facName, 'string');
			
			$cellIdB = 'B'.$i;
			$orderNo = (string)$objXLS->getSheet(0)->getCell($cellIdB)->getValue();
			
			$cellIdC = 'C'.$i;
			$piNo = $objXLS->getSheet(0)->getCell($cellIdC)->getValue();
			
			$cellIdD = 'D'.$i;
			$oritRef = $objXLS->getSheet(0)->getCell($cellIdD)->getValue();
			
			$cellIdE = 'E'.$i;
			$supPIno = $objXLS->getSheet(0)->getCell($cellIdE)->getValue();
			
			$cellIdF = 'F'.$i;
			$DDNno = $objXLS->getSheet(0)->getCell($cellIdF)->getValue();
			
			$cellIdG = 'G'.$i;
			$shipMode = $objXLS->getSheet(0)->getCell($cellIdG)->getValue();
			
			$cellIdH = 'H'.$i;
			$itemCode = $objXLS->getSheet(0)->getCell($cellIdH)->getValue();
			
			$cellIdI = 'I'.$i;
			$color = $objXLS->getSheet(0)->getCell($cellIdI)->getValue();
			
			$cellIdJ = 'J'.$i;
			$size = $objXLS->getSheet(0)->getCell($cellIdJ)->getValue();
			
			$cellIdK = 'K'.$i;
			$qty = $objXLS->getSheet(0)->getCell($cellIdK)->getValue();
			
			$cellIdL = 'L'.$i;
			$amount = $objXLS->getSheet(0)->getCell($cellIdL)->getValue();
			
			$cellIdM = 'M'.$i;
			$GW = $objXLS->getSheet(0)->getCell($cellIdM)->getValue();
			
			$cellIdN = 'N'.$i;
			$CM = $objXLS->getSheet(0)->getCell($cellIdN)->getValue();
			
			$cellIdO = 'O'.$i;
			$payment = $objXLS->getSheet(0)->getCell($cellIdO)->getValue();
			
			$cellIdP = 'P'.$i;
			$handleBy = $objXLS->getSheet(0)->getCell($cellIdP)->getValue();
			
			$cellIdC = 'Q'.$i;
			$readyDate = $objXLS->getSheet(0)->getCell($cellIdC)->getValue();
			
			$cellIdC = 'R'.$i;
			$confirmDate = $objXLS->getSheet(0)->getCell($cellIdC)->getValue();
			
			$cellIdC = 'S'.$i;
			$handDate = $objXLS->getSheet(0)->getCell($cellIdC)->getValue();
			
			$cellIdC = 'T'.$i;
			$remarks = $objXLS->getSheet(0)->getCell($cellIdC)->getValue();
				
				if($orderNo != '')
				{
					$qty = ($qty == ''?'Null':$qty);
					$amount = ($amount == ''?'Null':$amount);
					$CM = ($CM == ''?'Null':$CM);
					
					$sql = " insert into lc_supplierdetails (strfactory, strOrderNo, strPINo,strOritRefNo, strSupplierPINo, strDNNo, strShipMode, strItemCode, strColor,strSize,dblQty,dblAmount,strGW,dblCM,strPayment, strHandleBy,dtmReadyDate,dtmPIConfirmDate,dtmHandoverDate,strRemarks,supplier)
 values ('$fac','$orderNo','$piNo','$oritRef','$supPIno','$DDNno', '$shipMode','$itemCode','$color','$size',$qty, $amount,'$GW',$CM,'$payment','$handleBy','$readyDate','$confirmDate','$handDate','$remarks','$supplier') ";
					$results=$db->RunQuery($sql);
				}
			$i++;	
		}
	}
		
	$objXLS->disconnectWorksheets();
			
	unset($objXLS);
  }
  
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="177">&nbsp;</td>
    <td width="161">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
      <tr>
        <td align="right"><img src="../../images/continue.png" width="116" height="24" alt="continue" onclick="Continue();" /></td>
      </tr>
    </table></td>
  </tr>
 
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
