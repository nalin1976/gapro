var xmlHttp;
var altxmlHttp;
var count=0;
var xmlHttpreq = [];


function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
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

function createAltXMLHttpRequest() 
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

function stateChanged() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
	 	
			if (xmlHttp.responseText == "-1")
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("itemwizard_txtassign").value;
				optColor.value = xmlHttp.responseText;
				if(document.getElementById("itemwizard_cboAvailable").options.length==0)
									document.getElementById("itemwizard_cboAvailable").innerHTML="";
				document.getElementById("itemwizard_cboAvailable").options.add(optColor);
				
				for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cbocolors").options.length; loop1 ++)
				{
					if(document.getElementById("itemwizard_cbocolors").options[loop1].text==optColor.text)						
					{	
						document.getElementById("itemwizard_cbocolors").options[loop1] = null;								
					}
					
				}
				
			}
			else
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("itemwizard_txtassign").value;
				optColor.value = xmlHttp.responseText;
				document.getElementById("itemwizard_cbocolors").options.add(optColor);
				if(document.getElementById("itemwizard_chkassign").checked==true)
				{
					if(document.getElementById("itemwizard_cboAvailable").options.length==0)
									document.getElementById("itemwizard_cboAvailable").innerHTML="";
					document.getElementById("itemwizard_cboAvailable").options.add(optColor);
					alert("Property is successfully saved and assigned.");
				}else{
					alert("Property is successfully saved.");
				}
			}
			document.getElementById("itemwizard_txtassign").value = "";
			document.getElementById("itemwizard_chkassign").checked=true;
	 //document.getElementById("txtprint").innerHTML=xmlHttp.responseText;
	// setTimeout("location.reload(true);",1000);
	 } 
	}
}


function stateChangedalt() 
{ 
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			alert(altxmlHttp.responseText);
	 	} 
	}
}


//Save sub category
function SaveCategory()
{	
	
	if(document.getElementById('txtcatcode').value=="")
	{
		document.getElementById('txtcatcode').focus();
		alert("Please enter the Category Code.");
		return false;
	}
	else if(CheckitemAvailability(document.getElementById('txtcatcode').value,document.getElementById("itemwizard_cbocategories"),false))
	{
		document.getElementById('txtcatcode').focus();
		alert("The Category Name is already exist.");
	}
	
	else if(document.getElementById('txtcatname').value=="")
	{
		document.getElementById('txtcatname').focus();
	    alert("Please enter the Category Name.");
		return false;
	}
	else
  	{
		   
		xmlHttp=GetXmlHttpObject();

		if (xmlHttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		} 
  		
		
		var url="server.php";
		url=url+"?q=Save";
		
        //Save Sub Category
	
		    
			url=url+"&StrCatName="+URLEncode(document.getElementById("txtcatname").value);
			url=url+"&StrCatCode="+document.getElementById("txtcatcode").value;
			//url=url+"&strUserId="+document.getElementById("txtcategory3").value;
			//setTimeout("location.reload(true);",1000);
			
			if(document.getElementById("chkdisplay").checked==true)
			intDisplay=1;
			else
			intDisplay=0;
			
			url=url+"&intDisplay="+intDisplay;
			
			if(document.getElementById("chkinspection").checked==true)
			intInspection=1;
			else
			intInspection=0;
			
			url=url+"&intInspection="+intInspection;
			
			if(document.getElementById("chkadditionalQty").checked==true)
			intAdditional=1;
			else
			intAdditional=0;
			
			url=url+"&intAdditional="+intAdditional;
			//alert(url);
			//setTimeout("location.reload(true);",1000);		
			//alert(document.getElementById("cbobdivision").value);
	
		xmlHttp.onreadystatechange=handleCategoryStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
		//setTimeout("location.reload(true);",1000);	
		//document.getElementById("itemwizard_cbocategories").innerHTML=document.getElementById("txtcatname").value;
		
  }
} 

function deleteSubCat(ID)
{			   
	var urlDetails="wizardmiddle.php?str=subCategoryID&subCat="+ID;	
	htmlobj=$.ajax({url:urlDetails,async:false});
	
	var CatName=htmlobj.responseXML.getElementsByTagName("CatName")[0].childNodes[0].nodeValue;

	var responce=confirm("Are you sure you want to delete the sub category, \""+CatName+"\" ?");
	if (responce==true){
		
		var urlDetails="server.php?q=deleteSubCat&intSubCatNo="+ID;	
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		closeCategoryWindow();
		
		if(htmlobj.responseText=="Sub Category deleted successfully"){
			for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cbocategories").options.length; loop1 ++)
			{
				if(document.getElementById("itemwizard_cbocategories").options[loop1].value==ID)		
					document.getElementById("itemwizard_cbocategories").options[loop1] = null;	
				document.getElementById("itemwizard_cboAvailable").innerHTML="";
			}
		}
	}
	
	//urlDetails="server.php?q=LoadSubCategory";	
	//htmlobj=$.ajax({url:urlDetails,async:false});
	//document.getElementById("itemwizard_cbocategories").innerHTML+=htmlobj.responseText;
} 


function SaveCategoryM(ID)
{
	
	if(document.getElementById('txtcatcode').value=="")
	{
		document.getElementById('txtcatcode').focus();
		alert("Please enter the Category Code.");
		return false;
	}
	else if(CheckitemAvailability(document.getElementById('txtcatcode').value,document.getElementById("itemwizard_cbocategories"),false))
	{
		document.getElementById('txtcatcode').focus();
		alert("The Category Name is already exist.");
	}
	
	else if(document.getElementById('txtcatname').value=="")
	{
		document.getElementById('txtcatname').focus();
	    alert("Please enter the Category Name.");
		return false;
	}
	   else
  {
		   
		xmlHttp=GetXmlHttpObject();

		if (xmlHttp==null)
  		{
  			alert ("Browser does not support HTTP Request");
  			return;
  		} 
  		
		
		var url="server.php";
		url=url+"?q=SaveModify";
		var textcatname=URLEncode(document.getElementById("txtcatname").value);
		
        //Save Sub Category
		
		url=url+"&intSubCatNo="+ID;
		url=url+"&StrCatName="+textcatname;
		url=url+"&StrCatCode="+document.getElementById("txtcatcode").value;
		//url=url+"&strUserId="+document.getElementById("txtcategory3").value;
		//setTimeout("location.reload(true);",1000);
		//alert(url);
		if(document.getElementById("chkdisplay").checked==true)
		intDisplay=1;
		else
		intDisplay=0;
		
		url=url+"&intDisplay="+intDisplay;
		//alert(url);
		if(document.getElementById("chkinspection").checked==true)
		intInspection=1;
		else
		intInspection=0;
		
		url=url+"&intInspection="+intInspection;
		//alert(url);
		if(document.getElementById("chkadditionalQty").checked==true)
		intAdditional=1;
		else
		intAdditional=0;
		
		url=url+"&intAdditional="+intAdditional;
		//alert(url);
		//setTimeout("location.reload(true);",1000);		
		//alert(document.getElementById("cbobdivision").value);
		
		xmlHttp.onreadystatechange=handleCategoryStatusM;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		closeCategoryWindow();
		for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cbocategories").options.length; loop1 ++)
		{
			if(document.getElementById("itemwizard_cbocategories").options[loop1].value==ID)		
				document.getElementById("itemwizard_cbocategories").options[loop1].text = textcatname;		
		}
		//setTimeout("location.reload(true);",1000);	
		//document.getElementById("itemwizard_cbocategories").innerHTML=document.getElementById("txtcatname").value;
		
  }
} 

