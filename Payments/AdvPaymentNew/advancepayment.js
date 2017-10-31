var strPaymentType =""
var xmlHttpTaxSave= [];
var xmlHttpGLSave = [];
var xmlHttpPOSave = [];
var incr =0;
var altxmlHttpArray = [];

	var url					='advancepaymentDB.php?DBOprType=load_GLID';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	event_setter();
	
	function event_setter(){
$('.txtbox.lastcellz').live('keydown', function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 9 || keyCode == 13) {	  
				addNewGLRow(this.parentNode.parentNode.rowIndex)
	  }
	});
	//document.getElementById('txtinvno').focus();
$('#frmsupinv').keypress(function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 120) {	  
				$('#butSave').trigger('click');
	  }
	});
}

//-----------------------------------------------------------------------------------

function isEnterKey(obj,evt,No,rowIndex)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13 || charCode == 9)
	 {
		var url="../supplierInvXML.php?RequestType=loadGLDetailstoGrid&GLID="+No;
		htmlobj=$.ajax({url:url,async:false});
		
		var XMLAccId				= htmlobj.responseXML.getElementsByTagName("accId");
		var XMLAccDes				= htmlobj.responseXML.getElementsByTagName("accDes");
		 
			if(XMLAccId[0].childNodes[0].nodeValue=="")
			{
				alert("No record.");
				currentModifyRowIndex = rowIndex;
				var tbl = document.getElementById('tblGLAccs');
				var conpc = tbl.rows[currentModifyRowIndex].cells[1].lastChild.nodeValue;
				obj.parentNode.innerHTML = obj.value;
				return;
			}
		
		var tbl = document.getElementById('tblGLAccs');
		var tbl_row_source = $('#tblGLAccs tr')
		var booCheck = false;
		for(var loopz=1;loopz<=tbl_row_source.length-1;loopz++)
		{
			if(tbl_row_source[loopz].cells[1].lastChild.nodeValue==No)
				booCheck = true;
		}
		if(booCheck)
		{
			alert("GL Acc Id already exist.")
			return;
		}
		var row = tbl.insertRow(rowIndex);
		row.className="bcgcolor-tblrowWhite";
				
		var cellCheck = row.insertCell(0);   
		cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
		
		var cellGLId = row.insertCell(1);
		cellGLId.id	 = XMLAccId[0].childNodes[0].nodeValue;
		cellGLId.ondblclick = changeToStyleTextBox;
		cellGLId.align ="left";
		cellGLId.innerHTML = No;  
		cellGLId.className = 'normalfnt';
		
		var cellDes = row.insertCell(2);
		cellDes.innerHTML = XMLAccDes[0].childNodes[0].nodeValue;
		cellDes.align ="left";
		cellDes.className = 'normalfnt';
		
		var cellAmt = row.insertCell(3);   
		cellAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox2(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this);\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\"  value=\""+ 0 +"\">"; 
				
		tbl.deleteRow(rowIndex+1);
		tbl.rows[rowIndex].cells[3].childNodes[0].select();
	 }
	 //event_setter()
  }
  
 //----------------------------------------------------------------------------------------------------------------------------------------------------------
 
 function setAmountToGlAcc(evt,obj)
{
	var tbl = document.getElementById("tblGLAccs");
	var amount   = $('#txtGLTotal').val();
	var glAmount = (obj.value==""?0:obj.value);
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 112)
	 {
		 var totAmt = parseFloat(amount)+parseFloat(glAmount);
		 obj.value = RoundNumbers(totAmt,2);
		 document.getElementById("txtGLTotal").value = RoundNumbers(0,2);
		 var row = obj.parentNode.parentNode.rowIndex;
		 tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
		 
		
	 }
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------
 
 function setFixedValue(value,row)
{
	if(value=="")
	value = 0;
	var tbl = document.getElementById('tblGLAccs');
	tbl.rows[row].cells[3].childNodes[0].value=RoundNumbers(value,2);
}


var th = ['','thousand','million', 'billion','trillion'];

var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];


var xmlHttpTax;

var xmlHttpPos;

var xmlHttpGLs;
var xmlHttpSave;
function CreateXMLHttpForAdvanceSave() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSave = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSave = new XMLHttpRequest();
    }
}

function CreateXMLHttpForTaxSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpTaxSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpTaxSave[index] = new XMLHttpRequest();
    }
}

function CreateXMLHttpForGLsSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpGLSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpGLSave[index] = new XMLHttpRequest();
    }
}

function CreateXMLHttpForPOsSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPOSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPOSave[index] = new XMLHttpRequest();
    }
}


function CreateXMLHttpForAdvPays() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpAdvs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpAdvs = new XMLHttpRequest();
    }
}
function CreateXMLHttpForAdvPaysGL() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpAdvsGL = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpAdvsGL = new XMLHttpRequest();
    }
}
function setLineNumber()
{
	var tbl = document.getElementById('tblGLAccs').tBodies[0];
	var count=0;
	for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			count++;
		}
	}
	var tblTax = document.getElementById('tblTax').tBodies[0];
	for(var loop = 0 ;loop < tblTax.rows.length ; loop ++){
		if(tblTax.rows[loop].cells[0].childNodes[0].checked)
		{
			count++;
		}
	}
/*	var tblFreight = document.getElementById('tblFreight').tBodies[0];
	var fC=0;
	for(var loop = 0 ;loop < tblFreight.rows.length ; loop ++){
		if(tblFreight.rows[loop].cells[0].childNodes[0].checked)
		{
				count++;
				fC=1;
		}
	}*/
/*	if(fC==0){
		if(Number(document.getElementById('txtFrightChargers').value.trim())!=0)
				count++;	
	}*/
/*	var tblCourier = document.getElementById('tblCourier').tBodies[0];
	var cC=0;
	for(var loop = 0 ;loop < tblCourier.rows.length ; loop ++){
		if(tblCourier.rows[loop].cells[0].childNodes[0].checked)
		{
			count++;
			cC=1;
		}
	}
	if(cC==0){
		if(Number(document.getElementById('txtCourierChargers').value.trim())!=0)
				count++;
	}*/
/*	var tblOther = document.getElementById('tblOther').tBodies[0];
	var cO=0;
	for(var loop = 0 ;loop < tblOther.rows.length ; loop ++){
		if(tblOther.rows[loop].cells[0].childNodes[0].checked)
		{
				count++;
		}
	}
	if(cC==0){
		if(Number(document.getElementById('txtBankChargers').value.trim())!=0)
			count++;
	}*/
	//document.getElementById('txtlineno').value=count;
}

//-------------------------------------------------------------------------------------------------------

