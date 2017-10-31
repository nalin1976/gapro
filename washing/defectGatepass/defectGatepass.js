// JavaScript Document
var pub_DefctGPNo    = 0;
var pub_DefectGPYear = 0;
function loadColor(obj)
{
	if(obj.value=="")
	{
		clearAll();
		return;
	}
	document.getElementById('txtSendQty').readOnly = false;
	document.getElementById('txtSendQty').value = "";
	document.getElementById('cboStyleNo').value = obj.value;
	var url = "defectGatepassdb.php?request=loadColor&orderNo="+obj.value.trim();
	htmlobj = $.ajax({url:url,async:false});
	var XMLQty = htmlobj.responseXML.getElementsByTagName("Color");
	document.getElementById('cboColor').innerHTML=XMLQty[0].childNodes[0].nodeValue;
	loadQty(obj);
}
function loadPO(obj)
{
	if(obj.value=="")
	{
		clearAll();
		return;
	}
	$('#cboPONo').val(obj.value);
	document.getElementById("cboPONo").onchange();
}
function loadQty(obj)
{
	var color = document.getElementById('cboColor').value.trim();
	var url   = "defectGatepassdb.php?request=loadQty&orderNo="+obj.value.trim()+"&color="+URLEncode(color);
	htmlobj   = $.ajax({url:url,async:false});
	
	var XMLOrderQty  = htmlobj.responseXML.getElementsByTagName('orderQty');
	var XMLStockQty  = htmlobj.responseXML.getElementsByTagName('stockQty');
	var XMLgpQty     = htmlobj.responseXML.getElementsByTagName('gatepassQty');
	var XMLNr		 = htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany	 = htmlobj.responseXML.getElementsByTagName("cName");
	
	if(XMLNr.length>0)
	{
		
		if(XMLNr[0].childNodes[0].nodeValue==1)
		{
			document.getElementById('cboSewingFactory').innerHTML = XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById('cboSewingFactory').disabled  = true;
 			document.getElementById('txtOrderQty').value 		  = XMLOrderQty[0].childNodes[0].nodeValue;
			document.getElementById('txtAvailableQty').value  	  = XMLStockQty[0].childNodes[0].nodeValue;
			document.getElementById('txtGatepassQty').value  	  = XMLgpQty[0].childNodes[0].nodeValue;
		
		}
		else
		{
			document.getElementById('cboSewingFactory').innerHTML = XMLCompany[0].childNodes[0].nodeValue;
			alert("Please select 'Sewing Factory'.");
			document.getElementById('cboSewingFactory').disabled  = false
			return false;
		}
	}
}
function clearAll()
{	
	document.frmWasDefectGatepass.reset();
	document.getElementById('txtSendQty').readOnly = true;
	document.getElementById('cboColor').innerHTML = "";
	document.getElementById('cboSewingFactory').innerHTML = "<option value=\"\">Select One</option>";	
}
function LoadQtyWhenChangeSewFactory(obj)
{
	var color	= document.getElementById('cboColor').value.trim();
	var sFac	= obj.value
	var styleId	= document.getElementById('cboPONo').value.trim();
	
	var url   = "defectGatepassdb.php?request=LoadQtyWhenChangeSewFactory&color="+URLEncode(color)+"&sFac="+sFac+"&styleId="+styleId;
	htmlobj   = $.ajax({url:url,async:false});
	
	var XMLGPQty = htmlobj.responseXML.getElementsByTagName('gatePassQty');
	document.getElementById('txtGatepassQty').value = XMLGPQty[0].childNodes[0].nodeValue;
}
function checkBalance(obj)
{
	var AvailQty = parseFloat(document.getElementById('txtAvailableQty').value.trim());
	if(obj.value>AvailQty)
	{
		document.getElementById('txtSendQty').value = AvailQty;
	}
}
function Save_Send()
{
	if(document.getElementById('cboPONo').value=="")
	{
		alert("Please select a PO No.");
		document.getElementById('cboPONo').focus();
		return;
	}
	if(document.getElementById('cboColor').value=="")
	{
		alert("Please select a Colour.");
		document.getElementById('cboColor').focus();
		return;
	}
	if(document.getElementById('txtSendQty').value=="" || document.getElementById('txtSendQty').value==0 )
	{
		alert("Please enter a valid Gatepass Qty.");
		document.getElementById('txtSendQty').focus();
		return;
	}
	if(document.getElementById('txtToFactory').value=="" )
	{
		alert("Please select To Factory.");
		document.getElementById('txtToFactory').focus();
		return;
	}
	
	var url = "defectGatepassdb.php?request=getDefectGatepassNo";
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLAdmin 	= htmlobj.responseXML.getElementsByTagName("Admin");
	if(XMLAdmin[0].childNodes[0].nodeValue=="TRUE")
	{
		var XMLNo 		  = htmlobj.responseXML.getElementsByTagName("No");	
		var XMLYear 	  = htmlobj.responseXML.getElementsByTagName("Year");
		pub_DefctGPNo 	  = parseInt(XMLNo[0].childNodes[0].nodeValue);				
		pub_DefectGPYear  = parseInt(XMLYear[0].childNodes[0].nodeValue);	
		document.getElementById("txtGatePassNo").value = pub_DefectGPYear +  "/"  + pub_DefctGPNo ;
		SaveData();
	}
	else
	{
		alert("Error in getting new Defect No\nPlease contact system administrator");
		return;
	}
}
function SaveData()
{
	var PONo	  = document.getElementById('cboPONo').value;
	var color 	  = document.getElementById('cboColor').value.trim();
	var vehicleNo = document.getElementById('txtVehicleNo').value;
	var sewingFac = document.getElementById('cboSewingFactory').value;
	var sendQty   = document.getElementById('txtSendQty').value;
	var toFactory = document.getElementById('txtToFactory').value;
	var Remarks   = document.getElementById('txtRemarks').value.trim();
	
	var url = "defectGatepassdb.php?request=saveData&defectGPNo="+pub_DefctGPNo+"&defectGPYear="+pub_DefectGPYear+"&PONo="+PONo+"&color="+URLEncode(color)+"&vehicleNo="+URLEncode(vehicleNo)+"&sewingFac="+sewingFac+"&sendQty="+sendQty+"&toFactory="+toFactory+"&Remarks="+URLEncode(Remarks);
	htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="Saved")
	{
		alert("Saved Successfully.");
		document.frmWasDefectGatepass.reset();
		document.getElementById('cboColor').innerHTML = "";
		document.getElementById('cboSewingFactory').innerHTML = "<option value=\"\">Select One</option>";
		document.getElementById('Save').style.display = "none";
		//document.getElementById('butReport').style.display = "inline";
	}
	else
	{
		alert("Saving Error.");
		return;
	}
}
function clearForm()
{
	location.href = "defectGatepass.php";
}