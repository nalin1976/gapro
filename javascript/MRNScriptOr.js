// JavaScript Document

var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var multixmlHttp = [];
var savedCount = 0;
var currentMRNNo = "";
var pub_intMrnNo=0;
var pub_intMrnYear=0;
var pub_mainStore=0;
var pub_RecCount = 0;
//var a;

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
function createXMLHttpRequest3() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp3 = new XMLHttpRequest();
    }
}
function CreateXMLHttpForMRNNo() 
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
function createThirdXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        thirdxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        thirdxmlHttp = new XMLHttpRequest();
    }
}
function createtFourthXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        fourthxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        fourthxmlHttp = new XMLHttpRequest();
    }
}

function createNewMultiXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        multixmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        multixmlHttp[index] = new XMLHttpRequest();
    }
}

function loadStyleID()
{
	/*createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStyleID;
    xmlHttp.open("GET", 'MRNMiddle.php?RequestType=getStyleID', true);
    xmlHttp.send(null);  */
	
	var url = 'MRNMiddle.php?RequestType=getStyleID';
	var htmlobj=$.ajax({url:url,async:false});
	var XMLStyleNo = htmlobj.responseXML.getElementsByTagName("StyleName");						
	document.getElementById("cboStyleID").innerHTML = XMLStyleNo[0].childNodes[0].nodeValue;
}

/*function handleStyleID()
{
	  if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			// var style 		= xmlHttp.responseXML.getElementsByTagName("Style");
			 var StyleName 	= xmlHttp.responseXML.getElementsByTagName("StyleName");
			 for ( var loop = 0; loop < style.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = StyleName[loop].childNodes[0].nodeValue;
				opt.value = style[loop].childNodes[0].nodeValue;
				document.getElementById("cboStyleID").options.add(opt);				
			 }
			 
		}
	}
	
}*/
function LoadBuyerPO()
{
	//var styleID = document.getElementById('cboStyleID').value;
	var styleID = document.getElementById('cboscno').value;
	 var theDropDown = document.getElementById("cbobuyerpono");  
 clearDropDown("cbobuyerpono");
	if(styleID=="Select One")return;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBuyerPO;
    xmlHttp.open("GET", 'MRNMiddle.php?RequestType=BuyerPO&StyleID=' + URLEncode(styleID) , true);
    xmlHttp.send(null);  
}

function HandleBuyerPO()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var PO = xmlHttp.responseXML.getElementsByTagName("PO");
			  var POName = xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
			 for ( var loop = 0; loop < PO.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = POName[loop].childNodes[0].nodeValue;
				opt.value = PO[loop].childNodes[0].nodeValue;
				document.getElementById("cbobuyerpono").options.add(opt);
				
			 }
			LoadQty();
		}
	}
}

function LoadSCNo(obj)
{
//clearDropDown("cboscno");
//alert(obj.value);
	document.getElementById('cboscno').value = obj.value;
	document.getElementById('cboOrderNo').value = obj.value;
	/*var styleID = document.getElementById('cboscno').value;
	if(styleID=="Select One")return;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleScNo;
    thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=SRNo&StyleID=' + URLEncode(styleID) , true);
    thirdxmlHttp.send(null);  */
}

function HandleScNo()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
	
			 var srNo= thirdxmlHttp.responseXML.getElementsByTagName("SR")[0].childNodes[0].nodeValue;
			// alert(srNo);
			 document.getElementById("cboscno").value=srNo;
	/*		 for ( var loop = 0; loop < srNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = srNo[loop].childNodes[0].nodeValue;
				opt.value = srNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboscno").options.add(opt);
			 }*/
			 
		}
	}
}
//---------
function GetStyleID(obj)
{
 
   document.getElementById("cboOrderNo").value = obj.value;
	//alert(SCNO);
	/*createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleGetStyleID;
    thirdxmlHttp.open("GET", 'MRNMiddle.php?RequestType=GetStyleID&SCNO=' + SCNO , true);
    thirdxmlHttp.send(null);  */
}

function HandleGetStyleID()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
	
			 var StyleID= thirdxmlHttp.responseXML.getElementsByTagName("StyleID")[0].childNodes[0].nodeValue;
			  var StyleName = thirdxmlHttp.responseXML.getElementsByTagName("StyleName")[0].childNodes[0].nodeValue;
			/* document.getElementById("cboStyleID").value=StyleID;
			  document.getElementById("cboStyleID").text=StyleName;*/
			  var opt = document.createElement("option");
				opt.text = StyleName;
				opt.value = StyleID;
				document.getElementById("cboStyleID").options.add(opt);
			 LoadBuyerPO();
			 LoadMainCat();
		}
	}
}
function GetSCNO()
{
	clearDropDown("cboscno");	
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleGetSCNO;
    thirdxmlHttp.open("GET", 'MRNMiddle.php?RequestType=GetSCNO', true);
    thirdxmlHttp.send(null);  
}

function HandleGetSCNO()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
	
			 var XMLSRNO= thirdxmlHttp.responseXML.getElementsByTagName("SRNO");
			 var XMLStyleId= thirdxmlHttp.responseXML.getElementsByTagName("StyleId");
			 
			 for ( var loop = 0; loop < XMLSRNO.length; loop ++)
			 {			
				var opt = document.createElement("option");
				opt.text = XMLSRNO[loop].childNodes[0].nodeValue;
				opt.value = XMLStyleId[loop].childNodes[0].nodeValue;
				document.getElementById("cboscno").options.add(opt);
			 }
			 
		}
	}
}
//-----------
function LoadQty()
{

	var styleID = document.getElementById('cboOrderNo').value;
	var buyerPO=document.getElementById('cbobuyerpono').value;
	var scNo=document.getElementById('cboscno').value;
	//if(scNo=="" && buyerPO=="")
	//return;
	if(scNo=="")
	{
		setTimeout("LoadQty()", 500);
		
		}
		else
		{
	
			if(styleID=="Select One")return;
    		createAltXMLHttpRequest();
    		altxmlHttp.onreadystatechange = HandleQty;
    		altxmlHttp.open("GET",'MRNMiddle.php?RequestType=getQty&StyleID='+ URLEncode(styleID) +'&buyerPO='+URLEncode(buyerPO)+'&scNo='+scNo, true);
    		altxmlHttp.send(null);  
		}
}

function HandleQty()
{

    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
	
			 document.getElementById('txtorderqty').value=altxmlHttp.responseXML.getElementsByTagName("qty")[0].childNodes[0].nodeValue;
			 document.getElementById('txtReqQty').value=altxmlHttp.responseXML.getElementsByTagName("qty")[0].childNodes[0].nodeValue;
			 
			 
		}
	}
}

function LoadMainCat()
{
    clearDropDown("cbomat");    
	var styleID = document.getElementById('cboOrderNo').value;
	if(styleID=="Select One")return;
    createtFourthXMLHttpRequest() ;
    fourthxmlHttp.onreadystatechange = HandleMainCat;
    fourthxmlHttp.open("GET", 'MRNMiddle.php?RequestType=MainCat&StyleID=' + URLEncode(styleID) , true);
    fourthxmlHttp.send(null);  
}

function HandleMainCat()
{

    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
			 var mainCat =fourthxmlHttp.responseXML.getElementsByTagName("Catname");
			 var mainCatID=fourthxmlHttp.responseXML.getElementsByTagName("CatID");
			 
			 var opt2 = document.createElement("option");
			 opt2.text = ""
			 opt2.value = 0
			 document.getElementById("cbomat").options.add(opt2);
			 
			 for ( var loop = 0; loop < mainCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = mainCat[loop].childNodes[0].nodeValue;
				opt.value = mainCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cbomat").options.add(opt);
			 }
			 LoadSubCat();
			 loadStyleRatioColor();
			 
		}
	}
}
function LoadSubCat()
{
	clearDropDown('cbomaterials');
   	var styleID = document.getElementById('cboOrderNo').value;
	
	var mainCatID=document.getElementById('cbomat').value;
	
	if(styleID=="Select One")return;
    createtFourthXMLHttpRequest() ;
    fourthxmlHttp.onreadystatechange = HandleSubCat;
    fourthxmlHttp.open("GET", 'MRNMiddle.php?RequestType=SubCat&StyleID='+ URLEncode(styleID)+'&mainCatID='+mainCatID, true);
    fourthxmlHttp.send(null);  
}

function HandleSubCat()
{

    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
			 var SubCat =fourthxmlHttp.responseXML.getElementsByTagName("SubCatName");
			 var SubCatID=fourthxmlHttp.responseXML.getElementsByTagName("SubCatID");
			 
			var opt2 = document.createElement("option");
			opt2.text = ""
			opt2.value = 0
			document.getElementById("cbomaterials").options.add(opt2);
			 
			 for ( var loop = 0; loop < SubCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = SubCat[loop].childNodes[0].nodeValue;
				opt.value = SubCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cbomaterials").options.add(opt);
			 }
			 
		}
	}
}
function clearDropDown(controName) {  
 
 var theDropDown = document.getElementById(controName)  
 var numberOfOptions = theDropDown.options.length  
 for (i=0; i<numberOfOptions; i++) {  
   theDropDown.remove(0)  
 }
 }
 
 function MatToMRN()
 {
	 var styleID	= document.getElementById('cboOrderNo').value;
	 if(styleID == 'Select One')
	 {
		 alert('Select \"Order No\"');
		 document.getElementById('cboOrderNo').focus();
		 return; 
	}
	var buyerPO		= document.getElementById('cbobuyerpono').value;
	var tbl			= document.getElementById('mrnMatGrid');
	var count		= tbl.rows.length;
	 if(count>1)
	 {		
		for( var loop = 1 ;loop <count  ; loop ++ )
		{
			tbl.deleteRow(1);
		}
	 }

	 var scNO		= document.getElementById('cboscno').value;
	 var mainCatID	= document.getElementById('cbomat').value;
	 var subCatID	= document.getElementById('cbomaterials').value;
	 var totalQty	= document.getElementById('txtorderqty').value;
	 var store 		= document.getElementById("cboFactory").value;

	showPleaseWait();
    var url = 'MRNMiddle.php?RequestType=getMatInfo&styleID='+URLEncode(styleID)+'&mainCatID='+mainCatID+'&subCatID='+subCatID+'&buyerPO='+URLEncode(buyerPO)+'&scNo='+scNO + '&store=' + store;
    htmlobj=$.ajax({url:url,async:false});
	handleMatToMRN(htmlobj);
}

