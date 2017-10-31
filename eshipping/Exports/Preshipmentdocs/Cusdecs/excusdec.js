var xmlHttp =[];

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}


function loadInvoice()
{
	
	
	if(document.getElementById("cboInvoice").value!="")
	{
	pageReload();
	var invoiceno=document.getElementById("cboInvoice").value; 
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'excusdecdb.php?REQUEST=getData&invoiceno=' + invoiceno,true);
	xmlHttp[0].send(null);
	
	/*var invoiceno=document.getElementById("cboInvoice").value; 
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=setCusdecData;
	xmlHttp[2].open("GET",'excusdecdb.php?REQUEST=getusdecData&invoiceno=' + invoiceno,true);
	xmlHttp[2].send(null);*/
	}
	else
	pageReload();
}	
	
function stateChanged()
{
if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)

{
//alert(xmlHttp[0].responseText);

document.getElementById("txtInvoiceDate").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;	
document.getElementById("cboExporter").value=xmlHttp[0].responseXML.getElementsByTagName("CompanyID")[0].childNodes[0].nodeValue;
document.getElementById("cboConsignee").value=xmlHttp[0].responseXML.getElementsByTagName("BuyerID")[0].childNodes[0].nodeValue;
document.getElementById("txtVoyageeNo").value=xmlHttp[0].responseXML.getElementsByTagName("VoyegeNo")[0].childNodes[0].nodeValue;
document.getElementById("txtVoyageeDate").value=xmlHttp[0].responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;
document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;
document.getElementById("cboCityOf").value=xmlHttp[0].responseXML.getElementsByTagName("FinalDest")[0].childNodes[0].nodeValue;
document.getElementById("cboCountry").value=xmlHttp[0].responseXML.getElementsByTagName("strDestCountry")[0].childNodes[0].nodeValue;	
document.getElementById("txtFCl").value=xmlHttp[0].responseXML.getElementsByTagName("strFCL")[0].childNodes[0].nodeValue;	
document.getElementById("txtInsurence").value=xmlHttp[0].responseXML.getElementsByTagName("dblInsurance")[0].childNodes[0].nodeValue;	
document.getElementById("txtMeasure").value=xmlHttp[0].responseXML.getElementsByTagName("strMeasurement")[0].childNodes[0].nodeValue;
document.getElementById("txtFrreight").value=xmlHttp[0].responseXML.getElementsByTagName("dblFreight")[0].childNodes[0].nodeValue;
document.getElementById("txtCage50").value=xmlHttp[0].responseXML.getElementsByTagName("strCage50")[0].childNodes[0].nodeValue;
document.getElementById("txtOther").value=xmlHttp[0].responseXML.getElementsByTagName("dblOthers")[0].childNodes[0].nodeValue;
document.getElementById("txtAuthorizeby").value=xmlHttp[0].responseXML.getElementsByTagName("strAuthorizedBy")[0].childNodes[0].nodeValue;
document.getElementById("txtOfficeEntry").value=xmlHttp[0].responseXML.getElementsByTagName("strOfficeOfEntry")[0].childNodes[0].nodeValue;
//document.getElementById("cboCityOf").value=xmlHttp[2].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;
document.getElementById("cboWharfClerk").value=xmlHttp[0].responseXML.getElementsByTagName("strWharfClerk")[0].childNodes[0].nodeValue;
document.getElementById("cboDelivery").value=xmlHttp[0].responseXML.getElementsByTagName("DeliveryTerms")[0].childNodes[0].nodeValue;
document.getElementById("txtDecleration").value=xmlHttp[0].responseXML.getElementsByTagName("Declarant")[0].childNodes[0].nodeValue;
document.getElementById("txtBL").value=xmlHttp[0].responseXML.getElementsByTagName("BL")[0].childNodes[0].nodeValue;
document.getElementById("cboPayTerms").value=xmlHttp[0].responseXML.getElementsByTagName("Payterm")[0].childNodes[0].nodeValue;


/*
document.getElementById("txtLC").value=xmlHttp[0].responseXML.getElementsByTagName("LCNo")[0].childNodes[0].nodeValue;
document.getElementById("txtLcDate").value=xmlHttp[0].responseXML.getElementsByTagName("dtmLCDate")[0].childNodes[0].nodeValue;
document.getElementById("cboBank").value=xmlHttp[0].responseXML.getElementsByTagName("LCBankID")[0].childNodes[0].nodeValue;
document.getElementById("txtLoading").value=xmlHttp[0].responseXML.getElementsByTagName("PortOfLoading")[0].childNodes[0].nodeValue;


document.getElementById("cboCurrency").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtUnitPrice").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtNoCartoons").value=xmlHttp[0].responseXML.getElementsByTagName("NoOfCartons")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtDiscription").value=xmlHttp[0].responseXML.getElementsByTagName("GenDesc")[0].childNodes[0].nodeValue;

document.getElementById("txtMarksofPKGS").value=xmlHttp[0].responseXML.getElementsByTagName("MarksAndNos")[0].childNodes[0].nodeValue;
document.getElementById("cboInvoiceType").value=1;
document.getElementById("cboInvoiceType").disabled=true;
document.getElementById("cboTransMode").value=1;
document.getElementById("cboTransMode").disabled=true;
document.getElementById("cboUnit").value=1;
document.getElementById("cboUnit").disabled=true;
document.getElementById("txtInvoiceDetail").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
*/
}

}



