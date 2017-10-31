var xmlHttp;

var accNo=""
var accName=""
var accType=""
var accFactory=""

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
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >"+ PaymentNo +"</td>"+	
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poPaidAmt).toFixed(2) +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" name=\""+poYear+"\" id=\""+poNo+"\" >"+ poYear+"/"+poNo +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poValue).toFixed(2) +"</td>"+				
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(settledAmt).toFixed(2) +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(poBalance).toFixed(2) +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\"><div align=\"center\"><img src=\"../images/accept.png\" onClick=\"getGRNList(this);\"  alt=\"GRN\"  class=\"mouseover\" /></div></td><td class=\""+cls+"\" style=\"text-align:center;\"><input type=\"checkbox\" class=\"txtbox\"></td>"+
				
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
	
	
	var url  = "GrnDetails2.php?poYear="+poYear+"&&advance="+advance+"&&type="+type+"&&balance="+balance+"&&poNo="+poNo+"&&paymentNo="+paymentNo;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(500,100,'fmGrnDetails',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('fmGrnDetails').innerHTML=HTMLText;	
	
	LoadSupplierGL();
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
	var tblglaccounts=document.getElementById('tblglaccounts');
	var totAmt = 0;
	var rowAmt = 0;
	
	var glRowCount = tblglaccounts.rows.length;
	if(glRowCount < 2){
	 alert("Please allocate GL accounts");
	 return false;
	}
	for(var a=1;a<glRowCount;a++){
		rowAmt = tblglaccounts.rows[a].cells[3].lastChild.value;
		totAmt += parseFloat(rowAmt);;
	}
	var txtTotGrn=document.getElementById('txtTotGrn').value;
	if(txtTotGrn != totAmt){
	 alert("GL allocated ammount not tally with total grn value");	
	 return false;
	}

	
	var paymentNo = document.getElementById('paymentNo').value;
	var txtPoNo   = document.getElementById('txtPoNo').value;
	var supplier   = document.getElementById('cboSuppliers').value;
	
	var tblglaccounts = document.getElementById('tblglaccounts');
	var rowCount = tblglaccounts.rows.length;
	for(var a=1;a<rowCount;a++){
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
	 var payAmt = tblMain.rows[i].cells[6].childNodes[0].value;
	 var balanceAmt = tblMain.rows[i].cells[7].childNodes[0].nodeValue;
	 //alert(balanceAmt);
	 var path = "advancePaymenSettelmenttDB.php?RequestType=updateGrnDetails";
		 path += "&grnYear="+grnYear;
		 path += "&grnNo="+grnNo;
		 path += "&styleId="+styleId;
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

//---------------------------------------------------------------------------------------------

function LoadSupplierGL()
{
	var SupID = 1;
	var FacCd = 2;	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadSupplierGL;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadSupplierGL&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
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
			var tableText = "<table width=\"100%\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblglaccounts\" bgcolor=\"#CCCCFF\">"  +
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
					

					var tbl = document.getElementById('tblglaccounts');		
			        var lastRow = tbl.rows.length;	
				    ((lastRow % 2)==1)?cls='grid_raw':cls='grid_raw2';
									
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" checked='checked' />";

						tableText += "<tr class=\"bcgcolor-tblrowWhite\">"+
									"<td class=\""+cls+"\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\""+cls+"\" id=\"" +facId + "\" style=\"text-align:left;\">" + accNo+""+facAccId + "</td>" +
									"<td class=\""+cls+"\" id=\"" + XMLDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" +accName + "</td>" +
									"<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\"></td>" +
									"</tr>";
					boolcheck = true;
				}
				tableText+="</table>";
				document.getElementById("divcons").innerHTML = tableText;
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