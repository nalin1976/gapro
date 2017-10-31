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

var arrEmbellishment = [];
var IsEmbellishmentSet = 0;

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
							  "<select name=\"cboMaterial\" onchange=\"LoadMaterialCategories();SelectMainFabric(this.value);ClearOptions('cboItems');ClearOptions('cboItemsID');\" class=\"txtbox\" id=\"cboMaterial\" style=\"width:200px\" tabindex=\"1\">"+
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
										"<td width=\"95px\" height=\"28\" class=\"normalfnt\">&nbsp;Con./PC.</td>"+
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
										"<td height=\"25\" class=\"normalfnt\"  >&nbsp;Unit Price</td>"+
										"<td align=\"left\" id=\"itemPrice\" title=\"\">"+
										  "<input onblur=\"set4deci(this)\" name=\"txtunitprice\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" type=\"text\" class=\"txtbox\" id=\"txtunitprice\" tabindex=\"8\" value=\"0\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"validateUnitprice();\"/>"+
										"<td  class=\"normalfnt\">Wastage</td>"+
										"<td  align=\"left\">"+
										  "<input name=\"txtwastage\" type=\"text\" onkeyup=\"checkMaxWastage();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtwastage\"  value=\"0\" tabindex=\"9\" maxlength=\"5\" style=\"width:75px; text-align:right\" onblur=\"set4deci(this)\"/>"+
										"</td>"+
									"<td ></td>"+
										
									  "</tr>"+
									  "<tr>"+
										"<td height=\"27\" class=\"normalfnt\" >&nbsp;Origin</td>"+
										"<td align=\"left\">"+
										  "<select name=\"cboOrigine\" class=\"txtbox\" id=\"cboOrigine\" tabindex=\"10\" style=\"width:77px\">"+
										  "</select>"+
										"</td>"+
										"<td align=\"left\" ><span class=\"normalfnt\">Freight</span></td>"+
										"<td  align=\"left\"><input name=\"txtfreight\" type=\"text\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox\" id=\"txtfreight\" tabindex=\"11\" value=\"0\" maxlength=\"9\" style=\"width:75px; text-align:right\" onblur=\"set4deci(this)\"/></td>"+
										"<td ></td>"+
									  "</tr>"+
                                                                          "<tr id=\"trWash\" name=\"trWash\" >"+
                                                                                "<td height=\"27\" class=\"normalfnt\" >&nbsp;To be wash</td>"+
                                                                                "<td height=\"27\" class=\"normalfnt\" ><input type=\"checkbox\" id=\"chkWashable\" name=\"chkWashable\"></input></td>"+
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
    totalQty = ReqQty + (ReqQty * wastage / 100);
	
	// =======================================
	// 2015/10/19
	// Remove calculation of raw material for excess qty
	// + (ReqQty *  exQty / 100)
	// =======================================
	
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
		//price = RoundNumbers(parseFloat(conPc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
		price = RoundNumbers(parseFloat(parseFloat(conPc) + parseFloat(conPc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
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
	
	//if((originName =='LOC' /*&& originName!='LOC-F'*/) && (selection=='FABRIC' && selection!='1'))
	if((originName =='LOC' || originName=='LOC-F') && (selection=='FABRIC'))
		pub_transport2=1;
		
	//if((originName=='IMP' /*&& originName!='IMP-F'*/) && ((selection=='ACCESSORIES' || selection=='2') || (selection=='PACKING MATERIALS' || selection=='3') || (selection=='FABRIC' && selection!='1')))
	if((originName=='IMP' || originName=='IMP-F') && ((selection=='ACCESSORIES') || (selection=='PACKING  MATERIALS') || (selection=='FABRIC')))
		pub_clearing2 =1;
		
	//if(originName =='LOC' || originName=='IMP')
	if((originName =='LOC' || originName=='IMP' || originName=='IMP-F' || originName =='LOC-F') && (selection == 'FABRIC') || (selection == 'ACCESSORIES') || (selection == 'PACKING  MATERIALS'))
	{
		pub_interest2=2;
		pub_export2 = 1;
	}
	
	
	//alert(pub_clearing2);
	var cellPurchasedPrice = row.insertCell(15);     
	cellPurchasedPrice.className="normalfntRite";
	cellPurchasedPrice.innerHTML = RoundNumbers((pub_totalvalue*pub_transport2)/100,2) ;
	
	var cellPurchasedPrice = row.insertCell(16);     
	cellPurchasedPrice.className="normalfntRite";
	var tmpclear = 0;//RoundNumbers((pub_totalvalue*pub_clearing2)/100,2);
	tmpclear = RoundNumbers((pub_totalvalue*pub_clearing2)/100,2);
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
	else if (!DisplayEfficiencyLevel)
	{
			alert("Please enter the Eff. Level.");
			document.getElementById('txtEffLevel').focus();
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
        // =====================================
        // Adding - Add which level of style
        // Add by - Nalin Jayakody
        // Add On - 05/08/2017
        // =====================================
        else if(document.getElementById('cboStyleLevel').value == "-1"){
           alert("Please select which level of style."); 
           return false;
        }
        else if((document.getElementById('dtPCD').value == "") || (document.getElementById('dtPCD').value == null)) {
            alert("Please enter PCD/BCD date."); 
            document.getElementById('OrderPCD').focus();
           return false;
        }
        // =====================================
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
	}// Validate Product Category while saving a cost sheet
	 // Add On     - 2015/09/17
	 // Changed By - Nalin Jayakody
        else if(document.getElementById('cboProductCategory') != null){
               alert("Please select product category from list.");
               document.getElementById('cboProductCategory').focus();
               return false;
        }
         
        
	
	else
	{
            alert(document.getElementById('cboStyleLevel').value)
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
	var styleID = document.getElementById('txtStyleNo').value;
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
        
        var valToBeWash = getItemWashableStatus(itemcode, styleID);
        var IsToBeWash  = 0;
        
        if(valToBeWash == 1){
            IsToBeWash = 1;
        }
	
        
	drawPopupArea(560,390,'frmItems');
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
                                                                            "<td height=\"27\" class=\"normalfnt\">To be wash</td>"+
                                                                            "<td height=\"27\" class=\"normalfnt\"><input type=\"checkbox\" id=\"chkToBeWash\" name=\"chkToBeWash\"></input></td>"+
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
        if(IsToBeWash == 1){
            
            $("#chkToBeWash").prop("checked", "checked");
        }
	SelectMainFabric(matMainCat);
        
	inc('javascript/buttonkeypress.js');
}
function SelectMainFabric(catID)
{
    if(catID == 1){
        document.getElementById('mainFabDiv').style.visibility = 'visible';
        $("#trWash").css('visibility','visible');
    }	
    else{
        document.getElementById('mainFabDiv').style.visibility = 'hidden';
        $("#trWash").css('visibility','hidden');
    }
		
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
	
	// Get main category type
	pub_mainCat = tbl.rows[position].cells[19].lastChild.nodeValue;
	
	var ReqQty = document.getElementById('txtQTY').value * conpc;
	tbl.rows[position].cells[7].lastChild.nodeValue =  RoundNumbers(ReqQty,0);
	
	var exQty = document.getElementById('txtEXQTY').value;
	if (document.getElementById('txtEXQTY').value == "" || document.getElementById('txtEXQTY').value == null)
		exQty = 0;
	
	
	var totalQty = ReqQty + (ReqQty * wastage / 100);
	// ====================================================================
	// Comment on - 10/19/2015 
	// To prevent raw material calculaiton for excess qty
	// + (ReqQty *  exQty / 100) ;
	// ====================================================================
	
	
	// ====================================================================
	// Comment on - 10/20/2014 
	// Description - Comment below category check condition and assign of 
	//               req qty to totalQty
	//               And round up the totalQty value using CEIL function    
	// ====================================================================
	/*if (cat == 'F')
	{
		 totalQty = ReqQty ;
	}*/
	// ====================================================================
	
	totalQty = Math.ceil(totalQty);
	
	tbl.rows[position].cells[8].lastChild.nodeValue = RoundNumbers(totalQty,0) ;
	
    pub_totalPrice = RoundNumbers((parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight))),2);
	
	var pub_totalvalue=RoundNumbers((parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight))),2) ;
	//alert(pub_totalvalue);
	
	tbl.rows[position].cells[9].lastChild.nodeValue = pub_totalvalue;
	
    var price = 0;
	if (cat == 'F')
	{
		// ========================================================
		// Comment On - 11/04/2015
		// Comment By - Nalin Jayakody
		// Comment For - To add wastage calculation for price
		// ========================================================
		  /*	price = RoundNumbers(parseFloat(conpc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4); */
		// ========================================================
		price = RoundNumbers(parseFloat(parseFloat(conpc) + parseFloat(conpc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		  
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
	
	//if((originName =='LOC' /*&& originName!='LOC-F'*/) && (selection=='FABRIC' && selection!='1'))
	if((originName =='LOC' || originName!='LOC-F') && (selection=='FABRIC' && selection!='1'))
		pub_transport2=1;
		
	//if((originName=='IMP' /*&& originName!='IMP-F'*/) && ((selection=='ACCESSORIES' || selection=='2') || (selection=='PACKING MATERIALS' || selection=='3') || (selection=='FABRIC' && selection!='1')))
	if((originName=='IMP' || originName=='IMP-F') && ((selection=='ACCESSORIES') || (selection=='PACKING  MATERIALS') || (selection=='FABRIC')))
		pub_clearing2 =1;
		
	//if(originName =='LOC' || originName=='IMP')
	
	if((originName =='LOC' || originName=='IMP' || originName=='IMP-F' || originName =='LOC-F') && (selection == 'FABRIC') || (selection == 'ACCESSORIES') || (selection == 'PACKING  MATERIALS'))
	{
		pub_interest2=2;
		pub_export2 = 1;
		
	}

	var tmpclear = RoundNumbers((pub_totalvalue*pub_clearing2)/100,2);
	//alert(pub_slrrate);
	if((tmpclear<(10000/pub_slrrate)) && (tmpclear>0))
		tmpclear = RoundNumbers(10000/pub_slrrate,2);
	//alert(tmpclear);
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
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}	

function CalculateCMValue()
{
	/*var SMVValue = document.getElementById('txtSMV').value;
	var CMRate = document.getElementById('txtSMVRate').value;
	var CMValue = SMVValue * CMRate ;
	document.getElementById('txtCMValue').value = RoundNumbers(CMValue,4);*/
	var currentFOB = parseFloat(document.getElementById('txtTargetFOB').value);
	
	var esc = parseFloat(document.getElementById('txtESC').value);
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	var cm = currentFOB - pcmeterialCost - esc - finance;
	document.getElementById('txtCMValue').value = RoundNumbers(cm,4);
}

function CalculateCMValueKeyPress()
{
	var SMVValue = document.getElementById('txtSMV').value;
	var CMRate = document.getElementById('txtSMVRate').value;
	var CMValue = SMVValue * CMRate ;
	document.getElementById('txtCMValue').value = RoundNumbers(CMValue,4);
}

function CalculateCMRate()
{
/*	var SMVValue = parseFloat(document.getElementById('txtSMV').value);
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var upcharge = parseFloat(document.getElementById('txtUPCharge').value);
	var CMRate = (CMValue + upcharge ) / SMVValue ;
	document.getElementById('txtSMVRate').value = RoundNumbers(CMRate,4);*/
	
	//var SMVValue = document.getElementById('txtSMV').value;
	var SMVValue = parseFloat(document.getElementById('txtSMV').value) + parseFloat(document.getElementById('txtPackSMV').value) ;
	if(SMVValue=='') {SMVValue = 0}	else{SMVValue = parseFloat(SMVValue)};
		
	var CMValue = document.getElementById('txtCMValue').value;if(CMValue=='') {CMValue = 0}	else{CMValue = parseFloat(CMValue)};
	var upcharge = document.getElementById('txtUPCharge').value;if(upcharge=='') {upcharge = 0}	else{upcharge = parseFloat(upcharge)};
	
	var CMRate = (CMValue  ) / SMVValue ;
	document.getElementById('txtSMVRate').value = RoundNumbers(CMRate,4);
	//document.getElementById('txtCMValue').value = RoundNumbers(SMVValue*CMRate,4);
}

function CalculateESC()
{
	var currentFOB = parseFloat(document.getElementById('txtTargetFOB').value);
	
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	var esc = (CMValue + pcmeterialCost + finance) * EscPercentage / 100;
	document.getElementById('txtESC').value = RoundNumbers(esc,4);
	if (document.getElementById('chkFixed').checked)
	{
		document.getElementById('txtTargetFOB').value = currentFOB;
	}
	else
	{
		document.getElementById('txtTargetFOB').value = RoundNumbers(CMValue + pcmeterialCost + finance + esc,4);
	}	
}

function CalculateESCWithCMBox()
{
	var currentFOB = document.getElementById('txtTargetFOB').value;
	
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	var esc = (CMValue + pcmeterialCost + finance) * EscPercentage / 100;
	document.getElementById('txtESC').value = RoundNumbers(esc,4);
	document.getElementById('txtTargetFOB').value = RoundNumbers(CMValue + pcmeterialCost + finance + esc,4);

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
	document.getElementById("cboCategory").focus();
}

function ShowAddDeliverySchedule()
{
	drawPopupArea(550,280,'frmItems');
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var allocatedQty = getAllocatedQuantity();
	var balanceQuantity = Qty - allocatedQty;
	var styleId = $("#hndStyleId").val();
	
	//alert(styleId);
	
	//var exQty = calExQtyForDeliverySchedule(Qty,)
	var HTMLText = " <table width=\"550\" class=\"bcgl1\"  height=\"280\" >"+
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
						  "<tr height=\"26\">"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"20%\" class=\"normalfnt\">BPO</td>"+
							"<td align=\"left\" width=\"100\">"+
							 "<input name=\"txtBpo\" value =\"0\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);validateSpecialCharacters(this.id);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"\" id=\"txtBpo\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"\" />"+
							  /*"<input name=\"txtBpo\" value =\"0\" type=\"text\" class=\"txtboxRightAllign\" onblur=\"checkForValues(this);\"  onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return isValidZipCode(this.value,event);\" id=\"txtBpo\" maxlength=\"9\" style=\"width:75px; text-align:right\" onkeyup=\"\" />"+*/
							"</td>"+
							"<td class=\"normalfnt\" width=\"100\">Delivery date</td>"+
							"<td align=\"left\">"+			
							  "<input name=\"deliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"deliverydate\" onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\" style=\"width:75px;\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
						   "<tr height=\"26\">"+
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
						    "<tr height=\"26\">"+
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
						    "<tr height=\"26\">"+
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
							"<tr height=\"26\">"+
							"<td width=\"5\">&nbsp;</td>"+
							"<td  width=\"90\" class=\"normalfnt\">Ref No</td>"+
							"<td align=\"left\" width=\"100\"><label>"+
							  "<input name=\"refNo\" value =\"0\" type=\"text\" class=\"txtboxRightAllign\"  id=\"refNo\"  maxlength=\"9\" style=\"width:75px; text-align:right\"  />"+
							"</label></td>"+
							"<td class=\"normalfnt\" width=\"80\">Country</td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboCountries\" class=\"txtbox\" id=\"cboCountries\" style=\"width:78px\">"+
							"</select>"+
							"</label></td>"+
						  "</tr>"+
							/*"<td class=\"normalfnt\">Estimated Delivery Date</td>"+
							"<td>"+
							"<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"  >" +
							  "<input name=\"estimateddeliverydate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"estimateddeliverydate\" onclick=\"return showCalendar('estimateddeliverydate', '%d/%m/%Y');\"/>"+
							  "<input type=\"reset\" value=\"\"  class=\"txtboxRightAllign\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('deliverydate', '%d/%m/%Y');\">" +
							"</td>"+*/
						
						  "<tr height=\"26\">"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Delivery Status</td>"+
							"<td align=\"left\">"+
							"<select name=\"cboDeliveryStatus\" class=\"txtbox\" id=\"cboDeliveryStatus\" style=\"width:140px\">"+
							"<option value='-1'></option>"+
                            "<option value='1'>CONFIRMED</option>"+
                            "<option value='2'>BLOCKED</option>"+ 
							" </td>"+
							"<td class=\"normalfnt\" width=\"80\">Cut off Date</td>"+
							"<td class=\"normalfnt\" width=\"80\">"+
							"<input name=\"cutOffDate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"cutOffDate\" onclick=\"return showCalendar('cutOffDate', '%d/%m/%Y');\" style=\"width:75px;\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('cutOffDate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+
						
						 /*"<tr>"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Lead Time</td>"+
							"<td><label>"+
							"<select name=\"cboLeadTime\" class=\"txtbox\" id=\"cboLeadTime\" style=\"width:140px\">"+
							"</select>"+
							"</label></td>"+
						 "</tr>"+*/
						  "<tr height=\"26\">"+
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
								"<td width=\"40%\">&nbsp;</td>"+
								"<td width=\"55%\" ailgn=\"right\"><img src=\"images/upload.jpg\" alt=\"Save\" width=\"84\" height=\"24\" border=\"0\" class=\"mouseover\" onclick=\"uploadBuyerPO("+styleId+","+Qty+");\" />&nbsp;&nbsp;<img src=\"images/save.png\" class=\"mouseover\" width=\"84\" height=\"24\" onClick=\"SaveNewDeliverySchedule();\" />&nbsp;&nbsp;<img src=\"images/close.png\" class=\"mouseover\" width=\"95\" height=\"24\" onClick=\"closeWindow();\" /></td>"+
								"<td width=\"5%\">&nbsp;</td>"+
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
	loadCountries();
	calExQtyForDeliverySchedule(balanceQuantity);
	//LoadLeadTimes();
	//LoadPODelivery();
}
function calExQtyForDeliverySchedule(Qty)
{
	var ExPct = parseFloat(document.getElementById('txtEXQTY').value);
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
function loadCountries()
{    
    //createXMLHttpRequest();
    //xmlHttp.onreadystatechange = HandleShippingModes;
    var url = 'preordermiddletire.php?RequestType=GetCountries';
	var xmlHttp = $.ajax({url:url,async:false});
	//alert(xmlHttp.responseText);
	var XMLcountryID = xmlHttp.responseXML.getElementsByTagName("countryID");
			 var XMLcountryName = xmlHttp.responseXML.getElementsByTagName("countryName");
			 for ( var loop = 0; loop < XMLcountryID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLcountryName[loop].childNodes[0].nodeValue;
				opt.value = XMLcountryID[loop].childNodes[0].nodeValue;
				document.getElementById("cboCountries").options.add(opt);
			 }
			 document.getElementById("cboCountries").value = contpos;
    //xmlHttp.send(null);     
}
function ValidateSchedule()
{
	//if (document.getElementById('chkBase').checked && IsBaseScheduled()) return false;
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
	
	var bpono	= document.getElementById("txtBpo").value;
	if (document.getElementById('quantity').value == null || document.getElementById('quantity').value == "")
	{
		alert("Please enter the correct quantity.");
		document.getElementById('quantity').focus();
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
	//else if (isDateNotAvailabile(document.getElementById('deliverydate').value))
	else if (isDateNotAvailabile(document.getElementById('deliverydate').value, bpono))
	{
		alert("The schedule date already exists.");
		document.getElementById('deliverydate').focus();
		return false;
	}
	else if (isExceedingQuantity(parseInt(document.getElementById('quantity').value)))
	{
		alert("You are exceeding the main quantity. Please check it again.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if (isExceedingExcessQuantity())
	{
		//alert("You are exceeding the main excess quantity. Please check it again.");
		//document.getElementById('excqty').focus();
		//return false;
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
		
		var class1 = tbl.rows[loop].className ;
		if (class1 == "bcggreen")
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
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var class1 = tbl.rows[loop].className ;
		if (class1 == "bcggreen" && deliveryID != tbl.rows[loop].id)
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

// ------------------------------------------------------------------------------------------



// ------------------------------------------------------------------------------------------

function AddScheduletoTable()
{
	
		var date = document.getElementById('deliverydate').value;
		var qty = document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var bpo = document.getElementById("txtBpo").value;
		var refNo = document.getElementById("refNo").value;
		var handoverDate = document.getElementById("handOverdate").value;
		var estimateddate = document.getElementById("estimatedDate").value;
		//alert(estimateddate);
		var mode = "";
		if(document.getElementById('cboShippingMode').options.length > 0)
		mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var LeadTime = 0;
		var LeadID = 0;
		//hide lead time combo & estimate date for orit
		/*if (document.getElementById('cboLeadTime').options.length > 0)
		{
			var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
			var LeadID = document.getElementById('cboLeadTime').value;
		}
		var estimateddate =  document.getElementById('estimateddeliverydate').value;*/
		var remarks = document.getElementById('remarks').value;
		var modeID = document.getElementById('cboShippingMode').value;
		
		
		var iDeliveryStatus = document.getElementById('cboDeliveryStatus').value;
		var dtCutOffDate	= document.getElementById('cutOffDate').value;
		
		
		
		var strDeliveryStatus = GetDeliveryStatus(iDeliveryStatus);
		
		
		var tbl = document.getElementById('tblDelivery');
		var lastRow = tbl.rows.length;	
		
		var row = tbl.insertRow(lastRow);
		row.id = deliveryIndex;
		//hide setBaseSchedule check box for orit
		/*if (document.getElementById('chkBase').checked)
			row.className = "bcggreen";
		else
			row.className = "bcgwhite";*/
			row.className = "bcgwhite";
			var cellEdit = row.insertCell(0); 
		cellEdit.id = 0;
		if(editDelScheduleAfterRevision =='1' || editDelScheduleAfterFirstRevision=='1')
		{
			cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";
		}
		else
		{
			cellEdit.innerHTML='&nbsp;';
		}
		
		var cellDelete = row.insertCell(1); 
		//if(deleteDelSchedule)
			//cellDelete.innerHTML = "<div id=\"" +  date + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
			cellDelete.innerHTML = "<div id=\"" +  bpo + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
		//else
			//cellDelete.innerHTML='&nbsp;';
		
		
		var cellDeliveryDate = row.insertCell(2);     
		cellDeliveryDate.className="normalfntMid";
		cellDeliveryDate.id = date;
		cellDeliveryDate.innerHTML = date;
		
		var cellQty = row.insertCell(3);     
		cellQty.className="normalfntRite";
		cellQty.innerHTML = qty;
		
		var cellExQty = row.insertCell(4);     
		cellExQty.className="normalfntRite";
		cellExQty.innerHTML = exqty;
		
		var cellMode = row.insertCell(5);     
		cellMode.className="normalfntMid";
		cellMode.id = modeID;
		cellMode.innerHTML = mode;
		
		var cellRemarks = row.insertCell(6);     
		cellRemarks.className="normalfnt";
		if (remarks == null || remarks == "" )
			remarks = " ";
		cellRemarks.innerHTML = remarks;
		
		var cellBPO = row.insertCell(7);
		cellBPO.className="normalfntMid";
		cellBPO.id = bpo;
		cellBPO.innerHTML = bpo;
		
		var cellestimateDate = row.insertCell(8);
		cellestimateDate.className="normalfntMid";
		cellestimateDate.id = estimateddate;
		cellestimateDate.innerHTML = estimateddate;
		
		var cellhandoverDate = row.insertCell(9);
		cellhandoverDate.className="normalfntMid";
		cellhandoverDate.id = handoverDate;
		cellhandoverDate.innerHTML = handoverDate;
		
		var cellrefNo = row.insertCell(10);
		cellrefNo.className="normalfntMid";
		cellrefNo.innerHTML = refNo;
		
		var cellDeliStatus = row.insertCell(11);
		cellDeliStatus.id = iDeliveryStatus;
		cellDeliStatus.className="normalfntMid";
		cellDeliStatus.innerHTML = strDeliveryStatus;
		
		var cellCutOffDate = row.insertCell(12);
		cellCutOffDate.id = dtCutOffDate;
		cellCutOffDate.className="normalfntMid";
		cellCutOffDate.innerHTML = dtCutOffDate;
		
		alert("The Delivery Schedule added successfully.");
		
		deliveryIndex ++;
		
	
}

function RemoveSchedule(obj)
{

	alert(obj.id);
        if(confirm('Are you sure you want to delete this schedule?'))
	{
		
		DeleteDeliverySchedule(obj.id);
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);
	}
}

function RefreshDeliveryForm()
{
	var Qty = parseFloat(document.getElementById('txtQTY').value);
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
	var country = tbl.rows[position].cells[10].id;
	
	//hide for orit -----------------------------------------
	/*var estDate = "";
	if(tbl.rows[position].cells[8].lastChild != null)
	estDate = tbl.rows[position].cells[8].lastChild.nodeValue;
	leadposition = tbl.rows[position].cells[7].id;*/
	//-------------------------------------
	
	shippos = tbl.rows[position].cells[5].id;
	contpos = tbl.rows[position].cells[10].id;
	
	// Get delivery status for edit deliveryschedule
	// =======================================================
	var deliverystatus	= tbl.rows[position].cells[11].lastChild.nodeValue;
	var cutoffdate		= tbl.rows[position].cells[12].lastChild.nodeValue;
	
	// =======================================================
	var class_Name = tbl.rows[position].className ;
	var checkedtext = "";
	if (class_Name == "bcggreen")
		 checkedtext = "checked=\"checked\"";
	
	drawPopupArea(530,320,'frmItems');
	var HTMLText = " <table width=\"530\" class=\"bcgl1\"  height=\"320\">"+
					"<tr>"+
					 " <td><table width=\"100%\" height=\"300\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
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
							"<td class=\"normalfnt\" width=\"80\">Country</td>"+
							"<td align=\"left\"><label>"+
							"<select name=\"cboCountries\" class=\"txtbox\" id=\"cboCountries\" style=\"width:78px\">"+
							"</select>"+
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
						 "<tr height=\"26\">"+
							"<td>&nbsp;</td>"+
							"<td class=\"normalfnt\">Delivery Status</td>"+
							"<td align=\"left\">"+
							"<select name=\"cboDeliveryStatus\" class=\"txtbox\" id=\"cboDeliveryStatus\" style=\"width:140px\">"+
							"<option value='-1'></option>"+
                            "<option value='1' >CONFIRMED</option>"+
                            "<option value='2'>BLOCKED</option>"+ 
							" </td>"+
							"<td class=\"normalfnt\" width=\"80\">Cut off Date</td>"+
							"<td class=\"normalfnt\" width=\"80\">"+
							"<input name=\"cutOffDate\" type=\"text\" class=\"txtboxRightAllign\" onkeypress=\"return ControlableKeyAccess(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" id=\"cutOffDate\" onclick=\"return showCalendar('cutOffDate', '%d/%m/%Y');\" style=\"width:75px;\" value=\"" + cutoffdate + "\" />"+
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar('cutOffDate', '%d/%m/%Y');\">" +
							  "<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"  >" +
							"</td>"+
						  "</tr>"+

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
	document.getElementById('remarks').value=remarks;
	getShippingModes();
	loadCountries();
	//LoadLeadTimes(); //hide for orit
	//LoadPODeliveryDate(date);
}

function getAllocatedQuantity()
{
	var tbl = document.getElementById('tblDelivery');
	var allocatedQuantity = 0;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
       allocatedQuantity += parseInt(tbl.rows[loop].cells[3].lastChild.nodeValue);
	}
	return allocatedQuantity;
}

function isExceedingQuantity(newQuantity)
{
	var Qty = parseInt(document.getElementById('txtQTY').value);
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
       allocatedQuantity += parseInt(tbl.rows[loop].cells[4].lastChild.nodeValue);
	}
	return allocatedQuantity;
}

function isExceedingExcessQuantity()
{
	var givenEX = parseInt(document.getElementById('excqty').value);
	var ExQtyPC = parseInt(document.getElementById('txtEXQTY').value);
	var odrQty =  parseInt(document.getElementById('txtQTY').value);
	var maxExQty =  parseInt(odrQty + (odrQty * ExQtyPC / 100 ));
	//var ExQty = parseInt(newQuantity + (newQuantity * ExQtyPC));
	var allocatedQty = getAllocatedExcessQuantity();
	var balanceQuantity = maxExQty - allocatedQty;
	if (balanceQuantity < givenEX )
		return true;
	return false;
}

function UpdateSchedule(deldate,position)
{
	if(ValidateScheduleModifications(deldate,position) && ValidateBPOAllocation())
	{
		saveDeliveryChanges(deldate);
		UpdateDeliveryScheduleTable(deldate,position);
	}
}



function isDateNotAvailabile(newdate, bpono)
{
	var tbl = document.getElementById('tblDelivery');
	for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw 		= tbl.rows[loop];
        var date 	= rw.cells[2].lastChild.nodeValue;
		var bpoNo 	= rw.cells[7].lastChild.nodeValue;
		if ((newdate == date) && (bpoNo == bpono))
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

function ValidateScheduleModifications(newdate,position)
{
	//if (document.getElementById('chkBase').checked && IsEditedBaseScheduled(position)) return false;
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
	else if (isExceedingEditingQuantity(newdate,parseInt(document.getElementById('quantity').value)))
	{
		alert("You are exceeding the main quantity. Please check it again.");
		document.getElementById('quantity').focus();
		return false;
	}
	else if (isEditingExceedingExcessQuantity(newdate,parseInt(document.getElementById('excqty').value)))
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
	var Qty = parseInt(document.getElementById('txtQTY').value);
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
       		allocatedQuantity += parseInt(tbl.rows[loop].cells[3].lastChild.nodeValue);
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
       		allocatedQuantity += parseInt(tbl.rows[loop].cells[4].lastChild.nodeValue);
	}
	return allocatedQuantity;
}

function isEditingExceedingExcessQuantity(newdate,newQuantity)
{

/*
	var ExQty = parseInt(document.getElementById('txtEXQTY').value);
	var allocatedQty = getEditingAllocatedExcessQuantity(newdate);
	var balanceQuantity = ExQty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
	*/
	
	var givenEX = parseInt(document.getElementById('excqty').value);
	var ExQtyPC = parseInt(document.getElementById('txtEXQTY').value);
	var odrQty =  parseInt(document.getElementById('txtQTY').value);
	var maxExQty =  parseInt(odrQty + (odrQty * ExQtyPC / 100 ));
	
	var allocatedQty = getEditingAllocatedExcessQuantity(newdate);
	var balanceQuantity = maxExQty - allocatedQty;
	if (balanceQuantity < newQuantity )
		return true;
	return false;
	// ----------------------
	

	//var ExQty = parseInt(newQuantity + (newQuantity * ExQtyPC));

	
	// ----------------------
}



function SavePreOrderSheet()
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var RepeatNo = document.getElementById('txtRepeatNo').value;
	var StyleName = document.getElementById('txtStyleName').value;
	var BuyerID = document.getElementById('cboCustomer').value;
	var BuyingOfficeID = document.getElementById('cboBuyingOffice').value;
	var RefNo = document.getElementById('txtRefNo').value;
	var MerchantID =document.getElementById('cboMerchandiser').value;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var SMV = document.getElementById('txtSMV').value;
	var Qty = document.getElementById('txtQTY').value;
	var ExQty = document.getElementById('txtEXQTY').value;
	var DivisionID = document.getElementById('dboDivision').value;
	var SeasonID = document.getElementById('dboSeason').value;
	var EffLevel = document.getElementById('txtEffLevel').value;
	var NoOfLines = document.getElementById('txtNoLines').value;
	var FinanceP = document.getElementById('txtFinancePercentage').value;
	var FinanceA = document.getElementById('txtFinanceAmount').value;
	var MaterialCost = document.getElementById('txtMaterialCost').value;
	var SMVRate = document.getElementById('txtSMVRate').value;
	var CMValue = document.getElementById('txtCMValue').value;
	var TargetFOB = document.getElementById('txtTargetFOB').value;
	var UpCharge = document.getElementById('txtUPCharge').value;
	var UPChargeReason = document.getElementById('txtUPChargeReason').value;
	var ESC = document.getElementById('txtESC').value;
	var ScheduleMethod = document.getElementById('cboScheduleMethod').value;
	var subcontractQty = document.getElementById('txtSubContactQty').value;
	
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleSavingPreorderSheet;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SavePreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod + '&subcontractQty=' + subcontractQty + '&UPChargeReason=' + URLEncode(UPChargeReason), true);    
	xmlHttp.send(null); 	
}

function HandleSavingPreorderSheet()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  	
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");			 
			if (XMLResult[0].childNodes[0].nodeValue == "True")
				mainDataSaving = true;
			else
				mainDataSaving = false;
		}
	}
}

function SaveItems()
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].id;
		var posID = tbl.rows[loop].cells[2].id;
		var conpc = parseFloat(tbl.rows[loop].cells[3].lastChild.nodeValue)  ;
		var unitType = tbl.rows[loop].cells[4].lastChild.nodeValue ;
		var unitPrice = parseFloat(tbl.rows[loop].cells[5].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue)  ;
		var ReqQty = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue) ;
		var totalQty = parseFloat(tbl.rows[loop].cells[8].lastChild.nodeValue) ;
		var price = parseFloat(tbl.rows[loop].cells[9].lastChild.nodeValue);
		var value = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var originName = tbl.rows[loop].cells[11].lastChild.nodeValue  ;
		var originID = tbl.rows[loop].cells[11].id;
		var freight = parseFloat(tbl.rows[loop].cells[12].lastChild.nodeValue) ;
		
		createXMLHttpRequest();
		xmlHttp.open("GET",'preordermiddletire.php?RequestType=SaveItems&ItemCode=' + itemid + '&ConPc=' + conpc + '&UnitPrice=' + unitPrice + '&wastage=' + wastage + '&origin=' + originID  + '&StyleNo=' + URLEncode(StyleNo)  + '&ReqQty=' + ReqQty  + '&totalQty=' + totalQty + '&value=' + value + '&price=' + price + '&OrderNo=' + URLEncode(OrderNo) + '&freight=' + freight  + '&unitType=' + URLEncode(unitType), true);
		xmlHttp.send(null); 
		
		var obj = Mainvariations[posID];
		for (i in obj)
		{
			var arrElements = obj[i];
			var conpc = arrElements[0];
			var unitprice = arrElements[1] ;
			var wastage = arrElements[2];
			var qty = arrElements[3];
			var color = arrElements[4];
			variationsCount ++;
			createThirdXMLHttpRequest();
			thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveVariations&ItemCode=' + itemid + '&StyleNo=' + URLEncode(StyleNo) + '&conpc=' + conpc + '&unitprice=' + unitprice + '&wastage=' + wastage + '&qty=' + qty + '&color=' + color + '&IncID=' + i , true);
			thirdxmlHttp.send(null);
		}	
	}
}

