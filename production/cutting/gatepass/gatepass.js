//MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMcommonMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
var  xmlHttp=[];
var pub_records=0;
var pub_response_count=0;
var number_range=0;
var pub_total_quantity=0;
var pub_bundle_no=0;
var verify_count=0;
var prev_color="";
var prev_tbl="";
var prew_index=-1;
function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function deleterowsnotgpd(tableName)
	{	
		var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			var color=tbl.rows[loop].bgColor
			if(color=="#3974fb")
			continue;
			 tbl.deleteRow(loop);
		}		
	
	}	


function deleterows(tableName)
	{	
		var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	

function rowclickColorChangetbl()
{
	
	var rowIndex = this.rowIndex;
	var tablez=this.id;
	var tbl = document.getElementById(tablez);
	var color=tbl.rows[rowIndex].bgColor;
	if(color=="#3974fb")
			return false;
    
	try{
				if(prev_tbl!=""){
				document.getElementById(prev_tbl).rows[prew_index].className="";
				document.getElementById(prev_tbl).rows[prew_index].bgColor=prev_color;
				
				}
	}
	catch(err){}
	
		prev_color=tbl.rows[rowIndex].bgColor;
		prew_index=rowIndex;
		tbl.rows[rowIndex].className = "bcgcolor-highlighted";
		prev_tbl=tablez;
		
}

function colorSetter(tablez)
{
	
	
	var tbl = document.getElementById(tablez);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="odd";
		}
		else
		{
			tbl.rows[i].className="even";
		}
		
	}
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 1) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}



//ENDCOMMONMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM

function filterStyle()
{
	
	var buyer=document.getElementById("cboBuyer").value;	
	if(buyer!="")
		{	
			RomoveData("cmbStyle");
			createNewXMLHttpRequest(3);
			xmlHttp[3].onreadystatechange=function()
			{
						if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
						{
							var XMLstyleno=xmlHttp[3].responseXML.getElementsByTagName('StyleId');
							var XMLstylename=xmlHttp[3].responseXML.getElementsByTagName('Style');
							for (var loop=0; loop<XMLstyleno.length;loop++)
							{
									var opt 	= document.createElement("option");
									opt.text 	= XMLstylename[loop].childNodes[0].nodeValue;
									opt.value 	= XMLstyleno[loop].childNodes[0].nodeValue;
									document.getElementById("cmbStyle").options.add(opt);
							}
						}	
			}
			xmlHttp[3].open("GET",'gatepassdb.php?request=filter&buyer='+buyer,true);
			xmlHttp[3].send(null);	
		
		}
				

		
}

