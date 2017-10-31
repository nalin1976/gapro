// JavaScript Document
var  xmlhttp=[];
var xmlHttp;
var PayModeID;
var pub_payModePath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_payModePath+"/addinns/PayMode/";
function creatRequestArray(index) 
{
    if (window.ActiveXObject) 
    {
        xmlhttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlhttp[index] = new XMLHttpRequest();
    }	
}

function deleterows(tableName)
	{	
		var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
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
function CreateXMLHttpForBatchNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpBatchNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpBatchNo = new XMLHttpRequest();
    }
}

function CreateXMLHttpForBatches()
{
	if (window.ActiveXObject) 
    {
        xmlHttpBatchs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpBatchs = new XMLHttpRequest();
    }
}

//ok
function ShowData(obj)
{
	//alert(obj.parentNode.parentNode.cells[2].firstChild.)
	PayModeID			= obj.parentNode.parentNode.cells[2].childNodes[0].nodeValue;	
	var strDescription 	= obj.parentNode.parentNode.cells[3].childNodes[0].nodeValue;	
	var strRemarks 		= obj.parentNode.parentNode.cells[4].childNodes[0].nodeValue;
	var intStatus		= obj.parentNode.parentNode.cells[1].id;
	
	document.getElementById('txtDescription').value = strDescription;
	document.getElementById('txtRemarks').value 	= strRemarks;
	document.getElementById("hidden_paymodeid").value=PayModeID;
	(intStatus==1)?document.getElementById('chkActINAct').checked=true:document.getElementById('chkActINAct').checked=false;
}

//ok
function setNew()
{
	document.getElementById("txtDescription").value	= "";
	document.getElementById("txtRemarks").value		= "";
	document.getElementById('txtDescription').focus();
	document.getElementById("hidden_paymodeid").value="";
}

//ok
function savePayMode()
{
	if (isValidPayMode())
	{		
		var strDescription 	= document.getElementById('txtDescription').value;
		var strRemarks 		= document.getElementById('txtRemarks').value;
		var chkActINAct		= document.getElementById('chkActINAct').value;
		
		(document.getElementById("chkActINAct").checked==true)?chkStatus=1:chkStatus=0;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleSavePayMode;		
		xmlHttp.open("GET",pub_url+'PayModeMiddleTire.php?RequestType=savePayMode&strDescription='+strDescription+'&strRemarks='+strRemarks+'&intChkStatus='+chkStatus, true);
		xmlHttp.send(null); 
	}
}

//ok
function isValidPayMode()
{	
	if (document.getElementById('txtDescription').value == "" || document.getElementById('txtDescription').value == null)
	{
		alert("Please enter the \"Description\" .");
		document.getElementById('txtDescription').focus();
		return false;		
	}
	else if (document.getElementById('txtRemarks').value == "" || document.getElementById('txtRemarks').value == null)
	{
		alert("Please enter the \"Remarks\" .");
		document.getElementById('txtRemarks').focus();
		return false;	
	}	
	
	

}

function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tablez=this.id;
	var tbl = document.getElementById(tablez);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";		
		tbl.rows[i].className="bcgcolor-tblrowWhite";
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

//ok
function HandleSavePayMode()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  			
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue != "-2")
			{
				alert("The \"Pay Mode\" Saved successfully.")
				setNew();
				grid_refresh();
				
			}
			else
			{
				alert("The \"Pay Mode\" Updated successfully.");
				setNew();
				grid_refresh();
			}
		}
	}
}

//ok
function UpdateTable()
{	
	var strDescription 	= document.getElementById('txtDescription').value;
	var strRemarks 		= document.getElementById('txtRemarks').value;	
	var tbl 			= document.getElementById('tblPOPayMode');	    

	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];       

		if (PayModeID == rw.cells[1].childNodes[0].nodeValue)
		{
			rw.cells[3].childNodes[0].nodeValue=strRemarks;
		}		
	}
}

