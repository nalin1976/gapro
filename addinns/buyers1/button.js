var pub_buyerPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_buyerUrl = pub_buyerPath+"/addinns/buyers/";
var buy_office_array=[];
var array_of_array=[];
var pub_array_index=0;
var xmlHttp;
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 0 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function closeWindow(){
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}

function ValidateInterface()
{
		if(document.getElementById('txtAddinsBuyerCode').value.trim() == "" )
		{
			alert("Please enter \"Buyer Code\".");
			document.getElementById("txtAddinsBuyerCode").select();
			return false;
		}
		
		if(document.getElementById('txtAddinsName').value.trim() == "" )
		{
			alert("Please enter \"Buyer Name\".");
			document.getElementById("txtAddinsName").select();
			return false;
		}
		else if(isNumeric(document.getElementById('txtAddinsName').value.trim())){
			alert("Buyer Name must be an \"Alphanumeric\" value.");
			document.getElementById('txtAddinsName').select();
			return;
		}
		else if(document.getElementById('cboAddinsCountry').value.trim() == "" )
		{
			alert("Please select the \"Country\".");
			document.getElementById("cboAddinsCountry").focus();
			return false;
		} 
		else if(document.getElementById('txtAddinsEmail').value.trim() != "" )
		{
			var email = document.getElementById('txtAddinsEmail').value;
			if(!emailValidate(email))
			{
				alert("Please enter valid \"E-mail Address\".");
				document.getElementById("txtAddinsEmail").select();
				return false;
			}
		}
		else if(document.getElementById('cboPayTerm').value.trim() == "" )
		{
			alert("Please select the \"Pay Term\".");
			document.getElementById("cboPayTerm").focus();
			return false;
		} 
	return true;
}

function ValidateBeforeSave()
{	
	var x_id = document.getElementById("cboAddinsCustomer").value;
	var x_name = document.getElementById("txtAddinsBuyerCode").value.trim();
	
	var x_find = checkInField('buyers','buyerCode',x_name,'intBuyerID',x_id);
	if(x_find)
	{
		alert('" '+x_name+ ' " is already exist.');	
		document.getElementById("txtAddinsBuyerCode").select();
		return false;
	}
	
	var x_id = document.getElementById("cboAddinsCustomer").value;
	var x_name = document.getElementById("txtAddinsName").value.trim();
	
	var x_find = checkInField('buyers','strName',x_name,'intBuyerID',x_id);
	if(x_find)
	{
		alert('" '+x_name+'" is already exist.');	
		document.getElementById("txtAddinsName").select();
		return false;
	}
	return true;
}

function searchDivisions()
{
	xmlHttp=GetXmlHttpObject();
	var txtBuyerCode = document.getElementById('cboAddinsCustomer').value;
	if(txtBuyerCode.trim() != "")
	{
		xmlHttp.onreadystatechange = searchDivisionsRequest;
		var url  = pub_buyerUrl+"buttonIvents.php?q=searchDivisions";
		url += "&txtBuyerCode="+txtBuyerCode;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	else
	{
	  butCommand();
	}
}	
	
function searchDivisionsRequest()
{
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200 ) 
	{
		var response = xmlHttp.responseText;
		if(response == 1){
			butCommand();
	 	}else{
			alert("Please add \"Buyer Division\".");
			document.getElementById('txtBDName').select();
	 	}
	}
}

