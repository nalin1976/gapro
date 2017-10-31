
var xmlHttp;
var altxmlHttp;
var ArrayID = "";
var ArrayOffset = "";
var AllowableCharators=new Array("38","37","39","40","8","45");

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

function LoadLeadTime()
{
	ClearTableData();
	RemoveCurrentCombo("cboleadtime");
	var buyerId = document.getElementById("cbocustomer").value;

	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadLeadTime ;
	xmlHttp.open("GET",'eventtemplatesGet.php?RequestType=LoadLeadTime&BuyerId=' + buyerId,true);
	xmlHttp.send(null);
}

//Populate LeadTimes for Particular Customer
function HandleLoadLeadTime()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
		    //alert(xmlHttp.responseText);
			var XMLLeadTimeName = xmlHttp.responseXML.getElementsByTagName("LeadTimeName");
			var opt = document.createElement("option");
			opt.text = "";				
			document.getElementById("cboleadtime").options.add(opt);
				//alert(xmlHttp.responseText);
			 for ( var loop = 0; loop < XMLLeadTimeName.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLLeadTimeName[loop].childNodes[0].nodeValue;
				opt.value = XMLLeadTimeName[loop].childNodes[0].nodeValue;
				document.getElementById("cboleadtime").options.add(opt);
			 }
		}		
	}
}

//Clear ListBox
function RemoveCurrentCombo(comboname)
{
	var index = document.getElementById(comboname).options.length;
	while(document.getElementById(comboname).options.length > 0) 
	{
		index --;
		document.getElementById(comboname).options[index] = null;
	}
}

//Load Events Existing for a Particular Customer & LeadTime
function LoadEventsforLeadTime()
{
	var buyerId = document.getElementById("cbocustomer").value;
	var leadTime = document.getElementById("cboleadtime").value;

	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadEventsforLeadTime ;
	xmlHttp.open("GET",'eventtemplatesGet.php?RequestType=LoadEventsforLeadTime&BuyerId='+ buyerId +'&LeadTime='+ leadTime ,true);
	xmlHttp.send(null);
}

//Loading Events for Customer LeadTime
function HandleLoadEventsforLeadTime()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
		//alert(xmlHttp.responseText);
			//var XMLEventID = xmlHttp.responseXML.getElementsByTagName("ID");
			var XMLEventID = xmlHttp.responseXML.getElementsByTagName("ID");
			var XMLEvent = xmlHttp.responseXML.getElementsByTagName("EventName");
			var XMLOffset = xmlHttp.responseXML.getElementsByTagName("Offset");
			var XMLSelected = xmlHttp.responseXML.getElementsByTagName("Selected");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblevents\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"27\"  class=\"mainHeading2\"></td>"+
                                  "<td width=\"48\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Select</td>"+
                                  "<td width=\"271\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Event Name</td>"+
                                  "<td width=\"112\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Offset</td>"+
                                "</tr>";
			 for ( var loop = 0; loop < XMLEvent.length; loop ++)
			 {
				var selection = "";
				
				if (XMLSelected[loop].childNodes[0].nodeValue == "True")
					selection = "<input type=\"checkbox\" name=\"chkdel\" id=\"chkdel\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" />";
				else
					selection = "<input type=\"checkbox\" name=\"chkdel\" id=\"chkdel\" onclick=\"checkUncheckTextBox(this);\" />";
					
				tableText +=" <tr>" +
							" <td class=\"normalfntMid\"> " +
							" <div align=\"center\"><img src=\"../../images/edit.png\" alt=\"edit\" width=\"15\" height=\"15\" /></div> " +
							" </td> " +
							" <td class=\"normalfntMid\"><div align=\"center\"> " + selection + "</div> " +
							" </td>" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLEventID[loop].childNodes[0].nodeValue + "\" > "+ XMLEvent[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"width:50px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" value=\""+ XMLOffset[loop].childNodes[0].nodeValue +"\"> " +
							"</input></td>" +
							" </tr>";
							
			 }
			tableText += "</table>";
			document.getElementById('divcons').innerHTML=tableText;
		}		
	}
}

//Loading Events for New Customer LeadTime


//Clear Event Table Data
function ClearTableData()
{
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblevents\"  border=\"0\" >"+
                                "<tr>"+
                                  "<td width=\"27\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Edit</td>"+
                                  "<td width=\"48\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Select</td>"+
                                  "<td width=\"271\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Event Name</td>"+
                                  "<td width=\"112\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Offset</td>"+
                                "</tr>"+
								"<tr bgcolor=\"#D6E7F5\"><td class=\"normalfnt\">"+" "+"</td><td></td><td></td><td></td></tr>"
							"</table>";
			document.getElementById('divcons').innerHTML=tableText;
}

