var xmlHttp;
var xmlHttp1 = [];
var xmlHttp2;
var xmlHttp3 = [];

var mainArrayIndex = 0;
var Materials = [];

var mainRw=0;
var subCatID;

var gatePassNo = 0;
var gatePassYear =0;

var validateCount = 0;
var validateBinCount =0;

var pub_commonBin		= 0;
var pub_mainStoreID		= 0;
var pub_subStoreID		= 0;
var pub_location = '';
var pub_bin = '';
var pub_binQty =0;

function ClearForm()
{	
	/*$("#frmGPTranferIn")[0].reset();
	$("#tblTransInMain tr:gt(0)").remove();
	$("#cboSubStores").html('');
	document.getElementById('cmdSave').style.display='inline';
	loadGPnolist();	*/
	document.frmGPTranferIn.submit();
}

function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();	
}

//start - configuring HTTP request
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
//End - configuring HTTP request

//start - configuring HTTP1 array request
function createXMLHttpRequest1(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp1[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP1 array request

//Start - restrict to type only numeric value
var AllowableCharators=new Array("38","37","39","40","8");
 function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }
//End - restrict to type only numeric value

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

//Start-Delete selected table row from the Table issue.php
function RemoveItem(obj,id)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		setAdd1(obj,id);
	}
}
//End-Delete selected table row from the Table issue.php

function LoadSubStores()
{
	var strMainStores = document.getElementById("cboMainStore").value;
	var url  = "GPtransferInXml.php";
		url += "?RequestType=getCommonBin";
		url += '&strMainStores='+strMainStores;
	var htmlobj=$.ajax({url:url,async:false});
	var xmlCommBin 	= htmlobj.responseXML.getElementsByTagName("commBin");
	pub_commonBin 	=  xmlCommBin[0].childNodes[0].nodeValue;
	document.getElementById("titCommonBinID").title = pub_commonBin;
				 
	var url = 'GPtransferInXml.php?RequestType=LoadSubStores&MainStoreId=' +strMainStores;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLsubStoresId = htmlobj.responseXML.getElementsByTagName("strSubID");
	document.getElementById("cboSubStores").innerHTML =  XMLsubStoresId[0].childNodes[0].nodeValue;
}
	
function LoadGatePassDetails()
{	
	pub_commonBin			= document.getElementById('titCommonBinID').title;
	document.getElementById('cboGPTransInNo').value = '';
	RemoveAllRows('tblTransInMain');
	Materials = [];
	mainArrayIndex = 0
	var gatePassNo = document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;
	var url = 'GPtransferInXml.php?RequestType=LoadGatePassDetails&gatePassNo=' +gatePassNo;
	htmlobj=$.ajax({url:url,async:false});
	LoadGatePassDetailsRequest(htmlobj);
	document.getElementById('cmdSave').style.display='inline';
}

function LoadGatePassDetailsRequest(xmlHttp)
{
	var tbl					= document.getElementById('tblTransInMain');
	var XMLStyleID1			= xmlHttp.responseXML.getElementsByTagName("StyleID");

	for (var loop =0; loop < XMLStyleID1.length; loop ++)
	{
		var XMLStyleID			= xmlHttp.responseXML.getElementsByTagName("StyleID")[loop].childNodes[0].nodeValue;
		var XMLBuyerPoNo		= xmlHttp.responseXML.getElementsByTagName("BuyerPoNO")[loop].childNodes[0].nodeValue;	
		var XMLStyleName		= xmlHttp.responseXML.getElementsByTagName("StyleName")[loop].childNodes[0].nodeValue;
		var XMLBuyerPoName		= xmlHttp.responseXML.getElementsByTagName("BuyerPoName")[loop].childNodes[0].nodeValue;	
		var XMLMatDetailID		= xmlHttp.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
		var XMLItemDesc			= xmlHttp.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var XMLColor			= xmlHttp.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var XMLSize				= xmlHttp.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var XMLUnit				= xmlHttp.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var XMLQty				= xmlHttp.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
		var XMLSubCatID			= xmlHttp.responseXML.getElementsByTagName("SubCatID")[loop].childNodes[0].nodeValue;
		var XMLGRNno 			= xmlHttp.responseXML.getElementsByTagName("GRNno")[loop].childNodes[0].nodeValue;
		var XMLGRNyear 			= xmlHttp.responseXML.getElementsByTagName("GRNYear")[loop].childNodes[0].nodeValue;
		var XMLGRNTypeId		= xmlHttp.responseXML.getElementsByTagName("GRNTypeId")[loop].childNodes[0].nodeValue;
		var XMLGRNType 			= xmlHttp.responseXML.getElementsByTagName("GRNType")[loop].childNodes[0].nodeValue;
		
//BEGIN - Add data to the main grid
		CreateMainGrid(tbl,XMLStyleID,XMLBuyerPoNo,XMLStyleName,XMLBuyerPoName,XMLMatDetailID,XMLItemDesc,XMLColor,XMLSize,XMLUnit,XMLQty,XMLSubCatID,XMLGRNno,XMLGRNyear,mainArrayIndex,pub_commonBin,XMLGRNTypeId,XMLGRNType);
//END	- Add data to the main grid
	
//BEGIN -  Add details to the main array
		var details = [];
		details[0] 	= XMLMatDetailID; 	// Mat ID
		details[1] 	= XMLColor; 		// Color
		details[2] 	= XMLSize;			// Size
		details[3] 	= XMLBuyerPoNo; 	// Buyer PO
		details[4] 	= XMLQty; 			// Default Qty
		details[6] 	= XMLUnit; 			// Units
		details[7] 	= XMLStyleID; 		// StyleID			
		details[8] 	= XMLSubCatID; 		// RTN							
		details[9]	= 0; 				// Add click
		details[10] = XMLGRNno;
		details[11] = XMLGRNyear;
		details[12] = XMLGRNTypeId;		// GRN type S = Style, B= Bulk
		Materials[mainArrayIndex] = details;
		mainArrayIndex++;
//END -  Add details to the main array
	}
}

