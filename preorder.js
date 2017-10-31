var pubPreOrderRptURL = 'gapro/';
var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var fifthxmlHttp;
var loca = -1;
var arrayLocation = 0;
var Mainvariations = [];
var shippos = 0;
var contpos = 0;
var mainDataSaving = false;
var variationsCount = 0;
var currentUnit = "";
var approvalStatus=0;
var mainpagerequest = false;
var deliveryIndex = 0;
var leadposition = 0 ;
var previousUnit = "";
var sentToapprovalComments = "";
var pub_mill	 = 0;
var isPurchase = 'FALSE';
var POorderQty=0;


var pub_transport 	= 0;
var pub_clearing 	= 0;
var pub_interest 	= 0;
var pub_export 		= 0;
var pub_slrrate		= 0;

var pub_mainCat = '';

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

function getGetDivisions()
{    
	RemoveCurrentDivisions();
	var custID = document.getElementById('cboCustomer').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleDivisions;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetDivision&CustID=' + custID, true);
    xmlHttp.send(null);     
}

function HandleDivisions()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLDivisionID = xmlHttp.responseXML.getElementsByTagName("DivisionID");
			 var XMLDivisionName = xmlHttp.responseXML.getElementsByTagName("Division");
			 for ( var loop = 0; loop < XMLDivisionID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
				opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
				document.getElementById("dboDivision").options.add(opt);
			 }
			
		}
	}
}

function RemoveCurrentDivisions()
{
	var index = document.getElementById("dboDivision").options.length;
	while(document.getElementById("dboDivision").options.length > 0) 
	{
		index --;
		document.getElementById("dboDivision").options[index] = null;
	}
}

function GetBuyingOffices()
{
	RemoveCurrentBuyingOffices();
	var custID = document.getElementById('cboCustomer').value;	
    createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleBuyingOffices;
    altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetBuyingOffice&CustID=' + custID, true);
    altxmlHttp.send(null); 
}

function RemoveCurrentBuyingOffices()
{
	var index = document.getElementById("cboBuyingOffice").options.length;
	while(document.getElementById("cboBuyingOffice").options.length > 0) 
	{
		index --;
		document.getElementById("cboBuyingOffice").options[index] = null;
	}
}

function HandleBuyingOffices()
{
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			 var XMLID = altxmlHttp.responseXML.getElementsByTagName("BuyingOfficeID");
			 var XMLName = altxmlHttp.responseXML.getElementsByTagName("BOffice");
			 for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboBuyingOffice").options.add(opt);
			 }
			
		}
	}
}

