//Java Script
//
function loadExistingData()
{
	var path  = "existingData.php";
	htmlobj=$.ajax({url:path,async:false});
	drawPopupAreaLayer(300,270,'frmExistingData',1);
	var HTMLText=htmlobj.responseText
	document.getElementById('frmExistingData').innerHTML=HTMLText;	
	//encodeURIComponent();
	//encodeURI();
}

function ClearForm(obj)
{
	if(obj=="new")
	{
		document.getElementById('issuedWash_cboFactory').value='';
		document.getElementById('issuedWash_cboFactory').disabled=false;
		/*document.getElementById('issuedWash_cboFactory').onchange();*/
		document.getElementById('issuedWash_txtSerialNo').value='';
		//document.getElementById('issuedWash_cboStyle').innerHTML="<option value=''>Select One</option>";
		document.getElementById('issuedWash_cboStyle').value="";
		document.getElementById('issuedWash_cboStyle').disabled=false;
		//document.getElementById('issuedWash_cboPoNo').innerHTML="<option value=''>Select One</option>";
		document.getElementById('issuedWash_cboPoNo').value="";
		document.getElementById('issuedWash_cboPoNo').disabled=false;
		document.getElementById('issuedWash_cboPoNo').onchange();
		document.getElementById('issuedWash_cboColor').innerHTML="<option></option>";
		document.getElementById('issuedWash_cboColor').disabled=false;
		document.getElementById('issuedWash_txtAVLQty').value='';
		document.getElementById('issuedWash_txtIssueQty').value='';
		document.getElementById('issuedWash_txtIssueQty').disabled=false;
		document.getElementById('issuedWash_txtBalQty').value='';
		/*document.getElementById('issuedWash_txtOderQty').value='';*/
		document.getElementById('imgSave').style.display='inline';
		document.getElementById('imgConfirm').style.display='none';
		document.getElementById('issuedWash_cboFactory').innerHTML="<option></option>";
		document.getElementById('frmIssuedWash').reset();
	}
	/*var tbl=document.getElementById('tblIssueWashGrid').tBodies[0];
	var rCount = tbl.rows.length;
	for(var loop=0;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}*/
}


function loadStyles()
{
	var conId=document.getElementById('issuedWash_cboFactory').value.trim();
	if(conId=="")
	{
		ClearForm('new');
		document.getElementById("issuedWash_cboStyle").value="";
		document.getElementById("issuedWash_cboPoNo").value="";
		return false;
	}
	
	var path  = "issuedWash_xml.php?req=loadStyle&comId="+conId;
	htmlobj=$.ajax({url:path,async:false});
	$("#issuedWash_cboStyle").html(htmlobj.responseXML.getElementsByTagName("styleNo")[0].childNodes[0].nodeValue);
	$("#issuedWash_cboPoNo").html(htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue);
	
}
function loadPO(sNo)
{
	var sId=document.getElementById('issuedWash_cboStyle').value.trim();
	document.getElementById("issuedWash_cboPoNo").value=sId;
	document.getElementById("issuedWash_cboPoNo").onchange();
	/*if(sId=="")
	{
		document.getElementById("issuedWash_cboPoNo").value="";
		document.getElementById("issuedWash_cboStyle").focus();
		return false;
	}*/
	
	/*var styleName = $("#issuedWash_cboStyle option:selected").text()
	var path  = "issuedWash_xml.php?req=loadPO&sId="+sId;
	path +="&styleName="+URLEncode(styleName);
	htmlobj=$.ajax({url:path,async:false});*/
	
	//$("#issuedWash_cboPoNo").html(htmlobj.responseXML.getElementsByTagName("orderNo")[0].childNodes[0].nodeValue);
	
}

