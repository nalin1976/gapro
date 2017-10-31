var pub_intxmlHttp_count= 0;

var pub_matNo 			= 0;
var pub_printWindowNo	= 0;
var CopyToStat			= 0;
var pub_curr			= "NA";
$main0 					= 0;  	//Delete button
$main1 					= 1;	//Main category
$main2 					= 2;	//Item description
$mainRemark				= 3;	//Remarks
$main4 					= 4;	//Unit
$main5 					= 5;	//Qty
$main6 					= 6;    //Unit price
$maxUnit 				= 7;    //Max unit price
$main7					= 8;  	//Value
$main8 					= 9;	//Discount percentage
$main9					= 10;	//Discount price
$main10					= 11;  	//Final value
$main11 				= 12;	//Fixed check box
$main12        			= 13;	//Mat detail id
$main13					= 14;	//PR no 
$main14					= 15 ;   //cost center 
$main15					= 16;//GL Code
//BEGIN - Load pending po when form load to serch for the user.
$(document).ready(function() 
{
	var url					='generalPo-xml.php?id=load_PendinPO_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtFindGenPO" ).autocomplete({
			source: pub_po_arr
		});
		
		
});
//END - Load pending po when form load to serch for the user.

//BEGIN - Load pending po when change the searching PO year to serch for the user. 
function loadPendingPONoList()
{
	var url  = 'generalPo-xml.php?id=load_PendinPO_str';
		url += '&intYear='+document.getElementById('cbofindGenPOYear').value;
	
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtFindGenPO" ).autocomplete({
			source: pub_po_arr
		});
}
//END - Load pending po when change the searching PO year to serch for the user. 

//BEGIN - Close PopUp layer name pass as a parameter (LayerId)
function CloseGenPOPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
//END - Close PopUp layer name pass as a parameter (LayerId)
function ShowItems()
{
	
	showBackGround('divBG',0);
	var url="generalPoAddItemPopup.php"
	htmlobj=$.ajax({url:url,async:false});
	var HTMLText=htmlobj.responseText;
	drawPopupBox(866,508,'frmMaterial',1)
	document.getElementById('frmMaterial').innerHTML=HTMLText;
	
	
	var url					='generalPo-xml.php?id=load_PR_str';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_pr_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#txtPRNo" ).autocomplete({
		source: pub_pr_arr
	});
	
	//Load item list by codes to facilitate search  
	var url_itemcode = 'generalPo-xml.php?id=load_NAV_Code'; 
	var itemCode_xmlObj = $.ajax({url:url_itemcode, async:false});
	var arr_itemCode = 	itemCode_xmlObj.responseText.split("|");
	
	$("#txtNAVCode").autocomplete({
		source: arr_itemCode
	});
	
	loadItems();
}

function loadItems()
{
	loadMainCategory();
}

function loadMainCategory()
{
	ClearOptions('cboMainCategory');
	var url = 'generalPo-xml.php?id=loadMainCategory';
	var xml_http_obj = $.ajax({url:url,async:false});	
	document.getElementById("cboMainCategory").innerHTML = xml_http_obj.responseXML.getElementsByTagName('mainCat')[0].childNodes[0].nodeValue;	
 	loadSubCategory();	
	loadNavisionCode();		
}

function loadSubCategory()
{	
	ClearOptions('cboSubCategory');
	var mainCatId = document.getElementById("cboMainCategory").value;
	var url  = 'generalPo-xml.php?id=loadSubCategory';
		url += '&mainCatId='+mainCatId;	
	var xml_http_obj	=$.ajax({url:url,async:false});	
	document.getElementById("cboSubCategory").innerHTML = xml_http_obj.responseXML.getElementsByTagName('SubCat')[0].childNodes[0].nodeValue;
	loadNavisionCode();
}
function loadNavisionCode()
{	
	ClearOptions('cboNavitionCode');
	var subCat = document.getElementById("cboSubCategory").value;
	var mainCatId = document.getElementById("cboMainCategory").value;
	var url  = 'generalPo-xml.php?id=loadNavisionCode';
		url += '&subCat='+subCat;
		url += '&mainCatId='+mainCatId;	
	var xml_http_obj	=$.ajax({url:url,async:false});	
	document.getElementById("cboNavitionCode").innerHTML = xml_http_obj.responseXML.getElementsByTagName('naviCode')[0].childNodes[0].nodeValue;
	
}
	
