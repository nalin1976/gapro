// JavaScript Document

var xmlHttp;
var intTotalRecords = 0;
var intCompleteValue = 0;
var intMaxDeliveries = 0;
var intSelectedTab = 0;

var arrStyleCodes = new Array();

$(document).ready(function(e) {
    $("#revise-order").click(function(){
		intSelectedTab = 2;
		document.getElementById("imgUpdate").style.display = 'block';
		document.getElementById("btnCreateFile").style.display = 'none';
		ListToReviseOrders(this.id);
			
	});
	
	$("#revise-product").click(function(){
		intSelectedTab = 3;
		document.getElementById("imgUpdate").style.display = 'block';
		document.getElementById("btnCreateFile").style.display = 'none';
		ListToReviseOrders(this.id);
	});
	
	$("#list-orders").click(function(){
		document.getElementById("btnCreateFile").style.display = 'block';
		LoadNotTransferList();
	});
	
	$("#imgClose").click(function(){
		window.location = "../main.php";
	});
	
	$("#imgUpdate").click(function(){
		UpdateOrderTransferStatus();
	});
	
	
	
	
});

function createXMLHttpRequest(){
	if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function stateChanged() 
{
   
	if(xmlHttp.readyState==4)
      {
		  if(xmlHttp.status == 200) {
		var XMLOrders 	= xmlHttp.responseXML.getElementsByTagName("NoOfOrders");	  
		  
intTotalRecords=XMLOrders[0].childNodes[0].nodeValue;

/*document.getElementById('txtRecCnt').innerHTML = intTotalRecords;*/
document.getElementById('p').max = 100;//intTotalRecords;
			GetOrdersList();
			
	  	}
      }
}

function GetOrderCnt(){

createXMLHttpRequest();	
var url="orders.php?request=orderCount";
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("POST", url, true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send();  


}



function GetOrdersList(){
createXMLHttpRequest();	
var url="orders.php?request=orderlist";
xmlHttp.onreadystatechange=setOrders;
xmlHttp.open("POST", url, true)
//xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
xmlHttp.send(null);

}

function setOrders() 
{
    if(xmlHttp.readyState==4)
    {
		if(xmlHttp.status == 200) 
        {  
			var XMLOrders 	= xmlHttp.responseXML.getElementsByTagName("scno");
			var XMLStyleCode = xmlHttp.responseXML.getElementsByTagName("styleCode");
			var XMLStyleId = xmlHttp.responseXML.getElementsByTagName("styleID");
			//setTimeout(function(){alert("X")}, 6000);
			for(i=0;i<XMLOrders.length;i++){
				//document.getElementById("p1").value = i;
				var _intScNo = XMLOrders[i].childNodes[0].nodeValue;
				var _intStyleCode = XMLStyleCode[i].childNodes[0].nodeValue;
				var _strStyleId = XMLStyleId[i].childNodes[0].nodeValue;
				
				(function(index, styleCode, styleId){
					//setTimeout(function(){document.getElementById('txtHint').innerHTML +=_intScNo}, 3000);
					//window.setTimeout(function(){document.getElementById('txtHint').innerHTML = index ;}, 4000);
					setTimeout(function(){writeData(index, styleCode, styleId);},500*i);
				})(_intScNo, _intStyleCode, _strStyleId);
				
				(function(prmIndex){
					
					setTimeout(function(){ document.getElementById('p').value = (prmIndex/intTotalRecords)*100; 
											intCompleteValue = Math.round((prmIndex/intTotalRecords)*100);
										  document.getElementById('txtLabel').innerHTML = Math.round((prmIndex/intTotalRecords)*100) + "% Complete";}, 500*i);
					
				})(i+1);
				
			}
			
			
			// Redirect to the order export web page after 60 seconds			
			setTimeout(function(){redirecttolist();}, 60000);
			
		}
    }
	
	
}

function writeData(prmSCNo, prmStyleCode, prmStyleId){
	document.getElementById('txtHint').innerHTML = prmSCNo;
	
	var _intBracketPos = prmStyleId.indexOf("(");
	var _strStylePrefix = prmStyleId.substr(0, _intBracketPos);
	
	if(_intBracketPos > 0)
		_strStylePrefix = prmStyleId.substr(0, _intBracketPos);
	else
		_strStylePrefix = prmStyleId;
	
		
	createXMLHttpRequest();
	var url="orders.php?request=insertOrder&stylecode="+prmStyleCode+"&stylePrefix="+_strStylePrefix;
	//xmlHttp.onreadystatechange = GetRes;
	xmlHttp.open("GET", url);
	xmlHttp.send(null);
	
}

function GetRes(){

	if(xmlHttp.readyState == 4){
	
		if(xmlHttp.status == 200){
			alert(xmlHttp.responseText);
		}
		
	}
	
}

function t(){
	for(var i = 1; i <= 5; i++) 
	{
		(function(index) {
			var td = window.setTimeout(function() { document.getElementById('txtHint').innerHTML = index; }, 1000*i);
		})(i);
	}
}

function redirecttolist(){	
	window.location.assign("orderlist.php");		
	//alert("X");
}

function LoadNotTransferList(){
	
	document.getElementById("imgUpdate").style.display = 'none';
	
	createXMLHttpRequest();
	var url = "orders.php?request=getNoTrList";
	xmlHttp.onreadystatechange = CreateList;
	xmlHttp.open("POST", url);
	xmlHttp.send(null);
	
	
	
}

function CreateList(){
	
	var strHtml = "<table class='tbOrderList' width='100%' border='0' id='tbOrderList'><tr height='28px'><td class='tbHead' width='50px' align='center'>Select</td><td width='60px' class='tbHead'>&nbsp;SC No</td><td width='250px' class='tbHead'>&nbsp;Style Name</td><td class='tbHead' align='right' width='60px'>Order Qty&nbsp;</td><td class='tbHead'>&nbsp;Buyer Name</td><td class='tbHead' align='center'>&nbsp;Delivery Shedule</td></tr>";
	
	//strHtml += "<div class='inner_table'><table width='100%'>";
		
	if(xmlHttp.readyState==4){
		
		if(xmlHttp.status == 200){
			
			var xmlSCNo = xmlHttp.responseXML.getElementsByTagName('scno');
			var xmlStyleName = xmlHttp.responseXML.getElementsByTagName('styleId');
			var xmlOrderQty = xmlHttp.responseXML.getElementsByTagName('orderQty');
			var xmlStyleCode = xmlHttp.responseXML.getElementsByTagName('styleCode');
			var xmlBuyerName = xmlHttp.responseXML.getElementsByTagName('buyerName');
			
			for(i=0; i<xmlSCNo.length; i++){
				
				var _intSCNo = xmlSCNo[i].childNodes[0].nodeValue;
				var _strStyleId = xmlStyleName[i].childNodes[0].nodeValue;
				var _dblOrderQty = xmlOrderQty[i].childNodes[0].nodeValue;
				var _intStyleCode = xmlStyleCode[i].childNodes[0].nodeValue;
				var _strBuyerName = xmlBuyerName[i].childNodes[0].nodeValue;
			
				strHtml += "<tr height='20px' id='tr_"+i+"'><td align='center' class='tdData' width='50px' ><input type='checkbox' id='chk_"+i+"' onclick='selectOrder(this)' value="+_intStyleCode+"></td><td class='tdData' width='60px'>&nbsp;"+_intSCNo+"</td><td width='250px' class='tdData'>&nbsp;"+_strStyleId+"</td><td class='tdData' align='right' width='60px'>"+_dblOrderQty+"&nbsp;</td><td class='tdData'>&nbsp;"+_strBuyerName+"</td><td class='tdData' align='center'><img id="+_intStyleCode+" alt='View Deliveries' src='../images/view2.png'  onmouseover='ViewDelivery(this, event)' onmouseleave='HideDiv()' /></td></tr>";	
				
			}
			
		}
		
	}
	
	strHtml += "</table>";
	
	document.getElementById('tabs-1').innerHTML = strHtml;
	
	
}

function selectOrder(prmObj){
	
	/*var n = $("input:checked").length;
	alert(n);*/
	
}

function ExportFile(){
	
	var _intArrayPos = 0;
	
	intMaxDeliveries = 0;
	
	var _rows = document.getElementById('tbOrderList').getElementsByTagName("tr");
	var isNewFormat = $("#chkNewFormat").is(":checked");
	
	
	
	var intRowCnt = _rows.length;
	
	for(i=1; i<intRowCnt;i++){
		
		var rowId = _rows[i].id;
		
		if(inputList = document.getElementById(rowId).getElementsByTagName("input")){
			
			for(n=0;n<inputList.length;n++){
				if(inputList[n].type=="checkbox"){
					if(inputList[n].checked==true){
						//alert(inputList[n].value);
						arrStyleCodes[_intArrayPos] = inputList[n].value;
						_intArrayPos ++;
						
						GetMaxDeliveries(inputList[n].value);
						
						/*(function(prmCount){
							
							//setTimeout(function(){GetMaxDeliveries(prmCount)},1000);
						})(inputList[n].value);*/
					}
				}
			}
		}		
	}
	
	CreateExportFile(isNewFormat);
	//setTimeout(function(){CreateExportFile()}, 5000);	
	
	
}

function GetMaxDeliveries(prmStyleCode){
	
	/*createXMLHttpRequest();
	var url = "orders.php?request=getMaxDeliveries&styleCode="+prmStyleCode;
	xmlHttp.onreadystatechange = SetMaxDelivery;
	xmlHttp.open("GET", url);
	xmlHttp.send(null);*/
	
	var url = "orders.php?request=getMaxDeliveries&styleCode="+prmStyleCode;
	xmlHttp = $.ajax({type:"POST", url:url, async:false, dataType:"xml"}); //.done(function(){SetMaxDelivery();})
	
	SetMaxDelivery();
	
	}

function SetMaxDelivery(){

	/*if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){*/
			
			var xmlStyleCnt = xmlHttp.responseXML.getElementsByTagName("NoOfDeliveries");
			
			var _intStyleCount = parseInt(xmlStyleCnt[0].childNodes[0].nodeValue);
			//alert(_intStyleCount);
			AssignMaxDelivery(_intStyleCount)
			/*(function(stc){
				//setTimeout(function(){AssignMaxDelivery(stc)}, 500);
			})(_intStyleCount);*/
	/*	}
	}*/
}


//Assign the maximum delivery to the variable
function AssignMaxDelivery(prmNoDeliveries){	
	/*alert(intMaxDeliveries);
	alert(prmNoDeliveries);*/
	if(prmNoDeliveries > intMaxDeliveries){	
		intMaxDeliveries = prmNoDeliveries;			
	}
	
	
	
}

function CreateExportFile(prmIsNewFormat){
		//alert(intMaxDeliveries);
		//alert(arrStyleCodes);
		
	//var url = "orders.php?request=createcsv&nodeli="+intMaxDeliveries+"&arrstyles="+arrStyleCodes;
	//xmlHttp = $.ajax({type:"GET", url:url, async:false});
	var url = "tocsv.php?nodeli="+intMaxDeliveries+"&arrstyles="+arrStyleCodes;
	window.open(url);
        
        var urlRelate = "tocsvrelate.php?arrstyles="+arrStyleCodes;
        window.open(urlRelate);
	
	if(prmIsNewFormat == true){
		var url1 = "tocsvordernew.php?arrstyles="+arrStyleCodes;
		
	}else{	
		var url1 = "tocsvorder.php?nodeli="+intMaxDeliveries+"&arrstyles="+arrStyleCodes;
		
	}
	
	window.open(url1);
        
        
}

function ViewDelivery(imgObject, event){
	var StyleCode = imgObject.id;
	
	SetDivPosition(event, StyleCode)
	
	var sHTML = '';
	
	var url = "orders.php?request=getDeliveries&stylecode="+StyleCode;
	xmlHttp = $.ajax({url:url,async:false});
	
	//var objtBody = document.getElementById('tbodyDelivery');
	
	var xmlBPONo = xmlHttp.responseXML.getElementsByTagName('BuyerPONo');
	var xmlDeliveryQty = xmlHttp.responseXML.getElementsByTagName('BuyerPOQty');
	var xmlDelDate = xmlHttp.responseXML.getElementsByTagName('DeliveryDate');
	var xmlEstimatDate = xmlHttp.responseXML.getElementsByTagName('EstimateDate');
	var xmlHandOverDate = xmlHttp.responseXML.getElementsByTagName('HandOverDate');
	
	for(i=0; i<xmlBPONo.length; i++){
		
		var _BuyerPONo = xmlBPONo[i].childNodes[0].nodeValue;
		var _DeliveryQty = xmlDeliveryQty[i].childNodes[0].nodeValue;
		var _DeliveryDate = xmlDelDate[i].childNodes[0].nodeValue;
		var _EstimatedDate = xmlEstimatDate[i].childNodes[0].nodeValue;
		var _HandOverDate = xmlHandOverDate[i].childNodes[0].nodeValue;
		
		sHTML +="<tr><td class='tdDelivery'>"+_BuyerPONo+"</td><td class='tdDelivery'>"+_DeliveryQty+"</td><td class='tdDelivery'>"+_DeliveryDate.substring(0,10)+"</td><td class='tdDelivery'>"+_EstimatedDate+"</td><td class='tdDelivery'>"+_HandOverDate+"</td></tr>";
		
	}
	
	document.getElementById('tbodyDelivery').innerHTML = sHTML;
}

function SetDivPosition(event, prmObjId){
	
	document.getElementById("divDelivery").style.display = 'block';
	document.getElementById("divDelivery").style.top = "180px";
	document.getElementById("divDelivery").style.left = "970px";	
}

function HideDiv(){

	document.getElementById("divDelivery").style.display = 'none';	
}

function ListToReviseOrders(prmObjectID){
	
	var SelectedObjectId = prmObjectID;
	var DetailsForTable = '';
	var HeaderForTable = '';
	
	switch(SelectedObjectId){
		
		case "revise-order":
		
			HeaderForTable = "<table class='tbOrderList' width='100%' border='0' id='tbOrderProcessedList'><tr height='28px'><td class='tbHead' width='50px' align='center'>Select</td><td width='60px' class='tbHead'>&nbsp;SC No</td><td width='250px' class='tbHead'>&nbsp;Style Name</td><td class='tbHead' align='right' width='60px'>Order Qty&nbsp;</td><td class='tbHead'>&nbsp;Buyer Name</td></tr>";
			
			var url = "orders.php?request=OrdersToRevise";
			xmlHttp = $.ajax({url:url,async:false});
			
			DetailsForTable = ListDataFormat(xmlHttp,"revise-order");
			
			
			AddToTheTab("tabs-2",HeaderForTable,DetailsForTable);
			
		break;
		
		case "revise-product":
		
			HeaderForTable = "<table class='tbOrderList' width='100%' border='0' id='tbProductProcessedList'><tr height='28px'><td class='tbHead' width='50px' align='center'>Select</td><td width='60px' class='tbHead'>&nbsp;SC No</td><td width='250px' class='tbHead'>&nbsp;Style Name</td><td class='tbHead' align='right' width='60px'>Order Qty&nbsp;</td><td class='tbHead'>&nbsp;Buyer Name</td></tr>";
		
			var url = "orders.php?request=ProductsToRevise";
			xmlHttp = $.ajax({url:url,async:false});
			
			DetailsForTable = ListDataFormat(xmlHttp,"revise-product");
			
			
			AddToTheTab("tabs-3",HeaderForTable,DetailsForTable);
		
		break;
		
	}
}

function ListDataFormat(HTTPObject,TabId){
	
	var DetailsForTable='';
	
	var xmlSCNo = HTTPObject.responseXML.getElementsByTagName('scno');
	var xmlStyleName = HTTPObject.responseXML.getElementsByTagName('styleId');
	var xmlOrderQty = HTTPObject.responseXML.getElementsByTagName('orderQty');
	var xmlStyleCode = HTTPObject.responseXML.getElementsByTagName('styleCode');
	var xmlBuyerName = HTTPObject.responseXML.getElementsByTagName('buyerName');
	
	for(i=0; i<xmlSCNo.length; i++){
		
		var _intSCNo = xmlSCNo[i].childNodes[0].nodeValue;
		var _strStyleId = xmlStyleName[i].childNodes[0].nodeValue;
		var _dblOrderQty = xmlOrderQty[i].childNodes[0].nodeValue;
		var _intStyleCode = xmlStyleCode[i].childNodes[0].nodeValue;
		var _strBuyerName = xmlBuyerName[i].childNodes[0].nodeValue;
		
		switch(TabId){
		
			case "revise-order":
			
				DetailsForTable += "<tr height='20px' id='tro_"+i+"'><td align='center' class='tdData' width='50px' ><input type='checkbox' id='chk_"+i+"' onclick='selectOrder(this)' value="+_intStyleCode+"></td><td class='tdData' width='60px'>&nbsp;"+_intSCNo+"</td><td width='250px' class='tdData'>&nbsp;"+_strStyleId+"</td><td class='tdData' align='right' width='60px'>"+_dblOrderQty+"&nbsp;</td><td class='tdData'>&nbsp;"+_strBuyerName+"</td></tr>";	
			
			break;	
			
			case "revise-product":
				DetailsForTable += "<tr height='20px' id='trp_"+i+"'><td align='center' class='tdData' width='50px' ><input type='checkbox' id='chk_"+i+"' onclick='selectOrder(this)' value="+_intStyleCode+"></td><td class='tdData' width='60px'>&nbsp;"+_intSCNo+"</td><td width='250px' class='tdData'>&nbsp;"+_strStyleId+"</td><td class='tdData' align='right' width='60px'>"+_dblOrderQty+"&nbsp;</td><td class='tdData'>&nbsp;"+_strBuyerName+"</td></tr>";	
			break;
			
		}
	
		
				
	}
		
	DetailsForTable +="</table>";
	
	return DetailsForTable;	
}

function AddToTheTab(TabId, HeaderDetails, RowDetails){
		
	document.getElementById(TabId).innerHTML = HeaderDetails + RowDetails;
	
}

function UpdateOrderTransferStatus(){
	
	var _rows = 0;
	var url = '';
	
	switch(intSelectedTab){
		
		case 2:
			_rows = document.getElementById('tbOrderProcessedList').getElementsByTagName("tr");
		break;
		
		case 3:
			_rows = document.getElementById('tbProductProcessedList').getElementsByTagName("tr");
		break
		
	}
	
	//var _rows = document.getElementById('tbOrderProcessedList').getElementsByTagName("tr");
	
	var intRowCnt = _rows.length;
	//alert(intRowCnt);
	for(i=1; i<intRowCnt;i++){
		
		var rowId = _rows[i].id;
		//alert(rowId);
		if(inputList = document.getElementById(rowId).getElementsByTagName("input")){
			
			for(n=0;n<inputList.length;n++){
				if(inputList[n].type=="checkbox"){
					//alert(inputList[0].checked);
					if(inputList[n].checked==true){
						//alert(inputList[n].value);
						
						var StyleCode = parseInt(inputList[n].value);
						
						switch(intSelectedTab){
						
							case 2:
								url = "orders.php?request=ReviseOrder&Stylecode="+StyleCode;
								xmlHttp = $.ajax({url:url,async:false});
							break;
							
							case 3:
								url = "orders.php?request=ReviseProduct&Stylecode="+StyleCode;
								xmlHttp = $.ajax({url:url,async:false});
							break;	
							
						}					
					}
				}
			}
		}		
	}
	
	switch(intSelectedTab){
						
		case 2:
			ListToReviseOrders("revise-order");
		break;
		
		case 3:
			ListToReviseOrders("revise-product");
		break;	
		
	}				
	
	
	
}



