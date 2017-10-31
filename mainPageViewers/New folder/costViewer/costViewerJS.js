
function showReport(CostCenter)
{ var CostCenter=document.getElementById("cboCostCenter").value;
	
	
	var url="mainPageViewers/costViewer/rptRol.php?";
	url +="&CostCenter="+CostCenter;
	window.open(url,'123');
	
}
function displayDetail1()
{//alert('displayDetail');
	document.getElementById('detailTR11').style.display='block';
	increaseDivHeight1('detalisDiv1',250,0); 
	setTimeout("loaddetalisDiv1();",200);
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);
	document.getElementById('btUpAndDown1').innerHTML = "<img src='images/btDownArrow.png' width='23' height='23' class='mouseover' onclick='closeDetail1();'/>";
}
function increaseDivHeight1(div,maxHeight,i)
{
	
	document.getElementById(div).style.height = i +"px";
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);
	i=i+50;
	if(i<=maxHeight){
	setTimeout("increaseDivHeight1('"+div+"',"+maxHeight+","+i+")",10);
	}else{
	return false;	
	}
}
function loaddetalisDiv1()
{       
		document.getElementById('detalisDiv1').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
													   "<tr><td align='center'>"+
													   "<img src='images/loadingimg.gif'/></td>"+
													   "</tr></table>";
													   
		var CostCenter=document.getElementById("cboCostCenter").value;
		var url = "mainPageViewers/costViewer/costViewerDB.php?RequestType=loadCost";
		url +="&CostCenter="+CostCenter;	//alert(url);
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
	
		var XMLintMatDetailId= htmlobj.responseXML.getElementsByTagName("intMatDetailId");
		var XMLdblReorderLevel= htmlobj.responseXML.getElementsByTagName("dblReorderLevel");
		var XMLdblQty= htmlobj.responseXML.getElementsByTagName("dblQty");
		document.getElementById('detalisDiv1').innerHTML = "";
		displayDetail2(XMLintMatDetailId,XMLdblReorderLevel,XMLdblQty);
		
		
	}
function displayDetail2(XMLintMatDetailId,XMLdblReorderLevel,XMLdblQty)
{
	document.getElementById('detailTR11').style.display = 'block';
	//increaseDivHeight1('detalisDiv1',250,0);
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);
	var XMLintMatDetailId=XMLintMatDetailId;
	var XMLdblReorderLevel=XMLdblReorderLevel;
	var XMLdblQty=XMLdblQty;
	
	var tableText = " <table width='558' cellpadding='0' cellspacing='1' id='tblData1' align='left'>";
		
	 for ( var loop = 0; loop<XMLintMatDetailId.length; loop++)
	 {
		 if(loop%2){
			var rowColor = "#FBEDA2"; 
		 }else{
			var rowColor = "#fdf6d0"; 
		 }
		 
		tableText +="<tr bgcolor='"+rowColor+"' style='font-size:10px'>"+
		"	<td width='80%' height=\"20\" class=\"normalfnt\">"+XMLintMatDetailId[loop].childNodes[0].nodeValue+"</td>"+
		"	<td width='10%' class=\"normalfnt\">"+XMLdblReorderLevel[loop].childNodes[0].nodeValue+"</td>"+
		"	<td width='10%' class=\"normalfnt\">"+XMLdblQty[loop].childNodes[0].nodeValue+"</td>"+
		"	</tr>";
	}
		tableText += "</table>";
	document.getElementById("detalisDiv1").innerHTML = tableText;
	
	
					
	/*for(var loop=0;loop<XMLCostCenter.length;loop++)
	{
		var CostCenter = XMLCostCenter[loop].childNodes[0].nodeValue;
		var Description = XMLDescription[loop].childNodes[0].nodeValue;
		//alert(Description);
	}*/
	
	document.getElementById('btUpAndDown1').innerHTML = "<img src='images/btDownArrow.png' width='23' height='23' class='mouseover' onclick='closeDetail1();'/>";
}

function closeDetail1()
{
	
	closeMoreDetail1();
	document.getElementById('detailTR11').style.display = 'none';
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);
	document.getElementById('btUpAndDown1').innerHTML = "<img src='images/btUpArrow.png' width='23' height='23' class='mouseover' onclick='displayDetail1();'/>";
	document.getElementById('detalisDiv1').innerHTML = "";
}

function loadCost(rd)
{
	
	document.getElementById('detalisDiv1').innerHTML = "<table width='100%' height='100%' id='costDetails'>"+
													   "<tr><td align='center'>"+
													   "<img src='images/loadingimg.gif'/></td>"+
													   "</tr></table>";
	var url = "mainPageViewers/costViewer/costViewerDB.php?RequestType=loadCost";
		url +="&costStatus="+rd;	//alert(url);
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById('detalisDiv1').innerHTML = htmlobj.responseText;
}

function displayMoreInfo1(CostName,strOrderNo)
{
	//alert(EventName);
	document.getElementById('moreDetailTR11').style.display = 'block';
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);
	document.getElementById('txtOrderNo').value=strOrderNo;	
	document.getElementById('txtCostName').value=CostName;	
}

function closeMoreDetail1()
{
	document.getElementById('detailTR11').style.display = 'none';
	setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);	
}