function SaveDeliveryDetails()
{
	var tbl = document.getElementById('tblDelivery');
	var StyleNo = document.getElementById('txtStyleNo').value;
    for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
		var date = tbl.rows[loop].cells[2].lastChild.nodeValue;
		var qty = tbl.rows[loop].cells[3].lastChild.nodeValue;
		var exqty = tbl.rows[loop].cells[4].lastChild.nodeValue;
		var mode = tbl.rows[loop].cells[5].lastChild.nodeValue;
		var modeID =  tbl.rows[loop].cells[5].id;
		var remarks = tbl.rows[loop].cells[6].lastChild.nodeValue;
		var modeID =  tbl.rows[loop].cells[5].id;
		var LeadID = tbl.rows[loop].cells[7].id ;
		var estimateddate =  tbl.rows[loop].cells[7].lastChild.nodeValue;
		var class1 =tbl.rows[loop].className;
		var isbase= "N";
		if (class1 == "bcggreen")
			isbase= "Y";
		
		createAltXMLHttpRequest();
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID + '&estimateddate=' + estimateddate, true);
		altxmlHttp.send(null); 

	}
}

function ValidateItems()
{
	var tbl = document.getElementById('tblConsumption');
    if (tbl.rows.length <= 1)
	{
		alert ("No Items selected to be approval. Please select you items");
		return false;
	}
	return true;
}

function ValidateDeliverySchedule()
{
	var allocatedQuantity = getAllocatedQuantity();
	var allocatedExceedQuantity = getAllocatedExcessQuantity();
	var Qty = document.getElementById('txtQTY').value;
	var ExQty = document.getElementById('txtEXQTY').value;
	
	if (allocatedQuantity != Qty)
	{
		alert("Your delivery schedule is not valid with the quantity");	
		return false;
	}
	else if (allocatedExceedQuantity != ExQty)
	{

		alert("Your delivery schedule is not valid with the exceed quantity");	
		return false;
	}
	return true;
}

function ChangeFOB()
{
/*	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	var esc = parseFloat(document.getElementById('txtESC').value);
	var upcharge = parseFloat(document.getElementById('txtUPCharge').value);


	var currentfob = parseFloat(document.getElementById('txtTargetFOB').value);
	var cmValue = currentfob - pcmeterialCost - esc - finance + upcharge;
	document.getElementById('txtCMValue').value = RoundNumbers(cmValue,4);
	
	CalculateCMRate();*/
	
		var pcmeterialCost =  document.getElementById('txtMaterialCost').value ;if(pcmeterialCost=='') {pcmeterialCost = 0}	else{pcmeterialCost = parseFloat(pcmeterialCost)};
	var finance =  document.getElementById('txtFinanceAmount').value;if(finance=='') {finance = 0}	else{finance = parseFloat(finance)};
	var esc = document.getElementById('txtESC').value;if(esc=='') {esc = 0}	else{esc = parseFloat(esc)};
	var upcharge = document.getElementById('txtUPCharge').value;if(upcharge=='') {upcharge = 0}	else{upcharge = parseFloat(upcharge)};
		
	var currentfob = document.getElementById('txtTargetFOB').value;if(currentfob=='') {currentfob = 0}	else{currentfob = parseFloat(currentfob)};
	var cmValue = currentfob - pcmeterialCost - esc - finance + upcharge;
	document.getElementById('txtCMValue').value = RoundNumbers(cmValue,4);
	
	CalculateCMRate();
	
}

function ChangeOrderQuantity()
{
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var exQty = parseFloat(document.getElementById('txtEXQTY').value);
	
	//==========================================================	
	// Comment On - 03/03/2014
	// Description - Remove checking if item has been purchased
	//==========================================================
	//==========================================================	
	// Comment On - 03/19/2015
	// Description - Un comment request by MD
	//==========================================================
	if(isPurchase == 'TRUE')
	{
		if(Qty < parseFloat(POorderQty))
		{
			
			alert('You cannot decrease the order quantity, because some items has been already purchased');
			
			document.getElementById('txtQTY').value = 	POorderQty;
			document.getElementById('txtQTY').focus();
			return;
		}
	}
	//==========================================================
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].id;
		var posID = tbl.rows[loop].cells[2].id;
		var conpc = parseFloat(tbl.rows[loop].cells[3].lastChild.nodeValue)  ;
		var unitType = tbl.rows[loop].cells[4].lastChild.nodeValue ;
		var unitPrice = parseFloat(tbl.rows[loop].cells[5].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue)  ;
		var freight = parseFloat(tbl.rows[loop].cells[12].lastChild.nodeValue) ;
		var mainCat = parseInt(tbl.rows[loop].cells[16].id)
		/*tbl.rows[loop].cells[7].lastChild.nodeValue =RoundNumbers( conpc * Qty,0);
		
		var totalQty = 0;
		if (tbl.rows[loop].cells[3].id == "F")
		{
			totalQty = conpc * Qty  ;
		}
		else
		{
			totalQty = (conpc * Qty) + (conpc * Qty * wastage / 100) + (conpc * Qty *  exQty / 100) ;
		}
		tbl.rows[loop].cells[8].lastChild.nodeValue = RoundNumbers(totalQty,0);
		var totval = (conpc +  (conpc * wastage / 100)) * Qty * (unitPrice);
		tbl.rows[loop].cells[9].lastChild.nodeValue = RoundNumbers(totval,2);
		CalculateFigures();*/
		
		var reqQty = calculateReqQty(Qty,conpc);
		var totalQty = calculateTotalQty(Qty,conpc,wastage,exQty,mainCat);
		var value  = calculateCostValue(totalQty,unitPrice,freight);
		var totOrderQty = Qty; //parseFloat(Qty*exQty/100) 
		var price  = RoundNumbers(calCostPCwithExcess(Qty,value),4);
		
		tbl.rows[loop].cells[7].lastChild.nodeValue = reqQty;
		tbl.rows[loop].cells[8].lastChild.nodeValue = totalQty;
		tbl.rows[loop].cells[9].lastChild.nodeValue = value;
		tbl.rows[loop].cells[10].lastChild.nodeValue = price;
		CalculateFigures();
		
	}
	
}

