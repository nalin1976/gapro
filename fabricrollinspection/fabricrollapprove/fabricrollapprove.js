var xmlHttp					= [];

var pub_rollSerialNo		= 0;
var pub_rollSerialYear		= 0;

var validateCount			= 0;
var pub_validateLoop		= 0;
function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function createXMLHttpRequest(index){
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function GetXmlHttpObject(){
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function closeWindow(){
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?')){
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		//var tt=tro.parentNode;		
		tro.parentNode.removeChild(tro);
	}
}

function SeachStyle(){	
	var ScNo =document.getElementById("cboScNo").options[document.getElementById("cboScNo").selectedIndex].text;
	document.getElementById("cboStyleId").value =ScNo;
}

function SeachSC(){	
	var StyleID =document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	document.getElementById('cboScNo').value =StyleID;
}

function LoadSupplierBatch(){
	var StyleID =document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	
	RomoveData('cboSupplier');
	RomoveData('cboRollNo');
	createXMLHttpRequest(1);	
	xmlHttp[1].onreadystatechange = LoadSupplierBatchRequest;
	xmlHttp[1].open("GET",'fabricrollapprovexml.php?RequestType=LoadSupplierBatch&StyleID=' +URLEncode(StyleID) ,true);
	xmlHttp[1].send(null);
	
}
	function LoadSupplierBatchRequest(){	
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status ==200)
			{						
					 var XMLText= xmlHttp[1].responseText;					 
					document.getElementById('cboSupplierBatchNo').innerHTML=XMLText;				
			}
	}
			
function LoadSupplier(){
	var StyleID =document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	var SuppBatchNo = document.getElementById('cboSupplierBatchNo').value;
 	
	RomoveData('cboRollNo');
	createXMLHttpRequest(2);	
	xmlHttp[2].onreadystatechange = LoadSupplierRequest;
	xmlHttp[2].open("GET",'fabricrollapprovexml.php?RequestType=LoadSupplier&StyleID=' +URLEncode(StyleID)+ '&SuppBatchNo=' +SuppBatchNo ,true);
	xmlHttp[2].send(null);
}
	function LoadSupplierRequest(){	
		if(xmlHttp[2].readyState==4 && xmlHttp[2].status ==200)
		{			
			 var XMLText= xmlHttp[2].responseText;			 
			document.getElementById('cboSupplier').innerHTML=XMLText;
	
		}
	}	

function LoadRollNo(){
	var StyleID =document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	var SuppBatchNo = document.getElementById('cboSupplierBatchNo').value;
	var SupplierID = document.getElementById('cboSupplier').value;
 	createXMLHttpRequest(3);	
	xmlHttp[3].onreadystatechange = LoadRollNoRequest;
	xmlHttp[3].open("GET",'fabricrollapprovexml.php?RequestType=LoadRollNo&StyleID=' +URLEncode(StyleID)+ '&SuppBatchNo=' +SuppBatchNo+ '&SupplierID=' +SupplierID ,true);
	xmlHttp[3].send(null);
}
	function LoadRollNoRequest(){	
		if(xmlHttp[3].readyState==4 && xmlHttp[3].status ==200)
		{			
			 var XMLText= xmlHttp[3].responseText;			 
			document.getElementById('cboRollNo').innerHTML=XMLText;
	
		}
	}
	
