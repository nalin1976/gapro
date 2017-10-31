// JavaScript Document

var prepack_combo	="<select class=\"txtbox keymove\" style=\"width:100px\" tabindex=\"3\" >";
prepack_combo		+="<option value=\"3Bulk\">Bulk</option>";
prepack_combo		+="<option value=\"2Ratio\">Ratio</option>";
prepack_combo		+="<option value=\"1Pre Pack\">Pre Pack</option>";
prepack_combo		+="</select>";

var pre_combo	="<select class=\"txtbox\" style=\"width:100px\" tabindex=\"3\" >";
pre_combo		+="<option value=\"1Pre Pack\">Pre Pack</option>";
pre_combo		+="</select>";

var bulk_combo	="<select class=\"txtbox\" style=\"width:100px\" tabindex=\"3\" >";
bulk_combo		+="<option value=\"3Bulk\">Bulk</option>";
bulk_combo		+="</select>";

var ratio_combo	="<select class=\"txtbox\" style=\"width:100px\" tabindex=\"3\" >";
ratio_combo		+="<option value=\"2Ratio\">Ratio</option>";
ratio_combo		+="</select>";

var color_combo="";

var sizeArray=[];
var colorArray=[];
var size_combo="";
var pub_ctns_wt =[];

var qtyArr=[];
var ctnArr=[];
var ctnPackArr=[];

var arrRatioTotQty=[];
var arrRatioRows=[];

var prePackSizeArr = [];
var prePackColorArr = [];
var prePackTypeArr = [];
var prePackNoArr = [];

var ctnF=1;
var ctnT=0;

var start_sizes	=4;

var ctn_combo	="<select class=\"txtbox keymove\" style=\"width:100px\">";
gen_ctns_combo();



function validateOrderPackType()
{
	if(document.getElementById('cboOrder').value=='Select One')
		alert("Please Select Order No");
	else
	{
		if(document.getElementById('chk_pre').checked==true || document.getElementById('chk_bulk').checked==true || document.getElementById('chk_ratio').checked==true)
		{
			loadSizeColorArray();
			loadPackingDetGrid();
			loadCartonDet();
			loadPackNoDetArray();
		}
		else
			alert("Please Select a Pack Type");
	}
}

function loadPackNoDetArray()
{
	var orderId=document.getElementById('cboOrder').value;
	//alert(orderId);
	
	var url				='packinglistWizard-db.php?request=load_pre_pack_no&poNo='+orderId;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_Size    	=xml_http_obj.responseXML.getElementsByTagName('Size');
	var xml_Color		=xml_http_obj.responseXML.getElementsByTagName('Color');
	var xml_PrePackType	=xml_http_obj.responseXML.getElementsByTagName('PrePackType');
	var xml_PrePackNo	    =xml_http_obj.responseXML.getElementsByTagName('PrePackNo');
	
	for(var i=0;i<xml_Size.length;i++) 
	{
		var Size				=xml_Size[i].childNodes[0].nodeValue;
		//alert(Size);
		var Color				=xml_Color[i].childNodes[0].nodeValue;
		//alert(Color);
		if(xml_PrePackType[i].childNodes[0].nodeValue=='SINGLE')
			var PrePackType			= '1Pre Pack';
		if(xml_PrePackType[i].childNodes[0].nodeValue=='MULTIPLE')
			var PrePackType			= '2Ratio';
		if(xml_PrePackType[i].childNodes[0].nodeValue=='BULK')
			var PrePackType			= '3Bulk';
		var PrePackNo			=xml_PrePackNo[i].childNodes[0].nodeValue;
		
		prePackSizeArr[i] = Size;
		prePackColorArr[i] = Color;
		prePackTypeArr[i] = PrePackType;
		prePackNoArr[i] = PrePackNo;
		
	}
	
}

function loadPackingDetGrid()
{
	var colspanNo=sizeArray.length-1;
	var orderId=document.getElementById('cboOrder').value;
	var innerString="";
	var width=300/parseInt(sizeArray.length);
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";                  
    innerString+="<td width='138' height='25' style='text-align:center' rowspan='2'>Color</td>";
    innerString+="<td width='300' style='text-align:center' colspan=\""+colspanNo+"\">Size</td>";
    innerString+="<td width='108' style='text-align:center' rowspan='2'>Pack Type</td>";
    innerString+="</tr>";
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";
	for(var x=0;x<sizeArray.length-1;x++)                  
    	innerString+="<td style='text-align:center'>"+sizeArray[x]+"</td>";
    innerString+="</tr>";
	
	
	for(var i=0;i<colorArray.length-1;i++)
		{
			if(document.getElementById('chk_pre').checked==true)
			{
				//oncontextmenu 	= ItemSelMenu;
			  innerString+="<tr class='bcgcolor-tblrowWhite' ondblclick=deleteRow(this);>";
			  innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid' nowrap='nowrap'>"+colorArray[i]+"</td>";
			  for(var j=0;j<sizeArray.length-1;j++)
			  {
				  if(document.getElementById('chk_addOrderQty').checked==true)
				  {
					 var orderQty=getOrderQty(colorArray[i],orderId,sizeArray[j],'SINGLE');
					innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center;' value=\""+orderQty+"\" /></td>";
				  }
				  else
				  	innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' /></td>";
			  }
			  innerString+="<td width='108' height='25' style='text-align:center' class='normalfntMid'>"+pre_combo+"</td>";
			}
		}
		for(var i=0;i<colorArray.length-1;i++)
		{
			if(document.getElementById('chk_ratio').checked==true)
			{
				innerString+="<tr class='bcgcolor-tblrowWhite' ondblclick=deleteRow(this);>";
				innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid'>"+colorArray[i]+"</td>";
				for(var j=0;j<sizeArray.length-1;j++)
				{
				  if(document.getElementById('chk_addOrderQty').checked==true)
				  {
					 var orderQty=getOrderQty(colorArray[i],orderId,sizeArray[j],'MULTIPLE');
					innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' value=\""+orderQty+"\" /></td>";
				  }
				  else                  
    				innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' /></td>";
				}
				innerString+="<td width='108' height='25' style='text-align:center' class='normalfntMid'>"+ratio_combo+"</td>";
			}
		}
		for(var i=0;i<colorArray.length-1;i++)
		{
			if(document.getElementById('chk_bulk').checked==true)
			{
				innerString+="<tr class='bcgcolor-tblrowWhite' ondblclick=deleteRow(this);>";
				innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid'>"+colorArray[i]+"</td>";
				for(var j=0;j<sizeArray.length-1;j++)
				{
				  if(document.getElementById('chk_addOrderQty').checked==true)
				  {
					var orderQty=getOrderQty(colorArray[i],orderId,sizeArray[j],'BULK');
					innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' value=\""+orderQty+"\" /></td>";
				  }
				  else                  
    				innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' /></td>";
				}
				innerString+="<td width='108' height='25' style='text-align:center' class='normalfntMid'>"+bulk_combo+"</td>";
			}
		}
			
	document.getElementById('tblPackingListDet').innerHTML=innerString;
	$("#tblPackingListDet").tableDnD();
}

