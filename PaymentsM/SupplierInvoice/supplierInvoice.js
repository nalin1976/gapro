
function LoadDetails()
{
	
	//document.getElementById('tblGridInvoice').tBodies[0].innerHTML='';	
	 // $('#tblGridInvoice td:not(\'#tblhdr\')').empty();
	// $('#tblGridInvoice').remove("tr:gt(0)");
	 
  lastColomnDelete();



    var supplierID=document.getElementById('cboSupplier').value;	
    var url="supplierInvoice-db-get.php?request=loadTxtDetails&supplierID="+supplierID;
    var xmlhttp_obj=$.ajax({url:url,async:false})
    if(xmlhttp_obj.responseXML.getElementsByTagName("strAccPaccID").length>0)	
	{
     document.getElementById("txtAccPaccID").value=xmlhttp_obj.responseXML.getElementsByTagName("strAccPaccID")[0].childNodes[0].nodeValue;
     document.getElementById("txtCreditPeriod").value=xmlhttp_obj.responseXML.getElementsByTagName("intCreditPeriod")[0].childNodes[0].nodeValue;
	}
	else 
	{
	document.getElementById('tblGridInvoice').tBodies[0].innerHTML='';	
	return;
	}
	loadCalcuations();
	
}


function loadCalcuations()
{
    var supplierID=document.getElementById('cboSupplier').value;	
	//alert(supplierID);
    var url="supplierInvoice-db-get.php?request=loadGridDetails&supplierID="+supplierID;
    var xmlhttp_obj=$.ajax({url:url,async:false})
    if(xmlhttp_obj.responseText)	
	{
	document.getElementById('tblGridInvoice').tBodies[0].innerHTML=xmlhttp_obj.responseText;		
	}
	else if(xmlhttp_obj.responseText=='')
	{
	document.getElementById('tblGridInvoice').tBodies[0].innerHTML='';	
	}
//var val=getGridCommissionValues();
//alert(val);

}

function saveInvoice()
{
  if(!saveValidation)
  return;	
  
      var url="invoice-db-set.php?type=Save";		

	  url=url+"&cboSupplier="+document.getElementById("cboSupplier").value;
	  url=url+"&cboBatchNo="+document.getElementById("cboBatchNo").value;
	  url=url+"&cboAccount="+document.getElementById("cboAccount").value;
	  url=url+"&cboType="+document.getElementById("cboType").value;
	  url=url+"&cboCurrency="+document.getElementById("cboCurrency").value;
	  url=url+"&txtCreditPeriod="+document.getElementById("txtCreditPeriod").value;
	  url=url+"&txtDate="+document.getElementById("txtDate").value;
	  url=url+"&txtAccPaccID="+document.getElementById("txtAccPaccID").value;

      var xmlhttp_obj=$.ajax({url:url,async:false})
	  //var SupplierNo = xmlhttp_obj.responseText;
	  
	 // var arrSup = SupplierNo.split('/'); 
	 // alert(arrSup[0].trim());
	  alert(xmlhttp_obj.responseText);

	
}

function saveValidation()
{
      if(trim(document.getElementById('cboSupplier').value)=="")
		{
			alert("Please select \"Supplier\".");
			document.getElementById('cboSupplier').focus();
			return false;
		}	
		
		
		else if(trim(document.getElementById('cboBatchNo').value)=="")
		{
			alert("Please Enter \"Batch No\".");
			document.getElementById('cboBatchNo').focus();
			return false;
		}

		
		else if(trim(document.getElementById('cboAccount').value)=="")
		{
			alert("Please select \"Account\".");
			document.getElementById('cboAccount').focus();
			return false;
		}
		
		else if(trim(document.getElementById('cboType').value)=="")
		{
			alert("Please select \"Type\".");
			document.getElementById('cboType').focus();
			return false;
		}
		
		else if(trim(document.getElementById('cboCurrency').value)=="")
		{
			alert("Please select \"Currency\".");
			document.getElementById('cboCurrency').focus();
			return false;
		}
		
		else if(trim(document.getElementById('txtDate').value)=="")
		{
			alert("Please select \"Date\".");
			document.getElementById('txtDate').focus();
			return false;
		}
		
		return true;
}


