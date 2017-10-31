var item=0;
var verpos=0;
var prev_hs		="";
var prev_desc	="";
var prev_fabric	="";
var pub_window=[];

function getInvoiceDetail()
{
	document.getElementById("txtInvoiceDetail").value=document.getElementById("txtInvoiceNo").value;
	if(document.getElementById("txtInvoiceDetail").value!="")
	{
		if (document.getElementById("cboInvoiceNo").value=="")
						saveData();	
		var invoiceno=document.getElementById("txtInvoiceDetail").value; 
		createNewXMLHttpRequest(4);
		xmlHttp[4].onreadystatechange=addToDetailGrid;
		xmlHttp[4].open("GET",'invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + invoiceno,true);
		xmlHttp[4].send(null);
		//alert("ouhiyibbu");
	
	}
	else
	{
	alert("Please select an invoice number.");
	pageReload();
	//addToDetailGrid();
	
	}
}
/*
tblDescriptionOfGood
*/


function addToDetailGrid()
{

    if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
		cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	//alert(detailGrid.rows.length);
	var invdtlno=xmlHttp[4].responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=xmlHttp[4].responseXML.getElementsByTagName('StyleID');
	var PL=xmlHttp[4].responseXML.getElementsByTagName('PL');
	var ItemNo=xmlHttp[4].responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=xmlHttp[4].responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=xmlHttp[4].responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=xmlHttp[4].responseXML.getElementsByTagName('Quantity');
	var UnitID=xmlHttp[4].responseXML.getElementsByTagName('UnitID');
	var UnitPrice=xmlHttp[4].responseXML.getElementsByTagName('UnitPrice');
	var lCMP=xmlHttp[4].responseXML.getElementsByTagName('lCMP');
	var Amount=xmlHttp[4].responseXML.getElementsByTagName('Amount');	
	var HSCode=xmlHttp[4].responseXML.getElementsByTagName('HSCode');
	var GrossMass=xmlHttp[4].responseXML.getElementsByTagName('GrossMass');
	var NetMass=xmlHttp[4].responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=xmlHttp[4].responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=xmlHttp[4].responseXML.getElementsByTagName('NoOfCTns');
	var Category=xmlHttp[4].responseXML.getElementsByTagName('Category');
	var ProcedureCode=xmlHttp[4].responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=xmlHttp[4].responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=xmlHttp[4].responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=xmlHttp[4].responseXML.getElementsByTagName('ISD');
	var Fabrication=xmlHttp[4].responseXML.getElementsByTagName('Fabrication');
	var Color=xmlHttp[4].responseXML.getElementsByTagName('Color');
	var CBM=xmlHttp[4].responseXML.getElementsByTagName('CBM');
	var SCNO=xmlHttp[4].responseXML.getElementsByTagName('strSC_No');
	//alert(xmlHttp[4].responseText);
	var pos=0;
		for(var loop=0;loop<invdtlno.length;loop++)
		{		
		var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
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
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =SCNO[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(SCNO[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		
		
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		}
	//alert (item);
	}
	
	//rowupdater();
	calTot();
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


/////////////////////////edit grid////////

function editItems()
{
	//alert("kk");
newDettail();
document.getElementById('txtStyle').value=this.cells[2].childNodes[0].nodeValue;
var Prcode=this.cells[5].id;
if(Prcode=="")
{
	Prcode="0000.000";
}
document.getElementById('txtProcedureCode').value=Prcode;

document.getElementById('txtareaDisc').value=this.cells[5].childNodes[0].nodeValue;
//document.getElementById('txtareaDisc').value="-";
document.getElementById('txtUnit').value=this.cells[11].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value=this.cells[8].childNodes[0].nodeValue;
document.getElementById('txtGross').value=this.cells[12].childNodes[0].nodeValue;
document.getElementById('txtCtns').value=this.cells[16].childNodes[0].nodeValue;
document.getElementById('txtNet').value=this.cells[13].childNodes[0].nodeValue;
document.getElementById('txtBuyerPO').value=this.cells[3].childNodes[0].nodeValue;
document.getElementById('txtHS').value=this.cells[15].childNodes[0].nodeValue;
document.getElementById('txtQty').value=this.cells[10].childNodes[0].nodeValue;
document.getElementById('txtQtyUnit').value=this.cells[9].childNodes[0].nodeValue;
document.getElementById('txtCM').value=0;
document.getElementById('txtValue').value=calValue(this.cells[7].childNodes[0].nodeValue,this.cells[10].childNodes[0].nodeValue,this.cells[9].childNodes[0].nodeValue,this.cells[8].childNodes[0].nodeValue,1);
document.getElementById('cboCategory').value=this.cells[2].id;
document.getElementById('txtUmoQty1').value=this.cells[17].childNodes[0].nodeValue;
document.getElementById('txtUmoQty2').value=this.cells[18].childNodes[0].nodeValue;
document.getElementById('txtUmoQty3').value=this.cells[19].childNodes[0].nodeValue;
document.getElementById('cboUmoQty1').value=this.cells[17].id;
document.getElementById('cboUmoQty2').value=this.cells[18].id;
document.getElementById('cboUmoQty3').value=this.cells[19].id;
document.getElementById('txtISDNo').value=this.cells[20].childNodes[0].nodeValue;
document.getElementById('txtCBM').value=this.cells[21].childNodes[0].nodeValue;
document.getElementById('txtFabric').value=empty_handle_str(this.cells[6].childNodes[0].nodeValue);
document.getElementById('txtColor').value=this.cells[6].childNodes[0].nodeValue;
document.getElementById('txtPL').value=this.cells[4].childNodes[0].nodeValue;
document.getElementById('txtScNo').value=this.cells[1].childNodes[0].nodeValue;
var editgrid=document.getElementById('tblDescriptionOfGood');
editgrid.deleteRow(this.rowIndex);

//position=this.cells[15].id;
//verpos=this.cells[1].childNodes[0].nodeValue;
//alert(position);
}

function chckPo()
{
	var buyerPoNo=document.getElementById('txtBuyerPO').value;
	var invoiceNo=document.getElementById('txtInvoiceDetail').value;
	
	var url	 		=	"commercialinvoiceDB.php?REQUEST=checkPo&invoiceNo="+invoiceNo+"&buyerPoNo="+buyerPoNo;
	var http_obj	=	$.ajax({url:url,async:false})
	//alert(http_obj.responseText);	
	
	if (http_obj.responseText==1)
		{
			alert("Po Number Alredy Exist..")	
		}
}



function addToGrid()
{
	chckPo()
	if(document.getElementById('txtProcedureCode').disabled==false) 	
	{	
	if(inputvalidation())
	{
		var checkpc=document.getElementById('txtProcedureCode').value;
		if(validateprocedure(checkpc)==true)
		{
		var editgrid=document.getElementById('tblDescriptionOfGood');
		var prevpos=0;
		var verprepos=0;
			var dsc=document.getElementById('txtareaDisc').value;
			var style=document.getElementById('txtStyle').value;
			var unit1=document.getElementById('txtUnit').value;
			var unitprice=document.getElementById('txtUnitPrice').value;
			var gross=document.getElementById('txtGross').value;
			var ctns=document.getElementById('txtCtns').value;
			var net=document.getElementById('txtNet').value;
			var bpo=document.getElementById('txtBuyerPO').value;
			var unitqty=document.getElementById('txtQtyUnit').value;
			var cm=document.getElementById('txtCM').value;
			var qty=document.getElementById('txtQty').value;
			var category=document.getElementById('cboCategory').value;		
			var hs=document.getElementById('txtHS').value;
			var value=calValue(unitprice,unit1,qty,unitqty,1);
			var procedurecode=document.getElementById('txtProcedureCode').value;
			var umoUnit1=document.getElementById('cboUmoQty1').value;
			var umoUnit2=document.getElementById('cboUmoQty2').value;
			var umoUnit3=document.getElementById('cboUmoQty3').value;
			var ISD=document.getElementById('txtISDNo').value;
			var PL=document.getElementById('txtPL').value;
			var fabric=document.getElementById('txtFabric').value;
			var color=document.getElementById('txtColor').value;
			var uqty1=document.getElementById('txtUmoQty1').value;
			var uqty2=document.getElementById('txtUmoQty2').value;
			var uqty3=document.getElementById('txtUmoQty3').value;
			var CBM=document.getElementById('txtCBM').value;
			var ScNo=document.getElementById('txtScNo').value;
			//var PL=document.getElementById('txtPL').value;
				//verprepos=verpos;
				//prevpos=position;
				
				//alert(PL);
				
			var lastRow 		= editgrid.rows.length;	
			var row 			= editgrid.insertRow(lastRow);
					
			row.ondblclick=editItems;
			row.className ="bcgcolor-tblrow mouseover";
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =ScNo;
				rowCell.id=category;
		if(style=="")
		{
			rowCell.innerHTML = "n/a";
		}
		
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =style;
				rowCell.id=category;
		if(style=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =bpo;
				rowCell.id=category;
		if(bpo=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL;
				rowCell.id=procedurecode;
		if(PL=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =dsc;
				rowCell.id=procedurecode;
		if(dsc=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =fabric;
				rowCell.id=procedurecode;
		if(fabric=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =color;
		if(color=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unitprice;
		if(unitprice=="")
		{
			rowCell.innerHTML = "n/a";
		}						
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =unitqty;		
		if(unitqty=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =qty;
		if(qty=="")
		{
			rowCell.innerHTML = "0";
		}			
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =unit1;		
		if(unit1=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =value;
		if(value=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =gross;				
		if(gross=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =net;
		if(net=="")
		{
			rowCell.innerHTML = "0";
		}					
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =hs;	
		if(hs=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =ctns;
				
		
		if(ctns=="")
		{
			rowCell.innerHTML = "0";
		}			
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty1;
				cellDelete.id=umoUnit1;
		if(uqty1=="")
		{
			cellDelete.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty2;
				cellDelete.id=umoUnit2;
		if(uqty2=="")
		{
			cellDelete.innerHTML = "0";
		}					
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = uqty3;
				cellDelete.id=umoUnit3;
		if(uqty3=="")
		{
			cellDelete.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD;
		if(ISD=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(21); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM;
		if(CBM=="")
		{
			
			cellDelete.innerHTML = "0";
		}
		cleardata();
		InsertDetail();
		}
		else
		alert("Procedure code format should be like 0000.000");
	}
	}
	
}

function editInvoiceDtlDb(wut,pos,value)
{			
			prev_hs		=document.getElementById('txtHS').value;
			prev_desc	=document.getElementById('txtareaDisc').value;
			prev_fabric	=document.getElementById('txtFabric').value;
//alert(pos);
			var invoiceno=document.getElementById("txtInvoiceDetail").value;
			var dsc=document.getElementById('txtareaDisc').value;
			var desc=URLEncode(dsc);
			var style=document.getElementById('txtStyle').value;
			var unit=document.getElementById('txtUnit').value;
			var unitprice=document.getElementById('txtUnitPrice').value;
			var gross=document.getElementById('txtGross').value;
			var ctns=document.getElementById('txtCtns').value;
			var net=document.getElementById('txtNet').value;
			var bpo=document.getElementById('txtBuyerPO').value;
			var unitqty=document.getElementById('txtQtyUnit').value;
			var cm=document.getElementById('txtCM').value;
			var qty=document.getElementById('txtQty').value;			
			var hs=document.getElementById('txtHS').value;
			var category=document.getElementById('cboCategory').value;
			var procedurecode=document.getElementById('txtProcedureCode').value;
			var umoqty1=document.getElementById('txtUmoQty1').value;
			var umoqty2=document.getElementById('txtUmoQty2').value;
			var umoqty3=document.getElementById('txtUmoQty3').value;
			var val=document.getElementById('txtValue').value;
			var umoUnit1=document.getElementById('cboUmoQty1').value;
			var umoUnit2=document.getElementById('cboUmoQty2').value;
			var umoUnit3=document.getElementById('cboUmoQty3').value;
			var ISDNo=document.getElementById('txtISDNo').value;
			var fabrication=document.getElementById('txtFabric').value;
			var PL=document.getElementById('txtPLno').value;
						var ScNo=document.getElementById('txtScNo').value;

			//var value=100;
			//var value=calValue(unitprice,unit,qty,unitqty,cm); 
	createNewXMLHttpRequest(5);
	
	xmlHttp[5].onreadystatechange=function()
	{
	if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
	{
	alert(xmlHttp[5].responseText);	
	cleardata();
	getInvoiceDetail() ;
	//alert(item);
	
	}
	}
	xmlHttp[5].open("GET",'invoiceDbDetail.php?REQUEST=editData&invoiceno=' + invoiceno+ '&dsc='+desc+ '&style='+style+
	'&value='+val+ '&unit=' +unit+ '&unitprice='+unitprice+ '&gross=' +gross+ '&ctns=' +ctns+  '&net=' +net+ 
	'&bpo=' +bpo+ '&unitqty=' +unitqty+ '&cm=' +cm+ '&procedurecode=' +procedurecode+'&hs=' +hs+ '&wut=' +wut + '&pos=' +pos + 
	'&qty=' +qty+ '&category=' +category+ '&umoqty1='+umoqty1+ '&umoqty2='+umoqty2+ '&umoqty3='+umoqty3 + '&PL='+PL
	+ '&umoUnit1='+umoUnit1+ '&umoUnit2='+umoUnit2+ '&umoUnit3='+umoUnit3+ '&ISDNo='+ISDNo+ '&fabrication='+fabrication+ '&ScNo='+ScNo,true);
	xmlHttp[5].send(null);
	//alert(wut+" "+pos+ " "+ invoiceno);
}

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
	var item=cell.parentNode.parentNode.childNodes[15].id;
	var invoiceno=document.getElementById("txtInvoiceDetail").value;
	var tbl = document.getElementById('tblDescriptionOfGood');
	//alert (cell.parentNode.parentNode.rowIndex);	
		
	if (confirm("Are you sure you want to delete?" ))
	{
		tbl.deleteRow(cell.parentNode.parentNode.rowIndex);
		InsertDetail();
	}
}


function cleardata()
{
	
	
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
	document.getElementById('txtCM').value="";
	document.getElementById('txtProcedureCode').value="";
	document.getElementById('cboCategory').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtUmoQty1').value="";
	document.getElementById('txtUmoQty2').value="";
	document.getElementById('txtUmoQty3').value="";
	document.getElementById('cboUmoQty1').value="";
	document.getElementById('cboUmoQty2').value="";
	document.getElementById('cboUmoQty3').value="";
	document.getElementById('txtISDNo').value="";
	document.getElementById('txtFabric').value="";
	document.getElementById('txtCBM').value="";
	


	//document.getElementById('txtCBM').value="";
	document.getElementById('txtCBM').disabled=true;
	document.getElementById('txtStyle').disabled=true;
	document.getElementById('txtPLno').disabled=true;
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
	document.getElementById('txtCM').disabled=true;
	document.getElementById('txtProcedureCode').disabled=true;
	document.getElementById('cboCategory').disabled=true;
	document.getElementById('txtValue').disabled=true;
	document.getElementById('txtUmoQty1').disabled=true;
	document.getElementById('txtUmoQty2').disabled=true;
	document.getElementById('txtUmoQty3').disabled=true;
	document.getElementById('cboUmoQty1').disabled=true;
	document.getElementById('cboUmoQty2').disabled=true;
	document.getElementById('cboUmoQty3').disabled=true;
	document.getElementById('txtISDNo').disabled=true;
	document.getElementById('txtFabric').disabled=true;
	//document.getElementById('imgADD').style.visibility="hidden";
}

function calValue(p,pu,qty,qtyu,cm)
{
	if(p!="" && qty!="")
	{
		var actp=0;
		var aqty=0; 
		if (pu=="DZN")
		{
			actp=parseFloat(p/12);
		}
		else 	
			actp=parseFloat(p);
		
			aqty=parseFloat(qty);
		var final=actp*aqty;
		var formatnum=final.toFixed([2]);
		return formatnum;
	}
	else 
	return 0;
	/*if(p!="" && qty!="")
	{
		var actp=0;
		var aqty=0; 
		if (pu=="DZN")
		{
			actp=parseFloat(p/12);
		}
		else 	
			actp=parseFloat(p);
		if (qtyu=='DZN')
			aqty=parseFloat(qty*12);
		else 
			aqty=parseFloat(qty);
		var final=parseFloat(actp*aqty)
		var formatnum=RoundNumbers(final,2);
		return formatnum;
	}
	else 
	return 0;		 */
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
		alert("Please select the price unit.");
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
		alert("Please select the qty unit.");
		return false;
	}
	
if(document.getElementById('txtCM').value=="")
	{
		alert("Please Enter CM.");
		document.getElementById('txtCM').focus();
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

if(document.getElementById('txtInvoiceNo').value!="")
	{
		window.open("rptpreshipmentinvoice.php?InvoiceNo=" + document.getElementById("txtInvoiceNo").value+'&type=','pre_inv');
		window.open("rptShippingNote.php?InvoiceNo=" + document.getElementById("txtInvoiceNo").value+'&type=','sn');
		window.open("CO_boi.php?InvoiceNo=" + document.getElementById("txtInvoiceNo").value+'&type=','co');
		window.open("CO_boidrag.php?InvoiceNo=" + document.getElementById("txtInvoiceNo").value+'&type=','cob');
	}
	
try{
			for(var i=0;i<pub_window.length;i++)
			{
					pub_window[i].close();
			}
		}
	catch(err){}
	 var invoiceno	    =document.getElementById('txtInvoiceNo').value;
	 var url		    = "commercialinvoiceDB.php?REQUEST=prit_straight&invoiceno="+invoiceno;
	 var xml_http_obj   =$.ajax({url:url,async:false});
	 var xml_url		=xml_http_obj.responseXML.getElementsByTagName('Url');
	 for(var j=0;j<xml_url.length;j++)
	 	{
			pub_window[j]=window.open(xml_url[j].childNodes[0].nodeValue+"?InvoiceNo="+invoiceno);
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
	var cm=document.getElementById('txtCM').value;
	var qty=document.getElementById('txtQty').value;	
	var value=calValue(unitprice,unit,qty,unitqty,cm); 
	document.getElementById('txtValue').value=value;
}

function newDettail()
{
	document.getElementById('txtStyle').disabled=false;
	document.getElementById('txtCBM').disabled=false;
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
	document.getElementById('txtCM').disabled=false;
	document.getElementById('txtProcedureCode').disabled=false;
	document.getElementById('cboCategory').disabled=false;
	document.getElementById('txtValue').disabled=false;
	document.getElementById('txtUmoQty1').disabled=false;
	document.getElementById('txtUmoQty2').disabled=false;
	document.getElementById('txtUmoQty3').disabled=false;
	document.getElementById('cboUmoQty1').disabled=false;
	document.getElementById('cboUmoQty2').disabled=false;
	document.getElementById('cboUmoQty3').disabled=false;
	document.getElementById('txtISDNo').disabled=false;
	document.getElementById('txtFabric').disabled=false;
	//document.getElementById('imgADD').style.visibility="visible";
	document.getElementById('txtStyle').value="";
	//document.getElementById('txtValue').value="";
	document.getElementById('txtareaDisc').value=prev_desc;
	document.getElementById('txtUnit').value="";
	document.getElementById('txtUnitPrice').value="0000.000";
	document.getElementById('txtGross').value="";
	document.getElementById('txtCtns').value="";
	document.getElementById('txtNet').value="";
	document.getElementById('txtBuyerPO').value="";
	document.getElementById('txtHS').value=prev_hs;
	document.getElementById('txtQty').value="";
	document.getElementById('txtQtyUnit').value="";
	document.getElementById('txtCBM').value="";
	document.getElementById('txtCM').value="0";
	document.getElementById('txtProcedureCode').value="3054.950";
	document.getElementById('cboCategory').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtUmoQty1').value="";
	document.getElementById('txtUmoQty2').value="";
	document.getElementById('txtUmoQty3').value="";
	document.getElementById('cboUmoQty1').value="PCS";
	document.getElementById('cboUmoQty2').value="";
	document.getElementById('cboUmoQty3').value="DZN";
	document.getElementById('txtISDNo').value="";
	document.getElementById('txtFabric').value=prev_fabric;
	

}

function setGenDesc()
{
	//document.getElementById('txtareaDisc').value=document.getElementById("txtDiscription").value;
	
}

function calUOM()
{
		
	if(document.getElementById('txtQty').value=="")	
		return false;
	if(document.getElementById('txtQtyUnit').value=="DZN")
	{
		document.getElementById('txtUmoQty3').value=parseFloat(document.getElementById('txtQty').value);
		document.getElementById('txtUmoQty1').value=parseFloat(document.getElementById('txtQty').value)*12;
	}
	else if (document.getElementById('txtQtyUnit').value!="DZN")
	{	
		var dzn=parseInt(parseFloat(document.getElementById('txtQty').value)/12);
		if (parseFloat(document.getElementById('txtQty').value)%12>0)
		dzn+=1;
		document.getElementById('txtUmoQty3').value=dzn;
		document.getElementById('txtUmoQty1').value=parseFloat(document.getElementById('txtQty').value);
	}
}

function add_po_wise_ci()
{
	
		var hs=document.getElementById('txtHS_po').value;
		var desc=document.getElementById('txtDesc_po').value;
		var cat=document.getElementById('txtCatno_po').value;
		var isd=document.getElementById('txtISD_po').value;
		var po=document.getElementById('txtPO_po').value;
		var qty=document.getElementById('txtQty_po').value;
		var unt=document.getElementById('txtUnit_po').value;
		var price=document.getElementById('txtPrice_po').value;
		var currency=document.getElementById('cboCurrency_po').value;
		var amount=document.getElementById('txtAmount_po').value;
				
		var tbl =document.getElementById("tblDescription_po");
		var lastRow 		= tbl.rows.length;	
		var row 			= tbl.insertRow(lastRow);
		
		row.onclick	= rowclickColorChangeIou2;	
		row.ondblclick	= edit_po_wise;	
		
		if(lastRow % 2 ==1)
			row.className ="bcgcolor-tblrow mouseover";
		else
			row.className ="bcgcolor-tblrowWhite mouseover";
		
				
		var rowCell = row.insertCell(0);
		rowCell.className ="normalfntMid";
		rowCell.height='20';
		rowCell.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"remove_powise_grid(this);\"/>";	
		
		var rowCell = row.insertCell(1);
		rowCell.innerHTML =hs;		
		
		var rowCell = row.insertCell(2);
		rowCell.innerHTML =po;		
		
		var rowCell = row.insertCell(3);
		rowCell.innerHTML =isd;	
		
		var rowCell = row.insertCell(4);
		rowCell.innerHTML =cat;	
		
		var rowCell = row.insertCell(5);
		rowCell.innerHTML =desc;	
		
		var rowCell = row.insertCell(6);
		rowCell.className ="normalfntRite";			
		rowCell.innerHTML =qty;
		
		var rowCell = row.insertCell(7);
		rowCell.className ="normalfnt";			
		rowCell.innerHTML =unt;
		
		var rowCell = row.insertCell(8);
		rowCell.className ="normalfntRite";			
		rowCell.innerHTML =price;
		
		var rowCell = row.insertCell(9);
		rowCell.className ="normalfnt";			
		rowCell.innerHTML =currency;
		
		var rowCell = row.insertCell(10);
		rowCell.className ="normalfntRite";			
		rowCell.innerHTML =amount;
		
		document.getElementById('txtHS_po').focus();
}

function remove_powise_grid(obj)
{
	var index=obj.parentNode.parentNode.rowIndex;
	var tbl =document.getElementById("tblDescription_po");
	tbl.deleteRow(index);
}

function cal_po_amount()
{
		var qty=document.getElementById('txtQty_po').value;
		var price=document.getElementById('txtPrice_po').value;
		if(qty.trim()!="" && price.trim()!=""){
		document.getElementById('txtAmount_po').value=parseFloat(qty)*parseFloat(price);
		}
	
}

function edit_po_wise()
{
	
		var row=document.getElementById("tblDescription_po").rows[this.rowIndex];
		document.getElementById('txtHS_po').value=row.cells[1].childNodes[0].nodeValue;
		document.getElementById('txtDesc_po').value=row.cells[5].childNodes[0].nodeValue;
		document.getElementById('txtCatno_po').value=row.cells[4].childNodes[0].nodeValue;
		document.getElementById('txtISD_po').value=row.cells[3].childNodes[0].nodeValue;
		document.getElementById('txtPO_po').value=row.cells[2].childNodes[0].nodeValue;
		document.getElementById('txtQty_po').value=row.cells[6].childNodes[0].nodeValue;
		document.getElementById('txtUnit_po').value=row.cells[7].childNodes[0].nodeValue;
		document.getElementById('txtPrice_po').value=row.cells[8].childNodes[0].nodeValue;
		document.getElementById('cboCurrency_po').value=row.cells[9].childNodes[0].nodeValue;
		document.getElementById('txtAmount_po').value=row.cells[10].childNodes[0].nodeValue;
		document.getElementById("tblDescription_po").deleteRow(this.rowIndex);
	
}

function calMass()
{
	if(document.getElementById('txtQty').value==""||document.getElementById('txtQty').value==null)
		return;
	document.getElementById('txtGross').value=Math.round((parseFloat(document.getElementById('txtQty').value)*(0.69)).toFixed(2));
	document.getElementById('txtNet').value=Math.round((document.getElementById('txtQty').value)*(0.62));
}

function save_to_db_ci()
{

	
	
	var InvoiceNo=document.getElementById("cboInvoiceNo").value;
	var tbl=document.getElementById("tblDescription_po");
	
	for(var loop=1;loop<tbl.rows.length;loop++)
	{	
		var row		=tbl.rows[loop];
		var hs		=row.cells[1].childNodes[0].nodeValue;
		var desc	=row.cells[5].childNodes[0].nodeValue;
		var catno	=row.cells[4].childNodes[0].nodeValue;
		var isd		=row.cells[3].childNodes[0].nodeValue;
		var po		=row.cells[2].childNodes[0].nodeValue;
		var qty		=row.cells[6].childNodes[0].nodeValue;
		var unt		=row.cells[7].childNodes[0].nodeValue;
		var price	=row.cells[8].childNodes[0].nodeValue;
		var currency=row.cells[9].childNodes[0].nodeValue;
		var amount	=row.cells[10].childNodes[0].nodeValue;
		createNewXMLHttpRequest(71);
		xmlHttp[71].onreadystatechange=function()
		{
			
			
		if(xmlHttp[71].readyState==4 && xmlHttp[71].status==200)
			{	
			
				
			}	
			
		}
		xmlHttp[71].open("GET",'invoiceDbDetail.php?REQUEST=save_po_wise_ci&InvoiceNo=' + InvoiceNo + '&hs=' +hs+ '&desc=' +desc+ '&catno=' +catno+ '&isd=' +isd+ '&po=' +po+ '&qty=' +qty+ '&unt=' +unt+ '&price=' +price + '&currency=' +currency+ '&amount=' +amount  ,true);
		xmlHttp[71].send(null);
	}
	alert("Successfully saved.");
	hideBackGroundBalck();
}

function save_po_wise_ci()
{	showBackGroundBalck();
	createNewXMLHttpRequest(69);
	var InvoiceNo=document.getElementById("cboInvoiceNo").value;
	xmlHttp[69].onreadystatechange=function()
		{			
			if(xmlHttp[69].readyState==4 && xmlHttp[69].status==200)
				{	
					save_to_db_ci();
					
				}				
		}
	xmlHttp[69].open("GET",'invoiceDbDetail.php?REQUEST=delete_po_wise_ci&InvoiceNo=' + InvoiceNo  ,true);
	xmlHttp[69].send(null);	
}

function retrv_po_wise_ci()
{	

	createNewXMLHttpRequest(70);
	var InvoiceNo=document.getElementById("cboInvoiceNo").value;
	deleterows("tblDescription_po");
	xmlHttp[70].onreadystatechange=function()
		{
			
			
		if(xmlHttp[70].readyState==4 && xmlHttp[70].status==200)
			{	
				var InvoiceNo=xmlHttp[70].responseXML.getElementsByTagName('InvoiceNo');
				var PONO=xmlHttp[70].responseXML.getElementsByTagName('PONO');
				var ISDNo=xmlHttp[70].responseXML.getElementsByTagName('ISDNo');
				var HScode=xmlHttp[70].responseXML.getElementsByTagName('HScode');
				var Desc=xmlHttp[70].responseXML.getElementsByTagName('Desc');
				var Qty=xmlHttp[70].responseXML.getElementsByTagName('Qty');	
				var Unit=xmlHttp[70].responseXML.getElementsByTagName('Unit');
				var Price=xmlHttp[70].responseXML.getElementsByTagName('Price');
				var Currency=xmlHttp[70].responseXML.getElementsByTagName('Currency');	
				var Amount=xmlHttp[70].responseXML.getElementsByTagName('Amount');
				var CatNo=xmlHttp[70].responseXML.getElementsByTagName('CatNo');
				var tbl =document.getElementById("tblDescription_po");
				for(var loop=0;loop<InvoiceNo.length;loop++)				
				{
					
					var lastRow 		= tbl.rows.length;	
					var row 			= tbl.insertRow(lastRow);
					
					row.onclick	= rowclickColorChangeIou2;	
					row.ondblclick	= edit_po_wise;	
					
					if(lastRow % 2 ==1)
						row.className ="bcgcolor-tblrow mouseover";
					else
						row.className ="bcgcolor-tblrowWhite mouseover";
					
							
					var rowCell = row.insertCell(0);
					rowCell.className ="normalfntMid";
					rowCell.height='20';
					rowCell.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"remove_powise_grid(this);\"/>";	
					
					var rowCell = row.insertCell(1);
					rowCell.innerHTML =HScode[loop].childNodes[0].nodeValue;
							
					
					var rowCell = row.insertCell(2);
					rowCell.innerHTML =PONO[loop].childNodes[0].nodeValue;		
					
					var rowCell = row.insertCell(3);
					rowCell.innerHTML =ISDNo[loop].childNodes[0].nodeValue;	
					
					var rowCell = row.insertCell(4);
					rowCell.innerHTML =CatNo[loop].childNodes[0].nodeValue;	
					
					var rowCell = row.insertCell(5);
					rowCell.innerHTML =Desc[loop].childNodes[0].nodeValue;	
					
					var rowCell = row.insertCell(6);
					rowCell.className ="normalfntRite";			
					rowCell.innerHTML =Qty[loop].childNodes[0].nodeValue;
					
					var rowCell = row.insertCell(7);
					rowCell.className ="normalfnt";			
					rowCell.innerHTML =Unit[loop].childNodes[0].nodeValue;
					
					var rowCell = row.insertCell(8);
					rowCell.className ="normalfntRite";			
					rowCell.innerHTML =Price[loop].childNodes[0].nodeValue;
					
					var rowCell = row.insertCell(9);
					rowCell.className ="normalfnt";			
					rowCell.innerHTML =Currency[loop].childNodes[0].nodeValue;
					
					var rowCell = row.insertCell(10);
					rowCell.className ="normalfntRite";			
					rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
					
				}
				
			}	
			
		}
		xmlHttp[70].open("GET",'invoiceDbDetail.php?REQUEST=retrv_po_wise_ci&InvoiceNo=' + InvoiceNo  ,true);
		xmlHttp[70].send(null);
}

function print_preshipment_docs()
{
	var InvoiceNo=document.getElementById("cboInvoiceNo").value;
	window.open('rptpreshipmentinvoice.php?InvoiceNo='+InvoiceNo,'rpt');
	
}

function empty_handle_str(str)
{	
	return(str==""?"n/a":str);	
}

function empty_handle_dbl(no)
{	
	return(no==""?"0":no);	
}

function getMass()
{
	var plno 		=	document.getElementById("txtPLno").value;
	var url	 		=	("invoiceDbDetail.php?REQUEST=getMass&plno="+plno);
	var http_obj	=	$.ajax({url:url,async:false})
	document.getElementById('txtGross').value=http_obj.responseXML.getElementsByTagName('Gorss')[0].childNodes[0].nodeValue;
	document.getElementById('txtNet').value=http_obj.responseXML.getElementsByTagName('Net')[0].childNodes[0].nodeValue;
	//document.getElementById('txtNetNet').value=http_obj.responseXML.getElementsByTagName('NetNet')[0].childNodes[0].nodeValue;
	document.getElementById('txtCtns').value=http_obj.responseXML.getElementsByTagName('ctns')[0].childNodes[0].nodeValue;
	document.getElementById('txtStyle').value=http_obj.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue;
	document.getElementById('txtQty').value=http_obj.responseXML.getElementsByTagName('qty')[0].childNodes[0].nodeValue;
	document.getElementById('txtBuyerPO').value=http_obj.responseXML.getElementsByTagName('PO')[0].childNodes[0].nodeValue;
	document.getElementById('txtISDNo').value=http_obj.responseXML.getElementsByTagName('ISDno')[0].childNodes[0].nodeValue;
	document.getElementById('txtareaDisc').value=http_obj.responseXML.getElementsByTagName('Item')[0].childNodes[0].nodeValue;
	document.getElementById('txtFabric').value=http_obj.responseXML.getElementsByTagName('pllable')[0].childNodes[0].nodeValue;
	//document.getElementById('txtConstType').value=http_obj.responseXML.getElementsByTagName('plfabric')[0].childNodes[0].nodeValue;
	//document.getElementById('txtareaSpecDisc').value=http_obj.responseXML.getElementsByTagName('Item')[0].childNodes[0].nodeValue;
	//document.getElementById('txtDC').value=http_obj.responseXML.getElementsByTagName('Dc')[0].childNodes[0].nodeValue;
	//document.getElementById('txtCBM').value=http_obj.responseXML.getElementsByTagName('CBM')[0].childNodes[0].nodeValue;
	getItemVal(); 
}

function viewPOPUPDetail()
{
		createNewXMLHttpRequest(15);
		xmlHttp[15].onreadystatechange=function()
		{	
			if(xmlHttp[15].readyState==4 && xmlHttp[15].status==200)
   		 {
        		
				drawPopupArea(950,390,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[15].responseText;
						
		 }
			
		}
		
		var po = document.getElementById('txtBuyerPO').value;
		xmlHttp[15].open("GET",'pl_plugin_search.php?po='+po,true);
		xmlHttp[15].send(null);
		
}

function setPL(obj)
{
	if(obj.checked)
	{
		var pl = obj.parentNode.parentNode.cells[1].innerHTML.trim();
		var po = obj.parentNode.parentNode.cells[3].innerHTML.trim();
		
		closeWindow();	
		
		//document.getElementById('txtPLno').value = pl;
		//document.getElementById('txtPLno').onchange();
		var url	 		=	"invoiceDbDetail.php?REQUEST=addSizePrice&plno="+pl+"&po="+po;
		var http_obj	=	$.ajax({url:url,async:false})
		
	var detailGrid=document.getElementById("tblDescriptionOfGood");	
	var invdtlno=http_obj.responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=http_obj.responseXML.getElementsByTagName('StyleID');
	var PL=http_obj.responseXML.getElementsByTagName('PL');
	var ItemNo=http_obj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=http_obj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=http_obj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=http_obj.responseXML.getElementsByTagName('Quantity');
	var UnitID=http_obj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=http_obj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=http_obj.responseXML.getElementsByTagName('lCMP');
	var Amount=http_obj.responseXML.getElementsByTagName('Amount');	
	var HSCode=http_obj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=http_obj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=http_obj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=http_obj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=http_obj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=http_obj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=http_obj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=http_obj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=http_obj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=http_obj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=http_obj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=http_obj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=http_obj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=http_obj.responseXML.getElementsByTagName('ISD');
	var Fabrication=http_obj.responseXML.getElementsByTagName('Fabrication');
	var Color=http_obj.responseXML.getElementsByTagName('Color');
	var CBM=http_obj.responseXML.getElementsByTagName('CBM');
	//alert(xmlHttp[4].responseText);
	//alert(invdtlno.length);
	
	
	
	var pos=detailGrid.rows.length-1;
		for(var loop=0;loop<StyleID.length;loop++)
		{	
		
		var existData=0;
	
			for(var t=1;t<detailGrid.rows.length;t++)
			{
				if((detailGrid.rows[t].cells[3].childNodes[0].nodeValue==PL[loop].childNodes[0].nodeValue) && (detailGrid.rows[t].cells[6].childNodes[0].nodeValue==Color[loop].childNodes[0].nodeValue))
				{
					existData=1;
					break;
				}
			}
		if(existData==0)
		{
			
			var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		//if(loop % 2 ==0)
					//row.className ="bcgcolor-tblrow mouseover";
				//else
					row.className ="bcgcolorred mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\"/>";	
				cellDelete.id=1;
				
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(StyleID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
		if(BuyerPONo[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}		
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PL[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(PL[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(DescOfGoods[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabrication[loop].childNodes[0].nodeValue);
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
		if(Fabrication[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
				
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =Color[loop].childNodes[0].nodeValue;
		if(Color[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
		if(UnitPrice[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}						
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;		
		if(PriceUnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		if(Quantity[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
		if(UnitID[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
		if(Amount[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
		if(GrossMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
		if(NetMass[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}					
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
		if(HSCode[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		if(NoOfCTns[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "n/a";
		}			
		var cellDelete = row.insertCell(16); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
		if(dblUMOnQty1[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(17); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
		if(dblUMOnQty2[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}					
		var cellDelete = row.insertCell(18); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		if(dblUMOnQty3[loop].childNodes[0].nodeValue=="")
		{
			rowCell.innerHTML = "0";
		}				
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = ISD[loop].childNodes[0].nodeValue;
		if(ISD[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "n/a";
		}
		var cellDelete = row.insertCell(20); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = CBM[loop].childNodes[0].nodeValue;
		if(CBM[loop].childNodes[0].nodeValue=="")
		{
			cellDelete.innerHTML = "0";
		}
		
		}
		}
	}
}

function closeCross()
{
	//hideBackGroundBalck();
	//closeLayerByName("frmNewOrganize");
	closeWindow();	
		//closeWindow();
}

function InsertDetail()
{
	var tblData = document.getElementById("tblDescriptionOfGood");
	var invoiceno   = document.getElementById("txtInvoiceDetail").value;
	
	for(var i=1;i<tblData.rows.length;i++)
	{
		if(tblData.rows[i].cells[0].id==1)
		{
			alert("Enter 'HS Code' for red color rows !");
			return false;
		}
	}
	
	var url1	 		=	'invoiceDbDetail.php?REQUEST=delData&invoiceno='+invoiceno;
	$.ajax({url:url1,async:false});
	
	for(var x=1;x<tblData.rows.length;x++)
	{	
		var chkVal=$('#GSP_app').is(':checked');
		
	  if(chkVal)
	  	var chkGsp=1;
	  else
	  	var chkGsp=0;
	
	//alert(URLEncode(tblData.rows[x].cells[8].childNodes[0].nodeValue));
	//alert("yg");
		var url	 		=	'invoiceDbDetail.php?REQUEST=saveData&invoiceno='+invoiceno;
			
			var desc			= URLEncode(tblData.rows[x].cells[5].childNodes[0].nodeValue);
			var style			= URLEncode(tblData.rows[x].cells[2].childNodes[0].nodeValue);
			var unit1			= URLEncode(tblData.rows[x].cells[9].childNodes[0].nodeValue);
			var unitprice		= URLEncode(tblData.rows[x].cells[8].childNodes[0].nodeValue);
			var gross			= URLEncode(tblData.rows[x].cells[12].childNodes[0].nodeValue);
			var ctns			= URLEncode(tblData.rows[x].cells[16].childNodes[0].nodeValue);
			var net				= URLEncode(tblData.rows[x].cells[13].childNodes[0].nodeValue);
			var bpo				= URLEncode(tblData.rows[x].cells[3].childNodes[0].nodeValue);
			var unitqty			= URLEncode(tblData.rows[x].cells[11].childNodes[0].nodeValue);
			var qty				= URLEncode(tblData.rows[x].cells[10].childNodes[0].nodeValue);		
			var hs				= URLEncode(tblData.rows[x].cells[15].childNodes[0].nodeValue);
			var category		= URLEncode(tblData.rows[x].cells[2].id);
			var procedurecode	= URLEncode(tblData.rows[x].cells[5].id);
			var umoqty1			= URLEncode(tblData.rows[x].cells[17].childNodes[0].nodeValue);
			var umoqty2			= URLEncode(tblData.rows[x].cells[18].childNodes[0].nodeValue);
			var umoqty3			= URLEncode(tblData.rows[x].cells[19].childNodes[0].nodeValue);
			var val				= URLEncode(calValue(unitprice,unit1,qty,unitqty,1));
			var umoUnit1		= URLEncode(tblData.rows[x].cells[16].id);
			var umoUnit2		= URLEncode(tblData.rows[x].cells[17].id);
			var umoUnit3		= URLEncode(tblData.rows[x].cells[18].id);
			var ISDNo			= URLEncode(tblData.rows[x].cells[19].childNodes[0].nodeValue);
			var fabrication		= URLEncode(tblData.rows[x].cells[6].childNodes[0].nodeValue);
			var PL				= URLEncode(tblData.rows[x].cells[4].childNodes[0].nodeValue);
			var Color			= URLEncode(tblData.rows[x].cells[6].childNodes[0].nodeValue);
			
			var CBM			    = URLEncode(tblData.rows[x].cells[21].childNodes[0].nodeValue);
			var SeNo		    = URLEncode(tblData.rows[x].cells[1].childNodes[0].nodeValue);
			
			url+='&dsc='+desc+ '&style='+style+'&value='+val+ '&unit=' +unit1+ '&unitprice='+unitprice;
			url+='&gross=' +gross+ '&ctns=' +ctns+  '&net=' +net+'&bpo=' +bpo+ '&unitqty=' +unitqty;
			url+='&procedurecode=' +procedurecode+'&hs=' +hs;
			url+='&qty=' +qty+ '&category=' +category+ '&umoqty1='+umoqty1+ '&umoqty2='+umoqty2+'&umoqty3='+umoqty3;
			url+='&PL='+PL+ '&umoUnit1='+umoUnit1+ '&umoUnit2='+umoUnit2+ '&umoUnit3='+umoUnit3+ '&ISDNo='+ISDNo;
			url+='&fabrication='+fabrication+'&Color='+Color+'&cbm='+CBM+'&chkGsp='+chkGsp+'&SeNo='+SeNo;
		

		var http_obj	=	$.ajax({url:url,async:false});
		
	}
	
	alert("Data Saved Successfully !");
}
















function Loadshippingnote()
{	
		window.open("../../ShippingNotes/shippingnotes.php?InvoiceNo=" + URLEncode(document.getElementById("cboInvoiceNo").value),'ship_note');
		//window.open("shippingnotes.php");
		//alert (hi);
}
