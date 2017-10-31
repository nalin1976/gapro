// JavaScript Document
var pub_POUrl = "/gapro/";
var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var fifthxmlHttp;
var xmlHttp1;
var MatDetaiID;
var CurrentPO=0;
var companyNameA= new Array();
var companyIdA= new Array();
var CompanyIDs= new Array();
var deliveryDate=new Array();
var pub_poNo='';
var pub_year='';
var pub_printWindowNo=0;
var commonpoyear = new Date().getFullYear();
var currentStatus = 1;
 var tindex = 27;
 var pubCurrencyId = 7;// document.getElementById('cbocurrency').value;

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

function createtFifthXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        fifthxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        fifthxmlHttp = new XMLHttpRequest();
    }
}
function creatXmlHttp1() 
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
function LoadBuyerPO()
{
	
    LoadDeliveryDate();
	//LoadSCNo();
	//LoadMainCat(ans);
	
	clearDropDown("cboBuyerPO");
	//var styleID = document.getElementById('cboOrderNo').value;
	var styleID = document.getElementById('cboStyleNo').value;	
	
	var theDropDown = document.getElementById("cboBuyerPO");  
 var numberOfOptions = theDropDown.options.length; 
 for (i=0; i<numberOfOptions; i++) {  
   option[i]=null;//theDropDown.remove(0)  
 }
	if(styleID=="Select One")return;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBuyerPO;
	//====================================================
	// Comment On - 10/14/2015
	// Comment By - Nalin Jayakody
	// Description - Get buyer po numbers from the delivery schedule table instead of stylebuyerpos table
	// ====================================================
    /*xmlHttp.open("GET", 'POMiddle.php?RequestType=BuyerPO&StyleID=' + URLEncode(styleID) , true);*/
	// ====================================================
	
	xmlHttp.open("GET", 'POMiddle.php?RequestType=BuyerPOList&StyleID=' + URLEncode(styleID) , true);
    xmlHttp.send(null);  
}

function HandleBuyerPO()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLPO = xmlHttp.responseXML.getElementsByTagName("PO");
			 var XMLBuyerPoName = xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
			 for ( var loop = 0; loop < XMLPO.length; loop ++)
			 {
				/*var opt = document.createElement("option");
				opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;
				opt.value = XMLPO[loop].childNodes[0].nodeValue;
				document.getElementById("cboBuyerPO").options.add(opt);*/
				
				$("#cboBuyerPO").append("<option value=\""+XMLPO[loop].childNodes[0].nodeValue + "\">" + XMLBuyerPoName[loop].childNodes[0].nodeValue + "</option>");
				$("#cboBuyerPO").multiselect('refresh');
			 }
			// LoadGridData();
		}
	}
}
function LoadMainCat(ans)
{
    //clearDropDown("cboMaterial");
    //clearDropDown("cboBuyerPO");
	//alert(ans)
	var styleID = document.getElementById('cboOrderNo').value;
    var url ='POMiddle.php?RequestType=MainCat&StyleID=' + URLEncode(ans);
    var htmlobj=$.ajax({url:url,async:false});  
	
	var XMLMainCat = htmlobj.responseXML.getElementsByTagName("main");
	
	document.getElementById("cboMaterial").innerHTML = XMLMainCat[0].childNodes[0].nodeValue;
	document.getElementById("cboMaterial").value = XMLMainCat[0].childNodes[0].nodeValue;
	var ans1 = document.getElementById("cboMaterial").value;
	loadSubCategory(ans1);
}

function LoadDeliveryDate()
{
	clearDropDown("cboDiliveryDate");
	var styleID = document.getElementById('cboOrderNo').value;
	if(styleID=="Select One")return;
    createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleDeliveryDate;
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=DiliveryDate&StyleID=' + URLEncode(styleID) , true);
    altxmlHttp.send(null);  
}

function HandleDeliveryDate()


{

    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
	
			 var DateD= altxmlHttp.responseXML.getElementsByTagName("Date");
			 var DateF=altxmlHttp.responseXML.getElementsByTagName("DateFormat");
			 
			/*if(DateD.length<=0)
			{
				alert("This Style hasn't valid delivery date.");
				return;
			}*/
			
			 for ( var loop = 0; loop < DateD.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = DateD[loop].childNodes[0].nodeValue;
				opt.value = DateF[loop].childNodes[0].nodeValue;
				document.getElementById("cboDiliveryDate").options.add(opt);
				var opt = document.createElement("option");
			 }
			 
		}
	}
}
/*function LoadSCNo()
{
	var styleID = document.getElementById('cboStyleNo').value;
	document.getElementById("cboScNo").value = document.getElementById('cboStyleNo').value;
}*/

/*function LoadStyleNo()
{

    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleStyleNo;
    thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=StyleNo', true);
    thirdxmlHttp.send(null);  
}

function HandleStyleNo()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			var XMLID = thirdxmlHttp.responseXML.getElementsByTagName("StyleNo");
			 document.getElementById("cboStyleNo").innerHTML = XMLID[0].childNodes[0].nodeValue;
			 
		}
	}
}*/

function LoadSCNOList()
{

	
	var styleName = document.getElementById('cboStyleNo').value; 
	var url = 'POMiddle.php?RequestType=SCList&styleName='+URLEncode(styleName);
	var htmlobj=$.ajax({url:url,async:false});
	var XMLID = htmlobj.responseXML.getElementsByTagName("SCNo");
	//alert(XMLID);
			 document.getElementById("cboScNo").innerHTML = XMLID[0].childNodes[0].nodeValue;
}
function LoadstyleNo()
{

	//var ans= 0;
	var cboScNo = document.getElementById('cboScNo').value; 
	var url = 'POMiddle.php?RequestType=StyleList&cboScNo='+URLEncode(cboScNo);
	var htmlobj=$.ajax({url:url,async:false});
	var XMLID = htmlobj.responseXML.getElementsByTagName("StyleNo");
	//alert(XMLID);
			 document.getElementById("cboStyleNo").innerHTML = XMLID[0].childNodes[0].nodeValue;
			 document.getElementById("cboStyleNo").value = XMLID[0].childNodes[0].nodeValue;
			 var ans = document.getElementById("cboStyleNo").value;
			 LoadMainCat(ans);
			 
}

/*function loadSuplrs()
{

	
	var cbocurrency = document.getElementById('cbocurrency').value; 
	var url = 'POMiddle.php?RequestType=SupList&cbocurrency='+URLEncode(cbocurrency);
	var htmlobj=$.ajax({url:url,async:false});
	var XMLID = htmlobj.responseXML.getElementsByTagName("SuP");
	//alert(XMLID);
			 document.getElementById("cboSupplier").innerHTML = XMLID[0].childNodes[0].nodeValue;
}
*/

/*function HandleSCNOList()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLID = xmlHttp.responseXML.getElementsByTagName("SCNo");
			 document.getElementById("cboScNo").innerHTML = XMLID[0].childNodes[0].nodeValue;	
			 
		}
	}
}*/


