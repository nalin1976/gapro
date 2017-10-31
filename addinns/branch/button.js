var pub_rowId = 0;
var pub_branchPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_urlBranch = pub_branchPath+"/addinns/branch/";

//-------------hem--------------------------------------------------------------------------------
var xmlHttp1=[];

function DeleteRow(obj)
{
	var accName = obj.parentNode.parentNode.cells[1].childNodes[0].nodeValue;
	if(confirm("Are you sure you want to remove item '"+accName+"'?"))
	{
		var td  = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);	
	}
}

function clearformBranch()
{	
	loadCombo('SELECT intBranchId,strName FROM branch WHERE intStatus<>10 order by strName ASC','branch_cboBranchName');
	document.frmBranch.reset();
	$("#tblAccounts tr:gt(0)").remove();
	document.getElementById("branch_txtBranchCode").focus();
}
//---------Insert & Update Data (Save Data)------------hem-------------------------------------------

function ValidateBranchInterface()
{
	if(document.getElementById('branch_txtBranchCode').value.trim() =="" )
	{
		alert("Please enter 'Branch Code'.");	
		document.getElementById('branch_txtBranchCode').focus();
		return false;
	}
	else if(document.getElementById('branch_txtName').value.trim() =="" )
	{	alert("Please enter 'Branch Name'.");	
		document.getElementById('branch_txtName').focus();			
		return false;
	}
	else if (isNumeric(document.getElementById("branch_txtName").value))
	{	alert("\"Branch Name \" must be an alphanumeric value.");			
		document.getElementById('branch_txtName').focus();
		return false;
	}
	else if(document.getElementById('branch_cboCountry').value.trim() =="" )
	{	alert("Please select 'Country'.");	
		document.getElementById('branch_cboCountry').focus();			
		return false;
	}
	else if(document.getElementById('branch_cboBankName').value.trim() =="" )
	{	alert("Please select 'Bank'.");	
		document.getElementById('branch_cboBankName').focus();			
		return false;
	}	
	else if (document.getElementById("branch_txtEMail").value.trim()!="")
	{	
		if(emailValidate(document.getElementById("branch_txtEMail").value)==false)
		{
			document.getElementById("branch_txtEMail").focus();
			alert("Please enter a valid email address");
			return false;
		}
	}
	return true;
}

function ValidateBranchBeforeSave()
{
	var x_id = document.getElementById("branch_cboBranchName").value
	var x_name = document.getElementById("branch_txtBranchCode").value

	var x_find = checkInField('branch','strBranchCode',x_name,'intBranchId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("branch_txtBranchCode").focus();
		return false;
	}	
	var id = document.getElementById("branch_cboBranchName").value
	var name = document.getElementById("branch_txtName").value

	var x_find = checkInField('branch','strName',name,'intBranchId',id);
	if(x_find)
	{
		alert("\""+name+"\" is already exist.");	
		document.getElementById("branch_txtName").focus();
		return false;
	}
	return true;
}

