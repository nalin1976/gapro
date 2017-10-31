var xmlHttp;
var xmlHttp1=[];
var xmlHttp=[];
var mainArrayIndex 		= 0;
var Materials 			= [];

function LoadOrderNo(obj)
{
	var url 	= "shippingmiddle.php?req=LoadOrderNo&StyleNo="+obj;
	var htmlobj  = $.ajax({url:url,async:false});
	document.getElementById('cboSearch').innerHTML = htmlobj.responseText;
}

function SetOrderNo(obj)
{
	$('#cboSearch').val(obj.value);
}

function SetSCNo(obj)
{
	$('#cboSCNo').val(obj.value);
}

function SaveShipingData()
{
	if(!SaveValidation())
		return;	
	strCommand="Save";		
	var url="shipping.php";
	url=url+"?q="+strCommand;
	
	url=url+"&cboSearch="+document.getElementById("cboSearch").value;
	url=url+"&cboStyle="+document.getElementById("cboStyle").value;
	url=url+"&txtPcsPerpack="+document.getElementById("txtPcsPerpack").value;	
	url=url+"&material="+document.getElementById("txtMaterial").value;
	url=url+"&textDimension="+document.getElementById("textDimension").value;
	url=url+"&textWashCode="+document.getElementById("textWashCode").value;
	url=url+"&textQty="+document.getElementById("textQty").value;
	url=url+"&textVessal="+document.getElementById("textVessal").value;
	url=url+"&textVessalData="+document.getElementById("textVessalData").value;			
	url=url+"&cboGender="+document.getElementById("cboGender").value;
	url=url+"&textFabricRefNo="+document.getElementById("textFabricRefNo").value;		
	url=url+"&cboMode="+document.getElementById("cboMode").value;
	url=url+"&txtBuyers="+document.getElementById("txtBuyers").value;
	url=url+"&txtBuyer="+document.getElementById("txtBuyer").value;
	url=url+"&txtBuyerPoNo="+document.getElementById("txtBuyerPoNo").value;			
	url=url+"&cboShipmentTerm="+document.getElementById("cboShipmentTerm").value;
	url=url+"&cboPaymentTerm="+document.getElementById("cboPaymentTerm").value;
	url=url+"&txtGarmentType="+document.getElementById("txtGarmentType").value;
	url=url+"&txtQuataCat="+document.getElementById("txtQuataCat").value;	
	url=url+"&textFabricContent="+document.getElementById("textFabricContent").value;
	url=url+"&textDescription="+document.getElementById("textDescription").value;
	url=url+"&textCtnType="+document.getElementById("textCtnType").value;
	url=url+"&cboMill="+document.getElementById("cboMill").value;	

	htmlobj=$.ajax({url:url,async:false});	
	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{
		var details = Materials[loop];
		if(details!=null)
		{
			var url = "shipping.php?q=SaveDest";
			url += "&DestId="+details[0];
			url += "&Qty="+details[1];	
			url += "&orderId="+document.getElementById("cboSearch").value;
			htmlobj1=$.ajax({url:url,async:false});
		}
	}
	stateChanged(htmlobj);
	document.getElementById('butDelete').style.display = 'none';
}

function stateChanged(htmlobj) 
{ 	
	alert(htmlobj.responseText);		   		  		  
	ClearForm();
}
							 			
function ClearForm()
{	
	document.frmShippingdata.reset();
	loadCombo('SELECT  intStyleId,strOrderNo FROM orders where intStatus not in(13,14) order by strOrderNo','cboSearch');
	document.getElementById('cboSearch').focus();
}
  
function loadDetails(obj)
{
	if(obj.value.trim()=="")
		return false;
		
	var url="shippingmiddle.php?req=loadshipping&data="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	loadRequest(htmlobj,obj);
}

