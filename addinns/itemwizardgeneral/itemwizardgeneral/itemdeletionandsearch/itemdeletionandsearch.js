var xmlHttp				= [];
//var xmlHttp;
var altxmlHttp;
var count=0;
var xmlHttpreq = [];
var id="";
var rowId="";
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

/*
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
*/
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

function submitForm(){
	document.frmcomplete.submit();
}

function createXMLHttpRequest1(index){
	
	
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function LoadSubCategory(obj){
	
	document.getElementById('cboSubCategory').innerHTML="";
	createXMLHttpRequest1(1);
	xmlHttp[1].onreadystatechange=LoadSubCategoryRequest;
	xmlHttp[1].open("GET", 'itemdeletionandsearchmiddle.php?RequestType=LoadSubCategory&mainCategoryId=' + obj , true);
	xmlHttp[1].send(null);
}
	function LoadSubCategoryRequest() 
	{ 
		if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200){
			
			document.getElementById('cboSubCategory').innerHTML	= xmlHttp[1].responseText;
			
		}		
	}

function RemoveItem(obj){
	var rw = obj.parentNode.parentNode;
	if(confirm('Are you sure you want to remove item : ?'+rw.cells[0].childNodes[0].nodeValue))
	{
		

		var td = obj.parentNode;
		var tro = td.parentNode;
		//var tt=tro.parentNode;		
		tro.parentNode.removeChild(tro);
		var detailId	= tro.cells[0].id;
		//DeleteRow(detailId);
		Validate(detailId);
	}
}

function ValidateDelete(obj){
	var rw = obj.parentNode.parentNode;
	var detailId	= rw.cells[0].id;
	createXMLHttpRequest1(2);
	xmlHttp[2].index = detailId;
	xmlHttp[2].onreadystatechange=ValidateDeleteRequest;
	xmlHttp[2].open("GET", 'itemdeletionandsearchmiddle.php?RequestType=Validate&matDetailId=' + detailId , true);
	xmlHttp[2].send(null);
}
	function ValidateDeleteRequest() 
	{ 
		if(xmlHttp[2].readyState == 4) 
		{
			if(xmlHttp[2].status == 200) 
			{  
				var XMLStatus= xmlHttp[2].responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
				var matDetailsId = xmlHttp[2].index;
					if(XMLStatus=="TRUE")
					{
						if(confirm('This item already allocated to Styles\n\nAre you sure you want to Delete this item : ?')){
							ChangeStatus(matDetailsId,0);
						}
					}
					else
						if(confirm('Are you sure you want to Delete this item : ?')){
							ChangeStatus(matDetailsId,0);
						}
			}
		}
	}
function ValidateActive(obj){
	var rw = obj.parentNode.parentNode;
	var detailId	= rw.cells[0].id;
	createXMLHttpRequest1(2);
	xmlHttp[2].index = detailId;
	xmlHttp[2].onreadystatechange=ValidateActiveRequest;
	xmlHttp[2].open("GET", 'itemdeletionandsearchmiddle.php?RequestType=Validate&matDetailId=' + detailId , true);
	xmlHttp[2].send(null);
}
	function ValidateActiveRequest() 
	{ 
		if(xmlHttp[2].readyState == 4) 
		{
			if(xmlHttp[2].status == 200) 
			{  
				var XMLStatus= xmlHttp[2].responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
				var matDetailsId = xmlHttp[2].index;
					if(XMLStatus=="TRUE")
					{
						if(confirm('This item already allocated to Styles\n\nAre you sure you want to Active this item : ?')){
							ChangeStatus(matDetailsId,1);
						}
					}
					else
						if(confirm('Are you sure you want to Active this item : ?')){
							ChangeStatus(matDetailsId,1);
						}
			}
		}
	}
	
function ChangeStatus(matDetailsId,status){
	createXMLHttpRequest1(2);
	xmlHttp[2].onreadystatechange=ChangeStatusRequest;
	xmlHttp[2].open("GET", 'itemdeletionandsearchmiddle.php?RequestType=ChangeStatus&matDetailId=' +matDetailsId+ '&status=' +status ,true);
	xmlHttp[2].send(null);
}
	function ChangeStatusRequest() 
	{ 
		if(xmlHttp[2].readyState == 4) 
		{
			if(xmlHttp[2].status == 200) 
			{  
					if(xmlHttp[2].responseText.indexOf("connect") > -1)
					{
						alert("Sorry\nYour session has been timed out. No changes will be applied.\nPlease try again with new session.");
						submitForm();
					}
					else{
						//alert("Changes Saved successfully.");
						submitForm();
					}
			}
		}
	}
	
