// JavaScript Document

var cnt=0;

function loadOrders()
{
	var styleName=$("#txtStyle option:selected").text();
	
	//alert(document.getElementById('txtStyle').value);
	
	var url = "measurementAllocation-db-get.php?requestType=loadOders&stylename="+styleName;
	
	var resText = $.ajax({url:url,async:false});
	
	document.getElementById('orderNo').innerHTML = resText.responseText;
}



function selectOperator()
{	
	var url  = "measurementAllocation-Popup.php?";
	//inc('../country/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closePopUp";
	var tdPopUpClose = "size_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	

}


function selectSize()
{	
	
	var styleid   = document.getElementById('orderNo').value;
	var GridTable = document.getElementById('dataGrid');
	var str = "";
	
	for(var r=3;r<GridTable.rows[1].cells.length;r++)
	{
		str+=GridTable.rows[1].cells[r].innerHTML+",";
	}
	
	var url  = "measurementAllocationSize.php?StyleID="+styleid+"&str="+str;
	
	var W	= 0;
	var H	= 258;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closePopUp";
	var tdPopUpClose = "measurement_allocation_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	

}


function closePopUp(id)
{
	closePopUpArea(id);
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function loadDataToGrid(id)
{
	var url 	      ="measurementAllocation-db-get.php?requestType=loadGrid&id="+id;
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	var XMLDescription = xmlhttp_obj.responseXML.getElementsByTagName("Description");
	//var tablength    = GridTable.rows[1].cells.length;
	var GridTable=document.getElementById('dataGrid');
	var tablength    = GridTable.rows[1].cells.length;

		if(GridTable.rows.length==2)
		{
			var newRow       		 = GridTable.insertRow(GridTable.rows.length);
			//alert("sdsd");
			
			//newRow.className	     = "grid_header";
			var newCellSize1          = newRow.insertCell(0);
			newCellSize1.className	 = "grid_header";
			newCellSize1.innerHTML    = "<td width='10'><img src='../../images/del.png' name='deleteBut' id='butDel' class='mouseover' onclick='deleteGridRow(this);'/></td>";
			
			var newCellSize          = newRow.insertCell(1);
			newCellSize.className	 = "grid_header";
			newCellSize.innerHTML    = id;
			
			var newCellSize2         = newRow.insertCell(2);
			newCellSize2.className	 = "grid_header"; 
			newCellSize2.innerHTML   = XMLDescription[0].childNodes[0].nodeValue;
			
			createTextForGrid2();
		}
		
		else
		{
			var cnt1=0;
			for(var x=1;x<GridTable.rows.length;x++)
			{
				//alert(GridTable.rows[x].cells[0].childNodes[0].nodeValue);
				if(id==GridTable.rows[x].cells[1].childNodes[0].nodeValue)
					cnt1=cnt1+1;
			}
			
			if(cnt1>0)
			{
				alert("Only one item can be added!!!!");
			}
			else if(cnt1==0)
			{
				
				var newRow       		   = GridTable.insertRow(GridTable.rows.length);
				var newCellSize1           = newRow.insertCell(0);
			newCellSize1.className	       = "grid_header";
			newCellSize1.innerHTML         = "<td width='10'><img src='../../images/del.png' name='deleteBut' id='butDel' class='mouseover' onclick='deleteGridRow(this);' /></td>";
				
				
				var newCellSize            = newRow.insertCell(1);
				newCellSize.className	   = "grid_header";
				newCellSize.innerHTML      = id;
				
				var newCellSize2            = newRow.insertCell(2);
				newCellSize2.className	    = "grid_header";
				newCellSize2.innerHTML      = XMLDescription[0].childNodes[0].nodeValue;
				
				createTextForGrid2();
			}
		}
		
		
		
}


function MoveItemRight()
{
	var sizes = document.getElementById("cbosizes");
	if(sizes.selectedIndex <= -1) return;
	var selectedSize = sizes.options[sizes.selectedIndex].text;
	if (!CheckitemAvailability(selectedSize,document.getElementById("cboAvailable"),true))
	{
		var optSizes = document.createElement("option");
		//change1
		optSizes.value ="";
		//optColor.value = colors.options[colors.selectedIndex].value;
		//change1
		optSizes.text = sizes.options[sizes.selectedIndex].value;
		//optColor.text = selectedColor;
		document.getElementById("cboAvailable").options.add(optSizes);
		sizes.options[sizes.selectedIndex] = null;
	}
}




function MoveAllItemsRight()
{
	var sizes = document.getElementById("cbosizes");
	for(var i = 0; i < sizes.options.length ; i++) 
	{
		if(!CheckitemAvailability(sizes.options[i].text,document.getElementById("cboAvailable"),false))
		{
			var optSize = document.createElement("option");
			optSize.text = sizes.options[i].text;
			optSize.value = sizes.options[i].value;
			document.getElementById("cboAvailable").options.add(optSize);
		}
	}
	RemoveLeftSizes();
	
}


function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text == itemName)
		{
			if (message)
				alert("The property " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}


function RemoveLeftSizes()
{
	var index = document.getElementById("cbosizes").options.length;
	while(document.getElementById("cbosizes").options.length > 0) 
	{
		index --;
		document.getElementById("cbosizes").options[index] = null;
	}
}


function MoveItemUp(){
	if(document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].length == 0)
	{
	 return false;	
	}
	var cboAvailable = document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].text;
	var optionIndex = document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].index;
	document.getElementById('cboAvailable').options[optionIndex].text = document.getElementById('cboAvailable').options[optionIndex-1].text;
	document.getElementById('cboAvailable').options[optionIndex].value = document.getElementById('cboAvailable').options[optionIndex-1].text;
	document.getElementById('cboAvailable').options[optionIndex-1].text = cboAvailable;
	document.getElementById('cboAvailable').options[optionIndex-1].value = cboAvailable;
	document.getElementById('cboAvailable').options[optionIndex-1].selected = true;	
}


