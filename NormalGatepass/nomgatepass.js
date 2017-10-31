var xmlHttp;
var xmlHttp1=[];
var pub_no = 0;
var pub_Year = 0;
var validateCount = 0;

function ReloadPage()
{
	document.frmNGList.submit();
}

function ClearForm()
{	
	document.frmNormalGatePass.reset();
	RemoveAllRows('tblNGMain');
	HandleInterFace(0);
}

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

function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;
		tt.parentNode.removeChild(tt);	
	}
}

function LoadSavedDetails()
{
	var strIssueNoFrom = document.getElementById('cboissuenofrom').options[document.getElementById('cboissuenofrom').selectedIndex].text;
	var strObjFrom = strIssueNoFrom.split("/");
	var issueYearFrom  = (strObjFrom[0]);
	var issueNoFrom =(strObjFrom[1]);

	var strIssueNoTo =document.getElementById('cboissuenoto').options[document.getElementById('cboissuenoto').selectedIndex].text;
	var strObjTo = strIssueNoTo.split("/");
	var issueYearTo = (strObjTo[0]);
	var issueNoTo =(strObjTo[1]);

	var issueDateFrom = document.getElementById('issuedatefrom').value;
	var issueDateTo = document.getElementById('issuedateto').value;
		
	var chkbox = document.getElementById('chkdate').checked;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadsaveDetailsRequest;
	xmlHttp.open("GET",'nomgatepassxml.php?RequestType=GetLoadSavedDetails&issueNoFrom=' + issueNoFrom + '&issueYearFrom=' + issueYearFrom + '&issueNoTo=' + issueNoTo + '&issueYearTo=' + issueYearTo + '&issueDateFrom=' + issueDateFrom + '&issueDateTo=' + issueDateTo + '&chkbox=' + chkbox , true);
	xmlHttp.send(null);
}

	function LoadsaveDetailsRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
				var XMLIssueNo = xmlHttp.responseXML.getElementsByTagName("IssueNo");						
				var XMLIssuedDate = xmlHttp.responseXML.getElementsByTagName("IssuedDate");
				var XMLSecurityNo = xmlHttp.responseXML.getElementsByTagName("SecurityNo");
				var XMLintStatus = xmlHttp.responseXML.getElementsByTagName("intStatus");
								
				 var strText =  "<table id=\"tblIssueDetails\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								"<tr>"+
								  "<td width=\"12%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gatepass No</td>"+
								  "<td width=\"37%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
								  "<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gatepass To</td>"+
								  "<td width=\"8%\"bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Normal Print</td>"+
								  "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pre Print</td>"+
								 "</tr>";
				for (var loop =0; loop < XMLIssueNo.length; loop ++)	
				{
					strText +="<tr class=\"bcgcolor-tblrowWhite\" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
								  "<td class=\"normalfntMid\"><a target=\"_blank\" href=\"nomgatepass.php?No=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\" >"+XMLIssueNo[loop].childNodes[0].nodeValue+"</a></td>"+
								  "<td class=\"normalfntMid\">"+XMLIssuedDate[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfnt\">"+XMLSecurityNo[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid mouseover\"><a target=\"_blank\" href=\"nomgatepassreport.php?No=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\" ><img src=\"../../images/color1.png\"></td>"+
								  "<td class=\"normalfntMid mouseover\"><a target=\"_blank\" href=\"nomgatepassprint.php?No=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\" ><img src=\"../../images/color2.png\"></td>"+
								  "</tr>";
				}
				strText += "</table>";
				document.getElementById("divtblIssueDetails").innerHTML=strText;
			}
		}		
	}
//End - Load saved details in when click Search button in issues list.php form



function SaveNormalGatePass()
{
	if(!SaveValidation())
		return;
		
	var no = document.getElementById("txtreturnNo").value
	if(no=="")
	{
		var url = 'nomgatepassxml.php?RequestType=LoadIssueno';
		htmlobj=$.ajax({url:url,async:false});
		
		var XMLAdmin 	= htmlobj.responseXML.getElementsByTagName("Admin");
		if(XMLAdmin[0].childNodes[0].nodeValue=="TRUE")
		{
			var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No");	
			var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year");
			pub_no 	= parseInt(XMLNo[0].childNodes[0].nodeValue);				
			pub_Year = parseInt(XMLYear[0].childNodes[0].nodeValue);	
			document.getElementById("txtreturnNo").value = pub_Year +  "/"  + pub_no ;
			SaveDetails();
		}
		else
		{
			var XMLMessage 		= htmlobj.responseXML.getElementsByTagName("Message");
			alert(XMLMessage[0].childNodes[0].nodeValue);
			return;
		}
	}
	else
	{
		var noArray 	= no.split("/");		
		pub_no 			= parseInt(noArray[1]);
		pub_Year 		= parseInt(noArray[0]);
		SaveDetails();
	}
}

