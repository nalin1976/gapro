// JavaScript Document
var xmlHttp =[];
var position=0;
var count=0;
var mainGridRowNo=0;

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




function clearForm()
{
	window.location.reload();
}
function enableDateRange(obj)
{
	if(obj.checked==true)
	{
		document.getElementById('txtDateFrom').disabled=false;
		document.getElementById('txtDateTo').disabled=false;
	}
	else
	{
		document.getElementById('txtDateFrom').disabled=true;
		document.getElementById('txtDateTo').disabled=true;
	}
}




//function loadGridDetails()
//{
//
//		var buyer_id=document.getElementById('cboBuyer').value;
//		loadGrid();
//		alert(buyer_id);
//	
//}




function validateDataToLoadGrid()
{
	//alert("abc");
	var dateFrom = document.getElementById('txtDateFrom').value;
	var dateTo = document.getElementById('txtDateTo').value;
	
	var splitDateFrom = dateFrom.split("/");
	var splitDateTo = dateTo.split("/");
	
	if(document.getElementById('cboSerialNo').value==0)
	{
		if(document.getElementById('cboBuyer').value==0)
			alert("Please Select a Buyer");
		else if(document.getElementById('chk_dateRange').checked==true)
		{
			if(splitDateFrom[2]>splitDateTo[2])
				alert("Date From should be less than Date To");
			else if(splitDateFrom[1]>splitDateTo[1])
				alert("Date From should be less than Date To");
			else if(splitDateFrom[0]>splitDateTo[0])
				alert("Date From should be less than Date To");
			else
			{
				showPleaseWait();
				clearGrid();
				loadGrid();
				hidePleaseWait();
			}
		}
		else
		{
			clearGrid();
			showPleaseWait();
			loadGrid();
			hidePleaseWait();
		}
	}
}
function clearGrid()
{
	var tblreceipt=document.getElementById('tblreceipt');
	for(var i=tblreceipt.rows.length-1;i>0;i--)
		tblreceipt.deleteRow(i);	
}

function validateData()
{
	var selectCount=0;
	var tblForcast=document.getElementById('tblForcast');
	//saveHeader();
	//if(document.getElementById('cboSerialNo').value==0)
	//{
		if(tblForcast.rows.length>1)
				{
					for(var x=0;x<tblForcast.rows.length;x++)
					{
						if((tblForcast.rows[x].cells[0].childNodes[0].checked)==true)
						{
							selectCount=1;
                               break;
						}
					}
				}
		if(selectCount==0)
			alert("Select an SC No");
		
		else
			saveHeader();
	//}
}

function saveHeader()
{
	//showPleaseWait();
       // alert("uuyg");
	var Buyer		= document.getElementById('cboBuyer').value;
	var date                = document.getElementById('txtDate').value;
        
        if(document.getElementById('txtName').value=='')
            {
                var Name		= Buyer+"/"+date;
                document.getElementById('txtName').value=Name;
                alert("Name Saved as "+Name);
            }
          else
              {
                 Name=document.getElementById('txtName').value; 
              }
	//alert(Buyer+"/"+date);

            var url ="shipmentforecast-db.php?id=saveHeader";
		url+="&Name="+Name;
		url+="&date="+date;
                url+="&Buyer="+Buyer;
		
	var htmlhttp_obj	  = $.ajax({url:url,async:false});
	//alert(htmlhttp_obj.responseText);
            

	
	if(htmlhttp_obj.responseText!='0')
	{
		for(var x=1;x<tblForcast.rows.length;x++)
		{
			if((tblForcast.rows[x].cells[0].childNodes[0].checked)==true)
			{
				
				var url1 ="shipmentforecast-db.php?id=saveDetail";
					url1+="&serialNo="+htmlhttp_obj.responseText;
					url1+="&SCno="+tblForcast.rows[x].cells[1].childNodes[0].nodeValue;
					
				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(htmlhttp_obj1.responseText);
				//alert(tblreceipt.rows[x].cells[8].childNodes[0].nodeValue);
				
			}
		}
		alert("Saved Successfully");
		//clearForm();
	}
	else
		alert("Saving Failed");
	//hidePleaseWait();
	location.reload();
}