function ShowNameCreationWindow(ID,obj)
{
	id=ID;
	rowId = obj.parentNode.parentNode.rowIndex;
	createXMLHttpRequest1(1);
    xmlHttp[1].onreadystatechange = ShowNameCreationWindowNext;
    xmlHttp[1].open("GET", 'itemdeletionandsearchmiddle.php?RequestType=LoadItem&intItemSerial='+ID, true);
    xmlHttp[1].send(null); 
}

function ShowNameCreationWindowNext()
{
	if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
			{
//	alert(xmlHttp[1].responseText);
	
		drawPopupArea(600,318,'frmNameCreator');
		var HTMLText = "<table  width=\"600\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\" cellpadding=\"1\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td height=\"280\"><table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td width=\"92%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
							  "<table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\">"+
								"<tr>"+
								  "<td height=\"24\" colspan=\"4\" class=\"mainHeading\" class=\"TitleN2white\">Edit Property Values</td>"+
								"</tr>"+
								"<tr>"+
								  "<td height=\"3\" colspan=\"4\"><div id=\"divcons\" style=\"overflow:scroll; height:238px; width:590px;\">"+
									"<table id=\"tblValues\" width=\"650px\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
									  "<tr class=\"mainHeading4\">"+
										"<th colspan=\"2\" height=\"25\" width=\"18%\" >Property Name</th>"+
										"<th width=\"21%\">Property Value</th>"+
										"<th width=\"10%\">Display?</th>"+
										"<th width=\"24%\">Display Str</th>"+
										"<th width=\"15%\">Place</th>"+
										"<th width=\"8%\">Serial</th>"+
									  "</tr>";
									  
									  
							/*
							for (var i = 0 ; i < document.getElementById("cboAvailable").options.length ; i++)
							{
								var text = document.getElementById("cboAvailable").options[i].text;
								var value = document.getElementById("cboAvailable").options[i].value;
							
								HTMLText += "<tr>"+
											"<td colspan=\"2\" class=\"normalfnt\" id=\"" +  value + "\">" + text + "</td>"+
											"<td class=\"normalfnt\"><table width=\"93%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
											  "<tr>"+
												"<td width=\"79%\"><select name=\"CBOadd\" class=\"txtbox\" id=\"CBOadd\" style=\"width:90px\">"+
														"</select></td>"+
												"<td width=\"21%\"><img src=\"../../images/add.png\" alt=\"[+]\" width=\"16\" height=\"16\" class=\"mouseover\" onClick=\"ShowNewValueForm(this);\" /></td>"+
											  "</tr>"+
											"</table></td>"+
											"<td class=\"normalfntRite\"><div align=\"center\">"+
											  "<input type=\"checkbox\" name=\"checkbox\" value=\"checkbox\" \" />"+
											"</div></td>"+
											"<td><input name=\"textfield\" type=\"text\" class=\"txtbox\" size=\"15\" /></td>"+
											"<td><select name=\"select2\" class=\"txtbox\">"+
											  "<option value=\"Before\">Before</option>"+
											  "<option value=\"After\">After</option>"+
											"</select>                    </td>"+
											"<td><div align=\"center\">"+
											  "<select name=\"select2\" class=\"txtbox\">";
											for (var x = 0 ; x < document.getElementById("cboAvailable").options.length ; x++)
											{
												if (i == x )
												HTMLText += "<option value=\"" +( x + 1) + "\" selected=\"selected\">" + (x + 1) +"</option>";
												else
												HTMLText += "<option value=\"" +( x + 1) + "\">" + (x + 1) +"</option>";
											}
								HTMLText +=	  "</select>"+
											"</div></td>"+
										  "</tr>";
								createNewXMLHttpRequest(i);
								xmlHttpreq[i].onreadystatechange = HandlePropertyRequest;
								xmlHttpreq[i].value = value;
								xmlHttpreq[i].index = i;
								xmlHttpreq[i].open("GET", 'wizardmiddle.php?str=getPropValues&PropID=' + value, true);
								xmlHttpreq[i].send(null);
									  
							}
									*/ 
									
			
				var XMLPrice = xmlHttp[1].responseXML.getElementsByTagName("Price");
				var XMLUnit = xmlHttp[1].responseXML.getElementsByTagName("Unit");
				var XMLSerial = xmlHttp[1].responseXML.getElementsByTagName("Serial");				
				var Price = XMLPrice[0].childNodes[0].nodeValue;
				var Unit = XMLUnit[0].childNodes[0].nodeValue;
				var Serial = XMLSerial[0].childNodes[0].nodeValue;
				
				var XMLProperties = xmlHttp[1].responseXML.getElementsByTagName("PropertyName");
				var XMLPropertyIDs = xmlHttp[1].responseXML.getElementsByTagName("PropertyID");
				
				 for ( var loop = 0; loop < XMLProperties.length; loop ++)
				 {
					HTMLText += "<tr class=\"bcgcolor-tblrowWhite\">"+
											"<td colspan=\"2\" class=\"normalfnt\" id=\"" +XMLPropertyIDs[loop].childNodes[0].nodeValue+ "\">"+XMLProperties[loop].childNodes[0].nodeValue+"</td>"+
											"<td class=\"normalfnt\"><table width=\"93%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
												  "<tr>"+
													"<td width=\"79%\"><select name=\"CBOadd\" class=\"txtbox\" id=\"CBOadd\" style=\"width:120px\">"+fillValues(loop)+"</select></td>"+
													"<td width=\"21%\"><img src=\"../../../images/add.png\" alt=\"[+]\" width=\"16\" height=\"16\" class=\"mouseover\" onClick=\"ShowNewValueForm(this);\" /></td>"+
												  "</tr>"+
												"</table></td>"+
											"<td class=\"normalfntRite\"><div align=\"center\">"+
										  "<input type=\"checkbox\" name=\"checkbox\" onclick=\"displayStrCtrl(this,"+loop+");\" />"+
										"</div></td>"+
										"<td><input name=\"textfield"+loop+"\" id=\"textfield"+loop+"\" type=\"text\" class=\"txtbox\""+
										"size=\"15\" disabled=\"disabled\" /></td>"+
										"<td class=\"normalfnt\"><select name=\"select1\" class=\"txtbox\">"+
											  "<option value=\"Before\">Before</option>"+
											  "<option value=\"After\">After</option>"+
											"</select></td>"+
										"<td class=\"normalfnt\"><div align=\"center\">"+
										  "<select name=\"select2\" class=\"txtbox\">";
										for (var x = 0 ; x < XMLProperties.length ; x++)
										{
											if (loop == x )
											HTMLText += "<option value=" +( x + 1) + " selected=\"selected\">" + (x + 1) +"</option>";
											else
											HTMLText += "<option value=" +( x + 1) + ">" + (x + 1) +"</option>";
										}
							HTMLText +=	  "</select>"+
										"</div></td>"+
									  "</tr>";					
				 }
						HTMLText += "</table>"+
								 " </div></td>"+
								"</tr>"+
								"<tr>"+
								  "<td width=\"15%\" height=\"3\" class=\"normalfnt\">Unit</td>"+
								  "<td width=\"37%\" class=\"normalfnt\"><select name=\"cboUnits\" class=\"txtbox\" id=\"cboUnits\" style=\"width:90px\" tabindex=\"4\">"+
								  "</select></td>"+
								  "<td width=\"19%\" class=\"normalfnt\" align=\"right\">Price</td>"+
								  "<td width=\"29%\" class=\"normalfnt\"><input name=\"textPrice\" type=\"text\" class=\"txtboxRight\" size=\"15\" id=\"textPrice\" style=\"text-align:right;\"  value="+Price+" ></td></td>"+
								"</tr>"+
								"<tr>"+
								  "<td  colspan=\"4\" ><table width=\"100%\" border=\"0\" class=\"tableBorder\" cellpadding=\"1\" cellspacing=\"0\">"+
									"<tr>"+
									  "<td width=\"46%\" class=\"normalfntMid\">"+
									  "<img src=\"../../../images/finish.png\" alt=\"save\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"Savenfinish("+Serial+","+rowId+");\" />"+
									  "<img src=\"../../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeWindow();\" /></td>"+
									"</tr>"+
								 " </table></td>"+
								"</tr>"+
							  "</table>"+
									"</form>"+
							"</td>"+
							/*"<td width=\"4%\">&nbsp;</td>"+*/
						  "</tr>"+
						"</table></td>"+
					  "</tr>"+
					 /* "<tr>"+
						"<td>&nbsp;</td>"+
					  "</tr>"+*/
					"</table>";
	
		document.getElementById('frmNameCreator').innerHTML=HTMLText;
		//LoadAvailableUnits();
		loadComboes(Unit);
			}
}