function loadMaterial()
{
var mainCatId 		= document.getElementById("cboMainCategory").value;
var subCatId 		= document.getElementById("cboSubCategory").value;
//var navisionCode	= document.getElementById("cboNavitionCode").value;
var navisionCode	= document.getElementById("txtNAVCode").value;
var txtDetailsLike 	= document.getElementById("txtDetailsLike").value;
var txtPRNo 		= document.getElementById("txtPRNo").value;

/*if(txtPRNo!="")
{
	var url = 'generalPo-xml.php?id=loadCostCenter&txtPRNo='+txtPRNo;
	var http_obj = $.ajax({url:url,async:false});	
	document.getElementById("cboCostCenter").value = http_obj.responseXML.getElementsByTagName('costCenterId')[0].childNodes[0].nodeValue;
	document.getElementById("cboCostCenter").disabled = true;
	var costCenter 		= document.getElementById("cboCostCenter").value;	
}*/
/*else
{*/
	clearItemTable('tblMaterial');
	/*document.getElementById("cboCostCenter").disabled = false;
	var costCenter 		= document.getElementById("cboCostCenter").value;
	if(costCenter=="null")
	{
		alert("Please select 'Cost Center'");
		document.getElementById("cboCostCenter").focus();
		return false;
	}

}*/

clearItemTable('tblMaterial');

	var url  = 'generalPo-xml.php?id=loadMaterial';
		url += '&mainCatId='+mainCatId;
		url += '&subCatId='+subCatId;
		url += '&navisionCode='+navisionCode;
		url += '&txtDetailsLike='+txtDetailsLike;
		url += '&txtPRNo='+txtPRNo;
		//url += '&costCenter='+costCenter;
	var xml_http_obj = $.ajax({url:url,async:false});
	
	var XMLid 		 	= xml_http_obj.responseXML.getElementsByTagName("intItemSerial");
	var XMLname 	 	= xml_http_obj.responseXML.getElementsByTagName("strItemDescription");
	var XMLUnit 	 	= xml_http_obj.responseXML.getElementsByTagName("strUnit");	
	var XMLPRQty 	 	= xml_http_obj.responseXML.getElementsByTagName("PRQty");
	//var XMLGLId 	 	= xml_http_obj.responseXML.getElementsByTagName("cboGLId");
	var XMLUnitPrice 	= xml_http_obj.responseXML.getElementsByTagName("UnitPrice");
	//var XMLGLDes	 	= xml_http_obj.responseXML.getElementsByTagName("GLDescription");
	//var XMLPRGLId	 	= xml_http_obj.responseXML.getElementsByTagName("PRGLid");
	//var XMLPRGLDes	 	= xml_http_obj.responseXML.getElementsByTagName("PRGLDes");
	//var XMLGLAllowId	=xml_http_obj.responseXML.getElementsByTagName("GLAllowId");
	//var XMLCostCenterId = xml_http_obj.responseXML.getElementsByTagName("CostCenterId")[0].childNodes[0].nodeValue;
	//document.getElementById('cboCostCenter').value = XMLCostCenterId;
	var XMLItemCode 	= xml_http_obj.responseXML.getElementsByTagName("ItemCode");
	var tblMaterial  = document.getElementById("tblMaterial");

	for ( var loop = 0; loop < XMLid.length; loop++)
	{
		var lastRow = tblMaterial.rows.length;	
		var row = tblMaterial.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkitem(this)\"/>";	
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLid[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLname[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		//cell.innerHTML ="<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"\"/>";
		cell.innerHTML ="<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLPRQty[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"\"/>";
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.innerHTML ="<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLUnitPrice[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"\"/>";
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.innerHTML = XMLItemCode[loop].childNodes[0].nodeValue;
		
		/*var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.innerHTML = XMLItemCode[loop].childNodes[0].nodeValue;*/
		
		/*var cell = row.insertCell(3);
		cell.className ="normalfntRite";
		cell.id		   = XMLPRQty[loop].childNodes[0].nodeValue;
		if(txtPRNo!="")
		{
			cell.innerHTML = "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLPRQty[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"calculatePRRowValue(this);\"/>";
		}
		else
		{
			cell.innerHTML = "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLPRQty[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"/>";
		}
		
		
		var cell = row.insertCell(4);
		cell.className ="normalfntMid";
		if(txtPRNo!="")
		{
			cell.innerHTML = "<input type=\"text\" disabled=\"disabled\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLUnitPrice[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"calculateRowValue(this);\"/>";
		}
		else
		{
			cell.innerHTML = "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+XMLUnitPrice[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" />";
		}
		
		
		var cell = row.insertCell(5);
		cell.className ="normalfntMid";
		if(txtPRNo!="")
			cell.id	   = XMLPRGLId[loop].childNodes[0].nodeValue;
		else
			cell.id	   = XMLGLAllowId[loop].childNodes[0].nodeValue;
		
		cell.innerHTML = XMLGLId[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(6);
		cell.className ="normalfnt";
		cell.innerHTML = XMLGLDes[loop].childNodes[0].nodeValue;

		tblMaterial.rows[loop+1].cells[5].childNodes[0].value 	  = XMLPRGLId[loop].childNodes[0].nodeValue;
		//tblMaterial.rows[loop+1].cells[6].innerHTML = XMLPRGLDes[loop].childNodes[0].nodeValue;
		cell.id		   = $('#'+tblMaterial.rows[loop+1].cells[5].childNodes[0].id+' option:selected').text();
	*/
		
	}
}
	
function CheckAll(obj)
{
	var tblMaterial = document.getElementById("tblMaterial");
	if(obj.checked)
		var check = true;
	else
		var check = false;
	for(loop=1;loop<tblMaterial.rows.length;loop++)
	{
		tblMaterial.rows[loop].cells[0].childNodes[0].checked = check;
	}
}
	
function textChange(text)
{
	loadMaterial();
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toLowerCase() == itemName.toLowerCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function addItemToMainTable()
{
	var chkSelect 	= false;
	var chkGLSelect = false;	
	var tblMain = document.getElementById("tblMain");
	var tblMaterial = document.getElementById("tblMaterial");
	var txtPRNo = document.getElementById("txtPRNo").value;	
	var strMain = document.getElementById("cboMainCategory").options[document.getElementById("cboMainCategory").selectedIndex].text;

	var tempText="";
	/*var costCenter = document.getElementById("cboCostCenter").value;
	if(costCenter == 'null')
	{
		alert("Please select 'Cost Center'");
		document.getElementById("cboCostCenter").focus();
		return false;
	}
*/
	for(var x=1;x<tblMaterial.rows.length;x++)
	{
		if(tblMaterial.rows[x].cells[0].childNodes[0].checked == true)
		{
			chkSelect = true;
			if(txtPRNo=="")
			{
				/*if(tblMaterial.rows[x].cells[5].id =="")
				{
					alert("Please select GL Code");
					tblMaterial.rows[x].cells[5].childNodes[0].focus();
					return;
				}*/
			}
		}
	}
	if(chkSelect == false)
	{
		alert("No record to save.PLease select at least one item.");
		return;
	}
	
	var strCostCenter = $("#cboCostCenter option:selected").text();
	
	for (var i = 1; i < tblMaterial.rows.length; i++ )
	{
		if(tblMaterial.rows[i].cells[0].childNodes[0].checked == true)
		{
			//if(!isItemAvailable(parseInt(tblMaterial.rows[i].cells[1].id,costCenter)))
			{
				var url  = 'generalPo-xml.php?id=loadMaterialToMainGrid';
					url += '&txtPRNo='+txtPRNo;
					url += '&matDetialID='+tblMaterial.rows[i].cells[1].id;
				var xml_http_obj	= $.ajax({url:url,async:false});

				var matDetailID 	= xml_http_obj.responseXML.getElementsByTagName('intItemSerial')[0].childNodes[0].nodeValue;
				var matItem     	= xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[0].childNodes[0].nodeValue;
				var strunit 		= xml_http_obj.responseXML.getElementsByTagName('strUnit')[0].childNodes[0].nodeValue;
				var qty 			= tblMaterial.rows[i].cells[3].childNodes[0].value;
				var Unitprice 		= tblMaterial.rows[i].cells[4].childNodes[0].value;
				var mainCategory 	= xml_http_obj.responseXML.getElementsByTagName('mainCategory')[0].childNodes[0].nodeValue;
				var value 			= xml_http_obj.responseXML.getElementsByTagName('value')[0].childNodes[0].nodeValue;
				var disPercentage	= xml_http_obj.responseXML.getElementsByTagName('DiscountPer')[0].childNodes[0].nodeValue;
//BEGIN -  PR details
				var intPRno 		= xml_http_obj.responseXML.getElementsByTagName('intPRNo')[0].childNodes[0].nodeValue;
				var intPRyear 		= xml_http_obj.responseXML.getElementsByTagName('intPRYear')[0].childNodes[0].nodeValue;
				var strPRno 		= xml_http_obj.responseXML.getElementsByTagName('strPRNo')[0].childNodes[0].nodeValue;
				var suppId 			= xml_http_obj.responseXML.getElementsByTagName('SuppId')[0].childNodes[0].nodeValue;
				//var GLId =  tblMaterial.rows[i].cells[5].id;
				//var GLCode =  tblMaterial.rows[i].cells[6].id;
								
				if(suppId != ''){
					document.getElementById('cboSupplier').value=suppId;
					//document.getElementById('cboSupplier').disabled= true;
				}
				pub_curr 			= xml_http_obj.responseXML.getElementsByTagName('CurrId')[0].childNodes[0].nodeValue;
				
				if(pub_curr!="0")
				{
					document.getElementById('cboCurrency').value=pub_curr;
					//document.getElementById('cboCurrency').disabled= true;
				}
//END -  PR details
				var booCheck = false;
				for(var j=1;j < tblMain.rows.length; j++ )
				{
					if(tblMain.rows[j].cells[$main11].childNodes[0].nodeValue==matDetailID && tblMain.rows[j].cells[$main11].id==intPRyear && tblMain.rows[j].cells[$main12].id==intPRno && tblMain.rows[j].cells[$main13].id==costCenter)
					{
						booCheck = true;
					}	
				}
				if(!booCheck)
				{
					createMainItemGrid(matDetailID,matItem,'',strunit,qty,Unitprice,mainCategory,value,disPercentage,'',intPRno,intPRyear,strPRno,strCostCenter,/*costCenter,txtPRNo,GLId,GLCode,*/'');
					calculatePOValue();
					calculateT();
				}
			} //end isItemAvailable
		}
	}
	//CloseGenPOPopUp('popupLayer1');
	if(pub_curr !=0)
		document.getElementById('cboCurrency').onchange();
}

//BEGIN - Add details to main grid from the item popup.
function createMainItemGrid(matDetailID,matItem,strremark,strunit,qty,Unitprice,mainCategory,value,disPercentage,intfixed,intPRno,intPRyear,strPRno,costCenter,/*costCenterID,PRNo,GLId,GLCode,*/EXRate)
{
	var tbl 			= $('#tblMain tbody');
	var lastRow 		= $('#tblMain tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	row.className 		= 'bcgcolor-tblrowWhite';
	
	var rowCell 	  	= row.insertCell($main0);
	rowCell.className 	= "normalfntMid";
	rowCell.height		= 20;
	rowCell.innerHTML 	= "<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" />";
	
	var rowCell 	  	= row.insertCell($main1);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML	= mainCategory;
	
	var rowCell 	  	= row.insertCell($main2);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML	= matItem;
	
	var rowCell 	  	= row.insertCell($mainRemark);
	rowCell.className 	= "normalfntMid";
	rowCell.id			= strremark;
	rowCell.innerHTML	=  "<img src= \"../../images/edit.png\" onClick=\"addRemarks(this.parentNode,this.parentNode.parentNode.rowIndex);\" alt=\"add\" />";
	
	var rowCell 	  	= row.insertCell($main4);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML	= strunit;
	
	var rowCell 	  	= row.insertCell($main5);
	rowCell.className 	= "normalfntRite";
	/*if(PRNo=="" || PRNo==0)
		rowCell.id 	= "";
	else*/
	rowCell.id = qty;
	rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+qty+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"calculateRowValue(this);\" onClick=\"selectTextBoxContent(this);\" />";
	
	var rowCell 	  	= row.insertCell($main6);
	rowCell.className 	= "normalfntRite";
	//rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+Unitprice+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"calculateRowValue(this);\" "+(Unitprice=='0' ? "":'disabled="disabled"')+" onClick=\"selectTextBoxContent(this);\"/>";
	rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:70px; text-align:right\" value=\""+Unitprice+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  onkeyup=\"calculateRowValue(this);\" onClick=\"selectTextBoxContent(this);\"/>";
	
	var rowCell 	  	= row.insertCell($maxUnit);
	rowCell.className 	= "normalfntRite";
	if(EXRate=="")
		rowCell.innerHTML	= Unitprice;
	else
		rowCell.innerHTML	= EXRate;
	
	var rowCell 	  	= row.insertCell($main7);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML	= value;
	
	var rowCell 	  	= row.insertCell($main8);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:25px; text-align:right\"   onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" onkeyup=\"caculateDiscountValue(this);\" value=\""+disPercentage+"\" maxlength=\"2\"/>";
	
	var discountVal     = calDiscountVal(value,disPercentage);
	var rowCell 	  	= row.insertCell($main9);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= discountVal;
	
	var finalVal = calFinalVal(value,discountVal)
	var rowCell 	  	= row.insertCell($main10);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= finalVal;	
	
	var rowCell 	  	= row.insertCell($main11);
	rowCell.className 	= "normalfntMid";
	if(intfixed==1)
		rowCell.innerHTML 	= "<input type=\"checkbox\"  checked=\"checked\"/>";
	else
		rowCell.innerHTML 	= "<input type=\"checkbox\" />";
	
	var rowCell 	  	= row.insertCell($main12);
	rowCell.className 	= "normalfntRite";
	rowCell.id			= intPRyear;
	rowCell.innerHTML 	= matDetailID;
	
	/*var PRNo = (strPRno == '' ? '&nbsp;' :strPRno);
	var rowCell 	  	= row.insertCell($main13);
	rowCell.className 	= "normalfnt";
	rowCell.id			= intPRno;
	rowCell.innerHTML 	= PRNo;
	
	var rowCell 	  	= row.insertCell($main14);
	rowCell.className 	= "normalfnt";
	rowCell.id			= costCenterID
	rowCell.innerHTML 	= costCenter;
	
	var rowCell 	  	= row.insertCell($main15);
	rowCell.className 	= "normalfntMid";
	rowCell.id			= GLId;
	rowCell.innerHTML 	= GLCode;*/
}
//END - Add details to main grid from the item popup.

function isItemAvailable(matDetailId,costCenter)
{
var tbl = document.getElementById('tblMain');
	for (var a = 1; a < tbl.rows.length ; a++)
	{	 
		var gridItemId 		= parseInt(tbl.rows[a].cells[$main12].innerHTML);
		var gridCostCenterId = tbl.rows[a].cells[$main14].id;
		if (gridItemId== matDetailId && costCenter==gridCostCenterId)
		{	
			alert("Item is allready added to line "+a);
			return true; 
		}	 
	}
  return false;
}
 
function caculateDiscountValue(obj)
{
	var dblvalue 	=  obj.parentNode.parentNode.cells[$main7].innerHTML;
	var discountPct = obj.value;
	var val 		= calDiscountVal(dblvalue,discountPct);	
	obj.parentNode.parentNode.cells[$main9].innerHTML = RoundNumbers(val,4);			
	obj.parentNode.parentNode.cells[$main10].innerHTML = RoundNumbers(calFinalVal(dblvalue,val),4);
	calculateT();	
}

function calculateRowValue(objText)
{
	if(objText.parentNode.parentNode.cells[$main5].id!="")
	{
		if(objText.parentNode.parentNode.cells[$main5].lastChild.value>objText.parentNode.parentNode.cells[$main5].id)
		{
			objText.parentNode.parentNode.cells[$main5].lastChild.value=objText.parentNode.parentNode.cells[$main5].id;
		}
	}
	var dblQty 			=  objText.parentNode.parentNode.cells[$main5].lastChild.value;
	var dblUnitPrice 	=  objText.parentNode.parentNode.cells[$main6].lastChild.value;
	var dblTotal 		=  dblQty * dblUnitPrice;
	objText.parentNode.parentNode.cells[$main7].lastChild.nodeValue = RoundNumbers(dblTotal,4);
	
	var dblvalue 		=  objText.parentNode.parentNode.cells[$main7].innerHTML;
	var discountPct 	= objText.parentNode.parentNode.cells[$main8].lastChild.value;
	var val			 	= calDiscountVal(dblvalue,discountPct);
	objText.parentNode.parentNode.cells[$main9].lastChild.value 	= RoundNumbers(val,4);	
	objText.parentNode.parentNode.cells[$main10].innerHTML 			= RoundNumbers(calFinalVal(dblvalue,val),4);
	calculateT();
}

function calDiscountVal(dblvalue,discountPct)
{
	var value 		= parseFloat(dblvalue)*parseFloat(discountPct)/100;
	var newnumber 	= Math.round(value*Math.pow(10,4))/Math.pow(10,4);
	newnumber 		= isNaN(newnumber) == true?0:newnumber;
	return newnumber.toFixed(4);
}

function calFinalVal(dblvalue,val)
{
	var finalVal 	= parseFloat(dblvalue)-parseFloat(val);
	var rondVal 	= Math.round(finalVal*Math.pow(10,4))/Math.pow(10,4);
	rondVal 		= isNaN(rondVal) == true?0:rondVal;
	return rondVal.toFixed(4);
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo 	= objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo);
}

function SetDetails(obj)
{
	
	var url  = "generalPo-xml.php?";
	url += "&id=GetSupplierRelatedDetails";
	url += "&supId="+obj.value;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLCurrencyId	= htmlobj.responseXML.getElementsByTagName("CurrencyId")[0].childNodes[0].nodeValue;
	var XMLPaymentMode	= htmlobj.responseXML.getElementsByTagName("PaymentMode")[0].childNodes[0].nodeValue;
	var XMLPaymentTerm	= htmlobj.responseXML.getElementsByTagName("PaymentTerm")[0].childNodes[0].nodeValue;
	
	document.getElementById('cboCurrency').value = XMLCurrencyId;
	document.getElementById('cboPayMode').value = XMLPaymentMode;
	document.getElementById('cboPayTerms').value = XMLPaymentTerm;
	pub_curr = XMLCurrencyId;
	
	//Enter supplier name if supplier selected as 'sundry'
	
	var strSupplierName = ($("#cboSupplier option:selected").text().toUpperCase());
	
	var strPrefix = strSupplierName.substr(0,6);
	
	if(strPrefix == 'SUNDRY'){
		document.getElementById('tr_sundry').style.display = 'table-row';		
	}else{
		document.getElementById('tr_sundry').style.display = 'none';	
	}
	
}

function dateDisable(objChk)
{
	if(!objChk.checked)
	{
		document.getElementById("deliverydateDD").disabled= true;
		document.getElementById("deliverydateDD").value="";
	}
	else
	{
		document.getElementById("deliverydateDD").disabled=false;
		document.getElementById("deliverydateDD").value ="" ;
	}
}

function calculateT()
{
	var tblMain  = document.getElementById("tblMain");
	var dblT = 0;
	for(var i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[$main4].lastChild.value=="")
			tblMain.rows[i].cells[$main4].lastChild.value=0;
			
		if(tblMain.rows[i].cells[$main5].lastChild.value=="")
			tblMain.rows[i].cells[$main5].lastChild.value=0;
			
		dblT = dblT+(parseFloat(tblMain.rows[i].cells[$main10].innerHTML))		
	}
	document.getElementById("txtPoAmount").value = Math.round(dblT*Math.pow(10,4))/Math.pow(10,4);
}

//BEGIN - Validate bulk po compulsory fild before save and return the boolean value to save main function true/false
function validatePoInterface()
{	
	if(document.getElementById("cboSupplier").value=="")
	{
		alert("Please select the \"Supplier\".");
		document.getElementById('cboSupplier').focus();
		return false;
	}	
	else if(document.getElementById("cboCurrency").value=="")
	{
		alert("Please select the \"Currency\".");
		document.getElementById('cboCurrency').focus();
		return false;
	}
	else if(document.getElementById("deliverydateDD").value=="")
	{
		alert("Please enter the \"Delivery Date\".");
		showCalendar("deliverydateDD", '%d/%m/%Y');
		return false;
	}
	else if (validDate()==false) 
	{
		alert("Deliver Date is invalid.\nPO date cannot exceed Delivery date.");
		return false;
	}
	else if(document.getElementById("cboDeliverto").value=="")
	{
		alert("Please select the \"Deliver to Company\".");
		document.getElementById("cboDeliverto").focus();
		return false;
	}
	else if(document.getElementById("cboInvoiceTo").value=="")
	{
		alert("Please select the \"Invoice to Company\".");
		document.getElementById("cboInvoiceTo").focus();
		return false;
	}	
	else if(document.getElementById("cboPayMode").value=="")
	{
		alert("Please select the \"Payment Mode\".");
		document.getElementById('cboPayMode').focus();
		return false;
	}
	else if(document.getElementById("cboPayTerms").value=="")
	{
		alert("Please select the \"Payment Term\".");
		document.getElementById('cboPayTerms').focus();
		return false;
	}
	else if(document.getElementById('tblMain').rows.length<=1)
	{
		alert("No items appear to save.\nPlease add items and try.")
		return false;
	}
	
	/*var tbl = document.getElementById("tblMain");
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[$main14].id == 'null')
		{
			alert("Please select 'Cost Center'");
			tbl.rows[loop].cells[$main14].childNodes[0].focus();
			return false;
		}
	}*/
	
return true;
}
//END - Validate bulk po compulsory fild before save and return the boolean value to save main function true/false

function save()
{
	if(validatePoInterface()==false)
		return ;
		
	saveBulkGrnHeader();
}

function saveBulkGrnHeader()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	
	if( text1 == ""){
		var intGenPONo		= "";
		var intYear			= "";
	}
	else
	{
		var intGenPONo		= text1//(text1).split("/")[1];
		var intYear			=  document.getElementById("cboPOYearBox").value//(text1).split("/")[0];
	}
	
	var intSupplierID		= document.getElementById("cboSupplier").value;
	var strRemarks			= "";
	var dtmDate				= document.getElementById("podate").value;
	var dtmDeliveryDate		= (document.getElementById("deliverydateDD").value).split("/")[2]+"-"+(document.getElementById("deliverydateDD").value).split("/")[1]+"-"+(	document.getElementById("deliverydateDD").value).split("/")[0];	
	var strCurrency			= document.getElementById("cboCurrency").value;
	var dblTotalValue		= document.getElementById("txtPoAmount").value;	
	var intInvoiceComp		= document.getElementById("cboInvoiceTo").value;
	var intDeliverTo		= document.getElementById("cboDeliverto").value;	
	var strPayTerm			= document.getElementById("cboPayTerms").value;
	var intPayMode			= document.getElementById("cboPayMode").value;
	var shipmentMode		= document.getElementById("cboshipment").value;
	var shipmentTerms		= document.getElementById("cboshipmentTerm").value;	
	var strInstructions		= URLEncode(document.getElementById("txtIntroduction").value);
	if(document.getElementById('txtSundryName')){
		var strSupplierName = document.getElementById('txtSundryName').value;	
	}

	var url  = "generalPo-db.php?id=saveBulkPoHeader";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		url += "&intSupplierID="+intSupplierID;
		url += "&strRemarks="+strRemarks;
		url += "&dtmDate="+dtmDate;
		url += "&dtmDeliveryDate="+dtmDeliveryDate;
		url += "&strCurrency="+strCurrency;
		url += "&dblTotalValue="+dblTotalValue;		
		url += "&intInvoiceComp="+intInvoiceComp;
		url += "&intDeliverTo="+intDeliverTo;
		url += "&strPayTerm="+strPayTerm;
		url += "&intPayMode="+intPayMode;
		url += "&shipmentMode="+shipmentMode;
		url += "&shipmentTerms="+shipmentTerms;		
		url += "&strInstructions="+strInstructions;
		url += "&strSundrySypplier="+strSupplierName;
	var xml_http_obj = $.ajax({url:url,async:false});		
	
	var bulkPoNo = trim(xml_http_obj.responseText);
	if(bulkPoNo!="Saving-Error")
	{		
		saveBulkGrnDetails(bulkPoNo);
	}
	else
	{
		alert("Error : \nGeneral Purchase order header not saved");
		return;
	}
}

function saveBulkGrnDetails(pono)
{	
	var tblGrn 				= document.getElementById("tblMain");	
	pub_intxmlHttp_count 	= tblGrn.rows.length-1;
	var	intGenPONo			= pono.split("/")[1];
	var intYear				= pono.split("/")[0];	
	document.getElementById("txtBulkPoNo").value = intGenPONo; 
	var count=0;
	for(var loop=1;loop<tblGrn.rows.length;loop++)
	{
		var	intMatDetailID		= tblGrn.rows[loop].cells[$main12].lastChild.nodeValue;
		var strRemark			= tblGrn.rows[loop].cells[$mainRemark].id;
		var strUnit				= tblGrn.rows[loop].cells[$main4].lastChild.nodeValue;
		var dblUnitPrice		= tblGrn.rows[loop].cells[$main6].lastChild.value;
		var dblQty				= tblGrn.rows[loop].cells[$main5].lastChild.value;
		var dblPending			= tblGrn.rows[loop].cells[$main5].lastChild.value;
		var dblDisPcnt			= tblGrn.rows[loop].cells[$main8].lastChild.value; 
		var intFixed			= (tblGrn.rows[loop].cells[$main11].lastChild.checked==true ? 1:0); 
		var strDeliveryDates	= document.getElementById("deliverydateDD").value;
		var intDeliverTo 		= document.getElementById("cboDeliverto").value;
		//var intPRNo				= tblGrn.rows[loop].cells[$main13].id
		//var intPRYear			= tblGrn.rows[loop].cells[$main12].id
		//var costCenterID 		= tblGrn.rows[loop].cells[$main14].id
		//var GLId		 		= tblGrn.rows[loop].cells[$main15].id
		var maxExchRate			= tblGrn.rows[loop].cells[$maxUnit].lastChild.nodeValue;
		
		var url  = "generalPo-db.php?id=saveBulkPoDetails";
			url += "&intGenPONo="+intGenPONo;
			url += "&intYear="+intYear;
			url += "&intMatDetailID="+intMatDetailID;
			url += "&strRemark="+strRemark;
			url += "&strUnit="+strUnit;
			url += "&dblUnitPrice="+dblUnitPrice;
			url += "&dblQty="+dblQty;
			url += "&dblPending="+dblPending;
			url += "&dblDisPcnt="+dblDisPcnt;
			url += "&intFixed="+intFixed;
			url += "&strDeliveryDates="+strDeliveryDates;
			url += "&intDeliverTo="+intDeliverTo;
			//url += "&intPRNo="+intPRNo;
			//url += "&intPRYear="+intPRYear;
			url += "&count="+loop;	
			//url += "&costCenterID="+costCenterID;
			//url += "&GLId="+GLId;
			url += "&maxExchRate="+maxExchRate;
		var xml_http_obj	=$.ajax({url:url,async:false});
	
		if(xml_http_obj.responseText == 1)
			count++;	
	}
	
	if(count == tblGrn.rows.length-1)
	{
		alert("General Purchase Order No " +intYear+ "/"+ intGenPONo + " saved successfully.");
		document.getElementById('txtBulkPoNo').disabled = true;
		if(confirmGPO)
				document.getElementById('butConform').style.display = 'inline';					
	}
	else
	{
		alert( "General PO details saving error....");
		document.getElementById("txtBulkPoNo").value = '';
	}		
}

function loadBulkPoForm(intGenPONo,intYear,intStatus)
{
	var url 	 	= "generalPo-xml.php?id=checkPRAvailable&GPONo="+intGenPONo+"&GPYear="+intYear;
	var http_obj 	= $.ajax({url:url,async:false});
	var PRAvailable = http_obj.responseXML.getElementsByTagName('Validate')[0].childNodes[0].nodeValue;
	
	if(PRAvailable=="TRUE")
	{
		document.getElementById('cboCurrency').disabled = true;
		document.getElementById('cboSupplier').disabled = true;
	}
	else
	{
		document.getElementById('cboCurrency').disabled = false;
		document.getElementById('cboSupplier').disabled = false;
	}
	
	if ((intGenPONo!=0)||(intYear!=0))
	{		
		if(intStatus==1)
		{
			document.getElementById('butSave').style.display = 'none';
			document.getElementById('butConform').style.display = 'none';
		}
		else if(intStatus==10)
		{
			document.getElementById('butConform').style.display = 'none';
			document.getElementById("butCancel").style.display = 'none';
		}
		else if(intStatus==0)
		{
			document.getElementById("butCancel").style.display = 'none';
			
			if(confirmGPO)
				document.getElementById('butConform').style.display = 'inline';
				
		}
		else if(intStatus==13)
		{
			intStatus=1;
			var CopyToStat=1;
			document.getElementById('butSave').style.display = 'inline';
			document.getElementById("butConform").style.display="none";
			document.getElementById("txtBulkPoNo").value="";
			document.getElementById("cboPOYearBox").value="";			
		}
		clearItemTable('tblMain');
		loadBulkGenPOHeader(intGenPONo,intYear,intStatus,CopyToStat);
		loadGenPOdetails(intGenPONo,intYear,intStatus);
	}	
	else
	{
		document.getElementById('butConform').style.display = 'none';
		document.getElementById("butCancel").style.display = 'none';
		document.getElementById("butMail").style.display = 'none';
	}
}

function loadBulkGenPOHeader(intGenPONo,intYear,intStatus,CopyToStat)
{	
	var url  = "generalPo-xml.php?id=loadBulkPoHeader";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		url += "&intStatus="+intStatus;
		url += "&CopyToStat="+CopyToStat;
	var xml_http_obj	=$.ajax({url:url,async:false});
		
	if(xml_http_obj.responseXML.getElementsByTagName("*").length == 1)
	{
		alert('Sorry, No pending PO available for given PO Number. Try with another.');
		newPage();
		return
	}
				
	var XMLstrBulkPONo = xml_http_obj.responseXML.getElementsByTagName("intGenPONo");
	var XMLintYear = xml_http_obj.responseXML.getElementsByTagName("intYear");
	var XMLintSupplierID = xml_http_obj.responseXML.getElementsByTagName("intSupplierID");
	var XMLdtmDate = xml_http_obj.responseXML.getElementsByTagName("dtmDate");
	var XMLdtmDeliveryDate = xml_http_obj.responseXML.getElementsByTagName("dtmDeliveryDate");
	var XMLstrCurrency = xml_http_obj.responseXML.getElementsByTagName("strCurrency");
	var XMLintStatus = xml_http_obj.responseXML.getElementsByTagName("intStatus");
	var XMLintCompId = xml_http_obj.responseXML.getElementsByTagName("intCompId");
	var XMLintDeliverTo = xml_http_obj.responseXML.getElementsByTagName("intDeliverTo");
	var XMLstrPayTerm = xml_http_obj.responseXML.getElementsByTagName("strPayTerm");
	var XMLintPayMode = xml_http_obj.responseXML.getElementsByTagName("intPayMode");
	var XMLstrInstructions = xml_http_obj.responseXML.getElementsByTagName("strInstructions");
	var XMLintInvoiceComp = xml_http_obj.responseXML.getElementsByTagName("intInvoiceComp");
			
	document.getElementById("txtBulkPoNo").value= XMLstrBulkPONo[0].childNodes[0].nodeValue;
	document.getElementById("cboPOYearBox").value = XMLintYear[0].childNodes[0].nodeValue
	var objDate = XMLdtmDate[0].childNodes[0].nodeValue.split(" ");
	document.getElementById("podate").value = objDate[0] ;
	document.getElementById("cboSupplier").value = XMLintSupplierID[0].childNodes[0].nodeValue;
			
	var d = XMLdtmDeliveryDate[0].childNodes[0].nodeValue;
		var d1 = "";
		d = d.split("-");
		d1= d[2].substring(0,2)+"/"+d[1]+"/"+d[0];
	document.getElementById("deliverydateDD").value = d1 ;
	document.getElementById("checkbox").checked = 1;
	document.getElementById("txtIntroduction").value = XMLstrInstructions[0].childNodes[0].nodeValue;
	document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;
	document.getElementById("cboInvoiceTo").value = XMLintInvoiceComp[0].childNodes[0].nodeValue;
	document.getElementById("cboDeliverto").value = XMLintDeliverTo[0].childNodes[0].nodeValue;
	document.getElementById("cboPayMode").value = XMLintPayMode[0].childNodes[0].nodeValue;
	document.getElementById("cboPayTerms").value = XMLstrPayTerm[0].childNodes[0].nodeValue;
	//document.getElementById("cboCurrency").onchange();
	document.getElementById("txtPoAmount").value = "0";
				
	var XMLCopyToStat = xml_http_obj.responseXML.getElementsByTagName("CopyToStat");
	CopyToStat=XMLCopyToStat[0].childNodes[0].nodeValue
	if(CopyToStat==1){
		document.getElementById("txtBulkPoNo").value="";
		document.getElementById("cboPOYearBox").value="";
	}	
}

function loadGenPOdetails(intGenPONo,intYear,intStatus)
{	
	var url  = "generalPo-xml.php?id=loadBulkPoDetails";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		url += "&intStatus="+intStatus;
	var xml_http_obj	=$.ajax({url:url,async:false});	
	var tblMain = document.getElementById("tblMain");
	
	var XMLstrMainCategory = xml_http_obj.responseXML.getElementsByTagName("strMainCategory");
	var XMLitemDescription = xml_http_obj.responseXML.getElementsByTagName("itemDescription");
	var XMLstrRemark	   = xml_http_obj.responseXML.getElementsByTagName("strRemark");
	var XMLstrUnit		   = xml_http_obj.responseXML.getElementsByTagName("strUnit");
	var XMLdblUnitPrice    = xml_http_obj.responseXML.getElementsByTagName("dblUnitPrice");
	var XMLdblExchRate     = xml_http_obj.responseXML.getElementsByTagName("dblExchRate");
	var XMLdblQty 		   = xml_http_obj.responseXML.getElementsByTagName("dblQty");
	var XMLintMatDetailID  = xml_http_obj.responseXML.getElementsByTagName("intMatDetailID");
	var XMLValue		   = xml_http_obj.responseXML.getElementsByTagName("dblValue");
	var XMLPct			   = xml_http_obj.responseXML.getElementsByTagName("dblDiscountPct");
	var XMLFixed		   = xml_http_obj.responseXML.getElementsByTagName("intFixed");
	/*var XMLPRNo 		   = xml_http_obj.responseXML.getElementsByTagName("intPRNo");
	var XMLPRYear 		   = xml_http_obj.responseXML.getElementsByTagName("intPRYear");	
	var XMLstrPRNo 		   = xml_http_obj.responseXML.getElementsByTagName("strPRNo");
	var xmlCostCenter	   = xml_http_obj.responseXML.getElementsByTagName("costCenter");
	var xmlCostCenterID	   = xml_http_obj.responseXML.getElementsByTagName("costCenterID");
	var xmlGLCode		   = xml_http_obj.responseXML.getElementsByTagName("GLCode");
	var xmlGLId			   = xml_http_obj.responseXML.getElementsByTagName("GLId");*/
	
	for(var n = 0; n < XMLintMatDetailID.length ; n++) 
	{
		var matDetailID     = XMLintMatDetailID[n].childNodes[0].nodeValue;
		var matItem 		= XMLitemDescription[n].childNodes[0].nodeValue;
		var strremark 		= XMLstrRemark[n].childNodes[0].nodeValue;
		var strunit 		= XMLstrUnit[n].childNodes[0].nodeValue;
		var qty 			= XMLdblQty[n].childNodes[0].nodeValue;
		var Unitprice 		= XMLdblUnitPrice[n].childNodes[0].nodeValue;
		var dblExchRate		= XMLdblExchRate[n].childNodes[0].nodeValue;
		var mainCategory 	= XMLstrMainCategory[n].childNodes[0].nodeValue;
		var value 			= XMLValue[n].childNodes[0].nodeValue;
		var disPercentage 	= XMLPct[n].childNodes[0].nodeValue;
		var intfixed		= XMLFixed[n].childNodes[0].nodeValue;
		var intPRno  		= 0;// XMLPRNo[n].childNodes[0].nodeValue;
		var intPRyear  		= 0;//XMLPRYear[n].childNodes[0].nodeValue;
		var strPRno  		= 0;//XMLstrPRNo[n].childNodes[0].nodeValue;
		var costCenter		= 0;//xmlCostCenter[n].childNodes[0].nodeValue;
		var costCenterID	= 0;//xmlCostCenterID[n].childNodes[0].nodeValue;
		var GLCode		    = 0;//xmlGLCode[n].childNodes[0].nodeValue;
		var GLId			= 0;//xmlGLId[n].childNodes[0].nodeValue;
		
		createMainItemGrid(matDetailID,matItem,strremark,strunit,qty,Unitprice,mainCategory,value,disPercentage,intfixed,intPRno,intPRyear,strPRno,costCenter,costCenterID,intPRno,GLId,GLCode,dblExchRate);
	}
	calculateT();
}

function newPage()
{
	clearItemTable('tblMain');
	document.getElementById('cboSupplier').focus();
	$("#frmGenPoMain")[0].reset();
	document.getElementById('butConform').style.display = 'none';	
	document.getElementById('cboCurrency').disabled = false;
	document.getElementById('cboSupplier').disabled = false;
}

function cancel()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	if( text1 == "")
	{
		alert("No General PoNo appear to Cancel.");
		return;
	}
	if(confirm("Are you sure you want to Cancel General PoNo :"+text1));
	{
		var intGenPONo			= (text1).split("/")[1];
		var intYear				= (text1).split("/")[0];
		
		var url  = "generalPo-db.php?id=cancelBulkPo";
			url += "&intGenPONo="+intGenPONo;
			url += "&intYear="+intYear;
		htmlobj  = $.ajax({url:url,async:false});
		saveBulPoCancel(htmlobj);
	}
}

