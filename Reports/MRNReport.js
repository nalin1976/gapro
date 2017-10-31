var StyleNo=""
var optOption=""

function CreateXMLHttpSC() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSC = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSC = new XMLHttpRequest();
    }
}

function CreateXMLHttpSubCat() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSubCat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSubCat = new XMLHttpRequest();
    }
}
function CreateXMLHttpItems()
{
    if (window.ActiveXObject) 
    {
        xmlHttpItems = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpItems = new XMLHttpRequest();
    }	
}

 

function CreateXMLHttpMRNs()
{
    if (window.ActiveXObject) 
    {
        xmlHttpMRNs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpMRNs = new XMLHttpRequest();
    }	
}

function SelectedOption()
{
	if(document.getElementById("optConfirmed").checked==true)	
	{
		optOption="Confirmed"
	}	
	if(document.getElementById("optCanceled").checked==true)	
	{
		optOption="Canceled"
	}	
	if(document.getElementById("optBalancedtoIssue").checked==true)	
	{
		optOption="BalancedToIssue"
	}	
	if(document.getElementById("optTotalIssued").checked==true)	
	{
		optOption="TotalIssued"
	}
	
}

function SCDataCollector()
{
	clearSelectControl("cboBuyerPO");
	clearSelectControl("cboCategories");
	clearSelectControl("cboItems");
	document.getElementById("cboMainMats").value=0
	
	StyleNo=document.getElementById("cboSCNo").value
	document.getElementById("cboStyle").value=document.getElementById("cboSCNo").value
	document.getElementById("cboOrderNo").value=document.getElementById("cboSCNo").value
	//getBuyerPONos(StyleNo)
	
}


function StyleDataCollector()
{
	clearSelectControl("cboBuyerPO");
	clearSelectControl("cboCategories");
	clearSelectControl("cboItems");
	document.getElementById("cboMainMats").value=0

	StyleNo=document.getElementById("cboStyle").value
	document.getElementById("cboSCNo").value=document.getElementById("cboStyle").value
	document.getElementById("cboOrderNo").value=document.getElementById("cboStyle").value
	//getBuyerPONos(StyleNo)
	
}

function OrderDataCollector()
{
	//clearSelectControl("cboBuyerPO");
	clearSelectControl("cboCategories");
	clearSelectControl("cboItems");
	document.getElementById("cboMainMats").value=0

	document.getElementById("cboSCNo").value=document.getElementById("cboOrderNo").value
	document.getElementById("cboStyle").value=document.getElementById("cboOrderNo").value	
}

function getItems()
{
	StyleNo=document.getElementById("cboStyle").value
	var MainMatID=document.getElementById("cboMainMats").value
	var SubCatID=document.getElementById("cboCategories").value
	
	CreateXMLHttpItems() 
	xmlHttpItems.onreadystatechange = HandleItems;
	xmlHttpItems.open("GET", 'MRNReportDB.php?Opperation=getItems&StyleNo=' + StyleNo + '&MainMatID=' + MainMatID + '&SubCatID=' + SubCatID, true);
	xmlHttpItems.send(null); 
	
}

function HandleItems()
{
	if(xmlHttpItems.readyState == 4) 
    {
	   if(xmlHttpItems.status == 200) 
        {  
			var XMLItemDescription = xmlHttpItems.responseXML.getElementsByTagName("strItemDescription");
			var XMLItemSerial = xmlHttpItems.responseXML.getElementsByTagName("intItemSerial");
			
			clearSelectControl("cboItems");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			document.getElementById("cboItems").options.add(optFirst);
			
			for ( var loop = 0; loop < XMLItemDescription.length; loop++)
			{
				var StrItem = XMLItemDescription[loop].childNodes[0].nodeValue;
				var intItemSerial = XMLItemSerial[loop].childNodes[0].nodeValue;
				var optData = document.createElement("option");			
				optData.text = StrItem;
				optData.value = intItemSerial;
				document.getElementById("cboItems").options.add(optData);			
			}
		}
	}

}

