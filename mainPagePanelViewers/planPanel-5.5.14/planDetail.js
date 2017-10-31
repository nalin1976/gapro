//var xmlHttp;
//......malinga
var pnl_planUrl = "mainPagePanelViewers/planPanel/";


function setPanelPLAN(){
	//LoadMrnNo();
	//loadPlanDetailsToGrid();
	var frm=document.getElementById("frm");
	frm.submit();
}
function createXMLHttpRequest(){
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
	}
}
function loadPlanDetailsToGrid()
{	
	ClearTable("plantbl");
	createXMLHttpRequest();

	var url =  pnl_planUrl+'planDetailXML.php?RequestType=loadPlanDetailsToGrid';
	var htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGridPlan(htmlobj);
	//alert(htmlobj);
}

function CreatePopUpItemGridPlan(htmlobj)
{
	var XMLintStyleId	   = htmlobj.responseXML.getElementsByTagName("StyleId");
	var XMLstrOrderNo 		= htmlobj.responseXML.getElementsByTagName("strOrderNo");
	var XMLdtmOCD_Date  = htmlobj.responseXML.getElementsByTagName("dtmOCD_Date");
	var XMLdtmOCD_Date   = htmlobj.responseXML.getElementsByTagName("dtmOCD_Date");	
	
	var tbl 		= document.getElementById('plantbl');
	
	alert( XMLintStyleId.length);
	
	for(loop=0;loop< XMLintStyleId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "gridbodyTxtPnl";
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		
		var cell = row.insertCell(0);
		cell.className ="normalfnt";
		cell.style="text-align:center";
		cell.setAttribute('height','30');
		cell.setAttribute('width','25%');
		cell.innerHTML ="<input type=\"checkbox\" id=\"chkAll\" >";
		
		
		var cell = row.insertCell(1);//style no
		cell.className ="normalfnt";
		cell.removeAttribute("width");
		cell.setAttribute('width','10%');
		cell.innerHTML =XMLintStyleId[loop].childNodes[0].nodeValue;
		
		
		var cell = row.insertCell(2);//order no
		cell.className ="normalfnt";
		cell.setAttribute('width','10%')
		cell.innerHTML = XMLstrOrderNo[loop].childNodes[0].nodeValue;
		
				
		var cell = row.insertCell(3);//factory
		cell.className ="normalfnt";
		cell.setAttribute('width','20%');
		cell.innerHTML = "c";
		
		
		var cell = row.insertCell(4);//line
		cell.className ="normalfnt";
		var obj="<select id=\"comLineNo\" class=\"txtbox\" ></select>";
		cell.setAttribute('width','10%');
		cell.id = loop;
		cell.innerHTML = obj;
		
		
		var cell = row.insertCell(5);//date from
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.innerHTML =XMLdtmOCD_Date[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(6);//date to
		cell.className ="normalfnt";
		cell.setAttribute('width','15%');
		cell.innerHTML =XMLdtmOCD_Date[loop].childNodes[0].nodeValue;
		

	}
	
}

function IssueNote1(obj)
{
	var id=obj.id	
	var myWindow = window.open('issue/issues.php?id='+id);	
}

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function CheckAll(){
	var chkall=document.getElementById("chkAll");
	var tbl=document.getElementById("plantbl");
	alert(chkall.checked);
	for(var n=0; n<tbl.length; n++){
		tbl.rows[nn+1].cells[0].childNodes[0].checked=chkall.checked;
	}
}
function Confirm(Ids){
		var tbl = document.getElementById('plantbl');
		var stlNo=tbl.rows[Number(Ids.id)+1].cells[1].id;
		var chk=document.getElementById(Ids.id).checked;
		//var com=tbl.rows[Number(Ids.id)].cells[4].childNodes[0].nodeValue;comLineNo
		var com=document.getElementById("comLineNo" +Ids.id).value;
		if(com==""){
			alert("Select Line No");
			document.getElementById(Ids.id).checked=false;
			document.getElementById("comLineNo" +Ids.id).focus();
			return;
		}
		var DateFrom=document.getElementById("txtFromDate" +Ids.id).value;
		if(DateFrom==""){
			alert("Select Date From");
			document.getElementById(Ids.id).checked=false;
			document.getElementById("txtFromDate" +Ids.id).focus();
			return;			
		}
		var DateTo=document.getElementById("txtToDate" +Ids.id).value;
		if(DateTo==""){
			alert("Select Date To");
			document.getElementById(Ids.id).checked=false;
			document.getElementById("txtToDate" +Ids.id).focus();
			return;			
		}
		var path= pnl_planUrl+"planDetailXML.php?RequestType=Confirm&StyleID=" +stlNo +"&Check=" +chk;
		//apkhtml=$.ajax({url:path ,async:false});
		//alert();
//sendConfirm();
}
function sendConfirm(){
		var tbl = document.getElementById('plantbl');
		//var stlNo=tbl.rows[Number(Ids.id)+1].cells[1].id;
		//alert(tbl.rows.length);
		var stlNo="";
		var lineNo="";
		var DateFrom="" ,DateTo="";
		for(var n=0;n<tbl.rows.length-1; n++){
			if(document.getElementById(n).checked==true){
				stlNo= stlNo + "," +tbl.rows[n].cells[1].id;
				lineNo= lineNo + "," +document.getElementById("comLineNo" +n).value;
				//DateFrom= DateFrom + "," +tbl.rows[n].cells[1].id;
				//DateTo= DateTo + "," +tbl.rows[n].cells[1].id;
			}
		}
		alert(stlNo +"\n " +lineNo);
		
}