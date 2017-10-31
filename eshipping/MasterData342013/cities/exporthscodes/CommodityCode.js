var  xmlHttp=[];
var changedposition=0;


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

function rowclickColorChangeIou()
{	
	var rowIndex = this.rowIndex;
	
	
	var tbl = document.getElementById('tblCommodityCode');
	
	
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



function setbydelivery(cbo)
{	
	deleterows('tblCommodityCode');
	document.getElementById('txtRemarks').value= "";
			document.getElementById('txtCommodity').value="";
	if(cbo!="")	
	{	
	
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=function()
		{
		if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
		{	
			//alert(xmlHttp[0].responseText);
			var TaxCode	= xmlHttp[0].responseXML.getElementsByTagName('TaxCode');
			var Percentage 	= xmlHttp[0].responseXML.getElementsByTagName('Percentage');
			var Remarks		= xmlHttp[0].responseXML.getElementsByTagName('Remarks');
			var MP		= xmlHttp[0].responseXML.getElementsByTagName('MP');
			var intPosition		= xmlHttp[0].responseXML.getElementsByTagName('intPosition');
			var TaxBase		= xmlHttp[0].responseXML.getElementsByTagName('TaxBase');
			var tbl			= document.getElementById('tblCommodityCode');
			var CommodityCode		= xmlHttp[0].responseXML.getElementsByTagName('CommodityCode');
			var OptRates		= xmlHttp[0].responseXML.getElementsByTagName('OptRates');	
			var no	=1;
			var pos=0;
			var cnt=0;
			
			document.getElementById('txtRemarks').value= Remarks[0].childNodes[0].nodeValue;
			document.getElementById('txtCommodity').value= CommodityCode[0].childNodes[0].nodeValue;
			
			
			for( var loop=0;loop<TaxCode.length;loop++)
			{
				if(TaxCode[loop].childNodes[0].nodeValue!=""){
				var lastRow 		= tbl.rows.length;	
				var row 			= tbl.insertRow(lastRow);
				//row.ondblclick = function (){alert("pass");}
				
				pos++;
				
				if(cnt% 2 ==0)
					row.className ="bcgcolor-tblrow";
				else
					row.className ="bcgcolor-tblrowWhite";			
				if (TaxCode[loop].childNodes[0].nodeValue!="")
					cnt++;
				row.onclick	= rowclickColorChangeIou;
				
				var rowCell = row.insertCell(0);
				rowCell.className ="normalfntMid";
				rowCell.className ="mouseover";		
				rowCell.innerHTML ="<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" />";
				rowCell.onclick=deleteTax;						
				
				
				var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";	
				rowCell.className ="mouseover";			
				rowCell.innerHTML ="<img src=\"../../images/edit.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" />";
				rowCell.onclick=edit			
				
				var rowCell = row.insertCell(2);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =pos;
				
				
				var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =TaxCode[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";	
				rowCell.innerHTML =Percentage[loop].childNodes[0].nodeValue;
				
				var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";	
				rowCell.innerHTML =MP[loop].childNodes[0].nodeValue;
				
				
				var rowCell = row.insertCell(6);
				rowCell.className="normalfntMid";
				rowCell.innerHTML = "<a href=\"#\" STYLE=\"text-decoration:none\" title=\"Double click here to change.\" >" + TaxBase[loop].childNodes[0].nodeValue + "</a>";
				//rowCell.ondblclick=edit;
				rowCell.className='mouseover';
				//rowCell.alt="doubleclick to edit";
						
				var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";	
				rowCell.innerHTML =OptRates[loop].childNodes[0].nodeValue;
				}
				}

		
		
		
		}
		}
	xmlHttp[0].open("GET",'commodityCodesDB.php?REQUEST=getData&commoditycode=' + cbo,true);
	xmlHttp[0].send(null);
	}
	else
	{
		document.getElementById('txtRemarks').value= "";
		document.getElementById('txtCommodity').value= "";	
	deleterows('tblCommodityCode');	
	}	
}

function edit()
{
//	alert(this.childNodes[0].childNodes[0].nodeValue);
//	alert(this.parentNode.parentNode.childNodes[4].childNodes[2].childNodes[0].nodeValue);
		this.parentNode.childNodes[1].childNodes[0].nodeValue="changed"; 
		drawPopupArea(430,130,'rptconfirm');	
	document.getElementById("rptconfirm").innerHTML =document.getElementById('confirmReport').innerHTML;
	document.getElementById('confirmReport').innerHTML="";	
	document.getElementById("txtTaxCode").value=this.parentNode.childNodes[3].childNodes[0].nodeValue;
	document.getElementById("txtMP").value=this.parentNode.childNodes[5].childNodes[0].nodeValue;
	document.getElementById("txtBase").value=this.parentNode.childNodes[6].childNodes[0].childNodes[0].nodeValue;
	document.getElementById("txtRate").value=this.parentNode.childNodes[4].childNodes[0].nodeValue;
	try{
	document.getElementById("txtRateOpt").value=this.parentNode.childNodes[7].childNodes[0].nodeValue;	
	}catch(exception){}
	changedposition=this.parentNode.childNodes[2].childNodes[0].nodeValue;	


}



function	deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	
	



function closePOP()
{
	document.getElementById('confirmReport').innerHTML = document.getElementById("rptconfirm").innerHTML;
	closeWindow();
}


function moveup()
{


		var tbl = document.getElementById('tblCommodityCode');
		var highlightedrowindex = 0;
		var previousrowindex = 0;
for ( var i = 0; i < tbl.rows.length; i ++)
	{
		
		if( tbl.rows[i].className =="bcgcolor-highlighted" && i>1)
				{	//alert("found");
					
				//this.parentNode.childNodes[rowIndex-1].
	
			
			var change=tbl.rows[i-1].innerHTML;
			var pos=tbl.rows[i-1].cells[2].childNodes[0].nodeValue;
			var new1=tbl.rows[i].cells[2].childNodes[0].nodeValue;
	
			//tbl.rows[rowIndex].cells[2].childNodes[0].nodeValue=tbl.rows[rowIndex-1].cells[2].childNodes[0].nodeValue;
			//tbl.rows[rowIndex-1].cells[2].childNodes[0].nodeValue=pos;
			//alert(pos);
			
			//tbl.rows[i-1].cells[2].childNodes[0].nodeValue=tbl.rows[i].cells[2].childNodes[0].nodeValue;
			//tbl.rows[i].cells[2].childNodes[0].nodeValue=pos;	
			//tbl.rows[i+1].onclick=function(){alert("changed");}
			tbl.rows[i-1].innerHTML=tbl.rows[i].innerHTML;	
			tbl.rows[i].innerHTML=change;		
			var otherclassname = tbl.rows[i-1].className;		
			highlightedrowindex = i -1;
			previousrowindex = i;
			tbl.rows[i-1].cells[2].childNodes[0].nodeValue=pos;
			tbl.rows[i].cells[2].childNodes[0].nodeValue=new1;	
				//alert(pos+ " "+ new1);
				
				}
		
	}
	var newclass= "bcgcolor-tblrowWhite";
	if(previousrowindex % 2 !=0)
					newclass ="bcgcolor-tblrow";

	tbl.rows[highlightedrowindex].className ="bcgcolor-highlighted";
	tbl.rows[previousrowindex].className =newclass;
	eventSetter()
}


function movedown()
{	


		var tbl = document.getElementById('tblCommodityCode');
		var highlightedrowindex = 0;
		var previousrowindex = 0;
for ( var i = 1; i < tbl.rows.length; i ++)
	{
		
		if( tbl.rows[i].className =="bcgcolor-highlighted" && i<tbl.rows.length-1)
				{	//alert("found");
					
				//this.parentNode.childNodes[rowIndex-1].
	
			
			var change=tbl.rows[i+1].innerHTML;
			var pos=tbl.rows[i+1].cells[2].childNodes[0].nodeValue;
			var new1=tbl.rows[i].cells[2].childNodes[0].nodeValue;
	
			//tbl.rows[rowIndex].cells[2].childNodes[0].nodeValue=tbl.rows[rowIndex-1].cells[2].childNodes[0].nodeValue;
			//tbl.rows[rowIndex-1].cells[2].childNodes[0].nodeValue=pos;
			//alert(pos);
			
			//tbl.rows[i-1].cells[2].childNodes[0].nodeValue=tbl.rows[i].cells[2].childNodes[0].nodeValue;
			//tbl.rows[i].cells[2].childNodes[0].nodeValue=pos;	
			//tbl.rows[i+1].onclick=function(){alert("changed");}
			tbl.rows[i+1].innerHTML=tbl.rows[i].innerHTML;	
			tbl.rows[i].innerHTML=change;		
			var otherclassname = tbl.rows[i+1].className;		
			highlightedrowindex = i +1;
			previousrowindex = i;
			tbl.rows[i+1].cells[2].childNodes[0].nodeValue=pos;
			tbl.rows[i].cells[2].childNodes[0].nodeValue=new1;	
				//alert(pos+ " "+ new1);
				
				}
		
	}
	var newclass= "bcgcolor-tblrowWhite";
	if(previousrowindex % 2 !=0)
					newclass ="bcgcolor-tblrow";

	tbl.rows[highlightedrowindex].className ="bcgcolor-highlighted";
	tbl.rows[previousrowindex].className =newclass;
	eventSetter();
}


function eventSetter()
{

	var tblcomm=document.getElementById('tblCommodityCode');
	var numrows=tblcomm.rows.length;
	for (var j=1;j<numrows;j++)
	{
	tblcomm.rows[j].cells[1].onclick=edit;
	tblcomm.rows[j].cells[0].onclick=deleteTax;
	}
	
}

function selecttax()
{
	if (document.getElementById('txtCommodity').value!="")
{
	drawPopupArea(170,270,'popselecttax');	
	document.getElementById("popselecttax").innerHTML =document.getElementById('divselecttax').innerHTML;
	document.getElementById('divselecttax').innerHTML="";	
	tbltax=document.getElementById('tblCommodityCode');
	undodisable();	
	for(var i=1;i<tbltax.rows.length;i++)
	{
		var tax=tbltax.rows[i].cells[3].childNodes[0].nodeValue;	
		document.getElementById(tax).checked=true;
		document.getElementById(tax).disabled=true;
	
	
	}
}
}


function frmReload()
{
//positionupdater()
setTimeout("location.reload(true);",100);

}

function closeTax()
{
	document.getElementById('divselecttax').innerHTML=document.getElementById("popselecttax").innerHTML;
	closeWindow(); 
}


function setTax()
{
	var tax="";
	if (document.getElementById('CID').checked==true && document.getElementById('CID').disabled==false )
	{
			tax="CID";
			setTaxToGrid(tax);
	}
	if (document.getElementById('EIC').checked==true && document.getElementById('EIC').disabled==false )
	{
			tax="EIC";
			setTaxToGrid(tax);
	}
	if (document.getElementById('GST').checked==true && document.getElementById('GST').disabled==false )
	{
			tax="GST";
			setTaxToGrid(tax);
	}
	if (document.getElementById('NBT').checked==true && document.getElementById('NBT').disabled==false )
	{
			tax="NBT";
			setTaxToGrid(tax);
	}
	if (document.getElementById('PAL').checked==true && document.getElementById('PAL').disabled==false )
	{
			tax="PAL";
			setTaxToGrid(tax);
	}
	if (document.getElementById('SLR').checked==true && document.getElementById('SLR').disabled==false )
	{
			tax="SLR";
			setTaxToGrid(tax);
	}
	if (document.getElementById('CESS').checked==true && document.getElementById('CESS').disabled==false )
	{
			tax="CESS";
			setTaxToGrid(tax);
	}
	if (document.getElementById('SUR').checked==true && document.getElementById('SUR').disabled==false )
	{
			tax="SUR";
			setTaxToGrid(tax);
	}
	if (document.getElementById('VAT').checked==true && document.getElementById('VAT').disabled==false )
	{
			tax="VAT";
			setTaxToGrid(tax);
	}
	
		closeTax();
//alert(tax);

}

function undodisable()
{

document.getElementById('CID').disabled=false;
document.getElementById('EIC').disabled=false;
document.getElementById('GST').disabled=false;
document.getElementById('NBT').disabled=false;
document.getElementById('PAL').disabled=false;
document.getElementById('SLR').disabled=false;
document.getElementById('CESS').disabled=false;
document.getElementById('SUR').disabled=false;
document.getElementById('VAT').disabled=false;



}

//function newTax()
function setTaxToGrid(TT)
{
//alert(TT);
var taxgrid=document.getElementById('tblCommodityCode');
var gridend=taxgrid.rows.length;
var rowgrid=taxgrid.insertRow(gridend);
//alert(gridend);
if(gridend % 2 ==1)
					rowgrid.className ="bcgcolor-tblrow";
				else
					rowgrid.className ="bcgcolor-tblrowWhite";			

rowgrid.onclick	= rowclickColorChangeIou;

				
var gridcell = rowgrid.insertCell(0);
gridcell.className="mouseover";
gridcell.innerHTML="<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" />";

var gridcell = rowgrid.insertCell(1);
gridcell.className="mouseover";
gridcell.innerHTML="<img src=\"../../images/edit.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" />";

var gridcell = rowgrid.insertCell(2);
gridcell.className="normalfntMid";
gridcell.innerHTML=gridend;

var gridcell = rowgrid.insertCell(3);
gridcell.className="normalfntMid";
gridcell.innerHTML=TT;

var gridcell = rowgrid.insertCell(4);
gridcell.className="normalfntMid";
gridcell.innerHTML=0;

var gridcell = rowgrid.insertCell(5);
gridcell.className="normalfntMid";
gridcell.innerHTML=0;

var gridcell = rowgrid.insertCell(6);
gridcell.innerHTML="<a href=\"#\" STYLE=\"text-decoration:none\" title=\"Double click here to change.\" >NotSet</a>";

var gridcell = rowgrid.insertCell(7);
gridcell.className="normalfntMid";
gridcell.innerHTML=0;

eventSetter();
}



function editcommoditydb()
{

//alert(changedposition);
var commoditycode=document.getElementById('txtCommodity').value;
var remarks=document.getElementById('txtRemarks').value;
var taxcode=document.getElementById('txtTaxCode').value;
var rates=document.getElementById('txtRate').value;
var MP=document.getElementById('txtMP').value;
var txtRateOpt=document.getElementById('txtRateOpt').value;
var taxbase=document.getElementById('txtBase').value;
if(checkcommodityform(rates,taxbase))
	{
	gridpositionset();
	checkcommoditydb(commoditycode,taxcode);

	}
} 



function checkcommodityform(rate,base)
{
//alert(rate+ " "+base );
	if (rate==0)
	{
	alert("Please set rates.");
	document.getElementById('txtRate').focus();
	return false;
	}	
	else if (base==""){
	alert ("please select a tax base.");
	return false;
	}
	else 
	{
	return true;
	}
}

function checkcommoditydb(commoditycode,taxcode)
{

createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
	var response=xmlHttp[1].responseText;
	if (response=='update')
		dbupdate();
	if (response=='insert')	
		dbinsert();
	}	
		
	}
	xmlHttp[1].open("GET",'commodityCodesDB.php?REQUEST=checkdb&commoditycode=' + commoditycode+ '&tax=' + URLEncode(taxcode),true);
	xmlHttp[1].send(null);

}