function saveBulPoCancel(htmlobj)
{
	var intCancel = htmlobj.responseText;
	if(intCancel == 1)
	{
		alert("General Po is Canceled");
	}
	else if(intCancel.length > 1)
	{
		var grnExistLst = intCancel;
		alert("Can not cancel, GRN(s) exist ! :" + grnExistLst);
	}
}

function GeneralPoConfirmReport()
{
	if(document.getElementById("txtBulkPoNo").value=="")
	{
		alert("No General PoNo to view.");
		return;
	}
	document.getElementById('butConform').style.display = 'none';	
	window.open("genaralpoconfirmation.php?bulkPoNo=" + document.getElementById("txtBulkPoNo").value + "&intYear=" + document.getElementById("cboPOYearBox").value,'frmGenPoMain');
}

function GeneralPoReport($chemperid)
{
	var chemperid= $chemperid;
	if(document.getElementById("txtBulkPoNo").value=="")
	{
		alert("No General PoNo to view.");
		return;
	}
	window.open("reportpo.php?chemperid="+ chemperid +"&bulkPoNo=" + document.getElementById("txtBulkPoNo").value + "&intYear=" + document.getElementById("cboPOYearBox").value,'frmGenPoMain');
}

function trim(str)
{
	return ltrim(rtrim(str, ' '), ' ' );
}

