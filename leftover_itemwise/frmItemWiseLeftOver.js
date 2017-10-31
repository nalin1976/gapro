var mainArrayIndex 		= 0  ;
var Materials 			= [] ;
var pub_index			= 0  ;
var pub_mainRw 			= 0  ;
var validateCount		= 0  ;
var validateBinCount	= 0  ;
//BEGIN - Main Item Grid Column Variable
var m_del 				= 0  ;	// Delete button
var m_iDec 				= 1  ;	// Item Description
var m_order				= 2	 ;	// Order No
var m_bupo				= 3  ;	// Buyer PoNo
var m_co				= 4  ;	// Color
var m_size				= 5	 ;	// Size
var m_un				= 6  ; 	// Unit
var m_st				= 7	 ;	// Current Stock
var m_adjQty			= 8  ;  // Adjust Qty
var m_loc				= 9	 ;	// Add Location
var m_grnno				= 10 ;	// GRN No
var m_grntype			= 11 ;	// GRN Type
//END - Main Item Grid Column Variable

//BEGIN - Define Popup table columns id
var p_chkBox 			= 0  ;
var p_mc				= 1  ;
var p_sc				= 2  ;
var p_itemDe			= 3  ;
var p_buerpo			= 4  ;
var p_color				= 5  ;
var p_size				= 6	 ;
var p_unit				= 7	 ;
var p_stockBal			= 8	 ;
var p_grnno				= 9	 ;	// GRN No
var p_grntype			= 10 ;	// GRN Type
//END - Define Popup table columns id
$(document).ready(function() 
{
	var url					= 'frmItemWiseLeftOverxml.php?RequestType=load_OrderNo';
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
		
		$( "#txtOrderNo" ).autocomplete({
			source: pub_po_arr
		});	
});

$('#frmItemWiseLeftOverList').keypress(function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 13) {	  
				document.frmItemWiseLeftOverList.submit();
	  }
});
	
function CloseIWLOItem(LayerId)
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

function ClearForm()
{
	document.frmStyleStockAdjestment.submit();
}

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function CheckAll(obj,tbl)
{
	var tbl  = document.getElementById(tbl);
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[p_chkBox].childNodes[0].checked = check;
	}
}

function fix_header(tblName,w,h)
{
	$("#"+tblName+"").fixedHeader({
	width: w,height: h
	});
}

function SetOrderNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
	if(obj.value!='')
		SetStyleNo(obj.value);
}

function SetScNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
	if(obj.value!='')
		SetStyleNo(obj.value);
}

function SetStyleNo(orderId)
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLSetStyleNo";
		url += "&OrderId="+orderId;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyleNo').value = htmlobj.responseText;	
}

function LoadSubStore(obj)
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLLoadSubStore";
		url += "&MSId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSubStore').innerHTML = htmlobj.responseText;	
}

function LoadOrderAndSc(obj)
{
	LoadOrderNo(obj.value);
	LoadSCNo(obj.value);
}

function LoadOrderNo(styleNo)
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLLoadOrderNo";
		url += "&StyleNo="+URLEncode(styleNo);
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;	
}

function LoadSCNo(styleNo)
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLLoadSCNo";
		url += "&StyleNo="+URLEncode(styleNo);
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboScNo').innerHTML = htmlobj.responseText;	
}

