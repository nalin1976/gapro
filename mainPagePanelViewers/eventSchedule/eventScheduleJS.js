
function eventSchedulePanel()
{//alert("eventSchedulePanel");
	loadOrderNoEV();
	
}


function loadOrderNoEV()
{
	document.getElementById('cmbSrchOrderEV').innerHTML = "<option value=''>Loading</option>";
	var url = "mainPagePanelViewers/eventSchedule/eventScheduleDB.php?RequestType=loadOrderNoEV";
		htmlobj=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		document.getElementById('cmbSrchOrderEV').innerHTML = htmlobj.responseText;	
}

function loadDeilveryDateEV()
{
	document.getElementById('cmbSrchDeliDateEV').innerHTML = "<option value=''>Loading</option>";
	var url = "mainPagePanelViewers/eventSchedule/eventScheduleDB.php?RequestType=loadDeilveryDateEV";
		url +="&styleId="+document.getElementById('cmbSrchOrderEV').value;
		htmlobj=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		document.getElementById('cmbSrchDeliDateEV').innerHTML = htmlobj.responseText;	
}

function searchDataEV()
{
	var styleId 	 = document.getElementById('cmbSrchOrderEV').value;
	var deliveryDate = document.getElementById('cmbSrchDeliDateEV').value;
	
	document.getElementById('mainGridDataDivEV').innerHTML =   "<table width='100%' height='100%' id='evtScheduleDetails'>"+
															   "<tr><td align='center'>"+
															   "<img src='images/loadingimg.gif'/></td>"+
															   "</tr></table>";
	document.getElementById('graphicDivBarEV').innerHTML =   "<table width='100%' height='100%' id='evtScheduleDetails'>"+
															   "<tr><td align='center'>"+
															   "<img src='images/loadingimg.gif'/></td>"+
															   "</tr></table>";
	document.getElementById('graphicDivPieEV').innerHTML =   "<table width='100%' height='100%' id='evtScheduleDetails'>"+
															   "<tr><td align='center'>"+
															   "<img src='images/loadingimg.gif'/></td>"+
															   "</tr></table>";														   
	
	var url = "mainPagePanelViewers/eventSchedule/eventScheduleDB.php?RequestType=searchDataEV";
		url +="&styleId="+styleId;
		url +="&deliveryDate="+deliveryDate;
		htmlobj=$.ajax({url:url,async:false});//alert(htmlobj.responseText);
		document.getElementById('mainGridDataDivEV').innerHTML = htmlobj.responseText;
	document.getElementById('graphicDivBarEV').innerHTML = "<div id=\"chartBarEV\" style=\"width: 300px; height: 260px;\"></div>";
	document.getElementById('graphicDivPieEV').innerHTML = "<div id=\"chartPieEV\" style=\"width: 300px; height: 220px;\"></div>";	
setBarChartEV();
setPieChartEV();
}

function setBarChartEV()
{
	var noOfDelay 	   = document.getElementById('hdNoOfDelay').value;
	var noOfPending     = document.getElementById('hdNoOfPending').value;
	var noOfComplete 	= document.getElementById('hdNoOfComplete').value;
	var noOfSkip 		= document.getElementById('hdNoOfSkip').value;

var dataSource = new Array();
var myArray = new Array();
		myArray["state"] 	= "";		
		myArray["year1998"] = parseInt(noOfPending);
		myArray["year2001"] = parseInt(noOfDelay);
		myArray["year2004"] = parseInt(noOfComplete);
		myArray["year1988"] = parseInt(noOfSkip);
		//myArray["africa"] 	= 20;
		
		dataSource.push(myArray);	

var chart = $("#chartBarEV").dxChart({
    dataSource: dataSource,
	
    commonSeriesSettings: {
        argumentField: 'state',
        type: 'bar',
        hoverMode: 'allArgumentPoints',
        selectionMode: 'allArgumentPoints',
        label: {
            visible: true,
            format: "fixedPoint",
            precision: 0
        }
    },
    series: [
        { valueField: 'year2004', name: '2004' },
        { valueField: 'year2001', name: '2001' },
        { valueField: 'year1998', name: '1998' },
		{ valueField: 'year1988', name: '1988' }
    ],
   
    legend: {
        verticalAlignment: 'bottom',
        horizontalAlignment: 'center'
    },
    pointClick: function (point) {
        this.select();
    }
});
	
}

function setPieChartEV()
{
	var noOfDelay 	   = document.getElementById('hdNoOfDelay').value;
	var noOfPending     = document.getElementById('hdNoOfPending').value;
	var noOfComplete 	= document.getElementById('hdNoOfComplete').value;
	var noOfSkip 		= document.getElementById('hdNoOfSkip').value;
	
	 var dataSource = [
    { country: 'Complete', area: parseInt(noOfComplete) },
    { country: 'Delay', area: parseInt(noOfDelay) },
    { country: 'Pending', area: parseInt(noOfPending) },
    { country: 'Skip', area: parseInt(noOfSkip) }
];

var chart = $("#chartPieEV").dxPieChart({
    size:{ 
        width: 450
    },
    dataSource: dataSource,
	tooltip: {
		enabled: true,		
		percentPrecision: 2,
		customizeText: function() { 
			return this.valueText + ' - ' + this.percentText;
		}
	},
    series: [
        {
			type: 'doughnut',
            argumentField: 'country',
            valueField: 'area',
            label:{
                visible: true,
                connector:{
                    visible:true,           
                    width: 1
                }
            }
        }
    ]
	});

	
}