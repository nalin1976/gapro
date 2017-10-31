
//**************Created by suMitH HarShan 2011-04-29*************



//********************************************Save operations****************************************
function saveOperation()
{
 if(!SaveValidation())
  return;

    var  url="editOparations-db-set.php?type=Save";	
	
	url=url+"&cmbProcessId="+document.getElementById("cmbProcessId").value;
	url=url+"&cboComponentCatagory="+document.getElementById("cboComponentCatagory").value;
	url=url+"&cboComponent="+URLEncode(document.getElementById("cboComponent").value);
	url=url+"&txtOperationCode="+URLEncode(document.getElementById("txtOperationCode").value);
	url=url+"&txtOperation="+URLEncode(document.getElementById("txtOperation").value);
	
	if(document.getElementById("chkActive").checked==true)
	   var intStatus = 1;	
	else
	   var intStatus = 0;
	   
	url=url+"&status="+intStatus;
	
    var httpobj= $.ajax({url:url,async:false});
	var x=httpobj.responseText.trim();
    alert(x);
	
	loadOperations();
	clearForm();


}

//***************************************validation before save********************************************
function SaveValidation()
{
	    //Component Catagory is empty
		if(document.getElementById('cmbProcessId').value=="") //SubContractDate
		{
			alert("Please select the \"Process\".");
			document.getElementById('cmbProcessId').focus();
			return false;
		}
		
		else if(document.getElementById('cboComponentCatagory').value==0) //SubContractDate
		{
			alert("Please select the \"Component Catagory\".");
			document.getElementById('cboComponentCatagory').focus();
			return false;
		}
		
		//Component is empty
		else if(document.getElementById('cboComponent').value==0)
		{
			alert("Please Select a \"Component\".");
			document.getElementById('cboComponent').focus();
			return false;
		}
		
		//Operation Code is empty
		else if(document.getElementById('txtOperationCode').value=="")
		{
			alert("Please Enter \"Operation Code\".");
			document.getElementById('txtOperationCode').focus();
			return false;
		}
		
		//Operation is empty
		else if(document.getElementById('txtOperation').value=="")
		{
			alert("Please Enter \"Operation\".");
			document.getElementById('txtOperation').focus();
			return false;
		}
	
return true;		
	
}


// **************************************clear the form*************************************************
function clearForm()
{	
	document.frmeditoperation.reset();
	document.getElementById('txtOperationCode').value = '';
	document.getElementById('txtOperation').value = '';
	//loadCombo('SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes ORDER BY strMachineName ASC','cboSearch');
	document.getElementById('cboComponentCatagory').focus();
	$('#tbloperation > tbody').remove();  //clear the table 
}



//****************************************delete selected operations from the database***********************
//call to this function when click delete icon of the data grid
function deleteRowOperation(id) 
{
	//alert(id);
    var r=confirm("Are you sure you want to delete this Machine?");
	if(r==true)		
	{
    var url = "editOparations-db-set.php?type=delete&operationID="+id;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	clearForm();  //call to clear the form
	$('#id').remove();  // remove received id ,otherwise can't properly edit and next record delete
	}
}


//**************************************** Edit machine details ****************************************

//call to this function when click edit icon of the data grid
function editRowOperation(id,componentId,code,operation,status,catID) 
{
	//document.getElementById("cboOperationID").value		=id;  // hidden * text box. important to save & update data
	
	document.getElementById("cboComponentCatagory").value=catID; 
	document.getElementById("cboComponent").value		=componentId; 
	document.getElementById("txtOperationCode").value	=code;
	document.getElementById("txtOperation").value   	=operation;
	
	//status check box
	if(status==1)
	{
	 document.getElementById("chkActive").checked=true;
	}
	else
	{
	 document.getElementById("chkActive").checked=false;
	}

//commented because first click edit btn then click delete btn row will be remove.
// clicked row remove by jquery 	
/*	$("#tbloperation > tbody > tr").live("click", function() { 
		$(this).closest("tr").remove(); 
	});*/
	
}


//********************************************** Load components  ****************************************
//calling when component catagory combo onchange
function loadComponentsCatWise(intCatId)
{
	if(document.getElementById('cboComponentCatagory').value==0)
	{
	   clearForm();
      $("#tbloperation > tbody > tr").remove(); 
	}
	else
	{  
	var url = "editOparations-db-get.php?id=loadComponents&intCatId="+intCatId;
	var obj = $.ajax({url:url,async:false})	;
	document.getElementById('cboComponent').innerHTML = obj.responseText;
	}

}

//******************************************load Component Wise Details to grid *******************************
//call to this function when select the component category combo
// load details to grid according to selected component
function loadComponentWiseDetails()
{
   // clear other input boxes before loading the data to the grid
   $('#cboComponent').val('');
   $('#txtOperationCode').val('');
   $('#txtOperation').val('');
   
   if(document.getElementById('cboComponentCatagory').value==0)
	{
	   //clearForm();

	}
	else
	{
	var intCataId=document.getElementById('cboComponentCatagory').value;	  
	var url = "editOparations-db-get.php?id=loadComponentsDetails&intCataId="+intCataId;
	var obj2 = $.ajax({url:url,async:false});
	if(obj2!='')   // check if exist the response from the server
	document.getElementById('tbloperation').innerHTML = obj2.responseText;
	else
		$('#tbloperation > tbody').remove();  //clear  all data from the table if not response from the server

	}
	rowclickColorChangetbl();
}


//************************************************ load operations grid  ***************************************
//call to this function when select the Component Catagory & Component 
function loadOperations()
{
	// if cboComponent combo box value is zero, clear the next text boxes
	if(document.getElementById('cboComponent').value='')
	{
	   $('#txtOperationCode').val('');
       $('#txtOperation').val('');	
	   loadComponentWiseDetails();   // call to load details catogory wise
	   
	}
	// get combo boxes values
	var cboComponentCatagory = document.getElementById('cboComponentCatagory').value;
	var cboComponent = document.getElementById('cboComponent').value;
	
	var url = "editOparations-db-get.php?id=loadOperations&ComponentCatagory="+cboComponentCatagory+"&Component="+cboComponent;
    var obj = $.ajax({url:url,async:false})	; 
	if(obj!='')  // check if exist the response from the server
	{
	   document.getElementById('tbloperation').innerHTML = obj.responseText;
	   // clear other input boxes when loading the data to the grid
       $('#txtOperationCode').val('');
       $('#txtOperation').val('');
	}
		
	else
		$('#tbloperation > tbody').remove();  //clear table all data

}



// ********************************change the background color when selected the row****************************************
function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tbloperation');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function rowclickColorChangetbl2(obj)
{

	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById('tbloperation');
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

function tableRowColorchange()
{
		
    $(function() {
    $("#tbloperation tr:even").addClass("bcgcolor-tblrow");
    $("#tbloperation tr:odd").addClass("bcgcolor-tblrowWhite");
    $("#tbloperation tr").hover(
       function(){
         $(this).toggleClass("bcgcolor-highlighted");
       });
    });
}

//-------------------------------------------------------------------------------------------------

function getComponentCat(){
	var cmbProcessId = document.getElementById('cmbProcessId').value;
	var path = "editOparations-db-get.php?id=loadComponentCat&cmbProcessId="+cmbProcessId;
     htmlobj=$.ajax({url:path,async:false});

	 document.getElementById('cboComponentCatagory').innerHTML = htmlobj.responseText;
}



