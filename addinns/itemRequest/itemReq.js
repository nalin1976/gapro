// JavaScript Document
function getSubCat()
{
	var mainCat = $("#cboMainCat").val();
	var url = 'itemReqmiddle.php?RequestType=LoadSubcat';	
		url += '&mainCat='+mainCat;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 $("#cboSubCat").html(htmlobj.responseXML.getElementsByTagName("SubCat")[0].childNodes[0].nodeValue);
}

function loadAssignProperties()
{
	RemoveAllRows('tblValues');
	var subCat = $("#cboSubCat").val();
	
	var url = 'itemReqmiddle.php?RequestType=loadPropertyDetails';
		url += '&subCat='+subCat;
	
	htmlobj=$.ajax({url:url,async:false});
	
	var tblhtml = $("#tblValues").html();
	tblhtml += htmlobj.responseXML.getElementsByTagName("propertyData")[0].childNodes[0].nodeValue;
	$("#tblValues").html(tblhtml);
	LoadAvailableUnits();
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
		// alert(1);
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
								  "<td width=\"7%\"><img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeLayer();\" class=\"mouseover\" /></td></tr>"+
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
								"<select name=\"cboValues\" ondblclick=\"moveValueToTextBox(" + rowIndex  + "," + propValue +");\" size=\"10\" class=\"txtbox\" id=\"cboValues\" style=\"width:275px\">"+
								"</select>"+
							  "</div></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"22%\">&nbsp;</td>"+
								  "<td width=\"38%\" align=\"right\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closeLayer();\" class=\"mouseover\" /></td>"+
								  "<td width=\"40%\" align=\"right\"><img src=\"../../images/ok.png\" onClick=\"AddValueToList(" + rowIndex  + "," + propValue +")\" alt=\"close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"2\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
									"<tr>"+
									  "<td height=\"21\" colspan=\"3\" class=\"mainHeading2\">Value</td>"+
									  /*"<td height=\"21\" class=\"mainHeading2\"><img src=\"../../images/edit.png\" style=\"vertical-align:bottom;\" alt=\"Edit\" width=\"20\" height=\"15\" class=\"mouseover\" onclick=\"showPropertyValueModifyForm();\" /></td>"+*/
									"</tr>"+
									"<tr>"+
									  "<td width=\"58%\"><input maxlength=\"20\" tabindex=\"101\" name=\"txtNewValue\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=propertyValues&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"20\" /></td>"+
									  "<td width=\"26%\" align=\"right\"><input checked=\"checked\" tabindex=\"102\" align=\"right\" type=\"checkbox\" name=\"chkassignvalue\" id=\"chkassignvalue\" /></td>"+
									  "<td width=\"16%\" class=\"normalfnt\">Assign</td>"+
									"</tr>"+
									"<tr>"+
									  "<td colspan=\"3\" class=\"mbari13\"><div align=\"right\"><img tabindex=\"103\" src=\"../../images/addsmall.png\" id=\"butSave\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
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

function LoadApplicableValues(propValue)
{
	var url = 'itemReqmiddle.php?RequestType=getOtherProperties';	
		url += '&PropID='+propValue;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 $("#cboValues").html(htmlobj.responseXML.getElementsByTagName("PropName")[0].childNodes[0].nodeValue);
}

function moveValueToTextBox(rowIndex,propValue){
	document.getElementById('txtNewValue').value=URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text);	
		document.getElementById('txtNewValue').title=URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].value);	
}

