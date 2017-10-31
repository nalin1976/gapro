//wasreturntofactory.js
//13-05-2011
var pub_washDet=0;
function selectPOStyles(obj,cbo){
	document.getElementById(cbo).value=obj.value;
}

function loadDets(obj){
	var gp=obj.value.trim();
	var gpNo=gp.split('/')[1];
	var gpYear=gp.split('/')[0];
	var path="wasreturnToFactory_xml.php?req=getDet&gpNo="+gpNo+"&gpYear="+gpYear;
	htmlobj=$.ajax({url:path,async:false});
	
	var XMLToFactory = htmlobj.responseXML.getElementsByTagName('ToFac');
	var XMLStyleId=htmlobj.responseXML.getElementsByTagName('StyleId');
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName('OrderNo');
	var XMLStyle = htmlobj.responseXML.getElementsByTagName('Style');
	var XMLOderQty = htmlobj.responseXML.getElementsByTagName('OrderQty');
	
	document.getElementById('cboToFactory').value=XMLToFactory[0].childNodes[0].nodeValue;
	$('#cboPoNo').html("<option value=\""+ XMLStyleId[0].childNodes[0].nodeValue +"\">"+ XMLOrderNo[0].childNodes[0].nodeValue +"</option>");
	$('#cboStyle').html("<option value=\""+ XMLStyleId[0].childNodes[0].nodeValue +"\">"+ XMLStyle[0].childNodes[0].nodeValue +"</option>");
	document.getElementById('txtOrderQty').value=XMLOderQty[0].childNodes[0].nodeValue;
	

	var XMLCutNo	=	htmlobj.responseXML.getElementsByTagName('CutNo');
	var XMLShade	=	htmlobj.responseXML.getElementsByTagName('Shade');	
	var XMLsCutNo	=	htmlobj.responseXML.getElementsByTagName('sCutNo');	
	
	var tbl=document.getElementById('tblCutNos').tBodies[0];
	var tableText="";
	for(var i=0;i < XMLCutNo.length; i++){
	
		if((i%2)==0){
			var rowClass="grid_raw"	
		}
		else{
			var rowClass="grid_raw2"	
		}
		 tableText +=" <tr class='"+rowClass+"'>" +
		 			" <td class=\"normalfntMid\" align=\"center\">"+ XMLCutNo[i].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\"><input type=\"checkbox\" checked=\"checked\" onclick=\"checkMainGrid(this,'tblCutNos');\"/></td>"+					
					"</tr>";
	}
	tbl.innerHTML=tableText;
	document.getElementById('chkAllShades').checked="checked";
	var tbl=document.getElementById('tblShades').tBodies[0];
	var tableText="";
	for(var i=0;i < XMLShade.length; i++){
	
		if((i%2)==0){
			var rowClass="grid_raw"	
		}
		else{
			var rowClass="grid_raw2"	
		}
		 tableText +=" <tr class='"+rowClass+"'>" +
		 			" <td class=\"normalfntMid\" align=\"center\" id=\""+XMLsCutNo[i].childNodes[0].nodeValue+"\">"+ XMLShade[i].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\"><input type=\"checkbox\" checked=\"checked\" onclick=\"checkMainGrid(this,'tblShades');\"/></td>"+					
					"</tr>";
	}
	//alert(tableText)
	tbl.innerHTML=tableText;
	document.getElementById('chkAllCuts').checked="checked";
	loadColor(document.getElementById('cboPoNo'));
	
}
function loadColor(obj){
	var path="wasreturnToFactory_xml.php?req=getColor&pono="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var color		=	htmlobj.responseXML.getElementsByTagName('color');
	var OrderQty	=	htmlobj.responseXML.getElementsByTagName('OrderQty');
	$('#cboColor').html("<option value=\""+ color[0].childNodes[0].nodeValue +"\"></option><option>"+ color[0].childNodes[0].nodeValue +"</option>");
	document.getElementById('txtOrderQty').value=OrderQty[0].childNodes[0].nodeValue;
	document.getElementById('cboColor').selectedIndex=1;
	loadGrid(obj.value,color[0].childNodes[0].nodeValue,'','');
	//loadGrid(obj.value,color[0].childNodes[0].nodeValue);
	document.getElementById('chkAllSecond').checked=true;
	//document.getElementById('chkAllSecond').onclick();
	checkAllTblSecond(document.getElementById('chkAllSecond'));
}