function ChangeFactory()
{
	//var factoryName = document.getElementById('cboFactory').options[document.getElementById('cboFactory').selectedIndex].text;
	//document.getElementById('companyName').innerHTML = factoryName;
	factoryID = document.getElementById('cboFactory').value;
}

function AutoCompleteStyleNos(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 40)
	{
		document.getElementById("lstStyleNos").focus();
		return ;
	}
	RemoveCurrentStyleList();
	var text = document.getElementById('txtStyleNo').value;
	if (trim(text) == "" || trim(text) == null ||  charCode == 27 )
	{
		closeList();
		return;
	}
	
	createXMLHttpRequest();
   	xmlHttp.onreadystatechange = HandleStyleNos;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleNo&InputLatter=' + URLEncode(text), true);
    xmlHttp.send(null);     
}

function HandleStyleNos()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			if (document.getElementById("lstStyleNos") == null)
			{
				var html = "<div id=\"listDiv\" style=\"width:200px; height:150px\">" +
							"<select name=\"select\" size=\"1\" id=\"lstStyleNos\" onkeydown=\"ItemListKeyHandler(event)\" onchange=\"ShowSelectedStyleNo();\" style=\"width:200px; height:150px\" multiple=\"multiple\"></select></div>";
				
				var popupbox = document.createElement("div");
				 popupbox.id = "stylelist";
				 popupbox.style.position = 'absolute';
				 popupbox.style.zIndex = 2;
				 popupbox.style.left = curLeft(document.getElementById('txtStyleNo')) + "px";
				 popupbox.style.top = eval(curTop(document.getElementById('txtStyleNo')) + document.getElementById('txtStyleNo').offsetHeight) + "px"; 
				 popupbox.innerHTML = html;     
				 popupbox.ondblclick = closeList;
				 document.body.appendChild(popupbox);
			}
			 
			 var available = false;
			 var XMLNos = xmlHttp.responseXML.getElementsByTagName("Style");
			 for ( var loop = 0; loop < XMLNos.length; loop ++)
			 {
				 available = true;
				 var opt = document.createElement("option");
				opt.text = XMLNos[loop].childNodes[0].nodeValue;
				opt.value = XMLNos[loop].childNodes[0].nodeValue;
				document.getElementById("lstStyleNos").options.add(opt);				
			 }
			 
			 if (available == false)
			 	closeList();			
		}
	}
}

function curLeft(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetLeft;
		obj = obj.offsetParent;
	}
	return toreturn;
}

function curTop(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return toreturn;
}

function closeList()
{
	try
	{
		var box = document.getElementById('stylelist');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function RemoveCurrentStyleList()
{
	if (document.getElementById("lstStyleNos") == null) return;
	var index = document.getElementById("lstStyleNos").options.length;
	while(document.getElementById("lstStyleNos").options.length > 0) 
	{
		index --;
		document.getElementById("lstStyleNos").options[index] = null;
	}
}

function ShowSelectedStyleNo()
{
	document.getElementById('txtStyleNo').value = document.getElementById("lstStyleNos").value;
}

function ItemListKeyHandler(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode == 13) closeList();
}

function GetAcknowledgement()
{
	var styleNo  = document.getElementById('txtStyleNo').value;
	
	var StyleNo = document.getElementById('txtStyleNo').value;	
	var tblItems = document.getElementById('tblConsumption');
	var ItemCount = tblItems.rows.length -1;
	var tblSchedule = document.getElementById('tblDelivery');
	var ScheduleCount = tblSchedule.rows.length -2;
	var varCount = variationsCount;
	
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleAcknowledgement;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getAcknowledgement&StyleNo=' + URLEncode(styleNo) + '&ItemsCount=' + ItemCount + '&VariationCount=' +  varCount +  '&ScheduleCount=' + ScheduleCount, true);
    xmlHttp.send(null);
}

function HandleAcknowledgement()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var message = "";
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Style");
			var XMLItems = xmlHttp.responseXML.getElementsByTagName("Items");
			var XMLVariations = xmlHttp.responseXML.getElementsByTagName("Variations");
			var XMLSchedules = xmlHttp.responseXML.getElementsByTagName("Schedules");
			
			var redirectRequire = true;
			
			if (XMLStyle[0].childNodes[0].nodeValue == "True")
			{
				message += "Order Details Saving ..... - Completed.\n\n";
			}
			else
			{
				message += "Order Details Saving ..... - Failed.\n\n";
				redirectRequire = false;
			}
				
			if (XMLItems[0].childNodes[0].nodeValue == "True")
			{
				message += "Item Details Saving ..... - Completed.\n\n";
			}
			else
			{
				message += "Item Details Saving ..... - Failed.\n\n";
				redirectRequire = false;
			}
			
			if (XMLVariations[0].childNodes[0].nodeValue == "True")
			{
				message += "Variation Details Saving ..... - Completed.\n\n";
			}
			else
			{
				message += "Variation Details Saving ..... - Failed.\n\n";
				redirectRequire = false;
			}
			
			if (XMLSchedules[0].childNodes[0].nodeValue == "True")
			{
				message += "Schedule Details Saving ..... - Completed.";
			}
			else
			{
				message += "Schedule Details Saving ..... - Failed.";
				redirectRequire = false;
			}
			
			if(redirectRequire == false)
			{
				GetAcknowledgement();
				return;
			}
			
			alert(message);
			ClosePreloader();
			if (mainpagerequest)
			{
				if (redirectRequire)
				{
					window.location = "main.php";
				}
			}


			
		}	
	}
}

function SavePreOrder()
{
	if (ValidateInterfaceComponents())
	{
		approvalStatus = 0;
		mainpagerequest = true;
		var styleNo = document.getElementById('txtStyleNo').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleStyleNO;
		xmlHttp.open("GET", 'preordermiddletire.php?RequestType=IsExistingStyle&StyleNo=' + URLEncode(styleNo), true);
		xmlHttp.send(null); 
	}
	else
	{
		return false;	
	}
}

function HandleStyleNO()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Style");
			if (XMLStyle[0].childNodes[0].nodeValue == "False")
			{
				ArrangeDtabase();
			}
			else
			{
				alert("Sorry! The style no already exists. Please try again.");
			}
		}		
	}
}

