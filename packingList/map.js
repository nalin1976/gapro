// JavaScript Document

var xmlHttp = [];

function createXMLHttpRequest(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function addNewRow(obj)
{
	
	var tblType = document.getElementById("tblType");
	var rowHTML = obj.parentNode.parentNode.innerHTML;
	var rowIndex = obj.parentNode.parentNode.rowIndex;
	var rowCount = tblType.rows.length;
	if(rowIndex==rowCount-1)
	{
		tblType.insertRow(rowCount);
		tblType.rows[rowCount].innerHTML = rowHTML;
		//var typeId = obj.value;
		//tblType.rows[rowCount].cells[2].childNodes[0].value= typeId;
		//alert(tblType.rows[rowCount].cells[2].childNodes[0].value);
	}
	
}

function deleteRow(obj)
{
	
	var rowId = obj.parentNode.parentNode.rowIndex;
	
	var tblType = document.getElementById("tblType");
	if(tblType.rows.length>1)
	{
		tblType.deleteRow(rowId);
	}
}
	
function addBuyerToTextBox(obj)
{
	document.getElementById("txtBuyer").value	=obj.options[obj.selectedIndex].text;
}

function saveMap()
{
	var mapId		= document.getElementById("txtId").value;
	var buyer		= document.getElementById("txtBuyer").value;
	
	createXMLHttpRequest(0);
    xmlHttp[0].onreadystatechange = saveHeaderRequest;
    xmlHttp[0].open("GET", 'map-db.php?id=saveMapHeader&mapId='+mapId+'&buyer='+buyer, true);
    xmlHttp[0].send(null); 
	//alert(buyer);
}

function saveHeaderRequest()
{
	 if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		if(text=='error')
			alert('Error saving details ( '+text+' )');
		else if(parseInt(text)>0)
		{
			document.getElementById("txtId").value=text;
			saveDetails(text);
		}
		else
			saveDetails(text);
	}
}

function saveDetails(id)
{
	//alert(id);
	var tbl		= document.getElementById("tblType");
	var rowCount= tbl.rows.length;
	
	for(var i=0;i<rowCount;i++)
	{
		var type 			= tbl.rows[i].cells[5].childNodes[0].value;
		var cellColumnIndex = tbl.rows[i].cells[7].childNodes[0].value;
		var cellColumnCH 	= tbl.rows[i].cells[7].childNodes[0].options[tbl.rows[i].cells[7].childNodes[0].selectedIndex].text;
		var cellRow 		= tbl.rows[i].cells[8].childNodes[0].value;
		if(type!='' && cellColumnIndex!='' && cellColumnCH !='' && cellRow!='')
		{
			var url = 'map-db.php?id=saveMapDetails';
				url+='&mapId='+id;
				url+= '&type='+type;
				url+= '&cellColumnIndex='+cellColumnIndex;
				url+= '&cellColumnCH='+cellColumnCH;
				url+= '&cellRow='+cellRow;
			createXMLHttpRequest(i+1);
			xmlHttp[i+1].index = i+1;
			xmlHttp[i+1].onreadystatechange = saveDetailsRequest;
			xmlHttp[i+1].open("GET", url, true);
			xmlHttp[i+1].send(null);
			//alert(url);
		}
	}
		
}

function saveDetailsRequest()
{
	 if((xmlHttp[this.index].readyState == 4) && (xmlHttp[this.index].status == 200)) 
    {
		var text = xmlHttp[this.index].responseText;
		alert(text);
	}
}