function dbupdate()
{
//alert("editdb");
var commoditycode=document.getElementById('txtCommodity').value;
var taxcode=document.getElementById('txtTaxCode').value;
var rates=document.getElementById('txtRate').value;
var MP=document.getElementById('txtMP').value;
var taxbase=document.getElementById('txtBase').value;
var txtRateOpt=document.getElementById('txtRateOpt').value;

createNewXMLHttpRequest(3);
	xmlHttp[3].onreadystatechange=function()
	{
	if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
	{
		//alert(xmlHttp[3].responseText);
		positionupdater();
			closePOP();
	}	
		
	}
	xmlHttp[3].open("GET",'commodityCodesDB.php?REQUEST=update&commoditycode=' + commoditycode+ '&tax=' + URLEncode(taxcode)+ '&MP=' +MP+ '&rates=' +rates+ '&taxbase=' +URLEncode(taxbase)+ '&position=' +changedposition+ '&txtRateOpt=' +URLEncode(txtRateOpt),true);
	xmlHttp[3].send(null);

}



function dbinsert()
{
var remarks=document.getElementById('txtRemarks').value;
var commoditycode=document.getElementById('txtCommodity').value;
var taxcode=document.getElementById('txtTaxCode').value;
var rates=document.getElementById('txtRate').value;
var MP=document.getElementById('txtMP').value;
var taxbase=document.getElementById('txtBase').value;
var txtRateOpt=document.getElementById('txtRateOpt').value;

createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=function()
	{
	if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
	{
			//alert(xmlHttp[2].responseText);
			positionupdater();
			closePOP();
	}	
		
	}
	xmlHttp[2].open("GET",'commodityCodesDB.php?REQUEST=insert&commoditycode=' + commoditycode+ '&tax=' + taxcode+ '&MP=' +MP+ '&rates=' +rates+ '&taxbase=' +taxbase+ '&position=' +changedposition+ '&remarks=' +remarks+ '&txtRateOpt=' +txtRateOpt,true);
	xmlHttp[2].send(null);

}