function MoveItemDown(){
	if(document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].length == 0)
	{
	 return false;	
	}
	var cboAvailable = document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].text;
	var optionIndex = document.getElementById('cboAvailable').options[document.getElementById('cboAvailable').selectedIndex].index;
	document.getElementById('cboAvailable').options[optionIndex].text = document.getElementById('cboAvailable').options[optionIndex+1].text;
	document.getElementById('cboAvailable').options[optionIndex].value = document.getElementById('cboAvailable').options[optionIndex+1].text;
	document.getElementById('cboAvailable').options[optionIndex+1].text = cboAvailable;
	document.getElementById('cboAvailable').options[optionIndex+1].value = cboAvailable;
	document.getElementById('cboAvailable').options[optionIndex+1].selected = true;	
}

function DeleteItem(evt)
{
	var GridTable    = document.getElementById('dataGrid');
	var tablength    = GridTable.rows[1].cells.length;
	
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode== 46)
	var tobeRemoved   = document.getElementById("cboAvailable").value;
	var tobeRemovedID = document.getElementById("cboAvailable").selectedIndex;
	document.getElementById("cboAvailable").options[tobeRemovedID] = null;
	
	var elSel         = document.getElementById("cbosizes");
	elSel.innerHTML  += "<option selected value="+tobeRemoved+">"+tobeRemoved+"</option>";
	//alert(tobeRemoved);
	
	for(var j=3;j<GridTable.rows[1].cells.length;j++)
	{
		if(GridTable.rows[1].cells[j].innerHTML==tobeRemoved)
		{
			for(var q=1;q<GridTable.rows.length;q++)
			{
				GridTable.rows[q].deleteCell(j);
			}
		}
	}
	
	
}


function saveToGrid()
{
	var cboAvailable = document.getElementById("cboAvailable");
	var GridTable    = document.getElementById('dataGrid');
	var tablength    = GridTable.rows[1].cells.length;
	
	if(cboAvailable.length==0)
	{
		alert("Please select a size!!!!");
		//closePopUp(1);
	}
	else
	{
		for(var x=0;x<cboAvailable.length;x++)
		{	
			var avilable = 0;
			
			for(var y=3;y<GridTable.rows[1].cells.length;y++)
			{	
				if(cboAvailable[x].childNodes[0].nodeValue==GridTable.rows[1].cells[y].innerHTML)
				{
					avilable = 1;
				}
			}
			
				if(avilable==0)
				{
				
					var newCellSize            = document.getElementById("dataGrid").rows[1].insertCell(tablength);
					newCellSize.className      = "grid_header";
					newCellSize.innerHTML      = cboAvailable[x].childNodes[0].nodeValue;
			
					var i=document.getElementById('dataGrid').rows[0].cells
    				i[0].colSpan=Number(document.getElementById("dataGrid").rows[1].cells.length)+3;
					
					createTextForGrid1();
				}
			
			
		}
		
	}
}