function ShowItems()
{
	if(!ValidateInterfaceComponents()) return;
	drawPopupArea(570,450,'frmItems');
	var HTMLText = "<table width=\"570\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"230\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >"+
						  "<tr>"+
							/*"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+*/
							"<td colspan=\"3\" bgcolor=\"#0E4874\" class=\"PopoupTitleclass\"><table width=\"100%\" border=\"0\" bgcolor=\"#498cc2\" class=\"mainHeading\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\" >"+
								  "<td width=\"84%\" align=\"center\" >Select Item </td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" class=\"mouseover\"/></td>"+
								"</tr>"+
							  "</table></td>"+
						  "</tr>"+
						   "<tr>"+
							/*"<td  width=\"1\"></td>"+*/
							"<td width=\"17%\" class=\"normalfnt\" height=\"25\">Main Cat</td>"+
							/*"<td align=\"left\" width=\"80%\" class=\"normalfnt\"><label>"+
							  "<select name=\"cboMaterial\" onchange=\"LoadMaterialCategories();ValidateMainFabChk(this);\" class=\"txtbox\" id=\"cboMaterial\" style=\"width:200px\" tabindex=\"1\">"+
								"<option value=\"1\">Fabric</option>"+
								"<option value=\"2\">Accessories</option>"+
								"<option value=\"3\">Packing Material</option>"+
								"<option value=\"4\">Services</option>"+
								"<option value=\"5\">Other</option>"+
							  "</select>"+
							"</label><input type=\"checkbox\" tabindex=\"1\"  name=\"chkMainFabric\" id=\"chkMainFabric\" onchange=\"ValidateMainFabric(this);\"/>Select as Main Fabric</td>"+*/
							"<td width=\"83%\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normalfnt\"><tr>"+
							"<td align=\"left\" width=\"30%\" class=\"normalfnt\"><label>"+
							  "<select name=\"cboMaterial\" onchange=\"LoadMaterialCategories();ValidateMainFabChk(this);SelectMainFabric(this.value);ClearOptions('cboItems');ClearOptions('cboItemsID');\" class=\"txtbox\" id=\"cboMaterial\" style=\"width:200px\" tabindex=\"1\">"+
								"<option value=\"1\">Fabric</option>"+
								"<option value=\"2\">Accessories</option>"+
								"<option value=\"3\">Packing Material</option>"+
								"<option value=\"4\">Services</option>"+
								"<option value=\"5\">Other</option>"+
								"<option value=\"6\">Washing</option>"+
							  "</select>"+
							"</td>"+
							"<td><div id=\"mainFabDiv\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normalfnt\"><tr><td width=\"10%\" align=\"center\"><input type=\"checkbox\" tabindex=\"1\"  name=\"chkMainFabric\" id=\"chkMainFabric\" onchange=\"ValidateMainFabric(this);\"/></td>"+
							"<td width=\"90%\">Select as Main Fabric</td></tr></table></div></td>"+
						  "</tr></table>"+
						  "<tr>"+
							/*"<td  width=\"1\"></td>"+*/
							"<td width=\"17%\" height=\"25\" class=\"normalfnt\">Sub Cat</td>"+
							"<td align=\"left\" width=\"80%\"><label>"+
							  "<select name=\"cboCategory\" class=\"txtbox\" onchange=\"LoadItems();\" id=\"cboCategory\" style=\"width:200px\" tabindex=\"2\">"+
							  "</select>"+
							"</label></td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td  width=\"1\"></td>"+*/
							"<td class=\"normalfnt\" height=\"25\">Description</td>"+
							"<td align=\"left\" class=\"normalfntSM\">"+
							  "<select name=\"cboItems\" onchange=\"LoadItemDetails(this);\" onblur=\"LoadItemDetails(this);\" class=\"txtbox\" id=\"cboItems\" style=\"width:300px\" tabindex=\"2\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							  "<select name=\"cboItemsID\" onchange=\"LoadItemDetails(this);\" onblur=\"LoadItemDetails(this);\" class=\"txtbox\" id=\"cboItemsID\" style=\"width:100px\" tabindex=\"2\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
							   "<img src=\"images/searchSM.png\" alt=\"search\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"LoadSupplierDetails();\"  >"+
							    "<img src=\"images/manage.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"LoadItems();\"  >"+
							 /* "<a href=\"#\" onclick=\"AddNewMaterialItem();\">Create item</a>"+*/
							  "<img src=\"images/add.png\" alt=\"Filter\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"AddNewMaterialItem();\"  >"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							/*"<td width=\"1\"></td>"+*/
							"<td class=\"normalfnt\" height=\"25\">Filter</td>"+
							"<td align=\"left\" valign=\"top\">"+
							  "<input type=\"text\" id=\"txtFilter\" style=\"width:398px\" tabindex=\"3\" class=\"txtbox\" onkeypress=\"EnableEnterSubmitLoadItems(event);\"><img src=\"images/searchSM.png\" alt=\"search\" class=\"mouseover\" hspace=\"3\" vspace=\"0\" onClick=\"FilterLoadedItems();\"  >"+
							"</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"2\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
								  	/*"<td width=\"3%\" class=\"normalfnt\">&nbsp;</td>"+*/
									"<td width=\"100\" class=\"normalfnt\"  height=\"25\">Supplier</td>"+
									"<td width=\"2%\" class=\"normalfnt\">&nbsp;</td>"+
									"<td width=\"240\"class=\"normalfnt\"><select name=\"cboMill\" class=\"txtbox\" id=\"cboMill\" style=\"width:400px\" tabindex=\"4\" >"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select></td>"+
							  "<td width=\"90\" class=\"normalfnt\" > <img src=\"images/searchSM.png\"  width=\"16\" height=\"16\" align=\"top\" onclick=\"LoadedSupWiseItems();\"/> <img src=\"images/manage.png\"  width=\"16\" height=\"16\" align=\"top\" onclick=\"LoadMill();\"/></td>"+
								  "</tr>"+
								"</table></td>"+
							  "</tr>"+
							  "<tr>"+
							"<td colspan=\"2\">&nbsp;</td></tr>"+
							  "<tr>"+
								"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
								  "<tr>"+
									"<td><table width=\"100%\" height=\"80\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
									  "<tr>"+
										"<td width=\"95px\" height=\"28\" class=\"normalfnt\">Con./PC.</td>"+
										"<td width=\"165px\" align=\"left\">"+
										"<input name=\"txtconsumpc2\" onblur=\"set6deci(this)\"  onkeypress=\"return CheckforValidDecimal(this.value, 6,event);\" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" tabindex=\"5\" value=\"0\" maxlength=\"9\" style=\"width:75px; text-align:right\" />"+
										"</td>"+
										"<td class=\"normalfnt\" width=\"140px\" >Unit</td>"+
										"<td  align=\"left\" class=\"normalfnt\" width=\"73px\">"+
										  "<select name=\"cboUnits\" class=\"txtbox\" onchange=\"ConvertToDefaultUnit();\" id=\"cboUnits\" style=\"width:78px;\" tabindex=\"6\">"+
										  "</select></td>"+
										"<td width=\"80px\"><table class=\"normalfnt\"><tr>"+
										"<td><input type=\"checkbox\" value=\"checkbox\" id=\"chkConvert\" name=\"chkConvert\"></td>"+
										"<td>Convert</td></tr></table></td>"+
										
										"</tr>"+
									  "<tr>"+
										"<td height=\"25\" class=\"normalfnt\"  >Unit Price</td>"+
										"<td align=\"left\" id=\"itemPrice\" title=\"\">"+
										  "<input onblur=\"set4deci(this)\" name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"8\" value=\"0\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"validateUnitprice();\"/>"+
										"<td  class=\"normalfnt\">Wastage</td>"+
										"<td  align=\"left\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeyup=\"checkMaxWastage();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"0\" tabindex=\"9\" maxlength=\"5\" style=\"width:75px; text-align:right\" onblur=\"set4deci(this)\"/>"+
										"</td>"+
									"<td ></td>"+
										
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\" >Origin</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"10\" style=\"width:77px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\" ><span class=\"normalfnt\">Freight</span></td>"+
										"<td  align=\"left\"><input name=\"txtfreight\" type=\"text\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"11\" value=\"0\" maxlength=\"9\" style=\"width:75px; text-align:right\" onblur=\"set4deci(this)\"/></td>"+
										"<td ></td>"+
									  "</tr>"+
									"</table></td>"+
								  "</tr>"+
								"</table></td>"+
							 "</tr>"+
							"</table></td>"+
						  "</tr>"+
						  	 "<tr >"+
							"<td colspan=\"3\" height=\"30\" bgcolor=\"#D6E7F5\"><table width=\"100%\">"+
							  "<tr>"+
								"<td width=\"30%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"SaveItemInfo();\" tabindex=\"12\" id=\"butSave\"/></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" id=\"butClose\" tabindex=\"13\" /></td>"+
								"<td width=\"30%\">&nbsp;</td>"+
							  "</tr>"+
						 "<tr >"+
							"<td align=\"left\" class=\"fntwithWite\"><input type=\"checkbox\" tabindex=\"12\"  name=\"chkvariations\" id=\"chkvariations\" onchange=\"RemoveVariations();\" />Have Variations</td>"+
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
									"<td width=\"312\" class=\"normalfntRite\">&nbsp;</td>"+
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
	document.getElementById('cboMaterial').focus();
	LoadDefaultCategories();
	LoadAvailableUnits();
	LoadOrigins();
	LoadMill();
	inc('javascript/buttonkeypress.js');
	
	//SelectMainFabric(document.getElementById('cboMaterial').value);
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
	document.getElementById("cboItems").options.length = 0
	document.getElementById("cboItemsID").options.length = 0;
}

