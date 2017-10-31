var xmlHttp;

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

function getEstyy(objbtn)//styleId,EventScheduleMethod
{
	
	var row = objbtn.parentNode.parentNode;
	//var strStyle = row.cells[1].lastChild.nodeValue;
	var strStyle = row.cells[1].firstChild.value;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleGetEstyy;
	xmlHttp.open("GET", 'orderstatusmiddle.php?RequestType=getEstyy&StyleID=' + strStyle, true);
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

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
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
     popupbox.style.top = 168+ 'px';
     document.getElementById('frmAccyy').innerHTML=HTMLText; 
	 //popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
	
	
	
	
}

function getSizeRatios(objbtn)//styleId,EventScheduleMethod
{
	var row = objbtn.parentNode.parentNode;
	//alert(row)
	//var rowval = row.cells[1].lastChild.nodeValue;
	var rowval = row.cells[1].firstChild.value;
	//alert(rowval)
	//var color = row.cells[9].lastChild.nodeValue;
	var color = row.cells[9].firstChild.value;
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
				
				drawPopupArea(310,200,'frmSizeRatio');
				var strSizeTable="<div id=\"divSize\"  style=\"overflow:scroll; height:200px; width:320px;\">"+  
								"<table width=\"320\" cellpadding=\"0\" cellspacing=\"0\">"+
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
				popupbox.style.top = 168+ 'px';
				document.getElementById('frmSizeRatio').innerHTML=strSizeTable; 
				//popupbox.innerHTML = htmlText;     
				//alert(HTMLText)
				document.body.appendChild(popupbox);
			}
			
		}
	}
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

function StyleDetailSave()
{
	var row=document.getElementById("tblCaption").getElementsByTagName("TR")
	for(var loop=1;loop<row.length;loop++)
	{
		  var cell=row[loop].getElementsByTagName("TD")			 
		  var StyleID 			=cell[1].innerHTML;
		  var dblcm 			=cell[7].innerHTML;
		  var dblQty 			=cell[11].innerHTML;
		  var dtPLNDCutDate		=cell[14].innerHTML;
		  var ActCutDate		=cell[15].innerHTML;
		  var PLNDInputDate		=cell[16].innerHTML;
		  var ActInputDate		=cell[17].innerHTML;
		  var PLNDFinishDate	=cell[18].innerHTML;
		  var ActShipmentDate	=cell[19].innerHTML;
		  var ShipmentQTY 		=cell[20].innerHTML;
		  var plus_mines		=cell[21].innerHTML;
		  var FebPO				=cell[22].innerHTML;
		  var SMPL_YDG_RCVD 	=cell[23].innerHTML;
		  var Lab_Dip_Aprvd 	=cell[24].innerHTML;
		  var Fab_Test_Sent 	=cell[25].innerHTML;
		  var Feb_tet_Passd 	=cell[26].innerHTML;
		  var Bulk_Approved 	=cell[27].innerHTML;
		  var Fab_Inspect 		=cell[28].innerHTML;
		  var PITN_ORG_SMP_TGT 	=cell[29].innerHTML;
		  var PTTD_RCVD 		=cell[30].innerHTML;
		  var ORG_SMPL_RCVD 	=cell[31].innerHTML;
		  var SIZE_QTY 			=cell[32].innerHTML;
		  var SIZE_SIZE 		=cell[33].innerHTML;
		  var SIZE_TGT 			=cell[34].innerHTML;
		  var SIZE_SENT 		=cell[35].innerHTML;
		  var SIZE_APVD 		=cell[36].innerHTML;
		  var GoldSeal_SIZE 	=cell[37].innerHTML;
		  var GoldSeal_TGT 		=cell[38].innerHTML;
		  var GoldSeal_SENT 	=cell[39].innerHTML;
		  var GoldSeal_APVD 	=cell[40].innerHTML;
		  var GoldSeal_QTY 		=cell[41].innerHTML;
		  var TESTING_QTY 		=cell[42].innerHTML;
		  var TESTING_SIZE 		=cell[43].innerHTML;
		  var TESTING_TGT 		=cell[44].innerHTML;
		  var TESTING_SENT 		=cell[45].innerHTML;
		  var TESTING_APVD		=cell[46].innerHTML;
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleSaveStyleDetails;
		xmlHttp.open("GET", 'orderstatusmiddle.php?RequestType=saveStyleDetails&StyleID=' + StyleID + '&dblcm=' +  dblcm + '&=dblQty' +  dblQty + '&dtPLNDCutDate=' + dtPLNDCutDate  + '&ActCutDate=' + ActCutDate + '&PLNDInputDate=' + PLNDInputDate + '&ActInputDate=' + ActInputDate + '&PLNDFinishDate=' + PLNDFinishDate + '&ActShipmentDate=' + ActShipmentDate + '&ShipmentQTY=' + ShipmentQTY  + '&plus_mines=' + plus_mines + '&plus_mines=' + plus_mines  + '&FebPO=' + FebPO + '&SMPL_YDG_RCVD=' + SMPL_YDG_RCVD + '&Lab_Dip_Aprvd=' + Lab_Dip_Aprvd + '&Fab_Test_Sent=' + Fab_Test_Sent  + '&Feb_tet_Passd=' + Feb_tet_Passd + '&Bulk_Approved=' + Bulk_Approved  + '&Fab_Inspect=' + Fab_Inspect + '&PITN_ORG_SMP_TGT=' + PITN_ORG_SMP_TGT + '&PTTD_RCVD=' + PTTD_RCVD + '&ORG_SMPL_RCVD=' + ORG_SMPL_RCVD  + '&SIZE_QTY=' + SIZE_QTY + '&SIZE_SIZE=' + SIZE_SIZE  + '&SIZE_TGT=' + SIZE_TGT + '&SIZE_SENT=' + SIZE_SENT  + '&SIZE_APVD=' + SIZE_APVD + '&GoldSeal_SIZE=' +  GoldSeal_SIZE + '&GoldSeal_TGT=' + GoldSeal_TGT + '&GoldSeal_SENT=' +  GoldSeal_SENT + '&GoldSeal_APVD=' + GoldSeal_APVD + '&GoldSeal_QTY=' + GoldSeal_QTY  + '&TESTING_QTY=' + TESTING_QTY + '&TESTING_SIZE=' + TESTING_SIZE  + '&TESTING_SIZE=' + TESTING_SIZE + '&TESTING_TGT=' + TESTING_TGT  + '&TESTING_SENT=' + TESTING_SENT + '&TESTING_APVD=' + TESTING_APVD , true);
		xmlHttp.send(null);
	}
	
}

