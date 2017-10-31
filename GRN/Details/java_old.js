//tables
//1.tblMainGrn
//2.tblMainBin
//3.tblItem
//4.tblBins
//5.tblSecondbin
var pub_i=0;
var pub_grnFactory=0;
var pub_itemRowColor = '';
var pub_printWindowNo = 0;
var pub_ActiveCommonBins=0;


var nextGrnIndex=0;
var grnRowIndex = 0;
//var nextBinIndex=0;


var xmlHttp;
var xmlHttpCommit;
var xmlHttpRollBack;
var xmlHttp5;
var xmlHttp3;
var xmlHttp4;
var xmlHttp1 		= [];
var xmlHttp2 		= [];
var xmlHttpAutoBin	= [];
var xmlHttpSearchPo;

var count 	= 0;
var intMax = 0;

var intItemRowCount=0;

var pub_intSubCatNo=0;
var pub_intRow=0;
var pub_dblBinLoadQty=0;
var pub_intGrnNo=0;
var pub_intGrnYear=0;
var pub_intxmlHttp_count=0;
var pub_binCount = 0;

var pub_TotalSelectedValue=0;


	var	pub_detailsSaveDone = 	0;
	var	pub_binSaveDone		=	0;
	var allErrors			= 	0;



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

function createXMLHttpRequestSearchPo() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSearchPo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSearchPo = new XMLHttpRequest();
    }
}

function createXMLHttpRequest5() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp5 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp5 = new XMLHttpRequest();
    }
}

function createXMLHttpRequest4() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp4 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp4 = new XMLHttpRequest();
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
function LoadPo()
{
	
	RemovePo();
	
	var strPiNo			= document.getElementById('txtpino').value;
	var strSupplierID	= document.getElementById('cbosuplier').value;
	
	var dtDateFrom = "";
	var dtDateTo	="";
	if(document.getElementById("fromDate").value!="")
	{
	    dtDateFrom		= (document.getElementById("fromDate").value).split("/")[2]+"-"+(document.getElementById("fromDate").value).split("/")[1]+"-"+(document.getElementById("fromDate").value).split("/")[0];
	}
	
	if(document.getElementById("toDate").value!="")
	{
	var dtDateTo		= (document.getElementById("toDate").value).split("/")[2]+"-"+(document.getElementById("toDate").value).split("/")[1]+"-"+(document.getElementById("toDate").value).split("/")[0];
	}
	
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = PoRequest;
    xmlHttp.open("GET", 'xml.php?id=po-search&strPiNo='+strPiNo+'&strSupplierID='+strSupplierID+'&dtDateFrom='+dtDateFrom+'&dtDateTo='+dtDateTo, true);
    xmlHttp.send(null); 
	//alert(dtDateFrom);
}
function newPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
	document.getElementById("butReport").style.visibility="hidden";
	
}
function dateDisable(objChk)
{
		if(!objChk.checked)
		{
			document.getElementById("fromDate").disabled= true;
			document.getElementById("fromDate").value="";
			document.getElementById("toDate").disabled= true;
			document.getElementById("toDate").value="";
		}
		else
		{
			document.getElementById("fromDate").disabled=false;
			document.getElementById("toDate").disabled= false;
		}
}

function PoRequest()
{
	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 //alert(xmlHttp.responseText);
			 var XMLstrPINO = xmlHttp.responseXML.getElementsByTagName("strPINO");
			 var ListF = xmlHttp.responseXML.getElementsByTagName("ListF");
			 for ( var loop = 0; loop < XMLstrPINO.length; loop ++)
			 {
				 
				var opt = document.createElement("option");
				opt.text =  ListF[loop].childNodes[0].nodeValue;
				opt.value = XMLstrPINO[loop].childNodes[0].nodeValue;
				document.getElementById("txtpono").options.add(opt);
				
			 }
		}
	}
}

function GetSuppliers()
{    
	RemoveSuppliers();
	
	var strOrigin = document.getElementById('cbosuporigin').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = SupplierRequest;
    xmlHttp.open("GET", 'xml.php?id=supplier&value=' + strOrigin, true);
    xmlHttp.send(null); 
}

function SupplierRequest()
{
	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			
			 var XMLsupplierId = xmlHttp.responseXML.getElementsByTagName("SupplierId");
			 var XMLsupplierName = xmlHttp.responseXML.getElementsByTagName("SupplierName");
			 for ( var loop = 0; loop < XMLsupplierId.length; loop ++)
			 {
				 
				var opt = document.createElement("option");
				opt.text = XMLsupplierName[loop].childNodes[0].nodeValue;
				opt.value = XMLsupplierId[loop].childNodes[0].nodeValue;
				document.getElementById("cbosuplier").options.add(opt);
			 }
		}
	}
}

function RemoveSuppliers()
{
	var index = document.getElementById("cbosuplier").options.length;
	while(document.getElementById("cbosuplier").options.length > 0) 
	{
		index --;
		document.getElementById("cbosuplier").options[index] = null;
	}
}


//====================		BEGAIN OF LOAD SUB STORES  =======================================================================
//============================================================================================================================

function loadSubStores()
{    
	
	removeSubStores();
	
	var strMainStores = document.getElementById('cbomainstores').value;
	
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = subStoresRequest;
    xmlHttp.open("GET", 'xml.php?id=subStores&value=' + strMainStores, true);
    xmlHttp.send(null);
}

function subStoresRequest()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLsubStoresId = xmlHttp.responseXML.getElementsByTagName("strSubID");
			 var XMLsubStoresName = xmlHttp.responseXML.getElementsByTagName("strSubStoresName");
			 for ( var loop = 0; loop < XMLsubStoresId.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLsubStoresName[loop].childNodes[0].nodeValue;
				opt.value = XMLsubStoresId[loop].childNodes[0].nodeValue;
				document.getElementById("cboSubStores").options.add(opt);
			 }
		}
	}
}

function removeSubStores()
{
	var index = document.getElementById("cboSubStores").options.length;
	while(document.getElementById("cboSubStores").options.length > 0) 
	{
		index --;
		document.getElementById("cboSubStores").options[index] = null;
	}
}

//=====================             END OF LOAD SUB STORES ==========================================================================
//=====================================================================================================================================

function RemovePo()
{
	var index = document.getElementById("txtpono").options.length;
	while(document.getElementById("txtpono").options.length > 0) 
	{
		index --;
		document.getElementById("txtpono").options[index] = null;
	}
}

function removePoItems()
{
					var tblMainGrid = document.getElementById('tblMainGrn');
				var tblBinGrid  = document.getElementById('tblMainBin');
				
				tblMainGrid.innerHTML 	= 	"<tr>"+
							  "<td width=\"3%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
							  "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">SC No</td>"+
							  "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Buyer PO</td>"+
							  "<td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>"+
							  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>"+
							  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
							  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rate</td>"+
							  "<td width=\"6%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pending Qty</td>"+
							  "<td width=\"6%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rec Qty</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Excess</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Value</td>"+
							  "<td width=\"6%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Location</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Mat  ID</td>"+
							  "<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Year</td>"+
							  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No </td></tr>";
							  
				tblBinGrid.innerHTML	= "<tr>"+
										  "<td width=\"8%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin ID</td>"+
										  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Req Qty</td>"+
										  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Main Stores</td>"+
										  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Sub Stores</td>"+
										  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Location</td>"+
										  "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Bin Capacity Qty </td>"+
										  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Bin Available Qty </td>"+
										  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
										  "<td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Mat Sub Cat Id </td>"+
										  "</tr>";		
}
function ShowItems()
{
/*	if(!ValidateItemAddingForm()) 
	{
		return;
	}*/
	drawPopupArea(850,390,'frmItems');
	var HTMLText ="<table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"PopoupTitleclass\">PO Items</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\"><table width=\"100%\" height=\"25\" border=\"0\">"+
	"		  <tr>"+
	"			<td width=\"26%\" height=\"21\">Select Type</td>"+
	"			<td width=\"74%\"><select name=\"cboselect\" class=\"txtbox\" id=\"cboselect\" style=\"width:120px\">"+
	"			<option>Normal</option>"+
	"			<option>Ratio Wise</option>"+
	"			</select></td>"+
	"			</tr>"+ 
	"		</table></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"    <tr>"+
	"	<td><table class=\"bcgcolor\">"+
	"		  <td width=\"49\"><div align=\"center\" >"+
	"					<input name=\"chkCheckAll\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this)\" />"+
	"		  </div></td>"+
	"	  <td width=\"1000\" class=\"normalfnt\" id=\"tdCheckAll\">Check All </td>"+
	"	  <td width=\"20%\" class=\"normalfntLeftBlue\" >Selected Total Qty</td>"+
	"	  <td width=\"10%\" class=\"normalfnt2BITAB\" id=\"selectedTotalQty\">0</td>"+
	"	</table></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
	"	  <tr>"+
	"		<td width=\"100%\" class=\"normalfnt\"><div id=\"divItem\" style=\"overflow:scroll; height:260px; width:840px;\">"+
	"		  <table width=\"1500\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblItem\">"+
	"			<tr>"+
	"			  <td width=\"2%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
	"			  <td width=\"60%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Discription</td>"+
	"			  <td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Color</td>"+
	"			  <td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Size</td>"+
	"			  <td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Order No</td>"+
	"			  <td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Unit</td>"+
	"			  <td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Qty</td>"+
	"			  </tr>"+
	"		  </table>"+
	"		</div></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#D6E7F5\">"+
	"	  <tr>"+
	"		<td width=\"38%\" height=\"29\">&nbsp;</td>"+
	"		<td width=\"15%\"><img src=\"../../images/ok.png\" alt=\"OK\" width=\"86\" height=\"24\" onClick=\"addItemToGrn();\"/></td>"+
	"		<td width=\"10%\"><img src=\"../../images/close.png\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closeWindow();\" /></td>"+
	"		<td width=\"37%\">&nbsp;</td>"+
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table>";
	loca = -1;
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	addItems();
}

function checkAll(chk)
{
	//bookmark
	var tblItem = document.getElementById("tblItem");
	var dblTotal = 0;
	for(var loop=1;loop< tblItem.rows.length;loop++)
	{
		if(chk.checked == true)
		{
			
			tblItem.rows[loop].cells[0].childNodes[0].childNodes[1].checked= true ;
			addItemToGrn(tblItem.rows[loop].cells[0].childNodes[0].childNodes[1]);
			dblTotal += parseFloat(tblItem.rows[loop].cells[9].childNodes[0].nodeValue);
			document.getElementById("selectedTotalQty").innerHTML = dblTotal;
			//bookmark1
		}
		else
		{
			tblItem.rows[loop].cells[0].childNodes[0].childNodes[1].checked= false ;
			addItemToGrn(tblItem.rows[loop].cells[0].childNodes[0].childNodes[1]);
			document.getElementById("selectedTotalQty").innerHTML = 0;
		}
	}
}

function addItems()
{
	var strPoNo	= document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = ItemRequest;
    xmlHttp.open("GET", 'xml.php?id=addItems&value='+strPoNo, true);
    xmlHttp.send(null); 
	//alert(dtDateFrom);
}



