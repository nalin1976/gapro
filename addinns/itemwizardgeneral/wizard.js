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
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200) 
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
			}
			else
				alert("Property is successfully saved.");
		}
			document.getElementById("itemwizard_txtassign").value = "";
			document.getElementById("itemwizard_chkassign").checked=true;
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
function SaveMainCategory(catId,category)
{
	if(document.getElementById('txtcatcode').value=="")
	{
		document.getElementById('txtcatcode').focus();
		alert("Please enter the Category Code.");
		return;
	}
	else if(document.getElementById('txtcatname').value=="")
	{
		document.getElementById('txtcatname').focus();
	    alert("Please enter the Category Name.");
		return;
	}	
	else if(!MainCategory_ValidateBeforeSave(catId))
		return;
	
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
	
	var url="server.php";
	url=url+"?q=Save";
	url=url+"&categoryId="+catId;
	url=url+"&StrCatName="+URLEncode(document.getElementById("txtcatname").value);
	url=url+"&StrCatCode="+document.getElementById("txtcatcode").value;	
	url=url+"&allowEx="+(document.getElementById("chkExAllow").checked==true? 1:0);	
	url=url+"&category="+category;
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseText);
}

function SaveCategory()
{	
	if(document.getElementById('txtcatcode').value=="")
	{
		document.getElementById('txtcatcode').focus();
		alert("Please enter the Category Code.");
		return;
	}
	else if(CheckitemAvailability(document.getElementById('txtcatcode').value,document.getElementById("itemwizard_cbocategories"),false))
	{
		document.getElementById('txtcatcode').focus();
		alert("The Category Name is already exist.");
		return;
	}
	
	else if(document.getElementById('txtcatname').value=="")
	{
		document.getElementById('txtcatname').focus();
	    alert("Please enter the Category Name.");
		return;
	}
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		}
		
		var url="server.php";
		url=url+"?q=SaveSubCategory";
		url=url+"&mainCatId="+document.getElementById("itemwizard_cboMainCategories").value;
		url=url+"&StrCatName="+URLEncode(document.getElementById("txtcatname").value);
		url=url+"&StrCatCode="+document.getElementById("txtcatcode").value;		
		
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
		xmlHttp.onreadystatechange=handleCategoryStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
} 

function MainCategory_ValidateBeforeSave(catId)
{	
	var x_id = catId;
	var x_name = document.getElementById("txtcatcode").value;
	
	var x_find = checkInField('genmatmaincategory','strID',x_name,'intID',x_id);
	if(x_find)
	{
		alert('" '+x_name+ ' " is already exist.');	
		document.getElementById("txtAddinsBuyerCode").focus();
		return false;
	}
	
	var x_id = catId;
	var x_name = document.getElementById("txtcatname").value;
	
	var x_find = checkInField('genmatmaincategory','strDescription',x_name,'intID',x_id);
	if(x_find)
	{
		alert('" '+x_name+'" is already exist.');	
		document.getElementById("txtAddinsName").focus();
		return false;
	}
	return true;
}

function deleteSubCat(ID)
{			   
	var urlDetails="wizardmiddle.php?str=subCategoryID&subCat="+ID;	
	htmlobj=$.ajax({url:urlDetails,async:false});
	
	var CatName=htmlobj.responseXML.getElementsByTagName("CatName")[0].childNodes[0].nodeValue;

	var responce=confirm("Are you sure you want to delete the Sub Category, \""+CatName+"\" ?");
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
		return;
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
		url=url+"&mainCatId="+document.getElementById('itemwizard_cboMainCategories').value;
		url=url+"&intSubCatNo="+ID;
		url=url+"&StrCatName="+textcatname;
		url=url+"&StrCatCode="+document.getElementById("txtcatcode").value;
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
		xmlHttp.onreadystatechange=handleCategoryStatusM;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);		
		for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cbocategories").options.length; loop1 ++)
		{
			if(document.getElementById("itemwizard_cbocategories").options[loop1].value==ID)		
				document.getElementById("itemwizard_cbocategories").options[loop1].text = textcatname;		
		}
  	}
} 