function handleCategoryStatusM() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  	
			
			alert(xmlHttp.responseText);			
			
		 //document.getElementById("txtprint").innerHTML=xmlHttp.responseText;
		 //setTimeout("location.reload(true);",1000);
	 	}
	}
}

function handleCategoryStatus() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  	
			
			if (xmlHttp.responseText == "-1")
			{
				document.getElementById('txtcatname').focus();
				alert("Sub Category Name, \""+document.getElementById('txtcatname').value+"\" is already exist.");	
			}
			else if (xmlHttp.responseText == "-2")
			{
				document.getElementById('txtcatcode').focus();
				alert("Sub Category Code, \""+document.getElementById('txtcatcode').value+"\" is already exist.");	
			}
			else
			{
				//var opt = document.createElement("option");
				//opt.text =document.getElementById("txtcatname").value;
				//opt.value = document.getElementById("txtcatcode").value;
				//document.getElementById("itemwizard_cbocategories").options.add(opt);
				document.getElementById("itemwizard_cbocategories").innerHTML+=xmlHttp.responseText;
				document.getElementById("itemwizard_cboAvailable").innerHTML="";
				var tableText = "<TABLE id=\"tblOptions\">";
				 tableText += "<tr><td>No Properties available</td></tr>";
				 tableText += "</TABLE>";
				 document.getElementById("itemwizard_cboAvailable").innerHTML=tableText;
				alert("Sub Category is added.");
				closeCategoryWindow();
				//ClearCategoryInterface();
			}
		 //document.getElementById("txtprint").innerHTML=xmlHttp.responseText;
		 //setTimeout("location.reload(true);",1000);
	 	}
	}
}
	

//Save Property
function saveAndAssign()
{     
		
	if (document.getElementById("itemwizard_cbocategories").value == "" || document.getElementById("itemwizard_cbocategories").value == null)
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select the Sub Category first.");		
		return;
	}
	
	var flag=true;
	
	if(document.getElementById("itemwizard_txtassign").value.trim() =="")
	{
		document.getElementById("itemwizard_txtassign").focus();
		alert("Please enter the property");		
		return false;
	}
	
	else if (isNumeric(document.getElementById("itemwizard_txtassign").value))
	{	document.getElementById("itemwizard_txtassign").focus();
		alert("Property, \""+document.getElementById("itemwizard_txtassign").value+"\" should be Alphanumeric");
		return false;
	}
	
	var tmptext = document.getElementById("itemwizard_txtassign").value;
	//alert(document.getElementById("itemwizard_cboAvailable").options.length);
	for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cboAvailable").options.length; loop1 ++)
	{
		if(document.getElementById("itemwizard_cboAvailable").options[loop1].text==tmptext)						
		{	
			flag=false;	
			document.getElementById("itemwizard_txtassign").focus();
			alert("Property, \""+document.getElementById("itemwizard_txtassign").value+"\" is already assigned.")
		}		
	}
	
	if(flag){
		
        xmlHttp=GetXmlHttpObject();
		
        var url="server.php";
		url=url+"?q=Savepro";
	
			//url=url+"&strPropertyCode="+document.getElementById("txtvalue").value;
		url=url+"&strPropertyName="+URLEncode(document.getElementById("itemwizard_txtassign").value);
		var subCatID = document.getElementById("itemwizard_cbocategories").value;
				
		if(document.getElementById("itemwizard_chkassign").checked==true)
		{
			assign=1;
		}
		else
		{
			assign=0;
		}
		
		url=url+"&assign="+assign + "&subCatID=" + subCatID;
           
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}	
}

function ClearCategoryInterface()
{
	document.getElementById("chkinspection").checked = false;
	document.getElementById("chkdisplay").checked = false;
	document.getElementById("txtcatname").value = "";
	document.getElementById("txtcatcode").value = "";
}

//Add property to sub category
function Asignproperty()
{    

	if(document.getElementById("itemwizard_cbocategories").value=="")
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select Sub Catagory");			
		return false;
	}
	else if(document.getElementById("cboproperty").value=="")
	{
		document.getElementById("cboproperty").focus();
		alert("Please select Property");
		return false;
	}
	else
	{
		altxmlHttp=GetXmlHttpObject();
		//xmlHttp=GetXmlHttpObject();
		var url="server.php";
		url=url+"?q=Add";
		
		//Save Sub Category
		url=url+"&intPropertyId="+document.getElementById("cboproperty").value;				
		//	url=url+"&strPropName="+document.getElementById("cboproperty").options[document.getElementById('cboproperty').selectedIndex].text;
		url=url+"&intSubCatId="+document.getElementById("itemwizard_cbocategories").value;					

		altxmlHttp.onreadystatechange=stateChangedalt;
		altxmlHttp.open("GET",url,true);
		altxmlHttp.send(null);			
		GetProperty();			
   }
}


//Assign value to property 
function Asignvalue(addvalue)
{    

     if(document.getElementById("cboproperty").value=="")
		{
			document.getElementById("cboproperty").focus();
			alert("Please select Property");
			return false;
		}
		else if(document.getElementById("cbocassignvalue").value=="")
		{
			document.getElementById("cbocassignvalue").focus();
			alert("Please select the Value");
			return false;
		}
		else
		{
	 
			xmlHttp=GetXmlHttpObject();
			
			var url="server.php";
			url=url+"?q=Assign";
			
			
	
				
				url=url+"&intPropertyId="+document.getElementById("cboproperty").value;
				url=url+"&intSubPropertyid="+document.getElementById("cbocassignvalue").value;	
				//url=url+"&strSubPropName="+document.getElementById("cbocassignvalue").options[document.getElementById('cbocassignvalue').selectedIndex].text;	
				

		
			
			xmlHttp.onreadystatechange=stateChanged;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
			
	   }
}



//Save Value
function SaveValue(propID,rowIndex)
{    
//alert(document.getElementById("txtNewValue").value);

		var assivalu=0;
	 	if (document.getElementById("txtNewValue").value == "" || document.getElementById("txtNewValue").value == null)
		{
			document.getElementById("txtNewValue").focus();
			alert("Please enter the Value.");
			return;
		}
		xmlHttp=GetXmlHttpObject();
		
		var url="server.php";
		url=url+"?q=savevalue";
			

		//url=url+"&strSubPropertyCode="+document.getElementById("txtvaluecode").value;
		url=url+"&strSubPropertyName="+ URLEncode(document.getElementById("txtNewValue").value);
		url=url+"&intPropertyId="+propID;	
		
		if(document.getElementById("chkassignvalue").checked==true)
			assivalu=1;
		else
			assivalu=0;
		
		url=url+"&assivalu="+assivalu;
		
		xmlHttp.onreadystatechange=HandleValueSaving;
		xmlHttp.rowIndex = rowIndex;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null); 
	   
}

function HandleValueSaving()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			if (xmlHttp.responseText == "-1")
			{
				document.getElementById("txtNewValue").focus();
				alert("The Value, \""+document.getElementById("txtNewValue").value+"\" is already exist.");
			}
			else
			{
				alert("The Value saved successfully.");
				var id = xmlHttp.responseText;
				var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				opt.value = document.getElementById("txtNewValue").title;
				//alert(opt.text);
				//alert(opt.value);
				document.getElementById("cboValues").options.add(opt);
				if(document.getElementById("chkassignvalue").checked==true)
				{
					var tblValues = document.getElementById("tblValues");
					var cbo = tblValues.rows[xmlHttp.rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
					var opt = document.createElement("option");
					opt.text = document.getElementById("txtNewValue").value;
					opt.value = document.getElementById("txtNewValue").title;
					cbo.options.add(opt);
					//alert(cbo.options.length);
					cbo.selectedIndex= cbo.options.length-1;
					closeLayer();
				}
				
				
			}

			
		}
		
	}
	
}