function LoadSavedOrderDetails()
{
		//createXMLHttpRequest();
		//xmlHttp.onreadystatechange = HandleSavedOrderDetails;
		//xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getOrderData&StyleID=' + URLEncode(EditStyleNo), true);
		//xmlHttp.send(null); 
		var url = 'preordermiddletire.php?RequestType=getOrderData&StyleID=' + URLEncode(EditStyleNo);
		var xmlHttp = $.ajax({url:url,async:false});	
		var XMLOrderNo = xmlHttp.responseXML.getElementsByTagName("OrderNo");
			var XMLStyleName = xmlHttp.responseXML.getElementsByTagName("StyleName");
			var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleID");
			var XMLCompanyID = xmlHttp.responseXML.getElementsByTagName("CompanyID");
			var XMLDescription = xmlHttp.responseXML.getElementsByTagName("Description");
			var XMLBuyerID = xmlHttp.responseXML.getElementsByTagName("BuyerID");
			var XMLintQty = xmlHttp.responseXML.getElementsByTagName("intQty");
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");
			var XMLCustomerRefNo = xmlHttp.responseXML.getElementsByTagName("CustomerRefNo");
			var XMLSMVRate = xmlHttp.responseXML.getElementsByTagName("SMVRate");
			var XMLFOB = xmlHttp.responseXML.getElementsByTagName("FOB");
			var XMLFinance = xmlHttp.responseXML.getElementsByTagName("Finance");
			var XMLUserID = xmlHttp.responseXML.getElementsByTagName("UserID");
			var XMLFinPercntage = xmlHttp.responseXML.getElementsByTagName("FinPercntage");
			var XMLEfficiencyLevel = xmlHttp.responseXML.getElementsByTagName("EfficiencyLevel");
			var XMLCostPerMinute = xmlHttp.responseXML.getElementsByTagName("CostPerMinute");
			var XMLECSCharge = xmlHttp.responseXML.getElementsByTagName("ECSCharge");
			var XMLBuyingOfficeId = xmlHttp.responseXML.getElementsByTagName("BuyingOfficeId");
			var XMLDivisionId = xmlHttp.responseXML.getElementsByTagName("DivisionId");
			var XMLSeasonId = xmlHttp.responseXML.getElementsByTagName("SeasonId");
			var XMLRPTMark = xmlHttp.responseXML.getElementsByTagName("RPTMark");
			var XMLLineNos = xmlHttp.responseXML.getElementsByTagName("LineNos");
			var XMLUPCharges = xmlHttp.responseXML.getElementsByTagName("UPCharges");
			var XMLUPChargesReason = xmlHttp.responseXML.getElementsByTagName("UPChargesReason");
			var XMLExPercentage = xmlHttp.responseXML.getElementsByTagName("ExPercentage");
			var XMLExSMV = xmlHttp.responseXML.getElementsByTagName("SMV");
			var XMLExShedule = xmlHttp.responseXML.getElementsByTagName("SheduleMethod");
			var XMLSubQty = xmlHttp.responseXML.getElementsByTagName("SubQty");
			var XMLorderUnit = xmlHttp.responseXML.getElementsByTagName("orderUnit");
			var XMLproSubcat = xmlHttp.responseXML.getElementsByTagName("proSubcat");
			var XMLCoordinator = xmlHttp.responseXML.getElementsByTagName("Coordinator");
			var XMLLabourCost = xmlHttp.responseXML.getElementsByTagName("labourCost");
			var XMLMargin = xmlHttp.responseXML.getElementsByTagName("Profit");
			var XMLFacProfit = xmlHttp.responseXML.getElementsByTagName("facProfit");

			// ======================================================
			// Comment On - 02/25/2016
			// Comment By - Nalin Jayakody
			// Comment For - To change the Fac OH cost in given time, 
			// ======================================================				
			/* var XMLFacCostPerMin = xmlHttp.responseXML.getElementsByTagName("facCostPerMin"); */
			// ======================================================

			var XMLFacCostPerMin = xmlHttp.responseXML.getElementsByTagName("facCostPerMin");

			isPurchase = xmlHttp.responseXML.getElementsByTagName("ISpurchase")[0].childNodes[0].nodeValue;
			var XMLIsSampleOrder = xmlHttp.responseXML.getElementsByTagName("IsSampleOrder")[0].childNodes[0].nodeValue;
                        
                        
                        // ======================================================
                        // Adding On - 02/09/2017
                        // Adding By - Nalin Jayakody
                        // Adding For - Get status of embellishment of that order.
                        // ======================================================
                        
                        var XMLIsPrint = xmlHttp.responseXML.getElementsByTagName("IsPrint");
                        var XMLIsEMB = xmlHttp.responseXML.getElementsByTagName("IsEmb");
                        var XMLIsHeatSeal = xmlHttp.responseXML.getElementsByTagName("IsHeatSeal");
                        var XMLIsHandWork = xmlHttp.responseXML.getElementsByTagName("IsHandWork");
                        var XMLIsOther = xmlHttp.responseXML.getElementsByTagName("IsOther");
                        var XMLIsNA = xmlHttp.responseXML.getElementsByTagName("IsNA");
                        var XMLPackSMV = xmlHttp.responseXML.getElementsByTagName("PackSMV");
                        
                        if(XMLIsPrint[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        if(XMLIsEMB[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        if(XMLIsHeatSeal[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        if(XMLIsHandWork[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        if(XMLIsOther[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        if(XMLIsNA[0].childNodes[0].nodeValue == 1)
                            IsEmbellishmentSet = 1;
                        
                        
                        
                        // ======================================================
			
			document.getElementById('txtStyleNo').value = XMLStyleID[0].childNodes[0].nodeValue;
			document.getElementById('txtRepeatNo').value = XMLStyleName[0].childNodes[0].nodeValue;
			document.getElementById('cboFactory').value = XMLCompanyID[0].childNodes[0].nodeValue;
			document.getElementById('txtStyleName').value = XMLDescription[0].childNodes[0].nodeValue;
			document.getElementById('cboCustomer').value = XMLBuyerID[0].childNodes[0].nodeValue;
			document.getElementById('cboBuyingOffice').value = XMLBuyingOfficeId[0].childNodes[0].nodeValue;
			document.getElementById('txtRefNo').value = XMLCustomerRefNo[0].childNodes[0].nodeValue;
			document.getElementById('cboMerchandiser').value = XMLUserID[0].childNodes[0].nodeValue;
			document.getElementById('txtOrderNo').value = XMLOrderNo[0].childNodes[0].nodeValue;
			document.getElementById('txtSMV').value = XMLExSMV[0].childNodes[0].nodeValue;
			document.getElementById('txtQTY').value = XMLintQty[0].childNodes[0].nodeValue;
			POorderQty = XMLintQty[0].childNodes[0].nodeValue;
			document.getElementById('txtEXQTY').value = XMLExPercentage[0].childNodes[0].nodeValue;
			document.getElementById('dboDivision').value = XMLDivisionId[0].childNodes[0].nodeValue;
			document.getElementById('dboSeason').value = XMLSeasonId[0].childNodes[0].nodeValue;
			document.getElementById('txtEffLevel').value = XMLEfficiencyLevel[0].childNodes[0].nodeValue;
			document.getElementById('txtNoLines').value = XMLLineNos[0].childNodes[0].nodeValue;
			document.getElementById('txtFinancePercentage').value = XMLFinPercntage[0].childNodes[0].nodeValue;
			document.getElementById('txtFinanceAmount').value = XMLFinance[0].childNodes[0].nodeValue;
			document.getElementById('txtSMVRate').value = XMLSMVRate[0].childNodes[0].nodeValue;
			document.getElementById('txtSubContactQty').value = XMLSubQty[0].childNodes[0].nodeValue;
			//var currentFob = parseFloat(XMLFOB[0].childNodes[0].nodeValue);
			//var currentFob = parseFloat(XMLFOB[0].childNodes[0].nodeValue);
			
			//document.getElementById('txtCMValue').value = XMLCostPerMinute[0].childNodes[0].nodeValue;
			document.getElementById('txtTargetFOB').value = XMLFOB[0].childNodes[0].nodeValue;
			document.getElementById('txtUPCharge').value = XMLUPCharges[0].childNodes[0].nodeValue;
			document.getElementById('txtUPChargeReason').value = XMLUPChargesReason[0].childNodes[0].nodeValue;
			document.getElementById('txtESC').value = XMLECSCharge[0].childNodes[0].nodeValue;
			document.getElementById('cboScheduleMethod').value = XMLExShedule[0].childNodes[0].nodeValue;
			factoryID  = XMLCompanyID[0].childNodes[0].nodeValue;
			document.getElementById('cboOrderUnit').value = XMLorderUnit[0].childNodes[0].nodeValue;
			document.getElementById('cboProductCategory').value = XMLproSubcat[0].childNodes[0].nodeValue;
			document.getElementById('cboMerchandiser').value =  XMLCoordinator[0].childNodes[0].nodeValue;
			document.getElementById('txtLabourCost').value =  XMLLabourCost[0].childNodes[0].nodeValue;
			document.getElementById('txtMargin').value =  XMLMargin[0].childNodes[0].nodeValue;
			//document.getElementById('txtProfit').value =  XMLFacProfit[0].childNodes[0].nodeValue;
			document.getElementById('txtCostPerMinute').value =  XMLFacCostPerMin[0].childNodes[0].nodeValue;
			document.getElementById('cboOrderType').value = XMLIsSampleOrder;
			document.getElementById('cboManuFactory').value =  xmlHttp.responseXML.getElementsByTagName("manufacCompany")[0].childNodes[0].nodeValue;
                        $("#txtPackSMV").val(XMLPackSMV[0].childNodes[0].nodeValue);
			
			LoadSavedItemDetails();
			LoadSavedSchedules();
			if(!uselabourcost)
			changeEffLevel();

}

/*function HandleSavedOrderDetails()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLOrderNo = xmlHttp.responseXML.getElementsByTagName("OrderNo");
			var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleID");
			var XMLCompanyID = xmlHttp.responseXML.getElementsByTagName("CompanyID");
			var XMLDescription = xmlHttp.responseXML.getElementsByTagName("Description");
			var XMLBuyerID = xmlHttp.responseXML.getElementsByTagName("BuyerID");
			var XMLintQty = xmlHttp.responseXML.getElementsByTagName("intQty");
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");
			var XMLCustomerRefNo = xmlHttp.responseXML.getElementsByTagName("CustomerRefNo");
			var XMLSMVRate = xmlHttp.responseXML.getElementsByTagName("SMVRate");
			var XMLFOB = xmlHttp.responseXML.getElementsByTagName("FOB");
			var XMLFinance = xmlHttp.responseXML.getElementsByTagName("Finance");
			var XMLUserID = xmlHttp.responseXML.getElementsByTagName("UserID");
			var XMLFinPercntage = xmlHttp.responseXML.getElementsByTagName("FinPercntage");
			var XMLEfficiencyLevel = xmlHttp.responseXML.getElementsByTagName("EfficiencyLevel");
			var XMLCostPerMinute = xmlHttp.responseXML.getElementsByTagName("CostPerMinute");
			var XMLECSCharge = xmlHttp.responseXML.getElementsByTagName("ECSCharge");
			var XMLBuyingOfficeId = xmlHttp.responseXML.getElementsByTagName("BuyingOfficeId");
			var XMLDivisionId = xmlHttp.responseXML.getElementsByTagName("DivisionId");
			var XMLSeasonId = xmlHttp.responseXML.getElementsByTagName("SeasonId");
			var XMLRPTMark = xmlHttp.responseXML.getElementsByTagName("RPTMark");
			var XMLLineNos = xmlHttp.responseXML.getElementsByTagName("LineNos");
			var XMLUPCharges = xmlHttp.responseXML.getElementsByTagName("UPCharges");
			var XMLUPChargesReason = xmlHttp.responseXML.getElementsByTagName("UPChargesReason");
			var XMLExPercentage = xmlHttp.responseXML.getElementsByTagName("ExPercentage");
			var XMLExSMV = xmlHttp.responseXML.getElementsByTagName("SMV");
			var XMLExShedule = xmlHttp.responseXML.getElementsByTagName("SheduleMethod");
			var XMLSubQty = xmlHttp.responseXML.getElementsByTagName("SubQty");
			var XMLorderUnit = xmlHttp.responseXML.getElementsByTagName("orderUnit");
			var XMLproSubcat = xmlHttp.responseXML.getElementsByTagName("proSubcat");
			var XMLCoordinator = xmlHttp.responseXML.getElementsByTagName("Coordinator");
			var XMLLabourCost = xmlHttp.responseXML.getElementsByTagName("labourCost");
			var XMLMargin = xmlHttp.responseXML.getElementsByTagName("Profit");
			
			document.getElementById('txtStyleNo').value = XMLStyleID[0].childNodes[0].nodeValue;
			document.getElementById('txtRepeatNo').value = XMLRPTMark[0].childNodes[0].nodeValue;
			document.getElementById('cboFactory').value = XMLCompanyID[0].childNodes[0].nodeValue;
			document.getElementById('txtStyleName').value = XMLDescription[0].childNodes[0].nodeValue;
			document.getElementById('cboCustomer').value = XMLBuyerID[0].childNodes[0].nodeValue;
			document.getElementById('cboBuyingOffice').value = XMLBuyingOfficeId[0].childNodes[0].nodeValue;
			document.getElementById('txtRefNo').value = XMLCustomerRefNo[0].childNodes[0].nodeValue;
			document.getElementById('cboMerchandiser').value = XMLUserID[0].childNodes[0].nodeValue;
			document.getElementById('txtOrderNo').value = XMLOrderNo[0].childNodes[0].nodeValue;
			document.getElementById('txtSMV').value = XMLExSMV[0].childNodes[0].nodeValue;
			document.getElementById('txtQTY').value = XMLintQty[0].childNodes[0].nodeValue;
			document.getElementById('txtEXQTY').value = XMLExPercentage[0].childNodes[0].nodeValue;
			document.getElementById('dboDivision').value = XMLDivisionId[0].childNodes[0].nodeValue;
			document.getElementById('dboSeason').value = XMLSeasonId[0].childNodes[0].nodeValue;
			document.getElementById('txtEffLevel').value = XMLEfficiencyLevel[0].childNodes[0].nodeValue;
			document.getElementById('txtNoLines').value = XMLLineNos[0].childNodes[0].nodeValue;
			document.getElementById('txtFinancePercentage').value = XMLFinPercntage[0].childNodes[0].nodeValue;
			document.getElementById('txtFinanceAmount').value = XMLFinance[0].childNodes[0].nodeValue;
			//document.getElementById('txtSMVRate').value = XMLSMVRate[0].childNodes[0].nodeValue;
			document.getElementById('txtSubContactQty').value = XMLSubQty[0].childNodes[0].nodeValue;
			//var currentFob = parseFloat(XMLFOB[0].childNodes[0].nodeValue);
			//var currentFob = parseFloat(XMLFOB[0].childNodes[0].nodeValue);
			
			//document.getElementById('txtCMValue').value = XMLCostPerMinute[0].childNodes[0].nodeValue;
			document.getElementById('txtTargetFOB').value = XMLFOB[0].childNodes[0].nodeValue;
			document.getElementById('txtUPCharge').value = XMLUPCharges[0].childNodes[0].nodeValue;
			document.getElementById('txtUPChargeReason').value = XMLUPChargesReason[0].childNodes[0].nodeValue;
			document.getElementById('txtESC').value = XMLECSCharge[0].childNodes[0].nodeValue;
			document.getElementById('cboScheduleMethod').value = XMLExShedule[0].childNodes[0].nodeValue;
			factoryID  = XMLCompanyID[0].childNodes[0].nodeValue;
			document.getElementById('cboOrderUnit').value = XMLorderUnit[0].childNodes[0].nodeValue;
			document.getElementById('cboProductCategory').value = XMLproSubcat[0].childNodes[0].nodeValue;
			document.getElementById('cboMerchandiser').value =  XMLCoordinator[0].childNodes[0].nodeValue;
			document.getElementById('txtLabourCost').value =  XMLLabourCost[0].childNodes[0].nodeValue;
			document.getElementById('txtMargin').value =  XMLMargin[0].childNodes[0].nodeValue;
			
			
			LoadSavedItemDetails();
			LoadSavedSchedules();
			if(!uselabourcost)
			changeEffLevel();
		}
	}
}*/

function LoadSavedItemDetails()
{
		createAltXMLHttpRequest();
		altxmlHttp.onreadystatechange = HandleSavedItemDetails;
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getOrderDetailData&StyleID=' + URLEncode(EditStyleNo), true);
		altxmlHttp.send(null); 
}

function HandleSavedItemDetails()
{
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        { 
			var XMLstrOrderNo = altxmlHttp.responseXML.getElementsByTagName("OrderNo");
			var XMLintMatDetailID = altxmlHttp.responseXML.getElementsByTagName("MatDetailID");
			var XMLMatName = altxmlHttp.responseXML.getElementsByTagName("ItemName");
			var XMLOrigineName = altxmlHttp.responseXML.getElementsByTagName("OrigineName");
			var XMLUnit = altxmlHttp.responseXML.getElementsByTagName("Unit");
			var XMLdblUnitPrice = altxmlHttp.responseXML.getElementsByTagName("UnitPrice");
			var XMLreaConPc = altxmlHttp.responseXML.getElementsByTagName("ConPc");
			var XMLreaWastage = altxmlHttp.responseXML.getElementsByTagName("Wastage");
			var XMLintOriginNo = altxmlHttp.responseXML.getElementsByTagName("OriginNo");
			var XMLdblReqQty = altxmlHttp.responseXML.getElementsByTagName("dblReqQty");
			var XMLdblTotalQty = altxmlHttp.responseXML.getElementsByTagName("dblTotalQty");
			var XMLdblTotalValue = altxmlHttp.responseXML.getElementsByTagName("dblTotalValue");
			var XMLdbltotalcostpc = altxmlHttp.responseXML.getElementsByTagName("dbltotalcostpc");
			var XMLdblFreight = altxmlHttp.responseXML.getElementsByTagName("Freight");
			var XMLCategory = altxmlHttp.responseXML.getElementsByTagName("MainItem");
			var XMLPurchaseQty = altxmlHttp.responseXML.getElementsByTagName("PurchasedAmount");
			var XMLPurchasePrice = altxmlHttp.responseXML.getElementsByTagName("PurchasedPrice");
			var XMLbintobinqty = altxmlHttp.responseXML.getElementsByTagName("bintobinqty");
			
/*			var XMLtransport = altxmlHttp.responseXML.getElementsByTagName("transport");
			var XMLclearing = altxmlHttp.responseXML.getElementsByTagName("clearing");
			var XMLinterest = altxmlHttp.responseXML.getElementsByTagName("interest");
			var XMLexport = altxmlHttp.responseXML.getElementsByTagName("export");*/
			
			//alert(XMLstrOrderNo.length);
			for ( var loop = 0; loop < XMLstrOrderNo.length; loop ++)
			{
				
				var itemCode = XMLintMatDetailID[loop].childNodes[0].nodeValue;
				var itemDescription = XMLMatName[loop].childNodes[0].nodeValue;
				var conPc = XMLreaConPc[loop].childNodes[0].nodeValue;
				var unitType = XMLUnit[loop].childNodes[0].nodeValue;
				var unitPrice = XMLdblUnitPrice[loop].childNodes[0].nodeValue;wastage = XMLreaWastage[loop].childNodes[0].nodeValue;
				var originName = XMLOrigineName[loop].childNodes[0].nodeValue;
				var freight = XMLdblFreight[loop].childNodes[0].nodeValue;
				var originid = XMLintOriginNo[loop].childNodes[0].nodeValue;
				var category =  XMLCategory[loop].childNodes[0].nodeValue;
				var purchasedQty =  XMLPurchaseQty[loop].childNodes[0].nodeValue;
				var purchasedPrice =  XMLPurchasePrice[loop].childNodes[0].nodeValue;
				//var bintobinqty =  XMLbintobinqty[loop].childNodes[0].nodeValue;
				//alert(bintobinqty);
/*				var transport 	=  XMLtransport[loop].childNodes[0].nodeValue;
				var clearing	=  XMLclearing[loop].childNodes[0].nodeValue;
				var interest 	=  XMLinterest[loop].childNodes[0].nodeValue;
				var exports 	=  XMLexport[loop].childNodes[0].nodeValue;*/
				
				if(wastage == null || wastage == "")
					wastage = 0;
				
				if(freight == null || freight == "")
					freight = 0;
					
				if(originName == null || originName == "")
					originName = " ";
				
			
				AddItem(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,category,purchasedQty,purchasedPrice/*,bintobinqty*/);
				arrayLocation ++
			}
			CalculateMatCost();
			CalculateCMValue();
			var CMValue = parseFloat(document.getElementById('txtCMValue').value);
			var upcharge = parseFloat(document.getElementById('txtUPCharge').value);
			var SMVValue = parseFloat(document.getElementById('txtSMV').value);
			document.getElementById('txtSMVRate').value = RoundNumbers((CMValue + upcharge)/SMVValue,4);
			ReArrangeFigures();
			ChangeFOB();
			HideLoadingImage();
		}
	}
}

function LoadSavedVariation()
{
	createtFifthXMLHttpRequest();
	fifthxmlHttp.onreadystatechange = HandleSavedVariations;
	fifthxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getVariationData&StyleID=' + URLEncode(EditStyleNo), true);
	fifthxmlHttp.send(null); 
}

function HandleSavedVariations()
{
	if(fifthxmlHttp.readyState == 4) 
    {
        if(fifthxmlHttp.status == 200) 
        { 
			var XMLMatDetail = fifthxmlHttp.responseXML.getElementsByTagName("Material");
			for ( var loop = 0; loop < XMLMatDetail.length; loop ++)
			{
				var MatID = XMLMatDetail[loop].attributes.getNamedItem("ID").nodeValue;
				var arrvariationlist = [];
				var p = 0;
				var No = fifthxmlHttp.responseXML.getElementsByTagName("intNo");
				for ( var i = 0; i < No.length; i ++)
				{
					if (No[i].attributes.getNamedItem("ID").nodeValue == MatID )
					{
						var intNo = fifthxmlHttp.responseXML.getElementsByTagName("intNo")[i].childNodes[0].nodeValue;
						var conpc = fifthxmlHttp.responseXML.getElementsByTagName("ConPc")[i].childNodes[0].nodeValue;
						var unitprice = fifthxmlHttp.responseXML.getElementsByTagName("UnitPrice")[i].childNodes[0].nodeValue;
						var wastage = fifthxmlHttp.responseXML.getElementsByTagName("Wastage")[i].childNodes[0].nodeValue;
						var color = fifthxmlHttp.responseXML.getElementsByTagName("Color")[i].childNodes[0].nodeValue;
						var Remark = fifthxmlHttp.responseXML.getElementsByTagName("Remark")[i].childNodes[0].nodeValue;
						var qty = fifthxmlHttp.responseXML.getElementsByTagName("qty")[i].childNodes[0].nodeValue;
						var arrvar = [conpc,unitprice,wastage,qty,color];
						arrvariationlist[p] = arrvar;
						p ++;
						
					}
				}
				Mainvariations[loop]	= arrvariationlist;

				
				
			
			}

		}
	}
}

function LoadSavedSchedules()
{
	createtFourthXMLHttpRequest();
	fourthxmlHttp.onreadystatechange = HandleSavedSchedules;
	fourthxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getDeliveryData&StyleID=' + URLEncode(EditStyleNo), true);
	fourthxmlHttp.send(null);	
}

function HandleSavedSchedules()
{
	if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        { 
			var XMLDateofDelivery 	= fourthxmlHttp.responseXML.getElementsByTagName("DateofDelivery");
			var XMLQty 				= fourthxmlHttp.responseXML.getElementsByTagName("Qty");
			var XMLRemarks 			= fourthxmlHttp.responseXML.getElementsByTagName("Remarks");
			var XMLShippingModeID 	= fourthxmlHttp.responseXML.getElementsByTagName("ShippingModeID");
			var XMLShippingMode 	= fourthxmlHttp.responseXML.getElementsByTagName("ShippingMode");
			var XMLExQty 			= fourthxmlHttp.responseXML.getElementsByTagName("ExQty");
			var XMLisBase 			= fourthxmlHttp.responseXML.getElementsByTagName("isBase");
			var XMLLeadTimeID 		= fourthxmlHttp.responseXML.getElementsByTagName("LeadTimeID");
			var XMLLeadTime 		= fourthxmlHttp.responseXML.getElementsByTagName("LeadTime");
			var XMLEstimated 		= fourthxmlHttp.responseXML.getElementsByTagName("EstimatedDate");
			var XMLApprovalNo 		= fourthxmlHttp.responseXML.getElementsByTagName("intApprovalNo");
			var XMLintbpo 			= fourthxmlHttp.responseXML.getElementsByTagName("intbpo");
			var XMLhandOverDate 	= fourthxmlHttp.responseXML.getElementsByTagName("handOverDate");
			var XMLrefNo 			= fourthxmlHttp.responseXML.getElementsByTagName("refNo");
			var XMLintCountry 		= fourthxmlHttp.responseXML.getElementsByTagName("intCountry");
			
			// =================================================================================
			var XMLintDeliStatus 	= fourthxmlHttp.responseXML.getElementsByTagName("deliStatus");
			var XMLdtCutOffDate 	= fourthxmlHttp.responseXML.getElementsByTagName("CutOffDate");
			// =================================================================================
			
			for ( var loop = 0; loop < XMLDateofDelivery.length; loop ++)
			{
			
				var date            = XMLDateofDelivery[loop].childNodes[0].nodeValue;;
				var qty             = XMLQty[loop].childNodes[0].nodeValue;;
				var exqty           = XMLExQty[loop].childNodes[0].nodeValue;;
				var mode            = XMLShippingMode[loop].childNodes[0].nodeValue;;
				var remarks         = XMLRemarks[loop].childNodes[0].nodeValue;;
				var modeID          = XMLShippingModeID[loop].childNodes[0].nodeValue;
				var isbase          = XMLisBase[loop].childNodes[0].nodeValue;
				var LeadTimeID      = XMLLeadTimeID[loop].childNodes[0].nodeValue;
				var LeadTime        = XMLLeadTime[loop].childNodes[0].nodeValue;
				var estimatedDate   = XMLEstimated[loop].childNodes[0].nodeValue;
				var ApprovalNo      = XMLApprovalNo[loop].childNodes[0].nodeValue;
				var LeadTime        = XMLLeadTime[loop].childNodes[0].nodeValue;
				var estimatedDate   = XMLEstimated[loop].childNodes[0].nodeValue;
				var ApprovalNo      = XMLApprovalNo[loop].childNodes[0].nodeValue;
				var bpo             = XMLintbpo[loop].childNodes[0].nodeValue;
				var handOverDate    = XMLhandOverDate[loop].childNodes[0].nodeValue;
				var refNo           = XMLrefNo[loop].childNodes[0].nodeValue;
				var Country         = XMLintCountry[loop].childNodes[0].nodeValue;
				var iDelivery       = XMLintDeliStatus[loop].childNodes[0].nodeValue;
				var dtCutOffDate    = XMLdtCutOffDate[loop].childNodes[0].nodeValue;
				
				var strDeliveryStatus = '';
				
				switch(iDelivery){
				
					case "1":
						strDeliveryStatus = "CONFIRMED";
					break;	
					
					case "2":
						strDeliveryStatus = "BLOCKED";
					break;
					
				}
				
				var tbl = document.getElementById('tblDelivery');
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;
				if (isbase == 'Y')
					row.className = "bcggreen";
				else
					row.className = "bcgwhite";
				var cellEdit = row.insertCell(0); 
				cellEdit.innerHTML = '';
				
				if(ApprovalNo<1)
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";
				if(ApprovalNo==1 && editDelScheduleAfterFirstRevision=='1')
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";
				if(editDelScheduleAfterRevision=='1')	
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this.id);\" align=\"center\"><img class=\"mouseover\" src=\"images/edit.png\" /></div>";	
					
				var cellDelete = row.insertCell(1);     
				//cellDelete.innerHTML = "<div id=\"" +  date + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
                                cellDelete.innerHTML = "<div id=\"" +  bpo + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"images/del.png\" /></div>";
				
				var cellDeliveryDate = row.insertCell(2);     
				cellDeliveryDate.className="normalfntMid";
				cellDeliveryDate.id = date;
				cellDeliveryDate.innerHTML = date;
				
				var cellQty = row.insertCell(3);     
				cellQty.className="normalfntRite";
				cellQty.innerHTML = qty;
				
				var cellExQty = row.insertCell(4);     
				cellExQty.className="normalfntRite";
				cellExQty.innerHTML = exqty;
				
				var cellMode = row.insertCell(5);     
				cellMode.className="normalfntMid";
				cellMode.id = modeID;
				if (mode == null || mode == "" )
					mode = " ";
				cellMode.innerHTML = mode;
				
				var cellRemarks = row.insertCell(6);     
				cellRemarks.className="normalfnt";
				if (remarks == null || remarks == "" )
					remarks = " ";
				cellRemarks.innerHTML = remarks;
				
				var cellbpo = row.insertCell(7);
				cellbpo.className="normalfntMid";
				cellbpo.id = bpo;
				cellbpo.innerHTML = bpo;
				
				var cellEstimated = row.insertCell(8);
				cellEstimated.className="normalfntMid";
				cellEstimated.innerHTML = estimatedDate;
				
				var cellhandOverDate = row.insertCell(9);
				cellhandOverDate.className="normalfntMid";
				cellhandOverDate.id = handOverDate;
				cellhandOverDate.innerHTML = handOverDate;
				
				var cellrefNo = row.insertCell(10);
				cellrefNo.className="normalfntMid";
				cellrefNo.id = Country;
				cellrefNo.innerHTML = refNo;
				
				var cellDeliStatus = row.insertCell(11);
				cellDeliStatus.className="normalfntMid";
				cellDeliStatus.id = iDelivery;
				cellDeliStatus.innerHTML = strDeliveryStatus;
				
				var cellCutOffDate = row.insertCell(12);
				cellCutOffDate.className="normalfntMid";
				cellCutOffDate.id = dtCutOffDate;
				cellCutOffDate.innerHTML = dtCutOffDate;
				
				
				deliveryIndex++ ;
			}
			
		}
	}
}

function UpdatePreOrder()
{
	var x_id = document.getElementById("txtStyleNo").value.trim();
	var x_name = document.getElementById("txtOrderNo").value.trim();
	
	var x_find = checkInField('orders','strOrderNo',x_name,'intStyleId',x_id);
	if(x_find)
	{
		alert("Sorry! Order No ( "+x_name+" ) already exists. Please try again.");	
		document.getElementById("txtOrderNo").select();
		return false;
	}
	
        if((arrEmbellishment.length == 0) && (IsEmbellishmentSet == 0)){
            alert(" Please select embellishment types required for style ");
            return false;
        }
        
	var SMVValue = parseFloat(document.getElementById('txtSMV').value);
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var upcharge = parseFloat(document.getElementById('txtUPCharge').value);
	//var CMRate = (CMValue + upcharge ) / SMVValue ;
	//document.getElementById('txtSMVRate').value = RoundNumbers(CMRate,4);
	if (ValidateInterfaceComponents())
	{
		if (IsValidSchedules())
		{
			approvalStatus =0;
			mainpagerequest = false;
			//ArrangeDtabase();
			SavePreOdrChanges();
		}
	}
}

function CopyOrder()
{
	if (ValidateCopyOrder())
	{
		//var SourceStyleNo = document.getElementById('txtStyleNo').value;
		var SourceStyleNo = document.getElementById('cboOrderNo').options[document.getElementById('cboOrderNo').selectedIndex].text;
		var NewStyleNo = document.getElementById('txtnew').value;
		var SourceStyleID = document.getElementById('cboOrderNo').value;
		var newStyleName = document.getElementById('txtNewStyleNo').value;
		var colorCode = $("#cboColor option:selected").text();
		if(colorCode != "Select One")
			NewStyleNo = NewStyleNo+'-'+colorCode;
		var orderColorCode = $("#cboColor").val();
		var buyerOrderNo = document.getElementById('txtnew').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleCopyOrder;
		xmlHttp.open("GET", 'preordermiddletire.php?RequestType=CopyOrder&StyleIDSource=' + URLEncode(SourceStyleNo) + '&StyleIDTarget=' + URLEncode(NewStyleNo) + '&userid=' + UserID+'&SourceStyleID='+SourceStyleID+ '&newStyleName='+URLEncode(newStyleName)+'&orderColorCode='+URLEncode(orderColorCode)+'&buyerOrderNo='+URLEncode(buyerOrderNo), true);
		xmlHttp.send(null); 
	}
}

function HandleCopyOrder()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLMessage = xmlHttp.responseXML.getElementsByTagName("Result");
			 var XMLTargetStyleId = xmlHttp.responseXML.getElementsByTagName("TargetStyleId");
			
			alert(XMLMessage[0].childNodes[0].nodeValue);			
			
			 if ( XMLMessage[0].childNodes[0].nodeValue == "New ID Already Exists")
			 	return;
			 var NewStyleNo = document.getElementById('txtnew').value;
			 location = "editpreorder.php?StyleNo=" + XMLTargetStyleId[0].childNodes[0].nodeValue;
		}
	}
}

function ValidateCopyOrder()
{
	if (document.getElementById('cboOrderNo').value == "Select One" || document.getElementById('cboOrderNo').value == "")
	{
		alert("Please select the 'Source Order No'.");	
		document.getElementById('cboOrderNo').focus();
		return false;
	}
	else if (document.getElementById('txtnew').value.trim() == "")
	{
		alert("Please enter the 'New Order No'.");	
		document.getElementById('txtnew').select();
		return false;
	}
	else if (document.getElementById('txtNewStyleNo').value.trim() == "")
	{
		alert("Please enter the 'New Style No'.");	
		document.getElementById('txtNewStyleNo').select();
		return false;
	}
	
	var orderNo =  document.getElementById('cboOrderNo').options[document.getElementById('cboOrderNo').selectedIndex].text;
	var newOrderNo =  document.getElementById('txtnew').value.trim();
	
	var color = $("#cboColor option:selected").text();
	var colorCode = $("#cboColor").val();
	var orderLen=parseInt(newOrderNo.length)
	if(color != "Select One" )
	{
		orderLen += parseInt(color.length)
		newOrderNo = newOrderNo+'-'+colorCode;
	}
	
	if(orderNo==newOrderNo)
	{
		alert("'Source Order No' must different from 'New Order No'");
		document.getElementById('txtnew').select();
		return false;
	}
	if(orderLen>=35)
	{
		alert("Exceed the maximum length of \"Order No\" with Color");	
		document.getElementById('txtnew').focus();
		return false;	
	}
return true;
}
function ShowPreOrderReport()
{
	var styleNO = document.getElementById('txtStyleNo').value;
	//window.location = reportName + "?styleID=" + URLEncode(styleNO);
	window.open(reportName+"?styleID=" + styleNO,'frm_main'); 
}

function CalculateCMAfterEditing()
{
	var currentFOB = document.getElementById('txtTargetFOB').value;
	
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	var esc =  parseFloat(document.getElementById('txtESC').value);;

	
	var CMValue = currentFOB - (pcmeterialCost + finance + esc);
	document.getElementById('txtCMValue').value = RoundNumbers(CMValue,4);
	
}

function SaveAndApprovalPreOrder()
{
	var x = getAllocatedQuantity();
	//if(buyerPOrequired && buyerPOQty == 0)
	if(buyerPOrequired && x == 0)
	{
		alert("Sorry! You can't proceed with \"Send to Approval\" without having Style Buyer PO's.");
		return false;
	}
	if (ValidateInterfaceComponents())
	{
		if (IsValidSchedules())
		{
			//================================================================================
			// Change On - 2015/09/03
			// Change By - Nalin Jayakody
			// Description - Approval status 10 change to 5 for active 'First Approval Stage'
			//================================================================================
			  //approvalStatus = 10;
			//================================================================================
			approvalStatus = 5;  
			mainpagerequest = true;
			sentToapprovalComments = "";
			//ArrangeDtabase();
			if(EnableSendToApprovalComments)
				PromptText("images/envilop.jpeg", "Send to approval comments", "Please leave your message to send with the approval requesting email.", "getsentToapprovalComments");
			else
				SavePreOdrChanges();
		}
	}
}

function validateApprovalPossibility()
{
	
	var tbl = document.getElementById('tblDelivery');
	var totalQty = 0;
	for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
  	{
  		//if (tbl.rows[loop].cells[3].lastChild.nodeValue == "" || tbl.rows[loop].cells[3].lastChild.nodeValue == null)
			//tbl.rows[loop].cells[3].lastChild.nodeValue = "1";
			
  		var qty = parseInt(tbl.rows[loop].cells[3].lastChild.nodeValue);
		totalQty +=  qty;
		

  	}	
	//alert('bpoqty = '+totalQty);
  	//return totalQty;
	//alert(totalQty);
	if (totalQty != 0 && totalQty != document.getElementById('txtQTY').value )
	{
		alert("Please arrange your buyer PO quantities according to the modified order quantity.");
		document.getElementById('txtQTY').focus();
		return false;
	}
	if (!delSchedulerequired)
	{
		SaveAndApprovalPreOrder();
		return ; 
	}
	var styleNO = document.getElementById('txtStyleNo').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = function()
	{
		 if(xmlHttp.readyState == 4) 
	    {
	        if(xmlHttp.status == 200) 
	        {
	        		var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Value");
					//alert(XMLStyle[0].childNodes[0].nodeValue);
					if (XMLStyle[0].childNodes[0].nodeValue.trim() == "True")
					{
						SaveAndApprovalPreOrder();
					}	   
					else
					{
						alert("You should allocate relevant delivery schedules for your buyer po's before approval.");
						return;
					}     
				}
			}	
	};
	
	xmlHttp.open("GET", 'preordermiddletire.php?RequestType=validateApprovalPossibility&StyleID=' + URLEncode(styleNO), true);
	xmlHttp.send(null); 
}

function PromptText(promptpicture, prompttitle, message, sendto)
{
	promptbox = document.createElement('div');
	promptbox.setAttribute ('id' , 'prompt');
	document.getElementsByTagName('body')[0].appendChild(promptbox);
	//promptbox = eval("document.getElementById('prompt').style");
	promptbox.style.position = 'absolute';
   promptbox.style.zIndex = 5;
   promptbox.style.left = 253 + 'px';
   promptbox.style.top = 450 + 'px'; 
	//promptbox.position = 'absolute';
	//promptbox.top = 100;
	//promptbox.left = 200;
	//promptbox.width = 300;
	promptbox.border = 'outset 1 #bbbbbb';
	document.getElementById('prompt').innerHTML = "<table cellspacing='0' cellpadding='0' border='0' width='100%'><tr valign='middle'><td width='22' height='22' style='text-indent:2;' class='titlebar'>&nbsp;<img src='" + promptpicture + "' height='18' width='18'></td><td class='titlebar'>&nbsp;" + prompttitle + "</td></tr></table>";
	document.getElementById('prompt').innerHTML += "<table cellspacing='0' cellpadding='0' border='0' width='100%' class='promptbox'><tr><td>&nbsp;<span class='normalfnt'>" + message + " &nbsp;&nbsp;</span></td></tr><tr><td><br>&nbsp;<textarea style='height:200px;width:395px;' id='promptbox' onblur='this.focus()' class='promptbox'></textarea></td></tr><tr><td align='right'><br><input type='button' class='prompt' value='OK' onMouseOver='this.style.border=\"1 outset #dddddd\"' onMouseOut='this.style.border=\"1 solid transparent\"' onClick='" + sendto + "(document.getElementById(\"promptbox\").value); document.getElementsByTagName(\"body\")[0].removeChild(document.getElementById(\"prompt\"))'> <input type='button' class='prompt' value='No Thanks' onMouseOver='this.style.border=\"1 outset transparent\"' onMouseOut='this.style.border=\"1 solid transparent\"' onClick='" + sendto + "(\"\"); document.getElementsByTagName(\"body\")[0].removeChild(document.getElementById(\"prompt\"))'> <input type='button' class='prompt' value='Cancel Sending Approval' onMouseOver='this.style.border=\"1 outset transparent\"' onMouseOut='this.style.border=\"1 solid transparent\"' onClick='document.getElementsByTagName(\"body\")[0].removeChild(document.getElementById(\"prompt\"))'></td></tr></table>";
	document.getElementById("promptbox").focus();
}

function getsentToapprovalComments(comment)
{
	sentToapprovalComments = comment;
	SavePreOdrChanges();
}

function ArrangeDtabase()
{
	ShowPreLoader();
	var styleNO = document.getElementById('txtStyleNo').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleDatabase;
	xmlHttp.open("GET", 'preordermiddletire.php?RequestType=DeleteOrder&StyleID=' + URLEncode(styleNO), true);
	xmlHttp.send(null); 
}

function HandleDatabase()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLStyle[0].childNodes[0].nodeValue == "True")
			{
				CalculateFigures();
				SavePreOrderSheet();
				SaveItems();
				SaveDeliveryDetails();
				GetAcknowledgement();
			}
			else
			{
				alert("Sorry! There is a problem while prepairing the database please try again..");
			}
		}		
	}
}