function handleCategoryStatusM() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  	
			alert(xmlHttp.responseText);	
			closeCategoryWindow();
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
				document.getElementById("itemwizard_cbocategories").innerHTML+=xmlHttp.responseText;
				document.getElementById("itemwizard_cboAvailable").innerHTML="";
				var tableText = "<TABLE id=\"tblOptions\">";
				 tableText += "<tr><td>No Properties available</td></tr>";
				 tableText += "</TABLE>";
				 document.getElementById("itemwizard_cboAvailable").innerHTML=tableText;
				alert("Sub Category is added.");
				closeCategoryWindow();
			}
	 	}
	}
}
	

//Save Property
function saveAndAssign()
{     
	if (document.getElementById("itemwizard_cboMainCategories").value == "" || document.getElementById("itemwizard_cboMainCategories").value == null)
	{
		alert("Please select the Main Category.");
		document.getElementById("itemwizard_cboMainCategories").focus();				
		return;
	}	
	else if (document.getElementById("itemwizard_cbocategories").value == "" || document.getElementById("itemwizard_cbocategories").value == null)
	{
		document.getElementById("itemwizard_cbocategories").focus();
		alert("Please select the Sub Category.");		
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
	for(var loop1 = 0; loop1 < document.getElementById("itemwizard_cboAvailable").options.length; loop1 ++)
	{
		if(document.getElementById("itemwizard_cboAvailable").options[loop1].text==tmptext)						
		{	
			flag=false;	
			document.getElementById("itemwizard_txtassign").focus();
			alert("Property, \""+document.getElementById("itemwizard_txtassign").value+"\" is already assigned.")
		}		
	}
	
	if(flag)
	{
        xmlHttp=GetXmlHttpObject();
		
        var url="server.php";
		url=url+"?q=Savepro";
	
		url=url+"&strPropertyName="+URLEncode(document.getElementById("itemwizard_txtassign").value);
		var subCatID = document.getElementById("itemwizard_cbocategories").value;
				
		if(document.getElementById("itemwizard_chkassign").checked==true)
			assign=1;
		else
			assign=0;
		
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
/*	if(subcatid.trim()=="")
	{
		document.getElementById("imgP").src="../../images/addmark.png";
	}
	else
	{
		document.getElementById("imgP").src="../../images/edit.png";
	}*/
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
			try
			{
				RemoveAvailableProperties();
				var XMLPropertyId = xmlHttp.responseXML.getElementsByTagName("PropertyId");
				var XMLPropertyName = xmlHttp.responseXML.getElementsByTagName("PropertyName");
				
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
				 }			
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

function getSubCatID()
{
	if(document.getElementById('itemwizard_cboMainCategories').value=="")
	{
		alert ("Please select the Main Category.");
		document.getElementById('itemwizard_cboMainCategories').focus();
		return;
	}
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
		showCategoryForm(CatID,CatCode,CatName,Display,Inspection);	
	}
}

function showCategoryForm1(a)
{
	
	var htmlText = "<table width=\"500\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\" bgcolor=\"#FFFFFF\">"+
					 "<tr>"+						
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
							  "<td><input maxlength=\"50\"  tabindex=\"22\" name=\"txtcatname\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=generalCategories&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtcatname\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Display </td>"+
				"<td ><input tabindex=\"23\" type=\"checkbox\" name=\"chkdisplay\" id=\"chkdisplay\" /></td>"+
								  "<tr><td class=\"normalfnt\">Inspection</td>"+
								  "<td class=\"normalfnt\"><input tabindex=\"24\" type=\"checkbox\" name=\"chkinspection\" id=\"chkinspection\" /></td></tr>"+
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
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";	
	 var popupbox = document.createElement("div");
     popupbox.id = "catview";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 388 + 'px';
     popupbox.style.top = 160+ 'px'; 
	 popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
	document.getElementById("txtcatname").focus();
}

function showCategoryForm(CatID,CatCode,CatName,Display,Inspection,AdditionalAllowed)
{
	
	var htmlText = "<table width=\"500\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\" bgcolor=\"#FFFFFF\">"+
					 "<tr>"+						
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
							  "<td><input maxlength=\"50\"  tabindex=\"12\" name=\"txtcatname\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=generalCategories&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtcatname\" value=\""+CatName+"\" /></td>"+
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
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";	
	 var popupbox = document.createElement("div");
     popupbox.id = "catview";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 388 + 'px';
     popupbox.style.top = 160+ 'px'; 
	 popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);	
}

//Strat - Main Category PopUp Changes
function ShowMainCategorryForm()
{
	var mainId = document.getElementById("itemwizard_cboMainCategories").value;
	if(mainId==null||mainId=="")
	{	
		var catId 	= 0;
		var catCode = "";
		var catName = "";
		var excess 	= 0;
		ShowMainCategoryForm(catId,catCode,catName,excess,"S");
	}
	else
	{
		var urlDetails="wizardmiddle.php?str=GetMainCategory&mainCat="+mainId;	
		htmlobj		= $.ajax({url:urlDetails,async:false});
		var catId	= mainId;
		var catCode	= htmlobj.responseXML.getElementsByTagName("CatCode")[0].childNodes[0].nodeValue;
		var catName	= htmlobj.responseXML.getElementsByTagName("CatName")[0].childNodes[0].nodeValue;
		var excess	= htmlobj.responseXML.getElementsByTagName("AllowEx")[0].childNodes[0].nodeValue;
		ShowMainCategoryForm(catId,catCode,catName,excess,"U");	
	}
}

function ShowMainCategoryForm(CatID,CatCode,CatName,excess,category)
{
	var htmlText = "<table width=\"500\" border=\"0\" align=\"center\">"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\"  bgcolor=\"#FFFFFF\">"+
					 "<tr>"+						
						"<td width=\"30%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
						  "<table width=\"100%\" class=\"bcgl2Lbl\">"+
							"<tr>"+
							  "<td height=\"16\" colspan=\"2\"  class=\"mainHeading\"><table width=\"100%\" border=\"0\" >"+
								"<tr>"+
								  "<td width=\"93%\">Main Category</td>"+
								  "<td width=\"7%\"><img src=\"../../images/cross.png\" class=\"mouseover\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"CloseMainStorePopup();\" /></td>"+
								"</tr>"+
							  "</table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"7\" colspan=\"2\">&nbsp;</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" class=\"normalfnt\">Main Category Code&nbsp;<span class=\"compulsoryRed\">*</span></td><td width=\"61%\"><input maxlength=\"20\""+"tabindex=\"11\" name=\"txtcatcode\" type=\"text\" class=\"txtbox\" id=\"txtcatcode\" value=\""+CatCode+"\" /></td></tr><tr>"+
							  "<td width=\"39%\" height=\"1\" class=\"normalfnt\">Main Category Name&nbsp;<span class=\"compulsoryRed\">*</span></td>"+
							  "<td><input maxlength=\"50\"  tabindex=\"12\" name=\"txtcatname\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=GeneralMainCategories&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtcatname\" value=\""+CatName+"\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Allow GRN Excess</td>"+
				"<td ><input tabindex=\"13\" type=\"checkbox\" name=\"chkExAllow\" id=\"chkExAllow\"";
				if(excess==1)htmlText+="checked=\"checked\"";
				htmlText+="/></td></tr>"+
							"<tr><td height=\"21\" colspan=\"2\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td >"+
								  "<div align=\"center\">"+
								  "<img src=\"../../images/new.png\" alt=\"New\" name=\"New\" onclick=\"GenMainCatNew();\" class=\"mouseover\" />"+
								  "<img src=\"../../images/save.png\" class=\"mouseover\" alt=\"Save\" width=\"95\" height=\"24\" onClick=\"SaveMainCategory("+CatID+",'"+category+"');\" />";
								  if(document.getElementById('itemwizard_cboMainCategories').value!="")
								  {
								  htmlText+="<img src=\"../../images/delete.png\" alt=\"Delete\" id=\"butDelete\" name=\"Delete\" onclick=\"DeleteMainCategory("+CatID+");\" class=\"mouseover\" />";
								  }
								  htmlText+="<img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" border=\"0\" class=\"mouseover\" onClick=\"CloseMainStorePopup();\" />"+
								  "</div>"+
								  "</td>"+								  
								"</tr>"+
							 "</table></td>"+
							"</tr>"+
						  "</table>"+
								"</form>"+
						"</td>"+						
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				"</table>";	
	 var popupbox = document.createElement("div");
     popupbox.id = "catview";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 390 + 'px';
     popupbox.style.top = 165+ 'px'; 
	 popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
}

function GenMainCatNew()
{
	document.getElementById('txtcatcode').value = "";
	document.getElementById('txtcatname').value = "";
	document.getElementById('chkExAllow').checked = false;
}
function CloseMainStorePopup()
{
	loadCombo( 'select intID,strDescription from genmatmaincategory where status=1 order by strDescription','itemwizard_cboMainCategories');
	document.getElementById("itemwizard_cboMainCategories").focus();
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

function DeleteMainCategory(ID)
{
	var CatName = document.getElementById('txtcatname').value;

	if(confirm("Are you sure you want to delete the Mian Category , \""+CatName+"\" ?"))
	{
		
		var urlDetails="server.php?q=DeleteMainCategory&MainCatID="+ID;	
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		CloseMainStorePopup();
	}
}
//End - Main Category PopUp Changes

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

function LoadAvailableUnits()
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleUnits;
    xmlHttp.open("GET", 'wizardmiddle.php?str=GetUnits', true);
    xmlHttp.send(null); 
}

function HandleUnits()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("unit");

			  document.getElementById("cboUnits").innerHTML =  XMLName[0].childNodes[0].nodeValue
			  document.getElementById("cboPurchaseUnit").innerHTML =  XMLName[0].childNodes[0].nodeValue
		}
	}
}
function LoadCurrency()
{
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleCurrency;
    xmlHttp.open("GET", 'wizardmiddle.php?str=GetCurrency', true);
    xmlHttp.send(null); 
}

