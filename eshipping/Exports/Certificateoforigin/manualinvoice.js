var item=0;
var verpos=0;
var position=0;
function getInvoiceDetail()
{
	document.getElementById("txtInvoiceDetail").value=document.getElementById("cboInvoice").value;
	if(document.getElementById("txtInvoiceDetail").value!="")
	{
		if (document.getElementById("cboInvoice").value=="")
						saveData();	
		var invoiceno=document.getElementById("txtInvoiceDetail").value; 
		generateRequest(4);
		xmlHTTP[4].onreadystatechange=addToDetailGrid;
		xmlHTTP[4].open("GET",'invoiceDbDetail.php?REQUEST=getDetailData&invoiceno=' + invoiceno,true);
		xmlHTTP[4].send(null);
	}
	else
	{
	alert("Please select an invoice number.");
	
	//addToDetailGrid();
	
	}
}
/*
tblDescriptionOfGood
*/


function addToDetailGrid()
{

if(xmlHTTP[4].readyState==4 && xmlHTTP[4].status==200)
	{
		cleardata();
	deleterows("tblDescriptionOfGood");
	var detailGrid=document.getElementById("tblDescriptionOfGood");
	//alert(detailGrid.rows.length);
	var invdtlno=xmlHTTP[4].responseXML.getElementsByTagName('InvoiceNo');
	var StyleID=xmlHTTP[4].responseXML.getElementsByTagName('StyleID');
	var ItemNo=xmlHTTP[4].responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=xmlHTTP[4].responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=xmlHTTP[4].responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=xmlHTTP[4].responseXML.getElementsByTagName('Quantity');
	var UnitID=xmlHTTP[4].responseXML.getElementsByTagName('UnitID');
	var UnitPrice=xmlHTTP[4].responseXML.getElementsByTagName('UnitPrice');
	var lCMP=xmlHTTP[4].responseXML.getElementsByTagName('lCMP');
	var Amount=xmlHTTP[4].responseXML.getElementsByTagName('Amount');	
	var HSCode=xmlHTTP[4].responseXML.getElementsByTagName('HSCode');
	var GrossMass=xmlHTTP[4].responseXML.getElementsByTagName('GrossMass');
	var NetMass=xmlHTTP[4].responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=xmlHTTP[4].responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=xmlHTTP[4].responseXML.getElementsByTagName('NoOfCTns');
	var Category=xmlHTTP[4].responseXML.getElementsByTagName('Category');
	var ProcedureCode=xmlHTTP[4].responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=xmlHTTP[4].responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=xmlHTTP[4].responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=xmlHTTP[4].responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=xmlHTTP[4].responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=xmlHTTP[4].responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=xmlHTTP[4].responseXML.getElementsByTagName('UMOQtyUnit3');
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
				cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =pos;
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
					
				
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =StyleID[loop].childNodes[0].nodeValue;
				rowCell.id=Category[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;
				rowCell.id=ProcedureCode[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitPrice[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =PriceUnitID[loop].childNodes[0].nodeValue;
		
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =lCMP[loop].childNodes[0].nodeValue;
	
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Quantity[loop].childNodes[0].nodeValue;
		
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =UnitID[loop].childNodes[0].nodeValue;		
				
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =Amount[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =GrossMass[loop].childNodes[0].nodeValue;				
				
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NetMass[loop].childNodes[0].nodeValue;
				
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =HSCode[loop].childNodes[0].nodeValue;	
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =NoOfCTns[loop].childNodes[0].nodeValue;
				rowCell.id=ItemNo[loop].childNodes[0].nodeValue;
		item=ItemNo[loop].childNodes[0].nodeValue;
		
		var cellDelete = row.insertCell(14); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty1[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit1[loop].childNodes[0].nodeValue;
				
		var cellDelete = row.insertCell(15); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty2[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit2[loop].childNodes[0].nodeValue;
				
		var cellDelete = row.insertCell(16); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = dblUMOnQty3[loop].childNodes[0].nodeValue;;
				cellDelete.id=dblUMOnUnit3[loop].childNodes[0].nodeValue;
		}
	//alert (item);
	}
	
	//rowupdater();

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


function editItems()
{
newDettail();
document.getElementById('txtStyle').value=this.cells[2].childNodes[0].nodeValue;
document.getElementById('txtProcedureCode').value=this.cells[3].id;
document.getElementById('txtareaDisc').value=this.cells[3].childNodes[0].nodeValue;
document.getElementById('txtUnit').value=this.cells[5].childNodes[0].nodeValue;
document.getElementById('txtUnitPrice').value=this.cells[4].childNodes[0].nodeValue;
document.getElementById('txtGross').value=this.cells[10].childNodes[0].nodeValue;
document.getElementById('txtCtns').value=this.cells[13].childNodes[0].nodeValue;
document.getElementById('txtNet').value=this.cells[11].childNodes[0].nodeValue;
document.getElementById('txtBuyerPO').value=this.cells[1].id;
document.getElementById('txtHS').value=this.cells[12].childNodes[0].nodeValue;
document.getElementById('txtQty').value=this.cells[7].childNodes[0].nodeValue;
document.getElementById('txtQtyUnit').value=this.cells[8].childNodes[0].nodeValue;
document.getElementById('txtCM').value=this.cells[6].childNodes[0].nodeValue;
document.getElementById('txtValue').value=this.cells[9].childNodes[0].nodeValue;
document.getElementById('cboCategory').value=this.cells[2].id;
document.getElementById('txtUmoQty1').value=this.cells[14].childNodes[0].nodeValue;
document.getElementById('txtUmoQty2').value=this.cells[15].childNodes[0].nodeValue;
document.getElementById('txtUmoQty3').value=this.cells[16].childNodes[0].nodeValue;
document.getElementById('cboUmoQty1').value=this.cells[14].id;
document.getElementById('cboUmoQty2').value=this.cells[15].id;
document.getElementById('cboUmoQty3').value=this.cells[16].id;
position=this.cells[13].id;
verpos=this.cells[1].childNodes[0].nodeValue;
//alert(position);
}


function addToGrid()
{
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
			var unit=document.getElementById('txtUnit').value;
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
			var value=calValue(unitprice,unit,qty,unitqty,cm);
			var procedurecode=document.getElementById('txtProcedureCode').value;
			var umoUnit1=document.getElementById('cboUmoQty1').value;
			var umoUnit2=document.getElementById('cboUmoQty2').value;
			var umoUnit3=document.getElementById('cboUmoQty3').value;
		if (position!=0)
			{	
				verprepos=verpos;
				prevpos=position;
					
			editgrid.rows[verprepos].cells[3].childNodes[0].nodeValue=document.getElementById('txtareaDisc').value;
			editgrid.rows[verprepos].cells[2].childNodes[0].nodeValue=document.getElementById('txtStyle').value;
			editgrid.rows[verprepos].cells[2].id=category;
			editgrid.rows[verprepos].cells[9].childNodes[0].nodeValue=value;
			editgrid.rows[verprepos].cells[5].childNodes[0].nodeValue=document.getElementById('txtUnit').value;
			editgrid.rows[verprepos].cells[4].childNodes[0].nodeValue=document.getElementById('txtUnitPrice').value;
			editgrid.rows[verprepos].cells[10].childNodes[0].nodeValue=document.getElementById('txtGross').value;
			editgrid.rows[verprepos].cells[13].childNodes[0].nodeValue=document.getElementById('txtCtns').value;
			editgrid.rows[verprepos].cells[11].childNodes[0].nodeValue=document.getElementById('txtNet').value;
			editgrid.rows[verprepos].cells[1].id=document.getElementById('txtBuyerPO').value;
			editgrid.rows[verprepos].cells[8].childNodes[0].nodeValue=document.getElementById('txtQtyUnit').value;
			editgrid.rows[verprepos].cells[6].childNodes[0].nodeValue=document.getElementById('txtCM').value;
			editgrid.rows[verprepos].cells[7].childNodes[0].nodeValue=document.getElementById('txtQty').value;
			editgrid.rows[verprepos].cells[12].childNodes[0].nodeValue=document.getElementById('txtHS').value;
			editgrid.rows[verprepos].cells[3].id=procedurecode;
			editgrid.rows[verprepos].cells[13].id=prevpos;
						position=0;
			verpos=0;
			editInvoiceDtlDb('update',prevpos,value);	
			
			}
		else 
			{	
			
			item++;
			prevpos=item++;	
			
			/*
			alert(prevpos);
			
			var newrow=editgrid.insertRow(prevpos);
			
			if(prevpos % 2 ==1)
					newrow.className ="bcgcolor-tblrow mouseover";
				else
					newrow.className ="bcgcolor-tblrowWhite mouseover";
					newrow.onclick=rowclickColorChangeIou;
					newrow.ondblclick=editItems;
					
		var newcell = newrow.insertCell(0); 
				newcell.className ="normalfntMid";	
				newcell.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";				
					
		var newcell=newrow.insertCell(1)
				newcell.className="normalfntMid";
				newcell.innerHTML=prevpos;
				newcell.id=bpo;
					
		var newcell = newrow.insertCell(2);
				newcell.className ="normalfnt";			
				newcell.innerHTML =style;
				newcell.id=category;				
								
		var newcell = newrow.insertCell(3);
				newcell.className ="normalfnt";			
				newcell.innerHTML =dsc;
				newcell.id=procedurecode;
				
		var newcell = newrow.insertCell(4);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =unitprice;
				
		var newcell = newrow.insertCell(5);
				newcell.className ="normalfntMid";			
				newcell.innerHTML =unit;
		
		var newcell = newrow.insertCell(6);
				newcell.className ="normalfntMid";			
				newcell.innerHTML =cm;
	
		var newcell = newrow.insertCell(7);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =qty;
		
		var newcell = newrow.insertCell(8);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =unitqty;		
				
		var newcell = newrow.insertCell(9);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =value;
				
		var newcell = newrow.insertCell(10);
				newcell.className ="normalfntRite";			
			newcell.innerHTML =gross;				
				
		var newcell = newrow.insertCell(11);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =net;
				
		var newcell = newrow.insertCell(12);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =hs;
				
		var newcell = newrow.insertCell(13);
				newcell.className ="normalfntRite";			
				newcell.innerHTML =ctns;	
			*/
			
			editInvoiceDtlDb('insert',prevpos,value);					
			item++;		
			}
		
		}
		else
		alert("Procedure code format should be like 0000.000");
	}
	}
//alert(prevpos+ " "+position);

}

function editInvoiceDtlDb(wut,pos,value)
{			//alert(pos);
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
			//var value=100;
			//var value=calValue(unitprice,unit,qty,unitqty,cm); 
	generateRequest(5);
	
	xmlHTTP[5].onreadystatechange=function()
	{
	if(xmlHTTP[5].readyState==4 && xmlHTTP[5].status==200)
	{
	alert(xmlHTTP[5].responseText);	
	cleardata();
	getInvoiceDetail() ;
	//alert(item);
	
	}
	}
	xmlHTTP[5].open("GET",'invoiceDbDetail.php?REQUEST=editData&invoiceno=' + invoiceno+ '&dsc='+desc+ '&style='+style+
	'&value='+val+ '&unit=' +unit+ '&unitprice='+unitprice+ '&gross=' +gross+ '&ctns=' +ctns+  '&net=' +net+ 
	'&bpo=' +bpo+ '&unitqty=' +unitqty+ '&cm=' +cm+ '&procedurecode=' +procedurecode+'&hs=' +hs+ '&wut=' +wut + '&pos=' +pos + 
	'&qty=' +qty+ '&category=' +category+ '&umoqty1='+umoqty1+ '&umoqty2='+umoqty2+ '&umoqty3='+umoqty3
	+ '&umoUnit1='+umoUnit1+ '&umoUnit2='+umoUnit2+ '&umoUnit3='+umoUnit3,true);
	xmlHTTP[5].send(null);
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
	var item=cell.parentNode.parentNode.childNodes[13].id;
	var invoiceno=document.getElementById("txtInvoiceDetail").value;
	var tbl = document.getElementById('tblDescriptionOfGood');
	//alert (cell.parentNode.parentNode.rowIndex);	
		
	if (confirm("Are you sure you want to delete?" ))
	{
	tbl.deleteRow(cell.parentNode.parentNode.rowIndex);
	createNewXMLHttpRequest(6);
	xmlHttp[6].onreadystatechange=function()
	{
	if(xmlHTTP[6].readyState==4 && xmlHTTP[6].status==200)
	{	//positionupdater();
		//rowupdater();
		//alert(xmlHttp[6].responseText);
		getInvoiceDetail();
	}	
		
	}
	xmlHttp[6].open("GET",'invoiceDbDetail.php?REQUEST=deleteData&invoiceno=' + invoiceno + '&item=' +item  ,true);
	xmlHttp[6].send(null);
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
		var final=parseFloat(actp*aqty);
		var formatnum=RoundNumbers(final,2);
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
		window.open("../../../Reports/rptCommercialInvoice.php?InvoiceNo=" + document.getElementById("txtInvoiceNo").value);
/*
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=getIOUdetail;
	xmlHttp[2].open("GET",'ioudb.php?REQUEST=ioudetail&deliveryno=' + deliveryno,true);
	xmlHttp[2].send(null);		
	alert("priented sucessfully");
	*/
	
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
	document.getElementById('txtProcedureCode').value="0000.000";
	document.getElementById('cboCategory').value="";
	document.getElementById('txtValue').value="";
	document.getElementById('txtStyle').value="";
	document.getElementById('txtUmoQty1').value="";
	document.getElementById('txtUmoQty2').value="";
	document.getElementById('txtUmoQty3').value="";
	document.getElementById('cboUmoQty1').value="";
	document.getElementById('cboUmoQty2').value="";
	document.getElementById('cboUmoQty3').value="";

}

function setGenDesc()
{
		alert("pass");
	document.getElementById('txtareaDisc').value="";
	
}