function loadRequest(htmlobj,index)
{
	var XMLStyleID			= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLPcsPerpack		= htmlobj.responseXML.getElementsByTagName("PcsPerpack");		
	var XMLMaterial			= htmlobj.responseXML.getElementsByTagName("Material");
	var XMLDimension		= htmlobj.responseXML.getElementsByTagName("Dimension");
	var XMLWashCode			= htmlobj.responseXML.getElementsByTagName("WashCode");
	var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLVessal			= htmlobj.responseXML.getElementsByTagName("Vessal");
	var XMLVessalData		= htmlobj.responseXML.getElementsByTagName("VessalData");
	var XMLMode				= htmlobj.responseXML.getElementsByTagName("Mode");
	var XMLGender			= htmlobj.responseXML.getElementsByTagName("Gender");
	var XMLBuyer			= htmlobj.responseXML.getElementsByTagName("Buyer");
	var XMLName				= htmlobj.responseXML.getElementsByTagName("Name");
	var XMLShipmentTerm		= htmlobj.responseXML.getElementsByTagName("ShipmentTerm");
	var XMLPayMode			= htmlobj.responseXML.getElementsByTagName("PayMode");
	var XMLGarmentType		= htmlobj.responseXML.getElementsByTagName("GarmentType");
	var XMLQuataCat			= htmlobj.responseXML.getElementsByTagName("QuataCat");		
	var XMLFabricContent	= htmlobj.responseXML.getElementsByTagName("FabricContent");
	var XMLCtnTypee			= htmlobj.responseXML.getElementsByTagName("CtnType");
	var XMLBuyerPoNo		= htmlobj.responseXML.getElementsByTagName("BuyerPoNo");
	var XMLDescription		= htmlobj.responseXML.getElementsByTagName("Description");
	var XMLFabricRefNo		= htmlobj.responseXML.getElementsByTagName("FabricRefNo");
	var XMLMill				= htmlobj.responseXML.getElementsByTagName("Mill");
	var XMLType				= htmlobj.responseXML.getElementsByTagName("Type");	
		
	if(XMLStyleID.length <=0){
		alert("No record found to view details.");
		return;
	}
	
	document.getElementById('cboStyle').value 			= XMLStyleID[0].childNodes[0].nodeValue;
	document.getElementById('txtPcsPerpack').value 		= XMLPcsPerpack[0].childNodes[0].nodeValue;
	document.getElementById('txtMaterial').value 		= XMLMaterial[0].childNodes[0].nodeValue;		
	document.getElementById('textDimension').value 		= XMLDimension[0].childNodes[0].nodeValue;
	document.getElementById('textWashCode').value 		= XMLWashCode[0].childNodes[0].nodeValue;
	document.getElementById('textQty').value 			= XMLQty[0].childNodes[0].nodeValue;
	document.getElementById('textVessal').value 		= XMLVessal[0].childNodes[0].nodeValue;
	document.getElementById('textVessalData').value 	= XMLVessalData[0].childNodes[0].nodeValue;
	document.getElementById('cboMode').value 			= XMLMode[0].childNodes[0].nodeValue;
	document.getElementById('cboGender').value 			= XMLGender[0].childNodes[0].nodeValue;		
	document.getElementById('txtBuyers').value 			= XMLBuyer[0].childNodes[0].nodeValue;		
	document.getElementById('txtBuyer').value 			= XMLName[0].childNodes[0].nodeValue;
	document.getElementById('cboShipmentTerm').value 	= XMLShipmentTerm[0].childNodes[0].nodeValue;		
	document.getElementById('cboPaymentTerm').value 	= XMLPayMode[0].childNodes[0].nodeValue;		
	document.getElementById('txtGarmentType').value 	= XMLGarmentType[0].childNodes[0].nodeValue;
	document.getElementById('txtQuataCat').value 		= XMLQuataCat[0].childNodes[0].nodeValue;		
	document.getElementById('textCtnType').value 		= XMLCtnTypee[0].childNodes[0].nodeValue;
	document.getElementById('txtBuyerPoNo').value 		= XMLBuyerPoNo[0].childNodes[0].nodeValue;
	document.getElementById('textDescription').value 	= XMLDescription[0].childNodes[0].nodeValue;
	document.getElementById('textFabricRefNo').value 	= XMLFabricRefNo[0].childNodes[0].nodeValue;
	document.getElementById('cboMill').value 			= XMLMill[0].childNodes[0].nodeValue;
	
	if(XMLType[0].childNodes[0].nodeValue=='1')
		document.getElementById('butDelete').style.display = 'inline';
	else 
		document.getElementById('butDelete').style.display = 'none';
} 

function DeleteData(strCommand)
{		
	strCommand=="Delete"                    
	var url="shipping.php";
	url=url+"?q="+strCommand;				
	url=url+"&cboSearch="+document.getElementById("cboSearch").value;	
	
	htmlobj=$.ajax({url:url,async:false});
	stateChanged(htmlobj);
}
	
