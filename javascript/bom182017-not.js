// JavaScript Document


var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var fifthxmlHttp;
var currentUnit = "";
var xmlHttpreq = [];
var shippos = 0;
var currentItemCode = null;
var requestCount = 0;
var matincr = 0 ;
var editWaste = 0;
var editYY    = 0;
var deliveryIndex = 0;
var leadposition = 0 ;
var curObj ;
var loadPercentage;
var loadItem;
var matincr;
var previousUnit = "";
var delbpoedition = false;
//Start 31-03-2010 bookmark (all arrays are define)
var Materials = [];
var arrayRatioQty = [];
var arrayYY = [];
var arrayWastege =[];
var arrayMoq =[];
var MatColor = [];
var arrayColorIsPo = [];
var arraySizeIsPo = [];
var MatSize	 = [];
var alloType = '';
//End 31-03-2010 bookmark (all arrays are define)
var pub_ResponceCount = 0;
var checkLoop 			= 0;

var isPriceChanged = false;



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

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
    }
}

function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}

function createThirdXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        thirdxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        thirdxmlHttp = new XMLHttpRequest();
    }
}

function createtFourthXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        fourthxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        fourthxmlHttp = new XMLHttpRequest();
    }
}

function createtFifthXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        fifthxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        fifthxmlHttp = new XMLHttpRequest();
    }
}

function uploadBuyerPO(StyleNo,Qty)
{
	var url = 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Qty=' +Qty;
	//alert(url);
	var	popwindow= window.open ("BuyerPO/uploader_buyerPO.php?No=" + StyleNo + "&Qty=" + Qty , "Buyer PO Uploader","location=1,status=1,scrollbars=1,width=450,height=200");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
}

function GetCompanyPOList()
{    
	var CompanyID = document.getElementById('cboFactory').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePOList;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerPOListForCompanyBOM&CompanyID=' + CompanyID, true);
    xmlHttp.send(null);     
}

function HandlePOList()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleNo");
			// var XMLSRNO = xmlHttp.responseXML.getElementsByTagName("SRNO");
			 var XMLQTY = xmlHttp.responseXML.getElementsByTagName("QTY");
			 
			 RemoveAllRows();
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
				//var SRNO = XMLSRNO[loop].childNodes[0].nodeValue;
				var QTY  = XMLQTY[loop].childNodes[0].nodeValue;

				
				
				var tbl = document.getElementById('tblPreOders');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				var cellConPc = row.insertCell(0);
				cellConPc.innerHTML = styleID;
				
				var cellConPc = row.insertCell(1);
				//cellConPc.innerHTML = SRNO;
				
				var cellConPc = row.insertCell(2);
				cellConPc.innerHTML = QTY;
				
				
				var cellDelete = row.insertCell(3);   
				var imgtext = "<img id=\"" + styleID + "\" onCLick=\"viewForm('" + styleID + "');\" class=\"mouseover\" src=\"images/view.png\">";
				cellDelete.innerHTML = imgtext;
				
			 }
			
		}
	}
}

function viewForm(styleNo)
{
	location="bom.php?styleID=" + URLEncode(styleNo);
}

function GetTargetPOs()
{
	var styleNo = document.getElementById('txtstyle').value;
	if(styleNo == "")
	{
		alert("No style specified.");
		return ;
	}
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePOList;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerPOListForStyleBOM&StyleNO=' + URLEncode(styleNo), true);
    xmlHttp.send(null);   
}

function RemoveAllRows()
{
	var tbl = document.getElementById('tblPreOders');
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function isValidQuantity()
{
	if (document.getElementById('txtorderqty').value == null || document.getElementById('txtorderqty').value == "")
	{
		alert("Please enter the order quantity.");
		document.getElementById('txtorderqty').focus();
		return false;
	}
	else if (document.getElementById('txtorderqty').value  <= 0 )
	{
		alert("Please enter the order quantity correctly.");
		document.getElementById('txtorderqty').focus();
		return false;
	}
	return true;
}

function ShowAddingForm()
{
	if (isValidQuantity())
	{
		ShowItems();
	}
}

function doQuantityChange()
{
	var orderQty = document.getElementById('txtorderqty').value;
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var conPC = rw.cells[6].lastChild.nodeValue;
		var totalQty = parseInt(orderQty,10) * parseFloat(conPC,10);
		var cc = rw.cells[8].lastChild.nodeValue;
		rw.cells[8].lastChild.nodeValue = RoundNumbers(totalQty,4);
		var unitPrice = parseFloat(rw.cells[10].lastChild.nodeValue);
		var price = parseInt(orderQty,10) * parseFloat(conPC,10) * unitPrice;
		rw.cells[13].lastChild.nodeValue = RoundNumbers(price,4);
		var value = parseFloat(conPC) * unitPrice;
		rw.cells[14].lastChild.nodeValue = RoundNumbers(value,4);
	}
	calculateCMValue();
	
}

/*function RoundNumbers(value,decimelPoints)
{
	if(value.indexOf(".") == -1 && decimelPoints == 0)
		decimelPoints = 1;
		
	var rs = new Number(value);
	var lrs=rs.toFixed(decimelPoints);	
	while (lrs.charAt(lrs.length-1) == "0")
		lrs = lrs.substring(0,(lrs.length-1));
	
	if(lrs.charAt(lrs.length-1) == ".")
		lrs = lrs.substring(0,(lrs.length-1));
		
	if(lrs== Infinity || isNaN(lrs))
		lrs = 0;
	return lrs;
}*/

function RoundNumbers(number,decimals) {
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	return newString; // Output the result to the form field (change for your purposes)
}

///   -----------------------------------------------------------------

function ShowItems()
{
	drawPopupArea(600,300,'frmItems');
	var HTMLText = "<table width=\"600\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Select Item </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closes();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						   "<tr>"+
							/*"<td height=\"25\">&nbsp;</td>"+*/
							"<td width=\"20%\" class=\"normalfnt\" height=\"25\">Main Cat</td>"+
							"<td align=\"left\" width=\"80%\"><label>"+
							  "<select name=\"cboMaterial\" onchange=\"LoadMaterialCategories();\" class=\"txtbox\" id=\"cboMaterial\" style=\"width:200px\" tabindex=\"1\">"+
								"<option value=\"1\">Fabric</option>"+
								"<option value=\"2\">Accessories</option>"+
								"<option value=\"3\">Packing Material</option>"+
								"<option value=\"4\">Services</option>"+
								"<option value=\"5\">Other</option>"+
								"<option value=\"6\">Washing</option>"+
							  "</select>"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td height=\"25\">&nbsp;</td>"+*/
							"<td width=\"17%\" class=\"normalfnt\" height=\"25\">Sub Cat</td>"+
							"<td align=\"left\" width=\"80%\"><label>"+
							  "<select name=\"cboCategory\" class=\"txtbox\" onchange=\"LoadItems();\" id=\"cboCategory\" style=\"width:200px\" tabindex=\"2\">"+
							  "</select>"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td height=\"24\">&nbsp;</td>"+*/
							"<td class=\"normalfnt\" height=\"25\">Item</td>"+
							"<td align=\"left\">"+
							  "<select name=\"cboItems\" onchange=\"LoadItemDetails();\" class=\"txtbox\" id=\"cboItems\" style=\"width:408px\" tabindex=\"3\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td height=\"24\">&nbsp;</td>"+*/
							"<td class=\"normalfnt\" height=\"25\">Filter</td>"+
							"<td align=\"left\" valign=\"top\">"+
							  "<input type=\"text\" id=\"txtFilter\" style=\"width:406px\" class=\"txtbox\" tabindex=\"4\" onkeypress=\"EnableEnterSubmitLoadItems(event);\"><img src=\"images/manage.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"FilterLoadedItems();\" tabindex=\"5\" >"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"3\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
									"<td width=\"81%\">&nbsp;</td>"+
								  "</tr>"+
								"</table></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
								  "<tr>"+
									"<td><table width=\"100%\" height=\"80\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
									  "<tr>"+
										"<td width=\"70px\" height=\"28\" class=\"normalfnt\">Con./PC.</td>"+
										"<td width=\"50px\" align=\"left\">"+
										"<input name=\"txtconsumpc2\"  onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" tabindex=\"6\" value=\"0\" maxlength=\"9\" style=\"width:108px; text-align:right\" />"+
										"</td>"+
										"<td align=\"left\" class=\"normalfnt\">Unit</td>"+
										  "<td align=\"left\"><select name=\"cboUnits\" class=\"txtbox\" onchange=\"ConvertToDefaultUnit();\" id=\"cboUnits\" style=\"width:141px;\" tabindex=\"7\"></select>"+
										  /*"<input name=\"chkConvert\" type=\"checkbox\" id=\"chkConvert\" value=\"checkbox\" /> Convert"+*/
										"</td>"+
										"</tr>"+
									  "<tr>"+
										"<td height=\"25\" class=\"normalfnt\">Unit Price</td>"+
										"<td align=\"left\" id=\"itemPrice\" title=\"\">"+
										  "<input name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"8\" value=\"0\" maxlength=\"9\" style=\"width:108px; text-align:right\" onkeyup=\"validateUnitprice();\"/>"+
										"</td>"+
										"<td width=\"14%\" class=\"normalfnt\">Wastage</td>"+
										"<td width=\"35%\" align=\"left\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"0\" tabindex=\"9\"  maxlength=\"5\" style=\"width:139px; text-align:right\" onkeyup=\"checkMaxWastage();\" />"+
										"</td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Origin</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"10\" style=\"width:110px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Freight</span></td>"+
										"<td align=\"left\"><input name=\"txtfreight\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"11\" value=\"0\" maxlength=\"9\" style=\"width:139px; text-align:right\" onblur=\"set4deci(this);\"/></td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Purchase Type</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboPurchaseType\" class=\"txtbox\" id=\"cboPurchaseType\" tabindex=\"12\" style=\"width:110px\">"+
										   "<option value=\"NONE\">NONE</option>" +
											"<option value=\"COLOR\">COLOR</option>" +
											"<option value=\"SIZE\">SIZE</option>" +
											"<option value=\"BOTH\">BOTH</option>" +												    
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Placement</span></td>"+
										"<td align=\"left\"><input name=\"txtPlacement\" type=\"text\" class=\"txtbox\" id=\"txtPlacement\" style=\"width:139px;\" tabindex=\"13\" value=\" \" /></td>"+
									  "</tr>"+
									"</table></td>"+
								  "</tr>"+
								"</table></td>"+
							 "</tr>"+
							"</table></td>"+
						  "</tr>"+
						  	 "<tr>"+
							"<td colspan=\"3\" height=\"30\" bgcolor=\"#D6E7F5\"><table width=\"100%\">"+
							  "<tr>"+
								"<td width=\"30%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"AddDataToGrid();\"  id=\"butSave\" tabindex=\"14\"/></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closes();\" id=\"butClose\" tabindex=\"15\"/></td>"+
								"<td width=\"30%\">&nbsp;</td>"+
							  "</tr>"+
						  "<tr>"+
							"<td align=\"left\" class=\"fntwithWite\" ><input type=\"checkbox\" tabindex=\"9\"  name=\"chkvariations\" id=\"chkvariations\" onchange=\"RemoveVariations();\" />Have Variations</td>"+
							"<td colspan=\"2\" ></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"4\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
							  "<tr>"+
								"<td><div id=\"selectitem\" style=\"overflow:scroll;height:100px;\" ><table width=\"100%\" border=\"0\" id=\"tblVariations\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
									"<tr>"+
									  "<td width=\"6%\" height=\"22\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Del</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Con Pc</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Unit Price</td>"+
									  "<td width=\"22%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Wastage</td>"+
									  "<td width=\"12%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Qty</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Color</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Size</td>"+
									"</tr>"+
								"</table></div></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\">"+
								  "<tr>"+
									"<td width=\"143\">&nbsp;</td>"+
									"<td width=\"312\">&nbsp;</td>"+
									"<td width=\"31\" colspan=\"2\"><img src=\"images/addnew2.png\" onClick=\"AddnewVariation();\" alt=\"Add\" /></td>"+
								  "</tr>"+
								"</table></td>"+
							  "</tr>"+
							"</table></td>"+
						  "</tr>"+
							"</table></td>"+
						 "</tr>"+
					  "</table></td>"+
					"</tr>"+
				  "</table>";
	
	loca = -1;
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	LoadDefaultCategories();
	LoadAvailableUnits();
	LoadOrigins();
	inc('javascript/buttonkeypress.js');

}
function checkMaxWastage()
{
	var wastageQty = Number(document.getElementById('txtwastage').value);
	var mxWastage = Number(maxWastage);
	if(wastageQty>mxWastage)
	{
		alert('Maximum Wastage pecentage is '+ mxWastage);
		document.getElementById('txtwastage').focus();
		document.getElementById('txtwastage').value = '';
		return false;
		}
		else
		{
			//CalculateFigures();
			//document.getElementById('txtSMVRate').focus();
			return true;
			}
		
	
}

function closeWindow(LayerID)
{
	try
	{
		var box = document.getElementById(LayerID);
		box.parentNode.removeChild(box);
	}
		catch(err)
	{        
	}	
		
}

function LoadMaterialCategories()
{
	RemoveCategories();
	var matID = document.getElementById('cboMaterial').value;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleCategories;
    thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetSubCategries&mainCatID=' + matID, true);
    thirdxmlHttp.send(null);  
}

function LoadDefaultCategories()
{
	var matID = 1;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleCategories;
    thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetSubCategries&mainCatID=' + matID, true);
    thirdxmlHttp.send(null); 
}

function HandleCategories()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboCategory").options.add(opt);
			document.getElementById("cboCategory").value = "Select One";
			
			 var XMLID = thirdxmlHttp.responseXML.getElementsByTagName("CatID");
			 var XMLName = thirdxmlHttp.responseXML.getElementsByTagName("CatName");
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboCategory").options.add(opt);
			 }
			
			
		}
	}
}

function RemoveCategories()
{
	var index = document.getElementById("cboCategory").options.length;
	while(document.getElementById("cboCategory").options.length > 0) 
	{
		index --;
		document.getElementById("cboCategory").options[index] = null;
	}
}

function LoadItems()
{
	//RemoveItems();
	var matID = document.getElementById('cboMaterial').value;
	var catID = document.getElementById('cboCategory').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleItems;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetItems&MainCatID=' + matID + '&CatID=' + catID, true);
    xmlHttp.send(null);  
}

function RemoveItems()
{
	var index = document.getElementById("cboItems").options.length;
	while(document.getElementById("cboItems").options.length > 0) 
	{
		index --;
		document.getElementById("cboItems").options[index] = null;
	}
}

function HandleItems()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			/* var XMLID = xmlHttp.responseXML.getElementsByTagName("itemID");
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("itemName");
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboItems").options.add(opt);
			 }
			 
			var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboItems").options.add(opt);
			document.getElementById("cboItems").value = "Select One";*/
			var XMLName = xmlHttp.responseXML.getElementsByTagName("itemName");	
			document.getElementById("cboItems").innerHTML = XMLName[0].childNodes[0].nodeValue;
			
		}
	}
}

function LoadAvailableUnits()
{
    var url = 'preordermiddletire.php?RequestType=GetUnits';
    var htmlobj = $.ajax({url:url,async:false});
	HandleUnits(htmlobj);
}

function HandleUnits(xmlHttp)
{
	var XMLName = xmlHttp.responseXML.getElementsByTagName("unit");
	document.getElementById("cboUnits").innerHTML 	= XMLName[0].childNodes[0].nodeValue;
	document.getElementById("cboUnits").value 		= currentUnit;
	previousUnit = currentUnit;
}

function LoadOrigins()
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleOrigines;
    altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetOrigin', true);
    altxmlHttp.send(null); 
}

function HandleOrigines()
{
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			 var XMLID = altxmlHttp.responseXML.getElementsByTagName("OriginID");
			 var XMLName = altxmlHttp.responseXML.getElementsByTagName("OriginType");
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboOrigine").options.add(opt);
			 }
			document.getElementById('cboOrigine').value = 4;
			if (loca != -1)
				document.getElementById('cboOrigine').value = loca;
		}
	}
}

function LoadItemDetails()
{
	var ItemCode = document.getElementById('cboItems').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleItemDetails;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetItemDiscription&ItemID=' + ItemCode , true);
    xmlHttp.send(null);  
}

function HandleItemDetails()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLUnit = xmlHttp.responseXML.getElementsByTagName("Unit");
			 var XMLWastage = xmlHttp.responseXML.getElementsByTagName("Wastage");
			  var XMLUnitPrice = xmlHttp.responseXML.getElementsByTagName("UnitPrice");
			 document.getElementById("cboUnits").value = XMLUnit[0].childNodes[0].nodeValue;
			// document.getElementById("txtwastage").value = XMLWastage[0].childNodes[0].nodeValue;
			 //document.getElementById('txtunitprice').value = XMLUnitPrice[0].childNodes[0].nodeValue;
			 //document.getElementById('itemPrice').title = XMLUnitPrice[0].childNodes[0].nodeValue;
			// if (document.getElementById("txtwastage").value == "")
			 //	document.getElementById("txtwastage").value = 0;
		}
	}
}

function AddnewVariation()
{
	if (document.getElementById("chkvariations").checked)
	{
		AddRowToVariationTable();
	}
	else
	{
		alert("Please select the variation checkbox first.");	
		document.getElementById("chkvariations").focus();
	}
}

function AddRowToVariationTable()
{
	var tbl = document.getElementById('tblVariations');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellDelete = row.insertCell(0);     
	var delImage = new Image(); 
	delImage.src = "images/del.png";
	delImage.onclick = RemoveRowFromVariationsTable;
    cellDelete.appendChild(delImage);
	
	var cellConPc = row.insertCell(1);
	cellConPc.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\"  >";
	var cellUnitPrice = row.insertCell(2);
	cellUnitPrice.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  >";
	var cellWastage = row.insertCell(3);
	cellWastage.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  >";
	var cellQty = row.insertCell(4);
	cellQty.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  >";
	var cellColor = row.insertCell(5);
	cellColor.innerHTML = "<input type=\"text\" style=\"width:100px;\" class=\"txtbox\"  >";	
	var cellSize = row.insertCell(6);
	cellSize.innerHTML = "<input type=\"text\" style=\"width:100px;\" class=\"txtbox\"  >";	
}

function RemoveRowFromVariationsTable()
{
	var td = this.parentNode;
	var tr = td.parentNode;
	tr.parentNode.removeChild(tr);
}

function ConvertToDefaultUnit()
{
	if (document.getElementById("chkConvert").checked)
	{
		var conpc = document.getElementById('txtconsumpc2').value;
		if (conpc == null || conpc == "")
		{
			alert("Please enter the correct consumption.");
			document.getElementById('txtconsumpc2').select();
			return;
		}
		
		var selectedType = document.getElementById('cboUnits').value;
		var itemCode = document.getElementById('cboItems').value;
		UnitConversion(conpc,selectedType,itemCode);
		previousUnit = selectedType;
	}
}

function UnitConversion(conpc,selectedtype,itemcode)
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleConversions;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetConPc&ItemID=' + itemcode + '&SelectedUnit=' + URLEncode(selectedtype) + '&ConPc=' + conpc + '&previousUnit=' + URLEncode(previousUnit), true);
    xmlHttp.send(null); 
}

function HandleConversions()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLUnitValue = xmlHttp.responseXML.getElementsByTagName("ConPcCalculated");
			 var XMLDefaultUnit = xmlHttp.responseXML.getElementsByTagName("DefaultUnit");
			 
			 document.getElementById("txtconsumpc2").value = XMLUnitValue[0].childNodes[0].nodeValue;
			 document.getElementById("cboUnits").value = XMLDefaultUnit[0].childNodes[0].nodeValue;
		}
	}
}

function AddDataToGrid()
{
	if (ValidateItemAddingForm())
	{
		var material = document.getElementById('cboMaterial').options[document.getElementById('cboMaterial').selectedIndex].text;
		var category = document.getElementById('cboCategory').options[document.getElementById('cboCategory').selectedIndex].text;
		var purchaseType = document.getElementById('cboPurchaseType').options[document.getElementById('cboPurchaseType').selectedIndex].text;
		var placement = document.getElementById('txtPlacement').value;
		var itemCode = document.getElementById('cboItems').value;
		var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
		var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
		var unitType = document.getElementById('cboUnits').value;
		var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
		var wastage = parseFloat(document.getElementById('txtwastage').value);
		var originID = document.getElementById('cboOrigine').value;
		var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
		var freight = parseFloat(document.getElementById('txtfreight').value);
		var styleNo = document.getElementById('lblStyleNo').innerHTML;
		var selection = document.getElementById('cboMaterial').value;
		
		if (!checkAvailability(itemCode))
		{
			if (!canUseSavedCmForAddingInSameCategory && unitPrice > 0 )
			{
				alert("You are not authorized to add a item with a price. The price should be equal to \"0\".");
				return ;
			}
			else
			{
				var price = 0;
				//if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
				if ((selection == "1" || selection == "Fabric" || selection == "FABRIC"))
				{
					price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
				}
				else
				{
					price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
				}	
				var matcost = getTotalMaterialCostExceptCurrentItem(selection);
				var newMatCost = matcost + parseFloat(price);
				var preOrderCost = parseFloat(RoundNumbers(getCostingValueForCategory(selection),getNoOfDecimals(newMatCost)));
				
				if(newMatCost > preOrderCost && price > 0)
				{
					alert("Sorry! You are exceeding the minimum CM level. Modification has been rejected.");
					return ;
				}
			}
			
			AddItem(material,category,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID,document.getElementById('cboMaterial').value);
			SaveVariations(styleNo,itemCode);
			RefreshAddingInterface();
			calculateCMValue();
			
		}
		else
		{
			alert("The item already exists. Please use item change option.");
			return;
		}
	}
//
//	if (!ValidateItemAddingForm()) return;
//	if (!CalculateVariationWiseQtyPrice()) return;
//		var material = document.getElementById('cboMaterial').options[document.getElementById('cboMaterial').selectedIndex].text;
//		var category = document.getElementById('cboCategory').options[document.getElementById('cboCategory').selectedIndex].text;
//		var purchaseType = document.getElementById('cboPurchaseType').options[document.getElementById('cboPurchaseType').selectedIndex].text;
//		var placement = document.getElementById('txtPlacement').value;
//		var itemCode = document.getElementById('cboItems').value;
//		var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
//		var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
//		var unitType = document.getElementById('cboUnits').value;
//		var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
//		var wastage = parseFloat(document.getElementById('txtwastage').value);
//		var originID = document.getElementById('cboOrigine').value;
//		var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
//		var freight = parseFloat(document.getElementById('txtfreight').value);
//		var styleNo = document.getElementById('lblStyleNo').innerHTML;
//		var selection = document.getElementById('cboMaterial').value;
//		
//		if (!checkAvailability(itemCode))
//		{
//			if (!canUseSavedCmForAddingInSameCategory && unitPrice > 0 )
//			{
//				alert("You are not authorized to add a item with a price. The price should be equal to \"0\".");
//				return ;
//			}
//			else
//			{
//				var price = 0;
//				
//				var totalQty = 0;
//				
//				//var ReqQty = RoundNumbers(parseFloat(document.getElementById('txtorderqty').value) * conPc,4);
//				//start 2010-10-15 calculate req qty
//				var orderQty = document.getElementById('txtorderqty').value;
//				var ReqQty = calculateReqQty(orderQty,conPc);
//				var exQty = document.getElementById('txtexcessqty').value;
//				/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
//				{
//					totalQty = ReqQty ;
//				}
//				else
//				{
//					//totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
//					totalQty = calculateTotalQty(orderQty,conPc,wastage,exQty);
//				}*/
//				totalQty = calculateTotalQty(orderQty,conPc,wastage,exQty,selection);
//				//2010-10-20--------------------------------------------
//				//var value = RoundNumbers(parseInt(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
//				var value =calculateCostValue(totalQty,unitPrice,freight);
//				//2010-10-20
//				var totOrderQty = parseFloat(document.getElementById('txtorderqty').value*exQty/100) + parseFloat(document.getElementById('txtorderqty').value);
//						price = RoundNumbers(calCostPCwithExcess(orderQty,value),4);
//		
//				//end---------------------------------------------------------------------------
//				var matcost = parseFloat(getTotalMaterialCostExceptCurrentItem(selection));
//				var newMatCost = RoundNumbers((matcost + parseFloat(price)),4);
//				var preOrderCost = parseFloat(RoundNumbers(getCostingValueForCategory(selection),getNoOfDecimals(newMatCost)));
//				//alert(preOrderCost);
//				/*if(newMatCost > preOrderCost && price > 0)
//				{
//					alert("Sorry! You are exceeding the minimum CM level. Modification has been rejected.");
//					return ;
//				}*/
//			}
//			
//			AddItem(material,category,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID,document.getElementById('cboMaterial').value);
//			SaveVariations(styleNo,itemCode);
//			RefreshAddingInterface();
//			calculateCMValue();
//			
//			
//		}
//		else
//		{
//			alert("The item already exists. Please use item change option.");
//			return;
//		}
}

function CalculateVariationWiseQtyPrice()
{
	if (document.getElementById("chkvariations").checked == false) return true;
	var tbl = document.getElementById('tblVariations');
	var totvalue = 0;
	var totprice = 0;
	var totQty = 0;
	var odrQty = parseInt(document.getElementById('txtorderqty').value);
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		
		var rw = tbl.rows[loop];
        var conpc = rw.cells[1].lastChild.value;
		var unitprice = rw.cells[2].lastChild.value;
		var wastage = rw.cells[3].lastChild.value;
		var qty = rw.cells[4].lastChild.value;
		totvalue += parseFloat(conpc) * parseInt(qty);
		//alert(totvalue); 
		totprice += parseFloat(qty) * parseFloat(unitprice) *  parseFloat(conpc);
		totQty += parseInt(qty);
	
	}		
	if (odrQty != totQty)
	{
		alert("The sum of quantities is not equal to order quantity");
		return false;
	}	
	var realConPC = RoundNumbers(totvalue / odrQty,consumptionDecimalLength);
	var realunitPrice = totprice/ totvalue;
	document.getElementById('txtconsumpc2').value = realConPC;
	document.getElementById('txtunitprice').value = RoundNumbers(realunitPrice,4);
	return true;
}

function ValidateItemAddingForm()
{
	if (document.getElementById('cboItems').value == "Select One")
	{
		alert("Please select the item you wish to add.");
		document.getElementById('cboItems').focus();
		return false;
	}
	else if (document.getElementById('txtconsumpc2').value == null || document.getElementById('txtconsumpc2').value == "" ||document.getElementById('txtconsumpc2').value == '0')
	{
		alert("Please enter the correct consumption.");
		document.getElementById('txtconsumpc2').select();
		return false;
	}
	else if (document.getElementById("txtunitprice").value == null || document.getElementById("txtunitprice").value == "")
	{
		alert("Please enter the unit price");
		document.getElementById('txtunitprice').focus();
		return false;
	}
	
	//start 2010-08=12 commented for orit bom-----------------
	/*var tbl = document.getElementById('tblVariations');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        //var cl = rw.cells[2];
        var ConPc = rw.cells[1].lastChild;
		if (ConPc.value == null || ConPc.value == "" || ConPc.value <= 0)
		{
			alert("Inavlid consumption pc found in variations.");
			ConPc.focus();
			return false;
		}
		
		var Description = rw.cells[5].lastChild;
		if (Description.value == null || Description.value == "" || Description.value <= 0)
		{
			alert("Description is not defined well in variations.");
			Description.focus();
			return false;
		}
	}	*/
	
	//--------end--------------------------------
	return true;
}

function RemoveVariations()
{
	if (document.getElementById("chkvariations").checked == false)
	{
		if(confirm('All variations will be deleted. Do you want to continue?'))
		{
			var tbl = document.getElementById('tblVariations');
			for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
			{
				 tbl.deleteRow(loop);
			}
		}
		else
		{
			document.getElementById("chkvariations").checked = true;	
		}
	}
}

function AddItem(material,category,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,selection)
{
	if ((selection == '1' || selection == 'F')  && wastage>0 && _1WastageAllowed == false)
	{
		alert("Fabric wastages not allowed in your company.");	
		document.getElementById('txtwastage').focus();
		return false;
	}
	var exQty = parseInt(document.getElementById('txtexcessqty').value);
	var tbl = document.getElementById('tblConsumption');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellEdit = row.insertCell(0);   
	cellEdit.id = itemCode;
	cellEdit.innerHTML = "<div id=" + itemCode + " onClick=\"ShowEditForm(this.parentNode.id);\" align=\"center\"><img src=\"images/edit.png\" class=\"mouseover\"  /></div>";
	
	var cellDelete = row.insertCell(1);     
	cellDelete.innerHTML = "<div id=" + itemCode + "  onClick=\"RemoveItem(this);\" align=\"center\"><img src=\"images/del.png\" class=\"mouseover\"  /></div>"; 
	
	var cellRatio = row.insertCell(2);   
	if (purchaseType == "NONE")
	{
	cellRatio.innerHTML = "<div align=\"center\"><img src=\"images/matratio.png\" class=\"mouseover\"  onclick=\"ShowMaterialRatiowindow(this);\" /></div>"; 
	}
	else if(purchaseType == "COLOR" || purchaseType == "BOTH" )
	{
		cellRatio.innerHTML = "<div align=\"center\"><img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" style=\"visibility:hidden\" ></div>";
	}
	else
	{
		cellRatio.innerHTML = "<div align=\"center\"><img src=\"images/matratio.png\" class=\"mouseover\" style=\"visibility:hidden;\" onclick=\"ShowMaterialRatiowindow(this);\" /></div>"; 
	}
	
	if (purchaseType == "NONE")
	{
		row.className="backcolorWhite";
	}
	else
	{
		row.className="bcgcolor-tblrow";
	}
	
	var cellmaterial = row.insertCell(3);     
	cellmaterial.className="normalfntSM";
	cellmaterial.id = arrayLocation;
	var upper = material.toUpperCase()
	cellmaterial.innerHTML = upper.substr(0,3);
	
	var cellCategory = row.insertCell(4); 
	cellCategory.id=selection;
	cellCategory.className="normalfntSM";
	cellCategory.innerHTML = category;
	
	var cellDescription = row.insertCell(5);     
	cellDescription.className="normalfntSM";
	cellDescription.id = itemCode;
	cellDescription.innerHTML = itemDescription;
	
	var cellConPC = row.insertCell(6);     
	cellConPC.className="normalfntRiteSML";
	cellConPC.innerHTML = conPc;
	
	if (wastage == null || wastage == "" || isNaN(wastage) )
	wastage = 0;
					
	var cellWastage= row.insertCell(7);     
	cellWastage.className="normalfntRiteSML";
	cellWastage.innerHTML = wastage;
	
	var qty = parseInt(document.getElementById('txtorderqty').value,10);
	//var ReqQty = qty *  parseFloat(conPc);
	//start 2010-10-15 calculating req qty
	var ReqQty =  calculateReqQty(qty,conPc);
	// ----------------
	var totalQty = 0;
	
	/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		totalQty = ReqQty  ;
	}
	else
	{
	 	//totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
		totalQty = calculateTotalQty(qty,conPc,wastage,exQty);
	}*/
	// ----------------
	totalQty = calculateTotalQty(qty,conPc,wastage,exQty,selection);
	var cellTotQty = row.insertCell(8);     
	cellTotQty.className="normalfntRiteSML";
	//var reqQty = qty *  parseFloat(conPc);
	cellTotQty.innerHTML = totalQty;
	
	var cellUnit = row.insertCell(9);     
	cellUnit.className="normalfntMid";
	cellUnit.id = unitType;
	cellUnit.innerHTML = unitType;
	
	var cellUnitPrice = row.insertCell(10);     
	cellUnitPrice.className="normalfntRiteSML";
	cellUnitPrice.innerHTML = unitPrice;
	
	var cellFreight = row.insertCell(11);     
	cellFreight.className="normalfntRiteSML";
	cellFreight.innerHTML = freight;
	
	//
	var cellPurchaseType = row.insertCell(12);     
	cellPurchaseType.className="normalfntMid";
	cellPurchaseType.id = itemCode;
	var purchaseText = "<select name=\"select\" class=\"txtbox\" onchange=\"updatePurchaseType(this);\">" ;
	var ratioType = 0; 
	
	if (purchaseType == "NONE")
	{
		ratioType = 0;
		purchaseText += "<option selected=\"selected\" value=\"NONE\">NONE</option>";
	}
	else
	{
		purchaseText += "<option value=\"NONE\">NONE</option>";
	}
	
	if (purchaseType == "COLOR")
	{
		ratioType = 1; 
		purchaseText += "<option selected=\"selected\" value=\"COLOR\">COLOR</option>";
	}
	else
	{
		purchaseText += "<option value=\"COLOR\">COLOR</option>";
	}
	
	if (purchaseType == "SIZE")
	{
		ratioType = 1;
		purchaseText += "<option selected=\"selected\" value=\"SIZE\">SIZE</option>";
	}
	else
	{
		purchaseText += "<option value=\"SIZE\">SIZE</option>";
	}
	
	if (purchaseType == "BOTH")
	{
		ratioType = 1;
		purchaseText += "<option selected=\"selected\" value=\"BOTH\">BOTH</option>";
	}
	else
	{
		purchaseText += "<option value=\"BOTH\">BOTH</option>";
	}
	
	
	
	purchaseText += "</select>";
	
	cellPurchaseType.innerHTML = purchaseText;
	//
	
	
	// ----------------------
	var price = 0;
	/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}*/
	totalQty = RoundNumbers(totalQty,0);
	//var value = RoundNumbers(parseInt(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	var value = calculateCostValue(totalQty,unitPrice,freight);
	
	var totOrderQty = parseFloat(document.getElementById('txtorderqty').value*exQty/100) + parseFloat(document.getElementById('txtorderqty').value);
			price = RoundNumbers(calCostPCwithExcess(qty,value),4);
			
	// ----------------------
	//var price = qty * parseFloat(conPc) *  parseFloat(unitPrice);
	var cellOrderPrice = row.insertCell(13);     
	cellOrderPrice.className="normalfntRiteSML";
	cellOrderPrice.innerHTML = price;//RoundNumbers(price,4);
	
	//var value = parseFloat(conPc) *  parseFloat(unitPrice);
	var cellOrderValue = row.insertCell(14);     
	cellOrderValue.className="normalfntRiteSML";
	cellOrderValue.innerHTML =  value;//RoundNumbers(value,4);
					
	//
	var OrderType = "FOB";
	if (parseFloat(unitPrice) <= 0 )
	{
		OrderType = "NFE";
	}
	var cellOrderType = row.insertCell(15);     
	cellOrderType.className="normalfntMid";
	cellOrderType.id = originid;
	cellOrderType.innerHTML = OrderType;
	//
	//cellPurchaseType.innerHTML =  purchaseType;
	
	var cellPlacement = row.insertCell(16);     
	cellPlacement.className="normalfntMid";
	cellPlacement.innerHTML =  placement;
	
	var cellOrigin = row.insertCell(17);     
	cellOrigin.className="normalfntSM";
	cellOrigin.id = originid;
	cellOrigin.innerHTML =  originName;
	
	var cellPurchQty = row.insertCell(18);     
	cellPurchQty.className="normalfntRite";
	cellPurchQty.innerHTML =  0;
	
	var cellAvgPrice = row.insertCell(19);     
	cellAvgPrice.className="normalfntRite";
	cellAvgPrice.innerHTML =  0;
	
	var cellAvgValue = row.insertCell(20);     
	cellAvgValue.className="normalfntRite";
	cellAvgValue.innerHTML =  0;
	
	var cellVariation = row.insertCell(21);     
	cellVariation.className="normalfntRite";
	cellVariation.innerHTML =  0;
	
	var cellLeftOver = row.insertCell(22);
	cellLeftOver.className="normalfntRite";
	//cellLeftOver.onClick='LoadAllocation(this);';
	cellLeftOver.innerHTML = "<img src=\"images/butt_1.png\"/ onclick=\"LoadAllocation(this);\">";
	
	//var totalQty = RoundNumbers(reqQty + (reqQty * parseInt(document.getElementById('txtexcessqty').value,10) / 100),4);
	//var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice + wastage),4);
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	SaveItem(styleNo,itemCode,unitType,unitPrice,conPc,wastage,purchaseType,OrderType,placement,ratioType,ReqQty,totalQty,value,price,freight,originid);
}

function checkAvailability(itemcode)
{
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        //var cl = rw.cells[2];
        var itemid = rw.cells[0].id;
		if (itemid == itemcode)
			return true;
	}
	return false;
}

function RefreshAddingInterface()
{
	/*var tbl = document.getElementById('tblVariations');
	 for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	 {
	 	tbl.deleteRow(loop);
	 }*/
	document.getElementById('txtconsumpc2').value = "0";
	document.getElementById('txtunitprice').value = "0";
	document.getElementById('txtwastage').value = "0";
	document.getElementById('txtfreight').value = "0";
	document.getElementById("cboItems").value = "Select One";
	document.getElementById("cboCategory").value = "Select One";
	//document.getElementById("chkvariations").checked = false;
	document.getElementById('cboPurchaseType').value = "NONE";
	document.getElementById('txtPlacement').value = ' ' ;
	document.getElementById("cboCategory").focus();
}

var currentEditingRow = -1;
function closes()
{
	if(alloType == 'POItem')
	{
		LoadGridData();
		}
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

function ShowEditForm(itemcode)
{
	/* ===========================================================================
		Add On - 01/20/2016
		Add By - Nalin Jayakody
		Add For - Check if PO raise for selected item. This is try to avoid change item in the BOM 
	              after raise PO and user while working on several tabs on the browser.          
	   ===========================================================================
	*/
	var styleId = $("#cboSR").val();
	var urlBOM  = 'bomMiddletire.php?RequestType=IsPORaised&ItemCode='+itemcode+'&styleCode='+styleId;
	var htmlObj = $.ajax({url:urlBOM, async:false});
	
	
	var XMLPOExit = htmlObj.responseXML.getElementsByTagName("IsPOExist");

	var IsPOExist = parseInt(XMLPOExit[0].childNodes[0].nodeValue);
	if(IsPOExist == 1){
		alert("You cannot edit, because purchase order already raised for selected item ");return;
		
	}
	/* =========================================================================== */
	currentItemCode = itemcode;
	isPurchasedWithinTheProcess(itemcode);
	var tbl = document.getElementById('tblConsumption');
	var p = 0;
	
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{		
		var rw = tbl.rows[loop];
        var currentCode = rw.cells[5].id;
       
		if (currentCode == currentItemCode)
		{
			p ++;
			break;
		}
		p ++;
	}	
	currentEditingRow = p;
	var df= tbl.rows[p].cells[12];
	currentUnit = tbl.rows[p].cells[9].id;
	var itemName = tbl.rows[p].cells[5].lastChild.nodeValue;
	var purchaseType = tbl.rows[p].cells[12].lastChild.value;
	var conPC = tbl.rows[p].cells[6].lastChild.nodeValue;

	var unitPrice = tbl.rows[p].cells[10].lastChild.nodeValue;
	var wastage = tbl.rows[p].cells[7].lastChild.nodeValue;
	var freight = tbl.rows[p].cells[11].lastChild.nodeValue;
	var placement = " " ;
	if (tbl.rows[p].cells[16].childNodes.length != 0)
		placement = tbl.rows[p].cells[16].lastChild.nodeValue;
	var originID = tbl.rows[p].cells[17].id;
	var phsQty = parseFloat(tbl.rows[p].cells[18].lastChild.nodeValue);
	var disableUnits = phsQty > 0 ? " disabled=\"disabled\" " : " ";
	var imgvisibility = phsQty > 0 ? " style=\"visibility:hidden\" " : " ";
	var itemPrice = getItemUnitprice(itemcode);
	
	drawPopupArea(600,250,'frmItems');
	var HTMLText = "<table width=\"600\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							/*"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+*/
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Edit Item - " + itemName + " </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closes();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td height=\"24\">&nbsp;</td>"+*/
							"<td class=\"normalfnt\"  height=\"24\" width=\"107\">Item</td>"+
							"<td align=\"left\">"+
							  "<select name=\"cboItems\"" +  disableUnits + " onchange=\"LoadItemDetails();\" class=\"txtbox\" id=\"cboItems\" style=\"width:400px\" tabindex=\"2\">"+
							 // "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							"</td>"+
						  "</tr>"+
						   "<tr>"+
							/*"<td height=\"24\">&nbsp;</td>"+*/
							"<td class=\"normalfnt\"  height=\"24\"></td>"+
							"<td align=\"left\" valign=\"top\">"+
							 "<input type=\"text\" id=\"txtFilter\"  style=\"width:398px\" class=\"txtbox\" onkeypress =\"autocomplete_item();\">" +
							 "<img src=\"images/manage.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onclick =\"DisplaySelectedItem('" + itemcode + "');  "+imgvisibility+" \">"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"3\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
									"<td width=\"81%\">&nbsp;</td>"+
								  "</tr>"+
								"</table></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
								  "<tr>"+
									"<td><table width=\"100%\" height=\"80\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
									  "<tr>"+
										"<td width=\"18%\" height=\"28\" class=\"normalfnt\">Consum Pc</td>"+
										"<td width=\"33%\" align=\"left\" id=\"" + conPC + "\">"+
										"<input name=\"txtconsumpc2\"  onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event); \" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" tabindex=\"3\" value=\"" + conPC + "\" style=\"width:98px; text-align:right\" maxlength=\"9\" onblur=\"set4deci(this); \" onkeyup=\" ValueChanged(); \"/>"+
										"</td>"+
										"<td  align=\"left\" class=\"normalfnt\">Unit</td>"+
										  "<td align=\"left\"><select name=\"cboUnits\" " + disableUnits + " class=\"txtbox\" onchange=\"ConvertToDefaultUnit();\" id=\"cboUnits\" style=\"width:120px;\" tabindex=\"4\"></select>"+
										  /*"<input name=\"chkConvert\" type=\"checkbox\" id=\"chkConvert\" value=\"checkbox\" /> Convert"+*/
										"</td>"+
										"</tr>"+
									  "<tr>"+
										"<td height=\"25\" class=\"normalfnt\">Unit Price</td>"+
										"<td align=\"left\" id=\"itemPrice\" title=\""+itemPrice+"\">"+
										  "<input name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"8\" value=\"" + unitPrice + "\" maxlength=\"9\" style=\"width:98px; text-align:right\" onkeyup=\"validateUnitprice();isPurchaseWithinTheProcessToGetHighestUnitPrice('" + itemcode + "'); ValueChanged();\"/>"+
										"</td>"+
										"<td width=\"14%\" class=\"normalfnt\">Wastage</td>"+
										"<td width=\"35%\" align=\"left\"  id=\"" + wastage + "\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"" + wastage + "\" tabindex=\"6\" style=\"width:118px; text-align:right\" maxlength=\"5\" onkeyup=\"checkMaxWastage(); ValueChanged();\" onblur=\"set4deci(this);\"/>"+
										"</td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Origin</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"7\" style=\"width:100px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Freight</span></td>"+
										"<td align=\"left\"><input name=\"txtfreight\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"8\" value=\"" + freight + "\" style=\"width:118px; text-align:right\" maxlength=\"9\" onblur=\"set4deci(this);\"/></td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Purchase Type</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboPurchaseType\" class=\"txtbox\" id=\"cboPurchaseType\" tabindex=\"9\" style=\"width:100px\">"+
										   "<option value=\"NONE\">NONE</option>" +
											"<option value=\"COLOR\">COLOR</option>" +
											"<option value=\"SIZE\">SIZE</option>" +
											"<option value=\"BOTH\">BOTH</option>" +												    
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Placement</span></td>"+
										"<td align=\"left\"><input name=\"txtPlacement\" type=\"text\" class=\"txtbox\" id=\"txtPlacement\"  value=\"" + placement + "\" tabindex=\"10\" style=\"width:118px;\"/></td>"+
									  "</tr>"+
									"</table></td>"+
								  "</tr>"+
								"</table></td>"+
							 "</tr>"+
							"</table></td>"+
						  "</tr>"+
						  	 "<tr>"+
							"<td colspan=\"3\" height=\"30\" bgcolor=\"#D6E7F5\"><table width=\"100%\">"+
							  "<tr>"+
								"<td width=\"30%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"UpdateConsumptions('" + itemcode + "');\" id=\"butSave\" tabindex=\"11\"/></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closes();\" id=\"butClose\" tabindex=\"12\"/></td>"+
								"<td width=\"30%\">&nbsp;</td>"+
							  "</tr>"+
						 "<tr>"+
							"<td align=\"left\" class=\"fntwithWite\" ><input type=\"checkbox\" tabindex=\"9\"  name=\"chkvariations\" id=\"chkvariations\" onchange=\"RemoveVariations();\" />Have Variations</td>"+
							"<td colspan=\"2\" ></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"4\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
							  "<tr>"+
								"<td><div id=\"selectitem\" style=\"overflow:scroll;height:100px;\" ><table width=\"100%\" border=\"0\" id=\"tblVariations\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
									"<tr>"+
									  "<td width=\"6%\" height=\"22\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Del</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Con Pc</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Unit Price</td>"+
									  "<td width=\"22%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Wastage</td>"+
									  "<td width=\"12%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Qty</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Color</td>"+
									  "<td width=\"20%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Size</td>"+
									"</tr>"+
								"</table></div></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\">"+
								  "<tr>"+
									"<td width=\"143\">&nbsp;</td>"+
									"<td width=\"312\">&nbsp;</td>"+
									"<td width=\"31\" colspan=\"2\"><img src=\"images/addnew2.png\" onClick=\"AddnewVariation();\" alt=\"Add\" /></td>"+
								  "</tr>"+
								"</table></td>"+
							  "</tr>"+
							"</table></td>"+
						  "</tr>"+
							"</table></td>"+
						 "</tr>"+
					  "</table></td>"+
					"</tr>"+
				  "</table>";
	
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	LoadCategoryItems(itemcode);
	LoadAvailableUnits();
	LoadOrigins();
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	LoadVariations(styleNo,itemcode);
	document.getElementById('cboPurchaseType').value =  purchaseType;
	loca = originID;
	inc('javascript/buttonkeypress.js');
}

function autocomplete_item()
{
	var text = document.getElementById('txtFilter').value;
	var itemId = document.getElementById('cboItems').value;
	var url6	='bomMiddletire.php?RequestType=GetAutocompleteItem' ;
		url6 += '&text=' +text;
		url6 += '&itemId=' + itemId;
	
			var htmlobj	=$.ajax({url:url6,async:false});
			//alert(htmlobj.responseText);
			var pub_pending_arr		=htmlobj.responseText.split("|");
			//alert(pub_pending_arr);
			$( "#txtFilter" ).autocomplete({
			source: pub_pending_arr
			//alert(htmlobj.responseText);
		});
			
}

function DisplaySelectedItem()
{
	
	var selectedItem = document.getElementById('txtFilter').value;
	var url = 'bomMiddletire.php?RequestType=DisplaySelectedItem&selectedItem=' + selectedItem;
																						
			var htmlobj=$.ajax({url:url,async:false});
			//alert(htmlobj.responseText);
		
 			var XMLID = htmlobj.responseXML.getElementsByTagName("ItemId")[0].childNodes[0].nodeValue;
			var XMLMAINID = htmlobj.responseXML.getElementsByTagName("ItemmainId")[0].childNodes[0].nodeValue;
			//alert(htmlobj.responseXML.getElementsByTagName("ItemId"));
			//alert(XMLID[0].childNodes[0].nodeValue);			 
			document.getElementById("cboItems").value = XMLMAINID;	
			//alert(XMLMAINID);			
			
}

function isPurchaseWithinTheProcessToGetHighestUnitPrice(itemCode)
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createNewXMLHttpRequest(1);
    xmlHttpreq[1].onreadystatechange = HandleGettingPurchasedHighUnitprice; // SavePreOrder
    xmlHttpreq[1].open("GET", 'bomMiddletire.php?styleID=' + URLEncode(StyleNo) + '&RequestType=checkPurchasedUnitprice&itemCode=' + itemCode , true);   
	xmlHttpreq[1].send(null); 
}

function HandleGettingPurchasedHighUnitprice()
{
    if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        {  
			 var XMLUnitprice = xmlHttpreq[1].responseXML.getElementsByTagName("HighestUnitprice");
			 var purchasedUnitprice = XMLUnitprice[0].childNodes[0].nodeValue;
			 var unitprice = parseFloat(document.getElementById('txtunitprice').value);	
	
			if(!canDecreaseItemUnitprice)
			{
				if(unitprice<purchasedUnitprice)
				{
					alert("Sorry, you do not have permission to decrease item unitprice upto its PO highest unitprice ");
					document.getElementById('txtunitprice').value =parseFloat(purchasedUnitprice);
					return false;
				}
			}
			
		}
	}
}


function LoadVariations(styleNo,itemcode)
{
	createtFourthXMLHttpRequest();
    fourthxmlHttp.onreadystatechange = HandleVariations;
    fourthxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetVariations&styleNo=' + URLEncode(styleNo) + '&itemcode=' + itemcode , true);
    fourthxmlHttp.send(null); 	
}

function HandleVariations()
{
	if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  		
			 var XMLNo = fourthxmlHttp.responseXML.getElementsByTagName("No");
			 var XMLConPc = fourthxmlHttp.responseXML.getElementsByTagName("ConPC");
			 var XMLUnitPrice = fourthxmlHttp.responseXML.getElementsByTagName("UnitPrice");
			 var XMLWastage = fourthxmlHttp.responseXML.getElementsByTagName("Wastage");
			 var XMLQty = fourthxmlHttp.responseXML.getElementsByTagName("Qty");
			 var XMLColor = fourthxmlHttp.responseXML.getElementsByTagName("Color");
			 var XMLSize = fourthxmlHttp.responseXML.getElementsByTagName("Size");
			 for ( var loop = 0; loop < XMLNo.length; loop ++)
			 {
				 document.getElementById('chkvariations').checked = true;
				 AddVariationRowWithData(XMLConPc[loop].childNodes[0].nodeValue,XMLUnitPrice[loop].childNodes[0].nodeValue,XMLWastage[loop].childNodes[0].nodeValue,XMLQty[loop].childNodes[0].nodeValue,XMLColor[loop].childNodes[0].nodeValue,XMLSize[loop].childNodes[0].nodeValue);
			 }
		}
		
	}
}

function AddVariationRowWithData(conpc,unitprice,wastage,qty,color,size)
{
	var tbl = document.getElementById('tblVariations');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellDelete = row.insertCell(0);     
	var delImage = new Image(); 
	delImage.src = "images/del.png";
	delImage.onclick = RemoveRowFromVariationsTable;
    cellDelete.appendChild(delImage);
	
	var cellConPc = row.insertCell(1);
	cellConPc.innerHTML = "<input type=\"text\"  style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\" value=\"" + conpc + "\"  >";
	var cellUnitPrice = row.insertCell(2);
	cellUnitPrice.innerHTML = "<input type=\"text\"  style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + unitprice + "\" >";
	var cellWastage = row.insertCell(3);
	cellWastage.innerHTML = "<input type=\"text\"  style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + wastage + "\" >";
	var cellQty = row.insertCell(4);
	cellQty.innerHTML = "<input type=\"text\"  style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + qty + "\" >";
	var cellColor = row.insertCell(5);
	cellColor.innerHTML = "<input type=\"text\"  style=\"width:100px;\" class=\"txtbox\"  value=\"" + color + "\"  >";		
	var cellSize = row.insertCell(6);
	cellSize.innerHTML = "<input type=\"text\"  style=\"width:100px;\" class=\"txtbox\"  value=\"" + size + "\"  >";		

}

function UpdateConsumptions(currentItemCode)
{
    //alert(currentItemCode);
	if(! canplaysamecategory)
	{
		if(parseFloat(document.getElementById('txtconsumpc2').parentNode.id) < parseFloat(document.getElementById('txtconsumpc2').value))
		{																												  
			alert("You have not permision to exceed 'Consum PC'");
			return;
		}
		
		if(parseFloat(document.getElementById('txtunitprice').parentNode.id) < parseFloat(document.getElementById('txtunitprice').value))
		{																												  
			alert("You have not permision to exceed 'Unit Price'");
			return;
		}
		if(parseFloat(document.getElementById('txtwastage').parentNode.id) < parseFloat(document.getElementById('txtwastage').value))
		{																												  
			alert("You have not permision to exceed 'Wastage'");
			return;
		}
		
		
	}

	
	var purchaseType = document.getElementById('cboPurchaseType').options[document.getElementById('cboPurchaseType').selectedIndex].text;
	var placement = document.getElementById('txtPlacement').value;
	var itemCode = document.getElementById('cboItems').value;
	//alert(itemCode);
	var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
	var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
	var unitType = document.getElementById('cboUnits').value;
	var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
	var wastage = parseFloat(document.getElementById('txtwastage').value);
	var originID = document.getElementById('cboOrigine').value;
	var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
	var freight = parseFloat(document.getElementById('txtfreight').value);	
	
	var selection = ""
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var currentCode = tbl.rows[loop].cells[5].id;
		if (currentCode == currentItemCode)
		{
			selection = tbl.rows[loop].cells[4].id;
		}
	}
	
	var price = 0;
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC"))
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	
		
	var matcost = getTotalMaterialCostExceptCurrentItem(selection);
	var newMatCost = parseFloat((parseFloat(matcost) + parseFloat(price)).toFixed(4));
	var preOrderCost = parseFloat(RoundNumbers(getCostingValueForCategory(selection),getNoOfDecimals(newMatCost)));
//	alert(itemDescriptionPrv);
	//alert(isPriceChanged);
//	alert(newMatCost);alert(preOrderCost);
	if(isPriceChanged){
		if(newMatCost > preOrderCost)
		{
			alert("Sorry you are exceeding the minimum CM level. Modification has been rejected.");
			return ;
		}
	}
	
	var p = currentEditingRow;
	var purchasedQty = tbl.rows[p].cells[18].lastChild.nodeValue;
	
	ModifyTable(p,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID);

	
	calculateCMValue();
	
///*
//	if (!CalculateVariationWiseQtyPrice()) return;
//	var purchaseType = document.getElementById('cboPurchaseType').options[document.getElementById('cboPurchaseType').selectedIndex].text;
//	var placement = document.getElementById('txtPlacement').value;
//	var itemCode = document.getElementById('cboItems').value;
//	
//	var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
//	var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
//	
//	if(conPc == 0 || conPc == '')
//	{
//		alert("Please enter the correct consumption.");
//		document.getElementById('txtconsumpc2').select();
//		return false;
//	}
//	if(parseFloat(document.getElementById('txtunitprice').parentNode.id) < parseFloat(document.getElementById('txtunitprice').value))
//		{																												  
//			alert("You have not permision to exceed 'Unit Price'");
//			return;
//		}
//	var unitType = document.getElementById('cboUnits').value;
//	var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
//	var wastage = parseFloat(document.getElementById('txtwastage').value);
//	var originID = document.getElementById('cboOrigine').value;
//	var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
//	var freight = parseFloat(document.getElementById('txtfreight').value);	
//	
//	if (!canUseSavedCmForAddingInSameCategory && unitPrice > 0 )
//			{
//				alert("You are not authorized to edit a item with a price. The price should be equal to \"0\".");
//				return ;
//			}
//	
//	var selection = ""
//	var tbl = document.getElementById('tblConsumption');
//    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
//  	{
//		var currentCode = tbl.rows[loop].cells[5].id;
//		if (currentCode == currentItemCode)
//		{
//			selection = tbl.rows[loop].cells[4].id;
//		}
//	}
//	
//	
//	
//	var price = 0;
//	
//	//start 2010-08-26 commented for orit---------------------------------------------------- 
//	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
//	{
//		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
//	}
//	else
//	{
//		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
//	}
//	end ----------------------------------------------------------------------------------
//	
//	orit price calculation ---------------------------------------------------------
//	var totalQty = 0;
//	var ReqQty = RoundNumbers(parseFloat(document.getElementById('txtorderqty').value) * conPc,4);
//	set reqQty as 1 if reqQty is less than 1
//	var orderQty = document.getElementById('txtorderqty').value;
//	var ReqQty = calculateReqQty(orderQty,conPc);
//	var exQty = document.getElementById('txtexcessqty').value;
//	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
//	{
//		totalQty = ReqQty ;
//	}
//	else
//	{
//		//totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
//		totalQty = calculateTotalQty(orderQty,conPc,wastage,exQty);
//	}
//	totalQty = calculateTotalQty(orderQty,conPc,wastage,exQty,selection);
//	
//	var value = RoundNumbers(parseInt(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
//	var value = calculateCostValue(totalQty,unitPrice,freight);
//	
//	var totOrderQty = parseFloat(document.getElementById('txtorderqty').value*exQty/100) + parseFloat(document.getElementById('txtorderqty').value);
//			price = RoundNumbers(calCostPCwithExcess(orderQty,value),4);
//			
//	end----------------------------------------------------------------------------
//	var matcost = parseFloat(getTotalMaterialCostExceptCurrentItem(selection));
//	var newMatCost = RoundNumbers((matcost + parseFloat(price)),4);
//	var preOrderCost = parseFloat(RoundNumbers(getCostingValueForCategory(selection),getNoOfDecimals(newMatCost)));
//	
//	alert(matcost+' '+preOrderCost+' '+newMatCost+' '+price);
//	if(newMatCost > preOrderCost)
//	{
//		alert("Sorry you are exceeding the minimum CM level. Modification has been rejected.");
//		return ;
//	}
//	
//	var p = currentEditingRow;
//	
//	var lc=-1;
//	var tbl = document.getElementById('tblConsumption');
//    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
//  	{		
//		var rw = tbl.rows[loop];
//        var currentCode = rw.cells[5].id;
//		if (currentCode == currentItemCode)
//		{
//			p ++;
//			lc = loop;
//			break;		
//		}
//		p ++;
//	}	
//	alert(p);
//	*/
//	var purchasedQty = tbl.rows[p].cells[18].lastChild.nodeValue;
//	
//	ModifyTable(p,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID);
//
//	
//	calculateCMValue();
//	

}

function LoadCategoryItems(itemcode)
{
	/*createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleItemCategories;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetItemListforCategory&styleID=' + itemcode , true);
    thirdxmlHttp.send(null); */
	
	var url = 'bomMiddletire.php?RequestType=GetItemListforCategory';
							url += '&styleID=' +itemcode;
																		
			var htmlobj=$.ajax({url:url,async:false});
			var XMLID = htmlobj.responseXML.getElementsByTagName("ItemID");
			document.getElementById("cboItems").innerHTML =  XMLID[0].childNodes[0].nodeValue;
			document.getElementById('cboItems').value = itemcode;
}

function HandleItemCategories()
{
	if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			 var XMLID = thirdxmlHttp.responseXML.getElementsByTagName("ItemID");
			 var XMLName = thirdxmlHttp.responseXML.getElementsByTagName("ItemName");
			 
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboItems").options.add(opt);
			 }

			document.getElementById('cboItems').value = currentItemCode;
		}
	}
}

function ModifyTable(position,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid)
{
	var tbl = document.getElementById('tblConsumption');
	var qty = parseInt(document.getElementById('txtorderqty').value,10);
	var exQty = parseInt(document.getElementById('txtexcessqty').value);
	var selection = tbl.rows[position].cells[4].id;
	//var ReqQty = qty *  parseFloat(conPc);
	var ReqQty = calculateReqQty(qty,conPc);
	var totalQty = 0;	
	
	if ((selection == '1' || selection == 'F')  && wastage>0 && _1WastageAllowed == false)
	{
		alert("Fabric wastages not allowed in your company.");	
		document.getElementById('txtwastage').focus();
		return false;
	}
	
	/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		totalQty = parseFloat(ReqQty)  ;
	}
	else
	{
			//totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
			totalQty = calculateTotalQty(qty,conPc,wastage,exQty);
	}*/
	totalQty = calculateTotalQty(qty,conPc,wastage,exQty,selection);
	
	var purchasedQty  = parseFloat(tbl.rows[position].cells[18].lastChild.nodeValue);
	if (totalQty < purchasedQty)
	{
		alert("The material quantity already purchased. You can't decrease it further more.\nPurchased Qty : " + purchasedQty  + "\nMatirial Qty       : " + totalQty );
		return;
	}
	//alert("New Item Code " + itemCode);
	var exQty = parseInt(document.getElementById('txtexcessqty').value);
	tbl.rows[position].cells[0].id = itemCode;
	tbl.rows[position].cells[0].lastChild.id = itemCode;
	tbl.rows[position].cells[5].id = itemCode;
	tbl.rows[position].cells[5].lastChild.id=itemCode;
	tbl.rows[position].cells[5].lastChild.nodeValue = itemDescription;
	tbl.rows[position].cells[6].lastChild.nodeValue = RoundNumbers(conPc,consumptionDecimalLength);
	tbl.rows[position].cells[7].lastChild.nodeValue  = wastage;
        
        //alert("Before Assign New ID" + tbl.rows[position].cells[12].id);
        // ================================================
        // Adding On - 07/27/2016
        // Adding By - Nalin Jayakody
        // Add For - Assign item code to the 'Pruchase Mode Cell'
        //=====================================================
        tbl.rows[position].cells[12].id = itemCode;
	//=====================================================
	//alert("After Assign New ID" + tbl.rows[position].cells[12].id);
	

	tbl.rows[position].cells[8].lastChild.nodeValue = totalQty;
	
	tbl.rows[position].cells[9].id = unitType;
	if (tbl.rows[position].cells[9].lastChild == null) 
	{
		tbl.rows[position].cells[9].innerHTML = " ";
	}
	tbl.rows[position].cells[9].lastChild.nodeValue  = unitType;
	
	tbl.rows[position].cells[10].lastChild.nodeValue = RoundNumbers(unitPrice,4);
	
	tbl.rows[position].cells[11].lastChild.nodeValue  = freight;
	
	var OrderType = "FOB";
	if (parseFloat(unitPrice) <= 0 )
	{
		OrderType = "NFE";
	}
	tbl.rows[position].cells[15].id = originid;
	tbl.rows[position].cells[15].lastChild.nodeValue  = OrderType;
	
	var price = 0;
	var value = 0;
	
	//commented for orit calculation 2010-08-26 -----------------------------------
	/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		value = price * qty;
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) *  parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		value = price * qty;		
	}*/
//end------------------------------------------------

	//start orit calucation -----------------------------------------
	
	// value = RoundNumbers(parseInt(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	value = calculateCostValue(totalQty,unitPrice,freight);
	
	var  totOrderQty = parseFloat(document.getElementById('txtorderqty').value*exQty/100) + parseFloat(document.getElementById('txtorderqty').value);
			price = RoundNumbers(calCostPCwithExcess(qty,value),4);
	//end -----------------------------------------------------------
	
	//var price = qty * parseFloat(conPc) *  parseFloat(unitPrice);
	tbl.rows[position].cells[13].lastChild.nodeValue  = price;//RoundNumbers(price,4);
	
	//var value = parseFloat(conPc) *  parseFloat(unitPrice);

	tbl.rows[position].cells[14].lastChild.nodeValue =  value;//RoundNumbers(value,4);
					
	var opt = tbl.rows[position].cells[12].childNodes[1];
	if (opt == undefined)
		opt = tbl.rows[position].cells[12].childNodes[0];
	
	//alert(opt);
	
	opt.value = purchaseType;
	if (purchaseType == "NONE")
	{
		tbl.rows[position].className="backcolorWhite";
	}
	else
	{
		tbl.rows[position].className="bcgcolor-tblrow";
	}
	
	if (purchaseType == "NONE")
	{
		tbl.rows[position].cells[2].innerHTML = "<div align=\"center\"><img src=\"images/matratio.png\" class=\"mouseover\"  onclick=\"ShowMaterialRatiowindow(this);\" /></div>"; 
	}
	else if(purchaseType == "COLOR" || purchaseType == "BOTH" )
	{
		tbl.rows[position].cells[2].innerHTML = "<div align=\"center\"><img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" style=\"visibility:hidden\"></div>";
	}
	else
	{
		tbl.rows[position].cells[2].innerHTML = "<div align=\"center\"><img src=\"images/matratio.png\" class=\"mouseover\" style=\"visibility:hidden;\" onclick=\"ShowMaterialRatiowindow(this);\" /></div>"; 
	}
	//tbl.rows[position].cells[12].lastChild.nodeValue =  purchaseType;
	
	tbl.rows[position].cells[16].lastChild.nodeValue  =  placement;
	
	tbl.rows[position].cells[17].id = originid;
	tbl.rows[position].cells[17].lastChild.nodeValue  =  originName;
	
	//var currentItemCode = tbl.rows[position].cells[5].id;
	var newItemCode = itemCode;
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	
	var orderType = "FOB";
	if (parseFloat(unitPrice) <= 0 )
	{
		orderType = "NFE";
	}
	
	var ratioType = 0;
	//var value = (parseFloat(conPc) + parseFloat(conPc * wastage / 100) ) *  parseFloat(unitPrice + freight);
	//var reqQty = qty *  parseFloat(conPc);
	
	//var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice),4);
	var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice + freight),4);
	
	UpdateItem(styleNo,currentItemCode,newItemCode,unitType,unitPrice,conPc,wastage,purchaseType,orderType,placement,ratioType,ReqQty,totalQty,value,price,freight,originid)
			
}

function getTotalMaterialCost()
{
	var totalMaterialCost = 0 ;
	
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		//var value = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		var avgprice = parseFloat(tbl.rows[loop].cells[19].lastChild.nodeValue);
		var baseunitPrice = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var conPc = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue);
		var freight = parseFloat(tbl.rows[loop].cells[11].lastChild.nodeValue);
		var selection = tbl.rows[loop].cells[4].id;
		var variation = 0;
		if (avgprice != 0)
		var variation = baseunitPrice - parseFloat(avgprice);
		
		var unitPrice = baseunitPrice - parseFloat(variation);
		var price = 0;

		/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		}
		else
		{
			price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
		}
		
		totalMaterialCost = parseFloat(totalMaterialCost) + parseFloat(price);*/
		
		
		//orit costPC calculation
		 price = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);	
				totalMaterialCost +=  price;
				
		//------end-------------------
	}
	return totalMaterialCost;
}

function getMaterialFinance()
{
	var totalfinancecost = 0 ;
	var Qty = parseInt(document.getElementById('txtorderqty').value);
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		//var value = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		var avgprice = parseFloat(tbl.rows[loop].cells[19].lastChild.nodeValue);
		var baseunitPrice = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var conPc = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue);
		var freight = parseFloat(tbl.rows[loop].cells[11].lastChild.nodeValue);
		var selection = tbl.rows[loop].cells[4].id;
		var unitPrice = baseunitPrice - parseFloat(isNaN(avgprice / conPc) ? 0 : (avgprice / conPc));
		//var unitPrice = baseunitPrice - parseFloat(avgprice / conPc) ;
		var	originName = tbl.rows[loop].cells[17].lastChild.nodeValue  ;
		//2010-10-26-----------------
		var originType = tbl.rows[loop].cells[18].id;
		//2010-10-26---------------------------------
		var price = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		
		if(originType == 0 || originType == '0')
				totalfinancecost += parseFloat(price);
				
		/*if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		}
		else
		{
			price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
		}*/
		
		//2010-11-22 -------------------------------------------------
		/*var totalQty = 0;
		var exQty = parseInt(document.getElementById('txtexcessqty').value);
		var ReqQty = RoundNumbers(parseFloat(document.getElementById('txtorderqty').value) * conPc,4);
			
		if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			totalQty = ReqQty  ;
		}
		else
		{
			totalQty =parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
		}
		
		
		var value = RoundNumbers(parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight)),4);
		var totOrderQty = parseFloat(document.getElementById('txtorderqty').value*exQty/100) + parseFloat(document.getElementById('txtorderqty').value);
				price = RoundNumbers(calCostPCwithExcess(totOrderQty,value),4);*/
		//2010-11-22 -------------------------------------------------
		
		
				//2010-10-26 calculate finace according to itempurchase type
		/*if (originName.charAt(originName.length-1) == "F" ||originName.charAt(originName.length-1)== "f" )
			totalfinancecost += parseFloat(price);	*/	
			
			
				
				//2010-10-26------------------------------------
	}
	
	var financeValue = RoundNumbers((totalfinancecost * fiancePctng /100).toFixed(4),4);
	//alert(financeValue);
	return financeValue;
}

function calculateCMValue()
{
	var matCost = getTotalMaterialCost();
	var finance = getMaterialFinance();
	
	//var cm = fob - matCost -finance - parseFloat(escCharge) + upcharge;
	var profit = parseFloat(fob) - parseFloat(matCost) -parseFloat(finance) - parseFloat(escCharge) - parseFloat(cmvInPreoder);
	var cmNow = parseFloat(cmvInPreoder) + profit;
	document.getElementById('cmvnow').value = RoundNumbers(cmNow,4);
}

function SaveItem(styleNo,itemCode,unitType,unitPrice,conPc,wastage,purchaseType,orderType,placement,ratioType,reqQty,totalQty,totalValue,costPC,freight,originid)
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleItemSaving;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=SaveItems&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode + '&unitType=' + URLEncode(unitType) + '&unitPrice=' + unitPrice + '&conPc=' + conPc + '&wastage=' + wastage + '&purchaseType=' + purchaseType + '&orderType=' + orderType + '&placement=' + URLEncode(placement) + '&ratioType=' + ratioType + '&reqQty=' + reqQty + '&totalQty=' + totalQty + '&totalValue=' + totalValue + '&costPC=' + costPC + '&freight=' + freight + '&originid=' + originid  , true);
    xmlHttp.send(null);  
}

function HandleItemSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");		
			if (XMLResult[0].childNodes[0].nodeValue == "False")
			{
				alert("Some Error occure while specification saving process. \nPlease refresh the page and try again.");				
			}
		}
		
	}
}

function RemoveItem(obj)
{
	
	/* ===========================================================================
		Add On - 01/20/2016
		Add By - Nalin Jayakody
		Add For - Check if PO raise for selected item. This is try to avoid change item in the BOM 
	              after raise PO and user while working on several tabs on the browser.          
	   ===========================================================================
	*/
	var styleId = $("#cboSR").val();
	var itemcode = obj.id;
	var urlBOM  = 'bomMiddletire.php?RequestType=IsPORaised&ItemCode='+itemcode+'&styleCode='+styleId;
	var htmlObj = $.ajax({url:urlBOM, async:false});
	
	
	var XMLPOExit = htmlObj.responseXML.getElementsByTagName("IsPOExist");

	var IsPOExist = parseInt(XMLPOExit[0].childNodes[0].nodeValue);
	if(IsPOExist == 1){
		alert("! You cannot remove selected item, because purchase order already raised ");return;
		
	}
	/* =========================================================================== */
	
	if(confirm('Are you sure you want to delete this item?'))
	{
		var ItemCode = obj.id;
		var styleNo = document.getElementById('lblStyleNo').innerHTML;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleItemDeletion;
		xmlHttp.obj = obj;
		xmlHttp.open("GET", 'bomMiddletire.php?RequestType=DeleteSpecification&styleNo=' + URLEncode(styleNo) + '&ItemID=' +  ItemCode, true);
		xmlHttp.send(null); 
		
	}
}

function HandleItemDeletion()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");		
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var obj = xmlHttp.obj;
				var td = obj.parentNode;
				var tro = td.parentNode;
				tro.parentNode.removeChild(tro);
				calculateCMValue();
			}
			else
			{
				alert(XMLResult[0].childNodes[0].nodeValue);	
			}
		}
	}
}

function SaveVariations(StyleNo,itemid)
{
	var tbl = document.getElementById('tblVariations');

    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var conpc = rw.cells[1].lastChild.value;
		var unitprice = rw.cells[2].lastChild.value;
		var wastage = rw.cells[3].lastChild.value;
		var qty = rw.cells[4].lastChild.value;
		var color = rw.cells[5].lastChild.value;
		var size = rw.cells[6].lastChild.value;
		createXMLHttpRequest();
		xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveVariations&ItemCode=' + itemid + '&StyleNo=' + URLEncode(StyleNo) + '&conpc=' + conpc + '&unitprice=' + unitprice + '&wastage=' + wastage + '&qty=' + qty + '&color=' + URLEncode(color) + '&IncID=' + loop + '&size=' + URLEncode(size) , true);
		xmlHttp.send(null); 
	}		
	
}

function UpdateItem(styleNo,currentitemcode,newitemCode,unitType,unitPrice,conPc,wastage,purchaseType,orderType,placement,ratioType,reqQty,totalQty,totalValue,costPC,freight,originid)
{
	createXMLHttpRequest();
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdateItems&styleNo=' + URLEncode(styleNo) + '&currentitemcode=' + currentitemcode + '&itemCode=' + newitemCode + '&unitType=' + URLEncode(unitType) + '&unitPrice=' + unitPrice + '&conPc=' + conPc + '&wastage=' + wastage + '&purchaseType=' + purchaseType + '&orderType=' + orderType + '&placement=' + URLEncode(placement) + '&ratioType=' + ratioType + '&reqQty=' + reqQty + '&totalQty=' + totalQty + '&totalValue=' + totalValue + '&costPC=' + costPC + '&freight=' + freight + '&originid=' + originid  , true);
    xmlHttp.send(null); 
	//closeWindow(); //call close window bcoz variation are nt saved for orit
	SettingUpVariations(styleNo,currentitemcode);
}

function SettingUpVariations(StyleNo,itemid)
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleSettingUpVariations;
	altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=DeleteVariations&styleNo=' + URLEncode(StyleNo) + '&ItemID=' +  itemid, true);
	altxmlHttp.send(null); 
}

function HandleSettingUpVariations()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			var styleNo = document.getElementById('lblStyleNo').innerHTML;
			var itemCode = document.getElementById('cboItems').value;
			SaveVariations(styleNo,itemCode);
			closeWindow();
		}
		
	}
}

function updatePurchaseType(obj)
{
	if (!hasStyleRatio)
	{
		alert("Sorry! Can't change the 'Purchase Type'. \nStyle ratio is not enterd to this style. You should set style ratio first.");
		document.getElementById('cboPos').value = "NONE"
		return ;
	}
	
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var itemid = obj.parentNode.id;
	var purchaseType = obj.value;
        
        //alert(itemid);
	
	if (obj.value == "NONE")
	{
		var purchasedQty = obj.parentNode.parentNode.cells[18].childNodes[0].nodeValue;
		obj.parentNode.parentNode.cells[2].childNodes[0].innerHTML = "<img src=\"images/matratio.png\" class=\"mouseover\" onclick=\"ShowMaterialRatiowindow(this," + purchasedQty + ");\"/>";
		obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "visible";
		obj.parentNode.parentNode.className="backcolorWhite";
	}
	else if (obj.value == "COLOR" || purchaseType == "BOTH")
	{
		//obj.parentNode.parentNode.cells[2].childNodes[0].innerHTML = "<img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" >";
		//obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "hidden";
		obj.parentNode.parentNode.className="bcgcolor-tblrow";
	}
	else
	{
		//obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "hidden";
		obj.parentNode.parentNode.className="bcgcolor-tblrow";
	}

	createAltXMLHttpRequest();
	altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdatePurchaseType&styleNo=' + URLEncode(StyleNo) + '&ItemID=' +  itemid + '&purchaseType=' + obj.value, true);
	altxmlHttp.send(null); 
}

function ShowStyleRatiowindow()
{
	matRatioRequest= false;
	var orderno = document.getElementById('cboOrderNo').value;
	//alert(orderno);
	if(orderno == 'Select One' || orderno== '')
	{
		alert('Please select the \'Order No\'');
		document.getElementById('cboOrderNo').focus();
		return false;
		}
	if (isPurchased && isSuperStyleRatioEditot == false)
	{
		alert("Sorry! You can't proceed with style ratio change.\nSome materials already purchased.");	
		return ;
	}
	drawPopupArea(702,670,'frmRatio');
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var StyleName = document.getElementById('txtStyleNo').value;
	var SCNO = document.getElementById('txtSCNo').value;
	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var totqty = parseInt(orderQty,10) + (parseInt(orderQty,10) * parseInt(ExQty,10) / 100);
	var HTMLText = "<table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmRatio'),event);\">" +
						"<td width=\"25%\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style Ratio - [ Style : " + StyleName + " ]  &nbsp;&nbsp;    [ SCNO : " + SCNO + " ]</td>" +
						"</tr>" +
					"</table></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td class=\"bcgl1\"><table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"48\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"2%\">&nbsp;</td>" +
							  "<td width=\"15%\" class=\"normalfnt\">Buyer PO No.</td>" +
							  "<td width=\"22%\" class=\"normalfnt\"><select name=\"cbopono\" class=\"txtbox\" id=\"cbopono\" onChange=\"changePO();\" style=\"width:135px\">" +
								"</select>              </td>" +
							  "<td width=\"24%\" colspan=\"0\" class=\"normalfnt\">Total Order Qty</td>" +
							  "<td width=\"15%\" class=\"normalfnt\"><input name=\"txttotalorder\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txttotalorder\" value=\"" + orderQty + "\" /></td>" +
							  "<td width=\"12%\" colspan=\"0\" class=\"normalfnt\">&nbsp;Exess&nbsp;%</td>" +
							  "<td width=\"10%\" colspan=\"0\" class=\"normalfnt\"><input name=\"txtexces\" type=\"text\" disabled=\"disabled\" class=\"txtbox\" id=\"txtexces\" size=\"15\" value=\"" + ExQty + "\"  /></td>" +
							"</tr>" +
							"<tr>" +
							  "<td>&nbsp;</td>" +
							  "<td class=\"normalfnt\">Buyer PO Qty</td>" +
							  "<td class=\"normalfnt\"><input name=\"txtbuyerpo\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txtbuyerpo\" size=\"20\" value=\"" + orderQty + "\" /></td>" +
							  "<td width=\"12%\" class=\"normalfnt\">&nbsp;</td>" +
								"<td width=\"5%\" class=\"normalfnt\"><input name=\"matDetail\" type=\"text\" class=\"txtbox\" id=\"matDetail\" value=\"0\" style=\"text-align:right;\"/></td>" +
							  "<td width=\"15%\" class=\"normalfnt\">&nbsp;</td>" +
							  //Start 20-08-2010 Hide for orit
								"<td width=\"12%\" class=\"normalfnt\" style=\"visibility:hidden\"></td>" +
								"<td width=\"21%\" class=\"normalfnt\" style=\"visibility:hidden\">&nbsp;</td>" +
							 
							 //End 20-08-2010 Hide for orit
							  
							  "<td>&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratios</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divQtyRatio\" style=\"overflow:scroll; height:110px; width:700px;\">" +
						"</div></td>" +
					 "</tr>" +
					 "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td id=\"exratioHeader\" height=\"23\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratio for Qty " + totqty + " (Order Qty + Excess Qty)</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divExQtyRatio\" style=\"overflow:scroll; height:110px; width:700px;\">" +
						"</div></td>" +
					  "</tr>" +
					  
					  ///////////////////////Size wise FOB //////////////////////////////////
					   "<tr>" +
						"<td height=\"3\"></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td id=\"exratioHeader\" height=\"23\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Multiple FOB (Color & Size Wise)</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divSizeWiseFOB\" style=\"overflow:scroll; height:110px; width:700px;\">" +
						"</div></td>" +
					  "</tr>" +
					  
					    //////////////////////Pack qty/////////////////////////////////
					   "<tr>" +
						"<td height=\"3\"></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td id=\"exratioHeader\" height=\"23\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Pack Qty (Color & Size Wise)</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divPackQty\" style=\"overflow:scroll; height:110px; width:700px;\">" +
						"</div></td>" +
					  "</tr>" +
					  

					  
					  "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"31\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"24%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							  "<td width=\"20%\" bgcolor=\"#D6E7F5\"><img src=\"images/new.png\" alt=\"new\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"showColorSizeSelector('s');\" /></td>" +
							  "<td width=\"18%\" bgcolor=\"#D6E7F5\"><img id=\"imgSave\" src=\"images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\"SaveStyleRatio(); \" /></td>" +	
							  "<td width=\"18%\" bgcolor=\"#D6E7F5\"><img id=\"imgUpload\" src=\"images/upload.jpg\" alt=\"upload\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\" popupupload("+StyleNo+","+orderQty+") \" /></td>" + 						  
							  "<td width=\"14%\" bgcolor=\"#D6E7F5\"><img src=\"images/close.png\" alt=\"close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closes();\" /></td>" +
							  "<td width=\"24%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table></td>" +
				  "</tr>" +
				"</table>";	
				//<td width=\"18%\" bgcolor=\"#D6E7F5\"><img id=\"imgSave\" src=\"images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\" SaveStyleRatio1(); SaveStyleRatio(); \" /></td>"
	var frame = document.createElement("div");
    frame.id = "ratioselectwindow";
	document.getElementById('frmRatio').innerHTML=HTMLText;
	LoadBuyerBONos();
	
				
}

function LoadBuyerBONos()
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBuyerPOs;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerPOListForStyle&StyleNO=' + URLEncode(StyleNo), true);
    xmlHttp.send(null); 
}

function HandleBuyerPOs()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var orderQty = document.getElementById('txtorderqty').value;
			var opt = document.createElement("option");
			opt.text = "#Main Ratio#";
			opt.value = "#Main Ratio#";
			document.getElementById("cbopono").options.add(opt);
			
			
			
			 var XMLPO = xmlHttp.responseXML.getElementsByTagName("PONO");
			 var XMLQTY = xmlHttp.responseXML.getElementsByTagName("QTY");
			 var XMLBuyerPoName = xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
                         
			 
			 for ( var loop = 0; loop < XMLPO.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;
				opt.value = XMLPO[loop].childNodes[0].nodeValue;
				document.getElementById("cbopono").options.add(opt);
			 }	
			 if (document.getElementById("divExQtyRatio") != null)
			 {
			 	LoadStyleRatio();
			 }
			 else
			 {
				changePOonMaterial(loadPercentage,loadItem); 
			 }
		}
	}
}

function changePO()
{
	/*var poqty = parseInt(document.getElementById("cbopono").value,10);
	document.getElementById('txtbuyerpo').value = poqty;
	var exqtypc = parseInt(document.getElementById("txtexces").value,10); 
	var exqtyratio = poqty + (poqty * exqtypc / 100);
	document.getElementById('exratioHeader').innerHTML = "Ratio for Qty " + parseInt(exqtyratio,10) + " (Order Qty + Excess Qty)";*/
	LoadStyleRatio();
}

function showColorSizeSelector(ratiowindow)
{
	drawPopupAreaLayer(500,475,'frmSelector',3);
	var HTMLText = "<table width=\"500\" border=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmSelector'),event);\">" +
						"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Select Colors and Sizes</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><table width=\"100%\" border=\"0\">" +
						  "<tr>" +
							"<td width=\"3%\">&nbsp;</td>" +
							"<td width=\"18%\" class=\"normalfnt\">Buyer</td>" +
							"<td width=\"32%\"><select name=\"cboBuyer\" class=\"txtbox\" id=\"cboBuyer\" style=\"width:140px\" onChange=\"ChangeBuyer();\">" +
							"</select>        </td>" +
							"<td width=\"14%\" class=\"normalfnt\">Division</td>" +
							"<td width=\"33%\"><select name=\"cboDivision\" class=\"txtbox\" id=\"cboDivision\" style=\"width:140px\" onChange=\"ChangeDivision();\">" +
									"</select></td>" +
						 "</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"367\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
						  "<tr>" +
							"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Colors</td>" +
							"</tr>" +
						  "<tr>" +
							"<td width=\"46%\" bgcolor=\"#D6E7F5\" class=\"normalfntMid\">Colors</td>" +
							"<td width=\"8%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"<td width=\"46%\" bgcolor=\"#D6E7F5\" class=\"normalfntMid\">Selected Colors</td>" +
						  "</tr>" +
						  "<tr>" +
							"<td height=\"141\" valign=\"top\"><select onkeypress=\"keyMoveColorRight(event);\" name=\"cbocolors\" size=\"10\" class=\"txtbox\" id=\"cbocolors\" style=\"width:225px\" ondblclick=\"MoveColorRight();\">" +
							"</select></td>" +
							"<td><table width=\"100%\" border=\"0\">" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" id=\"imgMoveRight\" onClick=\"MoveAllColorsRight();\" /></div></td>" +
							  "</tr>" +
							"</table></td>" +
							"<td valign=\"top\"><select name=\"cboselectedcolors\" size=\"8\" class=\"txtbox\" id=\"cboselectedcolors\" style=\"width:225px;\" ondblclick=\"MoveColorLeft();\">" +
							"</select>" +
							"<table><tr><td class=\"normalfntMid\">New:</td><td><input  class=\"txtbox\" type=\"text\" onkeypress=\"return string_constrain(event);\" size=\"18\" maxlength=\"70\" id=\"txtnewcolor\" style=\"text-transform:uppercase\" onkeyup=\"grabColorEnterKey(event);\"></td><td><img src=\"images/addmark.png\" class=\"mouseover\" onClick=\"AddNewColor();\" width=\"80%\" height=\"80%\"></td></tr></table>"+					
							"</td>" +
						  "</tr>" +
						 "<tr>" +
							"<td height=\"21\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Sizes</td>" +
							"</tr>" +
						  "<tr>" +
							"<td bgcolor=\"#D6E7F5\" class=\"normalfntMid\">Sizes</td>" +
							"<td bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"<td bgcolor=\"#D6E7F5\" class=\"normalfntMid\">Selected Sizes</td>" +
						  "</tr>" +
						  "<tr>" +
							"<td valign=\"top\"><select onkeypress=\"keyMoveSizeRight(event);\" name=\"cbosizes\" size=\"10\" class=\"txtbox\" id=\"cbosizes\" style=\"width:225px\" ondblclick=\"MoveSizeRight();\">" +
									"</select></td>" +
							"<td><table width=\"100%\" border=\"0\">" +
							  "<tr>" +
								"<td><div align=\"center\"><img onkeypress=\"keyMoveSizeRight(event)\"  id=\"imgOneMoveLeft\" src=\"images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fw.png\" id=\"imgOneMoveRight\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeLeft();\" /></div></td>" +
							  "</tr>" + 
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/ff.png\" id=\"imgDownMoveLeft\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllSizesLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" id=\"imgDownMoveRight\"  onClick=\"MoveAllSizesRight();\" /></div></td>" +
							  "</tr>" +
							   "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								
							  "</tr>" +
							  "<tr>" +
								
							  "</tr>" +
							"</table></td>" +
							"<td valign=\"top\" align=\"left\" ><select name=\"cboselectedsizes\" size=\"8\" class=\"txtbox\" id=\"cboselectedsizes\" style=\"width:200px;\"  ondblclick=\"MoveSizeLeft();\">" +
									"</select>"+
							"<select name=\"cbosizesnumbsrial\" size=\"8\" class=\"txtbox\" id=\"cbosizesnumbsrial\" style=\"width:15px; visibility:hidden; \">" +
									"</select>"+
									"<table><tr><td class=\"normalfntMid\">New:</td><td><input  class=\"txtbox\" type=\"text\" size=\"18\"  onkeypress=\"return string_constrain(event);\" onkeyup=\"grabSizeEnterKey(event);\" maxlength=\"70\" id=\"txtnewSize\" style=\"text-transform:uppercase\"></td><td><img src=\"images/addmark.png\" class=\"mouseover\" onClick=\"AddNewSize(); \"  width=\"80%\" height=\"80%\"></td></tr></table>"+
									"<table style=\"width:200px;\" ><tr><td><div align=\"center\" id=\"imgUpMove\"><img src=\"images/uw.png\"  alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"moveO('cboselectedsizes','up');\" value\"UP\" /></div></td>" +
									"<td><div align=\"center\" id=\"imgDownMove\"><img src=\"images/dw.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\"  value\"DOWN\" onClick=\"moveO('cboselectedsizes','down');\" /></div></td>" +
									"</tr></table>"+					
							"</td>" +
						  "</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">" +
						  "<tr>" +
							"<td width=\"25%\">&nbsp;</td>" +
							"<td width=\"29%\"><img src=\"images/ok.png\" alt=\"OK\" width=\"86\" height=\"24\" class=\"mouseover\" onClick=\"AddSelection();\" /></td>" +
							"<td width=\"21%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeLayer();\" /></td>" +
							"<td width=\"25%\">&nbsp;</td>" +
						 "</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table>"; 
					
	var frame = document.createElement("div");
    frame.id = "colorsizeselectwindow";
	document.getElementById('frmSelector').innerHTML=HTMLText;	
	
	LoadBuyers();
	LoadAvailableColors();
	LoadAvailableSizes();
	if(ratiowindow == 's'){
		loadVariationColors();
		setDataToArray();
	}
//Start 31-03-2010 - bookmark	
	if(ratiowindow == 'm')
		setDataToArray();
//End 31-03-2010 - bookmark
}
function moveO(name,w){
var sel=document.getElementsByName(name)[0];
//alert(sel);
var opt=sel.options[sel.selectedIndex];
if(w=='up'){
var prev=opt.previousSibling;
	while(prev&&prev.nodeType!=1){
	prev=prev.previousSibling;
	}
prev?sel.insertBefore(opt,prev):sel.appendChild(opt)
}
else{
var next=opt.nextSibling;
	while(next&&next.nodeType!=1){
	next=next.nextSibling;
	}
	if(!next){sel.insertBefore(opt,sel.options[0])}
	else{
	var nextnext=next.nextSibling;
		while(next&&next.nodeType!=1){
		next=next.nextSibling;
		}
	nextnext?sel.insertBefore(opt,nextnext):sel.appendChild(opt);
	}
}
}
//Start 31-03-2010 - bookmark (Set all data to the arrays)
function setDataToArray()
{
	var tbl = document.getElementById('tblQtyRatio');
	var tblYY = document.getElementById('tblYY');
	var rowCount = tbl.rows.length;
       
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        var matDetails        =   strBomDetail[0];
        
         if(matDetails!='FAB'){
             var rowCountYY = 0;
             arrayYY ='';
         }
         else{
             var rowCountYY = tblYY.rows.length;
             arrayYY = new Array(rowCountYY-1);
         }
                    
       
        
        for(var i=0;i<rowCountYY-1;i++)
		{
          arrayWastege[i] = document.getElementById('wast'+[i]+'').value; 
          arrayMoq[i]     = document.getElementById('moq'+[i]+'').value;
        }
        
	Materials = new Array(rowCount-1);
	arrayRatioQty = new Array(rowCount-1);
	for(var r=0;r<rowCount-1;r++)
	{
		var cellCount = tbl.rows[r].cells.length;

	 if(matDetails!='FAB'){
		  var cellCountYY = 0;
		  arrayYY[r]='';
		}
		else{
			var cellCountYY = tblYY.rows[r].cells.length;
			arrayYY[r]=new Array(cellCountYY-1);
		}

		Materials[r] = new Array(cellCount-1);
		arrayRatioQty[r] = new Array(cellCount-1);
		MatColor[r] = tbl.rows[r].cells[0].lastChild.nodeValue;
		arrayColorIsPo[r] = tbl.rows[r].cells[0].id;
		for(var c=0;c<cellCount-1;c++)
		{
			
			if(r==0)
			{
				if(c==0)
				{
					MatSize[c] 			= tbl.rows[0].cells[c].lastChild.nodeValue;
					arraySizeIsPo[c] 	= tbl.rows[0].cells[c].lastChild.nodeValue;
					Materials[r][c] 	= tbl.rows[0].cells[c].lastChild.nodeValue;
					arrayRatioQty[r][c] = tbl.rows[0].cells[c].lastChild.nodeValue;					
     if(matDetails=='FAB'){
											arrayYY[r][c] = tblYY.rows[0].cells[c].lastChild.nodeValue;
										}
										
							}
				else
				{
					MatSize[c] 			= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;					
					arraySizeIsPo[c] 	= tbl.rows[0].cells[c].id;						 
					Materials[r][c]		= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;
					arrayRatioQty[r][c]	= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;
					   if(matDetails=='FAB'){
						   arrayYY[r][c]	= tblYY.rows[0].cells[c].childNodes[0].lastChild.nodeValue;
						}

						
				}
			}
			else
			{
				if(c==0)
				{
					Materials[r][c] 	= tbl.rows[r].cells[c].lastChild.nodeValue;
					arrayRatioQty[r][c] = tbl.rows[r].cells[c].lastChild.nodeValue;					
						if(matDetails=='FAB'){
						   arrayYY[r][c] = tblYY.rows[r].cells[c].lastChild.nodeValue;
						}
                                            
       
	   
				}
				else
				{
					Materials[r][c]		= parseInt(tbl.rows[r].cells[c].id);
					arrayRatioQty[r][c]	= parseInt(tbl.rows[r].cells[c].childNodes[0].childNodes[0].value);
					 if(matDetails=='FAB'){
						 arrayYY[r][c]           = tblYY.rows[r].cells[c].childNodes[0].childNodes[0].value;
						}

						
				}
			}
		}
	}	
}
//Start 31-03-2010 - bookmark (Set all data to the arrays)

function loadVariationColors()
{

	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	
	createNewXMLHttpRequest(10);
	xmlHttpreq[10].onreadystatechange = HandleVariationColors;
	xmlHttpreq[10].open("GET", 'bomMiddletire.php?RequestType=GetVariationColors&styleID=' + URLEncode(StyleNo) , true);
	xmlHttpreq[10].send(null);
}

function HandleVariationColors()
{
    if(xmlHttpreq[10].readyState == 4) 
    {
        if(xmlHttpreq[10].status == 200) 
        {  			
        
			 var XMLColor = xmlHttpreq[10].responseXML.getElementsByTagName("Color");
			 if (XMLColor.length > 0)
			 {
			 	document.getElementById("cboselectedcolors").options.length = 0;
			 	document.getElementById("cboselectedcolors").disabled = true;
				document.getElementById("cbocolors").disabled = true;
				document.getElementById("txtnewcolor").disabled = true;
			 }
			 for ( var loop = 0; loop < XMLColor.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLColor[loop].childNodes[0].nodeValue;
				opt.value = XMLColor[loop].childNodes[0].nodeValue;
				document.getElementById("cboselectedcolors").options.add(opt);
			 }			
			 
		}
	}
}

function LoadBuyers()
{
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBuyers;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerList', true);
    xmlHttp.send(null); 
}

function HandleBuyers()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			
			var opt = document.createElement("option");
			opt.text = currentBuyerName;
			opt.value = currentBuyerID;
			document.getElementById("cboBuyer").options.add(opt);
			document.getElementById("cboBuyer").value =currentBuyerID;
			
			 var XMLID = xmlHttp.responseXML.getElementsByTagName("BuyerID");
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("BuyerName");
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboBuyer").options.add(opt);
			 }			
			 ChangeBuyer();
		}
	}
}

function ShowBuyerDivisions()
{    
	RemoveCurrentDivisions();
	var custID = document.getElementById('cboBuyer').value;
    createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleDivisions;
    altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetDivision&CustID=' + custID, true);
    altxmlHttp.send(null);     
}

function HandleDivisions()
{
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboDivision").options.add(opt);
			document.getElementById("cboDivision").value = "Select One";
			 var XMLDivisionID = altxmlHttp.responseXML.getElementsByTagName("DivisionID");
			 var XMLDivisionName = altxmlHttp.responseXML.getElementsByTagName("Division");
			 for ( var loop = 0; loop < XMLDivisionID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
				opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
				document.getElementById("cboDivision").options.add(opt);
			 }
			
		}
	}
}

function RemoveCurrentDivisions()
{
	var index = document.getElementById("cboDivision").options.length;
	while(document.getElementById("cboDivision").options.length > 0) 
	{
		index --;
		document.getElementById("cboDivision").options[index] = null;
	}
}

function ShowBuyerColors()
{
	var custID = document.getElementById('cboBuyer').value;
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleColors;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerColors&BuyerID=' + custID, true);
    thirdxmlHttp.send(null);  
}

function HandleColors()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  			
			 var XMLColor = thirdxmlHttp.responseXML.getElementsByTagName("Color");
			 for ( var loop = 0; loop < XMLColor.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLColor[loop].childNodes[0].nodeValue;
				opt.value = XMLColor[loop].childNodes[0].nodeValue;
				
				
				var tbl = document.getElementById('tblQtyRatio');
				var xhave = false;

				for ( var loop1 = 1 ;loop1 < tbl.rows.length -1 ; loop1 ++ )
				{
					var rw = tbl.rows[loop1];
					var colorName = rw.cells[0].lastChild.nodeValue;
					if(colorName==opt.text)
						xhave=true;
				}

				if(! xhave)
					document.getElementById("cbocolors").options.add(opt);
				//bookmark1
				
				
				
			 }			
		}
	}
}

function RemoveCurrentColors()
{
	var index = document.getElementById("cbocolors").options.length;
	while(document.getElementById("cbocolors").options.length > 0) 
	{
		index --;
		document.getElementById("cbocolors").options[index] = null;
	}
}

function ShowBuyerSizes()
{
	var custID = document.getElementById('cboBuyer').value;
	createtFourthXMLHttpRequest();
    fourthxmlHttp.onreadystatechange = HandleSizes;
    fourthxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerSizes&BuyerID=' + custID, true);
    fourthxmlHttp.send(null);  
}

function HandleSizes()
{
    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  			
			 var XMLSizes = fourthxmlHttp.responseXML.getElementsByTagName("Size");
			 for ( var loop = 0; loop < XMLSizes.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLSizes[loop].childNodes[0].nodeValue;
				opt.value = XMLSizes[loop].childNodes[0].nodeValue;
				
				//alert(XMLSizes.length);
				
					var tbl = document.getElementById('tblQtyRatio');
					if (tbl != null) 
					{
							var rw = tbl.rows[0];
							var xhave = false;
							for ( var loop1 = 1 ;loop1 < rw.cells.length  ; loop1 ++ )
							{
								
								var size = rw.cells[loop1].lastChild.lastChild.nodeValue;
								
								
								if(trim(opt.text)==trim(size))
								{
									xhave= true;
								}
								
									
								
							}
							
							if(! xhave)
							{
								document.getElementById("cbosizes").options.add(opt);
							}
							
						
					}
				
				
			
				
				
				
			 }			
		}
	}
}

function RemoveCurrentSizes()
{
	var index = document.getElementById("cbosizes").options.length;
	while(document.getElementById("cbosizes").options.length > 0) 
	{
		index --;
		document.getElementById("cbosizes").options[index] = null;
	}
}

function ChangeBuyer()
{
	if (document.getElementById("cbosizes")!= null)
	RemoveCurrentSizes();
	RemoveCurrentColors();
	ShowBuyerDivisions();
	ShowBuyerColors();
	if (document.getElementById("cbosizes")!= null)
	ShowBuyerSizes();
}

function ShowBuyerDivisionColors()
{
	var custID = document.getElementById('cboBuyer').value;
	var divisionID = document.getElementById("cboDivision").value;
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleDivisionColors;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerDivisionColors&BuyerID=' + custID + '&DivisionID=' + divisionID, true);
    thirdxmlHttp.send(null);  
}

function HandleDivisionColors()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  			
			 var XMLColor = thirdxmlHttp.responseXML.getElementsByTagName("Color");
			 for ( var loop = 0; loop < XMLColor.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLColor[loop].childNodes[0].nodeValue;
				opt.value = XMLColor[loop].childNodes[0].nodeValue;
				document.getElementById("cbocolors").options.add(opt);
			 }			
		}
	}
}

function ShowBuyerDivisionSizes()
{
	var custID = document.getElementById('cboBuyer').value;
	var divisionID = document.getElementById("cboDivision").value;
	createtFourthXMLHttpRequest();
    fourthxmlHttp.onreadystatechange = HandleDivisionSizes;
    fourthxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetBuyerDivisionSizes&BuyerID=' + custID + '&divisionID=' + divisionID, true);
    fourthxmlHttp.send(null);  
}

function HandleDivisionSizes()
{
    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  			
			 var XMLSizes = fourthxmlHttp.responseXML.getElementsByTagName("Size");
			 for ( var loop = 0; loop < XMLSizes.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLSizes[loop].childNodes[0].nodeValue;
				opt.value = XMLSizes[loop].childNodes[0].nodeValue;
				document.getElementById("cbosizes").options.add(opt);
			 }			
		}
	}
}

function ChangeDivision()
{
	RemoveCurrentSizes();
	RemoveCurrentColors();	
	ShowBuyerDivisionColors();
	ShowBuyerDivisionSizes();
}
function keyMoveColorRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		MoveColorRight();
}
function MoveColorRight()
{
	var serial =document.getElementById("cboselectedsizes").options.length;
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	//var selectedColor1 =Number(serial)+1;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedcolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedcolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveColorLeft()
{
	var serial =document.getElementById("cboselectedsizes").options.length;
	var colors = document.getElementById("cboselectedcolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	//var selectedColor1 =Number(serial)-1;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbocolors"),false))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbocolors").options.add(optColor);
		
	}
	colors.options[colors.selectedIndex] = null;
}

function MoveAllColorsLeft()
{
	if(document.getElementById("cboselectedcolors").disabled)
	{
		alert("This function disabled for this style / buyer PO.");
		return;
	}
	var colors = document.getElementById("cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedcolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedcolors").options.add(optColor);
		}
	}
	RemoveCurrentColors();
}

function MoveAllColorsRight()
{
	if(document.getElementById("cboselectedcolors").disabled)
	{
		alert("This function disabled for this style / buyer PO.");
		return;
	}
	var colors = document.getElementById("cboselectedcolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbocolors").options.add(optColor);
		}
	}
	RemoveSelectedColors();
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toUpperCase() == itemName.toUpperCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function RemoveSelectedColors()
{
	var index = document.getElementById("cboselectedcolors").options.length;
	while(document.getElementById("cboselectedcolors").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedcolors").options[index] = null;
	}
}

function RemoveSelectedSizes()
{
	var index = document.getElementById("cboselectedsizes").options.length;
	while(document.getElementById("cboselectedsizes").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedsizes").options[index] = null;
	}
}
function  keyMoveSizeRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		MoveSizeRight();
}

function MoveSizeRight()
{
	var colors = document.getElementById("cbosizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	//var selectedColor1 = document.getElementById("cboselectedsizes").options.length;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedsizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedsizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
		var count = document.getElementById("cbosizesnumbsrial").options.length;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
	}
}

function MoveSizeLeft()
{
	var colors = document.getElementById("cboselectedsizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbosizes"),false))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbosizes").options.add(optColor);	
		
		//var count = document.getElementById("cbosizesnumbsrial").options.length;
	var elSel = document.getElementById('cbosizesnumbsrial');
  if (elSel.length > 0)
  {
    elSel.remove(elSel.length - 1);
  }
	}
	colors.options[colors.selectedIndex] = null;
}

function MoveAllSizesLeft()
{
	var colors = document.getElementById("cbosizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedsizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedsizes").options.add(optColor);
			if(colors.options.length =="")
			{
			var count = 0;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
		//alert(count);
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
	}
	else
	{
		var count = document.getElementById("cbosizesnumbsrial").options.length;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
		//alert(count);
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
	}
		}
	}
	RemoveCurrentSizes();
}

function MoveAllSizesRight()
{
	var colors = document.getElementById("cboselectedsizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbosizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbosizes").options.add(optColor);
			var i;
			var selectbox = document.getElementById('cbosizesnumbsrial');
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.remove(i);
    }
	//alert(selectbox);
		}
	}
	RemoveSelectedSizes();
}

function isValidColorSizeSelection()
{
	if (document.getElementById("cboselectedcolors").options.length == 0 && document.getElementById("cboselectedsizes").options.length == 0)
	{
		alert ("Please choose your color size ratio.");
		return false;
	}
	return true;
}

function AddSelection()
{
	if (isValidColorSizeSelection())
	{
		var colorlength = document.getElementById("cboselectedcolors").options.length;
		var sizelength = document.getElementById("cboselectedsizes").options.length;
		var sizeserial = document.getElementById("cbosizesnumbsrial").options.length;
		
		var colors = [];
		for(var i = 0; i < document.getElementById("cboselectedcolors").options.length ; i++) 
		{
			colors[i] = document.getElementById("cboselectedcolors").options[i].text;
		}
		
		var sizes = [];
		for(var i = 0; i < document.getElementById("cboselectedsizes").options.length ; i++) 
		{
			sizes[i] = document.getElementById("cboselectedsizes").options[i].text;
		}
		var sizeserial = [];
		for(var i = 0; i < document.getElementById("cbosizesnumbsrial").options.length ; i++) 
		{
			sizeserial[i] = document.getElementById("cbosizesnumbsrial").options[i].value;
			//alert(document.getElementById("cbosizesnumbsrial").options[i].value);
		}
		
		if (colors.length <= 0)
		{
			colors[0] = "N/A";
		}
		
		if (sizes.length <= 0)
		{
			sizes[0] = "N/A";
		}
		
		var tablewidth = 450 + (7 * sizes.length);
			var bomDetail         =   document.getElementById('matDetail').value;
			var strBomDetail      =   bomDetail.split("|");
			var matDetails        =   strBomDetail[0];
			var bomWastage        =   strBomDetail[2];

			
			var buyerPONo = "";
	try
	{
		buyerPONo = document.getElementById("cbopono").value;
	}
	catch(err)
	{
		buyerPONo = "#Main Ratio#"
	}
        
		// Create The table header
		var HTMLText = "";
		HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
		 			"<tr>" +					
	                "<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
		
		var celllength = parseInt(50 / sizes.length);
		
		for (i in sizes)
		{
			var y = MatSize.indexOf(sizes[i]);			/*Start 31-03-2010 bookmark*/	

			HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id=\""+sizeserial[i]+"\"><div align=\"center\">" + sizes[i] + "</div></td>";
		}
		
		HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
	              	"</tr>" ;
		
		// Create Table body
		var poValue=0;
		var ratioQty=0;
		for (x in colors)
		{
			var q = MatColor.indexOf(colors[x]);		/*Start 31-03-2010 bookmark*/
			
			/*HTMLText += "<tr>" +
						"<td id=\""+arrayColorIsPo[q]+"\" class=\"normalfnt\">" + colors[x] + "</td>" ;*/
			HTMLText += "<tr>" +
						"<td id=\""+arrayColorIsPo[q]+"\" class=\"normalfnt\">" + colors[x] + "</td>" ;
									
			for (i in sizes)
			{
//Start 31-03-2010 bookmark (read the array and add data to the table grid)
				var poValue=0;
				var ratioQty=0;
				///////////////// ADD PO VALUE TO GRID CELL ID////////////////////////////////////////////
				try{
					var r 			= MatColor.indexOf(colors[x]);
					var c 			= MatSize.indexOf(sizes[i]);
					var poValue 	= Materials[r][c];
					var ratioQty 	= arrayRatioQty[r][c];
					var yy   		= arrayYY[r][c];
					poValue			= (isNaN(poValue) ? 0:poValue);
					ratioQty		= (isNaN(ratioQty) ? 0:ratioQty);


				}
				catch(err)
				{
					//alery(err);
				}
//End 31-03-2010 bookmark  (read the array and add data to the table grid)
				if(matDetails=='FAB' && buyerPONo!='#Main Ratio#'){	
				    HTMLText += "<td id=\""+poValue+"\"><div align=\"center\">" +
                                    "<input name=\"txtratio\" disabled  type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" disabled class=\"txtbox\" value=\""+ratioQty+"\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return IsNumberWithoutDecimals(this.value,event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
                                    "</div></td>";
                                    }
                                else{
                                    HTMLText += "<td id=\""+poValue+"\"><div align=\"center\">" +
                                    "<input name=\"txtratio\"  type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\"  class=\"txtbox\" value=\""+ratioQty+"\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return IsNumberWithoutDecimals(this.value,event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
                                    "</div></td>";
                                    }
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
                	"</div></td>" +
              		"</tr>";
		}
		
		// Create table footer
		
		HTMLText += "<tr>" +
                    "<td class=\"normalfnt\">Total</td>";
		
		for (i in sizes)
		{
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
                		"</div></td>";
		}
		
		HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
                	"</div></td>" + 
              		"</tr>" ;
		
					
		document.getElementById("divQtyRatio").innerHTML = HTMLText;

              
                //<mig>..................................
                
                
                
        var HTMLTextYY = "";
		HTMLTextYY += "<table width=\"" + tablewidth + "\" id=\"tblYY\" cellpadding=\"0\" cellspacing=\"0\">" +
		 			"<tr>" +					
	                "<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
		
		var celllength = parseInt(50 / sizes.length);
		
		for (i in sizes)
		{
			var y = MatSize.indexOf(sizes[i]);			/*Start 31-03-2010 bookmark*/	

			HTMLTextYY += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id=\""+sizeserial[i]+"\"><div align=\"center\">" + sizes[i] + "</div></td>";
		}
		
		HTMLTextYY += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">Wastage %" +
                	"</div></td>" + 
                        "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">&nbsp</td>" +
                        "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">MOQ/MCQ</td>" +
              		"</tr>" ;
		
		// Create Table body
		var poValue=0;
		var ratioQty=0;
		for (x in colors)
		{
			var q = MatColor.indexOf(colors[x]);		/*Start 31-03-2010 bookmark*/
			
			/*HTMLText += "<tr>" +
						"<td id=\""+arrayColorIsPo[q]+"\" class=\"normalfnt\">" + colors[x] + "</td>" ;*/
			HTMLTextYY += "<tr>" +
						"<td id=\""+arrayColorIsPo[q]+"\" class=\"normalfnt\">" + colors[x] + "</td>" ;
									
			for (i in sizes)
			{
//Start 31-03-2010 bookmark (read the array and add data to the table grid)
				var poValue=0;
				var ratioQty=0;
                                var yyCon   =0;
                                //var wastage=0;
				///////////////// ADD PO VALUE TO GRID CELL ID////////////////////////////////////////////
				try{
					var r 			= MatColor.indexOf(colors[x]);
					var c 			= MatSize.indexOf(sizes[i]);
					var poValue 	= Materials[r][c];
					var ratioQty 	= arrayRatioQty[r][c];
                                        //var wastage 	= arrayWastege[r];
                                        var yyCon   	= arrayYY[r][c];
                                        //arrayWastege
                                        //console.log(wastage);
                                        
					poValue			= (isNaN(poValue) ? 0:poValue);
					ratioQty		= (isNaN(ratioQty) ? 0:ratioQty);
                                        yyCon                   = (isNaN(yyCon) ? 0:yyCon);
                                        //alert("ratioQty5 = "+yy);

				}
				catch(err)
				{
					//alery(err);a
				}
//End 31-03-2010 bookmark  (read the array and add data to the table grid)
				//alert("poValue1="+poValue+" ratioQty="+ratioQty);
                        if(editYY==1){
                         HTMLTextYY += "<td id=\""+poValue+"\"><div align=\"center\">" +
                                "<input name=\"yy\" type=\"text\"  class=\"txtbox\" value=\""+yyCon+"\" onkeyup=\"calConsuption(this);\"  onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQtyCon(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event);\" id=\"yy" + x + "" + i + "|"+ratioQty+"\" size=\"7\" />" +
                                "</div></td>";   
                        }
                        else{
                          HTMLTextYY += "<td id=\""+poValue+"\"><div align=\"center\">" +
                                "<input name=\"yy\" type=\"text\"  class=\"txtbox\" disabled value=\""+yyCon+"\" onkeyup=\"calConsuption(this);\"  onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQtyCon(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event);\" id=\"yy" + x + "" + i + "|"+ratioQty+"\" size=\"7\" />" +
                                "</div></td>";    
                        }
                        
                               
			}
                        //alert(arrayWastege[x]);
                            if(arrayWastege[x]>=0){
                               arrayWastege[x]=arrayWastege[x]; 
                            }
                            else{
                               arrayWastege[x]=bomWastage;    
                            }
                            
                            
                            if(arrayMoq[x]>=0){
                               arrayMoq[x]=arrayMoq[x]; 
                            }
                             else{
                               arrayMoq[x]=0;    
                            }
                            
                            
                        if(editWaste==1){
                            HTMLTextYY += "<td><input type=\"text\" value=\""+arrayWastege[x]+"\" class=\"txtbox\" onkeyup=\"calcWestage(this); ChangeCellValueCon(this); ValidateWithPoQtyCon(this);\"  id=\"wast" + x + "\" size=\"7\" />"+ 
                                      "</td>";
                                         
                	
              		"</tr>" ;
                        }
                        else{
                             HTMLTextYY += "<td><input type=\"text\" disabled value=\""+arrayWastege[x]+"\" class=\"txtbox\" onkeyup=\"calcWestage(this); ChangeCellValueCon(this); ValidateWithPoQtyCon(this);\"  id=\"wast" + x + "\" size=\"7\" />"+ 
                                      "</td>";

                	
              		"</tr>" ;
                        }
                        
                         HTMLTextYY += "<td class=\"normalfntRite\">&nbsp</td>" +
                                        "<td><input type=\"text\" value=\""+arrayMoq[x]+"\" class=\"txtbox\" id=\"moq" + x + "\" size=\"7\" />"+ 
                                       "</td>";
		}
                
                if(matDetails=="FAB"){
                    document.getElementById("yy").innerHTML = HTMLTextYY;
                }
        //</mig>...................................
               



	   HTMLText = HTMLText.replace("tblQtyRatio","tblEXQtyRatio");
		for (var loop = 0 ; loop < sizes.length * colors.length; loop ++)
		{
		HTMLText = HTMLText.replace("onkeyup=\"ChangeCellValue(this);\"","onkeyup=\"ChangeCellValueExcess(this);\""); 

		//HTMLText = HTMLText.replace("onkeyup=\"ChangeCellValue(this);\"","");
		}
		if (document.getElementById("divExQtyRatio") != null)
		document.getElementById("divExQtyRatio").innerHTML = HTMLText;
		closeLayer();
		doLoadCalculation();
	}
}

function LoadAvailableColors()
{
	var tbl = document.getElementById('tblQtyRatio');
	if (tbl == null) return;

    for ( var loop = 1 ;loop < tbl.rows.length -1 ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var colorName = rw.cells[0].lastChild.nodeValue;
		var optColor = document.createElement("option");
		optColor.text = colorName;
		optColor.value = colorName;
		
//Start 31-03-31 bookmark (when loading colors po colord will disabled)
		var isPo = rw.cells[0].id;
		if(isPo==1){
			optColor.disabled = true;
			document.getElementById('imgMoveRight').style.visibility = "hidden";
		}
		else
			optColor.disabled = false;
//End 31-03-31 bookmark (when loading colors po colord will disabled)

		document.getElementById("cboselectedcolors").options.add(optColor);		
	}
}

function LoadAvailableSizes()
{
	var tbl = document.getElementById('tblQtyRatio');
	if (tbl == null) return;
	var rw = tbl.rows[0];
	for ( var loop = 1 ;loop < rw.cells.length -1 ; loop ++ )
  	{
		var size = rw.cells[loop].lastChild.lastChild.nodeValue;
		var optSize = document.createElement("option");
		optSize.text = size;
		optSize.value = size;
//Start 31-03-31 bookmark (when loading colors po colord will disabled)
		var isPo = rw.cells[0].id;
		if(isPo==1){
				//document.getElementById("cboselectedsizes").ondblclick = function() { return false; }
				document.getElementById('imgDownMoveRight').style.visibility = "hidden";
				//document.getElementById('imgDownMoveLeft').style.visibility = "hidden";
				//document.getElementById('imgOneMoveRight').style.visibility = "hidden";
				//document.getElementById('imgOneMoveLeft').style.visibility = "hidden";
			}
			else
				optSize.disabled = false;
//End 31-03-31 bookmark (when loading colors po colord will disabled)
		document.getElementById("cboselectedsizes").options.add(optSize);	
		var count = document.getElementById("cbosizesnumbsrial").options.length;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
	}
}
function ChangeCellValue(obj)
{
	calculateRow(obj);
	CalculateColumn(obj);
	CalculateTotal(obj);
	UpdateTables(obj);
	
}
//<mig>
function ChangeCellValueCon(obj)
{
   // alert("a");
	calculateRowCon(obj);
	CalculateColumnCon(obj);
	//CalculateTotal(obj);
	//UpdateTables(obj);
	
}
function calculateRowCon(obj)
{
    var posId             =   obj.id;
    var rowId             =   parseFloat(posId.charAt(4));  
    var tblRatio          =   document.getElementById('tblQtyRatio');
    var cellLength        =   parseFloat(tblRatio.rows[rowId].cells.length);

	var total = 0;
        for ( var loop = 1 ;loop < cellLength-1 ; loop ++ )
  	{
            total += parseInt(tblRatio.rows[rowId+1].cells[loop].lastChild.lastChild.value,10);		
	}
	    tblRatio.rows[rowId+1].cells[cellLength-1].lastChild.lastChild.nodeValue = total;	
}

function CalculateColumnCon(obj)
{

      var tblRatio          =   document.getElementById('tblQtyRatio');
      var rowLength        =   parseFloat(tblRatio.rows.length);
      
          var posId             =   obj.id;
        var rowId             =   parseFloat(posId.charAt(4));  
      var cellLength        =   parseFloat(tblRatio.rows[rowId].cells.length);
        
        var gTotal=0;
	
	for(var i=1; i<cellLength-1 ; i++) 
        
  	{
            var total = 0;
                for(var loop = 1;loop <rowLength-1; loop ++ )
                {
                    total += parseInt(tblRatio.rows[loop].cells[i].lastChild.lastChild.value,10);
                    //alert("rowLength = "+rowLength+" total = "+total);
                    //tblRatio.rows[loop+1].cells[i+1].lastChild.lastChild.nodeValue = total;
                }
                          tblRatio.rows[rowLength-1].cells[i].lastChild.lastChild.nodeValue = total;
                          gTotal += total;
                        //  alert(gTotal);


	}
        tblRatio.rows[loop].cells[i].lastChild.lastChild.nodeValue = gTotal;
	
}
//</mig>
function ChangeCellValueExcess(obj)
{

	calculateRow(obj);
	CalculateColumn(obj);
	CalculateTotal(obj);
}

function calculateRow(obj)
{
	var tr = obj.parentNode.parentNode.parentNode;
	var total = 0;
	for ( var loop = 1 ;loop < tr.cells.length -1 ; loop ++ )
  	{
		total += parseInt(tr.cells[loop].childNodes[0].lastChild.value,10);		
	}
	tr.lastChild.lastChild.lastChild.nodeValue = total;	
}

function CalculateColumn(obj)
{
	var td = obj.parentNode.parentNode;
	var index = td.cellIndex;
	var total = 0;
	var table = obj.parentNode.parentNode.parentNode.parentNode;
	for ( var loop = 1 ;loop < table.rows.length -1 ; loop ++ )
  	{
		var rw = table.rows[loop];
        total += parseInt(rw.cells[index].lastChild.lastChild.value,10);
	}
	table.rows[table.rows.length-1].cells[index].lastChild.lastChild.nodeValue = total;
}

function CalculateTotal(obj)
{
	var table = obj.parentNode.parentNode.parentNode.parentNode;
	var total = 0;
	var tr = table.rows[table.rows.length-1];
	for ( var loop = 1 ;loop < tr.cells.length -1 ; loop ++ )
  	{
		//var bbb = tr.cells[loop].childNodes[0];
		total += parseInt(tr.cells[loop].childNodes[0].lastChild.nodeValue,10);	
		//alert(parseInt(tr.cells[loop].childNodes[0].lastChild.nodeValue));
	}
	table.rows[table.rows.length-1].cells[tr.cells.length -1].lastChild.lastChild.nodeValue = total;
}

//Start - 18-08-2010 (Culculate ex qty with two decimal places)
function calculateExRow(obj)
{
	var tr = obj.parentNode.parentNode.parentNode;
	var total = 0;
	for ( var loop = 1 ;loop < tr.cells.length -1 ; loop ++ )
  	{
		total += parseFloat(tr.cells[loop].childNodes[0].lastChild.value);		
	}
	total = total.toFixed(2);
	tr.lastChild.lastChild.lastChild.nodeValue = RoundNumbers(total,2);	
}

function CalculateExColumn(obj)
{
	var td = obj.parentNode.parentNode;
	var index = td.cellIndex;
	var total = 0;
	var table = obj.parentNode.parentNode.parentNode.parentNode;
	for ( var loop = 1 ;loop < table.rows.length -1 ; loop ++ )
  	{
		var rw = table.rows[loop];
        total += parseFloat(rw.cells[index].lastChild.lastChild.value);
	}
	total = total.toFixed(2);
	table.rows[table.rows.length-1].cells[index].lastChild.lastChild.nodeValue = RoundNumbers(total,2);
}

function CalculateExTotal(obj)
{
	var table = obj.parentNode.parentNode.parentNode.parentNode;
	var total = 0;
	var tr = table.rows[table.rows.length-1];
	for ( var loop = 1 ;loop < tr.cells.length -1 ; loop ++ )
  	{
		//var bbb = tr.cells[loop].childNodes[0];
		total += parseFloat(tr.cells[loop].childNodes[0].lastChild.nodeValue);	
		//alert(parseInt(tr.cells[loop].childNodes[0].lastChild.nodeValue));
	}
	total = total.toFixed(2);
	table.rows[table.rows.length-1].cells[tr.cells.length -1].lastChild.lastChild.nodeValue = RoundNumbers(total,2);
}
//End - 18-08-2010 (Culculate ex qty with two decimal places)

function UpdateTables(obj)
{
	var table = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
	var tr = obj.parentNode.parentNode.parentNode;
	var td = obj.parentNode.parentNode;
	var row = tr.rowIndex;
	var col = td.cellIndex;
	var tblEx = document.getElementById("tblEXQtyRatio");
	var tblQty = document.getElementById("tblQtyRatio");
	var givenValue = parseInt(obj.value,10);
	var exPercentage = parseInt(document.getElementById("txtexcessqty").value,10);
	if (table.id == "tblQtyRatio")
	{
		if (tblEx != null)
		{
			var exValue = RoundNumbers(givenValue + (givenValue * exPercentage / 100),2);
			tblEx.rows[row].cells[col].lastChild.lastChild.value = exValue;
			var newObj = tblEx.rows[row].cells[col].lastChild.lastChild;
			calculateExRow(newObj);
			CalculateExColumn(newObj);
			CalculateExTotal(newObj);
		}
	}
	else
	{
		var qty = parseInt(givenValue - (givenValue * exPercentage / 100));
		tblQty.rows[row].cells[col].lastChild.lastChild.value = qty;
		var newObj = tblQty.rows[row].cells[col].lastChild.lastChild;
		calculateRow(newObj);
		CalculateColumn(newObj);
		CalculateTotal(newObj);
	}
}

function isValidRatio()
{
	
	var poqty = parseInt(document.getElementById("txtbuyerpo").value,10);
	
	var tblQty = document.getElementById("tblQtyRatio");
	var tblEx = document.getElementById("tblEXQtyRatio");
	var ratioqty = parseInt(tblQty.rows[tblQty.rows.length-1].cells[tblQty.rows[0].cells.length -1].lastChild.lastChild.nodeValue,10);
	var ratioExqty = parseInt(tblEx.rows[tblQty.rows.length-1].cells[tblQty.rows[0].cells.length -1].lastChild.lastChild.nodeValue,10);
	var Expercentage = document.getElementById('txtexcessqty').value;
	var Exqty = parseInt(poqty) + (parseInt(poqty) * parseInt(Expercentage) / 100);
	
	if (poqty != ratioqty)
	{
		alert("The color size ratio total quantity does not match with the order quantity.\n Variance is : "+(poqty-ratioqty));	
		return false;
	}
	else if (parseInt(Exqty) != ratioExqty)
	{
		alert("The color size ratio total excess quantity does not match with the order excess quantity.\n Variance is : "+(parseInt(Exqty)-ratioExqty));	
		return false;
	}
	return true;
}

function SaveStyleRatio()
{
	if (isValidRatio())
	{
		ShowPreLoader();
		//ShowProgress();
		PrepairStyleRatioDatabase();
	}
}

function PrepairStyleRatioDatabase()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleSaving;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=DelStyRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) , true);
    xmlHttp.send(null); 
}

function HandleSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			StartSaving();
		}
	}
}
function SaveStyleRatio1()
{
	var tblQty = document.getElementById("tblQtyRatio");
	var tblEx = document.getElementById("tblEXQtyRatio");
	var incr = 0;
	requestCount = 0;
	matincr = 0;
	
	for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
	{
		for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
		{
			var styleNo = document.getElementById('lblStyleNo').innerHTML;
			var buyerPONo = document.getElementById("cbopono").value;
			var b = tblQty.rows[loop].cells[i];
			var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
			var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
			var sizeserial = tblQty.rows[0].cells[i].id;
			//alert(sizeserial);
			var qty = tblQty.rows[loop].cells[i].lastChild.lastChild.value;
			var exQty = tblEx.rows[loop].cells[i].lastChild.lastChild.value;			
			// userID
			requestCount ++ ;
			createNewXMLHttpRequest(incr);
			//xmlHttpreq[i].onreadystatechange = HandleStyleRatioRequest;
			//xmlHttpreq[i].index = i;
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveStyleRatio1&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&exQty=' + exQty + '&sizeserial=' + sizeserial, true);
			xmlHttpreq[incr].send(null);
			incr ++ ;			
			
		}		
	}
}
function StartSaving()
{
	var tblQty = document.getElementById("tblQtyRatio");
	var tblEx = document.getElementById("tblEXQtyRatio");
	var incr = 0;
	requestCount = 0;
	matincr = 0;
	
	for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
	{
		for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
		{
			var styleNo = document.getElementById('lblStyleNo').innerHTML;
			var buyerPONo = document.getElementById("cbopono").value;
			var b = tblQty.rows[loop].cells[i];
			var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
			var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
			var sizeserial = tblQty.rows[0].cells[i].id;
			//alert(sizeserial);
			var qty = tblQty.rows[loop].cells[i].lastChild.lastChild.value;
			var exQty = tblEx.rows[loop].cells[i].lastChild.lastChild.value;			
			// userID
			requestCount ++ ;
			createNewXMLHttpRequest(incr);
			//xmlHttpreq[i].onreadystatechange = HandleStyleRatioRequest;
			//xmlHttpreq[i].index = i;
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveStyleRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&exQty=' + exQty + '&sizeserial=' + sizeserial, true);
			xmlHttpreq[incr].send(null);
			incr ++ ;			
			
		}		
	}
	
	var tbl = document.getElementById('tblConsumption');
	var tblQty = document.getElementById("tblQtyRatio");
	
	for ( var x = 1 ;x < tbl.rows.length ; x ++ )
	{
		var dd = tbl.rows[x].cells[12];
		var purchaseType = tbl.rows[x].cells[12].childNodes[0].value;

		var itemCode = tbl.rows[x].cells[5].id;
		var conPC = parseFloat(tbl.rows[x].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[x].cells[7].lastChild.nodeValue);
		var freightCharge = parseFloat(tbl.rows[x].cells[11].lastChild.nodeValue);
		var exPercentage = parseInt(document.getElementById("txtexcessqty").value,10);
		var mainQty = parseInt(document.getElementById("txtorderqty").value,10);
		var matCatId = parseInt(tbl.rows[x].cells[4].id);
		//alert(purchaseType);
	
		if(purchaseType == "COLOR")
		{
			for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
			{
				var styleNo = document.getElementById('lblStyleNo').innerHTML;
				var buyerPONo = document.getElementById("cbopono").value;
				
				var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
				var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
				var qty = parseFloat(tblQty.rows[loop].cells[tblQty.rows[loop].cells.length -1].lastChild.lastChild.nodeValue,10);
				//qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
				qty = calculateMaterialRatioQty(qty,totconsumption,exPercentage,conPC,purchaseType,matCatId);
				
				createNewXMLHttpRequest(incr);
				xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=N/A&qty=' + qty + '&posID=' + (loop -1 ) + '&freight=' + freightCharge, true);
				xmlHttpreq[incr].send(null);
				matincr++;
				incr ++ ;
			}
		}
		else if(purchaseType == "SIZE")
		{
			for ( var i = 1 ;i < tblQty.rows[0].cells.length -1 ; i ++ )
			{
				var styleNo = document.getElementById('lblStyleNo').innerHTML;
				var buyerPONo = document.getElementById("cbopono").value;
				
				var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
				//var sizeserial = tblQty.rows[0].cells[i].id;
				//alert(sizeserial);
				var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
				var qty = parseFloat(tblQty.rows[tblQty.rows.length-1].cells[i].lastChild.lastChild.nodeValue,10);
				//qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
				qty = calculateMaterialRatioQty(qty,totconsumption,exPercentage,conPC,purchaseType,matCatId);
				createNewXMLHttpRequest(incr);
				xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=N/A&size=' + URLEncode(size) + '&qty=' + qty + '&posID=' + (loop - 1) + '&freight=' + freightCharge + '&sizeserial=' + sizeserial, true);
				xmlHttpreq[incr].send(null);
				matincr++;
				incr ++ ;
			}
		}
		else if(purchaseType == "BOTH")
		{
			for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
			{
				for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
				{
					var styleNo = document.getElementById('lblStyleNo').innerHTML;
					var buyerPONo = document.getElementById("cbopono").value;
					
					var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
					var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
					var qty = parseFloat(tblQty.rows[loop].cells[i].lastChild.lastChild.value,10);
					//qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
					//qty = Math.round((qty *  totconsumption) + ((qty * exPercentage / 100) * conPC));
					
					/*Start - 04-11-2010 this function comment and add a function 
					qty = (qty *  totconsumption) + ((qty * exPercentage / 100) * conPC);
					
					if(qty<1)
						qty = Math.ceil(qty);
					else
						qty = Math.round(qty);
						End*/
						
					qty = calculateMaterialRatioQty(qty,totconsumption,exPercentage,conPC,purchaseType,matCatId);
						
					var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
					createNewXMLHttpRequest(incr);
					xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty  + '&posID=' + (loop-1) + '&freight=' + freightCharge, true);
					xmlHttpreq[incr].send(null);
					matincr++;
					incr ++ ;
				}
				
			}
		}
		else
		{
			var styleNo = document.getElementById('lblStyleNo').innerHTML;
			var buyerPONo = document.getElementById("cbopono").value;
			
			var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
			var qty = parseFloat(tblQty.rows[loop].cells[i].lastChild.lastChild.nodeValue,10);
			var sizeserial = 0;
			//qty = Math.round((qty *  totconsumption) + ((qty * exPercentage / 100) * conPC)); 04-11-2010
			qty = calculateMaterialRatioQty(qty,totconsumption,exPercentage,conPC,purchaseType,matCatId);
			createNewXMLHttpRequest(incr);
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=N/A&size=N/A&qty=' + qty + '&posID=0' + '&freight=' + freightCharge  + '&sizeserial=' + sizeserial   , true);
			xmlHttpreq[incr].send(null);
			matincr++;
			incr ++ ;	
			
			
		}
			
		
		
	}

	// =================================================
	// Add By - Nalin Jayakody
	// Add On - 2015/11/30
	// Adding - Change the serial number of #Main Ratio# in style ratio if color and size 'N/A'
	//==================================================
	SetSerialStyleRatio();
	//==================================================

	ValidateDataTransfer();

	
}

function ValidateDataTransfer()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").value;

	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleAckmowledgement;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=ValidateTransfer&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&ReqCount=' + requestCount + '&Matrequest=' + matincr , true);
    xmlHttp.send(null); 
}

function HandleAckmowledgement()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			var result = XMLResult[0].childNodes[0].nodeValue;
			if (result == "True")
			{
				ClosePreloader();
				hasStyleRatio = true;
				alert("The style ratio has been saved successfully");
			}
			else
			{
				//ValidateDataTransfer();
				alert("Style ratio saving error, Please try save again");
				ClosePreloader();
				return;
			}
		}
	}
}

function ShowPreLoader()
{
	
	var dialog = document.createElement("div");
    dialog.id = "preloader";
    dialog.style.position = 'absolute';
    dialog.style.zIndex = 60;
    dialog.style.left = 0 + 'px';
    dialog.style.top = 0 + 'px';  
	
	var HTMLText = "<table width=\"1200\" height=\"1400\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >" +
				  "<!--DWLayoutTable-->" +
				  "<tr>" +
					"<td width=\"150\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\" height=\"184\">&nbsp;</td>" +
					"<td width=\"261\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
					"<td width=\"239\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
				  "</tr>" +
				  "<tr bgcolor=\"#000000\">" +
					"<td height=\"37\">&nbsp;</td>" +
					"<td valign=\"middle\"><div align=\"center\"  class=\"headRed\">Please Wait ..... </div></td>" +
					"<td>&nbsp;<progress id=\"p\" style=\"width:150px; \"></progress></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td height=\"1200\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +

					"<td class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
					"<td class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
				  "</tr>" +
				"</table>";
				
	dialog.innerHTML = HTMLText;     
    document.body.appendChild(dialog);
}

function ClosePreloader()
{
	try
    {
        var bgbox = document.getElementById('preloader');
        bgbox.parentNode.removeChild(bgbox);
    }
    catch(err)
    {
    }
}


function LoadStyleRatio()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	//var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
	var buyerPONo = document.getElementById("cbopono").value;
	createNewXMLHttpRequest(1);
	xmlHttpreq[1].onreadystatechange = HandleLoading;
	xmlHttpreq[1].open("GET", 'bomMiddletire.php?RequestType=GetStyleRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) , true);
	xmlHttpreq[1].send(null);
}

function HandleLoading()
{
	if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        {  
			var XMLTotalBuyerPoNo = xmlHttpreq[1].responseXML.getElementsByTagName("TotalBuyerPoNo")[0].childNodes[0].nodeValue;
			
			var poqty = parseInt(XMLTotalBuyerPoNo,10);
			document.getElementById('txtbuyerpo').value = poqty;
			var exqtypc = parseInt(document.getElementById("txtexces").value,10); 
			var exqtyratio = poqty + (poqty * exqtypc / 100);
			document.getElementById('exratioHeader').innerHTML = "Ratio for Qty " + parseInt(exqtyratio,10) + " (Order Qty + Excess Qty)";
			
			 var XMLStyleID = xmlHttpreq[1].responseXML.getElementsByTagName("StyleNo");
			 var XMLBuyerPO = xmlHttpreq[1].responseXML.getElementsByTagName("BuyerPONo");
			 var XMLColor = xmlHttpreq[1].responseXML.getElementsByTagName("Color");
			 var XMLSize = xmlHttpreq[1].responseXML.getElementsByTagName("Size");
			 var XMLQty = xmlHttpreq[1].responseXML.getElementsByTagName("Qty");
			 var XMLExQty = xmlHttpreq[1].responseXML.getElementsByTagName("ExQty");
			 var XMLintserial = xmlHttpreq[1].responseXML.getElementsByTagName("intserial");
			  var XMLFOB = xmlHttpreq[1].responseXML.getElementsByTagName("FOB");
			 var XMLPackQty = xmlHttpreq[1].responseXML.getElementsByTagName("PackQty");
			 
			 
			 var colorIndex = 0;
			 var sizeIndex = 0;
			  var serialIndex = 0;
			 var colors = [];
			 var sizes = [];
			 var Qtys = [];
			 var ExQtys = [];
			 var intserial =[];
			 var FOBs = [];
			 var PackQtys = [];
			 
			 
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var color  = XMLColor[loop].childNodes[0].nodeValue;
				var size = XMLSize[loop].childNodes[0].nodeValue;
				var serial = XMLintserial[loop].childNodes[0].nodeValue;
				Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
				ExQtys[loop] = XMLExQty[loop].childNodes[0].nodeValue;
				FOBs[loop] = XMLFOB[loop].childNodes[0].nodeValue;
				PackQtys[loop] = XMLPackQty[loop].childNodes[0].nodeValue;
				
				if(!findItem(color,colors))
				{
					colors[colorIndex] = color;
					colorIndex ++;
				}

				if(!findItem(size,sizes))
				{
					sizes[sizeIndex] = size;
					sizeIndex ++;
				}
				if(!findItem(intserial,serial))
				{
					intserial[serialIndex] = serial;
					serialIndex ++;
				}
			
			
			 }
			 //alert(sizes.length);
			 // ---------------------------------------
			 
			 var tablewidth = 450 + (7 * sizes.length);
		
			// Create The table header
			var HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			for (i in sizes)
			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id=\""+intserial[i]+"\"><div align=\"center\">" + sizes[i] + "</div></td>";
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td class=\"normalfnt\">" + colors[x] + "</td>" ;
				for (i in sizes)
				{
					HTMLText += "<td><div align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\" class=\"txtbox\" value=\"" + Qtys[loopindex] + "\" onkeyup=\"ChangeCellValue(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return IsNumberWithoutDecimals(this.value,event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>";
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\">Total</td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
			
			// -----------------------------------------------------------		
			
			document.getElementById("divQtyRatio").innerHTML = HTMLText;
			
			// -----------------------------------------------------------
			
			// Create The table header
			HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			for (i in sizes)
			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">" + sizes[i] + "</div></td>";
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td class=\"normalfnt\">" + colors[x] + "</td>" ;
				for (i in sizes)
				{
					HTMLText += "<td><div align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\" class=\"txtbox\" value=\"" + ExQtys[loopindex] + "\" onkeyup=\"ChangeCellValueExcess(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>";
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\">Total</td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
			HTMLText = HTMLText.replace("tblQtyRatio","tblEXQtyRatio");
			document.getElementById("divExQtyRatio").innerHTML = HTMLText;
			
			HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblFOB\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			for (i in sizes)
			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">" + sizes[i] + "</div></td>";
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td class=\"normalfnt\" nowrap='nowrap'>" + colors[x] + "</td>" ;
				for (i in sizes)
				{
					HTMLText += "<td><div align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\" class=\"txtbox\" value=\"" + FOBs[loopindex] + "\" onkeyup=\"ChangeCellValueFOB(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>";
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\"><b>Total</b></td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
						
			document.getElementById("divSizeWiseFOB").innerHTML = HTMLText;
			//////////////////////////////////////////// END FOB (Color & Size Wise) ///////////////////////////////
						//////////////////////////////////////////// START FOB (Color & Size Wise) ////////////////////////////
			// Create The table header
			HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblPackQty\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			for (i in sizes)
			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">" + sizes[i] + "</div></td>";
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td class=\"normalfnt\" nowrap='nowrap'>" + colors[x] + "</td>" ;
				for (i in sizes)
				{
					HTMLText += "<td><div align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\" class=\"txtbox\" value=\"" + PackQtys[loopindex] + "\" onkeyup=\"ChangeCellValuePackQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>";
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\"><b>Total</b></td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
						
			document.getElementById("divPackQty").innerHTML = HTMLText;
			//////////////////////////////////////////// END FOB (Color & Size Wise) ///////////////////////////////
			
		}
	}
	doLoadCalculation();
}

function findItem(item, arr) 
{
	if (arr.length <= 0) return false;
	// find index position of {item}
	// in Array {arr} - return -1, if 
	// item not found 
	var idx;
	var last = arr.length;
	for (var i = 0; i < last; i++)
	{
		idx = (item == arr[i])?i:-1;
		// quit on first "found"
		if (-1 != idx) break;
	}
	if (idx != -1)
	return true;
	else
	return false;
}

function doLoadCalculation()
{
	try
    {
		var exPercentage = parseInt(document.getElementById("txtexcessqty").value,10);
		var tblQty = document.getElementById("tblQtyRatio");
		var tblEx = document.getElementById("tblEXQtyRatio");
		for ( var loop = 1 ; loop < tblQty.rows.length -1 ; loop ++ )
		{
			for ( var i = 1 ; i < tblQty.rows[loop].cells.length -1 ; i ++ )
			{			
				
				var newObj = tblQty.rows[loop].cells[i].lastChild.lastChild;
				calculateRow(newObj);
				CalculateColumn(newObj);
				CalculateTotal(newObj);
				var givenValue = parseInt(tblQty.rows[loop].cells[i].lastChild.lastChild.value,10);
				
				if ( tblEx != null)
				{					
					var exValue = RoundNumbers(givenValue + (givenValue * exPercentage / 100),2);
					tblEx.rows[loop].cells[i].lastChild.lastChild.value = exValue;
					var newObj = tblEx.rows[loop].cells[i].lastChild.lastChild;
					//newObj = tblEx.rows[loop].cells[i].lastChild.lastChild;
					calculateExRow(newObj);
					CalculateExColumn(newObj);
					CalculateExTotal(newObj);
				}

			}
			
		}	
	}
	catch(err)
	{
	}
}

var ColorSizeConsumption = 0;
var ColorSizeWastage	= 0;
var pub_wastage	= 0;
var matRatioRequest = null;

function ShowMaterialRatiowindow(obj,purchasedQty)
{
	matRatioRequest = true;
	if (purchasedQty > 0 && isSuperMaterialRatioEditot == false)
	{
		alert("Sorry! Can't proceed with material ratio. \nThis item already purchased.");	
		return ;
	}
	
	if (!hasStyleRatio)
	{
		alert("Sorry! Can't proceed with material ratio. \nStyle ratio is not enterd to this style. You should set Style ratio First.");	
		return ;
	}
	curObj = obj;
	drawPopupArea(800,700,'frmMatRatio');
	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var wastage = obj.parentNode.parentNode.parentNode.cells[7].lastChild.nodeValue;
	var itemID = obj.parentNode.parentNode.parentNode.cells[5].id;
	var itemName = obj.parentNode.parentNode.parentNode.cells[5].lastChild.nodeValue;
	var conPC = parseFloat(obj.parentNode.parentNode.parentNode.cells[6].lastChild.nodeValue);
		var material = obj.parentNode.parentNode.parentNode.cells[3].lastChild.nodeValue;
        var uom      = obj.parentNode.parentNode.parentNode.cells[9].lastChild.nodeValue;
   
	/*start - can get a qty from grid no need to calculate
	var totqty = parseInt(parseInt(orderQty) + (parseInt(orderQty) * parseFloat(ExQty) / 100) + (parseInt(orderQty) * parseFloat(wastage) / 100) ) ;
	otqty  = Math.round(totqty * conPC);
	End - can get a qty from grid no need to calculate
	*/
	var totqty	= parseFloat(obj.parentNode.parentNode.parentNode.cells[8].lastChild.nodeValue);
	
	var addingPercentage = parseFloat(ExQty) + parseFloat(wastage);
	//ColorSizeConsumption = conPC + ( conPC * parseFloat(wastage) / 100 );
	ColorSizeConsumption = conPC;
	ColorSizeWastage = (parseFloat(orderQty) * parseFloat(wastage))/100;
	pub_wastage = parseFloat(wastage);
	loadPercentage = addingPercentage;
	loadItem = itemID ;
	var HTMLText = "<table width=\"800\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmMatRatio'),event);\">" +
						"<td width=\"25%\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Ratio - " + itemName + "</td>" +
						"</tr>" +
					"</table></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td class=\"bcgl1\"><table width=\"800\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"25\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"2%\">&nbsp;</td>" +
							  "<td width=\"15%\" class=\"normalfnt\">Buyer PO No.</td>" +
							  "<td width=\"22%\" class=\"normalfnt\"><select name=\"cbopono\" class=\"txtbox\" id=\"cbopono\" onChange=\"changePOonMaterial(" + addingPercentage + "," + itemID + "); ChangeBPONo(" + totqty + "," + orderQty + "); \" style=\"width:135px\">" +
								"</select>              </td>" +
								"<td class=\"normalfnt\">Total Qty ("+uom+")</td>" +
								"<td class=\"normalfnt\"><input name=\"txttotalorder\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txttotalorder\" value=\"" + totqty + "\" style=\"text-align:right\"/></td>" +
								"<td width=\"5%\" class=\"normalfnt\"><input width=\"5%\"  name=\"matDetail\" type=\"text\" class=\"txtbox\" id=\"matDetail\" value=\"" + material+"|"+conPC +"|"+wastage+ "\" style=\"text-align:right;display:none\"/></td>" +
                                                                "<td ><input name=\"bpo_Qty\" type=\"text\" class=\"txtbox\"  id=\"bpo_Qty\" value=\"" + purchasedQty + "\" style=\"text-align:right;display:none\"/></td>" +
                                         "</tr>" +
                                                          "<tr>" +
                                                                "<td width=\"2%\">&nbsp;</td>" +
                                                                "<td class=\"normalfnt\">BPO Qty </td>" +
                                                                "<td class=\"normalfnt\"><input name=\"bpo_Qty1\" type=\"text\" class=\"txtbox\" width=\"35\"  id=\"bpo_Qty1\" style=\"text-align:right\"/></td>" +
								//"<td colspan=\"2\" class=\"normalfnt\">&nbsp;</td>" +
							  "</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratios</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divQtyRatio\" style=\"overflow:scroll; height:570px; width:800px;\">" +
						"</div></td>" +
					 "</tr>" +
					 "<tr>" +
						//"<td>&nbsp;</td>" +
					  "</tr></table>" +
                    
					  "<tr>" +
						"<td><table width=\"100%\" height=\"31\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							  "<td width=\"20%\" bgcolor=\"#D6E7F5\"><img src=\"images/confirmpoqty.png\" alt=\"new\"  class=\"mouseover\" onClick=\"ShowPORaisedQtyWindow();\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/new.png\" alt=\"new\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"showColorSizeSelector('m');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\"SaveMaterialRatio('" + itemID + "');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/close.png\" alt=\"close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closes();\" /></td>" +
							 "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table></td>" +
				  "</tr>" +
				"</table>";
   //  <mig>...................                      
                        
    var HTMLTextYY = "<table width=\"800\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmMatRatio'),event);\">" +
						"<td width=\"25%\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Ratio - " + itemName + "</td>" +
						"</tr>" +
					"</table></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td class=\"bcgl1\"><table width=\"800\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"25\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"2%\">&nbsp;</td>" +
							  "<td width=\"15%\" class=\"normalfnt\">Buyer PO No.</td>" +
							  "<td width=\"22%\" class=\"normalfnt\"><select name=\"cbopono\" class=\"txtbox\" id=\"cbopono\" onChange=\"changePOonMaterial(" + addingPercentage + "," + itemID + "); ChangeBPONo(" + totqty + "," + orderQty + "); \" style=\"width:135px\">" +
								"</select>              </td>" +
								"<td class=\"normalfnt\">Total Qty ("+uom+")</td>" +
							  "<td class=\"normalfnt\"><input name=\"txttotalorder\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txttotalorder\" value=\"" + totqty + "\" style=\"text-align:right\"/></td>" +
							  "<td width=\"5%\" class=\"normalfnt\"><input name=\"matDetail\" type=\"text\" class=\"txtbox\" id=\"matDetail\" value=\"" + material+"|"+conPC +"|"+wastage+ "\" style=\"text-align:right;display:none;\"/></td>" +
                                                          "<td ><input name=\"bpo_Qty\" type=\"text\" class=\"txtbox\"  id=\"bpo_Qty\" value=\"" + purchasedQty + "\" style=\"text-align:right; display:none\"/></td>" +
                                                            "<td nowrap class=\"normalfnt\"><label id=\"balQty\" for=\"balQty\" /></label></td>" +
							  //"<td width=\"1%\">&nbsp;</td>" +
                                                  "</tr>" +
                                                          "<tr>" +
                                                                "<td width=\"2%\">&nbsp;</td>" +
                                                                "<td class=\"normalfnt\">BPO Qty </td>" +
                                                                "<td class=\"normalfnt\"><input name=\"bpo_Qty1\" type=\"text\" class=\"txtbox\" width=\"35\"  id=\"bpo_Qty1\" style=\"text-align:right\"/></td>" +
								//"<td colspan=\"2\" class=\"normalfnt\">&nbsp;</td>" +
							  "</tr>" +
                                                     
						"</table></td>" +
					  "</tr>" +
					  "<tr>" + 
						"<td width=\"1%\">&nbsp</td>" +
                                                //"<td width=\"1%\"><label class=\"normalfnt\" id=\"balQty\" for=\"balQty\" /></label></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratios</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divQtyRatio\" style=\"overflow:scroll; height:190px; width:800px;\">" +
						"</div></td>" +
					 "</tr>" +
					 "<tr>" +
						//"<td>&nbsp;</td>" +
					  "</tr></table>" +
					  


						  
					"<tr>" +
							"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Yardage Yield Consumption - (UOM = "+uom+")</td>" +
					 "</tr>" +
					"<tr>" +
							"<td><div id=\"yy\" style=\"overflow:scroll; height:190px; width:800px;\">" +
							"</div></td>" +
					"</tr>" +
					 


					"<tr>" +
							"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratio Review</td>" +
					 "</tr>" +
					"<tr>" +
							"<td><div id=\"rr\" style=\"overflow:scroll; height:190px; width:800px;\">" +
							"</div></td>" +
					"</tr>" +



					
					  "<tr>" +
						"<td><table width=\"100%\" height=\"31\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							  "<td width=\"20%\" bgcolor=\"#D6E7F5\"><img src=\"images/confirmpoqty.png\" alt=\"new\"  class=\"mouseover\" onClick=\"ShowPORaisedQtyWindow();\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/new.png\" alt=\"new\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"showColorSizeSelector('m');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\"SaveMaterialRatio('" + itemID + "');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/close.png\" alt=\"close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closes();\" /></td>" +
							 "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table></td>" +
				  "</tr>" +
				"</table>";	
				
	var frame = document.createElement("div");
    frame.id = "ratioselectwindow";
	if(material!='FAB'){    
	document.getElementById('frmMatRatio').innerHTML=HTMLText;
    }
    else{
        document.getElementById('frmMatRatio').innerHTML=HTMLTextYY;
    }

	LoadBuyerBONos();
	
	//document.getElementById("txttotalorder").value = orderQty;
	
}

function changePOonMaterial(percentage,itemID)
{
	if (document.getElementById("cbopono").value == "") return;
	var poqty = document.getElementById("cbopono").value;	
	
	
	
//COMMENT BECAUSE CALCULATION DONE IN BELOW LINE	
/*	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var wastage = curObj.parentNode.parentNode.parentNode.cells[7].lastChild.nodeValue;
	var itemID = curObj.parentNode.parentNode.parentNode.cells[5].id;
	var itemName = curObj.parentNode.parentNode.parentNode.cells[5].lastChild.nodeValue;
	var conPC = parseFloat(curObj.parentNode.parentNode.parentNode.cells[6].lastChild.nodeValue);
	var totqty = parseInt(parseInt(poqty) + (parseInt(poqty) * parseFloat(ExQty) / 100) + (parseInt(poqty) * parseFloat(wastage) / 100) );
	totqty  = Math.round(totqty * conPC);	

	document.getElementById('txttotalorder').value = totqty;*/
	
	var buyerPONo = "";
	try
	{
		buyerPONo = document.getElementById("cbopono").value;
	}
	catch(err)
	{
		buyerPONo = "#Main Ratio#"
	}
	var styleNo = document.getElementById('lblStyleNo').innerHTML;	
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        var matDetails        =   strBomDetail[0];
	
        if(matDetails=="FAB"){
            loadRatioReview(styleNo,buyerPONo,itemID);
        }   
	createNewXMLHttpRequest(1);
	xmlHttpreq[1].onreadystatechange = HandleLoadingMatRatio;
	xmlHttpreq[1].open("GET", 'bomMiddletire.php?RequestType=GetMatRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&ItemID=' + itemID , true);
	xmlHttpreq[1].send(null);
}

function HandleLoadingMatRatio()
{
	if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        {  
			 var XMLStyleID 	= xmlHttpreq[1].responseXML.getElementsByTagName("StyleNo");
			 var XMLBuyerPO 	= xmlHttpreq[1].responseXML.getElementsByTagName("BuyerPONo");
			 var XMLColor 		= xmlHttpreq[1].responseXML.getElementsByTagName("Color");
			 var XMLSize 		= xmlHttpreq[1].responseXML.getElementsByTagName("Size");
			 var XMLQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("Qty");

			 
			  var XMLyyCon 		= xmlHttpreq[1].responseXML.getElementsByTagName("yyCon");
			  var XMLwastage	= xmlHttpreq[1].responseXML.getElementsByTagName("wastage");
			  var XMLmoq    	= xmlHttpreq[1].responseXML.getElementsByTagName("moq");
			  
//Start 31-03-2010 - bookmark
			 var XMLBalQty		= xmlHttpreq[1].responseXML.getElementsByTagName("BalQty");
			 var XMLPoQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("PoQty");
			 var XMLtotPoQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("totPoQty");
			 var XMLinterJobQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("interJobQty");
			 var XMLyyPermission 	= xmlHttpreq[1].responseXML.getElementsByTagName("PermissionAllowed");
             var XMLwastePermission= xmlHttpreq[1].responseXML.getElementsByTagName("PermissionAllowedWaste");
			  
			 
			 var XMLColorPoDone = xmlHttpreq[1].responseXML.getElementsByTagName("ColorPoDone");
			 var XMLSizePoDone 	= xmlHttpreq[1].responseXML.getElementsByTagName("SizePoDone");
//End 31-03-2010

			 var colorIndex = 0;
			 var sizeIndex 	= 0;
			 var colors	 	= [];
			 var sizes 		= [];
			 var Qtys 		= [];			 
			 
//Start 31-03-2010 - bookmark
			 var PoQty_loop			= [];
			 var totPoQty_loop			= [];
			 var interJobQty_loop			= [];
			 var colorPoDone_loop	= [];
			 var sizePoDone_loop	= [];
			 var POQty_Colsize = new Array;//hem--17-11-2011
			 var Qty_Colsize = new Array;
			 var yyCons             = [];
             var yyCons_array       = [];
             var westage_array      = [];
             var moq_array          = [];
            //alert("doc = "+document.cookie);

	var buyerPONo = "";
	try
	{
		buyerPONo = document.getElementById("cbopono").value;
	}
	catch(err)
	{
		buyerPONo = "#Main Ratio#"
	}
                                
             // var yyCon_Colsize=new Array;
			 var interJobQty_Colsize = new Array;
//End 31-03-2010			 
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var color  = XMLColor[loop].childNodes[0].nodeValue;
				var size = XMLSize[loop].childNodes[0].nodeValue;
                                var wastage =XMLwastage[loop].childNodes[0].nodeValue;
                                //alert("color="+color+" wastage= "+wastage+"/"+ XMLStyleID.length+"/"+"Loop="+loop);
                                var moq =XMLmoq[loop].childNodes[0].nodeValue;
				
				Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
				editYY=XMLyyPermission[loop].childNodes[0].nodeValue;
				editWaste=XMLwastePermission[loop].childNodes[0].nodeValue;
				//alert("Color - " + color + " Size - " + size + " Qty " + XMLQty[loop].childNodes[0].nodeValue);
//Start 31-03-2010 - bookmark		
				//alert(XMLPoQty[loop].childNodes[0].nodeValue);		
				PoQty_loop[loop] = XMLPoQty[loop].childNodes[0].nodeValue;
				totPoQty_loop[loop] = XMLtotPoQty[loop].childNodes[0].nodeValue;
				interJobQty_loop[loop] = XMLinterJobQty[loop].childNodes[0].nodeValue;
				//alert(XMLtotPoQty[loop].childNodes[0].nodeValue);
				colorPoDone = XMLColorPoDone[loop].childNodes[0].nodeValue;
				sizePoDone = XMLSizePoDone[loop].childNodes[0].nodeValue;
//End 31-03-2010				
				if(!findItem(color,colors))
				{
					POQty_Colsize[colorIndex] = new Array;//hem
					interJobQty_Colsize[colorIndex] = new Array;//hem
					yyCons_array[colorIndex] = new Array;
					Qty_Colsize[colorIndex] = new Array;//hem
					colors[colorIndex] = color;
					westage_array[colorIndex]= wastage;
                    moq_array[colorIndex]= moq;
					colorPoDone_loop[colorIndex] = colorPoDone; /*31-03-2010 - bookmark*/
					colorIndex ++;
				}

				if(!findItem(size,sizes))
				{
					sizes[sizeIndex] = size;
					sizePoDone_loop[sizeIndex] = sizePoDone;	/*31-03-2010 - bookmark*/
					sizeIndex ++;
				}
			
			
			 }
			 
			 
					for (x in colors)//hem
					{
						for (i in sizes)
						{
							 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
							 {
								var color  = XMLColor[loop].childNodes[0].nodeValue;
								var size = XMLSize[loop].childNodes[0].nodeValue;
								Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
								PoQty_loop[loop] = XMLPoQty[loop].childNodes[0].nodeValue;
								totPoQty_loop[loop] = XMLtotPoQty[loop].childNodes[0].nodeValue;
								
								interJobQty_loop[loop] = XMLinterJobQty[loop].childNodes[0].nodeValue;
								yyCons[loop] = XMLyyCon[loop].childNodes[0].nodeValue;
								
								if(colors[x]==color && (sizes[i]==size)){
										POQty_Colsize[x][i]=totPoQty_loop[loop];
										interJobQty_Colsize[x][i]=interJobQty_loop[loop];
										Qty_Colsize[x][i]=Math.round(Qtys[loop]);
										
								}
							 }
								if(Qty_Colsize[x][i]>0){
								}
								else{
										POQty_Colsize[x][i]=0;
										interJobQty_Colsize[x][i]=0;
										Qty_Colsize[x][i]=0;
								}
						}
					}
					
						 var bomDetail         =   document.getElementById('matDetail').value;
                         var strBomDetail      =   bomDetail.split("|");
                         var matDetails        =   strBomDetail[0];
                         var bomWastage        =   strBomDetail[2];
                         //alert(bomWastage);
			 
			 //alert(sizes.length);
			 // ---------------------------------------
			 
			 var tablewidth = 450 + (7 * sizes.length);
		
			// Create The table header
			var HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			var y = 0;
			for (i in sizes)

			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id="+sizePoDone_loop[y]+"><div align=\"center\">" + sizes[i] + "</div></td>";
				y++; 											/*31-03-2010 - bookmark*/
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td id="+colorPoDone_loop[x]+" class=\"normalfnt\">" + colors[x] + "</td>" ;
				for (i in sizes)
				{
				 if(matDetails=='FAB' && buyerPONo!='#Main Ratio#'){
                                        
                                        HTMLText += "<td id="+POQty_Colsize[x][i]+"><div id="+interJobQty_Colsize[x][i]+" align=\"center\">" +
                                        "<input name=\"txtratio\" disabled type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" class=\"txtbox\" value=\"" + Qty_Colsize[x][i] + "\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
                                        "</div></td>";
                                        }
					else
					{
						HTMLText += "<td id="+POQty_Colsize[x][i]+"><div id="+interJobQty_Colsize[x][i]+" align=\"center\">" +
						"<input name=\"txtratio\"  type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" class=\"txtbox\" value=\"" + Qty_Colsize[x][i] + "\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
						"</div></td>";
					}
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\">Total</td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
			
			// -----------------------------------------------------------		
			
			document.getElementById("divQtyRatio").innerHTML = HTMLText;

            // <mig>............................  
                      
                       var HTMLTextYY = "";
			HTMLTextYY += "<table width=\"" + tablewidth + "\" id=\"tblYY\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			var y = 0;
			for (i in sizes)
                              //  alert(sizePoDone_loop[y]);
			{
				HTMLTextYY += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id="+sizePoDone_loop[y]+"><div align=\"center\">" + sizes[i] + "</div></td>";
				y++; 											/*31-03-2010 - bookmark*/
			}
			
			HTMLTextYY += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Wastage %</div></td>" +
                                        "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">&nbsp</td>" +
                                        "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">MOQ/MCQ</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLTextYY += "<tr>" +
							"<td id="+colorPoDone_loop[x]+" class=\"normalfnt\">" + colors[x] + "</td>" ;
				for (i in sizes)
				{
                                    yyCons_array[x][i] = Math.round(yyCons[loopindex]);
                                    yyCons_array[x][i] = yyCons[loopindex]; 
                                     
                                     //alert(yyCons_array[x][i]);
                                     if(yyCons_array[x][i]<=0 || ''){
                                         yyCons_array[x][i]=0;
                                     }
                                     
                    
                                        if(editYY==1){
					HTMLTextYY += "<td id="+POQty_Colsize[x][i]+"><div id="+interJobQty_Colsize[x][i]+" align=\"center\">" +
								"<input name=\"yy\" type=\"text\"  class=\"txtbox;\" value=\"" +yyCons_array[x][i]+ "\"  onkeyup=\"calConsuption(this);\" onkeyup=\"ChangeCellValue(this);\"  onblur=\"ValidateWithPoQtyCon(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"   onkeypress=\"return isNumberKey(event);\" id=\"yy" + x + "" + i + "|"+Qty_Colsize[x][i]+"\" size=\"7\" />" +
								"</div></td>";
                                        }
                                        else
                                        {
                                        HTMLTextYY += "<td id="+POQty_Colsize[x][i]+"><div id="+interJobQty_Colsize[x][i]+" align=\"center\">" +
								"<input name=\"yy\" type=\"text\"  class=\"txtbox;\" value=\"" +yyCons_array[x][i]+ "\" disabled onkeyup=\"calConsuption(this);\" onkeyup=\"ChangeCellValue(this);\"  onblur=\"ValidateWithPoQtyCon(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"   onkeypress=\"return isNumberKey(event);\" id=\"yy" + x + "" + i + "|"+Qty_Colsize[x][i]+"\" size=\"7\" />" +
								"</div></td>";  
                                            
                                        }
                                                    
                                      //  HTMLTextYY += "<td><input type=\"text\" value=\""+moq+"\" class=\"txtbox\" id=\"moq" + x + "\" size=\"7\" />"+ 
                                                   //             "</td>";
                                      			
					loopindex ++;
				}
				
				//HTMLTextYY += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">xcxcx %" +
                	//"</td>" +
                        var sizeLenth=sizes.length;
                        
                       //alert(bomWastage);
                           if(westage_array[x]>0){
                               westage_array[x]=westage_array[x]; 
                            }
                            else{
                               westage_array[x]=bomWastage; 
                               //alert(arrayWastege[x]);
                            }
                            
                        if(editWaste==1)
                            {
                            HTMLTextYY += "<td><input type=\"text\"  class=\"txtbox\" value=\""+westage_array[x]+"\"  onkeyup=\"calcWestage(this); ChangeCellValueCon(this); ValidateWithPoQtyCon(this);\"  id=\"wast" + x + "\" size=\"7\" />"+ 
                                          "</td>"+
                                          "<td class=\"normalfntRite\">&nbsp</td>" +
                                   "<td><input type=\"text\" value=\""+moq_array[x]+"\" class=\"txtbox\" id=\"moq" + x + "\" size=\"7\" />"+ 
                                      "</td>"+
                            "</tr>" ;
                            }
                            else
                            {
                               HTMLTextYY += "<td><input type=\"text\"  class=\"txtbox\" disabled value=\""+westage_array[x]+"\"  onkeyup=\"calcWestage(this); ChangeCellValueCon(this); ValidateWithPoQtyCon(this);\"  id=\"wast" + x + "\" size=\"7\" />"+ 
                                          "</td>"+
                                          "<td class=\"normalfntRite\">&nbsp</td>" +
                                   "<td><input type=\"text\" value=\""+moq_array[x]+"\" class=\"txtbox\" id=\"moq" + x + "\" size=\"7\" />"+ 
                                      "</td>"+
                            "</tr>" ; 
                            }
                            
			}
			
                 if(matDetails=="FAB"){
                        document.getElementById("yy").innerHTML = HTMLTextYY;

                    }        
   
		}
	} 
        
        //loadRatioReview();

               
			
    // </mig>...................


	doLoadCalculation();
}
// ----------------------------------------------------------------------------


function loadRatioReview(styleNo,buyerPONo,itemID){

    	  var bomURL 		= "bomMiddletire.php?RequestType=loadRR&styleNo=" + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + "&ItemID=" + itemID;
	  var htmlRatioObj 	= $.ajax({url:bomURL, async:false});
          
          // var ratioCount	= htmlRatioObj.responseXML.getElementsByTagName("ratiocount")[0].childNodes[0].nodeValue;	
            var XMLStyleID 	= htmlRatioObj.responseXML.getElementsByTagName("StyleNo");
            var XMLBuyerPO 	= htmlRatioObj.responseXML.getElementsByTagName("BuyerPONo");
            var XMLColor 	= htmlRatioObj.responseXML.getElementsByTagName("Color");
            var XMLSize 	= htmlRatioObj.responseXML.getElementsByTagName("Size");
            var XMLQty 		= htmlRatioObj.responseXML.getElementsByTagName("Qty");
            var XMLSerial       = htmlRatioObj.responseXML.getElementsByTagName("serialNo");
            
            var sizeIndex 	= 0;
            var colorIndex      = 0;
	    var sizes 		= [];
            var colors	 	= [];
            var Qtys 		= [];
            var Qty_Colsize     = new Array;
            var rrNos            = [];
        
    for ( var loop = 0; loop < XMLStyleID.length; loop ++)
                {
                       var color    = XMLColor[loop].childNodes[0].nodeValue;
                       var size     = XMLSize[loop].childNodes[0].nodeValue;
                       var rrNo      = parseInt(XMLSerial[loop].childNodes[0].nodeValue);
                       
                        Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
                                          
					Qty_Colsize[colorIndex] = new Array;//hem
                                        colors[colorIndex] = color;
                                        rrNos[colorIndex]  = rrNo;
                                        colorIndex ++;
                                       
				
                                
                        if(!findItem(size,sizes))
				{
					sizes[sizeIndex] = size;
					sizeIndex ++;
				}

//                        if(!findItem(color,colors))
//				{
//					Qty_Colsize[colorIndex] = new Array;//hem
//                                        colors[colorIndex] = color;
//                                        colorIndex ++;
//				}
//                                
//                        if(!findItem(size,sizes))
//				{
//					sizes[sizeIndex] = size;
//					sizeIndex ++;
//				}
                                
                }
                
                
                
                for (x in colors)//hem
                {
                        for (i in sizes)
                        {
                                 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
                                 {
                                        var color  = XMLColor[loop].childNodes[0].nodeValue;
                                        var size = XMLSize[loop].childNodes[0].nodeValue;
                                         

                                        Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
                                        //alert(Qtys[loop]);    

                                        if(colors[x]==color && (sizes[i]==size)){
                                                Qty_Colsize[x][i]=Math.round(Qtys[loop]);
                                                //alert(Qty_Colsize[x][i]);
                                        }
                                 }
                                        if(Qty_Colsize[x][i]>0){
                                        }
                                        else{
                                                Qty_Colsize[x][i]=0;

                                        }
                        }
                }

                                        
                                        
                var tablewidth = 450 + (7 * sizes.length);
    // Create The table header
			var HTMLTextRR = "";
			HTMLTextRR += "<table width=\"" + tablewidth + "\" id=\"tblRR\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);

			var y = 0;
			for (i in sizes)
                        {
				HTMLTextRR += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id="+y+"><div align=\"center\">" + sizes[i] + "</div></td>";
				y++; 											/*31-03-2010 - bookmark*/
			}
                              "</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
                          
                       var review=1;
			for (x in colors)
			{
                           
                            
                            if(rrNos[x]==0){
                                
                                 HTMLTextRR += "<tr>" +
                                                           "<td class=\"normalfnt\"><u>Ratio Review 0"+review+"</u></td>" +
                                            "<tr>";
                                    review++;
                                  
                             }
                             
				HTMLTextRR += "<tr>" +
							"<td id="+x+" class=\"normalfnt\">" + colors[x]+ "</td>" ;
				for (i in sizes) 
				{
                                   // console.log(colors[x][i]);
                                        HTMLTextRR += "<td id="+[x][i]+"><div id="+colors[x][i]+" align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\"  class=\"txtbox\" value=\"" + Qtys [x] + "\"  id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>"+
                                                 "<tr>";  
                                    
					loopindex ++;
				}
                                  
			}
              
                        document.getElementById("rr").innerHTML = HTMLTextRR;
}


//<mig> 29/6/2016.............



function calcWestage(val)
{

    var posId             =   val.id;
    var orderQty          =   parseFloat(document.getElementById('txtorderqty').value);
    var bpo_Qty           =   parseFloat(document.getElementById('bpo_Qty').value);
    var bpo_QtyWithWestage=   parseFloat(document.getElementById('txttotalorder').value);


    var westage           =   parseFloat(document.getElementById(""+posId+"").value);
    var rowId             =   parseFloat(posId.charAt(4)); 
    var tblQty 		  =   document.getElementById("tblYY");
    var tblRatio          =   document.getElementById('tblQtyRatio');
    var cellLength        =   parseFloat(tblQty.rows[rowId+1].cells.length);
    var tr                =   tblRatio.rows[tblRatio.rows.length-1];
    
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        var bomWaste        =   parseFloat(strBomDetail[2]);
    //alert("w="+westage+" bomWaste ="+bomWaste);
    if(westage<=bomWaste){
    var totRatioQty       =   parseFloat(tblRatio.rows[tblRatio.rows.length-1].cells[tr.cells.length -1].lastChild.lastChild.nodeValue);
    //alert(cellLength)
    document.getElementById('balQty').innerHTML="Balance Qty = "+(bpo_QtyWithWestage-totRatioQty);
    //balQtyX
        for(var i=1; i<cellLength-3; i++)
        {
            //alert(tblQty.rows[rowId+1].cells[i].lastChild.lastChild.value);
           var consuption         =   parseFloat(tblQty.rows[rowId+1].cells[i].lastChild.lastChild.value);//0.0009
           var qtyWithCon         =   bpo_Qty*consuption;//
           var westQty     = (qtyWithCon*westage)/100;
           var qtyWithWest =  Math.round(qtyWithCon+westQty);
            
           tblRatio.rows[rowId+1].cells[i].lastChild.lastChild.value = qtyWithWest;
          
        }
         //alert(tblRatio.rows[tblRatio.rows.length-1].cells[tr.cells.length -1].lastChild.lastChild.nodeValue);
     }
     else
     {
         alert("Maximum Wastage Percentage limit Is "+bomWaste+"%");
        
        westage=bomWaste;
        document.getElementById(""+posId+"").value=westage;
         var totRatioQty       =   parseFloat(tblRatio.rows[tblRatio.rows.length-1].cells[tr.cells.length -1].lastChild.lastChild.nodeValue);
    //alert(cellLength)
    document.getElementById('balQty').innerHTML="Balance Qty = "+(bpo_QtyWithWestage-totRatioQty);
    //balQtyX
        for(var i=1; i<cellLength-3; i++)
        {
            //alert(tblQty.rows[rowId+1].cells[i].lastChild.lastChild.value);
           var consuption         =   parseFloat(tblQty.rows[rowId+1].cells[i].lastChild.lastChild.value);//0.0009
           var qtyWithCon         =   bpo_Qty*consuption;//
           var westQty     = (qtyWithCon*westage)/100;
           var qtyWithWest =  Math.round(qtyWithCon+westQty);
            
           tblRatio.rows[rowId+1].cells[i].lastChild.lastChild.value = qtyWithWest;
          
        }
     }
}

function calConsuption(val)
{
   var consuption        =   parseFloat(val.value);
   var posId             =   val.id;
   var westId            =   "wast"+posId.charAt(2);
   var westage           =   parseFloat(document.getElementById(""+westId+"").value);
   var totQty            =   parseFloat(document.getElementById('txttotalorder').value);
   var orderQty          =   parseFloat(document.getElementById('txtorderqty').value);
   var bpo_Qty           =   parseFloat(document.getElementById('bpo_Qty').value);
//   var bomDetail         =   document.getElementById('matDetail').value;
//   var strBomDetail      =   bomDetail.split("|");
//   var bomCon            =   parseFloat(strBomDetail[1]);

    
   
    //alert("westage="+westage+" bomCon="+bomCon+" bpoQty="+bpo_Qty);
   
   var colSizeWiseQty    =   consuption*bpo_Qty;
   var westageQty        =   (colSizeWiseQty*westage)/100; 
   

   
   
   //alert("matDetails = " +matDetails+"bomCon " +bomCon+" OdrQty = "+OdrQty);

   var pos               =   posId.substring(2);
   var tmpRatioId        =   "txtratio"+pos;
   var tmp2ratioId       =   tmpRatioId.split("|");
   var ratioId           =   tmp2ratioId[0];
   var ratioQty          =   parseFloat(document.getElementById(""+ratioId+"").value);
  // alert("ratioId = "+ratioId); 
   var qtyWithWestage    =   colSizeWiseQty+westageQty;
   
   document.getElementById(""+ratioId+"").value =  Math.round(qtyWithWestage);

    var poQty 	 = parseFloat(val.parentNode.parentNode.id);
    var jobqty = parseFloat(val.parentNode.id);
    //alert("ratio Id = "+ratioId+" ratio Qty = "+ ratioQty+" poQty = "+poQty+" jobQty = "+jobqty);                 
                			
}


//</mig> 29/6/2016.............
function SaveMaterialRatio(itemCode)
{
	if (isValidMaterialRatio(itemCode))
	{
		ShowPreLoader();		
		PrepairMatRatioDatabase(itemCode);
	}
}

function PrepairMatRatioDatabase(itemCode)
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").value;

	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleMatRatioSaving;
	xmlHttp.itemCode = itemCode;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=DelMatRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&matID=' + itemCode , true);
    xmlHttp.send(null); 
}

function HandleMatRatioSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			StartMatSaving(xmlHttp.itemCode);
		}
	}
}

function StartMatSaving(itemCode)
{
	var tblQty 		= document.getElementById("tblQtyRatio");
        
        var bpoQty      =   $("#bpo_Qty1").val();
       
        
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        var bomMaterial       =   strBomDetail[0];
        
        var e = document.getElementById("cboSR");
        var scNo = e.options[e.selectedIndex].text;
        
        var bpo = document.getElementById("cbopono");
        var bpoNo = bpo.options[bpo.selectedIndex].value;
        
        //var scNo=
        
        var yyQty       = 0;
        var wastId      = 0;
        var wastage     = 0;  
        var moqId       = 0;
        var moq         = 0;
        var IsFabric    = 0;
          if(bomMaterial=='FAB'){
                IsFabric = 1;
           	var tblYY     = document.getElementById("tblYY");
                var y         = parseFloat(tblYY.rows[1].cells.length)-3;  
                //alert(y);     
              
            } // Fabric Condition
	var styleId 	= document.getElementById('lblStyleNo').innerHTML;
	//var tblEx = document.getElementById("tblEXQtyRatio");
	var incr 		= 0;
	requestCount 	= 0;
	matincr	 		= 0;
	pub_ResponceCount = 0;
	checkLoop 		= 0;
	
	var booRatioExist = false;
	//==================================================
	// Add On - 11/16/2015
	// Add By - Nalin Jayakody
	// Add For - Check initial material ratio exist in the materialratio_template.
	//==================================================
	  var bomURL 		= "bomMiddletire.php?RequestType=CheckRatio&styleNo=" + URLEncode(styleId) + "&itemCode=" + itemCode;
	  var htmlRatioObj 	= $.ajax({url:bomURL, async:false});
      var ratioCount	= htmlRatioObj.responseXML.getElementsByTagName("ratiocount")[0].childNodes[0].nodeValue;	
	  
	  if(ratioCount != '0'){booRatioExist = true;}	
	  	 
	//==================================================
	
	for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
	{
		for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
		{
			var styleNo 	= document.getElementById('lblStyleNo').innerHTML;
			var buyerPONo 	= document.getElementById("cbopono").value;
			var b 			= tblQty.rows[loop].cells[i];
			var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
			var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
			var sizeserial = tblQty.rows[0].cells[i].id;
			var qty = tblQty.rows[loop].cells[i].lastChild.lastChild.value;
                       
			//var exQty = tblEx.rows[loop].cells[i].lastChild.lastChild.value;			
   // alert("moq = "+moq+" moqId = "+moqId+" wastId = "+wastId+" wastage = "+wastage);
                        if(bomMaterial=='FAB'){
                           yyQty       = tblYY.rows[loop].cells[i].lastChild.lastChild.value;
                           wastId      = tblYY.rows[loop].cells[y].lastChild.id;
                           //alert("AA"+tblYY.rows[loop].cells[y+2].lastChild.id);
                           wastage     =  parseFloat(document.getElementById(""+wastId+"").value);
                           moqId     = tblYY.rows[loop].cells[y+2].lastChild.id;
                           moq =   parseFloat(document.getElementById(""+moqId+"").value);
                             //alert("moq = "+moq+" moqId = "+moqId+" wastId = "+wastId+" wastage = "+wastage)
                           //alert(qty);
                           
                           // ======================================================================
                           // Add On - 2016/12/18
                           // Add By - Nalin Jayakody
                           // Add For - Re-calculate fabric requirement based on YY and wastage while saving the materail ratio.
                           // ======================================================================
                           var dblReqQty  = parseFloat(bpoQty * yyQty);
                           var dblWastage = parseFloat((dblReqQty/100)*wastage);
                           var dblTotReq  = Math.ceil((dblReqQty + dblWastage)); 
                           
                           tblQty.rows[loop].cells[i].lastChild.lastChild.value = dblTotReq;
                           // ======================================================================
                           
                        }
			// userID
			
			// ========================================================================
			// Add On - 11/16/2015
			// Add By - Nalin Jayakody
			// Add For - if material ratio template  not exist add to the template
			// ========================================================================
				if(booRatioExist==false){
					var urlRatio = "bomMiddletire.php?RequestType=SaveRatioTemplate&styleNo=" + URLEncode(styleNo) + "&itemCode=" + itemCode+"&buyerpo="+URLEncode(buyerPONo)+"&color="+URLEncode(color)+"&size="+URLEncode(size)+"&sequnce="+incr;	
					var htmlObj = $.ajax({url:urlRatio, async:false});
				}
			
			
			
			// ========================================================================
			
			
			requestCount ++ ;
			createNewXMLHttpRequest(incr);
			//xmlHttpreq[i].onreadystatechange = HandleStyleRatioRequest;
			//xmlHttpreq[i].index = i;
			//xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&posID=' + (loop -1 ) + '&freight=' + qty + '&sizeserial=' + incr+'&yyQty='+yyQty+'&wastage='+wastage+'&moq='+moq, true);
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&posID=' + (loop -1 ) + '&freight=' + qty + '&sizeserial=' + incr+'&yyQty='+yyQty+'&wastage='+wastage+'&moq='+moq+'&isFabric='+IsFabric, true);
			xmlHttpreq[incr].send(null);
			incr ++ ;	
			pub_ResponceCount++;
			if (color != "N/A" || size != "N/A")
			{
				curObj.parentNode.parentNode.parentNode.className="backcolorGreen";
			}
			
		}		
	}
        var bomURL2 		= "bomMiddletire.php?RequestType=mailSend&scNo=" +scNo+ "&itemCode=" + itemCode+ "&styleNo=" + styleId+ "&bpoNo=" + bpoNo;
	  var htmlRatioObj 	= $.ajax({url:bomURL2, async:false});
          //alert(htmlRatioObj.responseText)
		  
	ValidateMaterialRatioTransfer(itemCode,pub_ResponceCount);
	//alert("The material ratio has been saved successfully.");
	//ClosePreloader();	
}
//Start 16-06-2010 - get material ratio responce
function ValidateMaterialRatioTransfer(matDetailId,pub_ResponceCount)
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").value;

	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleMaterialRatioAckmowledgement;
	xmlHttp.index = matDetailId;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=ValidateMaterialRatioTransfer&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&matDetailId=' +matDetailId+ '&Matrequest=' + pub_ResponceCount , true);
    xmlHttp.send(null); 
}

function HandleMaterialRatioAckmowledgement()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var itemCode = xmlHttp.index;
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			var result = XMLResult[0].childNodes[0].nodeValue;
			if (result == "True")
			{
				ClosePreloader();
				alert("The material ratio has been saved successfully.");
			}
			else
			{
				checkLoop++;
				if(checkLoop>100){
					alert("Sorry!\nError occured while saving the data. Please Save it again.");
					ClosePreloader();
					checkLoop = 0;
					return;
				}
				else{
					ValidateMaterialRatioTransfer(itemCode,pub_ResponceCount);
				}				
			}
		}
	}
}
//End 16-06-2010 - get material ratio responce

function isValidMaterialRatio(itemId)
{
   var tblQty = document.getElementById("tblQtyRatio");
    var tblYY = document.getElementById("tblYY");
    var bpoNo = document.getElementById('cbopono').value;
    var styleId = document.getElementById('lblStyleNo').innerHTML;
    
    var totYY = 0;
    
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        
        var bomMaterial       =   strBomDetail[0];
        var bomCon            =   parseFloat(strBomDetail[1]).toFixed(4);
     
          if(bomMaterial=='FAB'){
             
            for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
                {
                        for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
                        {
                            var yyQty       = parseFloat(tblYY.rows[loop].cells[i].lastChild.lastChild.value);
                            var totYY       = parseFloat(totYY+yyQty) ;
                            //alert("yyQty="+yyQty+"totYY="+totYY);
                           
                        }
                }
                var variance    = (bomCon-totYY).toFixed(4);
                var orderqty    = parseFloat(document.getElementById('txtorderqty').value);
                var variYY      = (orderqty*variance).toFixed(0);
                var positiveVal = Math.abs(variYY);
                //bomCon<totYY
                if(bpoNo=='#Main Ratio#'){
                    var odrQty=parseFloat(document.getElementById('txttotalorder').value);
                    var ratioqty = parseInt(tblQty.rows[tblQty.rows.length-1].cells[tblQty.rows[0].cells.length -1].lastChild.lastChild.nodeValue,10);
                   // alert("odrQty = "+odrQty+" ratioqty="+ratioqty);
                    if (odrQty < ratioqty)
                    {
                        alert("The Ratio Qty is not correct.\n Variance is : " +(odrQty-ratioqty));
                        return false;
                    }
                    // if (totYY <= 0 || positiveVal>1){
                   // alert("The Yardage Yield is not correct.\n Variance is : " +variance);
                   // return false;
                   // }
                   //isValidRatio()
                }else{
                    var url ='bomMiddletire.php?RequestType=chkBpoCon&styleId='+styleId+ '&bpoNo=' + bpoNo + '&itemId=' + itemId;
                      
                    var htmlobj    = $.ajax({url:url,async:false});
                    var sumOfConExist   = parseFloat(htmlobj.responseText);
                    var sumOfCon        = parseFloat(sumOfConExist+totYY).toFixed(4);
                    //alert(sumOfCon);
                    //alert("sumOfCon = "+sumOfCon+" bomCon = "+bomCon+" sumOfConExist = "+sumOfConExist+" totYY = "+totYY+" diff = "+(bomCon-sumOfCon));
                    
                    // ============================================================================================ 
                    // Comment By - Nalin Jayakody
                    // Comment On - 10/12/2016
                    // Comment For - Temprorary allow user to exceed consumption over by costing. Need to put with user right
                    // Un Comment - 12/06/2016
                    // Un Comment - 02/13/2016
                    // 
                    // ============================================================================================
                     if (bomCon < sumOfCon){
                        alert("The Yardage Yield is Not correct.\n Variance is : " +(bomCon-sumOfCon).toFixed(4));
                        return false; 
                    }
                    // ============================================================================================
                }
                
           
                return true;
            }
            else{            
                 
	var matQty = parseInt(document.getElementById("txttotalorder").value,10);
	var tblQty = document.getElementById("tblQtyRatio");
	var ratioqty = parseInt(tblQty.rows[tblQty.rows.length-1].cells[tblQty.rows[0].cells.length -1].lastChild.lastChild.nodeValue,10);
	if (ratioqty <= 0 || matQty != ratioqty)
		{
		
		alert("The material ratio is not correct.\n Variance is : " +(matQty-ratioqty));	
		return false;
	}
	
	
	return true;
			}
}

function ScrollToElement(x,y)
{
 	window.scrollTo(x,y);
	document.getElementById("cboPos").focus();
}

function AddNewColor()
{
	if (document.getElementById("txtnewcolor").value == "")
	{
		alert("Please enter the color name.");
		document.getElementById("txtnewcolor").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbocolors").options.length ; i++) 
	{
		if ( document.getElementById("cbocolors").options[i].text.toUpperCase() == document.getElementById("txtnewcolor").value.toUpperCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtnewcolor").value,document.getElementById("cboselectedcolors"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbocolors").options[i].text;
				optColor.value = document.getElementById("cbocolors").options[i].text;
				document.getElementById("cboselectedcolors").options.add(optColor);

				document.getElementById("cbocolors").options[i] = null;
				
				added =true;
			}
					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtnewcolor").value,document.getElementById("cboselectedcolors"),false))
			SaveColor(document.getElementById("txtnewcolor").value.toUpperCase());
		else
			alert("The color already exists.");
	}
}	

function SaveColor(colorName)
{
	var buyer = document.getElementById("cboBuyer").value;
	var division = document.getElementById("cboDivision").value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleColorSaving;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=AddNewColor&colorName=' + URLEncode(colorName) + '&buyer=' + buyer + '&division=' + division , true);
    xmlHttp.send(null); 
}

function HandleColorSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var optColor = document.createElement("option");
			optColor.text = document.getElementById("txtnewcolor").value.toUpperCase();
			optColor.value = document.getElementById("txtnewcolor").value.toUpperCase();
			document.getElementById("cboselectedcolors").options.add(optColor);
			document.getElementById("txtnewcolor").value = "";
		}
	}
}

function grabColorEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode== 13)
	 	AddNewColor();
}

function AddNewSize()
{
	if (document.getElementById("txtnewSize").value == "")
	{
		alert("Please enter the size name.");
		document.getElementById("txtnewSize").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbosizes").options.length ; i++)
	{
		if ( document.getElementById("cbosizes").options[i].text.toUpperCase() == document.getElementById("txtnewSize").value.toUpperCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbosizes").options[i].text;
				optColor.value = document.getElementById("cbosizes").options[i].text;
				document.getElementById("cboselectedsizes").options.add(optColor);

				document.getElementById("cbosizes").options[i] = null;
				
				added =true;
				var count = document.getElementById("cbosizesnumbsrial").options.length;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
			}
					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
		{
			var count = document.getElementById("cbosizesnumbsrial").options.length;
	/*for(var i = 0; i < document.getElementById("cboselectedsizes").options.length; i++)
	{*/
		//count++;
				var optColor1 = document.createElement("option");
				optColor1.value = count++;
				document.getElementById("cbosizesnumbsrial").options.add(optColor1);
				SaveSize(document.getElementById("txtnewSize").value.toUpperCase());
	}
		else
			alert("The size already exists.");
	}
}	

function getnumberserial()
{ 

	
				

}
function grabSizeEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode== 13)
	 	AddNewSize();
}

function SaveSize(SizeName)
{
	//alert(number);
	var buyer = document.getElementById("cboBuyer").value;
	var division = document.getElementById("cboDivision").value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleSizeSaving;
    xmlHttp.open("GET", 'bomMiddletire.php?RequestType=AddNewSize&SizeName=' + URLEncode(SizeName) + '&buyer=' + buyer + '&division=' + division , true);
    xmlHttp.send(null); 
}

function HandleSizeSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var optColor = document.createElement("option");
			optColor.text = document.getElementById("txtnewSize").value.toUpperCase();
			optColor.value = document.getElementById("txtnewSize").value.toUpperCase();
			document.getElementById("cboselectedsizes").options.add(optColor);
			document.getElementById("txtnewSize").value = "";
		}
	}
}

function showDeliveryForm()
{
	drawPopupAreaLayer(800,270,'frmDeliverySchedule',1);

	var HTMLText = "<table width=\"800\" border=\"0\">" +
				  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmDeliverySchedule'),event);\">"+
					"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Delivery schedule</td>"+
				  "</tr>"+
				  "<tr>"+
					"<td height=\"203\" valign=\"top\"><div style=\"overflow:scroll;height:200px;\"><table  width=\"100%\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblDelivery\">"+
						"<tr>"+
						  "<td height=\"20\" colspan=\"9\" bgcolor=\"#9BBFDD\"><div align=\"center\" class=\"normalfnth2\"></div></td>"+
						  "<td height=\"20\" bgcolor=\"#9BBFDD\" colspan=\"2\"><div align=\"right\" ><a href=\"#\"><img src=\"images/add-new.png\" width=\"109\" height=\"18\" border=\"0\" onclick=\"ShowAddDeliverySchedule();\" /></a></div></td>"+
						"</tr>"+
						"<tr>"+
					 /* "<td width=\"6%\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Edit</td>"+
					  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
					  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Delivery Date</td>"+
					  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty.</td>"+
					  "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">With Ex. Qty</td>"+
					  "<td width=\"16%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipping Mode</td>"+
					  "<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
					  "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" >Lead Time </td>"+
						"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Estimated Date </td>"+*/
						"<td width=\"4%\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Edit</td>"+
					  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
					  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Delivery Date</td>"+
					  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty.</td>"+
					  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">With Ex. Qty</td>"+
					  "<td width=\"16%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipping Mode</td>"+
					  "<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
					  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">BPO</td>"+
					  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Estimated Date</td>"+
					  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Hand Over Date</td>"+
					  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Ref. No.</td>"+
					"</tr>"+
					  "</table>"+
				"</td>"+
				  "</tr>"+
				  "<tr>"+
					"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
						"<td width=\"25%\">&nbsp;</td>"+
						"<td width=\"29%\">&nbsp;</td>"+
						"<td width=\"21%\">&nbsp;</td>"+
						"<td width=\"25%\"><img src=\"images/close.png\" class=\"mouseover\" onClick=\"closeLayer();removeGarbage();\" alt=\"Close\" width=\"97\" height=\"24\" /></td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";
				
	document.getElementById('frmDeliverySchedule').innerHTML=HTMLText;	
	LoadSavedSchedules();
}

function removeGarbage()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	fourthxmlHttp.onreadystatechange = HandleSavedSchedules;
	fourthxmlHttp.open("GET", 'preordermiddletire.php?RequestType=ClearEventScheduleGarbage&StyleNo=' + URLEncode(styleNo), true);
	fourthxmlHttp.send(null);	
}

function LoadSavedSchedules()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	createtFourthXMLHttpRequest();
	fourthxmlHttp.onreadystatechange = HandleSavedSchedules;
	fourthxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getDeliveryData&StyleID=' + URLEncode(styleNo), true);
	fourthxmlHttp.send(null);	
}

function HandleSavedSchedules()
{
	if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        { 
			var XMLDateofDelivery = fourthxmlHttp.responseXML.getElementsByTagName("DateofDelivery");
			var XMLQty = fourthxmlHttp.responseXML.getElementsByTagName("Qty");
			var XMLRemarks = fourthxmlHttp.responseXML.getElementsByTagName("Remarks");
			var XMLShippingModeID = fourthxmlHttp.responseXML.getElementsByTagName("ShippingModeID");
			var XMLShippingMode = fourthxmlHttp.responseXML.getElementsByTagName("ShippingMode");
			var XMLExQty = fourthxmlHttp.responseXML.getElementsByTagName("ExQty");
			var XMLApprovalNo = fourthxmlHttp.responseXML.getElementsByTagName("intApprovalNo");
			var XMLisBase = fourthxmlHttp.responseXML.getElementsByTagName("isBase");
			var XMLLeadTimeID = fourthxmlHttp.responseXML.getElementsByTagName("LeadTimeID");
			var XMLLeadTime = fourthxmlHttp.responseXML.getElementsByTagName("LeadTime");
			var XMLEstimateDate = fourthxmlHttp.responseXML.getElementsByTagName("EstimatedDate");
			var XMLintbpo = fourthxmlHttp.responseXML.getElementsByTagName("intbpo");
			var XMLhandOverDate = fourthxmlHttp.responseXML.getElementsByTagName("handOverDate");
			var XMLrefNo = fourthxmlHttp.responseXML.getElementsByTagName("refNo");
			
			for ( var loop = 0; loop < XMLDateofDelivery.length; loop ++)
			{
			
				var date = XMLDateofDelivery[loop].childNodes[0].nodeValue;;
				var qty = XMLQty[loop].childNodes[0].nodeValue;;
				var exqty = XMLExQty[loop].childNodes[0].nodeValue;;
				var mode = XMLShippingMode[loop].childNodes[0].nodeValue;;
				var remarks =XMLRemarks[loop].childNodes[0].nodeValue;;
				var modeID = XMLShippingModeID[loop].childNodes[0].nodeValue;
				var ApprovalNo = XMLApprovalNo[loop].childNodes[0].nodeValue;
				var isbase = XMLisBase[loop].childNodes[0].nodeValue;
				var LeadTimeID = XMLLeadTimeID[loop].childNodes[0].nodeValue;
				var LeadTime = XMLLeadTime[loop].childNodes[0].nodeValue;
				var estimatedDate = XMLEstimateDate[loop].childNodes[0].nodeValue;
				var intbpo = XMLintbpo[loop].childNodes[0].nodeValue;
				var handOverDate = XMLhandOverDate[loop].childNodes[0].nodeValue;
				var refNo = XMLrefNo[loop].childNodes[0].nodeValue;
				
				var tbl = document.getElementById('tblDelivery');
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;
				/*if (isbase == 'Y')
					row.className = "bcggreen";
				else
					row.className = "bcgwhite";*/
					row.className = "bcgwhite";
				var cellEdit = row.insertCell(0);
				cellEdit.id =ApprovalNo;  
				cellEdit.innerHTML = '';
			
				/*if(ApprovalNo<2)
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";*/
				//if(ApprovalNo<1 && editDelScheduleAfterFirstRevision=='1')
					//cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";
				//if(editDelScheduleAfterRevision=='1')	
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";	
				
				var cellDelete = row.insertCell(1); 
				//if(deleteDelSchedule)
					cellDelete.innerHTML = "<div id=\"" +  date + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
				//else
					//cellDelete.innerHTML = "&nbsp;";
				
				var cellDeliveryDate = row.insertCell(2);     
				cellDeliveryDate.className="normalfntMid";
				cellDeliveryDate.id = date;
				cellDeliveryDate.innerHTML = date;
				
				var cellQty = row.insertCell(3);     
				cellQty.className="normalfntMid";
				cellQty.innerHTML = qty;
				
				var cellExQty = row.insertCell(4);     
				cellExQty.className="normalfntMid";
				cellExQty.innerHTML = exqty;
				
				var cellMode = row.insertCell(5);     
				cellMode.className="normalfntMid";
				cellMode.id = modeID;
				if (mode == null || mode == "" )
					mode = " ";
				cellMode.innerHTML = mode;
				
				var cellRemarks = row.insertCell(6);     
				cellRemarks.className="normalfntMid";
				if (remarks == null || remarks == "" )
					remarks = " ";
				cellRemarks.innerHTML = remarks;
				
				var cellBPO = row.insertCell(7);
				cellBPO.className="normalfntMid";
				cellBPO.id = intbpo;
				cellBPO.innerHTML = intbpo;
				
				var cellestimateDate = row.insertCell(8);
				cellestimateDate.className="normalfntMid";
				cellestimateDate.id = estimatedDate;
				cellestimateDate.innerHTML = estimatedDate;
				
				var cellhandoverDate = row.insertCell(9);
				cellhandoverDate.className="normalfntMid";
				cellhandoverDate.id = handOverDate;
				cellhandoverDate.innerHTML = handOverDate;
				
				var cellrefNo = row.insertCell(10);
				cellrefNo.className="normalfntMid";
				cellrefNo.innerHTML = refNo;
				deliveryIndex++ ;
			}

		}
	}
}


function ValidateSchedule()
{
	//if (document.getElementById('chkBase').checked && IsBaseScheduled()) return false;
	var selectedDate = document.getElementById('deliverydate').value;
	var deliveryDate = document.getElementById('deliverydate').value;
	var day = selectedDate.substring(0,2);
	var month = selectedDate.substring(3,5);
	var year = selectedDate.substring(6,10);
	var selectedDate = new Date();
	selectedDate.setYear(parseInt(year));
	selectedDate.setMonth(parseInt(month,10));
	selectedDate.setDate(parseInt(day,10));
	var one_day=1000*60*60*24;
	var diff = Math.round((selectedDate.getTime()-serverDate.getTime())/(one_day));	
	if (document.getElementById('quantity').value == null || document.getElementById('quantity').value == "")
	{
		alert("Please enter the correct quantity.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if (parseInt(document.getElementById('quantity').value) > parseInt(document.getElementById('excqty').value))
	{
		alert("The with excess qty should greater than or equal to the order quantity.");
		document.getElementById('excqty').focus();
		return false;
	}
	else if (document.getElementById('deliverydate').value == null || document.getElementById('deliverydate').value == "")
	{
		alert("Please enter the Delivery Date.");
		document.getElementById('deliverydate').focus();
		return false;
	}
	/*else if (diff <= 1)
	{
		alert("The schedule date is not correct. Please select a date today onwards.");
		document.getElementById('deliverydate').focus()
		return false;
	}*/
	//alert(deliveryDate);
	else if(!validateDeliveryDate(deliveryDate))
	{
		alert("Delivery Date can not be prior to current date, Please select a correct delivery date.");
		document.getElementById('deliverydate').focus();
		return;
		}
	else if(document.getElementById('quantity').value <= 0)
	{
		alert("Please enter the correct quantity.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if (isDateNotAvailabile(document.getElementById('deliverydate').value))
	{
		alert("The schedule date already exists.");
		document.getElementById('deliverydate').focus();
		return false;
	}
	else if (isExceedingQuantity(parseInt(document.getElementById('quantity').value,10)))
	{
		alert("You are exceeding the main quantity. Please check it again.");
		document.getElementById('quantity').focus();
		return false;
	}
	/*else if (isExceedingExcessQuantity(parseInt(document.getElementById('excqty').value,10)))
	{
		alert("You are exceeding the main excess quantity. Please check it again.");
		document.getElementById('excqty').focus();
		return false;
	}*/
	else if(document.getElementById('remarks').value == '')
	{
		alert("Please enter \"Remarks\"");
		document.getElementById('remarks').focus();
		return false;
	}
	else
	{
		return true;	
	}
	return true;
}
function validateDeliveryDate(dtmFullDate)
{
	/*var dtmdate = document.getElementById('lbldate').innerHTML;
	var todayDate = new Date(dtmdate);*/
	
	var arrTdate = dtmFullDate.split("/")[2]+'-'+dtmFullDate.split("/")[1]+'-'+dtmFullDate.split("/")[0];
	//var testDate = new Date(arrTdate);
	
	
	var url="preordermiddletire.php";
			url=url+"?RequestType=deliveryDateValidation";
			url += '&delDate='+arrTdate;
			
			var xml_http_obj=$.ajax({url:url,async:false});
			
	if(xml_http_obj.responseXML.getElementsByTagName("XMLResponse")[0].childNodes[0].nodeValue == 1)
	  return true;
	 else
	 	return false;
		
		
	//alert(deliveryDate.FullYear )
}
function IsBaseScheduled()
{
	var tbl = document.getElementById('tblDelivery');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		
		var class_Name = tbl.rows[loop].className ;
		if (class_Name == "bcggreen")
		{
			alert("The base schedule already set.");
			return true;
		}
	}
	return false;
}

function IsEditedBaseScheduled(deliveryID)
{
	var tbl = document.getElementById('tblDelivery');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		
		var class_Name = tbl.rows[loop].className ;
		if (class_Name == "bcggreen" && deliveryID != tbl.rows[loop].id)
		{
			alert("The base schedule already set.");
			return true;
		}
	}
	return false;
}

function getShippingModes()
{    
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleShippingModes;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetShippingMode', true);
    xmlHttp.send(null);     
}

function HandleShippingModes()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLShippingID = xmlHttp.responseXML.getElementsByTagName("ShipModeID");
			 var XMLShippingName = xmlHttp.responseXML.getElementsByTagName("ShipMode");
			 for ( var loop = 0; loop < XMLShippingID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLShippingName[loop].childNodes[0].nodeValue;
				opt.value = XMLShippingID[loop].childNodes[0].nodeValue;
				document.getElementById("cboShippingMode").options.add(opt);
			 }
			 document.getElementById("cboShippingMode").value = shippos;
			
		}
	}
}

function AddScheduletoTable()
{
		var StyleNo = document.getElementById('lblStyleNo').innerHTML;
		var date = document.getElementById('deliverydate').value;
		var qty =  document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var modeID =  document.getElementById('cboShippingMode').value;
		var remarks = document.getElementById('remarks').value;
		/*var leadTime = document.getElementById('cboLeadTime').value;
		if (leadTime == "" || leadTime == null) leadTime = 11;
		var estimateddate = document.getElementById('estimateddeliverydate').value;*/
		var leadTime=0;
		var estimateddate = '00/00/0000';
		var isbase= "N";
		/*if (document.getElementById('chkBase').checked)
			isbase= "Y";*/
		
		createAltXMLHttpRequest();
		altxmlHttp.onreadystatechange = HandleDeliverySaving;
		altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdateSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&leadTime=' + leadTime + '&delDate=' + date + '&estimateddate=' + estimateddate, true);
		altxmlHttp.send(null); 
		
		
		
	//if (ValidateSchedule())
	//{
		/*var date = document.getElementById('deliverydate').value;
		var qty = document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var LeadTime = 11;
		if (document.getElementById('cboLeadTime').options.length > 0)
			LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
		var LeadID = document.getElementById('cboLeadTime').value;
		var remarks = document.getElementById('remarks').value;
		var modeID = document.getElementById('cboShippingMode').value;*/
		
		/*
		var tbl = document.getElementById('tblDelivery');
		var lastRow = tbl.rows.length;	
		
		var row = tbl.insertRow(lastRow);
		row.id = deliveryIndex;
		if (document.getElementById('chkBase').checked)
			row.className = "bcggreen";
		else
			row.className = "bcgwhite";
		var cellEdit = row.insertCell(0);   
		cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img src=\"images/edit.png\" /></div>";
		
		var cellDelete = row.insertCell(1);     
		cellDelete.innerHTML = "<div onClick=\"RemoveSchedule(this);\" align=\"center\"><img src=\"images/del.png\" /></div>";
		
		var cellDeliveryDate = row.insertCell(2);     
		cellDeliveryDate.className="normalfntMid";
		cellDeliveryDate.id = date;
		cellDeliveryDate.innerHTML = date;
		
		var cellQty = row.insertCell(3);     
		cellQty.className="normalfntMid";
		cellQty.innerHTML = qty;
		
		var cellExQty = row.insertCell(4);     
		cellExQty.className="normalfntMid";
		cellExQty.innerHTML = exqty;
		
		var cellMode = row.insertCell(5);     
		cellMode.className="normalfntMid";
		cellMode.id = modeID;
		cellMode.innerHTML = mode;
		
		var cellRemarks = row.insertCell(6);     
		cellRemarks.className="normalfntMid";
		if (remarks == null || remarks == "" )
			remarks = " ";
		cellRemarks.innerHTML = remarks;
		
		var cellLeadTime = row.insertCell(7);
		cellLeadTime.className="normalfntMid";
		cellLeadTime.id = LeadID;
		cellLeadTime.innerHTML = LeadTime;
		
		*/
		//UpdateSchedule(date,deliveryIndex);
		deliveryIndex ++;
		//ShowAddDeliverySchedule();
		//RefreshDeliveryForm();
		//RemoveAllDeliveryRows();
		//LoadSavedSchedules();
	//}
}

function HandleDeliverySaving()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        { 
        //	alert("pass");
			//saveBuyerPOAllocation();			
			RemoveAllDeliveryRows();
			LoadSavedSchedules();
			alert("The delivery schedules for the style is updated.");
			RefreshDeliveryForm();
			//closeWindow();
			
		}
		
	}
}

function HandleDeliveryUpdating()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        { 
        //	alert("pass");
			//saveBuyerPOAllocation();			
			RemoveAllDeliveryRows();
			LoadSavedSchedules();
			alert("The delivery schedules for the style is updated.");
			closeWaitingWindow();
			closeWindow();
			
		}
		
	}
}

function RemoveSchedule(obj)
{
	if(confirm('Are you sure you want to delete this schedule?'))
	{
		var td = obj.parentNode;
		var tro = td.parentNode;
		var delDate = tro.cells[2].lastChild.nodeValue;
		var styleNo = document.getElementById('lblStyleNo').innerHTML;
		//delDate = '2009-12-11';
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleDeletion;
		xmlHttp.open("GET", 'bomMiddletire.php?RequestType=DeleteDelivery&StyleNo=' + URLEncode(styleNo) + '&delDate=' + delDate, true);
		xmlHttp.send(null); 
		//tro.parentNode.removeChild(tro);
		RemoveAllDeliveryRows();
		LoadSavedSchedules();
	}
}

function HandleDeletion()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			RemoveAllDeliveryRows();
			LoadSavedSchedules();
		}
	}
}

function RefreshDeliveryForm()
{
var Qty = parseFloat(document.getElementById('txtorderqty').value);
	var allocatedQty = getAllocatedQuantity();
	var balanceQuantity = Qty - allocatedQty;
	document.getElementById('deliverydate').value = "";
	document.getElementById('quantity').value=balanceQuantity;
	//document.getElementById('excqty').value=balanceQuantity;
	calExQtyForDeliverySchedule(balanceQuantity);
	document.getElementById('remarks').value="";
	//document.getElementById('chkBase').checked = false;
	document.getElementById('quantity').focus();
}

function ShowAddDeliverySchedule()
{
	drawPopupArea(500,220,'frmItems');
	var Qty = parseFloat(document.getElementById('txtorderqty').value);
	var allocatedQty = getAllocatedQuantity();
	var balanceQuantity = Qty - allocatedQty;
	
	var HTMLText = " <table width=\"500\" class=\"bcgl1\"  height=\"220\">"+
					"<tr>"+
					 " <td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr >"+
							/*"<td width=\"3%\" bgcolor=\"#498cc2\">&nbsp;</td>"+*/
							"<td colspan=\"5\" bgcolor=\"#498cc2\" class=\"mainHeading\" height=\"20\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" class=\"normaltxtmidb2\" align=\"left\">Add Delivery Schedule </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"90\" class=\"normalfnt\">BPO</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"txtBpo\" value =\"0\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"txtBpo\" maxlength=\"20\" style=\"width:80px; text-align:right\" onkeyup=\"\" />"+
							"</label></td>"+
							"<td class=\"normalfnt\" width=\"100\">Delivery date</td>"+
							"<td align=\"left\">"+			
							  "<input name=\"deliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"deliverydate\" onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\" style=\"width:75px;\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
						   "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Qty<span class=\"normalfnt\">&nbsp;</span></td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"quantity\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"quantity\" value=\"" + balanceQuantity + "\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"calExQtyForDeliverySchedule(this.value);\" />"+
							"</label></td>"+
							"<td class=\"normalfnt\">Qty With Excess</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"excqty\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"excqty\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"calExQtyForDeliverySchedule(this.value);\" />"+
							"</label></td>"+
						  "</tr>"+
						    "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Shipping Mood<span class=\"normalfnt\">&nbsp;</span></td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboShippingMode\" class=\"txtbox\" id=\"cboShippingMode\" style=\"width:78px\">"+
							"</select>"+
							"</label></td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:78px\">"+
							"</select>"+
							"</label></td>"+
						  "</tr>"+
						    "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Estimated Date<span class=\"normalfnt\"><span>&nbsp;</span></td>"+
							"<td align=\"left\">"+			
							  "<input name=\"estimatedDate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimatedDate\" onclick=\"return showCalendar('estimatedDate', '%d/%m/%Y');\" style=\"width:75px;\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('estimatedDate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
							"<td class=\"normalfnt\">Handover Date</td>"+
							"<td align=\"left\">"+			
							  "<input name=\"handOverdate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"handOverdate\" onclick=\"return showCalendar('handOverdate', '%d/%m/%Y');\" style=\"width:75px;\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('handOverdate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
							"<tr>"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"90\" class=\"normalfnt\">Ref No</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"refNo\" value =\"0\" type=\"text\" class=\"txtboxRightAllign\"  id=\"refNo\"  maxlength=\"9\" style=\"width:75px; text-align:right\"  />"+
							"</label></td>"+
							/*"<td class=\"normalfnt\" width=\"80\">&nbsp;</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"excqty\" type=\"text\"  disabled=\"disabled\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"excqty\"  maxlength=\"9\" style=\"width:75px; text-align:right\"/>"+
							"</label></td>"+
						  "</tr>"+
							/*"<td class=\"normalfnt\">Estimated Delivery Date</td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"estimateddeliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimateddeliverydate\" onclick=\"return showCalendar('estimateddeliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+*/
						
						  /*"<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">&nbsp;</td>"+
							"<td style=\"padding-left:70px;\"><div class=\"normalfnt\">"+
							  "<input name=\"chkBase\" type=\"checkbox\" class=\"txtbox\" id=\"chkBase\" />"+
							" Set as Base Schedule</div></td>"+
						  "</tr>"+*/
						
						 /*"<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:140px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+*/
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Remarks</td>"+
							"<td align=\"left\" colspan=\"3\">"+
							"<input name=\"remarks\" type=\"text\" class=\"txtbox\"  id=\"remarks\"style=\"width:357px\" maxlength=\"50\" />"+
							 /* "<textarea name=\"remarks\" type=\"text\" class=\"txtbox\" id=\"remarks\" onkeypress=\"return imposeMaxLength(this,event, 50);\"  />"+*/
							/*"</textarea>"+*/
							"</td></tr>"+
						  /*"</tr>"+
						   "<tr>"+
							"<td>&nbsp;</td>"+
							"</tr>"+*/
						  /*"<tr style=\"visibility:hidden;\" >" +
						  "<td colspan=\"3\" bgcolor=\"#9bbfdd\" height=\"10\" class=\"normalfnth2\">Buyer PO Allocation</td>" + 
						  "</tr>" +
						  "<tr style=\"visibility:hidden;\" >" +
						  "<td colspan=\"3\"><div id=\"divBuyerPO\">Loading.... - Please wait.</div></td>" + 
						  "</tr>" +*/
						  "<tr>"+
							"<td colspan=\"5\" bgcolor=\"#D6E7F5\"><table width=\"100%\" height=\"45\" align=\"right\">"+
							  "<tr>"+
								"<td width=\"60%\">&nbsp;</td>"+
								"<td width=\"20%\"><img src=\"images/save.png\" class=\"mouseover\" width=\"84\" height=\"24\" onClick=\"SaveNewDeliverySchedule();\" /></td>"+
								"<td width=\"20%\"><img src=\"images/close.png\" class=\"mouseover\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
								/*"<td width=\"28%\">&nbsp;</td>"+*/
							  "</tr>"+
							"</table></td>"+
						 " </tr>"+
					  "</table></td>"+
					"</tr>"+
				  "</table>";	
	var frame = document.createElement("div");
    frame.id = "scheduleselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	document.getElementById('quantity').focus();
	getShippingModes();
	calExQtyForDeliverySchedule(balanceQuantity);
	//LoadLeadTimes();
	//LoadPODelivery();
}


function getAllocatedQuantity()
{
	var tbl = document.getElementById('tblDelivery');
	var allocatedQuantity = 0;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
       allocatedQuantity += parseInt(tbl.rows[loop].cells[3].lastChild.nodeValue,10);
	}
	return allocatedQuantity;
}

function isExceedingQuantity(newQuantity)
{
	var Qty = parseInt(document.getElementById('txtorderqty').value,10);
	var allocatedQty = getAllocatedQuantity();
	var balanceQuantity = Qty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
}

function getAllocatedExcessQuantity()
{
	var tbl = document.getElementById('tblDelivery');
	var allocatedQuantity = 0;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
       allocatedQuantity += parseInt(tbl.rows[loop].cells[4].lastChild.nodeValue,10);
	}
	return allocatedQuantity;
}

function isExceedingExcessQuantity(newQuantity)
{
	var ExQty = parseInt(document.getElementById('txtorderqty').value,10) + (parseInt(document.getElementById('txtorderqty').value,10) * parseInt(document.getElementById('txtexcessqty').value,10) / 100 );
	var allocatedQty = getAllocatedExcessQuantity();
	var balanceQuantity = ExQty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
}

function checkForValues(obj)
{
	if(obj.value == "" || obj.value == null)
		obj.value = 0;
}

function showEditScheduleWindow(itemcode)
{
	var tbl = document.getElementById('tblDelivery');
	var position = -1;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[2].id;
		if (itemid == itemcode)
			position = loop;
	}
	
	var changeLocation = tbl.rows[position].id;
	var date = tbl.rows[position].cells[2].lastChild.nodeValue;
	var qty = tbl.rows[position].cells[3].lastChild.nodeValue;
	var exqty = tbl.rows[position].cells[4].lastChild.nodeValue;
	var mode = tbl.rows[position].cells[5].lastChild.nodeValue;
	var remarks = tbl.rows[position].cells[6].lastChild.nodeValue;
	var bpo = tbl.rows[position].cells[7].lastChild.nodeValue;
	var estDate = tbl.rows[position].cells[8].lastChild.nodeValue;
	var handODate = tbl.rows[position].cells[9].lastChild.nodeValue;
	var refNo = tbl.rows[position].cells[10].lastChild.nodeValue;
	//var estDate = "";
	/*if(tbl.rows[position].cells[8].lastChild != null)
	estDate = tbl.rows[position].cells[8].lastChild.nodeValue;*/
	shippos = tbl.rows[position].cells[5].id;
	//leadposition = tbl.rows[position].cells[7].id;
	var class_Name = tbl.rows[position].className ;
	var checkedtext = "";
	if (class_Name == "bcggreen")
		 checkedtext = "checked=\"checked\"";
	
	drawPopupArea(500,225,'frmItems');
	var HTMLText = " <table width=\"500\" class=\"bcgl1\"  height=\"220\">"+
					"<tr>"+
					 " <td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr >"+
							/*"<td width=\"3%\" bgcolor=\"#498cc2\">&nbsp;</td>"+*/
							"<td colspan=\"5\" bgcolor=\"#498cc2\" class=\"mainHeading\" height=\"20\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" class=\"normaltxtmidb2\" align=\"left\">Edit Delivery Schedule </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"90\" class=\"normalfnt\">BPO</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"txtBpo\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" value=\"" + bpo + "\" id=\"txtBpo\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"\" />"+
							"</label></td>"+
							"<td class=\"normalfnt\" width=\"100\">Delivery date</td>"+
							"<td align=\"left\">"+			
							  "<input name=\"deliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"deliverydate\" onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\" style=\"width:75px;\" value=\"" + date + "\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
						   "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Qty<span class=\"normalfnt\">&nbsp;</span></td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"quantity\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"quantity\" value=\"" + qty + "\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"calExQtyForDeliverySchedule(this.value);\" />"+
							"</label></td>"+
							"<td class=\"normalfnt\">Qty With Excess</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"excqty\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"excqty\" value=\"" + exqty + "\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"calExQtyForDeliverySchedule(this.value);\" />"+
							"</label></td>"+
						  "</tr>"+
						    "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Shipping Mood<span class=\"normalfnt\">&nbsp;</span></td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboShippingMode\" class=\"txtbox\" id=\"cboShippingMode\" style=\"width:78px\">"+
							"</select>"+
							"</label></td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:78px\">"+
							"</select>"+
							"</label></td>"+
						  "</tr>"+
						    "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\" >Estimated Date<span class=\"normalfnt\"><span>&nbsp;</span></td>"+
							"<td align=\"left\">"+			
							  "<input name=\"estimatedDate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimatedDate\" onclick=\"return showCalendar('estimatedDate', '%d/%m/%Y');\" style=\"width:75px;\" value=\"" + estDate + "\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('estimatedDate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
							"<td class=\"normalfnt\">Handover Date</td>"+
							"<td align=\"left\">"+			
							  "<input name=\"handOverdate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"handOverdate\" onclick=\"return showCalendar('handOverdate', '%d/%m/%Y');\" style=\"width:75px;\" value=\"" + handODate + "\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('handOverdate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
							"<tr>"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"90\" class=\"normalfnt\">Ref No</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"refNo\" type=\"text\" class=\"txtboxRightAllign\" value=\"" + refNo + "\" id=\"refNo\"  maxlength=\"9\" style=\"width:75px; text-align:right\" />"+
							"</label></td>"+
							/*"<td class=\"normalfnt\" width=\"80\">&nbsp;</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"excqty\" type=\"text\"  disabled=\"disabled\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"excqty\"  maxlength=\"9\" style=\"width:75px; text-align:right\"/>"+
							"</label></td>"+
						  "</tr>"+
							/*"<td class=\"normalfnt\">Estimated Delivery Date</td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"estimateddeliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimateddeliverydate\" onclick=\"return showCalendar('estimateddeliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+*/
						
						  /*"<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">&nbsp;</td>"+
							"<td style=\"padding-left:70px;\"><div class=\"normalfnt\">"+
							  "<input name=\"chkBase\" type=\"checkbox\" class=\"txtbox\" id=\"chkBase\" />"+
							" Set as Base Schedule</div></td>"+
						  "</tr>"+*/
						
						 /*"<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:140px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+*/
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Remarks</td>"+
							"<td align=\"left\" colspan=\"3\">"+
							"<input name=\"remarks\" type=\"text\" class=\"txtbox\" value=\"" + remarks + "\"  id=\"remarks\"style=\"width:357px\" maxlength=\"50\" />"+
							 /* "<textarea name=\"remarks\" type=\"text\" class=\"txtbox\" id=\"remarks\" onkeypress=\"return imposeMaxLength(this,event, 50);\"  />"+*/
							/*"</textarea>"+*/
							"</td></tr>"+
						  /*"</tr>"+
						   "<tr>"+
							"<td>&nbsp;</td>"+
							"</tr>"+*/
						  /*"<tr style=\"visibility:hidden;\" >" +
						  "<td colspan=\"3\" bgcolor=\"#9bbfdd\" height=\"10\" class=\"normalfnth2\">Buyer PO Allocation</td>" + 
						  "</tr>" +
						  "<tr style=\"visibility:hidden;\" >" +
						  "<td colspan=\"3\"><div id=\"divBuyerPO\">Loading.... - Please wait.</div></td>" + 
						  "</tr>" +*/
						  "<tr>"+
							"<td colspan=\"5\" bgcolor=\"#D6E7F5\"><table width=\"100%\" height=\"45\" align=\"right\">"+
							  "<tr>"+
								"<td width=\"60%\">&nbsp;</td>"+
								"<td width=\"20%\"><img src=\"images/save.png\" class=\"mouseover\" width=\"84\" height=\"24\" onClick=\"UpdateSchedule('" + itemcode + "'," + changeLocation + ");\" /></td>"+
								"<td width=\"20%\"><img src=\"images/close.png\" class=\"mouseover\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
								/*"<td width=\"28%\">&nbsp;</td>"+*/
							  "</tr>"+
							"</table></td>"+
						 " </tr>"+
					  "</table></td>"+
					"</tr>"+
				  "</table>";	
	var frame = document.createElement("div");
    frame.id = "scheduleselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	document.getElementById('quantity').focus();
	getShippingModes();
	
	//LoadLeadTimes();
	//LoadPODeliveryDate(date);
}

function UpdateSchedule(deldate,deliveryID)
{
	showWaitingWindow();
	if(ValidateScheduleModifications(deldate,deliveryID) && ValidateBPOAllocation())
	{
		var StyleNo = document.getElementById('lblStyleNo').innerHTML;
		var date = document.getElementById('deliverydate').value;
		if(date != "")
		{
			document.getElementById("handOverdate").value = date;
			document.getElementById("estimatedDate").value = date;
			//alert(document.getElementById("estimatedDate").value);
		}
		var qty =  document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var modeID =  document.getElementById('cboShippingMode').value;
		var remarks = document.getElementById('remarks').value.trim();
		var bpo =  document.getElementById('txtBpo').value;
	var estimateddate =  document.getElementById('estimatedDate').value;
	var handOverdate =  document.getElementById('handOverdate').value;
	var refNo =  document.getElementById('refNo').value;
		//strart 2010-08-06 commented for orit ------------------------------
		/*var leadTime = document.getElementById('cboLeadTime').value;
		var estimateddate = document.getElementById('estimateddeliverydate').value;
		if (leadTime == "" || leadTime == null) leadTime = 11;
		var isbase= "N";
		if (document.getElementById('chkBase').checked)
			isbase= "Y";*/
		//-------------end-------------------------------------
		var leadTime = 0;
		//var estimateddate = '00/00/0000';
		var isbase= "N";
		//createAltXMLHttpRequest();
		//altxmlHttp.onreadystatechange = HandleDeliveryUpdating;
		//altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdateSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&leadTime=' + leadTime + '&delDate=' + deldate + '&estimateddate=' + estimateddate, true);
		//altxmlHttp.send(null); 
		
		var updateEventSchedule = "N";
		//start 2010-10-06 Need to update eventschedule details when BuyerPO wise delivery details available.
		//Orit version don't need this
		/*if(confirm("The schedule change may be need to update the event schedule. Please press 'OK' button to update the event schedule as well."))
		updateEventSchedule = "Y";*/
		//end--------------------------------
		
		//send mail, when editing the deliverySchedule 
		var needSendMail = "Y";
		
		//end----------------------------------------------------
		
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleDeliveryUpdating;
	altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=ChangeSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + leadTime + '&oldDate=' + deldate + '&estimateddate=' + estimateddate+  '&bpo=' + bpo+ '&handOverdate=' + handOverdate+ '&refNo=' + refNo + '&updateEventSchedule=' + updateEventSchedule+'&needSendMail='+needSendMail, true);
	altxmlHttp.send(null); 
		
		// --------------------------
		
		
		
	}
	else
	{
		closeWaitingWindow();
		}
}

function isDateNotAvailabile(newdate)
{
	var tbl = document.getElementById('tblDelivery');
	for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var date = rw.cells[2].lastChild.nodeValue;
		if (newdate == date)
			return true;
	}
	return false;
}

function DateTwiseAvailability(olddate,newdate)
{
	var tbl = document.getElementById('tblDelivery');
	var rowNo = -1;
	for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var date = rw.cells[2].lastChild.nodeValue;
		if (olddate == date)
			rowNo = loop;
	}
	
	for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var date = rw.cells[2].lastChild.nodeValue;
		if (newdate == date && loop != rowNo)
			return false;
	}
	return true;
}

function ValidateScheduleModifications(newdate,deliveryID)
{
	//if (document.getElementById('chkBase').checked && IsEditedBaseScheduled(deliveryID)) return false;
	var selectedDate = document.getElementById('deliverydate').value;
	var deliveryDate = document.getElementById('deliverydate').value;
	var day = selectedDate.substring(0,2);
	var month = selectedDate.substring(3,5);
	var year = selectedDate.substring(6,10);
	var selectedDate = new Date();
	selectedDate.setYear(parseInt(year));
	selectedDate.setMonth(parseInt(month,10));
	selectedDate.setDate(parseInt(day,10));
	var one_day=1000*60*60*24;
	//alert(document.getElementById('remarks').value);
	var diff = Math.round((selectedDate.getTime()-serverDate.getTime())/(one_day));	
	
	if (document.getElementById('quantity').value == null || document.getElementById('quantity').value == "")
	{
		alert("Please enter the correct quantity.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if (parseInt(document.getElementById('quantity').value) > parseInt(document.getElementById('excqty').value))
	{
		alert("The with excess qty should greater than or equal to the order quantity.");
		document.getElementById('excqty').focus();
		return false;
	}
	else if (document.getElementById('deliverydate').value == null || document.getElementById('deliverydate').value == "")
	{
		alert("Please enter the Delivery Date.");
		document.getElementById('deliverydate').focus();
		return false;
	}
	else if(document.getElementById('quantity').value <= 0)
	{
		alert("Please enter the correct quantity.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if(!validateDeliveryDate(deliveryDate))
	{
		alert("Delivery Date can not be prior to current date, Please select a correct delivery date.");
		document.getElementById('deliverydate').focus();
		return;
	}
	/*else if (diff <= 1)
	{
		alert("The schedule date is not correct. Please select a date today onwards.");
		document.getElementById('deliverydate').focus()
		return false;
	}*/
	else if (!DateTwiseAvailability(newdate,document.getElementById('deliverydate').value))
	{
		alert("The schedule date already exists.");
		document.getElementById('deliverydate').focus()
		return false;
	}
	else if (isExceedingEditingQuantity(newdate,parseInt(document.getElementById('quantity').value,10)))
	{
		alert("You are exceeding the main quantity. Please check it again.");
		document.getElementById('quantity').focus();
		return false;
	}
	/*else if (isEditingExceedingExcessQuantity(newdate,parseInt(document.getElementById('excqty').value,10)))
	{
		alert("You are exceeding the main excess quantity. Please check it again.");
		document.getElementById('excqty').focus();
		return false;
	}*/
	else if((document.getElementById('remarks').value).trim() == '')
	{
		alert("Please enter \"Remarks\"");
		document.getElementById('remarks').focus();
		return false;
	}
	else
	{
		return true;	
	}
	return true;
}

function isExceedingEditingQuantity(newdate,newQuantity)
{
	var Qty = parseInt(document.getElementById('txtorderqty').value,10);
	var allocatedQty = getAllocatedEditingQuantity(newdate);
	var balanceQuantity = Qty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
}

function getAllocatedEditingQuantity(newdate)
{
	var tbl = document.getElementById('tblDelivery');
	var allocatedQuantity = 0;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		if (tbl.rows[loop].cells[2].id != newdate)
       		allocatedQuantity += parseInt(tbl.rows[loop].cells[3].lastChild.nodeValue,10);
	}
	return allocatedQuantity;
}

function getEditingAllocatedExcessQuantity(newdate)
{
	var tbl = document.getElementById('tblDelivery');
	var allocatedQuantity = 0;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		if (tbl.rows[loop].cells[2].id != newdate)
       		allocatedQuantity += parseInt(tbl.rows[loop].cells[4].lastChild.nodeValue,10);
	}
	return allocatedQuantity;
}

function isEditingExceedingExcessQuantity(newdate,newQuantity)
{
	var ExQty = parseInt(document.getElementById('txtTotQty').value,10);
	var allocatedQty = getEditingAllocatedExcessQuantity(newdate);
	var balanceQuantity = ExQty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
}

function RemoveAllDeliveryRows()
{
	var tbl = document.getElementById('tblDelivery');
	for ( var loop = tbl.rows.length-1 ;loop > 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function LoadLeadTimes()
{
	var buyerID = currentBuyerID;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleLeadTimes;
    thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetLeadTimes&buyerID=' + buyerID, true);
    thirdxmlHttp.send(null); 
}

function HandleLeadTimes()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        { 
			var XMLID = thirdxmlHttp.responseXML.getElementsByTagName("LeadID");
			var XMLName = thirdxmlHttp.responseXML.getElementsByTagName("LeadTime");
			
			for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboLeadTime").options.add(opt);
			 }
			 document.getElementById("cboLeadTime").value = leadposition;
		}		
	}	
}

function reloadPreOrderStyle()
{
	//var styleNo = document.getElementById('cboStyles').value;
	//location = "bom.php?styleID=" + URLEncode(styleNo);
	document.frmbom.submit()
}

function reloadPreOrderOrderNo()
{
	//var styleNo = document.getElementById('cboOrderNo').value;
	//var styleName = document.getElementById('cboStyles').value;
	//location = "bom.php?styleID=" + URLEncode(styleNo) + '&styleName='+styleName;
	document.frmbom.submit()
}
function LoadPODeliveryDate(date)
{
	delbpoedition = true;
	var styleNO = document.getElementById('lblStyleNo').innerHTML;
	createtFifthXMLHttpRequest();
	fifthxmlHttp.onreadystatechange = HandlePODelivery;
	fifthxmlHttp.open("GET", 'preorderBuyerPO.php?styleID=' + URLEncode(styleNO) + '&DelDate=' + date , true);
	fifthxmlHttp.send(null);
}

function HandlePODelivery()
{
	if(fifthxmlHttp.readyState == 4) 
    {
        if(fifthxmlHttp.status == 200) 
        { 
			document.getElementById("divBuyerPO").innerHTML = fifthxmlHttp.responseText;
			if(!delbpoedition)		
			automateDelScheduleBPO();
			//alert(fourthxmlHttp.responseText);			
		}
	}
}

function automateDelScheduleBPO()
{
	var tbl = document.getElementById('tblBuyerPO');
	if (tbl == null) return;
	var ExQtyPC = parseInt(document.getElementById('txtexcessqty').value);
	if(tbl.rows.length==1)return;
	if (tbl.rows.length == 2)
    {
		var delQty = parseInt(document.getElementById('quantity').value);
		tbl.rows[1].cells[2].childNodes[1].value = delQty;		
		var exQty = parseInt(delQty + parseInt(delQty * ExQtyPC / 100));
		tbl.rows[1].cells[3].childNodes[1].value = exQty;
		tbl.rows[1].cells[0].childNodes[1].childNodes[1].checked = true;

	}
	else
	{
		var poQty  = 0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var optSelection = tbl.rows[loop].cells[0].childNodes[1].childNodes[1];
			if(optSelection.checked)
			{
				poQty += parseInt(tbl.rows[loop].cells[2].childNodes[1].id);
			}
		}
		document.getElementById('quantity').value = poQty;
	}
}

function LoadPODelivery()
{
	delbpoedition = false;
	var styleNO = document.getElementById('lblStyleNo').innerHTML;
	createtFifthXMLHttpRequest();
	fifthxmlHttp.onreadystatechange = HandlePODelivery;
	fifthxmlHttp.open("GET", 'preorderBuyerPO.php?styleID=' + URLEncode(styleNO), true);
	fifthxmlHttp.send(null);
}


function ValidateBPOAllocation()
{
	//var tbl = document.getElementById('tblBuyerPO');
	var bpoQty = 0;
	var bpoExqty = 0;
	var deliveryQty = parseInt(document.getElementById('quantity').value) ;
	var deliveryExqty = parseInt(document.getElementById('excqty').value);
	var isSelected = false;
    /*for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var optSelection = tbl.rows[loop].cells[0].childNodes[1].childNodes[1];
		if(optSelection.checked)
		{
			isSelected = true;
			var qty =  tbl.rows[loop].cells[2].childNodes[1].value;
			var poQty = parseInt(tbl.rows[loop].cells[2].childNodes[1].id);
			var exqty =  tbl.rows[loop].cells[3].childNodes[1].value;
			if (qty == "" || qty == null  )
			{
				alert("Quantities not given for selected Buyer PO's");
				return false;
			}
			if (exqty == "" || exqty == null )
			{
				alert("Excess quantities not given for selected Buyer PO's");
				return false;
			}
			bpoQty += parseInt(qty);
			bpoExqty += parseInt(exqty);
		}
	}
	
	if (!isSelected) 
	{
		return true;	
	}
	if (deliveryQty != bpoQty )
	{
		alert("The sum of Buyer PO quantity is not equal to delivery schedule quantity.");	
		return false;
	}
	if (deliveryExqty != bpoExqty )
	{
		alert("The sum of Buyer PO excess quantity is not equal to delivery schedule excess quantity.");	
		return false;
	}*/
	
	return true;
}


function SaveNewDeliverySchedule()
{
	showWaitingWindow();
	if (ValidateSchedule() && ValidateBPOAllocation() )
	{			
		var StyleNo = document.getElementById('lblStyleNo').innerHTML;
		var date = document.getElementById('deliverydate').value;
		if(date != "")
		{
			document.getElementById("handOverdate").value = date;
			document.getElementById("estimatedDate").value = date;
		}
		var qty = document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var modeID =  document.getElementById('cboShippingMode').value;
		var remarks =  document.getElementById('remarks').value.trim();
		var bpo = document.getElementById("txtBpo").value;
		var refNo = document.getElementById("refNo").value;
		var handoverDate = document.getElementById("handOverdate").value;
		var estimateddate = document.getElementById("estimatedDate").value;
		//var LeadTime = 0;
		var LeadID = 0;
		/*if (document.getElementById('cboLeadTime').options.length > 0)
		{
			//var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
			var LeadID = document.getElementById('cboLeadTime').value;
		}*/
		var isbase= "N";
		/*if (document.getElementById('chkBase').checked)
			isbase= "Y";*/
		var needSendMail = "Y";	
		//alert(needSendMail);
		createAltXMLHttpRequest();
		altxmlHttp.onreadystatechange = HandleNewDelivery;
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID+'&needSendMail='+needSendMail+ '&bpo=' + bpo + '&refNo=' + refNo+'&handoverDate='+handoverDate+'&estimateddate='+estimateddate, true);
		altxmlHttp.send(null); 
		
	}
	else
	{
		closeWaitingWindow();
	}
}

function HandleNewDelivery()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLResult = altxmlHttp.responseXML.getElementsByTagName("SaveState");	
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//AddScheduletoTable();
				//saveBuyerPOAllocation();
				RemoveAllDeliveryRows();
			LoadSavedSchedules();
			alert("The delivery schedules for the style is updated.");
			RefreshDeliveryForm();
				closeWaitingWindow();
			}
		}		
	}
}

/*function UpdateSchedule(deldate,position)
{
	if(ValidateScheduleModifications(deldate,position))
	{
		saveDeliveryChanges(deldate);
		UpdateDeliveryScheduleTable(deldate,position);
	}
}*/

function saveDeliveryChanges(editedDate)
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var date = document.getElementById('deliverydate').value;
	var qty = document.getElementById('quantity').value;
	var exqty = document.getElementById('excqty').value;
	var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	var modeID =  document.getElementById('cboShippingMode').value;
	var remarks =  document.getElementById('remarks').value;
	
	//var LeadTime = 0;
	var LeadID = 0;
	if (document.getElementById('cboLeadTime').options.length > 0)
	{
		//var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
		var LeadID = document.getElementById('cboLeadTime').value;
	}
	var isbase= "N";
	if (document.getElementById('chkBase').checked)
		isbase= "Y";
	
	var updateEventSchedule = "N";
	if(confirm("The schedule change may be need to update the event schedule. Please press 'OK' button to update the event schedule as well."))
		updateEventSchedule = "Y";
		
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleChangeDelivery;
	altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=ChangeSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID + '&oldDate=' + editedDate + '&updateEventSchedule=' + updateEventSchedule, true);
	altxmlHttp.send(null); 	
}

function HandleChangeDelivery()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLResult = altxmlHttp.responseXML.getElementsByTagName("SaveState");	
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//saveBuyerPOAllocation();
				closeWindow();
				
			}
		}		
	}
}

function UpdateDeliveryScheduleTable(deldate,position)
{
	var tbl = document.getElementById('tblDelivery');
	var rowNo = -1;
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var rw = tbl.rows[loop];
		var date = rw.cells[2].lastChild.nodeValue;
		if (deldate == date)
			rowNo = loop;
	}
	
	if (document.getElementById('chkBase').checked)
		tbl.rows[rowNo].className = "bcggreen";
	else
		tbl.rows[rowNo].className = "bcgwhite";
	
	tbl.rows[rowNo].cells[0].childNodes[0].id = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].id =  document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].lastChild.nodeValue = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[3].lastChild.nodeValue = document.getElementById('quantity').value;
	tbl.rows[rowNo].cells[4].lastChild.nodeValue = document.getElementById('excqty').value;
	tbl.rows[rowNo].cells[5].lastChild.nodeValue = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	tbl.rows[rowNo].cells[6].lastChild.nodeValue = document.getElementById('remarks').value;	
	tbl.rows[rowNo].cells[5].id = document.getElementById('cboShippingMode').value;
	var LeadTime = "";
	var LeadID = 0;
	if (document.getElementById('cboLeadTime').options.length > 0)
	{
		var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
		var LeadID = document.getElementById('cboLeadTime').value;
	}
	tbl.rows[rowNo].cells[7].lastChild.nodeValue = LeadTime;
	tbl.rows[rowNo].cells[7].id = LeadID;
	
	// -----------------------------------------
	
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var date = document.getElementById('deliverydate').value;
	var qty = document.getElementById('quantity').value;
	var exqty = document.getElementById('excqty').value;
	var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	var modeID =  document.getElementById('cboShippingMode').value;
	var remarks =  document.getElementById('remarks').value;
	
	//var LeadTime = 0;
	var LeadID = 0;
	if (document.getElementById('cboLeadTime').options.length > 0)
	{
		//var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
		var LeadID = document.getElementById('cboLeadTime').value;
	}
	var isbase= "N";
	if (document.getElementById('chkBase').checked)
		isbase= "Y";
	
	// ------------------------------------------
	
	//closeWindow();
}

function saveBuyerPOAllocation()
{
	var styleID = document.getElementById('lblStyleNo').innerHTML;
	var deliveryDate =document.getElementById('deliverydate').value;
	var tbl = document.getElementById('tblBuyerPO');
	var isMainRatio = true;
	var isedition = 0;
	if(delbpoedition)
		isedition = 1;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var optSelection = tbl.rows[loop].cells[0].childNodes[1].childNodes[1];
		if(optSelection.checked)
		{
			isMainRatio = false;
			var buyerPO = tbl.rows[loop].cells[1].id;
			var qty =  parseInt(tbl.rows[loop].cells[2].childNodes[1].value);
			//var poQty = parseInt(tbl.rows[loop].cells[2].childNodes[1].id);
			var exqty =  parseInt(tbl.rows[loop].cells[3].childNodes[1].value);
			var remarks = tbl.rows[loop].cells[4].childNodes[0].childNodes[1].value;
			createAltXMLHttpRequest();
			altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveScheduleBuyerPo&StyleNo=' + URLEncode(styleID) + '&ScheduleDate=' + deliveryDate + '&qty=' + qty + '&exqty=' + exqty  + '&remarks=' + URLEncode(remarks) + '&buyerPO=' + URLEncode(buyerPO) + '&isedition=' + isedition  , true);
			altxmlHttp.send(null); 	
		}
		
	}
	if(isMainRatio)
	{
		createAltXMLHttpRequest();
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveMainRatioEventSchedule&StyleNo=' + URLEncode(styleID) + '&ScheduleDate=' + deliveryDate  , true);
		altxmlHttp.send(null); 
	}
	RefreshDeliveryForm();
}

function showStyleBuyerPOForm()
{	
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBuyerPOWindow; // SavePreOrder
    xmlHttp.open("GET", 'buyerPOPopup.php?styleID=' + URLEncode(StyleNo) , true);   
	xmlHttp.send(null); 
}

function HandleBuyerPOWindow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			drawPopupArea(528,423,'frmBuyerPOs');
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmBuyerPOs').innerHTML=HTMLText;
		}		
	}
}

function reloadPreOrderSR()
{
	//var intSRNO = document.getElementById('cboSR').value;
	//location = "bom.php?intSRNO=" + intSRNO;
	//location = "bom.php?intSRNO=" + intSRNO;
	var styleNo = document.getElementById('cboSR').value;
	var styleName = document.getElementById('cboStyles').value;
	location = "bom.php?styleID=" + URLEncode(styleNo) + '&styleName='+styleName;
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	// start 2010-10-16 get order no 
	document.getElementById('cboOrderNo').value = scNo;
	document.getElementById('cboStyles').value = scNo;
	/*createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleSCshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleID&scNo=' + scNo , true);   
	xmlHttp.send(null); */
}

function handleSCshow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("StyID");	
			var ctyID = XMLResult[0].childNodes[0].nodeValue;
			document.getElementById('cboStyles').value = "Select One";
			document.getElementById('cboStyles').value = ctyID;
		}		
	}	
}

function getScNo()
{
	//start 2010-10-16 get style wise SC no ------------------------------
	/*var styleID = document.getElementById('cboStyles').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlestyshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getSRNo&styleID=' + URLEncode(styleID) , true);   
	xmlHttp.send(null);*/
	
	var styleName = document.getElementById('cboStyles').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseSCNum";
					url += '&styleName='+URLEncode(styleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  OrderNo;
	
}
function getStyleNo1()
{
	var srNo = document.getElementById('cboSR').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getSCWiseStyleNum";
					url += '&srNo='+URLEncode(srNo);
					
		var htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		var OrderNo = htmlobj.responseXML.getElementsByTagName("stylNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboStyles').innerHTML =  OrderNo;
}

/*function handlestyshow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("SrNO");	
			var ctyID = XMLResult[0].childNodes[0].nodeValue;
			document.getElementById('cboSR').value = "Select One";
			document.getElementById('cboSR').value = ctyID;
		}		
	}	
}
*/


function FilterLoadedItems()
{
	RemoveItems();
	var matID = document.getElementById('cboMaterial').value;
	var catID = document.getElementById('cboCategory').value;
	var searchString = document.getElementById('txtFilter').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleItems;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetItemsForString&MainCatID=' + matID + '&CatID=' + catID + '&searchString=' + URLEncode(searchString), true);
    xmlHttp.send(null); 
}

function getTotalMaterialCostExceptCurrentItem(category)
{
	var totalMaterialCost = 0 ;
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var currentCode = tbl.rows[loop].cells[5].id; 
		
		if (currentCode == currentItemCode)
			continue;
		if (tbl.rows[loop].cells[4].id != category)
			continue;
		var value = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		var avgprice = parseFloat(tbl.rows[loop].cells[19].lastChild.nodeValue);
		var baseunitPrice = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var conPc = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue);
		var freight = parseFloat(tbl.rows[loop].cells[11].lastChild.nodeValue);
		var selection = tbl.rows[loop].cells[4].id;
		var variation = 0;
		if (avgprice != 0)
		var variation = baseunitPrice - parseFloat(avgprice);
		var unitPrice = baseunitPrice - parseFloat(variation);
		var price = 0;

		if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && _1ExcessAllowed == false && _1WastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
			 
		}
		else
		{
			//price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);	
			price = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		}
		
		totalMaterialCost = parseFloat(totalMaterialCost) + parseFloat(price);
		//alert(totalMaterialCost);
	}
	return RoundNumbers(totalMaterialCost,4);
}

function getCostingValueForCategory(cat)
{
	switch (parseInt(cat))
	{
		case 1:
			return preOrderFabricCost;
		case 2:
			return preOrderAccessoriesCost;
		case 3:
			return preOrderPacMatCost;
		case 4:
			return preOrderServiceCost;
		case 5:
			return preOrderOtherCost;
		default:
			return 0;
	}
}

function getNoOfDecimals(val)
{
	var value = new String(val);
	if(value.indexOf('.')>-1)
	{
		return value.length - value.indexOf('.') - 1;
	}
	else
		return 0;
		
}

function isPurchasedWithinTheProcess(itemCode)
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createNewXMLHttpRequest(1);
    xmlHttpreq[1].onreadystatechange = HandleGettingPurchased; // SavePreOrder
    xmlHttpreq[1].open("GET", 'bomMiddletire.php?styleID=' + URLEncode(StyleNo) + '&RequestType=checkPurchased&itemCode=' + itemCode , true);   
	xmlHttpreq[1].send(null); 
}

function HandleGettingPurchased()
{
    if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        {  
			 var XMLQty = xmlHttpreq[1].responseXML.getElementsByTagName("Qty");
			 var purchasedQty = XMLQty[0].childNodes[0].nodeValue;	
			 if(purchasedQty > 0)
			 	document.getElementById('cboUnits').disabled = "true";
				document.getElementById('txtconsumpc2').setAttribute("disabled","disabled");
		}
	}
}

function checkExceedingBPOQty(obj)
{
	var maxqty = parseInt(obj.parentNode.parentNode.cells[5].childNodes[0].nodeValue);
	if(parseInt(obj.value) > maxqty)
	{
		alert("You can't exceed the buyerPO quantity. Max allowed quantity is " + maxqty);
		obj.value = maxqty;
		obj.focus();
		return ;
	}

	if(obj.parentNode.parentNode.cells[3].childNodes[1].value == "")
		obj.parentNode.parentNode.cells[3].childNodes[1].value = obj.value; 
		
	calculateTotalBPOQty();
}

function fillbpoData(obj)
{
	if(obj.checked)
	{
		var maxqty = parseInt(obj.parentNode.parentNode.parentNode.cells[5].childNodes[0].nodeValue);
		if(obj.parentNode.parentNode.parentNode.cells[2].childNodes[1].value == "")
		{
			obj.parentNode.parentNode.parentNode.cells[2].childNodes[1].value = maxqty;
		}
		if(obj.parentNode.parentNode.parentNode.cells[3].childNodes[1].value == "")
		{
			obj.parentNode.parentNode.parentNode.cells[3].childNodes[1].value = maxqty;
		}
	}
	calculateTotalBPOQty();
}

function calculateTotalBPOQty()
{
	var tbl = document.getElementById('tblBuyerPO');
	var bpoQty = 0;
	var bpoExqty = 0;
	//var deliveryQty = parseInt(document.getElementById('quantity').value) ;
	//var deliveryExqty = parseInt(document.getElementById('excqty').value);
	//var isSelected = false;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var optSelection = tbl.rows[loop].cells[0].childNodes[1].childNodes[1];
		if(optSelection.checked)
		{
			//isSelected = true;
			var qty =  tbl.rows[loop].cells[2].childNodes[1].value;
			var poQty = parseInt(tbl.rows[loop].cells[2].childNodes[1].id);
			var exqty =  tbl.rows[loop].cells[3].childNodes[1].value;
			if (qty == "" || qty == null  )
			{
				continue;
			}
			if (exqty == "" || exqty == null )
			{
				continue;
			}
			bpoQty += parseInt(qty);
			bpoExqty += parseInt(exqty);
		}
	}

	document.getElementById('quantity').value = bpoQty;
	document.getElementById('excqty').value = bpoExqty;

}

function LoadCategoryItemsForText(itemcode)
{
	//document.getElementById('cboItems').options.length = 0 ;
	var text = document.getElementById('txtFilter').value;
	/*createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleItemCategories;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetItemListforCategoryText&styleID=' + itemcode + '&filter=' + URLEncode(text) , true);
    thirdxmlHttp.send(null); */
	
	var url = 'bomMiddletire.php?RequestType=GetItemListforCategoryText';
							url += '&styleID=' +itemcode;
							url += '&filter=' +URLEncode(text);
																		
			var htmlobj=$.ajax({url:url,async:false});
			 var XMLID = htmlobj.responseXML.getElementsByTagName("ItemID");
						 
			document.getElementById("cboItems").innerHTML =  XMLID[0].childNodes[0].nodeValue;
				
	
}

function showContrastWindow(obj)
{
	if(!hasStyleRatio)
	{
		alert("Sorry! You can't proceed with contrast without having style ratio.");
		return false;
	}
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var itemCode = obj.parentNode.parentNode.parentNode.cells[5].id;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleContrast;
   xmlHttp.open("GET", 'contrastselecter.php?styleID=' + URLEncode(StyleNo) + '&itemCode=' + itemCode, true);
   xmlHttp.send(null)
}

function handleContrast()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			drawPopupArea(660,405,'frmContrast');
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmContrast').innerHTML=HTMLText;
		}		
	}
}

function showContrastColor()
{
	drawPopupAreaLayer(500,300,'frmSelector',3);
	var HTMLText = "<table width=\"500\" border=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmSelector'),event);\">" +
						"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Select Contrast Colors</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><table width=\"100%\" border=\"0\">" +
						  "<tr>" +
							"<td width=\"3%\">&nbsp;</td>" +
							"<td width=\"18%\" class=\"normalfnt\">Buyer</td>" +
							"<td width=\"32%\"><select name=\"cboBuyer\" class=\"txtbox\" id=\"cboBuyer\" style=\"width:140px\" onChange=\"ChangeBuyer();\">" +
							"</select>        </td>" +
							"<td width=\"14%\" class=\"normalfnt\">Division</td>" +
							"<td width=\"33%\"><select name=\"cboDivision\" class=\"txtbox\" id=\"cboDivision\" style=\"width:140px\" onChange=\"ChangeDivision();\">" +
									"</select></td>" +
						 "</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"200\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
						  "<tr>" +
							"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Colors</td>" +
							"</tr>" +
						  "<tr>" +
							"<td width=\"46%\" bgcolor=\"#D6E7F5\" class=\"normalfntMid\">Colors</td>" +
							"<td width=\"8%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"<td width=\"46%\" bgcolor=\"#D6E7F5\" class=\"normalfntMid\"><table width=\"100%\"><tr><td>Selected Colors </td><td><img class=\"mouseover\" src=\"images/stylecolor.png\" onClick=\"getStyleRatioColors();\" ></td></tr></table></td>" +
						  "</tr>" +
						  "<tr>" +
							"<td height=\"141\" valign=\"top\"><select onkeypress=\"keyMoveColorRight(event);\" name=\"cbocolors\" size=\"10\" class=\"txtbox\" id=\"cbocolors\" style=\"width:225px\" ondblclick=\"MoveColorRight();\">" +
							"</select></td>" +
							"<td><table width=\"100%\" border=\"0\">" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsRight();\" /></div></td>" +
							  "</tr>" +
							"</table></td>" +
							"<td valign=\"top\"><select name=\"cboselectedcolors\" size=\"8\" class=\"txtbox\" id=\"cboselectedcolors\" style=\"width:225px;\" ondblclick=\"MoveColorLeft();\">" +
							"</select>" +
							"<table><tr><td class=\"normalfntMid\">New:</td><td><input  class=\"txtbox\" type=\"text\" onkeypress=\"grabColorEnterKey(event);\" size=\"18\" maxlength=\"30\" id=\"txtnewcolor\"></td><td><img src=\"images/addmark.png\" class=\"mouseover\" onClick=\"AddNewColor();\" width=\"80%\" height=\"80%\"></td></tr></table>"+					
							"</td>" +
						  "</tr>" +
						 
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">" +
						  "<tr>" +
							"<td width=\"25%\">&nbsp;</td>" +
							"<td width=\"29%\"><img src=\"images/ok.png\" alt=\"OK\" width=\"86\" height=\"24\" class=\"mouseover\" onClick=\"addSelectedColorsTocontrast();\" /></td>" +
							"<td width=\"21%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeLayer();\" /></td>" +
							"<td width=\"25%\">&nbsp;</td>" +
						 "</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table>"; 
					
	var frame = document.createElement("div");
    frame.id = "colorsizeselectwindow";
	document.getElementById('frmSelector').innerHTML=HTMLText;	
	
	LoadBuyers();
	loadAddedContrastColors();
}

function changeContrastBuyerPO()
{
	document.getElementById('colorQty').innerHTML = "";
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPO = document.getElementById('contrastBuyerPO').value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleContrastBuyerPO;
   xmlHttp.open("GET", 'contrastmiddle.php?RequestType=LoadBuyerPOColors&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO), true);
   xmlHttp.send(null)
}

function handleContrastBuyerPO()
{
	if(xmlHttp.readyState == 4) 
   {
       if(xmlHttp.status == 200) 
       {  
        	document.getElementById('mainColor').innerHTML = xmlHttp.responseText;
       }        
	}
}

function getColorQuantity()
{
	document.getElementById('colorQty').innerHTML = "";
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPO = document.getElementById('contrastBuyerPO').value;
	var color = document.getElementById('mainColor').value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleContrastColorQty;
   xmlHttp.open("GET", 'contrastmiddle.php?RequestType=LoadBuyerPOColorQuantity&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&color=' + URLEncode(color) , true);
   xmlHttp.send(null)
}

function handleContrastColorQty()
{
	if(xmlHttp.readyState == 4) 
   {
       if(xmlHttp.status == 200) 
       {  
        	document.getElementById('colorQty').innerHTML = xmlHttp.responseText;
       }        
	}
}

function getStyleRatioColors()
{
	createXMLHttpRequest();
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
   xmlHttp.onreadystatechange = styleRatioColors;
   xmlHttp.open("GET", 'contrastmiddle.php?RequestType=getStyleRatioColors&styleID=' + URLEncode(StyleNo) , true);
   xmlHttp.send(null)
}

function styleRatioColors()
{
	if(xmlHttp.readyState == 4) 
   {
       if(xmlHttp.status == 200) 
       {  
       	 var XMLOption = xmlHttp.responseXML.getElementsByTagName("option");
       	 var colors = document.getElementById("cboselectedcolors");

       	 for (var i = 0; i < XMLOption.length ; i ++)
       	 {
       	 		var exists = false;
       	 		for (var loop = 0 ; loop < colors.options.length; loop ++)
					{
						if (colors.options[loop].value == XMLOption[i].childNodes[0].nodeValue)
						{
							exists =true;
							break;
						}
					}
				if (!exists)
				{
					var opt = document.createElement("option");
					opt.text = XMLOption[i].childNodes[0].nodeValue;
					opt.value = XMLOption[i].childNodes[0].nodeValue;
					document.getElementById("cboselectedcolors").options.add(opt);
				}
			 }
        	//document.getElementById('cboselectedcolors').innerHTML += xmlHttp.responseText;
       }        
	}
}

function validateContrastColorSelection()
{
	var colors = document.getElementById("cboselectedcolors");
	for (var loop = 0 ; loop < colors.options.length; loop ++)
	{
			if (colors.options[loop].value==document.getElementById("mainColor").value )
			{
				alert("Sorry! you can't add the garment color(" + colors.options[loop].value + ") as a contrast color. ");
				return false;
			}
	}
	return true;
}

function addSelectedColorsTocontrast()
{
	if(validateContrastColorSelection())
	{
		var tbl = document.getElementById('tblContrast');
		var colors = document.getElementById("cboselectedcolors");
		for (var loop = 0 ; loop < colors.options.length; loop ++)
		{
			if (!isContrastColorAlreadyAvailable(colors.options[loop].value))
			{
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				row.className = "backcolorWhite";
				row.innerHTML = " <td width=\"70%\" height=\"24\" class=\"normalfnt\">" + colors.options[loop].value + "</td>" +
          							"<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" style=\"width:100px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>";
			}
		}
		removeNotSelectedColors();
		closeLayer();
	}
	
}

function isContrastColorAlreadyAvailable(colorName)
{
	var tbl = document.getElementById('tblContrast');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		if (tbl.rows[loop].cells[0].childNodes[0].nodeValue == colorName )
  			return true;
  	}
  	return false;
}

function loadAddedContrastColors()
{
	var tbl = document.getElementById('tblContrast');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var opt = document.createElement("option");
		opt.text = tbl.rows[loop].cells[0].childNodes[0].nodeValue;
		opt.value = tbl.rows[loop].cells[0].childNodes[0].nodeValue;
		document.getElementById("cboselectedcolors").options.add(opt);
  	}
}

function removeNotSelectedColors()
{
	var tbl = document.getElementById('tblContrast');
	var length = tbl.rows.length ;
	for ( var loop = 1 ;loop < length ; loop ++ )
  	{
  		var colorFound = false;
  		var colors = document.getElementById("cboselectedcolors");
		for (var i = 0 ; i < colors.options.length; i ++)
		{
			if (tbl.rows[loop].cells[0].childNodes[0].nodeValue == colors.options[i].value )
  				colorFound =  true;
		}
  		if (!colorFound)
  		{
  			tbl.deleteRow(loop);
  			length --;
  			loop --;
  		}
  	}
}

function validContrastCombination()
{
	var tbl = document.getElementById('tblContrast');
	var totalContrast = 0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		if (tbl.rows[loop].cells[1].childNodes[0].value == "" || tbl.rows[loop].cells[1].childNodes[0].value == 0)
  		{
  			alert("Please enter the contrast consumption for color " + tbl.rows[loop].cells[0].childNodes[0].nodeValue);
  			tbl.rows[loop].cells[1].childNodes[0].focus();
  			return false;
		}
  		totalContrast += parseFloat(tbl.rows[loop].cells[1].childNodes[0].value);
  	}
  	
  	var itemConsumption = parseFloat(document.getElementById('totalconsumption').innerHTML);
  	if (totalContrast >= itemConsumption)
  	{
  		alert("Sorry! You can't proceed with this contarst consumptions. \nThe sum of contrast consumptions should be less than the item consumption " + itemConsumption);
  		return false;
	}
  	return true;
}

var contrastRequest = 0;
var contrastResponse = 0;


function saveContrast()
{
	if (validContrastCombination())
	{
		contrastRequest = 0;
		contrastResponse = 0;
		var buyerPO = document.getElementById('contrastBuyerPO').value;
		var garmentcolor = document.getElementById('mainColor').value;
		
		var StyleNo = document.getElementById('lblStyleNo').innerHTML;
		var contrastItem = document.getElementById('totalconsumption').parentNode.cells[0].id;
		
		
		if (buyerPO == null || buyerPO == "" || buyerPO == "Select One")
		{
			alert("The Buyer PO not selected.");
			document.getElementById('contrastBuyerPO').focus();
			return ;
		}
		else if (garmentcolor == null || garmentcolor == "" || garmentcolor == "Select One")
		{
			alert("The garment color not selected.");
			document.getElementById('mainColor').focus();
			return ;
		}
		
		var tbl = document.getElementById('tblContrast');
		if (tbl.rows.length <= 1)
		{
			if(!(confirm("The contrast is empty. This may cause to delete all the contrast items already saved in the database. Are you sure?")))
				return;
		}
		
		showPleaseWait();
		createXMLHttpRequest();
  		xmlHttp.onreadystatechange = function()
  		{
  			if(xmlHttp.readyState == 4)
				{	
       			if(xmlHttp.status == 200) 
       			{ 
       				if (tbl.rows.length <= 1)
       				{
       					alert("The contrast colors deleted.");
       					hidePleaseWait();
       				}
						contrastRequest = tbl.rows.length -1 ;
						for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  						{
  							var contrastcolor = tbl.rows[loop].cells[0].childNodes[0].nodeValue;
  							var contrastconsumption = tbl.rows[loop].cells[1].childNodes[0].value;
  							
  							createNewXMLHttpRequest(loop);
  							xmlHttpreq[loop].index = loop;
							xmlHttpreq[loop].onreadystatechange = function()
							{
								if(this.readyState == 4)
								{	
       							if(this.status == 200) 
       							{ 
       								if (this.responseText == 1)
											contrastResponse ++;
										if (contrastResponse == contrastRequest )
										{
											alert("The contrast colors successfully saved.");
											hidePleaseWait();
										}
									}			
								}
		
							};	
							xmlHttpreq[loop].open("GET", 'contrastmiddle.php?RequestType=SaveContastColor&styleID=' + URLEncode(StyleNo) + '&contrastItem=' + contrastItem + '&buyerPO=' + URLEncode(buyerPO) + '&garmentcolor=' + URLEncode(garmentcolor) + '&contrastcolor=' + URLEncode(contrastcolor) + '&contrastconsumption=' + contrastconsumption , true);
							xmlHttpreq[loop].send(null);
  			
						}
					}			
				}
  		}  		
  	 	xmlHttp.open("GET", 'contrastmiddle.php?RequestType=clearAvailableContrast&styleID=' + URLEncode(StyleNo) + '&contrastItem=' + contrastItem + '&buyerPO=' + URLEncode(buyerPO) + '&garmentcolor=' + (garmentcolor) , true);
   	xmlHttp.send(null)
   	
		
		
		
	}
}



function showPleaseWait()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divPleasewait";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
	document.body.appendChild(popupbox);
}

function hidePleaseWait()
{
	try
	{
		var box = document.getElementById('divPleasewait');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function removeCurrentContrastTable()
{
	var tbl = document.getElementById('tblContrast');
	var length = tbl.rows.length ;
	for ( var loop = 1 ;loop < length ; loop ++ )
  	{
  		tbl.deleteRow(loop);
  		length --;
  		loop --;
	}
}

function changeGarmentColor()
{
	removeCurrentContrastTable();
	getColorQuantity();
	loadSavedContrast();
}


function loadSavedContrast()
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPO = document.getElementById('contrastBuyerPO').value;
	var color = document.getElementById('mainColor').value;
	var contrastItem = document.getElementById('totalconsumption').parentNode.cells[0].id;
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = function()
	{
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
       			document.getElementById('tblContrast').innerHTML += this.responseText;					
			}			
		}
		
	};	
	xmlHttpreq[0].open("GET", 'contrastmiddle.php?RequestType=loadSavedContrast&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&color=' + URLEncode(color)  + '&contrastItem=' + contrastItem , true);
	xmlHttpreq[0].send(null);
}

function applyContrast()
{
	if (isPurchased)
	{
		alert("Some items already purchased. You can't apply the contrast.");
		return;
	}
	showPleaseWait();
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = function()
	{
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
       			alert("The contrast applied to this style.");
       			hidePleaseWait();					
			}			
		}
		
	};	
	xmlHttpreq[0].open("GET", 'contrastmiddle.php?RequestType=applyContrast&styleID=' + URLEncode(StyleNo) , true);
	xmlHttpreq[0].send(null);
}

var materialCell = null;
var materialRow = null;

function showMaterialRatioHelper(obj)
{
	if (!matRatioRequest)
		return;
	materialCell = obj.parentNode.parentNode.cellIndex;
	materialRow = obj.parentNode.parentNode.parentNode.rowIndex;
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerpo = document.getElementById("cbopono").value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleMatRatioHelper;
   xmlHttp.open("GET", 'materialRatioHelperPopUp.php?styleID=' + URLEncode(StyleNo) + '&bpo=' + URLEncode(buyerpo) , true);
   xmlHttp.send(null)
}

function handleMatRatioHelper()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			drawPopupAreaLayer(530,400,'frmHelper',5);
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmHelper').innerHTML=HTMLText;
		}
	}
}

function AddToMatRatioBox()
{
	var tbl = document.getElementById('stylecolorsize');
	var selectedQty = 0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		if(tbl.rows[loop].cells[0].childNodes[0].checked)
  		{
  			if(tbl.rows[loop].cells[3].childNodes[0].value != "")
  			{
  				selectedQty += parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
  			}
  		}
	}
	var ReqQty = Math.round((selectedQty * ColorSizeConsumption) + (((selectedQty * ColorSizeConsumption)*pub_wastage)/100));
	
	var d = document.getElementById('tblQtyRatio');
	//alert(document.getElementById('tblQtyRatio').childNodes[0].innerHTML);
	document.getElementById('tblQtyRatio').rows[materialRow].cells[materialCell].lastChild.lastChild.value = ReqQty;
	var obj = d.rows[materialRow].cells[materialCell].lastChild.lastChild;
	ChangeCellValue(obj) 
	closeLayer();
}

function ShowSubContractWindow()
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = function()
	{
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
       			drawPopupArea(660,405,'frmSubContract');
					var HTMLText = xmlHttp.responseText;
					document.getElementById('frmSubContract').innerHTML=HTMLText;					
			}			
		}
		
	};	
   xmlHttp.open("GET", 'subcontractor.php?styleID=' + URLEncode(StyleNo) , true);
   xmlHttp.send(null)
}

var uniqueID = 0;

function AddSubContractor()
{
	var cboText = document.getElementById('cboContractors').parentNode.innerHTML;
	var tbl = document.getElementById('tblContractors');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);

	row.className = "backcolorWhite";
	row.innerHTML = " <td  class=\"normalfntMid\"><img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" border=\"0\" class=\"mouseover\" onClick=\"removeContractor(this);\"/></td> <td height=\"24\" class=\"normalfnt\">" + cboText + "</td>" +
						 "<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>" +
						 "<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>" +
						 "<td>"+
							"<input name=\"del" + uniqueID + "\" type=\"text\" class=\"txtbox\" id=\"del" + uniqueID + "\" size=\"10\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"\"></input><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\">"+
							"</td>"+
          			 "<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event);\"></td>";
	
	uniqueID ++;
}



function removeContractor(obj)
{
	if(confirm('Are you sure you want to delete this item?'))
	{
		obj.parentNode.parentNode.parentNode.removeChild(obj.parentNode.parentNode);
		
	}
}

function SaveSubContractorDetails()
{
	if (validateSubContractDetails())
	{
		showPleaseWait();
		stratSubContractSaving();
	}
}

function validateSubContractDetails()
{
	if (document.getElementById('subContractBuyerPO').value == "-1")
	{
		alert("Please select the buyer PO.");
		document.getElementById('subContractBuyerPO').focus();
		return false;
	}
	
	var tbl = document.getElementById('tblContractors');

	var subQty = 0;
	for (var loop = 1 ; loop < tbl.rows.length ; loop ++ )
	{
		var contractor = tbl.rows[loop].cells[1].childNodes[0].value;
		if (contractor == "-1")
		{
			alert("Please select the sub contractor.");
			tbl.rows[loop].cells[1].childNodes[0].focus();
			return false;
		}
		var contracterName = tbl.rows[loop].cells[1].childNodes[0].options[tbl.rows[loop].cells[1].childNodes[0].selectedIndex].text;;
		var occurrences = 0;
		for (var i = 1 ; i < tbl.rows.length ; i ++ )
		{
			if (contractor == tbl.rows[i].cells[1].childNodes[0].value)
				occurrences ++;
			
			if (occurrences > 1)
			{
				alert("Duplicate sub contractor found for \""  + contracterName +  "\". Please delete duplicates and try again.");
				return false;
			}
		}
		
		var fob = tbl.rows[loop].cells[2].childNodes[0].value;
		if (fob == "")
		{
			alert("Please enter the FOB for \"" + contracterName + "\"");
			tbl.rows[loop].cells[2].childNodes[0].focus();
			return false;
		}		
		
		var cm = tbl.rows[loop].cells[3].childNodes[0].value;
		if (cm == "")
		{
			alert("Please enter the sub CM for \"" + contracterName + "\"");
			tbl.rows[loop].cells[3].childNodes[0].focus();
			return false;
		}
		
		var delDate = tbl.rows[loop].cells[4].childNodes[0].value;
		if (delDate == "")
		{
			alert("Please enter the delivery date for the contractor \"" + contracterName + "\"");
			tbl.rows[loop].cells[4].childNodes[0].focus();
			return false;
		}
		
		var qty = tbl.rows[loop].cells[5].childNodes[0].value;
		subQty += parseInt(qty);
		if (qty == "")
		{
			alert("Please enter the sub contractor quantity for \"" + contracterName + "\"");
			tbl.rows[loop].cells[5].childNodes[0].focus();
			return false;
		}
		else if (qty != parseInt(qty))
		{
			alert("Invalid sub contractor quantity for \"" + contracterName + "\"");
			tbl.rows[loop].cells[5].childNodes[0].focus();
			return false;
		}
	}
	
	var bpoQty = 	parseInt(document.getElementById('bpoQty').innerHTML);
	if(bpoQty < subQty)
	{
		alert("Sorry! You can't allocate more than buyer PO quantity.");
		return false;	
	}
	
	return true;
}

function showBuyerPOWiseQuantity()
{
	var buyerQty = document.getElementById('subContractBuyerPO').options[document.getElementById("subContractBuyerPO").selectedIndex].value;
	if(buyerQty == "-1")
	buyerQty = "";
	document.getElementById('bpoQty').innerHTML = buyerQty;
	loadSubContractInfo();
}

var requestCount = 0;
var responseCount = 0;

function stratSubContractSaving()
{
	var buyerPO = document.getElementById('subContractBuyerPO').options[document.getElementById("subContractBuyerPO").selectedIndex].text;
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = function()
	{
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
       		if(this.responseText == "1")
       		{
					responseCount = 0;
					var tbl = document.getElementById('tblContractors');
					requestCount = tbl.rows.length - 1;
					for (var loop = 1 ; loop < tbl.rows.length ; loop ++ )
					{
						var contractor = tbl.rows[loop].cells[1].childNodes[0].value;	
						var fob = tbl.rows[loop].cells[2].childNodes[0].value;
						var cm = tbl.rows[loop].cells[3].childNodes[0].value;
						var delDate = tbl.rows[loop].cells[4].childNodes[0].value;
						var qty = tbl.rows[loop].cells[5].childNodes[0].value;
						
						createNewXMLHttpRequest(loop);
					  	xmlHttpreq[loop].index = loop;
						xmlHttpreq[loop].onreadystatechange = function()
						{
							if(this.readyState == 4)
							{	
					 			if(this.status == 200) 
					 			{ 
					 				if (this.responseText == 1)
										responseCount ++;
									if (requestCount == responseCount )
									{
										alert("Subcontractor details successfully saved.");
										hidePleaseWait();
									}
								}			
							}
					
						};	
						xmlHttpreq[loop].open("GET", 'subcontractmiddle.php?RequestType=saveSubcontractDetails&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&contractor=' + contractor + '&fob=' + fob + '&cm=' + cm + '&delDate=' + delDate + '&qty=' + qty, true);
						xmlHttpreq[loop].send(null);
					}
				}			
			}
		}
		
	};
		
	xmlHttp.open("GET", 'subcontractmiddle.php?RequestType=deleteSubContractDetails&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) , true);
   xmlHttp.send(null);
}

function loadSubContractInfo()
{
	removeCurrentSubContractTable();
	var buyerPO = document.getElementById('subContractBuyerPO').options[document.getElementById("subContractBuyerPO").selectedIndex].text;
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = function()
	{
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
       		var XMLSubcontractor = this.responseXML.getElementsByTagName("Subcontractor");	
       		var XMLQty = this.responseXML.getElementsByTagName("Qty");
       		var XMLFob = this.responseXML.getElementsByTagName("Fob");
       		var XMLCM = this.responseXML.getElementsByTagName("CM");
       		var XMLDelDate = this.responseXML.getElementsByTagName("DelDate");	
       		
       		var tbl = document.getElementById('tblContractors');
       		var cboText = document.getElementById('cboContractors').parentNode.innerHTML;
       		for ( var loop = 0; loop < XMLSubcontractor.length; loop ++)
			 	{
					var Subcontractor = XMLSubcontractor[loop].childNodes[0].nodeValue;	
					var Qty = XMLQty[loop].childNodes[0].nodeValue;	
					var Fob = XMLFob[loop].childNodes[0].nodeValue;	
					var CM = XMLCM[loop].childNodes[0].nodeValue;	
					var DelDate = XMLDelDate[loop].childNodes[0].nodeValue;			 		
			 		
					var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
				
					row.className = "backcolorWhite";
					row.innerHTML = " <td  class=\"normalfntMid\"><img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" border=\"0\" class=\"mouseover\" onClick=\"removeContractor(this);\"/></td> <td height=\"24\" class=\"normalfnt\">" + cboText + "</td>" +
										 "<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" value=\"" + Fob + "\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>" +
										 "<td class=\"normalfnt\"><input type=\"text\" class=\"txtbox\" value=\"" + CM + "\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td>" +
										 "<td>"+
											"<input name=\"del" + uniqueID + "\" type=\"text\" value=\"" + DelDate + "\"  class=\"txtbox\" id=\"del" + uniqueID + "\" size=\"10\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"" + DelDate + "\"></input><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\">"+
											"</td>"+
				          			 "<td class=\"normalfnt\"><input type=\"text\" value=\"" + Qty + "\" class=\"txtbox\" style=\"width:50px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event);\"></td>";
					row.cells[1].childNodes[0].value = Subcontractor;
					uniqueID ++;
			 	}
			 			
			}			
		}
		
	};	
   xmlHttp.open("GET", 'subcontractmiddle.php?RequestType=showSubContractDetails&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) , true);
   xmlHttp.send(null)
}

function removeCurrentSubContractTable()
{
	var tbl = document.getElementById('tblContractors');
	var length = tbl.rows.length ;
	for ( var loop = 1 ;loop < length ; loop ++ )
  	{
  		tbl.deleteRow(loop);
  		length --;
  		loop --;
	}
}

// --------------------------------------------------

function showBPODeliveryForm()
{	
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var url = 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Type=P';
	drawPopupArea(820,496,'frmstylewise');
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmstylewise').innerHTML=HTMLText;
}

function HandleBPODelScheduleWindow()
{
	
			drawPopupArea(820,496,'frmstylewise');
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmstylewise').innerHTML=HTMLText;
			
}

function validateBuyerPO()
{
	if(document.getElementById('txtbuyerpo').value == "")
	{
		alert("Please enter the buyerPONo.");
		document.getElementById('txtbuyerpo').focus();
		return false;
	} 
	else if(document.getElementById('txtqty').value == "" || document.getElementById('txtqty').value < 1)
	{
		alert("Please enter valid quantity.");
		document.getElementById('txtqty').focus();
		return false;
	} 
	if(document.getElementById('deliverydateDD').value == "")
	{
		alert("Please enter the delivery date.");
		document.getElementById('deliverydateDD').focus();
		return false;
	} 
	if($("#cmbDeliveryStatus").val() == '-1'){
		alert("Please select delivery status either 'CONFIRMED' or 'BLOCK'.");
		return false;
	}
	
	return true;
}

function addBPOToGrid()
{
	if(validateBuyerPO())
	{
		var booShortShipped = 0;
		var txtBuyerPO = document.getElementById('txtbuyerpo').value;
		var txtQty = document.getElementById('txtqty').value;
		var countryID = document.getElementById('cbocountry').value;
				
		//alert(countryID);
		var CountryName = document.getElementById('cbocountry').options[document.getElementById('cbocountry').selectedIndex].text ;
		var leadTimeID = document.getElementById('cboLeadTime').value;
		var leadName = " ";
		if (document.getElementById('cboLeadTime').value != null && document.getElementById('cboLeadTime').value != ""){
			leadName = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text ;
                    }else{
                        alert(" Select T&A time table from the list");
                        return;
                    }
			
		var deliveryDate = document.getElementById('deliverydateDD').value;
		
		var manuLocationID = $("#cmbProductionLocation").val();
		var manuLocation   = $("#cmbProductionLocation option:selected").text();
                var iShortShipReason = $("#cboShortShipReason").val();


		//if(deliveryDate != "")
//		{
//			document.getElementById("estimatedDD").value = deliveryDate;
//			document.getElementById("handoverDD").value = deliveryDate;
//		}
		
		//if(estimatedDD =="" && handoverDD =="")
//		{
//			document.getElementById("estimatedDD").value = deliveryDate;
//			document.getElementById("handoverDD").value = deliveryDate;
//		}else
//		{
//			var estimatedDD = document.getElementById("estimatedDD").value;
//			var handoverDD = document.getElementById("handoverDD").value;
//		}
		
		//var estimatedDD = document.getElementById('deliverydateDD').value;
		
		if ((document.getElementById('estimatedDD').value != null) && (document.getElementById('estimatedDD').value  != "") && (document.getElementById('estimatedDD').value.trim() != "00/00/0000"))
			{
				estimatedDD = document.getElementById('estimatedDD').value;
				
			}else
			{
				estimatedDD = document.getElementById('deliverydateDD').value;
				
			}
			
			
		//var handoverDD = document.getElementById('deliverydateDD').value;
		if (document.getElementById('handoverDD').value != null && document.getElementById('handoverDD').value  != "" && document.getElementById('handoverDD').value.trim() != "00/00/0000")
			{
				handoverDD = document.getElementById('handoverDD').value;
			}else
			{
				handoverDD = document.getElementById('deliverydateDD').value;	
			}
			
			
						//mig -182017
		if (document.getElementById('dtmPcd').value != null && document.getElementById('dtmPcd').value  != "" && document.getElementById('dtmPcd').value.trim() != "00/00/0000")
			{
				var pcdDate = document.getElementById('dtmPcd').value;
			}
		//alert(pcdDate);	
			//mig -182017 end
			
		//if(document.getElementById('estimatedDD').value == null && document.getElementById('handoverDD').value == null)
//		{
//			document.getElementById("estimatedDD").value = document.getElementById('deliverydateDD').value;
//			document.getElementById("handoverDD").value = document.getElementById('deliverydateDD').value;	
//		}
		
				
		var shippingModeID = document.getElementById('cboShippingMode').value;
		var shippingMode   = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text ;
		var remarks        = document.getElementById('txtremarks').value;
		
		var orderstatus 	= parseInt($("#cmbDeliveryStatus").val());
		var orderstatusText = $("#cmbDeliveryStatus option:selected").text();
		var cutoffdate  	= $("#dtCutOff").val();
		var previousBPO		= $("#hndOldBuyerPo").val();
		var shipStatus 		= $("#hndShipStatus").val();
		var preBPOListId 	= $("#cboPreviousBPO").val();
                var iShortShipReasonId  = parseInt($("#cboShortShipReason").val());

		if(preBPOListId != '-1'){
			previousBPO = preBPOListId;
		}else{
                    alert(" Please select previous buyer po number from the list");
                    return;
                }
                
                // Check short ship status and reason
		if($("#chkShortShipped").is(":checked")){ 
                    
                    /*if(iShortShipReasonId == -1){
                        alert("Select short ship reason from the list ");
                        return;
                    }*/
                    booShortShipped = 1;}
                
                
		
		if(orderstatus == 2){
			if(cutoffdate == ''){
				alert("Please specify cutoff date when order being confirming ");
				$("#dtCutOff").focus();
				return;
			}
			
			
			if(!CompareDate(deliveryDate, cutoffdate)){
				alert("Cut off date cannot be exceed the delivery date ");
				return;
			}
		}else{ cutoffdate = "-";}
		
		var tbl = document.getElementById('BuyerPO');
		
		//alert(previousBPO);
		var lastRow = tbl.rows.length;					
		var row = tbl.insertRow(lastRow);
		if(shipStatus=="Completed")
			row.className =	"backcolorGreen";
		else
			row.className = "backcolorWhite";
			
		//alert(pcdDate);	
		
		row.innerHTML = "<td style=\"width:20px; border: 1px solid #CCC;\"><img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" border=\"0\" class=\"mouseover\" onclick=\"RemovePONumberFromGrid(this);\"  /></td>" +
                       "<td class=\"normalfnt\" ondblclick=\"changeToTextBoxBPO(this);\" style=\"width:95px; border: 1px solid #CCC;\" >"  + txtBuyerPO + "</td>"+
                       "<td class=\"normalfntRite\" ondblclick=\"changeToTextBoxBPO(this);\" style=\"width:57px; border: 1px solid #CCC;\" >" + txtQty +"</td>"+
                       "<td class=\"normalfntMid\" id=\"" + countryID + "\" style=\"width:70px; border: 1px solid #CCC;\">" + CountryName + "</td>"+
                       "<td class=\"normalfnt\" id=\"" + leadTimeID + "\" style=\"width:35px; border: 1px solid #CCC;\" >" + leadName + "</td>"+
                       "<td class=\"normalfnt\" style=\"width:78px; border: 1px solid #CCC;\">" + deliveryDate + "</td>"+
                       "<td class=\"normalfnt\" style=\"width:78px; border: 1px solid #CCC;\">" + estimatedDD + "</td>"+
					   "<td class=\"normalfnt\" style=\"width:75px; border: 1px solid #CCC;\">" + handoverDD + "</td>"+
                       "<td class=\"normalfnt\" id=\"" + shippingModeID + "\" style=\"width:53px; border: 1px solid #CCC;\">" + shippingMode + "</td>"+
                       "<td class=\"normalfnt\" style=\"width:68px; border: 1px solid #CCC; word-wrap:break-word;\">" + remarks + "</td>" +
					   "<td class=\"normalfntBPO\" id=\"" + orderstatus + "\" style=\"width:73px; border: 1px solid #CCC;\">" + orderstatusText + "</td>" + 
					   "<td class=\"normalfnt\" style=\"width:74px; border: 1px solid #CCC;\">" + cutoffdate + "</td>"+
					   "<td class=\"normalfnt\" style=\"width:70px; border: 1px solid #CCC;\">"+shipStatus+"</td>"+
					   "<td class=\"normalfntMid\" id=\"" + manuLocationID + "\" style=\"width:70px; border: 1px solid #CCC; word-wrap:break-word;\">" + manuLocation + "</td>"+
					   "<td class=\"normalfnt\" style=\"width:60px; border: 1px solid #CCC; word-wrap:break-word; \">" + previousBPO + "</td>" +
					   			    	 	"<td class=\"normalfnt\" style=\"width:75px; border: 1px solid #CCC;\">" + pcdDate + "</td>"+
					   "<td class=\"normalfnt\" style=\"width:0px; display:none;\">" + booShortShipped + "</td>" +
                                           "<td class=\"normalfnt\" style=\"width:0px; display:none;\">" + iShortShipReasonId + "</td>";
		
				   
	
		document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
		
		
		// =============================================
		// Add On - 11/03/2015
		// Add By - Nalin Jayakody
		// Adding - After add delivery item to the grid set control to the normal and clear the values
		// ================================================
		/*$("#txtbuyerpo").prop("disabled", false);
		$("txtqty").prop("disabled", false);
		
		$("#txtbuyerpo").val("");
		$("txtqty").val("");
		
		$("#txtbuyerpo").css("background-color", "#FFF");*/
		
		
	}
}

function displayAllocatedTotal()
{
	document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
}


function ValidateBPOSaving()
{
	var tbl = document.getElementById('BuyerPO');
	for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var buyerPO = tbl.rows[loop].cells[1].textContent;
		var deliveryDate = tbl.rows[loop].cells[5].textContent;
		var estimatedDate = tbl.rows[loop].cells[6].textContent;
		//alert(buyerPO)
		if(estimatedDate == "" || estimatedDate == "00/00/0000")
		{
			alert("Please enter Estimated Date");
			return false;	
		}
		
		//=============================================================
		// Comment On - 02/26/2016
		// Comment By - Nalin Jayakody
		// Comment For - To validate only buyer po no.
		//=============================================================		

		/* var combination = buyerPO + deliveryDate;
		if(isCombinationAvailable(combination))
		{
			alert("The combination of " + buyerPO + " - " + deliveryDate + " is assigned more than one time.");
			return false;
		} */

		//=============================================================
		
		var combination = buyerPO;
		var CheckPossition = loop + 1;
		if(isCombinationAvailable(combination, CheckPossition))
		{
			alert("The buyer PO number - " + buyerPO + " is assigned more than one time.");
			return false;
		} 

  	}	
  	
	//=============================================================
	// Comment On - 11/02/2015
	// Comment By - Nalin Jayakody
	// Comment For - To avoid calculation excess qty for deliveries
	//=============================================================
  	/* var approvedQuantity = parseInt(document.getElementById('approvedQty').textContent); */
	//=============================================================
	var approvedQuantity = parseInt(document.getElementById('lblTotalQty').textContent);
  	var allocatedQuantity = getAllocatedBuyerPOTotal();
  	
  	if(allocatedQuantity > approvedQuantity )
  	{
  		alert("Sorry! You can't continue with given buyer PO details. You are exceeding the order quantity.");
  		return false;
  	}
	if(allocatedQuantity < approvedQuantity )
  	{
  		alert("Sorry! Tha Allocation Qty Is Less Than Order Qty");
  		return false;
  	}
	
	return true;
}

function isCombinationAvailable(combineText, checkPossition)
{
	var availbleCount = 0;
	var tbl = document.getElementById('BuyerPO');
	for ( var loop = checkPossition ;loop < tbl.rows.length ; loop ++ )
  	{
  		var buyerPO = tbl.rows[loop].cells[1].textContent;
		var deliveryDate = tbl.rows[loop].cells[5].textContent;
		
		//=============================================================
		// Comment On - 02/26/2016
		// Comment By - Nalin Jayakody
		// Comment For - To validate only buyer po no.
		//=============================================================	

		// var combination = buyerPO + deliveryDate;

		//=============================================================	
		var combination = buyerPO;
		//alert("Main BPO - " + combineText + " Validate BPO ->" + combination + " Possition ->" + loop);

		if(combination == combineText){

			//alert(combination);
			availbleCount ++;
		}

  	}	
  	if(availbleCount >= 1 )
  		return true;
  	
  	return false;
}

function getAllocatedBuyerPOTotal()
{
	var tbl = document.getElementById('BuyerPO');
	var totalQty = 0;
	for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
  	{
  		if (tbl.rows[loop].cells[2].textContent == "" || tbl.rows[loop].cells[2].textContent == null)
			tbl.rows[loop].cells[2].textContent = "1";
  		var qty = parseInt(tbl.rows[loop].cells[2].textContent);

		totalQty +=  qty;
  	}	
  	return totalQty;
}



function saveDelBPO()
{
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var tbl = document.getElementById('BuyerPO');

	var scNo = $("#cboSR option:selected").text();
	//alert(tbl.rows.length);
	//if (tbl.rows.length <= 1)
	if (tbl.rows.length <= 0)
	{
		if(!confirm("No buyer PO available. This may cause to delete all delivery schedules and buyer PO allocations. Do you want to continue ?"))
			return ;
	}
	if(ValidateBPOSaving())
	{
		showPleaseWait();//hem  -21/09/2011
		
		//============================================================================================
		// Comment On - 11/02/2015
		// Comment By - Nalin Jayakody
		// Comment For - Avoid to delete delivery details while saving the delivery information
		//============================================================================================
		 var url  = 'preordermiddletire.php?RequestType=removeDelivery&styleID=' + URLEncode(StyleNo) ;
		 var obj = $.ajax({url:url,async:false}) 
		//============================================================================================
		
		var booAllDeliveries = 0;
		
		if($("#chkForAll").is(":checked")){ booAllDeliveries =1;}
		
		responseCount = 0;
		var tbl = document.getElementById('BuyerPO');
	
	
		var saved=0;
		var tosaved=0;
		requestCount = tbl.rows.length - 1;
		
		//for (var loop = 1 ; loop < tbl.rows.length ; loop ++ )
		for (var loop = 0 ; loop < tbl.rows.length ; loop ++ )
		{
			
			tosaved++;
			var buyerPO 	= tbl.rows[loop].cells[1].textContent;	
			var bpoQty 		= tbl.rows[loop].cells[2].textContent;
			var bpoCountry 	= tbl.rows[loop].cells[3].id;
			var bpoLeadTime = tbl.rows[loop].cells[4].id;
			var bpoDelivery = tbl.rows[loop].cells[5].textContent;
			//alert("bpoDelivery");
			var bpoEstimate = tbl.rows[loop].cells[6].textContent;
			var bpoHandover = tbl.rows[loop].cells[7].textContent;
			var bpoShipMode = tbl.rows[loop].cells[8].id;
			var bpoRemarks 	= tbl.rows[loop].cells[9].textContent;
			//var bpoRefNo = tbl.rows[loop].cells[9].textContent;
			//var handOverDate = tbl.rows[loop].cells[10].textContent;
			
			// ================================================================
			var bpoDeliveryStatus 	= tbl.rows[loop].cells[10].id;
			var bpoCutOffDate		= tbl.rows[loop].cells[11].textContent;
			var bpoProdStatus		= tbl.rows[loop].cells[12].textContent;
			var bpoPrevoius			= tbl.rows[loop].cells[14].textContent;
			var bpoManuLocation     = tbl.rows[loop].cells[13].id;
			var bpoShortShipped 	= tbl.rows[loop].cells[15].textContent;
                        var ibpoShrtShipReason  = tbl.rows[loop].cells[16].textContent;

			
			
			if(booAllDeliveries == 1){ bpoManuLocation = $("#cmbProductionLocation").val();}
			
			
			if(bpoDeliveryStatus == ''){ bpoDeliveryStatus = 1};
			if((bpoCutOffDate == "-") || (bpoCutOffDate=='')) { bpoCutOffDate = "01/00/1901";} 
			
			//==========================================================
			// Add On - 11/10/2015
			// Add by - Nalin Jayakody
			// Add For - Update material ratio buyer po number with new po number
			//==========================================================
		/*	var urlmr 		= 'preordermiddletire.php?RequestType=UpdateMR&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius) ;
			var htmlObjMR	= $.ajax({url:urlmr, async:false});
			var XMLresultMR	= htmlObjMR.responseXML.getElementsByTagName("Value");
			var res2		= XMLresultMR[0].childNodes[0].nodeValue;
			//==========================================================
			
			//==========================================================
			// Add On - 11/10/2015
			// Add by - Nalin Jayakody
			// Add For - Update purchaseorder details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdatePO&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPO	= $.ajax({url:urlPO, async:false});
			var XMLresultPO	= htmlObjPO.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultPO[0].childNodes[0].nodeValue;
			//==========================================================
						
			//==========================================================
			// Add On - 11/12/2015
			// Add by - Nalin Jayakody
			// Add For - Update GRN details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateGRN&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPO	= $.ajax({url:urlPO, async:false});
			var XMLresultPO	= htmlObjPO.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultPO[0].childNodes[0].nodeValue;
			
			//==========================================================
			
			//==========================================================
			// Add On - 11/12/2015
			// Add by - Nalin Jayakody
			// Add For - Update Stocktransaction details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateSTR&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPO	= $.ajax({url:urlPO, async:false});
			var XMLresultPO	= htmlObjPO.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultPO[0].childNodes[0].nodeValue;
			
			//==========================================================

			//==========================================================
			// Add On - 05/06/2016
			// Add by - Nalin Jayakody
			// Add For - Update Style Ratio details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateSR&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjSR	= $.ajax({url:urlPO, async:false});
			var XMLresultSR	= htmlObjSR.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultSR[0].childNodes[0].nodeValue;
			
			//==========================================================

			//==========================================================
			// Add On - 05/06/2016
			// Add by - Nalin Jayakody
			// Add For - Update Issue details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateIS&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjIS	= $.ajax({url:urlPO, async:false});
			var XMLresultIS	= htmlObjIS.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultIS[0].childNodes[0].nodeValue;
			
			//==========================================================

			//==========================================================
			// Add On - 05/24/2016
			// Add by - Nalin Jayakody
			// Add For - Update Materail Requestion details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateMAT&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjMAT	= $.ajax({url:urlPO, async:false});
			var XMLresultMA	= htmlObjMAT.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultMA[0].childNodes[0].nodeValue;
			
			//==========================================================

			//==========================================================
			// Add On - 05/24/2016
			// Add by - Nalin Jayakody
			// Add For - Update Gate Pass details buyer po number with new po number
			//==========================================================
			var urlPO 		= 'preordermiddletire.php?RequestType=UpdateGP&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjGP	= $.ajax({url:urlPO, async:false});
			var XMLresultGP	= htmlObjGP.responseXML.getElementsByTagName("Value");
			var res3		= XMLresultGP[0].childNodes[0].nodeValue;
			
			//==========================================================

			//==========================================================
			// Add On - 05/24/2016
			// Add by - Nalin Jayakody
			// Add For - Update D2D section buyer po numbers while changing the BPO in GAPRO
			//==========================================================
			// Table Name - d2d_transfer_details
                        
			var urlTR		= 'preordermiddletire.php?RequestType=UpdateTR&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjTR	= $.ajax({url:urlTR, async:false});
			var XMLresultTR	= htmlObjTR.responseXML.getElementsByTagName("Value");
			var resTR		= XMLresultTR[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_cut_dtlmarker

			var urlmarker	= 'preordermiddletire.php?RequestType=UpdateMK&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjMK	= $.ajax({url:urlmarker, async:false});
			var XMLresultMK	= htmlObjMK.responseXML.getElementsByTagName("Value");
			var resMK	= XMLresultMK[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_cut_budlesheet

			var urlBS	= 'preordermiddletire.php?RequestType=UpdateBS&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjBS	= $.ajax({url:urlBS, async:false});
			var XMLresultBS	= htmlObjBS.responseXML.getElementsByTagName("Value");
			var resBS	= XMLresultBS[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_LineIn_Deatils

			var urlLI	= 'preordermiddletire.php?RequestType=UpdateLI&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjLI	= $.ajax({url:urlLI, async:false});
			var XMLresultLI	= htmlObjLI.responseXML.getElementsByTagName("Value");
			var resLI	= XMLresultLI[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_LineOut_details

			var urlLO	= 'preordermiddletire.php?RequestType=UpdateLO&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjLO	= $.ajax({url:urlLO, async:false});
			var XMLresultLO	= htmlObjLO.responseXML.getElementsByTagName("Value");
			var resLO	= XMLresultLO[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_AqlDetails

			var urlAQ		= 'preordermiddletire.php?RequestType=UpdateAQ&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjAQ	= $.ajax({url:urlAQ, async:false});
			var XMLresultAQ	= htmlObjAQ.responseXML.getElementsByTagName("Value");
			var resAQ		= XMLresultAQ[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_Pack_Local_header

			var urlPL	= 'preordermiddletire.php?RequestType=UpdatePL&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPL	= $.ajax({url:urlPL, async:false});
			var XMLresultPL	= htmlObjPL.responseXML.getElementsByTagName("Value");
			var resPL	= XMLresultPL[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_Pack_Export_Header

			var urlPE		= 'preordermiddletire.php?RequestType=UpdatePE&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPE	= $.ajax({url:urlPE, async:false});
			var XMLresultPE	= htmlObjPE.responseXML.getElementsByTagName("Value");
			var resPE		= XMLresultPE[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_pack_washing_details

			var urlPW	= 'preordermiddletire.php?RequestType=UpdatePW&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjPW	= $.ajax({url:urlPW, async:false});
			var XMLresultPW	= htmlObjPW.responseXML.getElementsByTagName("Value");
			var resPW	= XMLresultPW[0].childNodes[0].nodeValue;

			//==========================================================
			
			// Table Name - d2d_packing_sc_transfer_detail

			var urlST	= 'preordermiddletire.php?RequestType=UpdateST&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjST	= $.ajax({url:urlST, async:false});
			var XMLresultST	= htmlObjST.responseXML.getElementsByTagName("Value");
			var resST	= XMLresultST[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_packing_sc_transfer_detail TO

			var urlTT	= 'preordermiddletire.php?RequestType=UpdateTT&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjTT	= $.ajax({url:urlTT, async:false});
			var XMLresultTT	= htmlObjTT.responseXML.getElementsByTagName("Value");
			var resTT	= XMLresultTT[0].childNodes[0].nodeValue;

			//==========================================================

			// Table Name - d2d_fineshedgood_point

			var urlFG	= 'preordermiddletire.php?RequestType=UpdateFG&styleID=' + URLEncode(scNo) + '&buyerPO=' + URLEncode(buyerPO) + '&prvbuyerPO=' + URLEncode(bpoPrevoius);
			var htmlObjFG	= $.ajax({url:urlFG, async:false});
			var XMLresultFG	= htmlObjFG.responseXML.getElementsByTagName("Value");
			var resFG	= XMLresultFG[0].childNodes[0].nodeValue;
                */       
			//==========================================================

			
			//==========================================================
			// Add On - Add manufacturing location to the delivery schedule
			// Add by - Nalin Jayakody
			// Add On - 12/29/2015 
			//==========================================================

			//==========================================================
			// Add On - Save previous BPO number to the table
			// Add by - Nalin Jayakody
			// Add On - 06/07/2016 
			//==========================================================
			//var url2 = 'preordermiddletire.php?RequestType=AddDeliveryBPO&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&bpoQty=' + bpoQty + '&bpoLeadTime=' + bpoLeadTime + '&bpoDelivery=' + bpoDelivery + '&bpoEstimate=' + bpoEstimate + '&bpoHandover=' + bpoHandover + '&bpoShipMode=' + bpoShipMode + '&bpoRemarks=' + URLEncode(bpoRemarks) + '&bpoCountry=' + URLEncode(bpoCountry) + '&bpoDeliStatus='+ URLEncode(bpoDeliveryStatus) + '&bpoCutOffDate=' + bpoCutOffDate + '&manuLocationId=' + URLEncode(bpoManuLocation) + "&shipStatus=" + bpoShortShipped  /*+ '&bpoRefNo=' +bpoRefNo+'&handOverDate='+handOverDate*/;
			var url2 = 'preordermiddletire.php?RequestType=AddDeliveryBPO&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&bpoQty=' + bpoQty + '&bpoLeadTime=' + bpoLeadTime + '&bpoDelivery=' + bpoDelivery + '&bpoEstimate=' + bpoEstimate + '&bpoHandover=' + bpoHandover + '&bpoShipMode=' + bpoShipMode + '&bpoRemarks=' + URLEncode(bpoRemarks) + '&bpoCountry=' + URLEncode(bpoCountry) + '&bpoDeliStatus='+ URLEncode(bpoDeliveryStatus) + '&bpoCutOffDate=' + bpoCutOffDate + '&manuLocationId=' + URLEncode(bpoManuLocation) + "&shipStatus=" + bpoShortShipped + "&prvBPO=" + bpoPrevoius + "&ishtreason=" + ibpoShrtShipReason /*+ '&bpoRefNo=' +bpoRefNo+'&handOverDate='+handOverDate*/;
			var obj2 = $.ajax({url:url2,async:false})
			var XMLresult	= obj2.responseXML.getElementsByTagName("Value");
			var res1=XMLresult[0].childNodes[0].nodeValue;
			
			saved+= parseFloat(res1);//hem  -21/09/2011
			
		}
		
		if(tosaved==saved){
			alert('Saved successfully.');//hem  -21/09/2011
		}
		else{
			alert('Save failed.');//hem  -21/09/2011
		}
	
	}
	$("#chkForAll").prop('checked',false);
		//var url3 = 'preordermiddletire.php?RequestType=updateDeliveryDetails&styleID=' + URLEncode(StyleNo);
		//var obj3 = $.ajax({url:url3,async:false})
	hidePleaseWait();//hem  -21/09/2011
}

function changeToTextBoxBPO(obj)
{
	var  currentTxt = obj.innerHTML;
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	//var newdiv = document.createElement('div');
	//newdiv.innerHTML = "<input type=\"text\" value =\""+ currentTxt + "\">";
	obj.innerHTML = "<input type=\"text\" class=\"txtbox\" value =\""+ currentTxt + "\" onblur=\"changeToTableCell(this);displayAllocatedTotal();\" size=\"9\" >";
	obj.childNodes[0].focus();
}



function changeToTableCellBPO(obj)
{
	obj.parentNode.innerHTML = obj.value;
}

function RemovePONumberFromGrid(obj)
{
	//alert(document.getElementById('lblStyleNo').innerHTML);
    
        var td = obj.parentNode;
	var tr = td.parentNode;
	
	document.getElementById('txtbuyerpo').value 		= tr.cells[1].textContent;	
	document.getElementById('txtqty').value 		= tr.cells[2].textContent;
	document.getElementById('cbocountry').value 		= tr.cells[3].id;
	document.getElementById('cboLeadTime').value 		= tr.cells[4].id;
	document.getElementById('deliverydateDD').value 	= tr.cells[5].textContent;
	document.getElementById('estimatedDD').value 		= tr.cells[6].textContent;
	document.getElementById('handoverDD').value 		= tr.cells[7].textContent;
	document.getElementById('cboShippingMode').value 	= tr.cells[8].id;
	document.getElementById('txtremarks').value 		= tr.cells[9].textContent;	
	document.getElementById('cmbDeliveryStatus').value 	= tr.cells[10].id;
	document.getElementById('dtCutOff').value 		= tr.cells[11].textContent;
        
        // Check 

	
	$("#cboPreviousBPO").val("-1");
	$("#hndShipStatus").val(tr.cells[12].textContent);
	$("#cmbProductionLocation").val(tr.cells[13].id);
	$("#hndOldBuyerPo").val(tr.cells[14].textContent);

	if(tr.cells[15].textContent == '1')
		$("#chkShortShipped").prop("checked", true);
	else
		$("#chkShortShipped").prop("checked", false);

		
	tr.parentNode.removeChild(tr);
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	
	var buyerpo = tr.cells[1].textContent;
	var qty     = tr.cells[2].textContent;
	var country = tr.cells[3].textContent;
	var leadTime= tr.cells[4].textContent;
	var delDate = tr.cells[5].textContent;
	var estDate = tr.cells[6].textContent;
	var handDate = tr.cells[7].textContent;
	var shipMod = tr.cells[8].textContent;
	var rmarks  = tr.cells[9].textContent;
	
	
	document.getElementById('txttotalqty').value = parseFloat(document.getElementById('txttotalqty').value - qty);		
	
}

function reloadDeliverySchedue()
{

}

function RemoveAllBPODeliveries()
{

	var tbl = document.getElementById('tblDelivery');
	for ( var loop = tbl.rows.length-1 ;loop > 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}
		
}

function showBPODeliveryFormMenu(StyleNo)
{	
	
	var scNo = $("#cboSR option:selected").text();
	
	var url = 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Type=P' + '&scno='+scNo;
	//showBackGround('divBG',0);
	html =$.ajax({url:url,async:false});
	drawPopupBox(1010,670,'frmstylewise',1);
	document.getElementById('frmstylewise').innerHTML = html.responseText;
}
//Start 31-03-2010 bookmark (Validate the ratio qty with confirm po qty.cannot decrease po qty)
function ValidateWithPoQty(obj)
 {
                        var ratioQty = (obj.value=="" ? 0:parseFloat(obj.value));
                        var poQty 	 = parseFloat(obj.parentNode.parentNode.id);
                        var jobqty = parseFloat(obj.parentNode.id);
                        //alert("ratio Qty 1= "+ ratioQty+" poQty = "+poQty+" jobQty = "+jobqty);
                         if((poQty+jobqty)>ratioQty){
                                 alert("Sorry!\nYou cannot decrease the current Ratio Qty than PO Qty or Interjob Qty.\n Po Qty : " + poQty+"\n InterJob Qty : "+jobqty+"\nCurrent Ratio Qty : "+ ratioQty);
                                        obj.value=poQty+jobqty;
                         }else{
                                obj.value=ratioQty;
                         }
                         doLoadCalculation();
						 }




function ValidateWithPoQtyCon(val)
{

   var posId             =   val.id;
   var pos               =   posId.substring(2);
   var wastCell          =   posId.substring(0,4);
   
        if(wastCell != "wast")
        {
             var tmpRatioId        =   "txtratio"+pos;
             var tmp2ratioId       =   tmpRatioId.split("|");
             var ratioId           =   tmp2ratioId[0];
             //alert("ratioId0 = "+tmp2ratioId[0]+" ratioId1 = "+tmp2ratioId[1]+ " posId = "+posId.substring(0,4));
             var ratioQty          =   parseFloat(document.getElementById(""+ratioId+"").value);

             var poQty             =   parseFloat(val.parentNode.parentNode.id);
             var jobqty            =   parseFloat(val.parentNode.id);

              //alert("ratio Qty> = "+ ratioQty+" poQty = "+poQty+" jobQty = "+jobqty);


               if((poQty+jobqty)>ratioQty){
                       alert("Sorry!\nYou cannot decrease the current Ratio Qty than PO Qty or Interjob Qty.\n Po Qty : " + poQty+"\n InterJob Qty : "+jobqty+"\nCurrent Ratio Qty : "+ ratioQty);
                              document.getElementById(""+ratioId+"").value = poQty+jobqty;
                              document.getElementById(""+posId+"").value =0;
               }else{
                              document.getElementById(""+ratioId+"").value = ratioQty;
               }

               doLoadCalculation();
         }
}



function ValidateWithPoQtyConX(val)
{

   var posId             =   val.id;
   var pos               =   posId.substring(2);
   var wastCell          =   posId.substring(0,4);
   
        if(wastCell != "wast")
        {
             var tmpRatioId        =   "txtratio"+pos;
             var tmp2ratioId       =   tmpRatioId.split("|");
             var ratioId           =   tmp2ratioId[0];
             //alert("ratioId0 = "+tmp2ratioId[0]+" ratioId1 = "+tmp2ratioId[1]+ " posId = "+posId.substring(0,4));
             var ratioQty          =   parseFloat(document.getElementById(""+ratioId+"").value);
	var ratioQty = (val.value=="" ? 0:parseFloat(val.value));
	var poQty 	 = parseFloat(val.parentNode.parentNode.id);
	var jobqty = parseFloat(val.parentNode.id);
	//alert(poQty);
	 if((poQty+jobqty)>ratioQty){
		 alert("Sorry!\nYou cannot decrease the current Ratio Qty than PO Qty or Interjob Qty.\n Po Qty : " + poQty+"\n InterJob Qty : "+jobqty+"\nCurrent Ratio Qty : "+ ratioQty);
			document.getElementById(""+ratioId+"").value = poQty+jobqty;
            document.getElementById(""+posId+"").value =0;
			val.value=poQty+jobqty;
	 }else{
	 	val.value=ratioQty;
		document.getElementById(""+ratioId+"").value = ratioQty;
	 }
	

			doLoadCalculation();
		}
}
						 
//function ValidateWithPoQtyCon(val)
//{
//
//var posId             =   val.id;
//   var pos               =   posId.substring(2);
//   var wastCell          =   posId.substring(0,4);
//   
// if(wastCell != "wast")
//        {
//             var tmpRatioId        =   "txtratio"+pos;
//             var tmp2ratioId       =   tmpRatioId.split("|");
//             var ratioId           =   tmp2ratioId[0];
//			// var ratioQty          =   parseFloat(document.getElementById(""+ratioId+"").value);
//             //var poQty             =   parseFloat(val.parentNode.parentNode.id);
//            // var jobqty            =   parseFloat(val.parentNode.id);
//            
//	var ratioQty = (obj.value=="" ? 0:parseFloat(obj.value));
//	var poQty 	 = parseFloat(obj.parentNode.parentNode.id);
//	var jobqty = parseFloat(obj.parentNode.id);
//
//
//
//	//alert(poQty);
//	
//
//
//	if((poQty+jobqty)>ratioQty){
//		 alert("Sorry!\nYou cannot decrease the current Ratio Qty than PO Qty or Interjob Qty.\n Po Qty : " + poQty+"\n InterJob Qty : "+jobqty+"\nCurrent Ratio Qty : "+ ratioQty);
//		document.getElementById(""+ratioId+"").value = poQty+jobqty;
//        document.getElementById(""+posId+"").value =0;
//
//        obj.value=poQty+jobqty;
//	 }else{
//	 	obj.value=ratioQty;
//		document.getElementById(""+ratioId+"").value = ratioQty;
//
//	 }
//	 doLoadCalculation();
//	}
//
//}
//End 31-03-2010 bookmark (Validate the ratio qty with confirm po qty.cannot decrease po qty)
//Start 31-03-2010 (open popup to view raised po qty)
function ShowPORaisedQtyWindow()
{
	drawPopupAreaLayer(702,280,'frmMatRatio1',6);
		  
	var HTMLText = "<table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmMatRatio1'),event);\">" +
						"<td width=\"24%\" height=\"18\" bgcolor=\"#316895\" class=\"normaltxtmidb2\">Purchase Order Confirm Qty Details</td>" +
						"<td width=\"1%\" height=\"18\" bgcolor=\"#316895\" class=\"normaltxtmidb2\"><img src=\"images/cross.png\" alt=\"close\"  class=\"mouseover\" onClick=\"closeLayer();\" /></td>" +
						"</tr>" +
					"</table></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td class=\"bcgl1\"><table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  >" +
	
					  "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td height=\"22\" bgcolor=\"#3379C6\" class=\"normaltxtmidb2\">Ratios</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><div id=\"divPoQtyRatio\" style=\"overflow:scroll; height:189px; width:700px;\">" +
						"</div></td>" +
					 "</tr>" +
					 "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +				
					 
					"</table></td>" +
				  "</tr>" +
				"</table>";	
				
	var frame = document.createElement("div");
    frame.id = "ratioselectwindow1";
	document.getElementById('frmMatRatio1').innerHTML=HTMLText;	
	
	ShowPORaisedQtyWindowDetails();
}

function ShowPORaisedQtyWindowDetails()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = "";
	try
	{
		buyerPONo = document.getElementById("cbopono").value;
	}
	catch(err)
	{
		buyerPONo = "#Main Ratio#"
	}
	createNewXMLHttpRequest(2);
	xmlHttpreq[2].onreadystatechange = ShowPORaisedQtyWindowDetailsRequest;
	xmlHttpreq[2].open("GET", 'bomMiddletire.php?RequestType=GetMatRatioPoQty&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&ItemID=' + loadItem , true);
	xmlHttpreq[2].send(null);
}

function ShowPORaisedQtyWindowDetailsRequest()
{
	if(xmlHttpreq[2].readyState == 4 && xmlHttpreq[2].status == 200) 
	{
		var colorIndex = 0;
		var sizeIndex = 0;
		var colors = [];
		var sizes = [];
		var PoQty_loop	= [];
		var POQty_Colsize = new Array;
		
		var Qtys = [];			 
		 
		var XMLStyleID = xmlHttpreq[2].responseXML.getElementsByTagName("StyleNo");		
			 var XMLBuyerPO = xmlHttpreq[2].responseXML.getElementsByTagName("BuyerPONo");
			 var XMLColor = xmlHttpreq[2].responseXML.getElementsByTagName("Color");
			 var XMLSize = xmlHttpreq[2].responseXML.getElementsByTagName("Size");
			 var XMLQty = xmlHttpreq[2].responseXML.getElementsByTagName("Qty");
			 var XMLBalQty = xmlHttpreq[2].responseXML.getElementsByTagName("BalQty");
			 var XMLPoQty = xmlHttpreq[2].responseXML.getElementsByTagName("PoQty");			 
		
		for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var color  = XMLColor[loop].childNodes[0].nodeValue;
				var size = XMLSize[loop].childNodes[0].nodeValue;
				Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
				PoQty_loop[loop] = XMLPoQty[loop].childNodes[0].nodeValue;				
				if(!findItem(color,colors))
				{
					POQty_Colsize[colorIndex] = new Array;
					colors[colorIndex] = color;
					colorIndex ++;
				}

				if(!findItem(size,sizes))
				{
					sizes[sizeIndex] = size;
					sizeIndex ++;
				}
			 }
				
					for (x in colors)
					{
						for (i in sizes)
						{
							 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
							 {
								var color  = XMLColor[loop].childNodes[0].nodeValue;
								var size = XMLSize[loop].childNodes[0].nodeValue;
								PoQty_loop[loop] = XMLPoQty[loop].childNodes[0].nodeValue;				
				
									if(colors[x]==color && (sizes[i]==size)){
											POQty_Colsize[x][i]=Math.round(PoQty_loop[loop]);
									}
							 }
								if(POQty_Colsize[x][i]>0){
								}
								else{
											POQty_Colsize[x][i]=0;
								}
						}
					}
				var tablewidth = 450 + (7 * sizes.length);
		
			// Create The table header
			var HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblPoQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			for (i in sizes)
			{
				HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">" + sizes[i] + "</div></td>";
			}
			
			HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
						"</tr>" ;
			
			// Create Table body
			var loopindex = 0;
			
			for (x in colors)
			{
				HTMLText += "<tr>" +
							"<td class=\"normalfnt\">" + colors[x] + "</td>" ;
				for (i in sizes)
				{
					HTMLText += "<td><div align=\"center\">" +
								"<input name=\"txtratio\" disabled type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" class=\"txtbox\" value=\"" + POQty_Colsize[x][i] + "\" onkeyup=\"ChangeCellValue(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtPoratio" + x + "" + i + "\" size=\"7\" />" +
								"</div></td>";
					loopindex ++;
				}
				
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
						"</div></td>" +
						"</tr>";
			}
			
			// Create table footer
			
			HTMLText += "<tr>" +
						"<td class=\"normalfnt\">Total</td>";
			
			for (i in sizes)
			{
				HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
							"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
						"</div></td>" + 
						"</tr>" ;
			
			// -----------------------------------------------------------		
			
			document.getElementById("divPoQtyRatio").innerHTML = HTMLText;
	}
}
//End 31-03-2010 (open popup to view raised po qty)
function LoadAllocation(obj,type)
{
	alloType =type; 
	if(type == 'BOM')
	{
		if (!hasStyleRatio)
		{
			alert("Sorry! Can't proceed with allocation. \nStyle ratio is not enterd to this style. You should set Style ratio First.");	
			return ;
		}
	
		var rw				= obj.parentNode.parentNode;
		var matDetailId 	= rw.cells[5].id;
		var bomQty			= rw.cells[10].childNodes[0].nodeValue;
		var freightPrice	= rw.cells[11].childNodes[0].nodeValue;
		var styleId 		= document.getElementById('lblStyleNo').innerHTML;
	}
	else if(type == 'POItem')
	{
		var rw				= obj.parentNode.parentNode;
		var matDetailId 	= rw.cells[1].id;
		var bomQty			= rw.cells[2].id;
		var freightPrice	=rw.cells[3].id;
		var styleId 		= document.getElementById('cboOrderNo').value;
	}
        // ======================================================
        // Add By - Nalin Jayakody
        // Add On - 01/25/2017
        // Add For - Load Left Over allocation form
        // ======================================================
        else if(type == 'frmPopItem')
	{
		var rw			= obj.parentNode.parentNode;
		var matDetailId 	= rw.cells[1].id;
                var strSize             = rw.cells[3].innerHTML;
                var strColor            = rw.cells[2].innerHTML;
		var bomQty		= rw.cells[2].id;
		var freightPrice	= rw.cells[3].id;
		var styleId 		= document.getElementById('cboStyleNo').value;
                var buyerPONo           = encodeURIComponent(rw.cells[4].innerHTML);
                //alert(buyerPONo);
	}
	
	
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=ShowExtraRequest;
	//xmlHttp.open("GET",'allocation_inbom/allocation.php?matDetailId='+matDetailId+ '&styleId=' +styleId+'&bomQty='+bomQty+ '&FreightPrice='+freightPrice,true);
        xmlHttp.open("GET",'allocation_inbom/allocation.php?matDetailId='+matDetailId+ '&styleId=' +styleId+'&bomQty='+bomQty+ '&FreightPrice='+freightPrice+"&strColor='"+strColor+"'&strSize='"+strSize+"'&buyerPO="+buyerPONo,true);
	xmlHttp.send(null);
}

	function ShowExtraRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupArea(820,510,'frmAllocation');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmAllocation').innerHTML=HTMLText;	
                                viewLeftOver();
				//test();
				//validatePopUp('realtooltip2');
			}
		}
	}
	
function calCostPCwithExcess(totQty,totVal)
{
	var costPC = parseFloat(parseFloat(totVal)/totQty);
		costPC = costPC.toFixed(4);		
	return costPC;
}

function getStyleIDtoCombo(obj)
{
	document.getElementById('cboStyles').value = obj.value;
}

function loadBomReport(styleID)
{
	if (!hasStyleRatio)
	{
		alert("Sorry! Can't proceed with 'BOM Report'. \nStyle ratio is not enterd to this style. You should set Style ratio First.");	
		return ;
	}
	
	window.open("bomitemreport.php?styleID=" + styleID,'frmbom'); 	
}

function EnableEnterSubmitLoadItems(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				FilterLoadedItems();	
}
function calExQtyForDeliverySchedule(Qty)
{
	var ExPct = parseFloat(document.getElementById('txtexcessqty').value);
	var exQty = parseInt(RoundNumbers(Qty*(100+ExPct)/100,0));
	
	/*var orderQty = parseFloat(document.getElementById('txtQTY').value);
	var totOrderQty = parseInt(RoundNumbers(orderQty*(100+ExPct)/100,0));
	
	var tblDelQtywithEx = parseInt(getAllocatedQtywithEx());
	var totOrderQtywithEx = (tblDelQtywithEx+exQty);
	
	if(totOrderQtywithEx>totOrderQty)
		exQty = totOrderQty-tblDelQtywithEx;*/
		//alert(exQty);
	document.getElementById('excqty').value = exQty;
}

function getStyleandSC()
{
		//alert(document.getElementById('cboOrderNo').value);
		//document.getElementById('cboStyles').value = document.getElementById('cboOrderNo').value;
		document.getElementById('cboSR').value = document.getElementById('cboOrderNo').value;
}

function getOrderNo()
{
	document.getElementById('cboOrderNo').value = document.getElementById('cboStyles').value;
}

/*function showWaitingWindow()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = window.innerWidth + 'px';
   popupbox.style.height = window.innerHeight + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<div style=\"margin-top:300px\" align=\"center\"><img src=\"../../images/load.gif\"/></div>",
	document.body.appendChild(popupbox);
}*/

function closeWaitingWindow()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

//start 2010-10-15 calculate required quntity 
// if req qty <1 reqQty = 1 -- 
function calculateReqQty(Qty,Conpc)
{
	ReqQty = parseFloat(Qty)* parseFloat(Conpc);
	
	if(ReqQty <1)
		ReqQty =1;
	else
		ReqQty = RoundNumbers(ReqQty,0);
		
	return ReqQty;
}

// start 2010-10-16 get order nos according to style  no ---------------------------------------
function getStylewiseOrderNo()
{
	var stytleName = document.getElementById('cboStyles').value;
	
	if(stytleName != 'Select One')
	{
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNum";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	}
	else
	{
		location = "bom.php?styleName="+stytleName;
		}
				
}
function getStylewiseOrderNoNew()
{
	var stytleName = document.getElementById('cboStyles').value;
	
	//if(stytleName != 'Select One')
	//{
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStylewiseOrderNoNew";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	//}
	//else
	//{
		//location = "bom.php?styleName="+stytleName;
		//}
				
}
//end ------------------------------------------------------------------------------------------

//start 2010-10-20 total order calculation & total value
function calculateTotalQty(Qty,Conpc,wastage,exQty,mainCatID)
{
	ReqQty = (parseFloat(Qty)* parseFloat(Conpc)).toFixed(4);
	
	exQty = getExpercentage(mainCatID,exQty);
	wastage = getWastagePercentage(mainCatID,wastage);
	
	//var totalQty = parseFloat(ReqQty) + (parseFloat(ReqQty) * parseFloat(wastage) / 100) + (parseFloat(ReqQty) *  parseFloat(exQty) / 100) ;
	var totalQty = parseFloat(ReqQty) + (parseFloat(ReqQty) * parseFloat(wastage) / 100) ;
	totalQty = Math.round(totalQty);
	return totalQty;
}

function calculateCostValue(totalQty,unitPrice,freight)
{
	var value = parseFloat(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight));
	
	value = RoundNumbers(value,4);
	
	return value;
}
//end -----------------------------------------------

//2010-10-21 start calculating material ratio qty
function calculateMaterialRatioQty(qty,totconsumption,exPercentage,conPC,purchaseType,matCatId)
{
	qty = parseFloat(qty);
	totconsumption = parseFloat(totconsumption);
	exPercentage = getExpercentage(matCatId,exPercentage);
	//var matQty = (qty + (qty * exPercentage / 100)) *  totconsumption; //Comment this because this formula add wastage with ex qty
	
	//=============================================================================
	// Comment On - 11/27/2015 
	// Comment For - Remove calculation for excess precentage quantity
	//============================================================================= 
	//var matQty = (qty *  totconsumption) + ((qty * exPercentage / 100) * conPC);
	//============================================================================= 
	var matQty = (qty *  totconsumption);
	
	if(purchaseType=="NONE")
	{
			matQty = Math.round(matQty);
	}
	else
	{
		if(matQty<1)
			matQty = Math.round(matQty);
		else
			matQty = Math.round(matQty);
	}
	
	return matQty;
	
}
//2010-10-21  -------------------end---------------------------------------------
function getExpercentage(mainCatID,exQty)
{
	var id = parseInt(mainCatID);
	var exPercent=exQty;
	
	switch(id)
	{
		case 1:
		{
			if(_1ExcessAllowed == false)
				exPercent =0;
			break;
		}
		case 2:
		{
			if(_2ExcessAllowed == false)
				exPercent =0;
			break;
		}
		case 3:
		{
			if(_3ExcessAllowed == false)
				exPercent =0;
			break;
		}
		case 4:
		{
			if(_4ExcessAllowed == false)
				exPercent =0;
			break;
		}
		case 5:
		{
			if(_5ExcessAllowed == false)
				exPercent =0;
			break;
		}
		case 6:
		{
			if(_6ExcessAllowed == false)
				exPercent =0;
			break;
		}
	}
	
	return exPercent;
}

function getWastagePercentage(mainCatID,wastage)
{
	var id = parseInt(mainCatID);
	var wastagePercent=wastage;
	
	switch(id)
	{
		case 1:
		{
			if(_1WastageAllowed == false)
				wastagePercent =0;
			break;
		}
		case 2:
		{
			if(_2WastageAllowed == false)
				wastagePercent =0;
			break;
		}
		case 3:
		{
			if(_3WastageAllowed == false)
				wastagePercent =0;
			break;
		}
		case 4:
		{
			if(_4WastageAllowed == false)
				wastagePercent =0;
			break;
		}
		case 5:
		{
			if(_5WastageAllowed == false)
				wastagePercent =0;
			break;
		}
		case 6:
		{
			if(_6WastageAllowed == false)
				wastagePercent =0;
			break;
		}
	}
	
	return wastagePercent;	
}
function validateUnitprice()
{
	var itemPrice = parseFloat(document.getElementById('itemPrice').title);
	//alert(itemPrice);	
	var unitprice = parseFloat(document.getElementById('txtunitprice').value);	
	
	if(!canIncreaseItemUnitprice)
	{
		if(unitprice>itemPrice)
		{
			alert("Sorry you do not have permission to increase item unitprice ");
			document.getElementById('txtunitprice').value = document.getElementById('itemPrice').title;
			return false;
		}
	}

}
function getItemUnitprice(itemid)
{	
    var style = document.getElementById("cboStyles").value;
	var url = "bomMiddletire.php?RequestType=getItemUnitprice&itemCode="+itemid+ "&style="+style;	
	var htmlobj=$.ajax({url:url,async:false});
	var itemprice = htmlobj.responseXML.getElementsByTagName('itemUnitprice')[0].childNodes[0].nodeValue;
	
	return itemprice;
}

function ValueChanged(){
	isPriceChanged = true;
}

function CompareDate(DeliDate, CutOffDate){
	
	var splitDelDate = DeliDate.split("/");
	var splitCutOffDate = CutOffDate.split("/"); 
	
	var dtDeliDate = new Date(splitDelDate[2], splitDelDate[1], splitDelDate[0] );

	var dtCutOffDate = new Date(splitCutOffDate [2], splitCutOffDate [1], splitCutOffDate [0]);

	if(dtCutOffDate > dtDeliDate){return false; }else{return true;}
	
}

function ChangeBPONo(prmTotReqQty, prmTotOrderQty){
	
	var styleNo 	= document.getElementById('lblStyleNo').innerHTML;
	
	var buyerPONo 	= $("#cbopono").val();
	
	
	// Calculate consumption of the Pcs.
	var conPc 	= (prmTotReqQty/prmTotOrderQty);
	
	// Get buyer PO qty from buyer
	var strSql 	= "bomMiddletire.php?RequestType=GetStyleRatio&styleNo=" + URLEncode(styleNo) + "&buyerPONo=" + URLEncode(buyerPONo);	
	var htmlObj 	= $.ajax({url:strSql, async:false});
	
	var XMLbuyerPOQty = htmlObj.responseXML.getElementsByTagName("TotalBuyerPoNo");
	
	var buyerPOQty 	= XMLbuyerPOQty[0].childNodes[0].nodeValue;
        // alert(buyerPOQty);
	document.getElementById('bpo_Qty').value = buyerPOQty;
	document.getElementById('bpo_Qty1').value = buyerPOQty;
        
	var reqBPOQty	= Math.round(conPc * buyerPOQty);
        //alert(reqBPOQty);
        //alert("conPc = "+conPc+" buyerPOQty = "+buyerPOQty+" reqBPOQty = "+reqBPOQty);
	$("#txttotalorder").val(reqBPOQty);
        var bomDetail         =   document.getElementById('matDetail').value;
        var strBomDetail      =   bomDetail.split("|");
        var matDetails        =   strBomDetail[0];
	
        if(matDetails=="FAB"){
            document.getElementById('balQty').innerHTML ="Balance Qty = "+0;
        } 
        
}

function SetSerialStyleRatio(){

	var maxSerialNo = 0;
	var styleNo 	= document.getElementById('lblStyleNo').innerHTML;

	//Get max serial number of the style ratio
	var strURL 		= "bomMiddletire.php?RequestType=GetMaxSerial&styleNo=" + URLEncode(styleNo);
	var htmlObj 	= $.ajax({url:strURL, async:false});

	var XMLMaxSerialNo = htmlObj.responseXML.getElementsByTagName("serialCount");

	maxSerialNo 	= parseInt(XMLMaxSerialNo[0].childNodes[0].nodeValue);

	var newMaxNo 	= maxSerialNo + 1;

	//Set max serial number to the #Main Ratio# in style ratio
	var strUpdateURL = "bomMiddletire.php?RequestType=UpdateMaxSerial&styleNo=" + URLEncode(styleNo)+"&maxserial="+newMaxNo;
	var htmlUpdateObj = $.ajax({url:strUpdateURL, async:false});

}

function popupupload(styleId, orderQty){

	var	popupWindow= window.open ("styleratio/uploader_ratio.php?No=" + styleId + "&Qty=" + orderQty , "Upload Style Ratio","location=1,status=1,scrollbars=1,width=450,height=200");
	popupWindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popupWindow.focus();	
}
