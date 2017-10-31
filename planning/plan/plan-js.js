
	var today = new Date();
	var dd = today.getDate(); 
	var mm = today.getMonth();//January is 0!
	//alert(mm);
	var yyyy = today.getFullYear();
	
	
	var intStartMonth=0;
	
	
	var intStartYear 	= yyyy;
	if(mm>0)
	{
		intStartMonth 	= mm-1;
		//alert(intStartMonth);
	}
	else
		intStartMonth    =11;
		
	var intStartDay		= dd;
	

	
	
	
	var sId=0;
	var tId=[];
	var removeStripId=[];
	var h =0;
	var t=0;
 	var i = 0;
	var x = 0;
	//var stripCount = 0;
	var arrS = [];
	
	var arrStrip  	=	[];
	var arrTeam 	= 	[];
	var arrCalender =	[];
	var arrCurve	=	[];
	var pub_beforeDragLeft = 0;
	var arrcalenderStatus=[];
	var arrM = [];
	
	
	

$(document).ready( function() {
		
							
		$(".classTeam").droppable({
			drop: function(event, ui){
			
			var A = $(this).find("#"+x).attr('id');		
			var teamId = $(this).attr('id');
			
			//alert(A);
			var divTeamId = teamId;	
			 	
			teamId = teamId.substring(4);		
			
			var obMbar = $(this).offset();			
			var obStrip = $("#"+x).offset();
		
			$("#"+x).offset({top:obMbar.top });
			
			
			
			//////////////calculation/////////////////////
			var stripLeft =  obStrip.left-obMbar.left;
			//alert(stripLeft);
						
			var cdays 	= 	(stripLeft/39);			
			var A1			=	parseInt((stripLeft / 39))/21;
			var A2			= 	(cdays-A1).toFixed(2);
			var A3			=	parseInt(A2);
			var cellLeft 	= ((cdays-A1-A3).toFixed(4));
			
			var pars=document.getElementById(divTeamId).getElementsByTagName("DIV");
			
			if(divTeamId!="divInitial")
				var cellDate = (pars[A3].id)
				//alert(cellDate);
			
			
			
			var strStyle = (arrStrip[x.substring(4)]['style']);
			/*var Dd = calDate.getDate();
			var Mm = calDate.getMonth()+1;
			if(Dd<10)
				Dd = '0'+Dd;			
			if(Mm<10)
				Mm = '0'+Mm;
				
			var newDate  = new String(calDate.getFullYear()+ "-"+Mm+"-"+Dd);*/
			
			
			//////////////////////////////////////   TIME CALCULATION ///////////////////////////////////////
						//alert(teamId);
			if(teamId=='nitial')
			{	
				callGetPosition();
				$("#"+x).width(100);
				arrStrip[x.substring(4)]['team'] 		= 0;
				callSetPosition();
				return;
			}
			
			
			
				var totMin 		= 	parseInt(arrM[teamId]['workingMinutes']);
				
				var startMin	=	parseInt((totMin*cellLeft).toFixed(2));
					
				
				
				arrStrip[x.substring(4)]['startDate'] 	= cellDate;
				arrStrip[x.substring(4)]['startTime'] 	= parseInt(startMin);
				
				var temp_team = arrStrip[x.substring(4)]['team'];
				//alert(temp_team);
				arrStrip[x.substring(4)]['team'] 		= teamId;
				
				//arrStrip[x.substring(4)]['curve'] 		= 0;
				arrStrip[x.substring(4)]['endDate'] 	= cellDate;
				
				arrStrip[x.substring(4)]['endTime']		= parseInt(startMin);
				arrStrip[x.substring(4)]['stripLeft']	= stripLeft;
				arrStrip[x.substring(4)]['cellLeft']	= cellLeft;
				arrStrip[x.substring(4)]['stripLeft']	= stripLeft;
				//arrStrip[x.substring(4)]['removeStatus']	= 0;
				
				//alert(arrStrip[x.substring(4)]['startDate']);
				//var sDate = arrStrip[x.substring(4)]['startDate'];
				//alert(sDate);
				//var sTeam = arrStrip[x.substring(4)]['team'];
				//alert(sTeam);
							
				//alert(time);
				/////////////////////////////######//////alert(arrCalender[dtSerial][sTeam]['workingMinutes']);
				//alert(arrCalender[arrStrip[x.substring(4)]['startDate']][arrStrip[x.substring(4)]['team']]);
				var tempWidth = $("#"+x).width();
				
				//alert(calDate);
				var stripWidth = calculateStripWidth(x.substring(4),cellDate,cellLeft); //alculateStripWidth(dtSerial,paQty,paTeam,paSmv,paTeamEffi,paMachines)
				//stripWidth=40;
				//alert(x);
				
				
				if(stripWidth!=0)
				{
					
					checkSubTeam();
					//alert(checkSubTeamValue);
					if(checkOverLap())
					{
					stripWidth = 0;
					}
				}
					
				if(stripWidth==0)
				{
					//alert('test');
					stripWidth = tempWidth;
					//pub_beforeDragLeft
					
					//alert('team'+temp_team);
					//$("#"+x).remove();
					//$("#"+x).remove().appendTo('team'+temp_team);
					// $("#"+x).css({ position: "absolute"})
					 arrStrip[x.substring(4)]['team'] 		= 0;
					//document.getElementById('team'+temp_team).appendChild(get(x));
					//$("#"+x).offset({left:pub_beforeDragLeft});
					callGetPosition();
					
					$("#"+x).remove();
					
					setLastPossition();
					
					callSetPosition();
					return;
					 //$("#"+x).css({ position: "absolute"})
					 
					
					//$("#"+x).revert();
				}
				
				callGetPosition();
				
				if(teamId!='divInitial')
					$("#"+x).width(stripWidth);
				else
					$("#"+x).width(100); //for initial row
					
				arrStrip[x.substring(4)]['stripWidth']	= stripWidth;
				
				callSetPosition();
				
				//alert(arrStrip[x.charAt(4)]['style']);// for get style no
	
				
				//alert(2);
				//$(".strip").offset({left:this.left-stripWidth });
				
				//$(".strip").offset({left:"+=500" });
				
				//alert(e);
				//$("#drag3").offset({left:(e)});
				
				//$("#"+x).css({position:"absolute"})
				//grag2.style.position = "absolute";
				//alert($("#"+x).attr('id'));
				//var A3 		= 	(A2*40)+obMbar.left-(40/21*A2);
				
				//$("#"+x).offset({left:A3 });
				
				//alert(A2.toFixed(2));
			
				
			}
		});
		//divInitialCaption
/*		$(".classGridBox1").droppable({
			drop: function(event, ui){
				alert('drop mini box');
			}
		});*/


		//$("#"+x).resizable();

$("#myDiv").scroll(function () { 
     	var scrollX= $(this).scrollLeft();
		//$('.strip').offset({left:left+(scrollX*(-1))});
		//alert(scrollX);
    });

$(".classGridBox").click(function(){
		var date = $(this).attr('id');
		var isActive = $(this).attr('name');
		var team= ($(this).parent().attr('id')).substring(4);
		
		//alert(teamId);
		//alert(A);
		clickonDay(date,team,isActive);							
	});
   // });
   
   

});	

function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}
 
