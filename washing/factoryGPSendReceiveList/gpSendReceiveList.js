//js
function getStyle(obj){	
 var path="gpSendReceiveList_xml.php?req=loadStyle&po="+obj.value.trim(); 
	htmlobj=$.ajax({url:path,async:false});
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('style');
	var XMLFromFactory=htmlobj.responseXML.getElementsByTagName('FromFactory');
	document.getElementById('cboStyleNo').value=XMLStyle[0].childNodes[0].nodeValue;
	document.getElementById('cboFactory').value=XMLFromFactory[0].childNodes[0].nodeValue;
	loadColor(obj.value);
}

function getPo(obj){
var path="gpSendReceiveList_xml.php?req=loadPo&style="+obj.value.trim(); 
	htmlobj=$.ajax({url:path,async:false});
	var XMLPo=htmlobj.responseXML.getElementsByTagName('po');
	var XMLFromFactory=htmlobj.responseXML.getElementsByTagName('FromFactory');
	document.getElementById('cboPo').value=XMLPo[0].childNodes[0].nodeValue;
	document.getElementById('cboFactory').value=XMLFromFactory[0].childNodes[0].nodeValue;	
	loadColor(document.getElementById('cboPo').value)
}

function loadColor(po){
	
	var path="gpSendReceiveList_xml.php?req=loadColor&po="+po; 
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor=htmlobj.responseXML.getElementsByTagName('color');
	document.getElementById('cboColor').innerHTML=XMLColor[0].childNodes[0].nodeValue;	
}

function showLogReport(){
	var path="po="+document.getElementById('cboPo').value.trim()+"&color="+document.getElementById('cboColor').value.trim()+"&factory="+document.getElementById('cboFactory').value.trim();
	window.open('rptGpSendReceiveList.php?'+path,'new');
}