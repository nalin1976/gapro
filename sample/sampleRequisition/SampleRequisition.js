var pub_rowindexno='';
var savedFlag=0;

/* 
  update_buyer() updates the txtBuyer field with 
  appropriate buyer name depending on the selected value of txtbxStyleNo .
*/
function update_buyer() {
	
	var StyleNo = document.getElementById('cboStyleNo').value;
	var url = "SampleRequisitionXml.php?id=buyerUpdate&StyleNo="+StyleNo;
	
	
	var xmlhttp_obj=$.ajax({url:url,async:false});	
	var XMLstrName = xmlhttp_obj.responseXML.getElementsByTagName("strName");
	
	document.getElementById('txtBuyer').value = XMLstrName[0].childNodes[0].nodeValue;
	document.getElementById('txtSmplNo').value = ''; /*clearing the field if it has been already set from previouse run
														   this part may have to be changed in order to cater the requirement that
														   the text field should be auto incremented.
														   */
}
//---------------------------------------------------------------------------
/*
	xmlQueryResponce() reads in the responce of the query been executed passes by 
	SampleRequisitionXml.php file and  the message to pe displayed. If the reponce is == 0 it identifies as an
	error. then the function prints out a custom made error message passed by developer
	and returnd true value.
	@xml_responce : xml object,responce sent as a result of the query execution.
	@msg: custom message to be passed in to the function to be displayed.
*/

function xmlQueryResponce(xml_responce,msg){
	if(xml_responce == 0){
		alert( msg);
		return true;
	}
}
//----------------------------------------------------------------------------
/* 
   getSampleNo() function retrieves the current available sample number from 
   the database and increments it by one and now this number will be the next 
   available sample number for the system.
   @: int , company id for the selected company on the screen.
*/

function getSampleNo(){
		var url = "SampleRequisitionXml.php?id=samplNoSet";
		var xml_object=$.ajax({url:url,async:false});
		var sml_no = xml_object.responseXML.getElementsByTagName("CurrentSampleNo");
	
		return sample_no=sml_no[0].childNodes[0].nodeValue;
	}
//-----------------------------------------------------------------------------------------------
/*
	updateSampleReqSizes() updates the samplerequestsizes table inthe database, if record insertion
	fails it prompt a message and reverse the changes made to the database.
	@row_start_index: int ,index at which actual data records starts in the table grid. 
	@no_of_data_rows:int number of rows in the table.
	@style_no: string, style number received from the screen.
	@sample_no: int,sample_no retrieved from the syscontrol table. 
	@tblFrom: table object,selected sample Requisition table object.
*/

function updateSampleReqSizes(row_start_index,no_of_data_rows,style_no,sample_no,tblFrom){
	var status_code = 0;
	for(row_start_index;row_start_index<=(no_of_data_rows - 1);row_start_index++){
			
			var sample_type =tblFrom.rows[row_start_index].cells[0].innerHTML;
			var smpl_req_date = tblFrom.rows[row_start_index].cells[1].innerHTML;
			var smpl_size = tblFrom.rows[row_start_index].cells[2].innerHTML;
			var smpl_pcs = tblFrom.rows[row_start_index].cells[3].innerHTML;
			var colour = tblFrom.rows[row_start_index].cells[4].innerHTML;
			
			var url= "SampleRequisitionXml.php?id=samplerequestsizes&sample_type="+sample_type+"&style_no="+style_no; //---
			url +="&smpl_pcs="+smpl_pcs+"&colour="+colour+"&smpl_size="+smpl_size+"&sample_no="+sample_no;
			
			var htmlobj=$.ajax({url:url,async:false});
			var htmlTxt = htmlobj.responseXML.getElementsByTagName("NextQuery");
			var responce = htmlTxt[0].childNodes[0].nodeValue;
			if(xmlQueryResponce(responce," ERROR : INSERTING DATA INTO <samplerequestsizes > TABLE FAILED!"))
			{
				status_code = 1;
				//document.getElementById("txtSmplNo").value=(sample_no - 1 ); // reseting the sample number to priviouse value.
				break;
			}	    
					
	}
	return status_code;
}
//-----------------------------------------------------------------------------------------
/*
	updateSamplReqHeader() updates the samplerequestheader table inthe database, if record insertion
	fails it prompt a message and reverse the changes made to the database.
	@date_requested: string, the date on which the requisition is made.
	@original_sample: boolean, value of Original sample check box. 
	@fabric: boolean, value of Fabric check box.
	@date_fabric_requested:string, the date on which the fabric is requested.
	@accessories:boolean, value of Accessories check box. 
	@date_access_requested:string, the date on which the Accessories are requested.
	@style_no: string, style number received from the screen.
	@sample_no: int,sample_no retrieved from the syscontrol table. 
*/

