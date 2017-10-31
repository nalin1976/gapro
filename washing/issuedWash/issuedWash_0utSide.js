// JavaScript Document
function loadOutSideDet(obj){
	clearCombo()
	var path="issuedWash_0utSide_xml.php?req=loadOutSideDet&poNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLStyelName	= htmlobj.responseXML.getElementsByTagName('Style');
	var XMLColor		= htmlobj.responseXML.getElementsByTagName("Color");
	var XMLMillId		= htmlobj.responseXML.getElementsByTagName("MillId");
	var XMLMill			= htmlobj.responseXML.getElementsByTagName("Mill");
	var XMLDivisionId	= htmlobj.responseXML.getElementsByTagName("DivisionId");
	var XMLDivision		= htmlobj.responseXML.getElementsByTagName("Division");
	var XMLFactoryId	= htmlobj.responseXML.getElementsByTagName("FactoryId");
	var XMLFactory		= htmlobj.responseXML.getElementsByTagName("Factory");
	var XMLFabricId		= htmlobj.responseXML.getElementsByTagName("FabricId");
	var XMLFabric		= htmlobj.responseXML.getElementsByTagName("Fabric");
	var XMLSize			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLQty			= htmlobj.responseXML.getElementsByTagName("Qty");
	if(XMLStyelName.length > 0){
		
		var opt = document.createElement("option");
		opt.value 	= XMLStyelName[0].childNodes[0].nodeValue;	
		opt.text 	= XMLStyelName[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_style").options.add(opt);
		

		var opt = document.createElement("option");
		opt.value 	= XMLColor[0].childNodes[0].nodeValue;	
		opt.text 	= XMLColor[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_color").options.add(opt);
		
		
		var opt = document.createElement("option");
		opt.value 	= XMLMillId[0].childNodes[0].nodeValue;	
		opt.text 	= XMLMill[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_mill").options.add(opt);
		
		
		var opt = document.createElement("option");
		opt.value 	= XMLDivisionId[0].childNodes[0].nodeValue;	
		opt.text 	= XMLDivision[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_division").options.add(opt);
		
		
		var opt = document.createElement("option");
		opt.value 	= XMLFactoryId[0].childNodes[0].nodeValue;	
		opt.text 	= XMLFactory[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_factory").options.add(opt);
		
		var opt = document.createElement("option");
		opt.value 	= XMLFabric[0].childNodes[0].nodeValue;	
		opt.text 	= XMLFabricId[0].childNodes[0].nodeValue;	
		document.getElementById("issuedWash_os_fbId").options.add(opt);
		
		document.getElementById('issuedWash_os_size').value=XMLSize[0].childNodes[0].nodeValue;
		document.getElementById('issuedWash_os_qty').value=XMLQty[0].childNodes[0].nodeValue;
	}
}

function ClearFormOS(){
	document.getElementById('frmIssuedWash_os').reset();
	clearCombo();
}
function clearCombo()
{
	document.getElementById("issuedWash_os_mill").innerHTML="";
	document.getElementById("issuedWash_os_color").innerHTML="";
	document.getElementById("issuedWash_os_style").innerHTML="";
	document.getElementById("issuedWash_os_division").innerHTML="";
	document.getElementById("issuedWash_os_factory").innerHTML="";
	document.getElementById("issuedWash_os_fbId").innerHTML="";
}
function validateForm(){

	var poNo       =	document.getElementById('issuedWash_os_pono').value.trim();
	var style		=	document.getElementById('issuedWash_os_style').value.trim();
	var color		=	document.getElementById('issuedWash_os_color').value.trim();
	var mill		=	document.getElementById('issuedWash_os_mill').value.trim();
	var division	=	document.getElementById('issuedWash_os_division').value.trim();
	var factory		=	document.getElementById('issuedWash_os_factory').value.trim();
	var gpno		=	document.getElementById('issuedWash_os_gpno').value.trim();
	var fbId		=	document.getElementById('issuedWash_os_fbId').value.trim();
	var cutno		=	document.getElementById('issuedWash_os_cutno').value.trim();
	var size		=	document.getElementById('issuedWash_os_size').value.trim();
	var purpose		=	document.getElementById('issuedWash_os_purpose').value.trim();
	var qty			=	document.getElementById('issuedWash_os_qty').value.trim();
	var term		=	document.getElementById('issuedWash_os_term').value.trim();
	
	if(poNo==""){
		alert("Select 'PONo'.");
		document.getElementById('issuedWash_os_pono').focus();
		return false;
	}
	if(style==""){
		alert("Select 'Style No'.");
		document.getElementById('issuedWash_os_style').focus();
		return false;
	}
	if(color==""){
		alert("Select 'Color'.");
		document.getElementById('issuedWash_os_color').focus();
		return false;
	}
	if(mill==""){
		alert("Select 'Mill'.");
		document.getElementById('issuedWash_os_mill').focus();
		return false;
	}
	if(division==""){
		alert("Select 'Division'.");
		document.getElementById('issuedWash_os_division').focus();
		return false;
	}
	if(factory==""){
		alert("Select 'Factory'.");
		document.getElementById('issuedWash_os_factory').focus();
		return false;
	}
	if(gpno==""){
		alert("Enter 'Gatepass No'.");
		document.getElementById('issuedWash_os_gpno').focus();
		return false;
	}
	if(fbId==""){
		alert("Enter 'Fabric ID'.");
		document.getElementById('issuedWash_os_fbId').focus();
		return false;
	}
	if(cutno==""){
		alert("Enter 'Cut No'.");
		document.getElementById('issuedWash_os_pono').focus();
		return false;
	}
	if(size==""){
		alert("Enter 'Size'.");
		document.getElementById('issuedWash_os_size').focus();
		return false;
	}
	if(purpose==""){
		alert("Enter 'Fabric purpose'.");
		document.getElementById('issuedWash_os_purpose').focus();
		return false;
	}
	if(qty==""){
		alert("Enter 'Wash Qty'.");
		document.getElementById('issuedWash_os_qty').focus();
		return false;
	}
	if(term==""){
		alert("Enter 'Term'.");
		document.getElementById('issuedWash_os_term').focus();
		return false;
	}
	
	saveIssuedWash_os(poNo,style,color,mill,division,factory,gpno,fbId,cutno,size, purpose,qty,term)
	
}
function saveIssuedWash_os(poNo,style,color,mill,division,factory,gpno,fbId,cutno,size,purpose,qty,term){
	
	var path="issuedWash_0utSide_xml.php?req=saveOutSideDet&poNo="+poNo;
	path+="&style="+style+"&color="+URLEncode(color)+"&mill="+mill+"&division="+division+"&factory="+factory+"&gpno="+gpno+"&fbId="+fbId+"&cutno="+cutno+"&size="+URLEncode(size)+"&purpose="+purpose+"&qty="+qty+"&term="+term;
	htmlobj=$.ajax({url:path,async:false});	
	var XMLResult=htmlobj.responseXML.getElementsByTagName("Result");
	if(XMLResult[0].childNodes[0].nodeValue)
	{
		alert("Saved successfully.");
		ClearFormOS('new');
		return false;
	}
	else{
		alert("Saving error.");
		return false;
	}
	
}