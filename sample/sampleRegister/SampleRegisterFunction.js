// JavaScript Document

var xmlHttp;
var cnt=0;

var save_count=0;

function getOrderNo()
{
	//Loading the combo Box 'Order no'
	
	 var styleNoList=document.getElementById('styleNoList').value;
	 var url;
	 var xmlhttp_obj;
	 var html;
	 
	 url="SampleRegister-set.php?id=loadOrderNo&stylename="+styleNoList;
	 xmlhttp_obj=$.ajax({url:url,async:false})
	 
	 html = xmlhttp_obj.responseText;
	 document.getElementById('OrderDetails').innerHTML = html;
	 
	 //Loading the checkboxes
	
	 if(styleNoList!=-1)
	 {
		url="SampleRegister-set.php?id=loadCheckBox1&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#originalSample').attr('checked',true);
			$('#originalSample').attr('disabled',true);
		}

	 }
	 
	  if(styleNoList!=-1)
	 {
		url="SampleRegister-set.php?id=loadCheckBox2&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#fabric').attr('checked',true);
			$('#fabric').attr('disabled',true);
		}

	 }
	 
	 	  if(styleNoList!=-1)
	 {
		url="SampleRegister-set.php?id=loadCheckBox3&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#accessories').attr('checked',true);
			$('#accessories').attr('disabled',true);
		}

	 }
	 
	 
	
}

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function addItems()
{
	var lastRow=document.getElementById("dataGrid");
	for(var x=lastRow.rows.length-1;x>1;x--)
	{
		lastRow.deleteRow(x);
	}
	
	var styleNoList	= document.getElementById("OrderDetails").value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = getGridValue;
    xmlHttp.open("GET", 'SampleRegister-set.php?id=loadGrid&styleno='+styleNoList, true);
    xmlHttp.send(null); 
}


function getGridValue()
{ 						
	cnt=cnt+1;			
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			try
			{
				var lastRow=document.getElementById("dataGrid");
				
				
				var XML_SAMPLE_DESCRIPTION 		= xmlHttp.responseXML.getElementsByTagName("SAMPLE_DESCRIPTION");
				var XML_SAMPLE_DUE_DATE 		= xmlHttp.responseXML.getElementsByTagName("SAMPLE_DUE_DATE");
				var XML_SAMPLE_NO 	= "";
			
				if(XML_SAMPLE_DESCRIPTION[0].childNodes[0].nodeValue=="")
				{
					XML_SAMPLE_NO=""; 
				}
				else
				{
					XML_SAMPLE_NO=lastRow.rows.length-1;
				}
			
				
				var count=lastRow.rows.length;
				var row = lastRow.insertRow(count);
				row.className="bcgcolor-tblrowWhite";
				var celledit;
				
				
				celledit = row.insertCell(0);
				celledit.className="normalfnt";
				celledit.style.textAlign="center";
				celledit.innerHTML =XML_SAMPLE_NO;
				XML_SAMPLE_NO="";
				
				celledit=row.insertCell(1);
				celledit.className="normalfnt";
				celledit.style.textAlign="center";
				celledit.innerHTML =XML_SAMPLE_DESCRIPTION[0].childNodes[0].nodeValue ;
				
				celledit=row.insertCell(2);
				celledit.className="normalfnt";
				celledit.innerHTML =XML_SAMPLE_DUE_DATE[0].childNodes[0].nodeValue.substring(0,10);
				
				celledit=row.insertCell(3);
				celledit.className="normalfnt";
				celledit.innerHTML = "<img height='15' src=\"../../images/assign.png\"id="+cnt+" onclick=\"selectOperator();\"" ;
				
				celledit=row.insertCell(4);
				celledit.className="normalfnt";
				celledit.innerHTML = "<input style='width:75px' type=\"text\" class=\"txtbox2\" readOnly=\"true\" name=\"txtbx_Issueddate\" id="+(cnt+1)+" onclick=\"return showCalendar("+(cnt+1)+",'%Y-%m-%d');\" <input name=\"reset\"type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;height:1px !important;\"   onclick=\"return showCalendar("+(cnt+1)+", '%Y-%m-%d');\"";
				
				celledit=row.insertCell(5);
				celledit.className="normalfnt";
				celledit.innerHTML = "<input style='width:75px' type=\"text\" class=\"txtbox2\"  name=\"txtbx_IssuedTodate\" readOnly=\"true\" id="+(cnt+2)+" onclick=\"return showCalendar("+(cnt+2)+",'%Y-%m-%d');\" <input name=\"reset\"type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;height:1px !important;\"   onclick=\"return showCalendar("+(cnt+2)+", '%Y-%m-%d');\"";
				
				celledit=row.insertCell(6);
				celledit.className="normalfnt";
				celledit.innerHTML = "<input style='width:75px' type=\"text\" class=\"txtbox2\"  name=\"txtbx_ReSub01\" readOnly=\"true\" id="+(cnt+3)+" onclick=\"return showCalendar(this.id,'%Y-%m-%d');\" <input name=\"reset\"type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;height:1px !important;\"   onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"";
				
				celledit=row.insertCell(7);
				celledit.className="normalfnt";
				celledit.innerHTML = "<input style='width:75px' type=\"text\" class=\"txtbox2\"  name=\"txtbx_ReSub02\" readOnly=\"true\" id="+(cnt+4)+" onclick=\"return showCalendar(this.id,'%Y-%m-%d');\" <input name=\"reset\"type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;height:1px !important;\"   onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"";
			
				celledit=row.insertCell(8);
				celledit.className="normalfnt";
				celledit.innerHTML = "<input style='width:75px' type=\"text\" class=\"txtbox2\"  name=\"txtbx_Appdate\" readOnly=\"true\" id="+(cnt+5)+" onclick=\"return showCalendar(this.id,'%Y-%m-%d');\" <input name=\"reset\"type=\"reset\"  class=\"txtbox\" style=\"visibility:hidden;height:1px !important;\"   onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"";
				
				
				
				
			}
			catch(err)
			{
				
			}
			
		}
	}			
}