function isDuplicateSelections()
{
	var arr = [];
	var tbl = document.getElementById('tblValues');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var optValue = tbl.rows[loop].cells[5].childNodes[0].childNodes[0].value;
		if (!findItem(optValue, arr))
		{
			arr[loop-1] = optValue ;
		}
		else
		{
			alert("Couldn't start save process. \nThere is a error with your serial selection. Please select it correctly.");
			return false;
		}
	}
	return true;
}

function Savenfinish()
{   
	if (!isDuplicateSelections())
	{
		return ;	
	}
	var mainCatID = mainID;
	var subCatID = document.getElementById("itemwizard_cbocategories").value;
	var tbl = document.getElementById('tblValues');
	var CatCodes = ["FA", "AC", "PA","SE","OT"];
	var ItemCode = CatCodes[mainCatID-1] + "_" + subCatID + ",";
	var displayCode = CatCodes[mainCatID-1] + "_" + subCatID + "#";
	var propIDlist=",";
	var propValueIdList =",";
	var displayStrList = "";
	var strBeforeAfterList = "";
	var serialList = "";
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value!=""){
		var PropID = tbl.rows[loop].cells[0].id;
		var propValue = tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value;

		//valName = tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options[tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].selectedIndex].value;
		//alert(propValue);
		//alert(valName);
		var displayStr = tbl.rows[loop].cells[3].childNodes[0].value;
		var strBeforeAfter = tbl.rows[loop].cells[4].childNodes[0].value;
		if(strBeforeAfter == 'Before'){
			strBeforeAfter = 1;
		}
	   if(strBeforeAfter == 'After'){
			strBeforeAfter = 2;
		}

		var serial = tbl.rows[loop].cells[5].childNodes[0].lastChild.value;
	
		//bookmark
		ItemCode += PropID + "." + propValue + ",";
		displayCode += PropID + "." + propValue + "#";
		propIDlist+=PropID+",";
		propValueIdList+=propValue+",";
		
		displayStrList+=displayStr+",";
		strBeforeAfterList+=strBeforeAfter+",";
		serialList+=serial+",";	
		}
	}
	
	
	
	var ItemName = document.getElementById("itemwizard_cbocategories").options[document.getElementById("itemwizard_cbocategories").selectedIndex].text;
	
	if (mainCatID == 1)
	{
		if(document.getElementById("itemwizard_cboFabricContent").options[document.getElementById("itemwizard_cboFabricContent").selectedIndex].text != "");
		ItemName += " " + document.getElementById("itemwizard_cboFabricContent").options[document.getElementById("itemwizard_cboFabricContent").selectedIndex].text ;
	}
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		for (var x = 1; x < tbl.rows.length ; x++)
		{
			var optValue = tbl.rows[x].cells[5].childNodes[0].childNodes[0].value;
			if (optValue == loop)
			{
				if (tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options.length <=0 )
				{
					alert("No values set for some properties. Please select proper values.");	
					return;
				}
				var valueName = tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].options[tbl.rows[x].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].selectedIndex].text;
				
				if(tbl.rows[x].cells[2].childNodes[0].childNodes[0].checked )
				{
					var displayText = tbl.rows[x].cells[3].childNodes[0].value;
					var subName = displayText;	
					
					if(tbl.rows[x].cells[4].childNodes[0].value == "Before")
					{
						subName = displayText + " " +  valueName;
					}
					else
					{
						subName = valueName + " " +  displayText;	

					}
					ItemName += " " + subName;
				}
				else
				{
					
					ItemName += " " + valueName;
				}
			}
		}
	}

	var wastage = document.getElementById("txtWastage").value;
	var unitPrice = document.getElementById("txtUnitPrice").value;
	var unitID = document.getElementById("cboUnits").options[document.getElementById('cboUnits').selectedIndex].text;
	var purchaseID = document.getElementById("cboPurchaseUnit").options[document.getElementById('cboPurchaseUnit').selectedIndex].text;
	var MainCateID = mainID;
	var subCatID = document.getElementById("itemwizard_cbocategories").value;
        
        var fabricTypeCode = $("#cbofabrictype").val();
	
	if(confirm("The new item name will be as follows\n\n" + ItemName + "\n\nDo you wan't to continue with this."))
	{
		createXMLHttpRequest();	
    	xmlHttp.onreadystatechange = HandleMaterialSaving;
		//alert(strBeforeAfterList);
    	//xmlHttp.open("GET", 'wizardmiddle.php?str=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + MainCateID + '&subCatID=' + subCatID+'&propValueIdList='+propValueIdList+'&propIDlist='+propIDlist+ '&Wastage=' + wastage + '&unitID=' + unitID + '&purchaseID=' + purchaseID + '&serialList=' + serialList + '&strBeforeAfterList=' + strBeforeAfterList + '&displayStrList=' + displayStrList +   '&unitPrice=' + unitPrice, true);
    	xmlHttp.open("GET", 'wizardmiddle.php?str=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + MainCateID + '&subCatID=' + subCatID+'&propValueIdList='+propValueIdList+'&propIDlist='+propIDlist+ '&Wastage=' + wastage + '&unitID=' + unitID + '&purchaseID=' + purchaseID + '&serialList=' + serialList + '&strBeforeAfterList=' + strBeforeAfterList + '&displayStrList=' + displayStrList +   '&unitPrice=' + unitPrice + '&fabtypecode='+fabricTypeCode, true);
   	xmlHttp.send(null);
   }  
	
	
	
}

function HandleMaterialSaving()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
        		var result = xmlHttp.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
				var message = xmlHttp.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
				if(result == "True")
				{
					alert(message);
					//setTimeout("location.reload(true);",1);
        			//alert("Item Code : " + displayCode + "\n Item Name : " + ItemName + "\n Saving Process completed.");
        		}
        		else
        		{
        			alert(message);
				}
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
	

function ClearForm()
{	
	//setTimeout("location.reload(true);",1000);
	document.getElementById('cboproperty').value==""
}
				

function GetProperty()
{   
	MoveAllItemsRight();
	var subcatid = document.getElementById('itemwizard_cbocategories').value;
	if(subcatid.trim()=="")
	{
		document.getElementById("imgP").src="../../images/addmark.png";
	}
	else
	{
		document.getElementById("imgP").src="../../images/edit.png";
	}
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleProperty;
	xmlHttp.open("GET", 'wizardmiddle.php?RequestType=subcat&subcatid=' + subcatid+'&str='+"subcat", true);
	xmlHttp.send(null); 		
}