function CreateMainGrid(tbl,styleId,buyerPoNo,styleName,buyerPoName,matDetailID,itemDesc,color,size,units,qty,subCatId,grnNo,grnYear,mainArrayIndex,pub_commonBin,grnTypeId,grnType)
{
	var lastRow 	= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.id			=0;
	cell.innerHTML 	= "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"0\" height=\"15\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" /></div>";
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfntMid";
	cell.id 		= mainArrayIndex;
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"checkbox2\" id=\"checkbox2\" onclick=\"RemoveBinColor(this,"+mainArrayIndex+");setAdd(this,"+mainArrayIndex+");\" />";
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.id 		= matDetailID;
	cell.innerHTML	= itemDesc;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.id 		= styleId;
	cell.innerHTML	= styleName;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.id 		= buyerPoNo;
	cell.innerHTML	= buyerPoName;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfntMid";
	cell.id 		= subCatId;
	cell.innerHTML	= color;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfntMid";
	cell.innerHTML	= size;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfntMid";
	cell.innerHTML	= units;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= qty;
	
	var cell 		= row.insertCell(9);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= "<input type=\"text\" id=\"txtTransInQty\" name=\"txtTransInQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onclick=\"return isNumberKey(event);\" value=\""+qty+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQty(this," + mainArrayIndex  + ");\">";
	
	var cell 		= row.insertCell(10);
	cell.className 	= "normalfntRite";
if(pub_commonBin==0)
	cell.innerHTML	= "<img src=\"../images/location.png\" alt=\"add\" width=\"80\" height=\"15\" onclick=\"OpenBinPopUp(this,"+mainArrayIndex+");SetQty(this,"+mainArrayIndex+");\"/>";
else
	cell.innerHTML	= "&nbsp;";
	
	var cell 		= row.insertCell(11);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= grnNo;
	
	var cell 		= row.insertCell(12);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= grnYear;
	
	var cell 		= row.insertCell(13);
	cell.className 	= "normalfntRite";
	cell.id			= grnTypeId;
	cell.innerHTML	= grnType;
}

