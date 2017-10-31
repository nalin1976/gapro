//javascript
//washing Budgeted Cost
//lasantha 
var pub_FabricSerial	= 0;
var xmlHttp=[];
var pub_intxmlHttp_count=0;
var pub_intxmlHttp_count1=0;
var pub_category = 0;
$(document).ready(function() 
{
	var url					='washReciveMiddle.php?req=LoadStyleName';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#cboStyleName" ).autocomplete({
	source: pub_po_arr
	});
	
	var url					='washReciveMiddle.php?req=LoadDivision';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#cboDivision" ).autocomplete({
	source: pub_po_arr
	});
	
	var url					='washReciveMiddle.php?req=LoadFabricId';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#cboFabricName" ).autocomplete({
	source: pub_po_arr
	});
	
	var url					='washReciveMiddle.php?req=LoadColors';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#cboColor" ).autocomplete({
	source: pub_po_arr
	});
	
	var url					='washReciveMiddle.php?req=LoadWashType';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#cboWashType" ).autocomplete({
	source: pub_po_arr
	});
	
});

function loadReport()
{
	document.frmWashRecieve.radioReports[0].checked == false;
	document.frmWashRecieve.radioReports[1].checked == false;
	if(document.getElementById('reportsPopUp').style.visibility == "hidden")
	{
		document.getElementById('reportsPopUp').style.visibility = "visible";
	}
	else
	{
		document.getElementById('reportsPopUp').style.visibility = "hidden";
	}
}

function loadCopyBudget()
{
	if(document.getElementById('copyBudget').style.visibility == "hidden")
	{
		document.getElementById('copyBudget').style.visibility = "visible";
		
		var url = 'washReciveMiddle.php?req=LoadJobToCopy';
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById('cboCopyBudget').innerHTML = htmlobj.responseText;
	}
	else
	{
		document.getElementById('copyBudget').style.visibility = "hidden";
	}
}

function loadRevision()
{
	
	var sNo=document.getElementById('txtSampleNo').value;
	if(sNo.trim()=="")
	{
		alert("Enter Sample Number.");
		return false;
	}
	if(document.getElementById('revReason').style.visibility == "hidden")
	{//alert("A");
		document.getElementById('revReason').style.visibility = "visible";
	}
	else
	{
		document.getElementById('revReason').style.visibility = "hidden";
	}
}

