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
var MatColor = [];
var arrayColorIsPo = [];
var arraySizeIsPo = [];
var MatSize	 = [];
//End 31-03-2010 bookmark (all arrays are define)
var pub_ResponceCount = 0;
var checkLoop 			= 0;
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
	drawPopupArea(600,450,'frmItems');
	var HTMLText = "<table width=\"600\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Select Item </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						   "<tr>"+
							"<td height=\"25\">&nbsp;</td>"+
							"<td width=\"17%\" class=\"normalfnt\">Material</td>"+
							"<td align=\"left\" width=\"80%\"><label>"+
							  "<select name=\"cboMaterial\" onchange=\"LoadMaterialCategories();\" class=\"txtbox\" id=\"cboMaterial\" style=\"width:200px\" tabindex=\"1\">"+
								"<option value=\"1\">Fabric</option>"+
								"<option value=\"2\">Accessories</option>"+
								"<option value=\"3\">Packing Material</option>"+
								"<option value=\"4\">Services</option>"+
								"<option value=\"5\">Other</option>"+
							  "</select>"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"25\">&nbsp;</td>"+
							"<td width=\"17%\" class=\"normalfnt\">Category</td>"+
							"<td align=\"left\" width=\"80%\"><label>"+
							  "<select name=\"cboCategory\" class=\"txtbox\" onchange=\"LoadItems();\" id=\"cboCategory\" style=\"width:200px\" tabindex=\"1\">"+
							  "</select>"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"24\">&nbsp;</td>"+
							"<td class=\"normalfnt\">Item</td>"+
							"<td align=\"left\">"+
							  "<select name=\"cboItems\" onchange=\"LoadItemDetails();\" class=\"txtbox\" id=\"cboItems\" style=\"width:320px\" tabindex=\"2\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"24\">&nbsp;</td>"+
							"<td class=\"normalfnt\"></td>"+
							"<td align=\"left\" valign=\"top\">"+
							  "<input type=\"text\" id=\"txtFilter\" style=\"width:200px\" class=\"txtbox\"><img src=\"images/manage.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"FilterLoadedItems();\"  >"+
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
										"<td width=\"33%\">"+
										"<input name=\"txtconsumpc2\"  onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" tabindex=\"3\" value=\"0\" />"+
										"</td>"+
										"<td colspan=\"2\" align=\"left\">"+
										  "<select name=\"cboUnits\" class=\"txtbox\" onchange=\"ConvertToDefaultUnit();\" id=\"cboUnits\" style=\"width:150px;\" tabindex=\"4\">"+
										  "</select><input name=\"chkConvert\" type=\"checkbox\" id=\"chkConvert\" value=\"checkbox\" /> Convert"+
										"</td>"+
										"</tr>"+
									  "<tr>"+
										"<td height=\"25\" class=\"normalfnt\">Unit Price</td>"+
										"<td>"+
										  "<input name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"5\" value=\"0\" />"+
										"</td>"+
										"<td width=\"14%\" class=\"normalfnt\">Wastage</td>"+
										"<td width=\"35%\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"0\" tabindex=\"6\"/>"+
										"</td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Origin</td>"+
										"<td>"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"7\" style=\"width:135px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Freight</span></td>"+
										"<td><input name=\"txtfreight\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"8\" value=\"0\" /></td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Purchase Type</td>"+
										"<td>"+
										  "<select name=\"cboPurchaseType\" class=\"txtbox\" id=\"cboPurchaseType\" tabindex=\"7\" style=\"width:135px\">"+
										   "<option value=\"NONE\">NONE</option>" +
											"<option value=\"COLOR\">COLOR</option>" +
											"<option value=\"SIZE\">SIZE</option>" +
											"<option value=\"BOTH\">BOTH</option>" +												    
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Placement</span></td>"+
										"<td><input name=\"txtPlacement\" type=\"text\" class=\"txtbox\" id=\"txtPlacement\" tabindex=\"8\" value=\" \" /></td>"+
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
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"AddDataToGrid();\" /></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
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

}

function closeWindow()
{
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
	RemoveItems();
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
			 var XMLID = xmlHttp.responseXML.getElementsByTagName("itemID");
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
			document.getElementById("cboItems").value = "Select One";
				
			
		}
	}
}

function LoadAvailableUnits()
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleUnits;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetUnits', true);
    xmlHttp.send(null); 
}

function HandleUnits()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("unit");
			 for ( var loop = 0; loop < XMLName.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLName[loop].childNodes[0].nodeValue;
				document.getElementById("cboUnits").options.add(opt);
			 }
			document.getElementById("cboUnits").value = currentUnit;
			previousUnit = currentUnit;
		}
	}
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
			 document.getElementById("cboUnits").value = XMLUnit[0].childNodes[0].nodeValue;
			 document.getElementById("txtwastage").value = XMLWastage[0].childNodes[0].nodeValue;
			 if (document.getElementById("txtwastage").value == "")
			 	document.getElementById("txtwastage").value = 0;
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
			alert("Please enter the correct consumption");
			document.getElementById('txtconsumpc2').focus();
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
				if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
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
}

function ValidateItemAddingForm()
{
	if (document.getElementById('cboItems').value == "Select One")
	{
		alert("Please select the itme you wish to add.");
		document.getElementById('cboItems').focus();
		return false;
	}
	else if (document.getElementById('txtconsumpc2').value == null || document.getElementById('txtconsumpc2').value == "")
	{
		alert("Please enter the correct consumption");
		document.getElementById('txtconsumpc2').focus();
		return false;
	}
	else if (document.getElementById("txtunitprice").value == null || document.getElementById("txtunitprice").value == "")
	{
		alert("Please enter the unit price");
		document.getElementById('txtunitprice').focus();
		return false;
	}
	
	
	var tbl = document.getElementById('tblVariations');
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
	}	
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
	if ((selection == '1' || selection == 'F')  && wastage>0 && FABRICWastageAllowed == false)
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
		cellRatio.innerHTML = "<div align=\"center\"><img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" ></div>";
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
	cellmaterial.innerHTML = material;
	
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
	var ReqQty = qty *  parseFloat(conPc);
	// ----------------
	var totalQty = 0;
	
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		totalQty = ReqQty  ;
	}
	else
	{
	 	totalQty = ReqQty + (ReqQty * wastage / 100) + (ReqQty *  exQty / 100) ;
	}
	// ----------------
	
	var cellTotQty = row.insertCell(8);     
	cellTotQty.className="normalfntRiteSML";
	var reqQty = qty *  parseFloat(conPc);
	cellTotQty.innerHTML = RoundNumbers(totalQty,2);
	
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
	
	var OrderType = "FOB";
	if (parseFloat(unitPrice) <= 0 )
	{
		OrderType = "NFE";
	}
	var cellOrderType = row.insertCell(12);     
	cellOrderType.className="normalfntMid";
	cellOrderType.id = originid;
	cellOrderType.innerHTML = OrderType;
	
	// ----------------------
	var price = 0;
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	
	// ----------------------
	//var price = qty * parseFloat(conPc) *  parseFloat(unitPrice);
	var cellOrderPrice = row.insertCell(13);     
	cellOrderPrice.className="normalfntRiteSML";
	cellOrderPrice.innerHTML = RoundNumbers(price,4);
	
	var value = parseFloat(conPc) *  parseFloat(unitPrice);
	var cellOrderValue = row.insertCell(14);     
	cellOrderValue.className="normalfntRiteSML";
	cellOrderValue.innerHTML =  RoundNumbers(value,4);
					
	var cellPurchaseType = row.insertCell(15);     
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
	
	
	var totalQty = RoundNumbers(reqQty + (reqQty * parseInt(document.getElementById('txtexcessqty').value,10) / 100),4);
	var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice + wastage),4);
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	SaveItem(styleNo,itemCode,unitType,unitPrice,conPc,wastage,purchaseType,OrderType,placement,ratioType,reqQty,totalQty,totalValue,value,freight,originid);
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
	var tbl = document.getElementById('tblVariations');
	 for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	 {
	 	tbl.deleteRow(loop);
	 }
	document.getElementById('txtconsumpc2').value = "0";
	document.getElementById('txtunitprice').value = "0";
	document.getElementById('txtwastage').value = "0";
	document.getElementById('txtfreight').value = "0";
	document.getElementById("cboItems").value = "Select One";
	document.getElementById("cboCategory").value = "Select One";
	document.getElementById("chkvariations").checked = false;
	document.getElementById('cboPurchaseType').value = "NONE";
	document.getElementById('txtPlacement').value = ' ' ;
	document.getElementById("cboCategory").focus();
}

