var xmlHttp;
var noOfStyleRecords
var noOfRowsFrom
var noOfRowsTo


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
 
function createXMLHttpStyleRequest() 
 {
	if (window.ActiveXObject) 
	{
		xmlHttpStyle = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpStyle = new XMLHttpRequest();
	}
 }

function createXMLHttpStyleCountRequest() 
{
	if (window.ActiveXObject) 
	{
		xmlHttpStyleCount = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpStyleCount = new XMLHttpRequest();
	}
}

function createXMLHttpCatsRequest() 
 {
	if (window.ActiveXObject) 
	{
		xmlHttpCats = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpCats = new XMLHttpRequest();
	}
 }

//=============================================== ANANDA 2009/07/22
function getStyleDeialsCount()
{
	var companyID=document.getElementById("cboCompanyID").value;
	var cusID=document.getElementById("cboCustomer").value;
	var styleLike=document.getElementById("txtstyleid").value;

	createXMLHttpStyleCountRequest() 
	xmlHttpStyleCount.onreadystatechange = HandleStylesCount;
	xmlHttpStyleCount.open("GET", 'NewOrderStatusDB.php?DBOprType=getStyleDeialsCount&companyID=' + companyID + '&cusID=' + cusID + '&styleLike=' + styleLike , true);
	xmlHttpStyleCount.send(null);
}
function HandleStylesCount()
{
	if(xmlHttpStyleCount.readyState == 4) 
    {
		if(xmlHttpStyleCount.status == 200) 
        { 	
			var XMLStyleID = xmlHttpStyleCount.responseXML.getElementsByTagName("strStyleID");
			var XMLColor = xmlHttpStyleCount.responseXML.getElementsByTagName("strColor");
			
			if(XMLStyleID.length>0)
			{
				noOfStyleRecords=XMLStyleID.length
				var row=document.getElementById("tblCaption").getElementsByTagName("TR")
				var cell=row[0].getElementsByTagName("TD")
				cell[1].innerHTML=XMLStyleID.length;
				cell[3].innerHTML=1;
				cell[5].innerHTML=15;
				
			}
			else
			{
				alert("There is no style to list");
				return;
			}
		}
	}
}

function tableclear()
{
	var stylesList="<table width=\"5300\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblStyles\">"+
					"<tr class=\"normaltxtmidb2\">"+
					"<td style=\"width:20px\" width=\"10\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
					"<td style=\"width:200px\" width=\"200px\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Customer</td>"+
					"<td style=\"width:150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style ID</td>"+
					"<td style=\"width:200px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PO</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">FOB</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SMV</td>"+
					"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Est. YY</td>"+
					"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act YY</td>"+
					"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">CM</td>"+
					"<td width=\"80px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Order Date</td>"+
					"<td width=\"200px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GMT ETD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rev. ETD</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Cut Date</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Cut Date</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Input Date</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Input Date</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Finish Date</td>"+
					"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Shipment Date</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipment QTY</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Finish Date</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Shipment Date</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipment Date</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">+/-</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Feb PO</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SMPL YDG RCVD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Lab Dip Aprvd</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fab Test Sent</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Feb tet Passd</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bulk Approved</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fab. Inspect</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PITN ORG SMP TGT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PTTD RCVD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">ORG SMPL RCVD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - QTY</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - SIZE</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - TGT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - SENT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - APVD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - SIZE</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - TGT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - SENT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - APVD</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - QTY</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - SIZE</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - TGT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - SENT</td>"+
					"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - APVD</td>"+
					"</tr></table>";
					document.getElementById("divStyles").innerHTML=stylesList
							
}