function fix_header(tblName,w,h)
{
	$("#"+tblName+"").fixedHeader({
	width: w,height: h
	});
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

function loadProcessPopUp()
{
	showBackGround('divBG',0);
	var url  = "processes.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(537,341,'frmProcess',1);				
	//drawPopupArea(500,310,'frmProcess');
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmProcess').innerHTML=HTMLText;
	fix_header('tblPrc',517,270);
}

function addProcesses(id){
	var tblPrc = document.getElementById("tblPrc");
	var serial=tblPrc.rows[id].cells[0].innerHTML;
	var chm=tblPrc.rows[id].cells[1].innerHTML;
	var liqour=tblPrc.rows[id].cells[2].innerHTML;
	var temp=tblPrc.rows[id].cells[3].innerHTML;
	var tm =tblPrc.rows[id].cells[4].innerHTML;
	
	var tblMain=document.getElementById('tblMain');
	var rowCount = tblMain.rows.length;
	var arrSerialCode=[];
	var rowID=rowCount;
	
	if(rowCount != 0)
	{
		rowOder();
		var m=0;
		for(var i=1;i<rowCount;i++)
		{
			var rid=tblMain.rows[i].cells[6].childNodes[1].id.split("img");
			arrSerialCode[i]=rid[1];
			if(m<arrSerialCode[i])
				m=arrSerialCode[i];
		}
		for(var a=0;a<rowCount;a++)
		{	
			if(arrSerialCode[a] == rowCount )
				rowID=parseInt(m)+1;
		}
	}

	var tblMain=document.getElementById('tblMain').tBodies[0];
	var rowCount = tblMain.rows.length;
	var row = tblMain.insertRow(rowCount);
	row.className="bcgcolor-tblrowWhite";
	row.style.cursor="pointer";
	row.setAttribute('onMouseOver',"moveTR('tblMain');");
	var htm = "<td class=\"\" style=\"cursor:pointer;\" >";
	htm+="<img src=\"../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
	htm+="<td class=\"normalfnt\">"+rowID+"</td>";
	htm+="<td class=\"normalfnt\" style=\"text-align:left;\">"+chm+"</td>";
	htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+liqour+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\" maxlength=\"8\"/></td>";
	htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+temp+"\" style=\"width:80px;text-align:right;\"  onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"  maxlength=\"8\"/></td>";
	htm+="<td class=\"normalfnt\" style=\"cursor:pointer;\"><input type=\"text\" value=\""+tm+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"  maxlength=\"8\" /></td>";
	htm+="<td class=\"normalfnt\" id=\""+rowID+"\" style=\"cursor:pointer;\">";
	htm+="<select style=\"width:90px;\" id=\"cboChmID"+rowID+"\" align=\"left\">";
	//htm+="<option></option>";
	htm+="</select>";
	htm+="<img src=\"../../images/add.png\"onclick=\"loadchemicals(this.id,"+serial+");\" id=\"img"+rowID+"\" align=\"right\"/>";
	htm+="</td><td class=\"normalfnt\">"+serial+"</td>";
	row.innerHTML=htm;
	//setColors(tblMain,rowCount);
	rowOder();
	fix_header('tblMain',810,322);
}

function changeFieldData(t,h)
{
	var val=t.innerHTML;
	var id=t.id;
	var ID="";
	(h==1)?ID="txtChangeTemp"+id:ID="txtChangeLi"+id;

	if(!document.getElementById(ID))
	{
		t.innerHTML="<input type=\"text\" style=\"width:inherit;\" id=\""+ ID +"\" value=\""+ val +"\" onkeypress=\"return CheckforValidDecimal(this.value,2,event);\">";
		document.getElementById(ID).focus();
	}
	else
	{
		t.innerHTML=document.getElementById(ID).value;
	}
} 

function selectFabricDet()
{
	var fId=document.getElementById('cboFabricName').value;
	var url  = "washReciveMiddle.php?req=selectFabricDet&cID="+fId+"";
	htmlobj=$.ajax({url:url,async:false});
	
	var arrAll=htmlobj.responseText;
	var arrFab=arrAll.split('~');
	
	var mill=arrFab[arrFab.length-1];
	document.getElementById('txtMill').value=mill
	var arrCon=arrFab[arrFab.length-2]
	var val=arrCon.split('-');
	var ln=val.length;
	document.getElementById('txtFabricContent').value=val[ln-1];
	var desc="";
	for(var i=0;i<ln-1;i++)
	{
		desc+=val[i]+"-";
	}
	document.getElementById('txtFabricDsc').value=desc;
	var HTMLText=htmlobj.responseText;
}

function loadchemicals(imgID,serial)
{
	showBackGround('divBG',0);
	var url  = "chemicals.php?prcId="+serial+"";
	htmlobj=$.ajax({url:url,async:false});
	
	drawPopupAreaLayer(550,300,'frmChemicals',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmChemicals').innerHTML=HTMLText;	
	document.getElementById('hdnVal').value=imgID;
	var id=imgID.split('img');
	var chmCode = document.getElementById("cboChmID"+id[1]);
	var arrChm=[];
	var arrChmQty=[];
	var arrChmUP=[];
	var arrcboChm=chmCode.length;
	
	for(var i=0;i< arrcboChm;i++)
	{
		var spID=chmCode.options[i].value.split(":");
		arrChm[i]=spID[0];
		arrChmQty[i]=spID[1];
		arrChmUP[i]=spID[2];
	}

	var tblChm=document.getElementById('tblChm');
	var rowCount = tblChm.rows.length;
		
	for(var a=0;a<rowCount;a++)
	{
		var serial= tblChm.rows[a].cells[0].innerHTML;
		var chk   = tblChm.rows[a].cells[5].childNodes[0];
		var qty	  = tblChm.rows[a].cells[3].childNodes[0];
		var up	  = tblChm.rows[a].cells[4].childNodes[0];
		for(var i=0;i<arrcboChm;i++)
		if(serial==arrChm[i])
		{
			document.getElementById(chk.id).checked=true;
			qty.value=arrChmQty[i];
			up.value=arrChmUP[i];
		}
	}
	fix_header('tblChm',527,250);
}

function loadWashType(wID)
{
	var washType=document.getElementById(wID).value;
	if(washType.trim()=="")
	{
		clearWashTypeForm();
		return false;
	}
	else
	{
		var url  = "washReciveMiddle.php?req=loadWashType&washType="+washType+"";
		htmlobj=$.ajax({url:url,async:false});
		loadWashTypeRequest(htmlobj);
	}
}

function loadWashTypeRequest(htmlobj)
{
	 var XMLCode = htmlobj.responseXML.getElementsByTagName("strWasType");				
	 document.getElementById('txtWashType').value = XMLCode[0].childNodes[0].nodeValue;
	 var XMLDesc = htmlobj.responseXML.getElementsByTagName("dblUnitPrice");				
	 document.getElementById('txtUnitPrice').value = XMLDesc[0].childNodes[0].nodeValue;
}

function saveWashType()
{
	var cboWashType	= document.getElementById('cboSearchWashType').value;
	var washType	= document.getElementById('txtWashType').value;
	var unitPrice	= document.getElementById('txtUnitPrice').value;
	if(washType.trim()=="")
	{
		alert("Fill Wash Type.");
		document.getElementById('txtWashType').focus();
		return false;
	}
	if(unitPrice.trim()=="")
	{
		alert("Fill UnitPrice.");
		document.getElementById('txtUnitPrice').focus();
		return false;
	}
	var url  = "washReciveMiddle.php?req=saveWashType&washType="+washType+"&unitPrice="+unitPrice+"";
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseXML);
}

function clearWashTypeForm()
{
	document.getElementById('cboSearchWashType').value ="";
	document.getElementById('txtWashType').value ="";
	document.getElementById('txtUnitPrice').value="";
}

function selectChemicals()
{
	var hdnVal=document.getElementById('hdnVal').value;
	var cboRow=hdnVal.split('img');
	var tblChm=document.getElementById('tblChm');
	var rowCount = tblChm.rows.length;
	var arrChmCode=[];
	var arrChmName=[];
	var arrChmQty=[];
	var arrUPrice=[];
	var chmCode=document.getElementById('cboChmID'+cboRow[1]);
	chmCode.innerHTML ="";
	for(var i=1;i<rowCount;i++)
	{
		arrChmCode[i]	=	tblChm.rows[i].cells[0].innerHTML;
		arrChmName[i]	=	tblChm.rows[i].cells[1].innerHTML;
		arrChmQty[i]	=	tblChm.rows[i].cells[3].childNodes[0].value;
		arrUPrice[i]	=	tblChm.rows[i].cells[4].childNodes[0].value;
		
		var chk=tblChm.rows[i].cells[5].childNodes[0];
		if(document.getElementById(chk.id).checked)
		{
			chmCode.innerHTML += "<option value=\""+arrChmCode[i]+":"+arrChmQty[i]+":"+arrUPrice[i]+"\">"+arrChmCode[i]+":"+arrChmName[i]+"</option>";
		}
	}
	CloseWindowInBC();
}

function clearForm()
{
	document.frmWashRecieve.reset();
	if(confirmBudgetedCost)
		document.getElementById('confirmIMG').style.display="inline";
	
	document.getElementById('saveIMG').style.display="inline";
	document.getElementById('cboStyleName').innerHTML="<option value=\"\">Select Item</option>";	
	var tbl=document.getElementById('tblMain').tBodies[0];
	var rCount = tbl.rows.length;
	for(var loop=0;loop<rCount;loop++)
	{
		tbl.deleteRow(loop);
		rCount--;
		loop--;
	}
}

function saveData()
{
	var fabricName 		= document.getElementById('cboFabricName').value;
	var customerName 	= document.getElementById('cboCustomerName').value;
	var styleName 		= document.getElementById('cboStyleName').value;
	var division 		= document.getElementById('cboDivision').value;
	var cl 				= document.getElementById('cboColor').value;
	var color			= URLEncode(cl);//.replace('#','~')
	var washType 		= document.getElementById('cboWashType').value.trim();
	var garment 		= document.getElementById('cboGarment').value;
	var machine 		= document.getElementById('cboMachine').value;
	var radioType 		= document.getElementById('radioType').value;
	var mode			= "0";
	if(document.frmWashRecieve.radioType[0].checked==true){mode="0"}
	if(document.frmWashRecieve.radioType[1].checked==true){mode="1"}
	var sampleNo 		= document.getElementById('txtSampleNo').value;
	var receiveDate 	= document.getElementById('txtReceiveDate').value;
	var mill 			= document.getElementById('txtMill').value;
	var fabricDsc		= document.getElementById('txtFabricDsc').value;
	var fabricContent	= document.getElementById('txtFabricContent').value;
	var timeHandling	= document.getElementById('txtTimeHandling').value;
	var noOfPcs			= document.getElementById('txtNoOfPcs').value;
	var weight 			= document.getElementById('txtWeight').value;
	//'cboDivision','Please select "Division".',
	var arrFormFields=['cboFabricName','cboCustomerName','cboStyleName','cboColor','cboWashType','cboGarment','cboMachine','txtReceiveDate','txtTimeHandling','txtNoOfPcs','txtWeight'];
	var arrFormFieldsName=['Please select "Fabric Name".','Please select "Customer Name".','Please select "Order No".','Please select "Color".','Please select "Wash Type".','Please select "Garment".','Please select "Machine".','Please add "Date".','Please add "Handling Time".','Please add "No Of Pcs".','Please add "Weight".'];
	
	for(var i=0;i<arrFormFields.length;i++)
	{
		if(document.getElementById(arrFormFields[i]).value.trim()=="")
		{
			alert(arrFormFieldsName[i]);
			document.getElementById(arrFormFields[i]).focus();
			return false;
		}
	}
	
	var url  = "db.php?req=saveHeader";
	url+="&fabricName="+fabricName;
	url+="&customerName="+customerName;
	url+="&styleName="+styleName;
	url+="&division="+division;
	url+="&color="+color;
	url+="&washType="+URLEncode(washType);
	url+="&garment="+garment;
	url+="&machine="+machine;
	url+="&radioType="+mode;
	url+="&sampleNo="+sampleNo;
	url+="&receiveDate="+receiveDate;
	url+="&mill="+mill;
	url+="&fabricDsc="+fabricDsc;
	url+="&fabricContent="+fabricContent;
	url+="&timeHandling="+timeHandling;
	url+="&noOfPcs="+noOfPcs;
	url+="&weight="+weight;	
	htmlobj=$.ajax({url:url,async:false});
	var result=htmlobj.responseText;
	var res=result.split("~");
	if(res[0]==1)
	{
		document.getElementById('txtSampleNo').value=res[1];
		insertCostDetails(res[1]);
	}
	else if(res[0]==2)
	{
		insertCostDetails(res[1]);
	}
}

function insertCostDetails(sNO)
{
	var tblMain=document.getElementById('tblMain');
	var rowCount=tblMain.rows.length;
	if(rowCount==1)
	{
		alert("Header Saved successfully.");
		return false;
	}
	pub_intxmlHttp_count = rowCount-1;
	var intRowOder =[];
	var prcID =[];
	var temp =[];
	var liqour =[];
	var tm  =[];
	for(var i=1;i<rowCount;i++)
	{
		 intRowOder[i] 	= tblMain.rows[i].cells[1].innerHTML;
		 prcID[i] 		= tblMain.rows[i].cells[7].innerHTML;
		 temp[i]  		= tblMain.rows[i].cells[4].childNodes[0].value;
		 liqour[i] 		= tblMain.rows[i].cells[3].childNodes[0].value;
		 tm[i]  		= tblMain.rows[i].cells[5].childNodes[0].value;
	}
	for(var loop=1;loop<prcID.length;loop++)
	{
		var url  = "db.php?req=saveCostDetails";
		url += "&serial="+sNO;
		url += "&rOder="+intRowOder[loop]
	    url += "&prcID="+prcID[loop];
		url += "&temp="+temp[loop];
		url += "&liqour="+liqour[loop];
		url += "&tm="+tm[loop];
		url += "&loop="+loop;
		
		htmlobj=$.ajax({url:url,async:false});

		var cboPoNo =htmlobj.responseText;
		if(cboPoNo==1)
		{
			pub_intxmlHttp_count=pub_intxmlHttp_count-1;
			if (pub_intxmlHttp_count ==0)
			{
					clearChemicals(sNO);
			}
		}
		else
		{
				alert( "Saving error...");
		}
	}
}
//clear chemicals:Budgeted Cost
function clearChemicals(sNO)
{
	var url  = "db.php?req=clearChemicalDetails";
	url += "&serial="+sNO;
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText==1)
	{
		insertChemicals(sNO);
		//clearForm();
	}
}
//insert chemicals:Budgeted Cost
function insertChemicals(sNO)
{
	var tblMain=document.getElementById('tblMain');
	var rowCount=tblMain.rows.length;
			var rowId=[];
			var cmbChemical	= [];
			var prcID=[];
			var chm=[];
			var chmQty=[];
			var chmUP=[];
			for(var r=1;r<rowCount;r++)
			{
				rowId[r]=tblMain.rows[r].cells[1].innerHTML;
				cmbChemical[r]=tblMain.rows[r].cells[6].childNodes[0];
				prcID[r]=tblMain.rows[r].cells[7].innerHTML;
			}
			var count=0;
			for(var i=1;i<cmbChemical.length;i++ )
			{
				for(var a=0;a<cmbChemical[i].length;a++)
				{
					count++;
				}
			}
			pub_intxmlHttp_count1=count;
			if(count==0){alert("Saved successfully.");return false;}
			for(var i=1;i<cmbChemical.length;i++ )
			{
				for(var a=0;a<cmbChemical[i].length;a++)
				{
					var chmSpID="";
					var chmSpID =	cmbChemical[i].options[a].value.split(":");
					chm[a]		=	chmSpID[0];
					chmQty[a]	=	chmSpID[1];
					chmUP[a]	=	chmSpID[2];
					var url  = "db.php?req=saveChemicalDetails";
					url += "&rowOder="+rowId[i];
					url += "&serial="+sNO;
					url += "&prcID="+prcID[i];
					url += "&chmID="+chm[a];
					url += "&chmQty="+chmQty[a];
					url += "&chmUP="+chmUP[a];
					htmlobj=$.ajax({url:url,async:false});
					var cboPoNo="";
					cboPoNo=htmlobj.responseText;
					
					if(parseInt(cboPoNo)== 1)
					{	
						pub_intxmlHttp_count1=pub_intxmlHttp_count1-1;
						if( parseInt(pub_intxmlHttp_count1) == 0 )
						{
							alert('Saved successfully.');	
						}
					}
					else
					{
						alert( "Saving error...");
					}
				}
				
			}
}
//confirm:Budgeted Cost
function confrimWashRecieve()
{
	var sNo=document.getElementById('txtSampleNo').value;
	if(sNo.trim()==""){
		alert("Enter Sample Number.");
		return false;
	}
	
	var url="db.php?req=confirmSample&";
	url += "sNo="+sNo;
	htmlobj=$.ajax({url:url,async:false});
	var res= htmlobj.responseText
	if(res==1){
		alert("Confirmed successfully.");
		if(confirmBudgetedCost)
			document.getElementById('confirmIMG').style.display="none";
			
		document.getElementById('saveIMG').style.display="none";
		document.getElementById('reviseIMG').style.display="inline";
		return false;
	}
}
//revise:Budgeted Cost
function reviseData()
{
	showPleaseWait();
	var sNo=document.getElementById('txtSampleNo').value;
	var revReason = document.getElementById('txtReason').value;
	if(revReason.trim()=="")
	{
		alert("Please enter the 'Reason'.");
		document.getElementById('txtReason').focus();
	}
	var url="db.php?req=reviseSample&reason="+revReason;
	url += "&sNo="+sNo;
	htmlobj=$.ajax({url:url,async:false});
	var res= htmlobj.responseText
	if(res==1){
		alert("Revised successfully.");
		if(confirmBudgetedCost)
			document.getElementById('confirmIMG').style.display="inline";
			
		document.getElementById('saveIMG').style.display="inline";
		document.getElementById('txtReason').value="";
		document.getElementById('revReason').style.visibility="hidden";
		document.getElementById('reviseIMG').style.display="none";
		hidePleaseWait();
		return false;
	}	
}