function getOrderQty(color,orderId,size,prePack)
{
	var url="packinglistWizard-db.php?request=load_OrderQty";
	   url+="&color="+color;
	   url+="&orderId="+orderId;
	   url+="&size="+size;
	   url+="&preType="+prePack;
	var http_qty_obj=$.ajax({url:url,async:false});
	//alert(http_qty_obj.responseText);
	return http_qty_obj.responseText;
}

function packType()
{
	var innerString="";
	for(var i=0;i<colorArray.length-1;i++)
		{
			innerString+="<tr class='bcgcolor-tblrowWhite'>";
			innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid'>"+colorArray[i]+"</td>";
			for(var j=0;j<sizeArray.length-1;j++)                  
    			innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' /></td>";
				innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid'>Pre Pack</td>";
		}
		return innerString;
}

function gen_ctns_combo()
{
	
	var url				='packinglistWizard-db.php?request=gen_ctns_combo';
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_CartonId	=xml_http_obj.responseXML.getElementsByTagName('CartonId');
	var xml_Carton		=xml_http_obj.responseXML.getElementsByTagName('Carton');
	var xml_Weight		=xml_http_obj.responseXML.getElementsByTagName('Weight');
	ctn_combo			="<select class=\"txtbox keymove\" style=\"width:120px\"><option value=''></option>";	
	for(var i=0;i<xml_CartonId.length;i++) 
	{
		var id				=xml_CartonId[i].childNodes[0].nodeValue;
		var Carton			=xml_Carton[i].childNodes[0].nodeValue;
		var Weight			=xml_Weight[i].childNodes[0].nodeValue;
		pub_ctns_wt[id]		=Weight
		ctn_combo		  	+="<option value=\""+id+"\">"+Carton+"</option>";
				  
		
	}
	ctn_combo		   +="</select>";
}

function loadSizeColorArray()
{
	color_combo="";
	var orderId=document.getElementById('cboOrder').value;
	var styleId=$("#cboOrder option:selected").text()
	
	var url="packinglistWizard-db.php?request=load_size";
		url+="&orderId="+styleId;
	var http_size_obj=$.ajax({url:url,async:false});
	var size=http_size_obj.responseText;
	
	sizeArray = size.split(',');
	
	var url="packinglistWizard-db.php?request=load_color";
		url+="&orderId="+orderId;
	var http_color_obj=$.ajax({url:url,async:false});
	var color=http_color_obj.responseText;
	
	colorArray = color.split(',');
	
	
	color_combo += "<select class=\"txtbox keymove\" style=\"width:100px\" >";
	for(var i=0; i<colorArray.length; i++)
		color_combo+="<option value=\""+colorArray[i]+"\">"+colorArray[i]+"</option>";
		
	color_combo +="</select>";
}

function loadCartonDet()
{
	var colspanNo=sizeArray.length-1;
	
	var innerString="";
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";                  
    innerString+="<td width='100' height='25' style='text-align:center' rowspan='2'>CTN Type</td>";
    innerString+="<td width='100' style='text-align:center' rowspan='2' >Pack Type</td>";
    innerString+="<td width='100' style='text-align:center' rowspan='2' >Color</td>";
	innerString+="<td width='108' style='text-align:center' colspan=\""+colspanNo+"\">Sizes</td>";
    innerString+="</tr>";
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";
	
	for(var x=0;x<sizeArray.length-1;x++)                  
    	innerString+="<td style='text-align:center'>"+sizeArray[x]+"</td>";
    innerString+="</tr>";
	
	innerString+="<tr class='bcgcolor-tblrowWhite'>";
	innerString+="<td width='100' style='text-align:center'>"+ctn_combo+"</td>";
	innerString+="<td width='100' style='text-align:center'>"+prepack_combo+"</td>";
	innerString+="<td width='100' style='text-align:center'>"+color_combo+"</td>";
	
	for(var j=0;j<sizeArray.length-1;j++)
	{
		if(j==0)
		      innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10'  onkeypress='return CheckforValidDecimal(this.value, 4,event);' onkeyup='fillTextboxes(this);' style='text-align:center' onblur='fillTextboxes(this);'  /></td>";
		else if(j!=sizeArray.length-2)            
    		innerString+="<td style='text-align:center' class='normalfntMid'><input type='text' class='txtbox' size='10' onkeypress='return CheckforValidDecimal(this.value, 4,event);' style='text-align:center' /></td>";
		else
			innerString+="<td style='text-align:center' class='normalfntMid'><input type='text' class='txtbox' size='10' onkeypress='return CheckforValidDecimal(this.value, 4,event);' onkeydown=\"addRCtn(this,event);\" style='text-align:center' /></td>";
	}
	
	document.getElementById('tblCartonDet').innerHTML=innerString;
	
}

function addRCtn(obj,evt)
{
	var tblPLDetails = document.getElementById('tblCartonDet');
	
	if (evt.keyCode == 9)
	{
		if(obj.parentNode.parentNode.rowIndex==(tblPLDetails.rows.length-1))
		{
			addRowCtn();
		}
	}
}

function addRowCtn()
{
	var tblCartonDet = document.getElementById('tblCartonDet');
	var lastRow    = tblCartonDet.rows.length;
	
	  var row 	   = tblCartonDet.insertRow(lastRow);
	  row.className  = "bcgcolor-tblrowWhite";
	  var str           = "<td  class='normalfntMid' height='25'>"+ctn_combo+"</td>";
				  str  += "<td  class='normalfntMid'>"+prepack_combo+"</td>";
				  str  += "<td  class='normalfntMid'>"+color_combo+"</td>";
	for(var j=0;j<sizeArray.length-1;j++)
	{
		if(j==0)
		      str+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' onkeypress='return CheckforValidDecimal(this.value, 4,event);' onblur='fillTextboxes(this);' style='text-align:center'  /></td>";
		else if(j!=sizeArray.length-2)            
    		str+="<td style='text-align:center' class='normalfntMid'><input type='text' class='txtbox' size='10' onkeypress='return CheckforValidDecimal(this.value, 4,event);' style='text-align:center' /></td>";
		else
			str+="<td style='text-align:center' class='normalfntMid'><input type='text' class='txtbox' size='10' onkeypress='return CheckforValidDecimal(this.value, 4,event);' onkeydown=\"addRCtn(this,event);\" style='text-align:center' /></td>";
	}
	  row.innerHTML = str;	
}

