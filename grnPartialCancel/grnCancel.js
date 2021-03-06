var xmlHttp=[];
var xmlHttp1=[];
var xmlHttp3;
var pub_TotalYrd = 0;
var pub_TotalQty = 0;
var pub_printWindowNo=0;
// ************************************** Trim Function ***************************
function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}
 
function ltrim(str) {
	chars = ' '  || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str) {
	chars = ' ' || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
// ************************************** End Of Trim Function ********************

// ************************************** Define xmlHttp Object *******************
function createXmlHttpObject(index)
{
 xmlHttp[index]=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp[index]=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
//return xmlHttp;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
function loadGRNDetails()
{
	var poNo = document.getElementById("cboPoNo").value;
	var year = document.getElementById("cboYear").value;
	
	createXmlHttpObject(0);
    xmlHttp[0].onreadystatechange = getPoDetailsRequest;
	var url = 'grnCancel-xml.php?id=getGRNDetails&poNo='+poNo+'&year='+year;
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 		
}
function getPoDetailsRequest()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status ==200)
	{
		var rText = xmlHttp[0].responseText;	
		document.getElementById("tblPoDetails").innerHTML = rText ;
	}
}

function CheckforValidDecimal2(sCell,decimalPoints,evt)
{
	
	
	var value=sCell.value;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
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

function removeRow(objDel)
{
		var no = objDel.parentNode.parentNode.parentNode.rowIndex;
		var tbl = objDel.parentNode.parentNode.parentNode.parentNode;
		//if(confirm("Are you sure remove row no " + no ))
		tbl.deleteRow(no);
}

function savePartialCancellation()
{
	var tbl = document.getElementById("tblPoDetails");
	var poNo = document.getElementById("cboPoNo").value;
	var year = document.getElementById("cboYear").value;
	
	var rowCount = tbl.rows.length;
	var checkCount = 0;
	for(var i=1;i<rowCount;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[1].childNodes[0].checked == true)
		{
			checkCount +=1;
			var styleId =  tbl.rows[i].cells[1].id;
			//alert(styleId);
			//var matDetailId =  tbl.rows[i].cells[2].childNodes[0].id;
			var matDetailId =  tbl.rows[i].id;
			var color =  tbl.rows[i].cells[3].childNodes[0].nodeValue;
			var size =  tbl.rows[i].cells[4].childNodes[0].nodeValue;
			var buyerPo =  tbl.rows[i].cells[5].id;
			var qty =  tbl.rows[i].cells[8].childNodes[0].value;
			var unitPrice	= tbl.rows[i].cells[7].childNodes[0].nodeValue; 
			createXmlHttpObject(i);
			xmlHttp[i].onreadystatechange = saveDetailsRequest;
			var url = 'grnCancel-db.php?id=saveGRNDtails';
				url += '&poNo='+poNo;
				url += '&year='+year;
				url += '&styleId='+URLEncode(styleId);
				url += '&matDetailId='+matDetailId;
				url += '&color='+URLEncode(color);
				url += '&size='+URLEncode(size);
				url += '&buyerPo='+URLEncode(buyerPo);
				url += '&qty='+qty;
				url += '&unitPrice='+unitPrice;
			//alert(url);
			xmlHttp[i].index = i;
			xmlHttp[i].open("GET", url, true);
			xmlHttp[i].send(null); 	
		}
	}
	if(checkCount<=0)
		alert("Pls select even one item.");
}

function saveDetailsRequest()
{
	if(xmlHttp[this.index].readyState==4 && xmlHttp[this.index].status ==200)
	{
		var rText = xmlHttp[this.index].responseText;	
		if(xmlHttp[this.index].index == 1)
			alert("GRN Cancellatin is done.");
	}
}





function rowclickColorChange(obj)
{

	 
	var row = obj.parentNode.parentNode.parentNode;
	//var tbl = document.getElementById('tblItem');
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
		if(chk.checked == true)
			tblItem.rows[loop].cells[0].childNodes[1].childNodes[0].checked= true ;
		else
			tblItem.rows[loop].cells[0].childNodes[1].childNodes[0].checked= false ;
	}
}