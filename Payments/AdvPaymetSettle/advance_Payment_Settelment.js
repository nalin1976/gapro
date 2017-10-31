var xmlHttp;

var accNo=""
var accName=""
var accType=""
var accFactory=""



	var url					='advancePaymenSettelmenttDB.php?DBOprType=load_GLID';
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


function XMLHttpForStylePO(index) 
{
	if (window.ActiveXObject) 
    {
       StylePOXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        StylePOXmlHttp = new XMLHttpRequest();
    }
}



function getStylePO()
{

	if(document.getElementById('cboSuppliers').value.trim()==""){
		document.getElementById("table_grid_style_body").innerHTML="";
		return false;
	}
		
	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
		
	var strSupID=document.getElementById("cboSuppliers").value;
	XMLHttpForStylePO();
	
	StylePOXmlHttp.onreadystatechange = HandleStylePOList;

    StylePOXmlHttp.open("GET", 'advancePaymenSettelmenttDB.php?DBOprType=getStyle&SupID=' + strSupID+"&type="+type, true);
	StylePOXmlHttp.send(null); 

}

function HandleStylePOList()
{	
	if(StylePOXmlHttp.readyState == 4) 
    {
	   if(StylePOXmlHttp.status == 200) 
        {  
		    var XMLPaymentNo = StylePOXmlHttp.responseXML.getElementsByTagName("PaymentNo");
			var XMLYear = StylePOXmlHttp.responseXML.getElementsByTagName("intYear");
			var XMLPONo = StylePOXmlHttp.responseXML.getElementsByTagName("poNo");
			var XMLPOValue = StylePOXmlHttp.responseXML.getElementsByTagName("poValue");
			var XMLPOBalance = StylePOXmlHttp.responseXML.getElementsByTagName("poBalance");
			var XMLpoPaidAmt = StylePOXmlHttp.responseXML.getElementsByTagName("poPaidAmt");
			var XMLStyle = StylePOXmlHttp.responseXML.getElementsByTagName("poStyle");
			var XMLsettledAmt = StylePOXmlHttp.responseXML.getElementsByTagName("settledAmt");
			
			
			strTable=""/*<table width=\"582\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblPOList\" class=\"normalfnt\">"+
					"<tr>"+*/
					/*"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Set Off</td>"+
					"<td width=\"17%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style</td>"+*/
					/*"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"grid_header\">PO No</td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"grid_header\"><div align=\"right\">PO Amount</div></td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"grid_header\"><div align=\"right\">Paid Amount</div></td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"grid_header\"><div align=\"right\">Balance</div></td>"+
					"<td width=\"10%\" bgcolor=\"#498CC2\" class=\"grid_header\">GRN</td>"+
					"<td class=\"grid_header\">Surrended</td>"+
					"</tr>"*/
					
			if(XMLYear.length==0)
			{
				var supname=document.getElementById("cboSuppliers");
				var sss=supname.options[document.getElementById("cboSuppliers").selectedIndex].text;
				alert("There are no PO's for " + sss);	
				 document.getElementById("table_grid_style_body").innerHTML="";
				return;
			}
			
			for ( var loop = 0; loop < XMLYear.length; loop ++)
			 {
			    var PaymentNo = XMLPaymentNo[loop].childNodes[0].nodeValue;
				var poYear = XMLYear[loop].childNodes[0].nodeValue;
				var poNo = XMLPONo[loop].childNodes[0].nodeValue;
				var poValue = XMLPOValue[loop].childNodes[0].nodeValue;
				var poBalance = XMLPOBalance[loop].childNodes[0].nodeValue;
				var poStyle = XMLStyle[loop].childNodes[0].nodeValue;
				var poPaidAmt = XMLpoPaidAmt[loop].childNodes[0].nodeValue;
				var settledAmt = XMLsettledAmt[loop].childNodes[0].nodeValue;

				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strTable+="<tr>"+
				/*"<td onmouseover=\"highlight(this.parentNode)\" height=\"20\" class=\"normalfntMid\"><input type=\"checkbox\" name=\"chkSurd\" id=\"chkSurd\" /></td>"+*/
				"<td  class=\""+cls+"\" >"+ PaymentNo +"</td>"+	
				"<td  class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poPaidAmt).toFixed(2) +"</td>"+
				"<td  class=\""+cls+"\" name=\""+poYear+"\" id=\""+poNo+"\" >"+ poYear+"/"+poNo +"</td>"+
				"<td  class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poValue).toFixed(2) +"</td>"+				
				"<td  class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(settledAmt).toFixed(2) +"</td>"+
				"<td  class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poBalance).toFixed(2) +"</td>"+
				"<td  class=\""+cls+"\"><div align=\"center\"><img src=\"../../images/accept.png\" onClick=\"getGRNList(this);\"  alt=\"GRN\"  class=\"mouseover\" /></div></td><td class=\""+cls+"\" style=\"text-align:center;\"><input type=\"checkbox\" class=\"txtbox\"></td>"+
				
				/*"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfntMid\"><label>"+
				"<input name=\"cmbGRN\" type=\"submit\" id=\"cmbGRN\" style=\"height:20px\" value=\"...\" />"+
				"</label></td>"+
				"<td class=\"normalfntMid\">&nbsp;</td>"+
*/				"</tr>"
									
			 }
			 
			 
			 strTable+="</table>"
			 
			 document.getElementById("table_grid_style_body").innerHTML=strTable;
			 
		}
	}
}

