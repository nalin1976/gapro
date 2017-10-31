var xmlHTTP=[];

function generateRequest(index)
{
	if(window.ActiveXObjet)
		xmlHTTP[index]=new ActiveXObject("microsoft.XMLHTTP");
	else if(window.XMLHttpRequest)
		xmlHTTP[index]=new XMLHttpRequest();	
}

function getData()
{
	if(document.getElementById("cboInvoice").value!="")
	{
	generateRequest(0);
	var invoiceno=document.getElementById("cboInvoice").value;
	xmlHTTP[0].onreadystatechange=function()
	{
		if(xmlHTTP[0].readyState==4 && xmlHTTP[0].status==200){
			document.getElementById("txtCompany").value=xmlHTTP[0].responseXML.getElementsByTagName("company")[0].childNodes[0].nodeValue;
			document.getElementById("txtPortofDischarge").value=xmlHTTP[0].responseXML.getElementsByTagName("PortOfDischarge")[0].childNodes[0].nodeValue;
				
		document.getElementById("txtConsgnee").value=xmlHTTP[0].responseXML.getElementsByTagName("buyers")[0].childNodes[0].nodeValue;
			document.getElementById("txtVessel").value=xmlHTTP[0].responseXML.getElementsByTagName("Vessel")[0].childNodes[0].nodeValue;
			document.getElementById("txtSupplimentry").value=xmlHTTP[0].responseXML.getElementsByTagName("SuplimentaryDetails")[0].childNodes[0].nodeValue;
			document.getElementById("txtDestination").value=xmlHTTP[0].responseXML.getElementsByTagName("FinalDestination")[0].childNodes[0].nodeValue;
			document.getElementById("txtCartoons").value=xmlHTTP[0].responseXML.getElementsByTagName("NoOfCartons")[0].childNodes[0].nodeValue;
			document.getElementById("txtCage2").value=xmlHTTP[0].responseXML.getElementsByTagName("Cage2")[0].childNodes[0].nodeValue;
			document.getElementById("texMarksnNos").value=xmlHTTP[0].responseXML.getElementsByTagName("Marks")[0].childNodes[0].nodeValue;
			document.getElementById("txtYear").value=xmlHTTP[0].responseXML.getElementsByTagName("ExportYear")[0].childNodes[0].nodeValue;
		
			
		}
		}
	xmlHTTP[0].open("GET",'certificateoforgindb.php?REQUEST=getco&invoiceno='+invoiceno,true);
	xmlHTTP[0].send(null);
	}
	else
	Clearformm();
	
}

function Clearformm()
{
	document.getElementById("cboInvoice").value="";
	document.getElementById("txtCompany").value="";
	document.getElementById("txtPortofDischarge").value="";
	document.getElementById("txtConsgnee").value="";
	document.getElementById("txtVessel").value="";
	document.getElementById("txtSupplimentry").value="";
	document.getElementById("txtDestination").value="";
	document.getElementById("txtCartoons").value="";
	document.getElementById("txtCage2").value="";
	document.getElementById("texMarksnNos").value="";
	document.getElementById("txtYear").value="";
	
	
	
	}
	
function savedb()
{
	if(document.getElementById("cboInvoice").value!="")
	{
		var invoice=document.getElementById("cboInvoice").value;
		var Company=document.getElementById("txtCompany").value;
		var PortofDischarge=document.getElementById("txtPortofDischarge").value;
		var Consgnee=document.getElementById("txtConsgnee").value;
		var Vessel=document.getElementById("txtVessel").value;
		var Supplimentry=document.getElementById("txtSupplimentry").value;
		var Destination=document.getElementById("txtDestination").value;
		var Cartoons=document.getElementById("txtCartoons").value;
		var Cage2=document.getElementById("txtCage2").value;
		var MarksnNos=document.getElementById("texMarksnNos").value;
		var Year=document.getElementById("txtYear").value;
		
		generateRequest(1);		
		xmlHTTP[1].onreadystatechange=function()
	{
		if(xmlHTTP[1].readyState==4 && xmlHTTP[1].status==200)
					alert(xmlHTTP[1].responseText);
	}
		xmlHTTP[1].open("GET",'certificateoforgindb.php?REQUEST=saveco&invoiceno='+invoice+'&PortofDischarge='+PortofDischarge+'&Year='+Year+'&Vessel='+Vessel+'&Supplimentry='+Supplimentry+'&Destination='+Destination+'&Cartoons='+Cartoons+'&Cage2='+Cage2+'&MarksnNos='+MarksnNos,true);
		xmlHTTP[1].send(null);
	
	}	
}

function printReport()
{
	if (document.getElementById("cboInvoice").value!="" )
	{
	generateRequest(10);
	var invoiceno=document.getElementById("cboInvoice").value;
	xmlHTTP[10].onreadystatechange=function()
			{
				if(xmlHTTP[10].readyState==4 && xmlHTTP[10].status==200)
					{
						var xmlItemno=xmlHTTP[10].responseXML.getElementsByTagName("ItemNo");
						
						for (var loop=0; loop< xmlItemno.length;loop++)
						{
							var itemno=xmlItemno[loop].childNodes[0].nodeValue;
							window.open('dragable/rptCO.php?invoiceno='+invoiceno+'&itemno='+itemno );
						}
					}
			}
	xmlHTTP[10].open("GET",'certificateoforgindb.php?REQUEST=print&invoiceno='+invoiceno,true);
	xmlHTTP[10].send(null);
	}
}