function fillTextboxes(obj)
{
	var tblCartonDet = document.getElementById('tblCartonDet');

	var qty=obj.value;
	
	var rwIndex=obj.parentNode.parentNode.rowIndex;
	
	if(tblCartonDet.rows[rwIndex].cells[1].childNodes[0].value=='1Pre Pack' || tblCartonDet.rows[rwIndex].cells[1].childNodes[0].value=='3Bulk')
	{	
		for(x=2;x<tblCartonDet.rows[rwIndex].cells.length;x++)
			tblCartonDet.rows[rwIndex].cells[x].childNodes[0].value=qty;
	}
}

/*function loadPLGrid()
{}*/
 
 function calculateRatio(rwIndex, color)
 {
	 //alert(rwIndex);
	 var tblCartonDet = document.getElementById('tblCartonDet');
	 var tblPackingData=document.getElementById('tblPackingData');
	 //var color = tblPackingData.rows[rwIndex].cells[0].childNodes[0].nodeValue;
	 var i=0;
	 for(var x=2;x<tblCartonDet.rows.length;x++)
	 {
		 var tot=0;
		 if(tblCartonDet.rows[x].cells[1].childNodes[0].value=='2Ratio' && tblCartonDet.rows[x].cells[2].childNodes[0].value==color)
		 {
			 for(var y=3;y<tblCartonDet.rows[x].cells.length;y++)
			 {
				 //alert(tblCartonDet.rows[x].cells[y].childNodes[0].value);
				 if(tblCartonDet.rows[x].cells[y].childNodes[0].value=='' || tblCartonDet.rows[x].cells[y].childNodes[0].value==0)
				 	var value=0;
				else
				    var value= parseFloat(tblCartonDet.rows[x].cells[y].childNodes[0].value);
				 
				 tot+=value;
			 }
			 arrRatioTotQty[i]=tot;
			 arrRatioRows[i]=x;
			 i++;
			// alert(arrRatioRows[i]);
		 }
		 
	 }
	 
	 sortArrRatioTotQty();
	 if(arrRatioTotQty.length>0)
	 	inputRowForRatio(rwIndex);
	 
 }
 
 function sortArrRatioTotQty()
 {
	 var x, y, holder, holder1;
  // The Bubble Sort method.
  for(x = 0; x < arrRatioTotQty.length; x++) 
  {
    for(y = 0; y < (arrRatioTotQty.length-1); y++) 
	{
      if(arrRatioTotQty[y] < arrRatioTotQty[y+1]) 
	  {
        holder = arrRatioTotQty[y+1];
		holder1= arrRatioRows[y+1];
		
        arrRatioTotQty[y+1] = arrRatioTotQty[y];
        arrRatioRows[y+1] = arrRatioRows[y];
		
		arrRatioTotQty[y] = holder;
		arrRatioRows[y] = holder1;
      }
    }
  }
  //alert(arrRatioRows);
 }
 

function getCartonArray(packTypePack)
{
	var tblCartonDet = document.getElementById('tblCartonDet');
	qtyArr=[];
	ctnArr=[];
	ctnPackArr=[];
	var chk=0;
	var i=0;
	
	for(var x=2;x<tblCartonDet.rows.length;x++)
	{
		if(packTypePack==tblCartonDet.rows[x].cells[1].childNodes[0].value)
		{
			chk=1;
			//alert(i);
			qtyArr[i]=parseFloat(tblCartonDet.rows[x].cells[3].childNodes[0].value);
		
			ctnArr[i]=tblCartonDet.rows[x].cells[0].childNodes[0].value;
		
			ctnPackArr[i]=tblCartonDet.rows[x].cells[1].childNodes[0].value;
			i++;
		}//alert(ctnPackArr[x-2]);
	}
	
	var x, y, holder, holder1, holder2;
  // The Bubble Sort method.
  if(chk==1)
  {
	  for(x = 0; x < qtyArr.length; x++) 
	  {
		for(y = 0; y < (qtyArr.length-1); y++) 
		{
		  if(qtyArr[y] < qtyArr[y+1]) 
		  {
			holder = qtyArr[y+1];
			holder1= ctnArr[y+1];
			holder2= ctnPackArr[y+1]; 
			
			qtyArr[y+1] = qtyArr[y];
			ctnArr[y+1] = ctnArr[y];
			ctnPackArr[y+1] = ctnPackArr[y];
			
			qtyArr[y] = holder;
			ctnArr[y] = holder1;
			ctnPackArr[y] = holder2;
		  }
		}
	  }
	//alert(qtyArr);  
  }
}

function clearData()
{
	var tblPackingData	= document.getElementById('tblPackingData');
	for(var x=tblPackingData.rows.length-1; x>2;x--)
		tblPackingData.deleteRow(x);
}

function save_pl_no()
{
	var url					='packinglistWizard-db.php?request=save_pl_no';
	var xml_http_obj		=$.ajax({url:url,async:false});
	//alert(xml_http_obj.responseText);
	save_pl_size_index(xml_http_obj.responseText);
}

function save_pl_size_index(PLNO)
{
	var tblPackingData	= document.getElementById('tblPackingData'); 
	var orderId         = document.getElementById('cboOrder').value;
	var Style			= $("#cboOrder option:selected").text();
	var colm_index		=0;
	var plno			= PLNO;
	
	var url_pl_header='packinglistWizard-db.php?request=save_pl_header&orderId='+URLEncode(Style)+'&plno='+plno;
		var xml_http_obj1		=$.ajax({url:url_pl_header,async:false});
	
	for(var loop=0;loop<tblPackingData.rows[1].cells.length;loop++)
	{
		var size				=tblPackingData.rows[1].cells[loop].childNodes[0].nodeValue;
		//alert(size)
		var url					='shipmentpackinglistdb.php?request=save_pl_size_index&size='+size+'&colm_index='+colm_index+'&plno='+plno+'&Style='+URLEncode(Style);
		var xml_http_obj		=$.ajax({url:url,async:false});
		colm_index++;
	}
	showPleaseWait();
	save_pl_details(plno);
	hidePleaseWait();
}