function OpenItemPopUp()
{
	var styleId 	= document.getElementById('cboOrderNo');
	var mainStore 	= document.getElementById('cboMainStore');

	if(!Validate('OpenItemPopUp',styleId,mainStore))
		return;
			
	showBackGround('divBG',0);
	var url  = "popupitem.php?StyleId="+styleId.value;
		url += "&MainStore="+mainStore.value;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(850,400,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',850,388);
	var tblPopup = document.getElementById('tblPopItem');
	if(tblPopup.rows.length<=1){
		alert("Sorry!\nNo Records found in selected options.")
		CloseIWLOItem('popupLayer1');
	}
}

function LoadPopItems()
{
	
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLLoadPopItems";
		url += "&StyleId="+document.getElementById('cboOrderNo').value;
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
		url += "&MainStore="+document.getElementById('cboMainStore').value;
	htmlobj=$.ajax({url:url,async:false});
	ResponseCreatePopUpItemGrid(htmlobj);
}

function ResponseCreatePopUpItemGrid(htmlobj)
{
	var XMLMainCatID 	= htmlobj.responseXML.getElementsByTagName("MainCatID");
	var tbl 		= document.getElementById('tblPopItem');
	ClearTable('tblPopItem');
	for(loop=0;loop<XMLMainCatID.length;loop++)
	{
		var mainCatID 	= htmlobj.responseXML.getElementsByTagName("MainCatID")[loop].childNodes[0].nodeValue;
		var mainDesc 	= htmlobj.responseXML.getElementsByTagName("Description")[loop].childNodes[0].nodeValue;
		var subCatId 	= htmlobj.responseXML.getElementsByTagName("SubCatID")[loop].childNodes[0].nodeValue;
		var subDesc 	= htmlobj.responseXML.getElementsByTagName("CatName")[loop].childNodes[0].nodeValue;
		var matId 		= htmlobj.responseXML.getElementsByTagName("MatDetailId")[loop].childNodes[0].nodeValue;
		var itemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var buyerPoNo 	= htmlobj.responseXML.getElementsByTagName("BuyerPoNo")[loop].childNodes[0].nodeValue;
		var color 		= htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var size 		= htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var unit 		= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var stockBal 	= htmlobj.responseXML.getElementsByTagName("StockBal")[loop].childNodes[0].nodeValue;
		var grnYear 	= htmlobj.responseXML.getElementsByTagName("GrnYear")[loop].childNodes[0].nodeValue;
		var grnNo 		= htmlobj.responseXML.getElementsByTagName("GrnNo")[loop].childNodes[0].nodeValue;
		var grnType 	= htmlobj.responseXML.getElementsByTagName("GRNType")[loop].childNodes[0].nodeValue;
		var grnTypeId 	= htmlobj.responseXML.getElementsByTagName("GRNTypeId")[loop].childNodes[0].nodeValue;

		CreatePopUpItemGrid(mainCatID,mainDesc,subCatId,subDesc,matId,itemDesc,buyerPoNo,color,size,unit,stockBal,grnYear,grnNo,grnType,grnTypeId);
	}
}

function CreatePopUpItemGrid(mainCatID,mainDesc,subCatId,subDesc,matId,itemDesc,buyerPoNo,color,size,unit,stockBal,grnYear,grnNo,grnType,grnTypeId)
{
	var tbl = document.getElementById('tblPopItem');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
		
	var cell 		= row.insertCell(p_chkBox);
	cell.className 	= "normalfntMid";
	cell.id 		= mainCatID;
	cell.innerHTML 	= "<input name=\"checkbox\" type=\"checkbox\" />";
	
	var cell 		= row.insertCell(p_mc);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= mainDesc;
	
	var cell 		= row.insertCell(p_sc);
	cell.className 	= "normalfnt";
	cell.id 		= subCatId;
	cell.innerHTML 	= subDesc;
	
	var cell 		= row.insertCell(p_itemDe);
	cell.className 	= "normalfnt";
	cell.id 		= matId;
	cell.innerHTML 	= itemDesc;
	
	var cell 		= row.insertCell(p_buerpo);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= buyerPoNo;
	
	var cell 		= row.insertCell(p_color);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= color;
	
	var cell 		= row.insertCell(p_size);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= size;
	
	var cell 		= row.insertCell(p_unit);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= unit;
	
	var cell 		= row.insertCell(p_stockBal);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= stockBal;
	
	var cell 		= row.insertCell(p_grnno);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= grnYear+'/'+grnNo;
	
	var cell 		= row.insertCell(p_grntype);
	cell.className 	= "normalfnt";
	cell.id 		= grnTypeId;
	cell.innerHTML 	= grnType;
}
function AddToMainPage()
{
	var tbl 	= document.getElementById('tblPopItem');
	var orderId = document.getElementById('cboOrderNo').value;
	var orderNo = $("#cboOrderNo option:selected").text();;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[p_chkBox ].childNodes[0].checked)
		{
			var matId 		= tbl.rows[loop].cells[p_itemDe].id;
			var itemDesc	= tbl.rows[loop].cells[p_itemDe].childNodes[0].nodeValue;
			var buyerPoNo	= tbl.rows[loop].cells[p_buerpo].childNodes[0].nodeValue;
			var units		= tbl.rows[loop].cells[p_unit].childNodes[0].nodeValue;
			var color		= tbl.rows[loop].cells[p_color].childNodes[0].nodeValue;
			var size		= tbl.rows[loop].cells[p_size].childNodes[0].nodeValue;
			var stockBal	= tbl.rows[loop].cells[p_stockBal].childNodes[0].nodeValue;
			var grnNo		= tbl.rows[loop].cells[p_grnno].childNodes[0].nodeValue;
			var grnTypeId	= tbl.rows[loop].cells[p_grntype].id;
			var grnType		= tbl.rows[loop].cells[p_grntype].childNodes[0].nodeValue;
			CreadeMainGrid(orderId,orderNo,matId,itemDesc,buyerPoNo,units,color,size,parseFloat(stockBal),grnNo,grnTypeId,grnType)
		}
	}
	CloseIWLOItem('popupLayer1');
}

