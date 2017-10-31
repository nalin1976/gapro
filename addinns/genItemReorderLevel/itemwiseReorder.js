// JavaScript Document
function loadSubCategoryList()
{
	var mainCat = document.getElementById('cboMainCategory').value;
	var url = 'itemwiseReorderDb.php?RequestType=loadSubcategoryList&mainCat='+mainCat;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSubCategory').innerHTML = htmlobj.responseXML.getElementsByTagName("subCategory")[0].childNodes[0].nodeValue;
	
}

function saveItemDetails(obj)
{
	var	costCenter = document.getElementById('cboCostCenter').value;
	var rlevel = obj.value;
	var row = obj.parentNode.parentNode;
	var matDetailId = row.cells[0].id;
	var url = 'itemwiseReorderDb.php?RequestType=SaveItem&costCenter='+costCenter+'&rlevel='+rlevel+'&matDetailId='+matDetailId;
	htmlobj=$.ajax({url:url,async:false});
}
function clearPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
}