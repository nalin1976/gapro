//MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMcommonMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
var  xmlHttp=[];
var pub_records=0;
var pub_response_count=0;
var number_range=0;
var pub_total_quantity=0;
var pub_bundle_no=0;
var verify_count=0;

var array_component		=[];
var array_category		=[];
var array_componentid   =[];

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
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function colorSetter(tablez)
{
	
	
	var tbl = document.getElementById(tablez);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
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
									var opt 		= document.createElement("option");
									opt.text 	= XMLstylename[loop].childNodes[0].nodeValue;
									opt.value 	= XMLstyleno[loop].childNodes[0].nodeValue;
									document.getElementById("cmbStyle").options.add(opt);
							}
						}	
			}
			xmlHttp[3].open("GET",'cutDeffectdb.php?request=filter&buyer='+buyer,true);
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
							var tbl=document.getElementById("tblCutNo");
							deleterows("tblCutNo");
							for (var loop=0; loop<XMLserial.length;loop++)
							{
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
														
														if(loop % 2 ==0)
															row.className ="even";				
														else
															row.className ="odd";
														
														row.onclick	= rowclickColorChangetbl;
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
			xmlHttp[4].open("GET",'cutDeffectdb.php?request=getcutz&Style='+Style,true);
			xmlHttp[4].send(null);	
			
			
		}	
		
}

function loadsizes(dz)
{	
	var serial=dz.id;
	var cutno=dz.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
	if(serial!="" && dz.checked==true)
		{	set_component_array();
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
							var tbl=document.getElementById("tblSize");
							for (var loop=0; loop<XMLserial.length;loop++)
							{
														var lastRow 		= tbl.rows.length;	
														var row 			= tbl.insertRow(lastRow);
														
														if(loop % 2 ==1)
															row.className ="bcgcolor-tblrowWhite";				
														else
															row.className ="bcgcolor-tblrow";
														//row.ondblclick=add_to_grid_o_b_o;
														row.onclick	= rowclickColorChangetbl;
														row.id='tblSize';
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfnt";
														rowCell.id=serial;
														rowCell.height='20';
														rowCell.innerHTML =cutno;
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfnt";
														rowCell.id=XMLbundle[loop].childNodes[0].nodeValue;;
														rowCell.innerHTML =XMLsize[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfntRite";
														rowCell.id=XMLpcs[loop].childNodes[0].nodeValue;;
														rowCell.innerHTML =XMLshade[loop].childNodes[0].nodeValue;
														
														var rowCell = row.insertCell(3);
														rowCell.className ="normalfntMid";			
														rowCell.innerHTML ="<input type=\"checkbox\"onchange=\"loadcomponent(this)\"class=\"txtbox\"id=\"\"/>";
																											
							}
						}	
			}
			xmlHttp[5].open("GET",'cutDeffectdb.php?request=getsizes&serial='+serial,true);
			xmlHttp[5].send(null);	
			
			
		}	
		else
		{
		remove_selected(serial);remove_selected_sizes(serial);}
}

function set_component_array()
{
	var style=document.getElementById("cmbStyle").value;
	var url	 ='cutDeffectdb.php?request=getcomponents&style='+style;
	htmlobj=$.ajax({url:url,async:false});
	var XMLcomponentId	=htmlobj.responseXML.getElementsByTagName('componentid');
	var XMLcomponent	=htmlobj.responseXML.getElementsByTagName('component');
	var XMLcatid		=htmlobj.responseXML.getElementsByTagName('catid');
	for(var loop=0;loop<XMLcomponentId.length;loop++)
	{
			
			array_component[loop]		=XMLcomponent[loop].childNodes[0].nodeValue;
			array_category[loop]		=XMLcatid[loop].childNodes[0].nodeValue;
			array_componentid[loop]     =XMLcomponentId[loop].childNodes[0].nodeValue;
	}
	
}

function remove_selected(siz)
{
	var tbl=document.getElementById("tblSize");
	for ( var i =tbl.rows.length; i > 1; i --)
	{
		if(tbl.rows[i-1].cells[0].id==siz)
		{
				tbl.deleteRow(i-1);
		}
		
	}
}