/*function setCusdecData()
{
if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)	
{//alert (xmlHttp[2].responseText);	
if(xmlHttp[2].responseXML.getElementsByTagName("InvoiceData").childNodes[0].nodeValue)
{
document.getElementById("cboCountry").value=xmlHttp[2].responseXML.getElementsByTagName("strDestCountry")[0].childNodes[0].nodeValue;	
document.getElementById("txtFCl").value=xmlHttp[2].responseXML.getElementsByTagName("strFCL")[0].childNodes[0].nodeValue;	
document.getElementById("txtInsurence").value=xmlHttp[2].responseXML.getElementsByTagName("dblInsurance")[0].childNodes[0].nodeValue;	
document.getElementById("txtMeasure").value=xmlHttp[2].responseXML.getElementsByTagName("strMeasurement")[0].childNodes[0].nodeValue;
document.getElementById("txtFrreight").value=xmlHttp[2].responseXML.getElementsByTagName("dblFreight")[0].childNodes[0].nodeValue;
document.getElementById("txtCage50").value=xmlHttp[2].responseXML.getElementsByTagName("strCage50")[0].childNodes[0].nodeValue;
document.getElementById("txtOther").value=xmlHttp[2].responseXML.getElementsByTagName("dblOthers")[0].childNodes[0].nodeValue;
document.getElementById("txtAuthorizeby").value=xmlHttp[2].responseXML.getElementsByTagName("strAuthorizedBy")[0].childNodes[0].nodeValue;
document.getElementById("txtOfficeEntry").value=xmlHttp[2].responseXML.getElementsByTagName("strOfficeOfEntry")[0].childNodes[0].nodeValue;
//document.getElementById("cboCityOf").value=xmlHttp[2].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;
document.getElementById("cboWharfClerk").value=xmlHttp[2].responseXML.getElementsByTagName("strWharfClerk")[0].childNodes[0].nodeValue;
document.getElementById("cboDelivery").value=xmlHttp[2].responseXML.getElementsByTagName("DeliveryTerms")[0].childNodes[0].nodeValue;
document.getElementById("txtDecleration").value=xmlHttp[2].responseXML.getElementsByTagName("Declarant")[0].childNodes[0].nodeValue;

}
}
}*/

