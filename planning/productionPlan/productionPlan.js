
function loadDays()
{
	var start =document.getElementById('txtStartDate').value;
	var end =document.getElementById('txtEndDate').value;
	var dtStart = new Date(start);
	var dtEnd = new Date(end);
	var difference_in_milliseconds = dtEnd - dtStart;	
	
	if (difference_in_milliseconds < 0)
	{
		  alert("End date must be greater than Start date");
		  return false;
	}
	/*
	var width=8+60+80+(75+2)*(1+Math.ceil(difference_in_milliseconds/(1000*60*60*24)));	
	
	var tmpDate=dtStart;
	
	var htmltext="";
	
	var month_name=new Array(12);
	month_name[0]="Jan";
	month_name[1]="Feb";
	month_name[2]="Mar";
	month_name[3]="Apr";
	month_name[4]="May";
	month_name[5]="Jun";
	month_name[6]="Jul";
	month_name[7]="Aug";
	month_name[8]="Sep";
	month_name[9]="Oct";
	month_name[10]="Nov";
	month_name[11]="Dec";
	
	
	htmltext +="<table width=\""+width+"\"  border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#162350\"  id=\"tblMain\"><tr><td  class=\"normaltxtmidb2\" >"+
						"<div id=\"boxdiv1\" >"+	
						"<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">Team</div>"+
						"<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Title</div>";
	
	for(;tmpDate<=dtEnd;){
		
		htmltext +="<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">"+tmpDate.getDate()+"/"+month_name[tmpDate.getMonth()]+"</div>";
		tmpDate.setDate(tmpDate.getDate()+1);						
	}
	
	htmltext +="</div></td></tr>";		
	*/
	
	var plannedQty="FALSE";
	if(document.getElementById('productionPlan_PlannedQty').checked==true)
		plannedQty="TRUE";
	
	var plannedTTL="FALSE";
	if(document.getElementById('productionPlan_PlannedTTL').checked==true)
		plannedTTL="TRUE";
	
	var plannedEfy="FALSE";
	if(document.getElementById('productionPlan_PlannedEfy').checked==true)
		plannedEfy="TRUE";
	
	var actualQty="FALSE";
	if(document.getElementById('productionPlan_ActualQty').checked==true)
		actualQty="TRUE";
		
	var actualTTL="FALSE";
	if(document.getElementById('productionPlan_ActualTTL').checked==true)
		actualTTL="TRUE";
	
	var actualEfy="FALSE";
	if(document.getElementById('productionPlan_ActualEfy').checked==true)
		actualEfy="TRUE";
	
	var urlDetails="productionPlanMiddle.php";
	urlDetails=urlDetails+"?id=teams&numDays="+(1+Math.ceil(difference_in_milliseconds/(1000*60*60*24)))+"&startDate="+document.getElementById('txtStartDate').value+"&endDate="+document.getElementById('txtEndDate').value+"&plannedQty="+plannedQty+"&plannedTTL="+plannedTTL+"&plannedEfy="+plannedEfy+"&actualQty="+actualQty+"&actualTTL="+actualTTL+"&actualEfy="+actualEfy;
	
	htmlobj=$.ajax({url:urlDetails,async:false});
	//htmltext +=htmlobj.responseText;
	//alert(htmlobj.responseText);
	//alert(htmlobj);
	document.getElementById('myDiv').innerHTML =htmlobj.responseText;
	
	/*
	var urlDetails="actualmiddle.php";
	urlDetails=urlDetails+"?id=Save";
	
	urlDetails=urlDetails+"&date="+document.getElementById("txtValidFrom").value;
	urlDetails=urlDetails+"&startTime="+document.getElementById("actual_time1").value;
	urlDetails=urlDetails+"&endTime="+document.getElementById("actual_time2").value;
	urlDetails=urlDetails+"&intTeamNo="+document.getElementById("actual_cboTeam").value;
	urlDetails=urlDetails+"&strStyleID="+document.getElementById("actual_cboStyle").value;
	urlDetails=urlDetails+"&intStripeID="+document.getElementById("actual_cboStripe").value;
	urlDetails=urlDetails+"&dblProducedQty="+document.getElementById("actual_txtProducedQty").value;
	urlDetails=urlDetails+"&dblSMV="+document.getElementById("actual_txtSMV").value;
	urlDetails=urlDetails+"&intWorkers="+document.getElementById("actual_txtWorkers").value;
	urlDetails=urlDetails+"&intWorkingMins="+document.getElementById("actual_txtWorkingMins").value;
	
	(function($) { 
			  
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
		
	})(jQuery);
	*/
} 

function loadReport()
{
	
	var start =document.getElementById('txtStartDate').value;
	var end =document.getElementById('txtEndDate').value;
	var dtStart = new Date(start);
	var dtEnd = new Date(end);
	var difference_in_milliseconds = dtEnd - dtStart;	
	
	if (difference_in_milliseconds < 0)
	{
		  alert("End date must be greater than Start date");
		  return false;
	}
	
	var plannedQty="FALSE";
	if(document.getElementById('productionPlan_PlannedQty').checked==true)
		plannedQty="TRUE";
	
	var plannedTTL="FALSE";
	if(document.getElementById('productionPlan_PlannedTTL').checked==true)
		plannedTTL="TRUE";
	
	var plannedEfy="FALSE";
	if(document.getElementById('productionPlan_PlannedEfy').checked==true)
		plannedEfy="TRUE";
	
	var actualQty="FALSE";
	if(document.getElementById('productionPlan_ActualQty').checked==true)
		actualQty="TRUE";
		
	var actualTTL="FALSE";
	if(document.getElementById('productionPlan_ActualTTL').checked==true)
		actualTTL="TRUE";
	
	var actualEfy="FALSE";
	if(document.getElementById('productionPlan_ActualEfy').checked==true)
		actualEfy="TRUE";
	
	var urlDetails="report.php";
	urlDetails=urlDetails+"?numDays="+(1+Math.ceil(difference_in_milliseconds/(1000*60*60*24)))+"&startDate="+document.getElementById('txtStartDate').value+"&endDate="+document.getElementById('txtEndDate').value+"&plannedQty="+plannedQty+"&plannedTTL="+plannedTTL+"&plannedEfy="+plannedEfy+"&actualQty="+actualQty+"&actualTTL="+actualTTL+"&actualEfy="+actualEfy;
	
	window.location=urlDetails;
	
}