function butCmdSaveBranch(strCommand)
{
	if(!ValidateBranchInterface())
		return;
		
	if(!ValidateBranchBeforeSave())	
		return;

	if(document.getElementById('branch_cboBranchName').value=="" )
		strCommand="New";
	
	var url=pub_urlBranch+"button.php";
	url=url+"?q="+strCommand;	
	url=url+"&cboBranchName="+URLEncode(document.getElementById("branch_cboBranchName").value);
	url=url+"&strBranchCode="+URLEncode(document.getElementById("branch_txtBranchCode").value);
	url=url+"&strName="+URLEncode(document.getElementById("branch_txtName").value.trim());
	url=url+"&strAddress1="+URLEncode(document.getElementById("branch_txtAddress1").value);
	url=url+"&strStreet="+URLEncode(document.getElementById("branch_txtStreet").value);
	url=url+"&strCity="+URLEncode(document.getElementById("branch_txtCity").value);
	url=url+"&strCountry="+URLEncode(document.getElementById("branch_cboCountry").value);
	url=url+"&strPhone="+URLEncode(document.getElementById("branch_txtPhone").value);
	url=url+"&strFax="+URLEncode(document.getElementById("branch_txtFax").value);
	url=url+"&strEMail="+URLEncode(document.getElementById("branch_txtEMail").value);
	url=url+"&strContactPerson="+URLEncode(document.getElementById("branch_txtContactPerson").value);
	url=url+"&strRemarks="+URLEncode(document.getElementById("branch_txtRemarks").value);
	url=url+"&strRefNo="+URLEncode(document.getElementById("branch_txtRefNo").value); 
	url=url+"& cboBankName="+URLEncode(document.getElementById("branch_cboBankName").value);	
			
	if(document.getElementById("branch_chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
			
	url=url+"&intStatus="+intStatus;
	htmlobj=$.ajax({url:url,async:false});
	
	var tbl = document.getElementById('tblAccounts');;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var url1 = pub_urlBranch+"button.php";	
		url1 += "?q=SaveAccountDetails";
		url1 += "&BranchId="+ $("#branch_cboBranchName").val();
		url1 += "&AccoName="+tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		url1 += "&CurrId="+ tbl.rows[loop].cells[2].id;		
		htmlobj1=$.ajax({url:url1,async:false});
	}
	
	stateChangedSave(htmlobj);
}

function stateChangedSave(htmlobj)
{ 
	alert(htmlobj.responseText);
	clearformBranch();
}

function GetBranchDetails(obj)
{   
	if(obj.value=='')
	{
		document.frmBranch.reset();
		return;
	}
	var url = pub_urlBranch+"branchMiddle.php?id=LoadDetails&BranchID="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	ShowBranchDetails(htmlobj);
	
	var url = pub_urlBranch+"branchMiddle.php?id=LoadAccountDetails&BranchID="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	LoadAccounts(htmlobj);
}

function ShowBranchDetails(htmlobj)
{
	if(document.getElementById('divlistORDetails').style.visibility == "visible")
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	
	document.frmBranch.radioListORdetails[0].checked = false;
	document.frmBranch.radioListORdetails[1].checked = false;
	document.getElementById('branch_txtBranchCode').disabled=false;
	
	var XMLBranchCode = htmlobj.responseXML.getElementsByTagName("strBranchCode");
		document.getElementById('branch_txtBranchCode').value 	= XMLBranchCode[0].childNodes[0].nodeValue;	
	var XMLName 	= htmlobj.responseXML.getElementsByTagName("Name");
		document.getElementById('branch_txtName').value 		= XMLName[0].childNodes[0].nodeValue;	
	var XMLAddress1 = htmlobj.responseXML.getElementsByTagName("Address1");
		document.getElementById('branch_txtAddress1').value 	= XMLAddress1[0].childNodes[0].nodeValue;	
	var XMLAddress1 = htmlobj.responseXML.getElementsByTagName("strStreet");
		document.getElementById('branch_txtStreet').value 		= XMLAddress1[0].childNodes[0].nodeValue;	
	var XMLCity 	= htmlobj.responseXML.getElementsByTagName("strCity");
		document.getElementById('branch_txtCity').value 		= XMLCity[0].childNodes[0].nodeValue;	
	var XMLCountry 	= htmlobj.responseXML.getElementsByTagName("Country");
		document.getElementById('branch_cboCountry').value 		= XMLCountry[0].childNodes[0].nodeValue;	
	var XMLPhone 	= htmlobj.responseXML.getElementsByTagName("Phone");
		document.getElementById('branch_txtPhone').value 		= XMLPhone[0].childNodes[0].nodeValue;	
	var XMLFax 		= htmlobj.responseXML.getElementsByTagName("Fax");
		document.getElementById('branch_txtFax').value 			= XMLFax[0].childNodes[0].nodeValue;	
	var XMLEMail 	= htmlobj.responseXML.getElementsByTagName("EMail");
		document.getElementById('branch_txtEMail').value 		= XMLEMail[0].childNodes[0].nodeValue;	
	var XMLRefNo 	= htmlobj.responseXML.getElementsByTagName("RefNo");
		document.getElementById('branch_txtRefNo').value 		= XMLRefNo[0].childNodes[0].nodeValue;	
	var XMLContactPerson = htmlobj.responseXML.getElementsByTagName("ContactPerson");
		document.getElementById('branch_txtContactPerson').value = XMLContactPerson[0].childNodes[0].nodeValue;	
	var XMLRemarks 	= htmlobj.responseXML.getElementsByTagName("Remarks");
		document.getElementById('branch_txtRemarks').value 		= XMLRemarks[0].childNodes[0].nodeValue;	
	var XMLsBankID 	= htmlobj.responseXML.getElementsByTagName("BankID");
		document.getElementById('branch_cboBankName').value 	= XMLsBankID[0].childNodes[0].nodeValue;
	
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("Status");
	if(XMLStatus[0].childNodes[0].nodeValue==1)
		document.getElementById("branch_chkActive").checked=true;	
	else
		document.getElementById("branch_chkActive").checked=false;	
	
	var XMLused = htmlobj.responseXML.getElementsByTagName("used");	
	if(XMLused[0].childNodes[0].nodeValue == '1')
		document.getElementById('branch_txtBranchCode').disabled=true;
	if(XMLused[0].childNodes[0].nodeValue == '0')
		document.getElementById('branch_txtBranchCode').disabled=false;
}

function LoadAccounts(htmlobj)
{
	tbl				= document.getElementById('tblAccounts');
	var XMLAccountNo  = htmlobj.responseXML.getElementsByTagName("AccountNo");
	var XMLCurrencyId = htmlobj.responseXML.getElementsByTagName("CurrencyId");
	var XMLCurrencyName = htmlobj.responseXML.getElementsByTagName("CurrencyName");
	$("#tblAccounts tr:gt(0)").remove();
	for(loop=0;loop<XMLAccountNo.length;loop++)
	{
		var accountName = XMLAccountNo[loop].childNodes[0].nodeValue;
		var currencyId = XMLCurrencyId[loop].childNodes[0].nodeValue;
		var currency = XMLCurrencyName[loop].childNodes[0].nodeValue;
		CreateGrid(loop,tbl,accountName,currencyId,currency)
	}
}

function ConfirmDeleteBranch(strCommand)
{
	if(document.getElementById('branch_cboBranchName').value!="" )
	{	
		var branchName = document.getElementById("branch_cboBranchName").options[document.getElementById('branch_cboBranchName').selectedIndex].text;
		if(confirm("Are you sure you want to delete  \""+ branchName+" \" ?"))
		{	
			var branchID=document.getElementById("branch_cboBranchName").value;
			var url  = pub_urlBranch+"button.php?q=delete";
			url += "&branchID="+branchID;
			htmlobj=$.ajax({url:url,async:false});
			deleteRequest(htmlobj);
		}
	}
	else{
		alert("Please select the \"Branch\".");
	}
}

function deleteRequest(htmlobj)
{
	var res = htmlobj.responseText;
	alert("Deleted successfully.");	
	loadCombo('SELECT distinct strName, strName FROM branch WHERE intStatus<>10 order by strName ASC','branch_cboBranchName');
	document.frmBranch.reset();
}
//----------REPORT-----hem------------------------------------------------------------------------------

function listBranchPrintDetails()
{
	document.frmBranch.radioListORdetails[0].checked = false;
	document.frmBranch.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}
//--------hem-------------------

function loadReportBranch()
{ 
	if(document.frmBranch.radioListORdetails[0].checked == true)
	{
		var branchID = document.getElementById('branch_cboBranchName').value;
		window.open(pub_urlBranch+"branchReportList.php?branchID=" + branchID,'brnchlist'); 
	}
	else
	{
		var branchID = document.getElementById('branch_cboBranchName').value;
		if(branchID != "")
			window.open(pub_urlBranch+"branchReportDetails.php?branchID=" + branchID,'brnchdtl'); 
		else
			alert("Please select a \"Branch\".");		
	}
	document.getElementById('divlistORDetails').style.visibility = "hidden";
}

//--------hem-------------------------------------------------------	
function popupBank1()
{
		var url  = "../banks/banks.php?";
	inc('../banks/banks-js.js');
	var W	= 545;
	var H	= 284;
	var closePopUp = "closeBanksPopUp";
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete);	
	
}
//--hem---------------------

