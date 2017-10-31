
var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
	
var incr =0;
	
//var $styleId = "";
var $styleId = "Eventschedule";

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
function createAltXMLHttpRequestArray(index) 
{
    if (window.ActiveXObject) 
    {
        altxmlHttpArray[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttpArray[index] = new XMLHttpRequest();
    }
}
function getEventScheduleMethod()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleGetEventScheduleMethod;
	xmlHttp.open("GET", 'EventSchedule.php?RequestType=EventScheduleMethod&StyleID=' + URLEncode($styleId) , true);
	xmlHttp.send(null);
}

function HandleGetEventScheduleMethod()
{	
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        { 		
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("ScheduleMethod");
			var EventScheduleMethod = XMLResult[0].childNodes[0].nodeValue;
			switch (EventScheduleMethod)
			{
				case "SE":
						getBaseDelivery($styleId,EventScheduleMethod);
					break;
					case "SB":
							getBaseDeliveryBPO($styleId,EventScheduleMethod);
						break;
						case "SBD":
								getDeliveriesBPO($styleId,EventScheduleMethod);
							break;
							case "SD":
									getDeliveries($styleId,EventScheduleMethod);
								break;
			}			
		}
	}
}

/* SE - Style, BaseDelivery DeliverySchedule wise Event Schedule */
function getBaseDelivery(styleId,EventScheduleMethod)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGetBaseDelivery;
	altxmlHttpArray[incr].open("GET", 'EventSchedule.php?RequestType=BaseDelivery&StyleID=' + URLEncode(styleId) +'&EventScheduleMethod=' + EventScheduleMethod , true);
	altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleGetBaseDelivery()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        { 	
			var XMLEventScheduleMethod = altxmlHttpArray[0].responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLBaseDeliveryDate = altxmlHttpArray[0].responseXML.getElementsByTagName("BaseDeliveryDate");
			var XMLDeliveryBPO = altxmlHttpArray[this.index].responseXML.getElementsByTagName("DeliveryBPO");
			
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;	
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			var DeliveryBPO = XMLDeliveryBPO[0].childNodes[0].nodeValue;

			EventScheduleProcess(EventScheduleMethod,BaseDeliveryDate,DeliveryBPO);
		}
	}	
}

/*SD - Style, DeliverySchedule wise Event schedule (without mentioning BaseDelivery)*/
function getDeliveries(styleId,EventScheduleMethod)
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleGetDeliveries;
	altxmlHttp.open("GET", 'EventSchedule.php?RequestType=GetDeliveries&StyleID=' + URLEncode(styleId) +'&EventScheduleMethod=' + EventScheduleMethod , true);
	altxmlHttp.send(null);
}

function HandleGetDeliveries()
{
	
	if(altxmlHttp.readyState == 4) 
    {
		if(altxmlHttp.status == 200) 
        { 	
			var XMLEventScheduleMethod = altxmlHttp.responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLDeliveryDate = altxmlHttp.responseXML.getElementsByTagName("DeliveryDate");
			
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;	
			for ( var loop = 0; loop < XMLDeliveryDate.length; loop++)
			 {
				var DeliveryDate = XMLDeliveryDate[loop].childNodes[0].nodeValue;	
				
				EventScheduleProcess(EventScheduleMethod,DeliveryDate);
			 }
		}
	}	
}

/* SB - Style, Buyer PO wise Event Schedule */
function getBaseDeliveryBPO(styleId,EventScheduleMethod)
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleGetBaseDeliveryBPO;
	altxmlHttp.open("GET", 'EventSchedule.php?RequestType=BaseDeliveryBPO&StyleID=' + URLEncode(styleId) + '&EventScheduleMethod=' + EventScheduleMethod , true);
	altxmlHttp.send(null);
}

function HandleGetBaseDeliveryBPO()
{
	if(altxmlHttp.readyState == 4) 
    {
		if(altxmlHttp.status == 200) 
        { 	
			var XMLEventScheduleMethod = altxmlHttp.responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLBaseDeliveryBPODate = altxmlHttp.responseXML.getElementsByTagName("BaseDeliveryBPODate");
			
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;
			
			for ( var loop = 0; loop < XMLBaseDeliveryBPODate.length; loop++)
			 {
				var BaseDeliveryBPODate = XMLBaseDeliveryBPODate[loop].childNodes[0].nodeValue;
				
				EventScheduleProcess(EventScheduleMethod,BaseDeliveryBPODate);
			 }
		}
	}	
}

/* SBD - Style, Buyer PO, Delivery wise Event Schedule */
function getDeliveriesBPO(styleId,EventScheduleMethod)
{
	createAltXMLHttpRequestArray(0);
	altxmlHttpArray[0].onreadystatechange = HandleGetDeliveriesBPO;
	altxmlHttpArray[0].open("GET", 'EventSchedule.php?RequestType=DeliveriesBPO&StyleID=' + URLEncode(styleId) + '&EventScheduleMethod=' + EventScheduleMethod , true);
	altxmlHttpArray[0].send(null);
	incr ++;
}

