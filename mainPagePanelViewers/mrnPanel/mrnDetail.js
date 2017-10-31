//var xmlHttp;
//......malinga
var pnl_mrnUrl = "mainPagePanelViewers/mrnPanel/";


function setPanelMRN(){
	//LoadMrnNo();
	loadMrnDetailsToGrid();
	}
function createXMLHttpRequest(){
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
	}
}

function LoadMrnNo()
{    
//	var mainStore = document.getElementById('btn').value;
	
   	var url = pnl_mrnUrl+'mrnDetailXML.php?RequestType=LoadMrnNo&mainStore='+1;
    var htmlobj=$.ajax({url:url,async:false});
	LoadMrnNoRequest(htmlobj);
}
function LoadMrnNoRequest(xmlHttp)
{			
	document.getElementById("cboMrnno").innerHTML = xmlHttp.responseText;
}
function loadMrnDetailsToGrid()
{	
/*
	if(document.getElementById('cboMrnno').value=="")
	{
		alert("Please select the 'MRN No'.");
		document.getElementById('cbomrnno').focus();
		return;
	}*/
	
	ClearTable("MRNtbl");
	
	//var StyleId =document.getElementById('cboorderno').value;
	//var BuyerPoNo =document.getElementById('cbobuyerpono').value;
	
	//var strMrnNo =document.getElementById('cboMrnno').options[document.getElementById('cboMrnno').selectedIndex].text;

	//var strobj = strMrnNo.split("/");

	//var mrnYear = (strobj[0]);
	//var mrnNo =(strobj[1]);

	createXMLHttpRequest();

	var url =  pnl_mrnUrl+'mrnDetailXML.php?RequestType=loadMrnDetailsToGrid&mainStoreId='+"1";
	var htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
	//alert(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{

	
	var XMLMRNno	   = htmlobj.responseXML.getElementsByTagName("MRNno");
	var XMLDate 		= htmlobj.responseXML.getElementsByTagName("Date");
	var XMLDepartment  = htmlobj.responseXML.getElementsByTagName("Department");
	var XMLIssueUser   = htmlobj.responseXML.getElementsByTagName("IssueUser");
	var XMLCompany 	 = htmlobj.responseXML.getElementsByTagName("Company");
	var XMLCompanyID   = htmlobj.responseXML.getElementsByTagName("CompanyID");
	var XMLYear 		= htmlobj.responseXML.getElementsByTagName("Year");
	var XMLNo 		  = htmlobj.responseXML.getElementsByTagName("No");
	
	
	var tbl 		= document.getElementById('MRNtbl');
	
	for(loop=0;loop<XMLMRNno.length;loop++)
	{
		
		//alert(XMLMRNno[loop].childNodes[0].nodeValue);
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "gridbodyTxtPnl";
		
		
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		
	
		
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		cell.setAttribute('height','30');
		cell.setAttribute('width','15%');
		var No=XMLNo[loop].childNodes[0].nodeValue;
		var Year=XMLYear[loop].childNodes[0].nodeValue;
		var store=XMLCompanyID[loop].childNodes[0].nodeValue;
		//var url =  pnl_mrnUrl+'mrnDetailXML.php?RequestType=loadMrnDetailsToGrid&mainStoreId='+"1";
		//fabricrollinspectionpopup.php?StyleID=' +URLEncode(styleID)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ 
		var mrnUrl="MaterialRequisition.php?id=1&mrnNo="+No+"&year="+Year+"&intStatus="+10+"&mainStore="+store+"";
		cell.innerHTML ="<a href=\""+mrnUrl+"\" class=\"non-html pdf\" target=\"_blank\">"+XMLMRNno[loop].childNodes[0].nodeValue+"</a>"
		
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.removeAttribute("width");
		cell.setAttribute('width','20%');
		cell.innerHTML = XMLDate[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.setAttribute('width','20%')
		cell.innerHTML = XMLDepartment[loop].childNodes[0].nodeValue;
		
				
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.innerHTML = XMLIssueUser[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.id = XMLCompanyID[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLCompany[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		var id=XMLMRNno[loop].childNodes[0].nodeValue
		cell.innerHTML = "<img src=\"images/view.png\" id=\""+id+"\" alt=\"add\" onclick=\"IssueNote1(this);\"/>"
		

	}
	
}

/*
function IssueNote1(obj)
{
	
	var myWindow = window.open('issue/issues.php',"_self"); 	
var id=obj.id	
document.getElementById('txtgrno').value=id;	
alert(document.getElementById('txtgrno').value);
alert("swh");
var url='issue/issues.php?id='+id;
//createXMLHttpRequest();	
//xmlhttp=new XMLHttpRequest();
//xmlhttp.open("GET","issue/issues.php?id='+id",true);
//xmlhttp.send();
//xmlDoc=xmlhttp.responseXML;

	



alert(url);
var htmlobj=$.ajax({url:url,async:false});


	//var id=obj.id;
	
}*/

function IssueNote1(obj)
{
	var id=obj.id	
	var myWindow = window.open('issue/issues.php?id='+id);	

}


/*function IssueNote()
{
	var id=document.getElementById('txtid').value;


var no 	 = id.split("/")[1];
var year = id.split("/")[0];



	var url = '../mainPagePanelViewers/mrnPanel/mrnDetailXML.php??RequestType=LoadMRNDetail&no=' +no+ '&year=' +year;
	//mainPagePanelViewers/mrnPanel/
	//alert(url);
	var htmlobj=$.ajax({url:url,async:false});
	
	
		
	
	
		var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription");
	var XMLMatDetailID 		= htmlobj.responseXML.getElementsByTagName("MatDetailID");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color");
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLBalQty 			= htmlobj.responseXML.getElementsByTagName("BalQty");
	var XMLMatMainID 		= htmlobj.responseXML.getElementsByTagName("MatMainID");
	var XMLStockQty 		= htmlobj.responseXML.getElementsByTagName("StockQty");
	var XMLStyleNo 			= htmlobj.responseXML.getElementsByTagName("StyleNo");
	var XMLBuyerPONO 		= htmlobj.responseXML.getElementsByTagName("BuyerPONO");
	var XMLStyleName 		= htmlobj.responseXML.getElementsByTagName("StyleName");
	var XMLBuyerPOName 		= htmlobj.responseXML.getElementsByTagName("BuyerPOName");
	var XMLSCNO 			= htmlobj.responseXML.getElementsByTagName("SCNO");
	var XMLGRNno 			= htmlobj.responseXML.getElementsByTagName("GRNno");
	var XMLGRNyear 			= htmlobj.responseXML.getElementsByTagName("GRNyear");	
	var XMLGRNType 			= htmlobj.responseXML.getElementsByTagName("grnType");	
	var XMLstrGRNType 		= htmlobj.responseXML.getElementsByTagName("strGRNType");
	
	
	//alert( document.getElementById('tblIssueList').length);
	var tbl 		= document.getElementById('tblIssueList');
	for(loop=0;loop<XMLMatDetailID.length;loop++)
	{
		//alert(XMLMatDetailID[loop].childNodes[0].nodeValue);
		alert(tbl.rows.length);
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "gridbodyTxtPnl";
		
		
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		
	
		
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		cell.setAttribute('height','30');
		cell.setAttribute('width','15%');
		var No=XMLNo[loop].childNodes[0].nodeValue;
		var Year=XMLYear[loop].childNodes[0].nodeValue;
		var store=XMLCompanyID[loop].childNodes[0].nodeValue;
		//var url =  pnl_mrnUrl+'mrnDetailXML.php?RequestType=loadMrnDetailsToGrid&mainStoreId='+"1";
		//fabricrollinspectionpopup.php?StyleID=' +URLEncode(styleID)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ 
		var mrnUrl="MaterialRequisition.php?id=1&mrnNo="+No+"&year="+Year+"&intStatus="+10+"&mainStore="+store+"";
		cell.innerHTML ="<a href=\""+mrnUrl+"\" class=\"non-html pdf\" target=\"_blank\">"+XMLMRNno[loop].childNodes[0].nodeValue+"</a>"
		
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.removeAttribute("width");
		cell.setAttribute('width','20%');
		cell.innerHTML = XMLDate[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.setAttribute('width','20%')
		cell.innerHTML = XMLDepartment[loop].childNodes[0].nodeValue;
		
				
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.innerHTML = XMLIssueUser[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.id = XMLCompanyID[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLCompany[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		var id=XMLMRNno[loop].childNodes[0].nodeValue
		cell.innerHTML = "<img src=\"images/view.png\" id=\""+id+"\" alt=\"add\" onclick=\"IssueNote(this);\"/>"
		
		
	}
}
*/
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function loadMrnDetails()
	{	
		
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  		
				
			 	var XMLItemDescription 	= xmlHttp.responseXML.getElementsByTagName("ItemDescription");
				var XMLMatDetailID 		= xmlHttp.responseXML.getElementsByTagName("MatDetailID");
				var XMLColor 			= xmlHttp.responseXML.getElementsByTagName("Color");
				var XMLSize 			= xmlHttp.responseXML.getElementsByTagName("Size");
				var XMLUnit 			= xmlHttp.responseXML.getElementsByTagName("Unit");
				var XMLBalQty 			= xmlHttp.responseXML.getElementsByTagName("BalQty");
				var XMLMatMainID 		= xmlHttp.responseXML.getElementsByTagName("MatMainID");
				var XMLStockQty 		= xmlHttp.responseXML.getElementsByTagName("StockQty");
				var XMLStyleNo 			= xmlHttp.responseXML.getElementsByTagName("StyleNo");
				var XMLBuyerPONO 		= xmlHttp.responseXML.getElementsByTagName("BuyerPONO");
				var XMLStyleName 		= xmlHttp.responseXML.getElementsByTagName("StyleName");
				var XMLBuyerPOName 		= xmlHttp.responseXML.getElementsByTagName("BuyerPOName");
				var XMLSCNO 			= xmlHttp.responseXML.getElementsByTagName("SCNO");
				var XMLGRNno 			= xmlHttp.responseXML.getElementsByTagName("GRNno");
				var XMLGRNyear 			= xmlHttp.responseXML.getElementsByTagName("GRNyear");
				
				
				/*var strText = "<table id=\"IssueItem\" width=\"1000\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
							  "<tr class=\"mainHeading4\">"+
							  "<td width=\"2%\" height=\"25\" ><input type=\"checkbox\" name=\"chksel\" id=\"chksel\" onclick=\"SelectAll(this);\"/></td>"+
								  "<td width=\"23%\" >Details</td>"+
								  "<td width=\"10%\" >Color</td>"+
								  "<td width=\"7%\" >Size</td>"+
								  "<td width=\"4%\" >Unit</td>"+
								  "<td width=\"7%\" >Req Qty</td>"+
								  "<td width=\"7%\" >GRN Balance</td>"+
								  "<td width=\"2%\" ></td>"+
								  "<td width=\"10%\" >Order No</td>"+
								  "<td width=\"8%\" >Buyer PoNo</td>"+
								  "<td width=\"4%\" >GRN No</td>"+
								  "<td width=\"3%\" >GRN Year</td>"+
							  "</tr>";*/
						
				for (var loop =0; loop < XMLItemDescription.length; loop ++)
				{
					/*var bpoName = XMLBuyerPOName[loop].childNodes[0].nodeValue;
					var bpoID   = XMLBuyerPONO[loop].childNodes[0].nodeValue;
						strText += 	  "<tr class=\"bcgcolor-tblrowWhite\">"+
									  "<td><div align=\"center\">"+
									  "<input type=\"checkbox\" name=\"chksel\" id=\"chksel\" />"+
									  "</div></td>"+
									      "<td class=\"normalfnt\" id=\"" +  XMLMatDetailID[loop].childNodes[0].nodeValue + "\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\" id =\""+ XMLMatMainID[loop].childNodes[0].nodeValue +"\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\" id=\""+XMLSCNO[loop].childNodes[0].nodeValue+"\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\">"+XMLBalQty[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\">"+XMLStockQty[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\"><div align=\"center\"><img src=\"../images/house.png\" onClick=\"setStockTransaction(this)\" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
										  "<td class=\"normalfnt\" id =\""+ XMLStyleNo[loop].childNodes[0].nodeValue +"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\" id=\""+bpoID+"\">"+bpoName+"</td>"+
										  "<td class=\"normalfntRite\">"+ XMLGRNno[loop].childNodes[0].nodeValue+"</td>"+
										   "<td class=\"normalfntRite\">"+ XMLGRNyear[loop].childNodes[0].nodeValue+"</td>"+
									  "</tr>";*/
				}

							 // strText += "</table>";
				document.getElementById("divIssueItem").innerHTML=strText;
							  
			}
		}
	}
	
	function drawTable(tbody) {
    var tr, td, i, j, oneRecord;
    tbody = document.getElementById(tbody);
    // node tree
    var data = xDoc.getElementsByTagName("season")[0];
    // for td class attributes
    var classes = ["ctr","","","","ctr"];
    for (i = 0; i < data.childNodes.length; i++) {
        // use only 1st level element nodes
        if (data.childNodes[i].nodeType == 1) {
            // one bowl record
            oneRecord = data.childNodes[i];
            tr = tbody.insertRow(tbody.rows.length);
            td = tr.insertCell(tr.cells.length);
            td.setAttribute("class",classes[tr.cells.length-1]);
            td.innerHTML = oneRecord.getElementsByTagName("number")[0].firstChild.nodeValue;
            td = tr.insertCell(tr.cells.length);
            td.setAttribute("class",classes[tr.cells.length-1]);
            td.innerHTML = oneRecord.getElementsByTagName("year")[0].firstChild.nodeValue;
            td = tr.insertCell(tr.cells.length);
            td.setAttribute("class",classes[tr.cells.length-1]);
            td.innerHTML = oneRecord.getElementsByTagName("winner")[0].firstChild.nodeValue;
            td = tr.insertCell(tr.cells.length);
            td.setAttribute("class",classes[tr.cells.length-1]);
            td.innerHTML = oneRecord.getElementsByTagName("loser")[0].firstChild.nodeValue;
            td = tr.insertCell(tr.cells.length);
            td.setAttribute("class",classes[tr.cells.length-1]);
            td.innerHTML = oneRecord.getElementsByTagName("winscore")[0].firstChild.nodeValue + " - " + oneRecord.getElementsByTagName("losscore")[0].firstChild.nodeValue;
        }
    }
}


function completeEvent()
{
	if(document.getElementById('checkboxgrid').checked==true)
		{
			var MRNstatus=1;
		}
	else
		{
			var MRNstatus=0;
		}
	
}










function getIssueNo()
{
	document.getElementById("Save").style.display ="none";
	
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboprolineno").value=="")	
	{
		alert ("Please select \"Production Line No\".");
		document.getElementById("cboprolineno").focus();
		document.getElementById("Save").style.display ="inline";
		return false;
	}
	
	if(tbl.rows.length<=1) {
		alert("No details to save.");
		document.getElementById("Save").style.display ="inline";
		document.getElementById("cmdAddNew").focus();

		return false;
	}
	
	for (loop = 1 ;loop < tbl.rows.length; loop++)
	{
		
		var issueQty = tbl.rows[loop].cells[6].childNodes[0].value;
		
		if(pub_commonBin==0){
		var checkBinAllocate = tbl.rows[loop].cells[2].id			
			if (checkBinAllocate==0)		
			{
				alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +".");
				document.getElementById("Save").style.display ="inline";
				return false;
				break;
			}
		}
		
			if ((issueQty=="")  || (issueQty==0))
			{
				alert ("Issue qty can't be '0' or empty in Line No : " + [loop] +".");
				document.getElementById("Save").style.display ="inline";
				return false;
				break;
			}			
	}
	showBackGroundBalck();
	checkLoop = 0;
	createXMLHttpRequest();	
	/*xmlHttp.onreadystatechange = LoadIssueNoRequest;
	xmlHttp.open("GET" ,'issuexml.php?RequestType=LoadIssueno' ,true);
	xmlHttp.send(null);	*/
	var url = 'issuexml.php?RequestType=LoadIssueno';
	var htmlobj=$.ajax({url:url,async:false});
	LoadIssueNoRequest(htmlobj)
}
	function LoadIssueNoRequest(htmlobj)
	{	
    	  		
		  var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;			 	
			
		  if(XMLAdmin=="TRUE")
		  {
			  var XMLissueNo = htmlobj.responseXML.getElementsByTagName("issueNo");
			  var XMLissueYear = htmlobj.responseXML.getElementsByTagName("issueYear");
			  issueNo = parseInt(XMLissueNo[0].childNodes[0].nodeValue);				
			  issueYear = parseInt(XMLissueYear[0].childNodes[0].nodeValue);
			  document.getElementById("txtissueNo").value = issueYear +  "/"  + issueNo ;			
			  saveIssuedetails();
		  }
		  else
		  {
			  alert("Please contact system administrator to assign new Issue No.");
			  hideBackGroundBalck();
			 document.getElementById("Save").style.display ="inline";
		  }
			
	}