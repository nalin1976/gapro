//Start - Table field variables names
var cell_check	 	= 0;
var cell_chem	 	= 1;
var cell_unit		= 2;
var cell_issueQty	= 3;
var cell_mrnQty  	= 4;
var cell_issuedQty 	= 5;
var cell_balToMrn  	= 6;
var cell_Sbal	 	= 7;


//End - Table field variables names

/*$(document).ready(function() 
{
	var url					='chemicalissuemiddle.php?RequestType=LoadCostNo';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");

	$( "#txtMRNNo" ).autocomplete({
		source: pub_po_arr
	});
});*/

function ClearForm()
{
	document.frmChemRequisitionMain.reset();
	document.getElementById("cboOrderNo").innerHTML = "";
	document.getElementById("cboStyleNo").innerHTML = "";
	$("#tblItemList tr:gt(0)").remove();
	LoadMrnNo();
}
function LoadMrnNo()
{
	var url = 'chemicalissuemiddle.php?RequestType=LoadMrnNo';
	var xmlhttp = $.ajax({url:url,async:false});
	document.getElementById('txtMRNNo').innerHTML = xmlhttp.responseText;
}

function LoadDetails(obj)
{
	var mrnNo	= document.getElementById('txtMRNNo').value;
	if(mrnNo=="")
	{
		ClearForm();
		return;
	}
	var url = 'chemicalissuemiddle.php?RequestType=LoadHeaderDetails&MrnNo='+mrnNo;
	var xml_http = $.ajax({url:url,async:false});
	
	var XMLMachineType = xml_http.responseXML.getElementsByTagName('MachineType');
		document.getElementById('cboMachineType').value = XMLMachineType[0].childNodes[0].nodeValue;
		
	var XMLOrderQty = xml_http.responseXML.getElementsByTagName('OrderQty');
		document.getElementById('txtOrderQty').value = XMLOrderQty[0].childNodes[0].nodeValue;
		
	var XMLStyleId = xml_http.responseXML.getElementsByTagName('StyleId');
	var XMLOrderNo = xml_http.responseXML.getElementsByTagName('OrderNo');
	var XMLStyleNo = xml_http.responseXML.getElementsByTagName('StyleNo');
	var XMLCostNo  = xml_http.responseXML.getElementsByTagName('CostNo');
	
	var opt = document.createElement("option");
	opt.text = XMLOrderNo[0].childNodes[0].nodeValue;
	opt.value = XMLStyleId[0].childNodes[0].nodeValue;
	document.getElementById("cboOrderNo").options.add(opt);
						
	var opt = document.createElement("option");
	opt.text = XMLStyleNo[0].childNodes[0].nodeValue;
	opt.value = XMLStyleId[0].childNodes[0].nodeValue;
	document.getElementById("cboStyleNo").options.add(opt);
	
	var opt = document.createElement("option");
	opt.text = XMLCostNo[0].childNodes[0].nodeValue;
	opt.value = XMLCostNo[0].childNodes[0].nodeValue;
	document.getElementById("cboCostNo").options.add(opt);
	
	var styleId	= document.getElementById('cboOrderNo').value;
	var mrnNo	= document.getElementById('txtMRNNo').value;
	var url = 'chemicalissuemiddle.php?RequestType=LoadDetails&MrnNo='+mrnNo+ '&StyleId='+styleId;
	var xml_http = $.ajax({url:url,async:false});
	
	var XMLChemicalId 	= xml_http.responseXML.getElementsByTagName('ChemicalId');
	var XMLChemDesc 	= xml_http.responseXML.getElementsByTagName('ChemDesc');
	var XMLMRNRaised 	= xml_http.responseXML.getElementsByTagName('MRNRaised');
	var XMLBalToMRN	 	= xml_http.responseXML.getElementsByTagName('BalToMRN');
	var XMLIssuedQty 	= xml_http.responseXML.getElementsByTagName('IssuedQty');
	var XMLStockBal	 	= xml_http.responseXML.getElementsByTagName('StockBal');	
	var XMLUnitId		= xml_http.responseXML.getElementsByTagName('UnitId');
	var XMLUnit		 	= xml_http.responseXML.getElementsByTagName('Unit');
	$("#tblItemList tr:gt(0)").remove();
	for(loop=0;loop<XMLChemicalId.length;loop++)
	{
		var chemicalId 	= XMLChemicalId[loop].childNodes[0].nodeValue;
		var chemDesc 	= XMLChemDesc[loop].childNodes[0].nodeValue;
		var unitId 		= XMLUnitId[loop].childNodes[0].nodeValue;
		var units 		= XMLUnit[loop].childNodes[0].nodeValue;
		var mrnRaised 	= parseFloat(XMLMRNRaised[loop].childNodes[0].nodeValue);
		var issuedQty 	= parseFloat(XMLIssuedQty[loop].childNodes[0].nodeValue);
		var stockBal 	= parseFloat(XMLStockBal[loop].childNodes[0].nodeValue);
		var balToMrn	= parseFloat(XMLBalToMRN[loop].childNodes[0].nodeValue);
		CreateGrid(chemicalId,chemDesc,unitId,units,mrnRaised,issuedQty,stockBal,balToMrn);
	}
}