function updateSamplReqHeader(date_requested,style_no,original_sample,fabric,date_fabric_requested,accessories,date_access_requested,sample_no){
	var status_code = 0;
	url= "SampleRequisitionXml.php?id=samplerequestheader&date_requested="+date_requested+"&style_no="+style_no; //---
	url+="&original_sample="+original_sample+"&fabric="+fabric+"&date_fabric_requested="+date_fabric_requested;
	url+="&accessories="+accessories+"&date_access_requested="+date_access_requested+"&sample_no="+sample_no;
	
	var xml_obj=$.ajax({url:url,async:false});
	var responce= xml_obj.responseXML.getElementsByTagName("NextQuery")[0].childNodes[0].nodeValue;
	if(xmlQueryResponce(responce," ERROR : INSERTING DATA INTO < samplerequestheader > TABLE FAILED!")){
		//document.getElementById("txtSmplNo").value=(sample_no - 1 ); // reseting the sample number to priviouse value.	
		status_code = 1;
	}
	return status_code;
}

//------------------------------------------------------------------------------
/*
	updateSmplReqDetails() updates the samplerequestdetails table inthe database, if record insertion
	fails it prompt a message and reverse the changes made to the database.
	@row_start_index: int ,index at which actual data records starts in the table grid. 
	@row_count:int number of rows in the table.
	@style_no: string, style number received from the screen.
	@sample_no: int,sample_no retrieved from the syscontrol table. 
	@table_main: table object,sample Requisition table object.
*/

function updateSmplReqDetails(row_start_index,row_count,table_main,sample_no,style_no){
	var status_code = 0;
	for(row_start_index; row_start_index<=(row_count-1) ;row_start_index++){
		
		sample_type = table_main.rows[row_start_index].cells[0].innerHTML;
		smpl_req_date = table_main.rows[row_start_index].cells[1].childNodes[1].value;
		if(smpl_req_date != ''){
				
			var url = "SampleRequisitionXml.php?id=samplerequestdetails&sample_type="+sample_type+"&smpl_req_date="+smpl_req_date;
			url+="&sample_no="+sample_no+"&style_no="+style_no; //----
					
			var xml_obj2=$.ajax({url:url,async:false});
			var outPut= xml_obj2.responseXML.getElementsByTagName("NextQuery");
			var responce=outPut[0].childNodes[0].nodeValue;
			
			if(xmlQueryResponce(responce," ERROR : INSERTING DATA INTO < samplerequestdetails > TABLE FAILED!"))
				{
					status_code = 1;
					//document.getElementById("txtSmplNo").value=(sample_no - 1 ); // reseting the sample number to priviouse value.
					break;
				}
		}
	}
	return status_code;
}
//------------------------------------------------------------------------------
/*
  saveToTables() saves extracted data on the screen to three database tables
  called samplerequestsizes,sample Request Header and sample Request Details.
  If any error occurs during the database table update the changes are reversed
  by prompting an error message.It takes in only one parameter it's 
  the company id.
*/