//Dynamically create new textbox and ok button to add new leadtime
function DrawNewLeadTimeTextBox()
{
			var tableText = "<input type=\"text\" id=\"txtnewleadtime\" name=\"txtnewleadtime\" class=\"txtbox\" style=\"width:75px\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\" ></input>";
			document.getElementById('divnewleadtime').innerHTML=tableText;
			document.getElementById('txtnewleadtime').focus();
			var tableText1 = "<img id=\"btnok\" name=\"btnok\" src=\"../../images/ok.png\" alt=\"Ok\" width=\"75\" height=\"20\" align=\"left\" class=\"mouseover\" onclick=\"AddNewLeadTime();\"/>";
			document.getElementById('divnewleadtimeok').innerHTML=tableText1;
}

//Add new leadtime & display events with zero figures
function AddNewLeadTime()
{
	if(compareTextboxVsSelectList() == true)
	{
		ClearTableData();
		RemoveCurrentCombo("cboleadtime");
		var opt = document.createElement("option");
		opt.text = document.getElementById("txtnewleadtime").value;		
		opt.value = document.getElementById("txtnewleadtime").value;	
		document.getElementById("cboleadtime").options.add(opt);
		DisposeNewLeadTimeControls();
		LoadAllEvents();
	}
}
//destroy dynamically created textbox & image button
function DisposeNewLeadTimeControls()
{
		var txtbox = document.getElementById('txtnewleadtime');
		txtbox.parentNode.removeChild(txtbox);
		var imgbtn = document.getElementById('btnok');
		imgbtn.parentNode.removeChild(imgbtn);
}

//Load All Events into Table
function LoadAllEvents()
{
	createXMLHttpRequest();
//	xmlHttp.onreadystatechange = HandleLoadEventsforLeadTime ;
	xmlHttp.onreadystatechange = HandleLoadEventsforNewLeadTime ;
	xmlHttp.open("GET",'eventtemplatesGet.php?RequestType=LoadAllEvents',true);
	xmlHttp.send(null);
}

function HandleLoadEventsforNewLeadTime()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
// alert("Lead Time Added");
			//var XMLEventID = xmlHttp.responseXML.getElementsByTagName("ID");
			var XMLEventID = xmlHttp.responseXML.getElementsByTagName("ID");
			var XMLEvent = xmlHttp.responseXML.getElementsByTagName("EventName");
			var XMLOffset = xmlHttp.responseXML.getElementsByTagName("Offset");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblevents\">"+
                                "<tr>"+
                                  "<td width=\"27\" bgcolor=\"#498CC2\" class=\"mainHeading2\"></td>"+
                                  "<td width=\"48\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Select</td>"+
                                  "<td width=\"271\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Event Name</td>"+
                                  "<td width=\"112\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Offset</td>"+
                                "</tr>";
			 for ( var loop = 0; loop < XMLEvent.length; loop ++)
			 {
				tableText +=" <tr>" +
							" <td class=\"normalfntMid\"> " +
							" <div align=\"center\"><img src=\"../../images/edit.png\" alt=\"edit\" width=\"15\" height=\"15\" /></div> " +
							" </td> " +
							" <td class=\"normalfntMid\"><div align=\"center\"> " +
							" <input type=\"checkbox\" name=\"chkdel\" id=\"chkdel\" onclick=\"checkUncheckTextBox(this);\" /></div> " +
							" </td>" +
							" <td class=\"normalfntMid\" align=\"left\" id=\"" + XMLEventID[loop].childNodes[0].nodeValue + "\" > "+ XMLEvent[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"width:50px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" value=\""+ XMLOffset[loop].childNodes[0].nodeValue +"\"> " +
							"</input></td>" +
							" </tr>";
			 }
			tableText += "</table>";
			document.getElementById('divcons').innerHTML=tableText;
		}		
	}
}

//Save EventTemplates
function SaveEventTemplates()
{
	if(ValidateHeaderDets())
	{	
		var buyerId = document.getElementById("cbocustomer").value;
		var leadTime = document.getElementById("cboleadtime").value;

// Saving Event Template Header
		createXMLHttpRequest();
    	xmlHttp.onreadystatechange = HandleSavingHeader;
    	xmlHttp.open("GET",'eventtemplatesGet.php?RequestType=SaveEventTemplateHeader&BuyerID=' + buyerId + '&LeadTime='+ leadTime , true);
    	xmlHttp.send(null);
		
		ArrayID = "";
		ArrayOffset = "";
		var tbl = document.getElementById('tblevents');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[1].childNodes[0].childNodes[1].checked)
			{
				var eventId = tbl.rows[loop].cells[2].id;
				var eventNm = tbl.rows[loop].cells[2].childNodes[0].value;
				var offset =  tbl.rows[loop].cells[3].childNodes[0].value;
	
				if (eventId.length > 0)
				{
					if (offset.length > 0)
					{
						ArrayID += eventId + ",";
						ArrayOffset += offset + ",";
					}
				 }
			}
			 //alert(loop);
		}
		//document.write(ArrayOffset);
	}
}