function loadGrid()
{
    //location.reload();

	var load_id = document.getElementById('cboBuyer').value;
	//alert(load_id);
	var url	="ShipmentForecast-db.php?id=loadgrid";
		url+="&load_id="+load_id;
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
                //alert (xmlhttp_obj.responseText);
	



		var XMLSCNo                  = xmlhttp_obj.responseXML.getElementsByTagName("SCNo");
		var XMLPoNo                  = xmlhttp_obj.responseXML.getElementsByTagName("PoNo");
		var XMLEX_FTY_Date           = xmlhttp_obj.responseXML.getElementsByTagName("EX_FTY_Date");
		var XMLCtnMes                = xmlhttp_obj.responseXML.getElementsByTagName("CtnMes");
		var XMLNet                   = xmlhttp_obj.responseXML.getElementsByTagName("Net");
		var XMLGrs                   = xmlhttp_obj.responseXML.getElementsByTagName("Grs");
		var XMLQty                   = xmlhttp_obj.responseXML.getElementsByTagName("Qty");
		var XMLDesc                  = xmlhttp_obj.responseXML.getElementsByTagName("Desc");
		var XMLFabric                = xmlhttp_obj.responseXML.getElementsByTagName("Fabric");
        var XMLStyleNo               = xmlhttp_obj.responseXML.getElementsByTagName("StyleNo");
		var XMLCountry               = xmlhttp_obj.responseXML.getElementsByTagName("Country");
		var XMLSeason                = xmlhttp_obj.responseXML.getElementsByTagName("Season");
		var XMLUnitPrice	     = xmlhttp_obj.responseXML.getElementsByTagName("UnitPrice");
		var XMLFactory               = xmlhttp_obj.responseXML.getElementsByTagName("Factory");
                
               
		tblForcast.className='scriptBgClr';
                for(var x=0;x<XMLSCNo.length; x++)
		{	
			//alert(XMLCountry[x].childNodes[0].nodeValue);
		
			
			var newRow			 	    = tblForcast.insertRow(x+1);
			newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblForcast.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" />";
			
			
			var newCellSCNo        = tblForcast.rows[x+1].insertCell(1);
			newCellSCNo.className  = "normalfntMid";
			newCellSCNo.align      = "center";
			newCellSCNo.id     	   = XMLSCNo[x].childNodes[0].nodeValue;
			//newCellSCNo.innerHTML 	= XMLSCNo[x].childNodes[0].nodeValue+"<img style='cursor:pointer' maxlength='15'  align='right' onclick='showCatPopUp(this);' src='../../images/add.png'/></td>";	
			newCellSCNo.innerHTML 	= XMLSCNo[x].childNodes[0].nodeValue;	

                        
                        
                        var newCellStyle              = tblForcast.rows[x+1].insertCell(2);
			newCellStyle.className       = "normalfntMid";
			newCellStyle.align           = "center";
			newCellStyle.id		         = XMLStyleNo[x].childNodes[0].nodeValue;
			newCellStyle.innerHTML       = XMLStyleNo[x].childNodes[0].nodeValue;
			
                        

                        
                        var newCellPoNo              = tblForcast.rows[x+1].insertCell(3);
			newCellPoNo.className       = "normalfntMid";
			newCellPoNo.align           = "center";
			newCellPoNo.id     			 = XMLPoNo[x].childNodes[0].nodeValue;
			newCellPoNo.innerHTML       = XMLPoNo[x].childNodes[0].nodeValue;
                        
                        
                        
                        
                        
                        var newCellDesc             = tblForcast.rows[x+1].insertCell(4);
			newCellDesc.className       = "normalfntMid";
			newCellDesc.align           = "center";
			newCellDesc.innerHTML       = XMLDesc[x].childNodes[0].nodeValue;
                        
                        

                        
                        
                        
                        			
			var newCellFabric             = tblForcast.rows[x+1].insertCell(5);
			newCellFabric.className       = "normalfntMid";
			newCellFabric.align           = "right";
			newCellFabric.innerHTML       = XMLFabric[x].childNodes[0].nodeValue;
                        
                        
                        
            var newCellCountry              = tblForcast.rows[x+1].insertCell(6);
			newCellCountry.className       = "normalfntMid";
			newCellCountry.align           = "center";
			newCellCountry.innerHTML       = XMLCountry[x].childNodes[0].nodeValue;
                        
                        
                        
			
                        
            var newCellSeason             = tblForcast.rows[x+1].insertCell(7);
			newCellSeason.className       = "normalfntMid";
			newCellSeason.align           = "center";
			newCellSeason.innerHTML       = XMLSeason[x].childNodes[0].nodeValue;
                        
                        
                        
                        
                        			
			var newCellUnitPrice            = tblForcast.rows[x+1].insertCell(8);
			newCellUnitPrice.className       = "normalfntMid";
			newCellUnitPrice.align           = "right";
			newCellUnitPrice.innerHTML       = XMLUnitPrice[x].childNodes[0].nodeValue; 
                        
                        
                        
                        
                        
                        			
			var newCellEX_FTY_Date       = tblForcast.rows[x+1].insertCell(9);
			newCellEX_FTY_Date.className       = "normalfntMid";
			newCellEX_FTY_Date.align           = "center";
			newCellEX_FTY_Date.innerHTML       = XMLEX_FTY_Date[x].childNodes[0].nodeValue;
                        
                        
                        
                        var newCellFactory            = tblForcast.rows[x+1].insertCell(10);
			newCellFactory.className       = "normalfntMid";
			newCellFactory.align           = "right";
			newCellFactory.innerHTML       = XMLFactory[x].childNodes[0].nodeValue;
                        
                        
                        
                        
                        
			var newCellCtnMes            = tblForcast.rows[x+1].insertCell(11);
			newCellCtnMes.className       = "normalfntMid";
			newCellCtnMes.align           = "center";
			newCellCtnMes.innerHTML       = "-";
			
			
                        
                        var newCellQty              = tblForcast.rows[x+1].insertCell(12);
			newCellQty.className       = "normalfntMid";
			newCellQty.align           = "center";
			newCellQty.innerHTML       = XMLQty[x].childNodes[0].nodeValue;
                        
                        
			var newCellNet            = tblForcast.rows[x+1].insertCell(13);
			newCellNet.className       = "normalfntMid";
			newCellNet.align           = "right";
			newCellNet.innerHTML       = XMLNet[x].childNodes[0].nodeValue;
                        
                        
                        var newCellGrs           = tblForcast.rows[x+1].insertCell(14);
			newCellGrs.className     = "normalfntMid";
			newCellGrs.align         = "center";
			newCellGrs.innerHTML     = XMLGrs[x].childNodes[0].nodeValue;
			
			

			


}






}





