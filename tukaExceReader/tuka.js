// JavaScript Document

function loadReport(){
	var marker = document.getElementById('strMarkerName').value;
	window.open("markerAppSheet.php?marker=" + marker,'frmTuka');
}