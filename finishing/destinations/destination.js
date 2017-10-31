// JavaScript Document
var row;
var delId = 0;
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
	
}
function setData(countriId)
{

	var countryID = countriId
	var url = 'destinationdb.php?Request=getData&countryID=' +countryID;
	htmlobj = $.ajax({url:url,async:false});
	ClearTable('tblNGMain');
	
	var XMLConId 			  = htmlobj.responseXML.getElementsByTagName("intConId");
	var XMLCityId  		 	  = htmlobj.responseXML.getElementsByTagName("intCityId");
	var XMLCityName 		  = htmlobj.responseXML.getElementsByTagName("cityName");
	var XMLPort				  = htmlobj.responseXML.getElementsByTagName("strport");
	var XMLaltCityName	 	  = htmlobj.responseXML.getElementsByTagName("altCityName");
	
	for(loop=0;loop<XMLCityId.length;loop++)
	{
		var ConId  		  	  = XMLConId[loop].childNodes[0].nodeValue;
		var CityId  		  = XMLCityId[loop].childNodes[0].nodeValue;
		var CityName  		  = XMLCityName[loop].childNodes[0].nodeValue;
		var Port			  = XMLPort[loop].childNodes[0].nodeValue;
		var altCityName 	  = XMLaltCityName[loop].childNodes[0].nodeValue;
	
		
		createMainGrid(ConId,CityId,CityName,Port,altCityName);
	}	
}
function createMainGrid(ConId,CityId,CityName,Port,altCityName)
{	
	var tbl 		= document.getElementById('tblNGMain');

	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
		
	var cell = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id = CityId;
	cell.innerHTML ="<img alt=\"add\" src=\"../../images/edit.png\" id=\""+ConId+"\" onClick=\"AddCity(this.id,this.parentNode.id,this.parentNode.parentNode.rowIndex,0);\" >";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.id = CityId;
	cell.innerHTML = CityName;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = Port;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap = "nowrap";
	cell.innerHTML = altCityName;
}
function AddCity(id,cityid,rowid,x)
{
	this.delId 		 = x;
	var tbl 		 = document.getElementById("tblNGMain");
	var cityID		 = cityid;
	var conId 	     = id;
	this.row 	     = rowid;
	var rw		     = tbl.rows[row];
	var CityName     = rw.cells[1].childNodes[0].nodeValue;
	var Port	     = rw.cells[2].childNodes[0].nodeValue;
	var altCityName	 = rw.cells[3].childNodes[0].nodeValue;
	
	showBackGround('divBG',0);
	var url = "destinationpop.php?conId="+conId+'&cityID=' +cityID+ '&CityName=' +CityName+ '&Port=' +Port+ '&altCityName=' +altCityName;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(504,211,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
		
}
function AddNewCity(x)
{
	if(document.getElementById("cboSearch").value=="")
	{
		showPleaseWait();
		alert("Please select a Country.");
		document.getElementById("cboSearch").focus();
		hidePleaseWait();
		return;
		
		
	}
	
	this.delId = x;
	var conId = $('#cboSearch').val();
	showBackGround('divBG',0);
	var url = "destinationpop.php?conId="+conId;

	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(504,211,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
		window.location.href='destination.php';
	}
	catch(err)
	{        
	}	
}
/*function AddCitytoGrid(conID)
{
	var tblMain		= document.getElementById('tblNGMain');
	var conId		= conID;
	var cityId	 	= $('#cboSearch').val();
	var cityName	= $('#txtCityName').val();
	var port		= $('#txtPort').val();
	var destination	= $('#txtDestination').val();
	
	var booCheck = false;
				for(var j=1;j < tblMain.rows.length; j++ )
				{
						if(tblMain.rows[j].cells[1].childNodes[0].nodeValue==cityName && tblMain.rows[j].cells[2].childNodes[0].nodeValue==port && tblMain.rows[j].cells[3].childNodes[0].nodeValue==destination )
						{
							booCheck = true;								
						}						
				}
				if(!booCheck)
				{
						if(delId==0)
						{
							tblMain.deleteRow(row);
						}
					createMainGrid(conId,cityId,cityName,port,destination);
				}
				else
					alert("the record already exist.");
}*/
function setCityData(cityId,conID)
{
	if(document.getElementById("cboCitySearch").value=="")
		{
			
			document.getElementById("txtCityName").value	= "";
			document.getElementById("txtPort").value        = "";
			document.getElementById("txtDestination").value = "";
			return;
		}
	
		cityID		= cityId;
		countryID	= conID;
		
		var url = 'destinationdb.php?Request=getData&cityID=' +cityID+'&countryID='+countryID;
		htmlobj = $.ajax({url:url,async:false});
		
		var XMLCityName 		  = htmlobj.responseXML.getElementsByTagName("cityName");
		var XMLPort				  = htmlobj.responseXML.getElementsByTagName("strport");
		var XMLaltCityName	 	  = htmlobj.responseXML.getElementsByTagName("altCityName");
		var XMLCityId  		 	  = htmlobj.responseXML.getElementsByTagName("intCityId");
		
		for(loop=0;loop<XMLCityId.length;loop++)
		{
			
			document.getElementById("txtCityName").value	= XMLCityName[loop].childNodes[0].nodeValue;
			document.getElementById("txtPort").value        = XMLPort[loop].childNodes[0].nodeValue;
			document.getElementById("txtDestination").value = XMLaltCityName[loop].childNodes[0].nodeValue;
		}
	
}
/*-------------------------- saving data-------------------------------*/
function SaveData(conId)
{
	showPleaseWait();
	document.getElementById("Save").style.display="none";
	var conID 	 	= conId
	var cityId		= $('#cboCitySearch').val();
	var ciytName    = $('#txtCityName').val();
	var port	    = $('#txtPort').val();
	var Dest	    = $('#txtDestination').val();
	
	var url = 'destinationdb.php?Request=SaveData&conID='+conID+'&cityId='+cityId+'&ciytName='+URLEncode(ciytName)+'&port='+URLEncode(port)+'&Dest='+URLEncode(Dest);
		htmlobj=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText=="Saved")
	{
		alert("saved successfully.");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
	}
	if(htmlobj.responseText=="Updated")
	{
		alert("Updated successfully.");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
	}
	if(htmlobj.responseText=="Error")
	{
		alert("Error.");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
	}
	if(htmlobj.responseText=="cant")
	{
		alert("the record already exist..");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
	}
}
function ClearForm()
{
	document.getElementById("cboCitySearch").value  = "";
	document.getElementById("txtCityName").value	= "";
	document.getElementById("txtPort").value        = "";
	document.getElementById("txtDestination").value = "";
}
function deleteData(conId)
{
	showPleaseWait();
	document.getElementById("Delete").style.display="none";
	var conID 	 	= conId
	var cityId		= $('#cboCitySearch').val();
	var cname=	document.getElementById("cboCitySearch").options[document.getElementById("cboCitySearch").selectedIndex].text;
	var ans=confirm("Are you sure you want to  delete '" +cname+ "' ?");
	if (ans)
	{
		var url = 'destinationdb.php?Request=deleteData&conID='+conID+'&cityId='+cityId;
		htmlobj=$.ajax({url:url,async:false});
		if(htmlobj.responseText=="Deleted")
		{
			alert("Deleted successfully");
			document.getElementById("Delete").style.display="inline";
			hidePleaseWait();
			ClearForm();	
		}
		else
		{
			alert("Error");
			document.getElementById("Delete").style.display="inline";
			hidePleaseWait();
			
		}
	}
	else
	{
		document.getElementById("Delete").style.display="inline";
		hidePleaseWait();
	}
}