var currentEditingRow = -1;
function ShowEditForm(itemcode)
{

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
	var df= tbl.rows[p].cells[15];
	currentUnit = tbl.rows[p].cells[9].id;
	var itemName = tbl.rows[p].cells[5].lastChild.nodeValue;
	var purchaseType = tbl.rows[p].cells[15].lastChild.value;
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

	
	drawPopupArea(600,425,'frmItems');
	var HTMLText = "<table width=\"600\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Edit Item - " + itemName + " </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"24\">&nbsp;</td>"+
							"<td class=\"normalfnt\">Item</td>"+
							"<td align=\"left\">"+
							  "<select name=\"cboItems\"" +  disableUnits + " onchange=\"LoadItemDetails();\" class=\"txtbox\" id=\"cboItems\" style=\"width:320px\" tabindex=\"2\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							"</td>"+
						  "</tr>"+
						   "<tr>"+
							"<td height=\"24\">&nbsp;</td>"+
							"<td class=\"normalfnt\"></td>"+
							"<td align=\"left\" valign=\"top\">"+
							  "<input type=\"text\" id=\"txtFilter\" " +  disableUnits + "  style=\"width:200px\" class=\"txtbox\"><img src=\"images/manage.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"LoadCategoryItemsForText('" + itemcode + "');\"  >"+
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
										"<td width=\"33%\" id=\"" + conPC + "\">"+
										"<input name=\"txtconsumpc2\"  onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" tabindex=\"3\" value=\"" + conPC + "\" />"+
										"</td>"+
										"<td colspan=\"2\" align=\"left\">"+
										  "<select name=\"cboUnits\" " + disableUnits + " class=\"txtbox\" onchange=\"ConvertToDefaultUnit();\" id=\"cboUnits\" style=\"width:150px;\" tabindex=\"4\">"+
										  "</select><input name=\"chkConvert\" type=\"checkbox\" id=\"chkConvert\" value=\"checkbox\" /> Convert"+
										"</td>"+
										"</tr>"+
									  "<tr>"+
										"<td height=\"25\" class=\"normalfnt\">Unit Price</td>"+
										"<td id=\"" + unitPrice + "\">"+
										  "<input name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"5\" value=\"" + unitPrice + "\" />"+
										"</td>"+
										"<td width=\"14%\" class=\"normalfnt\">Wastage</td>"+
										"<td width=\"35%\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"" + wastage + "\" tabindex=\"6\"/>"+
										"</td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Origin</td>"+
										"<td>"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"7\" style=\"width:135px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Freight</span></td>"+
										"<td><input name=\"txtfreight\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"8\" value=\"" + freight + "\" /></td>"+
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\">Purchase Type</td>"+
										"<td>"+
										  "<select name=\"cboPurchaseType\" class=\"txtbox\" id=\"cboPurchaseType\" tabindex=\"7\" style=\"width:135px\">"+
										   "<option value=\"NONE\">NONE</option>" +
											"<option value=\"COLOR\">COLOR</option>" +
											"<option value=\"SIZE\">SIZE</option>" +
											"<option value=\"BOTH\">BOTH</option>" +												    
										  "</select>"+
										"</td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Placement</span></td>"+
										"<td><input name=\"txtPlacement\" type=\"text\" class=\"txtbox\" id=\"txtPlacement\" tabindex=\"8\" value=\"" + placement + "\" /></td>"+
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
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"UpdateConsumptions('" + itemcode + "');\" /></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
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
		
	}


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
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
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
	if(newMatCost > preOrderCost)
	{
		alert("Sorry you are exceeding the minimum CM level. Modification has been rejected.");
		return ;
	}
	
	var p = currentEditingRow;
	/*
	var lc=-1;
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{		
		var rw = tbl.rows[loop];
        var currentCode = rw.cells[5].id;
		if (currentCode == currentItemCode)
		{
			p ++;
			lc = loop;
			break;		
		}
		p ++;
	}	
	alert(p);
	*/
	var purchasedQty = tbl.rows[p].cells[18].lastChild.nodeValue;
	
	ModifyTable(p,purchaseType,placement,itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID);

	
	calculateCMValue();
	
}

function LoadCategoryItems(itemcode)
{
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleItemCategories;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetItemListforCategory&styleID=' + itemcode , true);
    thirdxmlHttp.send(null); 
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
	var ReqQty = qty *  parseFloat(conPc);
	var totalQty = 0;	
	
	if ((selection == '1' || selection == 'F')  && wastage>0 && FABRICWastageAllowed == false)
	{
		alert("Fabric wastages not allowed in your company.");	
		document.getElementById('txtwastage').focus();
		return false;
	}
	
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		totalQty = parseFloat(ReqQty)  ;
	}
	else
	{
			totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
	}

	
	var purchasedQty  = parseFloat(tbl.rows[position].cells[18].lastChild.nodeValue);
	if (totalQty < purchasedQty)
	{
		alert("The material quantity already purchased. You can't decrease it further more.\nPurchased Qty : " + purchasedQty  + "\nMatirial Qty       : " + totalQty );
		return;
	}
	
	var exQty = parseInt(document.getElementById('txtexcessqty').value);
	tbl.rows[position].cells[0].id = itemCode;
	tbl.rows[position].cells[0].lastChild.id = itemCode;
	tbl.rows[position].cells[5].id = itemCode;
	tbl.rows[position].cells[5].lastChild.id=itemCode;
	tbl.rows[position].cells[5].lastChild.nodeValue = itemDescription;
	tbl.rows[position].cells[6].lastChild.nodeValue = RoundNumbers(conPc,consumptionDecimalLength);
	tbl.rows[position].cells[7].lastChild.nodeValue  = wastage;
	
	
	

	tbl.rows[position].cells[8].lastChild.nodeValue = RoundNumbers(totalQty,2);
	
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
	tbl.rows[position].cells[12].id = originid;
	tbl.rows[position].cells[12].lastChild.nodeValue  = OrderType;
	
	var price = 0;
	var value = 0;
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		value = price * qty;
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) *  parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		value = price * qty;		
	}

	//var price = qty * parseFloat(conPc) *  parseFloat(unitPrice);
	tbl.rows[position].cells[13].lastChild.nodeValue  = RoundNumbers(price,4);
	
	//var value = parseFloat(conPc) *  parseFloat(unitPrice);

	tbl.rows[position].cells[14].lastChild.nodeValue =  RoundNumbers(value,4);
					
	var opt = tbl.rows[position].cells[15].childNodes[1];
	if (opt == undefined)
		opt = tbl.rows[position].cells[15].childNodes[0];
	
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
		tbl.rows[position].cells[2].innerHTML = "<div align=\"center\"><img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" ></div>";
	}
	else
	{
		tbl.rows[position].cells[2].innerHTML = "<div align=\"center\"><img src=\"images/matratio.png\" class=\"mouseover\" style=\"visibility:hidden;\" onclick=\"ShowMaterialRatiowindow(this);\" /></div>"; 
	}
	//tbl.rows[position].cells[15].lastChild.nodeValue =  purchaseType;
	
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
	var value = (parseFloat(conPc) + parseFloat(conPc * wastage / 100) ) *  parseFloat(unitPrice + freight);
	var reqQty = qty *  parseFloat(conPc);
	
	//var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice),4);
	var totalValue = RoundNumbers((conPc +  (conPc * wastage / 100)) * qty * (unitPrice + freight),4);
	
	UpdateItem(styleNo,currentItemCode,newItemCode,unitType,unitPrice,conPc,wastage,purchaseType,orderType,placement,ratioType,reqQty,totalQty,totalValue,value,freight,originid)
			
}

function getTotalMaterialCost()
{
	var totalMaterialCost = 0 ;
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
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

		if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		}
		else
		{
			price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
		}
		
		totalMaterialCost = parseFloat(totalMaterialCost) + parseFloat(price);
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
		var value = parseFloat(tbl.rows[loop].cells[13].lastChild.nodeValue);
		var avgprice = parseFloat(tbl.rows[loop].cells[19].lastChild.nodeValue);
		var baseunitPrice = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var conPc = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue);
		var freight = parseFloat(tbl.rows[loop].cells[11].lastChild.nodeValue);
		var selection = tbl.rows[loop].cells[4].id;
		var unitPrice = baseunitPrice - parseFloat(isNaN(avgprice / conPc) ? 0 : (avgprice / conPc));
		//var unitPrice = baseunitPrice - parseFloat(avgprice / conPc) ;
		var	originName = tbl.rows[loop].cells[17].lastChild.nodeValue  ;
		var price = 0;

		if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		}
		else
		{
			price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
		}
		
		if (originName.charAt(originName.length-1) == "F" ||originName.charAt(originName.length-1)== "f" )
			totalfinancecost += parseFloat(price);			
	}
	var financeValue = totalfinancecost * fiancePctng /100;
	return financeValue;
}

function calculateCMValue()
{
	var matCost = getTotalMaterialCost();
	var finance = getMaterialFinance();
	//var cm = fob - matCost - (fob * parseFloat(EscPercentage)) -finance + upcharge;
	var cm = fob - matCost -finance - parseFloat(escCharge) + upcharge;
	document.getElementById('cmvnow').value = RoundNumbers(cm,4);
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
				alert("Failed");	
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
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var itemid = obj.parentNode.id;
	var purchaseType = obj.value;
	
	if (obj.value == "NONE")
	{
		var purchasedQty = obj.parentNode.parentNode.cells[18].childNodes[0].nodeValue;
		obj.parentNode.parentNode.cells[2].childNodes[0].innerHTML = "<img src=\"images/matratio.png\" class=\"mouseover\" onclick=\"ShowMaterialRatiowindow(this," + purchasedQty + ");\" />";
		obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "visible";
		obj.parentNode.parentNode.className="backcolorWhite";
	}
	else if (obj.value == "COLOR" || purchaseType == "BOTH")
	{
		obj.parentNode.parentNode.cells[2].childNodes[0].innerHTML = "<img src=\"images/variation.png\" onclick=\"showContrastWindow(this);\"  class=\"mouseover\" >";
		obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "";
		obj.parentNode.parentNode.className="bcgcolor-tblrow";
	}
	else
	{
		obj.parentNode.parentNode.cells[2].childNodes[0].childNodes[0].style.visibility = "hidden";
		obj.parentNode.parentNode.className="bcgcolor-tblrow";
	}

	createAltXMLHttpRequest();
	altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdatePurchaseType&styleNo=' + URLEncode(StyleNo) + '&ItemID=' +  itemid + '&purchaseType=' + obj.value, true);
	altxmlHttp.send(null); 
}

