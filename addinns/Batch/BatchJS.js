var xmlHttp;
//Start -  CALANDER

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
//End -  CALANDER

function ShowData(obj)
{
	var intBatchNo = obj.parentNode.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	document.getElementById('cboSearch').value=intBatchNo;
	document.getElementById('cboSearch').onchange();
}

function PostBatch(obj,rowindex)
{	

	showBackGround('divBG',0);
	var url = "batchdetailpop.php?batchNo="+obj+"&rowindex="+rowindex;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(704,337,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}

function HandlePostBatch(htmlobj,rowIndex)
{
	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");			 
	if (XMLResult[0].childNodes[0].nodeValue == "True")
	{
		var tbl = document.getElementById('tblBatch');
		var img = tbl.rows[xmlHttp.rowIndex].cells[1].childNodes[0].childNodes[0];
		img.src = "../../images/unposted.png";
		var edit=tbl.rows[xmlHttp.rowIndex].cells[0].childNodes[0].childNodes[1];
		edit.src="../../images/";
		edit.alt="";
		alert("The Batch posted successfully.");	
		setFroNew();
	}
}

function HandleUnPostBatch(htmlobj,rowIndex)
{
	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");			 
	if (XMLResult[0].childNodes[0].nodeValue == "True")
	{
		var tbl = document.getElementById('tblBatch');
		var img = tbl.rows[xmlHttp.rowIndex].cells[1].childNodes[0].childNodes[0];
		img.src = "../../images/posted.png";
		var edit=tbl.rows[xmlHttp.rowIndex].cells[0].childNodes[0].childNodes[1];
		edit.src="../../images/edit.png";
		edit.alt="edit";
		alert("The Batch unposted successfully.");					
	}
}

function setDefaultDate()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(day + "/" + month + "/" + year);
	AddRowtoGrid();
}

function getBatchNo(task)
{	
    var url = 'BatchMiddleTire.php?RequestType=BatchNoTask&task=' + task;
	htmlobj=$.ajax({url:url,async:false});
	HandleAdvanceNo(htmlobj);
}

function HandleAdvanceNo(htmlobj)
{
	var XMLBatchNo = htmlobj.responseXML.getElementsByTagName("batchNo");	
	if(XMLBatchNo.length>0)
		var BatchNo = XMLBatchNo[0].childNodes[0].nodeValue;
	else
		var BatchNo ='1'
}

function setFroNew()
{	
	document.getElementById("frmBatchCreation").reset();
	document.getElementById("txtDescription").focus();
	setDefaultDate();
	DisabledInterface(false);
	ManageInterface(2);
	interfaceChanged(0);
}

function saveBatch()
{
	var type	= document.getElementById('cboBatchType').value;
	if (isValidBatch(type))
	{		
		var optValue 		= document.getElementById('cboBatchType').value;
		var intBatchType=0;		
		if (optValue==1)
		{
			intBatchType=1;
		}
		else
		{
			intBatchType=2;
		}		
		var strDescription 	= document.getElementById('txtDescription').value.trim();
		strDescription=URLEncode(strDescription);
		var datex=document.getElementById("txtDate").value	
		var strDay =""
		var datex2=""
		var strMonth=""
		var strYear=""
		var payDate=""
		
		strDay =datex.substring(0,2);
		datex2=datex.substr(datex.indexOf("/")+1);
		strMonth=datex2.substring(0,datex.indexOf("/"));
		strYear=datex2.substr(datex.indexOf("/")+1);
		var payDate=strYear + "/" + strMonth + "/" +  strDay;
		
		var strCurrency 	= document.getElementById('cboCurrency').value;
		var strBankCode 	= document.getElementById('cboBank').value;	
		var intBatch		= document.getElementById('txtBatchNo').value;
		var accountNo		= $("#cboBatch_accountName option:selected").text()

		var url='BatchMiddleTire.php?RequestType=SaveBatch&intBatch='+intBatch+'&intBatchType='+intBatchType+'&strDescription='+URLEncode(strDescription)+'&strCurrency='+strCurrency+'&strBankCode='+strBankCode+'&dtmDate='+payDate+ '&AccountNo='+URLEncode(accountNo);			
		htmlobj=$.ajax({url:url,async:false});
		HandleSaveBatch(htmlobj);
	}
}

