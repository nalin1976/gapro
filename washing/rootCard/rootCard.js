//js
var prewPID = 0;
var chemNo = 1;
var pub_shiftId = 0;
var pub_MachineId = 0;
function getPlanDetails(obj)
{
	RemoveAllRows('tblChemical');
	document.getElementById('divchemTable').style.display="none";
	if(obj.value=="")
	{
		document.frmRootCard.reset();
	}
	var path = "rootCard_xml.php?RequestType=loadBatchCard&planId="+obj.value.trim();
	htmlObj  = $.ajax({url:path,async:false})
	document.getElementById('cboBatchNo').innerHTML=htmlObj.responseXML.getElementsByTagName('Batch')[0].childNodes[0].nodeValue;
}

function getCostDetails(obj)
{
	document.getElementById('divchemTable').style.display = "inline";
	RemoveAllRows('tblChemical');
	var tbl = document.getElementById('tblDepartment');
	
	var path="rootCard_xml.php?RequestType=loadRootCardheader&batchId="+obj.value.trim()+"&planId="+document.getElementById('cboPlanId').value.trim();
	htmlObj=$.ajax({url:path,async:false})
	var XMLstrStyle	=	htmlObj.responseXML.getElementsByTagName('strStyle')[0].childNodes[0].nodeValue;
	var XMLCINPO	=	htmlObj.responseXML.getElementsByTagName('CINPO')[0].childNodes[0].nodeValue;
	var XMLPO		=	htmlObj.responseXML.getElementsByTagName('PO')[0].childNodes[0].nodeValue;
	var XMLstrColor	=	htmlObj.responseXML.getElementsByTagName('strColor')[0].childNodes[0].nodeValue;
	var XMLdblWeight	=	htmlObj.responseXML.getElementsByTagName('dblWeight')[0].childNodes[0].nodeValue;
	var XMLdblQty	=	htmlObj.responseXML.getElementsByTagName('dblQty')[0].childNodes[0].nodeValue;
	var XMLintMachineType	=	htmlObj.responseXML.getElementsByTagName('Machines')[0].childNodes[0].nodeValue;
	var XMLCostId	=	htmlObj.responseXML.getElementsByTagName('costId')[0].childNodes[0].nodeValue; 	
	var XMLRootCard =	htmlObj.responseXML.getElementsByTagName('RootCard')[0].childNodes[0].nodeValue; 
	pub_shiftId		= 	htmlObj.responseXML.getElementsByTagName('intShiftId')[0].childNodes[0].nodeValue; 
	pub_MachineId	= 	htmlObj.responseXML.getElementsByTagName('intMachine')[0].childNodes[0].nodeValue; 
	
	document.getElementById('cboRootCardPONO').innerHTML=XMLPO;
	document.getElementById('txtRootCardStyleName').value=XMLstrStyle;
	document.getElementById('txtRootCardColor').value=XMLstrColor;
	document.getElementById('txtRootCardWOL').value=XMLdblWeight;
	document.getElementById('txtRootCardPCs').value=XMLdblQty;
	document.getElementById('txtCINPO').value=XMLCINPO;
	document.getElementById('txtCINStyle').value=XMLstrStyle; 
	document.getElementById('txtCINColor').value=XMLstrColor;
	document.getElementById('cboCINM').innerHTML=XMLintMachineType;
	//document.getElementById('txtRootCardNo').value=$('#'+obj.id+" option:selected").text()+"-"+XMLRootCard;
	
	var url_dep = "rootCard_xml.php?RequestType=loadOperator&shiftId="+pub_shiftId+"&machineId="+pub_MachineId;
	htmlObj = $.ajax({url:url_dep,async:false})
	
	var XMLSection 			  = htmlObj.responseXML.getElementsByTagName("intSection");
	var XMLEpfNo 		  	  = htmlObj.responseXML.getElementsByTagName("strEpfNo");
	var XMLoperatorName 	  = htmlObj.responseXML.getElementsByTagName("operatorName");
	
	for(var loop=0;loop<XMLSection.length;loop++)
	{
		
		for(var i=2;i<tbl.rows.length;i++)
		{
			if(tbl.rows[i].cells[0].id==XMLSection[loop].childNodes[0].nodeValue)
			{
				tbl.rows[i].cells[2].childNodes[0].value = XMLoperatorName[loop].childNodes[0].nodeValue;
				tbl.rows[i].cells[3].childNodes[0].value = XMLEpfNo[loop].childNodes[0].nodeValue;
			}
		}
	}
	
+"-"+XMLRootCard;
	getprocessors(XMLCostId)
	
}
function getprocessors(obj)
{
var path="rootCard_xml.php?RequestType=loadProccessors&costId="+obj;
	htmlObj=$.ajax({url:path,async:false});
	
	var XMLProcessId	=	htmlObj.responseXML.getElementsByTagName('ProcessId'); 
	var XMLCINPrcName	=	htmlObj.responseXML.getElementsByTagName('ProcessorName'); 
	var XMLChemiclDes	=	htmlObj.responseXML.getElementsByTagName('ChemicalDes');
	var XMLQty			= 	htmlObj.responseXML.getElementsByTagName('Qty');
	var XMLUnit			= 	htmlObj.responseXML.getElementsByTagName('Unit');
	
	if(XMLProcessId.length==0)
		setEmptyChemeicalList();	

	for(var i=0;i<XMLProcessId.length;i++)
	{
		var Pid 	 = XMLProcessId[i].childNodes[0].nodeValue;
		var PName	 = XMLCINPrcName[i].childNodes[0].nodeValue;
		var chemDes	 = XMLChemiclDes[i].childNodes[0].nodeValue;
		var qty	 	 = XMLQty[i].childNodes[0].nodeValue;
		var cunit	 = XMLUnit[i].childNodes[0].nodeValue;
	
		setChemeicalList(Pid,PName,chemDes,qty,i+1,cunit,XMLProcessId.length);
	}
}

