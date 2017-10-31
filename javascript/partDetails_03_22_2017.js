var xmlHttp;
var xmlHttp2 = [];
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
function RoundNumbers(number,decimals) {
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	return newString; // Output the result to the form field (change for your purposes)
}	
//Start-close popup window
function closeWindow()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}
//End-close popup window

//start - configuring HTTP2 request
function createXMLHttpRequest2(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP2 request

function SavePartDetails()
{
	tblMain=document.getElementById("tblPartDetails");	
	var TotSMV=0;
	var TotUM	=0;
	for(loop=1;loop<tblMain.rows.length;loop++)
	{
		var EFF      = tblMain.rows[loop].cells[4].childNodes[0].value;
		if(EFF=="" ||parseInt(EFF)==0){
			alert("Sorry!\nSome Percentage of Efficiency not calculated.Please click on empty text to Recal.");
			return;
			}	
		var StyleId	 = document.getElementById("txtStyleNo").value;		
		var SMVRate	 = document.getElementById("txtSMVRate").value;	
		var PartNo   = tblMain.rows[loop].cells[1].childNodes[0].nodeValue;
		var PartName = tblMain.rows[loop].cells[2].childNodes[0].value;
		var SMV      = parseFloat(tblMain.rows[loop].cells[3].childNodes[0].value);
	
		
		TotSMV +=SMV;
		var UM=(SMV*100)/parseInt(EFF);
		TotUM+=UM;
		
		
		createXMLHttpRequest2(loop);
		xmlHttp2[loop].open("GET",'partDetailsXml.php?RequestType=SavePartDetails&PartNo=' +URLEncode(PartNo)+ '&PartName=' +URLEncode(PartName)+ '&SMV=' +SMV+ '&EFF=' +EFF+ '&StyleId=' +URLEncode(StyleId)+ '&SMVRate=' +SMVRate ,true);
		xmlHttp2[loop].send(null);		
	}
	var EffSum=(TotSMV/TotUM)*100;
	document.getElementById("txtSMV").value = TotSMV;
	document.getElementById("txtEffLevel").value=RoundNumbers(EffSum,0);
	CalculateCMRate();
	CalculateESC();
	changeEffLevel();
	//document.getElementById("txtEffLevel").value=EffSum;
	//CalculateEffSum(TotSMV);
	closeWindow();
}

function ShowPartDetailsWindow()
{
	var StyleId	 = document.getElementById("txtStyleNo").value;	
	
	//createXMLHttpRequest();
	//xmlHttp.onreadystatechange=ShowPartDetailsWindowRequest;
	var url ='partDetails.php?StyleId=' +URLEncode(StyleId);
	var xmlHttp=$.ajax({url:url,async:false});
	drawPopupArea(422,244,'frmpartDetails');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmpartDetails').innerHTML=HTMLText;
	//xmlHttp.send(null);
}

	/*function ShowPartDetailsWindowRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupArea(422,244,'frmpartDetails');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmpartDetails').innerHTML=HTMLText;				
			}
		}
	}*/

function CalculateEff(obj)
{
	var rw		= obj.parentNode.parentNode;
	var SMV  = rw.cells[3].childNodes[0].value;
	var Qty 	= document.getElementById("txtQTY").value;
	rw.cells[4].childNodes[0].value ="";
	
	createXMLHttpRequest();
	xmlHttp.index= rw;
	xmlHttp.onreadystatechange=CalculateEffRequest;
	xmlHttp.open("GET",'partDetailsXml.php?RequestType=CalculateEff&SMV=' +SMV+ '&Qty=' +Qty ,true);
	xmlHttp.send(null);	
}

	function CalculateEffRequest()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{				
				var rw = xmlHttp.index
				var XMLEff = xmlHttp.responseXML.getElementsByTagName("CalculateEff")[0].childNodes[0].nodeValue;				
				rw.cells[4].childNodes[0].value=XMLEff;
			}
		}
	}
	
function RemoveRowItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td = obj.parentNode;
		//var tro = td.parentNode;
		var tt=td.parentNode;		
		tt.parentNode.removeChild(tt);				
		DeletePartRow(obj);
	}
}

function DeletePartRow(obj)
{
	var StyleId	= document.getElementById("txtStyleNo").value;
	var rw		=obj.parentNode.parentNode;
	var PartNo  = rw.cells[1].childNodes[0].nodeValue;
	
	createXMLHttpRequest();
	xmlHttp.open("GET",'partDetailsXml.php?RequestType=DeleteRow&StyleId=' +URLEncode(StyleId)+ '&PartNo=' +URLEncode(PartNo) ,true);
	xmlHttp.send(null);
}

function AddPartRow()
{	
	var  tblPart = document.getElementById('tblPartDetails');
	var NO=0;
		for(loop=1;loop<tblPart.rows.length;loop++)
		{
			 NO=parseInt(tblPart.rows[loop].cells[1].childNodes[0].nodeValue);
		}
	var lastRow = tblPart.rows.length;	
	var row = tblPart.insertRow(lastRow);
	
	var cellPartDetails = row.insertCell(0);
	cellPartDetails.className = "normalfntMid";	
	cellPartDetails.innerHTML ="<img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveRowItem(this);\"/>";
	
	var cellPartDetails = row.insertCell(1);
	cellPartDetails.className = "normalfntMid";	
	cellPartDetails.innerHTML = NO+1;
	
	var cellPartDetails = row.insertCell(2);
	cellPartDetails.className = "normalfnt";	
	cellPartDetails.innerHTML = "<input type=\"text\" name=\"txtpart\" id=\"txtpart\" class=\"txtbox\" size=\"20\" style=\"text-align:left\" value=\"\" />";
	
	var cellPartDetails = row.insertCell(3);
	cellPartDetails.className = "normalfntMid";	
	cellPartDetails.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" name=\"txtSmv2\" id=\"txtSmv2\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\"0\"  onblur=\"CalculateEff(this);\" />";
	
	var cellPartDetails = row.insertCell(4);
	cellPartDetails.className = "normalfntMid";	
	cellPartDetails.innerHTML ="<input type=\"text\" name=\"txtEFF\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" id=\"txtEFF\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" value=\""+""+"\" readonly=\"readonly\"/>";
}


function CalculateEffSum(totsmv)
{
	var Qty 	= document.getElementById("txtQTY").value;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=CalculateEffRequestSum;
	xmlHttp.open("GET",'partDetailsXml.php?RequestType=CalculateEff&SMV=' +totsmv+ '&Qty=' +Qty ,true);
	xmlHttp.send(null);	
}

	function CalculateEffRequestSum()
	{
		if(xmlHttp.readyState==4)
		{
			if(xmlHttp.status==200)
			{				
				var XMLEff = xmlHttp.responseXML.getElementsByTagName("CalculateEff")[0].childNodes[0].nodeValue;				
				document.getElementById("txtEffLevel").value=XMLEff;
			}
		}
	}