function showCatPopUp(obj)
{
	mainGridRowNo=obj.parentNode.parentNode.rowIndex;
	
        
        var grd = document.getElementById('tblForcast');
        var ScNo=grd.rows[mainGridRowNo].cells[1].id;
		var style=grd.rows[mainGridRowNo].cells[2].id;
		var PONo=grd.rows[mainGridRowNo].cells[3].id;
		//alert(PONo)
		document.getElementById("cboSCNO").value=ScNo;
		document.getElementById("cboPONO").value=PONo;
		document.getElementById("txtstyle").value=style;
		//alert(style)
		//alert(PONo);
	//alert("wew");
	
/*createNewXMLHttpRequest(16);
		xmlHttp[16].onreadystatechange=function()
		{	
			if(xmlHttp[16].readyState==4 && xmlHttp[16].status==200)
   		 {
        		
				drawPopupAreaLayer(500,200,'Shipment_Order_Ratio',1050);
				document.getElementById('Shipment_Order_Ratio').innerHTML=xmlHttp[16].responseText;
				//loadGrid();
			
		 }
			
		}
		xmlHttp[16].open("GET",'Shipment_Order_Ratio.php',true);
		xmlHttp[16].send(null);*/	////
		
displayFm('addFm',-530,220);		
		
		
/////createNewXMLHttpRequest(16);
//		
//				drawPopupArea(905,200,'Shipment_Order_Ratio');
//				//document.getElementById('Shipment_Order_Ratio').innerHTML=xmlHttp[16].responseText;
//				//loadGrid();
//		
//		open("GET",'Shipment_Order_Ratio.php',true);
//		//xmlHttp[16].send(null);	
//	
}


