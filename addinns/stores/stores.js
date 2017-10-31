var xmlHttp;
var multixmlHttp = [];
var pub_binID = '';
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

function validateMainStores(obj,controlName)
{
	if(obj=='1')
	{
		if(document.getElementById('txtStoreName').value.trim() == "")
		{
			alert("Please enter '"+controlName+"'.");
			document.getElementById('txtStoreName').select();
			return false;		
		}
		else if(isNumeric(document.getElementById('txtStoreName').value)){
			alert("Store Name must be an \"Alfanumeric\" value.");
			document.getElementById('txtStoreName').select();
			return;
		}
		if(document.getElementById('cboFactory').value.trim() == "")
		{
			alert("Please select the 'Company'.");
			document.getElementById('cboFactory').focus();
			return false;		
		}
	}
	else
	{
		if(document.getElementById('txtStoreName').value.trim() == "")
		{
			alert("Please enter '"+controlName+"'.");
			document.getElementById('txtStoreName').select();
			return false;		
		}
		else if(isNumeric(document.getElementById('txtStoreName').value)){
			alert("Store Name must be an \"Alfanumeric\" value.");
			document.getElementById('txtStoreName').select();
			return;
		}
	}
	
	return true;
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
		// alert(1);
	}	
}

function ValidateStoresBeforeSave(obj)
{
	if(obj=='1')
	{
		var x_id 	= document.getElementById("cboSearch").value;
		var x_name 	= document.getElementById("txtStoreName").value;
		
		var x_find 	= checkInField('mainstores','strName',x_name,'strMainID',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("txtStoreName").select();
			return false;
		}
		else if((document.getElementById('chkAutoBin').checked == true) && (document.getElementById('txtVirSubStore').value.trim() == ""))
		{
				alert("Please enter the Auto Bin Name.");	
				document.getElementById("txtVirSubStore").select();
				return false;
		}
		
	}
	else if(obj=='2')
	{
		var x_id 	= document.getElementById("cboSearch").value;
		var x_name 	= document.getElementById("txtStoreName").value;
		
		var x_find 	= checkInField('substores','strSubStoresName',x_name,'strSubID',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("txtStoreName").select();
			return false;
		}
	}
		else if(obj=='2')
	{
		var x_id 	= document.getElementById("cboSearch").value;
		var x_name 	= document.getElementById("txtStoreName").value;
		
		var x_find 	= checkInField('substores','strSubStoresName',x_name,'strSubID',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("txtStoreName").select();
			return false;
		}
	}
	else if(obj=='3')
	{
		var x_id 	= document.getElementById("cboSearch").value;
		var x_name 	= document.getElementById("txtStoreName").value;
		
		var x_find 	= checkInField('storeslocations','strLocName',x_name,'strLocID',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("txtStoreName").select();
			return false;
		}
	}
	else if(obj=='4')
	{
		var x_id 	= document.getElementById("cboSearch").value;
		var x_name 	= document.getElementById("txtStoreName").value;
		
		var x_find 	= checkInField('storesbins','strBinName',x_name,'strBinID',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("txtStoreName").select();
			return false;
		}
	}
	
return true;
}

