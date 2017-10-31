var xmlHttp;
var xmlHttp1=[];
var pub_intxmlHttp_count=0;

var pub_matNo = 0;
var pub_printWindowNo=0;
function createXMLHttpRequest() 
{
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
}
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function loadSubCategory()
{
	var cboCategory = document.getElementById('cboCategory').value;
		
	    createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = loadSubCategoryRequest;
		var url  = "priceInquiry-xml.php?id=loadSubCategory";
			url += "&cboCategory="+cboCategory;

		xmlHttp1[1].open("GET",url,true);
		xmlHttp1[1].send(null);
}

function loadSubCategoryRequest()
{
 if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
 { 
 //alert(xmlHttp1[1].responseText);
 document.getElementById('cboSubCategory').innerHTML = xmlHttp1[1].responseText;
  clearTable();
 }
}

function clearTable()
{
	var tblTable    = 	document.getElementById("tblMain");

	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}
	
	loadPriceInquiry();	
	
}

function loadPriceInquiry(){
	var cboSupplier = document.getElementById("cboSupplier").value;
	var cboCategory = document.getElementById("cboCategory").value;
	var cboSubCategory = document.getElementById("cboSubCategory").value;
    var cboItem = document.getElementById("cboItem").value;
	var chkDate = document.getElementById("chkDate").checked;
	var DateFrom = document.getElementById("DateFrom").value;
	var DateTo   = document.getElementById("DateTo").value;
    if(document.frmpriceinq.sortDate[0].checked == true){
	var sortDate = document.frmpriceinq.sortDate[0].value;
	}
	
    if(document.frmpriceinq.sortDate[1].checked == true){
	var sortDate = document.frmpriceinq.sortDate[1].value;
	}

    if(document.frmpriceinq.sortDate[2].checked == true){
	var sortDate = document.frmpriceinq.sortDate[2].value;
	}
	
	
	if(document.frmpriceinq.sortPrice[0].checked == true){
	var sortPrice = document.frmpriceinq.sortPrice[0].value;
	}
	
    if(document.frmpriceinq.sortPrice[1].checked == true){
	var sortPrice = document.frmpriceinq.sortPrice[1].value;
	}

    if(document.frmpriceinq.sortPrice[2].checked == true){
	var sortPrice = document.frmpriceinq.sortPrice[2].value;
	}

		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadPriceInquiryRequest;
		var url  = "priceInquiry-xml.php?id=loadPriceInquiry";
			url += "&cboSupplier="+cboSupplier;
			url += "&cboCategory="+cboCategory;
			url += "&cboSubCategory="+cboSubCategory;
			url += "&cboItem="+cboItem;
			url += "&chkDate="+chkDate;
			url += "&DateFrom="+DateFrom;
			url += "&DateTo="+DateTo;
			url += "&sortDate="+sortDate;
			url += "&sortPrice="+sortPrice;

		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
}

function loadPriceInquiryRequest(){ 	
 if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
 {
  			var tblMain = document.getElementById("tblMain");
			var XMLsuppliers     = xmlHttp1[0].responseXML.getElementsByTagName("suppliers");
			var XMLintPONo       = xmlHttp1[0].responseXML.getElementsByTagName("intPONo");
			var XMLdtmDate       = xmlHttp1[0].responseXML.getElementsByTagName("dtmDate");
     		var XMLstrItemDescription = xmlHttp1[0].responseXML.getElementsByTagName("strItemDescription");
			var XMLstrColor      = xmlHttp1[0].responseXML.getElementsByTagName("strColor");
			var XMLstrSize	     = xmlHttp1[0].responseXML.getElementsByTagName("strSize");
			var XMLdblUnitPrice	 = xmlHttp1[0].responseXML.getElementsByTagName("dblUnitPrice");
			var XMLstrCurrency	 = xmlHttp1[0].responseXML.getElementsByTagName("strCurrency");
				
			for(var n = 0; n < XMLintPONo.length ; n++) 
			{
				var rowCount = tblMain.rows.length;
				var row = tblMain.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";

					
				tblMain.rows[rowCount].innerHTML= 
			    "<td class=\"normalfnt\" width=\"15\" height=\"15\">"+XMLsuppliers[n].childNodes[0].nodeValue +"</td>"+
		        "<td class=\"normalfntMid\">"+XMLintPONo[n].childNodes[0].nodeValue+"</td>"+
				"<td class=\"normalfntMid\">"+XMLdtmDate[n].childNodes[0].nodeValue+"</td>"+
		  		"<td class=\"normalfnt\">"+XMLstrItemDescription[n].childNodes[0].nodeValue+"</td>"+
		  		"<td class=\"normalfntMid\">"+XMLstrColor[n].childNodes[0].nodeValue+"</td>"+
                "<td class=\"normalfntMid\">"+XMLstrSize[n].childNodes[0].nodeValue+"</td>"+
				"<td class=\"normalfntRite\">"+XMLdblUnitPrice[n].childNodes[0].nodeValue   +"</td>"+
				"<td class=\"normalfntMid\">"+XMLstrCurrency[n].childNodes[0].nodeValue+"</td>";
			}
 }
}