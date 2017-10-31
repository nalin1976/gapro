///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
function displayDetail()
{//alert('displayDetail');
	document.getElementById('detailTR').style.display = 'block';
	increaseDivHeight('detalisDiv',250,0);
	//increaseDivWidth('detalisDiv',580,0);
	//increaseDivWidth('viewerSubDiv',600,0);
	setTimeout("loadEvents();",200);
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);
	document.getElementById('btUpAndDown').innerHTML = "<img src='../../images/btDownArrow.png' width='23' height='23' class='mouseover' onclick='closeDetail();'/>";
}

function increaseDivWidth(div,maxHeight,i)
{
	
	document.getElementById(div).style.width = i +"px";
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);
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
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);
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
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);
	document.getElementById('btUpAndDown').innerHTML = "<img src='../../images/btUpArrow.png' width='23' height='23' class='mouseover' onclick='displayDetail();'/>";
	document.getElementById('detalisDiv').innerHTML = "";
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
	document.getElementById('btSkipEvent').style.display="";
	}else if(document.getElementById('rdPending').checked==true){
	var rd = "P";
	document.getElementById('btCompleteEvent').style.display="";
	document.getElementById('btSkipEvent').style.display="";
	}else if(document.getElementById('rdCompleted').checked==true){
	var rd = "C";
	document.getElementById('btCompleteEvent').style.display="none";
	document.getElementById('btSkipEvent').style.display="none";
	}
	
	document.getElementById('detalisDiv').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
													   "<tr><td align='center'>"+
													   "<img src='../../images/loadingimg.gif'/></td>"+
													   "</tr></table>";
	
	var searchOrderNo = document.getElementById('searchOrderNo').value;
	var searchEvent = document.getElementById('searchEvent').value;
	var searchDateFrom = document.getElementById('searchDateFrom').value;
	var searchDateTo = document.getElementById('searchDateTo').value;	
	var searchStyle = document.getElementById('searchStyle').value;
	var searchBuyer = document.getElementById('searchBuyer').value;
	var searchColor = document.getElementById('searchColor').value;
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
		url +="&searchColor="+searchColor;
		url +="&hdGridOrderBy="+hdGridOrderBy;
		//alert(url);
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('detalisDiv').innerHTML = htmlobj.responseText;
		hideMoreOrderDetails();
}

function displayMoreInfoTop()
{
	//alert(EventName);
	document.getElementById('moreDetailTR').style.display = 'block';
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);
	loadSearchBuyer();
	loadSearchEvent();	
	loadSearchOrderNo();
	loadSearchStyle();
	loadSearchColor();	
}

function closeMoreDetailTop()
{
	document.getElementById('moreDetailTR').style.display = 'none';
	setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);	
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
	////When delay event complete
	if(document.getElementById('checkBox/'+i).checked==true && document.getElementById('rdDelayed').checked==true){
	var orderNo = document.getElementById('tdOrderNo/'+i).innerHTML;
	var eventName = document.getElementById('tdEventName/'+i).innerHTML;	
	var reason=prompt("Please enter reason for delay this event.\n\nOrder No\t :"+orderNo+"\nEvent\t\t :"+eventName+"\n ","");
	document.getElementById('hdDelayedReason/'+i).value = reason;	
	}else{
	document.getElementById('hdDelayedReason/'+i).value = "";	
	}
}

