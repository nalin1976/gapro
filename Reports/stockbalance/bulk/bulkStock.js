// JavaScript Document
function getSubCategory()
{
	var mainCat =  $("#cboMainCat").val();
	
	var url = 'db.php?RequestType=LoadSubcatList';	
		url += '&mainCat='+mainCat;
			
		htmlobj=$.ajax({url:url,async:false});
		$("#cboSubCat").html(htmlobj.responseXML.getElementsByTagName("SubCat")[0].childNodes[0].nodeValue);		 
		
		getMatIemList();
}
function getMatIemList()
{
	var mainCat =  $("#cboMainCat").val();
	var subCat  = $("#cboSubCat").val();
	var matItem = $("#txtMatItem").val();
	
	var url = 'db.php?RequestType=LoadMatItemList';	
		url += '&mainCat='+mainCat;
		url += '&subCat='+subCat;
		url += '&matItem='+URLEncode(matItem);
		htmlobj=$.ajax({url:url,async:false});
		$("#cboMatItem").html(htmlobj.responseXML.getElementsByTagName("matItemList")[0].childNodes[0].nodeValue);		
}

function EnterSubmitLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode == 13)
		getMatIemList();
}