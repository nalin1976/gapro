var xmlHttp;
var altxmlHttp;

var Materials 				= [];
var xmlHttp					= [];
var xmlHttp1 				= [];
var xmlHttp2 				= [];

var mainRw					= 0;
var pub_commonBin			= 0;
var mainArrayIndex 			= 0;
var pub_mainStoreID			= 0;
var pub_subStoreID			= 0;
var pub_index				= 0;
var pub_returnToSupNo		= 0;
var pub_returnToSupYear		= 0;
var checkLoop				= 0;

var validateCount 			= 0;
var validateBinCount		= 0;
	
function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function createXMLHttpRequest(index){
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function createXMLHttpRequest1(index){
    if (window.ActiveXObject) 
    {
        xmlHttp1[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1[index] = new XMLHttpRequest();
    }
}

function createXMLHttpRequest2(index){
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}

function GetXmlHttpObject(){
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

function RomoveData(data){
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
function isNumberKey(evt){
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

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;
		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tro.parentNode.removeChild(tro);
		Materials[obj.id] = null;	
	}
}

function closeWindow(){
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

function PopUprowclickColorChange(obj){
	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById('tblItemPopUp');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "bcgcolor-tblrowWhite";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function rowclickColorChange(){
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblMain');
	
    for ( var i = 1; i < tbl.rows.length; i ++){
		tbl.rows[i].className = "bcgcolor-tblrow";
		if ((i % 2) == 1){
			tbl.rows[i].className="bcgcolor-tblrow";
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
function SeachStyle(){	
	var ScNo =document.getElementById("cboSCNO").value;//options[document.getElementById("cboSCNO").selectedIndex].text;	
	document.getElementById("cboStyleID").value =ScNo;	
	LoadSupplier();
}

function SeachSCNO(){
	var StyleID =document.getElementById("cboStyleID").value;//options[document.getElementById("cboStyleID").selectedIndex].text;
	document.getElementById("cboSCNO").value =StyleID;
	LoadSupplier();
}

function SelectAll(obj){
	var tbl 		= document.getElementById('tblItemPopUp');
	if(obj.checked){
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked=true;
		
		}
	}
	else{
		for(loop=1;loop<tbl.rows.length;loop++)	{
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked=false;	
	}
	}
}

function LoadBuyerPoNo(){		
	var StyleID =document.getElementById("cboStyleID").value;
	createXMLHttpRequest(1);
	RomoveData("cboBuyerPoNo")
	xmlHttp[1].onreadystatechange=LoadBuyerPoNoRequest;
	xmlHttp[1].open("GET",'returntosupplierxml.php?RequestType=LoadBuyetPoNo&StyleID=' + URLEncode(StyleID) ,true);
	xmlHttp[1].send(null);
}
	function LoadBuyerPoNoRequest(){
		if (xmlHttp[1].readyState==4){
			if (xmlHttp[1].status==200){
					/*	var opt = document.createElement("option");
						opt.text ="Select Buyer PO NO";
						document.getElementById("cboBuyerPoNo").options.add(opt);*/
						
				var XMLBuyerPoNo =xmlHttp[1].responseXML.getElementsByTagName("BuyerPoNo");
				var XMLBuyerPoName =xmlHttp[1].responseXML.getElementsByTagName("BuyerPoName");
					for ( var loop = 0; loop < XMLBuyerPoNo.length; loop ++)
			 		{							
						var opt = document.createElement("option");
						opt.value = XMLBuyerPoNo[loop].childNodes[0].nodeValue;	
						opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;	
						document.getElementById("cboBuyerPoNo").options.add(opt);	
						//LoadSupplier();
			 		}

			 		LoadSupplier();
			}
		}
	}

function LoadSupplier(){		
	var StyleID 	= document.getElementById("cboStyleID").value;//options[document.getElementById("cboStyleID").selectedIndex].text;
	var BuyerPoNo 	= document.getElementById("cboBuyerPoNo").value;//options[document.getElementById("cboBuyerPoNo").selectedIndex].text;	
	createXMLHttpRequest(5);
	RomoveData("cboSupplier")
	xmlHttp[5].onreadystatechange=LoadSupplierRequest;
	xmlHttp[5].open("GET",'returntosupplierxml.php?RequestType=LoadSupplier&StyleID=' + URLEncode(StyleID) + '&BuyerPoNo=' +URLEncode(BuyerPoNo) ,true);
	xmlHttp[5].send(null);
}
	function LoadSupplierRequest(){
		if (xmlHttp[5].readyState==4){
			if (xmlHttp[5].status==200){
				
						var opt = document.createElement("option");
						opt.text ="Select Supplier";
						opt.value ="";
						document.getElementById("cboSupplier").options.add(opt);
						
				var XMLSupplierId =xmlHttp[5].responseXML.getElementsByTagName("SupplierId");
				var XMLSupplierTitle =xmlHttp[5].responseXML.getElementsByTagName("SupplierTitle");
					for ( var loop = 0; loop < XMLSupplierId.length; loop ++)
			 		{							
						var opt = document.createElement("option");
						opt.text = XMLSupplierTitle[loop].childNodes[0].nodeValue;	
						opt.value = XMLSupplierId[loop].childNodes[0].nodeValue;	
						document.getElementById("cboSupplier").options.add(opt);			
			 		}
			}
		}
	}
	
function LoadSubStores(){
	var mainStores	= document.getElementById('cboMainStores').value;
	var Status	= document.getElementById('titStatus').title;	
	
	RomoveData("cboSubStores")
	createXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=LoadSubStoresRequest;
	xmlHttp[2].open("GET",'returntosupplierxml.php?RequestType=LoadSubStores&mainStores=' +mainStores+ '&Status=' +Status ,true);
	xmlHttp[2].send(null);	
}
	function LoadSubStoresRequest(){
		if (xmlHttp[2].readyState==4){
			if (xmlHttp[2].status==200){
						var opt = document.createElement("option");
						opt.value ="";
						opt.text ="Select Sub Store";
						document.getElementById("cboSubStores").options.add(opt);
						
				var XMLSubID =xmlHttp[2].responseXML.getElementsByTagName("SubID");
				var XMLSubStoresName =xmlHttp[2].responseXML.getElementsByTagName("SubStoresName");
				var XMLCommonBin =xmlHttp[2].responseXML.getElementsByTagName("CommonBin");
				pub_commonBin=XMLCommonBin[0].childNodes[0].nodeValue;
				
					for ( var loop = 0; loop < XMLSubID.length; loop ++){
						
						var opt = document.createElement("option");
						opt.text = XMLSubStoresName[loop].childNodes[0].nodeValue;	
						opt.value = XMLSubID[loop].childNodes[0].nodeValue;	
						document.getElementById("cboSubStores").options.add(opt);			
			 		}
					
				 document.getElementById('titCommonBinID').title= pub_commonBin;
			}
		}
	}

function ValidatePopUpItems()
{
	var orderId 	= document.getElementById('cboStyleID');
	var buyerPoNo 	= document.getElementById('cboBuyerPoNo');
	var supplierId 	= document.getElementById('cboSupplier');	
	var mainStore 	= document.getElementById('cboMainStores');
	
	if(orderId.value == "")
	{
		alert("Please select the 'Order No'.");
		orderId.focus();
		return;
	}
	else if(buyerPoNo.value == "")
	{
		alert("Please select the 'Buyer PoNo'.");
		buyerPoNo.focus();
		return;
	}	
	else if(supplierId.value == "")
	{
		alert("Please select the 'Supplier'.");
		supplierId.focus();
		return;
	}
	else if(mainStore.value == "")
	{
		alert("Please select the 'Main Store'.");
		mainStore.focus();
		return;
	}
	
		OpenPopUp(orderId,buyerPoNo,supplierId,mainStore);
}
function OpenPopUp(orderId,buyerPoNo,supplierId,mainStore)
{	
	createXMLHttpRequest(3);	
	xmlHttp[3].onreadystatechange=LoadStockDetailsRequest;
	xmlHttp[3].open("GET",'returntosupplieritempopup.php?StyleID=' +URLEncode(orderId.value)+ '&buyerPoNo=' +URLEncode(buyerPoNo.value)+ '&supplierID=' +supplierId.value+ '&mainStore=' +mainStore.value ,true);
	xmlHttp[3].send(null);
}

function LoadStockDetailsRequest(){
	if (xmlHttp[3].readyState==4){
		if (xmlHttp[3].status==200){
			drawPopupArea(958,471,'frmMaterialTransfer');				
			var HTMLText=xmlHttp[3].responseText;
			document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
		}
	}
}
	
function AddToMainPage()
{
	
	pub_commonBin		= document.getElementById('titCommonBinID').title;
	//alert(pub_commonBin);
	var tblPopUp 		= document.getElementById('tblItemPopUp');
	var tblMain 		= document.getElementById('tblMain');	
	var styleID 		= document.getElementById('cboStyleID').value;
	var buyerPoNo 		= document.getElementById('cboBuyerPoNo').value;
	var styleName 		= document.getElementById('cboStyleID').options[document.getElementById('cboStyleID').selectedIndex].text;
	var buyerPoName 		= document.getElementById('cboBuyerPoNo').options[document.getElementById('cboBuyerPoNo').selectedIndex].text;
	
	for(loop=1;loop<tblPopUp.rows.length;loop++)
	{	
		if(tblPopUp.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var istempRow		= tblPopUp.rows[loop].cells[0].id;//check temp stock item or not.
			var grnNo			=  tblPopUp.rows[loop].cells[1].childNodes[0].nodeValue;	
			var PoNo			=  tblPopUp.rows[loop].cells[1].id;
			var itemDescription	=  tblPopUp.rows[loop].cells[3].childNodes[0].nodeValue;
			var itemDetailID 	=  tblPopUp.rows[loop].cells[3].id;			
			var color 			=  tblPopUp.rows[loop].cells[4].childNodes[0].nodeValue;
			var size 			=  tblPopUp.rows[loop].cells[5].childNodes[0].nodeValue;
			var units 			=  tblPopUp.rows[loop].cells[6].childNodes[0].nodeValue;
			var grnQty 			=  tblPopUp.rows[loop].cells[7].childNodes[0].nodeValue;
			var stockBal 		=  tblPopUp.rows[loop].cells[8].childNodes[0].nodeValue;
			var matSubCatId		=  tblPopUp.rows[loop].cells[6].id;		
					
			var booCheck = false;
				for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ ){
					var mainistempRow 	= tblMain.rows[mainLoop].cells[0].id;
					var mainGrnNo 		= tblMain.rows[mainLoop].cells[1].childNodes[0].nodeValue;
					var mainMatDetaiId 	= tblMain.rows[mainLoop].cells[2].id;
					var mainStyleId 	= tblMain.rows[mainLoop].cells[3].id;	
					var mainBuyerPoNo 	= tblMain.rows[mainLoop].cells[4].id;
					var mainColor 		= tblMain.rows[mainLoop].cells[5].childNodes[0].nodeValue;
					var mainSize 		= tblMain.rows[mainLoop].cells[6].childNodes[0].nodeValue;									
					
					if ((mainMatDetaiId==itemDetailID) && (mainBuyerPoNo==buyerPoNo) && (mainColor==color) && (mainSize==size) && (mainGrnNo==grnNo) && (mainStyleId==styleID) && (mainistempRow==istempRow))
					{
						booCheck = true;
					}	
				}
			if (booCheck == false){
			var lastRow 		= tblMain.rows.length;	
			var row 			= tblMain.insertRow(lastRow);
			if(istempRow=='0')
				row.className = "bcgcolor-tblrowWhite";	
			else
				row.className = "txtbox bcgcolor-InvoiceCostTrim";
			
			var cellDelete = row.insertCell(0); 
			cellDelete.id = istempRow;	
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"" + mainArrayIndex + "\" onclick=\"RemoveItem(this);\"/>";			
					
			var cellGrnNo = row.insertCell(1);
			cellGrnNo.className ="normalfntSM";			
			cellGrnNo.innerHTML =grnNo;			
					
			var cellDescription = row.insertCell(2);
			cellDescription.className ="normalfntMidSML";
			cellDescription.id =itemDetailID;
			cellDescription.innerHTML =itemDescription;
			
					
			var cellStyleID = row.insertCell(3);
			cellStyleID.className ="normalfntMidSML";						
			cellStyleID.id =styleID;
			cellStyleID.innerHTML =styleName;
					
			var cellBuyerPoNo = row.insertCell(4);
			cellBuyerPoNo.className ="normalfntMidSML";			
			cellBuyerPoNo.id =buyerPoNo;
			cellBuyerPoNo.innerHTML =buyerPoName;
			
					
			var celColor = row.insertCell(5);
			celColor.className ="normalfntMidSML";			
			celColor.innerHTML =color;
			
					
			var cellSize = row.insertCell(6);
			cellSize.className ="normalfntMidSML";			
			cellSize.innerHTML =size;
			
			var cellUnits = row.insertCell(7);
			cellUnits.className ="normalfntMidSML";			
			cellUnits.innerHTML =units;					
		
			var cellStockQty = row.insertCell(8);
			cellStockQty.className ="normalfntRiteSML";			
			cellStockQty.innerHTML =stockBal;
			
			var cellGrnQty = row.insertCell(9);
			cellGrnQty.className ="normalfntRiteSML";			
			cellGrnQty.innerHTML =grnQty;
			
			var cellTxt = row.insertCell(10);				
			cellTxt.className ="normalfntRiteSML";	
			cellTxt.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+0+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQuantity(this," + mainArrayIndex  + ");\" />";
			
			//if(pub_commonBin==0){
			var cellLocation = row.insertCell(11);	
			cellLocation.id=0;
			cellLocation.className ="normalfntRiteSML";	
			cellLocation.innerHTML ="<div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\"  height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div>";
			//}
			//Start - array
			var details		= [];
				details[0]	= styleID;
			    details[1]	= buyerPoNo;
			    details[2]	= itemDetailID;
			    details[3]	= color;
				details[4]	= size;
				details[6]	= units;
				details[7]	= grnNo;
				details[8]	= 0;	
				details[9]	= PoNo;
				details[10]	= matSubCatId;
				details[11]	= istempRow; //Is temp stock availabe or not(no trim inspection done)
				
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
		Materials[index][8] = parseFloat(rw.cells[10].childNodes[0].value);		
}

function SetLocationItemQuantity(obj,index){
		var rw=obj.parentNode.parentNode.parentNode;
		Materials[index][8] = rw.cells[10].childNodes[0].value;		
}

function ValidateQty(obj){
	var rw 				= obj.parentNode.parentNode;
	var ReturnQty 		= parseFloat(rw.cells[10].childNodes[0].value);
	var GrnQty 			= parseFloat(rw.cells[9].childNodes[0].nodeValue);	
	var StockQty 		= parseFloat(rw.cells[8].childNodes[0].nodeValue);	
	
	if(ReturnQty>StockQty){		
		rw.cells[10].childNodes[0].value=StockQty;
	}
	else if(ReturnQty>GrnQty){
		rw.cells[10].childNodes[0].value=GrnQty;
	}
}

function RemoveBinColor(obj){
	if(pub_commonBin==1)return;
	var tblMain =document.getElementById("tblMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	if(tblMain.rows[Rw].cells[0].id==0)
		tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";
	else
		tblMain.rows[Rw].className = "bcgcolor-InvoiceCostTrim";
		
	tblMain.rows[Rw].cells[11].id =0;
}

function ValidateBinBinDetails(rowNo,index){
	pub_mainStoreID			= document.getElementById('cboMainStores').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;
	mainRw 					= rowNo.parentNode.parentNode.parentNode.rowIndex;	
	var rw					= rowNo.parentNode.parentNode.parentNode;
	var issueQty			= parseFloat(rw.cells[10].childNodes[0].value);
	var matDetailID			= parseFloat(rw.cells[2].id);
	var styleID				= rw.cells[3].id;
	var buyerPoNo			= rw.cells[4].id;
	var color				= rw.cells[5].childNodes[0].nodeValue;
	var size				= rw.cells[6].childNodes[0].nodeValue;
	var grnNo				= rw.cells[1].childNodes[0].nodeValue;
	var isTempStock			= rw.cells[0].id;
	pub_index				= index;
	
	if(pub_mainStoreID=="")
	{
		alert("Please select the 'Main Stores'.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	else if(pub_subStoreID=="")
	{
		alert("Please select the 'Sub Stores'.");
		document.getElementById('cboSubStores').focus();
		return;
	}
	else if(issueQty<=0)
	{
		alert("Return Qty must be grater than '0'.");
		rw.cells[10].childNodes[0].select();
		return;
	}
	else if(pub_commonBin==1)
	{
		alert("Default bin system activated.\nNo need to allocate bins.\nAll the bin details will save to default bin automatically");
		return;
	}
	
	loadBins(rowNo,pub_mainStoreID,pub_subStoreID,issueQty,matDetailID,styleID,buyerPoNo,color,size,grnNo,isTempStock);
}

function loadBins(rowNo,mainStoreID,subStoreID,issueQty,matDetailID,styleID,buyerPoNo,color,size,grnNo,isTempStock){
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange=loadBinsRequest;
	xmlHttp[4].open("GET",'returntosupplierbinitems.php?mainStoreID=' +mainStoreID+ '&subStoreID=' +subStoreID+ '&issueQty=' +issueQty+ '&matDetailID=' +matDetailID+ '&styleID=' +styleID+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&grnNo=' +grnNo+ '&isTempStock=' +isTempStock ,true);
	xmlHttp[4].send(null);
}
	function loadBinsRequest(){
		if (xmlHttp[4].readyState==4){
			if (xmlHttp[4].status==200){
				
				drawPopupArea(570,304,'frmMaterialTransfer');				
				var HTMLText=xmlHttp[4].responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;					
			}
		}
	}
	
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[2].childNodes[0].childNodes[1].checked){
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[0].lastChild.nodeValue);
		var issueQty = rw.cells[1].childNodes[0].value;
		rw.cells[1].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
				if (tbl.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
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

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++){
			if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value); 	// BinQty
							Bindetails[1] =   tblBin.rows[loop].cells[5].childNodes[0].nodeValue; 			// MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[6].childNodes[0].nodeValue;			// SubStores
							Bindetails[3] =   tblBin.rows[loop].cells[4].id; 								// Location
							Bindetails[4] =   tblBin.rows[loop].cells[3].id; 								// BinId							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[mainRw].className = "bcgcolor-InvoiceCostPocketing";//osc3,backcolorGreen,normalfnt2BITAB
		tblMain.rows[mainRw].cells[11].id =1;
		closeWindow();		
	}
	else{
		alert ("Allocated qty must Equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
	
}

function SaveValidation()
{
	document.getElementById('cmdSave').style.display ="none";
	pub_mainStoreID			= document.getElementById('cboMainStores').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;
	supplierID				= document.getElementById('cboSupplier').value;
	var tblMain				= document.getElementById('tblMain');

	if(pub_mainStoreID==""){
		alert("Please select the 'Main Stores'.");
		document.getElementById('cboMainStores').focus();
		document.getElementById('cmdSave').style.display ="inline";
		return;
	}
	if(pub_subStoreID==""){
		alert("Please select the 'Sub Stores'.");
		document.getElementById('cboSubStores').focus();
		document.getElementById('cmdSave').style.display ="inline";
		return;
	}
	if(supplierID == "")
	{
		alert("Please select the 'Supplier'");
		document.getElementById('cboSupplier').focus();
		document.getElementById('cmdSave').style.display = "inline";
		return;
	}	
	if(tblMain.rows.length<=1){alert("No details appear to save.");return false;}
	
		for (loop = 1 ;loop < tblMain.rows.length; loop++)
		{
			var issueQty = parseFloat(tblMain.rows[loop].cells[10].childNodes[0].value);
			var GrnQty = parseFloat(tblMain.rows[loop].cells[9].childNodes[0].nodeValue);
			var stockQty = parseFloat(tblMain.rows[loop].cells[8].childNodes[0].nodeValue);
			
				if ((issueQty=="")  || (issueQty==0)){
					alert ("Issue qty can't be '0' or empty.")
					document.getElementById('cmdSave').style.display ="inline";
					return false;				
				} 
				
				if(issueQty>stockQty){		
					alert("Return qty connot exceed stock balance\nIn line no : "+[loop]+"\nReturn Qty is "+issueQty+"\nStock Balance is"+stockQty+"\nVariance is : "+stockQty-issueQty+".")
				}
				if(issueQty>GrnQty){		
					alert("Return qty connot exceed Grn Qty\nIn line no : "+[loop]+"\nReturn Qty is "+issueQty+"\nGrn Qty is"+GrnQty+"\nVariance is : "+GrnQty-issueQty+".")
				}	
				
			//	alert(pub_commonBin);
				if(pub_commonBin==0){
					var checkBinAllocate = tblMain.rows[loop].cells[11].id;				 
						if (checkBinAllocate==0){
							alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +"." )
							document.getElementById('cmdSave').style.display ="inline";
							return false;				
						}			
				}
		}
	checkLoop = 0
	showBackGroundBalck();
	LoadJobNo();
}

function LoadJobNo()
{
	var No = document.getElementById("txtReturnNo").value
	if (No=="")
	{
		var url = 'returntosupplierxml.php?RequestType=LoadNo';
		var htmlobj=$.ajax({url:url,async:false});
		var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
		if(XMLAdmin=="TRUE"){
				var XMLNo =htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
				var XMLYear =htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
				pub_returnToSupNo =parseInt(XMLNo);
				pub_returnToSupYear = parseInt(XMLYear);
				document.getElementById("txtReturnNo").value=pub_returnToSupYear + "/" + pub_returnToSupNo;			
				Save();
				
			
			}
			else{
				alert("Please contact system administrator to Assign New Return No....");
				document.getElementById('cmdSave').style.display ="inline";
				hideBackGroundBalck();
			}
		/*createXMLHttpRequest(6);
		xmlHttp[6].onreadystatechange=LoadJobNoRequest;
		xmlHttp[6].open("GET",'returntosupplierxml.php?RequestType=LoadNo',true);
		xmlHttp[6].send(null);*/
	}
	else
	{		
		No = No.split("/");
		
		pub_returnToSupNo =parseInt(No[1]);
		pub_returnToSupYear = parseInt(No[0]);
		//Save();
	}
}

function LoadJobNoRequest()	
{
	if (xmlHttp[6].readyState==4){
		if (xmlHttp[6].status==200){
			
			var XMLAdmin	= xmlHttp[6].responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
			
			if(XMLAdmin=="TRUE"){
				var XMLNo =xmlHttp[6].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
				var XMLYear =xmlHttp[6].responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
				pub_returnToSupNo =parseInt(XMLNo);
				pub_returnToSupYear = parseInt(XMLYear);
				document.getElementById("txtReturnNo").value=pub_returnToSupYear + "/" + pub_returnToSupNo;			
				Save();
				
			
			}
			else{
				alert("Please contact system administrator to Assign New Return No....");
				document.getElementById('cmdSave').style.display ="inline";
				hideBackGroundBalck();
			}
		}
	}
	
}
	
function Save()
{
	validateCount 			= 0;
	validateBinCount		= 0;
	
	if(document.getElementById("txtReturnNo").value==""){alert ("No return no to save.");return}	

	var remarks 		= document.getElementById('txtRemarks').value;
	var supplierID 		= document.getElementById('cboSupplier').value;

	//createXMLHttpRequest(7);
	/*xmlHttp[7].open("GET",'returntosupplierxml.php?RequestType=SaveHeader&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&remarks=' +URLEncode(remarks)+  '&supplierID=' +supplierID ,true);
	xmlHttp[7].send(null);*/
	var url = 'returntosupplierxml.php?RequestType=SaveHeader&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&remarks=' +URLEncode(remarks)+  '&supplierID=' +supplierID;
	var htmlobj=$.ajax({url:url,async:false});
	
		for (loop = 0 ; loop < Materials.length ; loop ++)
		{	
			var details = Materials[loop] ;
			if 	(details!=null)
			{				
				var styleID 		= details[0];
			    var buyerPoNo 		= details[1];	
			    var itemDetailID 	= details[2];
			    var color			= details[3];
				var size			= details[4];
				var binArray 		= details[5];
				var units			= details[6];
				var grnNo 			= details[7];
				var Qty				= details[8];
				var PoNo			= details[9];
				var matSubCatId  	= details[10];
				var isTempStock  	= details[11];
				validateCount++;
					
		/*createXMLHttpRequest1(loop);
		xmlHttp1[loop].open("GET",'returntosupplierxml.php?RequestType=SaveDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&grnNo=' +grnNo+ '&Qty=' +Qty+ '&PoNo=' +PoNo ,true);
		xmlHttp1[loop].send(null);*/
		var url = 'returntosupplierxml.php?RequestType=SaveDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&grnNo=' +grnNo+ '&Qty=' +Qty+ '&PoNo=' +PoNo+ '&isTempStock=' +isTempStock;
		var htmlobj=$.ajax({url:url,async:false});		
		
				if(pub_commonBin==0){
					for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 		= binArray[i];
						var BinQty			= Bindetails[0]; 			// issueQty
						var MainStoresId	= Bindetails[1]; 			// MainStores
						var SubStoresId		= Bindetails[2];			// SubStores
						var LocationId		= Bindetails[3]; 			// Location
						var BinId			= Bindetails[4];			// BinId								
						if(isTempStock==0)
							validateBinCount++;
					
						/*createXMLHttpRequest2(i);
						xmlHttp2[i].open("GET",'returntosupplierxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&BinQty=' +BinQty+ '&mainStoresId=' +MainStoresId+ '&subStoreId=' +SubStoresId+ '&locationId=' +LocationId+ '&binId=' +BinId+ '&commonBin=' +pub_commonBin+ '&matSubCatId=' +matSubCatId+'&grnNo='+grnNo+ '&isTempStock=' +isTempStock ,true);
						xmlHttp2[i].send(null);*/
						var url = 'returntosupplierxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&BinQty=' +BinQty+ '&mainStoresId=' +MainStoresId+ '&subStoreId=' +SubStoresId+ '&locationId=' +LocationId+ '&binId=' +BinId+ '&commonBin=' +pub_commonBin+ '&matSubCatId=' +matSubCatId+'&grnNo='+grnNo+ '&isTempStock=' +isTempStock;
						var htmlobj=$.ajax({url:url,async:false});
					}
				}
				else
				{
					/*createXMLHttpRequest2(8);
					xmlHttp2[8].open("GET",'returntosupplierxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&BinQty=' +Qty+ '&mainStoresId=' +pub_mainStoreID+ '&subStoreId=' +pub_subStoreID+  '&commonBin=' +pub_commonBin+ '&matSubCatId=' +matSubCatId+'&grnNo='+grnNo+ '&isTempStock=' +isTempStock ,true);
					xmlHttp2[8].send(null);*/
					var url = 'returntosupplierxml.php?RequestType=SaveBinDetails&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&BinQty=' +Qty+ '&mainStoresId=' +pub_mainStoreID+ '&subStoreId=' +pub_subStoreID+  '&commonBin=' +pub_commonBin+ '&matSubCatId=' +matSubCatId+'&grnNo='+grnNo+ '&isTempStock=' +isTempStock;
					var htmlobj=$.ajax({url:url,async:false});
					if(isTempStock==0)
						validateBinCount++;
				}
			}
		}
	SaveValidate();
}

function SaveValidate()
{	
	/*createXMLHttpRequest(8);
	xmlHttp[8].onreadystatechange = SaveValidateRequest;
	xmlHttp[8].open("GET",'returntosupplierxml.php?RequestType=SaveValidate&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount ,true);
	xmlHttp[8].send(null);*/	
	//
	var url = 'returntosupplierxml.php?RequestType=SaveValidate&returnNo=' +pub_returnToSupNo+ '&returnYear=' +pub_returnToSupYear+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLCountHeader		= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var XMLCountDetails		= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;				
	var XMLCountBinDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
	
	if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE") &&(XMLCountBinDetails=="TRUE"))
	{
		ChangeGrnSaveStatus();
	}
	else
	{
		alert("Sorry!\nError occured while saving the data. Please save it again.");
	}
	//
}

function ChangeGrnSaveStatus(){
	var No = document.getElementById("txtReturnNo").value;
	/*createXMLHttpRequest(13);
	xmlHttp[13].onreadystatechange=ChangeGrnSaveStatusRequest;
	xmlHttp[13].open("GET",'returntosupplierxml.php?RequestType=ChangeGrnSaveStatus&No=' +No ,true);
	xmlHttp[13].send(null);*/
	
	//
	var url = 'returntosupplierxml.php?RequestType=ChangeGrnSaveStatus&No=' +No;
	var htmlobj=$.ajax({url:url,async:false});
	
	var intConfirm = htmlobj.responseText;
	if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
	{	
	alert ("Return Supplier No : " + document.getElementById("txtReturnNo").value +  " confirmed successfully.");							
			document.getElementById("cmdSave").style.visibility="hidden";
			document.getElementById("cmdCancel").style.visibility="visible";
			document.getElementById("cmdAddNew").style.visibility="hidden";
			hideBackGroundBalck();
	}
	else{
			alert("Sorry!\nError occured while saving the data. Please save it again.");
			hideBackGroundBalck();
	}
	//
}
/*	function ChangeGrnSaveStatusRequest()
	{
		if (xmlHttp[13].readyState==4)
		{
		 	if (xmlHttp[13].status==200)
			{
				var intConfirm = xmlHttp[13].responseText;		
				
				if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
				{	
				alert ("Return Supplier No : " + document.getElementById("txtReturnNo").value +  " confirmed successfully.");							
						document.getElementById("cmdSave").style.visibility="hidden";
						document.getElementById("cmdCancel").style.visibility="visible";
						document.getElementById("cmdAddNew").style.visibility="hidden";
						hideBackGroundBalck();
				}
				else{
						alert("Sorry!\nError occured while saving the data. Please save it again.");
						hideBackGroundBalck();
				}
					
			}
		}
	}*/
	
/*function SaveValidateRequest()
{
	if(xmlHttp[8].readyState == 4) 
	{
		if(xmlHttp[8].status == 200)
		{				
			var XMLCountHeader= xmlHttp[8].responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
			var XMLCountDetails= xmlHttp[8].responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;				
			var XMLCountBinDetails= xmlHttp[8].responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
			
				if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE") &&(XMLCountBinDetails=="TRUE"))
				{
					ChangeGrnSaveStatus();						
				}
				else 
				{
					checkLoop++;
					if(checkLoop>10){
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
	}
}
*///Start-PopUp search 
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

//Start - Saved Details PopUp window
function LoadPopUpNo()
{	
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state	= document.getElementById('cboState').value;
	var year	= document.getElementById('cboYear').value;
 	
	var url = 'returntosupplierxml.php?RequestType=LoadPopUpReturnYear&state='+state+'&year='+year;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboYear').innerHTML = htmlobj.responseText;
	
	var url = 'returntosupplierxml.php?RequestType=LoadPopUpReturnNo&state='+state+'&year='+year;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboNo').innerHTML = htmlobj.responseText;
}

/*function LoadPopUpJobNoRequest(){
	if(xmlHttp[9].readyState == 4){
        if(xmlHttp[9].status == 200){  
		
				var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboNo").options.add(opt);
	
			 var XMLReturnNo= xmlHttp[9].responseXML.getElementsByTagName("ReturnNo");
			 for ( var loop = 0; loop < XMLReturnNo.length; loop ++){
			
				var opt = document.createElement("option");
				opt.text = XMLReturnNo[loop].childNodes[0].nodeValue;
				opt.value = XMLReturnNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboNo").options.add(opt);
			 }			 
		}
	}
}*/

function loadPopUpReturnToStores(){
	
	document.getElementById('NoSearch').style.visibility = "hidden";	
	var No=document.getElementById('cboNo').value;
	var Year=document.getElementById('cboYear').value;
	if (No=="")return false;	
	
	LoadHeaderDetailsRequest(No,Year);	
	LoadDetailsRequest(No,Year);
}
function LoadHeaderDetailsRequest(No,Year)
{
	var url = 'returntosupplierxml.php?RequestType=LoadPopUpHeaderDetails&No=' +No+ '&Year=' +Year;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLReturnNo 	= htmlobj.responseXML.getElementsByTagName("ReturnNo")[0].childNodes[0].nodeValue;				
	var XMLStatus 		= parseInt(htmlobj.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);
	var XMLRemarks 		= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
	var XMLSupplierID 	= htmlobj.responseXML.getElementsByTagName("SupplierID")[0].childNodes[0].nodeValue;
	
	document.getElementById("txtReturnNo").value =XMLReturnNo;
	document.getElementById("cboSupplier").value =XMLSupplierID ;
	document.getElementById("txtRemarks").value =XMLRemarks ;		
	restrictInterface(XMLStatus);
	
}
function loadStyleName()
{
	var scNo = document.getElementById("cboSCNO").value;
	var url = 'returntosupplierxml.php?RequestType=LoadStyleNames&scNo=' +scNo;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLstrStyle 	= htmlobj.responseXML.getElementsByTagName("strStyle")[0].childNodes[0].nodeValue;				
	
	document.getElementById("cboStyles").value =XMLstrStyle;
	
	
}
	
function LoadDetailsRequest(No,Year)
{
	var url = 'returntosupplierxml.php?RequestType=LoadPopUpDetails&No=' +No+ '&Year=' +Year;
	var htmlobj=$.ajax({url:url,async:false});
	
	RemoveAllRows('tblMain');
	var tbl 				= document.getElementById("tblMain");
	var XMLGrnNo 			= htmlobj.responseXML.getElementsByTagName("GrnNo");
	var XMLGrnYear 			= htmlobj.responseXML.getElementsByTagName("GrnYear");				
	var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription");
	var XMLStyleID 			= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLBuyerPONO 		= htmlobj.responseXML.getElementsByTagName("BuyerPONO");
	var XMLStyleName		= htmlobj.responseXML.getElementsByTagName("StyleName");
	var XMLBuyerPOName 		= htmlobj.responseXML.getElementsByTagName("BuyerPOName");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color");				
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLGrnQty 			= htmlobj.responseXML.getElementsByTagName("GrnQty");
	var XMLStockBal 		= htmlobj.responseXML.getElementsByTagName("StockBal");
	var XMLNotTrimInspect	= htmlobj.responseXML.getElementsByTagName("NotTrimInspect");
			
	for (loop=0;loop<XMLStyleID.length;loop++)
	{		
		var strInnerHtml="";
		strInnerHtml+="<td class=\"normalfnt\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"" + mainArrayIndex + "\" /></td>";
		strInnerHtml+="<td class=\"normalfntSM\">"+XMLGrnYear[loop].childNodes[0].nodeValue+"/"+XMLGrnNo[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLStyleID[loop].childNodes[0].nodeValue+"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue+"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRiteSML\">"+XMLStockBal[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRiteSML\">"+XMLGrnQty[loop].childNodes[0].nodeValue+"</td>";
		strInnerHtml+="<td class=\"normalfntRiteSML\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" readonly=\"readonly\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLQty[loop].childNodes[0].nodeValue+"\"/></td>";
		strInnerHtml+="<td class=\"normalfntRiteSML\"><div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\"  height=\"20\"/></div></td>";
		
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);						
		tbl.rows[lastRow].innerHTML=  strInnerHtml;
		tbl.rows[lastRow].id = lastRow;
		if(XMLNotTrimInspect[loop].childNodes[0].nodeValue=='0')
			tbl.rows[lastRow].className = "bcgcolor-tblrowWhite";
		else
			tbl.rows[lastRow].className = "bcgcolor-InvoiceCostTrim";
	}
}
//End - Saved Details PopUp window

function ViewReport()
{
	var No =document.getElementById("txtReturnNo").value;
	if(No=="")
	{
		alert("Sorry!\nNo 'Return No' to print.Please select 'Return No'.");
		return;
	}
	
	No = No.split("/");
	
	ReturnNo =parseInt(No[1]);
	ReturnYear =parseInt(No[0]);
	
	newwindow=window.open('returntosupplierreport.php?ReturnNo='+ReturnNo+ '&ReturnYear=' +ReturnYear ,'name');
	if (window.focus) {newwindow.focus()}
}

function CancelValidation(){
	var No = document.getElementById("txtReturnNo").value;
	document.getElementById("cmdCancel").style.display="none";
	if(No=="")
	{
		alert("Sorry!\nNo 'Return No' to cancel.Please select 'Return No'.");
		return;
	}
	createXMLHttpRequest(13);
	xmlHttp[13].onreadystatechange=CancelValidationRequest;
	xmlHttp[13].open("GET",'returntosupplierxml.php?RequestType=CancelValidation&No=' +No ,true);
	xmlHttp[13].send(null);
}

function CancelValidationRequest(){
	if (xmlHttp[13].readyState==4){
		if (xmlHttp[13].status==200){
			
			var validateStatus=0;
			var XMLCancelValidation = xmlHttp[13].responseXML.getElementsByTagName('Cancel');
			var XMLPoNo 			= xmlHttp[13].responseXML.getElementsByTagName('PoNo');
			var XMLStyleID 			= xmlHttp[13].responseXML.getElementsByTagName('StyleID');
			var XMLBuyerPoNo 		= xmlHttp[13].responseXML.getElementsByTagName('BuyerPoNo');
			var XMLColor 			= xmlHttp[13].responseXML.getElementsByTagName('Color');
			var XMLSize 			= xmlHttp[13].responseXML.getElementsByTagName('Size');
			var XMLItemDescription 	= xmlHttp[13].responseXML.getElementsByTagName('ItemDescription');
			var XMLReturnQty 		= xmlHttp[13].responseXML.getElementsByTagName('ReturnQty');
			var XMLPendingQty 		= xmlHttp[13].responseXML.getElementsByTagName('PendingQty');
			
			for(loop=0;loop<XMLCancelValidation.length;loop++)				
			{					
				if(XMLCancelValidation[loop].childNodes[0].nodeValue="FALSE"){
					alert("You cannot Cancel this supplier return note, Because Grn already done for this PO: "+XMLPoNo[loop].childNodes[0].nodeValue+"\nStyle ID is : "+XMLStyleID[loop].childNodes[0].nodeValue+"\nItem is :"+XMLItemDescription[loop].childNodes[0].nodeValue+"\nBuyerPoNO is : "+XMLBuyerPoNo[loop].childNodes[0].nodeValue+"\nColor is : "+XMLColor[loop].childNodes[0].nodeValue+"\nSize is : "+XMLSize[loop].childNodes[0].nodeValue+"\nReturn Qty is : "+XMLReturnQty[loop].childNodes[0].nodeValue+"\nGrn Balance is : "+XMLPendingQty[loop].childNodes[0].nodeValue);
					validateStatus=1;
				}									
			}
		}
	}
	if(validateStatus==0)
		Cancel();
}
	
function Cancel()
{	
	showBackGroundBalck();
	var No = document.getElementById("txtReturnNo").value;
	
	var url = 'returntosupplierxml.php?RequestType=Cancel&No=' +No;
	var htmlobj = $.ajax({url:url,async:false});
	
	var intConfirm = htmlobj.responseText;	
	if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
	{	
		alert ("Return No : " + document.getElementById("txtReturnNo").value + "     canceled successfully.");
		document.getElementById("cmdSave").style.visibility="hidden";						
		document.getElementById("cmdCancel").style.visibility="hidden";
		document.getElementById("cmdAddNew").style.visibility="hidden";
		hideBackGroundBalck();
	}
	else
	{
		alert("Sorry!\nError occured while cancel the data. Please cancel it again.");
		hideBackGroundBalck();
	}
}
	
function closeFindReturn()
{
	document.getElementById("NoSearch").style.visibility="hidden";
}

function restrictInterface(XMLStatus)
{
	switch (XMLStatus){						
		case 1:	
			document.getElementById("cmdSave").style.display="none";							
			document.getElementById("cmdCancel").style.display="inline";	
			document.getElementById("cmdAddNew").style.visibility="hidden";
			break;				
		case 10:						
			document.getElementById("cmdSave").style.display="none";						
			document.getElementById("cmdCancel").style.display="none";	
			document.getElementById("cmdAddNew").style.visibility="hidden";
			break;							
	}
}