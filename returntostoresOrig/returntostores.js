var xmlHttp;
var altxmlHttp;


var Materials 			= [];
var xmlHttp2 			= [];
var xmlHttp4			= [];
var xmlHttp5			= [];

var mainRw				= 0;
var mainArrayIndex 		= 0;
var validateCount 		= 0;
var validateBinCount 	= 0;

var pub_mainStoreID		= 0;
var pub_subStoreID		= 0;
var pub_subCatID		= 0;
var pub_index			= 0;
var pub_returnNo		= 0;
var pub_returnYear		= 0;
var pub_commonBin		= 0;
var checkLoop 			= 0;

var pub_state 			= 0;
//Start-ClearForm
function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}
//End-ClearForm

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

//start - configuring HTTP1 request
function createXMLHttpRequest1() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp1 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1 = new XMLHttpRequest();
    }
}
//start - configuring HTTP1 request

//start - configuring HTTP2 request
function createXMLHttpRequest2(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP2 request

//start - configuring HTTP4 request
function createXMLHttpRequest4(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp4[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp4[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP4 request

//start - configuring HTTP4 request
function createXMLHttpRequest5(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp5[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp5[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP4 request

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
//Start-Delete selected table row from the Table 
function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;
		
		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;
		//alert(obj.id);
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;	
	}
}
//Start-Delete selected table row from the Table

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

function PopUprowclickColorChange(obj)
{
	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById('tblItemPopUp');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "bcgcolor-tblrow";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function rowclickColorChange()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblMain');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function SeachStyle(obj)
{	
	//var ScNo =document.getElementById("cboSCNO").options[document.getElementById("cboSCNO").selectedIndex].text;	
	//document.getElementById("cboStyleID").value =ScNo;
	document.getElementById("cboStyleID").value =obj.value;
	LoadBuyerPoNo();
}

function SeachSCNO(obj)
{
	/*var StyleID =document.getElementById("cboStyleID").options[document.getElementById("cboStyleID").selectedIndex].text;
	document.getElementById("cboSCNO").value =StyleID;*/
	document.getElementById("cboSCNO").value = obj.value;
	LoadBuyerPoNo();
}

function SelectAll(obj)
{
	var tbl 		= document.getElementById('tblItemPopUp');
	if(obj.checked){
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked=true;
		
		}
	}
	else{
		for(loop=1;loop<tbl.rows.length;loop++)	{
			tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked=false;	
		}
	}
	
}

function UnSelectAll()
{
	var tbl 		= document.getElementById('tblItemPopUp');	
	for(loop=1;loop<tbl.rows.length;loop++)	{
		tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked=false;	
	}
}

//Start-PopUp search 
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
//End-PopUp search 

/*function LoadBuyerPoNo()
{
	alert("LoadBuyerPoNo");
}
*/
//Start -Load Buyer PONO TO Combo
function LoadBuyerPoNo()
{		
	var StyleID =document.getElementById("cboStyleID").value;//options[document.getElementById("cboStyleID").selectedIndex].text;
	createXMLHttpRequest();
	RomoveData("cboBuyerPoNo")
	xmlHttp.onreadystatechange=LoadBuyerPoNoRequest;
	xmlHttp.open("GET",'returntostoresxml.php?RequestType=LoadBuyetPoNo&StyleID=' + URLEncode(StyleID) ,true);
	xmlHttp.send(null);
}
	function LoadBuyerPoNoRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var opt = document.createElement("option");
				opt.value = "";
				opt.text = "Select Buyer PO NO";
				document.getElementById("cboBuyerPoNo").options.add(opt);
						
				var XMLBuyerPoNo =xmlHttp.responseXML.getElementsByTagName("BuyerPoNo");
				var XMLBuyerPoName =xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
				
					for ( var loop = 0; loop < XMLBuyerPoNo.length; loop ++)
			 		{							
						var opt = document.createElement("option");
						opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;
						opt.value = XMLBuyerPoNo[loop].childNodes[0].nodeValue;
						document.getElementById("cboBuyerPoNo").options.add(opt);			
			 		}
			}
		}
	}
//End -Load Buyer PONO To Combo

function ValidatePopUpItems()
{
	var orderId		= document.getElementById("cboStyleID");
	var buyerPoNo	= document.getElementById("cboBuyerPoNo");
	
	if (orderId.value=="")
	{
		alert("Please select the 'Order No'.");
		orderId.focus();
		return false;
	}
	else if (buyerPoNo.value=="")
	{
		alert("Please select the 'Buyer PO No'.");
		buyerPoNo.focus();
		return false;
	}
	OpenPopUp(orderId,buyerPoNo);
}
function OpenPopUp(orderId,buyerPoNo)
{
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'returntostoresitempopup.php?StyleID=' +URLEncode(orderId.value)+ '&buyerPoNo=' +URLEncode(buyerPoNo.value) ,true);
	xmlHttp.send(null);
}

	function LoadStockDetailsRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupArea(958,467,'frmMaterialTransfer');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
			}
		}
	}
	
