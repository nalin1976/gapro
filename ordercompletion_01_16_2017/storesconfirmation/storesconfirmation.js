//JS 
var Materials 			= [];
var pub_commonBin		= 0;
var pub_index			= 0;
var pub_index			= 0;
var mainArrayIndex 		= 0;
var pub_mainRw			= 0;
//BEGIN - Main Item Grid Column Variable
var m_order = 0;
var m_bpo =1;
var m_iDesc = 2;
var m_color=3;
var m_size=4;
var m_unit = 5;
var m_Qty = 6;
var m_dQty =7;
var m_dispose =8;
var m_bQty =9;
var m_binLoc =10;
var m_bin=11;
var m_main=12;
var m_sub=13;
var m_loc=14;
var m_grn=15;
var m_grnT=16;
//END - Main Item Grid Column Variable
function LoadSubStores(){
	var mainStores	= document.getElementById('cboMainStores').value;	
	
	RomoveData("cboSubStores")
	var url="storesconfirmationdb.php?RequestType=LoadSubStores&mainStores=" +mainStores;			
	var htmlobj=$.ajax({url:url,async:false});
	
	pub_commonBin = htmlobj.responseXML.getElementsByTagName("CommonBinId")[0].childNodes[0].nodeValue;
			document.getElementById('cboMainStores').title = pub_commonBin;
					var opt = document.createElement("option");
					opt.text ="Select One";
					opt.value = "";
					document.getElementById("cboSubStores").options.add(opt);
					
			var XMLSubID =htmlobj.responseXML.getElementsByTagName("SubID");
			var XMLSubStoresName =htmlobj.responseXML.getElementsByTagName("SubStoresName");
			
				for ( var loop = 0; loop < XMLSubID.length; loop ++)
				{							
					var opt = document.createElement("option");
					opt.text = XMLSubStoresName[loop].childNodes[0].nodeValue;	
					opt.value = XMLSubID[loop].childNodes[0].nodeValue;	
					document.getElementById("cboSubStores").options.add(opt);			
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
function ValidatePopUpItems(obj,subCat,index)
{
	var mainStoreID = document.getElementById('cboMainStores').value.trim();
	var subStoreID  = document.getElementById('cboSubStores').value.trim();
	pub_index		= index;
	var balQty 		= obj.parentNode.parentNode.cells[9].innerHTML;
	pub_mainRw 		= obj.parentNode.parentNode.rowIndex;
	if(mainStoreID==""){
		alert("Please select the \"Main Stores\".");
		document.getElementById('cboMainStores').focus();
		return;
	}
	if(subStoreID==""){
		alert("Please select the \"Sub Stores\".");
		document.getElementById('cboSubStores').focus();
		return;
	}	
	if(balQty =='')
	{
		alert("Please enter 'Balance Qty'");
		return;
	}
	if(pub_commonBin==1){alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");return;}
	OpenPopUp(obj,subCat,index);
}
function OpenPopUp(obj,subCat,index)
{	
	var tblGrid= document.getElementById('tblMain')
	
	var mainStoreID = 	document.getElementById('cboMainStores').value.trim();// obj.parentNode.parentNode.cells[12].id;
	var subStoreID	= 	document.getElementById('cboSubStores').value.trim();//obj.parentNode.parentNode.cells[13].id;	
	var issueQty	=	obj.parentNode.parentNode.cells[9].innerHTML;
	var styleId		=	obj.parentNode.parentNode.cells[0].id;	
	
	var url='binitems.php?mainStoreID=' +mainStoreID+ '&subStoreID=' +subStoreID + '&subCatID=' +subCat + '&issueQty=' +issueQty+ '&index=' +index+'&styleId='+styleId;		
	var htmlobj=$.ajax({url:url,async:false});
	
	drawPopupArea(570,300,'frmMaterialTransfer');				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;		
}

function setBalance(obj)
{
	var td=obj.parentNode;
	var cell6=td.parentNode.cells[6].innerHTML;
	var cell8=td.parentNode.cells[8].childNodes[0].value;
	if(td.parentNode.cells[8].childNodes[0].value=="")
	{
		td.parentNode.cells[9].innerHTML="";
	}
	if(parseInt(cell6)+1 > parseInt(cell8))
	{
		td.parentNode.cells[9].innerHTML="";
		td.parentNode.cells[9].innerHTML=cell6-cell8;
	}
	else
	{
		var myStr = cell8;
		var strLen = myStr.length;
		td.parentNode.cells[8].childNodes[0].value=myStr = myStr.slice(0,strLen-1);
		//alert("Issued qty not exceed to Recieve qty.");
	}	
}
function setQty(obj){
	if(obj.checked==true){
		var qty=obj.parentNode.parentNode.parentNode.cells[6].innerHTML;//childNodes[0].value;
		if(obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value==""){
			obj.parentNode.parentNode.parentNode.cells[9].innerHTML=parseFloat(qty);
		}
		else{
			obj.parentNode.parentNode.parentNode.cells[9].innerHTML=(parseFloat(qty) - parseFloat(obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value));
		}
	}
	else{
		obj.parentNode.parentNode.parentNode.cells[9].innerHTML="";
		obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value="";
	}
}
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

function SetBinItemQuantity(style,index)
{	
	var tblMain 	=	document.getElementById("tblMain");				
	var tblBin		= 	document.getElementById('tblBinItem');
	var totReqQty 	= 	parseFloat(document.getElementById('txtReqQty').value);		
	var buyerPo		=	tblMain.rows[index].cells[1].innerHTML;
	var matDetId	= 	tblMain.rows[index].cells[2].id;
	var color		=	tblMain.rows[index].cells[3].innerHTML;
	var size		=	tblMain.rows[index].cells[4].innerHTML;
	var Unit		=  	tblMain.rows[index].cells[5].innerHTML;
	var grn			=	tblMain.rows[index].cells[15].innerHTML;
	var GPLoopQty 	= 	0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++){
			if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[0].checked){		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty ){	
	var htmlobj=""
	for (loop =1; loop < tblBin.rows.length; loop++){
			if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[0].checked){		
				var url='storesconfirmationdb.php?RequestType=saveBinItems&styleNo='+ style +'&location='+ tblBin.rows[loop].cells[4].id +'&binId='+tblBin.rows[loop].cells[3].id+'&mainStoreID='+ tblBin.rows[loop].cells[5].id +'&subStoreID=' + tblBin.rows[loop].cells[6].id +'&buyerPo='+ URLEncode(buyerPo) +'&matDetId='+ matDetId +'&color='+URLEncode(color)+'&size='+URLEncode(size)+'&unit='+URLEncode(Unit)+'&type=LeftOver&Qty='+ tblBin.rows[loop].cells[1].childNodes[0].value+'&grnNo='+URLEncode(grn)+'&tag='+ (loop-1);	
				//alert(url);
				htmlobj=$.ajax({url:url,async:false});
			}	
		}
		
		
		var XMLRes=htmlobj.responseXML.getElementsByTagName("det");
		var res=XMLRes[0].childNodes[0].nodeValue;
			res=res.split('~');
		if(res[0]== 0 ){
			tblMain.rows[index].className = "normalfnt2BITAB";
			tblMain.rows[index].cells[1].id =2;
			tblMain.rows[index].cells[1].title =res[1];			
		}
		closeWindow();		
	}
	else{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
}

function saveDisposedAndLeft(){ 

	var mainStore	=	document.getElementById('cboMainStores');
	var subStore	= 	document.getElementById('cboSubStores');
	if(mainStore.value.trim()==""){
		alert("Please select the \"Main Stores\".");
		document.getElementById('cboMainStores').focus();
		return;
	}
	if(subStore.value.trim()==""){
		alert("Please select the \"Sub Stores\".");
		document.getElementById('cboSubStores').focus();
		return;
	}
	var tblMain 	=	document.getElementById("tblMain");	
	var rowCount	= 	tblMain.rows.length;
	var styleId	="";
	var buyerPo="";
	var matDetId="";
	var color="";
	var size="";
	var Unit="";
	var dispose="";
	var bin="";
	var location="";
	var grn="";
	var cat="";
	var type="";
	var leftOver="";
	var cnt=rowCount-1;
	var tg;
		if(mainStore.title==1)
		{			
			for(var i=1;i<rowCount;i++)
			{
				
				styleId		=	tblMain.rows[i].cells[0].id;
				buyerPo		=	tblMain.rows[i].cells[1].innerHTML;;
				matDetId	= 	tblMain.rows[i].cells[2].id;
				color		=	tblMain.rows[i].cells[3].innerHTML;
				size		=	tblMain.rows[i].cells[4].innerHTML;
				Unit		=  	tblMain.rows[i].cells[5].innerHTML;
				grn			=	tblMain.rows[i].cells[15].innerHTML;
				tg=i;
				var docNo=0;
				
				if(tblMain.rows[i].cells[7].childNodes[0].childNodes[0].checked==true && tblMain.rows[i].cells[8].childNodes[0].value != 0 && tblMain.rows[i].cells[8].childNodes[0].value != "")
				{
					cat='saveToCommon';
					dispose		=	tblMain.rows[i].cells[8].childNodes[0].value;
					type		= 'Dispose';
					saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,dispose,grn,(i-1),cat,docNo,type,cnt,tg);
					leftOver	=	tblMain.rows[i].cells[9].innerHTML;
					type		= 'LeftOver';
					saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,leftOver,grn,i,cat,docNo,type,cnt,tg);				
				}
				else if(tblMain.rows[i].cells[8].childNodes[0].childNodes[0].value==0 || tblMain.rows[i].cells[9].innerHTML=="")
				{
					cat='saveToCommon';
					type		= 'LeftOver';
					leftOver	=	tblMain.rows[i].cells[6].innerHTML;
					saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,leftOver,grn,i,cat,docNo,type,cnt,tg);
				}
			}
		}
		else
		{			
			for(var i=1;i<rowCount;i++)
			{
				styleId		=	tblMain.rows[i].cells[0].id;
				buyerPo		=	tblMain.rows[i].cells[1].innerHTML;
				matDetId	= 	tblMain.rows[i].cells[2].id;
				color		=	tblMain.rows[i].cells[3].innerHTML;
				size		=	tblMain.rows[i].cells[4].innerHTML;
				Unit		=  	tblMain.rows[i].cells[5].innerHTML;
				grn			=	tblMain.rows[i].cells[15].innerHTML;
				var docNo=0;
				tg=i;
				
				if(tblMain.rows[i].cells[1].id==2)
				{
					cat='saveToOther';
					var docNo=tblMain.rows[i].cells[1].title;
					dispose		=	tblMain.rows[i].cells[8].childNodes[0].value;
					type		= 'Dispose';
					saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,dispose,grn,(i-1),cat,docNo,type,cnt,tg);
				}
				else
				{
					cat='saveToOther';
					//alert(tblMain.rows[i].cells[8].childNodes[0].value);
					if(tblMain.rows[i].cells[8].childNodes[0].value != 0)
					{
						dispose		=	tblMain.rows[i].cells[8].childNodes[0].value;
						type		= 'Dispose';
						//alert(type);
						saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,dispose,grn,(i-1),cat,docNo,type,cnt,tg);
						
						leftOver	=	tblMain.rows[i].cells[9].innerHTML;
						type		= 'LeftOver';
						//alert(type);
						saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,leftOver,grn,i,cat,docNo,type,cnt,tg);						
					}
					else
					{
						leftOver	=	tblMain.rows[i].cells[6].innerHTML;
						type		= 'LeftOver';
						saveDetails(mainStore.value.trim(),subStore.value.trim(),styleId,buyerPo,matDetId,color,size,Unit,leftOver,grn,i,cat,docNo,type,cnt,tg);
					}
							
				}
			}
		}
		sendEmail(styleId);
}