function butCommand()
{
	var strCommand = 'save';
	if(!ValidateInterface())
		return;
		
	if(!ValidateBeforeSave())	
		return;
		
	var table = document.getElementById("mytable");
	var rowCount = table.rows.length;
	if(rowCount ==0)
	{
		alert("Please add \"Buyer Division\".");
		document.getElementById('txtBDName').select();
		return false;
	}
	else
	{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
		alert ("Browser does not support HTTP Request");
		return;
 	} 
	
	if(document.getElementById('cboAddinsCustomer').value=="")
	strCommand="New";
	
	var url=pub_buyerUrl+"buttonIvents.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="save")
	{  
	    url=url+"&intBuyerID="+document.getElementById("cboAddinsCustomer").value;
		url=url+"&buyerCode="+URLEncode(document.getElementById("txtAddinsBuyerCode").value.trim());
		url=url+"&strName="+URLEncode(document.getElementById("txtAddinsName").value.trim());
		url=url+"&strAddress1="+URLEncode(document.getElementById("txtAddinsAddress1").value.trim());

		url=url+"&strStreet="+URLEncode(document.getElementById("txtAddinsStreet").value.trim());
		url=url+"&strCity="+URLEncode(document.getElementById("txtAddinsCity").value.trim());
		url=url+"&strCountry="+document.getElementById("cboAddinsCountry").value;
		url=url+"&strPhone="+URLEncode(document.getElementById("txtAddinsPhone").value.trim());
		url=url+"&strEmail="+URLEncode(document.getElementById("txtAddinsEmail").value.trim());
		url=url+"&strWeb="+URLEncode(document.getElementById("txtAddinsWeb").value.trim());
		url=url+"&strRemarks="+URLEncode(document.getElementById("txtAddinsRemarks").value.trim());
		url=url+"&strAgent="+URLEncode(document.getElementById("txtAddinsAgent").value.trim());
		url=url+"&strState="+URLEncode(document.getElementById("txtAddinsState").value.trim());
		url=url+"&strZipCode="+URLEncode(document.getElementById("txtAddinsZipCode").value.trim());
		url=url+"&strFax="+URLEncode(document.getElementById("txtAddinsFax").value.trim());	
		url=url+"&strDtFormat="+document.getElementById('cboAddinsDtFromat').value;
		url=url+"&actualFOB="+document.getElementById('cboActualFOB').value;
		url += "&payterm="+document.getElementById('cboPayTerm').value;
		
		var table = document.getElementById("mytable");
		var rowCount = table.rows.length;
		/*var rec1='';
		var rec2='';
		if(rowCount != 0)
		{
			for(var i=0;i<rowCount;i++)
			{
				rec1=rec1+URLEncode(table.rows[i].cells[2].childNodes[0].innerHTML+"~");
			}
			rec1 = rec1+"*"
			for(var i=0;i<rowCount;i++)
			{
				rec2=rec2+URLEncode(table.rows[i].cells[3].childNodes[0].innerHTML+"~");
			}
			
			url=url+"&bdName="+rec1;
			url=url+"&bdRemarks="+rec2;
		}*/
		if(rowCount != 0)
		{
			for(var i=0;i<rowCount;i++)
			{
				if(table.rows[i].cells[1].id ==0)
				{
					var url_d = "buttonIvents.php?q=saveBuyerDevisions&buyerID="+document.getElementById("cboAddinsCustomer").value;
					
					url_d += "&buyerDiv="+URLEncode(table.rows[i].cells[2].childNodes[0].innerHTML);
					url_d += "&buyerDivRemark="+URLEncode(table.rows[i].cells[3].childNodes[0].innerHTML);
					htmlobj=$.ajax({url:url_d,async:false});
				}
			}
			
		}
	}
	else
	{
		url=url+"&intBuyerID="+document.getElementById("cboAddinsCustomer").value;
		url=url+"&buyerCode="+URLEncode(document.getElementById("txtAddinsBuyerCode").value.trim());
		url=url+"&strName="+URLEncode(document.getElementById("txtAddinsName").value.trim());
		url=url+"&strAddress1="+URLEncode(document.getElementById("txtAddinsAddress1").value.trim());

		url=url+"&strStreet="+URLEncode(document.getElementById("txtAddinsStreet").value.trim());
		url=url+"&strCity="+URLEncode(document.getElementById("txtAddinsCity").value.trim());
		url=url+"&strCountry="+URLEncode(document.getElementById("cboAddinsCountry").value);
		url=url+"&strPhone="+URLEncode(document.getElementById("txtAddinsPhone").value.trim());
		url=url+"&strEmail="+URLEncode(document.getElementById("txtAddinsEmail").value.trim());
		url=url+"&strWeb="+URLEncode(document.getElementById("txtAddinsWeb").value.trim());
		url=url+"&strRemarks="+URLEncode(document.getElementById("txtAddinsRemarks").value.trim());
		url=url+"&strAgent="+URLEncode(document.getElementById("txtAddinsAgent").value.trim());
		url=url+"&strState="+URLEncode(document.getElementById("txtAddinsState").value.trim());
		url=url+"&strZipCode="+URLEncode(document.getElementById("txtAddinsZipCode").value.trim());
		url=url+"&strFax="+URLEncode(document.getElementById("txtAddinsFax").value.trim());	
		url=url+"&strDtFormat="+document.getElementById('cboAddinsDtFromat').value;
		url=url+"&actualFOB="+document.getElementById('cboActualFOB').value;
		url += "&payterm="+document.getElementById('cboPayTerm').value;
		
		//lasantha-division details
		var table = document.getElementById("mytable");
		var rowCount = table.rows.length;
		var rec1='';
		var rec2='';
		/*if(rowCount != 0)
		{
			for(var i=0;i<rowCount;i++)
			{
				rec1=rec1+table.rows[i].cells[2].childNodes[0].innerHTML+"~";
			}
			for(var i=0;i<rowCount;i++)
			{
				rec2=rec2+table.rows[i].cells[3].childNodes[0].innerHTML+"~";
			}
			
			url=url+"&bdName="+rec1;
			url=url+"&bdRemarks="+rec2;
		}*/
	}
	
	if(document.getElementById("chkAddinsActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus; 

	htmlobj=$.ajax({url:url,async:false});
	var res_id=htmlobj.responseText;
	
	if(rowCount != 0)
	{
		for(var i=0;i<rowCount;i++)
		{
			var url_d = "buttonIvents.php?q=saveBuyerDevisions&buyerID="+res_id;
			url_d += "&buyerDiv="+URLEncode(table.rows[i].cells[2].childNodes[0].innerHTML);
			url_d += "&buyerDivRemark="+URLEncode(table.rows[i].cells[3].childNodes[0].innerHTML);
			htmlobj=$.ajax({url:url_d,async:false});
		}
		
	}
	
	var off_url=[];
	var ajxobj=[];
	for(var loop=0;loop<array_of_array.length;loop++)
	{		
			off_url[loop]=array_of_array[loop]+'&res_id='+res_id.trim();
			ajxobj[loop]=$.ajax({url:off_url,async:false});
	}
	if(strCommand=="save")
		alert("Updated successfully.");
	else 
		alert("Saved successfully.");
	array_of_array.length=0;
	buy_office_array.length=0;
	pub_array_index=0;
	ClearBuyerForm();
} 
}

function ConformDeleteBuyer(strCommand)
{
	var buyerId	= document.getElementById('cboAddinsCustomer').value;
	if(buyerId==""){
		alert("Please select the Buyer");
		document.getElementById('cboAddinsCustomer').focus;
		return;
	}
	var boolDelete=confirm('Are you sure you want to delete \" '+document.getElementById('txtAddinsName').value+'\ " ?');
	if (boolDelete==true)
	{
		DeleteDataBuyer(strCommand);
	}
}


function DeleteDataBuyer(strCommand)
{
		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url=pub_buyerUrl+"buttonIvents.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="Delete"){ 		
		url=url+"&intBuyerID="+document.getElementById("cboAddinsCustomer").value;

	}

	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200 ) 
		{
			alert(xmlHttp.responseText)	;
			ClearBuyerForm();
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	
	
}