function ShowStyleRatiowindow()
{
	matRatioRequest= false;
	if (isPurchased && isSuperStyleRatioEditot == false)
	{
		alert("Sorry! You can't proceed with style ratio change.\nSome materials already purchased.");	
		return ;
	}
	drawPopupArea(702,432,'frmRatio');
	var StyleNo = document.getElementById('lblStyleNo').innerHTML;
	var SCNO = document.getElementById('scNo').innerHTML;
	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var totqty = parseInt(orderQty,10) + (parseInt(orderQty,10) * parseInt(ExQty,10) / 100);
	var HTMLText = "<table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmRatio'),event);\">" +
						"<td width=\"25%\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style Ratio - [ Style : " + StyleNo + " ]  &nbsp;&nbsp;    [ SCNO : " + SCNO + " ]</td>" +
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
							  "<td colspan=\"4\" class=\"normalfnt\">&nbsp;</td>" +
							  "<td width=\"1%\">&nbsp;</td>" +
							"</tr>" +
							"<tr>" +
							  "<td>&nbsp;</td>" +
							  "<td class=\"normalfnt\">Total Order Qty</td>" +
							  "<td class=\"normalfnt\"><input name=\"txttotalorder\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txttotalorder\" value=\"" + orderQty + "\" /></td>" +
							  "<td width=\"12%\" class=\"normalfnt\">Buyer PO Qty</td>" +
							  "<td width=\"21%\" class=\"normalfnt\"><input name=\"txtbuyerpo\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txtbuyerpo\" size=\"20\" value=\"" + orderQty + "\" /></td>" +
							  "<td width=\"12%\" class=\"normalfnt\">Exess%</td>" +
							  "<td width=\"15%\" class=\"normalfnt\"><input name=\"txtexces\" type=\"text\" disabled=\"disabled\" class=\"txtbox\" id=\"txtexces\" size=\"15\" value=\"" + ExQty + "\"  /></td>" +
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
					  "<tr>" +
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"31\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"24%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							  "<td width=\"20%\" bgcolor=\"#D6E7F5\"><img src=\"../../images/new.png\" alt=\"new\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"showColorSizeSelector('s');\" /></td>" +
							  "<td width=\"18%\" bgcolor=\"#D6E7F5\"><img src=\"../../images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\"SaveStyleRatio();\" /></td>" +
							  "<td width=\"14%\" bgcolor=\"#D6E7F5\"><img src=\"../../images/close.png\" alt=\"close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeWindow();\" /></td>" +
							  "<td width=\"24%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table></td>" +
				  "</tr>" +
				"</table>";	
				
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
			opt.value = orderQty;
			document.getElementById("cbopono").options.add(opt);
			
			
			
			 var XMLPO = xmlHttp.responseXML.getElementsByTagName("PONO");
			 var XMLQTY = xmlHttp.responseXML.getElementsByTagName("QTY");
			 for ( var loop = 0; loop < XMLPO.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLPO[loop].childNodes[0].nodeValue;
				opt.value = XMLQTY[loop].childNodes[0].nodeValue;
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
	var poqty = parseInt(document.getElementById("cbopono").value,10);
	document.getElementById('txtbuyerpo').value = poqty;
	var exqtypc = parseInt(document.getElementById("txtexces").value,10); 
	var exqtyratio = poqty + (poqty * exqtypc / 100);
	document.getElementById('exratioHeader').innerHTML = "Ratio for Qty " + parseInt(exqtyratio,10) + " (Order Qty + Excess Qty)";
	LoadStyleRatio();
}

function showColorSizeSelector(ratiowindow)
{
	
	drawPopupBox(500,435,'frmSelector',3);
	//drawPopupAreaLayer(500,435,'frmSelector',3);
	var HTMLText = "<table width=\"500\" border=\"0\" style=\"background-color: rgb(244, 233, 215);\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmSelector'),event);\">" +
						"<td width=\"486\" height=\"24\" bgcolor=\"#fcb334\" class=\"TitleN2white\">Select Colors and Sizes</td>" +
					  "</tr>" +
					  
					  "<tr>" +
						"<td height=\"367\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
						  "<tr>" +
							"<td height=\"20\" colspan=\"3\" bgcolor=\"#fcb334\" class=\"normaltxtmidb2L\">Colors</td>" +
							"</tr>" +
						  "<tr>" +
							"<td width=\"46%\" class=\"normalfntMid\">Colors</td>" +
							"<td width=\"8%\" >&nbsp;</td>" +
							"<td width=\"46%\" class=\"normalfntMid\">Selected Colors</td>" +
						  "</tr>" +
						  "<tr>" +
							"<td height=\"141\" valign=\"top\"><select name=\"cbocolors\" size=\"10\" class=\"txtbox\" id=\"cbocolors\" style=\"width:225px\" ondblclick=\"MoveColorRight();\">" +
							"</select></td>" +
							"<td><table width=\"100%\" border=\"0\">" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" id=\"imgMoveRight\" onClick=\"MoveAllColorsRight();\" /></div></td>" +
							  "</tr>" +
							"</table></td>" +
							"<td valign=\"top\"><select name=\"cboselectedcolors\" size=\"10\" class=\"txtbox\" id=\"cboselectedcolors\" style=\"width:225px;\" ondblclick=\"MoveColorLeft();\">" +
							"</select>" +
												
							"</td>" +
						  "</tr>" +
						 "<tr>" +
							"<td height=\"21\" colspan=\"3\" bgcolor=\"#fcb334\" class=\"normaltxtmidb2L\">Sizes</td>" +
							"</tr>" +
						  "<tr>" +
							"<td style=\"background-color: rgb(244, 233, 215);\" class=\"normalfntMid\">Sizes</td>" +
							"<td style=\"background-color: rgb(244, 233, 215);\">&nbsp;</td>" +
							"<td style=\"background-color: rgb(244, 233, 215);\" class=\"normalfntMid\">Selected Sizes</td>" +
						  "</tr>" +
						  "<tr>" +
							"<td valign=\"top\"><select name=\"cbosizes\" size=\"10\" class=\"txtbox\" id=\"cbosizes\" style=\"width:225px\" ondblclick=\"MoveSizeRight();\">" +
									"</select></td>" +
							"<td><table width=\"100%\" border=\"0\">" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeLeft();\" /></div></td>" +
							  "</tr>" + 
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllSizesLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" id=\"imgDownMoveRight\" onClick=\"MoveAllSizesRight();\" /></div></td>" +
							  "</tr>" +
							"</table></td>" +
							"<td valign=\"top\"><select name=\"cboselectedsizes\" size=\"10\" class=\"txtbox\" id=\"cboselectedsizes\" style=\"width:225px\" ondblclick=\"MoveSizeLeft();\">" +
									"</select>"+
														
							"</td>" +
						  "</tr>" +
						"</table></td>" +
					  "</tr>" +
					  "<tr>" +
						"<td style=\"background-color: rgb(244, 233, 215);\"><table width=\"100%\" border=\"0\">" +
						  "<tr>" +
							"<td width=\"25%\">&nbsp;</td>" +
							"<td width=\"29%\"><img src=\"../../images/ok.png\" alt=\"OK\" width=\"86\" height=\"24\" class=\"mouseover\" onClick=\"AddSelection();\" /></td>" +
							"<td width=\"21%\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closePopupBox(3);\" /></td>" +
							"<td width=\"25%\">&nbsp;</td>" +
						 "</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table>"; 
					
	var frame = document.createElement("div");
    frame.id = "colorsizeselectwindow";
	document.getElementById('frmSelector').innerHTML=HTMLText;	
	
	//LoadBuyers();
	LoadAvailableColors();
	LoadAvailableSizes();
	//if(ratiowindow == 's')
		//loadVariationColors();
//Start 31-03-2010 - bookmark	
	//if(ratiowindow == 'm')
		//setDataToArray();
//End 31-03-2010 - bookmark
}

//Start 31-03-2010 - bookmark (Set all data to the arrays)
function setDataToArray()
{
	var tbl = document.getElementById('tblQtyRatio');
	var rowCount = tbl.rows.length;
	Materials = new Array(rowCount-1);
	arrayRatioQty = new Array(rowCount-1);
	for(var r=0;r<rowCount-1;r++)
	{
		var cellCount = tbl.rows[r].cells.length;
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
				}
				else
				{
					MatSize[c] 			= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;					
					arraySizeIsPo[c] 	= tbl.rows[0].cells[c].id;						 
					Materials[r][c]		= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;
					arrayRatioQty[r][c]	= tbl.rows[0].cells[c].childNodes[0].lastChild.nodeValue;
				}
			}
			else
			{
				if(c==0)
				{
					Materials[r][c] 	= tbl.rows[r].cells[c].lastChild.nodeValue;
					arrayRatioQty[r][c] = tbl.rows[r].cells[c].lastChild.nodeValue;					
				}
				else
				{
					Materials[r][c]		= parseInt(tbl.rows[r].cells[c].id);
					arrayRatioQty[r][c]	= parseInt(tbl.rows[r].cells[c].childNodes[0].childNodes[0].value);
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
				document.getElementById("cbocolors").options.add(opt);
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
				document.getElementById("cbosizes").options.add(opt);
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

function MoveColorRight()
{
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
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
	var colors = document.getElementById("cboselectedcolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
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
		if ( cmb.options[i].text.toLowerCase() == itemName.toLowerCase())
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

function MoveSizeRight()
{
	var colors = document.getElementById("cbosizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedsizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedsizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
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

function AddSelection1()
{
	if (isValidColorSizeSelection())
	{
		var colorlength = document.getElementById("cboselectedcolors").options.length;
		var sizelength = document.getElementById("cboselectedsizes").options.length;
		
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
		
		if (colors.length <= 0)
		{
			colors[0] = "N/A";
		}
		
		if (sizes.length <= 0)
		{
			sizes[0] = "N/A";
		}
		
		var tablewidth = 450 + (7 * sizes.length);
		
		// Create The table header
		var HTMLText = "";
		HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
		 			"<tr>" +					
	                "<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
		
		var celllength = parseInt(50 / sizes.length);
		
		for (i in sizes)
		{
			var y = MatSize.indexOf(sizes[i]);			/*Start 31-03-2010 bookmark*/	

			HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id="+arraySizeIsPo[y]+"><div align=\"center\">" + sizes[i] + "</div></td>";
		}
		
		HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
	              	"</tr>" ;
		
		// Create Table body
		var poValue=0;
		var ratioQty=0;
		for (x in colors)
		{
			var q = MatColor.indexOf(colors[x]);		/*Start 31-03-2010 bookmark*/
			//alert(arrayColorIsPo[q]);
			HTMLText += "<tr>" +
						"<td id="+arrayColorIsPo[q]+" class=\"normalfnt\">" + colors[x] + "</td>" ;
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
					//alert(poValue);
					var ratioQty 	= arrayRatioQty[r][c];
					poValue			= (isNaN(poValue) ? 0:poValue);
					ratioQty		= (isNaN(ratioQty) ? 0:ratioQty);
				}
				catch(err)
				{
				}
//End 31-03-2010 bookmark  (read the array and add data to the table grid)

				HTMLText += "<td id=\""+poValue+"\"><div align=\"center\">" +
		                  	"<input name=\"txtratio\" type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\"  class=\"txtbox\" value=\""+ratioQty+"\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
                			"</div></td>";
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
		//alert(loop);
		var rw = tbl.rows[loop];
        var colorName = rw.cells[0].lastChild.nodeValue;
		var optColor = document.createElement("option");
		optColor.text = colorName;
		optColor.value = colorName;
		
//Start 31-03-31 bookmark (when loading colors po colord will disabled)
		var isPo = rw.cells[0].id;
		//alert(isPo);
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
		var isPo = rw.cells[loop].id;
		if(isPo==1){
				optSize.disabled = true;
				document.getElementById('imgDownMoveRight').style.visibility = "hidden";
			}
			else
				optSize.disabled = false;
//End 31-03-31 bookmark (when loading colors po colord will disabled)
		document.getElementById("cboselectedsizes").options.add(optSize);	
	}
}
function ChangeCellValue(obj)
{
	calculateRow(obj);
	CalculateColumn(obj);
	CalculateTotal(obj);
	UpdateTables(obj);
	
}

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
			var exValue = parseInt(givenValue + (givenValue * exPercentage / 100));
			tblEx.rows[row].cells[col].lastChild.lastChild.value = exValue;
			var newObj = tblEx.rows[row].cells[col].lastChild.lastChild;
			calculateRow(newObj);
			CalculateColumn(newObj);
			CalculateTotal(newObj);
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
		alert("The color size ratio quantity not match with the PO quantity.");	
		return false;
	}
	else if (parseInt(Exqty) != ratioExqty)
	{
		alert("The color size ratio for the excess quantity not match with the PO excess quantity.");	
		return false;
	}
	
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var url = 'bomMiddletire.php?RequestType=checkPurchased2&styleID=' + URLEncode(styleNo) ;
	var obj = $.ajax({url:url,async:false});
	//bookmark1
	var XMLQty = obj.responseXML.getElementsByTagName("Qty");
			 var purchasedQty = XMLQty[0].childNodes[0].nodeValue;	
			 if(purchasedQty > 0)
			 	{
					alert('System has purchase orders for this style.First You have to remove items in the purchase order');	
					return false;
				}
	
	
	
	return true;
}

function SaveStyleRatio()
{
	if (isValidRatio())
	{
		ShowPreLoader();
		PrepairStyleRatioDatabase();
	}
}

function PrepairStyleRatioDatabase()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
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
			var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
			var b = tblQty.rows[loop].cells[i];
			var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
			var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
			var qty = tblQty.rows[loop].cells[i].lastChild.lastChild.value;
			var exQty = tblEx.rows[loop].cells[i].lastChild.lastChild.value;			
			// userID
			requestCount ++ ;
			createNewXMLHttpRequest(incr);
			//xmlHttpreq[i].onreadystatechange = HandleStyleRatioRequest;
			//xmlHttpreq[i].index = i;
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveStyleRatio&styleNo=' + URLEncode(styleNo) + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&exQty=' + exQty, true);
			xmlHttpreq[incr].send(null);
			incr ++ ;			
			
		}		
	}
	
	var tbl = document.getElementById('tblConsumption');
	var tblQty = document.getElementById("tblQtyRatio");
	
	for ( var x = 1 ;x < tbl.rows.length ; x ++ )
	{
		var dd = tbl.rows[x].cells[15];
		var purchaseType = tbl.rows[x].cells[15].childNodes[0].value;

		var itemCode = tbl.rows[x].cells[5].id;
		var conPC = parseFloat(tbl.rows[x].cells[6].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[x].cells[7].lastChild.nodeValue);
		var freightCharge = parseFloat(tbl.rows[x].cells[11].lastChild.nodeValue);
		var exPercentage = parseInt(document.getElementById("txtexcessqty").value,10);
		var mainQty = parseInt(document.getElementById("txtorderqty").value,10);
		
		
	
		if(purchaseType == "COLOR")
		{
			for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
			{
				var styleNo = document.getElementById('lblStyleNo').innerHTML;
				var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
				
				var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
				var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
				var qty = parseFloat(tblQty.rows[loop].cells[tblQty.rows[loop].cells.length -1].lastChild.lastChild.nodeValue,10);
				qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
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
				var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
				
				var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
				var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
				var qty = parseFloat(tblQty.rows[tblQty.rows.length-1].cells[i].lastChild.lastChild.nodeValue,10);
				qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
				createNewXMLHttpRequest(incr);
				xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=N/A&size=' + URLEncode(size) + '&qty=' + qty + '&posID=' + (loop - 1) + '&freight=' + freightCharge, true);
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
					var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
					
					var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
					var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
					var qty = parseFloat(tblQty.rows[loop].cells[i].lastChild.lastChild.value,10);
					//qty = Math.round((qty + (qty * exPercentage / 100)) *  totconsumption);
					qty = Math.round((qty *  totconsumption) + ((qty * exPercentage / 100) * conPC));
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
			var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
			
			var totconsumption = parseFloat(conPC + (conPC * wastage / 100));
			var qty = parseFloat(tblQty.rows[loop].cells[i].lastChild.lastChild.nodeValue,10);
			qty = Math.round((qty *  totconsumption) + ((qty * exPercentage / 100) * conPC));
			createNewXMLHttpRequest(incr);
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=N/A&size=N/A&qty=' + qty + '&posID=0' + '&freight=' + freightCharge  , true);
			xmlHttpreq[incr].send(null);
			matincr++;
			incr ++ ;	
			
			
		}
			
		
		
	}
	ValidateDataTransfer();
}

function ValidateDataTransfer()
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;

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
				alert("The style ratio has been saved succsessfully");
			}
			else
			{
				ValidateDataTransfer();
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
					"<td>&nbsp;</td>" +
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
	var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
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
			 var XMLStyleID = xmlHttpreq[1].responseXML.getElementsByTagName("StyleNo");
			 var XMLBuyerPO = xmlHttpreq[1].responseXML.getElementsByTagName("BuyerPONo");
			 var XMLColor = xmlHttpreq[1].responseXML.getElementsByTagName("Color");
			 var XMLSize = xmlHttpreq[1].responseXML.getElementsByTagName("Size");
			 var XMLQty = xmlHttpreq[1].responseXML.getElementsByTagName("Qty");
			 var XMLExQty = xmlHttpreq[1].responseXML.getElementsByTagName("ExQty");
			 var colorIndex = 0;
			 var sizeIndex = 0;
			 var colors = [];
			 var sizes = [];
			 var Qtys = [];
			 var ExQtys = [];
			 
			 
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var color  = XMLColor[loop].childNodes[0].nodeValue;
				var size = XMLSize[loop].childNodes[0].nodeValue;
				Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
				ExQtys[loop] = XMLExQty[loop].childNodes[0].nodeValue;
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
								"<input name=\"txtratio\" type=\"text\" class=\"txtbox\" value=\"" + Qtys[loopindex] + "\" onkeyup=\"ChangeCellValue(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
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
								"<input name=\"txtratio\" type=\"text\" class=\"txtbox\" value=\"" + ExQtys[loopindex] + "\" onkeyup=\"ChangeCellValueExcess(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
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
				
				if ( tblEx != null)
				{
					newObj = tblEx.rows[loop].cells[i].lastChild.lastChild;
					calculateRow(newObj);
					CalculateColumn(newObj);
					CalculateTotal(newObj);
				}

			}
			
		}	
	}
	catch(err)
	{
	}
}

