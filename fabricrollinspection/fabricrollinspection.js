var xmlHttp					= [];
var xmlHttp1 				= [];

var pub_rollSerialNo		= 0;
var pub_rollSerialYear		= 0;

var validateCount			= 0;

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

function createXMLHttpRequest1(index){
    if (window.ActiveXObject) 
    {
        xmlHttp1[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1[index] = new XMLHttpRequest();
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

function autocomplete_item()
{
	var text = document.getElementById('txtponoLike').value;
	var year = document.getElementById('cboYear').value;
	//alert(text);
	//alert(year);
	var url6	='fabricrollinspectionxml.php?RequestType=GetAutocompleteItem' ;
		url6 += '&text=' +text;
		url6 += '&year=' +year;
	//alert(url6);	
		
			var htmlobj	=$.ajax({url:url6,async:false});
			//alert(htmlobj.responseText);
			var pub_pending_arr		=htmlobj.responseText.split("|");
			//alert(pub_pending_arr);
			$( "#txtponoLike" ).autocomplete({
			source: pub_pending_arr
			//alert(htmlobj.responseText);
		});
			
}

function DisplaySelectedItem()
{
	var selectedItem = document.getElementById('txtponoLike').value;
	//alert(selectedItem);
	var url = 'fabricrollinspectionxml.php?RequestType=DisplaySelectedItem&selectedItem=' + selectedItem;
	var htmlobj = $.ajax({url:url,async:false})
	var XMLPoNo = htmlobj.responseXML.getElementsByTagName("ponos")[0].childNodes[0].nodeValue;
	document.getElementById('cboPoNo').value = XMLPoNo;
}

function AutoTypeWidth()
{
	document.getElementById('txtCompWidth').value = document.getElementById('txtSuppWith').value;	
}

function AutoTypeLength()
{
	document.getElementById('txtCompLength').value = document.getElementById('txtSuppLength').value;	
}

function AutoTypeWeigth()
{
	document.getElementById('txtCompWeight').value = document.getElementById('txtSuppWeight').value;
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
		tro.parentNode.removeChild(tro);
		DeleteRow(obj);
	}
}
function DeleteRow(obj){
var rw 		= obj.parentNode.parentNode;
var rollNo  = rw.cells[1].childNodes[0].nodeValue;
var rollSerialNo = document.getElementById('txtFabricRollSerialNO').value;

createXMLHttpRequest(1);
//xmlHttp[1].onreadystatechange=LoadSupplierRequest;
xmlHttp[1].open("GET",'fabricrollinspectionxml.php?RequestType=DeleteRow&rollNo=' +rollNo+ '&rollSerialNo=' +rollSerialNo ,true);
xmlHttp[1].send(null);	
}

/*function SeachStyle(){	
	var ScNo =document.getElementById("cboScNo").options[document.getElementById("cboScNo").selectedIndex].text;
	document.getElementById("cboStyleId").value =ScNo;
}*/

function nextCompanyBatchNoTextBox(evt)
{
	
	if (evt.keyCode == 13)
	{
		document.getElementById('txtRollNo').focus();	
	}

}

function nextRollNoTextBox(evt)
{
	
	if (evt.keyCode == 13)
	{
		document.getElementById('txtRollNo').focus();	
	}

}

function nextSuppWidthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtSuppWith').focus();	
	}
}

function nextCompWidthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtCompWidth').focus();	
	}
}

function nextWidthUOM(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('cboWidthUOM').focus();	
	}
}

function nextSuppLengthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtSuppLength').focus();	
	}
}

function nextCompLengthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtCompLength').focus();	
	}
}

function nextLengthUOM(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('cboLengthUOM').focus();	
	}
}

function nextSuppWeigthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtSuppWeight').focus();	
	}
}

function nextCompWeigthTextBox(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtCompWeight').focus();	
	}
}

function nextWeigthUOM(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('cboWeightUOM').focus();	
	}
}

function nextSpecComments(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('txtSpecialComment').focus();	
	}
}

function nextSuppBatchNoTextBox(evt)
{
	
		document.getElementById('txtRollNo').focus();	
	
}

function ToAddButton(evt)
{
	if (evt.keyCode == 13)
	{
		document.getElementById('add').click();	
	}
}

/*function LoadScNo(){	
	
	//alert("llllll");
	var styleNo = document.getElementById('cboStyleId').value;
	//alert(styleNo);
	var url = "fabricrollinspectionxml?RequestType=LoadScNo&styleNo=" + styleNo;
	alert(url);
}*/


function LoadPoNo(){
	var year	= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	if(year=="")return;
	createXMLHttpRequest(1);
	RomoveData('cboPoNo');
	xmlHttp[1].onreadystatechange=LoadPoNoRequest;
	xmlHttp[1].open("GET",'fabricrollinspectionxml.php?RequestType=LoadPoNo&year=' +year ,true);
	xmlHttp[1].send(null);
}
	function LoadPoNoRequest(){	
		if(xmlHttp[1].readyState==4){
			if(xmlHttp[1].status==200){
			
				var XMLPoNo= xmlHttp[1].responseText;
				document.getElementById('cboPoNo').innerHTML = XMLPoNo;		
			}
		}
	}
	
	
function LoadSupplier(){
	var PoNo	= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
	var year	= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	if(PoNo=="")return;
	createXMLHttpRequest(2);
	RomoveData('cboSupplier');
	xmlHttp[2].onreadystatechange=LoadSupplierRequest;
	xmlHttp[2].open("GET",'fabricrollinspectionxml.php?RequestType=LoadSupplier&year=' +year+ '&PoNo=' +PoNo ,true);
	xmlHttp[2].send(null);
}
	function LoadSupplierRequest(){	
		if(xmlHttp[2].readyState==4){
			if(xmlHttp[2].status==200)
			{
				
			 var XMLSupplier	= xmlHttp[2].responseXML.getElementsByTagName('Supplier');	
			 var XMLSupplierID	= xmlHttp[2].responseXML.getElementsByTagName('SupplierID');	 	
				
			 for ( var loop = 0; loop < XMLSupplier.length; loop ++)
			 {			
				var opt = document.createElement("option");
				opt.text = XMLSupplier[loop].childNodes[0].nodeValue;
				opt.value = XMLSupplierID[loop].childNodes[0].nodeValue;
				document.getElementById('cboSupplier').options.add(opt);
			 }
			
		    }
		}
		 
	}