function handleMatToMRN(fourthxmlHttp)
{ 
	hidePleaseWait();
	var qty			= document.getElementById('txtReqQty').value;
	var itemDisI 	= fourthxmlHttp.responseXML.getElementsByTagName("Item");		 
	for(var loop = 0; loop < itemDisI.length; loop ++)
	{
		var itemDis			= itemDisI[loop].childNodes[0].nodeValue;
		var color			= fourthxmlHttp.responseXML.getElementsByTagName("color")[loop].childNodes[0].nodeValue;
		var size			= fourthxmlHttp.responseXML.getElementsByTagName("size")[loop].childNodes[0].nodeValue;
		var qty				= fourthxmlHttp.responseXML.getElementsByTagName("qty")[loop].childNodes[0].nodeValue;
		var matDetaiID		= fourthxmlHttp.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
		var conPCItem		= fourthxmlHttp.responseXML.getElementsByTagName("ConPC")[loop].childNodes[0].nodeValue;
		//var balanceQty=fourthxmlHttp.responseXML.getElementsByTagName("BalQty")[loop].childNodes[0].nodeValue;
		var balanceQty		= 0;
		var mrnRaised		= fourthxmlHttp.responseXML.getElementsByTagName("MRNRaised")[loop].childNodes[0].nodeValue;
		var issueQty		= fourthxmlHttp.responseXML.getElementsByTagName("Issued")[loop].childNodes[0].nodeValue;
		var issueBalance	= 0;
		//fourthxmlHttp.responseXML.getElementsByTagName("issueBalance")[loop].childNodes[0].nodeValue;
		var stockBalance	= fourthxmlHttp.responseXML.getElementsByTagName("stockBalance")[loop].childNodes[0].nodeValue;
		var wastage			= fourthxmlHttp.responseXML.getElementsByTagName("Wastage")[loop].childNodes[0].nodeValue;
		var Approved		= fourthxmlHttp.responseXML.getElementsByTagName("Approved")[loop].childNodes[0].nodeValue;
		var NotApproved		= fourthxmlHttp.responseXML.getElementsByTagName("NotApproved")[loop].childNodes[0].nodeValue;
		var trimInspected	= fourthxmlHttp.responseXML.getElementsByTagName("TrimInspected")[loop].childNodes[0].nodeValue; 
		var unFormatreqQty	= conPCItem*qty;
		var roundQty		= roundNumber(unFormatreqQty,2);
		balanceQty			= stockBalance-mrnRaised; 
		
		//start 2010-11-03  add grnno &year
		var grnNo 			= fourthxmlHttp.responseXML.getElementsByTagName("GRNno")[loop].childNodes[0].nodeValue;
		var grnYear 		= fourthxmlHttp.responseXML.getElementsByTagName("grnYear")[loop].childNodes[0].nodeValue;
		//end 2010-11-03
		var grnType 		= fourthxmlHttp.responseXML.getElementsByTagName("strGRNType")[loop].childNodes[0].nodeValue;
		var grnTypeId 		= fourthxmlHttp.responseXML.getElementsByTagName("strGRNTypeId")[loop].childNodes[0].nodeValue;
		var invoiceNo 		= fourthxmlHttp.responseXML.getElementsByTagName("invoiceNo")[loop].childNodes[0].nodeValue;
		var mainCategoryId  = fourthxmlHttp.responseXML.getElementsByTagName("intMainCatID")[loop].childNodes[0].nodeValue;
		
		craeteGrid(itemDis,color,size,qty,matDetaiID,roundQty,balanceQty,mrnRaised,issueQty,issueBalance,stockBalance,wastage,Approved,NotApproved,conPCItem,trimInspected,grnNo,grnYear,grnType,grnTypeId,invoiceNo,mainCategoryId); 
	}
 getReqQty(document.getElementById("txtReqQty"));		 
}
 
 function craeteGrid(itemDis,color,size,qty,matDetaiID,reqQTY,balanceQty,mrnRaised,issueQty,issueBalance,stockBalance,wastage,Approved,NotApproved,conPCItem,trimInspected,grnNo,grnYear,grnType,grnTypeId,invoiceNo,mainCategoryId)
 {
	var inhose=0
	
    var tbl = document.getElementById('mrnMatGrid');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellStockTrans = row.insertCell(0);
	
	if(stockBalance==-100)
	{
		cellStockTrans.innerHTML = "<div align=\"center\"><label id=\"ss\"></label></div>";
	}
	else
	{
		cellStockTrans.innerHTML = "<div align=\"center\"><img src=\"images/manage.png\" onClick=\"setStockTransaction(this)\" id="+matDetaiID+" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	}
	
	
	var cellSelect = row.insertCell(1);   	
	cellSelect.id = matDetaiID;
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+matDetaiID+" value=\"checkbox\" /></div>";
	
	tbl.rows[lastRow].bgColor="#FFFFFF";
	if(trimInspected!="")
	{

		cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+matDetaiID+" value=\"checkbox\" /></div>";
	
	}
	
	//MRN Completed styles
	if(stockBalance==0 && mrnRaised ==issueQty)
	{
		tbl.rows[lastRow].bgColor="#FFFFCC";
		cellSelect.innerHTML = "<div align=\"center\"><label id=\"ss\"></label></div>";
	}
	
	/*if(qty == mrnRaised && qty != 0 && balanceQty<=0)
	{
		tbl.rows[lastRow].bgColor="#FFFFCC";
		cellSelect.innerHTML = "<div align=\"center\"><label id=\"ss\"></label></div>";
	}*/
	/*else if(trimInspected=="0")
	{
		
		tbl.rows[lastRow].bgColor="#CCFFFF";
		cellSelect.innerHTML = "<div align=\"center\"><label id=\"ss\"></label></div>";
	}*/
	if(stockBalance==-100)
	{
		tbl.rows[lastRow].bgColor="#FFD9DA";
		//cellSelect.innerHTML="";
		cellSelect.innerHTML = "<div align=\"center\"><label id=\"ss\"></label></div>";
		stockBalance=0;
		inhose=0
		trimInspected=0
	}
	else if(stockBalance!=-100)
	{
		inhose=1
	}
	
	if(balanceQty<0)
	{
	balanceQty=0;	
	}
	
	
	var cellDis=row.insertCell(2);
	cellDis.id=matDetaiID;
	cellDis.className="normalfnt";
	cellDis.innerHTML=itemDis;
	
	var cellColor=row.insertCell(3);
	cellColor.className="normalfnt";
	cellColor.innerHTML=color;
	
	var cellSize=row.insertCell(4);
	cellSize.className="normalfnt";
	cellSize.innerHTML=size;
	
	var cellqty=row.insertCell(5);
	cellqty.className="normalfntRite";
	cellqty.innerHTML=qty;
	
	var reqQty=row.insertCell(6);
	reqQty.className="normalfntMid";
	if(parseInt(inhose)==0 || trimInspected=="" || (qty == mrnRaised && qty != 0))
	{
		if(parseFloat(balanceQty)>parseFloat(stockBalance))
		{
			var entqty=stockBalance;
		}
		else if(parseFloat(stockBalance)==-100)
		{
			var entqty=0;
		}
		else if(parseFloat(stockBalance)>=parseFloat(balanceQty))
		{
			var entqty=balanceQty;
		}
		reqQty.innerHTML="<input type=\"text\" size=\"8\" class=\"txtbox\" onfocus=\"javascript: select()\" onkeyup=\"checkQty(this)\" style=\"text-align:right\"  disabled=\"disabled\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  value="+entqty+"></input>";
	}
	else if(parseInt(inhose)==1 && trimInspected!="")
	{
		if(parseFloat(balanceQty)>parseFloat(stockBalance))
		{
			var entqty=stockBalance;
		}
		else if(parseFloat(stockBalance)==-100)
		{
			var entqty=0;
		}
		else if(parseFloat(stockBalance)>=parseFloat(balanceQty))
		{
			var entqty=balanceQty;
		}
		reqQty.innerHTML="<input type=\"text\" size=\"8\" class=\"txtbox\" onfocus=\"javascript: select()\" onkeyup=\"checkQty(this)\" style=\"text-align:right\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  value="+entqty+"></input>";
	}
	
	
	var Balqty=row.insertCell(7);
	Balqty.className="normalfntRite";
	var balQty1 = parseFloat(stockBalance)+parseFloat(issueQty)-parseFloat(mrnRaised);
	if(balQty1<0)
		balQty1 = 0;
	Balqty.innerHTML=balQty1;
	
	var mrnRaise=row.insertCell(8);
	mrnRaise.className="normalfntRite";
	mrnRaise.innerHTML=mrnRaised;
	
	var Issue=row.insertCell(9);
	Issue.className="normalfntRite";
	Issue.innerHTML=issueQty;
	
	var cellstockBalance=row.insertCell(10);
	cellstockBalance.className="normalfntRite";
	cellstockBalance.innerHTML=mrnRaised-issueQty;//issueBalance;
	
	var cellstockBalance=row.insertCell(11);
	cellstockBalance.className="normalfntRite";
	cellstockBalance.innerHTML=stockBalance;
	
	var conPc=row.insertCell(12);
	conPc.className="normalfntRite";
	//conPCItem=Math.round(conPCItem*1000)/1000;
	conPc.innerHTML=conPCItem;
	
	var cellwastage=row.insertCell(13);
	cellwastage.className="normalfntRiteSML";
	cellwastage.innerHTML=wastage;
	
	var appQty=row.insertCell(14);
	appQty.className="normalfntRiteSML";
	appQty.innerHTML=Approved;
	
	var NotAppQty=row.insertCell(15);
	NotAppQty.className="normalfntRiteSML";
	NotAppQty.innerHTML=NotApproved;
	
	var NotAppQty=row.insertCell(16);
	NotAppQty.className="normalfntSM";
	NotAppQty.style.display = "none";
	NotAppQty.innerHTML=inhose;
	
	var NotAppQty=row.insertCell(17);
	NotAppQty.className="normalfntSM";
	NotAppQty.style.display = "none";
	NotAppQty.innerHTML=trimInspected;	
	
	var cellGRNno=row.insertCell(18);
	cellGRNno.className="normalfntRB";
	if(grnTypeId == 'B')
		cellGRNno.innerHTML="<a target=\"_blank\" href=\"BulkGRN/Details/grnReport.php?grnYear="+grnYear+"&grnno="+grnNo+"\" >"+grnNo+"</a>";
	else if(grnTypeId == 'S')
		cellGRNno.innerHTML="<a target=\"_blank\" href=\"GRN/Details/grnReport.php?grnYear="+grnYear+"&grnno="+grnNo+"\" >"+grnNo+"</a>";
	
	var cellGRNYear=row.insertCell(19);
	cellGRNYear.className="normalfntRite";
	cellGRNYear.innerHTML=grnYear;
	
	var cellGRNYear=row.insertCell(20);
	cellGRNYear.className="normalfnt";
	cellGRNYear.id = grnTypeId;
	cellGRNYear.innerHTML=grnType;
	
	var cellGRNYear=row.insertCell(21);
	cellGRNYear.className="normalfnt";
	cellGRNYear.innerHTML=invoiceNo;
	
	var cellShrinkager=row.insertCell(22);
	cellShrinkager.className="normalfntMid";
	if(mainCategoryId == 1)
		cellShrinkager.innerHTML="<img src=\"images/add.png\" width=\"16\" height=\"16\" onClick=\"viewShrinkageDetails(this);\">";
	else
		cellShrinkager.innerHTML='';
 }
function checkQty(obj)
{
	var selrow=obj.parentNode.parentNode;
	var row=document.getElementById("mrnMatGrid").getElementsByTagName("TR");
	var cell=row[selrow.rowIndex].getElementsByTagName("TD");
	
	var enterQty=cell[6].firstChild.value
	var ratioQty=cell[5].innerHTML;
	var maxMrn = cell[7].innerHTML;
	
	if(isNaN(enterQty)==true)
	{
		alert("Invalied Quantity.Try again");
		cell[6].firstChild.value=maxMrn;
		return;
	}

		if(parseFloat(enterQty)>parseFloat(maxMrn))
		{
			alert("Sorry! You can't exceed the balance to MRN quantity.");
			cell[6].firstChild.value=maxMrn;
			return;
		}


}

function createCutWisePopUP()
{
	var styleID = document.getElementById('cboOrderNo').value;
	//alert(styleID);
	if(styleID == 'Select One')
	{
		alert("Select the Order No");
		document.getElementById('cboOrderNo').focus();
		return false;
		}
	 createXMLHttpRequest();
    xmlHttp.onreadystatechange = getCutDetails;
    xmlHttp.open("GET", 'MRNMiddle.php?RequestType=getCutQtyDetails&styleID='+styleID , true);
    xmlHttp.send(null);  
	 
}

function getCutDetails()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
			var type =xmlHttp.responseXML.getElementsByTagName("CutNo");
			
			if(type.length>0)
			{
				CutPopUP();
				//createStockpopup
			 for ( var loop = 0; loop < type.length; loop ++)
			 {
				 var cutno=xmlHttp.responseXML.getElementsByTagName("CutNo")[loop].childNodes[0].nodeValue;
				 var qty=xmlHttp.responseXML.getElementsByTagName("CutQty")[loop].childNodes[0].nodeValue;
				 
				 
				 //createStockRow(typeInf,date,qty);
				createCutRow(cutno,qty);
				 
			 }
			 //var Total=xmlHttp.responseXML.getElementsByTagName("Total")[0].childNodes[0].nodeValue;
			  
			 //document.getElementById('txtStock').innerHTML=Total;
			}
			else
			{
			alert("Cut Details Not available for this style");	
			}
			
		}
	}
}