function getGRNList(obj)
{
	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
		
	var fullPo=obj.parentNode.parentNode.parentNode.cells[2].lastChild.nodeValue;
	 var SPfullPO = fullPo.split("/");
	 var poYear = SPfullPO[0];
	 var poNo = SPfullPO[1];
	var advance=obj.parentNode.parentNode.parentNode.cells[1].innerHTML;
	var balance=obj.parentNode.parentNode.parentNode.cells[5].innerHTML;
	var paymentNo = obj.parentNode.parentNode.parentNode.cells[0].innerHTML;

/*	var url  = "GrnDetails2.php?po="+po+"&type="+type+"&poAmount="+poAmount;
	inc('advance_Payment_Settelment.js');
	var W	= 1;
	var H	= 1;
	var closePopUp = "closeGrnPopUp";
	var tdHeader = "td_GrnHeader";
	var tdDelete = "td_GrnDelete";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,"grnDet_popup_close_button");	*/
	
	//delect_table_content("tblGrnMain");
	var url  = "GrnDetails2.php?poYear="+poYear+"&&advance="+advance+"&&type="+type+"&&balance="+balance+"&&poNo="+poNo+"&&paymentNo="+paymentNo;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,30,'fmGrnDetails',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('fmGrnDetails').innerHTML=HTMLText;	
	//grid_fix_header_Grn_List();
	LoadSupplierGL();
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
			var tableText = "<table width=\"630\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblglaccounts\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"20\" height=\"20\" >*</td>" +
							 "<td width=\"82\" >GL Acc Id</td>" +
              				 "<td width=\"280\" >Description</td>" +
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
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\"  />";
			
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
					
					var tbl = document.getElementById('tblglaccounts');
					
					var lastRow = document.getElementById('tblglaccounts').rows.length;	
					var row = tbl.insertRow(lastRow);
					row.className="bcgcolor-tblrowWhite";
						
					var cellCheck = row.insertCell(0);   
					cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" /></div>";
					
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
				var tbl = document.getElementById('tblglaccounts');
				var conpc = tbl.rows[currentModifyRowIndex].cells[1].lastChild.nodeValue;
				obj.parentNode.innerHTML = obj.value;
				return;
			}
		
		var tbl = document.getElementById('tblglaccounts');
		var tbl_row_source = $('#tblglaccounts tr')
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
		cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" /></div>";
		
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
  
function clckGLBox2(value,row)
{
	var tbl = document.getElementById('tblglaccounts');
	if(value == 0 || value == "")
	{
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = false;
	}
	else
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
}
//===============================================================================================================

 function setFixedValue(value,row)
{
	if(value=="")
	value = 0;
	var tbl = document.getElementById('tblglaccounts');
	tbl.rows[row].cells[3].childNodes[0].value=RoundNumbers(value,2);
}


//----------------------------------------------------------------------------------