function SetQty(obj,index)
{
		var rw = obj.parentNode.parentNode;		
		Materials[index][4] = parseFloat(rw.cells[9].childNodes[0].value);	
}
function setAdd(obj,index)
{	
	var rw = obj.parentNode.parentNode;	
	Materials[index][9]=(rw.cells[1].childNodes[0].checked==true ? 1:0);
}
function setAdd1(obj,index)
{	
	var rw = obj.parentNode.parentNode;	
	Materials[index][9]=0;
}
function OpenBinPopUp(obj,index)
{
	mainRw = obj.parentNode.parentNode.rowIndex;	
	var rw = obj.parentNode.parentNode;	
	
	var stockQty =parseFloat(rw.cells[8].childNodes[0].nodeValue);
	var ReqQty =parseFloat(rw.cells[9].childNodes[0].value);
	
	//	if (rw.cells[1].childNodes[0].checked==false)
//			{
//				return false;
//			}
		var mainStoreID = document.getElementById("cboMainStore").value;
		var subStores =	document.getElementById("cboSubStores").value;
		
		if (mainStoreID=="")
		{
			alert ("Please select the Main Store.");
			document.getElementById("cboMainStore").focus();
			return false;
		}
		if (subStores=="")
		{
			alert ("Please select the Sub Store.");
			document.getElementById("cboSubStores").focus();
			return false;
		}
		
		if (ReqQty=="" || ReqQty==0 || ReqQty==isNaN)
		{
			alert ("GatePass Transfer In Qty can't be '0' or empty.");
			rw.cells[9].childNodes[0].value=stockQty
			 return false;
		}	
		else if (ReqQty > stockQty)
		{
			alert ("Can't Transfer In more than GatePass Qty.");
			rw.cells[9].childNodes[0].value =stockQty;
			return false;
		}
		else if(pub_commonBin == 1)
		{
			alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");return;	
		}
		drawPopupArea(612,312,'divGPTransferBinItem');
		var strText= "<table width=\"100%\" border=\"0\" bgcolor=\"#FFFFFF\">"+
            "<tr>"+
              "<td height=\"25\" class=\"mainHeading\">Bin Items</td>"+
            "</tr>"+
           "<tr>"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr>"+
				"<td width=\"10%\" height=\"25\">&nbsp;</td>"+
				"<td width=\"18%\" class=\"normalfnt\">Req Qty</td>"+
				"<td width=\"54%\"><input name=\"txtreqqty\" type=\"text\" class=\"txtbox\" value=\""+ReqQty+"\" id=\"txtReqQty\" size=\"31\" readonly=\"\"/></td>"+
				"<td width=\"18%\">&nbsp;</td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+				  
            "<tr>"+
              "<td height=\"74\"><table width=\"100%\" height=\"141\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"141\"><table width=\"100%\" border=\"0\" class=\"tableBorder\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divGPTransferBinItem\" style=\"overflow:scroll; height:208px; width:100%;\">"+
                              "<table id=\"tblGPTransferBinItem\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
                                "<tr class=\"mainHeading4\">"+
                                  "<td width=\"2\" height=\"25\" >Main Stores</td>"+
                                  "<td width=\"86\">Sub Stores</td>"+
                                  "<td width=\"20\">Location</td>"+
                                  "<td width=\"15\">Bin ID</td>"+
                                  "<td width=\"10\">AVI Qty</td>"+
                                  "<td nowrap=\"nowrap\">Req Qty</td>"+
                                  "<td width=\"1\">Add</td>"+
                                  "</tr>"+								
                         "</table>"+
                          "</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"tableBorder\">"+
                "<tr >"+
                  "<td width=\"28%\">&nbsp;</td>"+
                  "<td width=\"18%\"><img src=\"../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onclick=\"SetBinQuantityToArray(this,"+index+");\"/></td>"+
                  "<td width=\"6%\">&nbsp;</td>"+
                  "<td width=\"20%\"><img src=\"../images/close.png\" width=\"97\" height=\"24\" onclick=\"closeWindow();\" /></td>"+
                  "<td width=\"28%\">&nbsp;</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>";
		  document.getElementById("divGPTransferBinItem").innerHTML=strText;
		  LoadBinDetails(index);
	}

function ShowSubCatName()
{
	var url = 'GPtransferInXml.php?RequestType=ShowSubCatName&subCatID=' +subCatID;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLSubCatName =htmlobj.responseXML.getElementsByTagName("SubCatName")[0].childNodes[0].nodeValue;				
	alert ("No bin allocated for sub category : "+ XMLSubCatName +"\nPlease allocate the bin and try again.");
	closeWindow();
}