function getStyleDeials(possition)
{
	tableclear()
	var companyID=document.getElementById("cboCompanyID").value;
	var cusID=document.getElementById("cboCustomer").value;
	var styleLike=document.getElementById("txtstyleid").value;
	

	
	if(possition==1)
	{
		noOfRowsFrom=0
	 	noOfRowsTo=15
	}
	else if(possition==2)
	{
		noOfRowsFrom=noOfRowsFrom-15
	 	noOfRowsTo=15
		
	}
	else if(possition==3)
	{
		noOfRowsFrom=noOfRowsFrom+15
	 	noOfRowsTo=15
	}
	else if(possition==4)
	{
		var temp=noOfStyleRecords/15
		
		var tempRecSets=(temp-parseInt(temp))

			noOfRowsFrom=parseInt(temp)*15
	 		noOfRowsTo	=Number(tempRecSets*15).toFixed(0);
		
	}

	var row=document.getElementById("tblCaption").getElementsByTagName("TR")
	var cell=row[0].getElementsByTagName("TD")
	cell[3].innerHTML=noOfRowsFrom;
	cell[5].innerHTML=parseFloat(noOfRowsFrom)+parseFloat(noOfRowsTo);


	createXMLHttpStyleRequest() 
	xmlHttpStyle.onreadystatechange = HandleStyles;
	xmlHttpStyle.open("GET", 'NewOrderStatusDB.php?DBOprType=getStyleDeials&companyID=' + companyID + '&cusID=' + cusID + '&styleLike=' + styleLike + '&noOfRowsFrom=' + noOfRowsFrom + '&noOfRowsTo=' + noOfRowsTo, true);
	xmlHttpStyle.send(null);
	
	
}

