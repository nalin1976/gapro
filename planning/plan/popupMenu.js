// JavaScript Document

var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;
var chgTeamId=0;
var mealHrs=0;


function createXMLHttpRequestPopUp(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function closeWindow()
{
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


/*function createSplitQtyPopUp()
{
	showStripDetails();
	createXMLHttpRequestPopUp(0);
	xmlHttp[0].onreadystatechange = splitQtyPopUpRequest;
    xmlHttp[0].open("GET", 'splitQty.php', true);
    xmlHttp[0].send(null);
}*/

/*function splitQtyPopUpRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(408,228,'splitQtyPopUp',1000);
		
		document.getElementById('splitQtyPopUp').innerHTML=text;
		setQtyForTextBoxesInSplitPopUp();
		document.getElementById('txtSplitQty').focus();
		
	}
}
*/

function createSplitQtyPopUp()
{
		drawPopupAreaLayer(408,228,'splitQtyPopUp',1000);
		
		var text="<table width=\"407\" height=\"226\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
  "<tr class=\"cursercross\"  onmousedown=\"grab(document.getElementById('splitQtyPopUp'),event);\">"+
            "<td width=\"419\" height=\"41\" bgcolor=\"#498CC2\" class=\"mainHeading\">Split Quantity<img align=\"right\" onclick=\"closeWindow();\" id=\"butClose\" src=\"../../images/cross.png\"/></td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"88%\">"+
          "<table width=\"100%\" border=\"0\">"+
            "<tr>"+
              "<td height=\"110\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"\">"+
                "<tr>"+
                  "<td width=\"8%\" height=\"23\">&nbsp;</td>"+
				   "<td width=\"7%\" height=\"12\">&nbsp;</td>"+
                  "<td width=\"4%\" class=\"normalfnt\">&nbsp;</td>"+
                  "<td width=\"35%\" class=\"normalfnt\">Quantity</td>"+
                  "<td width=\"32%\" class=\"normalfnt\"><input type=\"text\" name=\"txtQty\" id=\"txtQty\" disabled=\"disabled\" style=\"text-align:right; background-color:#CCCCCC;\" size=\"10\" /></td>"+
                  "<td width=\"14%\">&nbsp;</td>"+
                "</tr>"+
                "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
				   "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">&nbsp;</td>"+
                  "<td class=\"normalfnt\" >Actual Qty</td>"+
                  "<td class=\"normalfnt\" ><input type=\"text\" name=\"txtProducedQty\" id=\"txtProducedQty\" style=\"text-align:right; background-color:#CCCCCC;\" disabled=\"disabled\" size=\"10\" /></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
           "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
				   "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">&nbsp;</td>"+
                  "<td class=\"normalfnt\" >Remaining Qty</td>"+
                  "<td class=\"normalfnt\" ><input type=\"text\" name=\"txtRestQty\" id=\"txtRestQty\" disabled=\"disabled\" style=\"text-align:right; background-color:#CCCCCC\"  size=\"10\" /></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
           "<tr>"+
             "<td height=\"12\">&nbsp;</td>"+
			  "<td height=\"12\">&nbsp;</td>"+
             "<td class=\"normalfnt\">&nbsp;</td>"+
             "<td class=\"normalfnt\" >SplitQty</td>"+
             "<td class=\"normalfnt\" ><input type=\"text\" id=\"txtSplitQty\" name=\"txtSplitQty\" style=\"text-align:right\" onkeyup=\"pressEnter(event);\" size=\"10\"  onkeypress=\"return isNumberKey(event);\" /></td>"+
             "<td>&nbsp;</td>"+
           "</tr>"+                               
              "</table></td>"+
            "</tr>"+
			"<td height=\"50\"><table width=\"100%\" height=\"50\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr>"+	
            "<td height=\"34\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
              "<tr>"+
			  
                "<td width=\"70%\" bgcolor=\"\"><table width=\"100%\" border=\"0\" class=\"tableFooter\">"+
                    "<tr>"+
                      "<td width=\"126\">&nbsp;</td>"+
                      "<td width=\"138\"><img src=\"../../images/ok.png\" class=\"mouseover\" alt=\"Save\" name=\"Save\" onclick=\"validateQty();\" /></td>"+
					  "<td width=\"113\">&nbsp;</td>"+
                    "</tr>"+
                "</table></td>"+
              "</tr>"+
            "</table></td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"+
       "</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
  "</tr>"+
"</table>";
		
		document.getElementById('splitQtyPopUp').innerHTML=text;
		setQtyForTextBoxesInSplitPopUp();
		document.getElementById('txtSplitQty').focus();
}

/*function createApplyLearningCurvePopUp()
{
	showStripDetails();
	//loadLearningCurveDetails();
	createXMLHttpRequestPopUp(0);
	xmlHttp[0].onreadystatechange = applyLearningCurvePopUpRequest;
    xmlHttp[0].open("GET", 'applyLearningCurve.php', true);
    xmlHttp[0].send(null);
}

function applyLearningCurvePopUpRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(621,351,'applyLearningCurvePopUp',1000);
		
		document.getElementById('applyLearningCurvePopUp').innerHTML=text;
		loadLearningCurveDetails();
		loadCurveDetailsInChart();
	}
}*/

function createApplyLearningCurvePopUp()
{
	drawPopupAreaLayer(621,351,'applyLearningCurvePopUp',1000);
	
	var text="<table width=\"600\" height=\"260\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
  "<tr class=\"cursercross\"  onmousedown=\"grab(document.getElementById('applyLearningCurvePopUp'),event);\">"+
            "<td height=\"35\" bgcolor=\"#498CC2\" class=\"mainHeading\">Apply Learning Curve</td>"+
          "</tr>"+
  "<tr>"+
    "<td><table width=\"88%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"88%\">"+
          "<table width=\"88%\" border=\"0\">"+

            "<tr>"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"\">"+
                "<tr>"+
                  "<td width=\"6%\" height=\"23\">&nbsp;</td>"+
                  "<td width=\"23%\" class=\"normalfnt\"><label></label></td>"+
                  "<td width=\"12%\"><label></label>                    <span class=\"normalfnt\">Curve Id </span></td>"+
                  "<td width=\"25%\"><select style=\"width: 152px;\"  class=\"txtbox\" name=\"cbo_curveDet\" id=\"cbo_curveDet\" tabindex=\"1\" onchange=\"loadCurveDetailsInChart();\"></select></td>"+
                  "<td width=\"34%\">&nbsp;</td>"+
                "</tr>"+
				"<tr><td>&nbsp;</td></tr>"+
                "<tr>"+
                  "<td colspan=\"5\"><table width=\"609\" height=\"80\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">"+
                    "<tr>"+
                      "<td><div id=\"container1\" style=\"width:600px; height: 200px; margin: 0 auto\"></div></td>"+
                    "</tr>"+
                  "</table></td>"+
                  "</tr>"+
                
                "<tr>"+
                  "<td height=\"12\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">&nbsp;</td>"+
                  "<td >&nbsp;</td>"+
                  "<td class=\"normalfnt\" >&nbsp;</td>"+
                  "<td>&nbsp;</td>"+
                "</tr></div>"+
              "</table></td>"+
            "</tr>"+
			"<td height=\"50\"><table width=\"100%\" height=\"50\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr>"+
            "<td height=\"34\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
              "<tr>"+
                "<td width=\"100%\" bgcolor=\"\"><table width=\"100%\" border=\"0\" class=\"tableFooter\">"+
                    "<tr>"+
                      "<td width=\"116\">&nbsp;</td>"+
                      
                      "<td width=\"90\"></td>"+
                      "<td width=\"102\"><img src=\"../../images/Select.png\" class=\"mouseover\" alt=\"select\" name=\"select\" width=\"100\" height=\"24\" onclick=\"showCurveId1();\"  /></td>"+
                      "<td width=\"97\"><img src=\"../../images/close.png\" alt=\"Close\" name=\"Close\" width=\"97\" height=\"24\" border=\"0\" id=\"Close\" onclick=\"closeWindow();\"/></a></td>"+
                      "<td width=\"178\">&nbsp;</td>"+
                    "</tr>"+
                "</table></td>"+
              "</tr>"+
            "</table></td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"+
        "</form></td>"+
        
      "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
    
  "</tr>"+
"</table>";
	
	document.getElementById('applyLearningCurvePopUp').innerHTML=text;
	loadLearningCurveDetails();
	loadCurveDetailsInChart();
}


function loadCurveDetailsInChart()
{   

	  //showPleaseWait();
	//createXMLHttpRequestPopUp(0);
	var curveId	 				= document.getElementById('cbo_curveDet').value;
	if(curveId==0 || curveId=='')
		showChart1('');
	else if(curveId>0)
	{
		var url = "plan-db.php?id=createStrip&curveId="+curveId;
		var xmlhttp_obj   = $.ajax({url:url,async:false})
		var effi         = xmlhttp_obj.responseText;
		var arrEffi1 = effi.split(',');
		var arrEffi = new Array();
		//showChart(arrEffi);
		for(var j=0;j<arrEffi1.length-1;j++)
			arrEffi[j]=parseInt(arrEffi1[j]);
		showChart1(arrEffi);
	}
	//hidePleaseWait();
}

function showChart1(p)
{	
	
	var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container1',
					defaultSeriesType: 'column',
					margin: [ 20, 40, 60, 80]
				},
				title: {
					text: 'Learning Curve'
				},
				xAxis: {
					//categories: [effi],
					categories: [
						'1 day', 
						'2 day', 
						'3 day', 
						'4 day', 
						'5 day',
						'6 day',
						'7 day',
						'8 day',
						'9 day',
						'10 day'
					],
					labels: {
						rotation: -45,
						align: 'right',
						style: {
							 font: 'normal 13px Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Efficency'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					formatter: function() {
						return '<b>'+ this.x +'</b><br/>'+
							 'Efficency: '+ Highcharts.numberFormat(this.y, 1) +
							 ' %';
					}
				},
			        series: [{
					name: 'Efficency',
					
					//data: [10, 20,30, 40, 50, 60, 60,60, 60,  60],
					data: [p[0],p[1],p[2],p[3],p[4],p[5],p[6],p[7],p[8],p[9]],
					//data:[p.toString],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						x: -3,
						y: 10,
						formatter: function() {
							return this.y;
						},
						style: {
							font: 'normal 13px Verdana, sans-serif'
						}
					}			
				}]
			});
			
			
		});

}