function ConfirmDelete()
{
var orderNo	= $("#cboSearch").val();
	if(orderNo=="")
	{
		alert("Please select 'Order No'.");
		$("#cboSearch").focus();
		return;
	}	
	if(!confirm("Are you sure you want to delete " +orderNo+" ?"))
		return;
		
	var url="shipping.php";
	url=url+"?q=Delete";				
	url=url+"&OrderNo="+orderNo;	
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseText);	
}

function loadGenderPopUp()
{
	var url="../shipping/gender.php"
	htmlobj=$.ajax({url:url,async:false});
	drawPopupArea(500,200,'frmPopEdit');
	document.getElementById("frmPopEdit").innerHTML=htmlobj.responseText;
}

function closeGenderPopUp(id)
{   
	closePopUpArea(id);
	var url = '/gapro/washing/addins/shipping/shipping.php?req=LoadGender';
	htmlobj=$.ajax({url:url,async:false});
	loadGenderRequest(htmlobj);
	var XMLText = htmlobj.responseText;	
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{		
	}	
}

function ViewShippingdataReport()
{	
	var cboSearch = document.getElementById('cboSearch').value;
	window.open("Shippingdatareport.php?",'frmwas_operators'); 
}

function ClearFormc()
{  
	    document.getElementById("cboSearch").value = "";
		document.getElementById("cboMode").value = "";
}

function ValidateSave()
{	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("strStyle").value;		
	var x_find = checkInField('orderdata','strStyle',x_name,'intStyleID',x_id);
	
	if(x_find)
	{
		alert(x_name+"is already exist.");	
		document.getElementById("cboSearch").focus();
		return;
	}
}

function butCommandas(objName)
{
	if(objName == "Save")
	{		
		var url="";
		var genderCode=document.getElementById('textGenderCode');
		var description=document.getElementById('textaDescription');		
		var cboSearch=document.getElementById('gender_cboSearch');
		if(cboSearch.value.trim()!="")
			url="gender_db.php?req=update&cboVal="+cboSearch.value.trim();
		else
			url="gender_db.php?req=save";
		
		if(document.getElementById("chkActive").checked==true)
			var intStatus = 1;	
		else
			var intStatus = 0; 
		
		url=url+"&intStatus="+intStatus;
		if(trim(document.getElementById('textGenderCode').value)=="")
		{
			alert("Please Fill \"Code\".");
			document.getElementById('textGenderCode').focus();
			return false;
		}				
		else if(trim(document.getElementById('textaDescription').value)=="")
		{
			alert("Please Fill \"Description\".");
			document.getElementById('textaDescription').focus();
			return false;
		}			
		url=url+"&genderCode="+genderCode.value+"&description="+description.value;
		htmlobj=$.ajax({url:url,async:false});
		alert(htmlobj.responseText);		
	}
}

function SaveValidation()
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select 'Order No'.");
		document.getElementById('cboSearch').focus();
		return false;
	}
 	else if(trim(document.getElementById('txtPcsPerpack').value)=="")
	{
		alert("Please enter 'Pcs Per Pack'.");
		document.getElementById('txtPcsPerpack').select();
		return false;
	}
	else if(trim(document.getElementById('textDimension').value)=="")
	{
		alert("Please enter 'Dimension'.");
		document.getElementById('textDimension').focus();
		return false;
	}		
	else if(trim(document.getElementById('textWashCode').value)=="")
	{
		alert("Please enter 'Wash Code'.");
		document.getElementById('textWashCode').focus();
		return false;
	}
	else if(trim(document.getElementById('textQty').value)=="")
	{
		alert("Please enter 'Qty'.");
		document.getElementById('textQty').focus();
		return false;
	}
	else if(trim(document.getElementById('textVessal').value)=="")
	{
		alert("Please enter 'Vessal'.");
		document.getElementById('textVessal').focus();
		return false;
	}
	else if(trim(document.getElementById('textVessalData').value)=="")
	{
		alert("Please enter 'Vessal Data'.");
		document.getElementById('textVessalData').focus();
		return false;
	}
	
	else if(trim(document.getElementById('cboMode').value)=="")
	{
		alert("Please select 'Mode'.");
		document.getElementById('cboMode').focus();
		return false;
	}
	else if(trim(document.getElementById('cboGender').value)=="")
	{
		alert("Please select \"Gender\".");
		document.getElementById('cboGender').focus();
		return false;
	}
	else if(trim(document.getElementById('txtBuyers').value)=="")
	{
		alert("Please enter \"Buyer\".");
		document.getElementById('txtBuyers').focus();
		return false;
	}	       		       
	else if(trim(document.getElementById('txtBuyerPoNo').value)=="")
	{
		alert("Please enter \"Buyer Po No\".");
		document.getElementById('txtBuyerPoNo').focus();
		return false;
	}
	else if(trim(document.getElementById('cboShipmentTerm').value)=="")
	{
		alert("Please select \"Shipment Term\".");
		document.getElementById('cboShipmentTerm').focus();
		return false ;
	}
	else if(trim(document.getElementById('cboPaymentTerm').value)=="")
	{
		alert("Please select \"Payment Term\".");
		document.getElementById('cboPaymentTerm').focus();
		return false ;
	}
		
	else if(trim(document.getElementById('txtGarmentType').value)=="")
	{
		alert("Please enter \"Garment Type\".");
		document.getElementById('txtGarmentType').focus();
		return false ;
	}
	else if(trim(document.getElementById('txtQuataCat').value)=="")
	{
		alert("Please enter \"Quota Cat\".");
		document.getElementById('txtQuataCat').focus();
		return false ;
	}
	else if(trim(document.getElementById('textDescription').value)=="")
	{
		alert("Please enter \"Description\".");
		document.getElementById('textDescription').focus();
		return false ;
	}		
	else if(trim(document.getElementById('textCtnType').value)=="")
	{
		alert("Please enter \"CTN Type\".");
		document.getElementById('textCtnType').focus();
		return false ;
	}
	else if(trim(document.getElementById('cboMill').value)=="")
	{
		alert("Please select \"Mill\".");
		document.getElementById('cboMill').focus();
		return false ;
	}
