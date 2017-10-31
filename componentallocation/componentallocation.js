var  xmlHttp=[];

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

function	deleterows(tableName)
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
	
function getComponent()
{
	if(document.getElementById("cmbCategoryId").value!="")
	{
	var style=document.getElementById("cmbStyle").value;				
	var categoryid=document.getElementById("cmbCategoryId").value;
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=function()
		{	
			if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
						 { 			
								
									var XMLComponentId	= xmlHttp[0].responseXML.getElementsByTagName('ComponentId');
									var XMLCategory	= xmlHttp[0].responseXML.getElementsByTagName('Category');
									var XMLComponent= xmlHttp[0].responseXML.getElementsByTagName('Component');
									var XMLDescription= xmlHttp[0].responseXML.getElementsByTagName('Description');
									var tblComponent		= document.getElementById('tblComponent');
									var no	=1;
									
									deleterows('tblComponent');			
									var tblallow=document.getElementById('tblallowComp');
									for(var loop=0;loop<XMLComponentId.length;loop++)
									{
											
											var component	= XMLComponentId[loop].childNodes[0].nodeValue;
											var category	= XMLCategory[loop].childNodes[0].nodeValue;
											if(!(check_compo(tblallow,category,component)))
											continue;
											var lastRow 		= tblComponent.rows.length;	
											var row 			= tblComponent.insertRow(lastRow);
											
											if(loop % 2 ==0)
												row.className ="bcgcolor-tblrow";
											else
												row.className ="bcgcolor-tblrowWhite";			
											
											row.onclick	= rowclickColorChangetbl;
											row.id='tblComponent';							
											row.ondblclick=allocateComponent;			
											
											var rowCell = row.insertCell(0);
											rowCell.className ="normalfnt";	
											rowCell.height=20;
											rowCell.id=XMLComponentId[loop].childNodes[0].nodeValue;
											rowCell.innerHTML =XMLComponent[loop].childNodes[0].nodeValue;
											
											
											var rowCell = row.insertCell(1);
											rowCell.className ="normalfnt";
											rowCell.id=XMLCategory[loop].childNodes[0].nodeValue;
											rowCell.innerHTML =XMLDescription[loop].childNodes[0].nodeValue;
											no++;
											
									}
								
						}
				
					
		}
		xmlHttp[0].open("GET",'componentallocationdb.php?request=getData&categoryid='+categoryid+'&style='+style,true);
		xmlHttp[0].send(null);	
	}
	else
	{
		
		deleterows('tblComponent');	
	}

}

function allocateComponent()
{	

if(document.getElementById('cmbStyle').value=="")
{
	alert ('Please select the "PO Number"');
	document.getElementById('cmbStyle').focus();
	return false;
}
var tbl = document.getElementById('tblComponent');
var tblallow=document.getElementById('tblallowComp');

var highlightedrowindex = 0;
var previousrowindex = 0;
	for ( var i = 1; i < tbl.rows.length; i ++)
	{
		
		if( tbl.rows[i].className =="bcgcolor-highlighted" && i<tbl.rows.length)
				{	
	
						var style=document.getElementById("cmbStyle").value;												
						if(style!="")
							{				
								var component= tbl.rows[i].cells[0].id;
								var category= tbl.rows[i].cells[1].id;
								if(!(check_compo(tblallow,category,component)))
									continue; 
								var lastRow 		= tblallow.rows.length;	
								var row 			= tblallow.insertRow(lastRow);
								
								if(lastRow % 2 ==1)
									row.className ="bcgcolor-tblrow";
								else
									row.className ="bcgcolor-tblrowWhite";			
								
								row.onclick	= rowclickColorChangetbl;
								row.id='tblallowComp';							
								row.ondblclick=removeComponent;			
								
								var rowCell = row.insertCell(0);
								rowCell.className ="normalfnt";	
								rowCell.height=20;
								rowCell.id=component;
								rowCell.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
								
								
								var rowCell = row.insertCell(1);
								rowCell.className ="normalfnt";
								rowCell.id=category;
								rowCell.innerHTML =tbl.rows[i].cells[1].childNodes[0].nodeValue;
								
								/*createNewXMLHttpRequest(4);
								xmlHttp[4].onreadystatechange=function()
								{
											if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
											{
												getStyleComponent();
											}	
								}
								xmlHttp[4].open("GET",'componentallocationdb.php?request=saveDetail&style='+style+'&category='+category+'&component='+component,true);
								xmlHttp[4].send(null);	*/
							
							}
						
				
						if(i<tbl.rows.length-1)
						tbl.rows[i+1].className ="bcgcolor-highlighted";
						else if(i>1)
						tbl.rows[i-1].className ="bcgcolor-highlighted";
						tbl.deleteRow(i);
			
				
				}
		
	}
	/*colorSetter("tblComponent");
	colorSetter("tblallowComp");*/
	
}

