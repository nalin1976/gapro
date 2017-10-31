var item=0;
var verpos=0

function getInvoiceDetail()
{
	//alert("Bhagya");
	if($('#cboFinalInvoice').val()==""){
		alert("Please save the header first.")
		var $tabs = $('#tabs').tabs(); $tabs.tabs('select',0);		
		return;
		
	}
	if(document.getElementById("cboInvoiceNo").value!="")
	{
		document.getElementById("txtInvoiceDetail").value=document.getElementById("cboInvoiceNo").value;
		if(document.getElementById("txtInvoiceDetail").value!="")
		{
			if ((document.getElementById("cboInvoiceNo").value=="")&&(document.getElementById("cboFinalInvoice").value==""))
							saveData();	
			var invoiceno=URLEncode(document.getElementById("txtInvoiceDetail").value); 
			createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=addToDetailGrid;
			xmlHttp[4].open("GET",'invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + invoiceno,true);
			xmlHttp[4].send(null);
		}
		else
		{
		alert("Please select an invoice number.");
		pageReload();
			
		}
		
		
	}
	else
	{
		load_final_inv_dtl();
	}
}
function print_co()
{
	var exchangeRate = parseFloat(document.getElementById('txtExchangeRateForCo').value);
	var invType 	 	 = document.getElementById('cboDocType').value;
	var refNo 		 = document.getElementById('txtRefeNo').value;
	var unitPrice 	 = parseFloat(document.getElementById('txtUnitPriceForCo').value);
	var netWt 	 	 = parseFloat(document.getElementById('txtNetWtCo').value);
	var gspDate 	 = document.getElementById('txtGSPDate').value;
	var invNo   	 = document.getElementById('cboFinalInvoice').value;
	var exRate		 = document.getElementById('txtExchangeRateForCo').value;
	//alert(refNo);
	//var co		= document.getElementById('optco').value;
	//var gspco	= document.getElementById('optgspco').value;
	//var isftaco	= document.getElementById('optisftaco').value;
	if(invNo!='')
	{
		if(invType=='optco')
			{
				window.open("movingCo.php?InvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate+"&refNo="+refNo,"GSP CO");
	
			}
		else if(invType=='optgspco')
			{
				window.open("movingGSPCO.php?InvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate+"&refNo="+refNo,"GSP CO");
				window.open("movingCo_Back.php?InvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate+"&netWt="+netWt+"&exRate="+exRate+"&unitPrice="+unitPrice,"GSP CO BACK");
		
			}
		else if(invType=='optaptaco')
			{
				//alert("Works");
				window.open("aptaCO.php?InvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate+"&refNo="+refNo,"APTA CO");
			}
		else if(invType=='optisftaco')
			{
				window.open("isftaCO.php?InvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate+"&refNo="+refNo,"ISFTA CO");
			}
		
	}
	else
		alert("Please Select Invoice Number");
	//window.open("movingGSPCO.php?I nvoiceNo="+URLEncode(invNo)+"&gspDate="+gspDate,"GSP CO");
	//window.open("movingCo_Back.php?InvoiceNo="+invNo+"&exRate="+exchangeRate+"&unitPrice="+unitPrice+"&netWt="+netWt,"CO_BACK");
	

}

function feildHide()
{
	var invType 	 	 = document.getElementById('cboDocType').value;
	if(invType=='optgspco')
		{
		document.getElementById('txtNetWtCo').disabled=false;
		document.getElementById('txtUnitPriceForCo').disabled=false;
		document.getElementById('txtExchangeRateForCo').disabled=false;
		document.getElementById('txtGSPDate').disabled=false;
		}
		else
		{
		document.getElementById('txtNetWtCo').disabled=true;
		document.getElementById('txtUnitPriceForCo').disabled=true;
		document.getElementById('txtExchangeRateForCo').disabled=true;
		document.getElementById('txtGSPDate').disabled=true;
		}
		
}

function print_MasterInv()
{
	//var exchangeRate = parseFloat(document.getElementById('txtExchangeRateForCo').value);
	var invNo 		 = document.getElementById('cboMasterInv').value;
	var buyer 	 = document.getElementById('cdoMasterInvBuyer').value;
	
	if(buyer=="LN")
		window.open("landsEndMasterInv.php?masInvNo="+invNo,"Master_Inv_LN");
	
	
}
function loadPreDetData()
{
	var preInvNo = document.getElementById('cboPreDetInvoiceNo').value;
	
		createNewXMLHttpRequest(4);
			xmlHttp[4].onreadystatechange=addToDetailGrid1;
			xmlHttp[4].open("GET",'invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + preInvNo,true);
			xmlHttp[4].send(null);
	
}

function addToDetailGrid1()
{

if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
	cleardata();
	//deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	var invdtlno=xmlHttp[4].responseXML.getElementsByTagName('InvoiceNo');
	var color=xmlHttp[4].responseXML.getElementsByTagName('Color');
	var StyleID=xmlHttp[4].responseXML.getElementsByTagName('StyleID');
	var ItemNo=xmlHttp[4].responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=xmlHttp[4].responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=xmlHttp[4].responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=xmlHttp[4].responseXML.getElementsByTagName('Quantity');
	var UnitID=xmlHttp[4].responseXML.getElementsByTagName('UnitID');
	var UnitPrice=xmlHttp[4].responseXML.getElementsByTagName('UnitPrice');
	var Amount=xmlHttp[4].responseXML.getElementsByTagName('Amount');	
	var HSCode=xmlHttp[4].responseXML.getElementsByTagName('HSCode');
	var GrossMass=xmlHttp[4].responseXML.getElementsByTagName('GrossMass');
	var NetMass=xmlHttp[4].responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=xmlHttp[4].responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=xmlHttp[4].responseXML.getElementsByTagName('NoOfCTns');
	var Category=xmlHttp[4].responseXML.getElementsByTagName('Category');
	var ProcedureCode=xmlHttp[4].responseXML.getElementsByTagName('ProcedureCode');
	var ISD=xmlHttp[4].responseXML.getElementsByTagName('ISD');
	var Fabric=xmlHttp[4].responseXML.getElementsByTagName('Fabric');
	var PLno=xmlHttp[4].responseXML.getElementsByTagName('PLno');
	var Dc=xmlHttp[4].responseXML.getElementsByTagName('Dc');
	var netnet=xmlHttp[4].responseXML.getElementsByTagName('netnet');
		var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\"  />";
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =empty_handle_str(StyleID[loop].childNodes[0].nodeValue)
							
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(BuyerPONo[loop].childNodes[0].nodeValue);
								
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(ISD[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(PLno[loop].childNodes[0].nodeValue);
		
		//alert(color[loop].childNodes[0].nodeValue);
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(color[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(DescOfGoods[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabric[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="n/a";
				
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(HSCode[loop].childNodes[0].nodeValue);
	 
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(UnitPrice[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(PriceUnitID[loop].childNodes[0].nodeValue);		
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Quantity[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =empty_handle_str(UnitID[loop].childNodes[0].nodeValue);				
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Amount[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(GrossMass[loop].childNodes[0].nodeValue);	
				
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(NetMass[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(18);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(netnet[loop].childNodes[0].nodeValue);
								
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = empty_handle_dbl(NoOfCTns[loop].childNodes[0].nodeValue);
			
		}
	
	}
	
	

}



function addToDetailGrid()
{

if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
	cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	var invdtlno=xmlHttp[4].responseXML.getElementsByTagName('InvoiceNo');
	var color=xmlHttp[4].responseXML.getElementsByTagName('Color');
	var StyleID=xmlHttp[4].responseXML.getElementsByTagName('StyleID');
	var ItemNo=xmlHttp[4].responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=xmlHttp[4].responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=xmlHttp[4].responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=xmlHttp[4].responseXML.getElementsByTagName('Quantity');
	var UnitID=xmlHttp[4].responseXML.getElementsByTagName('UnitID');
	var UnitPrice=xmlHttp[4].responseXML.getElementsByTagName('UnitPrice');
	var Amount=xmlHttp[4].responseXML.getElementsByTagName('Amount');	
	var HSCode=xmlHttp[4].responseXML.getElementsByTagName('HSCode');
	var GrossMass=xmlHttp[4].responseXML.getElementsByTagName('GrossMass');
	var NetMass=xmlHttp[4].responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=xmlHttp[4].responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=xmlHttp[4].responseXML.getElementsByTagName('NoOfCTns');
	var Category=xmlHttp[4].responseXML.getElementsByTagName('Category');
	var ProcedureCode=xmlHttp[4].responseXML.getElementsByTagName('ProcedureCode');
	var ISD=xmlHttp[4].responseXML.getElementsByTagName('ISD');
	var Fabric=xmlHttp[4].responseXML.getElementsByTagName('Fabric');
	var PLno=xmlHttp[4].responseXML.getElementsByTagName('PLno');
	var Dc=xmlHttp[4].responseXML.getElementsByTagName('Dc');
	var netnet=xmlHttp[4].responseXML.getElementsByTagName('netnet');
		var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\"  />";
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =empty_handle_str(StyleID[loop].childNodes[0].nodeValue)
							
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(BuyerPONo[loop].childNodes[0].nodeValue);
								
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(ISD[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(PLno[loop].childNodes[0].nodeValue);
		
		//alert(color[loop].childNodes[0].nodeValue);
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(color[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(DescOfGoods[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabric[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="n/a";
				
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(HSCode[loop].childNodes[0].nodeValue);
	 
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(UnitPrice[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(PriceUnitID[loop].childNodes[0].nodeValue);		
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Quantity[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =empty_handle_str(UnitID[loop].childNodes[0].nodeValue);				
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Amount[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(GrossMass[loop].childNodes[0].nodeValue);	
				
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(NetMass[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(18);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(netnet[loop].childNodes[0].nodeValue);
								
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = empty_handle_dbl(NoOfCTns[loop].childNodes[0].nodeValue);
			
		}
	
	}
	
	

}



function rowclickColorChangeIou()
{	
	var rowIndex = this.rowIndex;
	
	
	var tbl = document.getElementById('tblDescriptionOfGood');
	
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow mouseover";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite mouseover";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted mouseover";
	}
	
}

function rowclickColorChangeIou2()
{	
	var rowIndex = this.rowIndex;
	
	
	var tbl = document.getElementById('tblDescription_po');
	
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow mouseover";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite mouseover";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted mouseover";
	}
	
}




function editItems()
{
	newDettail();
	try{
		document.getElementById('txtStyle').value		=empty_handle_str(this.cells[2].childNodes[0].nodeValue);
		document.getElementById('txtBuyerPO').value		=empty_handle_str(this.cells[3].childNodes[0].nodeValue);
		document.getElementById('txtISDNo').value		=empty_handle_str(this.cells[4].childNodes[0].nodeValue);
		document.getElementById('txtareaDisc').value	=empty_handle_str(this.cells[7].childNodes[0].nodeValue);
		document.getElementById('txtHS').value			=empty_handle_str(this.cells[10].childNodes[0].nodeValue);
		document.getElementById('txtUnitPrice').value	=this.cells[11].childNodes[0].nodeValue;
		document.getElementById('txtUnit').value		=this.cells[12].childNodes[0].nodeValue;
		document.getElementById('txtQty').value			=this.cells[13].childNodes[0].nodeValue;
		document.getElementById('txtQtyUnit').value		=this.cells[14].childNodes[0].nodeValue;
		document.getElementById('txtValue').value		=this.cells[15].childNodes[0].nodeValue;
		document.getElementById('txtGross').value		=this.cells[16].childNodes[0].nodeValue;
		document.getElementById('txtNet').value			=this.cells[17].childNodes[0].nodeValue;
		document.getElementById('txtCtns').value		=this.cells[19].childNodes[0].nodeValue;
		
		document.getElementById('txtColor').value				=this.cells[6].childNodes[0].nodeValue;
		
		document.getElementById('txtFabricDesc').value	=this.cells[8].childNodes[0].nodeValue;
		document.getElementById('txtPLno').value		=this.cells[5].childNodes[0].nodeValue;
		document.getElementById('txtNetNet').value		=this.cells[18].childNodes[0].nodeValue;
		document.getElementById('txtEntryNo').value		=this.cells[9].childNodes[0].nodeValue;
				
		document.getElementById('tblDescriptionOfGood').deleteRow(this.rowIndex);
		$('#txtSD').val(this.cells[2].id)
		$('#txtDC').val(this.cells[3].id)
		$('#txtConstType').val(this.cells[8].id)
		$('#txtareaSpecDisc').val(this.cells[7].id)
		$('#txtMRP').val(this.cells[11].id)
		$('#txtCBM').val(this.cells[19].id)
	}
	catch(err){}
	rowclickColorChangeIou()
}


function addToGrid()
{
	var tbl = document.getElementById('tblDescriptionOfGood');
				var invoiceno=document.getElementById("txtInvoiceDetail").value;
				var color=empty_handle_str(document.getElementById("txtColor").value.trim());
				var desc=empty_handle_str(document.getElementById('txtareaDisc').value.trim());
				var style		=empty_handle_str(document.getElementById('txtStyle').value.trim());
				var unitz		=empty_handle_str(document.getElementById('txtUnit').value.trim());
				var unitprice	=empty_handle_dbl(document.getElementById('txtUnitPrice').value.trim());
				var gross		=empty_handle_dbl(document.getElementById('txtGross').value.trim());
				var ctns		=empty_handle_dbl(document.getElementById('txtCtns').value.trim());
				var net			=empty_handle_dbl(document.getElementById('txtNet').value.trim());
				var bpo			=empty_handle_str(document.getElementById('txtBuyerPO').value.trim());
				var unitqty 	=empty_handle_str(document.getElementById('txtQtyUnit').value.trim());
				var qty			=empty_handle_dbl(document.getElementById('txtQty').value.trim());			
				var hs			=empty_handle_str(document.getElementById('txtHS').value.trim());
				var val			=empty_handle_dbl(document.getElementById('txtValue').value.trim());
				var ISDNo		=empty_handle_str(document.getElementById('txtISDNo').value.trim());
				var FabricDesc	=empty_handle_str(document.getElementById('txtFabricDesc').value.trim());
				var PLno		=empty_handle_str(document.getElementById('txtPLno').value.trim());
				var NetNet		=empty_handle_dbl(document.getElementById('txtNetNet').value.trim());
					
				var sd			=$('#txtSD').val();
				var dc			=$('#txtDC').val();
				var ConstType	=$('#txtConstType').val();
				var areaSpecDisc=$('#txtareaSpecDisc').val();
				var retailPrice =$('#txtMRP').val();
				var CBM			=$('#txtCBM').val();
				var entryNo		=empty_handle_str($('#txtEntryNo').val());
		
		var lastRow			=tbl.rows.length;
		var row 			= tbl.insertRow(lastRow);
		row.onclick	= rowclickColorChangeIou;	
		
			//row.className="mouseover";	
		row.ondblclick=editItems;
			
		if(lastRow % 2 ==1)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
		
		var rowCell = row.insertCell(0); 
				rowCell.className ="normalfntMid";	
				rowCell.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";			
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\"checked=\"checked\" class=\"txtbox\"  />";
				rowCell.id=bpo;					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =style;
				rowCell.id		  =sd;
							
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =bpo;
				rowCell.id		  =dc;
								
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =ISDNo;
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =PLno;
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =color;
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =desc;
				rowCell.id		  =areaSpecDisc;
		
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =FabricDesc;
				rowCell.id		  =ConstType;
		
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =entryNo;
				
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =hs;
	 
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unitprice;
				rowCell.id		  =retailPrice;
		
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unitz;		
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =qty;
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =unitqty;				
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =val;
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =gross;	
				
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =net;
								
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = NetNet;
				
		var 	cellDelete			 = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ctns;
				cellDelete.id		 = CBM;
				
		cleardata();
		del_final_inv();
}
	
//alert(prevpos+ " "+position);




function	deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	



function RemoveItem(cell)
{
	if(confirm("Are you sure you want to delete?"))
	{
		var rowno=cell.parentNode.parentNode.rowIndex;
		var tbl = document.getElementById('tblDescriptionOfGood');
		tbl.deleteRow(rowno);
	}
}


function cleardata()
{
	try{
	document.getElementById('txtStyle').value="";
	//document.getElementById('txtValue').value="";
	document.getElementById('txtareaDisc').value="";
	document.getElementById('txtUnit').value="";
	document.getElementById('txtUnitPrice').value="";
	document.getElementById('txtGross').value="";
	document.getElementById('txtCtns').value="";
	document.getElementById('txtNet').value="";
	document.getElementById('txtBuyerPO').value="";
	document.getElementById('txtHS').value="";
	document.getElementById('txtQty').value="";
	document.getElementById('txtQtyUnit').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtISDNo').value="";
	
	document.getElementById('txtPLno').value="";
	document.getElementById('txtDC').value="";
	document.getElementById('txtFabricDesc').value="";
	document.getElementById('txtNetNet').value="";
	document.getElementById('txtSD').value="";
	document.getElementById('txtConstType').value="";
	document.getElementById('txtareaSpecDisc').value="";
	document.getElementById('txtMRP').value="";
	document.getElementById('txtCBM').value="";
	document.getElementById('txtEntryNo').value="";

	//document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').disabled=true;
	document.getElementById('txtareaDisc').disabled=true;
	document.getElementById('txtUnit').disabled=true;
	document.getElementById('txtUnitPrice').disabled=true;
	document.getElementById('txtGross').disabled=true;
	document.getElementById('txtCtns').disabled=true;
	document.getElementById('txtNet').disabled=true;
	document.getElementById('txtBuyerPO').disabled=true;
	document.getElementById('txtHS').disabled=true;
	document.getElementById('txtQty').disabled=true;
	document.getElementById('txtQtyUnit').disabled=true;
	document.getElementById('txtValue').disabled=true;
	document.getElementById('txtISDNo').disabled=true;
	document.getElementById('txtNetNet').disabled=true;
	
	document.getElementById('txtPLno').disabled=true;
	document.getElementById('txtDC').disabled=true;
	document.getElementById('txtFabricDesc').disabled=true;
	document.getElementById('txtNetNet').disabled=true;
	document.getElementById('txtSD').disabled=true;
	document.getElementById('txtConstType').disabled=true;
	document.getElementById('txtareaSpecDisc').disabled=true;
	document.getElementById('txtMRP').disabled=true;
	document.getElementById('txtCBM').disabled=true;
	document.getElementById('txtEntryNo').disabled=true;
	}
	catch(err){}
}

function calValue(p,pu,qty,qtyu)
{
	if(p!="" && qty!="")
	{
		var actp=0;
		var aqty=0; 
		if ((pu=="DZN")&&(qtyu!="DZN"))
		{
			actp=parseFloat(p/12);
		}
		else if((pu!="DZN")&&(qtyu=="DZN"))
		{
			actp=parseFloat(p*12);
		}
		else 		
		actp=parseFloat(p);
		
			aqty=parseFloat(qty);
		var final=parseFloat(actp*aqty);
		var formatnum=final.toFixed([2]);
		return formatnum;
	}
	else 
	return 0;
}


function inputvalidation()
{

		if(document.getElementById('txtStyle').value=="")
			{
				alert("Please enter a style number.");
				document.getElementById('txtStyle').focus();	
				return false;
			}
		if(document.getElementById('txtQty').value=="")
			{
				alert("Please enter the quantity.");
				document.getElementById('txtQty').focus();	
				return false;
			}
		if(document.getElementById('txtQtyUnit').value=="")
			{
				alert("Please select the unit.");
				return false;
			}
		if(document.getElementById('txtUnitPrice').value=="")
			{
				alert("Please enter the unit price.");
				document.getElementById('txtUnitPrice').focus();	
				return false;
			}
			
		if(document.getElementById('txtUnit').value=="")
			{
				alert("Please select the price unit.");
				return false;
			}
		
			
		if(document.getElementById('txtHS').value=="")
			{
				alert("Please enter the HS code.");
				document.getElementById('txtHS').focus();
				return false;
			}
		if(document.getElementById('txtCtns').value=="")
			{
				alert("Please enter number of cartoons.");
				document.getElementById('txtCtns').focus();
				return false;
			}
		if(document.getElementById('txtareaDisc').value=="")
			{
				alert("Please enter the description.");
				document.getElementById('txtareaDisc').focus();	
				return false;
			}
		else 
		return true;

}

function printthis()
{	
		
		var fino			=$('#txtInvoiceNo').val();			
		var url				='pop_printer_invoice.php';
		var xml_http_obj	=$.ajax({url:url,async:false});
				//window.open("packinglist_formats/pl_levis_newyork.php?plno="+plno,'pl');
				drawPopupArea(360,125,'frmPrinter');
				document.getElementById('frmPrinter').innerHTML=xml_http_obj.responseText;
				$('#cboPINV').val(fino)
}

function popMasterInv()
{	
		
		var fino			=$('#txtInvoiceNo').val();			
		var url				='masterInv.php';
		var xml_http_obj	=$.ajax({url:url,async:false});
				//window.open("packinglist_formats/pl_levis_newyork.php?plno="+plno,'pl');
				drawPopupArea(360,125,'frmPrinter');
				document.getElementById('frmPrinter').innerHTML=xml_http_obj.responseText;
				$('#cboMasterInv').val(fino)
}

function hide_pop()
{
	document.getElementById("pop_print").style.visibility = "hidden";	
}

function print_buyer_wise()
{
	var obj		=$('#cboRptFormat').val();
	var invno	=$('#cboPINV').val();
	var proforma="";
	if(document.getElementById("cbkProforma").checked==true)
	{
		 proforma="PROFORMA";	
	}
	
	if(invno=="")
	{
		alert("Please select an Invoice")	;
		$('#cboPINV').focus()
		return;
	}
	
	//<option value='2'>Levi's Europe</option>
	if(obj==2)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_euro.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl_europe.php?InvoiceNo=" +invno,'plz');	
		}
		else
		{
		window.open("buyerwiseinvoices/levis_euro.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/levis_euro_latterhead.php?InvoiceNo=" + invno,'l_head');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/shipment_pl_europe.php?InvoiceNo=" +invno,'plz');
		}
	}
	// <option value='1'>Levi's New York Vessel</option>
	else if(obj==1)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_euro.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');	
		}
		else
		{
		window.open("buyerwiseinvoices/levis_euro.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD_new_york.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/cpsia.php?InvoiceNo=" + invno,'cpsia');
		window.open("buyerwiseinvoices/addendum_sheet.php?InvoiceNo=" +invno,'adden');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		}
		
		
	}
	//<option value='3'>GV Sea</option> 
	else if(obj==3)
	{
		window.open("gv/benficiary1.php?InvoiceNo=" + invno,'c_inv');
		window.open("gv/benficiary2.php?InvoiceNo=" + invno,'isd');
		window.open("gv/benficiary_certificate.php?InvoiceNo=" + invno,'cpsia');
		window.open("gv/cpsia.php?InvoiceNo=" + invno,'adden');
		window.open("gv/denim_statement.php?InvoiceNo=" + invno,'ds');
		window.open("gv/co.php?InvoiceNo=" + invno,'co');
	}
	//<option value='4'>Levi's Europe FOB</option>
	else if(obj==4)
	{
		window.open("buyerwiseinvoices/levis_euro_fob.php?InvoiceNo=" + invno,'c_inv');
	}
	// <option value='5'>Levi's Europe Air</option>
	else if(obj==5)
	{
		window.open("buyerwiseinvoices/levis_euro_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/levis_euro_latterhead.php?InvoiceNo=" + invno,'l_head');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');		
		window.open("buyerwiseinvoices/shipment_pl_europe_air.php?InvoiceNo=" +invno,'plz');
	}
	//<option value='6'>GV Air</option>      
	else if(obj==6)
	{
		window.open("gv/benficiary1.php?InvoiceNo=" + invno,'c_inv');
		window.open("gv/benficiary2.php?InvoiceNo=" + invno,'isd');
		window.open("gv/benficiary_certificate_air.php?InvoiceNo=" + invno,'cpsia');
		window.open("gv/cpsia_air.php?InvoiceNo=" + invno,'adden');
		window.open("gv/denim_statement_air.php?InvoiceNo=" + invno,'ds');
		window.open("gv/co.php?InvoiceNo=" + invno,'co');
	}
	//<option value='7'>Levi's Mexico Vessel</option> 
	else if(obj==7)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_mexico_vessel.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_mexico_vessel.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/formb.php?InvoiceNo=" + invno,'formb');
		}
		
		
	}
	// <option value='8'>Levi's Canada Air</option>
	else if(obj==8)
	{
		window.open("buyerwiseinvoices/cci.php?InvoiceNo=" +invno,'cci');
		window.open("buyerwiseinvoices/levis_canada_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_canada_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/canada_cl.php?InvoiceNo=" +invno,'cl');
		
	}
	// <option value='10'>Levi's Canada Vessel</option>
	else if(obj==10)
	{
		window.open("buyerwiseinvoices/cci.php?InvoiceNo=" +invno,'cci');
		window.open("buyerwiseinvoices/levis_canada_sea.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_canada_vessel.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/canada_cl.php?InvoiceNo=" +invno,'cl');
		
	}
	// <option value='9'>Levi's New York Air</option>
	else if(obj==9)
	{
		window.open("buyerwiseinvoices/levis_euro.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD_new_york.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/cpsia.php?InvoiceNo=" + invno,'cpsia');
		window.open("buyerwiseinvoices/addendum_sheet.php?InvoiceNo=" +invno,'adden');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
	}
	//<option value='11'>Levi's Mexico Air</option> 
	else if(obj==11)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_mexico_air.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
			
		}
		else
		{
		window.open("buyerwiseinvoices/levis_mexico_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/formb.php?InvoiceNo=" + invno,'formb');
		}
		
		
	}
	//<option value='12'>Levi's Brazil Vessel</option> 
	else if(obj==12)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_brazil_vessel.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');		
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_brazil_vessel.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/formb.php?InvoiceNo=" + invno,'formb');
		
		}
		
	}
	 //<option value='13'>Levi's Brazil Air</option>
	else if(obj==13)
	{
		if(proforma=="PROFORMA")
		{
		
		window.open("buyerwiseinvoices/levis_brazil_air.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_brazil_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/formb.php?InvoiceNo=" + invno,'formb');
		
		}
		
	}
	//<option value='14'>Levi's Latin America Vessel</option> 
	else if(obj==14)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_latin_america_vessel.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_latin_america_vessel.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/after_shipment_advice.php?InvoiceNo=" + invno,'asa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/coii.php?InvoiceNo=" + invno,'coii');
			
		}
		
	}
	
    // <option value='15'>Levi's Latin America Air</option> 
	else if(obj==15)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_latin_america_air.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_latin_america_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/after_shipment_advice.php?InvoiceNo=" + invno,'asa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/coii.php?InvoiceNo=" + invno,'coii');
			
		}
		
	}
	
	//<option value='16'>South Africa Vessel</option>
	else if(obj==16)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_sa_vessel.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_sa_vessel.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/after_shipment_advice.php?InvoiceNo=" + invno,'asa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/coii.php?InvoiceNo=" + invno,'coii');
			
		}
		
	}
	//<option value='17'>South Africa Air</option>
	else if(obj==17)
	{
		if(proforma=="PROFORMA")
		{
		window.open("buyerwiseinvoices/levis_sa_air.php?InvoiceNo=" + invno+'&proforma='+proforma,'c_inv');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		}
		else
		{
		window.open("buyerwiseinvoices/levis_sa_air.php?InvoiceNo=" + invno,'c_inv');
		window.open("buyerwiseinvoices/ISD.php?InvoiceNo=" + invno,'isd');
		window.open("buyerwiseinvoices/shipment_pl_air.php?InvoiceNo=" +invno,'plz');
		window.open("buyerwiseinvoices/post_shipment_advice.php?InvoiceNo=" + invno,'psa');
		window.open("buyerwiseinvoices/after_shipment_advice.php?InvoiceNo=" + invno,'asa');
		window.open("buyerwiseinvoices/co.php?InvoiceNo=" + invno,'co');
		window.open("buyerwiseinvoices/coii.php?InvoiceNo=" + invno,'coii');
			
		}
		
	}
}

function checkInvoiceNo()
{
if (document.getElementById("txtInvoiceNo").value!="")
{}
else 
{
alert("Please fill header data first."); 
setTimeout(location.reload('true'),100);


}
}

function clearall()
{
//deleterows('tblDescriptionOfGood');
cleardata();

}

function validateprocedure(checkpc)
{
	//var objRegExp = "^\d{4}.\d{3}$";
   	//return objRegExp.test(checkpc);
	var objRegExp  =/^\d{4}\.\d{3}$/;

  //check for valid us phone with or without space between
  //area code
  return objRegExp.test(checkpc);
}

function getItemVal()
{
	var unit=document.getElementById('txtUnit').value;
	var unitprice=document.getElementById('txtUnitPrice').value;
	var unitqty=document.getElementById('txtQtyUnit').value;
	var qty=document.getElementById('txtQty').value;	
	var value=calValue(unitprice,unit,qty,unitqty); 
	document.getElementById('txtValue').value=value;
}

function newDettail()
{
	document.getElementById('txtStyle').disabled=false;
	document.getElementById('txtareaDisc').disabled=false;
	document.getElementById('txtUnit').disabled=false;
	document.getElementById('txtUnitPrice').disabled=false;
	document.getElementById('txtGross').disabled=false;
	document.getElementById('txtCtns').disabled=false;
	document.getElementById('txtNet').disabled=false;
	document.getElementById('txtBuyerPO').disabled=false;
	document.getElementById('txtHS').disabled=false;
	document.getElementById('txtQty').disabled=false;
	document.getElementById('txtQtyUnit').disabled=false;
	document.getElementById('txtValue').disabled=false;
	document.getElementById('txtISDNo').disabled=false;
	document.getElementById('txtStyle').value="";
	document.getElementById('txtSD').disabled=false;
	
	document.getElementById('txtPLno').disabled=false;
	document.getElementById('txtDC').disabled=false;
	document.getElementById('txtFabricDesc').disabled=false;
	document.getElementById('txtNetNet').disabled=false;
	document.getElementById('txtareaSpecDisc').disabled=false;
	document.getElementById('txtConstType').disabled=false;
	document.getElementById('txtMRP').disabled=false;
	document.getElementById('txtCBM').disabled=false;
	document.getElementById('txtEntryNo').disabled=false;
	//document.getElementById('txtValue').value="";
	document.getElementById('txtareaDisc').value="";
	document.getElementById('txtUnit').value="";
	document.getElementById('txtUnitPrice').value="";
	document.getElementById('txtGross').value="";
	document.getElementById('txtCtns').value="";
	document.getElementById('txtNet').value="";
	document.getElementById('txtBuyerPO').value="";
	document.getElementById('txtHS').value="";
	document.getElementById('txtQty').value="";
	document.getElementById('txtQtyUnit').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtISDNo').value="";
	document.getElementById('txtPLno').value="";
	document.getElementById('txtDC').value="";
	document.getElementById('txtFabricDesc').value="";
	document.getElementById('txtNetNet').value="";
	document.getElementById('txtSD').value="";
	document.getElementById('txtareaSpecDisc').value="";
	document.getElementById('txtConstType').value="";
	document.getElementById('txtMRP').value="";
	document.getElementById('txtCBM').value="";
	document.getElementById('txtEntryNo').value="";
}

function setGenDesc()
{
	document.getElementById('txtareaDisc').value=document.getElementById("txtDiscription").value;
	
}


function cal_po_amount()
{
		var qty=document.getElementById('txtQty_po').value;
		var price=document.getElementById('txtPrice_po').value;
		if(qty.trim()!="" && price.trim()!=""){
		document.getElementById('txtAmount_po').value=parseFloat(qty)*parseFloat(price);
		}
	
}


//Save Final Invoice
function save_to_db_ci()
{

	
	var InvoiceNo			=document.getElementById("txtInvoiceNo").value;
	var brand				=document.getElementById("txtBrand").value;
	var Quality				=document.getElementById("cmbQuality").value;
	var FinishStd			=document.getElementById("txtFinishStd").value;
	var PackStd				=document.getElementById("txtrPackStd").value;
	var Gender				=document.getElementById("cmbGender").value;
	
	var GmntType			=document.getElementById("txtGmntType").value;
	var BTM					=document.getElementById("txtBTM").value;
	
	var Cat					=document.getElementById("txtCat").value;
	var CTNType				=document.getElementById("txtCTNType").value;
	var CTNNos				=document.getElementById("txtCTNNos").value;
	var CTNSize				=document.getElementById("txtCTNSize").value;
	var other				=empty_handle_dbl(document.getElementById("txtOther").value);
	var Freight				=empty_handle_dbl(document.getElementById("txtFreight").value);
	var Insurance			=empty_handle_dbl(document.getElementById("txtInsurance").value);
	var DestCh				=empty_handle_dbl(document.getElementById("txtDestCh").value);
	
	var totother			=empty_handle_dbl(document.getElementById("txtTotOther").value);
	var totFreight			=empty_handle_dbl(document.getElementById("txtTotFreight").value);
	var totInsurance		=empty_handle_dbl(document.getElementById("txtTotInsurance").value);
	var totDestCh			=empty_handle_dbl(document.getElementById("txtTotDest").value);
	
	var BL					=document.getElementById("txtBL").value;
	var Vat					=empty_handle_dbl(document.getElementById("txtVat").value);
	var Container	    	=document.getElementById("txtContainer").value;
	var ISDnoz		    	=document.getElementById("cmbISDnoz").value;
	var SealNo		    	=document.getElementById("txtSealNo").value;
	var HAWB		    	=document.getElementById("txtHAWB").value;
	var MAWB		    	=document.getElementById("txtMAWB").value;
	var FreightPC		    =document.getElementById("txtFreightPC").value;
	var PS					=document.getElementById("txtPSnumber").value;
	var ShipmentRef			=document.getElementById("txtShipmentRef").value;
	var discount			=empty_handle_dbl(document.getElementById("txtDiscount").value);
	var discountType		=document.getElementById("cboPrecentageValue").value;
	var conType				=document.getElementById("cboCtnrType").value;
	var webtoolid			=document.getElementById("txtWebToolId").value;
	var samplecode			=document.getElementById("txtSampleCode").value;
	
	var FCR					=document.getElementById("txtFCR").value;
	var ExFile				=document.getElementById("txtExFile").value;
	var DocDue				=document.getElementById("txtDocDue").value;
	var DocSub				=document.getElementById("txtDocSub").value;
	var PayDue				=document.getElementById("txtPayDue").value;
	var PaySub				=document.getElementById("txtPaySub").value;
	var ExportNo			=document.getElementById("txtExportNo").value;
	var SGSIONO				=document.getElementById("txtSGSIONO").value;	
	
	createNewXMLHttpRequest(71);
		xmlHttp[71].onreadystatechange=function()
		{
			
			
			if(xmlHttp[71].readyState==4 && xmlHttp[71].status==200)
			{	
				alert("Successfully saved.");
				
			}	
			
		}
		xmlHttp[71].open("GET",'invoiceDbDetail.php?REQUEST=save_po_wise_ci&InvoiceNo=' + URLEncode(InvoiceNo) + '&brand=' +URLEncode(brand)+ '&FinishStd=' +URLEncode(FinishStd)+ '&PackStd=' +URLEncode(PackStd)+ '&Gender=' +URLEncode(Gender)+ '&GmntType=' +URLEncode(GmntType)+ '&BTM=' +URLEncode(BTM) + '&Cat=' +URLEncode(Cat)+ '&CTNType=' +URLEncode(CTNType)+ '&CTNNos=' +URLEncode(CTNNos)+ '&CTNSize=' +URLEncode(CTNSize)+ '&other=' +URLEncode(other)+ '&Freight=' +URLEncode(Freight)+ '&Insurance=' +URLEncode(Insurance) + '&DestCh=' +URLEncode(DestCh)+ '&BL=' +URLEncode(BL)+ '&Vat=' +URLEncode(Vat)+ '&Container=' +URLEncode(Container) + '&Quality=' +URLEncode(Quality) + '&SealNo=' +URLEncode(SealNo)+ '&HAWB=' +URLEncode(HAWB) + '&MAWB=' +URLEncode(MAWB) + '&FreightPC=' +URLEncode(FreightPC)+ '&PS=' +URLEncode(PS)+ '&totother=' +URLEncode(totother)+ '&totFreight=' +URLEncode(totFreight)+ '&totInsurance=' +URLEncode(totInsurance) + '&totDestCh=' +URLEncode(totDestCh)+ '&ShipmentRef=' +URLEncode(ShipmentRef)+ '&discount=' +URLEncode(discount)+'&discountType=' +URLEncode(discountType)+ '&contype=' +URLEncode(conType)+ '&webtoolid=' +URLEncode(webtoolid)+ '&samplecode=' +URLEncode(samplecode)+ '&FCR=' +URLEncode(FCR)+ '&ExFile=' +URLEncode(ExFile)+ '&DocDue=' +URLEncode(DocDue)+ '&DocSub=' +URLEncode(DocSub)+ '&PayDue=' +URLEncode(PayDue)+ '&PaySub=' +URLEncode(PaySub)+ '&ExportNo=' +URLEncode(ExportNo)+ '&SGSIONO=' +URLEncode(SGSIONO),true);
		xmlHttp[71].send(null)
		
}


function retrv_po_wise_ci()
{	
	//alert("Bhagya");
	createNewXMLHttpRequest(70);
	var InvoiceNo=URLEncode(document.getElementById("cboFinalInvoice").value);
	
	xmlHttp[70].onreadystatechange=function()
		{
			
			
		if(xmlHttp[70].readyState==4 && xmlHttp[70].status==200)
			{	
			try
				{
				document.getElementById("txtBrand").value=xmlHttp[70].responseXML.getElementsByTagName('Brand')[0].childNodes[0].nodeValue;
				document.getElementById("cmbQuality").value=xmlHttp[70].responseXML.getElementsByTagName('Quality')[0].childNodes[0].nodeValue;
				document.getElementById("txtFinishStd").value=xmlHttp[70].responseXML.getElementsByTagName('FinishedStd')[0].childNodes[0].nodeValue;
				document.getElementById("txtrPackStd").value=xmlHttp[70].responseXML.getElementsByTagName('PackStd')[0].childNodes[0].nodeValue;
				document.getElementById("cmbGender").value=xmlHttp[70].responseXML.getElementsByTagName('Gender')[0].childNodes[0].nodeValue;
				document.getElementById("txtGmntType").value=xmlHttp[70].responseXML.getElementsByTagName('GarmentType')[0].childNodes[0].nodeValue;	
				document.getElementById("txtBTM").value=xmlHttp[70].responseXML.getElementsByTagName('BTM')[0].childNodes[0].nodeValue;	
				document.getElementById("txtCat").value=xmlHttp[70].responseXML.getElementsByTagName('Cat')[0].childNodes[0].nodeValue;
				document.getElementById("txtCTNType").value=xmlHttp[70].responseXML.getElementsByTagName('CTNSType')[0].childNodes[0].nodeValue;	
				document.getElementById("txtCTNNos").value=xmlHttp[70].responseXML.getElementsByTagName('CTNnos')[0].childNodes[0].nodeValue;	
				document.getElementById("txtCTNSize").value=xmlHttp[70].responseXML.getElementsByTagName('CTNSize')[0].childNodes[0].nodeValue;	
				document.getElementById("txtOther").value=xmlHttp[70].responseXML.getElementsByTagName('other')[0].childNodes[0].nodeValue;	
				
				document.getElementById("txtTotFreight").value=xmlHttp[70].responseXML.getElementsByTagName('TotFreight')[0].childNodes[0].nodeValue;	
				document.getElementById("txtTotInsurance").value=xmlHttp[70].responseXML.getElementsByTagName('TotInsuranse')[0].childNodes[0].nodeValue;
				document.getElementById("txtTotDest").value=xmlHttp[70].responseXML.getElementsByTagName('TotDest')[0].childNodes[0].nodeValue;
				document.getElementById("txtTotOther").value=xmlHttp[70].responseXML.getElementsByTagName('TotOther')[0].childNodes[0].nodeValue;	
				
					document.getElementById("txtFreight").value=xmlHttp[70].responseXML.getElementsByTagName('Freight')[0].childNodes[0].nodeValue;	
				document.getElementById("txtInsurance").value=xmlHttp[70].responseXML.getElementsByTagName('Insurance')[0].childNodes[0].nodeValue;
				document.getElementById("txtDestCh").value=xmlHttp[70].responseXML.getElementsByTagName('DestCharge')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtBL").value=xmlHttp[70].responseXML.getElementsByTagName('BL')[0].childNodes[0].nodeValue;	
				document.getElementById("txtVat").value=xmlHttp[70].responseXML.getElementsByTagName('VAT')[0].childNodes[0].nodeValue;	
				document.getElementById("txtContainer").value=xmlHttp[70].responseXML.getElementsByTagName('Container')[0].childNodes[0].nodeValue;
				document.getElementById("txtSealNo").value=xmlHttp[70].responseXML.getElementsByTagName('SealNo')[0].childNodes[0].nodeValue;	
				document.getElementById("txtHAWB").value=xmlHttp[70].responseXML.getElementsByTagName('HAWB')[0].childNodes[0].nodeValue;	
				document.getElementById("txtMAWB").value=xmlHttp[70].responseXML.getElementsByTagName('MAWB')[0].childNodes[0].nodeValue;	
				document.getElementById("txtFreightPC").value=xmlHttp[70].responseXML.getElementsByTagName('FreightPC')[0].childNodes[0].nodeValue;
				document.getElementById("txtPSnumber").value=xmlHttp[70].responseXML.getElementsByTagName('PSno')[0].childNodes[0].nodeValue;	
				document.getElementById("txtShipmentRef").value=xmlHttp[70].responseXML.getElementsByTagName('ShipmentRef')[0].childNodes[0].nodeValue;
				document.getElementById("txtDiscount").value=xmlHttp[70].responseXML.getElementsByTagName('Discount')[0].childNodes[0].nodeValue;
				document.getElementById("cboPrecentageValue").value=xmlHttp[70].responseXML.getElementsByTagName('DiscountType')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtWebToolId").value=xmlHttp[70].responseXML.getElementsByTagName('WebToolId')[0].childNodes[0].nodeValue;
				document.getElementById("txtSampleCode").value=xmlHttp[70].responseXML.getElementsByTagName('SampleCode')[0].childNodes[0].nodeValue;
				document.getElementById("cboCtnrType").value=xmlHttp[70].responseXML.getElementsByTagName('ConType')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtFCR").value=xmlHttp[70].responseXML.getElementsByTagName('FCR')[0].childNodes[0].nodeValue;	
				document.getElementById("txtExFile").value=xmlHttp[70].responseXML.getElementsByTagName('FileNo')[0].childNodes[0].nodeValue;
				var inv_date_array=document.getElementById('txtInvoiceDate').value.split("/")
				var inv_date	= new Date(inv_date_array[2]+"/"+inv_date_array[1]+"/"+inv_date_array[0]);
				var due_date	= new Date(inv_date.setDate(inv_date.getDate()+7));
				due_date=due_date.getDate()+"/"+parseFloat(due_date.getMonth()+1)+"/"+due_date.getFullYear()
				document.getElementById("txtDocDue").value=due_date;
				
				document.getElementById("txtDocSub").value=xmlHttp[70].responseXML.getElementsByTagName('DocumentSubDate')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtPayDue").value=due_date;
				
				document.getElementById("txtPaySub").value=xmlHttp[70].responseXML.getElementsByTagName('PaymentSubDate')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtExportNo").value=xmlHttp[70].responseXML.getElementsByTagName('ExportNo')[0].childNodes[0].nodeValue;
				document.getElementById("txtSGSIONO").value=xmlHttp[70].responseXML.getElementsByTagName('SGSIONO')[0].childNodes[0].nodeValue;;	
					
				}
				catch (err){
					document.getElementById("commercial_inv").reset();
					}
			}	
			
		}
		xmlHttp[70].open("GET",'invoiceDbDetail.php?REQUEST=retrv_po_wise_ci&InvoiceNo=' + InvoiceNo  ,true);
		xmlHttp[70].send(null);
}



function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 1) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}


function load_isd()
{
	if($('#cboFinalInvoice').val()==""){
		var $tabs = $('#tabs').tabs(); $tabs.tabs('select',0);		
		return;
		
	}
	var InvoiceNo	=URLEncode(document.getElementById("cboInvoiceNo").value);
	var url			='invoiceDbDetail.php?REQUEST=load_isd&invoiceno=' + InvoiceNo  ;
	htmlobj			=$.ajax({url:url,async:false});	
	RomoveData('cmbISDnoz');
	var xml_isdno	=htmlobj.responseXML.getElementsByTagName('isd');
		for(var loop	=0;loop<xml_isdno.length;loop++)
			{
						var opt 	= document.createElement("option");
						opt.text 	= xml_isdno[loop].childNodes[0].nodeValue;
						opt.value 	= xml_isdno[loop].childNodes[0].nodeValue;
						document.getElementById("cmbISDnoz").options.add(opt);
				
			}
}

function load_po_from_isd()
{
	var InvoiceNo		=document.getElementById("cboInvoiceNo").value;
	var isd_no			=document.getElementById("cmbISDnoz").value;
	cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	var url				='invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + InvoiceNo+'&isd_no='+isd_no  ;
	htmlobj				=$.ajax({url:url,async:false});	
	var invdtlno		=htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var StyleID			=htmlobj.responseXML.getElementsByTagName('StyleID');
	var ItemNo			=htmlobj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo		=htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods		=htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity		=htmlobj.responseXML.getElementsByTagName('Quantity');
	var UnitID			=htmlobj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice		=htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP			=htmlobj.responseXML.getElementsByTagName('lCMP');
	var Amount			=htmlobj.responseXML.getElementsByTagName('Amount');	
	var HSCode			=htmlobj.responseXML.getElementsByTagName('HSCode');
	var GrossMass		=htmlobj.responseXML.getElementsByTagName('GrossMass');
	var NetMass			=htmlobj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID		=htmlobj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns		=htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var Category		=htmlobj.responseXML.getElementsByTagName('Category');
	var ProcedureCode	=htmlobj.responseXML.getElementsByTagName('ProcedureCode');
	var ISD				=htmlobj.responseXML.getElementsByTagName('ISD');
	var pos				=0;
	var ISD				=htmlobj.responseXML.getElementsByTagName('ISD');
	var Fabric			=htmlobj.responseXML.getElementsByTagName('Fabric');
	var PLno			=htmlobj.responseXML.getElementsByTagName('PLno');
	var Dc				=htmlobj.responseXML.getElementsByTagName('Dc');
	var netnet			=htmlobj.responseXML.getElementsByTagName('netnet');
	var SD				=htmlobj.responseXML.getElementsByTagName('SD');
	var specdetail		=htmlobj.responseXML.getElementsByTagName('specdetail');
	var consttype		=htmlobj.responseXML.getElementsByTagName('consttype');
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\"  />";
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =empty_handle_str(StyleID[loop].childNodes[0].nodeValue)
				rowCell.id=SD[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(BuyerPONo[loop].childNodes[0].nodeValue);
				rowCell.id=Dc[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(ISD[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(PLno[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(specdetail[loop].childNodes[0].nodeValue);
				rowCell.id		  =specdetail[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabric[loop].childNodes[0].nodeValue);
				rowCell.id		  =consttype[loop].childNodes[0].nodeValue
		
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ='n/a';
		
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(HSCode[loop].childNodes[0].nodeValue);
	 
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(UnitPrice[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(PriceUnitID[loop].childNodes[0].nodeValue);		
				
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Quantity[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =empty_handle_str(UnitID[loop].childNodes[0].nodeValue);				
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Amount[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(GrossMass[loop].childNodes[0].nodeValue);	
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(NetMass[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(netnet[loop].childNodes[0].nodeValue);
								
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = empty_handle_dbl(NoOfCTns[loop].childNodes[0].nodeValue);
		}
}

function clearform()
{
	
	document.getElementById("commercial_inv").reset();
}

function empty_handle_str(str)
{	
	return(str==""?"n/a":str);	
}

function empty_handle_dbl(no)
{	
	return(no==""?"0":no);	
}

function del_final_inv()
{
	var tbl 			= document.getElementById('tblDescriptionOfGood');
	if(tbl.rows.length<2)
	{
		alert("Sorry, there is no record in the detail grid.")	;
		return;
	}
	$('#cboInvoiceNo').val("");
	var InvoiceNo		=URLEncode(document.getElementById("txtInvoiceNo").value);
	var url				='invoiceDbDetail.php?REQUEST=del_final_inv&invoiceno=' + InvoiceNo  ;
	htmlobj				=$.ajax({url:url,async:false});	
			if(htmlobj.responseText.trim()=="deleted")
			{
			save_final_inv();
			}

} 

function save_final_inv()
{
	var InvoiceNo		=document.getElementById("txtInvoiceNo").value;
	var tbl 			= document.getElementById('tblDescriptionOfGood');
	var	item_no			=0;
	for (var loop=1;loop<tbl.rows.length;loop++)
		{
			var row= tbl.rows[loop];
			if(row.cells[1].childNodes[0].checked==true)
			{	item_no++;
				var style		=row.cells[2].childNodes[0].nodeValue;
				var sd			=row.cells[2].id;
				var dc			=row.cells[3].id;
				var po			=row.cells[3].childNodes[0].nodeValue;
				var isd			=row.cells[4].childNodes[0].nodeValue;
				var pl			=row.cells[5].childNodes[0].nodeValue;
				var color		=row.cells[6].childNodes[0].nodeValue;
				var desc		=row.cells[7].childNodes[0].nodeValue;
				var fabric		=row.cells[8].childNodes[0].nodeValue;
				var entryno		=row.cells[9].childNodes[0].nodeValue;
				var hs			=row.cells[10].childNodes[0].nodeValue;
				var price		=row.cells[11].childNodes[0].nodeValue;
				var price_unit	=row.cells[12].childNodes[0].nodeValue;
				var qty			=row.cells[13].childNodes[0].nodeValue;
				var qty_unit	=row.cells[14].childNodes[0].nodeValue;
				var value		=row.cells[15].childNodes[0].nodeValue;
				var gross		=row.cells[16].childNodes[0].nodeValue;
				var net			=row.cells[17].childNodes[0].nodeValue;
				var netnet		=row.cells[18].childNodes[0].nodeValue;
				var ctns		=row.cells[19].childNodes[0].nodeValue;
				var specdetail	=row.cells[7].id;
				var consttype	=row.cells[8].id;
				var retprice	=row.cells[11].id;
				var cbm			=row.cells[19].id;
			
				var url			='invoiceDbDetail.php?REQUEST=save_final_inv&invoiceno=' + URLEncode(InvoiceNo) +'&style='+URLEncode(style)+ '&po='+URLEncode(po) 
				+'&isd='+URLEncode(isd)+ '&desc='+URLEncode(desc)+ '&sd='+URLEncode(sd)+ '&dc='+dc+'&hs='+hs+ '&price='+price+'&price_unit='+URLEncode(price_unit)+ '&qty='+qty+'&qty_unit='
				+URLEncode(qty_unit)+ '&value='+value+'&gross='+gross+ '&net='+net+'&ctns='+ctns+ '&netnet='+netnet+'&pl='+pl+'&fabric='+URLEncode(fabric)+'&item_no='+item_no+'&specdetail='+URLEncode(specdetail)+'&consttype='+URLEncode(consttype)+'&retprice='+URLEncode(retprice)+'&cbm='+URLEncode(cbm)+'&entryno='+URLEncode(entryno)+'&color='+URLEncode(color);
				htmlobj			=$.ajax({url:url,async:false});	
				
			}	
			
			
		}
	alert("Saved successfully");
}


function load_final_inv_dtl()
{
	var InvoiceNo		=URLEncode(document.getElementById("txtInvoiceNo").value);
	var isd_no			=document.getElementById("cmbISDnoz").value;
	cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	var url				='invoiceDbDetail.php?REQUEST=load_final_inv_dtl&invoiceno=' + InvoiceNo+'&isd_no='+isd_no  ;
	htmlobj				=$.ajax({url:url,async:false});	
	var invdtlno		=htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var color			=htmlobj.responseXML.getElementsByTagName('Color');
	var StyleID			=htmlobj.responseXML.getElementsByTagName('StyleID');
	var ItemNo			=htmlobj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo		=htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods		=htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity		=htmlobj.responseXML.getElementsByTagName('Quantity');
	var UnitID			=htmlobj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice		=htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP			=htmlobj.responseXML.getElementsByTagName('lCMP');
	var Amount			=htmlobj.responseXML.getElementsByTagName('Amount');	
	var HSCode			=htmlobj.responseXML.getElementsByTagName('HSCode');
	var GrossMass		=htmlobj.responseXML.getElementsByTagName('GrossMass');
	var NetMass			=htmlobj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID		=htmlobj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns		=htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var Category		=htmlobj.responseXML.getElementsByTagName('Category');
	var ProcedureCode	=htmlobj.responseXML.getElementsByTagName('ProcedureCode');
	var ISD				=htmlobj.responseXML.getElementsByTagName('ISD');
	var pos				=0;
	var ISD				=htmlobj.responseXML.getElementsByTagName('ISD');
	var Fabric			=htmlobj.responseXML.getElementsByTagName('Fabric');
	var PLno			=htmlobj.responseXML.getElementsByTagName('PLno');
	var Dc				=htmlobj.responseXML.getElementsByTagName('Dc');
	var netnet			=htmlobj.responseXML.getElementsByTagName('netnet');
	var SD				=htmlobj.responseXML.getElementsByTagName('SD');
	var specdetail		=htmlobj.responseXML.getElementsByTagName('specdetail');
	var consttype		=htmlobj.responseXML.getElementsByTagName('consttype');
	var retailprice		=htmlobj.responseXML.getElementsByTagName('retprice');
	var cbm				=htmlobj.responseXML.getElementsByTagName('dblCBM');
	var entryno			=htmlobj.responseXML.getElementsByTagName('strEntryNo');
	
	
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		row.onclick	= rowclickColorChangeIou;	
		if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				else
					row.className ="bcgcolor-tblrowWhite mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\"checked=\"checked\"  />";
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =empty_handle_str(StyleID[loop].childNodes[0].nodeValue)
				rowCell.id=SD[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(BuyerPONo[loop].childNodes[0].nodeValue);
				rowCell.id=Dc[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(ISD[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(PLno[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(color[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(DescOfGoods[loop].childNodes[0].nodeValue);
				rowCell.id		  =specdetail[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabric[loop].childNodes[0].nodeValue);
				rowCell.id		  =consttype[loop].childNodes[0].nodeValue
				
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(entryno[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(HSCode[loop].childNodes[0].nodeValue);
	 
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(UnitPrice[loop].childNodes[0].nodeValue);
				rowCell.id		  =retailprice[loop].childNodes[0].nodeValue
		
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(PriceUnitID[loop].childNodes[0].nodeValue);		
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Quantity[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =empty_handle_str(UnitID[loop].childNodes[0].nodeValue);				
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Amount[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(GrossMass[loop].childNodes[0].nodeValue);	
				
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(NetMass[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(18);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(netnet[loop].childNodes[0].nodeValue);
								
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = empty_handle_dbl(NoOfCTns[loop].childNodes[0].nodeValue);
				cellDelete.id		 =cbm[loop].childNodes[0].nodeValue;
		}
}

function getMass()
{
	var plno 		=	document.getElementById("txtPLno").value;
	var url	 		=	("invoiceDbDetail.php?REQUEST=getMass&plno="+plno);
	var http_obj	=	$.ajax({url:url,async:false})
	document.getElementById('txtGross').value=http_obj.responseXML.getElementsByTagName('Gorss')[0].childNodes[0].nodeValue;
	document.getElementById('txtNet').value=http_obj.responseXML.getElementsByTagName('Net')[0].childNodes[0].nodeValue;
	document.getElementById('txtNetNet').value=http_obj.responseXML.getElementsByTagName('NetNet')[0].childNodes[0].nodeValue;
	document.getElementById('txtCtns').value=http_obj.responseXML.getElementsByTagName('ctns')[0].childNodes[0].nodeValue;
	document.getElementById('txtStyle').value=http_obj.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue;
	document.getElementById('txtQty').value=http_obj.responseXML.getElementsByTagName('qty')[0].childNodes[0].nodeValue;
	document.getElementById('txtBuyerPO').value=http_obj.responseXML.getElementsByTagName('PO')[0].childNodes[0].nodeValue;
	document.getElementById('txtISDNo').value=http_obj.responseXML.getElementsByTagName('ISDno')[0].childNodes[0].nodeValue;
	document.getElementById('txtareaDisc').value=http_obj.responseXML.getElementsByTagName('Item')[0].childNodes[0].nodeValue;
	document.getElementById('txtFabricDesc').value=http_obj.responseXML.getElementsByTagName('pllable')[0].childNodes[0].nodeValue;
	document.getElementById('txtConstType').value=http_obj.responseXML.getElementsByTagName('plfabric')[0].childNodes[0].nodeValue;
	document.getElementById('txtareaSpecDisc').value=http_obj.responseXML.getElementsByTagName('Item')[0].childNodes[0].nodeValue;
	document.getElementById('txtDC').value=http_obj.responseXML.getElementsByTagName('Dc')[0].childNodes[0].nodeValue;
	document.getElementById('txtCBM').value=http_obj.responseXML.getElementsByTagName('CBM')[0].childNodes[0].nodeValue;
	getItemVal(); 
}