return true;
}

function AddNewDestinationRow(obj)
{
	var tblDest 	= document.getElementById("tblDestination");	
	var destCode 	= obj.cells[0].childNodes[0].nodeValue;
	var destName 	= obj.cells[1].childNodes[0].nodeValue;
	var destId	 	= obj.id;
	var check 		= true;
	
	for(var loop =1;loop<tblDest.rows.length;loop++)
	{
		var mainDestId = tblDest.rows[loop].id;
		if(mainDestId==destId)
			return;		
	}
	
	var lastRow = tblDest.rows.length;	
	var row = tblDest.insertRow(lastRow);
	row.className="bcgcolor-tblrowWhite";
	row.id=destId;
	
	var cellIssuelist = row.insertCell(0);
	cellIssuelist.className ="normalfntMid";
	cellIssuelist.innerHTML = "<img src=\"../images/del.png\" alt=\"delete\" title=\"Click here to delete\" onclick=\"RemoveDestRow(this)\"/>";
	
	var cellIssuelist = row.insertCell(1);
	cellIssuelist.className ="normalfntMid";
	cellIssuelist.innerHTML = "<input type=\"text\" class=\"txtbox\" value="+0+" style=\"width:60px;text-align:right\"/>";
	
	var cellIssuelist = row.insertCell(2);
	cellIssuelist.className ="normalfntRite";
	cellIssuelist.innerHTML = destCode;
	
	var cellIssuelist = row.insertCell(3);
	cellIssuelist.className ="normalfnt";
	cellIssuelist.innerHTML = destName;
	
	obj.parentNode.removeChild(obj);
}

function LoadDestination()
{
	var orderId	= $("#cboSearch").val();
	if(orderId=="")
	{
		alert("Please select 'Order No'.");
		$("#cboSearch").focus();
		return;
	}
	var url = "destination.php?styId="+orderId;
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeDestination";
	var tdPopUpClose = "prc_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}
function LoadAllDestination(styId){
	var orderId	= $("#cboSearch").val();
	var url  = "alldestination.php?orderId="+orderId;
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdDrHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeAllDestination";
	var tdPopUpClose = "dryPrc_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeDestination(id)
{
	closePopUpArea(id);
}

function closeAllDestination(id)
{
	closePopUpArea(id);
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function SaveDestination()
{
	var tbl = document.getElementById('tblDestination');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var details = [];
		details[0] = tbl.rows[loop].id; 	// destination Id
		details[1] = tbl.rows[loop].cells[1].childNodes[0].value; 			// qty
	
		Materials[loop] = details;
		mainArrayIndex ++ ;
	}
}

function RemoveDestRow(obj)
{
	var td = obj.parentNode;
	var tro = td.parentNode;
	tro.parentNode.removeChild(tro);
	Materials[obj.parentNode.parentNode.id] = null;
}