function saveIssuedWash()
{
	var serial=document.getElementById('issuedWash_txtSerialNo').value.trim();
	var issueDate=document.getElementById('issuedWash_txtDate').value.trim();
	var styleNo=document.getElementById('issuedWash_cboStyle').value.trim();
	var poNo=document.getElementById('issuedWash_cboPoNo').value.trim();
	var color	=	document.getElementById('issuedWash_cboColor').value.trim();
	var iQty	=	document.getElementById('issuedWash_txtIssueQty').value.trim();
	
	var fromComId = $("#issuedWash_cboFactory").val();
	
	if(document.getElementById('issuedWash_cboFactory').value.trim()=="")
	{
		alert("Select 'Factory'.");
		document.getElementById('issuedWash_cboFactory').focus();
		return false;
	}
	/*if(styleNo=="")
	{
		alert("Select \"Style\".");
		document.getElementById('issuedWash_cboStyle').focus();
		return false;
	}*/
	if(poNo==""){
		alert("Please select 'PO No'.");
		document.getElementById('issuedWash_cboPoNo').focus();
		return false;
	}
	if(issueDate=="")
	{
		alert("Please select 'Date'.");
		document.getElementById('issuedWash_txtDate').focus();
		return false;
	}
	if(color==""){
		alert("Please select 'Color'.");
		document.getElementById('issuedWash_cboColor').focus();
		return false;
	}
	if(iQty==""){
		alert("Please enter 'Issue Qty'.");
		document.getElementById('issuedWash_txtIssueQty').focus();
		return false;
	}
	else if(Number(iQty) == 0){
		alert("'Issue Qty' should be greater than '0'.");
		document.getElementById('issuedWash_txtIssueQty').focus();
		return false;
	}
	//if(gridValidation()){
		var path  = "issuedWash_db.php?req=";
	
		if(serial=="")
		{
			path+="saveHeader&";
		}
		else
		{
			path+="updateHeader&serial="+serial+"&";
		}
		path+="issueDate="+issueDate+"&poNo="+poNo;
		path +="&fromComID="+fromComId+"&color="+color+"&iQty="+iQty;
		//alert(path);
		htmlobj=$.ajax({url:path,async:false});
		var res=htmlobj.responseText.split('~');
	//alert(res);
		if(res[0]==1)
		{
			if(saveDetails(res[1],color,iQty,fromComId,styleNo))
			{
				alert("Saved successfully.");
				//ClearForm('new');
				document.getElementById('issuedWash_txtSerialNo').value=res[1];
				document.getElementById('imgSave').style.display="none"
				document.getElementById('imgConfirm').style.display="inline";
				return false;
			}
		}
		else if(res[0]==2)
		{
			if(saveDetails(res[1],color,iQty,fromComId,styleNo))
			{
			alert("Updated successfully.");
			document.getElementById('imgSave').style.display="none"
			document.getElementById('imgConfirm').style.display="inline";
			//ClearForm('new');
			return false;
			}
		}
		/*if(res[0]==1){
			;
			
		}
		else if(res[0]==2){	
			
		}
		else{
			alert("Header saving error.");
			return false;
		}*/
	//}
}

function showReport(){
	if(document.getElementById('issuedWash_txtSerialNo').value.trim()==""){
		alert("Please enter 'Issued No'.");	
		return false;
	}
	window.open('issueToWashReport.php?q='+document.getElementById('issuedWash_txtSerialNo').value.trim(),'Issued to Wash');	
}
function gridValidation(){
	var tblMain=document.getElementById('tblIssueWashGrid').tBodies[0];
	var rowCount = tblMain.rows.length;
	
	for(var i=0;i<rowCount;i++)
	{
		var issueQty = parseFloat(tblMain.rows[i].cells[5].childNodes[0].value.trim());
		var iQty=(isNaN(issueQty) == true ?0:issueQty);
		
		if(iQty =="" || iQty ==0){
			
				alert("Fill \"Issue Qty\".");
				tblMain.rows[i].cells[5].childNodes[0].focus();
				return false;
		}
		
	}
	
	return true;
}

function saveDetails(sNo,color,iQty,fromComId,styleNo)
{
	//var tblMain=document.getElementById('tblIssueWashGrid').tBodies[0];
	var issueDate=document.getElementById('issuedWash_txtDate').value.trim();
	//var rowCount = tblMain.rows.length;

	/*for(var i=0;i<rowCount;i++)
	{*/
		var color=color;//.replace('#','~');+"&tag="+i
	//	var size=0;&size="+URLEncode(size)+"
		var iQty=parseFloat(iQty);	
		
		var path ="";
			path  = "issuedWash_db.php?req=saveDetails&serial="+sNo;
			path+="&color="+URLEncode(color)+"&iQty="+iQty+"&issueDate="+issueDate+"&fromComId="+fromComId+"&styleNo="+styleNo;
			htmlobj=$.ajax({url:path,async:false});
			
			var res=htmlobj.responseText;
			if(res=='0')
			{
				alert("Saving error");
				return false;
			}
		
	//}
	return true;
}
function loadCompany(obj){
	if(obj.value==""){
		 //ClearForm('new')
		return false;
	}
	var path  = "issuedWash_xml.php?req=loadCompany&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLNr=htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany=htmlobj.responseXML.getElementsByTagName("cName");
	
	if(XMLNr.length>0){
		//alert(XMLNr[0].childNodes[0].nodeValue)
		if(XMLNr[0].childNodes[0].nodeValue==1){
			document.getElementById('issuedWash_cboFactory').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById('issuedWash_cboFactory').disabled=true;
			loadColor(obj);
		}
		else{
			document.getElementById('issuedWash_cboFactory').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			alert("Please select the 'Sewing Factory'.");
			document.getElementById('issuedWash_cboFactory').disabled=false
			return false;
		}
	}
	
}

