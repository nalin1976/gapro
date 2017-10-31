var pub_AodNo	= 0;
var pub_AodYear = 0;
		
function ClearForm(tabIndex)
{
	if(tabIndex=='0')
	{
		document.frmWasSubContract_send.reset();
		RemoveComboValue('cboColor');
		document.getElementById('Save').style.display='inline';
		document.getElementById('butReport').style.display='none';
	}
	else
	{
		document.frmWasSubContract_receive.reset();
		RemoveComboValue('cboReColor');
		document.getElementById('Save').style.display='inline';
		document.getElementById('butReport').style.display='none';
		//document.getElementById('cboStyleNo').innerHTML='';
		//document.getElementById('cboReOrderNo').innerHTML='';
		document.getElementById('cboSubInSFromFac').innerHTML=''; 
	}
}
function getOrdeNo(obj){
	var path="subcontractorxml.php?RequestType=LoadStyleAndOderNo&fFac="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLPO=htmlobj.responseXML.getElementsByTagName("PO")[0].childNodes[0].nodeValue;
	document.getElementById('cboOrderNo').innerHTML=XMLPO;
	var XMLStyle=htmlobj.responseXML.getElementsByTagName("Style")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNo2').innerHTML=XMLStyle;
}
function RemoveComboValue(obj)
{
	/*alert(document.getElementById(obj).value)
	alert(document.getElementById(obj));*/
	var index = document.getElementById(obj).options.length;
	while(document.getElementById(obj).options.length > 0) 
	{
		index --;
		document.getElementById(obj).options[index] = null;
	}
}

function LoadOrderNo(obj,tabIndex)
{
	var tbl = (tabIndex=='0'? 'cboOrderNo':'cboReOrderNo');
	RemoveComboValue(tbl);
	var url  = "subcontractorxml.php?RequestType=LoadOrderNo";
		url += "&StyleNo="+URLEncode(obj.value);
		url += "&TabIndex="+tabIndex;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById(tbl).innerHTML = htmlobj.responseText;
}

function LoadColor(obj,tabIndex)
{
	if(obj.value.trim()==""){
		ClearForm(tabIndex);
		return false;	
	}
	var tbl = (tabIndex=='0'? 'cboColor':'cboReColor');
	RemoveComboValue(tbl);
	var url  = "subcontractorxml.php?RequestType=LoadColor";
	    url += "&OrderId="+obj.value;
		url += "&TabIndex="+tabIndex;
	htmlobj  = $.ajax({url:url,async:false});
	
	document.getElementById(tbl).innerHTML = htmlobj.responseText;
	document.getElementById(tbl).onchange();
	
	var XMLNr=htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany=htmlobj.responseXML.getElementsByTagName("cName");
	var fac;
	if(tabIndex==1){
		fac='cboSubInSFromFac';
	}
	else{
		fac='cboSubOutFromFac';
	}
	if(XMLNr.length>0){
		//alert(XMLNr[0].childNodes[0].nodeValue)
		if(XMLNr[0].childNodes[0].nodeValue==1){
			document.getElementById(fac).innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById(fac).disabled=true;
			if(tabIndex==0){
				LoadDetails(document.getElementById(tbl));
			}else{
				LoadReDetails(document.getElementById(tbl))
			}
		}
		else{
			document.getElementById(fac).innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			alert("Please select 'Sewing Factory'.");
			document.getElementById(fac).disabled=false
			return false;
		}
		
	}
	//LoadDetails(document.getElementById(tbl));
}

function LoadDetails(obj)
{
	var url  = "subcontractorxml.php?RequestType=LoadDetails";
		url += "&OrderId="+document.getElementById('cboOrderNo').value;
		url += "&Color="+URLEncode(obj.value);
		url += "&fFC="+document.getElementById('cboSubOutFromFac').value.trim();
	htmlobj  = $.ajax({url:url,async:false});
	
	var totS_ReceiveQty = parseFloat(htmlobj.responseXML.getElementsByTagName("TotReceiveQty")[0].childNodes[0].nodeValue);
	var totS_SeToOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotSendToOut")[0].childNodes[0].nodeValue);
	var totS_ReFrOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotReFrOut")[0].childNodes[0].nodeValue);
	var OrderQty		= parseFloat(htmlobj.responseXML.getElementsByTagName("OrderQty")[0].childNodes[0].nodeValue);
	var RvdQty			= parseFloat(htmlobj.responseXML.getElementsByTagName("RvdQty")[0].childNodes[0].nodeValue);
	
	document.getElementById('txtTotReceiveQty').value 	= totS_ReceiveQty;
	document.getElementById('txtSeToOut').value 		= totS_SeToOut;
	document.getElementById('txtReFrOut').value 		= totS_ReFrOut;
	document.getElementById('txtS_sendNow').value 		= totS_ReceiveQty;
	document.getElementById('txtS_BalQty').value 		= 0;
	document.getElementById('subSend_orderQty').value 		= OrderQty;
	document.getElementById('subSend_washRcvd').value 		= RvdQty;
	document.getElementById('cboSContractor').focus();
}

