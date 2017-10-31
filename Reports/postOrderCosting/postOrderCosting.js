function RomoveData(data)
{
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}
function LoadOrderNo(style)
{
	if(document.getElementById("rbAllStyle").checked)
		var orderStatus = '';
	else if(document.getElementById("rbCompleteStyle").checked)
		var orderStatus = '13';
	else if(document.getElementById("rbPendingStyle").checked)
		var orderStatus = '0,10';
		
	var url = 'postOrderCostingXML.php?RequestType=getStyleWiseOrderNo&style='+URLEncode(style)+'&OrderStatus='+orderStatus;
	htmlobj = $.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
	LoadSCNo(style,orderStatus);
}
function LoadSCNo(style,orderStatus)
{
	var url = 'postOrderCostingXML.php?RequestType=getStyleWiseSCNo&style='+URLEncode(style)+'&OrderStatus='+orderStatus;
	htmlobj = $.ajax({url:url,async:false});
	var XMLScNo = htmlobj.responseText;
	document.getElementById('cboScNo').innerHTML = XMLScNo;
}
function SetOrderNo(obj)
{
	$('#cboOrderNo').val(obj.value);
}

function SetSCNo(obj)
{
	$('#cboScNo').val(obj.value);
}

//-------------------------------
function LoadCompleteStyle(orderStatus)
{
	RomoveData('cboStyleID');
	RomoveData('cboScNo');
	RomoveData('cboOrderNo');
	
	var url ='postOrderCostingXML.php?RequestType=LoadAllStyle&OrderStatus='+orderStatus;
	htmlobj = $.ajax({url:url,async:false});
	var XMLStyle = htmlobj.responseText;
	document.getElementById('cboStyleID').innerHTML = XMLStyle;
	LoadSCNo("",orderStatus);
	laodStatusWiseOrder("",orderStatus);
}
function laodStatusWiseOrder(style,orderStatus)
{
	var url = 'postOrderCostingXML.php?RequestType=getStyleWiseOrderNo&style='+URLEncode(style)+'&OrderStatus='+orderStatus;
	htmlobj = $.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
}
function ViewReport()
{
	var StyleID 	= document.getElementById('cboOrderNo').value;
	var reportId 	= document.getElementById('cboReportCategory').value; 	
	var buyer 		= document.getElementById('cboBuyer').value; 
	var styleName 	= document.getElementById('cboStyleID').value;
	var orderStatus='';
	if(StyleID=="" && reportId==0)
	{
		alert("Please select 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		return false;
	}
	
	if(reportId==0)
		var reportName = "rptPostOrderCosting.php?";
	else if(reportId==1)
		var reportName = "rptPostOrderCostingSummary.php?";
	else if(reportId==2)	
		var reportName = "rptPostSummeryReport.php?";
		
	var url  = reportName;
		url += "&StyleID="+StyleID;
		url	+= "&buyer="+buyer;
		url	+= "&styleName="+URLEncode(styleName);
		url += "&CheckDate="+(document.getElementById('checkDate').checked ? 1:0);
		url += "&DateFrom="+document.getElementById('txtDfrom').value;
		url += "&DateTo="+document.getElementById('txtDto').value;
		url += "&OrderType="+document.getElementById('cboOrderType').value; 
	
	if(document.getElementById('rbAllStyle').checked)
		url += "&orderStatus="+document.getElementById('rbAllStyle').value;
	if(document.getElementById('rbCompleteStyle').checked)
		url += "&orderStatus="+document.getElementById('rbCompleteStyle').value;
	if(document.getElementById('rbApprovedStyle').checked)
		url += "&orderStatus="+document.getElementById('rbApprovedStyle').value;
	if(document.getElementById('rbPendingStyle').checked)
		url += "&orderStatus="+document.getElementById('rbPendingStyle').value;	
		
	window.open(url,reportName);
}

function ViewExReport()
{
	var StyleID 	= document.getElementById('cboOrderNo').value;
	var reportId 	= document.getElementById('cboReportCategory').value; 	
	var buyer 		= document.getElementById('cboBuyer').value; 
	var styleName 	= document.getElementById('cboStyleID').value; 
	var checkDate	= (document.getElementById('checkDate').checked ? 1:0);
	var dateFrom 	= document.getElementById('txtDfrom').value; 
	var dateTo	 	= document.getElementById('txtDto').value; 
	
	if(StyleID=="" && reportId==0)
	{
		alert("Please select 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		return false;
	}
	
	if(reportId==0)
		var reportName = "xclcostestimatesheet.php?";
	else if(reportId==1)
		var reportName = "xclPostOrderCostingSummary.php";
		
	var url =reportName+"?&StyleID="+StyleID+"&buyer="+buyer+"&styleName="+URLEncode(styleName)+'&CheckDate='+checkDate+'&DateFrom='+dateFrom+'&DateTo='+dateTo;
	window.open(url,reportName);
}

function SetDate(obj)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfrom").disabled= true;
		document.getElementById("txtDto").disabled= true;		
	}
	else
	{
		document.getElementById("txtDfrom").disabled=false;
		document.getElementById("txtDto").disabled= false;
	}	
}

function ClearForm()
{
	document.frmPostOrderCosting.reset();
	LoadCompleteStyle('');
}