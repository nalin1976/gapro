// JavaScript Document
var pub_taxurl	= "/gapro/addinns/tax/";
var msg=0;
var xmlHttp;
var deletionRow;
var editTT="";
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

function loadGLAcc()
{
	var url  = "../AccpacDetails/addGL.php?";
	inc('../AccpacDetails/accPackGL.js');
	var W	= 0;
	var H	= 10;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeCountryModePopUp(id)
{
	
	closePopUpArea(id);
	
	var sql = "select intGLAccID,strAccID,strDescription from glaccounts where intStatus='1' and intGLType='1' and intGLAccID not in (select intGLId from taxtypes) order by strAccID";
	var control = "cboTaxtGL";
	loadCombo(sql,control);
	
}

function showData(obj)
{
	var taxType = obj.parentNode.parentNode.parentNode.cells[3].childNodes[0].nodeValue;
	var taxRate = obj.parentNode.parentNode.parentNode.cells[4].childNodes[0].nodeValue;
	var intStatus =  obj.parentNode.parentNode.parentNode.cells[3].id;
	var taxGLId =  obj.parentNode.parentNode.parentNode.cells[5].id;
	var taxGLDSC =  obj.parentNode.parentNode.parentNode.cells[5].innerHTML;
	
	document.getElementById('txtType').value = taxType;
	document.getElementById('txtRate').value = taxRate;
	document.getElementById("cboTaxtGL").value = taxGLId;
	document.getElementById('taxID').title = obj.id;
	
	if(intStatus==1)
		$('#chkActive').attr('checked',true);
	else
		$('#chkActive').attr('checked',false);
	msg=1;
	editTT=taxType;
}

function removeRow(objDel,id)
{
	var tbl = document.getElementById('tblTaxTypes');
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.parentNode.rowIndex;
	var tax = tbl.rows[rowNo].cells[3].childNodes[0].nodeValue;
    var r=confirm("Are you sure you want to delete  \""+ tax+" \" ?");
	if (r==true){	
		
		var path = pub_taxurl+"taxMiddleTire.php?RequestType=DeleteTax";
		path += "&taxID="+id;
		htmlobj=$.ajax({url:path,async:false});	
		//alert("Deleted successfully.");
		alert(htmlobj.responseText);
		if(htmlobj.responseText=="Deleted successfully.")
			tbl.deleteRow(rowNo);
			
		var len = tbl.rows.length;
		for(var i=1;i<len;i++){
			tbl.rows[i].cells[0].childNodes[0].childNodes[0].nodeValue=i;		
		}
	}
	arrangeDesign(tbl);
}

function arrangeDesign(tbl)
{
	var rID=tbl.rows.length;
	for(var i=1;i<rID;i++)
	{
		var cls;
		(i%2==0)?cls="grid_raw":cls="grid_raw2";			
		tbl.rows[i].cells[0].className = cls;
		tbl.rows[i].cells[1].className = cls;
		tbl.rows[i].cells[2].className = cls;
		tbl.rows[i].cells[3].className = cls;
		tbl.rows[i].cells[4].className = cls;
	}
}

function RemoveRow(rowIndex)
{
	var tbl = document.getElementById('tblTaxTypes');
    tbl.deleteRow(rowIndex);
}

function NewTax()
{
	showBackGround('divBG',0);
	if (!isValidTax())
	{
		hideBackGround('divBG');
		return;
	}
	
	if(!ValidateTaxBeforeSave())
	{
		hideBackGround('divBG');
		return;
	}
		
	var TaxtType 	= URLEncode(document.getElementById('txtType').value);
	var taxRate 	= document.getElementById('txtRate').value;
	var gl			= document.getElementById('cboTaxtGL').value.trim();
	var retVal		= document.getElementById('taxID').title.trim();
	//var retVal 		= validateTaxType();
	var intStatus 	= 0;
	if($("#chkActive").attr('checked'))
		intStatus=1;
	
	if(retVal == "")
	{
		var url=pub_taxurl+"taxMiddleTire.php?RequestType=NewTax&taxType=" + TaxtType + "&taxRate=" + taxRate+"&intStatus="+intStatus+'&gl='+gl;		
		var htmlobj=$.ajax({url:url,async:false});
		HandleTaxAddition(htmlobj);
	}
	else
	{			
		var url=pub_taxurl+"taxMiddleTire.php?RequestType=updateTax&taxType="+TaxtType+"&taxRate="+taxRate+"&taxID="+retVal+"&pTax="+editTT+"&intStatus="+intStatus+'&gl='+gl;		
		var htmlobj=$.ajax({url:url,async:false});
		HandleTaxUpdate(htmlobj);
	}	
}

function HandleTaxAddition(xmlHttp)
{
	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");					
	loadGridData();
	alert("Saved successfully.");	
	ClearTxForm();
	hideBackGround('divBG');
}

function HandleTaxUpdate(xmlHttp)
{
	var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");	
	if (XMLResult[0].childNodes[0].nodeValue == "True")
	{				
		alert("Updated successfully.");	
		msg=0;
		ClearTxForm();
		loadGridData();
		hideBackGround('divBG');
	}		
}

function isValidTax()
{
	if (trim(document.getElementById('txtType').value) == "" || trim(document.getElementById('txtType').value) == null)
	{
		alert("Please enter the 'Tax Type'.");
		document.getElementById('txtType').select();
		return false;		
	}
	else if(isNumeric(document.getElementById('txtType').value.trim()))
	{
		alert("Tax Type must be an \"Alphanumeric\" value.");
		document.getElementById('txtType').select();
		return false;
	}
	else if (document.getElementById('txtRate').value.trim() == "" || document.getElementById('txtRate').value == null)
	{
		alert("Please enter the 'Tax Rate'.");
		document.getElementById('txtRate').select();
		return false;	
	}	
return true;
}

function ValidateTaxBeforeSave()
{	
	var x_id = document.getElementById("taxID").title;
	var x_name = document.getElementById("txtType").value;
	
	var x_find = checkInField('taxtypes','strTaxType',x_name,'strTaxTypeID',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtType").focus();
		return false;
	}
return true;
}

function validateTaxType()
{
	 var newTax = trim(document.getElementById('txtType').value);
	 var tbl = document.getElementById('tblTaxTypes');
		
		var newTaxRate = trim(document.getElementById('txtRate').value)
		var taxType='';
		var taxRate = '';
		var returnVal = 0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var rw = tbl.rows[loop];
			taxType = rw.cells[3].childNodes[0].nodeValue.trim();
			taxRate = rw.cells[4].childNodes[0].nodeValue.trim();
			/*if(editTT !="" &&  editTT != taxType){
				alert(taxType+ "already exist." );
				return false;
				
			}*/
			if(taxType == newTax )//lasantha
			{
					var id = rw.cells[2].childNodes[0].childNodes[0].id;
					returnVal = id;
					if(msg==1){
						rw.cells[4].childNodes[0].nodeValue = newTaxRate;
					}
					return returnVal;
			}
		}
		return returnVal;
}

