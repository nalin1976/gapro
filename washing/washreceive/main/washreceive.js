var xmlHttp=[];
var pub_intxmlHttp_count=0;
var pub_intxmlHttp_count1=0;
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
	{
		document.getElementById('revReason').style.visibility = "visible";
	}
	else
	{
		document.getElementById('revReason').style.visibility = "hidden";
	}
}
function loadProcessPopUp()
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = processRequest;
	var url  = "processes.php";
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function processRequest(){
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		drawPopupAreaLayer(500,310,'frmProcess',1);				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmProcess').innerHTML=HTMLText;	
	}
}

function loadWashTypePopUp()
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = washTypeRequest;
	var url  = "washType.php";
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function washTypeRequest(){
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		drawPopupAreaLayer(250,180,'frmWashType',1);				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmWashType').innerHTML=HTMLText;	
	}
}

function CloseWindow(){
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}
function addProcesses(id)
{
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
			//alert(arrSerialCode[i]);
			if(m<arrSerialCode[i])
			{
				m=arrSerialCode[i];
			}
		}
		for(var a=0;a<rowCount;a++)
		{	
			if(arrSerialCode[a] == rowCount )
			{
				rowID=parseInt(m)+1;
			}
		}
		
	}
	
     		var tblMain=document.getElementById('tblMain').tBodies[0];
			var rowCount = tblMain.rows.length;
            var row = tblMain.insertRow(rowCount);
			row.className="bcgcolor-tblrowWhite";
			row.style.cursor="pointer";
			row.setAttribute('onMouseOver',"moveTR('tblMain');");
            var htm = "<td class=\"normalfnt\" style=\"cursor:pointer;\" >";
			htm+="<img src=\"../../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
			htm+="<td class=\"normalfnt\">"+rowID+"</td>";
			htm+="<td class=\"normalfnt\">"+chm+"</td>";
			htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+liqour+"\" style=\"width:100px;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"/></td>";
			htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+temp+"\" style=\"width:80px;\"  onkeypress=\"return CheckforValidDecimal(this.value,3,event)\"/></td>";
			htm+="<td class=\"normalfnt\" style=\"cursor:pointer;\"><input type=\"text\" value=\""+tm+"\" style=\"width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"/></td>";
			htm+="<td class=\"normalfnt\" id=\""+rowID+"\" style=\"cursor:pointer;\">";
			htm+="<select style=\"width:50px;\" id=\"cboChmID"+rowID+"\" align=\"left\">";
			//htm+="<option></option>";
			htm+="</select>";
			htm+="<img src=\"../../../images/add.png\"onclick=\"loadchemicals(this.id,"+serial+");\" id=\"img"+rowID+"\" align=\"right\"/>";
			htm+="</td><td class=\"normalfnt\">"+serial+"</td>";
			row.innerHTML=htm;
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
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = fabricRequest;
	var url  = "washReciveMiddle.php?req=selectFabricDet&cID="+fId+"";
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function fabricRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var arrAll=xmlHttp[0].responseText;
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
	}
}
function loadchemicals(imgID,serial)
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = chemicalsRequest;
	var url  = "chemicals.php?prcId="+serial+"";
	xmlHttp[0].index=imgID;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function chemicalsRequest(){
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		drawPopupAreaLayer(400,300,'frmChemicals',1);				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmChemicals').innerHTML=HTMLText;	
		document.getElementById('hdnVal').value=xmlHttp[0].index;
		var id=xmlHttp[0].index.split('img');
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
			var qty	  = tblChm.rows[a].cells[3].childNodes[1];
			var up	  = tblChm.rows[a].cells[4].childNodes[1];
			for(var i=0;i<arrcboChm;i++)
			if(serial==arrChm[i])
			{
				document.getElementById(chk.id).checked=true;
				qty.value=arrChmQty[i];
				up.value=arrChmUP[i];
			}
		}
	}
}
function selectStyleName(id)
{
	var cId=document.getElementById(id).value;
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = styleRequest;
	var url  = "washReciveMiddle.php?req=selectStyles&cID="+cId+"";
	xmlHttp[0].index=cId
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function styleRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('cboStyleName').innerHTML=HTMLText;	
		selectBuyerDivision(xmlHttp[0].index);
	}
}