function clearDropDown(controName) {  
 
 var theDropDown = document.getElementById(controName)  
 if(theDropDown != null){
	 var numberOfOptions = theDropDown.options.length  
		 for (i=0; i<numberOfOptions; i++) {  
		   theDropDown.remove(0)  
		 }
 }
}
 
 //start 2010-09-23 load supplier wise item to material details table ----------------------------------------
 function LoadSupWiseItemtoMatGrid()
 {
	 var postate=0;
   RemoveRowFromTable();
   document.getElementsByName('chkAll')[0].checked = false;
   if(document.getElementById("cboOrderNo").value == 'Select One')
	{
		alert('Please select \"Order No\"');
		document.getElementById("cboOrderNo").focus();
		return;
	}
	else
	{
	   if(document.getElementById('cboDiliveryDate').value == "" && document.getElementById('maincategory').value != 4)
	   {
			alert("There is no valid delivery schedule available for this Style. \nPlease use BOM to reschedule your style delivery.");   
			return false;
	   }
	   if (document.getElementsByName('chkAllPO')[0].checked)
		{
			 postate=1;
		}
		
		
	   
		var styleID = document.getElementById('cboOrderNo').value;
		var buyerPO=document.getElementById('cboBuyerPO').value;
		var diliveryDate=document.getElementById('cboDiliveryDate').value;
	
		var sCNo=document.getElementById('cboScNo').value;
		var material= document.getElementById('cboMaterial').value;
		var subCat = document.getElementById('cboSubCategory').value;
		var supID = document.getElementById('cboSupplier').value;
		
		var url = 'POMiddle.php?RequestType=GetItemDis';
		url += '&StyleID='+styleID;
		url += '&buyerPO=' +URLEncode(buyerPO);
		url += '&diliveryDate='+diliveryDate;
		url += '&sCNo='+sCNo;
		url += '&mainCatID='+material;
		url += '&supID='+supID;
		url += '&postate='+postate;
		url += '&subCat='+subCat;
												
			var htmlobj=$.ajax({url:url,async:false});
			var ItemID =htmlobj.responseXML.getElementsByTagName("ItemID");
			 if(ItemID.length>0)
			 {
			
				 var Item=htmlobj.responseXML.getElementsByTagName("ItemName");
				//start 2010-09-10 check common stock leftover & Bulk availability
				var ItemLeftOverQty = htmlobj.responseXML.getElementsByTagName("ItemLeftOverQty");
				var ItemBulkQty     = htmlobj.responseXML.getElementsByTagName("ItemBulkQty");
				var XMLcolor = htmlobj.responseXML.getElementsByTagName("Color");
				var XMLsize = htmlobj.responseXML.getElementsByTagName("Size");
				var XMLpendingQty = htmlobj.responseXML.getElementsByTagName("pendingQty");
				var XMLunitprice = htmlobj.responseXML.getElementsByTagName("unitprice");
				var XMLfreight = htmlobj.responseXML.getElementsByTagName("dblfreight");
				var XMLtotQty = htmlobj.responseXML.getElementsByTagName("totQty");
				var XMLLiabilityQty = htmlobj.responseXML.getElementsByTagName("liabilityQty");
				//end----------------------------------------------------
				 for ( var loop = 0; loop < Item.length; loop ++)
				 {
					var itemSubID=ItemID[loop].childNodes[0].nodeValue;
					var itemSubDetail=Item[loop].childNodes[0].nodeValue;
					var lQty   = ItemLeftOverQty[loop].childNodes[0].nodeValue;
					var BQty   = ItemBulkQty[loop].childNodes[0].nodeValue;
					var color  =  XMLcolor[loop].childNodes[0].nodeValue;
					var size   =  XMLsize[loop].childNodes[0].nodeValue;
					var qty    =  XMLpendingQty[loop].childNodes[0].nodeValue;
					var unitprice = XMLunitprice[loop].childNodes[0].nodeValue;
					var freight = XMLfreight[loop].childNodes[0].nodeValue;
					var totQty = XMLtotQty[loop].childNodes[0].nodeValue;
					var liabilityQty = XMLLiabilityQty[loop].childNodes[0].nodeValue;
					createGrid(itemSubID,itemSubDetail,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty);
				 }
			 }
			 else
			 {
			     alert("No Item available for the selected supplier, please try again with another.");	 
			 }
		
	}
 }
 //end -------------------------------------------------------------------------------------------------------
 
 function LoadGridData()
{

   var postate=0;
   RemoveRowFromTable();
   document.getElementsByName('chkAll')[0].checked = false;
   if(document.getElementById("cboOrderNo").value == '' && document.getElementById("butOk").disabled == true)
	{
		alert('Please select \"Order No\"');
		document.getElementById("cboOrderNo").focus();
		return;
	}
	else
	{
	   if(document.getElementById('txtDate').value == "" && document.getElementById('maincategory').value != 4)
	   {
			alert("There is no valid delivery schedule available for this Style. \nPlease use BOM to reschedule your style delivery.");   
			return false;
	   }
		var material=document.getElementById('cboMaterial').value;
		var subCat  = document.getElementById('cboSubCategory').value;
		var items   =document.getElementById('cboItems').value;
		var tblTable = document.getElementById('tblStyleDetails');
	     for(var n = 1; n < tblTable.rows.length; n++)
	      {
		   if(tblTable.rows[n].cells[0].lastChild.checked == true)
		    {
			  var StyleID = tblTable.rows[n].cells[1].id;
			
			  var path = "POMiddle.php?RequestType=GetItemDis1";
	   		    path += "&StyleID="+StyleID+'&material='+material+'&subCat='+subCat+'&items='+items+'&postate='+postate;

			  htmlobj=$.ajax({url:path,async:false});
			  var ItemID =htmlobj.responseXML.getElementsByTagName("ItemID");
			  if(ItemID.length>0)
			   {
				 var style=htmlobj.responseXML.getElementsByTagName("StyleId");
				 var Item=htmlobj.responseXML.getElementsByTagName("ItemName");
				//start 2010-09-10 check common stock leftover & Bulk availability
				var ItemLeftOverQty = htmlobj.responseXML.getElementsByTagName("ItemLeftOverQty");
				var ItemBulkQty     = htmlobj.responseXML.getElementsByTagName("ItemBulkQty");
				var XMLcolor = htmlobj.responseXML.getElementsByTagName("Color");
				var XMLsize = htmlobj.responseXML.getElementsByTagName("Size");
				var XMLpendingQty = htmlobj.responseXML.getElementsByTagName("pendingQty");
				var XMLunitprice = htmlobj.responseXML.getElementsByTagName("unitprice");
				var XMLfreight = htmlobj.responseXML.getElementsByTagName("dblfreight");
				var XMLQty = htmlobj.responseXML.getElementsByTagName("totQty");
				var XMLLiabilityQty = htmlobj.responseXML.getElementsByTagName("liabilityQty");
				//end----------------------------------------------------
				 for ( var loop = 0; loop < Item.length; loop ++)
				  {
					var itemSubID=ItemID[loop].childNodes[0].nodeValue;
					var styleId=style[loop].childNodes[0].nodeValue;
					var itemSubDetail=Item[loop].childNodes[0].nodeValue;
					var lQty   = ItemLeftOverQty[loop].childNodes[0].nodeValue;
					var BQty   = ItemBulkQty[loop].childNodes[0].nodeValue;
					var color  =  XMLcolor[loop].childNodes[0].nodeValue;
					var size   =  XMLsize[loop].childNodes[0].nodeValue;
					var qty    =  XMLpendingQty[loop].childNodes[0].nodeValue;
					var unitprice = XMLunitprice[loop].childNodes[0].nodeValue;
					var freight = XMLfreight[loop].childNodes[0].nodeValue;
					var totQty = XMLQty[loop].childNodes[0].nodeValue;
					var liabilityQty = XMLLiabilityQty[loop].childNodes[0].nodeValue;
					createGrid(itemSubID,styleId,itemSubDetail,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty);
				 }
			  }
		   }
	    }
	}
}
function createGrid(itemSubID,styleId,itemDiscription,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty)
{ 
	var styleID=document.getElementById('cboStyleNo').value; 
	var tbl = document.getElementById('tblMatrialGrid');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	//alert(lQty);
	var style='';
	var postate = document.getElementById("cboPoItems").value;
	if((cantPurchaseStockAvailable &&(BQty!=0 || lQty!=0)) || qty==0)
	{
		style = 'disabled';
	}
	row.className = "bcgcolor-tblrowWhite";
	if(lQty != 0 || BQty !=0)
	{
		row.className = 'txtbox bcgcolor-InvoiceCostTrim';
		}
	
	if(qty ==0)
		row.className = 'txtbox bcgcolor-InvoiceCostFabric';
		
	var cellSelect = row.insertCell(0);   
	cellSelect.className = "normalfntMid";
	cellSelect.id = styleId;
	cellSelect.innerHTML = "<div align=\"center\" ><input type=\"checkbox\" name=\"checkbox\" id="+styleId+" value=\"checkbox\" "+style+" tabindex=\""+23+"\"/></div>";
	
	var cellDis = row.insertCell(1);  
	cellDis.id=itemSubID; 
	cellDis.height = 18;
	cellDis.className = "normalfnt";
	cellDis.innerHTML =  itemDiscription;//"<div align=\"center\" class=\"normalfnt\">"+itemDiscription+"</div>"; 	
	
	var cellColor = row.insertCell(2); 
	cellColor.className = "normalfnt";
	cellColor.id = unitprice;
	cellColor.innerHTML =  color;
	
	var cellSize = row.insertCell(3);
	cellSize.className = "normalfnt";
	cellSize.id = freight
	cellSize.innerHTML =  size;
	
	var cellSize = row.insertCell(4);
	cellSize.className = "normalfntRite";
	cellSize.innerHTML =  totQty;
	
	var cellQty = row.insertCell(5);
	cellQty.className = "normalfntRB";
	//cellQty.innerHTML =  qty;
	cellQty.innerHTML =  "<a href=\"#\" onclick=\"openItemMvPopup(this);\">"+qty+"</a>";
	
	var cellBulk = row.insertCell(6);
	cellBulk.id = 'B';
	if(BQty>0)
	{
		cellBulk.className = "normalfntRB";
		cellBulk.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+BQty+"</a>";
	}
	else
	{
		cellBulk.className = "normalfntRite";
		cellBulk.innerHTML =  BQty;
	}
	
	
	var cellLeft = row.insertCell(7);
	cellLeft.id = 'L';
	if(lQty>0)
	{
		cellLeft.className = "normalfntRB";
		cellLeft.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+lQty+"</a>";
	}
	else
	{
		cellLeft.className = "normalfntRite";
		cellLeft.innerHTML =  lQty;
	}
	
	var cell = row.insertCell(8);
	cell.id="LB";
	if(liabilityQty>0)
	{
		cell.className = "normalfntRB";
		cell.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+liabilityQty+"</a>";
	}
	else
	{
		cell.className = "normalfntRite";
		cell.innerHTML =  liabilityQty;
	}
		
	var cell = row.insertCell(9);
	cell.className = "normalfntMid";
	cell.innerHTML =  "<img alt=\"add\" src=\"images/aad.png\" onclick=\" LoadAllocation(this,'frmPopItem');\" >";
}  
function closeWindow()
{
	if(alloType == 'frmPopItem')
	{
		new1();
		}
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
function RemoveRowFromTable()
{
	var tbl = document.getElementById('tblMatrialGrid');
	var rowCount=tbl.rows.length;
 	if(rowCount<=2)return;
	for(var rowC=2; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(2);  
	
	}
	
	//var tr=td.childNode;
	//tr.parentNode.removeChild(tr);
}

function createGrid1(itemSubID,styleId,itemDiscription,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty,buyerpono)
{ 
	var styleID=document.getElementById('cboStyleNo').value; 
	var tbl = document.getElementById('tblMatrialGrid');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	//alert(lQty);
	var style='';
	var postate = document.getElementById("cboPoItems").value;
	if((cantPurchaseStockAvailable &&(BQty!=0 || lQty!=0)) || qty==0)
	{
		style = 'disabled';
	}
	row.className = "bcgcolor-tblrowWhite";
	if(lQty != 0 || BQty !=0)
	{
		row.className = 'txtbox bcgcolor-InvoiceCostTrim';
		}
	
	if(qty ==0)
		row.className = 'txtbox bcgcolor-InvoiceCostFabric';
		
	var cellSelect = row.insertCell(0);   
	cellSelect.className = "normalfntMid";
	cellSelect.id = styleId;
	cellSelect.innerHTML = "<div align=\"center\" ><input type=\"checkbox\" name=\"checkbox\" id="+styleId+" value=\"checkbox\" "+style+" tabindex=\""+23+"\"/></div>";
	
	var cellDis = row.insertCell(1);  
	cellDis.id=itemSubID; 
	cellDis.height = 18;
	cellDis.className = "normalfnt";
	cellDis.innerHTML =  itemDiscription;//"<div align=\"center\" class=\"normalfnt\">"+itemDiscription+"</div>"; 	
	
	var cellColor = row.insertCell(2); 
	cellColor.className = "normalfnt";
	cellColor.id = unitprice;
	cellColor.innerHTML =  color;
	
	var cellSize = row.insertCell(3);
	cellSize.className = "normalfnt";
	cellSize.id = freight
	cellSize.innerHTML =  size;
	
	var cellSize = row.insertCell(4);
	cellSize.className = "normalfntRite";
	cellSize.innerHTML =  buyerpono;
	
	var cellSize = row.insertCell(5);
	cellSize.className = "normalfntRite";
	cellSize.innerHTML =  totQty;
	
	var cellQty = row.insertCell(6);
	cellQty.className = "normalfntRB";
	//cellQty.innerHTML =  qty;
	cellQty.innerHTML =  "<a href=\"#\" onclick=\"openItemMvPopup(this);\">"+qty+"</a>";
	
	var cellBulk = row.insertCell(7);
	cellBulk.id = 'B';
	if(BQty>0)
	{
		cellBulk.className = "normalfntRB";
		cellBulk.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+BQty+"</a>";
	}
	else
	{
		cellBulk.className = "normalfntRite";
		cellBulk.innerHTML =  BQty;
	}
	
	
	var cellLeft = row.insertCell(8);
	cellLeft.id = 'L';
	if(lQty>0)
	{
		cellLeft.className = "normalfntRB";
		cellLeft.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+lQty+"</a>";
	}
	else
	{
		cellLeft.className = "normalfntRite";
		cellLeft.innerHTML =  lQty;
	}
	
	var cell = row.insertCell(9);
	cell.id="LB";
	if(liabilityQty>0)
	{
		cell.className = "normalfntRB";
		cell.innerHTML =  "<a href=\"#\" onclick=\"openStockPopup(this);\">"+liabilityQty+"</a>";
	}
	else
	{
		cell.className = "normalfntRite";
		cell.innerHTML =  liabilityQty;
	}
		
	var cell = row.insertCell(10);
	cell.className = "normalfntMid";
	cell.innerHTML =  "<img alt=\"add\" src=\"images/aad.png\" onclick=\"LoadAllocation(this,'frmPopItem');\" >";
}  

function RemoveRowFromTable()
{
	var tbl = document.getElementById('tblMatrialGrid');
	var rowCount=tbl.rows.length;
 	if(rowCount<=2)return;
	for(var rowC=2; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(2);  
	
	}
	
	//var tr=td.childNode;
	//tr.parentNode.removeChild(tr);
}


 function clearGrid()
 {
 var tbl = document.getElementById('tblMatrialGrid');
 var rowCount=tbl.rows.length;
 if(rowCount<=2)return;
 for(var rowC = rowCount; rowC < 3; rowC--)
 {
 tbl.deleteCell(0);
  tbl.deleteCell(1);
 
 }
 
 }
 
 
 function showPopUp()
 {
	 var dil=document.getElementById('deliverydateDD').value;
	 
	if(dil=="")
	{
	alert("Please select a delivery date before add items.");
	document.getElementById('deliverydateDD').focus();
	return;
	}
	var supID = document.getElementById('cboSupplier').value;
	
	if(supID == '0' || supID == "")
	{
		alert("Please select a Supplier before add items.");
		document.getElementById('cboSupplier').focus();
		return;
	}

showBackGround('divBG',0);
	var url = "poPopupItem.php?";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(722,600,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	
	 incHeader('js/dropdown/jquery-1.4.4.min.js');
	 incHeader('js/dropdown/jquery-ui.min.js');
	 incHeader('js/dropdown/jquery.multiselect.js');
	 incHeader('js/dropdown/dropselect.js');
	
	 LoadStyleNo();
	 LoadSCNOList();
	 //LoadOrderNo();
	 LoadMainCat();
	 loadSubCategory();
	 loadItems();
	 LoadBuyerPO();
	 inc('javascript/buttonkeypress.js');
	  
	 //document.getElementById('butAddNew').focus();
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
 function closePopup()
 {
	  closeWindow();
	/* var tbl =  document.getElementById('PoMatMain');
	 var rw=tbl.rows[1];
			var qtyID = rw.cells[9].id;
	document.getElementById('divcons').focus();
	*/
	// document.getElementById('butSave').focus();
	/* for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			//var tt=tbl.rows.length;
			//var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];
			var qtyID = rw.cells[1].id;
		}*/
		
	 }
 function disableBuyerPO()
 {
	 if (document.getElementsByName('chkAllPO')[0].checked)
	{
	 document.getElementById('cboDiliveryDate').disabled=true;
	 document.getElementById('cboBuyerPO').disabled=true;
	}
	else
	{
		 document.getElementById('cboDiliveryDate').disabled=false;
	 document.getElementById('cboBuyerPO').disabled=false;
	}
	 
	 
 }
 function enableDropDown()
 {
	  document.getElementById('cboDiliveryDate').disabled=false;
	 document.getElementById('cboBuyerPO').disabled=false;
	 document.getElementsByName('chkAllPO')[0].checked=false;
	
	 
 }
 function addDataToMain()
 {

	var radio = document.getElementsByName('checkbox');
	//var styleID=document.getElementById('orderno').value;
	var buyerPO=document.getElementById('cboBuyerPO').value;
	var deliveryDate=document.getElementById('txtDate').value;
	var deliveryDate1=document.getElementById('txtDate1').value;
	var material=document.getElementById('cboMaterial').value;
	var tbl = document.getElementById('tblMatrialGrid');
	var allPo=0;
	var tblTbl = document.getElementById('tblStyleDetails');
	
	//start 2010-11-03 add color/size wise items to main table 
/*	if(buyerPO.charAt(0)=="#")
	{
		buyerPO=buyerPO.substring(1,buyerPO.length-1);
	}*/
	/*var itemIDs="";
	for (var ii = 0; ii < radio.length; ii++)
	{
		if (radio[ii].checked)
		{
			itemIDs += radio[ii].id + ",";
		}
		
	}

		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandlePOItems1;
	if (document.getElementsByName('chkAllPO')[0].checked)
	{
		 allPo=1;
	}

		
		xmlHttp.open("GET", 'POMiddle.php?RequestType=POMainItems&itemIDs='+itemIDs+'&styleID='+URLEncode(styleID)+'&buyerPO='+URLEncode(buyerPO)+'&poState='+allPo+'&dilDate='+deliveryDate + '&material=' + material, true);
		
	
	xmlHttp.send(null);
	RemoveRowFromTable();*/
	/*for(n=1;n<tblTbl.rows.length;n++)
	{
		if(tblTbl.rows[n].cells[0].childNodes[0].checked== true)
		{
			var styleID = tblTbl.rows[n].cells[1].id;
			alert(styleID);
		}
	}*/
	
	//======================================================
	// Comment On - 12/04/2015
	// Comment For - Remove check all buyer po option 
	// Comment By - Nalin Jayakody
	//======================================================
	/*if (document.getElementsByName('chkAllPO')[0].checked)
	{
		 allPo=1;
	}*/
	//======================================================
	allPo					= 0;
	var tblRows				= tbl.rows.length;
	var tblMainRw			= document.getElementById('PoMatMain').rows.length;
	for(var loop =2; loop< tblRows ; loop++)
	{//alert(tblRows);
			var chk = tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked;
			if(chk == true)
			{
				var styleID = tbl.rows[loop].cells[0].id;
				var matDetailID = tbl.rows[loop].cells[1].id;
				var color = tbl.rows[loop].cells[2].childNodes[0].nodeValue;
				var size = tbl.rows[loop].cells[3].childNodes[0].nodeValue;
				//=====================================
				// Get buyer po number from the table
				// Add On - 2015/10/29
				// Add By - Nalin Jayakody
				//=====================================
				var buyerPO = tbl.rows[loop].cells[4].childNodes[0].nodeValue;
				//=====================================
				//alert(buyerPO);
				var url = 'POMiddle.php?RequestType=POMainItems1';
					url += '&matDetailID='+matDetailID;
					url += '&color='+URLEncode(color);
					url += '&size='+URLEncode(size);
					url += '&poState='+allPo;
					url += '&dilDate='+deliveryDate;
					url += '&styleID='+URLEncode(styleID);
					url += '&buyerPO='+URLEncode(buyerPO);
					url += '&material='+URLEncode(material);
					//alert(url);
					var htmlobj=$.ajax({url:url,async:false});
					//alert(htmlobj.responseText);
					var StyleID				= htmlobj.responseXML.getElementsByTagName("StyleID")[0].childNodes[0].nodeValue;
					//alert(StyleID);
				var StyleName			= htmlobj.responseXML.getElementsByTagName("StyleName")[0].childNodes[0].nodeValue;
				var BuyerPO				= htmlobj.responseXML.getElementsByTagName("BuyerPO")[0].childNodes[0].nodeValue;
				var BuyerPoName			= htmlobj.responseXML.getElementsByTagName("BuyerPoName")[0].childNodes[0].nodeValue;
				var Color				= htmlobj.responseXML.getElementsByTagName("Color")[0].childNodes[0].nodeValue;
				var Size				= htmlobj.responseXML.getElementsByTagName("Size")[0].childNodes[0].nodeValue;
				var qty					= htmlobj.responseXML.getElementsByTagName("Qty")[0].childNodes[0].nodeValue;
				var ItemName			= htmlobj.responseXML.getElementsByTagName("ItemName")[0].childNodes[0].nodeValue;
				var MainCatName			= htmlobj.responseXML.getElementsByTagName("MainCatName")[0].childNodes[0].nodeValue;
				var Unit				= htmlobj.responseXML.getElementsByTagName("Unit")[0].childNodes[0].nodeValue;
				var UnitPrice			= htmlobj.responseXML.getElementsByTagName("UnitPrice")[0].childNodes[0].nodeValue;
				var dblfreightUnitPrice	= htmlobj.responseXML.getElementsByTagName("dblfreightUnitPrice")[0].childNodes[0].nodeValue;
				var matID				= htmlobj.responseXML.getElementsByTagName("MatDetailID")[0].childNodes[0].nodeValue;
				var FreightBalQty		= htmlobj.responseXML.getElementsByTagName("dblFreightBalQty")[0].childNodes[0].nodeValue;
				//alert(FreightBalQty);
				var POtotalQty			= htmlobj.responseXML.getElementsByTagName("POTotalQty")[0].childNodes[0].nodeValue;

				var ItemQty				= htmlobj.responseXML.getElementsByTagName("ItemQty")[0].childNodes[0].nodeValue;				
				
			var RemarksNew="";
			var intFreight = document.getElementById("cboPoItems").value;
			//alert(intFreight);
			//alert(BuyerPO);
			
			//if (qty > 0 && intFreight!=1) 
			createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,qty,UnitPrice,UnitPrice,UnitPrice,matID,RemarksNew,POtotalQty,ItemQty,0,0,null,qty,StyleName,BuyerPoName)
			
			 /*if (FreightBalQty > 0 && dblfreightUnitPrice> 0 && intFreight!=0) 
			createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,FreightBalQty,dblfreightUnitPrice,dblfreightUnitPrice,UnitPrice,matID,RemarksNew,POtotalQty,ItemQty,1,0,null,FreightBalQty,StyleName,BuyerPoName)*/
			 
			 onchangePocalculate();
			 
			 
			}
			
			
			// convertLastRowRates(tblRows);
			  //tindex++;
	}
 
	
	//convertLastRowRates(tblMainRw);
	//end 2010-11-03 --------------------------------------------------------------------------------------
	
 }
 
 function isItemAvailable(styleID, ItemId,bpo, color,size,type)
 {

	 var tbl = document.getElementById('PoMatMain');

	 for (var a = 1; a < tbl.rows.length ; a++)
	 {
		 
		 var tblStyle = tbl.rows[a].cells[1].id;
		 var tblMaterial = tbl.rows[a].cells[4].id;
		 var tblColor = tbl.rows[a].cells[6].childNodes[0].nodeValue;
		 var tblSize = tbl.rows[a].cells[8].childNodes[0].nodeValue;
		 var tblBPO = tbl.rows[a].cells[2].id;
		 var tbltype = tbl.rows[a].id ;
		
		 if (tblStyle == styleID && tblMaterial == ItemId && tblBPO == bpo && tblColor == color && tblSize== size && tbltype==type)
		{	
			return true; 
		}
		 
	 }
	  return false;
 }
 
 function HandlePOItems1()
 {
  if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
				var tbl=document.getElementById('PoMatMain');
			 	var StyleIDA =xmlHttp.responseXML.getElementsByTagName("StyleID");
				var StyleNameA =xmlHttp.responseXML.getElementsByTagName("StyleName");
				if(StyleIDA.length==0)
				{
				alert("Sorry, There is no balance Qty available with the selected item.");
				return;
				}
			 	var BuyerPOA 			 = xmlHttp.responseXML.getElementsByTagName("BuyerPO");
				var BuyerPoNameA 		 = xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
			  	var ColorA 				 = xmlHttp.responseXML.getElementsByTagName("Color");
			  	var SizeA 				 = xmlHttp.responseXML.getElementsByTagName("Size");
				var qtyA 				 = xmlHttp.responseXML.getElementsByTagName("Qty");
				var ItemNameA 			 = xmlHttp.responseXML.getElementsByTagName("ItemName");
				var MainCatNameA 		 = xmlHttp.responseXML.getElementsByTagName("MainCatName");
				var UnitA 				 = xmlHttp.responseXML.getElementsByTagName("Unit");
				var UnitPriceA 			 = xmlHttp.responseXML.getElementsByTagName("UnitPrice");
				var dblfreightUnitPriceA = xmlHttp.responseXML.getElementsByTagName("dblfreightUnitPrice");
				var MatDetaiID			 = xmlHttp.responseXML.getElementsByTagName("MatDetailID");
				//add by roshan 2009-06-03
				var FreightBalQtyA		= xmlHttp.responseXML.getElementsByTagName("dblFreightBalQty");
				var POtotalQtyA			= xmlHttp.responseXML.getElementsByTagName("POTotalQty");
				var ItemQtyA			= xmlHttp.responseXML.getElementsByTagName("ItemQty");
				var tblRows				= tbl.rows.length;
				
			 for ( var loop = 0; loop < StyleIDA.length; loop ++)
			 {
			 	var StyleID				= StyleIDA[loop].childNodes[0].nodeValue;
				var StyleName			= StyleNameA[loop].childNodes[0].nodeValue;
				var BuyerPO				= BuyerPOA[loop].childNodes[0].nodeValue;
				var BuyerPoName			= BuyerPoNameA[loop].childNodes[0].nodeValue;
				var Color				= ColorA[loop].childNodes[0].nodeValue;
				var Size				= SizeA[loop].childNodes[0].nodeValue;
				var qty					= qtyA[loop].childNodes[0].nodeValue;
				var ItemName			= ItemNameA[loop].childNodes[0].nodeValue;
				var MainCatName			= MainCatNameA[loop].childNodes[0].nodeValue;
				var Unit				= UnitA[loop].childNodes[0].nodeValue;
				var UnitPrice			= UnitPriceA[loop].childNodes[0].nodeValue;
				var dblfreightUnitPrice	= dblfreightUnitPriceA[loop].childNodes[0].nodeValue;
				var matID				= MatDetaiID[loop].childNodes[0].nodeValue;
				//add by roshan 2009-06-03
				var FreightBalQty		= FreightBalQtyA[loop].childNodes[0].nodeValue;
				var POtotalQty			= POtotalQtyA[loop].childNodes[0].nodeValue;
				var ItemQty				= ItemQtyA[loop].childNodes[0].nodeValue;				
				
			var RemarksNew="";
			var intFreight = document.getElementById("poitamadding").value;
			
			if (qty > 0 && intFreight!=1) 
			createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,qty,UnitPrice,UnitPrice,UnitPrice,matID,RemarksNew,POtotalQty,ItemQty,0,0,null,qty,StyleName,BuyerPoName)
			
			 if (FreightBalQty > 0 && dblfreightUnitPrice> 0 && intFreight!=2) 
			createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,FreightBalQty,dblfreightUnitPrice,dblfreightUnitPrice,UnitPrice,matID,RemarksNew,POtotalQty,ItemQty,1,0,null,FreightBalQty,StyleName,BuyerPoName)
			 
			 onchangePocalculate();
			 
			 }
			 convertLastRowRates(tblRows);
			 document.getElementById("butSave").tabIndex = tindex;
			 tindex++;
			 document.getElementById("butcpoyPO").tabIndex = tindex;
			  //tindex++;
			 
		}
	}
	 
}
 //----------------
  function convertLastRowRates(tblRows)
 {
	var curType=document.getElementById("cbocurrency").value;
	
	var path = "POMiddle.php?RequestType=getExchangeRate";
	   		    path += "&curType="+URLEncode(curType);

			htmlobj=$.ajax({url:path,async:false});
			var Rate=htmlobj.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;
			var tbl=document.getElementById('PoMatMain');
		for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
  		{   //alert(tbl.rows.length);
			var tt=tbl.rows.length;
			var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];
			var maxRateUSD= rw.cells[12].childNodes[0].nodeValue;
			//alert(maxRateUSD);
			var maxRate= maxRateUSD*Rate;
			//maxRate=wacky_round(maxRate,4);
			maxRate=wacky_round(maxRate,5);
			rw.cells[13].childNodes[0].nodeValue=maxRate;
			rw.cells[11].lastChild.value=maxRate;
	
		}
		 onchangePocalculate();
		//createMainGridRow();
			//alert(htmlobj.responseText);
	/*if(curType==0)
	curType="USD"; */
	/*createAltXMLHttpRequest();
	altxmlHttp.index=tblRows;
	altxmlHttp.onreadystatechange = convertLastRowRatesRequest;
	altxmlHttp.open("GET", 'POMiddle.php?RequestType=getExchangeRate&curType='+URLEncode(curType), true);
	altxmlHttp.send(null); */ 
	 
 }
 function wacky_round(number, places) {
    var multiplier = Math.pow(10, places+2); // get two extra digits
    var fixed = Math.floor(number*multiplier); // convert to integer
    fixed += 44; // round down on anything less than x.xxx56
    fixed = Math.floor(fixed/100); // chop off last 2 digits
    return fixed/Math.pow(10, places);
}
/* function convertLastRowRatesRequest()
 {
	
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
		var tblRows=altxmlHttp.index;	
		var Rate=altxmlHttp.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
		var tbl=document.getElementById('PoMatMain');
		for ( var loop = tblRows ;loop < tbl.rows.length ; loop ++ )
  		{   //alert(tbl.rows.length);
			var tt=tbl.rows.length;
			var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];
			var maxRateUSD= rw.cells[12].childNodes[0].nodeValue;
			//alert(maxRateUSD);
			var maxRate= maxRateUSD*Rate;
			maxRate=roundNumber(maxRate,4);
			rw.cells[13].childNodes[0].nodeValue=maxRate;
			rw.cells[11].lastChild.value=maxRate;
	
		}
		 onchangePocalculate();
		}
	} 
	 
 }*/
 //----------------

 function createMainGridRow(style,buyerPO,mainCatName,discription,colorName,unitName,sizeName,qtyP,unitPrice,maxRateUSD,maxRate,matId,remarksqq,POtotalQty,ItemQty,intPOType,additionalQty,delDate,ratioBalQty,StyleName,BuyerPoName)
 {
	
	var curType=document.getElementById("cbocurrency").value;
		if(curType==0)
		curType="USD"; 
		//createAltXMLHttpRequest();
		//altxmlHttp.onreadystatechange = HandleExRate;
		var url = 'POMiddle.php?RequestType=getExchangeRate&curType='+URLEncode(curType);	
		var htmlobj=$.ajax({url:url,async:false});
		var Rate=htmlobj.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
	 
	if(qtyP=='')
		qtyP = 0;
		
 	var tbl = document.getElementById('PoMatMain');
	var x="";
	if(intPOType==1)  x = " - Freight";
	if (isItemAvailable(style, matId,buyerPO, colorName,sizeName,intPOType))
	{	
		alert("The record " + style + " : " +  matId + " : " + buyerPO + " : " +  colorName + " : " + sizeName + " : " + x + "\n already exists.");
		return;
	}
	
	var uniqueID = style + "" +  matId + "" + buyerPO + "" +  colorName + "" + sizeName + "" + x;
	
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

	row.id = intPOType;

	var dill=document.getElementById('deliverydateDD').value;
	
	var cellDelete = row.insertCell(0);  
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"images/del.png\" onClick=\"RemoveItem(this);\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	
	var cellStyle = row.insertCell(1);	
	cellStyle.className = "normalfntSM";
	cellStyle.id = style;	
	cellStyle.innerHTML = StyleName;	
	//alert(cellStyle.id);
	var cellBuyerPO=row.insertCell(2);	
	cellBuyerPO.className = "normalfntSM";
	cellBuyerPO.id = buyerPO;
	cellBuyerPO.innerHTML = BuyerPoName;
	
	var mainCat=row.insertCell(3);
	mainCat.className="normalfntSM";
	mainCat.innerHTML=mainCatName;
	
	if (intPOType == 1 ) discription +="<font class=\"error1\">- Freight</font>";
	var discrip=row.insertCell(4);
	discrip.className="normalfntSM";
	discrip.id=matId;
	discrip.innerHTML=discription;
	
	var remarks=row.insertCell(5);
	remarks.innerHTML="<input type=\"text\" maxlength=\"100\" size=\"15\" class=\"txtbox\" value=\""+remarksqq+"\" tabindex=\""+tindex+"\"></input>";
tindex++;
	var color=row.insertCell(6);
	color.className="normalfntSM";
	color.innerHTML=colorName;

	var unitN=row.insertCell(7);
	unitN.className="normalfntMidSML";
	unitN.innerHTML=unitName;
	
	var size=row.insertCell(8);
	size.className="normalfntMidSML";
	size.innerHTML=sizeName;	

	var qty=row.insertCell(9);
	qty.id=ratioBalQty;
	qty.innerHTML="<input type=\"text\" id=\"" + ratioBalQty + "\" size=\"10\" class=\"txtboxRightAllign\" value="+qtyP+" onkeyup=\"onchangePocalculate(); checkMaxqty(this);\" onblur=\"\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\" tabindex=\""+tindex+"\"></input>";
	tindex++;
	var addQty=row.insertCell(10);
	if(POtotalQty==null || POtotalQty=="")
	{
		POtotalQty=0;
	}
		var Fvalue = 10 - parseFloat(POtotalQty);
	
		if (Fvalue<0)
			Fvalue = 0;
		else if(Fvalue>10)
			Fvalue=10;

	if (additionalQty =='' || isNaN(parseInt(additionalQty)))
		additionalQty=0;
		
	var strDesable="";
	if((parseFloat(ItemQty)>500) || (intPOType==1))
	addQty.innerHTML="<input type=\"text\" id="+Fvalue+" size=\"11\" disabled=\"disabled\" class=\"txtboxRightAllign\" value="+additionalQty+" onkeyup=\"onchangePocalculate(); \" onblur=\"CheckAccessQty(this)\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  ></input>";
	else
	addQty.innerHTML="<input type=\"text\" id="+Fvalue+" size=\"11\" class=\"txtboxRightAllign\" value="+additionalQty+" onkeyup=\"onchangePocalculate();\" onblur=\"CheckAccessQty(this)\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" ></input>";
	
	var price = (parseFloat(unitPrice)*Rate).toFixed(5);
	var unitP=row.insertCell(11);
	unitP.innerHTML="<input type=\"text\" size=\"10\" class=\"txtboxRightAllign\" value="+price+" onkeyup=\"onchangePocalculate();\" onblur=\"checkMaxRate(this);\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal2(this.value, 4,event);\"  tabindex=\""+tindex+"\"></input>";
	tindex++;
	var maxRUsd=row.insertCell(12);
	maxRUsd.className="normalfntRiteSML";
	maxRUsd.innerHTML=maxRateUSD;

	var maxR=row.insertCell(13);
	maxR.className="normalfntRiteSML";
	maxR.innerHTML=maxRate;
	
	var value=row.insertCell(14);
	value.className="normalfntRiteSML";	

	var valueAct=unitPrice*qtyP;
	valueAct=roundNumber(valueAct,4);
	value.innerHTML=valueAct;
	
	var diliveryTo=row.insertCell(15);
	diliveryTo.className = "normalfntMid";
	diliveryTo.innerHTML="<select name=\"cboDilivery\"  class=\"txtbox\" id=\"cboDilivery\" style=\"width:50px\"  tabindex=\""+tindex+"\" >";
	tindex++;
	var diliveryDate=row.insertCell(16);
	diliveryDate.className = "normalfntMid";
	if(delDate == null)
	diliveryDate.innerHTML="<input name=\"" + uniqueID + "\" type=\"text\" class=\"txtbox\" id=\"" + uniqueID + "\" size=\"10\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+dill+"\" tabindex=\""+tindex+"\"></input><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"  >";
	else
	diliveryDate.innerHTML="<input name=\"" + uniqueID + "\" type=\"text\" class=\"txtbox\" id=\"" + uniqueID + "\" size=\"10\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\""+delDate+"\" tabindex=\""+tindex+"\"></input><input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\"   onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"  >";
	tindex++;
	LoadCompaniestoDp(tbl.rows.length-1);	 
 }
 
 function CheckAccessQty(objText)
 {
	if(parseInt(objText.id)<parseInt(objText.value))
		objText.value = objText.id;
 }
 function checkMaxqty(obj)
 {
	var currentQty=obj.value;
	//alert(currentQty);
	var maxQty=obj.id;
	//alert(maxQty);
	if(parseFloat(currentQty)>parseFloat(maxQty))
	{
		alert("Order qty can not be exceeding required qty.");
		obj.value = maxQty;
		return false;
		
		if ((obj.parentNode.parentNode.rowIndex % 2) == 1)
			obj.parentNode.parentNode.className="bcgcolor-tblrow";
		else
			obj.parentNode.parentNode.className="bcgcolor-tblrowWhite";
	}
	 onchangePocalculate();
 }
 function checkMaxRate(obj)
 {
	var currentValue = obj.value;
	var maxrate = obj.parentNode.parentNode.cells[13].childNodes[0].nodeValue;
	if (parseFloat(currentValue) > parseFloat(maxrate) && !canIncreaseUnitPriceFromPO)
	{
		alert("The unit price should less than the max rate.");
	}
 }
 
 // increase po value accoeding to the item qty and unit price.
 function calculatePOValue(qty, unitPrice)
 {
	 var thisRowPovalue=qty*unitPrice;
	 var previousPOVal=document.getElementById("txtpovalue").value;
	 var intItemPoVal=parseFloat(thisRowPovalue);
	 var IntpreviousPO=parseFloat(previousPOVal);
	 var unformatPO=IntpreviousPO+intItemPoVal;
	 var formatPO=roundNumber(unformatPO,4); 

	 document.getElementById("txtpovalue").value=formatPO;
	 
 }
 function convertRates()
 {
	 var curType=document.getElementById("cbocurrency").value;
	 if(curType=="")
	 	return;
		
	 if(curType==0)
	 curType="USD"; 
	 createAltXMLHttpRequest();
	 altxmlHttp.onreadystatechange = HandleRate;
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=getExchangeRate&curType='+curType, true);
    altxmlHttp.send(null);  
	 
 }
 function HandleRate()
 {
	
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
		var Rate=altxmlHttp.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
		//alert(Rate);
			if(Rate != 'NA')
			{
				var tbl=document.getElementById('PoMatMain');
				for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
				{
					var tt=tbl.rows.length;
					var ff=tbl.tBodies.length;
					var rw=tbl.rows[loop];
					var maxRateUSD= rw.cells[12].childNodes[0].nodeValue;
					var maxRate= maxRateUSD*Rate;
					maxRate=wacky_round(maxRate,5); //
					rw.cells[13].childNodes[0].nodeValue=maxRate;
					//rw.cells[11].lastChild.value=maxRate;
			
				}
				 onchangePocalculate();
				pubCurrencyId = document.getElementById('cbocurrency').value;
				}
			else
			{
				var cbocurrency = document.getElementById('cbocurrency').options[document.getElementById('cbocurrency').selectedIndex].text;
				alert('Exchange rate not available for '+cbocurrency);
				document.getElementById('cbocurrency').value = pubCurrencyId;
				return;
			}
		}
	} 
	 
 }
 
 function convertCancelRates()
 {
	 var curType=document.getElementById("cbocurrency").value;
	 if(curType==0)
	 curType="USD"; 
	 createAltXMLHttpRequest();
	 altxmlHttp.onreadystatechange = HandleCancelRate;
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=getExchangeRate&curType='+curType, true);
    altxmlHttp.send(null);  
	 
 }
 function HandleCancelRate()

 {
	
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
		var Rate=altxmlHttp.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
		var tbl=document.getElementById('PoMatMain');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var tt=tbl.rows.length;
			var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];
			var maxRateUSD= rw.cells[12].childNodes[0].nodeValue;
			var maxRate= maxRateUSD*Rate;
			//maxRate=wacky_round(maxRate,4);
			maxRate=wacky_round(maxRate,5);
			rw.cells[13].childNodes[0].nodeValue=maxRate;
			//rw.cells[11].lastChild.value=maxRate;
	
		}
		// onchangePocalculate();
		}
	} 
	 
 }
	 
 
 function checkTheDecimalPlace(Value)
 {
	
	
	 if (String(Value).indexOf(".") < String(Value).length - 3)
	 {
		
	return 	roundNumber(Value,2); 
	 }
	 else
	 {
		 return Value;
		 }
 }
 function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}
 function onchangePocalculate()
 {
	var poValue=0;
	var tbl=document.getElementById("PoMatMain");
	var rowcount=tbl.rows.length;
	for(var loop = 1; loop < rowcount; loop ++)
	 {
		 var rw=tbl.rows[loop];
		 var qty=rw.cells[9].lastChild.value;
		 var unitPrice=rw.cells[11].lastChild.value; 
		 var additionalQty = rw.cells[10].lastChild.value;
		
		 //alert(unitPrice + " " + qty);
		 if(additionalQty == "") additionalQty = 0;
		 if(qty == "") qty = 0;
		 if (unitPrice == "") unitPrice = 0;
		 var oneItemPO= ( parseFloat(qty) + parseFloat(additionalQty) ) * unitPrice;
		 rw.cells[14].childNodes[0].nodeValue = roundNumber(oneItemPO,4);
		 //alert(oneItemPO);
		 poValue+=oneItemPO;
	 }
	var roundPO= roundNumber(poValue,4);
	document.getElementById("txtpovalue").value=roundPO;
 }
 
 function deductPOValue(qty,unitPrice)
 {
	 var thisRowPovalue=qty*unitPrice;
	 var previousPOVal=document.getElementById("txtpovalue").value;
	 var intItemPoVal=parseFloat(thisRowPovalue);
	 var IntpreviousPO=parseFloat(previousPOVal);
	 var unFormatPO=IntpreviousPO-intItemPoVal;
	 var formatPO=roundNumber(unFormatPO,4);
	 document.getElementById("txtpovalue").value=formatPO;
	  
 }
 // load companies dropdown to datagrid.
 function LoadCompaniestoDp(intRow)
 {
	 var tbl=document.getElementById("PoMatMain");
	 var lastRow=intRow;
	 var rw=tbl.rows[lastRow];
	 var opt;
	 
	 if(companyNameA.length==0)
	 {				 
	   LoadCompanies();	  
	 }
	 for(var loop = 0; loop < companyNameA.length; loop ++)
	 {
		var opt = document.createElement("option");
		opt.text = companyNameA[loop].childNodes[0].nodeValue;
		opt.value = companyIdA[loop].childNodes[0].nodeValue;
		rw.cells[15].lastChild.options.add(opt); 
		 
	 }	 
 }
 
 function LoadCompanies()
 {
	createtFourthXMLHttpRequest();
    fourthxmlHttp.onreadystatechange = HandleCompanies;
    fourthxmlHttp.open("GET", 'POMiddle.php?RequestType=getCompanies', true);
    fourthxmlHttp.send(null);  
 }
 function HandleCompanies()
 {
	
	if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
		
	companyNameA=fourthxmlHttp.responseXML.getElementsByTagName("Company");
	companyIdA=fourthxmlHttp.responseXML.getElementsByTagName("CompanyID");
	
	
	/*
			 var CompanyID= xmlHttp.responseXML.getElementsByTagName("CompanyID");
			 var CompanyName= xmlHttp.responseXML.getElementsByTagName("Company");
			 
			 for ( var loop = 0; loop < CompanyID.length; loop ++)
			 {
			companyNameA[loop]=CompanyName[loop].childNodes[0].nodeValue;
			companyIdA[loop]=CompanyID[loop].childNodes[0].nodeValue;
				
			 }
			 */
			 
		}
	} 
	 
 }
 function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		
		var rowT=obj.parentNode.parentNode.parentNode;
		
		var qty=rowT.cells[9].lastChild.value;
		var unitPrice=rowT.cells[11].lastChild.value;
		deductPOValue(qty,unitPrice);
		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;
		//alert(tro.rowIndex);
		tt.parentNode.removeChild(tt);
		
		
	}
}