function createJoinStripPopUp()
{
	//showStripDetails();
	//loadLearningCurveDetails();
	document.getElementById('menudiv').style.display = "none" ;
	createXMLHttpRequestPopUp(0);
	xmlHttp[0].onreadystatechange = joinStripPopUpRequest;
    xmlHttp[0].open("GET", 'stripJoin.php', true);
    xmlHttp[0].send(null);
}

function joinStripPopUpRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(412,245,'stripJoinPopUp',1000);
		
		document.getElementById('stripJoinPopUp').innerHTML=text;
		
		loadStripDetCombo();
	}
}

function createChangeTimePopUp(teamId,mealHours)
{
	chgTeamId=teamId;
	mealHrs=parseFloat(mealHours);
	createXMLHttpRequestPopUp(0);
	xmlHttp[0].onreadystatechange = createChangeTimePopUpRequest;
    xmlHttp[0].open("GET", 'changeTime.php', true);
    xmlHttp[0].send(null);
}

function createChangeTimePopUpRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(475,340,'changeTimePopUp',1000);
		
		document.getElementById('changeTimePopUp').innerHTML=text;
		loadDataIntoChangeWorkingTime();
	}
}

function loadDataIntoChangeWorkingTime()
{
		document.getElementById('span_teamNo').innerHTML=chgTeamId;
		document.getElementById('txt_newStartDate').value=document.getElementById('dayDate').innerHTML;
		document.getElementById('txt_newEndDate').value=document.getElementById('dayDate').innerHTML;
		var startHour;
		var startMin;
		var endHour;
		var endMin;
		
		var startTime1=document.getElementById('dayStartTime').innerHTML;
		if(startTime1.length>2)
		{
			var startTime= startTime1.split('.');
			startHour=startTime[0];
			startMin=startTime[1];
				if(startHour.length==1)
					startHour="0"+startHour;
				if(startMin.length==1)
					startMin=startMin+"0";
			
		}
		else
		{
			startHour=startTime1;
			if(startHour.length==1)
					startHour="0"+startHour;
			startMin="00";
		}
		
		var endTime1=document.getElementById('dayEndTime').innerHTML;
		//alert(endTime1);
		if(endTime1.length>2)
		{
			var endTime= endTime1.split('.');
			endHour=endTime[0];
			endMin=endTime[1];
			
				if(endHour.length==1)
					endHour="0"+endHour;
				if(endMin.length==1)
					endMin=endMin+"0";
			
		}
		else
		{
			endHour=endTime1;
			if(endHour.length==1)
					endHour="0"+endHour;
			endMin="00";
		}
		//var startTime= startTime1.split('.');
		document.getElementById('txt_newStartTimeH').value=startHour;
		document.getElementById('txt_newStartTimeM').value=startMin;
		
		document.getElementById('txt_newEndTimeH').value=endHour;
		document.getElementById('txt_newEndTimeM').value=endMin;
		
		document.getElementById('txt_newWorkingHours').value=document.getElementById('dayWorkingHours').innerHTML;
		document.getElementById('txt_teamEfficiency').value=document.getElementById('dayEfficency').innerHTML;
		document.getElementById('txt_noOfMachines').value=document.getElementById('dayMachines').innerHTML;
		
		
}


