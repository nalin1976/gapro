var xmlHttp 			= [];
var Pub_recCount		= 0;
function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function createXMLHttpRequest(index){
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}
function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
 function isNumberKey(evt){
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function SeachFromStyle(){	
	var ScNo =document.getElementById("cboFromScno").options[document.getElementById("cboFromScno").selectedIndex].text;
	document.getElementById("cboFrom").value =ScNo;

}

function SeachFromSC(){	
	var StyleFromID =document.getElementById('cboFrom').options[document.getElementById('cboFrom').selectedIndex].text;
	document.getElementById('cboFromScno').value =StyleFromID;

}

function LoadDetails()
{
	
	var newStyleId		= document.getElementById('cboFrom').options[document.getElementById('cboFrom').selectedIndex].text;
	var oldStyle		= document.getElementById('cboTo').value;	
	var toScno			= document.getElementById('cboToScno').value;
	var mainStoreID		= document.getElementById('cboMainStores').value;
	var subStoreID		= document.getElementById('cboSubStore').value;
	var locationID		= document.getElementById('cboLocation').value;
	var biID			= document.getElementById('cboBins').value;
	
	if(newStyleId=="Select One"){alert("Please select the transfer from style....");return}
	if(oldStyle==""){alert("Please select the transfer to style....");return}
	if(toScno==""){alert("Please select the SCNO.");return;}
	if(newStyleId==oldStyle){alert("Tranfering style from and style to should be different....");return}
	if(mainStoreID==""){alert("Please select the Main Stores....");return}
	if(subStoreID==""){alert("Please select the Sub Stores....");return}
	if(locationID==""){alert("Please select the Location....");return}
	if(biID==""){alert("Please select the Bin....");return}
	showBackGroundBalck();
	RemoveAllRows('tblMain');
	createXMLHttpRequest(1);	
	xmlHttp[1].onreadystatechange=LoadDetailsRequest;
	xmlHttp[1].open("GET",'materialsTransferoldtonewXml.php?RequestType=LoadDetails&newStyleId=' +URLEncode(newStyleId)+ '&oldStyle=' +URLEncode(oldStyle),true);
	xmlHttp[1].send(null);
}

	function LoadDetailsRequest()
	{
		if (xmlHttp[1].readyState==4)
		{
			if (xmlHttp[1].status==200)
			{						
			var XMLItemDescription	= xmlHttp[1].responseXML.getElementsByTagName("ItemDescription");
			var XMLColor			= xmlHttp[1].responseXML.getElementsByTagName("Color");
			var XMLSize				= xmlHttp[1].responseXML.getElementsByTagName("Size");
			var XMLBuyerPONO		= xmlHttp[1].responseXML.getElementsByTagName("BuyerPONO");
			var XMLUnit				= xmlHttp[1].responseXML.getElementsByTagName("Unit");
			var XMLMatDetailID		= xmlHttp[1].responseXML.getElementsByTagName("MatDetailID");
			var XMLQty				= xmlHttp[1].responseXML.getElementsByTagName("Qty");
			var tblMain				= document.getElementById('tblMain');
			
			for(loop=0;loop<XMLMatDetailID.length;loop++)
			{
				var lastRow 		= tblMain.rows.length;	
				var row 			= tblMain.insertRow(lastRow);				
				
				var cell0 = row.insertCell(0);
				cell0.className ="normalfntMid";				
				cell0.innerHTML = "<input type=\"checkbox\">";
								
				var cellDescription = row.insertCell(1);
				cellDescription.className ="normalfnt";
				cellDescription.id =XMLMatDetailID[loop].childNodes[0].nodeValue;
				cellDescription.innerHTML =XMLItemDescription[loop].childNodes[0].nodeValue;
				
						
				var cellIBuyerPoNo = row.insertCell(2);
				cellIBuyerPoNo.className ="normalfntMid";			
				cellIBuyerPoNo.innerHTML =XMLBuyerPONO[loop].childNodes[0].nodeValue;
				
						
				var cellColor = row.insertCell(3);
				cellColor.className ="normalfntMidSML";
				cellColor.innerHTML =XMLColor[loop].childNodes[0].nodeValue;
						
				var cellSize = row.insertCell(4);
				cellSize.className ="normalfntMidSML";			
				cellSize.innerHTML =XMLSize[loop].childNodes[0].nodeValue;
				
						
				var cellUnits = row.insertCell(5);
				cellUnits.className ="normalfntMidSML";			
				cellUnits.innerHTML =XMLUnit[loop].childNodes[0].nodeValue;
				
						
				var cellQty = row.insertCell(6);
				cellQty.className ="normalfntMid";			
				cellQty.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" style=\"width:70px;text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+0+"\" />";	
				
				var cellQty = row.insertCell(7);
				cellQty.className ="normalfntMid";			
				cellQty.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" style=\"width:70px;text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+0+"\" />";	
										
				var celltxt = row.insertCell(8);
				celltxt.className ="normalfnt";	
				celltxt.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" style=\"width:150px\"  />";		
				}
			}
			hideBackGroundBalck();
		}
	}
//End - open popup window
	
function SelectAll(obj)
{
	var tbl 		= document.getElementById('tblMain');
	if(obj.checked)
	{
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[0].childNodes[0].checked=true;
		}
	}
	else
	{
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[0].childNodes[0].checked=false;
		}
	}
}
function SaveValidation()
{
		SaveDetails();
		document.getElementById("butSave").style.visibility="hidden";	

}

