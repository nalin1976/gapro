// JavaScript Document
var pub_GPNo = 0;
function LoadOrderNo(transferNo)
{
	ClearTable('tblMainGrid');
	if(transferNo=="")
	{
		document.getElementById('cboOrderNo').innerHTML = "<option value=\"\"></option>";
		document.getElementById('cboCutNo').innerHTML = "<option value=\"\"></option>";
		ClearTable('tblMainGrid');
		return;
	}
	var url = 'sewinggatepassdb.php?Request=LoadOrderNo&transferNo='+transferNo;
	htmlobj = $.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLOrderNo;
	loadCutNo();
	
}
function loadCutNo()
{
	var transferNo = $('#cboTransferInNo').val();
	var orderNo = $('#cboOrderNo').val();
	var url = 'sewinggatepassdb.php?Request=LoadCutNo&transferNo='+transferNo+'&orderNo='+orderNo;
	htmlobj = $.ajax({url:url,async:false});
	var XMLCutNo = htmlobj.responseText;
	document.getElementById('cboCutNo').innerHTML = XMLCutNo;

}
function loadDetails()
{
	var transferNo = $('#cboTransferInNo').val();
	var orderNo    = $('#cboOrderNo').val();
	var cutNo      = $('#cboCutNo').val();
	var url = 'sewinggatepassdb.php?Request=loadGatepassDetails&transferNo=' +transferNo+ '&orderNo=' +orderNo+ '&cutNo=' +cutNo;
	htmlobj=$.ajax({url:url,async:false});
	ClearTable('tblMainGrid');
	
	var XMLcutNo 			  = htmlobj.responseXML.getElementsByTagName("strCutNo");
	var XMLSize  		 	  = htmlobj.responseXML.getElementsByTagName("strSize");
	var XMLBundleNo 		  = htmlobj.responseXML.getElementsByTagName("dblBundleNo");
	var XMLdblQty 			  = htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLShade 			  = htmlobj.responseXML.getElementsByTagName("strShade");
	var XMLCutBundleSerial 	  = htmlobj.responseXML.getElementsByTagName("CutBundleSerial");
	
	for(loop=0;loop<XMLcutNo.length;loop++)
	{
		var cutNo 	 		  = XMLcutNo[loop].childNodes[0].nodeValue;
		var Size 	 		  = XMLSize[loop].childNodes[0].nodeValue;
		var BundleNo 		  = XMLBundleNo[loop].childNodes[0].nodeValue;
		var dblQty	  		  = XMLdblQty[loop].childNodes[0].nodeValue;
		var Shade	 		  = XMLShade[loop].childNodes[0].nodeValue;
		var CutBundleSerial	  = XMLCutBundleSerial[loop].childNodes[0].nodeValue;
		
		createMainGrid(cutNo,Size,BundleNo,dblQty,Shade,CutBundleSerial,0);
	}
}
function createMainGrid(cutNo,Size,BundleNo,dblQty,Shade,CutBundleSerial,states)
{
	var tbl 	  = document.getElementById('tblMainGrid');
	var lastRow   = tbl.rows.length;	
	var row 	  = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cell       = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id        = CutBundleSerial;
	if(states==0)
		cell.innerHTML = "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";
	else
		cell.innerHTML = "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" checked=\"checked\" /> ";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = cutNo;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	//cell.id = styleId;
	cell.innerHTML = Size;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = BundleNo;
	
	var cell = row.insertCell(4);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = dblQty;
	
	var cell = row.insertCell(5);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = Shade;
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function checkAll(obj)
{
	var tbl = document.getElementById("tblMainGrid");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}
function saveData()
{
	showPleaseWait();
	document.getElementById("butSave").style.display = "none";
	if(!saveValidation())
		return;
	
	var tbl = document.getElementById("tblMainGrid")
	for(var loopz=1;loopz<tbl.rows.length;loopz++)
	{
		if(tbl.rows[loopz].cells[0].childNodes[0].checked==true)
		{
			var GPNo = $('#txtGPNo').val();
			if(GPNo=="")
			{
				getGatePassNo();
				saveHeader();
				saveDetail(loopz);	
			}
			else
			{
				pub_GPNo = GPNo;
				saveHeader();
				saveDetail(loopz);	
			}
		}
	}
	alert("Saved successfully");
	hidePleaseWait();
}
function saveValidation()
{
	if(document.getElementById("txtVehicle").value=="")
	{
		alert("Please enter 'Vehicle No'.");
		document.getElementById("butSave").style.display = "inline";
		document.getElementById("txtVehicle").focus();
		hidePleaseWait();
		return false;
	}
	
	if(document.getElementById("txtPalletNo").value=="")
	{
		alert("Please enter 'Pallet No'.");
		document.getElementById("butSave").style.display = "inline";
		document.getElementById("txtPalletNo").focus();
		hidePleaseWait();
		return false;
	}
	
	if(document.getElementById("cboToFactory").value=="")
	{
		alert("Please select 'To Factory'.");
		document.getElementById("butSave").style.display = "inline";
		document.getElementById("cboToFactory").focus();
		hidePleaseWait();
		return false;
	}
	
	if(document.getElementById("cboReasonCode").value=="")
	{
		alert("Please select 'Reason Code'.");
		document.getElementById("butSave").style.display = "inline";
		document.getElementById("cboReasonCode").focus();
		hidePleaseWait();
		return false;
	}
	
	if(document.getElementById("tblMainGrid").rows.length<2)
	{
		alert('Sorry! There is no record to save.');
		document.getElementById("butSave").style.display = "inline";
		hidePleaseWait();
		return false;
	}
	var row_source 	= $('#tblMainGrid tr')
	for(var loopz=1;loopz<row_source.length;loopz++)
	{
		if(row_source[loopz].cells[0].childNodes[0].checked==true)
		{
			var booCheck = true;
		}
	}
	if(booCheck!=true)
	{
		alert('Please select at lease one record to save.');
		document.getElementById("butSave").style.display = "inline";
		hidePleaseWait();
		return false;
	}
	return true;
}
function getGatePassNo()
{
	var url  = "sewinggatepassdb.php?Request=getGatePassNo";
	htmlobj  = $.ajax({url:url,async:false});
	pub_GPNo = htmlobj.responseText;
	var opt = document.createElement("option");
				opt.text = pub_GPNo;
				opt.value = pub_GPNo;
				opt.selected = "selected";
				document.getElementById("txtGPNo").options.add(opt);
}
function saveHeader()
{
	var vehicleNo 	= $('#txtVehicle').val();
	var palletNo  	= $('#txtPalletNo').val();
	var toFactory	= $('#cboToFactory').val();
	var gpDate	 	= $('#txtGPDate').val();
	var reMarks	  	= $('#txtRemarks').val();
	var styleId	  	= $('#cboOrderNo').val();
	var totQty   	= calTotQty();
	var reasonCode	= $('#cboReasonCode').val();
	
	var url = "sewinggatepassdb.php?Request=saveGatePassHeader&pub_GPNo="+URLEncode(pub_GPNo)+"&vehicleNo="+URLEncode(vehicleNo)+"&palletNo="+URLEncode(palletNo)+"&gpDate="+URLEncode(gpDate)+"&toFactory="+toFactory+"&totQty="+totQty+"&styleId="+styleId+"&reMarks="+URLEncode(reMarks)+"&ReasonCode="+reasonCode;
	htmlobj=$.ajax({url:url,async:false});
}
function saveDetail(loopz)
{
	var tbl = document.getElementById('tblMainGrid');
	var GPNo 			= $('#txtGPNo').val();
	var transferInNo    = $('#cboTransferInNo').val();
	var rw				= tbl.rows[loopz];
	var cutBundleSerial = rw.cells[0].id;
	var bundleNo 		= rw.cells[3].childNodes[0].nodeValue;
	var Qty  			= rw.cells[4].childNodes[0].nodeValue;
	
	var url = 'sewinggatepassdb.php?Request=SaveGatePassDetails&GPNo='+URLEncode(GPNo)+'&cutBundleSerial='+cutBundleSerial+'&bundleNo='+bundleNo+'&Qty='+Qty+'&transferInNo='+transferInNo;
	htmlobj=$.ajax({url:url,async:false});
	
}
function calTotQty()
{
	var tbl = document.getElementById('tblMainGrid');
	var total=0;
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked==true)
		{
			total+=parseFloat(tbl.rows[i].cells[4].childNodes[0].nodeValue);
		}
	}
	return total;
}
function clearPage()
{
	window.location.href='sewinggatepass.php';
}
function print_gp()
{
	
	if(document.getElementById('txtGPNo').value=="")
	{
		alert("No gate pass No to view report.");	
		return false;
	}
	var GPNo = $('#txtGPNo').val();
	window.open('sewinggatepassrpt.php?gpnumber='+GPNo,'gp');
}
function load_gp_list(GPNO)
{	
	if(document.getElementById("txtGPNo").value=="")
	{
		document.getElementById("butSave").style.display = "inline";
		clearPage();
		return;
	}
	else
		document.getElementById("butSave").style.display = "none";
	
		
	var url='sewinggatepassdb.php?Request=load_gp_list&GPNO='+GPNO;
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById("txtVehicle").value=htmlobj.responseXML.getElementsByTagName('strVehicleNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtPalletNo").value=htmlobj.responseXML.getElementsByTagName('strPalletNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtGPDate").value=htmlobj.responseXML.getElementsByTagName('gpdate')[0].childNodes[0].nodeValue;
	document.getElementById("cboToFactory").value=htmlobj.responseXML.getElementsByTagName('intTofactory')[0].childNodes[0].nodeValue;
	document.getElementById("cboTransferInNo").value=htmlobj.responseXML.getElementsByTagName('TINo')[0].childNodes[0].nodeValue;
	var opt = document.createElement("option");
				opt.text = htmlobj.responseXML.getElementsByTagName('strOrderNo')[0].childNodes[0].nodeValue;
				opt.value = htmlobj.responseXML.getElementsByTagName('intStyleId')[0].childNodes[0].nodeValue;
				document.getElementById("cboOrderNo").options.add(opt);
	document.getElementById("txtRemarks").value=htmlobj.responseXML.getElementsByTagName('strRemarks')[0].childNodes[0].nodeValue;
	document.getElementById("cboReasonCode").value=htmlobj.responseXML.getElementsByTagName('ReasonCode')[0].childNodes[0].nodeValue;
	load_gp_details();
}
function load_gp_details()
{
	var GPNO = document.getElementById("txtGPNo").value;
	var url='sewinggatepassdb.php?Request=load_gp_details&GPNO='+GPNO;
	var xmlhttpobj=$.ajax({url:url,async:false});
	ClearTable('tblMainGrid');
	
	var XMLCutBundleSerial = xmlhttpobj.responseXML.getElementsByTagName('CutBundleSerial');
	var XMLBundleNo		   = xmlhttpobj.responseXML.getElementsByTagName('dblBundleNo');
	var XMLdblQty		   = xmlhttpobj.responseXML.getElementsByTagName('dblQty');
	var XMLstrCutNo		   = xmlhttpobj.responseXML.getElementsByTagName('strCutNo');
	var XMLstrSize		   = xmlhttpobj.responseXML.getElementsByTagName('strSize');
	var XMLstrShade		   = xmlhttpobj.responseXML.getElementsByTagName('strShade');
	
	for(loop=0;loop<XMLCutBundleSerial.length;loop++)
	{
		var CutBundleSerial   = XMLCutBundleSerial[loop].childNodes[0].nodeValue;
		var Size 	 		  = XMLstrSize[loop].childNodes[0].nodeValue;
		var BundleNo 		  = XMLBundleNo[loop].childNodes[0].nodeValue;
		var dblQty	  		  = XMLdblQty[loop].childNodes[0].nodeValue;
		var Shade	 		  = XMLstrShade[loop].childNodes[0].nodeValue;
		var CutNo	  		  = XMLstrCutNo[loop].childNodes[0].nodeValue;
		
		createMainGrid(CutNo,Size,BundleNo,dblQty,Shade,CutBundleSerial,1);
	}
}