function loadPrevious()
{
	showBackGround('divBG',0);
	pub_category	= 0;
	var url  = "previousCosting.php";
	var htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,388,'frmPrevious',1);		
	//drawPopupArea(500,345,'frmPrevious');
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmPrevious').innerHTML=HTMLText;
	fix_header('tblPreOder',450,270);
	fix_header('tblConfirm',450,270);
}

function copyDetails(id)
{
	var SNo= document.getElementById('cboCopyBudget').value;

	if(SNo.trim()!="")
	{
		loadDetails(SNo,0);
		document.getElementById('copyBudget').style.visibility = "hidden";
	}
	else
	{
		return false;
	}
}

function loadDetails(id,v)
{
	clearForm();
	var url  = "db.php?req=loadDetails&serial="+id;
	htmlobj=$.ajax({url:url,async:false});
	loadDetialRequest(htmlobj,v);
	CloseWindowInBC();
}

function loadDetialRequest(htmlobj,index)
{
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("intStatus");
	if(XMLStatus[0].childNodes[0].nodeValue==1)
	{
		if(confirmBudgetedCost)
			document.getElementById('confirmIMG').style.display="none";
			
		document.getElementById('saveIMG').style.display="none";
		document.getElementById('reviseIMG').style.display="inline";
	}
	else
	{
		document.getElementById('reviseIMG').style.display="none";
		if(confirmBudgetedCost)
			document.getElementById('confirmIMG').style.display="inline";
			
		document.getElementById('saveIMG').style.display="inline";
	}
	
	var XMLSampleNo = htmlobj.responseXML.getElementsByTagName("intSerialNo");
	var serialNo=XMLSampleNo[0].childNodes[0].nodeValue;
	
	if(index==1)
		document.getElementById('txtSampleNo').value = serialNo;
		
	else
	{
		document.getElementById('txtSampleNo').value = "";
		document.getElementById('reviseIMG').style.display = "none";
		if(confirmBudgetedCost)
			document.getElementById('confirmIMG').style.display = "inline";
			
		document.getElementById('saveIMG').style.display = "inline";
	}
	var XMLMill = htmlobj.responseXML.getElementsByTagName("Mill");
		document.getElementById('txtMill').value = XMLMill[0].childNodes[0].nodeValue;
	var XMLFabricName = htmlobj.responseXML.getElementsByTagName("FabricId");
		document.getElementById('cboFabricName').value = XMLFabricName[0].childNodes[0].nodeValue;
	var XMLFD = htmlobj.responseXML.getElementsByTagName("FD")[0].childNodes[0].nodeValue;	
		document.getElementById('txtFabricDsc').value = XMLFD;
	var XMLFC = htmlobj.responseXML.getElementsByTagName("FC")[0].childNodes[0].nodeValue;
		document.getElementById('txtFabricContent').value = XMLFC;	
	var XMLYear = htmlobj.responseXML.getElementsByTagName("intYear");
		document.getElementById('txtReceiveDate').value = XMLYear[0].childNodes[0].nodeValue;	
	var XMCustomer = htmlobj.responseXML.getElementsByTagName("intCustomerId");
		document.getElementById('cboCustomerName').value= XMCustomer[0].childNodes[0].nodeValue;
	var XMLStyleName = htmlobj.responseXML.getElementsByTagName("StyleName");
		document.getElementById('cboStyleName').value = XMLStyleName[0].childNodes[0].nodeValue;
	var XMLDivision = htmlobj.responseXML.getElementsByTagName("Division");		
		document.getElementById('cboDivision').value = XMLDivision[0].childNodes[0].nodeValue;	
	var XMLColorID = htmlobj.responseXML.getElementsByTagName("strColor");
		document.getElementById('cboColor').value = XMLColorID[0].childNodes[0].nodeValue;	
	var XMLWashType = htmlobj.responseXML.getElementsByTagName("intWashType");
		document.getElementById('cboWashType').value = XMLWashType[0].childNodes[0].nodeValue;	
	var XMLGarment = htmlobj.responseXML.getElementsByTagName("intGarmentId");
		document.getElementById('cboGarment').value = XMLGarment[0].childNodes[0].nodeValue;	
	var XMLMachine = htmlobj.responseXML.getElementsByTagName("cboMachine");
		document.getElementById('cboMachine').value = XMLMachine[0].childNodes[0].nodeValue;
		
	var XMLintCat= htmlobj.responseXML.getElementsByTagName("intCat");
	
	if(XMLintCat[0].childNodes[0].nodeValue=='1')
		document.frmWashRecieve.radioType[1].checked=true;
	else
		document.frmWashRecieve.radioType[0].checked=true;
	
	var XMLNoOfPcs = htmlobj.responseXML.getElementsByTagName("dblQty");
		document.getElementById('txtNoOfPcs').value = XMLNoOfPcs[0].childNodes[0].nodeValue;
	
	var XMLWeight = htmlobj.responseXML.getElementsByTagName("dblWeight");
		document.getElementById('txtWeight').value = XMLWeight[0].childNodes[0].nodeValue;
	
	var XMLTimeHandling = htmlobj.responseXML.getElementsByTagName("dblHTime");
		document.getElementById('txtTimeHandling').value = XMLTimeHandling[0].childNodes[0].nodeValue;
	
	var XMLRowOder 		= htmlobj.responseXML.getElementsByTagName("intRowOder");
	var XMLProcessName 	= htmlobj.responseXML.getElementsByTagName("strProcessName");
	var XMLTemp 		= htmlobj.responseXML.getElementsByTagName("dblTemp");
	var XMLiqour 		= htmlobj.responseXML.getElementsByTagName("dblLiqour");
	var XMLTime 		= htmlobj.responseXML.getElementsByTagName("dblTime");
	var XMLProcessId 	= htmlobj.responseXML.getElementsByTagName("intProcessId");

	for(var i=0;i < XMLProcessName.length;i++)
	{
		var cls;
		(i%2==1)?cls="grid_raw":cls="grid_raw2";
		
		var htm="";
		var tblMain=document.getElementById('tblMain').tBodies[0];
		var rowCount = tblMain.rows.length;
		var row = tblMain.insertRow(rowCount);
		row.className="bcgcolor-tblrowWhite";
		row.style.cursor="pointer";
		row.setAttribute('onMouseOver',"moveTR('tblMain');");
		htm="<td class=\""+cls+"\" style=\"cursor:pointer;\" >";
		htm+="<img src=\"../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
		htm+="<td class=\""+cls+"\">"+XMLRowOder[i].childNodes[0].nodeValue+"</td>";
		htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+XMLProcessName[i].childNodes[0].nodeValue+"</td>";
		htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;\" class=\""+cls+"\"><input type=\"text\" value=\""+XMLiqour[i].childNodes[0].nodeValue+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\" maxlength=\"8\"/></td>";
		htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;\" class=\""+cls+"\"><input type=\"text\" value=\""+XMLTemp[i].childNodes[0].nodeValue+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"  maxlength=\"8\"/></td>";
		htm+="<td class=\""+cls+"\"><input type=\"text\" value=\""+XMLTime[i].childNodes[0].nodeValue+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"  maxlength=\"8\"/></td>";
		htm+="<td class=\""+cls+"\" id=\""+XMLRowOder[i].childNodes[0].nodeValue+"\" style=\"cursor:pointer;\">";
		htm+="<select style=\"width:90px;\" id=\"cboChmID"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"left\">";
		htm+="<option></option>"
		htm+="</select>";
		htm+="<img src=\"../../images/add.png\" onclick=\"loadchemicals(this.id,"+XMLProcessId[i].childNodes[0].nodeValue+");\" id=\"img"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"right\"/>";
		htm+="</td>";
		htm+="<td class=\""+cls+"\">"+XMLProcessId[i].childNodes[0].nodeValue+"</td>";
		row.innerHTML =htm;	
	}
	var XMLChemicalId = htmlobj.responseXML.getElementsByTagName("intChemicalId");
	loadChemicals(serialNo);
	fix_header('tblMain',837,322);
}