function HandleStyles()
{
	if(xmlHttpStyle.readyState == 4) 
    {
		if(xmlHttpStyle.status == 200) 
        { 	
			var XMLName = xmlHttpStyle.responseXML.getElementsByTagName("strName");
			var XMLStyleID = xmlHttpStyle.responseXML.getElementsByTagName("strStyleID");
			var XMLDescription = xmlHttpStyle.responseXML.getElementsByTagName("strDescription");
			var XMLBuyerPONO = xmlHttpStyle.responseXML.getElementsByTagName("strBuyerPONO");
			var XMLFOB = xmlHttpStyle.responseXML.getElementsByTagName("reaFOB");
			var XMLNewSMV = xmlHttpStyle.responseXML.getElementsByTagName("reaNewSMV");
			var XMLestyy = xmlHttpStyle.responseXML.getElementsByTagName("estyy");
			var XMLactyy = xmlHttpStyle.responseXML.getElementsByTagName("actyy");
			var XMLNewCM = xmlHttpStyle.responseXML.getElementsByTagName("reaNewCM");
			var XMLdtmDate = xmlHttpStyle.responseXML.getElementsByTagName("dtmDate");
			var XMLColor = xmlHttpStyle.responseXML.getElementsByTagName("strColor");
			var XMLQty = xmlHttpStyle.responseXML.getElementsByTagName("dblQty");
			var XMLGMTETD = xmlHttpStyle.responseXML.getElementsByTagName("GMTETD");
			var XMLRevETD = xmlHttpStyle.responseXML.getElementsByTagName("RevETD");
			
			if(XMLStyleID.length==0)
			{
				alert("There is no any Style to Display")
				return;
			}
			
			
			var stylesList="<table width=\"5300\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblStyles\">"+
							"<tr class=\"normaltxtmidb2\">"+
							"<td style=\"width:20px\" width=\"10\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							"<td style=\"width:200px\" width=\"200px\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Customer</td>"+
							"<td style=\"width:150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style ID</td>"+
							"<td style=\"width:200px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PO</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">FOB</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SMV</td>"+
							"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Est. YY</td>"+
							"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act YY</td>"+
							"<td width=\"70px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">CM</td>"+
							"<td width=\"80px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Order Date</td>"+
							"<td width=\"200px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GMT ETD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rev. ETD</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Cut Date</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Cut Date</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Input Date</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Input Date</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Finish Date</td>"+
							"<td width=\"150px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Shipment Date</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipment QTY</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PLND Finish Date</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act Shipment Date</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipment Date</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">+/-</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Feb PO</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SMPL YDG RCVD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Lab Dip Aprvd</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fab Test Sent</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Feb tet Passd</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bulk Approved</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fab. Inspect</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PITN ORG SMP TGT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PTTD RCVD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">ORG SMPL RCVD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - QTY</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - SIZE</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - TGT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - SENT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SIZE - APVD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - SIZE</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - TGT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - SENT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gold Seal - APVD</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - QTY</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - SIZE</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - TGT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - SENT</td>"+
							"<td width=\"100px\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">TESTING - APVD</td>"+
							"</tr>";
			
			for(var loop=0;loop<XMLStyleID.length;loop++)
			{
				var name = XMLName[loop].childNodes[0].nodeValue;
				var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
				var Description = XMLDescription[loop].childNodes[0].nodeValue;
				var BuyerPoNo = XMLBuyerPONO[loop].childNodes[0].nodeValue;
				var FOB = XMLFOB[loop].childNodes[0].nodeValue;
				var NewSMV = XMLNewSMV[loop].childNodes[0].nodeValue;
				var estyy = XMLestyy[loop].childNodes[0].nodeValue;
				var actyy = XMLactyy[loop].childNodes[0].nodeValue;
				var NewCM = XMLNewCM[loop].childNodes[0].nodeValue;
				var Datex = XMLdtmDate[loop].childNodes[0].nodeValue;
				var Colour = XMLColor[loop].childNodes[0].nodeValue;
				var Qty = XMLQty[loop].childNodes[0].nodeValue;
				var GMTETD = XMLGMTETD[loop].childNodes[0].nodeValue;
				var RevETD = XMLRevETD[loop].childNodes[0].nodeValue;
				
				//bgcolor=\"#CCCCCC\"
				stylesList+="<tr>"+
"<td  class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\"><img src=\"images/butt_1.png\" onclick=\"getCategories(this)\" width=\"15\" height=\"15\" /></td>"+
"<td  class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + name + "</td>"+
"<td  class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + styleID + "</td>"+
"<td  class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + Description + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + BuyerPoNo + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + FOB + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + NewSMV + "</td>"+    
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><img src=\"images/add.png\" width=\"16\" height=\"16\" onClick=\"getEstyy(this)\" /></td>"+    
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + actyy + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + NewCM + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + Datex + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + Colour + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><img src=\"images/add.png\" width=\"16\" height=\"16\" onClick=\"getSizeRatios(this)\" /></td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + Qty + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + GMTETD + "</td>"+
"<td  class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + RevETD + "</td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpPLNDCutDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpPLNDCutDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpActCutDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpActCutDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpPLNDInputDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpPLNDInputDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpActInputDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpActInputDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpPLNDFinishDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpPLNDFinishDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" width=\"150px\" onmouseover=\"highlight(this.parentNode)\"><input name=\"dtpActShipmentDate" + loop + "\" type=\"text\" class=\"txtbox\" id=\"dtpActShipmentDate" + loop + "\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y/%m/%d');\"/><input name=\"reset\" type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%Y/%m/%d');\" value=\"\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData2\" type=\"text\" id=\"txtData2\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#CCCCCC\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#99FF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"<td bgcolor=\"#FFFF99\" class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\"><input name=\"txtData\" type=\"text\" id=\"txtData\" class=\"txtbox\" size=\"15\" /></td>"+
"</tr>";
				
					
			}
			
			stylesList+="</table>"
			
			document.getElementById("divStyles").innerHTML=stylesList
			
		}
	}
}


function getCategories(objbtn)
{
	var row 		= objbtn.parentNode.parentNode;
	var strStyle 	= row.cells[2].lastChild.nodeValue;
	var strColour	= row.cells[11].lastChild.nodeValue;
	
	createXMLHttpCatsRequest() 
	xmlHttpCats.onreadystatechange = HandleCategories;
	xmlHttpCats.open("GET", 'NewOrderStatusDB.php?DBOprType=getCategories&strStyle=' + strStyle + '&strColour=' + strColour, true);
	xmlHttpCats.send(null);
}

