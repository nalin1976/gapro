function saveOperationBrakDownSheet() {
	
 
	var styleNo1 		= URLEncode(document.getElementById('styleNo').value);
	var styleNo 		= URLEncode(document.getElementById('styleNo').value.trim());
	var machineSMV 		= document.getElementById('machineSMV').value;
	var comments 		= URLEncode(document.getElementById('comments').value);	 
	var helperSMV 		= document.getElementById('helperSMV').value;
	var totalSMV 		= document.getElementById('totalSMV').value;
	var workHours 		= document.getElementById('workHours').value;
	//	var operators 		= document.getElementById('txtOperators').value;
	//	var helpers 		= document.getElementById('txtHelpers').value;
	//	var teams 		= URLEncode(document.getElementById('txtTeam').value);
	//var totalOutputHr 	= document.getElementById('totalOutputHr').value;
	//var machineOutputHr 	= document.getElementById('machineOutputHr').value;
	if(styleNo1==''){
		alert("Please select a style.");
		return false;
	}
	else if(workHours==''){
		alert("Please enter Working hours.");
		document.getElementById('workHours').focus();
		return false;
	}
/*	else if(operators==''){
		alert("Please enter no of Operators.");
		document.getElementById('txtOperators').focus();
		return false;
	}*/
	
	var serial;
	var machine;
	var components;
	var optCode;
	var operations;
	var smv;
	var manual;
		
	var ArraySerial="";
	var ArrayMachine="";
	var ArrayComponents="";				
	var ArrayOptCode="";
	var ArrayOperations="";
	var ArraySMV="";
	var ArrayTgt="";
	var ArrayManual="";
				
	var tbl = document.getElementById('tblOperationSelection');
	//var noOfRows=tbl.rows.length-1; 
	//	console.log(tbl);
	if(tbl.rows.length>0)
	{
		var table_rows = tbl.rows.length;
		
		for ( var loop = 1 ;loop < tbl.rows.length; loop ++ )
		{
			 
			serial 		= loop;
			smv			= tbl.rows[loop].cells[6].childNodes[0].value;
			machine 	= URLEncode(tbl.rows[loop].cells[8].innerHTML);
			components 	= URLEncode(tbl.rows[loop].cells[9].innerHTML);
			optCode 	= URLEncode(tbl.rows[loop].cells[10].innerHTML);
			operations 	= URLEncode(tbl.rows[loop].cells[11].innerHTML);
			manual		= URLEncode(tbl.rows[loop].cells[12].innerHTML);
			if(ArraySerial!=""){ ArraySerial 	+= serial + ","; }else{ ArraySerial = serial + ","; } 
			if(ArrayMachine!=""){ ArrayMachine 	+= machine + ","; }else{ ArrayMachine = machine + ","; }
			if(ArrayComponents!=""){ ArrayComponents += components + ","; }else{ ArrayComponents = components + ",";}
			if(ArrayOptCode!=""){ ArrayOptCode 	+= optCode + ","; }else{ ArrayOptCode 	= optCode + ","; }
			if(ArrayOperations!=""){ ArrayOperations += operations + ","; }else{ ArrayOperations = operations + ","; }
			if(ArraySMV!=""){ ArraySMV += smv + ","; }else{ ArraySMV = smv+ ","; }
			if(ArrayManual!=""){ ArrayManual 	+= manual + ","; }else{ ArrayManual 	+= manual + ","; }			 
		}		 
	}
	 
	//+ "&workHours=" + workHours + "&totalOutputHr=" + totalOutputHr
 var path = "xml.php?RequestType=saveDet&styleNo=" + styleNo + "&machineSMV=" + machineSMV 
			+ "&comments=" + comments + "&helperSMV=" + helperSMV + "&totalSMV=" + totalSMV + "&workHours=" + workHours + "&table_rows=" + tbl.rows.length + "&ArraySerial=" + ArraySerial + "&ArrayMachine="+ArrayMachine			
			+ "&ArrayComponents=" + ArrayComponents + "&ArrayOptCode=" + ArrayOptCode
			+ "&ArrayOperations=" + ArrayOperations + "&ArraySMV=" + ArraySMV
			+ "&ArrayManual=" + ArrayManual; 	
			
	//alert(path);		
  
	htmlobj = $.ajax( { url :path, async :false });
	//alert(htmlobj.responseText);
	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	 //alert(XMLResult[0].childNodes[0].nodeValue);
	if (XMLResult[0].childNodes[0].nodeValue == "True") {
		//hideBackGroundBalck();
		document.getElementById('dataAdded').value = "ok";
		alert("Saved successfully.");
		document.getElementById('ordercombo').selectedIndex = 0; 
		document.getElementById('styleNo').selectedIndex = 0; 
		document.getElementById('machineSMV').value = "";
		document.getElementById('helperSMV').value = "";		
		document.getElementById('totalSMV').value = "";
		document.getElementById('workHours').value = 9;
	//	document.getElementById('txtOperators').value = "";
	//	document.getElementById('txtHelpers').value = "";
		document.getElementById('totalOutputHr').value = "";
		document.getElementById('machineOutputHr').value = "";
		document.getElementById('comments').value = "";
	//	document.getElementById('txtTeam').value = "";
  		document.getElementById("datagrid").innerHTML = "<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable\" id=\"tblOperationSelection\">"+
		"<caption style='background-color:#FBF8B3'></caption>"+
		"<tr>"+
		"<td style='background-color:#FBF8B3'>Serial No</td>"+
		"<td style='background-color:#FBF8B3'>Machine</td>"+
		"<td style='background-color:#FBF8B3'>Category</td>"+
		"<td style='background-color:#FBF8B3'>Components</td>"+
		"<td style='background-color:#FBF8B3'>Opt Code</td>"+
		"<td style='background-color:#FBF8B3'>Operations</td>"+
		"<td style='background-color:#FBF8B3'>SMV</td>"+
		"<td style='background-color:#FBF8B3'>Manual</td>"+
		"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\" style=\"display:none\">intMachineTypeId</td>"+
		"<th  style=\"display:none\">co</th>"+
		"<th style=\"display:none\">cc</th>"+
		"<th style=\"display:none\">opID</th>"+
		"<th style=\"display:none\">i/m</th>"+
		"<td style='background-color:#FBF8B3'># Opr</td>"+
		"<td style='background-color:#FBF8B3'>Target 100%</td>"+
		"<td style='background-color:#FBF8B3'>SMV (TMU)</td>"+
		"<td style='background-color:#FBF8B3'>&nbsp;</td>"+
		"</tr></table>";


//commented by sumith harshan		 
		//----------------------------------------------
/*		var tbl = document.getElementById('tblStyleCategory');
		noOfRows=tbl.rows.length-1;
		var ArrayStyle="";
		var ArrayCategory = "";
		var ArrayTeam = "";
		var ArrayOperators = "";
		var ArrayHelpers = "";
		var serial=tbl.rows.length;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			//var styleNo 		= URLEncode(document.getElementById('styleNo').value.trim());
				var styleNo = tbl.rows[loop].cells[0].innerHTML.trim();
				var category = URLEncode(tbl.rows[loop].cells[1].id);
				var team =  URLEncode(tbl.rows[loop].cells[2].innerHTML.trim());
				var operators = URLEncode(tbl.rows[loop].cells[3].innerHTML.trim());
				var helpers = URLEncode(tbl.rows[loop].cells[4].innerHTML.trim());
				//var team = URLEncode(tbl.rows[loop].cells[2].childNodes[0].value);
				//var operators= URLEncode(tbl.rows[loop].cells[3].childNodes[0].value);
				//var helpers = URLEncode(tbl.rows[loop].cells[4].childNodes[1].value);
				//alert(tbl.rows[loop].cells[4].childNodes[0].innerHTML);
				
				ArrayStyle += styleNo + ",";
				ArrayCategory += category + ",";
				ArrayTeam += team + ",";
				ArrayOperators += operators + ",";
				ArrayHelpers += helpers + ",";
		}
	
			path="";
			path="xml.php?RequestType=SaveStyleCategoryDetails&ArrayStyle="+ArrayStyle+"&ArrayCategory="+ArrayCategory+"&ArrayTeam="+ArrayTeam+"&ArrayOperators="+ArrayOperators+"&ArrayHelpers="+ArrayHelpers+"&serial="+serial;	
			
			htmlobj=$.ajax({url:path,async:false});
	
			document.getElementById("datagrid2").innerHTML="<table width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\" class=\"thetable\" id=\"tblStyleCategory\">"+
		"<caption></caption>"+
		"<tr>"+
		"<th>Style</th>"+
		"<th>Category</th>"+
		"<th>Teams</th>"+
		"<th>#Operators</th>"+
		"<th>#Helpers</th></tr></table>";*/
		//-------------------------------------------------
	saveStyleCategoryTable();	
		
		
	} else if (XMLResult[0].childNodes[0].nodeValue == "False") {
		alert("Save failed.");
	} 
}

// Sumith harshan  2011-05-05
function saveStyleCategoryTable()
{
	
	    var styleNo=document.getElementById('styleNo').value;
		var tbl = document.getElementById('tblStyleCategory');
		noOfRows=tbl.rows.length-1;
		var ArrayStyle="";
		var ArrayCategory = "";
		var ArrayTeam = "";
		var ArrayOperators = "";
		var ArrayHelpers = "";
		var serial=tbl.rows.length;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			//var styleNo 		= URLEncode(document.getElementById('styleNo').value.trim());
				var styleNo = tbl.rows[loop].cells[0].id.trim();
				var category = URLEncode(tbl.rows[loop].cells[1].id);
				var team =  URLEncode(tbl.rows[loop].cells[2].innerHTML.trim());
				var operators = URLEncode(tbl.rows[loop].cells[3].innerHTML.trim());
				var helpers = URLEncode(tbl.rows[loop].cells[4].innerHTML.trim());
				//var team = URLEncode(tbl.rows[loop].cells[2].childNodes[0].value);
				//var operators= URLEncode(tbl.rows[loop].cells[3].childNodes[0].value);
				//var helpers = URLEncode(tbl.rows[loop].cells[4].childNodes[1].value);
				//alert(tbl.rows[loop].cells[4].childNodes[0].innerHTML);
				
				ArrayStyle += styleNo + ",";
				ArrayCategory += category + ",";
				ArrayTeam += team + ",";
				ArrayOperators += operators + ",";
				ArrayHelpers += helpers + ",";
		}
	
			path="";
			path="xml.php?RequestType=SaveStyleCategoryDetails&ArrayStyle="+ArrayStyle+"&ArrayCategory="+ArrayCategory+"&ArrayTeam="+ArrayTeam+"&ArrayOperators="+ArrayOperators+"&ArrayHelpers="+ArrayHelpers+"&serial="+serial+"&styleNo="+styleNo;	
			
			htmlobj=$.ajax({url:path,async:false});
	
			document.getElementById("datagrid2").innerHTML="<table class=\"thetable\" width=\"100%\" cellpadding=\"0\"  cellspacing=\"1\"  id=\"tblStyleCategory\" >"+
		"<caption style='background-color:#FBF8B3'></caption>"+
		"<tr>"+
		"<td style='background-color:#FBF8B3'>Style</td>"+
		"<td style='background-color:#FBF8B3'>Category</td>"+
		"<td style='background-color:#FBF8B3'>Teams</td>"+
		"<td style='background-color:#FBF8B3'>#Operators</td>"+
		"<td style='background-color:#FBF8B3'>#Helpers</td></tr></table>";
}




/// --------- popup window related javascript 
function loadComponents(obj) 
{	

	var SelectOption 	= document.frmOperationBrackDown.ordercombo;
	var SelectedIndex 	= SelectOption.selectedIndex;
	var SelectedValue	= SelectOption.value;
	var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
	
//	updateDataGrid(SelectedValue);
	
	var componantAdded = document.getElementById('dataAdded').value;
	
	//if(componantAdded=="ok"){		
		if(SelectedText != 'select'){
			$('#btnOperational').hide();  // hide clicke dbutton to prevent loading lyer again
			
			var url  = "operation_selection.php?data="+SelectedText;
			htmlobjPOP=$.ajax({url:url,async:false});

			
			drawPopupAreaLayer(828,564,'frmChemicals',1);				
			var HTMLText=htmlobjPOP.responseText;
			//alert(HTMLText);
			document.getElementById('frmChemicals').innerHTML=HTMLText;	
			
			var SelectOption 	= document.frmOperationBrackDown.styleNo;
			var SelectedIndex 	= SelectOption.selectedIndex;
			var SelectedValue 	= SelectOption.value;
			var SelectedText 	= SelectOption.options[SelectOption.selectedIndex].text;
			document.getElementById('style_no').value 		= SelectedText;
			
			var SelectOption 	= document.frmOperationBrackDown.ordercombo;
			var SelectedIndex 	= SelectOption.selectedIndex;
			var SelectedValue 	= SelectOption.value;
			document.getElementById('style_no_data').value 	= SelectedValue;
			
			document.getElementById('opmachineSMV').value 	= document.getElementById('machineSMV').value;
			document.getElementById('optotalSMV').value 	= document.getElementById('totalSMV').value;
			document.getElementById('ophelpSMV').value 		= document.getElementById('helperSMV').value;
			

    
			
			
			
		//	document.getElementById("datagrid1").innerHTML=document.getElementById("datagrid").innerHTML;
			
			
		//	alert(document.getElementById("datagrid").innerHTML);
			
		}else{
			//document.getElementById('message_viwer').innerHTML = "Please Select Order No !";
			 alert("Please Select Style No !");	
			
			 $("#msg").ajaxError(function(request, settings){ $(this).append("<li>Error requesting page </li>"); });


		}
		insertGridColor();

backgroundDisablePopup();

	//}else{
		//alert("Before click [NEW], save current data");
	//}
}


