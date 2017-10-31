var xmlHttp;
var xmlHttp1=[];
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


function ShowItems()
{
 	var supplierId		= document.getElementById('cboreturnedby').value;
	if(supplierId=="")
	{
		alert("Please select the supplier.");
		document.getElementById('cboreturnedby').focus();
		return;
		
	}
	
		showBackGround('divBG',0);
		var url = "itempopup.php?";
		
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(856,340,'frmSupplierItemPopup',1);
		document.getElementById('frmSupplierItemPopup').innerHTML = htmlobj.responseText;


}

//Start -Load Materials 
function LoadMaterials()
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = MaterialsRequest;
	altxmlHttp.open("GET", 'gensupplierreturnxml.php?RequestType=LoadMaterial', true);
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
		xmlHttp1[1].open("GET", 'gensupplierreturnxml.php?RequestType=loadSubCategory&mainCatId='+mainCatId, true);
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


//Start -Load MrnNo Details to Body
function loadMrnDetailsToGrid()
{	

	ClearTable('IssueItem');
	var MatId =document.getElementById('cbomaterial').value;
	var CatId =document.getElementById('cboSubCategory').value;
	var IssLike = document.getElementById('txtisslike').value;
	var supplierId = document.getElementById('cboreturnedby').value;
	
	showPleaseWait();
	var url ='gensupplierreturnxml.php?RequestType=loadMrnDetailsToGrid&MatId=' + MatId + '&CatId=' + CatId + '&IssLike=' + IssLike + '&supplierId=' + supplierId;
	
	htmlobj=$.ajax({url:url,async:false});
	
	var itemDisI =htmlobj.responseXML.getElementsByTagName("ItemDescription")
		for ( var loop = 0; loop < itemDisI.length; loop ++)
		{
			var itemDis				=itemDisI[loop].childNodes[0].nodeValue;				 
			var XMLMatDetailID		=htmlobj.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
			var XMLUnit				=htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
			var XMLGrnBalance		=htmlobj.responseXML.getElementsByTagName("GrnBalance")[loop].childNodes[0].nodeValue;
			//var XMLMatMainID		=htmlobj.responseXML.getElementsByTagName("MatMainID")[loop].childNodes[0].nodeValue;
			var XMLStockQty			=htmlobj.responseXML.getElementsByTagName("StockQty")[loop].childNodes[0].nodeValue;
			var XMLGrnNo			=htmlobj.responseXML.getElementsByTagName("GrnNo")[loop].childNodes[0].nodeValue;
			/*var XMLGLAllowId		=htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;
			var XMLGLCode			=htmlobj.responseXML.getElementsByTagName("GLCode")[loop].childNodes[0].nodeValue;
			var XMLCostCenter		=htmlobj.responseXML.getElementsByTagName("costCenter")[loop].childNodes[0].nodeValue;*/
			
			if(XMLGrnBalance>0)
				craeteGrid(itemDis,XMLMatDetailID,XMLUnit,XMLGrnBalance,XMLStockQty,XMLGrnNo/*,XMLGLAllowId,XMLGLCode,XMLCostCenter*/); 
		}
	hidePleaseWait();	
}

function craeteGrid(itemDis,XMLMatDetailID,XMLUnit,XMLGrnBalance,XMLStockQty,XMLGrnNo/*,XMLGLAllowId,XMLGLCode,XMLCostCenter*/)
{
    var tbl = document.getElementById('IssueItem');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	tbl.rows[lastRow].bgColor="#FFFFFF"; 
	
	
	var cellSelect = row.insertCell(0);
	cellSelect.height = "20";
	cellSelect.id = XMLMatDetailID;
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+XMLMatDetailID+" value=\"checkbox\" /></div>";
	
	var cellDis=row.insertCell(1);
	cellDis.className="normalfntSM";
	/*cellDis.id		 = XMLCostCenter;*/
	cellDis.innerHTML=XMLGrnNo;
	
	var cellsxmlunit=row.insertCell(2);
	cellsxmlunit.className="normalfnt";
	cellsxmlunit.align="center";
	cellsxmlunit.innerHTML=itemDis;
	
	var cellsBalQty=row.insertCell(3);
	cellsBalQty.className="normalfntRite";
	cellsBalQty.align="center";
	cellsBalQty.innerHTML=XMLUnit;
	
	var cellsStockQty=row.insertCell(4);
	cellsStockQty.className="normalfntRite";
	cellsStockQty.align="center";
	cellsStockQty.innerHTML=XMLGrnBalance;
	
	var cellsGRNNo=row.insertCell(5);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=XMLStockQty;
	
	/*var cellsGLCode=row.insertCell(6);
	cellsGLCode.className="normalfntMid";
	cellsGLCode.id		 = XMLGLAllowId;
	cellsGLCode.innerHTML=XMLGLCode;*/
	
}