function  LoadBinDetails(index)
{		
	var mainStoreID = document.getElementById("cboMainStore").value;	
	var subStores =	document.getElementById("cboSubStores").value;	
	var details = Materials[index]
	subCatID =details[8]
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadBinDetailsRequest;
	xmlHttp.open("GET",'GPtransferInXml.php?RequestType=LoadBinDetails&mainStoreID=' +mainStoreID+ '&subStores=' +subStores+ '&subCatID=' +subCatID ,true);
	xmlHttp.send(null);
}
 function LoadBinDetailsRequest()
 {
	 if (xmlHttp.readyState==4)
	 {
		 if (xmlHttp.status==200)
		 {
			 var XMLMainStoresID 	= xmlHttp.responseXML.getElementsByTagName("MainStoresID");
			 var XMLSubStoresID 	= xmlHttp.responseXML.getElementsByTagName("SubStoresID");
			 var XMLLocationID 		= xmlHttp.responseXML.getElementsByTagName("LocationID");
			 var XMLBinID 			= xmlHttp.responseXML.getElementsByTagName("BinID");
			 var XMLMainStoresName 	= xmlHttp.responseXML.getElementsByTagName("MainStoresName");
			 var XMLSubStoresName 	= xmlHttp.responseXML.getElementsByTagName("SubStoresName");
			 var XMLLocationName 	= xmlHttp.responseXML.getElementsByTagName("LocationName");
			 var XMLBinName 		= xmlHttp.responseXML.getElementsByTagName("BinName");
			 var XMLAvalableQty 	= xmlHttp.responseXML.getElementsByTagName("AvalableQty");
		if 	(XMLSubStoresID.length)
				{
		 var strText = "<tr class=\"mainHeading4\">"+
						  "<td nowrap=\"nowrap\" height=\"25\" >Main Stores</td>"+
						  "<td nowrap=\"nowrap\">Sub Stores</td>"+
						  "<td nowrap=\"nowrap\">Location</td>"+
						  "<td nowrap=\"nowrap\">Bin ID</td>"+
						  "<td nowrap=\"nowrap\">AVI Qty</td>"+
						  "<td nowrap=\"nowrap\">Req Qty</td>"+
						  "<td nowrap=\"nowrap\">Add</td>"+
						"</tr>";
					for (loop=0;loop<XMLSubStoresID.length;loop++)
					{
						strText +="<tr class=\"bcgcolor-tblrowWhite\">"+
									  "<td nowrap=\"nowrap\" class=\"normalfnt\" id=\""+XMLMainStoresID[loop].childNodes[0].nodeValue+"\">"+XMLMainStoresName[loop].childNodes[0].nodeValue+"1</td>"+
									  "<td  nowrap=\"nowrap\" class=\"normalfnt\" id=\""+XMLSubStoresID[loop].childNodes[0].nodeValue+"\">"+XMLSubStoresName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td nowrap=\"nowrap\" class=\"normalfnt\" id=\""+XMLLocationID[loop].childNodes[0].nodeValue+"\">"+XMLLocationName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td nowrap=\"nowrap\" class=\"normalfnt\" id=\""+XMLBinID[loop].childNodes[0].nodeValue+"\">"+XMLBinName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td nowrap=\"nowrap\" class=\"normalfntRite\">"+XMLAvalableQty[loop].childNodes[0].nodeValue+"</td>"+
									  "<td nowrap=\"nowrap\" class=\" normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\"0\" /></td>"+
									  "<td nowrap=\"nowrap\" class=\"normalfnt\"><div align=\"center\">"+
										 "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"SetBinQty(this);\" />"+
									  "</div></td>"+
									  "</tr>";
					}				
						document.getElementById("tblGPTransferBinItem").innerHTML=strText;
				}
				else
				{
					ShowSubCatName();
				}
		 }
	 }
 }
 function ValidateQty(obj){
	var rw 				= obj.parentNode.parentNode;
	var GatePass 		= parseFloat(rw.cells[8].childNodes[0].nodeValue);
	var TransInQty		= parseFloat(rw.cells[9].childNodes[0].value);
	
	if(GatePass<TransInQty){		
		rw.cells[9].childNodes[0].value=GatePass;
	}
}
 
 function SetBinQty(objbin)
{
	var tbl = document.getElementById("tblGPTransferBinItem");
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[6].childNodes[0].childNodes[0].checked)
	{
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[4].lastChild.nodeValue);		
		//var GPQty = rw.cells[5].childNodes[0].value;
		
		rw.cells[5].childNodes[0].value = 0;
		var GPTranferLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
					{		
						GPTranferLoopQty +=  parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
					}				
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(GPTranferLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[5].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[5].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[5].childNodes[0].value = 0;
}

function SetBinQuantityToArray(obj,index)
{	
	var tblMain =document.getElementById("tblTransInMain");	
	var tblBin = document.getElementById("tblGPTransferBinItem");
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPTransferLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++)
		{
			if (tblBin.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
			{		
					GPTransferLoopQty +=  parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value);
			}	
		}
	
	if (GPTransferLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
		var details = Materials[index];
		subCatID =details[8];
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
			{
				var check =tblBin.rows[loop].cells[6].childNodes[0].childNodes[0];
				
				if (check.checked && parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value)>0)
				{					
						var Bindetails = [];
							Bindetails[0] =   tblBin.rows[loop].cells[0].id; // MainStores
							Bindetails[1] =   tblBin.rows[loop].cells[1].id; // SubStores
							Bindetails[2] =   tblBin.rows[loop].cells[2].id;// Location
							Bindetails[3] =   tblBin.rows[loop].cells[3].id; // Bin ID
							Bindetails[4] =   tblBin.rows[loop].cells[5].childNodes[0].value; // IssueQty							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
							pub_location = tblBin.rows[loop].cells[2].id;
							pub_bin = tblBin.rows[loop].cells[3].id;
							pub_binQty = parseFloat(tblBin.rows[loop].cells[4].innerHTML)-parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value);
							
							
				}
			}
		Materials[index][5] = BinMaterials;				
		tblMain.rows[mainRw].className = "bcgcolor-tblrowLiteBlue";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
		tblMain.rows[mainRw].cells[0].id =1;
		tblMain.rows[mainRw].cells[1].childNodes[0].checked=true;
		Materials[index][9] =1;
		closeWindow();		
	}
	else 
	{
		alert ("Allocated Qty must equal with Req Qty. \nReq Qty =" + totReqQty + "\nAllocated Qty =" + GPTransferLoopQty +"\nVariance is =" +(totReqQty-GPTransferLoopQty));
		return false;
	}
	
}

