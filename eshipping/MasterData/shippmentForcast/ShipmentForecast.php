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

<title>Shipment forecast </title>





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


<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
<link href="../../css/LRStyleCSS.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/formJS.js" type="text/javascript"></script>
<script src="ShipmentForecast.js" type="text/javascript"></script>


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
					<td class="normalfnt">Buyer</td>
					<td colspan="2"><select name="cboBuyer" style="width:300px" id="cboBuyer" class="txtbox" onchange="loadGrid();">
					  <option value="0"></option>
					  <?php
							$sql="SELECT
							shipmentforecast_detail.strBuyer
							FROM
							shipmentforecast_detail
							GROUP BY
							shipmentforecast_detail.strBuyer;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
					  <option value="<?php echo $row['strBuyer']; ?>"> <?php echo $row['strBuyer']; ?></option>
					  <?php
							}
							?>
				    </select></td>
				  <td  style="visibility:hidden"><span class="normalfnt" style="text-align:center"><span class="normalfnt" style="text-align:center">Date To</span></span></td>
                  
                    
                  <td  class="normalfnt">Name</td>
                    <td width="230"><input name="txtName" type="text" maxlength="100" class="txtbox" id="txtName" size="60" style="width:225px"/></td>
                   
                   
				</tr>
				<tr>
				  <td width="101" class="normalfnt"><span class="normalfnt" style="text-align:center"> Date</span></td>
				  <td width="179"><input name="txtDate" tabindex="2" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" disabled="disabled" onkeypress="return ControlableKeyAccess(event);" value="20<?php echo date('y/m/d');?>" onclick="return showCalendar(this.id, '%y/%m/%d');"/>
			      <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  <td width="118" class="normalfnt" style="visibility:hidden;" >&nbsp;</td>
				  <td width="81" class="normalfnt" style="text-align:center; visibility:hidden" >&nbsp;</td>
				  <td width="113" class="normalfnt" >&nbsp;</td>
				  <td >&nbsp;</td>
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
				
				$StyleNo	 =  $data->sheets[0]['cells'][$i][5];
				$DeptNo		 =  $data->sheets[0]['cells'][$i][6];
				$season 	 =  $data->sheets[0]['cells'][$i][7];
				$GOH 		 =  $data->sheets[0]['cells'][$i][8];
				
				$CTNS 		 =  $data->sheets[0]['cells'][$i][9];
				$packType	 =  $data->sheets[0]['cells'][$i][10];
				$Qty 		 =  $data->sheets[0]['cells'][$i][11];
				$NET_wt		 =  $data->sheets[0]['cells'][$i][12];
				
				
				$GRS_Wt      =  $data->sheets[0]['cells'][$i][13];
				$Ctn_L		 =  $data->sheets[0]['cells'][$i][14];
				$Ctn_W       =  $data->sheets[0]['cells'][$i][15];
				$Ctn_H       =  $data->sheets[0]['cells'][$i][16];
				

				$U_PRICE            =  $data->sheets[0]['cells'][$i][17];
				$GSP_STATUS         =  $data->sheets[0]['cells'][$i][18];
				
				$DESC        =  $data->sheets[0]['cells'][$i][19];
				$fabric		 =  $data->sheets[0]['cells'][$i][20];
				$Country 	 =  $data->sheets[0]['cells'][$i][21];
				$FACTORY     =  $data->sheets[0]['cells'][$i][22];
				
				$SHIP_MODE       =  $data->sheets[0]['cells'][$i][23];
				$EX_FTY          =  $data->sheets[0]['cells'][$i][24];
				$FOB_DATE        =  $data->sheets[0]['cells'][$i][25];
				$PO_Des			 =  $data->sheets[0]['cells'][$i][26];
				
				
				$ITEM_No       	 =  $data->sheets[0]['cells'][$i][27];
				$Knit_Woven      =  $data->sheets[0]['cells'][$i][28];
				$CONTRACT        =  $data->sheets[0]['cells'][$i][29];
				$RETEK_NO        =  $data->sheets[0]['cells'][$i][30];
				
				
				$ORMS_PORD_No       	 =  $data->sheets[0]['cells'][$i][31];
				$IMAN_Code    			 =  $data->sheets[0]['cells'][$i][32];
				$Criterion_No       	 =  $data->sheets[0]['cells'][$i][33];
				$TU_PONO		         =  $data->sheets[0]['cells'][$i][34];
				
				
				
				$TU_STY      	 	 =  $data->sheets[0]['cells'][$i][35];
				$PLANT    			 =  $data->sheets[0]['cells'][$i][36];
				$CUSTOMER       	 =  $data->sheets[0]['cells'][$i][37];
				$PO_HIT_NO		     =  $data->sheets[0]['cells'][$i][38];
				
				
				
				
				$FCL_LCL      	 	 =  $data->sheets[0]['cells'][$i][39];
				$VCP    			 =  $data->sheets[0]['cells'][$i][40];
				$PRODUCT_NO       	 =  $data->sheets[0]['cells'][$i][41];
				$SALES_ORDER_NO		 =  $data->sheets[0]['cells'][$i][42];
				
				
				
				$ITEM_COLOR      =  $data->sheets[0]['cells'][$i][43];
				$CTNS_TYPE    	 =  $data->sheets[0]['cells'][$i][44];
				$UNITE       	 =  $data->sheets[0]['cells'][$i][45];
				$SCF_STATUS		 =  $data->sheets[0]['cells'][$i][46];
				
				
				
				$Destination      	 =  $data->sheets[0]['cells'][$i][47];
				$Product_Code    	 =  $data->sheets[0]['cells'][$i][48];
				$Marsks_Numbers      =  $data->sheets[0]['cells'][$i][49];
				$PCS_Per_CTNS		 =  $data->sheets[0]['cells'][$i][50];
				
				
				$NetWT_Ppcs      	 =  $data->sheets[0]['cells'][$i][51];
				$GrsWT_Ppcs    		 =  $data->sheets[0]['cells'][$i][52];
				$BLUES_PO_NO     	 =  $data->sheets[0]['cells'][$i][53];
				$OTHER_REF			 =  $data->sheets[0]['cells'][$i][54];
				
				$CBM			 =  $data->sheets[0]['cells'][$i][55];
			//echo $Invoice_No ;
				
				if($sc_no !='')
				{
					//$sql_deleteDetail = "delete from shipmentforecast_detail where strSC_No ='$sc_no'";
	 				//$result=$db->RunQuery($sql_deleteDetail);
	 
					$str="INSERT INTO shipmentforecast_detail
							(
							strSC_No,
							strBuyer,
							strDrop_No,
							strPoNo,
							strStyleNo,
							strDeptNo,
							strSeason,
							strGOH_No,
							strPackType,
							strQty,
							intNOF_Ctns,
							intNetWt,
							intGrsWt,
							intCtnsL,
							intCtnsW,
							intCtnsH,
							intUnitPrice,
							intGSP_status,
							strDesc,
							strFabric,
							strCountry,
							strFactory,
							strShipMode,
							dtmEX_FTY_Date,
							dtmFOBdate,
							strPo_des,
							strItemNo,
							strknit_woven,
							strContractva,
							strRetec_No,
							strOrms_Pord_No,
							strIMAN_Code,
							strCriterion_No,
							strTu_PoNo,
							strTu_Style,
							strPlant,
							strCustomer,
							strPo_Hit_No,
							strFcl_Lcl,
							strVCP,
							strProduct_No,
							strSales_Order_No,
							strItem_Color,
							strCtns_Type,
							strUnite,
							strSTF,
							strDestination,
							strProduct_Code,
							strMarsks_Numbers,
							strPcs_Per_Ctns,
							strNetWT_Ppcs,
							strGrsWT_Ppcs,
							strBlues_Po_No,
							strOther_Ref,
							dblCBM
							)
							VALUES
							(
							'$sc_no', 
							'$buyer ',
							'$drop_no', 
							'$po_no', 
							'$StyleNo',
							'$DeptNo',
							'$season', 
							'$GOH ',
							'$packType',
							'$Qty ',
							'$CTNS' ,
							'$NET_wt',
							'$GRS_Wt ',    
							'$Ctn_L',
							'$Ctn_W',     
							'$Ctn_H',      
							'$U_PRICE',    
							'$GSP_STATUS ',
							'$DESC ',      
							'$fabric',
							'$Country', 
							'$FACTORY ',  
							'$SHIP_MODE ', 
							'$EX_FTY  ',   
							'$FOB_DATE',    
							'$PO_Des',
							'$ITEM_No ',    
							'$Knit_Woven  ',
							'$CONTRACT',    
							'$RETEK_NO ',   
							'$ORMS_PORD_No',
							'$IMAN_Code',   
							'$Criterion_No',
							'$TU_PONO',
							'$TU_STY',      
							'$PLANT ',   
							'$CUSTOMER ',   
							'$PO_HIT_NO',
							'$FCL_LCL',     
							'$VCP ',   
							'$PRODUCT_NO',  
							'$SALES_ORDER_NO',
							'$ITEM_COLOR ',    
							'$CTNS_TYPE',    
							'$UNITE  ',     
							'$SCF_STATUS',
							'$Destination ',   
							'$Product_Code ',  
							'$Marsks_Numbers ',
							'$PCS_Per_CTNS',
							'$NetWT_Ppcs',      
							'$GrsWT_Ppcs ',   
							'$BLUES_PO_NO',     
							'$OTHER_REF',
							$CBM	

							)";
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
              	<td width="2%">&nbsp;</td>
                <td class="normalfnt" width="13%"  height="25">Shipment forecast  </td>
                <td width="43%" ><input type="file" name="sample_po_sheet" style="width:250px;" id="sample_po_sheet" class="txtbox"  size="32" />
                <img src="../../images/files_upload_icon.png"  align="absmiddle" class="mouseover" onclick="upload_po();"/></td>
                <td width="42%" >&nbsp;</td>
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
	  <div align="center" style="width:850px; height:200px; overflow: scroll; height: 250px; width: 900px; margin-top:25px;">
				  <table align="center" width="1200px" bgcolor="#CCCCFF" id="tblForcast" cellpadding="0" cellspacing="1" border="0">
						<thead>
							<tr  bgcolor="#498CC2" class="normaltxtmidb2">
                                <td width="53">Confirm</td>
                                <td nowrap="nowrap" width="60">SC No</td>
                                <td width="55">Style No</td>
                                <td width="42">Buyer PO No</td>
                                <td width="74">Description</td>
                                <td width="84">Fabric Composition </td>
                                <td width="55">Country </td>
                                <td width="67">Season</td>
                                <td width="39">Price</td>
                                <td width="76">Del Date</td>
                                <td width="64">Factory</td>
                                <td width="101">CTN Measurement</td>
                                <td width="41">QTY</td>
                                <td width="46">Net WT</td>
                                <td width="50">GRS WT</td>
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
                    <td width="17%">&nbsp;</td>
                    <td width="16%"><img src="../../images/save.png" alt="new" name="butIouSave" width="93" height="24" class="mouseover"  id="butIouSave" onclick="validateData();"/></td>
                    <td width="16%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="" height="24" border="0" id="Close" /></a></td>
                    <td width="14%" style="visibility:hidden"><img src="../../images/cancel.jpg" width="100" class="mouseover"  onclick="CancelInv();"/></td>
                    <td width="12%" >&nbsp;</td>
                    <td width="3%">&nbsp;</td>
                  </tr>
              </table></td></tr></table>
                </td></tr></table></td></tr></td></tr>
                </table>
<?php /*?>                <?php
	include "Shipment_Order_Ratio.php";
	include "ColorSizeSelector.php";
?><?php */?>
</body></html>