function HandleSaveBatch(htmlobj)
{
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
	var XMLBatchNo = htmlobj.responseXML.getElementsByTagName("BatchNo"); 
	if (XMLResult[0].childNodes[0].nodeValue == "1")
	{
		var XMLBatchNo = htmlobj.responseXML.getElementsByTagName("BatchNo"); 
		AddRowtoGrid();
		alert("The Batch saved successfully. Batch No is " +XMLBatchNo[0].childNodes[0].nodeValue)
		getBatchNo(2);
		setFroNew();
		return false;
	}
	else if(XMLResult[0].childNodes[0].nodeValue =="-2")
	{
		UpdateTable();
		alert("The Batch \""+XMLBatchNo[0].childNodes[0].nodeValue+"\" updated successfully.");
		setFroNew();
		return false;
	}
	else if(XMLResult[0].childNodes[0].nodeValue =="-4")
	{
		alert("The Batch \""+XMLBatchNo[0].childNodes[0].nodeValue+"\" already exist.");
		return false;
	}
	else if(XMLResult[0].childNodes[0].nodeValue =="-5")
	{
		alert("The Batch Description already exist.");
		return false;
	}
	else
	{
		alert("Saving error.");
		return false;
	}
}

function isValidBatch(obj)
{	
	if (document.getElementById('txtDescription').value.trim() == "")
	{
		alert("Please enter the \"Description\".");
		document.getElementById('txtDescription').select();
		return false;		
	}
	else if (document.getElementById('cboBatchType').value == "0" || document.getElementById('cboBatchType').value == null)
	{
		alert("Please select the \"Batch Type\".");
		document.getElementById('cboBatchType').focus();
		return false;	
	}	
	else if (document.getElementById('txtDate').value == "" || document.getElementById('txtDate').value == null)
	{
		alert("Please enter the Date.");
		document.getElementById('txtDate').focus();
		return false;	
	}
	else if (document.getElementById('cboBank').value == 'null' && obj == '2')
	{
		alert("Please select the \"Bank\".");
		document.getElementById('cboBank').focus();
		return false;	
	}
	else if (document.getElementById('cboBatch_accountName').value == 'null' && obj == '2')
	{
		alert("Please select the \"Bank Account\".");
		document.getElementById('cboBank').focus();
		return false;	
	}
	else if (document.getElementById('cboCurrency').value == 'null'  && obj == '2')
	{
		alert("Please select the \"Currency\".");
		document.getElementById('cboCurrency').focus();
		return false;	
	}
	
	return true;
}

function LoadBatchold()
{	
	var intBatch = document.getElementById('cboSearch').value;
	if(intBatch.trim() == 0)
	{
		setDefaultDate();
		setFroNew();
		return false;
	}
	var tbl = document.getElementById('tblBatch');	
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
		if (intBatch==rw.cells[2].lastChild.nodeValue)
		{		
			document.getElementById('txtBatchNo').value 	= rw.cells[2].lastChild.nodeValue;
			document.getElementById('txtDescription').value = rw.cells[3].lastChild.nodeValue;
			document.getElementById('txtDate').value 		= rw.cells[5].lastChild.nodeValue;
			document.getElementById('cboCurrency').value 	= rw.cells[6].id;
			document.getElementById('cboBank').value 		= rw.cells[7].id;
			document.getElementById('cboBank').onchange() ;
			document.getElementById('cboBatchType').value 	= rw.cells[4].id;
			document.getElementById('cboBatch_accountName').value = rw.cells[6].id;
		}
	}
}