function ConformDeleteBO(strCommand)
{
	var BuyerOffID = document.getElementById("cboBoName").value;
	if(BuyerOffID == "")
	{
		alert("Please select the Buying Office");
		return false;
	}
	else
	{
		var boolDelete=confirm('Are you sure you want to delete \"'+document.getElementById('txtBOName').value+'\" ?');
		if (boolDelete==true)
		{
			DeleteBOData(strCommand);
		}
	}
}

function DeleteBOData(strCommand)
{
	xmlHttp=GetXmlHttpObject();

     if (xmlHttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
		  return;
	  } 
  
	var url=pub_buyerUrl+"buttonIvents.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="butBoDelete"){ 		
		url=url+"&intBuyerOffID="+document.getElementById("cboBoName").value;

	}

	xmlHttp.onreadystatechange=stateChangedBO;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function stateChangedBO()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
 		alert(xmlHttp.responseText);
		loadCombo( "SELECT intBuyingOfficeId, strName FROM buyerbuyingoffices where intStatus=1 and intBuyerID='"+document.getElementById("cboAddinsCustomer").value+"' order by strName ","cboBoName");
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		}
		var url=pub_buyerUrl+"SearchData.php";
		url += "?RequestType=getBuyingOffcDetails&buyerId="+document.getElementById("cboAddinsCustomer").value;
		xmlHttp=GetXmlHttpObject();
		xmlHttp.onreadystatechange=BuyingOffDetailResponse;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
 	} 
}
function ClearBuyerForm()
{
	document.getElementById('txtAddinsBuyerCode').disabled=false;
	document.frmBuyers.reset();
	RemoveAllRows('mytable');	
	loadCombo( 'SELECT intBuyerID, strName FROM buyers where intStatus<>10 order by strName','cboAddinsCustomer');
	document.getElementById("txtAddinsBuyerCode").focus();
}