function enableTimeTextBoxes(obj)
{
	if(obj.checked)
	{
		document.getElementById('txt_newStartTimeH').disabled=false;
		document.getElementById('txt_newStartTimeM').disabled=false;
		document.getElementById('txt_newEndTimeH').disabled=false;
		document.getElementById('txt_newEndTimeM').disabled=false;
		//document.getElementById('txt_MealHours').disabled=false;
		//$('#chk_newEndTime').attr('checked',true);
	}
	else
	{
		document.getElementById('txt_newStartTimeH').disabled=true;
		document.getElementById('txt_newStartTimeM').disabled=true;
		document.getElementById('txt_newEndTimeH').disabled=true;
		document.getElementById('txt_newEndTimeM').disabled=true;
		//document.getElementById('txt_MealHours').disabled=true;
		
		document.getElementById('txt_newStartTimeH').value="00";
		document.getElementById('txt_newStartTimeM').value="00";
		document.getElementById('txt_newEndTimeH').value="00";
		document.getElementById('txt_newEndTimeM').value="00";
		//document.getElementById('txt_MealHours').value=0;
		document.getElementById('txt_newWorkingHours').value='';
		
	}
	enableDayTypes();
	
}

function enableEfficiencyTextBox(obj)
{
	if(obj.checked)
		document.getElementById('txt_teamEfficiency').disabled=false;
	else
	{
		document.getElementById('txt_teamEfficiency').disabled=true;
		document.getElementById('txt_teamEfficiency').value='';
	}
	
	enableDayTypes();
}