function validateGridData()
{
	var GridTable=document.getElementById("dataGrid");
	var rowLength=GridTable.rows.length;
	var count=0;
	
	for(var k=2;k<GridTable.rows.length;k++)
	{
		for(var j=3;j<GridTable.rows[2].cells.length;j++)
		{
			if(GridTable.rows[k].cells[j].childNodes[0].value!='')
				count=count+1;
		}
	}
	
	var styleName=$("#txtStyle option:selected").text();
	
	var styleId=document.getElementById('orderNo').value;
	
	var orderNo=$("#orderNo option:selected").text();
	
	if(styleName=='')
	{
		alert("Please select Style");
	}
	/*else if(orderNo=='')
	{
		alert("Please Select Order No");
	}*/
	
	else if(rowLength==2)
	{
		alert("No sizes selected");
	}
	else if(count==0)
	{
		alert("Please specify the qty");
	}
	
	else
	{
		for(var x=2;x<GridTable.rows.length;x++)
		{
			for(var i=3;i<GridTable.rows[2].cells.length;i++)
			{
				if(GridTable.rows[x].cells[i].childNodes[0].value=='')
					GridTable.rows[x].cells[i].childNodes[0].value=0;
			
			}
		}
		
		saveGridData();
	}	
}

function saveGridData()
{
	var styleName=$("#txtStyle option:selected").text();
	var styleId=document.getElementById('orderNo').value;
	
	var GridTable=document.getElementById("dataGrid");
	
	var url1="measurementAllocation-db-set.php?requestType=DeleteData&styleId="+styleId;
	$.ajax({url:url1,async:false});
	
	for(var x=2;x<GridTable.rows.length;x++)
	{
		for(var i=3;i<GridTable.rows[1].cells.length;i++)
		{
			
			var url="measurementAllocation-db-set.php?requestType=saveData";
			url+="&styleId="+styleId;
			url+="&mesId="+GridTable.rows[x].cells[1].childNodes[0].nodeValue;
			url+="&size="+GridTable.rows[1].cells[i].childNodes[0].nodeValue;
			url+="&dblMes="+GridTable.rows[x].cells[i].childNodes[0].value;
			
			var xmlhttp_obj = $.ajax({url:url,async:false})
		}
		
		
	}
	if(true)
		{
			alert("Saved Successfully!!!");
			clearForm();
		}
	
}


function clearForm()
{
	window.location.reload();
}


function createTextForGrid1()
{
	var GridTable=document.getElementById("dataGrid");
	var len      = GridTable.rows[1].cells.length;
	
	for(var x=2;x<GridTable.rows.length;x++)
	{
		while(GridTable.rows[x].cells.length!=GridTable.rows[1].cells.length)
		{
			var newCellSize       = GridTable.rows[x].insertCell(x+1);
			newCellSize.innerHTML = "<input type='text' align='center' size='7' />";
		}
	}
}

function createTextForGrid2()
{
	var GridTable=document.getElementById("dataGrid");
	
	for(var s=3;s<GridTable.rows[1].cells.length;s++)
	{
			var rownum                = GridTable.rows.length-1;
			var newCellSize           = GridTable.rows[rownum].insertCell(s);
			newCellSize.innerHTML     = "<input type='text' align='center' size='7' />";
	}
}

function submitForm()
{
	document.forms['frmGrid'].submit();
}

function deleteGridRow(obj)
{
	var GridTable=document.getElementById("dataGrid");
	var tobedeleted = obj.parentNode.parentNode.rowIndex;
	//alert(tobedeleted);
	var firstLength = GridTable.rows.length;
	if(tobedeleted==1)
	{
		for(var x=firstLength-1;x>1;x--)
		{
			GridTable.deleteRow(x);
		}
	}
	else
	{
		GridTable.deleteRow(tobedeleted);
	}
	
	
}