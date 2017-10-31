// JavaScript Document

var prepack_combo	="<select class=\"txtbox keymove\" style=\"width:100px\" tabindex=\"3\" onkeypress='addR(this,event);' >";
prepack_combo		+="<option value=\"BULK\">BULK</option>";
prepack_combo		+="<option value=\"MULTIPLE\">MULTIPLE</option>";
prepack_combo		+="<option value=\"SINGLE\">SINGLE</option>";
prepack_combo		+="</select>";


function saveDetails()
{
	var editOrderNO		 = $('#cboInvoiceNo').val();
	var orderNo     	 = URLEncode($('#txtOrderNo').val());
	var styleNo     	 = URLEncode($('#txtStyleNo').val());
	var styleDesc   	 = URLEncode($('#txtStyleDesc').val());
	var unitPrice   	 = URLEncode($('#txtunitPrice').val());
	//var maxRePrice  	 = URLEncode($('#txtMaxRePrice').val());
	var quality		     = URLEncode($('#txtQuality').val());
	var gender      	 = URLEncode($('#txtGender').val());
	var mateNo      	 = URLEncode($('#txtMateNo').val());
	//var fabric      	 = URLEncode($('#txtFabric').val());
	//var label       	 = URLEncode($('#txtLabel').val());
	var season      	 = URLEncode($('#txtSeason').val());
	var buyer       	 = URLEncode($('#txtBuyer').val());
	var division    	 = URLEncode($('#txtDivision').val());
	var itemNo      	 = URLEncode($('#txtItemNo').val());
	var Item        	 = URLEncode($('#txtItem').val());
	var sortingType 	 = URLEncode($('#txtSortingType').val());
	var washCode    	 = URLEncode($('#txtWashCode').val());
	var constructionType = URLEncode($('#txtConstructionType').val());
	var garment          = URLEncode($('#txtGarment').val());
	var unitP    		 = URLEncode($('#cboUmoQty1').val());
	if(orderNo=="")
	{
		alert("Enter Order Number !");
		document.getElementById('txtOrderNo').focus();
		return false;
	}
	else if(styleNo=="")
	{
		alert("Enter Style Number !");
		document.getElementById('txtStyleNo').focus();
		return false;
	}
	else if(unitPrice=="")
	{
		alert("Enter WFX ID !");
		document.getElementById('txtunitPrice').focus();
		return false;
	}
	else if(unitP=="")
	{
		alert("Select Price Unit !");
		document.getElementById('txtunitPrice').focus();
		return false;
	}
	
	
	var url = "orderspec_ajax.php?REQUEST=saveDetails&orderNo="+orderNo+"&styleNo="+styleNo+"&styleDesc="+styleDesc+"&unitPrice="+unitPrice+"&quality="+quality;
		url += "&gender="+gender+"&mateNo="+mateNo+"&season="+season+"&buyer="+buyer+"&division="+division+"&itemNo="+itemNo;
		url += "&Item="+Item+"&sortingType="+sortingType+"&unitP="+unitP+"&washCode="+washCode+"&constructionType="+constructionType+"&garment="+garment+"&editOrderNo="+editOrderNO;
	
	var rsl = checkOrderNo();
	var orcerNO = $('#txtOrderNo').val();
	if(rsl==1)
	{
		alert("Order Number : "+orcerNO+" Already Exist !");
		return false;
	}
	
	var res = $.ajax({url:url,async:false});
	var OrderID = res.responseText;
	if(res.responseText!=-99 && res.responseText!="")
	{
		alert("Data Saved Successfully !");
		//window.location.reload();
		var opt = document.createElement("option");
        

        // Assign text and value to Option object
        opt.text = orderNo;
        opt.value = OrderID;
		document.getElementById("cboInvoiceNo").options.add(opt);
		document.getElementById("cboInvoiceNo").value=OrderID;
	}
	else
	{
		alert("Data Saved Successfully !");
	}
}

