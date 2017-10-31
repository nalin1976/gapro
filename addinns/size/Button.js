var xmlHttp;
var altxmlHttp;
var firxmlHttp;

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



function createaltxmlHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}


function createfirxmlHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        firxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        firxmlHttp = new XMLHttpRequest();
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
	

//Show BuyerDivision
function ShowBuyerDivisions()
{  
    MoveAllItemsLeft(); 
	RemoveCurrentDivisions();
	var custID = document.getElementById('sizes_cboBuyer').value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleDivisions;
    xmlHttp.open("GET", 'sizemiddle.php?RequestType=GetDivision&CustID=' + custID, true);
    xmlHttp.send(null);     
}

function HandleDivisions()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var opt = document.createElement("option");
			opt.text = "";
			opt.value = "";
			document.getElementById("sizes_cboDivision").options.add(opt);
			document.getElementById("sizes_cboDivision").value = "";
			 var XMLDivisionID = xmlHttp.responseXML.getElementsByTagName("DivisionID");
			 var XMLDivisionName = xmlHttp.responseXML.getElementsByTagName("Division");
			 
			 for ( var loop = 0; loop < XMLDivisionID.length; loop ++)
			 {  
				var opt = document.createElement("option");
				opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
				opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
				
				document.getElementById("sizes_cboDivision").options.add(opt);
				
			 }
			
		}
	}
}

function RemoveCurrentDivisions()
{
	var index = document.getElementById("sizes_cboDivision").options.length;
	while(document.getElementById("sizes_cboDivision").options.length > 0) 
	{
		index --;
		document.getElementById("sizes_cboDivision").options[index] = null;
	}
}

//Show BuyerColors
function ShowBuyerDivisionColors()
{    
    MoveAllItemsLeft();
    RemoveCurrentColors();
	var custID = document.getElementById('sizes_cboBuyer').value;
	var divisionID = document.getElementById("sizes_cboDivision").value;
	createaltxmlHttpRequest();
    altxmlHttp.onreadystatechange = HandleDivisionColors;
    altxmlHttp.open("GET", 'sizemiddle.php?RequestType=GetBuyerDivisionColors&BuyerID=' + custID + '&DivisionID=' + divisionID, true);
    altxmlHttp.send(null);  
}

function HandleDivisionColors()
{
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
		
		     RemoveAvailableColors();			
			 var XMLColor = altxmlHttp.responseXML.getElementsByTagName("Color");
			 for ( var loop = 0; loop < XMLColor.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLColor[loop].childNodes[0].nodeValue;
				opt.value = XMLColor[loop].childNodes[0].nodeValue;
				document.getElementById("sizes_cboAvailable").options.add(opt);
			 }			
		}
	}
}
function RemoveCurrentColors()
{
	var index = document.getElementById("sizes_cboAvailable").options.length;
	while(document.getElementById("sizes_cboAvailable").options.length > 0) 
	{
		index --;
		document.getElementById("sizes_cboAvailable").options[index] = null;
	}
}

function MoveItemRight()
{

    if(document.getElementById("sizes_cboBuyer").value=="")
	{
		alert("Please Select Buyer Frist");
		return;
	}

    if(document.getElementById("sizes_cboDivision").value=="")
	{
		alert("Please Select Division Frist");
		return;
	}
    
	var colors = document.getElementById("sizes_cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("sizes_cboAvailable"),true))
	{
		var optColor = document.createElement("option");
		//change1
		optColor.value ="";
		//optColor.value = colors.options[colors.selectedIndex].value;
		//change1
		optColor.text = colors.options[colors.selectedIndex].value;
		//optColor.text = selectedColor;
		document.getElementById("sizes_cboAvailable").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}



function MoveAllItemsRight()
{
    if(document.getElementById("sizes_cboBuyer").value=="")
	{
		alert("Please Select Buyer Frist");
		return;
	}

    if(document.getElementById("sizes_cboDivision").value=="")
	{
	alert("Please Select Division Frist");
	return;
	}
	
	var colors = document.getElementById("sizes_cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("sizes_cboAvailable"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("sizes_cboAvailable").options.add(optColor);
		}
	}
	RemoveLeftColors();
	
}


function MoveAllItemsLeft()
{
	var colors = document.getElementById("sizes_cboAvailable");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("sizes_cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("sizes_cbocolors").options.add(optColor);
		}
	}
	RemoveAvailableColors();
}


function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text == itemName)
		{
			if (message)
				alert("The property \"" + itemName + "\" is already exists in the list.");
			return true;			
		}
	}
	return false;
}


function RemoveAvailableColors()
{
	var index = document.getElementById("sizes_cboAvailable").options.length;
	while(document.getElementById("sizes_cboAvailable").options.length > 0) 
	{
		index --;
		document.getElementById("sizes_cboAvailable").options[index] = null;
	}
}


function RemoveLeftColors()
{
	var index = document.getElementById("sizes_cbocolors").options.length;
	while(document.getElementById("sizes_cbocolors").options.length > 0) 
	{
		index --;
		document.getElementById("sizes_cbocolors").options[index] = null;
	}
}


