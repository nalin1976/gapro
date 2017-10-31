<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Receipt</title>
<script type="text/javascript">

function upload_po()
{
		
	if(document.getElementById("sample_po_sheet").value=='')
	{	
			
		alert("There is no file to upload. Please select the specific file.")	
		document.getElementById("sample_po_sheet").focus();
		
		return false;
	}
	
	var masterbuyerCode = document.getElementById('cboBuyer').value;
	var url	="receipt-db.php?id=deleteuploadfile";
			url+="&masterbuyerCode="+masterbuyerCode;
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
document.frmTuka.submit();	//uploadFileValidation();
	//document.forms['frmTuka'].submit();
	//alert(document.forms['frmTuka'].submit());	
	
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

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

<script type="text/javascript" src="receipt.js"></script>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>

<style type="text/css">
.tableGrid{
	border:1px solid #cccccc;
}

.tableGrid thead{
	background-color:#7cabc4;
	text-align:center;
	color:#ffffff;
	padding:10px 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}

.tableGrid tbody{
	background-color:#e3e9ec;
	text-align:left;
	color:#333333;
	padding:4px;
}
</style>
</head>


<body>
<!--<form name="frmFabricIns" id="frmFabricIns" > -->
<table width="700" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td><?php include $backwardseperator.'Header.php'; ?></td>
	</tr>
  	<tr> 
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;Receipt</td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="850" style="margin-top:15px;">
				<tr>
					<td class="normalfnt">Search Serial No</td>
					<td colspan="2"><select name="cboSerialNo" style="width:300px" id="cboSerialNo" class="txtbox" onchange="loadHeaderDetails();">
					  <option value="0"></option>
					  <?php
							$sql="SELECT intSerialNo FROM receipt_header WHERE intCancelStatus=0;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
					  <option value="<?php echo $row['intSerialNo']; ?>">REC<?php echo $row['intSerialNo']; ?></option>
					  <?php
							}
							?>
				    </select></td>
				  <td  style="visibility:hidden"><span class="normalfnt" style="text-align:center"><span class="normalfnt" style="text-align:center">Date To</span></span></td>
                  
                    
                  <td  class="normalfnt">Cancelled Serial No</td>
                    <td><select name="cboSerialNo3" style="width:230px" id="cboSerialNo3" class="txtbox" onchange="loadDeleteDetails();">
                      <option value="0"></option>
                     
                      <?php
							$sql="SELECT intSerialNo FROM receipt_header WHERE intCancelStatus=1;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
                      <option value="<?php echo $row['intSerialNo']; ?>">REC<?php echo $row['intSerialNo']; ?></option>
                      <?php
							}
							?>
                             
                    </select></td>
                   
                   
				</tr>
				<tr>
				  <td width="101" class="normalfnt"><span class="normalfnt" style="text-align:center">Receipt Date</span></td>
				  <td width="179"><input name="txtDate" tabindex="2" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/>
			      <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  <td width="118" class="normalfnt" style="visibility:hidden;" >Serch with Date</td>
				  <td width="81" class="normalfnt" style="text-align:center; visibility:hidden" ><input type="checkbox" id="chk_dateRange" name="chk_dateRange" onclick="enableDateRange(this);"/></td>
				  <td width="113" class="normalfnt" style="text-align:center; visibility:hidden">Date From</td>
				  <td style="visibility:hidden"><input name="txtDateFrom" tabindex="2" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled" />
			      <input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  </tr>
				<tr>
					<td width="101" class="normalfnt">Bank</td>
					<td colspan="2"><select name="cboBank" style="width:300px" id="cboBank" class="txtbox" onchange="">
					  <option value="0"></option>
					  <?php
							$sql="SELECT DISTINCT
									bank.strBankCode,
									bank.strName
									FROM
									bank
									ORDER BY strName
									;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
					  <option value="<?php echo $row['strBankCode']; ?>"><?php echo $row['strName']; ?></option>
					  <?php
							}
							?>
				    </select></td>
					<td class="normalfnt" style="text-align:center">&nbsp;</td>
					<td class="normalfnt" style="text-align:center">&nbsp;</td>
			  	  <td width="230"><span style="visibility:hidden">
			  	    <input name="txtDateTo" tabindex="2" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/>
                    <input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
			  	  </span></td>
				</tr>