function LoadScToPo()
{
		var poNo = document.getElementById('cboPoNo').value;
		var year = document.getElementById('cboYear').value;
		
		var url = "fabricrollinspectionxml.php?RequestType=LoadScToPo&poNo=" + poNo + '&year=' + year;
		//alert(url);
		
		htmlobj = $.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('cboScNo').innerHTML = htmlobj.responseText;
}

function LoadStyleToSc()
{
	var poNo = document.getElementById('cboPoNo').value;
	var year = document.getElementById('cboYear').value;	
	var scNo = document.getElementById('cboScNo').value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadStyleToSc&poNo=" + poNo + '&year=' + year + '&scNo=' + scNo ;
	//alert(url);
	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	
	document.getElementById('cboStyleId').innerHTML = htmlobj.responseText;
}

function LoadBuyerPoToSc()
{
	var poNo = document.getElementById('cboPoNo').value;
	var year = document.getElementById('cboYear').value;
	var scNo = document.getElementById('cboScNo').value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadBuyerPoToSc&poNo=" + poNo + '&year=' + year + '&scNo=' + scNo ;
	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	
	document.getElementById('cboBuyerPoNo').innerHTML = htmlobj.responseText;
	
}	

function LoadDescriptionToSc()
{
	var	poNo 	= document.getElementById('cboPoNo').value;
	var year 	= document.getElementById('cboYear').value;
	var scNo 	= document.getElementById('cboScNo').value;
	//var buyerPo	= document.getElementById("cboBuyerPoNo").options[document.getElementById("cboBuyerPoNo").selectedIndex].text;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadDescriptionToSc&poNo=" + poNo + '&year=' + year + '&scNo=' + scNo ; 
	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	
	document.getElementById('cboDescription').innerHTML = htmlobj.responseText;	
}

function LoadColorToSc()
{
	var	poNo 	= document.getElementById('cboPoNo').value;
	var year 	= document.getElementById('cboYear').value;
	var scNo 	= document.getElementById('cboScNo').value;
	var itemDes	= document.getElementById('cboDescription').value; 
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadColorToSc&poNo=" + poNo + '&year=' + year + '&scNo=' + scNo + '&itemDes=' + itemDes;
	htmlobj = $.ajax({url:url,async:false});
	
	//alert(htmlobj.responseText);
	
	document.getElementById('cboColor').innerHTML = htmlobj.responseText;
}


	
function LoadStyle()
{
	var PoNo = document.getElementById('cboPoNo').value;
	//alert (PoNo);
	var year = document.getElementById('cboYear').value;
	//alert(year);
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadStyle&PoNo=" + PoNo + '&year=' + year;
	//alert(url);
	
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboStyleId').innerHTML = htmlobj.responseText;
	
}

function LoadSc()
{
	var PoNo = document.getElementById('cboPoNo').value;
	var year = document.getElementById('cboYear').value;
	var style = document.getElementById("cboStyleId").options[document.getElementById("cboStyleId").selectedIndex].text;
	//var style = document.getElementById('cboStyleId').value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadSc&PoNo=" + PoNo + '&year=' + year + '&style=' + URLEncode(style);
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	document.getElementById('cboScNo').innerHTML = htmlobj.responseText;
	
}

function LoadBuyerPoNo()
{
	var PoNo	= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
	var year	= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	var style = document.getElementById("cboStyleId").options[document.getElementById("cboStyleId").selectedIndex].text;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadBuyerPoNo&PoNo=" + PoNo + '&year=' + year + '&style=' + URLEncode(style);
	
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboBuyerPoNo').innerHTML = htmlobj.responseText;
	
}
	
//--------------

function loadUnits(){
	var po=document.getElementById('cboPoNo').value.trim();
var path='fabricrollinspectionxml.php?RequestType=getUnits&&po='+po;
htmlobj=$.ajax({url:path,async:false});
var XMLUnits=htmlobj.responseXML.getElementsByTagName('UNIT');
if(XMLUnits.length > 0){
	//document.getElementById('cboWidthUOM').innerHTML="";
	document.getElementById('cboLengthUOM').innerHTML="";
	//document.getElementById('cboWeightUOM').innerHTML="";
	
		for ( var loop = 0; loop < XMLUnits.length; loop ++){			
				/*var opt = document.createElement("option");
				opt.text = XMLUnits[loop].childNodes[0].nodeValue;
				opt.value = XMLUnits[loop].childNodes[0].nodeValue;
				document.getElementById('cboWidthUOM').options.add(opt);
				*/
				var opt = document.createElement("option");
				opt.text = XMLUnits[loop].childNodes[0].nodeValue;
				opt.value = XMLUnits[loop].childNodes[0].nodeValue;
				document.getElementById('cboLengthUOM').options.add(opt);
				
				/*var opt = document.createElement("option");
				opt.text = XMLUnits[loop].childNodes[0].nodeValue;
				opt.value = XMLUnits[loop].childNodes[0].nodeValue;
				document.getElementById('cboWeightUOM').options.add(opt);*/
			 }	
	}
}



//---------------

	
function LoadDescription()
{
	var PoNo		= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
	var year		= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	var BuyerPoNo 	= document.getElementById("cboBuyerPoNo").options[document.getElementById("cboBuyerPoNo").selectedIndex].text;
	var style	 	= document.getElementById("cboStyleId").options[document.getElementById("cboStyleId").selectedIndex].text;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadDescription&PoNo="+ URLEncode(PoNo) + '&year=' + URLEncode(year) + '&BuyerPoNo=' +
				URLEncode(BuyerPoNo) + '&style=' + URLEncode(style) ;
					
	//alert(url);	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	document.getElementById('cboDescription').innerHTML = htmlobj.responseText;
	
}	
		
function LoadColor()
{
	var PoNo		= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
	var year		= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	var style		= document.getElementById("cboStyleId").options[document.getElementById("cboStyleId").selectedIndex].text;	
	var BuyerPoNo	= document.getElementById("cboBuyerPoNo").options[document.getElementById("cboBuyerPoNo").selectedIndex].text;
	var ItemDes		= document.getElementById("cboDescription").value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadColor&year=" +year+ '&PoNo=' +URLEncode(PoNo)+ '&style=' +URLEncode(style)+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&ItemDes=' +URLEncode(ItemDes);
	
	//alert(url);
	
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboColor').innerHTML = htmlobj.responseText;
	
}	

