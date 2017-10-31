//
function loadWashType(obj)
{
	var cboWashType=document.getElementById('washType_cboSearchWashType').value
	if(cboWashType.trim()=="")
	{
		return false;
	}
	var path="washType_db.php?req=";
		path+="loadDetails&cboWashType="+(cboWashType);
		htmlobj=$.ajax({url:path,async:false});	
	var XMLWashType=htmlobj.responseXML.getElementsByTagName('strWasType');
	var XMLUnitPrice=htmlobj.responseXML.getElementsByTagName('dblUnitPrice');
	var XMLStatus=htmlobj.responseXML.getElementsByTagName('intStatus');
	
	document.getElementById('washType_txtWashType').value=XMLWashType[0].childNodes[0].nodeValue;
	document.getElementById('washType_txtWashUnitPrice').value=XMLUnitPrice[0].childNodes[0].nodeValue;
	if(XMLStatus[0].childNodes[0].nodeValue=='1')
	{
		document.getElementById('washType_chkActInAct').checked=true;
	}
	else
	{
		document.getElementById('washType_chkActInAct').checked=false;
	}
}

function ClearWashTypeForm()
{
	document.getElementById('frmWashType').reset();
	var sql = "SELECT intWasID,strWasType FROM was_washtype where intStatus <>10 order by strWasType";
	loadCombo(sql,'washType_cboSearchWashType');
	document.getElementById('washType_txtWashType').focus();
}

function ValidateWashTypeInterface(washType,unitPrice)
{
	if(washType.value.trim()=="")
	{
		alert("Please enter \"Wash Type\".");
		washType.focus();
		return false;
	}
	else if(isNumeric(washType.value)){
		alert("Wash Type must be an \"Alphanumeric \" value.");
		washType.focus();
		return;
	}
	else if(unitPrice.value.trim()=="")
	{
		alert("Please enter \"Unit Price\".");
		unitPrice.focus();
		return false;
	}
	return true;
}

function ValidateWashTypeBeforeSave(washType,cboWashType)
{
	var x_find = checkInField('was_washtype','strWasType',washType.value,'intWasID',cboWashType);
	if(x_find)
	{
	alert(washType.value+ " is already exist.");	
	document.getElementById("washType_txtWashType").focus();
	return false;
	}
return true;
}

function saveWashType()
{
	var cboWashType=document.getElementById('washType_cboSearchWashType').value;
	var washType=document.getElementById('washType_txtWashType');
	var unitPrice=document.getElementById('washType_txtWashUnitPrice');
	
	if(document.getElementById('washType_chkActInAct').checked)
		var status='1';
	else
		var status='0';	
	
	if(!ValidateWashTypeInterface(washType,unitPrice))
	{
		return
	}
	else if(!ValidateWashTypeBeforeSave(washType,cboWashType))
	{
		return
	}
	
	var path="washType_db.php?";
	
	if(cboWashType.trim()=="")
		path +="req=saveType";
	else
		path +="req=update";
	
	path +="&cboWashType="+cboWashType;
	path +="&washType="+washType.value;
	path +="&unitPrice="+unitPrice.value;
	path +="&status="+status;
	
	htmlobj=$.ajax({url:path,async:false});	
	var HTMLText=htmlobj.responseText
	alert(HTMLText);
	ClearWashTypeForm();
/*	return;
	if(cboWashType.trim()=="")
	{

		path+="saveType&washType="+(washType.value)+"&unitPrice="+(unitPrice.value)+"&status="+status;	
		htmlobj=$.ajax({url:path,async:false});	
		var HTMLText=htmlobj.responseText
		loadCombo("SELECT intWasID,strWasType FROM was_washtype",'washType_cboSearchWashType');
		alert(HTMLText);
		ClearWashTypeForm();
	}
	else if(cboWashType.trim()!="")
	{
		path+="update&cboWashType="+(cboWashType)+"&washType="+(washType.value)+"&unitPrice="+(unitPrice.value)+"&status="+status;	
		htmlobj=$.ajax({url:path,async:false});	
		var HTMLText=htmlobj.responseText
		loadCombo("SELECT intWasID,strWasType FROM was_washtype",'washType_cboSearchWashType');
		alert(HTMLText);
	}*/		
}

function checkValidity(washType,cboWashType)
{
	var x_find = checkInField('was_washtype','strWasType',washType.value,'intWasID',cboWashType.value);
	if(x_find)
	{
		alert(washType.value+ " is already exist.");	
		document.getElementById("washType_txtWashType").focus();
		return false;
	}
}

function deleteWashType()
{
	var cboWashType=document.getElementById('washType_cboSearchWashType').value;
	if(cboWashType.trim()=="")
	{
		alert("Please select the \"Wash Type\".");
		return;
	}
	if(confirm("Are you sure you want to delete "+document.getElementById('washType_txtWashType').value+"?"))
	{
		var path="washType_db.php?req=";
		path+="delete&cboWashType="+(cboWashType);	
		htmlobj=$.ajax({url:path,async:false});	
		var HTMLText=htmlobj.responseText;
		loadCombo("SELECT intWasID,strWasType FROM was_washtype",'washType_cboSearchWashType');
		alert(HTMLText);
		ClearWashTypeForm();
	}
}

function washTypeReport()
{
	window.open("washTypeReport.php",'washType' ); 
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