function createAltXMLHttpRequestArray(index) 
{
    if (window.ActiveXObject) 
    {
        altxmlHttpArray[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttpArray[index] = new XMLHttpRequest();
    }
}

//-----------------------------------------------------------------------------------------------------

function saveFreihtCharges(supID,payNo){
	var tbl=document.getElementById('tblFreight').tBodies[0];
	var rc=tbl.rows.length;


	var path='advancepaymentDB.php?DBOprType=saveCharges&strPaymentType='+document.getElementById('cboPaymentType').value.trim()+'&payNo='+URLEncode(payNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tbladvancefreightgl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function saveInsuranceCharges(supID,payNo){
	var tbl=document.getElementById('tblCourier').tBodies[0];
	var rc=tbl.rows.length;

	var path='advancepaymentDB.php?DBOprType=saveCharges&strPaymentType='+document.getElementById('cboPaymentType').value.trim()+'&payNo='+URLEncode(payNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tbladvanceinsurancegl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function saveOtherCharges(supID,payNo){
	var tbl=document.getElementById('tblOther').tBodies[0];
	var rc=tbl.rows.length;

	var path='advancepaymentDB.php?DBOprType=saveCharges&strPaymentType='+document.getElementById('cboPaymentType').value.trim()+'&payNo='+URLEncode(payNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tbladvanceothergl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function setCharges(obj,control,tbl){
	var amt=0;
	var rc=tbl.rows.length;
	
	for(var i=1;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			amt=Number(amt)+Number(tbl.rows[i].cells[3].childNodes[0].value);			
		}
		else{
			tbl.rows[i].cells[3].childNodes[0].value=0;
		}
	}
	control.value=amt.toFixed(4);
	control.onchange();
}
function ShowAllGLAccounts()
{
	var SupID = document.getElementById("cboSuppliers").value;

	//showBackGround('divBG',0);
	var url = "GLAccpop.php";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(0,0,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}

//---------------------------------------------------------------------------------------------------------

function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

//---------------------------------------------------------------------------------------------------------

var checkGLfirstTime = 0;
function AddNewGLAccounttoMain(objevent)
{
	//alert(objevent);
	var tblall = document.getElementById('tblallglaccounts');
	
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{	
		var boolcheck = false;	
		if (tblall.rows[loop].cells[0].lastChild.checked == true)
		{
			var glAccId = tblall.rows[loop].cells[1].id;
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblGLAccs');
			
			var lastRow = tbl.rows.length;
			for(var i=1;i<lastRow;i++)
			{
				try
				{
					if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc)
					{
						boolcheck=true;
						
					}
				}
				catch(e)
				{
					checkGLfirstTime = 1;
				}
					
			}
			if(!boolcheck)
					{
							
						var row = tbl.insertRow(lastRow);
						row.className = "bcgcolor-tblrowWhite";
						
						var cell = row.insertCell(0);
						cell.className ="normalfntMid";	
						cell.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
						
						var cell = row.insertCell(1);
						cell.className ="normalfnt";
						cell.id		   = glAccId;
						cell.ondblclick = changeToStyleTextBox;
						cell.innerHTML = rwGLAcc;
						
						var cell = row.insertCell(2);
						cell.className ="normalfnt";
						cell.innerHTML = rwGLDesc;
						
						var cell = row.insertCell(3);
						cell.className ="normalfnt";
						cell.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"setTotGlVale();setAmountToGlAcc(event,this);\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\">";
						
				
						/*var cls;
						((lastRow % 2)==1)?cls='normalfnt':cls='normalfnt';
					    htm="<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div></td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+glAccId+"\">"+rwGLAcc+"</td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLDesc+"</td>";
						htm +="<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" onkeyup=\"clckGLBox(this);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\"></td>";
						 row.innerHTML=htm;*/
					}
					else
					{
						alert("GL Acc Id "+rwGLAcc+" Allready exist.");
					}
					
			
		}
	}
	// event_setter();
	if(checkGLfirstTime==1)
		tbl.deleteRow(1);
	checkGLfirstTime = 0;
		
}
//-------------------------------------------------------------------------------------------------------
function showGlPoup()
{
			var strGLAccounts="<table width=\"100%\" height=\"350\" border=\"0\" class=\"TitleN2white\"  bgcolor=\"#FFF\" >"+
            "<tr>"+
              "<td height=\"25\" bgcolor=\"#498CC2\" class=\"containers \" align=\"center\">GL Accounts</td>"+
            "</tr>"+
            "<tr class=\"tablezRED\">"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr>"+
                    "<td width=\"1%\" height=\"25\">&nbsp;</td>"+
                    "<td width=\"8%\" class=\"normalfnt\">Factory</td>"+
                    "<td width=\"50%\"><label>"+
                      "<select name=\"cboFactory\" onchange=\"getGLAccounts()\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\">"+
                      "</select>"+
                    "</label></td>"+
                    "<td width=\"1%\">&nbsp;</td>"+
                    "<td width=\"6%\"  class=\"normalfnt\">Acc.Like</td>"+
                    "<td width=\"8%\"> <input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
                    "<td width=\"8%\"><img src=\"../../images/search.png\" onclick=\"getGLAccounts()\" alt=\"ok\" width=\"86\" height=\"24\" /></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"350\"><table width=\"100%\" height=\"350\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"250\"><table width=\"93%\" height=\"350\" border=\"0\" class=\"bcgl1\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divGLAccs\" style=\"overflow: -moz-scrollbars-vertical; height:390px; width:650px;\" >"+
                              "<table class=\"grid_header\" width=\"630\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\">"+
                                "<thead><tr>"+
                                  "<td width=\"10%\" class=\"grid_header\">*</td>"+
                                  "<td width=\"20%\" class=\"grid_header\">GL Acc ID</td>"+
                                  "<td width=\"70%\" height=\"25\" class=\"grid_header\">Description</td>"+
                                  "</tr></thead><tbody></tbody>"+
                              "</table>"+
                          "</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">"+
                "<tr bgcolor=\"#D6E7F5\">"+
                  "<td align=\"right\"><img src=\"../../images/ok.png\" onclick=\"getSelectedGLAccounts()\" alt=\"ok\"  height=\"24\" /></td>"+   
                  "<td align=\"left\"><img src=\"../../images/close.png\" onclick=\"closeWindow()\"  height=\"24\" /></td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"
	
/*		var popupbox = document.createElement("div");
		popupbox.id = "popupGLAccounts";
		popupbox.style.position = 'absolute';
		popupbox.style.zIndex = 1;
		popupbox.style.left = 341 + 'px';
		popupbox.style.top = 10 + 'px';  
		popupbox.innerHTML = strGLAccounts;  
		document.body.appendChild(popupbox);*/
		
		drawPopupArea(665,495,'popupGLAccounts');
		document.getElementById('popupGLAccounts').innerHTML = strGLAccounts; 
		LoadFactoryList();
		//loadTaxTypes();
}

function closeWindow()
{
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

function initializeTheInterface()
{
	//LoadFactoryList();
	loadTaxTypes();
}

function checkValues()
{
	var poAmount=parseFloat(document.getElementById("txtPOAmount").value);
	var totGLAmt=0;
	
	if(parseFloat(document.getElementById("txtPOTotalAmount").value)==0 || isNaN(parseFloat(document.getElementById("txtPOTotalAmount").value))==true)
	{
		alert("Please select PO(s) to pay an advance.");
		return false;
	}
	
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	if(rows.length==1)
	{
		alert("Please Select the GL Account(s) of AccPac");
		document.getElementById("cmdShowGLs").focus();
		return false;
	}
	
	for(var loop=1;loop<rows.length;loop++)
	{
		cells=rows[loop].getElementsByTagName("TD");
		if(cells[0].firstChild.checked==true){
			var c=cells[3].firstChild.value;
			totGLAmt=parseFloat(totGLAmt)+Number(c);
		}
		
	}
	
	if(parseFloat(poAmount.toFixed(4))!=parseFloat(totGLAmt.toFixed(4)))
	{
		var diff=parseFloat(poAmount)-parseFloat(totGLAmt)
		diff=Math.round(diff*100)/100;
		alert("There is a different (" + parseFloat(diff) + ") between Amount of PO (" + parseFloat(poAmount) +") and the Total Amount of GL Acccount (" + parseFloat(totGLAmt) + ").The Total Amount of GL account and PO Amount should be equal")	;
		return false;
	}
	
	if(document.getElementById("cboBatchNo").value==0)
	{
		alert("Please select a \"AccPac Batch No\".");
		document.getElementById("cboBatchNo").focus();
		
		return false;
	}

	

	if(document.getElementById("cboCurrencyTo").value==0)
	{
		alert("Please select the Type of Currency of Advace Payment");
		document.getElementById("cboCurrencyTo").focus();	
		return false;
	}
	SaveAdvPayment();
}

function advclose()
{
	location = "../main.php";
	return;
}

function findSupGLAccs(supID)
{ 
	var url='advancepaymentDB.php?DBOprType=getSupGLList&supID=' + supID;
	htmlobj=$.ajax({url:url,async:false});
	var XMLAccNo = htmlobj.responseXML.getElementsByTagName("accNo");
	var XMLDesc = htmlobj.responseXML.getElementsByTagName("accName");
	var XMLfacId = htmlobj.responseXML.getElementsByTagName("facId"); 
	var XMLfacAccId = htmlobj.responseXML.getElementsByTagName("facAccId"); 
	
	var strPOTable="";
							  
			
			for ( var loop = 0; loop < XMLAccNo.length; loop ++)
			 {
				var AccNo = XMLAccNo[loop].childNodes[0].nodeValue;
				var Desc  = XMLDesc[loop].childNodes[0].nodeValue;
				var facId = XMLfacId[loop].childNodes[0].nodeValue;
				var facAccId=XMLfacAccId[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strPOTable+="<tr>"+
							"<td class=\""+cls+"\" style=\"text-align:center;\"><input type=\"checkbox\"  onclick=\"chkUnchk(this),setLineNumber()\"></td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+facId+"\">" + AccNo+""+facAccId + "</td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\">" + Desc + "</td>"+
							"<td class=\""+cls+"\"><input name=\"txtamount\" type=\"text\"style=\"width: 100px; text-align: right;\" class=\"txtbox\" id=\"txtamount\" size=\"20\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onkeyup=\"clckGLBox(this)\" onblur=\"addNewGLRow(this)\" maxlength=\"20\"/></td>"+
							"</tr>"
			 }
	document.getElementById("tblGLAccs").tBodies[0].innerHTML=strPOTable;
}

/*function validatePoAmount(obj){
	var amt		=	Number(obj.value.trim());
	var balance	=	Number(obj.parentNode.parentNode.childNodes[4].innerHTML);
	if(amt>balance)
		alert("\"Pay Amount\" should be less than or equal to \"PO Balance\".");
		return false;
}*/

function loadBatchNo(){
	var supplier   = document.getElementById('cboSuppliers').value;
	var CurrencyTo   = document.getElementById('cboCurrencyTo').value;
	var path = "advancePaymenSettelmenttDB.php?RequestType=loadBatchNo";
	    path += "&supplier="+supplier;
	    path += "&CurrencyTo="+CurrencyTo;

	htmlobj=$.ajax({url:path,async:false});	
	
	document.getElementById("cboBatchNo").innerHTML = htmlobj.responseText;
}

function findSupPOs()
{	
	
/*	document.getElementById('txtExRate2').value="";
	document.getElementById('txtExRate').value="";
	document.getElementById('cboCurrencyTo').value='0';
	document.getElementById('cboBatchNo').value='0';
	document.getElementById('tblGLAccs').rows[0].cells[0].childNodes[0].checked=false;
	document.getElementById('tblTax').rows[0].cells[0].childNodes[0].checked=false;
	document.getElementById('tblTax').rows[0].cells[0].childNodes[0].onclick();
	document.getElementById('txtlineno').value="";
	clearCharges();
	document.getElementById('tblPOList').rows[0].cells[0].childNodes[0].checked=false;
	document.getElementById('tblPOList').rows[0].cells[0].childNodes[0].onclick();
	document.getElementById('tblPOList').tBodies[0].innerHTML="";*/
	var supID=document.getElementById("cboSuppliers").value.trim();
	
	//alert(document.getElementById('cboBatchNo').value);
	getPos(document.getElementById('cboBatchNo').value.trim());
	//findSupGLAccs(supID);
	setTax(supID);
	getSuopCurrency(supID);
	LoadSupplierGL();
	//loadBatchNo();
	
}

//------------------------------------------------------------------------------
function setTotGlVale()
{   
	var glTbl	= document.getElementById('tblGLAccs');
	var taxTbl 	= document.getElementById('tblTax');
	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txtPOAmount').value)==""?0:(document.getElementById('txtPOAmount').value));
	

	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id=='0' )
		{
			var NBTrate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((glTotValue*NBTrate)/100,2);
			taxTotAmount += parseFloat((taxTbl.rows[i].cells[3].childNodes[0].value == ""?0:taxTbl.rows[i].cells[3].childNodes[0].value));	
			
		}
		else if (taxTbl.rows[i].cells[0].childNodes[0].checked == false)
			taxTbl.rows[i].cells[3].childNodes[0].value = 0.00;
	}
	var totalOtherAmount = parseFloat(RoundNumbers(glTotValue+taxTotAmount,2));
	document.getElementById('txtcommission').value = RoundNumbers(totalOtherAmount,2);
	
	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id!='0' )
		{
			var rate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((totalOtherAmount*rate)/100,2);
			taxAmount	+= parseFloat(RoundNumbers((totalOtherAmount*rate)/100,2));
		}
	}
	
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{ 
		if(glTbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{ 
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}
	
	document.getElementById('txtTaxAmount').value = RoundNumbers(taxAmount,2);
	//document.getElementById('txtinvoiceamount').value = RoundNumbers(totalOtherAmount+taxAmount,2);
	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue+taxTotAmount)-glTotAmount,2);
}

//------------------------------------------------------------------------------
function LoadSupplierGL()
{
	var SupID = 1;
	var FacCd = 2;	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadSupplierGL;
	altxmlHttpArray[incr].open("GET",'../supplierInvXML.php?RequestType=LoadSupplierGL&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleLoadSupplierGL()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        { 
			/*var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");*/
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			var XMLAccNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accNo");
			var XMLDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accName");
			var XMLfacId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("facId"); 
			var XMLfacAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("facAccId"); 
			var boolcheck = false;
			var tableText = "<table width=\"408\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblGLAccs\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"20\" height=\"20\" >*</td>" +
							 "<td width=\"82\" >GL Acc Id</td>" +
              				 "<td width=\"200\" >Description</td>" +
              				 "<td width=\"90\" >Amount</td>" + 
						 "</tr>";
						 
				
				for(var loop = 0; loop < XMLAccNo.length; loop++)
				{
					var accNo=XMLAccNo[loop].childNodes[0].nodeValue;
					var accName=XMLDesc[loop].childNodes[0].nodeValue;
					var facId=XMLfacId[loop].childNodes[0].nodeValue;
					var facAccId=XMLfacAccId[loop].childNodes[0].nodeValue;
						
					var selection = "";
					var GLAmt = 0 ;
					
				/*	if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else*/
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\"  />";
			
						tableText += "<tr class=\"bcgcolor-tblrowWhite\">"+
									"<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\"normalfnt\" id=\"" +facId + "\" style=\"text-align:left;\">" + accNo+""+facAccId + "</td>" +
									"<td class=\"normalfnt\" id=\"" + XMLDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" +accName + "</td>" +
									"<td class=\"normalfnt\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this)\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" value=\""+ GLAmt +"\"> " +
									"</input></td>" +
									"</tr>";
					boolcheck = true;
				}
				tableText+="</table>";
				document.getElementById("divconsOfSelGLs").innerHTML = tableText;
				if(!boolcheck)
				{
					
					var tbl = document.getElementById('tblGLAccs');
					
					var lastRow = document.getElementById('tblGLAccs').rows.length;	
					var row = tbl.insertRow(lastRow);
					row.className="bcgcolor-tblrowWhite";
						
					var cellCheck = row.insertCell(0);   
					cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" disabled=\"disabled\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
					
					var cellGLId = row.insertCell(1);
					cellGLId.ondblclick = changeToStyleTextBox;
					 
					var cellDescription = row.insertCell(2);  
					
					var cellAmt = row.insertCell(3);
				}
			//	event_setter();
		}
	}
}

//----------------------------------------------------------------------------

function changeToStyleTextBox()
{
	
	var obj = this;
	
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	obj.align = "Left";
	obj.innerHTML ="<input type=\"text\" name=\"txtGLID\" id=\"txtGLID\" onkeydown=\"isEnterKey(this,event,this.value,this.parentNode.parentNode.rowIndex);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event,this.value);\" class=\"txtbox\" value =\"\" size=\"13\" >";
	
	obj.childNodes[0].focus();
	
	$( "#txtGLID" ).autocomplete({
		source: pub_po_arr
	});
}

//------------------------------------------------------------------------

function getPos(batch){
	delect_table_content("tblPOList");
	clearChrsAndAmnt();
	var supID=document.getElementById("cboSuppliers").value.trim();
	//setTax(supID);
		var batchCurrency;
	/*if(batch=='0'){
		
	}*/
	batchCurrency=document.getElementById('cboCurrencyTo').value.trim();
	var type = document.getElementById('cboPaymentType').value.trim();
	var batch = document.getElementById('cboBatchNo').value;

	var desc=document.getElementById("cboSuppliers").options[document.getElementById("cboSuppliers").selectedIndex].text;
	document.getElementById('txtDescription').value=desc.substr(0,6);
	var url='advancepaymentDB.php?DBOprType=getSupPOList&strPaymentType=' + type + '&supID=' + supID+'&bCrr='+batchCurrency+'&batchId='+batch;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLPONo = htmlobj.responseXML.getElementsByTagName("poNo");
	var XMLCurrency = htmlobj.responseXML.getElementsByTagName("currency");
	var XMLPOAmt = htmlobj.responseXML.getElementsByTagName("poAmount");
	var XMLPOBal = htmlobj.responseXML.getElementsByTagName("poBalance");
	var XMLPayTerm = htmlobj.responseXML.getElementsByTagName("payTerm");
	var XMLPayCur = htmlobj.responseXML.getElementsByTagName("payCurrency");
			
	var strPOTable="";
							  
			
			for ( var loop = 0; loop < XMLPONo.length; loop ++)
			 {
				var poNo = XMLPONo[loop].childNodes[0].nodeValue;
				var currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var poAmount = XMLPOAmt[loop].childNodes[0].nodeValue;
				var poBalance = XMLPOBal[loop].childNodes[0].nodeValue;
				var payTerm = XMLPayTerm[loop].childNodes[0].nodeValue;
				var payCur=XMLPayCur[loop].childNodes[0].nodeValue;
				/*if(document.getElementById('cboBatchNo').value.trim()==0){
					document.getElementById("cboCurrencyTo").value=payCur;
				}*/

				if(poBalance=="")
				{
				poBalance=poAmount;
				}
				var poPaidAmt=poAmount-poBalance;
				
				var intPoNo		= 	poNo.split('/')[0];
				var intPoYear	= 	poNo.split('/')[1];
				
				var linkPo		=	"<a target=\"_blank\" href=\"../reportpurchase.php?pono="+intPoYear+"&year="+intPoNo+"\">";
				
				//alert(linkPo);
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2"
					strPOTable+="<tr>"+
								  "<td class=\""+cls+"\"><input type=\"checkbox\" onclick=\"setPOValue();clearf(this),changeRates(this);\"  name=\"chkSelPo\" id=\"chkSelPo\" /></td>"+
								  "<td class=\""+cls+"\">" + linkPo  + poNo + "</a></td>"+
								  "<td class=\""+cls+"\" id=\""+ payCur +"\" style=\"text-align:left\">" + currency + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\">" + parseFloat(poAmount).toFixed(4) + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\">" + parseFloat(poPaidAmt).toFixed(4) + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\">" + parseFloat(poBalance).toFixed(4)  + "</td>"+
								  "<td align=\"center\" class=\""+cls+"\"><input type=\"text\" name=\"txtPayAmt\"  id=\"txtPayAmt\" style=\"text-align:right\"   class=\"txtbox\"   style=\"height:14px\"  value="+ parseFloat(poBalance).toFixed(4) + "  onkeyup=\"clckBox(this),validatePoValue(this);\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"></td>"+
								  "<td class=\""+cls+"\" style=\"text-align:left\">" + payTerm + "</td>"+
								"</tr>"
				

			 }
	grid_fix_header_poList();		
	document.getElementById("tblPOList").tBodies[0].innerHTML=strPOTable;

}
function getSuopCurrency(supID){
	var path="advancepaymentDB.php?DBOprType=getSupCurrency&supId="+supID;
	htmlobj=$.ajax({url:path,async:false});
	var XMLCurrency=htmlobj.responseXML.getElementsByTagName("CurrencyId");
	var XMlRate=htmlobj.responseXML.getElementsByTagName("rate");
	
	document.getElementById('cboCurrencyTo').value=XMLCurrency[0].childNodes[0].nodeValue;
	document.getElementById('txtExRate').value=XMlRate[0].childNodes[0].nodeValue;
}

function clckBox(obj){
	obj.parentNode.parentNode.cells[0].childNodes[0].checked=true;	
	setPOValue();
}
function clckGLBox(obj){
	obj.parentNode.parentNode.cells[0].childNodes[0].checked=true;	
	//obj.parentNode.parentNode.cells[0].childNodes[0].onclick();
	//setLineNumber();
	//setPOValue();
}

function clckGLBox2(value,row)
{
	var tbl = document.getElementById('tblGLAccs');
	if(value == 0 || value == "")
	{
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = false;
	}
	else
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
}
//===============================================================================================================
function setTax(supID){
	clearTax();
	var url  = 'advancepaymentDB.php?DBOprType=setTaxTypes&supID='+supID;
	htmlobj=$.ajax({url:url,async:false});		
/*	var Suptax  = htmlobj.responseXML.getElementsByTagName("suptax"); 
	var SuptaxId=0;
	var tblTax=document.getElementById('tblTax').tBodies[0];
	var rc=tblTax.rows.length;
	if(Suptax.length>0){
		SuptaxId	= Suptax[0].childNodes[0].nodeValue;
		for(var x=0;x<rc;x++)
		{
			if(tblTax.rows[x].cells[0].id==SuptaxId)
			{
				tblTax.rows[x].cells[0].childNodes[0].checked=true;
			}
			else
			{
				tblTax.rows[x].cells[0].childNodes[0].checked=false;
			}
		}
	}*/
	
}
//========================================================================	
function loadTaxTypes()
{
	var url= 'advancepaymentDB.php?DBOprType=getTaxTypes';
	htmlobj=$.ajax({url:url,async:false});
 
	var XMLTaxID = htmlobj.responseXML.getElementsByTagName("taxTypeID");
	var XMLTaxType = htmlobj.responseXML.getElementsByTagName("taxType");
	var XMLTaxRate = htmlobj.responseXML.getElementsByTagName("taxRate");

 	var strTaxTbl="<table width=\"450\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normaltxtmidb2\" id=\"tblTax\">"+
						  "<tr>"+
							"<td bgcolor=\"#498CC2\" width=\"20\" height=\"22\" class=\"grid_header\">*</td>"+
							"<td bgcolor=\"#498CC2\" width=\"70\" class=\"grid_header\">Tax</td>"+
							//"<td bgcolor=\"#498CC2\" width=\"10\" class=\"grid_header\"></td>"+
							"<td bgcolor=\"#498CC2\" width=\"40\" class=\"grid_header\">Rate</td>"+
							"<td bgcolor=\"#498CC2\" width=\"80\" class=\"grid_header\">Value</td>"+

						  "</tr>"
	for ( var loop = 0; loop < XMLTaxID.length; loop++)
			 {
				var taxID = XMLTaxID[loop].childNodes[0].nodeValue;
				var taxType = XMLTaxType[loop].childNodes[0].nodeValue;
				var taxRate = parseFloat(XMLTaxRate[loop].childNodes[0].nodeValue);
				
				
				
				
				taxRate = taxRate.toFixed(4);
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strTaxTbl+="<tr>"+
								"<td width=\"20\" class=\""+cls+"\" id=\""+taxID+"\" ><input type=\"checkbox\" onclick=\"setPOValue()\" onmouseover=\"highlight(this.parentNode)\" name=\"chkSelTax\" id=\"chkSelTax\" /></td>"+
								"<td width=\"70\" onmouseover=\"highlight(this.parentNode)\"  class=\""+cls+"\" style=\"text-align:left\">" + taxType + "</td>"+
								//"<td width=\"10\"  class=\""+cls+"\"></td>"+
								"<td width=\"40\"  class=\""+cls+"\" style=\"text-align:right\">" + taxRate + "</td>"+
								"<td width=\"80\"  class=\""+cls+"\" style=\"text-align:right\">0.00</td>"
								
							"</tr>"
				
			 }
			 
			 strTaxTbl+="</table>"
			 document.getElementById("divTaxType").innerHTML=strTaxTbl;
}


function showGLAccounts(booGLOk)
{
	try
	{
		if(booGLOk==true)
		{
			document.getElementById('popupGLAccounts').style.visibility = 'visible';
			document.getElementById('txtNameLike').value=""
			document.getElementById('cboFactory').value=0
			var strGLAccs="<table bgcolor=\"#FFFFE1\" width=\"460\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\">"+
							"<tr>"+
							  "<td width=\"39\" bgcolor=\"\" class=\"grid_header\">*</td>"+
							  "<td width=\"102\" bgcolor=\"\" class=\"grid_header\">GL Acc ID</td>"+
							  "<td width=\"269\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
							  "</tr>"+
						  "</table>"
							  
			document.getElementById('divGLAccs').innerHTML=strGLAccs;
		}
		else
		{
			document.getElementById('popupGLAccounts').style.visibility = 'hidden';
		}
	}
	catch(err)
	{        
	}	
	
}
function setTaxValue(obj){
	if(obj.parentNode.parentNode.cells[0].childNodes[0].checked==true){
		setPOValue2();	
	}	
	else{
		obj.parentNode.parentNode.cells[3].childNodes[0].value="";
		setPOValue2();	
	}
}

function setPOValue2(){
	
	var glTbl	= document.getElementById('tblGLAccs');
	var taxTbl 	= document.getElementById('tblTax');
	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txtPOAmount').value)==""?0:(document.getElementById('txtPOAmount').value));
    for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id=='0' )
		{
			var NBTrate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((glTotValue*NBTrate)/100,4);
			taxTotAmount += parseFloat((taxTbl.rows[i].cells[3].childNodes[0].value == ""?0:taxTbl.rows[i].cells[3].childNodes[0].value));	
			
		}
		else if (taxTbl.rows[i].cells[0].childNodes[0].checked == false)
			taxTbl.rows[i].cells[3].childNodes[0].value = 0.0000;
	}
	
	var totalOtherAmount = parseFloat(RoundNumbers(glTotValue+taxTotAmount,4));
	document.getElementById('txtcommission').value = RoundNumbers(totalOtherAmount,4);
	
	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id!='0' )
		{ 
			var rate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((totalOtherAmount*rate)/100,4);
			taxAmount	+= parseFloat(RoundNumbers((totalOtherAmount*rate)/100,4));
		}
	}
	
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{
		if(glTbl.rows[loop].cells[0].childNodes[0].checked)
		{
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}
	
	document.getElementById('txtTaxAmount').value = RoundNumbers(taxAmount,4);
	document.getElementById('txtPOTotalAmount').value = RoundNumbers(totalOtherAmount+taxAmount,4);
	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue+taxTotAmount)-glTotAmount,4);
}