function HandleCategories()
{
	if(xmlHttpCats.readyState == 4) 
    {
		if(xmlHttpCats.status == 200) 
        { 	
			var XMLintSubCatNo	= xmlHttpCats.responseXML.getElementsByTagName("intSubCatNo");
			var XMLStrCatName 	= xmlHttpCats.responseXML.getElementsByTagName("StrCatName");
			var XMLstrColor 	= xmlHttpCats.responseXML.getElementsByTagName("strColor");
			var XMLdblQty 		= xmlHttpCats.responseXML.getElementsByTagName("dblQty");
			
			drawPopupArea(290,200,'frmCategories');
			var strCatTable="<table width=\"420\" height=\"190\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
"<tr>"+
"<td height=\"94\" colspan=\"7\" class=\"normalfnt\">"+
"<div id=\"divCategories\" style=\"overflow:scroll; height:300px; width:420px;\" class=\"bcgl1\";>"+
"<table width=\"410\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\" name=id=\"tblGLAccs\">"+
"<tr>"+
"<td width=\"80\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Cat ID</td>"+
"<td width=\"300\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Category</td>"+
"<td width=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Quantity</td>"+
"</tr>"
			
				waitihg();
			
			for(var loop=0;loop<XMLintSubCatNo.length;loop++)
			{
				
				var SubCatNo	= XMLintSubCatNo[loop].childNodes[0].nodeValue
				var CatName		= XMLStrCatName[loop].childNodes[0].nodeValue
				var Color		= XMLstrColor[loop].childNodes[0].nodeValue
				var dblQtys		= XMLdblQty[loop].childNodes[0].nodeValue
				
				
			
				strCatTable+="<tr>"+
							"<td class=\"normalfnt\">" + SubCatNo + "</td>"+
							"<td class=\"normalfnt\">" + CatName  + "</td>"+
							"<td class=\"normalfnt\">" + dblQtys + "</td>"+
							"</tr>";
				
			}
				
				
				
				
				strCatTable+="</table>"+
								"</div></td>"+
								"</tr>"+
								"<tr>"+
								"<td width=\"137\" height=\"21\" bgcolor=\"#D5EAFF\">&nbsp;</td>"+
								"<td width=\"281\" bgcolor=\"#D5EAFF\">&nbsp;</td>"+
								"<td colspan=\"3\" bgcolor=\"#D5EAFF\" class=\"normalfnt\">&nbsp;</td>"+
								"<td width=\"108\" colspan=\"2\" bgcolor=\"#D5EAFF\"><img src=\"images/close.png\" class=\"mouseover\" alt=\"close\" onclick=\"closeWindow();\" /></td>"+
								"</tr>"+
								"</table>"
						
				
						
				var popupbox = document.createElement("divCategories");
				document.getElementById('frmCategories').innerHTML=strCatTable;
				popupbox.id = "popupbox";
				popupbox.style.position = 'absolute';
				popupbox.style.zIndex = 10;
				popupbox.style.left = 290 + 'px';
				popupbox.style.top = 145+ 'px';
				document.getElementById('frmCategories').innerHTML=strCatTable; 
				//popupbox.innerHTML = htmlText;     
				//alert(HTMLText)
				document.body.appendChild(popupbox);
			
		}
	}
}


function waitihg()
{
	drawPopupArea(290,200,'frmWaiting');
	var strWaitIF="<div id=\"divWaiting\" class=\"txtbox\" style=\"width:100px;height:100px\">"+
					"<img src=\"loading1.gif\" width=\"218\" height=\"209\" /></div>"
					
	var popupbox = document.createElement("divWaiting");
	document.getElementById('frmWaiting').innerHTML=strWaitIF;
	popupbox.id = "popupbox";
	popupbox.style.position = 'absolute';
	popupbox.style.zIndex = 10;
	popupbox.style.left = 290 + 'px';
	popupbox.style.top = 145+ 'px';
	document.getElementById('frmWaiting').innerHTML=strWaitIF; 
	document.body.appendChild(popupbox);
}

