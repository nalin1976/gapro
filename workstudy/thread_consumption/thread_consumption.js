var xmlHttpreq = [];
var pub_url = "/gaprofree/addinns/thread_consumption/";


//----------Load colors--------------------------------------
function loadGrid(styleID)
{
	
    document.getElementById('cboOrderNo').value= styleID;
    document.getElementById('cboStyle').value = styleID;
	
	
	
	var path="xml.php?RequestType=loadGrid&styId="+document.getElementById('cboStyle').value;
	
	htmlobj=$.ajax({url:path,async:false});
	
		//alert(htmlobj.responseText); 
	
	var XMLSerial   = htmlobj.responseXML.getElementsByTagName("serial");
	var XMLMachineId  = htmlobj.responseXML.getElementsByTagName("machineID");
	var XMLMachineDesc  = htmlobj.responseXML.getElementsByTagName("machineDesc");
	var XMLOperatId  = htmlobj.responseXML.getElementsByTagName("opID");
	var XMLOperatCode  = htmlobj.responseXML.getElementsByTagName("opCode");
	var XMStrOperat  = htmlobj.responseXML.getElementsByTagName("strOperat");
	var XMLLength  = htmlobj.responseXML.getElementsByTagName("length");
	var XMLComCatog  = htmlobj.responseXML.getElementsByTagName("comCatogory");
	var XMLStrMachine  = htmlobj.responseXML.getElementsByTagName("srtMachine");
	var XMLMachineStitchRatio  = htmlobj.responseXML.getElementsByTagName("MachineRatio");
	var XMLdblWastage  = htmlobj.responseXML.getElementsByTagName("dblWastage");
	
	if(XMLdblWastage!="")
	{
		document.getElementById('txtWastage').value=XMLdblWastage[0].childNodes[0].nodeValue;
	}
	
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblThreadCons\"  class=\"thetable\">"+
                                "<tr>"+
                                  "<th style='background-color:#FBF8B3'>Serial No</th>"+
                                  "<th style='background-color:#FBF8B3'>Comp Catogory</th>"+
                                  "<th style='background-color:#FBF8B3'>Machine ID</th>"+
                                  "<th style='background-color:#FBF8B3'>Opt Code</th>"+
                                  "<th style='background-color:#FBF8B3'>Operations</th>"+
                                  "<th style='background-color:#FBF8B3'>Opt Length (inches)</th>"+
                                  "<th style='background-color:#FBF8B3'>Combination</th>"+
								  "<th style=\"display:none\"></th>"+
								  "</tr>";
								
			 for ( var loop = 0; loop < XMLSerial.length; loop ++)
			 {
				 
				var rowClass="grid_raw";	
				if(XMLLength[loop].childNodes[0].nodeValue>0){
				rowClass="";
				var bgcolor="#FFD2FF";	
				}
				else{
				var bgcolor="";	
				}
				
				
				
				tableText +=" <tr class=\"" + rowClass + "\"  bgcolor=\"" + bgcolor + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSerial[loop].childNodes[0].nodeValue + "\" > "+ XMLSerial[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLMachineStitchRatio[loop].childNodes[0].nodeValue + "\" >"+ XMLComCatog[loop].childNodes[0].nodeValue +" </td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLStrMachine[loop].childNodes[0].nodeValue + "\" > "+ XMLMachineDesc[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLOperatId[loop].childNodes[0].nodeValue + "\" > "+ XMLOperatCode[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMStrOperat[loop].childNodes[0].nodeValue + "\" > "+ XMStrOperat[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"right\" id=\"" + XMLMachineStitchRatio[loop].childNodes[0].nodeValue + "\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" maxlength=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" value=\""+ XMLMachineStitchRatio[loop].childNodes[0].nodeValue+"\"> " +
							"</input></td>" +  													// click.png
							" <td class=\"normalfntMid\" align=\"right\"><img src=\"../../images/combination.png\" height=\"18\" border=\"0\" onclick=\"chechWast(this,"+loop+");\" class=\"mouseover\"/></td>" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLMachineId[loop].childNodes[0].nodeValue + "\" style=\"display:none\"> "+ XMLMachineId[loop].childNodes[0].nodeValue +"</td>"+
							" </tr>";
			 }
			tableText += "</table>";
			document.getElementById('divcons').innerHTML=tableText;  
}
//-------------------------------------------------------------------------------
function saveThreadConsumption()
{
	if(validateForm())
	{	
		//showBackGroundBalck();
	
		var tbl = document.getElementById('tblThreadCons');
		noOfRows=tbl.rows.length-1;
		var ArraySerial = "";
		var ArrayStyle = "";
		var ArrayOpId = "";
		var ArrayMacineID = "";
		var ArrayLength = "";
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[5].childNodes[0].value!=0)
			{
				var serial = URLEncode(tbl.rows[loop].cells[0].innerHTML);
				var style =  URLEncode(document.getElementById('cboStyle').value);
				var opID = URLEncode(tbl.rows[loop].cells[3].innerHTML);
				var machineId = URLEncode(tbl.rows[loop].cells[2].innerHTML);
				var length =  URLEncode(tbl.rows[loop].cells[5].childNodes[0].value);
				
				ArraySerial += serial + ",";
				ArrayStyle += style + ",";
				ArrayOpId += opID + ",";
				ArrayMacineID += machineId + ",";
				ArrayLength += length + ",";
			}
		}
	
	path="";
	path="xml.php?RequestType=Save&ArraySerial="+ArraySerial+"&ArrayStyle="+ArrayStyle+"&ArrayOpId="+ArrayOpId+"&ArrayMacineID="+ArrayMacineID+"&ArrayLength="+ArrayLength;	
	
	htmlobj=$.ajax({url:path,async:false});
	
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
			//	hideBackGroundBalck();
				alert("Saved successfully.");
				clearForm()
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "False"){
				alert("Save failed.");
			}
			if(XMLResult[0].childNodes[0].nodeValue == "UpdateTrue")
			{
				//hideBackGroundBalck();
				alert("Updated successfully.");
				clearForm()
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "UpdateFalse"){
				alert("Update failed.");
			}
			
	}
}
//---------Validate form----------------------------------------
function validateForm()
{
	var tbl = document.getElementById('tblThreadCons');
    var rows = tbl.rows.length-1;
	
	if (document.getElementById('cboStyle').value == "" )	
	{
		alert("Please select a \"Style No\" ");
		document.getElementById('cboStyle').focus();
		return false;
	}
	else if (rows <1 )	
	{
		alert("There is no any record to save.");
		document.getElementById('cboStyle').focus();
		return false;
	}
	else{
		return true;
	}
}

//---------------------------------------------------
function clearForm(){
	//document.frmWashReceive.reset();
	
	document.getElementById('cboStyle').value='';
	document.getElementById('cboOrderNo').value='';
	
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblThreadCons\"  class=\"\">"+
				"<caption style=\"background:#9bbfdd;\"></caption>"+
				"<tr >"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Serial No</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Comp Catogory</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Machine ID</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Opt Code</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Operations</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Opt Length (inches)</th>"+
					"<td bgcolor=\"#498cc2\" class=\"normaltxtmidb2\">Combination</th>"+
					"<td style=\"display:none\"></th>"+
								  "</tr></table>";
	//alert(tableText);
			document.getElementById('divcons').innerHTML=tableText;  
			document.getElementById('cboStyle').focus();
}
//---------------------------------------------------------
function loadCombinations(obj,rodID)
{
	if(obj.parentNode.parentNode.cells[5].childNodes[0].value==0){
		alert("Please add combination quantity.");
		return false;
	}
	
	var serialNo=obj.parentNode.parentNode.cells[0].innerHTML.trim();
	var mID=obj.parentNode.parentNode.cells[2].id;
	var stitchRatioID=obj.parentNode.parentNode.cells[1].id;
	
	var potCode=obj.parentNode.parentNode.cells[4].innerHTML.trim();
	var lgn=obj.parentNode.parentNode.cells[5].childNodes[0].value;
	var savedLength=obj.parentNode.parentNode.cells[5].id;
	//obj.parentNode.parentNode.cells[5].childNodes[0].value=0;
	
	var machineID=obj.parentNode.parentNode.cells[7].innerHTML.trim();
	var operatID=obj.parentNode.parentNode.cells[3].id;
	var styleID=document.getElementById('cboStyle').value;
	
    var order=document.getElementById('cboOrderNo').text;
    var style=document.getElementById('cboStyle').text;
	
	var url  = "combinations.php?mId="+machineID+"&styid="+styleID+"&opid="+operatID;
	htmlobj=$.ajax({url:url,async:false});
	
	
	drawPopupAreaLayer(876,418,'frmCombinations',1);
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmCombinations').innerHTML=HTMLText;	
	//----hem--------------
	var SelectOption=document.frmTreadConsump.cboStyle;
	var SelectedIndex=SelectOption.selectedIndex;
	var SelectedValue=SelectOption.value;
	var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
	document.getElementById('txtCombStyle').value=SelectedText;	
	document.getElementById('txtCombStyleID').value=styleID;
	
	var SelectOption=document.frmTreadConsump.cboOrderNo;
	var SelectedIndex=SelectOption.selectedIndex;
	var SelectedValue=SelectOption.value;
	var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
	document.getElementById('txtCombPo').value=SelectedText;
	
	document.getElementById('txtComOpert').value=potCode;
	document.getElementById('txtComOpertID').value=operatID;
	document.getElementById('txtCombMac').value=mID;
	document.getElementById('txtCombMacID').value=machineID;
	document.getElementById('txtCombLen').value=lgn;
	document.getElementById('txtPrevRow').value=rodID;
	
	document.getElementById('cboMachine').value=mID;
	//document.getElementById('cboStitchRatio').value=stitchRatioID;
	document.getElementById('txtSerial').value=serialNo;
	document.getElementById('txtCombSavedLen').value=savedLength;
	
	loadCombinationGrid();
	
}
//-----------------------------------------------------
function loadCombinationGrid(){
	
   document.getElementById('divconsCombi').innerHTML="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblCombination\"  class=\"thetable\">"+
   								"<caption style='background-color:#FBF8B3'></caption>"+
                                "<tr>"+
                                  "<td style='background-color:#FBF8B3'>Serial</td>"+
                                  "<td width='25%' style='background-color:#FBF8B3'>Color</td>"+
                                  "<td style='background-color:#FBF8B3'>Stitch Type</td>"+
                                  "<td style='background-color:#FBF8B3'>Thread Type</td>"+
                                  "<td style='background-color:#FBF8B3'>Machine Id</td>"+
                                  "<td style='background-color:#FBF8B3'>Operation</td>"+
								  "</tr>"+
								"<tr><td colspan=\"9\" height=\"40\" class=\"normalfnt\"></td></tr>"+
								"<tr><td colspan\"9\" class=\"normalfntMid\"><div id=\"imag\"><img src=\"../../images/loadingimg.gif\" /></div></td></tr>"+
								  "</table>"; 
								  ;
								 // alert("dfdfd");
   style=document.getElementById('txtCombStyleID').value;
   opCode=document.getElementById('txtComOpertID').value;
   operatDesc=document.getElementById('txtComOpert').value;
   mID=document.getElementById('txtCombMac').value;
   operationDesc=document.getElementById('txtComOpert').value;
   //stitchRatioName=document.getElementById('cboStitchRatio').value;
//   machineFactor=document.getElementById('cboMachineFactor').value;
   
   actualTotLen=document.getElementById('txtCombSavedLen').value;
   totLength=document.getElementById('txtCombLen').value;
   var wast2 = document.getElementById('txtWastage').value;
   var mId = document.getElementById('cboMachine2').value;
   
   //alert(style); alert(opCode); alert(operatDesc); alert(mID);  alert(actualTotLen); alert(totLength);
	var path	= "combinationGrid.php?mId="+mId+"&style="+style+"&opCode="+opCode+"&mID="+mID+"&operatDesc="+operatDesc+"&actualTotLen="+actualTotLen+"&totLength="+totLength+"&wast2="+wast2;
	htmlobj		= $.ajax({url:path,async:false});
	document.getElementById('divconsCombi').innerHTML=htmlobj.responseText;	//alert(htmlobj.responseText);
   
/*	var path="xml.php?RequestType=loadCombo";
	htmlobj=$.ajax({url:path,async:false});
	var XMLColorCombo  = htmlobj.responseXML.getElementsByTagName("colorCombo");
	var XMLThreadCombo  = htmlobj.responseXML.getElementsByTagName("threadCombo");
	var XMLTexCombo  = htmlobj.responseXML.getElementsByTagName("texCombo");
	alert(htmlobj.responseXML.getElementsByTagName("colorCombo")); 
	
	
	var path="xml.php?RequestType=loadCombinationGrid&style="+style+"&opCode="+opCode+"&mID="+mID+"&stitchRatioName="+stitchRatioName;
	htmlobj=$.ajax({url:path,async:false});
	
	
	var XMLstitch  = htmlobj.responseXML.getElementsByTagName("stitch");
	var XMLthread  = htmlobj.responseXML.getElementsByTagName("thread");
	var XMLtex  = htmlobj.responseXML.getElementsByTagName("tex");
	var XMLcolor  = htmlobj.responseXML.getElementsByTagName("color");

	var XMLstitchDes   = htmlobj.responseXML.getElementsByTagName("stitchDes");
	var XMLthreadDes  = htmlobj.responseXML.getElementsByTagName("threadDes");
	var XMLtexDes  = htmlobj.responseXML.getElementsByTagName("texDes");
   operationDes=document.getElementById('txtComOpert').value;
	
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblCombination\"  class=\"thetable\">"+
                                "<tr>"+
                                  "<th>Serial</th>"+
                                  "<th>Color</th>"+
                                  "<th>Stitch Type</th>"+
                                  "<th>Thread Type</th>"+
                                  "<th>Tex</th>"+
                                  "<th>Machine Id</th>"+
                                  "<th>Operation</th>"+
								  "<th style=\"display:none\">status</th>"+
								  "</tr>";
								
												 	   

			 for ( var loop = 0; loop < XMLstitch.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				serial=loop+1;
				
				tableText +=" <tr class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + serial + "\" > "+ serial +"</td>"+

							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLcolor[loop].childNodes[0].nodeValue + "\" > "+ XMLColorCombo[0].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLstitch[loop].childNodes[0].nodeValue + "\" > "+ XMLstitchDes[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLthread[loop].childNodes[0].nodeValue + "\" > "+ XMLThreadCombo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLtex[loop].childNodes[0].nodeValue + "\" > "+ XMLTexCombo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + mID + "\" > "+ mID +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + opCode + "\" > "+ operationDesc +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + 1 + "\" style=\"display:none\"> "+ 1 +"</td>"+
							" </tr>";
							
							

			 }
			tableText += "</table>";
			alert(tableText);
			
			document.getElementById('divconsCombi').innerHTML=tableText;  */
			
			
}
//---------------------------------------------------
function CloseWindow(){
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
	
	
}
//---combination onload function-------------------
function assignLength()
	{
		var stitchID=document.getElementById('cboStitType').value;
	
	var url="xml.php";
	url=url+"?RequestType=assignLength";
	url += '&stitchID='+stitchID;

	var htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText); 
	
	 var XMLLength = htmlobj.responseXML.getElementsByTagName("stLength");
	 document.getElementById('txtCombStLength').value = XMLLength[0].childNodes[0].nodeValue;
	 
	}