function Clear()
{
	document.getElementById('txtRollNo').value = "";
	document.getElementById('txtSuppWith').value = "";
	document.getElementById('txtCompWidth').value = "";	
	document.getElementById('txtSuppLength').value = "";
	document.getElementById('txtCompLength').value = "";	
	document.getElementById('txtSuppWeight').value = "";	
	document.getElementById('txtCompWeight').value = "";	
	document.getElementById('txtSpecialComment').value = "";	
}	

function AddDetailsToMainGrid()
{
			var tblMain 			= document.getElementById('tblMain');
			
			
			var RollNo				= document.getElementById('txtRollNo').value;
			var SuppBatchNo 		= document.getElementById('txtSupBatchNo').value;
			var CompBatchNo			= document.getElementById('txtCompBatchNo').value;
			var SuppWith			= document.getElementById('txtSuppWith').value;
			var CompWidth			= document.getElementById('txtCompWidth').value;
			var SuppLength			= document.getElementById('txtSuppLength').value;
			var CompLength			= document.getElementById('txtCompLength').value;
			var SuppWeight			= document.getElementById('txtSuppWeight').value;
			var CompWeight			= document.getElementById('txtCompWeight').value;
			if(RollNo=="")
			{
				alert("PLease enter the roll no");
				document.getElementById("txtRollNo").focus();
				return;
			}
			else if(SuppBatchNo == "")
			{
				alert("PLease enter the Supplier Batch no");
				document.getElementById("txtSupBatchNo").focus();
				return;
			}
			else if(CompBatchNo == "")
			{
				alert("PLease enter the Company Batch no");
				document.getElementById("txtCompBatchNo").focus();
				return;
			}
			else if(SuppWith == "")
			{
				alert("PLease enter the Supplier Width");
				document.getElementById("txtSuppWith").focus();
				return;
			}
			else if(CompWidth == "")
			{
				alert("PLease enter the Company Width");
				document.getElementById("txtCompWidth").focus();
				return;
			}
			else if(SuppLength == "")
			{
				alert("PLease enter the Supplier Length");
				document.getElementById("txtSuppLength").focus();
				return;
			}
			else if(CompLength == "")
			{
				alert("PLease enter the Company Length");
				document.getElementById("txtCompLength").focus();
				return;
			}
			else if(SuppWeight == "")
			{
				alert("PLease enter the Supplier Weigth");
				document.getElementById("txtSuppWeight").focus();
				return;
			}
			else if(CompWeight == "")
			{
				alert("PLease enter the Company Weigth");
				document.getElementById("txtCompWeight").focus();
				return;
			}
			Disablead();

	
	var WidthUOM			= document.getElementById('cboWidthUOM').value;
	//alert(WidthUOM);
	var LengthUOM			= document.getElementById('cboLengthUOM').value;
	//alert(LengthUOM);
	var WeightUOM			= document.getElementById('cboWeightUOM').value;
	//alert(WeightUOM);
			
			var SpecialComment		= document.getElementById('txtSpecialComment').value;
			var booCheck =false;
		
			for (var mainLoop =1;mainLoop < tblMain.rows.length; mainLoop++){
					var mainRollNo = tblMain.rows[mainLoop].cells[1].childNodes[0].nodeValue;					
					if(RollNo==mainRollNo){
						booCheck =true;
						alert ("Roll No : "+RollNo+"\nalready added");
						document.getElementById("txtRollNo").focus();
					}
				}
		
		if (booCheck == false){
			var lastRow 			= tblMain.rows.length;	
			var row 				= tblMain.insertRow(lastRow);	
			
			row.className="bcgcolor-tblrow";
			
			var cellDelete = row.insertCell(0); 			
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<div onClick=\"RemoveItem(this);\" align=\"center\"><img src=\"../images/del.png\" /></div>"; 		
					
			var cellDescription = row.insertCell(1);
			cellDescription.className ="normalfnt";		
			cellDescription.id="new";
			cellDescription.innerHTML =RollNo ;			
					
			var cellIBuyerPoNo = row.insertCell(2);
			cellIBuyerPoNo.className ="normalfntMid";			
			cellIBuyerPoNo.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\"  style=\"text-align:right;\" value=\""+SuppWith+"\" />";			
					
			var cellColor = row.insertCell(3);
			cellColor.className ="normalfntMid";						
			cellColor.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+CompWidth+"\" />";
					
			var cellSize = row.insertCell(4);
			cellSize.className ="normalfntMid";			
			cellSize.innerHTML =WidthUOM;			
					
			var cellUnits = row.insertCell(5);
			cellUnits.className ="normalfntMid";			
			cellUnits.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+SuppLength+"\" />";			
					
			var cell = row.insertCell(6);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+CompLength+"\" />";
			
			var cell = row.insertCell(7);
			cell.className ="normalfntMid";			
			cell.innerHTML =LengthUOM;
			
			var cell = row.insertCell(8);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+SuppWeight+"\" />";
			
			var cell = row.insertCell(9);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+CompWeight+"\" />";
			
			var cell = row.insertCell(10);
			cell.className ="normalfntMid";			
			cell.innerHTML =WeightUOM;
			
			var cell = row.insertCell(11);
			cell.className ="normalfnt";		
			cell.innerHTML ="<input type=\"text\" name=\"txtSpecalComments\" id=\"txtSpecalComments\" class=\"txtbox\" size=\"40\" style=\"text-align:left\" value=\""+SpecialComment+"\" />";
		}
		document.getElementById('txtRollNo').focus();
}

function Disablead(){
	document.getElementById("cboPoNo").disabled="disabled";
	document.getElementById("cboYear").disabled="disabled";
	document.getElementById("cboStyleId").disabled="disabled";	
	document.getElementById("cboBuyerPoNo").disabled="disabled";
	document.getElementById("cboScNo").disabled="disabled";
	document.getElementById("cboDescription").disabled="disabled";
	document.getElementById("cboColor").disabled="disabled";
	document.getElementById("cboSupplier").disabled="disabled";
}