function loadDetails()
{
	var orderno = $('#cboInvoiceNo').val();
	
	if(orderno=="")
	{
		document.getElementById('txtOrderNo').disabled=false;
	}
	else
	{
		document.getElementById('txtOrderNo').disabled=true;
	}
	
	if(orderno=="")
	{
		window.location.reload();
		return false;
	}
	var url = "orderspec_ajax.php?REQUEST=loadDetails&orderno="+orderno;
	
	var res = $.ajax({url:url,async:false});
	
	$('#txtOrderNo').val($('#cboInvoiceNo option:selected').text());
	$('#txtStyleNo').val(res.responseXML.getElementsByTagName("strStyle_No")[0].childNodes[0].nodeValue);
	$('#txtStyleDesc').val(res.responseXML.getElementsByTagName("strStyle_Description")[0].childNodes[0].nodeValue);
	$('#txtunitPrice').val(res.responseXML.getElementsByTagName("dblUnit_Price")[0].childNodes[0].nodeValue);
	//$('#txtMaxRePrice').val(res.responseXML.getElementsByTagName("dblMax_retail_price")[0].childNodes[0].nodeValue);
	$('#txtQuality').val(res.responseXML.getElementsByTagName("strQuality")[0].childNodes[0].nodeValue);
	$('#txtGender').val(res.responseXML.getElementsByTagName("strGender")[0].childNodes[0].nodeValue);
	$('#txtMateNo').val(res.responseXML.getElementsByTagName("strMaterial")[0].childNodes[0].nodeValue);
	//$('#txtFabric').val(res.responseXML.getElementsByTagName("strFabric")[0].childNodes[0].nodeValue);
	$('#cboUmoQty1').val(res.responseXML.getElementsByTagName("strUnit")[0].childNodes[0].nodeValue);
	$('#txtSeason').val(res.responseXML.getElementsByTagName("strSeason")[0].childNodes[0].nodeValue);
	$('#txtBuyer').val(res.responseXML.getElementsByTagName("strBuyer")[0].childNodes[0].nodeValue);
	$('#txtDivision').val(res.responseXML.getElementsByTagName("strDivision_Brand")[0].childNodes[0].nodeValue);
	$('#txtItemNo').val(res.responseXML.getElementsByTagName("strItem_no")[0].childNodes[0].nodeValue);
	$('#txtItem').val(res.responseXML.getElementsByTagName("strItem")[0].childNodes[0].nodeValue);
	$('#txtSortingType').val(res.responseXML.getElementsByTagName("strSorting_Type")[0].childNodes[0].nodeValue);
	$('#txtWashCode').val(res.responseXML.getElementsByTagName("strWash_Code")[0].childNodes[0].nodeValue);
	$('#txtConstructionType').val(res.responseXML.getElementsByTagName("strConstruction")[0].childNodes[0].nodeValue);
	$('#txtGarment').val(res.responseXML.getElementsByTagName("strGarment_Type")[0].childNodes[0].nodeValue);
}

function clearForm()
{
	window.location.reload();
}

function checkOrderNo()
{
		var id =  $('#cboInvoiceNo').val();
		var orcerNO = $('#txtOrderNo').val();
		var url = "orderspec_ajax.php?REQUEST=checkOrderExist&orderno="+orcerNO+"&id="+id;
		var res = $.ajax({url:url,async:false});
		
		if(res.responseText==1)
		{
			return 1;
		}	
}