function  setChemeicalList(Pid,PName,chemDes,qty,i,cunit,length)
{
	var tblMain 	= document.getElementById('tblChemical');
	var rowCount	= tblMain.rows.length;
	var row 		= tblMain.insertRow(rowCount);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.height     = "20";
	if(prewPID==Pid)
	{
		if(i==length)
		{
			cell.className 	= "border-bottom-left-fntsize10";
		}
		else
		{
			cell.className 	= "border-left-fntsize10";
			cell.innerHTML 	= "";
		}
	}
	else
	{
		cell.className 	= "border-top-left-fntsize10";
		cell.innerHTML 	= "&nbsp;"+chemNo+++"&nbsp;";
	}
	
	var cell 		= row.insertCell(1);
	if(prewPID==Pid)
	{
		if(i==length)
		{
			cell.className 	= "border-bottom-left-fntsize10";
		}
		else
		{
			cell.className 	= "border-left-fntsize10";
			cell.innerHTML 	= "";
		}
	}
	else
	{
		cell.className 	= "border-top-left-fntsize10";
		cell.innerHTML 	= "&nbsp;"+PName+"&nbsp;";
	}
	cell.id			= Pid;
	
	var cell 		= row.insertCell(2);
	if(prewPID==Pid)
	{
		if(i==length)
			cell.className 	= "border-bottom-left-fntsize10";
		else
			cell.className 	= "border-left-fntsize10";
	}
	else
	{
		cell.className 	= "border-top-left-fntsize10";
	}
	cell.innerHTML 	= "&nbsp;"+chemDes+"&nbsp;";
	
	var cell 		= row.insertCell(3);
	cell.style.textAlign = "right";
	if(prewPID==Pid)
	{
		if(i==length)
			cell.className 	= "border-bottom-left-fntsize10";
		else
			cell.className 	= "border-left-fntsize10";
	}
	else
	{
		cell.className 	= "border-top-left-fntsize10";
	}
	cell.innerHTML 	= "&nbsp;"+qty+"&nbsp;";
	
	var cell 		= row.insertCell(4);
	cell.style.textAlign = "right";
	if(prewPID==Pid)
	{
		if(i==length)
			cell.className 	= "border-Left-bottom-right-fntsize10";
		else
			cell.className 	= "border-left-right-fntsize10";
		
	}
	else
	{
		cell.className 	= "border-Left-Top-right-fntsize10";
	}
	cell.innerHTML 	= "&nbsp;"+cunit+"&nbsp;";
	
	prewPID = Pid;
}
function setEmptyChemeicalList()
{
	var tblMain 	= document.getElementById('tblChemical');
	var rowCount	= tblMain.rows.length;
	var row 		= tblMain.insertRow(rowCount);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className  = "border-top-fntsize10";
	
	var cell 		= row.insertCell(1);
	cell.className  = "border-top-fntsize10";
	
	var cell 		= row.insertCell(2);
	cell.className  = "border-top-fntsize10";
	
	var cell 		= row.insertCell(3);
	cell.className  = "border-top-fntsize10";
	
	var cell 		= row.insertCell(4);
	cell.className  = "border-top-fntsize10";
}

