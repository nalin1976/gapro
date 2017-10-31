// JavaScript Document
var xmlHttp;
var pub_winNo=0;
function createXMLHttp() 
{
	try
	 {
	  //Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
		  //Internet Explorer
		 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function loadGrn()
{
	createXMLHttp();
	
	var intStatus = document.getElementById("cboMode").options[document.getElementById('cboMode').selectedIndex].value;
	xmlHttp.onreadystatechange = grnRequest;
	
	var grnFromDate = "";
	var grnToDate	="";
	if(document.getElementById("fromDate").value!="")
	{
	    grnFromDate		= (document.getElementById("fromDate").value).split("/")[2]+"-"+(document.getElementById("fromDate").value).split("/")[1]+"-"+(document.getElementById("fromDate").value).split("/")[0];
	}
	
	if(document.getElementById("toDate").value!="")
	{
	var grnToDate		= (document.getElementById("toDate").value).split("/")[2]+"-"+(document.getElementById("toDate").value).split("/")[1]+"-"+(document.getElementById("toDate").value).split("/")[0];
	}
	
	var PoNo = document.getElementById("cbopono").options[document.getElementById('cbopono').selectedIndex].value;
	
/*	if(document.getElementById("txtGrnFromNo").value=='' && document.getElementById("txtGrnToNo").value=='' && grnFromDate=='' && grnToDate=='' && document.getElementById("txtinvlike").value=='' && document.getElementById("cboUser").value=='' && PoNo=='' )
	{
		if(intStatus==1)
		{
		alert("Pls select a at least one criteria.");	
		return;
		}
	}*/
	
	url = "pending-xml.php?id=loadGrn";
	url+= "&grnFromNo="+document.getElementById("txtGrnFromNo").value;
	url+= "&grnToNo="+document.getElementById("txtGrnToNo").value;
	url+= "&grnFromDate="+grnFromDate;
	url+= "&grnToDate="+grnToDate;
	url+= "&intStatus="+intStatus;
	url+= "&invNo="+URLEncode(document.getElementById("txtinvlike").value);
	url+= "&intCompanyId="+document.getElementById("cboFactory").value;
	url+= "&intUserId="+document.getElementById("cboUser").value;
	url+= "&PoNo="+PoNo;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

function grnRequest()
{
 if((xmlHttp.readyState == 4) && (xmlHttp.status == 200) )
	{
/*		var y = xmlHttp.responseText;
		var x = new XML();
		x = y;
		alert(x.PoNo);*/
		
		//alert(xmlHttp.responseText);
		//UserName
		var XMLGrnNo 		= xmlHttp.responseXML.getElementsByTagName("GrnNo");
		var XMLPoNo 		= xmlHttp.responseXML.getElementsByTagName("PoNo");
		var XMLPoYear 		= xmlHttp.responseXML.getElementsByTagName("PoYear");
		var XMLSupplierName = xmlHttp.responseXML.getElementsByTagName("SupplierName");
		var XMLGrnYear 		= xmlHttp.responseXML.getElementsByTagName("GrnYear");
		var XMLGrnDate 		= xmlHttp.responseXML.getElementsByTagName("GrnDate");
		var XMLUserName		= xmlHttp.responseXML.getElementsByTagName("UserName");
		var XMLInvNo		= xmlHttp.responseXML.getElementsByTagName("InvNo");
		var XMLgrnFactory	= xmlHttp.responseXML.getElementsByTagName("grnFactory");
		
		var tblPendingGrn 	= document.getElementById("tblPendingGrn");
		//tblPendingGrn.innerHTML=  "<td width=\"16%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN No</td>"+
		//						  "<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
		//						  "<td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Supplier</td>"+
		//						  "<td width=\"28%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
		//						  "<td width=\"16%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">View</td>";
		
		tblPendingGrn.innerHTML =  "<td width=\"10%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN No</td>"+
              "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
              "<td width=\"25%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Supplier</td>"+
			  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No</td>"+
              "<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
			  "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User</td>"+
			  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">View</td>"+
			  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Print</td>";
		
								  
		for(var loop=0;loop<XMLGrnNo.length;loop++)
		{
			
	var intStatus = document.getElementById("cboMode").value;	
	var strUrl  = "../Details/grndetails.php?id=1&GRNNo="+XMLGrnNo[loop].childNodes[0].nodeValue+"&intYear="+XMLGrnYear[loop].childNodes[0].nodeValue+"&intStatus="+intStatus+"&thisGrnFactory="+XMLgrnFactory[loop].childNodes[0].nodeValue;
	var strPo = XMLPoYear[loop].childNodes[0].nodeValue+"/"+XMLPoNo[loop].childNodes[0].nodeValue;
	
	var strGrnNo = XMLGrnYear[loop].childNodes[0].nodeValue + "/" + XMLGrnNo[loop].childNodes[0].nodeValue ;
	tblPendingGrn.innerHTML +="<tr>"+
							  //"<td class=\"normalfntMid\">"+strGrnNo+"</td>"+
							  
							  "<td class=\"normalfntMid\"><a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\">"+strGrnNo+"</a></td>"+
							  "<td class=\"normalfntMid\">"+strPo+"</td>"+
							  "<td class=\"normalfnt\" >"+XMLSupplierName[loop].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" >"+XMLInvNo[loop].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" style=\"text-align:center\">"+XMLGrnDate[loop].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" style=\"text-align:center\">"+XMLUserName[loop].childNodes[0].nodeValue+"</td>"+
							  "<td><a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\"><div align=\"center\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></div></a></td>"+
							  "<td><a target=\"_blank\"><img src=\"../../images/report.png\" id=\"butReport\"  class=\"mouseover\" width=\"90\" height=\"20\" onclick=\"grnReport(this);\"/></a></td>"+
							"</tr>";
		}
	}
}

function dateDisable(objChk)
{
		if(!objChk.checked)
		{
			document.getElementById("fromDate").disabled= true	;
			document.getElementById("fromDate").value=""		;
			document.getElementById("toDate").disabled= true	;
			document.getElementById("toDate").value=""			;
		}
		else
		{
			document.getElementById("fromDate").disabled=false	;
			document.getElementById("toDate").disabled= false	;
		}
}

function grnReport(objReport)
{
	var row = objReport.parentNode.parentNode.parentNode;
	var grn = row.cells[0].lastChild.childNodes[0].nodeValue;
	
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/Details/grnReport.php?grnno="+grn.split("/")[1]+'&grnYear='+grn.split("/")[0];
	//alert(path);
	//document.location.href = path;
	win2=window.open(path,'win'+pub_winNo++);
	//alert(document.location.search);
	
}