function saveToTables(){

	//var company_id= cmpId;
	var style_no = document.getElementById("cboStyleNo").options[document.getElementById("cboStyleNo").selectedIndex].text;
	var date_requested =document.getElementById("txtDt").value;	
	var sample_no = document.getElementById("txtSmplNo").value;	// @here a function is called to get the sample number from DB.
	var buyer = document.getElementById("txtBuyer").value;
	var original_sample = document.getElementById("orignl_smpl").childNodes[0].checked;	
	var fabric =document.getElementById("fbric").childNodes[0].checked;
	var date_fabric_requested = document.getElementById("txtFabricReqdate").value;
	var accessories = document.getElementById("access").childNodes[0].checked;
	var date_access_requested =document.getElementById("txtAccReqdate").value;
		
		
	var no_of_data_rows =document.getElementById("tblSmplReqDetails").rows.length;	
	var row_start_index = 2;// the first row of data starts at this place
	var sample_type ='';
	var smpl_req_date ='';
	var smpl_pcs = '';
	var colour ='';
	var smpl_size ='';
	var tblFrom = document.getElementById("tblSmplReqDetails");
	
	// validating the number of rows in the selected sample Requisition Details table 
	if(no_of_data_rows == 2 )
	{
		alert("AT LEAST ONE ROW OF DATA IN :Selected Sample Requisition Details :TABLE MUST BE PRESENTED TO CONTINUE SAVING");
		return ;
	}
	
	// GETTING THE SAMPLE NUMBER FROM THE DATA BASE.
	sample_no = getSampleNo();
	
	// varifying if the syscontrol table updated successfuly.
	if(xmlQueryResponce(sample_no," ERROR : UPDATING THE SAMPLE NO IN <syscontrol> TABLE FAILED!")){
		return;
	}
	document.getElementById("txtSmplNo").value = sample_no;
	
	// validating the fields in pop up window
	if(validateFields(style_no,"Style No",date_requested,"Date",sample_no,"Sample No"))//-----
		return ;
	
	// SAVING DATA TO "samplerequestsizes" TABLE.
	var status_code = updateSampleReqSizes(row_start_index,no_of_data_rows,style_no,sample_no,tblFrom);
	if(status_code == 1) return; // if the insertion is unsuccess full exit the function.
	
	// SAVING DATA TO "sample Request Header" TABLE.
	status_code=updateSamplReqHeader(date_requested,style_no,original_sample,fabric,date_fabric_requested,accessories,date_access_requested,sample_no);
	if(status_code == 1) return; // if the insertion is unsuccess full exit the function.
	
	// SAVING DATA TO "sample Request Details" TABLE.
	var table_main = document.getElementById("tblMain");
	var row_count = table_main.rows.length;	
	row_start_index =2;

    status_code = updateSmplReqDetails(row_start_index,row_count,table_main,sample_no,style_no);
	if(status_code == 1) return;
	alert( "MESSAGE : SAVING SUCCESSFUL!");
	savedFlag = 1; // data has been saved.
	clearDateField('tblMain',2); // clear the date fields of the table main upone successfull saving.
	
}
//-----------------------------------------------------------
/*
  clearFields() clears the style No,Date,Buyer and
  sample no fields.
*/

function clearFields(){

	//document.getElementById('cboStyleNo').value = '';
	document.getElementById('txtDt').value = '';
	document.getElementById('txtBuyer').value = '';
	document.getElementById('txtSmplNo').value = '';

	document.getElementById("orignl_smpl").childNodes[0].checked=false;
	document.getElementById("fbric").childNodes[0].checked=false;
	document.getElementById("txtFabricReqdate").value='';
	document.getElementById("access").childNodes[0].checked=false;
	document.getElementById("txtAccReqdate").value='';
	clearDateField('tblMain',2);

}
//----------------------------------------------------------
/*
	clearDateField() method acts as a private method that only serves to clear the date fields
	of the "sample Requisition Details" table. this function which has beeen created only to
	reduce code has been used in few places. 
	@table: String the name of the table
	@row_start: int the row index where the actual data is inserted.
*/

function clearDateField(table,row_start){
	var no_of_rows = document.getElementById(table).rows.length;
	
	if(no_of_rows > row_start){
		for(row_start;row_start <= (no_of_rows-1);row_start++){
			document.getElementById(table).rows[row_start].cells[1].childNodes[1].value='';	
		}
	}
}

//----------------------------------------------------------
/*
 function selectComponrnts() creates the pop up screen 
 SampleRequisitionPopup.php.
 */
 
