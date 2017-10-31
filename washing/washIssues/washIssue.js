//Java Script
//
var xmlHttp = [];

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

function ClearForm()
{
	document.getElementById('washIssue_txtIssueNo').value="";
	document.getElementById('washIssue_cboPoNo').value="";
	document.getElementById('washIssue_txtColor').innerHTML="<option value=\"\">Select One</option>";
	document.getElementById('washIssue_txtDivision').value="";
	document.getElementById('washIssue_txtIssueNo').value="";
	document.getElementById('washIssue_txtFactory').value="";
	document.getElementById('washIssue_date').value="";
	document.getElementById('washIssue_txtStyle').value="";
	document.getElementById('washIssue_txtPoQty').value="";
	document.getElementById('washIssue_txtReceiveQty').value="";
	document.getElementById('washIssue_txtWashQty').value="";
	document.getElementById('washIssue_txtIssueQty').value="";

	
}
function clearGrid(){
	var tbl=document.getElementById('tblWashIssueGrid').tBodies[0];
	var rCount = tbl.rows.length;
	for(var loop=0;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}
}

function loadColors(sNo)
{
	if(sNo.trim()==""){
		
	}
	var path="washIssue_xml.php?req=selectColors&styId="+sNo;
	
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor	=htmlobj.responseXML.getElementsByTagName("strColor");
	document.getElementById("washIssue_txtColor").innerHTML="<option value=\"\"></option>";
	for(var i=0;i<XMLColor.length;i++)
	{
		var opt = document.createElement("option");
			opt.value = XMLColor[i].childNodes[0].nodeValue;
			opt.text = XMLColor[i].childNodes[0].nodeValue;	
			document.getElementById("washIssue_txtColor").options.add(opt);
	}
}
function loadData(sNo)
{
	var cat=0;
	if(document.frmWashIssues.washIssue_radioInorOut[0].checked==true){
		cat="0"
	}
	if(document.frmWashIssues.washIssue_radioInorOut[1].checked==true){
		cat='1';
	}
	var path="washIssue_xml.php?req=selectDet&styId="+document.getElementById('washIssue_cboPoNo').value.trim()+"&color="+URLEncode(document.getElementById('washIssue_txtColor').value.trim())+"&cat="+cat;
	
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLTag	=htmlobj.responseXML.getElementsByTagName("strTag");
	var XMLColor   = htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLDivision   = htmlobj.responseXML.getElementsByTagName("strDivision");
	var XMLFACName   = htmlobj.responseXML.getElementsByTagName("strName");
	var XMLStyle   = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLPOQTY   = htmlobj.responseXML.getElementsByTagName("POQTY");
	var XMLWQTY   = htmlobj.responseXML.getElementsByTagName("QTY");
	var XMLRCVDQty	= htmlobj.responseXML.getElementsByTagName("RCVDQty");
	var XMLCompanyID	= htmlobj.responseXML.getElementsByTagName("CompanyID");
	var XMLIssueQty	= htmlobj.responseXML.getElementsByTagName("IssueQty");
	var XMLTotQty	= htmlobj.responseXML.getElementsByTagName("TotQty");
	//alert(XMLTag[0].childNodes[0].nodeValue);
	if(XMLTag[0].childNodes[0].nodeValue==1)
	{
		document.getElementById("washIssue_txtDivision").value=XMLDivision[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtFactory").value=XMLFACName[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtStyle").value=XMLStyle[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtPoQty").value=XMLPOQTY[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtWashQty").value=XMLWQTY[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtReceiveQty").value=XMLRCVDQty[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_txtComId").value=XMLCompanyID[0].childNodes[0].nodeValue;
		document.getElementById("washIssue_hdnIssedQty").value=XMLIssueQty[0].childNodes[0].nodeValue;
		//document.getElementById("washIssue_hdnTotQty").value=XMLTotQty[0].childNodes[0].nodeValue;
	}
	else
	{
		document.getElementById("washIssue_txtIssueNo").value="";
		document.getElementById("washIssue_txtDivision").value="";
		document.getElementById("washIssue_txtFactory").value="";
		document.getElementById("washIssue_date").value="";
		document.getElementById("washIssue_txtStyle").value="";
		document.getElementById("washIssue_txtPoQty").value="";
		document.getElementById("washIssue_txtReceiveQty").value="";
		document.getElementById("washIssue_txtWashQty").value="";
		document.getElementById("washIssue_txtIssueQty").value="";
		document.getElementById("washIssue_txtComId").value="";
		document.getElementById("washIssue_hdnIssedQty").value="";
	}

}

