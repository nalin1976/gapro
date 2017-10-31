//Start - Table field variables names
var cell_check	 	= 0;
var cell_chem	 	= 1;
var cell_unit		 = 2;
var cell_qty	 	= 3;
var cell_mrnQty  	= 4;
var cell_balToMrn 	 = 5;
var cell_mrnRaised  = 6;
var cell_issue  	= 7;
var cell_issueBal  	= 8;
var cell_Sbal	 	= 9;


//End - Table field variables names

/*$(document).ready(function() 
{
	var url					='chemicalrequisitionmiddle.php?RequestType=LoadCostNo';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");

	$( "#txtCostNo" ).autocomplete({
		source: pub_po_arr
	});
});*/

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		//var rw = obj.parentNode.parentNode;
		//var prossId	= document.getElementById('cboSearch').value;
		//var chemiId	= rw.cells[1].id;
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);
		
		
		//var url = 'chemicalallocationdb.php?RequestType=RemoveItem&ProcessId='+prossId+ '&ChemiId='+chemiId;
		//var xml_http = $.ajax({url:url,async:false});
	}
}

function ClearForm()
{
	document.frmChemRequisitionMain.reset();
	document.getElementById("cboOrderNo").innerHTML = "";
	document.getElementById("cboStyleNo").innerHTML = "";
	$("#tblItemList tr:gt(0)").remove();
}

function LoadCostDetails(obj)
{
	var costNo	= document.getElementById('txtCostNo').value;
	if(costNo=="")
	{
		ClearForm();
		return;
	}
	var url = 'chemicalrequisitionmiddle.php?RequestType=LoadCostHeaderDetails&CostNo='+costNo;
	var xml_http = $.ajax({url:url,async:false});
	
	var XMLMachineType = xml_http.responseXML.getElementsByTagName('MachineType');
		document.getElementById('cboMachineType').value = XMLMachineType[0].childNodes[0].nodeValue;
		
	var XMLQty = xml_http.responseXML.getElementsByTagName('Qty');
		document.getElementById('txtQty').value = XMLQty[0].childNodes[0].nodeValue;
		
	var XMLOrderQty = xml_http.responseXML.getElementsByTagName('OrderQty');
		document.getElementById('txtOrderQty').value = XMLOrderQty[0].childNodes[0].nodeValue;
		
	var XMLStyleId = xml_http.responseXML.getElementsByTagName('StyleId');
	var XMLOrderNo = xml_http.responseXML.getElementsByTagName('OrderNo');
	var XMLStyleNo = xml_http.responseXML.getElementsByTagName('StyleNo');
	
	var opt = document.createElement("option");
	opt.text = XMLOrderNo[0].childNodes[0].nodeValue;
	opt.value = XMLStyleId[0].childNodes[0].nodeValue;
	document.getElementById("cboOrderNo").options.add(opt);
						
	var opt = document.createElement("option");
	opt.text = XMLStyleNo[0].childNodes[0].nodeValue;
	opt.value = XMLStyleId[0].childNodes[0].nodeValue;
	document.getElementById("cboStyleNo").options.add(opt);
	
	var styleId	= document.getElementById('cboOrderNo').value;
	var costNo	= document.getElementById('txtCostNo').value;
	var url = 'chemicalrequisitionmiddle.php?RequestType=LoadCostDetails&CostNo='+costNo+ '&StyleId='+styleId;
	var xml_http = $.ajax({url:url,async:false});
	
	var XMLChemicalId 	= xml_http.responseXML.getElementsByTagName('ChemicalId');
	var XMLChemDesc 	= xml_http.responseXML.getElementsByTagName('ChemDesc');
	var XMLMRNRaised 	= xml_http.responseXML.getElementsByTagName('MRNRaised');
	var XMLIssuedQty 	= xml_http.responseXML.getElementsByTagName('IssuedQty');
	var XMLStockBal	 	= xml_http.responseXML.getElementsByTagName('StockBal');
	var XMLTotQty	 	= xml_http.responseXML.getElementsByTagName('TotQty');
	var XMLUnitId		= xml_http.responseXML.getElementsByTagName('UnitId');
	var XMLUnit		 	= xml_http.responseXML.getElementsByTagName('Unit');
	$("#tblItemList tr:gt(0)").remove();
	for(loop=0;loop<XMLChemicalId.length;loop++)
	{
		var chemicalId 	= XMLChemicalId[loop].childNodes[0].nodeValue;
		var chemDesc 	= XMLChemDesc[loop].childNodes[0].nodeValue;
		var totQty 		= XMLTotQty[loop].childNodes[0].nodeValue;
		var unitId 		= XMLUnitId[loop].childNodes[0].nodeValue;
		var units 		= XMLUnit[loop].childNodes[0].nodeValue;
		var mrnRaised 	= parseFloat(XMLMRNRaised[loop].childNodes[0].nodeValue);
		var issuedQty 	= parseFloat(XMLIssuedQty[loop].childNodes[0].nodeValue);
		var issueBal	= mrnRaised-issuedQty;
		var stockBal 	= parseFloat(XMLStockBal[loop].childNodes[0].nodeValue);
		var balToMrn	= stockBal-issueBal;
		CreateGrid(chemicalId,chemDesc,totQty,unitId,units,mrnRaised,issuedQty,issueBal,stockBal,balToMrn);
	}
}

