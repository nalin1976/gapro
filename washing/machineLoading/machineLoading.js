var savingKey="y";
var rewashStatus = 0;

function loadCombo2(sql,control)
{

	createXMLHttpRequestforTitle();
	xmlHttpForTitle.onreadystatechange=requestforloadcombo;
	xmlHttpForTitle.open("GET",'machineLoading-xml.php?sql='+sql,true);
	xmlHttpForTitle.control = control;
	xmlHttpForTitle.send(null);	
}

function loadCombo3(sql,control)
{

	createXMLHttpRequestforTitle();
	xmlHttpForTitle.onreadystatechange=requestforloadcombo;
	xmlHttpForTitle.open("GET","machineLoading-xml.php?id=none",true);
	xmlHttpForTitle.control = control;
	xmlHttpForTitle.send(null);	
}

function loadStyleName(pono){
	var mode=0;

		if(document.machineLoading.radioMachineLoading[0].checked==true){
			mode="0"
		
			loadCombo("SELECT was_actualcostheader.intSerialNo,concat(was_actualcostheader.intSerialNo,'-',orders.strDescription),orders.intQty FROM was_actualcostheader INNER JOIN orders ON was_actualcostheader.intStyleId=orders.intStyleId WHERE was_actualcostheader.intStyleId= "+pono+" AND was_actualcostheader.intStatus=1 order by strDescription ASC","machineLoading_cboCostId");
 //loadCostID(pono);
 		}if(document.machineLoading.radioMachineLoading[1].checked==true){
	 		mode="1"

 			var sql="SELECT was_actualcostheader.intSerialNo,concat(was_actualcostheader.intSerialNo,'-',was_outsidepo.strStyleDes),was_outsidepo.dblOrderQty FROM was_actualcostheader Inner Join was_outsidepo ON was_actualcostheader.intStyleId = was_outsidepo.intId WHERE was_actualcostheader.intStatus =  1 AND was_actualcostheader.intStyleId= "+ pono +";"; 
			loadCombo(sql,"machineLoading_cboCostId");
		}
		loadQty(pono,mode);
}

function loadQty(pono,mode){

	var path="machineLoading-xml.php?id=loadPoQty&pono="+pono+'&cat='+mode;
	htmlobj=$.ajax({url:path,async:false});
	var XMLQty = htmlobj.responseXML.getElementsByTagName("PoQty");
	var XMLTotRQty		 = htmlobj.responseXML.getElementsByTagName("TotRQty");
	var XMLWashQty	=htmlobj.responseXML.getElementsByTagName("WashQty");
	document.getElementById('txtOQty').value=XMLQty[0].childNodes[0].nodeValue;
	document.getElementById('txtTRQty').value=XMLTotRQty[0].childNodes[0].nodeValue;
	document.getElementById('txtBalQty').value=parseFloat(XMLTotRQty[0].childNodes[0].nodeValue)-parseFloat(XMLWashQty[0].childNodes[0].nodeValue);
	if(XMLWashQty.length>0){
		document.getElementById('txtWQty').value=XMLWashQty[0].childNodes[0].nodeValue;
	}
	
}
function loadCostID(intSerialNo){
	//alert(styleName);
		var mode=0;
		if(document.machineLoading.radioMachineLoading[0].checked==true){
			mode="0";
		}
		if(document.machineLoading.radioMachineLoading[1].checked==true){
	 		mode="1";			
		}
	

	var path = "machineLoading-xml.php?id=loadCostID&intSerialNo="+intSerialNo+"&cat="+mode;
	htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseText);
	//document.getElementById("machineLoading_txtCostId").value = htmlobj.responseText;
	var XMLintSerialNo   = htmlobj.responseXML.getElementsByTagName("intSerialNo");
	var XMLdblQty        = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLdblWeight     = htmlobj.responseXML.getElementsByTagName("dblWeight");
	var XMLstrWashType   = htmlobj.responseXML.getElementsByTagName("strWashType");
	var XMLintWasID      = htmlobj.responseXML.getElementsByTagName("intWasID");
	var XMLstrColor      = htmlobj.responseXML.getElementsByTagName("strColor");
	//var XMLTotRQty		 = htmlobj.responseXML.getElementsByTagName("TotRQty");
	
	//loadCombo3("",'machineLoading_cboMachine');	


	document.getElementById("machineLoading_Qty").value=XMLdblQty[0].childNodes[0].nodeValue;
	document.getElementById("machineLoading_Qty_hdn").value =XMLdblQty[0].childNodes[0].nodeValue;
	document.getElementById("machineLoading_LotWeight").value=XMLdblWeight[0].childNodes[0].nodeValue;
	document.getElementById("machineLoading_txtWashType").value=XMLstrWashType[0].childNodes[0].nodeValue;
	document.getElementById("washtype").title=XMLintWasID[0].childNodes[0].nodeValue;
	document.getElementById("machineLoading_txtColor").value=XMLstrColor[0].childNodes[0].nodeValue;
	//document.getElementById('txtTRQty').value=XMLTotRQty[0].childNodes[0].nodeValue;
	loadMachineType(intSerialNo);
	return htmlobj.responseText;
}

function loadMachineType(intSerialNo){
	var path = "machineLoading-xml.php?id=loadMachType&intSerialNo="+intSerialNo;
	htmlobj=$.ajax({url:path,async:false});

	var XMLintMachineId   = htmlobj.responseXML.getElementsByTagName("intMachineId");
	var XMLstrMachineType = htmlobj.responseXML.getElementsByTagName("strMachineType");

			for(var n = 0; n < XMLintMachineId.length; n++) 
			{
		document.getElementById("machineLoading_cboMachineType").options[n].value  = XMLintMachineId[n].childNodes[0].nodeValue;
		document.getElementById("machineLoading_cboMachineType").options[n].text  = XMLstrMachineType[n].childNodes[0].nodeValue;		
			}
	/*
 loadCombo2("SELECT was_machinetype.intMachineId,was_machinetype.strMachineType FROM was_machinetype INNER JOIN was_actualcostheader ON was_machinetype.intMachineId= was_actualcostheader.intMachineType where was_actualcostheader.intSerialNo="+intSerialNo+" ORDER BY was_machinetype.strMachineType","machineLoading_cboMachineType");*/
 var MachineType=document.getElementById("machineLoading_cboMachineType").value;

 //alert(MachineType);
 loadMachine(MachineType);
}