function savePOHeader()
{
	checkMaxqty(this);
	document.getElementById('butSave').style.display = 'inline';
	if(validateInterfaceData()){
		if(checkValiditiy())
		{
			createXMLHttpRequest();
			var pono=document.getElementById('txtfindpo').value;
			
			var year=savedPOYear;
			commonpoyear = year;
			var supplierID=document.getElementById('cboSupplier').value;
			
			var deliveryDate=document.getElementById('deliverydateDD').value;
			var currency=document.getElementById('cbocurrency').value;
			var InvoiceComp=document.getElementById('cboinvoiceto').value;
			var deliveryComp=document.getElementById('cbodiliverto').value;
				var poValue=document.getElementById('txtpovalue').value;
			var payTerm=document.getElementById('cbopayterms').value;
			var paymode=document.getElementById('cbopaymode').value;
			var instructions=document.getElementById('txtinstructions').value;
		/*	 while (instructions.indexOf("#")>-1)
					 {
						 instructions= instructions.replace("#","HashMark");
					 }*/
			var pino=document.getElementById('txtpino').value;
			var shipmentMode=document.getElementById('cboshipment').value;
			var shipTerm=document.getElementById('cboshipmentTerm').value;
			var ETA=document.getElementById('deliverydateETA').value;
			var ETD=document.getElementById('deliverydate').value;
			var sewFactory = document.getElementById('cboSewFactory').value;
			
			var validity=document.getElementById('textHiddenPO').value;
			
			if(pono!="" && validity=="")
			{
			checkPOValidity(pono);
			
			}
				if(pono=="" || validity=="True")
				{
					//showWaitingWindow();
					/*xmlHttp.onreadystatechange = HandleSavePO;
					xmlHttp.open("GET", 'POMiddle.php?RequestType=savePOheader&Year='+year+'&SupplierID='+supplierID+'&DeliveryDate='+deliveryDate+'&Currency='+currency+'&InvCompID='+InvoiceComp+'&DelToCompID='+deliveryComp+'&POValue='+poValue+'&PayTerm='+payTerm+'&PayMode='+paymode+'&Instructions='+URLEncode(instructions)+'&PINO='+pino+'&ShipmentMode='+shipmentMode+'&ShipmentTerm='+shipTerm+'&ETA='+ETA+'&ETD='+ETD+'&poNo='+pono, true);
					xmlHttp.send(null);  
					return true;*/
					var url="POMiddle.php";
					url=url+"?RequestType=savePOheader";
					url += '&Year='+year;
					url += '&SupplierID='+supplierID;
					url += '&DeliveryDate='+deliveryDate;
					url += '&Currency='+currency;
					url += '&InvCompID='+InvoiceComp;
					url += '&DelToCompID='+deliveryComp;
					url += '&POValue='+poValue;
					url += '&PayTerm='+payTerm;
					url += '&PayMode='+paymode;
					url += '&Instructions='+URLEncode(instructions);
					url += '&PINO='+URLEncode(pino);
					url += '&ShipmentMode='+shipmentMode;
					url += '&ShipmentTerm='+shipTerm;
					url += '&ETA='+ETA;
					url += '&ETD='+ETD;
					url += '&poNo='+pono;
					url += '&sewFactory='+sewFactory;
					//alert(url);
					var htmlobj=$.ajax({url:url,async:false});
					//var resPO_id=htmlobj.responseText;
					var PO_No = htmlobj.responseXML.getElementsByTagName("po")[0].childNodes[0].nodeValue;
					//var PO_No = resPO_id.getElementsByTagName("po")[0].childNodes[0].nodeValue;
					//alert(PO_No);
					if(PO_No != '-1000')
					{
						savePODetail(PO_No);
						//alert('save');
					}
					else
					{
						alert ("The allocated PO Number limit had exceed please contact your system administrator.");	
						return;
					}
				}
		}
		else
		{
			SaveButVisibility();
			return;
			}
  }
  else
  {
	 SaveButVisibility(); 
	  }
}

