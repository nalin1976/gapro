<?php
include "../authentication.inc";
include "../Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$consumptionDecimalLength = $xml->SystemSettings->ConsumptionDecimalLength;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BOM - Item Status(Edited Style Ratio)</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../javascript/script.js"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
<script src="editStyleRatio_Popup-js.js"></script>
<script>
function loadConPcTextBox(obj){
	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	if(document.getElementById("txtConPC")==null)
	{
	
	tblReOrder.rows[row].cells[col].innerHTML="<input type=\"text\" name=\"txtConPC\" style=\"text-align:right\" size=\"8\" class=\"txtbox\" id=\"txtConPC\" style=\"width:80px\" onkeyup=\"setReqQty(this);setBackCell(this,event);\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onblur=\"setCell(this);\" value="+value+">";
	//tblReOrder.rows[row].cells[col].id=1;
	
	document.getElementById("txtConPC").focus();	
	}
}

function setBackCell(obj,e)
{
	if (window.event) 
	{ 
		e = window.event; 
	}
	
	if(e.keyCode==13)
	{
		var row = obj.parentNode.parentNode.rowIndex;
		var col = obj.parentNode.cellIndex;
		var tblItemDetais = document.getElementById("tblItemDetais");
		if(obj.value != null){	
		var txtVal = obj.value;
		}else{
		var txtVal = '';
		}
		tblItemDetais.rows[row].cells[col].innerHTML=txtVal;
		
		save(row);
	}
	
}

function setCell(obj)
{ 
		var row = obj.parentNode.parentNode.rowIndex;
		var col = obj.parentNode.cellIndex;
		var tblItemDetais = document.getElementById("tblItemDetais");	
		var txtVal = obj.value;
		tblItemDetais.rows[row].cells[col].innerHTML=txtVal;
		
		//save(row);
}

function setReqQty(obj){

 var tblItemDetais = document.getElementById("tblItemDetais");	
 var row = obj.parentNode.parentNode.rowIndex;
 var conPC = tblItemDetais.rows[row].cells[6].lastChild.nodeValue;
 if(conPC == null){
  var conPC = tblItemDetais.rows[row].cells[6].lastChild.value;
 }
 var col=obj.cellIndex;
 var exQty =  tblItemDetais.rows[row].cells[8].id;
 var wastage = tblItemDetais.rows[row].cells[7].childNodes[0].nodeValue;
 if(wastage == null){
   var wastage = tblItemDetais.rows[row].cells[7].childNodes[0].value;
 }
 var newReqQty =  exQty * conPC;
 var newReqQtyWithWastage = newReqQty +  (newReqQty*wastage/100);
 newReqQtyWithWastage = newReqQtyWithWastage.toFixed(2);
 tblItemDetais.rows[row].cells[8].childNodes[0].nodeValue = newReqQtyWithWastage;
}

//-----------------------------------------------------------------------------------------------------------

function loadReqQtyTextBox(obj){
 	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	if(document.getElementById("txtReqQty")==null)
	{
	
	tblReOrder.rows[row].cells[col].innerHTML="<input type=\"text\" name=\"txtReqQty\" style=\"text-align:right\" size=\"8\" class=\"txtbox\" id=\"txtReqQty\" style=\"width:80px\" onkeyup=\"setConPc(this);setBackCell(this,event);\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onblur=\"setCell(this);\" value="+value+">";
	//tblReOrder.rows[row].cells[col].id=1;
	
	document.getElementById("txtReqQty").focus();	
	}
}

function setConPc(obj){

 var reqQty = obj.value;
 var row = obj.parentNode.parentNode.rowIndex;
 var col=obj.cellIndex;
 var tblItemDetais = document.getElementById("tblItemDetais");	
 var exQty =  tblItemDetais.rows[row].cells[8].id;
 var wastage = tblItemDetais.rows[row].cells[7].childNodes[0].nodeValue;
 
 var consumption = reqQty - ((reqQty*wastage)/100);
 var consumptionWithWaste = consumption/exQty;
 tblItemDetais.rows[row].cells[6].childNodes[0].nodeValue = consumptionWithWaste.toFixed(4);
}

//-------------------------------------------------------------------------------------------------------

function loadWastageTextBox(obj){
  	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	if(document.getElementById("txtWastage")==null)
	{
	
	tblReOrder.rows[row].cells[col].innerHTML="<input type=\"text\" name=\"txtWastage\" style=\"text-align:right\" size=\"5\" class=\"txtbox\" id=\"txtWastage\" style=\"width:10px\" onkeyup=\"setReqQty(this);setBackCell(this,event);\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onblur=\"setCell(this);\" value="+value+">";
	//tblReOrder.rows[row].cells[col].id=1;
	
	document.getElementById("txtWastage").focus();	
	}
}