function LoadSavedPreOrderInformation()
{
	LoadSavedOrderDetails();
	
	//LoadSavedVariation();
		
	
}

function CalculateMatCost()
{
	var subQty = parseFloat(document.getElementById('txtSubContactQty').value);
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	//alert(Qty + ' - ' + subQty);
	if(subQty> Qty)
	{
		alert("You can't exceed sub transport qty than order qty.");	
		document.getElementById('txtSubContactQty').value = Qty;
		return;
	}
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
		var conpc = parseFloat(tbl.rows[loop].cells[3].lastChild.nodeValue)  ;
		var unitType = tbl.rows[loop].cells[4].lastChild.nodeValue ;
		var unitPrice = parseFloat(tbl.rows[loop].cells[5].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue)  ;
		var ReqQty = parseFloat(tbl.rows[loop].cells[7].lastChild.nodeValue) ;
		var totalQty = parseFloat(tbl.rows[loop].cells[8].lastChild.nodeValue) ;
		var price = parseFloat(tbl.rows[loop].cells[9].lastChild.nodeValue);
		var value = parseFloat(tbl.rows[loop].cells[10].lastChild.nodeValue);
		var originName = tbl.rows[loop].cells[11].lastChild.nodeValue  ;
		var freight = parseFloat(tbl.rows[loop].cells[12].lastChild.nodeValue) ;

		totalMaterialCost = totalMaterialCost+ (value);

		
		if (originName.charAt(originName.length-1) == "F" ||originName.charAt(originName.length-1)== "f" )
			totalfinancecost += parseFloat(price);
			
			//bookmark
		var transport = parseFloat(tbl.rows[loop].cells[18].lastChild.nodeValue);
		var clearing = parseFloat(tbl.rows[loop].cells[17].lastChild.nodeValue);
		var interest = parseFloat(tbl.rows[loop].cells[16].lastChild.nodeValue);
		var exports = parseFloat(tbl.rows[loop].cells[15].lastChild.nodeValue);
				
				financeT += transport + clearing+interest+exports;
	}
	
	var financeValue = totalfinancecost / Qty * finacePcnt /100;
	document.getElementById('txtMaterialCost').value = RoundNumbers(totalMaterialCost,4); 
	
	//document.getElementById('txtFinanceAmount').value = RoundNumbers(financeValue,4);//commented by roshan 2010-11-26
	
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

	//ChangeFOB();
	
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

function ShowStyleLoader()
{
	if (document.getElementById('txtStyleNo').value == null || document.getElementById('txtStyleNo').value == "")
	{
		alert("Please enter the style No.");	
		document.getElementById('txtStyleNo').focus();
		return ;
	}
	
	var styleNO = document.getElementById('txtStyleNo').value;
	var	popwindow= window.open ("styleUploader.php?styleNo=" + styleNO, "styleloader","location=1,status=1,scrollbars=1,width=450,height=160");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();
	
}
function trim(str) { 
    if (str != null) {
        var i; 
        for (i=0; i<str.length; i++) {
            if (str.charAt(i)!=" ") {
                str=str.substring(i,str.length); 
                break;
            } 
        } 
    
        for (i=str.length-1; i>=0; i--) {
            if (str.charAt(i)!=" ") {
                str=str.substring(0,i+1); 
                break;
            } 
        } 
        
        if (str.charAt(0)==" ") {
            return ""; 
        } else {
            return str; 
        }
    }
}

function LoadLeadTimes()
{
	var buyerID = document.getElementById('cboCustomer').value;
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

var delbpoedition = false;

function LoadPODelivery()
{
	delbpoedition = false;
	var styleNO = document.getElementById('txtStyleNo').value;
	createtFifthXMLHttpRequest();
	fifthxmlHttp.onreadystatechange = HandlePODelivery;
	fifthxmlHttp.open("GET", 'preorderBuyerPO.php?styleID=' + URLEncode(styleNO), true);
	fifthxmlHttp.send(null);
}

function LoadPODeliveryDate(date)
{
	delbpoedition = true;
	var styleNO = document.getElementById('txtStyleNo').value;
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
			//alert(fourthxmlHttp.responseText);	
			if(!delbpoedition)		
			automateDelScheduleBPO();
		}
	}
}

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// New Functions - New Version Modifications
function validateNewPreorderSave()
{
	var orderNo = document.getElementById('txtOrderNo').value.trim();
	var color = $("#cboColor option:selected").text();
	var orderLen=parseInt(orderNo.length)
	if(color != "Select One" )
		orderLen += parseInt(color.length);
	
	/*if(document.getElementById('cboManuFactory').value == '')
	{
		alert("Please select the \"Sewing Factory\".");
		document.getElementById('cboManuFactory').focus();
		return false;	
	}*/
	if (document.getElementById('txtStyleNo').value.trim() == null || document.getElementById('txtStyleNo').value.trim() == "")
	{
		alert("Please enter the \"Style No\".");
		document.getElementById('txtStyleNo').focus();
		document.getElementById('txtStyleNo').select();
		return false;
	}
	else if (document.getElementById('txtOrderNo').value.trim() == null || document.getElementById('txtOrderNo').value.trim() == "")
	{
		alert("Please enter the \"Order No\".");
		document.getElementById('txtOrderNo').focus();
		document.getElementById('txtOrderNo').select();
		
		return false;
	}
	else if (document.getElementById('txtStyleName').value.trim() == null || document.getElementById('txtStyleName').value.trim() == "")
	{
		alert("Please enter the \"Style Name\".");
		document.getElementById('txtStyleName').focus();
		document.getElementById('txtStyleName').select();
		return false;
	}
	else if (document.getElementById('cboCustomer').value == "Select One")
	{
		alert("Please select the \"Buyer\".");
		document.getElementById('cboCustomer').focus();
		return false;
	}
	else if (document.getElementById('dboDivision').value == "Null")
	{
		alert("Please select the \"Buyer Division\".");
		document.getElementById('dboDivision').focus();
		return false;
	}
	else if (document.getElementById('cboMerchandiser').value == "Select One")
	{
		alert("Please select the \"Merchandiser\".");
		document.getElementById('cboMerchandiser').focus();
		return false;
	}	
	else if (document.getElementById('cboFactory').value == 'Select One')
	{
		alert("Please select a \"Factory\".");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (document.getElementById('txtQTY').value <= '1')
	{
		alert("Please Enter \"Order Qty\".");
		document.getElementById('txtQTY').focus();
		return false;
	}
	/*else if (document.getElementById('txtOrderNo').value == null || document.getElementById('txtOrderNo').value == "")
	{
		alert("Please enter the Order No.");
		document.getElementById('txtOrderNo').focus();
		return false;
	}*/
	else if (document.getElementById('txtSMV').value == null || document.getElementById('txtSMV').value == "")
	{
		alert("Please enter the \"SMV Value\".");
		document.getElementById('txtSMV').focus();
		return false;
	}
	else if (document.getElementById('txtSMV').value <= 0)
	{
		alert("Please enter correct \"SMV Value\".");
		document.getElementById('txtSMV').focus();
		document.getElementById('txtSMV').select();
		return false;
	}
	else if (document.getElementById('txtQTY').value == null || document.getElementById('txtQTY').value == "")
	{
		alert("Please enter the \"Quantity\".");
		document.getElementById('txtQTY').focus();
		return false;
	}
	
	//else if (document.getElementById('txtNoLines').value == null || document.getElementById('txtNoLines').value == "")
//	{
//		alert("Please enter no of lines.");
//		document.getElementById('txtNoLines').focus();
//		return false;
//	}
//	else if (document.getElementById('txtNoLines').value <= 0)
//	{
//		alert("Please enter correct No Of Lines.");
//		document.getElementById('txtNoLines').focus();
//		return false;
//	}
	else if (document.getElementById('txtQTY').value <= 0)
	{
		alert("Please enter correct Quantity.");
		document.getElementById('txtQTY').select();
		return false;
	}
	else if(orderLen>=35)
	{
		alert("Exceed the maximum length of \"Order No\"");
		document.getElementById('txtOrderNo').focus();
		return false;
	}
	else
	{
		return true;	
	}
	return true;	
}
function SaveNewPreOrder()
{
	if (validateNewPreorderSave())
	{
		approvalStatus = 0;
		mainpagerequest = true;
		var styleNo = document.getElementById('txtStyleNo').value.trim();
		var orderNo = document.getElementById('txtOrderNo').value.trim();
		var colorCode = $("#cboColor option:selected").text();
		if(colorCode != "Select One")
			orderNo = orderNo+'-'+colorCode;
			
		/*alert(orderNo)
		return false;*/
		if (document.getElementById('txtRepeatNo').value.trim() != "" && document.getElementById('txtRepeatNo').value.trim() != null)
			styleNo = document.getElementById('txtStyleNo').value.trim() + '-' + document.getElementById('txtRepeatNo').value.trim();
		//createXMLHttpRequest();
		//xmlHttp.onreadystatechange = HandleNewStyleNO;
		//xmlHttp.open("GET", 'preordermiddletire.php?RequestType=IsExistingOrderNo&orderNo=' + URLEncode(orderNo), true);
		//xmlHttp.send(null); 
		 var url = 'preordermiddletire.php?RequestType=IsExistingOrderNo&orderNo=' + URLEncode(orderNo);
		 var xmlHttp     	=$.ajax({url:url,async:false});
		 var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Style");
			if (XMLStyle[0].childNodes[0].nodeValue == "False")
			{
				SaveNewPreOrderSheet();
			}
			else
			{
				var OrderNo = document.getElementById('txtOrderNo').value.trim();
				alert("Sorry! Order No ( "+OrderNo+" ) already exists. Please try again.");
				document.getElementById('txtOrderNo').focus();
				document.getElementById('txtOrderNo').select();
			}
	}
	else
	{
		return false;	
	}
}

function HandleNewStyleNO()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Style");
			if (XMLStyle[0].childNodes[0].nodeValue == "False")
			{
				SaveNewPreOrderSheet();
			}
			else
			{
				alert("Sorry! The style no already exists. Please try again.");
			}
		}		
	}
}


