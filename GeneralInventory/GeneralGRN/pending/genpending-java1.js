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

function loadGrn()
{
	createXMLHttp();
	var tblPendingGrn 	= document.getElementById("tblPendingGrn");
		tblPendingGrn.innerHTML= "";
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
	var company = document.getElementById("cbocompany").options[document.getElementById('cbocompany').selectedIndex].value;
	
	
	url = "genpending-xml.php?id=loadGrn";
	url+= "&grnFromNo="+document.getElementById("txtGrnFromNo").value;
	url+= "&grnToNo="+document.getElementById("txtGrnToNo").value;
	url+= "&grnFromDate="+grnFromDate;
	url+= "&grnToDate="+grnToDate;
	url+= "&intStatus="+intStatus;
	url+= "&invNo="+document.getElementById("txtinvlike").value;
	url+= "&PoNo="+PoNo;
	url+= "&company="+company;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function grnRequest()
{
 if((xmlHttp.readyState == 4) && (xmlHttp.status == 200) )
	{
		
		var XMLGrnNo 		= xmlHttp.responseXML.getElementsByTagName("GrnNo");
		var XMLPoNo 		= xmlHttp.responseXML.getElementsByTagName("PoNo");
		var XMLSupplierName = xmlHttp.responseXML.getElementsByTagName("SupplierName");
		var XMLGrnYear 		= xmlHttp.responseXML.getElementsByTagName("GrnYear");
		var XMLGrnDate 		= xmlHttp.responseXML.getElementsByTagName("GrnDate");
		
		var tblPendingGrn 	= document.getElementById("tblPendingGrn");
		tblPendingGrn.innerHTML=  "<td width=\"16%\" height=\"33\" class=\"mainHeading4\">GRN No</td>"+
								  "<td width=\"19%\" class=\"mainHeading4\">PO No</td>"+
								  "<td width=\"21%\" class=\"mainHeading4\">Supplier</td>"+
								  "<td width=\"28%\" class=\"mainHeading4\">Date</td>"+
								  "<td width=\"16%\" class=\"mainHeading4\">View</td>";
				//alert(XMLGrnNo.length);				  
		for(var loop=0;loop<XMLGrnNo.length;loop++)
		{
			var intStatus = document.getElementById("cboMode").options[document.getElementById('cboMode').selectedIndex].value;	
			//if(intStatus==''){intStatus=0}; 
			intStatus = 0;
			var strUrl = "";
			var strReportUrl="";
			//if (intStatus == 0)	
			strUrl  = "../Details/gengrndetails.php?id=1&GRNNo="+XMLGrnNo[loop].childNodes[0].nodeValue+"&intYear="+XMLGrnYear[loop].childNodes[0].nodeValue +"&intStatus=0"+intStatus;
			strReportUrl  = "../Details/gengrnReport.php?grnno="+XMLGrnYear[loop].childNodes[0].nodeValue+"/"+XMLGrnNo[loop].childNodes[0].nodeValue;
			
			var strGrnNo = XMLGrnYear[loop].childNodes[0].nodeValue + "/" + XMLGrnNo[loop].childNodes[0].nodeValue ;
			tblPendingGrn.innerHTML +="<tr onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background=''\" class=\"bcgcolor-tblrowWhite\">"+						  
							  "<td class=\"normalfntMid\"><a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\">"+strGrnNo+"</a></td>"+
							  "<td class=\"normalfntMid\">"+XMLPoNo[loop].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" >"+XMLSupplierName[loop].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" style=\"text-align:center\">"+XMLGrnDate[loop].childNodes[0].nodeValue+"</td>"+
							  "<td><a href="+strReportUrl+" class=\"non-html pdf\" target=\"_blank\"><div align=\"center\"><img border=\"0\" src=\"../../../images/view.png\" alt=\"view\" /></div></a></td>"+
							"</tr>";
			
		}
	}
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