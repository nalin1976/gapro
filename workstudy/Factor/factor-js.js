
//-----------------------------------------------------------
function prompter() {
var name = prompt("Enter the Factor Name", "")
	var path = "xml.php?RequestType=saveFactorName&name="+name;			

	htmlobj = $.ajax( { url :path, async :false });
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
			//	alert("Saved successfully.");
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "False"){
				alert("Save failed.");
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "exist"){
				alert("Already exists.");
			}
			var url = "SELECT DISTINCT(intId), strName FROM ws_seamtype ORDER BY intId ASC";
			loadCombo(url,'cboFactorType');			
}
//----------------------------------------------------------
function saveMachineFactors()
{   	  
	    if(trim(document.getElementById('cboMachine').value)=="") 
		{
			alert("Please select \"Machine\".");
			document.getElementById('cboMachine').focus(); 
			return false;
		}
        else if(trim(document.getElementById('cboStitchType').value)=="")
		{
			alert("Please select \"Stitch Type\".");
			document.getElementById('cboStitchType').focus();
			return ;
		}
        else if(trim(document.getElementById('cboSeamType').value)=="")
		{
			alert("Please select \"Seam Type\".");
			document.getElementById('cboSeamType').focus();
			return ;
		}
        else if(trim(document.getElementById('txtLength').value)=="")
		{
			alert("Please enter \"Length\".");
			document.getElementById('txtLength').focus();
			return ;
		}
		
			var url = "xml.php?RequestType=saveMachineFactors";
			
			url=url+"&machineId="+document.getElementById("cboMachine").value;			
			url=url+"&stitchTypeId="+document.getElementById("cboStitchType").value;
			url=url+"&seamTypeId="+document.getElementById("cboSeamType").value;
			url=url+"&length="+document.getElementById("txtLength").value;
			
		var httpobj = $.ajax({url:url,async:false});
		var xmlObj = httpobj.responseXML;
		var XMLresponse=xmlObj.getElementsByTagName('response');
		alert(XMLresponse[0].childNodes[0].nodeValue);
		
		clearForm();
		document.forms.frmMachineFacors.submit();
 } 

//----------------------------------------------------------

function DeleteData()
{  
	var url = "xml.php?RequestType=deleteFactor&machineId="+document.getElementById("cboMachine").value+"&stitchTypeId="+document.getElementById("cboStitchType").value;
	var httpobj = $.ajax({url:url,async:false});
	var xmlObj = httpobj.responseXML;
	var XMLresponse=xmlObj.getElementsByTagName('response');
	alert(XMLresponse[0].childNodes[0].nodeValue);
} 
	
//----------------------------------------------------------

function clearForm()
{	
	document.frmMachineFacors.reset();
	document.getElementById("cboStitchType").value="";
	document.getElementById("cboSeamType").value="";
	document.getElementById("txtLength").value="";
	document.getElementById("cboMachine").focus();
}

//----------------------------------------------------------

function deleteMachineFactor()
{
		if((document.getElementById('cboMachine').value=="") || (document.getElementById('cboMachine').value=="") || (document.getElementById('cboMachine').value==""))
		    {
			alert("Please select \"Factor type\".");
		    }
		else
		    {
			var r=confirm("Are you sure you want to delete factor?");
				if(r==true)		
				{
					DeleteData();
					clearForm();
				}
			}
}	
		
//----------------------------------------------------------
	 
function loadDetails()
{	
	if(document.getElementById('cboMachine').value=="")
   	{
		return false;
   	} 
	if(document.getElementById('cboMachine').value=="")
   	{
		return false;
   	} 
	   
    var url="xml.php?RequestType=loadMachineFactorDetails&machineId="+document.getElementById("cboMachine").value+"&stitchTypeId="+document.getElementById("cboStitchType").value+"&seamTypeId="+document.getElementById("cboSeamType").value;
	 
	var httpobj = $.ajax({url:url,async:false});
	var xmlObj = httpobj.responseXML;
	
	var XMLseamType=xmlObj.getElementsByTagName('seamType');
	var XMLlength=xmlObj.getElementsByTagName('length');
	document.getElementById('cboSeamType').value=XMLseamType[0].childNodes[0].nodeValue;	
	document.getElementById('txtLength').value=XMLlength[0].childNodes[0].nodeValue;	
}

//----------------------------------------------------------

function ViewMachinesFactorReport()
{ 
/*	    if(document.getElementById('cboMachine').value=='')
		{
			alert("Please select a Machine.");
			document.getElementById('cboMachine').focus();
			return;
		}
		else
		{*/
		var cboSearch=document.getElementById('cboMachine').value;
		window.open("factorReport.php?",'frmmachines'); 
		//}
}

//----------------------------------------------------------

function ValidateSave()
{	               
     var machineCode=document.getElementById('txtMachineCode').value;
	var machineId=document.getElementById("cboSearch").value;
	var machineName=document.getElementById("txtMachine").value;		
	var x_find=checkInField('ws_machinetypes','strMachineName',machineName,'intMachineTypeId',machineId);
	
	if(x_find)
	    {
		alert('MachineName "'+machineName+'" is already exist.');	
		document.getElementById("txtMachine").focus();
		return false;
	    }
    else{
		var x_find=checkInField('ws_machinetypes','strMachineCode',machineCode,'intMachineTypeId',machineId);
			if(x_find)
			{
				alert('MachineCode "'+machineCode+'" is already exist.');	
				//alert('"'+machineCode+'" is already exist.');		
				document.getElementById("txtMachineCode").focus();
				return false;
			}
	   }  
       return true;	
}
//----------------------------------------------------------

function submitPage()
{
	document.forms.frmMachineFacors.submit();
}

function editRowMachine(obj) 
{
	 //alert(name);
    //document.getElementById("cboSearch").value	=id;
	var tbl3 = document.getElementById("tblmachinegrid");
	var machineID	= tbl3.rows[obj.parentNode.parentNode.rowIndex].cells[3].id;
	var stitchID	= tbl3.rows[obj.parentNode.parentNode.rowIndex].cells[4].id;
	var seamID		= tbl3.rows[obj.parentNode.parentNode.rowIndex].cells[5].id;
	var fac         = tbl3.rows[obj.parentNode.parentNode.rowIndex].cells[6].childNodes[0].nodeValue;
	
	
	document.getElementById("cboStitchType").disabled="true";
	document.getElementById("cboSeamType").disabled="true";
	
	
	document.getElementById("cboMachine").value	    = machineID;
	document.getElementById("cboStitchType").value	= stitchID;
	document.getElementById("cboSeamType").value	= seamID;
	document.getElementById("txtLength").value	    = fac;
	document.getElementById("txtLength").focus();
	

}

function rowclickColorChangetbl(obj)
{

	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById('tblmachinegrid');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		//tbl.rows[i].className = "";
		tbl.rows[i].style.backgroundColor = "";
		if ((i % 2) == 1)
		{
			//tbl.rows[i].className="bcgcolor-tblrow";
			tbl.rows[i].style.backgroundColor= "#FFFFCC";
		}
		else
		{
			tbl.rows[i].style.backgroundColor= "#FFFFFF";
		}
		if( i == rowIndex)
		    tbl.rows[i].style.backgroundColor= "#99CCFF";
	}
	
}

function deleteRowMachine(id) 
{
	var r=confirm("Are you sure you want to delete this Machine?");
	if(r==true)		
	{
    var url = "xml.php?RequestType=delete&machineId="+id;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	document.forms.frmMachineFacors.submit();
	//clearForm();
	}
}