function selectBuyerDivision(cId)
{
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = divisionRequest;
	var url  = "washReciveMiddle.php?req=selectDivision&cID="+cId+"";
	xmlHttp[1].open("GET",url,true);
	xmlHttp[1].send(null);
}
function divisionRequest()
{
	if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
	{
		var HTMLText=xmlHttp[1].responseText;
		document.getElementById('cboDivision').innerHTML=HTMLText;	
	}
}
function selectColor(id)
{
	var divID=document.getElementById(id).value;
	var cID  =document.getElementById('cboCustomerName').value;
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = colorRequest;
	var url  = "washReciveMiddle.php?req=selectColor&cID="+cID+"&divID="+divID+"";
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function colorRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('cboColor').innerHTML=HTMLText;	
	}
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
		createXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange = loadWashTypeRequest;
		var url  = "washReciveMiddle.php?req=loadWashType&washType="+washType+"";
		xmlHttp[0].open("GET",url,true);
		xmlHttp[0].send(null);
	}
}

function loadWashTypeRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		 var XMLCode = xmlHttp[0].responseXML.getElementsByTagName("strWasType");				
		 document.getElementById('txtWashType').value = XMLCode[0].childNodes[0].nodeValue;
		 var XMLDesc = xmlHttp[0].responseXML.getElementsByTagName("dblUnitPrice");				
		 document.getElementById('txtUnitPrice').value = XMLDesc[0].childNodes[0].nodeValue;
	}
}
function saveWashType()
{
	var cboWashType= document.getElementById('cboSearchWashType').value;
	var washType=document.getElementById('txtWashType').value;
	var unitPrice=document.getElementById('txtUnitPrice').value;
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
		createXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange = saveWashTypeRequest;
		var url  = "washReciveMiddle.php?req=saveWashType&washType="+washType+"&unitPrice="+unitPrice+"";
		xmlHttp[0].open("GET",url,true);
		xmlHttp[0].send(null);
}
function saveWashTypeRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var result=xmlHttp[0].responseXML;
		alert(result);
	}
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
				arrChmQty[i]	=	tblChm.rows[i].cells[3].childNodes[1].value;
				arrUPrice[i]	=	tblChm.rows[i].cells[4].childNodes[1].value;
				
				var chk=tblChm.rows[i].cells[5].childNodes[0];
				if(document.getElementById(chk.id).checked)
				{
					chmCode.innerHTML += "<option value=\""+arrChmCode[i]+":"+arrChmQty[i]+":"+arrUPrice[i]+"\">"+arrChmCode[i]+":"+arrChmName[i]+"</option>";
				}
			}
}