//*********Sumith**********2011-05-11*******************************************************************
// execute when operation selection popup, com cat combo onchange event

function loadDetailsToSMVtable()
{
   
    if(document.getElementById('comCat').value=='')
	{
	   	  //document.getElementById('txtTeam1').value 	=	'';
		  //document.getElementById('txtOperators1').value=	'';
		  //document.getElementById('txtHelpers1').value  =	'';	
		  return;
	}
	var category = document.getElementById('comCat').value;  // get selected category value of the combo
	var tblStyleCategory = document.getElementById('tblStyleCategory'); 
	var rowcount=tblStyleCategory.rows.length;
	
	for(var x=1; x<rowcount; x++)
	{
		var catID = tblStyleCategory.tBodies[0].rows[x].cells[1].id; // get tblStyleCategory category id
		if(catID==category)  // if tblStyleCategory category and combo category same, get data
		{ 
		  // get relevent row team, operators and helpers count and assgn it into popup text boxes
		  //document.getElementById('txtTeam1').value 	=	tblStyleCategory.tBodies[0].rows[x].cells[2].innerHTML;
		  //document.getElementById('txtOperators1').value=	tblStyleCategory.tBodies[0].rows[x].cells[3].innerHTML;
		  //document.getElementById('txtHelpers1').value  =	tblStyleCategory.tBodies[0].rows[x].cells[4].innerHTML;
	    }
		else
		{
		  //document.getElementById('txtTeam1').value 	=	'';
		  //document.getElementById('txtOperators1').value=	'';
		  //document.getElementById('txtHelpers1').value  =	'';	
		}
	}

}

// sumith   
function backgroundDisablePopup()
{

 //$('#comments').attr("disabled", true);

 var rowCount=document.getElementById('tblfrm').getElementsByTagName('tr').length;	
// alert(rowCount);
  //objElems = xForm.elements;
  for(i=0; i<rowCount.length; i++)
   {
    rows[i].disabled = true;
   }

}
 

//**************************************************************************************************************	

function CloseWindow(){
	if($('#PT').hide()) // if P/T button hide, show the P/T button 
	{
	$('#PT').show();  
	}
	if($('#btnOperational').hide())  // if operation button hide, show the operation button
	{ 
	$('#btnOperational').show(); 
	}
	
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}
}



function closeWindow2()
{
	try
	{
		var box = document.getElementById('popupLayer');
		removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function saveOperationSelection() {
 
	var styleNo 	= URLEncode(document.getElementById('style_no_data').value);
	var comCat 		= document.getElementById('comCat').value;
	var component 	= document.getElementById('component').value;
	var operation 	= document.getElementById('operation').value;	
	var manual 		= document.getElementById('manual').checked;	
	var machine 	= document.getElementById('machine').value;
	var smv 		= document.getElementById('smv').value;
	var machineSMV 	= document.getElementById('machineSMV').value;
	var helpSMV 	= document.getElementById('helpSMV').value;
	var totalSMV 	= document.getElementById('totalSMV').value;
	 
	var path = "xml.php?RequestType=saveOperationSelection&styleNo="+styleNo+
			+ "&comCat=" + comCat + "&component="+ component + "&operation=" + operation 
			+ "&manual=" + manual + "&machine=" + machine + "&smv=" + smv
			+ "&machineSMV=" + machineSMV + "&helpSMV=" + helpSMV + "&totalSMV=" + totalSMV;			

	htmlobj = $.ajax( { url :path, async :false });

	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");

	if (XMLResult[0].childNodes[0].nodeValue == "True") {
		hideBackGroundBalck();
		alert("Saved successfully.");		 
		updateDataGrid1(styleNo);
		
	} else if (XMLResult[0].childNodes[0].nodeValue == "False") {
		alert("Save failed.");
	} 
	 
}

function updateDataGrid1(str) {
	 
	if (str=="") {
  	//	document.getElementById("datagrid1").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	} else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)  {
			document.getElementById("datagrid1").innerHTML=xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadgrid&data="+str,true);
	xmlhttp.send();
}
//-----------------------------------------------------------------
function loadOperatorHelperTeam(style,category) {
 	   
	var path = "xml.php?RequestType=loadOperatorHelperTeam&style=" + style+"&category=" + category;  	
	htmlobj = $.ajax( { url :path, async :false });
	var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
	var teams = "";
	var operators = "";
	var helpers = "";
	if(XMLResult[0].childNodes[0].nodeValue!=0){
		
		var XMLTeams = htmlobj.responseXML.getElementsByTagName("teams");
		comment = XMLTeams[0].childNodes[0].nodeValue;
		document.getElementById('txtTeams').value = comment;  
		
		var XMLOperators = htmlobj.responseXML.getElementsByTagName("operators");
		comment = XMLOperators[0].childNodes[0].nodeValue;
		document.getElementById('txtOperators').value = comment;  
		
		var XMLHelpers = htmlobj.responseXML.getElementsByTagName("helpers");
		comment = XMLHelpers[0].childNodes[0].nodeValue;
		document.getElementById('txtHelpers').value = comment;  
	}
}
//------hem---------------------------------------------------------
function loadGrid(str,category) {
	 style=document.getElementById('cboOrderNo').value;
	if (style=="") {
  		//document.getElementById("datagrid").innerHTML="";
  		//return;
  	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	} else {// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)  {
			document.getElementById("datagrid").innerHTML=xmlhttp.responseText;
		}
  	}
	xmlhttp.open("GET","getorders.php?req=loadLayoutGrid&data="+str+"&category="+category,true);
	xmlhttp.send();
}
//-------------------------------------------------------------------
function moveOperationBreakDownSheet(data) 
{
	
	if($('#btnOperational').hide())  // if operation button hide, show the operation button
	{ 
	$('#btnOperational').show(); 
	}
	
	var gridData 	= document.getElementById('datagrid1').innerHTML;
	var machineSMV 	= document.getElementById('opmachineSMV').value;
	var helpSMV 	= document.getElementById('ophelpSMV').value;
	var totalSMV 	= document.getElementById('optotalSMV').value;
	
	//var team 			= document.getElementById('txtTeam1').value;
	//var noOfOperators 	= document.getElementById('txtOperators1').value;
	//var noOfHelpers 	= document.getElementById('txtHelpers1').value;
	
//	team="<input type=\"text\" value=\""+team+"\" size=\"5\"  style=\"text-align:right\"onclick=\"setInputBox(this.parentNode.rowIndex,2);\" >";
	//noOfOperators="<input type=\"text\" value=\""+noOfOperators+"\" size=\"5\"  style=\"text-align:right\"onclick=\"setInputBox(this.parentNode.rowIndex,3);\" >";
	//noOfHelpers="<input type=\"text\" value=\""+noOfHelpers+"\" size=\"5\"  style=\"text-align:right\" onclick=\"setInputBox(this.parentNode.rowIndex,4);\">";
	

// commented by sumith 2011-05-10	
/*	if(noOfOperators==''){
		alert("Please enter no of Operators.");
		document.getElementById('txtOperators1').focus();
		return false;
	}*/
	
	tblFrom	=	document.getElementById('tblOperationSelection1');
	tblTo	=   document.getElementById('tblOperationSelection');
	
	if(tblFrom.rows.length<=1)
	{
		alert("Operations not selected.");
		return false;
	}
	
	for ( var loop = 1 ;loop < tblFrom.rows.length ; loop ++ )
    {
		var operation1=tblFrom.rows[loop].cells[4].innerHTML.trim(); 
		var existRow=0;
		for ( var loop2 = 1 ;loop2 < tblTo.rows.length ; loop2 ++ )
		{
		   var operation2=tblTo.rows[loop2].cells[4].innerHTML.trim(); 
		   if(operation1==operation2){
				existRow=1;
		   }
		}
		if(existRow!=1){
			var row = tblFrom.rows[loop];
			tblTo.innerHTML += row.innerHTML;
		}
    }
// *****************Data insert to the tblStyleCategory ****************************************************************
		var tbl = document.getElementById('tblStyleCategory');
		var rowIndex='';
		for( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[1].id==tblFrom.rows[1].cells[2].id)
			{
				rowIndex=loop;
			}
		}

		
		
		for(var t=1;t<tblFrom.rows.length;t++)
		{
			var avala=0;
			
			for(var q=1;q<tbl.rows.length;q++)
			{
				if(tblFrom.rows[t].cells[2].id==tbl.rows[q].cells[1].id)
				{
					avala=1;
					break;
					
				}
			}
			
			if(avala==0)
			{
		var lastRow = tbl.rows.length;
		var row 	= tbl.insertRow(lastRow);
		
		
		//create first cell with data of the 3rd grid
		var cell0 		= row.insertCell(0);
		var textNode 	= document.createTextNode(document.getElementById('cboStyles').value);
		cell0.appendChild(textNode);
		cell0.id = document.getElementById('styleNo').value;
		cell0.align 	= "center";
		cell0.class		= "normalfntMid";
		
		//create 2nd cell with data of the 3rd grid
	
		
		var cell1 		= row.insertCell(1);
		var textNode 	= document.createTextNode(tblFrom.rows[t].cells[2].innerHTML.trim());
		cell1.appendChild(textNode);
		cell1.align 	= "center";
		cell1.class		= "normalfntMid";
		cell1.id		= tblFrom.rows[t].cells[2].id;
		
       //create team cell with data of the 3rd grid
		var cell2 		= row.insertCell(2);
		var textNode 	= document.createTextNode(t);
		cell2.appendChild(textNode);
		cell2.innerHTML	= 0;
		cell2.align 	= "right";
		cell2.class		= "normalfntRite";
		
		//create Operators cell with data of the 3rd grid
		var cell3 		= row.insertCell(3);
		cell3.appendChild(textNode);
		cell3.innerHTML	= 0;
		cell3.align 	= "right";
		cell3.class		= "normalfntRite";

		
		//create helpers cell with data of the 3rd grid
		var cell4 		= row.insertCell(4);
		cell4.appendChild(textNode);
		cell4.innerHTML	= 0;
		cell4.align 	= "right";
		cell4.class		= "normalfntRite";
		
		
		
			}
		}
		

	//document.getElementById('machineSMV').value   = machineSMV;
	//document.getElementById('helperSMV').value    = helpSMV;
	//document.getElementById('totalSMV').value     = totalSMV;	
	document.getElementById('dataAdded').value 	  = "not";	 
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		 
		
	}catch(err){        
	}

       for(var r=1;r<tbl.rows.length;r++)
	  {
	   
	    tbl.rows[r].cells[2].onclick = Function("setInputBox("+r+",2)");
                         
                      
        tbl.rows[r].cells[3].onclick = Function("setInputBox("+r+",3)");
                          
                      
        tbl.rows[r].cells[4].onclick = Function("setInputBox("+r+",4)");
                          
                      
					  
					
	  }

setSMVtoInputBox();	
loadjs();
}
//--------------------------------------------
function setSMVtoInputBox() {	

	var machineSMV=0;
	var helperSMV=0;
	var totalSMV=0;
	
	var tbl = document.getElementById('tblOperationSelection');
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var smv = tbl.rows[loop].cells[6].innerHTML;
		if(tbl.rows[loop].cells[6].id!=0){
		tbl.rows[loop].cells[6].innerHTML="<input type=\"text\" value=\""+smv+"\" size=\"5\"  style=\"text-align:right\" class=\"txtbox\" >";
		tbl.rows[loop].cells[6].id=0
		}
		
	}
	
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
	document.getElementById('totalSMV').value   = totalSMV;	
}
/// ---------- add row into the data dride table-------------------------
function addRow() {	  
	if(formValidate()) {
		
		var stlyeNo = document.getElementById('style_no_data').value;
		
		var SelectOption	= document.getElementById('operation');
		var SelectedIndex	= SelectOption.selectedIndex;
		var SelectedValue	= SelectOption.value;			  
		var operationID		= SelectedValue;			   
				
		//if(chechkAvailability(stlyeNo,operationID))  { // here check this combination of record is in the database 
		if(checkAvailbilityInThisTable())	{	
			var optotalSMV 	= document.getElementById('optotalSMV').value;
			  var tbl 			= document.getElementById('tblOperationSelection1');
			  
			  var nextRowIndex 	= tbl.rows.length; //for display next rpw id
			  
			  var lastRow 		= tbl.rows.length;// if there's no header row in the table, then iteration = lastRow + 1	  
			  var iteration 	= lastRow;
			  var row 			= tbl.insertRow(lastRow);

			  var cell0 		= row.insertCell(0);
			  var textNode 		= document.createTextNode(nextRowIndex);
			  cell0.appendChild(textNode);
			  cell0.align = "center";
			  cell0.class="normalfntMid";
			  
			  var SelectOption	= document.getElementById('machine');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell1 		= row.insertCell(1);
			  var textNode 		= document.createTextNode("-");
			  if(SelectedText !="select"){
				var textNode 	= document.createTextNode(SelectedText);
			  }	  
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";
			  
			  var SelectOption	= document.getElementById('comCat');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell2 		= row.insertCell(2);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell2.appendChild(textNode);
			  cell2.align = "center";
			  cell2.class="normalfntMid";
			   cell2.id=SelectedValue;
			  
			  var SelectOption	= document.getElementById('component');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell3 		= row.insertCell(3);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell3.appendChild(textNode);
			  cell3.align = "center";
			  cell3.class="normalfntMid";
			 			  
			  var SelectOption	= document.getElementById('operation');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell4 		= row.insertCell(4);
			  var textNode 		= document.createTextNode(SelectedValue);
			  cell4.appendChild(textNode);			  
			  cell4.align = "center";
			  cell4.class="normalfntMid";
			   
			  var SelectOption	= document.getElementById('operation');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell5 		= row.insertCell(5);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell5.appendChild(textNode);
			  cell5.align = "center";
			  cell5.class="normalfntMid";

			 			  
			  var cell6 		= row.insertCell(6);
			  var textNode 		= document.createTextNode(document.getElementById('smv').value);
			  cell6.appendChild(textNode);
			  cell6.align = "right";
			  cell6.class="normalfntMid";
			  cell6.id=1;
			 			  
			  var cell7 		= row.insertCell(7);			  
			  var manualStatus = 0;
			  if(document.getElementById('manual').checked){				 
				manualStatus = 1;
			  } 	  
			  var textNode1 	= document.createTextNode(manualStatus);
			  cell7.appendChild(textNode1);
			  
			  if(document.getElementById('manual').checked){ 
				cell7.innerHTML="<input type=\"checkbox\" checked=\"checked\" disabled=\"disabled\ >";				 
			  }else{
				cell7.innerHTML="<input type=\"checkbox\" disabled=\"disabled\ >";
			  }
			  cell7.align = "center";
			  cell7.class="normalfntMid";
			  			   
			  //set machine id
			  var SelectOption	= document.getElementById('machine');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell8 		= row.insertCell(8);
			  cell8.align = "right";
			  cell8.class="normalfntMid";

			  var textNode 		= document.createTextNode(SelectedValue);
			  cell8.appendChild(textNode);	   
			  cell8.style.display='none';
			   
			  //set component id
			  var SelectOption=document.getElementById('component'); 
			  var SelectedIndex=SelectOption.selectedIndex;
			  var SelectedValue=SelectOption.value;
			  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell9 = row.insertCell(9);
			  var textNode = document.createTextNode(SelectedValue);
			  cell9.appendChild(textNode);
			  cell9.style.display='none'; 
			  cell9.class="normalfntMid";
			  
			  //set com category id
			  var SelectOption=document.getElementById('comCat'); //machine,component,comCat
			  var SelectedIndex=SelectOption.selectedIndex;
			  var SelectedValue=SelectOption.value;
			  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell10 = row.insertCell(10);	 
			  var textNode = document.createTextNode(SelectedValue);
			  cell10.appendChild(textNode);
			  cell10.style.display='none';
			  cell10.class="normalfntMid";
			  
			  //set operation id
			  var SelectOption=document.getElementById('operation'); 
			  var SelectedIndex=SelectOption.selectedIndex;
			  var SelectedValue=SelectOption.value;
			  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell11 = row.insertCell(11);
			  var textNode = document.createTextNode(SelectedValue);
			  cell11.appendChild(textNode);
			  cell11.style.display='none';
			  cell11.class="normalfntMid";
			  
			  var cell12		= row.insertCell(12);
			  var manualStatus 	= 0;
			  if(document.getElementById('manual').checked){ manualStatus = 1; } 
			  var textNode1 	= document.createTextNode(manualStatus);
			  cell12.appendChild(textNode1);
			  cell12.style.display='none';
			  
			  var cell13		= row.insertCell(13);
			  var manualStatus 	= 0;
			  if(document.getElementById('manual').checked){ manualStatus = 1; } 
			  var textNode1 	= document.createTextNode(manualStatus);
			  cell13.appendChild(textNode1);
			  cell13.style.display='yes';
			  cell13.class="normalfntMid";
			  
			  //newly added rows listed here
		/*	  var cell12 		= row.insertCell(12);
			  var textNode 		= document.createTextNode(document.getElementById('smv').value);
			  cell12.appendChild(textNode);
			  cell12.class="normalfntMid";*/
			   
			  var cell14 		= row.insertCell(14);
			  var smv 			= document.getElementById('smv').value;
			  var target100		= 60/parseFloat(smv);
			  target100 		= target100.toFixed(2);	
			  var textNode 		= document.createTextNode(target100);
			  cell14.appendChild(textNode);
			  cell14.class="normalfntMid";
			  
			  var cell15 		= row.insertCell(15);
			  var smvTmu = 1667*document.getElementById('smv').value;
			  smvTmu 		= smvTmu.toFixed(2);	
			  var textNode 		= document.createTextNode(smvTmu);
			  cell15.appendChild(textNode);
			  cell15.class="normalfntMid";
			  
			  //set delete image			   
			  var SelectedText="-";	
			  var cell16 = row.insertCell(16);
			  var textNode = document.createTextNode(SelectedText);
			  cell16.appendChild(textNode);			  
 			  cell16.innerHTML="<img src=\"../../images/del.png\"  onClick=\"deleteNonDbRecord(this.parentNode.parentNode.rowIndex,this);\">";
			  cell16.class="normalfntMid";
			  
			  
			  var textNode = document.createTextNode(SelectedValue);
			 
			  var var1 = 0;
			  var var2 = 0;
			  
			  var var3 = 0;
			  var var4 = 0;
			  var var5 = 0;
			  
			  var var6 = 0;
			  var var7 = 0;
			  var var8 = 0;
			  
			  if(document.getElementById('optotalSMV').value!=""){
				var1 = document.getElementById('optotalSMV').value;
			  }
			  var2 = document.getElementById('smv').value;	  
			  var6 = parseFloat(var1)+parseFloat(var2);
			  var6 = var6.toFixed(2);
			  document.getElementById('optotalSMV').value = var6;
				
			  if(document.getElementById('manual').checked == true){  
				var3 = document.getElementById('ophelpSMV').value;
				if(var3 == ''){
					var3 = 0; 
				 }
				//var4 = parseFloat(document.getElementById('smv').value);
				
				var6 = parseFloat(var2) + parseFloat(var3);
				var6 = var6.toFixed(2);
				document.getElementById('ophelpSMV').value = var6;
			  }else{
				 //var5 = document.getElementById('machineSMV').value;
				 var4 =  document.getElementById('opmachineSMV').value;
				 if(var4 == ''){
					var4 = 0; 
				 }
				 //var4 = parseFloat(document.getElementById('smv').value);
				 var7 = parseFloat(var2) + parseFloat(var4);	
				 var7 = var7.toFixed(2);
				 document.getElementById('opmachineSMV').value = var7;  
			  }
			  ////////////////////////////////saveToAllocationTables//////////////////////////////////////
			  var 	url = "operationBreakDown_popup_set.php?id=allocateToTables";
			  		url += "&intCategory="+document.getElementById('comCat').value;
					
					url += "&intComponentId="+document.getElementById('component').value;
					url += "&intComponent="+document.getElementById('component').options[document.getElementById('component').selectedIndex].text;
					
					url += "&intOperationId="+document.getElementById('operation').value;
					url += "&intOperation="+document.getElementById('operation').options[document.getElementById('operation').selectedIndex].text;
					
					url += "&intManual="+manualStatus;
					
					//url += "&intMachine="+document.getElementById('cboMachine').value;
					
					url += "&intMachineTypeId="+document.getElementById('machine').value;
					url += "&intMachineType="+document.getElementById('machine').options[document.getElementById('machine').selectedIndex].text;
					
					url += "&dblSMV="+document.getElementById('smv').value;
					
			  var obj = $.ajax({url:url,async:false})	;
			  ////////////////////////////////////////////////////////////////////////////////////////////
			  
		}
		
		   //document.getElementById('comCat').selectedIndex=0;
		   //document.getElementById('component').selectedIndex=0;
		   document.getElementById('operation').selectedIndex=0;
		   document.getElementById('machine').selectedIndex=0;
		   //document.getElementById('cboMachine').selectedIndex=0;
		   document.getElementById('smv').value = "";
	}
}
//--------------------------
function addAllRows() {	 
var componentCateg=document.getElementById('comCat').value;
if(componentCateg==''){
	
	alert("Please select the component category.");
	return false;
}


	var tbl = document.getElementById('tblOperationSelection1');
    var comCat=document.getElementById('comCat').value;
	 
    var existRow=0;
    
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
    {
       var comCatExist=tbl.rows[loop].cells[0].id;               
       if(comCat==comCatExist){
        	existRow=1;
       }
    }
	
	var styleNo=document.getElementById('style_no').value;
 
	if(existRow==1)	{
	if(confirm("Are you sure, you want to remove existing record?")) 
	{
		var path = "xml.php?RequestType=removeAllRecord&styleNo=" + styleNo + "&componentCateg="+componentCateg;  
		htmlobj = $.ajax( { url :path, async :false });
		var XMLResult = htmlobj.responseXML.getElementsByTagName("deleteDetail");	 	 
	 	var feedBack = XMLResult[0].childNodes[0].nodeValue; 
		
		var path	= "allOperations_selections.php?componentCateg="+componentCateg;
		htmlobj		= $.ajax({url:path,async:false});
		document.getElementById('datagrid1').innerHTML=htmlobj.responseText;
	}	 
	}
	if(existRow==0)	{
		var path	= "allOperations_selections.php?componentCateg="+componentCateg+"&styleNo=" + styleNo;
		htmlobj		= $.ajax({url:path,async:false});
		document.getElementById('datagrid1').innerHTML =htmlobj.responseText;	
	}


}
//-------------------------
function chechkAvailability(stlyeNo,operationID){
			
	var path = "xml.php?RequestType=checkOpDetailAvailability&styleNo=" + stlyeNo + "&operationID=" + operationID; 			
  
	htmlobj = $.ajax( { url :path, async :false });

	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	 //(XMLResult[0].childNodes[0].nodeValue);
	
	 if((XMLResult[0].childNodes[0].nodeValue) > 1) {		 
		alert("Selected Style number and Operation related record is available. \n Please select the another combination."); 
		 return false;		 		
	} else{
		return true;
	} 	
}

