<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
$plno=$_GET["plno"];
$orderid=$_GET["orderid"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<title>Shipment Packing List</title>
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
.bcglm {
	border: 1px solid #CC9900;
}
</style>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th {border: 1px solid #FFF; padding: 0px 0px;  margin:0px;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>

<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.9.custom.min.js"></script>
<link href="../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="jquery.fixedheader.js" type="text/javascript"></script>
<style type="text/css">
#menu-hide tr:hover{background-color:#c5c5c5} 
.bcgl2 {
	border-bottom: 1px solid #DADADA;
}
.normalfnt_num {
	font-family: Verdana;
	font-size: 11px;
	color: #498CC2;
	margin: 0px;
	font-weight: normal;
	text-align:center;
	padding:2px;
}
</style>
<script type="text/javascript">





function upload_po()
{

	if(document.getElementById("sample_po_sheet").value=='')
	{	
			
		alert("There is no file to upload. Please select the specific file.")	
		document.getElementById("sample_po_sheet").focus();
		
		return false;
	}
//alert("iyguygh");
	document.frmTuka.submit();
	
	
	//var masterbuyerCode = document.getElementById('cboBuyer').value;
//	var url	="receipt-db.php?id=deleteuploadfile";
//			url+="&masterbuyerCode="+masterbuyerCode;
//		var xmlhttp_obj	  = $.ajax({url:url,async:false});
	//uploadFileValidation();
	//document.forms['frmTuka'].submit();
	//alert(document.frmTuka.submit());	
	
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
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">Shipment forecast  </td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="850" style="margin-top:15px;">
				<tr>
					<td class="normalfnt">Select SE </td>
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
                  
                    
                  <td  class="normalfnt"> Uploaded SE#</td>
                    <td width="230"><select name="cboSerialNo3" style="width:230px" id="cboSerialNo3" class="txtbox" onchange="loadDeleteDetails();">
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
				  <td width="101" class="normalfnt"><span class="normalfnt" style="text-align:center"> Date</span></td>
				  <td width="179"><input name="txtDate" tabindex="2" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/>
			      <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  <td width="118" class="normalfnt" style="visibility:hidden;" >&nbsp;</td>
				  <td width="81" class="normalfnt" style="text-align:center; visibility:hidden" >&nbsp;</td>
				  <td width="113" class="normalfnt" style="text-align:center; visibility:hidden">&nbsp;</td>
				  <td style="visibility:hidden"><span class="normalfnt" style="text-align:center"><span class="normalfnt" style="text-align:left;"><img src="../../images/search.png" onclick="validateDataToLoadGrid();" class="mouseover"/></span></span></td>
			  </tr>
          </table>
		  <table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		    <tr>
    <td></td>
    <?php 
//excel upload part goes here

		$file_type= $_POST["frmTuka"];
	//if($file_type!='')
	//{
		
		$filepath = $_FILES["sample_po_sheet"]["name"];
		//echo $filepath;
		mkdir("uplodfile", 0700);
		$filenameB = basename($filepath);
		$file = "uplodfile/".$filepath;
		move_uploaded_file($_FILES["sample_po_sheet"]["tmp_name"],"uplodfile/".$filepath);
			
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
		
		for ($i =2; $i < $data->sheets[0]['numRows']+1; $i++)
		
			{	

				$sc_no 		 =  $data->sheets[0]['cells'][$i][1];
				$buyer 		 =  $data->sheets[0]['cells'][$i][2];
				$drop_no 	 =  $data->sheets[0]['cells'][$i][3];
				$po_no 		 =  $data->sheets[0]['cells'][$i][4];
				
				$StokeNo	 =  $data->sheets[0]['cells'][$i][5];
				$DeptNo		 =  $data->sheets[0]['cells'][$i][6];
				$season 	 =  $data->sheets[0]['cells'][$i][7];
				$GOH 		 =  $data->sheets[0]['cells'][$i][8];
				
				$CTNS 		 =  $data->sheets[0]['cells'][$i][9];
				$packType	 =  $data->sheets[0]['cells'][$i][10];
				$Qty 		 =  $data->sheets[0]['cells'][$i][11];
				$NET_wt		 =  $data->sheets[0]['cells'][$i][12];
				
				$GRS_Wt	 			=  $data->sheets[0]['cells'][$i][13];
				$Ctn_Measurement    =  $data->sheets[0]['cells'][$i][14];
				$U_PRICE 			 =  $data->sheets[0]['cells'][$i][15];
				$GSP_STATUS 		 =  $data->sheets[0]['cells'][$i][16];
				
				$DESC		=  $data->sheets[0]['cells'][$i][17];
				$fabric		 =  $data->sheets[0]['cells'][$i][18];
				$Country 	 =  $data->sheets[0]['cells'][$i][19];
				$FACTORY 		 =  $data->sheets[0]['cells'][$i][20];
				
				$SHIP_MODE 		 =  $data->sheets[0]['cells'][$i][21];
				$EX_FTY	 		=  $data->sheets[0]['cells'][$i][22];
				$FOB_DATE 		 =  $data->sheets[0]['cells'][$i][23];
				//$NET_wt		 =  $data->sheets[0]['cells'][$i][12];
				
			//echo $Invoice_No ;
				
				if($sc_no !='')
				{
					$str="INSERT INTO ShipmentForecast
						( 
						strSC_No,
						strBuyer,
						strDrop_No,
						strPoNo,
						strStokeNo,
						strDeptNo,
						strSeason,
						strGOH_No,
						intCtns,
						strPackType,
						strQty,
						intNetWt,
						intGrsWt,
						strCtnMes,
						intUnitPrice,
						intGSP_status,
						strDesc,
						strFabric,
						strCountry,
						strFactory,
						strShipMode,
						strEX_FTY,
						dtmFOBdate
						)
						VALUES
						(
				'$sc_no', 		
				'$buyer '	,	
				'$drop_no', 	 
				'$po_no',
				'$StokeNo',	
				'$DeptNo'	,
				'$season',
				'$GOH' ,		 
				'$CTNS', 		
				'$packType'	, 
				'$Qty', 		
				'$NET_wt',	
				'$GRS_Wt',	 			
				'$Ctn_Measurement',    
				'$U_PRICE' 	,		 
				'$GSP_STATUS' ,
				'$DESC'	,	
				'$fabric'	,	
				'$Country', 	
				'$FACTORY' ,
				'$SHIP_MODE' ,		
				'$EX_FTY',	 		
				'$FOB_DATE' );";
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
            <td  colspan="2" ><form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="POST" action="ShipmentForecast.php" > <table width="100%" cellpadding="2" cellspacing="0">
             

              <tr>
              	<td width="3%">&nbsp;</td>
                <td class="normalfnt" width="12%"  height="25">Shipment forecast  </td>
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