var xmlHTTP				= [];
var pub_No				= 0;
var pub_validateCount	= 0;
var checkLoop			= 0;
function initiateResponse(index)
{
	if(window.ActiveXObject)
		xmlHTTP[index]=new ActiveXObject("Miccrosoft.XMLHTTP");
	else if(window.XMLHttpRequest)
		xmlHTTP[index]=new XMLHttpRequest(); 
	
}
function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 1) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function loadBuyerPOs()
{	
	RemoveAllRows('tblSource');
	RemoveAllRows('tblDestination');
	var styleId = document.getElementById("cboStyle").value;
	
	initiateResponse(0);
	xmlHTTP[0].onreadystatechange=function()
		{if(xmlHTTP[0].readyState==4 && xmlHTTP[0].status==200)
			{	
				deleteOption('cboBuyerPoNo');
				var XMLBuyerPO=xmlHTTP[0].responseXML.getElementsByTagName("BuyerPONO");
				var XMLBuyerPoName=xmlHTTP[0].responseXML.getElementsByTagName("BuyerPoName");
				for(var i=0; i<XMLBuyerPO.length;i++)
					{
						var opt=document.createElement("option");
						opt.text=XMLBuyerPoName[i].childNodes[0].nodeValue;
						opt.value=XMLBuyerPO[i].childNodes[0].nodeValue;
						document.getElementById("cboBuyerPoNo").options.add(opt);
					}
				
				
			}
		}
	
	xmlHTTP[0].open("GET",'bin2bindb.php?request=loadBPO&styleId='+styleId,true);
	xmlHTTP[0].send(null);
		
}

function deleteOption(selectName)
{
	var toDelOpt=document.getElementById(selectName);
	for(var i=toDelOpt.length-1;i>0;i--)
		toDelOpt.remove(i);	
}

function GetStyleName(obj)
{
	document.getElementById('cboStyle').value = obj.value;
	loadBuyerPOs();	
}
function GetScNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
	loadBuyerPOs();	
}
function loadSubStores(val)
{	if (val=="sor")
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
	
	
	
	initiateResponse(1);
	xmlHTTP[1].onreadystatechange=function()
		{if(xmlHTTP[1].readyState==4 && xmlHTTP[1].status==200)
			{	
				deleteOption(cboSub);
				var SubstoreName=xmlHTTP[1].responseXML.getElementsByTagName("SubStoreName");
				var SubstoreId=xmlHTTP[1].responseXML.getElementsByTagName("SubStoreId")
				for(var i=0; i<SubstoreId.length;i++)
					{
						var opt=document.createElement("option");
						opt.text=SubstoreName[i].childNodes[0].nodeValue;
						opt.value=SubstoreId[i].childNodes[0].nodeValue;
						document.getElementById(cboSub).options.add(opt);
						}
				
				
			}
		}
	var mainStore=document.getElementById(mainstore).value;
	xmlHTTP[1].open("GET",'bin2bindb.php?request=loadSubStores&mainStore='+mainStore,true);
	xmlHTTP[1].send(null);
		
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
	
		
	
	initiateResponse(2);
	xmlHTTP[2].onreadystatechange=function()
		{if(xmlHTTP[2].readyState==4 && xmlHTTP[2].status==200)
			{	
				deleteOption(location);
				var LocName=xmlHTTP[2].responseXML.getElementsByTagName("LocName");
				var LocID=xmlHTTP[2].responseXML.getElementsByTagName("LocID")
				for(var i=0; i<LocID.length;i++)
					{
						var opt=document.createElement("option");
						opt.text=LocName[i].childNodes[0].nodeValue;
						opt.value=LocID[i].childNodes[0].nodeValue;
						document.getElementById(location).options.add(opt);
						}
				
				
			}
		}
	var mainStore=document.getElementById(mainstore).value;
	var subStore=document.getElementById(cboSub).value;
	xmlHTTP[2].open("GET",'bin2bindb.php?request=loadLocatoion&mainStore='+mainStore+'&subStore='+subStore,true);
	xmlHTTP[2].send(null);
		
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

	initiateResponse(3);
	xmlHTTP[3].onreadystatechange=function()
		{if(xmlHTTP[3].readyState==4 && xmlHTTP[3].status==200)
			{	
				deleteOption(bin);
				var BinName=xmlHTTP[3].responseXML.getElementsByTagName("BinName");
				var BinID=xmlHTTP[3].responseXML.getElementsByTagName("BinID")
				for(var i=0; i<BinID.length;i++)
					{
						var opt=document.createElement("option");
						opt.text=BinName[i].childNodes[0].nodeValue;
						opt.value=BinID[i].childNodes[0].nodeValue;
						document.getElementById(bin).options.add(opt);
						}
				
				
			}
		}
	var mainStore=document.getElementById(mainstore).value;
	var subStore=document.getElementById(cboSub).value;
	var location=document.getElementById(location).value;
	xmlHTTP[3].open("GET",'bin2bindb.php?request=loadBin&mainStore='+mainStore+'&subStore='+subStore+'&location='+location,true);
	xmlHTTP[3].send(null);
		
}
	
