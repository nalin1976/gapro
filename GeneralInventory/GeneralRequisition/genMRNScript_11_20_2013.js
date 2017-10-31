// JavaScript Document
var pub_MRNno=0;
var pub_MRNyear =0;
var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var xmlHttpArray	= [];
var checkLoop 		= 0;


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


function LoadQty()
{

	var styleID = document.getElementById('cboStyleID').value;
	var buyerPO=document.getElementById('cbobuyerpono').value;
	var scNo=document.getElementById('cboscno').value;
	if(scNo=="" && buyerPO=="")
	return;
	else if(scNo=="")
	{
		setTimeout("LoadQty()", 500);
		
		}
		else
		{
			if(buyerPO.charAt(0)=="#")
			{
				buyerPO=buyerPO.substring(1,buyerPO.length-1);
			}
	
			if(styleID=="Select One")return;
    		createAltXMLHttpRequest();
    		altxmlHttp.onreadystatechange = HandleQty;
    		altxmlHttp.open("GET",'genMRNMiddle.php?RequestType=getQty&StyleID='+styleID+'&buyerPO='+buyerPO+'&scNo='+scNo, true);
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

function clearDropDown(controName) {  
 
 var theDropDown = document.getElementById(controName)  
 var numberOfOptions = theDropDown.options.length  
 for (i=0; i<numberOfOptions; i++) {  
   theDropDown.remove(0)  
 }
 }
 
function loadPopupItems()
{	
	ClearTable('mrnMatGrid');
	var mainCatID=document.getElementById('cboMainCategory');
	var subCatID=document.getElementById('cboSubCategory');
	var chkAllItem = document.getElementById('chkAllItem').checked;
	var strNAVItemCode = document.getElementById('txtItemCode').value;
	
	//if(!ValidateInterface('OpenItemPopup',mainCatID,subCatID))
	//	return;
		
	showPleaseWait();
	var url ='genMRNMiddle.php?RequestType=getMatInfo&mainCatID='+mainCatID.value+'&subCatID='+subCatID.value;
	url += '&chkAllItem='+chkAllItem;
	url += '&itemCode='+strNAVItemCode;

	htmlobj=$.ajax({url:url,async:false});
	var itemDisI =htmlobj.responseXML.getElementsByTagName("Item")
		for ( var loop = 0; loop < itemDisI.length; loop ++)
		{
		var itemDis			=itemDisI[loop].childNodes[0].nodeValue;				 
		var matDetaiID		=htmlobj.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
		var balanceQty		=htmlobj.responseXML.getElementsByTagName("BalQty")[loop].childNodes[0].nodeValue;
		var mrnRaised		=htmlobj.responseXML.getElementsByTagName("MRNRaised")[loop].childNodes[0].nodeValue;
		var issueQty		=htmlobj.responseXML.getElementsByTagName("Issued")[loop].childNodes[0].nodeValue;
		var stockBalance	=htmlobj.responseXML.getElementsByTagName("stockBalance")[loop].childNodes[0].nodeValue;
		var GRNNo			=htmlobj.responseXML.getElementsByTagName("intGRNNo")[loop].childNodes[0].nodeValue;
		var GRNYear			=htmlobj.responseXML.getElementsByTagName("intGRNYear")[loop].childNodes[0].nodeValue;
		var GLCode			=htmlobj.responseXML.getElementsByTagName("GLCode")[loop].childNodes[0].nodeValue;
		var GLAllowId		=htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;
		var ItemCode		=htmlobj.responseXML.getElementsByTagName("NAVItemCode")[loop].childNodes[0].nodeValue;
		
		craeteGrid(itemDis,matDetaiID,balanceQty,mrnRaised,issueQty,stockBalance,GRNNo,GRNYear,GLCode,GLAllowId, ItemCode); 
		}
	hidePleaseWait();		 

}

  
 function craeteGrid(itemDis,matDetaiID,balanceQty,mrnRaised,issueQty,stockBalance,GRNNo,GRNYear,GLCode,GLAllowId, ItemCode)
 {
    var tbl = document.getElementById('mrnMatGrid');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	tbl.rows[lastRow].bgColor="#FFFFFF"; 
	
	var cellSelect = row.insertCell(0);
	cellSelect.id = matDetaiID;
	cellSelect.height=20;
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+matDetaiID+" value=\"checkbox\" /></div>";
	
	if(stockBalance<=0 || balanceQty<=0)
	{
		tbl.rows[lastRow].bgColor="#FFC6C6";		
		cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id="+matDetaiID+" value=\"checkbox\" disabled=\"disabled\"  /></div>";
		//stockBalance=0;
	}

	if(balanceQty<0)
	{
	balanceQty=0;	
	}
	
	var cellItemCode=row.insertCell(1);
	cellItemCode.id=ItemCode;
	cellItemCode.className="normalfntSM";
	cellItemCode.innerHTML=ItemCode;
	
	var cellDis=row.insertCell(2);
	cellDis.id=matDetaiID;
	cellDis.className="normalfntSM";
	cellDis.innerHTML=itemDis;
	
	var Balqty=row.insertCell(3);
	Balqty.className="right";
	Balqty.align="center";
	Balqty.innerHTML=balanceQty;
	
	var mrnRaise=row.insertCell(4);
	mrnRaise.className="right";
	mrnRaise.align="center";
	mrnRaise.innerHTML=mrnRaised;
	
	var Issue=row.insertCell(5);
	Issue.className="right";
	Issue.align="center";
	Issue.innerHTML=issueQty;
	
	var cellstockBalance=row.insertCell(6);
	cellstockBalance.className="right";
	cellstockBalance.align="center";
	cellstockBalance.innerHTML=stockBalance;
	
	var cellGRNNo=row.insertCell(7);
	cellGRNNo.className="right";
	cellGRNNo.align="center";
	cellGRNNo.innerHTML=GRNNo;
	
	var cellGRNYear=row.insertCell(8);
	cellGRNYear.className="right";
	cellGRNYear.align="center";
	cellGRNYear.innerHTML=GRNYear;
	
	/*var cellGLCode=row.insertCell(8);
	cellGLCode.className="right";
	cellGLCode.align="center";
	cellGLCode.id = GLAllowId;
	cellGLCode.innerHTML=GLCode;*/
 }
 
 function createStockpopup()
 {
	 drawPopupAreaLayer(320,260,'frmStockTrans',15);
	 var HTMLText="<table width=\"100%\" border=\"0\">"+
            "<tr>"+
            "<td width=\"100%\" height=\"16\"  class=\"TitleN2white\">"+
			"<table width=\"100%\"border=\"0\" bgcolor=\"#0E4874\">"+
                "<tr>"+
                  "<td width=\"93%\">Stock transaction</td>"+
                  "<td width=\"7%\">"+
		         "<img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" "+
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
     "<td width=\"46%\"><div align=\"right\"><img \"../../images/close.png\" alt=\"close\" "+
	 "onClick=\"closeLayerByName('itemSub');\" width=\"97\" height=\"24\" /></div>"+
	 "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>";
		  
     var frame = document.createElement("div");
     frame.id = "StockTransWindow";
	 document.getElementById('frmStockTrans').innerHTML=HTMLText;
	 document.getElementById('popupLayer').id="itemSub";
	 
	 
 }
 function setStockTransaction(obj)
 {
	 var styleID=document.getElementById('cboStyleID').value;
	 var buyerPO=document.getElementById('cbobuyerpono').value;
	  if(buyerPO.charAt(0)=="#")
	{
		buyerPO=buyerPO.substring(1,buyerPO.length-1);
	}
	 var rowT=obj.parentNode.parentNode.parentNode;	 
	 var matID=obj.id;
	 var color=rowT.cells[3].childNodes[0].nodeValue;
	 var size=rowT.cells[4].childNodes[0].nodeValue;
	 createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStock;
    xmlHttp.open("GET", 'genMRNMiddle.php?RequestType=getStockTrance&styleNo='+styleID+'&buyerPo='+buyerPO+'&MatID='+matID+'&color='+color+'&size='+size , true);
    xmlHttp.send(null);  
	 
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
var tbl		= document.getElementById('mrnMatGrid');
var tblMain = document.getElementById('mainMatGrid');
var radio 	= document.getElementsByName('checkbox');

var mainCat=document.getElementById('cboMainCategory').options[document.getElementById('cboMainCategory').selectedIndex].text;

var rowCount=tbl.rows.count;
for (var ii = 0; ii < radio.length; ii++)
	{
		if (radio[ii].checked)
		{
			var rw=tbl.rows[ii+1];
			// =========================================================
			// Comment on - 11/11/2013 
			// Description - Adding item code to the display list
			// =========================================================
				/*var ItemDetail=rw.cells[1].childNodes[0].nodeValue;
				var balQty=rw.cells[2].childNodes[0].nodeValue; 
				var matID=radio[ii].id;
				var GRNNO=rw.cells[6].childNodes[0].nodeValue;
				var GRNYear=rw.cells[7].childNodes[0].nodeValue;*/
			// =========================================================
			//var GLCode=rw.cells[8].childNodes[0].nodeValue;
			//var GLAllowId=rw.cells[8].id;
			
			var ItemDetail=rw.cells[2].childNodes[0].nodeValue;
			var balQty=rw.cells[3].childNodes[0].nodeValue; 
			var matID=radio[ii].id;
			var GRNNO=rw.cells[7].childNodes[0].nodeValue;
			var GRNYear=rw.cells[8].childNodes[0].nodeValue;
			
			var booCheck =true;
				for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
				{
					var mainMatItemList = tblMain.rows[mainLoop].cells[2].id;
					var grnno			= tblMain.rows[mainLoop].cells[6].childNodes[0].nodeValue;
					var grnyear			= tblMain.rows[mainLoop].cells[7].childNodes[0].nodeValue;
					
					if(mainMatItemList==matID && grnno==GRNNO && grnyear==GRNYear ){
							alert("Sorry !\nItem : "+ ItemDetail + "\nAlready added.");
							booCheck =false;	
					}
				}
			if(booCheck)
				addDataRowToMainGrid(mainCat,ItemDetail,balQty,matID,balQty,GRNNO,GRNYear/*,GLCode,GLAllowId*/);
		}
	}
}

function addDataRowToMainGrid(MainCat,Detail,balQty,matID,Qty,GRNNO,GRNYear/*,GLCode,GLAllowId*/)
{
	var tbl=document.getElementById('mainMatGrid');	
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.height="25";
	row.className="bcgcolor-tblrowWhite";
	var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div align=\"center\"><img src= \"../../images/del.png\" onClick=\"RemoveItem(this);\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	
	var cellMaterial=row.insertCell(1);
	cellMaterial.className="normalfntSM";
	cellMaterial.innerHTML=MainCat;
	
	var cellDetails=row.insertCell(2);
	cellDetails.id=matID;
	cellDetails.className="normalfntSM";
	cellDetails.innerHTML=Detail;
	
	var cellDetails=row.insertCell(3);
	cellDetails.id="";
	cellDetails.className="normalfntMid";	
	cellDetails.innerHTML="<img src= \"../../images/edit.png\" onClick=\"addNote(this.parentNode,this.parentNode.parentNode.rowIndex);\" alt=\"add\" width=\"15\" height=\"15\" />";
	
	var cellBalqty=row.insertCell(4);
	cellBalqty.className="right";
	cellBalqty.align = "right";
	cellBalqty.innerHTML=balQty;
	
	var cellQty=row.insertCell(5);
	cellQty.className="normalfntMid";
	cellQty.innerHTML="<input type=\"text\" size=\"12\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"ValidateQty(this);\" style=\"text-align:right\" value="+Qty+"></input>";
	
	var cellNotes=row.insertCell(6);
	cellNotes.className="normalfntMid";
	cellNotes.innerHTML="<input type=\"text\" size=\"20\" class=\"txtbox\" style=\"text-align:right\"  maxlength=\"50\"></input>";	
	
	var cellGRNNo=row.insertCell(7);
	cellGRNNo.className="right";
	cellGRNNo.align = "right";
	cellGRNNo.innerHTML=GRNNO;
	
	var cellGRNYear=row.insertCell(8);
	cellGRNYear.className="right";
	cellGRNYear.align = "right";
	cellGRNYear.innerHTML=GRNYear;
	
	/*var cellGLCode=row.insertCell(9);
	cellGLCode.className="right";
	cellGLCode.align = "center";
	cellGLCode.id = GLAllowId
	cellGLCode.innerHTML=GLCode;*/
}

function ValidateQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var mrnQty 		= parseFloat(rw.cells[5].childNodes[0].value);	
	var stockBal 	= parseFloat(rw.cells[4].childNodes[0].nodeValue);	
	
	if(mrnQty>stockBal)
	{		
		rw.cells[5].childNodes[0].value=stockBal;
	}	
}

function roundNumber(num, dec) {
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
	var dipCode	= document.getElementById('cbodepartment');	
	var tbl		= document.getElementById('mainMatGrid');
	var No		= document.getElementById('txtReqNo');
	
	if(!ValidateInterface('SaveGenMRN',tbl,dipCode))
		return false;
		
	showPleaseWait();
	if(No.value==""){		
		generateNewMRNNo();
		saveGenMrnHeader();
		saveGenMrnDetails();
	}
	else{
		var no 				= No.value.split("/");
		pub_MRNno 	    = parseInt(no[1]);
		pub_MRNyear 	= parseInt(no[0]);
		saveGenMrnHeader();
		saveGenMrnDetails();
	}
	alert('Saved successfully')
	hidePleaseWait();
}
function generateNewMRNNo()
{
	var url = 'genMRNMiddle.php?RequestType=LoadNo';
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLresponse = htmlobj.responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
	if(XMLresponse == 'TRUE')
	{
		var genMRNno = htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var genMRNyear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_MRNno = parseInt(genMRNno);
		pub_MRNyear = parseInt(genMRNyear);
		document.getElementById('txtReqNo').value = pub_MRNyear+'/'+pub_MRNno;
	}
	else
	{
		alert('Error in generating MRN No');
		return false;
	}
}
function saveGenMrnHeader()
{
	var departementCode	= document.getElementById('cbodepartment').value;
	//var costCenterId    = document.getElementById('cboCostCenter').value;
	var url = 'genMRNMiddle.php?RequestType=SaveHeader&genMRNno='+pub_MRNno+'&genMRNyear='+pub_MRNyear;
		url += '&departementCode='+departementCode;
	htmlobj=$.ajax({url:url,async:false});
			
}

function saveGenMrnDetails()
{
	var tbl				= document.getElementById('mainMatGrid');
	var itemCount=0;
	
	 for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var tt		= tbl.rows.length;
			var ff		= tbl.tBodies.length;
			var rw		= tbl.rows[loop];
			
			var MatID	= tbl.rows[loop].cells[2].id;
			var balQty	= rw.cells[5].childNodes[0].value;
			var notes	= rw.cells[3].id; 
			var assetNo = rw.cells[6].lastChild.value;
			var GRNNo	= rw.cells[7].childNodes[0].nodeValue;
			var GRNYear	= rw.cells[8].childNodes[0].nodeValue;
			//var GLAllowId = rw.cells[9].id;
			
			itemCount++;
			var url = 'genMRNMiddle.php?RequestType=SaveMRNDetails&genMRNno='+pub_MRNno;
				url += '&genMRNyear='+pub_MRNyear+'&balQty='+balQty;
				url += '&notes='+URLEncode(notes);
				url += '&assetNo='+URLEncode(assetNo);
				url += '&MatID='+MatID;
				url += '&GRNNo='+GRNNo;
				url += '&GRNYear='+GRNYear;
				//url += '&GLAllowId='+GLAllowId;
				
			htmlobj=$.ajax({url:url,async:false});	
		}
}

	
function reportPopup()
{
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
}

