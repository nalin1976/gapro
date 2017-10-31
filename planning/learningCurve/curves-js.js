

// JavaScript Document
var xmlHttp 		= [];
var xmlHttp1;
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;

var pub_intxmlHttp_count=0;

function createXMLHttpRequestCurve(index) 
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

/*function closeWindow()
{
	alert($("#cboCurve option:selected").text());
	closeWindow1();
}*/

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

function pageSubmitOrderBook()
{
	document.getElementById('frmCurve').submit();	
}
function refreshWindowOrderBook()
{
	createXMLHttpRequestCurve(0);
    xmlHttp[0].onreadystatechange = learningCurveRequest;
    xmlHttp[0].open("GET", '../learningCurve/curves.php', true);
    xmlHttp[0].send(null); 
}

function loadLearningCurve()
{
	  showPleaseWait();
	createXMLHttpRequestCurve(0);
    xmlHttp[0].onreadystatechange = learningCurveRequest;
    xmlHttp[0].open("GET", '../learningCurve/curves.php', true);
    xmlHttp[0].send(null); 
}
function learningCurveRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		closeWindow();
		drawPopupAreaLayer(625,480,'frmCurve',1000);
		
		document.getElementById('frmCurve').innerHTML=text;
		document.getElementById('cboCurve').value= '1';
		document.getElementById('cboCurve').onchange();
		hidePleaseWait();//showChart();
	}
}

function showChart(p)
{	
	
	var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
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

function loadCurveDetails()
{   
/*    if(document.getElementById('divNewCurve').style.display == 'block'){
		document.getElementById('divNewCurve').style.display = 'none';
		document.get
		ElementById('newCurveId').value = "";
	}*/
	  showPleaseWait();
	createXMLHttpRequestCurve(0);
	var curveId	 				= document.getElementById('cboCurve').value;
	
	//alert(curveId);
	document.getElementById('tblCurveId').style.visibility = 'hidden';
	if(curveId=='')
	{
		showChart('');
		
			document.getElementById('tblCurveId').style.visibility = 'visible';
	
		var iHtml = "	<table align=\"center\" width=\"400\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" class=\"normalfnt\" id=\"tblCurve\" border=\"0\">"+
				"	<tr>"+
				"	<td height=\"10\" colspan=\"4\" class=\"backcolorGreen\" align=\"center\"><b>Curve List</b></td>"+
				"	</tr>"+
                "   <tr>"+
                "   <td width=\"60\" class=\"grid_raw\"><b>Del</b></td>"+
                "   <td width=\"171\"  class=\"grid_raw\"><b>Day No</b> </td>  "+
                "   <td width=\"167\" class=\"grid_raw\"><b>Efficiency</b></td>"+
                "   </tr>"+
                "   <tr>"+
                "   <td align=\"center\" valign=\"middle\" class=\"normalfntMid\"><div align=\"center\"><img onclick=\"removeRow2(this);\"  src=\"../../images/del.png\" /></div></td>"+
                "   <td class=\"normalfntMid\" align=\"center\">1</td>"+
				"	<td onclick=\"loadTextBox(this);\" class=\"normalfntMid\" align=\"center\"></td>"+
                "   </tr>"+
                "   </table>";
	document.getElementById('divCurve').innerHTML = iHtml;
	
	document.getElementById('newCurveId').focus();
		hidePleaseWait();
		
		
		return;	
	}
    xmlHttp[0].onreadystatechange 	= leaningCurveDetailsRequest;
    xmlHttp[0].open("GET", '../learningCurve/curves-xml.php?id=curveDetails&curveId='+curveId, true);
    xmlHttp[0].send(null);
	
	//showCurveId(curveId);
}

function leaningCurveDetailsRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
			var text = xmlHttp[0].responseText;
			document.getElementById('divCurve').innerHTML = text;
			var tblCurve = document.getElementById("tblCurve");			
			var rows 	 = tblCurve.rows.length;
			var effi= new Array();
			//alert(effi);
			for(var i=2;i<rows;i++)
			{
					effi[i-2] =  parseInt(tblCurve.rows[i].cells[2].childNodes[0].nodeValue) ;	
			}
			showChart(effi);
	}

			   
			   hidePleaseWait();
}

function loadTextBox(obj){


 var efficiency = obj.innerHTML;
 var rowId = obj.parentNode.rowIndex;

 if(document.getElementById('efficiency'+rowId)==null){
  obj.innerHTML = "<input onKeyPress=\"return enter(event,this)\" onblur='removeTextbox(this);'  name='efficiency"+rowId+"' id='efficiency"+rowId+"' type='text' size='5' ></input>";
  document.getElementById('efficiency'+rowId).value = efficiency;
  document.getElementById('efficiency'+rowId).focus();
 }
}