function fillValues(i)
{	
	var str = "<option value=\"\"></option>";
	var XMLName = xmlHttp[1].responseXML.getElementsByTagName("PropertyValue"+i);
	var XMLNameID = xmlHttp[1].responseXML.getElementsByTagName("PropertyValueID"+i);
//	var propVal= xmlHttp[1].responseXML.getElementsByTagName("PropertyName");
	 for ( var loop = 0; loop < XMLName.length; loop ++)
	 {
		 
	//	 if(propVal[loop].childNodes[0].nodeValue==XMLName[loop].childNodes[0].nodeValue){
	//	str += "<option value="+XMLNameID[loop].childNodes[0].nodeValue+" selected=\"selected\">"+XMLName[loop].childNodes[0].nodeValue+"</option>";	
	//	 }
	//	 else{
		str += "<option value="+XMLNameID[loop].childNodes[0].nodeValue+">"+XMLName[loop].childNodes[0].nodeValue+"</option>";	
	//	 }
	 }
	 return str;
}

function displayStrCtrl(objChk,i)
{	
		//alert(objChk.checked);
		if(!objChk.checked)
		{
			//alert("not Checked");
			document.getElementById("textfield"+i).disabled= true;
			document.getElementById("textfield"+i).value="";			
		}
		else
		{
			//alert("Checked");
			document.getElementById("textfield"+i).disabled=false;
			document.getElementById("textfield"+i).value="";
						
		}
}
function loadComboes(units){
	
	var sql = "SELECT strUnit, strUnit FROM units u where u.intStatus=1 ORDER BY strUnit";
	loadCombo(sql,'cboUnits');
	document.getElementById("cboUnits").value=units;
	 loadPropertyValue();
}