function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}

function setPOValue()
{ 
	var payAmount=0;
	var amt=parseFloat(document.getElementById("txtPOAmount").value);

	var extAmt=0//amtDraft+
	var taxTot=0
	var nbtVal=0
	
	rows=document.getElementById('tblPOList').getElementsByTagName("TR");
	for(var loop=1;loop<rows.length;loop++)
	{
		cells=rows[loop].getElementsByTagName("TD");
		if(cells[0].firstChild.checked == true)
		{
			if(cells[6].firstChild.value!="")
				payAmount=payAmount+parseFloat(cells[6].firstChild.value);				
			//document.getElementById('cboCurrencyTo').value=cells[2].innerHTML;

		}
		else{
			cells[6].firstChild.value=cells[5].innerHTML;
		}
	}
	
	setDescription();
	
	if(amt=="" || isNaN(amt)==true )	{ amt=0	}
	
	var txtBankCharge = document.getElementById("txtBankCharge").value;
	var txtHandleCharge = document.getElementById("txtHandleCharge").value;
	var txtFreightCharge = document.getElementById("txtFreightCharge").value;
	var txtOtherCharge = document.getElementById("txtOtherCharge").value;
	
	if(txtBankCharge == ''){
		txtBankCharge = 0;
	}
	if(txtHandleCharge == ''){
		txtHandleCharge = 0;
	}
	if(txtFreightCharge == ''){
		txtFreightCharge = 0;
	}
	if(txtOtherCharge == ''){
		txtOtherCharge = 0;
	}

	var totCharges = parseFloat(txtBankCharge)+parseFloat(txtHandleCharge)+parseFloat(txtFreightCharge)+parseFloat(txtOtherCharge);
    //var totAmt = payAmount.toFixed(4);
	
	//var totAmt = payAmount.toFixed(4);
	
	var totAmt = (totCharges + payAmount).toFixed(4);
	//alert(totAmt);
	
	//totAmt = Math.round(totAmt*100)/100;
	
	document.getElementById("txtPOAmount").value=totAmt;
	document.getElementById("txtPOAmount").title=totAmt;	
	document.getElementById("txtPOTotalAmount").value=totAmt;
		
	var glTbl	= document.getElementById('tblGLAccs');
	var taxTbl 	= document.getElementById('tblTax');
	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txtPOAmount').value)==""?0:(document.getElementById('txtPOAmount').value));
    for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id=='0' )
		{
			var NBTrate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((glTotValue*NBTrate)/100,4);
			taxTotAmount += parseFloat((taxTbl.rows[i].cells[3].childNodes[0].value == ""?0:taxTbl.rows[i].cells[3].childNodes[0].value));	
			
		}
		else if (taxTbl.rows[i].cells[0].childNodes[0].checked == false)
			taxTbl.rows[i].cells[3].childNodes[0].value = 0.0000;
	}
	
	var totalOtherAmount = parseFloat(RoundNumbers(glTotValue+taxTotAmount,4));
	document.getElementById('txtcommission').value = RoundNumbers(totalOtherAmount,4);
	
	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id!='0' )
		{ 
			var rate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((totalOtherAmount*rate)/100,4);
			taxAmount	+= parseFloat(RoundNumbers((totalOtherAmount*rate)/100,4));
		}
	}
	
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{
		if(glTbl.rows[loop].cells[0].childNodes[0].checked)
		{
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}
	
	document.getElementById('txtTaxAmount').value = RoundNumbers(taxAmount,4);
	document.getElementById('txtPOTotalAmount').value = RoundNumbers(totalOtherAmount+taxAmount,4);
	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue+taxTotAmount)-glTotAmount,4);
	
	setTotGlVale();
}