function SaveMainStores()
{
	if(!validateMainStores(1,"Main Store"))
		return

if(!ValidateStoresBeforeSave(1))	
		return;
		
	
		var storesName 	= trim(document.getElementById('txtStoreName').value);
		var virtualStore 	= trim(document.getElementById('txtVirSubStore').value);
		var remarks 	= trim(document.getElementById('txtRemarks').value);
		var compID 		= document.getElementById('cboFactory').value;
		var active 		= (document.getElementById('chkMainActive').checked==true ? 1:0);
		var autoBin 	= (document.getElementById('chkAutoBin').checked==true ? 1:0);
		var commonBin 	= (document.getElementById('chkCommonBin').checked==true ? 1:0);
			//	alert(autoBin);
		var Search 	 	= document.getElementById('cboSearch').value;
		
		

		if(trim(document.getElementById('cboSearch').value)=="")
			var category = "Save";
		else
			var category = "Update";
			
	//		alert(category);
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = SaveStoresResponse;
		xmlHttp.index = '1';
    	xmlHttp.open("GET", 'storesMiddleTire.php?Request=SaveMainStores&storesName=' + storesName + '&virtualStore=' + virtualStore  + '&remarks=' + remarks + '&compID=' + compID + '&active=' +active+ '&autoBin=' +autoBin+ '&commonBin=' +commonBin+ '&category=' +category+ '&Search=' +Search, true);
    	xmlHttp.send(null);
}
//
function SaveStoresResponse()
{
	if(xmlHttp.readyState == 4 &&  xmlHttp.status == 200)
	{	
	
	var company=trim(document.getElementById('cboFactory').value);
		
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		RemoveAllRows('tblMainStores');
		ClearForm(xmlHttp.index);
		
		var XMLPage 		= xmlHttp.responseXML.getElementsByTagName("page");
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
			var page 		= XMLPage[0].childNodes[0].nodeValue;
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateGrid(id,name,remarks,loop);

		}	
		if(page==1){
			loadCombo('SELECT strMainID,strName FROM mainstores where mainstores.intCompanyId =  '+company+' AND intAutomateCompany <>1 AND intStatus<>10 order by strName;','cboSearch');
		}
		else if(page==2){
			loadCombo('SELECT strSubID,strSubStoresName,substores.strRemarks,substores.intStatus, substores. strMainID FROM substores join mainstores on mainstores.strMainID=substores.strMainID  WHERE substores. strMainID =  '+mainStore+' and mainstores.intCompanyId =  '+company+' and substores.intStatus<>10 order by strSubStoresName;','cboSearch');
		}
		else if(page==3){
			loadCombo('select strLocID,strLocName  FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '+mainStore+' AND storeslocations.strSubID = '+substore+' and  mainstores.intCompanyId  =  '+company+' and storeslocations.intStatus<>10 order By strLocName;','cboSearch');
		}
		
	}
}
function SaveStoresBinResponse()
{
	if(xmlHttp.readyState == 4 &&  xmlHttp.status == 200)
	{	
	
	var company=trim(document.getElementById('cboFactory').value);
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		RemoveAllRows('tblMainStores');
		ClearForm(xmlHttp.index);
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateBinGrid(id,name,remarks,loop);
		}	
//		alert('SELECT strBinID,strBinName,storesbins.strRemarks,storesbins.intStatus FROM storesbins join mainstores on mainstores.strMainID=storesbins.strMainID WHERE storesbins.strMainID = '+mainStore+' AND storesbins.strSubID = '+substore+' AND storesbins.strLocID = '+locationID+' and  mainstores.intCompanyId  =  '+company+' and storesbins.intStatus<>10 order by storesbins.strBinName');
			loadCombo('SELECT strBinID,strBinName,storesbins.strRemarks,storesbins.intStatus FROM storesbins join mainstores on mainstores.strMainID=storesbins.strMainID WHERE storesbins.strMainID = '+mainStore+' AND storesbins.strSubID = '+substore+' AND storesbins.strLocID = '+locationID+' and  mainstores.intCompanyId  =  '+company+' and storesbins.intStatus<>10 order by storesbins.strBinName;','cboSearch');
	}
}

function CreateGrid(id,name,remarks,loop)
{
//	alert(loop);
	var tbl = document.getElementById('tblMainStores');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	//alert(lastRow);
	
		row.className = "bcgcolor-tblrow";
	if ((loop % 2) == 1)
		row.className = "bcgcolor-tblrowWhite";
		
	var cellIssuelist = row.insertCell(0);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML ="<input name=\"radiobutton\" id=\"" + id + "\" type=\"radio\" value=\"radiobutton\" />";
	
	var cellIssuelist = row.insertCell(1);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML =name;
	
	var cellIssuelist = row.insertCell(2);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML =remarks;
}