function SelectPoNo()
{
	var PoNo 		= document.getElementById('cboPoNo').value;
	var Supplier 	= document.getElementById('cboSupplier').value;	
	var StyleNo 	= document.getElementById('cboStyleId').value;
	var ScNo 		= document.getElementById('cboScNo').value;	
	var BuyerPoNo 	= document.getElementById('cboBuyerPoNo').value;
	var ItemDes 	= document.getElementById('cboDescription').value;	
	var Color 		= document.getElementById('cboColor').value;
	
	if(PoNo == "")
	{
		alert("PLease enter the Po No");
		document.getElementById("cboPoNo").focus();
		return;
	}	
	else if(Supplier == "")
	{
		alert("PLease enter the Supplier");
		document.getElementById("cboSupplier").focus();
		return;
	}
	else if(StyleNo == "")
	{
		alert("PLease enter the Style No");
		document.getElementById("cboStyleId").focus();
		return;
	}
	else if(ScNo == "")
	{
		alert("PLease enter the ScNo");
		document.getElementById("cboScNo").focus();
		return;
	}
	else if(BuyerPoNo == "")
	{
		alert("PLease enter the Buyer Po No");
		document.getElementById("cboBuyerPoNo").focus();
		return;
	}
	else if(ItemDes == "")
	{
		alert("PLease enter the Item Description");
		document.getElementById("cboDescription").focus();
		return;
	}
	else if(Color == "")
	{
		alert("PLease enter the Color");
		document.getElementById("cboColor").focus();
		return;
	}
}


function SaveValidation(){
	
	
	var tblMain=document.getElementById('tblMain')
	//alert(tblMain.rows.length); 
	if(tblMain.rows.length <=1){
		alert("No details appear to save....");
		return;
		}	
	else{
		LoadRollSerialNo()
	}
	
}

function LoadRollSerialNo()
{
	
	var No = document.getElementById("txtFabricRollSerialNO").value
	//alert(No);
	if (No=="")
	{
		/*createXMLHttpRequest(6);
		xmlHttp[6].onreadystatechange=LoadRollSerialNoRequest;
		xmlHttp[6].open("GET",'fabricrollinspectionxml.php?RequestType=LoadNo',true);
		xmlHttp[6].send(null);*/
		var path="fabricrollinspectionxml.php?RequestType=LoadNo";
		htmlobj=$.ajax({url:path,async:false});
		var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
		if(XMLAdmin=="TRUE"){
			var XMLNo 	= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
			var XMLYear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
			pub_rollSerialNo =parseInt(XMLNo);
			pub_rollSerialYear = parseInt(XMLYear);
			document.getElementById("txtFabricRollSerialNO").value=pub_rollSerialYear + "/" + pub_rollSerialNo;			
			Save();				
			}
		else{
			alert("Please contact system administrator to Assign New Fabric Roll No....");
		}
	}
	else
	{		
		No = No.split("/");
		
		pub_returnToSupNo =parseInt(No[1]);
		pub_returnToSupYear = parseInt(No[0]);	
		updateRecords(pub_returnToSupNo,pub_returnToSupYear);
	}
}

/*function LoadRollSerialNoRequest(){
	if (xmlHttp[6].readyState==4){
		if (xmlHttp[6].status==200){
			var XMLAdmin	= xmlHttp[6].responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
				if(XMLAdmin=="TRUE"){
					var XMLNo 	= xmlHttp[6].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
					var XMLYear = xmlHttp[6].responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
					pub_rollSerialNo =parseInt(XMLNo);
					pub_rollSerialYear = parseInt(XMLYear);
					document.getElementById("txtFabricRollSerialNO").value=pub_rollSerialYear + "/" + pub_rollSerialNo;			
					Save();				
				}
				else{
					alert("Please contact system administrator to Assign New Fabric Roll No....");
				}
			}
		}
		
	}*/
	
function AutoType()
{
	document.getElementById('txtCompBatchNo').value = document.getElementById('txtSupBatchNo').value;	
}	
	
function Save(){
	
	var year			= document.getElementById("cboYear").options[document.getElementById("cboYear").selectedIndex].text;
	var PoNo			= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
	var SupplierID		= document.getElementById("cboSupplier").value;
	var styleId			= document.getElementById("cboStyleId").value;
	//var Style			= document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	var BuyerPoNo		= document.getElementById("cboBuyerPoNo").options[document.getElementById("cboBuyerPoNo").selectedIndex].text;
		//BuyerPoNo 		= BuyerPoNo.replace("#Main Ratio#","Main Ratio");
	var MatDetailID		= document.getElementById("cboDescription").value;
	//var ItemDescription	= document.getElementById("cboDescription").options[document.getElementById("cboDescription").selectedIndex].text;
	var Color			= document.getElementById("cboColor").options[document.getElementById("cboColor").selectedIndex].text;
	
	var SupBatchNo		= document.getElementById("txtSupBatchNo").value;
	var CompBatchNo		= document.getElementById("txtCompBatchNo").value;
	
	var Remarks			= document.getElementById("txtRemarks").value;
	var tblMain 		= document.getElementById('tblMain');
	var mainStoreID		= document.getElementById('storesID').title;
	
	var path='fabricrollinspectionxml.php?RequestType=SaveHeader&rollSerialNo=' +pub_rollSerialNo+ '&rollSerialYear=' +pub_rollSerialYear+ '&PoNo=' +PoNo+  '&year=' +year+ '&SupplierID=' +SupplierID+ '&styleId=' +styleId+ '&MatDetailID=' +MatDetailID+ '&Color=' +Color+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&SupBatchNo=' +URLEncode(SupBatchNo)+ '&CompBatchNo=' +URLEncode(CompBatchNo)+ '&Remarks=' +Remarks+ '&mainStoreID=' +mainStoreID;
	
	//alert(path);
	
		htmlobj=$.ajax({url:path,async:false});
		//alert(htmlobj.responseText);
		
		if(htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue==1){
			//alert(tblMain.rows.length)
			for (loop = 1 ; loop < tblMain.rows.length ; loop ++){
				var RollNo			= tblMain.rows[loop].cells[1].innerHTML;
				var SuppWidth		= tblMain.rows[loop].cells[2].childNodes[0].value;
				var CompWidth		= tblMain.rows[loop].cells[3].childNodes[0].value;
				var WidthUOM		= tblMain.rows[loop].cells[4].innerHTML;
				var SuppLength		= tblMain.rows[loop].cells[5].childNodes[0].value;
				var CompLength		= tblMain.rows[loop].cells[6].childNodes[0].value;
				var LengthUOM		= tblMain.rows[loop].cells[7].innerHTML;
				var SuppWeight		= tblMain.rows[loop].cells[8].childNodes[0].value;
				var CompWeight		= tblMain.rows[loop].cells[9].childNodes[0].value;
				var WeighUOM		= tblMain.rows[loop].cells[10].innerHTML;
				var SpecialComm		= tblMain.rows[loop].cells[11].childNodes[0].value;
				//var SpecialComm		= 'special';
					validateCount++;
			
				var path='fabricrollinspectionxml.php?RequestType=SaveDetails&rollSerialNo=' +pub_rollSerialNo+ '&rollSerialYear=' +pub_rollSerialYear+ '&RollNo=' +RollNo+ '&SuppWidth=' +SuppWidth+ '&CompWidth=' +CompWidth+ '&WidthUOM=' +WidthUOM+ '&SuppLength=' +SuppLength+ '&CompLength=' +CompLength+ '&LengthUOM=' +LengthUOM+ '&SuppWeight=' +SuppWeight+ '&CompWeight=' +CompWeight+ '&WeighUOM=' +WeighUOM+ '&SpecialComm=' +SpecialComm+'&rc='+loop;
				//alert(path);
				//return false;
				htmlobj=$.ajax({url:path,async:false});
				
				
				/*if(htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue == tblMain.rows.length-1){
					SaveValidate();
				}*/
			}	
			SaveValidate();	
		}
		else{
			alert('Header saving error.');
			}
}

