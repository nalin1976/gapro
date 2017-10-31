var xmlHttp;
var mainArrayIndex = 0;
var Materials = [];
var issueNo = 0;
var issueYear = 0;
var validateCount = 0;
var validateBinCount =0;
var mainRw =0;
var intSelectedIssueLineNo = 0;
var dblIssueQty = 0;
var intGenItemCode;
var dblTotReqQty = 0;
var isNewOpen = true;

var ArrayGRN=[];
var ArrayIssueGRNList=[];
var intMRNCount = 0;
var intClickCnt = 0;
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
		mainRw--;
		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;		
		ArrayMRN[obj.id]==null;
		intClickCnt--;
	}
}
//End-Delete selected table row from the Table issue.php

//Start -Load MrnNo Details to Body
function loadMrnDetailsToGrid()
{	

	ClearTable('IssueItem');
	if(document.getElementById('cboPopMrnNo').value=="")
	{
		alert("Please select a MRN No");
		return false;
	}
	var strMrnNo 		= document.getElementById('cboPopMrnNo').options[document.getElementById('cboPopMrnNo').selectedIndex].text;
	var MatId 			= document.getElementById('cboMainCategory').value;
	
	showPleaseWait();
	var url ='genissuexml.php?RequestType=loadMrnDetailsToGrid&strMrnNo=' + strMrnNo + '&MatId=' + MatId;
	
	htmlobj=$.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	var itemDisI =htmlobj.responseXML.getElementsByTagName("ItemDescription")
		for ( var loop = 0; loop < itemDisI.length; loop ++)
		{
			var itemDis				=itemDisI[loop].childNodes[0].nodeValue;				 
			var XMLMatDetailID		=htmlobj.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
			var XMLunit				=htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
			var XMLBalQty			=htmlobj.responseXML.getElementsByTagName("BalQty")[loop].childNodes[0].nodeValue;
			var XMLMatMainID		=htmlobj.responseXML.getElementsByTagName("MatMainID")[loop].childNodes[0].nodeValue;
			var XMLStockQty			=htmlobj.responseXML.getElementsByTagName("StockQty")[loop].childNodes[0].nodeValue;
			var XMLGRNNo			=htmlobj.responseXML.getElementsByTagName("GRNNo")[loop].childNodes[0].nodeValue;
			var XMLDept				=htmlobj.responseXML.getElementsByTagName("Department")[loop].childNodes[0].nodeValue;
			var XMLcostCenterId		=htmlobj.responseXML.getElementsByTagName("costCenterId")[loop].childNodes[0].nodeValue;
			var XMLcostCenterDes	=htmlobj.responseXML.getElementsByTagName("costCenterDes")[loop].childNodes[0].nodeValue;
			var XMLMainCatDes		=htmlobj.responseXML.getElementsByTagName("MainCatDes")[loop].childNodes[0].nodeValue;
			var XMLItemCode         =htmlobj.responseXML.getElementsByTagName("ItemCode")[loop].childNodes[0].nodeValue; 
			/*var XMLGLCode		    =htmlobj.responseXML.getElementsByTagName("GLCode")[loop].childNodes[0].nodeValue;
			var XMLGLAllowId		=htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;*/
			
			craeteGrid(itemDis,XMLMatDetailID,XMLunit,XMLBalQty,XMLMatMainID,XMLStockQty,XMLGRNNo,XMLDept,XMLcostCenterId,XMLcostCenterDes,XMLMainCatDes/*,XMLGLCode,XMLGLAllowId*/, loop, XMLItemCode); 
		}
		
	ArrayGRN = new Array(loop);	
	intMRNCount++;
	//ArrayMRN[intMRNCount];
	
	hidePleaseWait();		 
	
	

}

  
 function craeteGrid(itemDis,XMLMatDetailID,XMLunit,XMLBalQty,XMLMatMainID,XMLStockQty,XMLGRNNo,XMLDept,XMLcostCenterId,XMLcostCenterDes,XMLMainCatDes/*,XMLGLCode,XMLGLAllowId*/, LineId, XMLItemCode)
 {
    var tbl = document.getElementById('IssueItem');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	tbl.rows[lastRow].bgColor="#FFFFFF"; 
	
	
	var cellSelect = row.insertCell(0);
	cellSelect.id = XMLMatDetailID;
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+XMLMatDetailID+" value=\"checkbox\" onclick=\" ValidateMRNQTY(this,"+LineId+",this.checked) \" /></div>";
	
	var cellDis=row.insertCell(1);
	cellDis.id=XMLMainCatDes;
	cellDis.className="normalfntSM";
	cellDis.innerHTML=itemDis;
	
	var cellsxmlunit=row.insertCell(2);
	cellsxmlunit.className="normalfnt";
	cellsxmlunit.align="center";
	cellsxmlunit.id = XMLDept;
	cellsxmlunit.innerHTML=XMLunit;
	
	var cellsBalQty=row.insertCell(3);
	cellsBalQty.className="normalfntRite";
	cellsBalQty.align="center";
	cellsBalQty.innerHTML=XMLBalQty;
	
	var cellsStockQty=row.insertCell(4);
	cellsStockQty.className="normalfntRite";
	cellsStockQty.align="center";
	cellsStockQty.innerHTML=XMLStockQty;
	
	/*var cellsGRNNo=row.insertCell(5);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=XMLGRNNo;*/
	
	/*var cellsGRNNo=row.insertCell(6);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML="<img src=\"../../images/location.png\" id="+XMLMatDetailID+" onclick='popUpGrnList(this,"+LineId+","+XMLBalQty+","+XMLMatDetailID+","+XMLStockQty+")'>";*/
	
	var cellsGRNNo=row.insertCell(5);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=XMLItemCode;
	
	/*var cellsGRNNo=row.insertCell(8);
	cellsGRNNo.className="normalfntRite";
	cellsGRNNo.align="center";
	cellsGRNNo.innerHTML=0;*/
	
	/*var cellsCSId=row.insertCell(6);
	cellsCSId.className="normalfntRite";
	cellsCSId.align="center";
	cellsCSId.id  = XMLcostCenterId; 
	cellsCSId.innerHTML=XMLcostCenterDes;
	
	var cellsCSId=row.insertCell(7);
	cellsCSId.className="normalfntMid";
	cellsCSId.align="center";
	cellsCSId.id  = XMLGLAllowId; 
	cellsCSId.innerHTML=XMLGLCode;*/
	
}
//End -Load MrnNo Details to Body