function HandleItems()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLID = xmlHttp.responseXML.getElementsByTagName("itemID");
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("itemName");
			 
			document.getElementById("cboItemsID").innerHTML =  XMLID[0].childNodes[0].nodeValue;			
			document.getElementById("cboItems").innerHTML =  XMLName[0].childNodes[0].nodeValue;
			
			/* for ( var loop = 0; loop < XMLID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboItems").options.add(opt);
				var optid = document.createElement("option");
				
				optid.value = XMLID[loop].childNodes[0].nodeValue;
				optid.text = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboItemsID").options.add(optid);
			 }
			 
			var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboItems").options.add(opt);
			document.getElementById("cboItems").value = "Select One";
			var optid = document.createElement("option");
			optid.text = "Select One";
			optid.value = "Select One";
			document.getElementById("cboItemsID").options.add(optid);
			document.getElementById("cboItemsID").value = "Select One";	*/
			
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
			 /*for ( var loop = 0; loop < XMLName.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLName[loop].childNodes[0].nodeValue;
				document.getElementById("cboUnits").options.add(opt);
			 }*/
			 document.getElementById("cboUnits").innerHTML = XMLName[0].childNodes[0].nodeValue;
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

function LoadItemDetails(obj)
{
	if(obj.id=="cboItems")
		document.getElementById('cboItemsID').value = document.getElementById('cboItems').value;
	else
		document.getElementById('cboItems').value = document.getElementById('cboItemsID').value;
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
		var itemCode = document.getElementById('cboItems').value;
		var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
		var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
		var unitType = document.getElementById('cboUnits').value;
		var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
		var wastage = parseFloat(document.getElementById('txtwastage').value);
		var originID = document.getElementById('cboOrigine').value;
		var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
		var freight = parseFloat(document.getElementById('txtfreight').value);
		if (!checkAvailability(itemCode))
		{
			AddItem(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID,document.getElementById('cboMaterial').value,0,0,0);
			CollectVariations();
			CalculateFigures();
			RefreshAddingInterface();
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
	
	var wastage = parseFloat(document.getElementById('txtwastage').value);
	if ((document.getElementById('cboMaterial').value == "1" || document.getElementById('cboMaterial').value == "Fabric" || document.getElementById('cboMaterial').value == "FABRIC") && wastage>0 && _1WastageAllowed == false)
	{
		alert("Fabric wastages not allowed in your company.");	
		document.getElementById('txtwastage').focus();
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

/*function AddItem(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,selection,purchasedQty,purchasedPrice,transport,clearing,interest,exports,bintobinqty)*/
function AddItem(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,selection,purchasedQty,purchasedPrice,bintobinqty)
{
	
	var tbl = document.getElementById('tblConsumption');
    var lastRow = tbl.rows.length;	
	
	
	var row = tbl.insertRow(lastRow);
	if ((tbl.rows.length % 2) == 0)
	{
		row.className="bcgcolor-tblrow";
	}
	else
	{
		row.className="bcgcolor-tblrowWhite";		
	}
	row.onclick = rowclickColorChange;
	
	var cellEdit = row.insertCell(0);   
	cellEdit.id = itemCode;
	cellEdit.innerHTML = "<div onClick=\"showEditWindow(this.id);\" id=" + itemCode + " align=\"center\"><img src=\"images/edit.png\" /></div>";
	
	var cellDelete = row.insertCell(1);   
	cellDelete.id = itemCode;
	
	//alert(bintobinqty);
	if (parseFloat(purchasedQty) <= 0)
	cellDelete.innerHTML = "<div onClick=\"RemoveItem(this);\" align=\"center\"><img src=\"images/del.png\" /></div>"; 
	//else
		//alert('po - '+purchasedQty +',bin -'+bintobinqty);
	var cellDescription = row.insertCell(2);     
	cellDescription.className="normalfnt";
	//cellDescription.id = arrayLocation;
	cellDescription.id = lastRow;
	cellDescription.innerHTML = itemDescription;
	
	var cellConPc = row.insertCell(3);     
	cellConPc.className="normalfntRite";
	
	if ((selection== "1" || selection== "Fabric" || selection== "FABRIC") /*&& FABRICExcessAllowed == false */ )
	{
		cellConPc.id = "F"  ;
	}
	else
	{
	 	cellConPc.id = "N";
	}
	cellConPc.ondblclick = changeToStyleTextBox;
	cellConPc.innerHTML = RoundNumbers(conPc,consumptionDecimalLength);
	
	var cellUnit = row.insertCell(4);     
	cellUnit.className="normalfntMid";
	if (unitType == null || unitType == "" )
			unitType = " ";
	cellUnit.innerHTML = unitType;
	
	var cellUnitPrice = row.insertCell(5);     
	cellUnitPrice.className="normalfntRite";
	cellUnitPrice.ondblclick = changeToStyleTextBox;
	cellUnitPrice.innerHTML = RoundNumbers(unitPrice,4);
	
	var cellWastage = row.insertCell(6);     
	cellWastage.className="normalfntMid";
	cellWastage.innerHTML = wastage;
	
	var ReqQty = parseInt(document.getElementById('txtQTY').value) * conPc;
	var cellRecQty = row.insertCell(7);     
	cellRecQty.className="normalfntRite";
	cellRecQty.innerHTML = RoundNumbers(ReqQty,0);
	
	var exQty = parseInt(document.getElementById('txtEXQTY').value);
	if (document.getElementById('txtEXQTY').value == "" || document.getElementById('txtEXQTY').value == null)
		exQty = 0;
	
	var totalQty = 0;
totalQty = ReqQty + (ReqQty * wastage / 100) + (ReqQty *  exQty / 100) ;
	
	var cellTotQty = row.insertCell(8);     
	cellTotQty.className="normalfntRite";
	cellTotQty.innerHTML = RoundNumbers(totalQty,0) ;
	
	var cellPrice = row.insertCell(9);     
	cellPrice.className="normalfntRite";
	var pub_totalvalue = RoundNumbers(parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight)),2);
	//alert(pub_totalvalue);
	
	cellPrice.innerHTML = RoundNumbers(parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight)),2) ;
	
	var price = 0;
	if ((selection == "1" || selection == "Fabric" || selection == "FABRIC")/* && FABRICExcessAllowed == false && FABRICWastageAllowed == false*/)
	{
		price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	
	var cellValue = row.insertCell(10);     
	cellValue.className="normalfntRite";
	cellValue.innerHTML = RoundNumbers(price,4);
	
	var cellOrigin = row.insertCell(11);     
	cellOrigin.className="normalfntMid";
	cellOrigin.id=originid;
	cellOrigin.innerHTML = originName;
	
	var cellFreight = row.insertCell(12);     
	cellFreight.className="normalfntRite";
	cellFreight.innerHTML = RoundNumbers(freight,4);	
	
	var cellPurchasedQty = row.insertCell(13);     
	cellPurchasedQty.className="normalfntRite";
	cellPurchasedQty.innerHTML = RoundNumbers(purchasedQty,4) ;
	
	var cellPurchasedPrice = row.insertCell(14);     
	cellPurchasedPrice.className="normalfntRite";
	cellPurchasedPrice.innerHTML = RoundNumbers(purchasedPrice,4) ;
	
	////////////////// new finance cost /////////////////////
	
	var pub_transport2 	= pub_transport;
	var pub_clearing2 	= pub_clearing;
	var pub_interest2 	= pub_interest;
	var pub_export2 	= pub_export;
	
	if((originName =='LOC' /*&& originName!='LOC-F'*/) && (selection=='FABRIC' && selection!='1'))
		pub_transport2=1;
		
	if((originName=='IMP' /*&& originName!='IMP-F'*/) && ((selection=='ACCESSORIES' || selection=='2') || (selection=='PACKING MATERIAL' || selection=='3') || (selection=='FABRIC' && selection!='1')))
		pub_clearing2 =1;
		
	if(originName =='LOC' || originName=='IMP')
	{
		pub_interest2=2;
		pub_export2 = 1;
	}
	
	
	//alert(pub_transport2);
	var cellPurchasedPrice = row.insertCell(15);     
	cellPurchasedPrice.className="normalfntRite";
	cellPurchasedPrice.innerHTML = RoundNumbers((pub_totalvalue*pub_transport2)/100,2) ;
	
	var cellPurchasedPrice = row.insertCell(16);     
	cellPurchasedPrice.className="normalfntRite";
	var tmpclear = RoundNumbers((pub_totalvalue*pub_clearing2)/100,2);
	if((tmpclear<(10000/pub_slrrate)) && (tmpclear>0))
		tmpclear = RoundNumbers(10000/pub_slrrate,2);
		
	cellPurchasedPrice.innerHTML = tmpclear ;
	
	var cellPurchasedPrice = row.insertCell(17);     
	cellPurchasedPrice.className="normalfntRite";
	cellPurchasedPrice.innerHTML = RoundNumbers((pub_totalvalue*pub_interest2)/100,2) ;
	
	var cellPurchasedPrice = row.insertCell(18);     
	cellPurchasedPrice.className="normalfntRite";
	cellPurchasedPrice.innerHTML = RoundNumbers((pub_totalvalue*pub_export2)/100,2) ;
	
	var cellMainCat = row.insertCell(19);     
	cellMainCat.className="normalfntRite";
	cellMainCat.innerHTML = selection;
	//cellMainCat.style.display = "none";
	//bookmark
	
	//alert(pub_transport);
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

function ValidateInterfaceComponents()
{
	//var rowCount = document.getElementById('tblPartDetails').rows.length;
	//alert(rowCount);
	if (document.getElementById('txtStyleNo').value == null || document.getElementById('txtStyleNo').value == "")
	{
		alert("Please enter the Style No.");
		document.getElementById('txtStyleNo').focus();
		return false;
	}
	else if (document.getElementById('txtStyleName').value == null || document.getElementById('txtStyleName').value == "")
	{
		alert("Please enter the Style Name.");
		document.getElementById('txtStyleName').focus();
		return false;
	}
	/*else if (document.getElementById('tblPartDetails').rows.length < 1 || document.getElementById('txtEffLevel').value <= 0)
	{
			alert("Please enter the Eff. Level.");
			document.getElementById('txtEffLevel').focus();
			return false;
	}*/
	else if (document.getElementById('cboCustomer').value == "Select One")
	{
		alert("Please select the buyer.");
		document.getElementById('cboCustomer').focus();
		return false;
	}
	else if (document.getElementById('cboMerchandiser').value == "Select One")
	{
		alert("Please select the Merchandiser.");
		document.getElementById('cboMerchandiser').focus();
		return false;
	}
	else if (document.getElementById('txtOrderNo').value == null || document.getElementById('txtOrderNo').value == "")
	{
		alert("Please enter the Order No.");
		document.getElementById('txtOrderNo').focus();
		return false;
	}
	else if (document.getElementById('txtOrderNo').value == null || document.getElementById('txtOrderNo').value == "")
	{
		alert("Please enter the Order No.");
		document.getElementById('txtOrderNo').focus();
		return false;
	}
	else if (document.getElementById('txtSMV').value == null || document.getElementById('txtSMV').value == "")
	{
		alert("Please enter the SMV Value.");
		document.getElementById('txtSMV').focus();
		return false;
	}
	else if (document.getElementById('txtSMV').value <= 0)
	{
		alert("Please enter correct SMV Value.");
		document.getElementById('txtSMV').focus();
		return false;
	}
	else if (document.getElementById('txtQTY').value == null || document.getElementById('txtQTY').value == "")
	{
		alert("Please enter the Quantity.");
		document.getElementById('txtQTY').focus();
		return false;
	}
	else if (document.getElementById('txtNoLines').value == null || document.getElementById('txtNoLines').value == "")
	{
		alert("Please enter no of lines.");
		document.getElementById('txtNoLines').focus();
		return false;
	}
	else if (document.getElementById('txtNoLines').value <= 0)
	{
		alert("Please enter correct No Of Lines.");
		document.getElementById('txtNoLines').focus();
		return false;
	}
	else if (document.getElementById('cboProductCategory').value == "" )
	{
		alert("Please select a Product Category.");
		document.getElementById('cboProductCategory').focus();
		return false;
	}
	else if (document.getElementById('txtQTY').value <= 0)
	{
		alert("Please enter correct Quantity.");
		document.getElementById('txtQTY').focus();
		return false;
	}
	else if (document.getElementById('txtTargetFOB') != null)
	{
		if (document.getElementById('txtTargetFOB').value <= 0)
		{
			alert("Please enter the FOB value.");
			document.getElementById('txtTargetFOB').focus();
			return false;
		}
	}
	else if (document.getElementById('txtSMVRate') != null)
	{
		if ((document.getElementById('txtSMVRate').value == null || document.getElementById('txtSMVRate').value == "") && (document.getElementById('txtCMValue').value == null || document.getElementById('txtCMValue').value == "") && (document.getElementById('txtTargetFOB').value == null || document.getElementById('txtTargetFOB').value == ""))
		{
			alert("Please enter the SMV Rate.");
			document.getElementById('txtSMVRate').focus();
			return false;
		}
	}
	
	else
	{
		return true;	
	}
	return true;	
}

function DisplayEfficiencyLevel()
{
	var styleID = document.getElementById('txtStyleNo').value;
	if (document.getElementById('txtSMV').value == null || document.getElementById('txtSMV').value == "")
	{
		return false;
	}
	else if (document.getElementById('txtSMV').value <= 0)
	{
		return false;
	}
	else if (document.getElementById('txtQTY').value == null || document.getElementById('txtQTY').value == "")
	{
		return false;
	}
	else if (document.getElementById('txtQTY').value <= 0)
	{
		return false;
	}
	var qty = document.getElementById('txtQTY').value;
	var smvRate = document.getElementById('txtSMVRate').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = DisplayEffResult;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetEfficiencyRate&styleID=' + styleID + '&qty=' + qty + '&smvRate=' + smvRate , true);
    xmlHttp.send(null);
}

function DisplayEffResult()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLEff = xmlHttp.responseXML.getElementsByTagName("EfficencyValue");
			 
			 document.getElementById("txtEffLevel").value = XMLEff[0].childNodes[0].nodeValue;
		}
	}
}

