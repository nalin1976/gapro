var xmlHttp;
var xmlHttp1=[];
var mainArrayIndex = 0;
var Materials = [];
//var MaterialsD = [];
var pub_no = 0;
var pub_Year = 0;
var validateCount = 0;
var validateBinCount =0;
var mainRw =0;

// start - configuring ALTHTTP request
function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}
// End - configuring ALTHTTP request

//Start - BackPage
function backtopage()
{
	window.location.href="main.php";
}
//End - BackPage

//Start-ClearForm
function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}
//End-ClearForm

// start - configuring HTTP request
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
// End - configuring HTTP request

//Start -Get GetXmlHttpObject
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}
//End -Get GetXmlHttpObject

function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}


//Start-Close Window
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
//End-Close Window

//Start - Public remove data function
function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}
//End - Public remove data function

//Start - Clear table data
function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}
//End - Clear table data

//Start-Delete selected table row from the Table issue.php
function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;		
	}
}
//End-Delete selected table row from the Table issue.php

//Start -Load Materials 
function LoadMaterials()
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = MaterialsRequest;
	altxmlHttp.open("GET", 'nomgatepassxml.php?RequestType=LoadMaterial', true);
	altxmlHttp.send(null);	
}

function MaterialsRequest()
{	
	if(altxmlHttp.readyState == 4) 
	{
		if(altxmlHttp.status == 200) 
		{  			 
			var XMLID = altxmlHttp.responseXML.getElementsByTagName("ID");
			var XMLDescription = altxmlHttp.responseXML.getElementsByTagName("Description");
			
			var opt = document.createElement("option");
			opt.text = "";						
			document.getElementById("cbomaterial").options.add(opt);
			
			for ( var loop =0; loop < XMLID.length; loop ++)
				{						
					var opt = document.createElement("option");
					opt.text = XMLDescription[loop].childNodes[0].nodeValue;
					opt.value = XMLID[loop].childNodes[0].nodeValue;
					document.getElementById("cbomaterial").options.add(opt);			
				}
		}
	}
}

function loadSubCategory()
	{	
		RomoveData('cboSubCategory');
		var mainCatId = document.getElementById("cbomaterial").value;
		createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = loadSubCategoryRequest;
		xmlHttp1[1].open("GET", 'nomgatepassxml.php?RequestType=loadSubCategory&mainCatId='+mainCatId, true);
		xmlHttp1[1].send(null); 
	}
	
	function loadSubCategoryRequest()
	{
		if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
		{
			var XMLid = xmlHttp1[1].responseXML.getElementsByTagName("intSubCatNo");
			var XMLname = xmlHttp1[1].responseXML.getElementsByTagName("StrCatName");
			
			 for ( var loop = 0; loop < XMLid.length; loop++)
			 {
				var opt = document.createElement("option");
				opt.value = XMLid[loop].childNodes[0].nodeValue;
				opt.text =XMLname[loop].childNodes[0].nodeValue ;
				document.getElementById("cboSubCategory").options.add(opt);
			 }
			 //loadMaterial();
		}
	}
	
//End -Load Materials 	

//Start - Load saved details in when click Search button in issues list.php form
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

//Start -Save part with arrays
function saveIssuedetails()
{	
	validateCount = 0;
	validateBinCount = 0;
	var productionId = document.getElementById('cboreturnedby').value;
	var instructbyId = document.getElementById('cboinstruct').value;
	var attention = document.getElementById('txtattention').value;
	var through = document.getElementById('txtthrough').value;
	var tblMain = document.getElementById('tblIssueList');
	var instructions   = document.getElementById('txtInstructions').value;
	var remarks   = document.getElementById('txtRemarks').value;
	var styleNo   = document.getElementById('txtStyleNo').value;

	createXMLHttpRequest();
	xmlHttp.open("GET" ,'nomgatepassxml.php?RequestType=SaveIssueHeader&issueNo=' + pub_no + '&issueYear=' + pub_Year + '&productionId=' + productionId + '&instructbyId=' + instructbyId + '&attention=' + attention + '&through=' + through + '&specialInstructions=' + URLEncode(instructions) + '&remarks=' + URLEncode(remarks) + '&styleNo=' + URLEncode(styleNo)  ,true)
	xmlHttp.send(null);	 		
	for (loop = 1 ; loop < tblMain.rows.length ; loop ++)
	{
	
	var ItemDescription = tblMain.rows[loop].cells[1].childNodes[0].value;
	var qty = tblMain.rows[loop].cells[2].childNodes[0].value;
	var unit = tblMain.rows[loop].cells[3].childNodes[0].value;
	var returnable = 0;
	if(tblMain.rows[loop].cells[4].childNodes[0].checked)
	returnable = 1;
			
			validateCount++; 
			
				createXMLHttpRequest();
			xmlHttp.open("GET",'nomgatepassxml.php?RequestType=SaveIssueDetails&issueNo=' + pub_no + '&issueYear=' + pub_Year + '&itemdDetailID=' + URLEncode(ItemDescription) + '&qty=' + qty + '&Unit=' + unit + '&returnable=' + returnable, true);
				xmlHttp.send(null);
		
	}	
	ResponseValidate();	
}
//End -Save part with arrays