function CutPopUP()
{
	 drawPopupAreaLayer(450,260,'frmCutQty',15);
	// drawPopupArea(958,415,'frmItemRequest');
	 
	  var HTMLText="<table width=\"100%\"bgcolor=\"#ffffff\" border=\"0\">"+
            "<tr>"+
            "<td width=\"100%\" height=\"16\"  class=\"TitleN2white\">"+
			"<table width=\"100%\"border=\"0\" bgcolor=\"#0E4874\">"+
                "<tr>"+
                  "<td width=\"93%\">Cut Details</td>"+
                  "<td width=\"7%\">"+
		         "<img src=\"images/cross.png\"  class=\"mouseover\" alt=\"close\" width=\"17\" height=\"17\" "+
				 "onClick=\"closeLayer();\" />"+
				  "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
          "<td height=\"0\" class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
                "<tr>"+
                  "<td width=\"100%\"><div align=\"center\">"+
                    "<div id=\"divcons\" style=\"overflow:scroll; height:180px; width:400px;\">"+
                      "<table id=\"tblCut\" width=\"380\" cellpadding=\"0\" cellspacing=\"0\">"+
                        "<tr>"+
                          "<td width=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Check</td>"+
             "<td width=\"128\" height=\"43\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">CutNo</td>"+
                          "<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
                          "</tr>"+
                        "</table>"+
                    "</div>"+
                  "</div></td>"+
                  "</tr>"+
              "</table></td>"+
              "</tr>"+
            "<tr>"+
              "<td height=\"21\" bgcolor=\"#d6e7f5\"><table width=\"100%\" border=\"0\">"+
                "<tr>"+
                  
           
     "<td width=\"46%\"><div align=\"right\"><img src=\"images/ok.png\"  class=\"mouseover\"  alt=\"OK\" width=\"86\" "+
		"height=\"24\" onclick=\"totalCutQty();\" /></div>"+
	 "</td>"+
	 "<td width=\"46%\"><div align=\"right\"><img src=\"images/close.png\" class=\"mouseover\" alt=\"close\" "+
	 "onClick=\"closeLayer();\" width=\"97\" height=\"24\" /></div>"+
	 "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>";
	/*var HTMLText = "<table width=\"450\" border=\"0\" >"+
					 " <tr class=\"TitleN2white\">"+
					"	<td width=\"402\"  bgcolor=\"#0E4874\">Select Cut Numbers</td>"+
					"	<td width=\"38\"><img src=\"images/cross.png\"  class=\"mouseover\"  onClick=\"closeLayer();\" alt=\"Close\" name=\"Close\" width=\"17\" height=\"17\" id=\"Close\" /></td>"+
					"  </tr>"+
					"  <tr>"+
					"	<td colspan=\"2\"><table width=\"450\" border=\"0\" id=\"tblCut\">"+
					"	  <tr>"+
						"	<td width=\"10%\">&nbsp;</td>"+
						"	<td width=\"40%\">Cut No</td>"+
						"	<td width=\"50%\">Quantity</td>"+
						"  </tr>"+
						 "</table></td>"+
					  "</tr>"+
					  "<tr>"+
						"<td colspan=\"2\">ok</td>"+
					  "</tr>"+
					"</table>";*/
					
	  var frame = document.createElement("div");
     frame.id = "CutTransWindow";
	 document.getElementById('frmCutQty').innerHTML=HTMLText;
}

function totalCutQty()
{
	var tbl = document.getElementById('tblCut');
	var Count = tbl.rows.length;
	var tblItem = document.getElementById('mrnMatGrid');
	var tblCnt = tblItem.rows.length;
	
	if(tblCnt == 1)
	{
			alert("Select MRN Items bofore add Cut Quantities");
			closeLayer();
			return false;
		}
	var total =0;
	for(var no=1;no<Count;no++)
	{
		var chk = tbl.rows[no].cells[0].childNodes[0].checked;
		if(chk == true)
		{ 
			var tot = parseFloat(tbl.rows[no].cells[2].innerHTML);
			total += tot;
		}
	}
	
	document.getElementById('txtReqQty').value = total;
	getReqQty(document.getElementById('txtReqQty'));
	closeLayer();
}
function createCutRow(cutno,qty)
{
	var tbl = document.getElementById('tblCut');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellType=row.insertCell(0);
	cellType.className="normalfntSM";
	//cellType.width="33";
	cellType.innerHTML="<input type='checkbox' name='chkCon' id='chkCon'>";
	
	var cellDate=row.insertCell(1);
	cellDate.className="normalfntMidSML";
	//cellDate.width="43";
	cellDate.innerHTML=cutno;
	
	var cellQty=row.insertCell(2);
	cellQty.className="normalfntMidSML";
	//cellQty.width="67";
	cellQty.innerHTML=qty;
	
	
}

