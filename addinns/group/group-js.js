

//  Edited By suMitH HarShan  2011-04-29

//**************************************Save Machines data******************************************
function saveMachine()
{   	
        if(trim(document.getElementById('cboGroup').value)=="")
		{
			alert("Please select \"Machine Type\".");
			document.getElementById('cboGroup').focus();
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

	    /*else if(!ValidateSave())
		{
			return;
		}*/
		
			var url = "machines-db-set.php?type=save";
			
			url=url+"&machineTypeId="+URLEncode(document.getElementById("txtMachineTypeID").value);
			url=url+"&machineId="+URLEncode(document.getElementById("cboGroup").value);
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
	loadCombo('SELECT intGroupId ,strGroupName FROM events_group ORDER BY strGroupName ASC','cboGroup');
	document.getElementById('cboGroup').focus();
	//loadGridMachines();
	$('#cboGroup').val('');
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
	var machineId=document.getElementById('cboGroup').value; 
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
		document.getElementById('cboGroup').value=XMLMachineID[0].childNodes[0].nodeValue;	
		
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
    var machineCode=URLEncode(document.getElementById('txtMachineCode').value);
	var machineTypeID=URLEncode(document.getElementById("txtMachineTypeID").value);
	var machineName=URLEncode(document.getElementById("txtMachine").value);		
	var x_find=checkInField('ws_machinetypes','strMachineName',machineName,'intMachineTypeId',machineTypeID);
	
	if(x_find)
	    {
		alert('MachineName "'+machineName+'" is already exist.');	
		document.getElementById("txtMachine").focus();
		return false;
	    }
 /*   else{
		var x_find=checkInField('ws_machinetypes','strMachineCode',machineCode,'intMachineTypeId',machineId);
			if(x_find)
			{
				alert('MachineCode "'+machineCode+'" is already exist.');	
				//alert('"'+machineCode+'" is already exist.');		
				document.getElementById("txtMachineCode").focus();
				return false;
			}
	   } */ 
       return true;	
}
//*************************Add machine type when click the add button***************************************
function prompter() {
var name = prompt("Enter the Group Name", "")
var trimName=name.trim();	
if(trimName==''){
	return false;
}
	var path = "group-db-set.php?type=saveGroupName&name="+trimName;	

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
			var url = "SELECT DISTINCT(intGroupId), strGroupName FROM events_group ORDER BY strGroupName ASC";
			loadCombo(url,'cboGroup');			
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
	document.getElementById("txtMachineTypeID").value='';
    document.getElementById("txtMachineTypeID").value=typeId;
	
    document.getElementById("cboGroup").value	=id;
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
	var tbl = document.getElementById('tblmaingrid');
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

//---------------------------------------------load the users popup--------------------------------------------------

function loadUsersPopUp(){
	var path = "users.php?";
	htmlobj=$.ajax({url:path,async:false});
	var text = htmlobj.responseText;
	closeWindow();
	drawPopupAreaLayer(545,240,'combinedDocs',1);
	document.getElementById('combinedDocs').innerHTML=text;
}

//------------------------------------------Closing the users pooup------------------------------------------------------------

function closeUsersPopUp(){
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}	
}

//------------------------------------------loading selected users to main grid--------------------------------------------------------

function loadUsersToGrid(){
	var arrArrayMainGridUser = [];
	var tblusersgrid = document.getElementById("tblusersgrid");
	var tblmaingrid = document.getElementById("tblmaingrid");
	
	var rowCountUserGrid = tblusersgrid.rows.length;
	var rowCountMainGrid = tblmaingrid.rows.length;
	
	for(var a =1;a<rowCountMainGrid;a++){
		var mainGridUser = tblmaingrid.rows[a].cells[1].lastChild.nodeValue;
		 if(arrArrayMainGridUser.indexOf(mainGridUser) == -1){
		   arrArrayMainGridUser.push(mainGridUser);	
		 }
	}
	
	for(var a =1;a<rowCountUserGrid;a++){
	 if(tblusersgrid.rows[a].cells[0].lastChild.checked == true){
	  if(arrArrayMainGridUser.indexOf(tblusersgrid.rows[a].cells[1].lastChild.nodeValue) == -1){
	  var row = tblmaingrid.insertRow(rowCountMainGrid);
	  row.className="bcgcolor-tblrowWhite";
	   tblmaingrid.rows[rowCountMainGrid].innerHTML=
	"<td class=\"normalfntMid\" width=\"46\"><img src='../../images/del.png' onclick='deleteRow();'</td>"+
	"<td class=\"normalfnt\" width=\"446\" id="+tblusersgrid.rows[a].cells[1].id+">"+tblusersgrid.rows[a].cells[1].lastChild.nodeValue+"</td>";
	  }
	 }
	}	
}

//------------------------------------------------delete the same group before save from the db------------------------------

function deleteBeforeSave(){
	var groupID = document.getElementById("cboGroup").value;
	if(groupID == ''){
	 alert("Please Select a Group");	
	 return false;
	}
    var path = "group-db-set.php?type=deleteBeforeSave";
	    path += "&groupID="+groupID;	
	htmlobj=$.ajax({url:path,async:false});
	if(htmlobj.responseText == 1){
		events_user_groups_Save();
	}
}
//--------------------------------------------save event with group------------------------------------------------------------
function events_user_groups_Save(){
 var groupID = document.getElementById("cboGroup").value;
 var tblmaingrid = document.getElementById("tblmaingrid");
 var count = 1;
 var rowCountMainGrid = tblmaingrid.rows.length;
 	for(var a =1;a<rowCountMainGrid;a++){
	var userID = tblmaingrid.rows[a].cells[1].id;
    var path = "group-db-set.php?type=events_user_groups_Save";
	    path += "&groupID="+groupID;
		path += "&userID="+userID;
	htmlobj=$.ajax({url:path,async:false});
	count++;
	 if(rowCountMainGrid == count){
		alert("Saved Successfully");
	 }
	}
}

//--------------------------------------------------load saved users--------------------------------------------------------

function loadExUsersForGroups(){
	var groupID = document.getElementById("cboGroup").value;
    var path = "group-db-get.php?type=loadExUsersForGroups";
	    path += "&groupID="+groupID;	
		htmlobj=$.ajax({url:path,async:false});
		document.getElementById("tblmaingrid").innerHTML  = htmlobj.responseText;
}

//---------------------------------------------------------------

function deleteRow(){
	// clicked row remove by jquery 	
	$("#tblmaingrid > tbody > tr").live("click", function() { 
		$(this).closest("tr").remove(); 
	});
}