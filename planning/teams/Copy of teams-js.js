// JavaScript Document
var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;
function createXMLHttpRequestTeams(index) 
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

function pageSubmit()
{
	document.getElementById('frmTeam').submit();	
}
function refreshWindow()
{
	createXMLHttpRequestTeams(0);
    xmlHttp[0].onreadystatechange = teamWindowShowRequest;
    xmlHttp[0].open("GET", '../teams/teams.php', true);
    xmlHttp[0].send(null); 
}
//
function pageSubmit2(obj)
{
	showPleaseWait();
	createXMLHttpRequestTeams(0);
    xmlHttp[0].onreadystatechange = teamWindowShowRequest;
    xmlHttp[0].open("GET", '../teams/teams.php?cboTeam='+obj.value, true);
    xmlHttp[0].send(null); 
}
function loadTeamsWindow()
{
	showPleaseWait();
	createXMLHttpRequestTeams(0);
    xmlHttp[0].onreadystatechange = teamWindowShowRequest;
    xmlHttp[0].open("GET", '../teams/teams.php', true);
    xmlHttp[0].send(null); 
}
function teamWindowShowRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		closeWindow();
		drawPopupAreaLayer(530,338,'frmTeamWindow',10);
		document.getElementById('frmTeamWindow').innerHTML=text;
		hidePleaseWait();
	}
}

function dateValidate()
{
		var fromDate 	= new Date(document.getElementById('txtValidFrom').value);
		var toDate		= new Date(document.getElementById('txtValidTo').value);
		
		if((fromDate=='') || (toDate==''))
		{
			alert("Date is not selected !");	
		}
		if(fromDate>toDate)
		{
			alert('(To) date must greater than (From) date ! ');
			return false;
		}
		
		var tbl = document.getElementById('tblTeamsValidateGrid');
		var rows = tbl.rows.length;
		var check = false;
		for(var i=1;i<rows;i++)
		{
			var gfromDate 	= 	new Date(tbl.rows[i].cells[1].innerHTML);
			var gtoDate 	= 	new Date(tbl.rows[i].cells[2].innerHTML);
			
			if(gfromDate<=fromDate && gtoDate>=fromDate)
				check =true;
				
		}
		if(check)
		{
			alert('Valid date range is allready in the list. ')
			return false;
		}

		return true;
		
}

function addrowtovalidgrid()
{
	if(!dateValidate())
	{
		return;
	}
	var tbl = document.getElementById('tblTeamsValidateGrid');
	var validFrom = document.getElementById('txtValidFrom').value;
	var validTo  = document.getElementById('txtValidTo').value;
	var newRow = "<tr><td  valign=\"middle\" class=\"normalfntMid\"><img onclick=\"deleteValidRow(this)\" src=\"../../images/del.png\" name=\"butDel\" id=\"butDel\" />"+
							  "</td>"+
                              "<td class=\"normalfntMid\">"+validFrom+"</td>"+
							  "<td class=\"normalfntMid\">"+validTo+"</td>"+
							  "<td class=\"normalfntMid\"></td>"+
                            "</tr>";
							
	tbl.innerHTML = tbl.innerHTML + newRow;
}

function deleteValidRow(obj)
{
	var tbl = document.getElementById('tblTeamsValidateGrid');
	tbl.deleteRow(obj.parentNode.parentNode.rowIndex);
}

function validateTeam()
{
	var strTeam  			= document.getElementById('txtTeamName').value;
	if(strTeam=='')
	{
		alert("Please Enter Team Name!");
	}
	else
		saveTeams();
}