function enableNoMachinesTextBox(obj)
{
	if(obj.checked)
		document.getElementById('txt_noOfMachines').disabled=false;
	else
	{
		document.getElementById('txt_noOfMachines').disabled=true;
		document.getElementById('txt_noOfMachines').value='';
	}
	enableDayTypes();
}

function enableDayTypes()
{
	if((document.getElementById('chk_newStartTime').checked==true)||(document.getElementById('chk_teamEfficiency').checked==true)||(document.getElementById('chk_noOfMachines').checked==true))
	{
		document.getElementById('cbo_dayType').disabled=false;
		document.getElementById('chk_updateAllTeams').disabled=false;
	}
	else
	{
		document.getElementById('cbo_dayType').disabled=true;
		document.getElementById('chk_updateAllTeams').disabled=true;
	}
}


function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

      return true;
}
	
function checkTime(obj)
{
	if(obj.value.length==1)
		obj.value="0"+obj.value;
	if(obj.value.length==0)
		obj.value="00";
}

function calculateNewWorkingHours()
{
	var sH=document.getElementById('txt_newStartTimeH').value;
	var sM=document.getElementById('txt_newStartTimeM').value;
	var mH=parseFloat(mealHrs);
	/*if(document.getElementById('txt_MealHours').value=='')
		var mH=0;
	else
		var mH=parseFloat(document.getElementById('txt_MealHours').value);*/
	
	if(parseFloat(sM)>60 || sM<0)
	{
		alert("Incorrect Time");
		sM=0;
		document.getElementById('txt_newStartTimeM').value="00";
	}
	
	if(parseFloat(sH)>24 || sH<0)
	{
		alert("Incorrect Time");
		sH=0;
		document.getElementById('txt_newStartTimeH').value="00";
	}
	
	var sT=parseFloat(sH)+'.'+parseFloat(sM);
	
	var eH=document.getElementById('txt_newEndTimeH').value;
	var eM=document.getElementById('txt_newEndTimeM').value;
	
	if(parseFloat(eM)>60 || eM<0)
	{
		alert("Incorrect Time");
		eM=0;
		document.getElementById('txt_newEndTimeM').value="00";
	}
	
	if(parseFloat(eH)>24 || eH<0)
	{
		alert("Incorrect Time");
		eH=0;
		document.getElementById('txt_newEndTimeH').value="00";
	}
	
	var eT=parseFloat(eH)+'.'+parseFloat(eM);
	
	var wT1=parseFloat(eT)-parseFloat(sT)-parseFloat(mH);
	//alert(parseFloat(mH));
	//var wT=round(wT1,2);
	document.getElementById('txt_newWorkingHours').value=wT1.toFixed(2);
}