//ok
function isExist()
{
	var strDescription 	= document.getElementById('txtDescription').value;
	var tbl = document.getElementById('tblPOPayMode');	    
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];		
		if (strDescription==rw.cells[2].lastChild.nodeValue)
		{		
			return true;
		}
	}
	return false;
}

//ok
function AddRowtoGrid(PayModeID)
{
	var strDescription 	= document.getElementById('txtDescription').value;
	var strRemarks 		= document.getElementById('txtRemarks').value;
	
	var tbl = document.getElementById('tblPOPayMode');
    var lastRow = tbl.rows.length;
	var row = tbl.insertRow(lastRow);

	var cellEdit = row.insertCell(0);

cellEdit.innerHTML="<td height=\"18\" class=\"normalfnt\"><div align=\"center\"> <img src=\"../../images/edit.png\" alt=\"edit\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"ShowData(this)\"  /> </div></td>"
		
	var cellID = row.insertCell(1);
	cellID.innerHTML = "<td class=\"normalfnt\">" + "" + "</td>" ;
	
	var cellDescription = row.insertCell(2);
	cellDescription.innerHTML = "<td class=\"normalfnt\">" + strDescription + "</td>" ;

	var cellRemarks = row.insertCell(3);
	cellRemarks.innerHTML = "<td class=\"normalfnt\">" + strRemarks + "</td>" ;
}

//----------------hem---------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp1=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp1=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp1;
}

function butCommand(strCommand)
{
//if (isValidData())
//{
	        	if(trim(document.getElementById('txtDescription').value)=="")
				{	
					document.getElementById('txtDescription').focus();
					alert("Please enter \"Description\".");
					return false;
				}
				else if(trim(document.getElementById('txtRemarks').value)=="")
				{
					alert("Please enter \"Remarks\".");
					document.getElementById('txtRemarks').focus();
					return false;
				}
				var x_id = document.getElementById("hidden_paymodeid").value
				var x_name = document.getElementById("txtDescription").value
				
				var x_find = checkInField('popaymentmode','strDescription',x_name,'strPayModeId',x_id);
				if(x_find)
				{
				alert("\""+x_name+"\" is already exist.");	
				document.getElementById("txtDescription").focus();
				return false;
				}	
					 
	             else
				 {
				xmlHttp1=GetXmlHttpObject();
				
				if (xmlHttp1==null)
				  {
				  alert ("Browser does not support HTTP Request");
				  return;
				  } 
				  
				 
           //hem if(document.getElementById("countries_cboCountryList").value=="")
			
		//hem	strCommand="New";
		
			
			var url=pub_url+"PayModeMiddleTire.php";
			url=url+"?q="+strCommand;
			var chk=0;
			var chkStatus=0;
			(document.getElementById("chkActINAct").checked==true)?chkStatus=1:chkStatus=0;
				if(strCommand=="Save"){ 
					url=url+"&strDescription="+document.getElementById("txtDescription").value;
					url=url+"&strRemarks="+document.getElementById("txtRemarks").value;	
					url=url+"&intChkStatus="+chkStatus;
				}
                 
				else
				{
					url=url+"&strDescription="+document.getElementById("txtDescription").value;
					url=url+"&strRemarks="+document.getElementById("txtRemarks").value;		
					url=url+"&intChkStatus="+chkStatus;
					}
	xmlHttp1.onreadystatechange=stateChanged;
	xmlHttp1.open("GET",url,true);
	xmlHttp1.send(null);

//}
} 
}

function stateChanged() 
{ 
if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
 { 
 alert(xmlHttp1.responseText);
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 //setTimeout("location.reload(true);",1000);
 	
	grid_refresh();
	setNew();
 } 
}

function ClearForm()
{	
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		 return;
	} 
		
	//createXMLHttpRequest();
	xmlHttp1.onreadystatechange = clearFormRes;
	xmlHttp1.open("GET", pub_url+'PayModeMiddleTire.php?q=clearReq', true);
	xmlHttp1.send(null);  
}
	
