//Start - Assign main columns to variables
var cell_del 		= 0 ; // Delete Columns
var cell_all 		= 1 ; // Delete Columns
var cell_sub 		= 2 ; // Delete Columns
var cell_buyer 		= 3 ; // Delete Columns
var cell_upfo 		= 4 ; // Delete Columns
var cell_confo 		= 5 ; // Delete Columns
var cell_color 		= 6 ; // Delete Columns
//End - Assign main columns to variables

function LoadFormulas(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var subCatId	= rw.cells[cell_sub].id;
	var url = "itemallocationmiddle.php?RequestType=LoadFormulas&BuyerId="+obj.value+ '&SubCatId='+subCatId;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLUPFId	= htmlobj.responseXML.getElementsByTagName("UnitPriceFormulaId");
	if(XMLUPFId.length<=0){
		rw.cells[cell_upfo].childNodes[1].value = "null";
	}
	else
		rw.cells[cell_upfo].childNodes[1].value = XMLUPFId[0].childNodes[0].nodeValue;
	
	var XMLCPFId	= htmlobj.responseXML.getElementsByTagName("ConPcFormulaId");
	if(XMLCPFId.length<=0){
		rw.cells[cell_confo].childNodes[1].value = "null";
	}
	else
		rw.cells[cell_confo].childNodes[1].value = XMLCPFId[0].childNodes[0].nodeValue; 
}

function AllocateFormula(obj)
{
	if(obj.value=="null")
		return;
	
	var rw 				= obj.parentNode.parentNode;
	var subCatId		= rw.cells[cell_sub].id;
	var buyer			= rw.cells[cell_buyer].childNodes[1].value;
	var upFormulaId		= rw.cells[cell_upfo].childNodes[1].value;
	var conPcFormulaId	= rw.cells[cell_confo].childNodes[1].value;
	var url = "itemallocationdb.php?RequestType=AllocateFormula&BuyerId="+buyer+ '&SubCatId='+subCatId+ '&UPFormulaId='+upFormulaId+ '&ConPcFormulaId='+conPcFormulaId;
	htmlobj=$.ajax({url:url,async:false});
}

function AllocateMaterials(obj)
{
	if(obj.value=="null")
		return;
		
	var rw 				= obj.parentNode.parentNode;
	var subCatId		= rw.cells[cell_sub].id;
	var colorCode		= rw.cells[cell_color].childNodes[0].value;
	var url = "itemallocationdb.php?RequestType=AllocateMaterials&MainMatId="+obj.value+ '&SubCatId='+subCatId+ '&ColorCode='+URLEncode(colorCode);
	htmlobj=$.ajax({url:url,async:false});
}

function ChangeColor(obj)
{
	var rw = obj.parentNode.parentNode;
	var subCatId		= rw.cells[cell_sub].id;
	var mainMatId		= rw.cells[cell_all].childNodes[1].value;
	var url = "itemallocationdb.php?RequestType=ChangeColor&MainMatId="+mainMatId+ '&SubCatId='+subCatId+ '&ColorCode='+URLEncode(obj.value);
	htmlobj=$.ajax({url:url,async:false});
}

function SaveType(obj)
{
	var rw = obj.parentNode.parentNode.parentNode;
	var subCatId		= rw.cells[cell_sub].id;
	var mainMatId		= rw.cells[cell_all].childNodes[1].value;
	var check = ((obj.checked) ? 1:0);
	var url = "itemallocationdb.php?RequestType=SaveType&Check="+check+'&MainMatId='+mainMatId+ '&SubCatId='+subCatId;
	htmlobj=$.ajax({url:url,async:false});
}