function HandleCurrency()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var XMLName = xmlHttp.responseXML.getElementsByTagName("currencyTypes");

			  document.getElementById("cboCurrency").innerHTML =  XMLName[0].childNodes[0].nodeValue
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
	document.getElementById("div"+ID).innerHTML="&nbsp;<input name=\""+ID+"\"id=\""+ID+"\" height=\"25\" style=\"width:250px\" value=\""+str+"\" type=\"text\" class=\"txtboxRightAllign\" maxlength=\"50\" />&nbsp;&nbsp;<img src=\"../../images/disk.png\" width=\"15\" alt=\"Save\" height=\"15\" onclick=\"saveProperty("+ID+");\" />";
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
		alert("Please enter the new Property Name.");		
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
	
	var urlDetails="propertyValueModifyDB.php?q=Save&intSubPropertyNo="+ID+"&strSubPropertyName="+document.getElementById(ID).value;
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

function LoadSubCategory(obj)
{
	var sql = "SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intStatus = 1 AND intCatNo = "+obj+" ORDER BY StrCatName";
	loadCombo(sql,'itemwizard_cbocategories');
}

//Start - Assign property value to property
function ShowNameCreationWindow()
{	
	if(!InterfaceValidation("itemwizard_cboMainCategories","Please select the Main Category."))
		return;
	if(!InterfaceValidation("itemwizard_cbocategories","Please select the Sub Category."))
		return;	
	
	drawPopupArea(600,375,'frmNameCreator');
	var HTMLText = "<table  width=\"600\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\" cellpadding=\"1\" cellspacing=\"0\">"+
				  "<tr>"+					
				  "</tr>"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\">"+
					  "<tr>"+						
						"<td width=\"48%\"><form id=\"frmmaterial3\" name=\"frmmaterial3\" method=\"post\" action=\"\">"+
						  "<table width=\"100%\" border=\"0\">"+
							"<tr>"+
							  "<td height=\"24\" colspan=\"4\" class=\"mainHeading\"><table width=\"100%\" border=\"0\"><tr><td width=\"95%\">Assign Properties</td><td><img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeWindow();\" class=\"mouseover\" /></td></tr></table></td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"3\" colspan=\"4\"><div id=\"divcons\" style=\"overflow:scroll; height:172px; width:100%;\">"+
								"<table id=\"tblValues\" width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								  "<tr class=\"mainHeading4\">"+
									"<th colspan=\"2\" height=\"25\" width=\"22%\" >Property Name</th>"+
									"<th width=\"22%\" >Property Value</th>"+
									"<th width=\"5%\"  >Display?</th>"+
									"<th width=\"25%\" >Display Str</th>"+
									"<th width=\"17%\" >Place</th>"+
									"<th width=\"5%\" >Serial</th>"+
								  "</tr>";
								  
								  
						
						for (var i = 0 ; i < document.getElementById("itemwizard_cboAvailable").options.length ; i++)
						{
							var text = document.getElementById("itemwizard_cboAvailable").options[i].text;
							var value = document.getElementById("itemwizard_cboAvailable").options[i].value;
						
							HTMLText += "<tr class=\"bcgcolor-tblrowWhite\">"+
										"<td colspan=\"2\" class=\"normalfnt\" id=\"" +  value + "\">" + text + "</td>"+
										"<td class=\"normalfnt\"><table width=\"93%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
										  "<tr>"+
											"<td width=\"79%\"><select name=\"CBOadd\" class=\"txtbox\" id=\"CBOadd\" style=\"width:100px\">"+
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
							  "<td width=\"75\" height=\"3\" class=\"normalfnt\">Unit</td>"+
							  "<td width=\"180\"><select name=\"cboUnits\" class=\"txtbox\" id=\"cboUnits\" style=\"width:90px\" tabindex=\"4\">"+
							  "</select></td>"+
							  "<td width=\"100\" class=\"normalfnt\">Wastage</td>"+
							  "<td width=\"100\"><input name=\"txtWastage\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  type=\"text\" id=\"txtWastage\" maxlength=\"11\" size=\"13\" tabindex=\"5\" /></td>"+
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Purchase Unit</td>"+
							  "<td ><select name=\"cboPurchaseUnit\" id=\"cboPurchaseUnit\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+
							  "<td class=\"normalfnt\">Unit Price</td>"+
							  "<td ><input name=\"txtUnitPrice\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  type=\"text\" id=\"txtUnitPrice\" maxlength=\"11\" size=\"13\" tabindex=\"7\" /></td>"+							  
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Product Post In Group</td>"+
							  "<td ><select name=\"cboProductPostInGroup\" id=\"cboProductPostInGroup\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+
							  "<td class=\"normalfnt\">Currency</td>"+
							  "<td ><select name=\"cboCurrency\" id=\"cboCurrency\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+							  
							"</tr>"+
							"<tr>"+
							  "<td class=\"normalfnt\">Invent Post In Group</td>"+
							  "<td ><select name=\"cboInventPostInGroup\" id=\"cboInventPostInGroup\" style=\"width:90px\" tabindex=\"6\" class=\"txtbox\" /></select></td>"+
							  "<td class=\"normalfnt\">Navision Code</td>"+
							  "<td ><input name=\"txtNavisionCode\"   type=\"text\" id=\"txtNavisionCode\" maxlength=\"11\" size=\"13\" tabindex=\"5\" /></td>"+							  
							"</tr>"+
							"<tr>"+
							 "<td class=\"normalfnt\">Reorder Level</td>"+
							  "<td ><input name=\"txtReLevel\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  type=\"text\" id=\"txtReLevel\" maxlength=\"10\" style=\"width:90px;text-align:right\" tabindex=\"7\" value=\""+0+"\" /></td>"+
							  "<td class=\"normalfnt\">&nbsp;</td>"+
							  "<td >&nbsp;</td>"+	
							"</tr>"+
							"<tr>"+
							  "<td height=\"21\" colspan=\"4\" class=\"mbari13\"><table width=\"100%\" border=\"0\">"+
								"<tr>"+
								  "<td width=\"33%\">"+
								  "<div align=\"center\">"+
								  "<img src=\"../../images/finish.png\" alt=\"save\" width=\"96\" height=\"24\" class=\"mouseover\" onClick=\"Savenfinish();\" />"+
								  "<img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" class=\"mouseover\" onClick=\"closeWindow();\" /></div></td>"+
								"</tr>"+
							 " </table></td>"+
							"</tr>"+
						  "</table>"+
								"</form>"+
						"</td>"+						
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
				  "<tr>"+					
				  "</tr>"+
				"</table>";

	document.getElementById('frmNameCreator').innerHTML=HTMLText;
	LoadAvailableUnits();
	//LoadCurrency();
	loadCombo("SELECT intId,strName from genprodpostinggroup order by strName",'cboProductPostInGroup');
	loadCombo("SELECT intId,strName from inventpostinggroup order by strName",'cboInventPostInGroup');
	loadCombo("SELECT currencytypes.strCurrency,currencytypes.strTitle FROM currencytypes WHERE (((currencytypes.intStatus)=1))",'cboCurrency');
}

function HandlePropertyRequest()
{	
	if(xmlHttpreq[this.index].readyState == 4 && xmlHttpreq[this.index].status == 200) 
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
	}	
}