function selectComponents(obj){
	
	pub_rowindexno = obj.parentNode.parentNode.rowIndex; /* curent node is the button 
															parent of which is a <td> and parent of which is a <tr>.
															by this technique we are calling the row index of the current row
														 */
	pub_rawObj = obj.parentNode.parentNode; // this is the current row object													 
	
	var StyleNo = document.getElementById('cboStyleNo').value; 
	
	// passing required variable and values to the SampleRequisitionPopup.php page.
	var url  = "SampleRequisitionPopup.php?id=size&StyleNo="+StyleNo+"&pub_rowindexno="+pub_rowindexno;
	htmlobj=$.ajax({url:url,async:false});	
	
	//drawPopupAreaLayer(470,320,'SampleRequisitionPopup',1);
	drawPopupBox(0,0,'SampleRequisitionPopup',1);
			
	var HTMLText=htmlobj.responseText;	
	document.getElementById('SampleRequisitionPopup').innerHTML=HTMLText;
}
//-------------------------------------------------------------------
/*
	validationField() takes in variable number of arguments in Value - key pair pattern.
	Suppose there is field called “STYLE NO” exists in a screen and its' value is captured 
	in a variable called ‘style_no’, the arguments passed to the function should be:
	validationField(style_no,”STYLE NO”). there can be variable number of value-key pairs be passed
	in to the function. Then the function will complains about the feild which has an empty value.
*/

function validateFields()
{
	for(i=0; i<arguments.length; i++){
		if(arguments[i] ==''|| arguments[i] =='0' ){
			alert('PLEASE FILL THE FIELD :'+arguments[i+1]+"!"	);
			return true;
		}
		i+=1;
	}
		
}
//---------------------------------------------------------------
/* addToGrid(currentRow_index) extracts all the field values from
	'Sample Requisition Pop Up Details' grid of the sample Requisition
	pop up screen and the field values of 'Sample Requisition Details'
	grid of Sample Requisition.php screen. Then the 'Selected Sample Requisition Details' 
	grid is populated with Sample Type ,Required Date ,Size , No of PCS and Colour.
	@currentRow_index : integer value, the current row index of the 'Sample Requisition Details'
	grid of Sample Requisition.php screen.
*/

function addToGrid(currentRow_index){
	
	// calling the first cell value which is "sample Type"	
	var sampleTypeCell =document.getElementById('tblMain').rows[currentRow_index].cells[0].innerHTML;
	
	//calling the 2nd element of the row which is the "Required date" field
	var requireDateCell =  document.getElementById('tblMain').rows[currentRow_index].cells[1].childNodes[1].value;
	//validating the Required Date Field
	if(validateFields(requireDateCell,"Required Date")){
			closeWindow();
			return;		
	}
	// getting the number of dynamic rows in the pop up table grid.
	var popUpNoOfRowCount = document.getElementById("tbl_srp").rows.length;

	
	var popUpNoOfdataRows = (popUpNoOfRowCount - 2); //gives the actual data rows avoiding table header and etc.
	
	var entry_point = 2 // data always adds to the top row in the "sample Requisition Details" table.
	var row_index = 2; // data inserting starts at row index 2.
	
	var size = '';
	var qty ='';
	var colour = '';
	
	var tblFrom=document.getElementById('tbl_srp');
	var tblTo=document.getElementById('tblSmplReqDetails');
	var closeWindowflag = 1;
	
	for(var i = 1; i <= popUpNoOfdataRows ; i++ ){
		
		size = tblFrom.rows[row_index].cells[1].childNodes[0].value;
		qty =  tblFrom.rows[row_index].cells[2].childNodes[0].value;
		colour =tblFrom.rows[row_index].cells[3].childNodes[0].value;
		
	// validation of the fields;

		if(validateFields(size,"Size",qty,"Qty",colour,"Colour")){
			closeWindowflag = 0;
			break;			  
		  }
		  else if(!isNumeric(qty)){
			alert("Quantity must be a \"Numeric \" value.");
			tblFrom.rows[row_index].cells[2].childNodes[0].focus();
			closeWindowflag = 0;
			break;			  
		  }
		  
		 var htmlTdDefinition='<td width="255" >***</td><td width="255" >***</td><td width="255" >***</td><td width="255" ><td width="255" >***</td>';
		 addrow('tblSmplReqDetails',2,htmlTdDefinition);
			
		tblTo.rows[entry_point].cells[0].innerHTML = sampleTypeCell;
		tblTo.rows[entry_point].cells[1].innerHTML = requireDateCell;
		tblTo.rows[entry_point].cells[2].innerHTML = size;
		tblTo.rows[entry_point].cells[3].innerHTML = qty;
		tblTo.rows[entry_point].cells[4].innerHTML = colour;
			
		row_index ++;
	}
	
	if(closeWindowflag == 1)closeWindow();
}
//------------------------------------------------------------------
/*	function closeWindow close the current window and it takes integer parameter.
	@param : if the param value is '1' there will be a confirmation box on closing the
	window. Else the function simply closes the window
*/