function saveDetails(mainStore,subStore,styleId,buyerPo,matDetId,color,size,Unit,disposeORleftOver,grn,i,cat,docNo,type,cnt,tg){
	var htmlobj="";
	var url='storesconfirmationdb.php?RequestType='+cat+'&styleNo='+ styleId +'&mainStoreID='+ mainStore +'&subStoreID=' + subStore +'&buyerPo='+ URLEncode(buyerPo) +'&matDetId='+ matDetId +'&color='+color+'&size='+size+'&unit='+Unit+'&type='+type+'&Qty='+ disposeORleftOver +'&grnNo='+grn+'&tag='+ i+'&docNo='+docNo+'&tg='+tg;
	htmlobj=$.ajax({url:url,async:false});
	/*var chk=htmlobj.responseXML.getElementsByTagName("det")[0].childNodes[0].nodeValue.split('~');
	alert(cnt+"="+chk[0]);
	if(cnt == chk[0]){
		alert('sss');
	}*/
}

function sendEmail(styleId){
	var url='storesconfirmationdb.php?RequestType=sendEmails&styleId='+ styleId 
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseXML.getElementsByTagName("Res")[0].childNodes[0].nodeValue==1){
		alert('Successfully confirmed.');
		window.location.reload();
		
	}
}


function confirmDisposeItems(disposeNo,disposeYear)
{
	if(disposeNo != '' && disposeYear!='')
	{
		var url='storeconfirmdb.php?RequestType=ConfiremDisposeItems&disposeNo='+ disposeNo+'&disposeYear='+disposeYear 
		htmlobj=$.ajax({url:url,async:false});
	
		if(htmlobj.responseXML.getElementsByTagName("Res")[0].childNodes[0].nodeValue==1){
			//window.close();
			document.getElementById('tblConfirm').style.display = 'none'
		}	
	}
	
}
/*function confirmDisposeItems(styleId){
	//alert(styleId);
	var url='storesconfirmationdb.php?RequestType=ConfiremDisposeItems&styleId='+ styleId 
	//alert(url);
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseXML.getElementsByTagName("Res")[0].childNodes[0].nodeValue==1){
	//document.getElementById('conform.png').innerHTML="";
		window.close();
	}
}
*///-------------------Start 2011-05-07 load pending order complete details--------------
/*
laod details from stocktransaction where order status is equal to 13 which already confirmed by merchandiser
*/
function loadOrderDetails(a)
{
	var styleId	=	document.getElementById('cboOrderNo').value;
	var url = 'storeconfirmdb.php?RequestType=loadPendingCompleteData&styleId='+ styleId;
	htmlobj=$.ajax({url:url,async:false});
	ClearTable('tblMain');
	Materials = [];
	mainArrayIndex 	= 0;
	
	var xmlMatId = htmlobj.responseXML.getElementsByTagName("intItemSerial");
	for(var loop=0;loop<xmlMatId.length;loop++)
	{
		var orderNo = htmlobj.responseXML.getElementsByTagName("strOrderNo")[loop].childNodes[0].nodeValue;
		var matDetailId = xmlMatId[loop].childNodes[0].nodeValue;
		var orderNo = htmlobj.responseXML.getElementsByTagName("strOrderNo")[loop].childNodes[0].nodeValue;
		var BuyerPoNo = htmlobj.responseXML.getElementsByTagName("BuyerPoNo")[loop].childNodes[0].nodeValue;
		var itemDesc = htmlobj.responseXML.getElementsByTagName("strItemDescription")[loop].childNodes[0].nodeValue;
		var strColor = htmlobj.responseXML.getElementsByTagName("strColor")[loop].childNodes[0].nodeValue;
		var strSize = htmlobj.responseXML.getElementsByTagName("strSize")[loop].childNodes[0].nodeValue;
		var strUnit = htmlobj.responseXML.getElementsByTagName("strUnit")[loop].childNodes[0].nodeValue;
		var QTY = htmlobj.responseXML.getElementsByTagName("QTY")[loop].childNodes[0].nodeValue;
		var BinName = htmlobj.responseXML.getElementsByTagName("strBinName")[loop].childNodes[0].nodeValue;
		var binId = htmlobj.responseXML.getElementsByTagName("strBin")[loop].childNodes[0].nodeValue;
		var location = htmlobj.responseXML.getElementsByTagName("strLocName")[loop].childNodes[0].nodeValue;
		var locationId = htmlobj.responseXML.getElementsByTagName("strLocation")[loop].childNodes[0].nodeValue;
		var SubStoresName = htmlobj.responseXML.getElementsByTagName("strSubStoresName")[loop].childNodes[0].nodeValue;
		var strSubStores = htmlobj.responseXML.getElementsByTagName("strSubStores")[loop].childNodes[0].nodeValue;
		var MainStoresID = htmlobj.responseXML.getElementsByTagName("strMainStoresID")[loop].childNodes[0].nodeValue;
		var MainStore = htmlobj.responseXML.getElementsByTagName("strName")[loop].childNodes[0].nodeValue;
		var grnNo = htmlobj.responseXML.getElementsByTagName("GRN")[loop].childNodes[0].nodeValue;
		var subCatId = htmlobj.responseXML.getElementsByTagName("intSubCatID")[loop].childNodes[0].nodeValue;
		var grnType = htmlobj.responseXML.getElementsByTagName("grnType")[loop].childNodes[0].nodeValue;
		var strGRNType = htmlobj.responseXML.getElementsByTagName("strGRNType")[loop].childNodes[0].nodeValue;
		
		createMainGrid(styleId,orderNo,BuyerPoNo,matDetailId,itemDesc,strColor,strSize,strUnit,QTY,MainStoresID,MainStore,strSubStores,SubStoresName,locationId,location,binId,BinName,grnNo,subCatId,grnType,strGRNType)
	}
	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function createMainGrid(styleId,orderNo,BuyerPoNo,matDetailId,itemDesc,strColor,strSize,strUnit,QTY,MainStoresID,MainStore,strSubStores,SubStoresName,locationId,location,binId,BinName,grnNo,subCatId,grnType,strGRNType)
{
	var tbl 	= document.getElementById('tblMain');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(m_order);
	cell.className 	= "normalfnt";
	cell.setAttribute('height','20');
	cell.id			= styleId;
	cell.innerHTML 	= orderNo;
	
	var cell 		= row.insertCell(m_bpo);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= BuyerPoNo;
	
	var cell 		= row.insertCell(m_iDesc);
	cell.className 	= "normalfnt";
	cell.id			= matDetailId
	cell.innerHTML 	= itemDesc;
	
	var cell 		= row.insertCell(m_color);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= strColor;
	
	var cell 		= row.insertCell(m_size);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= strSize;
	
	var cell 		= row.insertCell(m_unit);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= strUnit;
	
	var cell 		= row.insertCell(m_Qty);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= QTY;
	
	var cell 		= row.insertCell(m_dQty);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<div align=\"center\"><input onClick=\"setCheckQty(this,"+mainArrayIndex+");\" type=\"checkbox\" name=\"chkDispose\" id=\"chkDispose\" ></div>";
	
	var cell 		= row.insertCell(m_dispose);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= "<input type=\"text\" name=\"txtdisposeQty\" id=\"txtdisposeQty\" class=\"txtboxRightAllign\" size=\"10\" value=\"0\" onKeyUp=\"setGridBalance(this,"+mainArrayIndex+");\" onKeyPress=\"return CheckforValidDecimal(this.value,4,event);\" style=\"text-align:right;\"  />";
	
	var cell 		= row.insertCell(m_bQty);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= '';
	
	var cell 		= row.insertCell(m_binLoc);
	cell.className 	= "normalfnt";
	cell.id 		=0;
	cell.innerHTML 	= "<img height=\"20\" src=\"../../images/location.png\" onclick=\"ValidatePopUpItems(this,"+subCatId+","+mainArrayIndex+");\" />";
	
	var cell 		= row.insertCell(m_bin);
	cell.className 	= "normalfnt";
	cell.id			= binId;
	cell.innerHTML 	= BinName;
	
	var cell 		= row.insertCell(m_main);
	cell.className 	= "normalfnt";
	cell.id			= MainStoresID;
	cell.innerHTML 	= MainStore;
	
	var cell 		= row.insertCell(m_sub);
	cell.className 	= "normalfnt";
	cell.id			= strSubStores;
	cell.innerHTML 	= SubStoresName;
	
	var cell 		= row.insertCell(m_loc);
	cell.className 	= "normalfnt";
	cell.id			= locationId;
	cell.innerHTML 	= location;
	
	var cell 		= row.insertCell(m_grn);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= grnNo;
	
	var cell 		= row.insertCell(m_grnT);
	cell.className 	= "normalfnt";
	cell.id			=grnType;
	cell.innerHTML 	= strGRNType;
	
	var details = [];
	details[0] = matDetailId; 	// Matdetail Id
	details[1] = styleId; 	// Oreder Id
	details[2] = strColor ;	// Color
	details[3] = strSize; 		// Size
	details[4] = strUnit; 	// Unit
	details[6] = QTY; 		// leftover Qty
	details[7] = 0; 		//dispose Qty
	details[8] = '#Main Ratio#'; 		//Buyer PoNo
	details[9] = subCatId; 		//subcategory id
	details[10] = grnNo   // GRN no 
	details[11] = grnType
	
	//assign bin details to details array to save disposal data
	details[12] =  MainStoresID;
	details[13] =  strSubStores;
	details[14] =  locationId;
	details[15] =  binId;
	// assign current bin detals to bin array-save leftover details
	var BinMaterials = [];
	var mainBinArrayIndex = 0;
	var Bindetails = [];
	Bindetails[0] =   parseFloat(QTY); //qty
	Bindetails[1] =   MainStoresID; // MainStores
	Bindetails[2] =   strSubStores;// SubStores
	Bindetails[3] =   locationId; // Location
	Bindetails[4] =  binId; // BinId							
	BinMaterials[mainBinArrayIndex] = Bindetails;
	details[5] = BinMaterials;	
	
	Materials[mainArrayIndex] = details;
	mainArrayIndex ++ ;
}
function SetBinItemQty(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =1; loop < tblBin.rows.length; loop++)
	{
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
		tblMain.rows[pub_mainRw].className = "bcgcolor-tblrowLiteBlue";
		//tblMain.rows[pub_mainRw].cells[0].id = 1;
		closeWindow();
	}
	else{
		/*alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));*/
		return false;
	}	
}
//save leftover and dispose data
function saveDisposedAndLeftOverData()
{
	SaveHeader();
	
}
function SaveHeader()
{
	showBackGroundBalck();
	var url = "storeconfirmdb.php?RequestType=getDocumentNo";	
	htmlobj=$.ajax({url:url,async:false});
	var docNo = htmlobj.responseXML.getElementsByTagName("docNo")[0].childNodes[0].nodeValue;
	
	saveDetails(docNo);
}