var ColorSizeConsumption = 0;
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
	drawPopupArea(702,280,'frmMatRatio');
	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var wastage = obj.parentNode.parentNode.parentNode.cells[7].lastChild.nodeValue;
	var itemID = obj.parentNode.parentNode.parentNode.cells[5].id;
	var itemName = obj.parentNode.parentNode.parentNode.cells[5].lastChild.nodeValue;
	var conPC = parseFloat(obj.parentNode.parentNode.parentNode.cells[6].lastChild.nodeValue);
	var totqty = parseFloat(parseInt(orderQty) + (parseInt(orderQty) * parseFloat(ExQty) / 100) + (parseInt(orderQty) * parseFloat(wastage) / 100) ) ;
	totqty  = Math.round(totqty * conPC);
	var addingPercentage = parseFloat(ExQty) + parseFloat(wastage);
	ColorSizeConsumption = conPC + ( conPC * parseFloat(wastage) / 100 );
	loadPercentage = addingPercentage;
	loadItem = itemID ;
	var HTMLText = "<table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
				  "<tr>" +
					"<td height=\"25\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmMatRatio'),event);\">" +
						"<td width=\"25%\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Ratio - " + itemName + "</td>" +
						"</tr>" +
					"</table></td>" +
				  "</tr>" +
				  "<tr>" +
					"<td class=\"bcgl1\"><table width=\"700\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"25\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"2%\">&nbsp;</td>" +
							  "<td width=\"15%\" class=\"normalfnt\">Buyer PO No.</td>" +
							  "<td width=\"22%\" class=\"normalfnt\"><select name=\"cbopono\" class=\"txtbox\" id=\"cbopono\" onChange=\"changePOonMaterial(" + addingPercentage + "," + itemID + ");\" style=\"width:135px\">" +
								"</select>              </td>" +
								"<td class=\"normalfnt\">Total Qty</td>" +
							  "<td class=\"normalfnt\"><input name=\"txttotalorder\" type=\"text\" class=\"txtbox\" disabled=\"disabled\" id=\"txttotalorder\" value=\"" + totqty + "\" /></td>" +
							  "<td colspan=\"2\" class=\"normalfnt\">&nbsp;</td>" +
							  "<td width=\"1%\">&nbsp;</td>" +
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
						"<td>&nbsp;</td>" +
					  "</tr>" +
					  "<tr>" +
						"<td><table width=\"100%\" height=\"31\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" +
							"<tr>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							  "<td width=\"20%\" bgcolor=\"#D6E7F5\"><img src=\"images/confirmpoqty.png\" alt=\"new\"  class=\"mouseover\" onClick=\"ShowPORaisedQtyWindow();\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/new.png\" alt=\"new\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"showColorSizeSelector('m');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/save.png\" alt=\"save\" width=\"84\" height=\"24\" class=\"mouseover\" onClick=\"SaveMaterialRatio('" + itemID + "');\" /></td>" +
							  "<td width=\"15%\" bgcolor=\"#D6E7F5\"><img src=\"images/close.png\" alt=\"close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeWindow();\" /></td>" +
							 "<td width=\"15%\" bgcolor=\"#D6E7F5\">&nbsp;</td>" +
							"</tr>" +
						"</table></td>" +
					  "</tr>" +
					"</table></td>" +
				  "</tr>" +
				"</table>";	
				
	var frame = document.createElement("div");
    frame.id = "ratioselectwindow";
	document.getElementById('frmMatRatio').innerHTML=HTMLText;		
	LoadBuyerBONos();
	
	//document.getElementById("txttotalorder").value = orderQty;
	
}