function highlight(o)
{
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

//============================================================================================================================

function getSizeRatios(objbtn)//styleId,EventScheduleMethod
{
	var row = objbtn.parentNode.parentNode;
	//alert(row)
	var rowval = row.cells[1].lastChild.nodeValue;
	//alert(rowval)
	var color = row.cells[10].lastChild.nodeValue;
	//alert(color)
	
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleSizeRatios;
	xmlHttp.open("GET", 'NewOrderStatusDB.php?DBOprType=SIZERATIOS&StyleID=' + rowval + '&Color=' + color, true);
	xmlHttp.send(null);
	
}


function HandleSizeRatios()
{
	if(xmlHttp.readyState == 4) 
    {
		if(xmlHttp.status == 200) 
        { 	
			var XMLSize = xmlHttp.responseXML.getElementsByTagName("strSize");
			var XMLQty = xmlHttp.responseXML.getElementsByTagName("dblQty");
			if(XMLSize.length>0)
			{
				
				drawPopupArea(290,200,'frmSizeRatio');
				var strSizeTable="<div id=\"divSize\"  style=\"overflow:scroll; height:200px; width:300px;\">"+  
								"<table width=\"299\" cellpadding=\"0\" cellspacing=\"0\">"+
								"<tr><td><table><tr><td  bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><img src=\"images/cross.png\" class=\"mouseover\" alt=\"close\" onclick=\"closeWindow();\" /></td>"+
								"</tr></table></td></tr>"+
								"<tr><td width=\"150\" height=\"16\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>"+      
								"<td width=\"100\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Quantity</td>"+      
								"</tr>"
				for(var loop=0;loop<XMLSize.length;loop++)
				{
					var size = XMLSize[loop].childNodes[0].nodeValue;
					var qty = XMLQty[loop].childNodes[0].nodeValue;
					//alert( size)		
					strSizeTable+=	"<tr><td class=\"normalfntTAB\">" + size + "</td>"+
									"<td class=\"normalfntTAB\">" + qty + "</td></tr>"

					
				}
				strSizeTable+="</table>"
							"</div>"
							
							
				var popupbox = document.createElement("divSize");
				document.getElementById('frmSizeRatio').innerHTML=strSizeTable;
				popupbox.id = "popupbox";
				popupbox.style.position = 'absolute';
				popupbox.style.zIndex = 10;
				popupbox.style.left = 500 + 'px';
				popupbox.style.top = 165+ 'px';
				document.getElementById('frmSizeRatio').innerHTML=strSizeTable; 
				//popupbox.innerHTML = htmlText;     
				//alert(HTMLText)
				document.body.appendChild(popupbox);
			}
			
		}
	}
}

function getEstyy(objbtn)//styleId,EventScheduleMethod
{
	var row = objbtn.parentNode.parentNode;
	
	var rowval = row.cells[1].lastChild.nodeValue;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleGetEstyy;
	xmlHttp.open("GET", 'NewOrderStatusDB.php?DBOprType=ESTYY&StyleID=' + rowval , true);
	xmlHttp.send(null);
	
}

function HandleGetEstyy()
{
	if(xmlHttp.readyState == 4) 
    {
		if(xmlHttp.status == 200) 
        { 	
			var XMLEstyy = xmlHttp.responseXML.getElementsByTagName("Estyy");
			//alert (XMLEstyy);
			var Estyy = XMLEstyy[0].childNodes[0].nodeValue;
			var XMLMaterial = xmlHttp.responseXML.getElementsByTagName("Material");
			var Material = XMLMaterial[0].childNodes[0].nodeValue;
			ShowWindow(XMLEstyy,XMLMaterial);
			/*for ( var loop = 0; loop < XMLEstyy.length; loop++)
			 {
				
							
				//alert(Estyy);
			 }
			 */

			//EventScheduleProcess(EventScheduleMethod,BaseDeliveryDate);
		}
	}	
}

function ShowWindow($Estyy,$Material)
{
	drawPopupArea(860,150,'frmAccyy');
	var HTMLText = "<div id=\"divcons\" style=\"overflow:scroll; height:150px; width:860px;\">"+
"  <table width=\"840\" cellpadding=\"0\" cellspacing=\"0\">"+
"<tr>"+
"<td><table>"+
"<tr>"+
"<td  bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><img src=\"images/cross.png\" class=\"mouseover\" alt=\"close\" onclick=\"closeWindow();\" /></td>      "+
"</tr>"+
"</table></td>"+
"</tr>"+
"    <tr>"+
"      <td width=\"185\" height=\"16\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material</td>"+
"      <td width=\"90\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Est YY</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Act YY</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Reg Qty</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Qty</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rec Qty</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Variation</td>"+
"      <td width=\"90\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">EX %</td>"+
"    </tr>";
//start

										
			for (var i = 0 ; i < $Estyy.length ; i++)
			{
				 HTMLText += "<tr>"+
"<td class=\"normalfntTAB\">"+ $Material[i].childNodes[0].nodeValue +"</td>"+
"<td class=\"normalfntTAB\">"+ $Estyy[i].childNodes[0].nodeValue +"</td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\">"+
"<input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" />"+
"</div></td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\"><input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" /></div></td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\"><input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" /></div></td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\"><input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" /></div></td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\"><input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" /></div></td>"+
"<td colspan=\"2\" class=\"normalfntTAB\"><div align=\"center\"><input name=\"txtactyy2\" type=\"text\" class=\"txtbox\" id=\"txtactyy2\" size=\"8\" /></div></td>"+
"</tr>";
			}

//end
 HTMLText += "  </table>"+
  
"</div>";

	
	 var popupbox = document.createElement("div");
	 document.getElementById('frmAccyy').innerHTML=HTMLText;
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 165+ 'px';
     document.getElementById('frmAccyy').innerHTML=HTMLText; 
	 //popupbox.innerHTML = htmlText;     
	 //alert(HTMLText)
    document.body.appendChild(popupbox);
	
	
	
	
}

function drawPopupArea(width,height,popupname)
{
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 2;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;\">"+
					"<table width=\"" +width + "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td width=\"" + width + "\" height=\"" +  height + "\" align=\"center\" valign=\"middle\">Loading.....</td>"+
						"</tr>"+
					"</table>"+
					"</div><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\""+ (((screen.height - height)/4)+100) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					"</table>"+				
					"</div>";
    popupbox.innerHTML = htmltext;     
    document.body.appendChild(popupbox);
}


function closeWindow()
{  

	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box); 
		
	}
	catch(err)
	{        
	}	
}







