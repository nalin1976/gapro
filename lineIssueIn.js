function ReloadForm()
{
	document.getElementById('frmFinishingLineIn').submit();
}

function loadStylewiseOrders()
{
	var styleNo = document.getElementById('cboStyle').value;
	var url = 'lineIssueIndb.php?RequestType=getStylewiseOrderNo&styleNo='+URLEncode(styleNo);	
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
	document.getElementById('txtOrderQty').value = '';
	clearInterfaceData();
	
}
function loadOrderwiseColors()
{
	var styleId = document.getElementById('cboOrderNo').value;	
	var url = 'lineIssueIndb.php?RequestType=getOrdernoWiseColorDetails&styleId='+(styleId);	
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById('cboColor').innerHTML = htmlobj.responseText;
	
	loadOrderHeaderDetails();
}
function loadOrderHeaderDetails()
{
	var styleId = document.getElementById('cboOrderNo').value;	
	var url = 'lineIssueIndb.php?RequestType=getOrdernoHeaderDetails&styleId='+(styleId);	
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('txtOrderQty').value =  htmlobj.responseText;
	
	getOrderDetails();
}
function getOrderDetails()
{
	var styleId = document.getElementById('cboOrderNo').value;
	var color = document.getElementById('cboColor').value;
		
	var url = 'lineIssueIndb.php?RequestType=getOrdernoDetails&styleId='+(styleId)+'&color='+URLEncode(color);	
	htmlobj=$.ajax({url:url,async:false});
	CreateItemGrid(htmlobj);
}

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function CreateItemGrid(htmlobj)
{
	var strSize 	=  htmlobj.responseXML.getElementsByTagName("strSize");
	var receivedQty =  htmlobj.responseXML.getElementsByTagName("Qty");
	var balQty	=  htmlobj.responseXML.getElementsByTagName("balQty");
	var issuedQty = htmlobj.responseXML.getElementsByTagName("IssuedQty");
	
	var tbl 		= document.getElementById('tblMainGrid');
	clearInterfaceData();
	
	for(loop=0;loop<strSize.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.innerHTML = strSize[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfntRite";
		cell.innerHTML =issuedQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(3);
		cell.className ="normalfntRite";
		cell.innerHTML = "<input type=\"text\" style=\"width:120px; text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\" maxlength=\"10\" onkeyup=\"AutoCheck(this);\">";
	}
}

function checkAll(obj)
{
	var tbl 		= document.getElementById('tblMainGrid');
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[0].childNodes[0].checked = check;
	}
}

function clearInterfaceData()
{
	ClearTable('tblMainGrid');
	document.getElementById('chkAll').checked = false;
	
	document.getElementById('txtIssueNo').value = '';	
}

function saveFinishInData()
{
	var tbl = document.getElementById('tblMainGrid');
	var styleId =document.getElementById('cboOrderNo').value;
	var color = document.getElementById('cboColor').value;
	 
	var chk=0;
	for(i=1;i<tbl.rows.length;i++)	
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked && tbl.rows[i].cells[3].childNodes[0].value >0)
			chk++;
	}
	
	if(chk==0)
	{
		alert("Please select size details");
		return false;	
	} 
	else
	{
		var url = 'lineIssueIndb.php?RequestType=saveFinishingLineIssueHeader&styleId='+(styleId)+'&color='+URLEncode(color);	
		htmlobj=$.ajax({url:url,async:false});
		var response = htmlobj.responseText;
		
		if(response == 'N/A')
		{
			alert("Error in Finishing Line Issue Header Data");
			return false;
		}
		else
		{
			document.getElementById('txtIssueNo').value = response;
			saveFinishLineIssueDetails();
			
		}
		
	}	
}

function saveFinishLineIssueDetails()
{
	var tbl = document.getElementById('tblMainGrid');
	var lineInNo = document.getElementById('txtIssueNo').value;
	var styleId =document.getElementById('cboOrderNo').value;
	var color = document.getElementById('cboColor').value;
	
	for(i=1;i<tbl.rows.length;i++)	
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked && tbl.rows[i].cells[3].childNodes[0].value >0)
		{
			var size = tbl.rows[i].cells[1].innerHTML;
			var issueQty = tbl.rows[i].cells[3].childNodes[0].value;
			var url_d = 'lineIssueIndb.php?RequestType=saveFinishingLineIssueDetails&size='+URLEncode(size)+'&issueQty='+(issueQty)+'&lineInNo='+URLEncode(lineInNo)+'&styleId='+styleId+'&color='+URLEncode(color);
			htmlobj_d=$.ajax({url:url_d,async:false});
		}
	}
	alert("Saved successfully");
	ReloadForm();
}

function AutoCheck(obj)
{
	var rw	= obj.parentNode.parentNode;
	if(obj.value.trim()=="" || parseFloat(obj.value)==0)
		rw.cells[0].childNodes[0].checked = false;
	else
		rw.cells[0].childNodes[0].checked = true;
		
}