function save_pl_details(PLNO)
{
		
	var plno			=PLNO;
	var row_count		=1;
	var tblPackingData	= document.getElementById('tblPackingData');
	for(var loop_row=2;loop_row<tblPackingData.rows.length;loop_row++)
	{
		
		var ctns_no_from		 =tblPackingData.rows[loop_row].cells[0].childNodes[0].nodeValue;
		var ctns_no_to   		 =tblPackingData.rows[loop_row].cells[1].childNodes[0].nodeValue;
		var CTNWeight			 =URLEncode(tblPackingData.rows[loop_row].cells[tblPackingData.rows[loop_row].cells.length-3].childNodes[0].value);
		//alert(CTNWeight);
		var tag_no				 ='';
		var shade				 ="";
		var prepack				 =URLEncode(tblPackingData.rows[loop_row].cells[tblPackingData.rows[loop_row].cells.length-1].childNodes[0].nodeValue);
		var pack				 =URLEncode(tblPackingData.rows[loop_row].cells[tblPackingData.rows[loop_row].cells.length-2].childNodes[0].value);
		var color				 =URLEncode(tblPackingData.rows[loop_row].cells[3].childNodes[0].nodeValue);
		var lengths				 ='';
		var ctns				 =parseFloat(tblPackingData.rows[loop_row].cells[2].childNodes[0].nodeValue);
		//alert(tblPackingData.rows[2].cells[5].childNodes[0].nodeValue);
		
		var pcs	=0;
	
		for(var loop=4; loop<(tblPackingData.rows[loop_row].cells.length-4);loop++)
		{
			if(tblPackingData.rows[loop_row].cells[loop].childNodes[0].nodeValue!=0)
			{	
				pcs	+=parseFloat(emty_handle_dbl(tblPackingData.rows[loop_row].cells[loop].childNodes[0].nodeValue));
				//alert(pcs);
			}
		}
		
		var qty_pcs				 =(pcs*ctns).toFixed(2);
		
		var qty_doz				 =(pcs*ctns/12).toFixed(2);
		var gross				 =0;
		var net					 =0;
		var net_net				 =0;
		var tot_gross		 	 =0;
		var tot_net				 =0;
		var tot_net_net			 =0;
			
		var colm_index			 =0;
		for(var loop_col=4;loop_col<(tblPackingData.rows[loop_row].cells.length-4);loop_col++)
		{
			var size_pcs					=tblPackingData.rows[loop_row].cells[loop_col].childNodes[0].nodeValue;
			if(size_pcs!=""&&size_pcs!=0){
				//alert(size_pcs);
			var url					='shipmentpackinglistdb.php?request=save_pl_subdetails&pcs='+size_pcs+'&colm_index='+colm_index+'&plno='+plno+'&row_index='+row_count;
			var xml_http_obj		=$.ajax({url:url,async:false});}
			colm_index++;
		}
		
		var url					 ='shipmentpackinglistdb.php?request=save_pl_details&plno='+plno+'&row_index='+row_count+'&ctns_no_from='+ctns_no_from+'&ctns_no_to='+ctns_no_to+'&shade='+shade+'&color='+color+'&lengths='+lengths+'&pcs='+pcs+'&ctns='+ctns+'&qty_pcs='+qty_pcs+'&qty_doz='+qty_doz+'&gross='+gross+'&net='+net+'&net_net='+net_net+'&tot_gross='+tot_gross+'&tot_net='+tot_net+'&tot_net_net='+tot_net_net+'&qty_pcs='+qty_pcs+'&tag_no='+tag_no+'&CTNWeight='+CTNWeight+'&prepack='+prepack+'&pack='+pack;
		var xml_http_obj		 =$.ajax({url:url,async:false});
		row_count++;
	}
	alert("Saved successfully.");
	location.href="shipmentpackinglist.php?plno="+plno;	
	//hidePleaseWait();
}

function emty_handle_dbl(obj)
{
	return (obj==""?0:obj);
}

/*function inputRowForRatio(x)
 {
	 var tblCartonDet = document.getElementById('tblCartonDet');
     var tblPackingListDet = document.getElementById('tblPackingListDet');
	 var tblPackingData	= document.getElementById('tblPackingData'); 
	 var remainder=[];
	 var packQty=[];
	 var packTypePack=[];
	 var rest=[];
	 
		var i=0	
		var exist=0;
		
	  for(var y=1; y<tblPackingListDet.rows[x].cells.length-1;y++)
	  {
		  var color=tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue;
		  if(tblPackingListDet.rows[x].cells[tblPackingListDet.rows[x].cells.length-1].childNodes[0].value=='2Ratio')
		  {
			  exist=1;
			  //alert("Exist:"+exist);
			  if(tblPackingListDet.rows[x].cells[y].childNodes[0].value=='')
			  	packQty[i]=0;
			  else
		  		packQty[i]=parseFloat(tblPackingListDet.rows[x].cells[y].childNodes[0].value);
			//alert(packQty[i]);
			i++;
		  }
	  }
	  
	  if(exist==1)
	  {
		  for(var k=0; k<arrRatioRows.length;k++)
		  {
			  //alert(arrRatioRows[k]);
			  var doBulk=0;
			  var ans=[]; 
			  var totArrQty=0;
			  var arrQtyForRow=[];
			  var ansCount=0;
			  var less=0;
			  for(var c=3; c<tblCartonDet.rows[arrRatioRows[k]].cells.length; c++)
			  {
				  if(packQty[ansCount]==0)
				  	ans[ansCount]=0;
				  else	
				  	ans[ansCount]=parseInt((packQty[ansCount])/parseFloat(tblCartonDet.rows[arrRatioRows[k]].cells[c].childNodes[0].value));
				  //alert(ans[ansCount]);
				  arrQtyForRow[ansCount]=tblCartonDet.rows[arrRatioRows[k]].cells[c].childNodes[0].value;
				  totArrQty+=ans[ansCount];
				  if(ans[ansCount]<1)
				  	less=1;
				  ansCount++;
			  }
		  	  if(less==0)
			  {
				  
				  //Sorting ans array...
				  var a, b, holder, holder1;
				   for(a = 0; a < ans.length; a++)
				  {
					for(b = 0; b < (ans.length-1); b++) 
					{
					  if(ans[b] > ans[b+1]) 
					  {
						holder = ans[b+1];
						//holder1= arrQtyForRow[b+1]; 
						
						ans[b+1] = ans[b];
						//arrQtyForRow[b+1] = arrQtyForRow[b];
						
						ans[b] = holder;
						//arrQtyForRow[b] = holder1;
					  }
					}
				  }
				  
				  
				  var noOfCtn=ans[0];
				  createANewRow(noOfCtn,arrQtyForRow,color,arrRatioRows[k]);
				  var restCount=0;
				  for(var z=3; z<tblCartonDet.rows[arrRatioRows[k]].cells.length; z++)
				  {
					 alert(packQty[restCount]);
					  rest[restCount]=parseInt((packQty[restCount])-(noOfCtn)*parseFloat(tblCartonDet.rows[arrRatioRows[k]].cells[z].childNodes[0].value));
					  //alert(rest[restCount]);
						if(rest[restCount]==0)
							doBulk=1;
					  restCount++;
				  }
				  if(doBulk==0)
				  {
					  for(var r=0; r<rest.length; r++)
					  {
						packQty[r]=rest[r];
						//alert(packQty[r]);
					  }
					  if(k==arrRatioRows.length-1 && totQty>0)
				  	  {
					//createBulkRow(rest,color);
						noOfCtn=1;
						createANewRow1(noOfCtn,arrQtyForRow,color,arrRatioRows[k],packQty);
				  	  }
				  }
				  
			  }
			  
		  }
		  
	  }
	
}*/

