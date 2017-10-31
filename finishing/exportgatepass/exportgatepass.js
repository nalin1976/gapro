
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function loadWeekSheduleData()
{
	
	var sheduleNo 	= $('#cboScheduleNo').val();
	var mode		= $('#cboMode').val();
	var destination	= $('#cboDestination').val();
	
	if(sheduleNo=="")
	{
		alert("Please select a shedule No.")
		$('#cboScheduleNo').focus();
		return;
	}
	
	var url = 'exportgatepassdb.php?requestType=getWeekScheduleData&sheduleNo=' +URLEncode(sheduleNo)+ '&mode=' +URLEncode(mode)+ '&destination=' +URLEncode(destination);
	htmlobj=$.ajax({url:url,async:false});
	ClearTable('tblMainGrid');
	
	var XMLStyleId 			  = htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLOrderNo  		  = htmlobj.responseXML.getElementsByTagName("strOrderNo");
	var XMLStyle 			  = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLWkScheduleDetailId = htmlobj.responseXML.getElementsByTagName("intWkScheduleDetailId");
	var XMLWkScheduleId 	  = htmlobj.responseXML.getElementsByTagName("intWkScheduleId");
	var XMLCityId			  = htmlobj.responseXML.getElementsByTagName("intCityId");
	var XMLcity 			  = htmlobj.responseXML.getElementsByTagName("city");
	var XMLQty				  = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLMode				  = htmlobj.responseXML.getElementsByTagName("Mode");
	
	for(loop=0;loop<XMLWkScheduleDetailId.length;loop++)
	{
		var styleId 		  = XMLStyleId[loop].childNodes[0].nodeValue;
		var orderNo 		  = XMLOrderNo[loop].childNodes[0].nodeValue;
		var ScheduleDetailId  = XMLWkScheduleDetailId[loop].childNodes[0].nodeValue;
		var style			  = XMLStyle[loop].childNodes[0].nodeValue;
		var WkScheduleId 	  = XMLWkScheduleId[loop].childNodes[0].nodeValue;
		var CityId 			  = XMLCityId[loop].childNodes[0].nodeValue;
		var Mode 			  = XMLMode[loop].childNodes[0].nodeValue;
		var city			  = XMLcity[loop].childNodes[0].nodeValue;
		var Qty 			  = XMLQty[loop].childNodes[0].nodeValue;
		
		createMainGrid(styleId,orderNo,ScheduleDetailId,style,WkScheduleId,CityId,Mode,city,Qty,'');
	}	
}
function createMainGrid(styleId,orderNo,ScheduleDetailId,style,WkScheduleId,CityId,Mode,city,Qty,plNo)
{	
	var tbl 		= document.getElementById('tblMainGrid');

	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
		
	var cell = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id = ScheduleDetailId;
	cell.innerHTML = "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = styleId;
	cell.innerHTML = orderNo;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = styleId;
	cell.innerHTML = style;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = Mode;
	
	var cell = row.insertCell(4);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = Qty;
	
	var cell = row.insertCell(5);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = CityId;
	cell.innerHTML = city;
	
	var cell = row.insertCell(6);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = "";
	cell.innerHTML = (plNo==""?'n/a':plNo); // 123 has to change put it there to code saving part(PLNo==""?'n/a':PLNo);
	
	var cell = row.insertCell(7);
	cell.className ="normalfntMid";
	cell.nowrap = "nowrap";
	cell.innerHTML = "<img alt=\"add\" src=\"../../images/add.png\" id=\""+orderNo+"\" onClick=\"AddNewPl(this.id,this.parentNode.parentNode.rowIndex);\" >";
}
function AddNewPl(id,row)
{
	this.Mainrow=row; 
	var orderNo=id;
	showBackGround('divBG',0);
	var url = "pldetailpopup.php?orderNo="+orderNo;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(600,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	loadPlData();
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
function loadPlData()
{
	var plNo 		= $('#cboPLNo').val();
	var poNo		= $('#cboPONo').val();
	var styleNo		= $('#cboStyleNo').val();
	
	var url = 'exportgatepassdb.php?requestType=getPlData&plNo=' +plNo+ '&poNo=' +poNo+ '&styleNo=' +styleNo;
	htmlobj=$.ajax({url:url,async:false});
	ClearTable('popupPlSearch');
	
	var XMLPLNo 			  = htmlobj.responseXML.getElementsByTagName("PlNo");
	var XMLDate  		  	  = htmlobj.responseXML.getElementsByTagName("Date");
	var XMLPONo 			  = htmlobj.responseXML.getElementsByTagName("poNo");
	var XMLStyleNo			  = htmlobj.responseXML.getElementsByTagName("StyleNo");
	var XMLItem			 	  = htmlobj.responseXML.getElementsByTagName("Item");
	var XMLQty				  = htmlobj.responseXML.getElementsByTagName("Qty");
	
	for(loop=0;loop<XMLPLNo.length;loop++)
	{
		var plNo	 		  = XMLPLNo[loop].childNodes[0].nodeValue;
		var plDate	 		  = XMLDate[loop].childNodes[0].nodeValue;
		var PONo			  = XMLPONo[loop].childNodes[0].nodeValue;
		var styleNo			  = XMLStyleNo[loop].childNodes[0].nodeValue;
		var Item		 	  = XMLItem[loop].childNodes[0].nodeValue;
		var Qty 			  = XMLQty[loop].childNodes[0].nodeValue;
		
		createPopUpGrid(plNo,plDate,PONo,styleNo,Item,Qty);
	}	
}
function createPopUpGrid(plNo,plDate,PONo,styleNo,Item,Qty)
{
	var tbl 		= document.getElementById('popupPlSearch');

	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cell = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id = plNo;
	cell.innerHTML = "<img alt=\"add\" src=\"../../images/add.png\" id=\""+plNo+"\" onClick=\"AddPlToMainGrid(this.id);\" >";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = plNo;
	cell.innerHTML = plNo;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = plDate;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = PONo;
	
	var cell = row.insertCell(4);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = styleNo;
	
	var cell = row.insertCell(5);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = Item;
	
	var cell = row.insertCell(6);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = Qty;
	
}
function AddPlToMainGrid(id)
{
	var row_source 			=$('#tblMainGrid tr');
	var id=id;
	if(checkPlNo(id)){  // section added on 22/06/2011 to validate the plNo-Chandima
		row_source[Mainrow].cells[6].innerHTML=id;
	}
	else{
		alert("this PL No is already allocated!");
	}
		
	CloseOSPopUp('popupLayer1');	
}
/*
	function checkPlNo() iterate through the tblMainGrid
	and confirms that there is no any PL no is present which
	is equal to the one that's going to allocate. if present
	function returns false else true
	@param: plNo packing list numebr intending to check against
	@return: true if plNo is available in the tblMainGrid
	@return: false if plNo is not found in the tblMainGrid
*/

function checkPlNo(plNo)
{
	var exstPlNo='';
	var status = true;
	var tbl	=	$('#tblMainGrid');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		exstPlNo=tbl.rows[loop].cells[6].innerHTML;
		if(exstPlNo==plNo)
		{
			status = false ;
			break;
		}
	}
	return status;
}


function checkAll(obj)
{
	var tbl = document.getElementById("tblMainGrid");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}

/*
	clearCell() clears the hour and the minute part of the
	obj 
*/

function clearCell(obj)
{
	obj.value="";
}

/*
	validateTime() function validates if the hr and the minute part are 
	within the acceptable range.
	@timePart string: 'hr' or 'mnt' to represent the hour and the minute
	@id string: id of the text box

*/
function validateTime(timePart,id)
{
	var txtval = $("#"+id+"").val();
	//(new RegExp('^[0-9]$',txtval))? txtval = '0'+txtval:txtval =txtval;
	if( timePart == 'hr')
	{
	  (txtval>23||txtval<0)?alert("Hour Part must be positive and less than 24"): txtval=1 ;
	}
	else
	{
	  (txtval>59||txtval<0)?alert("Minute part must be positive and less than 60"): txtval=1 ;
	}
	(txtval ==1)?txtval='':$("#"+id+"").val('');
}


function save()
{
	
	if(!validteHeaderData()) return;
	if(!validateGridData()) return;
	var url		= "exportgatepassdb.php?requestType=saveData";
	var invDate			= $('#txtDate').val();
	var timeInDt 		= $('#txtTimeInDate').val();
	var timeOutDt		= $('#txtTimeOutDate').val(); 
	var timein			= $('#txtHrTimeIn').val()+":"+$('#txtMinTimeIn').val();   // 23:59 format 
	var timeOut			= $('#txtHrTimeOut').val()+":"+$('#txtMinTimeOut').val(); // 23:59 format 
	var vehNo			= $('#txtVehNo').val();
	var auth			= $('#txtAutho').val();
	var deliver			= $('#txtDelivered').val();
	var forwarder		= $("#cboFrwdr option:selected").val(); // getting the selected text value from a combo box
	var wklySchduleNo	= $("#cboScheduleNo option:selected").val(); //intwklyScheduleNo
	var modeid			= $("#cboScheduleNo option:selected").val();
	var cityCode		= $("#cboDestination option:selected").val();
	var gatePassNo		= $("#cboGatePass option:selected").text(); // gatePass NO
	var driver			= $("#txtDrvr").val();

	
	url+="&invDate="+URLEncode(invDate)+"&timeInDt="+URLEncode(timeInDt)+"&timeOutDt="+URLEncode(timeOutDt)+"&timein="+URLEncode(timein)+"&timeOut="+URLEncode(timeOut)+"&vehNo="+URLEncode(vehNo);
	url+="&auth="+URLEncode(auth)+"&deliver="+URLEncode(deliver)+"&forwarder="+URLEncode(forwarder)+"&wklySchduleNo="+URLEncode(wklySchduleNo)+"&modeid="+URLEncode(modeid)+"&cityCode="+URLEncode(cityCode)+"&driver="+URLEncode(driver);
	url+="&gatePassNo="+gatePassNo;

	
	var httpObj			= $.ajax({url:url,async:false});
	var returncode		= httpObj.responseText;

    //var returncode		= "2345";
	var gatePassNo		= returncode.split('__');
	if(gatePassNo[0] == '-1')
	{
		alert("ERROR :"+gatePassNo[1]); // pass the error message
		return;
	}
	
	$("#cboGatePass option:selected").text(gatePassNo[0]);
	 
	//now handling the finishing_gatepass_detail tbl, first delete records prior to incert them.

	var url = "exportgatepassdb.php?requestType=deleteFgpDetailTbldata&gatePassNo="+gatePassNo+"&invDate="+URLEncode(invDate);
	var httpObj1	= $.ajax({url:url,async:false});
	if(httpObj1.responseText=='fail')
	{
		alert("Grid data deleting error");
		return;
	}
	 
	var rowCount = $('#tblMainGrid tr').length;
	var tbl		 = document.getElementById("tblMainGrid");
	var flag = 0;
 for(var loop=1;loop < rowCount;loop ++)
 {
	 if(tbl.rows[loop].cells[0].childNodes[0].checked)
	{
		
		var styleNo	=	tbl.rows[loop].cells[2].innerHTML;
		var styleId	=	tbl.rows[loop].cells[2].id;
		var plNo	= 	tbl.rows[loop].cells[6].innerHTML;
		var intWkScheduleDetailId = tbl.rows[loop].cells[0].id;

		
	 var url="exportgatepassdb.php?requestType=saveGridData&styleNo="+styleNo+"&styleId="+styleId+"&plNo="+plNo;
		url+="&intWkScheduleDetailId="+intWkScheduleDetailId+"&gatePassNo="+gatePassNo+"&invDate="+invDate;

		var httpObj	= $.ajax({url:url,async:false});
		if(httpObj.responseText=='fail')
		 {
			 flag = -1;
			 break;
		 }
	}
	 
 }(flag!=0)?alert("Grid data saving error"):alert("Gate Pass No "+gatePassNo+" Successfuly saved");

}

/*
	deletDetailInTbl() function deletes all the records from 
	the finishing_gatepass_detail table for the given Keys.
	@param: wklySchduleNo- weekly schedule number.
	@param: plNo
	@param: gatePassNo - finishing gatepass number
	@param: invDate -invoice date
*/

function deletDetailInTbl(gatePassNo,invDate)
{
	var url = "exportgatepassdb.php?requestType=deleteFgpDetailTbldata&gatePassNo="+gatePassNo+"&invDate="+URLEncode(invDate);
	var httpObj	= $.ajax({url:url,async:false});
}
/*
	validteHeaderData() validates if there any compulsory
	fields are left blank.
	@return : boolean if any 'must fields' are left blank false
			will be returned.
*/

function validteHeaderData()
{
	var invDate			= ($('#txtDate').val()!='')? true:false;
	var timeInDt 		= ($('#txtTimeInDate').val()!='')?true:false;
	var timeOutDt		= ($('#txtTimeOutDate').val()!='')?true:false; 
	var txtHrTimeIn		= ($('#txtHrTimeIn').val()!='')?true:false;	 
	var txtMinTimeIn	= ($('#txtMinTimeIn').val()!='')?true:false;
	var txtHrTimeOut	= ($('#txtHrTimeOut').val()!='')?true:false;	
	var txtMinTimeOut	= ($('#txtMinTimeOut').val()!='')?true:false;
	var vehNo			= ($('#txtVehNo').val()!='')?true:false;
	var wklySchduleNo	= ($("#cboScheduleNo option:selected").val()!='')?true:false;
	
	if(!invDate)
	{
		alert("plese enter Invoice Date");
		$('#txtDate').focus();
		return false;
	}
	else if(!timeInDt)
	{
		alert("plese enter Time in Date");
		$('#txtTimeInDate').focus();
		return false;
	}
	else if (!timeOutDt)
	{
		alert("plese enter Time Out Date");
		$('#txtTimeOutDate').focus();
		return false;
	}
	else if (!txtHrTimeIn)
	{
		alert("plese enter Hr part in Time IN (24HH)");
		$('#txtHrTimeIn').focus();
		return false;
	}
	else if(!txtMinTimeIn)
	{
		alert("plese enter Minute part in Time IN (MM)");
		$('#txtMinTimeIn').focus();
		return false;
	}
	else if(!txtHrTimeOut)
	{
		alert("plese enter Hr part in Time Out (24HH)");
		$('#txtHrTimeOut').focus();
		return false;
	}
		else if(!txtMinTimeOut)
	{
		alert("plese enter Minute part in Time Out (MM)");
		$('#txtMinTimeOut').focus();
		return false;
	}
		else if(!vehNo)
	{
		alert("plese enter Vehicle Number");
		$('#txtVehNo').focus();
		return false;
	}
	else if(!wklySchduleNo)
	{
		alert("plese enter Weekly Schedule No");
		$('#wklySchduleNo').focus();
		return false;
	}
	else return true;
}


function loadGatepassDetail()
{
	var gatePassKeyArray= new Array();
	gatePassKeyArray	=	$('#cboGatePass option:selected').val().split('-');
	var gatePassNo 		=	gatePassKeyArray[1];
	var gatePassYear	=	gatePassKeyArray[0];
	 clearall();	

	url="exportgatepassdb.php?requestType=loadGatePassDetails&gatePassNo="+gatePassNo+"&gatePassYear="+gatePassYear;
	httpObj	=	$.ajax({url:url,async:false});
	

	try
	{
		var timeInDt 		= httpObj.responseXML.getElementsByTagName("dtmDateIn")[0].childNodes[0].nodeValue;
		var timeOutDt		= httpObj.responseXML.getElementsByTagName("dtmDateOut")[0].childNodes[0].nodeValue;
		var timeIn			= httpObj.responseXML.getElementsByTagName("strTimeIn")[0].childNodes[0].nodeValue;
		var timeOut			= httpObj.responseXML.getElementsByTagName("strTimeOut")[0].childNodes[0].nodeValue;
		var timeinHr		= timeIn.substring(0,2);
		var timeinMnt		= timeIn.substring(3);
		var timeOutHr		= timeOut.substring(0,2);
		var timeOutMnt		= timeOut.substring(3);
		var vehNo			= httpObj.responseXML.getElementsByTagName("strVehicleNo")[0].childNodes[0].nodeValue;
		var auth			= httpObj.responseXML.getElementsByTagName("strAuthorisedBy")[0].childNodes[0].nodeValue;
		var deliver			= httpObj.responseXML.getElementsByTagName("strDeliveredBy")[0].childNodes[0].nodeValue; 
		var forwarder		= httpObj.responseXML.getElementsByTagName("intForwarderID")[0].childNodes[0].nodeValue;  
		var wklySchduleNo	= httpObj.responseXML.getElementsByTagName("intWkScheduleNo")[0].childNodes[0].nodeValue;  
		var invDate			= httpObj.responseXML.getElementsByTagName("dtmDate")[0].childNodes[0].nodeValue;
		var driver			= httpObj.responseXML.getElementsByTagName("strDriver")[0].childNodes[0].nodeValue; // driver

		
		
	    $('#txtDate').val(invDate);
		$('#txtTimeInDate').val(timeInDt);
		$('#txtTimeOutDate').val(timeOutDt); 
		$('#txtHrTimeIn').val(timeinHr);
		$('#txtMinTimeIn').val(timeinMnt);  
		$('#txtHrTimeOut').val(timeOutHr);
		$('#txtMinTimeOut').val(timeOutMnt);
		$('#txtVehNo').val(vehNo);
		$('#txtAutho').val(auth);
		$('#txtDelivered').val(deliver);
		$("#cboFrwdr option:selected").val(forwarder);
		$("#cboScheduleNo ").val(wklySchduleNo);
		$('#txtDrvr').val(driver);
		
	}
	catch(err)
	{
		alert("please select a Gate Pass Number");
		$("#cboGatePass option:selected").focus();
	}
	
	// 	NOW LOADING THE GRID..............
	 loadfromFGPdetails(gatePassNo,gatePassYear,wklySchduleNo);
	 
}
/*
 function clearall() clears the Data on the Export Gate Pass
 interface and the data in the grid too.
*/
function clearall()
{
	
	$('#txtDate').val('');
	$('#txtTimeInDate').val('');
	$('#txtTimeOutDate').val(''); 
	$('#txtHrTimeIn').val('');
	$('#txtMinTimeIn').val('');  
	$('#txtHrTimeOut').val('');
	$('#txtMinTimeOut').val('');
	$('#txtVehNo').val('');
	$('#txtAutho').val('');
	$('#txtDelivered').val('');
	$('#txtDrvr').val('');
	$("#cboFrwdr option:selected").val('');
	$("#cboScheduleNo ").val('');
	ClearTable('tblMainGrid');
		
}
/*	
	function loadfromFGPdetails() loads the data on to the grid
	once
*/

function loadfromFGPdetails(gatePassNo,gatePassYear,wklySchduleNo)
{
	
	url	= "exportgatepassdb.php?requestType=loadFGPdetails&gatePassNo="+gatePassNo+"&gatePassYear="+gatePassYear+"&wklySchduleNo="+wklySchduleNo;
	httpObj = $.ajax({url:url,async:false});
	
	var XMLStyleId 			  = httpObj.responseXML.getElementsByTagName("intStyleId");
	var XMLOrderNo  		  = httpObj.responseXML.getElementsByTagName("strOrderNo");
	var XMLStyle 			  = httpObj.responseXML.getElementsByTagName("strStyle");
	var XMLWkScheduleDetailId = httpObj.responseXML.getElementsByTagName("intWkScheduleDetailId");
	var XMLWkScheduleId 	  = httpObj.responseXML.getElementsByTagName("intWkScheduleId");
	var XMLCityId			  = httpObj.responseXML.getElementsByTagName("intCityId");
	var XMLcity 			  = httpObj.responseXML.getElementsByTagName("city");
	var XMLQty				  = httpObj.responseXML.getElementsByTagName("dblQty");
	var XMLMode				  = httpObj.responseXML.getElementsByTagName("Mode");
	var XMLintPlNo			  = httpObj.responseXML.getElementsByTagName("intPlNo"); 
	
	for(loop=0;loop<XMLWkScheduleDetailId.length;loop++)
	{
		var styleId 		  = XMLStyleId[loop].childNodes[0].nodeValue;
		var orderNo 		  = XMLOrderNo[loop].childNodes[0].nodeValue;
		var ScheduleDetailId  = XMLWkScheduleDetailId[loop].childNodes[0].nodeValue;
		var style			  = XMLStyle[loop].childNodes[0].nodeValue;
		var WkScheduleId 	  = XMLWkScheduleId[loop].childNodes[0].nodeValue;
		var CityId 			  = XMLCityId[loop].childNodes[0].nodeValue;
		var Mode 			  = XMLMode[loop].childNodes[0].nodeValue;
		var city			  = XMLcity[loop].childNodes[0].nodeValue;
		var Qty 			  = XMLQty[loop].childNodes[0].nodeValue;
		var PlNo			  = XMLintPlNo[loop].childNodes[0].nodeValue; 
		
		createMainGrid(styleId,orderNo,ScheduleDetailId,style,WkScheduleId,CityId,Mode,city,Qty,PlNo);
	}	
	
		var tbl = document.getElementById("tblMainGrid");
		for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = true;		
	}	
	
}