function HandleProperty()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			//count=0;
			try
			{
				RemoveAvailableProperties();
				var XMLPropertyId = xmlHttp.responseXML.getElementsByTagName("PropertyId");
				var XMLPropertyName = xmlHttp.responseXML.getElementsByTagName("PropertyName");
				//var tableText = "<TABLE id=\"tblOptions\">";
				
				if (XMLPropertyId.length == 0 )
				 {
					 if (document.getElementById('itemwizard_cbocategories').value != "")
					 {
						 RemoveAvailableProperties();
						 var tableText = "<TABLE id=\"tblOptions\">";
						 tableText += "<tr><td>No Properties available</td></tr>";
						 tableText += "</TABLE>";
						 document.getElementById("itemwizard_cboAvailable").innerHTML=tableText;
					 }
					// tableText += "<tr><td colspan=\"3\">No Properties available for this category.</td></tr>";
				 }
				
				 else{
					 if(document.getElementById("itemwizard_cboAvailable").options.length==0){
							var tableText = "<TABLE id=\"tblOptions\">";
						 tableText += "<tr><td></td></tr>";
						 tableText += "</TABLE>";
						 document.getElementById("itemwizard_cboAvailable").innerHTML=tableText;
					 }
					
					 for ( var loop = 0; loop < XMLPropertyId.length; loop ++)
					 {
						var opt = document.createElement("option");
						opt.text = XMLPropertyName[loop].childNodes[0].nodeValue;
						opt.value = XMLPropertyId[loop].childNodes[0].nodeValue;
						document.getElementById("itemwizard_cboAvailable").options.add(opt);
						
						for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cbocolors").options.length; loop1 ++)
						{
							if(document.getElementById("itemwizard_cbocolors").options[loop1].value==opt.value)		{
								document.getElementById("itemwizard_cbocolors").options[loop1] = null;
							}
							
						}
					 }

			/*		var opt = document.createElement("option");
					opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
					opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
					document.getElementById("property").options.add(opt);
					document.getElementById("property").innerHTML+=xmlHttp.responseText; */         
					//tableText +=  "<tr> <td width=\"8%\">&nbsp;</td><td width=\"8%\"><input type=\"checkbox\" id=\""+XMLPropertyId[loop].childNodes[0].nodeValue+"\" name=\"chkproperty1\" /></td> <td class=\"normalfnt\">"+XMLPropertyName[loop].childNodes[0].nodeValue+"</td></tr>"; 
					
					//++count;
				 }
				 //tableText += "</TABLE>"
				 //document.getElementById("property").innerHTML = tableText;
				// alert(tableText);
				
			}
			catch(err)
			{
				
			}
			
		}
	}
}

function RemoveAvailableProperties()
{
	var index = document.getElementById("itemwizard_cboAvailable").options.length;
	while(document.getElementById("itemwizard_cboAvailable").options.length > 0) 
	{
		index --;
		document.getElementById("itemwizard_cboAvailable").options[index] = null;
	}
}


function Prpopertychkbox()
{   
	var checkedProperty=new Array();

	if(document.getElementById('itemwizard_cbocategories').value=="")
	{
		document.getElementById('itemwizard_cbocategories').focus();
		alert("Please select the Sub Category");
		return false;
	}
	else
	{		
		
		if(count>0)
		{
			var selected = false;	
			var incr = 0;
			var tbl = document.getElementById("tblOptions");
			for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
			{
				var opt = tbl.rows[loop].cells[1].lastChild;
				if (opt.checked)
				{
					selected = true;
					checkedProperty[incr]=opt.id;	
					incr ++;
				}
			}

			if(!selected)
			{
				alert("Please select the Property"); 
			}
			else
			{
				
				var url="wizard2.php?";
				var loop=0;
				for(;loop<checkedProperty.length;loop++)
				{
					//alert(checkedProperty[loop]);
					url+="property"+loop+"="+checkedProperty[loop]+"&";
					
				}
				
				url+="count="+loop;
				
				url=url+"&SubCatid="+document.getElementById("itemwizard_cbocategories").value;	
				//alert(url);
				window.location.href=url;
			}
		}
		else
		{
			alert("Please add Property for Sub Category"); 
		}
		
	}
	
}


function BacktoPage(intCatID)
	{
		window.location.href="wizard1.php?intCatNo="+intCatID;
	}


	function PageNavigate(CatID)
	{ 
		if(document.getElementById("itemwizard_cbocategories").value=="")
		{
			document.getElementById("itemwizard_cbocategories").focus();
			alert("Please select Sub Catagory");
			return false;
		}
		else
		{
		window.location.href="wizard3.php?CatID="+CatID;
		}
	}

	//function A()
//	{   
//		var tbl = document.getElementById('tblProperty');
//		for ( var loop = 0 ;loop < tbl.rows.length-1 ; loop ++ )
//		{
//			var rw = tbl.rows[loop];
//			var  t  = rw.cells[0].lastChild.value;
//			alert(t);
//			/*
			//if (t.options.length > 0)
//			{
//				var index = t.selectedIndex;
//				var  b = t.options[index];
//				alert(t.options[index].text);
//				//alert(rw.cells[2].lastChild.id);			
//				//alert (b);
//			}
//			else
//			{
//				alert("Nothing")	
//			}
//			//
//			*/
			//if (index == -1 ) index = 0;
			//alert(t.options[index].value);
        	//var value = rw.cells[2].lastChild.value;
		//}
	
	//}
	
	//function B()
	//{
		
			//alert(document.getElementById('cboproperty').options[document.getElementById('cboproperty').selectedIndex].text);
		//alert(document.getElementById("cboproperty").options[document.getElementById('cboproperty').selectedIndex].text);	
		
		
	//}
	
// ---------------------------------------------------


function MoveItemRight()
{
	if (document.getElementById("itemwizard_cbocategories").value == "" )
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select the Sub Category.");		
		return ; 
	}
	var colors = document.getElementById("itemwizard_cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("itemwizard_cboAvailable"),true))
	{
		if(document.getElementById("itemwizard_cboAvailable").options.length==0)
				document.getElementById("itemwizard_cboAvailable").innerHTML="";
					 
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = colors.options[colors.selectedIndex].value;
		document.getElementById("itemwizard_cboAvailable").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
		document.getElementById("itemwizard_txtassign").value=selectedColor;	
		
	}
}

function MoveItemLeft()
{
	var colors = document.getElementById("itemwizard_cboAvailable");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("itemwizard_cbocolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = colors.options[colors.selectedIndex].value;
		document.getElementById("itemwizard_cbocolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
		document.getElementById("itemwizard_txtassign").value=selectedColor;
		
	}
}

function MoveAllItemsLeft()
{
	if (document.getElementById("itemwizard_cbocategories").value == "" )
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select the Sub Category.");		
		return ; 
	}
	var colors = document.getElementById("itemwizard_cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("itemwizard_cboAvailable"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("itemwizard_cboAvailable").options.add(optColor);
		}
	}
	RemoveLeftProperties();
	
}

function MoveAllItemsRight()
{
	var colors = document.getElementById("itemwizard_cboAvailable");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("itemwizard_cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].value;
			document.getElementById("itemwizard_cbocolors").options.add(optColor);
		}
	}
	RemoveAvailableProperties();
}

function RemoveLeftProperties()
{
	var index = document.getElementById("itemwizard_cbocolors").options.length;
	while(document.getElementById("itemwizard_cbocolors").options.length > 0) 
	{
		index --;
		document.getElementById("itemwizard_cbocolors").options[index] = null;
	}
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text == itemName)
		{
			if (message)
				alert("The Property \"" + itemName + "\" is already exist in the list.");
			return true;			
		}
	}
	return false;
}

function LoadAllProperties()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleProperties;
	xmlHttp.open("GET", 'wizardmiddle.php?RequestType=getAllProperties', true);
	xmlHttp.send(null); 	
}

function HandleProperties()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 RemoveLeftProperties();
			 var XMLPropertyId = xmlHttp.responseXML.getElementsByTagName("PropertyId");
			 var XMLPropertyName = xmlHttp.responseXML.getElementsByTagName("PropertyName");
			
			 for ( var loop = 0; loop < XMLPropertyId.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = XMLPropertyName[loop].childNodes[0].nodeValue;
				opt.value = XMLPropertyId[loop].childNodes[0].nodeValue;
				document.getElementById("itemwizard_cbocolors").options.add(opt);
			 }
		}
		
	}
}

