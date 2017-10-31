// JavaScript Document
var pub_ShipAdvNo  = 0;

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function clearPage()
{
	window.location.href='shippingadvise.php';
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
	
	var url = 'shippingadvisedb.php?RequestType=getWeekScheduleData&sheduleNo=' +sheduleNo+ '&mode=' +mode+ '&destination=' +destination;
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

function createMainGrid(styleId,orderNo,ScheduleDetailId,style,WkScheduleId,CityId,Mode,city,Qty,PLNo)
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
	//cell.id = styleId;
	cell.innerHTML = style;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML =(Mode==1?"SEA":Mode==2?"AIR":"LAND");
	
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
	cell.innerHTML =(PLNo==""?'n/a':PLNo);
	
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
	
	var url = 'shippingadvisedb.php?RequestType=getPlData&plNo=' +plNo+ '&poNo=' +poNo+ '&styleNo=' +styleNo;
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
	row_source[Mainrow].cells[6].innerHTML=id;	
	CloseOSPopUp('popupLayer1');	
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
//-------------------Data Save Part ------------------------------
function saveData()
{
	if(Validate())
	{
		showPleaseWait();
		var row_source 			=$('#tblMainGrid tr')
		for(var loopz=1;loopz<=row_source.length-1;loopz++)
		{
			if(row_source[loopz].cells[0].childNodes[0].checked==true)
			{
				var booCheck = true;
				if(row_source[loopz].cells[6].childNodes[0].nodeValue=="n/a")
				{
					alert("Please add a PL No.");
					hidePleaseWait();
					return;
				}
				if(document.getElementById("txtDate").value=="")
					{
						alert("Please enter a date.");
						document.getElementById("txtDate").focus();
						hidePleaseWait();
						return;
					}
						var shipAdvNo = $('#cboShipAdvNo').val();
					if(shipAdvNo == '')
					{
						getShipAdvNo();
						saveHeader();
						saveDetails(loopz);
					}
					else
					{
						pub_ShipAdvNo=shipAdvNo;
						saveDetails(loopz);
						saveHeader();
					}
					
			}
		}
		alert("Saved successfully");
		window.location.href='shippingadvise.php';
		hidePleaseWait();
	}
	
		
}
function Validate()
{
	var row_source 			=$('#tblMainGrid tr')
	for(var loopz=1;loopz<=row_source.length-1;loopz++)
	{
		if(row_source[loopz].cells[0].childNodes[0].checked==true)
		{
			var booCheck = true;
		}
	}
	if(booCheck!=true)
	{
		alert("No record to save.")
		hidePleaseWait();
		return false;
	}
	else 
	{
		deleteDetails();
		
	}
	return true;
}
function getShipAdvNo()
{
	
	var url = "shippingadvisedb.php?RequestType=getShipAdvNo";
	htmlobj=$.ajax({url:url,async:false});
	pub_ShipAdvNo	 = htmlobj.responseText;
	document.getElementById('cboShipAdvNo').text  = pub_ShipAdvNo;
	var opt = document.createElement("option");
				opt.text  = pub_ShipAdvNo ;
				opt.value = pub_ShipAdvNo ;
				opt.selected = pub_ShipAdvNo;
				document.getElementById("cboShipAdvNo").options.add(opt);
				
}
function saveHeader()
{
	
	var mode		= $('#cboMode').val();
	var destination	= $('#cboDestination').val();
	var shipAdvDate = document.getElementById('txtDate').value;
	
	var url = "shippingadvisedb.php?RequestType=saveShipAdvHeader&pub_ShipAdvNo="+URLEncode(pub_ShipAdvNo)+"&mode="+mode+"&destination="+destination+"&shipAdvDate="+URLEncode(shipAdvDate);
	htmlobj=$.ajax({url:url,async:false});
	
}
function saveDetails(loopz)
{
	
	var tbl = document.getElementById("tblMainGrid");
	var loop = loopz;
	var shipAdvNo = $('#cboShipAdvNo').val();
	
			var rw			= tbl.rows[loop];
			var wkSheduleId = rw.cells[0].id;
			var styleId 	= rw.cells[1].id;
			var plNo  		= rw.cells[6].childNodes[0].nodeValue;
			
			var url = 'shippingadvisedb.php?RequestType=SaveShipAdvDetails&shipAdvNo='+URLEncode(shipAdvNo)+'&wkSheduleId='+wkSheduleId+'&styleId='+styleId+'&plNo='+plNo;
			htmlobj=$.ajax({url:url,async:false});
	
		
}
function deleteDetails()
{

	var shipAdvNo = $('#cboShipAdvNo').val();
	var url = 'shippingadvisedb.php?RequestType=DeleteShipAdvDetails&shipAdvNo='+URLEncode(shipAdvNo);
			htmlobj=$.ajax({url:url,async:false});
		
}
function loadShipAdvData()
{
	var shipAdvId = $('#cboShipAdvNo').val();
	
	url = "shippingadvisedb.php?RequestType=loadShipAdviseData&shipAdvId="+URLEncode(shipAdvId);
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
	var XMLModeID			  = htmlobj.responseXML.getElementsByTagName("ModeId");
	
	var XMLShipAdvDate        = htmlobj.responseXML.getElementsByTagName("shipAdvDate");
	var XMLPLNo		          = htmlobj.responseXML.getElementsByTagName("PLNo");
	var XMLcityID 			  = htmlobj.responseXML.getElementsByTagName("intCityId");
	var XMLstatus 			  = htmlobj.responseXML.getElementsByTagName("Status");
	
	
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
		var PLNo 			  = XMLPLNo[loop].childNodes[0].nodeValue; 
		var status			  = XMLstatus[loop].childNodes[0].nodeValue;
		
		document.getElementById('txtDate').value=XMLShipAdvDate[loop].childNodes[0].nodeValue;
		document.getElementById('cboScheduleNo').value=XMLWkScheduleId[loop].childNodes[0].nodeValue;
		document.getElementById('cboMode').value=XMLModeID[loop].childNodes[0].nodeValue;
		document.getElementById('cboDestination').value=XMLcityID[loop].childNodes[0].nodeValue;
		
		
			if(status==1)
			{
				document.getElementById("butSave").style.display="none";
				document.getElementById("butConform").style.display="none";
				document.getElementById('txtDate').disabled=true;
				document.getElementById('cboScheduleNo').disabled=true;
				document.getElementById('cboMode').disabled=true;
				document.getElementById('cboDestination').disabled=true;
				
			}
			else
			{
				document.getElementById("butSave").style.display="inline";
				document.getElementById("butConform").style.display="inline";
				document.getElementById('txtDate').disabled=false;
				document.getElementById('cboScheduleNo').disabled=false;
				document.getElementById('cboMode').disabled=false;
				document.getElementById('cboDestination').disabled=false;
			}
		
		createMainGrid(styleId,orderNo,ScheduleDetailId,style,WkScheduleId,CityId,Mode,city,Qty,PLNo);
	}
	
}
function conform()
{
	showPleaseWait();
	if(! confirm("Are you sure you want to confrim this shipment shedule?"))
		return ;
	
	var ShipAdvNo = $('#cboShipAdvNo').val();
	 
	var url = 'shippingadvisedb.php?RequestType=ConfirmShipAdv&ShipAdvNo='+URLEncode(ShipAdvNo);
	htmlobj=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText=="confirmed")
	{
		alert("confirmed successfully.");
		document.getElementById("butConform").style.display="none";
		document.getElementById("butSave").style.display="none";
		hidePleaseWait();
	}
	
}
function openWkReport()
{
	if(document.getElementById("cboShipAdvNo").value=="")
	{
		alert("Please select a shipping advice No.");
		document.getElementById("cboShipAdvNo").focus();
		return;	
	}
	var shipAdvNo = $('#cboShipAdvNo').val();
	url = 'shippingadvicerpt.php?shipAdvNo='+URLEncode(shipAdvNo);
	window.open(url);
}