function loadMachine(MachineType){
	loadCombo("SELECT intMachineId, strMachineName FROM was_machine WHERE intMachineType="+MachineType+" ORDER BY strMachineName ASC",'machineLoading_cboMachine');	

}
function loadMacinesList(MachineType)
{
	loadCombo("SELECT intMachineId, strMachineName FROM was_machine WHERE intMachineType="+MachineType+" ORDER BY strMachineName ASC",'machineLoadingList_cboMachine');	
}
function rdDateP(obj){
	if(obj.checked){
		document.getElementById('fromDate').disabled="fale";
		document.getElementById('toDate').disabled="disabled";
	}
	else{
		document.getElementById('fromDate').disabled="disabled";
		document.getElementById('toDate').disabled="disabled";
	}
}
function loadMachineOperator(MachineId){
		loadCombo("SELECT intOperatorId, strName FROM was_operators WHERE intMachineid="+MachineId+" ORDER BY strName ASC",'machineLoading_cboMachineOperator');	
}

function saveMachineLoadHeader()
{

//alert(savingKey)
   if(savingKey=="y"){
	  
	var PoNo       		= document.getElementById("machineLoading_cboPoNo").value;
	var CostId     		= document.getElementById("machineLoading_cboCostId").value;
	var washtype 		= document.getElementById("washtype").title;	
	var Color    		= document.getElementById("machineLoading_txtColor").value;
	var MachineType 	= document.getElementById("machineLoading_cboMachineType").value;
	var Machine 		= document.getElementById("machineLoading_cboMachine").value;
	var MachineOperator = document.getElementById("machineLoading_cboMachineOperator").value;
	var Shift 			= document.getElementById("machineLoading_cboShift").value;
	var dateIn 			= document.getElementById("machineLoading_dateIn").value;	
	var dateOut 		= document.getElementById("machineLoading_dateOut").value;	
	var TimeInHours   	= document.getElementById("machineLoading_txtTimeIn").value;
	var TimeOutHours    = document.getElementById("machineLoading_txtTimeOut").value;
	
	
	if(document.getElementById("machineLoading_Pass").checked == true)
	{
	var Status = 1;	
	}
	
	if(document.getElementById("machineLoading_Fail").checked  == true)
	{
	var Status = 0;	
	}
	
	if(document.getElementById("machineLoading_Rewash").checked  == true)
	{
		if(document.getElementById('cboRewash').value=="")
		{
			alert("Please select a Rewash Type.");
			document.getElementById('cboRewash').focus();
			return;
		}
		else
			rewashStatus = document.getElementById('cboRewash').value;
		
	var Status = 5;	
	}
	
	var LotNo      = document.getElementById("machineLoading_txtBatchId").value;	
	var RootCardNo = document.getElementById("machineLoading_txtRootCardNo").value;	
	var Qty        = document.getElementById("machineLoading_Qty").value;	
	var LotWeight  = document.getElementById("machineLoading_LotWeight").value;	

	if(PoNo == ""){
	alert("Please Select 'PO No'.");
	document.getElementById("machineLoading_cboPoNo").focus();
	return false;
	}
	
	if(CostId == ""){
	alert("Please Select 'Cost Id'.");
	document.getElementById("machineLoading_cboCostId").focus();
	return false;
	}
	
	if(RootCardNo == ""){
	alert("Please Select 'Root Card No'.");
	document.getElementById("machineLoading_txtRootCardNo").focus();
	return false;
	}
	
	if(Color == ""){
	alert("Please enter 'Color'.");
	document.getElementById("machineLoading_txtColor").focus();
	return false;
	}

	if(Machine == ""){
	alert("Please select 'Machine'.");
	document.getElementById("machineLoading_cboMachine").focus();
	return false;
	}
	
	if(MachineOperator == ""){
	alert("Please select 'Machine Operator Name'.");
	document.getElementById("machineLoading_cboMachineOperator").focus();
	return false;
	}
	
	if(Shift == ""){
	alert("Please select shift");
	document.getElementById("machineLoading_cboShift").focus();
	return false;
	}
	
	if(dateIn == ""){
	alert("Please select 'In Date'.");
	document.getElementById("machineLoading_dateIn").focus();
	return false;
	}
	
	if(dateOut == ""){
	alert("Please select 'Out Date'.");
	document.getElementById("machineLoading_dateOut").focus();
	return false;
	}
	
	if(TimeInHours==""){
		alert("Please enter 'Time In'");
		document.getElementById("machineLoading_txtTimeIn").focus();
		return false;
	}
	if(TimeInHours==""){
		alert("Please enter 'Time Out'");
		document.getElementById("machineLoading_txtTimeOut").focus();
		return false;
	}
	if(LotWeight==""){
		alert("Please enter 'Lot Weight'");
		document.getElementById("machineLoading_LotWeight").focus();
		return false;
	}
	var path = "machineLoading-db.php?id=saveHeader";
	    path += "&PoNo="+URLEncode(PoNo);
		path += "&CostId="+URLEncode(CostId);
		path += "&washtype="+URLEncode(washtype);
		path += "&Color="+URLEncode(Color);
		path += "&Machine="+URLEncode(Machine);
		path += "&MachineType="+MachineType;
		path += "&MachineOperator="+MachineOperator;
		path += "&Shift="+Shift;
		path += "&Status="+Status;
		path += "&LotNo="+LotNo;
		path += "&RootCardNo="+URLEncode(RootCardNo);
		path += "&Qty="+Qty;
		path += "&LotWeight="+LotWeight;
		path += "&dateIn="+dateIn;
		path += "&dateOut="+dateOut;
		path += "&TimeInHours="+TimeInHours.substr(0,5);
		path += "&TimeInAMPM="+TimeInHours.substr(5,7);
		path += "&TimeOutHours="+TimeOutHours.substr(0,5);;
		path += "&TimeOutAMPM="+TimeOutHours.substr(5,7);
		path += "&Status="+Status;
		path += "&rewashStatus="+rewashStatus;
	htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseText);
	if(htmlobj.responseText == "-1"){
	alert("Root card No already exists");	
	/*
	var answer = confirm ("PoNo and Root Card No already exists.Do you want to Update?")
    if (answer)
    alert ("Woo Hoo! So am I.")
    else
    alert ("Darn. Well, keep trying then.")
	*/
	return false;
	}
	else if(htmlobj.responseText == "1"){
	saveMachineLoadDetails();	

	}
	else{
	alert("Header Saving error");
	return false;
	}
	
	//document.machineLoading.reset();
    
	return htmlobj.responseText;
     }
	 else
	 {
	var PoNo        	= document.getElementById("machineLoading_cboPoNo").value;	
	var CostId      	= document.getElementById("machineLoading_cboCostId").value;
	var washtype    	= document.getElementById("washtype").title;	
	var Color       	= document.getElementById("machineLoading_txtColor").value;
	var MachineType		= document.getElementById("machineLoading_cboMachineType").value;
	var Machine 		= document.getElementById("machineLoading_cboMachine").value;
	var MachineOperator = document.getElementById("machineLoading_cboMachineOperator").value;
	var Shift 			= document.getElementById("machineLoading_cboShift").value;
	var dateIn 			= document.getElementById("machineLoading_dateIn").value;	
	var dateOut 		= document.getElementById("machineLoading_dateOut").value;	
	var TimeInHours   	= document.getElementById("machineLoading_TimeInHours").value;
	var TimeInMinutes 	= document.getElementById("machineLoading_TimeInMinutes").value;
	var TimeInAMPM 		= document.getElementById("machineLoading_TimeInAMPM").value;
	var TimeOutHours   	= document.getElementById("machineLoading_TimeOutHours").value;
	var TimeOutMinutes 	= document.getElementById("machineLoading_TimeOutMinutes").value;
	var TimeOutAMPM 	= document.getElementById("machineLoading_TimeOutAMPM").value;


	
	if(document.getElementById("machineLoading_Pass").checked == true)
	{
	var Status = 1;	
	}
	
	if(document.getElementById("machineLoading_Fail").checked  == true)
	{
	var Status = 0;	
	}
	
	if(document.getElementById("machineLoading_Rewash").checked  == true)
	{
		if(document.getElementById('cboRewash').value=="")
		{
			alert("Please select a Rewash Type.");
			document.getElementById('cboRewash').focus();
			return;
		}
		else
			rewashStatus = document.getElementById('cboRewash').value;
		
	var Status = 5;	
	}
	var LotNo      = document.getElementById("machineLoading_txtLotNo").value;	
	var RootCardNo = document.getElementById("machineLoading_txtRootCardNo").value;	
	var Qty        = document.getElementById("machineLoading_Qty").value;	
	var LotWeight  = document.getElementById("machineLoading_LotWeight").value;	
	
	if(PoNo == ""){
	alert("Please Select Po No");
	document.getElementById("machineLoading_cboPoNo").focus();
	return false;
	}
	
	if(CostId == ""){
	alert("Please Select Cost Id");
	document.getElementById("machineLoading_cboCostId").focus();
	return false;
	}
	
	if(RootCardNo == ""){
	alert("Please Select Root Card No");
	document.getElementById("machineLoading_txtRootCardNo").focus();
	return false;
	}
	
	if(Color == ""){
	alert("Please enter color Card No");
	document.getElementById("machineLoading_txtColor").focus();
	return false;
	}

	if(Machine == ""){
	alert("Please select machine");
	document.getElementById("machineLoading_cboMachine").focus();
	return false;
	}
	
	if(MachineOperator == ""){
	alert("Please select machine operator");
	document.getElementById("machineLoading_cboMachineOperator").focus();
	return false;
	}
	
	if(Shift == ""){
	alert("Please select shift");
	document.getElementById("machineLoading_cboShift").focus();
	return false;
	}
	
	if(dateIn == ""){
	alert("Please select In Date");
	document.getElementById("machineLoading_dateIn").focus();
	return false;
	}
	
	if(dateOut == ""){
	alert("Please select Out Date");
	document.getElementById("machineLoading_dateOut").focus();
	return false;
	}
	if(LotWeight==""){
		alert("Please enter 'Lot Weight'");
		document.getElementById("machineLoading_LotWeight").focus();
		return false;
	}
	
	var path = "machineLoading-db.php?id=updateHeader";
	    path += "&PoNo="+PoNo;
		path += "&CostId="+CostId;
		path += "&washtype="+washtype;
		path += "&Color="+Color;
		path += "&Machine="+Machine;
		path += "&MachineType="+MachineType;
		path += "&MachineOperator="+MachineOperator;
		path += "&Shift="+Shift;
		path += "&Status="+Status;
		path += "&LotNo="+LotNo;
		path += "&RootCardNo="+URLEncode(RootCardNo);
		path += "&Qty="+Qty;
		path += "&LotWeight="+LotWeight;
		path += "&dateIn="+dateIn;
		path += "&dateOut="+dateOut;
		path += "&TimeInHours="+TimeInHours;
		path += "&TimeInMinutes="+TimeInMinutes;
		path += "&TimeInAMPM="+TimeInAMPM;
		path += "&TimeOutHours="+TimeOutHours;
		path += "&TimeOutMinutes="+TimeOutMinutes;		
		path += "&TimeOutAMPM="+TimeOutAMPM;
		path += "&Status="+Status;
		path += "&rewashStatus="+rewashStatus;
	htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseText);
   if(htmlobj.responseText == "1"){
	updateMachineLoadDetails();	
	}
	else{
	alert("Root Card numner allready exist.");
	return false;
	}
	
	//document.machineLoading.reset();
    
	return htmlobj.responseText;
	 }
	}
	
