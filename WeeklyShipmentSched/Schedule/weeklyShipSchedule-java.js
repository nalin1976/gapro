var xmlHttp;
var xmlHttp1=[];
var pub_intxmlHttp_count=0;
var pub_urlMonShip = "/gapro/WeeklyShipmentSched/Schedule/";

var pub_matNo = 0;
var pub_printWindowNo=0;
function createXMLHttpRequest() 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function loadWeek(week){
	if(week == 'loadWeek1'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek1.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek2'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek2.style.color = "red";
	txtweek1.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek3'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek3.style.color = "red";
	txtweek2.style.color = "black";
	txtweek1.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek4'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek4.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek1.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek5'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek5.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek1.style.color = "black";
	}	
}

function loadWeekModify(week){
	if(week == 'loadWeek1'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek1.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek2'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek2.style.color = "red";
	txtweek1.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek3'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek3.style.color = "red";
	txtweek2.style.color = "black";
	txtweek1.style.color = "black";
	txtweek4.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek4'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek4.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek1.style.color = "black";
	txtweek5.style.color = "black";
	}
	
	if(week == 'loadWeek5'){
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	txtweek5.style.color = "red";
	txtweek2.style.color = "black";
	txtweek3.style.color = "black";
	txtweek4.style.color = "black";
	txtweek1.style.color = "black";
	}	
}

