//unit cinversion.js
//27-12-2010

var tag=0;
var unitSerial=0;

function loadFromUnit(obj){
	var path="unitConversionXml.php?req=loadUnit&unit="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLUnit=htmlobj.responseXML.getElementsByTagName('UnitName');
	document.getElementById('cboFromUnit').innerHTML="<option value=\"\"></option>";
	if(XMLUnit.length > 0){
		for(var i=0;i<XMLUnit.length;i++){
			var opt = document.createElement("option");
			opt.value = XMLUnit[i].childNodes[0].nodeValue;	
			opt.text = XMLUnit[i].childNodes[0].nodeValue;	
			document.getElementById("cboFromUnit").options.add(opt);
		}
	}
		
}

function loadToUnit(obj){
	var path="unitConversionXml.php?req=loadUnit&unit="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLUnit=htmlobj.responseXML.getElementsByTagName('UnitName');
	document.getElementById('cboToUnit').innerHTML="<option value=\"\"></option>";
	if(XMLUnit.length > 0){
		for(var i=0;i<XMLUnit.length;i++){
			var opt = document.createElement("option");
			opt.value = XMLUnit[i].childNodes[0].nodeValue;	
			opt.text = XMLUnit[i].childNodes[0].nodeValue;	
			document.getElementById("cboToUnit").options.add(opt);
		}
	}
}

function deleteUnit(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		var serial=obj.parentNode.parentNode.cells[0].id;
		var path="unitConversionXml.php?req=deleteUnit&serial="+serial;
		htmlobj=$.ajax({url:path,async:false});
		var XMLRes=htmlobj.responseXML.getElementsByTagName('Res')[0].childNodes[0].nodeValue;
		if(XMLRes){
			var tbl = document.getElementById('tblmain').tBodies[0];
			var td = obj.parentNode;
			var tro = td.parentNode;
			//var tt=tro.parentNode;		
			tro.parentNode.removeChild(tro);
			alert("Deleted successfully .");
		}
	}
}

function editUnit(obj){
	var id=obj.parentNode.parentNode.cells[0].id.trim();
	tag=1;
	unitSerial=obj.parentNode.parentNode.cells[0].id.trim();
	document.getElementById('cboFromUnit').value=obj.parentNode.parentNode.cells[2].innerHTML;
	
	loadToUnit(document.getElementById('cboFromUnit'));
	var opt = document.createElement("option");
			opt.value = obj.parentNode.parentNode.cells[3].innerHTML;	
			opt.text = obj.parentNode.parentNode.cells[3].innerHTML;	
			document.getElementById("cboToUnit").options.add(opt); 
			document.getElementById("cboToUnit").value=obj.parentNode.parentNode.cells[3].innerHTML;
	document.getElementById('txtFactor').value=obj.parentNode.parentNode.cells[4].innerHTML;
	
}

function setNew(){
	tag=0;
	document.getElementById('cboToUnit').innerHTML="<option value=\"\"></option>";
	document.getElementById('cboFromUnit').value="";
	document.getElementById('txtFactor').value="";
}

function saveDet(){
	var req="";
	
	var toUnit = document.getElementById('cboToUnit').value;
	var fromUnit = document.getElementById('cboFromUnit').value;
	var factor = document.getElementById('txtFactor').value;
	if(toUnit==""){
		alert("Please select \"To Unit\"");
		document.getElementById('cboToUnit').focus();
		return false;
	}
	if(fromUnit==""){
		alert("Please select \"From Unit\"");
		document.getElementById('cboFromUnit').focus();
		return false;
	}
	if(factor==""){
		alert("Please enter the \"Factor\"");
		document.getElementById('txtFactor').focus();
		return false;
	}
	if(tag==1){
		req="updateDet&serial="+unitSerial;
	}
	else{
		req="addNew";	
	}
	var path="unitConversionXml.php?req="+req+"&toUnit="+toUnit+"&fromUnit="+fromUnit+"&factor="+factor;
	htmlobj=$.ajax({url:path,async:false});
	var XMLRes=htmlobj.responseXML.getElementsByTagName('Res');
	var XMLtag=htmlobj.responseXML.getElementsByTagName('tag');
	
	if(XMLRes[0].childNodes[0].nodeValue)
		if(XMLtag[0].childNodes[0].nodeValue==1){
			var XMLSerial=htmlobj.responseXML.getElementsByTagName('serial')[0].childNodes[0].nodeValue;
			alert("Saved successfully.");
			addNewRow(XMLSerial,toUnit,fromUnit,factor);
			setNew();
			return false;
		}
		else if(XMLtag[0].childNodes[0].nodeValue==2){
			alert("Updated successfully .");
			updateGrid(unitSerial,toUnit,fromUnit,factor)
			setNew();
			return false;
		}
	else
		alert("error.");
}

function addNewRow(XMLSerial,toUnit,fromUnit,factor){
	var tblmain=document.getElementById('tblmain').tBodies[0];
	var rc=tblmain.rows.length;
	var row = tblmain.insertRow(rc);
	var cls="";
	(rc%2==0)?cls="grid_raw":cls="grid_raw2";
	tblmain.rows[rc].innerHTML= "<td class=\""+cls+"\" id=\""+ XMLSerial +"\"><img src=\"../../images/del.png\" onclick=\"deleteUnit(this);\" /></td><td class=\""+cls+"\" ><img src=\"../../images/edit.png\" onclick=\"editUnit(this);\" /></td><td class=\""+cls+"\" style=\"text-align:left;\">"+fromUnit+"</td><td class=\""+cls+"\" style=\"text-align:left;\">"+toUnit+"</td><td class=\""+cls+"\" style=\"text-align:right;\">"+factor+"</td>" ;
}

function updateGrid(unitSerial,toUnit,fromUnit,factor){
	var tblmain=document.getElementById('tblmain').tBodies[0];
	var rc=tblmain.rows.length;
	for(var i=0;i<rc;i++){
		if(tblmain.rows[i].cells[0].id==unitSerial){
			tblmain.rows[i].cells[2].innerHTML=fromUnit;
			tblmain.rows[i].cells[3].innerHTML=toUnit;
			tblmain.rows[i].cells[4].innerHTML=factor;
			return false;
		}
	}
}