//End -Load MrnNo Details to Body

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
			var itemdDetail 	= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var itemdDetailID 	= tbl.rows[loop].cells[0].id;
			var grnNo 			= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var costcenter 		= tbl.rows[loop].cells[1].id;
			var grnQty	 		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var stockBalance	= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var itmUnit 		= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			/*var GLAllowId 		= tbl.rows[loop].cells[6].id;
			var GLCode 			= tbl.rows[loop].cells[6].childNodes[0].nodeValue;*/
			//var detIssNo 		= issueYear + "/" +  issueNo;	
			
			var  tblIssueList = document.getElementById('tblIssueList');
			

				var booCheck =false;
				for (var mainLoop =1 ;mainLoop < tblIssueList.rows.length; mainLoop++ )
				{
					var mainItemDetailId 	= tblIssueList.rows[mainLoop].cells[2].id;
					var mainGrnNo 			= tblIssueList.rows[mainLoop].cells[1].lastChild.nodeValue;

					if ((mainItemDetailId==itemdDetailID) && (mainGrnNo == grnNo))
					{
						alert("Sorry!\nItem : "+ itemdDetail +" already added.")
						booCheck =true;
					}	
				}
			
			if (booCheck == false)
			{
				var lastRow = tblIssueList.rows.length;	
				var row = tblIssueList.insertRow(lastRow);
				
				row.className="bcgcolor-tblrowWhite";
					
				
				var cellDelete = row.insertCell(0);   
				cellDelete.id = testBin
				cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
				
				var cellIssuelist = row.insertCell(1);
				cellIssuelist.classname ="normalfntMid";
				cellIssuelist.id =testBin;
				cellIssuelist.innerHTML = grnNo;
				
				var cellIssuelist = row.insertCell(2);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id=itemdDetailID;
				cellIssuelist.innerHTML = itemdDetail;
				
				var cellIssuelist = row.insertCell(3);
				cellIssuelist.className = "normalfntMid";
				cellIssuelist.innerHTML="<input type=\"text\" size=\"15\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\"0\" onfocus=\"GetQty(this);\" onkeypress=\"return isNumberKey(event);\"  onkeyup=\"ValidateQty(this);SetItemQuantity(this," + mainArrayIndex  + ")\" style=\"text-align:right\" />";			
				var cellIssuelist = row.insertCell(4);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =itmUnit;
				
				var cellIssuelist = row.insertCell(5);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =grnQty;
				
				var cellIssuelist = row.insertCell(6);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =stockBalance;
				
				/*var cellIssuelist = row.insertCell(7);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id	    =GLAllowId;
				cellIssuelist.innerHTML =GLCode;*/
				
		
				// Saving Data
				var details = [];
				details[0] 	= itemdDetailID; // Mat ID				
				details[1] 	= grnNo; //mrnNo
				details[2] 	= itmUnit; //Unit
				details[3] 	= 0; //Unit	
				/*details[4] 	= GLAllowId; //GLAllowId		
				details[5] 	= costcenter; //costcenter*/
				Materials[mainArrayIndex] = details;
				mainArrayIndex ++ ;
				}
		}
	}
	testBin++;
CloseOSPopUp('popupLayer1');
}
//End - Load details from frame to main issue page

function SetItemQuantity(obj,index)
{
		var rw = obj.parentNode.parentNode;
		Materials[index][3] = parseFloat(rw.cells[3].childNodes[0].value);		
}