function changePOonMaterial(percentage,itemID)
{
	if (document.getElementById("cbopono").value == "") return;
	var poqty = document.getElementById("cbopono").value;
	//var totQty = parseInt(poqty) + parseInt(parseFloat(poqty) * percentage / 100);
	
	// ------------------------------------------
	
	var orderQty = document.getElementById('txtorderqty').value; 
	var ExQty = document.getElementById('txtexcessqty').value;
	var wastage = curObj.parentNode.parentNode.parentNode.cells[7].lastChild.nodeValue;
	var itemID = curObj.parentNode.parentNode.parentNode.cells[5].id;
	var itemName = curObj.parentNode.parentNode.parentNode.cells[5].lastChild.nodeValue;
	var conPC = parseFloat(curObj.parentNode.parentNode.parentNode.cells[6].lastChild.nodeValue);
	var totqty = parseFloat(parseInt(poqty) + (parseInt(poqty) * parseFloat(ExQty) / 100) + (parseInt(poqty) * parseFloat(wastage) / 100) );
	totqty  = Math.round(totqty * conPC);
	
	// ------------------------------------------
	document.getElementById('txttotalorder').value = totqty;
	//LoadStyleRatio();
	var buyerPONo = "";
	try
	{
		buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
	}
	catch(err)
	{
		buyerPONo = "#Main Ratio#"
	}
	var styleNo = document.getElementById('lblStyleNo').innerHTML;		

	

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
//Start 31-03-2010 - bookmark
			 var XMLBalQty		= xmlHttpreq[1].responseXML.getElementsByTagName("BalQty");
			 var XMLPoQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("PoQty");
			 var XMLtotPoQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("totPoQty");
			 
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
			 var colorPoDone_loop	= [];
			 var sizePoDone_loop	= [];
//End 31-03-2010			 
			 
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var color  = XMLColor[loop].childNodes[0].nodeValue;
				var size = XMLSize[loop].childNodes[0].nodeValue;
				Qtys[loop] = XMLQty[loop].childNodes[0].nodeValue;
//Start 31-03-2010 - bookmark				
				PoQty_loop[loop] = XMLPoQty[loop].childNodes[0].nodeValue;
				totPoQty_loop[loop] = XMLtotPoQty[loop].childNodes[0].nodeValue;
				
				colorPoDone = XMLColorPoDone[loop].childNodes[0].nodeValue;
				sizePoDone = XMLSizePoDone[loop].childNodes[0].nodeValue;
//End 31-03-2010				
				if(!findItem(color,colors))
				{
					colors[colorIndex] = color;
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
			 //alert(sizes.length);
			 // ---------------------------------------
			 
			 var tablewidth = 450 + (7 * sizes.length);
		
			// Create The table header
			var HTMLText = "";
			HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
						"<tr>" +					
						"<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
			
			var celllength = parseInt(50 / sizes.length);
			
			var y = 0;											/*31-03-2010 - bookmark*/
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
					HTMLText += "<td id="+totPoQty_loop[loopindex]+"><div align=\"center\">" +
								"<input name=\"txtratio\" type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" class=\"txtbox\" value=\"" + Qtys[loopindex] + "\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
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
			
		}
	}
	doLoadCalculation();
}

// ----------------------------------------------------------------------------

function SaveMaterialRatio(itemCode)
{
	if (isValidMaterialRatio())
	{
		ShowPreLoader();
		PrepairMatRatioDatabase(itemCode);
	}
}

function PrepairMatRatioDatabase(itemCode)
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;

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
	var tblQty = document.getElementById("tblQtyRatio");
	//var tblEx = document.getElementById("tblEXQtyRatio");
	var incr = 0;
	requestCount = 0;
	matincr = 0;
	pub_ResponceCount = 0;
	checkLoop = 0;
	for ( var loop = 1 ;loop < tblQty.rows.length -1 ; loop ++ )
	{
		for ( var i = 1 ;i < tblQty.rows[loop].cells.length -1 ; i ++ )
		{
			var styleNo = document.getElementById('lblStyleNo').innerHTML;
			var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
			var b = tblQty.rows[loop].cells[i];
			var color = tblQty.rows[loop].cells[0].lastChild.nodeValue;
			var size = tblQty.rows[0].cells[i].lastChild.lastChild.nodeValue;
			var qty = tblQty.rows[loop].cells[i].lastChild.lastChild.value;
			//var exQty = tblEx.rows[loop].cells[i].lastChild.lastChild.value;			
			// userID
			requestCount ++ ;
			createNewXMLHttpRequest(incr);
			//xmlHttpreq[i].onreadystatechange = HandleStyleRatioRequest;
			//xmlHttpreq[i].index = i;
			xmlHttpreq[incr].open("GET", 'bomMiddletire.php?RequestType=SaveMatRatio&styleNo=' + URLEncode(styleNo) + '&itemCode=' + itemCode  + '&buyerPONo=' + URLEncode(buyerPONo) + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty + '&posID=' + (loop -1 ) + '&freight=' + qty, true);
			xmlHttpreq[incr].send(null);
			incr ++ ;	
			pub_ResponceCount++;
			if (color != "N/A" || size != "N/A")
			{
				curObj.parentNode.parentNode.parentNode.className="backcolorGreen";
			}
			
		}		
	}
	ValidateMaterialRatioTransfer(itemCode,pub_ResponceCount);
	//alert("The material ratio has been saved successfully.");
	//ClosePreloader();	
}
//Start 16-06-2010 - get material ratio responce
function ValidateMaterialRatioTransfer(matDetailId,pub_ResponceCount)
{
	var styleNo = document.getElementById('lblStyleNo').innerHTML;
	var buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;

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

function isValidMaterialRatio()//bookmark;
{
	var matQty = parseInt(document.getElementById("txttotalorder").value,10);
	var tblQty = document.getElementById("tblQtyRatio");
	var ratioqty = parseInt(tblQty.rows[tblQty.rows.length-1].cells[tblQty.rows[0].cells.length -1].lastChild.lastChild.nodeValue,10);
	if (ratioqty <= 0 || matQty != ratioqty)
	{
		alert("The material ratio is not correct.");	
		return false;
	}
	return true;
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
		if ( document.getElementById("cbocolors").options[i].text.toLowerCase() == document.getElementById("txtnewcolor").value.toLowerCase())
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
			SaveColor(document.getElementById("txtnewcolor").value);
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
			optColor.text = document.getElementById("txtnewcolor").value;
			optColor.value = document.getElementById("txtnewcolor").value;
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
		if ( document.getElementById("cbosizes").options[i].text.toLowerCase() == document.getElementById("txtnewSize").value.toLowerCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbosizes").options[i].text;
				optColor.value = document.getElementById("cbosizes").options[i].text;
				document.getElementById("cboselectedsizes").options.add(optColor);

				document.getElementById("cbosizes").options[i] = null;
				
				added =true;
			}
					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
			SaveSize(document.getElementById("txtnewSize").value);
		else
			alert("The size already exists.");
	}
}	


function grabSizeEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode== 13)
	 	AddNewSize();
}

function SaveSize(SizeName)
{
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
			optColor.text = document.getElementById("txtnewSize").value;
			optColor.value = document.getElementById("txtnewSize").value;
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
						  "<td height=\"20\" colspan=\"8\" bgcolor=\"#9BBFDD\"><div align=\"center\" class=\"normalfnth2\">Delivery Schedule</div></td>"+
						  "<td height=\"20\" bgcolor=\"#9BBFDD\"><div align=\"right\" ><a href=\"#\"><img src=\"images/add-new.png\" width=\"109\" height=\"18\" border=\"0\" onclick=\"ShowAddDeliverySchedule();\" /></a></div></td>"+
						"</tr>"+
						"<tr>"+
					  "<td width=\"6%\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Edit</td>"+
					  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
					  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Delivery Date</td>"+
					  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty.</td>"+
					  "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">With Ex. Qty</td>"+
					  "<td width=\"16%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Shipping Mode</td>"+
					  "<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
					  "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Lead Time </td>"+
						"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Estimated Date </td>"+
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
			var XMLisBase = fourthxmlHttp.responseXML.getElementsByTagName("isBase");
			var XMLLeadTimeID = fourthxmlHttp.responseXML.getElementsByTagName("LeadTimeID");
			var XMLLeadTime = fourthxmlHttp.responseXML.getElementsByTagName("LeadTime");
			var XMLEstimateDate = fourthxmlHttp.responseXML.getElementsByTagName("EstimatedDate");
			
			for ( var loop = 0; loop < XMLDateofDelivery.length; loop ++)
			{
			
				var date = XMLDateofDelivery[loop].childNodes[0].nodeValue;;
				var qty = XMLQty[loop].childNodes[0].nodeValue;;
				var exqty = XMLExQty[loop].childNodes[0].nodeValue;;
				var mode = XMLShippingMode[loop].childNodes[0].nodeValue;;
				var remarks =XMLRemarks[loop].childNodes[0].nodeValue;;
				var modeID = XMLShippingModeID[loop].childNodes[0].nodeValue;
				var isbase = XMLisBase[loop].childNodes[0].nodeValue;
				var LeadTimeID = XMLLeadTimeID[loop].childNodes[0].nodeValue;
				var LeadTime = XMLLeadTime[loop].childNodes[0].nodeValue;
				var estimatedDate = XMLEstimateDate[loop].childNodes[0].nodeValue;
				
				var tbl = document.getElementById('tblDelivery');
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;
				if (isbase == 'Y')
					row.className = "bcggreen";
				else
					row.className = "bcgwhite";
				var cellEdit = row.insertCell(0);   
				cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";
				
				var cellDelete = row.insertCell(1);     
				cellDelete.innerHTML = "<div id=\"" +  date + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
				
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
				
				var cellLeadTime = row.insertCell(7);
				cellLeadTime.className="normalfntMid";
				cellLeadTime.id = LeadTimeID;
				cellLeadTime.innerHTML = LeadTime;
				
				var cellEstimated = row.insertCell(8);
				cellEstimated.className="normalfntMid";
				cellEstimated.innerHTML = estimatedDate;
				
				deliveryIndex++ ;
			}

		}
	}
}