function CreadeMainGrid(orderId,orderNo,matId,itemDesc,buyerPoNo,units,color,size,stockBal,grnNo,grnTypeId,grnType)
{
	var booCheck = true;
	var tbl = document.getElementById('tblMain');
	for(mainLoop=1;mainLoop<tbl.rows.length;mainLoop++)
	{
		var mainMatId 		= tbl.rows[mainLoop].cells[m_iDec].id;
		var mainOrderId 	= tbl.rows[mainLoop].cells[m_order].id;
		var mainColor 		= tbl.rows[mainLoop].cells[m_co].childNodes[0].nodeValue;
		var mainSize 		= tbl.rows[mainLoop].cells[m_size].childNodes[0].nodeValue;
		var mainBuyerPo		= tbl.rows[mainLoop].cells[m_bupo].childNodes[0].nodeValue;
		var mainGRNNo		= tbl.rows[mainLoop].cells[m_grnno].childNodes[0].nodeValue;
		var mainGRNTypeId	= tbl.rows[mainLoop].cells[m_grntype].id;
		
		if(mainMatId==matId && mainOrderId==orderId && mainColor==color && mainSize==size && mainBuyerPo==buyerPoNo && mainGRNNo==grnNo && mainGRNTypeId==grnTypeId)
			booCheck = false;			
	}
	if(booCheck)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className 	= "bcgcolor-tblrowWhite";
		
		var cell 		= row.insertCell(m_del);
		cell.className 	= "normalfntMid";
		cell.setAttribute('height','20');
		cell.id			= 0;
		cell.innerHTML 	= "<img alt=\"add\" src=\"../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(m_iDec);
		cell.className 	= "normalfnt";
		cell.id 		= matId;
		cell.innerHTML 	= itemDesc;
		
		var cell 		= row.insertCell(m_order);
		cell.className 	= "normalfnt";
		cell.id			= orderId
		cell.innerHTML 	= orderNo;
		
		var cell 		= row.insertCell(m_bupo);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= buyerPoNo;
		
		var cell 		= row.insertCell(m_co);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= color;
		
		var cell 		= row.insertCell(m_size);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= size;
		
		var cell 		= row.insertCell(m_un);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= units;
		
		var cell 		= row.insertCell(m_st);
		cell.className 	= "normalfntRite";
		cell.innerHTML 	= stockBal;
		
		var cell 		= row.insertCell(m_adjQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\""+stockBal+"\" onkeyup=\"SetQtyToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_loc);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<img alt=\"add\" src=\"../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex + ")\">";
		
		var cell 		= row.insertCell(m_grnno);
		cell.className 	= "normalfntRite";
		cell.innerHTML 	= grnNo;
		
		var cell 		= row.insertCell(m_grntype);
		cell.className 	= "normalfnt";
		cell.id			= grnTypeId;
		cell.innerHTML 	= grnType;
		
		var details = [];
		details[0]  = matId; 			// Matdetail Id
		details[1]  = orderId; 			// Oreder Id
		details[2]  = color ;			// Color
		details[3]  = size; 			// Size
		details[4]  = units; 			// Unit
		details[6]  = stockBal; 				// Adjust Qty
		details[7]  = buyerPoNo; 		// Buyer PoNo
		details[8]  = grnNo; 			// GRN No
		details[9]  = grnTypeId; 		// GRN Type
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
	}
}