/*
	function clearPage(), clears all the values currently on the form.
*/

function clearPage()
{
	clearall();
	$('#cboGatePass').val('');
}

/*
	function openFgpReport() opens the gate pass in a sdeprate window
	@param: doesn't take in any patameters
	@return: doesn't return any value
*/

function openFgpReport()
{
	var gatePassNo		= $("#cboGatePass option:selected").text(); // gatePass NO
	var invDate			= $('#txtDate').val(); // gatepass year
	
	var tbl = document.getElementById("tblMainGrid");
	var styleNoArray = new Array();
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		styleNoArray[loop - 1]=tbl.rows[loop].cells[1].id;
	}	
	
	var url	=	"rptexportgatepass.php?&gatePassNo="+gatePassNo+"&invDate="+invDate+"&styleNoArray="+styleNoArray;
	window.open(url,'rptFgp');
}
/*
	function validateGridData() Confirms that the records 
	whxih are about to save have a value for Packing list column 
	other than 'n/a'  in tblMain  table and those specific 
	records have been selected via check box. 
	@return : boolean value if both conditions are met return
				true else false.
*/

function validateGridData()
{
		var tbl = document.getElementById("tblMainGrid");
		var bool=false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			if(tbl.rows[loop].cells[6].childNodes[0].nodeValue!='n/a')bool= true;
				
		}
		
	}
	(!bool)?alert("please select recordes to be saved and select a PO number"):'';
	return bool;
	
}