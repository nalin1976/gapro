// JavaScript Document
var xmlHttp;
var requestCnt 				= 0;
var responseCnt 			= 0;
var multixmlHttp 			= [];
var xmlHttp1 				= [];
var pub_exRatePath 			= document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url					= pub_exRatePath+"/addinns/exchangeRate/";
var saveTimes				= 1;
var pub_intxmlHttp_count 	= 0;

function createNewMultiXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        multixmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        multixmlHttp[index] = new XMLHttpRequest();
    }
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

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

function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}

function SaveExchangeRate()
{
	if(document.getElementById('txtValidFrom').value == "")
	{	
		if(document.getElementById('txtValidFrom').value == "")
		{
			alert("Please select \"Date \".");
			document.getElementById('txtValidFrom').focus();
		}
	return false;
	}
	
	var tbl =  document.getElementById("tblExchngRate");
	var Count = tbl.rows.length;
	var fromDate 	= document.getElementById('txtValidFrom').value;
	var booCheckValidate = true;
	
	 requestCnt = 0;
	 responseCnt = 0;
	for(var loop=1; loop<Count; loop++)
	{
		var chkBox =tbl.rows[loop].cells[0].childNodes[0].checked;		
		if(chkBox == true)
		{
			var rate = tbl.rows[loop].cells[2].childNodes[0].value
			if(rate == 0)
			{
				alert("\"Rate\" must be greater than \"0\" .");
				tbl.rows[loop].cells[2].childNodes[0].select();
				return false;
			}
		}
	}
	
	var numOfChecked = false;
	for(var loop=1; loop<Count; loop++)
	{
		var chkBox =tbl.rows[loop].cells[0].childNodes[0].checked;
		
		if(chkBox == true)
		{
			numOfChecked = true;	
		}
	}	
	
	if(!numOfChecked)
	{
		alert("Please select a \"Currency \".");
		return false;
	}
	
	var error=0;
	
	for(var loop=1; loop<Count; loop++)
	{
		var chkBox =tbl.rows[loop].cells[0].childNodes[0].checked;
		
		if(chkBox == true)
		{
			booCheckValidate = false;
			var currID = tbl.rows[loop].cells[1].id;
			var strCurrency = tbl.rows[loop].cells[1].innerHTML;
			var rate = tbl.rows[loop].cells[2].childNodes[0].value;
			var baserowid = tbl.rows[loop].id;
			if((baserowid!=1) && dateValidate(currID,strCurrency,tbl,loop)==false )
			{
				tbl.rows[loop].cells[0].childNodes[0].checked= false;
				error=error+1;
				return false;
			}
		}
	}
	
	if(booCheckValidate)
		alert("No currency found to Save.\nAtlease you have to select one \"Currency\".");

	if(error==0)
	{
		for(var loop=1; loop<Count; loop++)
		{
			var chkBox =tbl.rows[loop].cells[0].childNodes[0].checked;
			
			if(chkBox == true)
			{
				booCheckValidate = false;
				var currID = tbl.rows[loop].cells[1].id;
				var strCurrency = tbl.rows[loop].cells[1].innerHTML;
				var rate = tbl.rows[loop].cells[2].childNodes[0].value;
				
				createXMLHttpRequest1(requestCnt);
				xmlHttp1[requestCnt].onreadystatechange=ResponseExRateDetails;
				xmlHttp1[requestCnt].index = requestCnt;
				xmlHttp1[requestCnt].open("GET",'exRateXml.php?RequestType=SaveExRate&currID='+ URLEncode(currID)+'&Dfrom='+fromDate+'&rate='+rate, true);
				xmlHttp1[requestCnt].send(null);
				requestCnt++;
			}
		}
	}
}

function ResponseExRateDetails()
{
	if(xmlHttp1[this.index].readyState == 4) //this.index
    {
        if(xmlHttp1[this.index].status == 200) 
        {
			responseCnt++;				
			if(requestCnt == responseCnt)
			{
				var tbl = document.getElementById('tblExchngRate');
				var Count = tbl.rows.length;
				var tbldetail = document.getElementById('tblExDetails');				
				var validFrom = document.getElementById('txtValidFrom').value;					
				
				LoadCurrencyToGrid();
				if(xmlHttp1[this.index].responseText==2){
					alert("Saved successfully.");
				}
				else{
					alert("Saved successfully.");
				}
				document.frmExRange.reset();
				document.getElementById('txtValidFrom').focus();
			}
		}
	}
}	

