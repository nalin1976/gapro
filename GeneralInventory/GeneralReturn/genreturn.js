var xmlHttp;
var mainArrayIndex = 0;
var Materials = [];
var issueNo = 0;
var issueYear = 0;
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

//Start -Load Styles 

//End -Load Styles 

//Start -Load Materials 
function LoadMaterials()
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = MaterialsRequest;
	altxmlHttp.open("GET", 'genreturnxml.php?RequestType=LoadMaterial', true);
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
//End -Load Materials 	

//Start -Load MrnNo PoNo when click BuyerPoNo
function LoadMrnNo()
{
	RomoveData("cbomrnno");
	RemoveAllRows("IssueItem");

	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadMrnNoRequest;
	xmlHttp.open("GET",'genreturnxml.php?RequestType=LoadMrnNo', true);
    xmlHttp.send(null); 
}

	function LoadMrnNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  			 
			 	var XMLMrnNo = xmlHttp.responseXML.getElementsByTagName("MrnNo");	

					var opt = document.createElement("option");
					opt.text = "";
					opt.value = "";	
					document.getElementById("cbomrnno").options.add(opt);
					for ( var loop = 0; loop < XMLMrnNo.length; loop ++)
			 		{						
						var opt = document.createElement("option");
						opt.text = XMLMrnNo[loop].childNodes[0].nodeValue;
						opt.value = XMLMrnNo[loop].childNodes[0].nodeValue;	
						document.getElementById("cbomrnno").options.add(opt);			
			 		}
			}
		}
		//loadMrnDetailsToGrid();
	}
//End -Load MrnNo PoNo when click BuyerPoNo

