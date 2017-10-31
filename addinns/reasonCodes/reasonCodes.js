//reason codes
var xmlHttp=[];
function createXMLHttpRequest(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function addProcess()
{
	var tblPrc=document.getElementById('tblProcesses');
	var prcName=document.getElementById('reasonCodes_txtProcess').value;
	var processId = document.getElementById('processId').value;
	
	if(prcName.trim()=="")
	{
		alert("Fill Process Name.");
		//document.getElementById('resN').innerHTML="*";
		document.getElementById('reasonCodes_txtProcess').focus();
		
		return false;
	}
	else
	{
		
		var x_id = document.getElementById("processId").value;
		var x_name = document.getElementById("reasonCodes_txtProcess").value;
	
		var x_find = checkInField('tblprocesses','strProcessName',x_name,'intCode',x_id);
		if(x_find)
		{
			alert('"'+x_name+ "\" is already exist.");	
			document.getElementById("reasonCodes_txtProcess").select();
			return;
		}
		
		var rowCount = tblPrc.rows.length;
		var arrPrCode=[];
		if(rowCount != 0)
		{
			/*for(var i=0;i<rowCount;i++)
			{
				arrPrCode[i]=tblPrc.rows[i].cells[1].childNodes[0].innerHTML;
			}*/
			for(var a=0;a<rowCount;a++)
			{	
				if(tblPrc.rows[a].cells[1].innerHTML == processId)
				{
					tblPrc.rows[a].cells[2].innerHTML=prcName;
					
				}
			}
		}
		saveProcesses();		
	}
}
function closeWindow(){
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}
function openProcessesPopUp()
{
	var url  = "reasonCodeProcessesPopUp.php?";
	htmlobj=$.ajax({url:url,async:false});
	var popHTML = htmlobj.responseText;
	
	showBackGround('divBG',0);
	drawPopupBox(230,80,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = popHTML;
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
/*function processRequest(){
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		drawPopupArea(250,120,'frmProcess');				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmProcess').innerHTML=HTMLText;	
	}
}*/

function saveProcesses()
{
	var prc=document.getElementById('reasonCodes_txtProcess').value;
	var processId =document.getElementById('processId').value; 
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = saveProcessRequest;
	var url  = "reasonCodeMiddle.php?req=saveProcesses&proName="+prc+"&processId="+processId;
	xmlHttp[0].index=prc;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function saveProcessRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var HTMLText=xmlHttp[0].responseText;
		if(HTMLText != 2 && HTMLText != 'N/A')
		{
			var res=HTMLText.split('-');
			var tblPrc=document.getElementById('tblProcesses');
			var rowCount = tblPrc.rows.length;
			var row = tblPrc.insertRow(rowCount)
			
			row.className="bcgcolor-tblrowWhite";
			//row.style.cursor="pointer";
			//row.style.backgroundColor="#CCC";
	tblPrc.rows[rowCount].innerHTML="<td class=\"normalfntMid\"><img src=\"../../images/del.png\" id=\""+res[1]+"\" onclick=\"removeRow(this);\"/></td><td class=\"normalfntR\">"+res[1]+"</td><td class=\"normalfnt\" onclick=\"editProcess(this);\">"+xmlHttp[0].index+"</td><td class=\"normalfntMid\"><input  type=\"checkbox\" id=\"chk"+res[1]+"\" name=\"chk"+res[1]+"\" /></td>";
			CloseOSPopUp('popupLayer1');
			alert("Record Successfully added.");
			
		}
		if(HTMLText==2)
		{
			alert("Process Name Already Exist.");
			CloseOSPopUp('popupLayer1');
			return false;
		}
		if(HTMLText == "N/A")
		{
			document.getElementById('processId').value='';
			CloseOSPopUp('popupLayer1')
			return false;
		}
	}
}

var c=0;
function saveReasonCodes()
{
	var resCode=document.getElementById('reasonCodes_txtReasonCode').value;
	var resDesc=document.getElementById('reasonCodes_txtReasonDescription').value;
	
	if(resCode.trim()=="")
	{
		alert("Fill Reason Code");
		document.getElementById('reasonCodes_txtReasonCode').focus();
		return false;
	}
	if(resDesc.trim()=="")
	{
		alert("Fill Description");
		document.getElementById('reasonCodes_txtReasonDescription').focus();
		return false;
	}
	
	var x_id = document.getElementById("reasonCodes_cboReasonCode").value;
	var x_name = document.getElementById("reasonCodes_txtReasonCode").value;

	var x_find = checkInField('tblreasoncodes','strCode',x_name,'intResonCodeId',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("reasonCodes_txtReasonCode").select();
		return;
	}
	addData();
}

function updateDate(resCode,resDesc,req)
{
	var tblPrc=document.getElementById('tblProcesses');
			var rowCount = tblPrc.rows.length;
			var arrPrCode=[];
			var intPrcCode="";
			for(var i=1;i<rowCount;i++)
				{
					
					arrPrCode[i]=tblPrc.rows[i].cells[1].childNodes[0].innerHTML;
					var chk=tblPrc.rows[i].cells[3].childNodes[0];
					
					if(document.getElementById(chk.id).checked)
					{
						//alert(chk.id+"-"+arrPrCode[i]);
						intPrcCode += arrPrCode[i]+"~";
					}
				}
				if(intPrcCode.trim()=="")
				{
					alert('Select a Processes.');
					return false;
				}

				var resCode=document.getElementById('reasonCodes_txtReasonCode').value;
				var resDesc=document.getElementById('reasonCodes_txtReasonDescription').value;
				var tblPrc=document.getElementById('tblProcesses');
				var rowCount = tblPrc.rows.length;
				var arrPrCode=[];
				var intPrcCode="";
				for(var i=1;i<rowCount;i++)
				{
					arrPrCode[i]=tblPrc.rows[i].cells[1].childNodes[0].innerHTML;
					//alert(arrPrCode[i]);
					var chk=tblPrc.rows[i].cells[3].childNodes[0];
					if(document.getElementById(chk.id).checked)
					{
						intPrcCode += arrPrCode[i]+"~";
					}
				}
						createXMLHttpRequest(1);
						xmlHttp[1].onreadystatechange = saveReasonRequest;
						var url  = "reasonCodeMiddle.php?req=updateReasons&intPrcCode="+intPrcCode+"&resCode="+resCode+"&resDesc="+resDesc+"";				xmlHttp[1].index=resCode;
						xmlHttp[1].open("GET",url,true);
						xmlHttp[1].send(null);
}

function addData()
{
	var tblPrc=document.getElementById('tblProcesses');
	var rowCount = tblPrc.rows.length;
	var arrPrCode=[];
	var intPrcCode="";
	var cboCode=document.getElementById('reasonCodes_cboReasonCode').value;
	var resCode=document.getElementById('reasonCodes_txtReasonCode').value;
	var resDesc=document.getElementById('reasonCodes_txtReasonDescription').value;
	
	if(document.getElementById("reasonCode_chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
		
	for(var i=1;i<rowCount;i++)
	{
		var chk=tblPrc.rows[i].cells[3].childNodes[0];
		if(chk.checked)
		{
			//alert(chk.id+"-"+arrPrCode[i]);
			intPrcCode += arrPrCode[i]+"~";
		}
	}
	
	if(intPrcCode.trim()=="")
	{
		alert('Select a Processes.');
		return false;
	}

	if(cboCode != '')
	{
		var url_d = "reasonCodeMiddle.php?req=deleteReasonAllocationCode&cboCode="+(cboCode);	
			url_d += "&resCode="+URLEncode(resCode);
			url_d += "&resDesc="+URLEncode(resDesc);
			url_d += "&intStatus="+(intStatus);
			
		htmlobj=$.ajax({url:url_d,async:false});
		var reasonCodeId = cboCode;
	}
	else
	{
		
		var tblPrc=document.getElementById('tblProcesses');
		
		var url_h = "reasonCodeMiddle.php?req=saveReasons&resCode="+URLEncode(resCode);
			url_h += "&resDesc="+URLEncode(resDesc);
			url_h += "&intStatus="+(intStatus);
		htmlobj=$.ajax({url:url_h,async:false});
		var reasonCodeId = htmlobj.responseText;
	}
	
	for(var i=1;i<rowCount;i++)
	{
		var processCode = tblPrc.rows[i].cells[1].innerHTML;
		var chk=tblPrc.rows[i].cells[3].childNodes[0];
		if(chk.checked)
		{
			var url = "reasonCodeMiddle.php?req=saveReasonsAllocation&reasonCodeId="+(reasonCodeId);
				url += "&processCode="+processCode;
							
			 htmlobj=$.ajax({url:url,async:false});
			
		}
	}
	
	ClearForm();
	alert("Saved successfully");
						
}
/*function delData()
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = delReasonRequest;
						
	var url  = "reasonCodeMiddle.php?req=delReasons&resCode="+resCode+"&resDesc="+resDesc+"";	
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function delReasonRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var HTMLText=xmlHttp[0].responseText;
		if(HTMLText == 1)
		{
			
		}
		else if(HTMLText == 2)
		{
			alert(HTMLText);
		}
		
	}
}*/

function saveReasonRequest()
{
	if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
	{
		var HTMLText=xmlHttp[1].responseText;
		alert(HTMLText);
		fillCombo(xmlHttp[1].index);
	}
}
function fillCombo(resCode)
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = fillNewCombo;
	var url  = "reasonCodeMiddle.php?req=fillReasonsCombo&resCode="+resCode+"";					
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function fillNewCombo()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('reasonCodes_cboReasonCode').innerHTML=HTMLText;
		ClearForm();
	}
}
function ClearForm()
{
		document.getElementById('reasonCodes_txtReasonCode').value="";
		document.getElementById('reasonCodes_cboReasonCode').value="";
		document.getElementById('reasonCodes_txtReasonDescription').value="";
		var url_r = "reasonCodeMiddle.php?req=loadReasonCodes";
	htmlobj=$.ajax({url:url_r,async:false});
	document.getElementById('reasonCodes_cboReasonCode').innerHTML = htmlobj.responseXML.getElementsByTagName("strReasonCode")[0].childNodes[0].nodeValue;
		var tblPrc=document.getElementById('tblProcesses');
		var rowCount = tblPrc.rows.length;
		var arrPrCode=[];
		for(var i=1;i<rowCount;i++)
			{
				arrPrCode[i]=tblPrc.rows[i].cells[0].childNodes[0].innerHTML;
				var intPrcCode=arrPrCode[i];
				var chk=tblPrc.rows[i].cells[3].childNodes[0];
				chk.checked=false;
			}
			return false;
}

function loadData()
{
	var resonCode=document.getElementById('reasonCodes_cboReasonCode').value;
	if(resonCode.trim()=="")
	{
		ClearForm();
		return false;
	}
	var url  = "reasonCodeMiddle.php?req=loadReasons&resonCode="+resonCode;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('reasonCodes_txtReasonCode').value = htmlobj.responseXML.getElementsByTagName("strReasonCode")[0].childNodes[0].nodeValue;
	document.getElementById('reasonCodes_txtReasonDescription').value = htmlobj.responseXML.getElementsByTagName("strDesc")[0].childNodes[0].nodeValue;
	var intStatus = htmlobj.responseXML.getElementsByTagName("intStatus")[0].childNodes[0].nodeValue;
	
	if(intStatus==1)
		document.getElementById('reasonCode_chkActive').checked = true;
	else
		document.getElementById('reasonCode_chkActive').checked = false;
	
	//clear process allocation table ------------------
	var tblProcess=document.getElementById('tblProcesses');
	var rowCount_p = tblProcess.rows.length;
	for(var i=1;i<rowCount_p;i++)
			{
				var chk=tblProcess.rows[i].cells[3].childNodes[0];
				chk.checked=false;
			}
	//-------------------------------------------------
	
	var url_p  = "reasonCodeMiddle.php?req=loadReasonsCodeProcess&resonCode="+resonCode;
	htmlobj_p =$.ajax({url:url_p,async:false});
	var XMLprocessNo = htmlobj_p.responseXML.getElementsByTagName("processCode");
	
	for (var loop = 0; loop < XMLprocessNo.length; loop ++)
	{
		var processId = 	htmlobj_p.responseXML.getElementsByTagName("processCode")[loop].childNodes[0].nodeValue;
		var tblPrc=document.getElementById('tblProcesses');
		var rowCount = tblPrc.rows.length;
		//alert(processId)
		for(var i=1;i<rowCount;i++)
		{
			if(processId == tblPrc.rows[i].cells[1].innerHTML)
				tblPrc.rows[i].cells[3].childNodes[0].checked = true;
			}
	}
}

function loadProcesses(resCode)
{
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = loadProcessRequest;
	var url  = "reasonCodeMiddle.php?req=loadProcesses&resCode="+resCode+"";
	xmlHttp[1].open("GET",url,true);
	xmlHttp[1].send(null);
}
function loadProcessRequest()
{
	if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
	{
		 var XMLPRCCode = xmlHttp[1].responseXML.getElementsByTagName("intProcessCode");	
		 for(var a=0;a<XMLPRCCode.length;a++)
		 {
			var tblPrc=document.getElementById('tblProcesses');
			var rowCount = tblPrc.rows.length;
			var arrPrCode=[];
			for(var i=1;i<rowCount;i++)
			{
				arrPrCode[i]=tblPrc.rows[i].cells[0].childNodes[0].innerHTML;
				var intPrcCode=arrPrCode[i];
				var chk=tblPrc.rows[i].cells[3].childNodes[0];
				var id=chk.id.split('chk')
				if(id[1]==XMLPRCCode[a].childNodes[0].nodeValue)
				{
					document.getElementById(chk.id).checked=true;
				}
			}
		 }
	}
}

function deleteReson()
{
	var resCode = document.getElementById('reasonCodes_txtReasonCode').value;
	var cboResCode = document.getElementById('reasonCodes_cboReasonCode').value;
	if(cboResCode.trim()=="")
	{
		alert("Select Reason Code.");
		return false;
	}
	/*if(resCode.trim()=="")
	{
		alert("Select Reason Code.");
		return false;
	}*/
	if(confirm("Are u sure delete this record?!")==true)
	{
		var url  = "reasonCodeMiddle.php?req=deleteReson&cboResCode="+cboResCode+"";
		htmlobj=$.ajax({url:url,async:false});
		alert(htmlobj.responseText);
		ClearForm();
	}
}
function deleteRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		 var res = xmlHttp[0].responseText;	
		 alert(res);
		 fillCombo(xmlHttp[0].index);
	}
}

function removeRow(objDel)
{
	if(confirm("Are u sure delete this record?")==true)
	{
		createXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange = deletePrcRequest;
		var url  = "reasonCodeMiddle.php?req=deleteProcess&prcCode="+objDel.id+"";
		xmlHttp[0].index=objDel;
		xmlHttp[0].open("GET",url,true);
		xmlHttp[0].send(null);

	}
	
}

function deletePrcRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var objDel=xmlHttp[0].index;
		var res = xmlHttp[0].responseText;	
		if(res ==1)
		{
			alert("Record deleted successfully.");
			var tblMain = objDel.parentNode.parentNode.parentNode;
			var rowNo = objDel.parentNode.parentNode.rowIndex
			tblMain.deleteRow(rowNo);
		}
		else
		{
			alert(res);
		}
	}
}
function editProcess(obj)
{
	openProcessesPopUp();
	document.getElementById('processId').value = obj.parentNode.cells[1].innerHTML;
	document.getElementById('reasonCodes_txtProcess').value = obj.parentNode.cells[2].innerHTML;
		
}