//---------------------------------------------------------------------------------------------------

function loadDelDateTextBox(){
	document.getElementById("txtDelDateTd").innerHTML="<input type=\"text\" name=\"txtDelDate\" style=\"text-align:left\" size=\"25\" class=\"txtbox\" id=\"txtDelDate\" style=\"width:100px\" onkeypress = \"setBackDelDateCell(this,event);\"  onblur=\"setCell(this);\" >";
	document.getElementById("txtDelDate").focus();	
}

function setBackDelDateCell(obj,e){
	if (window.event) 
	{ 
		e = window.event; 
	}
	
	if(e.keyCode==13)
	{
		var txtVal = obj.value;
		document.getElementById("txtDelDateTd").innerHTML=txtVal;
	}
}	

function loadDescriptionTextBox(obj){
   	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	if(document.getElementById("txtDescription")==null)
	{
	
	tblReOrder.rows[row].cells[col].innerHTML="<input type=\"text\" name=\"txtDescription\" style=\"text-align:left\" maxlength=\"20\" class=\"txtbox\" id=\"txtDescription\" style=\"width:100px\" onkeypress=\"setBackCell(this,event);\"  value="+value+">";
	//tblReOrder.rows[row].cells[col].id=1;
	
	document.getElementById("txtDescription").focus();	
	}
}

function save(row)
{
	var tblItemDetais = document.getElementById("tblItemDetais");	
	var saverow    = tblItemDetais.rows[row];
	var intStyleId       = document.getElementById("intStyleId").value;	
	var ratioOrderNos    = document.getElementById("ratioOrderNos").value;
	var itemSerial = saverow.cells[1].id;
	var color  = saverow.cells[3].lastChild.nodeValue;
	var BuyerPONO = saverow.cells[3].id;
	var size   = saverow.cells[4].lastChild.nodeValue;
	var conPc  = saverow.cells[6].lastChild.nodeValue;
	var wastage = saverow.cells[7].lastChild.nodeValue;
	var wastaSplit = wastage.split('%');
	wastage = wastaSplit[0];
	if(saverow.cells[8].lastChild == null){
	var reqQty = 0;
	}else{
	var reqQty = saverow.cells[8].id;
	}
	if(saverow.cells[2].lastChild != null){
    var description = saverow.cells[2].lastChild.nodeValue;
	}else{
	var description = '';
	}
	
	url="editStyleRatio_Popup-db-set.php?RequestType=save&intStyleId="+intStyleId+"&ratioOrderNos="+ratioOrderNos+"&itemSerial="+itemSerial+"&conPc="+conPc+"&reqQty="+         reqQty+"&color="+color+"&size="+size+"&BuyerPONO="+URLEncode(BuyerPONO)+"&wastage="+URLEncode(wastage)+"&description="+description;	
	var httpobj = $.ajax({url:url,async:false});
	var response=httpobj.responseText;
			
		//calculateGramdTot();
}

function calculateGramdTot(){
 var tblItemDetais = document.getElementById("tblItemDetais");	
 var tot = 0;
 var grandTot = 0;
 for(var a=1;a<tblItemDetais.rows.length-3;a++){
 if(tblItemDetais.rows[a].cells[6].lastChild == null){
 tot = 0;
 }else{
  tot = tblItemDetais.rows[a].cells[6].lastChild.nodeValue;
  if(tot == null){
   tot = 0;
  }
  grandTot += parseFloat(tot);
   }
 }
 grandTot = grandTot.toFixed(2);
 tblItemDetais.rows[tblItemDetais.rows.length-2].cells[1].lastChild.nodeValue = grandTot;
}

function visibleDeleteButton(obj){
   	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	tblReOrder.rows[row].cells[col].innerHTML="<img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"delRow(this)\"/></div>";
}

function hideDeleteButton(obj){
   	var row = obj.parentNode.rowIndex;
	var col=obj.cellIndex;
	var tblReOrder = document.getElementById("tblItemDetais");	
	var value=tblReOrder.rows[row].cells[col].innerHTML;
	
	tblReOrder.rows[row].cells[col].innerHTML="";
}