function loadPropertyValue(){
	
	var tbl = document.getElementById("tblValues");
	var rows = tbl.rows.length;
	for(var i=1; i<rows; i++){
	//alert(tbl.rows[i].cells[0].id);
	
	var PropertyValue = tbl.rows[i].cells[0].id;	
		var path = "itemdeletionandsearchmiddle.php?RequestType=loadPropertyValue";
	    path += "&intMatPropertyId="+PropertyValue;
		path += "&intItemSerial="+id;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLstrDisplayString   = htmlobj.responseXML.getElementsByTagName("strDisplayString");
	var XMLstrSubPropertyName   = htmlobj.responseXML.getElementsByTagName("strSubPropertyName");
	var XMLstrSubPropertyVAL   = htmlobj.responseXML.getElementsByTagName("strSubPropertyVAL");
	var XMLintBefore   = htmlobj.responseXML.getElementsByTagName("intBefore");
	var XMLintOrder    = htmlobj.responseXML.getElementsByTagName("intOrder");
	
	var xmlLength = htmlobj.responseXML.getElementsByTagName("*").length;
		if(xmlLength>1)
		{
			document.frmmaterial3.CBOadd[i-1].options[0].text=XMLstrSubPropertyName[0].childNodes[0].nodeValue;
			document.frmmaterial3.CBOadd[i-1].options[0].value=XMLstrSubPropertyVAL[0].childNodes[0].nodeValue;
			tbl.rows[i].cells[3].childNodes[0].disabled=false; 
			tbl.rows[i].cells[3].childNodes[0].value = XMLstrDisplayString[0].childNodes[0].nodeValue;
			
			if(XMLintBefore[0].childNodes[0].nodeValue == 1){
			// alert(XMLintOrder[0].childNodes[0].nodeValue)
			document.frmmaterial3.select1[i-1].options[0].text = "Before";
			document.frmmaterial3.select2[i-1].value = parseInt(XMLintOrder[0].childNodes[0].nodeValue);
			//alert(document.frmmaterial3.select2[i-1].options[0].value)
			}
			
			if(XMLintBefore[0].childNodes[0].nodeValue == 2){
			document.frmmaterial3.select1[i-1].options[0].text = "After";
			document.frmmaterial3.select2[i-1].value = parseInt(XMLintOrder[0].childNodes[0].nodeValue);
			}
		}
	}
}




	
function LoadAvailableUnits()
{
	createXMLHttpRequest1(2);
    xmlHttp[2].onreadystatechange = HandleUnits;
    xmlHttp[2].open("GET", '../../../preordermiddletire.php?RequestType=GetUnits', true);
    xmlHttp[2].send(null); 
}