function positionupdater()
{	var code=document.getElementById('txtCommodity').value;
	var tblcommdity=document.getElementById('tblCommodityCode');
	var count=0; var tax="";
	for(var loop=1; loop<tblcommdity.rows.length; loop++)	
	{
	
		if(tblcommdity.rows[loop].cells[4].childNodes[0].nodeValue!=0)
		{	
			count++
			tax=tblcommdity.rows[loop].cells[3].childNodes[0].nodeValue;
			//alert(count +" "+tax);
			updateposition(code,tax,count)
		}
	}

}


function gridpositionset()
{
var gridset=document.getElementById('tblCommodityCode');
	var count=0; var tax="";
	for(var loop=1; loop<gridset.rows.length; loop++)	
	{
	
		if(gridset.rows[loop].cells[3].childNodes[0].nodeValue==document.getElementById("txtTaxCode").value)
		{	
			gridset.rows[loop].cells[4].childNodes[0].nodeValue=document.getElementById("txtRate").value;
			gridset.rows[loop].cells[6].childNodes[0].childNodes[0].nodeValue=document.getElementById("txtBase").value;
			
			gridset.rows[loop].cells[5].childNodes[0].nodeValue=document.getElementById("txtMP").value;
			try{
			gridset.rows[loop].cells[7].childNodes[0].nodeValue=document.getElementById("txtRateOpt").value;
			}catch(exception){}
		
		}
		
	}

}