function createRequestItemPopUp()
{
	 var url="popMRNaddnew.php"
	 htmlobj=$.ajax({url:url,async:false});
	 var HTMLText=htmlobj.responseText;
	 drawPopupArea(950,450,'frmItemRequest');
	 document.getElementById('frmItemRequest').innerHTML=HTMLText;
	 
 }
 
  function LoadSCNoStyle()
 {
	 	document.getElementById('cboscno').value = document.getElementById('cboStyleID').value;
	 }
 function createStockpopup()
 {
	 //drawPopupArea(370,250,'frmStockTrans');
	 drawPopupAreaLayer(320,260,'frmStockTrans',15);
	 var HTMLText="<table width=\"100%\"bgcolor=\"#ffffff\" border=\"0\">"+
            "<tr>"+
            "<td width=\"100%\" height=\"16\"  class=\"TitleN2white\">"+
			"<table width=\"100%\"border=\"0\" bgcolor=\"#0E4874\">"+
                "<tr>"+
                  "<td width=\"93%\">Stock transaction</td>"+
                  "<td width=\"7%\">"+
		         "<img src=\"images/cross.png\"  class=\"mouseover\" alt=\"close\" width=\"17\" height=\"17\" "+
				 "onClick=\"closeLayer();\" />"+
				  "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
          "<td height=\"0\" class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
                "<tr>"+
                  "<td width=\"100%\"><div align=\"center\">"+
                    "<div id=\"divcons\" style=\"overflow:scroll; height:180px; width:300px;\">"+
                      "<table id=\"stockBalance\" width=\"280\" cellpadding=\"0\" cellspacing=\"0\">"+
                        "<tr>"+
                          "<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Type</td>"+
             "<td width=\"128\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
                          "<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
                          "</tr>"+
                        "</table>"+
                    "</div>"+
                  "</div></td>"+
                  "</tr>"+
              "</table></td>"+
              "</tr>"+
            "<tr>"+
              "<td height=\"21\" bgcolor=\"#d6e7f5\"><table width=\"100%\" border=\"0\">"+
                "<tr>"+
                  "<td width=\"31%\" class=\"normalfnBLD1\">Total Stock</td>"+
            "<td width=\"23%\" class=\"normalfntRiteTABb-ANS\"><label id=\"txtStock\"></label></td>"+
     "<td width=\"46%\"><div align=\"right\"><img src=\"images/close.png\" class=\"mouseover\" alt=\"close\" "+
	 "onClick=\"closeLayer();\" width=\"97\" height=\"24\" /></div>"+
	 "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>";
		  
     var frame = document.createElement("div");
     frame.id = "StockTransWindow";
	 document.getElementById('frmStockTrans').innerHTML=HTMLText;
	 //document.getElementById('popupLayer').id="itemSub";
	 
	 
 }

function setStockTransaction(obj)
{
	var styleID=document.getElementById('cboOrderNo').value;
	var buyerPO=URLEncode(document.getElementById('cbobuyerpono').value);
	var store = document.getElementById("cboFactory").value;
	var rowT=obj.parentNode.parentNode.parentNode;	 
	var matID=obj.id;
	var color=URLEncode(rowT.cells[3].childNodes[0].nodeValue);
	var size=URLEncode(rowT.cells[4].childNodes[0].nodeValue);
	var grnNo = rowT.cells[18].childNodes[0].childNodes[0].nodeValue;
	var grnYear = rowT.cells[19].childNodes[0].nodeValue;
	var grnTypeId = rowT.cells[20].id;
	 var type = 'MRN';
	 getGRNwiseStocktransactionDetails(type,styleID,buyerPO,store,matID,color,size,grnNo,grnYear,grnTypeId);
}
 
 function handleStock()
 {
	 if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var type =xmlHttp.responseXML.getElementsByTagName("type")
			
			if(type.length>0)
			{
				createStockpopup();
			 for ( var loop = 0; loop < type.length; loop ++)
			 {
				 var typeInf=xmlHttp.responseXML.getElementsByTagName("type")[loop].childNodes[0].nodeValue;
				 var date=xmlHttp.responseXML.getElementsByTagName("date")[loop].childNodes[0].nodeValue;
				 var qty=xmlHttp.responseXML.getElementsByTagName("qty")[loop].childNodes[0].nodeValue;
				 
				 
				 createStockRow(typeInf,date,qty);
	
				 
			 }
			 var Total=xmlHttp.responseXML.getElementsByTagName("Total")[0].childNodes[0].nodeValue;
			  
			 document.getElementById('txtStock').innerHTML=Total;
			}
			else
			{
			alert("No stock transaction available for this item.(Not a instock item)");	
			}
		
		}
		
	}
	 	 
}
function createStockRow(type,date,qty)
{
	
	var tbl = document.getElementById('stockBalance');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellType=row.insertCell(0);
	cellType.className="normalfntSM";	
	cellType.innerHTML=type;
	
	var cellDate=row.insertCell(1);
	cellDate.className="normalfntSM";
	cellDate.innerHTML=date;
	
	var cellQty=row.insertCell(2);
	cellQty.className="normalfntRite";
	cellQty.innerHTML=qty;
	
}
function addtoMainGrid()
{
var tbl=document.getElementById('mainMatGrid');

var radio 		= document.getElementsByName('checkbox');
var styleNo		= document.getElementById('cboOrderNo').value;
var StyleName 	= document.getElementById('cboStyleID').options[document.getElementById('cboStyleID').selectedIndex].text;
	if(styleNo == 'Select One')
	{
		alert('Please select \"Order No\".');
		document.getElementById('cboStyleID').focus();
		return;
	}
	
	//start 2010-12-29 get style name from db if style name not selected
	if(StyleName == 'Select One')
	{
			var url="MRNMiddle.php?RequestType=getStyleName";
					url += '&styleNo='+styleNo;
					
		var htmlobj=$.ajax({url:url,async:false});
		StyleName = htmlobj.responseXML.getElementsByTagName("styleName")[0].childNodes[0].nodeValue;
		//document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	}
	//end 2010-12-29
	
var BuyerPO 	= document.getElementById('cbobuyerpono').value;
var BuyerPoName = document.getElementById('cbobuyerpono').options[document.getElementById('cbobuyerpono').selectedIndex].text; 
var scNo		= document.getElementById('cboscno').options[document.getElementById('cboscno').selectedIndex].text;
var mainCat="";//document.getElementById('cbomat').options[document.getElementById('cbomat').selectedIndex].text;
var cnt			= 0;
var orderNo 	= document.getElementById('cboOrderNo').options[document.getElementById('cboOrderNo').selectedIndex].text;
var rw			= document.getElementById('mrnMatGrid').getElementsByTagName("TR");
var rowCount	= tbl.rows.length-1;

for (var ii = 1; ii < rw.length; ii++)
	{
		var cell=rw[ii].getElementsByTagName("TD");
		var ss=cell[1].firstChild.firstChild.id;
		
		if(ss!="ss")
		{
			if (cell[1].firstChild.firstChild.checked==true)
			{
				var ItemDetail=cell[2].childNodes[0].nodeValue; 
				var color=cell[3].childNodes[0].nodeValue; 
				var size=cell[4].childNodes[0].nodeValue; 
				var balQty=cell[7].childNodes[0].nodeValue; 
				var qty=cell[6].lastChild.value; 	
				var matID=cell[1].firstChild.firstChild.id;
				var grnNo = cell[18].childNodes[0].childNodes[0].nodeValue;
				var grnYear = cell[19].childNodes[0].nodeValue; 
				var grnTypeId = cell[20].id;
				var grnType = cell[20].childNodes[0].nodeValue; 
				var invoiceNo = cell[21].innerHTML; 
				if (checkAvailability(styleNo,BuyerPO,matID,color,size,grnNo,grnYear,grnTypeId))
				{
					alert("The following combination already exists. System will uncheck it automatically.\n\nStyle No : " + styleNo + " \nBuyer PO : " + BuyerPO + " \nItem : " + ItemDetail + " \nColor : " + color + " \nSize : " + size );
					cell[1].firstChild.firstChild.checked = false;
					continue;  
				}
				addDataRowToMainGrid(styleNo,scNo,BuyerPO,mainCat,ItemDetail,color,size,balQty,qty,matID,StyleName,BuyerPoName,orderNo,grnNo,grnYear,grnTypeId,grnType,invoiceNo);
				cnt++;
			}
			else
			{
				//alert("Select Items to MRN");
				//cnt++;
				//alert(rowCount);
				
				}
		}
		else
		{
			//cnt++;
			}
	}
	
	
	if(cnt>0)	
		alert("Selected item(s) added to the MRN.");
	//var x=confirm("Selected Items added successfully.Do you want to select an other item ?")
	//if(x==false)
	//{
	//	closeLayerByName('itemMain')
	//}
}

function checkAvailability(styleNo,buyerPO,itemcode,color,size,grnNo,grnYear,grnType)
{
	var tblobj=document.getElementById('mainMatGrid');	
//	alert(tbl.rows.length);
	for(var loop = 1 ; loop < tblobj.rows.length; loop ++)
	{
		var avlblStyleNo = tblobj.rows[loop].cells[1].id;
		var avlblBuyerPO = tblobj.rows[loop].cells[3].id;
		var avlblItemCode = tblobj.rows[loop].cells[4].childNodes[0].nodeValue;
		var avlblColor = tblobj.rows[loop].cells[6].childNodes[0].nodeValue;
		var avlblSize = tblobj.rows[loop].cells[7].childNodes[0].nodeValue;
		var avGRNNo = tblobj.rows[loop].cells[11].childNodes[0].nodeValue;
		var avGRNYear = tblobj.rows[loop].cells[12].childNodes[0].nodeValue;
		var avGRNType = tblobj.rows[loop].cells[13].id;
		if(styleNo == avlblStyleNo && buyerPO == avlblBuyerPO && itemcode == avlblItemCode && color == avlblColor && size == avlblSize && avGRNNo == grnNo && grnYear== avGRNYear && avGRNType == grnType)
		{
			 return true; 
		}
	}
	return false;
}

function addDataRowToMainGrid(styleNo,scNo,BuyerPO,MainCat,Detail,color,size,balQty,qty,matID,StyleName,BuyerPoName,orderNo,grnNo,grnYear,grnTypeId,grnType,invoiceNo)
{
var tbl=document.getElementById('mainMatGrid');	
var lastRow = tbl.rows.length;	
var row = tbl.insertRow(lastRow);

	if ((tbl.rows.length % 2) == 0)
	{
		row.className="bcgcolor-tblrowWhite";
	}
	else
	{
		row.className="bcgcolor-tblrowLiteBlue";		
	}
	
var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"images/del.png\" onClick=\"RemoveItem(this);\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	
	var cellMaterial=row.insertCell(1);
	cellMaterial.className="normalfntSM";
	cellMaterial.id=styleNo;
	cellMaterial.innerHTML=StyleName;

	var cellMaterial=row.insertCell(2);
	cellMaterial.className="normalfntSM";
	cellMaterial.innerHTML=scNo;
	
	var cellMaterial=row.insertCell(3);
	cellMaterial.className="normalfntSM";
	cellMaterial.id=BuyerPO;
	cellMaterial.innerHTML=orderNo;

	var cellMaterial=row.insertCell(4);
	cellMaterial.className="normalfntMidSML";
	//cellMaterial.style="visibility:hidden";
	cellMaterial.innerHTML=matID;
	
	var cellDetails=row.insertCell(5);
	cellDetails.id=matID;
	cellDetails.className="normalfntSM";	
	cellDetails.innerHTML=Detail;
	
	var cellColor=row.insertCell(6);
	cellColor.className="normalfntMidSML";
	cellColor.innerHTML=color;
	
	var cellSize=row.insertCell(7);
	cellSize.className="normalfntMidSML";
	cellSize.innerHTML=size;
	
	var cellBalqty=row.insertCell(8);
	cellBalqty.className="normalfntRiteSML";
	cellBalqty.innerHTML=balQty;
	
	var cellQty=row.insertCell(9);
	cellQty.className="normalfntRiteSML";
	cellQty.innerHTML="<input type=\"text\" size=\"12\" class=\"txtbox\" onkeyup=\"validateQty(this);\" onfocus=\"javascript: select();\" value="+qty+" id=\"txtQty\" style=\"text-align:right;\"></input>";
	/*var cellQty=row.insertCell(9);
	cellQty.className="normalfntRiteSML";
	cellQty.innerHTML=qty;*////"<input type=\"text\" size=\"12\" class=\"txtbox\" onfocus=\"javascript: select();\" value="+qty+"></input>";
	
	var cellNotes=row.insertCell(10);
	cellNotes.className="normalfntSM";
	cellNotes.innerHTML="<input type=\"text\" size=\"25\" class=\"txtbox\" maxlength=\"50\" onfocus=\"javascript: select();\"></input>";
	
	var cellGRNno=row.insertCell(11);
	cellGRNno.className="normalfntRiteSML";
	cellGRNno.innerHTML=grnNo;
	
	var cellGRNYear=row.insertCell(12);
	cellGRNYear.className="normalfntRiteSML";
	cellGRNYear.innerHTML=grnYear;
	
	var cellGRNYear=row.insertCell(13);
	cellGRNYear.className="normalfntSM";
	cellGRNYear.id = grnTypeId;
	cellGRNYear.innerHTML=grnType;
	
	var cellGRNYear=row.insertCell(14);
	cellGRNYear.className="normalfntSM";
	cellGRNYear.innerHTML=invoiceNo;
	
	
}

function roundNumber(num, dec) 
{
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{		
		var rowT=obj.parentNode.parentNode.parentNode;		
		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		
	}
}

function saveMrn()
{

	
	var datex=document.getElementById('deliverydateDD').value;
	
	var dipCode=document.getElementById('cbodepartment').value;
	var store = document.getElementById('cboFactory').value;
	var mrnNo = document.getElementById('txtMRNNo').value;
	//alert(store);
	createtFourthXMLHttpRequest() ;
    fourthxmlHttp.onreadystatechange = HandleSaveMrn;
    fourthxmlHttp.open("GET", 'MRNMiddle.php?RequestType=SaveMrnHeader&dipCode='+dipCode + '&datex=' + datex + '&store=' + store+'&mrnNo='+mrnNo, true);
    fourthxmlHttp.send(null);  
}

function HandleSaveMrn()
{

    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
			var xmlResult = fourthxmlHttp.responseXML.getElementsByTagName("Result");
			//alert(xmlResult[0].childNodes[0].nodeValue);
			var response = xmlResult[0].childNodes[0].nodeValue;
			var mrnNoDet = response.split('/');
			var mrnNo    = mrnNoDet[0];
			if(mrnNo > 0)
			{
				currentMRNNo = xmlResult[0].childNodes[0].nodeValue;
				//delete existing mrn details
				var url = 'MRNMiddle.php?RequestType=deleteMRNDetData';
							url += '&response=' +response;
																					
			var htmlobj=$.ajax({url:url,async:false});
			var XMLResponse = htmlobj.responseXML.getElementsByTagName("delResponse")[0].childNodes[0].nodeValue;
			
				if(XMLResponse == '1')
				{
					saveMRNDetail(xmlResult[0].childNodes[0].nodeValue);
					}
					else
					{
					alert("Error in saving data");
					document.getElementById("save").style.visibility = 'visible';
					}
				
			}
			else
			{
				alert("Error in saving data");
				document.getElementById("save").style.visibility = 'visible';
				}
			
		}
	}
}