//Calander Functions
function toggleCalendar()
{	
	var txtObj=document.getElementById("txtDate")
	cObj = txtObj.myCalendar;

	if (!cObj) {
		cObj = new CalendarDisplay(txtObj);
		document.body.appendChild(cObj.cDiv);
		txtObj.myCalendar = cObj;
	}
	
	cObj.toggle();
}

CalendarDisplay = function(txtObj) {
	this.txtObj = txtObj;
	this.tBox = this.txtObj;
	this.cDiv = document.createElement('div');
	this.cDiv.style.position = 'absolute';
	this.cDiv.style.display = 'none';
}

CalendarDisplay.prototype.MONTHS_CALENDAR = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
CalendarDisplay.prototype.DAYS_1_CALENDAR = new Array("S", "M", "T", "W", "T", "F", "S");
CalendarDisplay.prototype.DAYS_2_CALENDAR = new Array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa");

CalendarDisplay.prototype.toggle = function() {
	if (this.cDiv.style.display == 'none') {
		this.adjustPosition();
		this.fillCalendar(this.grabDate());
		this.cDiv.style.display = 'block';
	} else {
		this.cDiv.style.display = 'none';
	}
}

CalendarDisplay.prototype.grabDate = function() {
	var tempDate = new Date(this.tBox.value);
	if (!tempDate.getYear()) {
		tempDate = new Date();
	}
	return tempDate;
}

CalendarDisplay.prototype.fillCalendar = function(theDate) {
	if (this.cDiv.firstChild) {
		this.cDiv.removeChild(this.cDiv.firstChild);
	}
	this.adjustPosition();
	this.cDiv.appendChild(this.getCalendar(theDate));
}

CalendarDisplay.prototype.adjustPosition = function() {
	this.cDiv.style.top = this.tBox.offsetHeight + this.findPosY(this.tBox) + 'px';

	this.cDiv.style.left = this.findPosX(this.tBox) + 'px';
}