function createANewRow(noOfCtn,ctnValue,color,rowIndex)
{
	var tblCartonDet = document.getElementById('tblCartonDet');
    var tblPackingListDet = document.getElementById('tblPackingListDet');
	var tblPackingData	= document.getElementById('tblPackingData');
	var lastRow=document.getElementById('tblPackingData').rows.length;
	var poNo=document.getElementById('cboOrder').value; 

	
	ctnT=parseInt(ctnF)-1+parseInt(noOfCtn);
	
	var row 			= tblPackingData.insertRow(lastRow);
		row.className	= 'bcgcolor-tblrowWhite';
	
	var ctnFCell			=	row.insertCell(0);
		ctnFCell.style.textAlign= 'center';
		ctnFCell.innerHTML	= 	ctnF;
		
	var ctnTCell			=	row.insertCell(1);
		ctnTCell.style.textAlign= 'center';
		ctnTCell.innerHTML	= 	ctnT;
		
	var noCTNCell			=	row.insertCell(2);
		noCTNCell.style.textAlign= 'center';
		noCTNCell.innerHTML	= 	noOfCtn;
	
	/*var skuCell				=	row.insertCell(3);
		skuCell.style.textAlign= 'center';
		skuCell.innerHTML	= 	'';	*/
		
	var colorCell			=	row.insertCell(3);
		colorCell.style.textAlign= 'center';
		colorCell.innerHTML	= 	color;	
	var z=4;
	var tot=0;
	var packNo='';	
	for(var i=0;i<sizeArray.length-1;i++)
	{
		for(var cnt=0;cnt<prePackSizeArr.length;cnt++)
		{
			if(prePackSizeArr[cnt]==sizeArray[i] && prePackTypeArr[cnt]=='2Ratio' && prePackColorArr[cnt]==color)
				packNo = prePackNoArr[cnt]
		}
		//alert(ctnValue[i]);
		  var sizeCell			=	row.insertCell(z);
			  sizeCell.style.textAlign= 'center';
			  sizeCell.innerHTML	= 	(ctnValue[i]);
		  tot+=(ctnValue[i])*noOfCtn;
			
		z++;
	}
	
		
	var packQtyCell				=	row.insertCell(z);
		packQtyCell.style.textAlign= 'center';
		packQtyCell.innerHTML	= 	tot;
		
	var ctnComboCell			=	row.insertCell(z+1);
		ctnComboCell.style.textAlign= 'center';
		ctnComboCell.innerHTML	= 	ctn_combo;
		
	var packComboCell			=	row.insertCell(z+2);
		packComboCell.style.textAlign= 'center';
		packComboCell.innerHTML	= 	prepack_combo;
		
	var packNoCell			=	row.insertCell(z+3);
		packNoCell.style.textAlign= 'center';
		packNoCell.innerHTML	= 	packNo;
		
	tblPackingData.rows[lastRow].cells[z+1].childNodes[0].value=tblCartonDet.rows[rowIndex].cells[0].childNodes[0].value;
	tblPackingData.rows[lastRow].cells[z+1].childNodes[0].disabled=true;
	
	tblPackingData.rows[lastRow].cells[z+2].childNodes[0].value='2Ratio';
	tblPackingData.rows[lastRow].cells[z+2].childNodes[0].disabled=true;
	ctnF=parseInt(ctnT)+1;	
}

function createANewRow1(noOfCtn,ctnValue,color,rowIndex,restQty)
{
	
	var tblCartonDet = document.getElementById('tblCartonDet');
    var tblPackingListDet = document.getElementById('tblPackingListDet');
	var tblPackingData	= document.getElementById('tblPackingData');
	var lastRow=document.getElementById('tblPackingData').rows.length;
	var poNo=document.getElementById('cboOrder').value; 

	ctnT=parseInt(ctnF)-1+parseInt(noOfCtn);
	
	var row 			= tblPackingData.insertRow(lastRow);
		row.className	= 'bcgcolor-tblrowWhite';
	
	var ctnFCell			=	row.insertCell(0);
		ctnFCell.style.textAlign= 'center';
		ctnFCell.innerHTML	= 	ctnF;
		
	var ctnTCell			=	row.insertCell(1);
		ctnTCell.style.textAlign= 'center';
		ctnTCell.innerHTML	= 	ctnT;
		
	var noCTNCell			=	row.insertCell(2);
		noCTNCell.style.textAlign= 'center';
		noCTNCell.innerHTML	= 	noOfCtn;
	
	/*var skuCell				=	row.insertCell(3);
		skuCell.style.textAlign= 'center';
		skuCell.innerHTML	= 	'';	*/
		
	var colorCell			=	row.insertCell(3);
		colorCell.style.textAlign= 'center';
		colorCell.innerHTML	= 	color;	
	var z=4;
	var tot=0;	
	var packNo='';
	for(var i=0;i<sizeArray.length-1;i++)
	{
			for(var cnt=0;cnt<prePackSizeArr.length;cnt++)
			{
				if(prePackSizeArr[cnt]==sizeArray[i] && prePackTypeArr[cnt]=='2Ratio' && prePackColorArr[cnt]==color)
					packNo = prePackNoArr[cnt]
			}
			
		  var sizeCell			=	row.insertCell(z);
			  sizeCell.style.textAlign= 'center';
			  sizeCell.innerHTML	= 	(restQty[i]);
		  tot+=restQty[i];
			
		z++;
	}
	
		
	var packQtyCell				=	row.insertCell(z);
		packQtyCell.style.textAlign= 'center';
		packQtyCell.innerHTML	= 	tot;
		
	var ctnComboCell			=	row.insertCell(z+1);
		ctnComboCell.style.textAlign= 'center';
		ctnComboCell.innerHTML	= 	ctn_combo;
		
	var packComboCell			=	row.insertCell(z+2);
		packComboCell.style.textAlign= 'center';
		packComboCell.innerHTML	= 	prepack_combo;
		
	var packNoCell			=	row.insertCell(z+3);
		packNoCell.style.textAlign= 'center';
		packNoCell.innerHTML	= 	packNo;
		
	tblPackingData.rows[lastRow].cells[z+1].childNodes[0].value=tblCartonDet.rows[rowIndex].cells[0].childNodes[0].value;
	tblPackingData.rows[lastRow].cells[z+1].childNodes[0].disabled=true;
	
	tblPackingData.rows[lastRow].cells[z+2].childNodes[0].value='2Ratio';
	tblPackingData.rows[lastRow].cells[z+2].childNodes[0].disabled=true;
	ctnF=parseInt(ctnT)+1;	
}


