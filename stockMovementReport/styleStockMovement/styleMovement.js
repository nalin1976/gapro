function loadStylewiseOrderList()
{
	var styleNo = document.getElementById('cboStyle').value;
	var url = 'db.php?RequestType=getOrderNoList&styleNo='+styleNo;	
	htmlobj=$.ajax({url:url,async:false});
				 
	document.getElementById("cboOrder").innerHTML =  htmlobj.responseXML.getElementsByTagName("orderNoList")[0].childNodes[0].nodeValue;
	document.getElementById("cboSc").innerHTML =  htmlobj.responseXML.getElementsByTagName("scNoList")[0].childNodes[0].nodeValue;
}

function GetScNo(obj)
{
	$("#cboSc").val(obj.value);
	LoadColor(obj.value);
	LoadSize(obj.value);
	LoadItemDetails();
}

function GetStyleId(obj)
{
	$("#cboOrder").val(obj.value);
	LoadColor(obj.value);
	LoadSize(obj.value);
	LoadItemDetails()
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

function LoadItemDetails()
{
	var styleId = document.getElementById('cboOrder').value;
	var matItem = document.getElementById('txtmaterial').value;
	var subCat = document.getElementById('cboSubcat').value;
	var url = 'db.php?RequestType=LoadItemDetails&styleId='+styleId+'&matItem='+matItem+'&subCat='+subCat;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboMaterial").innerHTML =  htmlobj.responseXML.getElementsByTagName("SubCat")[0].childNodes[0].nodeValue;	
	
}

function getSubcategory()
{
	var mainCat =  document.getElementById('cboMainCat').value;
	var url = 'db.php?RequestType=LoadSubcat';	
		url += '&mainCat='+mainCat;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboSubcat").innerHTML =  htmlobj.responseText;
		// getMatIemList();
}
function EnterSubmitLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				LoadItemDetails();
}
function clearPage()
{
	$("#frmStockMvItem")[0].reset();		
}

function viewStockReport()
{
	var styleId = document.getElementById('cboOrder').value;
	if(styleId =="")
	{
		alert("Please select 'Order No'");
		document.getElementById('cboOrder').focus();
		return;
	}
	
	var url ="styleMovementReport.php?&styleId="+styleId;
	url += "&matMainCategory="+document.getElementById('cboMainCat').value;
	url += "&SubCat="+document.getElementById('cboSubcat').value;
	url += "&matDetailId="+document.getElementById('cboMaterial').value;
	url += "&matItemDesc="+document.getElementById('txtmaterial').value;
	url += "&color="+document.getElementById('cboColor').value;
	url += "&size="+document.getElementById('cboSize').value;
	window.open(url,'frmStockMvItem'); 
}