function HandleUnits()
{
	if(xmlHttp[2].readyState == 4) 
    {
        if(xmlHttp[2].status == 200) 
        {  
			 var XMLName = xmlHttp[2].responseXML.getElementsByTagName("unit");
			 /*for ( var loop = 0; loop < XMLName.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLName[loop].childNodes[0].nodeValue;
				document.getElementById("cboUnits").options.add(opt);
			 }*/
			 document.getElementById("cboUnits").innerHTML =  XMLName[0].childNodes[0].nodeValue 
		}
	}
}

function ShowNewValueForm(obj)
{
	var propertyName = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
	var propValue = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].id;
	var rowIndex = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.rowIndex;
	drawPopupAreaLayer(350,360,'frmValueSelecter',14);
	var HTMLText = "<table width=\"350\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
						"<td width=\"26%\">&nbsp;</td>"+
						"<td width=\"30%\">"+
						  "<table width=\"100%\" border=\"0\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"TitleN2white\"><table width=\"100%\" border=\"0\" class=\"mainHeading\">"+
								"<tr>"+
								  "<td width=\"93%\">Select Value</td>"+
								  "<td width=\"7%\"><img src=\"../../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeLayer();\" class=\"mouseover\" /></td></tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"7\" colspan=\"2\">&nbsp;</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" valign=\"top\" class=\"normalfnt\">Property</td>"+
							  "<td width=\"61%\" valign=\"top\" class=\"normalfnt\">" + propertyName + "</td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"0\" colspan=\"2\" class=\"normalfnt\">&nbsp;</td>"+
							  "</tr>"+
							"<tr>"+
							  "<td height=\"-1\" colspan=\"2\" class=\"normalfnt\"><div align=\"center\">"+
								"<select name=\"cboValues\" size=\"10\" class=\"txtbox\" id=\"cboValues\" style=\"width:275px\">"+
								"</select>"+
							  "</div></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"22%\">&nbsp;</td>"+
								  "<td width=\"38%\" align=\"right\"><img src=\"../../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closeLayer();\" class=\"mouseover\" /></td>"+
								  "<td width=\"40%\" align=\"right\"><img src=\"../../../images/ok.png\" onClick=\"AddValueToList(" + rowIndex  + "," + propValue +")\" alt=\"close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"2\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
									"<tr>"+
									  "<td height=\"21\" colspan=\"3\" class=\"mainHeading3\">New</td>"+
									"</tr>"+
									"<tr>"+
									  "<td width=\"58%\"><input name=\"txtNewValue\" onclick=\"closeList();\" onkeyup=\"GetAutoComplete(event,this.value,'../../../autofill.php?RequestType=propertyValues&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"20\" /></td>"+
									  "<td width=\"11%\"><input type=\"checkbox\" name=\"chkassignvalue\" id=\"chkassignvalue\" /></td>"+
									  "<td width=\"31%\" class=\"normalfnt\">Assign</td>"+
									"</tr>"+
									"<tr>"+
									  "<td colspan=\"3\" class=\"mbari13\"><div align=\"right\"><img src=\"../../../images/addsmall.png\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
									"</tr>"+
								  "</table></td>"+
								  "</tr>"+
							  "</table></td>"+
							"</tr>"+							
						  "</table>"+
						"</td>"+
						"<td width=\"44%\">&nbsp;</td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";
		document.getElementById('frmValueSelecter').innerHTML=HTMLText;
		LoadApplicableValues(propValue);
}

function LoadApplicableValues(propID)
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleLoadOtherProperties;
    altxmlHttp.open("GET", '../wizardmiddle.php?str=getOtherProperties&PropID=' + propID , true);
    altxmlHttp.send(null); 
}

function HandleLoadOtherProperties()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLValueID = altxmlHttp.responseXML.getElementsByTagName("PropID");
			 var ValueName = altxmlHttp.responseXML.getElementsByTagName("PropName");
			 for ( var loop = 0; loop < XMLValueID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = ValueName[loop].childNodes[0].nodeValue;
				opt.value = XMLValueID[loop].childNodes[0].nodeValue;
				document.getElementById("cboValues").options.add(opt);
			 }
			//alert(xmlHttpreq[this.index].value);
		}
	}	
}