function ItemRequest()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			try
			{
				var XMLDescription 	= xmlHttp.responseXML.getElementsByTagName("Description");
				var XMLRemarks 		= xmlHttp.responseXML.getElementsByTagName("Remarks");
				var XMLstrStyleId 	= xmlHttp.responseXML.getElementsByTagName("strStyleId");
				var XMLSCNo 	= xmlHttp.responseXML.getElementsByTagName("SCNo");
				var XMLstrUnit 		= xmlHttp.responseXML.getElementsByTagName("strUnit");
				var XMLQty 			= xmlHttp.responseXML.getElementsByTagName("Qty");
				var XMLstrColor  	= xmlHttp.responseXML.getElementsByTagName("strColor");
				var XMLstrSize		= xmlHttp.responseXML.getElementsByTagName("strSize");
				var XMLstrBuyerPONO = xmlHttp.responseXML.getElementsByTagName("strBuyerPONO");
				var XMLintMatDetailID= xmlHttp.responseXML.getElementsByTagName("intMatDetailID");
				var XMLdblUnitPrice= xmlHttp.responseXML.getElementsByTagName("dblUnitPrice");
				
				var tableText =     "			<table width=\"940\" cellpadding=\"1\" cellspacing=\"1\" id=\"tblItem\" bgcolor=\"#D9DFDD\">"+
									"			<tr >"+
									"			<td width=\"5%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
									"			<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Discription</td>"+
									"			<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Remarks</td>"+
									"			<td width=\"6%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Color</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Size</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Style No</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">SC No</td>"+
									"			<td width=\"7%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Buyer PO NO</td>"+//strBuyerPONO
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Unit</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Qty</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Mat Details ID</td>"+
									"			<td width=\"5%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Unit Price</td>"+
									"			</tr>";
				
				var strColor = "backcolorYellow";
				  for ( var loop = 0; loop < XMLDescription.length; loop++)
				  {    
				  		if(XMLQty[loop].childNodes[0].nodeValue<=0)
							 strColor = "backcolorYellow"
						else
							 strColor = "bcgcolor-tblrowWhite"
						
						//onClick=\"addItemToGrn();\"
						tableText +="			<tr class="+strColor+">"+
									"			<td ><div align=\"center\">"+
									"			<input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"rowclickColorChange(this);addItemToGrn(this);\" />"+
									"			</div></td>"+
									"			<td >"+ XMLDescription[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLRemarks[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLstrColor[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLstrSize[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLstrStyleId[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLSCNo[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLstrBuyerPONO[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLstrUnit[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLQty[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLintMatDetailID[loop].childNodes[0].nodeValue +"</td>"+
									"			<td >"+ XMLdblUnitPrice[loop].childNodes[0].nodeValue +"</td>"+
									"			</tr>"
									
				  }
				 tableText += "		    </table>";
				 document.getElementById("divItem").innerHTML = tableText;
				
			}
			catch(err)
			{
				
			}
			
		}
	}
}

function ValidateItemAddingForm()
{
	if (document.getElementById('txtpono').value == "")
	{
		alert("Please select the PO.");
		document.getElementById('txtpono').focus();
		return false;
	}
	else
		return true;
}
function RemoveRowFromVariationsTable()
{
	var td = this.parentNode;
	var tr = td.parentNode;
	tr.parentNode.removeChild(tr);
}

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
//////////////////////////////////////// $$$$$$$$$$$  Http array request $$$$$$$$$$$$$$$ \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

function removeItemFromMainGrn(styleID, ItemId,bpo, color,size)
{//bookmark
	//alert(1);	
		 var tbl = document.getElementById('tblMainGrn');

	 for (var a = 1; a < tbl.rows.length ; a++)
	 {
		 
		 var tblStyle 		= tbl.rows[a].cells[1].childNodes[0].nodeValue;
		 var tblMaterial 	= tbl.rows[a].cells[15].childNodes[0].nodeValue;
		 var tblColor 		= tbl.rows[a].cells[5].childNodes[0].nodeValue;
		 var tblSize 		= tbl.rows[a].cells[6].childNodes[0].nodeValue;
		 var tblBPO 		= tbl.rows[a].cells[3].childNodes[0].nodeValue;

		 if (tblStyle == styleID && tblMaterial == ItemId && tblBPO == bpo && tblColor == color && tblSize== size )
		{	
						var tblTable = 	document.getElementById("tblMainGrn");
	
						var grnIndexNo		 =a;//objDel.parentNode.parentNode.parentNode.id;
						//alert("grnIndexNo "+ grnIndexNo);
						tblTable.deleteRow(a);
						
			return true; 
		}
		 
	 }
	  return false;
}
function addItemToGrn(obj)
{
	//alert(123);
	if(!obj.checked)
	{
		styleID = obj.parentNode.parentNode.parentNode.cells[5].innerHTML;
		ItemId  = obj.parentNode.parentNode.parentNode.cells[10].innerHTML;
		bpo	 	= obj.parentNode.parentNode.parentNode.cells[7].innerHTML;
		color 	= obj.parentNode.parentNode.parentNode.cells[3].innerHTML;
		size	= obj.parentNode.parentNode.parentNode.cells[4].innerHTML;
		
		//styleID, ItemId,bpo, color,size
		removeItemFromMainGrn(styleID, ItemId,bpo, color,size);	
		return;
	}
	
	
	//alert(objRowId);
	var tbl = document.getElementById('tblItem');
	
	var intC=0;
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].childNodes[1].checked)
		intC++;
	}
	
	var poNo = document.getElementById('txtpono').value;
	
	intItemRowCount	= intC;
		
	var chkBx = document.getElementById('cboadd');
	var intCount=0;
	//var loop = 1
	var loop = obj.parentNode.parentNode.parentNode.rowIndex;
    //for (  ;loop < tbl.rows.length ; loop ++ )
  	//{
		var cbo = tbl.rows[loop].cells[0].childNodes[0].childNodes[1];
		if (cbo.checked) {
			//alert(loop);
			var strMatDetailId = tbl.rows[loop].cells[10].lastChild.nodeValue;
			var strColor = tbl.rows[loop].cells[3].lastChild.nodeValue;
			var strSize = tbl.rows[loop].cells[4].lastChild.nodeValue;
			var strOrderNo = tbl.rows[loop].cells[5].lastChild.nodeValue;
			var strBuyerPoNo =   tbl.rows[loop].cells[7].lastChild.nodeValue;
			if(isItemAvailable(strOrderNo,strMatDetailId,strBuyerPoNo,strColor,strSize))
			{
				//alert("Allready added this item");	
				return;
			}
			
			
			//check added item /////////////////////////
			

			
			////////////////////////////////////////////
		
		var tblGrn = document.getElementById('tblMainGrn');
		//tblGrn.deleteRow(0);
		/*var lastRow = tblGrn.rows.length;	
		var row = tblGrn.insertRow(lastRow);
		tblGrn.rows[lastRow].id = ++nextGrnIndex;*/
		//alert("Grn Line "+nextGrnIndex);
		createXMLHttpRequest1(loop);
		xmlHttp1[loop].onreadystatechange=HandleRequest;
		xmlHttp1[loop].num = loop;
	
		//xmlHttp1[loop].rowIndex = row.rowIndex;
		xmlHttp1[loop].open("GET", 'xml.php?id=addItemToGrn&strMatDetailId='+strMatDetailId+'&strColor='+URLEncode(strColor)+'&strSize='+URLEncode(strSize)+'&strOrderNo='+URLEncode(strOrderNo)+'&strBuyerPoNo='+URLEncode(strBuyerPoNo)+'&No='+loop + '&poNo=' + poNo, true);
		xmlHttp1[loop].send(null);
		
		
		//alert(tblItem.rows.length-1);
		
/*		var cellDelete = row.insertCell(0);     
		var delImage = new Image(); 
		delImage.src = "../images/del.png";
		delImage.onclick = RemoveRowFromVariationsTable;
		cellDelete.appendChild(delImage);*/
		
		//var b = row.insertCell(1);  
		//b.innerHTML = "";
		//closeWindow();
		//}

	}
}

 function isItemAvailable(styleID, ItemId,bpo, color,size)
 {//bookmark

	 var tbl = document.getElementById('tblMainGrn');

	 for (var a = 1; a < tbl.rows.length ; a++)
	 {
		 
		 var tblStyle 		= tbl.rows[a].cells[1].childNodes[0].nodeValue;
		 var tblMaterial 	= tbl.rows[a].cells[15].childNodes[0].nodeValue;
		 var tblColor 		= tbl.rows[a].cells[5].childNodes[0].nodeValue;
		 var tblSize 		= tbl.rows[a].cells[6].childNodes[0].nodeValue;
		 var tblBPO 		= tbl.rows[a].cells[3].childNodes[0].nodeValue;

		 if (tblStyle == styleID && tblMaterial == ItemId && tblBPO == bpo && tblColor == color && tblSize== size )
		{	
			alert("Item is allready allocated to line "+a);
			return true; 
		}
		 
	 }
	  return false;
 }
 
function HandleRequest()
{	
    if(xmlHttp1[this.num].readyState == 4) //this.index
    {
        if(xmlHttp1[this.num].status == 200) 
        {  
				
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("strStyleId");	
				var strStyleID = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("SCNo");	
				var strSCNo = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("Description");	
				var Description = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("strUnit");	
				var strUnit = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("dblQty");	
				var dblQty = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("strColor");	
				var strColor = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("strSize");	
				var strSize = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("strBuyerPONO");	
				var strBuyerPoNo = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("dblUnitPrice");	
				var dblUnitPrice = XMLvalue[0].childNodes[0].nodeValue;
				//alert(dblUnitPrice);
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("dblAdditionalQty");	
				var dblAdditionalQty = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("dblPending");	
				var dblPending = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("intMatDetailID");	
				var intMatDetailID = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLvalue = xmlHttp1[this.num].responseXML.getElementsByTagName("dblAdditionalPendingQty");	
				var dblAdditionalPendingQty = XMLvalue[0].childNodes[0].nodeValue;
				
				var XMLgrnExQty = xmlHttp1[this.num].responseXML.getElementsByTagName("GrnExcessQty");	
				var GrnExcessQty = XMLgrnExQty[0].childNodes[0].nodeValue;
				//alert(GrnExcessQty);
				
				//alert(dblAdditionalQty);

					
				//checking validate list
				var tbl = document.getElementById('tblMainGrn');
				
				for(var x=1;x<tbl.rows.length;x++)
				{
					if(tbl.rows[x].cells[1].lastChild.nodeValue	==	trim(strStyleID) 		&& 
					tbl.rows[x].cells[2].lastChild.nodeValue 	==	trim(strBuyerPoNo) 	&&
					tbl.rows[x].cells[3].lastChild.nodeValue	==	trim(Description) 	&& 
					tbl.rows[x].cells[4].lastChild.nodeValue	==	trim(strColor )		&& 
					tbl.rows[x].cells[5].lastChild.nodeValue	==	trim(strSize )		&& 
					tbl.rows[x].cells[6].lastChild.nodeValue	==	trim(strUnit))
					{
						alert(Description +" item is allready added.");
						return;
					}
					/*else
					{
						var x = tbl.rows[x].cells[3].lastChild.nodeValue;
						var y = trim(Description);
						if (x==y)
							alert(x +" = "+ y)
						else
							alert(x +" not = "+ y)
					}*/
					
				}
									
					var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
					
					tbl.rows[lastRow].id = ++nextGrnIndex;
					if((tbl.rows[lastRow].id % 2) == 0)
						tbl.rows[lastRow].className = 'bcgcolor-tblrow';
					else
						tbl.rows[lastRow].className = 'bcgcolor-tblrowWhite';
					//alert(1);
				var text1 =  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		  		
				  var intPoNo				= (text1[0]).split("/")[1];
				  var intYear				= (text1[0]).split("/")[0];
				
				//alert(this.rowIndex);
				//alert(tbl.rows[this.rowIndex].cells[1]);
				var strInnerHtml="";
				//strInnerHtml +="<input type=\"text\" style=\"txtbox\" value=\"" + value1 + "\">";
				if(dblAdditionalPendingQty=='')
					dblAdditionalPendingQty=0;
			  //strInnerHtml +="<tr>";
			  
              strInnerHtml +="<td><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"delRow(this)\"/></div></td>";//delete button
              strInnerHtml +="<td class=\"normalfntMid\">"+strStyleID+"</td>";				//Style No
				  strInnerHtml +="<td class=\"normalfntMid\">"+strSCNo+"</td>";				//SC No
              strInnerHtml +="<td class=\"normalfntMid\">"+strBuyerPoNo+"</td>";			//Buyer Po No
              strInnerHtml +="<td class=\"normalfnt\">"+Description+"</td>";				//Description
              strInnerHtml +="<td class=\"normalfntMidSML\">"+strColor+"</td>";				//Color
              strInnerHtml +="<td class=\"normalfntMidSML\">"+strSize+"</td>";				//Size
              strInnerHtml +="<td class=\"normalfntMid\">"+strUnit+"</td>";					//Unit
              strInnerHtml +="<td class=\"normalfntMid\">"+dblUnitPrice+"</td>";			//Rate
              strInnerHtml +="<td class=\"normalfntRite\">"+dblPending+"</td>";				//Pending Qty
strInnerHtml +="<td class=\"normalfntRite\"><input name=\"txtbatchno2\" type=\"text\" class=\"txtbox\" id=\"txtbatchno2\" size=\"10\" style=\"text-align:right\" value=\"" + dblPending + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal2(this, 4,event);\"></td>";					//Recived Qty
              strInnerHtml +="<td id="+GrnExcessQty+" class=\"normalfntMid\">0</td>";		//Excess Qty
			  strInnerHtml +="<td class=\"normalfntMid\">"+0+"</td>";	
              strInnerHtml +="<td class=\"normalfntRite\">"+Math.round((dblUnitPrice*dblPending)*1000)/1000 + "</td>";	//Value
              strInnerHtml +="<td class=\"mouseover\"><img src=\"../../images/location.png\" alt=\"Add Bin\" width=\"90\" height=\"20\" onclick=\"showBin("+intMatDetailID+",this)\" /></td>";										//Location
              strInnerHtml +="<td class=\"normalfntMid\">"+intMatDetailID+"</td>";			//Mat Cat Id
              strInnerHtml +="<td class=\"normalfntMid\">"+intYear+"</td>";					//year
              strInnerHtml +="<td class=\"normalfntMid\">"+intPoNo+"</td>";					//Po No
			  /*strInnerHtml +="<td class=\"normalfntRite\"><input name=\"txtAdditionalQty\" type=\"text\" class=\"txtbox\" id=\""+dblAdditionalPendingQty+"\" size=\"10\" style=\"text-align:right\" value=\"" + dblAdditionalPendingQty + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>";*/
            //strInnerHtml +="</tr>";
			  //alert(dblAdditionalPendingQty);
			  ///////////////// for hide columns  //////////////////////////////////
//class="mouseover"
			///////////// end of hide columns

				//tbl.rows[this.rowIndex].cells[1].innerHTML=  strInnerHtml ;
				tbl.rows[lastRow].innerHTML  	=  strInnerHtml ;
				intItemRowCount-=1;
				pub_i+=1;
				if(intItemRowCount==0)
				{
					findGrnValue(this);
				}
				
		}
	}
}

function delRow(objDel)
{
	var tblTable = 	document.getElementById("tblMainGrn");
	
	var grnIndexNo		 =objDel.parentNode.parentNode.parentNode.id;
	//alert("grnIndexNo "+ grnIndexNo);
	tblTable.deleteRow(objDel.parentNode.parentNode.parentNode.rowIndex);
	
	tblTable		= 	document.getElementById("tblMainBin");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		//alert("bin line  "+ tblTable.rows[loop].id + "==" +grnIndexNo);
		if(tblTable.rows[loop].id==grnIndexNo){
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
			
			//bookmark
		}
	}
	
}

function CheckforValidDecimal(sCell,decimalPoints,evt)
{

	var value=parseFloat(sCell.parentNode.parentNode.cells[8].lastChild.nodeValue);
	var Tqty = parseFloat(sCell.parentNode.parentNode.cells[10].lastChild.value);
	
	sCell.parentNode.parentNode.cells[13].lastChild.nodeValue=Math.round((Tqty * value)*1000)/1000;

		if(parseFloat(sCell.parentNode.parentNode.cells[9].lastChild.nodeValue-value)<0)
			sCell.parentNode.parentNode.cells[11].lastChild.nodeValue=parseFloat(value-sCell.parentNode.parentNode.cells[8].lastChild.nodeValue);
		else
			sCell.parentNode.parentNode.cells[11].lastChild.nodeValue=0;

	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

function calculation1(sCell)
{

	var maxExcessQty = parseFloat(sCell.parentNode.parentNode.cells[11].id);
	var Rate=parseFloat(sCell.parentNode.parentNode.cells[8].lastChild.nodeValue);
	var FixQty = parseFloat(sCell.parentNode.parentNode.cells[9].lastChild.nodeValue);
	var Qty = parseFloat(sCell.parentNode.parentNode.cells[10].lastChild.value);
	
	sCell.parentNode.parentNode.cells[13].lastChild.nodeValue=Math.round((Qty*Rate)*1000)/1000;
	
		if(FixQty<Qty)
		{
			if(parseFloat(Qty-FixQty)>maxExcessQty)
			{
				alert("Can't exceed maximum GRN excess qty " + maxExcessQty);
				sCell.parentNode.parentNode.cells[11].lastChild.nodeValue = maxExcessQty;
				sCell.parentNode.parentNode.cells[12].lastChild.nodeValue = 0;
				sCell.parentNode.parentNode.cells[10].lastChild.value = FixQty+maxExcessQty;
			}
			else
			{
				sCell.parentNode.parentNode.cells[11].lastChild.nodeValue=parseFloat(Qty-FixQty);
				sCell.parentNode.parentNode.cells[12].lastChild.nodeValue=0;
			}
			
		}
		else
		{
			sCell.parentNode.parentNode.cells[11].lastChild.nodeValue=0;
			sCell.parentNode.parentNode.cells[12].lastChild.nodeValue=parseFloat(FixQty-Qty);
		}
			
}


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

function createXMLHttpRequestAutoBin(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttpAutoBin[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttpAutoBin[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttpAutoBin[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

// =================================================       BIN ALLOWCATION    =========================
//=====================================================================================================

function showBin(intMatDetailID,button)
{
	//bookmark
	if(pub_ActiveCommonBins!=1)
	{
			showFrame();
			var TbinQty = parseFloat(button.parentNode.parentNode.cells[10].childNodes[0].value);
			document.getElementById("txtBinQty").value= TbinQty;
			pub_intRow=button.parentNode.parentNode.id;
			grnRowIndex= button.parentNode.parentNode.rowIndex;
			Get_meterial(intMatDetailID);
			get_allreadyAllocatedbins(pub_intRow);
			document.getElementById("txtQty2").value = get_total();
			pub_dblBinLoadQty= document.getElementById("txtQty2").value;
	}
	
}
function get_allreadyAllocatedbins(no)
{
	var tblMainBin = document.getElementById("tblMainBin");
	var tblSecondBin = document.getElementById("tblSecondbin");
	
	
	for(var loop=1;loop<tblMainBin.rows.length;loop++)
	{
		var	strBin			= tblMainBin.rows[loop].cells[0].lastChild.nodeValue;
		var binName			= tblMainBin.rows[loop].cells[9].lastChild.nodeValue;
		
		var	dblBinCapacity	= tblMainBin.rows[loop].cells[5].lastChild.nodeValue;
		var	dblBinAvailable	= tblMainBin.rows[loop].cells[6].lastChild.nodeValue;
		var	dblBinReqQty	= tblMainBin.rows[loop].cells[1].lastChild.nodeValue;
		var	strLocation		= tblMainBin.rows[loop].cells[4].lastChild.nodeValue;
		
		if(tblMainBin.rows[loop].id==no)
		{
								tblSecondBin.innerHTML += "<tr id=\""+strBin+"\">"+
											"<td><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\"/></div></td>"+
											"<td class=\"normalfntMid\">"+binName+"</td>"+
											"<td class=\"normalfntMid\">"+dblBinCapacity+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinAvailable+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinReqQty+"</td>"+
											"<td class=\"normalfntRite\">"+strLocation+"</td>"+
											"</tr>";
		}
			
	}
}
function Get_meterial(intMatDetailID)
{

    createXMLHttpRequest();
    xmlHttp.onreadystatechange = matDetailsIdRequest;
    xmlHttp.open("GET", 'xml.php?id=intMatDetailId&value='+intMatDetailID, true);
    xmlHttp.send(null); 
}

function matDetailsIdRequest()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var strMaterial = xmlHttp.responseText;
			var strValue=strMaterial.split("***");
			pub_intSubCatNo = strValue[1];
			document.getElementById("txtBinCategory").value=strValue[0];
			document.getElementById("txtBinCategory").index=strValue[1];
			Load_Locations(strValue[1]);
		}
	}
}

function Load_Locations(intSubCatId)
{
	var strMainId =	document.getElementById("cbomainstores").value;
	var strSubId = 	document.getElementById("cboSubStores").value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = locationRequest;
    xmlHttp.open("GET", 'xml.php?id=locations&strMainId='+strMainId+'&strSubId='+strSubId+'&intSubCatId='+intSubCatId, true);
    xmlHttp.send(null); 
}
function locationRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
			 var XMLstrLocID = xmlHttp.responseXML.getElementsByTagName("strLocID");
			  var XMLlocName = xmlHttp.responseXML.getElementsByTagName("locName");
			 
			 
			 for ( var loop = 0; loop < XMLstrLocID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLlocName[loop].childNodes[0].nodeValue;
				opt.value = XMLstrLocID[loop].childNodes[0].nodeValue;
				document.getElementById("cboLocation").options.add(opt);
			 }
	}
}

function showFrame()
{
	//bookmark
	drawPopupArea(505,410,'frmBinAvailability');
	var HTMLText =	"<table width=\"500\" border=\"0\" id=\"tblBinAvailability\">"+
  					"<tr>"+
		    		"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\"><table width=\"100%\" border=\"0\">"+
      				"<tr>"+
        			"<td width=\"94%\">Bin Avaliability</td>"+
        			"<td width=\"6%\">&nbsp;</td>"+
      				"</tr>"+
    				"</table>      </td>"+
  					"</tr>"+
					"<tr>"+
    				"<td><table width=\"100%\" border=\"0\">"+
      				/*"<tr>"+
        			"<td width=\"19%\"><span class=\"normalfnt\">Category</span></td>"+
        			"<td width=\"33%\" class=\"normalfnt\"><input name=\"txtBinCategory\" type=\"text\" class=\"txtbox\" id=\"txtBinCategory\" size=\"20\" onfocus=\"this.blur()\" />"+
        			"</select></td>"+
        			"<td width=\"16%\" class=\"normalfnt\">Qty</td>"+
        			"<td width=\"32%\"><span class=\"normalfnt\">"+
          			"<input name=\"txtQty\" type=\"text\" class=\"txtbox\" id=\"txtBinQty\" onfocus=\"this.blur()\" style=\"text-align:right\"  size=\"15\" />"+
          			"</select>"+
        			"</span></td>"+
      				"</tr>"+*/
					"<tr>"+
						"<td width=\"11%\"><span class=\"normalfnt\">Category</span></td>"+
						"<td width=\"13%\" class=\"normalfnt\"><input name=\"txtCategory\" type=\"text\" class=\"txtbox\" id=\"txtBinCategory\" size=\"18\" onfocus=\"this.blur()\"/></td>"+
						"<td width=\"5%\" class=\"normalfnt\">Qty</td>"+
						"<td width=\"19%\"><input name=\"txtQty\" type=\"text\" class=\"txtbox\" style=\"text-align:right\" id=\"txtBinQty\" size=\"12\" onfocus=\"this.blur()\" /></td>"+
						"<td width=\"24%\" class=\"normalfnt\">Allocated Qty </td>"+
						"<td width=\"21%\" class=\"normalfnt\"><input name=\"txtQty2\" type=\"text\" class=\"normalfnt2BITAB\" style=\"text-align:right\" id=\"txtQty2\" size=\"12\" onfocus=\"this.blur()\"></td>"+
					  "</tr>"+
    				"</table></td>"+
  					"</tr>"+
  					"<tr>"+
    				"<td><table width=\"100%\" border=\"0\" class=\"tablezRED\">"+
      				"<tr>"+
        			"<td width=\"10%\">&nbsp;</td>"+
        			"<td width=\"26%\">Location</td>"+
        			"<td width=\"34%\"><span class=\"normalfnt\">"+
          			"<select name=\"cboLocation\" class=\"txtbox\" id=\"cboLocation\" style=\"width:140px\" onchange=\"LoadBins();\">"+
          			"</select>"+
        			"</span></td>"+
        			"<td width=\"30%\"><img src=\"../../images/search.png\" alt=\"Search\" width=\"80\" height=\"24\" /></td>"+
      				"</tr>"+
    				"</table></td>"+
  					"</tr>"+
 					"<tr>"+
    				"<td height=\"164\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
      				"<tr>"+
        			"<td width=\"100%\" height=\"7\"><div id=\"divcons\" style=\"overflow:scroll; height:130px; width:500px;\">"+
          			"<table width=\"480px\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblBins\">"+
            		"<tr>"+
					 //" <td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
					 " <td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin ID</td>"+
					 " <td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Capacity Qty </td>"+
					 " <td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Available Qty </td>"+
					 " <td width=\"20%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Req Qty </td>"+
					 " <td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
					"</tr>"+
          			"</table>"+
        			"</div></td>"+
        			"</tr>"+
     				"<tr>"+
        			"<td height=\"8\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Already Allocated Bins</td>"+
      				"</tr>"+
      				"<tr>"+
        			"<td height=\"11\"><div id=\"divcons2\" style=\"overflow:scroll; height:130px; width:500px;\">"+
          			"<table width=\"520px\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblSecondbin\">"+
					"<tr>"+
					  "<td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
					  "<td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin ID</td>"+
					  "<td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Capacity Qty </td>"+
					  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Available Qty </td>"+
					  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Req Qty </td>"+
					  "<td width=\"20%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Location</td>"+
					"</tr>"+
					/*"<tr>"+
					  "<td><div align=\"center\"><img src=..//"../images/del.png/" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
					  "<td class=\"normalfntMid\">FABR</td>"+
					  "<td class=\"normalfntMid\">Pocketing</td>"+
					  "<td class=\"normalfntRite\">1212</td>"+
					  "<td class=\"normalfntRite\">1212</td>"+
					  "<td><div align=\"center\">"+
						  "<input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" />"+
					  "</div></td>"+
					"</tr>"+
            		"<tr>"+
              		"<td><div align=\"center\"><img src=..//"../images/del.png/" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
              		"<td class=\"normalfnt\">ACCE</td>"+
              		"<td class=\"normalfnt\">Zipper</td>"+
              		"<td class=\"normalfntRite\">443</td>"+
              		"<td class=\"normalfntRite\">1</td>"+
            		"</tr>"+
            		"<tr>"+
              		"<td><div align=\"center\"><img src=..//"../images/del.png/" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
              		"<td class=\"normalfnt\">ACCE</td>"+
              		"<td class=\"normalfnt\">Lable - Co Lable</td>"+
              		"<td class=\"normalfntRite\">43432</td>"+
              		"<td class=\"normalfntRite\">0.4</td>"+
            		"</tr>"+*/
          			"</table>"+
        			"</div></td>"+
      				"</tr>"+
    				"</table></td>"+
  					"</tr>"+
  					"<tr>"+
    				"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
      				"<tr>"+
        			"<td>&nbsp;</td>"+
        			"<td width=\"29%\"><img src=\"../../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onClick=\"addBinsToGrnTable();\" /></td>"+
        			"<td width=\"21%\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\"  onClick=\"closeWindow();setValue(this);\"    /></td>"+
        			"<td width=\"25%\">&nbsp;</td>"+
      				"</tr>"+
    				"</table></td>"+
  					"</tr>"+
					"</table>";
	loca = -1;
	var frame = document.createElement("div");
    frame.id = "BinAllocate";
	document.getElementById('frmBinAvailability').innerHTML=HTMLText;
}
function setValue()
{
	var tblGrn = document.getElementById("tblMainGrn");	
	if (pub_dblBinLoadQty>0)
	{
		tblGrn.rows[pub_intRow].cells[10].childNodes[0].value=pub_dblBinLoadQty;
	}

}

function LoadBins()
{
	
	var strMainId=	document.getElementById("cbomainstores").value;
	var strSubId=	document.getElementById("cboSubStores").value;
	var intLocId=	document.getElementById("cboLocation").value;
	var subCatId=	document.getElementById("txtBinCategory").index;

	//var tblBin  = document.getElementById("tblBinAvailability");
	//alert(obj.parentNode.parentNode.parentNode.cells[2].value);
	//alert(strMainStores + "  " + strSubStores + "  " + strLocationStores);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange= binsRequest;
	var url="xml.php?id=bins&strMainId="+strMainId+'&strSubId='+strSubId+'&intLocId='+intLocId+'&subCatId='+subCatId;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

function binsRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
				var XMLstrBinID 		= xmlHttp.responseXML.getElementsByTagName("strBinID");
				var XMLstrBinName 		= xmlHttp.responseXML.getElementsByTagName("strBinName");
				var XMLdblCapacityQty 	= xmlHttp.responseXML.getElementsByTagName("dblCapacityQty");
				var XMLdblFillQty 		= xmlHttp.responseXML.getElementsByTagName("dblFillQty");
				var tbl = document.getElementById('tblBins');
				
				var strInnerHtml="<table width=\"480px\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblBins\">"+
								 "<tr>"+
								 //" <td width=\"7%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
								 " <td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin ID</td>"+
								 " <td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Capacity Qty </td>"+
								 " <td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Available Qty </td>"+
								 " <td width=\"20%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Req Qty </td>"+
								 " <td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
								 "</tr>";
					
				for ( var loop = 0; loop < XMLstrBinID.length; loop++)
				  {    
				  var availableQty=XMLdblCapacityQty[loop].childNodes[0].nodeValue-XMLdblFillQty[loop].childNodes[0].nodeValue;
				  strInnerHtml += "<tr id=\""+XMLstrBinID[loop].childNodes[0].nodeValue+"\">"+
								  //"<td><div align=\"center\"><img src=..//"../images/del.png/" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
								  "<td class=\"normalfntMid\">"+XMLstrBinName[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntMid\">"+XMLdblCapacityQty[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfntRite\">"+availableQty+"</td>"+
								  "<td class=\"normalfntRite\"><input name=\"txtReqQty\" type=\"text\" class=\"txtbox\" id=\"txtReqQty\" size=\"15\" style=\"text-align:right\" value=\"0\" onkeyup=\"calculation2(this);\" onkeypress=\"return CheckforValidDecimal2(this, 4,event);\"></td>"+
/*								  "<td><div align=\"center\">"+
									  "<input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" onclick=\"addToSecondGrid(this);\"/>"+
								  "</div></td>"+*/
								  "<td>"+
									 "<div align=\"center\"><img src=\"../../images/aad.png\" alt=\"add\"  id=\"cboadd\" onclick=\"addToSecondGrid(this);\"/></div>"+
								  "</td>"+
								  "</tr>"+
								  "<tr>";
				  }
				  
				  tbl.innerHTML=  strInnerHtml ;
	
	}
}



function addBinsToGrnTable()
{	
	
	if(document.getElementById("txtQty2").value != document.getElementById("txtBinQty").value)
	{		
			dblDef = parseFloat(document.getElementById("txtBinQty").value) - parseFloat(document.getElementById("txtQty2").value );
			alert("The Qty is not Equal to Allocate Qty.\n Difference is "+dblDef );
			return;
	}
	
	var tblSecondBin = document.getElementById("tblSecondbin");
	var tblMainBin = document.getElementById("tblMainBin");
	
	if(tblMainBin.rows.length<=1)
	{
	tblMainBin.innerHTML =    "<tr>"+
							  "<td width=\"6%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin ID</td>"+
							  "<td width=\"6%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Req Qty</td>"+
							  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Main Stores</td>"+
							  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Sub Stores</td>"+
							  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Location</td>"+
							  "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Bin Capacity Qty </td>"+
							  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2R\">Bin Available Qty </td>"+
							  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
							  "<td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Mat Sub Cat Id </td>"+
							  "<td width=\"17%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin Name</td>"+
							  "</tr>";
	}

	findAndRemoveSelectedRows(pub_intRow);

	for(var loop=1;loop<tblSecondBin.rows.length;loop++)
	{		
		var tblGrn			=	document.getElementById("tblMainGrn");
		
		//this line for count of bin lines add to grn  detail line
		//tblGrn.rows[pub_intRow].id = pub_intRow;
		tblGrn.rows[grnRowIndex].count = tblSecondBin.rows.length-1;
		
		var intBinId		= 	tblSecondBin.rows[loop].id;
		
		var dblReqQty 		=	tblSecondBin.rows[loop].cells[4].lastChild.nodeValue;
		var dblCapacityQty	=	tblSecondBin.rows[loop].cells[2].lastChild.nodeValue;
		var dblAvailableQty	=	tblSecondBin.rows[loop].cells[3].lastChild.nodeValue;
		
		var strMainStores	=	document.getElementById("cbomainstores").value;
		var strSubStores	=	document.getElementById("cboSubStores").value;
		var strLocation		=	tblSecondBin.rows[loop].cells[5].lastChild.nodeValue;
		var strBin 			=	tblSecondBin.rows[loop].cells[1].lastChild.nodeValue;
		var strUnit			=	tblGrn.rows[grnRowIndex].cells[7].childNodes[0].nodeValue;
		
		
		tblMainBin.innerHTML	+="<tr>"+
								  "<td class=\"normalfntMid\">"+intBinId+"</td>"+
								  "<td class=\"normalfntRite\">"+dblReqQty+"</td>"+
								  "<td class=\"normalfntMid\">"+strMainStores+"</td>"+
								  "<td class=\"normalfntMid\">"+strSubStores+"</td>"+
								  "<td class=\"normalfntMid\">"+strLocation+"</td>"+
								  "<td class=\"normalfntRite\">"+dblCapacityQty+"</td>"+
								  "<td class=\"normalfntRite\">"+dblAvailableQty+"</td>"+
								  "<td class=\"normalfntMid\">"+strUnit+"</td>"+
								  "<td class=\"normalfntMid\">"+pub_intSubCatNo+"</td>"+
								  "<td class=\"normalfntMid\">"+strBin+"</td>"+
								  "</tr>";
		tblMainBin.rows[tblMainBin.rows.length-1].id=pub_intRow;
		//alert(tblMainBin.rows[tblMainBin.rows.length-1].id);
		//alert(tblMainBin.rows.length);
		//alert(tblMainBin.rows.length);
		//alert(tblMainBin.rows[tblMainBin.rows.length-1].id);
		
	}
	tblGrn.rows[grnRowIndex].className = "osc2";
	//tblGrn.rows[pub_intRow].cells[9].desable = true;
	closeWindow();
}

function findAndRemoveSelectedRows(no)
{
	var tblMainBin = document.getElementById("tblMainBin");
	var intRows = tblMainBin.rows.length;
	
	for(var loop=1;loop<intRows;loop++)
	{	
		var rowNo		= tblMainBin.rows[loop].id;
		if(rowNo==no){
			tblMainBin.deleteRow(loop);
			loop-=1;
			intRows-=1;
		}
			
	}
}

function addToSecondGrid(objButton)
{
		
		var objrow 		= objButton.parentNode.parentNode.parentNode;
		var intBinId	= objrow.id;
		var strBin 		= objrow.cells[0].lastChild.nodeValue;
		var dblBinCapacity 	= objrow.cells[1].lastChild.nodeValue;
		var dblBinAvailable = objrow.cells[2].lastChild.nodeValue;
		var dblBinReqQty 	= objrow.cells[3].lastChild.value;
		var strLocation 	= document.getElementById("cboLocation").value;
		
		if (dblBinReqQty<=0 ) return;
		var tblSecondBin = document.getElementById("tblSecondbin");

			var boolFound=false;
			
			
			//=======================
			var difQty = parseFloat(document.getElementById("txtBinQty").value) - get_total()-parseFloat(objrow.cells[3].lastChild.value);
			if(difQty<0)
			{
				alert("You can't exceed qty of " + document.getElementById("txtBinQty").value);
				return;
			}
			//=======================
					for(var loop=1;loop<tblSecondBin.rows.length;loop++)
					{
						if((tblSecondBin.rows[loop].cells[1].lastChild.nodeValue==strBin) && (tblSecondBin.rows[loop].cells[5].lastChild.nodeValue==strLocation))
						{
							
							var dblSubTotal = parseFloat(tblSecondBin.rows[loop].cells[4].lastChild.nodeValue)+parseFloat(dblBinReqQty);
							var dblSubAvailable = dblBinAvailable-dblSubTotal; 
							if (dblSubAvailable<0){
								alert("You can't Exceed Qty of Bin "+strBin+ "\n This Bin has available qty only   "+(dblBinAvailable-(dblSubTotal-dblBinReqQty)));
								objrow.cells[3].lastChild.value=(dblBinAvailable-(dblSubTotal-dblBinReqQty));
							}
							else
								tblSecondBin.rows[loop].cells[4].lastChild.nodeValue=dblSubTotal;	
							
							
							boolFound=true;
							break;
						}
				   }
				   
				   	if(boolFound==false)
					{
					tblSecondBin.innerHTML += "<tr id=\""+intBinId+"\">"+
											"<td><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\"/></div></td>"+
											"<td class=\"normalfntMid\">"+strBin+"</td>"+
											"<td class=\"normalfntMid\">"+dblBinCapacity+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinAvailable+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinReqQty+"</td>"+
											"<td class=\"normalfntRite\">"+strLocation+"</td>"+
											"</tr>";	
					}
		//}

document.getElementById("txtQty2").value = get_total();
}

function removeRow(objDel)
{
	var objTable 	= 	document.getElementById("tblSecondbin");
	var rowNo		=	objDel.parentNode.parentNode.parentNode.rowIndex;
	objTable.deleteRow(rowNo);
	document.getElementById("txtQty2").value = get_total();
}

function get_total()
{
		var tblSecondBin = document.getElementById("tblSecondbin");
		var dblTotal=0;
		for(var loop=1;loop<tblSecondBin.rows.length;loop++)
		{
			dblTotal+=parseFloat(tblSecondBin.rows[loop].cells[4].lastChild.nodeValue);
		}
		return dblTotal;
}
function calculation2(txtReqQty)
{
	//alert(txtReqQty.value);
	if(parseFloat(txtReqQty.parentNode.parentNode.cells[1].lastChild.nodeValue)<parseFloat(txtReqQty.value))
	{
		txtReqQty.parentNode.parentNode.cells[3].lastChild.value=parseFloat(txtReqQty.parentNode.parentNode.cells[2].lastChild.nodeValue);
		alert("You can't Exceed Bin Qty"+txtReqQty.parentNode.parentNode.cells[2].lastChild.nodeValue);
		
	}
}
function CheckforValidDecimal2(sCell,decimalPoints,evt)
{
	var value=sCell.value;

	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

//======================================================================================================
//======================================================================================================


function findGrnValue(objBox)
{
	//alert("Loop Start");
	var tblGrn = document.getElementById("tblMainGrn");
	var dblTotalValue=0;
	//alert(tblGrn.rows.length);
	for(var loop=1;loop<=tblGrn.rows.length;loop++)
	{
		try
		{
		var value = parseFloat(tblGrn.rows[loop].cells[13].lastChild.nodeValue);
		//alert(loop);
		dblTotalValue+=value;
		}
		catch(err)
		{}
		//alert(parseFloat(tblGrn.rows[loop].cells[11].lastChild.nodeValue));
	}
	
	try
	{
		if((parseFloat(document.getElementById("txtGrnValue").value)!=dblTotalValue)&& objBox.name !='txtAdditionalQty')
		{	
			var intMatDetailID=objBox.parentNode.parentNode.cells[15].childNodes[0].nodeValue;
			var button=objBox.parentNode.parentNode.cells[13].childNodes[0];
			
			//show bin window
			
				//showBin(intMatDetailID,button);
		}
	}
	catch(err){
		
	}
	document.getElementById("txtGrnValue").value=Math.round((dblTotalValue)*1000)/1000//dblTotalValue;
}


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//				Save Part Of GRN
function hide()
{
	//alert("1");
	document.getElementById("butSave").style.visibility="hidden";
}
function locadComonbin()
{
	createXMLHttpRequest5();
	xmlHttp5.onreadystatechange = getCommonBinsActive;
	var url  = "xml.php?id=getCommonBinsActive";
	xmlHttp5.open("GET",url,true);
	xmlHttp5.send(null);
	
}
function save()
{
	showWaitingWindow();
	if(grnValidation()==false)
	{
		closeWaitingWindow();
		return;
	}
	
	poYear = new Date().getFullYear();
	//alert(poYear);
	save_GrnHeader();
}

function getCommonBinsActive()
{
	if(xmlHttp5.readyState==4 && xmlHttp5.status==200)
	{
		//alert(1);
		pub_ActiveCommonBins= xmlHttp5.responseText;
	}
}

function save_GrnHeader()
{
		  var text1 =  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		  var tblGrid = document.getElementById("tblMainGrn");
		  if(tblGrid.rows.length<=1)
		  {
			closeWaitingWindow();
			alert("Items not found !");
			return;
		  }
		  var intPoNo				= (text1[0]).split("/")[1];
		  var intYear				= (text1[0]).split("/")[0];
		  //done
		  
		  var dtmRecievedDate		= document.getElementById("grnDate").value;//txtbatchno

		  var strInvoiceNo			= document.getElementById("txtinvoiceno").value;
		  var strSupAdviceNo		= document.getElementById("txtsupadviceno").value;

		  var dtmAdviceDate			= (document.getElementById("adviceDate").value).split("/")[2]+"-"+(document.getElementById("adviceDate").value).split("/")[1]+"-"+(					document.getElementById("adviceDate").value).split("/")[0];//document.getElementById("adviceDate").value;//txtbatchno
		  var strBatchNO			= document.getElementById("txtbatchno").value;
		  var intGrnNo				= document.getElementById("txtgrnno").value;
		  
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = saveGrnHeaderRequest;
	var url  = "db.php?id=saveGrnHeader";
		url += "&intGrnNo="+intGrnNo;
		url += "&intYear="+intYear;
		url += "&intPoNo="+intPoNo;
		url += "&dtmRecievedDate="+dtmRecievedDate;
		url += "&strInvoiceNo="+URLEncode(strInvoiceNo);
		url += "&strSupAdviceNo="+URLEncode(strSupAdviceNo);
		url += "&dtmAdviceDate="+dtmAdviceDate;
		url += "&strBatchNO="+URLEncode(strBatchNO);
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}

function saveGrnHeaderRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		 var text= xmlHttp.responseText;
		 var status = text.split('->')[0];
		 var msg = text.split('->')[1];
		 //alert(text);
		 if(status=='error')
		 {
			rollback();
			alert(msg);	
			closeWaitingWindow();
		 }
		 else
		 {
			 //commit();
			 document.getElementById("txtgrnno").value=msg;
			 pub_intGrnNo=msg;
			 //closeWaitingWindow();
			 save_GrnDetail();
		 }
			  
	}
}

function grnValidation()
{
	//	validate po no
	var strPoNo	= document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text;
	if(strPoNo=="")
	{
		alert("PO no is empty.");
		return false;
	}
	
	//validate suplier advice no
	var strAdviceNo	= document.getElementById("txtsupadviceno").value;
	if(strAdviceNo=="")
	{
		alert("Please enter \"Supplier Advice No\".");
		document.getElementById("txtsupadviceno").focus();
		return false;
	}
	
	//validate suplier advice no
	var strInvoiceNo	= document.getElementById("txtinvoiceno").value;
	if(strInvoiceNo=="")
	{
		alert("Please enter \"Invoice No\".");
		document.getElementById("txtinvoiceno").focus();
		return false;
	}
	
	var strInvoiceNo	= document.getElementById("grnDate").value ;
	if(strInvoiceNo=="")
	{
		alert("GRN Date is empty");
		document.getElementById("grnDate").focus();
		return false;
	}
	
	/////////////////////////// Qty validation /////////////////////////
			var tblGrn = document.getElementById("tblMainGrn");
			var tblBin = document.getElementById("tblMainBin");
			
			for(var loop=1;loop<tblGrn.rows.length;loop++)
			{
				var dblMainQty = tblGrn.rows[loop].cells[10].childNodes[0].value;
				if (dblMainQty<= 0 )
				{
					alert("Line "+ loop+" Required Qty must grater than '0'");	
					return false;
				}
			}
	///////////////////////////////////////////////////////////////////
	
	if(pub_ActiveCommonBins==0)
	{
			
			for(var loop=1;loop<tblGrn.rows.length;loop++)
			{
				var dblMainQty = parseFloat(tblGrn.rows[loop].cells[10].childNodes[0].value);
				//var dbladdiQty = parseFloat(tblGrn.rows[loop].cells[17].childNodes[0].value);
				var Tqty = dblMainQty;
				var dblTotalQty=0;
				for(var i=1;i<tblBin.rows.length;i++)
				{
					try
					{
					if(tblBin.rows[i].id==tblGrn.rows[loop].id)
						
						dblTotalQty+=parseFloat(tblBin.rows[i].cells[1].lastChild.nodeValue);
					}
					catch(err){
						
					}
				}
				if ((Tqty!=dblTotalQty) ||(dblTotalQty==0))
				{
					alert(loop+"  row Grn Allocated Bin Qty is incorect");
					return false;
				}
			}
	
	}
	
	//Final return value
	return true;
}

//===============================================================================================================
//================================================= GRN DETAILS   ===============================================
//===============================================================================================================

function save_GrnDetail()
{
		pub_detailsSaveDone = 	0;
		pub_binSaveDone		=	0;
		
		//intGrnNo = document.getElementById("txtgrnno").value;
		var tblGrn = document.getElementById("tblMainGrn");
		pub_intxmlHttp_count = tblGrn.rows.length-1;
		for(var loop=1;loop<tblGrn.rows.length;loop++)
		{
			var row = tblGrn.rows[loop];
			
			//alert();
			
			createXMLHttpRequest1(loop);
			xmlHttp1[loop].onreadystatechange=saveGrnDetailsRequest;
			xmlHttp1[loop].num = loop;
			xmlHttp1[loop].rowIndex = row.rowIndex;
			
			//alert(xmlHttp1[loop].num);
			
		var url  = "db.php?id=saveGrnDetails";
			url += "&count="+loop;
			url += "&intGrnNo="+pub_intGrnNo;
			url += "&strStyleID="+URLEncode(row.cells[1].lastChild.nodeValue);
			url += "&strBuyerPONO="+row.cells[3].lastChild.nodeValue.replace(/#/gi,"***");
			url += "&intMatDetailID="+row.cells[15].lastChild.nodeValue;
			url += "&strColor="+URLEncode(row.cells[5].lastChild.nodeValue);
			url += "&strSize="+URLEncode(row.cells[6].lastChild.nodeValue);
			url += "&dblQty="+row.cells[10].childNodes[0].value;
			url += "&dblCapacityQty="+row.cells[9].childNodes[0].nodeValue;
			url += "&dblExcessQty="+row.cells[11].lastChild.nodeValue;
			url += "&dblRate="+row.cells[8].lastChild.nodeValue;
			url += "&intYear="+row.cells[16].lastChild.nodeValue;
			url += "&intPoNo="+row.cells[17].lastChild.nodeValue;
			url += "&strUnit="+row.cells[7].lastChild.nodeValue;
			
			xmlHttp1[loop].open("GET", url, true);
			xmlHttp1[loop].send(null);	
			//continue;
			if(pub_ActiveCommonBins==1)
				continue;
			//#################################### SAVE STOCK TRANSACTION TABLE ############################
								var tblBin = document.getElementById("tblMainBin");
								pub_intxmlHttp_count = tblGrn.rows.length-1;
								pub_binCount = tblGrn.rows[loop].id;
								
								for(var x=1;x<tblBin.rows.length;x++)
								{
									//alert('main grid loop'+loop);
									
									//alert('bin row id  =  main id ( '+tblBin.rows[x].id+' + '+tblGrn.rows[loop].id+' )');
									//alert('bin row id = '+tblBin.rows[x].id);
									
									if(tblBin.rows[x].id==tblGrn.rows[loop].id)
									{
										//alert('in');
										var binRow = tblBin.rows[x];
										createXMLHttpRequest2(x);
										
										xmlHttp2[x].onreadystatechange=saveBin;
										xmlHttp2[x].num = x;
										
									var url2  = "db.php?id=saveBin";
										url2 += "&count="+x;
										url2 += "&intGrnNo="+pub_intGrnNo;
										url2 += "&strStyleNo="+URLEncode(row.cells[1].lastChild.nodeValue);
										url2 += "&strMainStoresID="+binRow.cells[2].lastChild.nodeValue;
										url2 += "&strSubStores="+binRow.cells[3].lastChild.nodeValue;
										url2 += "&strLocation="+binRow.cells[4].lastChild.nodeValue;
										url2 += "&strBin="+binRow.cells[0].lastChild.nodeValue;
										url2 += "&strBuyerPoNo="+row.cells[3].lastChild.nodeValue.replace(/#/gi,"***");
										url2 += "&intMatDetailId="+row.cells[15].lastChild.nodeValue;
										url2 += "&strColor="+URLEncode(row.cells[5].lastChild.nodeValue);
										url2 += "&strSize="+URLEncode(row.cells[6].lastChild.nodeValue);
										url2 += "&strUnit="+binRow.cells[7].lastChild.nodeValue;
										url2 += "&dblQty="+binRow.cells[1].lastChild.nodeValue;
										
										xmlHttp2[x].open("GET", url2, true);
										xmlHttp2[x].send(null);	
										
									}
								}
			//##############################################################################################
			
		}
}

function saveGrnDetailsRequest()
{
	if(xmlHttp1[this.num].readyState == 4) //this.index
    {
        if(xmlHttp1[this.num].status == 200) 
        {  
			
			///////////////////////////////////////////////
					 var text= xmlHttp1[this.num].responseText;
					 var status = text.split('->')[0];
					 var msg = text.split('->')[1];
					 
					 if(status=='error')
					 {
						rollback();
						alert(msg);	
						closeWaitingWindow();
					 }
					 else
					 {
						// commit();
						pub_intxmlHttp_count=pub_intxmlHttp_count-1;
						if (pub_intxmlHttp_count ==0)
						{
							
							pub_detailsSaveDone = 	1;
							
							if((pub_binSaveDone	==1) && (pub_detailsSaveDone==1))
							{
								commit();
								closeWaitingWindow();
								var grnNo		=	document.getElementById("txtgrnno").value;
								alert("GRN Saved Successfully. GRN no is "+grnNo);
								document.getElementById("butConform").style.visibility	=	"visible";
								document.getElementById("butReport").style.visibility	=	"visible";
							}
						}
					 }
			///////////////////////////////////////////////
			
		}
	}
}

function saveBin()
{
	if(xmlHttp2[this.num].readyState == 4) //this.index
    {
        if(xmlHttp2[this.num].status == 200) 
        {  
			//#############################################################
			 var text=xmlHttp2[this.num].responseText;
			 var status = text.split('->')[0];
			 var msg = text.split('->')[1];
			 
			 if(status=='error')
			 {
				rollback();
				alert(msg);	
				closeWaitingWindow();
			 }
			 else
			 {
				pub_binCount=pub_binCount-1;
				if (pub_binCount ==0)
				{
					
					pub_binSaveDone = 	1;
					//alert(pub_detailsSaveDone);
					if((pub_binSaveDone	==1) && (pub_detailsSaveDone==1))
					{
						commit();
						closeWaitingWindow();
						var grnNo		=	document.getElementById("txtgrnno").value;
						alert("GRN Saved Successfully. GRN no is "+grnNo);
						document.getElementById("butConform").style.visibility="visible";
						document.getElementById("butReport").style.visibility="visible";
					}
				}
			 }
			//#############################################################
		}
	}
}

function createXMLHttpRequest2(index) 
{
	try
	 {
	  //Firefox, Opera 8.0+, Safari
	 xmlHttp2[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		  //Internet Explorer
		 try
		  {
		  	xmlHttp2[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp2[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


function loadGrnFrom(intGrnNo,intYear,intStatus,grnFactory)
{
	showWaitingWindow();
	 pub_intGrnNo=intGrnNo;
	 pub_intGrnYear=intYear;
	
	pub_grnFactory = grnFactory;
	if ((intGrnNo!=0)||(intYear!=0))
	{
		if(intStatus==1)
		{
			
			document.getElementById("butSave").style.visibility="hidden";
			document.getElementById("butConform").style.visibility="hidden";
		}
		else if(intStatus==10)
		{
			document.getElementById("butSave").style.visibility="hidden";
			document.getElementById("butConform").style.visibility="hidden";
			document.getElementById("butCancel").style.visibility="hidden";
		}
		else if(intStatus==0)
			document.getElementById("butCancel").style.visibility="hidden";
			
		//  ==============================   GRN HEADER PART  ============================
		document.getElementById("txtgrnno").value = intGrnNo;

		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = grnHeaderRequest;
		var url  = "xml.php?id=loadGrnHeader";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;
			url += "&intStatus="+intStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		//====================================  GRN DETAIL PART ==============================================
		createXMLHttpRequest3();
		xmlHttp3.onreadystatechange = grnDetailRequest;
		var url  = "xml.php?id=loadgrndetail";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;
			url += "&intStatus="+intStatus;
		xmlHttp3.intGrnNo = intGrnNo;
		xmlHttp3.intYear = intYear;
		xmlHttp3.open("GET",url,true);
		xmlHttp3.send(null);

			var tblGrn = document.getElementById("tblMainGrn");
			tblGrn.innerHTML+="</tr>"+
				  "<td  height=\"80\" class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
			  "<td colspan=\"3\"    class=\"normaltxtmidb2\"><img src=\"../../images/loading5.gif\" width=\"100\" height=\"100\" border=\"0\"  /></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
           "</tr>";
		   
		   
		   		var tblBin = document.getElementById("tblMainBin");
					tblBin.innerHTML+="</tr>"+
				  "<td  height=\"80\" class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
			  "<td colspan=\"3\"    class=\"normaltxtmidb2\"><img src=\"../../images/loading5.gif\" width=\"100\" height=\"100\" border=\"0\"  /></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
				  "<td    class=\"normaltxtmidb2\"></td>"+
           "</tr>";
		   //alert("123");
		
	}	
	else
	{
		closeWaitingWindow();
		document.getElementById("butConform").style.visibility="hidden";
				//if(document.getElementById("txtgrnno").value!='')
			//document.getElementById("butReport").style.visibility="visible";
		//else
			document.getElementById("butReport").style.visibility="hidden";
			document.getElementById("butCancel").style.visibility="hidden";
	}
}

var poYear = new Date().getFullYear();

function grnHeaderRequest()
{
    if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        {  

			var hasRecord = xmlHttp.responseText;
			//alert(hasRecord);
			if(xmlHttp.responseXML.getElementsByTagName("NPONO").length<=0)
			{
				document.getElementById("txtgrnno").value="";
				alert("Record not found");
				newPage();
				return;
			}
		
			var strNPONO =  xmlHttp.responseXML.getElementsByTagName("NPONO")[0].childNodes[0].nodeValue;
			document.getElementById("txtpono").value = strNPONO;
			
			
			poYear =  parseInt(xmlHttp.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue);
			
			// stop cording heres
			
			document.getElementById("txtsupadviceno").value = xmlHttp.responseXML.getElementsByTagName("strSupAdviceNo")[0].childNodes[0].nodeValue;
				var m,m1;
				m = xmlHttp.responseXML.getElementsByTagName("dtmRecievedDate")[0].childNodes[0].nodeValue;
				m1 = m.split(" ");
			document.getElementById("grnDate").value =m1[0];
			document.getElementById("txtbatchno").value =xmlHttp.responseXML.getElementsByTagName("strBatchNO")[0].childNodes[0].nodeValue;
				var d = xmlHttp.responseXML.getElementsByTagName("dtmAdviceDate")[0].childNodes[0].nodeValue;
				var d1 = "";
				d = d.split("-");
				d1= d[2].substring(0,2)+"/"+d[1]+"/"+d[0];
			
			document.getElementById("adviceDate").value =d1;
			document.getElementById("txtinvoiceno").value =xmlHttp.responseXML.getElementsByTagName("strInvoiceNo")[0].childNodes[0].nodeValue;	
			
			
			//}
		}
	}
}


function grnDetailRequest()
{
    if(xmlHttp3.readyState == 4)
    {
        if(xmlHttp3.status == 200) 
        {   
		
		//alert(xmlHttp3.responseText);
		var tbl = document.getElementById('tblMainGrn');
		tbl.deleteRow(1);
		var tblBin = document.getElementById("tblMainBin");
		tblBin.deleteRow(1);
		var XMLstrStyleID = xmlHttp3.responseXML.getElementsByTagName("strStyleID");
		var XMLstrSRNO = xmlHttp3.responseXML.getElementsByTagName("SRNO");	
		var XMLDescription = xmlHttp3.responseXML.getElementsByTagName("strItemDescription");	
		var XMLstrUnit = xmlHttp3.responseXML.getElementsByTagName("strUnit");
		var XMLdblQty = xmlHttp3.responseXML.getElementsByTagName("dblQty");	
		var XMLstrColor = xmlHttp3.responseXML.getElementsByTagName("strColor");
		var XMLstrSize = xmlHttp3.responseXML.getElementsByTagName("strSize");
		var XMLstrBuyerPoNo = xmlHttp3.responseXML.getElementsByTagName("strBuyerPONO");
		var XMLdblUnitPrice = xmlHttp3.responseXML.getElementsByTagName("dblUnitPrice");
		var XMLdblAdditionalQty = xmlHttp3.responseXML.getElementsByTagName("dblExcessQty");
		var XMLdblPending = xmlHttp3.responseXML.getElementsByTagName("dblBalance");	
		var XMLintMatDetailID = xmlHttp3.responseXML.getElementsByTagName("intMatDetailID");
		var XMLdblAditionalQty = xmlHttp3.responseXML.getElementsByTagName("dblAditionalQty");
		var XMLintPoNo = xmlHttp3.responseXML.getElementsByTagName("intPoNo");
		var XMLintPoYear = xmlHttp3.responseXML.getElementsByTagName("intYear");
		
		//var XMLPOadditionalPendingQty = xmlHttp3.responseXML.getElementsByTagName("POadditionalPendingQty");
		//dblAditionalQty
		var XMLgrnExQty = xmlHttp3.responseXML.getElementsByTagName("GrnExcessQty");	
		//alert("hi");
		for(var loop =0;loop<XMLstrStyleID.length;loop++)
		{	 
			
				var strStyleID = XMLstrStyleID[loop].childNodes[0].nodeValue;
				var strSRNO = XMLstrSRNO[loop].childNodes[0].nodeValue;
				var Description = XMLDescription[loop].childNodes[0].nodeValue;
				var strUnit = XMLstrUnit[loop].childNodes[0].nodeValue;
				var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
				var strColor = XMLstrColor[loop].childNodes[0].nodeValue;
				var strSize = XMLstrSize[loop].childNodes[0].nodeValue;
				var strBuyerPoNo = XMLstrBuyerPoNo[loop].childNodes[0].nodeValue;
				var dblUnitPrice = XMLdblUnitPrice[loop].childNodes[0].nodeValue;
				var dblAdditionalQty = XMLdblAdditionalQty[loop].childNodes[0].nodeValue;
				var dblPending = XMLdblPending[loop].childNodes[0].nodeValue;
				var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
				var intMatDetailID = XMLintMatDetailID[loop].childNodes[0].nodeValue;
				var dblAditionalQty = XMLdblAditionalQty[loop].childNodes[0].nodeValue;
				var intPoNo = XMLintPoNo[loop].childNodes[0].nodeValue;
				var intPoYear = XMLintPoYear[loop].childNodes[0].nodeValue;
				
				//pub_intGrnYear = intPoYear;
				
				//var POadditionalPendingQty = XMLPOadditionalPendingQty[loop].childNodes[0].nodeValue;
				
				var GrnExcessQty = XMLgrnExQty[0].childNodes[0].nodeValue;
				var text1 =  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		        //alert(intPoNo);
				 // var intPoNo				= (text1[0]).split("/")[1];
				  //var intYear				= (text1[0]).split("/")[0];
				 // var intYear = poYear;
				
				
				//alert(this.rowIndex);
				//alert(tbl.rows[this.rowIndex].cells[1]);
				var strInnerHtml="";
				//strInnerHtml +="<input type=\"text\" style=\"txtbox\" value=\"" + value1 + "\">";
				
			  //strInnerHtml +="<tr>";
              strInnerHtml +="<td><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"delRow(this)\"/></div></td>";//delete button
              strInnerHtml +="<td class=\"normalfntMid\">"+strStyleID+"</td>";				//Style No
              strInnerHtml +="<td class=\"normalfntMid\">"+strSRNO+"</td>";				//SR No
              strInnerHtml +="<td class=\"normalfntMid\">"+strBuyerPoNo+"</td>";			//Buyer Po No
              strInnerHtml +="<td class=\"normalfnt\">"+Description+"</td>";				//Description
              strInnerHtml +="<td class=\"normalfntMidSML\">"+strColor+"</td>";				//Color
              strInnerHtml +="<td class=\"normalfntMidSML\">"+strSize+"</td>";				//Size
              strInnerHtml +="<td class=\"normalfntMidSML\">"+strUnit+"</td>";				//Unit
              strInnerHtml +="<td class=\"normalfntMid\">"+dblUnitPrice+"</td>";			//Rate
              strInnerHtml +="<td class=\"normalfntRite\">"+dblPending+"</td>";				//Pending Qty
strInnerHtml +="<td class=\"normalfntRite\"><input name=\"txtbatchno2\" type=\"text\" class=\"txtbox\" id=\"txtbatchno2\" size=\"10\" style=\"text-align:right\" value=\"" + dblQty + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>";							//Recived Qty
              strInnerHtml +="<td id="+GrnExcessQty+" class=\"normalfntMid\">"+dblAdditionalQty+"</td>";		//Excess Qty
			  strInnerHtml +="<td class=\"normalfntMid\">"+(dblPending-dblQty)+"</td>";		//balance Qty
              //strInnerHtml +="<td class=\"normalfntRite\">"+Math.round((dblUnitPrice*dblQty)*1000)/1000+"</td>";	//Value
			  //+Math.round((dblUnitPrice*(parseFloat(dblPending)+parseFloat(dblAdditionalPendingQty)))*1000)/1000 +
			  strInnerHtml +="<td class=\"normalfntRite\">"+Math.round((dblUnitPrice*dblQty)*1000)/1000 +"</td>";	//Value
			 // alert(Math.round((dblUnitPrice*(parseFloat(dblPending)+parseFloat(POadditionalPendingQty)))*1000)/1000);
              strInnerHtml +="<td class=\"mouseover\"><img src=\"../../images/location.png\" alt=\"Add Bin\" width=\"90\" height=\"20\" onclick=\"showBin("+intMatDetailID+",this)\" /></td>";						//Location
              strInnerHtml +="<td class=\"normalfntMid\">"+intMatDetailID+"</td>";			//Mat Cat Id
              strInnerHtml +="<td class=\"normalfntMid\">"+intPoYear+"</td>";					//year
              strInnerHtml +="<td class=\"normalfntMid\">"+intPoNo+"</td>";					//Po No
			  /*strInnerHtml +="<td class=\"normalfntRite\"><input name=\"txtAdditionalQty\" type=\"text\" class=\"txtbox\" id=\""+(parseFloat(dblAditionalQty)+parseFloat(POadditionalPendingQty))+"\" size=\"10\" style=\"text-align:right\" value=\"" + parseFloat(dblAditionalQty) + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>";*/
            //strInnerHtml +="</tr>";
			  
				//tbl.rows[this.rowIndex].cells[1].innerHTML=  strInnerHtml ;
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				tbl.rows[lastRow].innerHTML=  strInnerHtml ;
				tbl.rows[lastRow].id = ++nextGrnIndex;
				
				tbl.rows[lastRow].className = "osc2";
				
				pub_intRow = loop+1;
				//==========================             BIN TABLE        =============
					createXMLHttpRequest1(loop);
					xmlHttp1[loop].onreadystatechange = grnBinRequest;
					var url  = "xml.php?id=loadBins";
						url += "&strStyleId="+URLEncode(strStyleID);
						url += "&intDocumentNo="+xmlHttp3.intGrnNo;
						url += "&strBuyerPoNo="+strBuyerPoNo.replace(/#/gi,"***");
						url += "&intDocumentYear="+xmlHttp3.intYear;
						url += "&intMatDetailID="+intMatDetailID;
						url += "&strColor="+URLEncode(strColor);
						url += "&strSize="+URLEncode(strSize);
						url += "&strType="+"GRN";
						//strBuyerPoNo=strBuyerPoNo.replace(/#/gi,"***");
					xmlHttp1[loop].index = loop;
					xmlHttp1[loop].id = nextGrnIndex;
					xmlHttp1[loop].open("GET",url,true);
					xmlHttp1[loop].send(null);
					

					
		    }
			//alert("123");
			findGrnValue(this);
		}
	}
}
function grnBinRequest()
{
	if(xmlHttp1[this.index].readyState == 4)
    {
        if(xmlHttp1[this.index].status == 200) 
        {  
			var XMLstrBin = xmlHttp1[this.index].responseXML.getElementsByTagName("strBin");
			var XMLstrBinName = xmlHttp1[this.index].responseXML.getElementsByTagName("strBinName");
			var XMLdblQty = xmlHttp1[this.index].responseXML.getElementsByTagName("dblQty");
			var XMLstrMainStoresID = xmlHttp1[this.index].responseXML.getElementsByTagName("strMainStoresID");
			var XMLstrSubStores = xmlHttp1[this.index].responseXML.getElementsByTagName("strSubStores");
			var XMLstrLocation = xmlHttp1[this.index].responseXML.getElementsByTagName("strLocation");
			var XMLdblCapacityQty = xmlHttp1[this.index].responseXML.getElementsByTagName("dblCapacityQty");
			var XMLavailableQty = xmlHttp1[this.index].responseXML.getElementsByTagName("availableQty");
			var XMLstrUnit = xmlHttp1[this.index].responseXML.getElementsByTagName("strUnit");
			var XMLintSubCatNo = xmlHttp1[this.index].responseXML.getElementsByTagName("intSubCatNo");

//=================================================================================================================================================================
	
	var tblSecondBin 		= 	document.getElementById("tblSecondbin");
	var tblMainBin 			= 	document.getElementById("tblMainBin");
	var tblGrn				=	document.getElementById("tblMainGrn");
	
	//tblGrn.rows[this.id].id = xmlHttp1.length;
	
	//alert((this.index+1) +" = " +tblGrn.rows[this.index+1].id);
	//alert((xmlHttp1[this.index].index+1) +" - " + tblGrn.rows[xmlHttp1[this.index].index+1].id);
	
	for(var loop=0;loop<XMLstrBin.length;loop++)
	{		

		var strBin = XMLstrBin[loop].childNodes[0].nodeValue;
		var strBinName = XMLstrBinName[loop].childNodes[0].nodeValue;
		var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
		var strMainStoresID = XMLstrMainStoresID[loop].childNodes[0].nodeValue;
		var strSubStores = XMLstrSubStores[loop].childNodes[0].nodeValue;
		var strLocation = XMLstrLocation[loop].childNodes[0].nodeValue;
		var dblCapacityQty = XMLdblCapacityQty[loop].childNodes[0].nodeValue;
		var availableQty = XMLavailableQty[loop].childNodes[0].nodeValue;
		var strUnit = XMLstrUnit[loop].childNodes[0].nodeValue;
		var intSubCatNo = XMLintSubCatNo[loop].childNodes[0].nodeValue;
		
		tblMainBin.innerHTML	+="<tr>"+
								  "<td class=\"normalfntMid\">"+strBin+"</td>"+
								  "<td class=\"normalfntRite\">"+dblQty+"</td>"+
								  "<td class=\"normalfntMid\">"+strMainStoresID+"</td>"+
								  "<td class=\"normalfntMid\">"+strSubStores+"</td>"+
								  "<td class=\"normalfntMid\">"+strLocation+"</td>"+
								  "<td class=\"normalfntRite\">"+dblCapacityQty+"</td>"+
								  "<td class=\"normalfntRite\">"+availableQty+"</td>"+
								  "<td class=\"normalfntMid\">"+strUnit+"</td>"+
								  "<td class=\"normalfntMid\">"+intSubCatNo+"</td>"+
								  "<td class=\"normalfntMid\">"+strBinName+"</td>"+
								  "</tr>";

		tblMainBin.rows[tblMainBin.rows.length-1].id=this.id;
	}
	closeWaitingWindow();
	//tblGrn.rows[pub_intRow].className = "bcggreen";
//=================================================================================================================================================================

		}
	}
}


function conform(grnNo,grnYear)
{
	showWaitingWindow();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = grnConfirmedRequest;
	var url  = "db.php?id=confirmed";
		url += "&intGrnNo="+grnNo;
		url += "&intYear="+grnYear;
	xmlHttp.grnNo = grnNo;
	xmlHttp.grnYear = grnYear;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function grnConfirmedRequest()
{
	if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        {  
			var intIsSave = xmlHttp.responseText;
			closeWaitingWindow();
			if(intIsSave==1)
			{
				
				alert("Successfully Confirmed");
				//document.getElementById("butConform").href	= "grnReport.php";
				//document.getElementById("butConform").style.visibility		=	"hidden";
				//document.getElementById("butSave").style.visibility			=	"hidden";
				//document.getElementById("butReport").style.visibility		=	"visible";
				//alert(1);
					//var grnYear = poYear;
	//var grnYear = (text1[0]).split("/")[0];
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/Details/grnReport.php?grnno="+xmlHttp.grnNo+'&grnYear='+xmlHttp.grnYear;
	//alert(path);
	var win2=window.open(path,'win');
			
			}
		}
	}
}

function cancel()
{
	if(!confirm("Are you sure you want to cancel this GRN?")) return;
	
	showWaitingWindow();
			  var text1 	=  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		 	  var intYear	= (text1[0]).split("/")[0];
  		 	  var intPoNo	= (text1[0]).split("/")[1];
			  var intGrnNo 	= document.getElementById("txtgrnno").value;
			  
			  
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = grnCancelRequest;
		var url  = "db.php?id=cancel";
			url += "&intGrnNo="+intGrnNo;
			url += "&intGrnYear="+pub_intGrnYear;
			url += "&intYear="+intYear;
			url += "&intPoNo="+intPoNo;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
function grnCancelRequest()
{
	if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        {  
			var intIsSave = xmlHttp.responseText;
			closeWaitingWindow();
			
			if(intIsSave==1)
			{
				alert("Successfully Cancelled");
				document.getElementById("butCancel").style.visibility="hidden";
			}
			else
				alert("Proccess failed");
		}
	}
}
//============================== report

function grnReport()
{
//	alert(document.location.hash);
//	alert(document.location.host);
//	alert(document.location.hostname);
//	alert(document.location.href);
//	alert(document.location.pathname);
//	alert(document.location.port );
//	alert(document.location.hostname);
	//var grnYear = document.getElementById("txtpono").value.split("/")[0];
	var grnYear = poYear;
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/Details/grnReport.php?grnno="+document.getElementById("txtgrnno").value+'&grnYear='+grnYear;
	//alert(path);
	//document.location.href = path;
	//pub_printWindowNo
	var win2=window.open(path,'win'+pub_printWindowNo++);
	//alert(document.location.search);
	
}

function grnConfirmReport()
{
	
	 var text1 	=  	(document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
	  var tblGrid = document.getElementById("tblMainGrn");
	  if(tblGrid.rows.length<=1)
	  {
	  	alert("Items not found !");
		return;
	  }
	  
	  if (text1=="")
	  {
		alert("you are not valid user");  
		return;
	  }
	
		//var intYear	= 	(text1[0]).split("/")[0];
	 	//var intGrnNo 	= 	document.getElementById("txtgrnno").value;
	var grnYear = poYear;
	//var grnYear = (text1[0]).split("/")[0];
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/Details/grnConfirmReport.php?grnno="+document.getElementById("txtgrnno").value+'&grnYear='+grnYear;
	var win2=window.open(path,'win');
	
}
function gridValues()
{
	var tblGrn = document.getElementById("tblMainGrn");
	var tblBin = document.getElementById("tblMainBin");
	
	for (var x =1 ; x< tblGrn.rows.length;x++)
	{
		alert(tblGrn.rows[x].id);	
	}
}


function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}
 
function ltrim(str) {
	chars = ' '  || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str) {
	chars = ' ' || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
function rowclickColorChange(obj)
{
	//var rowIndex = this.rowIndex;
	//alert();
	 
	var row = obj.parentNode.parentNode.parentNode;
	
	//for calculate selected qty
	var labelValue = parseFloat(document.getElementById("selectedTotalQty").innerHTML);
	var selectValue = parseFloat(row.cells[9].childNodes[0].nodeValue);
	
	
	//alert(row[].cells
	//var tbl = document.getElementById('tblItem');
	if(row.className!="bcgcolor-highlighted")
		pub_itemRowColor= row.className;
	
	if(obj.checked)
	{
		row.className="bcgcolor-highlighted";
		document.getElementById("selectedTotalQty").innerHTML =labelValue+selectValue;
	}
	else
	{
		row.className=pub_itemRowColor;
		document.getElementById("selectedTotalQty").innerHTML =labelValue-selectValue;
	}
		
    //for ( var i = 1; i < tbl.rows.length; i ++)
	//{
		//tbl.rows[i].className = "";
/*		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}*/
		//if( i == rowIndex)
		//tbl.rows[rowIndex].className = "bcgcolor-highlighted";
	//}
	
}


function getGrnExcessQtyStatus()
{
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = statusRequest;
		var url  = "config.xml";
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function statusRequest()
{
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
    {
		var XMLPercentage 	= xmlHttp.responseXML.getElementsByTagName("DefaultGRNExcessQtyPercentage");
 		alert(XMLPercentage[0].childNodes[0].nodeValue);
	}
}

function autoBin()
{
	showWaitingWindow();
	 var tbl 			= 	document.getElementById('tblMainGrn');
	 var tblMainBin 	= 	document.getElementById("tblMainBin");
	 var strMainStores 	= 	document.getElementById('cbomainstores').value;
	 var strSubStores	= 	document.getElementById("cboSubStores").value;

	 var mainCatNo 	= '';
	 var manRowId 	= '';

 for (var i = 1; i < tbl.rows.length ; i++)
 {
	//alert(tbl.rows[a].id);
	
	 var mainGrnCount2 = tbl.rows[i].count;
	 if(mainGrnCount2>0)
	 {
		mainCatNo  	= tbl.rows[i].cells[15].innerHTML;
		manRowId	=  tbl.rows[i].id;	
	 }
	 
	 for (var a = 1; a < tbl.rows.length ; a++)
	 {
		//alert(tbl.rows[a].id);
		var mainGrnCount = tbl.rows[a].count;
/*		 var mainGrnCount = tbl.rows[a].count;
		 if(mainGrnCount>0)
		 {
		 	mainCatNo  	= tbl.rows[a].cells[15].lastChild.value;
			manRowId	=  tbl.rows[a].id;	
		 }
		 else*/
		 //alert(tbl.rows[a].cells[15].inn);
		 //alert(mainGrnCount);
		 
			if(tbl.rows[a].cells[15].innerHTML==mainCatNo && (! mainGrnCount>0))
			{
				 var intCountBin = tblMainBin.rows.length;
				 for (var x = 1; x <intCountBin  ; x++)
				 {
					 if(tblMainBin.rows[x].id==manRowId)
					 {
						var reqQty 	  				= tbl.rows[a].cells[10].lastChild.value;
						tblMainBin.innerHTML 		+=tblMainBin.rows[x].innerHTML;
						tblMainBin.rows[tblMainBin.rows.length-1].cells[1].innerHTML = reqQty;
						tblMainBin.rows[tblMainBin.rows.length-1].id=tbl.rows[a].id;
						tbl.rows[a].count 			= 1;
						tbl.rows[a].className 		= "osc2";
						//alert('xxx');
						//bookmark
					 }
						
				 }
			}
		 //}
}
/*		 	var reqQty 	  	= tbl.rows[a].cells[8].lastChild.value;
			var mainGrnRow	= tblMainBin.rows[a].id;
			
			var strUnit	= tbl.rows[a].cells[7].childNodes[0].nodeValue;
			var rowId	= tbl.rows[a].id;*/
			//alert(str);
			//tbl.rows[a].count = 1;
			
/*			createXMLHttpRequestAutoBin(a);
			
			xmlHttpAutoBin[a].onreadystatechange = autoRequest;
			var url  = "xml.php?id=loadAutoBins";
				url += "&strMainStores="+strMainStores;
				url += "&strSubStores="+strSubStores;
				url += "&reqQty="+reqQty;
				url += "&strUnit="+strUnit;
				
				xmlHttpAutoBin[a].index = a;
				xmlHttpAutoBin[a].id = rowId;
				xmlHttpAutoBin[a].open("GET",url,true);
				xmlHttpAutoBin[a].send(null);*/
	 }
closeWaitingWindow();
}

function autoRequest()
{	
    if(xmlHttpAutoBin[this.index].readyState == 4 && xmlHttpAutoBin[this.index].status == 200) //this.index
    {
		var text 					= xmlHttpAutoBin[this.index].responseText;
		var tblMainBin 				= 	document.getElementById("tblMainBin");
		tblMainBin.innerHTML 		+=text;
		tblMainBin.rows[tblMainBin.rows.length-1].id=xmlHttpAutoBin[this.index].id;
	}
}

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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function createXMLHttpRequestForCommit() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCommit = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCommit = new XMLHttpRequest();
    }
}

function createXMLHttpRequestForRollback() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpRollBack = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpRollBack = new XMLHttpRequest();
    }
}

function rollback()
{
	createXMLHttpRequestForRollback();
	xmlHttpRollBack.onreadystatechange = rollbackRequest;
	var url  = "db.php?id=rollback";
	xmlHttpRollBack.open("GET",url,true);
	xmlHttpRollBack.send(null);	
//lert(
}

function commit()
{
	createXMLHttpRequestForCommit();
	xmlHttpCommit.onreadystatechange = commitRequest;
	var url  = "db.php?id=commit";
	xmlHttpCommit.open("GET",url,true);
	xmlHttpCommit.send(null);	
}

function commitRequest()
{
	if(xmlHttpCommit.readyState==4 && xmlHttpCommit.status==200)
	{
		//alert("commit done")
	}
}

function rollbackRequest()
{
	if(xmlHttpRollBack.readyState==4 && xmlHttpRollBack.status==200)
	{
		//alert("rollback done")
	}
}