function delRow(objDel)
{
	var tblTable = 	document.getElementById("tblMain");
	
	var grnIndexNo		 =objDel.parentNode.parentNode.parentNode.id;
	tblTable.deleteRow(objDel.parentNode.parentNode.parentNode.rowIndex);
	
	tblTable		= 	document.getElementById("tblMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		if(tblTable.rows[loop].id==grnIndexNo){
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
		}
	}
}

function checkitem(objRatio)
{
	pub_matNo = objRatio.parentNode.parentNode.parentNode.rowIndex;
}

function validDate()
{	
	var valDt = document.getElementById("deliverydateDD").value;
	var poDt = document.getElementById("podate").value;
	var poDtY = poDt.substr(0,4);
	var poDtM = poDt.substr(5,2);
	var poDtD = poDt.substr(8,2);
	var poDtYMD = new Date(poDtY + "/" + poDtM + "/" + poDtD );	
	var valDtY = valDt.substr(6,4);
	var valDtM = valDt.substr(3,2);
	var valDtD = valDt.substr(0,2);
	var valDtYMD = new Date(valDtY + "/" + valDtM + "/" + valDtD );
	
	if (poDtYMD > valDtYMD)
		return false;
	
return true;
}

function loadPO()
{
	if(document.getElementById('copyPOMain').style.visibility == "hidden")
		document.getElementById('copyPOMain').style.visibility = "visible";
	else
		document.getElementById('copyPOMain').style.visibility = "hidden";
}