function  AddValueToList(rowIndex,propValue)
{
	var colors = document.getElementById("cboValues");
	if(colors.selectedIndex <= -1) 
	{
		alert("Please select property value to be added.");
		return;
	}
	
	createXMLHttpRequest1(1);
    			
	var url="../server.php";
	url=url+"?q=Assign";

	url=url+"&intPropertyId="+propValue;
	url=url+"&intSubPropertyid="+document.getElementById("cboValues").value;	
	url=url+"&SubPropertyName="+URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text);	
	
	xmlHttp[1].onreadystatechange=HandleValueAssigning;
	xmlHttp[1].open("GET",url,true);
	xmlHttp[1].rowIndex = rowIndex;
	xmlHttp[1].send(null);
	
}

function HandleValueAssigning()
{	
    if(xmlHttp[1].readyState == 4) 
    {
        if(xmlHttp[1].status == 200) 
        {
			if (xmlHttp[1].responseText == "true")
			{
				var tblValues = document.getElementById("tblValues");
				var cbo = tblValues.rows[xmlHttp[1].rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
				var opt = document.createElement("option");
				
				opt.text = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text;
				opt.value = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].value;
				for(var i=0;i<cbo.options.length+1;i++){
					if(i==cbo.options.length){
						cbo.options.add(opt);
					}
					if(cbo.options[i].text==opt.text){
						i=cbo.options.length+1;
					}
				}
				
				closeLayer();
			}
			else
			{
				alert("The property value assigning process failed. May be it already exists.");
			}
		}
		
	}
}

/*
function ShowNewValueForm1(obj)
{
	var propertyName = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
	var propValue = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].id;
	var rowIndex = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.rowIndex;
	drawPopupAreaLayer(250,140,'frmValueSelecter',20);
	var HTMLText = "<table width=\"250\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+						
						"<td >"+
						  "<table width=\"100%\" border=\"0\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"TitleN2white\"><table width=\"100%\" border=\"0\" bgcolor=\"#996F03\">"+
								"<tr>"+
								  "<td width=\"93%\">New Value</td>"+
								  "<td width=\"7%\"><img src=\"../../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeLayer();\" /></td></tr>"+
							  "</table></td>"+
							"</tr>"+
							
							"<tr>"+
							  "<td height=\"3\" colspan=\"2\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+									
									"<tr>"+
									  "<td colspan=\"2\"  width=\"75%\"><input name=\"txtNewValue\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"33\" /></td>"+ 
									"</tr>"+
									"<tr>"+
									"<td><img src=\"../../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeLayer();\" /></td>"
									+
									  "<td bgcolor=\"#D6E7F5\"><div align=\"center\"><img src=\"../../../images/addsmall.png\" class=\"mouseover\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" /></div></td>"+
									"</tr>"+
								  "</table></td>"+
								  "</tr>"+
							  "</table></td>"+
							"</tr>"+							
						  "</table>"+
						"</td>"+						
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";
		document.getElementById('frmValueSelecter').innerHTML=HTMLText;
		LoadApplicableValues1(propValue);
}

function LoadApplicableValues1(propID)
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleLoadOtherProperties1;
    altxmlHttp.open("GET", '../wizardmiddle.php?str=getOtherProperties&PropID=' + propID , true);
    altxmlHttp.send(null); 
}

function HandleLoadOtherProperties1()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLValueID = altxmlHttp.responseXML.getElementsByTagName("PropID");
			 var ValueName = altxmlHttp.responseXML.getElementsByTagName("PropName");
			 for ( var loop = 0; loop < XMLValueID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = ValueName[loop].childNodes[0].nodeValue;
				opt.value = XMLValueID[loop].childNodes[0].nodeValue;
				//document.getElementById("cboValues").options.add(opt);
			 }
			//alert(xmlHttpreq[this.index].value);
		}
	}	
}
*/
function SaveValue(propID,rowIndex)
{    

	 	if (document.getElementById("txtNewValue").value == "" || document.getElementById("txtNewValue").value == null)
		{
			alert("Please enter the value.");
			return;
		}
		createAltXMLHttpRequest();
		
		var url="../server.php";
		url=url+"?q=savevalue";
			
		
		//url=url+"&strSubPropertyCode="+document.getElementById("txtvaluecode").value;
		url=url+"&strSubPropertyName="+document.getElementById("txtNewValue").value;
		url=url+"&intPropertyId="+propID;	
		/*
		if(document.getElementById("chkassignvalue").checked==true)
		assivalu=1;
		else
		assivalu=0;
		
		url=url+"&assivalu="+assivalu;
		*/
		altxmlHttp.onreadystatechange=HandleValueSaving;
		altxmlHttp.rowIndex = rowIndex;
		altxmlHttp.open("GET",url,true);
		altxmlHttp.send(null);
	   
}