//Start - Load details from frame to main issue page
function LoaddetailsTomainPage()
{	
	var tbl = document.getElementById('IssueItem');
	var testBin = 0 ;
	var _iSelectedLine=0;

	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var checkitem=true;
		var chkBx = tbl.rows[loop].cells[0].childNodes[0].childNodes[0];
		
		if (chkBx.checked)
		{		
			var itemdDetail 	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var itemdDetailID 	= tbl.rows[loop].cells[0].id;
			var maincatName		= tbl.rows[loop].cells[1].id;	
			var Req_Qty	 	 	= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			//var Req_Qty	 	 	= tbl.rows[loop].cells[8].childNodes[0].nodeValue;
			var stockBalance 	= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var itmUnit 	 	= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			//var grnNo 	 		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var deptid	 		= tbl.rows[loop].cells[2].id;
			/*var costCenterDes 	= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var costCenterId	= tbl.rows[loop].cells[6].id;
			var GLCode		 	= tbl.rows[loop].cells[7].childNodes[0].nodeValue;
			var GLAllowId		= tbl.rows[loop].cells[7].id;*/
			
			//if(grnNo == '0/0'){alert('Select from which GRN items are issuing'); return;}
			
			
			var strMrnNo 		= document.getElementById('cboPopMrnNo').value;
			var tblIssueList 	= document.getElementById('tblIssueList');
			var booCheck =true;
				
				for (var mainLoop =1 ;mainLoop < tblIssueList.rows.length; mainLoop++ )
				{
//					
					var mainItemDetailId = tblIssueList.rows[mainLoop].cells[2].id;					
					var mainMrnNo = tblIssueList.rows[mainLoop].cells[6].lastChild.nodeValue;
					var grnno = tblIssueList.rows[mainLoop].cells[7].lastChild.nodeValue;

					if ((mainItemDetailId==itemdDetailID) && (mainMrnNo==strMrnNo) && (grnNo==grnno))
					{
						alert("Sorry !\nItem : "+ itemdDetail + "\nAlready added.");
						booCheck =false;
					}	
				}
//End -issue.php
			
			if (booCheck)
			{
				
				if(parseFloat(Req_Qty)>parseFloat(stockBalance)){
					
					Req_Qty = stockBalance;
				}
				
				
				var lastRow = tblIssueList.rows.length;	
				var row = tblIssueList.insertRow(lastRow);
				row.className="bcgcolor-tblrowWhite";
				
				
				var cellDelete = row.insertCell(0);   
				cellDelete.innerHTML = "<div align=\"center\"><img src=\"../../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";				
				
				var cellIssuelist = row.insertCell(1);
				cellIssuelist.classname ="normalfnt";
				cellIssuelist.id =testBin;
				cellIssuelist.innerHTML = maincatName;
				
				var cellIssuelist = row.insertCell(2);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id=itemdDetailID;
				cellIssuelist.innerHTML = itemdDetail;

				var cellIssuelist = row.insertCell(3);			
				cellIssuelist.innerHTML="<input type=\"text\" size=\"15\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+Req_Qty+"\" onfocus=\"GetQty(this);SetItemQuantity(this,"+ mainArrayIndex +");\" onkeypress=\"return isNumberKey(event);\" onchange=\"SetItemQuantity(this," + mainArrayIndex  + ");\" onkeyup=\"ValidateQty(this);\" style=\"text-align:right\"/>";

				var cellIssuelist = row.insertCell(4);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.id=stockBalance;
				cellIssuelist.innerHTML = Req_Qty;
				
				var cellIssuelist = row.insertCell(5);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML = stockBalance;
				
				var cellIssuelist = row.insertCell(6);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML = itmUnit;
			
				var cellIssuelist = row.insertCell(7);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML = strMrnNo;
				
				var cellIssuelist = row.insertCell(8);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id="gsel";
				//cellIssuelist.innerHTML = "<img src=\"../../images/location.png\" id="+itemdDetailID+" onclick='popUpGrnList("+itemdDetailID+","+mainRw+",0,0,"+stockBalance+")'>" ;
				cellIssuelist.innerHTML = "<img src=\"../../images/location.png\" id="+itemdDetailID+" >" ;
				//cellIssuelist.innerHTML = "<input type=\"button\" value=\"Add GRN\" onclick='testbtn()' />";
				
				/*var cellIssuelist = row.insertCell(7);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML = grnNo ;*/
				
				/*var cellIssuelist = row.insertCell(8);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id		=costCenterId;
				cellIssuelist.innerHTML = costCenterDes ;
				
				var cellIssuelist = row.insertCell(9);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id		=GLAllowId;
				cellIssuelist.innerHTML = GLCode ;*/
			
				// Saving Data
				var details = [];
				details[0] = itemdDetailID; // Mat ID
				details[1] = 0; // Default Qty
				details[2] = strMrnNo; //mrnNo
				details[3] = itmUnit; //Unit
				//details[4] = grnNo;
				/*details[5] = costCenterId;
				details[6] = GLAllowId;*/
				
				Materials[mainArrayIndex] = details;
				mainRw++;
				mainArrayIndex ++ ;
				}
				testBin ++ ;
		}
		
	}
	
	//ClearCell();
	// Add GRN selectable to the table		
	//AddGRNSelectToTable();
	///
	
	if(checkitem!=true)
	{
		alert("no record to add");
		return;
	}
	if(booCheck!=true)
	{
		alert("please select an issue item");
		return;
	}
	
	document.getElementById('cboprolineno').value=deptid;
	CloseOSPopUp('popupLayer1');
}
//End - Load details from frame to main issue page

