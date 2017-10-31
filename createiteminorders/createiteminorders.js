var xmlHttpitem = [];
var altxmlHttp;

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

function createXMLHttpRequestitem(index) 
 {
	if (window.ActiveXObject) 
	{
		xmlHttpitem[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpitem[index] = new XMLHttpRequest();
	}
 }
 
function AddNewMaterialItem()
{
	var mainMaterial = document.getElementById('cboMaterial').value;
	var subCategory	 = document.getElementById('cboCategory').value;
	var subCatName   = document.getElementById('cboCategory').options[document.getElementById('cboCategory').selectedIndex].text;
	if(mainMaterial==""){
		alert("Please select the main category");
		return;
	}
	if(subCategory=="Select One"){
		alert("Please select the sub category");
		return;
	}
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=AddNewMaterialItemRequest;
	xmlHttp.open("GET",'createiteminorders/createiteminorders.php?mainMaterial=' +mainMaterial+ '&subCategory=' +subCategory+'&subCatName='+subCatName,true);
	xmlHttp.send(null);
}

	function AddNewMaterialItemRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				//drawPopupArea(650,225,'frmCreateiteminorders');	
				drawPopupBox(650,225,'frmCreateiteminorders',10);
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmCreateiteminorders').innerHTML=HTMLText;				
			}
		}
	}
	
function SaveFinish()
{   
	if (!isDuplicateSelections())
	{
		return ;	
	}
	var mainCatID = document.getElementById("cboMaterial").value;
	var subCatID = document.getElementById("cboCategory").value;
	var tbl = document.getElementById('tblValues');
	var CatCodes = ["FA", "AC", "PA","SE","OT"];
	var ItemCode = CatCodes[mainCatID-1] + "_" + subCatID + ",";
	var displayCode = CatCodes[mainCatID-1] + "_" + subCatID + "#";
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked){
			if (tbl.rows[loop].cells[2].childNodes[0].options.length <=0 )
			{
				alert("No values set for some properties. Please select proper values.");	
				return;
			}
			var PropID = tbl.rows[loop].cells[1].id;
			var propValue = tbl.rows[loop].cells[2].childNodes[0].childNodes[1].value;
			ItemCode += PropID + "." + propValue + ",";
			displayCode += PropID + "." + propValue + "#";
		}
	}
	
	
	var ItemName = document.getElementById("cboCategory").options[document.getElementById("cboCategory").selectedIndex].text;
	