function loadPLGrid()
{
	ctnF=1;
	ctnT=0;
	
	
	
	var tblCartonDet = document.getElementById('tblCartonDet');
	var tblPackingListDet = document.getElementById('tblPackingListDet');
	var tblPackingData	= document.getElementById('tblPackingData');
	var poNo=document.getElementById('cboOrder').value; 
	
	document.getElementById('plVisibility').style.display='inline';
	document.getElementById('nxtImage').style.display='inline';
	
	var innerString="<tr bgcolor='#498CC2' height='20' class='normaltxtmidb2'><td rowspan='2'>CTN F:</td>";
		innerString+="<td rowspan='2' style='text-align:center;'>CTN T:</td>";
		innerString+="<td rowspan='2' style='text-align:center'>No Of Ctn</td>";
		//innerString+="<td rowspan='2' style='text-align:center'>SKU No</td>";
		innerString+="<td rowspan='2' style='text-align:center'>Color</td>";
		innerString+="<td colspan=\""+(sizeArray.length-1)+"\" style='text-align:center'>Size</td>";
		innerString+="<td rowspan='2' style='text-align:center'>Pack Qty</td>";
		innerString+="<td rowspan='2' style='text-align:center'>CTN Meas:</td>";
		innerString+="<td rowspan='2' style='text-align:center'>Pack Type</td>"
		innerString+="<td rowspan='2' style='text-align:center'>Pack No</td></tr>";
		
		innerString+="<tr bgcolor='#498CC2' height='20' class='normaltxtmidb2'>";
		
		
		for(var i=0;i<sizeArray.length-1;i++)
			innerString+="<td style='text-align:center; width:30px'>"+sizeArray[i]+"</td>";
		innerString+="</tr>";
		
		document.getElementById('tblPackingData').innerHTML=innerString;	
		
		//clearData();
		
		for(var x=2; x<tblPackingListDet.rows.length; x++)
		{
			var packTypePack=tblPackingListDet.rows[x].cells[tblPackingListDet.rows[x].cells.length-1].childNodes[0].value;
			var color=tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue;
			if(packTypePack!='2Ratio')
			{
			getCartonArray(packTypePack);
			for(var y=1; y<tblPackingListDet.rows[x].cells.length-1;y++)
			{
				var packQty1=tblPackingListDet.rows[x].cells[y].childNodes[0].value;
				if(packQty1=='')
					var packQty=0;
				else
					var packQty=parseFloat(packQty1);
				var size=tblPackingListDet.rows[1].cells[y-1].childNodes[0].nodeValue;
				//alert(packQty);
				
				for(var j=0; j<qtyArr.length; j++)
				{
					//alert(qtyArr[j]);
					var lastRow=document.getElementById('tblPackingData').rows.length;
					var selectCtn=0;
					if(packTypePack==ctnPackArr[j] && packTypePack!='2Ratio' && packQty!=0)
					{
						if(j!=0 && packQty!=0)
						{
							//alert(qtyArr[j]);
							
							if(qtyArr[j]<packQty && packQty<qtyArr[j-1])
							{
								var noOfCtns=1;
								var remainder=0;
								var ctnType1=ctnArr[j-1];
								var ctnPack1=ctnPackArr[j-1];
								selectCtn=1;
							}
							else if(qtyArr[j]==packQty)
							{
								var noOfCtns=1;
								var ctnType1=ctnArr[j];
								var ctnPack1=ctnPackArr[j];
								var remainder=packQty%qtyArr[j];
							}
							else if(qtyArr[j]>packQty)
							{
								var noOfCtns=0;
								var remainder=packQty;
							}
						}
						else
						{
							//alert(packQty>qtyArr[0]);
							if(packQty>=qtyArr[0])
							{
								//alert(qtyArr[0]);
								var noOfCtns=parseInt(packQty/qtyArr[0]);
								var ctnType1=ctnArr[0];
								var ctnPack1=ctnPackArr[0];
								//alert(noOfCtns);
								var remainder=packQty%qtyArr[0];
							}
							else
							{
								var noOfCtns=0;
								var remainder=packQty;
							}
						}
							if(noOfCtns>=1)	
							{
						
								ctnT=parseInt(ctnF)-1+parseInt(noOfCtns);
						
								var row 			= tblPackingData.insertRow(lastRow);
									row.className	= 'bcgcolor-tblrowWhite';
								
								var ctnFCell			=	row.insertCell(0);
									ctnFCell.style.textAlign= 'center';
									ctnFCell.innerHTML	= 	ctnF;
									
								var ctnTCell			=	row.insertCell(1);
									ctnTCell.style.textAlign= 'center';
									ctnTCell.innerHTML	= 	ctnT;
									
								var noCTNCell			=	row.insertCell(2);
									noCTNCell.style.textAlign= 'center';
									noCTNCell.innerHTML	= 	noOfCtns;
								
									
								var colorCell			=	row.insertCell(3);
									colorCell.style.textAlign= 'center';
									colorCell.innerHTML	= 	tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue;	
								var z=4;
								var tot=0;
								var packNo='';	
								for(var i=0;i<sizeArray.length-1;i++)
								{
									//alert(size);
									//alert(sizeArray[i]);
									if(size==sizeArray[i])
									{
										for(var cnt=0;cnt<prePackSizeArr.length;cnt++)
										{
											if(prePackSizeArr[cnt]==size && prePackTypeArr[cnt]==ctnPack1 && prePackColorArr[cnt]==tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue)
												packNo = prePackNoArr[cnt]
										}
										
										var sizeCell			=	row.insertCell(z);
											sizeCell.style.textAlign= 'center';
											if(selectCtn==1)
												sizeCell.innerHTML	= 	(packQty);
											else
												sizeCell.innerHTML	= 	(qtyArr[j]);
									}
										
									else
									{
										var sizeCell			=	row.insertCell(z);
											sizeCell.style.textAlign= 'center';
											sizeCell.innerHTML	= 	0;
									}
									z++;
							}
						
							
							var packQtyCell				=	row.insertCell(z);
								packQtyCell.style.textAlign= 'center';
								if(selectCtn==1)
									packQtyCell.innerHTML	= 	packQty;
								else
									packQtyCell.innerHTML	= 	qtyArr[j]*noOfCtns;
								
							var ctnComboCell			=	row.insertCell(z+1);
								ctnComboCell.style.textAlign= 'center';
								ctnComboCell.innerHTML	= 	ctn_combo;
								
							var packComboCell			=	row.insertCell(z+2);
								packComboCell.style.textAlign= 'center';
								packComboCell.innerHTML	= 	prepack_combo;
								
							var packNoCell			=	row.insertCell(z+3);
								packNoCell.style.textAlign= 'center';
								packNoCell.innerHTML	= 	packNo;
								
								
						if(selectCtn==1)
						{	
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].value=ctnType1;
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].disabled=true;
							
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].value=ctnPack1;
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].disabled=true;
						}
						else
						{
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].value=ctnArr[j];
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].disabled=true;
							
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].value=ctnPackArr[j];
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].disabled=true;
						}
						
						ctnF=parseInt(ctnT)+1;
						
					}
					packQty=remainder;
					}
					
				}
				if(packQty!=0 && packTypePack!='2Ratio' && packQty!='')
				{
					//ctnF=parseInt(ctnT)+1;
					var lastRow=document.getElementById('tblPackingData').rows.length;
					ctnT=parseInt(ctnF);
						
								var row 			= tblPackingData.insertRow(lastRow);
									row.className	= 'bcgcolor-tblrowWhite';
								
								var ctnFCell			=	row.insertCell(0);
									ctnFCell.style.textAlign= 'center';
									ctnFCell.innerHTML	= 	ctnF;
									
								var ctnTCell			=	row.insertCell(1);
									ctnTCell.style.textAlign= 'center';
									ctnTCell.innerHTML	= 	ctnT;
									
								var noCTNCell			=	row.insertCell(2);
									noCTNCell.style.textAlign= 'center';
									noCTNCell.innerHTML	= 	1;
								
									
								var colorCell			=	row.insertCell(3);
									colorCell.style.textAlign= 'center';
									colorCell.innerHTML	= 	tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue;	
								var z=4;
								var tot=0;	
								for(var i=0;i<sizeArray.length-1;i++)
								{
									//alert(size);
									//alert(sizeArray[i]);
									for(var cnt=0;cnt<prePackSizeArr.length;cnt++)
									{
										if(prePackSizeArr[cnt]==size && prePackTypeArr[cnt]==ctnPackArr[ctnPackArr.length-1] && prePackColorArr[cnt]==tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue)
											packNo = prePackNoArr[cnt]
									}
									if(size==sizeArray[i])
									{
										var sizeCell			=	row.insertCell(z);
											sizeCell.style.textAlign= 'center';
											sizeCell.innerHTML	= 	(packQty);
									}
										
									else
									{
										var sizeCell			=	row.insertCell(z);
											sizeCell.style.textAlign= 'center';
											sizeCell.innerHTML	= 	0;
									}
									z++;
							}
						
							
							var packQtyCell				=	row.insertCell(z);
								packQtyCell.style.textAlign= 'center';
								packQtyCell.innerHTML	= 	packQty;
								
							var ctnComboCell			=	row.insertCell(z+1);
								ctnComboCell.style.textAlign= 'center';
								ctnComboCell.innerHTML	= 	ctn_combo;
								
							var packComboCell			=	row.insertCell(z+2);
								packComboCell.style.textAlign= 'center';
								packComboCell.innerHTML	= 	prepack_combo;
								
							var packNoCell			=	row.insertCell(z+3);
								packNoCell.style.textAlign= 'center';
								packNoCell.innerHTML	= 	packNo;
							//alert(ctnArr[ctnArr.length-1]);	
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].value=ctnArr[ctnArr.length-1];
							tblPackingData.rows[lastRow].cells[z+1].childNodes[0].disabled=true;
							
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].value=ctnPackArr[ctnPackArr.length-1];
							tblPackingData.rows[lastRow].cells[z+2].childNodes[0].disabled=true;
					
						
						ctnF=parseInt(ctnT)+1;
				}
			}
			}
			else
			 calculateRatio(x,color);
		}
	
 }

