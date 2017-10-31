var xmlHttp;
var xmlHttp1=[];
var xmlHttp=[];
function createXMLHttpRequest() 
{
	try
	 {
		  xmlHttp=new XMLHttpRequest();
	 }
	catch(e)
	 {
		 
		 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch(e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
function createXMLHttpRequest1(index) 
{
	try
	 {
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {		 
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
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
		
		url=url+"&txtMaterial="+document.getElementById("txtMaterial").value;
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

		
		

	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange=stateChanged;
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);	
	
}

function stateChanged() 
 { 	
   if (xmlHttp1[0].readyState==4 && xmlHttp1[0].status==200)
	{	
       alert(xmlHttp1[0].responseText);
		   		  		  
  ClearForm();
		  		  
	 }
   }
function GetXmlHttpObject()
{
		  var xmlHttp=null;
			try
		 {
	
	   xmlHttp=new XMLHttpRequest();
		}
	   catch (e)
		{
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
function ClearshippingdataForm()
{   	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ClearshippingdataForm;
	 	xmlHttp.open("GET",'shipping.php?q=+obj', true);
		xmlHttp.send(null);  	
}	 
					 
function shippingdataForm1()
{	
	 if(xmlHttp.readyState == 4) 
	 { 
		 if(xmlHttp.status == 200) 
			{
			 document.getElementById("cboSearch").innerHTML  = xmlHttp.responseText;
			 document.getElementById('cboMode').focus();
			}
	   }		 
			 
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
	 {
		return false;
	 }
	var url="shippingmiddle.php?req=loadshipping&data="+obj.value;
	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange=loadRequest;
	xmlHttp1[0].index=obj;
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);	
}
function loadRequest()
{
	if (xmlHttp1[0].readyState==4 && xmlHttp1[0].status==200)
	{		
		var XMLStyleID=xmlHttp1[0].responseXML.getElementsByTagName("StyleID");
		var XMLPcsPerpack=xmlHttp1[0].responseXML.getElementsByTagName("PcsPerpack");		
	    var XMLMaterial=xmlHttp1[0].responseXML.getElementsByTagName("Material");
		var XMLDimension=xmlHttp1[0].responseXML.getElementsByTagName("Dimension");
		var XMLWashCode=xmlHttp1[0].responseXML.getElementsByTagName("WashCode");
		var XMLQty =xmlHttp1[0].responseXML.getElementsByTagName("Qty");
		var XMLVessal=xmlHttp1[0].responseXML.getElementsByTagName("Vessal");
		var XMLVessalData=xmlHttp1[0].responseXML.getElementsByTagName("VessalData");
		var XMLMode=xmlHttp1[0].responseXML.getElementsByTagName("Mode");
		var XMLGender=xmlHttp1[0].responseXML.getElementsByTagName("Gender");
		var XMLBuyer=xmlHttp1[0].responseXML.getElementsByTagName("Buyer");
		var XMLName=xmlHttp1[0].responseXML.getElementsByTagName("Name");
		var XMLShipmentTerm=xmlHttp1[0].responseXML.getElementsByTagName("ShipmentTerm");
		var XMLPayMode=xmlHttp1[0].responseXML.getElementsByTagName("PayMode");
		var XMLGarmentType=xmlHttp1[0].responseXML.getElementsByTagName("GarmentType");
		var XMLQuataCat=xmlHttp1[0].responseXML.getElementsByTagName("QuataCat");		
		var XMLFabricContent=xmlHttp1[0].responseXML.getElementsByTagName("FabricContent");
		var XMLCtnTypee=xmlHttp1[0].responseXML.getElementsByTagName("CtnType");
		var XMLBuyerPoNo=xmlHttp1[0].responseXML.getElementsByTagName("BuyerPoNo");
		var XMLDescription=xmlHttp1[0].responseXML.getElementsByTagName("Description");
		var XMLFabricRefNo=xmlHttp1[0].responseXML.getElementsByTagName("FabricRefNo");
		var XMLMill=xmlHttp1[0].responseXML.getElementsByTagName("Mill");
		
		
		document.getElementById('cboStyle').value = XMLStyleID[0].childNodes[0].nodeValue;
		document.getElementById('txtPcsPerpack').value = XMLPcsPerpack[0].childNodes[0].nodeValue;
		document.getElementById('txtMaterial').value = XMLMaterial[0].childNodes[0].nodeValue;		
		document.getElementById('textDimension').value = XMLDimension[0].childNodes[0].nodeValue;
		document.getElementById('textWashCode').value = XMLWashCode[0].childNodes[0].nodeValue;
		document.getElementById('textQty').value = XMLQty[0].childNodes[0].nodeValue;
		document.getElementById('textVessal').value = XMLVessal[0].childNodes[0].nodeValue;
		document.getElementById('textVessalData').value = XMLVessalData[0].childNodes[0].nodeValue;
		document.getElementById('cboMode').value = XMLMode[0].childNodes[0].nodeValue;
		document.getElementById('cboGender').value = XMLGender[0].childNodes[0].nodeValue;		
		document.getElementById('txtBuyers').value = XMLBuyer[0].childNodes[0].nodeValue;		
		document.getElementById('txtBuyer').value = XMLName[0].childNodes[0].nodeValue;
		document.getElementById('cboShipmentTerm').value = XMLShipmentTerm[0].childNodes[0].nodeValue;		
		document.getElementById('cboPaymentTerm').value = XMLPayMode[0].childNodes[0].nodeValue;		
		document.getElementById('txtGarmentType').value = XMLGarmentType[0].childNodes[0].nodeValue;
		document.getElementById('txtQuataCat').value = XMLQuataCat[0].childNodes[0].nodeValue;		
//		document.getElementById('textFabricContent').value = XMLFabricContent[0].childNodes[0].nodeValue;
		document.getElementById('textCtnType').value = XMLCtnTypee[0].childNodes[0].nodeValue;
		document.getElementById('txtBuyerPoNo').value = XMLBuyerPoNo[0].childNodes[0].nodeValue;
		document.getElementById('textDescription').value = XMLDescription[0].childNodes[0].nodeValue;
		document.getElementById('textFabricRefNo').value = XMLFabricRefNo[0].childNodes[0].nodeValue;
		document.getElementById('cboMill').value = XMLMill[0].childNodes[0].nodeValue;
	}
} 
function DeleteData(strCommand)
{
		
xmlHttp=GetXmlHttpObject();
if (xmlHttp1[0]==null)
  {
	  alert ("Browser does not support HTTP Request");
	  return;
  }
     strCommand=="Delete"                    
	var url="shipping.php";
	url=url+"?q="+strCommand;				
	url=url+"&cboSearch="+document.getElementById("cboSearch").value;	
   
	xmlHttp1[0].onreadystatechange=stateChanged;	
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);
}
	
function ConfirmDelete(strCommand)
{
		if(document.getElementById('cboSearch').value=="")
		{
			alert("Please select \"Order No\".");
		}
		else
		{
			var orderNo = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
			var r=confirm("Are you sure you want to delete " +orderNo+" ?");
			if (r==true)		
				DeleteData(strCommand);
		}
	
}

function loadGenderPopUp()
{
	/*var url  = "../shipping/gender.php?";
	inc('../shipping/shipping.js');
	var W	= 170;
	var H	= 160;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeGenderPopUp";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete);	*/
	var url="../shipping/gender.php"
	htmlobj=$.ajax({url:url,async:false});
	drawPopupArea(500,200,'frmPopEdit');
	document.getElementById("frmPopEdit").innerHTML=htmlobj.responseText;
	
}

function closeGenderPopUp(id)
{   
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=loadGenderRequest;
	xmlHttp.open("GET",'/gapro/washing/addins/shipping/shipping.php?req=LoadGender',true);
   	xmlHttp.send(null);
}

function loadGenderRequest()
{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		  {
			 var XMLText = xmlHttp.responseText;			
		   }
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
function createXMLHttpRequests(index)
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

function butCommandas(objName)
{
	if(objName=="New")
	{
		clearForm()
	}
	if(objName == "Save")
	{		
		var url="";
		var genderCode=document.getElementById('textGenderCode');
		var description=document.getElementById('textaDescription');		
		var cboSearch=document.getElementById('gender_cboSearch');
		if(cboSearch.value.trim()!="")
		{
			
			url="gender_db.php?req=update&cboVal="+cboSearch.value.trim();
		}
		else
		{
			url="gender_db.php?req=save";
		}
		if(document.getElementById("chkActive").checked==true)
		{
			var intStatus = 1;	
		}
		else
		{
			var intStatus = 0; 
		}
		
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
		createXMLHttpRequests(0);
		xmlHttp[0].onreadystatechange = stateChangesd;
		xmlHttp[0].open("GET",url,true);
		xmlHttp[0].send(null);
		
	}
}
function stateChangesd()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
	{
	 var XMLText = xmlHttp[0].responseText;
	 alert(XMLText);
	 clearForm();
	 //LoadDetail("loadAll")
	 return false;
	}
}

function clearForm()
{
	document.getElementById('frmGender').reset();
}

function LoadInformation(obj)
{
	
	if(obj=="loadAll")
	{
		var url="gendersmiddle.php?req=LoadgenderCbo";
	}
	else
	
		if(obj.value.trim()=="")
		{
		clearForm();
		return false;
		}
		var url="gendersmiddle.php?req=Loadgender&data="+obj.value;
	

	createXMLHttpRequests(0);
	xmlHttp[0].onreadystatechange=loadRequests;
	xmlHttp[0].open("GET",url,true);
	xmlHttp[0].send(null);	
}


function loadRequests()
{
	if (xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
	{		
		
		var XMLGenderCode=xmlHttp[0].responseXML.getElementsByTagName("GenderCode");
		var XMLID=xmlHttp[0].responseXML.getElementsByTagName("intGenderId");
		var XMLStatus = xmlHttp[0].responseXML.getElementsByTagName("Status");
		
		if(XMLID.length == 0)
		{
			var XMLDescription=xmlHttp[0].responseXML.getElementsByTagName("Description");
			document.getElementById('textGenderCode').value = XMLGenderCode[0].childNodes[0].nodeValue;
			document.getElementById('textaDescription').value = XMLDescription[0].childNodes[0].nodeValue;
			
			if(XMLStatus[0].childNodes[0].nodeValue==1)
			document.getElementById("chkActive").checked=true;	
		else
			document.getElementById("chkActive").checked=false;	
			
		}
		else
		{
			document.getElementById("gender_cboSearch").innerHtml="";
			
			for(var i=0; i<XMLGenderCode.length; i++)
			{
				var opt = document.createElement("option");
				opt.value = XMLID[i].childNodes[0].nodeValue;
				opt.text = XMLGenderCode[i].childNodes[0].nodeValue;
				document.getElementById("gender_cboSearch").options.add(opt);
				
			}
		}
		
	}
}

function SaveValidation()
{
	/*if(trim(document.getElementById('cboStyle').value)=="")
	{
		alert("Please select \"Style ID\".");
		document.getElementById('cboStyle').focus();
		return false;
	}*/			
	 if(trim(document.getElementById('txtPcsPerpack').value)=="")
	{
		alert("Please enter \"Pcs Per Pack\".");
		document.getElementById('txtPcsPerpack').select();
		return false;
	}
	else if(trim(document.getElementById('txtMaterial').value)=="")
	{
		alert("Please enter \"Material\".");
		document.getElementById('txtMaterial').focus();
		return false;
	}
	else if(trim(document.getElementById('textDimension').value)=="")
	{
		alert("Please enter \"Dimension\".");
		document.getElementById('textDimension').focus();
		return false;
	}	
		
	else if(trim(document.getElementById('textWashCode').value)=="")
	{
		alert("Please enter \"Wash Code\".");
		document.getElementById('textWashCode').focus();
		return false;
	}
	else if(trim(document.getElementById('textQty').value)=="")
	{
		alert("Please enter \"Qty\".");
		document.getElementById('textQty').focus();
		return false;
	}
	else if(trim(document.getElementById('textVessal').value)=="")
	{
		alert("Please enter \"Vessal\".");
		document.getElementById('textVessal').focus();
		return false;
	}
	else if(trim(document.getElementById('textVessalData').value)=="")
	{
		alert("Please enter \"Vessal Data\".");
		document.getElementById('textVessalData').focus();
		return false;
	}
	
	else if(trim(document.getElementById('cboMode').value)=="")
	{
		alert("Please select \"Mode\".");
		document.getElementById('cboMode').focus();
		return false;
	}
	else if(trim(document.getElementById('cboGender').value)=="")
	{
		alert("Please select \"Gender\".");
		document.getElementById('cboGender').focus();
		return false;
	}
	
	else if(trim(document.getElementById('textFabricRefNo').value)=="")
	{
		alert("Please enter \"Fabric Ref No\".");
		document.getElementById('textFabricRefNo').focus();
		return false;
	}
	else if(trim(document.getElementById('txtBuyers').value)=="")
	{
		alert("Please enter \"Buyer\".");
		document.getElementById('txtBuyers').focus();
		return false;
	}
	else if(trim(document.getElementById('txtBuyer').value)=="")
	{
		alert("Please enter \"Buyer\".");
		document.getElementById('txtBuyer').focus();
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
	else if(trim(document.getElementById('textFabricContent').value)=="")
	{
		alert("Please enter \"Fabric Content\".");
		document.getElementById('textFabricContent').focus();
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