// JavaScript Document
var xmlHttp;
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
function GetCompanyPOList()
{    
	var CompanyID = document.getElementById('cboFactory').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePOList;
    xmlHttp.open("GET", 'buyerPOMiddletire.php?RequestType=GetBuyerPOListForCompany&CompanyID=' + CompanyID, true);
    xmlHttp.send(null);     
}

function HandlePOList()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLStyleID = xmlHttp.responseXML.getElementsByTagName("StyleNo");
			 var XMLQTY = xmlHttp.responseXML.getElementsByTagName("QTY");
			 
			 RemoveAllRows();
			 for ( var loop = 0; loop < XMLStyleID.length; loop ++)
			 {
				var styleID = XMLStyleID[loop].childNodes[0].nodeValue;
				var QTY  = XMLQTY[loop].childNodes[0].nodeValue;

				
				
				var tbl = document.getElementById('tblPreOders');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				var cellConPc = row.insertCell(0);
				cellConPc.innerHTML = styleID;
				
				
				var cellConPc = row.insertCell(1);
				cellConPc.innerHTML = QTY;
				
				
				var cellDelete = row.insertCell(2);   
				var imgtext = "<a href=\"#\" ><img id=\"" + styleID + "\" onCLick=\"viewForm('" + styleID + "');\" class=\"noborderforlink\" src=\"images/view.png\"></a>";
				
				/*
				var viewImage = new Image(); 
				viewImage.src = "images/view.png";
				viewImage.id = styleID;
				viewImage.onclick = viewForm;
				cellDelete.appendChild(viewImage);
				*/
				cellDelete.innerHTML = imgtext;
				
			 }
			
		}
	}
}

function viewForm(styleNo)
{
	location="buyerPO.php?styleID=" + URLEncode(styleNo);
}

function GetTargetPOs()
{    
	var styleNo = document.getElementById('txtstyle').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandlePOList;
    xmlHttp.open("GET", 'buyerPOMiddletire.php?RequestType=GetBuyerPOListForStyle&StyleNO=' + URLEncode(styleNo), true);
    xmlHttp.send(null);     
}


function RemoveAllRows()
{
	var tbl = document.getElementById('tblPreOders');
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function RemovePONumber(obj)
{
	var td = obj.parentNode;
	var tr = td.parentNode;
	tr.parentNode.removeChild(tr);
	document.getElementById('txttotalqty').value = getCalculateTotal();
}

function RemoveDynamicPONumber(obj)
{
	var td = this.parentNode;
	var tr = td.parentNode;
	tr.parentNode.removeChild(tr);
	document.getElementById('txttotalqty').value = getCalculateTotal();
}

function getCalculateTotal()
{
	//alert(document.getElementById('lblTotalQty').lastChild.nodeValue);
	var tbl = document.getElementById('BuyerPO');
	var total = 0;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var qty = parseFloat(rw.cells[2].lastChild.nodeValue);
		total += qty;
	}
	return total;	
}

function ValidateNewPONO()
{
	if (document.getElementById('txtbuyerpo').value == null || document.getElementById('txtbuyerpo').value == "")
	{
		alert("Please enter buyer PO No.");
		document.getElementById('txtbuyerpo').focus();
		return false;
	}
	else if (document.getElementById("txtqty").value == null || document.getElementById("txtqty").value == "")
	{
		alert("Please enter the quantity.");
		document.getElementById('txtqty').focus();
		return false;
	}
	else if (document.getElementById("txtqty").value <= 0 || document.getElementById("txtqty").value > (parseInt(document.getElementById('lblTotalQty').lastChild.nodeValue) - getCalculateTotal()))
	{
		alert("Please enter valid quantity.");
		document.getElementById('txtqty').focus();
		return false;	
	}
	return true;
	
}

function AddNewPO()
{
	if (ValidateNewPONO())
	{
		var poNo = document.getElementById('txtbuyerpo').value;
		var qty = document.getElementById("txtqty").value;
		var country = document.getElementById("cbocountry").value;
		var remarks = document.getElementById("txtremarks").value;
		if (CheckNODuplicatePOs(poNo))
		{
			AddNewRow(poNo, qty, country, remarks);
			ClearForm();
		}
		document.getElementById("txttotalqty").value = getCalculateTotal();
		
	}
}

function AddNewRow(poNo, qty, country, remarks)
{
	var tbl = document.getElementById('BuyerPO');
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		var cellDelete = row.insertCell(0);     
		var delImage = new Image(); 
		delImage.src = "images/del.png";
		delImage.className="mouseover";
		delImage.onclick = RemoveDynamicPONumber;
		cellDelete.appendChild(delImage);
		
		var cellUnitPrice = row.insertCell(1);     
		cellUnitPrice.className="normalfnt";
		cellUnitPrice.innerHTML = poNo;
		
		var cellUnitPrice = row.insertCell(2);     
		cellUnitPrice.className="normalfntRite";
		cellUnitPrice.innerHTML = qty;
		
		var cellUnitPrice = row.insertCell(3);     
		cellUnitPrice.className="normalfntMid";
		cellUnitPrice.innerHTML = country;
		
		var cellUnitPrice = row.insertCell(4);     
		cellUnitPrice.className="normalfnt";
		cellUnitPrice.innerHTML = (remarks == "" ? " " : remarks);
}

