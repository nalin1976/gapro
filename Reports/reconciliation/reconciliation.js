var xmlHttp = [];

function createXMLHttpRequest(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function LoadSubCategory(obj)
{	
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange = LoadSubCategoryRequest;
	xmlHttp[0].open("GET",'db.php?RequestType=LoadSubCategory&mainId='+obj.value, true);
	xmlHttp[0].send(null);
}
	function LoadSubCategoryRequest()
	{
		if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200) 
		{
			var XMLText = xmlHttp[0].responseText;
			document.getElementById('cboSubCat').innerHTML = XMLText;
			LoadMaterial();
		}		
	}

function LoadMaterial()
{	
	var mainId		= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var matItem = $("#txtMatItem").val();
	
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = LoadMaterialRequest;
	xmlHttp[1].open("GET",'db.php?RequestType=LoadMaterial&mainId='+mainId+ '&subCatId='+subCatId+'&matItem='+URLEncode(matItem), true);
	xmlHttp[1].send(null);
}
	function LoadMaterialRequest()
	{
		if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
		{
			var XMLText = xmlHttp[1].responseText;
			document.getElementById('cboMatItem').innerHTML = XMLText;
		}
	}

function GetStyleAndSc(obj)
{
	LoadStyle(obj);
	LoadSc(obj);
	loadStyleNo(obj);
	getReportType('style');
}

function LoadStyle(obj)
{	
	createXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange = LoadStyleRequest;
	xmlHttp[2].open("GET",'db.php?RequestType=LoadStyle&status='+obj, true);
	xmlHttp[2].send(null);
}
	function LoadStyleRequest()
	{
		if(xmlHttp[2].readyState == 4 && xmlHttp[2].status == 200 ) 
		{
			var XMLText = xmlHttp[2].responseText;
			document.getElementById('cboStyle').innerHTML = XMLText;
		}
	}
	
function LoadSc(obj)
{	
	createXMLHttpRequest(4);
	xmlHttp[4].onreadystatechange = LoadScRequest;
	xmlHttp[4].open("GET",'db.php?RequestType=LoadSc&status='+obj, true);
	xmlHttp[4].send(null);
}
	function LoadScRequest()
	{
		if(xmlHttp[4].readyState == 4 && xmlHttp[4].status == 200 ) 
		{
			var XMLText = xmlHttp[4].responseText;
			document.getElementById('cboSc').innerHTML = XMLText;
		}
	}

function loadStyleNo(obj)
{
	var url = "db.php?RequestType=loadStyleNo&status="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyleNo').innerHTML = htmlobj.responseXML.getElementsByTagName("styleNoList")[0].childNodes[0].nodeValue ;
}
function LoadColor(obj)
{	
	createXMLHttpRequest(5);
	xmlHttp[5].onreadystatechange = LoadColorRequest;
	xmlHttp[5].open("GET",'db.php?RequestType=LoadColor&styleId='+obj, true);
	xmlHttp[5].send(null);
}
	function LoadColorRequest()
	{
		if(xmlHttp[5].readyState == 4 && xmlHttp[5].status == 200 ) 
		{
			var XMLText = xmlHttp[5].responseText;
			document.getElementById('cboColor').innerHTML = XMLText;
		}
	}

function LoadSize(obj)
{	
	createXMLHttpRequest(6);
	xmlHttp[6].onreadystatechange = LoadSizeRequest;
	xmlHttp[6].open("GET",'db.php?RequestType=LoadSize&styleId='+obj, true);
	xmlHttp[6].send(null);
}
	function LoadSizeRequest()
	{
		if(xmlHttp[6].readyState == 4 && xmlHttp[6].status == 200 ) 
		{
			var XMLText = xmlHttp[6].responseText;
			document.getElementById('cboSize').innerHTML = XMLText;
		}
	}
	
function EnterSubmitLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				LoadMaterial();
}

function loadStylewiseOrderNo()
{
	var styleNo = document.getElementById('cboStyleNo').value;
	var status = 0;
	if(document.getElementById('rdoAll').checked)
		status=0;
	if(document.getElementById('rdoRunning').checked)
		status=11;
	if(document.getElementById('rdoLeftOvers').checked)
		status=13;	
	var url = "db.php?RequestType=LoadOrderNoStylewise&styleNo="+URLEncode(styleNo)+"&status="+status;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyle').innerHTML = htmlobj.responseXML.getElementsByTagName("orderNo")[0].childNodes[0].nodeValue ;
	document.getElementById('cboSc').innerHTML = htmlobj.responseXML.getElementsByTagName("SCNo")[0].childNodes[0].nodeValue ;
}
function getReportType(type)
{
	var url = "db.php?RequestType=getReportType&type="+type;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboReportType').innerHTML = htmlobj.responseXML.getElementsByTagName("reportType")[0].childNodes[0].nodeValue ;
	if(type=='bulk')
	{
		document.getElementById('viewMerchand').style.display = 'inline';
	}
	else
	{
		document.getElementById('viewMerchand').style.display = 'none';
	}
}