function getInvoiceDetail()
{
	var orderID = document.getElementById("cboInvoiceNo").value;
	var detailGrid = document.getElementById('tblSizes');
	
	if(orderID=="")
	{
		alert("Select Order Number !");
		pageReload();
	}
	for(var j=detailGrid.rows.length-1;j>0;j--)
	{
		detailGrid.deleteRow(j);
	}
		
	
	var url = "orderspec_ajax.php?REQUEST=loadDataGrid&orderID="+orderID;
	var res = $.ajax({url:url,async:false});
	/*if( res.responseXML.getElementsByTagName("strSize")[0])
	{*/
		    var size  		= res.responseXML.getElementsByTagName("strSize");
			var color  		= res.responseXML.getElementsByTagName("strColor");
			var color_code  = res.responseXML.getElementsByTagName("ColorCode");
			var pcs   		= res.responseXML.getElementsByTagName("dblPcs");
			var net    		= res.responseXML.getElementsByTagName("dblNet");
			var desc   		= res.responseXML.getElementsByTagName("strDescription");
			var MRP    		= res.responseXML.getElementsByTagName("MRP");
			var SKU    		= res.responseXML.getElementsByTagName("SKU");
			var Fabric 		= res.responseXML.getElementsByTagName("Fabric");
			var pliNo 		= res.responseXML.getElementsByTagName("PliNo");
			var prePackNo 	= res.responseXML.getElementsByTagName("PrePackNo");
			var prePackType = res.responseXML.getElementsByTagName("PrePackType");
			var pack_upc = res.responseXML.getElementsByTagName("PackUpc");
			
	//alert(res.responseXML.getElementsByTagName("PrePackType"));
	if(!size.length>0)
	{
		addRow();
	}
		
		
		for(var x=0;x<size.length;x++)
		{
			
			
			
			var lastRow 		= detailGrid.rows.length;	
			var row 			= detailGrid.insertRow(lastRow);
			row.className       = "bcgcolor-tblrowWhite";
			var cellDelete = row.insertCell(0); 
					cellDelete.className ="normalfntMid";	
					cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" style=\"cursor:pointer\" onclick=\"delRow(this);\"/>";	
			
					var rowCell = row.insertCell(1);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML ="<input  type='text' align='center' tabindex='3' value='"+size[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:70px; '  maxlength='30'/>";
					
					var rowCell = row.insertCell(2);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' tabindex='3' value='"+color[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:120px; '  maxlength='50'/>";
					
					var rowCell = row.insertCell(3);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' tabindex='3' value='"+color_code[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:100px; '  maxlength='50'/>";
					
					var rowCell = row.insertCell(4);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+pcs[x].childNodes[0].nodeValue+"' onkeypress='return CheckforValidDecimal(this.value, 4,event);' class='txtbox' style='text-align:center; width:80px; '  maxlength='12'/>";
					
					var rowCell = row.insertCell(5);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+net[x].childNodes[0].nodeValue+"' onkeypress='return CheckforValidDecimal(this.value, 4,event);' class='txtbox' style='text-align:center; width:80px; '  maxlength='12'/>";
					
					var rowCell = row.insertCell(6);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+MRP[x].childNodes[0].nodeValue+"' onkeypress='return CheckforValidDecimal(this.value, 4,event);' class='txtbox' style='text-align:center; width:80px; '  maxlength='14'/>";
					
					var rowCell = row.insertCell(7);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+SKU[x].childNodes[0].nodeValue+"'  class='txtbox' style='text-align:center; width:100px; '  maxlength='40s'/>";
					
					var rowCell = row.insertCell(8);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+Fabric[x].childNodes[0].nodeValue+"'  class='txtbox' style='text-align:center; width:120px; '  maxlength='200'/>";
					
					var rowCell = row.insertCell(9);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+desc[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:120px; '  maxlength='400' />";
					
					var rowCell = row.insertCell(10);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+pliNo[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:120px; '  maxlength='200'/>";
					
					var rowCell = row.insertCell(11);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+prePackNo[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:120px; '  maxlength='200'/>";
					
					var rowCell = row.insertCell(12);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = prepack_combo;
					
					detailGrid.rows[lastRow].cells[12].childNodes[0].value=prePackType[x].childNodes[0].nodeValue;
					
					
					var rowCell = row.insertCell(13);
					rowCell.className ="normalfntMid";			
					rowCell.innerHTML = "<input  type='text' align='center' tabindex='3' value='"+pack_upc[x].childNodes[0].nodeValue+"' class='txtbox' style='text-align:center; width:120px; '  maxlength='400' />";
					
					
					
		}
	//}
}

function addRow()
{
	var detailGrid = document.getElementById('tblSizes');
	var lastRow    = detailGrid.rows.length;
	var row 	   = detailGrid.insertRow(lastRow);
	row.className       = "bcgcolor-tblrowWhite";
	
	var color 				= "";
	var pcs   				= "";
	var price				= "";
	var MRP  			 	= "";
	var SKU  				= "";
	var Fabric   			= "";
	var DescOfGoods   		= "";
	var color_code   		= "";
	var plino				= "";
	var prePackNo			= "";
	var prePackType			= "";
	var pack_upc            ="";

	if(detailGrid.rows[lastRow-1].cells[2].childNodes[0].value)
		color = detailGrid.rows[lastRow-1].cells[2].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[3].childNodes[0].value)
		color_code = detailGrid.rows[lastRow-1].cells[3].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[4].childNodes[0].value)
		pcs = detailGrid.rows[lastRow-1].cells[4].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[5].childNodes[0].value)
		price = detailGrid.rows[lastRow-1].cells[5].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[6].childNodes[0].value)
		MRP = detailGrid.rows[lastRow-1].cells[6].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[7].childNodes[0].value)
		SKU = detailGrid.rows[lastRow-1].cells[7].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[8].childNodes[0].value)
		Fabric = detailGrid.rows[lastRow-1].cells[8].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[9].childNodes[0].value)
		DescOfGoods = detailGrid.rows[lastRow-1].cells[9].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[10].childNodes[0].value)
		plino = detailGrid.rows[lastRow-1].cells[10].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[11].childNodes[0].value)
		prePackNo = detailGrid.rows[lastRow-1].cells[11].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[12].childNodes[0].value)
		prePackType = detailGrid.rows[lastRow-1].cells[12].childNodes[0].value;
	if(detailGrid.rows[lastRow-1].cells[13].childNodes[0].value)
		pack_upc = detailGrid.rows[lastRow-1].cells[13].childNodes[0].value;
	
	var str           = "<td  class='normalfntMid'><img height='15' style=\"cursor:pointer\" width='15' maxlength='15' alt='del' onclick='delRow(this);'";
				str  +=	" src='../../../images/del.png'></td><td  height='25' align='center'><input  type='text' tabindex='3' class='txtbox'";
				str  += " style='text-align:center; width:70px; ' id='txtGarments2'  maxlength='30'  /></td>";
                str  += " <td  align='center'><input  type='text' class='txtbox'   tabindex='3' style='text-align:center; width:120px; '";
				str  += " id='txtGarments2'  maxlength='50' value='"+color+"'  /></td>";
				str  += " <td  align='center'><input  type='text' class='txtbox'   tabindex='3' style='text-align:center; width:100px; '";
				str  += " id='txtGarments2'  maxlength='50' value='"+color_code+"'  /></td><td  align='center' ><input  type='text' class='txtbox'   tabindex='3'";
				str  += " style='text-align:center; width:80px; ' id='txtGarments2'  maxlength='12' onkeypress='return CheckforValidDecimal(this.value, 4,event);' value='"+pcs+"'";
				str  += " /></td><td  align='center' ><input  type='text' class='txtbox'   tabindex='3' style='text-align:center; width:80px; '";
				str  += " id='txtGarments2'  maxlength='12' value='"+price+"' onkeypress='return CheckforValidDecimal(this.value, 4,event);' style='text-align:center; width:80px; '/></td>";
                str  += " <td  align='center' ><input  type='text' class='txtbox' value='"+MRP+"' tabindex='3' style='text-align:center;  width:80px; ' ";
				str  += " id='txtGarments2'  maxlength='14'  onkeypress='return CheckforValidDecimal(this.value, 4,event);'/></td>";
				
				str  += " <td  align='center' ><input  type='text' class='txtbox'   value='"+SKU+"' tabindex='3' style='text-align:center;  width:100px; '";
				str  += " id='txtGarments2'  maxlength='40'  /></td>";
				
				str  += " <td  align='center' ><input  type='text' class='txtbox' value='"+Fabric+"'   tabindex='3' style='text-align:center;  width:120px; '";
				str  += " id='txtGarments2'  maxlength='200'  /></td>";
				
				str  += " <td  align='center' ><input  type='text' class='txtbox'  value='"+DescOfGoods+"'  tabindex='3' style='text-align:center;  width:120px; ' ";
				str  += " id='txtGarments2'  maxlength='200'  /></td>";
				
				str  += " <td  align='center' ><input  type='text' class='txtbox'  value='"+plino+"'  tabindex='3' style='text-align:center;  width:120px; '";
				str  += " id='pliNo'  maxlength='10'  /></td>";
				
				str  += " <td  align='center' ><input  type='text' class='txtbox'  value='"+prePackNo+"'  tabindex='3' style='text-align:center;  width:120px; '";
				str  += " id='prePackNo'  maxlength='10'  /></td>";
				
				str  += " <td  align='center' >"+prepack_combo+"</td>";
				
				
				str  += " <td  align='center' ><input  type='text' class='txtbox'  value='"+pack_upc+"'  tabindex='3' style='text-align:center;  width:120px; '";
				str  += " id='pack_upc'  maxlength='10'  /></td>";
				
	row.innerHTML = str;
	
	if(prePackType!="")
		detailGrid.rows[lastRow].cells[12].childNodes[0].value=prePackType;	
		
		
}