function InterfaceValidation(propertyName,message)
{
	if (document.getElementById(propertyName).value == "" || document.getElementById(propertyName).value == null)
	{
		document.getElementById(propertyName).focus();
		alert(message);
		return false;
	}
	return true;
}

function ShowNewValueForm(obj)
{
	var propertyName = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
	var propValue = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.cells[0].id;
	//alert(propertyName);
	
	var rowIndex = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.rowIndex;
	drawPopupAreaLayer(300,360,'frmValueSelecter',14);
	var HTMLText = "<table width=\"280\" border=\"0\" align=\"center\" >"+
				  "<tr>"+
					"<td height=\"139\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+						
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
							  "<td height=\"7\" colspan=\"2\">&nbsp;</td>"+
							"</tr>"+
							"<tr>"+
							  "<td width=\"39%\" height=\"0\" valign=\"top\" class=\"normalfnt\">Property</td>"+
							  "<td width=\"61%\" valign=\"top\" class=\"normalfnt\">" + propertyName + "</td>"+
							"</tr>"+
							"<tr>"+
							  "<td height=\"0\" colspan=\"2\" class=\"normalfnt\">&nbsp;</td>"+
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
									  "<td width=\"58%\"><input maxlength=\"50\" tabindex=\"101\" name=\"txtNewValue\" onclick=\"closeList();\" onkeydown=\"ItemListKeyEventHandler(event);\" onkeyup=\"GetAutoComplete(event,this.value,'../../autofill.php?RequestType=GeneralPropertyValues&',this.id);\" type=\"text\" class=\"txtbox\" id=\"txtNewValue\" size=\"20\" /></td>"+
									  "<td width=\"26%\" align=\"right\"><input checked=\"checked\" tabindex=\"102\" align=\"right\" type=\"checkbox\" name=\"chkassignvalue\" id=\"chkassignvalue\" /></td>"+
									  "<td width=\"16%\" class=\"normalfnt\">Assign</td>"+
									"</tr>"+
									"<tr>"+
									  "<td colspan=\"3\" class=\"mbari13\">"+
									  "<div align=\"right\">"+
									  "<img tabindex=\"103\" src=\"../../images/addsmall.png\" id=\"butSave\" onClick=\"SaveValue(" + propValue + "," +rowIndex + ");\" alt=\"add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
									"</tr>"+
								  "</table></td>"+
								  "</tr>"+
							  "</table></td>"+
							"</tr>"+							
						  "</table>"+
						"</td>"+
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
		}
	}	
}