function CreateBinGrid(id,name,remarks,loop)
{						
	var tbl = document.getElementById('tblMainStores');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	
		row.className = "bcgcolor-tblrow";
	if ((loop % 2) == 1)
		row.className = "bcgcolor-tblrowWhite";
		
	var cellIssuelist = row.insertCell(0);
	cellIssuelist.className ="normalfnt";
	if(commonBin==1)
	cellIssuelist.innerHTML ="<input name=\"radiobutton\" id=\"" + id + "\" type=\"radio\" value=\"radiobutton\" />";
	else
	cellIssuelist.innerHTML ="<img src=\"../../images/manage.png\" id=\"" + id + "\" alt=\"" + name + "\"  onClick=\"showManageBinForm(this);\" class=\"mouseover\">";
	
	var cellIssuelist = row.insertCell(1);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML =name;
	
	var cellIssuelist = row.insertCell(2);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML =remarks;
}
//
function handleStoresSaving()
{
	 if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 
        		if(xmlHttp.responseText == "-2")
        		{
        			alert("The " + messageString + document.getElementById('txtStoreName').value + " is already exists.");
        			document.getElementById('txtStoreName').focus();
        		}
				else if(xmlHttp.responseText == "-5")
				{
					alert("Updated successfully.");
					document.getElementById('txtStoreName').focus();
				}
        		else
        		{
        			alert("The " + messageString + document.getElementById('txtStoreName').value + " added.");
        			var tbl = document.getElementById('tblMainStores');
        			var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
					if ((tbl.rows.length % 2) == 0)
					{
						row.className="bcgcolor-tblrow";
					}
					else
					{
						row.className="bcgcolor-tblrowWhite";		
					}
					
					var rowText = "";
					if (messageString == "bin ")
					{
						rowText = "<td>" +
            					"<img src=\"../../images/manage.png\" id=\"" + xmlHttp.responseText + "\" alt=\"" + document.getElementById('txtStoreName').value + "\"  onClick=\"showManageBinForm(this);\" class=\"mouseover\">"+
         						"</td>"+
          						"<td class=\"normalfnt\">" + document.getElementById('txtStoreName').value + "</td>" +
          						"<td class=\"normalfnt\">" + document.getElementById('txtRemarks').value + "</td>";
          			
					}
					else
					{
						rowText = "<td>" +
            					"<input name=\"radiobutton\" id=\"" + xmlHttp.responseText + "\" type=\"radio\" value=\"radiobutton\" />"+
         						"</td>"+
          						"<td class=\"normalfnt\">" + document.getElementById('txtStoreName').value + "</td>" +
          						"<td class=\"normalfnt\">" + document.getElementById('txtRemarks').value + "</td>";
          							
					}
					
        			row.innerHTML = rowText;
				}
        }
    }
}

function ltrim(str) { 
	for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
	return str.substring(k, str.length);
}

function rtrim(str) {
	for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;
	return str.substring(0,j+1);
}

function trim(str) {
	return ltrim(rtrim(str));
}

function isWhitespace(charToCheck) {
	var whitespaceChars = " \t\n\r\f";
	return (whitespaceChars.indexOf(charToCheck) != -1);
}

function goToURL(url)
{
	var tbl = document.getElementById('tblMainStores');
	var mainID = "";
	for (var loop = 1 ; loop < tbl.rows.length ; loop ++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			mainID = tbl.rows[loop].cells[0].childNodes[0].id;
			break;
		}
	}
	
	if(mainID == "")
	{
		alert("Please select a " + messageString + ".");
		return;
	}
	location = url + mainID;
}

function SaveSubStores()
{
	if(!validateMainStores(0,"Sub Store"))
		return;

	if(!ValidateStoresBeforeSave(2))	
		return;
			
		var storesName 	= trim(document.getElementById('txtStoreName').value);
		var remarks 	= trim(document.getElementById('txtRemarks').value);
		var active 		= (document.getElementById('chkSubActive').checked==true ? 1:0);
		
		var Search 	 	= document.getElementById('cboSearch').value;
		
		if(trim(document.getElementById('cboSearch').value)=="")
			var category = "Save";
		else
			var category = "Update";
			
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = SaveStoresResponse;
		xmlHttp.index = '2';
		xmlHttp.open("GET", 'storesMiddleTire.php?Request=SaveSubStores&storesName=' + storesName + '&remarks=' + remarks + '&mainStore=' + mainStore + '&virtualMainStore=' + virtualMainStore + '&active=' +active+ '&category=' +category+ '&Search=' +Search , true);
		xmlHttp.send(null);
}