function remove_selected_sizes(siz)
{
	var tbl=document.getElementById("tblComponent");
	for ( var i =tbl.rows.length; i > 1; i --)
	{
		if(tbl.rows[i-1].cells[0].id==siz)
		{
				tbl.deleteRow(i-1);
		}
		
	}
}

function loadcomponent(obj)
{
		var serial=obj.parentNode.parentNode.cells[0].id;
		var bundle=obj.parentNode.parentNode.cells[1].id;
		var cutno=obj.parentNode.parentNode.cells[0].childNodes[0].nodeValue;
		var size =obj.parentNode.parentNode.cells[1].childNodes[0].nodeValue;
		var shade=obj.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
		var pcs=obj.parentNode.parentNode.cells[2].id;
	
	if(obj.checked==true)
	{
		
		var tbl=document.getElementById("tblComponent");
		for(var loop=0;loop<array_component.length;loop++)
			{
					var lastRow 		= tbl.rows.length;	
					var row 			= tbl.insertRow(lastRow);
					
					if(loop % 2 ==0)
						row.className ="even";				
					else
						row.className ="odd";
					
					row.onclick	= rowclickColorChangetbl;
					row.id='tblCutNo';
					
					var rowCell = row.insertCell(0);
					rowCell.className ="normalfnt";
					rowCell.height='20';
					rowCell.id=serial;
					rowCell.innerHTML =cutno;
					
					var rowCell = row.insertCell(1);
					rowCell.className ="normalfntRite";
					rowCell.id=bundle;
					rowCell.innerHTML =size;			
					
					var rowCell = row.insertCell(2);
					rowCell.className ="normalfntMid";
					rowCell.id=array_category[loop];	
					rowCell.innerHTML =shade;			 

					var rowCell = row.insertCell(3);
					rowCell.className ="normalfnt";	
					rowCell.id=array_componentid[loop];	
					rowCell.innerHTML =array_component[loop];	
					
					var rowCell = row.insertCell(4);
					rowCell.className ="normalfntRite";			
					rowCell.innerHTML =pcs;	
					
					var rowCell = row.insertCell(5);
					rowCell.className ="normalfntRite";			
					rowCell.innerHTML ="<input type=\"text\"style=\"width:80px;text-align:right\"class=\"txtbox\"/>";	
					
					var rowCell = row.insertCell(6);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML ="<input type=\"checkbox\"class=\"txtbox\"/>";
					
				
			}
	
	}else remove_selected_components(bundle);
		
}


function remove_selected_components(obj)
{
	var tbl=document.getElementById("tblComponent");
	for ( var i =tbl.rows.length; i > 1; i --)
	{
		if(tbl.rows[i-1].cells[1].id==obj)
		{
				tbl.deleteRow(i-1);
		}
		
	}
}

function saveHeader()
{
	if(document.getElementById("cboFactory").value=="")
	{
		alert('Please select the "Factory"');
		document.getElementById("cboFactory").focus();
		return false;
	}
	
	//var gpnumber=document.getElementById("cboSerial").value;
	var Styleno=document.getElementById("cmbStyle").value;
	var factory=document.getElementById("cboFactory").value;
	var defectdate=document.getElementById("txtCutDate").value;
	var stage=document.getElementById("cmbStage").value;
	//var totqty=calsum();
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
	
	xmlHttp[6].open("GET",'cutDeffectdb.php?request=saveheader&Styleno='+Styleno+'&factory='+factory+'&defectdate='+defectdate+'&stage='+stage,true);
	xmlHttp[6].send(null);	
}

function saveDetail(serial)
{
		var tbl=document.getElementById("tblComponent");
		for(var loop=1;loop<tbl.rows.length;loop++)	
		{
			
			if(tbl.rows[loop].cells[6].childNodes[0].checked==true)
				{
					
					var bundleserial=tbl.rows[loop].cells[0].id;
					var bundle=tbl.rows[loop].cells[1].id;
					var defect_qty=tbl.rows[loop].cells[5].childNodes[0].value;
					var cat_id=tbl.rows[loop].cells[2].id;
					var component_id=tbl.rows[loop].cells[3].id;
					var url='cutDeffectdb.php?request=savedetail&bundleserial='+bundleserial+'&bundle='+bundle+'&defect_qty='+defect_qty+'&cat_id='+cat_id+'&component_id='+component_id+'&serial='+serial;
					xmlhttpobj=$.ajax({url:url,async:false});
						
				
				}
		}hideBackGroundBalck();
		loadCombo("select concat(intDefectYear,\"/\",intDefectSerial) as serialno,concat(intDefectYear,\" -->\",intDefectSerial) as serialtext from productiondefectheader","cboSerial");
		alert("Saved successfully!");
}