function loadWeeklySchedule(){
	var tblTable    = 	document.getElementById("tblWeeklyMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=2;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}
	


	var cboStyleNo = document.getElementById('cboStyleNo').value;
	var cboOrderNo = document.getElementById('cboOrderNo').value;
	var cboBuyer = document.getElementById('cboBuyer').value;
	var cboWeeklySchedNo = document.getElementById('cboWeeklySchedNo').value;
	var path = "weeklyShipSchedule-xml.php?id=loadWeekly";
	path += "&StyleNo="+cboStyleNo;
	path += "&OrderNo="+cboOrderNo;
	path += "&cboBuyer="+cboBuyer;
	path += "&WeeklySchedNo="+cboWeeklySchedNo;

	htmlobj2=$.ajax({url:path,async:false});  
	
   if(htmlobj2.readyState == 4 && htmlobj2.status == 200 ) 
   {
	var tblViewData      = document.getElementById("tblWeeklyMain");  
	var XMLdeldate       = htmlobj2.responseXML.getElementsByTagName("deldate");
	var XMLorderno       = htmlobj2.responseXML.getElementsByTagName("orderno");
	var XMLintStyleId    = htmlobj2.responseXML.getElementsByTagName("intStyleId");
	var XMLstrStyle   = htmlobj2.responseXML.getElementsByTagName("strStyle");
	var XMLorderqty      = htmlobj2.responseXML.getElementsByTagName("orderqty");
    var XMLdelqty        = htmlobj2.responseXML.getElementsByTagName("delqty");
	var XMLdescription   = htmlobj2.responseXML.getElementsByTagName("description");
	var XMLunitprice	 = htmlobj2.responseXML.getElementsByTagName("unitprice");
	var XMLmerchandiser	 = htmlobj2.responseXML.getElementsByTagName("merchandiser");
	var XMLbuyer         = htmlobj2.responseXML.getElementsByTagName("buyer");
	var XMLintBuyerID    = htmlobj2.responseXML.getElementsByTagName("intBuyerID");
	var XMLscheduledate	 = htmlobj2.responseXML.getElementsByTagName("scheduledate");
	var XMLdblPcsPerPack = htmlobj2.responseXML.getElementsByTagName("dblPcsPerPack");
	var XMLshipmode      = htmlobj2.responseXML.getElementsByTagName("shipmode");
	var XMLintShipmentModeId      = htmlobj2.responseXML.getElementsByTagName("intShipmentModeId");
	var XMLstrVessal     = htmlobj2.responseXML.getElementsByTagName("strVessal");
	var XMLdtVessalDate  = htmlobj2.responseXML.getElementsByTagName("dtVessalDate");
	var XMLstrWearhouse  = htmlobj2.responseXML.getElementsByTagName("strWearhouse");
	var XMLstrDimention  = htmlobj2.responseXML.getElementsByTagName("strDimention");
	var XMLcomnam        = htmlobj2.responseXML.getElementsByTagName("comnam");
	var XMLmonQtySea     = htmlobj2.responseXML.getElementsByTagName("monQtySea");
	var XMLmonQtyAir     = htmlobj2.responseXML.getElementsByTagName("monQtyAir");
	var XMLstrColor        = htmlobj2.responseXML.getElementsByTagName("strColor");
	var XMLdblLength  = htmlobj2.responseXML.getElementsByTagName("dblLength");
	var XMLdblHight  = htmlobj2.responseXML.getElementsByTagName("dblHight");
	var XMLdblWidth  = htmlobj2.responseXML.getElementsByTagName("dblWidth");
	var XMLCBM  = htmlobj2.responseXML.getElementsByTagName("CBM");
	var XMLdbllblcomposition  = htmlobj2.responseXML.getElementsByTagName("dbllblcomposition");
	var XMLintSerial  = htmlobj2.responseXML.getElementsByTagName("intSerial");
	var XMLstrWashCode  = htmlobj2.responseXML.getElementsByTagName("strWashCode");
	var XMLstrSchedDate  = htmlobj2.responseXML.getElementsByTagName("strSchedDate");
	var XMLbalqty    = htmlobj2.responseXML.getElementsByTagName("balqty");
	var XMLstrWeek    = htmlobj2.responseXML.getElementsByTagName("strWeek");
	var XMLdblShipNowQuantityAir    = htmlobj2.responseXML.getElementsByTagName("dblShipNowQuantityAir");
	var XMLdblShipNowQuantitySea    = htmlobj2.responseXML.getElementsByTagName("dblShipNowQuantitySea");
	var XMLrem    = htmlobj2.responseXML.getElementsByTagName("strRemarks");
    var week = "";
	for(var n = 0; n < XMLorderno.length; n++) 
	{
	var rowCount = tblViewData.rows.length;
	var row = tblViewData.insertRow(rowCount);
		row.className="bcgcolor-tblrowWhite";
	var nn = n+1;		 		
    var intStyleId =  XMLintStyleId[n].childNodes[0].nodeValue;
	if(XMLstrWeek[n].childNodes[0].nodeValue == 'WEEK1'){
		week1 = "WEEK1";
		week2 = "WEEK2";
		week3 = "WEEK3";
		week4 = "WEEK4";
		week5 = "WEEK5";
	}
	if(XMLstrWeek[n].childNodes[0].nodeValue == 'WEEK2'){
		week1 = "WEEK2";
		week2 = "WEEK1";
		week3 = "WEEK3";
		week4 = "WEEK4";
		week5 = "WEEK5";
	}
	if(XMLstrWeek[n].childNodes[0].nodeValue == 'WEEK3'){
		week1 = "WEEK3";
		week2 = "WEEK1";
		week3 = "WEEK2";
		week4 = "WEEK4";
		week5 = "WEEK5";
	}
	if(XMLstrWeek[n].childNodes[0].nodeValue == 'WEEK4'){
		week1 = "WEEK4";
		week2 = "WEEK1";
		week3 = "WEEK2";
		week4 = "WEEK3";
		week5 = "WEEK5";
	}
	if(XMLstrWeek[n].childNodes[0].nodeValue == 'WEEK5'){
		week1 = "WEEK5";
		week2 = "WEEK1";
		week3 = "WEEK2";
		week4 = "WEEK3";
		week5 = "WEEK4";
	}

tblViewData.rows[rowCount].innerHTML=  
	"<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
	"<td class=\"normalfntMid\"><input type='checkbox'/></td>"+
	"<td class=\"normalfntMid\"><input type='checkbox' onclick=\"fillWeek("+(rowCount)+");\" checked=\"checked\"/></td>"+
	"<td class=\"normalfntRite\">"+XMLstrSchedDate[n].childNodes[0].nodeValue+"</td>"+
	//"<td class=\"normalfntMid\" ><input type=\"text\" value=\""+week+"\" size=\"6\" maxlength=\"6\" style=\"border:hidden;align:center\"></input></td>"+
	"<td class=\"normalfntMid\" id=\""+XMLintSerial[n].childNodes[0].nodeValue+"\">"+
	"<select>"+
	"<option>"+week1+"</option>"+
	"<option>"+week2+"</option>"+
	"<option>"+week3+"</option>"+
	"<option>"+week4+"</option>"+
	"<option>"+week5+"</option>"+
	"</select></td>"+
	"<td class=\"normalfntMid\" id=\""+XMLintSerial[n].childNodes[0].nodeValue+"\">"+nn+"</td>"+	
	"<td class=\"normalfntMid\">"+XMLdeldate[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLorderno[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\"  id=\""+XMLintStyleId[n].childNodes[0].nodeValue+"\">"+XMLstrStyle[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLorderqty[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLdelqty[n].childNodes[0].nodeValue+"</td>"+
    "<td class=\"normalfntRite\">0</td>"+
	"<td class=\"normalfntRite\" >"+XMLmonQtySea[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLmonQtyAir[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\">"+XMLbalqty[n].childNodes[0].nodeValue+"</td>"+
    "<td class=\"normalfntMid\"><img src=\"../../images/add.png\" onclick='loadDestination("+(n+2)+");'></td>"+
	"<td class=\"normalfntMid\"><input type=\"text\" size=\"30\" maxlength=\"100\" value="+XMLrem[n].childNodes[0].nodeValue+"></input></td>"+
	"<td class=\"normalfntRite\">"+XMLstrWashCode[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLdblLength[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLdblWidth[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLdblHight[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\">"+XMLdblPcsPerPack[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\">"+XMLstrDimention[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\" id=\""+XMLintShipmentModeId[n].childNodes[0].nodeValue+"\">"+XMLshipmode[0].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLstrVessal[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLdtVessalDate[n].childNodes[0].nodeValue+"</td>";
	

	}
  }
}

function loadDestination(row){
	var path = "destination.php";	
	    //path += "&orderNo="+orderNo;
	htmlobj=$.ajax({url:path,async:false});
	var text = htmlobj.responseText;
	closeWindow();
	drawPopupAreaLayer(560,360,'frmShipNow',1);
	document.getElementById('frmShipNow').innerHTML=text;	

	var tblViewData = document.getElementById("tblWeeklyMain"); 
	var styleID = tblViewData.rows[row].cells[8].id;
	var delDate = tblViewData.rows[row].cells[6].lastChild.nodeValue;
	var balanceFromMonthly = tblViewData.rows[row].cells[14].lastChild.nodeValue;
	var etdDate = tblViewData.rows[row].cells[3].lastChild.nodeValue;
		var path = "weeklyShipSchedule-xml.php?id=loadDestination";	
	        path += "&styleID="+styleID;
			path += "&delDate="+delDate;
			path += "&etdDate="+etdDate;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLstrDestName = htmlobj.responseXML.getElementsByTagName("strDestName");
	var XMLintDestID   = htmlobj.responseXML.getElementsByTagName("intDestID");
	var XMLdblShipNowQuantitySea = htmlobj.responseXML.getElementsByTagName("dblShipNowQuantitySea");
	var XMLdblShipNowQuantityAir = htmlobj.responseXML.getElementsByTagName("dblShipNowQuantityAir");
	var XMLdblQtyCtn  = htmlobj.responseXML.getElementsByTagName("dblQtyCtn");
	
	var tblDest = document.getElementById("tblDest"); 
		 var newrow = tblDest.insertRow(0);
		 //newrow.className="bcgcolor-tblrowWhite";	
		  tblDest.rows[0].innerHTML= "<td class=\"normalfnt\" style=\"visibility:hidden\">"+styleID+"</td>"+
		                             "<td class=\"normalfnt\" style=\"visibility:hidden\">"+delDate+"</td>"+
									 "<td class=\"normalfnt\" style=\"visibility:hidden\">"+row+"</td>"+
									 "<td class=\"normalfnt_size20Rite\">Balance = </td>"+
									 "<td class=\"normalfnt_size20\" id=\""+etdDate+"\">"+balanceFromMonthly+"</td>";
									 //"<td class=\"normalfnt_size20\" style=\"visibility:hidden\">"+etdDate+"</td>";
	for(var n = 0; n < XMLstrDestName.length; n++) 
	{
	 var rowCount = tblDest.rows.length;
	 var row = tblDest.insertRow(rowCount);
		 row.className="bcgcolor-tblrowWhite";	
		 tblDest.rows[rowCount].innerHTML=  
	"<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
	"<td class=\"normalfnt\" id="+XMLintDestID[n].childNodes[0].nodeValue+">"+XMLstrDestName[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\" id="+XMLdblShipNowQuantitySea[n].childNodes[0].nodeValue+"><input type=\"text\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 7,event);\" maxlength=\"100\" onblur=\"checkBalance("+balanceFromMonthly+");\" value="+XMLdblShipNowQuantitySea[n].childNodes[0].nodeValue+" ></input></td>"+
	"<td class=\"normalfntMid\" id="+XMLdblShipNowQuantityAir[n].childNodes[0].nodeValue+"><input type=\"text\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 7,event);\" maxlength=\"100\" onblur=\"checkBalance("+balanceFromMonthly+");\" value="+XMLdblShipNowQuantityAir[n].childNodes[0].nodeValue+" ></input></td>"+
		"<td class=\"normalfntMid\" ><input type=\"text\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 7,event);\" maxlength=\"100\" value="+XMLdblQtyCtn[n].childNodes[0].nodeValue+"></input></td>";

	}
	
}

function checkBalance(balanceFromMonthly){
var tblDest  = document.getElementById("tblDest");  
var length = tblDest.rows.length;
var totQtyNow = 0;
var totQtyEarly = 0;
var changeQty = 0;

//-----------early qty-------------------------
for(var i=2;i<length;i++){
 var seaQtyEarly = parseFloat(tblDest.rows[i].cells[2].id);	
 if(isNaN(seaQtyEarly)){
	seaQtyEarly=0; 
 }
 var airQtyEarly = parseFloat(tblDest.rows[i].cells[3].id);
 if(isNaN(airQtyEarly)){
	airQtyEarly=0;
 }
  totQtyEarly += (seaQtyEarly + airQtyEarly); 
 }

//----------now qty---------------------------

 for(var i=2;i<length;i++){
 var seaQtyNow = parseFloat(tblDest.rows[i].cells[2].lastChild.value);	
 if(isNaN(seaQtyNow)){
	seaQtyNow=0; 
 }
 var airQtyNow = parseFloat(tblDest.rows[i].cells[3].lastChild.value);
 if(isNaN(airQtyNow)){
	airQtyNow=0;
 }
  totQtyNow += (seaQtyNow + airQtyNow); 
 }
 

  changeQty = totQtyNow-totQtyEarly;


//alert(changeQty);alert(balanceFromMonthly);
  if(changeQty > balanceFromMonthly){
  alert("Ship Now Qty Should less than Balance Qty");	
  return false;
 }
}



function fillWeek(rowCount){
	var tblViewData      = document.getElementById("tblWeeklyMain"); 
	
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	/*
    if(txtweek1.style.color == "red" || txtweek2.style.color == "red" || txtweek3.style.color == "red" || txtweek4.style.color == "red" ||     txtweek5.style.color == "red" == true){*/
	if(tblViewData.rows[rowCount].cells[2].childNodes[0].checked == true){
	
	if(txtweek1.style.color == "red"){
	tblViewData.rows[rowCount].cells[4].childNodes[0].value="WEEK 1";	
	}
	if(txtweek2.style.color == "red"){
	tblViewData.rows[rowCount].cells[4].childNodes[0].value="WEEK 2";	
	}
	if(txtweek3.style.color == "red"){
	tblViewData.rows[rowCount].cells[4].childNodes[0].value="WEEK 3";	
	}
	if(txtweek4.style.color == "red"){
	tblViewData.rows[rowCount].cells[4].childNodes[0].value="WEEK 4";	
	}
	if(txtweek5.style.color == "red"){
	tblViewData.rows[rowCount].cells[4].childNodes[0].value="WEEK 5";	
	}
  }else{
	 tblViewData.rows[rowCount].cells[4].childNodes[0].value=""; 
  }
}

 function checkExists(){	 
  var scheddate   = document.getElementById("cboWeeklySchedNo").value;
  var tblViewData = document.getElementById("tblWeeklyMain");	
  var no=0;
   for(var loop=1;loop<tblViewData.rows.length;loop++)
   {
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{		
	 no+=1;
	}
   }

   if(no==0){
	alert("Please select PO's to save");   
	return false;
   }
	var path = "weeklySipmentSchedule-db.php?id=checkExist";
	path += "&scheddate="+scheddate;
	htmlobj=$.ajax({url:path,async:false}); 
	var res = htmlobj.responseText;	
	if((res*1)=="1"){

     var answer = confirm("Schedule No already exists.Do you want to replace?");
     if (answer){
     deleteBeforeSave();
	 }
     else{
     
	 }
	}else{
	saveWeeklyShipmentSched();	
	}
 }


function deleteBeforeSave(){
	var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;
	var tblDest  = document.getElementById("tblDest");  
	var styleID = tblDest.rows[0].cells[0].lastChild.nodeValue;
    var delDate = tblDest.rows[0].cells[1].lastChild.nodeValue;
	var etdDate = tblDest.rows[0].cells[4].id;
	var path = "weeklySipmentSchedule-db.php?id=deleteBeforeSaveWeekly";
	    path += "&intScheduleNo="+intScheduleNo;
	    path += "&styleID="+styleID;
	    path += "&delDate="+delDate;
		path += "&etdDate="+etdDate;
	htmlobj=$.ajax({url:path,async:false});  
    var res = htmlobj.responseText;	
	if((parseFloat(res))=="1"){
	saveWeeklyWithDest();
	}
 }
 
 function saveWeeklyWithDest(){
 var tblDest  = document.getElementById("tblDest");  
 var tblViewData = document.getElementById("tblWeeklyMain");
 var balanceFromMonthly = tblDest.rows[0].cells[4].childNodes[0].nodeValue;//return false;
 //checkBalance(balanceFromMonthly);
 
 var length = tblDest.rows.length;
var totQtyNow = 0;
var totQtyEarly = 0;
var changeQty = 0;

//-----------early qty-------------------------
for(var i=2;i<length;i++){
 var seaQtyEarly = parseFloat(tblDest.rows[i].cells[2].id);	
 if(isNaN(seaQtyEarly)){
	seaQtyEarly=0; 
 }
 var airQtyEarly = parseFloat(tblDest.rows[i].cells[3].id);
 if(isNaN(airQtyEarly)){
	airQtyEarly=0;
 }
  totQtyEarly += (seaQtyEarly + airQtyEarly); 
 }

//----------now qty---------------------------

 for(var i=2;i<length;i++){
 var seaQtyNow = parseFloat(tblDest.rows[i].cells[2].lastChild.value);	
 if(isNaN(seaQtyNow)){
	seaQtyNow=0; 
 }
 var airQtyNow = parseFloat(tblDest.rows[i].cells[3].lastChild.value);
 if(isNaN(airQtyNow)){
	airQtyNow=0;
 }
  totQtyNow += (seaQtyNow + airQtyNow); 
 }
 

  changeQty = totQtyNow-totQtyEarly;


//alert(changeQty);alert(balanceFromMonthly);
  if(changeQty > balanceFromMonthly){
  alert("Ship Now Qty Should less than Balance Qty");	
  return false;
 }

 var noOfDest = tblDest.rows.length;
 var styleID = tblDest.rows[0].cells[0].lastChild.nodeValue;
 var delDate = tblDest.rows[0].cells[1].lastChild.nodeValue;
 var rowNo   = tblDest.rows[0].cells[2].lastChild.nodeValue;
 var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;	
 var count=0;
 for(var i=2;i<=noOfDest;i++){
   var etdDate    = tblViewData.rows[rowNo].cells[3].lastChild.nodeValue;
	var week       = tblViewData.rows[rowNo].cells[4].childNodes[0].value;
	var intSerial  = tblViewData.rows[rowNo].cells[5].id;
	var deldate    = tblViewData.rows[rowNo].cells[6].lastChild.nodeValue;
	var styleno    = tblViewData.rows[rowNo].cells[8].id;
	var orderqty   = tblViewData.rows[rowNo].cells[9].lastChild.nodeValue;
	var deliveryqty = tblViewData.rows[rowNo].cells[10].lastChild.nodeValue;
	var exportQty   = tblViewData.rows[rowNo].cells[11].lastChild.nodeValue;
	var monQtySea   = tblViewData.rows[rowNo].cells[12].lastChild.nodeValue;
	var monQtyAir   = tblViewData.rows[rowNo].cells[13].lastChild.nodeValue;
	var balQty      = tblViewData.rows[rowNo].cells[14].lastChild.nodeValue;
	//var shipNowQtySea = tblViewData.rows[loop].cells[15].childNodes[0].value;
	//var shipNowQtyAir = tblViewData.rows[loop].cells[16].childNodes[0].value;
    var remark      = tblViewData.rows[rowNo].cells[16].childNodes[0].value;
	var washCode    = tblViewData.rows[rowNo].cells[17].lastChild.nodeValue;

	if(tblViewData.rows[rowNo].cells[18].lastChild!=null){
	var length      = tblViewData.rows[rowNo].cells[18].lastChild.nodeValue;
	}else{
	var length = 0;	
	}

	
	if(tblViewData.rows[rowNo].cells[19].lastChild!=null){
	var width   = tblViewData.rows[rowNo].cells[19].lastChild.nodeValue;
	}else{
	var width = 0;	
	}
	
	if(tblViewData.rows[rowNo].cells[20].lastChild!=null){
	var hiegth   = tblViewData.rows[rowNo].cells[20].lastChild.nodeValue;
	}else{
	var hiegth = 0;	
	}

	var pPerPack    = tblViewData.rows[rowNo].cells[21].lastChild.nodeValue;
	var dimention   = tblViewData.rows[rowNo].cells[22].lastChild.nodeValue;
	var mode   = tblViewData.rows[rowNo].cells[23].id;
	var vessel   = tblViewData.rows[rowNo].cells[24].lastChild.nodeValue;
	var vesselDate   = tblViewData.rows[rowNo].cells[25].lastChild.nodeValue;
 
    var destination     = tblDest.rows[i].cells[1].id;
	var shipNowQtySea   = tblDest.rows[i].cells[2].lastChild.value;
	var shipNowQtyAir   = tblDest.rows[i].cells[3].lastChild.value;
	var qtyCtn          = tblDest.rows[i].cells[4].lastChild.value;
	
    var url  = "weeklySipmentSchedule-db.php?id=save";
	    url += "&intScheduleNo="+intScheduleNo;
	    url += "&week="+week;
		url += "&etdDate="+etdDate;
		url += "&deldate="+deldate;
		url += "&styleno="+styleno;
		url += "&orderqty="+orderqty;
		url += "&deliveryqty="+deliveryqty;
		url += "&exportQty="+exportQty;
		url += "&monQtySea="+monQtySea;
		url += "&monQtyAir="+monQtyAir;
		url += "&balQty="+balQty;
		url += "&destination="+destination;
		url += "&shipnowqtySea="+shipNowQtySea;	
		url += "&shipnowqtyAir="+shipNowQtyAir;	
		url += "&qtyCtn="+qtyCtn;	
		url += "&remark="+remark;
		url += "&washCode="+washCode;
		url += "&length="+length;
		url += "&width="+width; 
		url += "&hiegth="+hiegth;
		url += "&pPerPack="+pPerPack;
		url += "&dimention="+dimention;
		url += "&mode="+mode;
		url += "&vessel="+vessel;
		url += "&vesselDate="+vesselDate;
		htmlobj2=$.ajax({url:url,async:false});

		count++;  

		if(count == (noOfDest-2)){
		alert(htmlobj2.responseText);	
		closeWindow();
		loadWeeklySchedule();		
	   }
  }
 }

 function saveWeeklyShipmentSched(){
   var tblViewData = document.getElementById("tblWeeklyMain");	
   var no=0;
   for(var loop=1;loop<tblViewData.rows.length;loop++)
   {
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{		
	 no+=1;
	}
   }

    var count=0; 
    var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;	
	for(var loop=2;loop<tblViewData.rows.length;loop++)
	{
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{	
	count++;
    
	var etdDate    = tblViewData.rows[loop].cells[3].lastChild.nodeValue;
	var week       = tblViewData.rows[loop].cells[4].childNodes[0].value;
	var intSerial  = tblViewData.rows[loop].cells[5].id;
	var deldate    = tblViewData.rows[loop].cells[6].lastChild.nodeValue;
	var styleno    = tblViewData.rows[loop].cells[8].id;
	var orderqty   = tblViewData.rows[loop].cells[9].lastChild.nodeValue;
	var deliveryqty = tblViewData.rows[loop].cells[10].lastChild.nodeValue;
	var exportQty   = tblViewData.rows[loop].cells[11].lastChild.nodeValue;
	var monQtySea   = tblViewData.rows[loop].cells[12].lastChild.nodeValue;
	var monQtyAir   = tblViewData.rows[loop].cells[13].lastChild.nodeValue;
	var balQty      = tblViewData.rows[loop].cells[14].lastChild.nodeValue;
	var shipNowQtySea = tblViewData.rows[loop].cells[15].childNodes[0].value;
	var shipNowQtyAir = tblViewData.rows[loop].cells[16].childNodes[0].value;
    var remark      = tblViewData.rows[loop].cells[18].childNodes[0].value;
	var washCode    = tblViewData.rows[loop].cells[19].lastChild.nodeValue;

	if(tblViewData.rows[loop].cells[20].lastChild!=null){
	var length      = tblViewData.rows[loop].cells[20].lastChild.nodeValue;
	}else{
	var length = 0;	
	}

	
	if(tblViewData.rows[loop].cells[21].lastChild!=null){
	var width   = tblViewData.rows[loop].cells[21].lastChild.nodeValue;
	}else{
	var width = 0;	
	}
	
	if(tblViewData.rows[loop].cells[22].lastChild!=null){
	var hiegth   = tblViewData.rows[loop].cells[22].lastChild.nodeValue;
	}else{
	var hiegth = 0;	
	}

	var pPerPack    = tblViewData.rows[loop].cells[23].lastChild.nodeValue;
	var dimention   = tblViewData.rows[loop].cells[24].lastChild.nodeValue;
	var mode   = tblViewData.rows[loop].cells[25].id;
	var vessel   = tblViewData.rows[loop].cells[26].lastChild.nodeValue;
	var vesselDate   = tblViewData.rows[loop].cells[27].lastChild.nodeValue;

	
	var url  = "weeklySipmentSchedule-db.php?id=save";
	    url += "&intScheduleNo="+intScheduleNo;
	    url += "&week="+week;
		url += "&etdDate="+etdDate;
		url += "&deldate="+deldate;
		url += "&styleno="+styleno;
		url += "&orderqty="+orderqty;
		url += "&deliveryqty="+deliveryqty;
		url += "&exportQty="+exportQty;
		url += "&monQtySea="+monQtySea;
		url += "&monQtyAir="+monQtyAir;
		url += "&balQty="+balQty;
		url += "&shipnowqtySea="+shipNowQtySea;	
		url += "&shipnowqtyAir="+shipNowQtyAir;	
		url += "&remark="+remark;
		url += "&washCode="+washCode;
		url += "&length="+length;
		url += "&width="+width; 
		url += "&hiegth="+hiegth;
		url += "&pPerPack="+pPerPack;
		url += "&dimention="+dimention;
		url += "&mode="+mode;
		url += "&vessel="+vessel;
		url += "&vesselDate="+vesselDate;
		
		htmlobj2=$.ajax({url:url,async:false});	
        if(htmlobj2.readyState == 4 && htmlobj2.status == 200 ) 
        {

	     if(count == (no)){	
	     alert("Saved Successfully");	
		 }
	    }

  }
 }
}

function confirmWeekly(){
	var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;
	var answer = confirm ("Do you want confirm the weekly plan?");
    if (answer){
    var path = "weeklySipmentSchedule-db.php?id=confirmWeekly";
	path += "&intScheduleNo="+intScheduleNo;
	htmlobj=$.ajax({url:path,async:false});
	if(htmlobj.readyState == 4 && htmlobj.status == 200 ) 
    {
		//alert(htmlobj.responseText);
	alert("Weekly plan confirmed.");
    }
	}
    else{
    return false;
	}


}
 
 function saveWeeklyShipmentSchedRequest()
{


		if(xmlHttp1[this.index].readyState == 4 && xmlHttp1[this.index].status == 200 ) 
		{
			var cbointStyleId =xmlHttp1[this.index].responseText;

			if(cbointStyleId==1)
			{
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				//alert(pub_intxmlHttp_count);
				if (pub_intxmlHttp_count ==0)
				{
					//var	cbointStyleId1		= document.getElementById("cbointStyleId").options[document.getElementById("cbointStyleId").selectedIndex].text;
					//alert("Style No  " + cbointStyleId1 + " Saved successfully !");
					//document.getElementById("cbointStyleId").value="";			
                     //newPage();	
					 alert("Saved Successfully");
				}
			}
			else{
				alert( "details saving error...");
			}
		}
}

//--------------------------------------------------------------------------------------------------------------------------

function modifyWeekShipmentSchedule(){
	window.open(pub_urlMonShip+"modifyWeekShipSchedule.php",'frmMonShipSched'); 
}


//---------------------------------------------------------Modify--------------------------------------------------------


function loadWeeklyScheduleModify(){
	var tblTable    = 	document.getElementById("tblWeeklyModify");
	var binCount	=	tblTable.rows.length;
	for(var loop=2;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}

	var cboStyleNo = document.getElementById('cboStyleNo').value;
	var cboOrderNo = document.getElementById('cboOrderNo').value;
	var cboBuyer = document.getElementById('cboBuyer').value;
	var cboWeeklySchedNo = document.getElementById('cboWeeklySchedNo').value;
	var path = "weeklyShipSchedule-xml.php?id=loadWeeklyModify";
	path += "&StyleNo="+cboStyleNo;
	path += "&OrderNo="+cboOrderNo;
	path += "&cboBuyer="+cboBuyer;
	path += "&WeeklySchedNo="+cboWeeklySchedNo;

	htmlobj2=$.ajax({url:path,async:false});  
	
   if(htmlobj2.readyState == 4 && htmlobj2.status == 200 ) 
   {
	var tblViewData      = document.getElementById("tblWeeklyModify"); 
	var XMLstrWeek      = htmlobj2.responseXML.getElementsByTagName("strWeek");
	var XMLetdDate      = htmlobj2.responseXML.getElementsByTagName("etdDate");
	var XMLdeldate       = htmlobj2.responseXML.getElementsByTagName("deldate");
	var XMLorderno       = htmlobj2.responseXML.getElementsByTagName("orderno");
	var XMLintStyleId    = htmlobj2.responseXML.getElementsByTagName("intStyleId");
	var XMLstrStyle   = htmlobj2.responseXML.getElementsByTagName("strStyle");
	var XMLorderqty      = htmlobj2.responseXML.getElementsByTagName("orderqty");
    var XMLdelqty        = htmlobj2.responseXML.getElementsByTagName("delqty");
	var XMLdescription   = htmlobj2.responseXML.getElementsByTagName("description");
	var XMLunitprice	 = htmlobj2.responseXML.getElementsByTagName("unitprice");
	var XMLmerchandiser	 = htmlobj2.responseXML.getElementsByTagName("merchandiser");
	var XMLbuyer         = htmlobj2.responseXML.getElementsByTagName("buyer");
	var XMLintBuyerID    = htmlobj2.responseXML.getElementsByTagName("intBuyerID");
	var XMLscheduledate	 = htmlobj2.responseXML.getElementsByTagName("scheduledate");
	var XMLdblPcsPerPack = htmlobj2.responseXML.getElementsByTagName("dblPcsPerPack");
	var XMLshipmode      = htmlobj2.responseXML.getElementsByTagName("shipmode");
	var XMLintShipmentModeId      = htmlobj2.responseXML.getElementsByTagName("intShipmentModeId");
	var XMLstrVessal     = htmlobj2.responseXML.getElementsByTagName("strVessal");
	var XMLdtVessalDate  = htmlobj2.responseXML.getElementsByTagName("dtVessalDate");
	var XMLstrWearhouse  = htmlobj2.responseXML.getElementsByTagName("strWearhouse");
	var XMLstrDimention  = htmlobj2.responseXML.getElementsByTagName("strDimention");
	var XMLcomnam        = htmlobj2.responseXML.getElementsByTagName("comnam");
	var XMLmonQtySea        = htmlobj2.responseXML.getElementsByTagName("monQtySea");
	var XMLmonQtyAir        = htmlobj2.responseXML.getElementsByTagName("monQtyAir");
	var XMLweeklyShipNowQtySea = htmlobj2.responseXML.getElementsByTagName("weeklyShipNowQtySea");
	var XMLweeklyShipNowQtyAir = htmlobj2.responseXML.getElementsByTagName("weeklyShipNowQtyAir");
	var XMLstrColor        = htmlobj2.responseXML.getElementsByTagName("strColor");
	var XMLdblLength  = htmlobj2.responseXML.getElementsByTagName("dblLength");
	var XMLdblHight  = htmlobj2.responseXML.getElementsByTagName("dblHight");
	var XMLdblWidth  = htmlobj2.responseXML.getElementsByTagName("dblWidth");
	var XMLCBM  = htmlobj2.responseXML.getElementsByTagName("CBM");
	var XMLdbllblcomposition  = htmlobj2.responseXML.getElementsByTagName("dbllblcomposition");
	var XMLstrRemarks  = htmlobj2.responseXML.getElementsByTagName("strRemarks");
	var XMLbalance  = htmlobj2.responseXML.getElementsByTagName("balance");
	var XMLstrWashCode  = htmlobj2.responseXML.getElementsByTagName("strWashCode");
    var XMLdblPcsPerPack  = htmlobj2.responseXML.getElementsByTagName("dblPcsPerPack");

	for(var n = 0; n < XMLorderno.length; n++) 
	{
	var rowCount = tblViewData.rows.length;
	var row = tblViewData.insertRow(rowCount);
		row.className="bcgcolor-tblrowWhite";
	var nn = n+1;		 		
    var intStyleId =  XMLintStyleId[n].childNodes[0].nodeValue;

tblViewData.rows[rowCount].innerHTML=  
	"<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
	"<td class=\"normalfntMid\"><input type='checkbox'/></td>"+
	"<td class=\"normalfntMid\"><input type='checkbox' onclick=\"fillWeekModify("+(rowCount)+");\" checked=\"checked\"/></td>"+
	"<td class=\"normalfntMid\">"+XMLetdDate[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\" ><input type=\"text\" size=\"6\" maxlength=\"6\" style=\"border:hidden\" readonly value=\""+XMLstrWeek[n].childNodes[0].nodeValue+"\"/></td>"+
	"<td class=\"normalfntMid\" >"+nn+"</td>"+	
	"<td class=\"normalfntMid\">"+XMLdeldate[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLorderno[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\"  id=\""+XMLintStyleId[n].childNodes[0].nodeValue+"\">"+XMLstrStyle[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLorderqty[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLdelqty[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLmonQtySea[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">"+XMLmonQtyAir[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\">"+XMLbalance[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\"><input type=\"text\" size=\"10\" maxlength=\"100\" value=\""+XMLweeklyShipNowQtySea[n].childNodes[0].nodeValue+"\"/></td>"+
	"<td class=\"normalfntMid\"><input type=\"text\" size=\"10\" maxlength=\"100\" value=\""+XMLweeklyShipNowQtyAir[n].childNodes[0].nodeValue+"\"/></td>"+
	"<td class=\"normalfntMid\"><input type=\"text\" size=\"30\" maxlength=\"100\" value=\""+XMLstrRemarks[n].childNodes[0].nodeValue+"\"/></td>"+
	"<td class=\"normalfntMid\">"+XMLstrWashCode[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntRite\">0</td>"+
	"<td class=\"normalfntRite\">0</td>"+
	"<td class=\"normalfntRite\">0</td>"+
	"<td class=\"normalfntRite\">"+XMLdblPcsPerPack[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfntMid\">"+XMLstrDimention[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\" id=\""+XMLintShipmentModeId[n].childNodes[0].nodeValue+"\">"+XMLshipmode[0].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLstrVessal[n].childNodes[0].nodeValue+"</td>"+
	"<td class=\"normalfnt\">"+XMLdtVessalDate[n].childNodes[0].nodeValue+"</td>";
	
var txtweek1 = document.getElementById("txtweek1");
var txtweek2 = document.getElementById("txtweek2");
var txtweek3 = document.getElementById("txtweek3");
var txtweek4 = document.getElementById("txtweek4");
var txtweek5 = document.getElementById("txtweek5");
txtweek1.style.color = "red";
txtweek2.style.color = "black";
txtweek3.style.color = "black";
txtweek4.style.color = "black";
txtweek5.style.color = "black";
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

//---------------------------------------------------------UPDATE-------------------------------------------------------------

 function deleteBeforeUpdate(){
  var scheddate   = document.getElementById("cboWeeklySchedNo").value;
  var tblViewData = document.getElementById("tblWeeklyModify");	
  var no=0;
   for(var loop=2;loop<tblViewData.rows.length;loop++)
   {
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{		
	 no+=1;
	}else{
	var text = ""+loop-1+"";
	var textLength = (text.length);
	var charIndex = text.charAt(textLength-1);
	var  postfix = "";
	if(charIndex != '1' || charIndex != '2' || charIndex != '3'){
	 postfix = "th";	
	}
	if(charIndex == '1'){
	 postfix = "st";	
	}
	if(charIndex == '2'){
	 postfix = "nd";	
	}
	if(charIndex == '3'){
	 postfix = "rd";	
	}
	alert("Please assign a week for "+(loop-1)+""+postfix+" row");	
	return false;
	}
   }

   if(no==0){
	alert("Please select PO's to update");   
	return false;
   }

	var path = "weeklySipmentSchedule-db.php?id=deleteBeforeUpdate";
	path += "&scheddate="+scheddate;
	htmlobj=$.ajax({url:path,async:false});  
    var res = htmlobj.responseText;	
	if((res*1)=="1"){
    updateWeeklyShipmentSched();
	}
 }
 

 function updateWeeklyShipmentSched(){	
   var tblViewData = document.getElementById("tblWeeklyModify");	
   var no=0;
   for(var loop=2;loop<tblViewData.rows.length;loop++)
   {
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{		
	 no+=1;
	}
   }

    pub_intxmlHttp_count = no;
    var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;	
	for(var loop=2;loop<tblViewData.rows.length;loop++)
	{
	if(tblViewData.rows[loop].cells[2].childNodes[0].checked == true)
	{

    var week       = tblViewData.rows[loop].cells[3].childNodes[0].value;
	var deldate    = tblViewData.rows[loop].cells[5].lastChild.nodeValue;
	var styleno    = tblViewData.rows[loop].cells[7].id;
	var orderqty   = tblViewData.rows[loop].cells[8].lastChild.nodeValue;
	var actualqty  = tblViewData.rows[loop].cells[9].lastChild.nodeValue;
	var deliveryqty = tblViewData.rows[loop].cells[10].lastChild.nodeValue;
	var exportQty   = tblViewData.rows[loop].cells[11].lastChild.nodeValue;
	var monQtySea   = tblViewData.rows[loop].cells[12].lastChild.nodeValue;
	var monQtyAir   = tblViewData.rows[loop].cells[13].lastChild.nodeValue;
	var balQty      = tblViewData.rows[loop].cells[14].lastChild.nodeValue;
	var shipNowQtySea  = tblViewData.rows[loop].cells[15].childNodes[0].value;
	var shipNowQtyAir  = tblViewData.rows[loop].cells[16].childNodes[0].value;
	var ctn         = tblViewData.rows[loop].cells[17].lastChild.nodeValue;
	var color       = tblViewData.rows[loop].cells[18].lastChild.nodeValue;
    var remark      = tblViewData.rows[loop].cells[19].childNodes[0].value;
	var perPackCode = tblViewData.rows[loop].cells[20].lastChild.nodeValue;
	var washCode    = tblViewData.rows[loop].cells[21].lastChild.nodeValue;
    var isdNo       = tblViewData.rows[loop].cells[22].lastChild.nodeValue;
	var doNo        = tblViewData.rows[loop].cells[23].lastChild.nodeValue;
    var dcNo        = tblViewData.rows[loop].cells[24].lastChild.nodeValue;
	var length      = tblViewData.rows[loop].cells[25].lastChild.nodeValue;
	var width       = tblViewData.rows[loop].cells[26].lastChild.nodeValue;
	var hiegth      = tblViewData.rows[loop].cells[27].lastChild.nodeValue;
	var pPerPack    = tblViewData.rows[loop].cells[28].lastChild.nodeValue;
	var CBM         = tblViewData.rows[loop].cells[29].lastChild.nodeValue;
	
	if(tblViewData.rows[loop].cells[30].lastChild!=null){
	var labelComp   = tblViewData.rows[loop].cells[30].lastChild.nodeValue;
	}else{
	var labelComp = 0;	
	}
	

	if(tblViewData.rows[loop].cells[31].lastChild!=null){
	var warehouse   = tblViewData.rows[loop].cells[31].lastChild.nodeValue;
	}else{
	var warehouse = 0;	
	}
	
	var dimention   = tblViewData.rows[loop].cells[32].lastChild.nodeValue;
	if(tblViewData.rows[loop].cells[33].lastChild!=null){
	var mode        = tblViewData.rows[loop].cells[33].lastChild.nodeValue;
	}else{
	var mode = 0;
	}
	if(tblViewData.rows[loop].cells[34].lastChild!=null){
	var vessel        = tblViewData.rows[loop].cells[34].lastChild.nodeValue;
	}else{
	var vessel = 0;
	}
	if(tblViewData.rows[loop].cells[35].lastChild!=null){
	var vesselDate        = tblViewData.rows[loop].cells[35].lastChild.nodeValue;
	}else{
	var vesselDate = 0;
	}
	if(tblViewData.rows[loop].cells[36].lastChild!=null){
	var scheduleDate        = tblViewData.rows[loop].cells[36].lastChild.nodeValue;
	}else{
	var scheduleDate = 0;
	}
	if(tblViewData.rows[loop].cells[37].lastChild!=null){
	var material        = tblViewData.rows[loop].cells[37].lastChild.nodeValue;
	}else{
	var material = 0;
	}
	if(tblViewData.rows[loop].cells[38].lastChild!=null){
	var exeRate        = tblViewData.rows[loop].cells[38].lastChild.nodeValue;
	}else{
	var exeRate = 0;
	}
	if(tblViewData.rows[loop].cells[39].lastChild!=null){
	var ctnGroupNo        = tblViewData.rows[loop].cells[39].lastChild.nodeValue;
	}else{
	var ctnGroupNo = 0;
	}

	createXMLHttpRequest1(loop);
	xmlHttp1[loop].onreadystatechange = updateWeeklyShipmentSchedRequest;
	
	var url  = "weeklySipmentSchedule-db.php?id=update";
	    url += "&week="+week;
	    url += "&intScheduleNo="+intScheduleNo;
		url += "&deldate="+deldate;
		url += "&styleno="+styleno;
		url += "&orderqty="+orderqty;
		url += "&deliveryqty="+deliveryqty;
		url += "&actualqty="+actualqty;
		url += "&exportQty="+exportQty;
		url += "&monQtySea="+monQtySea;
		url += "&monQtyAir="+monQtyAir;
		url += "&balQty="+balQty;
		url += "&shipnowqtySea="+shipNowQtySea;
		url += "&shipnowqtyAir="+shipNowQtyAir;
		url += "&ctn="+ctn;
		url += "&color="+color;
		url += "&remark="+remark;
		url += "&perPackCode="+perPackCode;
		url += "&washCode="+washCode;
		url += "&isdNo="+isdNo;
		url += "&doNo="+doNo;
		url += "&dcNo="+dcNo;
		url += "&length="+length;
		url += "&width="+width; 
		url += "&hiegth="+hiegth;
		url += "&pPerPack="+pPerPack;
		url += "&CBM="+CBM;
		url += "&labelComp="+labelComp;
		url += "&warehouse="+warehouse;
		url += "&dimention="+dimention;
		url += "&mode="+mode;
		url += "&vessel="+vessel;
		url += "&vesselDate="+vesselDate;
		url += "&scheduleDate="+scheduleDate;
		url += "&material="+material;
		url += "&exeRate="+exeRate;
		url += "&ctnGroupNo="+ctnGroupNo;

		
	xmlHttp1[loop].index = loop;
	xmlHttp1[loop].open("GET",url,true);
	xmlHttp1[loop].send(null);

  }
 }
}
 
 function updateWeeklyShipmentSchedRequest()
{


		if(xmlHttp1[this.index].readyState == 4 && xmlHttp1[this.index].status == 200 ) 
		{
			var cbointStyleId =xmlHttp1[this.index].responseText;

			if(cbointStyleId==1)
			{
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				//alert(pub_intxmlHttp_count);
				if (pub_intxmlHttp_count ==0)
				{
					//var	cbointStyleId1		= document.getElementById("cbointStyleId").options[document.getElementById("cbointStyleId").selectedIndex].text;
					//alert("Style No  " + cbointStyleId1 + " Saved successfully !");
					//document.getElementById("cbointStyleId").value="";			
                     //newPage();	
					 alert("Saved Successfully");
				}
			}
			else{
				alert( "details saving error...");
			}
		}
}

function fillWeekModify(rowCount){
	var tblViewData      = document.getElementById("tblWeeklyModify"); 
	
	var txtweek1 = document.getElementById("txtweek1");
	var txtweek2 = document.getElementById("txtweek2");
	var txtweek3 = document.getElementById("txtweek3");
	var txtweek4 = document.getElementById("txtweek4");
	var txtweek5 = document.getElementById("txtweek5");
	/*
    if(txtweek1.style.color == "red" || txtweek2.style.color == "red" || txtweek3.style.color == "red" || txtweek4.style.color == "red" ||     txtweek5.style.color == "red" == true){*/
	if(tblViewData.rows[rowCount].cells[2].childNodes[0].checked == true){
	
	if(txtweek1.style.color == "red"){
	tblViewData.rows[rowCount].cells[3].childNodes[0].value="WEEK 1";	
	}
	if(txtweek2.style.color == "red"){
	tblViewData.rows[rowCount].cells[3].childNodes[0].value="WEEK 2";	
	}
	if(txtweek3.style.color == "red"){
	tblViewData.rows[rowCount].cells[3].childNodes[0].value="WEEK 3";	
	}
	if(txtweek4.style.color == "red"){
	tblViewData.rows[rowCount].cells[3].childNodes[0].value="WEEK 4";	
	}
	if(txtweek5.style.color == "red"){
	tblViewData.rows[rowCount].cells[3].childNodes[0].value="WEEK 5";	
	}
  }else{
	 tblViewData.rows[rowCount].cells[3].childNodes[0].value=""; 
  }
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo);
	
	var len = tblMain.rows.length;

	for(var i=2;i<(parseFloat(len)-1);i++){
	 tblMain.rows[i].cells[4].childNodes[0].nodeValue=i;	
	}
}

//-----------------------------------------------------------------------------------

function weeklyReport(){
var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;	
window.open(pub_urlMonShip+"weeklyShipScheduleRep.php?intScheduleNo=" + intScheduleNo,'frmMonShipSched'); 	
}

//-----------------------------------------------------------------------------------

function saveWeekAndRemarks(){
 var tblMain = document.getElementById("tblWeeklyMain");	
 var intScheduleNo = document.getElementById("cboWeeklySchedNo").value;		
 var len = tblMain.rows.length;
 var ii=1;
 for(var i=2;i<len;i++){
	 var etdDate = tblMain.rows[i].cells[3].childNodes[0].nodeValue;
	 var delDate = tblMain.rows[i].cells[6].childNodes[0].nodeValue;
	 var styleID = tblMain.rows[i].cells[8].id;
	 var week = tblMain.rows[i].cells[4].childNodes[0].value;
	 var remarks = tblMain.rows[i].cells[16].childNodes[0].value;
	 	var path = "weeklySipmentSchedule-db.php?id=saveWeekAndRemarks";
	        path += "&intScheduleNo="+intScheduleNo;
			path += "&etdDate="+etdDate;
			path += "&delDate="+delDate;
			path += "&styleID="+styleID;
			path += "&week="+week;
			path += "&remarks="+remarks;
	    htmlobj=$.ajax({url:path,async:false}); 
		if(htmlobj.responseText == 1 || htmlobj.responseText == 2){
		 ii++;
		 if(ii == len-2 && htmlobj.responseText == 2){
		  alert("Please select Qty's");	 
		 }
         else if(ii == len-2){
		 alert("Updated Successfully");	
		 }
		}
 }
}