function ValidateSchedule()
{
	if (document.getElementById('chkBase').checked && IsBaseScheduled()) return false;
	var selectedDate = document.getElementById('deliverydate').value;
	var day = selectedDate.substring(0,2);
	var month = selectedDate.substring(3,5);
	var year = selectedDate.substring(6,10);
	var selectedDate = new Date();
	selectedDate.setYear(parseInt(year));
	selectedDate.setMonth(parseInt(month,10));
	selectedDate.setDate(parseInt(day,10));
	var one_day=1000*60*60*24;
	var diff = Math.ceil((selectedDate.getTime()-serverDate.getTime())/(one_day));	
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
	else if (diff <= 1)
	{
		alert("The schedule date is not correct. Please select a date today onwards.");
		document.getElementById('deliverydate').focus()
		return false;
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
	else if (isExceedingExcessQuantity(parseInt(document.getElementById('excqty').value,10)))
	{
		alert("You are exceeding the main excess quantity. Please check it again.");
		document.getElementById('excqty').focus();
		return false;
	}
	else
	{
		return true;	
	}
	return true;
}

function IsBaseScheduled()
{
	var tbl = document.getElementById('tblDelivery');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		
		var class = tbl.rows[loop].className ;
		if (class == "bcggreen")
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
		
		var class = tbl.rows[loop].className ;
		if (class == "bcggreen" && deliveryID != tbl.rows[loop].id)
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
		var leadTime = document.getElementById('cboLeadTime').value;
		var estimateddate = document.getElementById('estimateddeliverydate').value;
		if (leadTime == "" || leadTime == null) leadTime = 11;
		var isbase= "N";
		if (document.getElementById('chkBase').checked)
			isbase= "Y";
		
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
			saveBuyerPOAllocation();			
			RemoveAllDeliveryRows();
			LoadSavedSchedules();
			alert("The delivery schedules for the style is updated.");
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
			saveBuyerPOAllocation();			
			RemoveAllDeliveryRows();
			LoadSavedSchedules();
			alert("The delivery schedules for the style is updated.");
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
	document.getElementById('excqty').value=balanceQuantity;
	document.getElementById('remarks').value="";
	document.getElementById('chkBase').checked = false;
	document.getElementById('quantity').focus();
}

function ShowAddDeliverySchedule()
{
	drawPopupArea(500,400,'frmItems');
	var Qty = parseFloat(document.getElementById('txtorderqty').value);
	var allocatedQty = getAllocatedQuantity();
	var balanceQuantity = Qty - allocatedQty;
	
	
	var HTMLText = " <table width=\"500\" class=\"bcgl1\">"+
					"<tr>"+
					 " <td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Add Delivery Schedule </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Quantity</td>"+
							"<td><label>"+
							  "<input name=\"quantity\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"quantity\" value=\"" + balanceQuantity + "\" />"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">With Excess Qty</td>"+
							"<td><label>"+
							  "<input name=\"excqty\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"excqty\" value=\"" + balanceQuantity +  "\" />"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Delivery <span class=\"normalfnt\">Date</span></td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"deliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"deliverydate\" onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+
						  "</tr>"+
						   "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Estimated Delivery Date</td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"estimateddeliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimateddeliverydate\" onclick=\"return showCalendar('estimateddeliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">&nbsp;</td>"+
							"<td style=\"padding-left:70px;\"><div class=\"normalfnt\">"+
							  "<input name=\"chkBase\" type=\"checkbox\" class=\"txtbox\" id=\"chkBase\" />"+
							" Set as Base Schedule</div></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Shipping Mode</td>"+
							"<td><label>"+
							"<select name=\"cboShippingMode\" class=\"txtbox\" id=\"cboShippingMode\" style=\"width:155px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+
						 "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:155px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Remarks<br>&nbsp;</td>"+
							"<td><label>"+
							  "<input name=\"remarks\" type=\"text\" class=\"txtboxRightAllign\" id=\"remarks\" />"+
							"</label><br>&nbsp;</td>"+
						  "</tr>"+
						  "<tr>" +
						  "<td colspan=\"3\" bgcolor=\"#0E4874\" height=\"10\" class=\"PopoupTitleclass\">Buyer PO Allocation</td>" + 
						  "</tr>" +
						  "<tr>" +
						  "<td colspan=\"3\"><div id=\"divBuyerPO\">Loading.... - Please wait.</div></td>" + 
						  "</tr>" +
						  "<tr>"+
							"<td colspan=\"3\" bgcolor=\"#D6E7F5\"><table width=\"100%\" height=\"34\">"+
							  "<tr>"+
								"<td width=\"28%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/save.png\" class=\"mouseover\" width=\"84\" height=\"24\" onClick=\"SaveNewDeliverySchedule();\" /></td>"+
								"<td width=\"21%\"><img src=\"images/close.png\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
								"<td width=\"28%\">&nbsp;</td>"+
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
	LoadLeadTimes();
	LoadPODelivery();
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
	var estDate = "";
	if(tbl.rows[position].cells[8].lastChild != null)
	estDate = tbl.rows[position].cells[8].lastChild.nodeValue;
	shippos = tbl.rows[position].cells[5].id;
	leadposition = tbl.rows[position].cells[7].id;
	var class = tbl.rows[position].className ;
	var checkedtext = "";
	if (class == "bcggreen")
		 checkedtext = "checked=\"checked\"";
	
	drawPopupArea(500,370,'frmItems');
	var HTMLText = " <table width=\"500\" class=\"bcgl1\">"+
					"<tr>"+
					 " <td><table width=\"100%\" height=\"207\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Edit Delivery Schedule </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Quantity</td>"+
							"<td><label>"+
							  "<input name=\"quantity\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"quantity\" value=\"" + qty + "\" />"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">With Excess Qty</td>"+
							"<td><label>"+
							  "<input name=\"excqty\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"excqty\" value=\"" + exqty + "\" />"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Delivery <span class=\"normalfnt\">Date</span></td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"deliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" id=\"deliverydate\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" value=\"" + date + "\" onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Estimated Delivery Date</td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"estimateddeliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" value=\"" + estDate + "\" id=\"estimateddeliverydate\" onclick=\"return showCalendar('estimateddeliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">&nbsp;</td>"+
							"<td style=\"padding-left:70px;\"><div class=\"normalfnt\">"+
							  "<input name=\"chkBase\" type=\"checkbox\"  " + checkedtext + "  class=\"txtbox\" id=\"chkBase\" />"+
							" Set as Base Schedule</div></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Shipping Mode</td>"+
							"<td><label>"+
							"<select name=\"cboShippingMode\" class=\"txtbox\" id=\"cboShippingMode\" style=\"width:155px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+
						 "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:155px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+
						  "<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Remarks</td>"+
							"<td><label>"+
							  "<input name=\"remarks\" type=\"text\" value=\"" + remarks + "\" class=\"txtboxRightAllign\" id=\"remarks\" />"+
							"</label></td>"+
						  "</tr>"+
						   "<tr>" +
						  "<td colspan=\"3\" bgcolor=\"#0E4874\" height=\"10\" class=\"PopoupTitleclass\">Buyer PO Allocation</td>" + 
						  "</tr>" +
						  "<tr>" +
						  "<td colspan=\"3\"><div id=\"divBuyerPO\">Loading.... - Please wait.</div></td>" + 
						  "</tr>" +
						  "<tr>"+
						  "<tr>"+
							"<td colspan=\"3\" bgcolor=\"#D6E7F5\"><table width=\"100%\" height=\"34\">"+
							  "<tr>"+
								"<td width=\"28%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/save.png\" width=\"84\" class=\"mouseover\" height=\"24\" onClick=\"UpdateSchedule('" + itemcode + "'," + changeLocation + ");\" /></td>"+
								"<td width=\"21%\"><img src=\"images/close.png\" width=\"97\" class=\"mouseover\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
								"<td width=\"28%\">&nbsp;</td>"+
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
	LoadLeadTimes();
	LoadPODeliveryDate(date);
}

function UpdateSchedule(deldate,deliveryID)
{
	if(ValidateScheduleModifications(deldate,deliveryID) && ValidateBPOAllocation())
	{
		var StyleNo = document.getElementById('lblStyleNo').innerHTML;
		var date = document.getElementById('deliverydate').value;
		var qty =  document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var modeID =  document.getElementById('cboShippingMode').value;
		var remarks = document.getElementById('remarks').value;
		var leadTime = document.getElementById('cboLeadTime').value;
		var estimateddate = document.getElementById('estimateddeliverydate').value;
		if (leadTime == "" || leadTime == null) leadTime = 11;
		var isbase= "N";
		if (document.getElementById('chkBase').checked)
			isbase= "Y";
		
		//createAltXMLHttpRequest();
		//altxmlHttp.onreadystatechange = HandleDeliveryUpdating;
		//altxmlHttp.open("GET", 'bomMiddletire.php?RequestType=UpdateSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&leadTime=' + leadTime + '&delDate=' + deldate + '&estimateddate=' + estimateddate, true);
		//altxmlHttp.send(null); 
		
		var updateEventSchedule = "N";
		if(confirm("The schedule change may be need to update the event schedule. Please press 'OK' button to update the event schedule as well."))
		updateEventSchedule = "Y";
		
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleDeliveryUpdating;
	altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=ChangeSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + leadTime + '&oldDate=' + deldate + '&estimateddate=' + estimateddate + '&updateEventSchedule=' + updateEventSchedule, true);
	altxmlHttp.send(null); 
		
		// --------------------------
		
		
		
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
	if (document.getElementById('chkBase').checked && IsEditedBaseScheduled(deliveryID)) return false;
	var selectedDate = document.getElementById('deliverydate').value;
	var day = selectedDate.substring(0,2);
	var month = selectedDate.substring(3,5);
	var year = selectedDate.substring(6,10);
	var selectedDate = new Date();
	selectedDate.setYear(parseInt(year));
	selectedDate.setMonth(parseInt(month,10));
	selectedDate.setDate(parseInt(day,10));
	var one_day=1000*60*60*24;
	var diff = Math.ceil((selectedDate.getTime()-serverDate.getTime())/(one_day));	
	
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
	else if (diff <= 1)
	{
		alert("The schedule date is not correct. Please select a date today onwards.");
		document.getElementById('deliverydate').focus()
		return false;
	}
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
	else if (isEditingExceedingExcessQuantity(newdate,parseInt(document.getElementById('excqty').value,10)))
	{
		alert("You are exceeding the main excess quantity. Please check it again.");
		document.getElementById('excqty').focus();
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
	var ExQty = parseInt(document.getElementById('txtorderqty').value,10);
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
	var styleNo = document.getElementById('cboStyles').value;
	location = "bom.php?styleID=" + URLEncode(styleNo);
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
	var tbl = document.getElementById('tblBuyerPO');
	var bpoQty = 0;
	var bpoExqty = 0;
	var deliveryQty = parseInt(document.getElementById('quantity').value) ;
	var deliveryExqty = parseInt(document.getElementById('excqty').value);
	var isSelected = false;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
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
	}
	
	return true;
}


function SaveNewDeliverySchedule()
{
	if (ValidateSchedule() && ValidateBPOAllocation() )
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
			
		createAltXMLHttpRequest();
		altxmlHttp.onreadystatechange = HandleNewDelivery;
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID, true);
		altxmlHttp.send(null); 
		
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
				AddScheduletoTable();
				//saveBuyerPOAllocation();		
				
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
				saveBuyerPOAllocation();
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
			var buyerPO = tbl.rows[loop].cells[1].childNodes[0].nodeValue;
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
	var intSRNO = document.getElementById('cboSR').value;
	location = "bom.php?intSRNO=" + intSRNO;
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleSCshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleID&scNo=' + scNo , true);   
	xmlHttp.send(null); 
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
	
	var styleID = document.getElementById('cboStyles').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlestyshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getSRNo&styleID=' + URLEncode(styleID) , true);   
	xmlHttp.send(null);
}

function handlestyshow()
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

		if ((selection == "1" || selection == "Fabric" || selection == "FABRIC") && FABRICExcessAllowed == false && FABRICWastageAllowed == false)
		{
			price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		}
		else
		{
			price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
		}
		
		totalMaterialCost = parseFloat(totalMaterialCost) + parseFloat(price);
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
	//bookmark1
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
	document.getElementById('cboItems').options.length = 0 ;
	var text = document.getElementById('txtFilter').value;
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleItemCategories;
    thirdxmlHttp.open("GET", 'bomMiddletire.php?RequestType=GetItemListforCategoryText&styleID=' + itemcode + '&filter=' + URLEncode(text) , true);
    thirdxmlHttp.send(null); 
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
							"<td height=\"141\" valign=\"top\"><select name=\"cbocolors\" size=\"10\" class=\"txtbox\" id=\"cbocolors\" style=\"width:225px\" ondblclick=\"MoveColorRight();\">" +
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
	var buyerpo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
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
  				selectedQty += parseInt(tbl.rows[loop].cells[3].childNodes[0].value);
  			}
  		}
	}
	var ReqQty = Math.round(selectedQty * ColorSizeConsumption);
	var d = document.getElementById('tblQtyRatio');
	//alert(document.getElementById('tblQtyRatio').childNodes[0].innerHTML);
	document.getElementById('tblQtyRatio').rows[materialRow].cells[materialCell].lastChild.lastChild.value = ReqQty;
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

	createXMLHttpRequest();
   xmlHttp.onreadystatechange = HandleBPODelScheduleWindow; // SavePreOrder
   xmlHttp.open("GET", 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Type=P' , true);   
	xmlHttp.send(null); 
}

function HandleBPODelScheduleWindow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			drawPopupArea(820,492,'frmBuyerPODelevery');
			var HTMLText = xmlHttp.responseText;
			document.getElementById('frmBuyerPODelevery').innerHTML=HTMLText;
			//document.getElementById('lblTotalQty').innerHTML = document.getElementById('txtQTY').value;
			//document.getElementById('txttotalqty').value = document.getElementById('txtQTY').value;
	
		}		
	}
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
	return true;
}