function getSubCatID(){
	
	//xmlHttp=GetXmlHttpObject();
	
	if(document.getElementById("itemwizard_cbocategories").value==null||document.getElementById("itemwizard_cbocategories").value==""){	
		var urlDetails="server.php?q=subCategoryID";	
		htmlobj=$.ajax({url:urlDetails,async:false});
		showCategoryForm1(htmlobj.responseText);
	}
	else{
		
		var urlDetails="wizardmiddle.php?str=subCategoryID&subCat="+document.getElementById("itemwizard_cbocategories").value;	
		htmlobj=$.ajax({url:urlDetails,async:false});
		var CatID=htmlobj.responseXML.getElementsByTagName("CatID")[0].childNodes[0].nodeValue;
		var CatCode=htmlobj.responseXML.getElementsByTagName("CatCode")[0].childNodes[0].nodeValue;
		var CatName=htmlobj.responseXML.getElementsByTagName("CatName")[0].childNodes[0].nodeValue;
		var Display=htmlobj.responseXML.getElementsByTagName("Display")[0].childNodes[0].nodeValue;
		var Inspection=htmlobj.responseXML.getElementsByTagName("Inspection")[0].childNodes[0].nodeValue;
		var AdditionalAllowed=htmlobj.responseXML.getElementsByTagName("AdditionalAllowed")[0].childNodes[0].nodeValue;
		showCategoryForm(CatID,CatCode,CatName,Display,Inspection,AdditionalAllowed);	
	}
}

function showCategoryForm1(a)
{
	
	var htmlText = "<table width=\"500\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					 "<tr>"+
						"<td width=\"1%\">&nbsp;</td>"+
						"<td width=\"30%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
						  "<table width=\"100%\" class=\"bcgl2Lbl\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"mainHeading\"><table width=\"100%\" border=\"0\" >"+
								"<tr>"+
								  "<td width=\"93%\">Sub Category</td>"+
								  "<td width=\"7%\"><img src=\"../../images/cross.png\" class=\"mouseover\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeCategoryWindow();\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"7\" colspan=\"2\">&nbsp;</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" class=\"normalfnt\">Sub Category Code</td><td width=\"61%\"><input maxlength=\"20\""+"tabindex=\"21\" name=\"txtcatcode\" type=\"text\" class=\"txtbox\" id=\"txtcatcode\" value=\""+a+"\" /></td></tr><tr>"+
							  "<td width=\"39%\" height=\"1\" class=\"normalfnt\">Sub Category Name</td>"+
							  "<td><input maxlength=\"50\"  tabindex=\"22\" name=\"txtcatname\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=categories&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtcatname\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Display </td>"+
				"<td ><input tabindex=\"23\" type=\"checkbox\" name=\"chkdisplay\" id=\"chkdisplay\" /></td>"+
								  "<tr><td class=\"normalfnt\">Inspection</td>"+
								  "<td class=\"normalfnt\"><input tabindex=\"24\" type=\"checkbox\" name=\"chkinspection\" id=\"chkinspection\" /></td></tr>"+
								"<tr>"+
								  "<td class=\"normalfnt\">Allow Additional Qty </td>"+
								  "<td><input tabindex=\"25\" type=\"checkbox\" name=\"chkadditionalQty\" id=\"chkadditionalQty\" /></td>"+
								  
								"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"25%\">&nbsp;</td>"+
								  "<td width=\"25%\"><img src=\"../../images/addsmall.png\" class=\"mouseover\" alt=\"add\" width=\"95\" height=\"24\" onClick=\"SaveCategory();\" /></td>"+
								  "<td width=\"25%\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" class=\"mouseover\" onClick=\"closeCategoryWindow();\" /></td>"+								  
								  "<td width=\"*\">&nbsp;</td>"+
								"</tr>"+
							 "</table></td>"+
							"</tr>"+
						  "</table>"+
								"</form>"+
						"</td>"+
						"<td width=\"1%\">&nbsp;</td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";	
	 var popupbox = document.createElement("div");
     popupbox.id = "catview";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 165+ 'px'; 
	 popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
	document.getElementById("txtcatname").focus();
}

function showCategoryForm(CatID,CatCode,CatName,Display,Inspection,AdditionalAllowed)
{
	
	var htmlText = "<table width=\"500\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					 "<tr>"+
						"<td width=\"1%\">&nbsp;</td>"+
						"<td width=\"30%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
						  "<table width=\"100%\" class=\"bcgl2Lbl\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"mainHeading\"><table width=\"100%\" border=\"0\" >"+
								"<tr>"+
								  "<td width=\"93%\">Sub Category</td>"+
								  "<td width=\"7%\"><img src=\"../../images/cross.png\" class=\"mouseover\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeCategoryWindow();\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"7\" colspan=\"2\">&nbsp;</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" class=\"normalfnt\">Sub Category Code</td><td width=\"61%\"><input maxlength=\"20\""+"tabindex=\"11\" name=\"txtcatcode\" type=\"text\" class=\"txtbox\" id=\"txtcatcode\" value=\""+CatCode+"\" /></td></tr><tr>"+
							  "<td width=\"39%\" height=\"1\" class=\"normalfnt\">Sub Category Name</td>"+
							  "<td><input maxlength=\"50\"  tabindex=\"12\" name=\"txtcatname\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=categories&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtcatname\" value=\""+CatName+"\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Display </td>"+
				"<td ><input tabindex=\"13\" type=\"checkbox\" name=\"chkdisplay\" id=\"chkdisplay\"";
				if(Display==1)htmlText+="checked=\"checked\"";
				htmlText+="/></td></tr>"+
								  "<tr><td class=\"normalfnt\">Inspection</td>"+
								  "<td class=\"normalfnt\"><input tabindex=\"14\" type=\"checkbox\" name=\"chkinspection\" id=\"chkinspection\"";
				if(Inspection==1)htmlText+="checked=\"checked\""; 
				htmlText+="/></td></tr>"+
								"<tr><td class=\"normalfnt\">Allow Additional Qty </td>"+
								  "<td><input tabindex=\"15\" type=\"checkbox\" name=\"chkadditionalQty\" id=\"chkadditionalQty\"";
				if(AdditionalAllowed==1)htmlText+="checked=\"checked\"";
				htmlText+="/></td></tr>"+
							"<tr><td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"25%\"><img src=\"../../images/new.png\" alt=\"New\" name=\"New\" onclick=\"shiftToNew();\" class=\"mouseover\" /></td>"+
								  "<td width=\"25%\"><img src=\"../../images/save.png\" class=\"mouseover\" alt=\"Save\" width=\"95\" height=\"24\" onClick=\"SaveCategoryM("+CatID+");\" /></td>"+
								  "<td><img src=\"../../images/delete.png\" alt=\"Delete\" name=\"Delete\" onclick=\"deleteSubCat("+CatID+");\" class=\"mouseover\" /></td>"+
								  "<td width=\"25%\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" class=\"mouseover\" onClick=\"closeCategoryWindow();\" /></td>"+								  
								"</tr>"+
							 "</table></td>"+
							"</tr>"+
						  "</table>"+
								"</form>"+
						"</td>"+
						"<td width=\"1%\">&nbsp;</td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";	
	 var popupbox = document.createElement("div");
     popupbox.id = "catview";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 165+ 'px'; 
	 popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);	
}

function shiftToNew()
{
		closeCategoryWindow();
		var urlDetails="server.php?q=subCategoryID";	
		htmlobj=$.ajax({url:urlDetails,async:false});
		showCategoryForm1(htmlobj.responseText);
}

function closeCategoryWindow()
{
	try
	{
		var box = document.getElementById('catview');
		box.parentNode.removeChild(box);
		closeList();
	}
	catch(err)
	{        
	}	
}

