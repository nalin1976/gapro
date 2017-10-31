// JavaScript Document
function getSubcategory()
{
	var mainCat =  $("#cboMainCat").val();
	var url = 'db.php?RequestType=LoadSubcat';	
		url += '&mainCat='+mainCat;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboSubcat").innerHTML =  htmlobj.responseText;
		// getMatIemList();
}

function getMatIemList()
{
	var mainCat =  $("#cboMainCat").val();
	var subCat = $("#cboSubcat").val();
	var matItem = $("#txtmaterial").val();
	
	ClearOptions('cboMaterial');
	
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
				 
	 document.getElementById("cboMaterial").innerHTML =  htmlobj.responseText;
}

function viewItemStockRpt()
{
	var mainStore		=  $("#cboStore").val();	
	var matItem 		=  $("#cboMaterial").val();
	var Dfrom 			= $("#txtDfrom").val();
	var Dto				=  $("#txtDto").val();
	var mainCatID 		=  $("#cboMainCat").val();
	

	if(matItem == '')
	{
		alert("Please select the 'Meterial'.");
		$("#cboMaterial").focus();
		return;
	}
	else if(mainStore == '')
	{
		alert('Please select the \'Main Store\'.');
		$("#cboStore").focus();
		return;	
	}
	else if(Dfrom == '')
	{
		alert('Please select the \'Date From\'.');
		$("#txtDfrom").focus();
		return;	
	}
	else if(Dto == '')
	{
		alert('Please select the \'Date To\'.');
		$("#txtDto").focus();
		return;	
	}
	
	var mainCategory = $("#cboMainCat option:selected").text();
	var url = '';
	//var itemName     = $("#cboMaterial option:selected").text();
	
	if(document.getElementById('rbItem').checked)
				url = 'itemStockRpt.php?';
				
	var color = $("#cboColor option:selected").text();
		var size = $("#cboSize option:selected").text();			
	if(document.getElementById('rdoStyleWise').checked)
	{
		
		var orderNo = $("#cboStyle").val();
		
		
		if(orderNo == '')
		{
			alert('Please select the \'Order No\'');
			$("#cboStyle").focus();
			return;	
		}
		if(color == '')
		{
			alert('Please select the \'Color\'');
			$("#cboColor").focus();
			return;	
		}
		if(size == '')
		{
			alert('Please select the \'Size\'');
			$("#cboSize").focus();
			return;	
		}
		url = "styleStockRpt.php?";
		url += "&orderNo="+orderNo;
		url += "&orderName="+URLEncode($("#cboStyle option:selected").text());
		url += "&color="+URLEncode(color);
		url += "&size="+URLEncode(size);
		url += "&scNo="+$("#cboSc option:selected").text();
		
	}
				
				
	 url += "&matItem="+matItem;
		url += "&mainStore="+mainStore;
		url += "&Dfrom="+Dfrom;
		url += "&Dto="+Dto;
		url += "&mainCatID="+mainCatID;
		url += "&mainCategory="+URLEncode(mainCategory);
		url += "&color="+URLEncode(color);
		url += "&size="+URLEncode(size);
		//url += "&itemName="+URLEncode(itemName);
		url += "&matItem="+matItem;
		//alert(url)
	window.open(url,'frmStockMvItem'); 
}

function GetScNo(obj)
{
	$("#cboSc").val(obj.value);	
	LoadColor(obj.value);
	LoadSize(obj.value);
}

function GetStyleId(obj)
{
	$("#cboStyle").val(obj.value);
	LoadColor(obj.value);
	LoadSize(obj.value);
}

function LoadColor(obj)
{
	var url = 'db.php?RequestType=LoadColor&styleId='+obj;	
	htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboColor").innerHTML =  htmlobj.responseXML.getElementsByTagName("strColor")[0].childNodes[0].nodeValue;
}

function LoadSize(obj)
{
	var url = 'db.php?RequestType=LoadSize&styleId='+obj;	
	htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboSize").innerHTML =  htmlobj.responseXML.getElementsByTagName("strSize")[0].childNodes[0].nodeValue;	
}

function ClearOptions(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}
function EnterSubmitLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				getMatIemList();
}
function clearPage()
{
	$("#frmStockMvItem")[0].reset();	
}