function SetItemQuantity(obj,index)
{	
		var rw = obj.parentNode.parentNode;
		Materials[index][5] = parseFloat(rw.cells[3].childNodes[0].value);
}
function ValidateQty(obj)
{
	var rw 				= obj.parentNode.parentNode;
	var issueQty 		= parseFloat(rw.cells[3].childNodes[0].value);	
	var mrnQty 			= parseFloat(rw.cells[4].childNodes[0].nodeValue);	
	var stockBalance 	= parseFloat(rw.cells[4].id);
	
	if(stockBalance>mrnQty){
	if(issueQty>mrnQty){		
		rw.cells[3].childNodes[0].value=mrnQty;
	}
	}
	else{
	if(issueQty>stockBalance){		
		rw.cells[3].childNodes[0].value=stockBalance;
	}
	}
}

function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var reqQty 	= parseFloat(rw.cells[4].childNodes[0].nodeValue);
	var issueQty =rw.cells[3].childNodes[0].value;			
	/*if ((issueQty=="") ||(issueQty==0))
	{
		rw.cells[3].childNodes[0].value =reqQty;
	}*/
}

//Start - Load saved details in when click Search button in issues list.php form
/*function LoadSavedDetails()
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
	xmlHttp.open("GET",'genissuexml.php?RequestType=GetLoadSavedDetails&issueNoFrom=' + issueNoFrom + '&issueYearFrom=' + issueYearFrom + '&issueNoTo=' + issueNoTo + '&issueYearTo=' + issueYearTo + '&issueDateFrom=' + issueDateFrom + '&issueDateTo=' + issueDateTo + '&chkbox=' + chkbox , true);
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
				var XMLcompany = xmlHttp.responseXML.getElementsByTagName("company");
								
				 var strText =  "<table id=\"tblIssueDetails\" width=\"932\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								"<tr class=\"mainHeading4\">"+
								  "<td width=\"21%\" height=\"33\" >Issue No</td>"+
								  "<td width=\"35%\" >Date</td>"+
								  "<td width=\"30%\" >Issued To</td>"+
								  "<td width=\"40%\" >View</td>"+
								 "</tr>";
				for (var loop =0; loop < XMLIssueNo.length; loop ++)	
				{
					strText +="<tr class=\"bcgcolor-tblrowWhite\">"+
								  "<td class=\"normalfntMid\">"+XMLIssueNo[loop].childNodes[0].nodeValue+"</a></td>"+
								  "<td class=\"normalfntMid\">"+XMLIssuedDate[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\">"+XMLcompany[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\"><a href=\"genissuenote.php?issueNo=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\" class=\"non-html pdf\" target=\"_blank\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></a></td>"+
								  "</tr>";
				}
				strText += "</table>";
				document.getElementById("divtblIssueDetails").innerHTML=strText;
			}
		}		
	}*/
//End - Load saved details in when click Search button in issues list.php form