function RemoveBinColor(obj,index)
{
	var tblMain =document.getElementById("tblTransInMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[0].id =0;
}

//Start-Save part
function SaveValidation()
{
	document.getElementById('cmdSave').style.display = 'none';
	var tblMain 			= document.getElementById("tblTransInMain")
	pub_mainStoreID			= document.getElementById('cboMainStore').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;
	var type = 'Save';
	if(!SaveValidate(tblMain,pub_mainStoreID,pub_subStoreID,type))
	{
		document.getElementById('cmdSave').style.display = 'inline';
		return;
	}
	LoadGPTransferInNo();
}

function LoadGPTransferInNo()
{		
	var TansferIn = document.getElementById("cboGPTransInNo").value
	if (TansferIn=="")
	{
		var url = 'GPtransferInXml.php?RequestType=LoadGPTransferInNo';
		htmlobj=$.ajax({url:url,async:false});
		LoadGPTransferInNoRequest(htmlobj);
	}
	else
	{	
		transfer		= TansferIn.split("/");		
		transferIn 		= parseInt(transfer[1]);
		transferInYear 	= parseInt(transfer[0]);
		SaveHeader();
	}
}

function LoadGPTransferInNoRequest(xmlHttp)
{
	var XMLGatePassNo 	= xmlHttp.responseXML.getElementsByTagName("TransferInNo")[0].childNodes[0].nodeValue;
	var XMLGatePassYear = xmlHttp.responseXML.getElementsByTagName("TransferInYear")[0].childNodes[0].nodeValue;
	transferIn 			= parseInt(XMLGatePassNo);
	transferInYear 		= parseInt(XMLGatePassYear);
	document.getElementById("cboGPTransInNo").value=transferInYear + "/" + transferIn;			
	SaveHeader();
}
	
function SaveHeader()
{	
	var GatePassNo =document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;
	var remarks =document.getElementById("txtReason").value;

	var url = 'GPtransferInXml.php?RequestType=SaveHeaderDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+  '&GatePassNo=' +GatePassNo+ '&remarks=' +URLEncode(remarks);
	htmlobj=$.ajax({url:url,async:false});
	SaveDetails();
}

function SaveDetails()
{	
validateCount 	 = 0;
validateBinCount = 0;
var remarks 	 = document.getElementById("txtReason").value;
var GatePassNo 	 = document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;

	for (loop=0;loop<Materials.length;loop++)
	{
		var details = Materials[loop];
		var Add     = details[9];
		if 	((details!=null) && (Add!=0))
		{
			var MatDetailID = details[0];  // Mat ID
			var Color 		= details[1];  // Color
			var Size        = details[2];  // Size
			var BuyerPoNO   = details[3];  // Buyer PO
			var Qty         = details[4];  // Default Qty
			var binArray    = details[5];
			var Unit        = details[6];  //units
			var StyleID     = details[7];  //StyleID			
			var SubCatID    = details[8];  //RTN							
			var Add         = details[9];  //Add click
			var grnNo       = details[10]; //GRN No    2010-11-08
			var grnYear 	= details[11]; //GRN year
			var grnType 	= details[12]; //GRN Type
			validateCount++;
				
			var url = 'GPtransferInXml.php?RequestType=SaveDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+'&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&BuyerPoNO=' +URLEncode(BuyerPoNO)+ '&Qty=' +Qty+ '&Unit=' +Unit+ '&StyleID=' +URLEncode(StyleID)+ '&remarks=' +URLEncode(remarks)+ '&GatePassNo=' +GatePassNo+'&grnNo='+grnNo+'&grnYear='+grnYear+ '&GRNType='+grnType;
			var htmlobj=$.ajax({url:url,async:false});
			
			if(pub_commonBin==0)
			{			
				for (i = 0; i < binArray.length; i++)
				{
					var Bindetails = binArray[i];
					var MainStores = Bindetails[0]; // MainStores
					var SubStores  = Bindetails[1]; // SubStores
					var Location   = Bindetails[2];	// Location
					var BinID      = Bindetails[3]; // BinID
					var BinQty     = Bindetails[4]; // IssueQty							
					validateBinCount++;

					var url = 'GPtransferInXml.php?RequestType=SaveBinDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+ '&StyleID=' +URLEncode(StyleID)+ '&BuyerPoNO=' +URLEncode(BuyerPoNO)+ '&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +Unit+ '&MainStores=' +MainStores+ '&SubStores=' +SubStores+ '&Location=' +Location+ '&BinID=' +BinID+ '&BinQty=' +BinQty+ '&SubCatID=' +SubCatID +'&grnNo='+grnNo+'&grnYear='+grnYear+ '&GRNType='+grnType;
					var htmlobj=$.ajax({url:url,async:false});	
				}
			}
			else
			{
				validateBinCount++;
				var url = 'GPtransferInXml.php?RequestType=SaveBinDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+ '&StyleID=' +URLEncode(StyleID)+ '&BuyerPoNO=' +URLEncode(BuyerPoNO)+ '&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +Unit+ '&MainStores=' +pub_mainStoreID+ '&SubStores=' +pub_subStoreID+ '&BinQty=' +Qty+ '&commonBin=' +pub_commonBin+ '&SubCatID=' +SubCatID +'&grnNo='+grnNo+'&grnYear='+grnYear+ '&GRNType='+grnType;
				var htmlobj=$.ajax({url:url,async:false});						
			}
		}
	}	
	ResponseValidate();
}

function ResponseValidate()
{
	var url = 'GPtransferInXml.php?RequestType=ResponseValidate&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount;
	var htmlobj=$.ajax({url:url,async:false});	
	var Header		= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var Details		= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;
	var binDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;	
		
	if((Header=="TRUE") && (Details=="TRUE") && (binDetails=="TRUE"))
	{
		alert ("TransferIn No : " + document.getElementById("cboGPTransInNo").value +  " saved successfully.");
		document.getElementById('cmdSave').style.display = 'none';
	}
	else
	{
		alert("Error in saving.Please save it again.");
		document.getElementById('cmdSave').style.display = 'inline';
	}					
}	
//End-Save part

function reportPopup()
{
	if(document.getElementById('gotoReport').style.visibility=="hidden")
	{
		document.getElementById('gotoReport').style.visibility = "visible";
		LoadPopUpTransIn();
	}
	else
	{
		document.getElementById('gotoReport').style.visibility="hidden";
		return;
	}	
}

function ReportPopOut()
{
	if(document.getElementById('gotoReport').style.visibility=="visible")
	{
		document.getElementById('gotoReport').style.visibility="hidden";
		return;
	}
}

function LoadPopUpTransIn()
{
	RomoveData('cboRptTransIn');
	document.getElementById('gotoReport').style.visibility = "visible";	
	var state=document.getElementById('cboReportState').value;
	var year=document.getElementById('cboReportYear').value;
	
 	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadPopUpTransInRequest;
    xmlHttp.open("GET", 'GPtransferInXml.php?RequestType=LoadPopUpTransIn&state='+state+'&year='+year, true);
    xmlHttp.send(null);  
}

function LoadPopUpTransInRequest()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptTransIn").options.add(opt);
	
			 var XMLTransIn= xmlHttp.responseXML.getElementsByTagName("TransIn");
			 for ( var loop = 0; loop < XMLTransIn.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = XMLTransIn[loop].childNodes[0].nodeValue;
				opt.value = XMLTransIn[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptTransIn").options.add(opt);
			 }
			 
		}
	}
}
function showReport()
{
	var No			= document.getElementById('cboGPTransInNo').value;
	if(No=="")
	{
		alert("No \"Transfer In No\" to generate report.");
		return;
	}
	var NoArray		= No.split("/");
	var year		= NoArray[0];
	var TransInNo	= NoArray[1];
	if(TransInNo!="0")
	{		
		newwindow=window.open('Details/TransferInReport.php?TransferInNo='+TransInNo+'&TransferInYear='+year,'name');
			if (window.focus) {newwindow.focus()}	
	}
}