<tr>
					<td width="101" class="normalfnt">Buyer</td>
					<td colspan="2"><select name="cboBuyer" style="width:300px" id="cboBuyer" class="txtbox" onchange="loadBanks();">
					  <option value="0"></option>
					  <?php /*
							$sql="SELECT DISTINCT buyers.strBuyerId, buyers.strName
									FROM
									buyers
									INNER JOIN commercial_invoice_header ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
									ORDER BY strName;";*/
									
							$sql="SELECT
									buyers_main.intMainBuyerId,
									buyers_main.strMainBuyerName
									FROM
									buyers_main
									;";
							
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
					  <option value="<?php echo $row['intMainBuyerId']; ?>"><?php echo $row['strMainBuyerName']; ?></option>
					  <?php
							}
							?>
				    </select></td>
				  
	      <td class="normalfnt" style="text-align:center"><span class="normalfnt" style="text-align:left;"><img src="../../images/search.png" onclick="validateDataToLoadGrid();" class="mouseover"/></span></td>
	      <td class="normalfnt" style="text-align:center; visibility:hidden">Bank Letter No</td>
				    <td style="visibility:hidden"><select name="cboBankLetterNo" style="width:200px" id="cboBankLetterNo" class="txtbox" onchange="clearGrid();" disabled="disabled">
				      <option value="0"></option>
				      <?php
							$sql="SELECT
									bankletter_header.intSerialNo
									FROM
									bankletter_header
									;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
				      <option value="<?php echo $row['intSerialNo']; ?>"><?php echo $row['intSerialNo']; ?></option>
				      <?php
							}
							?>
			        </select></td>
			  </tr>
          </table>
              <table width="838" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
              

               
			  <tr>
					<td width="103" class="normalfnt"><span class="normalfnt" style="text-align:left;">Net Amount</span></td>
                    <td class="normalfnt"><input type="text" style="width:100px; text-align:right" id="txtTotNetAmt" class="txtbox" name="txtTotNetAmt" disabled="disabled" value="0"/></td>
				  <td width="79" ><span class="normalfnt" style="text-align:left;"><span class="normalfnt" style="text-align:left;">Remarks</span></span></td>
					<td class="normalfnt" colspan="2"><input type="text" class="txtbox" style="width:160px; text-align:left" id="txtRemarks" name="txtRemarks" size="100" /></td>
		  	  	  <td width="135" class="normalfnt">&nbsp;</td>
					<td class="normalfnt">&nbsp;</td>
			  	  	<td width="1"><!--<img src="../../images/search.png" onclick="validateGrid();" />--></td>
				</tr>
                
                <tr>
           
           	<td style="text-align:left;" class="normalfnt">Buyer Claim</td>
				  <td width="144"><span class="normalfnt">
				    <input type="text" class="txtbox" style="width:100px; text-align:right" id="txtBuyerClaim" name="txtBuyerClaim" onkeypress="return CheckforValidDecimal(this.value,2,event);"  value="0" onkeyup="calculateAmt();"/>
				  </span></td>
				  <td class="normalfnt" style="text-align:left;">Invoice  Amt</td>
				  <td><input type="text" style="width:100px; text-align:right" id="txtTotInvoiceAmt" class="txtbox" name="txtTotInvoiceAmt" disabled="disabled" value="0"/></td>
                  
				  <td style="text-align:left;" width="120" class="normalfnt">&nbsp;</td>
		  	  	  <td width="135">&nbsp;</td>
					<td width="80" class="normalfnt">&nbsp;</td>
            </tr>
                <tr>
                  <td class="normalfnt" style="text-align:left;">Net Receipt Amt</td>
                  <td><span class="normalfnt">
                    <input type="text" disabled="disabled" id="txtNetReceiptAmt" name="txtNetReceiptAmt" class="txtbox" style="width:100px; text-align:right" />
                  </span></td>
                  <td class="normalfnt">Discount Amt</td>
                  <td><input type="text" style="width:100px; text-align:right" id="txtDiscountAmt" class="txtbox" name="txtTotDiscountAmt" disabled="disabled" value="0"/></td>
                  <td class="normalfnt" style="text-align:left;">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                
 	      </table>
          
          
          
          
          
          <table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php';?></td>
    <?php 