function removeTextbox(obj)
{
	var value = obj.value;
	if(value=='')
		obj.parentNode.innerHTML = 0;
	else
		obj.parentNode.innerHTML = value;

/*var tblCurve = document.getElementById("tblCurve");
var efficiency = obj.value;
if(efficiency != "")

{
var rowId = obj.parentNode.parentNode.rowIndex;
obj.parentNode.innerHTML = efficiency;
  var tblMain =  document.getElementById('tblCurve');	
   var lastRow = tblMain.rows.length;

   document.getElementById("two"+(lastRow-2)+"").focus();
   
}*/
//obj.parentNode.id = 0;	
 
}


function removeRow(objDel)
{
	//alert(objDel.parentNode.rowIndex);
	var tbl = document.getElementById('tblCurve');
	var rowNo = objDel.parentNode.rowIndex;
	if(tbl.rows.length > 4){
		tbl.deleteRow(rowNo);	
	}
	
	//bookmark1
	resetDayNo();
}

function removeRow2(objDel)
{
	//alert(objDel.parentNode.rowIndex);
	var tbl = document.getElementById('tblCurve');
	var rowNo = objDel.parentNode.parentNode.parentNode.rowIndex;
	if(tbl.rows.length >= 4){
		tbl.deleteRow(rowNo);	
	}
	
	//bookmark1
	resetDayNo();
}






function saveCurve(){

	var tbl = document.getElementById("tblCurve");
	var curveId = document.getElementById("cboCurve").value;
	var curveName = '';	
	var curveValue=0;
	var daynum=0;
	
	if(document.getElementById('newCurveId').value!='')
	{
		curveName = document.getElementById('newCurveId').value;
	}
	else
	{	
		if(document.getElementById("cboCurve").options[document.getElementById("cboCurve").selectedIndex].text=='')
			alert("Please Enter Curve Name");
		else
			curveName = document.getElementById("cboCurve").options[document.getElementById("cboCurve").selectedIndex].text;
	}
	
	var arrEff ='';
	var count = tbl.rows.length;
	
	for(var i=2;i<count;i++)
	{
		var row = tbl.rows[i];
		if(row.cells[2].childNodes[0].nodeValue==0)
		{
			curveValue=1;
			dayNum=row.cells[1].childNodes[0].nodeValue;
			//alert(dayNum);
			break;
		}
		arrEff += row.cells[2].childNodes[0].nodeValue + ",";
	}
	if(curveValue==1)
		alert("Please Enter Efficiency to Day "+dayNum+"!");
	else
	{
		var urlDetails="/gapro/planning/learningCurve/curve-db.php?id=saveCurve&values="+arrEff+"&curveId="+curveId+"&curveName="+curveName;
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		loadLearningCurve();
	}

}

function saveCurveRequest(){
var tblCurve = document.getElementById("tblCurve");
var count = tblCurve.rows.length;
//alert(count);
    if((xmlHttp[this.index].readyState == 4) && (xmlHttp[this.index].status == 200)) 
    {     
			if(xmlHttp[this.index].index == (count-3)){
			var intNo =xmlHttp[this.index].responseText;
	
			var cboCurve = document.getElementById("cboCurve").value;
			if(document.getElementById("cboCurve").value == ""){
				var cboCurve = document.getElementById("newCurveId").value;
			}
//alert(intNo);
				if (intNo == 1)
				{
				 alert("Learning Curve " + cboCurve + " Saved successfully !");				 
				}
			
			else{
				alert("Saving Error");
			}
			var key1='y';
			loadCurveDetails();
		  }
	}
}

function newRow(){	

	document.getElementById('cboCurve').value= '';
	document.getElementById('cboCurve').onchange();
	document.getElementById('newCurveId').value=''
}

function removeAllRows()
{
 var tblMain =  document.getElementById('tblCurve');	
 var lastRow = tblMain.rows.length;
 
  for (i = lastRow-1; i != 0; i--) 
  {
   tblMain.deleteRow(i);
  } 
  var row = tblMain.insertRow(1);
  row.className="bcgcolor-tblrowWhite";
  
  tblMain.rows[1].innerHTML=  "<td  class=\"grid_raw\"><b>Del</b></td>"+
                              "<td  class=\"grid_raw\"><b>Day No</b></td>"+
							  "<td width=\"250\" class=\"grid_raw\"><b>Efficiency</b></td>";
							  
  var row2 = tblMain.insertRow(2);
  var lastRow = tblMain.rows.length;
  
  row2.className="bcgcolor-tblrowWhite";							  
  tblMain.rows[2].innerHTML="<td align=\"center\" valign=\"middle\" class=\"normalfntMid\" onclick=\"removeRow(this);\"><div align=\"center\"><img  src=\"../../images/del.png\" /></div></td>"+
              "<td bgcolor=\"\" class=\"normalfntMid\">"+(parseInt(lastRow)-2)+"</td>"+
			"<td  class=\"normalfntMid\" onclick=\"loadTextBox(this);\"><input type=\"text\" id=\"one\" size=\"5\" onKeyPress=\"return enter(event,this)\"           onblur=\"removeTextbox(this);\" /></td>";
							 
 document.getElementById('newCurveId').focus(); 							 
  var row3 = tblMain.insertRow(3);
  row3.className="bcgcolor-tblrowWhite";								 
  tblMain.rows[3].innerHTML="<td bgcolor=\"\" class=\"\"  align=\"center\"><div align=\"center\"><img  src=\"../../images/addnew2.png\" onclick=\"anotherLine();\"/></div></td>";	

}