function saveMachineLoadDetails(){
	var PoNo  = document.getElementById("machineLoading_cboPoNo").value;	
	var color = document.getElementById("machineLoading_txtColor").value;	
	var Qty   = document.getElementById("machineLoading_Qty").value;	
	
	if(document.getElementById("machineLoading_Pass").checked == true)
	{
		var Status = 1;
	}
	
	if(document.getElementById("machineLoading_Fail").checked  == true)
	{
	var Status = 0;	
	}
	
	if(document.getElementById("machineLoading_Rewash").checked  == true)
	{
		if(document.getElementById('cboRewash').value=="")
		{
			alert("Please select a Rewash Type.");
			document.getElementById('cboRewash').focus();
			return;
		}
		else
			rewashStatus = document.getElementById('cboRewash').value;
		
	var Status = 5;	
	}
	var path = "machineLoading-db.php?id=saveDetails";
		path += "&PoNo="+PoNo;
		path += "&color="+URLEncode(color);
		path += "&Status="+Status;
		path += "&rewashStatus="+rewashStatus;
		path += "&Qty="+Qty;
	htmlobj=$.ajax({url:path,async:false});
	
	var currentTime = new Date();
	var month = currentTime.getMonth()+1;
	var day = currentTime.getDate();
	var year = currentTime.getFullYear();

	document.getElementById("machineLoading_cboPoNo").innerHTML="";
	document.getElementById("machineLoading_cboCostId").innerHTML="<option value=\"\">Select One</option>";
	document.getElementById("machineLoading_cboMachineType").value=0;
	document.getElementById("machineLoading_cboMachine").innerHTML="<option value=\"\">Select One</option>"; 
	document.getElementById("machineLoading_cboMachineOperator").innerHTML="<option value=\"\">Select One</option>";
	document.getElementById("machineLoading_cboShift").value="";
	document.getElementById("machineLoading_txtRootCardNo").value=""; 
	document.getElementById("machineLoading_txtLotNo").value="";
	document.getElementById("machineLoading_Qty").value="";
	document.getElementById("machineLoading_LotWeight").value="";
	document.getElementById("machineLoading_txtTimeIn").value="";
	document.getElementById("machineLoading_txtTimeOut").value="";
	document.getElementById("machineLoading_dateIn").value=(year+"-"+month+"-"+day);
	document.getElementById("machineLoading_dateOut").value=(year+"-"+month+"-"+day);
	document.getElementById("machineLoading_txtWashType").value="";
	document.getElementById("machineLoading_txtColor").value="";
	
	alert("Successfully saved");
	//document.machineLoading.reset();
	//alert(htmlobj.responseText);
	
	return htmlobj.responseText;
	}
	