function HandleGetDeliveriesBPO()
{
	if(altxmlHttpArray[0].readyState == 4) 
    {
		if(altxmlHttpArray[0].status == 200) 
        { 	
			var XMLEventScheduleMethod = altxmlHttpArray[0].responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLDeliveryBPO = altxmlHttpArray[0].responseXML.getElementsByTagName("BuyerPONO");
			var XMLDeliveryBPODate = altxmlHttpArray[0].responseXML.getElementsByTagName("DeliveryBPODate");
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;
			
			for ( var loop = 0; loop < XMLDeliveryBPODate.length; loop++)
			 {
				 //alert(XMLDeliveryBPODate.length);
				var DeliveryBPO = XMLDeliveryBPO[loop].childNodes[0].nodeValue;
				var DeliveryBPODate = XMLDeliveryBPODate[loop].childNodes[0].nodeValue;
				
				EventScheduleProcess(EventScheduleMethod,DeliveryBPODate,DeliveryBPO);
			 }
		}
	}	
}


/* Process Event Schedule*/
function EventScheduleProcess(EventScheduleMethod,BaseDeliveryDate,DeliveryBPO)
{
	getEventTemplatesBuyer($styleId,BaseDeliveryDate,EventScheduleMethod,DeliveryBPO);
}

function getEventTemplatesBuyer(styleId,BaseDeliveryDate,EventScheduleMethod,DeliveryBPO)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGetEventTemplatesBuyer;
	altxmlHttpArray[incr].open("GET", 'EventSchedule.php?RequestType=StyleBuyer&StyleID=' + URLEncode(styleId) + '&BaseDeliveryDate=' + BaseDeliveryDate + '&EventScheduleMethod=' + EventScheduleMethod + '&DeliveryBPO=' + DeliveryBPO, true);
	altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleGetEventTemplatesBuyer()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        { 		
			var XMLBaseDeliveryDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BaseDeliveryDate");
			var XMLEventScheduleMethod = altxmlHttpArray[this.index].responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLDeliveryBPO = altxmlHttpArray[this.index].responseXML.getElementsByTagName("DeliveryBPO");
			
			var XMLBuyerID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BuyerID");
			
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;
			var DeliveryBPO = XMLDeliveryBPO[0].childNodes[0].nodeValue;
			
			var BuyerID = XMLBuyerID[0].childNodes[0].nodeValue;		
				
			getLeadTime($styleId,BaseDeliveryDate,BuyerID,EventScheduleMethod,DeliveryBPO);
		}
	}	
}

function getLeadTime(styleId,BaseDeliveryDate,BuyerID,EventScheduleMethod,DeliveryBPO)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGetLeadTime;
	altxmlHttpArray[incr].open("GET", 'EventSchedule.php?RequestType=StyleDeliveryLeadTime&StyleID=' + URLEncode(styleId) + '&BaseDeliveryDate=' + BaseDeliveryDate + '&BuyerID=' + BuyerID + '&EventScheduleMethod=' + EventScheduleMethod + '&DeliveryBPO=' + DeliveryBPO, true);
	altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleGetLeadTime()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLBaseDeliveryDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BaseDeliveryDate");
			var XMLEventScheduleMethod = altxmlHttpArray[this.index].responseXML.getElementsByTagName("EventScheduleMethod");
			var XMLDeliveryBPO = altxmlHttpArray[this.index].responseXML.getElementsByTagName("DeliveryBPO");
			var XMLBuyerID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BuyerID");
			var XMLLeadTime = altxmlHttpArray[this.index].responseXML.getElementsByTagName("LeadTime");
			
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			var EventScheduleMethod = XMLEventScheduleMethod[0].childNodes[0].nodeValue;
			var DeliveryBPO = XMLDeliveryBPO[0].childNodes[0].nodeValue;
			var BuyerID = XMLBuyerID[0].childNodes[0].nodeValue;
			var LeadTime = XMLLeadTime[0].childNodes[0].nodeValue;
						
			BaseDeliveryDate = BaseDeliveryDate.substring(0,10);
		
			if (EventScheduleMethod == "SBD")
			{
				SaveEventScheduleHeader_SBD($styleId,BuyerID,LeadTime,BaseDeliveryDate,DeliveryBPO);
			}
			else
			{
				SaveEventScheduleHeader($styleId,BuyerID,LeadTime,BaseDeliveryDate);
			}
			
		}
	}	
}