function setTaxValueChange(){
	var nTax=0;
	var totAmt=0;
	rows=document.getElementById('tblTax').getElementsByTagName("TR");
/*	if(obj.parentNode.parentNode.cells[0].firstChild.checked){
		
		nTax=Number(obj.value.trim());
	}*/
	for(var x=1;x<rows.length;x++)
	{
		cells=rows[x].getElementsByTagName("TD");
		
		if(cells[0].firstChild.checked==true)
		{					
			totAmt=totAmt+Number(cells[3].childNodes[0].value.trim());
		}
	}
	document.getElementById('txtTaxAmount').value=totAmt.toFixed(4);
	var amtFrightChargers=Number(document.getElementById("txtFrightChargers").value);
	//var amtDiscount=Number(document.getElementById("txtDiscount").value);
	var amtCourierChargers=Number(document.getElementById("txtCourierChargers").value);
	var amtBankChargers=Number(document.getElementById("txtBankChargers").value);
	
	var extAmt=amtFrightChargers+amtCourierChargers+amtBankChargers;

	var totalAmt=Number(document.getElementById("txtPOAmount").value);
	document.getElementById("txtPOTotalAmount").value=(totAmt+extAmt+totalAmt);
}
function setDescription(){
	var suplier=document.getElementById("cboSuppliers").options[document.getElementById("cboSuppliers").selectedIndex].text.substring(0,5);
	var desc="";
	rows=document.getElementById('tblPOList').getElementsByTagName("TR");
	for(var loop=1;loop<rows.length;loop++)
	{
		cells=rows[loop].getElementsByTagName("TD");
		if(cells[0].firstChild.checked == true)
		{
			document.getElementById('cboCurrencyTo').value=cells[2].innerHTML;
			desc=desc+"-"+cells[1].childNodes[0].childNodes[0].nodeValue	
		}
	}
	document.getElementById("txtDescription").value=suplier+desc;
}
function clearf(obj)
{
	var tblGL=document.getElementById('tblGLAccs');
	var rc=tblGL.rows.length;
	if(obj.checked==false){
		for(var i=1;i<rc;i++){
			tblGL.rows[i].cells[2].childNodes[0].value ="0.00";
			
		}
		//document.getElementById("txtFrightChargers").value ='0';
		//document.getElementById("txtDiscount").value ='0';
		//document.getElementById("txtCourierChargers").value ='0';
		//document.getElementById("txtBankChargers").value ='0';
		//document.getElementById("txtDiscount").value ='0';
		
		//document.getElementById("txtFrightChargers").style.backgroundColor ="#ffffff";
		//document.getElementById("txtDiscount").style.backgroundColor ="#ffffff";
		//document.getElementById("txtCourierChargers").style.backgroundColor ="#ffffff";
		//document.getElementById("txtBankChargers").style.backgroundColor ="#ffffff";
		//document.getElementById("txtDiscount").style.backgroundColor ="#ffffff";
	}
		
}
function LoadFactoryList()
{
    var url='advancepaymentDB.php?DBOprType=getFactoryList';
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLFactoryID = htmlobj.responseXML.getElementsByTagName("compID");
	var XMLFactoryName = htmlobj.responseXML.getElementsByTagName("compName");
	
	clearSelectControl("cboFactory");
	var optFirst = document.createElement("option");			
		optFirst.text = "";
		optFirst.value = 0;
		document.getElementById("cboFactory").options.add(optFirst);
		for ( var loop = 0; loop < XMLFactoryID.length; loop ++){
				var FactoryID = XMLFactoryID[loop].childNodes[0].nodeValue;
				var FactoryName = XMLFactoryName[loop].childNodes[0].nodeValue;
				var optFactory = document.createElement("option");
				
				optFactory.text =FactoryName.toUpperCase() ;
				optFactory.value = FactoryID;
				//alert(FactoryName + "   " + FactoryID);
				
				document.getElementById("cboFactory").options.add(optFactory);
			 }
			 document.getElementById("cboFactory").value=0;
}

