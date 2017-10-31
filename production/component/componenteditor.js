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
	var tbl = document.getElementById('tblComponent');
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

		

function getComponent()
{
	if(document.getElementById("cmbCategoryId").value!="")
	{
	var categoryid=document.getElementById("cmbCategoryId").value
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
					
							for(var loop=0;loop<XMLComponentId.length;loop++)
												{
														var lastRow 		= tblComponent.rows.length;	
														var row 			= tblComponent.insertRow(lastRow);
														
														if(loop % 2 ==0)
															row.className ="bcgcolor-tblrow";
														else
															row.className ="bcgcolor-tblrowWhite";			
														
														row.onclick	= rowclickColorChangetbl;
														
														
														var rowCell = row.insertCell(0);
														rowCell.className ="normalfntMid";	
														rowCell.align="center";
														rowCell.height=20;
														rowCell.innerHTML =	"<img src=\"../../images/del.png\"  class=\"mouseover\" onclick=\"delete_componenet(this);\" />";													
														var rowCell = row.insertCell(1);
														rowCell.className ="normalfntMid";	
														rowCell.align="center";
														rowCell.height=20;
														rowCell.innerHTML =	"<img src=\"../../images/edit.png\"  class=\"mouseover\" onclick=\"edit_componenet(this);\" />";													
														
														var rowCell = row.insertCell(2);
														rowCell.className ="normalfnt";	
														rowCell.id=XMLComponentId[loop].childNodes[0].nodeValue;
														rowCell.innerHTML =(XMLComponent[loop].childNodes[0].nodeValue==""?"-":cdata(XMLComponent[loop].childNodes[0].nodeValue));
														
														
														var rowCell = row.insertCell(3);
														rowCell.className ="normalfnt";			
														rowCell.innerHTML =(XMLDescription[loop].childNodes[0].nodeValue==""?"-":cdata(XMLDescription[loop].childNodes[0].nodeValue));
														no++;
												}
								
					}
				
					
	}
		xmlHttp[0].open("GET",'componenteditordb.php?request=getData&categoryid='+categoryid,true);
		xmlHttp[0].send(null);	
}
else
	{
		deleterows('tblComponent');	
		document.getElementById("hiddn_componentid").value=""
		document.getElementById("txtComponent").value="";
		document.getElementById("txtDescription").value="";
	}
}


function saveComponent()
{
	
	
	var categoryid=document.getElementById("cmbCategoryId").value;
	if(categoryid.trim()=="")
	{
		alert("Please select a Category.");
		document.getElementById("cmbCategoryId").focus();
		return false;
	}
	///////////////////////check db
	
	/////////////////////
	var componentid=document.getElementById("hiddn_componentid").value;
	var component	=document.getElementById("txtComponent").value;
	var description	=document.getElementById("txtDescription").value;
	description		=(description==""?'n/a':description);
		
	if(component.trim()=="")
	{
		alert("Please enter Component.");
		document.getElementById("txtComponent").focus();
		return false;
	}
	
	
	var check_com=check_component()
	if(check_com!=-999)
	{
		alert('This component already exist under the category "'+check_com+'".')
		document.getElementById("txtComponent").focus();
		return false;
	}
	
	/*var id = categoryid;
	var name = document.getElementById("txtComponent").value;

	var x_find = checkInField('cutting_component','strComponent',name,'intCategory',id);
	if(x_find)
	{
		alert(name+" is already exist.");	
		document.getElementById("txtComponent").focus();
		return false;
	}	*/
	
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
		{	
			if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
			{	document.getElementById("hiddn_componentid").value=""
				document.getElementById("txtComponent").value="";
				document.getElementById("txtDescription").value="";
				getComponent();
				document.getElementById("txtComponent").focus();
			}
		}
		
	xmlHttp[1].open("GET",'componenteditordb.php?request=saveData&categoryid='+categoryid+'&componentid='+componentid+'&description='+URLEncode(description)+'&component='+URLEncode(component),true);
	xmlHttp[1].send(null);	
	
}

function saveCategory()
{
	var new_category=prompt("Please enter a new Category","New Category");
	if (!new_category)
		return false;
	else if(new_category.trim()==""){saveCategory();return false;}
	else dosavecategory(new_category);
}

function dosavecategory()
{
	
	var catid=document.getElementById("cmbPopCategoryId").value;
	var category=document.getElementById("txPoptCategory").value;
	var cat_description=document.getElementById("txtPopDscr").value;
	if(category.trim()=="")
	{
		alert("Please enter a Category.");
		document.getElementById("txPoptCategory").focus();
		return false;
	}
	
	var id = document.getElementById("cmbPopCategoryId").value
	var name = document.getElementById("txPoptCategory").value
		
	var check_cat=check_category()
	if(check_cat!=-999)
	{
			alert('"'+name+'" already exist.');	
			document.getElementById("txPoptCategory").focus();
			return false;
	}
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=function()
		{	if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
			{
				alert("Saved successfully.");
				document.getElementById("cmbPopCategoryId").value="";
				document.getElementById("txPoptCategory").value="";
				document.getElementById("txtPopDscr").value="";
				loadCombo('select 	intCategoryNo, strCategory from component_category where intStatus=1 order by strCategory','cmbPopCategoryId');
	
			}
		}
	
	xmlHttp[2].open("GET",'componenteditordb.php?request=saveCat&category='+URLEncode(category)+'&catid='+catid+'&cat_description='+cat_description,true);
	xmlHttp[2].send(null);	
		
	
}