function HandleSavingHeader()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
/*			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{*/
			var XMLOutput = xmlHttp.responseXML.getElementsByTagName("Save");
			if(XMLOutput[0].childNodes[0].nodeValue == "True")
			{
				var XMLID = xmlHttp.responseXML.getElementsByTagName("ID");
				var XMLSerialNO = XMLID[0].childNodes[0].nodeValue;
				SaveEventTemplateDetails(XMLSerialNO,ArrayID,ArrayOffset);
			}
			else
			{
				alert("The event template header save failed.");	
//				document.getElementById('txtevent').focus();
			}
		}		
	}
}

function ValidateHeaderDets()
{
	if (document.getElementById('cbocustomer').value.trim() == "" )	
	{
		alert("Please select a buyer ");
		return false;
	}
	if (document.getElementById('cboleadtime').value.trim() == "" )	
	{
		alert("Please select a leadtime ");
		return false;
	}
	return true;
}




function SaveEventTemplateDetails($XMLSerialNO,$ArrayID,$ArrayOffset)
{
	// Saving Event Template Details
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleSavingDetails;
	altxmlHttp.open("GET",'eventtemplatesGet.php?RequestType=SaveEventTemplateDetails&SerialNo=' + $XMLSerialNO + '&ArrayID=' + ArrayID + '&ArrayOffset='+ ArrayOffset , true);
	altxmlHttp.send(null);	
	
	//ClearTableData();

}

function HandleSavingDetails()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        { 
			var XMLResult = altxmlHttp.responseXML.getElementsByTagName("Result");
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("The event template saved successfully.");	
				ClearTableData();
				document.getElementById('cbocustomer').focus();
				document.getElementById('cbocustomer').text = "";
				document.getElementById('cboleadtime').text = "";
				document.getElementById('cbocustomer').value = "";
				document.getElementById('cboleadtime').value = "";
				//document.getElementById(cboleadtime).options[0] = null;
		var txtbox = document.getElementById('txtnewleadtime');
		if(txtbox != null){
		txtbox.parentNode.removeChild(txtbox);
		}
		var imgbtn = document.getElementById('btnok');
		if(imgbtn != null){
		imgbtn.parentNode.removeChild(imgbtn);
		}
		
				document.getElementById('cbocustomer').focus();
				document.getElementById('cbocustomer').value = "";
				document.getElementById('cboleadtime').value = "";
			}
			else
			{
				alert("The event template save failed.");	
			}
		}		
	}
}

//*** Control Functions ***/
function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblevents');
	var rw = objevent.parentNode.parentNode.parentNode;
	
	if (rw.cells[1].childNodes[0].childNodes[1].checked)
	{
		if(rw.cells[3].childNodes[0].value == "")
			rw.cells[3].childNodes[0].value = "0";
			rw.cells[3].childNodes[0].focus();
	}
	else
	{
		//rw.cells[3].childNodes[0].value = "";
		rw.cells[3].childNodes[0].focus();
	}

}

function compareTextboxVsSelectList()
{
	var x = document.getElementById('cboleadtime');
	var y = document.getElementById('txtnewleadtime');
	
	z = parseInt(x.length);
	//alert(z);
	if(document.getElementById('cbocustomer').value==""){
			alert("Please Select a Customer !");
			return false;
			//break;
	}
	
	
	for(var i=0; i < z ; i++)
	{
		if(x.options[i].value == y.value)
		{
			alert("Leadtime already exist !");
			return false;
			break;
		}
	}
	return true;
}

function checkAll(obj)
{
	var tbl = document.getElementById('tblevents');
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[1].childNodes[0].childNodes[1].checked = true;
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[1].childNodes[0].childNodes[1].checked = false;
		}
	}
}

//----------------------------------------------REPORT--------------------------------------------------

function listORDetails()
{
	 document.frmEventTemplate.radioListORdetails[0].checked = false;
	 document.frmEventTemplate.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}

function loadReport(){ 
 if(document.frmEventTemplate.radioListORdetails[0].checked == true){
	    var cbosearch = document.getElementById('cbocustomer').value;
	    var cboTime = document.getElementById('cboleadtime').value;
	    var radioListORdetails = document.frmEventTemplate.radioListORdetails[0].value;
		window.open("templateReportList.php?cbocustomer=" + cbosearch); 
 }else{
	  var cbosearch = document.getElementById('cbocustomer').value;
	    var cboTime = document.getElementById('cboleadtime').value;
	  if((cbosearch != "") && (cboTime != "")){
	  var radioListORdetails = document.frmEventTemplate.radioListORdetails[1].value;
      window.open("templateReportDetails.php?cbocustomer=" + cbosearch + "&cboTime=" + cboTime); 
	  }else if((cbosearch == "")){
		alert("Please Select a Customer");  
	  }
	  else{
		alert("Please Select a Load Time");  
	 }
}
}