//Start -Load MrnNo Details to Body

	function loadMrnDetailsToGrid()
{	

	ClearTable('IssueItem');
	var MatId 	= document.getElementById('cboMainCategory').value;
	var IssLike = document.getElementById('txtIssueNo').value;
	
	showPleaseWait();
	var url ='genreturnxml.php?RequestType=loadMrnDetailsToGrid&MatId=' + MatId+'&IssLike='+IssLike;
	
	htmlobj=$.ajax({url:url,async:false});
	var itemDisI =htmlobj.responseXML.getElementsByTagName("ItemDescription")
		for ( var loop = 0; loop < itemDisI.length; loop ++)
		{
			var itemDis				=itemDisI[loop].childNodes[0].nodeValue;				 
			var XMLMatDetailID		=htmlobj.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
			var XMLMatCatID			=htmlobj.responseXML.getElementsByTagName("MatCatID")[loop].childNodes[0].nodeValue;
			var XMLunit				=htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
			var XMLIssueBalQty		=htmlobj.responseXML.getElementsByTagName("IssueBalQty")[loop].childNodes[0].nodeValue;
			var XMLIssueNo			=htmlobj.responseXML.getElementsByTagName("IssueNo")[loop].childNodes[0].nodeValue;
			var XMLIssueYear		=htmlobj.responseXML.getElementsByTagName("IssueYear")[loop].childNodes[0].nodeValue;
			var XMLGRNNo			=htmlobj.responseXML.getElementsByTagName("GrnNo")[loop].childNodes[0].nodeValue;
			var XMLcostCenterId		=htmlobj.responseXML.getElementsByTagName("costCenterId")[loop].childNodes[0].nodeValue;
			var XMLcostCenterDes	=htmlobj.responseXML.getElementsByTagName("costCenterDes")[loop].childNodes[0].nodeValue;
			/*var XMLGLCode			=htmlobj.responseXML.getElementsByTagName("GLCode")[loop].childNodes[0].nodeValue;
			var XMLGLAllowId		=htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;*/
			
			craeteGrid(itemDis,XMLMatDetailID,XMLMatCatID,XMLunit,XMLIssueBalQty,XMLIssueNo,XMLIssueYear,XMLGRNNo,XMLcostCenterId,XMLcostCenterDes/*,XMLGLCode,XMLGLAllowId*/); 
		}
	hidePleaseWait();		 

}
//End -Load MrnNo Details to Body
function craeteGrid(itemDis,XMLMatDetailID,XMLMatCatID,XMLunit,XMLIssueBalQty,XMLIssueNo,XMLIssueYear,XMLGRNNo,XMLcostCenterId,XMLcostCenterDes/*,GLCode,GLAllowId*/)
 {
    var tbl = document.getElementById('IssueItem');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	tbl.rows[lastRow].bgColor="#FFFFFF"; 
	
	
	var cellSelect = row.insertCell(0);
	cellSelect.id = XMLMatDetailID;
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+XMLMatDetailID+" value=\"checkbox\" /></div>";
	
	var cellDis=row.insertCell(1);
	cellDis.id=XMLMatCatID;
	cellDis.className="normalfntSM";
	cellDis.innerHTML=itemDis;
	
	var cellsxmlunit=row.insertCell(2);
	cellsxmlunit.className="normalfnt";
	cellsxmlunit.align="center";
	cellsxmlunit.innerHTML=XMLIssueNo;
	
	var cellsBalQty=row.insertCell(3);
	cellsBalQty.className="normalfntRite";
	cellsBalQty.align="center";
	cellsBalQty.innerHTML=XMLIssueYear;
	
	var cellsStockQty=row.insertCell(4);
	cellsStockQty.className="normalfntRite";
	cellsStockQty.align="center";
	cellsStockQty.innerHTML=XMLIssueBalQty;
	
	var cellsGRNNo=row.insertCell(5);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=XMLunit;
	
	var cellsGRNNo=row.insertCell(6);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=XMLGRNNo;
	
	/*var cellsGRNNo=row.insertCell(7);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.id=XMLcostCenterId;
	cellsGRNNo.innerHTML=XMLcostCenterDes;
	
	var cellsGRNNo=row.insertCell(8);
	cellsGRNNo.className="normalfntMid";
	cellsGRNNo.id=GLAllowId;
	cellsGRNNo.innerHTML=GLCode;*/
	
}
//Start - Load details from frame to main issue page
function LoaddetailsTomainPage()
{	
	var tbl = document.getElementById('IssueItem');
	var testBin = 0 ;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{		
		var chkBx = tbl.rows[loop].cells[0].childNodes[0].childNodes[0];
		
		if (chkBx.checked)
		{
			var itemdDetail =  tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var itemdDetailID = tbl.rows[loop].cells[0].id;
			var issueNo = tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var issueYear = tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var Req_Qty =  tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var issue_Qty =  Req_Qty;
			var detIssNo = issueYear + "/" +  issueNo;
			
			var itmUnit = tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var grnNo 	= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			/*var costCenterId = tbl.rows[loop].cells[7].id;
			var costCenterDes = tbl.rows[loop].cells[7].childNodes[0].nodeValue;
			var GLAllowId = tbl.rows[loop].cells[8].id;
			var GLCode = tbl.rows[loop].cells[8].childNodes[0].nodeValue;*/
			
			var  tblIssueList = document.getElementById('tblIssueList');
			
				var booCheck =false;
				for (var mainLoop =1 ;mainLoop < tblIssueList.rows.length; mainLoop++ )
				{
					var mainItemDetailId = tblIssueList.rows[mainLoop].cells[2].id;
					var mainIssueNo = tblIssueList.rows[mainLoop].cells[1].lastChild.nodeValue;
					var GRNNo		= tblIssueList.rows[mainLoop].cells[6].lastChild.nodeValue;
					var strObjIssue = mainIssueNo.split("/");
					
   
   if ((mainItemDetailId==itemdDetailID) && (strObjIssue[1] == issueNo) && (GRNNo==grnNo))
					{
						alert("Sorry !\nItem : "+ itemdDetail + "\nAlready added.");
						booCheck =true;
						
					}	
				}
			
			if (booCheck == false)
			{
				var lastRow = tblIssueList.rows.length;	
				var row = tblIssueList.insertRow(lastRow);
				row.className="bcgcolor-tblrowWhite";
				var cellDelete = row.insertCell(0);  
				cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
				
				var cellIssuelist = row.insertCell(1);
				cellIssuelist.classname ="normalfnt";
				cellIssuelist.id =testBin;
				cellIssuelist.innerHTML = detIssNo;
				
				var cellIssuelist = row.insertCell(2);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id=itemdDetailID;
				cellIssuelist.innerHTML = itemdDetail;
				
				var cellIssuelist = row.insertCell(3);			
				cellIssuelist.innerHTML="<input type=\"text\" size=\"15\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+Req_Qty+"\" onfocus=\"GetQty(this);\" onkeypress=\"return isNumberKey(event);\" onchange=\"SetItemQuantity(this," + mainArrayIndex  + ");\" style=\"text-align:right\" onkeyup=\"ValidateQty(this);\"/>";

				var cellIssuelist = row.insertCell(4);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =Req_Qty;
				
				var cellIssuelist = row.insertCell(5);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =itmUnit;
				
				var cellGRNNO = row.insertCell(6);
				cellGRNNO.className ="normalfntMid";
				cellGRNNO.innerHTML =grnNo;
				
				/*var cellCostCenter = row.insertCell(7);
				cellCostCenter.className ="normalfntMid";
				cellCostCenter.id		 = costCenterId;
				cellCostCenter.innerHTML = costCenterDes;
				
				var cellCostCenter = row.insertCell(8);
				cellCostCenter.className ="normalfntMid";
				cellCostCenter.id		 = GLAllowId;
				cellCostCenter.innerHTML = GLCode;*/
				
				// Saving Data
				var details = [];
				details[0] =   itemdDetailID; // Mat ID
				details[1] = 0; // Default Qty
				details[2] = detIssNo; //mrnNo				
				details[3] = itmUnit; //unit
				details[4] = Req_Qty; //unit
				details[5] = issue_Qty; //unit
				details[6] = grnNo;
				/*details[7] = costCenterId;
				details[8] = GLAllowId;*/
				
				Materials[mainArrayIndex] = details;
				mainArrayIndex ++ ;
				}
		}
		testBin++;
	}
closeWindow();
}
//End - Load details from frame to main issue page