/*	if (mainCatID == 1)
	{
		if(document.getElementById("cboFabricContent").options[document.getElementById("cboFabricContent").selectedIndex].text != "");
		ItemName += " " + document.getElementById("cboFabricContent").options[document.getElementById("cboFabricContent").selectedIndex].text ;
	}*/
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		
		for (var x = 1; x < tbl.rows.length ; x++)
		{
			/*if(tbl.rows[loop].cells[0].childNodes[0].checked)
		      {*/
				if(tbl.rows[x].cells[0].childNodes[0].checked)
				{				
					var optValue = tbl.rows[x].cells[7].childNodes[0].value;
						if (optValue == loop)
						{						
							if (tbl.rows[x].cells[2].childNodes[0].options.length <=0 )
							{
								alert("No values set for some properties. Please select proper values.");	
								return;
							}
							
								//var valueName = tbl.rows[x].cells[2].childNodes[0].childNodes[1].text;
								
								/*for(var i=0; i<tbl.rows[x].cells[2].childNodes[0].options.length; i++)
								{
									if(tbl.rows[x].cells[2].childNodes[0].options[i].selected == true)
										var valueName = tbl.rows[x].cells[2].childNodes[0].options[i].text;
								}*/
								
								var valueName = tbl.rows[x].cells[2].childNodes[0].options[tbl.rows[x].cells[2].childNodes[0].selectedIndex].text;
								
								if(tbl.rows[x].cells[4].childNodes[0].checked )
								{
									var displayText = tbl.rows[x].cells[5].childNodes[0].value;
									var subName = displayText;	
									
									if(tbl.rows[x].cells[6].childNodes[0].value == "Before")
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
			//}
		}//
	}

	var wastage = document.getElementById("txtwastage").value;
	var unitID = document.getElementById("cboUnits").options[document.getElementById('cboUnits').selectedIndex].text;	
	var subCatID = document.getElementById("cboCategory").value;
	
	if(confirm("The new item name will be as follows\n\n" + ItemName + "\n\nDo you wan't to continue with this."))
	{
		createXMLHttpRequestitem(1);	
    	xmlHttpitem[1].onreadystatechange = HandleMaterialSaving;
    	xmlHttpitem[1].open("GET", 'createiteminorders/createiteminordersdb.php?RequestType=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + mainCatID + '&subCatID=' + subCatID + '&Wastage=' + wastage + '&unitID=' + unitID, true);
   	xmlHttpitem[1].send(null);
   }	
}

function HandleMaterialSaving()
{
    if(xmlHttpitem[1].readyState == 4) 
    {
        if(xmlHttpitem[1].status == 200) 
        { 
        		var result = xmlHttpitem[1].responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
				var message = xmlHttpitem[1].responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
				if(result == "True")
				{
					alert(message);
					LoadItems();
					closePopupBox(10);
        		}
        		else
        		{
        			alert(message);
				}
			}	
 	}       
}

function isDuplicateSelections()
{
	var arr = [];
	var tbl = document.getElementById('tblValues');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var optValue = tbl.rows[loop].cells[7].childNodes[0].value;
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

function ShowNewValueForm(obj)
{
	var propertyName = obj.parentNode.parentNode.cells[1].childNodes[0].nodeValue;
	var propValue = obj.parentNode.parentNode.cells[1].id;
	var rowIndex = obj.parentNode.parentNode.rowIndex;
	drawPopupBox(350,360,'frmValueSelecter',14);
	//drawPopupAreaLayer(350,360,'frmValueSelecter',14);
	
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
								  "<td width=\"7%\"><img src=\"/gapro/images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closePopupBox(14);\" class=\"mouseover\" /></td></tr>"+
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
								  "<td width=\"38%\" align=\"right\"><img src=\"/gapro/images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closePopupBox(14);\" class=\"mouseover\" /></td>"+
								  "<td width=\"40%\" align=\"right\"><img src=\"/gapro/images/ok.png\" onClick=\"AddValueToList(" + rowIndex  + "," + propValue +")\" alt=\"close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"2\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
									"<tr>"+
									  "<td height=\"21\" colspan=\"3\" class=\"mainHeading2\">New</td>"+
									"</tr>"+
									"<tr>"+
									  "<td width=\"58%\"><input name=\"txtNewValue\"   onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'/gapro/autofill.php?RequestType=propertyValues&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"20\" /></td>"+
									  "<td width=\"11%\"><input type=\"checkbox\" name=\"chkassignvalue\" id=\"chkassignvalue\" /></td>"+
									  "<td width=\"31%\" class=\"normalfnt\">Assign</td>"+
									"</tr>"+
									"<tr>"+
									  "<td colspan=\"3\" class=\"mbari13\"><div align=\"right\"><img src=\"/gapro/images/addsmall.png\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
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
				/*var frame = document.createElement("div");
    frame.id = "propertyValue";*/
	 //document.getElementById('popupLayer').id="itemSub";
		document.getElementById('frmValueSelecter').innerHTML=HTMLText;
		
		LoadApplicableValues(propValue);
		
}

function LoadApplicableValues(propID)
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleLoadOtherProperties;
   /* altxmlHttp.open("GET", '/gapro/addinns/itemWizard/wizardmiddle.php?str=getOtherProperties&PropID=' + propID , true);*/
   altxmlHttp.open("GET", 'createiteminorders/createiteminordersdb.php?RequestType=getOtherProperties&PropID=' + propID , true);
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

//Save Property Value
function SaveValue(propID,rowIndex)
{    
		var assivalu=0;
	 	if (document.getElementById("txtNewValue").value == "" || document.getElementById("txtNewValue").value == null)
		{
			document.getElementById("txtNewValue").focus();
			alert("Please enter the Value.");
			return;
		}
		//xmlHttp=GetXmlHttpObject();
		createXMLHttpRequest();	
		/*var url="/gapro/addinns/itemWizard/server.php";
		url=url+"?q=savevalue";*/
			var url="createiteminorders/createiteminordersdb.php?RequestType=savevalue";

		//url=url+"&strSubPropertyCode="+document.getElementById("txtvaluecode").value;
		url=url+"&strSubPropertyName="+ URLEncode(document.getElementById("txtNewValue").value);
		url=url+"&intPropertyId="+propID;	
		
		if(document.getElementById("chkassignvalue").checked==true)
			assivalu=1;
		else
			assivalu=0;
		
		url=url+"&assivalu="+assivalu;
		
		xmlHttp.onreadystatechange=HandleValueSaving;
		xmlHttp.rowIndex = rowIndex;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null); 
	   
}

function HandleValueSaving()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			if (xmlHttp.responseText == "-1")
			{
				document.getElementById("txtNewValue").focus();
				alert("The Value is already exist.");
			}
			else
			{
				
				var id = xmlHttp.responseText;
				var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				opt.value = id;
				document.getElementById("cboValues").options.add(opt);
				if(document.getElementById("chkassignvalue").checked==true)
				{
					var tblValues = document.getElementById("tblValues");
					var cbo = tblValues.rows[xmlHttp.rowIndex].cells[2].childNodes[0];
					var opt = document.createElement("option");
					opt.text = document.getElementById("txtNewValue").value;
					opt.value = id;
					cbo.options.add(opt);
					//alert(cbo.options.length);
					cbo.selectedIndex= cbo.options.length-1;
					closeList1();
					closePopupBox(14);
				}
				
				
			}

			
		}
		
	}
	
}
function closeList1()
{
	try
	{
		var box = document.getElementById('items');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function  AddValueToList(rowIndex,propValue)
{
	var colors = document.getElementById("cboValues");
	if(colors.selectedIndex <= -1) 
	{
		alert("Please select Property value to be added.");
		return;
	}
	
	createXMLHttpRequest();	
			
	/*var url="/gapro/addinns/itemWizard/server.php";
	url=url+"?q=Assign";*/
	var url="createiteminorders/createiteminordersdb.php?RequestType=Assign";
	url=url+"&intPropertyId="+propValue;
	url=url+"&intSubPropertyid="+document.getElementById("cboValues").value;	
	url=url+"&SubPropertyName="+URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text);	
	
	xmlHttp.onreadystatechange=HandleValueAssigning;
	xmlHttp.open("GET",url,true);
	xmlHttp.rowIndex = rowIndex;
	xmlHttp.send(null);
	
}

function HandleValueAssigning()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			if (xmlHttp.responseText == "true")
			{
				var tblValues = document.getElementById("tblValues");
				var cbo = tblValues.rows[xmlHttp.rowIndex].cells[2].childNodes[0];
				var opt = document.createElement("option");
				
				opt.text = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text;
				opt.value = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].value;
				//alert(11);
				for(var i=0;i<cbo.options.length+1;i++){
					if(i==cbo.options.length){
						cbo.options.add(opt);						
						cbo.selectedIndex = cbo.options.length-1;
					}
					if(cbo.options[i].text==opt.text){
						i=cbo.options.length+1;
					}
				}
				
				closePopupBox(14);
			}
			else
			{
				alert("The Property value assigning process failed. May be it already exists.");
			}
		}
		
	}
}

function test23(id)
{
	alert(document.getElementById(id));
	}