function SaveDetails(){
	Pub_recCount		= 0;
	var tbl				= document.getElementById('tblMain');
	var newToScno		= document.getElementById('cboFrom').value;
	var newStyleID		= document.getElementById('cboFromScno').value;
	var oldStyleID		= document.getElementById('cboTo').value;
	var oldToScno		= document.getElementById('cboToScno').value;	
	var mainStoreID		= document.getElementById('cboMainStores').value;
	var subStoreID		= document.getElementById('cboSubStore').value;
	var locationID		= document.getElementById('cboLocation').value;
	var biID			= document.getElementById('cboBins').value;
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var chkDisabled	= tbl.rows[loop].cells[0].childNodes[0].disabled;
		var chkChecked	= tbl.rows[loop].cells[0].childNodes[0].checked;
		if(chkChecked && chkDisabled==false)
		{
			var matDetailID	= tbl.rows[loop].cells[1].id;
			var buyerPoNo	= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var color		= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var size		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var units		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var transQty	= tbl.rows[loop].cells[6].childNodes[0].value;
			var unitPrice	= tbl.rows[loop].cells[7].childNodes[0].value;
			var remarks		= tbl.rows[loop].cells[8].childNodes[0].value;		
			Pub_recCount	++;
		createXMLHttpRequest(loop);
		xmlHttp[loop].open("GET",'materialsTransferoldtonewdb.php?RequestType=SaveDetails&oldStyleID=' +URLEncode(oldStyleID)+ '&matDetailID=' +matDetailID+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&color=' +URLEncode(color)+ '&size=' +size+ '&units=' +units+ '&transQty=' +transQty+ '&unitPrice=' +unitPrice+'&remarks=' +URLEncode(remarks)+ '&oldToScno=' +oldToScno+ '&mainStoreID=' +mainStoreID+ '&subStoreID=' +subStoreID+ '&locationID=' +locationID+ '&biID=' +biID+ '&newStyleID=' +URLEncode(newStyleID)+ '&newToScno=' +newToScno ,true);
		xmlHttp[loop].send(null);	
		}
	}
	alert(Pub_recCount + " Records saved");	
}

function LoadSubStores(obj){	
	createXMLHttpRequest(2);	
	xmlHttp[2].onreadystatechange=LoadSubStoresRequest;
	xmlHttp[2].open("GET",'materialsTransferoldtonewXml.php?RequestType=LoadSubStores&mainStoreId=' +obj ,true);
	xmlHttp[2].send(null);
	}
	
	function LoadSubStoresRequest(){
		if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200){
			RomoveData('cboSubStore');
			RomoveData('cboLocation');
			RomoveData('cboBins');
			document.getElementById('cboSubStore').innerHTML = xmlHttp[2].responseText;
		}
	}
	
function LoadLocation(obj){
	var mainStoreId = document.getElementById('cboMainStores').value;
	createXMLHttpRequest(3);	
	xmlHttp[3].onreadystatechange=LoadLocationRequest;
	xmlHttp[3].open("GET",'materialsTransferoldtonewXml.php?RequestType=LoadLocation&mainStoreId=' +mainStoreId+ '&subStoreId=' +obj ,true);
	xmlHttp[3].send(null);
	}
	
	function LoadLocationRequest(){
		if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200){
			RomoveData('cboLocation');
			RomoveData('cboBins');
			document.getElementById('cboLocation').innerHTML = xmlHttp[3].responseText;
		}
	}
	
function LoadBins(obj){
	var mainStoreId = document.getElementById('cboMainStores').value;
	var subStoresId 	= document.getElementById('cboSubStore').value;
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange=LoadBinsRequest;
	xmlHttp[4].open("GET",'materialsTransferoldtonewXml.php?RequestType=LoadBins&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoresId+ '&locationId=' +obj ,true);
	xmlHttp[4].send(null);
	}
	
	function LoadBinsRequest(){
		if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200){
			RomoveData('cboBins');			
			document.getElementById('cboBins').innerHTML = xmlHttp[4].responseText;
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
   popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
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