function SaveValidate(){	
	var path='fabricrollinspectionxml.php?RequestType=SaveValidate&rollSerialNo=' +pub_rollSerialNo+ '&rollSerialYear=' +pub_rollSerialYear+ '&validateCount=' +validateCount ;
	htmlobj=$.ajax({url:path,async:false});
	var XMLCountHeader= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var XMLCountDetails= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;
	if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE")){
			alert ("Fabric Roll Serial No : " + document.getElementById("txtFabricRollSerialNO").value + " Save and Confirmed Successfully!");							
			RestrictInterface(1);
		}
		else{
			SaveValidate();											
		}	
	
}

/*function SaveValidateRequest()
{
		if(xmlHttp[8].readyState == 4) 
		{
			if(xmlHttp[8].status == 200)
			{				
				var XMLCountHeader= xmlHttp[8].responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
				var XMLCountDetails= xmlHttp[8].responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;								
				
					if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE")){
						alert ("Fabric Roll Serial No : " + document.getElementById("txtFabricRollSerialNO").value + " Confirmed Successfully!");							
					RestrictInterface(1);
						
					}
					else{
						SaveValidate();											
					}			
			}
		}
	}*/
	
function RestrictInterface(XMLStatus){
	switch (XMLStatus){	
	case 1:
		document.getElementById("cmdSave").style.visibility="hidden";
		document.getElementById('imgDiv').innerHTML="<img src=\"../images/revise.png\" id=\"cmdRevise\" alt=\"revise\"  onclick=\"revise();\" class=\"mouseover\"  />";
		document.getElementById("cmdCancel").style.visibility="visible";
		//document.getElementById("cmdAddNew").style.visibility="hidden";
	break;
	}
}

function ViewReport(){
/*	document.getElementById('NoSearch').style.visibility=="hidden"
	var RollYear	= document.getElementById('cboPopupYear').value;
	var RollNo		= document.getElementById('cboNo').options[document.getElementById("cboNo").selectedIndex].text;*/
	var no	= document.getElementById('txtFabricRollSerialNO').value;
	var no = no.split('/');
	var RollYear 	= no[0];
	var RollNo		= no[1];
	newwindow=window.open('fabricrollstikerprint.php?RollNo='+RollNo+ '&RollYear=' +RollYear ,'stikerPrint');
	if (window.focus) {newwindow.focus()}
}

function SearchPopUp()
{
if(document.getElementById('NoSearch').style.visibility=="hidden")
{
	document.getElementById('NoSearch').style.visibility = "visible";
	LoadPopUpNo();
}
	else
	{
	document.getElementById('NoSearch').style.visibility="hidden";
	return;
	}	
}

function LoadPopUpNo()
{
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state=document.getElementById('cboState').value;
	var year=document.getElementById('cboPopupYear').value;
	
 	createXMLHttpRequest(9);
    xmlHttp[9].onreadystatechange = LoadPopUpJobNoRequest;
    xmlHttp[9].open("GET", 'fabricrollinspectionxml.php?RequestType=LoadPopUpReturnNo&state='+state+'&year='+year, true);
    xmlHttp[9].send(null); 
	
}

function LoadPopUpJobNoRequest()
{
    if(xmlHttp[9].readyState == 4) 
    {
        if(xmlHttp[9].status == 200) 
        {  
			var PopUpXML 	= xmlHttp[9].responseText;
			document.getElementById("cboNo").innerHTML=PopUpXML;			 
		}
	}
}

function LoadRollPlanPopUp(obj){	
	drawPopupArea(362,190,'RollPlanPopUp');
	//LoadPopUpRollNo();
	document.getElementById("RollPlanPopUp").innerHTML =document.getElementById('divRollPlanPopUp').innerHTML;
	document.getElementById('divRollPlanPopUp').innerHTML="";		
	
}
function closePOP(){
	document.getElementById('divRollPlanPopUp').innerHTML = document.getElementById("RollPlanPopUp").innerHTML;	
	closeWindow();
}

function LoadDetailToMainPage(){	

	var popUpRollNo	= document.getElementById('cboPopUpRollNo').value.trim();
	var popUpBatchNo=document.getElementById('cboPopUpSupplierBatchNo').value.trim();
	document.getElementById('txtFabricRollSerialNO').value=popUpRollNo;
	createXMLHttpRequest(9);
    xmlHttp[9].onreadystatechange = LoadHeaderDetailsToMainRequest;
    xmlHttp[9].open("GET", 'fabricrollinspectionxml.php?RequestType=LoadHeaderDetailsToMain&No='+popUpRollNo+'&batchNo='+popUpBatchNo ,true);
    xmlHttp[9].send(null); 

}