function SetItemQuantity(obj,index)
{
		var rw = obj.parentNode.parentNode;
		Materials[index][4] = parseFloat(rw.cells[3].childNodes[0].value);
		Materials[index][6] = parseFloat(rw.cells[4].lastChild.nodeValue);
		//alert (Materials[index][6]);
}
function ValidateQty(obj)
{
	var rw 					= obj.parentNode.parentNode;
	var returnQty 			= parseFloat(rw.cells[3].childNodes[0].value);	
	var issueQty 			= parseFloat(rw.cells[4].childNodes[0].nodeValue);
	
	if(returnQty>issueQty)
	{		
		rw.cells[3].childNodes[0].value=issueQty;
	}	
}
function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var reqQty = rw.cells[4].lastChild.nodeValue;
	var issueQty =rw.cells[3].childNodes[0].value;			
	if ((issueQty=="") ||(issueQty==0))
	{
		rw.cells[3].childNodes[0].value =reqQty;
	}
}
//****************************************************BIN PART**************************************************************************
//Start-Show Bin Item form after click add bin button in main issue.php form

//Start - bin qty validate part
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItems');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[3].childNodes[0].childNodes[0].checked)
	{
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[1].lastChild.nodeValue);
		var issueQty = rw.cells[2].childNodes[0].value;
		
		rw.cells[2].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[3].childNodes[0].childNodes[0].checked)
					{		
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[2].childNodes[0].value);
					}				
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[2].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[2].childNodes[0].value = reduceQty;
					}
					
	}
	
	else 
		rw.cells[2].childNodes[0].value = 0;
}
//End - bin qty validate part

//END-*****************************************************************BIN PART**************************************************************************************

