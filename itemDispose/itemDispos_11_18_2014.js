// JavaScript Document
var xmlHttp;
var pub_intxmlHttp_count=0;
var rowArray = [];

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

function LoadStyleWiseOrderAndSc(obj)
{
	var path  = "itemDisposeXml.php?";
		path += "req=LoadStyleWiseOrderNo";
		path += "&styleNo="+URLEncode(obj.value);		
	htmlobj=$.ajax({url:path,async:false});	
	document.getElementById('cmbStyle').innerHTML = htmlobj.responseText;
	
	var path  = "itemDisposeXml.php?";
	    path += "req=LoadStyleWiseScNo";
	    path += "&styleNo="+URLEncode(obj.value);		
	htmlobj=$.ajax({url:path,async:false});	
	document.getElementById('cmbSC').innerHTML = htmlobj.responseText;
}
function LoadSC(obj)
{
	document.getElementById('cmbSC').value = obj.value;
	}
	
function LoadStyle(obj)
{
	//alert(obj.value);
	document.getElementById('cmbStyle').value = obj.value;
}
	
function LoadSubCat(obj)
{
	var maincatid = obj.value;
	var url = "SELECT matsubcategory.intSubCatNo, matsubcategory.StrCatName FROM matsubcategory WHERE matsubcategory.intCatNo ="+maincatid;
	loadCombo(url,'cmbSubCat');
}


function loadSubStores(obj)
{
	if(obj.value.trim()=="") return false;
	var path  = "itemDisposeXml.php?req=loadStoreType&mainStore="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLType 	=	htmlobj.responseXML.getElementsByTagName("type");
	document.getElementById('txtMainType').value=XMLType[0].childNodes[0].nodeValue;

	//if(document.getElementById('txtMainType').value==0){
	var mainId = obj.value;
	var url = "SELECT substores.strSubID, substores.strSubStoresName FROM substores WHERE substores.strMainID =  "+mainId;
	loadCombo(url,'cboSubStore');
	//}
	//else{
	//document.getElementById('cmbStyle').value="";	
	//}
	
	
}

function LoadItemData()
{
	/*if(document.getElementById('cmbStyleName').value.trim() == ""){
		alert("Please select 'Style No'.");
		document.getElementById('cmbStyleName').focus();
		return false;
	}*/
	if((document.getElementById('cmbStyle').value.trim() == "") && (document.getElementById('txtMainType').value.trim()==0))
	{
		alert("Please select 'Order No'.");
		document.getElementById('cmbStyle').focus();
		return false;
	}
	if(document.getElementById('cmbStore').value.trim() == "")
	{
		alert("Please select 'Main Store'.");
		document.getElementById('cmbStore').focus();
		return false;
	}
	document.getElementById('frmItemDispose').submit();
}