function addRow()
{
	var detailGrid = document.getElementById('tblOrderRatio');
	var lastRow    = detailGrid.rows.length;
	
	var row 	   = detailGrid.insertRow(lastRow);
	row.className       = "bcgcolor-tblrowWhite";
	var str ="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:158px; text-align:center;' /></td>";
		str +="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:75px; text-align:center;' /></td>";
		str +="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:75px; text-align:center;' /></td>";
		str +="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:75px; text-align:center;' /></td>";
		str +="<td style='text-align:center'><input type='text' onblur='checkExist(this);' style='width:75px; text-align:center;' /></td>";
        str+="<td style='text-align:center'><input type='text' style='width:75px; text-align:center;' onkeypress='addR(this,event); ";
		str+="return CheckforValidDecimal(this.value,4,event)'/></td>";
	row.innerHTML = str;	
}



function checkExist(obj)
{
	if(obj.value!="")
	{
	var grd = document.getElementById('tblOrderRatio');
	for(var i=1;i<grd.rows.length;i++)
	{
		//alert(obj.parentNode.parentNode.rowIndex);
		//alert(i);
		//if(grd.rows[i].cells[1].childNodes[0].value==obj.value && i!=obj.parentNode.parentNode.rowIndex)
//		{
//			
//			alert("Lorry Number : "+obj.value+" Already Exist !");
//			obj.value = "";
//			obj.focus();
//			break;
//		}
	}
	}
}

function addR(obj,evt)
{
	var detailGrid = document.getElementById('tblOrderRatio');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(detailGrid.rows.length-1))
		{
			addRow();
		}
	}
}





function addRo(obj,evt)
{
	var detailGrid = document.getElementById('tblOrderRatio');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(detailGrid.rows.length-1))
		{
			addRowCTN();
		}
	}
}

///////////////////////////save grid////////////////////*
function savedata()
{
	var grd	 	= document.getElementById('tblOrderRatio');
	var style	=document.getElementById("txtstyle").value
	//alert(style)
		for(var x=1;x<grd.rows.length;x++)
		{

			var color	=grd.rows[x].cells[0].childNodes[0].nodeValue;
					
//					for(var r=1;r<grd.rows.length;x++)
//						{
//							var Qty		=grd.rows[x].cells[1].childNodes[0].value;
//						}
			//var color_array=new Array(color);
//			 var a=color_array[1];
//			alert(a);
					
				for(var i = 0; i < document.getElementById("cboselectedsizes").options.length ; i++) 
				{
					size=(document.getElementById("cboselectedsizes").options[i].text);
					
						var r=i+1;
				var	Qty 	=grd.rows[x].cells[r].childNodes[0].value;
				var ScNo	=document.getElementById('cboSCNO').value;
				var PONO	=document.getElementById('cboPONO').value;
				var style	=document.getElementById("txtstyle").value
				//var Style	=grd.rows[mainGridRowNo].cells[2].id;
				
						/*alert(Style);
						alert(color);		
						alert(size);
						alert(Qty);
						alert(ScNo);
						alert(PONO);*/
						
						if(Qty!="" ) 
							{
						
							var urlNew = "ShipmentForecast-db.php?id=saveStyleRatio&ScNo="+ScNo
								+"&PONO="+PONO
								+"&color="+color
								+"&size="+size
								+"&style="+style
								+"&Qty="+Qty;
								
							htmlobjNew = $.ajax({url:urlNew,async:false});
							}
					
			
			}
	
		}
			
			
			//alert(grd.rows.length);
					
/*					for(var i=1;i<6;i++)
					{	
						
						var size="";
						var  Qty=0;
						
						
								
								var ScNo=document.getElementById('cboSCNO').value;
								var PONO=document.getElementById('cboPONO').value;
							
							//var Size=grd.rows[x].cells[1].childNodes[0].value;

						

							if(grd.rows[x].cells[i].childNodes[0].value!="")
							{
								//alert(grd.rows[x].cells[i].childNodes[0].value);
								if(i==1)
									{
										 size="S";
										 Qty=grd.rows[x].cells[i].childNodes[0].value;	
									}
								else if (i==2)
									{
										 size="M";
										 Qty=grd.rows[x].cells[i].childNodes[0].value;	
									}
								else if(i==3)
									{
										 size="L";
										 Qty=grd.rows[x].cells[i].childNodes[0].value;	
									}
								else if(i==4)
									{
										 size="XL";
										 Qty=grd.rows[x].cells[i].childNodes[0].value;	
									}
								else
									{
										 size="XXL";
										 Qty=grd.rows[x].cells[i].childNodes[0].value;	
									}	
							
							//alert(size);
							//alert(Qty);
							if(size !="" && Qty!="" ) 
							{
							var urlNew = "ShipmentForecast-db.php?id=saveStyleRatio&ScNo="+ScNo
							+"&PONO="+PONO
							+"&color="+URLEncode(grd.rows[x].cells[0].childNodes[0].value)
							+"&size="+size
							+"&Qty="+Qty;
							
				htmlobjNew = $.ajax({url:urlNew,async:false});
				
							}
					}
				
				}
			}
		alert("Data Saved Successfully !");	*/
}