function showEditWindow(itemcode)
{
	var tbl = document.getElementById('tblConsumption');
	var position = -1;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].lastChild.id;
		if (itemid == itemcode)
			position = loop;
	}
	//alert(position);
	var itemName = tbl.rows[position].cells[2].lastChild.nodeValue;
	
	var conpc = tbl.rows[position].cells[3].lastChild.nodeValue;
	var matCat = tbl.rows[position].cells[3].id;
	var unitType = tbl.rows[position].cells[4].lastChild.nodeValue;
	var unitPrice = tbl.rows[position].cells[5].lastChild.nodeValue;
	var wastage = tbl.rows[position].cells[6].lastChild.nodeValue;
	loca = tbl.rows[position].cells[11].id;
	var freight = tbl.rows[position].cells[12].lastChild.nodeValue; //tbl.rows[position].cells[11].lastChild.nodeValue
	var phsQty = parseFloat(tbl.rows[position].cells[13].lastChild.nodeValue);
	var disableUnits = phsQty > 0 ? " disabled=\"disabled\" " : " ";
	var mill = tbl.rows[position].cells[15].lastChild.nodeValue;
	var mainFabric = tbl.rows[position].cells[16].lastChild.nodeValue;
	var matMainCat = tbl.rows[position].cells[16].id;
	var itemUnitprice = getItemUnitprice(itemid);
	
	drawPopupArea(560,350,'frmItems');
	var HTMLText = "<table width=\"550\" class=\"bcgl1\">"+
					"<tr>"+
					  "<td><table width=\"100%\" height=\"210\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							/*"<td width=\"3%\" bgcolor=\"#0E4874\">&nbsp;</td>"+*/
							"<td colspan=\"2\" bgcolor=\"#0E4874\" class=\"mainHeading\"><table width=\"100%\" border=\"0\">"+
								"<tr class=\"cursercross\" onmousedown=\"grab(document.getElementById('frmItems'),event);\">"+
								  "<td width=\"84%\" align=\"left\">Edit Item - " + itemName + "</td>"+
								  "<td width=\"13%\">&nbsp;</td>"+
								  "<td width=\"3%\"><img src=\"images/cross.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
								"</tr>"+
							  "</table></td>"+
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
									  "<td width=\"4%\"></td>"+
										"<td width=\"15%\" height=\"28\" class=\"normalfnt\">Con./PC</td>"+
										"<td width=\"30%\" align=\"left\"><label>"+
										"<input name=\"txtconsumpc2\" onblur=\"set6deci(this)\"  onkeypress=\"return CheckforValidDecimal(this.value, 6,event);\" type=\"text\" class=\"txtbox\" id=\"txtconsumpc2\" value=\"" + conpc + "\" tabindex=\"3\" style=\"width:80px; text-align:right\" maxlength=\"9\"/>"+
										"</label></td>"+
										"<td class=\"normalfnt\" align=\"left\" width=\"18%\">Unit </td>"+
										"<td  align=\"left\" class=\"normalfnt\" width=\"18%\" ><label>"+
										  "<select " +  disableUnits + " name=\"cboUnits\" class=\"txtbox\" onchange=\"getConvertedUnitValue(" + itemcode + ");\" id=\"cboUnits\" style=\"width:82px;\" tabindex=\"4\">"+
										  "</select>"+
										  ""+
										"</label></td>"+
										"<td  width=\"15%\" class=\"normalfnt\">"+
										"<table width=\"100%\"><tr><td  width=\"15%\"><input name=\"chkConvert\" type=\"checkbox\" id=\"chkConvert\" value=\"checkbox\" /></td>"+
										"<td width=\"85%\">Convert</td></tr></table>"+
										" </td>"+
										"</tr>"+
									  "<tr>"+
									   "<td width=\"4%\"></td>"+
										"<td height=\"25\" class=\"normalfnt\">Unit Price</td>"+
										"<td  align=\"left\" id=\"itemPrice\" title=\""+itemUnitprice+"\"><label>"+
										  "<input name=\"txtunitprice\" onblur=\"set4deci(this)\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"5\" value=\"" + unitPrice + "\" style=\"width:80px; text-align:right\" maxlength=\"9\" onkeyup=\"validateUnitprice();\"/>"+
										"</label></td>"+
										"<td  class=\"normalfnt\">Wastage</td>"+
										"<td  align=\"left\"><label>"+
										  "<input name=\"txtwastage\" type=\"text\" onkeyup=\"checkMaxWastage();\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\" tabindex=\"6\" value=\"" + wastage + "\" style=\"width:80px; text-align:right\" maxlength=\"5\"/>"+
										"</label></td>"+
									  "</tr>"+
									  "<tr>"+
									   "<td width=\"4%\"></td>"+
										"<td height=\"27\" class=\"normalfnt\">Origin</td>"+
										"<td align=\"left\"><label>"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"7\" style=\"width:83px\" >"+
										  "</select>"+
										"</label></td>"+
										"<td align=\"left\"><span class=\"normalfnt\">Freight</span></td>"+
										"<td align=\"left\"><input name=\"txtfreight\" onblur=\"set4deci(this)\" type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"8\" value=\"" + freight + "\" style=\"width:80px; text-align:right\" maxlength=\"9\"/></td>"+
									  "</tr>"+
									  
									  "<tr>"+
									   "<td width=\"4%\"></td>"+
										"<td height=\"27\" class=\"normalfnt\">Mill</td>"+
										"<td align=\"left\" colspan=\"4\"><label>"+
										  "<select name=\"cboMill\" class=\"txtbox\" id=\"cboMill\" style=\"width:342px\" tabindex=\"9\">"+
							  "<option value=\"Select One\" selected=\"selected\">Select One</option>"+
							  "</select>"+
										"</label></td>"+
										/*"<td align=\"left\" class=\"normalfnt\" colspan=\"2\" >"+*/
									  "</tr>"+
									  "<tr><td colspan=\"3\" >"+
									  "<div style=\"visibility:hidden\" id=\"mainFabDiv\">"+
										"<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normalfnt\" ><tr>"+
										"<td width=\"13\"></td>"+
										"<td width=\"51\">Main Fabric </td>"+
										"<td width=\"100\"><input type=\"checkbox\" tabindex=\"10\"  name=\"chkMainFabric\" id=\"chkMainFabric\" onchange=\"ValidateMainFabric(this);\"/></td>"+
										"</td></tr></table></div>"+
									  "</td></tr>"+
									"</table></td>"+
								  "</tr>"+
								"</table></td>"+
							 "</tr>"+
							"</table></td>"+
						  "</tr>"+
						   "<tr>"+
							"<td colspan=\"3\" bgcolor=\"#D6E7F5\"><table width=\"100%\">"+
							  "<tr>"+
								"<td width=\"30%\">&nbsp;</td>"+
								"<td width=\"23%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onClick=\"UpdateItemInfo(" + tbl.rows[position].cells[2].id + "," + itemcode + ",'" + matCat + "','"+matMainCat+"');\" tabindex=\"11\"  id=\"butSave\"/></td>"+
								"<td width=\"17%\"><img src=\"images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onClick=\"closeWindow();\" tabindex=\"12\" id=\"butClose\"/></td>"+
								"<td width=\"30%\">&nbsp;</td>"+
							  "</tr>"+
							"</table></td>"+
						 "</tr>"+
						  "<tr>"+
							"<td align=\"left\" class=\"fntwithWite\"><input type=\"checkbox\" tabindex=\"12\"  name=\"chkvariations\" id=\"chkvariations\" onchange=\"RemoveVariations();\" />Have Variations</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td colspan=\"3\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
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
				  "</table>";
	
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	LoadAvailableUnits();
	LoadOrigins();
	currentUnit = unitType;
	LoadItemVariations(itemcode);
	LoadMill();	
	pub_mill = mill;
	document.getElementById('chkMainFabric').checked = (mainFabric==1 ? true:false)
	SelectMainFabric(matMainCat);
	inc('javascript/buttonkeypress.js');
}
function SelectMainFabric(catID)
{
	if(catID == 1)
		document.getElementById('mainFabDiv').style.visibility = 'visible';
		else
		document.getElementById('mainFabDiv').style.visibility = 'hidden';
}
function RequestDefaultUnit(itemcode)
{
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = showDefaultUnit;
    thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=GetDefaultUnit&ItemCode=' + itemcode , true);
    thirdxmlHttp.send(null);
}