function SearchPopUp()
{	
if(document.getElementById('NoSearch').style.visibility=="hidden")
{
	document.getElementById('NoSearch').style.visibility = "visible";
	LoadPopUpNo();
}
	else
	{
	document.getElementById('NoSearch').style.visibility="hidden";
	return;
	}	
}

function LoadPopUpNo()
{	
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state=document.getElementById('cboState').value;
	var year=document.getElementById('cboYear').value;
	
    var url = 'GPtransferInXml.php?RequestType=LoadPopUpTransIn&state='+state+'&year='+year;
    var htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboNo").innerHTML=htmlobj.responseText;	
}

function loadPopUpReturnToStores(){
	
	document.getElementById('NoSearch').style.visibility = "hidden";	
	var No=document.getElementById('cboNo').value;
	var Year=document.getElementById('cboYear').value;
	if (No=="")return false;	
	
	var url = 'GPtransferInXml.php?RequestType=LoadPopUpHeaderDetails&No='+No+ '&Year='+Year;
	var htmlobj=$.ajax({url:url,async:false});
	LoadHeaderDetailsRequest(htmlobj);
	
	var url = 'GPtransferInXml.php?RequestType=LoadPopUpDetails&No=' +No+ '&Year=' +Year;
	var htmlobj=$.ajax({url:url,async:false});
	LoadDetailsRequest(htmlobj);
}
function LoadHeaderDetailsRequest(htmlobj)
{
	var XMLGpTranferNo 	= htmlobj.responseXML.getElementsByTagName('GpTranferNo')[0].childNodes[0].nodeValue;	
	var XMLGatePassNo 	= htmlobj.responseXML.getElementsByTagName('GatePassNo')[0].childNodes[0].nodeValue;
	var XMLStatus 		= parseInt(htmlobj.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);
	var XMLRemarks 		= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
	
	document.getElementById('cboGPTransInNo').value =XMLGpTranferNo;				
	document.getElementById('txtReason').value =XMLRemarks ;		
	
	switch (XMLStatus)
	{						
		case 1:	
			document.getElementById("cmdSave").style.display="none";							
			break;				
		case 10:						
			document.getElementById("cmdSave").style.display="none";						
			break;							
	}
}
	
