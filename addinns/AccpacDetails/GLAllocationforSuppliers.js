// JavaScript Document
var save="A";
function createXMLHttpRequest()
{
	if (window.ActiveXObject) 
    {
        xmlHttpSupGL = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSupGL = new XMLHttpRequest();
    }
}

function AddRowtoGrid()
{
    var tbl = document.getElementById('tblGLAccs');
    var lastRow = tbl.rows.length;    
    
    
    var strDescription= document.getElementById("cboGLAccID").options[document.getElementById("cboGLAccID").selectedIndex].text;
	strDescription=strDescription.split(':');
    var accID= document.getElementById('cboGLAccID').value;
    
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	var cls;
	for(var x=1;x<rows.length;x++)
	{
		(x%2==0)?cls="grid_raw":cls="grid_raw2";
		var cells=rows[x].getElementsByTagName("TD");
		if(cells.length>0)
		{
			
			if(cells[0].id==accID)
			{
				alert("This GL Account is already selected.");
				document.getElementById('cboGLAccID').value=0
				changeBackground(x)
				return false;	
			}
		}

	}
	
	
var row = tbl.insertRow(1);
    var cellEdit = row.insertCell(0);
	cellEdit.id = accID;
    //cellEdit.className	= cls;
    cellEdit.innerHTML ="<div align=\"center\"><img src=\"../../images/del.png\"  onclick=\"deleteRow(this)\" alt=\"del\" width=\"15\" height=\"15\" /></div>";
	
	//"<div align=\"center\"><img src=\"../../images/edit.png\" alt=\"edit\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"ShowData(this)\" id=\"" + intBatch + "\"/></div>";
	
    var cellBatchNo             = row.insertCell(1);
    //cellBatchNo.className        = cls;    
    cellBatchNo.innerHTML         = strDescription[1];    

    var cellDescription         = row.insertCell(2);
    //cellDescription.className    = cls;
	
	
    cellDescription.innerHTML     = strDescription[0];
   
    document.getElementById('cboGLAccID').value=0;
	/*var strGLTbl="<tr>"+
						"<td width=\"80\" ><div align=\"center\"><img src=\"../../images/del.png\"  onclick=\"deleteRow(this)\"  width=\"15\" height=\"15\" /></div></td>"+
						"<td  style=\"text-align:left;\">" + strDescription[1] + "</td>"+
						"<td  style=\"text-align:left;\">" + accID + "</td>"+
						"</tr>"
	row.innerHTML=strGLTbl;*/
    arrangeRowColors(tbl);
}

function changeBackground(x)
{
	var table = document.getElementById("tblGLAccs");  
	var rows = table.getElementsByTagName("tr");
	for(var i = 0;i < rows.length;i++)
	{
		(x%2==0)?cls="grid_raw":cls="grid_raw2";
		if(i==x)
		{
			rows[i].bgColor = "#E6EBF1";//FDEAA8
			
		}
	}
}

function arrangeRowColors(tbl){
	var r=tbl.rows;
	var cls;
	for(var i=1;i<tbl.rows.length;i++){
		(i%2==0)?cls="grid_raw":cls="grid_raw2";
		r[i].cells[0].className=cls;
		r[i].cells[1].className=cls;
		r[i].cells[1].setAttribute("style","text-align:left")
		r[i].cells[2].className=cls;
		r[i].cells[2].setAttribute("style","text-align:left")
	}
}

function  deleteRow(obj)
{
	var td		= obj.parentNode.parentNode;
	var glNo	= td.parentNode.cells[0].id;
	
	if(confirm("Are you sure you want to remove GL Account No '"+td.parentNode.cells[2].innerHTML+"' from this supplier."))
	{
		var supplier = document.getElementById('cboSupliers').value.trim();
		if(supplier==0){return false;}
		
		var path = "accPackGLDB.php?DBOprType=deleteGLAccDets&supplier="+supplier+"&glNo="+glNo;
		htmlobj = $.ajax({url:path,async:false});
		var tbl = document.getElementById('tblGLAccs');
		var theRow = obj.parentNode.parentNode.parentNode.rowIndex
		tbl.deleteRow(theRow);
		var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
		
		if(XMLResult[0].childNodes[0].nodeValue)
		{
			var tbl = document.getElementById('tblGLAccs');
			arrangeRowColors(tbl);
			alert("GL Account deleted successfully.");
		}
		else
		{
			alert("Error");
		}
	}
	else
		return false;
}

