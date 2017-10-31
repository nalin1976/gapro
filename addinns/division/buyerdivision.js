var xmlHttp =[];

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function ShowBuyerDivisions()
{

	var buyer = document.getElementById("cboBuyer").value;		
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'buyerdivisionmiddle.php?request=getDivision&buyer=' + buyer ,true);
	xmlHttp[0].send(null);	
}


function stateChanged()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
		{
		document.getElementById("cboDivision").length = 0;
		
		
			var XMLDivisionCode= xmlHttp[0].responseXML.getElementsByTagName("DivisionId");
			var XMLDivision = xmlHttp[0].responseXML.getElementsByTagName("Division");
			for(var loop = 0 ; loop < XMLDivisionCode.length ; loop ++)
			{
				//document.getElementById("cboCity").value=XMLCityCode[loop].childNodes[0].nodeValue;
				//document.getElementById("cboCity").text=XMLCityName[loop].childNodes[0].nodeValue;
				var opt = document.createElement("option");
				opt.text =XMLDivision[loop].childNodes[0].nodeValue;
				opt.value =XMLDivisionCode[loop].childNodes[0].nodeValue;
				document.getElementById("cboDivision").options.add(opt);	
			
			}
		
	
	}
	
}
 
function saveDivision()
{
	 if((document.getElementById("cboBuyer").value!="")&&(document.getElementById("txtDevision").value!="")){
	 var buyer = document.getElementById("cboBuyer").value;	
	 var division= document.getElementById("txtDevision").value;	
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=savedindb;
	xmlHttp[1].open("GET",'buyerdivisionmiddle.php?request=editdb&buyer=' + buyer+'&division='+division ,true);
	xmlHttp[1].send(null);	
	
	 }else { if(document.getElementById("cboBuyer").value=="" )alert("Please select a buyer.");
	 			else if(document.getElementById("txtDevision").value=="") alert("Please enter a division.") ; }
}


function savedindb()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		alert("pass");
		
	}
	
}