function validateInterfaceData()
{
	var supplierID=document.getElementById('cboSupplier').value;
	var dtmFulldate = new Date(document.getElementById('deliverydateL').value);
	
	if(supplierID==0)
	{
	alert("Please select a \"Supplier\".");
	document.getElementById('cboSupplier').focus();
	return;
	}
	var deliveryDate= document.getElementById('deliverydateDD').value;
	
	if(deliveryDate=="")
	{
	//alert("Delivery date can not leave blank, Please select a delivery date.");
	alert("Please select a \"Delivery Date\".");
	document.getElementById('deliverydateDD').focus();	
	return;
	}
	
	//var dd = validateDate(deliveryDate);
	else if(!validateDate(deliveryDate))
	{
	alert("Delivery date can not be prior to current date, Please select a correct delivery date.");
	document.getElementById('deliverydateDD').focus();
	return;
	}
	var currency=document.getElementById('cbocurrency').value;
	if(currency==0)
	{
	alert("Please select currency type.");
	document.getElementById('cbocurrency').focus();
	return;
	}
	var InvoiceComp=document.getElementById('cboinvoiceto').value;
	if(InvoiceComp==0)
	{
	alert("Please select a company to invoice.");
	document.getElementById('cboinvoiceto').focus();
	return;
	}
	var deliveryComp=document.getElementById('cbodiliverto').value;
	if(deliveryComp==0)
	{
	alert("Please select a company to deliver Items.");
	document.getElementById('cbodiliverto').focus();
	return;
	}
	
	var ETA= document.getElementById('deliverydateETA').value;
	
	if(ETA!="" && !validateDate(ETA))
	{
		alert("ETA can not be prior to current date, Please select a correct ETA date.");
		document.getElementById('deliverydateETA').focus();
		return;
	}
	var ETD=document.getElementById('deliverydate').value;
	if(ETD!="" && !validateDate(ETD))
	{
		alert("ETD can not be prior to current date, Please select a correct ETD date.");
		document.getElementById('deliverydate').focus();
		return;
	}
	var payMode = document.getElementById('cbopaymode').value;
	if(payMode == 'Null')
	{
		alert("Please select  \"Pay Mode\" .");
		document.getElementById('cbopaymode').focus();
		return;	
	}
	var payTerm = document.getElementById('cbopayterms').value;
	if(payTerm == 'Null')
	{
		alert("Please select  \"Pay Term\" .");
		document.getElementById('cbopayterms').focus();
		return;	
	}
	
	if(parseInt(baseCountryId) != parseInt(supplierCountryID))
	{
		if(document.getElementById('cboshipment').value == "Null")	
		{
			alert("Please select  \"Shipment Mode\" .");
			document.getElementById('cboshipment').focus();
			return;	
		}
		if(document.getElementById('cboshipmentTerm').value == "Null")	
		{
			alert("Please select  \"Shipment Term\" .");
			document.getElementById('cboshipmentTerm').focus();
			return;	
		}
	}
	var sewFactory = document.getElementById('cboSewFactory').value;
	if(sewFactory == '')
	{
		alert("Please select  \"Sewing Factory\" .");
		document.getElementById('cboSewFactory').focus();
		return;
	}
	//alert(fullDate);
	return true;
}

function validateDate(dtmFullDate)
{
	/*var dtmdate = document.getElementById('deliverydateL').value;
	var arrDate = dtmdate.split("/")[2]+'-'+dtmdate.split("/")[1]+'-'+dtmdate.split("/")[0];
	var todayDate = new Date(arrDate);*/
	
	var arrTdate = dtmFullDate.split("/")[2]+'-'+dtmFullDate.split("/")[1]+'-'+dtmFullDate.split("/")[0];
	//var testDate = new Date(arrTdate);
	//alert(arrTdate);
	
	var url="POMiddle.php";
			url=url+"?RequestType=deliveryDateValidation";
			url += '&delDate='+arrTdate;
			
			var xml_http_obj=$.ajax({url:url,async:false});
			
	if(xml_http_obj.responseXML.getElementsByTagName("XMLResponse")[0].childNodes[0].nodeValue == 1)
	  return true;
	 else
	 	return false;
	
	
}

function SaveButVisibility()
{
	document.getElementById('butSave').style.display = 'inline';
	//document.getElementById('imgConfirm').style.visibility = 'visible';
	}
	
function HandleSavePO()
 {
	
	if(xmlHttp.readyState == 4) 
    {
		
        if(xmlHttp.status == 200) 
        {  
		
			var CurrentPO= xmlHttp.responseXML.getElementsByTagName("po")[0].childNodes[0].nodeValue;			
			if(CurrentPO==-1000)
			{
			alert ("The allocated PO Number limit had exceed please contact your system administrator.");	
			return;
			}
			savePODetail(CurrentPO);		
			
		}
	} 
	 
 } 

 
 function gotoReport1()
 {
	 createThirdXMLHttpRequest();
	 var po;
	 var editablePO=document.getElementById("txtfindpo").value;
	 var fullDate=document.getElementById("deliverydateL").value;
	 var year=fullDate.substr(6,10);
	 if(CurrentPO==0)
		{
		po=	editablePO;
		}
	else
		{
		po=CurrentPO;
		}
	if(po!="")
		{
		 createThirdXMLHttpRequest();
		 thirdxmlHttp.onreadystatechange = handleRepotState;
	
    	 thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=postate&Pono=' + po , true);
    	 thirdxmlHttp.send(null); 	
		}
		else
		{
			alert("No PO available for view.Please save and try again.");
		}
	 
 }
 function handleRepotState()
 {
	  var po;
	 var editablePO=document.getElementById("txtfindpo").value;
	 var fullDate=document.getElementById("deliverydateL").value;
	 var year=fullDate.substr(6,10);
	 if(CurrentPO==0)
		{
		po=	editablePO;
		}
	else
		{
		po=CurrentPO;
		}
	 
	 if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  	
	var status= thirdxmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;	 
			 if(status==1)
			 {
				window.location = 'invaliedreport purchase.php?pono='+po+'&year='+year;			 
			 }
			 else if(status==10)
			 {
				 window.location = 'reportpurchase.php?pono='+po+'&year='+year; 
			 }
			 
		}
	} 	 
	 
 }

 function checkPOValidity(PONo)
 {
	 createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandlePOValidity;
	
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=POValidity&Pono=' + PONo , true);
    altxmlHttp.send(null);  
 }

function HandlePOValidity()
{

    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
	
			 var Validity= altxmlHttp.responseXML.getElementsByTagName("POValid")[0].childNodes[0].nodeValue;
			
			 if(Validity=="False")			
				{
				alert("Invalid PO Number. Check and try again with correct PO number.");
				SaveButVisibility();
			return;
			 	}
				else{
					/*if(document.getElementById("txtfindpo").disabled == false)
					{
						alert("The PO No field should be empty to save new PO.");
						document.getElementById("txtfindpo").focus();
						return;
					}
					document.getElementById('textHiddenPO').value=Validity;
					savePOHeader();*/
					
						if(Validity == "True")
						{
							document.getElementById('textHiddenPO').value=Validity;
							savePOHeader();
							return;
							}
					}
			
			 
		}
	}
}
	 

function loadPO()
{
	if(document.getElementById('copyPOMain').style.visibility == "hidden")
	document.getElementById('copyPOMain').style.visibility = "visible";
	else
	document.getElementById('copyPOMain').style.visibility = "hidden";
	
	
	document.getElementById('cboPONo').length=1;
	 	
}

function fireSearch()
{
	var reqYear = document.getElementById('cboCopyEear').value ;
	/*commonpoyear = reqYear;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlLoadPO;
    xmlHttp.open("GET", 'POMiddle.php?RequestType=GetPO&year=' + reqYear, true);
    xmlHttp.send(null); */
	
	var url="POMiddle.php";
					url=url+"?RequestType=GetPO";
					url += '&year='+reqYear;
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("PO")[0].childNodes[0].nodeValue;
		document.getElementById('cboPONo').innerHTML =  OrderNo;
	
}

function handlLoadPO()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	
			 var PO= xmlHttp.responseXML.getElementsByTagName("PO");
			 var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboPONo").options.add(opt);
			 
			 for ( var loop = 0; loop < PO.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = PO[loop].childNodes[0].nodeValue;
				opt.value = PO[loop].childNodes[0].nodeValue;
				document.getElementById("cboPONo").options.add(opt);
			 }
			 document.getElementById("cboPONo").value = "Select One";
		}
	} 
}
function copyPO()
{
	clearPOData();
	document.getElementById('txtfindpo').value="";
	var PONo=document.getElementById('cboPONo').value;
	var reqYear = document.getElementById('cboCopyEear').value ;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleCopyPo;
    xmlHttp.open("GET", 'POMiddle.php?RequestType=copyPO&pono='+PONo + '&year=' + reqYear, true);
    xmlHttp.send(null);
}
function handleCopyPo()
{
		  if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	//Load values to the main controllers.
	
		document.getElementById('cbocurrency').value
=xmlHttp.responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
		document.getElementById('cboSupplier').value=xmlHttp.responseXML.getElementsByTagName("SupplierID")[0].childNodes[0].nodeValue;
		document.getElementById('cbodiliverto').value
=xmlHttp.responseXML.getElementsByTagName("DelToCompID")[0].childNodes[0].nodeValue;
document.getElementById('cboinvoiceto').value
=xmlHttp.responseXML.getElementsByTagName("InvCompID")[0].childNodes[0].nodeValue;
document.getElementById('cboshipment').value
=xmlHttp.responseXML.getElementsByTagName("ShipmentMode")[0].childNodes[0].nodeValue;
document.getElementById('cboshipmentTerm').value
=xmlHttp.responseXML.getElementsByTagName("ShipmentTerm")[0].childNodes[0].nodeValue;
document.getElementById('cbopaymode').value
=xmlHttp.responseXML.getElementsByTagName("PayMode")[0].childNodes[0].nodeValue;
document.getElementById('cbopayterms').value
=xmlHttp.responseXML.getElementsByTagName("PayTerm")[0].childNodes[0].nodeValue;
document.getElementById('txtpovalue').value
=xmlHttp.responseXML.getElementsByTagName("POValue")[0].childNodes[0].nodeValue;
document.getElementById('txtpino').value
=xmlHttp.responseXML.getElementsByTagName("PINO")[0].childNodes[0].nodeValue;
document.getElementById('txtinstructions').value
=xmlHttp.responseXML.getElementsByTagName("Instructions")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateL').value
=xmlHttp.responseXML.getElementsByTagName("Date")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateDD').value
=xmlHttp.responseXML.getElementsByTagName("DeliveryDate")[0].childNodes[0].nodeValue;
document.getElementById('deliverydate').value
=xmlHttp.responseXML.getElementsByTagName("ETD")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateETA').value
=xmlHttp.responseXML.getElementsByTagName("ETA")[0].childNodes[0].nodeValue;


//Load Values to the item grid
var styleID=xmlHttp.responseXML.getElementsByTagName("StyleID");
			
			 for ( var loop = 0; loop < styleID.length; loop ++)
			  {
			 	
				var StyleID=xmlHttp.responseXML.getElementsByTagName("StyleID")[loop].childNodes[0].nodeValue;
				var StyleName=xmlHttp.responseXML.getElementsByTagName("StyleName")[loop].childNodes[0].nodeValue;
				var BuyerPO=xmlHttp.responseXML.getElementsByTagName("BuyerPONO")[loop].childNodes[0].nodeValue;
				var BuyerPoName=xmlHttp.responseXML.getElementsByTagName("BuyerPoName")[loop].childNodes[0].nodeValue;
				var Color=xmlHttp.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
				var Size=xmlHttp.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
				var qty=xmlHttp.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
				var ItemName=xmlHttp.responseXML.getElementsByTagName("ItemDetail")[loop].childNodes[0].nodeValue;
				var MainCatName=xmlHttp.responseXML.getElementsByTagName("MainCategory")[loop].childNodes[0].nodeValue;
				var Unit=xmlHttp.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
				var UnitPrice=xmlHttp.responseXML.getElementsByTagName("UnitPrice")[loop].childNodes[0].nodeValue;
				var maxUSD=xmlHttp.responseXML.getElementsByTagName("MaxUSD")[loop].childNodes[0].nodeValue;
				var matID=xmlHttp.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
				var remarksCc=xmlHttp.responseXML.getElementsByTagName("Remarks")[loop].childNodes[0].nodeValue;

				var intPOType = xmlHttp.responseXML.getElementsByTagName("intPOType")[loop].childNodes[0].nodeValue;
				var POTotalQty=xmlHttp.responseXML.getElementsByTagName("POTotalQty")[loop].childNodes[0].nodeValue;
				var ItemQty=xmlHttp.responseXML.getElementsByTagName("ItemQty")[loop].childNodes[0].nodeValue;
				var additionalQty =xmlHttp.responseXML.getElementsByTagName("AdditionalQty")[loop].childNodes[0].nodeValue;
				
				CompanyIDs[loop]=xmlHttp.responseXML.getElementsByTagName("DeliverToCompId")[loop].childNodes[0].nodeValue;
				deliveryDate[loop]=xmlHttp.responseXML.getElementsByTagName("ItemDeliveryDate")[loop].childNodes[0].nodeValue;
				var ratioBalQty=xmlHttp.responseXML.getElementsByTagName("RatioBalQty")[loop].childNodes[0].nodeValue;

				createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,qty,UnitPrice,maxUSD,UnitPrice,matID,remarksCc,POTotalQty,ItemQty,intPOType,additionalQty,deliveryDate[loop],ratioBalQty,StyleName,BuyerPoName)

				
				document.getElementById('copyPOMain').style.visibility = "hidden";
			
			  }
			 
			 setSelectedValues(CompanyIDs,deliveryDate);
			 convertCancelRates();
		}
	}
	
}
// Select the delivered company and insert delivery date in Main PO grid.
function setSelectedValues(CompanyIDs,deliveryDate)
{
	var count=0;
	var tbl=document.getElementById('PoMatMain');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			//alert(deliveryDate[count]);
			
			var rw=tbl.rows[loop];
			
			rw.cells[15].lastChild.value=CompanyIDs[count];
			//rw.cells[16].childNodes[0].value=deliveryDate[count];
			count++;
		}
	
	
}
 function savePODetail(pono)
 {
	 
	 var fullDate=new Date();
	var year=savedPOYear;
	var count=0;
	var ponou=document.getElementById('txtfindpo').value;
	 var tbl=document.getElementById('PoMatMain');
	 if(tbl.rows.length<2)
	 {
	alert("No Items found in PO, Please add items to Purchase order.");
	return;
	 }
	 
	 var tblRwcnt = tbl.rows.length-1;
	  for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var tt=tbl.rows.length;
			var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];

			

			 var styleID= rw.cells[1].id;
			 var buyerPONO= rw.cells[2].id;
			 var remarks=rw.cells[5].lastChild.value;
			 var color=rw.cells[6].childNodes[0].nodeValue;
			 var unitType=rw.cells[7].childNodes[0].nodeValue;
			 var size=rw.cells[8].childNodes[0].nodeValue;
			 var qty=rw.cells[9].lastChild.value;
			 var additionalQty=rw.cells[10].lastChild.value;
			 var unitPrice=rw.cells[11].lastChild.value;
			 var deliverToComp=rw.cells[15].lastChild.value;;
			 var year=year;
			 var pending=qty;
	 	     var ItemDeliveryDate=rw.cells[16].childNodes[0].value;
			 var MatDetailID=tbl.rows[loop].cells[4].id;
			
			 
			
			 
			/* createThirdXMLHttpRequest();
			thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=savePOdetail&Year=' +year+ '&StyleID=' + URLEncode(styleID) + '&MatDetailID=' + MatDetailID + '&Color=' + URLEncode(color) + '&Size=' + URLEncode(size) +'&BuyerPONO=' + URLEncode(buyerPONO) + '&Remarks=' + URLEncode(remarks) + '&Unit=' + URLEncode(unitType) + '&UnitPrice=' + unitPrice +'&Qty=' + qty + '&Pending=' + pending + '&AdditionalQty=' + additionalQty + '&DeliverToCompId=' + deliverToComp + '&ItemDeliveryDate=' + ItemDeliveryDate + '&poNou='+ponou+'&pono='+pono+'&type='+tbl.rows[loop].id , true);
    thirdxmlHttp.send(null);  */
	
			 var url="POMiddle.php";
			url=url+"?RequestType=savePOdetail";
			url += '&Year='+year;
			url += '&StyleID='+styleID;
			url += '&MatDetailID='+MatDetailID;
			url += '&Color='+ URLEncode(color);
			url += '&Size='+URLEncode(size);
			url += '&BuyerPONO='+URLEncode(buyerPONO);
			url += '&Remarks='+URLEncode(remarks);
			url += '&Unit='+URLEncode(unitType);
			url += '&UnitPrice='+unitPrice;
			url += '&Qty='+qty;
			url += '&Pending='+pending;
			url += '&AdditionalQty='+additionalQty;
			url += '&DeliverToCompId='+deliverToComp;
			url += '&ItemDeliveryDate='+ItemDeliveryDate;
			url += '&poNou='+ponou;
			url += '&pono='+pono;
			url += '&type='+tbl.rows[loop].id;
			
			var htmlobj=$.ajax({url:url,async:false});
			var resPODet_id=htmlobj.responseXML.getElementsByTagName("SaveDetResponse")[0].childNodes[0].nodeValue;
			if(resPODet_id == 'save')
			{
				 count++;
				}
		}
		
		document.getElementById('txtfindpo').value=pono;
		if(count == tblRwcnt)
		{
			alert("Purchase order saved successfully.\n\nPO No : " + pono + "\nPO Year : " + year);
			document.getElementById('imgsendToApprov').style.display = 'inline';
			/*if(canConfirmPOs){
				document.getElementById('imgConfirm').style.display = 'inline';
			}*/
			/*alert(POfirstApproval);
			if(POfirstApproval)
			{
			document.getElementById('imgConfirm').style.visibility = 'visible';
			}*/
		}
			
			else
			{
				alert('Error in save po details');
				}
		//clearPOData();	 
		SaveButVisibility();
	 
 }
 function checkValiditiy()
 {
	 var tbl=document.getElementById('PoMatMain');
	 if(tbl.rows.length<2)
	 {
	alert("No Items found in PO, Please add items to purchase order.");
	document.getElementById('butNew').focus();
	return false;
	 }
	 var dtmFulldate = new Date(document.getElementById('deliverydateL').value);
	  for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var tt=tbl.rows.length;
			var rw=tbl.rows[loop]; 
			var qty=rw.cells[9].lastChild.value;
			 var maxQty=rw.cells[9].id;
			 if(parseFloat(qty)>parseFloat(maxQty))
			 {
			 	alert("Save cannot proceed. One or more item has over valued than maximum allowed Qty.");
				rw.className='osc2';				
			 	return false;
			 }
			 var unitPrice=rw.cells[11].lastChild.value;
			 var maxRate=rw.cells[13].childNodes[0].nodeValue;
				 if(parseFloat(unitPrice)>parseFloat(maxRate) && ! canIncreaseUnitPriceFromPO)
			 	{
				 alert("Save cannot proceed. One or more item has over valued than maximum Rate.");
				 return false;
			 	}
				//check item delivery date with the today date
				var itemDelDate = rw.cells[16].childNodes[0].value;
				
				if(!validateDate(itemDelDate))
				{
					 alert("Save cannot proceed. One or more item has delivery date prior to current date.");
					return false;
					}
		}
		return true;
 }
 
 
 var fullDate=new Date();
 var savedPOYear = fullDate.getFullYear();
 
 
 function loadPOdetails()
 {
	var yer = document.getElementById('cboPOYearBox').value; 
	var orderType = document.getElementById('cboOrderbyType').value; 
	//alert(orderType)
	clearPOData();
	if(document.getElementById('FindPO').style.visibility == "visible")	
		{
			document.getElementById('FindPO').style.visibility = "hidden";
		}
		
	var PONo=document.getElementById('txtfindpo').value;
	if(PONo == null || PONo == "")
	{
	alert("Please enter the PO No for edit.");
	document.getElementById('txtfindpo').focus();
	return;
	}
 	 savedPOYear = yer;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlePODetails;
    xmlHttp.open("GET", 'POMiddle.php?RequestType=findPO&pono='+PONo + '&year=' + yer+'&orderType='+orderType, true);
    xmlHttp.send(null); 
	 
	 
 }
 
 function handlePODetails()
 {
	  if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	//Load values to the main controllers.
	var poNocheck=xmlHttp.responseXML.getElementsByTagName("*"); 
var cdata=xmlHttp.responseXML.getElementsByTagName("PONo");
	//alert(cdata.length);
	if(cdata.length <= 0)
	{
	alert("Sorry, No pending PO available for given PO Number. Try with another.");
	document.getElementById('txtfindpo').focus();
	return;
	}
	
	commonpoyear=xmlHttp.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		document.getElementById('cbocurrency').value
=xmlHttp.responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
		document.getElementById('cboSupplier').value=xmlHttp.responseXML.getElementsByTagName("SupplierID")[0].childNodes[0].nodeValue;
		document.getElementById('cbodiliverto').value
=xmlHttp.responseXML.getElementsByTagName("DelToCompID")[0].childNodes[0].nodeValue;
document.getElementById('cboinvoiceto').value
=xmlHttp.responseXML.getElementsByTagName("InvCompID")[0].childNodes[0].nodeValue;
document.getElementById('cboshipment').value
=xmlHttp.responseXML.getElementsByTagName("ShipmentMode")[0].childNodes[0].nodeValue;
document.getElementById('cboshipmentTerm').value
=xmlHttp.responseXML.getElementsByTagName("ShipmentTerm")[0].childNodes[0].nodeValue;
document.getElementById('cbopaymode').value
=xmlHttp.responseXML.getElementsByTagName("PayMode")[0].childNodes[0].nodeValue;
document.getElementById('cbopayterms').value
=xmlHttp.responseXML.getElementsByTagName("PayTerm")[0].childNodes[0].nodeValue;
//document.getElementById('txtpovalue').value
//=xmlHttp.responseXML.getElementsByTagName("POValue")[0].childNodes[0].nodeValue;
document.getElementById('txtpino').value
=xmlHttp.responseXML.getElementsByTagName("PINO")[0].childNodes[0].nodeValue;
document.getElementById('txtinstructions').value
=xmlHttp.responseXML.getElementsByTagName("Instructions")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateL').value
=xmlHttp.responseXML.getElementsByTagName("Date")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateDD').value
=xmlHttp.responseXML.getElementsByTagName("DeliveryDate")[0].childNodes[0].nodeValue;
document.getElementById('deliverydate').value
=xmlHttp.responseXML.getElementsByTagName("ETD")[0].childNodes[0].nodeValue;
document.getElementById('deliverydateETA').value
=xmlHttp.responseXML.getElementsByTagName("ETA")[0].childNodes[0].nodeValue;
supplierCountryID = xmlHttp.responseXML.getElementsByTagName("supplierCountry")[0].childNodes[0].nodeValue;
document.getElementById('cboSewFactory').value=xmlHttp.responseXML.getElementsByTagName("sewFactory")[0].childNodes[0].nodeValue;
//Load Values to the item grid
var styleID=xmlHttp.responseXML.getElementsByTagName("StyleID");
			
			 for ( var loop = 0; loop < styleID.length; loop ++)
			  {
			 	
				var StyleID			= xmlHttp.responseXML.getElementsByTagName("StyleID")[loop].childNodes[0].nodeValue;
				var StyleName		= xmlHttp.responseXML.getElementsByTagName("StyleName")[loop].childNodes[0].nodeValue;
				var BuyerPO			= xmlHttp.responseXML.getElementsByTagName("BuyerPONO")[loop].childNodes[0].nodeValue;
				var BuyerPoName		= xmlHttp.responseXML.getElementsByTagName("BuyerPoName")[loop].childNodes[0].nodeValue;
				var Color			= xmlHttp.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
				var Size			= xmlHttp.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
				var qty				= xmlHttp.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
				var addQty			= xmlHttp.responseXML.getElementsByTagName("AdditionalQty")[loop].childNodes[0].nodeValue;
				var ItemName		= xmlHttp.responseXML.getElementsByTagName("ItemDetail")[loop].childNodes[0].nodeValue;
				var MainCatName		= xmlHttp.responseXML.getElementsByTagName("MainCategory")[loop].childNodes[0].nodeValue;
				var Unit			= xmlHttp.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
				var UnitPrice		= xmlHttp.responseXML.getElementsByTagName("UnitPrice")[loop].childNodes[0].nodeValue;
				var matID			= xmlHttp.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
				CompanyIDs[loop]	= xmlHttp.responseXML.getElementsByTagName("DeliverToCompId")[loop].childNodes[0].nodeValue;
				deliveryDate[loop]	= xmlHttp.responseXML.getElementsByTagName("ItemDeliveryDate")[loop].childNodes[0].nodeValue;
				var remarks			= xmlHttp.responseXML.getElementsByTagName("Remarks")[loop].childNodes[0].nodeValue;
				
				var maxUSD			= xmlHttp.responseXML.getElementsByTagName("MaxUSD")[loop].childNodes[0].nodeValue;
				var intPOType 		= xmlHttp.responseXML.getElementsByTagName("intPOType")[loop].childNodes[0].nodeValue;
				var POTotalQty		= xmlHttp.responseXML.getElementsByTagName("POTotalQty")[loop].childNodes[0].nodeValue;
				var ItemQty			= xmlHttp.responseXML.getElementsByTagName("ItemQty")[loop].childNodes[0].nodeValue;
				var ratioBalQty		= xmlHttp.responseXML.getElementsByTagName("RatioBalQty")[loop].childNodes[0].nodeValue;

		createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,qty,UnitPrice,maxUSD,UnitPrice,matID,remarks,POTotalQty,ItemQty,intPOType,addQty,deliveryDate[loop],ratioBalQty,StyleName,BuyerPoName)
			
			  }
			   setSelectedValues(CompanyIDs,deliveryDate);
			   onchangePocalculate();
			   onchangePocalculate();
			 	convertCancelRates();
			 	if(canConfirmPOs)
				{
			 	//document.getElementById('imgConfirm').style.display = 'inline';
				}
  				document.getElementById('butSave').style.display = 'inline';
				document.getElementById('imgsendToApprov').style.display = 'inline';
  				document.getElementById('txtfindpo').disabled = true;
  				currentStatus = 1;
		}
	}
 }
 
 function clearPOData()
 {
	 //document.getElementById('txtfindpo').value="";
	 var tbl = document.getElementById('PoMatMain');
	var rowCount=tbl.rows.length;
	
 	if(rowCount<2)return;
	for(var rowC=1; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(1);  
	//rowCount=tbl.rows.length;
  }
  
  document.getElementById('cbocurrency').selectedIndex=0;
  document.getElementById('cboSupplier').selectedIndex=0;
  document.getElementById('cbodiliverto').selectedIndex=0;
  document.getElementById('cboinvoiceto').selectedIndex=0;
  document.getElementById('cboshipment').selectedIndex=0;
  document.getElementById('cboshipmentTerm').selectedIndex=0;
  document.getElementById('cbopaymode').selectedIndex=0;
  document.getElementById('cbopayterms').selectedIndex=0;
  document.getElementById('txtpovalue').value=0;
  document.getElementById('txtpino').value="";
  
  document.getElementById('deliverydateDD').value="";
  document.getElementById('deliverydate').value="";
  document.getElementById('deliverydateETA').value="";
  document.getElementById('txtinstructions').value="";
  document.getElementById('txtfindpo').disabled = false;
  
	 
	 
}
function conform()
{
 var poNo=document.getElementById('txtfindpo').value;
 var tbl=document.getElementById('PoMatMain');

	
if(poNo!="" && tbl.rows.length>1)
{

var fullDate=new Date();
	var year=savedPOYear;
	
	if(confirm('Are you sure you want to confirm this PO -'+poNo+'?'))
	{	
		document.getElementById('butSave').style.display = "none";
		document.getElementById('imgConfirm').style.display = "none";
		window.open("poFirstApprovalReport.php?pono=" + poNo + "&year=" + year,'frmPO');
		//ConfirmValidation(poNo,year);
	}
	
}
else
alert("Please try again after loading PO data.");
//alert("Sorry! You Can't conform this PO. Please try again after loading Po data.");
	
}
function changeState()
{
	var poNo=document.getElementById('txtfindpo').value;
	
	createXMLHttpRequest();
		xmlHttp.onreadystatechange = handleConfirm;
		xmlHttp.open("GET", 'POMiddle.php?RequestType=confirm&pono='+poNo + '&year=' + commonpoyear, true);	
		xmlHttp.send(null); 
}
function handleConfirm()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;
			
			if(state=="TRUE")
			{
				var poNo=document.getElementById('txtfindpo').value;
				var fullDate=new Date();
	            var year=fullDate.getFullYear();
				//ClearForNewPO();
				pub_poNo = poNo;
				pub_year = commonpoyear;
				document.getElementById('confirmReport').style.visibility = "visible";
	            //window.location = 'reportpurchase.php?pono='+poNo+'&year='+year; 
			}
		}
	}
	
}
function confirmSave()
{
	
	if(savePOHeader())
	{
	
	PONo=CurrentPO;
	var fullDate=new Date();
	var year=fullDate.getFullYear();
	commonpoyear = savedPOYear;
	if(confirm('Are you sure you want to confirm this PO?'))
	{
	PONo=CurrentPO;
	changeMatRatio(PONo,year);
	createXMLHttpRequest();
    xmlHttp.open("GET", 'POMiddle.php?RequestType=confirm&pono='+PONo + '&year=' + commonpoyear, true);	
    xmlHttp.send(null); 
	}
	
	}
	
		
	
}