function setStyleAndPo(v){
	/*if(v==2){
	loadCombo("select distinct O.strStyle from was_stocktransactions WS inner join orders O on O.intStyleId=WS.intStyleId where  WS.strType='SubOut' order by O.strStyle",'cboStyleNo');	
	document.getElementById().onchange();
	}*/
	
}

function ValidateBalQty(obj)
{
	var sendNow = ((obj.value=="") ? 0:parseFloat(obj.value));
	document.getElementById('txtS_sendNow').value = sendNow;
	var totReQty	= parseFloat(document.getElementById('txtTotReceiveQty').value);
	if(sendNow>totReQty){
		obj.value = totReQty;
		document.getElementById('txtS_BalQty').focus();
		sendNow = parseFloat(document.getElementById('txtS_sendNow').value);
	}
	document.getElementById('txtS_BalQty').value = totReQty - sendNow;
}

function Save_Send()
{
	var styleId 	= document.getElementById('cboOrderNo');
	var sCotractor	= document.getElementById('cboSContractor');
	var color		= document.getElementById('cboColor');
	var sendNow		= document.getElementById('txtS_sendNow');
	var aodNo		= document.getElementById('txtAODNo').value;
	var purpose		= document.getElementById('txtPurpose');
	var fFac		= document.getElementById('cboSubOutFromFac').value;
	var vNo			= document.getElementById('subSend_vehicleNo').value.trim();
	if(fFac.trim()==""){
		alert("Please select 'Sewing Factory.'");
		document.getElementById('cboSubOutFromFac').focus();
		return false;
	}
	if(!ValidateInterface(styleId,sCotractor,color,sendNow))
		return;
	if(aodNo=="")
		GetSerialNo();
	else
	{
		No 			 = aodNo.split("/");		
		pub_AodNo 	 = parseInt(No[1]);
		pub_AodYear  = parseInt(No[0]);			
	}
	SaveHeader(styleId,sCotractor,color,sendNow,purpose,fFac,vNo);
}

function ValidateInterface(styleId,sCotractor,color,sendNow)
{
	
	
	if(styleId.value=="")
	{
		alert("Please select 'Order No'.");
		styleId.focus();
		return false;		
	}
	else if(sCotractor.value=="")
	{
		alert("Please select 'Sub Contractor'.");
		sCotractor.focus();
		return false;		
	}
	else if(color.value=="")
	{
		alert("Please select 'Color'.");
		color.focus();
		return false;		
	}
	else if(sendNow.value=="")
	{
		alert("Please enter 'Send Now Qty'.");
		sendNow.focus();
		return false;		
	}
	return true;
}

function GetSerialNo()
{
	var url = "subcontractordb.php?RequestType=GetSerialNo";	
	htmlobj = $.ajax({url:url,async:false});
	var XMLAdmin = htmlobj.responseXML.getElementsByTagName("Admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLNo 	= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var XMLYear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_AodNo	= XMLNo;
		pub_AodYear = XMLYear;
		document.getElementById('txtAODNo').value = XMLYear+"/"+XMLNo;
	}
	else
	{
		alert("Please contact system administrator to assign 'New Serial No'.");
		return;
	}
}

function SaveHeader(styleId,sCotractor,color,sendNow,purpose,fFac,vNo)
{
	var url  = "subcontractordb.php?RequestType=URLSaveHeader";
		url += "&AodNo="+pub_AodNo;
		url += "&AodYear="+pub_AodYear;
		url += "&StyleId="+styleId.value;
		url += "&SCotractor="+sCotractor.value;
		url += "&Color="+URLEncode(color.value);
		url += "&Purpose="+URLEncode(purpose.value);
		url += "&Qty="+sendNow.value;
		url += "&fFac="+fFac;
		url += "&vNo="+URLEncode(vNo);
		
		
 	htmlobj = $.ajax({url:url,async:false});
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
	if(XMLResult=='TRUE')
	{
		alert("Saved successfully.");
		document.getElementById('Save').style.display='none';
		document.getElementById('butReport').style.display='inline';
		
		//ClearForm();
	}
	else
	{
		alert("Error occur while saving data.Please save it again.");
	}
}

