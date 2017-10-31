// JavaScript Document
var xmlHttp;
var deletionRow;
var pub_url = "/gapro/addinns/CreditPeriod/";
function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function DeleteCreditPeriod(obj)
{
	var creditId = obj.id;
	deletionRow = obj.parentNode.parentNode.parentNode.rowIndex;
	var tr=obj.parentNode.parentNode.parentNode;
	
	//alert(td);
	if(confirm("Are you sure you want to delete \""+tr.cells[2].innerHTML+"\" ?"))
	{
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleCreditPeriodDeletion;
		xmlHttp.open("GET", pub_url+'CreditPeriodMiddleTire.php?RequestType=DeleteCredit&creditID=' + creditId, true);
		xmlHttp.send(null);
	}
}

function HandleCreditPeriodDeletion()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");			 
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Deleted successfully.");	
				RemoveRow(deletionRow);
				ClearCPForm();
			}
		}		
	}	
}

function RemoveRow(rowIndex)
{
	var tbl = document.getElementById('tblCreditPeriod');
    tbl.deleteRow(rowIndex);
}

function showData(obj)
{
	var creditPeriod = obj.parentNode.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	var noOfDays = parseFloat(obj.parentNode.parentNode.parentNode.cells[3].childNodes[0].nodeValue);
	var intStatus =  obj.parentNode.parentNode.parentNode.cells[2].id;
	if(intStatus==1)
		$('#chkActive').attr('checked',true);
	else
		$('#chkActive').attr('checked',false);
	document.getElementById('txtDescription').value = creditPeriod;
	document.getElementById('txtNoOfDates').value = noOfDays;
	document.getElementById("title_Description").title = obj.parentNode.parentNode.parentNode.cells[1].childNodes[0].childNodes[0].id;
}

function NewCreditPeriod()
{
	if (!IsValidCreditPeriod())
		return;
	else if(!ValidateCPBeforeSave())
		return;
	
	var creditId = document.getElementById("title_Description").title;
	var creditPeriod = document.getElementById('txtDescription').value;
	var noOfDays = document.getElementById('txtNoOfDates').value;
	var intStatus =0;
	if($("#chkActive").attr('checked'))
			intStatus=1;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleCreditPeriodAddition;
	xmlHttp.open("GET", pub_url+'CreditPeriodMiddleTire.php?RequestType=NewCreditPedid&creditPeriod=' + URLEncode(creditPeriod) + '&noOfDays=' + noOfDays + '&creditId=' +creditId+'&intStatus='+intStatus , true);
	xmlHttp.send(null);
}

function IsValidCreditPeriod()
{
	if(trim(document.getElementById('txtDescription').value)=="")
	{
		alert("Please enter \"Description\".");	
		document.getElementById('txtDescription').select();
		return false;
	}
	else if(isNumeric(document.getElementById('txtDescription').value)){
		alert("Description must be an \"Alphanumeric\" value.");
		document.getElementById('txtDescription').select();
		return;
	}
	else if(trim(document.getElementById('txtNoOfDates').value)=="")
	{
		alert("Please enter \"No of Dates\".");	
		document.getElementById('txtNoOfDates').select();
		return false;
	}
	return true;
}
function ValidateCPBeforeSave()
{	
	var x_id = document.getElementById("title_Description").title;
	var x_name = document.getElementById("txtDescription").value
	
	var x_find = checkInField('creditperiods','strDescription',x_name,'intSerialNO',x_id);
	if(x_find)
	{
		alert("\""+x_name+ "\" is already exist.");	
		document.getElementById("txtDescription").focus();
		return false;
	}
	return true;
}
function HandleCreditPeriodAddition()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			var XMLstatus = xmlHttp.responseXML.getElementsByTagName("intStatus");
			var ResStatus = XMLstatus[0].childNodes[0].nodeValue;
			
			if(XMLResult[0].childNodes[0].nodeValue == "-1")
			{
				//UpdateTable();
				alert("	\"No of dates\" already exist.");
				return false;
				//ClearCPForm();
			}
			else if (XMLResult[0].childNodes[0].nodeValue != "-2" )
			{				
				AddRowtoGrid(parseInt(XMLResult[0].childNodes[0].nodeValue),ResStatus);
				alert("Saved successfully.");
				ClearCPForm();
			}
			
			else
			{
				UpdateTable();
				alert("Updated successfully.");
				ClearCPForm();
			}				
		}		
	}	
}

function AddRowtoGrid(creditPeriodID,status)
{
	var creditPediod = document.getElementById('txtDescription').value;
	var noOfDays = document.getElementById('txtNoOfDates').value;
	var tbl = document.getElementById('tblCreditPeriod');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cellDelete = row.insertCell(0);
	cellDelete.className = "normalfnt";
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../images/del.png\" onclick=\"DeleteCreditPeriod(this);\" alt=\"Delete\"  width=\"15\" height=\"15\" class=\"mouseover\" id=\"" + creditPeriodID +"\" /></div>";
	
	var cellEdit = row.insertCell(1);
	cellEdit.className = "normalfnt";
	cellEdit.innerHTML = "<div align=\"center\"><img src=\"../../images/edit.png\" onclick=\"showData(this);\" alt=\"Edit\"  width=\"15\" height=\"15\" class=\"mouseover\" id=\"" + creditPeriodID +"\" /></div>";
	
	var cellType = row.insertCell(2);
	cellType.className = "normalfnt";
	cellType.id		= status; 
	cellType.innerHTML = creditPediod;
	
	var cellRate = row.insertCell(3);
	cellRate.className = "normalfntRite";
	cellRate.innerHTML = noOfDays ;
//	cellRate.style = "text-align:right";
//	cellRate.innerHTML = noOfDays;
}

function UpdateTable()
{
	var creditId		= document.getElementById("title_Description").title;
	var creditPeriod 	= document.getElementById('txtDescription').value;
	var noOfDays 		= document.getElementById('txtNoOfDates').value;
	var tbl 			= document.getElementById('tblCreditPeriod');
	var intStatus = 0;
		if($("#chkActive").attr('checked'))
			intStatus=1;
			
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
		if (creditId == rw.cells[1].childNodes[0].childNodes[0].id)
		{
			//alert( rw.cells[1].childNodes[0].childNodes[0]);
			rw.cells[2].childNodes[0].nodeValue = creditPeriod;
			rw.cells[2].id						= intStatus;
			rw.cells[3].childNodes[0].nodeValue = noOfDays;
		}		
	}
}

function ClearCPForm()
{
	document.frmCreditPeriod.reset();
	document.getElementById("title_Description").title = "";
	document.getElementById('txtDescription').focus();
}