//-------------------------------------------------------------------------------------------
function addRow()
{
	if(validateFormCombination())
	{	
	var path="xml.php?RequestType=getSerial";
	
	htmlobj=$.ajax({url:path,async:false});
	
	//alert(htmlobj.responseText); 
	var XMLSerial   = htmlobj.responseXML.getElementsByTagName("serial");
	
	//-------------------
 var tbl = document.getElementById('tblCombination');   //*****************************************************************
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  
  var cell0 = row.insertCell(0);
  var textNode = document.createTextNode(lastRow);
  cell0.appendChild(textNode);
  
  var SelectOption=document.getElementById('cboColor');
  var SelectedIndex=SelectOption.selectedIndex;
  var SelectedValue=SelectOption.value;
  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
  var cell1 = row.insertCell(1);
  var textNode = document.createTextNode(SelectedText);
  cell1.appendChild(textNode);
  
  var SelectOption=document.getElementById('cboStitType');
  var SelectedIndex=SelectOption.selectedIndex;
  var SelectedValue=SelectOption.value;
  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
  var text=SelectedText.split(":")
  
  
  var cell2 = row.insertCell(2);
  var textNode = document.createTextNode(text[0]);
  cell2.appendChild(textNode);

  var cell3 = row.insertCell(3);
  var textNode = document.createTextNode(text[1]);
  cell3.appendChild(textNode);
  
  var SelectOption=document.getElementById('cboThread');
  var SelectedIndex=SelectOption.selectedIndex;
  var SelectedValue=SelectOption.value;
  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
  var cell4 = row.insertCell(4);
  var textNode = document.createTextNode(SelectedText);
  cell4.appendChild(textNode);
  
  var SelectOption=document.getElementById('cboTex');
  var SelectedIndex=SelectOption.selectedIndex;
  var SelectedValue=SelectOption.value;
  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
  var cell5 = row.insertCell(5);
  var textNode = document.createTextNode(SelectedText);
  cell5.appendChild(textNode);

  var cell6 = row.insertCell(6);
  var textNode = document.createTextNode(document.getElementById('txtCombMac').value);
  cell6.appendChild(textNode);

  var cell7 = row.insertCell(7);
  var textNode = document.createTextNode(document.getElementById('txtComOpert').value);
  cell7.appendChild(textNode);

  var cell8 = row.insertCell(8);
 // var textNode = document.createTextNode(parseFloat(document.getElementById('txtCombStLength').value)+parseFloat(document.getElementById('txtCombLen').value));
  var textNode = document.createTextNode(parseFloat(document.getElementById('txtCombStLength').value));
  cell8.appendChild(textNode);
  
  var cell9 = row.insertCell(9);
  var textNode = document.createTextNode(document.getElementById('cboStitType').value);
  cell9.appendChild(textNode);
  
  var cell10 = row.insertCell(10);
  var textNode = document.createTextNode(document.getElementById('cboTex').value);
  cell10.appendChild(textNode);

  var cell11 = row.insertCell(11);
  var textNode = document.createTextNode(document.getElementById('cboThread').value);
  cell11.appendChild(textNode);

  var cell12 = row.insertCell(12);
  var textNode = document.createTextNode(document.getElementById('cboColor').value);
  cell12.appendChild(textNode);

  var cell13 = row.insertCell(13);
  var textNode = document.createTextNode(0);
  cell13.appendChild(textNode);
  
  //display none
  var rows = tbl.getElementsByTagName('tr');
	for (var ce=9; ce<14; ce++) {
		  var cels = rows[iteration].getElementsByTagName('td')
		  cels[ce].style.display='none';
		}
		
//total length		
	/*	var tbl = document.getElementById('tblCombination');
		noOfRows=tbl.rows.length-1;
		var length=0;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			length += parseFloat(tbl.rows[loop].cells[8].innerHTML);
		}
	  document.getElementById('txtTotLen').value=length;*/
	  
	  document.getElementById('txtTotLen').value=parseFloat(document.getElementById('txtTotLen').value)+parseFloat(document.getElementById('txtCombStLength').value);
	  document.getElementById('txtCombLen').value=parseFloat(document.getElementById('txtCombLen').value)+parseFloat(document.getElementById('txtCombStLength').value);
	  
	}
	
		document.getElementById('cboStitType').value="";
		document.getElementById('cboTex').value="";
		document.getElementById('cboThread').value="";
		document.getElementById('cboColor').value="";
	
}
//---------------------------------*********************************************************************************************************************************************************************************************************************************
function saveCombinations()
{
//	if(validateCombinationForSave())
//	{	
		//showBackGroundBalck();
	
		var tbl = document.getElementById('tblCombination');
		noOfRows=tbl.rows.length-1;
		
		var ArrayLength ="";
		var ArrayStitch ="";
		var ArrayTex ="";
		var ArrayThread ="";
		var ArrayColor ="";
		var ArrayMFactor ="";
		var ArrayWast = "";
		var ArrayLengthInches = "";
		var ArrayHeaderLength = "";
		var HeadWast = document.getElementById('txtWastage').value;
		var lengthDetail = document.getElementById('txtCombLen').value;

		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var style =  URLEncode(document.getElementById('txtCombStyleID').value);
				var mId	  =  URLEncode(document.getElementById('cboMachine2').value);
				var opID = document.getElementById('txtComOpertID').value;
				var machineId = document.getElementById('txtCombMac').value;
				var stitchRatio = "";//document.getElementById('cboStitchRatio').value;
				var serial = document.getElementById('txtSerial').value;
				var totLength = document.getElementById('txtCombLen').value;

				var length = URLEncode(tbl.rows[loop].cells[7].innerHTML);  // meteres
				var stitch = URLEncode(tbl.rows[loop].cells[2].id);
				//var tex = document.getElementById('texID'+loop).value;
				var thread = document.getElementById('threadID'+loop).value;
				var color = document.getElementById('color'+loop).value;
				color = jQuery.trim(color);
				//col = URLEncode(col);
				//alert(color);
				//var color = URLEncode(document.getElementById('color'+loop).value);
				//alert(color);
				var machineFactor = tbl.rows[loop].cells[7].id; 
				//alert(machineFactor);
				var wast = document.getElementById('txtWastage').value;
				var lengthInInch = tbl.rows[loop].cells[6].id;  // inches(inchesLength * factor)
				var headerLength = document.getElementById('txtCombLen').value;
				
				//alert(lengthInInch); 
				//alert(machineFactor);
				//alert(wast);				
				//var color='Xaxx';
				ArrayLength += length + ",";
				ArrayStitch += stitch + ",";
				ArrayTex += ",";
				ArrayThread += thread+ ",";
				ArrayColor += URLEncode(color.trim()) + ",";
				ArrayMFactor += machineFactor + ",";
				ArrayWast += wast + ",";
				ArrayLengthInches += lengthInInch + ",";   // inches(inchesLength * factor)
				ArrayHeaderLength += headerLength + ",";
				
		}
	
	path="";
	path="xml.php?RequestType=SaveCombinations&style="+style+"&mId="+mId+"&opID="+opID+"&serial="+serial+"&totLength="+totLength+"&machineId="+machineId+"&ArrayLength="+ArrayLength+"&ArrayMFactor="+ArrayMFactor+"&stitchRatio="+stitchRatio+"&ArrayStitch="+ArrayStitch+"&ArrayThread="+ArrayThread+"&ArrayTex="+ArrayTex+"&ArrayColor="+ArrayColor+"&ArrayWast="+ArrayWast+"&ArrayLengthInches="+ArrayLengthInches+"&ArrayHeaderLength="+ArrayHeaderLength+"&HeadWast="+HeadWast+"&lengthDetail="+lengthDetail;	
	
	htmlobj=$.ajax({url:path,async:false});
	
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Saved successfully.");

			}
			else if(XMLResult[0].childNodes[0].nodeValue == "False")
			{
				alert("Updated successfully.");
			}
	CloseWindow();		
	loadGrid(style);		