function checkAvailbilityInThisTable() {
	
	var tbl = document.getElementById('tblOperationSelection1');
    var comCat=document.getElementById('comCat').value;
    var component=document.getElementById('component').value;
    var operation=document.getElementById('operation').value;
     
    var existRow=0;
    
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
    {
       var ope_ration=tbl.rows[loop].cells[11].innerHTML.trim();               
       if(operation==ope_ration){
        	existRow=1;
       }
    }
 
	if(existRow==1)	{
       alert("This combination is already exists!");        
       //document.getElementById('comCat').selectedIndex=0;
       //document.getElementById('component').selectedIndex=0;
       document.getElementById('operation').selectedIndex=0;
	   document.getElementById('machine').selectedIndex=0;
 	   document.getElementById('smv').value = "";
       return false;
    }else{
		return true;
	} 
}

//*********************Sumith Harshan 2011-05-05**************************
//delete 2nd grid details.(not delete from the database)
function deleteRowNew(obj)//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
{
	obj.parentNode.parentNode.parentNode.deleteRow(obj.parentNode.parentNode.rowIndex);
	var intCategory	=	obj.parentNode.parentNode.cells[2].id; 
	//alert(strCategory);
	
	var tblStyleCategory=document.getElementById('tblStyleCategory');
	var rowcount=tblStyleCategory.rows.length;
	//alert(rowcount);
	for(var x=1; x<rowcount; x++)
	{
	 var catID = tblStyleCategory.tBodies[0].rows[x].cells[1].id;
	 if(catID==intCategory)
	 {
		tblStyleCategory.deleteRow(x); 
	 }
	}
	//tblStyleCategory.tBodies[0].deleteRow();
	var styleNo		=	document.getElementById('styleNo').value;
	var url  = "xml.php?RequestType=deleteStyleCategoryRow&styleNo="+styleNo+"&intCategory="+intCategory;
	htmlobj  =	$.ajax({url:url,async:false});			
}