function saveMRNDetail(mrnNo)
{
	var tbl=document.getElementById('mainMatGrid');
	var itemCount=tbl.rows.length-1;
	var row=document.getElementById('mainMatGrid').getElementsByTagName("TR")
	 pub_RecCount =  parseInt(row.length)-1;
	for ( var loop = 1 ;loop < row.length ; loop ++ )
	{
		var cell=row[loop].getElementsByTagName("TD");
		var styleID=cell[1].id;
		var buyerPo=cell[3].id;
		var scNo=cell[2].childNodes[0].nodeValue;

		var MatID= cell[5].id;
		var color=cell[6].childNodes[0].nodeValue;
		var size=cell[7].childNodes[0].nodeValue;
		var qty=cell[9].lastChild.value; 
		var balQty=cell[8].childNodes[0].nodeValue;
			balQty=balQty-qty;
		var notes=cell[10].lastChild.value; 
		
		var grnNo = cell[11].childNodes[0].nodeValue;
		var grnYear = cell[12].childNodes[0].nodeValue;
		var grnTypeId = cell[13].id;
		//var url = styleID+' '+buyerPo+' '+scNo+' '+MatID+' '+color+' '+size+' '+qty+' '+balQty;
		//alert(url);
		createThirdXMLHttpRequest();
		thirdxmlHttp.onreadystatechange = HandleSaveMrnDetails;
		thirdxmlHttp.open("GET", 'MRNMiddle.php?RequestType=SaveMrnDetail&mrnNo=' +mrnNo+ '&styleID=' + URLEncode(styleID) + '&BuyerPO=' + URLEncode(buyerPo) + '&matDetaiID=' + MatID + '&color=' + URLEncode(color) +'&size=' + URLEncode(size) + '&qty=' + qty + '&BalQty=' + balQty + '&notes=' + URLEncode(notes)+'&grnNo='+ grnNo + '&grnYear='+grnYear+'&grnTypeId='+grnTypeId, true);
		thirdxmlHttp.send(null);  
	}
	//getAcknoledgement(mrnNo,itemCount);
	
}
/*function getAcknoledgement(mrnNo,itemCount)
{
createXMLHttpRequest();
 xmlHttp.onreadystatechange = handleAck;
    xmlHttp.open("GET", 'MRNMiddle.php?RequestType=getAck&mrnNo='+mrnNo+'&count='+itemCount, true);
    xmlHttp.send(null);  
	
}
*/