function saveRootCard(){
	var planId=document.getElementById('cboPlanId');
	var date=document.getElementById('txtDate');
	var batchNo=document.getElementById('cboBatchNo');
	var poNo=document.getElementById('cboRootCardPONO');
	var color=document.getElementById('txtRootCardColor');
	var rootCardNo=document.getElementById('txtRootCardNo');
	var shade=document.getElementById('txtShade');
	var machine=document.getElementById('cboCINM');
	var ActualQty = document.getElementById('txtRootCardPCs');
	var tbl = document.getElementById('tblDepartment');
	
	if(formValidation(planId,date,batchNo,poNo,color,rootCardNo,shade,machine,ActualQty,tbl)){
	var path="rootCard_db.php?req=saveRootCard&plan="+planId.value+"&date="+date.value+"&batch="+batchNo.value+"&po="+poNo.value+"&color="+URLEncode(color.value)+"&rootCardNo="+rootCardNo.value+"&shade="+shade.value+"&machine="+machine.value+"&ActualQty="+ActualQty.value;
	htmlobj=$.ajax({url:path,async:false});
	var res=htmlobj.responseText;
		res=res.split('~');
		if(res[0]==1){
			document.getElementById('txtRootCardNo').value=res[1];
			saveDetail(res[1]);
		}
		else
		{
			alert('Error in saving Header.');
			return false;
		}
	}
		
}
function saveDetail(rootCrdNo)
{
	var boolCheck = true;
	var tbl = document.getElementById('tblDepartment');
	for(var i=2;i<tbl.rows.length;i++)
	{
		var departId 		= tbl.rows[i].cells[0].id;
		var noOfPcs 		= tbl.rows[i].cells[1].childNodes[0].value;
		var operatorName 	= tbl.rows[i].cells[2].childNodes[0].value;
		var EPFNo 			= tbl.rows[i].cells[3].childNodes[0].value;
		var timeIn 			= document.getElementById("txtTimeIn"+parseFloat(i-2)).value;
		var timeOut 		= document.getElementById("txtTimeOut"+parseFloat(i-2)).value;
		var Remarks 		= tbl.rows[i].cells[6].childNodes[0].value;
		
		var url = "rootCard_db.php?req=saveRootCardDetail&rootCrdNo="+rootCrdNo+"&departId="+departId+"&noOfPcs="+noOfPcs+"&operatorName="+URLEncode(operatorName)+"&EPFNo="+URLEncode(EPFNo)+"&TimeInHours="+timeIn.substr(0,5)+"&TimeInAMPM="+timeIn.substr(5,7)+"&TimeOutHours="+timeOut.substr(0,5)+"&TimeOutAMPM="+timeOut.substr(5,7)+"&Remarks="+URLEncode(Remarks);
		htmlobj=$.ajax({url:url,async:false});
		if(htmlobj.responseText!=1)
			boolCheck = false;
	}
	if(boolCheck)
		alert("Saved successfully.");
	else
	{
		alert("Error in saving Detail.");
		return;
	}
}

function formValidation(planId,date,batchNo,poNo,color,rootCardNo,shade,machine,ActualQty,tbl)
{
	
	if(planId.value==''){
		alert("Please select a 'Plan Id'.");
		planId.focus();
		return false
	}
	if(batchNo.value==''){
		alert("Please select a 'Batch No'.");
		batchNo.focus();
		return false
	}
	if(poNo.value==''){
		alert("Please select a 'PO No'.");
		poNo.focus();
		return false
	}
	if(color.value==''){
		alert("Please enter a 'Color'.");
		color.focus();
		return false
	}
	if(ActualQty.value=='' || ActualQty.value==0 )
	{
		alert("Please enter a 'Number of PCS'.");
		ActualQty.focus();
		return false
	}
	if(shade.value==''){
		alert("Please enter a 'Shade'.");
		shade.focus();
		return false
	}
	if(machine.value==''){
		alert("Please select a 'Machine'.");
		machine.focus();
		return false
	}
	for(var i=0;i<tbl.rows.length;i++)
	{
		
		if(tbl.rows[i].cells[0].id==2)
		{

			if(tbl.rows[i].cells[2].childNodes[0].value=="")
			{
				alert("Please enter Machine Operator's name.");
				tbl.rows[i].cells[2].childNodes[0].focus();
				return false;
			}
			if(tbl.rows[i].cells[3].childNodes[0].value=="")
			{
				alert("Please enter EPF No.");
				tbl.rows[i].cells[3].childNodes[0].focus();
				return false;
			}
			if(document.getElementById("txtTimeIn"+parseFloat(i-2)).value=="")
			{
				alert("Please enter TimeIn.");
				document.getElementById("txtTimeIn"+parseFloat(i-2)).focus();
				return false;
			}
			if(document.getElementById("txtTimeOut"+parseFloat(i-2)).value=="")
			{
				alert("Please enter TimeOut.");
				document.getElementById("txtTimeOut"+parseFloat(i-2)).focus();
				return false;
			}
		}
		
	}
		
	return true;
}
function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();	
	chemNo = 1;
}