function closeWindow(param){
	try
	{  if( param==1 && confirm("Do you want to close the window !")){
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		}
		else if(param != 1 ){
			var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		}
		
	}
	catch(err)
	{        
	}
}

//------------------------------------------------------------------
/* addRow1() function adds  rows to the first row of the body ,
	but technically it's the 3rd element of the (rowindex). 
	Then it populates the combo box with the sql query. By this function 
	populating of size and colour fields of SampleRequisition Pop up 
	according to the selected style no is performed
*/

function addRow1(){

var rowArray = document.getElementById("tr1").rowIndex; // get the position index of the first row
$value=document.getElementById("cboStyleNo").value

var htmlTdDefinition = '<td width=\"40%\"><input name=\"checkbox\" type=\"checkbox\" class=\"txtbox\" disabled=\"disabled\"/></td><td width=\"30%\"><select style=\"width: 155px;\" class=\"txtbox\" name=\"txtSize'+rowArray+'\" id=\"txtSize'+rowArray+'\"></select></td><td width=\"30%\"><input type=\"text\" class=\xtbox2\"  name=\"txtQty'+rowArray+'\" id=\"txtQty'+rowArray+'\" value=\"0\"/></td><td width=\"30%\"><select style=\"width: 155px;\" class=\"txtbox\" name=\"txtColor'+rowArray+'\" id=\"txtColor'+rowArray+'\"></select></td>';

addrow("tbl_srp",2,htmlTdDefinition);

// add data to the SIZE combo box
loadCombo("SELECT DISTINCT distinct B.strSize AS SIZE, B.strSize AS SIZE FROM orders AS A Inner Join styleratio AS B ON A.intStyleId = B.intStyleId WHERE A.intStyleId = '"+$value+"'","txtSize"+rowArray+"");

//add data to the COLOUR combo box
loadCombo("SELECT DISTINCT B.strColor AS COLOUR, B.strColor AS COLOUR FROM orders AS A Inner Join styleratio AS B ON A.intStyleId = B.intStyleId WHERE A.intStyleId = '"+$value+"'","txtColor"+rowArray+"");
		
}
//------------------------------------------------------------------
/*
	function addrow() adds rows to a given table passed by table id
	at agiven row index according to given HTML <td> statements.
	@table_id : id of the table to which the rows are added.
	@TableRowIndexToAddRows : the row index at which the insertion of the rows happens.e.g. 3,
	@htmlTdDefinition : includes the <td> structure e.g. '<td width="255" >***</td>'
*/

function addrow(table_id,TableRowIndexToAddRows,htmlTdDefinition){
	
	var x =document.getElementById(table_id).insertRow(TableRowIndexToAddRows); //add rows to this row position
	x.innerHTML= htmlTdDefinition;
	}
//------------------------------------------------------------------
/*
	deleteRow() deletes all the rows in a table starting from the first data row.
	@table_id: string or int, the id of the table in whcih the rows needed to be deleated
	@rowIndexToDeleteRows: the index at which the deletion starts.
	@dataRowStartIndex: the index at which the data rows start in the table.
*/
function deleteRow(table_id,rowIndexToDeleteRows,dataRowStartIndex){
	var tbleRowDelete =document.getElementById(table_id);
	var lastRowIndex =(tbleRowDelete.rows.length - 1);
	
	if( dataRowStartIndex <tbleRowDelete.rows.length){
	   for(rowIndexToDeleteRows;rowIndexToDeleteRows<=lastRowIndex;){
		    //lastRowIndex =(tbleRowDelete.rows.length - 1);
			var x =tbleRowDelete.deleteRow(rowIndexToDeleteRows);
		    lastRowIndex =(tbleRowDelete.rows.length - 1);
	   }
	}	
}

