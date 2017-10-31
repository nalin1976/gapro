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
	var txtMatItem = $("#txtMatItem").val();
	var url = 'db.php?RequestType=LoadMaterials';	
		url += '&mainId='+mainId;
		url += '&subCatId='+subCatId;
		url += '&txtMatItem='+URLEncode(txtMatItem);
		
	htmlobj=$.ajax({url:url,async:false});
		 
		document.getElementById("cboMaterial").innerHTML = htmlobj.responseText;
}

function viewAgeAnalysisRpt(excelRep)
{
	var mainId	= document.getElementById('cboMainCat').value;
	var subCatId	= document.getElementById('cboSubCat').value;
	var mainStore   = document.getElementById('cboStore').value;
	var color 	=  document.getElementById('cboColor').value;
	var size 	=  document.getElementById('cboSize').value;
	var ItemID 	=  document.getElementById('cboMaterial').value;
	var itemDesc	= $("#txtMatItem").val();
        var subStoreId  = $("#cboSubStore").val();
        var buyerId     = $("#cboCustomer").val();
        var orderStatus = $("#cboOrderStatus").val();
        var itemListing = $("#cboItemListing").val();
        
        
        if(excelRep=='E'){
           
           var file = "ageAnalysisRptExcel.php";
        }
        else{
            var file = "ageAnalysisRpt.php";
        }
	
	var url = file+"?mainId="+mainId;
		url += "&subCatId="+subCatId;
		url += "&ItemID="+ItemID;
		url += "&mainStore="+mainStore;
		url += "&color="+URLEncode(color);
		url += "&size="+URLEncode(size);
		url += "&itemDesc="+URLEncode(itemDesc);
                url += "&excelRep="+URLEncode(excelRep);
                url += "&subStoreId="+subStoreId;
                url += "&buyerId="+buyerId;
                url += "&ostatus="+orderStatus;
                url += "&ilisting="+itemListing;
                
	/*if(mainStore == '')
	{
		alert('Select Main Store');
		return false;
	}
	else
	{
		window.open(url,'frmStockRpt'); 
	}*/
	window.open(url,'frmStockRpt'); 
		
}

function enterLoadItem(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadMatItemList();
}

function loadSubStores(){
    
    var mainStoreId = $("#cboStore").val();
    
    var url = 'db.php?RequestType=LoadSubStore&mainId='+mainStoreId;
    
    htmlobj1 = $.ajax({url:url,async:false});
    
    $("#cboSubStore").html(htmlobj1.responseText);
    
}