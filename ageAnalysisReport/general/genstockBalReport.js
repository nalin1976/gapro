// JavaScript Document
function loadSubCatDetails()
{
	var mainCat = document.getElementById('cboMainCat').value;
	var url = 'gendb.php?RequestType=LoadSubCategory';	
		url += '&mainCat='+mainCat;
		htmlobj=$.ajax({url:url,async:false});
				 
		 document.getElementById("cboSubCat").innerHTML =  htmlobj.responseText;
		 
		 loadMatItemList();
}

function loadMatItemList()
{
	var mainId		= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var txtMatItem = $("#txtMatItem").val();
	var url = 'gendb.php?RequestType=LoadMaterials';	
		url += '&mainId='+mainId;
		url += '&subCatId='+subCatId;
		url += '&txtMatItem='+URLEncode(txtMatItem);
		
	htmlobj=$.ajax({url:url,async:false});
		 
		document.getElementById("cboMaterial").innerHTML = htmlobj.responseText;
}

function viewAgeAnalysisRpt(excelRep)
{
	var mainId		= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var mainStore   = document.getElementById('cboStore').value;
	var ItemID 		=  document.getElementById('cboMaterial').value;
	var itemDesc	= $("#txtMatItem").val();
        
	
	var url = "genageanalysisrpt.php?mainId="+mainId;
		url += "&subCatId="+subCatId;
		url += "&ItemID="+ItemID;
		url += "&mainStore="+mainStore;
		url += "&itemDesc="+URLEncode(itemDesc);
                url += "&excelRep="+URLEncode(excelRep);
                 
	if(mainStore == '')
	{
		alert('Please select a Main Store');
		return false;
	}
	else
	{
		window.open(url,'frmStockRpt'); 
	}
	
		
}

function enterLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadMatItemList();
}