function deleteRow(rowId,opId,styleNo)  //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=
{
	obj.parentNode.parentNode.parentNode.deleteRow(obj.parentNode.parentNode.rowIndex);	
	
		var tbl1 = document.getElementById('tblOperationSelection');
		var tbl2 = document.getElementById('tblStyleCategory');
		
		var category=tbl1.rows[rowId].cells[2].id;
		var machineType=tbl1.rows[rowId].cells[12].innerHTML.trim();
		var smv=tbl1.rows[rowId].cells[6].childNodes[0].value;
		//alert(smv);
		
    	//document.getElementById('tblOperationSelection').deleteRow(rowId)
		//var path = "xml.php?RequestType=removeRecord&styleNo=" + styleNo + "&operationID=" + opId + "&machineType=" + machineType + "&smv=" + smv;  
		//htmlobj = $.ajax( { url :path, async :false });
		//var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");	 	 
	 //	var feedBack = XMLResult[0].childNodes[0].nodeValue; 
	 
	 //----------------------
	 var totalSMV=0;
	 var machineSMV=0;
	 var helperSMV=0;
	 
		for ( var loop = 1 ;loop < tbl1.rows.length ; loop ++ )
		{
		   var smv=tbl1.rows[loop].cells[6].childNodes[0].value;
		   if(tbl1.rows[loop].cells[7].childNodes[0].checked){
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
		
		document.getElementById('machineSMV').value = machineSMV;
		document.getElementById('helperSMV').value  = helperSMV;
		document.getElementById('totalSMV').value   = totalSMV;	
		//-----------------------------------
		var exist=0;
		for ( var loop = 1 ;loop < tbl1.rows.length ; loop ++ )
		{
			if(tbl1.rows[loop].cells[2].id==category)
			exist=1;
		}
		//-----
		if(exist==0){
			for ( var loop = 1 ;loop < tbl2.rows.length ; loop ++ )
			{
				if(tbl2.rows[loop].cells[1].id==category){
				tbl2.deleteRow(loop);
				var url  = "xml.php?RequestType=deleteCategory&styleNo="+styleNo+"&category="+category;
				htmlobj=$.ajax({url:url,async:false});		
				}
			}
		}
		//---
		if(tbl1.rows.length==1){
				var url  = "xml.php?RequestType=deleteStyle&styleNo="+styleNo;
				htmlobj=$.ajax({url:url,async:false});
				document.getElementById("machineSMV").value=0;
				document.getElementById("helperSMV").value=0;
				document.getElementById("totalSMV").value=0;
		}
		
		
	}	 


function deleteRowLayout(rowId,opId,styleNo,id)  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
{
	//var styleNo =  document.getElementById('ordercombo').value;	   
	if(confirm("Are you sure, you want to remove this record?")) 
	{
    	//document.getElementById('tblOperationLayoutSelection').deleteRow(rowId)
		var path = "xml.php?RequestType=removeRecordLayout&styleNo=" + styleNo + "&operationID=" + opId + "&id=" + id;  
		htmlobj = $.ajax( { url :path, async :false });
		var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");	 	 
	 	var feedBack = XMLResult[0].childNodes[0].nodeValue; 
		if(feedBack='true'){
		loadGrid(styleNo);
		var url = "SELECT DISTINCT(id), id FROM ws_machinesoperatorsassignment ORDER BY id ASC";
		loadCombo(url,'cboEpfNo');
		alert("Deleted successfully. ");
		}
		else{
		alert("Failed to delete. ");
		}
	}	 
}

function deleteRow1(rowId,opId,styleNo) //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
{
	if(confirm("Are you sure, you want to remove this record?")) 
	{
		//var styleNo = document.getElementById('style_no_data').value;
    	document.getElementById('tblOperationSelection1').deleteRow(rowId)
		var path = "xml.php?RequestType=removeRecord&styleNo=" + styleNo + "&operationID=" + opId;  
		htmlobj = $.ajax( { url :path, async :false });
		var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");	 	 
	 	var feedBack = XMLResult[0].childNodes[0].nodeValue; 			 
	}
	//updateDataGrid(styleNo);
	CloseWindow();
	loadComponents(styleNo);
}

function deleteNonDbRecord(rowId,node) //,styleNo  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
{
	
	while(node.nodeName.toLowerCase() != 'table'){
		node = node.parentNode;
	}
	var tableID=node.id;
	
	
	if(confirm("Are you sure, you want to remove this record?")) 
	{
		var tbl1 = document.getElementById(tableID);
		var tbl2 = document.getElementById('tblStyleCategory');
		var category=tbl1.rows[rowId].cells[2].id;
		
		document.getElementById(tableID).deleteRow(rowId);
		
		if(tableID=='tblOperationSelection'){
			var exist=0;
			for ( var loop = 1 ;loop < tbl1.rows.length ; loop ++ )
			{
				if(tbl1.rows[loop].cells[2].id==category)
				exist=1;
			}
			//-----
			if(exist==0){
				for ( var loop = 1 ;loop < tbl2.rows.length ; loop ++ )
				{
					if(tbl2.rows[loop].cells[1].id==category){
					tbl2.deleteRow(loop);
					}
				}
			}
		}
		
	}
	//--------------------------------------------------------------------------------------------
	var totHelperSMV  = 0;
	var helperSMV     = 0;
	
	var machineSMV    = 0;
	var totMachineSMV = 0;
	
	var totSMV = 0;
	
	for ( var a = 1 ;a < tbl1.rows.length ; a ++ )
	{			  
	  if(tbl1.rows[a].cells[7].lastChild.checked == true){
		  helperSMV = tbl1.rows[a].cells[6].lastChild.nodeValue;
		  totHelperSMV += parseFloat(helperSMV);
	  }else{
		  machineSMV = tbl1.rows[a].cells[6].lastChild.nodeValue;
		  totMachineSMV += parseFloat(machineSMV);
	  }
	}

	document.getElementById('ophelpSMV').value = totHelperSMV.toFixed(2);
	document.getElementById('opmachineSMV').value = totMachineSMV.toFixed(2);
	
	totSMV = parseFloat(totHelperSMV) + parseFloat(totMachineSMV);
	
	document.getElementById('optotalSMV').value = totSMV.toFixed(2);

}

function deleteNonDbLayoutRecord(rowId) //,styleNo 
{
	if(confirm("Are you sure, you want to remove this record?")) 
	{
		//alert(rowId);
    	document.getElementById('tblOperationLayoutSelection').deleteRow(rowId)
		alert("Deleted successfully. ");
	}
}

 
function formValidate() {
	
	  var error="";
	  
	  var SelectOption=document.getElementById('cmbProcessId');
	  var SelectedIndex=SelectOption.selectedIndex;
	  var SelectedValue=SelectOption.value;	  
	  if(SelectedValue==''){
		error = '- Please select the Process  \n';
	  }
	
	  var SelectOption=document.getElementById('comCat');
	  var SelectedIndex=SelectOption.selectedIndex;
	  var SelectedValue=SelectOption.value;	  
	  if(SelectedValue==''){
		error = '- Please select the Component category \n';
	  }
	  
	  var SelectOption=document.getElementById('component');
	  var SelectedIndex=SelectOption.selectedIndex;
	  var SelectedValue=SelectOption.value;	  
	  if(SelectedValue==''){
		error += '- Please select the Component  \n';
	  }
	  
	  var SelectOption=document.getElementById('operation');
	  var SelectedIndex=SelectOption.selectedIndex;
	  var SelectedValue=SelectOption.value;	  
	  if(SelectedValue==''){
		error += '- Please select the Operation \n';
	  }
	  
/*	  if(!document.getElementById('manual').checked) {		  
		  var SelectOption1=document.getElementById('cboMachine');
		  var SelectedIndex1=SelectOption1.selectedIndex;
		  var SelectedValue1=SelectOption1.value;
		  if(SelectedValue1==''){
			error += '- Please select the Machine \n';
		  } 
	  }*/
	  
	  if(!document.getElementById('manual').checked) {		  
		  var SelectOption1=document.getElementById('machine');
		  var SelectedIndex1=SelectOption1.selectedIndex;
		  var SelectedValue1=SelectOption1.value;
		  if(SelectedValue1==''){
			error += '- Please select the Machine Type \n';
		  } 
	  }
	  if(document.getElementById('smv').value==""){
	  	 error += '- Please enter the SMV \n';
	  }
	  
	  if(error!=""){
		alert("  \n" + error);
		return false;
	  }else{
		return true;
	  }	
}

function forceSelectStyleNo() {
	alert("Please select the Style No");
	document.getElementById('styleNo').focus();
}
 
function hideMachine() {
	var x=document.getElementById("machine")
	if(document.getElementById('manual').checked) {
		x.selectedIndex = 0;		 
    	x.disabled=true		
		 document.getElementById('smv').focus();
	} else {
		x.disabled=false	
	}
	
}


function setHeaderData() {
 	   
	var styleNo=document.getElementById('ordercombo').value;	
	var path = "xml.php?RequestType=loadHeaderData&styleNo=" + styleNo;  	
	htmlobj = $.ajax( { url :path, async :false });
	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	var comment = "";	
	if(XMLResult[0].childNodes[0].nodeValue!=''){
		comment = XMLResult[0].childNodes[0].nodeValue;
	}
	document.getElementById('comments').value = comment;  
	
}

// pich time calculation as fallows
function loadPichTime(obj) 
{	

	var SelectOption 	= document.frmOperationBrackDown.ordercombo;
	var SelectedIndex 	= SelectOption.selectedIndex;
	var SelectedValue	= SelectOption.value;
	var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
	  		
	/*if(SelectedText != 'select'){
		
			var url  = "pich_time.php?data="+SelectedValue;
			htmlobj=$.ajax({url:url,async:false});
			alert(SelectedValue);
			drawPopupAreaLayer(480,560,'frmOperations',1);				
			var HTMLText=htmlobj.responseText;
			//document.getElementById('frmOperations').innerHTML=HTMLText;			 			
			document.getElementById('styleNo').value = SelectedValue;
			
	}else{
		alert("Please Select Order No !");
		document.frmOperationBrackDown.styleNo.focus;			
	}*/
	
	if(SelectedText != 'select'){
		$('#PT').hide(); // hide the clicked button to prevent loading the layer again
		
		var url  = "pich_time.php";
		htmlobj=$.ajax({url:url,async:false});
			
		drawPopupAreaLayer(480,398,'frmChemicals',1);				
		var HTMLText=htmlobj.responseText;
		document.getElementById('frmChemicals').innerHTML=HTMLText;	
			
		/*var SelectOption 	= document.frmOperationBrackDown.styleNo;
		var SelectedIndex 	= SelectOption.selectedIndex;
		var SelectedValue 	= SelectOption.value;
		var SelectedText 	= SelectOption.options[SelectOption.selectedIndex].text;
		document.getElementById('style_no').value 		= SelectedText;*/
			
		var SelectOption 	= document.frmOperationBrackDown.ordercombo;
		var SelectedIndex 	= SelectOption.selectedIndex;
		var SelectedValue 	= SelectOption.value;
		var SelectedText 	= SelectOption.options[SelectOption.selectedIndex].text;
		document.getElementById('styleNumber').value 	= SelectedValue;
		document.getElementById('poNumber').value 		= SelectedText;
		
		var machineSMV 	= document.frmOperationBrackDown.machineSMV.value;
		document.getElementById('mSMV').value = machineSMV;
		
		var helperSMV 	= document.frmOperationBrackDown.helperSMV.value;
		document.getElementById('hSMV').value = helperSMV;		
		
		var totalSMV 	= document.frmOperationBrackDown.totalSMV.value;
		document .getElementById('tSMV').value = totalSMV;
		
		//document.getElementById('opmachineSMV').value 	= document.getElementById('machineSMV').value;
		//document.getElementById('optotalSMV').value 	= document.getElementById('totalSMV').value;
		//document.getElementById('ophelpSMV').value 		= document.getElementById('helperSMV').value;
			
	}else{
		alert("Please Select Order No !");
		document.frmOperationBrackDown.styleNo.focus;			
	}
	 
}



function setTotalWorks() {
	var moValue = document.getElementById('moValue').value;
	var helpers = document.getElementById('helpers').value;
	
	if((moValue!="")&&(helpers!="")){
		if(isNumeric(moValue)){
			if(isNumeric(helpers)){
				document.getElementById('totalWorks').value = parseInt(moValue) + parseInt(helpers);
			}
		}else{
			document.getElementById('totalWorks').value = 0;	
		}
	}else{
		document.getElementById('totalWorks').value = 0;
	}
}

function isNumeric(value) {
  if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) {
	  //alert("Please enter numeric values");
	  return false;
  }else{
  	return true;
  }
}

function doCalculation()
{
	if(validatePitchTime())
	{
		var totalSMV = document.getElementById('tSMV').value;
		var totalWorks = document.getElementById('totalWorks').value;
		
		document.getElementById('workHours').value = totalWorks;
		
		// Total P/T = Total SMV / Total Workers
		document.getElementById('totalPT').value = 	parseFloat(totalSMV) / parseInt(totalWorks);
		
		var machineSMV = document.getElementById('mSMV').value;
		var moValue  = document.getElementById('moValue').value;
		// Machine P/T = M/SMV  /  M/o
		document.getElementById('machinePT').value = 	parseFloat(machineSMV) / parseInt(moValue);
		//Req MO = MSMV/ (MSMV / MO)
		document.getElementById('reqMO').value = parseFloat(machineSMV) / (parseFloat(machineSMV)/ parseInt(moValue)); 
		//not clear have some clarification
		
		var humanSMV = document.getElementById('hSMV').value;
		//Req. Help = HSMV / (MSMV / MO)
		document.getElementById('reqHelpers').value = parseFloat(humanSMV) / (parseFloat(machineSMV)/ parseInt(moValue));
		
		//Machine Output / Hr  = (MO*60)/msmv
		var machineOutputHr = (parseInt(moValue)*60) / parseFloat(humanSMV);		 
		document.getElementById('machineOutputHr').value = machineOutputHr.toFixed(2);
		
		//Total Output / Hr =  (MO*60)/smv
		var machineOutputHr = (parseInt(moValue)*60) / parseFloat(totalSMV); //not clear		
		document.getElementById('machineOutputHr').value = machineOutputHr.toFixed(2);
		
		//Pitch Time = Total SMV /MO
		var pitchTime = parseFloat(totalSMV) / parseInt(moValue);
		pitchTime = pitchTime.toFixed(2);
		
		//OPR =  SMV  / Total SMV * No of Operators
		//var opr = ;
		
		//Target 100% = 60/ SMV

	}
}

function validatePitchTime() {
	var moValue  = document.getElementById('moValue').value;
	var helpers = document.getElementById('helpers').value;
	
	if((moValue == "") || (helpers=="")){ alert("please fill the Workers M/O and Helpers"); return false;}
	if(!isNumeric(moValue) || !isNumeric(helpers)){
		alert("Befour do calculation, \n Please enter the valid Machine operators and \n Helper operators");
		return false;
	}else{
		return true;
	}
}

function pageClear() {
 
    document.getElementById('cboStyles').value = ""; 
	document.getElementById('ordercombo').value = ""; 
	document.getElementById('styleNo').value = ""; 
	document.getElementById('machineSMV').value = "";
	document.getElementById('helperSMV').value = "";		
	document.getElementById('totalSMV').value = "";
	document.getElementById('workHours').value = 9;
	//document.getElementById('txtOperators').value = "";
	document.getElementById('totalOutputHr').value = "";
	document.getElementById('machineOutputHr').value = "";
	document.getElementById('comments').value = "";
	//document.getElementById('txtTeam').value = "";
		  
	updateDataGrid('');	
	document.getElementById('styleNo').focus();
}

function LayoutPageClear() {
 
	document.getElementById('orderNo').value = "";
	document.getElementById('style_no_data').value = "";		
	document.getElementById('comCat').value = "";
	document.getElementById('component').value = "";		
	document.getElementById('operation').value = "";
	document.getElementById('machine').value = "";
	document.getElementById('cboEpfNo').value = "";
	document.getElementById('smv').value = "";
	loadGrid('','');	  
	document.getElementById('orderNo').focus();
}


function backToTheMainPage() {
	window.location.replace('../../main.php');	
}

function directToTheLayout() {
	window.location.replace('layout.php');	
}


function loadLayout(obj){
	 		
	var SelectOption 	= document.frmOperationBrackDown.ordercombo;
	var SelectedIndex 	= SelectOption.selectedIndex;
	var SelectedValue	= SelectOption.value;
	var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
		
	if(SelectedText != 'select'){
		
		 
		var url  = "layoutPopup.php?";
		//inc('../currency/Button.js');
		var W	= 992;
		var H	= 387;
		var tdHeader = "tdHeader";
		var tdDelete = "tdDelete";
		var closePopUp = "closeCurrencyPopUp";
		CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete);	
	
		/*var url  = "layout.php";
		htmlobj=$.ajax({url:url,async:false});
			
		drawPopupAreaLayer(805,530,'frmChemicals',1);				
		var HTMLText=htmlobj.responseText;
		document.getElementById('frmChemicals').innerHTML=HTMLText;	
				 			
		var SelectOption 	= document.frmOperationBrackDown.ordercombo;
		var SelectedIndex 	= SelectOption.selectedIndex;
		var SelectedValue 	= SelectOption.value;
		var SelectedText 	= SelectOption.options[SelectOption.selectedIndex].text;*/
		 	
	}else{
		alert("Please Select Order No !");
		document.frmOperationBrackDown.styleNo.focus;			
	}
}

