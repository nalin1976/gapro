var xmlHttp;
//start - configuring HTTP request
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
//End - configuring HTTP request

//Start - Public remove data function
function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}
//End - Public remove data function

//Start - Clear table data
function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}
//End - Clear table data

function DateDisable(objChk)
{	
		if(!objChk.checked)
		{
			document.getElementById("GPDateFrom").disabled= true;
			//document.getElementById("GPDateFrom").value="";
			document.getElementById("GPDateTo").disabled= true;
			//document.getElementById("GPDateTo").value="";
		}
		else
		{
			document.getElementById("GPDateFrom").disabled=false;
			document.getElementById("GPDateTo").disabled= false;
		}
}

function LoadGatePassNo()
{
	var category = document.getElementById("cbocategory").value;
	var storesCategory	= (document.getElementById('optInternal').checked==true ? "I":"E");
	createXMLHttpRequest();
	RomoveData("GPNOFrom");
	RomoveData("GPNOTo");
	xmlHttp.onreadystatechange=LoadGatePassNoRequest;
	xmlHttp.open("GET",'gatePassDetailsXml.php?RequestType=LoadGatePassNo&category=' +category+ '&storesCategory=' +storesCategory ,true);
	xmlHttp.send(null);
}
	function LoadGatePassNoRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLgatePassNo =xmlHttp.responseXML.getElementsByTagName("gatePassNo");
				
						var opt = document.createElement("option");
						opt.text = "";						
						document.getElementById("GPNOFrom").options.add(opt);	
						
						var opt = document.createElement("option");
						opt.text = "";						
						document.getElementById("GPNOTo").options.add(opt);	
				
					for ( var loop = 0; loop < XMLgatePassNo.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLgatePassNo[loop].childNodes[0].nodeValue;						
						document.getElementById("GPNOFrom").options.add(opt);	
						
						var opt = document.createElement("option");
						opt.text = XMLgatePassNo[loop].childNodes[0].nodeValue;						
						document.getElementById("GPNOTo").options.add(opt);
			 		}
			}
		}
		//LoadDetails();
	}

function LoadDetails()
{
	//var company = document.getElementById("cboCompany_gp").value;
	var chkDate = document.getElementById("chkDate").checked;
	var category =document.getElementById("cbocategory").value;
	var GPDateFrom = document.getElementById("GPDateFrom").value;
	var GPDateTO = document.getElementById("GPDateTo").value;
	var gatePassNoFrom = document.getElementById("GPNOFrom").options[document.getElementById("GPNOFrom").selectedIndex].text;
	var gatePassNoTo = document.getElementById("GPNOTo").options[document.getElementById("GPNOTo").selectedIndex].text;
	var storesCategory	= (document.getElementById('optInternal').checked==true ? "I":"E");
	var destination = document.getElementById("cboDestination").value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadDetailsRequest;
	xmlHttp.open("GET",'gatePassDetailsXml.php?RequestType=LoadDetailsToTable&chkDate=' +chkDate+ '&category=' +category+ '&GPDateFrom=' +GPDateFrom+ '&GPDateTO=' +GPDateTO+ '&gatePassNoFrom=' +gatePassNoFrom+ '&gatePassNoTo=' +gatePassNoTo+ '&storesCategory=' +storesCategory+'&destination='+destination ,true);
	xmlHttp.send(null);
}
function LoadDetailsRequest()
{
	if (xmlHttp.readyState==4)
	{
		if (xmlHttp.status)
		{
			var XMLGatePassNo 		= xmlHttp.responseXML.getElementsByTagName("GatePassNo");
			var XMLGatePassYear 	= xmlHttp.responseXML.getElementsByTagName("gatePassYear");
			var XMLDate 			= xmlHttp.responseXML.getElementsByTagName("Date");
			var XMLDestinationName 	= xmlHttp.responseXML.getElementsByTagName("DestinationName");
			var XMLStatus 			= xmlHttp.responseXML.getElementsByTagName("Status");
			var XMLUserName 		= xmlHttp.responseXML.getElementsByTagName("UserName");
			var XMLReportName		= xmlHttp.responseXML.getElementsByTagName("ReportName");
						
			var strText = "<table width=\"931\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
				"<tr class=\"mainHeading4\">"+
				  "<td width=\"2%\" height=\"25\">No</td>"+
				  "<td width=\"12%\">GatePass No</td>"+
				  "<td width=\"18%\">Date</td>"+
				  "<td width=\"38%\" >Destination</td>"+
				    "<td width=\"19%\" >User</td>"+
				  "<td width=\"14%\" >View</td>"+
				  
				"</tr>";
				var loop1 = 0;
			for (var loop=0;loop<XMLGatePassNo.length;loop++)
			{
				var ReportName = XMLReportName[loop].childNodes[0].nodeValue;
				var strUrl ="../styleItemGatePass.php?id=1&GatePassNo="+XMLGatePassNo[loop].childNodes[0].nodeValue+"&GatePassYear="+XMLGatePassYear[loop].childNodes[0].nodeValue+"&Status="+XMLStatus[loop].childNodes[0].nodeValue;
                var GPNO = XMLGatePassYear[loop].childNodes[0].nodeValue + "/" + XMLGatePassNo[loop].childNodes[0].nodeValue;
				var strReportUrl ="../"+ReportName+"?cboGatePassNo="+GPNO;
                                
                                var gpNo = XMLGatePassNo[loop].childNodes[0].nodeValue;
                                var gpYr = XMLGatePassYear[loop].childNodes[0].nodeValue;

                
                loop1++;
				strText +="<tr onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background=''\" class=\"bcgcolor-tblrowWhite\">"+
			  "<td class=\"normalfntMid\">"+loop1+"</td>"+
              "<td class=\"normalfntMid\"><a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\">"+GPNO+"</a></td>"+
              "<td class=\"normalfntMid\">"+XMLDate[loop].childNodes[0].nodeValue+"</td>"+
              "<td class=\"normalfntMid\">"+XMLDestinationName[loop].childNodes[0].nodeValue+"</td>"+
			   "<td class=\"normalfntMid\">"+XMLUserName[loop].childNodes[0].nodeValue+"</td>"+
			  "<td class=\"normalfntMid\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\"onclick=\"print_gp(this,"+gpNo+","+gpYr+")\" id=\""+strReportUrl+"\"/></td>"+		 
            "</tr>";
			}
			strText += "</table>";
			
			document.getElementById("divGatePassDetails").innerHTML=strText;
		}
	}
}

function print_gp(obj,gpNo,gpYr)
{
	window.open(obj.id,'x');
        window.open("../pickListReport.php?cboGatePassNo="+gpYr+"/"+gpNo,'y');
        
        
}