function stylefilter()
{
	var buyer=document.getElementById("cmbBuyer").value;	
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
			xmlHttp[3].open("GET",'componentallocationdb.php?request=filter&buyer='+buyer,true);
			xmlHttp[3].send(null);	
		
		}else
		clearform();
		
}

function getStyleData()
{
	var Style=document.getElementById("cmbStyle").value;	
	if(Style!="")
		{				
			
			createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=function()
			{
						if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
						{
							document.getElementById("txtQty").value=xmlHttp[4].responseXML.getElementsByTagName('Qty')[0].childNodes[0].nodeValue;
							document.getElementById("txtActualQty").value=xmlHttp[4].responseXML.getElementsByTagName('Actual')[0].childNodes[0].nodeValue;
							getStyleComponent();
						}	
			}
			xmlHttp[4].open("GET",'componentallocationdb.php?request=getStyleheader&Style='+Style,true);
			xmlHttp[4].send(null);	
		
		}
	
	
		
		
}

function saveHeader()
{
	var Style=document.getElementById("cmbStyle").value;
	var actual=document.getElementById("txtActualQty").value;
	var qtypcs=document.getElementById("txtQty").value;
	if(document.getElementById("tblallowComp").rows.length<2)
	{
		alert("There is no record to save.");
		return false;
	}
	if(Style!="" && actual!="" && qtypcs!="")
		{				
			
			createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=function()
			{
						if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
						{
							alert(xmlHttp[4].responseText);
						}	
			}
			xmlHttp[4].open("GET",'componentallocationdb.php?request=saveHeader&Style='+Style+'&actual='+actual+'&qtypcs='+qtypcs,true);
			xmlHttp[4].send(null);	
		
		}else{
		alert("Please select a PO Number.");
		document.getElementById("cmbStyle").focus()
		}
		
		save_allo_details();
}

function clearform()
{
	document.getElementById("cmbStyle").value="";
	document.getElementById("txtActualQty").value="";
	document.getElementById("txtQty").value="";
		
}