function delRow(obj){
	var row = obj.parentNode.parentNode.rowIndex;
	var tblItemDetais    = document.getElementById("tblItemDetais");	

	var intStyleId       = document.getElementById("intStyleId").value;	
	var ratioOrderNos    = document.getElementById("ratioOrderNos").value;
	var itemSerial = tblItemDetais.rows[row].cells[1].id;
	var color  = tblItemDetais.rows[row].cells[3].lastChild.nodeValue;
	var BuyerPONO = tblItemDetais.rows[row].cells[3].id;
	var size   = tblItemDetais.rows[row].cells[4].lastChild.nodeValue;
    var conPc  = tblItemDetais.rows[row].cells[6].lastChild.nodeValue;
	var wastage = tblItemDetais.rows[row].cells[7].lastChild.nodeValue;

	if(tblItemDetais.rows[row].cells[8].lastChild == null){
	var reqQty = 0;
	}else{
	var reqQty = tblItemDetais.rows[row].cells[8].lastChild.nodeValue;
	}
	
var hi= confirm("Do you really want to delete this row?");
if (hi== true){	
url="editStyleRatio_Popup-db-set.php?RequestType=delete&intStyleId="+intStyleId+"&ratioOrderNos="+ratioOrderNos+"&itemSerial="+itemSerial+"&conPc="+conPc+"&reqQty="+         reqQty+"&color="+color+"&size="+size+"&BuyerPONO="+URLEncode(BuyerPONO)+"&wastage="+URLEncode(wastage);
	var httpobj = $.ajax({url:url,async:false});
	var response=httpobj.responseText;
	alert("Successfully deleted");
	tblItemDetais.deleteRow(row);
 }
}

function visibleCancelButton(obj){
document.getElementById("btnCancel").style.visibility = "visible";
}

function hideCancelButton(obj){
document.getElementById("btnCancel").style.visibility = "hidden";
}



</script>
</head>

<body>
<table width="1100" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
     <?php 

	 
		$txtWastageForAll = $_GET["txtWastageForAll"];
		$strStyleID=$_GET["styleID"];
		$ratioOrderNos=$_GET["ratioOrderNos"];
		//$strStyleID='200998(6427)-TT-01';
		
		$intQty=0;
		$buyerName="";
		$intSRNO=0;
		$strDescription="";
		$usrnme="";
		$intCompanyID=0;
		
		//company
		$CompanyName="";
		$strAddress1="";
		$strAddress2="";
		$strStreet="";
		$strState="";
		$strCity="";
		$strCountry="";
		$strZipCode="";
		$strPhone="";
		$strEMail="";
		$strFax="";
		$strWeb="";
		$exPercentage = 0;
		$exQty = 0;
		
	    $sql1 = "select * from editedStyleRatio where intOrderNo='$ratioOrderNos' and intStatus = '1'";
		$result1 = $db->RunQuery($sql1);
		if(!mysql_num_rows($result1)){
		 echo "<caption>Order Sheet is Canceled!</caption>";
		 break;
		}
		
		$SQL="SELECT orders.strOrderNo,orders.intStyleId, orders.intQty, orders.reaExPercentage, buyers.strName, specification.intSRNO, orders.strDescription, useraccounts.Name, orders.intCompanyID