//Start -Save part with arrays
function saveBinDetails()
{
	//alert ("Bin Allocated!!!!");
}

function ValidateIsGRNSelected(){
	
	var tbl	= document.getElementById('tblIssueList');

	for (loop = 1; loop < tbl.rows.length ; loop ++)
	{
		var strColor = tbl.rows[loop].style.backgroundColor;
		
		if(strColor=='')
			return false;		
	}
	
	return true;
}

function saveIssuedetails()
{	
	
	
	
	
	validateCount = 0;
	validateBinCount = 0;
	var productionId = document.getElementById('cboprolineno').value;
	createXMLHttpRequest();
	xmlHttp.open("GET" ,'genissuexml.php?RequestType=SaveIssueHeader&issueNo=' + issueNo + '&issueYear=' + issueYear + '&productionId=' + productionId   ,true)
	xmlHttp.send(null);	 
	var tbl	= document.getElementById('tblIssueList');

	for (loop = 1; loop < tbl.rows.length ; loop ++)
	{
		
			var itemdDetailID 	= tbl.rows[loop].cells[2].id ;
			var qty	 			= tbl.rows[loop].cells[3].lastChild.value; 
			//var mrnNo  			= tbl.rows[loop].cells[6].childNodes[0].nodeValue;			
			var mrnNo  			= tbl.rows[loop].cells[7].childNodes[0].nodeValue;			
			var itmUnit 		= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var grnNo 			= 0;//tbl.rows[loop].cells[7].childNodes[0].nodeValue;
			/*var CostCenterId 	= tbl.rows[loop].cells[8].id;
			var GLAllowId 		= tbl.rows[loop].cells[9].id;*/
			//var grnYear = details[5];
			validateCount++;
			
		createXMLHttpRequest();		
		xmlHttp.open("GET",'genissuexml.php?RequestType=SaveIssueDetails&issueNo=' + issueNo + '&issueYear=' + issueYear + '&mrnNo=' + mrnNo + '&itemdDetailID=' + itemdDetailID + '&qty=' + qty + '&itmUnit=' + itmUnit + '&grnNo=' + grnNo/*+ '&CostCenterId=' + CostCenterId + '&GLAllowId=' + GLAllowId*/, true);
		xmlHttp.send(null);
		
		
		
		for(x=0;x<ArrayIssueGRNList.length;x++){
	
			for(j=0;j<ArrayIssueGRNList[x].length;j++){
				if(typeof(ArrayIssueGRNList[x][j])!='undefined'){
					
					var res = ArrayIssueGRNList[x][j].toString();
					var _arrResult = res.split(',');
					
					var _strGRNNo = _arrResult [0];
					var _dblQty = parseFloat(_arrResult[1]);
					var iGenItemCode = parseInt(_arrResult [2]);
					
					if(iGenItemCode == itemdDetailID){
							var url = 'genissuexml.php?RequestType=SaveGenStockTransaction&issueNo=' + issueNo + '&issueYear=' + issueYear + '&mrnNo=' + mrnNo + '&itemdDetailID=' + itemdDetailID + '&qty=' + _dblQty + '&itmUnit=' + itmUnit + '&grnNo=' + _strGRNNo
							
						htmlobj=$.ajax({url:url,async:false});
						
						//alert(htmlobj.reponseText);
					}
					
				}
			}
		
		}
		
		/*for(j=0;j<ArrayGRN.length;j++){
			if(typeof(ArrayGRN[j])!='undefined'){
				for(x=0;x<ArrayGRN[j].length;x++){
					if(typeof(ArrayGRN[j][x])!='undefined'){
						var res = ArrayGRN[j][x].toString();
						var arr = res.split(',');
											
						var _strGRNNo = arr[0];
						var _dblQty = arr[1];
						var iGenItemCode = parseInt(arr[2]);
						
						if(iGenItemCode == itemdDetailID){
							var url = 'genissuexml.php?RequestType=SaveGenStockTransaction&issueNo=' + issueNo + '&issueYear=' + issueYear + '&mrnNo=' + mrnNo + '&itemdDetailID=' + itemdDetailID + '&qty=' + _dblQty + '&itmUnit=' + itmUnit + '&grnNo=' + _strGRNNo
							
							htmlobj=$.ajax({url:url,async:false});
							
							alert(htmlobj.reponseText);
						}
					}
				}
			}
		}*/
		
		/*for(j=0;j<ArrayMRN.length;j++){
			if(typeof(ArrayMRN[j])!='undefined'){
				for(x=0;x<ArrayMRN[j].length;x++){
					if(typeof(ArrayMRN[j][x])!='undefined'){
						//alert(ArrayMRN[j][x])	
						for(z=0;z<ArrayMRN[j][x].length;z++){
							if(typeof(ArrayMRN[j][x][z])!='undefined'){
									
								var res = ArrayMRN[j][x][z].toString();
								var arr = res.split(',');
													
								var _strGRNNo = arr[0];
								var _dblQty = arr[1];
								var iGenItemCode = parseInt(arr[2]);
							
								if(iGenItemCode == itemdDetailID){
							var url = 'genissuexml.php?RequestType=SaveGenStockTransaction&issueNo=' + issueNo + '&issueYear=' + issueYear + '&mrnNo=' + mrnNo + '&itemdDetailID=' + itemdDetailID + '&qty=' + _dblQty + '&itmUnit=' + itmUnit + '&grnNo=' + _strGRNNo
							
							htmlobj=$.ajax({url:url,async:false});
							
							//alert(htmlobj.reponseText);	
							
								}
							}
						}
					}
		
				}
			}
		
		}*/
		
		}	
	
	ResponseValidate();	
}
//End -Save part with arrays