function saveGrid()
{
	var path="";  // = "itemDispose_db.php?req=saveDet";
	var tblMain=document.getElementById('tblMain').tBodies[0];
	var rowCount=tblMain.rows.length;
	var count=0;
	document.getElementById('butSave').style.display = 'none';
	for(var i=0;i<rowCount;i++)
	{
		if(tblMain.rows[i].cells[5].childNodes[0].childNodes[0].checked)
		{
			
			if(tblMain.rows[i].cells[4].childNodes[1].value.trim()==""){
				alert("Fill Dispose Qty in Line No : " + [i+1] +".");
				tblMain.rows[i].cells[4].childNodes[1].select();
				document.getElementById('butSave').style.display = 'inline';
				return false;
				}
				
		}
		if(tblMain.rows[i].cells[4].childNodes[1].value.trim()=="")
			count++;
	}
	
	if(count == rowCount)
	{
		alert('Please fill Dispose Qty before save');
		document.getElementById('butSave').style.display = 'inline';
		return;
	}
	var url = "itemDispose_db.php?req=getDocumentNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var docNo = htmlobj.responseXML.getElementsByTagName("disposeNo")[0].childNodes[0].nodeValue;
	var docYear = htmlobj.responseXML.getElementsByTagName("disposeYear")[0].childNodes[0].nodeValue;
	document.getElementById('txtDisposeNo').value = docYear+'/'+docNo;
	
	for(var i=0;i<rowCount;i++)
	{
		if(tblMain.rows[i].cells[5].childNodes[0].childNodes[0].checked)
		{
			var url_d = 'itemDispose_db.php?req=saveDetails';
			var styleId=tblMain.rows[i].cells[0].id;
			var buyerPo=URLEncode(tblMain.rows[i].cells[1].id);
			var matID =tblMain.rows[i].cells[2].id;
			var qty=tblMain.rows[i].cells[3].innerHTML;
			var disposeQty=tblMain.rows[i].cells[4].childNodes[1].value;
			var mainStores=tblMain.rows[i].cells[7].id;
			var subStores=tblMain.rows[i].cells[8].id;
			var location =tblMain.rows[i].cells[9].id;
			var bin=tblMain.rows[i].cells[10].id;
			var color = URLEncode(tblMain.rows[i].cells[11].innerHTML);
			var size = URLEncode(tblMain.rows[i].cells[12].innerHTML);
			var grnNo = URLEncode(tblMain.rows[i].cells[14].innerHTML)
			var grnType = tblMain.rows[i].cells[15].id;
			var strUnit =  URLEncode(tblMain.rows[i].cells[13].innerHTML);
			
			url_d += '&styleId='+styleId+'&buyerPo='+buyerPo+'&matID='+matID+'&disposeQty='+disposeQty+'&mainStores='+mainStores+'&subStores='+subStores+'&location='+location+'&bin='+bin+'&color='+color+'&size='+size+'&grnNo='+grnNo+'&grnType='+grnType+'&docNo='+docNo+'&strUnit='+strUnit;
			
			htmlobj=$.ajax({url:url_d,async:false});
		}
	}
	
	alert("Saved successfully.");
	document.getElementById('butConfirm').style.display = 'inline';
}
function setBalance(obj)
{
	var tblMain		= document.getElementById('tblMain').tBodies[0];
	var td			= obj.parentNode;
	var cell3		= td.parentNode.cells[3].innerHTML;
	var cell4		= td.parentNode.cells[4].childNodes[1].value;
	if( parseFloat(cell3) < parseFloat(cell4))
	{
		//td.parentNode.cells[4].childNodes[1].value 			= "";
		td.parentNode.cells[4].childNodes[1].value 			= cell3;
	}
/*	else
	{
		//var myStr 											= cell4;
		//var strLen 											= myStr.length;
		//td.parentNode.cells[4].childNodes[1].value=myStr 	= myStr.slice(0,strLen-1);
		td.parentNode.cells[4].childNodes[1].value=myStr 	= cell3;
	}*/
}

function loadReport()
{
	var docNo=document.getElementById('cboDisposeNo').value.trim();
	if(docNo=="")
	{
		alert("Select Dispose Number.");
		return false;
	}
	else
	{
		window.open("itemDisposalReport.php?req="+docNo+"",'new'); 
	}
}