function addRowintoOperationLayoutSheet(rowid,styleId,opId,side) { 
		  	 
	var path = "xml.php?RequestType=layoutData&styleNo="+styleId+"&operationId="+opId;  	
	htmlobj = $.ajax( { url :path, async :false });
	
	var XMLOPEID 	= htmlobj.responseXML.getElementsByTagName("operationId");
	var XMLOPE 		= htmlobj.responseXML.getElementsByTagName("operation");
	var XMLMACHId 	= htmlobj.responseXML.getElementsByTagName("machineId");
	var XMLMACHName 	= htmlobj.responseXML.getElementsByTagName("machine");
	var XMLSMV 		= htmlobj.responseXML.getElementsByTagName("smv");
	
for ( var loop = 0; loop < XMLOPEID.length; loop ++)
{
	var operationId	= XMLOPEID[loop].childNodes[0].nodeValue;
	var operation 	= XMLOPE[loop].childNodes[0].nodeValue;
	var machineId 	= XMLMACHId[loop].childNodes[0].nodeValue;
	var machineName = XMLMACHName[loop].childNodes[0].nodeValue;
	var smv 		= XMLSMV[loop].childNodes[0].nodeValue;
}
	
	
	if(side=='right'){
		var machineCombo = "<select class=\"txtbox\" style=\"width: 70px;\" id=\"machineR"+rowid+"\" name=\"machineR"+rowid+"\" onchange=\"loadSMV('"+rowid+"','"+side+"','"+styleId+"','"+opId+"',this.value);\"> <option value=\"0\">select</option>";			
	}
	else{
	var machineCombo = "<select class=\"txtbox\" style=\"width: 70px;\" id=\"machineL"+rowid+"\" name=\"machine"+rowid+"\" onchange=\"loadSMV('"+rowid+"','"+side+"','"+styleId+"','"+opId+"',this.value);\"> <option value=\"0\">select</option>";		
	}
	
	for ( var loop = 0; loop < XMLOPEID.length; loop ++) {
		var selectedStatus  = "";
			
		machineCombo += "<option value = \"" + XMLMACHId[loop].childNodes[0].nodeValue + "\" " +selectedStatus+ " >" + XMLMACHName[loop].childNodes[0].nodeValue + "</option>";			
	}
	machineCombo += "</select>"; 
	
	
	
/*	var path1 = "xml.php?RequestType=listOfMachine";  	
	newHTMLobj = $.ajax( { url :path1, async :false });
	 
	var XMLtext   = newHTMLobj.responseXML.getElementsByTagName("text");
	var XMLvalue   = newHTMLobj.responseXML.getElementsByTagName("value");
	
	var machineCombo = "<select class=\"txtbox\" style=\"width: 70px;\" id=\"machineL"+rowid+"\" name=\"machine"+rowid+"\"> <option value=\"0\">select</option>";		
	if(side=='right'){
		var machineCombo = "<select class=\"txtbox\" style=\"width: 70px;\" id=\"machineR"+rowid+"\" name=\"machineR"+rowid+"\"> <option value=\"0\">select</option>";			
	}
	for ( var loop = 0; loop < XMLtext.length; loop ++) {
		var selectedStatus  = "";
		if(machine==XMLvalue[loop].childNodes[0].nodeValue){ selectedStatus = "selected=\"selected\""; }
		machineCombo += "<option value = \"" + XMLvalue[loop].childNodes[0].nodeValue + "\" " +selectedStatus+ " >" + XMLtext[loop].childNodes[0].nodeValue + "</option>";			
	}
	machineCombo += "</select>"; */
	
	
	
	
	if(side=="left"){
		document.getElementById('tblLayoutOperationLeft').deleteRow(rowid);	
	}else{
		document.getElementById('tblLayoutOperationRight').deleteRow(rowid);		
	}
	var dispalyRowId 	= 90-parseInt(rowid);
	var level 			= parseInt(dispalyRowId)/3;
	var location 		= parseInt(dispalyRowId)%3;
	var displayLocation = parseInt(level)+1;
	
	if(side=="left"){
		var tbl 			= document.getElementById('tblLayoutOperationLeft');
	}else{
		var tbl 			= document.getElementById('tblLayoutOperationRight');
	}
	var nextRowIndex 	= tbl.rows.length;  
	var lastRow 		= tbl.rows.length;   
	var iteration 		= lastRow;
   
	var lastRow 		= tbl.rows.length;// if there's no header row in the table, then iteration = lastRow + 1	  
	var iteration 		= lastRow;
	var row 			= tbl.insertRow(rowid);
	 
	var cell0 			= row.insertCell(0);
	if(side=="left"){
		var textNode 		= document.createTextNode("L"+displayLocation);
	}else{
		var textNode 		= document.createTextNode("R"+displayLocation);
	}
	
	cell0.appendChild(textNode);
	cell0.align 		= "center";
   
		
	var cell1 			= row.insertCell(1);
	var textNode 		= document.createTextNode(XMLOPE[0].childNodes[0].nodeValue); 
	cell1.appendChild(textNode);
	cell1.align 		= "left";
	if(side=="left"){
		cell1.innerHTML 	= "<img src=\"../../images/edit.png\" width=\"19\" height=\"19\" onclick=\"addOperationToLayout(this.parentNode.parentNode.rowIndex);\" />"+operation;
	}else{
		cell1.innerHTML 	= "<img src=\"../../images/edit.png\" width=\"19\" height=\"19\" onclick=\"addOperationToRightTableLayout(this.parentNode.parentNode.rowIndex);\" />"+operation;
	}
	 
	var cell2 			= row.insertCell(2);
	//var textNode 		= document.createTextNode(machine);
	var textNode 		= document.createTextNode(0);
	cell2.appendChild(textNode);
	cell2.align 		= "center";
	cell2.innerHTML 	= machineCombo;		 
	
	var cell3 			= row.insertCell(3);
	//var textNode 		= document.createTextNode(smv);
	var textNode 		= document.createTextNode(0);
	cell3.appendChild(textNode);			  
	cell3.align 		= "center";
	
	var cell4 			= row.insertCell(4);
	var textNode 		= document.createTextNode(0);
	cell4.appendChild(textNode);
	//cell4.align 		= "left";
			  
	var cell5 			= row.insertCell(5);
	var textNode 		= document.createTextNode(0);
	cell5.appendChild(textNode);
	//cell5.align 		= "left";
	
	var cell6 			= row.insertCell(6);
	var textNode 		= document.createTextNode(0);
	cell6.appendChild(textNode);
	//cell6.align 		= "left";
	cell6.innerHTML 	= "<input type=\"checkbox\" checked=\"checked\"  class=\"chkbox\">";
	
	var cell7 			= row.insertCell(7);
	var textNode 		= document.createTextNode(0);
	cell7.appendChild(textNode);
	//cell7.align 		= "left";
	
	var cell8 			= row.insertCell(8);
	var textNode 		= document.createTextNode(0);
	cell8.appendChild(textNode);
	//cell8.align 		= "left";
	
	var cell9 			= row.insertCell(9);
	var textNode 		= document.createTextNode(0);
	cell9.appendChild(textNode);
	//cell9.align 		= "left";
	
	var cell10 			= row.insertCell(10);
	var textNode 		= document.createTextNode(XMLOPEID[0].childNodes[0].nodeValue);
	cell10.appendChild(textNode);
	//cell10.align 		= "left";
	cell10.style.display='none';
	
	var cell11 			= row.insertCell(11);
	var textNode 		= document.createTextNode(side);
	cell11.appendChild(textNode);
	cell11.style.display='none';
	
	var cell12 			= row.insertCell(12);
	var textNode 		= document.createTextNode(rowid);
	cell12.appendChild(textNode);
	cell12.style.display='none';
	
	var cell13 			= row.insertCell(13);
	var textNode 		= document.createTextNode(0); 
	cell13.appendChild(textNode);
	cell13.style.display='none';
	
	if(side=="left"){
		var mytable 		= document.getElementById('tblLayoutOperationLeft'); 
	}else{
		var mytable 		= document.getElementById('tblLayoutOperationRight'); 
	}
	
	var stylerows 		= mytable.getElementsByTagName("tr");
	stylerows[rowid].className = "bcgcolor-green"; 		 
	
	closePopup2();
}

//------------------------------
function loadSMV(rowid,side,style,operation,machine) { 
		  	 
	var path = "xml.php?RequestType=loadSMV&style="+style+"&operation="+operation+"&machine="+machine;  	
	htmlobj = $.ajax( { url :path, async :false });
	var XMLSMV 	= htmlobj.responseXML.getElementsByTagName("smv");
	
	if(side=="left"){
		var tbl 			= document.getElementById('tblLayoutOperationLeft');
	}else{
		var tbl 			= document.getElementById('tblLayoutOperationRight');
	}
	
	tbl.rows[rowid].cells[3].innerHTML=XMLSMV[0].childNodes[0].nodeValue;
	tbl.rows[rowid].cells[5].innerHTML=Math.round(60/parseFloat(XMLSMV[0].childNodes[0].nodeValue));
	tbl.rows[rowid].cells[13].innerHTML=0;
}

//------------------------------------------------------------------
function saveLayoutData() {
	
	var message = "";
	if(document.getElementById('cboOrderNo').value == ""){
		alert("Please select the order number");
		return false;
	}

	var tbl = document.getElementById('tblOperationLayoutSelection');
	var style=document.getElementById('cboOrderNo').value;
	if(tbl.rows.length>0)
	{
		var ArrayOperations='';
		var ArrayEPFNo='';
		
		var table_rows = tbl.rows.length;		 
		for ( var loop = 1 ;loop < tbl.rows.length; loop ++ )
		{	

			operation	 		= URLEncode(tbl.rows[loop].cells[3].id);			
			epfNo	= URLEncode(tbl.rows[loop].cells[1].childNodes[0].value);
			
			ArrayOperations 	+= operation + ",";	
			ArrayEPFNo 	+= epfNo + ",";	
		}


 		var path = "xml.php?RequestType=saveLayoutData&style=" + style +"&ArrayOperations=" + ArrayOperations + "&ArrayEPFNo=" + ArrayEPFNo;  
		htmlobj = $.ajax( { url :path, async :false });
 
		var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
		if (XMLResult[0].childNodes[0].nodeValue == "True") {		 

			message +=  "Saved successfully.";	
			loadGrid(style,'');

		 
		}else if (XMLResult[0].childNodes[0].nodeValue == "False") {
	 	//	alert("Save failed.");
		}
		 if(message!=""){
			 alert(message);
			 }
}

}
//--------------------------------------------------------------------

 
function table(){
$(document).ready(function() {
	$('.transGrid > thead > tr').css("background-color", "#498cc2");
	$('.transGrid > tbody > tr:odd').css("background-color", "#d2e9fc");
	$('.transGrid > tbody > tr:even').css("background-color", "#ffffff");
});
}
 
 
function isRecordAvaliable(styleID,rowId,thisSide) {
	var path		= "xml.php?RequestType=recordAvailable&styleId="+styleID+"&side="+thisSide+"&rowId="+rowId;	
	htmlobj			= $.ajax({url:path,async:false});
	var XMLSerial   = htmlobj.responseXML.getElementsByTagName("strTag");
		
	if(XMLSerial[0].childNodes[0].nodeValue==1){
		return true;
	}else{
		return false;	
	}
}

function forceToSelectOrderNo() {
	if(document.getElementById('txtStyleNo').value==""){
	alert("Please select the Order Number");
	return false;	
	}
}