function LoadHeaderDetailsToMainRequest(){
	if(xmlHttp[9].readyState == 4 && xmlHttp[9].status == 200){	
		var XMLFRollSerialNO	=	xmlHttp[9].responseXML.getElementsByTagName("FRollSerialNo");
		
		var popUpRollNo = XMLFRollSerialNO[0].childNodes[0].nodeValue;
		
		document.getElementById('txtFabricRollSerialNO').value=XMLFRollSerialNO[0].childNodes[0].nodeValue;
		
		var XMLPoNo 	= xmlHttp[9].responseXML.getElementsByTagName("PoNo");
		var XMLPoYear 	= xmlHttp[9].responseXML.getElementsByTagName("PoYear");
			RomoveData('cboPoNo');
				var opt = document.createElement("option");
				opt.text 	= XMLPoNo[0].childNodes[0].nodeValue;
				opt.value   = XMLPoNo[0].childNodes[0].nodeValue;
				document.getElementById('cboPoNo').options.add(opt);
				
			RomoveData('cboYear');
				var opt = document.createElement("option");
				opt.text 	= XMLPoYear[0].childNodes[0].nodeValue;
				opt.value   = XMLPoYear[0].childNodes[0].nodeValue;
				document.getElementById('cboYear').options.add(opt);
	
		var XMLSRNO = xmlHttp[9].responseXML.getElementsByTagName("SRNO");
		var XMLStyleID = xmlHttp[9].responseXML.getElementsByTagName("StyleID");
		
			RomoveData('cboScNo');
				var opt = document.createElement("option");
				opt.text 	= XMLSRNO[0].childNodes[0].nodeValue;
				opt.value   = XMLStyleID[0].childNodes[0].nodeValue;
				document.getElementById('cboScNo').options.add(opt);
				
			RomoveData('cboStyleId');
				var opt = document.createElement("option");
				opt.text 	= XMLStyleID[0].childNodes[0].nodeValue;
				opt.value   = XMLSRNO[0].childNodes[0].nodeValue;
				document.getElementById('cboStyleId').options.add(opt);
				
		var XMLBuyerPoNo = xmlHttp[9].responseXML.getElementsByTagName("BuyerPoNo");
		
			RomoveData('cboBuyerPoNo');
				var opt = document.createElement("option");
				opt.text = XMLBuyerPoNo[0].childNodes[0].nodeValue;
				opt.value = XMLBuyerPoNo[0].childNodes[0].nodeValue;
				document.getElementById('cboBuyerPoNo').options.add(opt);
				
		var XMLSupplierBatchNo = xmlHttp[9].responseXML.getElementsByTagName("SupplierBatchNo")[0].childNodes[0].nodeValue;
			document.getElementById('txtSupBatchNo').value = XMLSupplierBatchNo;
		var XMLCompanyBatchNo = xmlHttp[9].responseXML.getElementsByTagName("CompanyBatchNo")[0].childNodes[0].nodeValue;
			document.getElementById('txtCompBatchNo').value = XMLCompanyBatchNo;
			
		var XMLColor = xmlHttp[9].responseXML.getElementsByTagName("Color");
			RomoveData('cboColor');
				var opt = document.createElement("option");
				opt.text = XMLColor[0].childNodes[0].nodeValue;				
				document.getElementById('cboColor').options.add(opt);
		
		var XMLSupplierID = xmlHttp[9].responseXML.getElementsByTagName("SupplierID");
		var XMLSupplierName = xmlHttp[9].responseXML.getElementsByTagName("SupplierName");
		RomoveData('cboSupplier');
				var opt = document.createElement("option");
				opt.text = XMLSupplierName[0].childNodes[0].nodeValue;
				opt.value = XMLSupplierID[0].childNodes[0].nodeValue;
				document.getElementById('cboSupplier').options.add(opt);
				
		var XMLMatDetailID = xmlHttp[9].responseXML.getElementsByTagName("MatDetailID");
		var XMLItemDescription = xmlHttp[9].responseXML.getElementsByTagName("ItemDescription");
		RomoveData('cboDescription');
				var opt = document.createElement("option");
				opt.text = XMLItemDescription[0].childNodes[0].nodeValue;
				opt.value = XMLMatDetailID[0].childNodes[0].nodeValue;
				document.getElementById('cboDescription').options.add(opt);	
				
		var XMLRemarks = xmlHttp[9].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;	
				document.getElementById('txtRemarks').value = XMLRemarks;		
		var XMLStatus= xmlHttp[9].responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
		
		//------------
		createXMLHttpRequest(10);
		xmlHttp[10].onreadystatechange = LoadDetailsToMainRequest;
		xmlHttp[10].open("GET", 'fabricrollinspectionxml.php?RequestType=LoadDetailsToMainRequest&No='+popUpRollNo ,true);
		xmlHttp[10].send(null); 
		//-----------
		
		if(XMLStatus==1){
			document.getElementById('imgDiv').innerHTML="<img src=\"../images/revise.png\" id=\"cmdRevise\" alt=\"revise\"  onclick=\"revise();\" class=\"mouseover\"  />";

		}
		else{
			document.getElementById('imgDiv').innerHTML="<img src=\"../images/save-confirm.png\" id=\"cmdSave\" alt=\"save_confirm\" width=\"174\" height=\"24\" onclick=\"SaveValidation();\" class=\"mouseover\"/>";

		}

	}

}