function updateposition(code,tax,pos)
{
createNewXMLHttpRequest(4);
	xmlHttp[4].onreadystatechange=function()
	{
	if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
		//alert(xmlHttp[4].responseText);
		
	}	
		
	}
	xmlHttp[4].open("GET",'commodityCodesDB.php?REQUEST=position&commoditycode=' + code+ '&tax=' + URLEncode(tax)+ '&position=' +pos,true);
	xmlHttp[4].send(null);

}

function deleteTax()
{
var code=document.getElementById('txtCommodity').value;
try{
var tax=this.parentNode.childNodes[3].childNodes[0].nodeValue;
}catch(exception)
{}
if (confirm("Are you sure you want to delete\n" +code+" "+tax+"?" ))
{createNewXMLHttpRequest(5);
	xmlHttp[5].onreadystatechange=function()
	{
	if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
	{	//positionupdater();
		//alert(xmlHttp[5].responseText);
		setbydelivery(document.getElementById('txtCommodity').value);
	}	
		
	}
	xmlHttp[5].open("GET",'commodityCodesDB.php?REQUEST=delete&commoditycode=' + code+ '&tax=' + tax,true);
	xmlHttp[5].send(null);
	}


}


function savedata()
{	
if (document.getElementById("cboComodity").value=="")
	{
		saveHSheader();
	}
	else
	{
		positionupdater();
		alert ("Successfully saved.");
	}
}


function deletedata()
{
var code=document.getElementById('txtCommodity').value

if (confirm("Are you sure you want to delete\n" +code+"?" ))
{createNewXMLHttpRequest(6);
	xmlHttp[6].onreadystatechange=function()
	{
	if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
	{	//positionupdater();
		alert(xmlHttp[6].responseText);
		setTimeout("location.reload(true)",100);
	}	
		
	}
	xmlHttp[6].open("GET",'commodityCodesDB.php?REQUEST=deletecommodity&commoditycode=' + code,true);
	xmlHttp[6].send(null);
	}
}

function saveHSheader()
{
var remarks=document.getElementById('txtRemarks').value;
var commoditycode=document.getElementById('txtCommodity').value;

createNewXMLHttpRequest(10);
	xmlHttp[10].onreadystatechange=function()
	{
	if(xmlHttp[10].readyState==4 && xmlHttp[10].status==200)
	{
			alert(xmlHttp[10].responseText);
			setTimeout("location.reload(true)",100);
			
	}	
		
	}
	xmlHttp[10].open("GET",'commodityCodesDB.php?REQUEST=insertHeader&commoditycode=' + commoditycode+'&remarks=' +remarks,true);
	xmlHttp[10].send(null);	
	
	}