//Start -Get new Issue No from setting tables 
function getIssueNo()
{	
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboreturnedby").value=="")	
	{
		alert ("Please enter 'Gatepass To' before Saving");	
		return false;
	}
	if(tbl.rows.length<=1) {alert("No details available for the normal gate pass.");return false;}
	
	for (loop = 1 ;loop < tbl.rows.length; loop++)
	{
		var description = tbl.rows[loop].cells[1].childNodes[0].value;
		if(description == "")
		{
			alert("Sorry! You can't save empty items. Please enter the item descrriptions.");
			tbl.rows[loop].cells[1].childNodes[0].focus();
			return;
		}
		var issueQty = tbl.rows[loop].cells[2].childNodes[0].value;
			if ((issueQty=="")  || (issueQty==0))
			{
				alert ("Please enter valid quantity for the item : "+ tbl.rows[loop].cells[1].childNodes[0].value);
				 tbl.rows[loop].cells[2].childNodes[0].focus();
				return false;
			}	
	}

	var no = document.getElementById("txtreturnNo").value
	if(no=="")
	{
		createXMLHttpRequest();	
		xmlHttp.onreadystatechange = LoadIssueNoRequest;
		xmlHttp.open("GET" ,'nomgatepassxml.php?RequestType=LoadIssueno' ,true);
		xmlHttp.send(null);	
	}
	else
	{
		var noArray = no.split("/");		
		pub_no =parseInt(noArray[1]);
		pub_Year = parseInt(noArray[0]);
		saveIssuedetails();
	}
}
	function LoadIssueNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  			 
			 	var XMLNo 	= xmlHttp.responseXML.getElementsByTagName("No");	
				var XMLYear = xmlHttp.responseXML.getElementsByTagName("Year");
				  pub_no 	= parseInt(XMLNo[0].childNodes[0].nodeValue);				
				  pub_Year = parseInt(XMLYear[0].childNodes[0].nodeValue);	
				
						document.getElementById("txtreturnNo").value = pub_Year +  "/"  + pub_no ;
						saveIssuedetails();
			}
		}		
	}
//End -Load MrnNo PoNo when click BuyerPoNo

//Start-Validate save datails
function ResponseValidate()
{
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = ResponseValidateRequest;
	xmlHttp.open("GET" ,'nomgatepassxml.php?RequestType=ResponseValidate&issueNo=' + pub_no + '&Year=' + pub_Year + '&validateCount=' + validateCount,true);
	xmlHttp.send(null);
}
	function ResponseValidateRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{				
				var issueHeader= xmlHttp.responseXML.getElementsByTagName("recCountIssueHeader")[0].childNodes[0].nodeValue;
				var issueDetails= xmlHttp.responseXML.getElementsByTagName("recCountIssueDetails")[0].childNodes[0].nodeValue;
					if((issueHeader=="TRUE") && (issueDetails=="TRUE"))
					{
						alert ("Gatepass No :" + document.getElementById("txtreturnNo").value +  " Saved Successfully!");						
						//document.getElementById("Save").style.visibility="hidden";
					}
					else 
					{
						ResponseValidate();
					}			
			}
		}
	}

function showReport()
{
	var No = document.getElementById('txtreturnNo').value;
	
	if(No == ""){
		alert("Sorry\nNo Normal GatePass No to Save.");
		return ;
	}
	newwindow=window.open('nomgatepassreport.php?No=' +No,'name');
			if (window.focus) {newwindow.focus()}	
}

function printReport()
{

	var No = document.getElementById('txtreturnNo').value;
	if(No == ""){
		alert("Sorry\nNo Normal GatePass No to Save.");
		return ;
	}	
		newwindow=window.open('nomgatepassprint.php?No='+No,'name');
			if (window.focus) {newwindow.focus()}	
}

function AdddetailsTomainPage()
{	
	var tbl = document.getElementById('IssueItem');

	var  tblIssueList = document.getElementById('tblIssueList');			

	var lastRow = tblIssueList.rows.length;	
	var row = tblIssueList.insertRow(lastRow);

	row.className="bcgcolor-tblrowWhite";		


	var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div style=\"height:25px;\" align=\"center\" ><img style=\"margin-top:5px;\" src=\"../../images/del.png\" id=\"" + 0 + "\" alt=\"del\" onclick=\"RemoveItem(this);\" /></div>";
	
	var cellIssuelist = row.insertCell(1);
	cellIssuelist.className = "normalfnt";

	cellIssuelist.innerHTML="<input type=\"text\" style=\"width:500px;\" class=\"txtbox\" name=\"txtDetail\" id=\"txtDetail\" value =\"\" maxlength=\"100\" />";

	
	var cellIssuelist = row.insertCell(2);						
	cellIssuelist.innerHTML="<input type=\"text\" size=\"10\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\"0\"  onkeypress=\"return isNumberKey(event);\"/>";

	var cellIssuelist = row.insertCell(3);
	cellIssuelist.className ="normalfntRite";			
	cellIssuelist.innerHTML =document.getElementById('unitbox').innerHTML ;	
	
	var cellIssuelist = row.insertCell(4);
	cellIssuelist.className ="normalfntMid";			
	cellIssuelist.innerHTML ="<input type=\"checkbox\" class=\"txtbox\">" ;							

}