function AddBins(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	pub_index		= index;
	pub_mainRw 		= obj.parentNode.parentNode.rowIndex;
	var mainStore	= document.getElementById('cboMainStore');
	var subStore	= document.getElementById('cboSubStore');
	var orderId		= rw.cells[m_order].id;
	var matId		= rw.cells[m_iDec].id;
	var buyerPoNo	= rw.cells[m_bupo].childNodes[0].nodeValue;
	var size		= rw.cells[m_size].childNodes[0].nodeValue;
	var color		= rw.cells[m_co].childNodes[0].nodeValue;
	var grnNo		= rw.cells[m_grnno].childNodes[0].nodeValue;
	var grnTypeId	= rw.cells[m_grntype].id;
	var adjestQty	= rw.cells[m_adjQty].childNodes[0];
	if(!Validate('AddBins',mainStore,subStore,adjestQty))
		return;
		
	showBackGround('divBG',0);
	var url  = "popupbin.php?StyleId="+orderId;
		url += "&MainStore="+mainStore.value;
		url += "&SubStore="+subStore.value;
		url += "&MatId="+matId;
		url += "&BuyerPoNo="+URLEncode(buyerPoNo);
		url += "&Color="+URLEncode(color);
		url += "&Size="+URLEncode(size);
		url += "&AdjustQty="+adjestQty.value;
		url += "&GRNNo="+URLEncode(grnNo);
		url += "&GRNTypeId="+grnTypeId;
 	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(650,250,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);	
}

function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[2].childNodes[0].childNodes[1].checked){
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[0].lastChild.nodeValue);
		var issueQty = rw.cells[1].childNodes[0].value;
		rw.cells[1].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
				if (tbl.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[1].childNodes[0].value);
					}				
			}		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty) ;

					if (reqQty <= reduceQty ){
						rw.cells[1].childNodes[0].value = reqQty ;
					}
					else{
						 rw.cells[1].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[1].childNodes[0].value = 0;
}

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =1; loop < tblBin.rows.length; loop++)
	{
		if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblBin.rows[loop].cells[3].id; // BinId							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[pub_mainRw].className = "osc2";
		tblMain.rows[pub_mainRw].cells[0].id = 1;
		CloseIWLOItem('popupLayer1');
	}
	else{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}	
}

function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[m_st].childNodes[0].nodeValue);
		if(adjustQty>stockQty)
		{
			obj.value 	= stockQty;
			adjustQty	= stockQty;
		}
	Materials[index][6] = adjustQty;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

//BEGIN - Progran validation function
function Validate(obj0,obj1,obj2,obj3)
{
	if(obj0=='OpenItemPopUp')
	{
		if(obj1.value=="")
		{
			alert("Please select the 'Order No'.");
			obj1.focus();
			return false;
		}
		if(obj2.value=="")
		{
			alert("Please select the 'Main Store'.");
			obj2.focus();
			return false;
		}
	}
	else if(obj0=='AddBins')
	{
		if(obj1=="")
		{
			alert("Please select the 'Main Store'.");
			obj1.focus();
		}
		if(obj2=="")
		{
			alert("Please select the 'Sub Store'.");
			obj2.focus();
		}
		if(obj3=="" || obj3=="0")
		{
			alert("'Adjust Qty' should be more than 0.");
			obj3.focus();
		}
	}
return true;
}
//END - Progran validation function

//BEGIN - 
function SaveLeftOver()
{
	document.getElementById('butSave').style.display = 'none';
	var no 	= document.getElementById('txtSerialNo');
	var tbl = document.getElementById('tblMain');
	if(!ValidateSaveLeftOver())
	{
		document.getElementById('butSave').style.display = 'inline';
		return;
	}
	
	if(no.value=="")
	{
		GetNewSerialNo();
		SaveHeader();
		SaveDetails()
	}
	else
	{
		no 				= no.value.split("/");
		pub_serialNo 	= parseInt(no[1]);
		pub_serialYear 	= parseInt(no[0]);
		SaveHeader();
		SaveDetails()
	}
	alert("Saved successfully.");
	ClearForm();
}