function Clear(){
		
		var currentTime = new Date();
		var month = currentTime.getMonth()+1;
		var day = currentTime.getDate();
		var year = currentTime.getFullYear();

		document.getElementById("machineLoading_cboPoNo").innerHTML="";
		document.getElementById("machineLoading_cboCostId").innerHTML="<option value=\"\">Select One</option>";
		document.getElementById("machineLoading_cboMachineType").value=0;
		document.getElementById("machineLoading_cboMachine").innerHTML="<option value=\"\">Select One</option>";
		document.getElementById("machineLoading_cboMachineOperator").innerHTML="<option value=\"\">Select One</option>";
		document.getElementById("machineLoading_cboShift").value="";
		document.getElementById("machineLoading_txtColor").value="";
		document.getElementById("machineLoading_txtWashType").value="";
		document.getElementById("machineLoading_txtRootCardNo").value="";
		document.getElementById("machineLoading_Qty").value="";
		document.getElementById("machineLoading_LotWeight").value="";
		document.getElementById("machineLoading_txtTimeIn").value="";
		document.getElementById("machineLoading_txtTimeOut").value="";
	
		document.getElementById("machineLoading_dateIn").value=(year+"-"+month+"-"+day);
		document.getElementById("machineLoading_dateOut").value=(year+"-"+month+"-"+day);
		document.getElementById("txtOQty").value="";
		document.getElementById("txtTRQty").value="";
		document.getElementById("txtBalQty").value="";
		document.getElementById("txtWQty").value="";
		var sql="SELECT distinct orders.intStyleId,orders.strOrderNo FROM orders INNER JOIN was_actualcostheader ON orders.intStyleId=was_actualcostheader.intStyleId WHERE was_actualcostheader.intStatus=1 ORDER BY orders.strStyle";
loadCombo(sql,"machineLoading_cboPoNo");
}