//Start - Load saved details in when click Search button in issues list.php form
/*function LoadSavedDetails()
{
	
	var strIssueNoFrom = document.getElementById('cboissuenofrom').options[document.getElementById('cboissuenofrom').selectedIndex].text;
	var strIssueNoTo =document.getElementById('cboissuenoto').options[document.getElementById('cboissuenoto').selectedIndex].text;
	var issuedatefrom = document.getElementById('fromDate').value;
	var issuedateto = document.getElementById('toDate').value;
	var ReportSatus = document.getElementById('cboReportSatus').value;
		
	var chkdate = document.getElementById('chkdate').checked;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadsaveDetailsRequest;
	xmlHttp.open("GET",'genreturnxml.php?RequestType=GetLoadSavedDetails&strIssueNoFrom=' + strIssueNoFrom + '&strIssueNoTo=' + strIssueNoTo + '&chkdate=' + chkdate + '&issuedatefrom=' + issuedatefrom + '&issuedateto=' + issuedateto + '&ReportSatus=' + ReportSatus , true);
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
				var XMLintStatus = xmlHttp.responseXML.getElementsByTagName("intStatus");
				var XMLdepartment = xmlHttp.responseXML.getElementsByTagName("department");
				
								
				 var strText =  "<table id=\"tblIssueDetails\" width=\"932\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								"<tr class=\"mainHeading4\">"+
								  "<td width=\"21%\" height=\"33\" >Return No</td>"+
								  "<td width=\"37%\" >Date</td>"+
								  "<td width=\"21%\" >Returned By</td>"+
								  "<td width=\"21%\" >View</td>"+
								 "</tr>";
				for (var loop =0; loop < XMLIssueNo.length; loop ++)	
				{
					var Url ="genreturn.php?id=1&GenReturnNo="+XMLIssueNo[loop].childNodes[0].nodeValue+"&intStatus="+XMLintStatus[loop].childNodes[0].nodeValue;					
					strText +="<tr class=\"bcgcolor-tblrowWhite\">"+
								  "<td class=\"normalfntMid\"><a href=\""+Url+"\" target=\"_blank\">"+XMLIssueNo[loop].childNodes[0].nodeValue+"</a></td>"+
								  "<td class=\"normalfntMid\">"+XMLIssuedDate[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfnt\">"+XMLdepartment[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\"><a href=\"genreturnnote.php?issueNo=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\" class=\"non-html pdf\" target=\"_blank\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></a></td>"+
								  "</tr>";
				}
				strText += "</table>";
				document.getElementById("divtblIssueDetails").innerHTML=strText;
			}
		}		
	}*/
function saveIssuedetails()
{	
	validateCount = 0;
	validateBinCount = 0;
	var productionId = document.getElementById('cboreturnedby').value;
	
	createXMLHttpRequest();
	xmlHttp.open("GET" ,'genreturnxml.php?RequestType=SaveIssueHeader&issueNo=' + issueNo + '&issueYear=' + issueYear + '&productionId=' + productionId   ,true)
	xmlHttp.send(null);	 		
	
	var tbl				= document.getElementById('tblIssueList');
	
	 for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var rw		= tbl.rows[loop];
			var itemdDetailID = rw.cells[2].id;
			var qty = rw.cells[3].childNodes[0].value;
			var issueno  = rw.cells[1].childNodes[0].nodeValue;
			var itmUnit =  rw.cells[5].childNodes[0].nodeValue;
			var grnNo	= rw.cells[6].childNodes[0].nodeValue;
			/*var costCenterId = rw.cells[7].id;
			var GLAllowId = rw.cells[8].id;*/
			
			validateCount++;
			
			createXMLHttpRequest();
				xmlHttp.open("GET",'genreturnxml.php?RequestType=SaveIssueDetails&issueNo=' + issueNo+ '&issueYear=' + issueYear + '&issueno=' + issueno + '&itemdDetailID=' + itemdDetailID + '&qty=' + qty + '&itmUnit=' + itmUnit+ '&grnNo=' + grnNo/*+ '&costCenterId=' + costCenterId+ '&GLAllowId=' + GLAllowId*/, true);
				
				xmlHttp.send(null);
			
		}
	ResponseValidate();	
}
//End -Save part with arrays