function UpdateTable()
{
	var taxType = document.getElementById('txtType').value;
	var taxRate = document.getElementById('txtRate').value;
	var tbl = document.getElementById('tblTaxTypes');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        //var cl = rw.cells[2];
		if (taxType == rw.cells[3].childNodes[0].nodeValue)
		{
			rw.cells[4].childNodes[0].nodeValue = taxRate;
		}		
	}
}

function ValidateTaxSave()
{	
	 var newTax = trim(document.getElementById('txtType').value);
	 var tbl = document.getElementById('tblTaxTypes');
		var newTaxRate = trim(document.getElementById('txtRate').value)
		var taxType='';
		var taxRate = '';
		var returnVal = 0;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var rw = tbl.rows[loop];
			taxType = rw.cells[3].childNodes[0].nodeValue.trim();
			taxRate = rw.cells[4].childNodes[0].nodeValue.trim();
			//alert(taxType);
			if (taxType == newTax && newTaxRate==taxRate && msg == 1)
			{
				//alert(taxType +"== "+newTax +"&&" +newTaxRate+"=="+taxRate+ "&&"+ msg+ "=="+ 1);
				alert("Updated successfully.");
				msg=0;
				document.getElementById('txtType').value = "";
				document.getElementById('txtRate').value ="";
				document.getElementById('txtType').select();
				return false;
			}
			
		}
	return true;
}

