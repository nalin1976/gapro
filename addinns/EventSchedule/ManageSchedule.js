
var xmlHttp;
var altxmlHttp;

var tableHeader = "<tr>"+
                "<td width=\"30%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Event</td>"+
                "<td width=\"10%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Estimated Date</td>"+
                "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Change Date</td>"+
                "<td width=\"20%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Changed Reason</td>"+
                "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Completed Date</td>"+
				"<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\"><input type=\"checkbox\"/></td>"+
				"<td width=\"7%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" align=\"left\">Delay</td>"+
              "</tr>" ;
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

function LoadStyles()
{
	RemoveCurrentCombo("cbostyle");

	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadStyles ;
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=LoadStyles',true);
	xmlHttp.send(null);
}

function HandleLoadStyles()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("Style");
			var opt = document.createElement("option");
			opt.text = "";				
			document.getElementById("cbostyle").options.add(opt);
				
			 for ( var loop = 0; loop < XMLStyle.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLStyle[loop].childNodes[0].nodeValue;
				opt.value = XMLStyle[loop].childNodes[0].nodeValue;
				document.getElementById("cbostyle").options.add(opt);
			 }
		}		
	}
}

function LoadDeliveryDates()
{
	document.getElementById('tblschedule').innerHTML = tableHeader;
	RemoveCurrentCombo("cbodelivery");
	RemoveCurrentCombo("cboBuyerPO");
	var styleId = document.getElementById("cbostyle").value;
	//alert (styleId);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadDeliveryDates ;
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=LoadDeliveryDates&styleId=' + URLEncode(styleId),true);
	xmlHttp.send(null);
}

function HandleLoadDeliveryDates()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var XMLDeliveryDate = xmlHttp.responseXML.getElementsByTagName("DeliveryDate");
			var XMLDisplayDate = xmlHttp.responseXML.getElementsByTagName("DisplayDate");
			var opt = document.createElement("option");
			opt.text = "Select One";			
			opt.value = "Select One";		
			document.getElementById("cbodelivery").options.add(opt);
				
			 for ( var loop = 0; loop < XMLDeliveryDate.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLDisplayDate[loop].childNodes[0].nodeValue;
				opt.value = XMLDeliveryDate[loop].childNodes[0].nodeValue;
				document.getElementById("cbodelivery").options.add(opt);
			 }
		}		
	}
}

function LoadBuyerPO()
{
	var styleId = document.getElementById("cbostyle").value;
	var delDate = document.getElementById("cbodelivery").value;
	 styleId = "'"+styleId+"'";
	 delDate = "'"+delDate+"'";
 loadCombo("SELECT strBuyerPONO,strBuyerPONO FROM eventscheduleheader WHERE strStyleId = "+styleId+" AND dtDeliveryDate = "+delDate+"",'cboBuyerPO');
		
}



function LoadEventScheduleData()
{
	document.getElementById('tblschedule').innerHTML = tableHeader;
	var styleId = document.getElementById("cbostyle").value;
	var deliveryDate = document.getElementById("cbodelivery").value;
	var buyerPO = document.getElementById("cboBuyerPO").value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadEventScheduleData ;
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=LoadEventScheduleData&StyleId='+ URLEncode(styleId) +'&DeliveryDate='+ deliveryDate + '&buyerPO=' + URLEncode(buyerPO) ,true);
	xmlHttp.send(null);
}