function validateData(companyId)
{
	var chkTime=0;
	var chkEffi=0;
	var chkMach=0;
	
	if(document.getElementById('chk_newStartTime').checked==true)
		chkTime=1;
	else
		chkTime=0;
	if(document.getElementById('chk_teamEfficiency').checked==true)
		chkEffi=1;
	else
		chkEffi=0;
	if(document.getElementById('chk_noOfMachines').checked==true)
		chkMach=1;
	else
		chkMach=0;
	if(chkTime==1 || chkEffi==1 || chkMach==1)
	{
		if(document.getElementById('txt_newStartDate').value>document.getElementById('txt_newEndDate').value)
			alert("End Date is smaller");
		/*else if(document.getElementById('txt_newStartTimeH').value=="00" && document.getElementById('txt_newStartTimeM').value=="00" && chkTime==1)
			alert("Please Enter Start Time");
		else if(document.getElementById('txt_newEndTimeH').value=="00" && document.getElementById('txt_newEndTimeM').value=="00" && chkTime==1)
			alert("Please Enter End Time");*/
		else if(document.getElementById('txt_newWorkingHours').value<0)
		{
			alert("Start Time is greater than End Time.Please Enter Correctly");
			document.getElementById('txt_newStartTimeH').value="00";
			document.getElementById('txt_newStartTimeM').value="00";
			document.getElementById('txt_newEndTimeH').value="00";
			document.getElementById('txt_newEndTimeM').value="00";
			document.getElementById('txt_newWorkingHours').value="";
		}
		else if((document.getElementById('txt_teamEfficiency').value=='' || document.getElementById('txt_teamEfficiency').value==0) && chkEffi==1)
			alert("Enter Team Efficience ");
		else if((document.getElementById('txt_noOfMachines').value=='' || document.getElementById('txt_noOfMachines').value==0) && chkMach==1)
			alert("Enter No of Machines");
		else if(document.getElementById('cbo_dayType').value=="" )
			alert("Please Select Day Type");
		else
			saveTimeChanges(companyId,chkTime,chkEffi,chkMach);
	}
	else
		alert("Please Check a check box");
}