function HandleValueSaving()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			if (altxmlHttp.responseText == "-1")
			{
				alert("Value already exists");
			}
			else if(altxmlHttp.responseText=="-1Already exists")
			{
				alert("Value Already Assigned.");
			}
			else 
			{
				var id = altxmlHttp.responseText;
				var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				opt.value = id;
				//alert(opt.text);
				//document.getElementById("CBOadd").options.add(opt);
				
				var tblValues = document.getElementById("tblValues");
				var cbo = tblValues.rows[altxmlHttp.rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
				
				var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				opt.value = id;
				cbo.options.add(opt);
				alert("New Value Successfuly Saved"); 
				document.getElementById("txtNewValue").value="";
				//setTimeout("location.reload(true);",1);				
				
			}
			closeLayer();			
		}
		
	}
	
}

function Savenfinish(serial,rwID)
{   
	if (!isDuplicateSelections())
	{
		return ;	
	}
	
	var intItemSerial=serial;
	var strUnit = document.getElementById("cboUnits").value;
	var dblLastPrice=0.00;
	if(document.getElementById("textPrice").value!="")
		dblLastPrice = document.getElementById("textPrice").value;
		
	var tbl = document.getElementById('tblValues');
	var ItemCode="";
	var displayCode="";
	var propIDlist=",";
	var propValueIdList =",";
	var displayStrList = "";
	var strBeforeAfterList = "";
	var serialList = "";
	//var CatCodes = ["FA", "AC", "PA","SE","OT"];
	//var ItemCode = mainCatID + "_" + subCatID;
	//var displayCode = mainCatID + "_" + subCatID;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value!=""){
			var PropID = tbl.rows[loop].cells[0].id;
			var propValue = tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value;
			ItemCode +="," + PropID + "." + propValue;
			displayCode +="#" + PropID + "." + propValue;
			propIDlist+=PropID+",";
			propValueIdList+=propValue+",";
			
			var displayStr = tbl.rows[loop].cells[3].childNodes[0].value;
			var strBeforeAfter = tbl.rows[loop].cells[4].childNodes[0].value;
			if(strBeforeAfter == 'Before'){
				strBeforeAfter = 1;
			}
			
			if(strBeforeAfter == 'After'){
				strBeforeAfter = 2;
			}
	
			var serial = tbl.rows[loop].cells[5].childNodes[0].lastChild.value;
			displayStrList+=displayStr+",";
			strBeforeAfterList+=strBeforeAfter+",";
			serialList+=serial+",";	
		}
	}
	//alert(ItemCode);
	
	//var ItemName = document.getElementById("cbocategories").options[document.getElementById("cbocategories").selectedIndex].text;
	var ItemName="";
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		for (var x = 1; x < tbl.rows.length ; x++)
		{
			var optValue = tbl.rows[x].cells[5].childNodes[0].childNodes[0].value;
			if (optValue == loop)
			{
				if (tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options.length <=0 )
				{
					alert("No values set for some properties. Please select proper values.");	
					return;
				}
				var valueName = tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options[tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].selectedIndex].text;
				
				if(tbl.rows[x].cells[2].childNodes[0].childNodes[0].checked )
				{
					var displayText = tbl.rows[x].cells[3].childNodes[0].value;
					var subName = displayText;	
					
					if(tbl.rows[x].cells[4].childNodes[0].value == "Before")
					{
						subName = displayText + " " +  valueName;
					}
					else
					{
						subName = valueName + " " +  displayText;	

					}
					ItemName += " " + subName;
				}
				else
				{
					
					ItemName += " " + valueName;
				}
			}
		}
	}	
	//alert(ItemName);
	
	///*createXMLHttpRequest1(1);
