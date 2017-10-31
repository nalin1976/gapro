var pub_No					= 0;
var pub_validateCount		= 0;
var pub_ActiveCommonBins	= 0;

function showBackGroundBalck()
{
	showBackGround('divBG',0);
}

function hideBackGroundBalck()
{
	hideBackGround('divBG');
}

function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();	
}

function RomoveData(data)
{
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 1) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td 		 = obj.parentNode;
		var tro 	 = td.parentNode;		
		tro.parentNode.removeChild(tro);	
	}
}
function loadBuyerPOs()
{	
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');

	var style=document.getElementById("cboStyleNo").value;
	var url = 'bin2bindb.php?request=loadBPO&style='+style;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboBuyerPoNo").innerHTML = htmlobj.responseText;		
}

function deleteOption(selectName)
{
	var toDelOpt=document.getElementById(selectName);
	for(var i=toDelOpt.length-1;i>0;i--)
		toDelOpt.remove(i);	
}

function changeSC(obj)
{
	document.getElementById("cboStyleNo").value = obj.value;
	loadBuyerPOs();	
}

function changeStyleid(obj)
{
	document.getElementById("cboScNo").value = obj.value;
	loadBuyerPOs();	
}

function loadSubStores(val)
{	
	if (val=="sor")
	{
		var cboSub="cboSubStores";	
		var mainstore="cboMainStores";
		RemoveAllRows('tblSource');
		RomoveData('cboSubStores');
		RomoveData('cboLocation');
		RomoveData('cboBin');
	}
	if (val=="des")
	{
		var cboSub="cboDesSubStores";
		var mainstore="cboDesMainStores";
		RemoveAllRows('tblDestination');
		RomoveData('cboDesSubStores');
		RomoveData('cboDesLocation');
		RomoveData('cboDesBin');
	}
	
	var mainStore=document.getElementById(mainstore).value;
	var url = 'bin2bindb.php?request=loadSubStores&mainStore='+mainStore;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById(cboSub).innerHTML = htmlobj.responseText;
}

function loadLocation(val)
{
	if (val=="sor")
	{
		var cboSub="cboSubStores";	
		var mainstore="cboMainStores";
		var location="cboLocation";
		RemoveAllRows('tblSource');
		RomoveData('cboLocation');
		RomoveData('cboBin');
	}
	if (val=="des")
	{
		var cboSub="cboDesSubStores";
		var mainstore="cboDesMainStores";
		var location="cboDesLocation";
		RemoveAllRows('tblDestination');
		RomoveData('cboDesLocation');
		RomoveData('cboDesBin');
	}

	var mainStore = document.getElementById(mainstore).value;
	var subStore  = document.getElementById(cboSub).value;
	var url = 'bin2bindb.php?request=loadLocatoion&mainStore='+mainStore+'&subStore='+subStore;
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById(location).innerHTML = htmlobj.responseText;		
}

function loadBIN(val)
{	if (val=="sor")
	{
		var cboSub="cboSubStores";	
		var mainstore="cboMainStores";
		var location="cboLocation";
		var bin="cboBin";
		RemoveAllRows('tblSource');
		RomoveData('cboBin');
	}
	if (val=="des")
	{
		var cboSub="cboDesSubStores";
		var mainstore="cboDesMainStores";
		var location="cboDesLocation";
		var bin="cboDesBin";
		RemoveAllRows('tblDestination');
		RomoveData('cboDesBin');
	}

	var mainStore=document.getElementById(mainstore).value;
	var subStore=document.getElementById(cboSub).value;
	var location=document.getElementById(location).value;
	var url = 'bin2bindb.php?request=loadBin&mainStore='+mainStore+'&subStore='+subStore+'&location='+location;
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById(bin).innerHTML = htmlobj.responseText;			
}
	
function LoadSourceBinDetails()
{
	showBackGroundBalck();
	var styleId 	= document.getElementById("cboScNo").value;
	var buyerPoNo 	= document.getElementById('cboBuyerPoNo').value;
	var mainStore 	= document.getElementById('cboMainStores').value;
	var subStore 	= document.getElementById('cboSubStores').value;
	var location 	= document.getElementById('cboLocation').value;
	var bin 		= document.getElementById('cboBin').value;
	if(!searchValidate(buyerPoNo,mainStore,subStore,location,bin)){
		hideBackGroundBalck();
		return;
	}

	var url = 'bin2bindb.php?request=LoadSourceBinDetails&styleId=' +styleId+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&mainStore=' +mainStore+ '&subStore=' +subStore+ '&location=' +location+ '&bin=' +bin;
	htmlobj=$.ajax({url:url,async:false});
	LoadSourceBinDetailsRequest(htmlobj);
}