function frmReload()
{
		//document.getElementById('tblOrderRatio')="";
		ClearTable('tblOrderRatio');
		document.getElementById('cboSCNO').value="";
		document.getElementById('cboPONO').value="";
}


function ClearTable(tblName)
{
	var grd = document.getElementById('tblOrderRatio');
			
		for(var x=1;x<grd.rows.length;x++)
		{
			
					
					for(var i=0;i<6;i++)
					{	
						
							
						grd.rows[x].cells[i].childNodes[0].value="";
							
					}
		}
}

function showColorSizeSelector()
{
	
		
		var grd = document.getElementById('tblForcast');
		displayFm('addFm1',-530,220);
		var abc=grd.rows[mainGridRowNo].cells[1].id;
		var style=grd.rows[mainGridRowNo].cells[2].id;
		//alert(style);
		
/*		 var grd = document.getElementById('tblForcast');
        var ScNo=grd.rows[mainGridRowNo].cells[1].id;
		var PONo=grd.rows[mainGridRowNo].cells[3].id;
		document.getElementById("cboSCNO").value=ScNo;
		document.getElementById("cboPONO").value=PONo;*/

}

function closeLayer()
{
	//alert("hiniyata alert");
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function closeLayer2()
{
	//alert("hiniyata alert2");
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}


function grabColorEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode== 13)
	 	AddNewColor();
}

function AddNewColor()
{
	if (document.getElementById("txtnewcolor").value == "")
	{
		alert("Please enter the color name.");
		document.getElementById("txtnewcolor").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbocolors").options.length ; i++) 
	{
		if ( document.getElementById("cbocolors").options[i].text.toUpperCase() == document.getElementById("txtnewcolor").value.toUpperCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtnewcolor").value,document.getElementById("cboselectedcolors"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbocolors").options[i].text;
				optColor.value = document.getElementById("cbocolors").options[i].text;
				document.getElementById("cboselectedcolors").options.add(optColor);

				document.getElementById("cbocolors").options[i] = null;
				
				added =true;
			}
					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtnewcolor").value,document.getElementById("cboselectedcolors"),false))
			SaveColor(document.getElementById("txtnewcolor").value.toUpperCase());
		else
			alert("The color already exists.");
	}
}
function string_constrain(e)
{
    var keyCode = e.keyCode || e.which;
     if(keyCode =='39')
	{
			return false;
	}

}


