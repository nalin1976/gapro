
/*
 function loadDocDesdPopUp loads the pop up screen 
 on top of the parent screen
*/
function loadDocDescPopUp(obj){
	
		var url = "documentPopUp.php?"; // pass the url of the pop up screen to where it's required to navigate
		var httpObj = $.ajax({url:url,async:false});
		drawPopupArea(350,120,"popexpense");
		document.getElementById("popexpense").innerHTML=httpObj.responseText;
		//document.getElementById("popexpense").value=obj.parent.parent.cells[2].id;	
		//document.getElementById("popexpense").onclick();			
}

/*
 function getDocListForInvoice() loads the document list 
 associated with the selected invoice number
*/
function getDocListForInvoice(cboFinalInvoice){
	
    var strInvoiceNo =document.getElementById('cboFinalInvoice').value;
	var tbl 	= document.getElementById("tblDescription");
	
    var url 	= "documentList_middle.php?request=addDocListToGrid&strInvoiceNo="+strInvoiceNo;
	var httpObj	= $.ajax({url:url,async:false});
	cleargridcheckbox();

	
	try{
			var XMLId	=httpObj.responseXML.getElementsByTagName("intDocumentFormatId");
			var GpaNo =  httpObj.responseXML.getElementsByTagName("strGpa")[0].childNodes[0].nodeValue;
			var PicNo =  httpObj.responseXML.getElementsByTagName("strPicNo")[0].childNodes[0].nodeValue;
			var Crt	=  httpObj.responseXML.getElementsByTagName("strCertOfOrigin")[0].childNodes[0].nodeValue;
			$('#txtGpaNo').val(GpaNo);
			$('#txtPicNo').val(PicNo);
			$('#txtCrt').val(Crt);
		
	}
	catch(err)
	{
		$('#txtGpaNo').val('');
		$('#txtPicNo').val('');
		$('#txtCrt').val('');
		
	}
	
	//alert( XMLDoc.length)
	var tbl 	= document.getElementById("tblDescription").tBodies[0];

	for(var loop=0;loop < XMLId.length ;loop++)
	{
		var id 		= httpObj.responseXML.getElementsByTagName("intDocumentFormatId")[loop].childNodes[0].nodeValue;
		tbl.rows[loop].cells[3].id

		for( var i=0; i< tbl.rows.length; i++){	
		if( tbl.rows[i].cells[3].id ==id){ 
			tbl.rows[i].cells[0].childNodes[0].checked=true;
		}
		}
	}
	
}

/*
function loadComboBox() populates the popDoc combo box
at load time once the function is executed.
*/
function loadComboBox(){
	
	var sql = "select * from document_list where document_list.strStatus = '0'";
	loadCombo(sql,"popDoc");
	
}
/*
  function loadDoc() loads text boxes document and document description
  based on the selected value of the combo box popDoc
  @cboPopDoc : element id of the combobox
*/

function loadDoc(cboPopDoc){
	clearForm();
	var docName = document.getElementById('popDoc').options[document.getElementById('popDoc').selectedIndex].text;
	
	var url = "documentList_middle.php?request=loadpopupdesc&docName="+docName;
	var objXmlResponce = $.ajax({url:url,async:false});
	$('#txtpopDocDesc').val( objXmlResponce.responseXML.getElementsByTagName("strDocDesc")[0].childNodes[0].nodeValue);
	$('#txtpopNewDoc').val( objXmlResponce.responseXML.getElementsByTagName("StrDocument")[0].childNodes[0].nodeValue);
	$('#txDocumentFormatId').val( objXmlResponce.responseXML.getElementsByTagName("intDocumentFormatId")[0].childNodes[0].nodeValue); //hidden field to store PK.
	
}
/*
  function clearForm() clears the text box values on pop up screen
*/

function clearForm(){
$('#txtpopDocDesc').val("");
$('#txtpopNewDoc').val("");
}

/*
 function cleargrid(tblObj) clears the rows from row index 1 onwards.
 @tblObj : element id of the table of wich the rows needed to be cleared.	
*/
function cleargrid(tblObj){
	 var tbl =document.getElementById(tblObj);
	 var numrows = document.getElementById(tblObj).rows.length
	 for ( var loop = 1;numrows>1 && 1 < tbl.rows.length ;){
		 tbl.deleteRow(loop);
	 }
	
}
/*
	 clearPage() function clears the content on the documentList.php
	 @param : table object -tblObj, the grid that needs to be clear
*/

function clearPage(tblObj){
	
$('#cboFinalInvoice').val("");
//cleargridcheckbox();
}


