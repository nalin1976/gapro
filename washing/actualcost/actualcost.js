var pub_category = 0;
var xmlHttp = [];
//'cboOrderNo','Order No','orderNo','division',
//'cboDivision','Division','cboStyleId','Please select "Style Name".','styName',,'Please select "Division".''cboDivision',
var arrFieldIDs=['cboOrderNo','cboCustomer','cboMainFabric','cboColor','cboBranch','cboMachineType','txtNoOfPcs','cboGarmentType','cboWashType','txtWeight','txtTotHTime'];

var arrFieldList=['Please select "Order No".','Please select "Customer Name".','Please select "Fabric Name".','Please select "Color".','Please select "Branch".','Please select "Machine Type".','Please enter "No Of Pcs".','Please select "Garment Type".','Please select "Wash Type".','Please enter "Weight".','Please enter "Total Handling Time".'];

var arrUrlIds=['orderNo','cusName','fabName','color','branch','machineType','noOfPcs','garmentType','division',' washType','weight','totalHT'];
var arrUrlFieldIDs=['cboOrderNo','cboCustomer','cboMainFabric','cboColor','cboBranch','cboMachineType','txtNoOfPcs','cboGarmentType','cboDivision','cboWashType','txtWeight','txtTotHTime'];

var otherFields=['txtOrderQty','txtExPercent','txtTotalQty'];
var otherUrlIds=['orderQty','exPercent','totalQty'];

