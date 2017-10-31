
var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	if(document.getElementById('cboOrderNo').value.trim()=='Select One'){
		alert("Please select Order Number.");
	}
	document.frmcomplete.submit();
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

function GetScNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}
function GetStyleNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function startCompletionProcess()
{
	var pos = 0;
	var tbl = document.getElementById('tblCompleteOrders');
	var tblLen = tbl.rows.length;
	var StyleId=document.getElementById('cboOrderNo').value.trim();
	//alert(tblLen);
	/*for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if (tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			styles[pos] = tbl.rows[loop].cells[0].childNodes[0].id;
			pos ++;
		}
	}
	if(pos == 0)
	{
		alert('Please select style to complete');
		}
		else
		{*/
			process(StyleId);
	//}
	
}

function process(StyleId)
{
	//if (index > styles.length -1){
		//alert("Process completed.");
		//window.location = window.location;
		//return;
	//}
	var styleID = URLEncode(StyleId);
	createXMLHttpRequest();
	xmlHttp.index=StyleId;
    xmlHttp.onreadystatechange = HandleProcess;
    xmlHttp.open("GET", 'ordercompletiondb.php?RequestType=competeOrders&styleID=' + StyleId, true);
    xmlHttp.send(null);  
}

function HandleProcess()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			if (xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue == "True")
			{
				/*message += styles[index] +", ";
				index ++;
				process();*/
				document.getElementById('butConfirm').style.display = 'none';
				sendEmail(xmlHttp.index);
				
			}
		}
	}
}
function sendEmail(styleId)
{
	//var styleId=document.getElementById('').value.trim();
	var url="ordercompletiondb.php?RequestType=sendEmails&styleId="+URLEncode(styleId);
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseXML.getElementsByTagName("Res")[0].childNodes[0].nodeValue){
		alert('Successfully confirmed.');
		//location.reload(true);
	}
}
function SelectAll(obj)
{
	var tbl  = document.getElementById('tblCompleteOrders');
	var check = true;
	if(obj.checked)	
		check = true;
	else 
		check = false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked=check;
	}
}

function getStylewiseOrderNo()
{
	var stytleName = document.getElementById('cboStyles').value;
	var url="ordercompletiondb.php";
					url=url+"?RequestType=getStyleWiseOrderNum";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;	
}

function getStylewiseSCNo()
{
	var stytleName = document.getElementById('cboStyles').value;
	var url="ordercompletiondb.php";
					url=url+"?RequestType=getStyleWiseSCNum";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  OrderNo;	
}
function selectStyles(obj){
	var styleId= obj.value.trim();

	var url='ordercompletiondb.php?RequestType=getStyles&buyerId=' +styleId ;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboStyles").innerHTML = "";
	document.getElementById('cboStyles').innerHTML =  htmlobj.responseXML.getElementsByTagName("StyleName")[0].childNodes[0].nodeValue;
	 getStylewiseOrderNo()	
	 getStylewiseSCNo()
}