function SaveNewPreOrderSheet()
{
	//var StyleNo = URLEncode(document.getElementById('txtStyleNo').value);
	var StyleNo 	= document.getElementById('txtStyleNo').value.trim();
	if (document.getElementById('txtRepeatNo').value.trim() != "" && document.getElementById('txtRepeatNo').value.trim() != null)
		StyleNo 	= document.getElementById('txtStyleNo').value.trim() + '-' + document.getElementById('txtRepeatNo').value.trim();
	var RepeatNo 	= document.getElementById('txtRepeatNo').value.trim();
	var StyleName 	= document.getElementById('txtStyleName').value.trim();
	var BuyerID 	= document.getElementById('cboCustomer').value;
	var BuyingOfficeID = document.getElementById('cboBuyingOffice').value;
	var RefNo 		= document.getElementById('txtRefNo').value.trim();
	var MerchantID 	= document.getElementById('cboMerchandiser').value;
	var OrderNo 	= document.getElementById('txtOrderNo').value.trim();
	var colorCode 	= $("#cboColor option:selected").text();
		if(colorCode != "Select One")
			OrderNo = OrderNo+'-'+colorCode;
	var SMV 		= document.getElementById('txtSMV').value;
	var Qty 		= document.getElementById('txtQTY').value;
	var ExQty 		= document.getElementById('txtEXQTY').value;
	var DivisionID 	= document.getElementById('dboDivision').value;
	var SeasonID 	= document.getElementById('dboSeason').value;
	var EffLevel 	= document.getElementById('txtEffLevel').value;
	var NoOfLines 	= document.getElementById('txtNoLines').value;
	var FinanceP 	= 0;
	var FinanceA 	= 0;
	var MaterialCost = 0;
	var SMVRate 	= 0;
	var CMValue 	= 0;
	var TargetFOB 	= 0;
	var UpCharge 	= 0;
	var ESC 		= 0;
	var ScheduleMethod = document.getElementById('cboScheduleMethod').value;
	var facProfit 	= 0;
	var factoryID 	= document.getElementById('cboFactory').value;
	var color 		= $("#cboColor").val();
	var OrderType = document.getElementById('cboOrderType').value;
	var manufacCompany = document.getElementById('cboManuFactory').value;
	var buyerOrderNo = document.getElementById('txtOrderNo').value.trim();

	var facOHCostMin = document.getElementById('txtCostPerMinute').value;
	//createXMLHttpRequest();
   // xmlHttp.onreadystatechange = HandleSavingNewPreorderSheet;
    //xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SavePreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod+'&facProfit='+facProfit+'&color='+URLEncode(color)+ '&OrderType='+OrderType+'&manufacCompany='+manufacCompany+'&buyerOrderNo='+URLEncode(buyerOrderNo), true);    
    //xmlHttp.send(null);

    // ==========================================================================
    // Comment On - 02/25/2016
    // Comment By - Nalin Jayakody
    // Comment For - To save factory OH cost in to the order table
	 /* var url = 'preordermiddletire.php?RequestType=SavePreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod+'&facProfit='+facProfit+'&color='+URLEncode(color)+ '&OrderType='+OrderType+'&manufacCompany='+manufacCompany+'&buyerOrderNo='+URLEncode(buyerOrderNo); */
	// ==========================================================================

	var url = 'preordermiddletire.php?RequestType=SavePreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod+'&facProfit='+facProfit+'&color='+URLEncode(color)+ '&OrderType='+OrderType+'&manufacCompany='+manufacCompany+'&buyerOrderNo='+URLEncode(buyerOrderNo)+'&facOHCost='+facOHCostMin;
	 var xmlHttp     	=$.ajax({url:url,async:false});
	 	var XMLResult = xmlHttp.responseXML.getElementsByTagName("SaveState");	
			var StyleNo = document.getElementById('txtStyleNo').value.trim();
			if (document.getElementById('txtRepeatNo').value.trim() != "" && document.getElementById('txtRepeatNo').value.trim() != null)
				StyleNo = document.getElementById('txtStyleNo').value.trim() + '-' + document.getElementById('txtRepeatNo').value.trim();
			
			var XMLStyleId = xmlHttp.responseXML.getElementsByTagName("StyleId")[0].childNodes[0].nodeValue;
			
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
				location = "editpreorder.php?StyleNo=" + XMLStyleId;
}

function HandleSavingNewPreorderSheet()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  	
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("SaveState");	
			var StyleNo = document.getElementById('txtStyleNo').value;
			if (document.getElementById('txtRepeatNo').value != "" && document.getElementById('txtRepeatNo').value != null)
				StyleNo = document.getElementById('txtStyleNo').value + '-' + document.getElementById('txtRepeatNo').value;
			
			//var StyleNo = document.getElementById('txtStyleNo').value;
			
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
				location = "editpreorder.php?StyleNo=" + URLEncode(StyleNo);
		}
	}
}

function SaveItemInfo()
{
	
	// --------------------------------------
	if (!ValidateItemAddingForm()) return;
	if (!CalculateVariationWiseQtyPrice()) return;
	var StyleNo = document.getElementById('txtStyleNo').value ;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var itemid = document.getElementById('cboItems').value;
	var itemDescription = document.getElementById('cboItems').options[document.getElementById('cboItems').selectedIndex].text;
	var conpc = parseFloat(document.getElementById('txtconsumpc2').value);
	var unitType = document.getElementById('cboUnits').value;
	var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
	if(document.getElementById('txtwastage').value == "")
		document.getElementById('txtwastage').value = 0;
	var wastage = parseFloat(document.getElementById('txtwastage').value);
	var originID = document.getElementById('cboOrigine').value;
	var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
	var freight = parseFloat(document.getElementById('txtfreight').value);
	var ReqQty = RoundNumbers(parseFloat(document.getElementById('txtQTY').value) * conpc,4);
	var totalQty = 0;
	var exQty = document.getElementById('txtEXQTY').value;
        var IsWashable = 0;
	
	if ((document.getElementById('cboMaterial').value == "1"  || document.getElementById('cboMaterial').value == "Fabric" || document.getElementById('cboMaterial').value == "FABRIC")/* && FABRICExcessAllowed == false && FABRICWastageAllowed == false*/)
	{
		totalQty = ReqQty  ;
                
                var IsWashState = $("#chkWashable").prop('checked');
                if(IsWashState == true){IsWashable = 1;}
                    
	}
	else
	{
	 	totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100);
		// ======================================================
		// 10/19/2015
		// To prevent calculate raw material to excess qty
		// + parseFloat(ReqQty *  exQty / 100) ;
		// ====================================================== 
	}

	//var price = RoundNumbers(parseFloat(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	
	var price = 0;
	if (document.getElementById('cboMaterial').value == "1" )
	{
		// =======================================================		
		// Comment On - 11/04/2015
		// Comment By - Nalin Jayakody
		// Comment For - To add wastage calcualtion for fabric
		// =======================================================
		  /* price = RoundNumbers(parseFloat(conpc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4); */
		// =======================================================  
		price = RoundNumbers(parseFloat(parseFloat(conpc) + parseFloat(conpc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conpc) + parseFloat(conpc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}

	var value = RoundNumbers(parseInt(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	
	// ---------------------------------------
        
        


	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleNewItemStoring;
	xmlHttp.open("GET",'preordermiddletire.php?RequestType=SaveItems&ItemCode=' + itemid + '&ConPc=' + conpc + '&UnitPrice=' + unitPrice + '&wastage=' + wastage + '&origin=' + originID  + '&StyleNo=' + URLEncode(StyleNo)  + '&ReqQty=' + ReqQty  + '&totalQty=' + totalQty + '&value=' + value + '&price=' + price + '&OrderNo=' + URLEncode(OrderNo) + '&freight=' + freight  + '&unitType=' + URLEncode(unitType) + '&washable='+IsWashable, true);
	xmlHttp.send(null); 
	
	
	// ---------------------------------------------------
	


	
	
	// ---------------------------------------------------	
}
function SaveItemInfo_for_subTransport()
{
	//bookmark
		var qty  = document.getElementById("txtSubContactQty").value;	
		
		var url 	= "subPartDetailsXml.php?RequestType=gePara&qty="+qty;
		httpObj = $.ajax({url:url,async:false});
		var charge = httpObj.responseText;
	
	var StyleNo = document.getElementById('txtStyleNo').value ;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var price = parseFloat(qty) * parseFloat(charge);
	
	createXMLHttpRequest();
	
	xmlHttp.open("GET",'preordermiddletire.php?RequestType=SaveItems_for_subContract&ItemCode=20325&ConPc=1&UnitPrice=' + charge + '&wastage=0&origin=4&StyleNo=' + URLEncode(StyleNo)  + '&ReqQty=' + qty  + '&totalQty=' + qty + '&value=' + price + '&price=' + charge + '&OrderNo=' + URLEncode(OrderNo) + '&freight=0&unitType=JOB', true);
	xmlHttp.send(null); 
	
}


function HandleNewItemStoring()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("SaveState");	
			
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var tbl = document.getElementById('tblVariations');
				var StyleNo = document.getElementById('txtStyleNo').value;
				var itemid = document.getElementById('cboItems').value;
				for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
				{
					var rw = tbl.rows[loop];
					var conpc = rw.cells[1].lastChild.value;
					var unitprice = rw.cells[2].lastChild.value;
					var wastage = rw.cells[3].lastChild.value;
					var qty = rw.cells[4].lastChild.value;
					var color = rw.cells[5].lastChild.value;
					var size = rw.cells[6].lastChild.value;
					createThirdXMLHttpRequest();
					thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveVariations&ItemCode=' + itemid + '&StyleNo=' + URLEncode(StyleNo) + '&conpc=' + conpc + '&unitprice=' + unitprice + '&wastage=' + wastage + '&qty=' + qty + '&color=' + URLEncode(color) + '&IncID=' + loop + '&size=' + URLEncode(size) , true);
					thirdxmlHttp.send(null);
				}		
				AddNewDataToGrid();
			}
		}	
	}	
}

function AddNewDataToGrid()
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
			//alert(document.getElementById('cboMaterial').value);
			AddItem(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originID,document.getElementById('cboMaterial').value,0,0,0);
			//CollectVariations();
			CalculateFigures();
			RefreshAddingInterface();
		}
		else
		{
			alert("The item already exists. Please use item change option.");
			return;
		}
	
}

function LoadItemVariations(itemcode)
{
	var StyleNo = document.getElementById('txtStyleNo').value ;
	createtFifthXMLHttpRequest();
    fifthxmlHttp.onreadystatechange = HandleItemVariations;
    fifthxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getItemVariationData&styleID=' + URLEncode(StyleNo) + '&itemCode=' + itemcode, true);
    fifthxmlHttp.send(null);     
}


function HandleItemVariations()
{
    if(fifthxmlHttp.readyState == 4) 
    {
        if(fifthxmlHttp.status == 200) 
        {  
			 var XMLNo = fifthxmlHttp.responseXML.getElementsByTagName("intNo");
			 var XMLConpc = fifthxmlHttp.responseXML.getElementsByTagName("ConPc");
			 var XMLUnitPrice = fifthxmlHttp.responseXML.getElementsByTagName("UnitPrice");
			 var XMLWastage = fifthxmlHttp.responseXML.getElementsByTagName("Wastage");
			 var XMLColor = fifthxmlHttp.responseXML.getElementsByTagName("Color");
			 var XMLRemarks = fifthxmlHttp.responseXML.getElementsByTagName("Remark");
			 var XMLQty = fifthxmlHttp.responseXML.getElementsByTagName("qty");
			 var XMLSize = fifthxmlHttp.responseXML.getElementsByTagName("size");
			 for ( var loop = 0; loop < XMLNo.length; loop ++)
			 {
				document.getElementById("chkvariations").checked = true;
				var conpc =  XMLConpc[loop].childNodes[0].nodeValue;
				var unitprice =  XMLUnitPrice[loop].childNodes[0].nodeValue;
				var wastage =  XMLWastage[loop].childNodes[0].nodeValue;
				var qty =  XMLQty[loop].childNodes[0].nodeValue;
				var color =  XMLColor[loop].childNodes[0].nodeValue;
				var size =  XMLSize[loop].childNodes[0].nodeValue;
				AddVariationRowWithData(conpc,unitprice,wastage,qty,color,size);
			 }
			 
		}
		
	}
	
}

function UpdateItemInfo(locno,itemid,matCat,matMainCat)
{
	
	if (!CalculateVariationWiseQtyPrice()) return; //comment variation grid for orit
	// --------------------------------------
	//alert(locno);
	var tbl = document.getElementById('tblConsumption');	
	
	//2010-10-21---------------------------------------------------------------
	var pchQty = parseFloat(tbl.rows[locno].cells[13].lastChild.nodeValue);
	//alert(pchQty);
	var pchPrice = parseFloat(tbl.rows[locno].cells[14].lastChild.nodeValue);
	var pchQty = parseFloat(tbl.rows[locno].cells[13].lastChild.nodeValue);
	var pchPrice = parseFloat(tbl.rows[locno].cells[14].lastChild.nodeValue);
	//2010-10-21 ---------------------------------------------------------------
	
	var StyleNo = document.getElementById('txtStyleNo').value ;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var conpc = parseFloat(document.getElementById('txtconsumpc2').value);
	var unitType = document.getElementById('cboUnits').value;
	var unitPrice = parseFloat(document.getElementById('txtunitprice').value);
	var wastage = parseFloat(document.getElementById('txtwastage').value);
	var originID = document.getElementById('cboOrigine').value;
	var originName = document.getElementById('cboOrigine').options[document.getElementById('cboOrigine').selectedIndex].text;
	var freight = parseFloat(document.getElementById('txtfreight').value);
	var ReqQty = RoundNumbers(parseInt(document.getElementById('txtQTY').value) * conpc,4);
	var orderQty = document.getElementById('txtQTY').value;
	var ReqQty = calculateReqQty(orderQty,conpc); 
	var totalQty = 0;
	var exQty = document.getElementById('txtEXQTY').value;
	var mill = document.getElementById('cboMill').value;
	var mainFabric = (document.getElementById('chkMainFabric').checked ? 1:0);
	var mainCat = document.getElementById('cboMill').value;
	if ((matCat == '1' || matCat == 'F')  && wastage>0 && _1WastageAllowed == false)
	{
		alert("Fabric wastages not allowed in your company.");	
		document.getElementById('txtwastage').focus();
		return false;
	}
	//conpc should be graeter than 0
	if(conpc == '0' || conpc == '')
	{
		alert("Please enter the correct \"Consumption\".");
		document.getElementById('txtconsumpc2').focus();
		document.getElementById('txtconsumpc2').select();
		return false;
	}
	
	if(originID=="")
	{
		alert("Please select the \"Origin\".");
		document.getElementById('cboOrigine').focus();	
		return false;
	}
		
	/*if ((matCat == '1' || matCat == 'F') && FABRICExcessAllowed==false && FABRICWastageAllowed==false)
	{
		totalQty = parseFloat(ReqQty)  ;
	}
	else
	{
	 	totalQty = parseFloat(ReqQty) + parseFloat(ReqQty * wastage / 100) + parseFloat(ReqQty *  exQty / 100) ;
		
		//2010-10-19 calculate tatalQty
		totalQty = calculateTotalQty(orderQty,conpc,wastage,exQty);
	}*/
	totalQty = calculateTotalQty(orderQty,conpc,wastage,exQty,matMainCat);
	
	if (unitPrice < pchPrice)
	{
		alert("Sorry! You can't decrease the unit price more than purchased price.");	
		return;
	}
	
	if (totalQty < pchQty )
	{
		alert("Changes may not apply. The modified material quantity already purchased.");	
		return;
	}

	var value = RoundNumbers(parseFloat(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	var value = calculateCostValue(totalQty,unitPrice,freight);
	var price = 0;
	
	//Start 2010-08-04-----------commented for orit CostPC 
	if (matCat == 'F')
	{
		price = RoundNumbers(parseFloat(conpc) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);
	}
	else
	{
		price = RoundNumbers(parseFloat(parseFloat(conpc) + parseFloat(conpc) * parseFloat(wastage) / 100) * parseFloat(parseFloat(unitPrice) + parseFloat(freight)),4);		
	}
	//------------end--------------------
	// ---------------------------------------
        var IsToBeWashed = 0;
        
        if($("#chkToBeWash").is(":checked")){
            IsToBeWashed = 1;
        }
       
	var totOrderQty = parseFloat(document.getElementById('txtQTY').value*exQty/100) + parseFloat(document.getElementById('txtQTY').value);
			price = RoundNumbers(calCostPCwithExcess(orderQty,value),4);
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleItemUpdating;
	xmlHttp.itemID = itemid;
	xmlHttp.locno = locno;
	xmlHttp.matCat = matCat;
	xmlHttp.matMainCat = matMainCat;
	//xmlHttp.open("GET",'preordermiddletire.php?RequestType=UpdateItems&ItemCode=' + itemid + '&ConPc=' + conpc + '&UnitPrice=' + unitPrice + '&wastage=' + wastage + '&origin=' + originID  + '&StyleNo=' + URLEncode(StyleNo)  + '&ReqQty=' + ReqQty  + '&totalQty=' + totalQty + '&value=' + value + '&price=' + price + '&OrderNo=' + URLEncode(OrderNo) + '&freight=' + freight  + '&unitType=' + URLEncode(unitType) + '&mill=' +mill+ '&mainFabric=' +mainFabric, true);
	xmlHttp.open("GET",'preordermiddletire.php?RequestType=UpdateItems&ItemCode=' + itemid + '&ConPc=' + conpc + '&UnitPrice=' + unitPrice + '&wastage=' + wastage + '&origin=' + originID  + '&StyleNo=' + URLEncode(StyleNo)  + '&ReqQty=' + ReqQty  + '&totalQty=' + totalQty + '&value=' + value + '&price=' + price + '&OrderNo=' + URLEncode(OrderNo) + '&freight=' + freight  + '&unitType=' + URLEncode(unitType) + '&mill=' +mill+ '&mainFabric=' +mainFabric + "&iswashed="+IsToBeWashed, true);
	xmlHttp.send(null); 
	
	
	// ---------------------------------------------------
	


	
	
	// ---------------------------------------------------	
}
function calCostPCwithExcess(totQty,totVal)
{
	if(totQty == 0 && totVal==0)
	{
		var costPC = 0;	
	}
	else
	{
		var costPC = parseFloat(parseFloat(totVal)/totQty);	
		costPC = costPC.toFixed(5);		
	}
		
	return costPC;
}
function calculateReqQty(Qty,Conpc)
{
	ReqQty = (parseFloat(Qty)* parseFloat(Conpc)).toFixed(2);
	
	if(ReqQty <1)
		ReqQty =1;
	else 
		ReqQty = RoundNumbers(ReqQty,0);
		
	return ReqQty;
}
function calculateTotalQty(Qty,Conpc,wastage,exQty,mainCatID)
{
	var ReqQty = (parseFloat(Qty)* parseFloat(Conpc)).toFixed(4);
	
	exQty = getExpercentage(mainCatID,exQty);
	
	wastage = getWastagePercentage(mainCatID,wastage);

	var totalQty = parseFloat(ReqQty) + (parseFloat(ReqQty) * parseFloat(wastage) / 100);
	// ======================================================
	// 10/19/2015
	// To prevent calculation raw material for the excess qty
	// + (parseFloat(ReqQty) *  parseFloat(exQty) / 100) ;
	// ======================================================
	totalQty = Math.ceil(totalQty);
	return totalQty;
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

function calculateCostValue(totalQty,unitPrice,freight)
{
	var value = parseFloat(totalQty) * parseFloat(parseFloat(unitPrice) + parseFloat(freight));
	
	value = RoundNumbers(value,4);
	
	return value;
}
function HandleItemUpdating()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("SaveState");	
			
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var tbl = document.getElementById('tblVariations');
				var StyleNo = document.getElementById('txtStyleNo').value;
				var itemid = xmlHttp.itemID;
				for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
				{
					var rw = tbl.rows[loop];
					var conpc = rw.cells[1].lastChild.value;
					var unitprice = rw.cells[2].lastChild.value;
					var wastage = rw.cells[3].lastChild.value;
					var qty = rw.cells[4].lastChild.value;
					var color = rw.cells[5].lastChild.value;
					var size = rw.cells[6].lastChild.value;
					createThirdXMLHttpRequest();
					thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveVariations&ItemCode=' + itemid + '&StyleNo=' + URLEncode(StyleNo) + '&conpc=' + conpc + '&unitprice=' + unitprice + '&wastage=' + wastage + '&qty=' + qty + '&color=' + URLEncode(color) + '&IncID=' + loop + '&size=' + URLEncode(size) , true);
					thirdxmlHttp.send(null);
				}		
				
			}
			ModifyDatalist(xmlHttp.locno,xmlHttp.itemID,xmlHttp.matCat);
		}	
	}	
}

 // ---------------------------------------------------------------------------------
 
 
function  DeleteItemFromDatabase(itemid,rowIndex)
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var url ='preordermiddletire.php?RequestType=DeleteItemInfo&ItemCode=' + itemid + '&StyleNo=' + URLEncode(StyleNo);
	//xmlHttp.send(null); 
	var htmlobj=$.ajax({url:url,async:false});
	var XMLResult = htmlobj.responseXML.getElementsByTagName("DeleteStatus");	
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var tbl = document.getElementById('tblConsumption');
				var deleteRow = tbl.rows[rowIndex];
				deleteRow.parentNode.removeChild(deleteRow);
				CalculateFigures();
				//CalculatingTotFabricConPc();
			}
		
}