function ValidateQty(obj)
{
	var rw 				= obj.parentNode.parentNode;
	var grnQty 			= parseFloat(rw.cells[5].lastChild.nodeValue);
	var stockBalance 	= parseFloat(rw.cells[6].lastChild.nodeValue);
	var returnQty 		= parseFloat(rw.cells[3].childNodes[0].value);	
	
	if(rw.cells[3].childNodes[0].value=="")
	{
		rw.cells[3].childNodes[0].value=0;
	}
	else if(stockBalance>grnQty)
	{
		if(returnQty>grnQty)
			rw.cells[3].childNodes[0].value=grnQty;
	}
	else
	{
		if(returnQty>stockBalance)
			rw.cells[3].childNodes[0].value=stockBalance;
	}
}

function GetQty(obj)
{
	/*var rw 				= obj.parentNode.parentNode;
	var grnQty 			= parseFloat(rw.cells[5].lastChild.nodeValue);
	var stockBalance 	= parseFloat(rw.cells[6].lastChild.nodeValue);
	if(rw.cells[3].childNodes[0].value==""){
		rw.cells[3].childNodes[0].value=0;
	}
	var returnQty 		= parseFloat(rw.cells[3].childNodes[0].value);
		if(returnQty==""){
		rw.cells[3].childNodes[0].value=0;
	}
//alert(rw.cells[4].childNodes[0].value);
//-------------------------
	var matID 		= parseFloat(rw.cells[2].id);	
	var tblMain=document.getElementById('tblIssueList');
	var rowCount=tblMain.rows.length;
	
	var totRurnQty=0;
	for(var i=1;i<rowCount;i++)
	{
		if(matID==parseFloat(tblMain.rows[i].cells[2].id)){
		totRurnQty=totRurnQty+parseFloat(tblMain.rows[i].cells[3].childNodes[0].value);
		}
//	alert(totRurnQty);

	}
	stockBalance=stockBalance-totRurnQty;
	//alert(totRurnQty);
	
	
	if((returnQty==0) || (returnQty=="")){
	if(stockBalance>grnQty){
			rw.cells[3].childNodes[0].value=grnQty;
	}
	else{
			rw.cells[3].childNodes[0].value=stockBalance;
	}
	}*/
}

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
	xmlHttp.open("GET",'gensupplierreturnxml.php?RequestType=GetLoadSavedDetails&issueNoFrom=' + issueNoFrom + '&issueYearFrom=' + issueYearFrom + '&issueNoTo=' + issueNoTo + '&issueYearTo=' + issueYearTo + '&issueDateFrom=' + issueDateFrom + '&issueDateTo=' + issueDateTo + '&chkbox=' + chkbox , true);
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
								
				var strText =  "<table id=\"tblIssueDetails\" width=\"932\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								"<tr class=\"mainHeading4\">"+
								  "<td width=\"21%\" height=\"33\" >Supplier Return No</td>"+
								  "<td width=\"37%\" >Date</td>"+
								  "<td width=\"21%\" >Supplier</td>"+
								  "<td width=\"21%\" >View</td>"+
								 "</tr>";
				for (var loop =0; loop < XMLIssueNo.length; loop ++)	
				{
					strText +="<tr class=\"bcgcolor-tblrowWhite\">"+
								  "<td class=\"normalfntMid\">"+XMLIssueNo[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\">"+XMLIssuedDate[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\">"+XMLSecurityNo[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\"><a target=\"_blank\" href=\"gensupreturnnote.php?issueNo=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></a></td>"+
								  "</tr>";
				}
				strText += "</table>";
				document.getElementById("divtblIssueDetails").innerHTML=strText;
			}
		}		
	}
//End - Load saved details in when click Search button in issues list.php form

//Start -Save part with arrays
/*function saveBinDetails()
{
	//alert ("Bin Allocated!!!!");
}*/