function closeBanksPopUp()
{
	closeWindow();
	loadCombo('SELECT bank.intBankId, bank.strBankName FROM bank where intStatus<>10 order by strBankName asc;','branch_cboBankName');
}

function closePopUpArea(id)
{
try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

//-----------Load Country------------------------------------------------------
function popcountry_inbranch()
{
	var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUpInBranch";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeCountryModePopUpInBranch(id)
{
	closePopUpArea(id);
	var sql = "SELECT country.intConID,country.strCountry FROM country WHERE country.intStatus=1 order by country.strCountry;";
	var control = "branch_cboCountry";
	loadCombo(sql,control);
}

function LoadCountryModeRequest()
{
	if(xmlHttp1[3].readyState==4 && xmlHttp1[3].status==200)
	{
			var XMLText = xmlHttp1[3].responseText;			
			document.getElementById('branch_cboCountry').innerHTML = XMLText;
	}
}
//-----------Load Bank------------------------------------------------------
function popupBank()
{	
	var url  = "../banks/banks.php?";
	inc('/gapro/addinns/banks/banks-js.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeBankModePopUpInBranch";
	var tdPopUpClose = "banks_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}

function closeBankModePopUpInBranch(id)
{
	closePopUpArea(id);
    var sql = "SELECT bank.intBankId, bank.strBankName FROM bank  where intStatus=1 order by strBankName asc";
	var control = "branch_cboBankName";
	loadCombo(sql,control);
}

function LoadBranchModeRequest()
{
	if(xmlHttp1[4].readyState==4 && xmlHttp1[4].status==200)
	{
		var XMLText = xmlHttp1[4].responseText;			
		document.getElementById('branch_cboBankName').innerHTML = XMLText;
	}
}

function GetAccountName(obj)
{
	var url = pub_urlBranch+"branchMiddle.php?id=LoadAccountName&BranchName="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('branch_cboAccName').innerHTML = htmlobj.responseText;	
	//alert(document.getElementById('branch_cboAccName').options.length);
	GetBranchDetails();
}

function AddAccountDetailsToGrid()
{
	var accountName = trim($("#branch_txtAccountName").val());
	var currencyId = $("#branch_cboCurrencyId").val();
	
	if(accountName=="")
	{
		alert("Please enter the 'Account Name'.");
		$("#branch_txtAccountName").focus();
		return;
	}
	else if(currencyId=="")
	{
		alert("Please select the 'Currency'.");
		$("#branch_cboCurrencyId").focus();
		return;
	}
	
	var tbl 		= document.getElementById('tblAccounts');
	var currency	= $("#branch_cboCurrencyId option:selected").text()
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var mainAccNo	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		var mainCurrNo	= tbl.rows[loop].cells[2].id;
		
		if(mainAccNo==accountName && mainCurrNo==currencyId)
			return;
	}
	pub_rowId++;
	CreateGrid(pub_rowId,tbl,accountName,currencyId,currency);
}

function CreateGrid(rowId,tbl,accountName,currencyId,currency)
{
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	row.id = rowId;
	row.setAttribute("ondblclick","EditAccounts(this);"); 
	
	var cell = row.insertCell(0);
	cell.className = "normalfntMid";
	cell.innerHTML = "<img src=\"../../images/del.png\" alt=\"edit\" width=\"15\" height=\"15\" onclick=\"DeleteRow(this);\"/>";;
	
	var cell = row.insertCell(1);
	cell.className = "normalfnt";
	cell.innerHTML = accountName;
	
	var cell = row.insertCell(2);
	cell.className = "normalfnt";
	cell.id = currencyId;
	cell.innerHTML = currency;
}

function EditAccounts(obj)
{
	$("#branch_txtAccountName").val(obj.cells[1].childNodes[0].nodeValue);
	$("#branch_cboCurrencyId").val(obj.cells[2].id);
}