//-----------------------------------------------------------------------------------------------
/*
  clearGridIfSaved() function clears the "Selected Sample Requisition Details" data,
  if the remaining data in the grid has been saved once and it takes no arguments.
*/
function clearGridIfSaved(){
	if( savedFlag == 1 )
	deleteRow('tblSmplReqDetails',2,2);
	savedFlag = 0;
	
}



	

function getOrderNo()
{
	//Loading the combo Box 'Order no'
	
	 var styleNoList=document.getElementById('cboStyleNo').value;
	 var url;
	 var xmlhttp_obj;
	 var html;
	 
	 url="SampleRequisitionXml.php?id=loadOrderNo&stylename="+styleNoList;
	 xmlhttp_obj=$.ajax({url:url,async:false})
	 
	 html = xmlhttp_obj.responseText;
	 document.getElementById('OrderDetails').innerHTML = html;
	 
	 //Loading the checkboxes
	
	 if(styleNoList!=-1)
	 {
		url="SampleRequisitionXml.php?id=loadCheckBox1&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#originalSample').attr('checked',true);
			$('#originalSample').attr('disabled',true);
		}

	 }
	 
	  if(styleNoList!=-1)
	 {
		url="SampleRequisitionXml.php?id=loadCheckBox2&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#fabric').attr('checked',true);
			$('#fabric').attr('disabled',true);
		}

	 }
	 
	 	  if(styleNoList!=-1)
	 {
		url="SampleRequisitionXml.php?id=loadCheckBox3&styleno="+styleNoList; 
		xmlhttp_obj=$.ajax({url:url,async:false})
	    html = xmlhttp_obj.responseText;
		
		
		if(html=="1")
		{
			
			$('#accessories').attr('checked',true);
			$('#accessories').attr('disabled',true);
		}

	 }
	 
	 
	
}

function showColorSizeSelector2(ratiowindow)
{
	
	//drawPopupBox(500,435,'size_color_popup',3);
	
	//var frame = document.createElement("div");
    //frame.id = "colorsizeselectwindow";
	//document.getElementById('size_color_popup').innerHTML=HTMLText;	
	
	//var W	= 0;
	//var H	= 258;
	//var tdHeader = "td_coHeader";
	//var tdDelete = "td_coDelete";
	//var closePopUp = "closePopup_sample";
	//var tdPopUpClose = "measurement_allocation_popup_close_button";
	//var tdPopUpClose = "sample_popup_close";
	//CreatePopUp2('size_color_popup.php',W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	

	
	drawPopupBox(0,0,'SampleSizeColorPopUp',2);
	
	var url  = "size_color_popup.php";
	htmlobj=$.ajax({url:url,async:false});	
	
	var HTMLText=htmlobj.responseText;	
	document.getElementById('SampleSizeColorPopUp').innerHTML=HTMLText;
	
}

function AddSelection()
{
	var colors = document.getElementById('cboselectedcolors');
	var sizes  = document.getElementById('cboselectedsizes');
	var gridTable = document.getElementById('tbl_srp');
	var lastRow   = gridTable.rows.length;
	var lastColumn= gridTable.rows[0].cells.length;

	
	if(colors.options.length!=0 && sizes.options.length!=0)
	{
		
		for(var x=0;x<colors.length;x++)
		{
			
			lastColumn= gridTable.rows[0].cells.length;
			
			var newCell = gridTable.rows[0].insertCell(lastColumn);
			newCell.className = "mainHeading4";
			newCell.innerHTML = colors[x].value;
			
			closePopupBox(2);
		}
		
		for(var y=0;y<sizes.length;y++)
		{
			lastRow   = gridTable.rows.length;
			
			var newRow = gridTable.insertRow(lastRow);
			var newCell2 = newRow.insertCell(0);
			newCell2.className = "mainHeading4";
			newCell2.innerHTML = sizes[y].value;
			
			for(var i=1;i<gridTable.rows[0].cells.length;i++)
			{
				var textCell = newRow.insertCell(i);
				textCell.bgColor = "#FBF8B3";
				textCell.style.textAlign = "center";
				textCell.innerHTML = "<input type='text' style='width:100px; text-align:center'/>";
				
			}
			
			
		}
		
		
		
	}
	else
	{
		alert("Select Colour and Size !");
	}
}