function SaveValue(propID,rowIndex)
{    
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
    if(xmlHttp.readyState == 4 && xmlHttp.status == 200) 
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
			document.getElementById("cboValues").options.add(opt);
			if(document.getElementById("chkassignvalue").checked==true)
			{
				var tblValues = document.getElementById("tblValues");
				var cbo = tblValues.rows[xmlHttp.rowIndex].cells[1].childNodes[0].rows[0].cells[0].childNodes[0];
				var opt = document.createElement("option");
				opt.text = document.getElementById("txtNewValue").value;
				opt.value = document.getElementById("txtNewValue").title;
				cbo.options.add(opt);
				cbo.selectedIndex= cbo.options.length-1;
				closeLayer();
			}				
		}
	}
}
//End - Assign property value to property


//Start - Save Finish

function Savenfinish()
{   
	if (!isDuplicateSelections())
	{
		return ;	
	}
	var mainCatID = document.getElementById('itemwizard_cboMainCategories').value;
	var subCatID = document.getElementById("itemwizard_cbocategories").value;
	var tbl = document.getElementById('tblValues');
	//var CatCodes = ["FA", "AC", "PA","SE","OT"];
	var CatCodes = document.getElementById("itemwizard_cboMainCategories").options[document.getElementById("itemwizard_cboMainCategories").selectedIndex].text;
	var ItemCode = CatCodes + "_" + subCatID + ",";
	var displayCode = CatCodes + "_" + subCatID + "#";
	var propIDlist=",";
	var propValueIdList =",";
	var displayStrList = "";
	var strBeforeAfterList = "";
	var serialList = "";
	var ItemName = "";
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var PropID = tbl.rows[loop].cells[0].id;
		var propValue = tbl.rows[loop].cells[1].childNodes[0].rows[0].cells[0].childNodes[0].value;
	
		var displayStr = tbl.rows[loop].cells[3].childNodes[0].value;
		var strBeforeAfter = tbl.rows[loop].cells[4].childNodes[0].value;
		if(strBeforeAfter == 'Before'){
			strBeforeAfter = 1;
		}
		
	  	if(strBeforeAfter == 'After'){
			strBeforeAfter = 2;
		}

		var serial = tbl.rows[loop].cells[5].childNodes[0].lastChild.value;
	
		ItemCode += PropID + "." + propValue + ",";
		displayCode += PropID + "." + propValue + "#";
		propIDlist+=PropID+",";
		propValueIdList+=propValue+",";
		
		displayStrList+=displayStr+",";
		strBeforeAfterList+=strBeforeAfter+",";
		serialList+=serial+",";	
	}
	
	var intDisplayStatus = parseInt(GetMaterialDisplayStatus(subCatID));
	
	if(intDisplayStatus == 1)
		ItemName = document.getElementById("itemwizard_cbocategories").options[document.getElementById("itemwizard_cbocategories").selectedIndex].text;
	