function HandleItemDeletion()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("DeleteStatus");	
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var tbl = document.getElementById('tblConsumption');
				var deleteRow = tbl.rows[xmlHttp.rowIndex];
				deleteRow.parentNode.removeChild(deleteRow);
				CalculateFigures();
			}
			
		}
		
	}
	
}

function SaveNewDeliverySchedule()
{
	if (ValidateSchedule() && ValidateBPOAllocation() )
	{
					
		var StyleNo = document.getElementById('txtStyleNo').value;
		var date = document.getElementById('deliverydate').value;
		/*if(date != "")
		{
			document.getElementById("handOverdate").value = date;
			document.getElementById("estimatedDate").value = date;
		}*/
			
		
		var qty = document.getElementById('quantity').value;
		var exqty = document.getElementById('excqty').value;
		var bpo = document.getElementById("txtBpo").value;
		var refNo = document.getElementById("refNo").value;
		/*var handoverDate = document.getElementById("handOverdate").value;
		var estimateddate = document.getElementById("estimatedDate").value;*/
		
		if($("#estimatedDate").val() == ""){
			$("#estimatedDate").val(date);
		}
		
		if($("#handOverdate").val() == ""){
			$("#handOverdate").val(date);
		}
		
		var handoverDate = $("#handOverdate").val();
		var estimateddate = $("#estimatedDate").val();
		//alert(estimateddate);
		var mode = "";
		if(document.getElementById('cboShippingMode').options.length > 0)
		mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
		var modeID 			=  document.getElementById('cboShippingMode').value;
		var remarks 		=  document.getElementById('remarks').value;
		var contry 			= document.getElementById('cboCountries').value;
		
		// =======================================================================
		// Description - Delivery status and add cut off date to the delivery schedule
		// Change On   - 2015/08/13
		// Change By   - Nalin Jayakody 
		// =======================================================================
		var deliveryStatus 	= parseInt(document.getElementById('cboDeliveryStatus').value);
		var dtCutOffDate	= document.getElementById('cutOffDate').value;
		
		if(deliveryStatus == -1){
			alert('Please select valid delivery status from list');
			return false;
		}
		
		if(deliveryStatus == 2){
			if(dtCutOffDate == ''){
				alert('Cut off date can not be empty, while delivery status is BLOCKED');
				return false;	
			}
		}
		// =======================================================================
		
		//estimate date hide for orit
		//var estimateddate =  document.getElementById('estimateddeliverydate').value;
		
		//var estimateddate = '00/00/0000';
		//var handoverDate = '00/00/0000';
		
		var LeadID = 0;
		//leadtime combo hide for orit
		/*if (document.getElementById('cboLeadTime').options.length > 0)
		{
			//var LeadTime = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text;
			var LeadID = document.getElementById('cboLeadTime').value;
		}*/
		
		var isbase= "N";
		/*if (document.getElementById('chkBase').checked)
			isbase= "Y";*/
			
		var manuLocationId = $("#cboManuFactory").val();	
			
		createAltXMLHttpRequest();
		altxmlHttp.onreadystatechange = HandleNewDelivery;
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID + '&estimateddate=' + estimateddate+ '&bpo=' + bpo + '&handoverDate=' + handoverDate + '&refNo=' + refNo+ '&contry=' + contry + '&deliStatus=' + deliveryStatus + '&cutOffDate=' + dtCutOffDate + '&manuLocationId=' + manuLocationId, true);
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
				saveBuyerPOAllocation();
				
				//closeWindow();
				
			}
		}		
	}
}

function ValidateBPOAllocation()
{
	/*var tbl = document.getElementById('tblBuyerPO');
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
	}*/
	
	return true;
}

function saveBuyerPOAllocation()
{
	var styleID = document.getElementById('txtStyleNo').value;
	var deliveryDate =document.getElementById('deliverydate').value;
	//var tbl = document.getElementById('tblBuyerPO');
	var isMainRatio = true;
	var isedition = 0;
	if(delbpoedition)
		isedition = 1;
	
	if(isMainRatio)
	{
		createAltXMLHttpRequest();
		altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveMainRatioEventSchedule&StyleNo=' + URLEncode(styleID) + '&ScheduleDate=' + deliveryDate , true);
		altxmlHttp.send(null); 
	}
	RefreshDeliveryForm();
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
			
		tbl.rows[rowNo].className = "bcgwhite";
		var approvalNo = tbl.rows[rowNo].cells[0].id;
	approvalNo++;
	
	if(editDelScheduleAfterRevision=='1')
		tbl.rows[rowNo].cells[0].childNodes[0].id = document.getElementById('deliverydate').value;
	else	
		tbl.rows[rowNo].cells[0].innerHTML = '&nbsp;';
		tbl.rows[rowNo].className = "bcgwhite";
	
	tbl.rows[rowNo].cells[0].childNodes[0].id = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].id =  document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].lastChild.nodeValue = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[3].lastChild.nodeValue = document.getElementById('quantity').value;
	tbl.rows[rowNo].cells[4].lastChild.nodeValue = document.getElementById('excqty').value;
	tbl.rows[rowNo].cells[5].lastChild.nodeValue = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	tbl.rows[rowNo].cells[6].lastChild.nodeValue = document.getElementById('remarks').value;	
	tbl.rows[rowNo].cells[5].id = document.getElementById('cboShippingMode').value;
	tbl.rows[rowNo].cells[7].id = document.getElementById('txtBpo').value;
	tbl.rows[rowNo].cells[8].id = document.getElementById('estimatedDate').value;
	tbl.rows[rowNo].cells[9].id = document.getElementById('handOverdate').value;
	tbl.rows[rowNo].cells[10].lastChild.nodeValue = document.getElementById('refNo').value;
	tbl.rows[rowNo].cells[10].id = document.getElementById('cboCountries').value;
	
	tbl.rows[rowNo].cells[11].lastChild.nodeValue = GetDeliveryStatus(document.getElementById('cboDeliveryStatus').value);
	tbl.rows[rowNo].cells[12].lastChild.nodeValue = document.getElementById('cutOffDate').value;
	var LeadTime = "";
	var LeadID = 0;
		
	var StyleNo = document.getElementById('txtStyleNo').value;
	var date = document.getElementById('deliverydate').value;
	var qty = document.getElementById('quantity').value;
	var exqty = document.getElementById('excqty').value;
	var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	var modeID =  document.getElementById('cboShippingMode').value;
	var remarks =  document.getElementById('remarks').value;
	var cboCount =  document.getElementById('cboCountries').value;
	
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
	
	// ------------------------------------------
	
	//closeWindow();
}

function saveDeliveryChanges(editedDate)
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var date = document.getElementById('deliverydate').value;
	if(date != "")
		{
			document.getElementById("handOverdate").value = date;
			document.getElementById("estimatedDate").value = date;
			//alert(document.getElementById("estimatedDate").value);
		}
	var qty = document.getElementById('quantity').value;
	var exqty = document.getElementById('excqty').value;
	var mode = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	var modeID =  document.getElementById('cboShippingMode').value;
	var remarks =  document.getElementById('remarks').value;
	var bpo =  document.getElementById('txtBpo').value;
	var estimateddate =  document.getElementById('estimatedDate').value;
	var handOverdate =  document.getElementById('handOverdate').value;
	var refNo =  document.getElementById('refNo').value;
	var cboCountries =  document.getElementById('cboCountries').value;
	
	var deliverystatus 	= document.getElementById('cboDeliveryStatus').value;
	var cutoffdate		= document.getElementById('cutOffDate').value;
	
	if(deliverystatus == '-1'){
		alert("Please select delivery status from list"); return false;
	}
	
	if(deliverystatus == '2'){
		if((cutoffdate=='') || (cutoffdate=='00/00/0000')){
			alert("If order status BLOCKED, need to select proper cutoff date");
			document.getElementById('cutOffDate').focus();
			return false;	
		}
	}
	
	if(deliverystatus == '1'){cutoffdate = '0000-00-00'}
	//alert(handOverdate);
	//var estimateddate = '00/00/0000';
	var LeadTime = 0;
	var isbase= "N";
	var LeadID = 0;
		//--------------------------------------
		
	var updateEventSchedule = "N";
	var iManuLocationId = $("#cboManuFactory").val();
	
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleChangeDelivery;
	altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=ChangeSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + URLEncode(remarks) + '&isbase=' + isbase + '&LeadID=' + LeadID + '&oldDate=' + editedDate + '&estimateddate=' + estimateddate+ '&bpo=' + bpo+ '&handOverdate=' + handOverdate+ '&refNo=' + refNo + '&updateEventSchedule=' + updateEventSchedule+ '&cboCountries=' + cboCountries + '&deliveryStatus='+ deliverystatus +'&cutoff='+cutoffdate+ '&locaId=' + iManuLocationId, true);
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

function DeleteDeliverySchedule(delDate)
{
	StyleNo = document.getElementById('txtStyleNo').value;
	createAltXMLHttpRequest();
	altxmlHttp.open("GET", 'preordermiddletire.php?RequestType=DeleteSchedule&StyleNo=' + URLEncode(StyleNo) + '&ScheduleDate=' + delDate , true);
	altxmlHttp.send(null);
}

function SavePreOdrChanges()
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var RepeatNo = document.getElementById('txtRepeatNo').value;
	var StyleName = document.getElementById('txtStyleName').value;
	var BuyerID = document.getElementById('cboCustomer').value;
	var BuyingOfficeID = document.getElementById('cboBuyingOffice').value;
	var RefNo = document.getElementById('txtRefNo').value;
	var MerchantID =document.getElementById('cboMerchandiser').value;
	var OrderNo = document.getElementById('txtOrderNo').value;
	var SMV = parseFloat(document.getElementById('txtSMV').value);
	var Qty = document.getElementById('txtQTY').value;
	var ExQty = document.getElementById('txtEXQTY').value;
	var DivisionID = document.getElementById('dboDivision').value;
	var SeasonID = document.getElementById('dboSeason').value;
	var EffLevel = parseFloat(document.getElementById('txtEffLevel').value);
	var NoOfLines = document.getElementById('txtNoLines').value;
	var FinanceP = document.getElementById('txtFinancePercentage').value;
	var FinanceA = document.getElementById('txtFinanceAmount').value;
	var MaterialCost = document.getElementById('txtMaterialCost').value;
	var SMVRate = document.getElementById('txtSMVRate').value;
	var CMValue = document.getElementById('txtCMValue').value;
	var TargetFOB = document.getElementById('txtTargetFOB').value;
	var UpCharge = document.getElementById('txtUPCharge').value;
	var UPChargeReason = document.getElementById('txtUPChargeReason').value;
	var margin = document.getElementById('txtMargin').value;
	var ESC = document.getElementById('txtESC').value;
	var ScheduleMethod = document.getElementById('cboScheduleMethod').value;
	var subcontractQty = document.getElementById('txtSubContactQty').value;
	var orderUnit = document.getElementById('cboOrderUnit').value;
	var proSubcat = document.getElementById('cboProductCategory').value;
	var labourCost = document.getElementById('txtLabourCost').value;
	var facProfit = document.getElementById('txtProfit').value;
	var factoryID = document.getElementById('cboFactory').value;
	var orderType = document.getElementById('cboOrderType').value;
	var mafactureCompanyID = document.getElementById('cboManuFactory').value;
        
        var PackSMV = parseFloat(document.getElementById('txtPackSMV').value);
	
	var totSMV = SMV + PackSMV;
        
        // ================================================
        // Add On - 05/09/2017
        // Add By - Nalin Jayakody
        // Add for - To add PCD / BCD date to the order based on select style level
        // ================================================
        var sStyleLevel = document.getElementById('cboStyleLevel').value;
        var dtPCD = document.getElementById('dtPCD').value;
        
        //===================================================
	//=======================================================================
	/* Calculation for checking if CM/UM below 0.0511 */
	
	var _dblTotalCM = GetTotalCM(Qty, CMValue); //Get total CM
	//var _dblProducedMin = GetProduceMin(Qty, SMV); //Get the produced min
	var _dblProducedMin = GetProduceMin(Qty, totSMV); //Get the produced min
	
	var _dblUM = GetUM(_dblProducedMin, EffLevel);
	//alert(_dblUM);
	var _dblCMPerUM = GetCMperUM(_dblTotalCM, _dblUM);
	
	if(_dblCMPerUM.toFixed(4) < 0.06){
		alert("Current CM/AM value is " + _dblCMPerUM.toFixed(4) + " less than the 0.06 for style " + OrderNo);	
	}
	
	/*if(_dblCMPerUM.toFixed(4) < 0.0511){
		alert("Current CM/UM value is " + _dblCMPerUM.toFixed(4) + " less than the 0.0511 for style " + OrderNo);	
	}*/
	//=================================================================
	//alert(labourCost);
	
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleUpdatePreorderSheet; // SavePreOrder
    //xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveModifiedPreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod + '&subcontractQty=' + subcontractQty + '&orderUnit=' + URLEncode(orderUnit) + '&proSubcat=' + proSubcat + '&labourCost=' + labourCost + '&margin=' + margin + '&comments=' + URLEncode(sentToapprovalComments) + '&UPChargeReason=' +URLEncode(UPChargeReason)+'&facProfit='+facProfit+ '&orderType='+orderType+'&mafactureCompanyID='+mafactureCompanyID, true);   
    //xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveModifiedPreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod + '&subcontractQty=' + subcontractQty + '&orderUnit=' + URLEncode(orderUnit) + '&proSubcat=' + proSubcat + '&labourCost=' + labourCost + '&margin=' + margin + '&comments=' + URLEncode(sentToapprovalComments) + '&UPChargeReason=' +URLEncode(UPChargeReason)+'&facProfit='+facProfit+ '&orderType='+orderType+'&mafactureCompanyID='+mafactureCompanyID+'&pSMV='+PackSMV, true);   
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=SaveModifiedPreOrder&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&MerchantID=' + MerchantID + '&OrderNo=' + URLEncode(OrderNo) + '&SMV=' + SMV + '&Qty=' + Qty + '&ExQty=' + ExQty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&EffLevel=' + EffLevel +  '&NoOfLines=' + NoOfLines + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus + '&ScheduleMethod=' + ScheduleMethod + '&subcontractQty=' + subcontractQty + '&orderUnit=' + URLEncode(orderUnit) + '&proSubcat=' + proSubcat + '&labourCost=' + labourCost + '&margin=' + margin + '&comments=' + URLEncode(sentToapprovalComments) + '&UPChargeReason=' +URLEncode(UPChargeReason)+'&facProfit='+facProfit+ '&orderType='+orderType+'&mafactureCompanyID='+mafactureCompanyID+'&pSMV='+PackSMV+'&stylelevel='+sStyleLevel+'&dtpcd='+dtPCD, true);   
    xmlHttp.send(null); 	
}

function HandleUpdatePreorderSheet()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			if (approvalStatus == 10)
			{
				alert("Pre Order Saved and sent for approval.");
				location = "editpreorder.php";
			}
			else
			{
				//saveSubTransportCharges();
				alert("Pre Order Saved Successfully.");
			}
		}		
	}
}

function reloadPreOrderStyle()
{
	var styleNo = document.getElementById('cboStyles').value;
	location = "editpreorder.php?StyleNo=" + URLEncode(styleNo);
}

function ScrollToElement(x,y)
{
 	window.scrollTo(x,y);
	document.getElementById("txtStyleNo").focus();
}

function rowclickColorChange()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblConsumption');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function showStyleBuyerPOForm()
{	
	var StyleNo = document.getElementById('txtStyleNo').value;
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
			document.getElementById('lblTotalQty').innerHTML = document.getElementById('txtQTY').value;
			//document.getElementById('txttotalqty').value = document.getElementById('txtQTY').value;
	
		}		
	}
}

function reloadPreOrderSR()
{
	var styleID = document.getElementById('cboSR').value;
	location = "editpreorder.php?StyleNo=" + URLEncode(styleID);
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').options[document.getElementById('cboSR').selectedIndex].text;
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
	document.getElementById('cboSR').value = "Select One";
	document.getElementById('cboSR').value = document.getElementById('cboStyles').value;
}

function changeEffLevel()
{
	var efflevel = parseFloat(document.getElementById('txtEffLevel').value)/ 100;
	var cpm = parseFloat(document.getElementById('txtCostPerMinute').value) ;
	var smv = parseFloat(document.getElementById('txtSMV').value);
	var packSMV = parseFloat(document.getElementById('txtPackSMV').value);
        var totSMV = smv + packSMV;
	var orderQty = parseInt(document.getElementById('txtQTY').value);
	var subcontractQty = parseInt(document.getElementById('txtSubContactQty').value);
	if (orderQty == subcontractQty)
		document.getElementById('txtLabourCost').value = 0;
	else
		//document.getElementById('txtLabourCost').value = RoundNumbers((smv / efflevel * cpm),4);
		document.getElementById('txtLabourCost').value = RoundNumbers((totSMV / efflevel * cpm),4);
	
}

function ReArrangeFigures()
{
	var currentFOB = parseFloat(document.getElementById('txtTargetFOB').value);
	
	
	var Qty = parseFloat(document.getElementById('txtQTY').value);
	var pcmeterialCost =  parseFloat(document.getElementById('txtMaterialCost').value) ;
	var finance =  parseFloat(document.getElementById('txtFinanceAmount').value);
	
	
	if (document.getElementById('chkFixed').checked)
	{
		var newFOB = document.getElementById('txtTargetFOB').value;
		var esc = newFOB * EscPercentage / 100;
		document.getElementById('txtESC').value = RoundNumbers(esc,4);
		CalculateCMRate();	
		var cm = newFOB - pcmeterialCost - esc - finance;
		document.getElementById('txtCMValue').value = RoundNumbers(cm,4);
	}
	else
	{
		var CMValue = parseFloat(document.getElementById('txtCMValue').value);
		var curFOB = CMValue + pcmeterialCost + finance;
		//var newFOB = document.getElementById('txtTargetFOB').value;
		var esc = curFOB * EscPercentage / 100;
		document.getElementById('txtESC').value = RoundNumbers(esc,4);
		CalculateCMRate();	
		document.getElementById('txtTargetFOB').value = RoundNumbers(curFOB + esc ,4);
	}	
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var SMVValue = parseFloat(document.getElementById('txtSMV').value);
	document.getElementById('txtSMVRate').value = RoundNumbers(CMValue/SMVValue,4);
}

function IsValidSchedules()
{
	var allocatedQty = getAllocatedQuantity();
	var allocatedExcessQty= getAllocatedExcessQuantity();
	var ExQtyPC = parseInt(document.getElementById('txtEXQTY').value);
	var odrQty =  parseInt(document.getElementById('txtQTY').value);
	var maxEXQty = parseInt(odrQty + (odrQty *  ExQtyPC / 100));
	
	var SMVValue = parseFloat(document.getElementById('txtSMV').value);
	var CMValue = parseFloat(document.getElementById('txtCMValue').value);
	var upcharge = parseFloat(document.getElementById('txtUPCharge').value);
	var CMRate = (CMValue + upcharge ) / SMVValue ;

	if(CMRate<=0){//hem
		if(confirm('SMV Rate is '+CMRate+' . Do you want to continue?'))
		{
		   return true;	
		}
		else{
		    return false
		}
		//alert("Invalid SMV Rate.");//commented on 26/10/2011 as Nalin request
		//return false;
	}
	if (odrQty < allocatedQty)
	{
		alert("Your delivery schedule quantities not match with the new order quantity. Please do neccessary adjustments.");
		return false;
	}
	
	// ===================================================================
	
	/*if (maxEXQty < allocatedExcessQty)
	{
		alert("Your delivery schedule excess quantities not match with the new order excess quantity. Please do neccessary adjustments.");
		return false;
	}*/
	return true;
}