//	}
}
//-------------------------------------------------------------------------------------------
function validateFormCombination()
{
		var tbl = document.getElementById('tblCombination');
		var stitch=document.getElementById('cboStitType').value;
		var tex=document.getElementById('cboTex').value;;
		var tread=document.getElementById('cboThread').value;;
		var color=URLEncode(document.getElementById('cboColor').value);
		var existRow=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var gridStitch=tbl.rows[loop].cells[9].innerHTML.trim();
				var gridTex=tbl.rows[loop].cells[10].innerHTML.trim();
				var gridTread=tbl.rows[loop].cells[11].innerHTML.trim();
				var gridColor=URLEncode(tbl.rows[loop].cells[12].innerHTML.trim());
				
				if((stitch==gridStitch) && (tex==gridTex) && (tread==gridTread) && (color==gridColor)){
					existRow=1;
				}
		}

//
	if (document.getElementById('cboStitType').value == "" )	
	{
		alert("Please select a \"Stitch Type\" ");
		document.getElementById('cboStitType').focus();
		return false;
	}
	else if (document.getElementById('cboTex').value == "" )	
	{
		alert("Please select a \"Tex\" ");
		document.getElementById('cboTex').focus();
		return false;
	}
	else if (document.getElementById('cboThread').value == "" )	
	{
		alert("Please select a \"Thread\" ");
		document.getElementById('cboThread').focus();
		return false;
	}
	else if (document.getElementById('cboColor').value == "" )	
	{
		alert("Please select a \"Color\" ");
		document.getElementById('cboColor').focus();
		return false;
	}
	else if(existRow==1){
		alert("This combination is already exists!");
		return false;
	}
	else
	return true;
	
}
//-----------------------------------------------------------
function validateCombinationForSave(){
		var tbl = document.getElementById('tblCombination');
		noOfRows=tbl.rows.length-1;
		
		var exit=1;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				exit *= parseFloat(tbl.rows[loop].cells[13].innerHTML);
		}
		
		if(noOfRows<1){
		return false;	
		}
		if(exit==1){
		var tbl = document.getElementById('tblThreadCons');
		var rowNum=parseFloat(document.getElementById('txtPrevRow').value)+1;
		tbl.rows[rowNum].cells[5].childNodes[0].value=parseFloat(document.getElementById('txtTotLen').value);
		alert("These combinations already exists.");
		return false;	
		}
		else{
		return true;	
		}
		
		
	
}
//-----------------------------------------------------
function ViewThreadReport()
{ 
	    var styleID=document.getElementById('cboStyle').value;
		var cboStyles=document.getElementById('cboStyles').value;
		var order =document.getElementById('cboStyle').options[document.getElementById('cboStyle').selectedIndex].text;
		
		window.open("thread_consumptionReport.php?styleNo="+styleID+"&cboStyles="+cboStyles+"&order="+order,'frmthread'); 
}