function loadTransinNos(){
		
}
function loadGrid(po,color,transInNo,transInYear){   
	var gp=document.getElementById('cboGPNo').value.trim();
	var path="wasreturnToFactory_xml.php?req=loadDets&pono="+po+"&color="+color+"&gpNo="+gp.split('/')[1]+"&gpYear="+gp.split('/')[0] +"&transInNo="+transInNo+"&transInYear="+transInYear;
	htmlobj=$.ajax({url:path,async:false});
	var XMLCutNo=htmlobj.responseXML.getElementsByTagName('cutno');
	var XMLSize=htmlobj.responseXML.getElementsByTagName('size');
	var XMLBundleNo=htmlobj.responseXML.getElementsByTagName('BundleNo');
	var XMLCutBundleSerial=htmlobj.responseXML.getElementsByTagName('CutBundleSerial');
	var XMLRange=htmlobj.responseXML.getElementsByTagName('range');
	var XMLShade=htmlobj.responseXML.getElementsByTagName('Shade');
	var XMLBalQty=htmlobj.responseXML.getElementsByTagName('bal');
	var XMLRemarks=htmlobj.responseXML.getElementsByTagName('strRemarks');
	var XMLTransNo=htmlobj.responseXML.getElementsByTagName('TransNo');
	var XMLTransYear=htmlobj.responseXML.getElementsByTagName('TransYear');
	
	var tbl=document.getElementById('tblSecond').tBodies[0];
	var tableText="";
	for(var i=0;i < XMLCutNo.length; i++){
		if((i%2)==0){
			var rowClass="grid_raw"	
		}
		else{
			var rowClass="grid_raw2"	
		}
		if(XMLBalQty[i].childNodes[0].nodeValue!=0){
		 tableText +=" <tr class='"+rowClass+"'>" +
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLTransYear[i].childNodes[0].nodeValue+'/'+XMLTransNo[i].childNodes[0].nodeValue + "\" > "+ XMLCutNo[i].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[i].childNodes[0].nodeValue + "\" > "+ XMLSize[i].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"right\" id=\""+XMLCutBundleSerial[i].childNodes[0].nodeValue+"\">"+XMLBundleNo[i].childNodes[0].nodeValue+"</td>" +
		 			" <td class=\"normalfntMid\" align=\"right\">"+XMLRange[i].childNodes[0].nodeValue+"</td>" +
					" <td class=\"normalfntMid\" align=\"right\">"+XMLShade[i].childNodes[0].nodeValue+"</td>" +
					" <td class=\"normalfntMid\" align=\"right\">"+ XMLBalQty[i].childNodes[0].nodeValue+"</td>" +
					" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\"  id=\"" + i + "\" name=\"" + i + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLBalQty[i].childNodes[0].nodeValue+"\" onkeypress=\"return isNumberKey(event);\" onkeyup=\" compQty(this);getTotQty();\"> " +
							"</input></td>" +
					
					" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /></td>" +
					" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\" class=\"txtbox\" style=\"text-align:left\" size=\"10px\" align =\"right\" /></td>" +
					"</tr>";
		}
	}
	//alert(tableText)
	tbl.innerHTML=tableText;

}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblSecond');
	var rw = objevent.parentNode.parentNode;
	
	if (rw.cells[7].childNodes[0].checked)
	{
		rw.cells[6].childNodes[0].value =rw.cells[5].innerHTML;
		rw.cells[6].childNodes[0].focus();
	}
	else
	{
		rw.cells[6].childNodes[0].value = 0;
		rw.cells[6].childNodes[0].focus();
	}

