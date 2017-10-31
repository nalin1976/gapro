function SaveIssue()
{
	if(!SaveValidate())
		return;
	
	var iNo=document.getElementById('txtIssueNo').value.trim();
	var saveDet="saveDet";
	if(iNo !='')
		saveDet="upDateDet&iNo="+iNo;
	
	var store		= document.getElementById('cboStore').value.trim();
	var department	= document.getElementById('cboDepartment').value.trim();
	var orderId		= document.getElementById('cboOrderNo').value.trim();
	var color		= document.getElementById('cboColor').value.trim();	
	var issueQty	= document.getElementById('txtIssueQty').value.trim();
	var mrnNo		= document.getElementById('cboMrn').value.trim();
	var	fFac		= document.getElementById('wasIssue_txtSFactoryS').value.trim();
	var remarks		= document.getElementById('wasMrn_txtRemarks').value.trim();
	
	var url  = "wasissue_db.php?req="+saveDet+"&OrderId="+orderId+"&Color="+URLEncode(color)+ "&Store="+store+"&Department="+department+"&IssueQty="+issueQty+"&mrnNo="+mrnNo+"&fFac="+fFac+"&remarks="+remarks;
	var htmlobj=$.ajax({url:url,async:false});
	var res=htmlobj.responseText.split('~');
	if(res[1]==''){
		alert(res[0]);
		return false;
	}
	alert(res[0]);
	document.getElementById('txtIssueNo').value=res[1];
	holdForm();
	document.getElementById('Save').style.display='none';
	return false;
}