function clearForm()
{
	document.frmWashRecieve.reset();
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
	var fabricName = document.getElementById('cboFabricName').value;
	var customerName = document.getElementById('cboCustomerName').value;
	var styleName = document.getElementById('cboStyleName').value;
	var division = document.getElementById('cboDivision').value;
	var cl = document.getElementById('cboColor').value;
	var color=cl.replace('#','~');
	var washType = document.getElementById('cboWashType').value;
	var garment = document.getElementById('cboGarment').value;
	var machine = document.getElementById('cboMachine').value;
	var radioType = document.getElementById('radioType').value;
	var sampleNo = document.getElementById('txtSampleNo').value;
	var receiveDate = document.getElementById('txtReceiveDate').value;
	var mill = document.getElementById('txtMill').value;
	var fabricDsc= document.getElementById('txtFabricDsc').value;
	var fabricContent= document.getElementById('txtFabricContent').value;
	var timeHandling= document.getElementById('txtTimeHandling').value;
	var noOfPcs= document.getElementById('txtNoOfPcs').value;
	var weight = document.getElementById('txtWeight').value;
	
	var arrFormFields=['cboFabricName','cboCustomerName','cboStyleName','cboDivision','cboColor','cboWashType','cboGarment','cboMachine','txtReceiveDate','txtTimeHandling','txtNoOfPcs','txtWeight'];
	var arrFormFieldsName=['Fabric Name','Customer Name','Style Name','Division','Color','Wash Type','Garment','Machine','Receive Date','Time Handling','No Of Pcs','Weight'];
	
	for(var i=0;i<arrFormFields.length;i++)
	{
		if(document.getElementById(arrFormFields[i]).value.trim()=="")
		{
			alert("Fill "+arrFormFieldsName[i]);
			document.getElementById(arrFormFields[i]).focus();
			return false;
		}
	}

	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = saveheaderRequest;
	var url  = "db.php?req=saveHeader";
	url+="&fabricName="+fabricName;
	url+="&customerName="+customerName;
	url+="&styleName="+styleName;
	url+="&division="+division;
	url+="&color="+color;
	url+="&washType="+washType;
	url+="&garment="+garment;
	url+="&machine="+machine;
	url+="&radioType="+radioType;
	url+="&sampleNo="+sampleNo;
	url+="&receiveDate="+receiveDate;
	url+="&mill="+mill;
	url+="&fabricDsc="+fabricDsc;
	url+="&fabricContent="+fabricContent;
	url+="&timeHandling="+timeHandling;
	url+="&noOfPcs="+noOfPcs;
	url+="&weight="+weight;
	
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function saveheaderRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var result=xmlHttp[0].responseText;
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
}
function insertCostDetails(sNO)
{
	var tblMain=document.getElementById('tblMain');
	var rowCount=tblMain.rows.length;
	//alert(rowCount);
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
		 temp[i]  		= tblMain.rows[i].cells[3].childNodes[0].value;
		 liqour[i] 		= tblMain.rows[i].cells[4].childNodes[0].value;
		 tm[i]  		= tblMain.rows[i].cells[5].childNodes[0].value;
	}
	for(var loop=1;loop<prcID.length;loop++)
	{
		//alert(loop);
		createXMLHttpRequest(loop);
		xmlHttp[loop].onreadystatechange = saveCostDetailsRequest;
		var url  = "db.php?req=saveCostDetails";
		
		url += "&serial="+sNO;
		url += "&rOder="+intRowOder[loop]
	    url += "&prcID="+prcID[loop];
		url += "&temp="+temp[loop];
		url += "&liqour="+liqour[loop];
		url += "&tm="+tm[loop];
		url += "&loop="+loop;
	xmlHttp[loop].index = loop;
	xmlHttp[loop].index2 = sNO;
	xmlHttp[loop].open("GET",url,true);
	xmlHttp[loop].send(null);
	}
}

function saveCostDetailsRequest()
{
	if(xmlHttp[this.index].readyState == 4 && xmlHttp[this.index].status == 200 ) 
	{
		var cboPoNo =xmlHttp[this.index].responseText;
		if(cboPoNo==1)
		{
		pub_intxmlHttp_count=pub_intxmlHttp_count-1;
			
			if (pub_intxmlHttp_count ==0)
			{
				//alert(pub_intxmlHttp_count);
					clearChemicals(this.index2);
			}
		}
		else
		{
				alert( "Saving error...");
		}
	}
}