function saveWashIssue()
{
	var issuedId=document.getElementById('washIssue_txtIssueNo').value.trim();
	var sNo=document.getElementById('washIssue_cboPoNo').value.trim();
	var dtmDate=document.getElementById('washIssue_date').value.trim();
	var Qty=document.getElementById('washIssue_txtPoQty').value.trim();
	var rQty=document.getElementById('washIssue_txtReceiveQty').value.trim();
	var wQty=document.getElementById('washIssue_txtWashQty').value.trim();
	var iQty=document.getElementById('washIssue_txtIssueQty').value.trim();
	var color=document.getElementById('washIssue_txtColor').value.trim();
	var factory=document.getElementById('washIssue_txtComId').value.trim();
	if(sNo.trim()==""){
		alert("Please select 'Order No'.");
		document.getElementById('washIssue_cboPoNo').focus();
		return false;
	}
	if(color.trim()==""){
		alert("Please select 'Color'.");
		document.getElementById('washIssue_txtColor').focus();
		return false;	
	}
	if(dtmDate.trim()==""){
		alert("Please enter 'Date'.");
		document.getElementById('washIssue_date').focus();
		document.getElementById('washIssue_date').onclick();
		return false;	
	}
	if(rQty.trim()==""){
		alert("Please enter 'Recieve Qty'.");
		document.getElementById('washIssue_txtReceiveQty').focus();
		return false;	
	}
	if(iQty.trim()==""){
		alert("Please enter 'Recieve Qty'.");
		document.getElementById('washIssue_txtIssueQty').focus();
		return false;	
	}
	
	var mode="0";
	if(document.frmWashIssues.washIssue_radioInorOut[0].checked==true){mode="0"}
	if(document.frmWashIssues.washIssue_radioInorOut[1].checked==true){mode="1"}
		
	var path="washIssue_db.php?req=";
	if(issuedId.trim()=="")
	{
		path+="saveDet";
	}
	else
	{
		path+="updateDet&issuedId="+issuedId;
	}
	path+="&styId="+sNo+"&dtmDate="+dtmDate+"&Qty="+Qty+"&rQty="+rQty+"&wQty="+wQty+"&iQty="+iQty+"&mode="+mode+"&color="+URLEncode(color)+"&factory="+factory;	
	
	htmlobj=$.ajax({url:path,async:false});
	var res=htmlobj.responseText.split('~');
	if(res[0]=="1")
	{
		document.getElementById('washIssue_txtIssueNo').value=res[1];
		alert("Saved successfully.");
		addRowToGrid(res[1]);
	}
	else if(res[0]=="2")
	{
		alert("Updated successfully.");
	}
	else if(res[0]=="3")
	{
		alert("No sufficient qty for issue,Available Qty"+res[1]+".");
	}
	else
	{
		alert("Header Saving Error.");
	}
}
function addRowToGrid(issuedId){
	
	var path="washIssue_xml.php?req=loadNewRow&issueId="+issuedId;
	htmlobj=$.ajax({url:path,async:false});
	var XMLIssueId 	=htmlobj.responseXML.getElementsByTagName("issueId");
	var XMLStyle   = htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLColor   = htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLDivision   = htmlobj.responseXML.getElementsByTagName("strDivision");
	var XMLFName   = htmlobj.responseXML.getElementsByTagName("strName");
	var XMLDate   = htmlobj.responseXML.getElementsByTagName("dtmDate");
	var XMLStyleName   = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLQty   = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLRQty   = htmlobj.responseXML.getElementsByTagName("dblRQty");
	var XMLWQty   = htmlobj.responseXML.getElementsByTagName("dblWQty");
	var XMLIQty   = htmlobj.responseXML.getElementsByTagName("dblIQty");
	var XMLMode   = htmlobj.responseXML.getElementsByTagName("intMode");
	var tblMain=document.getElementById('tblWashIssueGrid').tBodies[0];
	for(var i=0;i<XMLIssueId.length;i++)
	{
		var issueId=XMLIssueId[i].childNodes[0].nodeValue;
		var mode=value=XMLMode[i].childNodes[0].nodeValue;
		var styleId=XMLStyle[i].childNodes[0].nodeValue;
		var color=XMLColor[i].childNodes[0].nodeValue;
		var div=XMLDivision[i].childNodes[0].nodeValue;
		var factory=XMLFName[i].childNodes[0].nodeValue;
		var issuedDate=XMLDate[i].childNodes[0].nodeValue;
		var styleName=XMLStyleName[i].childNodes[0].nodeValue
		var Qty=XMLQty[i].childNodes[0].nodeValue;
		var RQty=XMLRQty[i].childNodes[0].nodeValue;
		var WQty=XMLWQty[i].childNodes[0].nodeValue;
		var IQty=XMLIQty[i].childNodes[0].nodeValue;
		var htm="";
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		var cls;
		(i%2==0)?cls="grid_raw":cls="grid_raw2";
		row.className="bcgcolor-tblrowWhite";
			htm="<td class=\""+cls+"\" style=\"cursor:pointer;\" ><img src=\"../../images/edit.png\" id=\""+issueId+"\" onclick=\"loadHeaderDet(this);\" /></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+issueId+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:center;\">"+mode+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+styleId+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+styleName+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+color+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+div+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+factory+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+issuedDate+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+Qty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+RQty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+WQty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+IQty+"</td>";
			row.innerHTML =htm;	
	}
	
}

