//************************* Java Script Document ***************************************//
function clearForm()
{
	window.location.reload();
}
function saveIssues()
{
	var projectName = document.getElementById("txtProjectName").value;
	var attentTo    = document.getElementById("cboAttentTo").value;
	var user        = document.getElementById("txtUser").value;
	var description = document.getElementById("txtDescription").value;
	var reportBy    = document.getElementById("txtReportedBy").value;
	var status      = document.getElementById("cboStatus").value;
	
	if(projectName=="")
	{
		alert("Please Enter Project Name!");
		document.getElementById("txtProjectName").focus();
		return false;
	}
	/*if(attentTo=="")
	{
		alert("Please Select 'Attention To!'");
		document.getElementById("cboAttentTo").focus();
		return false;
	}*/
	if(user=="")
	{
		alert("Please Enter User!");
		document.getElementById("txtUser").focus();
		return false;
	}
	if(description=="")
	{
		alert("Please Enter Description!");
		document.getElementById("txtDescription").focus();
		return false;
	}
	if(reportBy=="")
	{
		alert("Please Enter Reporter!");
		document.getElementById("txtReportedBy").focus();
		return false;
	}
	if(status=="")
	{
		alert("Please Select Status!");
		document.getElementById("cboStatus").focus();
		return false;
	}
		saveIssuesList();
}
function saveIssuesList()
{
	var url         = 'issuesLogButton.php?requestType=requestNo';
	html            = $.ajax({url:url,async:false});
	var requestNo   = html.responseText;
	document.getElementById('txtRquestNo').text=requestNo;
	var projectName = document.getElementById("txtProjectName").value;
	var attentTo    = document.getElementById("cboAttentTo").value;
	var user        = document.getElementById("txtUser").value;
	var description = document.getElementById("txtDescription").value;
	var reportBy    = document.getElementById("txtReportedBy").value;
	var status      = document.getElementById("cboStatus").value;
	
	var url = 'issuesLogButton.php?requestType=saveIssueList&requestNo=' +requestNo+ '&projectName=' +projectName+ '&attentTo=' +attentTo+ '&user=' +user+ '&description=' +description+ '&reportBy=' +reportBy+ '&status=' +status;
	html  =$.ajax({url:url,async:false});
	
	if(html.responseText == 1)
	{
	 alert("Issue Saved Successfully \n\n Issue No is :"+requestNo);			
	}
	clearForm();
}