function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toUpperCase() == itemName.toUpperCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function SaveColor(colorName)
{
	var buyer = document.getElementById("cboBuyer").value;
		 var grd = document.getElementById('tblForcast');
        var ScNo=grd.rows[mainGridRowNo].cells[1].id;
		var style=grd.rows[mainGridRowNo].cells[2].id;
	//var division = document.getElementById("cboDivision").value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleColorSaving;
	
    xmlHttp.open("GET", 'ShipmentForecast-db.php?id=addNewColor&colorName=' + URLEncode(colorName) + '&buyer=' + buyer+ '&ScNo=' + ScNo, true);
    xmlHttp.send(null); 
	//alert("ijj");
}


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


function HandleColorSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var optColor = document.createElement("option");
			optColor.text = document.getElementById("txtnewcolor").value.toUpperCase();
			optColor.value = document.getElementById("txtnewcolor").value.toUpperCase();
			document.getElementById("cboselectedcolors").options.add(optColor);
			document.getElementById("txtnewcolor").value = "";
		}
	}
}


function grabSizeEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode== 13)
	 	AddNewSize();
}

function AddNewSize()
{
	if (document.getElementById("txtnewSize").value == "")
	{
		alert("Please enter the size name.");
		document.getElementById("txtnewSize").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbosizes").options.length ; i++)
	{
		if ( document.getElementById("cbosizes").options[i].text.toUpperCase() == document.getElementById("txtnewSize").value.toUpperCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbosizes").options[i].text;
				optColor.value = document.getElementById("cbosizes").options[i].text;
				document.getElementById("cboselectedsizes").options.add(optColor);

				document.getElementById("cbosizes").options[i] = null;
				
				added =true;
			}
					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtnewSize").value,document.getElementById("cboselectedsizes"),false))
			SaveSize(document.getElementById("txtnewSize").value.toUpperCase());
		else
			alert("The size already exists.");
	}
}	


function SaveSize(SizeName)
{
	var buyer = document.getElementById("cboBuyer").value;
		var buyer = document.getElementById("cboBuyer").value;
		 var grd = document.getElementById('tblForcast');
        var ScNo=grd.rows[mainGridRowNo].cells[1].id;
		var style=grd.rows[mainGridRowNo].cells[2].id;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleSizeSaving;
    xmlHttp.open("GET", 'ShipmentForecast-db.php?id=AddNewSize&SizeName=' + URLEncode(SizeName) + '&buyer=' + buyer + '&ScNo=' + ScNo , true);
    xmlHttp.send(null); 
}


function HandleSizeSaving()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var optColor = document.createElement("option");
			optColor.text = document.getElementById("txtnewSize").value.toUpperCase();
			optColor.value = document.getElementById("txtnewSize").value.toUpperCase();
			document.getElementById("cboselectedsizes").options.add(optColor);
			document.getElementById("txtnewSize").value = "";
		}
	}
}


function MoveColorRight()
{
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedcolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedcolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveColorLeft()
{
	var colors = document.getElementById("cboselectedcolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbocolors"),false))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbocolors").options.add(optColor);
		
	}
	colors.options[colors.selectedIndex] = null;
}

function MoveAllColorsLeft()
{
	if(document.getElementById("cboselectedcolors").disabled)
	{
		alert("This function disabled for this style / buyer PO.");
		return;
	}
	var colors = document.getElementById("cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedcolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedcolors").options.add(optColor);
		}
	}
	RemoveCurrentColors();
}

function MoveAllColorsRight()
{
	if(document.getElementById("cboselectedcolors").disabled)
	{
		alert("This function disabled for this style / buyer PO.");
		return;
	}
	var colors = document.getElementById("cboselectedcolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbocolors").options.add(optColor);
		}
	}
	RemoveSelectedColors();
}
function RemoveSelectedColors()
{
	var index = document.getElementById("cboselectedcolors").options.length;
	while(document.getElementById("cboselectedcolors").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedcolors").options[index] = null;
	}
}