function loadChemicals(sno)
{
	var tblMain=document.getElementById('tblMain');
	var rowCount=tblMain.rows.length;
	var rowId=[];
	var cmbChemical	= [];
	var prcID=[];
	var chm=[];
	for(var r=1;r<rowCount;r++)
	{
		rowId[r]=tblMain.rows[r].cells[1].innerHTML;
		prcID[r]=tblMain.rows[r].cells[7].innerHTML;
	}
	for(var i=1;i<rowId.length;i++ )
	{
		var url="db.php?req=loadChemicals&sNo="+sno+"&rId="+rowId[i]+"&pId="+prcID[i]+"";
		htmlobj=$.ajax({url:url,async:false});
		var result=htmlobj.responseText;
		tblMain.rows[i].cells[6].childNodes[0].innerHTML = result;
	}
}

function washReport()
{ 
	var sNO = document.getElementById('txtSampleNo').value;
	if(document.frmWashRecieve.radioReports[0].checked == true)
	{
		 if(document.getElementById('txtSampleNo').value != "")
		 {
			window.open("washingFormulaReport.php?q="+sNO,'WF' ); 
		 }
		 else
		 {
			 alert("Please Select a Sample No");
			 document.getElementById('txtSampleNo').focus();
			 //return false;
		 }
	}
	else
	{
		if(document.getElementById('txtSampleNo').value != "")
		{
			window.open("budgetCostSheetReport.php?q="+sNO,'WC' );		 
		}
		else{
		
		alert("Please Select a Sample No");	 
		document.getElementById('txtSampleNo').focus();
		//return false;
		}
	}
	document.getElementById('reportsPopUp').style.visibility = "hidden";
}