function changeMatRatio(pono,year)
{
	
	createtFourthXMLHttpRequest();
	fourthxmlHttp.onreadystatechange = handleMatratio;
	fourthxmlHttp.open("GET", 'POMiddle.php?RequestType=changeMatRatio&pono=' + pono + '&year=' + year, true);
    fourthxmlHttp.send(null);  			

}
function handleMatratio()
{
if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
		var state=fourthxmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;
		if(state=="TRUE")
		{
		changeState();	
		document.getElementById('imgConfirm').style.display = "none";
		document.getElementById('butSave').style.display = "none";
		currentStatus = 10;
		}
		}
	}
	
}

function serchForCancel(type)
{
	clearCancelPO();
	var pono=document.getElementById('txtpono').value;
	var supID=document.getElementById('cboSupplierCan').value;
	var fromDate=document.getElementById('CandeliverydateL').value;
	var toDate=document.getElementById('CandeliverydateDD').value;
	
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleSearch;
	xmlHttp.type = type;
   xmlHttp.open("GET", 'POMiddle.php?RequestType=getCancelPOData&pono='+pono+'&supplierID='+supID+'&from='+fromDate+'&to='+toDate+ '&type=' +type, true);
   xmlHttp.send(null); 	
	
}
function handleSearch()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			document.getElementById('tblCancelPO').innerHTML =  "<tr>"+
           "<td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>"+
              "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
              "<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Year</td>"+
              "<td width=\"29%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Date</td>"+
              "<td width=\"26%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Value</td>"+
              "</tr>";
			 var Ponos= xmlHttp.responseXML.getElementsByTagName("poNo");
			 for ( var loop = 0; loop < Ponos.length; loop ++)
			 {
				var poNo=xmlHttp.responseXML.getElementsByTagName("poNo")[loop].childNodes[0].nodeValue;
				var poYear=xmlHttp.responseXML.getElementsByTagName("poYear")[loop].childNodes[0].nodeValue;
				var poDate=xmlHttp.responseXML.getElementsByTagName("date")[loop].childNodes[0].nodeValue;
				var poValue=xmlHttp.responseXML.getElementsByTagName("poValue")[loop].childNodes[0].nodeValue;
				var GRN=xmlHttp.responseXML.getElementsByTagName("GRNState")[loop].childNodes[0].nodeValue;
				var payT=xmlHttp.responseXML.getElementsByTagName("PayTerm")[loop].childNodes[0].nodeValue;
				createCancelPOgrid(poNo,poYear, poDate,poValue,GRN,payT,xmlHttp.type);	
			 }
			 
		}
	} 
	
}
function createCancelPOgrid(pono,poYear, date,povalue,GRN,payT,type)
{
	var tbl = document.getElementById('tblCancelPO');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellDelete = row.insertCell(0);  
	tbl.rows[lastRow].bgColor="#FFFFFF";
	if(type=='cancel')
	{
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"images/del.png\" onClick=\"cancelPO(this,'cancel'," + poYear + ");\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 
	}
	else
	{
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"images/posted.png\" onClick=\"cancelPO(this,'revision'," + poYear + ");\" alt=\"del\" width=\"15\" height=\"15\" /></div>"; 	
	}
	
	
	var cellStyle=row.insertCell(1);
	cellStyle.className="normalfntMid";
	cellStyle.innerHTML=pono;
	
	var cellBuyerPO=row.insertCell(2);
	cellBuyerPO.className="normalfntMid";
	cellBuyerPO.innerHTML=poYear;
	
	var cellBuyerPO=row.insertCell(3);
	cellBuyerPO.className="normalfntMid";
	cellBuyerPO.innerHTML=date;
	
	var mainCat=row.insertCell(4);
	mainCat.className="normalfntRite";
	mainCat.innerHTML=povalue;
		
	if(GRN>0 || payT==0)
	{
	tbl.rows[lastRow].bgColor="#FFC6C6";
	cellDelete.innerHTML="";
	}
}

function clearCancelPO()
{
	 var tbl = document.getElementById('tblCancelPO');
	var rowCount=tbl.rows.length;
	
 	if(rowCount<2)return;
	for(var rowC=1; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(1);  
	rowCount=tbl.rows.length;
	}
}
	
	
function cancelPO(obj,type,year)
{
	var tr=obj.parentNode.parentNode.parentNode;
	var poNo=tr.cells[1].childNodes[0].nodeValue;
	creatXmlHttp1();
	xmlHttp1.onreadystatechange=grnStatusRequest;
	xmlHttp1.index = poNo;
	xmlHttp1.obj = obj;
	xmlHttp1.year = year;
	xmlHttp1.type = type;
	xmlHttp1.open("GET", 'POMiddle.php?RequestType=getGrnStatus&pono='+poNo + '&poYear=' + year, true);
   xmlHttp1.send(null); 
}
function grnStatusRequest()
{
	if(xmlHttp1.readyState == 4 && xmlHttp1.status == 200) 
    {
		var grnCount = xmlHttp1.responseXML.getElementsByTagName("num")[0].childNodes[0].nodeValue;
		var obj = xmlHttp1.obj;
		if (grnCount>0)
			alert("Can't Cancel / Revise this po. This po has allready raised GRN.");
		else
		{
			if(xmlHttp1.type=='cancel')
				cancelPo2(xmlHttp1.index,obj,xmlHttp1.year);
			else
				revisePo(xmlHttp1.index,obj,xmlHttp1.year);
			
		}
	}
		
}
function cancelPo2(poNo,obj,year)
{
	if(confirm('Are you sure you want cancel PO \"' +year+'/'+poNo+'\"?'))
	{
		createXMLHttpRequest();
    	xmlHttp.open("GET", 'POMiddle.php?RequestType=CancelPO&pono='+poNo + '&year=' + year, true);
    	xmlHttp.send(null); 
	

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;
		//alert(tro.rowIndex);
		tt.parentNode.removeChild(tt);	
		
	}

}
function revisePo(poNo,obj,poyer)
{
	if(confirm('Are you sure you want revise PO No \"'+ poyer+'/'+poNo+"\"?"))
	{
	createXMLHttpRequest();
    xmlHttp.open("GET", 'POMiddle.php?RequestType=revisePo&pono='+poNo + '&POYear=' + poyer, true);
    xmlHttp.send(null); 
	var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;
		//alert(tro.rowIndex);
		tt.parentNode.removeChild(tt);	
	}
	
}
function loadSuppliers1()
{
	var currency = document.getElementById("cbocurrency").value;
	var url  = "POMiddle.php";
		url += "?RequestType=getSuppliers1";
		url += "&currency="+currency;	
	var xml_http_obj=$.ajax({url:url,async:false});
	
	document.getElementById("cboSupplier").innerHTML = xml_http_obj.responseXML.getElementsByTagName('suppliers1')[0].childNodes[0].nodeValue;
}
function loadSuppliers1()
{
	var currency = document.getElementById("cbocurrency").value;
	var url  = "POMiddle.php";
		url += "?RequestType=getSuppliers1";
		url += "&currency="+currency;	
	var xml_http_obj=$.ajax({url:url,async:false});
	
	document.getElementById("cboSupplier").innerHTML = xml_http_obj.responseXML.getElementsByTagName('suppliers1')[0].childNodes[0].nodeValue;
}
function loadCurrancy()
{
	var suppLiers = document.getElementById("cboSupplier").value;
	var url  = "POMiddle.php";
		url += "?RequestType=getCurrancy";
		url += "&suppLiers="+suppLiers;	
	var xml_http_obj=$.ajax({url:url,async:false});
	
	document.getElementById("cbocurrency").innerHTML = xml_http_obj.responseXML.getElementsByTagName('suppliers1')[0].childNodes[0].nodeValue;
}
function loadSuppliers()
{

 createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = Handlesupliers;
	
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=getSuppliers', true);
    altxmlHttp.send(null);  
 }

function Handlesupliers()
{

    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
		 var supplierID= altxmlHttp.responseXML.getElementsByTagName("SupID");
			 var supplier=altxmlHttp.responseXML.getElementsByTagName("Supplier");
			 for ( var loop = 0; loop < supplierID.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = supplier[loop].childNodes[0].nodeValue;
				opt.value = supplierID[loop].childNodes[0].nodeValue;
				document.getElementById("cboSupplierCan").options.add(opt);
			 }
	
			
		}
	}
}
	