function loadCurrencyType()
{
    var url='advancepaymentDB.php?DBOprType=getTypeOfCurrency';
	htmlobj=$.ajax({url:url,async:false});
	var XMLCurrType = htmlobj.responseXML.getElementsByTagName("currType");
	var XMLCurrRate = htmlobj.responseXML.getElementsByTagName("currRate");
			
	clearSelectControl("cboCurrencyTo");
			
	var optFirst = document.createElement("option");			
		optFirst.text = "";
		optFirst.value = 0;
			
	document.getElementById("cboCurrencyTo").options.add(optFirst);
				
	for ( var loop = 0; loop < XMLCurrType.length; loop ++){
		var currType = XMLCurrType[loop].childNodes[0].nodeValue;
		var currRate = XMLCurrRate[loop].childNodes[0].nodeValue;
		var optCurr = document.createElement("option");
			optCurr.text =currType ;
			optCurr.value = currType;
				//optCurr.value = currRate;
			document.getElementById("cboCurrencyTo").options.add(optCurr);
		}
		document.getElementById("cboCurrencyTo").value=0;
}

function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
		nameLike =nameLike.trim();
	var url='../supplierInvXML.php?RequestType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike;
	htmlobj=$.ajax({url:url,async:false});
	
	$('#tblallglaccounts tr:gt(0)').remove();
	
	var XMLaccNo = htmlobj.responseXML.getElementsByTagName("accNo");
	var XMLaccName = htmlobj.responseXML.getElementsByTagName("accDes");
	var XMLAccountNo = htmlobj.responseXML.getElementsByTagName("AccountNo");	
	var XMLGLAccID = htmlobj.responseXML.getElementsByTagName("GLAccID");
	
			var strGLAccs="";
				  
			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo 		= XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes 		= XMLaccName[loop].childNodes[0].nodeValue;
				var AccountNo   = XMLAccountNo[loop].childNodes[0].nodeValue;
				var GLAccID   = XMLGLAccID[loop].childNodes[0].nodeValue;
				
				var tbl 		= document.getElementById('tblallglaccounts');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				row.className = "bcgcolor-tblrowWhite";
				
				var cell = row.insertCell(0);
				cell.className ="normalfntMid";
				cell.innerHTML = "<input type=\"checkbox\" name=\"chkSelGLAcc\" id=\"chkSelGLAcc\"/>";
				
				var cell = row.insertCell(1);
				cell.className ="normalfnt";
				cell.id		   = GLAccID;
				cell.innerHTML = accNo+""+AccountNo;
				
				var cell = row.insertCell(2);
				cell.className ="normalfnt";
				cell.innerHTML = accDes;
			}		
			
}

function getSelectedGLAccounts()
{
/*	
	var glrows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	
	var strSelGLs="";
	for(var loop=1;loop<glrows.length;loop++)
	{
		var glcells=glrows[loop].getElementsByTagName("TD");
		
			var accNo=(glcells[1].firstChild.nodeValue)
			var accName=(glcells[2].firstChild.nodeValue)
			
			var cls;
			(loop%2==0)?cls="grid_raw":cls="grid_raw2";
			if(glcells[0].firstChild.firstChild.checked == true)
			{
				strSelGLs+="<tr><td  class=\""+cls+"\"><input type=\"checkbox\"></td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\">" + accNo + "</td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\">" + accName + " </td>"+
							"<td class=\""+cls+"\"><input type=\"text\"  style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\"  class=\"txtbox\"  name=\"txtGLAmount\" id=\"txtGLAmount\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event); \"/></td>"+
						  "</tr>"
			
						
			}
	}
	strSelGLs+="</table>"
	document.getElementById("tblGLAccs").tBodies[0].innerHTML=strSelGLs;*/
	
	var tblall = document.getElementById('tblGLAccs').tBodies[0];
		
	for ( var loop = 0 ;loop < tblall.rows.length ; loop ++ )
	{	
		if (tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLId = tblall.rows[loop].cells[1].id;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblGLAccs').tBodies[0];
			
			var lastRow = tbl.rows.length;	
			for(var i=0;i<lastRow;i++){
				if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc){
					alert("GL Acc Id Allready exist.");
					tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked=false;
					return false;
				}
			}
			var row = tbl.insertRow(lastRow);
			
			/*var cellGLChk = row.insertCell(0);
			cellGLChk.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div>";
			
			var cellGLAcc = row.insertCell(1);
			cellGLAcc.innerHTML = rwGLAcc;
			
			var cellGLDesc = row.insertCell(2);
			cellGLDesc.innerHTML = rwGLDesc;
			
			var cellGLAmt = row.insertCell(3);
			cellGLAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\">";			
			*/
			var cls;
			((lastRow % 2)==0)?cls='grid_raw':cls='grid_raw2';
			var htm="<td class=\""+cls+"\" style=\"text-align:left;\"><input type=\"checkbox\" onclick=\"chkUnchk(this),setLineNumber();\"/></td>";
			htm +="<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+rwGLId+"\">"+rwGLAcc+"</td>";
			htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLDesc+"</td>";
			htm +="<td class=\""+cls+"\"><input name=\"txtamount\" type=\"text\" style=\"text-align:right\"  class=\"txtbox\" id=\"txtamount\" size=\"15\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" onkeyup=\"clckGLBox(this)\" onblur=\"addNewGLRow(this)\" /></td>";
			 row.innerHTML=htm;
		}
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------------

function checkUncheckTextBox(objevent)
{ 
	var tbl = document.getElementById('tblGLAccs');
	var rw = objevent.parentNode.parentNode.parentNode; 
	var tAmt	=document.getElementById('txtPOAmount');
	if (rw.cells[0].childNodes[0].childNodes[0].checked == true)
	{ 
		rw.cells[3].childNodes[0].focus();
	}
	else if(rw.cells[0].childNodes[0].childNodes[0].checked == false) 
	{
		rw.cells[3].childNodes[0].value = "";
	}
	setTotGlVale();
	
}
//------------------------------------------------------------------------------------------------------------------------------------------------

function addNewGLRow(rowIndex)
{	
	var tbl=document.getElementById('tblGLAccs');
	var rc=tbl.rows.length;
	
		if(rc==rowIndex+1)
		{
		
			var row = tbl.insertRow(rc);
			row.className="bcgcolor-tblrowWhite";
			
				
			var cellCheck = row.insertCell(0);   
			cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" disabled=\"disabled\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
			
			var cellGLId = row.insertCell(1);
			cellGLId.ondblclick = changeToStyleTextBox;
			cellGLId.align = "Left";
			cellGLId.innerHTML ="<input type=\"text\" name=\"txtGLID\" id=\"txtGLID\" onkeydown=\"isEnterKey(this,event,this.value,this.parentNode.parentNode.rowIndex);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event,this.value);\" class=\"txtbox\" value =\"\" size=\"13\">";
	document.getElementById('txtGLID').focus();
	$( "#txtGLID" ).autocomplete({
		source: pub_po_arr
	});
			 
			var cellDescription = row.insertCell(2);  
			
			var cellAmt = row.insertCell(3);  
			
				
	}
}


function chkUnchk(obj){
	obj.parentNode.parentNode.cells[3].childNodes[0].value="";
	obj.parentNode.parentNode.cells[3].childNodes[0].focus();
}

function chkUnchkAll(obj,tbl){

	var tbl=document.getElementById(tbl).tBodies[0];
	var rc=tbl.rows.length;
	if(obj.checked){
		for(var i=0;i<rc;i++){
			tbl.rows[i].cells[0].childNodes[0].checked=true;	
			tbl.rows[i].cells[0].childNodes[0].onclick();
		}
	}
	else{
		for(var i=0;i<rc;i++){
			tbl.rows[i].cells[0].childNodes[0].checked=false;
			tbl.rows[i].cells[0].childNodes[0].onclick();
		}
	}
}

function LoadAccPackBatches()
{
    var url='advancepaymentDB.php?DBOprType=getBatches';
	htmlobj=$.ajax({url:url,async:false});
	var XMLbatchID = htmlobj.responseXML.getElementsByTagName("batchID");
	var XMLbatchDes = htmlobj.responseXML.getElementsByTagName("batchDes");
			clearSelectControl("cboBatchNo");
			
			var optStorex = document.createElement("option");			
			optStorex.text = "";
			optStorex.value = 0;
			document.getElementById("cboBatchNo").options.add(optStorex);
				
			for ( var loop = 0; loop < XMLbatchID.length; loop ++)
			 {
				var batchID = XMLbatchID[loop].childNodes[0].nodeValue;
				var batchDes = XMLbatchDes[loop].childNodes[0].nodeValue;
				var optStore = document.createElement("option");
				
				optStore.text = batchDes;
				optStore.value = batchID;
				document.getElementById("cboBatchNo").options.add(optStore);
			 }
			 document.getElementById("cboBatchNo").value=0;
}

function LoadSuppliers()
{
	var url='advancepaymentDB.php?DBOprType=getSupList';
	htmlobj=$.ajax({url:url,async:false});
	var XMLSupID = htmlobj.responseXML.getElementsByTagName("supID");
	var XMLSupName = htmlobj.responseXML.getElementsByTagName("supName");
	
	clearSelectControl("cboSuppliers");
			
	var optStorex = document.createElement("option");			
	optStorex.text = "";
	optStorex.value = 0;
	document.getElementById("cboSuppliers").options.add(optStorex);
				
	for ( var loop = 0; loop < XMLSupID.length; loop ++)
	{
		var SupID = XMLSupID[loop].childNodes[0].nodeValue;
		var SupName = XMLSupName[loop].childNodes[0].nodeValue;
		var optStore = document.createElement("option");
				
		optStore.text = SupName;
		optStore.value = SupID;
		document.getElementById("cboSuppliers").options.add(optStore);
	}
	document.getElementById("cboSuppliers").value=0;
}

//bookmark2

function formValidation(){
	if(document.getElementById("cboBatchNo").value==0)
	{
		alert("Please select a \"AccPac Batch No\".");
		document.getElementById("cboBatchNo").focus();
		
		return false;
	}
	
	var GLAmt = 0;
	var totGlAmt = 0;
	var tblGLAccs=document.getElementById('tblGLAccs');
	for(var loop=1;loop<tblGLAccs.rows.length;loop++)
	{
	 if(tblGLAccs.rows[loop].cells[0].lastChild.lastChild.checked == true){
	  GLAmt  = tblGLAccs.rows[loop].cells[3].lastChild.value;
	  totGlAmt += parseFloat(GLAmt);	 
	 }
	}
	 var txtGLTotal = document.getElementById('txtcommission').value;
     
	 if(txtGLTotal != totGlAmt){
	 alert("GL amount should  tally with the total amount")	 
	 return false;
	 }
	 
	 var tblPOList=document.getElementById('tblPOList');
	 var c=0;
	 for(var loop=1;loop<tblPOList.rows.length;loop++)
	 {
	  if(tblPOList.rows[loop].cells[0].lastChild.checked == true){
		c++;  
	  }
	 }
	 if(c == 0){
		alert("Please select PO's for the Payment");
		return false;
	 }
	 
	SaveAdvPayment();
	
}


function SaveAdvPayment()
{
	var type = document.getElementById('cboPaymentType').value.trim();
	strPaymentType=type;
	var url= 'advancepaymentDB.php?DBOprType=AdvPaymentNoTask&strPaymentType=' + type;
	htmlobj=$.ajax({url:url,async:false});
	var no	= htmlobj.responseText;
		savePayment(no);
}

//bookmark
function savePayment(intPaymentNo)
{	
	var type = document.getElementById('cboPaymentType').value.trim();
	strPaymentType=type;

//var paymentno=document.getElementById("txtPaymentNo").value;
//var datex=document.getElementById("txtDate").value

var supid=document.getElementById("cboSuppliers").value.trim();

var description=document.getElementById("txtDescription").value.trim();
var batchno=document.getElementById("cboBatchNo").value.trim();
var draft=0;
var discount=0;
var frightcharge=document.getElementById("txtFreightCharge").value.trim();
var couriercharge=document.getElementById("txtHandleCharge").value.trim();;	
var bankcharge=document.getElementById("txtBankCharge").value.trim();
var otherCharges=document.getElementById("txtOtherCharge").value.trim();
var poamount=document.getElementById("txtPOAmount").value.trim();
var totalamount=document.getElementById("txtPOTotalAmount").value.trim();
var currency=document.getElementById("cboCurrencyTo").value.trim();
var lineNo=0;

/*if(draft=="")
{	
	draft=0;	
}*/

	var taxamount=0;//document.getElementById("cboSuppliers").value	
	var taxTot=0;
	var tax="";
	var rate=0;
	var amount=0;

	
	var rows=document.getElementById('tblTax').getElementsByTagName("TR");
	for(var x=1;x<rows.length;x++)
	{
		var cells=rows[x].getElementsByTagName("TD");

		if(cells[0].firstChild.checked==true)
		{
			taxamount	=parseFloat(taxamount)+Number(cells[3].firstChild.nodeValue );
			tax=cells[1].firstChild.nodeValue ;
			rate=cells[2].firstChild.nodeValue ;
			amount=Number(cells[3].firstChild.value) ;
			
			var url='advancepaymentDB.php?DBOprType=SaveAdvTax&strPaymentType=' + strPaymentType+'&paymentno='+intPaymentNo +'&tax=' + tax +'&rate=' + rate +'&amount='+ amount;
			htmlobj=$.ajax({url:url,async:false});	
			var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//alert("New Tax Saved Successfully.");
			}
			else
			{
				alert("Save Process Failed.");
				return false;
			}
		}
	}
	
	var tblGLAccs=document.getElementById('tblGLAccs');

	for(var loop=1;loop<tblGLAccs.rows.length;loop++)
	{
	 if(tblGLAccs.rows[loop].cells[0].lastChild.lastChild.checked == true){
	 var GLAccNo = tblGLAccs.rows[loop].cells[1].id;
	 var GLAmt = tblGLAccs.rows[loop].cells[3].lastChild.value;
	var url='advancepaymentDB.php?DBOprType=SaveAdvGLs&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo + '&glaccno=' + GLAccNo + '&amount=' + GLAmt;
	htmlobj=$.ajax({url:url,async:false});
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");	 
	 }
	}
	
	var rows=document.getElementById('tblPOList').getElementsByTagName("TR");
	
	for(var loop=1;loop<rows.length;loop++)
	{
		var cells=rows[loop].getElementsByTagName("TD");
		
		if(cells[0].firstChild.checked == true)
		{	
			var pono=cells[1].childNodes[0].firstChild.nodeValue ;
		
				var poNo		= 	pono.split('/')[1];
				var poYear		= 	pono.split('/')[0];
			var paidamount=parseFloat(cells[6].firstChild.value) ;
			var url='advancepaymentDB.php?DBOprType=SaveAdvPOs&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo + '&poNo=' + poNo +'&poYear='+poYear+ '&paidamount=' + paidamount ;
			htmlobj=$.ajax({url:url,async:false});
			var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
		}
	}
	
    var url='advancepaymentDB.php?DBOprType=SaveAdvPayment&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo  + '&supid=' + supid + '&description=' + description + '&batchno=' + batchno + '&draft=' + draft + '&discount=' + discount + '&frightcharge=' + frightcharge + '&couriercharge=' + couriercharge + '&bankcharge=' + bankcharge + '&poamount=' + poamount + '&taxamount=' + document.getElementById('txtTaxAmount').value.trim() + '&totalamount=' + totalamount + '&currency=' + currency+'&exRate='+ document.getElementById('txtExRate').value.trim()+'&entryNo='+0+'&lineNo='+0+'&otherCharges='+otherCharges;
	htmlobj=$.ajax({url:url,async:false}); 
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//saveFreihtCharges(supid,intPaymentNo);
				//saveInsuranceCharges(supid,intPaymentNo);
				//saveOtherCharges(supid,intPaymentNo);
				alert("Advance payment saved successfully. No is \""+intPaymentNo+"\"");
				document.getElementById('imgSave').style.visible=false;
				//document.getElementById('txtPaymentNo').value=intPaymentNo;
				document.getElementById('imgSave').style.visibility="hidden";
				//clearAll()
				//getAdvPaymentNo(2)
				//document.frmAdvance.reset();
				//setPoBalance();
                clearPoGrid();
				clearGlGrid();
				document.frmAdvance.reset();
			}
			else
			{
				alert("Save Process Failed.");
			}
}