function ValidateMRNSaving()
{
		document.getElementById("save").style.visibility = 'hidden';
		document.getElementById("butConfirm").style.visibility = 'hidden';
	savedCount = 0;
	var row=document.getElementById('mainMatGrid').getElementsByTagName("TR")
	if(row.length==1)
	{
		alert("There is no item(s) available in this MRN. Please select items and press 'Save' button.");
		document.getElementById("save").style.visibility = 'visible';
		//document.getElementById("addNew").focus();
		return;
	}
	
	var dipCode=document.getElementById('cbodepartment').value;
	if(dipCode==0)
	{
		alert("Sorry! You can't proceed with MRN without selecting a department.");
		document.getElementById('cbodepartment').focus();
		return;
	}
	
	var tbl=document.getElementById('mainMatGrid');
	var itemCount=tbl.rows.length-1;
	var row=document.getElementById('mainMatGrid').getElementsByTagName("TR")
	var store = document.getElementById('cboFactory').value;
	for ( var loop = 1 ;loop < row.length ; loop ++ )
	{
		/*var cell=row[loop].getElementsByTagName("TD");
		var styleID=cell[1].childNodes[0].nodeValue;
		var buyerPo=cell[3].childNodes[0].nodeValue;
		var scNo=cell[2].childNodes[0].nodeValue;

		var MatID= cell[5].id;
		var color=cell[6].childNodes[0].nodeValue;
		var size=cell[7].childNodes[0].nodeValue;
		//var qty=cell[9].childNodes[0].nodeValue; 
		var qty=cell[9].lastChild.value;
		var balQty=cell[8].childNodes[0].nodeValue;
			balQty=balQty-qty;
		var notes=cell[10].lastChild.value; 
		//alert(qty);
		createNewMultiXMLHttpRequest(loop);
		multixmlHttp[loop].index= loop;
		multixmlHttp[loop].onreadystatechange = handleSavingProcess;
    	multixmlHttp[loop].open("GET", 'MRNMiddle.php?RequestType=CheckPossibility&styleID=' + URLEncode(styleID) + '&BuyerPO=' + buyerPo + '&matDetaiID=' + MatID + '&color=' + color +'&size=' + size + '&qty=' + qty + '&BalQty=' + balQty + '&notes=' + URLEncode(notes) + '&store=' + store, true);
    	multixmlHttp[loop].send(null);
*/
	var cell=row[loop].getElementsByTagName("TD");
		var styleID=cell[1].id;
		var buyerPo=cell[3].id;
		var scNo=cell[2].childNodes[0].nodeValue;

		var MatID= cell[5].id;
		var color=cell[6].childNodes[0].nodeValue;
		var size=cell[7].childNodes[0].nodeValue;
		//var qty=cell[9].childNodes[0].nodeValue; 
		var qty=cell[9].lastChild.value;
		var balQty=cell[8].childNodes[0].nodeValue;
			balQty=balQty-qty;
		var notes=cell[10].lastChild.value; 
		
		var grnNo = cell[11].childNodes[0].nodeValue;
		var grnYear = cell[12].childNodes[0].nodeValue;
		var grnTypeId = cell[13].id; 
		createNewMultiXMLHttpRequest(loop);
		multixmlHttp[loop].index= loop;
		multixmlHttp[loop].onreadystatechange = handleSavingProcess;
    	multixmlHttp[loop].open("GET", 'MRNMiddle.php?RequestType=CheckPossibility&styleID=' + URLEncode(styleID) + '&BuyerPO=' + buyerPo + '&matDetaiID=' + MatID + '&color=' + URLEncode(color) +'&size=' + URLEncode(size) + '&qty=' + qty + '&BalQty=' + balQty + '&notes=' + URLEncode(notes) + '&store=' + store+'&grnNo='+grnNo+'&grnYear='+grnYear+'&grnTypeId='+grnTypeId, true);
    	multixmlHttp[loop].send(null);
	}
}

function handleSavingProcess()
{
	if(multixmlHttp[this.index].readyState == 4) 
    {
        if(multixmlHttp[this.index].status == 200) 
        {
        		//var tbl = document.getElementById('tblCategories');
        		//tbl.rows[this.index].className = "backcolorGreenRedBorder";
        		//checkCompletion();
        		var XMLResult = multixmlHttp[this.index].responseXML.getElementsByTagName("Result");
				//alert(XMLResult[0].childNodes[0].nodeValue);
				if(XMLResult[0].childNodes[0].nodeValue=="True")
				{
					savedCount ++;
					if(savedCount == document.getElementById('mainMatGrid').rows.length-1)
					{
						saveMrn();
						//alert(123);
					}
				}
				else
				{
					document.getElementById("save").style.visibility = 'visible';
					alert(XMLResult[0].childNodes[0].nodeValue);
				}
			
        }
    }   
}

function HandleSaveMrnDetails()
{
	var cnt=0;
	 if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			var mrnHeader = thirdxmlHttp.responseXML.getElementsByTagName("Result");
			if(mrnHeader[0].childNodes[0].nodeValue=="True")
			{
				/*cnt++;
				alert(cnt);
				if(cnt == pub_RecCount)
				{*/
				alert("MRN saved successfully.\n\nMRN No :" + currentMRNNo);
				document.getElementById('txtMRNNo').value = 	currentMRNNo;
				document.getElementById('save').style.visibility = "visible";
				document.getElementById('report').style.visibility = 'visible';
				document.getElementById('butConfirm').style.visibility = "visible";
				//}
				//clearData();	
				//getMRNNo(2)	
			}
			else
			{
				alert("Error occur while saving data.Please try again shortly.");	
			}
			 
		}
	}
}
	
	
function reportPopup()
{
/*
if(document.getElementById('gotoMrnReport').style.visibility=="hidden")
{
	document.getElementById('gotoMrnReport').style.visibility = "visible";
	LoadMrnacYear();
}
	else
	{
	document.getElementById('gotoMrnReport').style.visibility="hidden";
	return;
	}	
*/
if (document.getElementById('txtMRNNo').value=="")
	return false;
var intMRNno = document.getElementById("txtMRNNo").value;
	  var mrnNo = intMRNno.split('/')[0];
	  var year = intMRNno.split('/')[1];
window.open("mrnrep.php?mrnNo=" + mrnNo + "&year=" + year,'save');
	
}

function LoadMrnacYear()
{
	clearDropDown('cboRptMrnNo');

	document.getElementById('gotoMrnReport').style.visibility = "visible";	
	
	var year=document.getElementById('cboYear').value;
 	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleMrn;
    thirdxmlHttp.open("GET", 'MRNMiddle.php?RequestType=getMrnAccYear&year='+year, true);
    thirdxmlHttp.send(null);  
}

function HandleMrn()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptMrnNo").options.add(opt);
	
			 var poNo= thirdxmlHttp.responseXML.getElementsByTagName("MrnNo");
			 for ( var loop = 0; loop < poNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = poNo[loop].childNodes[0].nodeValue;
				opt.value = poNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptMrnNo").options.add(opt);
			 }
			 
		}
	}
}

function showMrnReport()
{
	
var mrnNo=document.getElementById('cboRptMrnNo').value;
var year=document.getElementById('cboYear').value;
document.getElementById('gotoMrnReport').style.visibility=="hidden"
if(mrnNo!="0")
{
window.location = 'mrnrep.php?mrnNo='+mrnNo+'&year='+year;	
}
else
{
alert("Please select a MRN No to view report.");	
}
}

function clearData()
{
	//document.getElementById('cbodepartment').value=0;
	var tbl=document.getElementById('mainMatGrid');
	var rowCount=tbl.rows.length;
	if(rowCount>1)
	{
	for( var loop = 1 ;loop < rowCount ; loop ++ )
	{
	tbl.deleteRow(1);
	}
	}
	savedCount = 0;
	
}

function newForm()
{
	clearData();
	document.getElementById('save').style.visibility = "";
	document.getElementById('report').style.visibility = "hidden";
	document.getElementById('butConfirm').style.visibility = "hidden";
	document.getElementById("txtMRNNo").value="";
	document.getElementById("cboFactory").value="0";
	document.getElementById("cboFactory").focus();
}

//==================== Ananda 2009/06/17

function setDefaultDate()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "/" + month + "/" +day );
	document.getElementById("deliverydateDD").value=ddate
	//getMRNNo(1)
}

/*
function getMRNNo(task)
{
	
	CreateXMLHttpForMRNNo();
	xmlHttp.onreadystatechange = HandleWithouPOInvNoTask;
	xmlHttp.open("GET", 'MRNMiddle.php?RequestType=MRNNoTask&task=' + task, true);
	xmlHttp.send(null); 
}

function HandleWithouPOInvNoTask()
{
	if(xmlHttp.readyState == 4) 
    {
	   if(xmlHttp.status == 200) 
        {  
			var XMLMRNNo = xmlHttp.responseXML.getElementsByTagName("MRNNo");
	
			if(XMLMRNNo.length>0)
			{
				var MRNNo = XMLMRNNo[0].childNodes[0].nodeValue;
			}
			else
			{
				alert("Please Contact the system administrator to define MRN No Range")
				return;
			}
			document.getElementById("txtMRNNo").value=MRNNo;
		}
	}
}
*/
function highlight(o)
{
	//var row=o
	//var srowno=row.rowIndex
	//var trow=
	
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

function validateAddNew()
{
	if(document.getElementById("cboFactory").value == 0)
	{
		alert("Please select the relevant \"Store\".");
		document.getElementById("cboFactory").focus();
		return ;
	}
	else if(document.getElementById("cbodepartment").value == 0)
	{
		alert("Please select the \"Department\".");
		document.getElementById("cbodepartment").focus();
		return ;
	}
	createRequestItemPopUp();
	loadStyleID();	
	GetSCNO();
	loadOrderNo();
}

function getReqQty(obj)
{
	var reqVal = parseFloat(obj.value);
	var tbl    = document.getElementById('mrnMatGrid');
	var intRows = tbl.rows.length;
	var orderQty = document.getElementById('txtorderqty').value;
	for(var loop=1; loop<intRows; loop++)
	{
		var row 	= tbl.rows[loop];
		var avQty 	= parseFloat(row.cells[7].lastChild.nodeValue);
		var conPc 	= parseFloat(row.cells[12].lastChild.nodeValue);
		var wastage = parseFloat(row.cells[13].lastChild.nodeValue);		
		//var reqdqty = (conPc*reqVal)+(reqVal*wastage/100);
		var reqdqty = calculateReqQty(reqVal,avQty,orderQty);
		
		if(avQty>= reqdqty)
		{
			if(reqdqty<1)
				reqdqty=1;
			row.cells[6].childNodes[0].value = reqdqty;
		}
		else
		{
			row.cells[6].childNodes[0].value = avQty;
		}
		
		if(row.cells[6].childNodes[0].value<=0)
		{
			row.cells[1].childNodes[0].childNodes[0].disabled = true;
		}
	}
	
}

function validateQty(obj)
{
	//var reqVal = obj.value;
	var balQty   = new Number(obj.parentNode.parentNode.cells[8].innerHTML);
	var reqVal = new Number(obj.value);
	if(reqVal>balQty)
	{
		alert("Required quantity should be less than bal. qty.");
		obj.value = balQty;
		//document.getElementById(obj).focus();
		//obj.focus();
		return ;
		}
	
}

function LoardMRN(MRNno,MRNyear,mrnStatus,MainStore)
{
	pub_intMrnNo=MRNno;
    pub_intMrnYear=MRNyear;
    pub_mainStore=MainStore;
	
	//showWaitingWindow();
	
	if((MRNno !=0) || (MRNyear !=0))
	{
		//alert(mrnStatus);
		if(mrnStatus==1)
		{
			
			document.getElementById("save").style.visibility="visible";
			document.getElementById("butConfirm").style.visibility="visible";
			
			
		}
		else if(mrnStatus==10) 
		{
			document.getElementById("save").style.visibility="hidden";
			document.getElementById("butConfirm").style.visibility="hidden";
			
		}
		document.getElementById("report").style.visibility="visible";
		document.getElementById("txtMRNNo").value = MRNno+'/'+MRNyear;
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = MrnHeaderRequest;
		var url  = "mrnXml.php?id=loadMrnHeader";
			url += "&intMrnNo="+MRNno;
			url += "&intYear="+MRNyear;
			url += "&intStatus="+mrnStatus;
			url += "&mainStore="+MainStore;
			//alert(url);
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
		createXMLHttpRequest3();
		xmlHttp3.onreadystatechange = MrnDetailRequest;
		var url2  = "mrnXml.php?id=loadMrnItems";
			url2 += "&intMrnNo="+MRNno;
			url2 += "&intYear="+MRNyear;
			url2 += "&intStatus="+mrnStatus;
			url2 += "&mainStore="+MainStore;
			//alert(url2);
		xmlHttp3.open("GET",url2,true);
		xmlHttp3.send(null);
	}
	else
	{
		setDefaultDate();
		}
	
}

function MrnHeaderRequest()
{
	 if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        {  

			var hasRecord = xmlHttp.responseText;
			//alert(hasRecord);
			if(xmlHttp.responseXML.getElementsByTagName("mrnNo").length<=0)
			{
				document.getElementById("txtMRNNo").value="";
				alert("Record not found");
				//newPage();
				return;
			}
			
			var dtmDate =  xmlHttp.responseXML.getElementsByTagName("mrnDate")[0].childNodes[0].nodeValue;
			var mainStore = xmlHttp.responseXML.getElementsByTagName("mainStoreID")[0].childNodes[0].nodeValue;
			var deptID    = xmlHttp.responseXML.getElementsByTagName("DeptCode")[0].childNodes[0].nodeValue;
			var user      = xmlHttp.responseXML.getElementsByTagName("mrnUser")[0].childNodes[0].nodeValue;
			
			document.getElementById("deliverydateDD").value=dtmDate;
			document.getElementById("cboFactory").value = mainStore;
			document.getElementById("cbodepartment").value = deptID;
			document.getElementById("txtrequestedby").value = user;
		}
	}
}