function ReloadBuyerCombo()
{
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	xmlHttp1.onreadystatechange = ReloadComboRequest;
	xmlHttp1.open("GET", pub_buyerUrl+'SearchData.php?RequestType=ReloadCombo', true);
	xmlHttp1.send(null);
}
	function ReloadComboRequest()
	{
		if(xmlHttp1.readyState == 4) 
		{
			if(xmlHttp1.status == 200) 
			{
				document.getElementById("cboAddinsCustomer").innerHTML  = xmlHttp1.responseText;
			}
		}			
	}

function checkvalue()
{
	if(document.getElementById('txtAddinsName').value!="")
		document.getElementById("txtAddinsAddress1").focus();
}

function LoadBuyingOfficeWindow()
{
	var buyerID = document.getElementById('cboAddinsCustomer').value;
	var url  = pub_buyerUrl+"buyingoffice.php?buyerName="+buyerID;
	inc(pub_buyerUrl+'buyers/button.js');
	inc(pub_buyerUrl+'buyers/Search.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_BoHeader";
	var tdDelete = "td_BoDelete";
	var closePopUp = "closePopUpArea";
	var tdPopUpClose = "buyingOffice_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
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

function ValidateBOInterface()
{
		if(document.getElementById('txtBOName').value.trim() == "" )
		{
			alert("Please enter \"Buying Office Name\".");
			document.getElementById("txtBOName").select();
			return false;
		}
		else if(isNumeric(document.getElementById('txtBOName').value.trim())){
			alert("Buying Office Name must be an \"Alphanumeric\" value.");
			document.getElementById('txtBOName').focus();
			return;
		}		
		else if(document.getElementById('txtBOEmail').value.trim() != "" )
		{
			var email = document.getElementById('txtBOEmail').value;
			if(!emailValidate(email))
			{
				alert("Please enter valid \"E-mail Address\".");
				document.getElementById("txtBOEmail").select();
				return false;
			}
		}
	return true;
}

function ValidateBOBeforeSave()
{	
	var x_id = document.getElementById("cboBoName").value;
	var x_name = document.getElementById("txtBOName").value.trim();
	
	var x_find = checkInField('buyerbuyingoffices','strName',x_name,'intBuyingOfficeId',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("txtAddinsBuyerCode").focus();
		return false;
	}	
	return true;
}

function butSaveBuyingOffice()
{
		
	if(!ValidateBOInterface())
		return;

	var bo_name=document.getElementById("txtBOName").value.trim();
	var bo_name1=document.getElementById("cboBoName").options[document.getElementById("cboBoName").selectedIndex].text;

	var booCheck =  chechoffice(bo_name);
	if(!booCheck && bo_name!=bo_name1)
	{
		alert('"'+bo_name+ '"is already exist.');	
		document.getElementById("txtBOName").focus();
		return false;
	}
	
	var url=pub_buyerUrl+"buttonIvents.php";
	url=url+"?q=SaveBuyingOfficeDetails";
	url=url+"&intBuyerID="+URLEncode(document.getElementById("cboAddinsCustomer").value);
	url=url+"&boID="+URLEncode(document.getElementById("cboBoName").value);
	url=url+"&boName="+URLEncode(document.getElementById("txtBOName").value.trim());
	url=url+"&boAddress1="+URLEncode(document.getElementById("txtBOAddress1").value.trim());
	url=url+"&boStreet="+URLEncode(document.getElementById("txtBOStreet").value.trim());
	url=url+"&boCity="+URLEncode(document.getElementById("txtBOCity").value.trim());
	url=url+"&boCountry="+URLEncode(document.getElementById("cmbCountry").value);
	url=url+"&boPhone="+URLEncode(document.getElementById("txtBOPhone").value.trim());
	url=url+"&boEmail="+URLEncode(document.getElementById("txtBOEmail").value.trim());
	url=url+"&boWeb="+URLEncode(document.getElementById("txtBOWeb").value.trim());
	url=url+"&boRemarks="+URLEncode(document.getElementById("txtBORemarks").value.trim());	
	url=url+"&boState="+URLEncode(document.getElementById("txtBOState").value.trim());
	url=url+"&boZipCode="+URLEncode(document.getElementById("txtBOZipCode").value.trim());
	url=url+"&boFax="+URLEncode(document.getElementById("txtBOFax").value.trim());
	
	if(document.getElementById("chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus; 
	
	if(document.getElementById("cboAddinsCustomer").value!="")
		{
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			} 
			xmlHttp.onreadystatechange=butSaveBuyingOfficeRequest;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);	
		}
		else
		{
			array_of_array[pub_array_index]=url;
			
			pub_array_index++;
			
			if(document.getElementById("cboBoName").value=="")
			{
				var tbl=document.getElementById("tblBuyerOffic");
				var lastrow=tbl.rows.length;
				
				var row=tbl.insertRow(lastrow);
				row.className ="bcgcolor-tblrowWhite";			
				
				var rowcell=row.insertCell(0);
				rowcell.className="normalfntMid";
				rowcell.innerHTML="<input type=\"checkbox\"class=\"txtbox\"checked=\"checked\"/>";
				var rowcell=row.insertCell(1);
				rowcell.className="normalfnt";
				rowcell.innerHTML=document.getElementById("txtBOName").value;
			}
		}
			ClearDetails(1)
}

function butSaveBuyingOfficeRequest() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
 		alert(xmlHttp.responseText);
		loadCombo( "SELECT intBuyingOfficeId, strName FROM buyerbuyingoffices where intStatus!=10 and intBuyerID='"+document.getElementById("cboAddinsCustomer").value+"' order by strName ","cboBoName");
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		}
		var url=pub_buyerUrl+"SearchData.php";
		url += "?RequestType=getBuyingOffcDetails&buyerId="+document.getElementById("cboAddinsCustomer").value;
		xmlHttp=GetXmlHttpObject();
		xmlHttp.onreadystatechange=BuyingOffDetailResponse;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
 	} 
}