function HandleLoadEventScheduleData()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 			
			var XMLScheduleID 		= xmlHttp.responseXML.getElementsByTagName("ScheduleID");
			var XMLEventID 			= xmlHttp.responseXML.getElementsByTagName("EventID");
			var XMLEvent		 	= xmlHttp.responseXML.getElementsByTagName("Event");
			var XMLEstDate 			= xmlHttp.responseXML.getElementsByTagName("EstDate");
			var XMLChngDate			= xmlHttp.responseXML.getElementsByTagName("ChngDate");
			var XMLCompDate 		= xmlHttp.responseXML.getElementsByTagName("CompDate");
			var XMLChngReason 		= xmlHttp.responseXML.getElementsByTagName("ChngReason");
			var XMLDateDiff 		= xmlHttp.responseXML.getElementsByTagName("DateDiff");
			var XMLChangeDateDiff 	= xmlHttp.responseXML.getElementsByTagName("ChaneDateDiff");
			var XMLStatus			= xmlHttp.responseXML.getElementsByTagName("Status");
			var XMLProssDiff		= xmlHttp.responseXML.getElementsByTagName("ProssDiff");			

			document.getElementById('tdStatus').innerHTML = "";
			if(XMLScheduleID.length<=0)
				return;
				
			if(XMLStatus[0].childNodes[0].nodeValue =='0')
			{
				document.getElementById('tdStatus').innerHTML = "";
				document.getElementById('butSave').style.visibility = "visible";
				document.getElementById('butSendToApprove').style.visibility = "visible";
			}
			else if(XMLStatus[0].childNodes[0].nodeValue =='1')
			{
				document.getElementById('tdStatus').innerHTML = "This Style Send For Approval";
				document.getElementById('butSave').style.visibility = "hidden";
				document.getElementById('butSendToApprove').style.visibility = "hidden";
			}
			else if(XMLStatus[0].childNodes[0].nodeValue =='2')
			{
				document.getElementById('tdStatus').innerHTML = "This Style Is Approved";
				document.getElementById('butSave').style.visibility = "hidden";
				document.getElementById('butSendToApprove').style.visibility = "hidden";
			}
			
			var tableText = "";
			 for ( var loop = 0; loop < XMLScheduleID.length; loop ++)
			 {	
			  var booImage = false;
			  
			 	var className = "bcgcolor-tblrowWhite";			 
				
				if (XMLDateDiff[loop].childNodes[0].nodeValue > 0 && XMLCompDate[loop].childNodes[0].nodeValue == "")
					className = "bcgcolor-notify";
				
				if(XMLDateDiff[loop].childNodes[0].nodeValue == 0)
					className = "bcgcolor-normal";			
					
				if(XMLDateDiff[loop].childNodes[0].nodeValue < 0 && XMLDateDiff[loop].childNodes[0].nodeValue > -2)
					className = "bcgcolor-tblrow";				
					
				if(XMLChangeDateDiff[loop].childNodes[0].nodeValue < 0 && XMLChangeDateDiff[loop].childNodes[0].nodeValue > -2)
					className = "bcgcolor-tblrow";
					
				if(XMLChangeDateDiff[loop].childNodes[0].nodeValue == 0 && XMLChangeDateDiff[loop].childNodes[0].nodeValue != "")
					className = "bcgcolor-normal";
					
				if(XMLCompDate[loop].childNodes[0].nodeValue != "")
					className = "bcgcolor-green";
					
				
				var delImage = "<img src=\"../images/del.png\" id=\"butDel\" name=\"butDel\" alt=\"delete\" />";
					
				tableText +="<tr class=\"" + className + "\" onmouseover=\"this.style.background =\'#D6E7F5'\" onmouseout=\"this.style.background=\''\">" +
							" <td height=\"20\" class=\"normalfnt\" align=\"left\" id=\"" + XMLEventID[loop].childNodes[0].nodeValue + "\" ><img src=\"../images/del.png\" id=\"butDel\" name=\"butDel\" alt=\"delete\" onclick='deleteRow(this);'/>"+ XMLEvent[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" id=\"" + XMLScheduleID[loop].childNodes[0].nodeValue + "\" > "+ XMLEstDate[loop].childNodes[0].nodeValue +"</td>";
					
							if (XMLChngDate[loop].childNodes[0].nodeValue != "")
							{
								var chngDate = XMLChngDate[loop].childNodes[0].nodeValue;
								var chngDateY = chngDate.substr(0,4);
								var chngDateM = chngDate.substr(5,2);
								var chngDateD = chngDate.substr(8,2);
								chngDate = chngDateD + "/" + chngDateM + "/" + chngDateY;
							}
							else
							{
								var chngDate = "";
							}
							tableText +="<td  class=\"normalfntMid\"><input name=\"chngdate\" type=\"text\" class=\"txtbox normalfntMid\" id=\"chngdate"+loop+"\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeydown=\"deleteText(event,this);\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+ chngDate +"\" /><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"></td>"+
							
							
							" <td class=\"normalfntMid\"><input name=\"chngreason\" type=\"text\" class=\"txtbox\" style=\"margin-left:5px;margin-right:5px\" id=\"chngreason\" size=\"25\"  maxlength=\"50\" value=\""+ XMLChngReason[loop].childNodes[0].nodeValue +"\" />"+
							"</td>";
							
							if (XMLCompDate[loop].childNodes[0].nodeValue != "")
							{
								var compDate = XMLCompDate[loop].childNodes[0].nodeValue;
								var compDateY = compDate.substr(0,4);
								var compDateM = compDate.substr(5,2);
								var compDateD = compDate.substr(8,2);
								compDate = compDateD + "/" + compDateM + "/" + compDateY;
							}
							else
							{
								var compDate = "";
							}
							
							if(compDate == "")
							tableText +="<td  class=\"normalfntMid\"><input name=\"compdate\" type=\"text\" class=\"txtbox normalfntMid\" id=\"compdate"+loop+"\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeydown=\"deleteText(event,this);\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+ compDate +"\" /><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"></td>";							
							else
							tableText +="<td  class=\"normalfntMid\"><input name=\"compdate\" type=\"text\" class=\"txtbox normalfntMid\" id=\"compdate"+loop+"\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeydown=\"deleteText(event,this);\" onkeypress=\"return ControlableKeyAccess(event);\"  value=\""+ compDate +"\" /><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"></td>";
							
							if(compDate == ""){
								tableText += "<td class=\"normalfntMid\"><input type=\"checkbox\" onclick=\"GetDate(this);\"/></td>";		
							}
							else{
								tableText += "<td class=\"normalfntMid\"><input type=\"checkbox\" onclick=\"GetDate(this);\" checked=\"checked\" disabled=\"disabled\"/></td>";					
							}
							
							tableText += "<td class=\"normalfntMid\">"+ XMLProssDiff[loop].childNodes[0].nodeValue +"</td>"+
							" </tr>";							
			 }
		
			document.getElementById('tblschedule').innerHTML+=tableText;
		}		
	}
}