function clearTable()
{
	var tblTable = 	document.getElementById("tblMain");
	tblTable		= 	document.getElementById("tblMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		tblTable.deleteRow(loop);
		binCount--;
		loop--;
	}
}

function textClear()
{
	document.getElementById("txtBulkPoNo").value = "";
}

function copyPO()
{
	var PONo 	= document.getElementById('cboCopyPopupPONo').value;
	var cpPO 	= PONo.split("/")[1];
	var cpYear 	= PONo.split("/")[0];

	clearTable();
	loadBulkPoForm(cpPO,cpYear,13);
	setTimeout("textClear();",100);
	document.getElementById('copyPOMain').style.visibility = "hidden";
}

function callClose()
{
	document.getElementById('copyPOMain').style.visibility == "hidden";
}

function closeCopyPo()
{
	document.getElementById('copyPOMain').style.visibility == "hidden";
}
function LoadCopyPopupPoNo(obj)
{
	var url="generalPo-xml.php?id=LoadCopyPopupPoNo&no="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboCopyPopupPONo').innerHTML = htmlobj.responseText;
}

function enableEnterSubmitLoadDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 13)
		loadMaterial();

}

function clearItemTable(tbl)
{	
	$("#"+tbl+" tr:gt(0)").remove();	
}

function ClearOptions(id)
{
	var selectObj 			= document.getElementById(id);
	var selectParentNode 	= selectObj.parentNode;
	var newSelectObj 		= selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj,selectObj);
	return newSelectObj;
}