//var tblMain=document.getElementById('tblMain').tBodies[0];
//var rowCount=tblMain.rows.length;
var gbPo='';
function createXMLHttpRequest(index){
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function validarionFields()
{
	for(var i=0;i<arrFieldIDs.length;i++)
	{
		if(document.getElementById(arrFieldIDs[i]).value.trim()=="")
		{
			alert(arrFieldList[i]);
			document.getElementById(arrFieldIDs[i]).focus();
			return false;
		}
	}
	return true;
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function LoadDetails(obj)
{
	if(obj.value==""){
		ClearForm();
		return;
	}
	//alert(obj.value.trim());
	LoadMainFabAndMill(obj.value);
	LoadOrderNo(obj.value);
	//LoadWashPriceDetails(obj.value);
}


function ClearForm()
{
	document.getElementById('cboCustomer').value = "";
	document.getElementById('cboOrderNo').value = "";
	document.getElementById('cboMainFabric').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('cboColor').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('cboBranch').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('cboMachineType').value = "";
	document.getElementById('txtOrderQty').value = "";
	document.getElementById('txtExPercent').value = "";
	document.getElementById('txtTotalQty').value = "";
	document.getElementById('cboMill').innerHTML = "";
	document.getElementById('txtDescription').value = "";
	document.getElementById('cboDivision').innerHTML = "";
	document.getElementById('cboGarmentType').innerHTML = "";
	document.getElementById('cboWashType').innerHTML = "";
	document.getElementById('txtWeight').value = "";
	document.getElementById('txtTotHTime').value = "";
	document.getElementById('cboStyleId').value = "";
	document.getElementById('saveIMG').style.display='inline';
	document.getElementById('reviseIMG').style.display='none';
	
	document.getElementById('frmmain').reset();
	var tbl=document.getElementById('tblMain').tBodies[0];
	var rCount = tbl.rows.length;
	for(var loop=0;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}
	document.getElementById('confirmIMG').style.display='none';
}

function CloseWindow(){
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

function loadchemicals(imgID,serial)
{
	showBackGround('divBG',0);
	var url  = "chemicals.php?prcId="+serial+"";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,300,'frmChemicals',1);				
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
	for(var i=1;i<rowCount;i++){
		arrChmCode[i]	=	tblChm.rows[i].cells[0].innerHTML;
		arrChmName[i]	=	tblChm.rows[i].cells[1].innerHTML;
		arrChmQty[i]	=	tblChm.rows[i].cells[3].childNodes[1].value;
		arrUPrice[i]	=	tblChm.rows[i].cells[4].childNodes[1].value;
				
		var chk=tblChm.rows[i].cells[5].childNodes[0];
		if(document.getElementById(chk.id).checked){
			chmCode.innerHTML += "<option value=\""+arrChmCode[i]+":"+arrChmQty[i]+":"+arrUPrice[i]+"\">"+arrChmCode[i]+":"+arrChmName[i]+"</option>";
		}
	}
	CloseWindow();
}

function loadPrevious()
{
	showBackGround('divBG',0);
	var url  = "previousCosting.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,345,'frmPrevious',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmPrevious').innerHTML=HTMLText;	
}

function LoadOrderNo(styleId,cat)
{
	var req="LoadOrderNo";
	if(cat==1){
		req="LoadOrderDetails";
	}
	else{
		req="LoadOrderNo";	
	}
	var url='actualcostmiddle.php?RequestType='+req+'&StyleId=' +styleId +'&cat='+cat;
	htmlobj=$.ajax({url:url,async:false});

	var XMLDivisionId = htmlobj.responseXML.getElementsByTagName("DivisionId");
	var XMLDivisionName = htmlobj.responseXML.getElementsByTagName("DivisionName");
	if(XMLDivisionName.length > 0){
		var opt = document.createElement("option");
		opt.value = XMLDivisionId[0].childNodes[0].nodeValue;	
		opt.text = XMLDivisionName[0].childNodes[0].nodeValue;	
		document.getElementById("cboDivision").options.add(opt);
	}		
		
	var XMLOrderNo =htmlobj.responseXML.getElementsByTagName("OrderNo");
	var XMLOrderId =htmlobj.responseXML.getElementsByTagName("OrderId");
	document.getElementById("cboOrderNo").innerHTML="";
	document.getElementById("cboOrderNo").innerHTML="<option value=\"\">Select one</option>";
	gbPo=XMLOrderId[0].childNodes[0].nodeValue;
	/*var sqlLO="SELECT o.intStyleId,o.strOrderNo FROM was_washpriceheader AS w INNER JOIN orders AS o ON o.intStyleId = w.intStyleId WHERE o.intStyleId <> '"+XMLOrderId[0].childNodes[0].nodeValue+"';";
	//alert(sqlLO);
	loadCombo(sqlLO,"cboOrderNo");*/
	
	if(XMLOrderNo.length > 0){
		var opt = document.createElement("option");
		opt.value = XMLOrderId[0].childNodes[0].nodeValue;	
		opt.text = XMLOrderNo[0].childNodes[0].nodeValue;	
		document.getElementById("cboOrderNo").options.add(opt);		
	}
	var XMLDesc	=	htmlobj.responseXML.getElementsByTagName("Description");
	if(XMLDesc.length>0){
	var XMLDescription = XMLDesc[0].childNodes[0].nodeValue;
	document.getElementById('txtDescription').value = XMLDescription;
	}
	
	var XMLOrderQty = parseFloat(htmlobj.responseXML.getElementsByTagName("OrderQty")[0].childNodes[0].nodeValue);	
	var XMLExPercent = parseFloat(htmlobj.responseXML.getElementsByTagName("ExPercent")[0].childNodes[0].nodeValue);
		
	document.getElementById('txtOrderQty').value = XMLOrderQty;
	document.getElementById('txtExPercent').value = XMLExPercent;
	document.getElementById('txtTotalQty').value = Math.round(XMLOrderQty + (XMLOrderQty * XMLExPercent / 100));
}

function LoadOrderDetails(styleId,cat)
{
	var mode=0;
	if(cat==0 || cat==1){
		mode=cat;
	}
	else{
		if(document.frmmain.rdoCategory[0].checked==true){mode="0"}
		if(document.frmmain.rdoCategory[1].checked==true){mode="1"}
	}
		
	var url='actualcostmiddle.php?RequestType=LoadOrderDetails&StyleId='+styleId+'&cat='+mode;
	htmlobj=$.ajax({url:url,async:false});

	var XMLDivisionId = htmlobj.responseXML.getElementsByTagName("DivisionId");
	var XMLDivisionName = htmlobj.responseXML.getElementsByTagName("DivisionName");
	if(XMLDivisionName.length > 0){
		document.getElementById("cboDivision").innerHTML="";
		var opt = document.createElement("option");
		opt.value = XMLDivisionId[0].childNodes[0].nodeValue;	
		opt.text = XMLDivisionName[0].childNodes[0].nodeValue;	
		document.getElementById("cboDivision").options.add(opt);
	}	
	var XMLDes=htmlobj.responseXML.getElementsByTagName("Description");
	if(XMLDes.length>0){
		var XMLDescription = XMLDes[0].childNodes[0].nodeValue;
		document.getElementById('txtDescription').value = XMLDescription;
	}
	
	var XMLOQ=htmlobj.responseXML.getElementsByTagName("OrderQty");
	var XMLOrderQty=0;
	if(XMLOQ.length>0){
		 XMLOrderQty= parseFloat(XMLOQ[0].childNodes[0].nodeValue);	
	}
	var XMLExPer=htmlobj.responseXML.getElementsByTagName("ExPercent");
	var XMLExPercent=0;
	if(XMLOQ.length>0){
	 XMLExPercent= parseFloat(XMLExPer[0].childNodes[0].nodeValue);
	}
	//if($('#cboOrderNo').value.trim()!=""){
		document.getElementById('txtOrderQty').value = XMLOrderQty;
		document.getElementById('txtExPercent').value = XMLExPercent;
		document.getElementById('txtTotalQty').value = Math.round(XMLOrderQty + (XMLOrderQty * XMLExPercent / 100));
	//}
}

function LoadMainFabAndMill(styleId,ct){
	//RomoveData("cboOrderNo")
	if(styleId==""){
		ClearForm();	
	}
	var cat=0;
	if(ct==0 || ct==1)
	cat=ct;
	else{
		if(document.frmmain.rdoCategory[0].checked==true){cat="0"}
		if(document.frmmain.rdoCategory[1].checked==true){cat="1"}
	}
		
	var url='actualcostmiddle.php?RequestType=LoadMainFabAndMill&StyleId=' +styleId+"&cat="+cat;
	htmlobj=$.ajax({url:url,async:false});
	var XMLMatDetailId = htmlobj.responseXML.getElementsByTagName("MatDetailId");
	var XMLItemDescription = htmlobj.responseXML.getElementsByTagName("ItemDescription");
	if(XMLMatDetailId.length > 0){
		document.getElementById("cboMainFabric").innerHTML="";
	var opt = document.createElement("option");
		opt.value = XMLMatDetailId[0].childNodes[0].nodeValue;	
		opt.text = XMLItemDescription[0].childNodes[0].nodeValue;	
		document.getElementById("cboMainFabric").options.add(opt);
	}
	var XMLMillId = htmlobj.responseXML.getElementsByTagName("MillId");
	var XMLMillName = htmlobj.responseXML.getElementsByTagName("MillName");
	if(XMLMillId.length > 0){
		document.getElementById("cboMill").innerHTML="";
	var opt = document.createElement("option");
		opt.value = XMLMillId[0].childNodes[0].nodeValue;	
		opt.text = XMLMillName[0].childNodes[0].nodeValue;	
		document.getElementById("cboMill").options.add(opt);	
	}
}

function LoadWashPriceDetails(obj,ct)
{
	//RomoveData("cboOrderNo")\
	var mode=0;
	if(ct==0 || ct==1){
		mode=ct;
	}
	else{
		if(document.frmmain.rdoCategory[0].checked==true){mode="0"}
		if(document.frmmain.rdoCategory[1].checked==true){mode="1"}
	}	
	var styleId	=obj.value;
	var url='actualcostmiddle.php?RequestType=LoadWashPriceDetailsRequest&StyleId=' +styleId+'&cat='+mode;
	htmlobj=$.ajax({url:url,async:false});
	var XMLColor = htmlobj.responseXML.getElementsByTagName("Color");
	if(XMLColor.length>0){
		document.getElementById("cboColor").innerHTML="<option value=\"\">Select Item</option>";
	var opt = document.createElement("option");
		opt.value = XMLColor[0].childNodes[0].nodeValue;	
		opt.text = XMLColor[0].childNodes[0].nodeValue;	
		document.getElementById("cboColor").options.add(opt);
		document.getElementById('cboColor').selectedIndex=1;
	}
	var XMLGarmentId = htmlobj.responseXML.getElementsByTagName("GarmentId");
	var XMLGarmentName = htmlobj.responseXML.getElementsByTagName("GarmentName");
	document.getElementById('cboGarmentType').innerHTML="";
	if(XMLGarmentId.length>0){
	var opt = document.createElement("option");
		opt.value = XMLGarmentId[0].childNodes[0].nodeValue;	
		opt.text = XMLGarmentName[0].childNodes[0].nodeValue;	
		document.getElementById("cboGarmentType").options.add(opt);
		document.getElementById('cboGarmentType').value=XMLGarmentId[0].childNodes[0].nodeValue;
	}
	
	var XMLWasTypeId = htmlobj.responseXML.getElementsByTagName("WasTypeId");
	var XMLWasType = htmlobj.responseXML.getElementsByTagName("WasType");
	document.getElementById("cboWashType").innerHTML="";
	if(XMLWasTypeId.length>0){
	var opt = document.createElement("option");
		opt.value = XMLWasTypeId[0].childNodes[0].nodeValue;	
		opt.text = XMLWasType[0].childNodes[0].nodeValue;	
		document.getElementById("cboWashType").options.add(opt);	
	}
	var XMLCompany = htmlobj.responseXML.getElementsByTagName("Company");
	if(XMLCompany.length>0){
	document.getElementById('cboCustomer').value=XMLCompany[0].childNodes[0].nodeValue;
	document.getElementById('cboCustomer').onchange();
	}
	
}

function selectMaxCapacity(obj){
	var path="actualcostmiddle.php?RequestType=getMaxMachineCapacity&mId="+obj.value;
	htmlobj=$.ajax({url:path,async:false});
	var XMLQty = htmlobj.responseXML.getElementsByTagName("McQty");
	document.getElementById('txtNoOfPcs').value=XMLQty[0].childNodes[0].nodeValue;
}

function LoadBranch(val,cat)
{
	RomoveData("cboBranch");
		var mode=0;
		if(cat==0 || cat==1){
			mode=cat;
		}else{
			if(document.frmmain.rdoCategory[0].checked==true){mode="0"}
			if(document.frmmain.rdoCategory[1].checked==true){mode="1"}
		}
		
	var url='actualcostmiddle.php?RequestType=LoadBranch&CustomerId=' +val+'&cat='+mode;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboBranch').innerHTML = htmlobj.responseText;
}

function LoadProcess(obj)
{
	showBackGround('divBG',0);
	var url='process.php?';
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,300,'frmProcess',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmProcess').innerHTML=HTMLText;				
}
//add Processes
function addProcesses(id)
{
	var tblPrc = document.getElementById("mytable");
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

			if(parseInt(m)<arrSerialCode[i])
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
            var htm = "<td class=\"normalfnt\" style=\"cursor:pointer;text-align:right;\" >";
			htm+="<img src=\"../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
			htm+="<td class=\"normalfnt\" style=\"text-align:right;\">"+rowID+"</td>";
			htm+="<td class=\"normalfnt\"  style=\"text-align:left;\">"+chm+"</td>";
			htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+temp+"\" style=\"width:100px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td class=\"normalfnt\" id='"+rowID+"' style=\"cursor:pointer;\"><input type=\"text\" value=\""+liqour+"\" style=\"width:80px;text-align:right;\"  onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td class=\"normalfnt\" style=\"cursor:pointer;\"><input type=\"text\" value=\""+tm+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td class=\"normalfnt\" id=\""+rowID+"\" style=\"cursor:pointer;\" valign=\"top\">";
			htm+="<select style=\"width:75px;\" id=\"cboChmID"+rowID+"\" align=\"left\">";
			//htm+="<option></option>";
			htm+="</select>";
			htm+="<img src=\"../../images/add.png\"onclick=\"loadchemicals(this.id,"+serial+");\" id=\"img"+rowID+"\" align=\"right\"/>";
			htm+="</td><td class=\"normalfnt\"  style=\"text-align:right;\">"+serial+"</td>";
			htm+="<td class=\"normalfnt\"><input type=\"text\" style=\"width:50px;text-align:right;\" maxlength=\"10\"></td>";
			row.innerHTML=htm;
			rowOder();
}

function SaveValidation()
{
	if(validarionFields())
	{
		//var radioType = document.getElementById('radioType').value;
		var mode="0";
		if(document.frmmain.rdoCategory[0].checked==true){mode="0"}
		if(document.frmmain.rdoCategory[1].checked==true){mode="1"}
		
		var url="actualcostdb.php?";
		var serial=document.getElementById('txtSampleNo').value.trim();
		(serial=="")?url +="req=saveHeader":url +="req=updateHeader&serial="+serial;
		
		for(var i=0;i<arrUrlFieldIDs.length;i++)
		{
			url += "&"+arrUrlIds[i]+"="+URLEncode(document.getElementById(arrUrlFieldIDs[i]).value.trim());
		}
		for(var i=0;i<otherUrlIds.length;i++)
		{
			url += "&"+otherUrlIds[i]+"="+URLEncode(document.getElementById(otherFields[i]).value.trim());
		}
		
		url+="&mode="+mode;
		htmlobj=$.ajax({url:url,async:false});

		var res=htmlobj.responseText.split("~");
		if(res[0]==1)
		{
			document.getElementById('txtSampleNo').value=res[1];
			insertActCostDetails(res[1]);
		}
	}
}

function insertActCostDetails(sNO)
{
	var tblMain=document.getElementById('tblMain');
	var rowCount=tblMain.rows.length;
	if(rowCount==1)
	{
		alert("Header saved successfully.");
		return false;
	}
	pub_intxmlHttp_count = rowCount-1;
	var intRowOder =[];
	var prcID =[];
	var temp =[];
	var liqour =[];
	var tm  =[];
	var PHValue = [];
	for(var i=1;i<rowCount;i++)
	{
		 intRowOder[i] 	= tblMain.rows[i].cells[1].innerHTML;
		 prcID[i] 		= tblMain.rows[i].cells[7].innerHTML;
		 temp[i]  		= tblMain.rows[i].cells[4].childNodes[0].value;
		 liqour[i] 		= tblMain.rows[i].cells[3].childNodes[0].value;
		 tm[i]  		= tblMain.rows[i].cells[5].childNodes[0].value;
		 PHValue[i]		= tblMain.rows[i].cells[8].childNodes[0].value;
	}
	for(var loop=1;loop<prcID.length;loop++)
	{
		//alert(loop);
		createXMLHttpRequest(loop);
		//xmlHttp[loop].onreadystatechange = saveActCostDetailsRequest;
		var url  = "actualcostdb.php?req=saveCostDetails";
		
		url += "&serial="+sNO;
		url += "&rOder="+intRowOder[loop]
	    url += "&prcID="+prcID[loop];
		url += "&temp="+temp[loop];
		url += "&liqour="+liqour[loop];
		url += "&tm="+tm[loop];
		url += "&PHValue="+PHValue[loop];
		url += "&loop="+loop;
		htmlobj=$.ajax({url:url,async:false});
		
		var cboPoNo =htmlobj.responseText;
		if(cboPoNo==1)
		{
			pub_intxmlHttp_count=pub_intxmlHttp_count-1;
			if (pub_intxmlHttp_count == 0)
			{
					clearActChemicals(sNO);
			}
		}
		else
		{
				alert( "Saving error...");
		}
	}
}
function clearActChemicals(sNO)
{
	var url  = "actualcostdb.php?req=clearChemicalDetails";
	url += "&serial="+sNO;
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText==1)
	{
		insertChemicals(sNO);
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
	if(count==0){
		alert('Saved successfully.');
		document.getElementById('confirmIMG').style.display='inline';
		return false;
	}
	pub_intxmlHttp_count1=count;
	
	for(var i=1;i<cmbChemical.length;i++ )
	{
		for(var a=0;a<cmbChemical[i].length;a++)
		{
			var chmSpID="";
			var chmSpID =	cmbChemical[i].options[a].value.split(":");
				chm[a]		=	chmSpID[0];
				chmQty[a]	=	chmSpID[1];
				chmUP[a]	=	chmSpID[2];
			var url  = "actualcostdb.php?req=saveChemicalDetails";
				url += "&rowOder="+rowId[i];
				url += "&serial="+sNO;
				url += "&prcID="+prcID[i];
				url += "&chmID="+chm[a];
				url += "&chmQty="+chmQty[a];
				url += "&chmUP="+chmUP[a];

				htmlobj=$.ajax({url:url,async:false});	
			var cboPoNo="";
				cboPoNo =htmlobj.responseText;

			if(parseInt(cboPoNo)== 1)
			{	
				pub_intxmlHttp_count1=pub_intxmlHttp_count1-1;
				if( parseInt(pub_intxmlHttp_count1) == 0 )
				{
					alert('Saved successfully.');	
					document.getElementById('confirmIMG').style.display='inline';
					//ClearForm();
				}
			}
			else
			{
				alert( "Saving error...");
			}
		}
	}
}

function copyActCostDetails(id)
{
	var SNo= document.getElementById(id).value;
	var SNo=SNo.split('~');
	var cat= document.getElementById(id).options[document.getElementById(id).selectedIndex].title;
	if(SNo[0].trim()!="")
	{
		//alert(SNo);
		
		loadActCostDetails(SNo[0],0,SNo[1]);
		
		document.getElementById('copyActCost').style.visibility = "hidden";
		var sqlLO="SELECT o.intStyleId,o.strOrderNo FROM was_washpriceheader AS w INNER JOIN orders AS o ON o.intStyleId = w.intStyleId order by o.strOrderNo;";
	//alert(sqlLO);
		loadCombo(sqlLO,"cboOrderNo");
		document.getElementById('cboOrderNo').value=gbPo;
	}
	else
	{
		return false;
	}
}

function loadActCostDetails(id,v,cat)
{
	
	ClearForm();
	var control="cboCustomer";
	if(cat==0){
		var sql="select intCompanyID,strName from companies where intStatus=1 order by strName;";
		}
	else{
		var sql="select intCompanyID,strName from was_outside_companies where intStatus=1 order by strName;";
	
		}
	loadCombo(sql,control);
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = loadActCostDetailsRequest;
	var url  = "actualcostmiddle.php?RequestType=loadActDetails&serial="+id+"&cat="+cat;
	xmlHttp[0].index=v;
	xmlHttp[0].indexc=cat;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
	CloseWindow();
}
function loadActCostDetailsRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		
		var XMLStatus = xmlHttp[0].responseXML.getElementsByTagName("intStatus");
		//alert(xmlHttp[0].indexc);
		if(xmlHttp[0].indexc==0){document.frmmain.rdoCategory[0].checked=true;}
		if(xmlHttp[0].indexc==1){document.frmmain.rdoCategory[1].checked=true;}
		//alert(XMLStatus[0].childNodes[0].nodeValue == 1);
		if(XMLStatus[0].childNodes[0].nodeValue == 1)
		{
			document.getElementById('confirmIMG').style.display="none";
			document.getElementById('saveIMG').style.display="none";
			document.getElementById('reviseIMG').style.display="inline";
		}
		else
		{
			document.getElementById('reviseIMG').style.display="none";
			document.getElementById('confirmIMG').style.display="inline";
			document.getElementById('saveIMG').style.display="inline";
		}
		
		var XMLSampleNo = xmlHttp[0].responseXML.getElementsByTagName("intSerialNo");
		var XMLRevisionNo= xmlHttp[0].responseXML.getElementsByTagName("intRevisionNo");
		
		var serialNo=XMLSampleNo[0].childNodes[0].nodeValue;
		var revisionNo=XMLRevisionNo[0].childNodes[0].nodeValue;
		if(xmlHttp[0].index==1)
		{
			document.getElementById('txtSampleNo').value = serialNo;
			document.getElementById('txtRevNumber').value = revisionNo;
			CloseWindow();
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
			document.getElementById('reviseIMG').style.display="none";
			document.getElementById('confirmIMG').style.display="inline";
			document.getElementById('saveIMG').style.display="inline";
		}
		
		var XMLStyle = xmlHttp[0].responseXML.getElementsByTagName("strStyle");
		var XMLStyleId = xmlHttp[0].responseXML.getElementsByTagName("intStyleId");
		document.getElementById("cboStyleId").innerHTML="<option>Select One</option>";
		if(xmlHttp[0].index==0){
			var sqlLC="select o.strStyle,o.strStyle from was_washpriceheader  w INNER JOIN orders o on o.intStyleId=w.intStyleId where o.strStyle <> '"+ XMLStyle[0].childNodes[0].nodeValue +"';";
			//alert(sqlLC);
			loadCombo(sqlLC,'cboStyleId');
		}
		if(XMLStyle.length>0){
			var opt = document.createElement("option");
			opt.value = XMLStyle[0].childNodes[0].nodeValue;	
			opt.text = XMLStyle[0].childNodes[0].nodeValue;	
			document.getElementById("cboStyleId").options.add(opt);
		}
		document.getElementById('cboStyleId').value = XMLStyle[0].childNodes[0].nodeValue;
		
		var XMLFabricName = xmlHttp[0].responseXML.getElementsByTagName("intMatDetailId");
		
		LoadMainFabAndMill(XMLStyleId[0].childNodes[0].nodeValue,xmlHttp[0].indexc);//load facric details
		document.getElementById('cboMainFabric').value = XMLFabricName[0].childNodes[0].nodeValue;

		LoadOrderNo(XMLStyleId[0].childNodes[0].nodeValue,xmlHttp[0].indexc);
		document.getElementById("cboOrderNo").value=XMLStyleId[0].childNodes[0].nodeValue;
		
		LoadWashPriceDetails(XMLStyle[0].childNodes[0].nodeValue,xmlHttp[0].indexc);
		
		var XMCustomer = xmlHttp[0].responseXML.getElementsByTagName("intCustomerId");
		document.getElementById('cboCustomer').value= XMCustomer[0].childNodes[0].nodeValue;
		
		LoadBranch(XMCustomer[0].childNodes[0].nodeValue,xmlHttp[0].indexc);
		
		var XMLDivision = xmlHttp[0].responseXML.getElementsByTagName("intDivisionId");
		document.getElementById('cboDivision').value = XMLDivision[0].childNodes[0].nodeValue;	
		
		
		
		var XMLWashType= xmlHttp[0].responseXML.getElementsByTagName("intWashType");
		document.getElementById('cboWashType').value = XMLWashType[0].childNodes[0].nodeValue;
		
		LoadWashPriceDetails(document.getElementById('cboOrderNo'),xmlHttp[0].indexc)
		
		var XMLColor = xmlHttp[0].responseXML.getElementsByTagName("strColor");
		/*if(XMLColor.length>0){
			var opt = document.createElement("option");
			opt.value = XMLColor[0].childNodes[0].nodeValue;	
			opt.text = XMLColor[0].childNodes[0].nodeValue;	
			document.getElementById("cboColor").options.add(opt);
		}*/
		//alert(XMLColor[0].childNodes[0].nodeValue);
		document.getElementById('cboColor').value = XMLColor[0].childNodes[0].nodeValue;	
		
		var XMLGarment= xmlHttp[0].responseXML.getElementsByTagName("intGarmentId");
		
		document.getElementById('cboGarmentType').value = XMLGarment[0].childNodes[0].nodeValue;
		
		var XMLMachine= xmlHttp[0].responseXML.getElementsByTagName("cboMachine");
		document.getElementById('cboMachineType').value = XMLMachine[0].childNodes[0].nodeValue;
			
		var XMLNoOfPcs= xmlHttp[0].responseXML.getElementsByTagName("dblQty");
		document.getElementById('txtNoOfPcs').value = XMLNoOfPcs[0].childNodes[0].nodeValue;
		
		var XMLWeight= xmlHttp[0].responseXML.getElementsByTagName("dblWeight");
		document.getElementById('txtWeight').value = XMLWeight[0].childNodes[0].nodeValue;
		
		var XMLTimeHandling= xmlHttp[0].responseXML.getElementsByTagName("dblHTime");
		document.getElementById('txtTotHTime').value = XMLTimeHandling[0].childNodes[0].nodeValue;
		
		var XMLRowOder = xmlHttp[0].responseXML.getElementsByTagName("intRowOder");
		var XMLProcessName = xmlHttp[0].responseXML.getElementsByTagName("strProcessName");
		var XMLTemp = xmlHttp[0].responseXML.getElementsByTagName("dblTemp");
		var XMLPHValue = xmlHttp[0].responseXML.getElementsByTagName("PHValue");
		var XMLiqour = xmlHttp[0].responseXML.getElementsByTagName("dblLiqour");
		var XMLTime = xmlHttp[0].responseXML.getElementsByTagName("dblTime");
		var XMLProcessId = xmlHttp[0].responseXML.getElementsByTagName("intProcessId");

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
			htm="<td class=\""+cls+"\" style=\"cursor:pointer;text-align:right;\" >";
			htm+="<img src=\"../../images/del.png\" onclick=\"removeRow(this);\"/></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+XMLRowOder[i].childNodes[0].nodeValue+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+XMLProcessName[i].childNodes[0].nodeValue+"</td>";
			htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;\" class=\""+cls+"\"><input type=\"text\" value=\""+XMLiqour[i].childNodes[0].nodeValue+"\" style=\"width:100px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td id='"+XMLRowOder[i].childNodes[0].nodeValue+"' style=\"cursor:pointer;text-align:center;\" class=\""+cls+"\"><input type=\"text\" value=\""+XMLTemp[i].childNodes[0].nodeValue+"\" style=\"width:80px;text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td class=\""+cls+"\"><input type=\"text\" value=\""+XMLTime[i].childNodes[0].nodeValue+"\" style=\"width:80px;text-align:right;\"onkeypress=\"return CheckforValidDecimal(this.value,1,event)\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/></td>";
			htm+="<td class=\""+cls+"\" id=\""+XMLRowOder[i].childNodes[0].nodeValue+"\" style=\"cursor:pointer;\">";
			htm+="<select style=\"width:75px;\" id=\"cboChmID"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"left\">";
			htm+="<option></option>"
			htm+="</select>";
			htm+="<img src=\"../../images/add.png\"onclick=\"loadchemicals(this.id,"+XMLProcessId[i].childNodes[0].nodeValue+");\" id=\"img"+XMLRowOder[i].childNodes[0].nodeValue+"\" align=\"right\"/>";
			htm+="</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+XMLProcessId[i].childNodes[0].nodeValue+"</td>";
			htm+="<td class=\""+cls+"\"><input type=\"text\" value=\""+XMLPHValue[i].childNodes[0].nodeValue+"\" style=\"width:50px;text-align:right;\" maxlength=\"10\"></td>";
			row.innerHTML =htm;	
		}
		var XMLChemicalId = xmlHttp[0].responseXML.getElementsByTagName("intChemicalId");

		loadActChemicals(serialNo);
	}
}
function loadActChemicals(sno)
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
		var url="actualcostdb.php?req=loadChemicals&sNo="+sno+"&rId="+rowId[i]+"&pId="+prcID[i]+"";
		createXMLHttpRequest(i);
		xmlHttp[i].onreadystatechange = loadChemicalReq;
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
		tbl.rows[this.index].cells[6].childNodes[0].innerHTML = xmlHttp[this.index].responseText;
	}
}