function controlMachingLoadingQty(obj){
	var balQty  = Number(document.getElementById('txtBalQty').value.trim());	
	var costQty = document.getElementById("machineLoading_Qty_hdn").value ;
	if(costQty<Number(obj.value)){
		alert("'Qty' should be less than or equal to 'Costing Qty'.");
			obj.value=document.getElementById("machineLoading_Qty_hdn").value ;
			return false;
		}
	if(balQty<Number(obj.value)){
			alert("'Qty' should be less than or equal to 'Balance Qty'.");
			obj.value=document.getElementById("machineLoading_Qty_hdn").value ;
			return false;
		}	
	
	
}
function updateMachineLoadDetails(){
	var PoNo  = document.getElementById("machineLoading_cboPoNo").value;	
	var color = document.getElementById("machineLoading_txtColor").value;	
	var Qty   = document.getElementById("machineLoading_Qty").value;	
	
	if(document.getElementById("machineLoading_Pass").checked == true)
	{
	var Status = 1;	
	}
	
	if(document.getElementById("machineLoading_Fail").checked  == true)
	{
	var Status = 0;	
	}
	
	if(document.getElementById("machineLoading_Rewash").checked  == true)
	{
		if(document.getElementById('cboRewash').value=="")
		{
			alert("Please select a Rewash Type.");
			document.getElementById('cboRewash').focus();
			return;
		}
		else
			rewashStatus = document.getElementById('cboRewash').value;
		
	var Status = 5;	
	}
	var path = "machineLoading-db.php?id=saveDetails";
		path += "&PoNo="+PoNo;
		path += "&color="+color;
		path += "&Status="+Status;
		path += "&rewashStatus="+rewashStatus;
		path += "&Qty="+Qty;
	htmlobj=$.ajax({url:path,async:false});
	alert("Successfully saved");	
	document.getElementById("machineLoading_cboPoNo").options[0].text="";
	document.getElementById("machineLoading_cboPoNo").options[0].value="";
	document.getElementById("machineLoading_cboCostId").options[0].text="";
	document.getElementById("machineLoading_cboCostId").options[0].value="";
	document.getElementById("machineLoading_cboMachineType").value=0;
	document.getElementById("machineLoading_cboMachine").options[0].text="";
	document.getElementById("machineLoading_cboMachine").options[0].value="";
	document.getElementById("machineLoading_cboMachineOperator").options[0].text="";
	document.getElementById("machineLoading_cboMachineOperator").options[0].value="";
	document.getElementById("machineLoading_cboShift").options[0].text="";
	document.getElementById("machineLoading_cboShift").options[0].value="";
	document.getElementById("machineLoading_txtLotNo").value="";
	document.getElementById("machineLoading_txtRootCardNo").value="";
	document.getElementById("machineLoading_Qty").value="";
	document.getElementById("machineLoading_LotWeight").value="";
	document.getElementById("machineLoading_TimeInHours").value="";
	document.getElementById("machineLoading_TimeInMinutes").value="";
	document.getElementById("machineLoading_TimeInAMPM").value="";
	document.getElementById("machineLoading_TimeOutHours").value="";
	document.getElementById("machineLoading_TimeOutMinutes").value="";
	document.getElementById("machineLoading_TimeOutAMPM").value="";

	document.getElementById("machineLoading_dateIn").value="";
	document.getElementById("machineLoading_dateOut").value="";

	
	//alert(htmlobj.responseText);
	//document.machineLoading.reset();
	return htmlobj.responseText;
	}
	
	function viewMachineLoading(){
	//showPleaseWait();
    var path = "machineLoadingList.php";
	htmlobj=$.ajax({url:path,async:false});
	var text = htmlobj.responseText;
	closeWindow();
	drawPopupAreaLayer(950,350,'frmMachineWindow',1);
	document.getElementById('frmMachineWindow').innerHTML=text;
	hidePleaseWait();
	
	}
	
function teamWindowShowRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(538,380,'frmTeamWindow',1);
		
		document.getElementById('frmTeamWindow').innerHTML=text;
		hidePleaseWait();
	}
}
	
