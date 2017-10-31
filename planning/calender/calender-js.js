
// JavaScript Document
var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;
var pub_nextGridNo=0;
var pub_rowIndex = 0;
function createXMLHttpRequestCalender(index) 
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

function pageSubmitCalender()
{
	document.getElementById('frmCalender').submit();	
}
function refreshWindowCalender()
{
	createXMLHttpRequestCalender(0);
    xmlHttp[0].onreadystatechange = calendershowRequest;
    xmlHttp[0].open("GET", '../calender/calender.php', true);
    xmlHttp[0].send(null); 
}

function loadCalenderWindow()
{
	showPleaseWait();
	createXMLHttpRequestCalender(0);
    xmlHttp[0].onreadystatechange = calendershowRequest;
    xmlHttp[0].open("GET", '../calender/calender.php', true);
    xmlHttp[0].send(null); 
}
function calendershowRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		closeWindow();
		drawPopupAreaLayer(320,312,'frmCalender',1000);
		
		document.getElementById('frmCalender').innerHTML=text;
		
		loadCalenderData();
		hidePleaseWait();
	}
}

function setDateCaption()
{
	var intYear = document.getElementById('cboYear').value;
	var strMonth = document.getElementById('cboMonth').options[ document.getElementById('cboMonth').selectedIndex].text;	
	
	document.getElementById('caption').innerHTML = strMonth + ' ' + intYear;
}

function loadCalenderData()
{
	showPleaseWait();
	setDateCaption();
	var intYear = document.getElementById('cboYear').value;
	var intMonth = document.getElementById('cboMonth').value;
		
	var cdate = new Date(intYear+'/'+intMonth+'/01');
	var intDay = cdate.getDay();
	var	dayid = 0;
	var daycount = 32 - new Date(intYear,intMonth-1,32).getDate();
	var end = false;
	
	//var urlDetails="../calender/calenderXml.php?id=loadHolidays&intYear="+intYear+"&intMonth="+intMonth+"";
	//htmlobj=$.ajax({url:urlDetails,async:false});
	//alert(htmlobj.responseText);
	var arrA =  '/';
	
	var value1 = arrA.split('/')[0];
	var value2 = arrA.split('/')[1];
	var arrD = value1.split(',');
	var arrC = value2.split(',');
	//alert(count(arrC));
	for(var i=1;i<=42;i++)
	{
	if(!end)
	{
		if(intDay<i)
		{
			
			
			dayid++;
			//alert(arrD.indexOf('19')+' - '+dayid);
			//alert(in_array(arrD,dayid)+' - '+dayid);
			
			document.getElementById('box'+i).innerHTML = "<font size=\"+1\">"+dayid+"</font>";
			if(document.getElementById('box'+i).parentNode.style.backgroundColor=="red"){
			  document.getElementById('box'+i).parentNode.style.backgroundColor="white";
			}
			if((i+1)%7==0)
				document.getElementById('box'+(i+1)).parentNode.style.backgroundColor="#A7E05A";
				
			if((i)%7==0)
				document.getElementById('box'+(i+1)).parentNode.style.backgroundColor="#FCCA6D";
			
			if(in_array(arrD,dayid))
			{
				//alert(dayid);
				document.getElementById('box'+(i)).parentNode.style.backgroundColor="red";
			}
			if(in_array(arrC,dayid))
			{
				document.getElementById('box'+(i)).parentNode.style.backgroundColor="white";
			}
		}
		else
		{
			document.getElementById('box'+i).innerHTML = "<font size=\"+1\">&nbsp;</font>";
			document.getElementById('box'+(i)).parentNode.style.backgroundColor="";
		}
	}
	else
	{
		document.getElementById('box'+i).innerHTML = "<font size=\"+1\">&nbsp;</font>";
		document.getElementById('box'+(i)).parentNode.style.backgroundColor="";	
	}
		
		if(daycount+intDay==i){
		
			end = true;
			 //loadCalenderDetails();
			}
		
	}	
	hidePleaseWait();
	
}

function in_array(arry, toFind){
	//return ('_|_'+arry.join('_|_')+'_|_').indexOf('_|_'+toFind+'_|_') > -1;
	for(var i=0;i<arry.length;i++)
	{
		if(arry[i]==toFind)
			return true;
	}
}

/*function loadCalenderDetails(){
	
	var intYear  = document.getElementById("cboYear").value;
	var intMonth = document.getElementById("cboMonth").value;
	
	
 	var url="../calender/calenderXml.php?id=loadCalenderDetails&intYear="+intYear+"&intMonth="+intMonth+"";
	
   	createXMLHttpRequestCalender(0);
	xmlHttp[0].onreadystatechange = loadCalenderDetailsRequest;
	xmlHttp[0].open("GET",url, true);
	xmlHttp[0].send(null); 	
	
}

function loadCalenderDetailsRequest(){

	if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
     	//alert(xmlHttp[0].responseText);
		var XMLintDay       = xmlHttp[0].responseXML.getElementsByTagName("intDay");
		var XMLstrDay       = xmlHttp[0].responseXML.getElementsByTagName("strDay");
		var XMLstrDayStatus = xmlHttp[0].responseXML.getElementsByTagName("strDayStatus");
		//alert(XMLstrDay.length);
		//loadCalenderData();	
		if(XMLstrDay.length != 0){

		 var tblGLs = document.getElementById('tblGLs');	
		// alert(XMLstrDayStatus[0].childNodes[0].nodeValue);	
		    var intYear = document.getElementById('cboYear').value;
	        var intMonth = document.getElementById('cboMonth').value;
			var cdate = new Date(intYear+'/'+intMonth+'/01');
	        var intDay = cdate.getDay();
			
		 	for(var n = 0; n < XMLintDay.length ; n++) 
			{			 
				if(XMLstrDayStatus[n].childNodes[0].nodeValue == 'saturday'){
				  document.getElementById('box'+(n+intDay+1)).parentNode.style.backgroundColor='rgb(167, 224, 90)';
				}
				
				if(XMLstrDayStatus[n].childNodes[0].nodeValue == 'sunday'){
				  document.getElementById('box'+(n+intDay+1)).parentNode.style.backgroundColor='rgb(252, 202, 109)';
				}
				 
				if(XMLstrDayStatus[n].childNodes[0].nodeValue == 'work'){
				  document.getElementById('box'+(n+intDay+1)).parentNode.style.backgroundColor='white';
				}
				 
				 
				 if(XMLstrDayStatus[n].childNodes[0].nodeValue == 'off'){
				  document.getElementById('box'+(n+intDay+1)).parentNode.style.backgroundColor='red';
				}
			}
		}else{
			
		}
	}
}*/