function saveIssuedetails()
{
	validateCount = 0;
	validateBinCount = 0;
	var productionId = document.getElementById('cboreturnedby').value;
	var reason		 = document.getElementById('txtReason').value.trim();
	createXMLHttpRequest();
	xmlHttp.open("GET" ,'gensupplierreturnxml.php?RequestType=SaveHeader&issueNo=' + issueNo + '&issueYear=' + issueYear + '&productionId=' + productionId + '&reason=' +URLEncode(reason)   ,true)
	xmlHttp.send(null);	 		
	//alert(Materials[0][4]);
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{
		var details = Materials[loop] ;
		
		if 	(details!=null)
		{
			var itemdDetailID 	= details[0];  	
			var grnNo  			= details[1];
			var units	 		= details[2];
			var returnQty 		= details[3]; 
			/*var GLAllowId 		= details[4]; 
			var costCenter 		= details[5]; */
			
			validateCount++;
			
				createXMLHttpRequest();
				xmlHttp.open("GET",'gensupplierreturnxml.php?RequestType=SaveDetails&returnNo=' + issueNo + '&returnYear=' + issueYear + '&grnNo=' + grnNo + '&itemdDetailID=' + itemdDetailID + '&returnQty=' + returnQty + '&unit=' + units /*+ '&GLAllowId=' + GLAllowId + '&costCenter=' + costCenter*/, true);
				xmlHttp.send(null);
		}
	}	
	ResponseValidate();	
}
//End -Save part with arrays

//Start -Get new Issue No from setting tables 
function getIssueNo()
{
	showPleaseWait();
	document.getElementById('Save').style.display = "none";
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboreturnedby").value=="")	
	{
		alert ("Please Select 'Supplier' Before Save");	
		document.getElementById("cboreturnedby").focus();
		document.getElementById('Save').style.display = "inline";
		hidePleaseWait();
		
		return false;
	}
	if (document.getElementById("txtReason").value.trim()=="")	
	{
		alert ("Please enter a reason Before Save");	
		document.getElementById("txtReason").focus();
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
		var issueQty = tbl.rows[loop].cells[3].childNodes[0].value;
		
			if ((issueQty=="")  || (issueQty==0))
			{
				//alert ("Return Qty Can't Be '0' Or Empty.")
				return false;
				break;
			}			
		//Qty Validation
		var stockQty = tbl.rows[loop].cells[6].lastChild.nodeValue;
		//alert (issueQty +" : "+ stockQty);
		if (parseFloat(issueQty) > parseFloat(stockQty))
			{
				alert ("Return Qty Can't Exceed 'Stock Qty'")
				document.getElementById('Save').style.display = "inline";
				hidePleaseWait();
				return false;
				break;
			}	
	}
	
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = LoadIssueNoRequest;
	xmlHttp.open("GET" ,'gensupplierreturnxml.php?RequestType=LoadNo' ,true);
	xmlHttp.send(null);	
}
	function LoadIssueNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  			 
			 	var XMLissueNo 	= xmlHttp.responseXML.getElementsByTagName("No");
				var XMLYear 	= xmlHttp.responseXML.getElementsByTagName("Year");
				  issueNo 		= parseInt(XMLissueNo[0].childNodes[0].nodeValue);				
				  issueYear 	= parseInt(XMLYear[0].childNodes[0].nodeValue);
				
						document.getElementById("txtreturnNo").value = issueYear +  "/"  + issueNo ;			
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
	xmlHttp.open("GET" ,'gensupplierreturnxml.php?RequestType=ResponseValidate&issueNo=' + issueNo + '&Year=' + issueYear + '&validateCount=' + validateCount,true);
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
						alert ("Supplier Return No :" + document.getElementById("txtreturnNo").value +  " saved successfully!");	
						document.getElementById('Save').style.display = "none";
						document.getElementById("butAddNew").style.display="none";
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

function showReport()
{

	var issueNo = document.getElementById('txtreturnNo').value;
	if(issueNo=="" || issueNo=="0")
	{
	 alert("No supplier return No to preview.");
	 return;
	}
	else
	{	
		
		newwindow=window.open('gensupreturnnote.php?issueNo='+issueNo,'name');
		if (window.focus) {newwindow.focus()}
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
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}