function rowOder()
{
	var tblMain=document.getElementById('tblMain');
	var rowCount = tblMain.rows.length;
	for(var c=1;c<rowCount;c++)
		{	
			tblMain.rows[c].cells[1].innerHTML=c;
		}
	setColors(tblMain,rowCount);
}

function setColors(tblMain,rowCount){
	for(var i=1;i<rowCount;i++){
		var cls;
		(i%2==0)?cls="grid_raw":cls="grid_raw2";
		for(var c=0;c<8;c++){
			tblMain.rows[i].cells[c].className=cls;
		}
	}
}
function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo-1);
	rowOder();
}
//BEGIN - Search Process
function searchProcess(obj,e)
{
	if(e.keyCode!=13)
		return;
	var url="washReciveMiddle.php?req=SearchProcesses&id="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('tblPrc').innerHTML=htmlobj.responseText;
}

function SearchPreCosting()
{
	showPleaseWait();
	var tbl = (pub_category=='0'?'tblPreOder':'tblConfirm');
	var url  = 'washReciveMiddle.php?req=SearchPreCosting'; 
	    url += '&Type='+document.getElementById('cboSType').value;
		url += '&Text='+document.getElementById('txtStype').value;
		url += '&CatId='+pub_category;
		url += '&InOrOut='+document.getElementById('cboPCCat').value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById(tbl).innerHTML=htmlobj.responseText;
	hidePleaseWait();
}
//END - Search Process
function tabSwitch(new_tab, new_content) 
{
	document.getElementById('content_1').style.display = 'none';
	document.getElementById('content_2').style.display = 'none';
	document.getElementById(new_content).style.display = 'block';	
	

	document.getElementById('tab_1').className = '';
	document.getElementById('tab_2').className = '';
	document.getElementById(new_tab).className = 'active';		
}

