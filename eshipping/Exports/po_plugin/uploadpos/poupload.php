<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Upload</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function upload_po()
{
	
	if(document.getElementById("sample_po_sheet").value=='')
	{
		alert("There is no file to upload. Please select the specific file.")	
		document.getElementById("sample_po_sheet").focus();
		return false;
	}
	document.frmTuka.submit();
}
function view_orderspec()
{
	var h_orderid=document.getElementById("h_orderid").value;
	location.href="../../order/orderspec/orderspec.php?orderno="+h_orderid; 	
}
function view_xlorderspec(obj)
{
	
	location.href="list_pos.php?batch="+obj; 
}
</script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php';?></td>
    <?php 
//excel upload part goes here

$file_type= $_POST["cboFileType"];
if($file_type)
{
$filepath	    = $_FILES["sample_po_sheet"]["name"];
mkdir("../../../upload files", 0700);
$filenameB = basename($filepath);
$file = "../../../upload files/".$filepath;
move_uploaded_file($_FILES["sample_po_sheet"]["tmp_name"],"../../../upload files/". $filepath);

if($file_type=='EXCEL')
	{		
	if($filepath!='')
		{			
		include 'reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($file);
		$str_syscontrol="select dblBatchNo from syscontrol";
		$result_syscontrol=$db->RunQuery($str_syscontrol);
		$batch_no_holder=mysql_fetch_array($result_syscontrol);
		$batch_no=$batch_no_holder["dblBatchNo"];
		
		$str_update_batch="update syscontrol set dblBatchNo=dblBatchNo+1";
		$result_update_batch=$db->RunQuery($str_update_batch);
		for ($i = 6; $i < $data->sheets[0]['numRows']+1; $i++)
			{		
				$mal_no 		 =  $data->sheets[0]['cells'][$i][6];
				$order_no 		 =  $data->sheets[0]['cells'][$i][12];
				$color 	 		 =  $data->sheets[0]['cells'][$i][18];
				$size		     =  $data->sheets[0]['cells'][$i][19];					 		
				$qty		     =  $data->sheets[0]['cells'][$i][20];
				$price			 =  $data->sheets[0]['cells'][$i][23];
			
				
				if($mal_no)
				{
					$str="INSERT INTO order_upload 
						( 
						intBatchNo,
						strMalNo, 
						strOrderNo, 
						strStyle, 
						strColor, 
						strSize, 
						dblQty, 
						price
						)
						VALUES
						(
						'$batch_no',
						'$mal_no', 
						'$order_no', 
						'n/a', 
						'$color', 
						'$size', 
						'$qty', 
						'$price'
						);";
					$result=$db->RunQuery($str);
					
					
				}	
				
				$xluploaded=true;	
			}
		
		
		}
}
else if($file_type=='GAPXML')
{
	$doc = new DOMDocument();
 	$doc->load($file);
	$po_header = $doc->getElementsByTagName( "HEADER" );
	$order_no=$po_header->item(0)->getElementsByTagName( "ORDERNUM" )->item(0)->nodeValue;
	validate_po($order_no);
	$product=$po_header->item(0)->getElementsByTagName( "DEPARTMENT" )->item(0)->nodeValue;	
	$po_detail = $doc->getElementsByTagName( "DETAIL" );
	$style=$po_detail->item(0)->getElementsByTagName( "STYLE" )->item(0)->nodeValue;
	
	$str_header="INSERT INTO orderspec 
	( 
	strOrder_No, 
	strStyle_No, 
	strStyle_Description, 
	strWFXId, 
	dblMax_retail_price, 
	strQuality, 
	strGender, 
	strMaterial, 
	strFabric, 
	strLabel, 
	strSeason, 
	strBuyer, 
	strDivision_Brand, 
	strItem_no, 
	strItem, 
	strSorting_Type, 
	strWash_Code, 
	strConstruction, 
	strGarment_Type, 
	intStatus, 
	strUnit
	)
	VALUES
	( 
	'$order_no', 
	'$style', 
	 '', 
	 null, 
	 null, 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'$product', 
	'', 
	'', 
	'', 
	'', 
	1, 	 
	''
	);";
	
	$reault_header=$db->RunQuery($str_header);
	$sqlInvoice="SELECT intOrderId FROM orderspec where strOrder_No='$order_no'";
	$resultInvoice=$db->RunQuery($sqlInvoice);
	
	
	
	$rowID=mysql_fetch_array( $resultInvoice);
	$order_id= $rowID["intOrderId"];
	
	
	foreach($po_detail as $pod)
	{
		$size=$pod->getElementsByTagName( "ATTRCODE2" )->item(0)->nodeValue;		
		$desc=$pod->getElementsByTagName( "FULLDESC" )->item(0)->nodeValue;
		$unit_price=$pod->getElementsByTagName( "UNITPRICE" )->item(0)->nodeValue;
		$mrp=$pod->getElementsByTagName( "MSRP" )->item(0)->nodeValue;
		$qty=$pod->getElementsByTagName( "QUANTITY" )->item(0)->nodeValue;
		$sku=$pod->getElementsByTagName( "SKU" )->item(0)->nodeValue;
		$color=$pod->getElementsByTagName( "EXTRA" )->item(2)->getElementsByTagName('CONTENT')->item(0)->nodeValue;
		$color_code=$pod->getElementsByTagName( "ATTRCODE1" )->item(0)->nodeValue;
		//$color_code1=$pod->getElementsByTagName( "ATTRCODE1" )->item(0)->nodeValue;
		
		$color_code = str_replace($style,'', $color_code);
		//echo $color_code;
			
		$prepackNo=$pod->getElementsByTagName( "EXTRA" )->item(1)->getElementsByTagName('CONTENT')->item(0)->nodeValue;
		
		if($prepackNo=='')
			$prepackNo='Bulk';
			
		$prepackType=$pod->getElementsByTagName( "EXTRA" )->item(4)->getElementsByTagName('CONTENT')->item(0)->nodeValue;
		
		if($prepackType=='')
			$prepackType='BULK';
		
		$desc = addslashes($desc);
		$color = addslashes($color);
		//echo $color;
			
		$str_detail="INSERT INTO orderspecdetails 
	(intOrderId, 
	strSize, 
	strColor, 
	strColorCode, 
	dblPcs, 
	dblPrice, 
	strDescription, 
	intStatus, 
	dblMRP, 
	strSKU, 
	strFabric,
	strPrePackNo,
	strPrePackType
	)
	VALUES
	('$order_id', 
	'$size', 
	'$color', 
	'$color_code', 
	'$qty', 
	'$unit_price', 
	 '$desc', 
	'1', 
	'$unit_price', 
	'$sku', 
	'',
	'$prepackNo',
	'$prepackType'
	);";
	$result_detail=$db->RunQuery($str_detail);
	$uploaded=1;
	}
}
else if($file_type=='LANDSXML')
{
	$doc = new DOMDocument();
 	$doc->load($file);
	$po_header = $doc->getElementsByTagName( "HEADER" );
	$order_no=$po_header->item(0)->getElementsByTagName( "ORDERNUM" )->item(0)->nodeValue;
	validate_po($order_no);
	$product=$po_header->item(0)->getElementsByTagName( "DEPARTMENT" )->item(0)->nodeValue;	
	$po_detail = $doc->getElementsByTagName( "DETAIL" );
	$style=$po_detail->item(0)->getElementsByTagName( "STYLE" )->item(0)->nodeValue;
	$str_header="INSERT INTO orderspec 
	( 
	strOrder_No, 
	strStyle_No, 
	strStyle_Description, 
	strWFXId, 
	dblMax_retail_price, 
	strQuality, 
	strGender, 
	strMaterial, 
	strFabric, 
	strLabel, 
	strSeason, 
	strBuyer, 
	strDivision_Brand, 
	strItem_no, 
	strItem, 
	strSorting_Type, 
	strWash_Code, 
	strConstruction, 
	strGarment_Type, 
	intStatus, 
	strUnit
	)
	VALUES
	( 
	'$order_no', 
	'$style', 
	 '', 
	 null, 
	 null, 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'', 
	'$product', 
	'', 
	'', 
	'', 
	'', 
	1, 	 
	''
	);";
	
	$reault_header=$db->RunQuery($str_header);
	$sqlInvoice="SELECT intOrderId FROM orderspec where strOrder_No='$order_no'";
	$resultInvoice=$db->RunQuery($sqlInvoice);
	$rowID=mysql_fetch_array( $resultInvoice);
	$order_id= $rowID["intOrderId"];
	
	foreach($po_detail as $pod)
	{
		$size=$pod->getElementsByTagName( "ATTRCODE2" )->item(0)->nodeValue;		
		$desc=$pod->getElementsByTagName( "FULLDESC" )->item(0)->nodeValue;
		$unit_price=$pod->getElementsByTagName( "UNITPRICE" )->item(0)->nodeValue;
		$mrp=$pod->getElementsByTagName( "MSRP" )->item(0)->nodeValue;
		$qty=$pod->getElementsByTagName( "QUANTITY" )->item(0)->nodeValue;
		$sku=$pod->getElementsByTagName( "SKU" )->item(0)->nodeValue;
		$color=$pod->getElementsByTagName( "EXTRA" )->item(1)->getElementsByTagName('CONTENT')->item(0)->nodeValue;
		//echo $color;
		$color_code=$pod->getElementsByTagName( "ATTRCODE1" )->item(0)->nodeValue;
		
		$color_code = str_replace($style,'', $color_code);
		
		$desc = addslashes($desc);
		$color = addslashes($color);
		
		$prepackNo='Bulk';
		$prepackType='BULK';
				
		$str_detail="INSERT INTO orderspecdetails 
	(intOrderId, 
	strSize, 
	strColor, 
	strColorCode, 
	dblPcs, 
	dblPrice, 
	strDescription, 
	intStatus, 
	dblMRP, 
	strSKU, 
	strFabric,
	strPrePackNo,
	strPrePackType
	)
	VALUES
	('$order_id', 
	'$size', 
	'$color', 
	'$color_code', 
	'$qty', 
	'$unit_price', 
	'$desc', 
	'1', 
	'$unit_price', 
	'$sku', 
	'',
	'$prepackNo',
	'$prepackType'
	);";
	$result_detail=$db->RunQuery($str_detail);
	$uploaded=1;
	}
}

		$fh = fopen($file, 'a');
		fclose($fh);	
		unlink($file);
}
?>
  </tr>
  <tr>
    <td align="center"><table width="500" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">Sample Order Upload</th>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          <tr>
            <td  colspan="2" ><form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="POST" action="poupload.php" > <table width="100%" cellpadding="2" cellspacing="0">
              
              <tr>
                <td  height="25">Document Type</td>
                <td>&nbsp;</td>
                <td><select name="cboFileType"   class="txtbox" id="cboFileType"style="width:150px"  tabindex="1">
			        <option value="EXCEL" >EXCEL 2003</option>
                    <option value="GAPXML" >GAP XML</option>
                    <option value="LANDSXML" >LANDS END XML</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td width="28%"  height="25">Sample PO Sheet</td>
                <td width="2%">&nbsp;</td>
                <td width="70%"><input type="file" name="sample_po_sheet" style="width:250px;" id="sample_po_sheet" class="txtbox"  size="32" />
                  <img src="../../../images/files_upload_icon.png"  align="absmiddle" class="mouseover" onclick="upload_po()"/></td>
              </tr>
              <?php if($uploaded){?>
              <tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_orderspec();"/> to view details.</strong><input type="hidden" id="h_orderid" name="h_orderid" value="<?php echo $order_id?>" /></td>
                </tr><?php }?>
                <?php if($xluploaded){?>
              <tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_xlorderspec(<?php echo $batch_no;?>);"/> to view details.</strong><input type="hidden" id="h_orderid" name="h_orderid" value="<?php echo $order_id?>" /></td>
                </tr><?php }?>
              </table></form></td>
          </tr>
          <!-- <tr>
            <th  colspan="2" class="mainHeading2" style="background-color:#CCC; text-align:center">Size Ratio</th>
            </tr>
          <tr>-->
		  
          <tr style="display:none">
            <td height="500" colspan="2" valign="top"><table width="500" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="sizeratio_grid">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                  <th width="20%" height="20" style="text-align:center">PO</th>
                  <th width="40%" style="text-align:center">Product</th>
                  <th width="20%" style="text-align:center">Price</th>
                  <th width="20%" style="text-align:center">Qty</th>
                  </tr>
                </thead>
              <tbody>
                </tbody>
              </table></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<?php 
function validate_po($po)
{
	
	global $db;
	$str_check_po="SELECT intOrderId FROM orderspec  WHERE strOrder_No='$po'";
	$result_check_po=$db->RunQuery($str_check_po);
	
	while($row_check_po=mysql_fetch_array($result_check_po))
	{
		
		$order_id=$row_check_po['intOrderId'];
		$str_del_dtl="DELETE FROM orderspecdetails WHERE intOrderId='$order_id'";
		$result_del_dtl=$db->RunQuery($str_del_dtl);
		
		
	}
	
	$str_del_hd="DELETE FROM orderspec WHERE strOrder_No='$po'";
	$result_del_hd=$db->RunQuery($str_del_hd);
	return;
	
	
}	

?>
</html>