function AddToMainPage()
{
	pub_commonBin			= document.getElementById('commonBinID').title;
	var tblPopUp = document.getElementById('tblItemPopUp');
	var StyleID = document.getElementById("cboStyleID").value;
	var StyleName = document.getElementById("cboStyleID").options[document.getElementById("cboStyleID").selectedIndex].text;
	for(loop=1;loop<tblPopUp.rows.length;loop++)
	{	
		if (tblPopUp.rows[loop].cells[0].childNodes[0].childNodes[1].checked)	
		{
			var issueNo			=  tblPopUp.rows[loop].cells[1].childNodes[0].nodeValue;
			var subCatId 		=  tblPopUp.rows[loop].cells[1].id;
			var itemDescription	=  tblPopUp.rows[loop].cells[3].childNodes[0].nodeValue;
			var itemDetailID 	=  tblPopUp.rows[loop].cells[3].id;
			var buyerPoNo 		=  tblPopUp.rows[loop].cells[4].id;
			var BuyerPOname     =  tblPopUp.rows[loop].cells[4].childNodes[0].nodeValue;
			var mrnNo 			=  tblPopUp.rows[loop].cells[5].id;
			var color 			=  tblPopUp.rows[loop].cells[5].childNodes[0].nodeValue;
			var size 			=  tblPopUp.rows[loop].cells[6].childNodes[0].nodeValue;
			var units 			=  tblPopUp.rows[loop].cells[7].childNodes[0].nodeValue;
			var qty 			=  tblPopUp.rows[loop].cells[8].childNodes[0].nodeValue;
			var grnNo 			=  tblPopUp.rows[loop].cells[9].childNodes[0].nodeValue;
			var grnType			=  tblPopUp.rows[loop].cells[10].id;
			var strGRNtype      = tblPopUp.rows[loop].cells[10].childNodes[0].nodeValue;
			
			var tblMain 		= document.getElementById('tblMain');			
			var booCheck =false;
				for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
				{
					var mainIssueNo 	= tblMain.rows[mainLoop].cells[1].childNodes[0].nodeValue;
					var mainMatDetaiId 	= tblMain.rows[mainLoop].cells[2].id;
					var mainStyleId 	= tblMain.rows[mainLoop].cells[3].id;	
					var mainBuyerPoNo 	= tblMain.rows[mainLoop].cells[4].id;
					var mainColor 		= tblMain.rows[mainLoop].cells[5].childNodes[0].nodeValue;
					var mainSize 		= tblMain.rows[mainLoop].cells[6].childNodes[0].nodeValue;	
					var mainGRNno 		= tblMain.rows[mainLoop].cells[11].childNodes[0].nodeValue;
					var mainGRNtype     = tblMain.rows[mainLoop].cells[12].id;
					if ((mainMatDetaiId==itemDetailID) && (mainBuyerPoNo==buyerPoNo) && (mainColor==color) && (mainSize==size) && (mainIssueNo==issueNo) && (mainStyleId==StyleID) && (grnNo == mainGRNno) && (grnType==mainGRNtype))
					{
								booCheck =true;
					}	
				}
			if (booCheck == false)
			{
			var lastRow 		= tblMain.rows.length;	
			var row 			= tblMain.insertRow(lastRow);

		
			row.className = "bcgcolor-tblrowWhite";
			row.onmouseover="this.style.background ='#D6E7F5';"
			
			var cellDelete = row.insertCell(0); 
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"" + mainArrayIndex + "\" onclick=\"RemoveItem(this);\"/></div>";			
					
			var cellIssueNo = row.insertCell(1);
			cellIssueNo.className ="normalfnt";	
			cellIssueNo.id =subCatId;
			cellIssueNo.innerHTML =issueNo;			
					
			var cellDescription = row.insertCell(2);
			cellDescription.className ="normalfntSM";
			cellDescription.id =itemDetailID;
			cellDescription.innerHTML =itemDescription;
			
					
			var cellStyleID = row.insertCell(3);
			cellStyleID.className ="normalfntSM";
			cellStyleID.id = StyleID;
			cellStyleID.innerHTML =StyleName;
					
			var cellBuyerPoNo = row.insertCell(4);
			cellBuyerPoNo.className ="normalfntSM";
			cellBuyerPoNo.id =buyerPoNo;
			cellBuyerPoNo.innerHTML =BuyerPOname;
			
					
			var celColor = row.insertCell(5);
			celColor.className ="normalfntSM";
			celColor.id =mrnNo; 
			celColor.innerHTML =color;
			
					
			var cellSize = row.insertCell(6);
			cellSize.className ="normalfntSM";			
			cellSize.innerHTML =size;
			
			var cellUnits = row.insertCell(7);
			cellUnits.className ="normalfntSM";			
			cellUnits.innerHTML =units;					
		
			var cellQty = row.insertCell(8);
			cellQty.className ="normalfntRite";			
			cellQty.innerHTML =qty;	
			
			var cellTxt = row.insertCell(9);				
			cellTxt.className ="normalfntMidSML";	
			cellTxt.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" value=\""+qty+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQuantity(this," + mainArrayIndex  + ");\" />";
			
			//if(pub_commonBin==0){
			var cellLocation = row.insertCell(10);	
			cellLocation.id=0;
			cellLocation.className ="normalfntMidSML";	
			cellLocation.innerHTML ="<div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\"  height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div>";
			//}
			
			var cellGRN = row.insertCell(11);
			cellGRN.className ="normalfntRite";			
			cellGRN.innerHTML =grnNo;	
			
			var cellGRN = row.insertCell(12);
			cellGRN.className ="normalfntRite";	
			cellGRN.id  = grnType
			cellGRN.innerHTML =strGRNtype;	
			//Start - array
			var details		= [];
				details[0]	= StyleID;
			    details[1]	= buyerPoNo;
			    details[2]	= itemDetailID;
			    details[3]	= color;
				details[4]	= size;
				details[6]	= units;
				details[7]	= issueNo;
				details[8]	= parseFloat(qty);
				details[9]	= subCatId;
				details[10]	= mrnNo;
				details[11]	= grnNo;
				details[12]	= grnType;
				
			Materials[mainArrayIndex]= details;
			mainArrayIndex++;
			//End - array		
			
			}
		}
	}
	closeWindow();
}