function convertRates()
{
	var tbl = document.getElementById('tblMain');
	var curType = document.getElementById('cboCurrency').value;
	var rate = 	getExRate(curType);
	
	if(rate != 'NA')
	{
		document.getElementById('txtExRate').value = rate;
		pub_curr = document.getElementById("cboCurrency").value;		
	}
	else
	{
		document.getElementById('txtExRate').value = "";
	}

	var EXRate = document.getElementById('txtExRate').value;
	if(tbl.rows.length>1)
	{
		for(var i=1;i<tbl.rows.length;i++)
		{
			var maxUnitPrice  = parseFloat(tbl.rows[i].cells[$maxUnit].childNodes[0].nodeValue);
			if(EXRate!="")
			{
				var newUnitPrice  = parseFloat(maxUnitPrice*EXRate);
				tbl.rows[i].cells[$main6].childNodes[0].value = RoundNumbers(newUnitPrice,2);
			}
			else
			{
				tbl.rows[i].cells[$main6].childNodes[0].value = maxUnitPrice;
			}
			calculatePOValue();
			calculateT();
			
		}
	}
	
		
	
}
function loadSuppliers()
{
	var currency = document.getElementById("cboCurrency").value;
	var url  = "generalPo-db.php";
		url += "?id=getSuppliers";
		url += "&currency="+currency;	
	var xml_http_obj=$.ajax({url:url,async:false});
	document.getElementById("cboSupplier").innerHTML = xml_http_obj.responseXML.getElementsByTagName('suppliers')[0].childNodes[0].nodeValue;
}