//BEGIN 
function LoadReDetails(obj)
{
	var url  = "subcontractorxml.php?RequestType=URLLoadReDetails";
		url += "&OrderId="+document.getElementById('cboReOrderNo').value;
		url += "&Color="+URLEncode(obj.value);
		url += "&sFac="+document.getElementById('cboSubInSFromFac').value;
	htmlobj  = $.ajax({url:url,async:false});
	
	var totS_SeToOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotSendToOut")[0].childNodes[0].nodeValue);
	var totS_ReFrOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotReFrOut")[0].childNodes[0].nodeValue);
	var subContractor	= htmlobj.responseXML.getElementsByTagName("SubContractor")[0].childNodes[0].nodeValue;  
	
	document.getElementById('txtRe_BalToReQty').value 	= totS_SeToOut-totS_ReFrOut;
	document.getElementById('txtRe_ToOut').value 		= totS_SeToOut;
	document.getElementById('txtRe_ReFrOut').value 		= totS_ReFrOut;
	document.getElementById('txtRe_ReNow').value 		= totS_SeToOut-totS_ReFrOut;
	document.getElementById('txtRe_BalQty').value 		= 0;
	document.getElementById('txtReAODNo').focus();
	document.getElementById('cboRe_SContractor').value=subContractor;
}

function ValidateReBalQty(obj)
{
	var sendNow = ((obj.value=="") ? 0:parseFloat(obj.value));
	document.getElementById('txtRe_ReNow').value = sendNow;
	var totReQty	= parseFloat(document.getElementById('txtRe_BalToReQty').value);
	if(sendNow>totReQty){
		obj.value = totReQty;
		document.getElementById('txtRe_BalQty').focus();
		sendNow = parseFloat(document.getElementById('txtRe_ReNow').value);
	}
	document.getElementById('txtRe_BalQty').value = totReQty - sendNow;
}
function Save_Receive()
{
	var styleId 	= document.getElementById('cboReOrderNo');
	var sCotractor	= document.getElementById('cboRe_SContractor');
	var color		= document.getElementById('cboReColor');
	var sendNow		= document.getElementById('txtRe_ReNow');
	var serialNo	= document.getElementById('txtRe_SerialNo');
	var aodNo		= document.getElementById('txtReAODNo');
	var purpose		= document.getElementById('txtRe_Purpose');
	var sFac		= document.getElementById('cboSubInSFromFac');
	
	/*if(docuement.getElementById('subSentAODSearch').value=="")
	{
		alert("Please select 'Sent AOD No'.");
		docuement.getElementById('subSentAODSearch').focus();
		return false;		
	}*/
	
	if(!ValidateReInterface(styleId,sCotractor,color,aodNo,sendNow,sFac))
		return;
	if(serialNo.value=="")
		GetReSerialNo();
	else
	{
		No 			 = serialNo.value.split("/");		
		pub_AodNo 	 = parseInt(No[1]);
		pub_AodYear  = parseInt(No[0]);			
	}
	SaveReHeader(styleId,sCotractor,color,sendNow,aodNo,purpose,sFac);
}
function ValidateReInterface(styleId,sCotractor,color,aodNo,sendNow,sFac)
{
	if(sFac.value=="")
	{
		alert("Please select 'Sent AOD No'.");
		document.getElementById('subSentAODSearch').focus();
		return false;		
	}
	
	if(styleId.value=="")
	{
		alert("Please select 'Order No'.");
		styleId.focus();
		return false;		
	}
	else if(aodNo.value=="")
	{
		alert("Please enter 'AOD No'.");
		aodNo.focus();
		return false;		
	}
	else if(sCotractor.value=="")
	{
		alert("Please select 'Sub Contractor'.");
		sCotractor.focus();
		return false;		
	}
	else if(color.value=="")
	{
		alert("Please select 'Color'.");
		color.focus();
		return false;		
	}	
	else if(sendNow.value=="")
	{
		alert("Please enter 'Send Now Qty'.");
		sendNow.focus();
		return false;		
	}
	return true;
}

function GetReSerialNo()
{
	var url = "subcontractordb.php?RequestType=URLGetReSerialNo";	
	htmlobj = $.ajax({url:url,async:false});
	var XMLAdmin = htmlobj.responseXML.getElementsByTagName("Admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLNo 	= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var XMLYear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_AodNo	= XMLNo;
		pub_AodYear = XMLYear;
		document.getElementById('txtRe_SerialNo').value = XMLYear+"/"+XMLNo;
	}
	else
	{
		alert("Please contact system administrator to assign 'New Serial No'.");
		return;
	}
}

