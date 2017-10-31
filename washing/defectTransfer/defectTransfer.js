// JavaScript Document
var pub_DefctNo=0;
var pub_DefectYear = 0;
function loadColor(obj)
{
	if(obj.value=="")
	{
		clearAll();
		return;
	}
	document.getElementById('cboStyleNo').value = obj.value;
	document.getElementById('txtSendQty').value = "";
	var url = "defectTransferdb.php?request=loadColor&orderNo="+obj.value.trim();
	htmlobj = $.ajax({url:url,async:false});
	var XMLQty = htmlobj.responseXML.getElementsByTagName("Color");
	document.getElementById('cboColour').innerHTML=XMLQty[0].childNodes[0].nodeValue;
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

	var color = document.getElementById('cboColour').value.trim();
	var url   = "defectTransferdb.php?request=loadQty&orderNo="+obj.value.trim()+"&color="+URLEncode(color);
	htmlobj   = $.ajax({url:url,async:false});
	
	var XMLOrderQty  = htmlobj.responseXML.getElementsByTagName('orderQty');
	var XMLStockQty  = htmlobj.responseXML.getElementsByTagName('stockQty');
	var XMLNr		 = htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany	 = htmlobj.responseXML.getElementsByTagName("cName");
	
	if(XMLNr.length>0)
	{
		
		if(XMLNr[0].childNodes[0].nodeValue==1)
		{
			document.getElementById('cboSewingFactory').innerHTML = XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById('cboSewingFactory').disabled  = true;
 			document.getElementById('txtOrderQty').value 		  = XMLOrderQty[0].childNodes[0].nodeValue;
			document.getElementById('txtStockQty').value  		  = XMLStockQty[0].childNodes[0].nodeValue;
		
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
function LoadQtyWhenChangeSewFactory(obj)
{
	var color	= document.getElementById('cboColour').value.trim();
	var sFac	= obj.value
	var styleId	= document.getElementById('cboPONo').value.trim();
	
	var url   = "defectTransferdb.php?request=LoadQtyWhenChangeSewFactory&color="+URLEncode(color)+"&sFac="+sFac+"&styleId="+styleId;
	htmlobj   = $.ajax({url:url,async:false});
	
	var XMLStockQty = htmlobj.responseXML.getElementsByTagName('stockQty');
	document.getElementById('txtStockQty').value = XMLStockQty[0].childNodes[0].nodeValue;
	
}
function checkBalance(obj)
{
	var stockQty = parseFloat(document.getElementById('txtStockQty').value.trim());
	if(obj.value>stockQty)
	{
		document.getElementById('txtSendQty').value = stockQty;
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
	if(document.getElementById('cboColour').value=="")
	{
		alert("Please select a Colour.");
		document.getElementById('cboColour').focus();
		return;
	}
	if(document.getElementById('txtSendQty').value=="")
	{
		alert("Please enter a Transfer Qty.");
		document.getElementById('txtSendQty').focus();
		return;
	}

	/*if(document.getElementById('txtRemarks').value=="")
	{
		alert("aaa");
		alert("Please enter a Reason.");
		document.getElementById('txtRemarks').focus();
		return;
	}*/
	
	var url = "defectTransferdb.php?request=getDefectNo";
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLAdmin 	= htmlobj.responseXML.getElementsByTagName("Admin");
	if(XMLAdmin[0].childNodes[0].nodeValue=="TRUE")
	{
		var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No");	
		var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year");
		pub_DefctNo 	= parseInt(XMLNo[0].childNodes[0].nodeValue);				
		pub_DefectYear  = parseInt(XMLYear[0].childNodes[0].nodeValue);	
		document.getElementById("txtDefectNo").value = pub_DefectYear +  "/"  + pub_DefctNo ;
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
	var color 	  = document.getElementById('cboColour').value.trim();
	var sewingFac = document.getElementById('cboSewingFactory').value;
	var sendQty   = document.getElementById('txtSendQty').value;
	var Remarks   = document.getElementById('txtRemarks').value.trim();
	
	var url = "defectTransferdb.php?request=saveData&defectNo="+pub_DefctNo+"&defectYear="+pub_DefectYear+"&PONo="+PONo+"&color="+URLEncode(color)+"&sewingFac="+sewingFac+"&sendQty="+sendQty+"&Remarks="+URLEncode(Remarks);
	htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="Saved")
	{
		alert("Saved Successfully.");
		document.frmWasDefectTransfer.reset();
		document.getElementById('cboColour').innerHTML = "";
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
	location.href = "defectTransfer.php";
}
function clearAll()
{	
	document.frmWasDefectTransfer.reset();
	document.getElementById('cboColour').innerHTML = "";
	document.getElementById('cboSewingFactory').innerHTML = "<option value=\"\">Select One</option>";	
}
/*function loadDetails(defectNo)
{
	if(defectNo=="")
	{
		return;
	}
	document.getElementById('txtDefectNo').value = defectNo;
	
	var url = "defectTransferdb.php?request=loadDetails&defectNo="+defectNo;
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLstyleId 	= htmlobj.responseXML.getElementsByTagName("styleId");
	var XMLColor	= htmlobj.responseXML.getElementsByTagName("color");
	var XMLDate   	= htmlobj.responseXML.getElementsByTagName('Date');
	var XMLQty   	= htmlobj.responseXML.getElementsByTagName('Qty'); 
	var XMLRemarks  = htmlobj.responseXML.getElementsByTagName('Remarks');
	
	document.getElementById('cboPONo').value	= XMLstyleId[0].childNodes[0].nodeValue;
	document.getElementById('cboPONo').onchange();
	document.getElementById('txtDate').value	= XMLDate[0].childNodes[0].nodeValue;
	document.getElementById('txtSendQty').value	= XMLQty[0].childNodes[0].nodeValue;
	document.getElementById('txtRemarks').value	= XMLRemarks[0].childNodes[0].nodeValue;
	document.getElementById('Save').style.display='none'; 
}
*/