//---------------------------------------------------
function prompter() {
var name = prompt("Enter the Ratoi Name", "");
if(name==null){
	return false;
}
	var path = "xml.php?RequestType=saveRatioName&name="+name;			

	htmlobj = $.ajax( { url :path, async :false });
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
			//	alert("Saved successfully.");
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "False"){
				alert("Save failed.");
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "exist"){
				alert("Already exists.");
			}
			var url = "SELECT DISTINCT(id), strName FROM ws_rationames ORDER BY id ASC";
			loadCombo(url,'cboStitchName');			
}
//-------------------------------------------------------------------------------------------
function addRowToStitchRatio()
{
	if(validateFormStitchRatio())
	{	
//	var path="xml.php?RequestType=getStitchRatioNo";
//	htmlobj=$.ajax({url:path,async:false});
//	var XMLSerial   = htmlobj.responseXML.getElementsByTagName("serial");
	
	//-------------------
  var tbl = document.getElementById('tblStitchRatio');
  var lastRow = tbl.rows.length;
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  
  var cell0 = row.insertCell(0);
  var textNode = document.createTextNode(SelectedText);
  cell0.appendChild(textNode);			  
  cell0.innerHTML="<img src=\"../../images/del.png\"  onClick=\"deleteStitchRatio(this.parentNode.parentNode.rowIndex);\">";
  cell0.class="normalfntMid";
  cell0.id=0;
  
  var cell1 = row.insertCell(1);
  var textNode = document.createTextNode(lastRow);
  cell1.appendChild(textNode);
  cell1.id=document.getElementById('cboMachineType').value;
  
  var SelectOption=document.getElementById('cboStitType');
  var SelectedIndex=SelectOption.selectedIndex;
  var SelectedValue=SelectOption.value;
  var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
  var cell2 = row.insertCell(2);
  var textNode = document.createTextNode(SelectedText);
  cell2.appendChild(textNode);
  cell2.id=document.getElementById('cboStitType').value;
  
  var cell3 = row.insertCell(3);
 var SelectedText = "<input type=\"text\" id=\"" + lastRow + "\" name=\"" + lastRow + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\"  value=\"\">";
 cell3.innerHTML=SelectedText;
 //removed onkeyup=\" getTotQty(this.parentNode.parentNode.rowIndex);\"  by sumith harshan 2011-05-10
 
  cell3.id=document.getElementById('cboStitchName').value;
	}
	
		document.getElementById('cboStitType').value="";
	
}
//-------------------------------------------------------------------------------------------
function validateFormStitchRatio()
{
		var tbl = document.getElementById('tblStitchRatio');
		var machine=document.getElementById('cboMachine').value;
		var stitchName=document.getElementById('cboStitchName').value;;
		var stitchType=document.getElementById('cboStitType').value;;
		var existRow=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{	
				var exstingRatioNameID=tbl.rows[loop].cells[3].id;
				var gridStitchType=tbl.rows[loop].cells[2].id;
				
				if(stitchType==gridStitchType){
					existRow=1;
				}
		}

	if (machine == "" )	
	{
		alert("Please select a \"Machine\" ");
		document.getElementById('cboMachine').focus();
		return false;
	}
	else if (stitchName == "" )	
	{
		alert("Please select a \"Stitch Name\" ");
		document.getElementById('cboStitchName').focus();
		return false;
	}
	else if (stitchType == "" )	
	{
		alert("Please select a \"Stitch Type\" ");
		document.getElementById('cboStitType').focus();
		return false;
	}
	else if ((tbl.rows.length>1) && (stitchName != exstingRatioNameID ))	
	{
		for ( var loop = 1 ;loop < tbl.rows.length+1 ; loop ++ )
		{

		tbl.deleteRow(1);		
		}
		return true;
	}
	else if (existRow == 1 )	
	{
		alert("This \"Stitch Type\" is already exists. ");
		return false;
	}
	else
	return true;
	
}
//--------------------------------------------------------------------------------------------
function deleteStitchRatio(rowId) //,styleNo 
{
	var tbl = document.getElementById('tblStitchRatio');
	if(confirm("Are you sure, you want to remove this record?")) 
	{
		if(tbl.rows[rowId].cells[0].id!=0){
		var path = "xml.php?RequestType=removeStitchRatio&id=" + tbl.rows[rowId].cells[0].id;  
		htmlobj = $.ajax( { url :path, async :false });
		var XMLResult = htmlobj.responseXML.getElementsByTagName("DeleteDetail");	 	 
	 	var feedBack = XMLResult[0].childNodes[0].nodeValue; 			 
		}
		
    	document.getElementById('tblStitchRatio').deleteRow(rowId)
	}
}
//------------------------------------------------------------------
function getTotQty(rowId)
{
	totOutputQty=0;
	var tbl = document.getElementById('tblStitchRatio');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[3].childNodes[0].value != ""){
		    totOutputQty += parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
			}
		}
		
		if(totOutputQty>100){
			var maxRemainVal=100-totOutputQty+parseFloat(tbl.rows[rowId].cells[3].childNodes[0].value);
			alert("Exeed 100%");
			tbl.rows[rowId].cells[3].childNodes[0].value=maxRemainVal;
			return false;
		}
	
}
//-------------------------------------------------------------------------------------------
function saveMachineStitchRatios()
{
	if(validateMachineStitchRatiosForSave())
	{	
	
		var tbl = document.getElementById('tblStitchRatio');
		noOfRows=tbl.rows.length-1;
		
		var ArrayMachine ="";
		var ArrayStitchRatio ="";
		var ArrayStitchType ="";
		var ArrayRatio ="";
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
				var machineTypeID = URLEncode(tbl.rows[loop].cells[1].id);
				var stitchRatio = URLEncode(tbl.rows[loop].cells[3].id);
				var stitchType = URLEncode(tbl.rows[loop].cells[2].id);
				var ratio = URLEncode(tbl.rows[loop].cells[3].childNodes[0].value);
				
				//var color='Xaxx';
				ArrayMachine += machineTypeID + ",";
				ArrayStitchRatio += stitchRatio + ",";
				ArrayStitchType += stitchType + ",";
				ArrayRatio += ratio+ ",";
		}
	
	path="";
	path="xml.php?RequestType=saveMachineStitchRatios&ArrayMachine="+ArrayMachine+"&ArrayStitchRatio="+ArrayStitchRatio+"&ArrayStitchType="+ArrayStitchType+"&ArrayRatio="+ArrayRatio;	
	
	htmlobj=$.ajax({url:path,async:false});
	
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Saved successfully.");
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "False"){
				alert("Save failed.");
			}
			if(XMLResult[0].childNodes[0].nodeValue == "UpdateTrue")
			{
				alert("Updated successfully.");
				//clearForm()
			}
			else if(XMLResult[0].childNodes[0].nodeValue == "UpdateFalse"){
				alert("Update failed.");
			}
			
	}
}
//-----------------------------------------------------------
function validateMachineStitchRatiosForSave(){
		var tbl = document.getElementById('tblStitchRatio');
		noOfRows=tbl.rows.length-1;
		
		var exit=1;
		var total=0;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{		if(tbl.rows[loop].cells[3].childNodes[0].value!=""){
				total = total+parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
				}
		}
		
		if(noOfRows<1){
		alert("No records to save.");
		return false;	
		}
		
		// commented by sumith 2011-05-10
		/*else if(total<100){
		alert("Ratio total must equal to 100%.");
		return false;	
		}*/
		else{
		return true;	
		}
		
		
	
}
//-----------------------------------------------------
function loadStitchRatioGrid(){
	
   machineID=document.getElementById('cboMachineType').value;
   stitchRatio=document.getElementById('cboStitchName').value;
	
	var path="xml.php?RequestType=loadStitchRatioGrid&machineID="+machineID+"&stitchRatio="+stitchRatio;
	htmlobj=$.ajax({url:path,async:false});

	var XMLid  = htmlobj.responseXML.getElementsByTagName("id");
	var XMLmachineTypeID  = htmlobj.responseXML.getElementsByTagName("machineID");
	var XMLStichRatName  = htmlobj.responseXML.getElementsByTagName("StichRatName");
	var XMLStichRatNameID  = htmlobj.responseXML.getElementsByTagName("StichRatNameID");
	var XMLStitchType  = htmlobj.responseXML.getElementsByTagName("StitchType");
	var XMLStitchTypeID  = htmlobj.responseXML.getElementsByTagName("StitchTypeID");
	var XMLRatio   = htmlobj.responseXML.getElementsByTagName("Ratio");
	
			var tableText = "<table style=\"width:540px\" class=\"thetable\" border=\"1\" cellspacing=\"1\" id=\"tblStitchRatio\">"+
						"<caption>Stitch Types</caption>"+
                                "<tr>"+
                                  "<th>Del</th>"+
                                  "<th>No</th>"+
                                  "<th>Stitch Type</th>"+
                                  "<th>Ratio</th>"+
								  "</tr>";
								
			 for ( var loop = 0; loop < XMLmachineTypeID.length; loop ++)
			 {
				var serial=loop+1;
				
				tableText +=" <tr>" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLid[loop].childNodes[0].nodeValue + "\" > <img src=\"../../images/del.png\"  onClick=\"deleteStitchRatio(this.parentNode.parentNode.rowIndex);\"></td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLmachineTypeID[loop].childNodes[0].nodeValue + "\" > "+ serial +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLStitchTypeID[loop].childNodes[0].nodeValue + "\" > "+ XMLStitchType[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLStichRatNameID[loop].childNodes[0].nodeValue + "\" ><input type=\"text\" id=\"this.parentNode.parentNode.rowIndex\" name=\"this.parentNode.parentNode.rowIndex\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\"  value=\"" + XMLRatio[loop].childNodes[0].nodeValue + "\"></td>"+
							" </tr>";
 // removed onkeyup=\" getTotQty(this.parentNode.parentNode.rowIndex);\" by sumith harshan 2011-05-10			 
			 }
			tableText += "</table>";
			
			document.getElementById('divStitchRatio').innerHTML=tableText;  
			
}
//----------------------------------------------------------------------------
function clearStitchRatioForm(){
	//document.frmWashReceive.reset();
	
	document.getElementById('cboMachineType').value='';
	document.getElementById('cboStitchName').value='';
	document.getElementById('cboStitType').value='';
	
			var tableText = "<table style=\"width:540px\" class=\"thetable\" border=\"1\" cellspacing=\"1\" id=\"tblStitchRatio\">"+
						"<caption>Stitch Types</caption>"+
                                "<tr>"+
                                  "<th>Del</th>"+
                                  "<th>No</th>"+
                                  "<th>Stitch Type</th>"+
                                  "<th>Ratio</th>"+
								  "</tr></table>";
	//alert(tableText);
			document.getElementById('divStitchRatio').innerHTML=tableText;  
			document.getElementById('cboMachineType').focus();
}
//-------------------------------------------------------------------------------
function loadMachineTypes(value){
	loadCombo('SELECT intMachineTypeId ,strMachineName FROM ws_machinetypes WHERE intMachineId='+value+' ORDER BY strMachineName ASC','cboMachineType');
}

function clearGrid(){
	document.getElementById('cboStitchName').value='';
	document.getElementById('cboStitType').value='';
	
			var tableText = "<table style=\"width:540px\" class=\"thetable\" border=\"1\" cellspacing=\"1\" id=\"tblStitchRatio\">"+
						"<caption>Stitch Types</caption>"+
                                "<tr>"+
                                  "<th>Del</th>"+
                                  "<th>No</th>"+
                                  "<th>Stitch Type</th>"+
                                  "<th>Ratio</th>"+
								  "</tr></table>";
	//alert(tableText);
			document.getElementById('divStitchRatio').innerHTML=tableText;  
			document.getElementById('cboMachineType').focus();
}



function calculateLength(obj)
{
		var totalLength = parseFloat(obj.id);
		var wast	 = parseFloat(obj.value);
		if(wast=='')
			wast = 0;
		var ratio 	=	parseFloat(obj.parentNode.id);
		
		var	actualLength = (totalLength * ratio)* ((100+wast)/100)/39;   // meters
		var actualLengthInches = actualLength *39;  // inches
//alert(actualLengthInches);
		var lengthInches = actualLengthInches * ratio;
		//alert(lengthInches);	
		obj.parentNode.parentNode.cells[7].id = Math.round(lengthInches*100,2)/100; 
		//alert(obj.parentNode.parentNode.cells[8].id);
		// round
		obj.parentNode.parentNode.cells[7].childNodes[0].nodeValue = Math.round(actualLength*100,2)/100; 
		//calculateLengthInches();
//		obj.parentNode.parentNode.id  
}

/*function calculateLengthInches()
{
var tblCombination = document.getElementById('tblCombination').tBodies[0];

var wastValue = tblCombination.rows[d].cells[8].value;
	alert(wastValue);

/*		var actualLengthInches = actualLength *39;  // inches
//alert(actualLengthInches);
		var lengthInches = actualLengthInches * ratio;
		//alert(lengthInches);	
		obj.parentNode.parentNode.cells[8].id = Math.round(lengthInches*100,2)/100; */
		//alert(obj.parentNode.parentNode.cells[8].id);
		
function chechWast(obj,loop1)
{
	if(document.getElementById('txtWastage').value=="")
	{
		alert("Please enter the wastage");
	}
	else
	{
		loadCombinations(obj,loop1);
	}
}

function addColor(obj)
{
	var styleid = document.getElementById('cboStyle').value;
	var grid    = document.getElementById('tblCombination');
	
	var colorname = prompt("Enter the Color Name", "");
	if(colorname==null)
	{
		return false;
	}
	
	var path = "xml.php?RequestType=saveColor&colorname="+colorname+"&styleid="+styleid;			

	htmlobj = $.ajax( { url :path, async :false });
	var XMLResult = htmlobj.responseText;
	
	
	if(XMLResult!="")
	{
		alert("Color successfully saved !");
		
		for(var x=1;x<grid.rows.length;x++)
		{
			var optn = document.createElement("OPTION");
			optn.text  = XMLResult;
			optn.value = XMLResult;
			
			if(obj.parentNode.parentNode.rowIndex==x)
			{
				optn.selected = "selected";
				grid.rows[x].cells[1].childNodes[0].options.add(optn);
				optn = null;
			}
			else
			{
				grid.rows[x].cells[1].childNodes[0].options.add(optn);
				optn = null;
			}
		}
	}
		
	else
		alert("Color already exist !");
}