function SaveDetails()
{	
	validateCount 		= 0;
	var gatePassTo 		= document.getElementById('txtGatePassTo').value;
	var instructBy  	= document.getElementById('txtInstructBy').value;
	var attentionBy		= document.getElementById('txtAttention').value;
	var through 		= document.getElementById('txtThrough').value;
	var tblMain 		= document.getElementById('tblNGMain');
	var instructions   	= document.getElementById('txtInstructions').value;
	var remarks   		= document.getElementById('txtRemarks').value;
	var styleNo   		= document.getElementById('txtStyleNo').value;
	var noOfPackages   	= document.getElementById('txtNoOfPackages').value;

	var url = 'nomgatepassxml.php?RequestType=SaveHeader&No=' + pub_no + '&Year=' + pub_Year + '&GatePassTo=' + URLEncode(gatePassTo) + '&InstructBy=' + URLEncode(instructBy) + '&AttentionBy=' + URLEncode(attentionBy) + '&Through=' + URLEncode(through) + '&specialInstructions=' + URLEncode(instructions) + '&remarks=' + URLEncode(remarks) + '&styleNo=' + URLEncode(styleNo)+ '&NoOfPackages='+noOfPackages;
	htmlobj=$.ajax({url:url,async:false});
	
	for (loop = 1 ; loop < tblMain.rows.length ; loop ++)
	{	
		var ItemDescription = tblMain.rows[loop].cells[1].childNodes[0].value;
		var qty 			= tblMain.rows[loop].cells[2].childNodes[0].value;
		var unitId 			= tblMain.rows[loop].cells[3].childNodes[1].value;
		var returnable		= (tblMain.rows[loop].cells[4].childNodes[0].checked==true ? 1:0);			
		validateCount++; 
		
		var url = 'nomgatepassxml.php?RequestType=SaveDetails&No=' + pub_no + '&Year=' + pub_Year + '&itemdDetailID=' + URLEncode(ItemDescription) + '&qty=' + qty + '&Unit=' + unitId + '&returnable=' + returnable;		
		htmlobj=$.ajax({url:url,async:false});		
	}	
	ResponseValidate();	
}

function ResponseValidate()
{
	var url = 'nomgatepassxml.php?RequestType=ResponseValidate&issueNo=' + pub_no + '&Year=' + pub_Year + '&validateCount=' + validateCount;
	htmlobj=$.ajax({url:url,async:false});
	
	var issueHeader		= htmlobj.responseXML.getElementsByTagName("recCountIssueHeader")[0].childNodes[0].nodeValue;
	var issueDetails	= htmlobj.responseXML.getElementsByTagName("recCountIssueDetails")[0].childNodes[0].nodeValue;
	
	if((issueHeader=="TRUE") && (issueDetails=="TRUE"))
	{
		alert ("Normal Gatepass No : " + document.getElementById("txtreturnNo").value + " Saved successfully.");
		HandleInterFace(0);
		
	}
	else 
	{
		alert ("Error while saving data, Please save it again.");
	}	
}

function showReport()
{
	var No = document.getElementById('txtreturnNo').value.trim();
	
	if(No == ""){
		alert("Sorry\nNo 'Normal GatePass No' appear to view.");
		return ;
	}
	newwindow=window.open('nomgatepassreport.php?No=' +No,'name');
			if (window.focus) {newwindow.focus()}	
}
function showReport1(No)
{		
	if(No == ""){
		alert("Sorry\nNo 'Normal GatePass No' appear to view.");
		return ;
	}
	newwindow=window.open('nomgatepassreport.php?No=' +No,'name');
			if (window.focus) {newwindow.focus()}	
}

function printReport()
{

	var No = document.getElementById('txtreturnNo').value.trim();
	if(No == ""){
		alert("Sorry\nNo 'Normal GatePass No' appear to view.");
		return ;
	}	
		newwindow=window.open('nomgatepassprint.php?No='+No,'name');
			if (window.focus) {newwindow.focus()}	
}