function ClearForm()
{
/* $(':input','#frmsupinv')
 .not(':button, :submit, :reset, :hidden')
 .val('')
 $("#tblGridInvoice > tbody").empty();*/
window.location='supplierInvoice.php'; 
 document.getElementById('cboSupplier').focus();	
}



//get grid value---------------------------------------------------------------
function getGridCommissionValues()
{
	
if (document.getElementById('tblGridInvoice').rows.length==0) return;
 for (var i=1; i<document.getElementById('tblGridInvoice').rows.length; i++)
 {
	 for (var x=1; x<document.getElementById('tblGridInvoice').getElementsByTagName('tr')[0].getElementsByTagName('td').length; x++)
	 {
		if(!document.getElementById('tblGridInvoice').rows[i].cells[x].childNodes[0].value)
		{
		  var amount = document.getElementById('tblGridInvoice').rows[i].cells[x].childNodes[0].data;
	    }
		  
		else if(document.getElementById('tblGridInvoice').rows[i].cells[x].childNodes[0].value)
		{
		   var amount = document.getElementById('tblGridInvoice').rows[i].cells[x].childNodes[0].value;
		}
		//alert(amount);
	 } 
 }

}

//add colomns------------------------------------------------------------
function addColumn(obj)
{
  if(document.getElementById('cboSupplier').value==0)
  {
	alert("Please select \"Supplier\".");
	document.getElementById('cboSupplier').focus();
	var selectedRate=obj.id;
    document.getElementById(selectedRate).checked=false;
	return false;
  }
  else
  {
  
   var selectedRate=obj.id;
   if(document.getElementById(selectedRate).checked==true)
   {
		 var tblHeadObj = document.getElementById('tblGridInvoice').tHead;
		 for (var h=0; h<tblHeadObj.rows.length; h++)
		 {
			var newTH = document.createElement('th');
			tblHeadObj.rows[h].appendChild(newTH);
			newTH.innerHTML = 'Rate';
			newTH.className='grid_header';
			newTH.id='rates';
		/*	newTH.style.backgroundColor='#fff3cf';
			newTH.style.color='#c4a641';
			newTH.style.border='1px solid #cccccc';*/
		 }
		 
		var tblBodyObj = document.getElementById('tblGridInvoice').tBodies[0];
	    for (var i=0; i<tblBodyObj.rows.length; i++) 
	    {
		 var newCell = tblBodyObj.rows[i].insertCell(-1);
		 newCell.innerHTML = selectedRate;
	    }
   }
   else if(document.getElementById(selectedRate).checked==false)  
   {
            deleteColumn();
   } 

  }
  //calculateTax(newCell)
}

//delete colomns---------------------------------------------------------------------
function deleteColumn()
{
	
	var allRows = document.getElementById('tblGridInvoice').rows;
	for (var i=0; i<allRows.length; i++) 
	{
		if (allRows[i].cells.length > 1) 
		{
			allRows[i].deleteCell(-1);
		}
	}
}


//calculate tax--------------------------------------------------------------------------
function calculateTax()
{
    for(var y=1; y<document.getElementById('tblGridInvoice').getElementsByTagName('tr')[0].getElementsByTagName('td').length; y++)
	{
		 //var Cell = document.getElementById('tblGridInvoice').rows[i].cells[3].childNodes[0].data;
		 //alert(Cell);
		//}

		var rate = document.getElementById('tblGridInvoice').rows[i].cells[y].childNodes[0].data;
		//alert(rate);
    }

}

function lastColomnDelete()
{
 var n = $("input:checked").length;
 if(n>0)
 {
  //alert('checked');
  $('#tblTaxData').find("input:checkbox").removeAttr("checked");
   var rates = document.getElementById('rates');
   

 }	
 //else
  //alert('not checked');
}