function addBPOToGrid()
{
	if(validateBuyerPO())
	{
		var txtBuyerPO = document.getElementById('txtbuyerpo').value;
		var txtQty = document.getElementById('txtqty').value;
		var countryID = document.getElementById('cbocountry').value;
		var CountryName = document.getElementById('cbocountry').options[document.getElementById('cbocountry').selectedIndex].text ;
		var leadTimeID = document.getElementById('cboLeadTime').value;
		if(leadTimeID=='')
			leadTimeID = 0;
		var leadName = " ";
		if (document.getElementById('cboLeadTime').value != null && document.getElementById('cboLeadTime').value != "")
			leadName = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text ;
		var deliveryDate = document.getElementById('deliverydateDD').value;
		var estimatedDate = document.getElementById('deliverydateDD').value;
		if (document.getElementById('estimatedDD').value != null && document.getElementById('estimatedDD').value  != "" )
			estimatedDate = document.getElementById('estimatedDD').value;
		var shippingModeID = document.getElementById('cboShippingMode').value;
		var shippingMode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text ;
		var remarks = document.getElementById('txtremarks').value;
		var refNo	= document.getElementById('txtBpRefNo').value;
		var tbl = document.getElementById('BuyerPO');
		var lastRow = tbl.rows.length;					
		var row = tbl.insertRow(lastRow);
		row.className = "backcolorWhite";
		
		row.innerHTML = "<td><img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" border=\"0\" class=\"mouseover\" onclick=\"RemovePONumberFromGrid(this);\" /></td>" +
                       "<td class=\"normalfnt\" ondblclick=\"changeToTextBoxBPO(this);\">"  + txtBuyerPO + "</td>"+
                       "<td class=\"normalfntRite\" ondblclick=\"changeToTextBoxBPO(this);\">" + txtQty +"</td>"+
                       "<td class=\"normalfntMid\" id=\"" + countryID + "\">" + CountryName + "</td>"+
                       "<td class=\"normalfnt\" id=\"" + leadTimeID + "\">" + leadName + "</td>"+
                       "<td class=\"normalfnt\">" + deliveryDate + "</td>"+
                       "<td class=\"normalfnt\">" + estimatedDate + "</td>"+
                       "<td class=\"normalfnt\" id=\"" + shippingModeID + "\">" + shippingMode + "</td>"+
                       "<td class=\"normalfnt\" NOWRAP>" + remarks + "</td>"+
						"<td class=\"normalfnt\" NOWRAP>"+refNo+"</td>";
		document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
	}
}

function displayAllocatedTotal()
{
	document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
}


function ValidateBPOSaving()
{
	var tbl = document.getElementById('BuyerPO');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var buyerPO = tbl.rows[loop].cells[1].textContent;
		var deliveryDate = tbl.rows[loop].cells[5].textContent;
		
		var combination = buyerPO + deliveryDate;
		if(isCombinationAvailable(combination))
		{
			alert("The combination of " + buyerPO + " - " + deliveryDate + " is assigned more than one time.");
			return false;
		}
  	}	
  	
  	var approvedQuantity = parseInt(document.getElementById('approvedQty').textContent);
  	var allocatedQuantity = getAllocatedBuyerPOTotal();
  	
  	if(allocatedQuantity > approvedQuantity)
  	{
  		alert("Sorry! You can't continue with given buyer PO details. You are exceeding the order quantity.");
  		return false;
  	}
	
	return true;
}

function isCombinationAvailable(combineText)
{
	var availbleCount = 0;
	var tbl = document.getElementById('BuyerPO');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var buyerPO = tbl.rows[loop].cells[1].textContent;
		var deliveryDate = tbl.rows[loop].cells[5].textContent;
		
		var combination = buyerPO + deliveryDate;
		if(combination == combineText)
			availbleCount ++;
  	}	
  	if(availbleCount > 1 )
  		return true;
  	
  	return false;
}

function getAllocatedBuyerPOTotal()
{
	var tbl = document.getElementById('BuyerPO');
	var totalQty = 0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
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
	
	if (tbl.rows.length <= 1)
	{
		if(!confirm("No buyer PO available. This may cause to delete all delivery schedules and buyer PO allocations. Do you want to continue ?"))
			return ;
	}
	if(ValidateBPOSaving())
	{
		
		var url  = 'preordermiddletire.php?RequestType=removeDelivery&styleID=' + URLEncode(StyleNo) ;
		var obj = $.ajax({url:url,async:false})
		
		
		

					responseCount = 0;
					var tbl = document.getElementById('BuyerPO');
					requestCount = tbl.rows.length - 1;
					
					for (var loop = 1 ; loop < tbl.rows.length ; loop ++ )
					{
						var buyerPO = tbl.rows[loop].cells[1].textContent;	
						var bpoQty = tbl.rows[loop].cells[2].textContent;
						var bpoCountry = tbl.rows[loop].cells[3].id;
						var bpoLeadTime = tbl.rows[loop].cells[4].id;
						var bpoDelivery = tbl.rows[loop].cells[5].textContent;
						var bpoEstimate = tbl.rows[loop].cells[6].textContent;
						var bpoShipMode = tbl.rows[loop].cells[7].id;
						var bpoRemarks = tbl.rows[loop].cells[8].textContent;
						var bpoRefNo = tbl.rows[loop].cells[9].textContent;
						
						//createNewXMLHttpRequest(loop);
					  	//xmlHttpreq[loop].index = loop;
						//xmlHttpreq[loop].onreadystatechange = function()
						//{
							//if(this.readyState == 4)
							//{	
					 			//if(this.status == 200) 
					 			//{ 
					 				
										//responseCount ++;
									//if (requestCount == responseCount )
									//{
										//alert("Buyer PO allocation completed.");
										
										//createXMLHttpRequest();
										//xmlHttp.onreadystatechange = function()
									  // {
											//if(this.readyState == 4)
											//{	
									       //	if(this.status == 200) 
									       //	{ 
									       	//	alert("Buyer PO allocation completed.");
												//alert(1);
												//getDeliveryData();
									       //	}
									      // }
									   // }
									   // xmlHttp.open("GET", 'preordermiddletire.php?RequestType=updateDeliveryDetails&styleID=' + URLEncode(StyleNo) , true);
   									// xmlHttp.send(null);
										//hidePleaseWait();
									//}
								//}			
							//}
					
						//};	
						var url2 = 'preordermiddletire.php?RequestType=AddDeliveryBPO&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&bpoQty=' + bpoQty + '&bpoLeadTime=' + bpoLeadTime + '&bpoDelivery=' + bpoDelivery + '&bpoEstimate=' + bpoEstimate + '&bpoShipMode=' + bpoShipMode + '&bpoRemarks=' + URLEncode(bpoRemarks) + '&bpoCountry=' + URLEncode(bpoCountry) + '&bpoRefNo=' +bpoRefNo;
						var obj2 = $.ajax({url:url2,async:false})
						
						
						
						
					}
							
			}
					//var url3 = 'preordermiddletire.php?RequestType=updateDeliveryDetails&styleID=' + URLEncode(StyleNo);
						//var obj3 = $.ajax({url:url3,async:false})
		alert('Saved successfully.');

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
	var td = obj.parentNode;
	var tr = td.parentNode;

	document.getElementById('txtbuyerpo').value = tr.cells[1].textContent;	
	document.getElementById('txtqty').value = tr.cells[2].textContent;
	document.getElementById('cbocountry').value = tr.cells[3].id;
	document.getElementById('cboLeadTime').value = tr.cells[4].id;
	document.getElementById('deliverydateDD').value = tr.cells[5].textContent;
	document.getElementById('estimatedDD').value = tr.cells[6].textContent;
	document.getElementById('cboShippingMode').value = tr.cells[7].id;
	document.getElementById('txtremarks').value = tr.cells[8].textContent;	
	
	tr.parentNode.removeChild(tr);
	//document.getElementById('txttotalqty').value = getCalculateTotal();
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
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = HandleBPODelScheduleWindow; // SavePreOrder
   xmlHttp.open("GET", 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Type=P' , true);   
	xmlHttp.send(null); 
}
//Start 31-03-2010 bookmark (Validate the ratio qty with confirm po qty.cannot decrease po qty)
function ValidateWithPoQty(obj)
{
	var ratioQty = (obj.value=="" ? 0:parseFloat(obj.value));
	var poQty 	 = parseFloat(obj.parentNode.parentNode.id);
	//alert("Ratio Qty :"+ratioQty+"\nPO Qty"+poQty);
	 if(poQty>ratioQty){
		 alert("Sorry!\nYou cannot decrease the current Ratio Qty than Confirm Po Qty.\nConfirm Po Qty : " + poQty+"\nCurrent Ratio Qty : "+ ratioQty);
	 	obj.value=poQty;
	 }else{
	 	obj.value=ratioQty;
	 }
	 doLoadCalculation();
}
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
						"<td width=\"1%\" height=\"18\" bgcolor=\"#316895\" class=\"normaltxtmidb2\"><div align=\"center\"<img src=\"images/cross.png\" alt=\"close\"  class=\"mouseover\" onClick=\"closeLayer();\" /></div></td>" +
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
		buyerPONo = document.getElementById("cbopono").options[document.getElementById("cbopono").selectedIndex].text;
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
					colors[colorIndex] = color;
					colorIndex ++;
				}

				if(!findItem(size,sizes))
				{
					sizes[sizeIndex] = size;
					sizeIndex ++;
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
								"<input name=\"txtratio\" type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\" class=\"txtbox\" value=\"" + PoQty_loop[loopindex] + "\" onkeyup=\"ChangeCellValue(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isNumberKey(event);\" id=\"txtPoratio" + x + "" + i + "\" size=\"7\" />" +
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
}
//End 31-03-2010 (open popup to view raised po qty)