function SetQuantity(obj,index){
		var rw=obj.parentNode.parentNode;
		Materials[index][8] = parseFloat(rw.cells[9].childNodes[0].value);		
}

function LoadSubStores()
{
	var mainStores	= document.getElementById('cboMainStores').value;	
	
	RomoveData("cboSubStores")
	createXMLHttpRequest2(1);
	xmlHttp2[1].onreadystatechange=LoadSubStoresRequest;
	xmlHttp2[1].open("GET",'returntostoresxml.php?RequestType=LoadSubStores&mainStores=' +mainStores ,true);
	xmlHttp2[1].send(null);	
}

function LoadSubStoresRequest()
{
	if (xmlHttp2[1].readyState==4)
	{
		if (xmlHttp2[1].status==200)
		{				
			pub_commonBin = xmlHttp2[1].responseXML.getElementsByTagName("CommonBinId")[0].childNodes[0].nodeValue;
			document.getElementById('commonBinID').title = pub_commonBin;
					/*var opt = document.createElement("option");
					opt.text ="Select One";
					opt.value = "";
					document.getElementById("cboSubStores").options.add(opt);*/
					
			var XMLSubID =xmlHttp2[1].responseXML.getElementsByTagName("SubID");
			var XMLSubStoresName =xmlHttp2[1].responseXML.getElementsByTagName("SubStoresName");
			
				for ( var loop = 0; loop < XMLSubID.length; loop ++)
				{							
					var opt = document.createElement("option");
					opt.text = XMLSubStoresName[loop].childNodes[0].nodeValue;	
					opt.value = XMLSubID[loop].childNodes[0].nodeValue;	
					document.getElementById("cboSubStores").options.add(opt);			
				}
		}
	}
}

function SetLocationItemQuantity(obj,index)
{
		var rw=obj.parentNode.parentNode.parentNode;
		Materials[index][8] = rw.cells[9].childNodes[0].value;		
}
	
function ValidateBinBinDetails(rowNo,index){
	var rw					= rowNo.parentNode.parentNode.parentNode;
	var issueQty			= parseFloat(rw.cells[9].childNodes[0].value);
	pub_commonBin			= document.getElementById('commonBinID').title;
	pub_mainStoreID			= document.getElementById('cboMainStores').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;
	pub_subCatID			= rw.cells[1].id;	
	pub_index				= index;
	mainRw 					= rowNo.parentNode.parentNode.parentNode.rowIndex;
	
	if(pub_mainStoreID==""){
		alert("Please select the Main Stores.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	if(pub_subStoreID==""){
		alert("Please select the Sub Stores.");
		document.getElementById('cboSubStores').focus();
		return;
	}	
	
	if(pub_commonBin==1){alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");return;}
	
	loadBins(rowNo,pub_mainStoreID,pub_subStoreID,issueQty);
}
function loadBins(rowNo,mainStoreID,subStoreID,issueQty)
{
	//alert(rowNo);
	createXMLHttpRequest2(2);	
	xmlHttp2[2].onreadystatechange=loadBinsRequest;
	xmlHttp2[2].open("GET",'binitems.php?mainStoreID=' +mainStoreID+ '&subStoreID=' +subStoreID+ '&issueQty=' +issueQty+ '&index=' +pub_index+ '&subCatID=' +pub_subCatID ,true);
	xmlHttp2[2].send(null);
}
	function loadBinsRequest(){
		if (xmlHttp2[2].readyState==4){
			if (xmlHttp2[2].status==200){
				
				drawPopupArea(570,418,'frmMaterialTransfer');				
				var HTMLText=xmlHttp2[2].responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;
				loadPendingBinDet();
			}
		}
	}
	
function LoadBinDetauls(){
	RemoveAllRows('tblBinItem')
	createXMLHttpRequest2(3);
	var location 		= document.getElementById('cboLocation').value;
	xmlHttp2[3].onreadystatechange=LoadBinDetailsRequest;
	xmlHttp2[3].open("GET",'returntostoresxml.php?RequestType=LoadBinDetauls&mainStoreID=' +pub_mainStoreID+ '&subStoreID=' +pub_subStoreID+ '&location=' +location+ '&subCatID=' +pub_subCatID ,true);
	xmlHttp2[3].send(null);
}	
		function LoadBinDetailsRequest(){	
			
			if (xmlHttp2[3].readyState==4){
				if (xmlHttp2[3].status==200){
					
					var XMLDiferent 	= xmlHttp2[3].responseXML.getElementsByTagName('Diferent');
					var XMLBinName 		= xmlHttp2[3].responseXML.getElementsByTagName('BinName');
					var XMLBinID 		= xmlHttp2[3].responseXML.getElementsByTagName('BinID');
					var XMLMainID 		= xmlHttp2[3].responseXML.getElementsByTagName('MainID');
					var XMLSubID 		= xmlHttp2[3].responseXML.getElementsByTagName('SubID');
					var XMLLocID 		= xmlHttp2[3].responseXML.getElementsByTagName('LocID');
					var XMLUnit 		= xmlHttp2[3].responseXML.getElementsByTagName('Unit');
					
					var tblmain			= document.getElementById("tblMain");
					var tbl 			= document.getElementById("tblBinItem");	
					
					for (loop=0;loop<XMLBinName.length;loop++)
					{
						var strInnerHtml="";	
						strInnerHtml +="<td class=\"normalfntRite\">"+XMLDiferent[loop].childNodes[0].nodeValue+"</td> ";
                        strInnerHtml +="<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\"0\" /></td>";
                        strInnerHtml +="<td class=\"normalfnt\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"GetStockQty(this);\">";                        
                        strInnerHtml +="<td class=\"normalfnt\" id=\""+XMLBinID[loop].childNodes[0].nodeValue+"\">"+XMLBinName[loop].childNodes[0].nodeValue+"</td>";
                        strInnerHtml +="<td class=\"normalfntSM\">"+XMLMainID[loop].childNodes[0].nodeValue+"</td>";
                        strInnerHtml +="<td class=\"normalfntSM\">"+XMLSubID[loop].childNodes[0].nodeValue+"</td>";
                        strInnerHtml +="<td class=\"normalfntSM\">"+XMLLocID[loop].childNodes[0].nodeValue+"</td>";      
						
						var lastRow = tbl.rows.length;	
						var row = tbl.insertRow(lastRow);						
						tbl.rows[lastRow].innerHTML=  strInnerHtml ;
						tbl.rows[lastRow].id = lastRow;
					}
				}
			}
		}
//Start - bin qty validate part
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[2].childNodes[0].childNodes[0].checked){
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[0].lastChild.nodeValue);
		var issueQty = rw.cells[1].childNodes[0].value;
		rw.cells[1].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
				if (tbl.rows[loop].cells[2].childNodes[0].childNodes[0].checked){		
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[1].childNodes[0].value);
					}				
			}		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty) ;

					if (reqQty <= reduceQty ){
						rw.cells[1].childNodes[0].value = reqQty ;
					}
					else{
						 rw.cells[1].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[1].childNodes[0].value = 0;
}
//End - bin qty validate part

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++){
			if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[0].checked){		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[0].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblBin.rows[loop].cells[3].id; // BinId							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[mainRw].className = "bcgcolor-tblrowLiteBlue";//osc3,backcolorGreen,normalfnt2BITAB
		tblMain.rows[mainRw].cells[10].id =1;
		closeWindow();		
	}
	else{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
	
}
function ValidateQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var Qty 		= parseFloat(rw.cells[9].childNodes[0].value);
	var StockQty 	= parseFloat(rw.cells[8].childNodes[0].nodeValue);	
		
	if(Qty>StockQty)
	{		
		rw.cells[9].childNodes[0].value=StockQty;
	}
}

