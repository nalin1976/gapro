// JavaScript Document
var xmlHttp;
var pub_intxmlHttp_count=0;
var rowArray = [];

function LoadSubCategory(obj)
{
	var maincatid = obj.value;
	var url = "SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory MSC WHERE MSC.intCatNo =  '"+maincatid+"' order by MSC.StrCatName";
	loadCombo(url,'cboSubCat');
	document.getElementById("cboSubCat").focus();
}
//--------------------------------------------------------
function LoadMaterials(obj)
{
	var style = document.getElementById("cboStyle").value;
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	
	var url = "select MIL.intItemSerial, MIL.strItemDescription  from stocktransactions ST join matitemlist MIL on ST.intMatDetailId=MIL.intItemSerial where MIL.intMainCatID =  '"+maincatid+"' and MIL.intSubCatID =  '"+subcatid+"' and ST.intStyleId =  '"+style+"' group by MIL.intItemSerial";
	loadCombo(url,'cboMatDesc');
	document.getElementById("cboMatDesc").focus();
}

//--------------------------------------------------------
function LoadColorSizeGrnPo(obj)
{
	var style = document.getElementById("cboStyle").value;
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	var material = document.getElementById("cboMatDesc").value;
	
	var url = "select ST.strColor, ST.strColor  from stocktransactions ST join matitemlist MIL on ST.intMatDetailId=MIL.intItemSerial where MIL.intMainCatID =  '"+maincatid+"' and MIL.intSubCatID =  '"+subcatid+"' and ST.intStyleId =  '"+style+"' and ST.intMatDetailId =  '"+material+"' group by ST.strColor";
	loadCombo(url,'cboColor');
	document.getElementById("cboColor").focus();
	
	var url = "select ST.strSize, ST.strSize  from stocktransactions ST join matitemlist MIL on ST.intMatDetailId=MIL.intItemSerial where MIL.intMainCatID =  '"+maincatid+"' and MIL.intSubCatID =  '"+subcatid+"' and ST.intStyleId =  '"+style+"' and ST.intMatDetailId =  '"+material+"' group by ST.strSize";
	loadCombo(url,'cboSize');	
}

//--------------------------------------------------------
function loadGRNPO(obj)
{
	var style = document.getElementById("cboStyle").value;
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	var material = document.getElementById("cboMatDesc").value;
	var color = document.getElementById("cboColor").value;
	var size = document.getElementById("cboSize").value;
	
	
	var url = "select grndetails.intGrnNo  ,grndetails.intGrnNo from stocktransactions join matitemlist  on stocktransactions.intMatDetailId=matitemlist.intItemSerial join grndetails on  grndetails.intMatDetailID=stocktransactions.intMatDetailId and  grndetails.strStyleID=stocktransactions.strStyleNo join grnheader on  grndetails.intGrnNo=grnheader.intGrnNo and grndetails.intGRNYear=grnheader.intGRNYear where matitemlist.intMainCatID =  '"+maincatid+"' and matitemlist.intSubCatID =  '"+subcatid+"' and stocktransactions.strStyleNo =  '"+style+"' and stocktransactions.intMatDetailId =  '"+material+"'";
	
if(color!="")
	 url+=" and stocktransactions.strColor = '"+color+"'";

if(size!="")
	 url+=" and stocktransactions.strSize = '"+size+"'";
	
	 url+=" group by grndetails.intGrnNo";
	
	//loadCombo(url,'cboGRNNo');
	
	//alert(url);
	
	var url = "select grnheader.intPoNo  ,grnheader.intPoNo from stocktransactions join matitemlist  on stocktransactions.intMatDetailId=matitemlist.intItemSerial join grndetails on  grndetails.intMatDetailID=stocktransactions.intMatDetailId and  grndetails.strStyleID=stocktransactions.strStyleNo join grnheader on  grndetails.intGrnNo=grnheader.intGrnNo and grndetails.intGRNYear=grnheader.intGRNYear where matitemlist.intMainCatID =  '"+maincatid+"' and matitemlist.intSubCatID =  '"+subcatid+"' and stocktransactions.strStyleNo =  '"+style+"' and stocktransactions.intMatDetailId =  '"+material+"'";
	
if(color!="")
	url+=" and stocktransactions.strColor = '"+color+"'";

if(size!="")
	url+=" and stocktransactions.strSize = '"+size+"'";
	
	url+=" group by grnheader.intPoNo";
	
	//loadCombo(url,'cboPoNo');
}
	