function loadOrderNo(orderNo)
{
	if(orderNo!=0 && orderNo!='')
		document.getElementById('cboOrder').value=orderNo;
}

function addPercentage()
{
	var percentageValue=document.getElementById('txtPrecentage').value;
	var tblPackingListDet = document.getElementById('tblPackingListDet');
	
	if(tblPackingListDet.rows.length>2 && percentageValue!='')
	{
		for(var x=2;x<tblPackingListDet.rows.length;x++)
		{
			for(var j=0;j<sizeArray.length-1;j++)
			{
				tblPackingListDet.rows[x].cells[j+1].childNodes[0].value=parseInt(tblPackingListDet.rows[x].cells[j+1].childNodes[0].value)+parseInt(parseFloat(tblPackingListDet.rows[x].cells[j+1].childNodes[0].value)*parseFloat(percentageValue)/100);
			}
		}
		document.getElementById('txtPrecentage').value='';
	}
	
	//alert(parseFloat(percentageValue));	
}


function inputRowForRatio(x)
 {
	 var tblCartonDet = document.getElementById('tblCartonDet');
     var tblPackingListDet = document.getElementById('tblPackingListDet');
	 var tblPackingData	= document.getElementById('tblPackingData'); 
	 var remainder=[];
	 var packQty=[];
	 var packTypePack=[];
	 var rest=[];
	 var totQty=0;
	 
		var i=0	
		var exist=0;
		
	  for(var y=1; y<tblPackingListDet.rows[x].cells.length-1;y++)
	  {
		  var color=tblPackingListDet.rows[x].cells[0].childNodes[0].nodeValue;
		  if(tblPackingListDet.rows[x].cells[tblPackingListDet.rows[x].cells.length-1].childNodes[0].value=='2Ratio')
		  {
			  exist=1;
			  //alert("Exist:"+exist);
			  if(tblPackingListDet.rows[x].cells[y].childNodes[0].value=='')
			  	packQty[i]=0;
			  else
		  		packQty[i]=parseFloat(tblPackingListDet.rows[x].cells[y].childNodes[0].value);
			//alert(packQty[i]);
			
			totQty+=packQty[i];
			i++;
		  }
	  }
	  
	  if(exist==1)
	  {
		  for(var k=0; k<arrRatioRows.length;k++)
		  {
			  //alert(arrRatioRows[k]);
			  var doBulk=0;
			  var ans=[]; 
			  var totArrQty=[];
			  var arrQtyForRow=[];
			  var ansCount=0;
			  var less=0;
			  var estimateQty=[];
			  for(var c=3; c<tblCartonDet.rows[arrRatioRows[k]].cells.length; c++)
			  {
				  if(totQty>0)
				  {
					  if(packQty[ansCount]==0 || packQty[ansCount]=='')
					  	ans[ansCount]=0;
					  else	
				  		ans[ansCount]=parseInt((packQty[ansCount])/parseFloat(tblCartonDet.rows[arrRatioRows[k]].cells[c].childNodes[0].value));
				  //alert(ans[ansCount]);
				  if(tblCartonDet.rows[arrRatioRows[k]].cells[c].childNodes[0].value=='')
				  	arrQtyForRow[ansCount]=0;
				  else
				  	arrQtyForRow[ansCount]=parseFloat(tblCartonDet.rows[arrRatioRows[k]].cells[c].childNodes[0].value);
				  //totArrQty[ansCount]=ans[ansCount];
				  ansCount++;
				  }
			  }
		  	  //Sorting ans array...
				  var a, b, holder, holder1;
				   for(a = 0; a < ans.length; a++)
				  {
					for(b = 0; b < (ans.length-1); b++) 
					{
					  if(ans[b] > ans[b+1]) 
					  {
						holder = ans[b+1];
						//holder1= arrQtyForRow[b+1]; 
						
						ans[b+1] = ans[b];
						//arrQtyForRow[b+1] = arrQtyForRow[b];
						
						ans[b] = holder;
						//arrQtyForRow[b] = holder1;
					  }
					}
				  }
				  
				 loopCTNno:for(var nc=0; nc<ans.length; nc++)
				  {
					if(ans[nc]!=0)
					{
						var noOfCtn=ans[nc];
						break loopCTNno;
					}
				  }
				 // alert(noOfCtn);
					createANewRow(noOfCtn,arrQtyForRow,color,arrRatioRows[k]);
				 totQty=0;
				 var restCount=0;
				  for(var z=3; z<tblCartonDet.rows[arrRatioRows[k]].cells.length; z++)
				  {
					 // alert(packQty[restCount]);
					 if(tblCartonDet.rows[arrRatioRows[k]].cells[z].childNodes[0].value=='')
					 	var ctValue=0;
					else
					 	var ctValue=tblCartonDet.rows[arrRatioRows[k]].cells[z].childNodes[0].value;
					  rest[restCount]=parseInt((packQty[restCount])-(noOfCtn)*parseFloat(ctValue));
					  totQty+=rest[restCount];
					  packQty[restCount]=rest[restCount];
					  //alert(rest[restCount]);
					  restCount++;
				  }
				 // alert(rest);
				  if(k==arrRatioRows.length-1 && totQty>0)
				  {
					//createBulkRow(rest,color);
					noOfCtn=1;
					createANewRow1(noOfCtn,arrQtyForRow,color,arrRatioRows[k],packQty);
				  }
		  }
		  
	  }
	
}