function loadColor(obj){
	document.getElementById('issuedWash_cboStyle').value=obj.value;
	var path  = "issuedWash_xml.php?req=loadColor&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor=htmlobj.responseXML.getElementsByTagName("Color");
	document.getElementById('issuedWash_cboColor').innerHTML="";
	/*document.getElementById('issuedWash_cboColor').innerHTML=XMLColor[0].childNodes[0].nodeValue*/
	for(var i=0;i<XMLColor.length;i++){
		$('#issuedWash_cboColor').append("<option value=\""+XMLColor[i].childNodes[0].nodeValue+"\">"+XMLColor[i].childNodes[0].nodeValue+"</option>");
		
	}
	//loadDetails(obj)
	loadQty(obj);
}

function loadQty(obj){

	var color=document.getElementById('issuedWash_cboColor').value.trim();	
	var path  = "issuedWash_xml.php?req=loadQty&orderNo="+obj.value.trim()+"&color="+URLEncode(color)+"&fFac="+document.getElementById('issuedWash_cboFactory').value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLRCVDQty=htmlobj.responseXML.getElementsByTagName('RCVDQty');
	var XMLORDERQty=htmlobj.responseXML.getElementsByTagName('ORDERQty');
	var XMLIQty=htmlobj.responseXML.getElementsByTagName('IQty');
	var XMLIssuedQty=htmlobj.responseXML.getElementsByTagName('IssuedQty');
	
	document.getElementById('issuedWash_txtRecvQty').value=XMLRCVDQty[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_txtOderQty').value=XMLORDERQty[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_txtAVLQty').value=XMLIQty[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_txtIssueQty').value=XMLIQty[0].childNodes[0].nodeValue;
	
	document.getElementById('issuedWash_txtIssuedQty').value=XMLIssuedQty[0].childNodes[0].nodeValue;
}

function loadDataToEdit(iNo,iYear){
	if(iNo==0 || iYear==0){ return false;}
	var path="issuedWash_xml.php?req=loadDet&iNo="+iNo+"&iYear="+iYear;
	htmlobj=$.ajax({url:path,async:false});
	var XMLFComCode=htmlobj.responseXML.getElementsByTagName('FComCode');
	var XMLPONo=htmlobj.responseXML.getElementsByTagName('PONo');
	var XMLColor=htmlobj.responseXML.getElementsByTagName('Color');
	var XMLQty=htmlobj.responseXML.getElementsByTagName('Qty');
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('Style');
	var XMLStatus=htmlobj.responseXML.getElementsByTagName('Status');
	
	document.getElementById('issuedWash_txtSerialNo').value=iYear+"/"+iNo;
	document.getElementById('issuedWash_cboFactory').value=XMLFComCode[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_cboFactory').onchange();
	document.getElementById('issuedWash_cboFactory').disabled="disabled";
	document.getElementById('issuedWash_cboPoNo').value=XMLPONo[0].childNodes[0].nodeValue;
	//alert(XMLPONo[0].childNodes[0].nodeValue);
	document.getElementById('issuedWash_cboPoNo').onchange();
	document.getElementById('issuedWash_cboPoNo').disabled="disabled";
	document.getElementById('issuedWash_cboStyle').value=XMLStyle[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_cboStyle').disabled="disabled";
	document.getElementById('issuedWash_cboColor').value=XMLColor[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_cboColor').disabled="disabled";
	document.getElementById('issuedWash_txtAVLQty').value=parseFloat(document.getElementById('issuedWash_txtAVLQty').value)+parseFloat(XMLQty[0].childNodes[0].nodeValue);
	document.getElementById('issuedWash_txtIssueQty').value=XMLQty[0].childNodes[0].nodeValue;
	document.getElementById('issuedWash_txtIssueQty').onkeyup();
	if(XMLStatus[0].childNodes[0].nodeValue==1){
		document.getElementById('issuedWash_txtIssueQty').readOnly=true; 
		document.getElementById('imgSave').style.display='none'; 
	}

}

function setBalance(obj){
	var avlQty=document.getElementById('issuedWash_txtAVLQty').value.trim();
		if(Number(avlQty) < Number(obj.value.trim())){
			obj.value=0;
		}
}
//Load color wise PO Details
function loadDetails(obj)
{
	var path  = "issuedWash_xml.php?req=loadGrid&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor	=htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLSize	=htmlobj.responseXML.getElementsByTagName("strSize");
	var XMLTQTY	=htmlobj.responseXML.getElementsByTagName("TQTY");
	var XMLQTY	=htmlobj.responseXML.getElementsByTagName("QTY");
	ClearForm('a');
	var tblMain=document.getElementById('tblIssueWashGrid').tBodies[0];
	for(var i=0;i<XMLColor.length;i++){
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		row.className="";
		var color=XMLColor[i].childNodes[0].nodeValue;
		var size=XMLSize[i].childNodes[0].nodeValue;
		var qty	=XMLQTY[i].childNodes[0].nodeValue;
		var tQty=XMLTQTY[i].childNodes[0].nodeValue;
		var cls;
		(i%2==2)?cls="grid_raw":cls="grid_raw2";
		var htm="";
			htm="<td class=\""+cls+"\" style=\"cursor:pointer;\" width=\"10\" ><img src=\"../../images/del.png\" id=\""+1+"\" onclick=\"removeRow(this);\" /></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\" >"+color+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+size+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+tQty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+qty+"</td>";
			htm+="<td class=\""+cls+"\" ><input type=\"text\" width=\"30\" class=\"txtbox\"/ onkeypress=\"return CheckforValidDecimal(this.value,0,event);\"onkeyup=\"setBalance(this);\" style=\"text-align:right;\" ></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\"></td>";
			row.innerHTML =htm;	
	}
	
	//get Order Qty
	
	var url = "issuedWash_xml.php?req=getOrderQty&orderNo="+obj.value.trim();
	htmlobj=$.ajax({url:url,async:false});
	$("#issuedWash_txtOderQty").val(htmlobj.responseXML.getElementsByTagName("orderQty")[0].childNodes[0].nodeValue);
}
// Load Existing Details

function loadIssuedDetails(id)
{
	document.getElementById('issuedWash_txtSerialNo').value=id;
	var path  = "issuedWash_xml.php?req=loadData&serial="+id;
	htmlobj=$.ajax({url:path,async:false});
	var XMLFactory	=htmlobj.responseXML.getElementsByTagName("intCompanyID");
	document.getElementById('issuedWash_cboFactory').value=XMLFactory[0].childNodes[0].nodeValue;
	var XMLDate	=htmlobj.responseXML.getElementsByTagName("dtmIssueDate");
	document.getElementById('issuedWash_txtDate').value=XMLDate[0].childNodes[0].nodeValue;
	var XMLStyleNo	=htmlobj.responseXML.getElementsByTagName("intStyleNo");
	var XMLStyle	=htmlobj.responseXML.getElementsByTagName("strStyle");
	document.getElementById("issuedWash_cboStyle").innerHTML="";
	var opt = document.createElement("option");
			opt.value = XMLStyle[0].childNodes[0].nodeValue;
			opt.text = XMLStyle[0].childNodes[0].nodeValue;	
			document.getElementById("issuedWash_cboStyle").options.add(opt);
	var XMLOrderNo	=htmlobj.responseXML.getElementsByTagName("strOrderNo");
	document.getElementById("issuedWash_cboPoNo").innerHTML="";	
	var opt = document.createElement("option");
			opt.value = XMLStyleNo[0].childNodes[0].nodeValue;
			opt.text = XMLOrderNo[0].childNodes[0].nodeValue;	
			document.getElementById("issuedWash_cboPoNo").options.add(opt);
	var XMLQty	=htmlobj.responseXML.getElementsByTagName("intQty");
	document.getElementById("issuedWash_txtOderQty").value=XMLQty[0].childNodes[0].nodeValue;
	
	var styleNo=XMLStyleNo[0].childNodes[0].nodeValue;;
	var path  = "issuedWash_xml.php?req=fillGrid&styleNo="+styleNo+"&serial="+id;
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor	=htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLSize	=htmlobj.responseXML.getElementsByTagName("strSize");
	var XMLQTY	=htmlobj.responseXML.getElementsByTagName("QTY");
	var XMLIssueQty = htmlobj.responseXML.getElementsByTagName("dblIssueQty");
	
	ClearForm('a');
	var tblMain=document.getElementById('tblIssueWashGrid').tBodies[0];
	for(var i=0;i<XMLIssueQty.length;i++){
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		row.className="";
		var color=XMLColor[i].childNodes[0].nodeValue;
		var size=XMLSize[i].childNodes[0].nodeValue;
		var qty	=XMLQTY[i].childNodes[0].nodeValue;
		var issueQty=0;
		//alert(i)
		if(XMLIssueQty.length > 0){
			issueQty=XMLIssueQty[i].childNodes[0].nodeValue;
		}
		var balance=qty-issueQty;
		(balance<0)?balance=0:balance=balance;
		var cls;
		(i%2==2)?cls="grid_raw":cls="grid_raw2";
		var htm="";
			htm="<td class=\""+cls+"\" style=\"cursor:pointer;\" width=\"10\" ><img src=\"../../images/del.png\" id=\""+1+"\" onclick=\"removeRow(this);\" /></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\" >"+color+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+size+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+(parseFloat(qty)+parseFloat(issueQty))+"</td>";
			htm+="<td class=\""+cls+"\" ><input type=\"text\" width=\"50\" class=\"txtbox\"/ onkeypress=\"return CheckforValidDecimal(this.value,0,event);\"onkeyup=\"setBalance(this);\" value=\""+parseFloat(issueQty)+"\" style=\"text-align:right;\"></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+(parseFloat(qty))+"</td>";//(parseFloat(balance) + parseFloat(issueQty))
			row.innerHTML =htm;	
	}
}
// Set the Balance QTY
/*function setBalance(obj)
{
	var tblMain=document.getElementById('tblIssueWashGrid').tBodies[0];
	var td=obj.parentNode;
	var cell3=parseFloat(td.parentNode.cells[4].innerHTML);
	var cell4=parseFloat(td.parentNode.cells[5].childNodes[0].value);
	var bal = cell3-cell4;
	/*if(td.parentNode.cells[4].childNodes[0].value=="")
	{
		td.parentNode.cells[5].childNodes[0].value="";
	}
	if(parseInt(cell3)+1 > parseInt(cell4))
	{
		td.parentNode.cells[5].innerHTML="";
		td.parentNode.cells[5].innerHTML=cell3-cell4;
	}
	else
	{
		var myStr = cell4;
		var strLen = myStr.length;
		td.parentNode.cells[4].childNodes[0].value=myStr = myStr.slice(0,strLen-1);
		//alert("Issued qty not exceed to Recieve qty.");
	}
	
	if(cell4>cell3)
	{
		td.parentNode.cells[5].childNodes[0].value = cell3;
		td.parentNode.cells[6].innerHTML=0;	
	}
	else
	{
		var balQty = (isNaN(cell4) == true ?cell3:bal);
	td.parentNode.cells[6].innerHTML=balQty;
	}
	
}*/
//Close PopUp
function CloseWindow()
{
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
//Remove Rows
function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo-1);
}

function confirmReport(iYear,iNo){
	
	if(confirm("Are you sure, you want to confirm?")){
	var path="../issuedWash/issuedWash_db.php?req=confirmRecord&iNo="+iNo+"&iYear="+iYear;
	htmlobj=$.ajax({url:path,async:false});
		if(htmlobj.responseText==1){
			alert("Issue No:"+iYear+"/"+iNo+" is successfully confirmed.");	
			document.getElementById('imgConfirm').style.visibility='hidden';
			return false;
		}
	}
	else{
		return false;
	}
}

function showTodayReport(){
	window.open('rpttodayReceive.php?factory='+document.getElementById('todayWash_cboFactory').value.trim()+'&date='+document.getElementById('todayWash_txtDate').value.trim()+'&dateTo='+document.getElementById('todayWash_txtDateTo').value.trim()+'&po='+document.getElementById('todayWash_cboPo').value.trim(),'Today Receive');	
}

function clearF(){
	document.getElementById('todayWash_cboFactory').value="";	
	document.getElementById('todayWash_txtDate').value="";
	document.getElementById('todayWash_txtDateTo').value="";
	document.getElementById('todayWash_cboPo').value="";
	ocument.getElementById('todayWash_cboPo').onchange();
	
}

function setStyle(con1,con2){
	document.getElementById(con2).value=document.getElementById(con1).value;
}