function AddSelection()
{
	if (isValidColorSizeSelection())
	{
		var colorlength = document.getElementById("cboselectedcolors").options.length;
		var sizelength = document.getElementById("cboselectedsizes").options.length;
		
		var colors = [];
		for(var i = 0; i < document.getElementById("cboselectedcolors").options.length ; i++) 
		{
			colors[i] = document.getElementById("cboselectedcolors").options[i].text;
		}
		
		var sizes = [];
		for(var i = 0; i < document.getElementById("cboselectedsizes").options.length ; i++) 
		{
			sizes[i] = document.getElementById("cboselectedsizes").options[i].text;
		}
		
		if (colors.length <= 0)
		{
			colors[0] = "N/A";
		}
		
		if (sizes.length <= 0)
		{
			sizes[0] = "N/A";
		}
		
		var tablewidth = 450 + (7 * sizes.length);
		
		// Create The table header
		var HTMLText = "";
		HTMLText += "<table width=\"" + tablewidth + "\" id=\"tblQtyRatio\" cellpadding=\"0\" cellspacing=\"0\">" +
		 			"<tr>" +					
	                "<td width=\"33%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Colors</td>";
		
		var celllength = parseInt(50 / sizes.length);
		
		for (i in sizes)
		{
			var y = MatSize.indexOf(sizes[i]);			/*Start 31-03-2010 bookmark*/	

			HTMLText += "<td width=\"" + celllength + "%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" id=\""+arraySizeIsPo[y]+"\"><div align=\"center\">" + sizes[i] + "</div></td>";
		}
		
		HTMLText += "<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Total</div></td>" +
	              	"</tr>" ;
		
		// Create Table body
		var poValue=0;
		var ratioQty=0;
		for (x in colors)
		{
			var q = MatColor.indexOf(colors[x]);		/*Start 31-03-2010 bookmark*/
			
			HTMLText += "<tr>" +
						"<td id=\""+arrayColorIsPo[q]+"\" class=\"normalfnt\">" + colors[x] + "</td>" ;
			for (i in sizes)
			{
//Start 31-03-2010 bookmark (read the array and add data to the table grid)
				var poValue=0;
				var ratioQty=0;
				///////////////// ADD PO VALUE TO GRID CELL ID////////////////////////////////////////////
				try{
					var r 			= MatColor.indexOf(colors[x]);
					var c 			= MatSize.indexOf(sizes[i]);
					var poValue 	= Materials[r][c];
					var ratioQty 	= arrayRatioQty[r][c];
					poValue			= (isNaN(poValue) ? 0:poValue);
					ratioQty		= (isNaN(ratioQty) ? 0:ratioQty);
				}
				catch(err)
				{
				}
//End 31-03-2010 bookmark  (read the array and add data to the table grid)

				HTMLText += "<td id=\""+poValue+"\"><div align=\"center\">" +
		                  	"<input name=\"txtratio\" type=\"text\" ondblClick=\"showMaterialRatioHelper(this);\"  class=\"txtbox\" value=\""+ratioQty+"\" onkeyup=\"ChangeCellValue(this);\" onblur=\"ValidateWithPoQty(this);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\"  onkeypress=\"return IsNumberWithoutDecimals(this.value,event);\" id=\"txtratio" + x + "" + i + "\" size=\"7\" />" +
                			"</div></td>";
			}
			
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  	
                	"</div></td>" +
              		"</tr>";
		}
		
		// Create table footer
		
		HTMLText += "<tr>" +
                    "<td class=\"normalfnt\">Total</td>";
		
		for (i in sizes)
		{
			HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +                  
                		"</div></td>";
		}
		
		HTMLText += "<td class=\"normalfntRite\"><div align=\"center\" class=\"normalfnth2Bm\">0" +
                	"</div></td>" + 
              		"</tr>" ;
		
					
		document.getElementById("divQtyRatio").innerHTML = HTMLText;
		HTMLText = HTMLText.replace("tblQtyRatio","tblEXQtyRatio");
		for (var loop = 0 ; loop < sizes.length * colors.length; loop ++)
		{
		HTMLText = HTMLText.replace("onkeyup=\"ChangeCellValue(this);\"","onkeyup=\"ChangeCellValueExcess(this);\""); 

		//HTMLText = HTMLText.replace("onkeyup=\"ChangeCellValue(this);\"","");
		}
		if (document.getElementById("divExQtyRatio") != null)
		document.getElementById("divExQtyRatio").innerHTML = HTMLText;
		closeLayer();
		doLoadCalculation();
	}
}
function isValidColorSizeSelection()
{
	if (document.getElementById("cboselectedcolors").options.length == 0 && document.getElementById("cboselectedsizes").options.length == 0)
	{
		alert ("Please choose your color size ratio.");
		return false;
	}
	return true;
}