function ltrim(str) {
	chars = ' '  || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str) {
	chars = ' ' || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function checkOverLap()
{
	if(arrStrip[x.substring(4)]['removeStatus']==0)
	{

	var team1 = arrStrip[x.substring(4)]['team'];
	var id1 = arrStrip[x.substring(4)]['id'];
	var startDate1 = new Date(jQuery.trim(arrStrip[x.substring(4)]['startDate']).replace(/-/gi,'/'));
	var endDate1 = new Date(jQuery.trim(arrStrip[x.substring(4)]['endDate']).replace(/-/gi,'/'));
	var startMin1 = parseInt(arrStrip[x.substring(4)]['startTime']);
	var endMin1 = parseInt(arrStrip[x.substring(4)]['endTime']);
	
	
	
	//alert(startDate1);
	//var dayMin = parseInt(arrCalender[startDate1][team1]['workingMinutes']);
	
	for(m in arrStrip)
	{
		if(arrStrip[m]['removeStatus']==0)
		{
		
		var team2 			= arrStrip[m]['team'];
		
		var  id2 			= arrStrip[m]['id'];
		var  startDate2 	= new Date(jQuery.trim(arrStrip[m]['startDate']).replace(/-/gi,'/'));
		var  endDate2 		= new Date(jQuery.trim(arrStrip[m]['endDate']).replace(/-/gi,'/'));
		var  startMin2 		= (arrStrip[m]['startTime']);
		var  endMin2 		= (arrStrip[m]['endTime']);
		
		if(team1==team2 && id1!=id2)
		{
			
			if(startDate2<=startDate1 && endDate2>=startDate1)
			{
				if((getD(startDate1)==getD(endDate1))&& (getD(endDate1)==getD(startDate2)))
				{
					if((endMin1+startMin1)<=startMin2)
						return false;
						
						alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
						return true;
				}
				
				if((getD(startDate1)==getD(endDate1))&& (getD(endDate1)==getD(endDate2)))
				{
					if(startMin1>endMin2)
						return false;
						
						alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
						return true;
				}
				
				if(getD(startDate1)==getD(endDate2))
				{
					if(startMin1>endMin2)
						return false;
				}
				if(getD(startDate1)==getD(startDate2))
				{
					if(startMin1<startMin2)	
					{
						if(getD(endDate1)==getD(startDate2))
						{
							if(endMin1<startMin2)
								return false;
						}
					}
				}
				
				alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
						return true;
			}
			
			if(startDate1<=startDate2 && endDate1>=startDate2)
			{
				
				if(getD(endDate1)==getD(startDate2))
				{
					if(endMin1<=startMin2)
					{
						return false;
					}
				}
				alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
						return true;
			}
			// FRONT SIDE OVERLAP
			/*if(endDate2 >startDate1 )
			{
				//alert(endDate1 + ' = '+startDate2);
				if(endDate1.getDate()==startDate2.getDate())
				{
					alert('1 Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
					return true;
				}
			}
			else if(endDate2.getYear() ==startDate1.getYear() && endDate2.getMonth() ==startDate1.getMonth() && endDate2.getDate() ==startDate1.getDate()  )
			{
				if(startMin1<endMin2)
				{
					alert('2 Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
					return true;	
				}		
			}*/
			
			// BACK SIDE OVERLAP
			/*if()
			{
				alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
				return true;
			}
			else if(endDate2 =startDate1)
			{
				if(startMin1<endMin2)
				{
					alert('Strip Overlap Id - '+arrStrip[x.substring(4)]['id']+' and '+arrStrip[m]['id']);
					return true;	
				}		
			}*/
		
		
		}
		}
		
	
	}
	return false;
	}
}

function getD(dt)
{
	return dt.getFullYear()+'-'+dt.getMonth()+'-'+dt.getDate();
}

function setLastPossition()
{
	if(arrStrip[x.substring(4)]['removeStatus']==0)
	{
	var orderStyle=arrStrip[x.substring(4)]['orderStyle'];
	//alert(orderStyle);
	var style = arrStrip[x.substring(4)]['style'] ;
	var qty = arrStrip[x.substring(4)]['qty'] ;
	var smv =arrStrip[x.substring(4)]['smv'] ;
	
	arrStrip[x.substring(4)]['team'] = 0;
	
	var styleText = orderStyle + '( '+ qty + ' )';
 	var newdiv = document.createElement('div');
	var nDrag = x;
	
	//alert(nDrag);
	//d.style.width="1270px";
	//newdiv.style.width = "100px";
	
    newdiv.setAttribute('id',nDrag);
	//newdiv.setAttribute('zIndex',nDrag);
	//newdiv.style.z-index = i;
	newdiv.setAttribute('class','strip');
	//newdiv.style.position = 'absolute';
	newdiv.style.position = 'relative';
	newdiv.style.zIndex = x.substring(4);
	newdiv.style.border=" green solid 1px";
	//newdiv.style.backbroundcolor = "#660000";
	
/*	  var htmltext = 	 "<table width=\"100%\" style=\"background-color:#D6E7F5;opacity:0.6;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf; width=\100%\" class=\"cursercross\" >"+
			 " <tr >"+
			"	<td width=\"100%\" colspan=\"5\" style=\"color:#660000\;font-size:10px\" align=\"center\">"+styleText+"</td>"+
			"  </tr>"+
			"  </table>";	
    */
	newdiv.innerHTML =	"<span style=\"opacity:1;\">"+styleText+"</span>";
	newdiv.oncontextmenu 	= ItemSelMenu;
	//newdiv.style.zIndex	 = 1;
	newdiv.onmousedown = func2;
	newdiv.onclick	   = funcClickOnStrip;
	
	//create array strip wise
	
	//newdiv.style.width = '200px';
  	document.getElementById('divInitial').appendChild(newdiv);
	
	
	$(function() {
		$("#"+x).draggable({
							   revert: 'invalid' ,
								
							   });
	});
	}
	
}
function clickonDay(date,team,isActive)
{
	document.getElementById('menudiv').style.display = "none" ;
	document.getElementById('menudiv1').style.display = "none" ;
	
	document.getElementById("dayDate").innerHTML 	= 		arrCalender[date][team]['date'];
	document.getElementById("dayTeam").innerHTML 	= 		arrTeam[team]['strTeam'];
	
		document.getElementById("dayType").innerHTML 		= 		arrCalender[date][team]['DayStatus'];
		document.getElementById("dayStartTime").innerHTML 	= 		arrCalender[date][team]['startTime'];
		document.getElementById("dayEndTime").innerHTML 	= 		arrCalender[date][team]['endTime'];
		document.getElementById("dayWorkingHours").innerHTML= 		arrCalender[date][team]['workingHours'];
		document.getElementById("dayDay").innerHTML 		= 		arrCalender[date][team]['strDay'];
		document.getElementById("dayMachines").innerHTML 	= 		arrCalender[date][team]['machines'];
		document.getElementById("dayEfficency").innerHTML 	= 		arrCalender[date][team]['efficency'];
		
		if(arrCalender[date][team]['DayStatus']=='saturday' || arrCalender[date][team]['DayStatus']=='sunday' || arrCalender[date][team]['DayStatus']=='inactive' || arrCalender[date][team]['DayStatus']=='off')
			document.getElementById("mealHours").innerHTML 		= 		0;
		else
			document.getElementById("mealHours").innerHTML 		= 		arrTeam[team]['mealHours'];
	
	if(isActive=='inActive')
	{
		document.getElementById("dayActive").innerHTML 		= 		"InActive";

	}
	else
	{

		document.getElementById("dayActive").innerHTML 		= 		"Active";
	}
	
	get('tblStrip').style.display = 'none';
	get('tblDay').style.display = 'table';
	
	/*var innerString="";
	   innerString=" <tr >&nbsp;</tr>";
      innerString+="<tr>&nbsp;</tr>";
	  innerString+="<tr>&nbsp;</tr>"; 
	  
	  document.getElementById("tblFooter2").innerHTML 	=innerString;*/
	  
	//get('divHead').innerHTML = get('divDay').innerHTML;
	//get('divDay').style.visibility = 'visible';
}
function get(id)
{
	return document.getElementById(id);
}


function getEndTime()
{

	var startTimeStrip 	= arrStrip[x.substring(4)]['endTime']	;
    if(arrStrip[x.substring(4)]['endDate']==arrStrip[x.substring(4)]['startDate'])
	{
		startTimeStrip   = parseInt(startTimeStrip)+parseInt(arrStrip[x.substring(4)]['startTime']);
	}
	var stDate			= arrStrip[x.substring(4)]['endDate'];
	var teamId 			= arrStrip[x.substring(4)]['team'];
	var startTimeDay  	= parseFloat(arrM[teamId]['startTime'])	;
	
	
	/*if(arrCalender[stDate][teamId]['DayStatus']=='saturday' || arrCalender[stDate][teamId]['DayStatus']=='sunday' || arrCalender[stDate][teamId]['DayStatus']=='inactive' || arrCalender[stDate][teamId]['DayStatus']=='off')
		var mealTime=0;
	else
		var mealTime=parseFloat(arrTeam[teamId]['mealHours']);
		
	var mealH=parseInt(mealTime);
		
	var mealM 	= parseInt(((mealTime-parseFloat(mealH))*100).toFixed(0));*/
	
	var H 				= parseInt(startTimeDay);
	var M 				= parseInt(((startTimeDay-parseFloat(H))*100).toFixed(0));
	var ToM  			= M +(H*60)+parseInt(startTimeStrip);
	var nH 				= parseInt(ToM/60);
	var nM				= ToM - (nH*60);
	var nTime 			= zeroPad(nH,2) +":"+zeroPad(nM,2);
	
	return nTime;	
	
}
function getStartTime()
{
	
		var startTimeStrip 	= arrStrip[x.substring(4)]['startTime']	;

		var stDate			= arrStrip[x.substring(4)]['startDate'];
		var teamId 			= arrStrip[x.substring(4)]['team'];
		var startTimeDay  	= parseFloat(arrM[teamId]['startTime']);
		
		
	
	//////	CAL PART
	var H 	= parseInt(startTimeDay);
	//alert(parseFloat(H*60));
	var M 	= parseInt(((startTimeDay-parseFloat(H))*100).toFixed(0));
	
	var ToM = M +(H*60)+parseInt(startTimeStrip);
	//alert(ToM);
	//alert(mealM+(mealH*60));
	//var ToM = (parseInt((parseInt(startTimeDay)-H).toFixed(2))*100)+parseInt(H*60)+parseInt(startTimeStrip);
	//alert(ToM);
	
	var nH 	= parseInt(ToM/60);
	var nM	= ToM - (nH*60);
	//alert(startTimeStrip);
	
	var nTime = zeroPad(nH,2) +":"+zeroPad(nM,2);
	
	
	//alert(nTime);
		  //stop here
	return nTime;
}

function zeroPad(num, numZeros) {
        var n = Math.abs(num);
        var zeros = Math.max(0, numZeros - Math.floor(n).toString().length );
        var zeroString = Math.pow(10,zeros).toString().substr(1);
        if( num < 0 ) {
                zeroString = '-' + zeroString;
        }

        return zeroString+n;
}


function callGetPosition()
{
/*	for(var n=1;n<=i;n++)
	{*/
	for(n in arrStrip)
	{
		
		if(arrStrip[n]['removeStatus']==0)
		{
		try{	
			
		var d3 = $("#drag"+n).offset();
		var e = d3.left;
		//alert(e);
		arrS[n] = e;
		}catch(e){
			}
		}
	}
		//alert(arrStrip[n-1]);
/*	}*/
}

function callSetPosition()
{
	for(n in arrStrip)
	{
		//alert(arrStrip[n]);	
		//alert(arrS[n]);
		var setLeft = parseFloat(arrS[n])+0.5;
		$("#drag"+(n)).offset({left:setLeft});
	}
}


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ calculate strip width @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function calculateStripWidth(stripId,dtSerial,cellLeft)
{

		var qty 	= 	arrStrip[stripId]['qty'];
		var team 	= 	arrStrip[stripId]['team'];
		var smv 	= 	arrStrip[stripId]['smv'];
		var curveId =   arrStrip[stripId]['curve'];
		var teamEfficency 	= 	arrTeam[team]['efficency'];
		var machines 		= 	arrTeam[team]['machines'];
		
		
		var changeTeamParam = arrStrip[stripId]['changeTeamParam'];
		//alert(changeTeamParam);
		
		var startingDate	= new Date(dtSerial);
		
		if(changeTeamParam==1)
		{
			var chTeamEfficency = arrStrip[stripId]['paramTeamEff'];
			var chNOMachine		= arrStrip[stripId]['paramNoOfMachine'];
			var totalminutes 	= ((parseFloat(qty) * parseFloat(smv))/(parseFloat(chNOMachine) * parseFloat(chTeamEfficency))*100).toFixed(0);
			//alert(totalminutes);
		}
		
		else if(curveId==0)
		{
			var totalminutes 	= ((parseFloat(qty) * parseFloat(smv))/(parseFloat(machines) * parseFloat(teamEfficency))*100).toFixed(0);
			
		}
		
		else///////////////////////////////////////Adding Learning Curve//////////////////////////////////
		{
				var totalminutes=0;
				var totQty=0;
				var cntMin=0;
				
				
				var arrEffi = arrCurve[curveId]['efficiency'].split(',');
				
				var dt =$.datepicker.parseDate('yy-mm-dd', dtSerial);
				var dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
				
				for (var j=0;j<arrEffi.length-1;j++)
				{
						var qty1=((parseFloat(arrM[team]['workingMinutes'])*parseFloat(arrEffi[j])*parseFloat(machines))/(parseFloat(smv)*100)).toFixed(0);
					
					
					totQty=parseFloat(totQty)+parseFloat(qty1);
					
					
					if(parseFloat(totQty)<=parseFloat(qty))
					{
						
							totalminutes=parseFloat(totalminutes)+parseFloat(arrM[team]['workingMinutes']);
					}
					else
					{
						totQty=parseFloat(totQty)-parseFloat(qty1);
						
						var excessQty=parseFloat(qty)-parseFloat(totQty);
						
						totalminutes=parseFloat(totalminutes)+((excessQty*smv*100)/(parseFloat(machines)*parseFloat(arrEffi[j])));
						
						cntMin=1;
						break;
					}
					
					dt.setDate(dt.getDate()+1);
				    dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
				}
				
				if(cntMin!=1)
				{
					var dtNew1=dtNew;
					dt =$.datepicker.parseDate('yy-mm-dd', dtNew1);
					
					dt.setDate(dt.getDate()+1);
					dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
					
					
					
					teamEfficency 	= 	arrTeam[team]['efficency'];
					
					
					qty1=((parseFloat(arrM[team]['workingMinutes'])*parseFloat(teamEfficency)*parseFloat(machines))/(parseFloat(smv)*100)).toFixed(0);	
					totQty=parseFloat(totQty)+parseFloat(qty1);
					
					
					while(parseFloat(totQty)<=parseFloat(qty))
					{
						
						totalminutes=parseFloat(totalminutes)+parseFloat(arrM[team]['workingMinutes']);
						
						dt.setDate(dt.getDate()+1);
				    	dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
						
						
						qty1=((parseFloat(arrM[team]['workingMinutes'])*parseFloat(teamEfficency)*parseFloat(machines))/(parseFloat(smv)*100)).toFixed(0);	
						totQty=parseFloat(totQty)+parseFloat(qty1);
					}
					
					if(parseFloat(totQty)>parseFloat(qty))
					{
						totQty=parseFloat(totQty)-parseFloat(qty1);
						var excessQty1=parseFloat(qty)-parseFloat(totQty);
						
						totalminutes=parseFloat(totalminutes)+((excessQty1*smv*100)/(parseFloat(machines)*parseFloat(teamEfficency)));
					}
					
				}
		}///////////////////////////////////////////////////////
		
	//alert(totalminutes);
	var pp=0;
	//alert(totalminutes);
	var pendingMin = totalminutes;
	
	/*if(arrCalender[dtSerial][team]['workingMinutes']==0)
	{
		if(arrCalender[dtSerial][team]['DayStatus']=='inactive')
			alert("This is InActive area for the Team \""+arrTeam[team]['strTeam']+"\.");
		else
			alert("This day is holliday for Team \""+arrTeam[team]['strTeam']+"\" .So style can't start in here.");	
		return 0;
	}*/
	
	//alert(pendingMin);
	var sWidth = 0;
	var tempDate = 0;
	//tempDate = dtSerial;
	var vi=0;
	var endMinutes = 0;
	var dayMin = 0;
	//var i = 1;
	do
	{
		vi++;
		
		//alert(tempDate);
		
		
		
		
		var myday  = startingDate;
		var date1 = myday.getDate();
		if(date1<10)
		date1 = '0'+date1;
			
		var month1 = myday.getMonth()+1;
		if(month1<10)
		month1 = '0'+month1;
			
		var dateFormat = new String(myday.getFullYear()+'-'+month1+'-'+date1);
		
		var pras = document.getElementById('team'+team).getElementsByTagName("DIV");
		
		var activeStatus = pras[dateFormat].title;
		
		if('inActive'==activeStatus)
		{
			alert("Style can't going to over the InActive days.\n Style will be move to the Initial-Row.");
			return 0;
		}
		
		if(myday.getDay()==6)
		{
			var url = "plan-db.php?id=getWorkingHours";
				url +="&dateFormat="+dateFormat;
		
			htmlobj=$.ajax({url:url,async:false});
				//alert(htmlobj.responseText);
				
			if(htmlobj.responseText==false)
			{
				
				dayMin = 300;
			}
			else
			{
				dayMin = htmlobj.responseText;
			}
		}
		else if(myday.getDay()==0)
		{
			var url = "plan-db.php?id=getWorkingHours";
				url +="&dateFormat="+dateFormat;
		
			htmlobj=$.ajax({url:url,async:false});
				
				
			if(htmlobj.responseText==false)
			{
				dayMin = 0;	
				
			}
			else
			{
				dayMin = htmlobj.responseText;
			}
		}
		else 
		{
			dayMin = arrM[team]['workingMinutes'];
			//alert(dayMin);				
		}
		
		
		for(d=0; d<=holidayCount[0]; d++)
		{
			if(dateFormat == holidayDate[d])
			{
				dayMin = holidayWorkingHours[d];
			}
		}
		
		
		
		
		
		var mem_dayMin = dayMin;
		
		if(sWidth==0)
		{
			var cellLeftMin = (cellLeft * dayMin);
			dayMin -=cellLeftMin;
		}
			//alert(dayMin);
			
		if(pendingMin<=dayMin)
		{
			//alert("day = "+tempDate+" , pending="+pendingMin+" , dayMin = "+dayMin);
			if(dayMin==0)
			{
				sWidth += 0;
			}
			else
			{
				endMinutes = pendingMin;
				sWidth += (pendingMin/mem_dayMin * 41);
				pendingMin = 0;
			}
		}
		else
		{
			//////////////////////////////   GOTO NEXT DATE  //////////////////////////////////////////////////////////////////////////
			myday.setDate(myday.getDate()+1);
			
				//pre calculation for create next date /////////////////////
			var Dd = myday.getDate();
			var Mm = myday.getMonth()+1;
			if(Dd<10)
				Dd = '0'+Dd;
				
			if(Mm<10)
				Mm = '0'+Mm;
			var tempDate = new String(myday.getFullYear()+'-' +Mm+'-'+Dd);
			
				// end of pre calculation/////////////////////////////////////
				
				/*if(arrCalender[tempDate][team]['DayStatus']=='inactive')
				{
					alert("Style can't going to over the InActive days.\n Style will be move to the Initial-Row.");
					return 0;
				}*/
			//alert(arrCalender[tempDate][team]['workingMinutes']);
			//alert(pendingMin);
			//return;
			pendingMin -= dayMin;
			if(dayMin<=0)
				sWidth +=41;
			else
				sWidth +=((41*dayMin)/mem_dayMin);
				
		//alert(sWidth);
			//alert(pendingMin + ' - '+dayMin + ' = width '+sWidth);
			//if(vi==5)
				//break;
		}
		
		
	}while (pendingMin > 0);
	
		
		arrStrip[stripId]['endDate'] 	= tempDate;
		
		//alert(tempDate);
		
			//var startTimeStrip = endMinutes;//arrStrip[stripId]['lastDayMin']	;
			//var stDate		= tempDate;
			//var teamId 		= arrStrip[stripId]['team'];
			//var startTimeDay  	= parseFloat(arrCalender[tempDate][teamId]['startTime'])	;
			//var H 	= parseInt(startTimeDay);
			//var M 	= parseInt(((startTimeDay-parseFloat(H))*100).toFixed(0));
			//var ToM  = M +(H*60)+parseInt(startTimeStrip);
			//var nH 	= parseInt(ToM/60);
			//var nM	= ToM - (nH*60);
			//var eTime = zeroPad(nH,2) +":"+zeroPad(nM,2);
			
			//alert(endMinutes);
		arrStrip[stripId]['endTime']		= parseInt(endMinutes);
		
		//alert(sWidth);
		return sWidth;
}

 function createObject(obj)
 {
	 
 	var style = obj.cells[2].innerHTML;
	var qty = obj.cells[3].innerHTML;
	var smv = obj.cells[10].firstChild.value;
	var orderStyleId=obj.cells[1].innerHTML;
	var orderStyle=obj.cells[2].innerHTML;
	var exFactoryDate=obj.cells[5].innerHTML;
		
	var url1 = "plan-db.php?id=getOrderNo";
	url1  +="&styleId="+orderStyleId;
	
	htmlobj=$.ajax({url:url1,async:false});
	var orderNo=htmlobj.responseText;
	
	
	if(smv!=0)
	{
		var url = "plan-db.php?id=selectSewingSmv";
		url  +="&styleId="+orderStyleId;
	
		htmlobj=$.ajax({url:url,async:false});
		
		var dbSewingSmv=htmlobj.responseText;
		//alert(dbSewingSmv);
		
		//var dbSewingSmv=obj.cells[10].childNodes[0].value;
		//alert(dbSewingSmv);
		
		if(parseFloat(dbSewingSmv)==parseFloat(smv))
		{
			var styleText = style + '( '+ qty + ' )';
			var newdiv = document.createElement('div');
			var nDrag = 'drag'+(++i);
			
			
			
			//alert(nDrag);
			//d.style.width="1270px";
			//newdiv.style.width = "100px";
			
			newdiv.setAttribute('id',nDrag);
			//newdiv.setAttribute('zIndex',nDrag);
			//newdiv.style.z-index = i;
			newdiv.setAttribute('class','strip');
			//newdiv.style.position = 'absolute';
			newdiv.style.position = 'relative';
			newdiv.style.zIndex = i;
			newdiv.style.border=" green solid 1px";
			//newdiv.style.backbroundcolor = "#660000";
			
		/*	  var htmltext = 	 "<table width=\"100%\" style=\"background-color:#D6E7F5;opacity:0.6;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf; width=\100%\" class=\"cursercross\" >"+
					 " <tr >"+
					"	<td width=\"100%\" colspan=\"5\" style=\"color:#660000\;font-size:10px\" align=\"center\">"+styleText+"</td>"+
					"  </tr>"+
					"  </table>";	
			*/
			newdiv.innerHTML =	"<span style=\"opacity:1;\">"+styleText+"</span>";
			newdiv.oncontextmenu 	= ItemSelMenu;
			//newdiv.style.zIndex	 = 1;
			newdiv.onmousedown = func2;
			newdiv.onclick	   = funcClickOnStrip;
			
			//create array strip wise
			var arrProperty 			= [];
				arrProperty['id'] 		= i;
				arrProperty['orderStyleId']	=orderStyleId;
				arrProperty['orderNo']=orderNo;
				arrProperty['orderStyle']=orderStyle;
				arrProperty['style']	= style;
				arrProperty['qty'] 		= qty;
				arrProperty['actQty'] 	= 0;
				arrProperty['new'] 		= 1;
				arrProperty['totalHours'] 		= 0;
				arrProperty['smv'] 		= smv;
				arrProperty['team']		= 0;
				arrProperty['removeStatus']=0;
				arrProperty['deliveryDate']=exFactoryDate;
			
				arrProperty['curve']=0;
				arrProperty['curveName']='';
				arrProperty['cellLeft']=0;
				
				var tpdate = new Date();
				tpdate = tpdate.getFullYear()+'-'+tpdate.getMonth()+'-'+tpdate.getDate();
				
				arrProperty['startDate']=tpdate
				arrProperty['startTime']=0;
				arrProperty['endDate']=tpdate;
				arrProperty['endTime']=0;
				arrProperty['changeTeamParam']=0;
				
			arrStrip[i] = arrProperty;
			
			//newdiv.style.width = '200px';
			document.getElementById('divInitial').appendChild(newdiv);
			removeOrderLine(obj);
			setObject();
		}
		else
			alert("Please Save Edited Data");
	}
	else
		alert("Please enter a value for sewingsmv");
		
 }
 
 
function func2(e)
{
	
	x = this.id;
	//alert(x);
	var d3 = $("#"+x).offset();
	var m = d3.left;	
	pub_beforeDragLeft = m;
	
	//onrightclick(e);

}

function onrightclick(e)
{
	////////// create click event ///////
	var rightclick;
	if (!e) var e = window.event;
	if (e.which) rightclick = (e.which == 3);
	else if (e.button) rightclick = (e.button == 2);
	 ////////////////////////////////////
	if(rightclick)
	{
			 var popupbox = document.createElement("div");
			 popupbox.id = "contextmenu";
			 popupbox.style.position = 'absolute';
			 popupbox.style.zIndex = 1000;
			 popupbox.style.left = 300 + 'px';
			 popupbox.style.top = 300 + 'px';  
			 var htmltext = "123";
			 popupbox.innerHTML = "<table id=\"contextmenu\" width=\"183\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
									"<td width=\"36\">&nbsp;</td>"+
									"<td width=\"172\">&nbsp;</td>"+
								  "</tr>"+
								  "<tr>"+
									"<td>&nbsp;</td>"+
									"<td>&nbsp;</td>"+
								  "</tr>"+
								  "<tr>"+
									"<td>&nbsp;</td>"+
									"<td>&nbsp;</td>"+
								  "</tr>"+
								  "<tr>"+
									"<td>&nbsp;</td>"+
									"<td>&nbsp;</td>"+
								  "</tr>"+
								  "<tr>"+
									"<td>&nbsp;</td>"+
									"<td>&nbsp;</td>"+
								  "</tr>"+
								"</table>";  
			 document.body.appendChild(popupbox);
	}
	else
	{
		var box = document.getElementById('contextmenu');
		box.parentNode.removeChild(box);
	}
		//alert('Rightclick: ' + rightclick); // true or false
}

function bodyonclick(e)
{

	var box = document.getElementById('contextmenu');
	box.parentNode.removeChild(box);

}
	
function removeOrderLine(obj)
{
	var tblOrder = document.getElementById("tblOrderBook");
	tblOrder.deleteRow(obj.rowIndex);
}
function setObject()
{
		$(function() {
		$("#drag"+i).draggable({
							   revert: 'invalid' ,
							   
							   //helper: 'clone',
								//containment: 'parent',
								//grid: [150,150],

								
							   });
//		$("#draggable2").draggable({ snap: '.ui-widget-header' });

			//$("#drag"+i).draggable({ snap: '.ui-widget-header' });
		/*$("#boxdiv3").droppable({
			drop: function(event, ui){
				//$("#boxdiv3").html("dropped");
				
				//$("drag"+i).offset.top
				var pos = $(this).position();
				//alert(pos.left + " " + pos.top);
			}
		});

				$("#boxdiv4").droppable({
			drop: function(event, ui){
			}
		});*/
	});	
}



function savePlanningDetails()
{

		var allRecord 	= 0;
		var savedRecord = 0;
		
	
		
		for(var j=0;j<tId.length;j++)
		{
			var url = "plan-db.php?id=deleteStrip";
				url	+= "&activeStrip="+tId[j];	
				htmlobj=$.ajax({url:url,async:false});
			arrStrip.splice(tId[j],1);
		}
		
		for(n in arrStrip)
		{
			//alert(arrStrip[n]['joinStripCnt']);
			allRecord++;
			
			var teamId = (arrStrip[n]['team']);
			//alert(arrM[teamId]['workingMinutes'])
			
			var url = "plan-db.php?id=savePlanDetails";
				url	+= "&style="+(arrStrip[n]['orderStyleId']);
				url	+= "&smv="+arrStrip[n]['smv'];
				url	+= "&stripId="+(arrStrip[n]['id']);
				url	+= "&new="+(arrStrip[n]['new']);
				url	+= "&qty="+(arrStrip[n]['qty']);
				url	+= "&actQty="+(arrStrip[n]['actQty']);
				url	+= "&startDate="+(arrStrip[n]['startDate']);
				url	+= "&startTime="+(arrStrip[n]['startTime']);
				url	+= "&team="+teamId;
				url	+= "&curve="+(arrStrip[n]['curve']);
				url	+= "&endDate="+(arrStrip[n]['endDate']);
				url	+= "&endTime="+(arrStrip[n]['endTime']);
				url	+= "&totalHours="+(arrStrip[n]['totalHours']);
				url	+= "&cellLeft="+(arrStrip[n]['cellLeft']);
				url	+= "&stripWidth="+(arrStrip[n]['stripWidth']);
				url	+= "&workingHours="+(arrM[teamId]['workingMinutes']);
				url	+= "&teameffi="+(arrStrip[n]['paramTeamEff']);
				url	+= "&machines="+(arrStrip[n]['paramNoOfMachine']);
				url	+= "&changeTeamParam="+(arrStrip[n]['changeTeamParam']);
				
			htmlobj=$.ajax({url:url,async:false});
			//alert(htmlobj.responseText);
			if( htmlobj.responseText==1)
			{
				savedRecord++;
			}
		}
		if(allRecord==savedRecord)
			alert("Planning data saved successfully.");
		else
			alert("Planning data not saved.Please save it again.");
	
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*var mousex = 0;
var mousey = 0;
var grabx = 0;
var graby = 0;
var orix = 0;
var oriy = 0;
var elex = 0;
var eley = 0;
var algor = 0;
var dragobj = null;



function falsefunc() { 
	return false; 
} // used to block cascading events






function getMouseXY(e) // works on IE6,FF,Moz,Opera7
{ 
  if (!e) e = window.event; // works on IE, but not NS (we rely on NS passing us the event)

  if (e)
  { 
    if (e.pageX || e.pageY)
    { // this doesn't work on IE6!! (works on FF,Moz,Opera7)
		//alert(mousex);
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';
      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { // works on IE6,FF,Moz,Opera7
      mousex = e.clientX + document.body.scrollLeft;
      mousey = e.clientY + document.body.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }  
  }
}

function grab(context,e)
{
	update(e);

  document.onmousedown = falsefunc; // in NS this prevents cascading of events, thus disabling text selection
  dragobj = context;
  dragobj.style.zIndex = context.zIndex; // move it to the top
  document.onmousemove = drag;
  document.onmouseup = drop;


  grabx = mousex;
  graby = mousey;
	

  elex = orix = dragobj.offsetLeft;
  eley = oriy = dragobj.offsetTop;
  //update();
}


function drag(e) // parameter passing is important for NS family 
{
  if (dragobj)
  {
    elex = orix + (mousex-grabx);
    eley = oriy + (mousey-graby);
    dragobj.style.position = "absolute";
    dragobj.style.left = (elex).toString(10) + 'px';
    dragobj.style.top  = (eley).toString(10) + 'px';
  }
  update(e);
  return false; // in IE this prevents cascading of events, thus text selection is disabled
}

function drop()
{
  if (dragobj)
  {
    dragobj.style.zIndex = 0;
    dragobj = null;
  } 
  update();
  document.onmousemove = update;
  document.onmouseup = null;
  document.onmousedown = null;   // re-enables text selection on NS
}

*/

function checkRow()
{	
	var rowLength=document.getElementById('tblOrderBook').rows.length;
	
	for(n in arrStrip)
	{
		var arrStyleId=arrStrip[n]['orderStyleId'];
		//alert(arrStrip[n]['qty']);
		for(var j=2;j<rowLength;j++)
		{
		var styleId=document.getElementById('tblOrderBook').rows[j].cells[1].childNodes[0].nodeValue;
		
		
		var earlyCellQty=document.getElementById('tblOrderBook').rows[j].cells[3].childNodes[0].nodeValue;
			if(styleId==arrStyleId)
			{
				
				document.getElementById('tblOrderBook').rows[j].cells[3].innerHTML=earlyCellQty-arrStrip[n]['qty'];
					if(document.getElementById('tblOrderBook').rows[j].cells[3].childNodes[0].nodeValue==0)
					{
						document.getElementById('tblOrderBook').deleteRow(j);
						rowLength=document.getElementById('tblOrderBook').rows.length;
					}
			}
		}
	}
}


////////////////////////////////////////////////////////////////////////////////////////////////

function createAllStrips()
 {	
 
 	for(a in arrTeam)
	{ 
		var teamId = 'team'+arrTeam[a]['id'];
		var paWidth = 0;
		
		for(n in arrStrip)
		{
			//alert(arrTeam[n]['id']);
			if(arrStrip[n]['removeStatus']==0)
			{
				var divTeamId = 'team'+arrStrip[n]['team'];
				if(teamId==divTeamId)
				{
					
					var pars = document.getElementById(divTeamId).getElementsByTagName('DIV');
					//var cellTop = $("#calanderDiv").offset();
					//cellTop  = cellTop.top;
					//alert(cellTop);
					
					var fristCel = (pars[0].id);
					
					var firstDate = new Date(fristCel);
					var startDate = new Date(arrStrip[n]['startDate']);
					
					var difference		= startDate.getTime() - firstDate.getTime();
					var daysDifference	= Math.floor(difference/1000/60/60/24);
					//alert(startDate+"-"+firstDate);
					
					var orderStyleId	= arrStrip[n]['orderStyleId'];	
					var orderStyle		= arrStrip[n]['orderStyle'];
					var style			= arrStrip[n]['style'];		
					var qty				= arrStrip[n]['qty'];
					var cellLeft		= arrStrip[n]['cellLeft'];
					var cellLeft1		= parseFloat(cellLeft)*41;
				
					var styleText = orderStyle + '('+ qty + ')';
					var newdiv = document.createElement('div');				
					var nDrag = 'drag'+(n);				
					newdiv.style.zIndex = 1;
					newdiv.setAttribute('id',nDrag);				
					newdiv.setAttribute('class','strip');
					newdiv.style.position = 'relative';
					newdiv.style.border=" green solid 1px";
					
					
					// create oder 
					
					
					var intTeam = arrStrip[n]['team'];
					if(intTeam>0)
					{	
						var stripLeft = parseFloat((daysDifference*41+cellLeft1))-parseFloat(paWidth);
						
						var Width = parseFloat(calculateStripWidth(n,arrStrip[n]['startDate'],arrStrip[n]['cellLeft']));
						
						newdiv.style.left = (parseFloat(stripLeft)-1)+'px';
						
											
						paWidth = parseFloat(Width) + parseFloat(paWidth);
						
						
						newdiv.style.width = parseFloat(calculateStripWidth(n,arrStrip[n]['startDate'],arrStrip[n]['cellLeft']))+'px';
						
						
						newdiv.style.top = '-25px';
						var tdSize=0;
						var actualOder = arrStrip[n]['actQty'];
						
						if(actualOder>0)
						{
							var totQty = arrStrip[n]['qty'];			
							
							arrStrip[n]['qty'] = actualOder;
							tdSize = parseFloat(calculateStripWidth(n,arrStrip[n]['startDate'],arrStrip[n]['cellLeft']));
							
							var totbehindQty = arrStrip[n]['behindQty'];
							
							
							// @@@@@ adpress behind quentity in strip by red color @@@
							var qty_for_1px = parseFloat(totQty/Width);
							var qtyfor_oneday = parseFloat(qty_for_1px)*40*arrStrip[n]['datesCount'];
							if(qtyfor_oneday>=actualOder)
							{
								var behindQty = parseInt(qtyfor_oneday-actualOder);
								totbehindQty = parseInt(totbehindQty) + behindQty;
							}
							else
							{
							    var	ahead_of = actualOder-qtyfor_oneday;
								totbehindQty = totbehindQty - ahead_of;
							}
							
							arrStrip[n]['qty'] = totbehindQty;
							var behindWidth = parseFloat(calculateStripWidth(n,arrStrip[n]['startDate'],arrStrip[n]['cellLeft']));
							arrStrip[n]['qty'] = totQty;
							
								var tbl = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
								
								if(totbehindQty>0)
								{
									arrStrip[n]['behindQty'] = totbehindQty;
									tbl += "<td width=\""+tdSize+"px\" bgcolor=\"#A7E05A\" height=\"24px\">&nbsp;</td>";
									tbl += "<td style=\"position:absolute\" width=\""+behindWidth+"px\" bgcolor=\"#FF3030\" height=\"24px\">"+styleText+"</td>";
								}
								else
									tbl += "<td style=\"position:absolute\" width=\""+tdSize+"px\" bgcolor=\"#A7E05A\" height=\"24px\">"+styleText+"</td>";
									tbl += "</tr></table>";
									
									
							 
						}
						
						paWidth = parseFloat(paWidth)+2 ;
						
						
						
					}			
					
					if(tdSize==0)
					{
						newdiv.innerHTML ="<span>"+styleText+"</span>";
						
						//setObject2();
					}
					else
						newdiv.innerHTML =	tbl;
						
					newdiv.oncontextmenu 	= ItemSelMenu;	
					newdiv.onmousedown = func2;
					newdiv.onclick	   = funcClickOnStrip;
					
					
					if(arrStrip[n]['team']==0)
						document.getElementById('divInitial').appendChild(newdiv);
					else
					{
						document.getElementById('team'+arrStrip[n]['team']).appendChild(newdiv);
						
					}
				} //end if in line no 1339
				
					
			}
			if(tdSize==0)
				setObject2();
		}
	}
 }
 
 
 /*function setActQty()
 {
	for(n in arrStrip)
	{
		
		if(arrStrip[n]['removeStatus']==0)
		{
			var orderStyleId=arrStrip[n]['orderStyleId'];
			
			var orderStyle=arrStrip[n]['orderStyle'];
			var style = arrStrip[n]['style'];
	
			var qty = arrStrip[n]['qty'];
			var styleText = orderStyle + '( '+ qty + ' )';
			
			var tdSize=0;
		
			var completedQty=arrStrip[n]['actQty'];//getCompletedQty(activeSplitId);
			//alert(completedQty);
			if(completedQty>0)
			{
				var totQty=arrStrip[n]['qty'];
				
				var endDate=arrStrip[n]['endDate'];
				var endTime=arrStrip[n]['endTime'];
				
				arrStrip[n]['qty']=completedQty;
				
				var completedWidth=parseFloat(calculateStripWidth(n,arrStrip[n]['startDate'],arrStrip[n]['cellLeft']));
				
				tdSize=completedWidth;
				
				arrStrip[n]['qty']=totQty;
				
				arrStrip[n]['qty']=totQty;
				arrStrip[n]['endDate']=endDate;
				arrStrip[n]['endTime']=endTime;
				
				var div1=document.getElementById("drag"+n);
		
				if(tdSize==0)
					div1.innerHTML=styleText;
				else
					div1.innerHTML =	"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><td width=\""+tdSize+"px\" bgcolor=\"#A7E05A\" >"+styleText+"</td></table>";
			}
		}
	}
 }*/

 
 /*function getCompletedQty(stripId)
 {
	 //alert(stripId);
	 	var url1 = "plan-db.php?id=completedQty";
			url1	+= "&style="+arrStrip[stripId]['style'];
			url1	+= "&team="+arrStrip[stripId]['team'];
			url1	+= "&stripId="+stripId;
				
	var htmlobj=$.ajax({url:url1,async:false});
	var qty=htmlobj.responseText;
	
	//alert(qty);
	
	return htmlobj.responseText;
 }*/
 
 function getThisMonthQuantity(paDate,lastMonthFirstDay,n)
 {
	 	var dt =$.datepicker.parseDate('yy-mm-dd', paDate);
		var dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
		
		//alert(dtNew);
		var team 	= 	arrStrip[n]['team'];
		var smv 	= 	arrStrip[n]['smv'];
		//alert(curveId);
		var teamEfficency 	= 	arrTeam[team]['efficency'];
		var machines 		= 	arrTeam[team]['machines'];
 		
	
		var spentMinutes=arrStrip[n]['startTime'];
		//alert(dayMinutes);
	
		var firstDayWorkTime=arrCalender[dtNew][ arrStrip[n]['team'] ]['workingMinutes']-spentMinutes;
		
		var totalMinutes=firstDayWorkTime;
		
		//alert(totalMinutes);
		
		dt.setDate(dt.getDate()+1);
		dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
		

		var qty=0;
		var curveId=arrStrip[n]['curve'];
		//alert(curveId);
		if(curveId==0)
		{
			
			while(dtNew<lastMonthFirstDay)
			{
				//alert(arrCalender[dtNew][ arrStrip[n]['team'] ]['workingMinutes']);
				totalMinutes=totalMinutes+arrCalender[dtNew][ arrStrip[n]['team'] ]['workingMinutes'];
				
				dt.setDate(dt.getDate()+1);
				dtNew =$.datepicker.formatDate( 'yy-mm-dd', dt);
				
			}

			qty=(parseFloat(totalMinutes)*parseFloat(machines) * parseFloat(teamEfficency)/ (parseFloat(smv)*100));
			
			
			arrStrip[n]['qty']=arrStrip[n]['qty']-qty;
			
			
		}
		else
		{
			var url = "plan-db.php?id=createStrip&curveId="+curveId;
			var xmlhttp_obj   = $.ajax({url:url,async:false})
			var effi         = xmlhttp_obj.responseText;
			var j=0;
			var arrEffi = effi.split(',');
			
			
			var dt1 =$.datepicker.parseDate('yy-mm-dd', paDate);
			var dtNew1 =$.datepicker.formatDate( 'yy-mm-dd', dt1);
			var qty1=0;
			
			while(dtNew1<lastMonthFirstDay)
			{
				if(j!=(arrEffi.length-1))
				{
					qty1=((parseFloat(arrCalender[dtNew1][team]['workingMinutes'])*parseFloat(arrEffi[j]))/(parseFloat(smv)*100)).toFixed(0);
					j++;
					
				}
				else
				{
					qty1=((parseFloat(arrCalender[dtNew1][team]['workingMinutes'])*parseFloat(arrEffi[j-1]))/(parseFloat(smv)*100)).toFixed(0);
				}
				qty=parseFloat(qty)+parseFloat(qty1);
				
				dt1.setDate(dt1.getDate()+1);
				
				dtNew1 =$.datepicker.formatDate( 'yy-mm-dd', dt1);
			}
			arrStrip[n]['qty']=arrStrip[n]['qty']-qty;
		}
			
 }

function setObject2()
{
			$(function() {
			for(n in arrStrip)
			{
				//var completedQty=getCompletedQty(n);
				if(arrStrip[n]['actQty']==0)
				{
					
				$("#drag"+n).draggable({
								   		revert: 'invalid' 
								   });
				
				}
			}
			
		});	
}

function setObject3()
{
			$(function() {
			for(n in arrStrip)
			{
			$("#drag"+n).draggable
			({
				 revert: 'invalid' ,						
	
			});

		}
			
		});	
}

function loadLearningCurveDetails()
{
	//var curveId=arrStrip[x.substring(4)]['curve'];
	//var stripId=arrStrip[x.substring(4)]['id'];
	var curveDet=document.getElementById("cbo_curveDet");
	var curveId=arrStrip[x.substring(4)]['curve'];
	//alert(curveId);
	/*var url = "plan-db.php?id=&curveId="+arrStrip[x.substring(4)]['curve'];
	
	var xmlhttp_obj   = $.ajax({url:url,async:false})
	
	document.getElementById('cbo_curveDet').innerHTML = xmlhttp_obj.responseText;*/
	var innerString="<option selected value=\"0\"></option>";
	for(n in arrCurve)
	{
		if(curveId==arrCurve[n]['id'])
			innerString+="<option selected value=\""+arrCurve[n]['id']+"\">"+arrCurve[n]['curveName']+"</option>";
		else
			innerString+="<option value=\""+arrCurve[n]['id']+"\">"+arrCurve[n]['curveName']+"</option>"; 
	}
	
	document.getElementById("cbo_curveDet").innerHTML=innerString;
	
	/*var url1="plan-db.php?id=disableLearningCurve&stripId="+arrStrip[x.substring(4)]['id'];
	var xmlhttp_obj1   = $.ajax({url:url1,async:false})
	if(xmlhttp_obj1.responseText==1)*/
	
	if(arrStrip[x.substring(4)]['actQty']!=0)
		document.getElementById('cbo_curveDet').disabled="true";
}



function removeStrip()
{
	//callGetPosition();
	//showStripDetails();
	document.getElementById("menudiv").style.display = "none";
	
	var activeSplitId= x.substring(4);
	//alert(activeSplitId);
	//alert(arrStrip[activeSplitId]['id']);
	
	var styleId=arrStrip[activeSplitId]['style'];
	var orderId=arrStrip[activeSplitId]['orderStyleId'];
	var qty=arrStrip[activeSplitId]['qty'];
	var smv=arrStrip[activeSplitId]['smv'];
	
			tId[t]=activeSplitId;
			t++;
			
				var divId="drag"+activeSplitId;
				var div=document.getElementById(divId);
				var parent=document.getElementById(divId).parentNode;
				
				arrStrip[activeSplitId]['orderStyleId']=0;			
				arrStrip[activeSplitId]['removeStatus']=1;
				//createAllStrips();
				
				parent.removeChild(div);
				
				
				//callSetPosition();

			
}

//###################ENTER KEY EVENT############################//
function pressEnter(event)
{
	if(event.keyCode=='13')
	{
		validateQty();
	}
}


//######################VALIDATING THE QTY IN THE TEXT BOX###############################//
function validateQty()
{
	
	//var activeSplitId= document.getElementById("stripNo").innerHTML;
	var activeSplitId=x.substring(4);
	var txtQty=document.getElementById("txtSplitQty").value;
	
	//alert(arrStrip[activeSplitId]['qty']);
	var completedQty= document.getElementById("txtProducedQty").value;
	
	
	if(document.getElementById("txtSplitQty").value.trim() == "" || document.getElementById("txtSplitQty").value==0 )
	{
		alert("Please Enter a Value to the Split Qty!! ");
		document.getElementById("txtSplitQty").focus();
	}
	else if(isNaN(document.getElementById("txtSplitQty").value))
	{
		alert("Split Qty must be a \"Numeric \" value.");
		
		document.getElementById("txtSplitQty").value="";
		document.getElementById("txtSplitQty").focus();
	}
	else if(Number(txtQty)>=arrStrip[activeSplitId]['qty'])
	{
		alert("Specified Qty is too large")
		document.getElementById("txtSplitQty").value="";
		document.getElementById("txtSplitQty").focus();
		
	}
	else if(parseFloat(txtQty)>(parseFloat(arrStrip[activeSplitId]['qty'])-parseFloat(completedQty)))
	{
		var restQty=parseFloat(arrStrip[activeSplitId]['qty'])-parseFloat(completedQty);
		alert("You can't split.Only "+restQty+" qty left");
		document.getElementById("txtSplitQty").value="";
		document.getElementById("txtSplitQty").focus();
	}
	else
	{
		callGetPosition();
		splitStrip();
		callSetPosition();
	}
}



//####################SPLITING THE STRIPES##########################//
function splitStrip()
{	

	var activeSplitId = x.substring(4);
	
	var fixedQty	= arrStrip[activeSplitId]['qty']; 	
	var style		= arrStrip[activeSplitId]['style'];	
	var orderStyle	= arrStrip[activeSplitId]['orderStyle'];	
	var leftCell	= arrStrip[activeSplitId]['cellLeft'];
		
	var earlyQty=arrStrip[activeSplitId]['qty'];
	
	
	var nowQty=document.getElementById("txtSplitQty").value;
	
	var rest=fixedQty-nowQty;
	
	//updating the array....
	arrStrip[activeSplitId]['qty']=rest;
	
	
	var styleText = orderStyle + '( '+ rest + ' )';
	
	var sDate = new Date(arrStrip[activeSplitId]['startDate']);
	//alert(sDate);
	var pDate = new Date(intStartYear +'/'+ (intStartMonth+1) +'/'+ intStartDay);
	var days = parseInt((sDate - pDate)/86400000);
	
	//var left_days = (no_of_dates - days)*(-42);
	var timeM = arrStrip[activeSplitId]['startTime'];
	var intTeam = arrStrip[activeSplitId]['team'];
	
	if(intTeam>0)
	{
		//var tempW = parseFloat((arrTeam[intTeam]['totalStripWidth']).toFixed(2));
		//alert(tempW);
		//alert(arrTeam[intTeam]['totalStripWidth']);
		//if(tempW>0)
		//{
			//tempW+=2;
		//}
		//div.style.left = (left_days-tempW)+'px';
	
	
	//////////////////////////////////////// WIDTH CALCULATION /////////////////////////////////////////////
	var paDate = arrStrip[activeSplitId]['startDate'];
	
	var paWidth = parseFloat(calculateStripWidth(activeSplitId,paDate,arrStrip[activeSplitId]['cellLeft'])) ; 
	
	
	
	var div1=document.getElementById("drag"+activeSplitId);
	
	
	var tdSize=0;
		
	var completedQty= arrStrip[activeSplitId]['actQty'];//getCompletedQty(activeSplitId);
	//alert(completedQty);
	if(completedQty!=0)
	{
		var totQty=arrStrip[activeSplitId]['qty'];
		
		//alert(arrStrip[activeSplitId]['qty']);
		
		arrStrip[activeSplitId]['qty']=completedQty;
		//alert(arrStrip[activeSplitId]['qty']);
		var completedWidth=parseFloat(calculateStripWidth(activeSplitId,paDate,arrStrip[activeSplitId]['cellLeft']));
		//var completedWidth=div1.childNodes[0].rows[0].cells[0].width;
		tdSize=completedWidth;
		
		//alert(totQty);
		arrStrip[activeSplitId]['qty']=totQty;

	}

	//alert(paWidth);
	//div1.style.width = (paWidth)+ 'px';
	//arrTeam[arrStrip[activeSplitId]['team']]['totalStripWidth'] =  paWidth+tempW;
	}// end of if(intTeam>0)
	
	
	//div1.childNodes[0].rows[0].cells[0].width;
	/*div1.innerHTML=styleText;*/
	div1.style.width = (paWidth)+ 'px';
	
	if(tdSize==0)
		div1.innerHTML=styleText;
	else
		div1.innerHTML =	"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td width=\""+tdSize+"\" bgcolor=\"#A7E05A\" >"+styleText+"</td></tr></table>";
		
	
	//alert(arrStrip[x.substring(4)]['team']);
	//setObject2();
	///#######################CREATE INITIAL STRIP############################################
	createObject_for_split(activeSplitId,nowQty);
	//document.getElementById("tblFooter2").innerHTML=''; 	
	div1.oncontextmenu 	= ItemSelMenu;
	div1.onmousedown = func2;
	div1.onclick	   = funcClickOnStrip;
	setObject2();
	closeWindow();
}


///#######################CREATE INITIAL STRIP################################################
function createObject_for_split(activeSplitId,qty)
 {
	
 	var style = arrStrip[activeSplitId]['style'];
	var qty = qty;
	var orderId=arrStrip[activeSplitId]['orderStyleId'];
	var orderStyle=arrStrip[activeSplitId]['orderStyle'];
	var deliveryDate=arrStrip[activeSplitId]['deliveryDate'];
	//alert(deliveryDate);
	//var orderStyleId=arrStrip[activeSplitId]['smv'];
	var smv = arrStrip[activeSplitId]['smv'];
	
	var styleText = orderStyle + '( '+ qty + ' )';
 	var newdiv = document.createElement('div');
	var nDrag = 'drag'+(++i);
	
	//alert(nDrag);
	//d.style.width="1270px";
	//newdiv.style.width = "100px";
	
    newdiv.setAttribute('id',nDrag);
	//newdiv.setAttribute('zIndex',nDrag);
	//newdiv.style.z-index = i;
	newdiv.setAttribute('class','strip');
	//newdiv.style.position = 'absolute';
	newdiv.style.position = 'relative';
	newdiv.style.zIndex = i;
	newdiv.style.border=" green solid 1px";
	//newdiv.style.backbroundcolor = "#660000";
	
/*	  var htmltext = 	 "<table width=\"100%\" style=\"background-color:#D6E7F5;opacity:0.6;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf; width=\100%\" class=\"cursercross\" >"+
			 " <tr >"+
			"	<td width=\"100%\" colspan=\"5\" style=\"color:#660000\;font-size:10px\" align=\"center\">"+styleText+"</td>"+
			"  </tr>"+
			"  </table>";	
    */
	newdiv.innerHTML =	"<span style=\"opacity:1;\">"+styleText+"</span>";
	//newdiv.style.zIndex	 = 1;
	
	
	//create array strip wise
	var arrProperty 			= [];
		arrProperty['id'] 		= i;
		arrProperty['orderStyleId'] 		= orderId;
		arrProperty['style']	= style;
		arrProperty['orderStyle']	= orderStyle;
		arrProperty['orderNo']	=0;
		arrProperty['qty'] 		= qty;
		arrProperty['actQty'] 	= 0;
		arrProperty['new'] 		= 1;
		arrProperty['totalHours']= 0;
		arrProperty['smv'] 		= smv;
		arrProperty['team']		= 0;
		arrProperty['removeStatus']=0;
		arrProperty['deliveryDate']=deliveryDate;
	
		arrProperty['curve']=0;
		arrProperty['curveName']='';
		arrProperty['cellLeft']=0;
		
		var tpdate = new Date();
		tpdate = tpdate.getFullYear()+'-'+tpdate.getMonth()+'-'+tpdate.getDate();
		
		arrProperty['startDate']=tpdate
		arrProperty['startTime']=0;
		arrProperty['endDate']=tpdate;
		arrProperty['endTime']=0;
		
	arrStrip[i] = arrProperty;
	
	//newdiv.style.width = '200px';
  	document.getElementById('divInitial').appendChild(newdiv);
	newdiv.oncontextmenu 	= ItemSelMenu;
	newdiv.onmousedown = func2;
	newdiv.onclick	   = funcClickOnStrip;
	setObject();
 }
 
 function showCurveId1()
 {
	// var clickedStripNo=document.getElementById("stripNo").childNodes[0].nodeValue;
	 //alert(clickedStripNo);
	 var clickedStripNo=x.substring(4);
	 var curveDet=arrStrip[clickedStripNo]['actQty'];//getCompletedQty(clickedStripNo);
	if(parseFloat(curveDet)==0 || !curveDet)
		showCurveId();
	closeWindow();
 }
 
 function showCurveId()
 {
	var curveId=document.getElementById("cbo_curveDet").value;
	var curveName=$("#cbo_curveDet option:selected").text();
	//alert(curveId);
	//var clickedStripNo=document.getElementById("stripNo").childNodes[0].nodeValue;
	var clickedStripNo=arrStrip[x.substring(4)]['id'];
	//alert(clickedStripNo);
	if(clickedStripNo!=0)
	{
		callGetPosition();
		applyLearningCurveToStrip(clickedStripNo,curveId,curveName);
		callSetPosition();
	}
 }
 
 function applyLearningCurveToStrip(clickedStripNo1,curveId,curveName)
 {
	 arrStrip[clickedStripNo1]['changeTeamParam'] = 0;
	 arrStrip[clickedStripNo1]['paramTeamEff'] = 0;
	 var startingDate = arrStrip[clickedStripNo1]["startDate"];	
	 var preCurveName=arrStrip[clickedStripNo1]["curveName"];
	 var preCurve=arrStrip[clickedStripNo1]["curve"];
	 	
	 arrStrip[clickedStripNo1]["curve"]=curveId;
	 arrStrip[clickedStripNo1]["curveName"]=curveName;
	 
	 var oderStyle = arrStrip[clickedStripNo1]["orderStyle"];
	 var quantity  = arrStrip[clickedStripNo1]["qty"]; 
	 var styleText = oderStyle + '( ' + quantity + ' )';
	 var paWidth = parseFloat(calculateStripWidth(clickedStripNo1,startingDate,arrStrip[clickedStripNo1]["cellLeft"])) ;
	 //alert(paWidth);
	 
	 var checkOverLapValue=checkOverLap();
	if(checkOverLapValue==false)
	{
		var div1=document.getElementById("drag"+clickedStripNo1);
		div1.style.width = (paWidth)+ 'px';
		arrStrip[clickedStripNo1]["stripWidth"] = paWidth ;
		//if(tdSize==0)
			div1.innerHTML=styleText;
		//else
		//	div1.innerHTML =	"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"position:absolute\" width=\""+tdSize+"px\" bgcolor=\"#A7E05A\" >"+styleText+"</td></tr></table>";
		
		 
		div1.oncontextmenu 	= ItemSelMenu;
		div1.onmousedown    = func2;
		div1.onclick	   = funcClickOnStrip;
		
		setObject2();
		
	}
	else
	{
		arrStrip[activeSplitId]['qty']=preQty;
		arrStrip[activeSplitId]['curve']=Number(preCurve);
		arrStrip[activeSplitId]['curveName']=preCurveName;
	}
	
 }
 

 
 function setQtyForTextBoxesInSplitPopUp()
 {
	//alert(x);
	document.getElementById("txtQty").value = arrStrip[x.substring(4)]['qty'];   
	document.getElementById("txtProducedQty").value = arrStrip[x.substring(4)]['actQty']; 
	document.getElementById("txtRestQty").value = parseFloat(arrStrip[x.substring(4)]['qty']-arrStrip[x.substring(4)]['actQty']);
	
	 
 }

function disableAndEnableRightClickpopUp()
{
	//showStripDetails();
	 
	if(parseFloat( document.getElementById("stripCompletedQty").innerHTML)>0)
	{
		document.getElementById('item2_applyCurve').style.color="#E9E9E4";
		document.getElementById('item3_remove').style.color="#E9E9E4";
		//document.getElementById('item2').removeAttribute("onClick");
		//document.getElemen