var pub_zIndex = 0;
//-----------------------------------------------------------
function newStyleDefinition(){
document.getElementById("cboStyle").value="";
document.getElementById("cboSC").value="";
document.getElementById("cboStyleCategory").value="";
	var HTMLText = "<table style=\"width:1100px;\" id=\"tblStyleDefinition\" class=\"thetable\" border=\"1\" cellspacing=\"1\">"+
						"<caption>Style Component</caption>"+
							"<tr>"+
								"<th width=\"35\">Del</th>"+
								"<th width=\"145\">Garmnet Pack  </th>"+
								"<th width=\"144\">Garmrnt Component  </th>"+
								"<th width=\"207\"><p>Embelish Placement </p>"+
							    "</th>"+
								"<th width=\"191\">Remarks</th>"+
							"</tr>"+			 		
						"</table>";	
document.getElementById("styleDefinition").innerHTML=HTMLText;
document.getElementById("cboStyle").focus();
}
//-----------------------------------------------------------
function loadGridStyleDefinition(combo) {
	
	loadBuyerAndDevition();
	var style=document.getElementById("cboStyle").value;
	var sc=document.getElementById("cboSC").value;
	var styleCategory=document.getElementById("cboStyleCategory").value;
	
	if(combo=='cboStyle'){
	document.getElementById("cboSC").value=	style;
	}
	if(combo=='cboSC'){
	document.getElementById("cboStyle").value= sc;
	}
	
	var HTMLText = "<table style=\"width:1100px;\" id=\"tblStyleDefinition\" class=\"thetable\" border=\"1\" cellspacing=\"1\">"+
						"<caption>Style Component</caption>"+
							"<tr>"+
								"<th width=\"35\" style=\"display:none\">Del</th>"+
								"<th width=\"145\">Garment Pack  </th>"+
								"<th width=\"144\">Garment Component  </th>"+
								"<th width=\"207\"><p>Embelishment Placement </p>"+
							    "</th>"+
								"<th width=\"191\">Remarks</th>"+
							"</tr>"+			 		
						"</table>";
if(combo=='cboStyle'){
var url="styleDefinition-db-get.php?RequestType=loadCategory&style="+style;
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("cboStyleCategory").value='';
	document.getElementById("cboStyleCategory").value=httpobj.responseText;
}
							
loadExistingComponents();						
loadServices();
loadGrid();
/*var url="styleDefinition-db-get.php?RequestType=loadGrid&style="+style+"&styleCategory="+styleCategory;
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("styleDefinition").innerHTML=httpobj.responseText;*/
}
//---------------------------------------------------------------
function loadExistingComponents()
{
	var style=document.getElementById("cboStyle").value;
	var styleCategory=document.getElementById("cboStyleCategory").value;
	
var url="styleDefinition-db-get.php?RequestType=loadExistingComponents&style="+style+"&styleCategory="+styleCategory;
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("styleComponents").innerHTML=httpobj.responseText;
}
//--------------------------------------------------------------
function loadServices()
{
	var style=document.getElementById("cboStyle").value;
var url="styleDefinition-db-get.php?RequestType=loadServices&style="+style;
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("styleServices").innerHTML=httpobj.responseText;
}
//-------------------------------------------------------------------
function addComponents(){
	var tbl = document.getElementById('tblComponents');
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if ((tbl.rows[loop].cells[1].childNodes[0].checked) && (tbl.rows[loop].cells[1].childNodes[0].disabled != true)){

		  var tbl2 = document.getElementById('tblStyleComponents');
		  var lastRow = tbl2.rows.length;
		  var row = tbl2.insertRow(lastRow);
		  
		  var SelectOption=document.getElementById('cboStyleCategory');
		  var SelectedIndex=SelectOption.selectedIndex;
		  var categoryID=SelectOption.value;
		  var category=SelectOption.options[SelectOption.selectedIndex].text;	
		  
		  var packID =  tbl.rows[loop].cells[2].id;
		  var pack =  tbl.rows[loop].cells[2].innerHTML;
		  var compID =  tbl.rows[loop].cells[3].id;
		  var component =  tbl.rows[loop].cells[3].innerHTML;
		  var placemntID =  tbl.rows[loop].cells[4].id;
		  var placement =  tbl.rows[loop].cells[4].innerHTML;
		  
		  //hem doooooooo
		  //chk for existing???

		  var cell0 = row.insertCell(0);
		  var textNode = document.createTextNode(categoryID);
		  cell0.appendChild(textNode);
		  cell0.id=category;
		  
		  var cell1 = row.insertCell(1);
		  var textNode = document.createTextNode(pack);
		  cell1.appendChild(textNode);
		  cell1.id=packID;
		  
		  var cell2 = row.insertCell(2);
		  var textNode = document.createTextNode(component);
		  cell2.appendChild(textNode);
		  cell2.id=compID;
		  
		  var cell3 = row.insertCell(3);
		  var textNode = document.createTextNode(placement);
		  cell3.appendChild(textNode);
		  cell3.id=placemntID;
		}
}
CloseWindow();
loadGrid();
}
//-------------------------------------------------------------------------
function loadGrid()
{
//	alert("lll");
	var tbl1 = document.getElementById('tblStyleServices');
	var tbl2 = document.getElementById('tblStyleComponents');
	var noOfRows = tbl2.rows.length;
	var noOfCols = tbl1.rows.length;

var tableText = "<table style=\"width:1100px;\" id=\"tblStyleDefinition\" class=\"thetable\" border=\"1\" cellspacing=\"1\"><caption>Style Component</caption>"+
                                "<tr>"+
                                  "<td width=\"35\"  class=\"grid_header\">Del</td>"+
                                  "<td width=\"145\" class=\"grid_header\">Garment Pack </td>"+
                                  "<td width=\"144\" height=\"18\" class=\"grid_header\">Garment Component </td>"+
                                  "<td width=\"207\" class=\"grid_header\">Embelishment Placement</td>";
								  
								  
	for (var col =1; col < noOfCols; col ++){
		var serviceID=tbl1.rows[col].cells[0].innerHTML;
		var service=tbl1.rows[col].cells[1].innerHTML;
		tableText += "<td width=\"200\" class=\"grid_header\" id=\"" + serviceID + "\">"+service+"</td>";	
	}
tableText += "<td width=\"191\" class=\"grid_header\">Remarks</td></tr>";

	for (var rw =1; rw < noOfRows; rw ++){
		
		  var packID =  tbl2.rows[rw].cells[1].id;
		  var pack =  tbl2.rows[rw].cells[1].innerHTML;
		  var compID =  tbl2.rows[rw].cells[2].id;
		  var component =  tbl2.rows[rw].cells[2].innerHTML;
		  var placemntID =  tbl2.rows[rw].cells[3].id;
		  var placement =  tbl2.rows[rw].cells[3].innerHTML;
		  
		  
	tableText += "<tr>"+
				  "<td style=\"display:yes\" class=\"normalfntMid\" id=\"" + (noOfCols+4) + "\"><img src=\"../../images/del.png\"  onClick=\"deleteComponents(this.parentNode.parentNode.rowIndex);\"  class=\"mouseover\"></td>"+
				  "<td   class=\"normalfntMid\" id=\"" + packID + "\">"+pack+"</td>"+
				  "<td height=\"18\"  class=\"normalfntMid\" id=\"" + compID + "\">"+component+"</td>"+
				  "<td   class=\"normalfntMid\" id=\"" + placemntID + "\">"+placement+"</td>";	
				  
			for (var col =1; col < noOfCols; col ++){
				var serviceID=tbl1.rows[col].cells[0].innerHTML;
				var serviceCombo=tbl1.rows[col].cells[2].innerHTML;
				if((placemntID=='') || (placemntID==0)){
				serviceCombo='';	
				}
				tableText += "<td  id=\"" + serviceID + "\" class=\"normalfntMid\">"+serviceCombo+"</td>";	
			}
			
tableText += "<td  class=\"normalfntMid\" id=\"" + serviceID + "\"><input type=\"text\" class=\"txtbox\"  size=\"10px\" align =\"center\" ></td></tr>";
	}

tableText += "</table>"
document.getElementById("styleDefinition").innerHTML=tableText;

assignExistingEmbelismntTypes();

}
//---------------------------------------------------------------------------
function assignExistingEmbelismntTypes()
{
	var tbl = document.getElementById('tblStyleDefinition');
	var tbl1 = document.getElementById('tblStyleServices');
	var totalCols = tbl1.rows.length+4;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var style=document.getElementById('cboStyle').value;
				var styleCategory=document.getElementById('cboStyleCategory').value;
				var pack = URLEncode(tbl.rows[loop].cells[1].id);
				var component = URLEncode(tbl.rows[loop].cells[2].id);
				var embPlacement = URLEncode(tbl.rows[loop].cells[3].id);
				//var totalCols=tbl.rows[0].id;
				
				if((embPlacement!='') && (embPlacement!=0)){
					for( var col = 4 ;col < totalCols-1 ; col++ ){
					var service = URLEncode(tbl.rows[loop].cells[col].id);
					var url="styleDefinition-db-get.php?RequestType=loadExistingServices&style="+style+"&pack="+pack+"&component="+component+"&embPlacement="+embPlacement+"&service="+service+"&styleCategory="+styleCategory;
					var httpobj = $.ajax({url:url,async:false});
					var embType=httpobj.responseText;
					tbl.rows[loop].cells[col].childNodes[0].value=embType;
					}
				}
			}
}
//----------------------------------------------------------------------------
function saveStyleDefinitions()
{
		var tbl = document.getElementById('tblStyleDefinition');
		
	var tbl1 = document.getElementById('tblStyleServices');
	var totalCols = tbl1.rows.length+4;
		
		var style=document.getElementById('cboStyle').value;
		var styleCategory=document.getElementById('cboStyleCategory').value;
		
		var ArrayGarmentPack ="";
		var ArrayGarmentComponent ="";
		var ArrayEmbelishPlacement  ="";
		var ArrayService ="";
		var ArrayEmbelishType ="";
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var pack = URLEncode(tbl.rows[loop].cells[1].id);
				var component = URLEncode(tbl.rows[loop].cells[2].id);
				var embPlacement = URLEncode(tbl.rows[loop].cells[3].id);
				//var totalCols=tbl.rows[0].id;
				
				for( var col = 4 ;col < totalCols-1 ; col++ ){
					var service = URLEncode(tbl.rows[loop].cells[col].id);
					if((embPlacement!='') && (embPlacement!=0)){
					var embType = tbl.rows[loop].cells[col].childNodes[0].value;
					}
					else{
					embType='';	
					}
					ArrayGarmentPack += pack + ",";
					ArrayGarmentComponent += component + ",";
					ArrayEmbelishPlacement += embPlacement + ",";
					ArrayService += service+ ",";
					ArrayEmbelishType += embType + ",";
				}
		}
	
	url="";
	url="styleDefinition-db-set.php?RequestType=SaveStyleDefinitions&style="+style+"&styleCategory="+styleCategory+"&ArrayGarmentPack="+ArrayGarmentPack+"&ArrayGarmentComponent="+ArrayGarmentComponent+"&ArrayEmbelishPlacement="+ArrayEmbelishPlacement+"&ArrayService="+ArrayService+"&ArrayEmbelishType="+ArrayEmbelishType;	
	
		var httpobj = $.ajax({url:url,async:false});
		alert(httpobj.responseText);
		
	document.getElementById('cboStyle').value='';	
	document.getElementById('cboSC').value=''	
	document.getElementById('cboStyleCategory').value=''	
	loadGridStyleDefinition('');		
}
//-----------------------------------------------------------
function loadBuyerAndDevition(){
	var style=document.getElementById('cboStyle').value;
	var url="styleDefinition-db-get.php?RequestType=loadBuyerAndDevition&style="+style;
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("tblBuyerDivition").innerHTML=httpobj.responseText;
}
//-----------------------------------------------------------
function selectComponents(){
	
	var url  = "SampleRequisitionPopup.php";
	htmlobj=$.ajax({url:url,async:false});
	
	drawPopupAreaLayer(470,320,'RequisitionPopup',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('RequisitionPopup').innerHTML=HTMLText;
}

//-------------------------------------------------
function checkedAndDisableExistings(){
	
		var tbl1 = document.getElementById('tblComponents');
		var tbl2 = document.getElementById('tblStyleComponents');
		
		for ( var loop = 1 ;loop < tbl2.rows.length ; loop ++ )
		{
		  var packID1 =  tbl2.rows[loop].cells[1].id;
		  var compID1 =  tbl2.rows[loop].cells[2].id;
		  var placement1 =  tbl2.rows[loop].cells[3].innerHTML;
			
			for ( var loop2 = 1 ;loop2 < tbl1.rows.length ; loop2 ++ )
			{
			  var packID2 =  tbl1.rows[loop2].cells[2].id;
			  var compID2 =  tbl1.rows[loop2].cells[3].id;
			  var placement2 =  tbl1.rows[loop2].cells[4].innerHTML;

				  if((packID1==packID2)&&(compID1==compID2)&&(placement1==placement2)){
					 tbl1.rows[loop2].cells[1].childNodes[0].checked = true ; 
					 tbl1.rows[loop2].cells[1].childNodes[0].disabled = true;
				  }
			}
		}
		setDisabled();
}
//---------------------------------------------------
function setDisabled(){
	var tbl = document.getElementById('tblComponents');
	
	for ( var i = 1 ;i < tbl.rows.length ; i ++ )
	{
	var componentID=tbl.rows[i].cells[1].id;
			if((tbl.rows[i].cells[0].id==1) && (tbl.rows[i].cells[1].childNodes[0].checked ==true)){
				for( var j = i+1 ;j < tbl.rows.length ; j ++ ){	
					if(tbl.rows[j].cells[1].id==componentID){
						tbl.rows[j].cells[1].childNodes[0].disabled =true;
					}
				}
			}
			
			if((tbl.rows[i].cells[0].id==0) && (tbl.rows[i].cells[1].childNodes[0].checked ==true)){
				for( var j = 0 ;j < i ; j ++ ){	
					if((tbl.rows[j].cells[1].id==componentID) && (tbl.rows[j].cells[0].id==1)){
						tbl.rows[j].cells[1].childNodes[0].disabled =true;
					}
				}
			}
		}
}
//-------------------------------------------------
function closeWindow1(){
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
	
	
}
//-------------------------------------------------------
function deleteComponents(rowIndex){
	var tbl1 = document.getElementById('tblStyleDefinition');
	//if(confirm("Are you sure, you want to remove this record?")) 
	//{
	/*	if(tbl.rows[rowId].cells[0].id!=0){
		var path = "xml.php?RequestType=removeStitchRatio&id=" + tbl.rows[rowId].cells[0].id;  
		htmlobj = $.ajax( { url :path, async :false });
		var XMLResult = htmlobj.responseXML.getElementsByTagName("DeleteDetail");	 	 
	 	var feedBack = XMLResult[0].childNodes[0].nodeValue; 			 
		}*/
		//alert(rowIndex);
			var style=document.getElementById('cboStyle').value;
			var styleCategory=document.getElementById('cboStyleCategory').value;
		
		  var packID2 =  tbl1.rows[rowIndex].cells[1].id;
		  var compID2 =  tbl1.rows[rowIndex].cells[2].id;
		  var placement2 =  tbl1.rows[rowIndex].cells[3].innerHTML;
		  var placementID2 =  tbl1.rows[rowIndex].cells[3].id;
		  
		//var path = "styleDefinition-db-set.php?RequestType=deleteRow&style="+style+"&styleCategory="+styleCategory+"&packID2="+packID2+"&compID2="+compID2+"&placementID2="+placementID2; 
		//htmlobj = $.ajax( { url :path, async :false });
		//alert(htmlobj.responseText); 			 
		  
		  if(placement2==0){
			 placement2=''; 
		  }
		
    	document.getElementById('tblStyleDefinition').deleteRow(rowIndex);
		
		  var tbl = document.getElementById('tblStyleComponents');
		  
		for ( var loop2 = 1 ;loop2 < tbl.rows.length ; loop2 ++ )
		{
		  var packID =  tbl.rows[loop2].cells[1].id;
		  var compID =  tbl.rows[loop2].cells[2].id;
		  var placement =  tbl.rows[loop2].cells[3].innerHTML;
		  if(placement==0){
			 placement=''; 
		  }
			//  alert(placement2);
			//  alert(placement);
		  if((packID==packID2)&&(compID==compID2)&&(placement==placement2)){
			document.getElementById('tblStyleComponents').deleteRow(loop2);
		  }
		  
		}
		
	//}
}
//-----------------------------------------------------------
function listing(){

  $(document).ready(function(){
    $("#browser").treeview();
 $("#add").click(function() {
 	var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
 		"<li><span class='file'>Item1</span></li>" + 
 		"<li><span class='file'>Item2</span></li>" +
 		"</ul></li>").appendTo("#browser");
 	$("#browser").treeview({
 		add: branches
 	});
 });
  });
	
}
//--------------------------------------------------------
function showPlacements(component){

	
		var tbl = document.getElementById('tblComponents');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var trComponent = URLEncode(tbl.rows[loop].id);
				if(component==trComponent){

					if(tbl.rows[loop].style.display=='none'){
					tbl.rows[loop].style.display = '';
					}
					else{
					tbl.rows[loop].style.display = 'none';
					}
					
				}
				
		}
}
//---------------------------------------------------------
function chechUncheck(rowIndex){
	//alert(rowIndex);
		var tbl = document.getElementById('tblComponents');
		if(tbl.rows[rowIndex].cells[1].childNodes[0].checked == true){
			var componentID=tbl.rows[rowIndex].cells[1].id;
			if(tbl.rows[rowIndex].cells[0].id==1){
				for( var i = rowIndex+1 ;i < tbl.rows.length ; i ++ ){	
					if(tbl.rows[i].cells[1].id==componentID){
						tbl.rows[i].cells[1].childNodes[0].checked =false;
					}
				}
			}
			else{
				for( var i = 0 ;i < rowIndex ; i ++ ){	
					if((tbl.rows[i].cells[1].id==componentID) && (tbl.rows[i].cells[0].id==1)){
						tbl.rows[i].cells[1].childNodes[0].checked =false;
					}
				}
			}
		}
	
}
//---------old----------------------------------------------
/*function saveStyleCateg()
{   

	    if(trim(document.getElementById('txtStyleCategoryCode').value)=="") 
		{
			alert("Please select \"Catogery Code\".");
			document.getElementById('txtStyleCategoryCode').focus(); 
			return false;
		}
        else if(trim(document.getElementById('txtStyleCategoryName').value)=="")
		{
			alert("Please select \"Catogery Name\".");
			document.getElementById('txtStyleCategoryName').focus();
			return ;
		}
		else if(!ValidateSaveSC())
		{
			return;
		}
		
			var url = "styleCatPopup-db-set.php?RequestType=saveStyleCateg";
			
			url=url+"&Id="+URLEncode(document.getElementById("txtStyleCategoryID").value);			
			url=url+"&code="+URLEncode(document.getElementById("txtStyleCategoryCode").value);			
			url=url+"&name="+URLEncode(document.getElementById("txtStyleCategoryName").value);
			if(document.getElementById("txtStyleCategoryActive").checked==true)
				var status = 1;	
			else
				var status = 0;
			url=url+"&status="+status;
			var httpobj = $.ajax({url:url,async:false});
			
		alert(httpobj.responseText);
		newStyleCateg();
		loadGridSC();
 } 
//--------------------------------------------------------------
function ValidateSaveSC()
 {	
	var id=document.getElementById("txtStyleCategoryID").value;
	var code=document.getElementById("txtStyleCategoryCode").value;
	var name=document.getElementById("txtStyleCategoryName").value;
	var x_find=checkInField('d2d_master_stylecategory','strStyleCategoryCode',code,'intStyleCategoryId',id);
	
	if(x_find)
	    {
			alert('Category Code "'+code+'" is already exist.');		
			document.getElementById("txtStyleCategoryCode").select();
			return false;
	    }
	else{
	var x_find=checkInField('d2d_master_stylecategory','strStyleCategoryName',name,'intStyleCategoryId',id);
			if(x_find)
			{
				alert('Category name "'+name+'" is already exist.');		
				document.getElementById("txtStyleCategoryName").select();
				return false;
			}
	   }  
       return true;	
}
//---------------------------------------------------------------
function loadGridSC() {
	var url="styleCatPopup-db-get.php?RequestType=loadGrid";
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("styleCategoryMaster").innerHTML=httpobj.responseText;
}
//---------------------------------------------------------------
function deleteRowSC(id) {
var r=confirm("Are you sure you want to delete category?");
	if(r==true)		
	{
	var url="styleCatPopup-db-set.php?RequestType=deleteRow&id="+id;		
	var httpobj = $.ajax({url:url,async:false});
	loadGridSC();
	alert(httpobj.responseText);
	}
}
//---------------------------------------------------------------
function editRowSC(id,code,name,active) {
document.getElementById("txtStyleCategoryID").value=id;
	document.getElementById("txtStyleCategoryCode").value=code;
	document.getElementById("txtStyleCategoryName").value=name;
	if(active==1){
	document.getElementById("txtStyleCategoryActive").checked=true;
	}
	else{
	document.getElementById("txtStyleCategoryActive").checked=false;
	}
}*/
//-----------------------------------------------------------
