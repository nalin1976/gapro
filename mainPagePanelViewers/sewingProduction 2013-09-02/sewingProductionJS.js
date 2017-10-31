function setSewingProductionPanel()
{//alert("setSewingProductionPanel");
	loadFactory();
	loadLineNo()
	
}

function loadFactory()
{
	document.getElementById('cmbSrchFacPD').innerHTML = "<option value=''>Loading</option>";
	var url = "mainPagePanelViewers/sewingProduction/sewingProductionDB.php?RequestType=loadFactory";
		htmlobj=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		document.getElementById('cmbSrchFacPD').innerHTML = htmlobj.responseText;	
}
function loadLineNo()
{
	document.getElementById('cmbSrchLinePD').innerHTML = "<option value=''>Loading</option>";
	var url = "mainPagePanelViewers/sewingProduction/sewingProductionDB.php?RequestType=loadLineNo";
		htmlobj=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		document.getElementById('cmbSrchLinePD').innerHTML = htmlobj.responseText;	
}


function searchDataPD()
{//alert("searchDataPD");
	document.getElementById('mainGridDataDivPD').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
															   "<tr><td align='center'>"+
															   "<img src='images/loadingimg.gif'/></td>"+
															   "</tr></table>";
	
	document.getElementById('graphicDivPD').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
														   "<tr><td align='center'>"+
														   "<img src='images/loadingimg.gif'/></td>"+
														   "</tr></table>";													   
	var srchFactory = document.getElementById('cmbSrchFacPD').value;
	var lineNo 		= document.getElementById('cmbSrchLinePD').value;
	var tagetDate 	= document.getElementById('txtSrchDatePD').value;
	
	var url = "mainPagePanelViewers/sewingProduction/sewingProductionDB.php?RequestType=searchDataPD";
		url +="&srchFactory="+srchFactory;
		url +="&lineNo="+lineNo;
		url +="&tagetDate="+tagetDate;
		htmlobjGrid=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		loadBarChart();
		document.getElementById('mainGridDataDivPD').innerHTML = htmlobjGrid.responseText;
				
}

function loadBarChart()
{//alert("loadBarChart"); //graphicDivPD
	document.getElementById('graphicDivPD').innerHTML = "<table width='100%' height='100%' id='evtScheduleDetails'>"+
														   "<tr><td align='center'>"+
														   "<img src='images/loadingimg.gif'/></td>"+
														   "</tr></table>";
	var srchFactory = document.getElementById('cmbSrchFacPD').value;
	var lineNo 		= document.getElementById('cmbSrchLinePD').value;
	var tagetDate 	= document.getElementById('txtSrchDatePD').value;
	
	var url = "mainPagePanelViewers/sewingProduction/sewingProductionDB.php?RequestType=loadBarChart";
		url +="&srchFactory="+srchFactory;
		url +="&lineNo="+lineNo;
		url +="&tagetDate="+tagetDate;
		htmlobj=$.ajax({url:url,async:false});//alert(url);
		
		//alert(htmlobj.responseText);
		document.getElementById('graphicDivPD').innerHTML = "<div id=\"chartProduction\" style=\"width: 640px; height: 260px;\"></div>";
		setChart(htmlobj.responseXML);
}
		
function setChart(xmlData)
{
	
	var XMLtarTime = xmlData.getElementsByTagName("tarTime");
	var XMLtarQty  = xmlData.getElementsByTagName("tarQty");
	var XMLactQty  = xmlData.getElementsByTagName("actQty");

	var dataSource = new Array();

	for (i=0;i<XMLtarTime.length;i++)
  	{
  	var tarTime = XMLtarTime[i].childNodes[0].nodeValue;
	var tarQty  = XMLtarQty[i].childNodes[0].nodeValue;
	var actQty  = XMLactQty[i].childNodes[0].nodeValue;
	
	var myArray = new Array();
		myArray["year"] 	= tarTime;
		
		myArray["europe"] 	= parseInt(tarQty);
		myArray["americas"] = parseInt(actQty);
		//myArray["africa"] 	= 20;
		
		dataSource.push(myArray);
  	}

/*for (var i in myArray) {
    alert('key is: ' + i + ', value is: ' + myArray[i]);
}*/

var chart = $("#chartProduction").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
		type: 'spline',
        argumentField: 'year'
    },
    series: [
        { valueField: 'europe', name: 'Europe' },
        { valueField: 'americas', name: 'Americas' },
        { valueField: 'africa', name: 'Africa' }
    ],
    argumentAxis:{
        grid:{
            visible: true
        }
    },
    tooltip:{
        enabled: true
    },
    title: '',
    legend: {
        verticalAlignment: 'bottom',
        horizontalAlignment: 'center'
    },
    commonPaneSettings: {
        border:{
            visible: true,
            right: false
        }       
    }
});
}