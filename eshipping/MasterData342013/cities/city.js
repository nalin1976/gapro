var xmlHttp =[];

function createNewXMLHttpRequest(index) 
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

function getCityDetails()
{ 
	var city = document.getElementById("cboCountry").value;
		
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'cityMiddle.php?request=getdata&city=' + city ,true);
	xmlHttp[0].send(null);	
		
}

function stateChanged()
{	 
	if(xmlHttp[0].readyState==4)
	{	
	
		if(xmlHttp[0].status==200)
		{
		document.getElementById("cboCity").length = 0;
		document.getElementById("txtCityName").value="";
		document.getElementById("txtPortOfLoading").value="";
		document.getElementById("txtDcNo").value="";
		document.getElementById("txtISDNo").value="";
		document.getElementById("txtDestination").value="";
		
			var XMLCityName = xmlHttp[0].responseXML.getElementsByTagName("City");
			var XMLCityCode = xmlHttp[0].responseXML.getElementsByTagName("CityCode");
			for(var loop = 0 ; loop < XMLCityName.length ; loop ++)
			{
				//document.getElementById("cboCity").value=XMLCityCode[loop].childNodes[0].nodeValue;
				//document.getElementById("cboCity").text=XMLCityName[loop].childNodes[0].nodeValue;
				var opt = document.createElement("option");
				opt.text =XMLCityName[loop].childNodes[0].nodeValue;
				opt.value =XMLCityCode[loop].childNodes[0].nodeValue;
				document.getElementById("cboCity").options.add(opt);	
			
			}
		}
	
	}
	
	

	
}	
	//alert(xmlHttp[0].responseText);
 function viewCity()
 {
	var vcity= document.getElementById("cboCity").value;
	//alert(vcity);
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=function()
	{
	if(xmlHttp[0].readyState==4)
		{
				
				var scity = xmlHttp[0].responseXML.getElementsByTagName("City")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCityName").value = scity;
        		var sport = xmlHttp[0].responseXML.getElementsByTagName("Port")[0].childNodes[0].nodeValue;
	     		document.getElementById("txtPortOfLoading").value = sport;
				var DC = xmlHttp[0].responseXML.getElementsByTagName("DC")[0].childNodes[0].nodeValue;
	     		document.getElementById("txtDcNo").value = DC;
				var ISD = xmlHttp[0].responseXML.getElementsByTagName("ISD")[0].childNodes[0].nodeValue;
	     		document.getElementById("txtISDNo").value = ISD;
				var DES = xmlHttp[0].responseXML.getElementsByTagName("DES")[0].childNodes[0].nodeValue;
	     		document.getElementById("txtDestination").value = DES;
		}	
	}
	xmlHttp[0].open("GET",'cityMiddle.php?request=viewdata&city=' + vcity ,true);
	xmlHttp[0].send(null);	  
 
 }	
	
		function deleteData()
	{
		
		var dccode=	document.getElementById("cboCity").value;	
		if(dccode!="")
		{
			var dcity= document.getElementById("cboCity").options[document.getElementById("cboCity").selectedIndex].text;		
			var dcon=confirm("Are you sure you want to delete '" +dcity+ "'?");	
				if (dcon)
				{
					createNewXMLHttpRequest(0);
					xmlHttp[0].onreadystatechange=function()
					{
						if(xmlHttp[0].readyState==4)
						{
							alert(xmlHttp[0].responseText);	
							setTimeout("location.reload(true);",100);						
						}
											
					}
					xmlHttp[0].open("GET",'cityinsert.php?request=deletedata&city=' + dccode ,true);
					xmlHttp[0].send(null);	
					
				}
				
		
		}
		if(document.getElementById("cboCountry").value=="")
		{
			alert("Please select a Country .");
		}
		else if(document.getElementById("txtCityName").value=="")
			{
				alert("Please select a city.");
			}
		
	}

	
function savedata()
{
	
if (validateform())
	{
		validatedb()	
	}
	
}


function validateform()
	{
		
		if(document.getElementById("cboCountry").value=="")
			{
				alert("Plesase select a country.");
				document.getElementById("cboCountry").focus();
				return false;
			}		
			
		else if(document.getElementById("txtCityName").value=="")
			{
				alert("Plesase enter a city.");
				document.getElementById("txtCityName").focus();
				return false;
			}
			
		else if(document.getElementById("txtPortOfLoading").value=="")
			{
					alert("Plesase enter the port of loading.");	
					document.getElementById("txtPortOfLoading").focus();
					return false;
			}	
			
		else
			{
				return true;			
			}	
	}
	
	
	
	function validatedb()
	{
		var country =document.getElementById("cboCountry").value;
		var city =document.getElementById("cboCity").value;
		//alert(city);
		createNewXMLHttpRequest(0);
					xmlHttp[0].onreadystatechange=function()
					{
						if(xmlHttp[0].readyState==4)
						{
							var response=xmlHttp[0].responseText;	
											
							if (response=='insert')
							{
								var str="insert";
								insertdb(str);
															
							}
							else if(response=='update')
							{	
								if (confirm("Record already exist, do youwant to update?"))
								{							
								var str="update";
								insertdb(str);
								
								}
															
							} 
							
							
						}
											
					}
					xmlHttp[0].open("GET",'cityinsert.php?request=checkdb&country=' + URLEncode(country) + '&city=' +URLEncode(city),true);
					xmlHttp[0].send(null);	
	
	}
	
	
	function insertdb(str)
	{
		var arg=str;
		//alert(arg);
		var country =document.getElementById("cboCountry").value;
		var city =document.getElementById("txtCityName").value;
		var port=document.getElementById("txtPortOfLoading").value;
		var old=document.getElementById("cboCity").value;
		var dc=document.getElementById("txtDcNo").value;
		var isd=document.getElementById("txtISDNo").value;
		var des=document.getElementById("txtDestination").value;
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
					{
						if(xmlHttp[0].readyState==4)
						{
							alert(xmlHttp[0].responseText);	
							setTimeout("location.reload(true);",100);	
						}
					}
		xmlHttp[0].open("GET",'cityinsert.php?request=insertdb&country=' + URLEncode(country) + '&city=' +URLEncode(city)+ '&arg=' +URLEncode(arg)+ '&port=' +URLEncode(port)+ '&old=' +URLEncode(old) + '&dc='+URLEncode(dc) + '&isd=' +URLEncode(isd)+'&des='+URLEncode(des),true);
			xmlHttp[0].send(null);				
		
	}	
	
	function ClearForm()
	{
	document.getElementById("cboCountry").value="";
	document.getElementById("txtCityName").value="";
	document.getElementById("txtPortOfLoading").value="";
	document.getElementById("txtDcNo").value="";
	document.getElementById("txtISDNo").value="";
	document.getElementById("txtDestination").value="";
	document.getElementById("cboCity").length=0;
	
	
		
	}
	
