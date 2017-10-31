// JavaScript Document
var xmlHttp =[];
var count=0;
function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function getMRNDetails()
{	
	var MRNNO=document.getElementById("cboMRNNo").value;
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=addToGrid;
	xmlHttp[0].open("GET",'mrndb.php?REQUEST=getData&MRNNO=' + MRNNO,true);
	xmlHttp[0].send(null);	
	document.getElementById("currentNo").childNodes[0].nodeValue=MRNno;

}


function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function addToGrid()
{
	
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200){ 
	var tblMain=document.getElementById("tblMRN");
	RemoveAllRows("tblMRN");
	
					var XMLStyleNo	= xmlHttp[0].responseXML.getElementsByTagName('StyleNo');
					var XMLStyleName	= xmlHttp[0].responseXML.getElementsByTagName('StyleName');
					//var XMLItemCode	= xmlHttp[0].responseXML.getElementsByTagName('ItemCode');
					var XMLBuyerPONO	= xmlHttp[0].responseXML.getElementsByTagName('BuyerPONO');
					var XMLBuyerPOName	= xmlHttp[0].responseXML.getElementsByTagName('BuyerPOName');
					var XMLItemDescription	= xmlHttp[0].responseXML.getElementsByTagName('ItemDescription');
					var XMLColor	= xmlHttp[0].responseXML.getElementsByTagName('Color');
					var XMLSize= xmlHttp[0].responseXML.getElementsByTagName('Size');
					var XMLMRNQty	= xmlHttp[0].responseXML.getElementsByTagName('MRNQty');
					var XMLBalQty	= xmlHttp[0].responseXML.getElementsByTagName('BalQty');
					var XMLIssueQty	= xmlHttp[0].responseXML.getElementsByTagName('IssueQty');
					var XMLMatDetailID	= xmlHttp[0].responseXML.getElementsByTagName('MatDetailID');
					var XMLGRNNo	= xmlHttp[0].responseXML.getElementsByTagName('GRNNo');
					var XMLGRNYear	= xmlHttp[0].responseXML.getElementsByTagName('GRNYear');
					var XMLGRNType	= xmlHttp[0].responseXML.getElementsByTagName('GRNType');
					
					
		    for(var loop=0; loop<XMLStyleNo.length; loop++){
			var lastRow 		= tblMain.rows.length;	
			var row 			= tblMain.insertRow(lastRow);
				if(loop % 2 ==0)
					row.className ="bcgcolor-popup";
				else
					row.className ="bcgcolor-tblrowWhite";			
				row.onclick	= rowclickColorChangeIou;
				//row.onclick	= rowclickColorChangeIou;
		
			//row.className = "bcgcolor-tblrowWhite";
			/*row.onmouseover="this.style.background ='#D6E7F5';";
			var mainArrayIndex=0;
			var rowcwll = row.insertCell(0); 
			rowcwll.className ="mouseover";	*/
			
			/*if (XMLIssueQty[loop].childNodes[0].nodeValue==" "||XMLIssueQty[loop].childNodes[0].nodeValue=='0'){
			rowcwll.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\"  id=\"" + mainArrayIndex + "\" onclick=\"RemoveItem(this);\"/></div>";
			XMLIssueQty[loop].childNodes[0].nodeValue=0;
			
			}
			else			
			rowcwll.innerHTML ="&nbsp;"*/
					
			var rowcwll = row.insertCell(0);
			rowcwll.className ="normalfnt";	
			rowcwll.id =XMLStyleNo[loop].childNodes[0].nodeValue;
			rowcwll.innerHTML =XMLStyleName[loop].childNodes[0].nodeValue;
			
					
			/*var rowcwll = row.insertCell(2);
			rowcwll.className ="normalfntMidSML";
			rowcwll.id=XMLMatDetailID[loop].childNodes[0].nodeValue;
			rowcwll.innerHTML =XMLItemCode[loop].childNodes[0].nodeValue;*/
			
			var rowcwll = row.insertCell(1);
			rowcwll.className ="normalfntMidSML";
			rowcwll.id =XMLBuyerPONO[loop].childNodes[0].nodeValue;
			rowcwll.innerHTML =XMLBuyerPOName[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(2);
			rowcwll.className ="normalfntMidSML";
			rowcwll.id		  =XMLMatDetailID[loop].childNodes[0].nodeValue;
			rowcwll.innerHTML =XMLItemDescription[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(3);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLColor[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(4);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLSize[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(5);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLMRNQty[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(6);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLIssueQty[loop].childNodes[0].nodeValue;
			
			var balance=parseFloat(XMLMRNQty[loop].childNodes[0].nodeValue)-parseFloat(XMLIssueQty[loop].childNodes[0].nodeValue);
			
			var rowcwll = row.insertCell(7);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =balance;
			//XMLBalQty[loop].childNodes[0].nodeValue;
			
			var adjust=0;
			if(balance==0)
			adjust="N/A";
			else
			adjust="<input name=\"txtAdjest\"id=\"txtAdjest\"class=\"txtbox\" style=\"text-align:right\"size=\"10\"onchange=\"validateAdjust(this);\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event); \"value=\"" + XMLMRNQty[loop].childNodes[0].nodeValue +"\"/>";
			var rowcwll = row.insertCell(8);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =adjust;
			
			var rowcwll = row.insertCell(9);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLGRNNo[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(10);
			rowcwll.className ="normalfntMidSML";
			rowcwll.innerHTML =XMLGRNYear[loop].childNodes[0].nodeValue;
			
			var rowcwll = row.insertCell(11);
			rowcwll.className ="normalfntMidSML";
			rowcwll.id =XMLGRNType[loop].childNodes[0].nodeValue;
			rowcwll.innerHTML=(XMLGRNType[loop].childNodes[0].nodeValue=="S"?"Style":XMLGRNType[loop].childNodes[0].nodeValue=="B"?"Bulk":XMLGRNType[loop].childNodes[0].nodeValue);
			
		}
					
			
	}
}

function validateAdjust(adj)
{
	
	var mrnqty=parseFloat(adj.parentNode.parentNode.childNodes[5].innerHTML);
	var issueqty=parseFloat(adj.parentNode.parentNode.childNodes[6].innerHTML);
	var adjust=adj.value;
	
	if(adjust>mrnqty || adjust<issueqty){
	alert("Sorry!value should between "+issueqty+" and "+mrnqty);
	adj.parentNode.parentNode.childNodes[8].childNodes[0].value=mrnqty;
	//adj.parentNode.parentNode.childNodes[10].childNodes[0].focus;
	}
	}
function RemoveItem(del)
{
	
	if(confirm("Are you sure wnat to delete this?")){
	var index=del.parentNode.parentNode.parentNode.rowIndex;
	document.getElementById("tblMRN").deleteRow(index);
	/*del.parentNode.parentNode.parentNode.innerHTML="";*/}
	
	/*var mrnno=document.getElementById("currentNo").childNodes[0].nodeValue;
	var style=del.parentNode.parentNode.parentNode.childNodes[1].innerHTML;
	var buyerpo=del.parentNode.parentNode.parentNode.childNodes[3].innerHTML;	
	var matdetailtid=del.parentNode.parentNode.parentNode.childNodes[1].id;	
	var color=del.parentNode.parentNode.parentNode.childNodes[5].innerHTML;	
	var size=del.parentNode.parentNode.parentNode.childNodes[6].innerHTML;
	var mrnqty=del.parentNode.parentNode.parentNode.childNodes[10].childNodes[0].value;
	var balqty=parseFloat(del.parentNode.parentNode.parentNode.childNodes[10].childNodes[0].value)-parseFloat(del.parentNode.parentNode.parentNode.childNodes[8].innerHTML);
	
	
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
		if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200)
		alert(xmlHttp[1].responseText);		
	}
	xmlHttp[1].open("GET",'mrndb.php?REQUEST=editMrn&MRNNO=' + mrnno+'&style='+URLEncode(style)+'&buyerpo='+URLEncode(buyerpo)+'&matdetailtid='+matdetailtid+'&color='+URLEncode(color)+'&size='+URLEncode(size)+'&balqty='+balqty+'&mrnqty='+mrnqty,true);
	xmlHttp[1].send(null);	*/
	
}

function saveGrid()
{
	var mrnno=document.getElementById("currentNo").childNodes[0].nodeValue;
	var tableMRN=document.getElementById("tblMRN");	
	
	for(var loop=1;loop<tableMRN.rows.length;loop++)
	{
		var style=tableMRN.rows[loop].cells[0].id;
		var buyerpo=tableMRN.rows[loop].cells[1].id;	
		var matdetailtid=tableMRN.rows[loop].cells[2].id;	
		var color=tableMRN.rows[loop].childNodes[3].innerHTML;	
		var size=tableMRN.rows[loop].childNodes[4].innerHTML;
		var issue=tableMRN.rows[loop].childNodes[6].innerHTML;
		var mrnqty=tableMRN.rows[loop].childNodes[5].innerHTML;
		if(parseFloat(issue)!=parseFloat(mrnqty))
		 mrnqty=tableMRN.rows[loop].childNodes[8].childNodes[0].value;
		var grnno   = tableMRN.rows[loop].childNodes[9].innerHTML;
		var grnYear = tableMRN.rows[loop].childNodes[10].innerHTML;
		var grnType	= tableMRN.rows[loop].childNodes[11].id;
		
		var balqty=parseFloat(mrnqty)-parseFloat(issue);
		
		var url = 'mrndb.php?REQUEST=editMrn&mrnno=' + mrnno+'&style='+URLEncode(style)+'&buyerpo='+URLEncode(buyerpo)+'&matdetailtid='+matdetailtid+'&color='+URLEncode(color)+'&size='+URLEncode(size)+'&balqty='+balqty+'&mrnqty='+mrnqty+'&grnno='+grnno+'&grnYear='+grnYear+'&grnType='+URLEncode(grnType);
		htmlobj=$.ajax({url:url,async:false});	
	
	}	
}


function preparetosave()
{
	var MRNno=document.getElementById("currentNo").childNodes[0].nodeValue;
	var url = 'mrndb.php?REQUEST=deleteFirst&MRNno=' + MRNno;
	htmlobj=$.ajax({url:url,async:false});	
	alert(htmlobj.responseText);
	saveGrid();
}
function newWindow()
{
setTimeout("location.reload(true);",100);	
}

function rowclickColorChangeIou()
{	
	var rowIndex = this.rowIndex;
	
	
	var tbl = document.getElementById('tblMRN');
	
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-popup";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}