function MrnDetailRequest()
{
	if(xmlHttp3.readyState == 4)
    {
        if(xmlHttp3.status == 200) 
        { 
			var StyleID =xmlHttp3.responseXML.getElementsByTagName("StyleID"); 
			if(StyleID.length<=0)
			{
				document.getElementById("txtMRNNo").value="";
				alert("Record not found");
				//newPage();
				return;
			}
			
			for(var loop = 0; loop<StyleID.length; loop++)
			{
				var styleID=StyleID[loop].childNodes[0].nodeValue;
				//alert(styleID);
				var styleName=xmlHttp3.responseXML.getElementsByTagName("StyleName")[loop].childNodes[0].nodeValue;
				var BuyerPoid =  xmlHttp3.responseXML.getElementsByTagName("BuyePoid")[loop].childNodes[0].nodeValue;
				var BuyerPoName = xmlHttp3.responseXML.getElementsByTagName("BuyerPOName")[loop].childNodes[0].nodeValue;
				var color=xmlHttp3.responseXML.getElementsByTagName("color")[loop].childNodes[0].nodeValue;
				var size=xmlHttp3.responseXML.getElementsByTagName("size")[loop].childNodes[0].nodeValue;
				var qty=xmlHttp3.responseXML.getElementsByTagName("qty")[loop].childNodes[0].nodeValue;
				var matDetaiID=xmlHttp3.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
				var balQty = xmlHttp3.responseXML.getElementsByTagName("BalQty")[loop].childNodes[0].nodeValue;
				var matName = xmlHttp3.responseXML.getElementsByTagName("Item")[loop].childNodes[0].nodeValue;
				var note = xmlHttp3.responseXML.getElementsByTagName("note")[loop].childNodes[0].nodeValue;
				var scNo = xmlHttp3.responseXML.getElementsByTagName("SCno")[loop].childNodes[0].nodeValue;
				var OrderNo = xmlHttp3.responseXML.getElementsByTagName("OrderNo")[loop].childNodes[0].nodeValue;
				var grnNo = xmlHttp3.responseXML.getElementsByTagName("grnNo")[loop].childNodes[0].nodeValue;
				var grnYear = xmlHttp3.responseXML.getElementsByTagName("grnYear")[loop].childNodes[0].nodeValue;
				var grnType = xmlHttp3.responseXML.getElementsByTagName("grnType")[loop].childNodes[0].nodeValue;
				var strGRNType = xmlHttp3.responseXML.getElementsByTagName("strGRNType")[loop].childNodes[0].nodeValue;
				var invoiceNo = xmlHttp3.responseXML.getElementsByTagName("invoiceNo")[loop].childNodes[0].nodeValue;
				
				addDataRowToMainGridSt(styleID,scNo,BuyerPoid,matName,color,size,balQty,qty,matDetaiID,styleName,BuyerPoName,note,OrderNo,grnNo,grnYear,grnType,strGRNType,invoiceNo)
			}
			
			
		}
	}
}

function addDataRowToMainGridSt(styleNo,scNo,BuyerPO,Detail,color,size,balQty,qty,matID,StyleName,BuyerPoName,note,OrderNo,grnNo,grnYear,grnType,strGRNType,invoiceNo)
{
var tbl=document.getElementById('mainMatGrid');	
var lastRow = tbl.rows.length;	
var row = tbl.insertRow(lastRow);

	if ((tbl.rows.length % 2) == 0)
	{
		row.className="bcgcolor-tblrow";
	}
	else
	{
		row.className="bcgcolor-tblrowWhite";		
	}
	
var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"images/del.png\" onClick=\"RemoveItem(this);\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	
	var cellMaterial=row.insertCell(1);
	cellMaterial.className="normalfntSM";
	cellMaterial.id=styleNo;
	cellMaterial.innerHTML=StyleName;

	var cellMaterial=row.insertCell(2);
	cellMaterial.className="normalfntSM";
	cellMaterial.innerHTML=scNo;
	
	var cellMaterial=row.insertCell(3);
	cellMaterial.className="normalfntSM";
	cellMaterial.id=BuyerPO;
	cellMaterial.innerHTML=OrderNo;

	var cellMaterial=row.insertCell(4);
	cellMaterial.className="normalfntMidSML";
	//cellMaterial.style="textalign=center"
	cellMaterial.innerHTML=matID;
	
	var cellDetails=row.insertCell(5);
	cellDetails.id=matID;
	cellDetails.className="normalfntSM";	
	cellDetails.innerHTML=Detail;
	
	var cellColor=row.insertCell(6);
	cellColor.className="normalfntMidSML";
	cellColor.innerHTML=color;
	
	var cellSize=row.insertCell(7);
	cellSize.className="normalfntMidSML";
	cellSize.innerHTML=size;
	
	var cellBalqty=row.insertCell(8);
	cellBalqty.className="normalfntRiteSML";
	cellBalqty.innerHTML=balQty;
	
	var cellQty=row.insertCell(9);
	cellQty.className="normalfntRiteSML";
	cellQty.innerHTML="<input type=\"text\" size=\"12\" class=\"txtbox\" onkeyup=\"validateQty(this);\" onfocus=\"javascript: select();\" value="+qty+" id=\"txtQty\" style=\"text-align:right\"></input>";
	
	var cellNotes=row.insertCell(10);
	cellNotes.className="normalfntSM";
	cellNotes.innerHTML="<input type=\"text\" size=\"25\" class=\"txtbox\" maxlength=\"50\" value=\""+note+"\" onfocus=\"javascript: select();\"></input>";
	
	var cellGrnNo=row.insertCell(11);
	cellGrnNo.className="normalfntMidSML";
	cellGrnNo.innerHTML=grnNo;
	
	var cellGrnYear=row.insertCell(12);
	cellGrnYear.className="normalfntMidSML";
	cellGrnYear.innerHTML=grnYear;
	
	var cellGrnYear=row.insertCell(13);
	cellGrnYear.className="normalfntSM";
	cellGrnYear.id =grnType 
	cellGrnYear.innerHTML=strGRNType;
	
	var cellGrnYear=row.insertCell(14);
	cellGrnYear.className="normalfntSM";
	cellGrnYear.innerHTML=invoiceNo;
}

function confirmReport(mrnYear)
{	//alert(mrnYear);
	document.getElementById('save').style.visibility = "hidden";
	document.getElementById('butConfirm').style.visibility = "hidden";
	
	var tblGrid = document.getElementById("mainMatGrid");
	var mrn_year = (document.getElementById("mrnYear").value==""? new Date().getFullYear():document.getElementById("mrnYear").value);
	
	  if(tblGrid.rows.length<=1)
	  {
	  	alert("Items not found !");
		return;
	  }
	  var intMRNno = document.getElementById("txtMRNNo").value;
	  var mrnNo = intMRNno.split('/')[0];
	  var year = mrn_year;
	  var storeID = document.getElementById("cboFactory").value;
	  var deptID  = document.getElementById("cbodepartment").value;
	 // alert(document.location.hostname);
	 var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/';
	 //+document.location.pathname.split("/")[2];
	path += "mrnConfirmRpt.php?mrnNo="+mrnNo+'&year='+year+'&MainStoreID='+storeID+'&deptId='+deptID;
	//alert(path);
	var win2=window.open(path,'win');
}

