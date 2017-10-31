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

//Start-ClearForm
function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}
//End-ClearForm

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

function DateValidate(objChk) 
{
		if(!objChk.checked)
		{
			document.getElementById("DateFrom").disabled= true;
			//document.getElementById("GPDateFrom").value="";
			document.getElementById("DateTo").disabled= true;
			//document.getElementById("GPDateTo").value="";
		}
		else
		{
			document.getElementById("DateFrom").disabled=false;
			document.getElementById("DateTo").disabled= false;
		}
}
var category ;
function LoadSavedDetails()
{
	var chkDate = document.getElementById("chkDate").checked;
	 category =document.getElementById("cbocategory").value;
	var DateFrom = document.getElementById("DateFrom").value;
	var DateTO = document.getElementById("DateTo").value;
	var TransferInNoFrom = document.getElementById("TrasnferNoFrom").value;
	var TransferInNoTo = document.getElementById("TrasnferNoTo").value;
	RemoveAllRows("tblTranferInDetails");
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadSavedDetailsRequest;
	xmlHttp.open("GET",'TransferInDetailsXml.php?RequestType=LoadSavedDetails&chkDate=' +chkDate+ '&category=' +category+ '&DateFrom=' +DateFrom+ '&DateTO=' +DateTO+ '&TransferInNoFrom=' +TransferInNoFrom+ '&TransferInNoTo=' +TransferInNoTo ,true);
	xmlHttp.send(null);
}
function LoadSavedDetailsRequest()
{
	if (xmlHttp.readyState==4)
	{
		if (xmlHttp.status==200)
		{
			if (category==1)
			{
				var XMLTranferInNo = xmlHttp.responseXML.getElementsByTagName("TranferInNo");
				var XMLYear = xmlHttp.responseXML.getElementsByTagName("Year");
				var XMLDate = xmlHttp.responseXML.getElementsByTagName("Date");
				var XMLGatePassno = xmlHttp.responseXML.getElementsByTagName("GatePassno");
				var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");
				
	var strText="<tr class=\"mainHeading4\">"+
				 "<td width=\"1%\" height=\"25\" ></td>"+
				 "<td width=\"7%\" >Transfer In No</td>"+
				 "<td width=\"7%\" >Date</td>"+
				 "<td width=\"8%\" >Gate Pass No</td>"+
				 "<td width=\"8%\" >View</td>"+				
				"</tr>";
		  	var loop1 = 0;
				for(var loop=0;loop<XMLTranferInNo.length;loop++)
				{
					var strReportUrl ="TransferInReport.php?id=1&TransferInNo="+XMLTranferInNo[loop].childNodes[0].nodeValue+"&TransferInYear="+XMLYear[loop].childNodes[0].nodeValue+"&Status="+XMLStatus[loop].childNodes[0].nodeValue;
					var TransferInNo=XMLYear[loop].childNodes[0].nodeValue+"/"+XMLTranferInNo[loop].childNodes[0].nodeValue;	
			
				loop1++;
			strText +="<tr class=\"bcgcolor-tblrowWhite\" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
					 "<td class=\"normalfntMid\">"+loop1+"</td>"+
					 "<td class=\"normalfntMid\">"+TransferInNo+"</td>"+
					 "<td class=\"normalfntMid\">"+XMLDate[loop].childNodes[0].nodeValue+"</td>"+
					 "<td class=\"normalfntMid\">"+XMLGatePassno[loop].childNodes[0].nodeValue+"</td>"+
					 "<td class=\"normalfntMid\"><a href=\""+strReportUrl+"\" class=\"non-html pdf\" target=\"_blank\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></a></td>"+
					"</tr>";
				}
				document.getElementById("tblTranferInDetails").innerHTML=strText;
			}
			else
			{
				var XMLTranferInNo = xmlHttp.responseXML.getElementsByTagName("TranferInNo");
				var XMLYear = xmlHttp.responseXML.getElementsByTagName("Year");
				var XMLDate = xmlHttp.responseXML.getElementsByTagName("Date");
				var XMLGatePassno = xmlHttp.responseXML.getElementsByTagName("GatePassno");
				var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");	
						
	var strText="<tr class=\"mainHeading4\">"+
				 "<td width=\"1%\" height=\"25\"></td>"+
				 "<td width=\"7%\" >Transfer In No</td>"+
				 "<td width=\"7%\" >Date</td>"+
				 "<td width=\"8%\" >Gate Pass No</td>"+
				 "<td width=\"8%\" >View</td>"+				 
				"</tr>";
			  var loop1 = 0;
				for(var loop=0;loop<XMLTranferInNo.length;loop++)
				{
					var strReportUrl ="TransferInReport.php?id=1&TransferInNo="+XMLTranferInNo[loop].childNodes[0].nodeValue+"&TransferInYear="+XMLYear[loop].childNodes[0].nodeValue+"&Status="+XMLStatus[loop].childNodes[0].nodeValue;
					
					var TransferInNo=XMLYear[loop].childNodes[0].nodeValue+"/"+XMLTranferInNo[loop].childNodes[0].nodeValue;
			loop1++;
		strText +="<tr  class=\"bcgcolor-tblrowWhite\" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
				 "<td class=\"normalfntMid\">"+loop1+"</td>"+
				 "<td class=\"normalfntMid\">"+TransferInNo+"</td>"+
				 "<td class=\"normalfntMid\">"+XMLDate[loop].childNodes[0].nodeValue+"</td>"+
				 "<td class=\"normalfntMid\">"+XMLGatePassno[loop].childNodes[0].nodeValue+"</td>"+
				 "<td class=\"normalfntMid\"><a href=\""+strReportUrl+"\" class=\"non-html pdf\" target=\"_blank\"><img border=\"0\" src=\"../../images/view.png\" alt=\"view\" /></a></td>"+				 
				"</tr>";
				}
				document.getElementById("tblTranferInDetails").innerHTML=strText;
			}
		}
	}
}

function Cancel(obj)
{
	if(confirm('Are you sure you want to Cancel this TransferIn No?'))
	{
		var TransNO =obj.parentNode.id;
		createXMLHttpRequest();
		xmlHttp.index=TransNO;
		xmlHttp.onreadystatechange=CancelRequest;
		xmlHttp.open("GET",'TransferInDetailsXml.php?RequestType=Cancel&TransNO=' +TransNO ,true);
		xmlHttp.send(null);
	}
}
	function CancelRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLTransNO =xmlHttp.index;
				alert ("TransferIn NO : "+ XMLTransNO + " Canceled.");
				RemoveAllRows("tblTranferInDetails");
				if(confirm('Do you want to view Tranfering No :'+ XMLTransNO +' Report?'))
				{
					var ExpodeNo =XMLTransNO.split("/");
					window.location = 'TransferInReport.php?TransferInNo='+ExpodeNo[1]+'&TransferInYear='+ExpodeNo[0];			 
				}
			}
		}
	}