function showCanelPopup()
{
	 drawPopupArea(515,317,'frmPOCancel');
	 var HTMLText ="<table width=\"100%\" border=\"0\" bgcolor=\"#ffffff\" align=\"left\">"+
          "<tr>"+
		"<td width=\"93%\" height=\"25\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Purchase Order Cancellation</td>"+		
          "</tr>"+
          "<tr>"+
            "<td height=\"165\">"+
            "<table width=\"100%\" height=\"165\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr>"+
       "<td width=\"100%\" height=\"26\"><table width=\"100%\" align=\"right\" border=\"0\" class=\"bcgl1\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#FEFDEB\">"+
                    "<tr>"+
                      "<td height=\"13\" class=\"normalfnt\">Supplier</td>"+
                      "<td colspan=\"2\"><span class=\"normalfnt\">"+
   "<select name=\"cboSupplierCan\" class=\"txtbox\" id=\"cboSupplierCan\" style=\"width:328px\">"+ 
   "<option value=\"0\" selected=\"selected\">Select One</option>"+                         
            "</select>"+ 
                      "</span></td>"+
                      "<td width=\"23%\">&nbsp;</td>"+     
                    "</tr>"+
				   
				   
				   "<tr>"+
                      "<td width=\"21%\" height=\"12\" class=\"normalfnt\">PO No</td>"+
                      "<td width=\"29%\"><input name=\"txtpono\" size=\"15\" type=\"text\" class=\"txtbox\""+
					  "id=\"txtpono\" /></td>"+
                      "<td width=\"27%\">&nbsp;</td>"+
                      "<td width=\"23%\">&nbsp;</td>"+
                    "</tr>"+
                   
                    "<tr>"+
                      "<td height=\"27\" class=\"normalfnt\">Date From</td>"+
                    "<td width=\"25%\"><input name=\"CandeliverydateL\" type=\"text\" class=\"txtbox\""+ 
				   "id=\"CandeliverydateL\" size=\"15\" onmousedown=\"DisableRightClickEvent();\""+ 
					   "onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return"+ 
"ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id,'%d/%m/%Y');\"/>"+
"<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\""+   
"onclick=\"return  showCalendar(this.id, '%d/%m/%Y');\"></td>"+
                      "<td class=\"normalfnt\">To "+
                       "<input name=\"CandeliverydateDD\" type=\"text\" class=\"txtbox\""+ 
				   "id=\"CandeliverydateDD\" size=\"15\" onmousedown=\"DisableRightClickEvent();\""+ 
					   "onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return"+ 
"ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id,'%d/%m/%Y');\"/>"+
"<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\""+   
"onclick=\"return  showCalendar(this.id, '%d/%m/%Y');\"></td>"+
						 "<td  class=\"normalfnt\"><img src=\"images/search.png\" alt=\"serch\" width=\"80\" height=\"24\""+ 
   "onclick=\"serchForCancel('cancel');\" /></td>"+
                      "</tr>"+                   
                  "</table></td>"+
                "</tr>"+
                "<tr class=\"bcgl1\">"+
                  "<td><table width=\"93%\" border=\"0\" class=\"bcgl1\">"+
                    "<tr>"+
      "<td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:177px; width:500px;\">"+
          "<table width=\"484\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblCancelPO\" bgcolor=\"#CCCCFF\">"+
            "<tr>"+
           "<td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>"+
              "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
			  "<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Year</td>"+
              "<td width=\"29%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Date</td>"+
              "<td width=\"26%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Value</td>"+
              "</tr>"+       
           "</table>"+
        "</div></td>"+
           "</tr>"+
              "</table></td>"+
                "</tr>"+
                "<tr class=\"bcgl1\">"+
                 "<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">"+
                  "<tr>"+
                      "<td width=\"25%\">&nbsp;</td>"+
                      "<td width=\"17%\" class=\"normalfntp2\">&nbsp;</td>"+
         "<td width=\"20%\" class=\"normalfntp2\"><img src=\"images/close.png\" alt=\"close\""+ 
		 "width=\"97\" height=\"24\" onclick=\"closeWindow();\" /></td>"+
                      "<td width=\"38%\">&nbsp;</td>"+
                    "</tr>"+
                  "</table></td>"+
                "</tr>"+
              "</table>"+
               "</td>"+
          "</tr>"+
        "</table>";
	 
	 
	 
	 var frame = document.createElement("div");
     frame.id = "CancelPOwindow";
	 document.getElementById('frmPOCancel').innerHTML=HTMLText;
	 loadSuppliers();
}

function getAcknowlegePO(pono,year,count)
{
	if(pono=="")
	{
	pono=CurrentPO;	
	}
	document.getElementById('txtfindpo').disabled = true;
 	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleAck;
	altxmlHttp.pono = pono;
	altxmlHttp.year = year;
	altxmlHttp.count = count;
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=AcknowledgePO&pono='+pono+'&year='+year+'&count='+count, true);
    altxmlHttp.send(null);  
 }

function HandleAck()
{

    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
		var ackPoHead= altxmlHttp.responseXML.getElementsByTagName("Ack")[0].childNodes[0].nodeValue;
		var ackPoDetail= altxmlHttp.responseXML.getElementsByTagName("AckDetial")[0].childNodes[0].nodeValue;
		if(ackPoHead=="TRUE" && ackPoDetail=="TRUE")
		{
				
			alert("Purchase order successfully saved.\n\nPO No : " + altxmlHttp.pono + "\nPO Year : " + altxmlHttp.year );
			
		}
		else
		{
			var pono = altxmlHttp.pono;
				var year = altxmlHttp.year;
				var count = altxmlHttp.count;
				getAcknowlegePO(pono,year,count);
			//alert("Problem occur while saving data.Please try again shortly.");	
		}
		}
		
		//closeWaitingWindow();
	}
}
function showPopUpEditPO()
{
if(document.getElementById('FindPO').style.visibility == "visible")	
{
	document.getElementById('FindPO').style.visibility = "hidden";
}
else
{
	document.getElementById('FindPO').style.visibility = "visible";
	LoadPOacSup();
}
	
}
function LoadPOacSup()
{
	clearDropDown('cboPONoFind');
	
	var suplierID=document.getElementById('cboSupFind').value;
 	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandlePOSupVice;
    thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=getPOAccSuplly&supID='+suplierID, true);
    thirdxmlHttp.send(null);  
}

function HandlePOSupVice()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "";
				document.getElementById("cboPONoFind").options.add(opt);
	
			 var poNo= thirdxmlHttp.responseXML.getElementsByTagName("PONo");
			 for ( var loop = 0; loop < poNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = poNo[loop].childNodes[0].nodeValue;
				opt.value = poNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboPONoFind").options.add(opt);
			 }
			 
		}
	}
}
	
function setValuetoPoBox()
{
	var poNo=document.getElementById("cboPONoFind").value;
	document.getElementById("txtfindpo").value=poNo;
	document.getElementById('FindPO').style.visibility = "hidden";
	
}

function LoadPOacState()
{
	clearDropDown('cboRptPONo');

	document.getElementById('gotoReport').style.visibility = "visible";
	
	var ReportState=document.getElementById('RptState').value;
	var year=document.getElementById('cboYear').value;
	var supid = document.getElementById('cborptSupplier').value;
	
 	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandlePOStateVice;
    thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=getPOAccState&state='+ReportState+'&year='+year + '&supid=' + supid, true);
    thirdxmlHttp.send(null);  
}

function HandlePOStateVice()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptPONo").options.add(opt);
	
			 var poNo= thirdxmlHttp.responseXML.getElementsByTagName("PONo");
			 for ( var loop = 0; loop < poNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = poNo[loop].childNodes[0].nodeValue;
				opt.value = poNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptPONo").options.add(opt);
			 }
			 
		}
	}
}

function showReport()
{
	///////////////////////////////// GET REPORT FOR NEW WINDOW ////////////////
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/';

	//path += "/Details/grnReport.php?grnno="+document.getElementById("txtgrnno").value+'&grnYear='+grnYear;
	////////////////////////////////////////////////////////////////////////////
	
	
	var ReportState=document.getElementById('RptState').value;
	var year=document.getElementById('cboYear').value;
	var PONo=document.getElementById('cboRptPONo').value;
	if(PONo!="0")
	{
	
		if(ReportState==1)
		{
			
			path += 'invalidPO.php?pono='+PONo+'&year='+year;			 	
		}
		else if(ReportState==10)
		{
				
			if( document.getElementById('chkNormal').checked==true)
				path += 'reportpurchase.php?pono='+PONo+'&year='+year; 
			else
				path+= 'reportpurchaseOther.php?pono='+PONo+'&year='+year;  	
		}
		else if(ReportState==11)
		{
			path+= 'cancelpo.php?pono='+PONo+'&year='+year; 
		}
	
	}
	var win2=window.open(path,'win'+pub_printWindowNo++);
}
function reportPopup()
{

if ( document.getElementById('txtfindpo').value == "")
{
	alert("Please load the relevant PO first.");
	return;
}
var PONo = document.getElementById('txtfindpo').value;
var year=document.getElementById('cboPOYearBox').value;

//window.open(reportName+"?styleID=" + styleNO,'frm_main'); 
window.open("reportpurchase.php?pono=" + PONo + "&year=" + year,'frmPO');

/*
if(document.getElementById('gotoReport').style.visibility=="hidden")
{
	document.getElementById('gotoReport').style.visibility = "visible";
	LoadPOacState();
}
	else
	{
	document.getElementById('gotoReport').style.visibility="hidden";
	return;
	}	
	
	*/
}

function ClearForNewPO()
{
	if(confirm('Are you sure you want to clear the page?'))
	{	
		document.getElementById('txtfindpo').value="";
		var tbl = document.getElementById('PoMatMain');
		var rowCount=tbl.rows.length;
		
		document.getElementById('cbocurrency').value = "";
		document.getElementById('cboSupplier').selectedIndex=0;
		document.getElementById('cbodiliverto').selectedIndex=0;
		document.getElementById('cboinvoiceto').selectedIndex=0;
		document.getElementById('cboshipment').selectedIndex=0;
		document.getElementById('cboshipmentTerm').selectedIndex=0;
		document.getElementById('cbopaymode').selectedIndex=0;
		document.getElementById('cbopayterms').selectedIndex=0;
		document.getElementById('txtpovalue').value=0;
		document.getElementById('txtpino').value="";
		
		document.getElementById('deliverydateDD').value="";
		document.getElementById('deliverydate').value="";
		document.getElementById('deliverydateETA').value="";
		document.getElementById('txtinstructions').value="";
		document.getElementById('cboSewFactory').value="";
		
		document.getElementById('imgConfirm').style.display = 'none';
		document.getElementById('butSave').style.display = 'inline';
		document.getElementById('txtfindpo').disabled = false;
		document.getElementById('cboSupplier').focus();
		pubCurrencyId=document.getElementById('cbocurrency').value;
		//alert(pubCurrencyId)
		currentStatus = 1;
		if(rowCount<2)return;
		for(var rowC=1; rowC<rowCount; rowC++)
		{
			tbl.deleteRow(1);  
		}
		savedPOYear = fullDate.getFullYear();
	}
}

function LoadMainCatMat()
{
    clearDropDown("cbomate");    
	 createtFourthXMLHttpRequest();
    fourthxmlHttp.onreadystatechange = HandleMainCat;
    fourthxmlHttp.open("GET", 'POMiddle.php?RequestType=MainCatMat', true);
    fourthxmlHttp.send(null);  
}

function HandleMainCat()
{

    if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  
			 var mainCat =fourthxmlHttp.responseXML.getElementsByTagName("Mat");
			 var mainCatID=fourthxmlHttp.responseXML.getElementsByTagName("MatID");
			 for ( var loop = 0; loop < mainCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = mainCat[loop].childNodes[0].nodeValue;
				opt.value = mainCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cbomate").options.add(opt);
			 }
			
		}
	}
}

function loadSubCat()
{
	var catID=document.getElementById('cbomate').value;
	clearDropDown("cboCategory");    
	createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = handleSubCat;
    thirdxmlHttp.open("GET", 'POMiddle.php?RequestType=SubCatMat&catID='+catID, true);
    thirdxmlHttp.send(null);  
	
}
function handleSubCat()
{
	if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			 var mainCat =thirdxmlHttp.responseXML.getElementsByTagName("SubMat");
			 var mainCatID=thirdxmlHttp.responseXML.getElementsByTagName("SubMatID");
			 for ( var loop = 0; loop < mainCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = mainCat[loop].childNodes[0].nodeValue;
				opt.value = mainCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cboCategory").options.add(opt);
			 }
			 
		}
	}

}

/*function loadItems()
{
	var mainCatID=document.getElementById('cbomate').value;
	var subCatID=document.getElementById('cboCategory').value;
	clearDropDown("cboItems");    
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = handleItems;
    altxmlHttp.open("GET", 'POMiddle.php?RequestType=ItemListMat&MaincatID='+mainCatID+'&subCat='+subCatID, true);
    altxmlHttp.send(null);  
	
}
function handleItems()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			 var mainCat =altxmlHttp.responseXML.getElementsByTagName("ItemDis");
			 var mainCatID=altxmlHttp.responseXML.getElementsByTagName("ItemID");
			 for ( var loop = 0; loop < mainCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = mainCat[loop].childNodes[0].nodeValue;
				opt.value = mainCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cboItems").options.add(opt);
			 }
			 
		}
	}
	
	
}*/

function viewStyle()
{
	clearStyleGrid();
	var matDetailID=document.getElementById('cboItems').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStyle;
    xmlHttp.open("GET", 'POMiddle.php?RequestType=styleList&matDetailID='+matDetailID, true);
    xmlHttp.send(null); 	
	
}
function handleStyle()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var styleID=xmlHttp.responseXML.getElementsByTagName("StyleID");
			for(var loop=0;loop<styleID.length;loop++)
			{
			var style= styleID[loop].childNodes[0].nodeValue;
			var buyerPO=xmlHttp.responseXML.getElementsByTagName("BuyerPONO")[loop].childNodes[0].nodeValue;
			createStyleGrid(style,buyerPO);
			}
		}
	}
}
function createStyleGrid(styleID,buyerPO)
{
	var tbl = document.getElementById('tblstyleGrid');
    var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var cellSelect = row.insertCell(0);  
	cellSelect.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkboxStyle\" id="+buyerPO+" /></div>"; 
	
	var cellStyle=row.insertCell(1);
	cellStyle.className="normalfntSM";
	cellStyle.innerHTML=styleID;
	
	
	var cellBuyerPO=row.insertCell(2);
	cellBuyerPO.className="normalfntSM";
	cellBuyerPO.innerHTML=buyerPO;
	
	
	
}

function createPopUpStyle()
{
drawPopupArea(400,370,'frmItemAddStyle');
var HTMLText="<table width=\"100%\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
 "<tr>"+
    "<td>&nbsp;</td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"22%\" height=\"233\">&nbsp;</td>"+
        "<td width=\"39%\"><form>"+
          "<table width=\"75%\" border=\"0\">"+
            "<tr>"+
              "<td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Material vice Style Select</td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"tablezRED\">"+
                "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">Material</td>"+
                  "<td width=\"47%\"><select name=\"cbomate\" class=\"txtbox\" id=\"cbomate\" style=\"width:200px\" onchange=\"loadSubCat();\"><option>Select One.</option>"+
                  "</select></td>"+
                  "<td width=\"22%\">&nbsp;</td>"+
                "</tr>"+
                "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">Category</td>"+
                  "<td><select name=\"cboCategory\" class=\"txtbox\" id=\"cboCategory\" style=\"width:200px\" onchange=\"loadItems();\">"+
                  "</select></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
                "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">Item</td>"+
                  "<td><select name=\"cboItems\" class=\"txtbox\" id=\"cboItems\" style=\"width:200px\">"+
                  "</select></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
                  "<tr>"+
                    "<td width=\"8%\" height=\"25\">&nbsp;</td>"+
                    "<td width=\"23%\" class=\"normalfnt\">&nbsp;</td>"+
                    "<td colspan=\"2\"><div align=\"right\"><img src=\"images/search.png\" width=\"80\" height=\"24\" onclick=\"viewStyle();\"/></div></td>"+
                    "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"74\"><table width=\"100%\" height=\"141\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"141\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:130px; width:350px;\">"+
                              "<table width=\"349\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblstyleGrid\">"+
                                "<tr>"+
                                  "<td width=\"43\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
                                  "<td width=\"154\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style ID</td>"+
                                  "<td width=\"150\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PO</td>"+
                                  "</tr>"+
                               
                              "</table>"+
                          "</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
             "<td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr bgcolor=\"#D6E7F5\">"+
                  "<td width=\"28%\">&nbsp;</td>"+
                  "<td width=\"18%\">&nbsp;</td>"+
                  "<td width=\"6%\">&nbsp;</td>"+
                  "<td width=\"20%\"><img src=\"images/addsmall.png\" alt=\"Add\" width=\"95\" height=\"24\" onclick=\"addDataToMainStyle();\" /></td>"+
                  "<td width=\"28%\"><input type=\"image\" name=\"imageField\" src=\"images/close.png\" /></td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"+
        "</form></td>"+
        "<td width=\"39%\">&nbsp;</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
 "<tr>"+
    "<td>&nbsp;</td>"+
  "</tr>"+
"</table>";
 var frame = document.createElement("div");
     frame.id = "itemAddStylewise";
	 document.getElementById('frmItemAddStyle').innerHTML=HTMLText;
	 LoadMainCatMat();
}
 function clearStyleGrid()
 {
 var tbl = document.getElementById('tblstyleGrid');
var rowCount=tbl.rows.length;
 	if(rowCount<=1)return;
	for(var rowC=1; rowC<rowCount; rowC++)
	{
	tbl.deleteRow(1);  
	
	}
 }
 
  function addDataToMainStyle()
 {
		
	var radio = document.getElementsByName('checkboxStyle');
	var tbl= document.getElementById('tblstyleGrid');
	var rowCount=tbl.rows.length;
	var matDetail=document.getElementById('cboItems').value;
	var styleID="";
	var buyerPO="";
	
	
	for (var ii = 0; ii < rowCount-1; ii++)
	{
		if (radio[ii].checked)
		{
			styleID+=tbl.rows[ii+1].cells[1].childNodes[0].nodeValue+ ",";
			var BuyerPP=tbl.rows[ii+1].cells[2].childNodes[0].nodeValue;
/*			if(BuyerPP.charAt(0)=="#")
			{
			buyerPO=BuyerPP.substring(1,BuyerPP.length-1);
			}*/
			buyerPO += BuyerPP + ",";
		}
		
	}

		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandlePOItems;		
		xmlHttp.open("GET", 'POMiddle.php?RequestType=POMainItemsStyle&MatID='+matDetail+'&styleID='+URLEncode(styleID)+'&buyerPO='+URLEncode(buyerPO), true);
		
	
	xmlHttp.send(null);
	//RemoveRowFromTable();
	//closeWindow(); 
 }
 
 function HandlePOItems()
 {
  if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
				var mainCatName=document.getElementById('maincategory').value;
			 	var StyleIDA =xmlHttp.responseXML.getElementsByTagName("StyleID");
				if(StyleIDA.length==0)
				{
				alert("Sorry, There is no balance Qty available with the selected item.");
				return;
				}
			 	var BuyerPOA =xmlHttp.responseXML.getElementsByTagName("BuyerPO");
			  	var ColorA =xmlHttp.responseXML.getElementsByTagName("Color");
			  	var SizeA =xmlHttp.responseXML.getElementsByTagName("Size");
				var qtyA =xmlHttp.responseXML.getElementsByTagName("Qty");
				var ItemNameA =xmlHttp.responseXML.getElementsByTagName("ItemName");
				var MainCatNameA =xmlHttp.responseXML.getElementsByTagName("MainCatName");
				var UnitA =xmlHttp.responseXML.getElementsByTagName("Unit");
				var UnitPriceA =xmlHttp.responseXML.getElementsByTagName("UnitPrice");
				var MatDetaiID=xmlHttp.responseXML.getElementsByTagName("MatDetailID");
				var intPOTypeA=xmlHttp.responseXML.getElementsByTagName("intPOType");
			 for ( var loop = 0; loop < StyleIDA.length; loop ++)
			 {
			 	var StyleID=StyleIDA[loop].childNodes[0].nodeValue;
				var BuyerPO=BuyerPOA[loop].childNodes[0].nodeValue;
				var Color=ColorA[loop].childNodes[0].nodeValue;
				var Size=SizeA[loop].childNodes[0].nodeValue;
				var qty=qtyA[loop].childNodes[0].nodeValue;
				var ItemName=ItemNameA[loop].childNodes[0].nodeValue;
				var MainCatName=mainCatName;
				var Unit=UnitA[loop].childNodes[0].nodeValue;
				var UnitPrice=UnitPriceA[loop].childNodes[0].nodeValue;
				var matID=MatDetaiID[loop].childNodes[0].nodeValue;
				var RemarksNew="";
				var intPOType=intPOTypeA[loop].childNodes[0].nodeValue;
				
				createMainGridRow(StyleID,BuyerPO,MainCatName,ItemName,Color,Unit,Size,qty,UnitPrice,UnitPrice,UnitPrice,matID,RemarksNew,POtotalQty,ItemQty,intPOType,0,null,qty);
			 }
			 convertRates();
			
			 
			 
		}
	}
	 
 }
 
 