function GetNewSerialNo()
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLGetNewSerialNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
	
	if(XMLAdmin=="TRUE" && XMLNo!='')
	{
		var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_serialNo 	= parseInt(XMLNo);
		pub_serialYear 	= parseInt(XMLYear);
		document.getElementById("txtSerialNo").value = pub_serialYear + "/" + pub_serialNo;			
	}
	else
	{
		alert("Please contact system administrator to assign new Return No.");
	}
}

function SaveHeader()
{
	var url  = "frmItemWiseLeftOverxml.php?RequestType=URLSaveHeader";
	    url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
	htmlobj=$.ajax({url:url,async:false});
}

function SaveDetails()
{
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var matId 		= details[0] ; 			// Matdetail Id
			var orderId		= details[1] ; 			// Oreder Id
			var color 		= details[2] ;			// Color
			var size 		= details[3] ; 			// Size
			var units 		= details[4] ; 			// Unit
			var binArray 	= details[5];	
			var qty			= details[6] ; 			// Adjust Qty
			var buyerPoNo 	= details[7] ; 			// Buyer PoNo
			var grnNo 		= details[8] ; 			// GRN No
			var grnTypeId	= details[9] ; 			// GRN Type
			validateCount++;
			
	var url = 'frmItemWiseLeftOverxml.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&Qty=' +qty+ '&GRNNo='+grnNo+ '&GRNType='+grnTypeId;
	var htmlobj=$.ajax({url:url,async:false});
			
			for (i = 0; i < binArray.length; i++)
			{
				var Bindetails 		= binArray[i];
				var binQty 			= Bindetails[0];  // issueQty
				var mainStoreId		= Bindetails[1];  // MainStores
				var subStoreId		= Bindetails[2];  // SubStores
				var locationId		= Bindetails[3];  // Location
				var binId			= Bindetails[4];  // BinId							
				validateBinCount++;
			
				var url='frmItemWiseLeftOverxml.php?RequestType=URLSaveBinDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&BinQty=' +binQty+ '&MSId=' +mainStoreId+ '&SSId=' +subStoreId+ '&LocId=' +locationId+ '&BinId=' +binId+ '&GRNNo=' +grnNo+ '&GRNType='+grnTypeId;
				var htmlobj=$.ajax({url:url,async:false});
				
			}
		}
	}
}
//END - 

function ValidateSaveLeftOver()
{
	var tbl = document.getElementById('tblMain');
	if(tbl.rows.length <=1)
	{
		alert("No details appear to save.");
		return false
	}
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if (tbl.rows[loop].cells[0].id==0){
			alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +".");
			return false;				
		}	
	}
return true;
}

function LoadSubCat(styleID)
{
	var mainCat = document.getElementById('cboPopMainCat').value;
	var url = "frmItemWiseLeftOverxml.php?RequestType=URLloadPopupSubCategory&mainCat="+mainCat+"&styleID="+styleID;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseText;
}

function EnterLoadPopItems(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode == 13)
		LoadPopItems();
}

function ViewNormalReport(obj)
{
		var reportName = "rptItemWiseLeftOverList.php";
		
	var url  = reportName+"?";
		url += "&txtOrderNo="+URLEncode(document.getElementById('txtOrderNo').value);
		url += "&txtAllocationNo="+URLEncode(document.getElementById('txtAllocationNo').value); 
		url += "&cboSubCategory="+URLEncode(document.getElementById('cboSubCategory').value.trim()); 
		url += "&cboItem="+URLEncode(document.getElementById('cboItem').value.trim()); 
		url += "&cboLOCompany="+URLEncode(document.getElementById('cboLOCompany').value.trim()); 
		url += "&txtItem="+URLEncode(document.getElementById('txtItem').value.trim()); 
		url += "&txtFromDate="+URLEncode(document.getElementById('txtFromDate').value.trim()); 
		url += "&txtToDate="+URLEncode(document.getElementById('txtToDate').value.trim()); 
		url += "&chkDate="+(document.getElementById('chkDate').checked ? 'on':'');
		url += "&ReportFormat="+obj; 
	window.open(url,reportName)
}