function clearGlGrid(){
	var tbl=document.getElementById('tblGLAccs');
	var binCount	=	tbl.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tbl.deleteRow(loop);
			binCount--;
			loop--;
	}
}

function clearPoGrid(){
	var tbl=document.getElementById('tblPOList');
	var binCount	=	tbl.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tbl.deleteRow(loop);
			binCount--;
			loop--;
	}
}

function setPoBalance(){
	var tbl=document.getElementById('tblPOList').tBodies[0];
	var rc=tbl.rows.length;
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			var paid=tbl.rows[i].cells[4].innerHTML;
			var balance=tbl.rows[i].cells[5].innerHTML;
			var val=tbl.rows[i].cells[6].childNodes[0].value;
			tbl.rows[i].cells[4].innerHTML=(Number(paid)+Number(val)).toFixed(4);
			tbl.rows[i].cells[5].innerHTML=(Number(balance)-Number(val)).toFixed(4);
			tbl.rows[i].cells[6].childNodes[0].value=0;
		}
	}
}
function validatePoValue(obj){
	var poVal=parseFloat(obj.parentNode.parentNode.cells[5].innerHTML);
	var val= parseFloat(obj.value.trim());
	if(poVal<val){
		alert("Pay amount should be less than or equal to PO balance.");
		obj.value=poVal;
		setPOValue();
		return false;
	}
}
function clearTax(){
	/*var rows=document.getElementById('tblTax').getElementsByTagName("TR");
	
	for(var x=1;x<rows.length;x++)
	{
		var cells=rows[x].getElementsByTagName("TD");
		cells[3].firstChild.nodeValue ="0.00"
		cells[0].firstChild.checked=false;
	}*/
	var tbl=document.getElementById('tblTax').tBodies[0];
	var rc=tbl.rows.length;
	for(var i=0;i<rc;i++){
		tbl.rows[i].cells[3].childNodes[0].value="";
		tbl.rows[i].cells[0].lastChild.checked=false;
	}
	
}
function clearAll()
{	
	var glaccTable=""
	document.getElementById("tblGLAccs").tBodies[0].innerHTML=glaccTable	
	  
	var poTable=""
	document.getElementById("tblPOList").tBodies[0].innerHTML=poTable;	
	document.getElementById("cboSuppliers").value=0;
	document.getElementById("txtDescription").value="";
	document.getElementById("cboBatchNo").value=0;
	//document.getElementById("txtlineno").value=0;
	clearChrsAndAmnt();
	document.getElementById("cboCurrencyTo").value=0;
	//document.getElementById("txtPaymentNo").value="";
	document.getElementById("txtExRate").value="";
	//document.getElementById("txtExRate2").value="";
	document.getElementById('imgSave').style.visibility="visible";
	
	//getAdvPaymentNo(1)
	clearTax();
	//clearCharges();
}
function clearCharges(){
	var tbls=['tblFreight','tblCourier','tblOther'];
	for(var i=0;i<tbls.length;i++){
		var tbl=document.getElementById(tbls[i]).tBodies[0];
		for(var loop=0;loop<tbl.rows.length;loop++){
			tbl.rows[loop].cells[0].childNodes[0].checked=false;
			tbl.rows[loop].cells[3].childNodes[0].value='0';
		}
	}
}
function clearChrsAndAmnt(){
	document.getElementById("txtDraftNo").value=0;
	//document.getElementById("txtDiscount").value="0.0000";
	document.getElementById("txtPOAmount").value="0.0000";
	document.getElementById("txtPOTotalAmount").value="0.0000";
	document.getElementById("txtTaxAmount").value="0.0000";
}

function clearSelectControl(cboid)
{
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var aa=0;
	   for (aa=select.options.length-1;aa>=0;aa--)
	   {
			select.remove(aa);
	   }
   }
}

/*function addNewGLRow(obj){
	var tbl=document.getElementById('tblGLAccs').tBodies[0];
	var rc=tbl.rows.length;
	var cls;
		((rc % 2)==0)?cls='grid_raw':cls='grid_raw2';
	var htm="<tr>"+
							"<td class=\""+cls+"\" style=\"text-align:center;\"><input type=\"checkbox\"  onclick=\"chkUnchk(this),setLineNumber()\"></td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+0+"\">" + 0+""+0 + "</td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\">" + 0 + "</td>"+
							"<td class=\""+cls+"\"><input name=\"txtamount\" type=\"text\"style=\"width: 100px; text-align: right;\" class=\"txtbox\" id=\"txtamount\" size=\"20\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onchange=\"clckGLBox(this)\" onblur=\"addNewGLRow(this)\"/></td>"+
							"</tr>";
			
	//$('#tblGLAccs > tbody:last').after(htm);
}*/