function getExRate(curType)
{
	var url  = "generalPo-db.php";
		url += "?id=getExchangeRate";
		url += "&curType="+curType;	
	var xml_http_obj=$.ajax({url:url,async:false});
	var rate = xml_http_obj.responseXML.getElementsByTagName('Rate')[0].childNodes[0].nodeValue;	
	return rate;
}

function enableEnterSubmitLoadGenPODetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode == 13)
		viewGenPOdetails();				
}

function viewGenPOdetails()
{
	var GPONo 	 = document.getElementById("txtFindGenPO").value;
	var GPYear 	 = document.getElementById("cbofindGenPOYear").value;	
	loadBulkPoForm(GPONo,GPYear,0);
}
function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}	

////////// end of line 1598

function setCostCenterVal(obj)
{
	obj.parentNode.parentNode.cells[$main14].id = obj.value;
}

function selectTextBoxContent(obj)
{
	
	//document.getElementById("txtDetailsLike").select();
	obj.select();
}
function addRemarks(obj,rw)
{
	showBackGround('divBG',0);
	var url = "remarkpopup.php?Remark="+obj.id+"&rowNo="+rw;	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(426,86,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	document.getElementById('textareaRemark').focus();
}
function enterRemark(obj,evt,row)
{
	var tbl = document.getElementById('tblMain');
	 var keyCode = evt.keyCode || evt.which; 
	  if (keyCode == 13) 
	  {	  
			tbl.rows[row].cells[$mainRemark].id = obj.value;
			CloseGenPOPopUp('popupLayer1');
	  }
}
function loadGLDescription(obj,row)
{
	
	var url = "generalPo-xml.php?id=loadGLDescription&GLId="+obj.value;
	htmlobj = $.ajax({url:url,async:false});
	var tblMain = document.getElementById("tblMaterial");
	
	var XMLstrMainCategory = htmlobj.responseXML.getElementsByTagName("strGLDescription")[0].childNodes[0].nodeValue;
	tblMain.rows[row].cells[6].id = htmlobj.responseXML.getElementsByTagName("strGLCode")[0].childNodes[0].nodeValue;
	tblMain.rows[row].cells[6].innerHTML = XMLstrMainCategory;
	tblMain.rows[row].cells[5].id = obj.value;
	
}
function calculatePRRowValue(obj)
{
	if(obj.parentNode.parentNode.cells[3].id!="")
	{
		if(obj.parentNode.parentNode.cells[3].lastChild.value>obj.parentNode.parentNode.cells[3].id)
		{
			obj.parentNode.parentNode.cells[3].lastChild.value=obj.parentNode.parentNode.cells[3].id;
		}
	}
}
function calculatePOValue()
{
	var tbl = document.getElementById('tblMain');
	for(var i =1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[$main5].id!="")
		{
			if(tbl.rows[i].cells[$main5].lastChild.value>tbl.rows[i].cells[$main5].id)
			{
				tbl.rows[i].cells[$main5].lastChild.value=tbl.rows[i].cells[$main5].id;
			}
		}

		var dblQty 			=  tbl.rows[i].cells[$main5].lastChild.value;
		var dblUnitPrice 	=  tbl.rows[i].cells[$main6].lastChild.value;
		var dblTotal 		=  dblQty * dblUnitPrice;
		tbl.rows[i].cells[$main7].lastChild.nodeValue = RoundNumbers(dblTotal,4);
		
		var dblvalue 		= tbl.rows[i].cells[$main7].innerHTML;
		var discountPct 	= tbl.rows[i].cells[$main8].lastChild.value;
		var val			 	= calDiscountVal(dblvalue,discountPct);
		tbl.rows[i].cells[$main9].lastChild.value 	= RoundNumbers(val,4);	
		tbl.rows[i].cells[$main10].innerHTML 		= RoundNumbers(calFinalVal(dblvalue,val),4);
	}
}