function saveTimeChanges(companyId,chkTime,chkEffi,chkMach)
{
	
	var chg_startDate=document.getElementById('txt_newStartDate').value;
	var chg_endDate=document.getElementById('txt_newEndDate').value;
	
	var chgCount=chkExistStripes(chgTeamId,chg_startDate,chg_endDate);
	if(chgCount==1)
	{
		alert("Planning Data Available.\nPlease Specify a Different Date Range");
	}
	else
	{
		/*var mealHours=document.getElementById('txt_MealHours').value;
		if(mealHours=='')
			mealHours=0;*/
		var htmlobj;
		
		if(chkTime==1)
		{
			var sH=document.getElementById('txt_newStartTimeH').value;
			var sM=document.getElementById('txt_newStartTimeM').value;
			var sT=parseFloat(sH)+'.'+parseFloat(sM);
			
			var eH=document.getElementById('txt_newEndTimeH').value;
			var eM=document.getElementById('txt_newEndTimeM').value;
			var eT=parseFloat(eH)+'.'+parseFloat(eM);
			
			var wH=document.getElementById('txt_newWorkingHours').value;
		}
		
		var sDate=document.getElementById('txt_newStartDate').value;
		var eDate=document.getElementById('txt_newEndDate').value;
		
		if(chkEffi==1)
			var teamEfficiency=document.getElementById('txt_teamEfficiency').value;
			
		if(chkMach==1)
			var noOfMachines=document.getElementById('txt_noOfMachines').value;
			
		var dayType=document.getElementById('cbo_dayType').value;
		
		if(document.getElementById('chk_updateAllTeams').checked)
			var chkAll=1;
		else
			var chkAll=0;
			
			var url="plan-db.php?id=changeDayProperty&teamId="+chgTeamId;
					url+="&sDate="+sDate;
					url+="&eDate="+eDate;
			if(chkTime==1 && chkEffi==1 && chkMach==1)
			{
				
				url+="&startTime="+sT;
				url+="&endTime="+eT;
				url+="&sworkingHours="+wH;
				url+="&dayType="+dayType;
				url+="&teamEfficiency="+teamEfficiency;
				url+="&noOfMachines="+noOfMachines;
				
			}
			else if(chkTime==0 && chkEffi==1 && chkMach==0)
			{
					url+="&dayType="+dayType;
					url+="&teamEfficiency="+teamEfficiency;	
			}
			else if(chkTime==0 && chkEffi==0 && chkMach==1)
			{
					url+="&dayType="+dayType;
					url+="&noOfMachines="+noOfMachines;
			}
			else if(chkTime==1 && chkEffi==0 && chkMach==0)
			{
					url+="&startTime="+sT;
					url+="&endTime="+eT;
					url+="&sworkingHours="+wH;
					url+="&dayType="+dayType;	
			}
			else if(chkTime==0 && chkEffi==1 && chkMach==1)
			{
					url+="&dayType="+dayType;
					url+="&teamEfficiency="+teamEfficiency;
					url+="&noOfMachines="+noOfMachines;
			}
			else if(chkTime==1 && chkEffi==0 && chkMach==1)
			{
					url+="&startTime="+sT;
					url+="&endTime="+eT;
					url+="&sworkingHours="+wH;
					url+="&dayType="+dayType;
					url+="&noOfMachines="+noOfMachines;
			}
			else if(chkTime==1 && chkEffi==1 && chkMach==0)
			{
					url+="&startTime="+sT;
					url+="&endTime="+eT;
					url+="&sworkingHours="+wH;
					url+="&dayType="+dayType;
					url+="&teamEfficiency="+teamEfficiency;
						
			}
			url+="&chkAll="+chkAll;
			url+="&actTime="+chkTime;
			url+="&actEffi="+chkEffi;
			url+="&actMach="+chkMach;
			url+="&companyId="+companyId;
				
			htmlobj=$.ajax({url:url,async:false});
			alert(htmlobj.responseText);
			
			updateArrayCalander(chgTeamId,chkAll,chkTime,chkEffi,chkMach);
	}
}

function createEventSchedule()
{
//showStripDetails();
	//loadLearningCurveDetails();
	document.getElementById('menudiv').style.display = "none" ;
	createXMLHttpRequestPopUp(0);
	xmlHttp[0].onreadystatechange = eventSchedulePopUpRequest;
    xmlHttp[0].open("GET", 'eventSchedulePopUp.php', true);
    xmlHttp[0].send(null);
}

function eventSchedulePopUpRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		//closeWindow();
		drawPopupAreaLayer(467,243,'eventSchedulePopUp',1000);
		
		document.getElementById('eventSchedulePopUp').innerHTML=text;
	}
	
	//alert(orderStyleId);
}