function pageReload()
{
setTimeout("location.reload(true)",100);
}



function saveDetailData()
{
	//alert ("ooo");
	var detailGrid = document.getElementById('tblSizes');
	var orderID = document.getElementById("cboInvoiceNo").value;
	
	if(!(detailGrid.rows.length>1))
	{
		alert("Enter Data !");
		return false;
	}
	
	var url3 = "orderspec_ajax.php?REQUEST=DeleteDetail&orderID="+orderID;
	var res = $.ajax({url:url3,async:false});
	
	var qtySum = 0;
	var arr = [];
	for(var i=1;i<detailGrid.rows.length;i++)
	{	
		//alert("sd");
		if(URLEncode(detailGrid.rows[i].cells[1].childNodes[0].value)!='')
		{
			//alert(detailGrid.rows[i].cells[4].childNodes[0].value);
			qtySum += parseFloat(detailGrid.rows[i].cells[4].childNodes[0].value); 
			
			
			var url = "orderspec_ajax.php?REQUEST=saveDetailData&orderID="+orderID;
			url    += "&size="+URLEncode(detailGrid.rows[i].cells[1].childNodes[0].value);
			url    += "&colour="+URLEncode(detailGrid.rows[i].cells[2].childNodes[0].value);
			url    += "&color_code="+URLEncode(detailGrid.rows[i].cells[3].childNodes[0].value);
			url    += "&pcs="+URLEncode(detailGrid.rows[i].cells[4].childNodes[0].value);
			url    += "&net="+URLEncode(detailGrid.rows[i].cells[5].childNodes[0].value);
			url    += "&mrp="+URLEncode(detailGrid.rows[i].cells[6].childNodes[0].value);
			url    += "&sku="+URLEncode(detailGrid.rows[i].cells[7].childNodes[0].value);
			url    += "&fab="+URLEncode(detailGrid.rows[i].cells[8].childNodes[0].value);
			url    += "&desc="+URLEncode(detailGrid.rows[i].cells[9].childNodes[0].value);
			url    += "&plino="+URLEncode(detailGrid.rows[i].cells[10].childNodes[0].value);
			url    += "&prepackno="+URLEncode(detailGrid.rows[i].cells[11].childNodes[0].value);
			url    += "&prepacktype="+URLEncode(detailGrid.rows[i].cells[12].childNodes[0].value);
			url    += "&pack_upc="+URLEncode(detailGrid.rows[i].cells[13].childNodes[0].value);
			//alert (detailGrid.rows[i].cells[13].childNodes[0].value);
			
			/*if(detailGrid.rows[i].cells[1].childNodes[0].value=="" || detailGrid.rows[i].cells[2].childNodes[0].value || detailGrid.rows[i].cells[3].childNodes[0].value)
			{
				alert("Enter Size, Color And Pcs !");
				return false;
			}*/
			var res = $.ajax({url:url,async:false});
			//alert(res.responseText);
		}
	}
	
	var url2 = "orderspec_ajax.php?REQUEST=saveHeadData&orderID="+orderID+"&totsum="+qtySum;
	var res = $.ajax({url:url2,async:false});
	alert("Data Saved Successfully !");
	
}

function addR(obj,evt)
{
	var detailGrid = document.getElementById('tblSizes');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(detailGrid.rows.length-1))
		{
			addRow();
		}
	}
}


function delRow(obj)
{
	var rowNo=obj.parentNode.parentNode.rowIndex;
	var detailGrid = document.getElementById('tblSizes');
	
	detailGrid.deleteRow(rowNo);
	
	
}