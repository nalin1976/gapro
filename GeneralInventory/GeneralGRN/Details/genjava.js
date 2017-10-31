//tables
//1.tblMainGrn
//2.tblMainBin
//3.tblItem
//4.tblBins
//5.tblSecondbin

var pub_ActiveCommonBins=0;

var nextGrnIndex=0;
var grnRowIndex = 0;
//var nextBinIndex=0;


var xmlHttp;
var xmlHttp5;
var xmlHttp3;
var xmlHttp4;
var xmlHttp1 = [];
var xmlHttp2 = [];

var count 	= 0;
var intMax = 0;

var intItemRowCount=0;

var pub_intSubCatNo=0;
var pub_intRow=0;
var pub_dblBinLoadQty=0;
var pub_intGrnNo=0;
var pub_intxmlHttp_count=0;
var pub_binCount = 0;

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
	var intSupplierID	= document.getElementById('cbosuplier').value;
	
	var dtDateFrom = "";
	var dtDateTo   = "";
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
	var url = 'genxml.php?id=po-search&strPiNo='+strPiNo+'&intSupplierID='+intSupplierID+'&dtDateFrom='+dtDateFrom+'&dtDateTo='+dtDateTo;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null); 
}

function newPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
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
			 var XMLstrPINO = xmlHttp.responseXML.getElementsByTagName("strPINO");
			 var ListF = xmlHttp.responseXML.getElementsByTagName("ListF");
			 for (var loop = 0; loop < XMLstrPINO.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text  =  ListF[loop].childNodes[0].nodeValue;
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
    xmlHttp.open("GET", 'genxml.php?id=supplier&value=' + strOrigin, true);
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

function RemovePo()
{
	var index = document.getElementById("txtpono").options.length;
	while(document.getElementById("txtpono").options.length > 0) 
	{
		index --;
		document.getElementById("txtpono").options[index] = null;
	}
}
	
function ShowItems()
{
	showBackGround('divBG',0);
	var url = "genPOpopupItems.php?&genPONo="+document.getElementById("txtpono").value;
	var htmlobj=$.ajax({url:url,async:false});
	var popHTML = htmlobj.responseText;
	drawPopupBox(610,390,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = popHTML;
	//addItems();
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
function addItems()
{
	var strPoNo	= document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = ItemRequest;
    xmlHttp.open("GET", 'genxml.php?id=addItems&value='+strPoNo, true);
    xmlHttp.send(null); 
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
				var XMLstrUnit 		= xmlHttp.responseXML.getElementsByTagName("strUnit");
				var XMLQty 			= xmlHttp.responseXML.getElementsByTagName("Qty");
				var XMLintMatDetailID= xmlHttp.responseXML.getElementsByTagName("intMatDetailID");
				
				var tableText =     "<table width=\"700\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblItem\" bgcolor=\"#CCCCFF\">"+
									"<tr height='25' class=\"mainHeading4\">"+
									"<td width=\"1%\" ><input type=\"checkbox\" name=\"chkSelectAll\" id=\"chkSelectAll\" onclick=\"SelectAll(this);\"/></td>"+
									"<td width=\"16%\" >Description</td>"+
									"<td width=\"6%\" >Unit</td>"+
									"<td width=\"6%\" >Qty</td>"+
									"<td width=\"6%\" >Mat Details ID</td>"+
									"<td width=\"6%\" >Cost Center</td>"+
									"</tr>";
				
				var strColor = "backcolorYellow";

				  for ( var loop = 0; loop < XMLDescription.length; loop++)
				  {    
				  		if (loop % 2 == 0)
							 strColor = "bcgcolor-tblrowWhite";
						else
							 strColor = "bcgcolor-tblrow";
						
						
						tableText +="<tr class="+strColor+" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
									"<td ><div align=\"center\" >"+
									"<input type=\"checkbox\" name=\"cboadd\" id=\"cboadd\" />"+
									"</div></td>"+
									"<td>"+ XMLDescription[loop].childNodes[0].nodeValue +"</td>"+
									"<td class=\"normalfntMid\">"+ XMLstrUnit[loop].childNodes[0].nodeValue +"</td>"+
									"<td>"+ XMLQty[loop].childNodes[0].nodeValue +"</td>"+
									"<td>"+ XMLintMatDetailID[loop].childNodes[0].nodeValue +"</td>"+
									"</tr>"
				  }
				 tableText += "</table>";
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



function addItemToGrn()
{
	var tbl 	= document.getElementById('tblItem');
	var tblMain = document.getElementById('tblMainGrn');
	
	var intC=0;
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].childNodes[1].checked)
		intC++;
	}
	
	if (document.getElementById('txtpono').value == "")
	{
		alert("Please select the PO.");
		document.getElementById('txtpono').focus();
		return false;
	}
	else
	{
		var PoString = document.getElementById('txtpono').value;
		var poNo = PoString.substr(5,PoString.length);
		var year = PoString.substr(0,4);
		//alert (poNo.substr(5,poNo.length));
	}
	
	intItemRowCount	= intC;
		
	var chkBx = document.getElementById('cboadd');
	var intCount=0;

    for (var loop=1;loop < tbl.rows.length ; loop ++ )
  	{
		var cbo = tbl.rows[loop].cells[0].childNodes[0].childNodes[1];
		if (cbo.checked) {
			var strDescription = tbl.rows[loop].cells[1].lastChild.nodeValue;
			var matDetailId = tbl.rows[loop].cells[4].id;
			/*var costCenterId = tbl.rows[loop].cells[5].id;
			var glAlloId = tbl.rows[loop].cells[6].id;*/
			var booCheck =true;	
			
			for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
			{
				var mainMatDetailId =tblMain.rows[mainLoop].cells[10].lastChild.nodeValue;
				/*var mainCostCenterId = tblMain.rows[mainLoop].cells[13].id;
				var mainGlAlloId = tblMain.rows[mainLoop].cells[14].id;*/
				//alert(matDetailId+' '+mainMatDetailId+' '+costCenterId+' '+mainCostCenterId)
				if(matDetailId==mainMatDetailId && costCenterId==mainCostCenterId && glAlloId==mainGlAlloId)
				{
					alert("Sorry !\nItem : "+ strDescription + "\nAlready added.");
					booCheck =false;	
				}
				
					
			}
				if(booCheck){
					/*createXMLHttpRequest1(loop);
					xmlHttp1[loop].onreadystatechange=HandleRequest;
					xmlHttp1[loop].num = loop;
					var url = 'genxml.php?id=addItemToGrn&strDescription='+ URLEncode(strDescription) +'&No='+ loop + '&poNo=' + poNo+ '&year=' + year+'&matDetailId='+matDetailId+'&costCenterId='+costCenterId;
					xmlHttp1[loop].open("GET", url, true);
					xmlHttp1[loop].send(null);*/
					var url = 'genxml.php?id=addItemToGrn&strDescription='+ URLEncode(strDescription) +'&No='+ loop + '&poNo=' + poNo+ '&year=' + year+'&matDetailId='+matDetailId;
					var htmlobj=$.ajax({url:url,async:false});
					HandleRequest(htmlobj);
				}
				
		
		}

	}
}


function HandleRequest(htmlobj)
{	
    /*if(xmlHttp1[this.num].readyState == 4) 
    {
        if(xmlHttp1[this.num].status == 200) 
        {  */
				var XMLmainCat = htmlobj.responseXML.getElementsByTagName("strMainCategory");	
				var strMainCategory = XMLmainCat[0].childNodes[0].nodeValue;

				var XMLsubCat = htmlobj.responseXML.getElementsByTagName("strSubCategory");	
				var strSubCategory = XMLsubCat[0].childNodes[0].nodeValue;
				
				var XMLItemCode = htmlobj.responseXML.getElementsByTagName("strItemCode");
				var strItemCode = XMLItemCode[0].childNodes[0].nodeValue;
	
				var XMLdesc = htmlobj.responseXML.getElementsByTagName("Description");	
				var Description = XMLdesc[0].childNodes[0].nodeValue;
				
				var XMLunit = htmlobj.responseXML.getElementsByTagName("strUnit");	
				var strUnit = XMLunit[0].childNodes[0].nodeValue;
				
				var XMLunitPrice = htmlobj.responseXML.getElementsByTagName("dblUnitPrice");	
				var dblUnitPrice = XMLunitPrice[0].childNodes[0].nodeValue;
				
				var XMLpending = htmlobj.responseXML.getElementsByTagName("dblPending");	
				var dblPending = XMLpending[0].childNodes[0].nodeValue;
				
				var XMLmatDetId = htmlobj.responseXML.getElementsByTagName("intMatDetailID");	
				var intMatDetailID = XMLmatDetId[0].childNodes[0].nodeValue;
				
				/*var XMLCostcenterID = htmlobj.responseXML.getElementsByTagName("costCenterId");	
				var CostcenterID = XMLCostcenterID[0].childNodes[0].nodeValue;
				
				var costCenter = htmlobj.responseXML.getElementsByTagName("costCenter")[0].childNodes[0].nodeValue;
				var glAlloId = htmlobj.responseXML.getElementsByTagName("glAlloId")[0].childNodes[0].nodeValue;
				var glAccId = htmlobj.responseXML.getElementsByTagName("glAccId")[0].childNodes[0].nodeValue;
				var costCenterCode = htmlobj.responseXML.getElementsByTagName("costCenterCode")[0].childNodes[0].nodeValue;*/
				//checking validate list
				var tbl = document.getElementById('tblMainGrn');
									
					var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
					row.className="bcgcolor-tblrowWhite";
					tbl.rows[lastRow].id = ++nextGrnIndex;
					
				var text1 =  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		  
				  var intGenPONo				= (text1[0]).split("/")[1];
				  var intYear				= (text1[0]).split("/")[0];
				
				
				var strInnerHtml="";
              strInnerHtml +="<td><div align=\"center\"><img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"delRow(this)\"/></div></td>";//delete button
			  strInnerHtml +="<td class=\"normalfnt\">"+strMainCategory+"</td>";			//Description
			  strInnerHtml +="<td class=\"normalfnt\">"+strSubCategory+"</td>";				//Description
			  strInnerHtml +="<td class=\"normalfnt\">"+strItemCode+"</td>";				//Description
              strInnerHtml +="<td class=\"normalfnt\">"+Description+"</td>";				//Description
              strInnerHtml +="<td class=\"normalfnt\">"+strUnit+"</td>";				//Unit
              strInnerHtml +="<td class=\"normalfntRite\">"+dblUnitPrice+"</td>";			//Rate
              strInnerHtml +="<td class=\"normalfntRite\">"+dblPending+"</td>";				//Pending Qty
strInnerHtml +="<td class=\"normalfntRite\"><input name=\"txtbatchno2\" type=\"text\" class=\"txtbox\" id=\"txtbatchno2\" size=\"15\" style=\"text-align:right\" value=\"" + dblPending + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>";					//Recived Qty
			  strInnerHtml +="<td class=\"normalfntMid\">0</td>";		//Excess Qty
              strInnerHtml +="<td class=\"normalfntRite\">"+RoundNumbers(dblUnitPrice*dblPending,4)+"</td>";//Value
              /*strInnerHtml +="<td class=\"normalfntRite\"><img src=\"../../../images/location.png\" alt=\"Add Bin\" width=\"90\" height=\"20\" onclick=\"showBin("+intMatDetailID+",this)\" /></td>";		*/			//Location
              strInnerHtml +="<td class=\"normalfntMid\">"+intMatDetailID+"</td>";			//Mat Cat Id
              strInnerHtml +="<td class=\"normalfntMid\">"+intYear+"</td>";					//year
              strInnerHtml +="<td class=\"normalfntMid\">"+intGenPONo+"</td>";					//Po No
			/*  strInnerHtml +="<td class=\"normalfnt\" id=\""+CostcenterID+"\">"+costCenter+"</td>";	//costcenter		
			   strInnerHtml +="<td class=\"normalfnt\" id=\""+glAlloId+"\">"+glAccId+'-'+costCenterCode+"</td>";*/	//glAllocation	
				tbl.rows[lastRow].innerHTML=  strInnerHtml ;
				intItemRowCount-=1;
				if(intItemRowCount==0)
				{
					findGrnValue(this);
				}
	/*			
		}
	}*/
}

function delRow(objDel)
{
	var tblTable = 	document.getElementById("tblMainGrn");
	
	var grnIndexNo		 =objDel.parentNode.parentNode.parentNode.id;
	tblTable.deleteRow(objDel.parentNode.parentNode.parentNode.rowIndex);
	
	tblTable		= 	document.getElementById("tblMainBin");
/*	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		if(tblTable.rows[loop].id==grnIndexNo){
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
		}
	}
*/	
}

function CheckforValidDecimal(sCell,decimalPoints,evt)
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

function calculation1(sCell)
{
	var value=sCell.value;
	sCell.parentNode.parentNode.cells[10].lastChild.nodeValue=RoundNumbers(parseFloat(value*sCell.parentNode.parentNode.cells[6].lastChild.nodeValue),4);
	if(parseFloat(sCell.parentNode.parentNode.cells[7].lastChild.nodeValue) < value)
	{
		var exQty = parseFloat(value) - parseFloat(sCell.parentNode.parentNode.cells[7].lastChild.nodeValue);
		sCell.parentNode.parentNode.cells[9].lastChild.nodeValue =RoundNumbers(exQty,4);
	}
	else
	{
		sCell.parentNode.parentNode.cells[9].lastChild.nodeValue = 0;
	}
}


function createXMLHttpRequest1(index) 
{
	try
	 {
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
function createXMLHttpRequest2(index) 
{
	try
	 {
	 xmlHttp2[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
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
function Get_meterial(intMatDetailID)
{
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = matDetailsIdRequest;
    xmlHttp.open("GET", 'genxml.php?id=intMatDetailId&value='+intMatDetailID, true);
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
			Load_Locations(strValue[1]);
		}
	}
}


function setValue()
{
	var tblGrn = document.getElementById("tblMainGrn");	
	if (pub_dblBinLoadQty>0)
	{
		tblGrn.rows[pub_intRow].cells[9].childNodes[0].value=pub_dblBinLoadQty;
	}

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

		var objrow = objButton.parentNode.parentNode.parentNode;
		var strBin = objrow.cells[0].lastChild.nodeValue;
		var dblBinCapacity = objrow.cells[1].lastChild.nodeValue;
		var dblBinAvailable = objrow.cells[2].lastChild.nodeValue;
		var dblBinReqQty = objrow.cells[3].lastChild.value;
		var strLocation = document.getElementById("cboLocation").value;
		
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
					tblSecondBin.innerHTML += "<tr>"+
											"<td><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\"/></div></td>"+
											"<td class=\"normalfntMid\">"+strBin+"</td>"+
											"<td class=\"normalfntMid\">"+dblBinCapacity+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinAvailable+"</td>"+
											"<td class=\"normalfntRite\">"+dblBinReqQty+"</td>"+
											"<td class=\"normalfntRite\">"+strLocation+"</td>"+
											"</tr>";	
					}

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
	if(parseFloat(txtReqQty.parentNode.parentNode.cells[2].lastChild.nodeValue)<parseFloat(txtReqQty.value))
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
	var tblGrn = document.getElementById("tblMainGrn");
	var dblTotalValue=0;
	for(var loop=1;loop<=tblGrn.rows.length;loop++)
	{
		try
		{
		var value = parseFloat(tblGrn.rows[loop].cells[10].lastChild.nodeValue);
		dblTotalValue+=value;
		}
		catch(err)
		{}
	}
	
	try
	{
		if(parseFloat(document.getElementById("txtGrnValue").value)!=dblTotalValue)
		{	
			var intMatDetailID=objBox.parentNode.parentNode.cells[13].childNodes[0].nodeValue;
			var button=objBox.parentNode.parentNode.cells[12].childNodes[0];
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
	
	document.getElementById("butSave").style.display="none";
}

function save(type)
{
	if(grnValidation()==false)
		return;
	showPleaseWait();	
	save_GrnHeader(type);
	//document.getElementById("butSave").style.display="none";
	
}


function save_GrnHeader(type)
{
		  var text1 =  (document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text).split("--");
		  
		  var intGenPoNo				= (text1[0]).split("/")[1];
		  var intGenPoYear				= (text1[0]).split("/")[0];
		  //done
		  
		  var dtRecdDate		= document.getElementById("grnDate").value;//txtbatchno

		  var strInvoiceNo			= document.getElementById("txtinvoiceno").value;
		  var strSupAdviceNo		= document.getElementById("txtsupadviceno").value;

		  var dtAdviceDate			= document.getElementById("adviceDate").value;
		
		  var text1				= document.getElementById("txtgrnno").value;
				if( text1 == ""){
					var strGenGrnNo		= "";
					var intBulkGrnyear		= "";
				}
				else{
					var strGenGrnNo		= (text1).split("/")[1];
					var intBulkGrnyear		= (text1).split("/")[0];
				}

		var url  = "gendb.php?id=saveGrnHeader";
		url += "&strGenGrnNo="+strGenGrnNo;
		url += "&intBulkGrnyear="+intBulkGrnyear;
		url += "&intGenPoNo="+intGenPoNo;
		url += "&intGenPoYear="+intGenPoYear;
		url += "&dtRecdDate="+dtRecdDate;
		url += "&strInvoiceNo="+strInvoiceNo;
		url += "&strSupAdviceNo="+strSupAdviceNo;
		url += "&dtAdviceDate="+dtAdviceDate;
	var htmlobj=$.ajax({url:url,async:false});
	
	pub_intGrnNo= htmlobj.responseText;
		 
	document.getElementById("txtgrnno").value=pub_intGrnNo;
	if(pub_intGrnNo!="Saving-Error")
	{
	  if(pub_intGrnNo=="exceedRange")
	  {
		  alert("GRN no is exceeded");
		  alert("GRN is not saved");
		  document.getElementById("butSave").style.display="inline";
		  hidePleaseWait();
	  }
	  else
	  {
			save_GrnDetail(pub_intGrnNo,type);
	  }
	}
	else if(pub_intGrnNo==1)
	{
		alert("GRN Header Saved successfully");
		hidePleaseWait();
	}
	else
	{
		alert("GRN Header Not Saved");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
	}
	
}


function grnValidation()
{
	//	validate po no
	var strPoNo	= document.getElementById("txtpono").options[document.getElementById('txtpono').selectedIndex].text;
	if(strPoNo=="")
	{
		alert("Please select 'PO No'.");
		return false;
	}
	
	//validate suplier advice no
	var strAdviceNo	= document.getElementById("txtsupadviceno").value;
	if(strAdviceNo=="")
	{
		alert("Please enter 'Supplier Advice No'.");
		document.getElementById("txtsupadviceno").focus();
		return false;
	}
	
	//validate suplier advice no
	var strInvoiceNo	= document.getElementById("txtinvoiceno").value;
	if(strInvoiceNo=="")
	{
		alert("Please enter 'Invoice No'.");
		document.getElementById("txtinvoiceno").focus();
		return false;
	}
	
	var strInvoiceNo	= document.getElementById("grnDate").value ;
	if(strInvoiceNo=="")
	{
		alert("Please select 'GRN Date'");
		document.getElementById("grnDate").focus();
		return false;
	}
	
	var adviceDate	= document.getElementById("adviceDate").value ;
	if(adviceDate=="")
	{
		alert("Please select 'Supplier Advice Date'.");
		document.getElementById("grnDate").focus();
		return false;
	}
	var tbl = document.getElementById("tblMainGrn")
	var rowCount = tbl.rows.length
	if(rowCount == 1)
	{
		alert("Please add item(s) before save");
		return false;
	}
	return true;
}

//===============================================================================================================
//================================================= GRN DETAILS   ===============================================
//===============================================================================================================

function save_GrnDetail(strBulkGrn_Year,type)
{
		var tblGrn = document.getElementById("tblMainGrn");
		pub_intxmlHttp_count = tblGrn.rows.length-1;
		
		  var strGenGrnNo		= strBulkGrn_Year.split("/")[1];
		  var intBulkGrnYear	= strBulkGrn_Year.split("/")[0];
		
		for(var loop=1;loop<tblGrn.rows.length;loop++)
		{
			//alert(loop);
			var row = tblGrn.rows[loop];
						
		var url  = "gendb.php?id=saveGrnDetails";
			url += "&count="+loop;
			url += "&strGenGrnNo="+strGenGrnNo;
			url += "&intBulkGrnYear="+intBulkGrnYear;
			url += "&intMatDetailID="+row.cells[11].childNodes[0].nodeValue;
			url += "&dblQty="+row.cells[8].childNodes[0].value;
			url += "&dblCapacityQty="+row.cells[7].childNodes[0].nodeValue;
			url += "&dblExcessQty="+row.cells[9].lastChild.nodeValue;
			url += "&dblRate="+row.cells[6].lastChild.nodeValue;
			url += "&intYear="+row.cells[12].lastChild.nodeValue;
			url += "&intGenPONo="+row.cells[13].lastChild.nodeValue;
			url += "&strUnit="+row.cells[5].lastChild.nodeValue;
			url += "&strInvoiceNo="+document.getElementById("txtinvoiceno").value;
			url += "&strDesc="+row.cells[4].lastChild.nodeValue;
			/*url += "&costCenterId="+row.cells[13].id;
			url += "&glAlloId="+row.cells[14].id;*/
			/*xmlHttp2[loop].open("GET", url, true);
			xmlHttp2[loop].send(null);	*/
			var htmlobj=$.ajax({url:url,async:false});
			//alert(htmlobj.responseText);
			var intNo = htmlobj.responseText;
			var grnNo = intNo.split("-")[1];
			intNo = intNo.split("-")[0];
			//alert(intNo);
			if(intNo==1)
			{
				
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				if (pub_intxmlHttp_count ==0 && type==0)
				{
					//alert("GRN Details Successfully Saved");
					alert("General GRN " + grnNo + " saved successfully  !");
					document.getElementById("butSave").style.display="inline";
					document.getElementById("butConform").style.display="inline";
					hidePleaseWait();
				}
					
			}
			else
			{
				alert( "GRN details saving error...");
				document.getElementById("butSave").style.display="inline";
				hidePleaseWait();
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
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
function loadGrnFrom(intGrnNo,intYear,intStatus)
{
	//alert(intGrnNo +" "+ intYear  +" "+ intStatus )
	if ((intGrnNo!=0)||(intYear!=0))
	{
		if(intStatus==1)
		{
			document.getElementById("butSave").style.display="none";
			document.getElementById("butConform").style.display="none";
			document.getElementById("butCancel").style.display="inline";
			//alert(1);
		}
		else if(intStatus==10)
		{
			document.getElementById("butSave").style.display="none";
			document.getElementById("butConform").style.display="none";
			document.getElementById("butCancel").style.display="inline";
		}
		else if(intStatus==0)
		{
			document.getElementById("butCancel").style.display="none";
		}
		//  ==============================   GRN HEADER PART  ============================
		document.getElementById("txtgrnno").value = intYear +"/"+ intGrnNo;
		
		loadGRNheader(intGrnNo,intYear,intStatus);
		
		
	}	
	else
	{
		document.getElementById("butConform").style.display="none";
		document.getElementById("butCancel").style.display="none";
	}
}

function loadGRNheader(intGrnNo,intYear,intStatus)
{
	var url  = "genxml.php?id=loadGrnHeader";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;
			url += "&intStatus="+intStatus;
	var htmlobj=$.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	var hasRecord = htmlobj.responseXML.getElementsByTagName("hasRecord")[0].childNodes[0].nodeValue;
			
			if(hasRecord ==0)
			{
				document.getElementById("txtgrnno").value="";
				alert("Record not found");
				newPage();
				return;
			}
			var strNPONO =  htmlobj.responseXML.getElementsByTagName("NPONO")[0].childNodes[0].nodeValue;
			var Supplier =  htmlobj.responseXML.getElementsByTagName("Supplier")[0].childNodes[0].nodeValue;
			//document.getElementById("txtpono").value = strNPONO;
			// Roshan stop cording heres
			/*** shivanka strat ***/
			RemovePo();
			var opt = document.createElement("option");
			opt.text = strNPONO + " -- " + Supplier ;
			opt.value = strNPONO + " -- " + Supplier  ;
			document.getElementById("txtpono").options.add(opt);
			
			document.getElementById("txtsupadviceno").value = htmlobj.responseXML.getElementsByTagName("strSupAdviceNo")[0].childNodes[0].nodeValue;
				var m,m1;
				m = htmlobj.responseXML.getElementsByTagName("dtAdviceDate")[0].childNodes[0].nodeValue;
				m1 = m.split(" ");
			document.getElementById("adviceDate").value =m1[0];
			//document.getElementById("txtbatchno").value =xmlHttp.responseXML.getElementsByTagName("strBatchNO")[0].childNodes[0].nodeValue;
				var d = htmlobj.responseXML.getElementsByTagName("dtRecdDate")[0].childNodes[0].nodeValue;
				var d1 = "";
				d = d.split("-");
				d1= d[2].substring(0,2)+"/"+d[1]+"/"+d[0];
			
			document.getElementById("grnDate").value =d1;
			document.getElementById("txtinvoiceno").value =htmlobj.responseXML.getElementsByTagName("strInvoiceNo")[0].childNodes[0].nodeValue;
			
			loadGRNDetails(intGrnNo,intYear);
}



function loadGRNDetails(intGrnNo,intYear)
{
	var url  = "genxml.php?id=loadgrndetail";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;	
	var htmlobj=$.ajax({url:url,async:false});
	var tbl = document.getElementById('tblMainGrn');
			
			var XMLMaterial = htmlobj.responseXML.getElementsByTagName("Material");	
			var XMLCategory = htmlobj.responseXML.getElementsByTagName("Category");	
			var XMLDescription = htmlobj.responseXML.getElementsByTagName("strItemDescription");	
			var XMLstrUnit = htmlobj.responseXML.getElementsByTagName("strUnit");
			var XMLdblQty = htmlobj.responseXML.getElementsByTagName("dblQty");	
			var XMLdblUnitPrice = htmlobj.responseXML.getElementsByTagName("dblUnitPrice");
			var XMLdblAdditionalQty = htmlobj.responseXML.getElementsByTagName("dblExcessQty");
			var XMLdblPending = htmlobj.responseXML.getElementsByTagName("dblBalance");	
			var XMLintMatDetailID = htmlobj.responseXML.getElementsByTagName("intMatDetailID");
			var XMLPoNo = htmlobj.responseXML.getElementsByTagName("intGenPONo");	
			var XMLPoYear = htmlobj.responseXML.getElementsByTagName("intYear");
			var xmlCostCenter = htmlobj.responseXML.getElementsByTagName("costCenter");
			var xmlCostcenterId = htmlobj.responseXML.getElementsByTagName("costCenterID");
			var xmlGLId = htmlobj.responseXML.getElementsByTagName("intGLId");
			var xmlGLAccNo = htmlobj.responseXML.getElementsByTagName("strAccID");
			var xmlGLCostCenterCode =  htmlobj.responseXML.getElementsByTagName("costCenterCode");
			var xmlItemCode =  htmlobj.responseXML.getElementsByTagName("ItemCode");
			
			for(var loop =0;loop<XMLDescription.length;loop++)
			{	 
					var Material = XMLMaterial[loop].childNodes[0].nodeValue;
					var Category = XMLCategory[loop].childNodes[0].nodeValue;
					var Description = XMLDescription[loop].childNodes[0].nodeValue;
					var strUnit = XMLstrUnit[loop].childNodes[0].nodeValue;
					var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
					var dblUnitPrice = XMLdblUnitPrice[loop].childNodes[0].nodeValue;
					var dblAdditionalQty = XMLdblAdditionalQty[loop].childNodes[0].nodeValue;
					var dblPending = XMLdblPending[loop].childNodes[0].nodeValue;
					var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
					var intMatDetailID = XMLintMatDetailID[loop].childNodes[0].nodeValue;
					var intGenPONo = XMLPoNo[loop].childNodes[0].nodeValue;
					var intYear = XMLPoYear[loop].childNodes[0].nodeValue;
					var costCenter = xmlCostCenter[loop].childNodes[0].nodeValue;
					var costCenterID = xmlCostcenterId[loop].childNodes[0].nodeValue;
					var GLId = xmlGLId[loop].childNodes[0].nodeValue;
					var GLAccNo = xmlGLAccNo[loop].childNodes[0].nodeValue;
					var GLCostCenterCode = xmlGLCostCenterCode[loop].childNodes[0].nodeValue;
					var ItemCode = xmlItemCode[loop].childNodes[0].nodeValue;
					
					var strInnerHtml="";
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\"><div align=\"center\"><img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"delRow(this)\" /></div></td>";//delete button
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\">"+Material+"</td>";				//Description
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\">"+Category+"</td>";				//Description
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\">"+ItemCode+"</td>";				//Description
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\">"+Description+"</td>";				//Description
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\">"+strUnit+"</td>";				//Unit
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"right\">"+dblUnitPrice+"</td>";			//Rate
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"right\">"+dblPending+"</td>";				//Pending Qty
	strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\"><input name=\"txtbatchno2\" type=\"text\" class=\"txtbox\" id=\"txtbatchno2\" size=\"15\" style=\"text-align:right\" value=\"" + dblQty + "\" onkeyup=\"calculation1(this);\" onblur=\"findGrnValue(this);\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>";							//Recived Qty
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"right\">"+dblAdditionalQty+"</td>";		//Excess Qty
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"right\">"+Math.round((dblUnitPrice*dblQty)*1000)/1000+"</td>";	//Value
				  /*strInnerHtml +="<td class=\"normalfntRite\"><img src=\"../../../images/location.png\" alt=\"Add Bin\" width=\"90\" height=\"20\" onclick=\"showBin("+intMatDetailID+",this)\" /></td>";						//Location*/
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"center\">"+intMatDetailID+"</td>";			//Mat Cat Id
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"center\">"+intYear+"</td>";					//year
				  strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" align=\"center\">"+intGenPONo+"</td>";					//Po No
				   /* strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" id=\""+costCenterID+"\">"+costCenter+"</td>"; //cost center
					 strInnerHtml +="<td class=\"bcgcolor-tblrowWhite\" id=\""+GLId+"\">"+GLAccNo+'-'+GLCostCenterCode+"</td>"; //GL Allocation details*/
				  /*strInnerHtml +="<td class=\"normalfntMid\">Issued Qty</td>"					//Issued Qty
				  strInnerHtml +="<td class=\"normalfntMid\">Rec Qty</td>";						//Rec Qty*/
				
					var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
					
					tbl.rows[lastRow].innerHTML=  strInnerHtml ;
					tbl.rows[lastRow].id = lastRow;
					
					tbl.rows[lastRow].className = "bcggreen";
					
					pub_intRow = loop+1;
					
				}
			findGrnValue(this);		
}



function conform()
{
	//showPleaseWait();
	if(! confirm("Are you sure you want to confrim this GRN?"))
		return ;
	save(1);
	  var text1 	=  	document.getElementById("txtgrnno").value.split("/");
	  var intYear	= 	(text1[0]);
	  var intGrnNo 	= 	(text1[1]);
			  
		//createXMLHttpRequest();
		//xmlHttp.onreadystatechange = grnConfirmedRequest;
		var url  = "gendb.php?id=confirmed";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;
		//xmlHttp.open("GET",url,true);
		//xmlHttp.send(null);
		var htmlobj=$.ajax({url:url,async:false});
		var intIsSave = htmlobj.responseText;
		if(intIsSave==1)
			saveStockTransaction();
}

function grnConfirmedRequest()
{
	if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        {  
			var intIsSave = xmlHttp.responseText;
			//alert(intIsSave);
			if(intIsSave==1)
			{
				saveStockTransaction();
			
			}
		}
	}
}

function saveStockTransaction()
{
	var text1 	=  	document.getElementById("txtgrnno").value.split("/");
	var intYear	= 	(text1[0]);
	var intGrnNo 	= 	(text1[1]);

	var tblGrn = document.getElementById("tblMainGrn");
	
	var arrMatDetID = "";
	var arrQty = "";
	var arrUnit = "";
	var costcenterID="";
	for(var loop=1;loop<tblGrn.rows.length;loop++)
		{
			var row = tblGrn.rows[loop];
			arrMatDetID = row.cells[11].lastChild.nodeValue ;
			arrQty = row.cells[8].childNodes[0].value;
			arrUnit  = row.cells[5].lastChild.nodeValue;
			
			var url  = "gendb.php?id=saveStockTransaction";
			url += "&intGrnNo="+intGrnNo;
			url += "&intYear="+intYear;
			url += "&arrMatdetID=" + arrMatDetID;
			url += "&arrQty=" + arrQty;
			url += "&arrUnit=" + arrUnit;
			var htmlobj=$.ajax({url:url,async:false});
		}
	
	
	
	alert("Confirmed successfully ");
	document.getElementById("butConform").style.display="none";
	document.getElementById("butSave").style.display="none";
	document.getElementById("butCancel").style.display="inline";
	hidePleaseWait();
	
}

//============================== report

function grnReport()
{
	//var path = document.location.protocol+'/'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	/*var path = "gengrnReport.php?grnno="+document.getElementById("txtgrnno").value;
	document.location.href = path;*/
	if(document.getElementById("txtgrnno").value==''){
	alert("No GRN No to Preview");	
	return false;
	}
	var No	= document.getElementById("txtgrnno").value;
	newwindow=window.open('gengrnReport.php?grnno='+No,'name');
			if (window.focus) {newwindow.focus()}
}

//===============================CANCEL GRN===========
function cancel()
{
	var strBulkGrn_Year = document.getElementById("txtgrnno").value;
	
	showPleaseWait();
	
	var reason = prompt("Please enter GRN cancel reason", "");
	if(reason == '' || reason == null)
	{
		alert('Can not cancel GRN without having a reason');
		hidePleaseWait();
		return false;
	}
		var tblGrn = document.getElementById("tblMainGrn");
		pub_intxmlHttp_count = tblGrn.rows.length-1;
		
		  var strGenGrnNo		= strBulkGrn_Year.split("/")[1];
		  var intBulkGrnYear	= strBulkGrn_Year.split("/")[0];
		
		var url  = "gendb.php?id=cancelGrnDetails";
			url += "&strGenGrnNo="+strGenGrnNo;
			url += "&intBulkGrnYear="+intBulkGrnYear;
			url += "&reason="+URLEncode(reason);
		var htmlobj=$.ajax({url:url,async:false});
		
		var response = htmlobj.responseText;
		if(response==1)
		{
			alert("cancelled Successfully ");
			document.getElementById("butCancel").style.display="none";
			hidePleaseWait();
		}
		else
		{
			alert(htmlobj.resposeText);
			hidePleaseWait();
		}
		
}



function SelectAll(obj)
{

	var tbl = document.getElementById('tblItem');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(obj.checked){
			tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked = true;
		}
		else
			tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked= false;
			
	}
	
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
function removePoItems()
{
	$("#tblMainGrn tr:gt(0)").remove();
}