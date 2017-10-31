var xmlHttp = [];

function createXMLHttpRequest(index){
	if (window.ActiveXObject){
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest){
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function ClearForm(){	
	setTimeout("location.reload(true);",0);
	return true;
}

function GetDetails(){
	var SearchID	= document.getElementById('cboSearch').value;
	
	createXMLHttpRequest(1);	
	xmlHttp[1].onreadystatechange = GetDetailsRequest;
	xmlHttp[1].open("GET" ,'deliverytermmiddle.php?RequestType=GetDetails&SearchID=' +SearchID ,true);
	xmlHttp[1].send(null);
}
	function GetDetailsRequest(){
		if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200){
			var XMLCode	= xmlHttp[1].responseXML.getElementsByTagName("DeliveryCode")[0].childNodes[0].nodeValue;
				document.getElementById('txtDeliveryCode').value = XMLCode;
				
			var XMLName	= xmlHttp[1].responseXML.getElementsByTagName("DeliveryName")[0].childNodes[0].nodeValue;
				document.getElementById('txtDeliveryName').value = XMLName;
			
		}
	}

function SaveValidation(){
	var DeliveryCode	= document.getElementById('txtDeliveryCode').value;
	var DeliveryName	= document.getElementById('txtDeliveryName').value;
	
	createXMLHttpRequest(2);	
	xmlHttp[2].onreadystatechange = SaveValidationRequest;
	xmlHttp[2].open("GET" ,'deliverytermmiddle.php?RequestType=SaveValidation&DeliveryCode=' +URLEncode(DeliveryCode) ,true);
	xmlHttp[2].send(null);	
}
	function SaveValidationRequest(){
		if(xmlHttp[2].readyState == 4 && xmlHttp[2].status == 200){
			var XMLValidate	= xmlHttp[2].responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
			if(XMLValidate=="TRUE")
			{
				Update();
			}
			else
			{
				Save();
			}
		}
	}

function Update(){
	var DeliveryCode	= document.getElementById('txtDeliveryCode').value;
	var DeliveryName	= document.getElementById('txtDeliveryName').value;
	
	createXMLHttpRequest(3);	
	xmlHttp[3].onreadystatechange = UpdateRequest;
	xmlHttp[3].open("GET" ,'deliverytermdb.php?RequestType=Update&DeliveryCode=' +URLEncode(DeliveryCode)+ '&DeliveryName=' +URLEncode(DeliveryName) ,true);
	xmlHttp[3].send(null);	
}
	function UpdateRequest(){
		if(xmlHttp[3].readyState == 4 && xmlHttp[3].status == 200){
			
			if(xmlHttp[3].responseText==1){
				alert("Package code updated.");
				if(ClearForm())
				{
					document.getElementById('txtDeliveryCode').focus();
				}
			}
			else
				alert("Sorry!\nError Occured while updating data\nPlease check the details and save it again.");
		}
	}
	
function Save(){
	var DeliveryCode	= document.getElementById('txtDeliveryCode').value;
	var DeliveryName	= document.getElementById('txtDeliveryName').value;
	
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange = SaveRequest;
	xmlHttp[4].open("GET" ,'deliverytermdb.php?RequestType=Save&DeliveryCode=' +URLEncode(DeliveryCode)+ '&DeliveryName=' +URLEncode(DeliveryName) ,true);
	xmlHttp[4].send(null);	
}
	function SaveRequest(){
		if(xmlHttp[4].readyState == 4 && xmlHttp[4].status == 200){
			
			if(xmlHttp[4].responseText==1){
				alert("Package code saved.");
				if(ClearForm())
				document.getElementById('txtDeliveryCode').focus();
			}
			else
				alert("Sorry\nError Occured while saving data\nPlease check the details and save it again.");
		}
	}