var chk=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[7].childNodes[0].checked == true)
			chk++;
		}
		if(chk==tbl.rows.length-1){
		document.getElementById('chkAllSecond').checked=true;	
		}
		else{
		document.getElementById('chkAllSecond').checked=false;	
		}
getTotQty();

}

function compQty(obj){
	var val1=obj.value;
	var val2=obj.parentNode.parentNode.cells[5].innerHTML;
	if(Number(val1) > Number(val2)){
		obj.value=val2;
	}
}

function checkAllTblSecond(obj)
{
	var tbl = document.getElementById('tblSecond');
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[7].childNodes[0].checked = true;
			tbl.rows[loop].cells[6].childNodes[0].value =tbl.rows[loop].cells[5].innerHTML;
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[6].childNodes[0].value = 0;
			tbl.rows[loop].cells[7].childNodes[0].checked = false;
			// tbl.rows[loop].cells[10].childNodes[0].value = 0;
		}
	}
			getTotQty();
}

function getTotQty()
{
	totOutputQty=0;
	var tbl = document.getElementById('tblSecond');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		//	if(tbl.rows[loop].cells[7].childNodes[0].checked == true){
		    totOutputQty += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
		//	}
		}
	document.getElementById('txtTotGpQty').value= totOutputQty;  
}

function SavePData(){
	showBackGround('divBG',0);
	var po=document.getElementById('cboPoNo').value.trim();
	var color=document.getElementById('cboColor').value.trim();
	var fFac=document.getElementById('cboFactory').value.trim();
	var tFac=document.getElementById('cboToFactory').value.trim();
	var gp=document.getElementById('cboGPNo').value.trim();
	var remarks	= document.getElementById('txtRemarks').value.trim();
   	if(gp==""){
		alert("Please select 'GatePass Number'.");	
		document.getElementById('cboGPNo').focus();
		hideBackGround('divBG');
		return false;
	}
	
	if(fFac==""){
		alert("Please select 'From Factory'.");	
		document.getElementById('cboFactory').focus();
		hideBackGround('divBG');
		return false;
	}
	
	if(tFac==""){
		alert("Please select 'To Factory'.");	
		document.getElementById('cboToFactory').focus();
		hideBackGround('divBG');
		return false;
	}
	
	if(po==""){
		alert("Please select 'PO number'.");	
		document.getElementById('cboPoNo').focus();
		hideBackGround('divBG');
		return false;
	}
	
	if(color==""){
		alert("Please select 'Color'.");	
		document.getElementById('cboColor').focus();
		hideBackGround('divBG');
		return false;
	}
	
	var path="wasreturnToFactory_db.php?req=chkAvl&po="+po+"&color="+color+"&qty="+document.getElementById('txtTotGpQty').value.trim()+"&tFac="+tFac;
	htmlobj=$.ajax({url:path,async:false});
	if(htmlobj.responseText==0){
		alert('Not Available')	;
		hideBackGround('divBG');
		return false;
	}
	else{
		var path1="wasreturnToFactory_db.php?req=saveHeader&fFac="+fFac+"&tFac="+tFac+"&po="+po+"&color="+color+"&qty="+document.getElementById('txtTotGpQty').value.trim()+"&gpNo="+gp.split('/')[1]+"&gpYear="+gp.split('/')[0]+ "&Remarks="+URLEncode(remarks);	
		htmlobj1=$.ajax({url:path1,async:false}); 
		var res=htmlobj1.responseText.split('~');
		document.getElementById('txtSerial').value=res[1];
		var res2=res[1].split("/");
		if(res[0]==1){
			var tbl = document.getElementById('tblSecond');
			var clength=0;
			for(var i=1;i<tbl.rows.length;i++){
				if(tbl.rows[i].cells[7].childNodes[0].checked){
				clength++;
				}	
			}
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{

				var cNo=tbl.rows[loop].cells[0].innerHTML;
				var tNo=tbl.rows[loop].cells[0].id;
				var transinNo=tNo.split('/')[1];
				var transinYear=tNo.split('/')[0];
				var size=tbl.rows[loop].cells[1].innerHTML;
				var bundle=tbl.rows[loop].cells[2].innerHTML;
				var bundleSerial=tbl.rows[loop].cells[2].id;
				var range=tbl.rows[loop].cells[3].innerHTML;
				var shade=tbl.rows[loop].cells[4].innerHTML;
				var qty=tbl.rows[loop].cells[6].childNodes[0].value;
				var rm=tbl.rows[loop].cells[8].childNodes[0].value;
				
				if(tbl.rows[loop].cells[7].childNodes[0].checked){
					var path2="wasreturnToFactory_db.php?req=saveDat&serial="+res2[1]+"&year="+res2[0]+"&cNo="+cNo+"&size="+size+"&bundle="+bundle+"&bundleSerial="+bundleSerial+"&range="+range+"&shade="+shade+"&qty="+qty+"&rm="+rm+"&transinNo="+transinNo+"&transinYear="+transinYear+"&gpNo="+gp.split('/')[1]+"&gpYear="+gp.split('/')[0]+"&rFac="+ document.getElementById('cboToFactory').value.trim()+"&loop="+clength;	

					htmlobj2=$.ajax({url:path2,async:false}); 
					
					if(htmlobj2.responseText==1){
						clength--;
						if(clength==0){
							updateWashReady();
							 confirmData();
							alert("Saved successfully.");	
							document.getElementById('butSave').style.display="none";
							hideBackGround('divBG');
							return false;
						}
					}
					else{
						alert('saving fail.');
						hideBackGround('divBG');
						return false;
					}
				}
				
			}
			
			
			//document.getElementById('btnConfirm').style.display="inline";
			
		}
		else{
			alert('Saving error.');
			}
	}
	
}