function ShowNameCreationWindow()
{
	//if (document.getElementById("itemwizard_cboAvailable").options.length <= 0 )
	//{
		//alert("Please select a property at least.");		
		//return ; 
	//}
	
	if (document.getElementById("itemwizard_cbocategories").value == "" || document.getElementById("itemwizard_cbocategories").value == null)
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select the Sub Category first.");
		return;
	}
	
	drawPopupArea(600,340,'frmNameCreator');
	var HTMLText = "<table  width=\"600\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td></td>"+
				  "</tr>"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
					//	"<td width=\"1%\">&nbsp;</td>"+
						"<td width=\"100%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
						  "<table width=\"100%\" border=\"0\">"+
							"<tr>"+
							  "<td height=\"24\" colspan=\"4\" class=\"mainHeading\"><table width=\"100%\" border=\"0\"><tr><td width=\"95%\">Assign Properties</td><td><img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeWindow();\" class=\"mouseover\" /></td></tr></table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"4\"><div id=\"divcons\" style=\"overflow:scroll; height:150px; width:585px;\">"+
								"<table id=\"tblValues\" width=\"580px\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
									"<td colspan=\"2\" width=\"22%\" class=\"mainHeading2\">Property Name</td>"+
									"<td width=\"22%\" class=\"mainHeading2\">Property Value</td>"+
									"<td width=\"5%\" class=\"mainHeading2\">Display?</td>"+
									"<td width=\"25%\" class=\"mainHeading2\">Display Str</td>"+
									"<td width=\"17%\" class=\"mainHeading2\">Place</td>"+
									"<td width=\"5%\" class=\"mainHeading2\">Serial</td>"+
								  "</tr>";
								  
								  
						
						for (var i = 0 ; i < document.getElementById("itemwizard_cboAvailable").options.length ; i++)
						{
							var text = document.getElementById("itemwizard_cboAvailable").options[i].text;
							var value = document.getElementById("itemwizard_cboAvailable").options[i].value;
						
							HTMLText += "<tr>"+
										"<td colspan=\"2\" class=\"normalfnt\" id=\"" +  value + "\">" + text + "</td>"+
										"<td class=\"normalfnt\"><table width=\"93%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										  "<tr>"+
											"<td width=\"79%\"><select name=\"CBOadd\" class=\"txtbox\" id=\"CBOadd\" style=\"width:90px\">"+
													"</select></td>"+
											"<td width=\"21%\"><img src=\"../../images/add.png\" alt=\"[+]\" width=\"16\" height=\"16\" class=\"mouseover\" onClick=\"ShowNewValueForm(this);\" /></td>"+
										  "</tr>"+
										"</table></td>"+
										"<td class=\"normalfntRite\"><div align=\"center\">"+
										  "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"displayStrCtrl(this,"+i+");\" />"+
										"</div></td>"+
										"<td><input name=\"textfield"+i+"\" id=\"textfield"+i+"\" type=\"text\" class=\"txtbox\" size=\"15\" disabled=\"disabled\" /></td>"+
										"<td><select name=\"select2\" class=\"txtbox\">"+
										  "<option value=\"Before\">Before</option>"+
										  "<option value=\"After\">After</option>"+
										"</select>                    </td>"+
										"<td><div align=\"center\">"+
										  "<select name=\"select2\" class=\"txtbox\">";
										for (var x = 0 ; x < document.getElementById("itemwizard_cboAvailable").options.length ; x++)
										{
											if (i == x )
											HTMLText += "<option value=\"" +( x + 1) + "\" selected=\"selected\">" + (x + 1) +"</option>";
											else
											HTMLText += "<option value=\"" +( x + 1) + "\">" + (x + 1) +"</option>";
										}
							HTMLText +=	  "</select>"+
										"</div></td>"+
									  "</tr>";
							createNewXMLHttpRequest(i);
							xmlHttpreq[i].onreadystatechange = HandlePropertyRequest;
							xmlHttpreq[i].value = value;
							xmlHttpreq[i].index = i;
							xmlHttpreq[i].open("GET", 'wizardmiddle.php?str=getPropValues&PropID=' + value, true);
							xmlHttpreq[i].send(null);
								  
						}
								 
					HTMLText += "</table>"+
							 " </div></td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"90\" height=\"3\" class=\"normalfnt\">Unit</td>"+
							  "<td width=\"200\"><select name=\"cboUnits\" class=\"txtbox\" id=\"cboUnits\" style=\"width:90px\" tabindex=\"4\">"+
							  "</select></td>"+
							  "<td width=\"140\" class=\"normalfnt\">Wastage</td>"+
							  "<td width=\"80\" align=\"right\"><input name=\"txtWastage\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  type=\"text\" id=\"txtWastage\" maxlength=\"11\" size=\"13\" tabindex=\"5\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Purchase Unit</td>"+
							  "<td ><select name=\"cboPurchaseUnit\" id=\"cboPurchaseUnit\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+
							  "<td class=\"normalfnt\">Unit Price</td>"+
							  "<td align=\"right\"><input name=\"txtUnitPrice\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  type=\"text\" id=\"txtUnitPrice\" maxlength=\"11\" size=\"13\" tabindex=\"7\" /></td>"+							  
							"</tr>"+
                                                        "<tr>"+
							  "<td class=\"normalfnt\">Fabric Type</td>"+
							  "<td ><select name=\"cboFabricType\" id=\"cboFabricType\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+
							  "<td class=\"normalfnt\">&nbsp;</td>"+
							  "<td align=\"right\">&nbsp;</td>"+							  
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"4\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"3%\">&nbsp;</td>"+
								  "<td width=\"6%\">&nbsp;</td>"+
								  "<td width=\"91%\" class=\"normalfnt\">&nbsp;</td>"+
								"</tr>"+
							 " </table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"4\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  /*"<td width=\"33%\">&nbsp;</td>"+*/
								  "<td width=\"50%\"><div align=\"right\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeWindow();\" /></div></td>"+
								  "<td width=\"50%\" align=\"left\"><img src=\"../../images/finish.png\" alt=\"save\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"Savenfinish();\" /></td>"+
								"</tr>"+
							 " </table></td>"+
							"</tr>"+
						  "</table>"+
								"</form>"+
						"</td>"+
						//"<td width=\"1%\">&nbsp;</td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				  "<tr>"+
					"<td></td>"+
				  "</tr>"+
				"</table>";

	document.getElementById('frmNameCreator').innerHTML=HTMLText;
	LoadAvailableUnits();
        LoadFabricType();
}

function LoadFabricType(){
    
    var url = "../../preordermiddletire.php?RequestType=GetFabricTypes";
    var htmlObj = $.ajax({url:url,async:false});
    //alert(htmlObj.responseText);
    var XMLFabricTypeCode = htmlObj.responseXML.getElementsByTagName("TYPE_CODE");
    var XMLFabricTypeName = htmlObj.responseXML.getElementsByTagName("TYPE_NAME");
    
    for (var loop = 0; loop < XMLFabricTypeCode.length; loop ++){
        $("#cboFabricType").append($('<option>',{value:XMLFabricTypeCode[loop].childNodes[0].nodeValue, text:XMLFabricTypeName[loop].childNodes[0].nodeValue}));
    }
    
}
	
function LoadAvailableUnits()
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleUnits;
    xmlHttp.open("GET", '../../preordermiddletire.php?RequestType=GetUnits', true);
    xmlHttp.send(null); 
}

function HandleUnits()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("unit");
			 /*for ( var loop = 0; loop < XMLName.length; loop ++)
			 {
				var opt = document.createElement("option");
				var optp = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLName[loop].childNodes[0].nodeValue;
				optp.text = XMLName[loop].childNodes[0].nodeValue;
				optp.value = XMLName[loop].childNodes[0].nodeValue;
				document.getElementById("cboUnits").options.add(opt);
				document.getElementById("cboPurchaseUnit").options.add(optp);
			 }*/
			 document.getElementById("cboUnits").innerHTML =  XMLName[0].childNodes[0].nodeValue
			  document.getElementById("cboPurchaseUnit").innerHTML =  XMLName[0].childNodes[0].nodeValue
		}
	}
}