//    xmlHttp[1].onreadystatechange = alertMsgForItem;
//    xmlHttp[1].open("GET", '../../itemwizardgeneral/wizardmiddle.php?str=UpdateMaterial&intItemSerial=' + intItemSerial +'&ItemCode=' + ItemCode  +'&ItemName=' + ItemName+'&strUnit=' + strUnit + '&dblLastPrice=' + dblLastPrice +'&propIDlist='+propIDlist+'&propValueIdList='+propValueIdList+'&displayStrList='+displayStrList+'&strBeforeAfterList='+strBeforeAfterList+'&serialList='+serialList, true);
//	xmlHttp.open("GET", 'wizardmiddle.php?str=SaveMaterial&ItemCode=' + ItemCode + '&ItemName=' + ItemName + '&MainCatID=' + MainCateID + '&subCatID=' + subCatID + '&unitID=' + unitID, true);*/
//    xmlHttp[1].send(null);  
	var url = '../../itemwizardgeneral/wizardmiddle.php?str=UpdateMaterial&intItemSerial=' + intItemSerial +'&ItemCode=' + ItemCode  +'&ItemName=' + ItemName+'&strUnit=' + strUnit + '&dblLastPrice=' + dblLastPrice +'&propIDlist='+propIDlist+'&propValueIdList='+propValueIdList+'&displayStrList='+displayStrList+'&strBeforeAfterList='+strBeforeAfterList+'&serialList='+serialList;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLmessage = htmlobj.responseXML.getElementsByTagName("message");
	var message = XMLmessage[0].childNodes[0].nodeValue;
	var tblMain = document.getElementById('tblPreOders');
	tblMain.rows[rwID].cells[1].innerHTML = htmlobj.responseXML.getElementsByTagName("ItemName")[0].childNodes[0].nodeValue;
	tblMain.rows[rwID].cells[2].innerHTML = htmlobj.responseXML.getElementsByTagName("strUnit")[0].childNodes[0].nodeValue;
	tblMain.rows[rwID].cells[3].innerHTML = htmlobj.responseXML.getElementsByTagName("dblLastPrice")[0].childNodes[0].nodeValue;
	
	alert(message);
	closeWindow();
	
}

function alertMsgForItem()
{	
    if(xmlHttp[1].readyState == 4) 
    {
        if(xmlHttp[1].status == 200) 
        {  
			var XMLmessage = xmlHttp[1].responseXML.getElementsByTagName("message");
			var message = XMLmessage[0].childNodes[0].nodeValue;
			alert(message);
			//closeWindow();
			//setTimeout("location.reload(true);",1);

		}
	}
	
}

function isDuplicateSelections()
{
	var arr = [];
	var tbl = document.getElementById('tblValues');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var optValue = tbl.rows[loop].cells[5].childNodes[0].childNodes[0].value;
		if (!findItem(optValue, arr))
		{
			arr[loop-1] = optValue ;
		}
		else
		{
			alert("Couldn't start save process. \nThere is a error with your serial selection. Please select it correctly.");
			return false;
		}
	}
	return true;
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

/*
function loadItem()
{
	var mainCatId = document.getElementById("cboMainCategory").value;
	var subCatId = document.getElementById("cboSubCategory").value;
	var txtDetailsLike = document.getElementById("txtDetailsLike").value;
	createXMLHttpRequest1(2);
	xmlHttp1[2].onreadystatechange = loadMaterialRequest;
	xmlHttp1[2].open("GET", 'supplierWiseItemsXml.php?id=loadMaterial&mainCatId='+mainCatId+'&subCatId='+subCatId+'&txtDetailsLike='+txtDetailsLike, true);
	xmlHttp1[2].send(null); 
		
}

function loadMaterialRequest()
{
	if(xmlHttp1[2].readyState == 4 && xmlHttp1[2].status == 200 ) 
	{
		var XMLid = xmlHttp1[2].responseXML.getElementsByTagName("intItemSerial");
		var XMLname = xmlHttp1[2].responseXML.getElementsByTagName("strItemDescription");
		var tblMaterial = document.getElementById("tblMaterial");
		
		var selection = "";				
		selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkitem(this)\"/>";
		
		var tableText = "<tr>"+
								"		<td width=\"2%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
								"		<td width=\"90%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Detail</td>"+
								"		<td width=\"8%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Serial</td>"+
								"		</tr>"+
								"		<tr>";
		
	 for ( var loop = 0; loop < XMLid.length; loop++)
	 {		
		tableText +="<tr class=\"bcgcolor-tblrowWhite\">"+
		"	<td class=\"normalfnt\" ><div align=\"center\">"+ selection + "</div></td>"+
		"	<td class=\"normalfnt\">"+XMLname[loop].childNodes[0].nodeValue+"</td>"+
		"	<td class=\"normalfnt\">"+XMLid[loop].childNodes[0].nodeValue+"</td>"+
		"	</tr>";
	}
	tblMaterial.innerHTML = tableText;
	}
}
*/