//Start -Get new Issue No from setting tables 
function getIssueNo()
{	
	if(!ValidateIsGRNSelected()){
		alert('GRN locations not been selected for some items.');	
		return false;
	}
	
	showPleaseWait();
	document.getElementById("Save").style.display="none";
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboprolineno").value=="")	
	{
		alert ("Please Select production Line Before Save");	
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(tbl.rows.length<=1)
	{
		alert("No Details To Save");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	for (loop = 1 ;loop < tbl.rows.length; loop++)
	{
		var issueQty 	= (tbl.rows[loop].cells[3].childNodes[0].value);
		var mrnQty 		= parseFloat(tbl.rows[loop].cells[4].childNodes[0].nodeValue);
		var stockQty 	= parseFloat(tbl.rows[loop].cells[4].id);
	
			if ((issueQty=="")  || (issueQty==0))
			{
				alert ("Issue Qty Can't Be '0' Or Empty.")
				document.getElementById("Save").style.display="inline";
				tbl.rows[loop].cells[3].childNodes[0].value=0;
				tbl.rows[loop].cells[3].childNodes[0].focus();
				hidePleaseWait();
				return false;
				break;
			}
			if(issueQty>mrnQty){
				alert("Sorry!\nIssueQty Cannot exceed MrnQty in Line No : "+loop+"\nIssueQty :"+issueQty+"\nMrnQty : "+mrnQty);
				document.getElementById("Save").style.display="inline";
				hidePleaseWait();
				return;
				break;
			}
			if(issueQty>stockQty){
				alert("Sorry!\nIssueQty Cannot exceed StockQty in Line No : "+loop+"\nIssueQty :"+issueQty+"\nStockQty : "+stockQty);
				document.getElementById("Save").style.display="inline";
				hidePleaseWait();
				return;
				break;
			}
			
	}
	
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = LoadIssueNoRequest;
	xmlHttp.open("GET" ,'genissuexml.php?RequestType=LoadIssueno' ,true);
	xmlHttp.send(null);	
}
	function LoadIssueNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  			 
			 	var XMLissueNo = xmlHttp.responseXML.getElementsByTagName("issueNo");	
				  issueNo = parseInt(XMLissueNo[0].childNodes[0].nodeValue);				
				  issueYear = parseInt(new Date().getFullYear());
				
						document.getElementById("txtissueNo").value = issueYear +  "/"  + issueNo ;			
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
	xmlHttp.open("GET" ,'genissuexml.php?RequestType=ResponseValidate&issueNo=' + issueNo + '&Year=' + issueYear + '&validateCount=' + validateCount,true);
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
						alert ("Issue No :" + document.getElementById("txtissueNo").value +  " Saved Successfully!");	
						
						document.getElementById("Save").style.display="none";
						document.getElementById("butShowItem").style.display="none";
						hidePleaseWait();
					}
					else 
					{
						ResponseValidate();	
						hidePleaseWait();
					}			
			}
		}
	}
//End-Validate save datails

//Start - open report usimg popup window 
function ReportPopup()
{
if(document.getElementById('gotoReport').style.visibility=="hidden")
{
	document.getElementById('gotoReport').style.visibility = "visible";
	LoadPopUpIssueNo();
}
	else
	{
	document.getElementById('gotoReport').style.visibility="hidden";
	return;
	}
	
}
function LoadPopUpIssueNo()
{
	RomoveData('cboRptIssueNo');
	document.getElementById('gotoReport').style.visibility = "visible";	
	var state=document.getElementById('cboState').value;
	var year=document.getElementById('cboYear').value;
	
 	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadPopUpIssueNoInRequest;
    xmlHttp.open("GET", 'genissuexml.php?RequestType=LoadPopUpIssueNo&state='+state+'&year='+year, true);
    xmlHttp.send(null);  
}