function loadDetails(year,no)
{	 
	if (no=="")return false;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadHeaderDetailsRequest;
	xmlHttp.open("GET",'nomgatepassxml.php?RequestType=LoadHeaderDetails&no=' +no+ '&year=' +year ,true);
	xmlHttp.send(null);
	 
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange=LoadGatePassDetailsRequest;
	xmlHttp1[1].open("GET",'nomgatepassxml.php?RequestType=LoadGatePassDetails&no=' +no+ '&year=' +year ,true);
	xmlHttp1[1].send(null); 
}

	function LoadHeaderDetailsRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLGatePassNo =xmlHttp.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
				var XMLRemarks =xmlHttp.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
				var XMLAttention =xmlHttp.responseXML.getElementsByTagName("Attention")[0].childNodes[0].nodeValue;			
				var XMLThrough =xmlHttp.responseXML.getElementsByTagName("Through")[0].childNodes[0].nodeValue;
				var XMLToStores =xmlHttp.responseXML.getElementsByTagName("ToStores")[0].childNodes[0].nodeValue;
				var XMLInstructedBy = xmlHttp.responseXML.getElementsByTagName("InstructedBy")[0].childNodes[0].nodeValue;
				var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleID")[0].childNodes[0].nodeValue;
				var XMLInstructions = xmlHttp.responseXML.getElementsByTagName("Instructions")[0].childNodes[0].nodeValue;
				 
				document.getElementById("txtreturnNo").value =XMLGatePassNo;
				document.getElementById("txtRemarks").value=XMLRemarks;
				document.getElementById("txtattention").value =XMLAttention;			
				document.getElementById("txtthrough").value =XMLThrough ;
				document.getElementById("cboreturnedby").value =XMLToStores ;				
				document.getElementById("cboinstruct").value =XMLInstructedBy ;
				document.getElementById("txtStyleNo").value =XMLStyleID ;
				document.getElementById("txtInstructions").value =XMLInstructions ;
				
			}
		}
	}
	
	function LoadGatePassDetailsRequest()
	{
		if (xmlHttp1[1].readyState==4)
		{
			if (xmlHttp1[1].status==200)
			{
				var XMLDescription =xmlHttp1[1].responseXML.getElementsByTagName("Description");
				var XMLQty =xmlHttp1[1].responseXML.getElementsByTagName("Qty");				
				var XMLUnit =xmlHttp1[1].responseXML.getElementsByTagName("Unit");			
				var XMLReturnable =xmlHttp1[1].responseXML.getElementsByTagName("Returnable");
				 
				 for(loop=0 ; loop<XMLDescription.length;loop++)
				 {
					var tbl 			= document.getElementById('IssueItem');
					var tblIssueList 	= document.getElementById('tblIssueList');
					var lastRow 		= tblIssueList.rows.length;	
					var row 			= tblIssueList.insertRow(lastRow);
				
					row.className		= "bcgcolor-tblrowWhite";			
				
					var cellDelete = row.insertCell(0);   
					cellDelete.innerHTML = "<div style=\"height:25px;\" align=\"center\" ><img style=\"margin-top:5px;\" src=\"../../images/del.png\" id=\"" + 0 + "\" alt=\"del\" onclick=\"RemoveItem(this);\" /></div>";
					
					var cellIssuelist = row.insertCell(1);
					cellIssuelist.className = "normalfnt";				
					cellIssuelist.innerHTML="<input type=\"text\" style=\"width:500px;\" class=\"txtbox\" name=\"txtDetail\" id=\"txtDetail\" value =\""+XMLDescription[loop].childNodes[0].nodeValue+"\" maxlength=\"100\" />";
				
					
					var cellIssuelist = row.insertCell(2);						
					cellIssuelist.innerHTML="<input type=\"text\" size=\"10\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" style=\"text-align:right\" value =\""+XMLQty[loop].childNodes[0].nodeValue+"\"  onkeypress=\"return isNumberKey(event);\"/>";
				
					var cellIssuelist = row.insertCell(3);
					cellIssuelist.className ="normalfntRite";			
					cellIssuelist.innerHTML =document.getElementById('unitbox').innerHTML ;						 
					tblIssueList.rows[loop+1].cells[3].childNodes[0].value =  XMLUnit[loop].childNodes[0].nodeValue;
					
					var cellIssuelist = row.insertCell(4);
					cellIssuelist.className ="normalfntMid";
					cellIssuelist.innerHTML ="<input type=\"checkbox\" class=\"txtbox\" "+(XMLReturnable[loop].childNodes[0].nodeValue=="1" ? "checked=checked" : "" )+">" ;		
				 }
				
			}
		}
	}