function completeEvent()
{
	if(eventSelectingValidation()==false){
	alert("Please tick event.");
	return false;
	}
	if(eventComplateValidation()==false){
	alert("Enter date of event completed.");
	return false;
	}	
	var c = confirm("Are you sure you want to COMPLETE events ?");
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

function eventSelectingValidation()
{
	var tbl = document.getElementById('evtScheduleDetails');//alert(tbl.rows.length);
	for(var i=1;i<=tbl.rows.length;i++)
	{ //alert(i);
	  	if(document.getElementById('checkBox/'+i).checked==true){
			return true;
		}		
	}	
return false;
}

function eventComplateValidation()
{
	var tbl = document.getElementById('evtScheduleDetails');//alert(tbl.rows.length);
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

function loadSearchColor()
{
		document.getElementById('searchColor').innerHTML = "<option value=''>Loading</option>";
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=loadSearchColor";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	
		document.getElementById('searchColor').innerHTML = htmlobj.responseText;	
}

function completeEventsBefore20130320()
{

		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=completeEventsBefore20130320";
		htmlobj=$.ajax({url:url,async:false});	
		//alert(htmlobj.responseText);	

}

function showMoreOrderDetails()
{
	var totalTableColumWIth = 1163 ;
	document.getElementById('evtScheduleHeadr').style.width=totalTableColumWIth+"px"; // Afert the maximize colums with of Header table(sum of table all colum width)
	document.getElementById('evtScheduleDetails').style.width=totalTableColumWIth+"px"; // Afert the maximize colums with of Detail table(sum of table all colum width)

	$('.moreColumStyleNo').show();
	$('.moreColumOritOrderNo').show();
	$('.moreColumDevision').show();
	$('.moreColumBuyer').show();

	scrollGridHead('headerDiv','detalisDiv');
	document.getElementById('tdExpandOrderDetails').innerHTML="<img src='../../images/btRightArrow.png' border='0' width='23' height='23' onclick='hideMoreOrderDetails();'/>";
}

function hideMoreOrderDetails()
{
	document.getElementById('evtScheduleHeadr').style.width=563+"px";
	document.getElementById('evtScheduleDetails').style.width=563+"px";

	$('.moreColumStyleNo').hide();
	$('.moreColumOritOrderNo').hide();
	$('.moreColumDevision').hide();
	$('.moreColumBuyer').hide();

	scrollGridHead('headerDiv','detalisDiv');
	document.getElementById('tdExpandOrderDetails').innerHTML="<img src='images/btLeftArrow.png' border='0' width='23' height='23' onclick='showMoreOrderDetails();'/>";
	
}

function hideColums(colStyle,width)
{//alert(colStyle);
	$('.'+colStyle).hide();
	var headrTotWidth = parseInt(document.getElementById('evtScheduleHeadr').style.width);
	var detailTotWidth = parseInt(document.getElementById('evtScheduleDetails').style.width);
	document.getElementById('evtScheduleHeadr').style.width=headrTotWidth-width+"px";
	document.getElementById('evtScheduleDetails').style.width=detailTotWidth-width+"px";	
}

function addDelayComment(eventScheduleId,intEventId,i,eventStatus)
{
	var existingComment="";
	var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=takeExsitingDelayEventComments";
				url +="&eventScheduleId="+eventScheduleId;
				url +="&intEventId="+intEventId;
				htmlobj=$.ajax({url:url,async:false});	
				//alert(htmlobj.responseText);
				existingComment = htmlobj.responseText;
				
	var orderNo = document.getElementById('tdOrderNo/'+i).innerHTML;
	var eventName = document.getElementById('tdEventName/'+i).innerHTML;		
	var reason=prompt("Please enter REMARK for this event.\n\nOrder No\t :"+orderNo+"\nEvent\t\t :"+eventName+"\n ",existingComment);

	if(reason && reason!=""){
		var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=saveDelayEventComments";
				url +="&eventScheduleId="+eventScheduleId;
				url +="&intEventId="+intEventId;
				url +="&reason="+reason;
				url +="&eventStatus="+eventStatus;	 //alert(url);
				htmlobj=$.ajax({url:url,async:false});	
				//alert(htmlobj.responseText);
				alert("Comment added successful.");
				loadEvents();
	}
}

function viewRemarks(eventScheduleId,intEventId)
{
	var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=viewRemarks";
				url +="&eventScheduleId="+eventScheduleId;
				url +="&intEventId="+intEventId;
				htmlobj=$.ajax({url:url,async:false});	
				//alert(htmlobj.responseText);
				
	$("#tiptable").remove();		
					
		var	html = "<div id='tiptable' class='tooltip'>"+htmlobj.responseText+"</div>";
				
		$('body').append(html).children('tiptable').hide().fadeIn(400);
		
		$(document).mousemove(function(e){
			$('#tiptable').css('top',e.pageY + 5).css('left',e.pageX + 20);
		});
	
}

function hideRemarks()
{
	$("#tiptable").remove();
}

function skipEvent()
{//alert('pp');
	if(eventSelectingValidation()==false){
	alert("Please tick event.");
	return false;
	}
	if(eventComplateValidation()==false){
	alert("Enter date of event skiped.");
	return false;
	}
	
	if(eventSkipResonValidation()==false){
	//alert("Enter reason for skip this event");
	return false;
	}
		
	var c = confirm("Are you sure you want to SKIP events ?");
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
			var hdSkipedReason=document.getElementById('hdSkipedReason/'+i).value;
			
			var url = "mainPageViewers/eventsViewer/eventsViewerDB.php?RequestType=skipEvent";
				url +="&scheduleId="+scheduleId;
				url +="&eventId="+eventId;
				url +="&txtComplateDate="+txtComplateDate;	
				url +="&hdSkipedReason="+hdSkipedReason;// alert(url);
				htmlobj=$.ajax({url:url,async:false});
				//alert(htmlobj.responseText);
		}		
	}
	if(htmlobj.responseText==1){
		alert("Events skip sucessful.");
		loadEvents();
		loadNoOfDelayedEvent();	
	}else{
		alert("Fail");
	}
}

function eventSkipResonValidation()
{
	var tbl = document.getElementById('evtScheduleDetails');//alert(tbl.rows.length);
	//alert("ok");
	for(var i=1;i<=tbl.rows.length;i++)
	{ //alert(i);
	  	if(document.getElementById('checkBox/'+i).checked==true){
			var txtComplateDate=document.getElementById('hdSkipedReason/'+i).value;
			if(txtComplateDate==""){
			setSkipedReson(i);
			return false;	
			}
		}		
	}	
return true;
}

function setSkipedReson(i)
{//alert(i);
	if(document.getElementById('checkBox/'+i).checked==true){
	var orderNo = document.getElementById('tdOrderNo/'+i).innerHTML;
	var eventName = document.getElementById('tdEventName/'+i).innerHTML;	
	var reason=prompt("Please enter reason for SKIP this event.\n\nOrder No\t :"+orderNo+"\nEvent\t\t :"+eventName+"\n ","");
		if(reason){/// if press ok buttton
		document.getElementById('hdSkipedReason/'+i).value = reason;	
		skipEvent();///call again for save
		}
	}else{
	document.getElementById('hdSkipedReason/'+i).value = "";	
	}
}