function getStyleComponent()
{
	if(document.getElementById("cmbStyle").value!="")
	{
	var Style=document.getElementById("cmbStyle").value;
	createNewXMLHttpRequest(5);
	xmlHttp[5].onreadystatechange=function()
		{	
			if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
						 { 			
								
									var XMLComponentId	= xmlHttp[5].responseXML.getElementsByTagName('ComponentId');
									var XMLCategory	= xmlHttp[5].responseXML.getElementsByTagName('Category');
									var XMLComponent= xmlHttp[5].responseXML.getElementsByTagName('Component');
									var XMLDescription= xmlHttp[5].responseXML.getElementsByTagName('Description');
									var tblComponent		= document.getElementById('tblallowComp');
									var no	=1;
									
									deleterows('tblallowComp');			
									
							for(var loop=0;loop<XMLComponentId.length;loop++)
												{
														var lastRow 		= tblComponent.rows.length;	
														var row 			= tblComponent.insertRow(lastRow);
														
														if(loop % 2 ==0)
															row.className ="bcgcolor-tblrow";
														else
															row.className ="bcgcolor-tblrowWhite";			
														
														row.onclick	= rowclickColorChangetbl;
														row.id='tblallowComp';
														row.ondblclick=removeComponent;
																									
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfnt";
														rowCell.height=20;
														rowCell.id=XMLComponentId[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =XMLComponent[loop].childNodes[0].nodeValue;
														
														
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfnt";
														rowCell.id=XMLCategory[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =XMLDescription[loop].childNodes[0].nodeValue;
														no++;
														
												}
								
					}
				
					
	}
		xmlHttp[5].open("GET",'componentallocationdb.php?request=getStyleCutData&Style='+Style,true);
		xmlHttp[5].send(null);	 
		set_Buyer();
}
else 
deleterows('tblallowComp');			

}

function removeComponent()
{	


		var tblallow = document.getElementById('tblComponent');
		var tbl =document.getElementById('tblallowComp');
		var highlightedrowindex = 0;
		var previousrowindex = 0;
		
	for ( var i = 1; i < tbl.rows.length; i ++)
	{
		
		if( tbl.rows[i].className =="bcgcolor-highlighted" && i<tbl.rows.length)
				{	
	
						var style=document.getElementById("cmbStyle").value;												
						if(style!="")
							{				
								var component= tbl.rows[i].cells[0].id;
								var category= tbl.rows[i].cells[1].id;
								var lastRow 		= tblallow.rows.length;	
								var row 			= tblallow.insertRow(lastRow);
								
								if(lastRow % 2 ==1)
									row.className ="bcgcolor-tblrow";
								else
									row.className ="bcgcolor-tblrowWhite";			
								
								row.onclick	= rowclickColorChangetbl;
								row.id='tblComponent';							
								row.ondblclick=allocateComponent;			
								
								var rowCell = row.insertCell(0);
								rowCell.className ="normalfnt";	
								rowCell.height=20;
								rowCell.id=component;
								rowCell.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
								
								
								var rowCell = row.insertCell(1);
								rowCell.className ="normalfnt";
								rowCell.id=category;
								rowCell.innerHTML =tbl.rows[i].cells[1].childNodes[0].nodeValue;
								/*createNewXMLHttpRequest(7);
								xmlHttp[7].onreadystatechange=function()
								{
											if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
											{
												getComponent();
											}	
								}
								xmlHttp[7].open("GET",'componentallocationdb.php?request=deleteDetail&style='+style+'&category='+category+'&component='+component,true);
								xmlHttp[7].send(null);*/	
							
							}
						
				
						if(i<tbl.rows.length-1)
						tbl.rows[i+1].className ="bcgcolor-highlighted";
						else if(i>1)
						tbl.rows[i-1].className ="bcgcolor-highlighted";
						tbl.deleteRow(i);			
				
				}
		
	}
	/*colorSetter("tblComponent");
	colorSetter("tblallowComp");*/
	
}

function allocate_all_Component()
{	
	
	if(document.getElementById('cmbStyle').value=="")
	{
		alert ('Please select the "PO Number"');
		document.getElementById('cmbStyle').focus();
		return false;
	}
	var style=document.getElementById("cmbStyle").value;												
	if(style!="")
		{		
	
			var tbl = document.getElementById('tblComponent');
			var tblallow=document.getElementById('tblallowComp');
			var highlightedrowindex = 0;
			var previousrowindex = 0;
			for ( var i = 1; i < tbl.rows.length; i ++)
				{					
											
					var component= tbl.rows[i].cells[0].id;
					var category= tbl.rows[i].cells[1].id;
					if(!(check_compo(tblallow,category,component)))
							continue; 
					var lastRow 		= tblallow.rows.length;	
					var row 			= tblallow.insertRow(lastRow);
					
					if(lastRow % 2 ==1)
						row.className ="bcgcolor-tblrow";
					else
						row.className ="bcgcolor-tblrowWhite";			
					
					row.onclick	= rowclickColorChangetbl;
					row.id='tblallowComp';							
					row.ondblclick=removeComponent;			
					
					var rowCell = row.insertCell(0);
					rowCell.className ="normalfnt";	
					rowCell.height=20;
					rowCell.id=component;
					rowCell.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
					
					
					var rowCell = row.insertCell(1);
					rowCell.className ="normalfnt";
					rowCell.id=category;
					rowCell.innerHTML =tbl.rows[i].cells[1].childNodes[0].nodeValue;
											/*createNewXMLHttpRequest(8);
											xmlHttp[8].onreadystatechange=function()
											{
														if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200)
														{
															getStyleComponent();
														}	
											}
											xmlHttp[8].open("GET",'componentallocationdb.php?request=saveDetail&style='+style+'&category='+category+'&component='+component,true);
											xmlHttp[8].send(null);	*/
										
										
									
							
									//tbl.deleteRow(i);
						
							
							
					
				}
		 deleterows('tblComponent');	
		}
	
}

function remove_all_Component()
{	
	var style=document.getElementById("cmbStyle").value;												
	if(style!="")
		{		
	
			var tblallow = document.getElementById('tblComponent');
			var tbl =document.getElementById('tblallowComp');
			var highlightedrowindex = 0;
			var previousrowindex = 0;
		for ( var i = 1; i < tbl.rows.length; i ++)
				{
								var component= tbl.rows[i].cells[0].id;
								var category= tbl.rows[i].cells[1].id;
								var lastRow 		= tblallow.rows.length;	
								var row 			= tblallow.insertRow(lastRow);
								
								if(lastRow % 2 ==1)
									row.className ="bcgcolor-tblrow";
								else
									row.className ="bcgcolor-tblrowWhite";			
								
								row.onclick	= rowclickColorChangetbl;
								row.id='tblComponent';							
								row.ondblclick=allocateComponent;			
								
								var rowCell = row.insertCell(0);
								rowCell.className ="normalfnt";	
								rowCell.height=20;
								rowCell.id=component;
								rowCell.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
								
								
								var rowCell = row.insertCell(1);
								rowCell.className ="normalfnt";
								rowCell.id=category;
								rowCell.innerHTML =tbl.rows[i].cells[1].childNodes[0].nodeValue;
											
											/*var component= tbl.rows[i].cells[0].id;
											var category= tbl.rows[i].cells[1].id;
											createNewXMLHttpRequest(9);
											xmlHttp[9].onreadystatechange=function()
											{
														if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
														{
															getComponent();
														}	
											}
											xmlHttp[9].open("GET",'componentallocationdb.php?request=deleteDetail&style='+style+'&category='+category+'&component='+component,true);
											xmlHttp[9].send(null);	*/						
						
							
							
					
				}
		 deleterows('tblallowComp');	
		}
	
}
 
function form_clear()
{

	document.getElementById("cmbStyle").value="";
	document.getElementById("txtActualQty").value="";
	document.getElementById("txtQty").value="";
	document.getElementById("cmbBuyer").value="";
	document.getElementById("cmbCategoryId").value="";
	deleterows('tblComponent');
	deleterows('tblallowComp');

}

function delete_style_allo()
{	if(document.getElementById("cmbStyle").value!="")
	alert("Sorry, you cannot delete this allocation.");
}

function set_Buyer()
{
	var style=document.getElementById("cmbStyle").value;
	document.getElementById("cmbBuyer").value=""
	var url='componentallocationdb.php?request=get_style_buyer&style='+style;
	var xmlhttpobj=$.ajax({url:url,async:false});
	document.getElementById("cmbBuyer").value=xmlhttpobj.responseText;
}

function save_allo_details()
{
	del_first();
	var style		=document.getElementById("cmbStyle").value;
	var check_tbl	=document.getElementById("tblallowComp");
	for(var loop=1;loop<check_tbl.rows.length;loop++)
	{
					
					var component	= check_tbl.rows[loop].cells[0].id;
					var category 	= check_tbl.rows[loop].cells[1].id;
					
		var url		="componentallocationdb.php?request=saveDetail&style="+style+"&category="+category+"&component="+component;
		var http_obj=$.ajax({url:url,async:false})
	}
	
}

function check_compo(tbl,cat,com)
{
	//alert(tbl);
	//alert(cat+"/"+com);
	
	var check_tbl=tbl;
	for(var loop=1;loop<check_tbl.rows.length;loop++)
	{
					
					var component	= check_tbl.rows[loop].cells[0].id;
					var category 	= check_tbl.rows[loop].cells[1].id;
					
		if(component==com && category==cat)
		{
			return false;	
		}
		
	}
		return true;
}

function del_first()
{
		var style		=document.getElementById("cmbStyle").value;
		var url		    ="componentallocationdb.php?request=del_first&style="+style;
		var http_obj=$.ajax({url:url,async:false})
}