function showDefaultUnit()
{
	if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			 var XMLUnit = thirdxmlHttp.responseXML.getElementsByTagName("Unit");
			 
			 document.getElementById("cboUnits").value = XMLUnit[0].childNodes[0].nodeValue;
		}
	}
}

function getConvertedUnitValue(itemcode)
{
	if (document.getElementById("chkConvert").checked)
	{
		var conpc  = document.getElementById('txtconsumpc2').value;
		var selectedType = document.getElementById('cboUnits').value;
		UnitConversion(conpc,selectedType,itemcode);	
		previousUnit = selectedType;
	}
}

function CollectVariations()
{
	var arrvariationlist = [];
	var p = 0;
	var tbl = document.getElementById('tblVariations');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var conpc = rw.cells[1].lastChild.value;
		var unitprice = rw.cells[2].lastChild.value;
		var wastage = rw.cells[3].lastChild.value;
		var qty = rw.cells[4].lastChild.value;
		var color = rw.cells[5].lastChild.value;
		var arrvar = [conpc,unitprice,wastage,qty,color];
		arrvariationlist[p] = arrvar;
		p ++;
	}		
	Mainvariations[arrayLocation]	= arrvariationlist;
	arrayLocation ++;
}


function LoadVariations(locno)
{
	var obj = Mainvariations[locno];
	for (i in obj)
	{
		var arrElements = obj[i];
		AddVariationRowWithData(arrElements[0],arrElements[1],arrElements[2],arrElements[3],arrElements[4]);
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
	cellConPc.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\" value=\"" + conpc + "\"  >";
	var cellUnitPrice = row.insertCell(2);
	cellUnitPrice.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + unitprice + "\" >";
	var cellWastage = row.insertCell(3);
	cellWastage.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + wastage + "\" >";
	var cellQty = row.insertCell(4);
	cellQty.innerHTML = "<input type=\"text\" style=\"width:75px;\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"   value=\"" + qty + "\" >";
	var cellColor = row.insertCell(5);
	cellColor.innerHTML = "<input type=\"text\" style=\"width:100px;\" class=\"txtbox\"  value=\"" + color + "\"  >";
	var cellSize = row.insertCell(6);
	cellSize.innerHTML = "<input type=\"text\" style=\"width:100px;\" class=\"txtbox\"  value=\"" + size + "\"  >";
			
}

function ModifyVariationList(locno)
{
	var arrvariationlist = [];
	var p = 0;
	var tbl = document.getElementById('tblVariations');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var conpc = rw.cells[1].lastChild.value;
		var unitprice = rw.cells[2].lastChild.value;
		var wastage = rw.cells[3].lastChild.value;
		var qty = rw.cells[4].lastChild.value;
		var color = rw.cells[5].lastChild.value;
		var arrvar = [conpc,unitprice,wastage,qty,color];
		arrvariationlist[p] = arrvar;
		p ++;
	}		
	Mainvariations[locno]	= arrvariationlist;
}