function HandleMainCat()
{
    if(fifthxmlHttp.readyState == 4) 
    {
        if(fifthxmlHttp.status == 200) 
        {  
			 var mainCat =fifthxmlHttp.responseXML.getElementsByTagName("Catname");
			 var mainCatID=fifthxmlHttp.responseXML.getElementsByTagName("CatID");
			 for ( var loop = 0; loop < mainCat.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = mainCat[loop].childNodes[0].nodeValue;
				opt.value = mainCatID[loop].childNodes[0].nodeValue;
				document.getElementById("cboMaterial").options.add(opt);
			 }
			 loadSubCategory();
		}
	}
}

///////////////////////////////// PO REVISION ///////////////////////////////////////////////////////////////////
function showRevisePopup()
{
	 drawPopupArea(515,317,'frmPORevision');
	 var HTMLText ="<table width=\"75%\" border=\"0\" bgcolor=\"#ffffff\" align=\"left\">"+
          "<tr>"+
"<td height=\"25\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Purchase Order Revision</td>"+
          "</tr>"+
          "<tr>"+
            "<td height=\"165\">"+
            "<table width=\"100%\" height=\"165\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr>"+
       "<td width=\"100%\" height=\"26\"><table width=\"100%\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"bcgl1\">"+
                    "<tr>"+
                      "<td height=\"13\" class=\"normalfnt\">Supplier</td>"+
                      "<td colspan=\"2\" ><span class=\"normalfnt\">"+
   "<select name=\"cboSupplierCan\" class=\"txtbox\" id=\"cboSupplierCan\" style=\"width:328px\">"+ 
   "<option value=\"0\" selected=\"selected\">Select One</option>"+                         
            "</select>"+ 
                      "</span></td>"+
                      "<td width=\"23%\">&nbsp;</td>"+     
                    "</tr>"+
				   
				   
				   "<tr>"+
                      "<td width=\"21%\" height=\"12\" class=\"normalfnt\">PO No:</td>"+
                      "<td width=\"29%\"><input name=\"txtpono\" type=\"text\" class=\"txtbox\""+
					  "id=\"txtpono\" /></td>"+
                      "<td width=\"27%\">&nbsp;</td>"+
                      "<td width=\"23%\">&nbsp;</td>"+
                    "</tr>"+
                   
                    "<tr>"+
                      "<td height=\"27\" class=\"normalfnt\">Date From</td>"+
                    "<td width=\"29%\"><input name=\"CandeliverydateL\" type=\"text\" class=\"txtbox\""+ 
				   "id=\"CandeliverydateL\" size=\"15\" onmousedown=\"DisableRightClickEvent();\""+ 
					   "onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return"+ 
"ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id,'%d/%m/%Y');\"/>"+
"<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\""+   
"onclick=\"return  showCalendar(this.id, '%d/%m/%Y');\"></td>"+
                      "<td class=\"normalfnt\">to "+
                       "<input name=\"CandeliverydateDD\" type=\"text\" class=\"txtbox\""+ 
				   "id=\"CandeliverydateDD\" size=\"15\" onmousedown=\"DisableRightClickEvent();\""+ 
					   "onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return"+ 
"ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id,'%d/%m/%Y');\"/>"+
"<input type=\"reset\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;\""+   
"onclick=\"return  showCalendar(this.id, '%d/%m/%Y');\"></td>"+
					"<td ><img src=\"images/search.png\" alt=\"serch\" width=\"80\" height=\"24\""+ 
   "onclick=\"serchForCancel('revision');\" /></td>"+
                      "</tr>"+                    
                  "</table></td>"+
                "</tr>"+
                "<tr class=\"bcgl1\">"+
                  "<td><table width=\"93%\" border=\"0\" class=\"bcgl1\">"+
                    "<tr>"+
      "<td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:177px; width:500px;\">"+
          "<table width=\"490\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblCancelPO\" bgcolor=\"#CCCCFF\">"+
            "<tr>"+
           "<td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>"+
              "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
			   "<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Year</td>"+
              "<td width=\"29%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Date</td>"+
              "<td width=\"26%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO Value</td>"+
              "</tr>"+       
           "</table>"+
        "</div></td>"+
           "</tr>"+
              "</table></td>"+
                "</tr>"+
                "<tr class=\"bcgl1\">"+
                 "<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">"+
                  "<tr>"+
                      "<td width=\"25%\">&nbsp;</td>"+
                      "<td width=\"17%\" class=\"normalfntp2\">&nbsp;</td>"+
         "<td width=\"20%\" class=\"normalfntp2\"><img src=\"images/close.png\" alt=\"close\""+ 
		 "width=\"97\" height=\"24\" onclick=\"closes();\" /></td>"+
                      "<td width=\"38%\">&nbsp;</td>"+
                    "</tr>"+
                  "</table></td>"+
                "</tr>"+
              "</table>"+
               "</td>"+
          "</tr>"+
        "</table>";
	 
	 var frame = document.createElement("div");
     frame.id = "RevisionPoWindow";
	 document.getElementById('frmPORevision').innerHTML=HTMLText;
	 loadSuppliers();
	 
}
function closes()
{
	if(alloType == 'POItem')
	{
		LoadGridData();
		}
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
function closeWin(index)
{
	try
	{
		var box = document.getElementById('popupLayer'+index);
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function closedConfirmReport()
{
		document.getElementById('confirmReport').style.visibility = "hidden";
}
function viewConfirmReport()
{
	if( document.getElementById('rdoNormal').checked==true)
		window.location = 'reportpurchase.php?pono='+pub_poNo+'&year='+commonpoyear; 
	else
		window.location = 'reportpurchaseOther.php?pono='+pub_poNo+'&year='+commonpoyear;  
		
	//window.location = 'reportpurchase.php?pono='+pub_poNo+'&year='+pub_year; 
}

function ConfirmValidation(pono,year)
{

	createtFourthXMLHttpRequest();
	fourthxmlHttp.onreadystatechange = HandleConfirmValidation;
	fourthxmlHttp.open("GET", 'POMiddle.php?RequestType=ConfirmValidation&pono=' + pono + '&year=' + year, true);
    fourthxmlHttp.send(null);  			

}

function HandleConfirmValidation()
{
	if(fourthxmlHttp.readyState == 4) 
    {
        if(fourthxmlHttp.status == 200) 
        {  		
			var XMLResult =fourthxmlHttp.responseXML.getElementsByTagName("Result");
			var XMLmessage=fourthxmlHttp.responseXML.getElementsByTagName("Body");
			if (XMLResult[0].childNodes[0].nodeValue == "true")
			{
				var poNo=document.getElementById('txtfindpo').value;
				 var tbl=document.getElementById('PoMatMain');
					

				var fullDate=new Date();
				var year=fullDate.getFullYear();
				
				changeMatRatio(poNo,year);
				
						
			}
			else
			{
				alert(XMLmessage[0].childNodes[0].nodeValue);
				return false;
			}
		}
		
	}
}

function validateExrateBeforAddItem()
{
	
	if(document.getElementById("cboOrderNo").value == '' && document.getElementById("butOk").disabled == true)
	{
		alert('Please select \"Order No\".');
		document.getElementById("cboOrderNo").focus();
		return;
	}
	else if(document.getElementById('tblMatrialGrid').rows.length<=2)
	{
		alert("No items found to add.");
		return;
	}
	else
	{
		var curType=document.getElementById("cbocurrency").value;
		/*if(curType==0)
		curType="USD"; */
		//createAltXMLHttpRequest();
		//altxmlHttp.onreadystatechange = HandleExRate;
		var url = 'POMiddle.php?RequestType=getExchangeRate&curType='+URLEncode(curType);	
		var htmlobj=$.ajax({url:url,async:false});
		var Rate=htmlobj.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
		//alert(Rate);
			if(Rate != 'NA')
			{
				addDataToMain();
				
			}
			else
			{
				var cbocurrency = document.getElementById('cbocurrency').options[document.getElementById('cbocurrency').selectedIndex].text;
				alert('Exchange rate not available for '+cbocurrency);
				return;
			}
		//alert(htmlobj.responseText);
		//altxmlHttp.open("GET", 'POMiddle.php?RequestType=getExchangeRate&curType='+URLEncode(curType), true);
		//altxmlHttp.send(null);  
	}
	
}

/*function HandleExRate()
{
	//if(altxmlHttp.readyState == 4) 
    //{
       // if(altxmlHttp.status == 200) 
        //{
		var Rate=htmlobj.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;	
		alert(Rate);
			if(Rate != 'NA')
			{
				addDataToMain();
				
			}
			else
			{
				var cbocurrency = document.getElementById('cbocurrency').options[document.getElementById('cbocurrency').selectedIndex].text;
				alert('Exchange rate not available for '+cbocurrency);
				return;
			}
		//}
	//}
	
}*/

function showWaitingWindow()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = window.innerWidth + 'px';
   popupbox.style.height = window.innerHeight + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<div style=\"margin-top:300px\" align=\"center\"><img src=\"../../images/load.gif\"/></div>",
	document.body.appendChild(popupbox);
}

function closeWaitingWindow()
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

function delRow()
{
	var tblTable = 	document.getElementById("PoMatMain");	
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			alert(binCount);		
	}
}

function closeFindPO()
{
	document.getElementById('FindPO').style.visibility = "hidden";	
}

function LoadOrderNo()
{
	var styleName = document.getElementById('cboStyleNo').value; 
	var url = 'POMiddle.php?RequestType=getOrderNo&styleName='+URLEncode(styleName);
	var htmlobj=$.ajax({url:url,async:false});
	var XMLID = htmlobj.responseXML.getElementsByTagName("OrderNo");
	//alert(XMLID);
			 document.getElementById("cboOrderNo").innerHTML = XMLID[0].childNodes[0].nodeValue;
			 
	clearDropDown("cboBuyerPO");
	//clearDropDown("cboDiliveryDate");
	//clearDropDown("cboMaterial");
	//clearDropDown("cboSubCategory");
	
}

function getOrderNum()
{
	document.getElementById("cboOrderNo").value = document.getElementById("cboScNo").value;
}

function getSCNo()
{
	document.getElementById("cboScNo").value = document.getElementById("cboOrderNo").value;
}

function sendToApproval()
{
	var pono = $("#txtfindpo").val();
	var year = $("#cboPOYearBox").val();
	
	var url = 'POMiddle.php?RequestType=ConfirmValidation&pono=' + pono + '&year=' + year;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLResult =htmlobj.responseXML.getElementsByTagName("Result");
	var XMLmessage=htmlobj.responseXML.getElementsByTagName("Body");
	
	if (XMLResult[0].childNodes[0].nodeValue == "true")
	{	
		updatePOsendToAppr(pono,year);
							
	}
	else
	{
		alert(XMLmessage[0].childNodes[0].nodeValue);
		return false;
	}
}

function updatePOsendToAppr(pono,year)
{
	var url = 'POMiddle.php?RequestType=confirmSendToApprove&pono=' + pono + '&year=' + year;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLResult =htmlobj.responseXML.getElementsByTagName("State");
	
	if (XMLResult[0].childNodes[0].nodeValue == "TRUE")
	{	
		if(canConfirmPOs){
				document.getElementById('imgConfirm').style.display = 'inline';
						}	
			document.getElementById('butSave').style.display = 'none';
			document.getElementById('imgsendToApprov').style.display = 'none';
	}
	
}
function loadSubCategory(ans1)
{
	//clearDropDown("cboSubCategory");
	var styleId = $('#cboStyleNo').val();
	
	
	var url = 'POMiddle.php?RequestType=loadSubCategoryDet';
		url += '&styleId='+styleId;
		url += '&mainCatId='+ans1;
		
	var htmlobj=$.ajax({url:url,async:false});
	var XMLResult =htmlobj.responseXML.getElementsByTagName("subCatID")[0].childNodes[0].nodeValue;
	
	$("#cboSubCategory").html(XMLResult);
	
}

function checkAll(obj)
{
	var tbl = document.getElementById('tblMatrialGrid');	
	if(obj.checked)
	{
		
		for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
		{
			if(!(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].disabled))
			 	tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = true;
			
		}
	}
	else
	{
		for ( var loop = 2 ;loop < tbl.rows.length ; loop ++ )
		{
			 tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = false;
			
		}
	}
}

function OpenCopyInstruPopUp()
{
	showBackGround('divBG',0);
	var url = 'popupcopypoinstruction.php?';
	var htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(320,178,'frmOpenCopyInstruPopUp',1);
	document.getElementById('frmOpenCopyInstruPopUp').innerHTML = htmlobj.responseText;
	LoadInstruPOPopup()
}

function LoadInstruPOPopup()
{
	var url					='podb.php?RequestType=URLLoadInstruPOPopup';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$( "#txtInPopPoNo" ).autocomplete({
		source: pub_po_arr
	});
}

function LoadPoInstruction(obj,evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 13)
	{
		var url	 = 'podb.php?RequestType=URLLoadPoInstruction';
			url += '&PoNo='+URLEncode(obj.value);
		var htmlobj	= $.ajax({url:url,async:false});
		document.getElementById('txtPopUpIntro').value = htmlobj.responseText;
	}
}

function LoadPoInstructionOnBlur(obj)
{
	var url	 = 'podb.php?RequestType=URLLoadPoInstruction';
		url += '&PoNo='+URLEncode(obj.value);
	var htmlobj	= $.ajax({url:url,async:false});
	document.getElementById('txtPopUpIntro').value = htmlobj.responseText;
}

function CopyIntroToMain(obj)
{
	document.getElementById('txtinstructions').value = document.getElementById('txtPopUpIntro').value;
	ClosePoPopUp('popupLayer1');
}

function ClosePoPopUp(LayerId)
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

function openItemMvPopup(obj)
{
	var styleId = document.getElementById("cboOrderNo").value;
	var buyerPO = URLEncode(document.getElementById("cboBuyerPO").value);
	var rw = obj.parentNode.parentNode;
	var matDetailId = rw.cells[1].id;
	var itemDesc = URLEncode(rw.cells[1].innerHTML);
	var color = URLEncode(rw.cells[2].innerHTML);
	var size = URLEncode(rw.cells[3].innerHTML);
	
	var url = 'poItemMovement.php?styleId='+styleId+'&matDetailId='+matDetailId+'&itemDesc='+itemDesc+'&color='+color;
		url += '&size='+size+'&buyerPO='+buyerPO;
	var htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(700,420,'frmOpenItemMovementPopUp',20);
	document.getElementById('frmOpenItemMovementPopUp').innerHTML = htmlobj.responseText;	
}

function openPOReport(intYear,PoNo)
{
	window.open("poConfirmReport.php?pono=" + PoNo + "&year=" + intYear);
}

function openStockPopup(obj)
{
	var styleId = document.getElementById("cboOrderNo").value;
	var buyerPO = URLEncode(document.getElementById("cboBuyerPO").value);
	var rw = obj.parentNode.parentNode;
	var alloID = obj.parentNode.id;
	var matDetailId = rw.cells[1].id;
	var itemDesc = URLEncode(rw.cells[1].innerHTML);
	var color = URLEncode(rw.cells[2].innerHTML);
	var size = URLEncode(rw.cells[3].innerHTML);
	
	var url = 'poStockMovement.php?styleId='+styleId+'&matDetailId='+matDetailId+'&itemDesc='+itemDesc+'&color='+color;
		url += '&size='+size+'&buyerPO='+buyerPO+'&alloID='+alloID;
	var htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(365,265,'frmOpenItemStockMovementPopUp',25);
	document.getElementById('frmOpenItemStockMovementPopUp').innerHTML = htmlobj.responseText;	
}
//************************************************************************************************************
function checkedAll(obj)
{
	var tbl = document.getElementById('tblStyleDetails');	
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(!(tbl.rows[loop].cells[0].childNodes[0].disabled))
			 	tbl.rows[loop].cells[0].childNodes[0].checked = true;
			
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			 tbl.rows[loop].cells[0].childNodes[0].checked = false;
			
		}
	}
}
//***********************************************************************************************************
function findDuplicates()
{
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	var styleno      = document.getElementById('styleno').value;
	var ext = 0;
	var rowCount = tblStyleDetails.rows.length;
	for(loop=1;loop<tblStyleDetails.rows.length;loop++)
	{
		var styleNo=tblStyleDetails.rows[loop].cells[1].id;
		if(styleno==styleNo)
		{
			ext=1;
			alert("Record Allready Exit!");
			tblStyleDetails.deleteRow(loop);
					rowCount--;
					loop--;
			break;
			
			
		}
	}
}
//********************************************************************************************************
function removeExistingRowValues1()
{
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	var i = 0;
	
	for(i=tblStyleDetails.rows.length; i>1; i--)
	{
		tblStyleDetails.deleteRow(i-1);
	}
}
function removeExistingRowValues2()
{
	var tbl =document.getElementById('tblStyleDetails');
	var i = 0;
	
	for(i=tbl.rows.length; i>1; i--)
	{
		tbl.deleteRow(i-1);
	}
}
//************************************************************************************************************

function loadDetails()
{
	var buyer        = document.getElementById('buyer').value; 
	var url = 'POMiddle.php?RequestType=loadDetails&buyer='+buyer;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLseasons  = htmlobj.responseXML.getElementsByTagName("SEASONS");
		document.getElementById("season").innerHTML = XMLseasons[0].childNodes[0].nodeValue;
}

function loadStyleDetails()
{
	var buyers        = document.getElementById('buyer').value; 
	var url = 'POMiddle.php?RequestType=loadStyleDetails&buyers='+buyers;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLstyle  = htmlobj.responseXML.getElementsByTagName("STYLE");
		document.getElementById("styleno").innerHTML = XMLstyle[0].childNodes[0].nodeValue;
}

function loadOrderDetails()
{
	var buyer1        = document.getElementById('buyer').value; 
	var url = 'POMiddle.php?RequestType=loadOrderDetails&buyer1='+buyer1;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLorder  = htmlobj.responseXML.getElementsByTagName("ORDER");
		document.getElementById("orderno").innerHTML = XMLorder[0].childNodes[0].nodeValue;
}

function loadScNoDetails()
{
	var buyersdetails1        = document.getElementById('buyer').value; 
	var url = 'POMiddle.php?RequestType=loadSCDetails&buyersdetails1='+buyersdetails1;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLscNo  = htmlobj.responseXML.getElementsByTagName("SCNO");
		document.getElementById("scno").innerHTML = XMLscNo[0].childNodes[0].nodeValue;
}

function loadMainCatDetails()
{
	var buyer2        = document.getElementById('buyer').value; 
	var url = 'POMiddle.php?RequestType=loadMainDetails&buyer2='+buyer2;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLStyleno  = htmlobj.responseXML.getElementsByTagName("STYLENOS");
		document.getElementById("maincategory").innerHTML = XMLStyleno[0].childNodes[0].nodeValue;
}

function loadSubCatDetails()
{
	var mainCat        = document.getElementById('maincategory').value;
	//alert(mainCat);
	var buyer3        = document.getElementById('buyer').value; 
	//alert(buyer3);
	var url = 'POMiddle.php?RequestType=loadSubDetails&mainCat='+mainCat+'&buyer3='+buyer3;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLmainCat  = htmlobj.responseXML.getElementsByTagName("MAINCAT");
		document.getElementById("subcategorys").innerHTML = XMLmainCat[0].childNodes[0].nodeValue;
}

