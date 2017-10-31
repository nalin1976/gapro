function ViewCharts (){
	
	var storesLocationId = parseInt(document.getElementById('cmbStores').value);
	var buyerId = parseInt(document.getElementById('cmbCustomer').value);
	var mainCategoryId = parseInt(document.getElementById('cmbMainCategory').value);
	var subCategoryId = parseInt(document.getElementById('cmbSubCategory').value);
	
	var reportRangeId = parseInt(document.getElementById('cmbReportRange').value);
	
	var url = "";
	
	if(mainCategoryId==-1){alert("Please select main category "); return;}
	
	if(storesLocationId == -1 && buyerId == -1 && mainCategoryId != -1 && subCategoryId == -1 && reportRangeId == 1){
		//alert("OK");
		url = 'rmreport.php?reportType=1&mc='+mainCategoryId;
	}
	
	window.open(url);
}