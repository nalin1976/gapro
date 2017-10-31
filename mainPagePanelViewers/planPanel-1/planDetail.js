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
		var Lino=document.getElementById("comLineNo" +Ids.id).value;
		if(Lino==""){
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
		//var path= pnl_planUrl+"planDetailXML.php?RequestType=Confirm&StyleID=" +stlNo +"&Check=" +chk;
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
		var planConfirm=0;
		var chk=0;
//=========================2014-03-24===================================SORT line no======================================
			var linNo=new Array();
			var tmplno="", LiNo="";
			var arrayDFrom=new Array();
			var arrayDTo=new Array();
			var dts=new Date();
			var d="";
			for(var n=0;n<tbl.rows.length-1; n++){
				linNo[n]=document.getElementById("comLineNo" +n).value;
				arrayDFrom[n]=document.getElementById("txtFromDate" +n).value;
				arrayDTo[n]=document.getElementById("txtToDate" +n).value;
			}
			//alert(linNo);
			for(var n=0;n<linNo.length; n++)
			{
				for(var m=n+1; m<linNo.length; m++)
				{
					if(Number(linNo[n])>Number(linNo[m]))
					{
						tmplno=linNo[m];
						linNo[m]=linNo[n];
						linNo[n]=tmplno;
						
						tmpfdate=arrayDFrom[m];
						arrayDFrom[m]=arrayDFrom[n];
						arrayDFrom[n]=tmpfdate;
						
						tmptdate=arrayDTo[m];
						arrayDTo[m]=arrayDTo[n];
						arrayDTo[n]=tmptdate;
					}
				}
			}
		//	alert(linNo +"\n"+arrayDFrom +"\n" +arrayDTo);
			
//=end ========================2014-03-24===================================SORT line no======================================
//========================chk date gap==========2014-03-27=============================================================
		var lineCount=new Array();
		var lnCount=0;
		tmplno=linNo[0];
		lineCount[0]=0;
		for(var n=0; n<linNo.length;n++)
		{
			if(tmplno==linNo[n])
			{
				lineCount[lnCount]=Number(lineCount[lnCount])+1;
			}else{ 
				lnCount=lnCount+1;
				lineCount[lnCount]=1;
				tmplno=linNo[n];
			}
		}
		//	alert(linNo +"\n"+arrayDFrom +"\n" +arrayDTo +"\n" +lineCount);
		for(var n=0;n<linNo.length; n++)
		{
			d1=arrayDFrom[n].split("-");
			var date1=new Date(d1[0],d1[1],d1[2]);
			for(var m=n+1; m<linNo.length; m++)
			{
				if(linNo[n]==linNo[m])
				{
					d2=arrayDFrom[m].split("-");
					var date2=new Date(d2[0],d2[1],d2[2]);
					if(date1.valueOf()>date2.valueOf())
					{
						tmpfDate=arrayDFrom[n];
						arrayDFrom[n]=arrayDFrom[m]
						arrayDFrom[m]=tmpfDate;
						
						tmptDate=arrayDTo[n];
						arrayDTo[n]=arrayDTo[m]
						arrayDTo[m]=tmptDate;
					}
				}
			}
		}
		//alert(linNo +"\n"+arrayDFrom +"\n" +arrayDTo +"\n" +lineCount);
//==end======================chk date gap==========2014-03-27=============================================================

		for(var n=0;n<tbl.rows.length-1; n++){
				if(chk==0){
					stlNo	= tbl.rows[n+1].cells[1].id;
					lineNo	= document.getElementById("comLineNo" +n).value;
					DateFrom=document.getElementById("txtFromDate" +n).value;
					DateTo	= document.getElementById("txtToDate" +n).value;
					if(document.getElementById(n).checked==true) planConfirm=1; else planConfirm=0;
					chk=1;
				}else{
					stlNo	= stlNo + "," +tbl.rows[n+1].cells[1].id;
					lineNo	= lineNo + "," +document.getElementById("comLineNo" +n).value;
					DateFrom= DateFrom + "," +document.getElementById("txtFromDate" +n).value;
					DateTo	= DateTo + "," +document.getElementById("txtToDate" +n).value;
					if(document.getElementById(n).checked==true) planConfirm = planConfirm +"," + 1; else planConfirm= planConfirm +"," + 0;
				}
			//}
		}
		//alert(stlNo +"\n " +lineNo);

		var path= pnl_planUrl+"planDetailXML.php?RequestType=Confirm&StyleID=" +stlNo +"&lineNo=" +lineNo +"&DateFrom=" +DateFrom +"&DateTo=" +DateTo +"&planConfirm=" + planConfirm;
		//alert(path);
		apkhtml=$.ajax({url:path ,async:false});
		alert("Confirm Successfuly");
}
//================2014-03-25=========================================================

