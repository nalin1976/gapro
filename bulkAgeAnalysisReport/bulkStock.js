// JavaScript Document
function loadSubCatDetails()
{
	var mainCat = document.getElementById('cboMainCat').value;
	var url = 'db.php?RequestType=LoadSubCategory';	
		url += '&mainCat='+mainCat;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboSubCat").innerHTML =  htmlobj.responseText;
		 
		 loadMatItemList();
}

function loadMatItemList()
{
	var mainId		= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var txtMatItem  = $("#txtMatItem").val();
	
	var url = 'db.php?RequestType=LoadMaterials';	
		url += '&mainId='+mainId;
		url += '&subCatId='+subCatId;
		url += '&txtMatItem='+URLEncode(txtMatItem);
		
	htmlobj=$.ajax({url:url,async:false});
		 
		document.getElementById("cboMaterial").innerHTML = htmlobj.responseText;
}

function viewAgeAnalysisRpt()
{
	var mainId		= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var mainStore   = document.getElementById('cboStore').value;
	var color 		=  document.getElementById('cboColor').value;
	var size 		=  document.getElementById('cboSize').value;
	var ItemID 		=  document.getElementById('cboMaterial').value;
	var itemDesc    = $("#txtMatItem").val();
	var Merchandiser = document.getElementById('cboMerchandiser').value;
	
	var url = "bulkAgeAnalysisreport.php?mainId="+mainId;
		url += "&subCatId="+subCatId;
		url += "&ItemID="+ItemID;
		url += "&mainStore="+mainStore;
		url += "&color="+URLEncode(color);
		url += "&size="+URLEncode(size);
		url += "&itemDesc="+URLEncode(itemDesc);
		url += "&Merchandiser="+Merchandiser;
		url += "&mainCatName="+URLEncode($("#cboMainCat option:selected").text());
		url += "&subCatName="+URLEncode($("#cboSubCat option:selected").text());
		url += "&merchandName="+URLEncode($("#cboMerchandiser option:selected").text());
		url += "&storeName="+URLEncode($("#cboStore option:selected").text());
	
	window.open(url,'frmbulkStockRpt'); 
		
}// JavaScript Document

function enableEnterloadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	
			 if (charCode == 13)
				loadMatItemList();
}