function cleargridcheckbox()
{
	var tbl = document.getElementById("tblDescription").tBodies[0];

//	alert("tablelength :"+tbl.rows.length);
	for(var loop=0;loop < tbl.rows.length ;loop++)
	{ 
		tbl.rows[loop].cells[0].childNodes[0].checked=false;
	}

}
/*
	 saveDoc() function saves the changes made to the documents to the tables document_list and
	 invoice_document_list. i.e. Altering existing document name and it's description 
	 against an invoice number or inserting a totaly new document to the system against an invoice number.
	 once the function is fired changes are vissible in the parent screen grid.
	 @param : table object -tblObj, the grid that needs to be clear
*/


function saveDoc(){
	var docFormatId 	= $('#txDocumentFormatId').val();
	var changeDocName 	= $('#txtpopNewDoc').val();
	var changeDocDesc 	= $('#txtpopDocDesc').val();
	if(changeDocDesc == '') changeDocDesc = 'N/A';
	var strInvoiceNo 	= document.getElementById('cboFinalInvoice').value;
	
	if( changeDocName !="" ){
		var url = "documentList_middle.php?request=saveDoc&docFormatId="+docFormatId+"&changeDocName="+changeDocName+"&changeDocDesc="+changeDocDesc+"&strInvoiceNo="+strInvoiceNo;
		var objXML = $.ajax({url:url,async:false});
	
		loadComboBox(); // load the popup combo box with updated values
		try{
		var intDocumentFormatId = objXML.responseXML.getElementsByTagName("intDocumentFormatId")[0].childNodes[0].nodeValue;
		var StrDocument=  objXML.responseXML.getElementsByTagName("StrDocument")[0].childNodes[0].nodeValue;
		var strDocDesc =  objXML.responseXML.getElementsByTagName("strDocDesc")[0].childNodes[0].nodeValue;
		var status				= objXML.responseXML.getElementsByTagName("status")[0].childNodes[0].nodeValue;
		var tbl 				= document.getElementById("tblDescription").tBodies[0];
		}
		catch(err)
		{
			var status =5;
		}
		//alert(status);
		switch(status)
		{
			case 1:
			 alert("Saved successfuly");
			 break;
			case 2:
			 alert("Updated successfuly");
			 break;
		    case 3:
		     alert("Saving error");
		     break;
		    case 4:
		     alert("Updating error");
		     break;
			case 5:
		     alert("Trying to save duplicate document!! Error ");
		  	 break;
		}
		addRecordToGrid(status,intDocumentFormatId); // adding row to the grid if status is 1 
		if(status ==1 || status ==2 ){
			for( var i=0; i< tbl.rows.length; i++){	
		if( tbl.rows[i].cells[3].id ==intDocumentFormatId){ 
			tbl.rows[i].cells[0].childNodes[0].checked=true;
			tbl.rows[i].cells[3].innerHTML = StrDocument;
			tbl.rows[i].cells[4].innerHTML = strDocDesc;
			
			}
		  }
		}
		
		
		//getDocListForInvoice('cboFinalInvoice'); // update the grid in the parent screen.
	}
}