function LoadBatch(obj)
{
	var url = "BatchMiddleTire.php?RequestType=LoadBatch&BatchId="+obj.value;
	htmlobj_LoadBatch=$.ajax({url:url,async:false});
	
	var XMLIsUsed = htmlobj_LoadBatch.responseXML.getElementsByTagName("IsUsed");
	
	if(XMLIsUsed.length<=0){
		interfaceChanged(0);
		document.frmBatchCreation.reset();
		return;
	}
	document.getElementById('txtBatchNo').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("BatchId")[0].childNodes[0].nodeValue;
	document.getElementById('txtDescription').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("Description")[0].childNodes[0].nodeValue;
	document.getElementById('txtDate').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("Date")[0].childNodes[0].nodeValue;
	document.getElementById('cboBatchType').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("BatchType")[0].childNodes[0].nodeValue;
	
	document.getElementById('cboBank').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("BankId")[0].childNodes[0].nodeValue;
	document.getElementById('cboBank').onchange();
	document.getElementById('cboBatch_accountName').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
	document.getElementById('cboCurrency').value = htmlobj_LoadBatch.responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
	var postedStatus = htmlobj_LoadBatch.responseXML.getElementsByTagName("postedStatus")[0].childNodes[0].nodeValue;
	interfaceChanged(postedStatus);
	document.getElementById('cboBatchType').onchange();
	if(XMLIsUsed[0].childNodes[0].nodeValue==1)
		DisabledInterface(true);
	else
		DisabledInterface(false);
}

function UpdateTable()
{
	/*var optValue 		= document.getElementById('cboBatchType').value;
	var batchType=0;		
	if (optValue==1)
	{
		batchType="Invoice";
	}
	else
	{
		batchType="Payment";
	}	
	var strDescription 	= document.getElementById('txtDescription').value;
	var dtmDate 		= document.getElementById('txtDate').value;
	var strCurrency 	= document.getElementById('cboCurrency').value;
	var strBankCode 	= document.getElementById('cboBank').options[document.getElementById('cboBank').selectedIndex].text;	
	var intBatch		= document.getElementById('txtBatchNo').value;		
	var tbl = document.getElementById('tblBatch');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];       
		if (intBatch == rw.cells[2].childNodes[0].nodeValue)
		{
			rw.cells[3].childNodes[0].nodeValue = strDescription;
			rw.cells[4].childNodes[0].nodeValue = batchType;			
			rw.cells[5].childNodes[0].nodeValue = dtmDate;
			rw.cells[6].childNodes[0].nodeValue = strCurrency;
			rw.cells[7].childNodes[0].nodeValue = strBankCode;	
		}		
	}*/
	AddRowtoGrid();
}

function AddRowtoGrid()
{
    var url = 'BatchMiddleTire.php?RequestType=getAllBatches';
	htmlobj=$.ajax({url:url,async:false});
	HandlePaymentVoucher(htmlobj);
}