function loadHeaderDet(obj)
{
	var IO = obj.parentNode.parentNode.cells[2].innerHTML;
	if(IO=="In"){
		cat=0;
	}
	else{
		cat=1;	
	}
	var path="washIssue_xml.php?req=loadDet&issueId="+obj.id+"&cat="+cat;
	
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLIssueId   = htmlobj.responseXML.getElementsByTagName("issueId");
	var XMLStyle   = htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLColor   = htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLDivision   = htmlobj.responseXML.getElementsByTagName("strDivision");
	var XMLFName   = htmlobj.responseXML.getElementsByTagName("strName");
	var XMLDate   = htmlobj.responseXML.getElementsByTagName("dtmDate");
	var XMLStyleName   = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLQty   = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLRQty   = htmlobj.responseXML.getElementsByTagName("dblRQty");
	var XMLWQty   = htmlobj.responseXML.getElementsByTagName("dblWQty");
	var XMLIQty   = htmlobj.responseXML.getElementsByTagName("dblIQty");
	var XMLMode   = htmlobj.responseXML.getElementsByTagName("intMode");
	var XMLTQty   =  htmlobj.responseXML.getElementsByTagName("TQty");
	
	document.getElementById('washIssue_txtIssueNo').value=XMLIssueId[0].childNodes[0].nodeValue;
	
	document.getElementById("washIssue_txtColor").innerHTML="<option value="+ XMLColor[0].childNodes[0].nodeValue +">"+XMLColor[0].childNodes[0].nodeValue+"</option>";
	document.getElementById("washIssue_txtDivision").value=XMLDivision[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_txtFactory").value=XMLFName[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_date").value=XMLDate[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_txtStyle").value=XMLStyleName[0].childNodes[0].nodeValue
	document.getElementById("washIssue_txtPoQty").value=XMLQty[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_txtReceiveQty").value=XMLRQty[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_txtWashQty").value=XMLWQty[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_txtIssueQty").value=XMLIQty[0].childNodes[0].nodeValue;
	document.getElementById("washIssue_hdnIssedQty").value=XMLIQty[0].childNodes[0].nodeValue; 
	document.getElementById("washIssue_hdnTotQty").value=XMLTQty[0].childNodes[0].nodeValue; 
	
	var mode=value=XMLMode[0].childNodes[0].nodeValue;
	var control="washIssue_cboPoNo";
	if(mode=="0")
	{
		document.frmWashIssues.washIssue_radioInorOut[0].checked=true;
		var sqls="SELECT distinct orders.intStyleId,orders.strOrderNo FROM orders INNER JOIN was_actualcostheader ON orders.intStyleId=was_actualcostheader.intStyleId WHERE was_actualcostheader.intStatus=1 ORDER BY orders.strStyle;";
		loadCombo(sqls,control);
		document.getElementById("washIssue_cboPoNo").value=XMLStyle[0].childNodes[0].nodeValue;
	}
	else
	{
		document.frmWashIssues.washIssue_radioInorOut[1].checked=true;
		var sqls="SELECT DISTINCT was_outsidepo.intId,was_outsidepo.intPONo FROM was_machineloadingheader AS ws Inner Join was_outsidepo ON was_outsidepo.intId = ws.intStyleId WHERE ws.intStatus =1 ORDER BY was_outsidepo.intPONo;";
		loadCombo(sqls,control);
		document.getElementById("washIssue_cboPoNo").value=XMLStyle[0].childNodes[0].nodeValue;
	}
	
}

function searchDetails()
{
	
	var issuedId=document.getElementById('washIssue_txtSearch').value;
	var dtmFrom=document.getElementById('washIssue_dateFrom').value;
	var dtmT0=document.getElementById('washIssue_dateOut').value;
	
	var path="washIssue_xml.php?req=loadSearchDet&issueId="+issuedId+"&dtmFrom="+dtmFrom+"&dtmT0="+dtmT0;
	htmlobj=$.ajax({url:path,async:false});
	var XMLIssueId 	=htmlobj.responseXML.getElementsByTagName("issueId");
	var XMLStyle   = htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLColor   = htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLDivision   = htmlobj.responseXML.getElementsByTagName("strDivision");
	var XMLFName   = htmlobj.responseXML.getElementsByTagName("strName");
	var XMLDate   = htmlobj.responseXML.getElementsByTagName("dtmDate");
	var XMLStyleName   = htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLQty   = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLRQty   = htmlobj.responseXML.getElementsByTagName("dblRQty");
	var XMLWQty   = htmlobj.responseXML.getElementsByTagName("dblWQty");
	var XMLIQty   = htmlobj.responseXML.getElementsByTagName("dblIQty");
	var XMLMode   = htmlobj.responseXML.getElementsByTagName("intMode");
	var tblMain=document.getElementById('tblWashIssueGrid').tBodies[0];
ClearForm();
clearGrid();
	for(var i=0;i<XMLIssueId.length;i++)
	{
		var issueId=XMLIssueId[i].childNodes[0].nodeValue;
		var mode=value=XMLMode[i].childNodes[0].nodeValue;
		var styleId=XMLStyle[i].childNodes[0].nodeValue;
		var color=XMLColor[i].childNodes[0].nodeValue;
		var div=XMLDivision[i].childNodes[0].nodeValue;
		var factory=XMLFName[i].childNodes[0].nodeValue;
		var issuedDate=XMLDate[i].childNodes[0].nodeValue;
		var styleName=XMLStyleName[i].childNodes[0].nodeValue
		var Qty=XMLQty[i].childNodes[0].nodeValue;
		var RQty=XMLRQty[i].childNodes[0].nodeValue;
		var WQty=XMLWQty[i].childNodes[0].nodeValue;
		var IQty=XMLIQty[i].childNodes[0].nodeValue;
		var htm="";
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		var cls;
		(i%2==0)?cls="grid_raw":cls="grid_raw2";
		row.className="bcgcolor-tblrowWhite";
			htm="<td class=\""+cls+"\" style=\"cursor:pointer;\" ><img src=\"../../images/edit.png\" id=\""+issueId+"\" onclick=\"loadHeaderDet(this);\" /></td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+issueId+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:center;\">"+mode+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+styleId+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+styleName+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+color+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+div+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:left;\">"+factory+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+issuedDate+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+Qty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+RQty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+WQty+"</td>";
			htm+="<td class=\""+cls+"\" style=\"text-align:right;\">"+IQty+"</td>";
			row.innerHTML =htm;	
	}
	
}

function printPoAvailable()
{
	var sNO = document.getElementById('washIssue_txtIssueNo').value;
	 if(sNO.trim() != ""){
	    
		window.open("storesWashIssueReport.php?q="+sNO,'new1' ); 
	 }
	 else
	 {
		 alert("Please Select a Issue No");
	 }
}

function checkAvlQty(obj){
	var IQty=document.getElementById('washIssue_hdnIssedQty').value.trim();
	var TQty=document.getElementById('washIssue_txtWashQty').value.trim();
	var chkQty=Number(TQty)-Number(IQty);
	var avl=0;
	if(document.getElementById('washIssue_txtIssueNo').value != ""){
		TQty=(TQty-(Number(document.getElementById('washIssue_hdnTotQty').value))+Number(IQty));
		chkQty=Number(TQty);
	}
		if(Number(TQty) < Number(obj.value.trim())){
			obj.value=chkQty;
			alert("Available 'Qty' is "+chkQty+".");
			return false;
		}else{
			if(Number(chkQty)<Number(obj.value.trim())){
				obj.value=chkQty;
				alert("Available 'Qty' is "+chkQty+".");
				return false;
			}
		}
	
	/*var poNo=document.getElementById('washIssue_cboPoNo').value.trim();
	var color=document.getElementById('washIssue_txtColor').value.trim();
	
	var path="washIssue_xml.php?req=getBalance&poNo="+poNo+"&color="+URLEncode(color);
	htmlobj=$.ajax({url:path,async:false});	*/
	
}