//excel upload part goes here

		$file_type= $_POST["frmTuka"];
	//if($file_type!='')
	//{
		
		$filepath = $_FILES["sample_po_sheet"]["name"];
		mkdir("uplodfile", 0700);
		$filenameB = basename($filepath);
		$file = "uplodfile/".$filepath;
		move_uploaded_file($_FILES["sample_po_sheet"]["tmp_name"],"uplodfile/". $filepath);
			
		if($filepath!='')
		
		{
			
		include 'reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($file);
		//$str_syscontrol="select dblBatchNo from syscontrol";
		//$result_syscontrol=$db->RunQuery($str_syscontrol);
		//$batch_no_holder=mysql_fetch_array($result_syscontrol);
		//$batch_no=$batch_no_holder["dblBatchNo"];
		
		//$str_update_batch="update syscontrol set dblBatchNo=dblBatchNo+1";
		//$result_update_batch=$db->RunQuery($str_update_batch);
		for ($i = 2; $i < $data->sheets[0]['numRows']+1; $i++)
			{		
				$Invoice_No 		 =  $data->sheets[0]['cells'][$i][1];
				$Buyer_PoNo 		 =  $data->sheets[0]['cells'][$i][2];
				
			//echo $Invoice_No ;
				
				if($Invoice_No)
				{
					$str="INSERT INTO import_receipt 
						( 
						strInvoice_No,
						strBuyer_PoNo 
						)
						VALUES
						(
						'$Invoice_No',
						'$Buyer_PoNo'
						);";
					$result=$db->RunQuery($str);
				}	
				$xluploaded=true;	
			}
		
	//}
		$fh = fopen($file, 'a');
		fclose($fh);	
		unlink($file);
}
?>
  </tr>

          <tr>
            <td  colspan="2" ><form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="POST" action="receipt.php" > <table width="100%" cellpadding="2" cellspacing="0">
             

              <tr>
              	<td width="3%">&nbsp;</td>
                <td class="normalfnt" width="12%"  height="25">Sample PO Sheet</td>
                <td width="85%" colspan="2"><input type="file" name="sample_po_sheet" style="width:250px;" id="sample_po_sheet" class="txtbox"  size="32" />
                <img src="../../images/files_upload_icon.png"  align="absmiddle" class="mouseover" onclick="upload_po();"/></td>
              </tr>
              
              <?php if($uploaded){?>
              
              <!--<tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_orderspec();"/> to view details.</strong><input type="hidden" id="Invoice_No" name="Invoice_No" value="<?php echo $Invoice_No?>" /></td>
              </tr>-->
			  
			  <?php }?>
                <?php if($xluploaded){?>
                
             <!-- <tr>
                <td  height="25" colspan="3" style="color:#00C"> <strong>* Successfully uploded. Click <img src="../../../images/go.png" width="30" height="22" align="absmiddle" class="mouseover" onclick="view_xlorderspec(<?php echo $batch_no;?>);"/> to view details.</strong><input type="hidden" id="Invoice_No" name="Invoice_No" value="<?php echo $order_id?>" /></td>
              </tr>-->
			  
			  <?php }?>
              </table></form>
  <div align="center">
	  <div align="center" style="width:700px; height:200px; overflow:auto; margin-top:25px;">
				  <table align="center" width="680" bgcolor="#CCCCFF" id="tblreceipt" cellpadding="0" cellspacing="1" border="0">
						<thead>
							<tr  bgcolor="#498CC2" class="normaltxtmidb2">
								<td width="43">Select</td>
								<td width="76">Invoice No</td>	
                                <td width="90">Invoice Date</td>
                                <td width="55">Style Id</td>
                                <td width="87">Buyer PO No</td>					
								<td width="112">Invoice Amount</td>
                                <td width="120">Discount Amount</td>
                                <td width="88">Net Amount</td>
                                <td width="70">Wfx No</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
				  </table>
				  
    </div>
</div>
	  </td>
	</tr></table>
	<tr>
    	<td>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
         
         <tr>
            <td width="110" bgcolor="#ffffff">&nbsp;</td>
   			<td colspan="3" bgcolor="#ffffff" class="normalfnt" style="text-align:left;" td>&nbsp;</td>
            <td width="100">&nbsp;</td>
                  
					<td style="text-align:left;" width="24" class="normalfnt">&nbsp;</td>
		  	  	  <td width="100"><input type="text" style="width:100px; text-align:right" id="txtTotInvoice" class="txtbox" name="txtTotInvoice" disabled="disabled" value="0"/></td>
                 
  	  	    <td style="text-align:center;" width="99" class="normalfnt"><input type="text" style="width:99px; text-align:right" id="txtDiscount" class="txtbox" name="txtDiscount" disabled="disabled" value="0"/></td>
		  	  	  <td width="83"><input type="text" style="width:83px; text-align:right" id="txtTotNet" class="txtbox" name="txtTotNet" disabled="disabled" value="0"/></td>
		   <td width="200" class="normalfnt" style="text-align:center"><a href="<?php echo $backwardseperator;?>Finance/receipt/receipterror.php" target="_blank">Error Report </a></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td colspan="9" bgcolor="#D6E7F5"><table width="100%" border="0" cellpadding="0" cellspacing="0">
		      <tr></tr>
              <tr>
                <td width="49" bgcolor="#ffffff">&nbsp;</td>
                <td width="40" bgcolor="#ffffff">&nbsp;</td>
                <td width="23" bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#D6E7F5"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="2%">&nbsp;</td>
                    <td width="20%">&nbsp;</td>
                    <td width="17%"><img src="../../images/new.png" alt="new" name="butNew" width="" height="24" class="mouseover"  id="butNew" onclick="clearForm();"/></td>
                    <td width="16%"><img src="../../images/save.png" alt="new" name="butIouSave" width="93" height="24" class="mouseover"  id="butIouSave" onclick="validateData();"/></td>
                    <td width="16%"><img src="../../images/cancel.jpg" width="100" class="mouseover"  onclick="CancelInv();"/></td>
                    <td width="14%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="" height="24" border="0" id="Close" /></a></td>
                    <td width="12%"><img src="../../images/aad.png" class="mouseover" onclick="uploadFileValidation();"/></td>
                    <td width="3%">&nbsp;</td>
                  </tr>
                </table></td></tr></table>
                </td></tr></table></td></tr></td></tr>
                </table>
</body></html>