function AdddetailsTomainPage()
{	
	var tbl = document.getElementById('IssueItem');
	var tblMain = document.getElementById('tblNGMain');
	var lastRow = tblMain.rows.length;	
	var row = tblMain.insertRow(lastRow);

	row.className="bcgcolor-tblrowWhite";

	var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div style=\"height:25px;\" align=\"center\" ><img style=\"margin-top:5px;\" src=\"../images/del.png\" id=\"" + 0 + "\" alt=\"del\" onclick=\"RemoveItem(this);\" /></div>";
	
	var cellIssuelist = row.insertCell(1);
	cellIssuelist.className = "normalfnt";
	cellIssuelist.innerHTML="<input type=\"text\" style=\"width:645px;\" class=\"txtbox\" name=\"txtDetail\" id=\"txtDetail\" value =\"\" maxlength=\"100\" />";
	
	var cellIssuelist = row.insertCell(2);	
	cellIssuelist.className = "normalfntRite";
	cellIssuelist.innerHTML="<input type=\"text\" style=\"width:90px;text-align:right\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\"0\"  onkeypress=\"return isNumberKey(event);\"/>";

	var cellIssuelist = row.insertCell(3);
	cellIssuelist.className ="normalfntRite";			
	cellIssuelist.innerHTML =document.getElementById('unitbox').innerHTML ;	
	
	var cellIssuelist = row.insertCell(4);
	cellIssuelist.className ="normalfntMid";			
	cellIssuelist.innerHTML ="<input type=\"checkbox\" class=\"txtbox\">" ;
	
	row.cells[1].childNodes[0].focus();
}

function loadDetails(year,no)
{	 
	if (no=="")return false;
	
	var url = 'nomgatepassxml.php?RequestType=LoadHeaderDetails&no=' +no+ '&year=' +year;
	htmlobj=$.ajax({url:url,async:false}); 
	LoadHeaderDetailsRequest(htmlobj);	
	
	var url = 'nomgatepassxml.php?RequestType=LoadGatePassDetails&no=' +no+ '&year=' +year;
	htmlobj=$.ajax({url:url,async:false}); 
	LoadGatePassDetailsRequest(htmlobj);
}

function LoadHeaderDetailsRequest(xmlHttp)
{
	var XMLGatePassNo 	= xmlHttp.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
	var XMLRemarks 		= xmlHttp.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
	var XMLAttention	= xmlHttp.responseXML.getElementsByTagName("Attention")[0].childNodes[0].nodeValue;			
	var XMLThrough 		= xmlHttp.responseXML.getElementsByTagName("Through")[0].childNodes[0].nodeValue;
	var XMLToStores 	= xmlHttp.responseXML.getElementsByTagName("ToStores")[0].childNodes[0].nodeValue;
	var XMLInstructedBy = xmlHttp.responseXML.getElementsByTagName("InstructedBy")[0].childNodes[0].nodeValue;
	var XMLStyleID 		= xmlHttp.responseXML.getElementsByTagName("StyleID")[0].childNodes[0].nodeValue;
	var XMLInstructions = xmlHttp.responseXML.getElementsByTagName("Instructions")[0].childNodes[0].nodeValue;
	var XMLStatus 		= xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
	var XMLNoOfPackages	= xmlHttp.responseXML.getElementsByTagName("NoOfPackages")[0].childNodes[0].nodeValue;
	 
	document.getElementById("txtreturnNo").value 	 = XMLGatePassNo;
	document.getElementById("txtRemarks").value		 = XMLRemarks;
	document.getElementById("txtAttention").value 	 = XMLAttention;			
	document.getElementById("txtThrough").value 	 = XMLThrough ;
	document.getElementById("txtGatePassTo").value 	 = XMLToStores ;				
	document.getElementById("txtInstructBy").value 	 = XMLInstructedBy ;
	document.getElementById("txtStyleNo").value 	 = XMLStyleID ;
	document.getElementById("txtInstructions").value = XMLInstructions ;
	document.getElementById("txtNoOfPackages").value = XMLNoOfPackages ;
	
	HandleInterFace(XMLStatus);
}
	
