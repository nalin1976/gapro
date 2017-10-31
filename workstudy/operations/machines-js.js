

function saveOperation()
{   	  
	 if(trim(document.getElementById('txtOperationCode').value)=="")
			{
				alert("Please enter \"Operation  Code\".");
				document.getElementById('txtOperationCode').focus();
				return false;
			}		
		
			else if(trim(document.getElementById('cboComponent').value)=="")
			{
				alert("Please select \"Component\".");
				document.getElementById('cboComponent').focus();
				return ;
			}
			
			else if(trim(document.getElementById('txtOperation').value)=="")
			{
				alert("Please enter \"Operation\".");
				document.getElementById('txtOperation').focus();
				return ;
			}
			
						
			else if(trim(document.getElementById('cboOperationMode').value)=="")
			{
				alert("Please select \"Operation Mode\".");
				document.getElementById('cboOperationMode').focus();
				return ;
			}
			else if(trim(document.getElementById('cboMachine').value)=="")
			{
				alert("Please select \"Machine\".");
				document.getElementById('cboMachine').focus();
				return ;
			}
			else if(trim(document.getElementById('cboMachineType').value)=="")
			{
				alert("Please select \"Machine Type\".");
				document.getElementById('cboMachineType').focus();
				return ;
			}
			else if(trim(document.getElementById('txtSMV').value)=="")
			{
				alert("Please enter \"SMV\".");
				document.getElementById('txtSMV').focus();
				return ;
	        }
			else if(trim(document.getElementById('txtTMU').value)=="")
			{
				alert("Please enter \"TMU\".");
				document.getElementById('txtTMU').focus();
				return ;
	        }

     else if(!ValidateSave())
		{
			return;
		}
       
	        var url="Operations-db-set.php?type=save"; 
			url=url+"&operationId="+URLEncode(document.getElementById("cboSearch").value);			
			url=url+"&operationCode="+URLEncode(document.getElementById("txtOperationCode").value);
			url=url+"&cboComponent="+URLEncode(document.getElementById("cboComponent").value);	
			url=url+"&txtOperation="+URLEncode(document.getElementById("txtOperation").value);
			url=url+"&cboOperationMode="+URLEncode(document.getElementById("cboOperationMode").value);	
			url=url+"&cboMachineType="+URLEncode(document.getElementById("cboMachineType").value);	
			url=url+"&txtSMV="+URLEncode(document.getElementById("txtSMV").value);
			url=url+"&txtTMU="+URLEncode(document.getElementById("txtTMU").value);
		
		if(document.getElementById("chkActive").checked==true)		
			var intStatus = 1;	
		else
			var intStatus = 0;
		
		url=url+"&intStatus="+intStatus;			
	    var httpobj = $.ajax({url:url,async:false});
		
		alert(httpobj.responseText);
		ClearForm();
 } 

		

function deleteOperation()
{
		if(document.getElementById('cboSearch').value=="")		    
				alert("Please select \"Search\".");   
		else
		    {
			var Search =document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
			var r=confirm("Are you sure you want to delete \'"+Search+"\'?");
			if(r==true)	
			
			DeleteData();
			ClearForm();
			}
}	


function DeleteData()
{
		var url="Operations-db-set.php?type=delete&operationId="+document.getElementById("cboSearch").value;
  
		var httpobj = $.ajax({url:url,async:false});
	    alert(httpobj.responseText);
} 
	


function ClearForm()
{	
	document.frmOperations.reset();
	loadCombo('SELECT intOpID ,strOperation FROM ws_operations ORDER BY strOperation ASC ','cboSearch');
	document.getElementById('txtOperationCode').focus();
	
 }
	


	 