function showPop(obj)
{
	var no = parseInt(obj.childNodes[0].childNodes[0].childNodes[0].data);	
	//alert(obj.lastChild.id);
	if(no!=0 && (! isNaN(no)))
	{
		
		var bcolor = obj.style.backgroundColor;

		if(bcolor!='red'){
			obj.style.backgroundColor='red';
		}
		else{
			obj.style.backgroundColor='white';
		}
		
		if(obj.id == 'sun'){
		  if(bcolor=='rgb(252, 202, 109)'){
			 obj.style.backgroundColor='red';
	    	}else if(bcolor=='red'){
			 obj.style.backgroundColor='white';	
			}else{
			  obj.style.backgroundColor='rgb(252, 202, 109)';		
			}
		}
		
		if(obj.id == 'sat'){
		  if(bcolor=='rgb(167, 224, 90)'){
			 obj.style.backgroundColor='red';
	    	}else if(bcolor=='red'){
			 obj.style.backgroundColor='white';	
			}else{
			  obj.style.backgroundColor='rgb(167, 224, 90)';		
			}
		}

		//alert(bcolor);
	}
}

function checkIfAssigened()
{
	showPleaseWait();
	
 	var intYear  = document.getElementById("cboYear").value;
	var intMonth = document.getElementById("cboMonth").value;

/*	//check at least one team
	var urlDetails="/gapro/planning/calender/calenderXml.php?id=checkTeamAvailablility";
	htmlobj=$.ajax({url:urlDetails,async:false});
	if(parseInt(htmlobj.responseText)<=0)
	{
		alert("First you have to create at least one team.If it is not, system unable save calender details.");
		hidePleaseWait();
		return;
	}*/
	
	/*//check already exist calender details
	var urlDetails="../calender/calenderXml.php?id=checkIfAssigened&intYear="+intYear+"&intMonth="+intMonth+"";
	htmlobj=$.ajax({url:urlDetails,async:false});
	var value =  parseInt(htmlobj.responseText);
	
	if(value>0)
	{
		if(!confirm ("Calender details already exists. Do you want to replace them?"))	
		{
			hidePleaseWait();return;
		}
	}*/
	
	//check calender order
	/*var edate = intYear+'/'+intMonth+'/01';
	
	var urlDetails="../calender/calenderXml.php?id=isValidDate&edate="+edate;
	htmlobj=$.ajax({url:urlDetails,async:false});
	var value =  htmlobj.responseText;
	if(value!='true')
	{
		alert("Calendar must continue from "+value);
		hidePleaseWait();return;
	}
	else*/
		dataSave();
}

function dataSave()
{
	
	var intYear  = document.getElementById('cboYear').value;
	var intMonth = document.getElementById('cboMonth').value;
	
	var cdate = new Date(intYear+'/'+intMonth+'/01');
	//alert(cdate);
	var intDay = cdate.getDay();
	//alert(intDay);
	var	dayid = 0;
	var daycount = 32 - new Date(intYear,intMonth-1,32).getDate();
	

	var url="../calender/calenderDB.php?id=save";
	url += "&intYear="+intYear;
	url += "&intMonth="+intMonth;
	url += "&day2=";
	var dayCount = 0 ;
	for(var i=intDay+1;i<=daycount+intDay;i++)
	{
			
		var bcolor = document.getElementById('box'+i).parentNode.style.backgroundColor;
		
		if(bcolor=='red')
		{
			dayCount++;
			
			var dateValue = $("#box"+i).html();
			var day1 = dateValue.split(">");
			var day2 = day1[1].split("<");
			
			url +=day2[0]+"-";	
		}
	
	}
	
	url += "&dayCount="+dayCount;
	
	createXMLHttpRequestCalender(0);
	xmlHttp[0].onreadystatechange = alertMessage;
	xmlHttp[0].open("GET",url, true);
	xmlHttp[0].send(null); 
}

function alertMessage()
{
	if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		//var save = trim(xmlHttp[0].responseText);
		//alert(save);
		hidePleaseWait();
		alert("Saved Successfully");
		
	}
}

function showWait()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divPleasewait";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;

  // popupbox.style.background="#000000"; 
   popupbox.style.width = '200px';
   popupbox.style.height = '200px';
   
     //popupbox.style.left = (screen.width + popupbox.width)/2+'px';
 	 popupbox.style.left =parseInt(screen.width)/2-parseInt(popupbox.style.width) + 'px';
	 popupbox.style.top =parseInt(screen.height)/2-parseInt(popupbox.style.height) + 'px';
	 
	 
   //popupbox.style.MozOpacity = 0.2;
   popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<p  align=\"center\"> <img src=\"/gapro/images/loading.gif\"  /></p>",
	document.body.appendChild(popupbox);
}




