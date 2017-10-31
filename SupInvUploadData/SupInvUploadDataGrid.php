<?php
// Test CVS
 session_start();
 $backwardseperator = "../";
 $filepath	    = $_POST['filepath2'];
 $cboSupplier	= $_POST['cboSupplier'];
	
		
		mkdir("../SupInvUploadExcel");
		mkdir("../SupInvUploadExcel/".$filepath,0777);
		mkdir("../SupInvUploadExcel/".$filepath."/xls",0777);
	
		$target  = "../SupInvUploadExcel/".$filepath."/xls/";
		$name    = explode('.',$_FILES['filepath2']['name']);
		
		
		move_uploaded_file($_FILES['filepath2']['tmp_name'], $target.$name[0].".".$name[1]);

require_once 'Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('CP1251');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/



/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read("../SupInvUploadExcel/xls/$name[0].$name[1]");



/*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);
	include "../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload Supplier Invoice</title>
</head>

<body onload="grid_fix_header();">
<form id="" name="">
<table width="100%" border="0" align="center" >
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>



<div align="center">
<table width="805px">
  <tr>
    <td class="mainHeading2">Upload Supplier Invoice</td>
  </tr>
</table>
<table width="100%" bgcolor="#FAD163" border="0" cellpadding="0" cellspacing="1" class="tableBorder" id="tblMain" align="center">
<thead>
<tr class='mainHeading4' style="height:25px">
<th>PO No</th>
<th>&nbsp;</th>
<th>Date</th>
<th>Invoice No</th>
<th>Amount</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
$pos = 0;

for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
echo "<tr class='bcgcolor-tblrowWhite'>";

			
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
	$cellValue =  $data->sheets[0]['cells'][$i][1];
	//echo $cellValue[0];
	if($cellValue[0] == "G"){ 
	echo "<td class='normalfnt'>";
		echo $data->sheets[0]['cells'][$i][$j];
	echo "</td>";
	 }else{
	echo "<td  style='	font-family: Verdana;font-size: 1px;color: #000000;margin: 0px;font-weight: normal;text-align:left;visibility:hidden;'>";
		echo 'a';
	echo "</td>";
	 }
	}
	
echo "</tr>";
}

//print_r($data);
//print_r($data->formatRecords);
?>
</tbody>
</table>
</div>

<div>
 <table width="805px" class="tableBorder" align="center">
  <tr><td align="center"><input type="hidden" id="hiddenSupId" value="<?php echo $cboSupplier;?>"/><input type="hidden" id="hiddenFileName"       value="<?php echo $name[0].".".$name[1];?>"/></td></tr>
 </table>
 <table width="805px" class="tableBorder" align="center">
  <tr><td align="center" ><img src="../images/save.png" onclick="saveSupInvoiceUploadData();"/><img src="../images/mProcess.png" onclick="loadProcessPopUp();"/></td></tr>
 </table>
</div>

</form>
</body>
<script src="../js/jquery.fixedheader.js" type="text/javascript"></script>
<script src="SupInvUploadData.js" type="text/javascript"></script>
</html>



