///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
function displayDetailExample()
{//alert('displayDetail');
	document.getElementById('detailTRExample').style.display = 'block';
	setViewerPosition("Example",500,10);
	document.getElementById('btUpAndDownExample').innerHTML = "<img src='images/btDownArrow.png' width='23' height='23' class='mouseover' onclick='closeDetailExample();'/>";
}
function closeDetailExample()
{
	closeMoreDetailTop();
	document.getElementById('detailTRExample').style.display = 'none';
	setViewerPosition("Example",500,10);
	document.getElementById('btUpAndDownExample').innerHTML = "<img src='images/btUpArrow.png' width='23' height='23' class='mouseover' onclick='displayDetailExample();'/>";
}
function displayMoreInfoTopExample()
{
	document.getElementById('moreDetailTRExample').style.display = 'block';
	setViewerPosition("Example",500,10);
}
function closeMoreDetailTopExample()
{
	document.getElementById('moreDetailTRExample').style.display = 'none';
	setViewerPosition("Example",500,10);
}
////////////////////////////////////////// Data base connectivity ////////////////////////////////////////////////////
function loadGridDataExample()
{
		var value = "Hello World.";
		var url = "mainPageViewers/example/exampleDB.php?RequestType=loadGridDataExample";
		url +="&name="+value;	
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('detalisDivExample').innerHTML = htmlobj.responseText;
	
}