function SaveReHeader(styleId,sCotractor,color,sendNow,aodNo,purpose,sFac)
{
	var url  = "subcontractordb.php?RequestType=URLSaveReHeader";
		url += "&AodNo="+pub_AodNo;
		url += "&AodYear="+pub_AodYear;
		url += "&GpNo="+aodNo.value;
		url += "&StyleId="+styleId.value;
		url += "&SCotractor="+sCotractor.value;
		url += "&Color="+URLEncode(color.value);
		url += "&Purpose="+URLEncode(purpose.value);
		url += "&Qty="+sendNow.value;
		url += "&sFac="+sFac.value;
		
 	htmlobj = $.ajax({url:url,async:false});
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
	if(XMLResult=='TRUE')
	{
		alert("Saved successfully.");
		document.getElementById('butSaveR').style.display='inline';
		ClearForm();
	}
	else
	{
		alert("Error occur while saving data.Please save it again.");
	}
}

function showLogReport(){
	var sc=document.getElementById('sub_cboFactory').value.trim();
	window.open('subcontractRpt.php?req='+document.getElementById('sub_cboPo').value.trim()+"&sc="+sc,'Subcontrator Wip');	
}

function clearF(){
	document.getElementById('outside_cboFactory').value="";	
	document.getElementById('outside_txtDate').value="";
}

function getStyle(obj){
	//alert(obj);
	var path="subcontractorxml.php?RequestType=getStyle&poNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});	
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('Style');
	var XMLCOLOR=htmlobj.responseXML.getElementsByTagName('COLOR');
	var XMLPur=htmlobj.responseXML.getElementsByTagName('PUR');
	var XMLFactory=htmlobj.responseXML.getElementsByTagName('Factory');
	if(XMLStyle.length > 0){
	 document.getElementById('sub_cboStyleNo').value=XMLStyle[0].childNodes[0].nodeValue;
	 $('#sub_cboColor').html("<option value=\""+XMLCOLOR[0].childNodes[0].nodeValue+"\">"+XMLCOLOR[0].childNodes[0].nodeValue+"</option>");
	 document.getElementById('sub_txtPurpose').value=XMLPur[0].childNodes[0].nodeValue;
	 document.getElementById('sub_cboFactory').value=XMLFactory[0].childNodes[0].nodeValue;
	 
	}
}
function getPo(obj){
	var path="subcontractorxml.php?RequestType=getPo&style="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});	
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('PO');
	var XMLCOLOR=htmlobj.responseXML.getElementsByTagName('COLOR');
	var XMLPur=htmlobj.responseXML.getElementsByTagName('PUR');
	var XMLFactory=htmlobj.responseXML.getElementsByTagName('Factory');
	
	 document.getElementById('sub_cboPo').value=XMLStyle[0].childNodes[0].nodeValue;
	 $('#sub_cboColor').html("<option value=\""+XMLCOLOR[0].childNodes[0].nodeValue+"\">"+XMLCOLOR[0].childNodes[0].nodeValue+"</option>");
	 document.getElementById('sub_txtPurpose').value=XMLPur[0].childNodes[0].nodeValue;
	 document.getElementById('sub_cboFactory').value=XMLFactory[0].childNodes[0].nodeValue;
}

/*function loadColor(){
	getStyle( document.getElementById('sub_cboPo') );
}*/

function subReports(){
	
	if(document.frmSubRpt.rdoSubContract[0].checked){
		window.open('subcontractDet.php','Log');
	}
	else if(document.frmSubRpt.rdoSubContract[1].checked){
		window.open('OutSideWip.php','Wip');
	}
}

function showRptPoUp(){
	var url  = "subcontratorReports.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(250,100,'frmReports',1);				
	//drawPopupArea(500,310,'frmProcess');
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmReports').innerHTML=HTMLText;
}
function CloseWindowInBC()
{
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}
}