function setTotGlVale()
{   
	var glTbl	= document.getElementById('tblglaccounts');

	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txtTotGrn').value)==""?0:(document.getElementById('txtTotGrn').value));
		
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{ 
		if(glTbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{ 
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}

	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue)-glTotAmount,2);
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

//------------------------------------------------------------------------------------------------------------------------------

 function setAmountToGlAcc(evt,obj)
{
	var tbl = document.getElementById("tblglaccounts");
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

//------------------------------------------------------------------------------------------------------------------------------------------------

function addNewGLRow(rowIndex)
{	
	var tbl=document.getElementById('tblglaccounts');
	var rc=tbl.rows.length;
	
		if(rc==rowIndex+1)
		{
		
			var row = tbl.insertRow(rc);
			row.className="bcgcolor-tblrowWhite";
			
				
			var cellCheck = row.insertCell(0);   
			cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\"  onclick=\"checkUncheckTextBox(this);\" /></div>";
			
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

function closeGrnPopUp(id)
{
	closePopUpArea(id)
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
//===========================================================================================
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

function NewGLAccSave(accNo,accName,accType,accFactory)
{
	NewXMLHttpGLAcc();
    GLAccXmlHttp.onreadystatechange = HandleSaveGLAcc;
	GLAccXmlHttp.open("GET", 'advancePaymenSettelmenttDB.php?DBOprType=SaveNewGLAcc&AccNo=' + accNo + '&AccName='+ accName +'&AccType='+ accType +'&FactoryCode='+ accFactory , true);
    
	GLAccXmlHttp.send(null);  
	
}

function HandleSaveGLAcc()
{
    if(GLAccXmlHttp.readyState == 4) 
    {
        if(GLAccXmlHttp.status == 200) 
        {  
			var XMLResult = GLAccXmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//document.getElementById("txtname").value = "";
				//document.getElementById("txtremarks").value = "";
				//clearSelectControl("cboMainStores");
				LoadGLAccs();
				alert("New GL Account Saved Successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}
function setBalance(obj)
{
	var tblMain=document.getElementById('tblGrnMain').tBodies[0];
	var rC=tblMain.rows.length;
	var td=obj.parentNode;
	var balQty = td.parentNode.cells[7].innerHTML;

	var cell3=td.parentNode.cells[7].id;	

	var cell4=td.parentNode.cells[6].childNodes[0].value;
	if(td.parentNode.cells[6].childNodes[0].value=="")
	{
		td.parentNode.cells[7].innerHTML=0;
	}
	if(parseInt(cell3)+1 > parseInt(cell4))
	{
		td.parentNode.cells[7].innerHTML=0.00;
		td.parentNode.cells[7].innerHTML=(cell3-cell4).toFixed(2);
	}
	else
	{
		var myStr = cell4;
		var strLen = myStr.length;
		td.parentNode.cells[6].childNodes[0].value=myStr = myStr.slice(0,strLen-1);
		//alert("Issued qty not exceed to Recieve qty.");
	}
}

function setGrnValue(){
		var grnVal=0.00;
		var grnVal2=0.00;
		var payVal = 0;
		document.getElementById('txtTotGrn').value=0.00;
		var tblMain=document.getElementById('tblGrnMain').tBodies[0];
		var rC=tblMain.rows.length;
		for(var i=0;i<rC;i++){
			//alert(rC);
			if(tblMain.rows[i].cells[0].childNodes[0].checked==true){
				if(tblMain.rows[i].cells[6].childNodes[0].value.trim()=="")
				{
					tblMain.rows[i].cells[6].childNodes[0].value="";
				}
				payVal = tblMain.rows[i].cells[6].childNodes[0].value;
				if(payVal == ""){
				 payVal = 0;	
				}
				grnVal+=parseFloat(payVal);
				document.getElementById('txtTotGrn').value = grnVal.toFixed(2);
			}

/*		 if(parseFloat(document.getElementById('txtTotGrn').value.trim()) > parseFloat(document.getElementById('grnPoAmount').value.trim())){
			tblMain.rows[i].cells[6].childNodes[0].value=tblMain.rows[i].cells[5].innerHTML;
			document.getElementById('txtTotGrn').value=grnVal2;
			   for(var i=0;i<rC;i++){
				if(tblMain.rows[i].cells[0].childNodes[0].checked==true){
					if(tblMain.rows[i].cells[6].childNodes[0].value.trim()=="")
					{
						tblMain.rows[i].cells[6].childNodes[0].value=0.00;
					}
					grnVal2+=parseFloat(tblMain.rows[i].cells[6].childNodes[0].value);
					document.getElementById('txtTotGrn').value=grnVal2;
				}
			   }
		   }*/

		   
		   		if(parseFloat(document.getElementById('txtTotGrn').value.trim()) > parseFloat(document.getElementById('txtBalance').value.trim())){
				//alert("Balance of advance is "+parseFloat(document.getElementById('txtBalance').value.trim())+ " Pls reduce the payment");
				
				tblMain.rows[i].cells[6].lastChild.value="";
				setGrnValue();
				var bal= parseFloat(document.getElementById('txtBalance').value.trim())-parseFloat(document.getElementById('txtTotGrn').value.trim());
				tblMain.rows[i].cells[6].childNodes[0].value = bal.toFixed(2);
				setGrnValue();
				return false;
			}
		}
			if(parseFloat(document.getElementById('txtTotGrn').value.trim()) > 0){
		    if(parseFloat(document.getElementById('txtTotGrn').value.trim()) == parseFloat(document.getElementById('txtBalance').value.trim())){
			  //alert("Advance payment settled"); 
		    }
		   }
 setTotGlVale();
}

function selectAllChk(obj){
	var tblMain=document.getElementById('tblGrnMain').tBodies[0];
	var rC=tblMain.rows.length;
	if(obj.checked==true){
		for(var i=0;i<rC;i++){
			tblMain.rows[i].cells[0].childNodes[0].checked=true;
			tblMain.rows[i].cells[6].childNodes[0].value = tblMain.rows[i].cells[7].id;
            tblMain.rows[i].cells[7].innerHTML = 0;
		}
	}
	else{
		for(var i=0;i<rC;i++){
			tblMain.rows[i].cells[0].childNodes[0].checked=false;
    		tblMain.rows[i].cells[6].childNodes[0].value = 	""; 
            tblMain.rows[i].cells[7].childNodes[0].nodeValue = tblMain.rows[i].cells[7].id;
		}
	}
	setGrnValue();
}

function CloseWindow(){
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}	
}
//-------------------------------------------------------------------------------------
function setPayAmt(row){
var tblMain=document.getElementById('tblGrnMain');
 if(tblMain.rows[row].cells[0].childNodes[0].checked==true){
  tblMain.rows[row].cells[6].childNodes[0].value = tblMain.rows[row].cells[7].id;
   tblMain.rows[row].cells[7].innerHTML = 0;
  tblMain.rows[row].cells[6].childNodes[0].focus();
 }else{
  tblMain.rows[row].cells[6].childNodes[0].value = 	""; 
  tblMain.rows[row].cells[7].childNodes[0].nodeValue = tblMain.rows[row].cells[7].id;
 }

}
//-------------------------------------------------------------------------------------

function updateGrnDetails(){
	var tblGrnMain=document.getElementById('tblGrnMain');
	var count=0;
	for(var a=1;a<tblGrnMain.rows.length;a++){
	 if(tblGrnMain.rows[a].cells[0].lastChild.checked == true){
		count++; 
	 }
	}
	if(count == 0){
	 alert("Please select a GRN");
	 return false;
	}
	
	var tblglaccounts=document.getElementById('tblglaccounts');
	var totAmt = 0;
	var rowAmt = 0;
	
	var glRowCount = tblglaccounts.rows.length;

	var count1=0;
	for(var a=1;a<tblglaccounts.rows.length;a++){
		
	 if(tblglaccounts.rows[a].cells[0].lastChild.lastChild.checked == true){
		count1++; 
	 }
	}
	
	if(count1 == 0){
	 alert("Please allocate GL accounts");
	 return false;
	}

	for(var a=1;a<glRowCount;a++){
	 if(tblglaccounts.rows[a].cells[0].lastChild.lastChild.checked == true){
		rowAmt = tblglaccounts.rows[a].cells[3].lastChild.value;
		totAmt += parseFloat(rowAmt);
	 }
	}
	var txtTotGrn=document.getElementById('txtTotGrn').value;

	if(txtTotGrn != totAmt){
	 alert("GL allocated amount not tally with the total grn value");	
	 return false;
	}

	
	var paymentNo = document.getElementById('paymentNo').value;
	var txtPoNo   = document.getElementById('txtPoNo').value;
	var supplier   = document.getElementById('cboSuppliers').value;
	
	var tblglaccounts = document.getElementById('tblglaccounts');
	var rowCount = tblglaccounts.rows.length;
	for(var a=1;a<rowCount;a++){ 
	if(tblglaccounts.rows[a].cells[0].lastChild.lastChild.checked == true){
	var path = "advancePaymenSettelmenttDB.php?RequestType=loadAdvPaySetGlAccNo";
	htmlobj=$.ajax({url:path,async:false});	
	
	
	var XMLdblAdvPaySetGlAccNo = htmlobj.responseXML.getElementsByTagName("dblAdvPaySetGlAccNo");
	var dblAdvPaySetGlAccNo = XMLdblAdvPaySetGlAccNo[0].childNodes[0].nodeValue;
	
		var glAccID = tblglaccounts.rows[a].cells[1].lastChild.nodeValue;
		var glAmt   = tblglaccounts.rows[a].cells[3].lastChild.value;
		
	var path = "advancePaymenSettelmenttDB.php?RequestType=saveGlAccounts";
	    path += "&dblAdvPaySetGlAccNo="+dblAdvPaySetGlAccNo;
	    path += "&paymentNo="+paymentNo;
	    path += "&txtPoNo="+txtPoNo;
		path += "&glAccID="+glAccID;
		path += "&supplier="+supplier;
		path += "&glAmt="+glAmt;
	htmlobj=$.ajax({url:path,async:false});	
	 }
	}

	
	var tblMain=document.getElementById('tblGrnMain').tBodies[0];
	var rC=tblMain.rows.length;
	var count = 0;
	var checked = 0;
	for(var i=0;i<rC;i++){
	 if(tblMain.rows[i].cells[0].childNodes[0].checked==true){	
	  checked++;
	 }
	}
	var txtTotGrn = document.getElementById('txtTotGrn').value;

	 var poNo = document.getElementById('txtPoNo').value;
	 var poYear = document.getElementById('txtPoYear').value;
	 
	 var txtBalance = document.getElementById('txtBalance').value.trim();
	 var txtTotGrn =  document.getElementById('txtTotGrn').value.trim();
	 var grnPoAmount = document.getElementById('grnPoAmount').value.trim();

	 if(parseFloat(txtBalance) == parseFloat(txtTotGrn)){
	
	 var path = "advancePaymenSettelmenttDB.php?RequestType=updateSurended";
		 path += "&poNo="+poNo;
		 path += "&poYear="+poYear;
	htmlobj=$.ajax({url:path,async:false});	
	 if(htmlobj.responseText == 1){
	  getStylePO();	
	 }
	 }
	 
	var txtTotGrn = document.getElementById('txtTotGrn').value;
    for(var i=0;i<rC;i++){
	if(tblMain.rows[i].cells[0].childNodes[0].checked==true){	
	 var fullGRN = tblMain.rows[i].cells[1].childNodes[0].nodeValue;
	 var SPfullGRN = fullGRN.split("/");
	 var grnYear = SPfullGRN[0];
	 var grnNo = SPfullGRN[1];
	 var styleId = tblMain.rows[i].cells[1].id;
	 var itemId  = tblMain.rows[i].cells[2].id;
	 var payAmt = tblMain.rows[i].cells[6].childNodes[0].value;
	 var balanceAmt = tblMain.rows[i].cells[7].childNodes[0].nodeValue;
	 //alert(balanceAmt);
	 var path = "advancePaymenSettelmenttDB.php?RequestType=updateGrnDetails";
		 path += "&grnYear="+grnYear;
		 path += "&grnNo="+grnNo;
		 path += "&styleId="+styleId;
		 path += "&itemId="+itemId;
		 path += "&payAmt="+payAmt;
		 path += "&balanceAmt="+balanceAmt;
		 path += "&txtTotGrn="+txtTotGrn;
		 path += "&poNo="+poNo;
		 path += "&poYear="+poYear;
	htmlobj=$.ajax({url:path,async:false});	
	count++;
	if(checked == count){
	 alert(htmlobj.responseText);	
	 CloseWindow();
	 getStylePO();

	}
  }
 }
}

//--------------------------------------------------------------------------------------------

function updateForSurrender(){
	
var answer = confirm ("Do you really want to Surrender these PO's")
if (!answer){}
else{


	var tblMain=document.getElementById('tblMain');
	var rC=tblMain.rows.length;
	var checked = 0;
	var count = 0;
	for(var i=0;i<rC;i++){
	 if(tblMain.rows[i].cells[7].childNodes[0].checked==true){	
	  checked++;
	 }
	}
	
	

	for(var i=0;i<rC;i++){
	 if(tblMain.rows[i].cells[7].childNodes[0].checked==true){	
	 var fullPo= tblMain.rows[i].cells[2].childNodes[0].nodeValue;
	 var SPfullPO = fullPo.split("/");
	 var poYear = SPfullPO[0];
	 var poNo = SPfullPO[1];
	  	 var path = "advancePaymenSettelmenttDB.php?RequestType=updateSurended";
		     path += "&poNo="+poNo;
		     path += "&poYear="+poYear;
	     htmlobj=$.ajax({url:path,async:false});
		 count++;

		 if(checked == count){
			alert("Surrended Successfully"); 
			getStylePO();
		 }
	 }
	}
 }
}


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

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

function delect_table_content(obj)
{
	$('#'+ obj+' tbody' ).html("")
}


function grid_fix_header_Grn_List()
{
	$("#tblMain").fixedHeader({
	width: 582,height: 250
	});	
}