function getSubcategories()
{
	StyleNo=document.getElementById("cboStyle").value
	var MainMatID=document.getElementById("cboMainMats").value
	
	CreateXMLHttpSubCat() 
	xmlHttpSubCat.onreadystatechange = HandleSubCats;
	xmlHttpSubCat.open("GET", 'MRNReportDB.php?Opperation=getSubCategoies&StyleNo=' + StyleNo + '&MainMatID=' + MainMatID, true);
	xmlHttpSubCat.send(null); 
}

function HandleSubCats()
{
	if(xmlHttpSubCat.readyState == 4) 
    {
	   if(xmlHttpSubCat.status == 200) 
        {  
			var XMLStrCatName = xmlHttpSubCat.responseXML.getElementsByTagName("StrCatName");
			var XMLintSubCatID = xmlHttpSubCat.responseXML.getElementsByTagName("intSubCatID");
			
			clearSelectControl("cboCategories");
			clearSelectControl("cboItems");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			document.getElementById("cboCategories").options.add(optFirst);
			
			for ( var loop = 0; loop < XMLStrCatName.length; loop++)
			{
				var StrCatName = XMLStrCatName[loop].childNodes[0].nodeValue;
				var intSubCatID = XMLintSubCatID[loop].childNodes[0].nodeValue;
				var optData = document.createElement("option");			
				optData.text = StrCatName;
				optData.value = intSubCatID;
				document.getElementById("cboCategories").options.add(optData);			
			}
		}
	}
}

function getBuyerPONos(StyleNo)
{
	CreateXMLHttpSC();
	xmlHttpSC.onreadystatechange = HandleSCNo;
	xmlHttpSC.open("GET", 'MRNReportDB.php?Opperation=getStyleBuyerPONo&StyleNo=' + StyleNo, true);
	xmlHttpSC.send(null); 
	
}
function HandleSCNo()
{
	if(xmlHttpSC.readyState == 4) 
    {
	   if(xmlHttpSC.status == 200) 
        {  
			var XMLstrBuyerPONO = xmlHttpSC.responseXML.getElementsByTagName("strBuyerPONO");
			
			clearSelectControl("cboBuyerPO");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "#Main Ratio#";
			optFirst.value = 0;
			document.getElementById("cboBuyerPO").options.add(optFirst);
			
			for ( var loop = 0; loop < XMLstrBuyerPONO.length; loop++)
			{
				var strBuyerPONO = XMLstrBuyerPONO[loop].childNodes[0].nodeValue;
				var optData = document.createElement("option");			
				optData.text = strBuyerPONO;
				optData.value = strBuyerPONO;
				document.getElementById("cboBuyerPO").options.add(optData);			
			}
		}
	}
}

function getMRNDetails()
{
	StyleNo=document.getElementById("cboStyle").value
	var MainMatID=document.getElementById("cboMainMats").value
	var SubCatID=document.getElementById("cboCategories").value
	var MatDetailID=document.getElementById("cboItems").value
	//var BuyerPO=document.getElementById("cboBuyerPO").value
	var BuyerPO=0;
	SelectedOption()
	
	CreateXMLHttpMRNs() 
	xmlHttpMRNs.onreadystatechange = HandleMRNs;
	xmlHttpMRNs.open("GET", 'MRNReportDB.php?Opperation=getMRNDetails&StyleNo=' + StyleNo + '&MainMatID=' + MainMatID + '&SubCatID=' + SubCatID + '&MatDetailID=' + MatDetailID + '&BuyerPO=' + BuyerPO +'&optOption=' + optOption, true);
	xmlHttpMRNs.send(null); 
	
}