function BuyingOffDetailResponse()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{
		ClearDetailsBO(1);
		document.getElementById("tblBuyerOffic").innerHTML = '';
		var color1 = "#498CC2";
		var color2 = "#498CC2";
		
		document.getElementById("tblBuyerOffic").innerHTML = xmlHttp.responseText;
		
	}
}

function ClearDetailsBO(obj)
{
	document.getElementById('txtBOName').value = "";
	document.getElementById('txtBOAddress1').value = "";
	document.getElementById('txtBOStreet').value = "";
	document.getElementById('txtBOCity').value = "";
	document.getElementById('cmbCountry').value = "";
	document.getElementById('txtBOPhone').value = "";
	document.getElementById('txtBOEmail').value = "";
	document.getElementById('txtBOWeb').value = "";
	document.getElementById('txtBORemarks').value = "";
	document.getElementById('txtBOState').value = "";
	document.getElementById('txtBOZipCode').value = "";
	document.getElementById('txtBOFax').value = "";
	document.getElementById("chkAddinsActive").checked=true;
	document.getElementById("txtBOName").focus();
}
//End 23-04-2010 Buying Office
//Start 23-04-2010 Buyer Division
function LoadBuyerDivisionWindow(obj)
{	
	var buyerID = document.getElementById('cboAddinsCustomer').value;
    var buyerCode = document.getElementById('txtAddinsBuyerCode').value;
	
	if(buyerID=="")
		return;
		
	//xmlHttp1=GetXmlHttpObject();
	//xmlHttp1.onreadystatechange=LoadBuyerDivisionWindowRequest;
	var url = pub_buyerUrl+'buttonIvents.php?q=loadBuyerDivs&buyerName='+buyerID;
	var xmlHttp1     	=$.ajax({url:url,async:false});
	var HTMLText=xmlHttp1.responseText;
			document.getElementById('mytable').innerHTML=HTMLText;	
	//xmlHttp1.send(null);
}