function confirmMRN(mrnNo,mrnYear,storeID,deptId)
{
	//xmlHttp.onreadystatechange = mrnComfirmRequest;
	var url  = "MRNMiddle.php?RequestType=confirmMrn";
		url += "&intMrnNo="+mrnNo;
		url += "&intYear="+mrnYear;
		url += "&storeID="+storeID;
		url += "&deptId="+deptId;
	//xmlHttp.mrnNo = mrnNo;
	//xmlHttp.mrnYear = mrnYear;
	//xmlHttp.open("GET",url,true);
	htmlobj=$.ajax({url:url,async:false});
	mrnComfirmRequest(htmlobj,mrnNo,mrnYear);
}

function mrnComfirmRequest(xmlHttp,mrnNo,mrnYear)
{
var hasRecord = xmlHttp.responseText;
				
	if(xmlHttp.responseXML.getElementsByTagName("MRNresponse")[0].childNodes[0].nodeValue == 1)
	{
		alert("Confirmed successfully.");
		var path  = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/';
			path += "mrnrep.php?mrnNo="+mrnNo+'&year='+mrnYear;
		var win2=window.open(path,'win');
	}
	else
		alert(xmlHttp.responseXML.getElementsByTagName("MRNresponse")[0].childNodes[0].nodeValue)	
}

function loadOrderNo()
{
	var url="MRNMiddle.php";
	url=url+"?RequestType=loadOrderNoDet";	
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboOrderNo").innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
}

function LoadStyleandSC()
{
	
  	 document.getElementById("cboscno").value = document.getElementById("cboOrderNo").value;	
}

function validateOrderQty()
{
	var orderQty = new Number(document.getElementById("txtorderqty").value);
	var reqQty   = new Number(document.getElementById("txtReqQty").value);
	
	if(reqQty>orderQty)
	{
		document.getElementById("txtReqQty").value = orderQty;
		
		}
}

//2010-11-02 start get style wise SCNo
function styleWiseSCno()
{
	var StyleID = document.getElementById("cboStyleID").value;
	var url="MRNMiddle.php";
					url=url+"?RequestType=SRNo";
					url += '&StyleID='+URLEncode(StyleID);
					
		var htmlobj=$.ajax({url:url,async:false});
		var XMLStyleNo = htmlobj.responseXML.getElementsByTagName("SCno");						
	document.getElementById("cboscno").innerHTML = XMLStyleNo[0].childNodes[0].nodeValue;
	clearMRNmatGrid();	
}

//get stylewise Order No 
function styleWiseOrderNo()
{
		var StyleID = document.getElementById("cboStyleID").value;
	var url="MRNMiddle.php";
					url=url+"?RequestType=loadOrderNoStylewise";
					url += '&StyleID='+URLEncode(StyleID);
					
		var htmlobj=$.ajax({url:url,async:false});
		var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("OrderNolist");						
	document.getElementById("cboOrderNo").innerHTML = XMLOrderNo[0].childNodes[0].nodeValue;
}
						  
function clearMRNmatGrid()
{
	var tbl=document.getElementById('mrnMatGrid');
	  var count=tbl.rows.length;
	 if(count>1)
	 {
		
		 for( var loop = 1 ;loop <count  ; loop ++ )
		{
			tbl.deleteRow(1);
		}
	 }	
}

function calculateReqQty(reqVal,avQty,orderQty)
{
	ReqQty = (parseFloat(avQty)/ parseFloat(orderQty)*parseFloat(reqVal));
	
	if(ReqQty <1)
		ReqQty =1;
	else 
		ReqQty = RoundNumbers(ReqQty,2);
		
	return ReqQty;
}

function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}
function loadStyleRatioColor()
{
	var url = "MRNMiddle.php?RequestType=loadOrderNoStyleRatioColor&styleID="+document.getElementById("cboOrderNo").value;	
	var htmlobj=$.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("ratioColor");						
	document.getElementById("txtStyleRatioColor").innerHTML = XMLOrderNo[0].childNodes[0].nodeValue;
	LoadPatternNo();
}
function LoadPatternNo()
{
	var url = "MRNMiddle.php?RequestType=URLLoadPatternNo&styleID="+document.getElementById("cboOrderNo").value;	
	var htmlobj=$.ajax({url:url,async:false});
	var XMLPatternNo = htmlobj.responseText;
	document.getElementById("cboPatternNo").innerHTML = XMLPatternNo;
}
function openBulkGRNReport(grnNo,grnYear)
{
	alert(grnNo)
	}

function viewShrinkageDetails(obj)
{
	drawPopupAreaLayer(502,260,'frmValueSelecter',14);
	var styleId = document.getElementById("cboOrderNo").value;	
	 var rw = obj.parentNode.parentNode;
	 var rwNo = rw.rowIndex;
	 var url="mrnShrinkageDetails.php?&balQty="+rw.cells[7].innerHTML+"&styleId="+styleId+"&rwNo="+rwNo;
	 htmlobj=$.ajax({url:url,async:false});
	 var HTMLText=htmlobj.responseText;
	document.getElementById('frmValueSelecter').innerHTML=HTMLText;
	// document.getElementById('frmItemReq').innerHTML=HTMLText;
}
function setShrinkQty(obj)
{
	var stockQty =  parseFloat(document.getElementById("txtStockQty").value);
	var rwNo = obj.parentNode.parentNode;
	var rollQty = parseFloat(rwNo.cells[2].innerHTML);
	
	var tbl = document.getElementById("tblShrinkage");
	
	if(obj.checked)
	{
		var allocatedQty =0;
		rwNo.cells[4].childNodes[0].value = 0;
		for(var i=1;i<tbl.rows.length;i++)
		{
			if(tbl.rows[i].cells[3].childNodes[0].checked)
			{
				allocatedQty += parseFloat(tbl.rows[i].cells[4].childNodes[0].value);
			}
				
		}
		
		var reducedQty = stockQty-allocatedQty;
		
		if(rollQty<=reducedQty)
			rwNo.cells[4].childNodes[0].value =rollQty;
		else
			rwNo.cells[4].childNodes[0].value = reducedQty;
			
		if(rwNo.cells[4].childNodes[0].value==0)
			rwNo.cells[3].childNodes[0].checked = false;
	}
	else
	{
		rwNo.cells[4].childNodes[0].value = 0;
		rwNo.cells[3].childNodes[0].checked = false;
	}
	
}
function validateRollQty(obj)
{
	var tbl = document.getElementById('tblShrinkage');
	var rw = obj.parentNode.parentNode;
	rw.cells[3].childNodes[0].checked = true;	
	
	var stockQty = document.getElementById("txtStockQty").value;
	var allocatedQty = parseFloat(getAllocatedQty());
	var reqQty = parseFloat(obj.value);
	var avBinQty = parseFloat(rw.cells[2].lastChild.nodeValue);
	
	var avQty = stockQty - (allocatedQty)+reqQty;
	
	if(avQty>stockQty)
	{
		rw.cells[4].childNodes[0].value='';
		rw.cells[4].childNodes[0].value = avBinQty	
	}
	else
	{
		rw.cells[4].childNodes[0].value='';
		var allocatedQty = parseFloat(getAllocatedQty());
		var balQty = stockQty-allocatedQty;
		//alert(balQty + ' ' +avBinQty + ' ' + reqQty)
		if(reqQty>avBinQty)
		{
			if(balQty>avBinQty)
				rw.cells[4].childNodes[0].value = avBinQty;
			else
				rw.cells[4].childNodes[0].value = balQty;
				
			
		}
		else
		{
			if(reqQty>balQty)
				rw.cells[4].childNodes[0].value = balQty;
			else
				rw.cells[4].childNodes[0].value = reqQty;
		}
			
	}
	
	
	if(obj.value=='' || obj.value==0)
		rw.cells[3].childNodes[0].checked = false;	
}
function getAllocatedQty()
{
	var tbl = document.getElementById("tblShrinkage");
	var allocatedQty=0;
	for(var i=1;i<tbl.rows.length;i++)
		{
			if(tbl.rows[i].cells[3].childNodes[0].checked)
			{
				if(tbl.rows[i].cells[4].childNodes[0].value != '')
					allocatedQty += parseFloat(tbl.rows[i].cells[4].childNodes[0].value);
			}
				
		}
		
		return allocatedQty;
}

function addShrinkQty(rwNo)
{
	var stockQty = parseFloat(document.getElementById("txtStockQty").value);
	var tbl = document.getElementById("tblShrinkage");
	var allocatedQty=0;
	for(var i=1;i<tbl.rows.length;i++)
		{
			if(tbl.rows[i].cells[3].childNodes[0].checked)
			{
				if(tbl.rows[i].cells[4].childNodes[0].value != '')
					allocatedQty += parseFloat(tbl.rows[i].cells[4].childNodes[0].value);
			}
				
		}
	var tblMRNdet = document.getElementById("mrnMatGrid");	
	if(allocatedQty <= stockQty)
		tblMRNdet.rows[rwNo].cells[6].childNodes[0].value = allocatedQty;
	else
		{
			var variance = allocatedQty-stockQty;
			alert("Allocated Qty not match with stock Qty\n Allocated Qty : "+allocatedQty +"\n Stock Qty : "+stockQty+ "\n Variance is : " + variance);
			return false;
			}
}
