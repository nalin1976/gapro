

//  Edited By suMitH HarShan  2011-04-29

//**************************************Save Machines data******************************************
function saveMachine()
{   	
        if(trim(document.getElementById('cboMachines').value)=="")
		{
			alert("Please select \"Machine Type\".");
			document.getElementById('cboMachines').focus();
			return ;
		}
	    else if(trim(document.getElementById('txtMachineCode').value)=="") 
		{
			alert("Please enter \"Machine Code\".");
			document.getElementById('txtMachineCode').focus(); 
			return false;
		}
        else if(trim(document.getElementById('txtMachine').value)=="")
		{
			alert("Please enter \"Machine Name\".");
			document.getElementById('txtMachine').focus();
			return ;
		}

/*	    else if(!ValidateSave())
		{
			return;
		}*/
		
			var url = "machines-db-set.php?type=save";
			
			//url=url+"&machineTypeId="+URLEncode(document.getElementById("txtMachineTypeID").value);
			url=url+"&machineId="+URLEncode(document.getElementById("cboMachines").value);
			url=url+"&machineCode="+URLEncode(document.getElementById("txtMachineCode").value);
			url=url+"&machineName="+URLEncode(document.getElementById("txtMachine").value);

			if(document.getElementById("chkActive").checked==true)
				var intStatus = 1;	
			else
				intStatus = 0;
			url=url+"&status="+intStatus;
			
			if(document.getElementById("chkHelper").checked==true)
				var intHelper = 1;	
			else
				var intHelper = 0;
			url=url+"&intHelper="+intHelper;
			
		var httpobj = $.ajax({url:url,async:false});
					  
		alert(httpobj.responseText);
		loadGridMachines();
		clearForm();
 } 



		
//commented by suMitH HarShan  2011-04-29   not use	 
/*function DeleteData()
{  
	var url = "machines-db-set.php?type=delete&machineId="+document.getElementById("cboSearch").value;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	clearForm();
} */
	

//*******************************************Clear the form***********************************************
function clearForm()
{	
	document.frmmachines.reset();
	loadCombo('SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC','cboMachines');
	document.getElementById('cboMachines').focus();
	loadGridMachines();
	//$('#txtMachineTypeID').val('');
}

//commented by suMitH HarShan  2011-04-29   not use	 
/*function deleteMachine()
{
		if(document.getElementById('cboSearch').value=="")
		    {
			alert("Please select \"Machine\".");
		    }
		else
		    {
			var Search =document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
			var r=confirm("Are you sure you want to delete \'"+Search+"\'?");
				if(r==true)		
				{
					DeleteData();
					clearForm();
				}
			}
}	*/
		
 
 // Edit by suMitH HarShan 2011-04-29
 // **********************Load machine details to the grid when selected the machine type combo box******************************
function loadDetails()
{	
	/*if(obj.value.trim()=="")
   	{
		return false;
   	} */
	var machineId=document.getElementById('cboMachines').value; 
	if(machineId=='')
	{
	  loadGridMachines();	
	  return;
	}   
    var url="machines-db-get.php?type=loadMachineDetails&machineId="+machineId;
	 
	var httpobj = $.ajax({url:url,async:false});
	//var xmlObj = httpobj.responseXML;
	if(httpobj)  //check if exist the response
	{
		/*var XMLMachineCode=xmlObj.getElementsByTagName('MachineCode');
		var XMLMachine=xmlObj.getElementsByTagName('Machine');
		var XMLintHelper=xmlObj.getElementsByTagName('intHelper');	
		var XMLStatus=xmlObj.getElementsByTagName('Status');	
		var XMLMachineID=xmlObj.getElementsByTagName('MachineID');	
		
		document.getElementById('txtMachineCode').value=XMLMachineCode[0].childNodes[0].nodeValue;
		document.getElementById('txtMachine').value=XMLMachine[0].childNodes[0].nodeValue;	
		document.getElementById('cboMachines').value=XMLMachineID[0].childNodes[0].nodeValue;	
		
		if(XMLStatus[0].childNodes[0].nodeValue==1)
			document.getElementById('chkActive').checked=true;	
		else
			document.getElementById('chkActive').checked=false;	
			
		if(XMLintHelper[0].childNodes[0].nodeValue==1)
			document.getElementById('chkHelper').checked=true;	
		else
			document.getElementById('chkHelper').checked=false;	*/
			
		//clear from data before loading the details  
		$('#txtMachineCode').val('');
		$('#txtMachine').val('');
			
		document.getElementById('tblmachinegrid').innerHTML=httpobj.responseText;	
	}

}

	  
//commented by suMitH HarShan  2011-04-29   not use	
/*function ViewMachinesReport()
{ 
	    var cboSearch=document.getElementById('cboSearch').value;
		window.open("machinesreport.php?",'frmmachines'); 
}
*/