function automateDelScheduleBPO()
{
	var tbl = document.getElementById('tblBuyerPO');
	if (tbl == null) return;
	var ExQtyPC = parseInt(document.getElementById('txtEXQTY').value);
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

function HideLoadingImage()
{
	document.getElementById('lyrLoading').style.display = 'none';
}

function ShowLoadingImage()
{
	document.getElementById('lyrLoading').style.display = '';
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

var currentModifyRowIndex = null;
var previousConPc = null;
var previousUnitPrice = null;

function changeToStyleTextBox()
{
	
	var obj = this;
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	var  currentTxt = obj.innerHTML;
	previousConPc = parseFloat(currentTxt);
	previousUnitPrice = parseFloat(currentTxt);
	//var newdiv = document.createElement('div');
	//newdiv.innerHTML = "<input type=\"text\" value =\""+ currentTxt + "\">";
	obj.innerHTML = "<input type=\"text\" onkeydown=\"isEnterKey(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, consumptionDecimalLength,event);\"  class=\"txtbox\" value =\""+ currentTxt + "\" onblur=\"changeToCells(this);\" size=\"9\" >";
	obj.childNodes[0].focus();
}

function changeToCells(obj)
{
	if(obj.parentNode.cellIndex == 3)
	{
		var tbl = document.getElementById('tblConsumption');			 
		var currentTotal = parseFloat(tbl.rows[obj.parentNode.parentNode.rowIndex].cells[8].lastChild.nodeValue);
		var purchasedQty = parseFloat(tbl.rows[obj.parentNode.parentNode.rowIndex].cells[13].lastChild.nodeValue);
		var newTotalwillbe = currentTotal / previousConPc * parseFloat(obj.value);
		if (newTotalwillbe < purchasedQty)
		{
			alert("Sorry! The item already purchased. Please enter a value which generate more than purchased quantity.");
			obj.value = previousConPc;
			obj.parentNode.innerHTML = previousConPc;	
			document.getElementById('txtNoLines').focus();
			return ;
		}
	}
	if(obj.parentNode.cellIndex == 5)
	{
		var tbl = document.getElementById('tblConsumption');			 
		var purchasedPrice = parseFloat(tbl.rows[obj.parentNode.parentNode.rowIndex].cells[14].lastChild.nodeValue);
		if (purchasedPrice > parseFloat(obj.value))
		{
			alert("Sorry! The item already purchased. Please enter a value which generate more than purchased quantity.");
			obj.value = previousUnitPrice;
			obj.parentNode.innerHTML = previousConPc;	
			document.getElementById('txtNoLines').focus();
			return ;
		}
	}
	
	ShowLoadingImage();
	updateCellChanges(obj.parentNode.parentNode.rowIndex);
	obj.parentNode.innerHTML = obj.value;			
}

function updateCellChanges(rowIndex)
{
	currentModifyRowIndex = rowIndex;
	var tbl = document.getElementById('tblConsumption');
	var styleID = document.getElementById('txtStyleNo').value;
	var itemCode = tbl.rows[rowIndex].cells[0].id;
	var conpc = tbl.rows[rowIndex].cells[3].lastChild.nodeValue;
	if (conpc== null)
		conpc = tbl.rows[rowIndex].cells[3].lastChild.value;
	var unitprice = tbl.rows[rowIndex].cells[5].lastChild.nodeValue;
	if (unitprice== null)
		unitprice = tbl.rows[rowIndex].cells[5].lastChild.value;
	var orderQty = document.getElementById('txtQTY').value;
	// ===========================================================
	// Comment On - 2016/03/09
	// Comment By - Nalin Jayakody
	// Comment For - Remove excess percentage calculation from when change value in a cell
	// ===========================================================
	// # var excessPercentage = document.getElementById('txtEXQTY').value;
	// ===========================================================
	var excessPercentage = 0;
	updateDatabaseValues(styleID,itemCode,conpc,unitprice,orderQty,excessPercentage);
}

function updateDatabaseValues(styleID,itemCode,conpc,unitprice,orderQty,excessPercentage)
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleCellChanges;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=updateCellChanges&styleID=' + URLEncode(styleID) + '&itemCode=' + itemCode + '&conpc=' + conpc + '&unitprice=' + unitprice + '&orderQty=' + orderQty + '&excessPercentage=' + excessPercentage , true);
    xmlHttp.send(null); 
}

function HandleCellChanges()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLReqQty = xmlHttp.responseXML.getElementsByTagName("ReqQty");
			 var XMLTotalQty = xmlHttp.responseXML.getElementsByTagName("TotalQty");
			 var XMLTotalValue = xmlHttp.responseXML.getElementsByTagName("TotalValue");
			 var XMLCostPC = xmlHttp.responseXML.getElementsByTagName("CostPC");
			 
			 var ReqQty = XMLReqQty[0].childNodes[0].nodeValue;
			 var TotalQty = XMLTotalQty[0].childNodes[0].nodeValue;
			 var TotalValue = XMLTotalValue[0].childNodes[0].nodeValue;
			 var CostPC = XMLCostPC[0].childNodes[0].nodeValue;
			 
			 var tbl = document.getElementById('tblConsumption');
			 tbl.rows[currentModifyRowIndex].cells[7].lastChild.nodeValue = RoundNumbers(ReqQty,0);
			 tbl.rows[currentModifyRowIndex].cells[8].lastChild.nodeValue = RoundNumbers(TotalQty,0);
			 tbl.rows[currentModifyRowIndex].cells[9].lastChild.nodeValue = RoundNumbers(TotalValue,2);
			 tbl.rows[currentModifyRowIndex].cells[10].lastChild.nodeValue = RoundNumbers(CostPC,4);
			 HideLoadingImage();
		}
	}
}

function isEnterKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
		 document.getElementById('txtNoLines').focus();
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

// --------------------------------------------------

function showBPODeliveryForm()
{	
	var StyleNo = document.getElementById('txtStyleNo').value;
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
		var leadName = " ";
		if (document.getElementById('cboLeadTime').value != null && document.getElementById('cboLeadTime').value != "")
			leadName = document.getElementById('cboLeadTime').options[document.getElementById('cboLeadTime').selectedIndex].text ;
		var deliveryDate = document.getElementById('deliverydateDD').value;
		var handOverDate = document.getElementById('dtmHandOverDate').value;
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
					   "<td class=\"normalfnt\" NOWRAP>"+refNo+"</td>"+
						"<td class=\"normalfnt\" NOWRAP>"+handOverDate+"</td>";//bookmark
		document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
	}
}

function displayAllocatedTotal()
{
	document.getElementById('txttotalqty').value = getAllocatedBuyerPOTotal();
}


function ValidateBPOSaving()
{
	var orderQty = document.getElementById("lblTotalQty").innerHTML;
	orderQty = parseFloat(orderQty);
	var totQty = document.getElementById("txttotalqty").value;
	totQty = parseFloat(totQty);
	if(orderQty==totQty)
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
		alert(allocatedQuantity);
		buyerPOQty = allocatedQuantity;
		
		if(allocatedQuantity > approvedQuantity)
		{
			alert("Sorry! You can't continue with given buyer PO details. You are exceeding the order quantity.");
			return false;
		}
	
		return true;
	}
	else
	{
	alert("Sorry! You can't complete process, Order Qty doesn't match with Total Qty");
	var tbl = document.getElementById('BuyerPO');
	document.getElementById("BuyerPO").deleteRow(tbl.rows.length-1);
	}
	//return false;
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
	//alert('bpoqty = '+totalQty);
  	return totalQty;
	//alert(totalQty);
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

var xmlHttpreq = [];

function saveDelBPO()
{
	var StyleNo = document.getElementById('txtStyleNo').value;
	var tbl = document.getElementById('BuyerPO');
	
	
	if (tbl.rows.length <= 1)
	{
		if(!confirm("No buyer PO available. This may cause to delete all delivery schedules and buyer PO allocations. Do you want to continue ?"))
			return ;
	}
	if(ValidateBPOSaving())
	{
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = function()
	   {
		if(this.readyState == 4)
		{	
       	if(this.status == 200) 
       	{ 
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
						var handOverDate = tbl.rows[loop].cells[10].textContent;
						
						createNewXMLHttpRequest(loop);
					  	xmlHttpreq[loop].index = loop;
						xmlHttpreq[loop].onreadystatechange = function()
						{
							if(this.readyState == 4)
							{	
					 			if(this.status == 200) 
					 			{ 
					 				
										responseCount ++;
									if (requestCount == responseCount )
									{
										//alert("Buyer PO allocation completed.");
										
										createXMLHttpRequest();
										xmlHttp.onreadystatechange = function()
									   {
											if(this.readyState == 4)
											{	
									       	if(this.status == 200) 
									       	{ 
									       		alert("Buyer PO allocation completed.");
												//LoadSavedSchedules();
									       	}
									       }
									    }
									    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=updateDeliveryDetails&styleID=' + URLEncode(StyleNo) , true);
   									 xmlHttp.send(null);
										//hidePleaseWait();
									}
								}			
							}
					
						};	
						xmlHttpreq[loop].open("GET", 'preordermiddletire.php?RequestType=AddDeliveryBPO&styleID=' + URLEncode(StyleNo) + '&buyerPO=' + URLEncode(buyerPO) + '&bpoQty=' + bpoQty + '&bpoLeadTime=' + bpoLeadTime + '&bpoDelivery=' + bpoDelivery + '&bpoEstimate=' + bpoEstimate + '&bpoShipMode=' + bpoShipMode + '&bpoRemarks=' + URLEncode(bpoRemarks) + '&bpoCountry=' + URLEncode(bpoCountry) + '&bpoRefNo=' +bpoRefNo+'&handOverDate='+handOverDate, true);
						xmlHttpreq[loop].send(null);
					}
							
			}
		}
		
	};
		xmlHttp.open("GET", 'preordermiddletire.php?RequestType=removeDelivery&styleID=' + URLEncode(StyleNo) , true);
   	xmlHttp.send(null);	
	}
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
	document.getElementById('dtmHandOverDate').value = tr.cells[10].textContent;
	
	tr.parentNode.removeChild(tr);
	document.getElementById('txttotalqty').value = getCalculateTotal();
}

function reloadDeliverySchedue()
{
	RemoveAllBPODeliveries();
	LoadSavedSchedules();
}

function RemoveAllBPODeliveries()
{

	var tbl = document.getElementById('tblDelivery');
	for ( var loop = tbl.rows.length-1 ;loop > 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}
		
}

function getItemUnitprice(itemid)
{
    var url = "preordermiddletire.php?RequestType=getItemUnitprice&itemCode="+itemid;	
    var htmlobj=$.ajax({url:url,async:false});
    var itemprice = htmlobj.responseXML.getElementsByTagName('itemUnitprice')[0].childNodes[0].nodeValue;

    return itemprice;
}

function getItemWashableStatus(itemid, styleId){
    
    var url = "preordermiddletire.php?RequestType=getItemWashStatus&itemCode="+itemid+"&styleId="+styleId;
    var htmlobj = $.ajax({url:url,async:false});
    //alert(htmlobj.responseText)
    var tobeWashed = htmlobj.responseXML.getElementsByTagName('washStatus')[0].childNodes[0].nodeValue;
    
    return tobeWashed;
    
}
function LoadMill()
{
	//createtFourthXMLHttpRequest();
    //fourthxmlHttp.onreadystatechange = HandleMill;
    var url = 'preordermiddletire.php?RequestType=LoadMill';
	
	//alert(url.responseText);
    //fourthxmlHttp.send(null);
	var fourthxmlHttp = $.ajax({url:url,async:false});
	document.getElementById("cboMill").innerHTML = fourthxmlHttp.responseText;
			document.getElementById("cboMill").value = pub_mill; 
}
function validateUnitprice()
{
	var itemPrice = parseFloat(document.getElementById('itemPrice').title);	
	var unitprice = parseFloat(document.getElementById('txtunitprice').value);	
	
	if(!canIncreaseItemUnitprice)
	{
		if(unitprice>itemPrice)
		{
			//alert("Sorry you do not have permission to increase item unitprice ");
			//document.getElementById('txtunitprice').value = document.getElementById('itemPrice').title;
			//return false;
		}
	}
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
function GetStyleNoWiseScNo(obj)
{
	var stytleName = obj.value;
	if(stytleName != 'Select One')
	{
	var url="preordermiddletire.php";
					url=url+"?RequestType=GetStyleNoWiseScNo";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var XMLScNo = htmlobj.responseXML.getElementsByTagName("ScNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  XMLScNo;
	}
	else
	{
		location = "editpreorder.php?";
		}
				
}
function getOrderNo()
{
	var stytleName = document.getElementById('cboStyles').value;
	if(stytleName != 'Select One')
	{
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNo";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	}
	else
	{
		location = "editpreorder.php?";
		}
				
}
function reloadPreOrderOrderNo()
{
	var styleID = document.getElementById('cboOrderNo').value;
	var StyleName = document.getElementById('cboStyles').value;
	//alert(styleID + ' ' + StyleName);
	if(StyleName != "Select One" || styleID != "Select One")
		location = "editpreorder.php?StyleNo=" + URLEncode(styleID)+"&StyleName="+StyleName;
		else
			location = "editpreorder.php?";
}
function Autotype()
{
	
	
	var StyleNo=document.getElementById('txtStyleNo').value;
	document.getElementById('txtOrderNo').value=StyleNo;
	
	//var StyleNo=document.getElementById('txtStyleNo').value=OrderNo;
}
function GetOrderNoBySC(obj)
{
	document.getElementById("cboOrderNo").value = obj;
}

function GetTotalCM(prmTotalQty, prmCMValue){
		
	var _dblTotalCM = 0;
	
	_dblTotalCM = parseFloat(prmTotalQty) * parseFloat(prmCMValue);
	
	return _dblTotalCM;
		
}

function GetProduceMin(prmTotalQty, prmSMV){
	
	var _dblProdMin = 	parseFloat(prmTotalQty) * parseFloat(prmSMV);
	
	return _dblProdMin;
}

function GetUM(prmProducedMin, prmEff){
	
	var _dblUM = parseFloat(prmProducedMin)/parseFloat(prmEff);
	
	return _dblUM;
	
}

function GetCMperUM(prmTotalCM, prmUM){
	
	var _dblCMUM = (prmTotalCM/prmUM)/100;
	
	return _dblCMUM;
}

function GetDeliveryStatus(prmDeliveryStatus){
	
	var _strDeliveryStatus = '';
	
	switch(prmDeliveryStatus){
		
		case "1":
			_strDeliveryStatus = "CONFIREMD";
		break;
		
		case "2":
			_strDeliveryStatus = "BLOCKED";
		break;	
		
	}
	
	return _strDeliveryStatus;
}

function uploadBuyerPO(StyleNo,Qty)
{
	var url = 'BPODelivery.php?styleID=' + URLEncode(StyleNo) + '&Qty=' +Qty;
	//alert(url);
	var	popwindow= window.open ("BuyerPO/uploader_buyerPO.php?No=" + StyleNo + "&Qty=" + Qty , "Buyer PO Uploader","location=1,status=1,scrollbars=1,width=450,height=200");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
}

function popUpEmb(){
    
    var styleId = $("#txtStyleNo").val();
    
    var url = "embtype.php?styleid="+styleId;
    var xmlHttp =  $.ajax({url:url, async:false});
    drawPopupArea(445,384,'frmEmbTypes');
    
    var htmlText = xmlHttp.responseText;
    document.getElementById('frmEmbTypes').innerHTML = htmlText;
    
}

function setEmbOther(){
    
    var chkOther = Boolean($("#chkOther").prop('checked'));
    
    if(chkOther) {       
        $("#txtOther").css('visibility', 'visible');
        $("#txtOther").focus();
    }   
    else
        $("#txtOther").css('visibility', 'hidden');
}

function SaveEmb(){
    
    //alert(arrEmbellishment.length);
    var i = 0;
    var styleId = $("#txtStyleNo").val();
    
    var isPrint     = 0;
    var isEmb       = 0;
    var isHeatSeal  = 0;
    var isHandWork  = 0;
    var isOther     = 0;
    var isNA        = 0;
    var strOtherType = '';
    
    // ========================
    // 04/28/2017
    // Add By - Nalin Jayakody
    // Adding - Add new embellishment types
    // =================================
    var isCPL       = 0;
    var isPreSew    = 0;
    var isPressing  = 0;
    var isBNP       = 0;
    var isHTP       = 0;
    var isSA        = 0;
    var isDA        = 0;
    var isSmoking   = 0;
    var isPleating  = 0;
    var isWash      = 0;
    // =================================
    
    $("#tbEmbType tr").each(function(){
       
        //var row = $(this);
        
        $(this).find('td').each(function(){
            
            var col = $(this);
            
            if(col.find('input[type="checkbox"]').is(':checked')){
            var chkBoxId = col.find('input[type="checkbox"]').attr('id');
            //alert(chkBoxId);
            switch(chkBoxId){
                
                case "chkPrint":
                    isPrint = 1;
                    arrEmbellishment[i] = isPrint;
                break;
                
                case "chkEmb":
                    isEmb = 1;
                    arrEmbellishment[i] = isEmb;
                break;
                
                case "chkHeatSeal":
                    isHeatSeal = 1;
                    arrEmbellishment[i] = isHeatSeal;
                break;
                
                case "chkHW":
                    isHandWork = 1;
                    arrEmbellishment[i] = isHandWork;
                break;
                
                case "chkOther":
                
                    if($("#txtOther").val() == ""){
                        alert("Please specify type embellishment");
                        return;
                    }
                    strOtherType = $("#txtOther").val();
                    isOther = 1;
                    arrEmbellishment[i] = isOther;
                break;
                
                case "chkNA":
                    isNA = 1;
                    arrEmbellishment[i] = isNA;
                break;
                
                case "chkCPL":
                    isCPL = 1;
                    arrEmbellishment[i] = isCPL;
                break;
                
                case "chkPreSew":
                    isPreSew = 1;
                    arrEmbellishment[i] = isPreSew;
                break;
                
                case "chkPressing":
                    isPressing = 1;
                    arrEmbellishment[i] = isPressing;
                break;
                
                case "chkBNP":
                    isBNP = 1;
                    arrEmbellishment[i] = isBNP;
                break;
                
                case "chkHTP":
                    isHTP = 1;
                    arrEmbellishment[i] = isHTP;
                break;
                
                case "chkSEQ":
                    isSA = 1;
                    arrEmbellishment[i] = isSA;
                break;
                
                case "chkDA":
                    isDA = 1;
                    arrEmbellishment[i] = isDA;
                break;
                
                case "chkSmoking":
                    isSmoking = 1;
                    arrEmbellishment[i] = isSmoking;
                break;
                
                case "chkPleating":
                    isPleating = 1;
                    arrEmbellishment[i] = isPleating;
                break;
                
                case "chkWash":
                    isWash = 1;
                    arrEmbellishment[i] = isWash;
                break;
                
            }
            
            i++;
        }
            
        });
        
        
        
        
    });
    
    var url="preordermiddletire.php";
	url+="?RequestType=SetEMB";
	url+='&styleid='+styleId+'&print='+isPrint+'&emb='+isEmb+'&hs='+isHeatSeal+'&hw='+isHandWork+'&iother='+isOther+'&other='+URLEncode(strOtherType)+'&na='+isNA+'&cpl='+isCPL+'&ps='+isPreSew+'&pressing='+isPressing+'&bnp='+isBNP+'&htp='+isHTP+'&sa='+isSA+'&da='+isDA+'&smoking='+isSmoking+'&pleating='+isPleating+'&wash='+isWash;
	//url+='&styleid='+styleId+'&print='+isPrint+'&emb='+isEmb+'&hs='+isHeatSeal+'&hw='+isHandWork+'&iother='+isOther+'&other='+URLEncode(strOtherType)+'&na='+isNA;
    
    var htmlObj = $.ajax({url:url, async:false});
    closeWindow();
    
}