function addRecordToGrid(status1,intDocumentFormatId1){
	var satus = status1;
	var tbl = document.getElementById("tblDescription").tBodies[0];
	var tablelastrow = tbl.rows.length;
	
	if(status1 ==1){
	var url="documentList_middle.php?request=getdocs&intDocumentFormatId1="+intDocumentFormatId1;
	var objXML1 = $.ajax({url:url,async:false});
	
	var StrDocument=objXML1.responseXML.getElementsByTagName("StrDocument")[0].childNodes[0].nodeValue;
	var strDocDesc =objXML1.responseXML.getElementsByTagName("strDocDesc")[0].childNodes[0].nodeValue;
	
	//alert("StrDocument: "+StrDocument+"strDocDesc: "+strDocDesc)
	
	var row = tbl.insertRow(tablelastrow); // insert an empty record	
	(tablelastrow%2 == 1)? classColour = "bcgcolor-tblrowWhite":classColour = "bcgcolor-tblrow";
	row.className = classColour;
		
		insertHTML ="<td><input type=\"checkbox\" class=\"chkbx\" /></td>";
		insertHTML +="<td class=\"normalfntMid\"  ><img src=\"../../images/edit.png\" width=\"15\" height=\"15\" align=\"absmiddle\" class=\"mouseover\" onclick=\"loadDocDescPopUp(this);loadComboBox();loadSelectRow(this)\" /></td>";
		insertHTML +="<td class=\"normalfntMid\"  style=\"display:none\" ><img src=\"../../images/del.png\" width=\"15\" height=\"15\" class=\"mouseover\" onclick=\"deleteRec(this)\" /></td>";
		insertHTML +="<td class=\"normalfnt\" id =\""+intDocumentFormatId1+"\" >"+StrDocument+"</td>";
		insertHTML +="<td  class=\"normalfnt\" >"+strDocDesc+"</td>";
		tbl.rows[tablelastrow].innerHTML = insertHTML;
	}
	
}
/*
  function deleteRec(id) takes the id of the image(images/del.png) object as the parameter.
  and it delete that specific record from the grid , further this function uopdates 
  the invoice_document_list table accordingly against the selecteed invoice number.
  @id : id of the image element
*/
function deleteRec(id){
	var rowObject = id.parentNode.parentNode; //tablerow 
	var tableObj = rowObject.parentNode; // returns the table object.
	//confirm("Do you want to delete the selected Reocrd!","DELETE RECORD");
	//var cellId = rowObject.cells[3].id; // this provides the PK of the document to be deleted.
	//var invoiceNo = $('#cboFinalInvoice').val();
	
	//var url1 = "documentList_middle.php?request=updateDeletRcd&intDocumentFormatId="+cellId+"&invoiceNo="+invoiceNo;
//	var objXML1 = $.ajax({url:url1,async:false});
	//var successflag = objXML1.responseText;
	 tableObj.deleteRow(rowObject.rowIndex);
	//if(successflag == 1) rowObject.cells[0].childNodes[0].checked = false; // set the check box to unset.
	
}
/*
	function saveToInvoiceDocList() generates Successfuly Saved
	message.
*/
function saveToInvoiceDocList(){
	var tbl = document.getElementById("tblDescription").tBodies[0];
	var rowlength = tbl.rows.length;
	var invoiceno = $('#cboFinalInvoice').val();
	var gpaNo 		=	$('#txtGpaNo').val();
	var picNo		=	$('#txtPicNo').val();
	var certOrigin	=	$('#txtCrt').val();

	deleteDoc(invoiceno);
	url="documentList_middle.php?request=saveHeader&gpaNo="+URLEncode(gpaNo)+"&picNo="+URLEncode(picNo)+"&certOrigin="+URLEncode(certOrigin)+"&invoiceno="+invoiceno;
	htmlobj1 = $.ajax({url:url,async:false})
	
	
	for(var i = 0; i<rowlength ; i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			
			var id = tbl.rows[i].cells[3].id;
			url="documentList_middle.php?request=savemaindata&intDocumentFormatId="+id+"&invoiceno="+invoiceno;
			htmlobj = $.ajax({url:url,async:false})
			
	}
	
	
}alert(htmlobj.responseText);
}

function deleteDoc(inv){
	url="documentList_middle.php?request=delmaindata&invoiceno="+inv;
	htmlobj = $.ajax({url:url,async:false})
}
/*
  function loadSelectRow(idImage) takes the id of the image(images/save_small.jpg) object as the parameter.
  and it loads the document and the description on to the text boxes accordingly .
  @idImage : id of the image element
*/

function loadSelectRow(idImage){
	var docName = idImage.parentNode.parentNode.cells[3].innerHTML;
	var url = "documentList_middle.php?request=loadpopupdesc&docName="+docName;
	var objXmlResponce = $.ajax({url:url,async:false});
	$('#txtpopDocDesc').val( objXmlResponce.responseXML.getElementsByTagName("strDocDesc")[0].childNodes[0].nodeValue);
	$('#txtpopNewDoc').val( objXmlResponce.responseXML.getElementsByTagName("StrDocument")[0].childNodes[0].nodeValue);
	$('#txDocumentFormatId').val( objXmlResponce.responseXML.getElementsByTagName("intDocumentFormatId")[0].childNodes[0].nodeValue);
	
}
/*
 function showReport() navigates to the documentListReport.php
 if the invoice number is set.	
*/
function showReport(){
	
	var invno=document.getElementById('cboFinalInvoice').value.trim();
	if(invno!='')
	{
		window.open("documentListReport.php?InvoiceNo="+invno,"report");
	}
	
}
/*
 function refreshi() clears the values of all the element on the document
*/
function refreshi()
{
	$('#popDoc').val('');
	$('#txtpopNewDoc').val('');
	$('#txtpopDocDesc').val('');
	$('#txDocumentFormatId').val('');	
}


function deleterRecord()
{
  var docdesc = $('#txtpopDocDesc').val();	
  var doc	= $('#txtpopNewDoc').val();
  var docid = $('#txDocumentFormatId').val();
  url = "documentList_middle.php?request=deleRecord&docid="+docid+"&doc="+doc+"&docdesc="+docdesc;
  var objXmlResponce = $.ajax({url:url,async:false});
  
  alert(objXmlResponce.responseText);
  loadComboBox();
  getDocListForInvoice(document.getElementById('cboFinalInvoice').value);
  tblid =document.getElementById('txDocumentFormatId');
  deleteRec(tblid);
  
  
  
}