function RemoveBinColor(obj)
{
	if(pub_commonBin==1)return;
	var tblMain =document.getElementById("tblMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[10].id =0;
}
function SaveValidation(obj)
{
	pub_state				= obj;
	pub_mainStoreID			= document.getElementById('cboMainStores').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;
	var tblMain				= document.getElementById('tblMain');
	var ReturnBy			= document.getElementById('cboReturnBy').value;

	if(ReturnBy==""){
		alert("Please select the Return By.");
		document.getElementById('cboReturnBy').focus();
		return false
	}
	
	if(pub_state==1){
		if(pub_mainStoreID==""){
			alert("Please select the Main Stores.");
			document.getElementById('cboMainStores').focus();
			return false
		}
		if(pub_subStoreID==""){
			alert("Please select the Sub Stores.");
			document.getElementById('cboSubStores').focus();
			return false
		}
	}
		if(tblMain.rows.length <=1){alert("No details appear to save....");return false}
		
		for (loop = 1 ;loop < tblMain.rows.length; loop++)
		{
			var issueQty = parseFloat(tblMain.rows[loop].cells[9].childNodes[0].value);
			var stockQty = parseFloat(tblMain.rows[loop].cells[8].childNodes[0].nodeValue);
			
				if ((issueQty=="")  || (issueQty==0)){
					alert ("Issue qty can't be '0' or empty.")
					return false;				
				} 
					
				if(pub_commonBin==0 && pub_state==1){
					var checkBinAllocate = tblMain.rows[loop].cells[10].id;				 
						if (checkBinAllocate==0){
							alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +"." )
							return false;				
						}			
				}
		}
	checkLoop = 0;
	showBackGroundBalck();
	LoadJobNo();
}
function LoadJobNo()
{
	var No = document.getElementById("txtReturnNo").value
	if (No=="")
	{
		createXMLHttpRequest();
		xmlHttp.onreadystatechange=LoadJobNoRequest;
		xmlHttp.open("GET",'returntostoresxml.php?RequestType=LoadNo',true);
		xmlHttp.send(null);
	}
	else
	{		
		No = No.split("/");
		
		pub_returnNo =parseInt(No[1]);
		pub_returnYear = parseInt(No[0]);
		Save();
	}
}
	function LoadJobNoRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				
				var XMLAdmin	= xmlHttp.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
				if(XMLAdmin=="TRUE"){
				var XMLNo 	= xmlHttp.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
				var XMLYear = xmlHttp.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
				pub_returnNo =parseInt(XMLNo);
				pub_returnYear = parseInt(XMLYear);
				document.getElementById("txtReturnNo").value=pub_returnYear + "/" + pub_returnNo;			
				Save();
				
				}
				else{
					alert("Please contact system administrator to assign new Return No....");
					hideBackGroundBalck();
				}
			}
		}
		
	}
	