function clearChemicals(sNO)
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = clearChemicalDetailsRequest;
	var url  = "db.php?req=clearChemicalDetails";
	url += "&serial="+sNO;
	xmlHttp[0].index = sNO;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function clearChemicalDetailsRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		if(xmlHttp[0].responseText==1)
		{
			insertChemicals(xmlHttp[0].index);
		}
	}
}
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
			//alert(pub_intxmlHttp_count1);
			for(var i=1;i<cmbChemical.length;i++ )
			{
				for(var a=0;a<cmbChemical[i].length;a++)
				{
					var chmSpID="";
					var chmSpID =	cmbChemical[i].options[a].value.split(":");
					chm[a]		=	chmSpID[0];
					chmQty[a]	=	chmSpID[1];
					chmUP[a]	=	chmSpID[2];
					createXMLHttpRequest(a);
					xmlHttp[a].onreadystatechange = saveChemicalDetailsRequest;
					var url  = "db.php?req=saveChemicalDetails";
					url += "&rowOder="+rowId[i];
					url += "&serial="+sNO;
					url += "&prcID="+prcID[i];
					url += "&chmID="+chm[a];
					url += "&chmQty="+chmQty[a];
					url += "&chmUP="+chmUP[a];
					xmlHttp[a].index = a;
					xmlHttp[a].index2 =count;
					//alert(xmlHttp[a].index2);
					xmlHttp[a].open("GET",url,true);
					xmlHttp[a].send(null);
				}
				
			}
}
function saveChemicalDetailsRequest()
{
	if(xmlHttp[this.index].readyState == 4 && xmlHttp[this.index].status == 200 ) 
	{
		var cboPoNo="";
		cboPoNo =xmlHttp[this.index].responseText;

			if(parseInt(cboPoNo)== 1)
			{	
				pub_intxmlHttp_count1=pub_intxmlHttp_count1-1;
				//alert(parseInt(pub_intxmlHttp_count1));
				if( parseInt(pub_intxmlHttp_count1) == 0 )
				{
					alert('Successfully Saved.');	
				}
			}
			else
			{
				alert( "Saving error...");
			}
	}
}
function confrimWashRecieve()
{
	var sNo=document.getElementById('txtSampleNo').value;
	if(sNo.trim()=="")
	{
		alert("Enter Sample Number.");
		return false;
	}
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = confirmRequest;
	var url="db.php?req=confirmSample&";
	url += "sNo="+sNo;

	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function confirmRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var res= xmlHttp[0].responseText
		if(res==1)
		alert("Comfiremed successfully.");
		document.getElementById('confirmIMG').style.visibility="hidden";
		document.getElementById('saveIMG').style.visibility="hidden";
		document.getElementById('reviseIMG').style.visibility="visible";
		return false;
	}
}

function reviseData()
{
	var sNo=document.getElementById('txtSampleNo').value;
	var revReason = document.getElementById('txtReason').value;
	if(revReason.trim()=="")
	{
		alert("Fill reason.");
	}
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = reviseRequest;
	var url="db.php?req=reviseSample&reason="+revReason;
	url += "&sNo="+sNo;

	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
	
}
function reviseRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var res= xmlHttp[0].responseText
		if(res==1)
		alert("Revised successfully.");
		document.getElementById('confirmIMG').style.visibility="visible";
		document.getElementById('saveIMG').style.visibility="visible";
		document.getElementById('revReason').style.visibility="hidden";
		document.getElementById('reviseIMG').style.visibility="hidden";
		return false;
	}
}

function loadPrevious()
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = previousRequest;
	var url  = "previousCosting.php";
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function previousRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		drawPopupAreaLayer(500,345,'frmPrevious',1);				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmPrevious').innerHTML=HTMLText;	
	}
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
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = loadDetialRequest;
	var url  = "db.php?req=loadDetails&serial="+id;
	xmlHttp[0].index=v;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}
function loadDetialRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		
		var XMLStatus = xmlHttp[0].responseXML.getElementsByTagName("intStatus");
		//alert(XMLStatus[0].childNodes[0].nodeValue);
		if(XMLStatus[0].childNodes[0].nodeValue==1)
		{
			document.getElementById('confirmIMG').style.visibility="hidden";
			document.getElementById('saveIMG').style.visibility="hidden";
			document.getElementById('reviseIMG').style.visibility="visible";
		}
		else
		{
			document.getElementById('reviseIMG').style.visibility="hidden";
			document.getElementById('confirmIMG').style.visibility="visible";
			document.getElementById('saveIMG').style.visibility="visible";
		}
		
		var XMLSampleNo = xmlHttp[0].responseXML.getElementsByTagName("intSerialNo");
		var serialNo=XMLSampleNo[0].childNodes[0].nodeValue;
		
		if(xmlHttp[0].index==1)
		{
			document.getElementById('txtSampleNo').value = serialNo;
			
		}
		else
		{
			document.getElementById('txtSampleNo').value ="";
			/*if(XMLStatus[0].childNodes[0].nodeValue!=1){
				document.getElementById('reviseIMG').style.visibility="hidden";
				document.getElementById('confirmIMG').style.visibility="visible";
			}
			else
			{
				
				document.getElementById('confirmIMG').style.visibility="visible";
			}*/
			document.getElementById('reviseIMG').style.visibility="hidden";
			document.getElementById('confirmIMG').style.visibility="visible";
			document.getElementById('saveIMG').style.visibility="visible";
		}
		
		var XMLFabricName = xmlHttp[0].responseXML.getElementsByTagName("intMatDetailId");
		document.getElementById('cboFabricName').value = XMLFabricName[0].childNodes[0].nodeValue;
		
		var XMLYear = xmlHttp[0].responseXML.getElementsByTagName("intYear");
		document.getElementById('txtReceiveDate').value = XMLYear[0].childNodes[0].nodeValue;
		
		var XMCustomer = xmlHttp[0].responseXML.getElementsByTagName("intCustomerId");
		document.getElementById('cboCustomerName').value= XMCustomer[0].childNodes[0].nodeValue;
		
		var XMLStyle = xmlHttp[0].responseXML.getElementsByTagName("intStyleId");
		document.getElementById('cboStyleName').value = XMLStyle[0].childNodes[0].nodeValue;	
		
		var XMLDivision = xmlHttp[0].responseXML.getElementsByTagName("intDivisionId");
		document.getElementById('cboDivision').value = XMLDivision[0].childNodes[0].nodeValue;	
		
		var XMLColor = xmlHttp[0].responseXML.getElementsByTagName("strColor");
		document.getElementById('cboColor').value = XMLColor[0].childNodes[0].nodeValue;	
		
		var XMLWashType= xmlHttp[0].responseXML.getElementsByTagName("intWashType");
		document.getElementById('cboWashType').value = XMLWashType[0].childNodes[0].nodeValue;
		
		var XMLGarment= xmlHttp[0].responseXML.getElementsByTagName("intGarmentId");
		document.getElementById('cboGarment').value = XMLGarment[0].childNodes[0].nodeValue;
		
		var XMLMachine= xmlHttp[0].responseXML.getElementsByTagName("cboMachine");
		document.getElementById('cboMachine').value = XMLMachine[0].childNodes[0].nodeValue;
			
		var XMLNoOfPcs= xmlHttp[0].responseXML.getElementsByTagName("dblQty");
		document.getElementById('txtNoOfPcs').value = XMLNoOfPcs[0].childNodes[0].nodeValue;
		
		var XMLWeight= xmlHttp[0].responseXML.getElementsByTagName("dblWeight");
		document.getElementById('txtWeight').value = XMLWeight[0].childNodes[0].nodeValue;
		
		var XMLTimeHandling= xmlHttp[0].responseXML.getElementsByTagName("dblHTime");
		document.getElementById('txtTimeHandling').value = XMLTimeHandling[0].childNodes[0].nodeValue;
		
		var XMLRowOder = xmlHttp[0].responseXML.getElementsByTagName("intRowOder");
		var XMLProcessName = xmlHttp[0].responseXML.getElementsByTagName("strProcessName");
		var XMLTemp = xmlHttp[0].responseXML.getElementsByTagName("dblTemp");
		var XMLiqour = xmlHttp[0].responseXML.getElementsByTagName("dblLiqour");
		var XMLTime = xmlHttp[0].responseXML.getElementsByTagName("dblTime");
		var XMLProcessId = xmlHttp[0].responseXML.getElementsByTagName("intProcessId");

		for(var i=0;i < XMLProcessName.length;i++)
		{
			var htm="";
			var tblMain=document.getElementById('tblMain').tBodies[0];
			var rowCount = tblMain.rows.length;
            var row = tblMain.insertRow(rowCount);
			row.className="bcgcolor-tblrowWhite";
			row.style.cursor="pointer";
			row.setAttribute('onMouseOver',"moveTR('tblMain');");
			htm="<td class=\"normalfnt\" style=\"cursor:pointer;\" >";
			htm+="<img src=\"../../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
			htm+="<td class=\"normalfnt\">"+XMLRowOder[i].childNodes[0].nodeValue+"</td>";
			htm+="<td class=\"normalfnt\">"+XMLProcessName[i].childNodes[0].nodeValue+"</td>";
			htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;\" class=\"normalfnt\"><input type=\"text\" value=\""+XMLTemp[i].childNodes[0].nodeValue+"\" style=\"width:100px;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"/></td>";
			htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;\" class=\"normalfnt\"><input type=\"text\" value=\""+XMLiqour[i].childNodes[0].nodeValue+"\" style=\"width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value,3,event)\"/></td>";
			htm+="<td class=\"normalfnt\"><input type=\"text\" value=\""+XMLTime[i].childNodes[0].nodeValue+"\" style=\"width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"/></td>";
			htm+="<td class=\"normalfnt\" id=\""+XMLRowOder[i].childNodes[0].nodeValue+"\" style=\"cursor:pointer;\">";
			htm+="<select style=\"width:50px;\" id=\"cboChmID"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"left\">";
			htm+="<option></option>"
			htm+="</select>";
			htm+="<img src=\"../../../images/add.png\"onclick=\"loadchemicals(this.id,"+XMLProcessId[i].childNodes[0].nodeValue+");\" id=\"img"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"right\"/>";
			htm+="</td>";
			htm+="<td class=\"normalfnt\">"+XMLProcessId[i].childNodes[0].nodeValue+"</td>";
			row.innerHTML =htm;	
		}
		var XMLChemicalId = xmlHttp[0].responseXML.getElementsByTagName("intChemicalId");

		loadChemicals(serialNo);
		selectFabricDet();
	}
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
		createXMLHttpRequest(i);
		xmlHttp[i].onreadystatechange = loadChemicalReq;
		//alert(i);
		xmlHttp[i].index=i;
		xmlHttp[i].index2=tblMain;
		xmlHttp[i].open("GET",url,true);
		xmlHttp[i].send(null);
	}
}