function loadSubCatDetails1()
{
	var mainCat1        = document.getElementById('maincategory').value;
	//alert(mainCat);
	//var buyer3        = document.getElementById('buyer').value; 
	//alert(buyer3);
	var url = 'POMiddle.php?RequestType=loadSubDetails1&mainCat1='+mainCat1;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLmainCat  = htmlobj.responseXML.getElementsByTagName("MAINCAT");
		document.getElementById("subcategorys").innerHTML = XMLmainCat[0].childNodes[0].nodeValue;
}

function loadItems()
{
	
	var subcategory = document.getElementById('cboSubCategory').value; 
	var cboStyleNo = document.getElementById('cboStyleNo').value; 
	var url = 'POMiddle.php?RequestType=loadItems&subcategory='+URLEncode(subcategory)+'&cboStyleNo='+cboStyleNo;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLItems = htmlobj.responseXML.getElementsByTagName("ITEMS");
	//alert(htmlobj.responseText);
			 document.getElementById("cboItems").innerHTML = XMLItems[0].childNodes[0].nodeValue;
}

function loadSeason()
{
	var stylens        = document.getElementById('styleno').value; 
	var url = 'POMiddle.php?RequestType=loadseason&stylens='+stylens;	
		var htmlobj=$.ajax({url:url,async:false});
		var XMLSeason  = htmlobj.responseXML.getElementsByTagName("SEASON");
		document.getElementById("season").innerHTML = XMLSeason[0].childNodes[0].nodeValue;
}

function loadDate()
{
	var styleNos        = document.getElementById('styleno').value; 
	var url = 'POMiddle.php?RequestType=loadDate&styleNos='+styleNos;	
		var htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		var XMLDate   = htmlobj.responseXML.getElementsByTagName("Date1");
		var XMLDate1  = htmlobj.responseXML.getElementsByTagName("Date11");
		document.getElementById("Date").value = XMLDate[0].childNodes[0].nodeValue;
		document.getElementById("Date1").value = XMLDate1[0].childNodes[0].nodeValue;
}

//*************************************************************************************************

function viewData()
{
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	for(var n = 1; n < tblStyleDetails.rows.length; n++)
	{
		if(tblStyleDetails.rows[n].cells[0].lastChild.checked == true)
		{
			var StyleNo = tblStyleDetails.rows[n].cells[1].id;
			
			var path = "POMiddle.php?RequestType=loadData";
	   		    path += "&StyleNo="+StyleNo;

			htmlobj=$.ajax({url:path,async:false});
			var tblMatrialGrid =document.getElementById('tblMatrialGrid');
	//removeExistingValues();
	var XMLselectBx= htmlobj.responseXML.getElementsByTagName("selectBox");
	var XMLDescrip = htmlobj.responseXML.getElementsByTagName("Description");
	var XMLColor   = htmlobj.responseXML.getElementsByTagName("Color");
	var XMLSize    = htmlobj.responseXML.getElementsByTagName("size");
	var XMLQty     = htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLPending = htmlobj.responseXML.getElementsByTagName("Pending");
	var XMLBulk    = htmlobj.responseXML.getElementsByTagName("Bulk");
	var XMLLeft    = htmlobj.responseXML.getElementsByTagName("LeftStock");
	var XMLLiabilty= htmlobj.responseXML.getElementsByTagName("Liabiltiy");
	var XMLAllocat = htmlobj.responseXML.getElementsByTagName("Allocation");
	
	for(var x=0;x<XMLDescrip.length;x++)
	{ 
				var newRow = tblMatrialGrid.insertRow(x+2);
				
				var selectItem        = tblMatrialGrid.rows[x+2].insertCell(0);
				selectItem.class      ="normalfntMid";
				selectItem.align      ="center";
				selectItem.innerHTML  = "<input type=\"checkbox\" style='width:20px;' align=\"center\" class=\"txtbox\"\"/>";
				
				var style             = tblMatrialGrid.rows[x+2].insertCell(1);
				style.class           ="normalfntMid";
				style.align           ="left";
				style.innerHTML       = XMLDescrip[x].childNodes[0].nodeValue;
		
				var order             = tblMatrialGrid.rows[x+2].insertCell(2);
				order.class           ="normalfntMid";
				order.align           ="left";
				order.innerHTML       = XMLColor[x].childNodes[0].nodeValue;
				
				var color             = tblMatrialGrid.rows[x+2].insertCell(3);
				color.class           ="normalfntMid";
				color.align           ="center";
				color.innerHTML       = XMLSize[x].childNodes[0].nodeValue;
				
				var size              = tblMatrialGrid.rows[x+2].insertCell(4);
				size.class            ="normalfntMid";
				size.align            ="center";				
				size.innerHTML        = XMLQty[x].childNodes[0].nodeValue;
				
				var cutNo             = tblMatrialGrid.rows[x+2].insertCell(5);
				cutNo.class           ="normalfntMid";
				cutNo.align           ="center";
				cutNo.innerHTML       = XMLPending[x].childNodes[0].nodeValue;
				
				var compo             = tblMatrialGrid.rows[x+2].insertCell(6);
				compo.class           ="normalfntMid";
				compo.align           ="center";
				compo.innerHTML       = XMLBulk[x].childNodes[0].nodeValue;
				
				var bundle            = tblMatrialGrid.rows[x+2].insertCell(7);
				bundle.class          ="normalfntMid";
				bundle.align          ="center";
				bundle.innerHTML      = XMLLeft[x].childNodes[0].nodeValue;
				
				var range             = tblMatrialGrid.rows[x+2].insertCell(8);
				range.class           ="normalfntMid";
				range.align           ="center";
				range.innerHTML       = XMLLiabilty[x].childNodes[0].nodeValue;
				
				var qty               = tblMatrialGrid.rows[x+2].insertCell(9);
				qty.class             ="normalfntMid";
				qty.align             ="right";
				qty.innerHTML         = XMLAllocat[x].childNodes[0].nodeValue;
	      }
				
		}
	}
	
}
function removeExistingValues()
{
	var tblMatrialGrid = document.getElementById('tblMatrialGrid');

	var i = 0;
	
	for(i=tblMatrialGrid.rows.length; i>2; i--)
	{
		tblMatrialGrid.deleteRow(i-1);
	}
}
//****************************************************************************************************
function LoadStyleNo()
{
	var buyer = document.getElementById('cboBuyer').value; 
	var url = 'POMiddle.php?RequestType=getStyleNO&buyer='+URLEncode(buyer);
	var htmlobj=$.ajax({url:url,async:false});
	var XMLID = htmlobj.responseXML.getElementsByTagName("StyleNo");
	//alert(XMLID);
			 document.getElementById("cboStyleNo").innerHTML = XMLID[0].childNodes[0].nodeValue;
			 
	//clearDropDown("cboBuyerPO");
	//clearDropDown("cboDiliveryDate");
	clearDropDown("cboMaterial");
	clearDropDown("cboSubCategory");
	
}
function dsableOkBtton()
{
	var style=document.getElementById("cboStyleNo").value;
	var order=document.getElementById("cboOrderNo").value;
	var scNo =document.getElementById("cboScNo").value;
	
	if(style!="")
	{
		removeExistingRowValues1();
	}
	if(order!="")
	{
		removeExistingRowValues1();
	}
}

function showOrderDetails()
{
	removeExistingRowValues1();
	var buyer        = document.getElementById('cboBuyer').value;
	var season       = document.getElementById('cboSeason').value;
	var mainCat        = document.getElementById('cboMaterial').value;
	var subCat         = document.getElementById('cboSubCategory').value;
	var items          = document.getElementById('cboItems').value;
	
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	
	var url = 'POMiddle.php?RequestType=showorderDetails&buyer='+buyer+'&season='+season+'&mainCat='+mainCat+'&subCat='+subCat+'&items='+items;
	var htmlobj=$.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	var XMLselect  = htmlobj.responseXML.getElementsByTagName("selectBox");
	var XMLstyleNo = htmlobj.responseXML.getElementsByTagName("styleNo");
	var XMLstyleId = htmlobj.responseXML.getElementsByTagName("styleID");
	var XMLorderNo = htmlobj.responseXML.getElementsByTagName("orderNo");

	for(var x=0;x<XMLstyleNo.length;x++)
	{
		var selectBox=XMLselect[x].childNodes[0].nodeValue;
		var styleNo  =XMLstyleNo[x].childNodes[0].nodeValue;
		var styleId  =XMLstyleId[x].childNodes[0].nodeValue;
		var orders    =XMLorderNo[x].childNodes[0].nodeValue;
	
		var tblStyleDetails =document.getElementById('tblStyleDetails');
		var lastRow = tblStyleDetails.rows.length;	
	    var row = tblStyleDetails.insertRow(lastRow);
	    row.className = "bcgcolor-tblrowWhite";
		
		var selectBox = row.insertCell(0);   
	    selectBox.className = "normalfntMid";
	    selectBox.innerHTML = "<input type='checkbox' id='styleCheck' name='styleCheck' checked='checked' />";
		
		var style = row.insertCell(1);  
	    style.id  =styleId; 
	    style.height = 18;
	    style.className = "normalfnt";
	    style.innerHTML =  styleNo;
		
		var order= row.insertCell(2); 
	    order.className = "normalfnt";
	    order.innerHTML =  orders;
	
	}
}
function findDuplicates()
{
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	var styleno      = document.getElementById('cboStyleNo').value;
	var ext = 0;
	var rowCount = tblStyleDetails.rows.length;
	for(loop=1;loop<tblStyleDetails.rows.length;loop++)
	{
		var styleNo=tblStyleDetails.rows[loop].cells[1].id;
		if(styleno==styleNo)
		{
			ext=1;
			alert("Record Allready Exit!");
			tblStyleDetails.deleteRow(loop);
					rowCount--;
					loop--;
			break;
			
			
		}
	}
}
function removeExistingRowValues1()
{
	var tblStyleDetails =document.getElementById('tblStyleDetails');
	var i = 0;
	
	for(i=tblStyleDetails.rows.length; i>1; i--)
	{
		tblStyleDetails.deleteRow(i-1);
	}
}

function checkedAll(obj)
{
	var tbl = document.getElementById('tblStyleDetails');	
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(!(tbl.rows[loop].cells[0].childNodes[0].disabled))
			 	tbl.rows[loop].cells[0].childNodes[0].checked = true;
			
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			 tbl.rows[loop].cells[0].childNodes[0].checked = false;
			
		}
	}
}
function new1()
{
   var postate=0;
   RemoveRowFromTable();
   document.getElementsByName('chkAll')[0].checked = false;
   
   // ========================================================
   // Add On - 10/26/2015
   // Add By - Nalin Jayakody
   // Adding - Check if selected all buyer po's or not
   // ========================================================
   var chkAllBPONo = false;//$("#chkAllPO").is(":checked");
   // ========================================================
   
   if(document.getElementById("cboOrderNo").value == '' && document.getElementById("butOk").disabled == true)
	{
		alert('Please select \"Order No\"');
		document.getElementById("cboOrderNo").focus();
		return;
	}
	else
	{
	   if(document.getElementById('txtDate').value == "" && document.getElementById('cboMaterial').value != 4)
	   {
			alert("There is no valid delivery schedule available for this Style. \nPlease use BOM to reschedule your style delivery.");   
			return false;
	   }
		var material=document.getElementById('cboMaterial').value;
		var subCat  = document.getElementById('cboSubCategory').value;
		var items   =document.getElementById('cboItems').value;
		var tblTable = document.getElementById('tblStyleDetails');
		
        if(tblTable.rows.length !=1)
         {
	      for(var n = 1; n < tblTable.rows.length; n++)
	       {
		    if(tblTable.rows[n].cells[0].lastChild.checked == true)
		     {
			   var StyleID = tblTable.rows[n].cells[1].id;
				
			   var path = "POMiddle.php?RequestType=GetItemDis1";
	   		    path += "&StyleID="+StyleID;

			    htmlobj=$.ajax({url:path,async:false});
				//alert(htmlobj.responseText);
			    var ItemID =htmlobj.responseXML.getElementsByTagName("ItemID");
			     if(ItemID.length>0)
			      {
				   var style=htmlobj.responseXML.getElementsByTagName("StyleId");
				   var Item=htmlobj.responseXML.getElementsByTagName("ItemName");
				//start 2010-09-10 check common stock leftover & Bulk availability
				   var ItemLeftOverQty = htmlobj.responseXML.getElementsByTagName("ItemLeftOverQty");
				   var ItemBulkQty     = htmlobj.responseXML.getElementsByTagName("ItemBulkQty");
				   var XMLcolor = htmlobj.responseXML.getElementsByTagName("Color");
				   var XMLsize = htmlobj.responseXML.getElementsByTagName("Size");
				   var XMLpendingQty = htmlobj.responseXML.getElementsByTagName("pendingQty");
				   var XMLunitprice = htmlobj.responseXML.getElementsByTagName("unitprice");
				   var XMLfreight = htmlobj.responseXML.getElementsByTagName("dblfreight");
				   var XMLQty = htmlobj.responseXML.getElementsByTagName("totQty");
				   var XMLLiabilityQty = htmlobj.responseXML.getElementsByTagName("liabilityQty");
				//end----------------------------------------------------
				    for ( var loop = 0; loop < Item.length; loop ++)
				     {
					  var itemSubID=ItemID[loop].childNodes[0].nodeValue;
					  var styleId=style[loop].childNodes[0].nodeValue;
					  var itemSubDetail=Item[loop].childNodes[0].nodeValue;
					  var lQty   = ItemLeftOverQty[loop].childNodes[0].nodeValue;
					  var BQty   = ItemBulkQty[loop].childNodes[0].nodeValue;
					  var color  =  XMLcolor[loop].childNodes[0].nodeValue;
					  var size   =  XMLsize[loop].childNodes[0].nodeValue;
					  var qty    =  XMLpendingQty[loop].childNodes[0].nodeValue;
					  var unitprice = XMLunitprice[loop].childNodes[0].nodeValue;
					  var freight = XMLfreight[loop].childNodes[0].nodeValue;
					  var totQty = XMLQty[loop].childNodes[0].nodeValue;
					  var liabilityQty = XMLLiabilityQty[loop].childNodes[0].nodeValue;
					  createGrid(itemSubID,styleId,itemSubDetail,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty);
				     }
			      }
		       }
	        }
        }
		else
		 {
	      var styleNo = document.getElementById('cboStyleNo').value;
	      var orderNo = document.getElementById('cboOrderNo').value;
	      var scNo    = document.getElementById('cboScNo').value;
		  var mainCat = document.getElementById('cboMaterial').value;
	      var subCat  = document.getElementById('cboSubCategory').value;
	      var itemList= document.getElementById('cboItems').value;
		  // ========================================================
		  // Add On - 10/26/2015
		  // Add By - Nalin Jayakody
		  // Adding - Add buyer PO number to the variable
		  // ========================================================
		  var buyerPOArray 		= $("#cboBuyerPO").val();
		  if(!buyerPOArray){alert('Please select buyer po numbers from the list '); return;}
		  // ========================================================
		   
		  // ========================================================
		  // Change On - 10/26/2015
		  // Change By - Nalin Jayakody
		  // Change    - To add buyer po number to the query string for
		  //             retrievew and facilitate raw materials by buyer po wise
		  // ======================================================== 
		   
	       /* var path = "POMiddle.php?RequestType=GetItemDis11";
	   		    path += "&styleNo="+styleNo+'&orderNo='+orderNo+'&scNo='+scNo+'&mainCat='+mainCat+'&subCat='+subCat+'&itemList='+itemList; */
		  // ========================================================
		for(arrLen = 0; arrLen < buyerPOArray.length; arrLen++){
		  var buyerPO = buyerPOArray[arrLen];	
		  //alert(buyerPO);
		  var path = "POMiddle.php?RequestType=GetItemDis11";
	   		  path += "&styleNo="+styleNo+'&orderNo='+orderNo+'&scNo='+scNo+'&mainCat='+mainCat+'&subCat='+subCat+'&itemList='+itemList+'&buyerpo='+URLEncode(buyerPO)+'&chkallbpo='+chkAllBPONo; 		

			var htmlobj=$.ajax({url:path,async:false});
			//alert(htmlobj.responseText);
			 var ItemID =htmlobj.responseXML.getElementsByTagName("ItemID");
			 //alert(htmlobj.responseText);
			  if(ItemID.length>0)
			   {
				 var style			= htmlobj.responseXML.getElementsByTagName("StyleId");
				 var Item			= htmlobj.responseXML.getElementsByTagName("ItemName");
				//start 2010-09-10 check common stock leftover & Bulk availability
				var ItemLeftOverQty = htmlobj.responseXML.getElementsByTagName("ItemLeftOverQty");
				var ItemBulkQty     = htmlobj.responseXML.getElementsByTagName("ItemBulkQty");
				var XMLcolor 		= htmlobj.responseXML.getElementsByTagName("Color");
				var XMLsize 		= htmlobj.responseXML.getElementsByTagName("Size");
				var XMLpendingQty 	= htmlobj.responseXML.getElementsByTagName("pendingQty");
				var XMLunitprice 	= htmlobj.responseXML.getElementsByTagName("unitprice");
				var XMLfreight 		= htmlobj.responseXML.getElementsByTagName("dblfreight");
				var XMLQty 			= htmlobj.responseXML.getElementsByTagName("totQty");
				var XMLLiabilityQty = htmlobj.responseXML.getElementsByTagName("liabilityQty");
				var XMLBuyerPONo	= htmlobj.responseXML.getElementsByTagName("buyerpono");
				//end----------------------------------------------------
				 for ( var loop = 0; loop < Item.length; loop ++)
				 {
					var itemSubID		= ItemID[loop].childNodes[0].nodeValue;
					var styleId			= style[loop].childNodes[0].nodeValue;
					var itemSubDetail	= Item[loop].childNodes[0].nodeValue;
					var lQty   			= ItemLeftOverQty[loop].childNodes[0].nodeValue;
					var BQty   			= ItemBulkQty[loop].childNodes[0].nodeValue;
					var color  			= XMLcolor[loop].childNodes[0].nodeValue;
					var size   			= XMLsize[loop].childNodes[0].nodeValue;
					var qty    			= XMLpendingQty[loop].childNodes[0].nodeValue;
					var unitprice 		= XMLunitprice[loop].childNodes[0].nodeValue;
					var freight 		= XMLfreight[loop].childNodes[0].nodeValue;
					var totQty 			= XMLQty[loop].childNodes[0].nodeValue;
					var liabilityQty 	= XMLLiabilityQty[loop].childNodes[0].nodeValue;
					var buyerPONo		= XMLBuyerPONo[loop].childNodes[0].nodeValue;
					createGrid1(itemSubID,styleId,itemSubDetail,lQty,BQty,color,size,qty,unitprice,freight,totQty,liabilityQty,buyerPONo);
				 }
			 }
		   }
		}
    }
}

function changedeliveryDate()
{
	//alert("111");
	var styleID=document.getElementById('deliverydateDD').value; 
	//alert(styleID);
		var tbl = document.getElementById('PoMatMain');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			 var styleNo = tbl.rows[loop].cells[16].childNodes[0].value;
			 //alert(styleNo);
			 tbl.rows[loop].cells[16].childNodes[0].value = document.getElementById('deliverydateDD').value;
			// alert(tbl.rows[loop].cells[16].childNodes[0].value);
		}
}