function pageReload()
{
	
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();
//document.getElementById("cboInvoice").value=""
document.getElementById("txtInvoiceDate").value=month + "/" + day + "/" + year;
document.getElementById("cboExporter").value="";
document.getElementById("cboConsignee").value="";
document.getElementById("txtVoyageeNo").value="";
document.getElementById("txtVoyageeDate").value="";
document.getElementById("txtVessel").value="";
document.getElementById("cboCityOf").value="";
document.getElementById("cboCountry").value=""
document.getElementById("txtFCl").value="";
document.getElementById("txtInsurence").value="";
document.getElementById("txtMeasure").value="";
document.getElementById("txtFrreight").value="";
document.getElementById("txtCage50").value="";
document.getElementById("txtOther").value="";
document.getElementById("txtAuthorizeby").value="";
document.getElementById("txtOfficeEntry").value="";
//document.getElementById("cboCityOf").value="";
document.getElementById("cboWharfClerk").value="";
document.getElementById("cboDelivery").value="";
document.getElementById("txtDecleration").value=""
document.getElementById("txtBL").value="";
document.getElementById("cboPayTerms").value="";
//setTimeout(location.reload(true),100);

}
	
function saveCusdec()
{
var countruy=document.getElementById("cboCountry").value;
var fcl=document.getElementById("txtFCl").value;
var Insurence=document.getElementById("txtInsurence").value;
var Measure=document.getElementById("txtMeasure").value;
var Frreight=document.getElementById("txtFrreight").value;
var Cage50=document.getElementById("txtCage50").value;
Cage50=URLEncode(Cage50);
var Other=document.getElementById("txtOther").value;
var Authorizeby=document.getElementById("txtAuthorizeby").value;
var invoiceno=document.getElementById("cboInvoice").value;
var officeEntry=document.getElementById("txtOfficeEntry").value;
var City=document.getElementById("cboCityOf").value;
var wharfclerk=document.getElementById("cboWharfClerk").value;
var Delivery=document.getElementById("cboDelivery").value;
var Decleration=document.getElementById("txtDecleration").value;
var BL=document.getElementById("txtBL").value;
var payterm=document.getElementById("cboPayTerms").value;

if(payterm!=""){
if(invoiceno!="")
{
createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function(){if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)alert(xmlHttp[1].responseText);}
	xmlHttp[1].open("GET",'excusdecdb.php?REQUEST=editData&invoiceno=' + invoiceno + '&fcl=' +fcl+   '&Insurence=' +Insurence+   '&Measure=' +Measure+  '&Frreight=' +Frreight+  '&Cage50=' +Cage50+     '&Authorizeby=' +Authorizeby +  '&Other=' +Other +  '&Other=' +Other+  '&officeEntry=' +officeEntry+  '&countruy=' +countruy+  '&wharfclerk=' +wharfclerk+  '&Delivery=' +Delivery+'&Decleration='+Decleration+'&BL='+BL+'&payterm='+payterm,true);
	xmlHttp[1].send(null);
}
}else 
alert("Please select payment terms.");
}

function PrintCusdec()
{
		var cusdectype="";
	if (document.getElementById("boi").checked==true||document.getElementById("infact").checked==true||document.getElementById("all").checked==true)
	{
	cusdectype=0;
	}
	else if(document.getElementById("general").checked==true)
	{
	cusdectype=1;	
	}
	
	if(document.getElementById("cboInvoice").value!=""){
	var No =document.getElementById("cboInvoice").value;
	/*if(No=="" || No=="0"){
		alert("No delivery no appear to view..");
		return false;
	}
	*/
	/*var newwindow=window.open('excusdecReport.php?invoiceNo='+No+'&cusdectype='+cusdectype ,'name');*/
	window.open('cusdec_plug_in.php?InvoiceNo='+No ,'name1');
	/*var back_side=window.open('cusdec_back_side.php','back');
	if (window.focus || back_side.focus) {newwindow.focus();}*/
	}
}
 function setCage50()
 {
	//alert("pass")	 
	var cage50=document.getElementById("txtMeasure").value+"\n"+document.getElementById("txtCage50").value;
	document.getElementById("txtCage50").value=cage50;  
 }