function HandleSaveStyleDetails()
{
	if(xmlHttp.readyState == 4) 
    {
	   if(xmlHttp.status == 200) 
        {
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//alert("New Tax Saved Successfully.");
			}
			else
			{
				alert("Save Process Failed.");
			}
			
		}
	}	
}

//=============================================aa


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

function GetNoOfStyles()
{
	var companyID	= document.getElementById('cboCompanyID').value;
	var buyerID		= document.getElementById('cboCustomer').value;
	var styleID		= document.getElementById('txtstyleid').value;	
	var chkDate		= (document.getElementById('chkDate').checked == true ? 1:0);
	var date		= document.getElementById('txtDate').value;
	
		RomoveData("cboStyleID1");
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = GetNoOfStylesRequest;
		xmlHttp.open("GET", 'orderstatusmiddle.php?RequestType=GetNoOfStyles&companyID=' + companyID + '&buyerID=' +  buyerID + '&styleID=' +styleID+ '&chkDate=' +chkDate+ '&date=' +date , true);
		xmlHttp.send(null);
}
	function GetNoOfStylesRequest()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200) 
    	{
    //		var XMLNO	= xmlHttp.responseXML.getElementsByTagName('countStyle')[0].childNodes[0].nodeValue;
//    		document.getElementById('txtTotNos').value = XMLNO;

			var XMLNO = xmlHttp.responseXML.getElementsByTagName("styleID");	
								 		
					for ( var loop = 0; loop < XMLNO.length; loop ++){						
						var opt = document.createElement("option");
						opt.text = XMLNO[loop].childNodes[0].nodeValue;						
						document.getElementById("cboStyleID1").options.add(opt);			
			 		}
					document.getElementById('txtTotNos').value=XMLNO.length;
		}
	}
	
	
function getEstyypopup(obj){
	var row = obj.parentNode.parentNode;
var test ="test";
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'orderstatusestyypopup.php?test=' +test,true);
	xmlHttp.send(null);
}

	function LoadStockDetailsRequest(){
		if (xmlHttp.readyState==4){
			if (xmlHttp.status==200){
				drawPopupArea(860,150,'frmMaterialTransfer');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
			}
		}
	}
	
function DisableCalander(obj)
{
	if(obj.checked)
		document.getElementById('txtDate').disabled =false;
	else
		document.getElementById('txtDate').disabled =true;
		document.getElementById('txtDate').value ="";
}