function SaveLocation()
{
	if(!validateMainStores(0,"Location Name"))
		return;
	if(!ValidateStoresBeforeSave(3))	
		return;
		
	var storesName 	= trim(document.getElementById('txtStoreName').value);
	var remarks 	= trim(document.getElementById('txtRemarks').value);	
	var active 		= (document.getElementById('chkSubActive').checked==true ? 1:0);
	var Search 	 	= document.getElementById('cboSearch').value;
		
	if(trim(document.getElementById('cboSearch').value)=="")
		var category = "Save";
	else
		var category = "Update";
			
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = SaveStoresResponse;
	xmlHttp.index = '3';
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=SaveLocation&storesName=' + storesName + '&remarks=' + remarks + '&mainStore=' + mainStore+ '&virtualMainStore=' + virtualMainStore + '&subStore=' + substore + '&virtualSubStore=' + virtualSubStore + '&Search=' +Search+ '&category=' +category+ '&active=' +active, true);
	xmlHttp.send(null);
}

function SaveBin()
{
	if(!validateMainStores(0,"Bin Name"))
		return;
	if(!ValidateStoresBeforeSave(4))	
		return;
		
		var storesName 	= trim(document.getElementById('txtStoreName').value);
		var remarks 	= trim(document.getElementById('txtRemarks').value);
		var Search 	 	= document.getElementById('cboSearch').value;
		var active 		= (document.getElementById('chkSubActive').checked==true ? 1:0);
		if(trim(document.getElementById('cboSearch').value)=="")
			var category = "Save";
		else
			var category = "Update";
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = SaveStoresBinResponse;
		xmlHttp.index = '4';
    	xmlHttp.open("GET", 'storesMiddleTire.php?Request=BinLocation&storesName=' + storesName + '&remarks=' + remarks + '&mainStore=' + mainStore + '&virtualMainStore=' + virtualMainStore + '&subStore=' + substore + '&virtualSubStore=' + virtualSubStore + '&locationID=' + locationID + '&virtualLocation=' + virtualLocation + '&active=' +active+ '&category=' +category+ '&Search=' +Search , true);
    	xmlHttp.send(null);
}

function showManageBinForm(obj)
{
	 pub_binID = obj.id;
	 createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleManageBinForm;
    xmlHttp.open("GET", 'manageBin.php?bin=' + obj.id + '&binName=' + URLEncode(obj.alt), true);
    xmlHttp.send(null); 
}

function handleManageBinForm()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			drawPopupArea(715,350,'frmManageBin');
			document.getElementById('frmManageBin').innerHTML=xmlHttp.responseText;
		}
	}
}

function doThis(e)
{
	if (e.keyCode == 13)
	{
		var mainCatId	= document.getElementById('cboMainCategory');
		if(mainCatId.value=='0')
		{
			alert("Please select 'Main Category'.");
			mainCatId.focus();
			return;
		}
		LoadMaterialCategories(pub_binID);
	}
}

function LoadMaterialCategories(binID)
{
	document.getElementById('tblCategories').innerHTML="";
	var matID = document.getElementById('cboMainCategory').value;
	var subCategory	= document.getElementById('txtSubCategory').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleCategories;
//	alert('Request=getCategories&binID=' + binID + '&mainCat=' + matID + '&mainStore=' + mainStore + '&substore=' + substore + '&locationID=' + locationID);
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=getCategories&binID=' + binID + '&mainCat=' + matID + '&mainStore=' + mainStore + '&substore=' + substore + '&locationID=' + locationID + '&SubCategory=' +URLEncode(subCategory), true);
	xmlHttp.send(null);  
}

function HandleCategories()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
				document.getElementById('tblCategories').innerHTML=xmlHttp.responseText;
		  }
	 }
}

var currentBin = "";

function SaveCategoryAllocation(binID)
{
	currentBin = binID;
	if(validateInputs())
	{
		var selectedList = "";
		var tbl = document.getElementById('tblCategories');
		for(var loop = 1 ; loop < tbl.rows.length; loop ++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				tbl.rows[loop].className = "bcgcolor-tblrow";
				selectedList += tbl.rows[loop].cells[0].childNodes[0].id + "," ;
			}
		}
		selectedList = selectedList.substring(0,selectedList.length-1);
		var matID = document.getElementById('cboMainCategory').value;
		createXMLHttpRequest();
    	xmlHttp.onreadystatechange = handleStarting;
    	xmlHttp.open("GET", 'storesMiddleTire.php?Request=removeUnwanted&binID=' + binID + '&mainStore=' + mainStore + '&virtualMainStore=' + virtualMainStore + '&substore=' + substore + '&virtualSubStore=' + virtualSubStore + '&locationID=' + locationID + '&virtualLocation=' + virtualLocation + '&selectedList=' + selectedList + '&matID=' + matID, true);
    	xmlHttp.send(null); 
	}
}