function loadDetails(obj) ////////////////////////////////
{	
	if(obj.value.trim()=="")
   	{
		ClearForm();
		return false;
   	} 
	
     var url="Operations-db-get.php?type=loadOperationsDetails&operationId="+obj.value;
     var httpobj = $.ajax({url:url,async:false});
	 var xmlObj  = httpobj.responseXML;
	
	 var XMLOperationCode=xmlObj.getElementsByTagName('OperationCode');
	 var XMLCategory=xmlObj.getElementsByTagName('category');
	 var XMLComponent=xmlObj.getElementsByTagName('Component');
	 var XMLOperation=xmlObj.getElementsByTagName('Operation');
	 var XMLOperationMode=xmlObj.getElementsByTagName('OperationMode');
	 var XMLMachine=xmlObj.getElementsByTagName('Machine');
	 var XMLMachineType=xmlObj.getElementsByTagName('MachineTypeID');
	 var XMLSMV=xmlObj.getElementsByTagName('SMV');
	 var XMLTMU=xmlObj.getElementsByTagName('TMU');
	 var XMLStatus=xmlObj.getElementsByTagName('Status');			
			
	 document.getElementById('txtOperationCode').value=XMLOperationCode[0].childNodes[0].nodeValue;
	 document.getElementById('cboComponentCateg').value=XMLCategory[0].childNodes[0].nodeValue;
	 
	loadCombo('SELECT intComponentId ,strComponent FROM components WHERE intCategory='+XMLCategory[0].childNodes[0].nodeValue+' AND intStatus=1 ORDER BY strComponent ASC','cboComponent');
	 
	 document.getElementById('cboComponent').value=XMLComponent[0].childNodes[0].nodeValue;
	 document.getElementById('txtOperation').value=XMLOperation[0].childNodes[0].nodeValue;	
	 document.getElementById('cboOperationMode').value=XMLOperationMode[0].childNodes[0].nodeValue;
	 document.getElementById('cboMachineType').value=XMLMachineType[0].childNodes[0].nodeValue;
	 document.getElementById('cboMachine').value=XMLMachine[0].childNodes[0].nodeValue;
	 document.getElementById('txtSMV').value=XMLSMV[0].childNodes[0].nodeValue;
	 document.getElementById('txtTMU').value=XMLTMU[0].childNodes[0].nodeValue;
			
			if(XMLStatus[0].childNodes[0].nodeValue==1)
				document.getElementById('chkActive').checked=true;	
			else
				document.getElementById('chkActive').checked=false;	
			//	alert('SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes WHERE intMachineId='+document.getElementById('cboMachine').value+' ORDER BY strMachineName ASC');
				
	loadCombo('SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes WHERE intMachineId='+document.getElementById('cboMachine').value+' ORDER BY strMachineName ASC','cboMachineType');
	 document.getElementById('cboMachineType').value=XMLMachineType[0].childNodes[0].nodeValue;
}



function ViewOperationsReport()
   { 
	    var cboSearch=document.getElementById('cboSearch').value;
		window.open("Operationsreport.php?",'frmoperations'); 
    }


function ValidateSave()
 {	
	var operationId=document.getElementById("cboSearch").value;
	var operationCode=document.getElementById("txtOperationCode").value;
	var operation=document.getElementById("txtOperation").value;
	var x_find=checkInField('ws_operations','strOpCode',operationCode,'intOpID',operationId);
	
	if(x_find)
	    {
			//alert('Operation Code "'+operationCode+'" is already exist.');		
			//document.getElementById("txtOperationCode").focus();
			//return false;
	    }
	else{
		var x_find=checkInField('ws_operations','strOperation',operation,'intOpID',operationId);
			if(x_find)
			{
				alert('Operation "'+operation+'" is already exist.');		
				document.getElementById("txtOperationCode").focus();
				return false;
			}
	   }  
       return true;	
}

function calculateSMVandTMU(value){
	if(value=='smv'){
		if(document.getElementById("txtSMV").value!=''){
	var val1=parseFloat(document.getElementById("txtSMV").value)*1667;
	document.getElementById("txtTMU").value=Math.round(val1*100)/100;
		}
	}
	else{
		if(document.getElementById("txtTMU").value!=''){
	var val2=parseFloat(document.getElementById("txtTMU").value)/1667;	
	document.getElementById("txtSMV").value=Math.round(val2*100)/100;
		}
	}
}

function loadMachineTypes(value){
	loadCombo('SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes WHERE intMachineId='+value+' ORDER BY strMachineName ASC','cboMachineType');
}


function updateComCateg(comCateg){
	loadCombo('SELECT intComponentId ,strComponent FROM components WHERE intCategory='+comCateg+' AND intStatus=1 ORDER BY strComponent ASC','cboComponent');
	
	//loadCombo('SELECT intComponentId ,strComponent FROM components WHERE intCategory='+comCateg+' AND intStatus='1' ORDER BY strComponent ASC','cboComponent');
}