function loadMachineLoadningGrid(){
	document.getElementById('frmMachineLoadingList').submit();
	/*var tblTable    = 	document.getElementById("tblMachineLoadingList");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}
	
	var costID = document.getElementById("frmMachineLoadingList_cboCostId").value;	
	var machineType  = document.getElementById("frmMachineLoadingList_cboMachineType").value;	
	var machine  = document.getElementById("machineLoadingList_cboMachine").value;
	var fromDate  = document.getElementById("fromDate").value;
	var toDate  = document.getElementById("toDate").value;
	var cboMode  = document.getElementById("cboMode").value;
	//alert(fromDate);
	//alert(costID);alert(machineType);alert(machine);alert(fromDate);alert(toDate);alert(cboMode);
	var path = "machineLoading-xml.php?id=loadMachineLoadningGrid";
		path += "&costID="+costID;
		path += "&cboMode="+cboMode;
		path += "&machineType="+machineType;
		path += "&machine="+machine;
		path += "&fromDate="+fromDate;
		path += "&toDate="+toDate;
	    htmlobj=$.ajax({url:path,async:false});
        //alert(htmlobj.responseText);
		var XMLintStyleId		= htmlobj.responseXML.getElementsByTagName("intStyleId");
		var XMLstrStyle			= htmlobj.responseXML.getElementsByTagName("strStyle");
		var XMLintCostId 		= htmlobj.responseXML.getElementsByTagName("intCostId");
		var XMLstrMachineType	= htmlobj.responseXML.getElementsByTagName("strMachineType");
		var XMLstrMachineName	= htmlobj.responseXML.getElementsByTagName("strMachineName");
		var XMLintLotNo	        = htmlobj.responseXML.getElementsByTagName("intLotNo");
		var XMLintRootCardNo	= htmlobj.responseXML.getElementsByTagName("intRootCardNo");
		var XMLintRewashNo	    = htmlobj.responseXML.getElementsByTagName("intRewashNo");
		var XMLtmInTime	        = htmlobj.responseXML.getElementsByTagName("tmInTime");
		var XMLtmOutTime	    = htmlobj.responseXML.getElementsByTagName("tmOutTime");
		var XMLdblWeight	  = htmlobj.responseXML.getElementsByTagName("dblWeight");
		var XMLintOperatorId  = htmlobj.responseXML.getElementsByTagName("intOperatorId");
		var XMLstrShiftName	  = htmlobj.responseXML.getElementsByTagName("strShiftName");
		var XMLintRootCardNo  = htmlobj.responseXML.getElementsByTagName("intRootCardNo");	
		var XMLoperatorName	  = htmlobj.responseXML.getElementsByTagName("operatorName");
		var XMLdtmInDate	  = htmlobj.responseXML.getElementsByTagName("dtmInDate");
    	var XMLdtmOutDate	  = htmlobj.responseXML.getElementsByTagName("dtmOutDate");
		var XMLintStatus	  = htmlobj.responseXML.getElementsByTagName("intStatus");
		var XMLstrColor 	  = htmlobj.responseXML.getElementsByTagName("strColor");
		var XMLstrWasType	  = htmlobj.responseXML.getElementsByTagName("strWasType");
		var tblMachineLoadingList 		=  document.getElementById("tblMachineLoadingList");
		
		for(var loop=0;loop<XMLintStyleId.length;loop++)
		{
//alert(XMLtmInTime[loop].childNodes[0].nodeValue);
			var intStatus = document.getElementById("cboMode").value;	

			var strUrl  = "machineLoading.php?id=1&intStyleId="+XMLintStyleId[loop].childNodes[0].nodeValue+"&intStatus="+intStatus+"&intRootCardNo="+XMLintRootCardNo[loop].childNodes[0].nodeValue;
			var reportUrl  = "generalPurchaeOrderReport.php?bulkPoNo="+XMLintStyleId[loop].childNodes[0].nodeValue+"&intStatus="+intStatus;
			var intStyleId 			= XMLintStyleId[loop].childNodes[0].nodeValue;
			var intRootCardNo		= XMLintRootCardNo[loop].childNodes[0].nodeValue;
			var intStatus2   		= XMLintStatus[loop].childNodes[0].nodeValue;
		
			var string = intStyleId+"###"+intRootCardNo+"###"+intStatus2;
			
				var tblMain    = 	document.getElementById("tblMachineLoadingList");
				var rowCount = tblMain.rows.length;
				//tblMain.insertRow(rowCount);
				var row = tblMain.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
             if(XMLintStatus[loop].childNodes[0].nodeValue == '0'){
				var strStatus = "Pending"; 
			 }
			 if(XMLintStatus[loop].childNodes[0].nodeValue == '1'){
				var strStatus = "Successful"; 
			 }
			 if(XMLintStatus[loop].childNodes[0].nodeValue == '2'){
				var strStatus = "Incomplete"; 
			 }
			 if(XMLintStatus[loop].childNodes[0].nodeValue == '5'){
				var strStatus = "Rewash"; 
			 }
			 
             
            tblMain.rows[rowCount].innerHTML +="<td class=\"normalfntMid\" ><img class=\"mouseover\"  border=\"0\" src=\"../../images/view.png\" alt=\"view\" id=\""+string+"\" onclick=\"loadMachineLoadingForm(this.id);\"/></td>"+
            "<td class=\"normalfntMid\">"+XMLstrStyle[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLintCostId[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLstrMachineType[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLstrMachineName[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLintLotNo[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLintRewashNo[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLtmInTime[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLtmOutTime[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\"></td>"+
			"<td class=\"normalfntMid\">"+XMLdblWeight[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLintOperatorId[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLstrShiftName[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLintRootCardNo[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLoperatorName[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLdtmInDate[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLdtmOutDate[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+strStatus+"</td>"+
			"<td class=\"normalfntMid\">"+XMLstrColor[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLstrWasType[loop].childNodes[0].nodeValue+"</td>";
		}
	
	return htmlobj.responseText;*/
}
function loadMachineLoadingForm(styleId,RootCNo,RootYear,status)
{
	
	var url ="machineLoading.php?StyleNo="+styleId+"&rootCard="+RootCNo+"&RootYear="+RootYear+"&status="+status;
	window.open(url,"machineLoading");
}