function CreateGrid(chemicalId,chemDesc,unitId,units,mrnRaised,issuedQty,stockBal,balToMrn)
{
	var tbl 	   	= document.getElementById('tblItemList');
	var lastRow    	= tbl.rows.length;	
	var row 	   	= tbl.insertRow(lastRow);
	var chkDisable	= "";
	
	row.className  = "bcgcolor-tblrowWhite";	
	
	var cell       = row.insertCell(0);
	cell.className = "normalfntMid";
	cell.innerHTML = "<input type=\"checkbox\" name=\"chkSelect\" id=\"chkSelect\" "+(chkDisable)+"/>";
	
	var cell       = row.insertCell(1);
	cell.className = "normalfnt";
	cell.id		   = chemicalId;
	cell.innerHTML = chemDesc;
	
	var cell       = row.insertCell(2);
	cell.className = "normalfnt";
	cell.id		   = unitId;
	cell.innerHTML = units;

	var cell 	   = row.insertCell(3);
	cell.className = "normalfntRite";
	cell.innerHTML = "<input type=\"text\" class=\"txtbox\" style=\"width:70px;text-align:right\" "+(chkDisable)+" onkeyup=\"ValidateWithBalIssueQty(this);\"/>";

	var cell 	   = row.insertCell(4);
	cell.className = "normalfntRite";
	cell.innerHTML = mrnRaised;
	
	var cell 	   = row.insertCell(5);
	cell.className = "normalfntRite";
	cell.innerHTML = issuedQty;
	
	var cell 	   = row.insertCell(6);
	cell.className = "normalfntRite";
	cell.innerHTML = balToMrn;
	
	var cell 	   = row.insertCell(7);
	cell.className = "normalfntRite";
	cell.innerHTML = stockBal;
}

function Save()
{
	var mrnNo	= document.getElementById('txtMRNNo').value;
	var issueNo	= document.getElementById('txtIssueNo').value;
	var orderId	= document.getElementById('cboOrderNo').value;
	var costNo	= document.getElementById('cboCostNo').value;
	
	if(!validateInterfase(mrnNo))
		return;
		
	if(!LoadNo(issueNo))
		return;
		
	var url = 'chemicalissuedb.php?RequestType=SaveHeader&MrnNo='+mrnNo+ '&IssueNo='+pub_No+ '&IssueYear='+pub_Year+ '&OrderId='+orderId+ '&CostNo='+costNo;
	var xmlhttp = $.ajax({url:url,async:false});
	
	var tbl = document.getElementById('tblItemList');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[cell_check].childNodes[0].checked)
		{
			var url  = 'chemicalissuedb.php?RequestType=SaveDetails';
			url 	+= '&IssueNo='+pub_No;
			url 	+= '&IssueYear='+pub_Year;
			url 	+= '&ChemId='+tbl.rows[loop].cells[cell_chem].id;
			url 	+= '&UnitId='+tbl.rows[loop].cells[cell_unit].id;
			url 	+= '&IsssueQty='+tbl.rows[loop].cells[cell_issueQty].childNodes[0].value;
			url 	+= '&MRNNo='+mrnNo;
			var xmlhttp = $.ajax({url:url,async:false});
		}
	}
	alert(xmlhttp.responseText);
	ClearForm();
}