function handleStarting()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
        		var tbl = document.getElementById('tblCategories');
				for(var loop = 1 ; loop < tbl.rows.length; loop ++)
				{
					if(tbl.rows[loop].cells[0].childNodes[0].checked)
					{
						var category = tbl.rows[loop].cells[0].childNodes[0].id;
						var capacity = tbl.rows[loop].cells[3].childNodes[0].value;
						var unit = tbl.rows[loop].cells[2].childNodes[0].value;
						var remarks = tbl.rows[loop].cells[5].childNodes[0].value;
						createNewMultiXMLHttpRequest(loop);
						multixmlHttp[loop].index= loop;
						multixmlHttp[loop].onreadystatechange = handleSavingProcess;
    					multixmlHttp[loop].open("GET", 'storesMiddleTire.php?Request=SaveAllocation&binID=' + currentBin + '&mainStore=' + mainStore + '&virtualMainStore=' + virtualMainStore + '&substore=' + substore + '&virtualSubStore=' + virtualSubStore + '&locationID=' + locationID + '&virtualLocation=' + virtualLocation + '&category=' + category + '&capacity=' + capacity + '&unit=' + unit + '&remarks=' + remarks  , true);
    					multixmlHttp[loop].send(null); 
					}
				}
        }
    }
}

function handleSavingProcess()
{
	if(multixmlHttp[this.index].readyState == 4) 
    {
        if(multixmlHttp[this.index].status == 200) 
        {
        		var tbl = document.getElementById('tblCategories');
        		tbl.rows[this.index].className = "backcolorGreenRedBorder";
        		checkCompletion();
        }
    }   
}

function validateInputs()
{
	var tbl = document.getElementById('tblCategories');
	for(var loop = 1 ; loop < tbl.rows.length; loop ++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			if(tbl.rows[loop].cells[3].childNodes[0].value == "" || parseInt(tbl.rows[loop].cells[3].childNodes[0].value) == 0)
			{
				alert("You haven't enter correct capacities for some categories");
				tbl.rows[loop].cells[3].childNodes[0].focus();
				return false;
			}
		}	
	
	}
	return true;
}

function checkCompletion()
{
	var tbl = document.getElementById('tblCategories');
	for(var loop = 1 ; loop < tbl.rows.length; loop ++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			if(tbl.rows[loop].className == "bcgcolor-tblrow")
				return;
		}
	}
	alert("Bin - item allocation process completed.");
}

function checkAll(obj)
{
	var tbl = document.getElementById('tblCategories');
	for(var loop = 1 ; loop < tbl.rows.length; loop ++)
	{
		if(obj.checked)
			tbl.rows[loop].cells[0].childNodes[0].checked = true;
		else{
			if(!tbl.rows[loop].cells[0].childNodes[0].disabled)
				tbl.rows[loop].cells[0].childNodes[0].checked = false;
		
		}
	}
}

function setSameUnit(obj)
{
	if(!obj.checked) return;

	var tbl = document.getElementById('tblCategories');
	var unit = tbl.rows[1].cells[2].childNodes[0].value;
	for(var loop = 1 ; loop < tbl.rows.length; loop ++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked && !tbl.rows[loop].cells[0].childNodes[0].disabled)
			tbl.rows[loop].cells[2].childNodes[0].value = unit;
	}
}

function setSameCapacity(obj)
{
	if(!obj.checked) return;

	var tbl = document.getElementById('tblCategories');
	var capacity = tbl.rows[1].cells[3].childNodes[0].value;
	
	for(var loop = 1 ; loop < tbl.rows.length; loop ++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked && !tbl.rows[loop].cells[0].childNodes[0].disabled)
			tbl.rows[loop].cells[3].childNodes[0].value = capacity;
	}
}

function showAddNew(divId,height)
{
	var divC=document.getElementById(divId);
	if(divC.style.visibility=='hidden')
	{
		divC.style.height=height+"px";
		divC.style.visibility="visible";
	}
	else
	{
		divC.style.visibility="hidden";
		divC.style.height="0px";
	}
}

//
function LoadMainStoreDetails(obj)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadMainStoreDetailsResponse;
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=LoadMainStoreDetails&mainStoreId=' + obj.value , true);
	xmlHttp.send(null);  
}