function deleteRow(objDel){
var tblMain = objDel.parentNode.parentNode.parentNode;
var rowNo = objDel.parentNode.parentNode.rowIndex;
document.getElementById('tblschedule').deleteRow(rowNo);
}

function SaveEventSchedule()
{
	if(ValidateHeaderDets())
	{	
		var styleId = document.getElementById("cbostyle").value;
		var deliveryDate = document.getElementById("cbodelivery").value;

		ArrscheduleID = "";
		ArreventID = "";
		ArrchngDate = "";
		ArrchngReason = "";
		ArrcompDate = "";
		
		var tbl = document.getElementById('tblschedule');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var scheduleID = tbl.rows[loop].cells[1].id;
			var eventID = tbl.rows[loop].cells[0].id;
			var chngDate =  tbl.rows[loop].cells[2].childNodes[0].value;
			var chngReason =  tbl.rows[loop].cells[3].childNodes[0].value;
			var compDate =  tbl.rows[loop].cells[4].childNodes[0].value;

			if (scheduleID.length > 0 && (chngDate != "" || compDate != "") )
			{
					ArrscheduleID += scheduleID + ",";
					ArreventID += eventID + ",";
					ArrchngDate += chngDate + ",";
					ArrchngReason += URLEncode(chngReason) + ",";
					ArrcompDate += compDate + ",";
			 } 
		}
		
		// Saving Event schedule
		createXMLHttpRequest();
    	xmlHttp.onreadystatechange = HandleSaveEventSchedule;
    	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=SaveEventSchedule&StyleId=' + URLEncode(styleId) + '&DeliveryDate='+ deliveryDate + '&ArrscheduleID='+ ArrscheduleID + '&ArreventID='+ ArreventID + '&ArrchngDate=' + ArrchngDate + '&ArrchngReason=' + ArrchngReason + '&ArrcompDate=' + ArrcompDate , true);
    	xmlHttp.send(null);

	}
}