FROM ((orders INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID) INNER JOIN specification ON orders.intStyleId = specification.intStyleId) INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID
WHERE (((orders.intStyleId)='".$strStyleID."'));";
     // echo $SQL;
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			$intQty			= $row["intQty"];
			$buyerName		= $row["strName"];
			$intSRNO		= $row["intSRNO"];
			$strDescription	= $row["strDescription"];
			$usrnme			= $row["Name"];
			$intCompanyID	= $row["intCompanyID"];
			$exPercentage 	= $row["reaExPercentage"];
			$orderNo		= $row["strOrderNo"];
		}
		$exQty = $intQty + ($intQty * $exPercentage / 100);
		
		$report_companyId = $intCompanyID;
		?>
      <tr>
        <td ><?php include 'reportHeader.php';?></td>
        <!--<td width="6%" class="normalfnt">&nbsp;</td>-->
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="7" class="head2"><table width="100%" border="0">
          <tr>
            <td width="22%" align="center">&nbsp;</td>
            <td width="60%" align="center">ORDER SHEET - REPORT
              <?php
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $xmlISO->ISOCodes->BOMReport;
						}              
	                 
                   ?></td>
            <td width="18%" class="normalfnth2Bm">MML/MER/002</td>
          </tr>
      </table></td>
      </tr>
      <tr>
        <td width="13%" class="normalfnth2B">STYLE NO</td>
        <td class="normalfnt">
		<?php
		$sql_style="select strStyle,intStyleId from orders where intStyleId='$strStyleID'";
		$result_style=$db->RunQuery($sql_style);
		$row_style = mysql_fetch_array($result_style);
		echo $row_style["strStyle"];
		?></td>
        <td class="normalfnt"><span class="normalfnth2B">SC NO</span></td>
        <td class="normalfnt"><?php echo $intSRNO;?></td>
        <td width="6%" id="strStyleID" style="visibility:hidden"><?php echo $strStyleID;?></td>
        <td width="19%" class="normalfnth2B">DESCRIPTION</td>
        <td width="27%" class="normalfnt"><?php echo $strDescription;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">ORDER NO </td>
        <td colspan="3" class="normalfnt"><?php echo $orderNo;?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">MERCHANDISER</td>
        <td class="normalfnt"><?php echo $usrnme;?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">ORDER QTY</td>
        <td width="15%" class="normalfnt"><?php echo $intQty;?></td>
        <td width="9%" class="normalfnth2B">WITH EXCESS </td>
        <td width="11%" class="normalfnt"><?php echo $exQty; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">BUYER</td>
        <td class="normalfnt"><?php echo $buyerName;?></td>
      </tr>
      <tr>
        <td height="26" class="normalfnth2B">&nbsp;</td>
        <td colspan="3" class="normalfnt">&nbsp;</td>
        <td>&nbsp;<input type="hidden" id="intStyleId" value="<?php echo $row_style["intStyleId"];?>"/></td>
        <td class="normalfnt2bldBLACK">Document No</td>
        <td class="normalfnt" id="tdRatioOrderNos"><?php echo $_GET['ratioOrderNos']; ?></td>
      </tr>
      
      

    </table></td>
  </tr>
  <tr>
    <td class="normalfnth2B">Delivery Schedule </td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblDelSched">
        <tr >
          <td width="300" class="normalfntBtab">Delivery Date </td>
          <td width="100" class="normalfntBtab">BuyerPONo</td>
          <td width="100" class="normalfntBtab">Qty</td>
        </tr>
		<?php
		$sql = "select dtDateofDelivery,dblQty,dbExQty from deliveryschedule where intStyleId = '$strStyleID' order by dtDateofDelivery;";
		$result = $db->RunQuery($sql); 	
		$totqty = 0;
		while($row = mysql_fetch_array($result))
		{
			$delDate = $row["dtDateofDelivery"];
			$sql = "select dtDateofDelivery,strBuyerPONO,intQty from bpodelschedule  where intStyleId = '$strStyleID' and dtDateofDelivery = '$delDate'";
			$resultbpo = $db->RunQuery($sql); 
			$num_rows = mysql_num_rows($resultbpo);
			if ($num_rows > 0)
			{
				while($rowbpo = mysql_fetch_array($resultbpo))
				{
		?>
		<tr>
			<td class="normalfntTAB" onclick="loadDelDateTextBox()" id="txtDelDateTd"><?php echo date("jS F Y", strtotime($rowbpo["dtDateofDelivery"])) ;  ?></td>
			<td class="normalfntTAB"><?php echo $rowbpo["strBuyerPONO"];  ?></td>
			<td class="normalfntRiteTAB"><?php echo $rowbpo["intQty"];  ?></td>
		</tr>
		<?php
				}
			}
			else
			{
			?>
			<tr>
			<td class="normalfntTAB" onclick="loadDelDateTextBox()" id="txtDelDateTd"><?php echo date("jS F Y", strtotime($row["dtDateofDelivery"]))  ?></td>
			<td class="normalfntTAB">#Main Ratio#</td>
			<td class="normalfntRiteTAB"><?php echo $row["dbExQty"];  ?></td>
		</tr>
			
			<?php
			
			}
			$totqty += $row["dbExQty"]; 
		}
		
		?>
		<tr>
		  <td colspan="2" class="normalfntMidTAB">Total</td>
		  <td class="normalfntRiteTAB"><?php echo $totqty;  ?></td>
	    </tr>
    </table></td>
    <td>&nbsp;<input type="hidden" id="ratioOrderNos" value="<?php echo $_GET['ratioOrderNos']; ?>"/> </td>
  </tr>
  <?php
 	$sql = "select distinct strBuyerPONO from styleratio where intStyleId = '$strStyleID'";
 	$resultbpo = $db->RunQuery($sql); 	
	while($rowbpo = mysql_fetch_array($resultbpo))
	{
		$sizearray = array();
  ?>
  <tr>
    <td><span class="normalfnth2B">Style Ratio - <?php echo $rowbpo["strBuyerPONO"];  ?> </span></td>
  </tr>

<!--  <tr  style="visibility:hidden">
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td><table width="500" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblColorSize">
        <tr >
          <td width="200" class="normalfntBtab">Color/Size</td>
		  <?php
		  $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
		  ?>
          <td width="75" class="normalfntBtab">&nbsp;<?php echo $rowsize["strSize"];  ?>&nbsp;</td>
          <?php
		  	$loop ++;
		  	}
		  ?>
          <td width="75" class="normalfntBtab">Total</td>
        </tr>
		<?php
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $rowbpo["strBuyerPONO"] . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
			$rowtot = 0;
		?>
		<tr>
		  <td class="normalfntTAB"><?php echo $rowcolor["strColor"];  ?></td>
		  <?php
		  	foreach ($sizearray as $size)
			{
				//echo $sql = "select dblExQty from editedStyleRatio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				  $sql="select styleratio.dblExQty as exQty1, 
editedStyleRatio.dblExQty as exQty2
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where editedStyleRatio.intOrderNo = '$ratioOrderNos' and styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "' and styleratio.strColor = '".$rowcolor["strColor"]."' and styleratio.strSize = '$size'";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					if($rowqty["exQty2"]!=''){
						
						$qty=$rowqty["exQty2"];
					}
					else{
						$qty=$rowqty["exQty1"];
					}
					$rowtot += $qty;
		  ?>
			<td class="normalfntMidTAB">&nbsp;<?php echo number_format($qty,0,'','');  ?>&nbsp;</td>
			<?php
				}
			}
			?>
			<td class="normalfntMidTAB">&nbsp;<?php echo number_format($rowtot,0,'','');  ?>&nbsp;</td>
		</tr>
		<?php
		}

		$sumtot = 0;
		?>
		<tr>
		  <td class="normalfntTAB">Total</td>
		  <?php
		  foreach ($sizearray as $size)
			{
				 $sql = "select sum(styleratio.dblExQty) as exQty1, 
sum(editedStyleRatio.dblExQty) as exQty2
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where editedStyleRatio.intOrderNo = '$ratioOrderNos' and styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '".$rowbpo["strBuyerPONO"]."' and styleratio.strSize = '$size';";
				$resulttotqty = $db->RunQuery($sql); 
				while($rowtotqty= mysql_fetch_array($resulttotqty))
				{
					if($rowtotqty["exQty2"]!=''){
						
						$qty=$rowtotqty["exQty2"];
					}
					else{
						$qty=$rowtotqty["exQty1"];
					}
				$sumtot += $qty;
		  ?>
		  <td class="normalfntMidTAB">&nbsp;<?php echo number_format($qty,0,'','');?>&nbsp;</td>
		  <?php
				}
			  }
		  ?>
		  <td class="normalfntMidTAB">&nbsp;<?php echo number_format($sumtot,0,'','');  ?>&nbsp;</td>
	    </tr>
    </table></td>
    <td>&nbsp; </td>
  </tr>
  <?php
  }
  ?>
  <TR>
  <TD class="normalfnth2B"> Item Details  </TD>
  </TR>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItemDetais">
    <thead>
      <tr>
	    <td  class="normalfntBtab" width="2%"></td>
        <td  class="normalfntBtab" width="30%">Item</td>
		<td  class="normalfntBtab" width="10%">Description</td>
        <td  class="normalfntBtab" width="10%">Color</td>
        <td  class="normalfntBtab" width="10%">Size</td>
        <td  class="normalfntBtab" width="8%">Unit</td>
        <td  class="normalfntBtab" width="6%">Con/Pc</td>
        <td  class="normalfntBtab" width="6%">Waste %</td>
        <td  class="normalfntBtab" width="6%">Req. Qty</td>        
        </tr>
     </thead>
      <tr>
      <?php
	 	$Count_Req_Qty=0;
		$Count_Orderd_QTY=0;
		$Count_Bal_Orederd=0;
	  
	  $SQL_Category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