function LoadDetailsRequest(htmlobj)
{
	RemoveAllRows('tblTransInMain');
	var tbl 				= document.getElementById("tblTransInMain");
		
	var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription");
	var XMLStyleID 			= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLBuyerPONO 		= htmlobj.responseXML.getElementsByTagName("BuyerPONO");
	var XMLStyleName		= htmlobj.responseXML.getElementsByTagName("StyleName");
	var XMLBuyerPOName 		= htmlobj.responseXML.getElementsByTagName("BuyerPOName");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color");				
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLGatePassQty		= htmlobj.responseXML.getElementsByTagName("GatePassQty");
	var XMLGRNno 			= htmlobj.responseXML.getElementsByTagName("GRNno");
	var XMLGRNyear			= htmlobj.responseXML.getElementsByTagName("GRNyear");
	var XMLGRNTypeId		= htmlobj.responseXML.getElementsByTagName("GRNTypeId");
	var XMLGRNType			= htmlobj.responseXML.getElementsByTagName("GRNType");
	
	for (loop=0;loop<XMLStyleID.length;loop++)
	{
		var strInnerHtml="";				
		strInnerHtml+="<td class=\"normalfnt\"><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"0\" height=\"15\" /></div></td>";
		strInnerHtml+="<td class=\"normalfntMid\"><input type=\"checkbox\" name=\"checkbox2\" id=\"checkbox2\" checked=\"checked\" disabled=\"disabled\"/></td>";
		strInnerHtml+="<td class=\"normalfnt\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMid\" id=\""+XMLStyleID[loop].childNodes[0].nodeValue+"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue+"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMid\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMid\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMid\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRite\">"+XMLGatePassQty[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRite\"><input type=\"text\" id=\"txtTransInQty\" name=\"txtTransInQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" readonly=\"readonly\" value=\""+XMLQty[loop].childNodes[0].nodeValue+"\"/> </td>";
		strInnerHtml+="<td class=\"normalfntMid\"><img src=\"../images/location.png\" alt=\"add\" width=\"80\" height=\"15\"/></td>";              
		strInnerHtml+="<td class=\"normalfntRite\">"+XMLGRNno[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRite\">"+XMLGRNyear[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRite\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>";
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);						
		tbl.rows[lastRow].innerHTML=  strInnerHtml ;
		tbl.rows[lastRow].id = lastRow;
		tbl.rows[lastRow].className = "bcgcolor-tblrowLiteBlue";
	}
}
//End - Saved Details PopUp window

function CancelValidation()
{
	showBackGroundBalck();
	if(confirm('Are you sure you want to Cancel this TransferIn No?'))
	{
		var TransNO =document.getElementById('cboGPTransInNo').value;
	
		createXMLHttpRequest();
		xmlHttp.index=TransNO;
		xmlHttp.onreadystatechange=CancelValidationRequest;
		xmlHttp.open("GET",'Details/TransferInDetailsXml.php?RequestType=Cancel&TransNO=' +TransNO ,true);
		xmlHttp.send(null);
	}
	else{
		hideBackGroundBalck();
	}
}
	function CancelValidationRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLTransNO =xmlHttp.index;
				alert ("TransferIn NO : "+ XMLTransNO + " Canceled.");
				
				if(confirm('Do you want to view Tranfering No :'+ XMLTransNO +' Report?'))
				{
					//var ExpodeNo =XMLTransNO.split("/");
					//window.location = 'Details/TransferInReport.php?TransferInNo='+ExpodeNo[1]+'&TransferInYear='+ExpodeNo[0];	
					showReport();
					document.getElementById("cmdSave").style.visibility="hidden";						
					document.getElementById("cmdCancel").style.visibility="hidden";
					hideBackGroundBalck();
				}
				else{
					hideBackGroundBalck();
				}
			}
		}
	}
	
function showBackGroundBalck()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	//popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
	document.body.appendChild(popupbox);
}

function hideBackGroundBalck()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function loadGPnolist()
{
	var styleId = $("#cboOrderNo").val();
	
	var url = 'GPtransferInXml.php?RequestType=getGPNolist';	
		url += '&styleId='+styleId;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 $("#cboGatePassNo").html(htmlobj.responseXML.getElementsByTagName("GPNo")[0].childNodes[0].nodeValue);
}

