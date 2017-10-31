
function LoadOrderNo(styleId)
{
	var styleID = styleId;
	var url = 'shippingorderdataXML.php?Request=loadItem&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
	LoadSCNo(styleID);
	
}
function LoadSCNo(styleId)
{
	var styleID = styleId;
	var url = 'shippingorderdataXML.php?Request=loadSCNo&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLScNo = htmlobj.responseText;
	document.getElementById('cboSCNo').innerHTML = XMLScNo;
	
}


function SetOrderNo(obj)
{
	$('#cboOrderNo').val(obj.value);
}

function SetSCNo(obj)
{
	$('#cboSCNo').val(obj.value);
}

function loadDetails(orderid)
{
	document.frmShipDetail.reset();
	var orderID = orderid;
	var url="shippingorderdataXML.php?Request=loadshippingData&orderID="+URLEncode(orderID);
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLStyleID				= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLstrStyle				= htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLMaterialNo			= htmlobj.responseXML.getElementsByTagName("strMaterialNo");		
	var XMLConstructionType		= htmlobj.responseXML.getElementsByTagName("strConstructionType");
	var XMLstrLabel				= htmlobj.responseXML.getElementsByTagName("strLabel");
	var XMLPrePackCode			= htmlobj.responseXML.getElementsByTagName("strPrePackCode");
	var XMLdblCTN_l				= htmlobj.responseXML.getElementsByTagName("dblCTN_l");
	var XMLdblCTN_w				= htmlobj.responseXML.getElementsByTagName("dblCTN_w");
	var XMLdblCTN_h				= htmlobj.responseXML.getElementsByTagName("dblCTN_h");
	var XMLstrWashCode			= htmlobj.responseXML.getElementsByTagName("strWashCode");
	var XMLstrArticle			= htmlobj.responseXML.getElementsByTagName("strArticle");
	var XMLstrItemNo			= htmlobj.responseXML.getElementsByTagName("strItemNo");
	var XMLItemGeneralDesc		= htmlobj.responseXML.getElementsByTagName("strItemGeneralDesc");
	var XMLItemSpecDesc			= htmlobj.responseXML.getElementsByTagName("strItemSpecDesc");
	var XMLManufactOrderNo		= htmlobj.responseXML.getElementsByTagName("strManufactOrderNo");
	var XMLManufactStyle		= htmlobj.responseXML.getElementsByTagName("strManufactStyle");
	var XMLSortingType			= htmlobj.responseXML.getElementsByTagName("strSortingType");		
	var XMLstrWeightUnit		= htmlobj.responseXML.getElementsByTagName("strWeightUnit");
	var XMLstrMRP				= htmlobj.responseXML.getElementsByTagName("strMRP");
	var XMLDivisionId			= htmlobj.responseXML.getElementsByTagName("intDivisionId");
	var XMLSeasonId				= htmlobj.responseXML.getElementsByTagName("intSeasonId");
	var XMLCompanyID			= htmlobj.responseXML.getElementsByTagName("intCompanyID");
	var XMLOrderColorCode		= htmlobj.responseXML.getElementsByTagName("strOrderColorCode");
	var XMLHSCode				= htmlobj.responseXML.getElementsByTagName("strHSCode");
	var XMLMondialPONo			= htmlobj.responseXML.getElementsByTagName("MondialPONo");
	var XMLType					= htmlobj.responseXML.getElementsByTagName("Type");	
	
	
	if(XMLStyleID.length <=0)
	{
		alert("No record found to view details.");
		return;
	}
	if(XMLType[0].childNodes[0].nodeValue==0)
	{
		document.getElementById('cboStyle').value 			= XMLstrStyle[0].childNodes[0].nodeValue;
		document.getElementById('cboDivision').value 		= XMLDivisionId[0].childNodes[0].nodeValue;
		document.getElementById('cboSeason').value 			= XMLSeasonId[0].childNodes[0].nodeValue;
		document.getElementById('cboManufacturee').value 	= XMLCompanyID[0].childNodes[0].nodeValue;
		document.getElementById('txtColor').value 			= XMLOrderColorCode[0].childNodes[0].nodeValue;
		
	}
	else
	{
		document.getElementById('cboStyle').value 			= XMLstrStyle[0].childNodes[0].nodeValue;
		document.getElementById('cboDivision').value 		= XMLDivisionId[0].childNodes[0].nodeValue;
		document.getElementById('cboSeason').value 			= XMLSeasonId[0].childNodes[0].nodeValue;
		document.getElementById('cboManufacturee').value 	= XMLCompanyID[0].childNodes[0].nodeValue;
		document.getElementById('txtColor').value 			= XMLOrderColorCode[0].childNodes[0].nodeValue;
		document.getElementById('txtMaterial').value 		= XMLMaterialNo[0].childNodes[0].nodeValue;
		document.getElementById('txtConType').value 		= XMLConstructionType[0].childNodes[0].nodeValue;		
		document.getElementById('txtLable').value 			= XMLstrLabel[0].childNodes[0].nodeValue;
		document.getElementById('txtPrePackCode').value 	= XMLPrePackCode[0].childNodes[0].nodeValue;
		document.getElementById('txt_l').value 				= XMLdblCTN_l[0].childNodes[0].nodeValue;
		document.getElementById('txt_w').value 				= XMLdblCTN_w[0].childNodes[0].nodeValue;
		document.getElementById('txt_h').value 				= XMLdblCTN_h[0].childNodes[0].nodeValue;
		document.getElementById('txtWashCode').value 		= XMLstrWashCode[0].childNodes[0].nodeValue;
		document.getElementById('txtArticle').value 		= XMLstrArticle[0].childNodes[0].nodeValue;		
		document.getElementById('txtItemNo').value 			= XMLstrItemNo[0].childNodes[0].nodeValue;		
		document.getElementById('txtGenItem').value 		= XMLItemGeneralDesc[0].childNodes[0].nodeValue;
		document.getElementById('txtSpecItem').value 		= XMLItemSpecDesc[0].childNodes[0].nodeValue;		
		document.getElementById('txtManuOrdNo').value 		= XMLManufactOrderNo[0].childNodes[0].nodeValue;		
		document.getElementById('txtManuStyle').value 		= XMLManufactStyle[0].childNodes[0].nodeValue;
		document.getElementById('txtSortType').value 		= XMLSortingType[0].childNodes[0].nodeValue;		
		document.getElementById('txtWTUnit').value 			= XMLstrWeightUnit[0].childNodes[0].nodeValue;
		document.getElementById('txtMRP').value 			= XMLstrMRP[0].childNodes[0].nodeValue;
		document.getElementById('cboDivision').value 		= XMLDivisionId[0].childNodes[0].nodeValue;
		document.getElementById('cboSeason').value 			= XMLSeasonId[0].childNodes[0].nodeValue;
		document.getElementById('cboManufacturee').value 	= XMLCompanyID[0].childNodes[0].nodeValue;
		document.getElementById('txtHSCode').value 			= XMLHSCode[0].childNodes[0].nodeValue;
		document.getElementById('txtMondialPONo').value 	= XMLMondialPONo[0].childNodes[0].nodeValue;
		
	}
	
}
function SaveShipingData()
{
	showPleaseWait();
	if(!SaveValidation())
	return;
	
	var orderNo 	= $('#cboOrderNo').val();
	var material 	= $('#txtMaterial').val();
	var ConType 	= $('#txtConType').val();
	var Lable 		= $('#txtLable').val();
	var MRP 		= $('#txtMRP').val();
	var PrePackCode = $('#txtPrePackCode').val();
	var CTN_l 		= $('#txt_l').val();
	var CTN_w	 	= $('#txt_w').val();
	var CTN_h 		= $('#txt_h').val();
	var WashCode 	= $('#txtWashCode').val();
	var Article 	= $('#txtArticle').val();
	var ItemNo 		= $('#txtItemNo').val();
	var GenItem 	= $('#txtGenItem').val();
	var SpecItem 	= $('#txtSpecItem').val();
	var ManuOrdNo 	= $('#txtManuOrdNo').val();
	var ManuStyle 	= $('#txtManuStyle').val();
	var SortType 	= $('#txtSortType').val();
	var WTUnit 		= $('#txtWTUnit').val();
	var HSCode 		= $('#txtHSCode').val();
	var mondialPONo = $('#txtMondialPONo').val();
	
	var url="shippingorderdataXML.php?Request=SaveshippingData&orderNo="+URLEncode(orderNo)+"&material="+URLEncode(material)+"&ConType="+URLEncode(ConType)+"&Lable="+URLEncode(Lable)+"&MRP="+URLEncode(MRP)+"&PrePackCode="+URLEncode(PrePackCode)+"&CTN_l="+URLEncode(CTN_l)+"&CTN_w="+URLEncode(CTN_w)+"&CTN_h="+URLEncode(CTN_h)+"&WashCode="+URLEncode(WashCode)+"&Article="+URLEncode(Article)+"&ItemNo="+URLEncode(ItemNo)+"&GenItem="+URLEncode(GenItem)+"&SpecItem="+URLEncode(SpecItem)+"&ManuOrdNo="+URLEncode(ManuOrdNo)+"&ManuStyle="+URLEncode(ManuStyle)+"&SortType="+URLEncode(SortType)+"&WTUnit="+URLEncode(WTUnit)+"&HSCode="+URLEncode(HSCode)+"&mondialPONo="+URLEncode(mondialPONo);
	var xml_http_obj =$.ajax({url:url,async:false});
	
	if(xml_http_obj.responseText=="saved")
	{
		
		alert("saved successfully.")
		ClearForm();
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="update")
	{
		alert("updated successfully.");
		ClearForm();
		hidePleaseWait();
	}
	else
	{
		alert("error");
		hidePleaseWait();
	}	
}
function SaveValidation()
{
	if(document.getElementById('cboOrderNo').value=="")
	{
		alert("Please select 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		hidePleaseWait();
		return false;
	}
 	else if(trim(document.getElementById('txtGenItem').value)=="")
	{
		alert("Please enter 'Item general description'.");
		document.getElementById('txtGenItem').focus();
		hidePleaseWait();
		return false;
	}
	else if(trim(document.getElementById('txtWashCode').value)=="")
	{
		alert("Please enter 'Wash Code'.");
		document.getElementById('txtWashCode').focus();
		hidePleaseWait();
		return false;
	}		
	else if(trim(document.getElementById('txtHSCode').value)=="")
	{
		alert("Please enter 'HS Code'.");
		document.getElementById('txtHSCode').focus();
		hidePleaseWait();
		return false;
	}
	return true;
	
}
function ClearForm()
{
	document.frmShipHeader.reset();
	document.frmShipDetail.reset();
}