//--------------------------------------------------------
function loadPONo(obj)
{
	var style = document.getElementById("cboStyle").value;
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	var material = document.getElementById("cboMatDesc").value;
	var color = document.getElementById("cboColor").value;
	var size = document.getElementById("cboSize").value;
	var grnNo = document.getElementById("cboGRNNo").value;
	
	var url = "select grnheader.intPoNo  ,grnheader.intPoNo from stocktransactions join matitemlist  on stocktransactions.intMatDetailId=matitemlist.intItemSerial join grndetails on  grndetails.intMatDetailID=stocktransactions.intMatDetailId and  grndetails.strStyleID=stocktransactions.strStyleNo join grnheader on  grndetails.intGrnNo=grnheader.intGrnNo and grndetails.intGRNYear=grnheader.intGRNYear where matitemlist.intMainCatID =  '"+maincatid+"' and matitemlist.intSubCatID =  '"+subcatid+"' and stocktransactions.strStyleNo =  '"+style+"' and stocktransactions.intMatDetailId =  '"+material+"'";
	
if(color!="")
	 url+=" and stocktransactions.strColor = '"+color+"'";

if(size!="")
	 url+=" and stocktransactions.strSize = '"+size+"'";
	 
if(grnNo!="")
	 url+=" and grndetails.intGrnNo = '"+grnNo+"'";
	
	 url+=" group by grnheader.intPoNo";
	
	//loadCombo(url,'cboPoNo');
	
}
//--------------------------------------------------------------------------------
function loadGrid()
{
	if(document.getElementById("cboStyle").value.trim()=="")
	{
		return false;
	}
	
	var style = document.getElementById("cboStyle").value;
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	var material = document.getElementById("cboMatDesc").value;
	var color = document.getElementById("cboColor").value;
	var size = document.getElementById("cboSize").value;
	var grnNo = document.getElementById("cboGRNNo").value;
	var poNo = document.getElementById("cboPoNo").value;
	
	
	var path  = 'xml.php?req=loadGrid&style='+style+'&maincatid='+maincatid+'&subcatid='+subcatid+'&material='+material+'&color='+color+'&size='+size+'&grnNo='+grnNo+'&poNo='+poNo;
	htmlobj=$.ajax({url:path,async:false});
	var XMLstrMainStoresID 	=	htmlobj.responseXML.getElementsByTagName("strMainStoresID");
	var XMLstrSubStores		=	htmlobj.responseXML.getElementsByTagName("strSubStores");
	var XMLstrLocation 	=	htmlobj.responseXML.getElementsByTagName("strLocation");
	var XMLstrBin	=	htmlobj.responseXML.getElementsByTagName("strBin");
	var XMLstrStyleNo 			=	htmlobj.responseXML.getElementsByTagName("strStyleNo");
	var XMLintMatDetailId	=	htmlobj.responseXML.getElementsByTagName("intMatDetailId");
	var XMLdblQty 			=	htmlobj.responseXML.getElementsByTagName("dblQty");
	var tblMain=document.getElementById('tblItemWise').tBodies[0];
	tblMain.innerHTML="";
	for(var i=0;i<XMLstrMainStoresID.length;i++)
	{
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		(i%2==1)?row.className="grid_raw":row.className="grid_raw2";
		
		var htm="";
			htm="<td>"+XMLstrMainStoresID[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrSubStores[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrLocation[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrBin[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrStyleNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLintMatDetailId[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLdblQty[i].childNodes[0].nodeValue+"</td>";
			row.innerHTML =htm;	
	}
}
//------------------------------------------------------
function loadReport(){
	
	var style = document.getElementById("cboStyle").value;
	if(style==""){
	alert("Please select 'Order No'.");
	document.getElementById("cboStyle").focus();
	return;
	}
	var maincatid = document.getElementById("cboMainCat").value;
	var subcatid = document.getElementById("cboSubCat").value;
	var material = document.getElementById("cboMatDesc").value;
	var color = document.getElementById("cboColor").value;
	var size = document.getElementById("cboSize").value;
	//var grnNo = document.getElementById("cboGRNNo").value;
	//var poNo = document.getElementById("cboPoNo").value;
	
	
	window.open('BinInquiry_ItemWiseReport.php?style='+style+'&maincatid='+maincatid+'&subcatid='+subcatid+'&material='+material+'&color='+color+'&size='+size,'frmBinInquiries'); 
}
//-----------------------------------------------------------
function loadSubStores()
{
	var mainStore = document.getElementById("cboMainStore").value;
	var url = "SELECT substores.strSubID, substores.strSubStoresName FROM substores WHERE substores.strMainID =  '"+mainStore+"'";
	loadCombo(url,'cboSubStore');
	document.getElementById("cboSubStore").focus();
}
//--------------------------------------------------------
function loadLocations()
{
	var mainStore = document.getElementById("cboMainStore").value;
	var subStore = document.getElementById("cboSubStore").value;
	
	var url = "SELECT storeslocations.strLocID, storeslocations.strLocName FROM storeslocations WHERE storeslocations.strMainID =  '"+mainStore+"' and storeslocations.strSubID =  '"+subStore+"'";
	loadCombo(url,'cboLocation');
	document.getElementById("cboLocation").focus();
}
//--------------------------------------------------------
function loadBins()
{
	var mainStore = document.getElementById("cboMainStore").value;
	var subStore = document.getElementById("cboSubStore").value;
	var location = document.getElementById("cboLocation").value;
	
	var url = "SELECT storesbins.strBinID, storesbins.strBinName FROM storesbins WHERE storesbins.strMainID =  '"+mainStore+"' and storesbins.strSubID =  '"+subStore+"' and storesbins.strLocID =  '"+location+"'";
	loadCombo(url,'cboBin');
	//alert(url);
	document.getElementById("cboBin").focus();
}
//--------------------------------------------------------
//--------------------------------------------------------------------------------
function loadGrid2()
{
	
	var mainStore = document.getElementById("cboMainStore").value;
	var subStore = document.getElementById("cboSubStore").value;
	var location = document.getElementById("cboLocation").value;
	var bin = document.getElementById("cboBin").value;
	
	
	var path  = 'xml.php?req=loadGrid2&mainStore='+mainStore+'&subStore='+subStore+'&location='+location+'&bin='+bin;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLstrMainStoresID 	=	htmlobj.responseXML.getElementsByTagName("strMainStoresID");
	var XMLstrSubStores		=	htmlobj.responseXML.getElementsByTagName("strSubStores");
	var XMLstrLocation 	=	htmlobj.responseXML.getElementsByTagName("strLocation");
	var XMLstrBin	=	htmlobj.responseXML.getElementsByTagName("strBin");
	var XMLstrStyleNo 			=	htmlobj.responseXML.getElementsByTagName("strStyleNo");
	var XMLintMatDetailId	=	htmlobj.responseXML.getElementsByTagName("intMatDetailId");
	var XMLdblQty 			=	htmlobj.responseXML.getElementsByTagName("dblQty");
	
	var XMLintGrnNo 			=	htmlobj.responseXML.getElementsByTagName("intGrnNo");
	var XMLintPoNo	=	htmlobj.responseXML.getElementsByTagName("intPoNo");
	var XMLstrColor 			=	htmlobj.responseXML.getElementsByTagName("strColor");
	var XMLstrSize 			=	htmlobj.responseXML.getElementsByTagName("strSize");
	
	
	var tblMain=document.getElementById('binWiseTable').tBodies[0];
	tblMain.innerHTML="";
	
	for(var i=0;i<XMLstrMainStoresID.length;i++)
	{
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		(i%2==1)?row.className="grid_raw":row.className="grid_raw2";
		
		var htm="";
			htm="<td>"+XMLstrMainStoresID[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrSubStores[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrLocation[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrBin[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrStyleNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLintGrnNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLintPoNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLintMatDetailId[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrColor[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLstrSize[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLdblQty[i].childNodes[0].nodeValue+"</td>";
			row.innerHTML =htm;	
	}
}

function loadReportBinWise()
{
	var mainStore 	= document.getElementById("cboMainStore").value;
	var subStore 	= document.getElementById("cboSubStore").value;
	var location 	= document.getElementById("cboLocation").value;
	var bin 		= document.getElementById("cboBin").value;
	
	if(mainStore==""){
		alert("Please select 'Main Store'.");
		document.getElementById("cboMainStore").focus();
		return;
	}
	else if(subStore==""){
		alert("Please select 'Sub Store'.");
		document.getElementById("cboSubStore").focus();
		return;
	}
	else if(location==""){
		alert("Please select 'Location'.");
		document.getElementById("cboLocation").focus();
		return;
	}
	
	window.open('BinInquiry_BinWiseReport.php?mainStore='+mainStore+'&subStore='+subStore+'&location='+location+'&bin='+bin,'frmBinwiseBinInquiries'); 
}

function LoadSC(obj)
{
	document.getElementById('cboSC').value = obj.value;
	}
	
function LoadStyle(obj)
{
	document.getElementById('cboStyle').value = obj.value;
}
	
//----------------------------------------------
function clearFormBin()
{
	document.getElementById('cboMainStore').value = "";
	document.getElementById('cboSubStore').innerHTML = "";
	document.getElementById('cboLocation').innerHTML = "";
	document.getElementById('cboBin').innerHTML = "";
}
	
//----------------------------------------------
function clearFormItem()
{
	document.getElementById('cboStyle').value = "";
	document.getElementById('cboSC').value = "";
	document.getElementById('cboMainCat').innerHTML = "";
	document.getElementById('cboSubCat').innerHTML = "";
	document.getElementById('cboMatDesc').innerHTML = "";
	document.getElementById('cboColor').innerHTML = "";
	document.getElementById('cboSize').innerHTML = "";
	
}
	
//----------------------------------------------