function clearData() {	 
	document.getElementById('orderNo').selectedIndex = 0; 
	document.getElementById('txtStyleNo').value = "";
	
}

function popitup(url) {
	if(document.getElementById('orderNo').selectedIndex == 0){
		alert("Please select the order number");
		return false;
	}else{ 
		 params  = 'width='+screen.width;
		 params += ', height='+screen.height;
		 params += ', top=0, left=0'
		 params += ', scrollbars=yes'
		 params += ', fullscreen=yes';		
		 newwin=window.open(url,'windowname4', params);
		 if (window.focus) {newwin.focus()}
		 return false; 
	}
}

function reportLayout(){
	 
	if(document.getElementById('cboOrderNo').selectedIndex == 0){
		alert("Please select the Order Number.");
		return false;
	}
	if(document.getElementById('comCat').value == ''){
		alert("Please select the Category.");
		return false;
	}
	else{ 
	    var style = document.getElementById('cboStyles').value;
		var order = document.getElementById('cboOrderNo').options[document.getElementById('cboOrderNo').selectedIndex].text;
		var styleId = document.getElementById('cboOrderNo').value;
		var category = document.getElementById('comCat').value;
		var operators=document.getElementById('txtOperators').value;
		var helpers=document.getElementById('txtHelpers').value;
		var machineSMV=document.getElementById('txtMSMV').value;
		var helperSMV=document.getElementById('txtHSMV').value;
		var teams=document.getElementById('txtTeams').value;
		var hoursPerDay=document.getElementById('txtHrs').value;
		
		var path		= 'xml.php?RequestType=styleRegisterdForReport&styleId='+styleId;	
		htmlobj			= $.ajax({url:path,async:false});
		var XMLSerial   = htmlobj.responseXML.getElementsByTagName("strTag");
			
		if(XMLSerial[0].childNodes[0].nodeValue==1){
			window.open('LayoutSheetReport.php?styleId='+styleId + '&operators=' + operators + '&helpers=' + helpers + '&machineSMV=' + machineSMV + '&helperSMV=' + helperSMV + '&teams=' + teams + '&hoursPerDay=' + hoursPerDay + '&category=' + category+'&style='+style+'&order='+order);
		}else{
			alert("In order to view the report, please save these records");
			return false;	
		}
		
		 
	}
} 
/*	 
function popupBank()
{
	 
	var url = "layoutPopup.php";
	inc('/ajaxupload.js');
	inc('/Operation.js');
	inc('/Button.js');
	inc('/../../javascript/script.js');
	inc('/../../js/jquery-1.2.6.min.js');
	inc('/../../js/table_script.js');
var W = 1;
var H = 1;
var closePopUp = "closeBankModePopUpInBranch";
//var closePopUp = "closeGrnPopUp";
var tdHeader = "td_pHeader";
var tdDelete = "td_GrnDelete";
CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,"layout_popup_close_button");

}

//-----------------------------------

function closeBankModePopUpInBranch(id)
{
	closePopUpArea(id);
	var sql = "SELECT bank.intBankId, bank.strBankName FROM bank where intStatus=1 order by strBankName asc";
	var control = "branch_cboBankName";
	loadCombo(sql,control);
}
//-----------------------------------------------------------------------
function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
		catch(err)
	{}
}


//--------------------------------------------------------------------------- popup layout related code block

  
function popupLayout(obj) 
{	
	
			 
		
			var url  = "layout.php";
			htmlobj=$.ajax({url:url,async:false});			
			drawPopupAreaLayer(980,500,'frmChemicals',1);				
			var HTMLText=htmlobj.responseText;
			document.getElementById('frmChemicals').innerHTML=HTMLText;	
			
}
	

function CloseWindow(){
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}
}
*/

/*function popupLayoutPage(){
	
	var url  = "layoutPopup.php?";
	 
	inc('ajaxupload.js');
	inc('Operation.js');	 
	/*inc('../../javascript/script.js');
	inc('../../js/jquery-1.2.6.min.js');
	inc('../../js/table_script.js');*/
	/*
	var W	= 0;
	var H	= 242;
	var closePopUp = "closeCurrencyPopUp";
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
    var tdPopUpClose = "layout_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	

}*/

function openLayoutPage(){
 
	var url  = "layout.php?";
	/*var W	= 0;
	var H	= 242;
	var closePopUp = "closeCurrencyPopUp";
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
    var tdPopUpClose = "currency_popup_close_button";
	CreatePopUpNew(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	*/
	
	htmlobj=$.ajax({url:url,async:false});
			
			drawPopupBox(980,475,'frmLayout',1);				
			var HTMLText=htmlobj.responseText;
			document.getElementById('frmLayout').innerHTML=HTMLText;	
			document.getElementById('orderNo').value=document.getElementById('styleNo').value;
			document.getElementById('txtStyleNo').value=document.getElementById('styleNo').value;
	
	if(document.getElementById('txtStyleNo').value!=""){
		loadLayoutGridRelatedData(document.getElementById('txtStyleNo').value);	
/*
if (objDiv.scrollTop==0) objDiv.scrollTop=4;
if (objDiv.scrollTop+12==objDiv.scrollHeight - objDiv.offsetHeight)
{
if (objDiv.scrollHeight > objDiv.offsetHeight)
{
objDiv.scrollTop = objDiv.scrollHeight - objDiv.offsetHeight;
}
}	
*/
		}
		
		
}

function loadLayoutGridRelatedData(styleID) {
	
	document.getElementById('txtStyleNo').value = styleID;
	var path	= "layoutLeft.php?styleNo="+styleID;
	htmlobj		= $.ajax({url:path,async:false});
	document.getElementById('layoutLeftGrid').innerHTML=htmlobj.responseText;	
	
		var objDiv1 = document.getElementById("divcons1");
		objDiv1.scrollTop = objDiv1.scrollHeight;
	
	loadLayoutGridRelatedRightData(styleID);	 
}

function loadLayoutStyle() {
	var styleID = document.getElementById('cboOrderNo').value;

	loadGrid(styleID,'');
}
 
function loadLayoutGridRelatedRightData(styleID){
	 	
	var path	= "layoutRight.php?styleNo="+styleID;	 
	htmlobj		= $.ajax({url:path,async:false});	
	document.getElementById('layoutRightGrid').innerHTML=htmlobj.responseText;	

		var objDiv2 = document.getElementById("divcons2");
		objDiv2.scrollTop = objDiv2.scrollHeight;
}



function CreatePopUpNew(url,W,H,closePopUp,tdHeader,tdDelete)
{
	createXMLHttpRequestforTitle();	
	xmlHttpForTitle.onreadystatechange=CreatePopUpRequest2;
	xmlHttpForTitle.W = W;
	xmlHttpForTitle.H = H;
	
	xmlHttpForTitle.tdHeader = tdHeader;
	xmlHttpForTitle.tdDelete = tdDelete;
	
	xmlHttpForTitle.closePopUp = closePopUp;
	xmlHttpForTitle.open("GET",url ,true);
	xmlHttpForTitle.send(null);
}

function closeCurrencyPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCurrencyRequest;
	xmlHttp.open("GET", 'xml.php?id=loadCurrency', true);
   	xmlHttp.send(null);
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}
//--------------2011--01-7-----------------------------------------
function openLayoutPageNewTab()
{
		var style=document.getElementById('styleNo').value;
		//var operators=document.getElementById('txtOperators').value;
		//var helpers=document.getElementById('txtHelpers').value;
		var machineSMV=document.getElementById('machineSMV').value;
		var helperSMV=document.getElementById('helperSMV').value;
		//var teams=document.getElementById('txtTeam').value;
		var hoursPerDay=document.getElementById('workHours').value;
		
		var operators='';
		var helpers='';
		var teams='';
		
	window.open('layoutPage.php?style='+style + '&operators=' + operators + '&helpers=' + helpers + '&machineSMV=' + machineSMV + '&helperSMV=' + helperSMV + '&teams=' + teams + '&hoursPerDay=' + hoursPerDay,'frmlayouts'); 
}



function addRowsToLayout() {	  
	 if(formLayoutValidate()) {
		
		var stlyeNo = document.getElementById('style_no_data').value;
		
		var SelectOption	= document.getElementById('operation');
		var SelectedIndex	= SelectOption.selectedIndex;
		var SelectedValue	= SelectOption.value;			  
		var operationID		= SelectedValue;			   
				
	//hem	if(checkAvailbilityInThisTable())	{	
			  var tbl 			= document.getElementById('tblOperationLayoutSelection');
			  var nextRowIndex 	= tbl.rows.length; //for display next rpw id
			  var lastRow 		= tbl.rows.length;// if there's no header row in the table, then iteration = lastRow + 1	  
			  var iteration 	= lastRow;
		
		//hem--do get epf from db???????????
			  if(document.getElementById('cboEpfNo').value==''){
					var tbl = document.getElementById('tblOperationLayoutSelection');	
					if(tbl.rows.length>1){
						var epf=0;
						for( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
						{
							if(parseFloat(tbl.rows[loop].cells[1].innerHTML)>epf)
							epf=parseFloat(tbl.rows[loop].cells[1].innerHTML)
						}
						epf=epf+1;
					}
					else{
					var epf = 1;	
					}
			  }
			  else{
			  var epf=document.getElementById('cboEpfNo').value;
			  }
			  
			  var row 			= tbl.insertRow(1);
			  
			  var SelectedText="-";	
			  var cell2 = row.insertCell(0);
			  var textNode = document.createTextNode(SelectedText);
			  cell2.appendChild(textNode);	
 			  cell2.innerHTML="<img src=\"../../images/del.png\"  onClick=\"deleteNonDbLayoutRecord(this.parentNode.parentNode.rowIndex);\">";
			  cell2.class="normalfntMid";
			  
			  var cell0 		= row.insertCell(1);
			  var textNode 		= document.createTextNode(epf);
			  cell0.appendChild(textNode);
			  cell0.align = "center";
			  cell0.class="normalfntMid";
			  
			  var SelectOption	= document.getElementById('operation');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell1 		= row.insertCell(2);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";
			  
			  var SelectOption	= document.getElementById('machine');
			  var SelectedIndex	= SelectOption.selectedIndex;
			  var SelectedValue	= SelectOption.value;
			  var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
			  var cell1 		= row.insertCell(3);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";

			  var SelectedText	= document.getElementById('smv').value;	
			  var cell1 		= row.insertCell(4);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell1.appendChild(textNode);
			  cell1.align = "right";
			  cell1.class="normalfntRite";

			  var SelectedText	= Math.round(60/parseFloat(document.getElementById('smv').value),2);	
			  var cell1 		= row.insertCell(5);
			  var textNode 		= document.createTextNode(SelectedText);
			  cell1.appendChild(textNode);
			  cell1.align = "right";
			  cell1.class="normalfntRite";
			  
			  
			  var cell1 		= row.insertCell(6);
			  var textNode 		= document.createTextNode(document.getElementById('operation').value);
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";
			  cell1.style.display='none';

			  
			  var cell1 		= row.insertCell(7);
			  var textNode 		= document.createTextNode(document.getElementById('machine').value);
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";
			  cell1.style.display='none';

			  
			  var cell1 		= row.insertCell(8);
			  var textNode 		= document.createTextNode(1);
			  cell1.appendChild(textNode);
			  cell1.align = "center";
			  cell1.class="normalfntMid";
			  cell1.style.display='none';

			var tbl = document.getElementById('tblOperationLayoutSelection');
			var maxEpfVal=tbl.rows[1].cells[1].innerHTML.trim();               

			if(document.getElementById('cboEpfNo').value==""){
			var myNewOption = document.createElement("OPTION");
			document.getElementById('cboEpfNo').options.add(myNewOption);
			myNewOption.value = maxEpfVal;
			myNewOption.text  = maxEpfVal;
			}
			
			document.getElementById('cboEpfNo').value=maxEpfVal;
		//}
	}
}

//-------------------------------------------------------------------------------------------
function formLayoutValidate()
{
	var stlyeNo = document.getElementById('style_no_data').value;
	var operation=document.getElementById('operation').value;
	var catog=document.getElementById('comCat').value;
	var component=document.getElementById('component').value;
	var machine=document.getElementById('machine').value;
	var id=document.getElementById('cboEpfNo').value;
	var tbl = document.getElementById('tblOperationLayoutSelection');
	
//	alert(id);
		var existRow=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var gridID=tbl.rows[loop].cells[1].innerHTML.trim();
				var gridOperation=tbl.rows[loop].cells[6].innerHTML.trim();
				
				if(operation==gridOperation){
					existRow=1;
				}
		}



	if (document.getElementById('style_no_data').value == "" )	
	{
		alert("Please select a \"SC No\" ");
		document.getElementById('style_no_data').focus();
		return false;
	}
	else if (document.getElementById('comCat').value == "" )	
	{
		alert("Please select a \"Catogery\" ");
		document.getElementById('comCat').focus();
		return false;
	}
	else if (document.getElementById('component').value == "" )	
	{
		alert("Please select a \"Component\" ");
		document.getElementById('component').focus();
		return false;
	}
	else if (document.getElementById('operation').value == "" )	
	{
		alert("Please select a \"Operation\" ");
		document.getElementById('operation').focus();
		return false;
	}
	else if (document.getElementById('machine').value == "" )	
	{
		alert("Please select a \"Machine\" ");
		document.getElementById('machine').focus();
		return false;
	}
	else if(existRow==1){
		alert("This Operation is already assigned!");
		return false;
	}
	else
	return true;
	
}