function ViewReportPopUp()
{
	document.frmmain.radioReports[0].checked == false;
	document.frmmain.radioReports[1].checked == false;
	if(document.getElementById('reportsPopUp').style.visibility == "hidden")
	{
		document.getElementById('reportsPopUp').style.visibility = "visible";
	}
	else
	{
		document.getElementById('reportsPopUp').style.visibility = "hidden";
	}
}

function washReport(l,obj,r){ 
//alert(l);
	if(l==0){
	var po_location=(document.getElementById('rdoInHouse2').checked==true?'inhouse':'outside')
	var sNO = document.getElementById('txtSampleNo').value;
 if(document.frmmain.radioReports[0].checked == true){
	 if(document.getElementById('txtSampleNo').value != ""){
	    
		window.open("washingFormula.php?q="+sNO+'&po_location='+po_location,'new1' ); 
		document.getElementById('reportsPopUp').style.visibility = "hidden";
	 }
	 else
	 {
		 alert("Please Select a Sample No");
	 }
 }else{
	 if(document.getElementById('txtSampleNo').value != ""){
		 window.open("chemicalCostSheet.php?q="+sNO+'&po_location='+po_location,'new2' );
		 document.getElementById('reportsPopUp').style.visibility = "hidden";
	 }else{
	   alert("Please Select a Sample No");	 
	 }
 }
	}
	else{
		var sNO=obj.parentNode.parentNode.cells[0].innerHTML;
		var loc=obj.parentNode.parentNode.cells[1].innerHTML;
		
		var po_location=(loc=='In House'?'inhouse':'outside')
		if(r==0)
		window.open("washingFormula.php?q="+sNO+'&po_location='+po_location,'new1' ); 
		else
		window.open("chemicalCostSheet.php?q="+sNO+'&po_location='+po_location,'new2' );
	}
}