function LoadBuyerDivisionWindowRequest()
{
	if (xmlHttp1.readyState==4)
	{
		if (xmlHttp1.status==200)
		{
			var HTMLText=xmlHttp1.responseText;
			document.getElementById('mytable').innerHTML=HTMLText;				
		}
	}
}
	
function butSaveBuyerDivision()
{
	 if(document.getElementById('txtBDName').value.trim()=="" )
		{
			alert("Please enter Name");
			document.getElementById("txtBDName").focus();
			return false;
		}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
		alert ("Browser does not support HTTP Request");
		return;
 	} 
	
	var url=pub_buyerUrl+"buttonIvents.php";
	url=url+"?q=SaveBuyerDivisionDetails";
	url=url+"&intBuyerID="+URLEncode(document.getElementById("txtAddinsBuyerCode").value);
	url=url+"&bdID="+URLEncode(document.getElementById("cboDivisionName").value);
	url=url+"&bdName="+URLEncode(document.getElementById("txtBDName").value);
	url=url+"&bdRemarks="+URLEncode(document.getElementById("txtBDRemarks").value);
	
	if(document.getElementById("chkAddinsActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus; 
	
	xmlHttp.onreadystatechange=butSaveBuyerDivisionRequest;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function butSaveBuyerDivisionRequest() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
	    divisionSave = trim(xmlHttp.responseText);		
 		alert(xmlHttp.responseText);
		closeWindow();	
 	} 
}