function checkAll(obj,tbl){
	var tbl=document.getElementById(tbl).tBodies[0]
	if(obj.checked){
		for(var i=0;i<tbl.rows.length;i++){
			tbl.rows[i].cells[1].childNodes[0].checked=true;	
		}	
	}
	else{
		for(var i=0;i<tbl.rows.length;i++){
			tbl.rows[i].cells[1].childNodes[0].checked=false;	
			//document.getElementById('tblSecond').tBodies[0].innerHTML="";
		}	
	}
}

function selectAllFields(obj,tbl){
	var tbl=document.getElementById(tbl).tBodies[0];
	var rl=tbl.rows.length;
	if(obj.checked){
		var chk=0;
			for(var i=0;i<rl;i++){
				if(tbl.rows[i].cells[0].childNodes[0].checked){
					chk++;
				}	
			}
			if(chk==rl){
				document.getElementById('chkAll').checked=true;
				loadGrid(document.getElementById('cboPoNo').value,document.getElementById('cboColor').value ,'','');
			}
			else{
				document.getElementById('chkAll').checked=false;
			}
	}
	else{
		document.getElementById('chkAll').checked=false;
		for(var i=0;i<rl;i++){
			var tNo=tbl.rows[i].cells[1].innerHTML;
			if(tbl.rows[i].cells[0].childNodes[0].checked){
				loadGrid(document.getElementById('cboPoNo').value,document.getElementById('cboColor').value ,tNo.split('/')[1],tNo.split('/')[0]);
			}
		}
	}
	
}

function updateWashReady(){
			var po=document.getElementById('cboPoNo').value.trim();
			var tFactory=document.getElementById('cboToFactory').value.trim()
			var Qty=document.getElementById('txtTotGpQty').value.trim();
			var path3="wasreturnToFactory_db.php?req=updateWashReady&po="+po+"&tFac="+tFactory+"&qty="+Qty;	
			htmlobj3=$.ajax({url:path3,async:false});
			var tbl=document.getElementById('tblSecond').tBodies[0];	
			if(htmlobj3.responseText.split('~')[0]==1){
				
				for(var i=0;i<tbl.rows.length;i++){
					if(tbl.rows[i].cells[7].childNodes[0].checked){
						var bundleNo=tbl.rows[i].cells[2].innerHTML;
						var bundleSerial=tbl.rows[i].cells[2].id;
						var qty=tbl.rows[i].cells[6].childNodes[0].value;
						var rm=tbl.rows[i].cells[8].childNodes[0].value;
						var path4="wasreturnToFactory_db.php?req=updateWashReadyDet&serial="+htmlobj3.responseText.split('~')[1]+"&cutBundleSerial="+bundleSerial+"&bundleNo="+bundleNo+"&qty="+qty+"&rm="+rm+"&tFac="+tFactory;	
						htmlobj4=$.ajax({url:path4,async:false});	
						if(htmlobj4.responseText==1){
							//alert("Successfully confirmed.");
							//return false;
						}
					}
				}
			}
	
}