function enableColor(obj)
{
	var tblCartonDet= document.getElementById('tblCartonDet');
	var rwIndex=obj.parentNode.parentNode.rowIndex;
	
	if(obj.value='2Ratio')
		tblCartonDet.rows[rwIndex].cells[2].childNodes[0].disabled=false;
	else
		tblCartonDet.rows[rwIndex].cells[2].childNodes[0].disabled=true;
	//alert(rwIndex);
		
}

function createPercentagePopUp()
{
	drawPopupAreaLayer(612,260,'precentagePopUp',1000);
	var colspanNo=sizeArray.length-1;
	var orderId=document.getElementById('cboOrder').value;
	var innerString="";
	
	var innerString="<table width=\"407\" height=\"226\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
  "<tr class=\"cursercross\"  onmousedown=\"grab(document.getElementById('precentagePopUp'),event);\">"+
            "<td width=\"419\" height=\"41\" bgcolor=\"#316895\" class=\"TitleN2white\">Add Precentage<img align=\"right\" onclick=\"closeWindow();\" id=\"butClose\" src=\"../images/cross.png\"/></td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"88%\">"+
          "<table width=\"100%\" border=\"0\">"+
            "<tr>"+
              "<td> <div id='divcons'  style='overflow:scroll; height:200px; width:600px;'><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\" id='tblAddPercentage'>";
	
	
	var width=300/parseInt(sizeArray.length);
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";                  
    innerString+="<td width='138' height='25' style='text-align:center' rowspan='2'>Color</td>";
    innerString+="<td width='300' style='text-align:center' colspan=\""+colspanNo+"\">Size</td>";
   innerString+="<td width='108' style='text-align:center' rowspan='2'>Confirmation</td>";
    innerString+="</tr>";
	innerString+="<tr bgcolor='#498CC2' class='normaltxtmidb2'>";
	for(var x=0;x<sizeArray.length-1;x++)                  
    	innerString+="<td style='text-align:center'>"+sizeArray[x]+"</td>";
    innerString+="</tr>";
	
	
	for(var i=0;i<colorArray.length-1;i++)
		{
			
			  innerString+="<tr class='bcgcolor-tblrowWhite'>";
			  innerString+="<td width='138' height='25' style='text-align:center' class='normalfntMid' nowrap='nowrap'>"+colorArray[i]+"</td>";
			  for(var j=0;j<sizeArray.length-1;j++)
			  {
				  	innerString+="<td style='text-align:center' class='normalfntMid'><input class='txtbox' size='10' style='text-align:center' /></td>";
			  }
			innerString+="<td style='text-align:center' class='normalfntMid'><img src='../images/conform.png' onclick='addPercentageToBulk(this);' /></td>";  
		}
		
		innerString+="</table></div></td></tr></table>";
		innerString+="</td></tr></table>"
		
		document.getElementById('precentagePopUp').innerHTML=innerString;
}

function closeWindow()
{
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function addPercentageToBulk(obj)
{
	var tblAddPercentage=document.getElementById('tblAddPercentage');
	var tblPackingListDet=document.getElementById('tblPackingListDet');
	var lastCell=tblPackingListDet.rows[2].cells.length-1;
	//alert(cellLength);
	
	var rowNo=obj.parentNode.parentNode.rowIndex;
	var colorName=tblAddPercentage.rows[rowNo].cells[0].childNodes[0].nodeValue;
	
	for(var i=1; i<tblAddPercentage.rows[rowNo].cells.length-1; i++)
	{
		var sum=0;
		var percentageValue=tblAddPercentage.rows[rowNo].cells[i].childNodes[0].value;
		if(percentageValue=='')
			percentageValue=0;
		
		for(var j=2; j<tblPackingListDet.rows.length; j++)
		{
			if(tblPackingListDet.rows[j].cells[0].childNodes[0].nodeValue==colorName)
			{
				if(tblPackingListDet.rows[j].cells[i].childNodes[0].value=='')
					sum=sum;
				else
					sum+=parseFloat(tblPackingListDet.rows[j].cells[i].childNodes[0].value);
			}
		}
		//alert(sum);
		
		var addition=parseInt(sum*parseFloat(percentageValue)/100);
		
		for(var count=2; count<tblPackingListDet.rows.length; count++)
		{
			//alert(tblPackingListDet.rows[count].cells[0].childNodes[0].nodeValue);
			if(tblPackingListDet.rows[count].cells[lastCell].childNodes[0].value=='3Bulk' && tblPackingListDet.rows[count].cells[0].childNodes[0].nodeValue==colorName)
			{
				if(tblPackingListDet.rows[count].cells[i].childNodes[0].value=='')
					var bulkVal=0;
				else
					var bulkVal=tblPackingListDet.rows[count].cells[i].childNodes[0].value;
				tblPackingListDet.rows[count].cells[i].childNodes[0].value = parseFloat(bulkVal) + addition;
			}
		}
	}
	alert("Percentages Added for Colour "+colorName );
}

function deleteRow(obj)
{
	
	var answer = confirm("Do you want to delete this color?")
	if (answer)
	{
		var tblPackingListDet = document.getElementById('tblPackingListDet');
		tblPackingListDet.deleteRow(obj.rowIndex);
	}
}