function saveTeams()
{
	
	showPleaseWait();
	//var tbl = document.getElementById('tblTeamsValidateGrid');
	
	var intTeamNo  			= document.getElementById('cboTeam').value;
	var strTeam  			= document.getElementById('txtTeamName').value;
	var intMachines  		= document.getElementById('txtNoOfMachines').value;
	var intEfficency  		= document.getElementById('txtTeamEfficiency').value;
	var intOperators  		= document.getElementById('txtOperators').value;
	var dblWorkingHours 	= document.getElementById('txtWorkingHours').value;
	var intSubTeamOf 		= document.getElementById('cboSubTeam').value;
	var intHelper  			= document.getElementById('txtHelpers').value;
	var dblStartTime  		= document.getElementById('txtFromTime').value;
	var dblEndTime  		= document.getElementById('txtToTime').value;
	
	
	if(document.getElementById('txtMealHrs').value=='')
		var dblMealHours = 0;
	else
		var dblMealHours=document.getElementById('txtMealHrs').value;
						
	createXMLHttpRequestTeams(0);
	var url = "../teams/teams-db.php?id=saveTeams";
		url+= "&intTeamNo="+intTeamNo+"";
		url+= "&strTeam="+strTeam+"";
		url+= "&intMachines="+intMachines+"";
		url+= "&intEfficency="+intEfficency+"";
		url+= "&intOperators="+intOperators+"";
		url+= "&dblWorkingHours="+dblWorkingHours+"";
		url+= "&intSubTeamOf="+intSubTeamOf+"";
		url+= "&intHelper="+intHelper+"";
		url+= "&dblStartTime="+dblStartTime+"";
		url+= "&dblEndTime="+dblEndTime+"";
		url+= "&dblMealHours="+dblMealHours+"";
		
    xmlHttp[0].onreadystatechange = saveTeamsRequest;
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 
	
	
}

function saveTeamsRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var id = xmlHttp[0].responseText;
		saveGridDetails(id);
		hidePleaseWait();
	}
}

function saveGridDetails(teamId)
{
	var tbl = document.getElementById('tblTeamsValidateGrid');
	var rows = tbl.rows.length;
	for(var i=1;i<rows;i++)
	{
		var fromDate 	= (tbl.rows[i].cells[1].innerHTML);
		var toDate		= (tbl.rows[i].cells[2].innerHTML);
		
		createXMLHttpRequestTeams(i);
		xmlHttp[i].onreadystatechange = dateValidateRequest;
		var url = "../teams/teams-db.php?id=saveTeamsValidateDataGrid";
			url += "&teamId="+teamId;
			url += "&fromDate="+fromDate;
			url += "&toDate="+toDate;
			
		xmlHttp[i].open("GET", url, true);
		xmlHttp[i].index = i;
		xmlHttp[i].send(null); 	
	}
}

function dateValidateRequest()
{
    if((xmlHttp[this.index].readyState == 4) && (xmlHttp[this.index].status == 200)) 
    {
		var text = xmlHttp[this.index].responseText;
		if(this.index ==1)	
		alert(text);
		refreshWindow();
	}
}

function deleteTeams()
{
	if(confirm('Are you sure delete this record?'))
	{
		var teamId = document.getElementById('cboTeam').value
		
		createXMLHttpRequestTeams(0);
		xmlHttp[0].onreadystatechange = deleteTeamsRequest;
		xmlHttp[0].open("GET", '../teams/teams-db.php?id=teamDelete&teamId='+teamId, true);
		xmlHttp[0].send(null); 
	}
}

function deleteTeamsRequest()
{
 if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		alert(text);
		refreshWindow();
	}	
}

function calculateWorkingHours()
{
	var fromTime = parseFloat(document.getElementById('txtFromTime').value);
	
	if(document.getElementById('txtMealHrs').value=='')
		var mealMin = 0;
	else
	{
		var mealTime = parseFloat(document.getElementById('txtMealHrs').value);
		var mealH	 = Math.floor(mealTime);
		
		var mealMin	 = (mealH * 60)+((mealTime-mealH)*100);
	}
		var H1 	= Math.floor(fromTime);
		var M1	= (H1 * 60)+((fromTime-H1)*100);
	
	
	var toTime = parseFloat(document.getElementById('txtToTime').value);
	var H2 	= Math.floor(toTime);
	var M2	= (H2 * 60)+((toTime-H2)*100);
	
	var M3 = (M2-M1)-mealMin;
	
	var H4 = Math.floor(M3/60);
	var H5 = (M3-(H4*60)).toFixed(0);
	if(H5.length==1)
		H5 = '0'+H5;
		
	var T = H4+"."+H5;
	
	
/*	var varTime = toTime - fromTime;
	if(isNaN(varTime) || (varTime<0))
		varTime = 0;
	*/
	document.getElementById('txtWorkingHours').value = T;
}

function checkValidMainTeam(obj)
{
	var mainTeam = document.getElementById('cboTeam').value;
	if((mainTeam==obj.value)&& (obj.value)!=0)
	{
		alert("Please select a valid sub team");
		obj.value = 0;
	}
}