function highlight(o)
{
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

function ReportPrint()
{
	strPaymentType=document.getElementById("cboPaymentType").value.trim();
	var selectedAdvPaymentNo=document.getElementById("txtPaymentNo").value.trim();
	if(selectedAdvPaymentNo!=""){
		window.open('advancePayment/rptAdvancePaymentReport.php?PayNo=' + selectedAdvPaymentNo + '&strPaymentType=' + strPaymentType,"rptAdvancePayment");
	}
	else{
		alert("No specified advance payment to display.");
	}
}

function AdvancePaymentReport()
{
	location = "advancePaymentFinder.php";
	return;
	try
	{
		document.getElementById('popupGLAccounts').style.visibility = 'hidden';
		document.getElementById('popupAdvancePayment').style.visibility = 'hidden';

	}
	catch(err)
	{        
	}
	


	var advReport="<table width=\"800\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	"<tr>"+
	"<td><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">"+
	"<tr>"+
	"<td width=\"20%\"><img src=\"../images/eplan_logo.png\" alt=\"\" width=\"191\" height=\"47\" class=\"normalfnt\" /></td>"+
	"<td width=\"6%\" class=\"normalfnt\">&nbsp;</td>"+
	"<td width=\"74%\" class=\"tophead\"><p class=\"topheadBLACK\">Jinadasa Brothers Ltd</p>"+
	"<p class=\"normalfnt\">Colombo, Sri Lanka. Tel: (+94) 112 345678 Fax: (+94) 112 345678 </p>"+
	"<p class=\"normalfnt\">E-Mail: info@jinadasa.com Web: www.jinadasa.com</p></td>"+
	"</tr>"+
	"</table></td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divCaption\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblCaption\">"+
	"<tr>"+
	"<td height=\"36\" colspan=\"5\" class=\"head2\">ADVANCE PAYMENT</td>"+
	"</tr>"+
	"<tr>"+
	"<td width=\"8%\" class=\"normalfnth2B\">PAYEE</td>"+
	"<td width=\"40%\" class=\"normalfnt\"></td>"+
	"<td width=\"6%\" class=\"normalfnt\">&nbsp;</td>"+
	"<td width=\"19%\" class=\"normalfnth2B\">PAYMENT NO</td>"+
	"<td width=\"27%\" class=\"normalfnt\">&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td height=\"13\" class=\"normalfnth2B\">&nbsp;</td>"+
	"<td class=\"normalfnt\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td class=\"normalfnth2B\">DATE</td>"+
	"<td class=\"normalfnt\">&nbsp;</td>"+
	"</tr>"+
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnth2B\">Style Ratio</td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divItems\"> <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"tablez\"  id=\"tblItems\">"+
	"<tr>"+
	"<td width=\"36%\" height=\"25\" class=\"normalfntBtab\">DISCRIPTION</td>"+
	"<td width=\"14%\" class=\"normalfntBtab\">AMOUNT</td>"+
	"<td width=\"10%\" class=\"normalfntBtab\">VAT</td>"+
	"<td width=\"13%\" class=\"normalfntBtab\">CHARGERS</td>"+
	"<td width=\"11%\" class=\"normalfntBtab\">DISCOUNT</td>"+
	"<td width=\"16%\" class=\"normalfntBtab\">TOTAL AMOUNT</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntMidTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"</tr>"+
	/*"<tr>"+
	"<td class=\"normalfntTAB\"> Cotton 98% Cotton 2% Elastane</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntMidTAB\">0.00%</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"</tr>"+*/
	"<tr>"+
	"<td class=\"normalfnth2Bm\">Grand Total</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"nfhighlite1\"></td>"+
	"</tr>"+
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divGLAccs\"> <table width=\"100%\" height=\"60\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblGLAccs\">"+
	"<tr>"+
	"<td width=\"27%\" height=\"25\" class=\"normalfntBtab\">ACCOUNT</td>"+
	"<td width=\"26%\" class=\"normalfntBtab\">A/C CODE</td>"+
	"<td width=\"13%\" class=\"normalfntBtab\">AMOUNT</td>"+
	"<td width=\"34%\" class=\"normalfntBtab\">ADDRESS</td>"+
	"</tr>"+
	"<tr>"+
	"<td height=\"18\" class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"</tr>"+
	/*"<tr>"+
	"<td height=\"17\" class=\"normalfntTAB\">97C AQUA</td>"+
	"<td class=\"normalfntTAB\">452</td>"+
	"<td class=\"normalfntTAB\">247</td>"+
	"<td class=\"normalfntTAB\">456</td>"+
	"</tr>"+*/
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td><table width=\"100%\" border=\"0\">"+
	"<tr>"+
	"<td width=\"20%\" class=\"normalfnt\">PREPARED BY</td>"+
	"<td width=\"25%\" class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td width=\"13%\">&nbsp;</td>"+
	"<td width=\"15%\">&nbsp;</td>"+
	"<td width=\"27%\">&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">CHECKED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">AUTHORIZED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">APPROVED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td class=\"normalfnt\">RECIVED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"</tr>"+
	"</table></td>"+
	"</tr>"+
	"</table>"
	
	var popupbox3 = document.createElement("div");
	popupbox3.id = "popupAdvancePaymentReport";
	popupbox3.style.position = 'absolute';
	popupbox3.style.zIndex = 1;
	popupbox3.style.left = 100 + 'px';
	popupbox3.style.top = 20 + 'px';  
	popupbox3.innerHTML = advReport//testA;//aa;//strAdvRepot;        
	document.body.style.background="#FFFFFF"
	document.body.appendChild(popupbox3);
	
	var PaymentNo=document.getElementById("txtPaymentNo").value
	PaymentNo=PaymentNo-1
	//getAdvacePaymentsList(supid);
	//getAdvPayData(PaymentNo)
}

function getAdvacePaymentsList(supid)
{
	strPaymentType=document.getElementById("cboPymentType").value
	var url='advancepaymentDB.php?DBOprType=getAdvacePaymentsList&strPaymentType=' + strPaymentType + '&supid=' + supid
	htmlobj=$.ajax({url:url,async:false});
	var XMLAdvPayNo = htmlobj.responseXML.getElementsByTagName("AdvPayNo");

			var strAdvPayList="";
			for(var loop=0;loop<XMLAdvPayNo.length;loop++)
			{
				var AdvPayNo=XMLAdvPayNo[loop].childNodes[0].nodeValue;
				
				strAdvPayList+="<tr>"+
							   "<td  class=\"normalfnt\" height=\"5\">" + AdvPayNo  + "</td>"+
							   "<td class=\"normalfnt\" height=\"5\"><img src=\"../images/manage.png\" onclick=\"getAdvPayData(this)\" alt=\"AdvPayReport\" width=\"16\" /></td>"+
						       "</tr>"
			
			}
			document.getElementById("divAdvReportPONOList").innerHTML=strAdvPayList;
}

function fillAvailableAdvData()
{	
	strPaymentType=document.getElementById("cboPaymentType").value.trim();

	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	var po=document.getElementById('txtPoNo').value.trim();
	var poNo=po.split('/')[1];
	var poYear=po.split('/')[0];
	var url='advancepaymentDB.php?DBOprType=findAdvData&strPaymentType=' + strPaymentType + '&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo+'&poNo='+poNo+'&poYear='+poYear;
	htmlobj=$.ajax({url:url,async:false});
	var XMLPaymentNo = htmlobj.responseXML.getElementsByTagName("PaymentNo");
			var XMLDate = htmlobj.responseXML.getElementsByTagName("paydate");
			var XMLAmount = htmlobj.responseXML.getElementsByTagName("poamount");
			var XMLTaxAmount = htmlobj.responseXML.getElementsByTagName("taxamount");
			var XMLTotalAmount = htmlobj.responseXML.getElementsByTagName("totalamount");
			var XMLPOno = htmlobj.responseXML.getElementsByTagName("POno");
			var XMLPOYear = htmlobj.responseXML.getElementsByTagName("POYear");

			
			var strData=""
				
			for ( var loop = 0; loop < XMLPaymentNo.length; loop ++)
			 {
				var advNo 	= XMLPaymentNo[loop].childNodes[0].nodeValue;
				var datex 	= XMLDate[loop].childNodes[0].nodeValue;
				var amt 	= XMLAmount[loop].childNodes[0].nodeValue;
				var taxAmt 	= XMLTaxAmount[loop].childNodes[0].nodeValue;
				var totAmt	= XMLTotalAmount[loop].childNodes[0].nodeValue;
				var POno	= XMLPOno[loop].childNodes[0].nodeValue;
				var POYear	= XMLPOYear[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strData+="<tr>"+
				"<td class=\""+cls+"\" style=\"text-align:left\">&nbsp;"+POYear+"/"+POno+"</td>"+
				"<td class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + advNo + "</td>"+
				"<td class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + datex + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + amt + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + taxAmt + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + totAmt + "</td>"+
				"<td class=\""+cls+"\"><div align=\"center\" onmouseover=\"highlight(this.parentNode)\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"previewReport(this)\"/></div></td>"+
				"</tr>"	
			 }
			 strData+="</table>"
	document.getElementById("tblAdvData").tBodies[0].innerHTML=strData;
}
function edDate(obj){
	if(obj.checked==true){
		document.getElementById('txtDateFrom').disabled=false;
		document.getElementById('txtDateTo').disabled=false;
		}
	else{
		document.getElementById('txtDateFrom').disabled=true;
		document.getElementById('txtDateTo').disabled=true;
		document.getElementById('txtDateFrom').value="";
		document.getElementById('txtDateTo').value="";
		
	}
}

function clearAdPay(){
	//document.getElementById('form1').reset();
	document.getElementById('chk').checked=false;
	document.getElementById('txtDateFrom').disabled=true;
	document.getElementById('txtDateTo').disabled=true;
	document.getElementById('txtDateFrom').value="";
	document.getElementById('txtDateTo').value="";
	document.getElementById('cboSuppliers').value="";
	document.getElementById('txtPoNo').value="";
}
function previewReport(obj)
{
	document.getElementById("cboPaymentType").value.trim();	
	var row=obj.parentNode.parentNode.parentNode
	var selectedAdvPaymentNo =  row.cells[1].innerHTML;
	window.open('rptAdvancePaymentReport.php?PayNo=' + selectedAdvPaymentNo + '&strPaymentType=' + strPaymentType,"AdvancePaymentRpt")
}

function setDefaultDate()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=( year + "/" + month + "/" + day);
	document.getElementById("txtDate").value=ddate
	//getAdvPaymentNo(1)
}

function setDefaultDateofFinder()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "/" + month + "/" + day);
	//document.getElementById("txtDateFrom").value=ddate
	//document.getElementById("txtDateTo").value=ddate	
}

 //==================

function toWords(s)
{s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != String(parseFloat(s))) return 'not a number'; 
var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'hundred ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');
}

//===================================================
var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  // this call must be the last as it might use data initialized above; if
  // we specify a parent, as opposite to the "showCalendar" function above,
  // then we create a flat calendar -- not popup.  Hidden, though, but...
  cal.create(parent);

  // ... we can show it here.
  cal.show();
}

