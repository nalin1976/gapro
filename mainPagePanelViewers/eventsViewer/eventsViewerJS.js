///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
function displayDetail()
{//alert('displayDetail');
	document.getElementById('detailTR').style.display = 'block';
	increaseDivHeight('detalisDiv',250,0);
	increaseDivWidth('detalisDiv',580,0);
	//increaseDivWidth('viewerSubDiv',600,0);
	setViewerPosition("eventViewerMainDiv",10,10);
	document.getElementById('btUpAndDown').innerHTML = "<img src='images/btDownArrow.png' width='23' height='23' class='mouseover' onclick='closeDetail();'/>";
}

function increaseDivWidth(div,maxHeight,i)
{
	
	document.getElementById(div).style.width = i +"px";
	setViewerPosition("eventViewerMainDiv",10,10);
	i=i+72.5;
	if(i<=maxHeight){
	setTimeout("increaseDivWidth('"+div+"',"+maxHeight+","+i+")",10);
	}else{
	return false;	
	}
}

function increaseDivHeight(div,maxHeight,i)
{
	
	document.getElementById(div).style.height = i +"px";
	setViewerPosition("eventViewerMainDiv",10,10);
	i=i+50;
	if(i<=maxHeight){
	setTimeout("increaseDivHeight('"+div+"',"+maxHeight+","+i+")",10);
	}else{
	return false;	
	}
}


function closeDetail()
{
	closeMoreDetailTop();
	document.getElementById('detailTR').style.display = 'none';
	setViewerPosition("eventViewerMainDiv",10,10);
	document.getElementById('btUpAndDown').innerHTML = "<img src='images/btUpArrow.png' width='23' height='23' class='mouseover' onclick='displayDetail();'/>";
}

function loadDataOrderBy(val)
{
	document.getElementById('hdGridOrderBy').value=val;
	loadEvents();
}



function loadEvents()
{
	if(document.getElementById('rdDelayed').checked==true){
	var rd = "D";
	document.getElementById('btCompleteEvent').style.display="";
	}else if(document.getElementById('rdPending').checked==true){
	var rd = "P";
	document.getElementById('btCompleteEvent').style.display="";
	}else if(document.getElementById('rdCompleted').checked==true){
	var rd = "C";
	document.getElementById('btCompleteEvent').style.display="none";
	}
	
	document.getElementById('detalisDiv').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
													   "<tr><td align='center'>"+
													   "<img src='images/loadingimg.gif'/></td>"+
													   "</tr></table>";
	
	var searchOrderNo = document.getElementById('searchOrderNo').value;
	var searchEvent = document.getElementById('searchEvent').value;
	var searchDateFrom = document.getElementById('searchDateFrom').value;
	var searchDateTo = document.getElementById('searchDateTo').value;	
	var searchStyle = document.getElementById('searchStyle').value;
	var searchBuyer = document.getElementById('searchBuyer').value;
	var hdGridOrderBy = document.getElementById('hdGridOrderBy').value;
	
	if(searchDateFrom!="" && searchDateTo==""){
	alert("Enter \"Date To\" ");	
	}else if(searchDateFrom=="" && searchDateTo!=""){
	alert("Enter \"Date From\" ");	
	}else if(searchDateFrom>searchDateTo){
	alert("Enter currect date range");	
	}
	
	var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadEvents";
		url +="&eventStatus="+rd;	
		url +="&searchOrderNo="+searchOrderNo;
		url +="&searchEvent="+searchEvent;
		url +="&searchDateFrom="+searchDateFrom;
		url +="&searchDateTo="+searchDateTo;
		url +="&searchStyle="+searchStyle;
		url +="&searchBuyer="+searchBuyer;
		url +="&hdGridOrderBy="+hdGridOrderBy;
		//alert(url);
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('detalisDiv').innerHTML = htmlobj.responseText;
}

function displayMoreInfoTop()
{
	//alert(EventName);
	document.getElementById('moreDetailTR').style.display = 'block';
	setViewerPosition("eventViewerMainDiv",10,10);
	loadSearchBuyer();
	loadSearchEvent();	
	loadSearchOrderNo();
	loadSearchStyle();	
}