function HandlePaymentVoucher(htmlobj)
{
	var XMLbatchNo 	= htmlobj.responseXML.getElementsByTagName("batchNo");
	var XMLdesc 	= htmlobj.responseXML.getElementsByTagName("desc");
	var XMLtype 	= htmlobj.responseXML.getElementsByTagName("type");
	var XMLdate 	= htmlobj.responseXML.getElementsByTagName("date");
	var XMLcurrency = htmlobj.responseXML.getElementsByTagName("currency");
	var XMLbank 	= htmlobj.responseXML.getElementsByTagName("bank");
	var XMLbankCode = htmlobj.responseXML.getElementsByTagName("bankCode");
	var XMLposted 	= htmlobj.responseXML.getElementsByTagName("posted");
	var XMLcurrencyName 	= htmlobj.responseXML.getElementsByTagName("currencyName");
			
	var strBatches  = "<table  width=\"850\" bgcolor=\"\" height=\"41\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblBatch\">"+
					  "<tr>"+
					   	"<td width=\"53\" bgcolor=\"\" class=\"grid_header\">Edit</td>"+
						"<td width=\"61\" height=\"24\" bgcolor=\"\" class=\"grid_header\">Status</td>"+
						"<td width=\"79\" bgcolor=\"\" class=\"grid_header\">Batch No</td>"+
						"<td width=\"221\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
						"<td width=\"72\" bgcolor=\"\" class=\"grid_header\">Type</td>"+
						"<td width=\"77\" bgcolor=\"\" class=\"grid_header\">Date</td>"+
						"<td width=\"83\" bgcolor=\"\" class=\"grid_header\">Currency</td>"+
						"<td width=\"281\" bgcolor=\"\" class=\"grid_header\">Bank</td>"+
					  "</tr>"
			
			
	for ( var loop = 0; loop < XMLbatchNo.length; loop ++)
	{
		var cls;
		(loop%2==0)?cls="grid_raw":cls="grid_raw2";
		var batchNo  = XMLbatchNo[loop].childNodes[0].nodeValue;
		var datex 	 = XMLdate[loop].childNodes[0].nodeValue;
		var	desc	 = XMLdesc[loop].childNodes[0].nodeValue;
		var	type	 = XMLtype[loop].childNodes[0].nodeValue;
		var posted   = XMLposted[loop].childNodes[0].nodeValue;
		var	currency = XMLcurrency[loop].childNodes[0].nodeValue;
		var bank	 = XMLbank[loop].childNodes[0].nodeValue;
		var bankCode = XMLbankCode[loop].childNodes[0].nodeValue;
		var currName = XMLcurrencyName[loop].childNodes[0].nodeValue;
		var postImg;
		var editImg;
		var clickEvent;
		var typeId=type;
		if(posted==1) 
		{
			postImg='unposted.png'; 
			clickEvent = 'openTxtFile(this);';
			
		}
		else 
		{
			postImg='posted.png'; 
			clickEvent = 'PostBatch(this.id,this.parentNode.parentNode.parentNode.rowIndex)';
		}
		if(posted==1) {editImg=''; alt=''; }else {editImg='edit.png';alt='edit';}
		if (type==1) type='Invoice'; else type='Payment';
		
			strBatches+="<tr class=\""+cls+"\">"+
			"<td height=\"18\" class=\""+cls+"\"><div align=\"center\"> <img src=\"../../images/"+editImg+"\" alt=\""+alt+"\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"ShowData(this)\" id=\""+batchNo+"\" /> </div></td>"+
			"<td class=\""+cls+"\"><div align=\"center\"><img src=../../images/"+ postImg +" alt=\"posted\" id=\""+batchNo+"\" width=\"15\" height=\"15\" onclick=\""+clickEvent+"\" class=\"mouseover\" />"+
			"</div></td>"+
			"<td class=\""+cls+"\">" + batchNo + "</td>"+
			"<td class=\""+cls+"\" style=\"text-align:left;\">" + desc + "</td>"+
			"<td class=\""+cls+"\" id=\""+typeId+"\" style=\"text-align:left;\">" + type + "</td>"+
			"<td class=\""+cls+"\">" + datex + "</td>"+
			"<td class=\""+cls+"\" style=\"text-align:left;\" id="+currency+">" + currName + "</td>"+
			"<td class=\""+cls+"\" id=\""+bankCode+"\" style=\"text-align:left;\" >" + bank + " </td>"+
			"</tr>"
		
	}
	strBatches+="</table>"
	document.getElementById("divBatches").innerHTML=strBatches
	var comID=document.getElementById("cboCompany").value.trim();
	var sql = "SELECT intBatch, strDescription FROM batch where batch.intCompID="+comID+" ORDER BY intBatch DESC ;";
	loadCombo(sql,'cboSearch');
}

