
//Save Machines data
function saveMachine()
{   	

	    if(trim(document.getElementById('txtMachineName').value)=="") 
		{
			alert("Please enter \"Machine Name\".");
			document.getElementById('txtMachineCode').focus(); 
			return false;
		}

	    else if(!ValidateSave())
		{
			return;
		}
		
			var url = "machines-db-set.php?type=save";
			
			url=url+"&cboSearch="+URLEncode(document.getElementById("cboSearch").value);
			url=url+"&txtMachineName="+URLEncode(document.getElementById("txtMachineName").value);

			
		var httpobj = $.ajax({url:url,async:false});
					  
		alert(httpobj.responseText);
		loadGridMachines();
		clearForm();
 } 




//Clear the form
function clearForm()
{	
	document.frmmachines.reset();
	loadCombo('SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC','cboSearch');
	document.getElementById('txtMachineName').focus();
	
}

		
 
function loadDetails()
{	
	if(document.getElementById('cboSearch').value.trim()=="")
   	{
		document.getElementById('txtMachineName').value='';
		return false;
   	} 
	   
	var cboMachine = document.getElementById('cboSearch').value.trim();   
    var url="machines-db-get.php?type=loadMachineDetails&machineId="+cboMachine;
	 
	var httpobj = $.ajax({url:url,async:false});
	var xmlObj = httpobj.responseXML;
	 
	var XMLMachineID   = xmlObj.getElementsByTagName('machinID');
	var XMLMachineName = xmlObj.getElementsByTagName('machineName');	
	
	document.getElementById('cboSearch').value    = XMLMachineID[0].childNodes[0].nodeValue;
	document.getElementById('txtMachineName').value = XMLMachineName[0].childNodes[0].nodeValue;	


}

	  
//commented by suMitH HarShan  2011-04-29   not use	
/*function ViewMachinesReport()
{ 
	    var cboSearch=document.getElementById('cboSearch').value;
		window.open("machinesreport.php?",'frmmachines'); 
}
*/


// Validate the form before save it.get entered data and check it, if exist in the database.
function ValidateSave()
{	               
     var machineID  = URLEncode(document.getElementById('cboSearch').value);
	var machineName = URLEncode(document.getElementById("txtMachineName").value);		
	var x_find=checkInField('ws_machines','strName',machineName,'intMacineID',machineID);

	
	if(x_find)
	    {
		alert('Machine Name "'+machineName+'" is already exist.');	
		document.getElementById("txtMachineName").focus();
		return false;
	    }

       return true;	
}


//----------------delete selected machine from the database-------------------------------

function deleteRowMachine(id) 
{
var r=confirm("Are you sure you want to delete this Machine?");
	if(r==true)		
	{
    var url = "machines-db-set.php?type=delete&machineId="+id;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	loadGridMachines() ;
	clearForm();
	}
}


//-------------------Edit machine details-------------------------------
function editRowMachine(id,name) 
{
	 //alert(name);
    document.getElementById("cboSearch").value	=id;
	document.getElementById("txtMachineName").value	=name;

}


//--------------------load data grid when machine was saved----------------------------
function loadGridMachines() 
{
	var url="machines-db-get.php?type=loadGrid";
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("tblmachinegrid").innerHTML=httpobj.responseText;
}


// ********************************change the background color when selected the row****************************************
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