function LoadNo(issueNo)
{
	if(issueNo=="")
	{
		var url = 'chemicalissuemiddle.php?RequestType=LoadNo';
		var xmlhttp = $.ajax({url:url,async:false});
		var XMLAdmin	= xmlhttp.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
		if(XMLAdmin=="TRUE")
		{
			var XMLNo 	= xmlhttp.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
			var XMLYear = xmlhttp.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
			pub_No		= parseInt(XMLNo);
			pub_Year 	= parseInt(XMLYear);
			document.getElementById("txtIssueNo").value=pub_Year + "/" + pub_No;			
			return true;
		}
		else{
			alert("Please contact system administrator to assign new 'MRN No'.");
			return false;
		}
	}
	else
	{
		No = issueNo.split("/");		
		pub_No =parseInt(No[1]);
		pub_Year = parseInt(No[0]);
		return true;
	}
}

function validateInterfase(mrnNo)
{
	var booCheck = false;
	if(mrnNo=="")
	{
		alert("Please select 'MRN No'.");
		document.getElementById('txtMRNNo').focus();
		return false;
	}
	var tbl = document.getElementById('tblItemList');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[cell_check].childNodes[0].checked)
		{
			booCheck = true;
			var issueQty = tbl.rows[loop].cells[cell_issueQty].childNodes[0].value;
			if(issueQty=="" || issueQty=='0')
			{
				alert("Please enter valid qty in line no :"+loop);
				tbl.rows[loop].cells[cell_issueQty].childNodes[0].select();
				return false;
			}
		}
	}
	
	if(!booCheck)
	{
		alert("Please select at least one item.");
		return;
	}
	return true;
}

function ValidateWithOrderQty(obj)
{
	var orderQty	= parseFloat(document.getElementById('txtOrderQty').value);
	var washQty 	= parseFloat(obj.value);
	var noOfPcs		= parseFloat(document.getElementById('txtQty').value);
	if(washQty>orderQty){
		obj.value = orderQty;
		washQty 	= parseFloat(orderQty);
	}
	
	
	var tbl = document.getElementById('tblItemList');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var colNoOfPcs = parseFloat(tbl.rows[loop].cells[cell_qty].childNodes[0].nodeValue);
		if(tbl.rows[loop].cells[cell_check].childNodes[0].disabled)
			tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value = "";
		else
			var calc =  Math.round(colNoOfPcs/noOfPcs*washQty,4);
			if(calc > parseFloat(tbl.rows[loop].cells[cell_balToMrn].childNodes[0].nodeValue))
				tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value = tbl.rows[loop].cells[cell_balToMrn].childNodes[0].nodeValue;
			else
				tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value = calc;
	}
}

function LoadList()
{
	var tbl = document.getElementById('tblList');
	var url = 'chemicalissuemiddle.php?RequestType=LoadList';
	var xmlhttp = $.ajax({url:url,async:false});
	
	var XMLMRNNo	 	= xmlhttp.responseXML.getElementsByTagName('MRNNo');
	var XMLCostNo	 	= xmlhttp.responseXML.getElementsByTagName('CostNo');
	var XMLDate	 		= xmlhttp.responseXML.getElementsByTagName('Date');
	var XMLRequestBy	= xmlhttp.responseXML.getElementsByTagName('RequestBy');
	$("#tblList tr:gt(0)").remove();
	for(loop=0;loop<XMLMRNNo.length;loop++)
	{
		var mrnNo 		= XMLMRNNo[loop].childNodes[0].nodeValue;
		var costNo 		= XMLCostNo[loop].childNodes[0].nodeValue;
		var date 		= XMLDate[loop].childNodes[0].nodeValue;
		var requestBy 	= XMLRequestBy[loop].childNodes[0].nodeValue;
		CreateGridList(mrnNo,costNo,date,requestBy);
	}
}

function CreateGridList(mrnNo,costNo,date,requestBy)
{
	var tbl 	   = document.getElementById('tblList');
	var lastRow    = tbl.rows.length;	
	var row 	   = tbl.insertRow(lastRow);
	row.className  = "bcgcolor-tblrowWhite";	
	
	var cell       = row.insertCell(0);
	cell.className = "normalfnt";
	cell.innerHTML = mrnNo;
	
	var cell       = row.insertCell(1);
	cell.className = "normalfnt";
	cell.innerHTML = costNo;
	
	var cell       = row.insertCell(2);
	cell.className = "normalfnt";
	cell.innerHTML = date;
	
	var cell       = row.insertCell(3);
	cell.className = "normalfnt";
	cell.innerHTML = requestBy;
}

function ValidateWithBalIssueQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var issueBal	= parseFloat(rw.cells[cell_balToMrn].childNodes[0].nodeValue);
	if(parseFloat(obj.value)>issueBal)
	{
		obj.value = issueBal;
	}
}