function HandleMRNs()
{
	if(xmlHttpMRNs.readyState == 4) 
    {
	   if(xmlHttpMRNs.status == 200) 
        {  
			var XMLintMatRequisitionNo = xmlHttpMRNs.responseXML.getElementsByTagName("intMatRequisitionNo");
			var XMLstrStyleNo = xmlHttpMRNs.responseXML.getElementsByTagName("strStyleNo");
			var XMLdtmDate = xmlHttpMRNs.responseXML.getElementsByTagName("dtmDate");
			var XMLstrItemDescription = xmlHttpMRNs.responseXML.getElementsByTagName("strItemDescription");
			var XMLstrColor = xmlHttpMRNs.responseXML.getElementsByTagName("strColor");
			var XMLstrSize = xmlHttpMRNs.responseXML.getElementsByTagName("strSize");
			var XMLdblQty = xmlHttpMRNs.responseXML.getElementsByTagName("dblQty");
			var XMLissueQty = xmlHttpMRNs.responseXML.getElementsByTagName("issueQty");
			var XMLdblBalanceQtytoIssue = xmlHttpMRNs.responseXML.getElementsByTagName("dblBalanceQtytoIssue");

			
		var strMrnData="<table width=\"1050\" height=\"24\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblPVData\">"+
			"<tr>"+
			"<td width=\"60\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" height=\"24\">Req. No </td>"+
			"<td width=\"80\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No </td>"+
			"<td width=\"60\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
			"<td width=\"130\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Detail </td>"+
			"<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colour</td>"+
			"<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Size</td>"+
			"<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Req. Quantity</td>"+
			"<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Issued Qty</td>"+
			"<td width=\"73\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance to Issue </td>"+
			"</tr>"

			
			
			
			for ( var loop = 0; loop < XMLintMatRequisitionNo.length; loop++)
			{
				var intMatRequisitionNo = XMLintMatRequisitionNo[loop].childNodes[0].nodeValue;
				var strStyleNo = XMLstrStyleNo[loop].childNodes[0].nodeValue;
				var dtmDate = XMLdtmDate[loop].childNodes[0].nodeValue;
				var strItemDescription = XMLstrItemDescription[loop].childNodes[0].nodeValue;
				var strColor = XMLstrColor[loop].childNodes[0].nodeValue;
				var strSize = XMLstrSize[loop].childNodes[0].nodeValue;
				var dblQty = XMLdblQty[loop].childNodes[0].nodeValue;
				var issueQty = XMLissueQty[loop].childNodes[0].nodeValue;
				var dblBalanceQtytoIssue = XMLdblBalanceQtytoIssue[loop].childNodes[0].nodeValue;
				
				strMrnData+="<tr>"+
				"<td  class=\"normalfnt\"  height=\"20\"   onmouseover=\"highlight(this.parentNode)\">" + intMatRequisitionNo + "</td>"+
				"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + strStyleNo + "</td>"+
				"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + dtmDate + "</td>"+
				"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + strItemDescription + "</td>"+
				"<td class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + strColor + "</td>"+
				"<td class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + strSize + "</td>"+
				"<td class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + dblQty + "</td>"+
				"<td class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + issueQty + "</td>"+
				"<td class=\"normalfntMid\" onmouseover=\"highlight(this.parentNode)\">" + dblBalanceQtytoIssue + "</td>"+
				"</tr>"
				
			}
			strMrnData+="</table>"
			
			document.getElementById("divMRNData").innerHTML=strMrnData
			
		}
	}

}

function printMRNsReport()
{
	StyleNo=document.getElementById("cboStyle").value
	var MainMatID=document.getElementById("cboMainMats").value
	var SubCatID=document.getElementById("cboCategories").value
	var MatDetailID=document.getElementById("cboItems").value
	var BuyerPO=document.getElementById("cboBuyerPO").value
	
	
	window.open('rptMRNReport.php?StyleNo=' + StyleNo + '&MainMatID=' + MainMatID + '&SubCatID=' + SubCatID + '&MatDetailID=' + MatDetailID + '&BuyerPO=' + BuyerPO   )	
}

function clearSelectControl(cboid)
{
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var aa=0;
	   for (aa=select.options.length-1;aa>=0;aa--)
	   {
			select.remove(aa);
	   }
   }
}

function highlight(o)
{
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