function closeMoreDetailTop()
{
	document.getElementById('moreDetailTR').style.display = 'none';
	setViewerPosition("eventViewerMainDiv",10,10);	
}

function enableDt(i)
{
//alert(i);
	if(document.getElementById('checkBox/'+i).checked==	true)
	{
		document.getElementById('cmptDt/'+i).disabled =false;
		document.getElementById('cmptDt/'+i).value = document.getElementById('hdToday').value;
	}else{
		document.getElementById('cmptDt/'+i).disabled =true;
		document.getElementById('cmptDt/'+i).value ="";
	}	
}

function setDelayedReson(i)
{//alert(i);
	if(document.getElementById('checkBox/'+i).checked==true && document.getElementById('rdDelayed').checked==true){
	var reason=prompt("Please enter reason for delay","");
	document.getElementById('hdDelayedReason/'+i).value = reason;	
	}else{
	document.getElementById('hdDelayedReason/'+i).value = "";	
	}
}

function completeEvent()
{
	if(eventComplateValidation()==false){
	alert("Enter date of event completed.");
	return false;
	}
		
	var c = confirm("Are you sure you want to complete events ?");
	if(c==false){
	return false;	
	}
	var tbl = document.getElementById('evtScheduleDetails');//alert(tbl.rows.length);
	//alert("ok");
	for(var i=1;i<=tbl.rows.length;i++)
	{ //alert(i);
	  	if(document.getElementById('checkBox/'+i).checked==true){
			//alert(i);
			var scheduleId=document.getElementById('hdEventScheduleId/'+i).value;
			var eventId=document.getElementById('hdEventId/'+i).value;
			var txtComplateDate=document.getElementById('cmptDt/'+i).value;
			var hdDelayedReason=document.getElementById('hdDelayedReason/'+i).value;
			
			var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=completeEvent";
				url +="&scheduleId="+scheduleId;
				url +="&eventId="+eventId;
				url +="&txtComplateDate="+txtComplateDate;	
				url +="&hdDelayedReason="+hdDelayedReason; //alert(url);
				htmlobj=$.ajax({url:url,async:false});
				//alert(htmlobj.responseText);
		}		
	}
	if(htmlobj.responseText==1){
		alert("Events complete sucessful.");
		loadEvents();
		loadNoOfDelayedEvent();
	}
}

function eventComplateValidation()
{
	var tbl = document.getElementById('evtScheduleDetails');//alert(tbl.rows.length);
	//alert("ok");
	for(var i=1;i<=tbl.rows.length;i++)
	{ //alert(i);
	  	if(document.getElementById('checkBox/'+i).checked==true){
			var txtComplateDate=document.getElementById('cmptDt/'+i).value;
			if(txtComplateDate==""){
			document.getElementById('cmptDt/'+i).focus();
			return false;	
			}
		}		
	}	
return true;
}

function resetSrchFm()
{
	document.getElementById('searchOrderNo').value="";
	document.getElementById('searchEvent').value="";
	document.getElementById('searchDateFrom').value="";
	document.getElementById('searchDateTo').value="";		
}

function loadNoOfDelayedEvent()
{
//alert("pl");
	var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadNoOfDelayedEvent";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('tdNoOfDelayedEvent').innerHTML = "(Delayed:"+htmlobj.responseText+")";
}


function loadSearchOrderNo()
{
		document.getElementById('searchOrderNo').innerHTML = "<option value=''>Loading</option>";
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadSearchOrderNo";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('searchOrderNo').innerHTML = htmlobj.responseText;	
}

function loadSearchEvent()
{
		document.getElementById('searchEvent').innerHTML = "<option value=''>Loading</option>";
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadSearchEvent";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('searchEvent').innerHTML = htmlobj.responseText;
}

function loadSearchStyle()
{
		document.getElementById('searchStyle').innerHTML = "<option value=''>Loading</option>";
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadSearchStyle";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('searchStyle').innerHTML = htmlobj.responseText;
}

function loadSearchBuyer()
{
		document.getElementById('searchBuyer').innerHTML = "<option value=''>Loading</option>";
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadSearchBuyer";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('searchBuyer').innerHTML = htmlobj.responseText;
}

function completeEventsBefore20130320()
{

		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=completeEventsBefore20130320";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	

}