FROM (specificationdetails INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
WHERE (((specificationdetails.intStyleId)='". $strStyleID."'))AND matmaincategory.intID not in(4,5)
ORDER BY matmaincategory.intID;
";

//echo $SQL_Category;

		$result_Category= $db->RunQuery($SQL_Category);
		while($row_Category = mysql_fetch_array($result_Category))
		{
		echo "<td height=\"20\" colspan='2' class=\"normalfnt2BITAB\">".$row_Category["strDescription"]."</td>";
		echo "<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"/*."<td>&nbsp;</td>"*/;
		echo "<td>&nbsp;</td>"."<td style='visibility:hidden'>0</td>"."</tr>";
		

  $Item = "select * from (SELECT

matitemlist.strItemDescription,
matitemlist.intItemSerial,
null as strDes,
materialratio.strBuyerPONO,
materialratio.strColor,
materialratio.strSize,
specificationdetails.strUnit,
specificationdetails.sngConPc as sngConPc,
editedStyleRatio.dblExQty as dblExQty,
specificationdetails.sngWastage
FROM
((materialratio
Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial)
Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID)
Inner Join specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
Left Join editedStyleRatio ON materialratio.intStyleId = editedStyleRatio.intStyleId AND materialratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND materialratio.strColor = editedStyleRatio.strColor AND materialratio.strSize = editedStyleRatio.strSize AND editedStyleRatio.intOrderNo = '$ratioOrderNos' 

WHERE (((materialratio.intStyleId)='".$strStyleID."') AND ((matmaincategory.intID)=".$row_Category["intID"].") AND editedStyleRatio.intStatus = '1') 

and materialratio.strMatDetailID not in

(
	SELECT
editordersheet.intMatDetailId
FROM editordersheet
WHERE
editordersheet.intStyleId =  materialratio.intStyleId AND
editordersheet.intMatDetailId =  materialratio.strMatDetailID AND
editordersheet.strColor =  materialratio.strColor AND
editordersheet.strSize =  materialratio.strSize AND
editordersheet.intDocNo =  '$ratioOrderNos'

)
union
SELECT

matitemlist.strItemDescription,
matitemlist.intItemSerial,
editordersheet.strDes as strDes,
editordersheet.strBuyerPoNo AS strBuyerPONO,
editordersheet.strColor,
editordersheet.strSize,
matitemlist.strUnit,
editordersheet.dblConPc as sngConPc,
editordersheet.dblReqQty as dblExQty,
editordersheet.strWastage as sngWastage
FROM
editordersheet
Inner Join orders ON orders.intStyleId = editordersheet.intStyleId
Inner Join matitemlist ON matitemlist.intItemSerial = editordersheet.intMatDetailId
WHERE
editordersheet.intStyleId =  '".$strStyleID."' AND matitemlist.intMainCatID='".$row_Category["intID"]."' AND 
editordersheet.intDocNo =  '$ratioOrderNos' AND editordersheet.intStatus ='1') as T order by strItemDescription";

			
			$result_Description= $db->RunQuery($Item);
			$i=0;
			while($row_Descrip = mysql_fetch_array($result_Description))
			{
			    $TRcolor = '';
				if($txtWastageForAll == ''){
				$waste_value = $row_Descrip["sngWastage"];
				}else{
				$waste_value  = $txtWastageForAll;
				}
				$buyerPO=$row_Descrip["strBuyerPONO"];
				$color=$row_Descrip["strColor"];
				$size=$row_Descrip["strSize"];
				

				//if(dblReqQty)
				if(($row_Descrip["strColor"]!='N/A') && ($row_Descrip["strSize"]=='N/A')){
				 $sql1 = "select * from styleratio where intStyleId = '$strStyleID' AND strBuyerPONO = '$buyerPO' AND strColor = '$color'";
				 $result = $db->RunQuery($sql1);
				 if(mysql_num_rows($result)){
				
					$sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE 
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO' AND
					editedStyleRatio.strColor =  '$color'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
					}else{
					$TRcolor = "style='background-color:pink'";
					 $sqlQty = "SELECT
					Sum(materialratio.dblQty) as Qty
					FROM
					materialratio
					WHERE 
					materialratio.strSize = '$size' AND 
					materialratio.intStyleId =  '$strStyleID' AND
					materialratio.strBuyerPONO =  '$buyerPO' AND
					materialratio.strColor =  '$color'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
					}
				}
				else if(($row_Descrip["strColor"]=='N/A') && ($row_Descrip["strSize"]!='N/A')){
				 $sql1 = "select * from styleratio where intStyleId = '$strStyleID' AND strBuyerPONO = '$buyerPO' AND strSize = '$size'";
				 $result = $db->RunQuery($sql1);
				 if(mysql_num_rows($result)){
				 
					$sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO' AND
					editedStyleRatio.strSize =  '$size'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
				    $exQty = $rowQty["Qty"]; 
					}else{
					$TRcolor = "style='background-color:pink'";
					$sqlQty = "SELECT
					Sum(materialratio.dblQty) as Qty
					FROM
					materialratio
					WHERE 
					materialratio.strSize = '$size' AND 
					materialratio.intStyleId =  '$strStyleID' AND
					materialratio.strBuyerPONO =  '$buyerPO' AND
					materialratio.strColor =  '$color'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
					}
					
				}
				else if(($row_Descrip["strColor"]=='N/A') && ($row_Descrip["strSize"]=='N/A')){
					 $sqlQty = "SELECT
					Sum(editedStyleRatio.dblExQty) as Qty
					FROM
					editedStyleRatio
					WHERE 
					editedStyleRatio.intOrderNo = '$ratioOrderNos' AND 
					editedStyleRatio.intStyleId =  '$strStyleID' AND
					editedStyleRatio.strBuyerPONO =  '$buyerPO'";
					$resultQty = $db->RunQuery($sqlQty); 	
					$rowQty = mysql_fetch_array($resultQty);
					$exQty = $rowQty["Qty"]; 
				}
				else{
					$exQty=$row_Descrip["dblExQty"];
				}
				
	            $dblConPc = $row_Descrip["dblConPc"];
				$strBuyerPONO = $row_Descrip['strBuyerPONO'];
				if($exQty > 0){
				echo "<tr $TRcolor>";
				echo "<td onmouseover='visibleDeleteButton(this);' onmouseout='hideDeleteButton(this);' width='2%'></td>";
				echo "<td class=\"normalfntTAB\" id=".$row_Descrip["intItemSerial"]." >".$row_Descrip["strItemDescription"]."</td>";
				echo "<td class=\"normalfntTAB\"  onclick = 'loadDescriptionTextBox(this);'>".$row_Descrip["strDes"]."</td>";
				echo "<td  class=\"normalfntMidTAB\" id='$strBuyerPONO'>".$row_Descrip["strColor"]."</td>";
				echo "<td class=\"normalfntMidTAB\"  >".$row_Descrip["strSize"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strUnit"]."</td>";
				echo "<td class=\"normalfntRiteTAB\" onclick = 'loadConPcTextBox(this);'>".number_format($row_Descrip["sngConPc"],4)."</td>";
				echo "<td class=\"normalfntMidTAB\" onclick = 'loadWastageTextBox(this);'>".$waste_value."</td>";
				

				//$exQty=$row_Descrip["dblExQty"];

				echo "<td class=\"normalfntRiteTAB\" onclick = 'loadReqQtyTextBox(this);' id='$exQty'>
				".number_format($exQty*$row_Descrip["sngConPc"] + ($exQty*$row_Descrip["sngConPc"]*$waste_value)/100,0,'','')."
				</td>";	
				$Count_Req_Qty+=$exQty*$row_Descrip["sngConPc"];

							
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format(($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]),0) . "</td>";
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format($row_Descrip["dblBalQty"],0) ."</td>";
				echo "</tr>";
				
				
				$Count_Orderd_QTY+=($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]);
				$Count_Bal_Orederd+=$row_Descrip["dblBalQty"];
				}
			}
			
		}
		$Count_Req_Qty=round($Count_Req_Qty,0);
	  ?>
	    <tr>
		   <td colspan="9" class="normalfntTAB">&nbsp;</td>
	    </tr>