function loadCurrencyPopUp()
{
	
	var url  = "../currency/Currency.php?";
	inc('../currency/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeCurrencyPopUp";
	var tdPopUpClose = "currency_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}
function closeCurrencyPopUp(id)
{
	closePopUpArea(id);
	var url = 'BatchMiddleTire.php?RequestType=loadCurrency';
   	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboCurrency').innerHTML = htmlobj.responseText;
}

function batch_creation_popupBank()
{
	var url  = "../branch/branch.php?";
	inc('../branch/button.js')
	inc('../banks/bank-js.js')
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_brnchHeader";// "td_coHeader";
	var tdDelete = "td_coDeleteBranch";//"td_coDelete";
	var closePopUp = "closeBranchPopUp";
	var tdPopUpClose = "branch_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}

function closeBranchPopUp(id)
{
	closePopUpArea(id);
	var url = 'BatchMiddleTire.php?RequestType=LoadBankMode';
   	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboBank').innerHTML = htmlobj.responseText;
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function LoadAccountDetails(obj)
{
	var url = "BatchMiddleTire.php?RequestType=LoadAccountDetails&BranchId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboBatch_accountName').innerHTML = htmlobj.responseText;
}

function LoadCurrency(obj)
{
	document.getElementById('cboCurrency').value = obj.value;
}

function ManageInterface(obj)
{		
	if(obj=="1")
	{
		document.getElementById('divbank').style.display = "none";
		document.getElementById('cboCurrency').disabled = false;
	}
	else
	{
		document.getElementById('divbank').style.display = "inline";
		document.getElementById('cboCurrency').disabled = true;
	}
}

function DisabledInterface(obj)
{
	document.getElementById('cboBatchType').disabled = obj;
	document.getElementById('cboBank').disabled = obj;
	document.getElementById('cboBatch_accountName').disabled = obj;
}

function DeleteBatch()
{
	var batchId	=  document.getElementById('cboSearch').value;
	var url = "BatchMiddleTire.php?RequestType=DeleteBatch&BatchId="+batchId;
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue);
	setFroNew();
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
function postingBatch(batchNo,rowIndex)
{
		var chk=confirm("Are you sure, that you want to post Batch No."+batchNo+"\." );
		if(!chk)
		{
			return false;
		}
		var url = "BatchMiddleTire.php?RequestType=writetxt&batchNo="+batchNo;
		htmlobj=$.ajax({url:url,async:false});
		var XMLboolcheck = htmlobj.responseXML.getElementsByTagName("boolcheck")[0].childNodes[0].nodeValue;
		var fileName     = htmlobj.responseXML.getElementsByTagName("txtFileName")[0].childNodes[0].nodeValue;
		if(XMLboolcheck=="true")
		{
			
			var tbl = document.getElementById('tblBatch');
			var img = tbl.rows[rowIndex].cells[1].childNodes[0].childNodes[0];
			tbl.rows[rowIndex].cells[1].id = batchNo;
			tbl.rows[rowIndex].cells[1].innerHTML ="<div align=\"center\"><img src=\"../../images/unposted.png\" alt=\"posted\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"openTxtFile(this)\" /></div>" 
			
			var edit=tbl.rows[rowIndex].cells[0].childNodes[0].childNodes[1];
			edit.src="../../images/";
			edit.alt="";
			alert("The Batch posted successfully.");
			CloseOSPopUp('popupLayer1');
		}
		else
			alert("The Batch not posted.");	
}
function openTxtFile(obj)
{
	ShowData(obj);
	document.frmBatchCreation.action ="readfile.php";
	document.frmBatchCreation.target = "_blank";
	document.frmBatchCreation.submit();
	interfaceChanged(0);	
	document.frmBatchCreation.reset();
	
}
function interfaceChanged(postedStatus)
{
	if(postedStatus==1)
	{
		document.getElementById("butSave").style.display = "none";
		document.getElementById("butDelete").style.display = "none";
	}
	if(postedStatus==0)
	{
		document.getElementById("butSave").style.display = "inline";
		document.getElementById("butDelete").style.display = "inline";
	}
}