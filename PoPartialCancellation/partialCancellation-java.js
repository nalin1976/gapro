function ClearForm()
{
	document.frmPOPartialCancellation.submit();
}

function loadPoDetails()
{
	var poNo = document.getElementById("cboPoNo").value;
	var year = document.getElementById("cboYear").value;
	
	var url = 'partialCancellation-xml.php?id=getPoDetails&poNo='+poNo+'&year='+year;
	var htmlobj=$.ajax({url:url,async:false});
	GetPoDetailsRequest(htmlobj);
}

function GetPoDetailsRequest(htmlobj)
{
	var XMLCount 		= htmlobj.responseXML.getElementsByTagName("StyleId");
	for(var loop=0;loop<XMLCount.length;loop++)
	{
		var styleId 	= htmlobj.responseXML.getElementsByTagName("StyleId")[loop].childNodes[0].nodeValue;
		var orderNo 	= htmlobj.responseXML.getElementsByTagName("OrderNo")[loop].childNodes[0].nodeValue;
		var iemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[loop].childNodes[0].nodeValue;
		var iemDescId 	= htmlobj.responseXML.getElementsByTagName("ItemDescId")[loop].childNodes[0].nodeValue;
		var color 		= htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var size 		= htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var buyerPO 	= htmlobj.responseXML.getElementsByTagName("BuyerPO")[loop].childNodes[0].nodeValue;
		var remarks 	= htmlobj.responseXML.getElementsByTagName("Remarks")[loop].childNodes[0].nodeValue;
		var unitPrice 	= htmlobj.responseXML.getElementsByTagName("UnitPrice")[loop].childNodes[0].nodeValue;
		var poQty 		= htmlobj.responseXML.getElementsByTagName("POQty")[loop].childNodes[0].nodeValue;
		var value 		= htmlobj.responseXML.getElementsByTagName("Value")[loop].childNodes[0].nodeValue;
		CreateMainGrid(styleId,orderNo,iemDesc,iemDescId,color,size,buyerPO,remarks,unitPrice,poQty,value);
	}
}

function CreateMainGrid(styleId,orderNo,iemDesc,iemDescId,color,size,buyerPO,remarks,unitPrice,poQty,value)
{
	var tbl 		= document.getElementById('tblPoDetails');
	var lastRow 	= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfntMid";
	cell.setAttribute('height','20');
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"rowclickColorChange(this);\" />";
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id			= styleId;
	cell.innerHTML 	= orderNo;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.id			= iemDescId;
	cell.innerHTML 	= iemDesc;
	
	var cell		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= color;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= size;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= buyerPO;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= remarks;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= unitPrice;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input name=\"txtQty\" type=\"text\" class=\"txtbox\" id=\""+poQty+"\" size=\"10\" value=\""+poQty+"\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"validNum(this);\" />";
	
	var cell 		= row.insertCell(9);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= value;
}

function validNum(obj)
{
	var qty = parseFloat(obj.value);
	if (qty > parseFloat(obj.id) )
	{
		alert("Can't exceed maximum po qty.");	
		obj.value=  Math.round((obj.id)*100)/100;
	}
	
	var unitPrice = parseFloat(obj.parentNode.parentNode.cells[7].childNodes[0].nodeValue);
	var value = Math.round((unitPrice*obj.value)*100)/100;
	obj.parentNode.parentNode.cells[9].childNodes[0].nodeValue = value;
}

function savePartialCancellation()
{
	var tbl 	= document.getElementById("tblPoDetails");
	var poNo 	= document.getElementById("cboPoNo").value;
	var year 	= document.getElementById("cboYear").value;
	
	var checkCount 	= 0;
	var responseCnt = 0;
	
	if(!SaveValidation())
		return;
		
	if(confirm('Are you sure you want to cancel this selected PO item/s ?'))
	{
		for(var i=1;i<tbl.rows.length;i++)
		{
			if(tbl.rows[i].cells[0].childNodes[0].checked == true)
			{
				checkCount +=1;
				
				var styleId 	= tbl.rows[i].cells[1].id;
				var matDetailId = tbl.rows[i].cells[2].id;
				var color 		= tbl.rows[i].cells[3].childNodes[0].nodeValue;
				var size 		= tbl.rows[i].cells[4].childNodes[0].nodeValue;
				var buyerPo 	= tbl.rows[i].cells[5].childNodes[0].nodeValue;
				var qty 		= tbl.rows[i].cells[8].childNodes[0].value;
				
				var url  = 'partialCancellation-db.php?id=savePoDtails';
					url += '&poNo='+poNo;
					url += '&year='+year;
					url += '&styleId='+styleId;
					url += '&matDetailId='+matDetailId;
					url += '&color='+URLEncode(color);
					url += '&size='+URLEncode(size);
					url += '&buyerPo='+URLEncode(buyerPo);
					url += '&qty='+qty;				
				var htmlobj=$.ajax({url:url,async:false});
				var OrderNo = htmlobj.responseText;
				
				if(OrderNo == '1')
					responseCnt +=1;
			}
		}
		
		if(responseCnt == checkCount)
		{
			alert("Selected item/s canceled successfully.");		
		}
		//clearTableData();
		ClearForm();
	}
}

function rowclickColorChange(obj)
{ 
	var row = obj.parentNode.parentNode.parentNode;
	if(row.className!="bcgcolor-highlighted")
		pub_itemRowColor= row.className;
	
	if(obj.checked)
		row.className="bcgcolor-highlighted";
	else
		row.className=pub_itemRowColor;	
}


function checkAll(chk)
{
	var tblItem = document.getElementById("tblPoDetails");
	for(var loop=1;loop< tblItem.rows.length;loop++)
	{
		if(chk.checked)
			tblItem.rows[loop].cells[0].childNodes[0].checked= true ;
		else
			tblItem.rows[loop].cells[0].childNodes[0].checked= false ;
	}
}

function clearTableData()
{
var tbl = document.getElementById('tblPoDetails');
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}
}

function getPONO()
{
	var intYear = document.getElementById('cboYear').value;
	
	var url  = "partialCancellation-xml.php";
		url += "?id=getPONo";
		url += "&intYear="+intYear;
	
	var htmlobj=$.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseText;
	document.getElementById('cboPoNo').innerHTML =  OrderNo;
	clearTableData();
}

function SaveValidation()
{
var tbl 	= document.getElementById("tblPoDetails");
var poNo 	= document.getElementById("cboPoNo").value;
var year 	= document.getElementById("cboYear").value;
var booAvil	= false;	
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked == true)
		{
			booAvil = true;
		}
	}
	if(poNo=="")
	{
		alert("Please select the 'PO No'.");
		document.getElementById("cboPoNo").focus();
		return false;
	}
	if(tbl.rows.length<=1)
	{
		alert("No items appear to Cancel.");
		return false;
	}
	if(!booAvil)
	{
		alert("No item selected to cancel.Please select atleast one item to cancel.")
		return false;
	}
return true;
}