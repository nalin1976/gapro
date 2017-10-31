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
	
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = LoadMaterialRequest;
	xmlHttp[1].open("GET",'db.php?RequestType=LoadMaterial&mainId='+mainId+ '&subCatId='+subCatId, true);
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
	 if (charCode == 13)
		getMatIemList();
}
function getMatIemList()
{
	var mainCat =  $("#cboMainCat").val();
	var subCat = $("#cboSubCat").val();
	var matItem = $("#txtmaterial").val();
	
	ClearOptions('cboMatItem');
	
	if(mainCat == '')
	{
		alert("Please select \"Main Category\"");
		$("#cboMainCat").focus();
		return false;
	}
	var url = 'db.php?RequestType=LoadMatItemList';	
		url += '&mainCat='+mainCat;
		url += '&subCat='+subCat;
		url += '&matItem='+URLEncode(matItem);
		htmlobj=$.ajax({url:url,async:false});
				 
	 document.getElementById("cboMatItem").innerHTML =  htmlobj.responseText;
}
function ClearOptions(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}

function LoadCostCenter(obj)
{
	var url  = 'db.php?RequestType=URLLoadCostCenter';
		url += '&FactoryId='+obj.value;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboCostCenter").innerHTML =  htmlobj.responseText;
}
function LoadGLCode(obj)
{
	var url  = 'db.php?RequestType=URLLoadGLCode';
		url += '&costCenterId='+obj.value;
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById("cboGLCode").innerHTML = htmlobj.responseText;  
}