function loadCutNo()
{
	var Style=document.getElementById("cmbStyle").value;
	if(Style!="")
		{	
			createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=function()
			{
						if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
						{
							var XMLserial=xmlHttp[4].responseXML.getElementsByTagName('serial');
							var XMLcutno=xmlHttp[4].responseXML.getElementsByTagName('cutNO');
							var XMLtotQty=xmlHttp[4].responseXML.getElementsByTagName('Tot_Qty');
							var XMLcut_gp_status=xmlHttp[4].responseXML.getElementsByTagName('cut_gp_status');
							var tbl=document.getElementById("tblCutNo");
							deleterows("tblSize");
							deleterows("tblCutNo");
							if(prev_tbl=="tblSize")
							prev_tbl="";
							for (var loop=0; loop<XMLserial.length;loop++)
							{
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
														
														if(XMLcut_gp_status[loop].childNodes[0].nodeValue=='complete')
															var color='#3974FB';				
														else
															var color='#66CC00';
														
														//row.onclick	= rowclickColorChangetbl;
														row.bgColor=color;
														row.id='tblCutNo';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfnt";
														rowCell.height='20';
														rowCell.nowrap="nowrap"
														rowCell.id=XMLserial[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =XMLcutno[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntRite";			
														rowCell.innerHTML =XMLtotQty[loop].childNodes[0].nodeValue;													
													
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input type=\"checkbox\"class=\"txtbox\"id=\""+XMLserial[loop].childNodes[0].nodeValue+"\"onchange=\"loadsizes(this)\"/>";
														
							}
						}	
			}
			xmlHttp[4].open("GET",'gatepassdb.php?request=getcutz&Style='+Style,true);
			xmlHttp[4].send(null);	
			set_Buyer();
			
		}	
		
}

function loadsizes(dz)
{
	var serial=dz.id;
	if(serial!="" && dz.checked==true)
		{	
			createNewXMLHttpRequest(5);
			xmlHttp[5].onreadystatechange=function()
			{
						if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
						{
							var XMLserial=xmlHttp[5].responseXML.getElementsByTagName('serial');
							var XMLsize=xmlHttp[5].responseXML.getElementsByTagName('size');
							var XMLshade=xmlHttp[5].responseXML.getElementsByTagName('shade');
							var XMLbundle=xmlHttp[5].responseXML.getElementsByTagName('bundle');
							var XMLpcs=xmlHttp[5].responseXML.getElementsByTagName('pcs');
							var XMLstate=xmlHttp[5].responseXML.getElementsByTagName('status');
							var tbl=document.getElementById("tblSize");
							for (var loop=0; loop<XMLserial.length;loop++)
							{
								
														var color="#66CC00";		
														if(XMLstate[loop].childNodes[0].nodeValue==11)
														{
															color="#FE5B49";
														}
														
														if(XMLstate[loop].childNodes[0].nodeValue==2)
														{
															color="#3974FB";
														}
														
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
														
														row.bgColor=color;
														
														row.ondblclick=add_to_grid_o_b_o;
														row.onclick	= rowclickColorChangetbl;
														row.id='tblSize';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfnt";
														rowCell.id=serial;
														rowCell.height='20';
														rowCell.innerHTML =XMLsize[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfnt";
														rowCell.id=XMLbundle[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =XMLshade[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfnt";
														rowCell.id=XMLbundle[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =XMLpcs[loop].childNodes[0].nodeValue;
																											
							}
						}	
			}
			xmlHttp[5].open("GET",'gatepassdb.php?request=getsizes&serial='+serial,true);
			xmlHttp[5].send(null);	
			
			
		}	
		else
		{
		remove_selected(serial);remove_selected_sizes(serial);}
}


function addAllSizestoGrid()
{
		
	var tbl=document.getElementById("tblSize");
	var stbl=document.getElementById("tbladdedsizes");
	
	for (var loop=1; loop<tbl.rows.length;loop++)
							{
							var color=tbl.rows[loop].bgColor
							if(color=="#3974fb")
							continue;
								
							var lastRow 		= stbl.rows.length;	
							var row 			= stbl.insertRow(lastRow);
							
							
							row.bgColor=color;
							
							
							
							row.ondblclick=remove_to_grid_o_b_o;
							row.onclick	= rowclickColorChangetbl;
							row.id='tbladdedsizes';
							
							var rowCell = row.insertCell(0);
							rowCell.className ="normalfnt";
							rowCell.height='20';
							rowCell.id=tbl.rows[loop].cells[0].id;
							rowCell.innerHTML =tbl.rows[loop].cells[0].innerHTML;
							
							var rowCell = row.insertCell(1);
							rowCell.className ="normalfnt";
							rowCell.id=tbl.rows[loop].cells[1].id;
							rowCell.innerHTML =tbl.rows[loop].cells[1].innerHTML;
							
							var rowCell = row.insertCell(2);
							rowCell.className ="normalfnt";
							rowCell.id=tbl.rows[loop].cells[2].id;
							rowCell.innerHTML =tbl.rows[loop].cells[2].innerHTML;
																				
																
							}
			deleterowsnotgpd("tblSize");				
}



function saveHeader()
{
	if(document.getElementById("cboGpNo").value.trim()!="")
	{
		return false;
	}
		
	if(document.getElementById("txtVehicle").value.trim()=="")
	{
		alert('Please enter "Vehicle #."');
		document.getElementById("txtVehicle").focus();
		return false;
	}
	
	if(document.getElementById("txtPalletNo").value.trim()=="")
	{
		alert('Please enter "Pallet #."');
		document.getElementById("txtPalletNo").focus();
		return false;
	}
	
	if(document.getElementById("cboToFactory").value=="")
	{
		alert('Please select the "To Factory"');
		document.getElementById("cboToFactory").focus();
		return false;
	}
	
	if(document.getElementById("tbladdedsizes").rows.length<2)
	{
		alert('Sorry! There is no record to save.');
		return false;
	}
	
	
	var gpnumber=document.getElementById("cboGpNo").value;
	var Styleno=document.getElementById("cmbStyle").value;
	var tofactory=document.getElementById("cboToFactory").value;
	var gpdate=document.getElementById("txtCutDate").value;
	var PreparedBy=document.getElementById("txtPreparedBy").value;
	var Vehicle=document.getElementById("txtVehicle").value;
	var PalletNo=document.getElementById("txtPalletNo").value;
	var totqty=calsum();
	showBackGroundBalck();
	createNewXMLHttpRequest(6);
			xmlHttp[6].onreadystatechange=function()
			{
						if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
						{
							if(xmlHttp[6].responseText!='Error!')
							saveDetail(xmlHttp[6].responseText);
							else
							hideBackGroundBalck();
						}
			}
	
	xmlHttp[6].open("GET",'gatepassdb.php?request=saveheader&gpnumber='+gpnumber+'&totqty='+totqty+'&Styleno='+Styleno+'&tofactory='+tofactory+'&gpdate='+gpdate+'&Vehicle='+Vehicle+'&PalletNo='+PalletNo,true);
	xmlHttp[6].send(null);	
}

function saveDetail(gpno)
{
		var tofactory=document.getElementById("cboToFactory").value;
		var gpnumber=gpno;
		var xmlhttpobj=[];
		var stbl=document.getElementById("tbladdedsizes");
		for(var loop=1;loop<stbl.rows.length;loop++)
			{	var serial=stbl.rows[loop].cells[0].id;
				var cutno=stbl.rows[loop].cells[1].id;
				var url='gatepassdb.php?request=savedetail&serial='+serial+'&gpnumber='+gpnumber+'&cutno='+cutno+'&tofactory='+tofactory;
				xmlhttpobj[loop]=$.ajax({url:url,async:false});				
			}
	
			save_verify(gpno);
}

function loadFactory()
{	
	var factype="";
	if (document.getElementById("IN").checked==true)
			factype="IN";
	else if(document.getElementById("EX").checked==true)
			factype="EX";
	RomoveData("cboToFactory");		
	createNewXMLHttpRequest(8);
			xmlHttp[8].onreadystatechange=function()
			{
						if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200)
						{
							var XMLstyleno=xmlHttp[8].responseXML.getElementsByTagName('StyleId');
							var XMLstylename=xmlHttp[8].responseXML.getElementsByTagName('Style');
							for (var loop=0; loop<XMLstyleno.length;loop++)
							{
									var opt 		= document.createElement("option");
									opt.text 	= XMLstylename[loop].childNodes[0].nodeValue;
									opt.value 	= XMLstyleno[loop].childNodes[0].nodeValue;
									document.getElementById("cmbStyle").options.add(opt);
							}
						}	
			}
			xmlHttp[8].open("GET",'gatepassdb.php?request=loadfact&factype='+factype,true);
			xmlHttp[8].send(null);			
		
}

function gettofactory()
{
	var tofactory="";
	if(document.getElementById('IN').checked==true)
	{  tofactory='IN';}
	else if(document.getElementById('EX').checked==true)
	{  tofactory='EX';}
	
			createNewXMLHttpRequest(6);
			xmlHttp[6].onreadystatechange=function()
			{
				if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
						{
							RomoveData("cboToFactory");
							var XMLfacid=xmlHttp[6].responseXML.getElementsByTagName('facid');
							var XMLname=xmlHttp[6].responseXML.getElementsByTagName('facname');
							for(var loop=0;loop<XMLfacid.length;loop++)
							{
									var opt 		= document.createElement("option");
									opt.text 	= XMLname[loop].childNodes[0].nodeValue;
									opt.value 	= XMLfacid[loop].childNodes[0].nodeValue;
									document.getElementById("cboToFactory").options.add(opt);
							}
						}
			}
	xmlHttp[6].open("GET",'gatepassdb.php?request=tofac&tofactory='+tofactory,true);
	xmlHttp[6].send(null);	
}

function save_verify(gpno)
{
	alert("Gate pass: "+gpno+" saved successfully.");
											
	hideBackGroundBalck();
	loadCombo( "select concat(intYear,\"/\", intGPnumber) as gpid,concat(intYear,\"-->\", intGPnumber) as gpid from productiongpheader order by intGPnumber desc","cboGpNo");
	var d=new Date();
	newFormGP();
	document.getElementById("cboGpNo").value=d.getFullYear()+"/"+gpno;
	
	/*var pubrecords=document.getElementById("tbladdedsizes").rows.length-1;
	createNewXMLHttpRequest(8);	
	var gpnumber=document.getElementById("cboGpNo").value;
	xmlHttp[8].onreadystatechange=function()
			{			
							
						if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200)
								{
									var str=xmlHttp[8].responseText;
									
									if(str=="saved" ){
											alert("Successfully saved.");
											
											hideBackGroundBalck();
											loadCombo( "select concat(intYear,\"/\", intGPnumber) as gpid,concat(intYear																							 ,\"-->\", intGPnumber) as gpid from productiongpheader ","cboGpNo");
											var d=new Date();
											document.getElementById("cboGpNo").value=d.getFullYear()+"/"+gpno;
											}
									else if(verify_count>=5){
									alert("Error: Problem occurred while saving.");hideBackGroundBalck();}
									else 
										{	verify_count+=1;setTimeout("save_verify(gpno)",10000);}
									
								}	
			}
	xmlHttp[8].open("GET",'gatepassdb.php?request=saveVerify&pub_records='+pubrecords+'&gpnumber='+gpno,true);
	xmlHttp[8].send(null);	*/
}

function add_to_grid_o_b_o()
{	
	var frmtbl=document.getElementById("tblSize");
	var totbl=document.getElementById("tbladdedsizes");
	for ( var i = 1; i < frmtbl.rows.length; i ++)
	{		
		if(frmtbl.rows[i].className =="bcgcolor-highlighted" && i<frmtbl.rows.length)
		{							
									var color=frmtbl.rows[i].bgColor
									if(color=="#3974fb")
									continue;
									var lastRow 		= totbl.rows.length;	
									var row 			= totbl.insertRow(lastRow);
																		
									row.bgColor=color;
									
									row.onclick	= rowclickColorChangetbl;
									row.ondblclick=remove_to_grid_o_b_o;
									row.id='tbladdedsizes';			
			
			 						var rowCell = row.insertCell(0);
									rowCell.className ="normalfnt";
									rowCell.height='20';
									rowCell.id=frmtbl.rows[i].cells[0].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[0].innerHTML;
									
									var rowCell = row.insertCell(1);
									rowCell.className ="normalfnt";
									rowCell.id=frmtbl.rows[i].cells[1].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[1].innerHTML;
									
									var rowCell = row.insertCell(2);
									rowCell.className ="normalfnt";
									rowCell.id=frmtbl.rows[i].cells[2].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[2].innerHTML;
									
									if(i<frmtbl.rows.length-1){
											if(frmtbl.rows[i+1].bgColor!="#3974fb"){
											prev_color=frmtbl.rows[i+1].bgColor
											prew_index=i;
											frmtbl.rows[i+1].className ="bcgcolor-highlighted";}
											else prev_tbl=""
											}
										else if(i>1 && frmtbl.rows[i-1].bgColor!="#3974fb"){
											if(frmtbl.rows[i-1].bgColor!="#3974fb"){
											prev_color=frmtbl.rows[i-1].bgColor
											prew_index=i;
											frmtbl.rows[i-1].className ="bcgcolor-highlighted";	}										
											else prev_tbl=""
											}
											else prev_tbl=""
								  	
								  /* if(prev_tbl=="tblSize" && prew_index==i)
										prev_tbl="";	*/
								   frmtbl.deleteRow(i);
									
									
							
							
		}
	}

}

function remove_to_grid_o_b_o()
{
	var totbl=document.getElementById("tblSize");
	var frmtbl=document.getElementById("tbladdedsizes");
	for ( var i = 1; i < frmtbl.rows.length; i ++)
	{		
		if(frmtbl.rows[i].className =="bcgcolor-highlighted" && i<frmtbl.rows.length)
		{							
									
									var lastRow 		= totbl.rows.length;	
									var row 			= totbl.insertRow(lastRow);
									
									var color=frmtbl.rows[i].bgColor
									row.bgColor=color;
									
									row.onclick	= rowclickColorChangetbl;
									row.ondblclick=add_to_grid_o_b_o;
									row.id='tblSize';	
			 						
									var rowCell = row.insertCell(0);
									rowCell.className ="normalfnt";
									rowCell.height='20';
									rowCell.id=frmtbl.rows[i].cells[0].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[0].innerHTML;
									
									var rowCell = row.insertCell(1);
									rowCell.className ="normalfnt";
									rowCell.id=frmtbl.rows[i].cells[1].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[1].innerHTML;
									
									var rowCell = row.insertCell(2);
									rowCell.className ="normalfnt";
									rowCell.id=frmtbl.rows[i].cells[2].id;
									rowCell.innerHTML =frmtbl.rows[i].cells[2].innerHTML;
									
									if(i<frmtbl.rows.length-1){
											prev_color=frmtbl.rows[i+1].bgColor
											prew_index=i;
											frmtbl.rows[i+1].className ="bcgcolor-highlighted";											
											}
										else if(i>1 && frmtbl.rows[i-1].bgColor!="#3974fb"){											
											prev_color=frmtbl.rows[i-1].bgColor
											prew_index=i;
											frmtbl.rows[i-1].className ="bcgcolor-highlighted";										
											}
										else prev_tbl=""
											
										/*if(prev_tbl=="tbladdedsizes" && prew_index==i)
										prev_tbl="";	*/
								    	frmtbl.deleteRow(i);
									
									
									
							
							
		}
	}

}

function remove_selected(siz)
{
	var tbl=document.getElementById("tblSize");
	for ( var i =tbl.rows.length; i > 1; i --)
	{
		if(tbl.rows[i-1].cells[0].id==siz)
		{		
				if(prev_tbl=="tblSize" && prew_index==i-1)
				prev_tbl="";
				tbl.deleteRow(i-1);
				
		}
		
	}
}

function remove_selected_sizes(siz)
{
	var tbl=document.getElementById("tbladdedsizes");
	for ( var i =tbl.rows.length; i > 1; i --)
	{
		if(tbl.rows[i-1].cells[0].id==siz)
		{		if(prev_tbl=="tbladdedsizes" && prew_index==i-1)
				prev_tbl="";
				tbl.deleteRow(i-1);
		}
		
	}
}

function removeAllSizesfromGrid()
{
		
	var tbl=document.getElementById("tbladdedsizes");
	var stbl=document.getElementById("tblSize");
	
	for (var loop=1; loop<tbl.rows.length;loop++)
							{
								
							var lastRow 		= stbl.rows.length;	
							var row 			= stbl.insertRow(lastRow);
							
							color=tbl.rows[loop].bgColor;
							
							row.bgColor=color;
							
							row.onclick	= rowclickColorChangetbl;
							row.ondblclick=add_to_grid_o_b_o;
							row.id='tblSize';
							
							var rowCell = row.insertCell(0);
							rowCell.className ="normalfnt";
							rowCell.height='20';
							rowCell.id=tbl.rows[loop].cells[0].id;
							rowCell.innerHTML =tbl.rows[loop].cells[0].innerHTML;
							
							var rowCell = row.insertCell(1);
							rowCell.className ="normalfnt";
							rowCell.id=tbl.rows[loop].cells[1].id;
							rowCell.innerHTML =tbl.rows[loop].cells[1].innerHTML;
							
							var rowCell = row.insertCell(2);
							rowCell.className ="normalfnt";
							rowCell.id=tbl.rows[loop].cells[2].id;
							rowCell.innerHTML =tbl.rows[loop].cells[2].innerHTML;
																											
							}
			deleterowsnotgpd("tbladdedsizes");				
}

function print_gp()
{
	var gpno=document.getElementById("cboGpNo").value;
	if(gpno=="")
	{
		alert('Please select a "GP #".');
		document.getElementById("cboGpNo").focus();
		return false;
	}
	window.open('rptgatepass.php?gpnumber='+gpno,'gp');
	
}

function calsum()
{
	var tbl=document.getElementById("tbladdedsizes");
	var total=0;
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
				total+=parseFloat(tbl.rows[loop].cells[2].childNodes[0].nodeValue);	
		}
	return total;
}

function newFormGP()
{
	document.getElementById("cboGpNo").value="";
	document.getElementById("txtVehicle").value="";
	document.getElementById("txtPalletNo").value="";
	document.getElementById("cboToFactory").value="";
	document.getElementById("cboBuyer").value="";
	document.getElementById("cmbStyle").value="";
	deleterows("tblSize");
	deleterows("tblCutNo");
	deleterows("tbladdedsizes");
	document.getElementById("txtVehicle").focus();
	$(".txtbox").removeAttr("disabled");
}

function load_gp_list()
{
	var gp=document.getElementById("cboGpNo").value;
	var url='gatepassdb.php?request=load_gp_list&gp='+gp;
	var xmlhttpobj=$.ajax({url:url,async:false});
	document.getElementById("txtVehicle").value=xmlhttpobj.responseXML.getElementsByTagName('VehicleNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtPalletNo").value=xmlhttpobj.responseXML.getElementsByTagName('PalletNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtCutDate").value=xmlhttpobj.responseXML.getElementsByTagName('gpdate')[0].childNodes[0].nodeValue;
	document.getElementById("cboToFactory").value=xmlhttpobj.responseXML.getElementsByTagName('Tofactory')[0].childNodes[0].nodeValue;
	document.getElementById("cmbStyle").value=xmlhttpobj.responseXML.getElementsByTagName('StyleId')[0].childNodes[0].nodeValue;
	document.getElementById("cboBuyer").value=xmlhttpobj.responseXML.getElementsByTagName('BuyerId')[0].childNodes[0].nodeValue;
	document.getElementById("txtPreparedBy").value=xmlhttpobj.responseXML.getElementsByTagName('UserName')[0].childNodes[0].nodeValue;
	var XMLStatus = xmlhttpobj.responseXML.getElementsByTagName('Status')[0].childNodes[0].nodeValue;
	if(XMLStatus=='10')
		document.getElementById("butCancel").style.display = 'none';
load_gp_details();
}

function set_Buyer()
{
	document.getElementById("cboBuyer").value=""
	var style=document.getElementById("cmbStyle").value;
	var url='gatepassdb.php?request=get_style_buyer&style='+style;
	var xmlhttpobj=$.ajax({url:url,async:false});
	document.getElementById("cboBuyer").value=xmlhttpobj.responseText;
}

function load_gp_details()
{
	var gp=document.getElementById("cboGpNo").value;
	var url='gatepassdb.php?request=load_gp_details&gp='+gp;
	var xmlhttpobj=$.ajax({url:url,async:false});
	
					var XMLserial=xmlhttpobj.responseXML.getElementsByTagName('serial');
					var XMLsize=xmlhttpobj.responseXML.getElementsByTagName('size');
					var XMLshade=xmlhttpobj.responseXML.getElementsByTagName('shade');
					var XMLbundle=xmlhttpobj.responseXML.getElementsByTagName('bundle');
					var XMLpcs=xmlhttpobj.responseXML.getElementsByTagName('pcs');
					var XMLstate=xmlhttpobj.responseXML.getElementsByTagName('status');
					deleterows("tbladdedsizes");
					var tbl=document.getElementById("tbladdedsizes");
					for (var loop=0; loop<XMLserial.length;loop++)
					{
						
							var color="#66CC00";		
							if(XMLstate[loop].childNodes[0].nodeValue==11)
							{
								color="#FE5B49";
							}
							
							if(XMLstate[loop].childNodes[0].nodeValue==2)
							{
								color="#3974FB";
							}
							
							var lastRow 		= tbl.rows.length;	
							var row 			= tbl.insertRow(lastRow);
							
							row.bgColor=color;
							
							row.onclick	= rowclickColorChangetbl;
							row.id='tblSize';
							
							var rowCell = row.insertCell(0);
							rowCell.className ="normalfnt";
							rowCell.height='20';
							rowCell.innerHTML =XMLsize[loop].childNodes[0].nodeValue;
							
							var rowCell 	  = row.insertCell(1);
							rowCell.className ="normalfnt";
							rowCell.id		  =XMLbundle[loop].childNodes[0].nodeValue;
							rowCell.innerHTML =XMLshade[loop].childNodes[0].nodeValue;
							
							var rowCell		  = row.insertCell(2);
							rowCell.className ="normalfnt";
							rowCell.id		  =XMLbundle[loop].childNodes[0].nodeValue;
							rowCell.innerHTML =XMLpcs[loop].childNodes[0].nodeValue;
																									
					}
					$(".txtbox").attr("disabled","disabled");	
}

function load_view_gp(gpyear,gpnumber)
{
	document.getElementById("cboGpNo").value=gpyear+"/"+gpnumber;
	load_gp_list();
}

function CancelGP()
{
	var gatePassNo = document.getElementById('cboGpNo').value;
	if(gatePassNo=="")
	{
		alert("Please select 'GatePass No'.");
		return;
	}
	if(!ValidateCancel(gatePassNo))
		return;
		
	var url  = 'gatepassdb.php?request=URLCancelGP';
		url += '&GatePassNo='+gatePassNo;
	htmlobj=$.ajax({url:url,async:false});
	alert("Canceled successfully.");
}

function ValidateCancel(gatePassNo)
{
	var url  = 'gatepassdb.php?request=URLValidateCancel';
		url += '&GatePassNo='+gatePassNo;
	htmlobj=$.ajax({url:url,async:false});
	var XMLValidate	= htmlobj.responseXML.getElementsByTagName('Validate');
	if(XMLValidate[0].childNodes[0].nodeValue=="FALSE")
	{
		alert("GatePass Transfer in already raised for this GatePass No.");
		return false;
	}
	return true;
}