function HandleSaveEventSchedule()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var XMLOutput = xmlHttp.responseXML.getElementsByTagName("Save");
			if(XMLOutput[0].childNodes[0].nodeValue == "True")
			{
				LoadEventScheduleData();
				alert("The event schedule save successful! ");
				//document.getElementById('cbostyle').focus();
				//document.getElementById('cbostyle').value = "";
				//document.getElementById('cbodelivery').value = "";
			}
			else
			{
				alert("The event schedule save failed.");	
			}
		}		
	}
}

function ValidateHeaderDets()
{
	if (document.getElementById('cbostyle').value == "" )	
	{
		alert("Please select a style ");
		return false;
	}
	if (document.getElementById('cbodelivery').value == "" )	
	{
		alert("Please select a delivery date");
		return false;
	}
	
	var tbl = document.getElementById('tblschedule');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var scheduleID = tbl.rows[loop].cells[1].id;
		var eventID = tbl.rows[loop].cells[0].id;
		var eventName = tbl.rows[loop].cells[0].childNodes[0].nodeValue;
		var chngDate =  tbl.rows[loop].cells[2].childNodes[0].value;
		var chngReason =  tbl.rows[loop].cells[3].childNodes[0].value;
		var compDate =  tbl.rows[loop].cells[4].childNodes[0].value;
		if(chngDate != "" && chngReason == "" )
		{
			alert("Changed reason for the following event is not available. Please enter reason for the date change and press save.\n\nEvent Name : " + eventName + "\nChanged Date : " + chngDate);
			tbl.rows[loop].cells[3].childNodes[0].focus();
			return false;
		}
		
	}

		
	
	return true;
}


//Utility Function
function RemoveCurrentCombo(comboname)
{
	var index = document.getElementById(comboname).options.length;
	while(document.getElementById(comboname).options.length > 0) 
	{
		index --;
		document.getElementById(comboname).options[index] = null;
	}
}

//Calendar Control
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
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
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


function deleteText(evt,obj)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	if(charCode == 46)
	obj.value = "";
}
//Start 05-05-2010 
function SendToApproval()
{
	var styleId = document.getElementById("cbostyle").value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleSendToApproval;
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=SendToApproval&StyleId=' + URLEncode(styleId) , true);
	xmlHttp.send(null);	
}
	function HandleSendToApproval()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
		{
			alert ("Style name send to approved");
			document.getElementById('butSendToApprove').style.visibility = "hidden";
			document.getElementById('butSave').style.visibility = "hidden";
		}
	}
function GetDate(obj)
{
	var rw = obj.parentNode.parentNode;
	if(!obj.checked){
		rw.childNodes[7].childNodes[0].value = "";
		return;
	}
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = GetDateRequest;
	
	xmlHttp.index = rw;
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=GetDate' , true);
	xmlHttp.send(null);	
}
	function GetDateRequest()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
		{			
			var XMLCurrentDatet = xmlHttp.responseXML.getElementsByTagName("CurrentDate");						
			var rw = xmlHttp.index;
			rw.childNodes[7].childNodes[0].value = XMLCurrentDatet[0].childNodes[0].nodeValue;
		}
	}