<!--		 <tr>
		   <td colspan="6" class="normalfntTAB"><strong>Grand Total </strong></td>
		   <td class="normalfntRiteTAB" ><?php echo number_format(($Count_Req_Qty),2); ?></td>
	    </tr>-->
		 <tr>
		   <td colspan="6" class="normalfntTAB">&nbsp;</td>
		   <td class="normalfntRiteTAB">&nbsp;</td>
	    </tr>
	  </table>	</td>
      <td>&nbsp;</td>
  </tr>
  <?php
  $sql = "select * from editordersheet 			WHERE
			editordersheet.intStyleId =  '".$strStyleID."' AND 
			editordersheet.intDocNo =  '$ratioOrderNos' AND editordersheet.intStatus ='0'";
  $result= $db->RunQuery($sql);	
  if(mysql_num_rows($result)){
  
  ?>
  <tr><TD class="normalfnth2B"> Deleted Items  </TD></tr>
  <tr><td>
  	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblDelete">
    <thead>
      <tr>
	    <td  class="normalfntBtab" width="2%"></td>
        <td  class="normalfntBtab" width="30%">Item</td>
		<td  class="normalfntBtab" width="10%">Description</td>
        <td  class="normalfntBtab" width="10%">Color</td>
        <td  class="normalfntBtab" width="10%">Size</td>
        <td  class="normalfntBtab" width="8%">Unit</td>
        <td  class="normalfntBtab" width="6%">Con/Pc</td>
        <td  class="normalfntBtab" width="6%">Waste %</td>
        <td  class="normalfntBtab" width="6%">Req. Qty</td>        
        </tr>
     </thead>
      <tr>
	</tr>
	
	<tr>
	  <?php
	 	$Count_Req_Qty=0;
		$Count_Orderd_QTY=0;
		$Count_Bal_Orederd=0;
	  
	  $SQL_Category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
FROM (specificationdetails INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
WHERE (((specificationdetails.intStyleId)='". $strStyleID."')) AND matmaincategory.intID not in(4,5)
ORDER BY matmaincategory.intID;
";

//echo $SQL_Category;

		$result_Category= $db->RunQuery($SQL_Category);
		while($row_Category = mysql_fetch_array($result_Category))
		{
		echo "<td height=\"20\" colspan='2' class=\"normalfnt2BITAB\">".$row_Category["strDescription"]."</td>";
		echo "<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"."<td>&nbsp;</td>"/*."<td>&nbsp;</td>"*/;
		echo "<td>&nbsp;</td>"."<td style='visibility:hidden'>0</td>"."</tr>";
		

  $Item = "select * from (
			SELECT
			
			matitemlist.strItemDescription,
			matitemlist.intItemSerial,
			editordersheet.strDes as strDes,
			editordersheet.strBuyerPoNo AS strBuyerPONO,
			editordersheet.strColor,
			editordersheet.strSize,
			matitemlist.strUnit,
			editordersheet.dblConPc as sngConPc,
			editordersheet.dblReqQty as dblExQty,
			editordersheet.strWastage as sngWastage
			FROM
			editordersheet
			Inner Join orders ON orders.intStyleId = editordersheet.intStyleId
			Inner Join matitemlist ON matitemlist.intItemSerial = editordersheet.intMatDetailId
			WHERE
			editordersheet.intStyleId =  '".$strStyleID."' AND matitemlist.intMainCatID='".$row_Category["intID"]."' AND 
			editordersheet.intDocNo =  '$ratioOrderNos' AND editordersheet.intStatus ='0') as T order by strItemDescription";

			
			$result_Description= $db->RunQuery($Item);
			$i=0;
			while($row_Descrip = mysql_fetch_array($result_Description))
			{
			 $TRcolor = '';
				$waste_value = $row_Descrip["sngWastage"];
				$buyerPO=$row_Descrip["strBuyerPONO"];
				$color=$row_Descrip["strColor"];
				$size=$row_Descrip["strSize"];

			    $exQty=$row_Descrip["dblExQty"];

				
	            $dblConPc = $row_Descrip["dblConPc"];
				$strBuyerPONO = $row_Descrip['strBuyerPONO'];
				if($exQty > 0){
				echo "<tr $TRcolor>";
				echo "<td  width='2%'></td>";
				echo "<td class=\"normalfntTAB\" id=".$row_Descrip["intItemSerial"]." >".$row_Descrip["strItemDescription"]."</td>";
				echo "<td class=\"normalfntTAB\"  >".$row_Descrip["strDes"]."</td>";
				echo "<td  class=\"normalfntMidTAB\" id='$strBuyerPONO'>".$row_Descrip["strColor"]."</td>";
				echo "<td class=\"normalfntMidTAB\"  >".$row_Descrip["strSize"]."</td>";
				echo "<td class=\"normalfntMidTAB\">".$row_Descrip["strUnit"]."</td>";
				echo "<td class=\"normalfntRiteTAB\">".number_format($row_Descrip["sngConPc"],4)."</td>";
				echo "<td class=\"normalfntMidTAB\" >".$row_Descrip["sngWastage"]."</td>";
				

				//$exQty=$row_Descrip["dblExQty"];

				echo "<td class=\"normalfntRiteTAB\"  id='$exQty'>
				".number_format($exQty*$row_Descrip["sngConPc"] + ($exQty*$row_Descrip["sngConPc"]*$row_Descrip["sngWastage"])/100,0,'','')."
				</td>";	
				$Count_Req_Qty+=$exQty*$row_Descrip["sngConPc"];

							
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format(($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]),0) . "</td>";
				//echo "<td  style=\"display:none\" class=\"normalfntRiteTAB\">" . number_format($row_Descrip["dblBalQty"],0) ."</td>";
				echo "</tr>";
				
				
				$Count_Orderd_QTY+=($row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]);
				$Count_Bal_Orederd+=$row_Descrip["dblBalQty"];
				}
			}
			
		}
		$Count_Req_Qty=round($Count_Req_Qty,0);
	  ?>
	  
	    </tr></table></td>
		<?php
		}
		?>
		
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="7%">&nbsp;</td>
        <td width="13%" class="normalfnt">Remark </td>
        <td width="80%"> :</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Care Label Position</td>
        <td>:</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Tag Position</td>
        <td>:</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Others</td>
        <td>:</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr class="normalfntMidSML">
        <td colspan="5" class="normalfnt">&nbsp;</td>
        </tr>
      <tr>
        <td width="19%" class="border-bottom">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="19%" class="border-bottom">&nbsp;</td>
        <td width="26%">&nbsp;</td>
        <td width="16%" class="border-bottom">&nbsp;</td>
      </tr>
      <tr class="normalfntMidTAB">
        <td>Merchandiser</td>
        <td>&nbsp;</td>
        <td>Planner</td>
        <td>&nbsp;</td>
        <td>Merchandising Manager</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr> 
   <tr>&nbsp;</tr>
</table>
</table>
<table width="317" style="margin-left:150px" border="0">
<tr>
<td width="16" style="background-color:pink"></td>
<td width="171" class="normalfnt">&nbsp;Must be customised by user</td>
<td width="108" onmouseover="visibleCancelButton(this);" onmouseout="hideCancelButton(this);"><img src="../images/cancel.jpg" style="visibility:hidden" id="btnCancel" onclick="cancelOrderSheet();"/></td>
</tr>
</table>
</body>
</html>