function confirmData(){
	
	//if(confirm("Do you want to comfirm details.")){
		var docNo=document.getElementById('txtSerial').value.split('/')[1];
		var docYear=document.getElementById('txtSerial').value.split('/')[0];
		var po=document.getElementById('cboPoNo').value.trim();
		var color=document.getElementById('cboColor').value.trim();
		var fFac=document.getElementById('cboToFactory').value.trim();
		var qty=document.getElementById('txtTotGpQty').value.trim();
	
		var path="wasreturnToFactory_db.php?req=confirmData&docNo="+docNo+"&docYear="+docYear+"&po="+po+"&color="+color+"&qty="+qty+"&fFac="+fFac;
		htmlobj=$.ajax({url:path,async:false});
		if(htmlobj.responseText==1){
			//alert('Successfully confirmed.');	
			
		}
		
	//}
}

function ClearForm(){
	document.getElementById('frmProductionFinishGoodRecieved').reset();
	document.getElementById('cboColor').innerHTML="<option value=\"\">Select One</option>";
	document.getElementById('tblCutNos').tBodies[0].innerHTML="";
	document.getElementById('tblSecond').tBodies[0].innerHTML="";
	document.getElementById('butSave').style.display="inline";
	document.getElementById('cboPoNo').innerHTML="<option value=\"\">Select One</option>";
}


//////////////////////


function checkMainGrid(obj,tb){
	
	var tblMain=document.getElementById('tblSecond').tBodies[0];
	var tblMainRc=tblMain.rows.length;
	var tbl=document.getElementById(tb).tBodies[0];
	var tblRc=tbl.rows.length;
	var no=obj.parentNode.parentNode.cells[0].innerHTML;
	
	if(obj.checked){		
		if(tb=='tblCutNos'){
			for(var i=0;i<tblMainRc;i++){
				var cN0 = tblMain.rows[i].cells[0].childNodes[0].nodeValue.trim();
				if( cN0 == no.trim()){					
					tblMain.rows[i].cells[7].childNodes[0].checked=true;
					tblMain.rows[i].cells[7].childNodes[0].onclick();	
					//setShades(cN0,1);		
				}	
			}
		}
		
	}
	else{
		if(tb=='tblCutNos'){
			for(var i=0;i<tblMainRc;i++){
				var cN0 = tblMain.rows[i].cells[0].childNodes[0].nodeValue.trim();
				if( cN0 == no.trim()){
					tblMain.rows[i].cells[7].childNodes[0].checked=false;
					tblMain.rows[i].cells[7].childNodes[0].onclick();
					//setShades(cN0,0);
				}	
			}
			document.getElementById('chkAllCuts').checked=false;
		}
	}

}

/*function setShades(cN0,t){
	var tblShades=document.getElementById('tblShades').tBodies[0]; 
	var rc=tblShades.rows.length;
	if(t==0){
		for(var i=0;i<rc;i++){
			var cn=tblShades.rows[i].cells[0].id.trim();
			if(cN0==cn)
				tblShades.rows[i].cells[1].childNodes[0].checked=false;
		}
	}
	else{
		for(var i=0;i<rc;i++){
			var cn=tblShades.rows[i].cells[0].id.trim();
			if(cN0==cn)
				tblShades.rows[i].cells[1].childNodes[0].checked=true;
		}
	}
}*/