function clearFormRes()
{
	if(xmlHttp1.readyState == 4) 
	{
		if(xmlHttp1.status == 200) 
		{
			document.getElementById("divBatches").innerHTML  = xmlHttp1.responseText;
		}
	}
		clearFields();
}

function clearFields()
{
	var arrElements=['txtDescription','txtRemarks'];
	for(var i=0;i<arrElements.length;i++)
	{
		document.getElementById(arrElements[i]).value="";
		
	}
		document.getElementById('txtDescription').focus();
}

function grid_refresh()
{
	creatRequestArray(0);
	xmlhttp[0].onreadystatechange=function()
		{
				if(xmlhttp[0].readyState==4 && xmlhttp[0].status==200)
				{	deleterows("tblPOPayMode");
					var XMLid=xmlhttp[0].responseXML.getElementsByTagName('PayTermId');
					var XMLDescription=xmlhttp[0].responseXML.getElementsByTagName('Description');
					var XMLRemarks=xmlhttp[0].responseXML.getElementsByTagName('Remarks');
					var XMLStatus=xmlhttp[0].responseXML.getElementsByTagName('Status');
					var tbl=document.getElementById("tblPOPayMode");
					var no=0;
				
					for (var loop=0; loop<XMLid.length;loop++)
						{		
						var cls;
						(loop%2==0)?cls="grid_raw":cls="grid_raw2";
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
														
														
														row.className ="bcgcolor-tblrowWhite";				
														
														row.onclick	= rowclickColorChangetbl;
														row.id='tblPOPayMode';
														
														var rowCell = row.insertCell(0);
														rowCell.className =cls;
														rowCell.height="18";
														rowCell.innerHTML ="<img src=\"../../images/del.png\"alt=\"edit\"width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"DeletePaymentMode(this)\" />";
														
														var rowCell = row.insertCell(1);
														rowCell.className =cls;
														rowCell.height="18";
														rowCell.id=XMLStatus[loop].childNodes[0].nodeValue;
														rowCell.innerHTML ="<img src=\"../../images/edit.png\"alt=\"edit\"width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"ShowData(this)\" />";
														
														var rowCell = row.insertCell(2);
														rowCell.className =cls;			
														rowCell.innerHTML =XMLid[loop].childNodes[0].nodeValue;
														
														
														var rowCell = row.insertCell(3);
														rowCell.className =cls;	
														rowCell.style.textAlign="left"
														rowCell.innerHTML=(XMLDescription[loop].childNodes[0].nodeValue==""? " n/a":XMLDescription[loop].childNodes[0].nodeValue);
														
														var rowCell = row.insertCell(4);
														rowCell.className =cls;		
														rowCell.style.textAlign="left"
														rowCell.innerHTML=(XMLRemarks[loop].childNodes[0].nodeValue==""?" n/a":XMLRemarks[loop].childNodes[0].nodeValue);
														no++;
						}

				}
		}
	
	xmlhttp[0].open("GET", pub_url+'PayModeMiddleTire.php?q=reload',true);
	xmlhttp[0].send(null);
	document.getElementById('frmPayMode').reset();
}


function DeletePaymentMode(dz)
{
	if(confirm("Are you sure you want to delete \"" + dz.parentNode.parentNode.cells[3].childNodes[0].nodeValue+"\" ?"))
	{
		creatRequestArray(0);
		var id=dz.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
		xmlhttp[0].onreadystatechange=function()
		{	
			if(xmlhttp[0].readyState==4 && xmlhttp[0].status==200)
			{
				alert(xmlhttp[0].responseText);
				grid_refresh();
				
			}
			
		}
		xmlhttp[0].open("GET", pub_url+'PayModeMiddleTire.php?q=delete&paytrmid='+id,true);
		xmlhttp[0].send(null);
	}
}