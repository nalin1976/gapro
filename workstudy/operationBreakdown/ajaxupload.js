function updateOreder(str)
{ 
 
	if (str=="") {
  		document.getElementById("ordersdiv").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("ordersdiv").innerHTML=xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadoperation&data="+str,true);
	xmlhttp.send();
}

function updateHeader(str)  {	 

    document.getElementById('ordercombo').value= str;
    document.getElementById('styleNo').value = str;
	
	document.getElementById('machineSMV').value = "";
	document.getElementById('helperSMV').value = "";		
	document.getElementById('totalSMV').value = "";
	document.getElementById('workHours').value = 9;
//	document.getElementById('txtOperators').value = "";
	document.getElementById('totalOutputHr').value = "";
	document.getElementById('machineOutputHr').value = "";
	document.getElementById('comments').value = "";

	var path 	= "getorders.php?req=loadgridHeader&data="+str;		
	htmlobj1 	= $.ajax({url:path,async:false});
			  var XMLWorkHrs = htmlobj1.responseXML.getElementsByTagName("workingHrs");
			  var XMLcomments = htmlobj1.responseXML.getElementsByTagName("comments");
			  var XMLflag = htmlobj1.responseXML.getElementsByTagName("flag");
			  var XMLmachineSMV = htmlobj1.responseXML.getElementsByTagName("machineSMV");
			  var XMLhelperSMV = htmlobj1.responseXML.getElementsByTagName("helperSMV");
			  
			  if(XMLflag[0].childNodes[0].nodeValue!=0){
				machineSMV 	= parseFloat(XMLmachineSMV[0].childNodes[0].nodeValue);
				helperSMV  	= parseFloat(XMLhelperSMV[0].childNodes[0].nodeValue);
				totalSMV 	= parseFloat(XMLmachineSMV[0].childNodes[0].nodeValue)+parseFloat(XMLhelperSMV[0].childNodes[0].nodeValue);
				  
				totalSMV 	= totalSMV.toFixed(2);
				machineSMV 	= machineSMV.toFixed(2);
				helperSMV  	= helperSMV.toFixed(2);

				document.getElementById("workHours").value=XMLWorkHrs[0].childNodes[0].nodeValue;
				document.getElementById("comments").value=XMLcomments[0].childNodes[0].nodeValue;
				document.getElementById("machineSMV").value=machineSMV;
				document.getElementById("helperSMV").value=helperSMV;
				document.getElementById("totalSMV").value=totalSMV;
			  }
			 
 	/*var tbl = document.getElementById('tblOperationSelection');		 
	
	var machineSMV=0;
	var helperSMV=0;
	var totalSMV=0;
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
	   var smv=tbl.rows[loop].cells[6].childNodes[0].value;
	   if(tbl.rows[loop].cells[7].childNodes[0].checked){
	   helperSMV +=parseFloat(smv);
	   }
	   else{
	   machineSMV +=parseFloat(smv);
	   }
	}
	
	totalSMV = parseFloat(helperSMV) + parseFloat(machineSMV);	
	totalSMV 	= totalSMV.toFixed(2);
	machineSMV 	= machineSMV.toFixed(2);
	helperSMV  	= helperSMV.toFixed(2);
	
	//alert(totalSMV.toFixed(2));
	 
	document.getElementById('machineSMV').value = machineSMV;
	document.getElementById('helperSMV').value  = helperSMV;
	document.getElementById('totalSMV').value   = totalSMV;	*/
//-----------	 
			  
			  
}



function updateDataGrid(str)  {	 

	document.getElementById('dataAdded').value 	= "ok";		
	var path 	= "getorders.php?req=loadgrid&data="+str.trim();		
	htmlobj 	= $.ajax({url:path,async:false});		 	
	document.getElementById("datagrid").innerHTML = htmlobj.responseText;		
	
loadStyleCategoryGrid();

loadjs();
	
insertGridColor();

}
//----------------style Catogory data loading to the grid--------------------
function loadStyleCategoryGrid()
{
    var style=document.getElementById('styleNo').value.trim();
	var path 	= "getorders.php?req=loadStyleCategoryGrid&style="+style;		
	htmlobj 	= $.ajax({url:path,async:false});		 	
	document.getElementById("datagrid2").innerHTML = htmlobj.responseText;		
}
//---------------------------------------------------------
function setInputBox(row,colom){
		var tbl = document.getElementById('tblStyleCategory');
		var val=tbl.rows[row].cells[colom].innerHTML;
		if(document.getElementById('txtInputBoxFlag').value==0){
		tbl.rows[row].cells[colom].innerHTML="<input type=\"text\" value=\""+val+"\" size=\"5\"  style=\"text-align:right\" onblur=\"RemoveInputBox("+row+","+colom+")\" class=\"txtbox\" >";
		tbl.rows[row].cells[colom].childNodes[0].select();
		document.getElementById('txtInputBoxFlag').value=1;
		}
}
//-----------------------------------------------
function RemoveInputBox(row,colom){
		var tbl = document.getElementById('tblStyleCategory');
		var val=tbl.rows[row].cells[colom].childNodes[0].value;
		//alert(val);
		tbl.rows[row].cells[colom].innerHTML=val;
	    document.getElementById('txtInputBoxFlag').value=0;
}
//---------------------------------------------
function loadjs()
{
	$(document).ready(function() {
	// Initialise the first table (as before)
	$("#tblOperationSelection").tableDnD();
	// Make a nice striped effect on the table
});
}

function hideColums(){
  	 
    var tbl  = document.getElementById('tblOperationSelection');
    var rows = tbl.getElementsByTagName('tr');
	 
   
   for(iteration=0;iteration<tbl.rows.length;iteration++){ 
	for (var ce=7; ce<12; ce++) {
	 	//alert(iteration);	  
       var cels = rows[iteration].getElementsByTagName('td');
       
	   //cels[ce].style.display='none';
	  
    }
   }
	
}


/*for (var i = 0; i < oTable.rows.length; i++)
{
 oTable.rows[i].style.fontWeight = "bold";
}
oTable.rows[iRow].oRow.cells[iCell].style.color = "red";
oTable.rows[iRow].cells[iCell].style.color = "red";
oTable.rows[iRow].oRow.cells[iCell].class = "normalfnt";*/



function updateComCat(str){
	
	//if (str=="")  {
  	//	document.getElementById("componentDiv").innerHTML = "";
  	//	return;
  //	}
	if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else  {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("componentDiv").innerHTML = xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadComponent&data="+str,true);
	xmlhttp.send();
}

function updateComCatForOpSelection(str){
	
	document.getElementById('operation').value = "";
	document.getElementById('cboMachine').value = "";
	document.getElementById('machine').value = "";
	document.getElementById('smv').value = "";
	
  		document.getElementById("datagrid1").innerHTML = "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable\" id=\"tblOperationSelection1\">"+
		"<caption></caption>"+
		"<tr>"+
		"<th>Serial No</th>"+
		"<th>Machine</th>"+
		"<th>Category</th>"+
		"<th>Components</th>"+
		"<th>Opt Code</th>"+
		"<th>Operations</th>"+
		"<th>SMV</th>"+
		"<th>Manual</th>"+
		"<th bgcolor=\"#498cc2\" class=\"normaltxtmidb2\" style=\"display:none\">intMachineTypeId</th>"+
		"<th  style=\"display:none\">co</th>"+
		"<th style=\"display:none\">cc</th>"+
		"<th style=\"display:none\">opID</th>"+
		"<th style=\"display:none\">i/m</th>"+
		"<th># Opr</th>"+
		"<th>Target 100%</th>"+
		"<th>SMV (TMU)</th>"+
		"<th>&nbsp;</th>"+
		"</tr></table>";
	//if (str=="")  {
  	//	document.getElementById("componentDiv").innerHTML = "";
  	//	return;
  //	}
	if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else  {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("componentDiv").innerHTML = xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadComponentForOPer&data="+str,true);
	xmlhttp.send();
	
	loadCategoryDet();
}
//----------------------------------
function loadCategoryDet(){
	
	var style 	= document.getElementById('style_no').value;
	var category 	= document.getElementById('comCat').value;
	path="";
	path="getorders.php?req=loadStyleCategoryDet&style="+style+"&category="+category;	
	
	htmlobj=$.ajax({url:path,async:false});
		var XMLTag = htmlobj.responseXML.getElementsByTagName("strTag");	 	 
	 	var tag = XMLTag[0].childNodes[0].nodeValue; 
	
	if(tag==1){
		var XMLTeams = htmlobj.responseXML.getElementsByTagName("teams");	 	 
	 	var teams = XMLTeams[0].childNodes[0].nodeValue; 
		document.getElementById('txtTeam1').value=teams;
		
		var XMLOperators = htmlobj.responseXML.getElementsByTagName("operators");	 	 
	 	var operators = XMLOperators[0].childNodes[0].nodeValue; 
		document.getElementById('txtOperators1').value=operators;

		var XMLHelpers = htmlobj.responseXML.getElementsByTagName("helpers");	 	 
	 	var helpers = XMLHelpers[0].childNodes[0].nodeValue; 
		document.getElementById('txtHelpers1').value=helpers;
	}
	else{
		document.getElementById('txtTeam1').value='';
		document.getElementById('txtOperators1').value='';
		document.getElementById('txtHelpers1').value='';
	}
}
//----------------------------------

function updateOperation(str){
	
	document.getElementById('cboMachine').value = "";
	document.getElementById('machine').value = "";
	document.getElementById('cboEpfNo').value = "";
	document.getElementById('smv').value = "";
	
	if (str=="") {
  		document.getElementById("operationDiv").innerHTML = "";
  		return;
  	}

	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else  {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("operationDiv").innerHTML=xmlhttp.responseText;
		}
  	}

	xmlhttp.open("GET","getorders.php?req=loadOperation&data="+str,true);
	xmlhttp.send();
	/*var url="getorders.php?req=loadOperation&data="+str;
	htmlobj = $.ajax( { url :path, async :false });
	document.getElementById("operationDiv").innerHTML=xmlhttp.responseText*/
	
}

function updateOperationForOPerat(str){
	
	document.getElementById('cboMachine').value = "";
	document.getElementById('machine').value = "";
//	document.getElementById('cboEpfNo').value = "";
	document.getElementById('smv').value = "";
	
	if (str=="") {
  		document.getElementById("operationDiv").innerHTML = "";
  		return;
  	}
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else  {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("operationDiv").innerHTML=xmlhttp.responseText;
		}
  	}	
	xmlhttp.open("GET","getorders.php?req=loadOperation&data="+str,true);
	xmlhttp.send();	
	/*var url="getorders.php?req=loadOperation&data="+str;
	htmlobj = $.ajax( { url :path, async :false });
	document.getElementById("operationDiv").innerHTML=xmlhttp.responseText*/
	
}

function updateMachine(str) {
	document.getElementById('cboMachine').value = "";
	document.getElementById('machine').value = "";
	document.getElementById('cboEpfNo').value = "";
	document.getElementById('smv').value = "";
	
	if (str=="") {
  		document.getElementById("machineDiv").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("machineDiv").innerHTML=xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadMachine&data="+str,true);
	xmlhttp.send();
	 
}

function updateMachineForOperat(str) {
	document.getElementById('cboMachine').value = "";
	document.getElementById('machine').value = "";
//	document.getElementById('cboEpfNo').value = "";
	document.getElementById('smv').value = "";
	
	if (str=="") {
  		document.getElementById("machineDiv").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("machineDiv").innerHTML=xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadMachine&data="+str,true);
	xmlhttp.send();
	 
}

function loadMachineTypes()
{
	var intMachine = document.getElementById('cboMachine').value;
	var url = "SELECT ws_machinetypes.intMachineTypeId, ws_machinetypes.strMachineName FROM ws_machinetypes WHERE ws_machinetypes.intMachineId =  '"+intMachine+"'";
	loadCombo(url,'cboMachine');	
}
function setSMV(txt) {
	 
	
	var styleNo 	= document.getElementById('style_no_data').value;
	var comCat 		= document.getElementById('comCat').value;
	var component 	= document.getElementById('component').value;
	var operation 	= document.getElementById('operation').value;
	//var machine 	= document.getElementById('machine').value;
	 
	var path = "xml.php?RequestType=setSMV&styleNo=" + styleNo + "&comCat=" + comCat + "&component=" + component + "&operation=" + operation;// + "&machine=" + machine; 
	
	htmlobj = $.ajax( { url :path, async :false });

	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");	  
	var XMLMachine = htmlobj.responseXML.getElementsByTagName("intMachine");	
	var XMLResult1 = htmlobj.responseXML.getElementsByTagName("intMachineType");		  
	
	if(txt=='loadAll')
	{
	var url = 'SELECT DISTINCT(intMacineID), strName FROM ws_machines ORDER BY intMacineID ASC';
	loadCombo(url,'cboMachine');
	document.getElementById('machine').innerHTML = '';
	}
	else
	{
		var url = 'SELECT DISTINCT(intMacineID), strName FROM ws_machines WHERE intMacineID='+XMLMachine[0].childNodes[0].nodeValue+' ORDER BY intMacineID ASC';	
		loadCombo(url,'cboMachine');
		
	document.getElementById('cboMachine').value=XMLMachine[0].childNodes[0].nodeValue;
	
	if(XMLResult[0].childNodes[0].nodeValue!=""){
		document.getElementById('smv').value = XMLResult[0].childNodes[0].nodeValue;
	}else{
		document.getElementById('smv').value = 0;
	}  
	
	if(XMLResult1[0].childNodes[0].nodeValue!=0){
		document.getElementById('manual').checked  = true;
		
		var x=document.getElementById("machine")
		x.selectedIndex = 0;		 
		x.disabled=true		 
		 
	}else{
		document.getElementById('manual').checked = false;		
		var x=document.getElementById("machine")
		x.disabled=false
	} 
}
	
	
	
		
}


function setSMVLay() {
	var styleNo 	= document.getElementById('style_no_data').value;
	var comCat 		= document.getElementById('comCat').value;
	var component 	= document.getElementById('component').value;
	var operation 	= document.getElementById('operation').value;
	//var machine 	= document.getElementById('machine').value;
	var path = "xml.php?RequestType=setSMV&styleNo=" + styleNo + "&comCat=" + comCat + "&component=" + component + "&operation=" + operation;// + "&machine=" + machine; 
	
	htmlobj = $.ajax( { url :path, async :false });

	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");	  
	if(XMLResult[0].childNodes[0].nodeValue!=""){
		document.getElementById('smv').value = XMLResult[0].childNodes[0].nodeValue;
		document.getElementById('txtTmu').value =60/parseFloat(XMLResult[0].childNodes[0].nodeValue);
		
	}else{
		document.getElementById('smv').value = 0;
		document.getElementById('txtTmu').value = 0;
	}  
	
	var XMLResult1 = htmlobj.responseXML.getElementsByTagName("intMachineType");		  
	if(XMLResult1[0].childNodes[0].nodeValue!=0){
		document.getElementById('manual').checked  = true;
		
		var x=document.getElementById("machine")
		x.selectedIndex = 0;		 
		x.disabled=true		 
		 
	}else{
		document.getElementById('manual').checked = false;		
		var x=document.getElementById("machine")
		x.disabled=false
	} 	
}

function addOperationToLayout(rowId)	{
	
	if(checkLeftPreviousLine(rowId)){
		var styleNo = 0;
		styleNo = document.getElementById('txtStyleNo').value;
		if(styleNo == "" || styleNo == 0) {
			alert("Please select the order number!");
		}else
		{		 
			var url  = "operationsBox.php?rowid="+rowId+"&styleNo="+styleNo+"&side='left'";
			htmlobj=$.ajax({url:url,async:false});		
			drawPopupBox(400,160,'frmOpBox',2);				
			var HTMLText=htmlobj.responseText;
			document.getElementById('frmOpBox').innerHTML=HTMLText;	
		}
	}
}

function addOperationToRightTableLayout(rowId)	{
	
	if(checkRightPreviousLine(rowId)){
		
		var styleNo = 0;
		styleNo = document.getElementById('txtStyleNo').value;
		if(styleNo == "" || styleNo == 0) {
			alert("Please select the order number!");
		}else
		{		 
			var url  = "operationsBox.php?rowid="+rowId+"&styleNo="+styleNo+"&side='right'";
			htmlobj=$.ajax({url:url,async:false});		
			drawPopupBox(400,160,'frmOpBox',2);				
			var HTMLText=htmlobj.responseText;
			document.getElementById('frmOpBox').innerHTML=HTMLText;	
		}
	}
}

function checkRightPreviousLine(rowId){
	
	if(rowId>87){
		return true;	
	}else{
		var tbl = document.getElementById('tblLayoutOperationRight');
		 
		var exist = 0;	 	
		var nextStart = 0;
		if(rowId%3 ==0 ){		 
			nextStart = rowId+1;
		}else{		
			nextStart = (parseInt(rowId/3)+1)*3 + 1;
		}	
		var loop =nextStart;
		for(loop; loop < nextStart+3 ; loop++) {			 
			if(tbl.rows[loop].cells[3].lastChild.nodeValue > 0){
				exist ++;
			}
		}
		if(exist==0){
			alert("No added operation in previous line, Please assign operation there.");
			return false
		}else{
			return true
		}
	}
}

function checkLeftPreviousLine(rowId){
	
	if(rowId>87){
		return true;	
	}else{
		var tbl = document.getElementById('tblLayoutOperationLeft');		 
		var exist = 0;	 	
		var nextStart = 0;
		if(rowId%3 ==0 ){		 
			nextStart = rowId+1;
		}else{		
			nextStart = (parseInt(rowId/3)+1)*3 + 1;
		}	
		var loop =nextStart;
		for(loop; loop < nextStart+3 ; loop++) {			 
			if(tbl.rows[loop].cells[3].lastChild.nodeValue > 0){
				exist ++;				
			}			
		}
		if(exist==0){
			alert("No added operation in previous line, Please assign operation there.");
			return false
		}else{
			return true
		}
	}
}

function closePopup1(){
	try {
		var box = document.getElementById('popupLayer1');
		box.parentNode.removeChild(box);
		loca = 0;
		//window.parent.reload();
	}catch(err){        
	}
}

function closePopup2(){
	try {
		var box = document.getElementById('popupLayer2');
		box.parentNode.removeChild(box);
		loca = 0;
		//window.parent.reload();
	}catch(err){        
	}
}

function CloseWindowOPBox(){
	try {
		var box = document.getElementById('frmOperatBox');
		box.parentNode.removeChild(box);
		loca = 0;
		//window.parent.reload();
	}catch(err){        
	}
}
//-----------------------------------------------
function loadScSyle(val){
	document.getElementById('cboCopyPopupStyle').value="";
	document.getElementById('cboCopyPopupSC').value="";
	document.getElementById('cboCopyPopupStyle').value=val;
	document.getElementById('cboCopyPopupSC').value=val;
}
//------------------------------------------------
function loadOperationBreakDown()
{
	if(document.getElementById('styleNo').value==''){
	alert("Select the new style number");
	return false;	
	}
	
	var tbl = document.getElementById('tblOperationSelection');
	var existingRecords=tbl.rows.length;
	if(existingRecords>1){
	alert("Operations already breaked for this style");
	return false;	
	}
	
	if(document.getElementById('copyOperationBreakDown').style.visibility == "hidden")
		document.getElementById('copyOperationBreakDown').style.visibility = "visible";
	else
		document.getElementById('copyOperationBreakDown').style.visibility = "hidden";
	
}
//---------------------------------------------------------
function copyOperationBreakDown()
{
	existingStyle=document.getElementById('cboCopyPopupStyle').value
	newStyle=document.getElementById('styleNo').value;
	
	document.getElementById('styleNo').value=existingStyle;
	document.getElementById('ordercombo').value=existingStyle;
	
	updateDataGrid(existingStyle);
	updateHeader(existingStyle);
	document.getElementById('styleNo').value=newStyle;
	document.getElementById('ordercombo').value=newStyle;
	
		var tbl = document.getElementById('tblStyleCategory');
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[0].innerHTML=newStyle;
		}
	callClose();
}
//---------------------------------------------------------
function callClose()
{
	document.getElementById('copyOperationBreakDown').style.visibility = "hidden";
}


/*function  setStyleNoInLayout(styleID){
	document.getElementById('txtStyleNo').value = styleID;
}*/

/*function deleteRecord(obj)	{

	var currID = obj.id;
    //var curr = obj.parentNode.parentNode.cells[1].childNodes[0].nodeValue;
   	//var exRate = obj.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
    //var dfrom = obj.parentNode.parentNode.cells[3].childNodes[0].nodeValue;
   	var r=confirm("Are you sure, you want to delete this record?");
    if (r==true)
    {        
       createXMLHttpRequest();       
       xmlHttp.onreadystatechange = HandleExDelete;
       xmlHttp.index = obj.parentNode.parentNode.rowIndex;
       xmlHttp.open("GET", pub_url+'xml.php?RequestType=deleteRecord&currID='+currID+'&exRate='+ exRate+'&dfrom='+dfrom , true);
       xmlHttp.send(null);
    }
	
}*/

/// fallowing one is not used
function isset (a) {     
    var a = arguments, l = a.length, i = 0, undef;    
    if (l === 0) {
        throw new Error('Empty isset'); 
    }    
    while (i !== l) {
        if (a[i] === undef || a[i] === null) {
            return false; 
        }
        i++; 
    }
    return true;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
function addNewCategory()
{
	var strCategory = prompt("Please enter category name.").trim();	
	if(strCategory!='')
	{
		saveCategory(strCategory);
	}
}

function saveCategory(name)
{
	var url = "operationBreakDown_popup_set.php?id=saveCategory&name="+name;
	var obj = $.ajax({url:url,async:false})	;
	
	if(obj.responseText!='')
			alert(obj.responseText);
	loadCategory();
}

function loadCategory()
{
	var url = "operationBreakDown_popup_get.php?id=loadCategory";
	var obj = $.ajax({url:url,async:false})	;
	document.getElementById('comCat').innerHTML = obj.responseText;
	
}
//////////////////////////////////////////////////////////////////////////////////////

/*function loadComponentsCatWise(intCatId)
{
	var cmbProcessId   = document.getElementById('cmbProcessId').value;
	var intCatId   = document.getElementById('comCat').value;
	var url = "operationBreakDown_popup_get.php?id=loadComponents&intCatId="+intCatId+"&cmbProcessId="+cmbProcessId;
	var obj = $.ajax({url:url,async:false})	;
	document.getElementById('component').innerHTML = obj.responseText;
	document.getElementById('operation').innerHTML='';
}*/

function addNewComponents()
{
	var intCatId = document.getElementById('comCat').value;
	if(intCatId=='0')
	{
		alert('Please select Component Category.');	
		return;
	}
	var strComponent = prompt("Please enter Component name.").trim();	
	if(strComponent!='')
	{
		var url = "operationBreakDown_popup_set.php?id=saveComponents&intCatId="+intCatId+"&name="+strComponent;
		var obj = $.ajax({url:url,async:false})	;
		if(obj.responseText!='')
			alert(obj.responseText);
		loadComponentsCatWise(intCatId);
	}
}

function loadOperations(intCompId)
{
	var intCatId = document.getElementById('comCat').value;
	var cmbProcessId   = document.getElementById('cmbProcessId').value;
	var url = "operationBreakDown_popup_get.php?id=loadOperations&intCompId="+intCompId+"&intCatId="+intCatId+"&cmbProcessId="+cmbProcessId;
	var obj = $.ajax({url:url,async:false});
	document.getElementById('operation').innerHTML = obj.responseText;
}

function addNewOperation()
{
	var intCatId = document.getElementById('comCat').value;
	var intCompId = document.getElementById('component').value;
	if(intCatId=='0')
	{
		alert('Please select Component Category.');	
		return;
	}
	else if(intCompId=='0')
	{
		alert('Please select Component.');	
		return;	
	}
	
	var url  = "Operations2.php?";
	    url += "&intCatId="+intCatId;
		url += "&intCompId="+intCompId;
	inc('Button.js');
	var W	= 100;
	var H	= 50;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp22(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function CreatePopUp22(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose)
{
	createXMLHttpRequestforTitle();	
	xmlHttpForTitle.onreadystatechange=CreatePopUpRequest22;
	xmlHttpForTitle.W = W;
	xmlHttpForTitle.H = H;
	
	xmlHttpForTitle.tdHeader = tdHeader;
	xmlHttpForTitle.tdDelete = tdDelete;
	xmlHttpForTitle.tdPopUpClose = tdPopUpClose;
	
	xmlHttpForTitle.closePopUp = closePopUp;
	xmlHttpForTitle.open("GET",url ,true);
	xmlHttpForTitle.send(null);
}

function CreatePopUpRequest22()
{
	if (xmlHttpForTitle.readyState==4 && xmlHttpForTitle.status==200)
	{
			var W 			= 0;
			var H 			= 0;
			var closePopUp 	= xmlHttpForTitle.closePopUp;
			var zIn = ++pub_zIndex;
			drawPopupBox22(W,H,'frmPopUp'+zIn,(zIn));				
			var HTMLText=xmlHttpForTitle.responseText;		
			
			HTMLText = HTMLText.replace(/main_bottom/gi,'main_bottompop');
			
			document.getElementById('frmPopUp'+zIn).innerHTML = HTMLText;
			document.getElementById(xmlHttpForTitle.tdHeader).innerHTML = "";
			//popup_close_button
			document.getElementById(xmlHttpForTitle.tdPopUpClose).innerHTML = "<img onclick=\""+closePopUp+"("+zIn+");\" align=\"right\" src=\"/gapro/images/cross.png\" />";
			
/*			document.getElementById(xmlHttpForTitle.tdHeader).innerHTML = "<img  align=\"right\" src=\"/gapro/images/closelabel.gif\" alt=\"Close\" name=\"Close\"  border=\"0\" id=\"Close\" onclick=\""+closePopUp+"("+zIn+");\"/>";*/				
			//document.getElementById(xmlHttpForTitle.tdDelete).innerHTML = '';
	}		
}

  function drawPopupBox22(width,height,popupname,zindex)
{
	 var popupbox = document.createElement("div");
     popupbox.id = "popupLayer" + zindex;
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = zindex;
     popupbox.style.left = 30 + 'px';
     popupbox.style.top = 10 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;margin-left:-250px;margin-top:-20px;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#550000;\">"+
					"<table width=\"" +width + "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td width=\"" + width + "\" height=\"" +  height + "\" align=\"center\" valign=\"middle\">Loading.....</td>"+
						"</tr>"+
					"</table>"+
					"</div><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\""+ (((screen.height - height)/4)+100) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					"</table>"+				
					"</div>";
    popupbox.innerHTML = htmltext;     
    document.body.appendChild(popupbox);
}

function CloseWindowOpBox2(){
	try {
		var box = document.getElementById('frmPopOperation');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}
}

function drawPopupAreaLayer1(width,height,popupname,zindex)
{
	

	 var popupbox = document.createElement("div");
     popupbox.id = "popupLayer";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = zindex;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px; margin-left:-220px; text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;position:absolute;\">"+
					"<table width=\"" +width + "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td width=\"" + width + "\" height=\"" +  height + "\" align=\"center\" valign=\"middle\">Loading.....</td>"+
						"</tr>"+
					"</table>"+
					"</div><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\""+ (((screen.height - height)/4)+100) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					"</table>"+				
					"</div>";
    popupbox.innerHTML = htmltext;     
    document.body.appendChild(popupbox);
    update();
}


function closeCountryModePopUp(id)
{

	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	
/*	closePopUpArea(id);
	
	var urlDetails="Button.php?q=LoadCountryMode";
	htmlobj=$.ajax({url:urlDetails,async:false});
	document.getElementById('currency_cboCountry').innerHTML=htmlobj.responseText;*/
	
	closePopUpArea(id);
	
	//var sql = "SELECT intConID,strCountry FROM country WHERE intStatus <>10 order by strCountry";
	//var control = "currency_cboCountry";
	//loadCombo(sql,control);

}

function loadMTypes(id)
{
	var url = "operationBreakDown_popup_get.php?id=loadMTypes&intMachineId="+id;
	var obj = $.ajax({url:url,async:false});
	document.getElementById('machine').innerHTML = obj.responseText;
}

function addNewMachines()
{
	var strMachine = prompt("Please enter Machine name.").trim();	
	if(strMachine!='')
	{
		var url = "operationBreakDown_popup_set.php?id=saveMachine&name="+strMachine;
		var obj = $.ajax({url:url,async:false})	;
		if(obj.responseText!='')
			alert(obj.responseText);
		loadMachines();
	}
}

function loadMachines()
{
	var url = "operationBreakDown_popup_get.php?id=loadMachines";
	var obj = $.ajax({url:url,async:false});
	document.getElementById('cboMachine').innerHTML = obj.responseText;
}

function addNewMachineTypes2()
{

	var strMachineType = prompt("Please enter Machine Type .").trim();	
	var strMachineType2 = prompt("Please enter Machine Type2 .").trim();	
	if(strMachineType=='')
		return;
	var intHelper	   = confirm('Is that Helper Machine ? \nIf yes please click on "OK" button else please do cancel.');
	if(intHelper)
		intHelper = 1;
	else
		intHelper = 0;
		
	if(strMachineType!='')
	{
		var url = "operationBreakDown_popup_set.php?id=saveMachineType&name="+strMachineType+"&intHelper="+intHelper+"&intMachine="+intMachine;
		var obj = $.ajax({url:url,async:false})	;
		if(obj.responseText!='')
			alert(obj.responseText);
		loadMTypes(intMachine);
	}
}

function addNewMachineTypes()
{
	var intCatId = document.getElementById('comCat').value;
	var intCompId = document.getElementById('component').value;
	if(intCatId=='0')
	{
		alert('Please select Component Category.');	
		return;
	}
	else if(intCompId=='0')
	{
		alert('Please select Component.');	
		return;	
	}
	
	var url  = "Machine2.php?";
	    url += "&intCatId="+intCatId;
		url += "&intCompId="+intCompId;
	inc('Button.js');
	var W	= 100;
	var H	= 50;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp22(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function loadSmv()
{
	var intMachineTypeId 	= document.getElementById('machine').value;
	var intOperationId		= document.getElementById('operation').value;
	var url = "operationBreakDown_popup_get.php?id=loadSmv&intMachineTypeId="+intMachineTypeId+"&intOperationId="+intOperationId;
	var obj = $.ajax({url:url,async:false})	;
	
	document.getElementById('smv').value = obj.responseText;
}