function LoadGatePassDetailsRequest(xmlHttp1)
{
	var XMLDescription 		= xmlHttp1.responseXML.getElementsByTagName("Description");
	var XMLQty 				= xmlHttp1.responseXML.getElementsByTagName("Qty");				
	var XMLUnit 			= xmlHttp1.responseXML.getElementsByTagName("Unit");			
	var XMLReturnable 		= xmlHttp1.responseXML.getElementsByTagName("Returnable");

	for(loop=0 ; loop<XMLDescription.length;loop++)
	{
		var tbl 				= document.getElementById('IssueItem');
		var tblMain 			= document.getElementById('tblNGMain');
		var lastRow 			= tblMain.rows.length;	
		var row 				= tblMain.insertRow(lastRow);
		
		row.className			= "bcgcolor-tblrowWhite";			
		
		var cellDelete = row.insertCell(0);   
		cellDelete.innerHTML = "<div style=\"height:25px;\" align=\"center\" ><img style=\"margin-top:5px;\" src=\"../images/del.png\" id=\"" + 0 + "\" alt=\"del\" onclick=\"RemoveItem(this);\" /></div>";
		
		var cellIssuelist 		= row.insertCell(1);
		cellIssuelist.className = "normalfnt";				
		cellIssuelist.innerHTML	= "<input type=\"text\" style=\"width:645px;\" class=\"txtbox\" name=\"txtDetail\" id=\"txtDetail\" value =\""+XMLDescription[loop].childNodes[0].nodeValue+"\" maxlength=\"100\" />";
		
		
		var cellIssuelist 		= row.insertCell(2);						
		cellIssuelist.innerHTML	= "<input type=\"text\" size=\"10\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" style=\"text-align:right;width:90px;\" value =\""+XMLQty[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return isNumberKey(event);\"/>";
		
		var cellIssuelist 		= row.insertCell(3);
		cellIssuelist.className = "normalfntRite";			
		cellIssuelist.innerHTML = document.getElementById('unitbox').innerHTML ;						 
		tblMain.rows[loop+1].cells[3].childNodes[0].value =  XMLUnit[loop].childNodes[0].nodeValue;
		
		var cellIssuelist 		= row.insertCell(4);
		cellIssuelist.className = "normalfntMid";
		cellIssuelist.innerHTML = "<input type=\"checkbox\" class=\"txtbox\" "+(XMLReturnable[loop].childNodes[0].nodeValue=="1" ? "checked=checked" : "" )+">" ;		
	}
}
	
function SaveValidation()
{
	var tblMain = document.getElementById('tblNGMain');
	if(document.getElementById('txtGatePassTo').value.trim()=="")
	{
		alert("Please enter the 'GatePass To'.");
		document.getElementById('txtGatePassTo').focus();
		return false;
	}
	if(document.getElementById('txtAttention').value.trim()=="")
	{
		alert("Please enter the 'Attention'.");
		document.getElementById('txtAttention').focus();
		return false;
	}
	if(document.getElementById('txtInstructBy').value.trim()=="")
	{
		alert("Please enter the 'Instructed By'.");
		document.getElementById('txtInstructBy').focus();
		return false;
	}
	else if(tblMain.rows.length <=1)
	{
		alert("Sorry!\nNo details found to save.");
		return false;
	}
	
	for (loop = 1 ;loop < tblMain.rows.length; loop++)
	{
		var description = tblMain.rows[loop].cells[1].childNodes[0].value;
		if(description == "")
		{
			alert("Item Description cannot be blank.");
			tblMain.rows[loop].cells[1].childNodes[0].select();
			return;
		}
		var issueQty = tblMain.rows[loop].cells[2].childNodes[0].value;
		if ((issueQty=="")  || (issueQty==0))
		{
			alert ("Invalid qty in Line No :"+ loop);
			 tblMain.rows[loop].cells[2].childNodes[0].select();
			return false;
		}	
	}
return true;
}

function ConfirmNormalGatePass()
{
	var url  = "nomgatepassxml.php?";
	 	url += "RequestType=URLConfirmNormalGatePass";
	 	url += "&No="+document.getElementById('txtreturnNo').value;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLValid 	= htmlobj.responseXML.getElementsByTagName("Valid")[0].childNodes[0].nodeValue;
	var XMLMessage 	= htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
	if(XMLValid=='TRUE')
	{
		alert(XMLMessage);
		HandleInterFace(1);
	}
	else
	{
		alert(XMLMessage);
		HandleInterFace(0);
	}
}

function CancelNormalGatePass()
{
	var url  = "nomgatepassxml.php?";
	url += "RequestType=URLCancelNormalGatePass";
	url += "&No="+document.getElementById('txtreturnNo').value;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLValid 	= htmlobj.responseXML.getElementsByTagName("Valid")[0].childNodes[0].nodeValue;
	var XMLMessage 	= htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
	if(XMLValid=='TRUE')
	{
		alert(XMLMessage);
		HandleInterFace(10);
	}
	else
	{
		alert(XMLMessage);
		HandleInterFace(1);
	}
}

function HandleInterFace(status)
{
	if(status=='0') //Pending Stage
	{
		document.getElementById('butSave').style.display='inline';
		document.getElementById('butConfirm').style.display='inline';
		document.getElementById('butCancel').style.display='none';
	}
	else if(status=='1') //Confirm Stage
	{
		document.getElementById('butSave').style.display='none';
		document.getElementById('butConfirm').style.display='none';
		document.getElementById('butCancel').style.display='inline';
	}
	else if(status=='10') //Cancel Status
	{
		document.getElementById('butSave').style.display='none';
		document.getElementById('butConfirm').style.display='none';
		document.getElementById('butCancel').style.display='none';
	}
}