function ClearTxForm()
{
	document.getElementById('taxID').title = "";
	document.frmTaxType.reset();
	document.frmTaxType.txtType.focus();	
}

function loadGridData()
{
	var path = pub_taxurl+"taxMiddleTire.php?RequestType=loadViewData";
	htmlobj2=$.ajax({url:path,async:false});	
	
	var tblTable    = 	document.getElementById("tblTaxTypes");
	var binCount	=	tblTable.rows.length;

	$("#tblTaxTypes tr:gt(0)").remove();
	if(htmlobj2.readyState == 4 && htmlobj2.status == 200 ) 
	{
		var tblTaxTypes      = document.getElementById("tblTaxTypes");  
		var XMLstrTaxTypeID  = htmlobj2.responseXML.getElementsByTagName("strTaxTypeID");
		var XMLstrTaxType    = htmlobj2.responseXML.getElementsByTagName("strTaxType");	
		var XMLdblRate       = htmlobj2.responseXML.getElementsByTagName("dblRate");	
		var XMLintStatus     = htmlobj2.responseXML.getElementsByTagName("intStatus");	
		var XMLTAXGL     	 = htmlobj2.responseXML.getElementsByTagName("TAXGL");	
		var XMLTAXGLID       = htmlobj2.responseXML.getElementsByTagName("TAXGLID");	
		
		for(var n = 0; n < XMLstrTaxTypeID.length; n++) 
		{
			var rowCount = tblTaxTypes.rows.length;	
			var row = tblTaxTypes.insertRow(rowCount);
			row.className="bcgcolor-tblrowWhite";

			var cls;
			(n%2==0)?cls="grid_raw":cls="grid_raw2";
			tblTaxTypes.rows[rowCount].innerHTML=  
			"<td class=\""+cls+"\"><div align=\"center\">"+rowCount+"</div></td>"+
			"<td class=\""+cls+"\"><div align=\"center\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this,this.id);\" id=\""+XMLstrTaxTypeID[n].childNodes[0].nodeValue+"\"/></div></td>"+
			"<td class=\""+cls+"\" ><div align=\"center\"><img src=\"../../images/edit.png\" width=\"15\" height=\"15\" onclick=\"showData(this);\" id=\""+XMLstrTaxTypeID[n].childNodes[0].nodeValue+"\"/></div></td>"+
			"<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+XMLintStatus[n].childNodes[0].nodeValue+"\">"+XMLstrTaxType[n].childNodes[0].nodeValue+"</td>"+
			"<td class=\""+cls+"\" style=\"text-align:right;\">"+XMLdblRate[n].childNodes[0].nodeValue+"</td>"+
			"<td class=\""+cls+"\" id=\""+XMLTAXGLID[n].childNodes[0].nodeValue+"\" style=\"text-align:center;\">"+XMLTAXGL[n].childNodes[0].nodeValue+"</td>";
		}
	}	
		
/*	var sql = "select intGLAccID,strAccID,strDescription from glaccounts where intStatus='1' and intGLType='1' and intGLAccID not in (select intGLId from taxtypes) order by strDescription;";
	var control = "cboTaxtGL";
	loadCombo(sql,control);*/
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}