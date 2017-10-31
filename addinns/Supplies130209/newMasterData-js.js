
// JavaScript Document
var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;

function createXMLHttpRequestOrderBook(index) 
{
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
}

function closeWindow(id)
{
	try
	{
		var box = document.getElementById("popupLayer");
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}
function closeWindow2()
{
	try
	{
		var box = document.getElementById("popupLayer10");
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}
function pageSubmitOrderBook()
{
	document.getElementById('frmCalender').submit();	
}
function refreshWindowOrderBook()
{
	createXMLHttpRequestOrderBook(0);
    xmlHttp[0].onreadystatechange = orderBookRequest;
    xmlHttp[0].open("GET", '../orderBook/orderBook.php', true);
    xmlHttp[0].send(null); 
}

function loadOrderBook()
{
	
	createXMLHttpRequestOrderBook(0);
    xmlHttp[0].onreadystatechange = orderBookRequest;
    xmlHttp[0].open("GET", '../orderBook/orderBook.php', true);
    xmlHttp[0].send(null); 
}
function orderBookRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		closeWindow();
		drawPopupAreaLayer(670,300,'frmOrderBook',1);
		
		document.getElementById('frmOrderBook').innerHTML=text;
	}
}
//=======================Hemanthi===============Currency=====================//
function loadNewCurruncy()
{
	createXMLHttpRequestOrderBook(0);
    xmlHttp[0].onreadystatechange = newCurrencyRequest;
    xmlHttp[0].open("GET", 'newCurrencyPopup.php', true);
    xmlHttp[0].send(null); 
	
}
function newCurrencyRequest()
{
    if((xmlHttp[0].readyState == 4) ) 
    {
	var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupBox(600,200,'frmNewCurrency',10);
		
		document.getElementById('frmNewCurrency').innerHTML=text;
	}
}

function saveData()
{
	var txtCurrency = document.getElementById('txtCurrency').value;
	var txtTitle = document.getElementById('txtTitle').value;
	var txtRate = document.getElementById('txtRate').value;
	var txtFraction = document.getElementById('txtFraction').value;
	var txtExRate = document.getElementById('txtExRate').value;
	var chkActive = document.getElementById('chkActive').value;
	var url="newCurrencyDB.php?";	
	//alert(url);
	url=url+"q=save";
	url=url+"&txtCurrency="+txtCurrency;
	url=url+"&txtTitle="+txtTitle;
	url=url+"&txtRate="+txtRate;
	url=url+"&txtFraction="+txtFraction;
	url=url+"&txtExRate="+txtExRate;
	url=url+"&chkActive="+chkActive;
	//alert(url);
	createXMLHttpRequestOrderBook(0);
    xmlHttp[0].onreadystatechange = newSaveCurrencyRequest;
    xmlHttp[0].open("GET",url, true);
    xmlHttp[0].send(null); 
}
function newSaveCurrencyRequest()
{
	if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		alert(text);
		addToMainPopup();
		closeWindow2();
		/*closeWindow();
		loadOrderBook();*/
		
/*		var strStyleId = document.getElementById('txtStyleID').value;
		var strDescription = document.getElementById('txtDsc').value;
		var intQuantity = document.getElementById('txtQty').value;
		var dtmCutCode = document.getElementById('txtCD').value;
		var dtmExFactory = document.getElementById('txtEF').value;
		var strStatus = document.getElementById('txtSt').value;
		var strType = document.getElementById('txtType').value;
		//alert(strStyleId);
		var table = document.getElementById("tblOrderBook");
		
		var rowCount = table.rows.length;		
		var row = table.insertRow(rowCount);
		var cell0 = row.insertCell(1);
		cell0.width='20px';
		cell0.innerHTML="<img src='../../images/edit.png'/>";
		alert(cell0.innerHTML+"sdfs")*/
		
	}
}
function addToMainPopup()
{
	
var selectBox = document.getElementById('cbocurrency');
var newOption = document.createElement("option");
option.text = "Option Text";
option.value = "Option Value";
selectBox.options.add(option);

}


var xmlHttp;


//Insert & Update Data (Save Data)

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 alert(xmlHttp.responseText);
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 setTimeout("location.reload(true);",1000);
 } 
}



function GetXmlHttpObject()
{
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
	
//delete data
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{
		//document.getElementById("txtHint").innerHTML="";
//		document.getElementById("txtCountryCode").value = "";
//		document.getElementById("txtCountry").value = "";
       setTimeout("location.reload(true);",1000);
		
	}
	
		function backtopage()
	{
		window.location.href="main.php";
	}

//load data
function createXMLHttpRequest() 
	{
		if (window.ActiveXObject) 
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if (window.XMLHttpRequest) 
		{
			xmlHttp = new XMLHttpRequest();
		}
	}

function getCountryDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboCountryList').value=='')
	{

			 setTimeout("location.reload(true);",0);
			 //alert("alert");
	}
	
	
		var CountryID = document.getElementById('cboCountryList').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowCountryDetails;
		xmlHttp.open("GET", 'Countrymiddle.php?CountryID=' + CountryID, true);
		xmlHttp.send(null);  
	
	}

function ShowCountryDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CountryCode");
				document.getElementById('txtCountryCode').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CountryName");
				document.getElementById('txtCountry').value = XMLLoad[0].childNodes[0].nodeValue;	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("chkActive").checked=true;	
				}
				else
				{
					document.getElementById("chkActive").checked=false;	
				}
				
			}
		}
	}
	
	
	function checkvalue()
	{
	if(document.getElementById('txtCountryCode').value!="")
	document.getElementById("txtCountry").focus();
	}
	
	
//-------------------------------------	report-----------------------------------------------