function SaveValidate(tblMain,pub_mainStoreID,pub_subStoreID,type)
{
	if(document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text=="Select One")
	{
		alert("Please select the 'GatePass No'.");
		document.getElementById('cboGatePassNo').focus();
		return false;
	}
	if(pub_mainStoreID=="")
	{
		alert("Please select the 'Main Stores'.");
		document.getElementById('cboMainStore').focus();
		return false;
	}
	else if(pub_subStoreID=="")
	{
		alert("Please select the 'Sub Stores'.");
		document.getElementById('cboSubStores').focus;
		return false;
	}
	else if(tblMain.rows.length<=1)
	{	alert ("No details appear to save.");
		return false;
	}
	
	var tblLen = tblMain.rows.length-1;
	for(loop=1;loop<tblMain.rows.length;loop++)
		{
			if(tblMain.rows[loop].cells[1].childNodes[0].checked == false)
				tblLen--;				
		}
		
	if(tblLen == 0)
	{
		alert('Please select at least one item(s).');
		return false;
	}
	if(type == 'Save')
	{
		if(pub_commonBin == 0)
		{
			for(loop=1;loop<tblMain.rows.length;loop++)
			{
				if(tblMain.rows[loop].cells[0].id==0)
				{
					alert ("Cannot save without allocating bin.\nPlease allocate the bin in line no : " + [loop] +"." );
					return false;
				}
			}
		}
	}
	else if(type == 'autoBin')
	{
		var count = 1;
		for(loop=1;loop<tblMain.rows.length;loop++)
		{
			if(tblMain.rows[loop].cells[0].id==0)
				count++;
		}
		if(count == tblMain.rows.length)
		{
			alert("Please allocate bin details for one item");
			return false;
		}
	}
	
return true;
}

function autoBin()
{
	//showWaitingWindow();
	 var tbl 			= 	document.getElementById('tblTransInMain');
	 var strMainStores 	= 	document.getElementById('cboMainStore').value;
	 var strSubStores	= 	document.getElementById("cboSubStores").value;
	 var count =1;	
	 var mainCatNo 	= '';
	 var manRowId 	= '';
	 var subCatID 	= '';
	 var type = 'autoBin';
	if(SaveValidate(tbl,strMainStores,strSubStores,type))
	{
		for(var i = 1; i < tbl.rows.length ; i++)
		{
			var binAllocation=false;
			if(tbl.rows[i].cells[0].id ==1)
				continue;
			
						
			for(var a = 1; a < tbl.rows.length ; a++)
			{
				if(tbl.rows[a].cells[0].id ==1)
				continue;
				
				var gpQty = parseFloat(tbl.rows[a].cells[9].childNodes[0].value);
				if(tbl.rows[a].cells[1].childNodes[0].checked)
				{
					binAllocation = true;
					var mainSubCatId = tbl.rows[a].cells[5].id;
					var index = tbl.rows[a].cells[1].id;
					
					if(mainSubCatId != subCatID)
					{
						var url = 'GPtransferInXml.php?RequestType=checkBinavailabiltyforSubcat';
						url += '&strMainStores='+strMainStores;
						url += '&strSubStores='+strSubStores;
						url += '&pub_location='+pub_location;
						url += '&pub_bin='+pub_bin;
						url += '&mainCatNo='+mainSubCatId;	
						
						htmlobj=$.ajax({url:url,async:false});
						binAvResponse = htmlobj.responseXML.getElementsByTagName("binResult")[0].childNodes[0].nodeValue;
						if(binAvResponse == '1')
							binAllocation = true;
						else
							binAllocation = false;
					}
					if(binAllocation)
					{
						//tbl.rows[a].cells[0].id =1;
						if(pub_binQty>gpQty)
						{
							var BinMaterials = [];
							var mainBinArrayIndex = 0;
							var Bindetails = [];
							Bindetails[0] =   strMainStores; // MainStores
							Bindetails[1] =  strSubStores; // SubStores
							Bindetails[2] =   pub_location; // Location
							Bindetails[3] =   pub_bin; // Bin ID
							Bindetails[4] =   tbl.rows[a].cells[9].childNodes[0].value; // IssueQty								
							Bindetails[5] =   mainSubCatId //  MatSubCategoryId
										
							BinMaterials[mainBinArrayIndex] = Bindetails;
							Materials[index][5] = BinMaterials;
							tbl.rows[a].className = "bcgcolor-tblrowLiteBlue";
							tbl.rows[a].cells[0].id=1;
							Materials[index][9] =1;
							pub_binQty = pub_binQty-gpQty;
							subCatID = mainSubCatId;
						}
						else
						{
							alert("Bin Capacity Exeed the Required Quantity");
							return;
						}
						
					}
					else
					{
						alert("Bin Allocation Details not available");
						return;
					}
					
				}
			}
		}
	}
}

function SelectAll(obj)
{
	var tbl = document.getElementById('tblTransInMain');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[1].childNodes[0].checked = (obj.checked ? true:false);
	}
}