function loadCopyActCost()
{
	
	if(document.getElementById('copyActCost').style.visibility == "hidden")
	{
		//document.getElementById('frmmain').reset();
		document.getElementById('copyActCost').style.visibility = "visible";
		var sql="SELECT concat(intSerialNo,'~',intCat) as val ,intSerialNo FROM was_actualcostheader order by intSerialNo;";
	var control="cboCopyActCost";
	loadCombo(sql,control);
	}
	else
	{
		document.getElementById('copyActCost').style.visibility = "hidden";
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

function confrimActualCost()
{
	var sNo=document.getElementById('txtSampleNo').value;
	if(sNo.trim()=="")
	{
		alert("Enter Serial Number.");
		return false;
	}
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = confirmActCostRequest;
	var url="actualcostdb.php?req=confirmActCost&";
	url += "sNo="+sNo;

	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
}

function confirmActCostRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var res= xmlHttp[0].responseText
		if(res==1)
		alert("Confirm successfully.");
		document.getElementById('confirmIMG').style.display="none";
		document.getElementById('saveIMG').style.display="none";
		document.getElementById('reviseIMG').style.display="inline";
		return false;
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
	var url="actualcostdb.php?req=reviseSample&reason="+revReason;
	url += "&sNo="+sNo;

	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);
	
}
function reviseRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
	{
		var res= xmlHttp[0].responseText.split('~');
		if(res[0]==1)
		alert("Revised successfully.");
		document.getElementById('confirmIMG').style.display="inline";
		document.getElementById('saveIMG').style.display="inline";
		document.getElementById('revReason').style.visibility="hidden";
		document.getElementById('reviseIMG').style.display="none";
		document.getElementById('txtRevNumber').value=res[1];
		return false;
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
	setColors(tblMain,rowCount);
}