function loadMachineLoadingLoad(styleId,RootCNo,RootCrdYear,status){
	//alert(styleId=="" || RootCNo=="" || status=="");
	if(styleId==" " )
	{
		return false;
	}
	//var splitString = string;//.split("###");
	var styleId    = styleId;
	var RootCardNo = RootCNo;

	//var status     = document.getElementById('cboMode').value.trim();
	
	var path = "machineLoading-xml.php?id=loadMachineLoadingForm";
	path += "&status="+status;
	//path += "&RootCardNo="+RootCardNo;
	//path += "&RootCrdYear="+RootCrdYear;
	path += "&styleId="+styleId;
	
	htmlobj=$.ajax({url:path,async:false});
	
	
    var XMLintMachineType = htmlobj.responseXML.getElementsByTagName("intMachineType");
	var XMLstrMachineType = htmlobj.responseXML.getElementsByTagName("strMachineType");
	var XMLintMachineId   = htmlobj.responseXML.getElementsByTagName("intMachineId");
	var XMLstrMachineName = htmlobj.responseXML.getElementsByTagName("strMachineName");
	var XMLRewashStatus  = htmlobj.responseXML.getElementsByTagName("RewashStatus");
	var XMLmachineOperator= htmlobj.responseXML.getElementsByTagName("machineOperator");
    var XMLintShiftId	  = htmlobj.responseXML.getElementsByTagName("intShiftId");
	var XMLstrShiftName	  = htmlobj.responseXML.getElementsByTagName("strShiftName");
	var XMLdtmInDate	  = htmlobj.responseXML.getElementsByTagName("dtmInDate");
	var XMLdtmOutDate	  = htmlobj.responseXML.getElementsByTagName("dtmOutDate");
	var XMLintWashType	  = htmlobj.responseXML.getElementsByTagName("intWashType");
	var XMLstrWasType	  = htmlobj.responseXML.getElementsByTagName("strWasType");
	var XMLstrColor 	  = htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLintStyleId	  = htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLstrStyle		  = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLstrDescription = htmlobj.responseXML.getElementsByTagName("strDescription");
	var XMLintCostId      = htmlobj.responseXML.getElementsByTagName("intCostId");
//	var XMLintRootCardNo  = htmlobj.responseXML.getElementsByTagName("rootCardNo");	
	var XMLdblQty	      = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLdblWeight	  = htmlobj.responseXML.getElementsByTagName("dblWeight");
	var XMLtmInTimeHours  = htmlobj.responseXML.getElementsByTagName("tmInTimeHours");
	var XMLtmInTimeMinutes= htmlobj.responseXML.getElementsByTagName("tmInTimeMinutes");
	var XMLtmINAMPM       = htmlobj.responseXML.getElementsByTagName("tmINAMPM");
	var XMLtmOutTimeHours  = htmlobj.responseXML.getElementsByTagName("tmOutTimeHours");
	var XMLtmOutTimeMinutes= htmlobj.responseXML.getElementsByTagName("tmOutTimeMinutes");
	var XMLtmOUTAMPM       = htmlobj.responseXML.getElementsByTagName("tmOUTAMPM");
	var XMLintStatus       = htmlobj.responseXML.getElementsByTagName("intStatus");
	var XMLPoNo		   	   = htmlobj.responseXML.getElementsByTagName("PoNo");
	var XMLBatchId		   = htmlobj.responseXML.getElementsByTagName("batchId");
	var XMLLotNo		   = htmlobj.responseXML.getElementsByTagName("LotNo");

document.getElementById("machineLoading_txtBatchId").value  = XMLBatchId[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_txtLotNo").value  = XMLLotNo[0].childNodes[0].nodeValue;		
document.getElementById("machineLoading_cboMachineType").options[0].value  = XMLintMachineType[0].childNodes[0].nodeValue;	
document.getElementById("machineLoading_cboMachineType").options[0].text=XMLstrMachineType[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboMachine").options[0].value  = XMLintMachineId[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboMachine").options[0].text=XMLstrMachineName[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboMachineOperator").innerHTML  = XMLmachineOperator[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_cboMachineOperator").options[0].text = XMLoperatorName[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboShift").options[0].value = XMLintShiftId[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboShift").options[0].text  = XMLstrShiftName[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_dateIn").value  = XMLdtmInDate[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_dateOut").value  = XMLdtmOutDate[0].childNodes[0].nodeValue;
document.getElementById("washtype").title  = XMLintWashType[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_txtWashType").value  = XMLstrWasType[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_txtColor").value     = XMLstrColor[0].childNodes[0].nodeValue;

document.getElementById("machineLoading_cboPoNo").innerHTML=XMLPoNo[0].childNodes[0].nodeValue;	

document.getElementById("machineLoading_txtRootCardNo").value = RootCrdYear+"/"+RootCNo;	

document.getElementById("machineLoading_cboCostId").options[0].text  = XMLintCostId[0].childNodes[0].nodeValue+"-"+ XMLstrDescription[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_cboCostId").options[0].value =XMLintCostId[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_Qty").value           = XMLdblQty[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_LotWeight").value     = XMLdblWeight[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_txtTimeIn").value     = XMLtmInTimeHours[0].childNodes[0].nodeValue+":"+XMLtmINAMPM[0].childNodes[0].nodeValue;;
//document.getElementById("machineLoading_TimeInMinutes").value     = XMLtmInTimeMinutes[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_TimeInAMPM").options[0].text    = XMLtmINAMPM[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_TimeInAMPM").options[0].value    = XMLtmINAMPM[0].childNodes[0].nodeValue;
document.getElementById("machineLoading_txtTimeOut").value     = XMLtmOutTimeHours[0].childNodes[0].nodeValue+":"+XMLtmOUTAMPM[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_TimeOutMinutes").value     = XMLtmOutTimeMinutes[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_TimeOutAMPM").options[0].text    = XMLtmOUTAMPM[0].childNodes[0].nodeValue;
//document.getElementById("machineLoading_TimeOutAMPM").options[0].value    = XMLtmOUTAMPM[0].childNodes[0].nodeValue;

if(XMLintStatus[0].childNodes[0].nodeValue == 1){
document.getElementById('machineLoading_Pass').checked = true;	
}

if(XMLintStatus[0].childNodes[0].nodeValue == 0){
document.getElementById('machineLoading_Fail').checked = true;
}

if(XMLintStatus[0].childNodes[0].nodeValue == 5)
{
	document.getElementById('machineLoading_Rewash').checked = true;
	$("#divRewashCmb").show(100);
	document.getElementById('cboRewash').value = XMLRewashStatus[0].childNodes[0].nodeValue;
}

	
closeWindow();
 loadQty(XMLintStyleId[0].childNodes[0].nodeValue);
//return htmlobj.responseXML;
 
}



function closeWindow()
{
	/*try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	*/
}
function ViewMLoadingRpt()
{
	if(document.getElementById('radioWash').checked==false && document.getElementById('radioMachine').checked==false && document.getElementById('radioWashSum').checked==false )
	{	
		alert("Please select a report type.");
		return false;
	}
	else
	{
				var datefrom	 = $('#dateFrom').val();
				var dateto		 = $('#dateTo').val();
			if(document.getElementById('radioWash').checked==true)
			{
			
				var datefrom	 = $('#dateFrom').val();
				var dateto		 = $('#dateTo').val();
				var PONo		 = $('#cboPO option:selected').text();
				var color	 	 = $('#cboColor option:selected').text();
				var cboshift	 = $('#cboShift option:selected').text();
				var cboshiftid   = $('#cboShift').val();
				var washtype	 = $('#cboWashType').val();
			
			window.open("reports/washreport.php?datefrom="+datefrom+"&dateto="+dateto+"&PONo="+PONo+"&color="+color+"&cboshift="+cboshift+"&cboshiftid="+cboshiftid+"&washtype="+washtype,'WRpt');
				
			}
			else if(document.getElementById('radioMachine').checked==true)
			{
				
				
			var datefrom	 = $('#dateFrom').val();
			var PONo		 = $('#cboPO option:selected').text();
			var cboshift	 = $('#cboShift option:selected').text();
			var cboshiftid   = $('#cboShift').val();
			var machine		 = $('#cboMachine').val();
			
			window.open("reports/machineLoadingReport.php?datefrom="+datefrom+"&PONo="+PONo+"&cboshift="+cboshift+"&cboshiftid="+cboshiftid+"&machine="+machine,'MLRpt');
				
			
			}
			else if(document.getElementById('radioWashSum').checked==true)
			{
				window.open("reports/washTypeSummary.php?datefrom="+datefrom+"&dateto="+dateto,'WSRpt');
			}
	}
}
function ClearForm()
{
	document.frmMachineLoading.reset();
	
}


function selectReports(obj)
{
	if(obj.value==0)
	{
		
		document.frmMachineLoading.reset();
		document.getElementById('cboColor').disabled=false;
		document.getElementById('cboMachine').disabled=true;
		document.getElementById('cboWashType').disabled=false;
		document.getElementById('dateTo').disabled=false;
		document.getElementById('cboPO').disabled=false;
		document.getElementById('cboShift').disabled=false;	
	}
	else if(obj.value==1)
	{
		document.getElementById('cboColor').value="";
		document.getElementById('cboMachine').value="";
		document.getElementById('cboWashType').value="";
		document.getElementById('dateTo').value="";
		document.getElementById('cboPO').value="";
		document.getElementById('cboShift').value="";
		
		document.getElementById('cboColor').disabled=true;
		document.getElementById('cboMachine').disabled=false;
		document.getElementById('cboWashType').disabled=true;
		document.getElementById('dateTo').disabled=true;
	}
	else if(obj.value==2){
		//document.frmMachineLoading.reset();
		document.getElementById('cboColor').value="";
		document.getElementById('cboMachine').value="";
		document.getElementById('cboWashType').value="";
		document.getElementById('cboPO').value="";
		document.getElementById('cboShift').value="";
		
		document.getElementById('cboColor').disabled=true;
		document.getElementById('cboMachine').disabled=true;
		document.getElementById('cboWashType').disabled=true;
		document.getElementById('dateTo').disabled=false;
		document.getElementById('cboPO').disabled=true;
		document.getElementById('cboShift').disabled=true;
		document.getElementById('dateTo').value	 = $('#dateFrom').val();
	}

}
function chaneColor()
{
	var poId	 = $('#cboPO').val();
	
if(document.getElementById('radioWash').checked==true)
{
	if(poId!="")
	{
		var url = "machineLoading-xml.php?request=Getcolor&poId="+poId;	
		htmlobj=$.ajax({url:url,async:false});
		var XMLcolor	= htmlobj.responseXML.getElementsByTagName("color")[0].childNodes[0].nodeValue;
		
		document.getElementById('cboColor').value= XMLcolor;
		
	}
	return;
}

}


//---------------------------
function loadDetails(obj){
	var path="machineLoading_xml.php?req=loadData&rNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLOrderNo=htmlobj.responseXML.getElementsByTagName('OrderNo');
	var XMLCostID=htmlobj.responseXML.getElementsByTagName('CostID');
	var XMLLot=htmlobj.responseXML.getElementsByTagName('Lot');
	var XMLLotQty=htmlobj.responseXML.getElementsByTagName('LotQty');
	var XMLMachineType=htmlobj.responseXML.getElementsByTagName('MachineType');
	var XMLMachine=htmlobj.responseXML.getElementsByTagName('Machine');
	var XMLShiftId=htmlobj.responseXML.getElementsByTagName('ShiftId');
	var XMLLotWeight=htmlobj.responseXML.getElementsByTagName('LotWeight');
	var XMLWashType=htmlobj.responseXML.getElementsByTagName('WashType');
	var XMLColor=htmlobj.responseXML.getElementsByTagName('Color');
	var XMLOperator=htmlobj.responseXML.getElementsByTagName('Operator');
	var XMLBatchId=htmlobj.responseXML.getElementsByTagName('BatchId');
	var washType = XMLWashType[0].childNodes[0].nodeValue.split("/");

	document.getElementById('machineLoading_cboPoNo').innerHTML=XMLOrderNo[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_cboCostId').innerHTML=XMLCostID[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_txtLotNo').value=XMLLot[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_Qty').value=XMLLotQty[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_cboMachineType').value=XMLMachineType[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_cboMachine').innerHTML=XMLMachine[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_cboShift').value=XMLShiftId[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_txtBatchId').value=XMLBatchId[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_txtWashType').value=washType[1];
	document.getElementById('washtype').title = washType[0];
	document.getElementById('machineLoading_txtColor').value=XMLColor[0].childNodes[0].nodeValue;
	document.getElementById('machineLoading_cboMachineOperator').innerHTML=XMLOperator[0].childNodes[0].nodeValue;
	
	/*
	machineLoading_LotWeight
	machineLoading_txtTimeIn
	machineLoading_txtTimeOut
	machineLoading_cboMachineType
	machineLoading_cboMachine
	machineLoading_cboShift
	machineLoading_dateIn
	machineLoading_dateOut
	machineLoading_txtWashType
	machineLoading_txtColor*/
}