//Start -Get new Issue No from setting tables 
function saveReturnData()
{
	if(!saveValidation())
	return;
	var returnNo = document.getElementById("txtreturnNo").value
	if(returnNo=="")
	{
		getIssueNo();
	}
	else
	{
		var noArray 	= returnNo.split("/");		
		issueNo 		= parseInt(noArray[1]);
		issueYear 		= parseInt(noArray[0]);
		
		saveIssuedetails();
	}
}

function getIssueNo()
{	
	showPleaseWait();
	document.getElementById('Save').style.display = "none";
	
	var url ='genreturnxml.php?RequestType=LoadNo';
	htmlobj = $.ajax({url:url,async:false});
	var XMLissueNo = htmlobj.responseXML.getElementsByTagName("issueNo");
	
	issueNo = parseInt(XMLissueNo[0].childNodes[0].nodeValue);				
	issueYear = parseInt(new Date().getFullYear());
				
	document.getElementById("txtreturnNo").value = issueYear +  "/"  + issueNo ;			
	saveIssuedetails();
}
//End -Load MrnNo PoNo when click BuyerPoNo
function saveValidation()
{
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboreturnedby").value=="")	
	{
		alert ("Please Select 'Returned By' Before Save");
		document.getElementById('Save').style.display = "inline";
		hidePleaseWait();
		return false;
	}
	if(tbl.rows.length<=1) 
	{
		alert("No Details To Save");
		document.getElementById('Save').style.display = "inline";
		hidePleaseWait();
		return false;
	}

	for (loop = 1 ;loop < tbl.rows.length; loop++)
	{
		var issueQty = parseFloat(tbl.rows[loop].cells[4].childNodes[0].nodeValue);
		var returnQty = parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
		
			if ((returnQty=="")  || (returnQty==0))
			{
				alert ("Return Qty Can't Be '0' Or Empty in line no :"+loop);
				document.getElementById('Save').style.display = "inline";
				hidePleaseWait();
				return false;
				break;
			}
			if (returnQty>issueQty)
			{
				alert ("Return Qty Can't Be greater than issue Qty in line no :"+loop);
				document.getElementById('Save').style.display = "inline";
				hidePleaseWait();
				return false;
				break;
			}					
	}
	return true;
}
//Start-Validate save datails
function ResponseValidate()
{
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = ResponseValidateRequest;
	xmlHttp.open("GET" ,'genreturnxml.php?RequestType=ResponseValidate&issueNo=' + issueNo + '&Year=' + issueYear + '&validateCount=' + validateCount,true);
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
						alert ("Return No :" + document.getElementById("txtreturnNo").value +  " Saved Successfully!");
						document.getElementById('Save').style.display = "inline";
						ClearTable('tblIssueList');
						loadGenReturnData(issueNo,issueYear,0);
						hidePleaseWait();
						
					}
					else 
					{
						ResponseValidate();
					}			
			}
		}
	}
//End-Validate save datails

//Start - open report usimg popup window 
function showReport()
{
	var IssueNo = document.getElementById("txtreturnNo").value;
	if(IssueNo!="")
	{	
		newwindow=window.open('genreturnnote.php?issueNo='+IssueNo,'name');
			if (window.focus) {newwindow.focus()}
	}
	else
	{
		alert("No saved record to view report.");
		return;
	}
}
//End - open report usimg popup window

function SelectAll(obj)
{

	var tbl = document.getElementById('IssueItem');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(obj.checked){
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = true;
		}
		else
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked= false;			
	}	
}

//------------------------06/05/2011------------lahiru ------------------------------