/*	if (mainCatID == 1)
	{
		if(document.getElementById("itemwizard_cboFabricContent").options[document.getElementById("itemwizard_cboFabricContent").selectedIndex].text != "");
		ItemName += " " + document.getElementById("itemwizard_cboFabricContent").options[document.getElementById("itemwizard_cboFabricContent").selectedIndex].text ;
	}*/
	
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
	var reorderLevel 	= document.getElementById("txtReLevel").value;
	var wastage = document.getElementById("txtWastage").value;
	var unitPrice = document.getElementById("txtUnitPrice").value;
	var unitID = document.getElementById("cboUnits").options[document.getElementById('cboUnits').selectedIndex].text;
	var purchaseID = document.getElementById("cboPurchaseUnit").options[document.getElementById('cboPurchaseUnit').selectedIndex].text;
	var MainCateID = mainCatID;
	var subCatID = document.getElementById("itemwizard_cbocategories").value;
	
	var cboProductPostInGroup = document.getElementById("cboProductPostInGroup").value;
	var cboInventPostInGroup = document.getElementById("cboInventPostInGroup").value;
	
	// sumith harshan	2011-05-30
	var cboCurrency 	= document.getElementById("cboCurrency").value;
	var navisionCode = document.getElementById("txtNavisionCode").value;
	if(trim(navisionCode)=='')
	{
		alert('Please enter Navision Code');
		document.getElementById("txtNavisionCode").focus();
		return;	
	}
	
	if(confirm("The new item name will be as follows\n\n" + ItemName + "\n\nDo you wan't to continue with this."))
	{
		createXMLHttpRequest();	
    	xmlHttp.onreadystatechange = HandleMaterialSaving;
    	xmlHttp.open("GET", 'wizardmiddle.php?str=SaveMaterial&ItemCode=' + URLEncode(ItemCode) + '&ItemName=' + URLEncode(ItemName) + '&MainCatID=' + MainCateID + '&subCatID=' + subCatID+'&propValueIdList='+propValueIdList+'&propIDlist='+propIDlist+ '&Wastage=' + wastage + '&unitID=' + unitID + '&purchaseID=' + purchaseID + '&serialList=' + serialList + '&strBeforeAfterList=' + strBeforeAfterList + '&displayStrList=' + displayStrList +   '&unitPrice=' + unitPrice+'&cboProductPostInGroup='+cboProductPostInGroup+'&cboInventPostInGroup='+cboInventPostInGroup+"&cboCurrency="+cboCurrency+"&navisionCode="+navisionCode+"&reorderLevel="+reorderLevel, true);
   	xmlHttp.send(null);
   }  
}

function GetMaterialDisplayStatus(prmSubCatCode){
	
	
	var urlDetails="wizardmiddle.php?str=subCategoryID&subCat="+prmSubCatCode;	
	htmlobj=$.ajax({url:urlDetails,async:false});
	
	var intDisplay = htmlobj.responseXML.getElementsByTagName("Display")[0].childNodes[0].nodeValue;
	
	return intDisplay;
	
	
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
				alert(message);
			else
				alert(message);
		}	
 	}       
}
//End - Save Finish