function Save()
{
	validateCount 		= 0;
	validateBinCount	= 0;
	
	if(document.getElementById("txtReturnNo").value==""){alert ("No return no to save....");return}	

	var remarks 		= document.getElementById('txtRemarks').value;
	var returnBy 		= document.getElementById('cboReturnBy').value;
	var mainStore      =  document.getElementById('cboMainStores').value;
	createXMLHttpRequest();
	xmlHttp.open("GET",'returntostoresxml.php?RequestType=SaveHeader&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&remarks=' +URLEncode(remarks)+ '&returnBy=' +returnBy ,true);
	xmlHttp.send(null);
		//alert( Materials.length);
	
	//start 2010-11-09 delete returntostore details before save
		var url = 'returntostoresxml.php?RequestType=deleteReturnStoreDetails';
			url += '&returnNo='+pub_returnNo;
			url += '&returnYear='+pub_returnYear;
		var htmlobj=$.ajax({url:url,async:false});
		
	//end 2010-11-09	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{
			var StyleID 		= details[0];
			var buyerPoNo 		= details[1];	
			var itemDetailID    = details[2];	
			var color 			= details[3];	
			var size 			= details[4];
			var binArray 		= details[5];
			var units 			= details[6];	
			var issueNo 		= details[7];	
			var qty 			= details[8];
			var subCatID		= details[9];
			var mrnNo			= details[10];
			var grnNo 			= details[11];
			var grnType			= details[12];
			validateCount++;
			
			
/*	createXMLHttpRequest2(loop);
	xmlHttp2[loop].open("GET",'returntostoresxml.php?RequestType=SaveDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&issueNo=' +issueNo+ '&qty=' +qty+ '&mrnNo=' +mrnNo+ '&status=' +pub_state +'&grnNo='+grnNo,true);
	xmlHttp2[loop].send(null);*/
	var url = 'returntostoresxml.php?RequestType=SaveDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&issueNo=' +issueNo+ '&qty=' +qty+ '&mrnNo=' +mrnNo+ '&status=' +pub_state +'&grnNo='+grnNo+'&grnType='+grnType;
	var htmlobj=$.ajax({url:url,async:false});
			try{
				if(pub_commonBin==0 && mainStore !=''){
					for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 		= binArray[i];
						var binQty 			= Bindetails[0];  // issueQty
						var mainStoreId		= Bindetails[1];  // MainStores
						var subStoreId		= Bindetails[2];  // SubStores
						var locationId		= Bindetails[3];  // Location
						var binId			= Bindetails[4];  // BinId							
						validateBinCount++;
					
/*						createXMLHttpRequest4(i);
						xmlHttp4[i].open("GET",'returntostoresxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&locationId=' +locationId+ '&binId=' +binId+ '&subCatID=' +subCatID+ '&commonBin=' +pub_commonBin +'&grnNo='+grnNo,true);
						xmlHttp4[i].send(null);*/
						var url='returntostoresxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&locationId=' +locationId+ '&binId=' +binId+ '&subCatID=' +subCatID+ '&commonBin=' +pub_commonBin +'&grnNo='+grnNo+'&grnType='+grnType;
						//alert(url);
						var htmlobj=$.ajax({url:url,async:false});
						
					}
				}
				else
				{
		/*			createXMLHttpRequest4(1);
					xmlHttp4[1].open("GET",'returntostoresxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&binQty=' +qty+ '&mainStoreId=' +pub_mainStoreID+ '&subStoreId=' +pub_subStoreID+ '&subCatID=' +subCatID+ '&commonBin=' +pub_commonBin ,true);
					xmlHttp4[1].send(null);*/
					validateBinCount++;
					var url ='returntostoresxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&binQty=' +qty+ '&mainStoreId=' +pub_mainStoreID+ '&subStoreId=' +pub_subStoreID+ '&subCatID=' +subCatID+ '&commonBin=' +pub_commonBin+'&grnNo='+grnNo+'&grnType='+grnType;
					
					var htmlobj=$.ajax({url:url,async:false});
				}
			}
			catch(err)
			{
			}
		}
	}
	if(pub_state==1)
		ConfirmReturn(document.getElementById("txtReturnNo").value);
	else
		SaveValidate();
}
function SaveValidate()
{	
	createXMLHttpRequest5(1);
	xmlHttp5[1].onreadystatechange = SaveValidateRequest;
	xmlHttp5[1].open("GET",'returntostoresxml.php?RequestType=SaveValidate&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount+ '&pub_state=' +pub_state ,true);
	xmlHttp5[1].send(null);
}
	function SaveValidateRequest()
	{
		if(xmlHttp5[1].readyState == 4) 
		{
			if(xmlHttp5[1].status == 200)
			{				
				var XMLCountHeader= xmlHttp5[1].responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
				var XMLCountDetails= xmlHttp5[1].responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;				
				var XMLCountBinDetails= xmlHttp5[1].responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
					
					if(pub_state==1){
						if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE") &&(XMLCountBinDetails=="TRUE"))
						{
							
						alert ("Return to Store No : " + document.getElementById("txtReturnNo").value +  " confirmed successfully.");
						document.getElementById("cmdSave").style.display="none";
						document.getElementById("cmdConfirm").style.display="none";
						document.getElementById("cmdCancel").style.display="inline";	
						document.getElementById("cmdAddNew").style.visibility="hidden";
						hideBackGroundBalck();
							
						}
						else 
						{
							checkLoop++;
							if(checkLoop>50){
								alert("Sorry!\nError occured while saving the data. Please save it again.");
								hideBackGroundBalck();
								checkLoop = 0;
								return;
							}
							else{
								SaveValidate();											
							}
						}
					}
					else{
						if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE"))
						{
							alert ("Return No : " + document.getElementById("txtReturnNo").value +  " saved successfully.");							
							document.getElementById("cmdSave").style.display="inline";
							if(confirmReturn)
								document.getElementById("cmdConfirm").style.display="inline";
							document.getElementById("cmdCancel").style.display="none";
							document.getElementById("cmdAddNew").style.visibility="hidden";
							hideBackGroundBalck();
							
						}
						else 
						{
							checkLoop++;
							if(checkLoop>50){
								alert("Sorry!\nError occured while saving the data. Please Save it again.");
								hideBackGroundBalck();
								checkLoop = 0;
								return;
							}
							else{
								SaveValidate();											
							}
						}
					}
			}
		}
	}
	
function ViewReport()
{
	var No =document.getElementById("txtReturnNo").value;	
	if(No==""){alert("No Return No to view.");return}
	No = No.split("/");
	
	ReturnNo =No[1];
	ReturnYear =No[0];
	
	newwindow=window.open('returntostoresreport.php?ReturnNo='+ReturnNo+ '&ReturnYear=' +ReturnYear ,'name');
	if (window.focus) {newwindow.focus()}
}

//Start - Saved Details PopUp window
function LoadPopUpNo()
{
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state	= document.getElementById('cboState').value;
	var year	= document.getElementById('cboYear').value;
	
	var url = 'returntostoresxml.php?RequestType=LoadPopUpReturnYear&state='+state+'&year='+year;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboYear').innerHTML = htmlobj.responseText;
	
	var url = 'returntostoresxml.php?RequestType=LoadPopUpReturnNo&state='+state+'&year='+year;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboNo').innerHTML = htmlobj.responseText;
}

function LoadPopUpJobNoRequest()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboNo").options.add(opt);
	
			 var XMLReturnNo= xmlHttp.responseXML.getElementsByTagName("ReturnNo");
			 for ( var loop = 0; loop < XMLReturnNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = XMLReturnNo[loop].childNodes[0].nodeValue;
				opt.value = XMLReturnNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboNo").options.add(opt);
			 }
			 
		}
	}
}
function loadPopUpReturnToStores()
{
	document.getElementById('NoSearch').style.visibility = "hidden";	
	 No=document.getElementById('cboNo').value;
	 Year=document.getElementById('cboYear').value;
	pub_state = document.getElementById('cboState').value;
	
	if (No=="")return false;	
	
	createXMLHttpRequest5(1);
	xmlHttp5[1].onreadystatechange=LoadHeaderDetailsRequest;
	xmlHttp5[1].open("GET",'returntostoresxml.php?RequestType=LoadPopUpHeaderDetails&No=' +No+ '&Year=' +Year ,true);
	xmlHttp5[1].send(null);
	
	createXMLHttpRequest5(2);
	xmlHttp5[2].onreadystatechange=LoadDetailsRequest;
	xmlHttp5[2].open("GET",'returntostoresxml.php?RequestType=LoadPopUpDetails&No=' +No+ '&Year=' +Year ,true);
	xmlHttp5[2].send(null);
}
	function LoadHeaderDetailsRequest()
	{
		if (xmlHttp5[1].readyState==4)
		{
			if (xmlHttp5[1].status==200)
			{
				var XMLReturnNo 	= xmlHttp5[1].responseXML.getElementsByTagName("ReturnNo")[0].childNodes[0].nodeValue;
				var XMLReturnedBy 	= xmlHttp5[1].responseXML.getElementsByTagName("ReturnedBy")[0].childNodes[0].nodeValue;
				var XMLStatus 		= parseInt(xmlHttp5[1].responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);
				var XMLRemarks 		= xmlHttp5[1].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
				
			
				document.getElementById("txtReturnNo").value =XMLReturnNo;
				document.getElementById("cboReturnBy").value =XMLReturnedBy ;
				document.getElementById("txtRemarks").value =XMLRemarks ;			
				
					switch (XMLStatus){	
						case 0:	
							document.getElementById("cmdSave").style.display="inline";
							if(confirmReturn)
								document.getElementById("cmdConfirm").style.display="inline";
							document.getElementById("cmdCancel").style.display="none";
							document.getElementById("cmdAddNew").style.visibility="hidden";
							break;	
						case 1:	
							document.getElementById("cmdSave").style.display="none";
							document.getElementById("cmdConfirm").style.display="none";
							document.getElementById("cmdCancel").style.display="inline";
							document.getElementById("cmdAddNew").style.visibility="hidden";
							break;				
						case 10:						
							document.getElementById("cmdSave").style.display="none";						
							document.getElementById("cmdCancel").style.display="none";	
							document.getElementById("cmdAddNew").style.visibility="hidden";
							document.getElementById("cmdConfirm").style.display="none";
							break;							
					}
			}
		}		
	}
	
	function LoadDetailsRequest()
	{
		if (xmlHttp5[2].readyState==4)
		{
			if (xmlHttp5[2].status==200)
			{	
				RemoveAllRows('tblMain');
				var tbl 				= document.getElementById("tblMain");
		var XMLIssueNo 			= xmlHttp5[2].responseXML.getElementsByTagName("IssueNo");
		var XMLIssueYear 		= xmlHttp5[2].responseXML.getElementsByTagName("IssueYear");				
		var XMLItemDescription 	= xmlHttp5[2].responseXML.getElementsByTagName("ItemDescription");
		var XMLStyleID 			= xmlHttp5[2].responseXML.getElementsByTagName("StyleID");
		var XMLStyleName 			= xmlHttp5[2].responseXML.getElementsByTagName("StyleName");
		var XMLBuyerPONO 		= xmlHttp5[2].responseXML.getElementsByTagName("BuyerPONO");
		var XMLBuyerPOName 		= xmlHttp5[2].responseXML.getElementsByTagName("BuyerPOName");
		var XMLColor 			= xmlHttp5[2].responseXML.getElementsByTagName("Color");				
		var XMLSize 			= xmlHttp5[2].responseXML.getElementsByTagName("Size");
		var XMLUnit 			= xmlHttp5[2].responseXML.getElementsByTagName("Unit");
		var XMLIssueQty 		= xmlHttp5[2].responseXML.getElementsByTagName("IssueQty");
		var XMLReturnQty 		= xmlHttp5[2].responseXML.getElementsByTagName("ReturnQty");
		var XMLMatdetailId 		= xmlHttp5[2].responseXML.getElementsByTagName("MatdetailId");
		var XMLMatSubCatID 		= xmlHttp5[2].responseXML.getElementsByTagName("MatSubCatID");
		var XMLMatrequisitionNo = xmlHttp5[2].responseXML.getElementsByTagName("MatrequisitionNo");
		var XMLMatrequisitionYear = xmlHttp5[2].responseXML.getElementsByTagName("MatrequisitionYear");
		var GRNno = xmlHttp5[2].responseXML.getElementsByTagName("GRNno");
		var grnType = xmlHttp5[2].responseXML.getElementsByTagName("grnType");
		var strGRNType = xmlHttp5[2].responseXML.getElementsByTagName("strGRNType");
		var returnNo = Year+'/'+No;	
		
				for (loop=0;loop<XMLStyleID.length;loop++)
				{
				var mrnNo	= XMLMatrequisitionYear[loop].childNodes[0].nodeValue+"/"+XMLMatrequisitionNo[loop].childNodes[0].nodeValue
				var matdetailId	= XMLMatdetailId[loop].childNodes[0].nodeValue;
				 var strInnerHtml="";
				 if(pub_state == 0)
				 {
					 strInnerHtml+="<td class=\"normalfnt\"><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"" + mainArrayIndex + "\" onclick=\"RemoveItem(this);\"/></div></td>";
				 }
				 else
				 {
					 strInnerHtml+="<td class=\"normalfnt\"><div align=\"center\"></div></td>";
				 }
				
				strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLMatSubCatID[loop].childNodes[0].nodeValue+"\">"+XMLIssueYear[loop].childNodes[0].nodeValue+"/"+XMLIssueNo[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+matdetailId+"\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLStyleID[loop].childNodes[0].nodeValue +"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue +"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+mrnNo+"\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLIssueQty[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLReturnQty[loop].childNodes[0].nodeValue+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQuantity(this," + mainArrayIndex  + ");\" /></td>";
				strInnerHtml+="<td class=\"normalfntMidSML\"><div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\"  height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div></td>";
				strInnerHtml+="<td class=\"normalfnt\">"+GRNno[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml+="<td class=\"normalfnt\" id=\""+grnType[loop].childNodes[0].nodeValue+"\">"+strGRNType[loop].childNodes[0].nodeValue+"</td>";
				
				var details		= [];
				details[0]	= XMLStyleID[loop].childNodes[0].nodeValue;
			    details[1]	= XMLBuyerPONO[loop].childNodes[0].nodeValue;
			    details[2]	= matdetailId;
			    details[3]	= XMLColor[loop].childNodes[0].nodeValue;
				details[4]	= XMLSize[loop].childNodes[0].nodeValue;
				details[6]	= XMLUnit[loop].childNodes[0].nodeValue;
				details[7]	= XMLIssueYear[loop].childNodes[0].nodeValue+"/"+XMLIssueNo[loop].childNodes[0].nodeValue;
				details[8]	= parseFloat(XMLReturnQty[loop].childNodes[0].nodeValue);
				details[9]	= XMLMatSubCatID[loop].childNodes[0].nodeValue;//subCatId
				details[10]	= mrnNo;//mrnNo
				details[11]	= GRNno[loop].childNodes[0].nodeValue;
				details[12]	= grnType[loop].childNodes[0].nodeValue;
				var BuyerPoNo = XMLBuyerPONO[loop].childNodes[0].nodeValue;
			Materials[mainArrayIndex]= details;
			
			
				 var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);						
				tbl.rows[lastRow].innerHTML=  strInnerHtml ;
				tbl.rows[lastRow].id = lastRow;
				//if(pub_state)
				tbl.rows[lastRow].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB
				
				
				var url = 'returntostoresxml.php?RequestType=LoadPendingConfirmBinDetails&returnNo=' +returnNo+ '&styleId=' +URLEncode(details[0])+ '&buyerPoNo=' +URLEncode(BuyerPoNo)+ '&matDetailID=' +details[2]+ '&color=' +URLEncode(details[3])+ '&size=' +URLEncode(details[4])+'&pub_state='+pub_state;
				
				var htmlobj=$.ajax({url:url,async:false});
				
					var XMLBinQty =htmlobj.responseXML.getElementsByTagName("Qty");
					var XMLMainStoresID =htmlobj.responseXML.getElementsByTagName("MainStoresID");
					var XMLSubStores =htmlobj.responseXML.getElementsByTagName("SubStores");
					var XMLLocation =htmlobj.responseXML.getElementsByTagName("Location");
					var XMLBin =htmlobj.responseXML.getElementsByTagName("Bin");
					var XMLMatSubCatId =htmlobj.responseXML.getElementsByTagName("MatSubCatId");
					
					
					var mainBinArrayIndex = 0;
					var BinMaterials = [];
					//alert(XMLMainStoresID.length);
					for (no=0;no<XMLMainStoresID.length;no++)
					{						
							var arrayIndex =mainArrayIndex;				
								//alert(arrayIndex);	
								//var Bindetails = [];
							var Bindetails = [];
							Bindetails[0] =   details[8];
							Bindetails[1] =   XMLMainStoresID[no].childNodes[0].nodeValue; // MainStores
							Bindetails[2] =   XMLSubStores[no].childNodes[0].nodeValue; // SubStores
							Bindetails[3] =   XMLLocation[no].childNodes[0].nodeValue;// Location
							Bindetails[4] =   XMLBin[no].childNodes[0].nodeValue; // Bin ID
							
							Bindetails[5] =   XMLMatSubCatId[no].childNodes[0].nodeValue; // MatSubCategoryId
							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
							Materials[arrayIndex][5] = BinMaterials;
							if(XMLMainStoresID[no].childNodes[0].nodeValue == 'Null')
								tbl.rows[arrayIndex+1].className = "bcgcolor-tblrowWhite";
							else
								tbl.rows[arrayIndex+1].className = "bcgcolor-tblrowLiteBlue";
							tbl.rows[arrayIndex+1].cells[10].id =1;
					}
					if(XMLMainStoresID[0].childNodes[0].nodeValue != 'Null')
					{
						document.getElementById('cboMainStores').value = XMLMainStoresID[0].childNodes[0].nodeValue;
						LoadSubStores();
						document.getElementById('cboSubStores').value = XMLSubStores[0].childNodes[0].nodeValue;
						//alert(XMLSubStores[0].childNodes[0].nodeValue);
					}
					else
					{
						document.getElementById('cboMainStores').value='';
						document.getElementById('cboSubStores').value='';
					}
					
					
		mainArrayIndex++;
				}
				
				mainArrayIndex=0;
			}
		}
	}
//End - Saved Details PopUp window

//Start - Cancel part
function Cancel()
{	
	showBackGroundBalck();
	var No = document.getElementById("txtReturnNo").value;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=GatePassCancelRequest;
	xmlHttp.open("GET",'returntostoresxml.php?RequestType=Cancel&No=' +No ,true);
	xmlHttp.send(null);
}

	function GatePassCancelRequest()
	{
		if (xmlHttp.readyState==4)
		{
		 	if (xmlHttp.status==200)
			{
				//var intConfirm = xmlHttp.responseText;	
				var intConfirm = xmlHttp.responseXML.getElementsByTagName("cancelResponse")[0].childNodes[0].nodeValue;
				//if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1"){	
				if (intConfirm==1){	
					alert ("Return No : " + document.getElementById("txtReturnNo").value +  " cancelled successfully.");
					document.getElementById("cmdSave").style.display="none";
					document.getElementById("cmdConfirm").style.display="none";
					document.getElementById("cmdCancel").style.display="none";	
					document.getElementById("cmdAddNew").style.visibility="hidden";
					hideBackGroundBalck();
				}
				else{
					//alert("Sorry!\nError occured while cancel the data. Please cancel it again.");
					alert(intConfirm);
					hideBackGroundBalck();
				}
					
			}
		}
	}	
//End - Cancel part

function Confirm()
{
	state = 1;
	if(SaveValidation(1)==false)
		return ;
	//var no = document.getElementById("txtReturnNo").value;	
	//if(confirm('Are you sure you want to confirm this Return No : '+no+'?'))
	//{	
	//ConfirmReturn(no);	
	//}			
		
}

function ConfirmReturn(no)
{
	var url = 'returntostoresxml.php?RequestType=ConfirmReturn&no=' +no;
	var htmlobj=$.ajax({url:url,async:false});
	SaveValidate();

}
	function ConfirmReturnRequest()
	{
		if (xmlHttp1.readyState==4)
		{
			if (xmlHttp1.status==200)
			{
				
				//var intConfirm = xmlHttp1.responseText;	
				 var intConfirm = xmlHttp1.responseXML.getElementsByTagName("cancelResponse")[0].childNodes[0].nodeValue;
				if (intConfirm=="1")
				{					
					alert ("Return to Store No : " + document.getElementById("txtReturnNo").value +  " confirmed successfully.");
					document.getElementById("cmdSave").style.display="none";
					document.getElementById("cmdConfirm").style.display="none";
					document.getElementById("cmdCancel").style.display="inline";	
					document.getElementById("cmdAddNew").style.visibility="hidden";
				hideBackGroundBalck();
				}
			}
		}
	}
	
function closeFindReturnNo()
{
	document.getElementById("NoSearch").style.visibility="hidden";
}
function loadPendingBinDet()
{
	//alert(pub_index);
	var details = Materials[pub_index] ;
			var binArray	= details[5];
	
var 	strText = "<table id=\"tblBinItemPending\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
						"<tr class=\"mainHeading4\">"+
						  "<td width=\"25%\" height=\"25\">Main Stores</td>"+
						  "<td width=\"20%\" >Sub Stores</td>"+
						  "<td width=\"20%\" >Location</td>"+
						  "<td width=\"15%\" >Bin ID</td>"+
						  "<td width=\"10%\" >Allocated Qty</td>"+
                        "</tr>";
	try{
				for (loop=0;loop<binArray.length;loop++)
				{			
				var Bindetails 			= binArray[loop];
				
				var url ="returntostoresxml.php?RequestType=GetAllocatedBinQty";
				url +="&msId="+ Bindetails[1];
				url +="&ssId="+ Bindetails[2];
				url +="&locId="+ Bindetails[3];
				url +="&binId="+ Bindetails[4];	
				
				htmlobj=$.ajax({url:url,async:false});
				var XMLMainStore= htmlobj.responseXML.getElementsByTagName('MainStore');
				var XMLSubStore	= htmlobj.responseXML.getElementsByTagName('SubStore');
				var XMLLocation	= htmlobj.responseXML.getElementsByTagName('Location');
				var XMLBin		= htmlobj.responseXML.getElementsByTagName('Bin');

				strText  +="<tr class=\"bcgcolor-tblrowWhite\">"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[1]+"\">"+XMLMainStore[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[2]+"\">"+XMLSubStore[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[3]+"\">"+XMLLocation[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[4]+"\">"+XMLBin[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfntRite\" id=\""+Bindetails[0]+"\">"+Bindetails[0]+"</td>"+
							 "</tr>";
				}
			}
			catch(err){
			}
			strText +="</table>";
			document.getElementById("tblBinItemPending").innerHTML=strText;
			
}