function LoadCurrencyToGrid()
{
	var url="exRateXml.php?RequestType=LoadCurrencyToGrid";
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLCurrencyId 	= htmlobj.responseXML.getElementsByTagName("CurrencyId");
	var XMLTitle 		= htmlobj.responseXML.getElementsByTagName("Title");
	var XMLDateFrom 	= htmlobj.responseXML.getElementsByTagName("DateFrom");
	var XMLRate 		= htmlobj.responseXML.getElementsByTagName("Rate");
	var XMLDefaultCurrency 		= htmlobj.responseXML.getElementsByTagName("DefaultCurrency");
	var tbldetail 		= document.getElementById('tblExDetails');
	RemoveAllRows('tblExDetails');
	for(var loop=0; loop<XMLCurrencyId.length; loop++)
	{
		var currID 		= XMLCurrencyId[loop].childNodes[0].nodeValue;
		var currName 	= XMLTitle[loop].childNodes[0].nodeValue;
		var rate 		= XMLRate[loop].childNodes[0].nodeValue;
		var validFrom 	= XMLDateFrom[loop].childNodes[0].nodeValue;
		if(XMLDefaultCurrency[loop].childNodes[0].nodeValue)
			var del = "";
		else
			var del = "<img src=\"../../images/del.png\" id=\""+currID+"\" onClick=\"deleteRecord(this);\">";
			
		var newRow = "<tr class=\"bcgcolor-tblrowWhite\" align=\"center\"><td id=\""+currID+"\">"+del+"</td>"+
		"<td class=\"normalfnt\">"+currName+"</td>"+
		"<td class=\"normalfnt\" style=\"text-align:right\">"+rate+"</td>"+
		"<td class=\"normalfntMid\">"+validFrom+"</td>"+					
		"</tr>";
		tbldetail.innerHTML = tbldetail.innerHTML + newRow;
	}
}

function validateDate(Dfrom,Dto)
{
    var fromDate 	= new Date(document.getElementById('txtValidFrom').value);
	var check = false;	
	if(Dfrom<= fromDate)
		check = true;
		
	if(check == true)
	{
		alert("Exchange Rate available for selected date ");
		return false;
	}			
return true;
}

function dateValidate(id,strCurrency,tbl1,loop)
{
	var fromDate 	= document.getElementById('txtValidFrom').value;
	
	if((fromDate==''))
		alert("Date is not selected !");
	
	var tbl = document.getElementById('tblExDetails');
	var rows = tbl.rows.length;
	var check = false;
	for(var i=1;i<rows;i++)
	{
		var gfromDate 	= 	tbl.rows[i].cells[3].innerHTML;
		var currID      = tbl.rows[i].cells[0].id;
		if((gfromDate==fromDate)  && ( currID==id))
			check =true;		
	}
	if(check)
	{
		alert("Selected Date  for the \""+strCurrency+" \" is already in the list. ");
		tbl1.rows[loop].cells[2].childNodes[0].value=0;
		tbl1.rows[1].focus();
		return false;
	}
return true;
}

function viewGroupDetails()
{
	if(ValidateDates())
	{	
	    var dateFrom = document.getElementById('txtValidFrom').value;
		window.open("viewExRate.php?",'frmExRange'); 
	}
}

function deleteRecord(obj)
{
	var currID = obj.id;
	var curr = obj.parentNode.parentNode.cells[1].childNodes[0].nodeValue;
	var exRate = obj.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	var dfrom = obj.parentNode.parentNode.cells[3].childNodes[0].nodeValue;
	var r=confirm("Are you sure you want to delete  \""+ curr+"\"?");
	if (r==true)
	{
		createXMLHttpRequest();
		
		xmlHttp.onreadystatechange = HandleExDelete;
		xmlHttp.index = obj.parentNode.parentNode.rowIndex;
		xmlHttp.open("GET", pub_url+'exRateXml.php?RequestType=deleteExRate&currID='+currID+'&exRate='+ exRate+'&dfrom='+dfrom , true);
		xmlHttp.send(null);
	}
}

function HandleExDelete()
{
	if (xmlHttp.readyState==4)
	{
		if (xmlHttp.status==200)	
		{ 
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");	
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				RemoveRow(xmlHttp.index);
			}
		}
	}
}

function RemoveRow(rowIndex)
{
	var tbl = document.getElementById('tblExDetails');
    tbl.deleteRow(rowIndex);
}

function ValidateDates()
{
	return true;
}

function ClearExchangeRateForm()
{
	document.frmExRange.reset();
	document.getElementById('txtValidFrom').focus();
	showCalendar('txtValidFrom', '%Y-%m-%d');
}