function CheckNODuplicatePOs(newPO)
{
	var tbl = document.getElementById('BuyerPO');
	var total = 0;
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var currentName = rw.cells[1].lastChild.nodeValue;
		if ( currentName == newPO)
		{
			alert("The given PO number already exists.");	
			return false;
		}
	}
	return true;
}

function SaveBuyerPOs()
{
	if (getCalculateTotal() != parseInt(document.getElementById('lblTotalQty').lastChild.nodeValue))
	{
		alert("The sum of given quantities does not match with total quantity.");	
		ClosePreloader();
	}
	else
	{
		var tbl = document.getElementById('BuyerPO');
		var styleNo = document.getElementById('lblStyleNo').lastChild.nodeValue;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var rw = tbl.rows[loop];
			var BuyerPONumber = rw.cells[1].lastChild.nodeValue;
			var qty = rw.cells[2].lastChild.nodeValue;
			var country = rw.cells[3].lastChild.nodeValue;
			var remarks = "";
			if (rw.cells[4].lastChild != null)
			remarks = rw.cells[4].lastChild.nodeValue;
			
		    createXMLHttpRequest();

			//xmlHttp.onreadystatechange = HandlePOList;
			xmlHttp.open("GET", 'buyerPOMiddletire.php?RequestType=SaveBuyerPO&StyleID=' + URLEncode(styleNo) + '&BuyerPO=' + BuyerPONumber + '&qty=' + qty + '&Country=' +  country + '&Remarks=' + URLEncode(remarks), true);
			xmlHttp.send(null); 
		}
		GetBPOAcknowledgement();
	}
}

function GetBPOAcknowledgement()
{
	var styleNo = document.getElementById('lblStyleNo').lastChild.nodeValue;
	var tbl = document.getElementById('BuyerPO');	
	var pocount = tbl.rows.length-1;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleBPOAcknowledgement;
    xmlHttp.open("GET", 'buyerPOMiddletire.php?RequestType=GetAcknowledgment&styleID=' + URLEncode(styleNo) + '&count=' + pocount , true);
    xmlHttp.send(null);	
}

function HandleBPOAcknowledgement()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			redirectRequire = false;
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("State");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				buyerPOQty = getCalculateTotal();
				redirectRequire = true;
				alert("Buyer PO Number Saving Completed.");
				ClosePreloader();
			}
			else
			{
				redirectRequire = false;				
			}
			
			if (redirectRequire == false)
			{
				GetBPOAcknowledgement();	
			}
		}
		
	}
}

function ShowPreLoader()
{
	var dialog = document.createElement("div");
    dialog.id = "preloader";
    dialog.style.position = 'absolute';
    dialog.style.zIndex = 60;
    dialog.style.left = 0 + 'px';
    dialog.style.top = 0 + 'px';  
	
	var HTMLText = "<table width=\"1200\" height=\"1400\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >" +
				  "<!--DWLayoutTable-->" +
				  "<tr>" +
					"<td width=\"150\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\" height=\"184\">&nbsp;</td>" +
					"<td width=\"261\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
					"<td width=\"239\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
				  "</tr>" +
				  "<tr bgcolor=\"#000000\">" +
					"<td height=\"37\">&nbsp;</td>" +
					"<td valign=\"middle\"><div align=\"center\"  class=\"headRed\">Please Wait ..... </div></td>" +
					"<td>&nbsp;</td>" +
				  "</tr>" +
				  "<tr>" +
					"<td height=\"1200\" class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
					"<td class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
					"<td class=\"backgroundSelecterStyle\" style=\"filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;\">&nbsp;</td>" +
				  "</tr>" +
				"</table>";
				
	dialog.innerHTML = HTMLText;     
    document.body.appendChild(dialog);
}

function ClosePreloader()
{
	try
    {
        var bgbox = document.getElementById('preloader');
        bgbox.parentNode.removeChild(bgbox);
    }
    catch(err)
    {
    }
}

function MakeDatabaseForSaving()
{
	ShowPreLoader();
	var styleNO = document.getElementById('lblStyleNo').lastChild.nodeValue;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleMakeDatabase;
	xmlHttp.open("GET", 'buyerPOMiddletire.php?RequestType=DeletePos&styleID=' + URLEncode(styleNO), true);
	xmlHttp.send(null); 
}

function HandleMakeDatabase()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("State");
			if (XMLStyle[0].childNodes[0].nodeValue == "True")
			{
				SaveBuyerPOs();
			}
			else
			{
				alert("Sorry! There is a problem while prepairing the database please try again..");
			}
		}		
	}
}


function ClearForm()
{
	document.getElementById('txtbuyerpo').value = "";
	document.getElementById("txtqty").value = "";
	document.getElementById("txtremarks").value = "";
}