function listORDetails(event,id)
{
	 document.frmBuyers.radioListORdetails[0].checked = false;
	 document.frmBuyers.radioListORdetails[1].checked = false;
	 var x= event.clientX ;
	 var y= event.clientY;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	{
		document.getElementById('divlistORDetails').style.visibility = "visible";
	}
	else
	{
		document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
}

function loadBuyerReport(){ 
 if(document.frmBuyers.radioListORdetails[0].checked == true){
	    var cboCustomer = document.getElementById('cboAddinsCustomer').value;
	    var radioListORdetails = document.frmBuyers.radioListORdetails[0].value;
		window.open(pub_buyerUrl+"BuyerReportList.php?cboCustomer=" + cboCustomer,"buyerR1"); 
		document.getElementById('divlistORDetails').style.visibility = "hidden";
 }else{
	 if(document.getElementById('cboAddinsCustomer').value != ""){
	  var cboCustomer = document.getElementById('cboAddinsCustomer').value;
	  
	  var radioListORdetails = document.frmBuyers.radioListORdetails[1].value;
      window.open(pub_buyerUrl+"BuyerReportDetails.php?cboCustomer=" + cboCustomer,"buyerR2"); 
	  document.getElementById('divlistORDetails').style.visibility = "hidden";
	 }else{
	   alert("Please select a Buyer");	 
	 }
 }
}

function addDivisions()
{
	var divName = cdata(document.getElementById('txtBDName').value);
	var divRemark = cdata(document.getElementById('txtBDRemarks').value);	

	if(divName.trim()=="" )
	{
		alert('Please enter "Buyer Division Name".');
		document.getElementById('txtBDName').focus();
		return false;
	}
	if(divRemark.trim() == "")
	{
		divRemark = '&nbsp';
	}
	
	var table = document.getElementById("mytable");
		table.border='0';
	var rowCount = table.rows.length;
	var arrDivCode=[];
	if(rowCount != 0)
	{
		for(var i=0;i<rowCount;i++)
		{
			arrDivCode[i]=table.rows[i].cells[2].childNodes[0].innerHTML;
		}
		for(var a=0;a<rowCount;a++)
		{	
			if(arrDivCode[a] == divName )
			{
				alert("Division already exist.");
				return false;
			}
		}
	}
		var row = table.insertRow(rowCount);
		row.className = "bcgcolor-tblrowWhite";
		var cell0 = row.insertCell(0);
		cell0.innerHTML="<input type='hidden' id='txtDivHidden' value='"+(rowCount+1)+"'/>";
		var cell1 = row.insertCell(1);
		cell1.width='20px';
		cell1.id=0;
		cell1.innerHTML="<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\"/>";
		var cell2 = row.insertCell(2);
		cell2.width='100px';
		cell2.innerHTML="<label id='txtD"+rowCount+"' name='txtD"+rowCount+"'>"+divName+"</lable>";
		var cell3 = row.insertCell(3);
		cell3.innerHTML="<label id='txtDR"+rowCount+"' name='txtDR"+rowCount+"'>"+divRemark+"</lable>";
		
		document.getElementById('txtBDName').value="";
		document.getElementById('txtBDRemarks').value="";
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	var rw = objDel.parentNode.parentNode;
	
	if(rw.cells[1].id != 0)
	{
		var url = "buttonIvents.php?q=deleteDivision&buyerDivId="+rw.cells[1].id;
		htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText ==1)
			tblMain.deleteRow(rowNo);
		else
			alert(htmlobj.responseText)
	}
	else
	{
		tblMain.deleteRow(rowNo);
	}
	//tblMain.deleteRow(rowNo);
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@	country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


function	showCountryPopUpInBuyer()
{
	var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 0;
	var H	= 258;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUpInBuyer";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}
	
function closeCountryModePopUpInBuyer(id)
{
	closePopUpArea(id);
	var sql = "SELECT intConID,strCountry FROM country WHERE intStatus <>10 order by strCountry";
	var control = "cboAddinsCountry";
	loadCombo(sql,control);
	document.getElementById('txtAddinsZipCode').value = "";
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
	
function loadBuyerOfficeDatatoCombo()
{
	var buyerID = document.getElementById('cboAddinsCustomer').value;
	var url=pub_buyerUrl+"SearchData.php";
	url += "?RequestType=getBuyingOffcmboDetails&buyerId="+document.getElementById("cboAddinsCustomer").value;
	createXMLHttpRequest(); 
	xmlHttp.onreadystatechange=BuyingOffCmbDetailResponse;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function BuyingOffCmbDetailResponse()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cboBoName').innerHTML = XMLText;
		}	
}

function chechoffice(str)
{
	var tbl=document.getElementById("tblBuyerOffic");
	var boffice="";
	var state=0;
	
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			
			if(boffice=tbl.rows[loop].cells[1].childNodes[0].nodeValue==str){
							
							state=1;}
		}
	if (state==1)
		return false;
	else 
		return true;
}

function buyer_GetCountryZipCode(id)
{
	
	document.getElementById('txtAddinsZipCode').value = getZipCode(id);
}