function loadOperatBreakDownReport(){ 
var opbdrpt_intStyleID = document.getElementById('styleNo').value;
	var SelectOption 	= document.frmOperationBrackDown.ordercombo;
	var scNo	= SelectOption.options[SelectOption.selectedIndex].text;	

if(opbdrpt_intStyleID==''){
alert("Please select a Style.");
return false;
}

var tbl = document.getElementById('tblStyleCategory');
	for( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
		var category=tbl.rows[loop].cells[1].id;
		var catName = tbl.rows[loop].cells[1].innerHTML;
		//alert(catName);
			window.open("operation_Break_DownReport.php?opbdrpt_intStyleID="+opbdrpt_intStyleID + "&category=" + category+'&catName='+catName+"&scNo="+scNo); 
	}
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------

function loadOperation(){
	    var oprationId   = document.getElementById('cboSearch').value;
		
	    var path		= 'xml.php?RequestType=loadOperation&oprationId='+oprationId;	
		htmlobj			= $.ajax({url:path,async:false});
		
		var XMLCode   = htmlobj.responseXML.getElementsByTagName("Code");
		var XMLName   = htmlobj.responseXML.getElementsByTagName("Name");
		var XMLStatus   = htmlobj.responseXML.getElementsByTagName("Status");
		
		document.getElementById('txtOptCode').value = XMLCode[0].childNodes[0].nodeValue;
		document.getElementById('txtName').value = XMLName[0].childNodes[0].nodeValue;
		if(XMLStatus[0].childNodes[0].nodeValue == '1'){
			document.getElementById('chkStatus').checked = true;
		}else{
		    document.getElementById('chkStatus').checked = false;	
		}
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------

function saveOperationsPopUp(){
	 var oprationId   = document.getElementById('cboSearch').value;
	 var operatinoCode = document.getElementById('txtOptCode').value;
	 var name = document.getElementById('txtName').value; 
	 if(document.getElementById('chkStatus').checked == true){
		var chkStatus = '1'; 
	 }else{
		var chkStatus = '0';
	 }
	 
	 var comCat   = document.getElementById('comCat').value;
	 var component = document.getElementById('component').value;
	 
	 	if(!ValidateOperationsBeforeSave())	
		return;
		{
			alert("Saved successfully.");
	 
	 var path		= 'operationBreakDown_popup_set.php?id=saveOperationPopup&operatinoCode='+operatinoCode+'&name='+name+'&comCat='+comCat+'&component='+component+'&chkStatus='+chkStatus;	
	 //alert(path);
		 var htmlobj	= $.ajax({url:path,async:false});
		//alert(htmlobj.responseText);  	 		 
				document.getElementById("cboSearch").value="";
				document.getElementById("txtOptCode").value="";
				document.getElementById("txtName").value="";
				loadCombo('SELECT intId,strOperationCode,strOperationName FROM ws_operations WHERE intStatus =1 ORDER BY strOperationCode','cboSearch');
		}
 
}

//------------------------------------------------------------------------------------------------------------------------------------------------------|

function ValidateOperationsBeforeSave()
{	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtOptCode").value;
	
	var x_find = checkInField('ws_operations','strOperationCode',x_name,'intId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtOptCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtName").value;
	
	var x_find = checkInField('ws_operations','strOperationName',x_name,'intId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtName").focus();
		return false;
	}
	
	return true;
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------

/*function ConfirmDeleteOperation(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select a \"Operation\".");
		document.getElementById('cboSearch').focus();
		return;
	}	
	else
	{
	var r=confirm("Are you sure you want to delete \""+ document.getElementById('cboSearch').options[document.getElementById('cboSearch').selectedIndex].text +"\" ?");
		if (r==true)		
			DeleteDataOperation(strCommand);				
	}
}
*/
function DeleteDataOperation(){
	var oprationId   = document.getElementById('cboSearch').value;
	var txtName = document.getElementById('txtName').value; 
	var comCat   = document.getElementById('comCat').value;
	var component = document.getElementById('component').value;

	if(oprationId!="")
	{
		if(confirm("Are you sure you want to delete \n \'"+txtName+"\' ?"))
		{
					alert("Deleted successfully.");
					var path = 'operationBreakDown_popup_set.php?id=deleteOperationPopup&oprationId='+oprationId+'&comCat='+comCat+'&component='+component+'&txtName='+txtName;
					var obj =$.ajax({url:path,async:false});
					//alert(obj.responseText);
					if(obj.responseText == 1){
				document.getElementById("cboSearch").value="";
				document.getElementById("txtOptCode").value="";
				document.getElementById("txtName").value="";
				loadCombo('SELECT intId,strOperationCode,strOperationName FROM ws_operations WHERE intStatus =1 ORDER BY intId','cboSearch');
						}
		}
	}
	else
	{
		alert('Please select a Operation.');
		document.getElementById("cboSearch").focus();
	}
}

//--------------------------------------------------------------Machines-----------------------------------------------------------------------------------

function loadMachine(){
	    var machineId   = document.getElementById('cboSearchM').value;
		
	    var path		= 'xml.php?RequestType=loadMachine&machineId='+machineId;	
		htmlobj			= $.ajax({url:path,async:false});
		
		var XMLMCode   = htmlobj.responseXML.getElementsByTagName("MCode");
		var XMLMName   = htmlobj.responseXML.getElementsByTagName("MName");
		var XMLMStatus   = htmlobj.responseXML.getElementsByTagName("MStatus");
		
		document.getElementById('txtMachCode').value = XMLMCode[0].childNodes[0].nodeValue;
		document.getElementById('txtMachName').value = XMLMName[0].childNodes[0].nodeValue;
		if(XMLMStatus[0].childNodes[0].nodeValue == '1'){
			document.getElementById('chkMStatus').checked = true;
		}else{
		    document.getElementById('chkMStatus').checked = false;	
		}
}

function saveMachinesPopUp(){
	 var machId   = document.getElementById('cboSearchM').value;
	 var machCode = document.getElementById('txtMachCode').value;
	 var machName = document.getElementById('txtMachName').value; 
	 if(document.getElementById('chkMStatus').checked == true){
		var chkStatusMach = '1'; 
	 }else{
		var chkStatusMach = '0';
	 }
	 
	 var comCat   = document.getElementById('comCat').value;
	 var component = document.getElementById('component').value;
	 
	 	if(!ValidateMachinesBeforeSave())	
		return;
		{
			alert("Saved successfully.");
	 
	 var path		= 'operationBreakDown_popup_set.php?id=saveMachinePopup&machCode='+machCode+'&machName='+machName+'&comCat='+comCat+'&component='+component+'&chkStatusMach='+chkStatusMach;	
	 //alert(path);
		 var htmlobj	= $.ajax({url:path,async:false});
		//alert(htmlobj.responseText);  	 		 
				document.getElementById("cboSearchM").value="";
				document.getElementById("txtMachCode").value="";
				document.getElementById("txtMachName").value="";
				loadCombo('SELECT intMachineTypeId,strMachineCode,strMachineName FROM ws_machinetypes WHERE intStatus =1 ORDER BY strMachineCode','cboSearchM');
		}
}

//------------------------------------------------

function ValidateMachinesBeforeSave()
{	
	var x_id = document.getElementById("cboSearchM").value;
	var x_name = document.getElementById("txtMachCode").value;
	
	var x_find = checkInField('ws_machinetypes','strMachineCode',x_name,'intMachineTypeId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtMachCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("cboSearchM").value;
	var x_name = document.getElementById("txtMachName").value;
	
	var x_find = checkInField('ws_machinetypes','strMachineName',x_name,'intMachineTypeId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtMachName").focus();
		return false;
	}
	
	return true;
}

//-----------------------------------------------

/*function ConfirmDeleteMachine(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select a \"Operation\".");
		document.getElementById('cboSearch').focus();
		return;
	}	
	else
	{
		var r=confirm("Are you sure you want to delete \""+ document.getElementById('cboSearch').options[document.getElementById('cboSearch').selectedIndex].text +"\" ?");
		if (r==true)		
			DeleteDataMachine(strCommand);				
	}
}*/

function DeleteDataMachine(){
	var machId   = document.getElementById('cboSearchM').value;
	var machCode = document.getElementById('txtMachCode').value;
    var machName = document.getElementById('txtMachName').value; 
	
	if(machName!="")
	{
		if(confirm("Are you sure you want to delete \n \'"+machName+"\' ?"))
		{
					alert("Deleted successfully.");
					var path = 'operationBreakDown_popup_set.php?id=deleteMachinePopup&machId='+machId+'&machCode='+machCode+'&machName='+machName;
					var obj =$.ajax({url:path,async:false});
					//alert(obj.responseText);
					if(obj.responseText == 1){
				document.getElementById("cboSearchM").value="";
				document.getElementById("txtMachCode").value="";
				document.getElementById("txtMachName").value="";
				loadCombo('SELECT intMachineTypeId,strMachineCode,strMachineName FROM ws_machinetypes WHERE intStatus =1 ORDER BY strMachineCode','cboSearchM');
						}
		}
	}
	else
	{
		alert('Please select a Operation.');
		document.getElementById("cboSearch").focus();
	}
}

//---------------------------------------------------------------------------------------------------------------

function loadOperationsWise(){
	var cmbProcessId   = document.getElementById('cmbProcessId').value;
	var cmbcatId   = document.getElementById('comCat').value;
	var sql = "SELECT ws_operations.intId,concat(ws_operations.strOperationCode,'-',ws_operations.strOperationName)	    FROM  ws_operations WHERE "+
	" ws_operations.intProcessId =  "+cmbProcessId+" AND ws_operations.intCompCatId =  "+cmbcatId+"";
			
	var control1 = "operation";
	loadCombo(sql,control1);
}

//----------------------------------------------------------------------------------------------------------------

/*function loadComCatForProcess(){
	document.getElementById('component').value ="";
	var cmbProcessId   = document.getElementById('cmbProcessId').value;
	//alert(cmbProcessId);
	var sql = 
	" SELECT  distinct componentcategory.intCategoryNo,componentcategory.strCategory "+  
	 " FROM  componentcategory Inner Join ws_operations ON "+
	 " componentcategory.intCategoryNo = ws_operations.intCompCatId  WHERE  ws_operations.intProcessId =   "+cmbProcessId+"";
			alert(sql);
	var control1 = "comCat";
	loadCombo(sql,control1);	
}*/

//----------------------------------------------------------------------------------------------------------------

function checkForManualOperations(){
 var cmbProcessId = 	document.getElementById('cmbProcessId').value;
 if(cmbProcessId != '2'){	 
	document.getElementById("manual").checked = true;
	document.getElementById("manual").disabled = false;
	hideMachine2(); 
 }else{
	document.getElementById("manual").checked = false;
	document.getElementById("manual").disabled = 'disabled';
	hideMachine2(); 
 }
}

function hideMachine2() {
	var x=document.getElementById("machine")
	if(document.getElementById('manual').checked) {
		x.selectedIndex = 0;		 
    	x.disabled=true		
	} else {
		x.disabled=false	
	}
}
//--------------------Edit by Badra 01/07/2012-----------------------------------------------------------------------
function loadComponentEditorPopup()
{
	var url = "componenteditor.php"
	showBackGround('divBG',0);
	html =$.ajax({url:url,async:false});
	drawPopupBox(570,525,'frmPopComponents',1);
	document.getElementById('frmPopComponents').innerHTML = html.responseText;
	
}
function closePopup(LayerId){
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}
}
function saveComponent()
{
	var process = document.getElementById("cmbProcessID").value;
	var compCatgry = document.getElementById("cmbCategoryId").value;
	var componentid =document.getElementById("hiddn_componentid").value;
	var component = document.getElementById("txtComponent").value;
	var description = document.getElementById("txtDescription").value;
	
	if(process=="")
	{
		alert("Please Select a \"Process\".");
		document.getElementById("cmbProcessID").focus();
		return false;
	}
	if(compCatgry=="")
	{
		alert("Please Select a \"Component Category\".");
		document.getElementById("cmbCategoryId").focus();
		return false;
	}
	else if(component=="")
	{
		alert("Please Enter a \"Component\".");
		document.getElementById("txtComponent").focus();
		return false;	
	}
	else if(description=="")
	{
		alert("Please Enter a \"Description\".");
		document.getElementById("txtDescription").focus();
		return false;
	}
	
	checkDuplicateComponent();
	
	
}

function checkDuplicateComponent()
{
	//var component = document.getElementById("txtComponent").value;
	var process = document.getElementById("cmbProcessID").value;
	var compCatgry = document.getElementById("cmbCategoryId").value;
	var componentid =document.getElementById("hiddn_componentid").value;
	var component = document.getElementById("txtComponent").value;
	var description = document.getElementById("txtDescription").value;
	
	var url ="operationBreakDown_popup_set.php?id=checkDuplicate&component="+component+'&compCatgry=' +compCatgry;
	//alert(url);
	var obj =$.ajax({url:url,async:false});
	//alert(obj.responseText);
	var duplicateNo = obj.responseText;
	//alert(duplicateNo);
	if(duplicateNo ==1)
	{
		alert('This component already exists under the category.');
		document.getElementById("txtComponent").focus();
	}
	if(duplicateNo == 0)
	{
		var url = 'operationBreakDown_popup_set.php?id=saveComponent&process=' +process+'&compCatgry='+compCatgry+'&component='+component +'&description=' +description+'&componentid=' +componentid;
	//alert(url);
	var obj =$.ajax({url:url,async:false});
	var save = obj.responseText;
	if(save == 1)
	{
		getComponent();
	}
	}
}

function getComponent()
{
	if(document.getElementById("cmbCategoryId").value!="" || document.getElementById("cmbProcessID").value!="")
	{
	var categoryid=document.getElementById("cmbCategoryId").value;
	var processid=document.getElementById("cmbProcessID").value;
	
	var url ="xml.php?RequestType=loadComponents&categoryid="+categoryid+"&processid="+processid;
	//alert(url);
	var obj =$.ajax({url:url,async:false});
	//alert(obj.responseText);
									var XMLComponentId	= obj.responseXML.getElementsByTagName('ComponentId');
									//alert(XMLComponentId);
									var XMLCategory	= obj.responseXML.getElementsByTagName('Category');
									var XMLComponent= obj.responseXML.getElementsByTagName('Component');
									var XMLDescription= obj.responseXML.getElementsByTagName('Description');
									var XMLProcess= obj.responseXML.getElementsByTagName('Process');
									var XMLProcessId= obj.responseXML.getElementsByTagName('ProcessId');
									var tblComponent		= document.getElementById('tblComponent');
									var no	=1;
									
									deleterows('tblComponent');			
					
							for(var loop=0;loop<XMLComponentId.length;loop++)
												{
														var lastRow 		= tblComponent.rows.length;	
														var row 			= tblComponent.insertRow(lastRow);
														
														if(loop % 2 ==0)
															row.className ="bcgcolor-tblrow";
														else
															row.className ="bcgcolor-tblrowWhite";			
														
														row.onclick	= rowclickColorChangetbl;
														
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfntMid";	
														rowCell.align="center";
														rowCell.height=20;
														rowCell.innerHTML =	"<img src=\"../../images/del.png\"  class=\"mouseover\" onclick=\"delete_componenet(this);\" />";													
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntMid";	
														rowCell.align="center";
														rowCell.height=20;
														rowCell.innerHTML =	"<img src=\"../../images/edit.png\"  class=\"mouseover\" onclick=\"edit_componenet(this);\" />";													
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfnt";	
														rowCell.id=XMLProcessId[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =(XMLProcess[loop].childNodes[0].nodeValue==""?"-":cdata(XMLProcess[loop].childNodes[0].nodeValue));
														
														var rowCell = row.insertCell(3);
														rowCell.className ="normalfnt";	
														rowCell.id=XMLComponentId[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =(XMLComponent[loop].childNodes[0].nodeValue==""?"-":cdata(XMLComponent[loop].childNodes[0].nodeValue));
														
														
														var rowCell = row.insertCell(4);
														rowCell.className ="normalfnt";	
														rowCell.id = (XMLCategory[loop].childNodes[0].nodeValue==""?"-":cdata(XMLCategory[loop].childNodes[0].nodeValue));
														rowCell.innerHTML =(XMLDescription[loop].childNodes[0].nodeValue==""?"-":cdata(XMLDescription[loop].childNodes[0].nodeValue));
														no++;
												}
								
							//checkDuplicatewithTable();
	}
	else
	{
		deleterows('tblComponent');	
	}
}
function deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	
function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblComponent');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}
function save_all()
{
	if(document.getElementById('tblComponent').rows.length<=1)
	{
		alert("There is no record to save.");
		return;	
	}	
	alert("Saved successfully.");
	clear_forms();
}

function clear_forms()
{	
	document.getElementById("cmbProcessID").value=""
	document.getElementById("hiddn_componentid").value=""
	document.getElementById("txtComponent").value="";
	document.getElementById("cmbCategoryId").value="";
	document.getElementById("txtDescription").value="";
	deleterows('tblComponent');	
	document.getElementById("cmbCategoryId").focus();
}

function delete_componenet(dz)
{
	var component=dz.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	var cmbProcessId=dz.parentNode.parentNode.cells[2].id;
	var componentid=dz.parentNode.parentNode.cells[3].id;
	var category=dz.parentNode.parentNode.cells[4].id;
	
	if(confirm("Are you sure you want to delete \n \'"+component+"\' ?"))
	{
			{	document.getElementById("hiddn_componentid").value=""
				document.getElementById("txtComponent").value="";
				document.getElementById("txtDescription").value="";
			}
	var url = 'operationBreakDown_popup_set.php?id=delete_component&category=' +category+'&componentid='+componentid+'&cmbProcessId='+cmbProcessId;
	var obj =$.ajax({url:url,async:false});
	var deleteComp = obj.responseText;
	if(deleteComp == 1)
	{
		alert('Deleted successfully.');
		getComponent();
	}
			
	}
	
}

function mainfrm_delete()
{
		
	var catid	=document.getElementById("cmbCategoryId").value;
	var category	=document.getElementById("cmbCategoryId").options[document.getElementById("cmbCategoryId").selectedIndex].text;	
	
	if(catid!="")
	{
		if(confirm("Are you sure you want to delete \n"+category+" ?"))
		{
					alert("Deleted successfully.");
					deleterows('tblComponent');
					loadCombo('select 	intCategoryNo, strCategory from componentcategory where intStatus=1 order by strCategory','cmbCategoryId');
					clear_forms();
			
			var url = 'operationBreakDown_popup_set.php?id=delete_category&catid=' +catid;
			var obj =$.ajax({url:url,async:false});
			//alert(url.responseText);	
		}
	}
	
}
//--------------------Edit By Badra 03/07/2012(Processes)---------------------------------------------------------------
function edit_processes()
{
	var url = "processes.php"
	//showBackGround('divBG',0);
	html =$.ajax({url:url,async:false});
	drawPopupArea(450,200,'frmCategory')
	document.getElementById("frmCategory").innerHTML= html.responseText;
	
}

function clear_processes()
{
	document.getElementById("cmbPopProcessId").value="";
	document.getElementById("txtPopProcess").value="";
	document.getElementById("txtPopDscr").value="";
	document.getElementById("txtPopProcess").focus();
}

function dosaveprocess()
{
	var processid=document.getElementById("cmbPopProcessId").value;
	var process=document.getElementById("txtPopProcess").value;
	var pro_description=document.getElementById("txtPopDscr").value;
	if(process=="")
	{
		alert("Please enter a Process.");
		document.getElementById("txtPopProcess").focus();
		return false;
	}
	var id = document.getElementById("cmbPopProcessId").value
	var name = document.getElementById("txtPopProcess").value
	if(!ValidateProcessBeforeSave())
		return;
	{
		alert("Saved successfully.");
		var url = 'operationBreakDown_popup_set.php?id=saveProcess&process='+URLEncode(process)+'&processid='+processid+'&pro_description='+pro_description;
				var obj =$.ajax({url:url,async:false});
				document.getElementById("cmbPopProcessId").value="";
				document.getElementById("txtPopProcess").value="";
				document.getElementById("txtPopDscr").value="";
				loadCombo('select intProcessId, strProcess from ws_processes  order by intProcessId','cmbPopProcessId');
				
	}
}

function ValidateProcessBeforeSave()
{	
	var x_id = document.getElementById("cmbPopProcessId").value;
	var x_name = document.getElementById("txtPopProcess").value;
	
	var x_find = checkInField('ws_processes','strProcess',x_name,'intProcessId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtPopProcess").focus();
		return false;
	}
	
	return true;
}

function getProcess()
{
	var catid=document.getElementById("cmbPopProcessId").value;
	if(catid=="")
	{
	document.getElementById("cmbPopProcessId").value="";
	document.getElementById("txtPopProcess").value="";
	document.getElementById("txtPopDscr").value="";
	document.getElementById("txtPopProcess").focus();
	return;
	}

	
	 var path = "xml.php?RequestType=get_process";
	     path += "&catid="+catid;
	 htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseXML);
	
	 var XMLProcesses = htmlobj.responseXML.getElementsByTagName("Processes");
	 document.getElementById("txtPopProcess").value= XMLProcesses[0].childNodes[0].nodeValue;
	// alert(document.getElementById("txtPopProcess").value);
	 var XMLDescription = htmlobj.responseXML.getElementsByTagName("Description");
	 document.getElementById("txtPopDscr").value= XMLDescription[0].childNodes[0].nodeValue;
}

function delete_Process()
{	
	
	var opProcess=document.getElementById("txtPopProcess").value;
	var processId=document.getElementById("cmbPopProcessId").value;	

	if(processId!="")
	{
		if(confirm("Are you sure you want to delete \n \'"+opProcess+"\' ?"))
		{
					alert("Deleted successfully.");
					var url = 'operationBreakDown_popup_set.php?id=delete_process&processId='+processId;
			var obj =$.ajax({url:url,async:false});
					document.getElementById("cmbPopProcessId").value="";
					document.getElementById("txtPopProcess").value="";
					document.getElementById("txtPopDscr").value="";
					loadCombo('select intProcessId, strProcess from ws_processes  order by intProcessId','cmbPopProcessId');
		}
	}
	else
	{
		alert('Please select a Process.');
		document.getElementById("cmbPopProcessId").focus();
	}
}
function close_process(){
	closeWindow();	
    loadCombo('select intProcessId, strProcess from ws_processes  order by intProcessId','cmbProcessId');	
}
//--------------------Edit By Badra 03/07/2012(Category)---------------------------------------------------------------
function edit_category()
{
	var url = "popcategory.php"
	//showBackGround('divBG',0);
	html =$.ajax({url:url,async:false});
	drawPopupArea(450,200,'frmCategory')
	document.getElementById("frmCategory").innerHTML= html.responseText;
	
}
function close_pop()
{
	closeWindow();	
	loadCombo('select 	intCategoryNo, strCategory from componentcategory where intStatus=1 order by strCategory','cmbCategoryId');
	
}
function clear_pop()
{	
	document.getElementById("cmbPopCategoryId").value="";
	document.getElementById("txPoptCategory").value="";
	document.getElementById("txtPopDscr").value="";
	document.getElementById("txPoptCategory").focus();
}

function dosavecategory()
{
	var catid=document.getElementById("cmbPopCategoryId").value;
	var category=document.getElementById("txPoptCategory").value;
	var cat_description=document.getElementById("txtPopCatDscr").value;
	if(category=="")
	{
		alert("Please enter a Category.");
		document.getElementById("txPoptCategory").focus();
		return false;
	}
	var catId = document.getElementById("cmbPopCategoryId").value
	var catName = document.getElementById("txPoptCategory").value
	if(!ValidateCategoryBeforeSave())
		return;
	{
		alert("Saved successfully.");
		var url = 'operationBreakDown_popup_set.php?id=saveCat&category='+URLEncode(category)+'&catid='+catid+'&cat_description='+cat_description;
				var obj =$.ajax({url:url,async:false});
				document.getElementById("cmbPopCategoryId").value="";
				document.getElementById("txPoptCategory").value="";
				document.getElementById("txtPopCatDscr").value="";
				loadCombo('select 	intCategoryNo, strCategory from componentcategory where intStatus=1 order by strCategory','cmbPopCategoryId');
				
	}
}

function ValidateCategoryBeforeSave()
{	
	var x_id = document.getElementById("cmbPopCategoryId").value;
	var x_name = document.getElementById("txPoptCategory").value;
	
	var x_find = checkInField('componentcategory','strCategory',x_name,'intCategoryNo',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txPoptCategory").focus();
		return false;
	}
	
	return true;
}

function delete_category()
{	
	
	var opCategory=document.getElementById("txPoptCategory").value;
	var categoryId=document.getElementById("cmbPopCategoryId").value;	

	if(categoryId!="")
	{
		if(confirm("Are you sure you want to delete \n \'"+opCategory+"\' ?"))
		{
					alert("Deleted successfully.");
					var url = 'operationBreakDown_popup_set.php?id=deleteCategory&categoryId='+categoryId;
			var obj =$.ajax({url:url,async:false});
					document.getElementById("cmbPopCategoryId").value="";
					document.getElementById("txPoptCategory").value="";
					document.getElementById("txtPopCatDscr").value="";
					loadCombo('select 	intCategoryNo, strCategory from componentcategory where intStatus=1 order by strCategory','cmbPopCategoryId');
		}
	}
	else
	{
		alert('Please select a Category.');
		document.getElementById("cmbPopCategoryId").focus();
	}
}

function getCategory()
{
	var categoryid=document.getElementById("cmbPopCategoryId").value;
	if(categoryid=="")
	{
	document.getElementById("cmbPopCategoryId").value="";
	document.getElementById("txPoptCategory").value="";
	document.getElementById("txtPopCatDscr").value="";
	document.getElementById("txPoptCategory").focus();
	return;
	}

	
	 var path = "xml.php?RequestType=get_category";
	     path += "&categoryid="+categoryid;
	 htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseXML);
	
	 var XMLCategory = htmlobj.responseXML.getElementsByTagName("Category");
	 document.getElementById("txPoptCategory").value= XMLCategory[0].childNodes[0].nodeValue;
	// alert(document.getElementById("txtPopProcess").value);
	 var XMLCatDescription = htmlobj.responseXML.getElementsByTagName("CatDescription");
	 document.getElementById("txtPopCatDscr").value= XMLCatDescription[0].childNodes[0].nodeValue;
}

function loadComponentsWise()
{
	if(document.getElementById("cmbProcessId").value!="" || document.getElementById("comCat").value!="")
	{
	var intCatId   = document.getElementById('comCat').value;
	var intProcessId   = document.getElementById('cmbProcessId').value;
	
	var url ="operationBreakDown_popup_set.php?id=loadComponentsProcessCatWise&intCatId="+intCatId+"&intProcessId="+intProcessId;
	//alert(url);
	var obj =$.ajax({url:url,async:false});
	//alert(obj.responseText);
	document.getElementById('component').innerHTML = obj.responseText;
	document.getElementById('operation').innerHTML='';
	}
}

