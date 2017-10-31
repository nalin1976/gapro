$(document).ready(function() 
{
	var url					='editDeliverySchduledb.php?id=load_ord_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtOrderNo" ).autocomplete({
			source: pub_po_arr
		});
		
		
	var url					='editDeliverySchduledb.php?id=load_style_str';
		var pub_xml_http	=$.ajax({url:url,async:false});
		var pub_style			=pub_xml_http.responseText.split("|");	
	
	$( "#txtStyleName" ).autocomplete({
			source: pub_style
		});
});

function enableEnterLoadOrderDetails(evt)
{
var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadStyleId('orderNo');
}
function loadStyleId(type)
{
	var orderNo='';
	var styleId='';

	if(type == 'orderNo')
		orderNo = document.getElementById("txtOrderNo").value;
	else
		styleId = document.getElementById("cboSc").value;
	
	
	var url = 'editDeliverySchduledb.php?id=load_styleId&orderNo='+URLEncode(orderNo)+'&styleId='+styleId;	
	htmlobj = $.ajax({url:url,async:false});
	
	document.getElementById("styleId").title = htmlobj.responseXML.getElementsByTagName('styleID')[0].childNodes[0].nodeValue;
	document.getElementById("orderQty").innerHTML = htmlobj.responseXML.getElementsByTagName('orderQty')[0].childNodes[0].nodeValue;
	document.getElementById("exPct").innerHTML = htmlobj.responseXML.getElementsByTagName('exPct')[0].childNodes[0].nodeValue;
	document.getElementById("txtStyleName").value = htmlobj.responseXML.getElementsByTagName('strStyle')[0].childNodes[0].nodeValue;
	document.getElementById("cboSc").value = htmlobj.responseXML.getElementsByTagName('styleID')[0].childNodes[0].nodeValue;
	document.getElementById("txtOrderNo").value = htmlobj.responseXML.getElementsByTagName('orderNo')[0].childNodes[0].nodeValue;
	styleId = htmlobj.responseXML.getElementsByTagName('styleID')[0].childNodes[0].nodeValue;
	LoadSavedSchedules(styleId);
}