function LoadSourceBinDetailsRequest(htmlobj)
{	
	var tbl 	  			= document.getElementById('tblSource');
	var XMLScNo 			= htmlobj.responseXML.getElementsByTagName("ScNo");
	var XMLStyleId 			= htmlobj.responseXML.getElementsByTagName("styleNo");
	var XMLStyleName 		= htmlobj.responseXML.getElementsByTagName("styleName");
	var XMLmatDetailId 		= htmlobj.responseXML.getElementsByTagName("matDetailId");
	var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color");
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLstockQty 		= htmlobj.responseXML.getElementsByTagName("stockQty");
	var XMLUnits 			= htmlobj.responseXML.getElementsByTagName("Units");
	var XMLGRNno 			= htmlobj.responseXML.getElementsByTagName("GRNno");
	var XMLGRNYear 			= htmlobj.responseXML.getElementsByTagName("GRNyear");
	var XMLGRNTypeId		= htmlobj.responseXML.getElementsByTagName("GRNTypeId");
	var XMLGRNType 			= htmlobj.responseXML.getElementsByTagName("GRNType");
	var text 				= "";
	
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
	
	for(var loop=0;loop<XMLStyleId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className="bcgcolor-tblrowWhite";
text = "<td class=\"normalfntMid\" id="+loop+">"+XMLScNo[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfnt\" id=\""+ XMLStyleId[loop].childNodes[0].nodeValue +"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfnt\" id="+XMLmatDetailId[loop].childNodes[0].nodeValue+">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntMid\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntMid\" id="+XMLUnits[loop].childNodes[0].nodeValue+">"+XMLSize[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntRite\">"+XMLstockQty[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntMid\"><input name=\"textfield\" class=\"txtbox\" type=\"text\" style=\"text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"checkQty(this);\" onmouseover=\"checkQty(this);\" value="+XMLstockQty[loop].childNodes[0].nodeValue+" size=\"10\" /></td>"+
		"<td class=\"normalfntMid\"> <input type=\"checkbox\" id=\"chkTransfer\" onclick=\"AddDetailsToDestination(this)\"></td>"+
		"<td class=\"normalfntRite\">"+XMLGRNno[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntRite\">"+XMLGRNYear[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntRite\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>";  
		tbl.rows[lastRow].innerHTML=text;
	}
	hideBackGroundBalck();
	document.getElementById("butSave").style.visibility="visible";
}

function AddDetailsToDestination(obj)
{
var rw 				= obj.parentNode.parentNode;
var no				= rw.cells[0].id;
var matDetailsId	= rw.cells[2].id;
var transQty		= rw.cells[6].childNodes[0].value;
var stockQty		= rw.cells[5].childNodes[0].nodeValue;

var destMainStoreId	= document.getElementById('cboDesMainStores').value;
var destSubStoreId	= document.getElementById('cboDesSubStores').value;
var destLocationId	= document.getElementById('cboDesLocation').value;
var destBinId		= document.getElementById('cboDesBin').value;
		
	if(validateDestination(destMainStoreId,destSubStoreId,destLocationId,destBinId,transQty,stockQty,rw)){
		obj.checked=false;
		return;
	}
	if(!obj.checked){
		removeItemFromDestination(no);
		return;
	}

var url = 'bin2bindb.php?request=validateBinAllocation&matDetailsId=' +matDetailsId+ '&destMainStoreId=' +destMainStoreId+ '&destSubStoreId=' +destSubStoreId+ '&destLocationId=' +destLocationId+ '&destBinId=' +destBinId+'&pub_ActiveCommonBins='+pub_ActiveCommonBins;
htmlobj=$.ajax({url:url,async:false});
validateBinAllocationRequest(htmlobj,obj);
}

function validateBinAllocationRequest(htmlobj,obj)
{		
	var XMLValidate 	= htmlobj.responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
	var XMLMatCatName 	= htmlobj.responseXML.getElementsByTagName("MatCatName")[0].childNodes[0].nodeValue;

	
	if(XMLValidate!="TRUE")
	{
		addDetails(obj);
	}
	else
	{
		alert("Sorry!\nSub Category Name : "+XMLMatCatName+" still not allocate to the selected Destination Bin.Please allocate and try again.")
		obj.checked=false;			
		return;
	}
}

function removeItemFromDestination(no){
	var tblDestination 	= document.getElementById('tblDestination');
	var test	= tblDestination.rows.length;
	for(var i =1;i<test;i++)
	{
		var descno = tblDestination.rows[i].cells[1].id;		
		if(no==descno){
			tblDestination.deleteRow(i);
		}
	}
}

function addDetails(obj)
{
		var rw 				= obj.parentNode.parentNode;
		var scno			= rw.cells[0].childNodes[0].nodeValue;
		var no				= rw.cells[0].id;
		var styleId			= rw.cells[1].id;
		var styleName		= rw.cells[1].childNodes[0].nodeValue;
		var itemDescription	= rw.cells[2].childNodes[0].nodeValue;
		var matDetailsId	= rw.cells[2].id;
		var color			= rw.cells[3].childNodes[0].nodeValue;		
		var size			= rw.cells[4].childNodes[0].nodeValue;
		var units			= rw.cells[4].id;
		var transQty		= rw.cells[6].childNodes[0].value;	
		var GRNNo			= rw.cells[8].childNodes[0].nodeValue;
		var GRNYear			= rw.cells[9].childNodes[0].nodeValue;
		var GRNTypeId		= rw.cells[10].id;
		var GRNType			= rw.cells[10].childNodes[0].nodeValue;
		var tbl 	  		= document.getElementById('tblDestination');
		
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className="bcgcolor-tblrowWhite";
		
		text ="<td class=\"normalfntMid\"><img src=\"../images/del.png\" alt=\"edit\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\"/></td>"+
 		"<td class=\"normalfntMid\" id="+no+">"+scno+"</td>"+
		"<td class=\"normalfnt\" id=\""+styleId+"\">"+styleName+"</td>"+
		"<td class=\"normalfnt\" id="+matDetailsId+">"+itemDescription+"</td>"+
		"<td class=\"normalfntMid\" >"+color+"</td>"+
		"<td class=\"normalfntMid\" id="+units+">"+size+"</td>"+
		"<td class=\"normalfntRite\">"+transQty+"</td>"+
		"<td class=\"normalfntRite\">"+GRNNo+"</td>"+
		"<td class=\"normalfntRite\">"+GRNYear+"</td>"+
		"<td class=\"normalfntRite\" id=\""+GRNTypeId+"\">"+GRNType+"</td>";	
     	
		tbl.rows[lastRow].innerHTML=text;
}

function GetNo()
{	
	document.getElementById("butSave").style.display="none";
	showBackGroundBalck();
	if(!SaveValidate())
	{
		document.getElementById("butSave").style.display="inline";
		hideBackGroundBalck();		
		return;
	}	

	var url = 'bin2bindb.php?request=GetNo';
	htmlobj=$.ajax({url:url,async:false});
	GetNoRequest(htmlobj);
}

function GetNoRequest(htmlobj)
{
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
		
	if(XMLAdmin=="TRUE"){
		var XMLNo = htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;					
		pub_No =parseInt(XMLNo);						
		Save();				
	}
	else{
		alert("Please contact system administrator to Assign New No....");
		hideBackGroundBalck();
	}
}
	
function Save()
{
	pub_validateCount	= 0;
	var tbl = document.getElementById('tblDestination');
	for(var i=1;i<tbl.rows.length;i++)
	{
		var scNo 		= tbl.rows[i].cells[1].childNodes[0].nodeValue;
		var styleId 	= tbl.rows[i].cells[2].id;
		var itemCode 	= tbl.rows[i].cells[3].id;
		var buyerPoNo 	= document.getElementById('cboBuyerPoNo').value;
		var color 		= tbl.rows[i].cells[4].childNodes[0].nodeValue;
		var size 		= tbl.rows[i].cells[5].childNodes[0].nodeValue;
		var units		= tbl.rows[i].cells[5].id;
		var transferQty	= tbl.rows[i].cells[6].childNodes[0].nodeValue;
		var GRNno 		= tbl.rows[i].cells[7].childNodes[0].nodeValue
		var GRNyear 	= tbl.rows[i].cells[8].childNodes[0].nodeValue
		var grnType 	= tbl.rows[i].cells[9].id;
		
		var url= "binTransfer-db.php?id=save";
			url += "&styleId="+URLEncode(styleId);
			url += "&buyerPoNo="+URLEncode(buyerPoNo);
			url += "&itemCode="+itemCode;
			url += "&color="+URLEncode(color);
			url += "&size="+URLEncode(size);
			url += "&unit="+units;
			url += "&sourceMainId="+document.getElementById("cboMainStores").value;
			url += "&sourceSubId="+document.getElementById("cboSubStores").value;
			url += "&sourceLocation="+document.getElementById("cboLocation").value;
			url += "&sourceBinId="+document.getElementById("cboBin").value;
			url += "&transferQty="+transferQty;		
			url += "&desMainId="+document.getElementById("cboDesMainStores").value;
			url += "&desSubId="+document.getElementById("cboDesSubStores").value;
			url += "&desLocation="+document.getElementById("cboDesLocation").value;
			url += "&desBinId="+document.getElementById("cboDesBin").value;
			url += "&no="+pub_No;
			url += "&GRNno="+GRNno;
			url += "&GRNyear="+GRNyear;
			url += "&GRNType="+grnType;			
		pub_validateCount++;
		var htmlobj=$.ajax({url:url,async:false});	
	}
	SaveValidation();
}
function SaveValidation()
{	
	var url = 'bin2bindb.php?request=SaveValidate&no=' +pub_No+  '&validateCount=' +pub_validateCount;
	var htmlobj=$.ajax({url:url,async:false});
	SaveValidationRequest(htmlobj);
}

function SaveValidationRequest(htmlobj)
{
	var XMLCountBinInDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinInDetails")[0].childNodes[0].nodeValue;
	var XMLCountBinOutDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinOutDetails")[0].childNodes[0].nodeValue;
	
	if(XMLCountBinInDetails=="TRUE" && XMLCountBinOutDetails=="TRUE")
	{
		alert("Bin to bin transfered successfully.");
		hideBackGroundBalck();					
		document.getElementById("butSave").style.display="none";
	}
	else 
	{
		alert("Sorry!\nError occured while saving the data. Please Save it again.");
		document.getElementById("butSave").style.display="inline";
		hideBackGroundBalck();
		return;
	}	
		location.reload();
}

function validateDestination(destMainStoreId,destSubStoreId,destLocationId,destBinId,transQty,stockQty,rw){	
	if(destMainStoreId==""){
		alert("Please select the 'Destination Main Store'.");
		document.getElementById('cboDesMainStores').focus();
	return true;
	}
	else if(destSubStoreId==""){
		alert("Please select the 'Destination Sub Store'.");
		document.getElementById('cboDesSubStores').focus();
	return true;
	}
	else if(destLocationId==""){
		alert("Please select the 'Destination Location'.");
		document.getElementById('cboDesLocation').focus();
		return true;
	}
	else if(destBinId==""){
		alert("Please select the 'Destination Bin'.");
		document.getElementById('cboDesBin').focus();
		return true;
	}
	else if(parseFloat(transQty)==0){
		alert("Transfer qty cannot be '0'.");
		rw.cells[6].childNodes[0].focus();
		return true;
	}
	else if(transQty==""){
		alert("Transfer qty cannot be empty.");
		rw.cells[6].childNodes[0].focus();
		return true;
	}
	else if(parseFloat(transQty)>parseFloat(stockQty)){
		alert("Transfer qty cannot be exceed stock qty\nStock Qty = "+ stockQty +"\nTransfer Qty = " +transQty);
		rw.cells[6].childNodes[0].focus();
		return true;
	}
	var sourceMainStore = document.getElementById('cboMainStores').value;
	var sourceSubStore	= document.getElementById('cboSubStores').value;
	var sourceLocation	= document.getElementById('cboLocation').value;
	var sourceBin		= document.getElementById('cboBin').value;
	
	if(sourceMainStore==destMainStoreId && sourceSubStore==destSubStoreId && sourceLocation==destLocationId && sourceBin==destBinId)
	{
		alert("'Source Bin' and 'Destination Bin' cannot be same.");
		document.getElementById('cboBin').focus();
		return true;
	}
return false;
}

function SaveValidate()
{
	var tblSource 	= document.getElementById('tblSource');
	var tbl 		= document.getElementById('tblDestination');
	
	if(document.getElementById("cboScNo").value == ""){
		alert("Please select the 'Order No'.");
		document.getElementById("cboScNo").focus();
		return false;
	}
	else if(document.getElementById("cboBuyerPoNo").value==""){
		alert("Please select the 'Buyer PoNo'.");
		document.getElementById("cboBuyerPoNo").focus();
		return false;
	}
	else if(document.getElementById("cboMainStores").value==""){
		alert("Please select the 'Source Main Store'.");
		document.getElementById("cboMainStores").focus();
		return false;
	}
	else if(document.getElementById("cboSubStores").value==""){
		alert("Please select the 'Source Sub Store'.");
		document.getElementById("cboSubStores").focus();
		return false;
	}
	else if(document.getElementById("cboLocation").value==""){
		alert("Please select the 'Source Location'.");
		document.getElementById("cboLocation").focus();
		return false;
	}
	else if(document.getElementById("cboBin").value==""){
		alert("Please select the 'Source Bin'.");
		document.getElementById("cboBin").focus();
		return false;
	}
	else if(tblSource.rows.length<=1){
		alert("Sorry!\nNo Source details to save.");
		return false;
	}
	else if(document.getElementById("cboDesMainStores").value==""){
		alert("Please select the 'Destination Main Store'.");
		document.getElementById("cboDesMainStores").focus();
		return false;
	}
	else if(document.getElementById("cboDesSubStores").value==""){
		alert("Please select the 'Destination Sub Store'.");
		document.getElementById("cboDesSubStores").focus();
		return false;
	}
	else if(document.getElementById("cboDesLocation").value==""){
		alert("Please select the 'Destination Location'.");
		document.getElementById("cboDesLocation").focus();
		return false;
	}
	else if(document.getElementById("cboDesBin").value==""){
		alert("Please select the 'Destination Bin'.");
		document.getElementById("cboDesBin").focus();
		return false;
	}
	else if(tbl.rows.length<=1){
		alert("Sorry!\nNo Destination details to save.");
		return false;
	}	
return true;
}

function searchValidate(buyerPoNo,mainStore,subStore,location,bin)
{	
	if(document.getElementById("cboScNo").value==""){
		alert("Please select the 'Order No'.");
		document.getElementById("cboScNo").focus();
		return false;
	}
	else if(buyerPoNo==""){
		alert("Please select the 'Buyer PoNo'.");
		document.getElementById('cboBuyerPoNo').focus();
		return false;
	}
	else if(mainStore==""){
		alert("Please select the 'Source Main Store'.");
		document.getElementById('cboMainStores').focus();
		return false;
	}
	else if(subStore==""){
		alert("Please select the 'Source Sub Store'.");
		document.getElementById('cboSubStores').focus();
		return false;
	}
	else if(location==""){
		alert("Please select the 'Source Location'.");
		document.getElementById('cboLocation').focus();
		return false;
	}
	else if(bin==""){
		alert("Please select the 'Source Bin'.");
		document.getElementById('cboBin').focus();
		return false;
	}
return true;
}

function checkQty(obj)
{
	var rw	= obj.parentNode.parentNode;
	var stockQty	= rw.cells[5].childNodes[0].nodeValue;
	if(parseFloat(obj.value)>parseFloat(stockQty))
	{		
		obj.value = stockQty;
	}
}

function getCommonBinDet()
{
	var strMainStores = $("#cboDesMainStores").val();
	var url  = "bin2bindb.php?";
		url += "request=getCommonBin";
		url += "&strMainStores="+strMainStores;
	var htmlobj=$.ajax({url:url,async:false});	
	pub_ActiveCommonBins = htmlobj.responseXML.getElementsByTagName("commonbin")[0].childNodes[0].nodeValue;
}

function ClearForm()
{
	showBackGround('divBG',0);
	document.frmBinToBin.reset();
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
	document.getElementById('cboBuyerPoNo').innerHTML="";
	hideBackGround('divBG');
}