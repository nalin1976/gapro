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

function loadMRNList()
{
	createXMLHttp();
	
	//var intStatus = document.getElementById("cboMode").value;
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
		
	url = "genMRNMiddle.php?RequestType=loadMRNList";
	url+= "&fromDate="+fromDate;
	url+= "&toDate="+toDate;
	url+= "&mrnNo="+document.getElementById("txtPoNo").value;
	url+= "&strCompanyID="+document.getElementById("cboStores").value;
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function bulkPoRequest()
{
 if((xmlHttp.readyState == 4) && (xmlHttp.status == 200) )
	{
		var XMLstrMrnNo 			= xmlHttp.responseXML.getElementsByTagName("strMrnNo");
		var XMLintYear				= xmlHttp.responseXML.getElementsByTagName("intYear");
		var XMLstrDepartment 			= xmlHttp.responseXML.getElementsByTagName("strDepartment");
		
		var tblPendingGrn 			=  document.getElementById("tblPoList");
		tblPendingGrn.innerHTML		=   "  <tr>"+
										"  <td width=\"13%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">MRN NO</td>"+
										"  <td width=\"40%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Department</td>"+
										"  <td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"></td>"+
										"  </tr>";
								  
		for(var loop=0;loop<XMLstrMrnNo.length;loop++)
		{
			//var intStatus = document.getElementById("cboMode").value;	
			var strUrl  = "genMaterialRequisition.php?RequestType=1&MrnNo="+XMLstrMrnNo[loop].childNodes[0].nodeValue+"&intYear="+XMLintYear[loop].childNodes[0].nodeValue;
			var strUrl2  = "genmrnrep.php?RequestType=1&mrnNo="+XMLstrMrnNo[loop].childNodes[0].nodeValue+"&year="+XMLintYear[loop].childNodes[0].nodeValue;
			
			
			var strMRNNo = XMLintYear[loop].childNodes[0].nodeValue + "/" + XMLstrMrnNo[loop].childNodes[0].nodeValue ;
			tblPendingGrn.innerHTML +="<tr>"+
									  //"<td class=\"normalfntMid\">"+strGrnNo+"</td>"+
									  "<td class=\"normalfntMid\"><a href="+strUrl2+" class=\"non-html pdf\" target=\"_blank\">"+strMRNNo+"</a></td>"+
									  "<td class=\"normalfntMid\">"+XMLstrDepartment[loop].childNodes[0].nodeValue+"</td>"+
									  "<td><a href="+strUrl2+" class=\"non-html pdf\" target=\"_blank\"><div align=\"center\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></div></a></td>"+
									"</tr>";
		}
	}
}

function ViewReport(mrnYear,mrnNo)
{
	var No = mrnNo;
	if(No==""){alert("No MRN No to view");return}
	var Year =mrnYear;
	
	newwindow=window.open('genmrnrep.php?mrnNo='+No+ '&year=' +Year ,'frmMrn');
	if (window.focus) {newwindow.focus()}
}