function LoadMRNDetails(obj)
{
	if(document.getElementById('cboMrn').value==""){
		document.getElementById('wasIssue_txtSFactoryS').value='';
		ClearForm();
		return false;
	}
	
	var url = "wasissue_xml.php?req=URLLoadMRNDetails&MrnNo="+obj.value;
	htmlobj = $.ajax({url:url,async:false});
	var XMLDept = htmlobj.responseXML.getElementsByTagName('Dept')[0].childNodes[0].nodeValue;
	document.getElementById('cboDepartment').value = XMLDept;
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName('OrderNo')[0].childNodes[0].nodeValue;
	document.getElementById('cboOrderNo').innerHTML = XMLOrderNo;
	var XMLStyleNo = htmlobj.responseXML.getElementsByTagName('StyleNo')[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNo').innerHTML = XMLStyleNo;
	var XMLColor = htmlobj.responseXML.getElementsByTagName('Color')[0].childNodes[0].nodeValue;
	document.getElementById('cboColor').innerHTML = XMLColor;
	var XMLOrderQty = htmlobj.responseXML.getElementsByTagName('OrderQty')[0].childNodes[0].nodeValue;
	document.getElementById('txtOrderQty').value = XMLOrderQty;
	var XMLMRNQty = htmlobj.responseXML.getElementsByTagName('MRNQty')[0].childNodes[0].nodeValue;
	document.getElementById('txtMRNQty').value = XMLMRNQty;
	var XMLAvailableQty = htmlobj.responseXML.getElementsByTagName('AvailableQty')[0].childNodes[0].nodeValue;
	document.getElementById('txtAvailableQty').value = XMLAvailableQty;
	var XMLStore = htmlobj.responseXML.getElementsByTagName('Store')[0].childNodes[0].nodeValue;
	document.getElementById('cboStore').value = XMLStore;
	
	var XMLNr=htmlobj.responseXML.getElementsByTagName("Nr");
	var XMLCompany=htmlobj.responseXML.getElementsByTagName("cName");

	if(XMLNr.length>0){
		//alert(XMLNr[0].childNodes[0].nodeValue)
		if(XMLNr[0].childNodes[0].nodeValue==1){
			document.getElementById('wasIssue_txtSFactoryS').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			document.getElementById('wasIssue_txtSFactoryS').disabled=true;
		}
		else{
			/*ClearForm();
			
			document.getElementById('wasIssue_txtSFactoryS').innerHTML=XMLCompany[0].childNodes[0].nodeValue;
			alert("Please select 'Sewing Factory'.");*/
			var sql="SELECT DISTINCT companies.intCompanyID,companies.strName FROM companies order by companies.strName; ASC";
	loadCombo(sql,'wasIssue_txtSFactoryS');
			document.getElementById('wasIssue_txtSFactoryS').disabled=true
			$("#wasIssue_txtSFactoryS option[value='']").remove();
			$("#wasIssue_txtSFactoryS").append('<option value="">Select One</option>');
			document.getElementById("wasIssue_txtSFactoryS").value='';	
			return false;
		}
		
	}
}

function ClearForm()
{

	document.getElementById('cboMrn').disabled=false;
	document.getElementById('cboStore').disabled=false;
	document.getElementById('cboDepartment').disabled=false;
	document.getElementById('cboOrderNo').disabled=false;
	document.getElementById('cboStyleNo').disabled=false;
	document.getElementById('cboColor').disabled=false;
	document.getElementById('cboColor').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('cboStyleNo').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('cboOrderNo').innerHTML = "<option value=\"\">Select One</option>";
	document.getElementById('Save').style.display='inline';
	var sql="select concat(intMrnYear,'/',dblMrnNo)as mrnNo,concat(intMrnYear,'/',dblMrnNo)as mrnDNo from was_mrn where dblBalQty >0 order by mrnNo";
	loadCombo(sql,'cboMrn');		
	document.frmProductionIssue.reset();	
	$("#cboMrn option[value='']").remove();
	$("#cboMrn").append('<option value="">Select One</option>');
	document.getElementById("cboMrn").value='';	
}

function SaveValidate()
{
	var issueQty = document.getElementById('txtIssueQty').value.trim();
	if(document.getElementById('cboMrn').value.trim()==""){
		document.getElementById('cboMrn').focus();
		alert("Please select 'MRN No'.");
		return false;
	}
	else if(issueQty=="" || issueQty=="")
	{
		alert("Issue Qty cannot be zero or empty.");
		 document.getElementById('txtIssueQty').focus();
		return false;
	}
	else{
		return true;
	}
}

function holdForm(){
	document.getElementById('cboMrn').disabled=true;
	document.getElementById('cboStore').disabled=true;
	document.getElementById('cboDepartment').disabled=true;
	document.getElementById('cboOrderNo').disabled=true;
	document.getElementById('cboStyleNo').disabled=true;
	document.getElementById('cboColor').disabled=true;
	document.getElementById('txtIssueQty').readonly=true;
	document.getElementById('wasMrn_txtRemarks').readonly=true;
}

function showReports(mrnNo,iNo,t){
	var mrnNo=mrnNo;
	var iNo=iNo 
	if(t!=0){
	 mrnNo=document.getElementById('cboMrn').value.trim();
	 iNo=document.getElementById('txtIssueNo').value.trim();
	
	var bUrl='';
	if(mrnNo=="")
		return false
	else
		if(iNo!=''){
			bUrl='&issueNo='+iNo;
		}
		window.open('../issueList/rptWasingMRNIssueReport.php?mrn='+bUrl,'washMrnIssue');
	}
	else{
		if(iNo!=''){
			bUrl='&ino='+iNo;
		}
		window.open('../issueList/rptWasingMRNIssueReport.php?mrn='+bUrl,'washMrnIssue')
	}
}

function setBalance(obj){
	var avb=document.getElementById('txtMRNQty').value.trim();
	if(Number(obj.value)>Number(avb)){
		//alert(obj.value>avb);
		obj.value=avb;
	}	
}

function getStylewiseOrderNo(obj,com){
	document.getElementById(com).value=obj.value;
}

function clearForm(){
	document.getElementById("cboStyleNo").value='';
	document.getElementById("cboOrderNo").value='';
	document.getElementById("cbomMrnNofrom").value='';
	document.getElementById("cboMrnNoTo").value='';
	document.getElementById("txtDfrom").value='';
	document.getElementById("txtDto").value='';
	document.getElementById("wasMrn_cboStore").value='';
	document.getElementById("wasMrn_cboDepartment").value='';
	
}

function getStylewiseOrderNo(obj){
	var path="issueLis_xml.php?req=loadPo&style="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboOrderNo').value=htmlobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue; 
}

function getStyle(obj){
	var path="issueLis_xml.php?req=loadStyle&po="+URLEncode(obj.value.trim());
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('cboStyleNo').value=htmlobj.responseXML.getElementsByTagName('StyleNo')[0].childNodes[0].nodeValue; 
}