function LoadDetailsToMainRequest(){
	if(xmlHttp[10].readyState == 4 && xmlHttp[10].status == 200){
		var XMLRollNo = xmlHttp[10].responseXML.getElementsByTagName("RollNo");
		var XMLSuppWidth = xmlHttp[10].responseXML.getElementsByTagName("SuppWidth");
		var XMLCompWidth = xmlHttp[10].responseXML.getElementsByTagName("CompWidth");
		var XMLWidthUOM = xmlHttp[10].responseXML.getElementsByTagName("WidthUOM");
		var XMLSuppLength = xmlHttp[10].responseXML.getElementsByTagName("SuppLength");
		var XMLCompLength = xmlHttp[10].responseXML.getElementsByTagName("CompLength");
		var XMLLengthUOM = xmlHttp[10].responseXML.getElementsByTagName("LengthUOM");
		var XMLSuppWeight = xmlHttp[10].responseXML.getElementsByTagName("SuppWeight");
		var XMLCompWeight = xmlHttp[10].responseXML.getElementsByTagName("CompWeight");
		var XMLWeightUOM = xmlHttp[10].responseXML.getElementsByTagName("WeightUOM");
		var XMLSpecialComments= xmlHttp[10].responseXML.getElementsByTagName("SpecialComments");
		var XMLApproved= xmlHttp[10].responseXML.getElementsByTagName("Approved");
		
		
		RemoveAllRows('tblMain');
		var tblMain 			= document.getElementById('tblMain');	
		var lastRow 			= tblMain.rows.length;	
		//var row 				= tblMain.insertRow(lastRow);
		
		for(var loop=0;loop<XMLRollNo.length;loop++){
			var lastRow 			= tblMain.rows.length;	
			var row 				= tblMain.insertRow(lastRow);
			var rd="";
			row.className=""
			
			if(XMLApproved[loop].childNodes[0].nodeValue==1)
			{
				//rd="readonly=\"readonly\"";
				rd="disabled=\"disabled\"";
				row.className="bcgcolor-tblrow";
			}
			else{
				row.className="bcgcolor-tblrowWhite";
			}
			
			
			
			
			var cellDelete = row.insertCell(0); 			
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<div onClick=\"RemoveItem(this);\" align=\"center\" ><img src=\"../images/del.png\" /></div>"; 		
				
			var cellDescription = row.insertCell(1);
			cellDescription.className ="normalfnt";			
			cellDescription.innerHTML =XMLRollNo[loop].childNodes[0].nodeValue;			
				
			var cellIBuyerPoNo = row.insertCell(2);
			cellIBuyerPoNo.className ="normalfntMid";			
			cellIBuyerPoNo.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right;\" value=\""+XMLSuppWidth[loop].childNodes[0].nodeValue+"\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+"/>";		
				 
			var cellColor = row.insertCell(3);
			cellColor.className ="normalfntMid";						
			cellColor.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLCompWidth[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+"/>";
				
			var cellSize = row.insertCell(4);
			cellSize.className ="normalfntMid";			
			cellSize.innerHTML =XMLWidthUOM[loop].childNodes[0].nodeValue;			
				
			var cellUnits = row.insertCell(5);
			cellUnits.className ="normalfntMid";			
			cellUnits.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLSuppLength[loop].childNodes[0].nodeValue	+"\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+"/>";
					
				
			var cell = row.insertCell(6);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLCompLength[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+"/>";
			
			var cell = row.insertCell(7);
			cell.className ="normalfntMid";			
			cell.innerHTML =XMLLengthUOM[loop].childNodes[0].nodeValue;
			
			var cell = row.insertCell(8);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLSuppWeight[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+" />";
			
			var cell = row.insertCell(9);
			cell.className ="normalfntMid";			
			cell.innerHTML ="<input type=\"text\" name=\"\" id=\"\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLCompWeight[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+"/>";
			
			var cell = row.insertCell(10);
			cell.className ="normalfntMid";			
			cell.innerHTML =XMLWeightUOM[loop].childNodes[0].nodeValue;
			
			var cell = row.insertCell(11);
			cell.className ="normalfnt";		
			cell.innerHTML ="<input type=\"text\" name=\"txtSpecalComments\" id=\"txtSpecalComments\" class=\"txtbox\" size=\"40\" style=\"text-align:left\" value=\""+XMLSpecialComments[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" "+rd+" />";
		}
		closePOP();
		//document.getElementById('cmdSave').style.visibility='hidden';
		//document.getElementById('cmdSave').src="../images/revise.png";
	}
}

function LoadPopUpRollNo(){
 
	var batchNo = document.getElementById('cboPopUpSupplierBatchNo').value;
	var SupplierID = document.getElementById('cboPopUpSupplier').value;
	var path='fabricrollinspectionxml.php?RequestType=LoadPopUpRollNo&batchNo='+batchNo+ '&SupplierID=' +SupplierID;
	
	htmlobj=$.ajax({url:path,async:false});
	
	var result=htmlobj.responseXML.getElementsByTagName("PO");
	document.getElementById('cboPopUpRollNo').innerHTML="<option value=\"\"></option>";
		if(result.length > 0){
			for(var i=0;i<result.length;i++){
				var opt = document.createElement("option");
				opt.value = result[i].childNodes[0].nodeValue;	
				opt.text = result[i].childNodes[0].nodeValue;	
				document.getElementById("cboPopUpRollNo").options.add(opt);
			}
	}
}
function LoadPopUpBatchNo(){
	var batchNo = document.getElementById('cboPopUpSupplierBatchNo').value;
	var SupplierID = document.getElementById('cboPopUpSupplier').value;
	var path='fabricrollinspectionxml.php?RequestType=LoadPopUpBatchNo&batchNo='+batchNo+ '&SupplierID=' +SupplierID;
	htmlobj=$.ajax({url:path,async:false});
	var result=htmlobj.responseXML.getElementsByTagName("Batch");
	document.getElementById('cboPopUpSupplierBatchNo').innerHTML="<option value=\"\"></option>";
		if(result.length > 0){
			for(var i=0;i<result.length;i++){
				var opt = document.createElement("option");
				opt.value = result[i].childNodes[0].nodeValue;	
				opt.text = result[i].childNodes[0].nodeValue;	
				document.getElementById("cboPopUpSupplierBatchNo").options.add(opt);
			}
	}
}
/*function LoadPopUpRollNoRequest(){
	if(xmlHttp[11].readyState==4 && xmlHttp[11].Statue==200){
		var XMLPoNo= xmlHttp[11].responseText;
			document.getElementById('cboPopUpRollNo').innerHTML = XMLPoNo;
	}
}*/

function LoadSupplierToMode(companyId)
{
	var Mode = document.getElementById('cboMode').value;
	
	//alert(Mode);
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadSupplierToMode&Mode=" +Mode + '&companyId=' + companyId;
	//alert(url);
	
	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	
	document.getElementById('cboPopUpSupplier').innerHTML = htmlobj.responseText;
	
	 //var XMLSupplierId = htmlobj.responseXML.getElementsByTagName("SuppId")[0].childNodes[0].nodeValue;
//	 var XMLSupplier = htmlobj.responseXML.getElementsByTagName("Supp")[0].childNodes[0].nodeValue;
//	 
//	 document.getElementById('cboPopUpSupplier').value = XMLSupplierId;
//	 document.getElementById('cboPopUpSupplier').nodeValue = XMLSupplier;
	 //alert(document.getElementById('cboPopUpSupplier').value);
	
}

function LoadSuppBatchNo(companyId)
{
	var Mode = document.getElementById('cboMode').value;
	var SupplierId = document.getElementById('cboPopUpSupplier').value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadSuppBatchNo&Mode=" + Mode + '&SupplierId=' + SupplierId + '&companyId=' + companyId;
	//alert(url);
	
	htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	document.getElementById('cboPopUpSupplierBatchNo').innerHTML = htmlobj.responseText;
	//alert(document.getElementById('cboPopUpSupplierBatchNo').innerHTML);		
}


function LoadRollNoToMode(companyId)
{
	var Mode = document.getElementById('cboMode').value;
	var SupplierId = document.getElementById('cboPopUpSupplier').value;
	var SuppBatchNo = document.getElementById('cboPopUpSupplierBatchNo').value;
	
	var url = "fabricrollinspectionxml.php?RequestType=LoadRollNoToMode&Mode=" + Mode + '&SupplierId=' + SupplierId + '&SuppBatchNo=' + SuppBatchNo + '&companyId=' + companyId;
	
	htmlobj = $.ajax({url:url,async:false});
	
	document.getElementById('cboPopUpRollNo').innerHTML = htmlobj.responseText;
}
	
function Cancel()
{
	var rollSerialNo	= document.getElementById('txtFabricRollSerialNO').value;
	//alert(rollSerialNo);
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = CancelRequest;
	xmlHttp[1].open("GET", 'fabricrollinspectionxml.php?RequestType=Cancel&rollSerialNo='+rollSerialNo ,true);
	xmlHttp[1].send(null);
}
	function CancelRequest(){
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200){
			var XMLResult = xmlHttp[1].responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
			
		}
		
		if(XMLResult == 1){
			alert("Canceled");
			document.getElementById('cmdCancel').style.visibility='hidden';
			ClearForm();
		}
	}

function loadQty(objC,objS){
	var c=objC.value.trim();
	objS.value=c;
	//objS.value.trim()=objC.value.trim();
}


function revise(){
	var rollSerialNo	= 	document.getElementById('txtFabricRollSerialNO').value;
	var path="fabricrollinspectionxml.php?RequestType=revise&rollSerialNo="+rollSerialNo;
	htmlobj=$.ajax({url:path,async:false});
	var result=htmlobj.responseXML.getElementsByTagName("Result");
	if(result[0].childNodes[0].nodeValue==1){
		alert("Fabric roll is revised");
			document.getElementById('imgDiv').innerHTML="<img src=\"../images/save-confirm.png\" id=\"cmdSave\" alt=\"save_confirm\" width=\"174\" height=\"24\" onclick=\"SaveValidation();\" class=\"mouseover\"/>";
	}
}


function updateRecords(pub_returnToSupNo,pub_returnToSupYear){
	var path="fabricrollinspectionxml.php?RequestType=updateHeader&rollSerialNo="+pub_returnToSupNo+"&serialYear="+pub_returnToSupYear;
	
	htmlobj=$.ajax({url:path,async:false});
	var result=htmlobj.responseXML.getElementsByTagName("Result");
	
	var tblMain=document.getElementById('tblMain');
	var rc=tblMain.rows.length-1;
	var res;
	var rollSerialNo	= 	document.getElementById('txtFabricRollSerialNO').value;
	if(result[0].childNodes[0].nodeValue==1){
		
		for (loop = 1 ; loop < tblMain.rows.length ; loop ++){
		var RollNo			= tblMain.rows[loop].cells[1].innerHTML;
		var SuppWidth		= tblMain.rows[loop].cells[2].childNodes[0].value;
		//alert(SuppWidth);
		var rType="updateDet";
		//.childNodes[0].nodeValue
		var CompWidth		= tblMain.rows[loop].cells[3].childNodes[0].value;
		var WidthUOM		= tblMain.rows[loop].cells[4].innerHTML;
		var SuppLength		= tblMain.rows[loop].cells[5].childNodes[0].value;
		var CompLength		= tblMain.rows[loop].cells[6].childNodes[0].value;
		var LengthUOM		= tblMain.rows[loop].cells[7].innerHTML;
		var SuppWeight		= tblMain.rows[loop].cells[8].childNodes[0].value;
		var CompWeight		= tblMain.rows[loop].cells[9].childNodes[0].value;
		var WeighUOM		= tblMain.rows[loop].cells[10].innerHTML;
		var SpecialComm		= tblMain.rows[loop].cells[11].childNodes[0].value;
		//alert(tblMain.rows[loop].cells[1].id);
		if(tblMain.rows[loop].cells[1].id=="new")
		{
			SuppWidth		= tblMain.rows[loop].cells[2].childNodes[0].value;
			CompWidth		= tblMain.rows[loop].cells[3].childNodes[0].value;
			WidthUOM		= tblMain.rows[loop].cells[4].innerHTML;
			SuppLength		= tblMain.rows[loop].cells[5].childNodes[0].value;
			CompLength		= tblMain.rows[loop].cells[6].childNodes[0].value;
			LengthUOM		= tblMain.rows[loop].cells[7].innerHTML;
			SuppWeight		= tblMain.rows[loop].cells[8].childNodes[0].value;
			CompWeight		= tblMain.rows[loop].cells[9].childNodes[0].value;
			WeighUOM		= tblMain.rows[loop].cells[10].innerHTML;
			var SpecialComm	= tblMain.rows[loop].cells[11].childNodes[0].value;
			var serial		= document.getElementById('txtFabricRollSerialNO').value.trim().split("/");
			
			rType="SaveDetails&rollSerialYear="+serial[0]+"&rollSerialNo="+serial[1];
		}
		else{
			rType+= '&rollSerialNo='+rollSerialNo+''; 
		}
		//var SpecialComm		= 'special';
			validateCount++;

		var url='fabricrollinspectionxml.php?RequestType='+rType+'&RollNo=' +RollNo+ '&SuppWidth=' +SuppWidth+ '&CompWidth=' +CompWidth+ '&WidthUOM=' +WidthUOM+ '&SuppLength=' +SuppLength+ '&CompLength=' +CompLength+ '&LengthUOM=' +LengthUOM+ '&SuppWeight=' +SuppWeight+ '&CompWeight=' +CompWeight+ '&WeighUOM=' +WeighUOM+ '&SpecialComm=' +SpecialComm+'&r='+loop ;
			htmlobj=$.ajax({url:url,async:false});
			//alert(url);
			
		}
			alert('Updated successfully.');
			document.getElementById('imgDiv').innerHTML="<img src=\"../images/revise.png\" id=\"cmdRevise\" alt=\"revise\"  onclick=\"revise();\" class=\"mouseover\"  />";
		

	}
}