function calanderClick(id)
{
	
  // alert(id);
  // var html = "<table><body><tr><td>hellw</td></tr></body></table>"
  drawPopupAreaLayer(250,100,'calanderPopUp',1000);
  var text ='<table cellspacing="0" border="0" cellpadding="10" bgcolor="#FFFFFF" height="100%" width="100%" id="popupWorkingHours"><tr><td class="normalfnt" width="10">Working Hours</td><td class="normalfnt"><input type="text" id="cboWorkingHour" name="cboWorkingHour" size="10" /></td></tr><tr><td width="10"><input type="text" name="hiddenId" id="hiddenId" style="visibility:hidden;" value="'+id+'" size="12"/></td><td width="25"><img src="../../images/ok.png" class="mouseover" alt="Save" name="Save" onClick="saveCalanderData();"/></td></tr></table>';
  document.getElementById('calanderPopUp').innerHTML = text;
  
}  


// change Team Parameters   

function showTeamParameter()
{
	drawPopupAreaLayer(408,228,'teamParameterPopUp',1000);
	var popup="<table width=\"407\" height=\"226\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
  "<tr class=\"cursercross\"  onmousedown=\"grab(document.getElementById('teamParameterPopUp'),event);\">"+
            "<td width=\"419\" height=\"41\" bgcolor=\"#498CC2\" class=\"mainHeading\">Change Team Parameters<img align=\"right\" onclick=\"closeWindow();\" id=\"butClose\" src=\"../../images/cross.png\"/></td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"88%\">"+
          "<table width=\"100%\" border=\"0\">"+
            "<tr>"+
              "<td height=\"110\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"\">"+
                "<tr>"+
                  "<td width=\"8%\" height=\"23\">&nbsp;</td>"+
				   "<td width=\"7%\" height=\"12\">&nbsp;</td>"+
                  "<td width=\"4%\" class=\"normalfnt\">&nbsp;</td>"+
                  "<td width=\"35%\" class=\"normalfnt\">Team Efficiency</td>"+
                  "<td width=\"32%\" class=\"normalfnt\"><input type=\"text\" name=\"txtTeamEff\" id=\"txtTeamEff\"  size=\"10\" /></td>"+
                  "<td width=\"14%\">&nbsp;</td>"+
                "</tr>"+
                "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
				   "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">&nbsp;</td>"+
                  "<td class=\"normalfnt\" >No Of Machines</td>"+
                  "<td class=\"normalfnt\" ><input type=\"text\" name=\"txtMachine\" id=\"txtMachine\" size=\"10\" /></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
           "<tr>"+
                  "<td height=\"25\">&nbsp;</td>"+
				   "<td height=\"25\">&nbsp;</td>"+
                  "<td class=\"normalfnt\">&nbsp;</td>"+
                  "<td class=\"normalfnt\" >Operators</td>"+
                  "<td class=\"normalfnt\" ><input type=\"text\" name=\"txtTeamOperator\" id=\"txtTeamOperator\" size=\"10\" /></td>"+
                  "<td>&nbsp;</td>"+
                "</tr>"+
                                        
              "</table></td>"+
            "</tr>"+
			"<td height=\"50\"><table width=\"100%\" height=\"50\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr>"+	
            "<td height=\"34\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
              "<tr>"+
			  
                "<td width=\"70%\" bgcolor=\"\"><table width=\"100%\" border=\"0\" class=\"tableFooter\">"+
                    "<tr>"+
                      "<td width=\"126\">&nbsp;</td>"+
                      "<td width=\"138\"><img src='../../images/save.png' alt='report' name='butSave' width='84' height='24' class='mouseover' id='butSave' onclick='saveChangeParameters();' /></td>"+
					  "<td width=\"113\"><img src='../../images/close.png' alt='close' name='butClose' width='97' height='24' border='0' class='mouseover' id='butClose' onclick='closeWindow();' /></td>"+
					  "<td width=\"126\">&nbsp;</td>"+
                    "</tr>"+
                "</table></td>"+
              "</tr>"+
            "</table></td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"+
       "</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
  "</tr>"+
"</table>";
	document.getElementById('teamParameterPopUp').innerHTML = popup;
	loadInitialTeamDetail();
}