/*function addAllSizestoGrid()
{
		
	var tbl=document.getElementById("tblSize");
	var stbl=document.getElementById("tbladdedsizes");
	
	for (var loop=1; loop<tbl.rows.length;loop++)
							{
								
							var lastRow 		= stbl.rows.length;	
							var row 			= stbl.insertRow(lastRow);
							
							if(loop % 2 ==0)
								row.className ="bcgcolor-tblrowWhite";				
							else
								row.className ="bcgcolor-tblrow";
							
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
			deleterows("tblSize");				
}





function saveDetail(gpno)
{
		var tofactory=document.getElementById("cboToFactory").value;
		var gpnumber=gpno;
		var stbl=document.getElementById("tbladdedsizes");
		for(var loop=1;loop<stbl.rows.length;loop++)
			{	var serial=stbl.rows[loop].cells[0].id;
				var cutno=stbl.rows[loop].cells[1].id;
				createNewXMLHttpRequest(7);
				xmlHttp[7].onreadystatechange=function()
						{
									if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
									{	
										
										
									}
						}
						
				xmlHttp[7].open("GET",'cutDeffectdb.php?request=savedetail&serial='+serial+'&gpnumber='+gpnumber+'&cutno='+cutno+'&tofactory='+tofactory,true);
				xmlHttp[7].send(null);	
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
			xmlHttp[8].open("GET",'cutDeffectdb.php?request=loadfact&factype='+factype,true);
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
	xmlHttp[6].open("GET",'cutDeffectdb.php?request=tofac&tofactory='+tofactory,true);
	xmlHttp[6].send(null);	
}

function save_verify(gpno)
{
	var pubrecords=document.getElementById("tbladdedsizes").rows.length-1;
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
											loadCombo( "select intGPnumber, intGPnumber as Year from productiongpheader ","cboGpNo");
											document.getElementById("cboGpNo").value=gpno;
											}
									else if(verify_count>=5){
									alert("Error: Problem occurred while saving.");hideBackGroundBalck();}
									else 
										{	verify_count+=1;setTimeout("save_verify()",10000);}
									
								}	
			}
	xmlHttp[8].open("GET",'cutDeffectdb.php?request=saveVerify&pub_records='+pubrecords+'&gpnumber='+gpno,true);
	xmlHttp[8].send(null);	
}

function add_to_grid_o_b_o()
{
	var frmtbl=document.getElementById("tblSize");
	var totbl=document.getElementById("tbladdedsizes");
	for ( var i = 1; i < frmtbl.rows.length; i ++)
	{		
		if(frmtbl.rows[i].className =="bcgcolor-highlighted" && i<frmtbl.rows.length)
		{							
									
									var lastRow 		= totbl.rows.length;	
									var row 			= totbl.insertRow(lastRow);
									
									if(lastRow % 2 ==0)
										row.className ="bcgcolor-tblrowWhite";				
									else
										row.className ="bcgcolor-tblrow";
									
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
									
									if(i<frmtbl.rows.length-1)
											frmtbl.rows[i+1].className ="bcgcolor-highlighted";
										else if(i>1)
											frmtbl.rows[i-1].className ="bcgcolor-highlighted";
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
									
									if(lastRow % 2 ==0)
										row.className ="bcgcolor-tblrowWhite";				
									else
										row.className ="bcgcolor-tblrow";
									
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
									
									if(i<frmtbl.rows.length-1)
											frmtbl.rows[i+1].className ="bcgcolor-highlighted";
										else if(i>1)
											frmtbl.rows[i-1].className ="bcgcolor-highlighted";
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
							
							if(loop % 2 ==0)
								row.className ="bcgcolor-tblrowWhite";				
							else
								row.className ="bcgcolor-tblrow";
							
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
			deleterows("tbladdedsizes");				
}

function print_gp()
{
	var gpno=document.getElementById("cboGpNo").value;
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
}*/