function delete_componenet(dz)
{
	var component=dz.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	var componentid=dz.parentNode.parentNode.cells[2].id;
	var category=document.getElementById("cmbCategoryId").value;
	if(confirm("Are you sure you want to delete \n"+component+" ?"))
	{
		
	createNewXMLHttpRequest(3);
	xmlHttp[3].onreadystatechange=function()
		{	
			if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
			{	document.getElementById("hiddn_componentid").value=""
				document.getElementById("txtComponent").value="";
				document.getElementById("txtDescription").value="";
				getComponent();
			}
		}
		
	xmlHttp[3].open("GET",'componenteditordb.php?request=delete_component&categoryid='+category+'&componentid='+componentid,true);
	xmlHttp[3].send(null);	
		
	}
	
}

function edit_componenet(dz)
{
	//alert(dz.parentNode.parentNode.cells[2].childNodes[0].nodeValue);
	document.getElementById("txtComponent").value=dz.parentNode.parentNode.cells[2].childNodes[0].nodeValue;
	document.getElementById("txtDescription").value=dz.parentNode.parentNode.cells[3].childNodes[0].nodeValue;
	document.getElementById("hiddn_componentid").value=dz.parentNode.parentNode.cells[2].id;
}

function edit_category()
{
	createNewXMLHttpRequest(4);
	xmlHttp[4].onreadystatechange=function()
		{	
			if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
			{
				drawPopupArea(450,200,'frmCategory')
				document.getElementById("frmCategory").innerHTML=xmlHttp[4].responseText;
			}
			
			
		}
		
	xmlHttp[4].open("GET",'popcategory.php',true);
	xmlHttp[4].send(null);		
}

function close_pop()
{
	closeWindow();	
	loadCombo('select 	intCategoryNo, strCategory from component_category where intStatus=1 order by strCategory','cmbCategoryId');
	
}


function getCategory()
{
	var catid=document.getElementById("cmbPopCategoryId").value;
	if(catid=="")
	{
		clear_pop()
		return;
	}
	createNewXMLHttpRequest(5);
	xmlHttp[5].onreadystatechange=function()
		{	
			if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
						 { 			
						 	document.getElementById("txPoptCategory").value=xmlHttp[5].responseXML.getElementsByTagName('Category')[0].childNodes[0].nodeValue;
							document.getElementById("txtPopDscr").value=xmlHttp[5].responseXML.getElementsByTagName('Description')[0].childNodes[0].nodeValue;;
						 }
		}
	xmlHttp[5].open("GET",'componenteditordb.php?request=get_category&catid='+catid,true);
	xmlHttp[5].send(null);		
}

function delete_category()
{	
	
	var category=document.getElementById("txPoptCategory").value;
	var catid	=document.getElementById("cmbPopCategoryId").value;	
	
	if(catid!="")
	{
		if(confirm("Are you sure you want to delete \n"+category+" ?"))
		{
			createNewXMLHttpRequest(6);
			xmlHttp[6].onreadystatechange=function()
			{
				if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
				{
					alert("Deleted successfully.");
					document.getElementById("cmbPopCategoryId").value="";
					document.getElementById("txPoptCategory").value="";
					document.getElementById("txtPopDscr").value="";
					loadCombo('select 	intCategoryNo, strCategory from component_category where intStatus=1 order by strCategory','cmbPopCategoryId');
				}
				
			}
			xmlHttp[6].open("GET",'componenteditordb.php?request=delete_category&categoryid='+catid,true);
			xmlHttp[6].send(null);	
			
		}
	}
}

function clear_forms()
{	
	document.getElementById("hiddn_componentid").value=""
	document.getElementById("txtComponent").value="";
	document.getElementById("cmbCategoryId").value="";
	document.getElementById("txtDescription").value="";
	deleterows('tblComponent');	
	document.getElementById("cmbCategoryId").focus();
}

function save_all()
{
	if(document.getElementById('tblComponent').rows.length<=1)
	{
		alert("There is no record to save.");
		return;	
	}	
	alert("Saved successfully.");
}

function mainfrm_delete()
{
		
	var catid	=document.getElementById("cmbCategoryId").value;
	var category	=document.getElementById("cmbCategoryId").options[document.getElementById("cmbCategoryId").selectedIndex].text;	
	
	if(catid!="")
	{
		if(confirm("Are you sure you want to delete \n"+category+" ?"))
		{
			createNewXMLHttpRequest(7);
			xmlHttp[7].onreadystatechange=function()
			{
				if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
				{
					alert("Deleted successfully.");
					deleterows('tblComponent');
					loadCombo('select 	intCategoryNo, strCategory from component_category where intStatus=1 order by strCategory','cmbCategoryId');
					clear_forms();
				}
				
			}
			xmlHttp[7].open("GET",'componenteditordb.php?request=delete_category&categoryid='+catid,true);
			xmlHttp[7].send(null);	
			
		}
	}
	
}

function clear_pop()
{	
	document.getElementById("cmbPopCategoryId").value="";
	document.getElementById("txPoptCategory").value="";
	document.getElementById("txtPopDscr").value="";
	document.getElementById("txPoptCategory").focus();
}

function check_component()
{
	var componentid=document.getElementById("hiddn_componentid").value;
	var component	=document.getElementById("txtComponent").value;
	var url='componenteditordb.php?request=check_component&component='+URLEncode(component.trim())+'&componentid='+componentid;
	var http_obj=$.ajax({url:url,async:false})
	return http_obj.responseText;
}

function check_category()
{
	var category=document.getElementById("txPoptCategory").value;
	var categoryid=document.getElementById("cmbPopCategoryId").value;
	var url='componenteditordb.php?request=check_category&category='+URLEncode(category.trim())+'&categoryid='+URLEncode(categoryid.trim());
	var http_obj=$.ajax({url:url,async:false})
	return http_obj.responseText;
}