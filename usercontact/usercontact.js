var xmlHttp;
//start - configuring HTTP request
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
//End - configuring HTTP request

//Start - Public remove data function
function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}
//End - Public remove data function
function closeWindow(){
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}
//Start - Clear table data
function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}
//End - Clear table data

function DateDisable(objChk)
{	
		if(!objChk.checked)
		{
			document.getElementById("GPDateFrom").disabled= true;
			//document.getElementById("GPDateFrom").value="";
			document.getElementById("GPDateTo").disabled= true;
			//document.getElementById("GPDateTo").value="";
		}
		else
		{
			document.getElementById("GPDateFrom").disabled=false;
			document.getElementById("GPDateTo").disabled= false;
		}
}


function LoadDetails(obj)
{	
	var companyId	= document.getElementById('').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadDetailsRequest;
	xmlHttp.open("GET",'usercontactxml.php?RequestType=LoadDetails&userName=' +obj ,true);
	xmlHttp.send(null);
}
function LoadDetailsRequest()
{
	if (xmlHttp.readyState==4)
	{
		if (xmlHttp.status==200)
		{
			var XMLUserID 		= xmlHttp.responseXML.getElementsByTagName("UserID");
			var XMLUserNamer 	= xmlHttp.responseXML.getElementsByTagName("UserName");
			var XMLCompName 			= xmlHttp.responseXML.getElementsByTagName("CompName");
			var XMLDepartement 	= xmlHttp.responseXML.getElementsByTagName("Departement");
			var XMLFactoryExtension 			= xmlHttp.responseXML.getElementsByTagName("FactoryExtension");
			var XMLUserExtension 		= xmlHttp.responseXML.getElementsByTagName("UserExtension");
			var XMLRemarks 		= xmlHttp.responseXML.getElementsByTagName("Remarks");
				
			var strText = "<table width=\"931\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
				"<tr>"+
				  "<td width=\"4%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">ID</td>"+
				  "<td width=\"14%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User Name</td>"+
				  "<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Departement</td>"+
				  "<td width=\"34%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Factory</td>"+
				    "<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fac Ex.</td>"+
				  "<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User Ex.</td>"+
				  "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
				  
				"</tr>";
				
			for (var loop=0;loop<XMLUserID.length;loop++)
			{
				strText +="<tr onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background=''\" class=\"bcgcolor-tblrowWhite\">"+
			  "<td class=\"normalfntMid\">"+XMLUserID[loop].childNodes[0].nodeValue+"</td>"+
              "<td class=\"normalfntMid\">"+XMLUserNamer[loop].childNodes[0].nodeValue+"</td>"+
              "<td class=\"normalfntMid\">"+XMLDepartement[loop].childNodes[0].nodeValue+"</td>"+
              "<td class=\"normalfntMid\">"+XMLCompName[loop].childNodes[0].nodeValue+"</td>"+
			   "<td class=\"normalfntMid\">"+XMLFactoryExtension[loop].childNodes[0].nodeValue+"</td>"+
			  "<td class=\"normalfntMid\">"+XMLUserExtension[loop].childNodes[0].nodeValue+"</td>"+	
			  " <td class=\"normalfnt\">"+XMLRemarks[loop].childNodes[0].nodeValue+"</td>"+
            "</tr>";
			}
			strText += "</table>";
			document.getElementById("divGatePassDetails").innerHTML=strText;
		}
	}
	
}

function LoadPoUp()
{	
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'usercontactpopup.php?',true);
	xmlHttp.send(null);
}

	function LoadStockDetailsRequest(){
		if (xmlHttp.readyState==4){
			if (xmlHttp.status==200){
				drawPopupArea(600,215,'frmMaterialTransfer');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
			}
		}
	}
	
function SaveDetails()
{
	var txtUser = document.getElementById('txtUser').value;	
		if(txtUser==""){
			alert("User Name cannot be blanck");
			document.getElementById('txtFacExten').focus
			}	
	var company = document.getElementById('cboCom').value;
			if(company==""){
			alert("Company cannot be blanck");
			document.getElementById('txtFacExten').focus
			}	var department = document.getElementById('txtDepartment').value;
		
	var facExten = document.getElementById('txtFacExten').value;
		if(facExten==""){
			alert("Factory Extension cannot be blanck");
			document.getElementById('txtFacExten').focus
			}
	var userExten = document.getElementById('txtUserExten').value;
		if(userExten==""){
			alert("User Extension cannot be blanck");
			document.getElementById('txtFacExten').focus
			}
	var remarks = document.getElementById('txtRemarks').value;		 
	
	createXMLHttpRequest();	
	//xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'usercontactxml.php?RequestType=SaveDetails&userName=' +txtUser+ '&company=' +company+ '&department=' +department+ '&facExten=' +facExten+ '&userExten=' +userExten+ '&remarks=' +remarks ,true);
	xmlHttp.send(null);
	alert("User Name : "+ txtUser + " Updated.");
}