function tabSwitch_2(active, number, tab_prefix, content_prefix) 
{
	for (var i=1; i < number+1; i++) {
	  document.getElementById(content_prefix+i).style.display = 'none';
	  document.getElementById(tab_prefix+i).className = '';
	}
	document.getElementById(content_prefix+active).style.display = 'block';
	document.getElementById(tab_prefix+active).className = 'active';	
	
}

function LoadCategoryDetails(obj)
{
	if(obj=='0')
	{
		LoadCustomers(0);
	}
	else if(obj=='1')
	{
		LoadCustomers(1);
	}
}

function LoadCustomers(obj)
{
	var url="washReciveMiddle.php?req=LoadCustomers&Category="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboCustomerName').innerHTML = htmlobj.responseText;
}

function GetFabricSerial(obj,e)
{
	if(e.keyCode!=13)
		return;
	var url="washReciveMiddle.php?req=GetFabricSerial&FId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLFD 		= htmlobj.responseXML.getElementsByTagName("FD");
	if(XMLFD.length<=0)
		return;
		document.getElementById('txtFabricDsc').value = XMLFD[0].childNodes[0].nodeValue;
	var XMLFC 		= htmlobj.responseXML.getElementsByTagName("FC")[0].childNodes[0].nodeValue;
		document.getElementById('txtFabricContent').value = XMLFC;
}