function HandlePropertyRequest()
{	
    if(xmlHttpreq[this.index].readyState == 4) 
    {
        if(xmlHttpreq[this.index].status == 200) 
        {  
			var tblValues = document.getElementById("tblValues");
			var cbo = tblValues.rows[this.index + 1].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
			var XMLValueID = xmlHttpreq[this.index].responseXML.getElementsByTagName("PropID");
			 var ValueName = xmlHttpreq[this.index].responseXML.getElementsByTagName("PropName");
			 var opt = document.createElement("option");
			opt.text = "";
			opt.value = "";
			cbo.options.add(opt);
			 for ( var loop = 0; loop < XMLValueID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = ValueName[loop].childNodes[0].nodeValue;
				opt.value = XMLValueID[loop].childNodes[0].nodeValue;
				cbo.options.add(opt);
			 }
			//alert(xmlHttpreq[this.index].value);
		}
	}
	
}

function displayStrCtrl(objChk,i)
{	
		//alert(objChk.checked);
		if(!objChk.checked)
		{
			//alert("not Checked");
			document.getElementById("textfield"+i).disabled= true;
			document.getElementById("textfield"+i).value="";			
		}
		else
		{
			//alert("Checked");
			document.getElementById("textfield"+i).disabled=false;
			document.getElementById("textfield"+i).value="";
						
		}
}


function ShowNewValueForm(obj)
{
	var propertyName = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
	var propValue = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].id;
	var rowIndex = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.rowIndex;
	drawPopupAreaLayer(350,360,'frmValueSelecter',14);
	var HTMLText = "<table width=\"350\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
						"<td width=\"26%\">&nbsp;</td>"+
						"<td width=\"30%\">"+
						  "<table width=\"100%\" border=\"0\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"TitleN2white\"><table width=\"100%\" border=\"0\" class=\"mainHeading\">"+
								"<tr>"+
								  "<td width=\"93%\">Select Value</td>"+
								  "<td width=\"7%\"><img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeLayer();\" class=\"mouseover\" /></td></tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"7\" colspan=\"2\"></td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" valign=\"top\" class=\"normalfnt\">Property</td>"+
							  "<td width=\"61%\" valign=\"top\" class=\"normalfnt\" >" + propertyName + "</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" valign=\"top\" class=\"normalfnt\">Search Property</td>"+
							   "<td width=\"61%\" valign=\"top\" class=\"normalfnt\"><input maxlength=\"20\" onkeypress=\"EnableEnterSubmitLoadProp(event,"+propValue+");\" name=\"txtNewPropValue\" type=\"text\" class=\"txtbox\" id=\"txtNewPropValue\" size=\"20\" tabindex=\"101\"/></td>"+
							  "</tr>"+
							"<tr>"+
							  "<td height=\"-1\" colspan=\"2\" class=\"normalfnt\"><div align=\"center\">"+
								"<select name=\"cboValues\" ondblclick=\"moveValueToTextBox(" + rowIndex  + "," + propValue +");\" size=\"10\" class=\"txtbox\" id=\"cboValues\" style=\"width:275px\">"+
								"</select>"+
							  "</div></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"22%\">&nbsp;</td>"+
								  "<td width=\"38%\" align=\"right\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closeLayer();\" class=\"mouseover\" /></td>"+
								  "<td width=\"40%\" align=\"right\"><img src=\"../../images/ok.png\" onClick=\"AddValueToList(" + rowIndex  + "," + propValue +")\" alt=\"close\" class=\"mouseover\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"2\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
									"<tr>"+
									  "<td height=\"21\" colspan=\"2\" class=\"mainHeading2\">Value</td>"+
									  "<td height=\"21\" class=\"mainHeading2\"><img src=\"../../images/edit.png\" style=\"vertical-align:bottom;\" alt=\"Edit\" width=\"20\" height=\"15\" class=\"mouseover\" onclick=\"showPropertyValueModifyForm();\" /></td>"+
									"</tr>"+
									"<tr>"+
									  "<td width=\"58%\"><input maxlength=\"50\" tabindex=\"102\" name=\"txtNewValue\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=propertyValues&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"20\" /></td>"+
									  "<td width=\"26%\" align=\"right\"><input checked=\"checked\" tabindex=\"102\" align=\"right\" type=\"checkbox\" name=\"chkassignvalue\" id=\"chkassignvalue\" /></td>"+
									  "<td width=\"16%\" class=\"normalfnt\">Assign</td>"+
									"</tr>"+
									"<tr>"+
									  "<td colspan=\"3\" class=\"mbari13\"><div align=\"right\"><img tabindex=\"103\" src=\"../../images/addsmall.png\" id=\"butSave\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
									"</tr>"+
								  "</table></td>"+
								  "</tr>"+
							  "</table></td>"+
							"</tr>"+							
						  "</table>"+
						"</td>"+
						"<td width=\"44%\">&nbsp;</td>"+
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";
		document.getElementById('frmValueSelecter').innerHTML=HTMLText;
		LoadApplicableValues(propValue);
}

function LoadApplicableValues(propID)
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleLoadOtherProperties;
    altxmlHttp.open("GET", 'wizardmiddle.php?str=getOtherProperties&PropID=' + propID , true);
    altxmlHttp.send(null); 
}

function HandleLoadOtherProperties()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLValueID = altxmlHttp.responseXML.getElementsByTagName("PropID");
			 var ValueName = altxmlHttp.responseXML.getElementsByTagName("PropName");
			 for ( var loop = 0; loop < XMLValueID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = ValueName[loop].childNodes[0].nodeValue;
				opt.value = XMLValueID[loop].childNodes[0].nodeValue;
				document.getElementById("cboValues").options.add(opt);
			 }
			 	document.getElementById("txtNewValue").focus();
				loadOnButtonEnter()
			//alert(xmlHttpreq[this.index].value);
		}
	}	
}

function moveValueToTextBox(rowIndex,propValue){
	document.getElementById('txtNewValue').value=URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text);	
		document.getElementById('txtNewValue').title=URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].value);	
}

function  AddValueToList(rowIndex,propValue)
{
	var colors = document.getElementById("cboValues");
	if(colors.selectedIndex <= -1) 
	{
		alert("Please select Property value to be added.");
		return;
	}
	
	xmlHttp=GetXmlHttpObject();
			
	var url="server.php";
	url=url+"?q=Assign";
	
	url=url+"&intPropertyId="+propValue;
	url=url+"&intSubPropertyid="+document.getElementById("cboValues").value;	
	url=url+"&SubPropertyName="+URLEncode(document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text);	
	
	xmlHttp.onreadystatechange=HandleValueAssigning;
	xmlHttp.open("GET",url,true);
	xmlHttp.rowIndex = rowIndex;
	xmlHttp.send(null);
	
}

function HandleValueAssigning()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			if (xmlHttp.responseText == "true")
			{
				var tblValues = document.getElementById("tblValues");
				var cbo = tblValues.rows[xmlHttp.rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
				var opt = document.createElement("option");
				
				opt.text = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].text;
				opt.value = document.getElementById("cboValues").options[document.getElementById("cboValues").selectedIndex].value;
				//alert(11);
				for(var i=0;i<cbo.options.length+1;i++){
					if(i==cbo.options.length){
						cbo.options.add(opt);						
						cbo.selectedIndex = cbo.options.length-1;
					}
					if(cbo.options[i].text==opt.text){
						i=cbo.options.length+1;
					}
				}
				
				closeLayer();
			}
			else
			{
				alert("The Property value assigning process failed. May be it already exists.");
			}
		}
		
	}
}