function anotherLine(id){
	
	
  	var tblMain =  document.getElementById('tblCurve');	
  	var lastRow = tblMain.rows.length -1 ;
	
  	if(id != lastRow)
   	  return;
	 
	 //bookmark2
	var newRow = tblMain.insertRow(lastRow+1);
	newRow.innerHTML = "   <td align=\"center\" valign=\"middle\" class=\"normalfntMid\"><div align=\"center\"><img onclick=\"removeRow2(this);\"   src=\"../../images/del.png\" /></div></td>"+
                "   <td class=\"normalfntMid\" align=\"center\">"+lastRow+"</td>"+
				"	<td onclick=\"loadTextBox(this);\" class=\"normalfntMid\" align=\"center\"><input id=\"C"+lastRow+"\" onKeyPress=\"return enter(event,this)\" onblur=\"removeTextbox(this);\" name=\"textfield\" type=\"text\" size=\"10\" /></td>";
	document.getElementById('C'+lastRow).focus();
	resetDayNo();
   //var day =  tblMain.rows[lastRow-2].cells[1].lastChild.nodeValue;	
   //var day1 = (day*1) + (1*1);

	/*  
	
	var row2 = tblMain.insertRow(lastRow-1);
	  row2.className="bcgcolor-tblrowWhite";							  
	  tblMain.rows[lastRow].innerHTML="<td align=\"center\" valign=\"middle\" class=\"normalfntMid\" onclick=\"removeRow(this);\"><div align=\"center\"><img  src=\"../../images/del.png\" /></div></td>"+
					"<td class=\"normalfntMid\"align=\"center\">"+day1+"</td>"+
					"<td class=\"normalfntMid\" onclick=\"loadTextBox(this);\"><input type=\"text\" id=\"two"+(lastRow-1)+"\" size=\"5\"         							                onKeyPress=\"return enter(event,this)\" onblur=\"removeTextbox(this);\" /></td>";
	document.getElementById("two"+(lastRow)+"").focus();
	
	*/
}



function resetDayNo()
{
	var tbl = document.getElementById('tblCurve');
	var count = tbl.rows.length;
	for(var i=2;i<count-1;i++)
	{
		var row = tbl.rows[i];
		row.cells[1].childNodes[0].nodeValue = i-1;
	}
}


function deleteCurveId(){
	
	var cboCurve	    = document.getElementById("cboCurve").value;
	if(cboCurve == ""){
	 alert("Plese Select Curve Id to Delete");	
	 document.getElementById("cboCurve").focus();
	 return false;
	}
	
	 createXMLHttpRequestCurve(0);
	 xmlHttp[0].onreadystatechange = deleteCurveIDRequest;
	 var url  = "../learningCurve/curve-db.php?id=deleteCurve";
		url += "&cboCurve="+cboCurve;
		
	 xmlHttp[0].open("GET",url,true);
	 xmlHttp[0].send(null);
	 
	/*var urlDetails="/gapro/planning/learningCurve/curve-db.php?id=deleteCurve&&cboCurve="+cboCurve;
	htmlobj=$.ajax({url:urlDetails,async:false});
	alert(htmlobj.responseText)*/
	 
	 return true;
}

function deleteCurveIDRequest(){

		if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200 ) 
		{
			var delete1 = trim(xmlHttp[0].responseText);
			if(delete1!="Saving-Error")
			{
				alert(""+ $("#cboCurve option:selected").text() +"  Deleted Successfully");
				document.getElementById("cboCurve").value = "";
                loadLearningCurve();
				
			}
			else
			{
				alert("Error : \nLearning Curves Not Deleted");
				return;
			}
		}
}

  function enter(e,obj)
  {
   evt = e || window.event;
  
   if(evt && evt.keyCode == 13)
   {

    anotherLine(obj.parentNode.parentNode.rowIndex);

    return false; 
   }
   else
    return true; 
  }
  
  function enterNewCurveId(e)
  {
   evt = e || window.event;
   if(evt && evt.keyCode == 13)
   {

    document.getElementById("one").focus();

    return false; 
   }
   else
    return true; 
  }
  