function LoadDetailsToMainTable()
{
	var StyleID 	=document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	var SuppBatchNo = document.getElementById('cboSupplierBatchNo').value;
	var SupplierID 	= document.getElementById('cboSupplier').value;
	var RollNo 		= document.getElementById('cboRollNo').value;
	RemoveAllRows('tblMain');
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange = LoadDetailsToMainTableRequest;
	xmlHttp[4].open("GET",'fabricrollapprovexml.php?RequestType=LoadDetailsToMainTable&StyleID=' +URLEncode(StyleID)+ '&SuppBatchNo=' +SuppBatchNo+ '&SupplierID=' +SupplierID+ '&RollNo=' +RollNo ,true);
	xmlHttp[4].send(null);
	
}
	function LoadDetailsToMainTableRequest()
	{
		if(xmlHttp[4].readyState==4 && xmlHttp[4].status ==200)
		{
			var tbl = document.getElementById('tblMain');
			
			var XMLRollNo = xmlHttp[4].responseXML.getElementsByTagName("RollNo");
			var XMLStyleID = xmlHttp[4].responseXML.getElementsByTagName("StyleID");
			var XMLSCNO = xmlHttp[4].responseXML.getElementsByTagName("SCNO");
			var XMLBuyerPoNo = xmlHttp[4].responseXML.getElementsByTagName("BuyerPoNo");
			var XMLMatDetailID = xmlHttp[4].responseXML.getElementsByTagName("MatDetailID");
			var XMLItemDescription = xmlHttp[4].responseXML.getElementsByTagName("ItemDescription");
			var XMLColor = xmlHttp[4].responseXML.getElementsByTagName("Color");
			var XMLSupplierBatchNo = xmlHttp[4].responseXML.getElementsByTagName("SupplierBatchNo");
			var XMLSupplierName = xmlHttp[4].responseXML.getElementsByTagName("SupplierName");
			var XMLInspected = xmlHttp[4].responseXML.getElementsByTagName("Inspected");
			var XMLApproved = xmlHttp[4].responseXML.getElementsByTagName("Approved");
			var XMLQty = xmlHttp[4].responseXML.getElementsByTagName("Qty");
			var XMLApprovedQty = xmlHttp[4].responseXML.getElementsByTagName("ApprovedQty");
			var XMLRejectedQty = xmlHttp[4].responseXML.getElementsByTagName("RejectedQty");
			var XMLSpecialComments = xmlHttp[4].responseXML.getElementsByTagName("SpecialComments");
			
			for (var loop =0 ;loop < XMLRollNo.length; loop++ )
			{
				
				var lastRow = tbl.rows.length;
				var row = tbl.insertRow(lastRow);
				row.className="bcgcolor-tblrow";
				
				var cell=row.insertCell(0);
				cell.className="normalfnt";	
				cell.innerHTML="<div align=\"center\"><img src=\"../../images/del.png\"/></div></td>";				
				var cell=row.insertCell(1);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLRollNo[loop].childNodes[0].nodeValue;
										
				
				var cell=row.insertCell(2);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLStyleID[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(3);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLSCNO[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(4);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLBuyerPoNo[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(5);
				cell.className="normalfntSM";
				cell.id=XMLMatDetailID[loop].childNodes[0].nodeValue;
				cell.innerHTML=XMLItemDescription[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(6);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLColor[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(7);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLSupplierBatchNo[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(8);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLSupplierName[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(9);
				cell.className="normalfntMid";	
				cell.innerHTML="<input type=\"checkbox\" name=\"chkInspect\" id=\"chkInspect\" "+(XMLInspected[loop].childNodes[0].nodeValue=="1" ? "checked=checked" : "" )+" />";
				
				var cell=row.insertCell(10);
				cell.className="normalfntMid";	
				cell.innerHTML="<input type=\"checkbox\" name=\"chkApproved\" id=\"chkApproved\" "+(XMLApproved[loop].childNodes[0].nodeValue=="1" ? "checked=checked" : "" )+" onclick=\"GetApprovedQty(this);\"/>";
				
				var cell=row.insertCell(11);
				cell.className="normalfntRite";	
				cell.innerHTML=XMLQty[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(12);
				cell.className="normalfntMid";	
				cell.innerHTML="<input type=\"text\" value=\""+XMLApprovedQty[loop].childNodes[0].nodeValue+"\" name=\"txtAppQty\" id=\"txtAppQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" onkeyup=\"CalculateRejectQty(this);\"/>";
				
				var cell=row.insertCell(13);
				cell.className="normalfntRite";	
				cell.innerHTML=(XMLRejectedQty[loop].childNodes[0].nodeValue=="")? 0:XMLRejectedQty[loop].childNodes[0].nodeValue;
				
				var cell=row.insertCell(14);
				cell.className="normalfntSM";	
				cell.innerHTML=XMLSpecialComments[loop].childNodes[0].nodeValue;			
				
			}			
		}
	}
	
function GetApprovedQty(obj)
{
	var rw	= obj.parentNode.parentNode;
	if(obj.checked)
	{
		rw.cells[12].childNodes[0].value=rw.cells[11].childNodes[0].nodeValue;		
	}
	else 
		rw.cells[12].childNodes[0].value=0;
	CalculateRejectQty(obj);
}

function CalculateRejectQty(obj)
{	
	var rw	= obj.parentNode.parentNode;
	var length	= parseFloat(rw.cells[11].childNodes[0].nodeValue);
	var appLength	= parseFloat(rw.cells[12].childNodes[0].value);
	
	if(length<appLength){		
		rw.cells[12].childNodes[0].value = rw.cells[11].childNodes[0].nodeValue;
	}
	var length	= parseFloat(rw.cells[11].childNodes[0].nodeValue);
	var appLength	= parseFloat(rw.cells[12].childNodes[0].value);
	
	var Qty	= length-appLength;
	rw.cells[13].childNodes[0].nodeValue	= Qty;
	
}

function SaveValidation()
{
	Save();
}

function Save()
{
	var tbl	= document.getElementById('tblMain');
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var rollSerialNo = document.getElementById('cboRollNo').value;
		var rollNo		= tbl.rows[loop].cells[1].childNodes[0].nodeValue;		
		
		var inspect 	= tbl.rows[loop].cells[9].childNodes[0].checked==true ? "1" : "0";
		var approved 	= tbl.rows[loop].cells[10].childNodes[0].checked==true ? "1" : "0";
		var appQty		= tbl.rows[loop].cells[12].childNodes[0].value;
		var rejQty		= tbl.rows[loop].cells[13].childNodes[0].nodeValue;
		
		
		createXMLHttpRequest(loop);	
		//xmlHttp[loop].onreadystatechange = SaveValidateRequest;
		xmlHttp[loop].open("GET",'fabricrollapprovexml.php?RequestType=Save&rollSerialNo=' +rollSerialNo+ '&rollNo=' +rollNo+ '&inspect=' +inspect+ '&approved=' +approved+ '&appQty=' +appQty+ '&rejQty=' +rejQty ,true);
		xmlHttp[loop].send(null);
		alert ("Details Updated Successfully!");
	}
}


