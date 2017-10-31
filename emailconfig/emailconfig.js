var xmlHttp 	= [];
function createXMLHttpRequest(index) 
{
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function closeWindow()
{
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

function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
		// alert(1);
	}	
}

function GetEmailsAccounts(obj)
{
	if(!ValidateInterface())
	{
		return;
	}
	
	var userId = document.getElementById("cboMainUserID").value;
	var permissionId = document.getElementById("cboPermission").value;
		
	createXMLHttpRequest(5);	
	xmlHttp[5].onreadystatechange=GetEmailsAccountsRequest;
	xmlHttp[5].open("GET",'emailconfigmiddle.php?RequestType=LoadDetails&UserId='+userId+ '&permissionId=' +permissionId,true);
	xmlHttp[5].send(null);
}

function GetEmailsAccountsRequest()
{
	if (xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
	{
		var XMLUserId = xmlHttp[5].responseXML.getElementsByTagName("UserId");
		var XMLEmailAccount = xmlHttp[5].responseXML.getElementsByTagName("EmailAccount");
		RemoveAllRows('tblMain');
		
		for(loop=0;loop<XMLUserId.length;loop++)
		{
			AddToGrid(XMLEmailAccount[loop].childNodes[0].nodeValue,XMLUserId[loop].childNodes[0].nodeValue);
		}
	}
}
function ValidateInterface()
{
	var userId =  document.getElementById('cboMainUserID').value;
	if(userId=="")
	{
		alert("Please select the \"User\".");
		document.getElementById('cboPermission').value = "";
		document.getElementById('cboMainUserID').focus();
		return false;
	}
return true;
}

function LoadEmailsPopUp()
{
	var permission =  document.getElementById('cboPermission').value;
	if(permission=="")
	{
		alert("Please select the \"Permission\".");
		document.getElementById('cboPermission').focus();
		return false;		
	}
	
	createXMLHttpRequest(0);	
	xmlHttp[0].onreadystatechange=LoadEmailsPopUpRequest;
	xmlHttp[0].open("GET",'emailpopup.php?' ,true);
	xmlHttp[0].send(null);
}

function LoadEmailsPopUpRequest()
{
	if (xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
	{
		drawPopupArea(400,445,'frmEmailPopUp');				
		var HTMLText=xmlHttp[0].responseText;
		document.getElementById('frmEmailPopUp').innerHTML=HTMLText;				
	}
}

function SelectAll(obj)
{
	var boo = false;
	if(obj.checked)
		var boo = true;
		
	var tbl = document.getElementById('tblPopUp');
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = boo;
	}
}

//Start PopUp details
function SearchPopUpnames(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode == 13)
	{
		alert("ok");
	}
}

function AddToMainTable()
{
	var tblPop = document.getElementById('tblPopUp');
	
	for(loop=1;loop<tblPop.rows.length;loop++)
	{
		var booCheck = true;
		if(tblPop.rows[loop].cells[0].childNodes[0].checked)
		{
			var email = tblPop.rows[loop].cells[1].childNodes[0].nodeValue;
			var emailId = tblPop.rows[loop].cells[1].id;
			
			var tbl = document.getElementById('tblMain');
			for(i=1;i<tbl.rows.length;i++)
			{
				var mainEmailId = tbl.rows[i].cells[1].id;
				if(emailId==mainEmailId)
					booCheck = false;
			}
			if(booCheck)
				AddToGrid(email,emailId);
		}			
	}
	closeWindow();
}

function AddToGrid(email,emailId)
{
	var  tbl = document.getElementById('tblMain');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";	
	
	var cell0 = row.insertCell(0);
	cell0.className = "normalfntMid";
	cell0.innerHTML = "<img  src=\"../images/del.png\" onclick=\"DeleteItem(this);\"/>";
	
	var cell1 = row.insertCell(1);
	cell1.className = "normalfnt";
	cell1.id= emailId;
	cell1.innerHTML = email;
}
//End PopUp details

function butCommand()
{
	var UserId = document.getElementById('cboMainUserID').value;
	var fieldName = document.getElementById('cboPermission').value;
	
	var PermisionList = "";
	var	tbl = document.getElementById('tblMain');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		PermisionList += tbl.rows[loop].cells[1].id + ",";
	}	
	
	createXMLHttpRequest(1);	
	xmlHttp[1].onreadystatechange=butCommandRequest;
	xmlHttp[1].open("GET",'emailconfigdb.php?RequestType=Save&FieldName='+fieldName+ '&PermisionList=' +PermisionList+ '&UserId=' +UserId ,true);
	xmlHttp[1].send(null);
}

function butCommandRequest()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		alert(xmlHttp[1].responseText);	
		RemoveAllRows('tblMain');
	}
}

function ConfirmDelete()
{
	var userName = document.getElementById("cboMainUserID").options[document.getElementById("cboMainUserID").selectedIndex].text;
	var permission = document.getElementById("cboPermission").options[document.getElementById("cboPermission").selectedIndex].text;
	if(confirm("Are you sure you want to delete.\nUser Name : "+userName+"\nPermission : "+permission))
	{
		var userId = document.getElementById("cboMainUserID").value;
		var permissionId = document.getElementById("cboPermission").value;
		
		createXMLHttpRequest(1);	
		xmlHttp[1].onreadystatechange=ConfirmDeleteRequest;
		xmlHttp[1].open("GET",'emailconfigdb.php?RequestType=Delete&PermissionId='+permissionId+ '&UserId=' +userId ,true);
		xmlHttp[1].send(null);
		
	}
}

function ConfirmDeleteRequest()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		alert(xmlHttp[1].responseText);
		ClearForm();
	}
}

function DeleteItem(obj)
{
	var rw = obj.parentNode.parentNode;
	if(confirm("Are you sure you want to remove \""+rw.cells[1].childNodes[0].nodeValue+"\"?"))
	{
		obj.parentNode.parentNode.parentNode;		
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);	
	}
}

function ClearForm()
{
	document.frmEmailConfig.reset();
	RemoveAllRows('tblMain');
	document.getElementById('cboMainUserID').focus();
}

function ShowRportPopUp()
{
	if (document.getElementById("divReport").style.visibility == "hidden")
	{
		document.getElementById("divReport").style.visibility = "";
	}
	else
	{
		document.getElementById("divReport").style.visibility = "hidden";
	}
}

function ViewReport(obj)
{
	var userId = document.getElementById('cboMainUserID').value;
	if(obj=="rdCurrentDetails")
	{
		if(userId=="")
		{
			alert("Please select the \"User\".");
			document.getElementById('cboMainUserID').focus();
			return;
		}
	}else{
		userId = "";
	}

	
	newwindow=window.open('report.php?UserId=' +userId ,'name');
	if (window.focus) {newwindow.focus()}
	ShowRportPopUp();			
}