function LoadMainStoreDetailsResponse()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {				
			var XMLCompanyId = xmlHttp.responseXML.getElementsByTagName("CompanyId");
				if(XMLCompanyId.length<=0){
					ClearForm(1);
					return;
				}
			document.getElementById('cboFactory').value =  XMLCompanyId[0].childNodes[0].nodeValue;
			var XMLName = xmlHttp.responseXML.getElementsByTagName("Name");				
			document.getElementById('txtStoreName').value =  XMLName[0].childNodes[0].nodeValue;
			var XMLRemarks = xmlHttp.responseXML.getElementsByTagName("Remarks");				
			document.getElementById('txtRemarks').value =  XMLRemarks[0].childNodes[0].nodeValue;
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");				
			if(XMLStatus[0].childNodes[0].nodeValue=='1')
				document.getElementById('chkMainActive').checked = true;
			else 
				document.getElementById('chkMainActive').checked = false;
				
			var XMLAutomateCompany = xmlHttp.responseXML.getElementsByTagName("AutomateCompany");
			
			//alert(XMLAutomateCompany.length);
			if(XMLAutomateCompany.length>1){
				document.getElementById('chkAutoBin').checked = true;
				document.getElementById('chkAutoBin').disabled=true;
				document.getElementById('txtVirSubStore').style.display="";
				document.getElementById('txtVirSubStore').value="";
				document.getElementById('txtVirSubStore').value= XMLName[1].childNodes[0].nodeValue;
			}
			else {
				document.getElementById('chkAutoBin').checked = false;
				document.getElementById('chkAutoBin').disabled=false;
				document.getElementById('txtVirSubStore').style.display="none";
				document.getElementById('txtVirSubStore').value="";
			}
				
			var XMLCommonBin = xmlHttp.responseXML.getElementsByTagName("CommonBin");				
			if(XMLCommonBin[0].childNodes[0].nodeValue=='1')
				document.getElementById('chkCommonBin').checked = true;
			else 
				document.getElementById('chkCommonBin').checked = false;
		}
	}
}

function LoadSubStoreDetails(obj)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadSubStoreDetailsResponse;
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=LoadSubStoreDetails&subStoreId=' + obj.value , true);
	xmlHttp.send(null);  
}

function LoadSubStoreDetailsResponse()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {				
			var XMLSubStoresName = xmlHttp.responseXML.getElementsByTagName("SubStoresName");
				if(XMLSubStoresName.length<=0){
					ClearForm(2);
					return;
				}
			document.getElementById('txtStoreName').value =  XMLSubStoresName[0].childNodes[0].nodeValue;
			var XMLRemarks = xmlHttp.responseXML.getElementsByTagName("Remarks");				
			document.getElementById('txtRemarks').value =  XMLRemarks[0].childNodes[0].nodeValue;
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");				
			if(XMLStatus[0].childNodes[0].nodeValue=='1')
				document.getElementById('chkSubActive').checked = true;
			else 
				document.getElementById('chkSubActive').checked = false;				
		}
	}
}

function LoadLocationDetails(obj)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadLocationDetailsResponse;
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=LoadLocationDetails&locationId=' + obj.value , true);
	xmlHttp.send(null);  
}

function LoadLocationDetailsResponse()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {				
			var XMLSubStoresName = xmlHttp.responseXML.getElementsByTagName("SubStoresName");
				if(XMLSubStoresName.length<=0){
					ClearForm(2);
					return;
				}
			document.getElementById('txtStoreName').value =  XMLSubStoresName[0].childNodes[0].nodeValue;
			var XMLRemarks = xmlHttp.responseXML.getElementsByTagName("Remarks");				
			document.getElementById('txtRemarks').value =  XMLRemarks[0].childNodes[0].nodeValue;
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");				
			if(XMLStatus[0].childNodes[0].nodeValue=='1')
				document.getElementById('chkSubActive').checked = true;
			else 
				document.getElementById('chkSubActive').checked = false;				
		}
	}
}

function LoadBinDetails(obj)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadBinDetailsResponse;
	xmlHttp.open("GET", 'storesMiddleTire.php?Request=LoadBinDetails&binId=' + obj.value , true);
	xmlHttp.send(null);  
}