function AddNewItemToPage()
{
/*	var tbl = document.getElementById('tblschedule');
	var maxCount = 0;
	for (loop=1;loop<tbl.rows.length;loop++)
	{
		var test= tbl.rows[loop].cells[0].id;
		maxCount = Math.max(maxCount,test);
	}
	alert(maxCount);*/
	//AddRow();
	var styleName	= document.getElementById('cbostyle').value;
	var deliveryDate	= document.getElementById('cbodelivery').value;
	var eventName	= document.getElementById('cboEvent').options[document.getElementById('cboEvent').selectedIndex].text;
	var eventId		= document.getElementById('cboEvent').value;
	var offSet		= document.getElementById('txtOffSet').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = AddNewItemToPageRequest;	
	xmlHttp.open("GET",'ManageScheduleXML.php?RequestType=UpdateRow&styleName='+styleName+'&deliveryDate='+deliveryDate+ '&eventId='+eventId+'&offSet='+offSet , true);
	xmlHttp.send(null);
}
function AddNewItemToPageRequest()
{
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
	{
		
		
		var XMLAvailablet = xmlHttp.responseXML.getElementsByTagName("Available");
		if(XMLAvailablet[0].childNodes[0].nodeValue=="TRUE"){
			alert("Sorry!\n This item already added.");
			return;
		}
		
		var XMLEventId = xmlHttp.responseXML.getElementsByTagName("EventId");
		var XMLEventName = xmlHttp.responseXML.getElementsByTagName("EventName");
		var XMLScheduleId = xmlHttp.responseXML.getElementsByTagName("ScheduleId");
		var XMLEstimateDate = xmlHttp.responseXML.getElementsByTagName("EstimateDate");
		var XMLChangeDate = xmlHttp.responseXML.getElementsByTagName("ChangeDate");
		var XMLChangeReason = xmlHttp.responseXML.getElementsByTagName("ChangeReason");
		var XMLCompleteDate = xmlHttp.responseXML.getElementsByTagName("CompleteDate");
		var XMLDateDiff = xmlHttp.responseXML.getElementsByTagName("DataDiff");		
		var XMLChangediff = xmlHttp.responseXML.getElementsByTagName("Changediff");	
		
		var tbl			= document.getElementById('tblschedule');
		var lastRow 	= tbl.rows.length;	
		var row			= tbl.insertRow(lastRow);	
		
		var className = "bcgcolor-tblrowWhite";			 
		
		if (XMLDateDiff[0].childNodes[0].nodeValue > 0 && XMLCompleteDate[0].childNodes[0].nodeValue == "")
		className = "bcgcolor-notify";
		
		if(XMLDateDiff[0].childNodes[0].nodeValue == 0)
		className = "bcgcolor-normal";			
		
		if(XMLDateDiff[0].childNodes[0].nodeValue < 0 && XMLDateDiff[0].childNodes[0].nodeValue > -2)
		className = "bcgcolor-tblrow";				
		
		if(XMLChangediff[0].childNodes[0].nodeValue < 0 && XMLChangediff[0].childNodes[0].nodeValue > -2)
		className = "bcgcolor-tblrow";
		
		if(XMLChangediff[0].childNodes[0].nodeValue == 0 && XMLChangediff[0].childNodes[0].nodeValue != "")
		className = "bcgcolor-normal";
		
		if(XMLCompleteDate[0].childNodes[0].nodeValue != "")
		className = "bcgcolor-green";
		
		row.className	= className;
		
		var cell 		= row.insertCell(0);	
		cell.className 	= "normalfnt";
		cell.id 		= XMLEventId[0].childNodes[0].nodeValue;
		cell.innerHTML 	= XMLEventName[0].childNodes[0].nodeValue;
		
		var cell 		= row.insertCell(1);
		cell.className 	= "normalfntMid";
		cell.id 		= XMLScheduleId[0].childNodes[0].nodeValue;
		cell.innerHTML 	= XMLEstimateDate[0].childNodes[0].nodeValue;
		
		var cell 		= row.insertCell(2);
		cell.className 	= "normalfnt";	
		cell.innerHTML 	= "<input name=\"chngdate\" type=\"text\" class=\"txtbox normalfntMid\" id=\"chngdate"+lastRow+1+"\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeydown=\"deleteText(event,this);\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+ XMLChangeDate[0].childNodes[0].nodeValue +"\" /><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\">";
		
		var cell 		= row.insertCell(3);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<input name=\"chngreason\" type=\"text\" class=\"txtbox\" style=\"margin-left:5px;margin-right:5px\" id=\"chngreason\" size=\"25\"  maxlength=\"50\" value=\""+ XMLChangeReason[0].childNodes[0].nodeValue +"\" />";
		
		var cell 		= row.insertCell(4);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input name=\"compdate\" type=\"text\" class=\"txtbox normalfntMid\" id=\"compdate"+lastRow+1+"\" size=\"15\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeydown=\"deleteText(event,this);\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+ XMLCompleteDate[0].childNodes[0].nodeValue +"\" /><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\">";
		
		var cell 		= row.insertCell(5);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<input type=\"checkbox\" onclick=\"GetDate(this);\"/>";
		
		var cell 		= row.insertCell(6);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= XMLDateDiff[0].childNodes[0].nodeValue;				
	}
}
//End 05-05-2010