function findItem(item, arr) 
{
	if (arr.length <= 0) return false;
	// find index position of {item}
	// in Array {arr} - return -1, if 
	// item not found 
	var idx;
	var last = arr.length;
	for (var i = 0; i < last; i++)
	{
		idx = (item == arr[i])?i:-1;
		// quit on first "found"
		if (-1 != idx) break;
	}
	if (idx != -1)
	return true;
	else
	return false;
}

function DeleteItem(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode== 46)
	document.getElementById("itemwizard_cboAvailable").options[document.getElementById("itemwizard_cboAvailable").selectedIndex] = null;
}

function showFabricContentForm()
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleFabricContentForm;
    altxmlHttp.open("GET", 'fabricContent.php', true);
    altxmlHttp.send(null); 
}

function HandleFabricContentForm()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			drawPopupArea(515,350,'frmFabricContent');
			document.getElementById('frmFabricContent').innerHTML=altxmlHttp.responseText;
		}
	}
}

function showPropertyModifyForm()
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandlePropertyModifyForm;
    altxmlHttp.open("GET", 'propertyModify.php?propStr=' + document.getElementById('itemwizard_txtassign').value.trim(), true);
    altxmlHttp.send(null); 
}

function HandlePropertyModifyForm()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			drawPopupArea(424,412,'frmPropertyModify');
			document.getElementById('frmPropertyModify').innerHTML=altxmlHttp.responseText;
		}
	}
}

function showPropertyValueModifyForm()
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandlePropertyValueModifyForm;
    altxmlHttp.open("GET", 'propertyValueModify.php?propValStr=' + document.getElementById('txtNewValue').value.trim(), true);
    altxmlHttp.send(null); 
}

function HandlePropertyValueModifyForm()
{	
    if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			drawPopupAreaLayerPropVal(424,412,'frmPropertyValueModify',15);
			//drawPopupArea(515,350,'frmPropertyValueModify');
			document.getElementById('frmPropertyValueModify').innerHTML=altxmlHttp.responseText;
		}
	}
}

function drawPopupAreaLayerPropVal(width,height,popupname,zindex)
{
	

	 var popupbox = document.createElement("div");
     popupbox.id = "popupLayerPropVal";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = zindex;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;position:absolute;\">"+
					"<table width=\"" +width + "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td width=\"" + width + "\" height=\"" +  height + "\" align=\"center\" valign=\"middle\">Loading.....</td>"+
						"</tr>"+
					"</table>"+
					"</div><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\""+ (((screen.height - height)/4)+100) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					"</table>"+				
					"</div>";
    popupbox.innerHTML = htmltext;     
    document.body.appendChild(popupbox);
    update();
}

function generateContentName()
{
	var ontentName = "";
	document.getElementById('txtContentName').value = "";
	var tbl = document.getElementById('tblContent');
    for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
  	{
		if(tbl.rows[loop].cells[1].childNodes[0].value != 0)
			document.getElementById('txtContentName').value += tbl.rows[loop].cells[1].childNodes[0].value + "% " + tbl.rows[loop].cells[0].innerHTML + " ";
	}
}

function editProperty(ID,str){
	
	document.getElementById(ID).disabled=false;		
	document.getElementById("div"+ID).innerHTML="&nbsp;<input name=\""+ID+"\"id=\""+ID+"\" height=\"25\" style=\"width:250px\" value=\""+str+"\" type=\"text\" class=\"txtboxRightAllign\" maxlength=\"50\" />&nbsp;<img src=\"../../images/accept.png\" width=\"15\" alt=\"Save\" height=\"15\" onclick=\"saveProperty("+ID+");\" />";
	document.getElementById(ID).focus();
}

function delProperty(ID,str){
	
	var responce=confirm("Are you sure you want to delete the property, \""+str+"\" ?");
	if (responce==true){
	
		var urlDetails="propertyModifyDB.php?q=Delete&intPropertyId="+ID;	
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		
		if(htmlobj.responseText=="Property deleted successfully"){
			closeWindow();
			showPropertyModifyForm();
		}		
	}
}

function saveProperty(ID){
	
	if(document.getElementById(ID).value.trim() =="")
	{
		document.getElementById(ID).focus();
		alert("Please enter the new Property name");		
		return false;
	}
	
	var urlDetails="propertyModifyDB.php?q=Save&intPropertyId="+ID+"&strPropertyName="+document.getElementById(ID).value;	
	htmlobj=$.ajax({url:urlDetails,async:false});
	alert(htmlobj.responseText);
	
	if(htmlobj.responseText=="Property is already exist")
		document.getElementById(ID).focus();
		
	if(htmlobj.responseText=="Property modified successfully"){
		closeWindow();
		showPropertyModifyForm();
	}
}

function editPropertyValue(ID,str){
	
	document.getElementById(ID).disabled=false;		
	document.getElementById("div"+ID).innerHTML="&nbsp;<input name=\""+ID+"\"id=\""+ID+"\" height=\"25\" style=\"width:250px\" value=\""+str+"\" type=\"text\" class=\"txtboxRightAllign\" maxlength=\"45\" />&nbsp;<img src=\"../../images/accept.png\" width=\"15\" alt=\"Save\" height=\"15\" onclick=\"savePropertyValue("+ID+");\" />";
	document.getElementById(ID).focus();
}

function delPropertyValue(ID,str){

	var responce=confirm("Are you sure you want to delete the property value, \""+str+"\" ?");
	if (responce==true){
		
		var urlDetails="propertyValueModifyDB.php?q=Delete&intSubPropertyNo="+ID;	
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		
		if(htmlobj.responseText=="Property Value deleted successfully"){
			closeLayer1();
			showPropertyValueModifyForm();
		}
	}
}

function savePropertyValue(ID){
	
	if(document.getElementById(ID).value.trim() =="")
	{
		document.getElementById(ID).focus();
		alert("Please enter the new Property Value");		
		return false;
	}
	
	var urlDetails="propertyValueModifyDB.php?q=Save&intSubPropertyNo="+ID+"&strSubPropertyName="+URLEncode(document.getElementById(ID).value);
	htmlobj=$.ajax({url:urlDetails,async:false});
	alert(htmlobj.responseText);
	
	if(htmlobj.responseText=="Property Value is already exist")
		document.getElementById(ID).focus();
		
	if(htmlobj.responseText=="Property Value modified successfully"){
		closeLayer1();
		showPropertyValueModifyForm();
	}
}

function closeLayer1()
{
	try
	{
		var box = document.getElementById('popupLayerPropVal');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
function EnableEnterSubmitLoadProp(evt,propValue)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
			 if (charCode == 13)
				loadOtherPropValwithSearchText(propValue);
}

function loadOtherPropValwithSearchText(propValue)
{
	var searchTxt = document.getElementById('txtNewPropValue').value;
	
	var url = 'wizardmiddle.php?str=getOtherPropertiesWithSearchText';
			url += '&PropID=' +propValue;
			url += '&searchTxt=' +URLEncode(searchTxt);
	
	var htmlobj=$.ajax({url:url,async:false});		
	var XMLValueID = htmlobj.responseXML.getElementsByTagName("PropID");
	var ValueName = htmlobj.responseXML.getElementsByTagName("PropName");
	ClearOptions('cboValues');	 
			 for ( var loop = 0; loop < XMLValueID.length; loop ++)
			 {
				var opt = document.createElement("option");
				opt.text = ValueName[loop].childNodes[0].nodeValue;
				opt.value = XMLValueID[loop].childNodes[0].nodeValue;
				document.getElementById("cboValues").options.add(opt);
			 }
			 	document.getElementById("txtNewValue").focus();
				loadOnButtonEnter()	
}
function ClearOptions(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}