function LoadMrnacYear()
{
	clearDropDown('cboRptMrnNo');

	document.getElementById('gotoMrnReport').style.visibility = "visible";	
	
	var year=document.getElementById('cboYear').value;
 	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleMrn;
    thirdxmlHttp.open("GET", 'genMRNMiddle.php?RequestType=getMrnAccYear&year='+year, true);
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
window.location = 'genmrnrep.php?mrnNo='+mrnNo+'&year='+year;	
}
else
{
alert("Please select a MRN No to view report.");	
}
}

function clearData()
{
	document.getElementById('cbodepartment').value=0;
	var tbl=document.getElementById('mainMatGrid');
	var rowCount=tbl.rows.length;
	if(rowCount>1)
	{
	for( var loop = 1 ;loop < rowCount ; loop ++ )
	{
	tbl.deleteRow(1);
	}
	}
}

/***** shivanka *****/
var xmlHttp1=[];

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

	function loadItems()
	{
			loadMainCategory();
	}

	function loadMainCategory()
	{
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadMainCategoryRequest;
		xmlHttp1[0].open("GET", 'genMRNMiddle.php?RequestType=loadMainCategory', true);
		xmlHttp1[0].send(null); 
	}
	
	function loadMainCategoryRequest()
	{
	if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			//alert(xmlHttp1[0].responseText);
			clearCombo('cboMainCategory');
			var XMLintID = xmlHttp1[0].responseXML.getElementsByTagName("intID");
			var XMLstrDescription = xmlHttp1[0].responseXML.getElementsByTagName("strDescription");
			
			var opt = document.createElement("option");
			opt.text = "";
			opt.value = "";
			document.getElementById("cboMainCategory").options.add(opt);
			 for ( var loop = 0; loop < XMLintID.length; loop++)
			 {
				var opt = document.createElement("option");
				opt.text =XMLstrDescription[loop].childNodes[0].nodeValue ;
				opt.value = XMLintID[loop].childNodes[0].nodeValue;
				document.getElementById("cboMainCategory").options.add(opt);
			 }
			 loadSubCategory();
		}
	}
	
	function loadSubCategory()
	{	
		clearCombo('cboSubCategory');
		var mainCatId = document.getElementById("cboMainCategory").value;
		var url = 'genMRNMiddle.php?RequestType=loadSubCategory&mainCatId='+mainCatId;
		
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById("cboSubCategory").innerHTML = htmlobj.responseXML.getElementsByTagName("genSubCat")[0].childNodes[0].nodeValue;
		
	}
	
	
	
	function clearCombo(name)
	{
		var index = document.getElementById(name).options.length;
		while(document.getElementById(name).options.length > 0) 
		{
			index --;
			document.getElementById(name).options[index] = null;
		}
	}

function newPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
}

///////////////////////////////////////////////////////////////////////////////////////

function loadMRNForm(strMrnNo,intYear,status)
{
	if ((strMrnNo!=0)||(intYear!=0))
	{
		var url  = "genMRNMiddle.php?RequestType=loadMrnHeader";
			url += "&strMrnNo="+strMrnNo;
			url += "&intYear="+intYear;
		htmlobj=$.ajax({url:url,async:false});
		
		document.getElementById("txtReqNo").value = intYear+'/'+strMrnNo;
		document.getElementById("deliverydateDD").value = htmlobj.responseXML.getElementsByTagName("dtDate")[0].childNodes[0].nodeValue;
		document.getElementById("cbodepartment").value = htmlobj.responseXML.getElementsByTagName("strDepartmentCode")[0].childNodes[0].nodeValue
		document.getElementById("txtrequestedby").value = htmlobj.responseXML.getElementsByTagName("strRequestedBy")[0].childNodes[0].nodeValue
		//document.getElementById("cboCostCenter").value = htmlobj.responseXML.getElementsByTagName("costCenterId")[0].childNodes[0].nodeValue
		
		var url1  = "genMRNMiddle.php?RequestType=loadMrnDetails";
			url1 += "&strMrnNo="+strMrnNo;
			url1 += "&intYear="+intYear;
		htmlobjDet = $.ajax({url:url1,async:false});
		
		var XMLstrMatDetailID = htmlobjDet.responseXML.getElementsByTagName("strMatDetailID");
			var XMLdblQty = htmlobjDet.responseXML.getElementsByTagName("dblQty");
			var XMLdblBalQty = htmlobjDet.responseXML.getElementsByTagName("dblBalQty");
			var XMLstrNotes = htmlobjDet.responseXML.getElementsByTagName("strNotes");
			var XMLstrAssetNo = htmlobjDet.responseXML.getElementsByTagName("strAssetNo");
			var XMLDescription = htmlobjDet.responseXML.getElementsByTagName("Description");
			var XMLMainCat = htmlobjDet.responseXML.getElementsByTagName("MainCat");
			var grnno = htmlobjDet.responseXML.getElementsByTagName("GRNNo");
			var grnyear = htmlobjDet.responseXML.getElementsByTagName("GRNYear");
			var glcode = htmlobjDet.responseXML.getElementsByTagName("GLCode");
			var glallowid = htmlobjDet.responseXML.getElementsByTagName("GLAllowId");
			
			for(var n = 0; n < XMLstrMatDetailID.length ; n++) 
			{
				/*loadDataRowToMainGrid(XMLMainCat[n].childNodes[0].nodeValue,XMLDescription[n].childNodes[0].nodeValue,XMLdblBalQty[n].childNodes[0].nodeValue,XMLdblQty[n].childNodes[0].nodeValue,XMLstrMatDetailID[n].childNodes[0].nodeValue,XMLstrNotes[n].childNodes[0].nodeValue)*/
				loadDataRowToMainGrid(XMLMainCat[n].childNodes[0].nodeValue,XMLDescription[n].childNodes[0].nodeValue,XMLdblBalQty[n].childNodes[0].nodeValue,XMLdblQty[n].childNodes[0].nodeValue,XMLstrMatDetailID[n].childNodes[0].nodeValue,XMLstrNotes[n].childNodes[0].nodeValue,XMLstrAssetNo[n].childNodes[0].nodeValue,grnno[n].childNodes[0].nodeValue,grnyear[n].childNodes[0].nodeValue,glcode[n].childNodes[0].nodeValue,glallowid[n].childNodes[0].nodeValue)
			}
			
			restrictInterface(status)
		
	}		
}