function AddValueToList(rowIndex,propValue)
{
	var tblValues = document.getElementById("tblValues");
	var cbo = tblValues.rows[rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
	
	var val = $("#cboValues option:selected").text();
	var opt = document.createElement("option");
	opt.text = val;
	for(var i=0;i<cbo.options.length+1;i++){
					if(i==cbo.options.length){
						cbo.options.add(opt);						
						cbo.selectedIndex = cbo.options.length-1;
					}
					if(cbo.options[i].text==opt.text){
						i=cbo.options.length+1;
					}
				}
	closeLayer();
}
function LoadAvailableUnits()
{
	
	var url = '../../preordermiddletire.php?RequestType=GetUnits';
			
	htmlobj=$.ajax({url:url,async:false});
	 var XMLName = htmlobj.responseXML.getElementsByTagName("unit");
			 /*for ( var loop = 0; loop < XMLName.length; loop ++)
			 {
				var opt = document.createElement("option");
				var optp = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLName[loop].childNodes[0].nodeValue;
				optp.text = XMLName[loop].childNodes[0].nodeValue;
				optp.value = XMLName[loop].childNodes[0].nodeValue;
				document.getElementById("cboUnits").options.add(opt);
				document.getElementById("cboPurchaseUnit").options.add(optp);
			 }*/
			 
		 document.getElementById("cboUnits").innerHTML =  XMLName[0].childNodes[0].nodeValue
			  document.getElementById("cboPurchaseUnit").innerHTML =  XMLName[0].childNodes[0].nodeValue
}

function SaveValue(propID,rowIndex)
{    
//alert(document.getElementById("txtNewValue").value);

		var assivalu=0;
	 	if ($("#txtNewValue").val() == "" || $("#txtNewValue").val() == null)
		{
			document.getElementById("txtNewValue").focus();
			alert("Please enter the Value.");
			return;
		}
		else
		{
			var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				
				//alert(opt.text);
				//alert(opt.value);
				document.getElementById("cboValues").options.add(opt);
				if(document.getElementById("chkassignvalue").checked==true)
				{
					var tblValues = document.getElementById("tblValues");
					var cbo = tblValues.rows[rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
					var opt = document.createElement("option");
					opt.text = document.getElementById("txtNewValue").value;
					cbo.options.add(opt);
					//alert(cbo.options.length);
					cbo.selectedIndex= cbo.options.length-1;
					closeLayer();
				}
			}
		
	   
}

function Savenfinish()
{   
	if (!isDuplicateSelections())
	{
		return ;	
	}
	var mainCatID = $("#cboMainCat").val();
	var subCatID = $("#cboSubCat").val();
		
	var tbl = document.getElementById('tblValues');
	var CatCodes = ["FA", "AC", "PA","SE","OT"];
	var ItemCode = CatCodes[mainCatID-1] + "_" + subCatID + ",";
	var displayCode = CatCodes[mainCatID-1] + "_" + subCatID + "#";
	var propIDlist=",";
	var propValueIdList =",";
	var displayStrList = "";
	var strBeforeAfterList = "";
	var serialList = "";
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var PropID = tbl.rows[loop].cells[0].id;
		var propValue = tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value;

		
		var displayStr = tbl.rows[loop].cells[3].childNodes[0].value;
		var strBeforeAfter = tbl.rows[loop].cells[4].childNodes[0].value;
		if(strBeforeAfter == 'Before'){
			strBeforeAfter = 1;
		}
	   if(strBeforeAfter == 'After'){
			strBeforeAfter = 2;
		}

		var serial = tbl.rows[loop].cells[5].childNodes[0].lastChild.value;
	
		//bookmark
		ItemCode += PropID + "." + propValue + ",";
		displayCode += PropID + "." + propValue + "#";
		propIDlist+=PropID+",";
		propValueIdList+=propValue+",";
		
		displayStrList+=displayStr+",";
		strBeforeAfterList+=strBeforeAfter+",";
		serialList+=serial+",";	
	}
	
	//alert(propIDlist+ '**'+propValueIdList);
	
	var ItemName = $("#cboSubCat option:selected").text();
	
	if (mainCatID == 1)
	{
		if($("#cbofabric_content option:selected").text() != "");
		ItemName += " " + $("#cbofabric_content option:selected").text() ;
	}
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		for (var x = 1; x < tbl.rows.length ; x++)
		{
			var optValue = tbl.rows[x].cells[5].childNodes[0].childNodes[1].value;
			if (optValue == loop)
			{
				if (tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options.length <=0 )
				{
					alert("No values set for some properties. Please select proper values.");	
					return;
				}
				var valueName = tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options[tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].selectedIndex].text;
				
				if(tbl.rows[x].cells[2].childNodes[0].childNodes[1].checked )
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

	var wastage =$("#txtWastage").val();
	var unitPrice = $("#txtUnitPrice").val();
	var unitID  = $("#cboUnits option:selected").text();
	var purchaseID = $("#cboPurchaseUnit option:selected").text();
	//var MainCateID = mainID;
	
	
	if(confirm("The new item name will be as follows\n\n" + ItemName + "\n\nDo you wan't to continue with this."))
	{
		/*createXMLHttpRequest();	
    	xmlHttp.onreadystatechange = HandleMaterialSaving;
		//alert(strBeforeAfterList);
    	xmlHttp.open("GET", 'wizardmiddle.php?str=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + MainCateID + '&subCatID=' + subCatID+'&propValueIdList='+propValueIdList+'&propIDlist='+propIDlist+ '&Wastage=' + wastage + '&unitID=' + unitID + '&purchaseID=' + purchaseID + '&serialList=' + serialList + '&strBeforeAfterList=' + strBeforeAfterList + '&displayStrList=' + displayStrList +   '&unitPrice=' + unitPrice, true);
   	xmlHttp.send(null);*/
	
	var url = 'itemReqmiddle.php?RequestType=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + mainCatID + '&subCatID=' + subCatID+'&propValueIdList='+propValueIdList+'&propIDlist='+propIDlist+ '&Wastage=' + wastage + '&unitID=' + unitID + '&purchaseID=' + purchaseID + '&serialList=' + serialList + '&strBeforeAfterList=' + strBeforeAfterList + '&displayStrList=' + displayStrList +   '&unitPrice=' + unitPrice;
			
	htmlobj=$.ajax({url:url,async:false});
	var message = htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
	alert(message);
   }  
	
	
	
}

function isDuplicateSelections()
{
	var arr = [];
	var tbl = document.getElementById('tblValues');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var optValue = tbl.rows[loop].cells[5].childNodes[0].childNodes[1].value;
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