function OpenItemPopUp()
{
			
	showBackGround('divBG',0);
	var url = "genreturnpopup.php?";
		
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(805,378,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	//fix_header('tblPopItem',550,388);	
}

function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function confirmRetun()
{
	showPleaseWait();
	document.getElementById('butConfirm').style.display = 'none';
	document.getElementById('Save').style.display = 'none';
	if(document.getElementById('txtreturnNo').value == '')
	{
		alert("Gatepass No not available");
		hidePleaseWait();
		document.getElementById('butConfirm').style.display = 'inline';
		document.getElementById('Save').style.display = 'inline';
		return;
	}
	
	var tbl				= document.getElementById('tblIssueList');
	var returnNo 		= $('#txtreturnNo').val();
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var rw		= tbl.rows[loop];
		var itemdDetailID = rw.cells[2].id;
		var qty = rw.cells[3].childNodes[0].value;
		var issueno  = rw.cells[1].childNodes[0].nodeValue;
		var itmUnit =  rw.cells[5].childNodes[0].nodeValue;
		var grnNo	= rw.cells[6].childNodes[0].nodeValue;
		/*var costCenterId = rw.cells[7].id;
		var GLAllowId = rw.cells[8].id;*/

		var url ='genreturnxml.php?RequestType=confirmRetun&returnNo=' + returnNo+ '&itemdDetailID=' + itemdDetailID + '&qty=' + qty + '&itmUnit=' + itmUnit+ '&grnNo=' + grnNo/*+ '&costCenterId=' + costCenterId+ '&GLAllowId=' + GLAllowId*/;
		htmlobj = $.ajax({url:url,async:false});
		
		var responceConfirm		=htmlobj.responseXML.getElementsByTagName("responceConfirm")[0].childNodes[0].nodeValue;
	
	}
	if(responceConfirm=="TRUE")
		{
			alert("Confirmed successfully.");
			hidePleaseWait();
		}
		else
		{
			alert("Error in confirming.");
			hidePleaseWait();
			document.getElementById('butConfirm').style.display = 'inline';
			document.getElementById('Save').style.display = 'inline';
			return;
		}
		
}
function loadGenReturnData(GPNo,GPyear,status)
{
	if(GPNo !=0)
	{
		var url = "genreturnxml.php?RequestType=loadGenReturnHeaderDetails&status="+status+"&GPNo="+GPNo+"&GPyear="+GPyear;
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById('txtreturnNo').value = GPyear+'/'+GPNo;
		document.getElementById('txtdate').value = htmlobj.responseXML.getElementsByTagName("ReturneDate")[0].childNodes[0].nodeValue;
		document.getElementById('cboreturnedby').value = htmlobj.responseXML.getElementsByTagName("ReturnedBy")[0].childNodes[0].nodeValue;
	
	loadReturnDetails(GPNo,GPyear,status);
		switch(parseInt(status))
		{
			case 0:
			{
				document.getElementById('Save').style.display = 'inline';
				document.getElementById('butConfirm').style.display = 'inline';
				break;
			}
			case 1:
			{
				document.getElementById('Save').style.display = 'none';
				document.getElementById('butConfirm').style.display = 'none';
				break;
			}
		}
	}
}
function loadReturnDetails(GPNo,GPyear,status)
{
	var url = "genreturnxml.php?RequestType=loadGenReturnDetailsData&status="+status+"&GPNo="+GPNo+"&GPyear="+GPyear;
	htmlobj = $.ajax({url:url,async:false});
	var  tblIssueList = document.getElementById('tblIssueList');
	var testBin = 0 ;
	var itemDisI =htmlobj.responseXML.getElementsByTagName("ItemDescription")
		for ( var loop = 0; loop < itemDisI.length; loop ++)
		{
			var itemDis				=itemDisI[loop].childNodes[0].nodeValue;				 
			var XMLMatDetailID		=htmlobj.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
			var XMLunit				=htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
			var XMLRetQty			=htmlobj.responseXML.getElementsByTagName("RetQty")[loop].childNodes[0].nodeValue;
			var XMLIssueQty			=htmlobj.responseXML.getElementsByTagName("IssueQty")[loop].childNodes[0].nodeValue;
			var XMLgrnNo			=htmlobj.responseXML.getElementsByTagName("grnNo")[loop].childNodes[0].nodeValue;
			var XMLgrnYear			=htmlobj.responseXML.getElementsByTagName("grnYear")[loop].childNodes[0].nodeValue;
			var XMLIssueNo			=htmlobj.responseXML.getElementsByTagName("IssueNo")[loop].childNodes[0].nodeValue;
			var XMLIssYear			=htmlobj.responseXML.getElementsByTagName("IssYear")[loop].childNodes[0].nodeValue;
			/*var XMLcostCenterId		=htmlobj.responseXML.getElementsByTagName("CostCenterId")[loop].childNodes[0].nodeValue;
			var XMLcostCenterDes	=htmlobj.responseXML.getElementsByTagName("CostCenterDes")[loop].childNodes[0].nodeValue;
			var XMLGLAllowId		=htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;
			var XMLGLCode			=htmlobj.responseXML.getElementsByTagName("GLCode")[loop].childNodes[0].nodeValue;*/
			
			createMainGrid(tblIssueList,testBin,itemDis,XMLMatDetailID,XMLunit,XMLRetQty,XMLIssueQty,XMLgrnNo,XMLgrnYear,XMLIssueNo,XMLIssYear/*,XMLcostCenterId,XMLcostCenterDes,XMLGLAllowId,XMLGLCode*/);
			testBin++;
		}
}
function createMainGrid(tblIssueList,testBin,itemDis,XMLMatDetailID,XMLunit,XMLRetQty,XMLIssueQty,XMLgrnNo,XMLgrnYear,XMLIssueNo,XMLIssYear/*,XMLcostCenterId,XMLcostCenterDes,GLAllowId,GLCode*/)
{
		var lastRow = tblIssueList.rows.length;	
		var row = tblIssueList.insertRow(lastRow);
		row.className="bcgcolor-tblrowWhite";
		var cellDelete = row.insertCell(0);  
		cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
		
		var cellIssuelist = row.insertCell(1);
		cellIssuelist.classname ="normalfnt";
		cellIssuelist.id =testBin;
		cellIssuelist.innerHTML = XMLIssYear+"/"+XMLIssueNo;
		
		var cellIssuelist = row.insertCell(2);
		cellIssuelist.className = "normalfnt";
		cellIssuelist.id=XMLMatDetailID;
		cellIssuelist.innerHTML = itemDis;
		
		var cellIssuelist = row.insertCell(3);			
		cellIssuelist.innerHTML="<input type=\"text\" size=\"15\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+XMLRetQty+"\" onfocus=\"GetQty(this);\" onkeypress=\"return isNumberKey(event);\" onchange=\"SetItemQuantity(this," + mainArrayIndex  + ");\" style=\"text-align:right\" onkeyup=\"ValidateQty(this);\"/>";

		var cellIssuelist = row.insertCell(4);
		cellIssuelist.className ="normalfntRite";
		cellIssuelist.innerHTML =XMLIssueQty;
		
		var cellIssuelist = row.insertCell(5);
		cellIssuelist.className ="normalfntMid";
		cellIssuelist.innerHTML =XMLunit;
		
		var cellGRNNO = row.insertCell(6);
		cellGRNNO.className ="normalfntMid";
		cellGRNNO.innerHTML =XMLgrnYear+"/"+XMLgrnNo;
		
		/*var cellCostCenter = row.insertCell(7);
		cellCostCenter.className ="normalfntMid";
		cellCostCenter.id		 = XMLcostCenterId;
		cellCostCenter.innerHTML = XMLcostCenterDes;
		
		var cellCostCenter = row.insertCell(8);
		cellCostCenter.className ="normalfntMid";
		cellCostCenter.id		 = GLAllowId;
		cellCostCenter.innerHTML = GLCode;*/
		
		// Saving Data
		var details = [];
		details[0] =   XMLMatDetailID; // Mat ID
		details[1] = 0; // Default Qty
		details[2] = XMLIssYear+"/"+XMLIssueNo; //mrnNo				
		details[3] = XMLunit; //unit
		details[4] = XMLRetQty; //unit
		details[5] = XMLIssueQty; //unit
		details[6] = XMLgrnYear+"/"+XMLgrnNo;
		/*details[7] = XMLcostCenterId;
		details[8] = GLAllowId;*/
		
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
}