function ModifyDatalist(locno,itemcode,cat)
{
	//alert(locno+itemcode+cat)
	if (ValidateItemEditingForm())
	{
		
		var conPc = parseFloat(document.getElementById('txtconsumpc2').value);
		var unitType = document.getElementById('cboUnits').value;
		var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
		var wastage = parseFloat(document.getElementById('txtwastage').value);
		var originID = document.getElementById('cboOrigine').value;
		var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
		var freight = parseFloat(document.getElementById('txtfreight').value);
		
		
		ModifyItems(itemcode,conPc,unitType,unitPrice,wastage,originName,freight,originID,cat);
		//ModifyVariationList(locno);
		CalculateFigures();
		CalculateCMAfterEditing();
		closeWindow();		
	}
}


function CalculateVariationWiseQtyPrice()
{
	if (document.getElementById("chkvariations").checked == false) return true;
	var tbl = document.getElementById('tblVariations');
	var totvalue = 0;
	var totprice = 0;
	var totQty = 0;
	var odrQty = parseInt(document.getElementById('txtQTY').value);
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		
		var rw = tbl.rows[loop];
        var conpc = rw.cells[1].lastChild.value;
		var unitprice = rw.cells[2].lastChild.value;
		var wastage = rw.cells[3].lastChild.value;
		var qty = rw.cells[4].lastChild.value;
		totvalue += parseFloat(conpc) * parseInt(qty);
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

function ModifyItems(itemcode,conpc,unitType,unitPrice,wastage,originName,freight,originID,cat)
{
	//alert(unitPrice);
	var tbl = document.getElementById('tblConsumption');
	var position = -1;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].lastChild.id;
		if (itemid == itemcode)
			position = loop;
	}
	
	tbl.rows[position].cells[3].lastChild.nodeValue = RoundNumbers(conpc,consumptionDecimalLength) ;
	tbl.rows[position].cells[4].lastChild.nodeValue =  unitType ;
	tbl.rows[position].cells[5].lastChild.nodeValue = RoundNumbers(unitPrice,4);
	tbl.rows[position].cells[6].lastChild.nodeValue = wastage  ;
	tbl.rows[position].cells[11].lastChild.nodeValue = originName  ;
	tbl.rows[position].cells[11].id=originID;
	tbl.rows[position].cells[12].lastChild.nodeValue = freight ;
	
	var ReqQty = document.getElementById('txtQTY').value * conpc;
	tbl.rows[position].cells[7].lastChild.nodeValue =  RoundNumbers(ReqQty,0);
	
	var exQty = document.getElementById('txtEXQTY').value;
	if (document.getElementById('txtEXQTY').value == "" || document.getElementById('txtEXQTY').value == null)
		exQty = 0;
	
	
	var totalQty = ReqQty + (ReqQty * wastage / 100) + (ReqQty *  exQty / 100) ;
	if (cat == 'F')
	{
		 totalQty = ReqQty ;
	}
	tbl.rows[position].cells[8].lastChild.nodeValue = RoundNumbers(totalQty,0) ;
	
    pub_totalPrice = RoundNumbers((parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight))),2);
	
	var pub_totalvalue=RoundNumbers((parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight))),2) ;
	//alert(pub_totalvalue);
	
	tbl.rows[position].cells[9].lastChild.nodeValue = pub_totalvalue;
	
    var price = 0;
	if (cat == 'F')
	{
		price = RoundNumbers(parseFloat(conpc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conpc) + parseFloat(conpc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	
	var selection = pub_mainCat;
	
	tbl.rows[position].cells[10].lastChild.nodeValue = RoundNumbers(price,4);
	//bookmark
	//alert(price);
	
		////////////////// new finance cost /////////////////////
	//alert(1);
	var pub_transport2 	= pub_transport;
	var pub_clearing2 	= pub_clearing;
	var pub_interest2 	= pub_interest;
	var pub_export2 	= pub_export;
	
	if((originName =='LOC' /*&& originName!='LOC-F'*/) && (selection=='FABRIC' && selection!='1'))
		pub_transport2=1;
		
	if((originName=='IMP' /*&& originName!='IMP-F'*/) && ((selection=='ACCESSORIES' || selection=='2') || (selection=='PACKING MATERIAL' || selection=='3') || (selection=='FABRIC' && selection!='1')))
		pub_clearing2 =1;
		
	if(originName =='LOC' || originName=='IMP')
	{
		pub_interest2=2;
		pub_export2 = 1;
	}

	var tmpclear = RoundNumbers((pub_totalvalue*pub_clearing2)/100,2);
	if((tmpclear<(10000/pub_slrrate)) && (tmpclear>0))
		tmpclear = RoundNumbers(10000/pub_slrrate,2);
	
	tbl.rows[position].cells[15].lastChild.nodeValue = RoundNumbers((pub_totalvalue*pub_transport2)/100,2) ;
	tbl.rows[position].cells[16].lastChild.nodeValue = tmpclear;
	tbl.rows[position].cells[17].lastChild.nodeValue = RoundNumbers((pub_totalvalue*pub_interest2)/100,2) ;
	tbl.rows[position].cells[18].lastChild.nodeValue = RoundNumbers((pub_totalvalue*pub_export2)/100,2) ;
	CalculateMatCost();
}

function RemoveItem(obj)
{
	if(confirm('Are you sure you want to delete this item?'))
	{
		var td = obj.parentNode;
		var rowIndex = td.parentNode.rowIndex;
		DeleteItemFromDatabase(td.id,rowIndex);
	}
}

function ValidateItemEditingForm()
{
	if (document.getElementById('txtconsumpc2').value == null || document.getElementById('txtconsumpc2').value == "")
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

function checkForValues(obj)
{
	if(obj.value == "" || obj.value == null)
		obj.value = 0;
}

function CalculateFigures()
{
	
	var Qty = document.getElementById('txtQTY').value;
	var ExQty = document.getElementById('txtEXQTY').value;
	var SMVValue = document.getElementById('txtSMV').value;
	var finacePcnt = document.getElementById('txtFinancePercentage').value;
	var totalMaterialCost =  0;	
	var totalfinancecost = 0;
	var tbl = document.getElementById('tblConsumption');
	
	var financeT = 0;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].id;
		var conpc = RoundNumbers(parseFloat(tbl.rows[loop].cells[3].lastChild.nodeValue) ,consumptionDecimalLength) ;
		var unitType = tbl.rows[loop].cells[4].lastChild.nodeValue ;
		var unitPrice = RoundNumbers(parseFloat(tbl.rows[loop].cells[5].lastChild.nodeValue),4);
		var wastage = RoundNumbers(parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue),4)  ;
		var ReqQty = RoundNumbers(parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue),4) ;
		var totalQty = RoundNumbers(parseFloat(tbl.rows[loop].cells[8].lastChild.nodeValue),4) ;
		var price = RoundNumbers(parseFloat(tbl.rows[loop].cells[9].lastChild.nodeValue),4);
		var value = RoundNumbers(parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue),4);

		var	originName = tbl.rows[loop].cells[11].lastChild.nodeValue  ;
		var freight = RoundNumbers(parseFloat(tbl.rows[loop].cells[12].lastChild.nodeValue),4) ;

		totalMaterialCost = parseFloat(totalMaterialCost) + parseFloat(value);
		
		if (originName.charAt(originName.length-1) == "F" ||originName.charAt(originName.length-1)== "f" )
			totalfinancecost += parseFloat(price);	
			
			
				var transport = parseFloat(tbl.rows[loop].cells[18].lastChild.nodeValue);
				var clearing = parseFloat(tbl.rows[loop].cells[17].lastChild.nodeValue);
				var interest = parseFloat(tbl.rows[loop].cells[16].lastChild.nodeValue);
				var exports = parseFloat(tbl.rows[loop].cells[15].lastChild.nodeValue);
				financeT += transport + clearing+interest+exports;
	}
	
	
	//var financeValue = totalfinancecost / Qty * finacePcnt /100;
	//alert(financeValue);
	
	//document.getElementById('txtFinanceAmount').value = RoundNumbers(financeT,4);
	document.getElementById('txtMaterialCost').value = RoundNumbers(totalMaterialCost,4);
	
/*	var subQty = parseFloat(document.getElementById('txtSubContactQty').value);
	var subCost = 0;
	if(subQty<=5000)
		subCost = subQty * 0.05;
	else if(subQty<=10000)
		subCost = subQty * 0.035;
	else if(subQty<=20000)
		subCost = subQty * 0.025;
	else
		subCost = subQty * 0.020;*/
	
	
	document.getElementById('txtFinanceAmount').value =RoundNumbers((financeT)/Qty,4);
	//CalculateCMValue();
	//CalculateCMRate();
	//CalculateESC();
	//bookmark
	ReArrangeFigures();
	//CalculateMatCost();
	
	
}

function RoundNumbers(number,decimals) {
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 