function RemoveSelectedSizes()
{
	var index = document.getElementById("cboselectedsizes").options.length;
	while(document.getElementById("cboselectedsizes").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedsizes").options[index] = null;
	}
}
function  keyMoveSizeRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		MoveSizeRight();
}

function MoveSizeRight()
{
	var colors = document.getElementById("cbosizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedsizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedsizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveSizeLeft()
{
	var colors = document.getElementById("cboselectedsizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbosizes"),false))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbosizes").options.add(optColor);		
	}
	colors.options[colors.selectedIndex] = null;
}

function MoveAllSizesLeft()
{
	var colors = document.getElementById("cbosizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedsizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedsizes").options.add(optColor);
		}
	}
	RemoveCurrentSizes();
}

function MoveAllSizesRight()
{
	var colors = document.getElementById("cboselectedsizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbosizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbosizes").options.add(optColor);
		}
	}
	RemoveSelectedSizes();
}


function AddSelection()
{
		var colorlength   = document.getElementById("cboselectedcolors").options.length;
		var sizelength 	  = document.getElementById("cboselectedsizes").options.length;
		var tblOrderRatio = document.getElementById('tblOrderRatio');
		
		var str = "<tr><td class='normalfntMid'>Color</td>";
		for(var x = 0; x < document.getElementById("cboselectedsizes").options.length ; x++) 
		{
			str+= "<td class='normalfntMid'>"+document.getElementById("cboselectedsizes").options[x].text+"</td>";
		}
		str+="</tr>";
		
		tblOrderRatio.innerHTML=str;
		
		var colors = [];
		for(var i = 0; i < document.getElementById("cboselectedcolors").options.length ; i++) 
		{
			colors[i] = document.getElementById("cboselectedcolors").options[i].text;
				//alert(colors[i]);
					//alert(colors[i].length);
					var pos=0; 
					
			
						var lastRow 		= tblOrderRatio.rows.length;	
						var row 			= tblOrderRatio.insertRow(lastRow);
						
						pos++;

					var rowCell = row.insertCell(0);
							rowCell.className ="normalfntMid";			
							rowCell.innerHTML =colors[i];
				
				
				
							//rowCell.id=tblOrderRatio.rows[x].cells[0].childNodes[0].nodeValue;
				
		
				
				var sizes = [];
				var cellNo = 1;
				for(var x = 0; x < document.getElementById("cboselectedsizes").options.length ; x++) 
				{
					sizes[x] = document.getElementById("cboselectedsizes").options[x].text;
						if([x]=0)
							{
							var rowCell = row.insertCell(cellNo);
							rowCell.className ="normalfntMid";			
							rowCell.innerHTML ="<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+sizes[x]+"</td>"
							}
						else
							{
								for(var x = 1; x <= document.getElementById("cboselectedsizes").options.length ; x++) 
								{
								
								var rowCell = row.insertCell(x);
								rowCell.className ="normalfntMid";			
								rowCell.innerHTML ="<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+
								"<input type=\"text\" style=\"width:158px; text-align:center;\"/>"	+"</td>"		
								}
							}
					cellNo++;
				}
				
			}	
				
		
		if (colors.length <= 0)
		{
			colors[0] = "N/A";
		}
		
		if (sizes.length <= 0)
		{
			sizes[0] = "N/A";
		}

			//alert(colors[i]);
}