function MatchFromdateAndTodate(Ids){
	var fdate=new Date();
	var todate=new Date();
	var rowno=document.getElementById(Ids).id;
	rowno=rowno.replace(document.getElementById(Ids).name,"");
	var txtfdate=document.getElementById("txtFromDate" +rowno).value;
	var txttdate=document.getElementById("txtToDate" +rowno).value;
	txtfdate=txtfdate.split("-");
	txttdate=txttdate.split("-");
	fdate=new Date(txtfdate[0],txtfdate[1],txtfdate[2]);
	todate=new Date(txttdate[0],txttdate[1],txttdate[2]);
	if(fdate.valueOf()>todate.valueOf()){
		alert("Check Date From  and To ");
		document.getElementById(Ids).focus();
		return;
	}
	
	var tbl = document.getElementById('plantbl');
	var linNo=new Array();
	var tmplno="", LiNo="";
	var arrayDFrom=new Array();
	var arrayDTo=new Array();
	var d=0;
	var rNo="";
	for(var n=0;n<tbl.rows.length-1; n++)
	{
		if(document.getElementById("comLineNo" +rowno).value==document.getElementById("comLineNo" +n).value)
		{
			if(d==0) rNo=n; else rNo="," +n;
			linNo[d]=document.getElementById("comLineNo" +n).value;
			arrayDFrom[d]=document.getElementById("txtFromDate" +n).value;
			arrayDTo[d]=document.getElementById("txtToDate" +n).value;
			d=d+1;
		}
	}
	// sort fromdate
	for(var n=0;n<linNo.length; n++)
	{
		d1=arrayDFrom[n].split("-");
		var date1=new Date(d1[0],d1[1],d1[2]);
		for(var m=n+1; m<linNo.length; m++)
		{
			//if(linNo[n]==linNo[m])
			//{
				d2=arrayDFrom[m].split("-");
				var date2=new Date(d2[0],d2[1],d2[2]);
				if(date1.valueOf()>date2.valueOf())
				{
					tmpfDate=arrayDFrom[n];
					arrayDFrom[n]=arrayDFrom[m]
					arrayDFrom[m]=tmpfDate;
					
					tmptDate=arrayDTo[n];
					arrayDTo[n]=arrayDTo[m]
					arrayDTo[m]=tmptDate;
				}
			//}
		}
	}
	// end sort fromdate
	var gaps="";
	var gapDate;
	for(var n=0; n<linNo.length-1; n++)
	{
		if(arrayDTo[n]>arrayDFrom[n+1])
		{
			alert("Pleas Check the Planing Date in " + document.getElementById("comLineNo" +rowno).options[document.getElementById("comLineNo" +rowno).selectedIndex].text);
			//DisplayRows(rno);
			return;
		}else{
			d1=arrayDFrom[n+1].split("-");
			d2=arrayDTo[n].split("-");
			var date1=new Date(d1[0],d1[1],d1[2]);
			var date2=new Date(d2[0],d2[1],d2[2]);
			gapDate=date1.getDate() - date2.getDate();
			gaps=gaps +"\n" +arrayDTo[n] +" to " +arrayDFrom[n+1] +" gaps " +gapDate;
		}
	}
	alert("This is " +document.getElementById("comLineNo" +rowno).options[document.getElementById("comLineNo" +rowno).selectedIndex].text +" Gaps. \n" +gaps);
	//alert(linNo +"\n"+arrayDFrom +"\n" +arrayDTo);
	
/*		for (var n=0;n<tbl.rows.length-1; n++){
			
		}
*/}
//end================2014-03-25======================================================
function DisplayRows(rno)
{
	rno=rno.split(",");
	for (var m=0; m<rno.length; m++){
		
	}
}