function LoadPopUpIssueNoInRequest()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptIssueNo").options.add(opt);
	
			 var XMLIssueNo= xmlHttp.responseXML.getElementsByTagName("IssueNo");
			 for ( var loop = 0; loop < XMLIssueNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = XMLIssueNo[loop].childNodes[0].nodeValue;
				opt.value = XMLIssueNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptIssueNo").options.add(opt);
			 }
		}
	}
}
function showReport()
{
	var ReportState=document.getElementById('cboState').value;
	var year=document.getElementById('cboYear').value;
	//var IssueNo=document.getElementById('cboRptIssueNo').value;
	var strIssueNo = document.getElementById('txtissueNo').value;
	var arr_issueNo = strIssueNo.split('/');
	var IssueNo = arr_issueNo[1];
	
	if(IssueNo!="0")
	{	
		newwindow=window.open('genissuenote.php?issueNo='+year+"/"+IssueNo,'name');
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
//---------------------start 2011-05-03-----------------------------------------
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

function OpenItemPopUp()
{
			
	showBackGround('divBG',0);
	var url = "genPopItems.php?";
		
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(825,388,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	//fix_header('tblPopItem',550,388);	
}
function ClearOptions(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function LoadMrnNo()
{
	ClearOptions("cboPopMrnNo");
	ClearTable("IssueItem");
	var url = 'genissuexml.php?RequestType=LoadMrnNo&mainCatId='+document.getElementById('cboMainCategory').value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopMrnNo').innerHTML = htmlobj.responseXML.getElementsByTagName("MrnNo")[0].childNodes[0].nodeValue;
}

//-----------------------------------------------------------------------------

//Load GRN List to rasie issue note
function popUpGrnList(prmItemCode, prmLindId, prmIssueQty, prmStockQty){ 

 // Clear the existing data before re-create the table	
 ClearTable('tbGRNList');	
 
 // Get the issue qty from the textbox
 /*//var _dblIssueQty = document.getElementById('tblIssueList').rows[intClickCnt].cells[3].lastChild.value;
 //var _dblIssueQty = $(this).closest(
 intSelectedLineNo = prmLindId;
 dblIssueQty = _dblIssueQty;
 strGenItemCode = prmMatDetailId;*/
 
 //GRN list div set as visible
 document.getElementById('divPopUpGRNList').style.visibility = 'visible';
	
 //Get the GRN table element 
 var tbl = document.getElementById('tbGRNList');
 
 // Load the GRN list belongs to selected item & location
 //****************************************************************
 var url ='genissuexml.php?RequestType=loadGRNList&intMatItemCode=' + prmItemCode;
	
 htmlobj=$.ajax({url:url,async:false});
 
 var GRNList = htmlobj.responseXML.getElementsByTagName("GRNNo")
 //****************************************************************
 
 //alert(GRNList.length);
 
 var _iLineId = 0;
 
 
 // Add GRN details to the GRN table element.
 for( var loop = 0; loop < GRNList.length; loop++ ){
	 
	var intGRNNo	= GRNList[loop].childNodes[0].nodeValue;
	var intGRNYear = htmlobj.responseXML.getElementsByTagName("GRNYear")[loop].childNodes[0].nodeValue;
	var strUnit = htmlobj.responseXML.getElementsByTagName("UNIT")[loop].childNodes[0].nodeValue;	
	var dblQty = htmlobj.responseXML.getElementsByTagName("QTY")[loop].childNodes[0].nodeValue;	
	//var strType = htmlobj.responseXML.getElementsByTagName("TYPE")[loop].childNodes[0].nodeValue;	
	
	if(dblQty>0){
		
		var lastRow = tbl.rows.length;
		row = tbl.insertRow(lastRow);
		tbl.rows[lastRow].bgColor="#FFFFFF"; 
	 
		var cellGRNNo =row.insertCell(0);
		cellGRNNo.className="normalfntSM";
		
		/*if(strType == 'ADJST'){
			cellGRNNo.innerHTML = 'OPEN STOCK'	
			intGRNYear = 1;
			intGRNNo = 1;
		}*//*else{
			cellGRNNo.innerHTML= intGRNYear + "/"+ intGRNNo;
		}*/	
		
		cellGRNNo.innerHTML= intGRNYear + "/"+ intGRNNo;
	
		var cellUnit = row.insertCell(1);
		cellUnit.className = "normalfntSM";
		cellUnit.innerHTML = strUnit;
		
		var cellUnit = row.insertCell(2);
		cellUnit.className = "normalfntRiteSML";
		cellUnit.innerHTML = "<input type=\"text \" size=\"8 \" class=\"txtbox \" style=\" text-align:right;\" value=\"0\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event); \" id=txt_"+prmLindId+" onkeyup=\"ValidateReqQty("+prmIssueQty+","+prmStockQty+")\"  />";
		
		var cellQty = row.insertCell(3);
		cellQty.className = "normalfntRiteSML";
		cellQty.innerHTML = dblQty;
		cellQty.id = "td_"+_iLineId;
		
		//var strId = intGRNYear+"/"+intGRNNo+"/"+prmLindId+1+"/"+_iLineId;
		var strId = "chk";//_"+_iLineId;
		
		var cellSelect = row.insertCell(4);
		cellSelect.className = "normalfntSM";
		//cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+strId+" value=\"checkbox\" onclick=\"segregateGRN(this,"+prmIssueQty+","+prmStockQty+") \" /></div>";
		cellSelect.innerHTML = "<input type=\"checkbox\" name=\"checkbox\" id="+strId+" value=\"checkbox\" />";
		
		_iLineId++;
	}
	 
 }
	
}

function segregateGRN(prmObj, prmIssuingQty, prmStockQty, prmRowIndex, prmGrnBalQty){
	
	var _dblGrnWiseIssueQty = 0;
	var _dblIssueBalQty = 0;
	
	var _tb = document.getElementById('tbGRNList');
	
	//_tb.rows[prmRowIndex].cells[2].childNodes[0].value=2;
	
	// Get total of GRN wise issuing qty
	_dblGrnWiseIssueQty += ValidateGRNListQty();
	
	if(prmIssuingQty>_dblGrnWiseIssueQty){
		
		if(parseFloat(prmIssuingQty)>parseFloat(prmGrnBalQty)){
			
			_dblIssueBalQty = parseFloat(prmIssuingQty) - _dblGrnWiseIssueQty;
			
			if(_dblIssueBalQty>prmGrnBalQty){
				_tb.rows[prmRowIndex].cells[2].childNodes[0].value=	prmGrnBalQty;
			}else{
				_tb.rows[prmRowIndex].cells[2].childNodes[0].value=	_dblIssueBalQty;
			}
			
			
			
		}else{
			
			_dblIssueBalQty = parseFloat(prmIssuingQty) - _dblGrnWiseIssueQty;
			
			if(_dblIssueBalQty>parseFloat(prmGrnBalQty)){
				_tb.rows[prmRowIndex].cells[2].childNodes[0].value=prmGrnBalQty;
			}else{
				_tb.rows[prmRowIndex].cells[2].childNodes[0].value=_dblIssueBalQty;
			}
			
			
		}
		
	}
	
	
	
	
	//document.getElementById('divPopUpGRNList').style.visibility = 'hidden';
}


function CloseDiv(divId){
	isNewOpen = true;
	document.getElementById(divId).style.visibility = 'hidden';
	
}

function CloseDivItemPopUp(divId){
	
	
	
	var box = document.getElementById(LayerId);
	box.parentNode.removeChild(box);
	hideBackGround('divBG');
	
}

function changePointer(prmSpan){
	document.getElementById(prmSpan).style.cursor = 'hand';
}

function ValidateGRNListQty(){

	var _dblReqQty = 0;
	var tb = document.getElementById('tbGRNList');
	//alert(tb.rows.length);x
	for(i=1;i<tb.rows.length;i++){
		
		if(typeof(tb.rows[i].cells[0]) != 'undefined'){
			
			if(tb.rows[i].cells[4].childNodes[0].checked == false){
				tb.rows[i].cells[2].childNodes[0].value = 0;	
			}
			
			
			_dblReqQty += parseFloat(tb.rows[i].cells[2].childNodes[0].value);
		}		
	}
	
	return _dblReqQty;
}

function ClearRequestQtyWhenUnChecked(){
	
	var tb = document.getElementById('tbGRNList');
	
	for(i=1;i<tb.rows.length;i++){		
		if(typeof(tb.rows[i].cells[0]) != 'undefined'){
			
			if(tb.rows[i].cells[4].childNodes[0].checked == false){
				tb.rows[i].cells[2].childNodes[0].value = 0;	
			}
		}	
	}
	
}

function UncheckedIfNoQty(){
	var tb = document.getElementById('tbGRNList');
	
	for(i=1;i<tb.rows.length;i++){		
		if(typeof(tb.rows[i].cells[0]) != 'undefined'){
			
			if(tb.rows[i].cells[2].childNodes[0].value == 0){
				tb.rows[i].cells[4].childNodes[0].checked = false;	
			}
		}	
	}
}


function ValidateReqQty(prmIssueQty, prmStockQty){

	var _dblReqQty = 0;
	var _dblTmpVal = 0
	var tb = document.getElementById('tbGRNList');
	//alert(tb.rows.length);x
	for(i=1;i<tb.rows.length;i++){
		
		if(typeof(tb.rows[i].cells[0]) != 'undefined'){
			
			_dblReqQty += parseFloat(tb.rows[i].cells[2].childNodes[0].value);
			//alert(_dblReqQty);
			if(prmStockQty>prmIssueQty){
			
				if(_dblReqQty>prmIssueQty){
					alert("Issue quantity cannot be more than MRN quantity");
					tb.rows[i].cells[2].childNodes[0].value = 0;
					tb.rows[i].cells[4].childNodes[0].childNodes[0].checked = false;
					return;	
				}
			}else{
				
				if(_dblReqQty>prmStockQty){
					alert("Sorry you cannot exceed the stock balance");
					tb.rows[i].cells[2].childNodes[0].value = 0;
					tb.rows[i].cells[4].childNodes[0].childNodes[0].checked = false;
					return;	
				}
				
			}
		}		
	}
}

function GRNAddToList(){
	//alert(intSelectedIssueLineNo);
	
	ArrayGRN[intSelectedIssueLineNo-1] = [,,];
	
	var iarrIndex = 0;
	var _dblReqQty = 0;
	var tb = document.getElementById('tbGRNList');
	//alert(tb.rows.length);x
	for(i=1;i<tb.rows.length;i++){
		
		if(typeof(tb.rows[i].cells[0]) != 'undefined'){
			
			//if(tb.rows[i].cells[4].childNodes[0].childNodes[0].checked == true){
			if(tb.rows[i].cells[4].childNodes[0].checked == true){
				
					ArrayGRN[intSelectedIssueLineNo-1][iarrIndex] = new Array([tb.rows[i].cells[0].innerHTML, tb.rows[i].cells[2].childNodes[0].value, intGenItemCode]);
					//ArrayGRN[_iArrLen-1][iarrIndex] = new Array([tb.rows[i].cells[0].innerHTML, tb.rows[i].cells[2].childNodes[0].value, strGenItemCode]);	
					
					iarrIndex++; 				
			}
		}		
	}
	
	_dblReqQty = parseFloat(ValidateGRNListQty());
	
	if(dblIssueQty == _dblReqQty){
	
		document.getElementById('tblIssueList').rows[intSelectedIssueLineNo].style.backgroundColor = "#A6CFEE";
		ArrayIssueGRNList[intSelectedIssueLineNo-1]=ArrayGRN[intSelectedIssueLineNo-1];
		CloseDiv('divPopUpGRNList');
	}else{
		alert("Issue quantity not equal to selected GRN quantities "); return false;
			
	}
	
	/*for(x=0;x<ArrayIssueGRNList.length;x++){
	
		for(j=0;j<ArrayIssueGRNList[x].length;j++){
			if(typeof(ArrayIssueGRNList[x][j])!='undefined'){
				alert(ArrayIssueGRNList[x][j]);
			}
		}
		
	}*/
	
	
}

function ClearCell(){

var tblIssueList 	= document.getElementById('tblIssueList');
		
	for (var mainLoop0 =1 ;mainLoop0 < tblIssueList.rows.length; mainLoop0++ )
	{
		if(tblIssueList.rows[mainLoop0].cells.length>8){
			tblIssueList.rows[mainLoop0].deleteCell(8);	
		}
	
	}	
	
}

function AddGRNSelectToTable(){	

	for (var mainLoop =1 ;mainLoop < tblIssueList.rows.length; mainLoop++ )
	{
	
		var _iItemCode = tblIssueList.rows[mainLoop].cells[2].id;
		var _dblStockBal = tblIssueList.rows[mainLoop].cells[5].innerHTML;
		
		var c = tblIssueList.rows[mainLoop].insertCell(8);
		c.className ="normalfntMid";
		c.innerHTML = "<img src=\"../../images/location.png\" id="+_iItemCode+" onclick='popUpGrnList("+_iItemCode+","+mainLoop+",0,0,"+_dblStockBal+")'>" ;
	
	}	
	
	
}

// Function for validate MRN qty with stock balance qty
// If stock balance 0, selected item not add to the list
function ValidateMRNQTY(prmObj, prmLineId, prmSelected){	
	
	if(prmSelected){
		
		var _tbl = document.getElementById('IssueItem');
		
		var _dblStockBal = parseFloat(_tbl.rows[prmLineId+1].cells[4].innerHTML);
		
		
		if(_dblStockBal<=0){
			_tbl.rows[prmLineId+1].cells[0].childNodes[0].childNodes[0].checked = false;
		}
	}
	
}



// JQUERY SECTION
// =======================================================================================

$(document).ready(function(e) {
	
	var _dblIssuingQty = 0;
	var _dblStockBal = 0;
	
    $(document).on("click", "img", function(){	
		
		// Get row index of the table from selected image element click 
		var _iRowIndex = $(this).closest('tr').index();
		
		if(_iRowIndex>0){
			intSelectedIssueLineNo = _iRowIndex;
			var _GenItemCode = $(this).attr('id');
			intGenItemCode = parseInt(_GenItemCode);
			_dblIssuingQty = $(this).closest('tr').find('input[type="text"]').val();
			_dblStockBal = $(this).closest('tr').find("td").eq(5).html();
			
			dblIssueQty = parseFloat(_dblIssuingQty);
			
			popUpGrnList(_GenItemCode, _iRowIndex, _dblIssuingQty, _dblStockBal);
		}
			
	});
	
	$(document).on("change","[type=checkbox]", function(){
		var _strChkBoxId = $(this).attr('id');
		
		if(_strChkBoxId =="chk"){
			
			var _iGrnRowIndex = $(this).closest('tr').index();
			var _dblGrnBalQty = $(this).closest('tr').find("td").eq(3).html();
		
			if($(this).is(":checked")){
				
				segregateGRN(this, _dblIssuingQty, _dblStockBal, _iGrnRowIndex, _dblGrnBalQty);
				UncheckedIfNoQty();
			}else{
				ClearRequestQtyWhenUnChecked();	
			}
		}
		
	});
	
});



