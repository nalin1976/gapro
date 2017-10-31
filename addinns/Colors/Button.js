function ClearCombo(id)
{
	var index = document.getElementById(id).options.length;
	while(document.getElementById(id).options.length > 0) 
	{
		index --;
		document.getElementById(id).options[index] = null;
	}
}

function ClearForm()
{
	document.frmColors.reset();
	ClearCombo('cboAvailable');
	var url = 'Colorsmiddle.php?RequestType=GetAllColors&BuyerID=' + 0 + '&DivisionID=' + 0;
    htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cbocolors').innerHTML = htmlobj.responseText;
}

function ShowBuyerDivisions()
{  
    //MoveAllItemsLeft(); 
	var custID = document.getElementById('cboBuyer').value;
    var url = 'Colorsmiddle.php?RequestType=GetDivision&CustID=' + custID;
    htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboDivision').innerHTML = htmlobj.responseText;
	document.getElementById('cboDivision').onchange();
}

function ShowBuyerDivisionColors()
{    
    MoveAllItemsLeft();
	ClearCombo('cboAvailable');
	var custID = document.getElementById('cboBuyer').value;
	var divisionID = document.getElementById("cboDivision").value;
    var url = 'Colorsmiddle.php?RequestType=GetBuyerDivisionColors&BuyerID=' + custID + '&DivisionID=' + divisionID;
    htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboAvailable').innerHTML = htmlobj.responseText;
	
	var url = 'Colorsmiddle.php?RequestType=GetAllColors&BuyerID=' + custID + '&DivisionID=' + divisionID;
    htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cbocolors').innerHTML = htmlobj.responseText;
}

function MoveItemRight()
{
   if(!Validate())
   		return;
    
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboAvailable"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = colors.options[colors.selectedIndex].text;
		optColor.value = colors.options[colors.selectedIndex].value;
		document.getElementById("cboAvailable").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveAllItemsRight()
{
    if(document.getElementById("cboBuyer").value=="")
	{
		alert("Please select 'Buyer'.");
		document.getElementById('cboBuyer').focus();
		return;
	}
    else if(document.getElementById("cboDivision").value=="")
	{
		alert("Please select 'Division'.");
		document.getElementById('cboDivision').focus();
		return;
	}
	
	var colors = document.getElementById("cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboAvailable"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("cboAvailable").options.add(optColor);
		}
	}
	ClearCombo('cbocolors');
}

function MoveAllItemsLeft()
{
	var colors = document.getElementById("cboAvailable");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("cbocolors").options.add(optColor);
		}
	}
	ClearCombo('cboAvailable');
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text == itemName)
		{
			if (message)
				alert("The property \"" + itemName + "\" is already exist in the list.");
			return true;			
		}
	}
	return false;
}

function saveAndAssign()
{
	if(!Validate('saveAndAssign'))
		return;
	var url  = "Button.php";
	 	url += "?q=add";
	 	url += "&Colorname="+ URLEncode(document.getElementById("txtcolorname").value);
	 	url += "&Description="+URLEncode(document.getElementById("txtdescription").value);	
	 	url += "&BuyerID="+ document.getElementById("cboBuyer").value;
		url += "&DivisionID="+ document.getElementById("cboDivision").value;
	htmlobj=$.ajax({url:url,async:false});
	stateChanged(htmlobj);
}

function stateChanged(htmlobj) 
{ 
	if (htmlobj.responseText == "-1")
	{
		alert("Color already exsit in selected criteria.");	
		return false;
	}
	else
	{				
		var optColor = document.createElement("option");
		optColor.text = document.getElementById("txtcolorname").value;
		optColor.value = document.getElementById("txtcolorname").value;		
		document.getElementById("cboAvailable").options.add(optColor);

		document.getElementById("txtcolorname").value = "";
		document.getElementById("txtdescription").value = "";
		alert("Added successfully.");
		//loadCombo('SELECT distinct strDescription, strColor FROM colors  order by strColor ASC','cbocolors');
		ClearForm();
	}
}

function DeleteItem(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode== 46)	
		document.getElementById("cboAvailable").options[document.getElementById("cboAvailable").selectedIndex] = null;
}

function SaveandFinish()
{
	if(!Validate('SaveandFinish'))
		return;

	var url="Button.php";
	url=url+"?q=save";
	url=url+"&BuyerID="+document.getElementById("cboBuyer").value;
	url=url+"&DivisionID="+document.getElementById("cboDivision").value;

	var NewColor="";
	var Description="";

	for (var i = 0 ; i < document.getElementById("cboAvailable").length ; i++)
	{
		var text = document.getElementById("cboAvailable").options[i].text;
		var value = document.getElementById("cboAvailable").options[i].value;
		var text1 = text.replace('#','@@@***');
		var value1 = value.replace('#','@@@***');
		NewColor+=text1 + ",";
		Description+=value1 + ",";
	}
						
	url+="&NewColor="+NewColor;
	url+="&Description="+Description;
	htmlobj=$.ajax({url:url,async:false});
	stateChangedalt(htmlobj);
}

function stateChangedalt() 
{ 
	alert("Saved successfully");
	ClearForm();
}

function loadReport()
{ 
	window.open("ColorReport.php?cbodepartment" ); 
}
   
function listORDetails()
{
	document.frmColors.radioListORdetails[0].checked = false;
	document.frmColors.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
		document.getElementById('divlistORDetails').style.visibility = "visible";
	else
		document.getElementById('divlistORDetails').style.visibility = "hidden";	 	
}

function loadReport()
{ 
	if(document.frmColors.radioListORdetails[0].checked == true)
	{
		var cboBuyer = document.getElementById('cboBuyer').value;
		var cboDivision = document.getElementById('cboDivision').value;
		var radioListORdetails = document.frmColors.radioListORdetails[0].value;
		window.open("ColorReportList.php"); 
		document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
	else
	{
		var cboBuyer = document.getElementById('cboBuyer').value;
		var cboDivision = document.getElementById('cboDivision').value;
		if(cboBuyer != "" && cboDivision!="")
		{
			var radioListORdetails = document.frmColors.radioListORdetails[1].value;
			window.open("ColorReportDetails.php?cboBuyer=" + cboBuyer+"&cboDivision="+cboDivision); 
			document.getElementById('divlistORDetails').style.visibility = "hidden";
		}
		else
		{
			alert("Please select both Buyer and Division"); 
			document.getElementById('divlistORDetails').style.visibility = "hidden";
		}
 	}
}

function Validate(obj)
{
	if(document.getElementById("cboBuyer").value == "")
	{
		alert("Please select 'Buyer'.");
		document.getElementById("cboBuyer").focus()
		return false;
	}
	
	if(obj=='SaveandFinish')
	{
		if(document.getElementById('cboAvailable').options.length<=0)
		{
			alert("No 'Available Colors' found to proceed.");
			return false;
		}
	}
	if(obj=='saveAndAssign')
	{	
		if(document.getElementById("txtcolorname").value.trim() == "")
		{
			alert("Please enter 'Color Name'.");
			document.getElementById("txtcolorname").focus();
			return false;		
		}
	}
return true;
}