function saveDetails(docNo)
{
	//check dispose Qty available and insert record to itemdispose table
	if(chekDisposeItemAvailability())
	{
		var urlItemDis = "storeconfirmdb.php?RequestType=saveItemDisposeHeader&docNo="+docNo;	
		htmlobj=$.ajax({url:urlItemDis,async:false});
	}
	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{
			var matId 		= details[0]; 	// Matdetail Id
			var styleID		= details[1]; 	// Oreder Id
			var color		= details[2];	// Color
			var size		= details[3]; 	// Size
			var units		= details[4];	// Unit
			var binArray 	= details[5];	
			var qty			= details[6]; 	// Adjust Qty
			var disposeQty	= details[7]; 	//Unitprice
			var buyerPoNo	= details[8];	// BuyerPoNo
			var subCatId	= details[9];	//SubCatId
			var grnNo		= details[10]; //GRN no
			var grnType		= details[11]; //GRN no
			
			var MainStoresID = details[12] ;
			var strSubStores = details[13] ;
			var locationId = details[14] ;
			var binId  = details[15] ;
			//save disposal data
			if(disposeQty != 0)
			{
				var urlDis = 'storeconfirmdb.php?RequestType=saveDisposeData&matId='+matId+'&styleID='+styleID;
			urlDis += '&color='+URLEncode(color)+'&size='+URLEncode(size)+'&units='+URLEncode(units)+'&qty='+qty+'&disposeQty='+disposeQty+'&buyerPoNo='+URLEncode(buyerPoNo)+'&subCatId='+subCatId+'&grnNo='+URLEncode(grnNo)+'&docNo='+docNo+'&grnType='+URLEncode(grnType)+'&MainStoresID='+MainStoresID+'&strSubStores='+strSubStores+'&locationId='+locationId+'&binId='+binId;
			
				var htmlobj_dis =$.ajax({url:urlDis,async:false});
			}
			
			for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 		= binArray[i];
						var binQty 			= Bindetails[0];  // issueQty
						var mainStoreId		= Bindetails[1];  // MainStores
						var subStoreId		= Bindetails[2];  // SubStores
						var locationId		= Bindetails[3];  // Location
						var binId			= Bindetails[4];  // BinId							
					//save leftover data	
					var url = 'storeconfirmdb.php?RequestType=saveLeftoverData&matId='+matId+'&styleID='+styleID;
			url += '&color='+URLEncode(color)+'&size='+URLEncode(size)+'&units='+URLEncode(units)+'&qty='+qty+'&disposeQty='+disposeQty+'&buyerPoNo='+URLEncode(buyerPoNo)+'&subCatId='+subCatId+'&grnNo='+URLEncode(grnNo)+'&docNo='+docNo+'&grnType='+URLEncode(grnType);
					 url +='&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&LocId=' +locationId+ '&BinId=' +binId+'&grnNo='+grnNo+'&binQty='+binQty;
					
						var htmlobj=$.ajax({url:url,async:false});
						
					}
			
		}
	}
	
	var url_h = 'storeconfirmdb.php?RequestType=saveStockHistory&styleID='+document.getElementById("cboOrderNo").value;
	var htmlobj_h =$.ajax({url:url_h,async:false});
	hideBackGroundBalck();
	alert('Successfully confirmed.');
		window.location.reload();
}