function GetSentAODDets(obj,e)
{
	if(obj.value==""){
		ClearForm(1);
		return 
	}
	
	var url="subcontractorxml.php?RequestType=GetSentAODDets&SAOD="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	var SFac=htmlobj.responseXML.getElementsByTagName("SFac");
	var SubCon=htmlobj.responseXML.getElementsByTagName("SubContractNo");
	var StyleId=htmlobj.responseXML.getElementsByTagName("StyleId");
	var OrderNo=htmlobj.responseXML.getElementsByTagName("OrderNo");
	var Style=htmlobj.responseXML.getElementsByTagName("Style");
	
	document.getElementById('cboReOrderNo').innerHTML="<option value=\"\"></option><option value=\""+StyleId[0].childNodes[0].nodeValue+"\">"+OrderNo[0].childNodes[0].nodeValue+"</option>"; 
	document.getElementById('cboStyleNo').innerHTML="<option value=\"\"></option><option value=\""+Style[0].childNodes[0].nodeValue+"\">"+Style[0].childNodes[0].nodeValue+"</option>"; 
	document.getElementById('cboSubInSFromFac').value = SFac[0].childNodes[0].nodeValue;
	document.getElementById('cboRe_SContractor').value = SubCon[0].childNodes[0].nodeValue; 
	/*var OUTAOD 		= htmlobj.responseXML.getElementsByTagName("OUTAOD");

	if(OUTAOD.length<=0)
		return;
		document.getElementById('txtFabricDsc').value = OUTAOD[0].childNodes[0].nodeValue;
	var XMLFC 		= htmlobj.responseXML.getElementsByTagName("FC")[0].childNodes[0].nodeValue;
		document.getElementById('cboSubInSFromFac').value = XMLFC;*/
}
//End

function loadGP(){
	var AOD=document.getElementById('txtAODNo').value.trim();
	window.open('rptSubContractorGP.php?req='+AOD,'new');
}

function setMaxLength(obj){
	var len=obj.value.trim().length;
	if(len > 255){
		obj.value=obj.value.substr(0,255);
		return false;
	}
}

function getSubCompanyWiseQty(obj){
	
	var url  = "subcontractorxml.php?RequestType=URLLoadSubComReDetails";
		url += "&OrderId="+document.getElementById('cboReOrderNo').value;
		url += "&Color="+URLEncode(document.getElementById('cboReColor').value.trim());
		url += "&sFac="+document.getElementById('cboSubInSFromFac').value;
		url += "&subFac="+obj.value.trim();
	htmlobj  = $.ajax({url:url,async:false});
	
	//var totS_ReceiveQty = parseFloat(htmlobj.responseXML.getElementsByTagName("TotReceiveQty")[0].childNodes[0].nodeValue);
	var totS_SeToOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotSendToOut")[0].childNodes[0].nodeValue);
	var totS_ReFrOut  	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotReFrOut")[0].childNodes[0].nodeValue);
	//var RvdQty			= parseFloat(htmlobj.responseXML.getElementsByTagName("RvdQty")[0].childNodes[0].nodeValue);
	
	document.getElementById('txtRe_BalToReQty').value 	= totS_SeToOut-totS_ReFrOut;
	document.getElementById('txtRe_ToOut').value 		= totS_SeToOut;
	document.getElementById('txtRe_ReFrOut').value 		= totS_ReFrOut;
	document.getElementById('txtRe_ReNow').value 		= totS_SeToOut-totS_ReFrOut;
	document.getElementById('txtRe_BalQty').value 		= 0;
	document.getElementById('txtReAODNo').focus();
}

function GetQtyWhenChangeSewFactory(obj)
{
	var url  = "subcontractorxml.php?RequestType=LoadDetails";
	url += "&OrderId="+document.getElementById('cboOrderNo').value;
	url += "&Color="+URLEncode(document.getElementById('cboColor').value);
	url += "&fFC="+document.getElementById('cboSubOutFromFac').value.trim();
	htmlobj  = $.ajax({url:url,async:false});
	
	var totS_ReceiveQty = parseFloat(htmlobj.responseXML.getElementsByTagName("TotReceiveQty")[0].childNodes[0].nodeValue);
	var totS_SeToOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotSendToOut")[0].childNodes[0].nodeValue);
	var totS_ReFrOut 	= parseFloat(htmlobj.responseXML.getElementsByTagName("TotReFrOut")[0].childNodes[0].nodeValue);
	var OrderQty		= parseFloat(htmlobj.responseXML.getElementsByTagName("OrderQty")[0].childNodes[0].nodeValue);
	var RvdQty			= parseFloat(htmlobj.responseXML.getElementsByTagName("RvdQty")[0].childNodes[0].nodeValue);
	
	document.getElementById('txtTotReceiveQty').value 	= totS_ReceiveQty;
	document.getElementById('txtSeToOut').value 		= totS_SeToOut;
	document.getElementById('txtReFrOut').value 		= totS_ReFrOut;
	document.getElementById('txtS_sendNow').value 		= totS_ReceiveQty;
	document.getElementById('txtS_BalQty').value 		= 0;
	document.getElementById('subSend_orderQty').value 		= OrderQty;
	document.getElementById('subSend_washRcvd').value 		= RvdQty;
	document.getElementById('cboSContractor').focus();
}