function LoadSourceBinDetails(){
var styleId 	= document.getElementById("cboStyle").value;
var buyerPoNo 	= document.getElementById('cboBuyerPoNo').value;
var mainStore 	= document.getElementById('cboMainStores').value;
if(searchValidate(styleId,buyerPoNo,mainStore)){
	return;
}
showBackGroundBalck();
initiateResponse(2)
xmlHTTP[2].onreadystatechange = LoadSourceBinDetailsRequest;
xmlHTTP[2].open("GET",'bin2bindb.php?request=LoadSourceBinDetails&styleId=' +URLEncode(styleId)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&mainStore=' +mainStore,true);
xmlHTTP[2].send(null);
}
function LoadSourceBinDetailsRequest(){
	if(xmlHTTP[2].readyState==4 && xmlHTTP[2].status==200){
		
		var XMLScNo 			= xmlHTTP[2].responseXML.getElementsByTagName("ScNo");
		var XMLStyleName 		= xmlHTTP[2].responseXML.getElementsByTagName("StyleName");
		var XMLStyleId 			= xmlHTTP[2].responseXML.getElementsByTagName("styleNo");
		var XMLmatDetailId 		= xmlHTTP[2].responseXML.getElementsByTagName("matDetailId");
		var XMLItemDescription	= xmlHTTP[2].responseXML.getElementsByTagName("ItemDescription");
		var XMLColor 			= xmlHTTP[2].responseXML.getElementsByTagName("Color");
		var XMLSize 			= xmlHTTP[2].responseXML.getElementsByTagName("Size");
		var XMLstockQty 		= xmlHTTP[2].responseXML.getElementsByTagName("stockQty");
		var XMLUnits 			= xmlHTTP[2].responseXML.getElementsByTagName("Units");
		var tbl 	  			= document.getElementById('tblSource');
		var text 				= "";
		
		RemoveAllRows('tblSource');
		RemoveAllRows('tblDestination');
		if(XMLStyleId.length<=0){
			alert("No details found in selected criteria");
			hideBackGroundBalck();
			return;
		}
			
		for(var loop=0;loop<XMLStyleId.length;loop++)
		{
			var lastRow = tbl.rows.length;	
			var row = tbl.insertRow(lastRow);
			row.className="bcgcolor-tblrowWhite";
	text = "<td class=\"normalfntMid\" id="+loop+">"+XMLScNo[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\" id=\""+XMLStyleId[loop].childNodes[0].nodeValue+"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfnt\" id="+XMLmatDetailId[loop].childNodes[0].nodeValue+">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\" id="+XMLUnits[loop].childNodes[0].nodeValue+">"+XMLSize[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntRite\">"+XMLstockQty[loop].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntMid\"><input name=\"textfield\" class=\"txtbox\" type=\"text\" style=\"text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"checkQty(this);\" onmouseover=\"checkQty(this);\" value="+XMLstockQty[loop].childNodes[0].nodeValue+" size=\"10\" /></td>"+
			"<td class=\"normalfntMid\"> <input type=\"checkbox\" id=\"chkTransfer\" onclick=\"AddDetailsToDestination(this)\"></td>";
      
		tbl.rows[lastRow].innerHTML=text;
		}
		hideBackGroundBalck();
		document.getElementById("butSave").style.visibility="visible";
	}
}

function AddDetailsToDestination(obj){
var rw 				= obj.parentNode.parentNode;
var no				= rw.cells[0].id;
var matDetailsId	= rw.cells[2].id;
var transQty		= rw.cells[6].childNodes[0].value;
var stockQty		= rw.cells[5].childNodes[0].nodeValue;

var destMainStoreId	= document.getElementById('cboDesMainStores').value;
var destSubStoreId	= document.getElementById('cboDesSubStores').value;
var destLocationId	= document.getElementById('cboDesLocation').value;
var destBinId		= document.getElementById('cboDesBin').value;
		if(validateDestination(destMainStoreId,destSubStoreId,destLocationId,destBinId,transQty,stockQty)){
			obj.checked=false;
			return;
		}
		if(!obj.checked){
			removeItemFromDestination(no);
			return;
		}

initiateResponse(4)
xmlHTTP[4].onreadystatechange = validateBinAllocationRequest;
xmlHTTP[4].index	= obj;
xmlHTTP[4].open("GET",'bin2bindb.php?request=validateBinAllocation&matDetailsId=' +matDetailsId+ '&destMainStoreId=' +destMainStoreId+ '&destSubStoreId=' +destSubStoreId+ '&destLocationId=' +destLocationId+ '&destBinId=' +destBinId ,true);
xmlHTTP[4].send(null);
}

function validateBinAllocationRequest(){
	if(xmlHTTP[4].readyState==4 && xmlHTTP[4].status==200){
		
		var XMLValidate 	= xmlHTTP[4].responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
		var XMLMatCatName 	= xmlHTTP[4].responseXML.getElementsByTagName("MatCatName")[0].childNodes[0].nodeValue;
		
		var obj 		= xmlHTTP[4].index;
		if(XMLValidate!="TRUE"){
			addDetails(obj);
		}
		else{
			alert("Sorry!\nSub Category Name : "+XMLMatCatName+" still not allocate to the selected Destination Bin.Please allocate and try again.")
			obj.checked=false;			
			return;
		}
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

function addDetails(obj){
		var rw 				= obj.parentNode.parentNode;
		var scno			= rw.cells[0].childNodes[0].nodeValue;
		var no				= rw.cells[0].id;
		var styleName		= rw.cells[1].childNodes[0].nodeValue;
		var styleId			= rw.cells[1].id;
		var itemDescription	= rw.cells[2].childNodes[0].nodeValue;
		var matDetailsId	= rw.cells[2].id;
		var color			= rw.cells[3].childNodes[0].nodeValue;		
		var size			= rw.cells[4].childNodes[0].nodeValue;
		var units			= rw.cells[4].id;
		var transQty		= rw.cells[6].childNodes[0].value;		
		var tbl 	  		= document.getElementById('tblDestination');
		
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className="bcgcolor-tblrowWhite";
		
		text ="<td class=\"normalfntMid\"><img src=\"../images/del.png\" alt=\"edit\" width=\"15\" height=\"15\"/></td>"+
 		"<td class=\"normalfntMid\" id=\""+no+"\">"+scno+"</td>"+
		"<td class=\"normalfntMid\" id=\""+styleId+"\">"+styleName+"</td>"+
		"<td class=\"normalfnt\" id="+matDetailsId+">"+itemDescription+"</td>"+
		"<td class=\"normalfntMid\" >"+color+"</td>"+
		"<td class=\"normalfntMid\" id="+units+">"+size+"</td>"+
		"<td class=\"normalfntRite\">"+transQty+"</td>";	
     	
		tbl.rows[lastRow].innerHTML=text;
}
function GetNo(){
	var tblSource = document.getElementById('tblSource');
	var tbl = document.getElementById('tblDestination');
	if(tbl.rows.length<=1){alert("Sorry!\nNo Destination details to save.");return}
	if(tblSource.rows.length<=1){alert("Sorry!\nNo Source details to save.");return}
	if(SaveValidate()){
		return;
	}
	showBackGroundBalck();
	initiateResponse(1);
	xmlHTTP[1].onreadystatechange=GetNoRequest;
	xmlHTTP[1].open("GET",'bin2bindb.php?request=GetNo', true);
	xmlHTTP[1].send(null);
}

	function GetNoRequest(){
		if(xmlHTTP[1].readyState==4 && xmlHTTP[1].status==200){
			var XMLAdmin	= xmlHTTP[1].responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
				
				if(XMLAdmin=="TRUE"){
					var XMLNo =xmlHTTP[1].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;					
					pub_No =parseInt(XMLNo);						
					Save();				
				}
				else{
					alert("Please contact system administrator to Assign New No....");
					hideBackGroundBalck();
				}
		}
	}
	
function Save(){
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
		
		initiateResponse(i);	
		var url= "binTransfer-db.php?id=save";
			url += "&styleId="+URLEncode(styleId);
			url += "&buyerPoNo="+URLEncode(buyerPoNo);
			url += "&itemCode="+itemCode;
			url += "&color="+URLEncode(color);
			url += "&size="+URLEncode(size);
			url += "&unit="+units;
			url += "&sourceMainId="+document.getElementById("cboMainStores").value;
			url += "&transferQty="+transferQty;		
			url += "&desMainId="+document.getElementById("cboDesMainStores").value;
			url += "&desSubId="+document.getElementById("cboDesSubStores").value;
			url += "&desLocation="+document.getElementById("cboDesLocation").value;
			url += "&desBinId="+document.getElementById("cboDesBin").value;
			url += "&no="+pub_No;
		pub_validateCount++;
		xmlHTTP[i].index = i;
		xmlHTTP[i].open("GET", url, true);
		xmlHTTP[i].send(null);	
	
	}
	SaveValidation();
}
function SaveValidation()
{	
	initiateResponse(10);
	xmlHTTP[10].onreadystatechange = SaveValidationRequest;
	xmlHTTP[10].open("GET",'bin2bindb.php?request=SaveValidate&no=' +pub_No+  '&validateCount=' +pub_validateCount ,true);
	xmlHTTP[10].send(null);
}
	function SaveValidationRequest()
	{
		if(xmlHTTP[10].readyState == 4) 
		{
			if(xmlHTTP[10].status == 200)
			{				
				var XMLCountBinInDetails= xmlHTTP[10].responseXML.getElementsByTagName("recCountBinInDetails")[0].childNodes[0].nodeValue;
				var XMLCountBinOutDetails= xmlHTTP[10].responseXML.getElementsByTagName("recCountBinOutDetails")[0].childNodes[0].nodeValue;
				
					if(XMLCountBinInDetails=="TRUE" && XMLCountBinOutDetails=="TRUE")
					{
						alert("Bin to bin transfered successfully.");
						hideBackGroundBalck();					
						document.getElementById("butSave").style.visibility="hidden";
					}
					else 
					{
						checkLoop++;
						if(checkLoop>10){
							alert("Sorry!\nError occured while saving the data. Please Save it again.");
							hideBackGroundBalck();
							checkLoop = 0;
							return;
						}
						else{
							SaveValidation();											
						}
					}			
			}
		}
	}

function validateDestination(destMainStoreId,destSubStoreId,destLocationId,destBinId,transQty,stockQty){	
	if(destMainStoreId==""){alert("Please select the Destination Main Store.");return true;}
	if(destSubStoreId==""){alert("Please select the Destination Sub Store.");return true;}
	if(destLocationId==""){alert("Please select the Destination Location.");return true;}
	if(destBinId==""){alert("Please select the Destination Bin.");return true;}
	if(parseFloat(transQty)==0){alert("Transfer qty cannot be '0'.");return true;}
	if(transQty==""){alert("Transfer qty cannot be empty.");return true;}
	if(parseFloat(transQty)>parseFloat(stockQty)){alert("Transfer qty cannot be exceed stock qty\nStock Qty = "+ stockQty +"\nTransfer Qty = " +transQty);return true;}
return false;
}

function SaveValidate(){
	if(document.getElementById("cboStyle").value==""){alert("Please select the Style.");return true;}
	if(document.getElementById("cboBuyerPoNo").value==""){alert("Please select the BuyerPoNo.");return true;}
	if(document.getElementById("cboMainStores").value==""){alert("Please select the Source Main Store.");return true;}
	if(document.getElementById("cboDesMainStores").value==""){alert("Please select the Destination Main Store.");return true;}
	if(document.getElementById("cboDesSubStores").value==""){alert("Please select the Destination Sub Store.");return true;}
	if(document.getElementById("cboDesLocation").value==""){alert("Please select the Destination Location.");return true;}
	if(document.getElementById("cboDesBin").value==""){alert("Please select the Destination Bin.");return true;}
	return false;
}

function searchValidate(styleId,buyerPoNo,mainStore){
	if(styleId==""){alert("Please select the Style.");return true;}
	if(buyerPoNo==""){alert("Please select the BuyerPoNo.");return true;}
	if(mainStore==""){alert("Please select the Source Main Store.");return true;}
return false;
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

function showBackGroundBalck()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	//popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
	document.body.appendChild(popupbox);
}
function hideBackGroundBalck()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}