function pageRefresh()
{
	document.getElementById("frmAdvance").submit();
}
function pageRefreshListing()
{
	document.getElementById("form1").submit();
}
//===========lasantha -- currency change
function loadExchangeRate(obj){
	var url='advancepaymentDB.php?DBOprType=getExchangeRate&batchId='+obj.value.trim();
	htmlobj=$.ajax({url:url,async:false});
	var XMLCurrency = htmlobj.responseXML.getElementsByTagName("Currency");
	var XMLCurrencyId = htmlobj.responseXML.getElementsByTagName("CurrencyId");
	var XMLRate = htmlobj.responseXML.getElementsByTagName("Rate");
	var XMLEntryNo = htmlobj.responseXML.getElementsByTagName("EntryNo");
	
	if(XMLCurrencyId.length>0){
		var Rate=XMLRate[0].childNodes[0].nodeValue;
		document.getElementById('txtExRate').value=Rate;
		document.getElementById('cboCurrencyTo').value=XMLCurrencyId[0].childNodes[0].nodeValue;
		//document.getElementById('txtExRate2').value=XMLEntryNo[0].childNodes[0].nodeValue; 
	}
	else {
		document.getElementById('txtExRate').value="";
		document.getElementById('cboCurrencyTo').value="";
		//document.getElementById('txtExRate2').value="";
		return false;
	}
}

function getEntryNo(){}
///////=================================================================================///////////////////////////
function changeRates(obj){
	/*var baseCurrency="";
	var exRate=document.getElementById('txtExRate').value.trim();
	var TotPoAmt=document.getElementById('txtPOAmount').value.trim();
	var nwTot=0;
	var nwTot2=0;
	var bCrr=document.getElementById('cboCurrencyTo').value.trim();
	if(obj.checked==true){
		baseCurrency=obj.parentNode.parentNode.childNodes[2].id;
		if(baseCurrency!=bCrr){
			nwTot=TotPoAmt-obj.parentNode.parentNode.childNodes[6].childNodes[0].value;
			//document.getElementById('txtPOAmount').value=nwTot;
			alert(nwTot);
			nwTot2=obj.parentNode.parentNode.childNodes[6].childNodes[0].value*exRate;
			document.getElementById('txtPOAmount').value=parseFloat(nwTot)+parseFloat(nwTot2);
			}
	}*/
	
}
//======================================
//==============================================


/*//Calander Functions
function toggleCalendar()
{	
	var txtObj=document.getElementById("txtDate")
	cObj = txtObj.myCalendar;

	if (!cObj) {
		cObj = new CalendarDisplay(txtObj);
		document.body.appendChild(cObj.cDiv);
		txtObj.myCalendar = cObj;
	}
	
	cObj.toggle();
}

CalendarDisplay = function(txtObj)
{
	this.txtObj = txtObj;
	this.tBox = this.txtObj;
	this.cDiv = document.createElement('div');
	this.cDiv.style.position = 'absolute';
	this.cDiv.style.display = 'none';
}

CalendarDisplay.prototype.MONTHS_CALENDAR = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
CalendarDisplay.prototype.DAYS_1_CALENDAR = new Array("S", "M", "T", "W", "T", "F", "S");
CalendarDisplay.prototype.DAYS_2_CALENDAR = new Array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa");

CalendarDisplay.prototype.toggle = function() {
	if (this.cDiv.style.display == 'none') {
		this.adjustPosition();
		this.fillCalendar(this.grabDate());
		this.cDiv.style.display = 'block';
	} else {
		this.cDiv.style.display = 'none';
	}
}

CalendarDisplay.prototype.grabDate = function() {
	var tempDate = new Date(this.tBox.value);
	if (!tempDate.getYear()) {
		tempDate = new Date();
	}
	return tempDate;
}

CalendarDisplay.prototype.fillCalendar = function(theDate) {
	if (this.cDiv.firstChild) {
		this.cDiv.removeChild(this.cDiv.firstChild);
	}
	this.adjustPosition();
	this.cDiv.appendChild(this.getCalendar(theDate));
}

CalendarDisplay.prototype.adjustPosition = function() {
	this.cDiv.style.top = this.tBox.offsetHeight + this.findPosY(this.tBox) + 'px';

	this.cDiv.style.left = this.findPosX(this.tBox) + 'px';
}

CalendarDisplay.prototype.getCalendar = function(theDate) {
	var theYear = theDate.getFullYear();
	var theMonth = theDate.getMonth();
	var theDay = theDate.getDate();

	var theTable = document.createElement('table');
	theTable.id = 'calendartable';
	var theTHead = theTable.createTHead();
	var theTBody = document.createElement('tbody');
	theTable.appendChild(theTBody);
	
	var monthRow = theTHead.insertRow(0);
	var navLeftCell = monthRow.insertCell(0);
	var monthCell = monthRow.insertCell(1);
	var navRightCell = monthRow.insertCell(2);
	monthCell.colSpan = 5;
	monthCell.appendChild(document.createTextNode(this.MONTHS_CALENDAR[theMonth] + ', ' + theYear));
	var leftLink = document.createElement('a');
	leftLink.href = '#';
	this.setCalendarPrevious(leftLink, this.txtObj, theYear, theMonth, theDay);
	leftLink.appendChild(document.createTextNode('-'));
	navLeftCell.appendChild(leftLink);
	var rightLink = document.createElement('a');
	rightLink.href = '#';
	this.setCalendarNext(rightLink, this.txtObj, theYear, theMonth, theDay);
	rightLink.appendChild(document.createTextNode('+'));
	navRightCell.appendChild(rightLink);
	
	var weeksRow = theTHead.insertRow(1);
	for (var i=0; i<7; i++) {
		var tempWeeksCell = weeksRow.insertCell(i);
		tempWeeksCell.appendChild(document.createTextNode(this.DAYS_2_CALENDAR[i]));
	}
	
	var temporaryDate1 = new Date(theYear, theMonth, 1);
	var startDayOfWeek = temporaryDate1.getDay();
	var temporaryDate2 = new Date(theYear, theMonth + 1, 0);
	var lastDateOfMonth = temporaryDate2.getDate();
	var dayCount = 1;
		
	for (var r=0; r<6; r++) {
		var tempDaysRow = theTable.tBodies[0].insertRow(r);
		tempDaysRow.className = 'dayrow';
		for (var c=0; c<7; c++) {
			var tempDaysCell = tempDaysRow.insertCell(c);
			var mysteryNode;
			if ((r > 0 || c >= startDayOfWeek) && dayCount <= lastDateOfMonth) {
				tempDaysCell.className = 'yestext';
				var mysteryNode = document.createElement('a');
				mysteryNode.href = '#';
				this.setCalendarClick(mysteryNode, this.txtObj, theYear, theMonth, dayCount);
				mysteryNode.appendChild(document.createTextNode(dayCount));
				dayCount++;
			} else {
				tempDaysCell.className = 'notext';
				mysteryNode = document.createTextNode('');
			}
			tempDaysCell.appendChild(mysteryNode);
		}
	}
	
	return theTable;
}
CalendarDisplay.prototype.setCalendarClick = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {fillInFields(theObj, theYear, (theMonth + 1), theDay); return false;}
}
CalendarDisplay.prototype.setCalendarPrevious = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showPrevious(theObj, theYear, theMonth, theDay); return false;}
}
CalendarDisplay.prototype.setCalendarNext = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showNext(theObj, theYear, theMonth, theDay); return false;}
}
	


CalendarDisplay.prototype.findPosX = function(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) {
		curleft += obj.x;
	}
	return curleft;
}


CalendarDisplay.prototype.findPosY = function(obj) {
	var curtop = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent) {
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.y) {
		curtop += obj.y;
	}
	return curtop;
}

function fillInFields(obj, year, month, day)
{
	obj.value = (month < 10 ? '0'+month : month) + '/' + (day < 10 ? '0'+day : day) + '/' + year;
	cObj = obj.myCalendar;
	cObj.toggle();
}

function showPrevious(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var lastMonth = new Date(year, month - 1, day)
	cObj.fillCalendar(lastMonth);
}
function showNext(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var nextMonth = new Date(year, month + 1, day)
	cObj.fillCalendar(nextMonth);
}*/

function loadBatchesAccordingToSupCurrency(){
	var cboSuppliers = document.getElementById("cboSuppliers").value;
	var url='advancepaymentDB.php?DBOprType=loadBatchesAccordingToSupCurrency&cboSuppliers='+cboSuppliers;
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById("cboBatchNo").innerHTML = htmlobj.responseText;
}

//------------------------------------------------------------------------------------------------------------

function delect_table_content(obj)
{
	$('#'+ obj+' tbody' ).html("")
}

function grid_fix_header_poList()
{
	$("#tblPOList").fixedHeader({
	width: 955,height: 200
	});	
}

function grid_fix_header_tax()
{
	$("#tblTax").fixedHeader({
	width: 480,height: 120
	});	
}

//-----------------------------------------------------------------------------------------------------------

function changePOamt(val){

 var txtPOAmountTitle=document.getElementById('txtPOAmount').title;
     txtPOAmountTitle= parseFloat(txtPOAmountTitle) + 5;
	 
 if(val > txtPOAmountTitle){
	alert("You are permited to increase the PO amount only by 5 "); 
	document.getElementById('txtPOAmount').value = document.getElementById('txtPOAmount').title;
	document.getElementById('txtPOAmount').focus();	
 }
 
 	var glTbl	= document.getElementById('tblGLAccs');
	var taxTbl 	= document.getElementById('tblTax');
	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txtPOAmount').value)==""?0:(document.getElementById('txtPOAmount').value));
	
    for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id=='0' )
		{
			var NBTrate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((glTotValue*NBTrate)/100,4);
			taxTotAmount += parseFloat((taxTbl.rows[i].cells[3].childNodes[0].value == ""?0:taxTbl.rows[i].cells[3].childNodes[0].value));	
			
		}
		else if (taxTbl.rows[i].cells[0].childNodes[0].checked == false)
			taxTbl.rows[i].cells[3].childNodes[0].value = 0.0000;
	}
	
	var totalOtherAmount = parseFloat(RoundNumbers(glTotValue+taxTotAmount,4));
	document.getElementById('txtcommission').value = RoundNumbers(totalOtherAmount,4);
	
	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id!='0' )
		{ 
			var rate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((totalOtherAmount*rate)/100,4);
			taxAmount	+= parseFloat(RoundNumbers((totalOtherAmount*rate)/100,4));
		}
	}
	
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{
		if(glTbl.rows[loop].cells[0].childNodes[0].checked)
		{
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}
	
	document.getElementById('txtTaxAmount').value = RoundNumbers(taxAmount,4);
	document.getElementById('txtPOTotalAmount').value = RoundNumbers(totalOtherAmount+taxAmount,4);
	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue+taxTotAmount)-glTotAmount,4);
}