function loadDisposedItems(obj)
{
	if(obj.value.trim()=="")
	{
		return false;
	}
	var path  = "itemDisposeXml.php?req=loadListing&docNo="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLDocumentNo 	=	htmlobj.responseXML.getElementsByTagName("DocumentNo");
	var XMLStyle		=	htmlobj.responseXML.getElementsByTagName("Style");
	var XMLBuyerPoName 	=	htmlobj.responseXML.getElementsByTagName("BuyerPoName");
	var XMLDescription	=	htmlobj.responseXML.getElementsByTagName("Description");
	var XMLQty 			=	htmlobj.responseXML.getElementsByTagName("Qty");
	var tblMain=document.getElementById('tblMain').tBodies[0];
	tblMain.innerHTML="";
	for(var i=0;i<XMLDocumentNo.length;i++)
	{
		var rowCount = tblMain.rows.length;
        var row = tblMain.insertRow(rowCount);
		(i%2==1)?row.className="grid_raw":row.className="grid_raw2";
		
		var htm="";
			htm="<td>"+XMLDocumentNo[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLStyle[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLBuyerPoName[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLDescription[i].childNodes[0].nodeValue+"</td>";
			htm+="<td>"+XMLQty[i].childNodes[0].nodeValue+"</td>";
			row.innerHTML =htm;	
	}
}

function setArray(obj)
{
	var row  =obj.parentNode.parentNode.parentNode;
	var rowId = row.rowIndex;
	if(obj.checked)
	{
		rowArray[rowArray.length]				= rowId;
		row.cells[4].childNodes[1].disabled		= false;
		row.cells[4].childNodes[1].focus();
		row.cells[4].childNodes[1].value		= row.cells[3].childNodes[0].nodeValue;
	}
	else
	{
		row.cells[4].childNodes[1].disabled		= true;
		row.cells[4].childNodes[1].value 		= '';
		var indexId 							= rowArray.indexOf(rowId);
		if(indexId!=-1)
			rowArray.splice(indexId,1);
	}	
}

function saveArray()
{
	var count = rowArray.length;
	var i =0;
	var y = 0;
	var n = 0;
	var disNo = '';
	
	for(var x in  rowArray )
	{
		i = rowArray[x];			
		var disposeQty=parseFloat(tblMain.rows[i].cells[4].childNodes[1].value);
		if(disposeQty>0)
		{
			path  = "itemDispose_db.php?req=saveDet";
			var style		= trim(tblMain.rows[i].cells[0].id);
			var buyerPo		= trim(tblMain.rows[i].cells[1].id);
			var maiID 		= tblMain.rows[i].cells[2].id;
			var qty			= parseFloat(tblMain.rows[i].cells[3].innerHTML);
			var mainStores	= tblMain.rows[i].cells[6].id;
			var subStores	= tblMain.rows[i].cells[7].id;
			var location 	= tblMain.rows[i].cells[8].id;
			var bin			= tblMain.rows[i].cells[9].id;
			var color		= tblMain.rows[i].cells[10].innerHTML;
			var size		= tblMain.rows[i].cells[11].innerHTML;
			var unitD		= tblMain.rows[i].cells[12].innerHTML;
			var grnNo		= tblMain.rows[i].cells[13].innerHTML;
			
			path+="&style="+URLEncode(style)+"&buyerPo="+URLEncode(buyerPo)+"&maiID="+maiID+"&qty="+qty+"&disposeQty="+disposeQty+"&mainStores="+mainStores+"&subStores="+subStores+"&location="+location+"&bin="+bin+"&color="+URLEncode(color)+"&size="+URLEncode(size)+"&unitD="+unitD+'&disNo='+disNo+"&grnNo="+URLEncode(grnNo);
			htmlobj=$.ajax({url:path,async:false});
			
			var x = parseInt(htmlobj.responseText);
			if(x>0)
			{
				y = y+1;
				disNo = x;
			}
				n++;
		}
		else
			count--;
	}
	
	if(n==0)
		alert("No item found to save. Please select at least one item.");
	else if(count ==y)
	{
		alert('Dispose No.'+x+' saved successfully.');
		LoadItemData();
	}
	else
		alert('Records not save.Please save again.');
	
}


function openReport(no,year,status)
{
	var form = document.createElement("form");
	var txt	 = document.createElement("input");
	var reportPath="itemDisposalReport.php?no="+no+"&year="+year;
	/*var txtVal=status+","+user+","+date;
                    form.setAttribute("method", "post");
                    form.setAttribute("action", reportPath);
                    document.body.appendChild(form);      
					form.setAttribute("target", "_blank");
					txt.setAttribute('type','hidden');
					txt.setAttribute('name','txtValues');
					txt.setAttribute('value',txtVal);
					form.appendChild(txt)
                    form.submit()*/

	window.open(reportPath,'new' ); 
}
function dateDisable(obj){
	if(obj.checked==true)
	{	
		document.getElementById('fromDate').disabled=false;
		document.getElementById('toDate').disabled=false;
	}
	else
	{
		document.getElementById('fromDate').disabled=true;
		document.getElementById('toDate').disabled=true;
		document.getElementById('fromDate').value="";
		document.getElementById('toDate').value="";
	}
}

function selectDisposeNo(obj){
	
	document.getElementById('tblPendingGrn').tBodies[0].innerHTML="";
	if(obj.value.trim()==""){
		document.getElementById('cboDisposeNo').innerHTML="";
		return false;
		}
	var path="itemDisposeXml.php?req=getDisposeNo&status="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLDisposeNo 	=	htmlobj.responseXML.getElementsByTagName("Result");
	document.getElementById('cboDisposeNo').innerHTML="<option value=\"\"></option>";
	
	if(XMLDisposeNo.length>0)
	{
		for(var i=0;i<XMLDisposeNo.length;i++)
		{
			var opt = document.createElement("option");
				opt.value = XMLDisposeNo[i].childNodes[0].nodeValue;
				opt.text = XMLDisposeNo[i].childNodes[0].nodeValue;	
				document.getElementById("cboDisposeNo").options.add(opt);
		}
	}
}
function selectMainStore(obj){
	if(obj.value.trim()==""){
		document.getElementById('cboMainStore').innerHTML="";
		return false;
		}
	var path="itemDisposeXml.php?req=getMainStore&ComId="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLMainID 	=	htmlobj.responseXML.getElementsByTagName("MainID");
	var XMLMName 	=	htmlobj.responseXML.getElementsByTagName("Name");
	document.getElementById('cboMainStore').innerHTML="<option value=\"\"></option>";
	
	if(XMLMainID.length>0)
	{
		for(var i=0;i<XMLMainID.length;i++)
		{
			var opt = document.createElement("option");
				opt.value = XMLMainID[i].childNodes[0].nodeValue;
				opt.text = XMLMName[i].childNodes[0].nodeValue;	
				document.getElementById("cboMainStore").options.add(opt);
		}
	}
}

function confirmItemDispose(disposeYear,disposeNo){
	
	
	var path="itemDispose_db.php?req=confirmDispose&disposeId="+disposeNo+"&disposeYear="+disposeYear;
	htmlobj=$.ajax({url:path,async:false});
	var res=htmlobj.responseText;
	
	if(res==1){
		document.getElementById('confrimDiv').innerHTML="";
		alert("Disposel No : "+disposeYear+'/'+ disposeNo + " comfirmed successfully.");
		
		window.location.reload();//window.close();
		//window.opener.location.reload();
	} 
	else
	{
		alert(res);
		}
	
}

function clearPage(){
	document.getElementById('frmItemDispose').reset();
	document.getElementById('cmbStyleName').value="";
	document.getElementById('cmbStyle').value="";
	document.getElementById('cmbStore').value="";
	document.getElementById('cmbSC').value="";
	document.getElementById('cmbSubCat').value="";
	document.getElementById('cmbMainCat').value="";
	document.getElementById('cboSubStore').value="";
	document.getElementById('butConfirm').style.display = 'none';
	document.getElementById('butSave').style.display = 'inline';
	var tblMain=document.getElementById('tblMain').tBodies[0];
	tblMain.innerHTML="";
}

function openConfirmReport()
{
	var disposeNo = document.getElementById('txtDisposeNo').value;
	var disNo	= disposeNo.split("/");
	var	no 	= parseInt(disNo[1]);
	var	year 	= parseInt(disNo[0]);
	var reportPath="itemDisposalReport.php?no="+no+"&year="+year;
	
	window.open(reportPath,'frmItemDispose'); 
}
function searchDet()
{
	document.getElementById('frmdisposelist').submit();	
}