// *****************Validate the form before save it.get entered data and check it, if exist in the database.********************
function ValidateSave()
{	               
	var machineID     = URLEncode(document.getElementById("cboMachines").value);
    var machineCode   = URLEncode(document.getElementById('txtMachineCode').value);
	var machineName   = URLEncode(document.getElementById("txtMachine").value);	

	// check for machine name	
	var x_find=checkInField('ws_machinetypes','strMachineName',machineName,'intMachineId',machineID);
	
	if(x_find)
	{
		alert('Machine Name "'+machineName+'" is already exist.');	
		document.getElementById("txtMachine").focus();
		return false;
	}
    else  	// check for machine code	
	{
		var x_find=checkInField('ws_machinetypes','strMachineCode',machineCode,'intMachineId',machineID);
			if(x_find)
			{
				alert('Machine Code "'+machineCode+'" is already exist.');	
				//alert('"'+machineCode+'" is already exist.');		
				document.getElementById("txtMachineCode").focus();
				return false;
			}
	 }  
       return true;	
}
//*************************Add machine type when click the add button***************************************
function prompter() 
{
	    var name = prompt("Enter the Machine Name").trim();	
		//var trimName=name.trim();	
		if(name!='')
		{
			//return false;
		
		var path = "machines-db-set.php?type=saveMachineName&name="+name;	

	    var httpobj = $.ajax( { url :path, async :false });
		var XMLResult = httpobj.responseXML.getElementsByTagName("SaveDetail");
	
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
			var url = "SELECT DISTINCT(intMacineID), strName FROM ws_machines ORDER BY intMacineID ASC";
			loadCombo(url,'cboMachines');		
		}
}


//*******************************delete selected machine from the database****************************

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


//*********************************************Edit machine details******************************************
function editRowMachine(typeId,id,code,helper,name,status) 
{
	//alert(status);
	//get relevent values from the server and it display in the relevent boxes
	//document.getElementById("txtMachineTypeID").value='';
    //document.getElementById("txtMachineTypeID").value=typeId;
	
    document.getElementById("cboMachines").value	=id;
	document.getElementById("txtMachineCode").value	=code;
	document.getElementById("txtMachine").value		=name;
	
	//status check box
	if(status==1)
	{
	 document.getElementById("chkActive").checked=true;
	}
	else
	{
	 document.getElementById("chkActive").checked=false;
	}
	
	//helper check box
	if(helper==1)
	{
	 document.getElementById("chkHelper").checked=true;
	}
	else
	{
	 document.getElementById("chkHelper").checked=false;
	}

//commented because first click edit btn then click delete btn row will be remove.
// clicked row remove by jquery 	
/*	$("#tblmachinegrid > tbody > tr").live("click", function() { 
		$(this).closest("tr").remove(); 
	});*/

	//loadGridMachines() ;
}


//**************************Load all machine details grid when details was saved******************************************
function loadGridMachines() 
{
	var url="machines-db-get.php?type=loadGrid";
	var httpobj = $.ajax({url:url,async:false});
	document.getElementById("tblmachinegrid").innerHTML=httpobj.responseText;
}


// ********************************change the background color when clicked the row****************************************
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