function SaveEventScheduleHeader(styleId,BuyerID,LeadTime,BaseDeliveryDate)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
    altxmlHttpArray[incr].onreadystatechange = HandleSaveEventScheduleHeader;
    altxmlHttpArray[incr].open("GET",'EventSchedule.php?RequestType=SaveEventScheduleHeader&styleId=' + URLEncode(styleId) + '&BuyerID=' + BuyerID + '&LeadTime=' + LeadTime + '&BaseDeliveryDate=' + BaseDeliveryDate , true);
    altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleSaveEventScheduleHeader()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        {	
			var XMLSave = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Save");
			var XMLMax = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Max");
			var XMLBuyerID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BuyerID");
			var XMLLeadTime = altxmlHttpArray[this.index].responseXML.getElementsByTagName("LeadTime");
			var XMLBaseDeliveryDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BaseDeliveryDate");
			
			var Max = XMLMax[0].childNodes[0].nodeValue;
			var BuyerID = XMLBuyerID[0].childNodes[0].nodeValue;
			var LeadTime = XMLLeadTime[0].childNodes[0].nodeValue;
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			
			if(XMLSave[0].childNodes[0].nodeValue == "True")
			{
				getEventTemplates(BuyerID,LeadTime,BaseDeliveryDate,Max);
			}
			else
			{
				alert("The event schedule header save failed.");	
			}
		}
	}
}

/* SBD Header Save */
function SaveEventScheduleHeader_SBD(styleId,BuyerID,LeadTime,BaseDeliveryDate,DeliveryBPO)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleSaveEventScheduleHeader_SBD;
    altxmlHttpArray[incr].open("GET",'EventSchedule.php?RequestType=SaveEventScheduleHeaderSBD&styleId=' + URLEncode(styleId) + '&BuyerID=' + BuyerID + '&LeadTime=' + LeadTime + '&BaseDeliveryDate=' + BaseDeliveryDate + '&DeliveryBPO=' + DeliveryBPO, true);
    altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleSaveEventScheduleHeader_SBD()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        {	
			var XMLSave = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Save");
			var XMLMax = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Max");
			var XMLBuyerID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BuyerID");
			var XMLLeadTime = altxmlHttpArray[this.index].responseXML.getElementsByTagName("LeadTime");
			var XMLBaseDeliveryDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BaseDeliveryDate");
			
			var Max = XMLMax[0].childNodes[0].nodeValue;
			var BuyerID = XMLBuyerID[0].childNodes[0].nodeValue;
			var LeadTime = XMLLeadTime[0].childNodes[0].nodeValue;
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			
			if(XMLSave[0].childNodes[0].nodeValue == "True")
			{
				getEventTemplates(BuyerID,LeadTime,BaseDeliveryDate,Max);
			}
			else
			{
				alert("The event schedule header save failed.");	
			}
		}
	}
}


function getEventTemplates(BuyerID,LeadTime,BaseDeliveryDate,Max)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGetEventTemplates;
	altxmlHttpArray[incr].open("GET", 'EventSchedule.php?RequestType=EventTemplates&BuyerID=' + BuyerID +'&LeadTime=' + LeadTime +'&BaseDeliveryDate=' + BaseDeliveryDate + '&Max=' + Max , true);
	altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleGetEventTemplates()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        { 	
			var XMLMax = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Max");
			var XMLBaseDeliveryDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BaseDeliveryDate");
			var XMLEventID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("EventID");
			var XMLOffset = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Offset");
			
			var Max = XMLMax[0].childNodes[0].nodeValue;
			var BaseDeliveryDate = XMLBaseDeliveryDate[0].childNodes[0].nodeValue;
			
			for ( var loop = 0; loop < XMLEventID.length; loop ++)
			 {
				var EventID = XMLEventID[[loop]].childNodes[0].nodeValue;
				var Offset  = XMLOffset[[loop]].childNodes[0].nodeValue;
				
				var dt = new Date(parseInt(BaseDeliveryDate.split("-")[0]),parseInt(BaseDeliveryDate.split("-")[1])-1,parseInt(BaseDeliveryDate.split("-")[2].split(" ")[0]) );
				dt.setDate(dt.getDate() + parseInt(Offset));
				
				var EstDateY = dt.getFullYear();
				var EstDateM = dt.getMonth() + 1;
				var EstDateD = dt.getDate();
				
				var EstDate = parseInt(EstDateY) + "-" + parseInt(EstDateM) + "-" + parseInt(EstDateD) ;
				
				SaveEventScheduleDetails(Max,EventID,EstDate);
			 }
		}
	}	
}

/*******************/

function SaveEventScheduleDetails(Max,EventID,EstDate)
{
	createAltXMLHttpRequestArray(incr);
 	altxmlHttpArray[incr].index = incr;
   	altxmlHttpArray[incr].onreadystatechange = HandleSaveEventScheduleDetails;
    altxmlHttpArray[incr].open("GET",'EventSchedule.php?RequestType=SaveEventScheduleDetails&Max=' + Max + '&EventID=' + EventID + '&EstDate=' + EstDate , true);
    altxmlHttpArray[incr].send(null);
	incr ++;
}

function HandleSaveEventScheduleDetails()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
		if(altxmlHttpArray[this.index].status == 200) 
        {	
			var XMLSaveDets = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Save");
			
//			var XMLLengthY = altxmlHttpArray[this.index].responseXML.getElementsByTagName("LengthY");
//			var XMLCounterX = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CounterX");		
			if(XMLSaveDets[0].childNodes[0].nodeValue == "True")
			{
				//alert("The event schedule save successful.");	
			}
			else
			{
				alert("The event schedule details save failed.");	
			}
				
		}
	}
}