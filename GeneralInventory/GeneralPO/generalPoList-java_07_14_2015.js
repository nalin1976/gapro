// JavaScript Document
var xmlHttp;

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

function loadBulkPo()
{
	var tblPendingGrn 			=  document.getElementById("tblPoList");
	tblPendingGrn.innerHTML = "";	
	createXMLHttp();
	
	var intStatus = document.getElementById("cboMode").value;
	xmlHttp.onreadystatechange = bulkPoRequest;
	
	var fromDate = "";
	var toDate	="";
	if(document.getElementById("fromDate").value!="")
	{
	    fromDate		= (document.getElementById("fromDate").value).split("/")[2]+"-"+(document.getElementById("fromDate").value).split("/")[1]+"-"+(document.getElementById("fromDate").value).split("/")[0];
	}
	
	if(document.getElementById("toDate").value!="")
	{
	var toDate		= (document.getElementById("toDate").value).split("/")[2]+"-"+(document.getElementById("toDate").value).split("/")[1]+"-"+(document.getElementById("toDate").value).split("/")[0];
	}
	
	
	url = "generalPo-xml.php?id=loadBulkPo";
	url+= "&fromDate="+fromDate;
	url+= "&toDate="+toDate;
	url+= "&intStatus="+intStatus;
	url+= "&poNo="+document.getElementById("txtPoNo").value;
	url+= "&intSupplierID="+document.getElementById("cbopolist").value;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

function bulkPoRequest()
{
 if((xmlHttp.readyState == 4) && (xmlHttp.status == 200) )
	{
		var XMLintGenPONo 			= xmlHttp.responseXML.getElementsByTagName("intGenPONo");
		var XMLintYear				= xmlHttp.responseXML.getElementsByTagName("intYear");
		var XMLstrTitle 			= xmlHttp.responseXML.getElementsByTagName("strTitle");
		var XMLpermision 			= xmlHttp.responseXML.getElementsByTagName("permision");
		var XMLuserName 			= xmlHttp.responseXML.getElementsByTagName("userName");
		var XMLdate 				= xmlHttp.responseXML.getElementsByTagName("date");
		
		var tblPendingGrn 			=  document.getElementById("tblPoList");
		tblPendingGrn.innerHTML		=         "<tr bgcolor=\"#804000\">"+
											  "<td width=\"10%\" height=\"20\" class=\"normaltxtmidb2\">PO NO</td>"+
											  "<td width=\"46%\" class=\"normaltxtmidb2\">Supplier</td>"+
											   "<td width=\"10%\" class=\"normaltxtmidb2\">Date</td>"+
											    "<td width=\"15%\" class=\"normaltxtmidb2\">User</td>"+
											  "<td width=\"12%\" class=\"normaltxtmidb2\">Report</td>"+
											"</tr>";
								  
		for(var loop=0;loop<XMLintGenPONo.length;loop++)
		{
			var permision = XMLpermision[loop].childNodes[0].nodeValue;
			
			var intStatus = document.getElementById("cboMode").value;	
			var strUrl  = "generalPo.php?id=1&BulkPoNo="+XMLintGenPONo[loop].childNodes[0].nodeValue+"&intYear="+XMLintYear[loop].childNodes[0].nodeValue+"&intStatus="+intStatus;
			
			if(PP_allowChemicalPOReport==1)
				var reportUrl  = "reportpo.php?chemperid=1&bulkPoNo="+XMLintGenPONo[loop].childNodes[0].nodeValue+"&intYear="+XMLintYear[loop].childNodes[0].nodeValue+"&intStatus="+intStatus;
			else
				var reportUrl  = "oritgeneralpurcahseorderreport.php?bulkPoNo="+XMLintGenPONo[loop].childNodes[0].nodeValue+"&intYear="+XMLintYear[loop].childNodes[0].nodeValue+"&intStatus="+intStatus;
			
			var intGenPONo = XMLintYear[loop].childNodes[0].nodeValue + "/" + XMLintGenPONo[loop].childNodes[0].nodeValue ;
			
			var A = '';
			if(permision ==1)
			{
				butView = "<a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\"><div align=\"center\"><img class=\"mouseover\"  border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></div></a>";
				A = "<a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\">"+intGenPONo+"</a>";
			}
			else
				A = intGenPONo;
				
			tblPendingGrn.innerHTML +="<tr onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background=''\" class=\"bcgcolor-tblrowWhite\">"+
									  //"<td class=\"normalfntMid\">"+strGrnNo+"</td>"+
									  
									  "<td class=\"normalfnt\">"+A+"</td>"+
									  "<td class=\"normalfnt\">"+XMLstrTitle[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\">"+XMLdate[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\">"+XMLuserName[loop].childNodes[0].nodeValue+"</td>"+
									  //"<td>"+butView+"</td>"+
									"<td><a href="+reportUrl+" class=\"non-html pdf\" target=\"_blank\"><div align=\"center\"><img src=\"../../images/view2.png\" id=\"butReport\"  class=\"mouseover\"  border=\"0\" /></div></a></td>"+
									"</tr>";
		}
	}
}