function allowcationSave()
{
	var isFirst =1;
	
	if(document.getElementById('cboSupliers').value==0)
	{
		alert("Please select a supplier to allocate to GL Accounts")
		document.getElementById('cboSupliers').focus();
		return; 
	}
	else
	{
	var supID=document.getElementById('cboSupliers').value	
	}
	
	var table = document.getElementById("tblGLAccs");  
	var rows = table.getElementsByTagName("tr");
	var response = 0;
	if(rows.length==1)
	{
		alert("Please select GL Accounts to allocate")
		document.getElementById('cboGLAccID').focus();
		return; 
	}
	else
	{	
		var url = 'accPackGLDB.php?DBOprType=deleteSupGLAlloData';
			url += '&supID='+supID;
		htmlobj=$.ajax({url:url,async:false});
		
		for(var no=1;no<table.rows.length;no++)
		{
			var alloID = table.rows[no].cells[0].id;
			var url = 'accPackGLDB.php?DBOprType=SaveSupGLAllowcation';
			url += '&supID='+supID;
			url += '&alloID='+alloID;
			
			htmlobj=$.ajax({url:url,async:false});
			var result = htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
			
			if(result == "True")
				response++;
		}
		
		if(response == table.rows.length-1)
		{
			alert("Saved successfully.");
			clearGlAllocationForSup('frmGlAllocationForSup','tblGLAccs');
			return;
		}
	}
}

function HandleSaveSupGLAllowcation()
{
	if(xmlHttpSupGL.readyState == 4) 
    {
        if(xmlHttpSupGL.status == 200) 
        {  
			var XMLResult = xmlHttpSupGL.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				if(save!="F")
				{
					save="S";
				}	
			}
			else
			{
				save="F";
			}
		}
	}
}

function getAllocatedSupGls()
{
	var supID=document.getElementById("cboSupliers").value;
	createXMLHttpRequest();
	xmlHttpSupGL.onreadystatechange = HandleAllowcatedSupGLAccs;		
	xmlHttpSupGL.open("GET",'accPackGLDB.php?DBOprType=GetAllowcatedSupGLAccs&supID='+ supID , true);
	xmlHttpSupGL.send(null); 
}

function HandleAllowcatedSupGLAccs()
{
	if(xmlHttpSupGL.readyState == 4) 
    {
        if(xmlHttpSupGL.status == 200) 
        {  
			var XMLAccNo = xmlHttpSupGL.responseXML.getElementsByTagName("accNo");
			var XMLAccName = xmlHttpSupGL.responseXML.getElementsByTagName("accName");
			var XMLAccId = xmlHttpSupGL.responseXML.getElementsByTagName("accID");
			
			var strGLTbl="<table width=\"560\" bgcolor=\"\" height=\"20\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblGLAccs\">"+
							"<tr>"+
							"<td width=\"63\" height=\"24\"  class=\"grid_header\">Del</td>"+
							"<td width=\"432\"  class=\"grid_header\"><div align=\"center\">GL Description</div></td>"+
							"<td width=\"203\"  class=\"grid_header\"><div align=\"center\">GL ID</div></td>"+
							"</tr>"
			for(var loop=0;loop<XMLAccNo.length;loop++)
			{
				var accno=XMLAccNo[loop].childNodes[0].nodeValue;
				var accname=XMLAccName[loop].childNodes[0].nodeValue;
				var AlloID = XMLAccId[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				
				strGLTbl+="<tr class=\"\">"+
						"<td class=\""+cls+"\" id=\""+AlloID+"\"><div align=\"center\"><img src=\"../../images/del.png\"  onclick=\"deleteRow(this)\"  width=\"15\" height=\"15\" /></div></td>"+
						"<td class=\""+cls+"\" style=\"text-align:left;\">" + accname + "</td>"+
						"<td class=\""+cls+"\"  style=\"text-align:left;\">" + accno + "</td>"+
						"</tr>"
			}
			strGLTbl+="</table>"
			
			document.getElementById("divtblGLAccs").innerHTML=strGLTbl
		}
	}	
}

///----------------------- lasantha 22-09-2010--------------
function clearGlAllocationForSup(frm,tbl)
{
	document.getElementById(frm).reset();
	var tbl=document.getElementById(tbl)
	var rCount = tbl.rows.length;
	for(var loop=1;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}
	document.getElementById('cboSupliers').focus();
}