function CreateGrid(chemicalId,chemDesc,totQty,unitId,units,mrnRaised,issuedQty,issueBal,stockBal,balToMrn)
{
	var tbl 	   	= document.getElementById('tblItemList');
	var lastRow    	= tbl.rows.length;	
	var row 	   	= tbl.insertRow(lastRow);
	var className 	= "bcgcolor-tblrowWhite";
	var chkDisable	= false;
	if(stockBal<=0)
	{
		className = "bcgcolor-InvoiceCostTrim";
		chkDisable = 'disabled="disabled"'; 
	}
	else 
	{
		className = "bcgcolor-tblrowWhite";
		chkDisable = ""; 
	}
	
	row.className  = className;	
	
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
	
	var cell       = row.insertCell(3);
	cell.className = "normalfntRite";
	cell.innerHTML = totQty;
	
	var cell 	   = row.insertCell(4);
	cell.className = "normalfntRite";
	cell.innerHTML = "<input type=\"text\" class=\"txtbox\" style=\"width:70px;text-align:right\" "+(chkDisable)+" onkeyup=\"ValidateWithBalMrnQty(this);\"/>";
	
	var cell 	   = row.insertCell(5);
	cell.className = "normalfntRite";
	cell.innerHTML = balToMrn;
	
	var cell 	   = row.insertCell(6);
	cell.className = "normalfntRite";
	cell.innerHTML = mrnRaised;
	
	var cell 	   = row.insertCell(7);
	cell.className = "normalfntRite";
	cell.innerHTML = issuedQty;
	
	var cell 	   = row.insertCell(8);
	cell.className = "normalfntRite";
	cell.innerHTML = issueBal;
	
	var cell       = row.insertCell(9);
	cell.className = "normalfntRite";
	cell.innerHTML = stockBal;
}

function Save()
{
	var costNo	= document.getElementById('txtCostNo').value;
	var mrnNo	= document.getElementById('txtMrnNo').value;
	var washQty	= document.getElementById('txtWashQty').value;
	var orderId	= document.getElementById('cboOrderNo').value;
	if(!validateInterfase(costNo,washQty))
		return;
		
	if(!LoadNo(mrnNo))
		return;
		
	var url = 'chemicalrequisitiondb.php?RequestType=SaveHeader&CostNo='+costNo+ '&MRNNo='+pub_No+ '&MRNYear='+pub_Year+ '&OrderId='+orderId;
	var xmlhttp = $.ajax({url:url,async:false});
	
	var tbl = document.getElementById('tblItemList');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[cell_check].childNodes[0].checked)
		{
			var url  = 'chemicalrequisitiondb.php?RequestType=SaveDetails';
			url 	+= '&MRNNo='+pub_No;
			url 	+= '&MRNYear='+pub_Year;
			url 	+= '&ChemId='+tbl.rows[loop].cells[cell_chem].id;
			url 	+= '&UnitId='+tbl.rows[loop].cells[cell_unit].id;
			url 	+= '&MrnQty='+tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value;
			var xmlhttp = $.ajax({url:url,async:false});
		}
	}
	alert(xmlhttp.responseText);
	ClearForm();
}

function LoadNo(mrnNo)
{
	if(mrnNo=="")
	{
		var url = 'chemicalrequisitionmiddle.php?RequestType=LoadNo';
		var xmlhttp = $.ajax({url:url,async:false});
		var XMLAdmin	= xmlhttp.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
		if(XMLAdmin=="TRUE")
		{
			var XMLNo 	= xmlhttp.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
			var XMLYear = xmlhttp.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
			pub_No		= parseInt(XMLNo);
			pub_Year 	= parseInt(XMLYear);
			document.getElementById("txtMrnNo").value=pub_Year + "/" + pub_No;			
			return true;
		}
		else{
			alert("Please contact system administrator to assign new 'MRN No'.");
			return false;
		}
	}
	else
	{
		No = mrnNo.split("/");		
		pub_No =parseInt(No[1]);
		pub_Year = parseInt(No[0]);
		return true;
	}
}

function validateInterfase(costNo,washQty)
{
	var booCheck = false;
	if(costNo=="")
	{
		alert("Please select 'Cost No'.");
		document.getElementById('txtCostNo').focus();
		return false;
	}
/*	else if(washQty=="")
	{
		alert("Please enter 'Wash Qty'.");
		document.getElementById('txtWashQty').focus();
		return false;
	}*/
	
	var tbl = document.getElementById('tblItemList');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[cell_check].childNodes[0].checked)
		{
			booCheck = true;
			var issueQty = tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value;
			if(issueQty=="" || issueQty=='0')
			{
				alert("Please enter valid qty in line no :"+loop);
				tbl.rows[loop].cells[cell_mrnQty].childNodes[0].select();
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
		//alert(colNoOfPcs/noOfPcs*washQty);
			var calc = 0;
			calc =  (colNoOfPcs/noOfPcs)*washQty;
			var q=parseFloat(tbl.rows[loop].cells[cell_balToMrn].childNodes[0].nodeValue);
			if(calc > q)
				tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value = tbl.rows[loop].cells[cell_balToMrn].childNodes[0].nodeValue;
			else
				tbl.rows[loop].cells[cell_mrnQty].childNodes[0].value = calc;
	}
}

function LoadList()
{
	var tbl = document.getElementById('tblList');
	var url = 'chemicalrequisitionmiddle.php?RequestType=LoadList';
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

function ValidateWithBalMrnQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var mrnBal	= parseFloat(rw.cells[cell_balToMrn].childNodes[0].nodeValue);
	if(parseFloat(obj.value)>mrnBal)
	{
		obj.value = mrnBal;
	}
}