function loadDataRowToMainGrid(MainCat,Detail,balQty,Qty,matID,notes,assetNo,grnno,grnyear,GLCode,GLAllowId)
{
	var tbl=document.getElementById('mainMatGrid');	
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cellDelete = row.insertCell(0);   
	cellDelete.innerHTML = "<div align=\"center\"><img src= \"../../images/del.png\" onClick=\"RemoveItem(this);\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	
	var cellMaterial=row.insertCell(1);
	cellMaterial.className="normalfntSM";
	cellMaterial.innerHTML=MainCat;
	
	var cellDetails=row.insertCell(2);
	cellDetails.id=matID;
	cellDetails.className="normalfntSM";	
	cellDetails.innerHTML=Detail;
	
	var cellDetails=row.insertCell(3);
	cellDetails.id=notes;
	cellDetails.className="normalfntMid";	
	cellDetails.innerHTML="<img src= \"../../images/edit.png\" onClick=\"addNote(this.parentNode,this.parentNode.parentNode.rowIndex);\" alt=\"add\" width=\"15\" height=\"15\" />";
	
	var cellBalqty=row.insertCell(4);
	cellBalqty.className="right";
	cellBalqty.align = "right";
	cellBalqty.innerHTML=balQty;
	
	var cellQty=row.insertCell(5);
	cellQty.className="normalfntMid";
	cellQty.innerHTML="<input type=\"text\" size=\"12\" style=\"text-align:right\" value="+Qty+"></input>";
	
	var cellNotes=row.insertCell(6);
	cellNotes.className="normalfntMid";
	cellNotes.innerHTML="<input type=\"text\" size=\"20\" style=\"text-align:right\" value=\""+assetNo+"\"></input>";
	
	var cellGRNNo=row.insertCell(7);
	cellGRNNo.className="right";
	cellGRNNo.align = "right";
	cellGRNNo.innerHTML=grnno;
	
	var cellGRNYear=row.insertCell(8);
	cellGRNYear.className="right";
	cellGRNYear.align = "right";
	cellGRNYear.innerHTML=grnyear;
	
	var cellGLCode=row.insertCell(9);
	cellGLCode.className="right";
	cellGLCode.align = "center";
	cellGLCode.id = GLAllowId;
	cellGLCode.innerHTML=GLCode;
}
//Start - 21-01-2010 Modified

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