function LoadBinDetailsResponse()
{	
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {				
			var XMLBinName = xmlHttp.responseXML.getElementsByTagName("BinName");
				if(XMLBinName.length<=0){
					ClearForm(2);
					return;
				}
			document.getElementById('txtStoreName').value =  XMLBinName[0].childNodes[0].nodeValue;
			var XMLRemarks = xmlHttp.responseXML.getElementsByTagName("Remarks");				
			document.getElementById('txtRemarks').value =  XMLRemarks[0].childNodes[0].nodeValue;
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");				
			if(XMLStatus[0].childNodes[0].nodeValue=='1')
				document.getElementById('chkSubActive').checked = true;
			else 
				document.getElementById('chkSubActive').checked = false;				
		}
	}
}

function ClearForm(obj)
{	
//alert(obj);
	if(obj=='1')
	{
		document.getElementById('cboSearch').value="";
		//document.getElementById('cboFactory').value="";
		document.getElementById('txtStoreName').value="";
		document.getElementById('txtRemarks').value="";
	//	document.getElementById('cboFactory').value="";
		document.getElementById('txtVirSubStore').value="";
		document.getElementById('txtVirSubStore').style.display="none";
		document.getElementById('chkAutoBin').disabled=false;
		document.getElementById('chkAutoBin').checked = false;
		document.getElementById('chkCommonBin').checked= false;
		document.getElementById('txtStoreName').focus();
	}
	else if(obj=='2')
	{
		document.getElementById('cboSearch').value="";
		document.getElementById('txtStoreName').value="";
		document.getElementById('txtRemarks').value="";
		document.getElementById('txtStoreName').focus();
	}
	else if(obj=='3')
	{
		document.getElementById('txtStoreName').value="";
		document.getElementById('txtRemarks').value="";
		document.getElementById('txtStoreName').focus();
	}	
	else if(obj=='4')
	{
		document.getElementById('txtStoreName').value="";
		document.getElementById('txtRemarks').value="";
		document.getElementById('txtStoreName').focus();
	}	
}
//----------------hem--------------------------------------
function activeVirtualSubstore(){
	
if(document.getElementById('chkAutoBin').checked == true){
document.getElementById('txtVirSubStore').style.display="";
document.getElementById('txtVirSubStore').focus();
}
else
document.getElementById('txtVirSubStore').style.display="none";

}
//---------Delete a Store-----------------------------------
function ConfirmDeleteStore(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select 'Main Store'.");
		document.getElementById('cboSearch').focus();
	}
	else
	{
		var storeName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ storeName+" \" ?");
		if (r==true)		
			DeleteStore(strCommand);
	}
}
//----------------------------------------------------------------------------
function DeleteStore(strCommand)
{
	createXMLHttpRequest();
  
	var url="storesMiddleTire.php";
	url=url+"?Request=deleteStore";

	if(strCommand=="Delete"){ 		
		url=url+"&cboStoreID="+document.getElementById("cboSearch").value;
		
	}
	
//	alert(url);

	xmlHttp.onreadystatechange=stateChanged2;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
//----------------------------
function stateChanged2() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
 
        { 
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		var factory=document.getElementById('cboFactory').value;
		
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
			RemoveAllRows('tblMainStores');
		
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateGrid(id,name,remarks,loop);
			loadCombo('SELECT strMainID,strName FROM mainstores where mainstores.intCompanyId =  '+factory+' AND intAutomateCompany <>1 AND intStatus<>10 order by strName;','cboSearch');
			ClearForm(1);	
		//	alert(xmlHttp.index);
			}
		}
	}
}
//-----------------------------------------------------------------------------------------
function ConfirmDeleteSubStore(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select 'Sub Store'.");
		document.getElementById('cboSearch').focus();
	}
	else
	{
		var storeName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ storeName+" \" ?");
		if (r==true)		
			DeleteSubStore(strCommand);
	}
}
//----------------------------------------------------------------------------
function DeleteSubStore(strCommand)
{
	createXMLHttpRequest();
  
	var url="storesMiddleTire.php";
	url=url+"?Request=deleteSubStore";

	if(strCommand=="Delete"){ 		
		url=url+"&cboStoreID="+document.getElementById("cboSearch").value+"&mainStore="+mainStore;
		
	}
	
//	alert(url);

	xmlHttp.onreadystatechange=stateChangedSubStore;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
//----------------------------
function stateChangedSubStore() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
 
        { 
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		var factory=document.getElementById('cboFactory').value;
		
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
			RemoveAllRows('tblMainStores');
		
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateGrid(id,name,remarks,loop);
			loadCombo('select strSubID,strSubStoresName,strRemarks from substores where intStatus<>10 and strMainID='+mainStore+' order by strSubStoresName;','cboSearch');
			ClearForm(2);	
		//	alert(xmlHttp.index);
			}
		}
	}
}
//-----------------------------------------------------------------------------------------
function ConfirmDeleteLocation(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select 'Location'.");
		document.getElementById('cboSearch').focus();
	}
	else
	{
		var locationName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ locationName+" \" ?");
		if (r==true)		
			DeleteLocation(strCommand);
	}
}
//----------------------------------------------------------------------------
function DeleteLocation(strCommand)
{
	createXMLHttpRequest();
  
	var url="storesMiddleTire.php";
	url=url+"?Request=deleteLocation";

	if(strCommand=="Delete"){ 		
		url=url+"&locationID="+document.getElementById("cboSearch").value+"&substore="+substore+"&mainStore="+mainStore;
		
	}
	
//	alert(url);

	xmlHttp.onreadystatechange=stateChangedLocation;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
//----------------------------
function stateChangedLocation() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
 
        { 
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		var factory=document.getElementById('cboFactory').value;
		
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
			RemoveAllRows('tblMainStores');
		
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateGrid(id,name,remarks,loop);
		//	alert('select strLocID,strLocName FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '+mainStore+' AND storeslocations.strSubID = '+substore+' and storeslocations.intStatus<>10 order By strLocName');
			loadCombo('select strLocID,strLocName FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '+mainStore+' AND storeslocations.strSubID = '+substore+' and storeslocations.intStatus<>10 order By strLocName;','cboSearch');
			ClearForm(2);	
		//	alert(xmlHttp.index);
			}
		}
	}
}
//-----------------------------------------------------------------------------------------
function ConfirmDeleteBin(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select 'Bin'.");
		document.getElementById('cboSearch').focus();
	}
	else
	{
		var binName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ binName+" \" ?");
		if (r==true)		
			DeleteBin(strCommand);
	}
}
//----------------------------------------------------------------------------
function DeleteBin(strCommand)
{
	createXMLHttpRequest();
  
	var url="storesMiddleTire.php";
	url=url+"?Request=deleteBin";

	if(strCommand=="Delete"){ 		
		url=url+"&binId="+document.getElementById("cboSearch").value+"&locationID="+locationID+"&substore="+substore+"&mainStore="+mainStore;
		
	}
	
//	alert(url);

	xmlHttp.onreadystatechange=stateChangedBin;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
//----------------------------
function stateChangedBin() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
 
        { 
		var XMLMessage	= xmlHttp.responseXML.getElementsByTagName("Message");
		alert(XMLMessage[0].childNodes[0].nodeValue);
		var factory=document.getElementById('cboFactory').value;
		
		var XMLID 		= xmlHttp.responseXML.getElementsByTagName("Id");
		var XMLName 	= xmlHttp.responseXML.getElementsByTagName("Name");
		var XMLRemarks 	= xmlHttp.responseXML.getElementsByTagName("Remarks");
			RemoveAllRows('tblMainStores');
		
		for(loop=0;loop<XMLID.length;loop++)
		{
			var id 		= XMLID[loop].childNodes[0].nodeValue;
			var name 	= XMLName[loop].childNodes[0].nodeValue;
			var remarks = XMLRemarks[loop].childNodes[0].nodeValue;
			CreateGrid(id,name,remarks,loop);
		//	alert('select strLocID,strLocName FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '+mainStore+' AND storeslocations.strSubID = '+substore+' and storeslocations.intStatus<>10 order By strLocName');
			loadCombo('SELECT strBinID,strBinName,storesbins.strRemarks,storesbins.intStatus FROM storesbins join mainstores on mainstores.strMainID=storesbins.strMainID WHERE storesbins.strMainID = '+mainStore+' AND storesbins.strSubID = '+substore+' AND storesbins.strLocID = '+locationID+' and storesbins.intStatus<>10 order by storesbins.strBinName;','cboSearch');
			ClearForm(2);	
		//	alert(xmlHttp.index);
			}
		}
	}
}