function loadChemicalReq()
{
	if(xmlHttp[this.index].readyState == 4 && xmlHttp[this.index].status == 200 ) 
	{
		var tbl=this.index2;
		//alert(xmlHttp[this.index].responseText);
		tbl.rows[this.index].cells[6].childNodes[0].innerHTML = xmlHttp[this.index].responseText;
		
	}
}
function washReport(){ 
	var sNO = document.getElementById('txtSampleNo').value;
 if(document.frmWashRecieve.radioReports[0].checked == true){
	 if(document.getElementById('txtSampleNo').value != ""){
	    
		window.open("washingFormulaReport.php?q="+sNO ); 
	 }
	 else
	 {
		 alert("Please Select a Sample No");
	 }
 }else{
	 if(document.getElementById('txtSampleNo').value != ""){
     window.open("budgetCostSheetReport.php?q="+sNO ); 
	 }else{
	   alert("Please Select a Sample No");	 
	 }
 }
}

function rowOder()
{
	var tblMain=document.getElementById('tblMain');
	var rowCount = tblMain.rows.length;
	for(var c=1;c<rowCount;c++)
		{
			tblMain.rows[c].cells[1].innerHTML=c;
		}
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	//alert(rowNo);
	tblMain.deleteRow(rowNo-1);
	rowOder();
}
//==========Search
function searchProcess(obj)
{
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = searchProcessReq;
	var url="washReciveMiddle.php?req=searcProcesses&id="+obj.value;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function searchProcessReq()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var tbl=document.getElementById('tblPrc');
		tbl.innerHTML= xmlHttp[0].responseText;
	}
}
//==========
//tabs- 
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