function createRequestItemPopUp()
{
	/*if(document.getElementById("cboCostCenter").value=="")
	{
		showPleaseWait();
		alert("Please select a Cost Center.");
		document.getElementById("cboCostCenter").focus();
		hidePleaseWait();
		return;
	}
	var costCenterId = document.getElementById("cboCostCenter").value;*/
	showBackGround('divBG',0);
	var url = "genmrndetailpopup.php";
		
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(808,382,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
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
	
	
function SelectAll(obj)
{

	var tbl = document.getElementById('mrnMatGrid');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].disabled==false){
			if(obj.checked){
				tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = true;
			}
			else
				tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked= false;
		}
			
	}
	
}

function ViewReport()
{
	var No =document.getElementById("txtReqNo").value;	
	if(No==""){alert("No MRN No to view");return}
	var NoArray = No.split("/");
	
	No =NoArray[1];
	Year =NoArray[0];
	
	newwindow=window.open('genmrnrep.php?mrnNo='+No+ '&year=' +Year ,'frmMrn');
	if (window.focus) {newwindow.focus()}
}
//End - 21-01-2010 Modified 
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function ValidateInterface(type,obj0,obj1)
{
	
	if(type == 'OpenItemPopup')
	{
		if(obj0.value == '')
		{
			alert("Please select 'Main Category'");
			obj0.focus();
			return false;
		}
		else if(obj1.value == '')
		{
			alert("Please select 'Sub Category'");
			obj1.focus();
			return false;
		}
	}
	else if(type == 'SaveGenMRN')
	{
		
		if(obj0.rows.length <=1)
		{
			alert("Sorry!\nCan not proceed, No item found in Mrn.Please click on ADD NEW to add items.");
			return false
		}
		else if(obj1.value == '')
		{
			alert('Please select a department')	
			obj1.focus();
			return false
		}
		for(loop=1;loop<obj0.rows.length;loop++)
		{
			if (obj0.rows[loop].cells[4].childNodes[0].value ==0){
				alert ("Cannot save with 0 qty in Line No : " + [loop] +".");
				obj0.rows[loop].cells[4].childNodes[0].select();
				return false;				
			}	
		}
	}
	return true;
}
function cofirmMRN()
{
	var No =document.getElementById("txtReqNo").value;	
	if(No==""){alert("No MRN No to view");return}
	var NoArray = No.split("/");
	
	No =NoArray[1];
	Year =NoArray[0];
	restrictInterface(1);
	newwindow=window.open('genMRNconfirm.php?mrnNo='+No+ '&year=' +Year ,'frmMrn');
}