function setColors(tblMain,rowCount){
	for(var i=1;i<rowCount;i++){
		var cls;
		(i%2==0)?cls="grid_raw":cls="grid_raw2";
		for(var c=0;c<9;c++){
			tblMain.rows[i].cells[c].className=cls;
		}
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
function ChangeCat(obj)
{
	pub_category = obj;
}

function SearchPreCosting()
{
	var tbl = (pub_category=='0'?'tblPreOder':'tblConfirm');
	var url  = 'actualcostmiddle.php?RequestType=SearchPreCosting'; 
	    url += '&Type='+document.getElementById('cboSType').value;
		url += '&Text='+document.getElementById('txtStype').value;
		url += '&CatId='+pub_category;
		url += '&InOrOut='+document.getElementById('cboPCCat').value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById(tbl).innerHTML=htmlobj.responseText;
}

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

function LoadStyleWiseOrderNo(obj)
{	
	if(obj==""){
			document.getElementById('cboOrderNo').onchange();
	}
	
	var cat=0;
		if(document.frmmain.rdoCategory[0].checked==true){cat="0"}
		if(document.frmmain.rdoCategory[1].checked==true){cat="1"}
		
	var url = "actualcostmiddle.php?RequestType=LoadStyleWiseOrderNo&StyleNo="+URLEncode(obj)+"&cat="+cat;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
	
}

//BEGIN - Search Process
function searchProcess(obj,e)
{
	if(e.keyCode!=13)
		return;
	var url="actualcostmiddle.php?RequestType=SearchProcesses&id="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('mytable').innerHTML=htmlobj.responseText;
}
//BEGIN - Search Chemicals
function SearchChemical(obj,e,pid)
{
	if(e.keyCode!=13)
		return;
	
	var url="actualcostmiddle.php?RequestType=SearchChemical&id="+URLEncode(obj.value)+"&pid="+pid;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('tblChm').innerHTML=htmlobj.responseText;
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

function checkfirstDecimal(obj){
	var d=obj.value.trim().charAt(0);	
	if(d=='.')
		if(obj.value.length>1)
			obj.value='0'+obj.value;		
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