function setCheckQty(obj,index)
{
	var qty=parseFloat(obj.parentNode.parentNode.parentNode.cells[6].innerHTML);//total qty leftover or disposal
	var disposeQty =parseFloat(obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value); //disposal qty
	
	//if disposal qty is 0 then asign total qty as leftover qty
	if(obj.checked==true){
		if(obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value==""){
			obj.parentNode.parentNode.parentNode.cells[9].innerHTML=parseFloat(qty);
		}
		else{
			obj.parentNode.parentNode.parentNode.cells[9].innerHTML=(parseFloat(qty) - parseFloat(obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value));
		}
	}
	else{
		obj.parentNode.parentNode.parentNode.cells[9].innerHTML="";
		obj.parentNode.parentNode.parentNode.cells[8].childNodes[0].value=0;
	}
	//asign leftover qty and disposal qty to material array
	Materials[index][6] = qty-disposeQty;
	Materials[index][7] = disposeQty;
}

function setGridBalance(obj,index)
{
	var tblMain =document.getElementById("tblMain");
	var disQty = obj.value;
	var qty = parseFloat(obj.parentNode.parentNode.cells[6].innerHTML)
	if(disQty != '')
	{
		if(parseFloat(disQty)>qty)
		{
			disQty=	qty;
		}
		var balQty = parseFloat(qty) - parseFloat(disQty);
		obj.parentNode.parentNode.cells[7].childNodes[0].childNodes[0].checked=true;
		obj.parentNode.parentNode.cells[9].innerHTML = balQty
		obj.parentNode.parentNode.cells[8].childNodes[0].value = disQty;
	}
	else
	{
		obj.parentNode.parentNode.cells[7].childNodes[0].childNodes[0].checked=false;
		obj.parentNode.parentNode.cells[8].childNodes[0].value=0;
		obj.parentNode.parentNode.cells[9].innerHTML = qty;
	}
	//asign leftover qty and disposal qty to material array
	Materials[index][6] = obj.parentNode.parentNode.cells[9].innerHTML;
	Materials[index][7] = parseFloat(obj.parentNode.parentNode.cells[8].childNodes[0].value);
	
	//when disposal qty change assign new leftover qty to bin array and bin details.
	var BinMaterials = [];
	var mainBinArrayIndex = 0;
	var Bindetails = [];
	Bindetails[0] =   parseFloat(obj.parentNode.parentNode.cells[9].innerHTML); // leftover qty
	Bindetails[1] =   obj.parentNode.parentNode.cells[12].id; // MainStores
	Bindetails[2] =   obj.parentNode.parentNode.cells[13].id;// SubStores
	Bindetails[3] =   obj.parentNode.parentNode.cells[14].id; // Location
	Bindetails[4] =   obj.parentNode.parentNode.cells[11].id; // BinId							
	BinMaterials[mainBinArrayIndex] = Bindetails;
	
	Materials[index][5] = BinMaterials;				
	tblMain.rows[index+1].className = "bcgcolor-tblrowWhite";
}

function chekDisposeItemAvailability()
{
	var tbl = 	document.getElementById("tblMain");
	var count =0;
	var rwCount = tbl.rows.length-1;
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[8].childNodes[0].value==0)	
			count++;
	}
	if(count == rwCount)
		return false;
	else
		return true;
}