function restrictInterface(status)
{
	switch(parseInt(status))
		{
			case 0:
			{
				document.getElementById('butSave').style.display = 'inline';
				document.getElementById('butConfirm').style.display = 'inline';
				break;
			}
			case 1:
			{
				document.getElementById('butSave').style.display = 'none';
				document.getElementById('butConfirm').style.display = 'none';
				break;
			}
		}	
}
function resetGridData()
{
	ClearTable('mainMatGrid');
}
function addNote(obj,rw)
{
	showBackGround('divBG',0);
	var url = "notepopup.php?note="+obj.id+"&rowNo="+rw;	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(426,86,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	document.getElementById('textareaNote').focus();
}
function enterNote(obj,evt,row)
{
	var tbl = document.getElementById('mainMatGrid');
	 var keyCode = evt.keyCode || evt.which; 
	  if (keyCode == 13) 
	  {	  
			tbl.rows[row].cells[3].id = obj.value;
			CloseOSPopUp('popupLayer1');
	  }
}

function listCodes(){
	
	var strItemCode = document.getElementById('txtItemCode').value;
	
	var url1  = "genMRNMiddle.php?RequestType=listGenItems";
		url1 += "&strItemChar="+strItemCode;
		
	htmlobjDet = $.ajax({url:url1,async:false});
	//alert(htmlobjDet.responseText);	
	var XMLItemCode = htmlobjDet.responseXML.getElementsByTagName("ITEMCODE");
	
	//var arrSet = ["Apple", "Ann", "Animal", "Ball", "Bus", "Bannana", "Bun", "Cat", "Candy", "Come", "Dog", "Dumpy"];
	
	var arrayItemCods = new Array();
	
	for(var i=0;i<XMLItemCode.length;i++){
		
		arrayItemCods[i] = XMLItemCode[i].childNodes[0].nodeValue;
	}
	
	$(function(){arrayItemCods;$("#txtItemCode").autocomplete({source:arrayItemCods},{appendTo:"#menu_container"});});
	
	//$(function(){ var arrSet = ["Apple", "Ann", "Animal", "Ball", "Bus", "Bannana", "Bun", "Cat", "Candy", "Come", "Dog", "Dumpy"];$("#txtItemCode").autocomplete({source:arrSet});});	
}