function LoadSavedSchedules(styleId)
{
	//var styleId = document.getElementById("styleId").title;
	clearTbl('tblDelivery');
	var url = 'editDeliverySchduledb.php?id=load_DeliveryData&styleId='+(styleId);	
	htmlobj = $.ajax({url:url,async:false});
		
	var XMLDateofDelivery = htmlobj.responseXML.getElementsByTagName("DateofDelivery");
	var XMLQty = htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLRemarks = htmlobj.responseXML.getElementsByTagName("Remarks");
	var XMLShippingModeID = htmlobj.responseXML.getElementsByTagName("ShippingModeID");
	var XMLShippingMode = htmlobj.responseXML.getElementsByTagName("ShippingMode");
	var XMLExQty = htmlobj.responseXML.getElementsByTagName("ExQty");
	var XMLisBase = htmlobj.responseXML.getElementsByTagName("isBase");
	var XMLLeadTimeID = htmlobj.responseXML.getElementsByTagName("LeadTimeID");
	var XMLLeadTime = htmlobj.responseXML.getElementsByTagName("LeadTime");
	var XMLEstimated = htmlobj.responseXML.getElementsByTagName("EstimatedDate");
	var XMLApprovalNo = htmlobj.responseXML.getElementsByTagName("intApprovalNo");
	
			for ( var loop = 0; loop < XMLDateofDelivery.length; loop ++)
			{
			
				var date = XMLDateofDelivery[loop].childNodes[0].nodeValue;
				var qty = XMLQty[loop].childNodes[0].nodeValue;;
				var exqty = XMLExQty[loop].childNodes[0].nodeValue;;
				var mode = XMLShippingMode[loop].childNodes[0].nodeValue;;
				var remarks =XMLRemarks[loop].childNodes[0].nodeValue;;
				var modeID = XMLShippingModeID[loop].childNodes[0].nodeValue;
				var isbase = XMLisBase[loop].childNodes[0].nodeValue;
				var LeadTimeID = XMLLeadTimeID[loop].childNodes[0].nodeValue;
				var LeadTime = XMLLeadTime[loop].childNodes[0].nodeValue;
				var estimatedDate = XMLEstimated[loop].childNodes[0].nodeValue;
				var ApprovalNo = XMLApprovalNo[loop].childNodes[0].nodeValue;
				var	deliveryIndex = htmlobj.responseXML.getElementsByTagName("intDeliveryId")[loop].childNodes[0].nodeValue;
				
				var tbl = document.getElementById('tblDelivery');
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;
				if (isbase == 'Y')
					row.className = "bcggreen";
				else
					row.className = "backcolorWhite";
				var cellEdit = row.insertCell(0); 
				cellEdit.innerHTML = '';
				
				if(ApprovalNo<2)
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this);\" align=\"center\"><img class=\"mouseover\" src=\"../images/edit.png\" /></div>";
				if(ApprovalNo==2 && editDelScheduleAfterFirstRevision=='1')
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this);\" align=\"center\"><img class=\"mouseover\" src=\"../images/edit.png\" /></div>";
				if(editDelScheduleAfterRevision=='1')	
					cellEdit.innerHTML = "<div id=\"" +  date + "\" onClick=\"showEditScheduleWindow(this);\" align=\"center\"><img class=\"mouseover\" src=\"../images/edit.png\" /></div>";	
					
				var cellDelete = row.insertCell(1);     
				cellDelete.innerHTML = "<div id=\"" +  date + "\" onClick=\"RemoveSchedule(this);\" align=\"center\"><img class=\"mouseover\" src=\"../images/del.png\" /></div>";
				
				var cellDeliveryDate = row.insertCell(2);     
				cellDeliveryDate.className="normalfntMid";
				cellDeliveryDate.id = date;
				cellDeliveryDate.height="20"
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
				//deliveryIndex++;
			}
}
function clearTbl(tbl)
{
	$("#"+tbl+" tr:gt(0)").remove();	
	
}
function showEditScheduleWindow(obj)
{
	showBackGround('divBG',0);
	var rw = obj.parentNode.parentNode;
	var url = "editDelSchedulePopup.php?&delveryID="+rw.id;

	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(500,181,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	document.getElementById('deliverydate').value = rw.cells[2].id;
	document.getElementById('quantity').value = rw.cells[3].innerHTML;
	document.getElementById('excqty').value = rw.cells[4].innerHTML;
	document.getElementById('remarks').value = rw.cells[6].innerHTML;
	var shippos = rw.cells[5].id;
	getShippingModes(shippos);
}
function getShippingModes(shippos)
{    
    var url = '../preordermiddletire.php?RequestType=GetShippingMode';
 	 htmlobj=$.ajax({url:url,async:false});
	
	var XMLShippingID = htmlobj.responseXML.getElementsByTagName("ShipModeID");
	 var XMLShippingName = htmlobj.responseXML.getElementsByTagName("ShipMode");
	 
	 for ( var loop = 0; loop < XMLShippingID.length; loop ++)
	 {
		var opt = document.createElement("option");
		opt.text = XMLShippingName[loop].childNodes[0].nodeValue;
		opt.value = XMLShippingID[loop].childNodes[0].nodeValue;
		document.getElementById("cboShippingMode").options.add(opt);
	 }
	 document.getElementById("cboShippingMode").value = shippos;
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
function checkForValues(obj)
{
	if(obj.value == "" || obj.value == null)
		obj.value = 0;
}
function calExQtyForDeliverySchedule(Qty)
{
	var ExPct = parseFloat(document.getElementById('exPct').innerHTML);
	var exQty = parseInt(RoundNumbers(Qty*(100+ExPct)/100,0));
	document.getElementById('excqty').value = exQty;
}

function UpdateSchedule(delScheduleId)
{
	if(validateDelData())
	{
	var url = 'editDeliverySchduledb.php?id=updateDeliveryData&delScheduleId='+(delScheduleId);	
	url += '&deliveryDate='+URLEncode(document.getElementById("deliverydate").value);
	url += '&DelQty='+document.getElementById("quantity").value;
	url += '&ExDelQty='+document.getElementById("excqty").value;
	url += '&ShippingMode='+document.getElementById("cboShippingMode").value;
	url += '&remarks='+URLEncode(document.getElementById("remarks").value);
	htmlobj=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText == '1')
		updateDeliveryDetails(delScheduleId);
	}
}
function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
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
function validateDelData()
{
	var delDate = document.getElementById('deliverydate').value;
	if(delDate =='')
	{
		alert("Select 'Delivery Date'");
		document.getElementById('deliverydate').focus();
		return false;
	}
	var delQty = document.getElementById('quantity').value;
	if(delQty ==0)
	{
		alert("Enter 'Delivery Qty'");
		document.getElementById('quantity').focus();
		return false;
	}
	var remarks = trim(document.getElementById('remarks').value);
	if(remarks =='')
	{
		alert("Enter 'Remarks'");
		document.getElementById('remarks').focus();
		return false;
	}
	return true;
}
function updateDeliveryDetails(delScheduleId)
{
	var tbl = document.getElementById('tblDelivery');
	var rowNo = -1;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var rw = tbl.rows[loop];
		var delId = rw.id;
		if (delId == delScheduleId)
			rowNo = loop;
	}
	
	tbl.rows[rowNo].cells[0].childNodes[0].id = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].id =  document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[2].lastChild.nodeValue = document.getElementById('deliverydate').value;
	tbl.rows[rowNo].cells[3].lastChild.nodeValue = document.getElementById('quantity').value;
	tbl.rows[rowNo].cells[4].lastChild.nodeValue = document.getElementById('excqty').value;
	tbl.rows[rowNo].cells[5].lastChild.nodeValue = document.getElementById('cboShippingMode').options[document.getElementById('cboShippingMode').selectedIndex].text;
	tbl.rows[rowNo].cells[6].lastChild.nodeValue = document.getElementById('remarks').value;	
	tbl.rows[rowNo].cells[5].id = document.getElementById('cboShippingMode').value;
}
function RemoveSchedule(obj)
{

	if(confirm('Are you sure you want to delete this schedule?'))
	{
		var rw = obj.parentNode.parentNode;
		DeleteDeliverySchedule(rw.id);
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);
	}
}
function DeleteDeliverySchedule(delScheduleId)
{
	var url = 'editDeliverySchduledb.php?id=DeleteDeliveryData&delScheduleId='+(delScheduleId);	
	htmlobj=$.ajax({url:url,async:false});
}