CalendarDisplay.prototype.getCalendar = function(theDate) {
	var theYear = theDate.getFullYear();
	var theMonth = theDate.getMonth();
	var theDay = theDate.getDate();

	var theTable = document.createElement('table');
	theTable.id = 'calendartable';
	var theTHead = theTable.createTHead();
	var theTBody = document.createElement('tbody');
	theTable.appendChild(theTBody);
	
	var monthRow = theTHead.insertRow(0);
	var navLeftCell = monthRow.insertCell(0);
	var monthCell = monthRow.insertCell(1);
	var navRightCell = monthRow.insertCell(2);
	monthCell.colSpan = 5;
	monthCell.appendChild(document.createTextNode(this.MONTHS_CALENDAR[theMonth] + ', ' + theYear));
	var leftLink = document.createElement('a');
	leftLink.href = '#';
	this.setCalendarPrevious(leftLink, this.txtObj, theYear, theMonth, theDay);
	leftLink.appendChild(document.createTextNode('-'));
	navLeftCell.appendChild(leftLink);
	var rightLink = document.createElement('a');
	rightLink.href = '#';
	this.setCalendarNext(rightLink, this.txtObj, theYear, theMonth, theDay);
	rightLink.appendChild(document.createTextNode('+'));
	navRightCell.appendChild(rightLink);
	
	var weeksRow = theTHead.insertRow(1);
	for (var i=0; i<7; i++) {
		var tempWeeksCell = weeksRow.insertCell(i);
		tempWeeksCell.appendChild(document.createTextNode(this.DAYS_2_CALENDAR[i]));
	}
	
	var temporaryDate1 = new Date(theYear, theMonth, 1);
	var startDayOfWeek = temporaryDate1.getDay();
	var temporaryDate2 = new Date(theYear, theMonth + 1, 0);
	var lastDateOfMonth = temporaryDate2.getDate();
	var dayCount = 1;
		
	for (var r=0; r<6; r++) {
		var tempDaysRow = theTable.tBodies[0].insertRow(r);
		tempDaysRow.className = 'dayrow';
		for (var c=0; c<7; c++) {
			var tempDaysCell = tempDaysRow.insertCell(c);
			var mysteryNode;
			if ((r > 0 || c >= startDayOfWeek) && dayCount <= lastDateOfMonth) {
				tempDaysCell.className = 'yestext';
				var mysteryNode = document.createElement('a');
				mysteryNode.href = '#';
				this.setCalendarClick(mysteryNode, this.txtObj, theYear, theMonth, dayCount);
				mysteryNode.appendChild(document.createTextNode(dayCount));
				dayCount++;
			} else {
				tempDaysCell.className = 'notext';
				mysteryNode = document.createTextNode('');
			}
			tempDaysCell.appendChild(mysteryNode);
		}
	}
	
	return theTable;
}
CalendarDisplay.prototype.setCalendarClick = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {fillInFields(theObj, theYear, (theMonth + 1), theDay); return false;}
}
CalendarDisplay.prototype.setCalendarPrevious = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showPrevious(theObj, theYear, theMonth, theDay); return false;}
}
CalendarDisplay.prototype.setCalendarNext = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showNext(theObj, theYear, theMonth, theDay); return false;}
}
	


CalendarDisplay.prototype.findPosX = function(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) {
		curleft += obj.x;
	}
	return curleft;
}


CalendarDisplay.prototype.findPosY = function(obj) {
	var curtop = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent) {
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.y) {
		curtop += obj.y;
	}
	return curtop;
}

function fillInFields(obj, year, month, day)
{
	obj.value = (month < 10 ? '0'+month : month) + '/' + (day < 10 ? '0'+day : day) + '/' + year;
	cObj = obj.myCalendar;
	cObj.toggle();
}

function showPrevious(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var lastMonth = new Date(year, month - 1, day)
	cObj.fillCalendar(lastMonth);
}
function showNext(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var nextMonth = new Date(year, month + 1, day)
	cObj.fillCalendar(nextMonth);
}












// CALANDER ===============================================================

var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) 
{
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) 
  {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } 
  else 
  {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") 
	{
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) 
	{
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  // this call must be the last as it might use data initialized above; if
  // we specify a parent, as opposite to the "showCalendar" function above,
  // then we create a flat calendar -- not popup.  Hidden, though, but...
  cal.create(parent);

  // ... we can show it here.
  cal.show();
}



