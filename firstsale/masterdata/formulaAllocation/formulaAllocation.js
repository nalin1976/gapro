// JavaScript Document
function CheckAll(obj,tbl,cellId)
{
	var tbl  = document.getElementById(tbl);
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[cellId].childNodes[0].checked = check;
	}
	if(validateInterface('all'))
	{
		showBackGroundBalck();
		var buyer = document.getElementById('cboBuyer').value;
		var upriceFormula = document.getElementById('cboUnitPrice').value;
		var conpcFormula = document.getElementById('cboConpc').value;	
		var subCategory = document.getElementById('cboSubcategory').value;	
		
		var url = "formulaAllocationdb.php?id=saveAllItemFormulaDetails&buyer="+buyer;
			url +="&upriceFormula="+upriceFormula+"&conpcFormula="+conpcFormula;
			url += "&subCategory="+subCategory;
			url += "&ItemMainCat="+tbl.rows[1].cells[3].childNodes[0].selectedIndex;
			url += "&itemType="+tbl.rows[1].cells[4].childNodes[0].checked;
			url += "&displayItem="+tbl.rows[1].cells[5].childNodes[0].checked;
			url += "&otherPacking="+tbl.rows[1].cells[6].childNodes[0].checked;
			url += "&check="+check;	
			htmlobj=$.ajax({url:url,async:false});
	}
	//start assign main category
	var mainCategoryId = tbl.rows[1].cells[3].childNodes[0].selectedIndex;
	var chkItemName = tbl.rows[1].cells[4].childNodes[0].checked;
	var chkItem = tbl.rows[1].cells[5].childNodes[0].checked;
	var chkOtherPack = tbl.rows[1].cells[6].childNodes[0].checked;
	var chkAll = tbl.rows[1].cells[0].childNodes[0].checked;
	if(mainCategoryId !=0)
	{
		for(var i=2;i<tbl.rows.length;i++)	
		{
			tbl.rows[i].cells[3].childNodes[0].selectedIndex = mainCategoryId;
			tbl.rows[i].cells[4].childNodes[0].checked = chkItemName;
			tbl.rows[i].cells[5].childNodes[0].checked = chkItem;
			tbl.rows[i].cells[6].childNodes[0].checked = chkOtherPack;
			tbl.rows[i].cells[0].childNodes[0].checked = chkAll;
		}	
	}
	// end assign main category
	alert("Saved successfully");
	hideBackGroundBalck();
}
function CheckAllOther(obj,tbl,cellId)
{
	var tbl  = document.getElementById(tbl);
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[cellId].childNodes[0].checked = check;
	}
}
function chekMainCategory(obj)
{
	var tbl  = document.getElementById('tblMainGrid');
	if(obj.checked)
	{
		var mainCategoryId = tbl.rows[1].cells[3].childNodes[0].selectedIndex;
		if(mainCategoryId !=0)
		{
			for(var i=2;i<tbl.rows.length;i++)	
			{
				tbl.rows[i].cells[3].childNodes[0].selectedIndex = mainCategoryId;
			}	
		}
		else
		{
			alert("Select Main Category in first line");
			obj.checked = false;
			
			//tbl.rows[1].cells[3].childNodes[0].select();
			return;
		}
	}
	else
	{
		for(var i=1;i<tbl.rows.length;i++)	
			{
				tbl.rows[i].cells[3].childNodes[0].selectedIndex = 0;
			}
	}
}

function saveFormulaAllocation(obj)
{
	var tbl  = document.getElementById('tblMainGrid');
	if(validateInterface('item'))
	{
		var rw = obj.parentNode.parentNode;
		if(rw.cells[3].childNodes[0].selectedIndex ==0)
		{
			alert("Select 'Main Category' ");
			obj.checked = false;
			return false;
		}
		showBackGroundBalck();
		var buyer = document.getElementById('cboBuyer').value;
		var upriceFormula = document.getElementById('cboUnitPrice').value;
		var conpcFormula = document.getElementById('cboConpc').value;	
		var subCategory = document.getElementById('cboSubcategory').value;
		
		
		var url = "formulaAllocationdb.php?id=saveItemFormulaDetails&buyer="+buyer;
		url +="&upriceFormula="+upriceFormula+"&conpcFormula="+conpcFormula;
		url += "&subCategory="+subCategory;
		url += "&matDetailId="+rw.cells[2].id;
		url += "&ItemMainCat="+rw.cells[3].childNodes[0].selectedIndex;
		url += "&itemType="+rw.cells[4].childNodes[0].checked;
		url += "&displayItem="+rw.cells[5].childNodes[0].checked;
		url += "&otherPacking="+rw.cells[6].childNodes[0].checked;
		url += "&check="+obj.checked;	
		htmlobj=$.ajax({url:url,async:false});
			
		alert("Saved successfully");
		hideBackGroundBalck();
	}
	
}

function validateInterface(type)
{
	var buyer = document.getElementById('cboBuyer').value;
	var upriceFormula = document.getElementById('cboUnitPrice').value;
	var conpcFormula = document.getElementById('cboConpc').value;
	var tbl  = document.getElementById('tblMainGrid');
	var rwCount = tbl.rows.length;
	var count=1;
	if(buyer == "")
	{
		alert("Please selct 'Buyer'");
		document.getElementById('cboBuyer').focus();
		return; 
	}
	else if(upriceFormula == "null")
	{
		alert("Please select 'Unitprice Formula'");
		document.getElementById('cboUnitPrice').focus();
		return; 
	}
	else if(conpcFormula == "null")
	{
		alert("Please select 'Conpc Formula'");
		document.getElementById('cboConpc').focus();
		return; 
	}
	else
	{
		if(type =='all')
		{
			for(i=1;i<tbl.rows.length;i++)	
			{
				if(tbl.rows[1].cells[3].childNodes[0].selectedIndex ==0)
					{
						alert("Select 'Main Category'");
						return;
					}
				
			}
		}
	}
	
	return true;
}
function clearPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
}
function viewFormulaReport()
{
	var buyerId =  document.getElementById('cboBuyer').value;
	var subcat = document.getElementById('cboSubcategory').value;
	
	if(buyerId == '')
	{
		alert("Please select 'Buyer'");
		document.getElementById('cboBuyer').focus();
		return; 
	}
	else if(subcat == 'null')
	{
		alert("Please select 'Sub Category'");
		document.getElementById('cboSubcategory').focus();
		return; 	
	}
	var buyerName = $("#cboBuyer option:selected").text();
	var url = 'formulaAlloReport.php?buyerId='+buyerId+'&subcat='+subcat+'&buyerName='+URLEncode(buyerName);
	window.open(url,'frmFormulaAllo')
}