function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}

function selectOperator()
{
	
	/*var url  = "SampleRegister-setOpt.php";
	htmlobj=$.ajax({url:url,async:false});	
	drawPopupAreaLayer(470,320,'SampleRegisterOptPopup',1);
	var HTMLText=htmlobj.responseText;	
	document.getElementById('SampleRegisterOptPopup').innerHTML=HTMLText;
	*/
	
		
	var styleNoList = document.getElementById('OrderDetails').value; 
	
	// passing required variable and values to the SampleRequisitionPopup.php page.
	var url  = "SampleRegister-setOpt.php?id=popup&StyleNo="+styleNoList;
	htmlobj=$.ajax({url:url,async:false});	
	//drawPopupArea(1,1,'SampleRegister-setOpt');
	drawPopupAreaLayer(100,100,'SampleRegister-setOpt',1);		
	var HTMLText=htmlobj.responseText;	
	document.getElementById('SampleRegister-setOpt').innerHTML=HTMLText;
	//addItemstoPopUp();
	//loadselectedData();

}

function closePopUp(){
	try
	{	
		/*var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;*/
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		//window.close();
		
	}
	catch(err)
	{    
		
	}
	
	
}


function validateGridData()
{
	var tb= document.getElementById('dataGrid');
	var issued_Date;
	var issued_To;
	var reSub1;
	var reSub2;
	var app;
	var i;
	for(i=2;i<tb.rows.length;i++)
	{
		issued_Date=tb.rows[i].cells[4].childNodes[0].value;
		issued_To=tb.rows[i].cells[5].childNodes[0].value;
		reSub1=tb.rows[i].cells[6].childNodes[0].value;
		reSub2=tb.rows[i].cells[7].childNodes[0].value;
		app=tb.rows[i].cells[8].childNodes[0].value;
			if(issued_Date=="")
				alert("Please Enter Issued Date");
			else if(issued_To=="")
				alert("Please Enter Issued To Date");
			else if(reSub1=="")
				alert("Please Enter Re.Sub 01 Date");
			else if(reSub2=="")
				alert("Please Enter Re.Sub 02 Date");
			else if(app=="")
				alert("Please Enter App Date");
	}
}





//Validation part in Pop Up Window

function validateOperatorPopUp()
{
	/*var opt_Select=document.getElementById("opt_table").rows[2].cells[0].childNodes[1].checked;
	alert(opt_Select);*/
	
	var opt_Select;
	var count_opt=0;
	var start_date;
	var noDays;
	var strCode;
	var tb= document.getElementById('opt_table');
	for(var i=2;i<tb.rows.length;i++)
	{
		//check whether the checkbox is checked or not
		strCode=document.getElementById("opt_table").rows[i].cells[0].childNodes[0].id;
		opt_Select=document.getElementById("opt_table").rows[i].cells[0].childNodes[1].checked;
		start_date=document.getElementById("opt_table").rows[i].cells[2].childNodes[0].value;
		noDays=document.getElementById("opt_table").rows[i].cells[3].childNodes[0].value;
		
		if(opt_Select==true && start_date=="")
			{
			alert("Please Select a Date for the selected operator");
			count_opt++;
			}
		
		else if(opt_Select==true && start_date!="" && noDays=="")
			{
			alert("Please specify no of days ");
			count_opt++;
			}
		
		else if(opt_Select==true && start_date!="" && noDays!="")
		{	
			count_opt++;
			savePopupData(opt_Select,start_date,noDays,strCode);
		}
		else if(opt_Select==false && (start_date!="" || noDays!=""))
		{
				document.getElementById("opt_table").rows[i].cells[2].childNodes[0].value="";
				document.getElementById("opt_table").rows[i].cells[3].childNodes[0].value="";
		}
		
	}
		
		
		if(count_opt==0)
					alert("Please select the operator");
}


function savePopupData(opt_Select,start_date,noDays,strCode)
{
		//alert(strCode);
	var styleNoList=document.getElementById('styleNoList').value;
	var url;
	var xmlhttp_obj;
	var html;
	 
	url="SampleRegister-set.php?id=updateSampleOpt&styleno="+styleNoList+"&optCode="+strCode+"&startDate="+start_date+"&noDays="+noDays;
	xmlhttp_obj=$.ajax({url:url,async:false})
	 
    html = xmlhttp_obj.responseText;
	 
	alert(html);
}



function loadDataGrid()
{
	addItems();
}