function saveAndAssign()
{       

	if (document.getElementById("sizes_cboBuyer").value == "" || document.getElementById("sizes_cboBuyer").value == null)
	{
		alert("Please select the Buyer first.");
		return false;
	}
	
	if(document.getElementById("sizes_cboDivision").value == "" || document.getElementById("sizes_cboDivision").value == null)
	{
		alert("Please select the Division first.");
		return false;
	}
	
	if(document.getElementById("sizes_txtcolorname").value.trim() == "" || document.getElementById("sizes_txtcolorname").value.trim() == null)
	{
		alert("Please enter Size.");
		return false;
	}
	
	
        xmlHttp=GetXmlHttpObject();
		
        var url="Button.php";
		url=url+"?q=add";
		
	
	//Save New Color

		    
			url=url+"&Colorname="+document.getElementById("sizes_txtcolorname").value;
			url=url+"&Description="+document.getElementById("sizes_txtdescription").value;

					
			/*if(document.getElementById("chkassign").checked==true)
			{
				assign=1;
			}
			else
			{
				assign=0;
			}*/
			
			var BuyerID = document.getElementById("sizes_cboBuyer").value;
			var DivisionID = document.getElementById("sizes_cboDivision").value;
			url=url+"&BuyerID=" + BuyerID + "&DivisionID=" + DivisionID;
			//alert(url);
           
      
		
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
 		
	
}


function stateChanged() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	 		//alert("|" + xmlHttp.responseText + "|");			
			if (xmlHttp.responseText == "-1")
			{
				alert("The process failed. May be size already exsists.");	
			}
			else
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("sizes_txtcolorname").value;
				optColor.value = xmlHttp.responseText;
				document.getElementById("sizes_cbocolors").options.add(optColor);
				//if(document.getElementById("chkassign").checked==true)
				//{
					document.getElementById("sizes_cboAvailable").options.add(optColor);
				//}
				document.getElementById("sizes_txtcolorname").value = "";
				document.getElementById("sizes_txtdescription").value = "";
				//document.getElementById("chkassign").checked=false;
				alert("The Process Completed.");
			}

	 } 
	}
}


function DeleteItem(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode== 46)
	document.getElementById("sizes_cboAvailable").options[document.getElementById("sizes_cboAvailable").selectedIndex] = null;
}


function SaveandFinish()
{
    if (document.getElementById("sizes_cboBuyer").value == "" || document.getElementById("sizes_cboBuyer").value == null)
	{
		alert("Please select the Buyer first.");
		return false;
	}
	
	if(document.getElementById("sizes_cboDivision").value == "" || document.getElementById("sizes_cboDivision").value == null)
	{
		alert("Please select the Division first.");
		return false;
	}
	
	if(document.getElementById("sizes_cboAvailable").options.length<=0)
	{
		alert("Please Select Size.");
		return false;
	}
	    firxmlHttp=GetXmlHttpObject();
		
        var url="Button.php";
		url=url+"?q=save";
		
	
	//Save New Color

		    
			url=url+"&BuyerID="+document.getElementById("sizes_cboBuyer").value;
			url=url+"&DivisionID="+document.getElementById("sizes_cboDivision").value;

	                    var NewColor="";
						for (var i = 0 ; i < document.getElementById("sizes_cboAvailable").length ; i++)
						{
							var text = document.getElementById("sizes_cboAvailable").options[i].text;
							var value = document.getElementById("sizes_cboAvailable").options[i].value;
							/*if(value=="")
							{*/
							//alert(text);
								NewColor+=text + ",";
							//}
						}
						
						url+="&NewColor="+NewColor;
						
						
		firxmlHttp.onreadystatechange=stateChangedalt;
		firxmlHttp.open("GET",url,true);
		firxmlHttp.send(null);	

}


/*function stateChangedalt() 
{ 
	if(firxmlHttp.readyState == 4) 
    {
        if(firxmlHttp.status == 200) 
        {  
			alert(firxmlHttp.responseText);
	 	} 
	}
}*/

function stateChangedalt() 
{ 
if (firxmlHttp.readyState==4 || firxmlHttp.readyState=="complete")
 {
 	alert("Size Saved successfully");
	document.getElementById("sizes_cboBuyer").value = "";
	document.getElementById("sizes_cboDivision").value = "";
	document.getElementById("sizes_cboAvailable").options.length = "";
 
 //setTimeout("location.reload(true);",1000);
 } 
}

function loadReport()
{
	document.frmSize.radioReports[0].checked == false;
	document.frmSize.radioReports[1].checked == false;
	if(document.getElementById('reportsPopUp').style.visibility == "hidden")
	{
		document.getElementById('reportsPopUp').style.visibility = "visible";
	}
	else
	{
		document.getElementById('reportsPopUp').style.visibility = "hidden";
	}
}

function loadReportSize(){ 
 if(document.frmSize.radioReports[0].checked == true){
	    var cboBuyer = document.getElementById('sizes_cboBuyer').value;
	    var radioListORdetails = document.frmSize.radioReports[0].value;
		window.open("sizeReportList.php?cboBuyer=" + cboBuyer); 
		document.getElementById('reportsPopUp').style.visibility = "hidden";
 }else{
	  var cboBuyer = document.getElementById('sizes_cboBuyer').value;
	  var cboDiv = document.getElementById('sizes_cboDivision').value;
	  if(cboBuyer.trim() == "")
	  {
	  	alert("Please select a Buyer");
		document.frmSize.radioReports[1].checked == false;
		return false;
	  }
	  if(cboDiv.trim()=="")
	  {
		alert("Please select a Division");  
		document.frmSize.radioReports[1].checked == false;
		return false;
	  }
	  var radioListORdetails = document.frmSize.radioReports[1].value;
      window.open("sizeReportDetails.php?cboBuyer=" +cboBuyer+"&cboDiv="+cboDiv); 
	  document.getElementById('reportsPopUp').style.visibility = "hidden";
 }
}