function SelectAll(obj,tblName)
{
	var tbl = document.getElementById(tblName);
	if(obj.checked)
		var checked = true;
	else
		var checked = false;
	for(i=1;i<tbl.rows.length;i++)
	{
		tbl.rows[i].cells[5].childNodes[0].checked = checked;
	}
}

function ChangeCat(obj)
{
	pub_category = obj;
}

function SearchChemical(obj,e,pid)
{
	if(obj.value=="")
		return false;
	
	if(e.keyCode!=13)
		return;
	
	var url="washReciveMiddle.php?req=SearchChemical&id="+URLEncode(obj.value)+"&pid="+pid;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('tblChm').innerHTML=htmlobj.responseText;
}

function GetColors(obj,e){
	if(e.keyCode!=13)
		return;
	var url="washReciveMiddle.php?req=GetColors&cId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLCD 		= htmlobj.responseXML.getElementsByTagName("CD");
	if(XMLCD.length<=0)
		return;
		document.getElementById('txtColor').value = XMLCD[0].childNodes[0].nodeValue;
//	var XMLFC 		= htmlobj.responseXML.getElementsByTagName("FC")[0].childNodes[0].nodeValue;
//		document.getElementById('txtColor').value = XMLFC;	
}

function checkfirstDecimal(obj){
	var d=obj.value.trim().charAt(0);	
	if(d=='.')
		obj.value=0;	
}

function checkLastDecimal(obj){
	var len=obj.value.trim().length;
	if(obj.value.trim().charAt(len-1)=='.')
			obj.value=obj.value.trim().substr(0,len-1);
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}

function saveDetToExl(){

var reportName	= "rptexcelBudgetCostReports.php?";
	newwindow=window.open(reportName,'report');	
	if (window.focus) {newwindow.focus()}
}