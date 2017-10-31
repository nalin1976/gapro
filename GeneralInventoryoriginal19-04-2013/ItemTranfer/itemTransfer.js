// JavaScript Document
var pub_No = 0;
function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();	
}
function RomoveData(data)
{
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 1) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}
function loadSubStores(mainStoresId)
{
	RomoveData('cboSubCategory');
	
	var url     = 'itemTransferdb.php?request=loadSubStores&mainStore='+mainStoresId;
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboSubCategory').innerHTML = htmlobj.responseText;
}
function LoadSourceBinDetails()
{
	showPleaseWait();
	var category 	= document.getElementById('cboMainCategory').value;
	var subcategory = document.getElementById('cboSubCategory').value;
	var itemLike 	= document.getElementById('txtItemDiscription').value;
	var costCenter 	= document.getElementById('cboCostCenter').value;
	var tbl 	  	= document.getElementById('tblSource');

	if(costCenter=="")
	{
		alert("Please select a 'Cost Center'.");
		document.getElementById('cboCostCenter').focus();
		hidePleaseWait();
		return;
	}
	var url = "itemTransferdb.php?request=loadSourceDetails&category="+category+"&subcategory="+subcategory+"&itemLike="+itemLike+"&costCenter="+costCenter;
	var htmlobj = $.ajax({url:url,async:false});
	RemoveAllRows('tblSource');
	
	var XMLMatId 		= htmlobj.responseXML.getElementsByTagName("MatDetailId");
	var XMLItemDes 		= htmlobj.responseXML.getElementsByTagName("ItemDes");
	var XMLunit 		= htmlobj.responseXML.getElementsByTagName("unit");
	var XMLTotalQty 	= htmlobj.responseXML.getElementsByTagName("TotalQty");
	var XMLGRNNo 		= htmlobj.responseXML.getElementsByTagName("GRNNo");
	var XMLGLAllowId 	= htmlobj.responseXML.getElementsByTagName("GLAllowId");
	var XMLGLCode 		= htmlobj.responseXML.getElementsByTagName("GLCode");
	
	for(var i=0;i<XMLMatId.length;i++)
	{
		var MatId   	= XMLMatId[i].childNodes[0].nodeValue;
		var ItemDes 	= XMLItemDes[i].childNodes[0].nodeValue;
		var Iunit   	= XMLunit[i].childNodes[0].nodeValue;
		var TotQty  	= XMLTotalQty[i].childNodes[0].nodeValue;
		var GRNNo   	= XMLGRNNo[i].childNodes[0].nodeValue;
		var GLAllowId   = XMLGLAllowId[i].childNodes[0].nodeValue;
		var GLCode  	= XMLGLCode[i].childNodes[0].nodeValue;
		
		createSourceGrid(tbl,MatId,ItemDes,Iunit,TotQty,GRNNo,GLAllowId,GLCode);
	}
	hidePleaseWait();	
}
function createSourceGrid(tbl,MatId,ItemDes,Iunit,TotQty,GRNNo,GLAllowId,GLCode)
{
	var lastRow	  	= tbl.rows.length;	
	var row 	 	= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	="normalfnt";
	cell.setAttribute('height','20');
	cell.id			= MatId;
	cell.innerHTML  = ItemDes;
	
	var cell 		= row.insertCell(1);
	cell.className 	="normalfnt";
	cell.innerHTML 	= Iunit;
	
	var cell 		= row.insertCell(2);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= TotQty;
	
	var cell 		= row.insertCell(3);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= "<input name=\"textfield\" class=\"txtbox\" type=\"text\" style=\"text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"checkQty(this);validateCheck(this);\" value="+TotQty+" size=\"15\" />";
	
	var cell 		= row.insertCell(4);
	cell.className 	="normalfntMid";
	cell.innerHTML  ="<input type=\"checkbox\" id=\"chkTransfer\" onclick=\"AddDetailsToDestination(this);\">";
	
	var cell 		= row.insertCell(5);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= GRNNo;
	
	var cell 		= row.insertCell(6);
	cell.className 	="normalfntMid";
	cell.id			= GLAllowId;
	cell.innerHTML 	= GLCode;
}
function checkQty(obj)
{
	var rw	= obj.parentNode.parentNode;
	var stockQty	= rw.cells[2].childNodes[0].nodeValue;
	if(parseFloat(obj.value)>parseFloat(stockQty))
	{		
		obj.value = stockQty;
	}
}
function validateCheck(obj)
{
	var rw	  = obj.parentNode.parentNode;
	var matId = rw.cells[0].id;
	rw.cells[4].childNodes[0].checked = false;
	removeItemFromDestination(matId);
}
function AddDetailsToDestination(obj)
{
	showPleaseWait();
	var rw 				= obj.parentNode.parentNode;
	var matId			= rw.cells[0].id;
	var itemDes			= rw.cells[0].childNodes[0].nodeValue;
	var Iunit			= rw.cells[1].childNodes[0].nodeValue;
	var stockQty		= rw.cells[2].childNodes[0].nodeValue;
	var transQty		= rw.cells[3].childNodes[0].value;
	var transCheck		= rw.cells[4].childNodes[0].checked;
	var GRNNO			= rw.cells[5].childNodes[0].nodeValue;
	var GLAllowId		= rw.cells[6].id;
	var GLCode			= rw.cells[6].childNodes[0].nodeValue;
	var tbl			    = document.getElementById('tblDestination');
	
	var destCostId	    = document.getElementById('cboDesCostCenter').value;
	var sourceCostId    = document.getElementById('cboCostCenter').value;
	
	if(destCostId=="")
	{
		alert("Please select a destination Cost Center.");
		document.getElementById('cboDesCostCenter').focus();
		rw.cells[4].childNodes[0].checked = false;
		hidePleaseWait();
		return;
	}
	if(destCostId==sourceCostId)
	{
		alert("'Source CostCenter' and 'Destination CostCenter' cannot be same.");
		document.getElementById('cboDesCostCenter').focus();
		rw.cells[4].childNodes[0].checked = false;
		hidePleaseWait();
		return true;
	}
	if(transQty=="" || transQty==0)
	{
		alert("Cannot transfer item with empty or 0 Qty.");
		rw.cells[3].childNodes[0].focus();
		rw.cells[4].childNodes[0].checked = false;
		hidePleaseWait();
		return;
	}
	if(!obj.checked)
	{
		removeItemFromDestination(matId);
		hidePleaseWait();
		return;
	}

	createDestinationGrid(tbl,matId,itemDes,Iunit,stockQty,transQty,GRNNO,GLAllowId,GLCode);
	hidePleaseWait();	
}
function createDestinationGrid(tbl,matId,itemDes,Iunit,stockQty,transQty,GRNNO,GLAllowId,GLCode)
{
	var lastRow	  	= tbl.rows.length;	
	var row 	 	= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	="normalfntMid";
	cell.setAttribute('height','20');
	cell.innerHTML  = "<img src=\"../../images/del.png\" alt=\"edit\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\"/>";
	
	var cell 		= row.insertCell(1);
	cell.className 	="normalfnt";
	cell.id			= matId;
	cell.innerHTML  = itemDes;
	
	var cell 		= row.insertCell(2);
	cell.className 	="normalfnt";
	cell.innerHTML 	= Iunit;
	
	var cell 		= row.insertCell(3);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= stockQty;
	
	var cell 		= row.insertCell(4);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= transQty;
	
	var cell 		= row.insertCell(5);
	cell.className 	="normalfntRite";
	cell.innerHTML 	= GRNNO;
	
	var cell 		= row.insertCell(6);
	cell.className 	="normalfntMid";
	cell.id			= GLAllowId;
	cell.innerHTML 	= GLCode;
}
function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var sourctbl = document.getElementById('tblSource');
		var td 		 = obj.parentNode;
		var tro 	 = td.parentNode;	
		tro.parentNode.removeChild(tro);
		for(var i=0;i<sourctbl.rows.length;i++)
		{
			if(sourctbl.rows[i].cells[0].id==tro.cells[1].id)
			{
				sourctbl.rows[i].cells[4].childNodes[0].checked = false;
			}
		}		
	}
}
function removeItemFromDestination(matId){
	var tblDestination 	= document.getElementById('tblDestination');
	for(var i =1;i<tblDestination.rows.length;i++)
	{
		var desMatId = tblDestination.rows[i].cells[1].id;		
		if(matId==desMatId){
			tblDestination.deleteRow(i);
		}
	}
}
function GetNo()
{	
	document.getElementById("butSave").style.display="none";
	showPleaseWait();
	if(!SaveValidate())
	{
		return;
	}
	var url = 'itemTransferdb.php?request=GetNo';
	htmlobj = $.ajax({url:url,async:false});	
	
	var XMLAdmin = htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;	
	if(XMLAdmin=="TRUE")
	{
		var XMLNo = htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;					
		pub_No = parseInt(XMLNo);						
		Save();				
	}
	else
	{
		alert("Please contact system administrator to Assign New No....");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
	}
}
function Save()
{
	var boolCheck = true;
	var tbl			    = document.getElementById('tblDestination');
	var sourceCostId    = document.getElementById('cboCostCenter').value;
	var DesCostId	    = document.getElementById('cboDesCostCenter').value;
	for(var i=1;i<tbl.rows.length;i++)
	{
		var MatDetId	= tbl.rows[i].cells[1].id;
		var Iunit    	= tbl.rows[i].cells[2].childNodes[0].nodeValue;
		var TransQty	= tbl.rows[i].cells[4].childNodes[0].nodeValue;
		var GrnNo   	= tbl.rows[i].cells[5].childNodes[0].nodeValue;
		var GLAllowId   = tbl.rows[i].cells[6].id;
		
		var url = "itemTransferdb.php?request=SaveDetails&sourceCostId="+sourceCostId+"&DesCostId="+DesCostId+"&MatDetId="+MatDetId+"&Iunit="+Iunit+"&TransQty="+TransQty+"&GrnNo="+GrnNo+"&pub_No="+pub_No+"&GLAllowId="+GLAllowId;
		htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText=="Error")
		{
			boolCheck = false;
			break;
		}
	}
	if(boolCheck)
	{
		alert("Item transfered successfully.");
		hidePleaseWait();					
		document.getElementById("butSave").style.display="none";
		clearAll();
	}
	else
	{
		alert("Sorry!\nError occured while saving the data. Please Save it again.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return;
	}
}
function SaveValidate()
{
	var tblSource 	= document.getElementById('tblSource');
	var tblDes 		= document.getElementById('tblDestination');
	
	if(tblSource.rows.length<=1)
	{
		alert("Sorry!\nNo Source details to save.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(tblDes.rows.length<=1)
	{
		alert("Sorry!\nNo Destination details to save.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	return true;
}
function emptyDesTable()
{
	var tblSource = document.getElementById('tblSource');
	RemoveAllRows('tblDestination');
	for(var i=0;i<tblSource.rows.length;i++)
	{
		if(tblSource.rows[i].cells[4].childNodes[0].checked==true)
		{
			tblSource.rows[i].cells[4].childNodes[0].checked = false;
		}
	}
}
function emtyBothTable()
{
	RemoveAllRows('tblDestination');
	RemoveAllRows('tblSource');
	document.getElementById('cboDesCostCenter').value = "";
}
function clearAll()
{
	document.frmItemTransfer.reset();
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
}